<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController
{
    //? Pagina Index Principal
    public static function index(Router $router)
    {
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'vendedores'=>$vendedores,
            'resultado' => $resultado
            
        ]);
    }

    //?Pagina de creacion de propiedades
    public static function crear(Router $router)
    {
        $errores = Propiedad::getErrores();
        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //CREA UNA NUEVA INSTANCIA
            $propiedad = new Propiedad($_POST['propiedad']);
            /** SUBIDA DE ARCHIVOS **/

            //Generar un nombre unico para los archivos o imagenes
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            //Setear la imagen
            //Realiza un reseze a la imagen con intervention
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad->setImagen($nombreImagen);
            }
            //Validar
            $errores = $propiedad->validar();

            if (empty($errores)) {

                //CREAR CARPETA
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
                //Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);

                //Guardamos la propiedad
                $resultado = $propiedad->guardar();

                if ($resultado) {
                    header('location: /propiedades');
                }
            }
        }
        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    //?Pagina de actualizar propiedades
    public static function actualizar(Router $router)
    {
        $id = validarORedireccionar('/propiedades');
        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Asignar los atributos
            $args = $_POST['propiedad'];
            $propiedad->sincronizar($args);

            $errores = $propiedad->validar();

            //Generar un nombre unico para los archivos o imagenes
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            //Validacion Subida de archivos
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad->setImagen($nombreImagen);
            }

            //Revisar que el arreglo de errores este vacio
            if (empty($errores)) {
                // Almacenar la imagen
                if ($_FILES['propiedad']['tmp_name']['imagen']) {
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }

                // Guarda en la base de datos
                $resultado = $propiedad->guardar();

                if ($resultado) {
                    header('location: /propiedades');
                }
            }
        }

        $router->render('/propiedades/actualizar', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $tipo = $_POST['tipo'];
                if (validarTipoContenido($tipo)) {
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            }
        }
    }
}
