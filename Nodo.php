<?php
class Nodo
{
    public $dato;       
    public $siguiente;  
    public $anterior;  

    public function __construct($dato)
    {
        $this->dato = $dato;
        $this->siguiente = null;
        $this->anterior = null;
    }
}
