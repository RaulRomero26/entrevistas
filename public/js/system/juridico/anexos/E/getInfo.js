/** ----------- Cargar info desde fetch-----------*/
let id_puesta = document.getElementById('id_puesta').value
let id_entrevista = document.getElementById('id_entrevista').value

function cargarInfoAnexoE() {
    let formData = new FormData()
    formData.append('Id_Puesta', id_puesta)
    formData.append('Id_Entrevista', id_entrevista)
    fetch(base_url_js + 'Juridico/getInfoAnexoEFetch', {
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
    let Entrevista = data.Entrevista
    let Primer_Resp = data.Primer_Resp
    let Domicilio = data.Domicilio
    let Puesta = data.Puesta

    //Caso de Puesta Concluida
    if (Puesta.Estatus == '1') { edit_see_button.classList.add('mi_hide') }

    //reservar datos entrevistado
    if (Entrevista.Reservar_Datos == '1') {
        rad_Preservar_D[1].checked = true
    } else {
        rad_Preservar_D[0].checked = true
    }

    //fecha/hora entrevista
    fecha.value = Entrevista.Fecha_Hora.substring(0, 10)
    hora.value = Entrevista.Fecha_Hora.substring(11, 16)

    // datos generales del entrevistado
    nombre_ent.value = Entrevista.Nombre_Ent
    ap_pat_ent.value = Entrevista.Ap_Paterno_Ent
    ap_mat_ent.value = Entrevista.Ap_Materno_Ent
    calidad.value = Entrevista.Calidad
        //nacionalidad
    if (Entrevista.Nacionalidad != 'MEXICANA') {
        nacionalidad_panel.classList.remove("mi_hide");
        nacionalidad_otro.disabled = false
        nacionalidad_otro.value = Entrevista.Nacionalidad
        nacionalidad_select.value = 'EXTRANJERA'

    } else {
        nacionalidad_panel.classList.add("mi_hide");
        nacionalidad_otro.disabled = true
        nacionalidad_otro.value = ''
        nacionalidad_select.value = 'MEXICANA'

    }
    genero.value = Entrevista.Genero
    fecha_nacimiento.value = Entrevista.Fecha_Nacimiento
    edad.value = Entrevista.Edad
    telefono.value = Entrevista.Telefono
    correo.value = Entrevista.Correo
        //identificacion select
    const identificaciones = ['Credencial INE', 'Licencia', 'Pasaporte', 'No'];
    if (identificaciones.includes(Entrevista.Identificacion)) { //no es otro
        identificacion_select.value = Entrevista.Identificacion
        identificacion_panel.classList.add("mi_hide");
        identificacion_otro.disabled = true
        identificacion_otro.value = ''
    } else { //si es Otro
        identificacion_select.value = 'Otro'
        identificacion_panel.classList.remove("mi_hide");
        identificacion_otro.disabled = false
        identificacion_otro.value = Entrevista.Identificacion
    }
    num_identificacion.value = Entrevista.Num_Identificacion

    //domicilio del entrevistado
    colonia_domEntrev.value = Domicilio.Colonia
    calle_1_domEntrev.value = Domicilio.Calle
    no_ext_domEntrev.value = Domicilio.No_Exterior
    no_int_domEntrev.value = Domicilio.No_Interior
    coord_x_domEntrev.value = Domicilio.Coordenada_X
    coord_y_domEntrev.value = Domicilio.Coordenada_Y
    estado_domEntrev.value = Domicilio.Estado
    municipio_domEntrev.value = Domicilio.Municipio
    cp_domEntrev.value = Domicilio.CP
    referencias_domEntrev.value = Domicilio.Referencias

    // relato de la entrevista
    relato_entrevista.value = Entrevista.Relato_Entrevista.replace(/[“”]/g,'"')

    // traslado de la persona entrevistada
    if (Entrevista.Canalizacion == '1') {
        rad_Traslado[1].checked = true
        traslado_panel.classList.remove('mi_hide')
        lugar_canalizacion.value = Entrevista.Lugar_Canalizacion
        descripcion_canalizacion.value = Entrevista.Descripcion_Canalizacion

    } else {
        rad_Traslado[0].checked = true
        traslado_panel.classList.add('mi_hide')
        lugar_canalizacion.disabled = true
        descripcion_canalizacion.disabled = true
    }

    //primer respondiente
    if (Puesta.Id_Primer_Respondiente == Entrevista.Id_Primer_Respondiente) { //se oculta panel primer respondiente
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
    }

}


/**------------------------Set Edit / See Mode------------------------------- */
let edit_see_button = document.getElementById('id_edit_button')
let modo_actual = true

function changeEditSeeMode(modo) {
    edit_see_button.textContent = (modo) ? 'Editar registro' : 'Solo lectura'

    //reservar datos entrevistado
    rad_Preservar_D[0].disabled = modo
    rad_Preservar_D[1].disabled = modo

    //fecha/hora entrevista
    fecha.disabled = modo
    hora.disabled = modo

    // datos generales del entrevistado
    nombre_ent.disabled = modo
    ap_pat_ent.disabled = modo
    ap_mat_ent.disabled = modo
    calidad.disabled = modo
        //nacionalidad
    nacionalidad_select.disabled = modo
    if (nacionalidad_select.value != 'MEXICANA') {
        nacionalidad_otro.disabled = modo
    }

    genero.disabled = modo
    fecha_nacimiento.disabled = modo
    edad.disabled = modo
    telefono.disabled = modo
    correo.disabled = modo
        //identificacion select
    identificacion_select.disabled = modo
    if (identificacion_select.value == 'Otro') { //Select Otro
        identificacion_otro.disabled = modo
    }
    num_identificacion.disabled = modo

    // domicilio del entrevistado
    if (modo) document.getElementById('id_busqueda_por_panel_1').classList.add('mi_hide')
    else document.getElementById('id_busqueda_por_panel_1').classList.remove('mi_hide')
    colonia_domEntrev.disabled = modo
    calle_1_domEntrev.disabled = modo
    no_ext_domEntrev.disabled = modo
    no_int_domEntrev.disabled = modo
    coord_x_domEntrev.disabled = modo
    coord_y_domEntrev.disabled = modo
    estado_domEntrev.disabled = modo
    municipio_domEntrev.disabled = modo
    cp_domEntrev.disabled = modo
    referencias_domEntrev.disabled = modo

    // relato entrevista
    relato_entrevista.disabled = modo

    // traslado entrevistado
    rad_Traslado[0].disabled = modo
    rad_Traslado[1].disabled = modo
    if (rad_Traslado[1].checked) {
        lugar_canalizacion.disabled = modo
        descripcion_canalizacion.disabled = modo
    }

    //primer respondiente
    rad_PR[0].disabled = modo
    rad_PR[1].disabled = modo
    if (rad_PR[1].checked) { //se bloquea valores de elementos
        if (modo) document.getElementById('id_busqueda_pr_panel').classList.add('mi_hide')
        else document.getElementById('id_busqueda_pr_panel').classList.remove('mi_hide')
        nombre_pr.disabled = modo
        ap_pat_pr.disabled = modo
        ap_mat_pr.disabled = modo
        institucion_pr.disabled = modo
        cargo_pr.disabled = modo
        no_control_pr.disabled = modo
    }

    if (modo) document.getElementById('id_send_buttons_panel').classList.add('mi_hide')
    else document.getElementById('id_send_buttons_panel').classList.remove('mi_hide')
}

// Window on loaded
window.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('id_edit_button_panel').classList.remove('mi_hide')
    cargarInfoAnexoE()

    edit_see_button.addEventListener('click', (e) => {
        modo_actual = !modo_actual
        changeEditSeeMode(modo_actual)
    })
});