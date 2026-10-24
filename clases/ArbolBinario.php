
<?php

// Clase encargada de construir y recorrer un árbol binario.
class ArbolBinario
{
    // Guarda el nodo principal del árbol, llamado raíz.
    public ?Nodo $raiz;

    // Crea el árbol y recibe su raíz. Si no se indica, queda vacía.
    public function __construct(?Nodo $raiz = null)
    {
        $this->raiz = $raiz;
    }

    // Construye el árbol a partir de dos recorridos y verifica el resultado.
    public static function construir(string $tipo, array $r1, array $r2): self
    {
        // Comprueba que ambos recorridos tengan los mismos nodos.
        self::validar($r1, $r2);

        // Selecciona el método de construcción según los recorridos recibidos.
        if ($tipo == 'pre-in') {
            $raiz = self::preIn($r1, $r2);
        } elseif ($tipo == 'post-in') {
            $raiz = self::postIn($r1, $r2);
        } elseif ($tipo == 'pre-post') {
            $raiz = self::prePost($r1, $r2);
        } else {
            // Muestra un error si el tipo de recorrido no está permitido.
            throw new InvalidArgumentException(
                'Tipo de recorrido no válido.'
            );
        }

        // Crea el árbol con la raíz obtenida.
        $arbol = new self($raiz);

        // Obtiene los recorridos del árbol construido para comprobarlos.
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

        // Verifica que los recorridos obtenidos coincidan con los ingresados.
        if ($p1 !== $r1 || $p2 !== $r2) {
            throw new InvalidArgumentException(
                'Los recorridos no corresponden a un mismo árbol.'
            );
        }

        // Devuelve el árbol construido.
        return $arbol;
    }

    // Comprueba que ambos recorridos contengan los mismos nodos sin repetirlos.
    private static function validar(array $r1, array $r2): void
    {
        // Verifica que los recorridos tengan la misma cantidad de nodos.
        if (count($r1) !== count($r2)) {
            throw new InvalidArgumentException(
                'Los recorridos deben tener la misma cantidad de nodos.'
            );
        }

        // Comprueba que no existan nodos repetidos en ninguno de los recorridos.
        if (
            count($r1) !== count(array_unique($r1)) ||
            count($r2) !== count(array_unique($r2))
        ) {
            throw new InvalidArgumentException(
                'Los nodos no pueden repetirse.'
            );
        }

        // Copia los recorridos para ordenar sus elementos.
        $a = $r1;
        $b = $r2;

        // Ordena ambas copias para poder comparar sus elementos.
        sort($a);
        sort($b);

        // Comprueba que los dos recorridos tengan los mismos valores.
        if ($a !== $b) {
            throw new InvalidArgumentException(
                'Ambos recorridos deben contener los mismos nodos.'
            );
        }
    }

    // Construye el árbol utilizando preorden e inorden.
    private static function preIn(array $pre, array $in): ?Nodo
    {
        // Si no quedan elementos, no hay nodo que construir.
        if (empty($pre)) {
            return null;
        }

        // En preorden, el primer elemento es la raíz.
        $raiz = $pre[0];

        // Busca la posición de la raíz dentro del recorrido inorden.
        $posicion = array_search($raiz, $in, true);

        // Si no encuentra la raíz, los recorridos no se pueden procesar.
        if ($posicion === false) {
            throw new InvalidArgumentException(
                'No se encontró la raíz en el recorrido inorden.'
            );
        }

        // Crea el nodo principal de esta parte del árbol.
        $nodo = new Nodo($raiz);

        // Construye el subárbol izquierdo con los elementos anteriores a la raíz.
        $nodo->izq = self::preIn(
            array_slice($pre, 1, $posicion),
            array_slice($in, 0, $posicion)
        );

        // Construye el subárbol derecho con los elementos posteriores a la raíz.
        $nodo->der = self::preIn(
            array_slice($pre, $posicion + 1),
            array_slice($in, $posicion + 1)
        );

        // Devuelve el nodo con sus subárboles construidos.
        return $nodo;
    }

    // Construye el árbol utilizando postorden e inorden.
    private static function postIn(array $post, array $in): ?Nodo
    {
        // Si no quedan elementos, devuelve un árbol vacío en esta parte.
        if (empty($post)) {
            return null;
        }

        // En postorden, el último elemento es la raíz.
        $raiz = $post[count($post) - 1];

        // Busca la posición de la raíz en el recorrido inorden.
        $posicion = array_search($raiz, $in, true);

        // Si la raíz no aparece en inorden, muestra un error.
        if ($posicion === false) {
            throw new InvalidArgumentException(
                'No se encontró la raíz en el recorrido inorden.'
            );
        }

        // Crea el nodo correspondiente a la raíz.
        $nodo = new Nodo($raiz);

        // Construye el subárbol izquierdo.
        $nodo->izq = self::postIn(
            array_slice($post, 0, $posicion),
            array_slice($in, 0, $posicion)
        );

        // Construye el subárbol derecho usando los elementos restantes.
        $nodo->der = self::postIn(
            array_slice(
                $post,
                $posicion,
                count($post) - 1 - $posicion
            ),
            array_slice($in, $posicion + 1)
        );

        // Devuelve el nodo construido.
        return $nodo;
    }

    // Construye el árbol utilizando preorden y postorden.
    private static function prePost(array $pre, array $post): ?Nodo
    {
        // Si no quedan elementos, devuelve una parte vacía del árbol.
        if (empty($pre)) {
            return null;
        }

        // El primer elemento de preorden es la raíz.
        $nodo = new Nodo($pre[0]);

        // Si solo queda un elemento, ese nodo ya está completo.
        if (count($pre) == 1) {
            return $nodo;
        }

        // Busca en postorden el primer elemento que sigue a la raíz en preorden.
        $posicion = array_search($pre[1], $post, true);

        // Si no lo encuentra, los recorridos no son compatibles.
        if ($posicion === false) {
            throw new InvalidArgumentException(
                'Los recorridos no son compatibles.'
            );
        }

        // Calcula cuántos elementos pertenecen al subárbol izquierdo.
        $tam = $posicion + 1;

        // Construye el subárbol izquierdo con los elementos correspondientes.
        $nodo->izq = self::prePost(
            array_slice($pre, 1, $tam),
            array_slice($post, 0, $tam)
        );

        // Construye el subárbol derecho con los elementos restantes.
        $nodo->der = self::prePost(
            array_slice($pre, $tam + 1),
            array_slice($post, $tam, count($post) - $tam - 1)
        );

        // Devuelve el nodo con sus subárboles.
        return $nodo;
    }

    // Recorre el árbol en preorden: raíz, izquierda y derecha.
    private function recorrerPreorden(?Nodo $n, array &$resultado): void
    {
        // Si el nodo está vacío, termina esta parte del recorrido.
        if ($n === null) {
            return;
        }

        // Agrega primero el valor del nodo actual.
        $resultado[] = $n->valor;

        // Recorre el subárbol izquierdo.
        $this->recorrerPreorden($n->izq, $resultado);

        // Después recorre el subárbol derecho.
        $this->recorrerPreorden($n->der, $resultado);
    }

    // Inicia el recorrido preorden y devuelve sus elementos.
    public function preorden(): array
    {
        $resultado = [];
        $this->recorrerPreorden($this->raiz, $resultado);

        return $resultado;
    }

    // Recorre el árbol en inorden: izquierda, raíz y derecha.
    private function recorrerInorden(?Nodo $n, array &$resultado): void
    {
        // Si el nodo está vacío, termina esta parte del recorrido.
        if ($n === null) {
            return;
        }

        // Recorre primero el subárbol izquierdo.
        $this->recorrerInorden($n->izq, $resultado);

        // Agrega el valor del nodo actual.
        $resultado[] = $n->valor;

        // Finalmente, recorre el subárbol derecho.
        $this->recorrerInorden($n->der, $resultado);
    }

    // Inicia el recorrido inorden y devuelve sus elementos.
    public function inorden(): array
    {
        $resultado = [];
        $this->recorrerInorden($this->raiz, $resultado);

        return $resultado;
    }

    // Recorre el árbol en postorden: izquierda, derecha y raíz.
    private function recorrerPostorden(?Nodo $n, array &$resultado): void
    {
        // Si el nodo está vacío, termina esta parte del recorrido.
        if ($n === null) {
            return;
        }

        // Recorre el subárbol izquierdo.
        $this->recorrerPostorden($n->izq, $resultado);

        // Después recorre el subárbol derecho.
        $this->recorrerPostorden($n->der, $resultado);

        // Agrega el valor del nodo actual al final.
        $resultado[] = $n->valor;
    }

    // Inicia el recorrido postorden y devuelve sus elementos.
    public function postorden(): array
    {
        $resultado = [];
        $this->recorrerPostorden($this->raiz, $resultado);

        return $resultado;
    }

    // Separa el texto ingresado para obtener una lista de nodos.
    public static function parsear(string $texto): array
    {
        // Elimina los espacios que hay al principio y al final.
        $texto = trim($texto);

        // Si no hay texto, devuelve una lista vacía.
        if ($texto === '') {
            return [];
        }

        // Separa los nodos cuando encuentra comas, punto y coma o espacios.
        $partes = preg_split('/[,;\s]+/u', $texto, -1, PREG_SPLIT_NO_EMPTY);

        // Devuelve los nodos obtenidos; si ocurre un error, devuelve una lista vacía.
        return $partes === false ? [] : $partes;
    }
}
