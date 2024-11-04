let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

document.addEventListener("DOMContentLoaded", function () {
	iniciarApp();
});

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

	obtenerNombre();

	asignarFecha();

	asignarHora();
}

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
		mostrarResumen();
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
	const { id } = serv;
	const cardSeleccionada = document.querySelector(`[data-id-servicios="${id}"]`);

	if (servicios.some((unServicio) => unServicio.id == serv.id)) {
		cita.servicios = servicios.filter((servicio) => servicio !== serv);
		cardSeleccionada.classList.remove("seleccionado");
	} else {
		cita.servicios = [...servicios, serv];
		cardSeleccionada.classList.add("seleccionado");
	}
	// console.log(cita);
}

function obtenerNombre() {
	cita.nombre = document.querySelector("#nombre").value;
}

function asignarFecha() {
	const elementoFecha = document.querySelector("#fecha");
	elementoFecha.addEventListener("input", function (e) {
		const date = new Date(e.target.value);
		const day = date.getUTCDay();
		if ([1].includes(day)) {
			sendAlert("error", "Los Lunes no estamos disponibles");
		} else {
			cita.fecha = date;
		}
	});
}

function asignarHora() {
	const elementoHora = document.querySelector("#hora");
	elementoHora.addEventListener("input", function (e) {
		const hora = e.target.value;
		const horaArray = hora.split(":");
		if (horaArray[0] < 8 || horaArray[0] >= 19) {
			sendAlert("error", "La hora ingresada no es válida");
		} else {
			cita.hora = hora;
		}
	});
}

function mostrarResumen() {
	if (Object.values(cita).includes("")) {
		console.log("FALTA INFORMACION");
	} else {
		console.log("MOSTRANDO RESUMEN");
	}
	console.log(cita);

	// console.log(Object.values(cita).includes(''));
}

function sendAlert(tipo, mensaje) {
	// Verificar que no existan alertas
	if (document.querySelector(".alerta")) return;

	// Crear el elemento html de la alerta
	const alertaHtml = document.createElement("DIV");
	alertaHtml.classList.add("alerta");
	alertaHtml.classList.add(tipo);
	alertaHtml.textContent = mensaje;

	// Agregar html de alerta al form
	const formHtml = document.querySelector(".formulario");
	formHtml.appendChild(alertaHtml);

	// Eliminar la alerta despues de 3 segundos
	setTimeout(() => {
		alertaHtml.remove();
	}, 3000);
}
