<?php
require_once __DIR__ . '/clases/Conjuntos.php';
require_once __DIR__ . '/clases/helpers.php';

$titulo = 'Operaciones entre conjuntos';

$textoA = '';
$textoB = '';
$conj = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $textoA = $_POST['a'] ?? '';
    $textoB = $_POST['b'] ?? '';

    try {
        $a = Conjuntos::parsear($textoA);
        $b = Conjuntos::parsear($textoB);

        $conj = new Conjuntos($a, $b);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

require __DIR__ . '/includes/header.php';
?>

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

    <button type="submit">Calcular</button>
</form>

<?php if ($error !== ''): ?>
    <p class="error"><?= e($error) ?></p>
<?php endif; ?>

<?php if ($conj !== null): ?>

    <div class="resultado">

        <p>
            <span class="etiqueta">Conjunto A</span>
            <?= e(mostrarConjunto($conj->conjuntoA())) ?>
        </p>

        <p>
            <span class="etiqueta">Conjunto B</span>
            <?= e(mostrarConjunto($conj->conjuntoB())) ?>
        </p>

        <hr>

        <p>
            <span class="etiqueta">A ∪ B (Unión)</span>
            <strong><?= e(mostrarConjunto($conj->union())) ?></strong>
        </p>

        <p>
            <span class="etiqueta">A ∩ B (Intersección)</span>
            <strong><?= e(mostrarConjunto($conj->interseccion())) ?></strong>
        </p>

        <p>
            <span class="etiqueta">A − B (Diferencia)</span>
            <strong><?= e(mostrarConjunto($conj->diferenciaAB())) ?></strong>
        </p>

        <p>
            <span class="etiqueta">B − A (Diferencia)</span>
            <strong><?= e(mostrarConjunto($conj->diferenciaBA())) ?></strong>
        </p>

    </div>

<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>