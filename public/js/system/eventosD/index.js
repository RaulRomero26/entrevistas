$(function() {
    $('[data-toggle="tooltip"]').tooltip()
})

//document.addEventListener("DOMContentLoaded", function(event) {
var search = document.getElementById('id_search')
var filtroActual = document.getElementById('filtroActual')
var search_button = document.getElementById('search_button')


search_button.addEventListener('click', buscarEventosCad)

function buscarEventosCad(e) {
	var myform = new FormData()
	myform.append("cadena", search.value)
	myform.append("filtroActual", filtroActual.value)
	/*la direción relativa con Fetch es con base en la url actual por eso se coloca ../ vamos a una rama abajo de la URL*/
	fetch(base_url_js+'EventosDelictivos/buscarPorCadena', {
		method: 'POST',
		body: myform
	})
	.then(function(response) {
		if (response.ok) {
			return response.json()
		} else {
			throw "Error en la llamada Ajax";
		}
	})
	.then(function(myJson) {
		if (!(typeof(myJson) == 'string')) {
			document.getElementById('id_tbody').innerHTML = myJson.infoTable.body
			document.getElementById('id_thead').innerHTML = myJson.infoTable.header
			document.getElementById('id_pagination').innerHTML = myJson.links
			//document.getElementById('id_link_csv').href = myJson.export_links.csv
			document.getElementById('id_link_excel').href = myJson.export_links.excel
			document.getElementById('id_link_pdf').href = myJson.export_links.pdf
			document.getElementById('id_total_rows').innerHTML = myJson.total_rows
			document.getElementById('id_dropdownColumns').innerHTML = myJson.dropdownColumns
			var columnsNames3 = document.querySelectorAll('th')
				columnsNames3.forEach(function(element, index, array){
					if (element.className.match(/column.*/))
						hideShowColumn(element.className)
					});
		} else {
			console.log("myJson: " + myJson)
		}

	})
	.catch(function(error) {
		console.log("Error desde Catch _  " + error)
	})
}

function checarCadena(e) {
	if (search.value == "") {
		buscarEventosCad()
	}
}

function aplicarRangos(){
	//obtener cada valor de la fecha
	var rango_inicio = document.getElementById('id_date_1').value
	var rango_fin = document.getElementById('id_date_2').value
	//comprobar si ya seleccionó una fecha
	if (rango_inicio != '' && rango_fin != '') {
		let fecha1 = new Date(rango_inicio);
		let fecha2 = new Date(rango_fin)

		let resta = fecha2.getTime() - fecha1.getTime()
		if(resta >= 0){	//comprobar si los rangos de fechas son correctos
			document.getElementById('form_rangos').submit()
		}
		else{
			//caso de elegir rangos erroneos
			alert("Elige intervalos correctos")
		} 
	}
	else {
		//caso de no ingresar aún nada
		alert("Selecciona primero los rangos")
	}
}

function hideShowColumn(col_name)
{	
	var myform = new FormData() //form para actualizar la session variable
		myform.append('columName',col_name) //se asigna el nombre de la columna a cambiar

	var checkbox_val=document.getElementById(col_name).value;
	if(checkbox_val=="hide"){
		var all_col=document.getElementsByClassName(col_name);
		for(var i=0;i<all_col.length;i++){
		   	all_col[i].style.display="none";
		}
		document.getElementById(col_name).value="show";
		myform.append('valueColumn','hide') //se asigna la acción (hide or show)
	}
		
	else{
		var all_col=document.getElementsByClassName(col_name);
		for(var i=0;i<all_col.length;i++){
			all_col[i].style.display="table-cell";
		}
		document.getElementById(col_name).value="hide";
		myform.append('valueColumn','show') //se asigna la acción (hide or show)
	}
	//se actualiza la session var para las columnas cambiadas
	fetch(base_url_js+'EventosDelictivos/setColumnFetch', {
			method: 'POST',
			body: myform
		})
	.then(function(response){
		if (response.ok) {
			return response.json()
		}
		else{
			throw "Error en la llamada fetch"
		}
	})
	.then(function(myJson){
	})
	.catch(function(error){
		console.log("catch: "+error)
	})
}

function hideShowAll(){
	const valueCheckAll = document.getElementById('checkAll').value //valor actual del check todos
	var checkBoxes = document.querySelectorAll('.checkColumns') //se obtiene los checks de las columnas del filtro actual
	//se convierte todo a hide o todo a show ademas de desmarcar o marcar todos los checked
	if (valueCheckAll === 'hide') {
		checkBoxes.forEach(function(element,index,array){
			if (element.value = 'show') {
				element.value = 'hide'
				element.checked = false
			}
		})
		document.getElementById('checkAll').value = 'show'
	}
	else{
		checkBoxes.forEach(function(element,index,array){
			if (element.value = 'hide') {
				element.value = 'show'
				element.checked = true
			}
		})
		document.getElementById('checkAll').value = 'hide'
	}
	
	//se procede a mostrar u ocultar todo
	var columnsNames = document.querySelectorAll('th')
	columnsNames.forEach(function(element, index, array){
		if (element.className.match(/column.*/))
			hideShowColumn(element.className)
	  });
}

var columnsNames2 = document.querySelectorAll('th')
	columnsNames2.forEach(function(element, index, array){
		if (element.className.match(/column.*/))
			hideShowColumn(element.className)
	  });

/* ----- ----- ----- Eliminar registro ----- ----- ----- */
const bnts_delete = document.getElementsByClassName('btn_delete_folio'),
	msgError = document.getElementById('message_index');
for(let i=0; i<bnts_delete.length;i++){
	bnts_delete[i].addEventListener('click',()=>{
		if(window.confirm('¿Seguro que desea eliminar el registro?')){
			let myFormData = new FormData();

			myFormData.append('id', bnts_delete[i].getAttribute('data-id'));

			fetch(base_url_js+'EventosDelictivos/deleteFolio',{
				method: 'POST',
				body: myFormData
			})
			.then(res=>res.json())
			.then(data =>{
				if(!data.status){
					let messageError;
					if ('error_message' in data) {
						if (data.error_message != 'Render Index') {
							if (typeof(data.error_message) != 'string') {
								messageError = `<div class="alert alert-danger text-center" role="alert">Sucedio un error en el servidor: ${data.error_message.errorInfo[2]}</div>`;
							} else {
								messageError = `<div class="alert alert-danger text-center" role="alert">Sucedio un error en el servidor: ${data.error_message}</div>`;
							}
						} else {
							messageError = `<div class="alert alert-danger text-center alert-session-create" role="alert">
									<p>Sucedio un error, su sesión caduco o no tiene los permisos necesarios. Por favor vuelva a iniciar sesión.</p>
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalLogin">
										Iniciar sesión
									</button>
								</div>`;
						}
					}
	
					msgError.innerHTML = messageError
					window.scroll({
						top: 0,
						left: 100,
						behavior: 'smooth'
					});
				}else{
					msgError.innerHTML = '<div class="alert alert-success text-center" role="alert">Registro eliminado correctamente.</div>'
					window.scroll({
						top: 0,
						left: 100,
						behavior: 'smooth'
					});
	
					setInterval(function() { location.reload(); }, 1500);
				}
			})
		}
	})
}