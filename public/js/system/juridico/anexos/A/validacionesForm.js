//get form element
let formAnexoA = document.getElementById('id_form_anexo_a')

/*--------------ALERTS------------*/
let alert_result = document.getElementById('id_alert_result')


/*------CAMPOS PARA ERRORES-------*/
//numero y fecha/hora detención
let error_num_detencion = document.getElementById('error_num_detencion')
let error_fecha = document.getElementById('error_fecha')
let error_hora = document.getElementById('error_hora')

//datos generales del detenido
let error_nombre_d = document.getElementById('error_nombre_d')
let error_ap_pat_d = document.getElementById('error_ap_pat_d')
let error_ap_mat_d = document.getElementById('error_ap_mat_d')
let error_apodo = document.getElementById('error_apodo')
let error_nacionalidad_radio = document.getElementById('error_nacionalidad_radio')
let error_nacionalidad_otro = document.getElementById('error_nacionalidad_otro')
let error_genero = document.getElementById('error_genero')
let error_fecha_nacimiento = document.getElementById('error_fecha_nacimiento')
let error_edad = document.getElementById('error_edad')
let error_identificacion_select = document.getElementById('error_identificacion_select')
let error_identificacion_otro = document.getElementById('error_identificacion_otro')
let error_num_identificacion = document.getElementById('error_num_identificacion')

//domicilio del detenido
let error_colonia_domDetenido = document.getElementById('error_colonia_domDetenido')
let error_calle_1_domDetenido = document.getElementById('error_calle_1_domDetenido')
let error_no_ext_domDetenido = document.getElementById('error_no_ext_domDetenido')
let error_no_int_domDetenido = document.getElementById('error_no_int_domDetenido')
let error_coord_x_domDetenido = document.getElementById('error_coord_x_domDetenido')
let error_coord_y_domDetenido = document.getElementById('error_coord_y_domDetenido')
let error_estado_domDetenido = document.getElementById('error_estado_domDetenido')
let error_municipio_domDetenido = document.getElementById('error_municipio_domDetenido')
let error_cp_domDetenido = document.getElementById('error_cp_domDetenido')
let error_referencias_domDetenido = document.getElementById('error_referencias_domDetenido')

//información adicional del detenido
let error_descripcion_detenido = document.getElementById('error_descripcion_detenido')
let error_lesiones_radio = document.getElementById('error_lesiones_radio')
let error_padecimiento_radio = document.getElementById('error_padecimiento_radio')
let error_grupo_v_radio = document.getElementById('error_grupo_v_radio')
let error_grupo_d_radio = document.getElementById('error_grupo_d_radio')
let error_padecimiento = document.getElementById('error_padecimiento')
let error_grupo_v = document.getElementById('error_grupo_v')
let error_grupo_d = document.getElementById('error_grupo_d')


//familiar del detenido
let error_familiar_radio = document.getElementById('error_familiar_radio')
let error_nombre_f = document.getElementById('error_nombre_f')
let error_ap_pat_f = document.getElementById('error_ap_pat_f')
let error_ap_mat_f = document.getElementById('error_ap_mat_f')
let error_telefono_f = document.getElementById('error_telefono_f')

// derechos del detenido
let error_derechos_radio = document.getElementById('error_derechos_radio')

//inspección del detenido
let error_obj_encontrado_radio = document.getElementById('error_obj_encontrado_radio')
let error_pert_encontrado_radio = document.getElementById('error_pert_encontrado_radio')

//ubicación de la detención
let error_ubicacion_det_radio = document.getElementById('error_ubicacion_det_radio')
let error_colonia_ubi_detencion = document.getElementById('error_colonia_ubi_detencion')
let error_calle_1_ubi_detencion = document.getElementById('error_calle_1_ubi_detencion')
let error_calle_2_ubi_detencion = document.getElementById('error_calle_2_ubi_detencion')
let error_no_ext_ubi_detencion = document.getElementById('error_no_ext_ubi_detencion')
let error_no_int_ubi_detencion = document.getElementById('error_no_int_ubi_detencion')
let error_coord_x_ubi_detencion = document.getElementById('error_coord_x_ubi_detencion')
let error_coord_y_ubi_detencion = document.getElementById('error_coord_y_ubi_detencion')
let error_estado_ubi_detencion = document.getElementById('error_estado_ubi_detencion')
let error_municipio_ubi_detencion = document.getElementById('error_municipio_ubi_detencion')
let error_cp_ubi_detencion = document.getElementById('error_cp_ubi_detencion')
let error_referencias_ubi_detencion = document.getElementById('error_referencias_ubi_detencion')

//lugar traslado detenido
let error_lugar_traslado = document.getElementById('error_lugar_traslado')
let error_desc_traslado = document.getElementById('error_desc_traslado')
let error_obs_detencion = document.getElementById('error_obs_detencion')

// primer respondiente
let error_primer_respondiente_radio = document.getElementById('error_primer_respondiente_radio')
let error_nombre_pr = document.getElementById('error_nombre_pr')
let error_ap_pat_pr = document.getElementById('error_ap_pat_pr')
let error_ap_mat_pr = document.getElementById('error_ap_mat_pr')
let error_institucion_pr = document.getElementById('error_institucion_pr')
let error_cargo_pr = document.getElementById('error_cargo_pr')

// segundo respondiente
let error_nombre_sr = document.getElementById('error_nombre_sr')
let error_ap_pat_sr = document.getElementById('error_ap_pat_sr')
let error_ap_mat_sr = document.getElementById('error_ap_mat_sr')
let error_institucion_sr = document.getElementById('error_institucion_sr')
let error_cargo_sr = document.getElementById('error_cargo_sr')

const checkFormAnexoA = (event) => {
    // console.log(event.target);
    // console.log(event.target.id);
    let buttonForm = document.getElementById(event.target.id)
    let cancelButton = document.getElementById('id_cancel_button')

    buttonForm.disabled = true
    buttonForm.textContent = 'Guardando...'
    cancelButton.classList.add('mi_hide')

    let myFormData = new FormData(formAnexoA)
    let band = [] //banderas success

    /*inician las validaciones campo por campo*/
    let FV = new FormValidator()
    let ind = 0

    //set rules
    //numero y fecha/hora detención
    band[ind++] = error_num_detencion.textContent = FV.validate(myFormData.get('Num_Detencion'), 'max_length[45]')
    band[ind++] = error_fecha.textContent = FV.validate(myFormData.get('Fecha'), 'required | date')
    band[ind++] = error_hora.textContent = FV.validate(myFormData.get('Hora'), 'required | time')

    //datos generales del detenido
    band[ind++] = error_nombre_d.textContent = FV.validate(myFormData.get('Nombre_D'), 'required | max_length[250]')
    band[ind++] = error_ap_pat_d.textContent = FV.validate(myFormData.get('Ap_Paterno_D'), 'required | max_length[250]')
    band[ind++] = error_ap_mat_d.textContent = FV.validate(myFormData.get('Ap_Materno_D'), 'required | max_length[250]')
    band[ind++] = error_apodo.textContent = FV.validate(myFormData.get('Apodo'), 'max_length[100]')
    band[ind++] = error_nacionalidad_radio.textContent = FV.validate(myFormData.get('Nacionalidad_Radio'), 'required')
        //nacionalidad
    if (myFormData.get('Nacionalidad_Radio') != 'MEXICANA')
        band[ind++] = error_nacionalidad_otro.textContent = FV.validate(myFormData.get('Nacionalidad_Otro'), 'required | max_length[45]')

    band[ind++] = error_genero.textContent = FV.validate(myFormData.get('Genero'), 'required | max_length[45]')
    band[ind++] = error_fecha_nacimiento.textContent = FV.validate(myFormData.get('Fecha_Nacimiento'), 'required | max_length[45]')
    band[ind++] = error_edad.textContent = FV.validate(myFormData.get('Edad'), 'required | max_length[2]')
    band[ind++] = error_edad.textContent = (parseInt(myFormData.get('Edad')) > 10) ? '' : 'Edad debe ser positiva mayor a 10'
    band[ind++] = error_identificacion_select.textContent = FV.validate(myFormData.get('Identificacion'), 'required | max_length[45]')
    if (myFormData.get('Identificacion') == 'Otro')
        band[ind++] = error_identificacion_otro.textContent = FV.validate(myFormData.get('Identificacion_Otro'), 'required | max_length[45]')
    band[ind++] = error_num_identificacion.textContent = FV.validate(myFormData.get('Num_Identificacion'), 'max_length[45]')

    //domicilio del detenido
    band[ind++] = error_colonia_domDetenido.textContent = FV.validate(myFormData.get('Colonia_Dom_Detenido'), 'max_length[500]')
    band[ind++] = error_calle_1_domDetenido.textContent = FV.validate(myFormData.get('Calle_1_Dom_Detenido'), 'max_length[100]')
    band[ind++] = error_no_ext_domDetenido.textContent = FV.validate(myFormData.get('No_Ext_Dom_Detenido'), 'max_length[100]')
    band[ind++] = error_no_int_domDetenido.textContent = FV.validate(myFormData.get('No_Int_Dom_Detenido'), 'max_length[100]')
    band[ind++] = error_coord_x_domDetenido.textContent = FV.validate(myFormData.get('Coordenada_X_Dom_Detenido'), 'max_length[45]')
    band[ind++] = error_coord_y_domDetenido.textContent = FV.validate(myFormData.get('Coordenada_Y_Dom_Detenido'), 'max_length[45]')
    band[ind++] = error_estado_domDetenido.textContent = FV.validate(myFormData.get('Estado_Dom_Detenido'), 'max_length[850]')
    band[ind++] = error_municipio_domDetenido.textContent = FV.validate(myFormData.get('Municipio_Dom_Detenido'), 'max_length[850]')
    band[ind++] = error_cp_domDetenido.textContent = FV.validate(myFormData.get('CP_Dom_Detenido'), 'max_length[45]')
    band[ind++] = error_referencias_domDetenido.textContent = FV.validate(myFormData.get('Referencias_Dom'), 'max_length[850]')

    // información adicional del detenido
    band[ind++] = error_descripcion_detenido.textContent = FV.validate(myFormData.get('Descripcion_Detenido'), 'required | max_length[10000]')
    band[ind++] = error_lesiones_radio.textContent = FV.validate(myFormData.get('Lesiones'), 'required | length[2]')
    band[ind++] = error_padecimiento_radio.textContent = FV.validate(myFormData.get('Padecimiento_Radio'), 'required | length[2]')
    if (myFormData.get('Padecimiento_Radio') != 'No')
        band[ind++] = error_padecimiento.textContent = FV.validate(myFormData.get('Descripcion_Padecimiento'), 'required | max_length[250]')
    band[ind++] = error_grupo_v_radio.textContent = FV.validate(myFormData.get('Grupo_V_Radio'), 'required | length[2]')
    if (myFormData.get('Grupo_V_Radio') != 'No')
        band[ind++] = error_grupo_v.textContent = FV.validate(myFormData.get('Grupo_Vulnerable'), 'required | max_length[250]')
    band[ind++] = error_grupo_d_radio.textContent = FV.validate(myFormData.get('Grupo_D_Radio'), 'required | length[2]')
    if (myFormData.get('Grupo_D_Radio') != 'No')
        band[ind++] = error_grupo_d.textContent = FV.validate(myFormData.get('Grupo_Delictivo'), 'required | max_length[250]')

    // familiar del detenido
    band[ind++] = error_familiar_radio.textContent = FV.validate(myFormData.get('Familiar_Radio'), 'required | length[2]')
    if (myFormData.get('Familiar_Radio') != 'No') {
        band[ind++] = error_nombre_f.textContent = FV.validate(myFormData.get('Nombre_F'), 'required | max_length[250]')
        band[ind++] = error_ap_pat_f.textContent = FV.validate(myFormData.get('Ap_Paterno_F'), 'max_length[250]')
        band[ind++] = error_ap_mat_f.textContent = FV.validate(myFormData.get('Ap_Materno_F'), 'max_length[250]')
        band[ind++] = error_telefono_f.textContent = FV.validate(myFormData.get('Telefono_F'), 'max_length[10]')
    }

    // derechos del detenido
    band[ind++] = error_derechos_radio.textContent = FV.validate(myFormData.get('Lectura_Derechos'), 'required | length[2]')

    //inspección del detenido
    band[ind++] = error_obj_encontrado_radio.textContent = FV.validate(myFormData.get('Objeto_Encontrado'), 'required | length[2]')
    band[ind++] = error_pert_encontrado_radio.textContent = FV.validate(myFormData.get('Pertenencias_Encontradas'), 'required | length[2]')
    if (myFormData.get('Pertenencias_Encontradas') != 'No') {
        if (!(pertenenciaArray.length > 0)) {
            band[ind++] = "Error personas array";
            //se muestra alert danger error por si esta activo
            document.getElementById('id_error_p_mode').classList.remove('mi_hide');


        } else {
            //se guardan en el formData las personas si es que hay alguna
            myFormData.append("Pertenencias_Detenido", JSON.stringify(pertenenciaArray));
        }
    }

    // lugar de la detención
    band[ind++] = error_ubicacion_det_radio.textContent = FV.validate(myFormData.get('Ubicacion_Det_Radio'), 'required')
    if (myFormData.get('Ubicacion_Det_Radio') != 'Sí') {
        band[ind++] = error_colonia_ubi_detencion.textContent = FV.validate(myFormData.get('Colonia_Ubi_Det'), 'max_length[450]')
        band[ind++] = error_calle_1_ubi_detencion.textContent = FV.validate(myFormData.get('Calle_1_Ubi_Det'), 'max_length[450]')
        band[ind++] = error_calle_2_ubi_detencion.textContent = FV.validate(myFormData.get('Calle_2_Ubi_Det'), 'max_length[450]')
        band[ind++] = error_no_ext_ubi_detencion.textContent = FV.validate(myFormData.get('No_Ext_Ubi_Det'), 'max_length[45]')
        band[ind++] = error_no_int_ubi_detencion.textContent = FV.validate(myFormData.get('No_Int_Ubi_Det'), 'max_length[45]')
        band[ind++] = error_coord_x_ubi_detencion.textContent = FV.validate(myFormData.get('Coordenada_X_Ubi_Det'), 'max_length[45]')
        band[ind++] = error_coord_y_ubi_detencion.textContent = FV.validate(myFormData.get('Coordenada_Y_Ubi_Det'), 'max_length[45]')
        band[ind++] = error_estado_ubi_detencion.textContent = FV.validate(myFormData.get('Estado_Ubi_Det'), 'max_length[600]')
        band[ind++] = error_municipio_ubi_detencion.textContent = FV.validate(myFormData.get('Municipio_Ubi_Det'), 'max_length[600]')
        band[ind++] = error_cp_ubi_detencion = FV.validate(myFormData.get('CP_Ubi_Det'), 'max_length[45]')
        band[ind++] = error_referencias_ubi_detencion.textContent = FV.validate(myFormData.get('Referencias_Ubi_Det'), 'max_length[800]')
    }

    //lugar traslado detenido
    band[ind++] = error_lugar_traslado.textContent = FV.validate(myFormData.get('Lugar_Traslado'), 'required | max_length[450]')
    band[ind++] = error_desc_traslado.textContent = FV.validate(myFormData.get('Descripcion_Traslado'), 'required | max_length[450]')
    band[ind++] = error_obs_detencion.textContent = FV.validate(myFormData.get('Observaciones_Detencion'), 'max_length[10000]')

    // primer respondiente
    band[ind++] = error_primer_respondiente_radio.textContent = FV.validate(myFormData.get('Primer_Respondiente_Radio'), 'required | length[2]')
    if (myFormData.get('Primer_Respondiente_Radio') != 'No') {
        band[ind++] = error_nombre_pr.textContent = FV.validate(myFormData.get('Nombre_PR'), 'required | max_length[250]')
        band[ind++] = error_ap_pat_pr.textContent = FV.validate(myFormData.get('Ap_Paterno_PR'), 'required | max_length[250]')
        band[ind++] = error_ap_mat_pr.textContent = FV.validate(myFormData.get('Ap_Materno_PR'), 'required | max_length[250]')
        band[ind++] = error_institucion_pr.textContent = FV.validate(myFormData.get('Institucion_PR'), 'required | max_length[250]')
        band[ind++] = error_cargo_pr.textContent = FV.validate(myFormData.get('Cargo_PR'), 'required | max_length[250]')
        band[ind++] = FV.validate(myFormData.get('No_Control_PR'), 'max_length[45]')

        band[ind++] = error_nombre_sr.textContent = FV.validate(myFormData.get('Nombre_SR'), 'max_length[250]')
        band[ind++] = error_ap_pat_sr.textContent = FV.validate(myFormData.get('Ap_Paterno_SR'), 'max_length[250]')
        band[ind++] = error_ap_mat_sr.textContent = FV.validate(myFormData.get('Ap_Materno_SR'), 'max_length[250]')
        band[ind++] = error_institucion_sr.textContent = FV.validate(myFormData.get('Institucion_SR'), 'max_length[250]')
        band[ind++] = error_cargo_sr.textContent = FV.validate(myFormData.get('Cargo_SR'), 'max_length[250]')
        band[ind++] = FV.validate(myFormData.get('No_Control_SR'), 'max_length[45]')
    }

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
        let url_tipo_fetch = (event.target.id == 'guardar_crear') ? base_url_js + 'Juridico/insertAnexoAFetch' : base_url_js + 'Juridico/updateAnexoAFetch';

        fetch(url_tipo_fetch, {
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
                        //numero y fecha/hora detención
                        error_num_detencion.textContent = myJson.error_num_detencion
                        error_fecha.textContent = myJson.error_fecha
                        error_hora.textContent = myJson.error_hora

                        //datos generales del detenido
                        error_nombre_d.textContent = myJson.error_nombre_d
                        error_ap_pat_d.textContent = myJson.error_ap_pat_d
                        error_ap_mat_d.textContent = myJson.error_ap_mat_d
                        error_apodo.textContent = myJson.error_apodo
                        error_nacionalidad_radio.textContent = myJson.error_nacionalidad_radio
                            //nacionalidad
                        if (myFormData.get('Nacionalidad_Radio') != 'MEXICANA')
                            error_nacionalidad_otro.textContent = myJson.error_nacionalidad_otro

                        error_genero.textContent = myJson.error_genero
                        error_fecha_nacimiento.textContent = myJson.error_fecha_nacimiento
                        error_edad.textContent = myJson.error_edad
                        error_identificacion_select.textContent = myJson.error_identificacion_select
                        if (myFormData.get('Identificacion') == 'Otro')
                            error_identificacion_otro.textContent = myJson.error_identificacion_otro
                        error_num_identificacion.textContent = myJson.error_num_identificacion

                        //domicilio del detenido
                        error_colonia_domDetenido.textContent = myJson.error_colonia_domDetenido
                        error_calle_1_domDetenido.textContent = myJson.error_calle_1_domDetenido
                        error_no_ext_domDetenido.textContent = myJson.error_no_ext_domDetenido
                        error_no_int_domDetenido.textContent = myJson.error_no_int_domDetenido
                        error_coord_x_domDetenido.textContent = myJson.error_coord_x_domDetenido
                        error_coord_y_domDetenido.textContent = myJson.error_coord_y_domDetenido
                        error_estado_domDetenido.textContent = myJson.error_estado_domDetenido
                        error_municipio_domDetenido.textContent = myJson.error_municipio_domDetenido
                        error_cp_domDetenido.textContent = myJson.error_cp_domDetenido
                        error_referencias_domDetenido.textContent = myJson.error_referencias_domDetenido

                        // información adicional del detenido
                        error_descripcion_detenido.textContent = myJson.error_descripcion_detenido
                        error_lesiones_radio.textContent = myJson.error_lesiones_radio
                        error_padecimiento_radio.textContent = myJson.error_padecimiento_radio
                        if (myFormData.get('Padecimiento_Radio') != 'No')
                            error_padecimiento.textContent = myJson.error_padecimiento
                        error_grupo_v_radio.textContent = myJson.error_grupo_v_radio
                        if (myFormData.get('Grupo_V_Radio') != 'No')
                            error_grupo_v.textContent = myJson.error_grupo_v
                        error_grupo_d_radio.textContent = myJson.error_grupo_d_radio
                        if (myFormData.get('Grupo_D_Radio') != 'No')
                            error_grupo_d.textContent = myJson.error_grupo_d

                        // familiar del detenido
                        error_familiar_radio.textContent = myJson.error_familiar_radio
                        if (myFormData.get('Familiar_Radio') != 'No') {
                            error_nombre_f.textContent = myJson.error_nombre_f
                            error_ap_pat_f.textContent = myJson.error_ap_pat_f
                            error_ap_mat_f.textContent = myJson.error_ap_mat_f
                            error_telefono_f.textContent = myJson.error_telefono_f
                        }

                        // derechos del detenido
                        error_derechos_radio.textContent = myJson.error_derechos_radio

                        //inspección del detenido
                        error_obj_encontrado_radio.textContent = myJson.error_obj_encontrado_radio
                        error_pert_encontrado_radio.textContent = myJson.error_pert_encontrado_radio
                        if (myFormData.get('Pertenencias_Encontradas') != 'No') {
                            if (!(pertenenciaArray.length > 0)) {
                                //se muestra alert danger error por si esta activo
                                document.getElementById('id_error_p_mode').classList.remove('mi_hide');
                            } else {
                                //se guardan en el formData las personas si es que hay alguna
                                myFormData.append("Pertenencias_Detenido", JSON.stringify(pertenenciaArray));
                            }
                        }

                        // lugar de la detención
                        if (myFormData.get('Ubicacion_Det_Radio') != 'Sí') {
                            error_colonia_ubi_detencion.textContent = myJson.error_colonia_ubi_detencion
                            error_calle_1_ubi_detencion.textContent = myJson.error_calle_1_ubi_detencion
                            error_calle_2_ubi_detencion.textContent = myJson.error_calle_2_ubi_detencion
                            error_no_ext_ubi_detencion.textContent = myJson.error_no_ext_ubi_detencion
                            error_no_int_ubi_detencion.textContent = myJson.error_no_int_ubi_detencion
                            error_coord_x_ubi_detencion.textContent = myJson.error_coord_x_ubi_detencion
                            error_coord_y_ubi_detencion.textContent = myJson.error_coord_y_ubi_detencion
                            error_estado_ubi_detencion.textContent = myJson.error_estado_ubi_detencion
                            error_municipio_ubi_detencion.textContent = myJson.error_municipio_ubi_detencion
                            error_cp_ubi_detencion = myJson.error_cp_ubi_detencion
                        }

                        //lugar traslado detenido
                        error_lugar_traslado.textContent = myJson.error_lugar_traslado
                        error_desc_traslado.textContent = myJson.error_desc_traslado
                        error_obs_detencion.textContent = myJson.error_obs_detencion

                        // primer respondiente
                        error_primer_respondiente_radio.textContent = myJson.error_primer_respondiente_radio
                        if (myFormData.get('Primer_Respondiente_Radio') != 'No') {
                            error_nombre_pr.textContent = myJson.error_nombre_pr
                            error_ap_pat_pr.textContent = myJson.error_ap_pat_pr
                            error_ap_mat_pr.textContent = myJson.error_ap_mat_pr
                            error_institucion_pr.textContent = myJson.error_institucion_pr
                            error_cargo_pr.textContent = myJson.error_cargo_pr
                                //segundo respondiente
                            error_nombre_sr.textContent = myJson.error_nombre_sr
                            error_ap_pat_sr.textContent = myJson.error_ap_pat_sr
                            error_ap_mat_sr.textContent = myJson.error_ap_mat_sr
                            error_institucion_sr.textContent = myJson.error_institucion_sr
                            error_cargo_sr.textContent = myJson.error_cargo_sr
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