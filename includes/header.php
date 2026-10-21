<?php
require_once __DIR__ . '/clases/helpers.php';

$titulo = 'Taller PHP';
$paginas = [
    'index.php'        => 'Inicio',
    'acronimo.php'     => '1. Acrónimo',
    'sucesion.php'     => '2. Fibonacci / Factorial',
    'estadistica.php'  => '3. Estadística',
    'conjuntos.php'    => '4. Conjuntos',
    'binario.php'      => '5. Binario',
    'arbol.php'        => '6. Árbol binario',
    'calculadora.php'  => '7. Calculadora',
];
$actual = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo ?? 'Taller PHP') ?> · Taller PHP</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="barra">
    <a class="marca" href="index.php">Taller PHP</a>
    <nav>
        <?php foreach ($paginas as $archivo => $nombre): ?>
            <a href="<?= e($archivo) ?>" class="<?= $archivo === $actual ? 'activo' : '' ?>"><?= e($nombre) ?></a>
        <?php endforeach; ?>
    </nav>
</header>
<main class="contenedor">
    <h1><?= e($titulo ?? '') ?></h1>
