import Typed from "typed.js";
 
//HOVER

document.addEventListener('DOMContentLoaded', () => {
    // Instancia para el título
    const typedTitle = new Typed("#typed-text-hover-title", {
        strings: ["UNISEC MÉXICO"],
        typeSpeed: 50,
        showCursor: false,
    });

    // Instancia para el contenido
    const typedContent = new Typed("#typed-text-hover", {
        strings: ["Ingeniería Cosmonáutica", "", "Tecnología del Futuro"],
        typeSpeed: 150,
        backSpeed: 50,
        loop: true,
    });
});
