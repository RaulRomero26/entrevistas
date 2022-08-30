//get form element
let formAnexoE = document.getElementById('id_form_anexo_e')

/*--------------ALERTS------------*/
let alert_result = document.getElementById('id_alert_result')

/*------CAMPOS PARA ERRORES-------*/

//reservar datos entrevistado
let error_reservar_datos = document.getElementById('error_reservar_datos')

//fecha y hora entrevista
let error_fecha = document.getElementById('error_fecha')
let error_hora = document.getElementById('error_hora')

//datos generales del entrevistado
let error_nombre_ent = document.getElementById('error_nombre_ent')
let error_ap_pat_ent = document.getElementById('error_ap_pat_ent')
let error_ap_mat_ent = document.getElementById('error_ap_mat_ent')
let error_calidad = document.getElementById('error_calidad')
let error_nacionalidad_select = document.getElementById('error_nacionalidad_select')
let error_nacionalidad_otro = document.getElementById('error_nacionalidad_otro')
let error_genero = document.getElementById('error_genero')
let error_fecha_nacimiento = document.getElementById('error_fecha_nacimiento')
let error_edad = document.getElementById('error_edad')
let error_telefono = document.getElementById('error_telefono')
let error_correo = document.getElementById('error_correo')
let error_identificacion_select = document.getElementById('error_identificacion_select')
let error_identificacion_otro = document.getElementById('error_identificacion_otro')
let error_num_identificacion = document.getElementById('error_num_identificacion')

// domicilio del entrevistado
let error_colonia_domEntrev = document.getElementById('error_colonia_domEntrev')
let error_calle_1_domEntrev = document.getElementById('error_calle_1_domEntrev')
let error_no_ext_domEntrev = document.getElementById('error_no_ext_domEntrev')
let error_no_int_domEntrev = document.getElementById('error_no_int_domEntrev')
let error_coord_x_domEntrev = document.getElementById('error_coord_x_domEntrev')
let error_coord_y_domEntrev = document.getElementById('error_coord_y_domEntrev')
let error_estado_domEntrev = document.getElementById('error_estado_domEntrev')
let error_municipio_domEntrev = document.getElementById('error_municipio_domEntrev')
let error_cp_domEntrev = document.getElementById('error_cp_domEntrev')
let error_referencias_domEntrev = document.getElementById('error_referencias_domEntrev')

// relato de la entrevista
let error_relato_entrevista = document.getElementById('error_relato_entrevista')

// lugar traslado entrevistado
let error_canalizacion = document.getElementById('error_canalizacion')
let error_lugar_canalizacion = document.getElementById('error_lugar_canalizacion')
let error_descripcion_canalizacion = document.getElementById('error_descripcion_canalizacion')

//primer respondiente
let error_primer_respondiente_radio = document.getElementById('error_primer_respondiente_radio')
let error_nombre_pr = document.getElementById('error_nombre_pr')
let error_ap_pat_pr = document.getElementById('error_ap_pat_pr')
let error_ap_mat_pr = document.getElementById('error_ap_mat_pr')
let error_institucion_pr = document.getElementById('error_institucion_pr')
let error_cargo_pr = document.getElementById('error_cargo_pr')
let error_no_control_pr = document.getElementById('error_no_control_pr')

const checkFormAnexoE = (event) => {

    let buttonForm = document.getElementById(event.target.id)
    let cancelButton = document.getElementById('id_cancel_button')

    buttonForm.disabled = true
    buttonForm.textContent = 'Guardando...'
    cancelButton.classList.add('mi_hide')

    let myFormData = new FormData(formAnexoE)
    let band = [] //banderas success

    /*inician las validaciones campo por campo*/
    let FV = new FormValidator()
    let ind = 0

    //set rules
    //reservar datos entrevistado
    band[ind++] = error_reservar_datos.textContent = FV.validate(myFormData.get('Reservar_Datos'), 'required | numeric | length[1]')

    //fecha/hora entrevista
    band[ind++] = error_fecha.textContent = FV.validate(myFormData.get('Fecha'), 'required | date')
    band[ind++] = error_hora.textContent = FV.validate(myFormData.get('Hora'), 'required | time')

    if (myFormData.get('Reservar_Datos') == '1') { //si desea reservar sus datos
        // datos generales del entrevistado
        band[ind++] = error_nombre_ent.textContent = FV.validate(myFormData.get('Nombre_Ent'), 'max_length[250]')
        band[ind++] = error_ap_pat_ent.textContent = FV.validate(myFormData.get('Ap_Paterno_Ent'), 'max_length[250]')
        band[ind++] = error_ap_mat_ent.textContent = FV.validate(myFormData.get('Ap_Materno_Ent'), 'max_length[250]')
        band[ind++] = error_fecha_nacimiento.textContent = FV.validate(myFormData.get('Fecha_Nacimiento'), 'max_length[20]')
        band[ind++] = error_edad.textContent = FV.validate(myFormData.get('Edad'), 'max_length[3]')
        if (myFormData.get('Edad') != '') {
            band[ind++] = error_edad.textContent = (parseInt(myFormData.get('Edad')) > 10) ? '' : 'Edad debe ser positiva mayor a 10'
        }

    } else {
        // datos generales del entrevistado
        band[ind++] = error_nombre_ent.textContent = FV.validate(myFormData.get('Nombre_Ent'), 'required | max_length[250]')
        band[ind++] = error_ap_pat_ent.textContent = FV.validate(myFormData.get('Ap_Paterno_Ent'), 'required | max_length[250]')
        band[ind++] = error_ap_mat_ent.textContent = FV.validate(myFormData.get('Ap_Materno_Ent'), 'required | max_length[250]')
        band[ind++] = error_fecha_nacimiento.textContent = FV.validate(myFormData.get('Fecha_Nacimiento'), 'required | max_length[20]')
        band[ind++] = error_edad.textContent = FV.validate(myFormData.get('Edad'), 'required | max_length[3]')
        band[ind++] = error_edad.textContent = (parseInt(myFormData.get('Edad')) > 10) ? '' : 'Edad debe ser positiva mayor a 10'
    }

    band[ind++] = error_calidad.textContent = FV.validate(myFormData.get('Calidad'), 'required | max_length[250]')
    band[ind++] = error_nacionalidad_select.textContent = FV.validate(myFormData.get('Nacionalidad'), 'required | max_length[45]')
        //nacionalidad
    if (myFormData.get('Nacionalidad') != 'MEXICANA')
        band[ind++] = error_nacionalidad_otro.textContent = FV.validate(myFormData.get('Nacionalidad_Otro'), 'required | max_length[45]')
    band[ind++] = error_genero.textContent = FV.validate(myFormData.get('Genero'), 'required | length[1]')


    band[ind++] = error_telefono.textContent = FV.validate(myFormData.get('Telefono'), 'max_length[20]')
    band[ind++] = error_correo.textContent = FV.validate(myFormData.get('Correo'), 'max_length[100]')
    band[ind++] = error_identificacion_select.textContent = FV.validate(myFormData.get('Identificacion'), 'required | max_length[45]')
    if (myFormData.get('Identificacion') == 'Otro')
        band[ind++] = error_identificacion_otro.textContent = FV.validate(myFormData.get('Identificacion_Otro'), 'required | max_length[45]')
    band[ind++] = error_num_identificacion.textContent = FV.validate(myFormData.get('Num_Identificacion'), 'max_length[45]')

    //domicilio del detenido
    band[ind++] = error_colonia_domEntrev.textContent = FV.validate(myFormData.get('Colonia_Dom_Entrev'), 'max_length[500]')
    band[ind++] = error_calle_1_domEntrev.textContent = FV.validate(myFormData.get('Calle_1_Dom_Entrev'), 'max_length[100]')
    band[ind++] = error_no_ext_domEntrev.textContent = FV.validate(myFormData.get('No_Ext_Dom_Entrev'), 'max_length[100]')
    band[ind++] = error_no_int_domEntrev.textContent = FV.validate(myFormData.get('No_Int_Dom_Entrev'), 'max_length[100]')
    band[ind++] = error_coord_x_domEntrev.textContent = FV.validate(myFormData.get('Coordenada_X_Dom_Entrev'), 'max_length[45]')
    band[ind++] = error_coord_y_domEntrev.textContent = FV.validate(myFormData.get('Coordenada_Y_Dom_Entrev'), 'max_length[45]')
    band[ind++] = error_estado_domEntrev.textContent = FV.validate(myFormData.get('Estado_Dom_Entrev'), 'max_length[850]')
    band[ind++] = error_municipio_domEntrev.textContent = FV.validate(myFormData.get('Municipio_Dom_Entrev'), 'max_length[850]')
    band[ind++] = error_cp_domEntrev.textContent = FV.validate(myFormData.get('CP_Dom_Entrev'), 'max_length[45]')
    band[ind++] = error_referencias_domEntrev.textContent = FV.validate(myFormData.get('Referencias_Dom_Entrev'), 'max_length[850]')

    // relato entrevista
    band[ind++] = error_relato_entrevista.textContent = FV.validate(myFormData.get('Relato_Entrevista'), 'max_length[50000]')

    // traslado entrevistado
    band[ind++] = error_canalizacion.textContent = FV.validate(myFormData.get('Canalizacion'), 'required | length[1]')
    if (myFormData.get('Canalizacion') == '1') {
        band[ind++] = error_lugar_canalizacion.textContent = FV.validate(myFormData.get('Lugar_Canalizacion'), 'required | max_length[45]')
        band[ind++] = error_descripcion_canalizacion.textContent = FV.validate(myFormData.get('Descripcion_Canalizacion'), 'required | max_length[500]')
    }

    // primer respondiente
    band[ind++] = error_primer_respondiente_radio.textContent = FV.validate(myFormData.get('Primer_Respondiente_Radio'), 'required | length[1]')
    if (myFormData.get('Primer_Respondiente_Radio') == '1') {
        band[ind++] = error_nombre_pr.textContent = FV.validate(myFormData.get('Nombre_PR'), 'required | max_length[250]')
        band[ind++] = error_ap_pat_pr.textContent = FV.validate(myFormData.get('Ap_Paterno_PR'), 'required | max_length[250]')
        band[ind++] = error_ap_mat_pr.textContent = FV.validate(myFormData.get('Ap_Materno_PR'), 'required | max_length[250]')
        band[ind++] = error_institucion_pr.textContent = FV.validate(myFormData.get('Institucion_PR'), 'required | max_length[250]')
        band[ind++] = error_cargo_pr.textContent = FV.validate(myFormData.get('Cargo_PR'), 'required | max_length[250]')
        band[ind++] = FV.validate(myFormData.get('No_Control_PR'), 'max_length[45]')
    }

    //excape "" relato entrevista
    document.getElementById('id_relato_entrevista').value.replace(/[“”]/g,'"');

    //se comprueban todas las validaciones
    let success = true
    band.forEach(element => {
        success &= (element == '') ? true : false
    })

    goToTop();
    if (success) {
        //Solo hay 2: 
        //-----insertar nuevo
        //-----actualizar existente
        let tipo_post = (event.target.id == 'guardar_crear') ? 0 : 1
        myFormData.append('Tipo_Form', tipo_post)
        fetch(base_url_js + 'Juridico/insertUpdateAnexoEFetch', {
                method: 'POST',
                body: myFormData
            })
            .then(response => {
                if (response.ok) {
                    return response.json()
                } else {
                    throw 'Error en el servidor. Intente de nuevo, si el problema persiste, comuníquese con el equipo de Desarrollo.'
                }
            })
            .then(myJson => {
                console.log(myJson);
                if (myJson.resp_case.startsWith('error')) {
                    showErrorInAlert(myJson.error_message)
                    buttonForm.disabled = false
                    buttonForm.textContent = 'Guardar Cambios'
                    cancelButton.classList.remove('mi_hide')
                }
                alert_result.classList.remove('text-center')
                switch (myJson.resp_case) {
                    case 'error_interno': //error de petición
                    case 'error_post': //error de petición
                    case 'error_db': //error de base de datos
                        break
                    case 'error_session': //error de sesión
                        let html_for_session = `
                                            <p>Sucedio un error, su sesión caduco o no tiene los permisos necesarios. Por favor vuelva a iniciar sesión.</p>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalLogin">
                                                Iniciar sesión
                                            </button>`
                        alert_result.classList.add('text-center')
                        showErrorInAlert(html_for_session)
                        break
                    case 'error_form': //error de formulario
                        //reservar datos entrevistado
                        error_reservar_datos.textContent = myJson.error_reservar_datos

                        //fecha/hora entrevista
                        error_fecha.textContent = myJson.error_fecha
                        error_hora.textContent = myJson.error_hora

                        // datos generales del entrevistado
                        error_nombre_ent.textContent = myJson.error_nombre_ent
                        error_ap_pat_ent.textContent = myJson.error_ap_pat_ent
                        error_ap_mat_ent.textContent = myJson.error_ap_mat_ent
                        error_calidad.textContent = myJson.error_calidad
                        error_nacionalidad_select.textContent = myJson.error_nacionalidad_select
                            //nacionalidad
                        if (myFormData.get('Nacionalidad') != 'MEXICANA')
                            error_nacionalidad_otro.textContent = myJson.error_nacionalidad_otro

                        error_genero.textContent = myJson.error_genero
                        error_fecha_nacimiento.textContent = myJson.error_fecha_nacimiento
                        error_edad.textContent = myJson.error_edad
                        error_telefono.textContent = myJson.error_telefono
                        error_correo.textContent = myJson.error_correo
                        error_identificacion_select.textContent = myJson.error_identificacion_select
                        if (myFormData.get('Identificacion') == 'Otro')
                            error_identificacion_otro.textContent = myJson.error_identificacion_otro
                        error_num_identificacion.textContent = myJson.error_num_identificacion

                        //domicilio del detenido
                        error_colonia_domEntrev.textContent = myJson.error_colonia_domEntrev
                        error_calle_1_domEntrev.textContent = myJson.error_calle_1_domEntrev
                        error_no_ext_domEntrev.textContent = myJson.error_no_ext_domEntrev
                        error_no_int_domEntrev.textContent = myJson.error_no_int_domEntrev
                        error_coord_x_domEntrev.textContent = myJson.error_coord_x_domEntrev
                        error_coord_y_domEntrev.textContent = myJson.error_coord_y_domEntrev
                        error_estado_domEntrev.textContent = myJson.error_estado_domEntrev
                        error_municipio_domEntrev.textContent = myJson.error_municipio_domEntrev
                        error_cp_domEntrev.textContent = myJson.error_cp_domEntrev
                        error_referencias_domEntrev.textContent = myJson.error_referencias_domEntrev

                        // relato entrevista
                        error_relato_entrevista.textContent = myJson.error_relato_entrevista

                        // traslado entrevistado
                        error_canalizacion.textContent = myJson.error_canalizacion
                        if (myFormData.get('Canalizacion') == '1') {
                            error_lugar_canalizacion.textContent = myJson.error_lugar_canalizacion
                            error_descripcion_canalizacion.textContent = myJson.error_descripcion_canalizacion
                        }
                        // primer respondiente
                        error_primer_respondiente_radio.textContent = myJson.error_primer_respondiente_radio
                        if (myFormData.get('Primer_Respondiente_Radio') == '1') {
                            error_nombre_pr.textContent = myJson.error_nombre_pr
                            error_ap_pat_pr.textContent = myJson.error_ap_pat_pr
                            error_ap_mat_pr.textContent = myJson.error_ap_mat_pr
                            error_institucion_pr.textContent = myJson.error_institucion_pr
                            error_cargo_pr.textContent = myJson.error_cargo_pr
                        }

                        break
                    case 'success': //registro guardado correctamente TODO CHIDO
                        showSuccessInAlert('Registro guardado exitósamente.')
                        setInterval(() => {
                            window.location = base_url_js + "Juridico/Puesta/" + myFormData.get('Id_Puesta') + "/ver";
                        }, 3500);
                        break
                }
            })
            .catch(err => {
                showErrorInAlert(err)
                buttonForm.disabled = false
                buttonForm.textContent = 'Guardar Cambios'
                cancelButton.classList.remove('mi_hide')
            })

    } else {

        buttonForm.disabled = false
        buttonForm.textContent = 'Guardar Cambios'
        cancelButton.classList.remove('mi_hide')

        console.log(`MALLL`);
        showErrorInAlert('Error en el formulario, checa los campos del formulario')
    }


}

function goToTop() {
    window.scroll({
        top: 100,
        behavior: "smooth",
    });
}

function showErrorInAlert(message) {
    alert_result = document.getElementById('id_alert_result')
    alert_result.parentNode.classList.remove('mi_hide')
    alert_result.classList.remove('alert-success')
    alert_result.classList.add('alert-danger')
    alert_result.innerHTML = message
}

function showSuccessInAlert(message) {
    alert_result = document.getElementById('id_alert_result')
    alert_result.parentNode.classList.remove('mi_hide')
    alert_result.classList.remove('alert-danger')
    alert_result.classList.add('alert-success')
    alert_result.innerHTML = message
}

function hideAlert() {
    alert_result.classList.add('mi_hide')
}