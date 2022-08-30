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
//numero y fecha/hora detención
let num_detencion = document.getElementById('id_num_detencion')
let fecha = document.getElementById('id_fecha')
let hora = document.getElementById('id_hora')

//datos generales del detenido
let nombre_d = document.getElementById('id_nombre_d')
let ap_pat_d = document.getElementById('id_ap_pat_d')
let ap_mat_d = document.getElementById('id_ap_mat_d')
let apodo = document.getElementById('id_apodo')
let genero = document.getElementById('id_genero')
let fecha_nacimiento = document.getElementById('id_fecha_nacimiento')
let edad = document.getElementById('id_edad')
let nacionalidad_otro = document.getElementById('id_nacionalidad_otro')
let identificacion_select = document.getElementById('id_identificacion_select')
let identificacion_otro = document.getElementById('id_identificacion_otro')
let num_identificacion = document.getElementById('id_num_identificacion')

//domicilio detenido
let colonia_domDetenido = document.getElementById('id_colonia_domDetenido')
let calle_1_domDetenido = document.getElementById('id_calle_1_domDetenido')
let no_ext_domDetenido = document.getElementById('id_no_ext_domDetenido')
let no_int_domDetenido = document.getElementById('id_no_int_domDetenido')
let coord_x_domDetenido = document.getElementById('id_coord_x_domDetenido')
let coord_y_domDetenido = document.getElementById('id_coord_y_domDetenido')
let estado_domDetenido = document.getElementById('id_estado_domDetenido')
let municipio_domDetenido = document.getElementById('id_municipio_domDetenido')
let cp_domDetenido = document.getElementById('id_cp_domDetenido')
let referencias_domDetenido = document.getElementById('id_referencias_domDetenido')

//información adicional del detenido
let descripcion_detenido = document.getElementById('id_descripcion_detenido')
let lesiones = document.getElementById('id_lesiones')
let padecimiento = document.getElementById('id_padecimiento')
let grupo_v = document.getElementById('id_grupo_v')
let grupo_d = document.getElementById('id_grupo_d')

//familiar del detenido
let nombre_f = document.getElementById('id_nombre_f')
let ap_pat_f = document.getElementById('id_ap_pat_f')
let ap_mat_f = document.getElementById('id_ap_mat_f')
let telefono_f = document.getElementById('id_telefono_f')

//ubicacion de la detención
let colonia_ubi_detencion = document.getElementById('id_colonia_ubi_detencion')
let calle_1_ubi_detencion = document.getElementById('id_calle_1_ubi_detencion')
let calle_2_ubi_detencion = document.getElementById('id_calle_2_ubi_detencion')
let no_ext_ubi_detencion = document.getElementById('id_no_ext_ubi_detencion')
let no_int_ubi_detencion = document.getElementById('id_no_int_ubi_detencion')
let coord_x_ubi_detencion = document.getElementById('id_coord_x_ubi_detencion')
let coord_y_ubi_detencion = document.getElementById('id_coord_y_ubi_detencion')
let estado_ubi_detencion = document.getElementById('id_estado_ubi_detencion')
let municipio_ubi_detencion = document.getElementById('id_municipio_ubi_detencion')
let cp_ubi_detencion = document.getElementById('id_cp_ubi_detencion')
let referencias_ubi_detencion = document.getElementById('id_referencias_ubi_detencion')

//lugar de traslado del detenido
let lugar_traslado = document.getElementById('id_lugar_traslado')
let desc_traslado = document.getElementById('id_desc_traslado')
let obs_detencion = document.getElementById('id_obs_detencion')

//primer respondiente
let nombre_pr = document.getElementById('id_nombre_pr')
let ap_pat_pr = document.getElementById('id_ap_pat_pr')
let ap_mat_pr = document.getElementById('id_ap_mat_pr')
let institucion_pr = document.getElementById('id_institucion_pr')
let cargo_pr = document.getElementById('id_cargo_pr')
let no_control_pr = document.getElementById('id_no_control_pr')

//segundo respondiente
let nombre_sr = document.getElementById('id_nombre_sr')
let ap_pat_sr = document.getElementById('id_ap_pat_sr')
let ap_mat_sr = document.getElementById('id_ap_mat_sr')
let institucion_sr = document.getElementById('id_institucion_sr')
let cargo_sr = document.getElementById('id_cargo_sr')
let no_control_sr = document.getElementById('id_no_control_sr')

/*--------------------------LISTENER DE CAMPOS----------------------------*/
//numero y fecha/hora detención
num_detencion.addEventListener('change', (e) => {
    const MAX_LENGTH = 45
    if (num_detencion.value.trim() !== '' && num_detencion.value.length <= MAX_LENGTH) {
        document.getElementById('error_num_detencion').textContent = ''
    } else if (!(num_detencion.value.trim() !== '')) {
        document.getElementById('error_num_detencion').textContent = 'Llene el campo *'
    } else if (!(num_detencion.value.length <= MAX_LENGTH)) {
        document.getElementById('error_num_detencion').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
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

//datos generales del detenido
nombre_d.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (nombre_d.value.trim() !== '' && nombre_d.value.length <= MAX_LENGTH) {
        document.getElementById('error_nombre_d').textContent = ''
    } else if (!(nombre_d.value.trim() !== '')) {
        document.getElementById('error_nombre_d').textContent = 'Llene el campo *'
    } else if (!(nombre_d.value.length <= MAX_LENGTH)) {
        document.getElementById('error_nombre_d').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
ap_pat_d.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (ap_pat_d.value.trim() !== '' && ap_pat_d.value.length <= MAX_LENGTH) {
        document.getElementById('error_ap_pat_d').textContent = ''
    } else if (!(ap_pat_d.value.trim() !== '')) {
        document.getElementById('error_ap_pat_d').textContent = 'Llene el campo *'
    } else if (!(ap_pat_d.value.length <= MAX_LENGTH)) {
        document.getElementById('error_ap_pat_d').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
ap_mat_d.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (ap_mat_d.value.trim() !== '' && ap_mat_d.value.length <= MAX_LENGTH) {
        document.getElementById('error_ap_mat_d').textContent = ''
    } else if (!(ap_mat_d.value.trim() !== '')) {
        document.getElementById('error_ap_mat_d').textContent = 'Llene el campo *'
    } else if (!(ap_mat_d.value.length <= MAX_LENGTH)) {
        document.getElementById('error_ap_mat_d').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
apodo.addEventListener('change', (e) => {
    const MAX_LENGTH = 100
    if (apodo.value.trim() !== '' && apodo.value.length <= MAX_LENGTH) {
        document.getElementById('error_apodo').textContent = ''
    } else if (!(apodo.value.trim() !== '')) {
        document.getElementById('error_apodo').textContent = 'Llene el campo *'
    } else if (!(apodo.value.length <= MAX_LENGTH)) {
        document.getElementById('error_apodo').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
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
edad.addEventListener('change', (e) => {
    const MAX_LENGTH = 3
    if (edad.value.trim() !== '' && edad.value.length <= MAX_LENGTH) {
        document.getElementById('error_edad').textContent = ''
    } else if (!(edad.value.trim() !== '')) {
        document.getElementById('error_edad').textContent = 'Llene el campo *'
    } else if (!(edad.value.length <= MAX_LENGTH)) {
        document.getElementById('error_edad').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
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
let rad_Nacionalidad = document.getElementsByName('Nacionalidad_Radio')
for (let i = 0; i < rad_Nacionalidad.length; i++) {
    rad_Nacionalidad[i].addEventListener('change', function() {
        document.getElementById('error_nacionalidad_radio').textContent = ''
    });
}
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


//información adicional del detenido
descripcion_detenido.addEventListener('change', (e) => {
    const MAX_LENGTH = 12000
    if (descripcion_detenido.value.trim() !== '' && descripcion_detenido.value.length <= MAX_LENGTH) {
        document.getElementById('error_descripcion_detenido').textContent = ''
    } else if (!(descripcion_detenido.value.trim() !== '')) {
        document.getElementById('error_descripcion_detenido').textContent = 'Llene el campo *'
    } else if (!(descripcion_detenido.value.length <= MAX_LENGTH)) {
        document.getElementById('error_descripcion_detenido').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
padecimiento.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (padecimiento.value.trim() !== '' && padecimiento.value.length <= MAX_LENGTH) {
        document.getElementById('error_padecimiento').textContent = ''
    } else if (!(padecimiento.value.trim() !== '')) {
        document.getElementById('error_padecimiento').textContent = 'Llene el campo *'
    } else if (!(padecimiento.value.length <= MAX_LENGTH)) {
        document.getElementById('error_padecimiento').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
grupo_v.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (grupo_v.value.trim() !== '' && grupo_v.value.length <= MAX_LENGTH) {
        document.getElementById('error_grupo_v').textContent = ''
    } else if (!(grupo_v.value.trim() !== '')) {
        document.getElementById('error_grupo_v').textContent = 'Llene el campo *'
    } else if (!(grupo_v.value.length <= MAX_LENGTH)) {
        document.getElementById('error_grupo_v').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
grupo_d.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (grupo_d.value.trim() !== '' && grupo_d.value.length <= MAX_LENGTH) {
        document.getElementById('error_grupo_d').textContent = ''
    } else if (!(grupo_d.value.trim() !== '')) {
        document.getElementById('error_grupo_d').textContent = 'Llene el campo *'
    } else if (!(grupo_d.value.length <= MAX_LENGTH)) {
        document.getElementById('error_grupo_d').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
let rad_Lsesiones = document.getElementsByName('Lesiones')
for (let i = 0; i < rad_Lsesiones.length; i++) {
    rad_Lsesiones[i].addEventListener('change', function() {
        document.getElementById('error_lesiones_radio').textContent = ''
    });
}
let rad_Padecimiento = document.getElementsByName('Padecimiento_Radio')
for (let i = 0; i < rad_Padecimiento.length; i++) {
    rad_Padecimiento[i].addEventListener('change', function() {
        document.getElementById('error_padecimiento_radio').textContent = ''
    });
}
let rad_Grupo_V = document.getElementsByName('Grupo_V_Radio')
for (let i = 0; i < rad_Grupo_V.length; i++) {
    rad_Grupo_V[i].addEventListener('change', function() {
        document.getElementById('error_grupo_v_radio').textContent = ''
    });
}
let rad_Grupo_D = document.getElementsByName('Grupo_D_Radio')
for (let i = 0; i < rad_Grupo_D.length; i++) {
    rad_Grupo_D[i].addEventListener('change', function() {
        document.getElementById('error_grupo_d_radio').textContent = ''
    });
}

//familiar del detenido
nombre_f.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (nombre_f.value.trim() !== '' && nombre_f.value.length <= MAX_LENGTH) {
        document.getElementById('error_nombre_f').textContent = ''
    } else if (!(nombre_f.value.trim() !== '')) {
        document.getElementById('error_nombre_f').textContent = 'Llene el campo *'
    } else if (!(nombre_f.value.length <= MAX_LENGTH)) {
        document.getElementById('error_nombre_f').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
ap_pat_f.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (ap_pat_f.value.trim() !== '' && ap_pat_f.value.length <= MAX_LENGTH) {
        document.getElementById('error_ap_pat_f').textContent = ''
    } else if (!(ap_pat_f.value.trim() !== '')) {
        document.getElementById('error_ap_pat_f').textContent = 'Llene el campo *'
    } else if (!(ap_pat_f.value.length <= MAX_LENGTH)) {
        document.getElementById('error_ap_pat_f').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
ap_mat_f.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (ap_mat_f.value.trim() !== '' && ap_mat_f.value.length <= MAX_LENGTH) {
        document.getElementById('error_ap_mat_f').textContent = ''
    } else if (!(ap_mat_f.value.trim() !== '')) {
        document.getElementById('error_ap_mat_f').textContent = 'Llene el campo *'
    } else if (!(ap_mat_f.value.length <= MAX_LENGTH)) {
        document.getElementById('error_ap_mat_f').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
telefono_f.addEventListener('change', (e) => {
    const MAX_LENGTH = 10
    if (telefono_f.value.trim() !== '' && telefono_f.value.length <= MAX_LENGTH) {
        document.getElementById('error_telefono_f').textContent = ''
    } else if (!(telefono_f.value.trim() !== '')) {
        document.getElementById('error_telefono_f').textContent = 'Llene el campo *'
    } else if (!(telefono_f.value.length <= MAX_LENGTH)) {
        document.getElementById('error_telefono_f').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
let rad_Familiar = document.getElementsByName('Familiar_Radio')
for (let i = 0; i < rad_Familiar.length; i++) {
    rad_Familiar[i].addEventListener('change', function() {
        document.getElementById('error_familiar_radio').textContent = ''
    });
}

// lectura de derechos
let rad_Derechos = document.getElementsByName('Lectura_Derechos')
for (let i = 0; i < rad_Derechos.length; i++) {
    rad_Derechos[i].addEventListener('change', function() {
        document.getElementById('error_derechos_radio').textContent = ''
    });
}

// inspección del detenido
let rad_Obj_Enc = document.getElementsByName('Objeto_Encontrado')
for (let i = 0; i < rad_Obj_Enc.length; i++) {
    rad_Obj_Enc[i].addEventListener('change', function() {
        document.getElementById('error_obj_encontrado_radio').textContent = ''
    });
}
let rad_Pertenencias = document.getElementsByName('Pertenencias_Encontradas')
for (let i = 0; i < rad_Pertenencias.length; i++) {
    rad_Pertenencias[i].addEventListener('change', function() {
        document.getElementById('error_pert_encontrado_radio').textContent = ''
    });
}

//ubicación de la detención
let rad_Ubi_Det = document.getElementsByName('Ubicacion_Det_Radio')
for (let i = 0; i < rad_Ubi_Det.length; i++) {
    rad_Ubi_Det[i].addEventListener('change', function() {
        document.getElementById('error_ubicacion_det_radio').textContent = ''
    });
}

//lugar de traslado del detenido
lugar_traslado.addEventListener('change', (e) => {
    const MAX_LENGTH = 450
    if (lugar_traslado.value.trim() !== '' && lugar_traslado.value.length <= MAX_LENGTH) {
        document.getElementById('error_lugar_traslado').textContent = ''
    } else if (!(lugar_traslado.value.trim() !== '')) {
        document.getElementById('error_lugar_traslado').textContent = 'Llene el campo *'
    } else if (!(lugar_traslado.value.length <= MAX_LENGTH)) {
        document.getElementById('error_lugar_traslado').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
desc_traslado.addEventListener('change', (e) => {
    const MAX_LENGTH = 450
    if (desc_traslado.value.trim() !== '' && desc_traslado.value.length <= MAX_LENGTH) {
        document.getElementById('error_desc_traslado').textContent = ''
    } else if (!(desc_traslado.value.trim() !== '')) {
        document.getElementById('error_desc_traslado').textContent = 'Llene el campo *'
    } else if (!(desc_traslado.value.length <= MAX_LENGTH)) {
        document.getElementById('error_desc_traslado').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
obs_detencion.addEventListener('change', (e) => {
    const MAX_LENGTH = 10000
    if (obs_detencion.value.trim() !== '' && obs_detencion.value.length <= MAX_LENGTH) {
        document.getElementById('error_obs_detencion').textContent = ''
    } else if (!(obs_detencion.value.trim() !== '')) {
        document.getElementById('error_obs_detencion').textContent = 'Llene el campo *'
    } else if (!(obs_detencion.value.length <= MAX_LENGTH)) {
        document.getElementById('error_obs_detencion').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
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

/*datos generales del detenido*/
let nacionalidadPanel = document.getElementById('id_nacionalidad_otro_panel')

function changeNacionalidad(e) {
    if (e.target.id == 'id_nacionalidad_2') {
        nacionalidadPanel.classList.remove("mi_hide");
        document.getElementById('id_nacionalidad_otro').disabled = false
    } else {
        nacionalidadPanel.classList.add("mi_hide");
        document.getElementById('id_nacionalidad_otro').disabled = true
    }
}

let identificacion_panel = document.getElementById('id_identificacion_panel')

function changeIdentificacion(e) {
    if (e.target.value == 'Otro') {
        identificacion_panel.classList.remove("mi_hide");
        document.getElementById('id_identificacion_otro').disabled = false
    } else {
        identificacion_panel.classList.add("mi_hide");
        document.getElementById('id_identificacion_otro').disabled = true
    }
}

// información adicional del detenido
let padecimiento_panel = document.getElementById('id_padecimiento_panel')

function changePadecimientos(e) {
    if (e.target.value == 'Sí') {
        padecimiento_panel.classList.remove("mi_hide");
        document.getElementById('id_padecimiento').disabled = false
    } else {
        padecimiento_panel.classList.add("mi_hide");
        document.getElementById('id_padecimiento').disabled = true
    }
}
let grupo_v_panel = document.getElementById('id_grupo_v_panel')

function changeGrupoV(e) {
    if (e.target.value == 'Sí') {
        grupo_v_panel.classList.remove("mi_hide");
        document.getElementById('id_grupo_v').disabled = false
    } else {
        grupo_v_panel.classList.add("mi_hide");
        document.getElementById('id_grupo_v').disabled = true
    }
}
let grupo_d_panel = document.getElementById('id_grupo_d_panel')

function changeGrupoD(e) {
    if (e.target.value == 'Sí') {
        grupo_d_panel.classList.remove("mi_hide");
        document.getElementById('id_grupo_d').disabled = false
    } else {
        grupo_d_panel.classList.add("mi_hide");
        document.getElementById('id_grupo_d').disabled = true
    }
}

// familiar del detenido
let familiar_panel = document.getElementById('id_familiar_panel')

function changeFamiliarRadio(e) {
    if (e.target.id == 'id_familiar_radio_2') {
        familiar_panel.classList.remove("mi_hide");
        document.getElementById('id_nombre_f').disabled = false
        document.getElementById('id_ap_pat_f').disabled = false
        document.getElementById('id_ap_mat_f').disabled = false
        document.getElementById('id_telefono_f').disabled = false
    } else {
        familiar_panel.classList.add("mi_hide");
        document.getElementById('id_nombre_f').disabled = true
        document.getElementById('id_ap_pat_f').disabled = true
        document.getElementById('id_ap_mat_f').disabled = true
        document.getElementById('id_telefono_f').disabled = true
    }
}

// inspección de la persona detenida
let pertenencias_panel = document.getElementById('id_pertenencias_panel')

function changePertenenciasRadio(e) {
    if (e.target.id == 'id_pert_econtradas_2') {
        pertenencias_panel.classList.remove("mi_hide");
        document.getElementById('id_pertenencia').disabled = false
        document.getElementById('id_descripcion').disabled = false
        document.getElementById('id_destino').disabled = false
        document.getElementById('id_btn_add_pert').disabled = false
    } else {
        pertenencias_panel.classList.add("mi_hide");
        document.getElementById('id_pertenencia').disabled = true
        document.getElementById('id_descripcion').disabled = true
        document.getElementById('id_destino').disabled = true
        document.getElementById('id_btn_add_pert').disabled = true
    }
}

// ubicacion de la detención
let ubicacion_det_panel = document.getElementById('id_ubicacion_det_panel')

function changeUbicacionDetRadio(e) {
    if (e.target.id == 'id_ubicacion_det_radio_1') {
        ubicacion_det_panel.classList.remove("mi_hide");
        document.getElementById('id_colonia_ubi_detencion').disabled = false
        document.getElementById('id_calle_1_ubi_detencion').disabled = false
        document.getElementById('id_calle_2_ubi_detencion').disabled = false
        document.getElementById('id_no_ext_ubi_detencion').disabled = false
        document.getElementById('id_no_int_ubi_detencion').disabled = false
        document.getElementById('id_coord_x_ubi_detencion').disabled = false
        document.getElementById('id_coord_y_ubi_detencion').disabled = false
        document.getElementById('id_cp_ubi_detencion').disabled = false

    } else {
        ubicacion_det_panel.classList.add("mi_hide");
        document.getElementById('id_colonia_ubi_detencion').disabled = true
        document.getElementById('id_calle_1_ubi_detencion').disabled = true
        document.getElementById('id_calle_2_ubi_detencion').disabled = true
        document.getElementById('id_no_ext_ubi_detencion').disabled = true
        document.getElementById('id_no_int_ubi_detencion').disabled = true
        document.getElementById('id_coord_x_ubi_detencion').disabled = true
        document.getElementById('id_coord_y_ubi_detencion').disabled = true
        document.getElementById('id_cp_ubi_detencion').disabled = true
    }
}

// primer respondiente
let primer_r_panel = document.getElementById('id_elemento_panel')

function changePrimerResRadio(e) {
    if (e.target.id == 'id_primer_respondiente_radio_2') {
        primer_r_panel.classList.remove("mi_hide");
        document.getElementById('id_nombre_pr').disabled = false
        document.getElementById('id_ap_pat_pr').disabled = false
        document.getElementById('id_ap_mat_pr').disabled = false
        document.getElementById('id_institucion_pr').disabled = false
        document.getElementById('id_cargo_pr').disabled = false

    } else {
        primer_r_panel.classList.add("mi_hide");
        document.getElementById('id_nombre_pr').disabled = true
        document.getElementById('id_ap_pat_pr').disabled = true
        document.getElementById('id_ap_mat_pr').disabled = true
        document.getElementById('id_institucion_pr').disabled = true
        document.getElementById('id_cargo_pr').disabled = true
    }
}

/*--------------------------FUNCIONES AUXILIARES----------------------------*/
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

function ventanaSecundaria(URL) {
    window.open(URL, '_blank', "width=500,height=500,scrollbars=YES,centerscreen")
}