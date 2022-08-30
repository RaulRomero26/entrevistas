/** ----------- Cargar info desde fetch-----------*/
let id_puesta = document.getElementById('id_puesta').value
let id_detenido = document.getElementById('id_detenido').value

/**------------------------Set Edit / See Mode------------------------------- */
let edit_see_button = document.getElementById('id_edit_button')
let modo_actual = true

function cargarInfoDetenido() {
    let formData = new FormData()
    formData.append('Id_Puesta', id_puesta)
    formData.append('Id_Detenido', id_detenido)
    fetch(base_url_js + 'Juridico/getInfoAnexoAFetch', {
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
    let Detenido = data.Detenido
    let Domicilio = data.Domicilio
    let Familiar = data.Familiar
    let Pertenencias = data.Pertenencias
    let Puesta = data.Puesta
    let Ubi_Detencion = data.Ubi_Detencion
    let Primer_Resp = data.Primer_Resp
    let Segundo_Resp = data.Segundo_Resp

    //Caso de Puesta Concluida
    if (Puesta.Estatus == '1') { edit_see_button.classList.add('mi_hide') }

    //num fecha y hora detenido
    num_detencion.value = Detenido.Num_Detencion
    fecha.value = Detenido.Fecha_Hora.substring(0, 10)
    hora.value = Detenido.Fecha_Hora.substring(11, 16)

    //datos generales del Detenido
    nombre_d.value = Detenido.Nombre_D
    ap_pat_d.value = Detenido.Ap_Paterno_D
    ap_mat_d.value = Detenido.Ap_Materno_D
    apodo.value = Detenido.Apodo
    genero.value = Detenido.Genero
    fecha_nacimiento.value = Detenido.Fecha_Nacimiento
    edad.value = Detenido.Edad
        //nacionalidad
    if (Detenido.Nacionalidad != 'MEXICANA') {
        nacionalidadPanel.classList.remove("mi_hide");
        nacionalidad_otro.disabled = false
        nacionalidad_otro.value = Detenido.Nacionalidad
        rad_Nacionalidad[1].checked = true

    } else {
        nacionalidadPanel.classList.add("mi_hide");
        nacionalidad_otro.disabled = true
        nacionalidad_otro.value = ''
        rad_Nacionalidad[0].checked = true

    }
    //identificacion select
    const identificaciones = ['Credencial INE', 'Licencia', 'Pasaporte', 'No'];
    if (identificaciones.includes(Detenido.Identificacion)) { //no es otro
        identificacion_select.value = Detenido.Identificacion
        identificacion_panel.classList.add("mi_hide");
        identificacion_otro.disabled = true
        identificacion_otro.value = ''
    } else { //si es Otro
        identificacion_select.value = 'Otro'
        identificacion_panel.classList.remove("mi_hide");
        identificacion_otro.disabled = false
        identificacion_otro.value = Detenido.Identificacion
    }
    num_identificacion.value = Detenido.Num_Identificacion

    //domicilio del detenido
    colonia_domDetenido.value = Domicilio.Colonia
    calle_1_domDetenido.value = Domicilio.Calle
    no_ext_domDetenido.value = Domicilio.No_Exterior
    no_int_domDetenido.value = Domicilio.No_Interior
    coord_x_domDetenido.value = Domicilio.Coordenada_X
    coord_y_domDetenido.value = Domicilio.Coordenada_Y
    estado_domDetenido.value = Domicilio.Estado
    municipio_domDetenido.value = Domicilio.Municipio
    cp_domDetenido.value = Domicilio.CP
    referencias_domDetenido.value = Domicilio.Referencias

    //información adicional del detenido
    descripcion_detenido.value = Detenido.Descripcion_Detenido
    if (Detenido.Lesiones == '1') { rad_Lsesiones[1].checked = true } else { rad_Lsesiones[0].checked = true }

    if (Detenido.Descripcion_Padecimiento != '') {
        rad_Padecimiento[1].checked = true
        padecimiento_panel.classList.remove("mi_hide");
        padecimiento.disabled = false
        padecimiento.value = Detenido.Descripcion_Padecimiento
    } else {
        rad_Padecimiento[0].checked = true
        padecimiento_panel.classList.add("mi_hide");
        padecimiento.disabled = true
        padecimiento.value = ''
    }
    if (Detenido.Grupo_Vulnerable != '') {
        rad_Grupo_V[1].checked = true
        grupo_v_panel.classList.remove("mi_hide");
        grupo_v.disabled = false
        grupo_v.value = Detenido.Grupo_Vulnerable
    } else {
        rad_Grupo_V[0].checked = true
        grupo_v_panel.classList.add("mi_hide");
        grupo_v.disabled = true
        grupo_v.value = ''
    }
    if (Detenido.Grupo_Delictivo != '') {
        rad_Grupo_D[1].checked = true
        grupo_d_panel.classList.remove("mi_hide");
        grupo_d.disabled = false
        grupo_d.value = Detenido.Grupo_Delictivo
    } else {
        rad_Grupo_D[0].checked = true
        grupo_d_panel.classList.add("mi_hide");
        grupo_d.disabled = true
        grupo_d.value = ''
    }

    //familiar detenido
    if (Familiar) {
        rad_Familiar[1].checked = true
        familiar_panel.classList.remove("mi_hide");
        nombre_f.disabled = false
        ap_pat_f.disabled = false
        ap_mat_f.disabled = false
        telefono_f.disabled = false
        nombre_f.value = Familiar.Nombre_F
        ap_pat_f.value = Familiar.Ap_Paterno_F
        ap_mat_f.value = Familiar.Ap_Materno_F
        telefono_f.value = Familiar.Telefono_F
    } else {
        rad_Familiar[0].checked = true
        familiar_panel.classList.add("mi_hide");
        nombre_f.disabled = true
        ap_pat_f.disabled = true
        ap_mat_f.disabled = true
        telefono_f.disabled = true
        nombre_f.value = ''
        ap_pat_f.value = ''
        ap_mat_f.value = ''
        telefono_f.value = ''
    }

    //derechos del detenido
    if (Detenido.Lectura_Derechos == '1') { rad_Derechos[1].checked = true } else { rad_Derechos[0].checked = true }

    //inspección del detenido
    if (Detenido.Objeto_Encontrado == '1') { rad_Obj_Enc[1].checked = true } else { rad_Obj_Enc[0].checked = true }
    if (Detenido.Pertenencias_Encontradas == '1') {
        rad_Pertenencias[1].checked = true

        //carga de Pertenencias del detenido
        if (Pertenencias.length > 0) {

            showHidePertenenciasPanel(true)
            Pertenencias.forEach(elem => {
                pertenenciaArray.push({
                    Id: numPert,
                    Pertenencia: elem.Pertenencia.toUpperCase(),
                    Descripcion: elem.Descripcion.toUpperCase(),
                    Destino: elem.Destino.toUpperCase()
                })

                let row = pertenenciaTable.insertRow(pertenenciaTable.rows.length);
                row.id = "auxPer_" + numPert;
                //se agrega la info a la tabla
                row.insertCell(0).innerHTML = `${elem.Pertenencia.toUpperCase()}`;
                row.insertCell(1).innerHTML = `${elem.Descripcion.toUpperCase()}`;
                row.insertCell(2).innerHTML = `${elem.Destino.toUpperCase()}`;
                let auxOp = row.insertCell(3);
                auxOp.className = 'sticky_field';
                auxOp.innerHTML = createHtmlOperaciones(numPert);

                numPert++
            })
        } else {
            showHidePertenenciasPanel(false)
        }
    } else {
        rad_Pertenencias[0].checked = true
        showHidePertenenciasPanel(false)
    }

    //lugar de la detención
    if (Puesta.Id_Ubicacion == Detenido.Id_Ubicacion_Detencion) { //es la misma que la de la intervención
        ubicacion_det_panel.classList.add("mi_hide");
        rad_Ubi_Det[1].checked = true
    } else { //son diferentes
        ubicacion_det_panel.classList.remove("mi_hide");
        rad_Ubi_Det[0].checked = true
            //ubicación
        colonia_ubi_detencion.value = Ubi_Detencion.Colonia
        calle_1_ubi_detencion.value = Ubi_Detencion.Calle_1
        calle_2_ubi_detencion.value = Ubi_Detencion.Calle_2
        no_ext_ubi_detencion.value = Ubi_Detencion.No_Ext
        no_int_ubi_detencion.value = Ubi_Detencion.No_Int
        coord_x_ubi_detencion.value = Ubi_Detencion.Coordenada_X
        coord_y_ubi_detencion.value = Ubi_Detencion.Coordenada_Y
        estado_ubi_detencion.value = Ubi_Detencion.Estado
        municipio_ubi_detencion.value = Ubi_Detencion.Municipio
        cp_ubi_detencion.value = Ubi_Detencion.CP
        referencias_ubi_detencion.value = Ubi_Detencion.Referencias
    }

    //lugar del traslado
    lugar_traslado.value = Detenido.Lugar_Traslado
    desc_traslado.value = Detenido.Descripcion_Traslado
    obs_detencion.value = Detenido.Observaciones_Detencion

    //primer respondiente
    if (Puesta.Id_Primer_Respondiente == Detenido.Id_Primer_Respondiente) { //se oculta panel primer respondiente
        rad_PR[0].checked = true
        primer_r_panel.classList.add("mi_hide")
    } else { //se muestra panel y se asiganan valores
        rad_PR[1].checked = true
        primer_r_panel.classList.remove("mi_hide")
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

function showHidePertenenciasPanel(show) {
    if (show) {
        pertenencias_panel.classList.remove("mi_hide");
        pertenencia.disabled = false
        breveDesc.disabled = false
        destino.disabled = false
    } else {
        pertenencias_panel.classList.add("mi_hide");
        pertenencia.disabled = true
        breveDesc.disabled = true
        destino.disabled = true
    }

}

/**------------------------Set Edit / See Mode------------------------------- */

function changeEditSeeMode(modo) {

    edit_see_button.textContent = (modo) ? 'Editar registro' : 'Solo lectura'
        //num fecha y hora detenido
    num_detencion.disabled = modo
    fecha.disabled = modo
    hora.disabled = modo

    //datos generales del Detenido
    nombre_d.disabled = modo
    ap_pat_d.disabled = modo
    ap_mat_d.disabled = modo
    apodo.disabled = modo
    genero.disabled = modo
    fecha_nacimiento.disabled = modo
    edad.disabled = modo
        //nacionalidad
    rad_Nacionalidad[0].disabled = modo
    rad_Nacionalidad[1].disabled = modo
    if (rad_Nacionalidad[1].checked) {
        nacionalidad_otro.disabled = modo
    }

    //identificacion select
    identificacion_select.disabled = modo
    if (identificacion_select.value == 'Otro') { //Select Otro
        identificacion_otro.disabled = modo
    }
    num_identificacion.disabled = modo

    //domicilio del detenido
    if (modo) document.getElementById('id_busqueda_por_panel_1').classList.add('mi_hide')
    else document.getElementById('id_busqueda_por_panel_1').classList.remove('mi_hide')
    colonia_domDetenido.disabled = modo
    calle_1_domDetenido.disabled = modo
    no_ext_domDetenido.disabled = modo
    no_int_domDetenido.disabled = modo
    coord_x_domDetenido.disabled = modo
    coord_y_domDetenido.disabled = modo
    estado_domDetenido.disabled = modo
    municipio_domDetenido.disabled = modo
    cp_domDetenido.disabled = modo
    referencias_domDetenido.disabled = modo

    //información adicional del detenido
    descripcion_detenido.disabled = modo
    rad_Lsesiones[0].disabled = modo
    rad_Lsesiones[1].disabled = modo

    rad_Padecimiento[0].disabled = modo
    rad_Padecimiento[1].disabled = modo
    if (rad_Padecimiento[1].checked) {
        padecimiento.disabled = modo
    }

    rad_Grupo_V[0].disabled = modo
    rad_Grupo_V[1].disabled = modo
    if (rad_Grupo_V[1].checked) {
        grupo_v.disabled = modo
    }

    rad_Grupo_D[0].disabled = modo
    rad_Grupo_D[1].disabled = modo
    if (rad_Grupo_D[1].checked) {
        grupo_d.disabled = modo
    }

    //familiar detenido
    rad_Familiar[0].disabled = modo
    rad_Familiar[1].disabled = modo
    if (rad_Familiar[1].checked) {
        nombre_f.disabled = modo
        ap_pat_f.disabled = modo
        ap_mat_f.disabled = modo
        telefono_f.disabled = modo

    }

    //derechos del detenido
    rad_Derechos[0].disabled = modo
    rad_Derechos[1].disabled = modo

    //inspección del detenido
    rad_Obj_Enc[0].disabled = modo
    rad_Obj_Enc[1].disabled = modo

    rad_Pertenencias[0].disabled = modo
    rad_Pertenencias[1].disabled = modo
    if (rad_Pertenencias[1].checked) { //existen pertenencias se deshabilitan
        pertenencia.disabled = modo
        breveDesc.disabled = modo
        destino.disabled = modo
        pertenenciaArray.forEach(elem => {
            document.getElementById('id_button1_' + elem.Id).disabled = modo
            document.getElementById('id_button2_' + elem.Id).disabled = modo
        })
        document.getElementById('id_btn_add_pert').disabled = modo
        document.getElementById('id_btn_edit_pert').disabled = modo
        document.getElementById('id_btn_cancel_pert').disabled = modo
    }

    //lugar de la detención
    if (modo) document.getElementById('id_busqueda_por_panel_2').classList.add('mi_hide')
    else document.getElementById('id_busqueda_por_panel_2').classList.remove('mi_hide')
    rad_Ubi_Det[0].disabled = modo
    rad_Ubi_Det[1].disabled = modo
    if (rad_Ubi_Det[0].checked) { //son diferentes
        colonia_ubi_detencion.disabled = modo
        calle_1_ubi_detencion.disabled = modo
        calle_2_ubi_detencion.disabled = modo
        no_ext_ubi_detencion.disabled = modo
        no_int_ubi_detencion.disabled = modo
        coord_x_ubi_detencion.disabled = modo
        coord_y_ubi_detencion.disabled = modo
        estado_ubi_detencion.disabled = modo
        municipio_ubi_detencion.disabled = modo
        cp_ubi_detencion.disabled = modo
        referencias_ubi_detencion.disabled = modo
    }

    //lugar del traslado
    lugar_traslado.disabled = modo
    desc_traslado.disabled = modo
    obs_detencion.disabled = modo

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
    cargarInfoDetenido()

    edit_see_button.addEventListener('click', (e) => {
        modo_actual = !modo_actual
        changeEditSeeMode(modo_actual)
    })
});