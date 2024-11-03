let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

document.addEventListener("DOMContentLoaded", function () {
	iniciarApp();
});

const cita = {
	nombre: "",
	fecha: "",
	hora: "",
	servicios: [],
};

function mostrarSeccion() {
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

function mostrarOcultarBtnsPag() {
	const btnPaginaAnterior = document.querySelector("#anterior");
	const btnPaginaSiguiente = document.querySelector("#siguiente");

	if (paso === 1) {
		btnPaginaAnterior.classList.add("ocultar");
		btnPaginaSiguiente.classList.remove("ocultar");
	} else if (paso === 3) {
		btnPaginaAnterior.classList.remove("ocultar");
		btnPaginaSiguiente.classList.add("ocultar");
	} else {
		btnPaginaAnterior.classList.remove("ocultar");
		btnPaginaSiguiente.classList.remove("ocultar");
	}
}

function funcBotonesPag() {
	btnPagAnt = document.querySelector("#anterior");
	btnPagSig = document.querySelector("#siguiente");
	btnPagAnt.addEventListener("click", function () {
		if (paso <= pasoInicial) return;
		paso--;
		mostrarSeccion();
		mostrarOcultarBtnsPag();
	});
	btnPagSig.addEventListener("click", function () {
		if (paso >= pasoFinal) return;
		paso++;
		mostrarSeccion();
		mostrarOcultarBtnsPag();
	});
}

function tabs() {
	const botonesNav = document.querySelectorAll(".tabs button");
	botonesNav.forEach((boton) =>
		boton.addEventListener("click", function (e) {
			paso = parseInt(e.target.dataset.paso);
			mostrarSeccion();
			mostrarOcultarBtnsPag();
		})
	);
}

async function consultarAPI() {
	try {
		const url = "http://localhost:3000/api/servicios";
		let resultado = await fetch(url);
		let servicios = await resultado.json();
		mostrarServicios(servicios);
	} catch (error) {
		console.log(error);
	}
}

function mostrarServicios(servicios) {
	servicios.forEach((servicio) => {
		const { id, nombre, precio } = servicio;

		const pNombreServicio = document.createElement("P");
		pNombreServicio.classList.add("nombre-servicio");
		pNombreServicio.textContent = nombre;

		const pPrecioServicio = document.createElement("P");
		pPrecioServicio.classList.add("precio-servicio");
		pPrecioServicio.textContent = `$ ${precio}`;

		const divServicio = document.createElement("DIV");
		divServicio.classList.add("servicio");
		divServicio.dataset.idServicios = id;
		divServicio.appendChild(pNombreServicio);
		divServicio.appendChild(pPrecioServicio);
		divServicio.onclick = function () {
			seleccionarServicio(servicio);
		};

		const divListaServicios = document.querySelector("#servicios");
		divListaServicios.appendChild(divServicio);
	});
}

function seleccionarServicio(serv) {
	const servicios = cita.servicios;
	cita.servicios = [...servicios, serv];
	const { id } = serv;
    const cardSeleccionada = document.querySelector(`[data-id-servicios="${id}"]`);
    cardSeleccionada.classList.add('seleccionado')
    
}

function iniciarApp() {
	// Muestra las secciones y crea listeners en los botones de los tabs
	//Muestra las secciones
	mostrarSeccion();
	//Muestra/oculta botoned de paginación
	mostrarOcultarBtnsPag();
	// Agrega la funcionalidad a los botones de paginación
	funcBotonesPag();
	// Agrega listeners a los botones de navegación
	tabs();
	// Cargar datos de la API
	consultarAPI();
}
