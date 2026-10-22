
<?php

class Sucesion
{
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

    public static function factorial(int $n): array
    {
        $serie = [1];

        for ($i = 1; $i <= $n; $i++) {
            $serie[] = $serie[$i - 1] * $i;
        }

        return $serie;
    }
}
