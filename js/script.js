var indFilaForm = 4; //Indice de posición de la fila en la tabla

//Llega como parámetro 'cantidad'
function crearCampos(cantidad) {

	for (var i = 1, cantidad = Number(cantidad); i <= cantidad; i++) {
		//para el elemento 'datos'insertar fila en la cuarta posición 
		myNewRow = document.getElementById("datos").insertRow(-1);
		myNewRow.id = indFilaForm;
		//Insertar 'celda'o componente en fila nueva. Corresponde a #orden
		myNewCell = myNewRow.insertCell(-1);
		myNewCell.innerHTML = "<td>" + indFilaForm + "</td>";
		//Insertar 'celda'o componente en fila nueva. Corresponde a titulo de la columna
		myNewCell = myNewRow.insertCell(-1);
		myNewCell.innerHTML = "<td><input type='text' id='nom_campo" + indFilaForm + "' name='nom_campo" + indFilaForm + "' placeholder='Nombre del campo' onkeypress='return sinEspacio(event)'></td>";
		////Insertar 'celda'o componente en fila nueva. Corresponde a tipo de dato
		myNewCell = myNewRow.insertCell(-1);
		myNewCell.innerHTML = "<td>" +
			"<select id='tipo_dato" + indFilaForm + "' name='tipo_dato" + indFilaForm + "'>" +
			"<!-- <option value='' selected='selected' disabled='disabled'>Selecciona una opción</option> -->" +
			"<optgroup label='Datos personales'>" +
			"<option value='nom_h'>Nombre hombre</option>" +
			"<option value='nom_m'>Nombre mujer</option>" +
			"<option value='app_pat'>Apellido paterno</option>" +
			"<option value='app_mat'>Apellido materno</option>" +
			"</optgroup>" +
			"<optgroup label='Contacto'>" +
			"<option value='email'>Email</option>" +
			"<option value='telefono'>Teléfono</option>" +
			"<option value='password'>Contraseña</option>" +
			"</optgroup>" +
			"<optgroup label='Direcciones'>" +
			"<option value='localidad'>Localidad</option>" +
			"<option value='municipio'>Municipio</option>" +
			"<option value='estado'>Estado</option>" +
			"</optgroup>" +
			"</select>" +
			"</td>";
		//Insertar 'celda'o componente en fila nueva. Corresponde a la opción eliminar fila de
		//la tabla 'datos'
		myNewCell = myNewRow.insertCell(-1);
		myNewCell.innerHTML = "<td><input type='button' class='btn-danger' value='Eliminar' onclick='removeElem(this)'></td>";
		//incremento en el índice de posiciónes en la tabla 'datos' 
		indFilaForm++;
	}
}
//Función javascript que elimina columnas (filas) dela tabla Datos
function removeElem(obj) {
	var oTr = obj;
	while (oTr.nodeName.toLowerCase() != 'tr') {
		oTr = oTr.parentNode;
	}
	//Root representa al nodo padre
	//La función removeChild() requiere como parámetro el nodo que se va a eliminar.
	// Además, esta función debe ser invocada desde el elemento padre de ese nodo que se quiere eliminar. 
	// La forma más segura y rápida de acceder al nodo padre de un elemento es mediante la propiedad nodoHijo.parentNode.
	var root = oTr.parentNode;
	root.removeChild(oTr);
}

function sinEspacio(event) { 
	var key = window.Event ? event.which : event.keyCode;
	if (key == 32) {
		return false;
	} else {
		return true;
	}
} 

/** Validacion de solo numeros **/
function isInteger(event) {
	var key = window.Event ? event.which : event.keyCode;
	if ((key >= 48 && key <= 57) || (key == 8)) {
		return true;
	} else {
		return false;
	}
}

//Validación del formulario en caso que el nombre de la nueva bdd quede vacío, el # de registros
//O el nombre de columna queden vacíos
function validarForm() {
	var frm = document.getElementById("frm_gd");

	var ns = document.getElementById("nom_archivo").value;
	var nt = document.getElementById("nom_tabla").value;
	var nf = document.getElementById("num_filas").value;

	// Verificamos que haya algo escrito en el input y que no contenga caracteres especiales, solo son validos los guiones bajos
	if (ns == null || ns.length == 0 || /^\s+$/.test(ns) || !/^[a-zA-Z0-9]|_+$/.test(ns)) {
		document.getElementById("nom_archivo").setAttribute('class', 'requerido');
		document.getElementById("nom_archivo").focus();
	} // Verificamos que haya algo escrito en el input y que no contenga caracteres especiales, solo son validos los guiones bajos
	else if (nt == null || nt.length == 0 || /^\s+$/.test(nt) || !/^[a-zA-Z0-9]|_+$/.test(nt)) {
		document.getElementById("nom_tabla").setAttribute('class', 'requerido');
		document.getElementById("nom_archivo").removeAttribute('class');
		document.getElementById("num_filas").removeAttribute('class');
		document.getElementById("nom_tabla").focus();
	} // Verificamos que haya algo escrito en el input y que no contenga caracteres especiales, solo son validos los guiones bajos
	else if (nf == null || nf.length == 0 || /^\s+$/.test(nf) || !/^[0-9]+$/.test(nf)) {
		document.getElementById("num_filas").setAttribute('class', 'requerido');
		document.getElementById("nom_archivo").removeAttribute('class');
		document.getElementById("nom_tabla").removeAttribute('class');
		document.getElementById("num_filas").focus();
	} // Validacion de los campos dinamicos
	else if (validaDinam() != false) {
		error_gen.innerHTML = "*** Parece que no has llenado los campos válidos, si no usas todos los campos eliminalos";
		error_gen.setAttribute("style", "display: block; color: red; font-size: 11pt; font-weight: bold;");
	} // validacion para campos, es decir que haya algun campo para generar la tabla
	else if (contartr() == 0) {
		error_gen.innerHTML = "¡¡¡¡ Inserta algunas filas para poder generar tu archivo !!!!";
		error_gen.setAttribute("style", "display: block; color: red; font-size: 11pt; font-weight: bold;");
	} else { // Envio del formulario
		frm.submit();
		frm.reset();
	}
}

/**
 * [contartr Funcion que sirve para contar las filas de los campos dinamicos]
 * @return {[contador]} [Numero de filas que hay dinamicamente]
 */
function contartr() {
	var tReg = document.getElementById('datos');
	var contador = 0;
	var cellsOfRow = "";
	var compareWith = "";
	// Recorremos todas las filas con contenido de la tabla
	for (var i = 1; i < tReg.rows.length; i++) {
		cellsOfRow = tReg.rows[i].getElementsByTagName('td');
		// Recorremos todas las celdas
		for (var j = 0; j < cellsOfRow.length; j++) {
			contador++;
			break;
		}
	}
	return contador;
}

/**
 * [validaDinam Valida que los campos dinamicos tengan un valor]
 * @return {[found]} [Valor de retorno que expresa si hay valores invalidos ('false==OK', 'true==Valores invalidos')]
 */
function validaDinam() {
	var tableReg = document.getElementById('datos');
	var cellsOfRow = "";
	var compareWith = "";
	var found = false;
	// Recorremos todas las filas con contenido de la tabla
	for (var i = 1; i < tableReg.rows.length; i++) {
		cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
		found = false;
		// Recorremos todas las celdas
		for (var j = 0; j < cellsOfRow.length && !found; j++) {
			// Buscamos el input en el contenido de la celda
			nomcam = document.getElementById("nom_campo" + cellsOfRow[j].innerHTML).value;
			// Verificamos que haya algo escrito en el input y que no contenga caracteres especiales, solo son validos los guiones bajos
			if (nomcam == null || nomcam.length == 0 || /^\s+$/.test(nomcam) || !/^[a-zA-Z0-9]|_+$/.test(nomcam)) {
				document.getElementById("nm_arc").setAttribute("style", "display: none;");
				document.getElementById("nm_tab").setAttribute("style", "display: none;");
				document.getElementById("num_f").setAttribute("style", "display: none;");
				document.getElementById("nom_archivo").removeAttribute('class');
				document.getElementById("nom_tabla").removeAttribute('class');
				document.getElementById("num_filas").removeAttribute('class');
				document.getElementById("nom_campo" + cellsOfRow[j].innerHTML).setAttribute('class', 'requerido');
				document.getElementById("nom_campo" + cellsOfRow[j].innerHTML).focus();
				found = true;
			} else {
				document.getElementById("nom_campo" + cellsOfRow[j].innerHTML).removeAttribute('class');
			}
			break;
		}
		// Si se ha encontrado un campo vacio dinamico se detiene el bucle para corregir este campo
		if (found) {
			break;
		} else { // En el caso contrario continua buscando mas errores 
			continue;
		}
	}
	return found;
}