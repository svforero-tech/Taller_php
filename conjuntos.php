
<?php
require_once __DIR__ . '/clases/Conjuntos.php';
require_once __DIR__ . '/clases/helpers.php';

$titulo = 'Operaciones entre conjuntos';

$textoA = '';
$textoB = '';
$conj = null;
$error = '';

// Comprueba si se envió el formulario.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtiene los valores escritos en los campos.
    $textoA = $_POST['a'] ?? '';
    $textoB = $_POST['b'] ?? '';

    try {
        // Convierte los textos en listas de números.
        $a = Conjuntos::parsear($textoA);
        $b = Conjuntos::parsear($textoB);

        // Crea los conjuntos para realizar las operaciones.
        $conj = new Conjuntos($a, $b);

    } catch (Exception $e) {
        // Guarda el mensaje si ocurre algún error.
        $error = $e->getMessage();
    }
}

// Carga el encabezado de la página.
require __DIR__ . '/includes/header.php';
?>

<!-- Formulario para ingresar los dos conjuntos. -->
<form method="post" class="panel">

    <label>Conjunto A (números separados por coma o espacio)
        <input
            type="text"
            name="a"
            value="<?= e($textoA) ?>"
            placeholder="1, 2, 3, 4"
            required>
    </label>

    <label>Conjunto B
        <input
            type="text"
            name="b"
            value="<?= e($textoB) ?>"
            placeholder="3, 4, 5, 6"
            required>
    </label>

    <!-- Envía los conjuntos para calcular las operaciones. -->
    <button type="submit">Calcular</button>
</form>

<!-- Muestra el error, si ocurre alguno. -->
<?php if ($error !== ''): ?>
    <p class="error"><?= e($error) ?></p>
<?php endif; ?>

<!-- Muestra los resultados si los conjuntos se crearon correctamente. -->
<?php if ($conj !== null): ?>

    <div class="resultado">

        <!-- Muestra los conjuntos ingresados. -->
        <p>
            <span class="etiqueta">Conjunto A</span>
            <?= e(mostrarConjunto($conj->conjuntoA())) ?>
        </p>

        <p>
            <span class="etiqueta">Conjunto B</span>
            <?= e(mostrarConjunto($conj->conjuntoB())) ?>
        </p>

        <hr>

        <!-- Muestra la unión: todos los elementos de ambos conjuntos. -->
        <p>
            <span class="etiqueta">A ∪ B (Unión)</span>
            <strong><?= e(mostrarConjunto($conj->union())) ?></strong>
        </p>

        <!-- Muestra la intersección: elementos que comparten ambos conjuntos. -->
        <p>
            <span class="etiqueta">A ∩ B (Intersección)</span>
            <strong><?= e(mostrarConjunto($conj->interseccion())) ?></strong>
        </p>

        <!-- Muestra los elementos que están en A, pero no en B. -->
        <p>
            <span class="etiqueta">A − B (Diferencia)</span>
            <strong><?= e(mostrarConjunto($conj->diferenciaAB())) ?></strong>
        </p>

        <!-- Muestra los elementos que están en B, pero no en A. -->
        <p>
            <span class="etiqueta">B − A (Diferencia)</span>
            <strong><?= e(mostrarConjunto($conj->diferenciaBA())) ?></strong>
        </p>

    </div>

<?php endif; ?>

<!-- Carga el pie de página. -->
<?php require __DIR__ . '/includes/footer.php'; ?>
