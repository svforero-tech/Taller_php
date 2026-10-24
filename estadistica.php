
<?php
require_once __DIR__ . '/clases/Estadistica.php';
require_once __DIR__ . '/clases/helpers.php';

$titulo = 'Promedio, mediana y moda';

// Obtiene la cantidad de números ingresada y comprueba que sea un entero.
$cantidad = filter_var(
    $_POST['cantidad'] ?? $_GET['cantidad'] ?? '',
    FILTER_VALIDATE_INT
);

// Guarda los números enviados por el formulario.
$valores = $_POST['numeros'] ?? [];

// Variables para los mensajes de error y los resultados.
$error = '';
$stats = null;

// Comprueba que la cantidad sea por lo menos uno.
if ($cantidad !== false && $cantidad < 1) {
    $error = 'Debes ingresar al menos un número.';
    $cantidad = false;
}

// Comprueba si se envió el formulario con los números.
if (
    $cantidad !== false &&
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['numeros'])
) {
    try {
        // Arreglo donde se guardarán los números válidos.
        $numeros = [];

        // Recorre los números ingresados, hasta la cantidad indicada.
        foreach (array_slice($valores, 0, $cantidad) as $valor) {
            $numeros[] = Estadistica::parsearNumero($valor);
        }

        // Crea el objeto que permite calcular las estadísticas.
        $stats = new Estadistica($numeros);

    } catch (InvalidArgumentException $ex) {
        // Muestra el mensaje si algún dato no es válido.
        $error = $ex->getMessage();
    }
}

// Carga el encabezado de la página.
require __DIR__ . '/includes/header.php';
?>

<!-- Formulario para indicar cuántos números se van a ingresar. -->
<form method="get" class="panel">
    <label>¿Cuántos números vas a ingresar?
        <input
            type="number"
            name="cantidad"
            min="1"
            value="<?= $cantidad !== false ? (int) $cantidad : '' ?>"
            required
        >
    </label>

    <button type="submit">Continuar</button>
</form>

<!-- Muestra un error si existe. -->
<?php if ($error !== ''): ?>
    <p class="error"><?= e($error) ?></p>
<?php endif; ?>

<!-- Crea los campos necesarios según la cantidad elegida. -->
<?php if ($cantidad !== false): ?>
    <form method="post" class="panel">

        <!-- Conserva la cantidad seleccionada al enviar el formulario. -->
        <input type="hidden" name="cantidad" value="<?= (int) $cantidad ?>">

        <div class="campos">
            <?php for ($i = 0; $i < $cantidad; $i++): ?>
                <label>Número <?= $i + 1 ?>
                    <input
                        type="text"
                        name="numeros[]"
                        value="<?= e((string) ($valores[$i] ?? '')) ?>"
                        required
                    >
                </label>
            <?php endfor; ?>
        </div>

        <!-- Envía los números para calcular los resultados. -->
        <button type="submit">Calcular</button>
    </form>
<?php endif; ?>

<!-- Muestra las estadísticas si se calcularon correctamente. -->
<?php if ($stats !== null): ?>
    <div class="resultado">

        <!-- Calcula y muestra el promedio de los números. -->
        <p>
            <span class="etiqueta">Promedio</span>
            <strong><?= e(formatear($stats->promedio())) ?></strong>
        </p>

        <!-- Calcula y muestra el valor central de los números ordenados. -->
        <p>
            <span class="etiqueta">Mediana</span>
            <strong><?= e(formatear($stats->mediana())) ?></strong>
        </p>

        <!-- Calcula y muestra el número o los números más repetidos. -->
        <p>
            <span class="etiqueta">Moda</span>
            <strong>
                <?php
                // Obtiene la moda.
                $moda = $stats->moda();

                // Si ningún número se repite, indica que no hay moda.
                if ($moda === []) {
                    echo 'No hay moda';
                } else {
                    // Une las modas encontradas y las muestra separadas por comas.
                    echo e(implode(', ', array_map('formatear', $moda)));
                }
                ?>
            </strong>
        </p>
    </div>
<?php endif; ?>

<!-- Carga el pie de página. -->
<?php require __DIR__ . '/includes/footer.php'; ?>
