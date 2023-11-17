<?php

namespace Model;

class Propiedad extends ActiveRecord
{
    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

    //?Declaracion de atributos
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

    //?Constructor de metodos
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('y-m-d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    }

    //?Validador entero en el formulario
    public function validar()
    {
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }
        if (!$this->precio) {
            self::$errores[] = "Coloca un precio";
        }
        if (strlen($this->descripcion) < 50) {
            self::$errores[] = "La descripcion es obligatoria y debe contener un minimo de 50 caracteres";
        }
        if (!$this->habitaciones) {
            self::$errores[] = "Ingresa el numero de habitaciones";
        }
        if (!$this->wc) {
            self::$errores[] = "Ingresa el numero de wc que contiene la propiedad";
        }
        if (!$this->estacionamiento) {
            self::$errores[] = "Ingresa el numero de estacionamientos que contiene la propiedad";
        }
        if (!$this->vendedorId) {
            self::$errores[] = "Selecciona un vendedor valido";
        }

        if (!$this->imagen) {
            self::$errores[] = "La imagen es obligatoria";
        }

        return self::$errores;
    }
}
