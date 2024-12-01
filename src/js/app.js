let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

document.addEventListener("DOMContentLoaded", function () {
	iniciarApp();
});

function iniciarApp() {
	mostrarSeccion(); //Carga y muestra las secciones y los listeners
	mostrarOcultarBtnsPag(); //Muestra/oculta botones de paginación
	funcBotonesPag(); //Agrega funcionalidad a los botones de paginación
	tabs(); //Agrega listeners a los botones tabs de navegación
	consultarServiciosAPI(); //Carga los datos desde la API
	obtenerId(); //Obtiene el idUsuario desde el html
	obtenerNombre(); //Obtiene el nombre desde el html
	asignarFecha(); //Asigna la fecha teniendo en cuenta la disponibilidad
	asignarHora(); //Asigna la hora teniendo en cuenta la disponibilidad
}

const cita = {
	idUsuario: "",
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

async function consultarServiciosAPI() {
	try {
		const url = "/api/servicios";
		let resultado = await fetch(url);
		let servicios = await resultado.json();
		mostrarServicios(servicios);
	} catch (error) {
		console.log("error en consultarAPI" + error);
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
		pPrecioServicio.textContent = `$ ${parseInt(precio).toLocaleString("es-CO")}`;

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
}

function obtenerNombre() {
	cita.nombre = document.querySelector("#nombre").value;
}

function obtenerId() {
	cita.idUsuario = document.querySelector("#idUsuario").value;
}

function asignarFecha() {
	const elementoFecha = document.querySelector("#fecha");
	elementoFecha.addEventListener("input", function (e) {
		// Validación dia de la semana en servicio
		const day = new Date(e.target.value).getUTCDay();
		if ([1].includes(day)) {
			sendAlert("error", "Los Lunes no estamos disponibles");
			elementoFecha.value = "";
		} else {
			cita.fecha = e.target.value;
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
			elementoHora.value = "";
		} else {
			cita.hora = e.target.value;
		}
	});
}

function mostrarResumen() {
	const divPaso3 = document.querySelector("#paso-3");
	divPaso3.classList.add("contenido-resumen");
	while (divPaso3.childNodes[0]) {
		divPaso3.childNodes[0].remove();
	}
	// console.log(cita);
    let valorTotal = 0;
	const { nombre, fecha, hora, servicios } = cita;
	if (Object.values(cita).includes("") || cita.servicios.length == 0) {
		sendAlert("error", "Falta ingresar información", "#paso-3", false);
		return;
	}
	document.querySelector(".alerta")?.remove();

	//Formateando fecha
	const date = new Date(fecha);
	const dia = date.getDate();
	const mes = date.getMonth();
	const year = date.getFullYear();
	const fechaUTC = new Date(Date.UTC(year, mes, dia + 2));
	const opcionesFecha = { weekday: "long", year: "numeric", month: "long", day: "numeric" };
	const fechaFormateada = fechaUTC.toLocaleDateString("es-CO", opcionesFecha);

	//Renderizando Nombre, Fecha y Hora
	const divDatosPersonales = document.createElement("DIV");
	divDatosPersonales.classList.add("contenedor-datos");
	const pNombre = document.createElement("P");
	pNombre.innerHTML = `<span>Nombre: </span>${nombre}`;
	const pFecha = document.createElement("P");
	pFecha.innerHTML = `<span>Fecha: </span>${fechaFormateada}`;
	const pHora = document.createElement("P");
	pHora.innerHTML = `<span>Hora: </span>${hora} horas`;
	const botonResumen = document.createElement("BUTTON");
	botonResumen.classList.add("boton");
	botonResumen.textContent = "Reservar";
	botonResumen.onclick = reservarCita;

	// Div datos personales
	const headingDatosPersonales = document.createElement("H3");
	headingDatosPersonales.textContent = "Resumen de Cita";
	divDatosPersonales.appendChild(headingDatosPersonales);
	divDatosPersonales.appendChild(pNombre);
	divDatosPersonales.appendChild(pFecha);
	divDatosPersonales.appendChild(pHora);
    

	// Heading servicios en resumen
	const headingServicios = document.createElement("H3");
	headingServicios.textContent = "Resumen de Servicios";
	divPaso3.appendChild(headingServicios);

	// Iterando y renderizando los servicios
	servicios.forEach((servicio) => {
        const { id, nombre, precio } = servicio;
		const divServicio = document.createElement("DIV");
		divServicio.classList.add("contenedor-servicio");
		const pNombreServicio = document.createElement("P");
		pNombreServicio.textContent = nombre;
		const pPrecioServicio = document.createElement("P");
		pPrecioServicio.innerHTML = `<span>Precio: </span>$${parseInt(precio).toLocaleString("es-CO")}`;
        
		divServicio.appendChild(pNombreServicio);
		divServicio.appendChild(pPrecioServicio);
        valorTotal += parseInt(precio);
		divPaso3.appendChild(divServicio);
	});
    const pTotal = document.createElement("P");
	pTotal.innerHTML = `<span>Total:</span> <b>$${parseInt(valorTotal).toLocaleString("es-CO")}</b>`;
	divDatosPersonales.appendChild(pTotal);
	divDatosPersonales.appendChild(botonResumen);
	divPaso3.append(divDatosPersonales);
}

async function reservarCita() {
	// Desestructurando el objeto Cita y tomando ids de los servicios
	const { idUsuario, nombre, fecha, hora, servicios } = cita;
	const serviciosId = servicios.map((servicio) => servicio.id);
    // console.log(serviciosId);
    
	// Agregando la información de SBY a un obj formData
	const formData = new FormData();
	formData.append("usuarioId", idUsuario);
	formData.append("nombre", nombre);
	formData.append("fecha", fecha);
	formData.append("hora", hora);
	formData.append("servicios", serviciosId);

	try {
		// Enviando el obj formData en el body de la peticion post a api/citas
		const urlCitas = "/api/citas";
		const respCita = await fetch(urlCitas, {
			method: "POST",
			body: formData,
		});
		const dataCita = await respCita.json();
		// console.log(dataCita);
		//Validando si el registro fue guardado en la base de datos
		if (dataCita.resultado) {
			Swal.fire({
				icon: "success",
				title: "Cita Agendada",
				text: "Tu cita fue agendada correctamente.",
			}).then(() => {
				window.location.reload();
			}, 1000);
		}
	} catch (error) {
		Swal.fire({
			icon: "error",
			title: "Error...",
			text: "Ocurrió un problema al agendar tu cita.",
			footer: '<a href="#">Why do I have this issue?</a>',
		});
	}
}

function sendAlert(tipo, mensaje, element = ".formulario", desaparece = true) {
	// Verificar que no existan alertas
	if (document.querySelector(".alerta")) {
		document.querySelector(".alerta").remove();
	}

	// Crear el elemento html de la alerta
	const alertaHtml = document.createElement("DIV");
	alertaHtml.classList.add("alerta");
	alertaHtml.classList.add(tipo);
	alertaHtml.textContent = mensaje;

	// Agregar html de alerta al form
	const formHtml = document.querySelector(element);
	formHtml.appendChild(alertaHtml);

	// Eliminar la alerta despues de 3 segundos
	if (desaparece) {
		setTimeout(() => {
			alertaHtml.remove();
		}, 3000);
	}
}
