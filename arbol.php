
<?php
$titulo = 'Árbol binario desde sus recorridos';

require __DIR__ . '/includes/header.php';

// Nombres de los recorridos
$campos = [
    'pre' => 'Preorden',
    'in' => 'Inorden',
    'post' => 'Postorden'
];

// Guardar lo que escribe el usuario
$entrada = [];

foreach ($campos as $clave => $nombre) {
    $entrada[$clave] = trim($_POST[$clave] ?? '');
}

// Variables para el resultado
$arbol = null;
$tipoMetodo = '';
$nombreMetodo = '';
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        // Convertir los textos ingresados en listas de nodos
        $recorridos = [];

        foreach ($entrada as $clave => $texto) {

            // Permitir separar los nodos con flechas
            $texto = str_replace(
                ['→', '->', '➜', '➡'],
                ' ',
                $texto
            );

            $recorridos[$clave] = ArbolBinario::parsear($texto);
        }

        // Contar cuántos recorridos fueron ingresados
        $cantidad = 0;

        foreach ($recorridos as $recorrido) {
            if (!empty($recorrido)) {
                $cantidad++;
            }
        }

        if ($cantidad < 2) {
            throw new InvalidArgumentException(
                'Ingresa al menos dos recorridos.'
            );
        }

        // Elegir qué recorridos se usarán
        if (
            !empty($recorridos['pre']) &&
            !empty($recorridos['in'])
        ) {
            $tipoMetodo = 'pre-in';
            $nombreMetodo = 'Preorden + Inorden';

            $r1 = $recorridos['pre'];
            $r2 = $recorridos['in'];

        } elseif (
            !empty($recorridos['post']) &&
            !empty($recorridos['in'])
        ) {
            $tipoMetodo = 'post-in';
            $nombreMetodo = 'Postorden + Inorden';

            $r1 = $recorridos['post'];
            $r2 = $recorridos['in'];

        } else {
            $tipoMetodo = 'pre-post';
            $nombreMetodo = 'Preorden + Postorden';

            $r1 = $recorridos['pre'];
            $r2 = $recorridos['post'];
        }

        // Construir el árbol
        $arbol = ArbolBinario::construir(
            $tipoMetodo,
            $r1,
            $r2
        );

    } catch (InvalidArgumentException $ex) {
        $error = $ex->getMessage();
    }
}
?>

<form method="post" class="panel">

    <p class="nota">
        Ingresa mínimo dos recorridos. Puedes separar los nodos
        con espacios, comas o flechas.
        Ejemplo: A → B → D.
    </p>

    <?php foreach ($campos as $clave => $nombre): ?>

        <label>
            <?= e($nombre) ?>

            <input
                type="text"
                name="<?= e($clave) ?>"
                value="<?= e($entrada[$clave]) ?>"
                placeholder="<?php
                    $ejemplos = [
                        'pre' => 'A → B → D → E → C',
                        'in' => 'D → B → E → A → C',
                        'post' => 'D → E → B → C → A'
                    ];

                    echo e($ejemplos[$clave]);
                ?>"
            >
        </label>

    <?php endforeach; ?>

    <button type="submit">Construir árbol</button>

</form>

<?php if ($error !== null): ?>

    <p class="error">
        <?= e($error) ?>
    </p>

<?php endif; ?>

<?php if ($arbol !== null): ?>

    <div class="resultado">

        <span class="etiqueta">
            Construido con: <?= e($nombreMetodo) ?>
        </span>

        <div class="arbol">
            <ul>
                <?= renderNodo($arbol->raiz) ?>
            </ul>
        </div>

        <p>
            <span class="etiqueta">Preorden:</span>
            <?= e(implode(' → ', $arbol->preorden())) ?>
        </p>

        <p>
            <span class="etiqueta">Inorden:</span>
            <?= e(implode(' → ', $arbol->inorden())) ?>
        </p>

        <p>
            <span class="etiqueta">Postorden:</span>
            <?= e(implode(' → ', $arbol->postorden())) ?>
        </p>

        <?php if ($tipoMetodo === 'pre-post'): ?>

            <p class="nota">
                Con preorden y postorden puede haber más de un árbol
                posible. Si un nodo tiene un solo hijo, se coloca
                a la izquierda.
            </p>

        <?php endif; ?>

    </div>

<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
