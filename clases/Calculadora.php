<?php

class Calculadora
{
    public function calcular(float $a, float $b, string $operacion): float
    {
        if ($operacion === 'suma') {
            return $a + $b;
        }

        if ($operacion === 'resta') {
            return $a - $b;
        }

        if ($operacion === 'multiplicacion') {
            return $a * $b;
        }

        if ($operacion === 'division') {
            if ($b == 0) {
                throw new Exception('No se puede dividir entre cero.');
            }

            return $a / $b;
        }

        if ($operacion === 'porcentaje') {
            return $a * $b / 100;
        }

        throw new Exception('Operación no válida.');
    }
}
