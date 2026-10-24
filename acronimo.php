
<?php

require_once __DIR__ . '/clases/Acronimo.php';
require_once __DIR__ . '/clases/helpers.php';

$titulo = 'Convertir una frase en acrónimo';

require __DIR__ . '/includes/header.php';

// Variables que almacenan la frase ingresada, el resultado y los errores.
$frase = '';
$resultado = '';
$error = '';

// Comprueba si el formulario fue enviado mediante el método POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtiene la frase escrita y elimina los espacios
    $frase = trim($_POST['frase'] ?? '');

    // Comprueba si el usuario dejó el campo vacío.
    if ($frase === '') {
        $error = 'Escribe una frase.';
    } else {

        // Crea un objeto de la clase Acronimo con la frase ingresada.
        $acronimo = new Acronimo($frase);

        // Genera el acrónimo a partir de la frase.
        $resultado = $acronimo->generar();

        // Si no se obtuvo ningún resultado, muestra un mensaje de error.
        if ($resultado === '') {
            $error = 'La frase no contiene palabras.';
        }
    }
}
?>

<!-- Formulario que permite ingresar la frase. -->
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

    <!-- Envía la frase para procesarla. -->
    <button type="submit">Convertir</button>
</form>

<!-- Muestra el mensaje de error solamente si existe uno. -->
<?php if ($error !== ''): ?>
    <p class="error"><?= e($error) ?></p>
<?php endif; ?>

<!-- Muestra el resultado solamente si se generó un acrónimo. -->
<?php if ($resultado !== ''): ?>
    <div class="resultado">
        <span class="etiqueta">Acrónimo</span>

        <!-- Presenta el acrónimo generado. -->
        <strong class="grande"><?= e($resultado) ?></strong>
    </div>
<?php endif; ?>

<!-- Presenta un ejemplo para orientar al usuario. -->
<p class="nota">
    Ejemplo: As Soon As Possible → ASAP
</p>

<?php
// Incluye el pie de página común.
require __DIR__ . '/includes/footer.php';
?>
