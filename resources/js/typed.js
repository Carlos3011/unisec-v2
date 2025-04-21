import Typed from "typed.js";
 
//HOVER

document.addEventListener('DOMContentLoaded', () => {
    // Instancia para el título
    const typedTitle = new Typed("#typed-text-hover-title", {
        strings: ["UNISEC MÉXICO", "Consorcio Universitario de Ingeniería Espacial"],
        typeSpeed: 120,
        backSpeed: 65,
        loop: true,
        showCursor: false,
    });

    // Instancia para el contenido
    const typedContent = new Typed("#typed-text-hover", {
        strings: ["Ingeniería Cosmonáutica", "", "Tecnología del Futuro"],
        typeSpeed: 100,
        backSpeed: 50,
        loop: true,
        showCursor: false,
    });
});
