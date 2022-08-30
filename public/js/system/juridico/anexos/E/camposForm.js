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

// FECHA/HORA ENTREVISTA
let fecha = document.getElementById('id_fecha')
let hora = document.getElementById('id_hora')

// DATOS GENERALES DE LA ENTREVISTA
let nombre_ent = document.getElementById('id_nombre_ent')
let ap_pat_ent = document.getElementById('id_ap_pat_ent')
let ap_mat_ent = document.getElementById('id_ap_mat_ent')

let calidad = document.getElementById('id_calidad')
let nacionalidad_select = document.getElementById('id_nacionalidad_select')
let nacionalidad_otro = document.getElementById('id_nacionalidad_otro')
let genero = document.getElementById('id_genero')
let fecha_nacimiento = document.getElementById('id_fecha_nacimiento')
let edad = document.getElementById('id_edad')

let telefono = document.getElementById('id_telefono')
let correo = document.getElementById('id_correo')
let identificacion_select = document.getElementById('id_identificacion_select')
let identificacion_otro = document.getElementById('id_identificacion_otro')
let num_identificacion = document.getElementById('id_num_identificacion')

// DOMICILIO ENTREVISTADO
let colonia_domEntrev = document.getElementById('id_colonia_domEntrev')
let calle_1_domEntrev = document.getElementById('id_calle_1_domEntrev')
let no_ext_domEntrev = document.getElementById('id_no_ext_domEntrev')
let no_int_domEntrev = document.getElementById('id_no_int_domEntrev')
let coord_x_domEntrev = document.getElementById('id_coord_x_domEntrev')
let coord_y_domEntrev = document.getElementById('id_coord_y_domEntrev')
let estado_domEntrev = document.getElementById('id_estado_domEntrev')
let municipio_domEntrev = document.getElementById('id_municipio_domEntrev')
let cp_domEntrev = document.getElementById('id_cp_domEntrev')
let referencias_domEntrev = document.getElementById('id_referencias_domEntrev')

// RELATO DE LA ENTREVISTA 
let relato_entrevista = document.getElementById('id_relato_entrevista')

// TRASLADO DE LA PERSONA ENTREVISTADA
let lugar_canalizacion = document.getElementById('id_lugar_canalizacion')
let descripcion_canalizacion = document.getElementById('id_descripcion_canalizacion')

// PRIMER RESPONDIENTE
let nombre_pr = document.getElementById('id_nombre_pr')
let ap_pat_pr = document.getElementById('id_ap_pat_pr')
let ap_mat_pr = document.getElementById('id_ap_mat_pr')
let institucion_pr = document.getElementById('id_institucion_pr')
let cargo_pr = document.getElementById('id_cargo_pr')
let no_control_pr = document.getElementById('id_no_control_pr')

/*--------------------------LISTENER DE CAMPOS----------------------------*/
// persona preservar sus datos
let rad_Preservar_D = document.getElementsByName('Reservar_Datos')
for (let i = 0; i < rad_Preservar_D.length; i++) {
    rad_Preservar_D[i].addEventListener('change', function() {
        document.getElementById('error_reservar_datos').textContent = ''
    });
}

// fecha/hora entrevista
fecha.addEventListener('change', (e) => {
    if (existeFecha(fecha.value)) {
        document.getElementById('error_fecha').textContent = ''
    } else {
        document.getElementById('error_fecha').textContent = 'Elije una fecha correcta'
    }
})
hora.addEventListener('change', (e) => {
    if (existeHora(hora.value)) {
        document.getElementById('error_hora').textContent = ''
    } else {
        document.getElementById('error_hora').textContent = 'Elije una hora correcta'
    }
})

// datos generales del entrevistado
nombre_ent.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (nombre_ent.value.trim() !== '' && nombre_ent.value.length <= MAX_LENGTH) {
        document.getElementById('error_nombre_ent').textContent = ''
    } else if (!(nombre_ent.value.trim() !== '')) {
        document.getElementById('error_nombre_ent').textContent = 'Llene el campo *'
    } else if (!(nombre_ent.value.length <= MAX_LENGTH)) {
        document.getElementById('error_nombre_ent').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
ap_pat_ent.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (ap_pat_ent.value.trim() !== '' && ap_pat_ent.value.length <= MAX_LENGTH) {
        document.getElementById('error_ap_pat_ent').textContent = ''
    } else if (!(ap_pat_ent.value.trim() !== '')) {
        document.getElementById('error_ap_pat_ent').textContent = 'Llene el campo *'
    } else if (!(ap_pat_ent.value.length <= MAX_LENGTH)) {
        document.getElementById('error_ap_pat_ent').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
ap_mat_ent.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (ap_mat_ent.value.trim() !== '' && ap_mat_ent.value.length <= MAX_LENGTH) {
        document.getElementById('error_ap_mat_ent').textContent = ''
    } else if (!(ap_mat_ent.value.trim() !== '')) {
        document.getElementById('error_ap_mat_ent').textContent = 'Llene el campo *'
    } else if (!(ap_mat_ent.value.length <= MAX_LENGTH)) {
        document.getElementById('error_ap_mat_ent').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
calidad.addEventListener('change', (e) => {
    const MAX_LENGTH = 45
    if (calidad.value.trim() !== '' && calidad.value.length <= MAX_LENGTH) {
        document.getElementById('error_calidad').textContent = ''
    } else if (!(calidad.value.trim() !== '')) {
        document.getElementById('error_calidad').textContent = 'Llene el campo *'
    } else if (!(calidad.value.length <= MAX_LENGTH)) {
        document.getElementById('error_calidad').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
nacionalidad_select.addEventListener('change', (e) => {
    const MAX_LENGTH = 45
    if (nacionalidad_select.value.trim() !== '' && nacionalidad_select.value.length <= MAX_LENGTH) {
        document.getElementById('error_nacionalidad_select').textContent = ''
    } else if (!(nacionalidad_select.value.trim() !== '')) {
        document.getElementById('error_nacionalidad_select').textContent = 'Llene el campo *'
    } else if (!(nacionalidad_select.value.length <= MAX_LENGTH)) {
        document.getElementById('error_nacionalidad_select').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
nacionalidad_otro.addEventListener('change', (e) => {
    const MAX_LENGTH = 45
    if (nacionalidad_otro.value.trim() !== '' && nacionalidad_otro.value.length <= MAX_LENGTH) {
        document.getElementById('error_nacionalidad_otro').textContent = ''
    } else if (!(nacionalidad_otro.value.trim() !== '')) {
        document.getElementById('error_nacionalidad_otro').textContent = 'Llene el campo *'
    } else if (!(nacionalidad_otro.value.length <= MAX_LENGTH)) {
        document.getElementById('error_nacionalidad_otro').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
genero.addEventListener('change', (e) => {
    const MAX_LENGTH = 1
    if (genero.value.trim() !== '' && genero.value.length <= MAX_LENGTH) {
        document.getElementById('error_genero').textContent = ''
    } else if (!(genero.value.trim() !== '')) {
        document.getElementById('error_genero').textContent = 'Llene el campo *'
    } else if (!(genero.value.length <= MAX_LENGTH)) {
        document.getElementById('error_genero').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
fecha_nacimiento.addEventListener('change', (e) => {
    if (existeFecha(fecha_nacimiento.value)) {
        edad.value = calcularEdad(fecha_nacimiento.value)
        document.getElementById('error_fecha_nacimiento').textContent = ''
        document.getElementById('error_edad').textContent = ''
    } else {
        document.getElementById('error_fecha_nacimiento').textContent = 'Elije una fecha correcta'
    }
})
telefono.addEventListener('change', (e) => {
    const MAX_LENGTH = 20
    if (telefono.value.trim() !== '' && telefono.value.length <= MAX_LENGTH) {
        document.getElementById('error_telefono').textContent = ''
    } else if (!(telefono.value.trim() !== '')) {
        document.getElementById('error_telefono').textContent = 'Llene el campo *'
    } else if (!(telefono.value.length <= MAX_LENGTH)) {
        document.getElementById('error_telefono').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
correo.addEventListener('change', (e) => {
    const MAX_LENGTH = 100
    if (correo.value.trim() !== '' && correo.value.length <= MAX_LENGTH) {
        document.getElementById('error_correo').textContent = ''
    } else if (!(correo.value.trim() !== '')) {
        document.getElementById('error_correo').textContent = 'Llene el campo *'
    } else if (!(correo.value.length <= MAX_LENGTH)) {
        document.getElementById('error_correo').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
identificacion_select.addEventListener('change', (e) => {
    const MAX_LENGTH = 100
    if (identificacion_select.value.trim() !== '' && identificacion_select.value.length <= MAX_LENGTH) {
        document.getElementById('error_identificacion_select').textContent = ''
    } else if (!(identificacion_select.value.trim() !== '')) {
        document.getElementById('error_identificacion_select').textContent = 'Llene el campo *'
    } else if (!(identificacion_select.value.length <= MAX_LENGTH)) {
        document.getElementById('error_identificacion_select').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
identificacion_otro.addEventListener('change', (e) => {
    const MAX_LENGTH = 100
    if (identificacion_otro.value.trim() !== '' && identificacion_otro.value.length <= MAX_LENGTH) {
        document.getElementById('error_identificacion_otro').textContent = ''
    } else if (!(identificacion_otro.value.trim() !== '')) {
        document.getElementById('error_identificacion_otro').textContent = 'Llene el campo *'
    } else if (!(identificacion_otro.value.length <= MAX_LENGTH)) {
        document.getElementById('error_identificacion_otro').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
num_identificacion.addEventListener('change', (e) => {
    const MAX_LENGTH = 100
    if (num_identificacion.value.trim() !== '' && num_identificacion.value.length <= MAX_LENGTH) {
        document.getElementById('error_num_identificacion').textContent = ''
    } else if (!(num_identificacion.value.trim() !== '')) {
        document.getElementById('error_num_identificacion').textContent = 'Llene el campo *'
    } else if (!(num_identificacion.value.length <= MAX_LENGTH)) {
        document.getElementById('error_num_identificacion').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})

// relato de la entrevista
relato_entrevista.addEventListener('change', (e) => {
    const MAX_LENGTH = 50000
    if (relato_entrevista.value.trim() !== '' && relato_entrevista.value.length <= MAX_LENGTH) {
        document.getElementById('error_relato_entrevista').textContent = ''
    } else if (!(relato_entrevista.value.trim() !== '')) {
        document.getElementById('error_relato_entrevista').textContent = 'Llene el campo *'
    } else if (!(relato_entrevista.value.length <= MAX_LENGTH)) {
        document.getElementById('error_relato_entrevista').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})

// tarslado del entrevistado
let rad_Traslado = document.getElementsByName('Canalizacion')
for (let i = 0; i < rad_Traslado.length; i++) {
    rad_Traslado[i].addEventListener('change', function() {
        document.getElementById('error_canalizacion').textContent = ''
    });
}
lugar_canalizacion.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (lugar_canalizacion.value.trim() !== '' && lugar_canalizacion.value.length <= MAX_LENGTH) {
        document.getElementById('error_lugar_canalizacion').textContent = ''
    } else if (!(lugar_canalizacion.value.trim() !== '')) {
        document.getElementById('error_lugar_canalizacion').textContent = 'Llene el campo *'
    } else if (!(lugar_canalizacion.value.length <= MAX_LENGTH)) {
        document.getElementById('error_lugar_canalizacion').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
descripcion_canalizacion.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (descripcion_canalizacion.value.trim() !== '' && descripcion_canalizacion.value.length <= MAX_LENGTH) {
        document.getElementById('error_descripcion_canalizacion').textContent = ''
    } else if (!(descripcion_canalizacion.value.trim() !== '')) {
        document.getElementById('error_descripcion_canalizacion').textContent = 'Llene el campo *'
    } else if (!(descripcion_canalizacion.value.length <= MAX_LENGTH)) {
        document.getElementById('error_descripcion_canalizacion').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})

// primer respondiente
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

/*-------LISTENERS DE LOS PANELES QUE SE MUESTRAN O SE OCULTAN-------*/

// datos generales del entrevistado
let nacionalidad_panel = document.getElementById('id_nacionalidad_otro_panel')

function changeNacionalidad(e) {
    if (e.target.value != 'MEXICANA') {
        nacionalidad_panel.classList.remove("mi_hide");
        nacionalidad_otro.disabled = false
    } else {
        nacionalidad_panel.classList.add("mi_hide");
        nacionalidad_otro.disabled = true
    }
}

let identificacion_panel = document.getElementById('id_identificacion_panel')

function changeIdentificacion(e) {
    if (e.target.value == 'Otro') {
        identificacion_panel.classList.remove("mi_hide");
        identificacion_otro.disabled = false
    } else {
        identificacion_panel.classList.add("mi_hide");
        identificacion_otro.disabled = true
    }
}

// traslado de la persona entrevistada
let traslado_panel = document.getElementById('id_traslado_panel')

function changeTraslado(e) {
    if (e.target.value == '1') {
        traslado_panel.classList.remove("mi_hide");
        lugar_canalizacion.disabled = false
        descripcion_canalizacion.disabled = false
    } else {
        traslado_panel.classList.add("mi_hide");
        descripcion_canalizacion.disabled = true
        lugar_canalizacion.disabled = true
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

    } else {
        pr_panel.classList.add("mi_hide");
        nombre_pr.disabled = true;
        ap_pat_pr.disabled = true;
        ap_mat_pr.disabled = true;
        institucion_pr.disabled = true;
        cargo_pr.disabled = true;
    }
}


/*--------------------------FUNCIONES AUXILIARES----------------------------*/
function mySubmitFunction(e) {
    e.preventDefault();
    return false;
}
/*valida fecha*/
function existeFecha(fecha) {
    let fechaf = fecha.split("-")
    let d = fechaf[2]
    let m = fechaf[1]
    let y = fechaf[0]
    return m > 0 && m < 13 && y > 0 && y < 32768 && d > 0 && d <= (new Date(y, m, 0)).getDate()
}
/*valida fecha*/
function existeHora(hora) {
    let horaH = hora.split(":")
    let hrs = horaH[0]
    let mins = horaH[1]
    return hrs >= 0 && hrs <= 23 && mins >= 0 && mins <= 59
}
/*solo números*/
function soloNumeros(e) {
    tecla = (document.all) ? e.keyCode : e.which;

    // Patron de entrada, en este caso solo acepta numeros
    patron = /[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}
/**calcular la edad conforme una fecha */
function calcularEdad(dateString) {
    let hoy = new Date()
    let fechaNacimiento = new Date(dateString)
    let edad = hoy.getFullYear() - fechaNacimiento.getFullYear()
    let diferenciaMeses = hoy.getMonth() - fechaNacimiento.getMonth()
    if (
        diferenciaMeses < 0 ||
        (diferenciaMeses === 0 && hoy.getDate() < fechaNacimiento.getDate())
    ) {
        edad--
    }
    return edad
}