<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController
{
    public static function index(Router $router)
    {

        $propiedades = Propiedad::get(3);

        $router->render('paginas/index', [
            'inicio' => true,
            'propiedades' => $propiedades
        ]);
    }

    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros', []);
    }
    public static function propiedades(Router $router)
    {
        $propiedades = Propiedad::all();
        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }
    public static function propiedad(Router $router)
    {
        $id = validarORedireccionar('/propiedades');
        $propiedad = Propiedad::find($id);
        $router->render('paginas/propiedad', [
            'propiedades' => $propiedad
        ]);
    }
    public static function blog(Router $router)
    {
        $router->render('paginas/blog');
    }
    public static function entrada(Router $router)
    {
        $router->render('paginas/entrada');
    }
    //?Hacer un envio de mail a travez de PHP MAILER
    public static function contacto(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $respuestas = $_POST['contacto'];

            //Crear instancia de PHP mailer
            $mail = new PHPMailer();
            //Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = 'd1ec5609369ed5';
            $mail->Password = '75c0302d587617';
            $mail->SMTPSecure = 'tls';

            //Contenido del EMAIL
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices');
            $mail->Subject = 'Tienes un nuevo mensaje';
            //Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            //DEFINIR EL CONTENIDO
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . '</p>';
            $contenido .= '<p>Se le contacta por: ' . $respuestas['contacto'] . '</p>';

            //Enviar de forma condicional algunos campos de email o telefon
            if ($respuestas['contacto'] === 'telefono') {
                $contenido .= '<p>Eligio ser contactado por Telefono.</p>';
                $contenido .= '<p>Telefono: ' . $respuestas['telefono'] . '</p>';
                $contenido .= '<p>Fecha: ' . $respuestas['fecha'] . '</p>';
                $contenido .= '<p>Hora: ' . $respuestas['hora'] . '</p>';
            } else {
                //Es email, entonces agregamos el campo email
                $contenido .= '<p>Eligio ser contactado por Email.</p>';
                $contenido .= '<p>Email: ' . $respuestas['email'] . '</p>';
            }
            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . '</p>';
            $contenido .= '<p>Vende o Compra: ' . $respuestas['tipo'] . '</p>';
            $contenido .= '<p>Precio o Presupuesto: $' . $respuestas['precio'] . '</p>';            
            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es texto alternativo sin HTML';
            //Enviar el email
            if ($mail->send()) {
                echo "<script>alert('Se envio el mensaje de contacto correctamente, espere unos minutos y alguien se pondra en contacto')</script>";
                // header('location: /');
            } else {
                echo "<script>alert('No se envio el mensaje. Revise su conexion a internet o rellene bien los campos de contacto')</script>";
            }
        }
        $router->render('paginas/contacto', []);
    }
}
