document.addEventListener("DOMContentLoaded", function() {
    eventListener();
    darkMode();
});

function eventListener() {
    const mobileMenu = document.querySelector(".mobile-menu");
    mobileMenu.addEventListener("click", navegacionResponsive);

    //Muestra campos condicionales
    const metodoContacto = document.querySelectorAll(
        'input[name="contacto[contacto]"]'
    );
    metodoContacto.forEach((input) =>
        input.addEventListener("click", mostrarMetodosContacto)
    );
}

function navegacionResponsive() {
    const navegacion = document.querySelector(".navegacion");

    // navegacion.classList.toogle('mostrar');
    if (navegacion.classList.contains("mostrar")) {
        navegacion.classList.remove("mostrar");
    } else {
        navegacion.classList.add("mostrar");
    }
}

function darkMode() {
    const botonDarkMode = document.querySelector(".dark-mode-boton");
    botonDarkMode.addEventListener("click", function() {
        document.body.classList.toggle("dark-mode");
        // if (botonDarkMode.classList.contains('dark-mode-boton')) {
        //     botonDarkMode.classList.remove('dark-mode')
        // } else {
        //     botonDarkMode.classList.add('dark-mode')
        // }
    });
}

function mostrarMetodosContacto(e) {
    const contactoDiv = document.querySelector("#contacto");
    if (e.target.value == "telefono") {
        contactoDiv.innerHTML = `
        <label for="telefono">Telefono</label>
        <input type="tel" placeholder="Tu numero" id="telefono" name="contacto[telefono]">

        <p>Eliga la fecha y hora para la llamada</p>

        <label for="Fecha">Fecha</label>
        <input type="date" id="fecha" name="contacto[fecha]"></input>

        <label for="hora">Hora</label>
        <input type="time" id="hora" min="09:00" max="17:30" name="contacto[hora]"></input>
        `;
    } else {
        contactoDiv.innerHTML = `
        <label for="email">E-mail</label>
        <input type="email" placeholder="Tu Email" id="email" name="contacto[email]">

        <p>En unos momentos recibira un email de nuestros asesores. Recuerde revisar su bandeja de no deseado</p>
        
        `;
    }
}