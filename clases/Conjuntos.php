
<?php

class Conjuntos
{
    private array $a;
    private array $b;

    // Recibe los dos conjuntos y los organiza al crearlos.
    public function __construct(array $a, array $b)
    {
        $this->a = $this->ordenar($a);
        $this->b = $this->ordenar($b);
    }

    // Elimina los elementos repetidos y ordena los números de menor a mayor.
    private function ordenar(array $numeros): array
    {
        $numeros = array_unique($numeros);
        sort($numeros);

        // Organiza los índices del arreglo nuevamente.
        return array_values($numeros);
    }

    // Devuelve los elementos del conjunto A.
    public function conjuntoA(): array
    {
        return $this->a;
    }

    // Devuelve los elementos del conjunto B.
    public function conjuntoB(): array
    {
        return $this->b;
    }

    // Unión: reúne los elementos de A y B sin repetirlos.
    public function union(): array
    {
        return $this->ordenar(array_merge($this->a, $this->b));
    }

    // Intersección: devuelve los elementos que están en ambos conjuntos.
    public function interseccion(): array
    {
        return $this->ordenar(array_intersect($this->a, $this->b));
    }

    // Diferencia A - B: devuelve los elementos que están en A, pero no en B.
    public function diferenciaAB(): array
    {
        return $this->ordenar(array_diff($this->a, $this->b));
    }

    // Diferencia B - A: devuelve los elementos que están en B, pero no en A.
    public function diferenciaBA(): array
    {
        return $this->ordenar(array_diff($this->b, $this->a));
    }

    // Convierte el texto ingresado por el usuario en un arreglo de números enteros.
    public static function parsear(string $texto): array
    {
        // Separa los valores cuando encuentra espacios, comas o punto y coma.
        $partes = preg_split('/[\s,;]+/', trim($texto));
        $numeros = [];

        // Revisa cada valor ingresado.
        foreach ($partes as $parte) {

            // Si el valor está vacío, pasa al siguiente.
            if ($parte === '') {
                continue;
            }

            // Verifica que el valor sea numérico y que sea un número entero.
            if (!is_numeric($parte) || (int) $parte != $parte) {
                throw new Exception("El valor '$parte' no es un entero.");
            }

            // Convierte el valor a entero y lo guarda en el arreglo.
            $numeros[] = (int) $parte;
        }

        // Devuelve todos los números ingresados.
        return $numeros;
    }
}
