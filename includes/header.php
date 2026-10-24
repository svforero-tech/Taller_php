<?php

$paginas = [
    'index.php'        => 'Inicio',
    'acronimo.php'     => 'Acrónimo',
    'sucesion.php'     => 'Fibonacci / Factorial',
    'estadistica.php'  => 'Estadística',
    'conjuntos.php'    => 'Conjuntos',
    'binario.php'      => 'Binario',
    'arbol.php'        => 'Árbol binario',
    'calculadora.php'  => 'Calculadora',
];
$actual = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo ?? 'Taller PHP') ?> · Taller PHP</title>
    <link rel="stylesheet" href="estilos/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">
</head>

<body>
    <header class="barra">
        <nav>
            <?php foreach ($paginas as $archivo => $nombre): ?>
                <a href="<?= e($archivo) ?>" class="<?= $archivo === $actual ? 'activo' : '' ?>"><?= e($nombre) ?></a>
            <?php endforeach; ?>
        </nav>
    </header>
    <main class="contenedor">
        <h1><?= e($titulo ?? '') ?></h1>