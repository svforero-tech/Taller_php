
<?php
require_once __DIR__ . '/clases/ConversorBinario.php';
require_once __DIR__ . '/clases/helpers.php';

$titulo = 'Entero a binario';
$numero = '';
$resultado = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero'] ?? '';

    $n = filter_var(trim($numero), FILTER_VALIDATE_INT);

    if ($n === false) {
        $error = 'Ingresa un número entero válido.';
    } else {
        $resultado = ConversorBinario::convertir($n);
    }
}

require __DIR__ . '/includes/header.php';
?>

<form method="post" class="panel">
    <label>Número entero
        <input type="number" name="numero" step="1"
               value="<?= e((string) $numero) ?>" required>
    </label>

    <button type="submit">Convertir</button>
</form>

<?php if ($error !== ''): ?>
    <p class="error"><?= e($error) ?></p>
<?php endif; ?>

<?php if ($resultado !== null): ?>
    <div class="resultado">
        <p>Resultado en binario:</p>
        <strong class="grande"><?= e($resultado['binario']) ?></strong>

        <h3>Divisiones realizadas</h3>

        <table>
            <tr>
                <th>Dividendo</th>
                <th>Cociente</th>
                <th>Residuo</th>
            </tr>

            <?php foreach ($resultado['pasos'] as $paso): ?>
                <tr>
                    <td><?= $paso[0] ?></td>
                    <td><?= $paso[1] ?></td>
                    <td><?= $paso[2] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <p class="nota">Los residuos se leen de abajo hacia arriba.</p>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
