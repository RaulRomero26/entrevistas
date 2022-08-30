//get form element
let formAnexoB = document.getElementById('id_form_anexo_b')

/*--------------ALERTS------------*/
let alert_result = document.getElementById('id_alert_result')

/*------CAMPOS PARA ERRORES-------*/

//nivel del uso de la fuerza
let error_num_lesionados_autoridad = document.getElementById('error_num_lesionados_autoridad')
let error_num_lesionados_persona = document.getElementById('error_num_lesionados_persona')
let error_num_fallecidos_autoridad = document.getElementById('error_num_fallecidos_autoridad')
let error_num_fallecidos_persona = document.getElementById('error_num_fallecidos_persona')

let error_descripcion_conducta = document.getElementById('error_descripcion_conducta')
let error_asistencia_med_radio = document.getElementById('error_asistencia_med_radio')
let error_asistencia_medica = document.getElementById('error_asistencia_medica')

//prerror_imer respondiente
let error_primer_respondiente_radio = document.getElementById('error_primer_respondiente_radio')
let error_nombre_pr = document.getElementById('error_nombre_pr')
let error_ap_pat_pr = document.getElementById('error_ap_pat_pr')
let error_ap_mat_pr = document.getElementById('error_ap_mat_pr')
let error_institucion_pr = document.getElementById('error_institucion_pr')
let error_cargo_pr = document.getElementById('error_cargo_pr')
let error_no_control_pr = document.getElementById('error_no_control_pr')

// serror_egundo respondiente
let error_nombre_sr = document.getElementById('error_nombre_sr')
let error_ap_pat_sr = document.getElementById('error_ap_pat_sr')
let error_ap_mat_sr = document.getElementById('error_ap_mat_sr')
let error_institucion_sr = document.getElementById('error_institucion_sr')
let error_cargo_sr = document.getElementById('error_cargo_sr')
let error_no_control_sr = document.getElementById('error_no_control_sr')

const checkFormAnexoB = (event) => {

    let buttonForm = document.getElementById(event.target.id)
    let cancelButton = document.getElementById('id_cancel_button')

    buttonForm.disabled = true
    buttonForm.textContent = 'Guardando...'
    cancelButton.classList.add('mi_hide')

    let myFormData = new FormData(formAnexoB)
    let band = [] //banderas success

    /*inician las validaciones campo por campo*/
    let FV = new FormValidator()
    let ind = 0

    //set rules
    //numero y fecha/hora detención
    band[ind++] = error_num_lesionados_autoridad.textContent = FV.validate(myFormData.get('Num_Lesionados_Autoridad'), 'required | numeric | max_length[25]')
    band[ind++] = error_num_lesionados_persona.textContent = FV.validate(myFormData.get('Num_Lesionados_Persona'), 'required | numeric | max_length[25]')
    band[ind++] = error_num_fallecidos_autoridad.textContent = FV.validate(myFormData.get('Num_Fallecidos_Autoridad'), 'required | numeric | max_length[25]')
    band[ind++] = error_num_fallecidos_persona.textContent = FV.validate(myFormData.get('Num_Fallecidos_Persona'), 'required | numeric | max_length[25]')

    band[ind++] = error_descripcion_conducta.textContent = FV.validate(myFormData.get('Descripcion_Conducta'), 'required | max_length[2500]')
    band[ind++] = error_asistencia_med_radio.textContent = FV.validate(myFormData.get('Asistencia_Med_Radio'), 'required | length[1]')

    if (myFormData.get('Asistencia_Med_Radio') == '1') {
        band[ind++] = error_asistencia_medica.textContent = FV.validate(myFormData.get('Asistencia_Medica'), 'required | max_length[2500]')
    }

    // primer respondiente
    band[ind++] = error_primer_respondiente_radio.textContent = FV.validate(myFormData.get('Primer_Respondiente_Radio'), 'required | length[1]')
    if (myFormData.get('Primer_Respondiente_Radio') == '1') {
        band[ind++] = error_nombre_pr.textContent = FV.validate(myFormData.get('Nombre_PR'), 'required | max_length[250]')
        band[ind++] = error_ap_pat_pr.textContent = FV.validate(myFormData.get('Ap_Paterno_PR'), 'required | max_length[250]')
        band[ind++] = error_ap_mat_pr.textContent = FV.validate(myFormData.get('Ap_Materno_PR'), 'required | max_length[250]')
        band[ind++] = error_institucion_pr.textContent = FV.validate(myFormData.get('Institucion_PR'), 'required | max_length[250]')
        band[ind++] = error_cargo_pr.textContent = FV.validate(myFormData.get('Cargo_PR'), 'required | max_length[250]')
        band[ind++] = error_nombre_sr.textContent = FV.validate(myFormData.get('Nombre_SR'), 'max_length[250]')
        band[ind++] = error_ap_pat_sr.textContent = FV.validate(myFormData.get('Ap_Paterno_SR'), 'max_length[250]')
        band[ind++] = error_ap_mat_sr.textContent = FV.validate(myFormData.get('Ap_Materno_SR'), 'max_length[250]')
        band[ind++] = error_institucion_sr.textContent = FV.validate(myFormData.get('Institucion_SR'), 'max_length[250]')
        band[ind++] = error_cargo_sr.textContent = FV.validate(myFormData.get('Cargo_SR'), 'max_length[250]')
        band[ind++] = FV.validate(myFormData.get('No_Control_PR'), 'max_length[45]')
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
        let tipo_post = (event.target.id == 'guardar_crear') ? 0 : 1
        myFormData.append('Tipo_Form', tipo_post)
        fetch(base_url_js + 'Juridico/insertUpdateAnexoBFetch', {
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
                        error_num_lesionados_autoridad.textContent = myJson.error_num_lesionados_autoridad
                        error_num_lesionados_persona.textContent = myJson.error_num_lesionados_persona
                        error_num_fallecidos_autoridad.textContent = myJson.error_num_fallecidos_autoridad
                        error_num_fallecidos_persona.textContent = myJson.error_num_fallecidos_persona
                        error_descripcion_conducta.textContent = myJson.error_descripcion_conducta
                        error_asistencia_med_radio.textContent = myJson.error_asistencia_med_radio

                        if (myFormData.get('Asistencia_Med_Radio') == '1') {
                            error_asistencia_medica.textContent = myJson.error_asistencia_medica
                        }

                        // primer respondiente
                        error_primer_respondiente_radio.textContent = myJson.error_primer_respondiente_radio
                        if (myFormData.get('Primer_Respondiente_Radio') == '1') {
                            error_nombre_pr.textContent = myJson.error_nombre_pr
                            error_ap_pat_pr.textContent = myJson.error_ap_pat_pr
                            error_ap_mat_pr.textContent = myJson.error_ap_mat_pr
                            error_institucion_pr.textContent = myJson.error_institucion_pr
                            error_cargo_pr.textContent = myJson.error_cargo_pr
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