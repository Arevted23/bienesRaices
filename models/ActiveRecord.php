<?php

namespace Model;

class ActiveRecord
{
    //Base de Datos
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    //Errores o validacion
    protected static $errores = [];

    //?Metodo para definir la conexion a la DB
    public static function setDB($database)
    {
        self::$db = $database;
    }

    //?Funcion que evalua si es necesario INSERTAR o ACTUALIZAR un registro
    public function guardar()
    {
        if (!is_null($this->id)) {
            //actualizar
            $this->actualizar();
        } else {
            //creando un nuevo regustro
            $this->crear();
        }
    }

    //?Funcion para realizar INSERT en la base de datos
    public function crear()
    {
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        //Insertar en la base de datos
        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";
        $resultado = self::$db->query($query);

        if ($resultado) {
            //Redireccionar al usuario
            header('Location: /admin?resultado=1');
        }

        return $resultado;
    }

    //?Funcion para realizar UPDATE en la base de datos
    public function actualizar()
    {
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key} = '{$value}'";
        }
        $query = "UPDATE " . static::$tabla . "  SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= "LIMIT 1";

        $resultado = self::$db->query($query);
        if ($resultado) {
            //Redirecciona al usuario.
            header('Location: /admin?resultado=2');
        }
    }

    //?Funcion para realizar un DELETE de la base de datos
    public function eliminar()
    {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        if ($resultado) {
            $this->borrarImagen();
            header('Location: /admin?resultado=3');
        }
    }

    //?Identificar y unir los atributos de la base de datos
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    //?Funcion para sanitizar los datos a la base de datos
    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    //?Subida de archivos
    public function setImagen($imagen)
    {
        //Elimina la imagen previa
        if (!is_null($this->id)) {
            $this->borrarImagen();
        }
        //Asignar al atributo de imagen el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }
    //?Elimina el archivo
    public function borrarImagen()
    {
        //Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    //?Validacion de errores en el formulario
    public static function getErrores()
    {
        return static::$errores;
    }

    //?Validador entero en el formulario
    public function validar()
    {
        static::$errores = [];
        return static::$errores;
    }

    //?Lista todas los registros
    public static function all()
    {
        $query = "SELECT * FROM " . static::$tabla;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    //?Obtiene determinado numero de registros
    public static function get($cantidad)
    {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }



    //?Busca una propiedad por su ID
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id}";
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }

    //?Consultar SQL
    public static function consultarSQL($query)
    {
        //Conultar la DB
        $resultado = self::$db->query($query);
        //Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }
        //Liberar la memoria
        $resultado->free();
        //Retornar los resultadoas
        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new static;
        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    //?Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
