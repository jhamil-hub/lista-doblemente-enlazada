<?php
class ListaDoble
{
    private $cabeza;
    private $cola;
    private $tamano;

    public function __construct()
    {
        $this->cabeza = null;
        $this->cola = null;
        $this->tamano = 0;
    }

    public function estaVacia() { return $this->cabeza === null; }
    public function getTamano() { return $this->tamano; }

    public function insertarInicio(Producto $producto)
    {
        $nuevo = new Nodo($producto);
        if ($this->estaVacia()) {
            $this->cabeza = $this->cola = $nuevo;
        } else {
            $nuevo->siguiente = $this->cabeza;
            $this->cabeza->anterior = $nuevo;
            $this->cabeza = $nuevo;
        }
        $this->tamano++;
    }

    public function insertarFinal(Producto $producto)
    {
        $nuevo = new Nodo($producto);
        if ($this->estaVacia()) {
            $this->cabeza = $this->cola = $nuevo;
        } else {
            $nuevo->anterior = $this->cola;
            $this->cola->siguiente = $nuevo;
            $this->cola = $nuevo;
        }
        $this->tamano++;
    }

    public function buscarPorId($id)
    {
        $actual = $this->cabeza;
        while ($actual !== null) {
            if ($actual->dato->getId() == $id) {
                return $actual->dato;
            }
            $actual = $actual->siguiente;
        }
        return null;
    }

    public function eliminarPorId($id)
    {
        $actual = $this->cabeza;
        while ($actual !== null) {
            if ($actual->dato->getId() == $id) {
                if ($actual->anterior !== null) {
                    $actual->anterior->siguiente = $actual->siguiente;
                } else {
                    $this->cabeza = $actual->siguiente;
                }
                if ($actual->siguiente !== null) {
                    $actual->siguiente->anterior = $actual->anterior;
                } else {
                    $this->cola = $actual->anterior;
                }
                $this->tamano--;
                return true;
            }
            $actual = $actual->siguiente;
        }
        return false;
    }

    public function recorrerAdelante()
    {
        $items = [];
        $actual = $this->cabeza;
        while ($actual !== null) {
            $items[] = $actual->dato;
            $actual = $actual->siguiente;
        }
        return $items;
    }

    public function recorrerAtras()
    {
        $items = [];
        $actual = $this->cola;
        while ($actual !== null) {
            $items[] = $actual->dato;
            $actual = $actual->anterior;
        }
        return $items;
    }
}
