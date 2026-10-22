
<?php
require_once __DIR__ . '/clases/Sucesion.php';
require_once __DIR__ . '/clases/helpers.php';

$titulo = 'Sucesión de Fibonacci o factorial';

$numero = $_POST['numero'] ?? '';
$operacion = $_POST['operacion'] ?? 'fibonacci';

$serie = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $n = filter_var(trim((string) $numero), FILTER_VALIDATE_INT);

    if ($n === false || $n < 0) {
        $error = 'Ingresa un número entero mayor o igual a 0.';
    } elseif ($operacion === 'fibonacci') {
        $serie = Sucesion::fibonacci($n);
    } elseif ($operacion === 'factorial') {
        $serie = Sucesion::factorial($n);
    } else {
        $error = 'Selecciona una operación válida.';
    }
}

require __DIR__ . '/includes/header.php';
?>

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

    <button type="submit">Calcular</button>
</form>

<?php if ($error !== ''): ?>
    <p class="error"><?= e($error) ?></p>
<?php endif; ?>

<?php if ($serie !== null && $operacion === 'fibonacci'): ?>
    <div class="resultado">
        <span class="etiqueta">
            Primeros <?= count($serie) ?> términos de Fibonacci
        </span>

        <p class="serie"><?= e(implode(', ', $serie)) ?></p>
    </div>

<?php elseif ($serie !== null && $operacion === 'factorial'): ?>
    <div class="resultado">
        <span class="etiqueta">Factorial de <?= (int) $numero ?></span>

        <strong class="grande">
            <?= (int) $numero ?>! = <?= e((string) end($serie)) ?>
        </strong>

        <p class="serie">Serie:
            <?php
            $partes = [];

            foreach ($serie as $i => $factorial) {
                $partes[] = $i . '! = ' . $factorial;
            }

            echo e(implode(', ', $partes));
            ?>
        </p>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
