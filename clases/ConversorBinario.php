<?php

class ConversorBinario
{
    public static function convertir(int $numero): array
    {
        $negativo = $numero < 0;
        $n = abs($numero);
        $pasos = [];
        $bits = ''; // Cadena donde se construye el número binario.

        if ($n === 0) { // Si el número es cero, devuelve directamente su representación binaria.
            return [
                'binario' => '0',
                'pasos' => [[0, 0, 0]]
            ];
        }

        while ($n > 0) { // Divide el número entre 2 hasta que el cociente llegue a cero.
            $cociente = intdiv($n, 2);
            $residuo = $n % 2;

            $pasos[] = [$n, $cociente, $residuo]; // Guarda el número actual, el cociente y el residuo.
            $bits = $residuo . $bits;

            $n = $cociente; // Continúa el proceso usando el cociente como nuevo número.
        }

        if ($negativo) { // Si el número original era negativo, agrega el signo menos.
            $bits = '-' . $bits;
        }

        return [ // Devuelve el número binario y los pasos realizados.
            'binario' => $bits,
            'pasos' => $pasos
        ];
    }
}