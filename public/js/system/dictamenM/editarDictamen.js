/*cambios en fecha de dictamen*/
var fechaDictamen = document.getElementById('id_fecha_dictamen')
fechaDictamen.addEventListener('change', changeFecha)

function changeFecha() {
    const meses = ['-', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
    let fecha = fechaDictamen.value.split('-')
    document.getElementById('id_dia_footer').value = fecha[2]
    document.getElementById('id_mes_footer').value = meses[parseInt(fecha[1])]
    document.getElementById('id_anio_footer').value = fecha[0]
}
changeFecha()

/*cambio en la instancia a la que es remitido*/
function changeInstancia() {
    document.getElementById('id_instancia_e').value = document.getElementById('id_instancia_1').textContent
}
changeInstancia()

/*solo números*/
function soloNumeros(e) {
    tecla = (document.all) ? e.keyCode : e.which;

    // Patron de entrada, en este caso solo acepta numeros
    patron = /[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}

/*Padece enfermedad y toma medicamentos*/
var padecePanel = document.getElementById('id_enfermedades_padece_panel')

function changePadeceEnfermedades(e) {
    if (e.target.id == 'id_enf_pad_1') {
        padecePanel.classList.remove("mi_hide");
        document.getElementById('id_enfermedades_padece').disabled = false
    } else {
        padecePanel.classList.add("mi_hide");
        document.getElementById('id_enfermedades_padece').disabled = true
    }
}

var tomaMedPanel = document.getElementById('id_toma_medicamentos_panel')

function changeTomaMedic(e) {
    if (e.target.id == 'id_medic_1') {
        tomaMedPanel.classList.remove("mi_hide");
        document.getElementById('id_toma_medicamentos').disabled = false
    } else {
        tomaMedPanel.classList.add("mi_hide");
        document.getElementById('id_toma_medicamentos').disabled = true
    }
}

/*consumió alguna sustancia?*/
var consumioPanel = document.getElementById('id_consumio_panel')

function changeConsumio(e) {
    if (e.target.id == 'id_consumio_1') {
        consumioPanel.classList.remove("mi_hide");
        document.getElementById('id_sustancia_1').disabled = false
        document.getElementById('id_sustancia_2').disabled = false
        document.getElementById('id_sustancia_3').disabled = false
        document.getElementById('id_fecha_consumo').disabled = false
        document.getElementById('id_hora_consumo').disabled = false
        document.getElementById('id_cantidad_consumida').disabled = false
    } else {
        consumioPanel.classList.add("mi_hide");
        document.getElementById('id_sustancia_1').disabled = true
        document.getElementById('id_sustancia_2').disabled = true
        document.getElementById('id_sustancia_3').disabled = true
        document.getElementById('id_fecha_consumo').disabled = true
        document.getElementById('id_hora_consumo').disabled = true
        document.getElementById('id_cantidad_consumida').disabled = true

    }
}