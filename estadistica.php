
<?php
require_once __DIR__ . '/clases/Estadistica.php';
require_once __DIR__ . '/clases/helpers.php';

$titulo = 'Promedio, mediana y moda';

$cantidad = filter_var(
    $_POST['cantidad'] ?? $_GET['cantidad'] ?? '',
    FILTER_VALIDATE_INT
);

$valores = $_POST['numeros'] ?? [];
$error = '';
$stats = null;

if ($cantidad !== false && $cantidad < 1) {
    $error = 'Debes ingresar al menos un número.';
    $cantidad = false;
}

if (
    $cantidad !== false &&
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['numeros'])
) {
    try {
        $numeros = [];

        foreach (array_slice($valores, 0, $cantidad) as $valor) {
            $numeros[] = Estadistica::parsearNumero($valor);
        }

        $stats = new Estadistica($numeros);
    } catch (InvalidArgumentException $ex) {
        $error = $ex->getMessage();
    }
}

require __DIR__ . '/includes/header.php';
?>

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

<?php if ($error !== ''): ?>
    <p class="error"><?= e($error) ?></p>
<?php endif; ?>

<?php if ($cantidad !== false): ?>
    <form method="post" class="panel">
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

        <button type="submit">Calcular</button>
    </form>
<?php endif; ?>

<?php if ($stats !== null): ?>
    <div class="resultado">
        <p>
            <span class="etiqueta">Promedio</span>
            <strong><?= e(formatear($stats->promedio())) ?></strong>
        </p>

        <p>
            <span class="etiqueta">Mediana</span>
            <strong><?= e(formatear($stats->mediana())) ?></strong>
        </p>

        <p>
            <span class="etiqueta">Moda</span>
            <strong>
                <?php
                $moda = $stats->moda();

                if ($moda === []) {
                    echo 'No hay moda';
                } else {
                    echo e(implode(', ', array_map('formatear', $moda)));
                }
                ?>
            </strong>
        </p>
    </div>
<?php endif; ?>


<?php require __DIR__ . '/includes/footer.php'; ?>
