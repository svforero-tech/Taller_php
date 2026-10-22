<?php

class ConversorBinario
{
    public static function convertir(int $numero): array
    {
        $negativo = $numero < 0;
        $n = abs($numero);
        $pasos = [];
        $bits = '';

        if ($n === 0) {
            return [
                'binario' => '0',
                'pasos' => [[0, 0, 0]]
            ];
        }

        while ($n > 0) {
            $cociente = intdiv($n, 2);
            $residuo = $n % 2;

            $pasos[] = [$n, $cociente, $residuo];
            $bits = $residuo . $bits;

            $n = $cociente;
        }

        if ($negativo) {
            $bits = '-' . $bits;
        }

        return [
            'binario' => $bits,
            'pasos' => $pasos
        ];
    }
}