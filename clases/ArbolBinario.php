
<?php

class ArbolBinario
{
    public ?Nodo $raiz;

    public function __construct(?Nodo $raiz = null)
    {
        $this->raiz = $raiz;
    }

    // Construir el árbol según los recorridos recibidos
    public static function construir(string $tipo, array $r1, array $r2): self
    {
        self::validar($r1, $r2);

        if ($tipo == 'pre-in') {
            $raiz = self::preIn($r1, $r2);
        } elseif ($tipo == 'post-in') {
            $raiz = self::postIn($r1, $r2);
        } elseif ($tipo == 'pre-post') {
            $raiz = self::prePost($r1, $r2);
        } else {
            throw new InvalidArgumentException(
                'Tipo de recorrido no válido.'
            );
        }

        $arbol = new self($raiz);

        // Comprobar que los recorridos coincidan
        if ($tipo == 'pre-in') {
            $p1 = $arbol->preorden();
            $p2 = $arbol->inorden();
        } elseif ($tipo == 'post-in') {
            $p1 = $arbol->postorden();
            $p2 = $arbol->inorden();
        } else {
            $p1 = $arbol->preorden();
            $p2 = $arbol->postorden();
        }

        if ($p1 !== $r1 || $p2 !== $r2) {
            throw new InvalidArgumentException(
                'Los recorridos no corresponden a un mismo árbol.'
            );
        }

        return $arbol;
    }

    // Validar que los recorridos tengan los mismos nodos
    private static function validar(array $r1, array $r2): void
    {
        if (count($r1) !== count($r2)) {
            throw new InvalidArgumentException(
                'Los recorridos deben tener la misma cantidad de nodos.'
            );
        }

        if (
            count($r1) !== count(array_unique($r1)) ||
            count($r2) !== count(array_unique($r2))
        ) {
            throw new InvalidArgumentException(
                'Los nodos no pueden repetirse.'
            );
        }

        $a = $r1;
        $b = $r2;

        sort($a);
        sort($b);

        if ($a !== $b) {
            throw new InvalidArgumentException(
                'Ambos recorridos deben contener los mismos nodos.'
            );
        }
    }

    // Construir usando preorden e inorden
    private static function preIn(array $pre, array $in): ?Nodo
    {
        if (empty($pre)) {
            return null;
        }

        $raiz = $pre[0];
        $posicion = array_search($raiz, $in, true);

        if ($posicion === false) {
            throw new InvalidArgumentException(
                'No se encontró la raíz en el recorrido inorden.'
            );
        }

        $nodo = new Nodo($raiz);

        $nodo->izq = self::preIn(
            array_slice($pre, 1, $posicion),
            array_slice($in, 0, $posicion)
        );

        $nodo->der = self::preIn(
            array_slice($pre, $posicion + 1),
            array_slice($in, $posicion + 1)
        );

        return $nodo;
    }

    // Construir usando postorden e inorden
    private static function postIn(array $post, array $in): ?Nodo
    {
        if (empty($post)) {
            return null;
        }

        $raiz = $post[count($post) - 1];
        $posicion = array_search($raiz, $in, true);

        if ($posicion === false) {
            throw new InvalidArgumentException(
                'No se encontró la raíz en el recorrido inorden.'
            );
        }

        $nodo = new Nodo($raiz);

        $nodo->izq = self::postIn(
            array_slice($post, 0, $posicion),
            array_slice($in, 0, $posicion)
        );

        $nodo->der = self::postIn(
            array_slice(
                $post,
                $posicion,
                count($post) - 1 - $posicion
            ),
            array_slice($in, $posicion + 1)
        );

        return $nodo;
    }

    // Construir usando preorden y postorden
    private static function prePost(array $pre, array $post): ?Nodo
    {
        if (empty($pre)) {
            return null;
        }

        $nodo = new Nodo($pre[0]);

        if (count($pre) == 1) {
            return $nodo;
        }

        $posicion = array_search($pre[1], $post, true);

        if ($posicion === false) {
            throw new InvalidArgumentException(
                'Los recorridos no son compatibles.'
            );
        }

        $tam = $posicion + 1;

        $nodo->izq = self::prePost(
            array_slice($pre, 1, $tam),
            array_slice($post, 0, $tam)
        );

        $nodo->der = self::prePost(
            array_slice($pre, $tam + 1),
            array_slice($post, $tam, count($post) - $tam - 1)
        );

        return $nodo;
    }

    // Recorrido preorden: raíz, izquierda, derecha
    private function recorrerPreorden(?Nodo $n, array &$resultado): void
    {
        if ($n === null) {
            return;
        }

        $resultado[] = $n->valor;

        $this->recorrerPreorden($n->izq, $resultado);
        $this->recorrerPreorden($n->der, $resultado);
    }

    public function preorden(): array
    {
        $resultado = [];
        $this->recorrerPreorden($this->raiz, $resultado);

        return $resultado;
    }

    // Recorrido inorden: izquierda, raíz, derecha
    private function recorrerInorden(?Nodo $n, array &$resultado): void
    {
        if ($n === null) {
            return;
        }

        $this->recorrerInorden($n->izq, $resultado);

        $resultado[] = $n->valor;

        $this->recorrerInorden($n->der, $resultado);
    }

    public function inorden(): array
    {
        $resultado = [];
        $this->recorrerInorden($this->raiz, $resultado);

        return $resultado;
    }

    // Recorrido postorden: izquierda, derecha, raíz
    private function recorrerPostorden(?Nodo $n, array &$resultado): void
    {
        if ($n === null) {
            return;
        }

        $this->recorrerPostorden($n->izq, $resultado);
        $this->recorrerPostorden($n->der, $resultado);

        $resultado[] = $n->valor;
    }

    public function postorden(): array
    {
        $resultado = [];
        $this->recorrerPostorden($this->raiz, $resultado);

        return $resultado;
    }

    // Convertir el texto ingresado en una lista de nodos
    public static function parsear(string $texto): array
    {
        $texto = trim($texto);

        if ($texto === '') {
            return [];
        }

        $partes = preg_split('/[,;\s]+/u', $texto, -1, PREG_SPLIT_NO_EMPTY);

        return $partes === false ? [] : $partes;
    }
}
