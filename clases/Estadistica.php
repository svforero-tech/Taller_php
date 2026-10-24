
<?php

class Estadistica
{
    // Arreglo donde se guardan los números ingresados.
    private array $numeros;

    // Recibe los números y verifica que la lista no esté vacía.
    public function __construct(array $numeros)
    {
        // Si no se ingresaron números, muestra un error.
        if (empty($numeros)) {
            throw new InvalidArgumentException(
                'Debe ingresar al menos un número.'
            );
        }

        // Guarda los números para utilizarlos en los cálculos.
        $this->numeros = $numeros;
    }

    // Calcula el promedio.
    public function promedio(): float
    {
        return array_sum($this->numeros) / count($this->numeros);
    }

    // Calcula la mediana.
    public function mediana(): float
    {
        // Copia los números para ordenarlos sin modificar la lista original.
        $orden = $this->numeros;
        sort($orden);

        // Obtiene la cantidad de números y la posición central.
        $cantidad = count($orden);
        $mitad = intdiv($cantidad, 2);

        // Si hay una cantidad impar, devuelve el número del centro.
        if ($cantidad % 2 === 1) {
            return $orden[$mitad];
        }

        // Si hay una cantidad par, calcula el promedio de los dos valores centrales.
        return ($orden[$mitad - 1] + $orden[$mitad]) / 2;
    }

    // Encuentra el número o los números que más se repiten.
    public function moda(): array
    {
        // Cuenta cuántas veces aparece cada número.
        $conteo = array_count_values(
            array_map('strval', $this->numeros)
        );

        // Obtiene la mayor cantidad de repeticiones.
        $mayor = max($conteo);

        // Si ningún número se repite y hay varios valores distintos, no hay moda.
        if ($mayor === 1 && count($conteo) > 1) {
            return [];
        }

        // Arreglo donde se guardan los números que más se repiten.
        $modas = [];

        // Revisa cuáles números tienen la mayor cantidad de repeticiones.
        foreach ($conteo as $numero => $veces) {
            if ($veces === $mayor) {
                $modas[] = (float) $numero;
            }
        }

        // Ordena las modas de menor a mayor.
        sort($modas);

        // Devuelve las modas encontradas.
        return $modas;
    }

    // Convierte el texto ingresado en un número decimal.
    public static function parsearNumero(string $texto): float
    {
        // Elimina espacios al inicio y al final, y cambia la coma por un punto.
        $texto = str_replace(',', '.', trim($texto));

        // Verifica que el texto represente un número válido.
        if (!is_numeric($texto)) {
            throw new InvalidArgumentException(
                'El valor ingresado no es un número válido.'
            );
        }

        // Convierte el texto a un número decimal y lo devuelve.
        return (float) $texto;
    }
}
