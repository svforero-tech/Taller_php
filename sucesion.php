
<?php
require_once __DIR__ . '/clases/Sucesion.php';
require_once __DIR__ . '/clases/helpers.php';

$titulo = 'Sucesión de Fibonacci o factorial';

// Obtiene los datos enviados y selecciona Fibonacci por defecto.
$numero = $_POST['numero'] ?? '';
$operacion = $_POST['operacion'] ?? 'fibonacci';

// Variables para guardar la serie y los posibles errores.
$serie = null;
$error = '';

// Comprueba si se envió el formulario.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Comprueba que el número ingresado sea un entero válido.
    $n = filter_var(trim((string) $numero), FILTER_VALIDATE_INT);

    // Rechaza los valores que no sean enteros válidos o sean negativos.
    if ($n === false || $n < 0) {
        $error = 'Ingresa un número entero mayor o igual a 0.';

    // Genera la sucesión de Fibonacci.
    } elseif ($operacion === 'fibonacci') {
        $serie = Sucesion::fibonacci($n);

    // Genera la serie de factoriales.
    } elseif ($operacion === 'factorial') {
        $serie = Sucesion::factorial($n);

    // Muestra un error si la operación no es válida.
    } else {
        $error = 'Selecciona una operación válida.';
    }
}

// Carga el encabezado de la página.
require __DIR__ . '/includes/header.php';
?>

<!-- Formulario para ingresar el número y elegir la operación. -->
<form method="post" class="panel">
    <label>Número
        <input
            type="number"
            name="numero"
            min="0"
            step="1"
            value="<?= e((string) $numero) ?>"
            required
        >
    </label>

    <!-- Permite elegir entre Fibonacci y factorial. -->
    <fieldset>
        <legend>Operación</legend>

        <label class="inline">
            <input
                type="radio"
                name="operacion"
                value="fibonacci"
                <?= $operacion === 'fibonacci' ? 'checked' : '' ?>
            >
            Sucesión de Fibonacci
        </label>

        <label class="inline">
            <input
                type="radio"
                name="operacion"
                value="factorial"
                <?= $operacion === 'factorial' ? 'checked' : '' ?>
            >
            Factorial
        </label>
    </fieldset>

    <!-- Envía los datos para realizar el cálculo. -->
    <button type="submit">Calcular</button>
</form>

<!-- Muestra el mensaje si ocurre un error. -->
<?php if ($error !== ''): ?>
    <p class="error"><?= e($error) ?></p>
<?php endif; ?>

<!-- Muestra la sucesión de Fibonacci si fue seleccionada. -->
<?php if ($serie !== null && $operacion === 'fibonacci'): ?>
    <div class="resultado">
        <span class="etiqueta">
            Primeros <?= count($serie) ?> términos de Fibonacci
        </span>

        <!-- Une los números de la serie y los muestra separados por comas. -->
        <p class="serie"><?= e(implode(', ', $serie)) ?></p>
    </div>

<!-- Muestra el resultado si se seleccionó factorial. -->
<?php elseif ($serie !== null && $operacion === 'factorial'): ?>
    <div class="resultado">
        <span class="etiqueta">Factorial de <?= (int) $numero ?></span>

        <!-- Muestra el factorial del número ingresado. -->
        <strong class="grande">
            <?= (int) $numero ?>! = <?= e((string) end($serie)) ?>
        </strong>

        <!-- Presenta todos los factoriales calculados. -->
        <p class="serie">Serie:
            <?php
            // Arreglo para guardar cada factorial con su número.
            $partes = [];

            // Recorre la serie y organiza los resultados.
            foreach ($serie as $i => $factorial) {
                $partes[] = $i . '! = ' . $factorial;
            }

            // Muestra los factoriales separados por comas.
            echo e(implode(', ', $partes));
            ?>
        </p>
    </div>
<?php endif; ?>

<!-- Carga el pie de página. -->
<?php require __DIR__ . '/includes/footer.php'; ?>
