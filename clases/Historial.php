<?php

class Historial
{
    public static function agregar(string $texto): void
    {
        if (!isset($_SESSION['historial_calculadora'])) {
            $_SESSION['historial_calculadora'] = [];
        }

        array_unshift($_SESSION['historial_calculadora'], $texto);
    }

    public static function obtener(): array
    {
        return $_SESSION['historial_calculadora'] ?? [];
    }

    public static function borrar(): void
    {
        $_SESSION['historial_calculadora'] = [];
    }
}