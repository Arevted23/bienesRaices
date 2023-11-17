<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesion</h1>
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    <form method="POST" action="/login" class="formulario">
        <fieldset>
            <legend>Email y Passwor</legend>

            <label for="email">E-mail</label>
            <input name="email" type="email" placeholder="Tu Email" id="email" required>

            <label for="password">Password</label>
            <input name="password" type="password" placeholder="Password" id="password" required>

        </fieldset>
        <input type="submit" value="Iniciar Sesion" class="boton boton-verde">
    </form>
</main>