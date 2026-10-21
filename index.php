
<?php
$titulo = 'Taller PHP';

require __DIR__ . '/includes/header.php';

$apps = [
    ['acronimo.php', '1. Acrónimo',
        'Convierte una frase en un acrónimo. Ejemplo: Portable Network Graphics → PNG.'],

    ['sucesion.php', '2. Fibonacci y factorial',
        'Genera la serie de Fibonacci o calcula el factorial de un número.'],

    ['estadistica.php', '3. Estadística',
        'Calcula el promedio, la media y la moda de una lista de números.'],

    ['conjuntos.php', '4. Conjuntos',
        'Realiza la unión, intersección y diferencia entre dos conjuntos.'],

    ['binario.php', '5. Conversión a binario',
        'Convierte un número entero al sistema binario.'],

    ['arbol.php', '6. Árbol binario',
        'Construye un árbol binario a partir de sus recorridos.'],

    ['calculadora.php', '7. Calculadora',
        'Realiza operaciones matemáticas y guarda un historial.']
];
?>

<p class="subtitulo">Selecciona una aplicación para comenzar:</p>

<div class="rejilla">
    <?php foreach ($apps as $app): ?>
        <a class="tarjeta" href="<?= e($app[0]) ?>">
            <h2><?= e($app[1]) ?></h2>
            <p><?= e($app[2]) ?></p>
        </a>
    <?php endforeach; ?>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
