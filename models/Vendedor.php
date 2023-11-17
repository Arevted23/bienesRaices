<?php

namespace Model;

class Vendedor extends ActiveRecord
{
    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    //?Declaracion de atributos
    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    //?Constructor de metodos
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    //?Validador entero en el formulario
    public function validar()
    {
        if (!$this->nombre) {
            self::$errores[] = "El nombre del vendedor es obligatorio";
        }
        if (!$this->apellido) {
            self::$errores[] = "El apellido del vendedor es obligatorio";
        }
        if (!$this->telefono) {
            self::$errores[] = "Ingresa un numero de telefono valido";
        }
        // if(!preg_match('/[0-9]{10}/', $this->telefono)){
        //     self::$errores[] = "Formato de numero de telefono no valido";
        // }
        return self::$errores;
    }
}
