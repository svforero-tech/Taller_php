<?php
require_once __DIR__ . '/clases/Acronimo.php';
require_once __DIR__ . '/clases/helpers.php';

$titulo = 'Convertir una frase en acrónimo';

require __DIR__ . '/includes/header.php';

$frase = '';
$resultado = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $frase = trim($_POST['frase'] ?? '');

    if ($frase === '') {
        $error = 'Escribe una frase.';
    } else {
        $acronimo = new Acronimo($frase);
        $resultado = $acronimo->generar();

        if ($resultado === '') {
            $error = 'La frase no contiene palabras.';
        }
    }
}
?>

<form method="post" class="panel">
    <label>Frase
        <input
            type="text"
            name="frase"
            value="<?= e($frase) ?>"
            placeholder="Portable Network Graphics"
            required
        >
    </label>

    <button type="submit">Convertir</button>
</form>

<?php if ($error !== ''): ?>
    <p class="error"><?= e($error) ?></p>
<?php endif; ?>

<?php if ($resultado !== ''): ?>
    <div class="resultado">
        <span class="etiqueta">Acrónimo</span>
        <strong class="grande"><?= e($resultado) ?></strong>
    </div>
<?php endif; ?>

<p class="nota">
    Ejemplo: As Soon As Possible → ASAP
</p>

<?php require __DIR__ . '/includes/footer.php'; ?>