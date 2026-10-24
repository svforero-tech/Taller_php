<?php

class Historial
{
    // Recibe el texto que se desea guardar.
    public static function agregar(string $texto): void
    {
        // Si todavía no existe el historial en la sesión, se crea como un arreglo vacío.
        if (!isset($_SESSION['historial_calculadora'])) {
            $_SESSION['historial_calculadora'] = [];
        }

        // Agrega el nuevo texto al inicio del arreglo, para que aparezca primero en el historial.
        array_unshift($_SESSION['historial_calculadora'], $texto);
    }

    // Devuelve todos los elementos guardados en el historial.
    public static function obtener(): array
    {
        // Si el historial existe, lo devuelve. Si no existe, devuelve un arreglo vacío.
        return $_SESSION['historial_calculadora'] ?? [];
    }

     // Borra todos los elementos del historial.
    public static function borrar(): void
    {
        // Reemplaza el historial actual por un arreglo vacío.
        $_SESSION['historial_calculadora'] = [];
    }
}