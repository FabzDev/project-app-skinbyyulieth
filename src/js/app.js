let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;


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

function mostrarOcultarBtnsPag(){
    const btnPaginaAnterior = document.querySelector('#anterior');
    const btnPaginaSiguiente = document.querySelector('#siguiente');

    if(paso===1){
        btnPaginaAnterior.classList.add('ocultar')
        btnPaginaSiguiente.classList.remove('ocultar')
    } else if (paso ===3){
        btnPaginaAnterior.classList.remove('ocultar')
        btnPaginaSiguiente.classList.add('ocultar')
    } else {
        btnPaginaAnterior.classList.remove('ocultar')
        btnPaginaSiguiente.classList.remove('ocultar')
    }
}

function funcBotonesPag(){
    btnPagAnt = document.querySelector('#anterior');
    btnPagSig = document.querySelector('#siguiente');
    btnPagAnt.addEventListener('click', function(){
        if (paso<=pasoInicial) return;
        paso--;
        mostrarSeccion();
        mostrarOcultarBtnsPag();
    })
    btnPagSig.addEventListener('click', function(){
        if (paso>=pasoFinal) return;
        paso++;
        mostrarSeccion();
        mostrarOcultarBtnsPag();
    })
}

function iniciarApp() { // Muestra las secciones y crea listeners en los botones de los tabs
    //Muestra las secciones
    mostrarSeccion(); 
    //Muestra/oculta botoned de paginación
    mostrarOcultarBtnsPag();
    // Agrega la funcionalidad a los botones de paginación
    funcBotonesPag();
    // Agrega listeners a los botones de navegación
    let botonesNav = document.querySelectorAll(".tabs button");
	botonesNav.forEach((boton) =>
		boton.addEventListener("click", function (e) {
			paso = parseInt(e.target.dataset.paso);
			mostrarSeccion();
            mostrarOcultarBtnsPag();
		})
	);
}
