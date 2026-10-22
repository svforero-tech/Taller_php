
<?php

// Mostrar texto de forma segura en la página
function e(?string $texto): string
{
    return htmlspecialchars(
        (string) $texto,
        ENT_QUOTES,
        'UTF-8'
    );
}

//Acomoda el conjunto con las comas y {}
function mostrarConjunto(array $numeros): string
{
    if (empty($numeros)) {
        return '∅';
    }

    return '{' . implode(', ', $numeros) . '}';
}

//Muestra los números con un máximo de dos decimales
function formatear(float $numero): string
{
    return rtrim(rtrim(number_format($numero, 2, '.', ''), '0'), '.');
}

// Mostrar un nodo del árbol en HTML
function renderNodo(?Nodo $n): string
{
    // Si no existe el nodo, no hay nada que mostrar
    if ($n === null) {
        return '';
    }

    // Mostrar el valor del nodo
    $html = '<li><span>' . e($n->valor) . '</span>';

    // Comprobar si tiene hijos
    if ($n->izq !== null || $n->der !== null) {

        $html .= '<ul>';

        // Mostrar el hijo izquierdo
        if ($n->izq !== null) {
            $html .= renderNodo($n->izq);
        } else {
            $html .= '<li class="vacio"><span>·</span></li>';
        }

        // Mostrar el hijo derecho
        if ($n->der !== null) {
            $html .= renderNodo($n->der);
        } else {
            $html .= '<li class="vacio"><span>·</span></li>';
        }

        $html .= '</ul>';
    }

    // Devolver el HTML completo del nodo
    return $html . '</li>';
}
