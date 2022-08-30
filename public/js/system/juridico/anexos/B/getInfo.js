/** ----------- Cargar info desde fetch-----------*/
let id_puesta = document.getElementById('id_puesta').value
let id_informe = document.getElementById('id_informe').value

function cargarInfoAnexoB() {
    let formData = new FormData()
    formData.append('Id_Puesta', id_puesta)
    formData.append('Id_Informe', id_informe)
    fetch(base_url_js + 'Juridico/getInfoAnexoBFetch', {
            method: 'post',
            body: formData
        })
        .then(resp => {
            if (resp.ok) return resp.json()
            else throw 'Error desde la respuesta en json'
        })
        .then(myJson => {
            console.log(myJson);
            if (myJson.resp_case.startsWith('error')) {
                showErrorInAlert(myJson.error_message)
            }
            switch (myJson.resp_case) {
                case 'error_interno': //error de petición
                    break
                case 'error_post': //error de petición
                    break
                case 'error_db': //error de base de datos
                    setTimeout(() => {
                        window.location = base_url_js + "Juridico";
                    }, 3000);
                    break
                case 'error_session': //error de sesión
                    let html_for_session = `
                                        <p>Sucedio un error, su sesión caduco o no tiene los permisos necesarios. Por favor vuelva a iniciar sesión.</p>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalLogin">
                                            Iniciar sesión
                                        </button>`
                    showErrorInAlert(html_for_session)
                    break
                case 'success': //registro guardado correctamente TODO CHIDO
                    setInfoData(myJson.apartados)
                    changeEditSeeMode(modo_actual)
                    document.getElementById('guardar_crear').id = 'editar_registro'
                    break
            }
        })
        .catch(err => {
            showErrorInAlert(err)
        })
}

function setInfoData(data) {
    let Informe = data.Informe
    let Primer_Resp = data.Primer_Resp
    let Segundo_Resp = data.Segundo_Resp
    let Puesta = data.Puesta

    //Caso de Puesta Concluida
    if (Puesta.Estatus == '1') { edit_see_button.classList.add('mi_hide') }
    //nivel del uso de la fuerza
    num_lesionados_autoridad.value = Informe.Num_Lesionados_Autoridad
    num_lesionados_persona.value = Informe.Num_Lesionados_Persona
    num_fallecidos_autoridad.value = Informe.Num_Fallecidos_Autoridad
    num_fallecidos_persona.value = Informe.Num_Fallecidos_Persona

    reduccion_movimiento.checked = (Informe.Reduccion_Movimiento == '1') ? 'true' : ''
    armas_incapacitantes.checked = (Informe.Armas_Incapacitantes == '1') ? 'true' : ''
    armas_fuego.checked = (Informe.Armas_Fuego == '1') ? 'true' : ''

    descripcion_conducta.value = Informe.Descripcion_Conducta
    if (Informe.Asistencia_Medica != null && Informe.Asistencia_Medica != '') { //se da check al radio de asistencia y se muestra campo
        rad_Asistencia_M[1].checked = true
        asistencia_panel.classList.remove("mi_hide")
        asistencia_medica.disabled = false
        asistencia_medica.value = Informe.Asistencia_Medica
    } else {
        rad_Asistencia_M[0].checked = true
        asistencia_panel.classList.add("mi_hide")
        asistencia_medica.disabled = true
        asistencia_medica.value = ''
    }

    //primer respondiente
    if (Puesta.Id_Primer_Respondiente == Informe.Id_Primer_Respondiente) { //se oculta panel primer respondiente
        rad_PR[0].checked = true
        pr_panel.classList.add("mi_hide")
    } else { //se muestra panel y se asiganan valores
        rad_PR[1].checked = true
        pr_panel.classList.remove("mi_hide")
        nombre_pr.value = Primer_Resp.Nombre_PR
        ap_pat_pr.value = Primer_Resp.Ap_Paterno_PR
        ap_mat_pr.value = Primer_Resp.Ap_Materno_PR
        institucion_pr.value = Primer_Resp.Institucion
        cargo_pr.value = Primer_Resp.Cargo
        no_control_pr.value = Primer_Resp.No_Control
            //segundo respondiente
        nombre_sr.value = Segundo_Resp.Nombre_PR
        ap_pat_sr.value = Segundo_Resp.Ap_Paterno_PR
        ap_mat_sr.value = Segundo_Resp.Ap_Materno_PR
        institucion_sr.value = Segundo_Resp.Institucion
        cargo_sr.value = Segundo_Resp.Cargo
        no_control_sr.value = Segundo_Resp.No_Control
    }

}


/**------------------------Set Edit / See Mode------------------------------- */
let edit_see_button = document.getElementById('id_edit_button')
let modo_actual = true

function changeEditSeeMode(modo) {
    edit_see_button.textContent = (modo) ? 'Editar registro' : 'Solo lectura'

    //nivel del uso de la fuerza
    num_lesionados_autoridad.disabled = modo
    num_lesionados_persona.disabled = modo
    num_fallecidos_autoridad.disabled = modo
    num_fallecidos_persona.disabled = modo

    reduccion_movimiento.disabled = modo
    armas_incapacitantes.disabled = modo
    armas_fuego.disabled = modo

    descripcion_conducta.disabled = modo
    rad_Asistencia_M[0].disabled = modo
    rad_Asistencia_M[1].disabled = modo
    if (rad_Asistencia_M[1].checked) { //se da check al radio de asistencia y se muestra campo
        asistencia_medica.disabled = modo
    } else {
        asistencia_medica.disabled = modo
    }

    //primer respondiente
    rad_PR[0].disabled = modo
    rad_PR[1].disabled = modo
    if (rad_PR[1].checked) { //se bloquea valores de elementos
        if (modo) {
            document.getElementById('id_busqueda_pr_panel').classList.add('mi_hide')
            document.getElementById('id_busqueda_sr_panel').classList.add('mi_hide')
        } else {
            document.getElementById('id_busqueda_pr_panel').classList.remove('mi_hide')
            document.getElementById('id_busqueda_sr_panel').classList.remove('mi_hide')
        }
        nombre_pr.disabled = modo
        ap_pat_pr.disabled = modo
        ap_mat_pr.disabled = modo
        institucion_pr.disabled = modo
        cargo_pr.disabled = modo
        no_control_pr.disabled = modo
            //segundo respondiente
        nombre_sr.disabled = modo
        ap_pat_sr.disabled = modo
        ap_mat_sr.disabled = modo
        institucion_sr.disabled = modo
        cargo_sr.disabled = modo
        no_control_sr.disabled = modo
    }

    if (modo) document.getElementById('id_send_buttons_panel').classList.add('mi_hide')
    else document.getElementById('id_send_buttons_panel').classList.remove('mi_hide')
}

// Window on loaded
window.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('id_edit_button_panel').classList.remove('mi_hide')
    cargarInfoAnexoB()

    edit_see_button.addEventListener('click', (e) => {
        modo_actual = !modo_actual
        changeEditSeeMode(modo_actual)
    })
});