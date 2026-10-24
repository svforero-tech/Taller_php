<?php

require_once __DIR__ . '/clases/helpers.php';

$titulo = 'Taller PHP';
require __DIR__ . '/includes/header.php';

$apps = [
    [
        'acronimo.php',
        'Acrónimo',
        'Convierte una frase en un acrónimo. Ejemplo: Portable Network Graphics → PNG.',
        'Aa'
    ],

    [
        'sucesion.php',
        'Fibonacci y factorial',
        'Genera la serie de Fibonacci o calcula el factorial de un número.',
        'n!'
    ],

    [
        'estadistica.php',
        'Estadística',
        'Calcula el promedio, la media y la moda de una lista de números.',
        'x̄'
    ],

    [
        'conjuntos.php',
        'Conjuntos',
        'Realiza la unión, intersección y diferencia entre dos conjuntos.',
        '∪'
    ],

    [
        'binario.php',
        'Conversión a binario',
        'Convierte un número entero al sistema binario.',
        '01'
    ],

    [
        'arbol.php',
        'Árbol binario',
        'Construye un árbol binario a partir de sus recorridos.',
        '⑂'
    ],

    [
        'calculadora.php',
        'Calculadora',
        'Realiza operaciones matemáticas y guarda un historial.',
        '±'
    ]
];
?>

<div class="escena">
    <section class="pantalla">
        <h2 class="bienvenida">¡Bienvenido!</h2>
        <p class="subtitulo">Pasa el mouse sobre un círculo para ver la aplicación.<br>Hay siete caminos, ¿cuál tomas?</p>
    </section>

    <nav class="apps">
        <?php foreach ($apps as $i => $app): ?>
            <div class="app">
                <a class="circulo" href="<?= e($app[0]) ?>" aria-label="<?= e($app[1]) ?>">
                    <?= e($app[3]) ?>
                </a>
                <div class="info">
                    <h3><?= e($app[1]) ?></h3>
                    <p><?= e($app[2]) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </nav>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>