<?php

class Conjuntos
{
    private array $a;
    private array $b;

    public function __construct(array $a, array $b)
    {
        $this->a = $this->ordenar($a);
        $this->b = $this->ordenar($b);
    }

    private function ordenar(array $numeros): array
    {
        $numeros = array_unique($numeros);
        sort($numeros);

        return array_values($numeros);
    }

    public function conjuntoA(): array
    {
        return $this->a;
    }

    public function conjuntoB(): array
    {
        return $this->b;
    }

    public function union(): array
    {
        return $this->ordenar(array_merge($this->a, $this->b));
    }

    public function interseccion(): array
    {
        return $this->ordenar(array_intersect($this->a, $this->b));
    }

    public function diferenciaAB(): array
    {
        return $this->ordenar(array_diff($this->a, $this->b));
    }

    public function diferenciaBA(): array
    {
        return $this->ordenar(array_diff($this->b, $this->a));
    }

    public static function parsear(string $texto): array
    {
        $partes = preg_split('/[\s,;]+/', trim($texto));
        $numeros = [];

        foreach ($partes as $parte) {
            if ($parte === '') {
                continue;
            }

            if (!is_numeric($parte) || (int) $parte != $parte) {
                throw new Exception("El valor '$parte' no es un entero.");
            }

            $numeros[] = (int) $parte;
        }

        return $numeros;
    }
}
