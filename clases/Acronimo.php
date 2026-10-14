<?php

class Acronimo
{
    public function __construct(private string $frase) {}

    public function generar(): string
    {
        // Reemplaza los guiones por espacios
        $texto = str_replace('-', ' ', $this->frase);

        // Elimina signos innecesarios con una regla de expreciones regulares.
        $texto = preg_replace('/[^\p{L}\p{N}\s]/u', '', $texto) ?? '';

        // Separa la frase en palabras
        $palabras = preg_split('/\s+/u', trim($texto), -1, PREG_SPLIT_NO_EMPTY);

        $acronimo = '';

        // Toma la primera letra de cada palabra
        foreach ($palabras as $palabra) {
            $acronimo .= mb_strtoupper(mb_substr($palabra, 0, 1));
        }

        return $acronimo;
    }
}