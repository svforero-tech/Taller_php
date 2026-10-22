
<?php

class Estadistica
{
    private array $numeros;

    public function __construct(array $numeros)
    {
        if (empty($numeros)) {
            throw new InvalidArgumentException(
                'Debe ingresar al menos un número.'
            );
        }

        $this->numeros = $numeros;
    }

    public function promedio(): float
    {
        return array_sum($this->numeros) / count($this->numeros);
    }

    public function mediana(): float
    {
        $orden = $this->numeros;
        sort($orden);

        $cantidad = count($orden);
        $mitad = intdiv($cantidad, 2);

        if ($cantidad % 2 === 1) {
            return $orden[$mitad];
        }

        return ($orden[$mitad - 1] + $orden[$mitad]) / 2;
    }

    public function moda(): array
    {
        $conteo = array_count_values(
            array_map('strval', $this->numeros)
        );

        $mayor = max($conteo);

        if ($mayor === 1 && count($conteo) > 1) {
            return [];
        }

        $modas = [];

        foreach ($conteo as $numero => $veces) {
            if ($veces === $mayor) {
                $modas[] = (float) $numero;
            }
        }

        sort($modas);

        return $modas;
    }

    public static function parsearNumero(string $texto): float
    {
        $texto = str_replace(',', '.', trim($texto));

        if (!is_numeric($texto)) {
            throw new InvalidArgumentException(
                'El valor ingresado no es un número válido.'
            );
        }

        return (float) $texto;
    }
}
