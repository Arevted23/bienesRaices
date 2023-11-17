<fieldset>
    <legend>Informacion General</legend>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre del Vendedor" value="<?php echo s($vendedor->nombre); ?>">
    <label for="nombre">Apellido:</label>
    <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido del Vendedor" value="<?php echo s($vendedor->apellido); ?>">
</fieldset>
<fieldset>
<legend>Informacion de Contacto</legend>
    <label for="nombre">Telefono:</label>
    <input type="number" id="telefono" name="vendedor[telefono]" placeholder="Telefono del Vendedor" value="<?php echo s($vendedor->telefono); ?>">
    <!-- <label for="nombre">Correo:</label>
    <input type="email" id="email" name="vendedor[email]" placeholder="Corrreo del Vendedor" value="<?php echo s($vendedor->email); ?>"> -->
</fieldset>