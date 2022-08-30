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
        document.getElementById('id_nombre').disabled = true;
        document.getElementById('id_ap_paterno').disabled = true;
        document.getElementById('id_ap_materno').disabled = true;
        document.getElementById('id_alias').disabled = true;
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

//se cargan los primeros valores de zonas y sectores
getZonasSectores()

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

window.onload = function() {

    let online = window.navigator.onLine;
    if (!online) {
        offlineMapsInspeccion();
    }
};