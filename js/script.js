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
			"<option value='emai'>Email</option>" +
			"<option value='telefon'>Teléfono</option>" +
			"<option value='usr'>Usuario</option>" +
			"<option value='passwd'>Contraseña</option>" +
			"</optgroup>" +
			"<optgroup label='Direcciones'>" +
			"<option value='lcld'>Localidad</option>" +
			"<option value='munic'>Municipio</option>" +
			"<option value='estd'>Estado</option>" +
			"<option value='paisW'>País</option>" +
			"</optgroup>" +
			"<optgroup label='Numérico'>" +
			"<option value='ai'>AutoIncrementable</option>" +
			"<option value='intale'>Entero aleatorio</option>" +
			"<option value='dal'>Decimal aleatorio</option>" +
			"<option value='mondin'>Dinero ($)</option>" +
			"<option value='matric'>Matrícula</option>" +
			"<option value='calif'>Calificación</option>" +
			"<option value='fecDate'>Fecha aleatoria</option>" +
			"<option value='houDate'>Hora aleatoria</option>" +
			"</optgroup>" +
			"<optgroup label='Escuela'>"+
			"<option value='tipoal'>Tipo Alumno</option>"+
			"<option value='profr'>Profesor</option>"+
			"<option value='mat'>Materia</option>"+
			"<option value='trabEsc'>Trabajos</option>"+
			"<option value='groupEsc'>Grupo</option>"+
			"<option value='perEsc'>Periodo</option>"+
			"<option value='parcEsc'>Parcial</option>"+
			"<option value='clf'>Calificación (en letra)</option>"+
			"<option value='escEsc'>Escuela</option>"+
			"<option value='asis'>Asistencia</option>"+
			"<option value='salonEsc'>Salón</option>"+
			"</optgroup>"+
			"<optgroup label='Hospital'>"+
			"<option value='crg'>Cargo</option>"+
			"<option value='templ'>Tipo Empleado</option>"+
			"<option value='depnd'>Dependencia</option>"+
			"<option value='tper'>Permiso</option>"+
			"<option value='obsr'>Observación Médica</option>"+
			"<option value='ttrat'>Tipo Tratamiento</option>"+
			"<option value='texm'>Tipo Examen Médico</option>"+
			"<option value='dta'>Dieta</option>"+
			"<option value='decta'>Descripción cuenta</option>"+
			"<option value='dechp'>Descripción Hospital</option>"+
			"<option value='descfmp'>Descripción Forma de Pago</option>"+
			"<option value='fmp'>Forma de pago</option>"+
			"</optgroup>"+
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

	var ns = document.getElementById("nom_archivo");
	var nt = document.getElementById("nom_tabla");
	var nf = document.getElementById("num_filas");

	if (ns.value == null || ns.value.length == 0 || /^\s+$/.test(ns.value) || !/^[a-zA-Z0-9]|_+$/.test(ns.value)) {
		showMessage("Escribe un nombre para tu archivo.", ns.id);
	}
	else if (nt.value == null || nt.value.length == 0 || /^\s+$/.test(nt.value) || !/^[a-zA-Z0-9]|_+$/.test(nt.value)) {
		showMessage("Escribe un nombre para la tabla.", nt.id);
	}
	else if (nf.value == null || nf.value.length == 0 || /^\s+$/.test(nf.value) || !/^[0-9]+$/.test(nf.value)) {
		showMessage("Escribe el numero de filas a realizar.", nf.id);
	}
	else if (validaDinam() != false) {
        showMessage("Parece que no has llenado los campos válidos, si no usas todos los campos eliminalos", 'null');
	}
	else if (contartr() == 0) {
        showMessage("¡¡¡¡ Inserta algunas filas para poder generar tu archivo !!!!", "null");
	}
    else { // Envio del formulario
		frm.submit();
//		frm.reset();
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

function showMessage(status, id){

    var window = document.getElementById('result');
    var cont = document.getElementById('contenido');
    
    if (cont) window.removeChild(cont);
    
    var h2 = document.createElement('h2');
    h2.innerHTML='Información';
    h2.setAttribute('id','pTitulo');
    
    var mensaje = status;
        
    var p1 = document.createElement('p');
    p1.innerHTML = mensaje;
    p1.setAttribute('id','pMens');
    var br = document.createElement('br');
    p1.appendChild(br);
    
    var buttonR = document.createElement('input');
    buttonR.setAttribute('type', 'button');
    buttonR.setAttribute('value', 'Regresar');
    buttonR.setAttribute('onclick', 'closeDivError(\''+id+'\')');

    var div = document.createElement('div');
    var br = document.createElement('br');
    div.appendChild(br);
    div.setAttribute('id','pBoton');
    div.appendChild(buttonR);
    
    var section = document.createElement('section');
    section.setAttribute('id','contenido');
    section.appendChild(h2);
    section.appendChild(p1);
    section.appendChild(div);
    window.appendChild(section);

    window.style.display = 'block';

    var window_width = window.offsetWidth;
    var window_height = window.offsetHeight;

    window.style.marginLeft = '-' + Math.round(window_width/2) + 'px';
    window.style.marginTop = '-' + Math.round(window_height/2) + 'px';
    return true;
}
function closeDivError(id){
    var window = document.getElementById('result');
    window.innerHTML = '';
    window.style.display = 'none';
    console.log(id);
    if(id != 'null' || id == 'undefined'){
        var idf = document.getElementById(id);
        idf.focus(); 
    }
}