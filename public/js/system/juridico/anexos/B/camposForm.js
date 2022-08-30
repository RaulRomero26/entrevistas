$(function() {
    $('[data-toggle="tooltip"]').tooltip()
    $('[data-toggle="popover"]').popover()
    $('#myModal').on('shown.bs.modal', function() {
        $('#myInput').trigger('focus')
    })
})

/*--------------ALERTS------------*/
let result_alert = document.getElementById('id_result_alert')
let alert = document.getElementById('id_alert')

/*------CAMPOS PARA ASIGNAR EL CORRESPONDIENTE LISTENER-------*/
//nivel del uso de la fuerza
let num_lesionados_autoridad = document.getElementById('id_num_lesionados_autoridad')
let num_lesionados_persona = document.getElementById('id_num_lesionados_persona')
let num_fallecidos_autoridad = document.getElementById('id_num_fallecidos_autoridad')
let num_fallecidos_persona = document.getElementById('id_num_fallecidos_persona')

let reduccion_movimiento = document.getElementById('id_reduccion_movimiento')
let armas_incapacitantes = document.getElementById('id_armas_incapacitantes')
let armas_fuego = document.getElementById('id_armas_fuego')

let descripcion_conducta = document.getElementById('id_descripcion_conducta')
let asistencia_medica = document.getElementById('id_asistencia_medica')

//primer respondiente
let nombre_pr = document.getElementById('id_nombre_pr')
let ap_pat_pr = document.getElementById('id_ap_pat_pr')
let ap_mat_pr = document.getElementById('id_ap_mat_pr')
let institucion_pr = document.getElementById('id_institucion_pr')
let cargo_pr = document.getElementById('id_cargo_pr')
let no_control_pr = document.getElementById('id_no_control_pr')

// segundo respondiente
let nombre_sr = document.getElementById('id_nombre_sr')
let ap_pat_sr = document.getElementById('id_ap_pat_sr')
let ap_mat_sr = document.getElementById('id_ap_mat_sr')
let institucion_sr = document.getElementById('id_institucion_sr')
let cargo_sr = document.getElementById('id_cargo_sr')
let no_control_sr = document.getElementById('id_no_control_sr')


/*--------------------------LISTENER DE CAMPOS----------------------------*/
//nivel del uso de la fuerza
num_lesionados_autoridad.addEventListener('change', (e) => {
    const MAX_LENGTH = 25
    if (num_lesionados_autoridad.value.trim() !== '' && num_lesionados_autoridad.value.length <= MAX_LENGTH) {
        document.getElementById('error_num_lesionados_autoridad').textContent = ''
    } else if (!(num_lesionados_autoridad.value.trim() !== '')) {
        document.getElementById('error_num_lesionados_autoridad').textContent = 'Llene el campo *'
    } else if (!(num_lesionados_autoridad.value.length <= MAX_LENGTH)) {
        document.getElementById('error_num_lesionados_autoridad').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
num_lesionados_persona.addEventListener('change', (e) => {
    const MAX_LENGTH = 25
    if (num_lesionados_persona.value.trim() !== '' && num_lesionados_persona.value.length <= MAX_LENGTH) {
        document.getElementById('error_num_lesionados_persona').textContent = ''
    } else if (!(num_lesionados_persona.value.trim() !== '')) {
        document.getElementById('error_num_lesionados_persona').textContent = 'Llene el campo *'
    } else if (!(num_lesionados_persona.value.length <= MAX_LENGTH)) {
        document.getElementById('error_num_lesionados_persona').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
num_fallecidos_autoridad.addEventListener('change', (e) => {
    const MAX_LENGTH = 25
    if (num_fallecidos_autoridad.value.trim() !== '' && num_fallecidos_autoridad.value.length <= MAX_LENGTH) {
        document.getElementById('error_num_fallecidos_autoridad').textContent = ''
    } else if (!(num_fallecidos_autoridad.value.trim() !== '')) {
        document.getElementById('error_num_fallecidos_autoridad').textContent = 'Llene el campo *'
    } else if (!(num_fallecidos_autoridad.value.length <= MAX_LENGTH)) {
        document.getElementById('error_num_fallecidos_autoridad').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
num_fallecidos_persona.addEventListener('change', (e) => {
    const MAX_LENGTH = 25
    if (num_fallecidos_persona.value.trim() !== '' && num_fallecidos_persona.value.length <= MAX_LENGTH) {
        document.getElementById('error_num_fallecidos_persona').textContent = ''
    } else if (!(num_fallecidos_persona.value.trim() !== '')) {
        document.getElementById('error_num_fallecidos_persona').textContent = 'Llene el campo *'
    } else if (!(num_fallecidos_persona.value.length <= MAX_LENGTH)) {
        document.getElementById('error_num_fallecidos_persona').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})

descripcion_conducta.addEventListener('change', (e) => {
    const MAX_LENGTH = 2500
    if (descripcion_conducta.value.trim() !== '' && descripcion_conducta.value.length <= MAX_LENGTH) {
        document.getElementById('error_descripcion_conducta').textContent = ''
    } else if (!(descripcion_conducta.value.trim() !== '')) {
        document.getElementById('error_descripcion_conducta').textContent = 'Llene el campo *'
    } else if (!(descripcion_conducta.value.length <= MAX_LENGTH)) {
        document.getElementById('error_descripcion_conducta').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})

let rad_Asistencia_M = document.getElementsByName('Asistencia_Med_Radio')
for (let i = 0; i < rad_Asistencia_M.length; i++) {
    rad_Asistencia_M[i].addEventListener('change', function() {
        document.getElementById('error_asistencia_med_radio').textContent = ''
    });
}
asistencia_medica.addEventListener('change', (e) => {
    const MAX_LENGTH = 2500
    if (asistencia_medica.value.trim() !== '' && asistencia_medica.value.length <= MAX_LENGTH) {
        document.getElementById('error_asistencia_medica').textContent = ''
    } else if (!(asistencia_medica.value.trim() !== '')) {
        document.getElementById('error_asistencia_medica').textContent = 'Llene el campo *'
    } else if (!(asistencia_medica.value.length <= MAX_LENGTH)) {
        document.getElementById('error_asistencia_medica').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})

//primer respondiente
let rad_PR = document.getElementsByName('Primer_Respondiente_Radio')
for (let i = 0; i < rad_PR.length; i++) {
    rad_PR[i].addEventListener('change', function() {
        document.getElementById('error_primer_respondiente_radio').textContent = ''
    });
}
nombre_pr.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (nombre_pr.value.trim() !== '' && nombre_pr.value.length <= MAX_LENGTH) {
        document.getElementById('error_nombre_pr').textContent = ''
    } else if (!(nombre_pr.value.trim() !== '')) {
        document.getElementById('error_nombre_pr').textContent = 'Llene el campo *'
    } else if (!(nombre_pr.value.length <= MAX_LENGTH)) {
        document.getElementById('error_nombre_pr').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
ap_pat_pr.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (ap_pat_pr.value.trim() !== '' && ap_pat_pr.value.length <= MAX_LENGTH) {
        document.getElementById('error_ap_pat_pr').textContent = ''
    } else if (!(ap_pat_pr.value.trim() !== '')) {
        document.getElementById('error_ap_pat_pr').textContent = 'Llene el campo *'
    } else if (!(ap_pat_pr.value.length <= MAX_LENGTH)) {
        document.getElementById('error_ap_pat_pr').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
ap_mat_pr.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (ap_mat_pr.value.trim() !== '' && ap_mat_pr.value.length <= MAX_LENGTH) {
        document.getElementById('error_ap_mat_pr').textContent = ''
    } else if (!(ap_mat_pr.value.trim() !== '')) {
        document.getElementById('error_ap_mat_pr').textContent = 'Llene el campo *'
    } else if (!(ap_mat_pr.value.length <= MAX_LENGTH)) {
        document.getElementById('error_ap_mat_pr').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
institucion_pr.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (institucion_pr.value.trim() !== '' && institucion_pr.value.length <= MAX_LENGTH) {
        document.getElementById('error_institucion_pr').textContent = ''
    } else if (!(institucion_pr.value.trim() !== '')) {
        document.getElementById('error_institucion_pr').textContent = 'Llene el campo *'
    } else if (!(institucion_pr.value.length <= MAX_LENGTH)) {
        document.getElementById('error_institucion_pr').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
cargo_pr.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (cargo_pr.value.trim() !== '' && cargo_pr.value.length <= MAX_LENGTH) {
        document.getElementById('error_cargo_pr').textContent = ''
    } else if (!(cargo_pr.value.trim() !== '')) {
        document.getElementById('error_cargo_pr').textContent = 'Llene el campo *'
    } else if (!(cargo_pr.value.length <= MAX_LENGTH)) {
        document.getElementById('error_cargo_pr').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})

//segundo respondiente
nombre_sr.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (nombre_sr.value.trim() !== '' && nombre_sr.value.length <= MAX_LENGTH) {
        document.getElementById('error_nombre_sr').textContent = ''
    } else if (!(nombre_sr.value.trim() !== '')) {
        document.getElementById('error_nombre_sr').textContent = 'Llene el campo *'
    } else if (!(nombre_sr.value.length <= MAX_LENGTH)) {
        document.getElementById('error_nombre_sr').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
ap_pat_sr.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (ap_pat_sr.value.trim() !== '' && ap_pat_sr.value.length <= MAX_LENGTH) {
        document.getElementById('error_ap_pat_sr').textContent = ''
    } else if (!(ap_pat_sr.value.trim() !== '')) {
        document.getElementById('error_ap_pat_sr').textContent = 'Llene el campo *'
    } else if (!(ap_pat_sr.value.length <= MAX_LENGTH)) {
        document.getElementById('error_ap_pat_sr').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
ap_mat_sr.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (ap_mat_sr.value.trim() !== '' && ap_mat_sr.value.length <= MAX_LENGTH) {
        document.getElementById('error_ap_mat_sr').textContent = ''
    } else if (!(ap_mat_sr.value.trim() !== '')) {
        document.getElementById('error_ap_mat_sr').textContent = 'Llene el campo *'
    } else if (!(ap_mat_sr.value.length <= MAX_LENGTH)) {
        document.getElementById('error_ap_mat_sr').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
institucion_sr.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (institucion_sr.value.trim() !== '' && institucion_sr.value.length <= MAX_LENGTH) {
        document.getElementById('error_institucion_sr').textContent = ''
    } else if (!(institucion_sr.value.trim() !== '')) {
        document.getElementById('error_institucion_sr').textContent = 'Llene el campo *'
    } else if (!(institucion_sr.value.length <= MAX_LENGTH)) {
        document.getElementById('error_institucion_sr').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
cargo_sr.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (cargo_sr.value.trim() !== '' && cargo_sr.value.length <= MAX_LENGTH) {
        document.getElementById('error_cargo_sr').textContent = ''
    } else if (!(cargo_sr.value.trim() !== '')) {
        document.getElementById('error_cargo_sr').textContent = 'Llene el campo *'
    } else if (!(cargo_sr.value.length <= MAX_LENGTH)) {
        document.getElementById('error_cargo_sr').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})


/*-------LISTENERS DE LOS PANELES QUE SE MUESTRAN O SE OCULTAN-------*/

/*nivel del uso de la fuerza*/
let asistencia_panel = document.getElementById('id_asistencia_med_panel')

function changeAsistenciaMed(e) {
    if (e.target.id == 'id_asistencia_med_2') {
        asistencia_panel.classList.remove("mi_hide");
        document.getElementById('id_asistencia_medica').disabled = false
    } else {
        asistencia_panel.classList.add("mi_hide");
        document.getElementById('id_asistencia_medica').disabled = true
    }
}

// primer respondiente
let pr_panel = document.getElementById('id_elemento_panel')

function changePrimerResRadio(e) {
    if (e.target.id == 'id_primer_respondiente_radio_2') {
        pr_panel.classList.remove("mi_hide");
        nombre_pr.disabled = false;
        ap_pat_pr.disabled = false;
        ap_mat_pr.disabled = false;
        institucion_pr.disabled = false;
        cargo_pr.disabled = false;
        nombre_sr.disabled = false;
        ap_pat_sr.disabled = false;
        ap_mat_sr.disabled = false;
        institucion_sr.disabled = false;
        cargo_sr.disabled = false;

    } else {
        pr_panel.classList.add("mi_hide");
        nombre_pr.disabled = true;
        ap_pat_pr.disabled = true;
        ap_mat_pr.disabled = true;
        institucion_pr.disabled = true;
        cargo_pr.disabled = true;
        nombre_sr.disabled = true;
        ap_pat_sr.disabled = true;
        ap_mat_sr.disabled = true;
        institucion_sr.disabled = true;
        cargo_sr.disabled = true;
    }
}


/*--------------------------FUNCIONES AUXILIARES----------------------------*/
function mySubmitFunction(e) {
    e.preventDefault();
    return false;
}
/*solo números*/
function soloNumeros(e) {
    tecla = (document.all) ? e.keyCode : e.which;

    // Patron de entrada, en este caso solo acepta numeros
    patron = /[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}