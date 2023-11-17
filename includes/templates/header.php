<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    $auth =  $_SESSION['login'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Bienes_Raices/build/css/app.css">
    <title>Bienes Raices</title>
</head>

<body>
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/Bienes_Raices/index.php">
                    <img src="/Bienes_Raices/build/img/logo.svg" alt="Logotipo Bienes Raices">
                </a>

                <div class="mobile-menu">
                    <img src="/Bienes_Raices/build/img/barras.svg" alt="Icono Menu">
                </div>
                <div class="derecha">
                    <img src="/Bienes_Raices/build/img/dark-mode.svg" alt="Modo Oscuro" class="dark-mode-boton">
                    <nav class="navegacion">
                        <a href="nosotros.php">Nosotros</a>
                        <a href="anuncios.php">Anuncio</a>
                        <a href="blog.php">Blog</a>
                        <a href="contacto.php">Contacto</a>
                        <?php if ($auth): {?>
                            <a href="/Bienes_Raices/cerrar.php">Cerrar Sesion</a>
                        <?php }endif;?>
                    </nav>
                </div>
            </div>
            <!--Cierre de la barra-->
            <?php if ($inicio) { ?>
                <h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>
            <?php } ?>
        </div>
    </header>