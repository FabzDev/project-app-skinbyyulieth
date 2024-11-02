let paso = 1;

document.addEventListener("DOMContentLoaded", function () {
    iniciarApp();
});
function mostrarSeccion() { // Muestra y oculta las secciones dinamicamente
	// Remover .mostrar de la seccion anterior (si existe)
    let seccionAnterior = document.querySelector(".mostrar");
	if (seccionAnterior) {
		seccionAnterior.classList.remove("mostrar");
	}
    // Obtener elemento de la seccion a mostrar y agregarle la clase mostrar
	let seccionMostrar = document.querySelector(`#paso-${paso}`);
	seccionMostrar.classList.add("mostrar");

    // Remover .actual del tab anterior (si existe)
    let tabAnterior = document.querySelector(".actual");
	if (tabAnterior) {
		tabAnterior.classList.remove("actual");
	}
    //Obtener el elemento del tab button de la seccion mostrada
    let tabActual = document.querySelector(`[data-paso="${paso}"]`);
    tabActual.classList.add("actual");

}

function iniciarApp() { // Muestra las secciones y crea listeners en los botones de los tabs
    //Muestra las secciones
    mostrarSeccion(); 
    // Agrega listeners a los botones
    let botones = document.querySelectorAll(".tabs button");
	botones.forEach((boton) =>
		boton.addEventListener("click", function (e) {
			paso = parseInt(e.target.dataset.paso);
			mostrarSeccion();
		})
	);
}
