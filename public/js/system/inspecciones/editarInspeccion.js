$(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
    /*solo números*/
function soloNumeros(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    // Patron de entrada, en este caso solo acepta numeros
    patron = /[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}

//chackboxes persona y vehículo
var check_persona = document.getElementById('id_check_persona')
var check_vehiculo = document.getElementById('id_check_vehiculo')

check_persona.addEventListener('change', function() {
    document.getElementById('id_edit_p_mode').classList.add('mi_hide');
    document.getElementById('id_edit_persona').classList.add('mi_hide');
    document.getElementById('id_add_persona').classList.remove('mi_hide');
    limpiarPersonaCampos();

    if (this.checked) {
        document.getElementById('error_inspeccion_a').textContent = '' //se borra msj de error
        document.getElementById('id_nombre').disabled = false
        document.getElementById('id_ap_paterno').disabled = false
        document.getElementById('id_ap_materno').disabled = false
        document.getElementById('id_alias').disabled = false
        document.getElementById('id_fecha_nacimiento').disabled = false
        document.getElementById('id_add_persona').disabled = false
        document.getElementById('id_edit_persona').disabled = false
        document.getElementById('id_persona_table').classList.remove('mi_hide');
    } else {
        if (!check_vehiculo.checked) { //si muestra error si no se elije al menos una opción
            document.getElementById('error_inspeccion_a').textContent = 'Elije al menos una opción (persona y/o vehículo)'
        }
        document.getElementById('id_nombre').disabled = true
        document.getElementById('id_ap_paterno').disabled = true
        document.getElementById('id_ap_materno').disabled = true
        document.getElementById('id_alias').disabled = true
        document.getElementById('id_fecha_nacimiento').disabled = true;
        document.getElementById('id_add_persona').disabled = true;
        document.getElementById('id_edit_persona').disabled = true;
        document.getElementById('id_persona_table').classList.add('mi_hide');
        document.getElementById('id_error_p_mode').classList.add('mi_hide');
    }
});

check_vehiculo.addEventListener('change', function() {
    if (this.checked) {
        document.getElementById('error_inspeccion_a').textContent = '' //se borra msj de error
        document.getElementById('id_marca').disabled = false
        document.getElementById('id_submarca').disabled = false
        document.getElementById('id_tipo').disabled = false
        document.getElementById('id_color').disabled = false
        document.getElementById('id_modelo').disabled = false
        document.getElementById('id_placas').disabled = false
        document.getElementById('id_niv_vehiculo').disabled = false
        document.getElementById('id_colocacion_1').disabled = false
        document.getElementById('id_colocacion_2').disabled = false
        document.getElementById('id_colocacion_3').disabled = false
    } else {
        if (!check_persona.checked) { //si muestra error si no se elije al menos una opción
            document.getElementById('error_inspeccion_a').textContent = 'Elije al menos una opción (persona y/o vehículo)'
        }
        document.getElementById('id_marca').disabled = true
        document.getElementById('id_modelo').disabled = true
        document.getElementById('id_placas').disabled = true
        document.getElementById('id_submarca').disabled = true
        document.getElementById('id_tipo').disabled = true
        document.getElementById('id_color').disabled = true
        document.getElementById('id_niv_vehiculo').disabled = true
        document.getElementById('id_colocacion_1').disabled = true
        document.getElementById('id_colocacion_2').disabled = true
        document.getElementById('id_colocacion_3').disabled = true
    }
});

/*------------------------CARGAR GRUPOS------------------------*/
var grupo_select = document.getElementById('id_grupo')
var zonas_sectores = document.getElementById('id_zona_sector')


grupo_select.addEventListener('change', getZonasSectores)

function getZonasSectores() {
    var myform = new FormData()
    myform.append('grupo', grupo_select.value)

    fetch(base_url_js + 'Inspecciones/getZonaSector', {
            method: 'POST',
            body: myform
        })
        .then(function(response) {
            if (response.ok) {
                return response.json()
            } else {
                throw 'Error en response.json'
            }
        })
        .then(function(myJson) {
            zonas_sectores.innerHTML = myJson.zonas_sectores
        })
        .catch(function(err) {
            console.log("Exception: " + err)
        })
}


/*---------------------CARGAR FILES DE IMÁGENES---------------------*/
var imagesOldInspecciones = []
var imagesOldInspecciones2 = []
    //var ind_aux_old_img = 1


document.addEventListener("DOMContentLoaded", function(event) {
    const id_inspeccion_img = document.getElementById('id_inspeccion').value
    preLoadImagesInspeccion(id_inspeccion_img)
});

function preLoadImagesInspeccion(id_inspeccion) {
    var formdata = new FormData()
    formdata.append("Id_Inspeccion", id_inspeccion)

    fetch(base_url_js + 'Inspecciones/getImagesFetch', {
            method: 'POST',
            body: formdata
        })
        .then((response) => {
            if (response.ok)
                return response.json()
            else
                throw 'Error response.json'
        })
        .then((myJson) => {
            // console.log(myJson)
            if (myJson.status) {
                var image_input = document.getElementById('fileInspecciones')
                myJson.images.forEach((element, index, array) => {
                    imagesOldInspecciones.push({
                            'id': element.Id_Imagen_I,
                            'Path_Imagen': element.Path_Imagen
                        })
                        //se guarda otra copia para comparar los ids en el controlador
                    imagesOldInspecciones2.push({
                        'id': element.Id_Imagen_I,
                        'Path_Imagen': element.Path_Imagen
                    })
                    const src = base_url_js + "public/files/inspecciones/images/" + id_inspeccion + "/" + element.Path_Imagen
                    createElementInspeccionesOld(src, element.Id_Imagen_I); //se manda la img y el id del ultimo item
                    //ind_aux_old_img++
                })

            }
            // console.log(imagesOldInspecciones)
        })
        .catch((error) => {
            // console.log('Error catch: ' + error)
        })
}

/*---------------FUNCIONES PARA GESTION DE IMG OLD---------------*/
const createElementInspeccionesOld = (src, id_item) => {
    const contenedor = document.getElementById('photos-content-inspecciones'),
        newElement = document.createElement('div'),
        div = document.createElement('div'),
        spanDelete = document.createElement('span'),
        iconDelete = document.createTextNode('x'),
        img = document.createElement('img'),
        file = document.getElementById('fileInspecciones');

    spanDelete.appendChild(iconDelete);
    spanDelete.setAttribute('onclick', 'deleteItemFromInspeccionesFilesOld(' + id_item + ')');
    spanDelete.setAttribute('class', 'deleteFile');
    div.appendChild(spanDelete);
    img.src = src;
    div.setAttribute('class', 'd-flex justify-content-end');
    img.setAttribute('class', 'img-fluid');
    newElement.appendChild(div);
    newElement.appendChild(img);
    newElement.setAttribute('class', 'col-sm-3 px-2');
    newElement.setAttribute('id', 'image_old' + id_item);
    contenedor.appendChild(newElement);
    file.value = '';
}

function deleteItemFromInspeccionesFilesOld(id_item) {
    document.getElementById('image_old' + id_item).remove()
    var ind = -1
        //se busca el index del elemento que continen el id especificado
    imagesOldInspecciones.forEach((element, index, array) => {
            if (element['id'] == id_item)
                ind = index
        })
        //se borra el item seleccionado de la lista de files de inspecciones
    imagesOldInspecciones.splice(ind, 1)

    //console.log("---------------------")
    //imagesOldInspecciones.forEach((element,index,array) => {
    //    console.log("queda id: "+element['id']+" -- name: "+element['Path_Imagen'])
    //})
}

window.onload = function() {

    let online = window.navigator.onLine;
    if (!online) {
        offlineMapsInspeccion();
    }

    cargarPersonasArray();
};

//funcion para precargar las personas inspeccionadas si es que existen
function cargarPersonasArray() {
    // console.log(document.getElementById('id_inspeccion').value);
    let myForm = new FormData();
    myForm.append('Id_Inspeccion', document.getElementById('id_inspeccion').value);
    fetch(base_url_js + "Inspecciones/getPersonasArrayFetch", {
            method: 'POST',
            body: myForm
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw "Excepcion en response.ok";
            }
        })
        .then(personasFetch => {

            // console.log(myJson);
            if (personasFetch.length > 0) {
                // console.log("eureka");
                personasFetch.forEach(elem => {
                        personasArray.push({
                            Id: numPersonas,
                            Nombre: elem.Nombre.toUpperCase(),
                            Ap_Paterno: elem.Ap_Paterno.toUpperCase(),
                            Ap_Materno: elem.Ap_Materno.toUpperCase(),
                            Alias: elem.Alias.toUpperCase(),
                            Fecha_Nacimiento: elem.Fecha_Nacimiento
                        })

                        let row = personaTable.insertRow(personaTable.rows.length);
                        row.id = "auxPer_" + numPersonas;
                        //se agrega la info a la tabla
                        row.insertCell(0).innerHTML = `${elem.Nombre.toUpperCase()} ${elem.Ap_Paterno.toUpperCase()} ${elem.Ap_Materno.toUpperCase()}`;
                        row.insertCell(1).innerHTML = `${elem.Alias.toUpperCase()}`;
                        row.insertCell(2).innerHTML = `${elem.Fecha_Nacimiento}`;
                        let auxOp = row.insertCell(3);
                        auxOp.className = 'sticky_field';
                        auxOp.innerHTML = createHtmlOperaciones(numPersonas);

                        numPersonas++
                    })
                    // console.log(personasArray);
            } else {
                document.getElementById('id_persona_table').classList.add('mi_hide');
            }
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })
        })
        .catch(err => console.log(err))
}