
<?php

class Sucesion
{
    // Genera los primeros n números de la sucesión de Fibonacci.
    public static function fibonacci(int $n): array
    {
        $serie = [];
        $a = 0;
        $b = 1;

        for ($i = 0; $i < $n; $i++) {
            $serie[] = $a;

            $temporal = $a + $b;
            $a = $b;
            $b = $temporal;
        }

        return $serie;
    }

    // Genera una serie de factoriales desde 0! hasta n!.
    public static function factorial(int $n): array
    {
        $serie = [1]; // El factorial de 0 es 1

         // Calcula el factorial actual multiplicando el factorial anterior por el número actual.
        for ($i = 1; $i <= $n; $i++) {
            $serie[] = $serie[$i - 1] * $i;
        }

        return $serie;
    }
}
