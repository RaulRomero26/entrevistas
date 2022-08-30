$(function() {
    $('[data-toggle="tooltip"]').tooltip(
    		{
    			delay: { "show": 200, "hide": 100 }
    		}
    	)
})

$(function () {
  $('[data-toggle="popover"]').popover()
})

//document.addEventListener("DOMContentLoaded", function(event) {
	var search2 = document.getElementById('id_search2')
	var filtroActual2 = document.getElementById('filtroActual2')
	var search_button2 = document.getElementById('search_button2')

	search_button2.addEventListener('click', buscarSVCad)


	function buscarSVCad(e) {
		//if (search.value != "") {
		var myform2 = new FormData()
		myform2.append("cadena2", search2.value)
		myform2.append("filtroActual2", filtroActual2.value)
		console.log("Buscar es: " + search2.value)
		console.log("Filtro actual #2 es: " + filtroActual2.value)
		//console.log("Myform2: " + myform2.value)	

		fetch(base_url_js+'Seguimientos/buscarSVPorCadena', {
				method: 'POST',
				body: myform2
			})
			.then(function(response) {
				if (response.ok) {
					//muestra los errores, anteriormente estaba como response.json();
					return response.json()
				} else {
					throw "Error en la llamada Ajax";
				}
			})
			.then(function(myJson2) {
				//console.log("Respuesta 2\n"+JSON.stringify(myJson2))
				//console.log("Respuesta 2\n"+JSON.stringify(myJson2.response))
				if (!(typeof(myJson2) == 'string')) {
					document.getElementById('id_header2').innerHTML = myJson2.infoTable2.header
					document.getElementById('id_tbody2').innerHTML = myJson2.infoTable2.body
					document.getElementById('id_pagination2').innerHTML = myJson2.links2
					//document.getElementById('id_link_csv2').href = myJson2.export_links.csv
					document.getElementById('id_link_excel2').href = myJson2.export_links2.excel
					document.getElementById('id_link_pdf2').href = myJson2.export_links2.pdf
					document.getElementById('id_total_rows2').innerHTML = myJson2.total_rows2
					document.getElementById('id_dropdownColumns2').innerHTML = myJson2.dropdownColumns2
					var columnsNames6 = document.querySelectorAll('th')
					columnsNames6.forEach(function(element, index, array){
						if (element.className.match(/c2olumn.*/))
							hideShowColumn2(element.className)
					  });
					//console.log(myJson2)
				} else {
					console.log("myJson2: " + myJson2)
				}
				$('[data-toggle="popover"]').popover()

			})
			.catch(function(error) {
				//console.log("myJson2: " + myJson2)
				console.log("Error desde Catch _  " + error)
			})
		//}

	}

	function checarCadena2(e) {
		if (search2.value == "") {
			buscarSVCad()
		}
	}
	//});

	function aplicarRangos2(){
	//obtener cada valor de la fecha
	var rango_inicio = document.getElementById('id_date_21').value
	var rango_fin = document.getElementById('id_date_22').value
	//comprobar si ya seleccionó una fecha
	if (rango_inicio != '' && rango_fin != '') {
		let fecha1 = new Date(rango_inicio);
		let fecha2 = new Date(rango_fin)

		let resta = fecha2.getTime() - fecha1.getTime()
		//console.log("resta = "+resta)
		if(resta >= 0){	//comprobar si los rangos de fechas son correctos
			document.getElementById('form_rangos2').submit()
		}
		else{
			//caso de elegir rangos erroneos
			//console.log("Elige intervalos correctos")
			alert("Elige intervalos correctos")
		} 
	}
	else {
		//caso de no ingresar aún nada
		//console.log("Te falta knalito")
		alert("Selecciona primero los rangos")
	}
}

function hideShowColumn2(col_name)
{	
	var myform2 = new FormData() //form para actualizar la session variable
		myform2.append('columName2',col_name) //se asigna el nombre de la columna a cambiar

	var checkbox_val=document.getElementById(col_name).value;
	if(checkbox_val=="hide"){
		var all_col=document.getElementsByClassName(col_name);
		for(var i=0;i<all_col.length;i++){
		   	all_col[i].style.display="none";
		}
		//document.getElementById(col_name+"_head").style.display="none";
		document.getElementById(col_name).value="show";
		myform2.append('valueColumn2','hide') //se asigna la acción (hide or show)
	}
		
	else{
		var all_col=document.getElementsByClassName(col_name);
		for(var i=0;i<all_col.length;i++){
			all_col[i].style.display="table-cell";
		}
		//document.getElementById(col_name+"_head").style.display="table-cell";
		document.getElementById(col_name).value="hide";
		myform2.append('valueColumn2','show') //se asigna la acción (hide or show)
	}
	//se actualiza la session var para las columnas cambiadas
	fetch(base_url_js+'Seguimientos/setColumnFetchSV', {
			method: 'POST',
			body: myform2
		})
	.then(function(response){
		if (response.ok) {
			return response.json()
		}
		else{
			throw "Error en la llamada fetch"
		}
	})
	.then(function(myJson2){
		//console.log(myJson2)
	})
	.catch(function(error){
		console.log("catch: "+error)
	})
}

function hideShowAll2(){
	const valueCheckAll = document.getElementById('checkAll2').value //valor actual del check todos
	var checkBoxes = document.querySelectorAll('.checkColumns2') //se obtiene los checks de las columnas del filtro actual
	//se convierte todo a hide o todo a show ademas de desmarcar o marcar todos los checked
	if (valueCheckAll === 'hide') {
		checkBoxes.forEach(function(element,index,array){
			if (element.value = 'show') {
				element.value = 'hide'
				element.checked = false
			}
		})
		document.getElementById('checkAll2').value = 'show'
	}
	else{
		checkBoxes.forEach(function(element,index,array){
			if (element.value = 'hide') {
				element.value = 'show'
				element.checked = true
			}
		})
		document.getElementById('checkAll2').value = 'hide'
	}
	
	//se procede a mostrar u ocultar todo
	var columnsNames4 = document.querySelectorAll('th')
	columnsNames4.forEach(function(element, index, array){
		if (element.className.match(/c2olumn.*/))
			hideShowColumn2(element.className)
	  });
}

var columnsNames5 = document.querySelectorAll('th')
	columnsNames5.forEach(function(element, index, array){
		if (element.className.match(/c2olumn.*/))
			hideShowColumn2(element.className)
	  });