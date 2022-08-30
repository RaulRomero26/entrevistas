//get form element
let formDictamen = document.getElementById('id_form_dictamen')
    /*--------------ALERTS------------*/
let error_panel = document.getElementById('id_error_panel')
let success_panel = document.getElementById('id_success_panel')
let error_alert = document.getElementById('id_error_alert')
let success_alert = document.getElementById('id_success_alert')
    /*------CAMPOS PARA ASIGNAR EL CORRESPONDIENTE LISTENER-------*/
    //detenido
let nombre = document.getElementById('id_nombre')
let ap_paterno = document.getElementById('id_ap_paterno')
let ap_materno = document.getElementById('id_ap_materno')
let edad = document.getElementById('id_edad')
let ocupacion = document.getElementById('id_ocupacion')
let domicilio = document.getElementById('id_domicilio')
    //elemento
let nombre_e = document.getElementById('id_nombre_e')
let ap_paterno_e = document.getElementById('id_ap_paterno_e')
let ap_materno_e = document.getElementById('id_ap_materno_e')
let placa_e = document.getElementById('id_placa_e')
let cargo_e = document.getElementById('id_cargo_e')
let sector_e = document.getElementById('id_sector_e')
let unidad_e = document.getElementById('id_unidad_e')

let folio = document.getElementById('id_folio_n')
let fecha1 = document.getElementById('id_fecha_dictamen')
let hora1 = document.getElementById('id_hora_dictamen')
let padeceInput = document.getElementById('id_enfermedades_padece')
let tomaMedInput = document.getElementById('id_toma_medicamentos')
let fechaConsum = document.getElementById('id_fecha_consumo')
let horaConsum = document.getElementById('id_hora_consumo')
let cantidadConsum = document.getElementById('id_cantidad_consumida')
let heridas_lesiones = document.getElementById('id_heridas_lesiones')
let observaciones = document.getElementById('id_observaciones')
// buttons reinicio
let fecha_reinicio = document.getElementById('id_fecha_reinicio')
let hora_reinicio = document.getElementById('id_hora_reinicio')

    /*------------------------get all error elements------------------------*/
let error_fecha_dictamen = document.getElementById('error_fecha_dictamen')
let error_hora_dictamen = document.getElementById('error_hora_dictamen')
let error_instancia = document.getElementById('error_instancia')
let error_nombre = document.getElementById('error_nombre')
let error_ap_pat = document.getElementById('error_ap_pat')
let error_ap_mat = document.getElementById('error_ap_mat')
let error_edad = document.getElementById('error_edad')
let error_ocupacion = document.getElementById('error_ocupacion')
let error_domicilio = document.getElementById('error_domicilio')
let error_genero = document.getElementById('error_genero')

let error_nombre_e = document.getElementById('error_nombre_e')
let error_ap_paterno_e = document.getElementById('error_ap_paterno_e')
let error_ap_materno_e = document.getElementById('error_ap_materno_e')
let error_placa_e = document.getElementById('error_placa_e')
let error_cargo_e = document.getElementById('error_cargo_e')
let error_sector_e = document.getElementById('error_sector_e')
let error_unidad_e = document.getElementById('error_unidad_e')

let error_padece_si_no = document.getElementById('error_padece_si_no')
let error_enfermedades_padece = document.getElementById('error_enfermedades_padece')
let error_medic_si_no = document.getElementById('error_medic_si_no')
let error_toma_medicamentos = document.getElementById('error_toma_medicamentos')
let error_pruebas_1 = document.getElementById('error_pruebas_1')
let error_pruebas_2 = document.getElementById('error_pruebas_2')
let error_pruebas_3 = document.getElementById('error_pruebas_3')
let error_coopera = document.getElementById('error_coopera')
let error_consumio = document.getElementById('error_consumio')
let error_sustancia = document.getElementById('error_sustancia')
let error_fecha_consumo = document.getElementById('error_fecha_consumo')
let error_hora_consumo = document.getElementById('error_hora_consumo')
let error_cantidad_consumo = document.getElementById('error_cantidad_consumo')
let error_edo_cons = document.getElementById('error_edo_cons')
let error_actitud = document.getElementById('error_actitud')
let error_lenguaje = document.getElementById('error_lenguaje')
let error_fascies = document.getElementById('error_fascies')
let error_conjuntivas = document.getElementById('error_conjuntivas')
let error_pupilas = document.getElementById('error_pupilas')
let error_pupilas2 = document.getElementById('error_pupilas2')
let error_mucosa_oral = document.getElementById('error_mucosa_oral')
let error_heridas_lesiones = document.getElementById('error_heridas_lesiones')
let error_observaciones = document.getElementById('error_observaciones')
let error_diagnostico = document.getElementById('error_diagnostico')


/*Validar el formulario de disctamen*/
function checkFormDictamen(event) {
    // console.log("Tocó botón ...");
    // console.log(event.target);
    // console.log(event.target.id);
    let buttonForm = document.getElementById(event.target.id)
    let cancelButton = document.getElementById('id_cancel_button')
    buttonForm.disabled = true
    buttonForm.textContent = 'Guardando...'
    cancelButton.classList.add('mi_hide')

    let myFormData = new FormData(formDictamen)
    let band = [] //banderas success
        /*inician las validaciones campo por campo*/
    let FV = new FormValidator()
    let ind = 0
        //set rules
        //detenido
    band[ind++] = error_nombre.textContent = FV.validate(myFormData.get('Nombre'), 'required | max_length[100]')
    band[ind++] = error_ap_pat.textContent = FV.validate(myFormData.get('Ap_Paterno'), 'required | max_length[100]')
    band[ind++] = error_ap_mat.textContent = FV.validate(myFormData.get('Ap_Materno'), 'required | max_length[100]')
    band[ind++] = error_edad.textContent = FV.validate(myFormData.get('Edad'), 'required | numeric')
    band[ind++] = error_ocupacion.textContent = FV.validate(myFormData.get('Ocupacion'), 'required | max_length[250]')
    band[ind++] = error_domicilio.textContent = FV.validate(myFormData.get('Domicilio'), 'required | max_length[650]')
    band[ind++] = error_genero.textContent = FV.validate(myFormData.get('Genero'), 'required | length[1]')
        //elemento
    band[ind++] = error_nombre_e.textContent = FV.validate(myFormData.get('Nombre_E'), 'required | max_length[450]')
    band[ind++] = error_ap_paterno_e.textContent = FV.validate(myFormData.get('Ap_Paterno_E'), 'required | max_length[450]')
    band[ind++] = error_ap_materno_e.textContent = FV.validate(myFormData.get('Ap_Materno_E'), 'required | max_length[450]')
    band[ind++] = error_placa_e.textContent = FV.validate(myFormData.get('Placa_E'), 'max_length[45]')
    band[ind++] = error_cargo_e.textContent = FV.validate(myFormData.get('Cargo_E'), 'required | max_length[350]')
    band[ind++] = error_sector_e.textContent = FV.validate(myFormData.get('Sector_Area_E'), 'required | max_length[250]')
    band[ind++] = error_unidad_e.textContent = FV.validate(myFormData.get('Unidad_E'), 'required | max_length[100]')
        //dictamen form
    band[ind++] = error_fecha_dictamen.textContent = FV.validate(myFormData.get('Fecha_Dictamen'), 'required | date')
    band[ind++] = error_hora_dictamen.textContent = FV.validate(myFormData.get('Hora_Dictamen'), 'required | time')
    band[ind++] = error_instancia.textContent = FV.validate(myFormData.get('Instancia'), 'required')

    band[ind++] = error_padece_si_no.textContent = FV.validate(myFormData.get('Padece_Si_No'), 'required')
    band[ind++] = error_medic_si_no.textContent = FV.validate(myFormData.get('Medic_Si_No'), 'required')

    if (myFormData.get('Padece_Si_No') == '1')
        band[ind++] = error_enfermedades_padece.textContent = FV.validate(myFormData.get('Enfermedades_Padece'), 'required')

    if (myFormData.get('Medic_Si_No') == '1')
        band[ind++] = error_toma_medicamentos.textContent = FV.validate(myFormData.get('Medicamentos_Toma'), 'required')

    band[ind++] = error_pruebas_1.textContent = FV.validate(myFormData.get('Prueba_Alcoholimetro'), 'required')
    band[ind++] = error_pruebas_2.textContent = FV.validate(myFormData.get('Prueba_Multitestdrog'), 'required')
    band[ind++] = error_pruebas_3.textContent = FV.validate(myFormData.get('Prueba_Clinica'), 'required')

    band[ind++] = error_coopera.textContent = FV.validate(myFormData.get('Coopera_Interrogatorio'), 'required')
    band[ind++] = error_consumio.textContent = FV.validate(myFormData.get('Consumio_Si_No'), 'required')

    if (myFormData.get('Consumio_Si_No') == '1') {
        band[ind++] = error_sustancia.textContent = FV.validate(myFormData.get('Sustancia_Consumida[]'), 'required')
        band[ind++] = error_fecha_consumo.textContent = FV.validate(myFormData.get('Fecha_Consumo'), 'max_length[10]')
        band[ind++] = error_hora_consumo.textContent = FV.validate(myFormData.get('Hora_Consumo'), 'max_length[5]')
        band[ind++] = error_cantidad_consumo.textContent = FV.validate(myFormData.get('Cantidad_Consumida'), 'max_length[500]')
    }

    band[ind++] = error_edo_cons.textContent = FV.validate(myFormData.get('Estado_Conciencia'), 'required')
    band[ind++] = error_actitud.textContent = FV.validate(myFormData.get('Actitud'), 'required')
    band[ind++] = error_lenguaje.textContent = FV.validate(myFormData.get('Lenguaje[]'), 'required')
    band[ind++] = error_fascies.textContent = FV.validate(myFormData.get('Fascies'), 'required')
    band[ind++] = error_conjuntivas.textContent = FV.validate(myFormData.get('Conjuntivas'), 'required')
    band[ind++] = error_pupilas.textContent = FV.validate(myFormData.get('Pupilas'), 'required')
    band[ind++] = error_pupilas2.textContent = FV.validate(myFormData.get('Pupilas2'), 'required')
    band[ind++] = error_mucosa_oral.textContent = FV.validate(myFormData.get('Mucosa_Oral'), 'required')
    band[ind++] = error_heridas_lesiones.textContent = FV.validate(myFormData.get('Heridas_Lesiones'), 'max_length[500]')
    band[ind++] = error_observaciones.textContent = FV.validate(myFormData.get('Observaciones'), 'max_length[500]')
    band[ind++] = error_diagnostico.textContent = FV.validate(myFormData.get('Diagnostico'), 'required')

    //se comprueban todas las validaciones
    let success = true
    band.forEach(element => {
        success &= (element == '') ? true : false
    })

    //Se asigna la url del fetch correspondiente 
    //Solo hay 2: 
    //-----insertar nuevo (caso de otro) o 
    //-----actualizar existente sin importar si es nuevo porque ya estaría almacenado previamente con la info del detenido y el elemento participante)
    let url_tipo_fetch = (event.target.id == 'id_dictamen_otro') ? base_url_js + 'DictamenMedico/insertOtroFetch' : base_url_js + 'DictamenMedico/actualizaFetch';
    let nuevo = (event.target.id == 'id_dictamen_nuevo') ? '1' : '0';
    myFormData.append('Nuevo', nuevo); //condición para que al actualizar si es nuevo actualice la fecha hora de registro

    if (success) { //si todo es correcto se envía form
        // console.log(url_tipo_fetch);
        window.scroll({
            top: 100,
            behavior: "smooth",
        });
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
                // console.log(myJson);
                if (myJson.resp_case.startsWith('error')) {
                    error_panel.classList.remove('mi_hide')
                    error_alert.textContent = myJson.error_message
                    success_panel.classList.add('mi_hide')

                    buttonForm.disabled = false
                    buttonForm.textContent = 'Guardar Cambios'
                    cancelButton.classList.remove('mi_hide')
                }
                switch (myJson.resp_case) {
                    case 'error_interno': //error de petición
                    case 'error_post': //error de petición
                    case 'error_db': //error de base de datos
                        break
                    case 'error_session': //error de sesión
                        //falta añadir boton de inicio de sesión
                        error_panel.classList.add('text-center')
                        error_alert.classList.add('alert-session-create')
                        error_alert.innerHTML = `
                                                <p>Sucedio un error, su sesión caduco o no tiene los permisos necesarios. Por favor vuelva a iniciar sesión.</p>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalLogin">
                                                    Iniciar sesión
                                                </button>
                                                `
                        break
                    case 'error_form': //error de formulario
                        error_nombre.textContent = myJson.error_nombre
                        error_ap_pat.textContent = myJson.error_ap_pat
                        error_ap_mat.textContent = myJson.error_ap_mat
                        error_edad.textContent = myJson.error_edad
                        error_genero.textContent = myJson.error_genero
                        error_ocupacion.textContent = myJson.error_ocupacion
                        error_domicilio.textContent = myJson.error_domicilio
                            //elemento
                        error_nombre_e.textContent = myJson.error_nombre_e
                        error_ap_paterno_e.textContent = myJson.error_ap_paterno_e
                        error_ap_materno_e.textContent = myJson.error_ap_materno_e
                        error_placa_e.textContent = myJson.error_placa_e
                        error_cargo_e.textContent = myJson.error_cargo_e
                        error_sector_e.textContent = myJson.error_sector_e
                        error_unidad_e.textContent = myJson.error_unidad_e
                            //dictamen form
                        error_fecha_dictamen.textContent = myJson.error_fecha_dictamen
                        error_hora_dictamen.textContent = myJson.error_hora_dictamen
                        error_instancia.textContent = myJson.error_instancia

                        error_padece_si_no.textContent = myJson.error_padece_si_no
                        error_medic_si_no.textContent = myJson.error_medic_si_no

                        if (myFormData.get('Padece_Si_No') == '1')
                            error_enfermedades_padece.textContent = myJson.error_enfermedades_padece

                        if (myFormData.get('Medic_Si_No') == '1')
                            error_toma_medicamentos.textContent = myJson.error_toma_medicamentos

                        error_pruebas_1.textContent = myJson.error_pruebas_1
                        error_pruebas_2.textContent = myJson.error_pruebas_2
                        error_pruebas_3.textContent = myJson.error_pruebas_3

                        error_coopera.textContent = myJson.error_coopera
                        error_consumio.textContent = myJson.error_consumio

                        if (myFormData.get('Consumio_Si_No') == '1') {
                            error_sustancia.textContent = myJson.error_sustancia
                            error_fecha_consumo.textContent = myJson.error_fecha_consumo
                            error_hora_consumo.textContent = myJson.error_hora_consumo
                            error_cantidad_consumo.textContent = myJson.error_cantidad_consumo
                        }

                        error_edo_cons.textContent = myJson.error_edo_cons
                        error_actitud.textContent = myJson.error_actitud
                        error_lenguaje.textContent = myJson.error_lenguaje
                        error_fascies.textContent = myJson.error_fascies
                        error_conjuntivas.textContent = myJson.error_conjuntivas
                        error_pupilas.textContent = myJson.error_pupilas
                        error_pupilas2.textContent = myJson.error_pupilas2
                        error_mucosa_oral.textContent = myJson.error_mucosa_oral
                        error_heridas_lesiones.textContent = myJson.error_heridas_lesiones
                        error_observaciones.textContent = myJson.error_observaciones
                        error_diagnostico.textContent = myJson.error_diagnostico
                        break
                    case 'success': //registro guardado correctamente TODO CHIDO
                        error_panel.classList.add('mi_hide')
                        error_alert.textContent = ''
                        success_panel.classList.remove('mi_hide')
                        success_alert.textContent = 'Registro guardado exitósamente.'
                        setInterval(() => {
                            window.location = base_url_js + "DictamenMedico";
                        }, 2500);
                        break
                }
            })
            .catch(err => {
                error_panel.classList.remove('mi_hide')
                error_alert.textContent = err
                success_panel.classList.add('mi_hide')
            })

    } else { //si no, se muestran errores en pantalla
        error_panel.classList.remove('mi_hide')
        error_alert.textContent = 'Error en el formulario, comprueba que esten llenados correctamente todos los campos requeridos'
        success_panel.classList.add('mi_hide')
        alert("Error: checa la información del formulario")

        window.scrollTo(0, 100); // values are x,y-offset
        buttonForm.disabled = false
        buttonForm.textContent = 'Guardar Cambios'
        cancelButton.classList.remove('mi_hide')
    }

}

/*LISTENERS para cada input*/
fecha1.addEventListener('change', (e) => {
    if (existeFecha(fecha1.value)) {
        document.getElementById('error_fecha_dictamen').textContent = ''
    } else {
        document.getElementById('error_fecha_dictamen').textContent = 'Elije una fecha correcta'
    }
})
hora1.addEventListener('change', (e) => {
        if (existeHora(hora1.value)) {
            document.getElementById('error_hora_dictamen').textContent = ''
        } else {
            document.getElementById('error_hora_dictamen').textContent = 'Elije una hora correcta'
        }
    })
    //---------------------detenido--------------------------
nombre.addEventListener('change', (e) => {
    const MAX_LENGTH = 150
    if (nombre.value.trim() !== '' && nombre.value.length <= MAX_LENGTH) {
        document.getElementById('error_nombre').textContent = ''
    } else if (!(nombre.value.trim() !== '')) {
        document.getElementById('error_nombre').textContent = 'Llene el campo *'
    } else if (!(nombre.value.length <= MAX_LENGTH)) {
        document.getElementById('error_nombre').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
ap_paterno.addEventListener('change', (e) => {
    const MAX_LENGTH = 150
    if (ap_paterno.value.trim() !== '' && ap_paterno.value.length <= MAX_LENGTH) {
        document.getElementById('error_ap_pat').textContent = ''
    } else if (!(ap_paterno.value.trim() !== '')) {
        document.getElementById('error_ap_pat').textContent = 'Llene el campo *'
    } else if (!(ap_paterno.value.length <= MAX_LENGTH)) {
        document.getElementById('error_ap_pat').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
ap_materno.addEventListener('change', (e) => {
    const MAX_LENGTH = 150
    if (ap_materno.value.trim() !== '' && ap_materno.value.length <= MAX_LENGTH) {
        document.getElementById('error_ap_mat').textContent = ''
    } else if (!(ap_materno.value.trim() !== '')) {
        document.getElementById('error_ap_mat').textContent = 'Llene el campo *'
    } else if (!(ap_materno.value.length <= MAX_LENGTH)) {
        document.getElementById('error_ap_mat').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
edad.addEventListener('change', (e) => {
    const MAX_LENGTH = 2
    if (edad.value.trim() !== '' && edad.value.length <= MAX_LENGTH) {
        document.getElementById('error_edad').textContent = ''
    } else if (!(edad.value.trim() !== '')) {
        document.getElementById('error_edad').textContent = 'Llene el campo *'
    } else if (!(edad.value.length <= MAX_LENGTH)) {
        document.getElementById('error_edad').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
ocupacion.addEventListener('change', (e) => {
    const MAX_LENGTH = 150
    if (ocupacion.value.trim() !== '' && ocupacion.value.length <= MAX_LENGTH) {
        document.getElementById('error_ocupacion').textContent = ''
    } else if (!(ocupacion.value.trim() !== '')) {
        document.getElementById('error_ocupacion').textContent = 'Llene el campo *'
    } else if (!(ocupacion.value.length <= MAX_LENGTH)) {
        document.getElementById('error_ocupacion').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
domicilio.addEventListener('change', (e) => {
        const MAX_LENGTH = 600
        if (domicilio.value.trim() !== '' && domicilio.value.length <= MAX_LENGTH) {
            document.getElementById('error_domicilio').textContent = ''
        } else if (!(domicilio.value.trim() !== '')) {
            document.getElementById('error_domicilio').textContent = 'Llene el campo *'
        } else if (!(domicilio.value.length <= MAX_LENGTH)) {
            document.getElementById('error_domicilio').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
        }
    })
    //---------------------elemento--------------------------
nombre_e.addEventListener('change', (e) => {
    const MAX_LENGTH = 450
    if (nombre_e.value.trim() !== '' && nombre_e.value.length <= MAX_LENGTH) {
        document.getElementById('error_nombre_e').textContent = ''
    } else if (!(nombre_e.value.trim() !== '')) {
        document.getElementById('error_nombre_e').textContent = 'Llene el campo *'
    } else if (!(nombre_e.value.length <= MAX_LENGTH)) {
        document.getElementById('error_nombre_e').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
ap_paterno_e.addEventListener('change', (e) => {
    const MAX_LENGTH = 450
    if (ap_paterno_e.value.trim() !== '' && ap_paterno_e.value.length <= MAX_LENGTH) {
        document.getElementById('error_ap_paterno_e').textContent = ''
    } else if (!(ap_paterno_e.value.trim() !== '')) {
        document.getElementById('error_ap_paterno_e').textContent = 'Llene el campo *'
    } else if (!(ap_paterno_e.value.length <= MAX_LENGTH)) {
        document.getElementById('error_ap_paterno_e').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
ap_materno_e.addEventListener('change', (e) => {
    const MAX_LENGTH = 450
    if (ap_materno_e.value.trim() !== '' && ap_materno_e.value.length <= MAX_LENGTH) {
        document.getElementById('error_ap_materno_e').textContent = ''
    } else if (!(ap_materno_e.value.trim() !== '')) {
        document.getElementById('error_ap_materno_e').textContent = 'Llene el campo *'
    } else if (!(ap_materno_e.value.length <= MAX_LENGTH)) {
        document.getElementById('error_ap_materno_e').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
placa_e.addEventListener('change', (e) => {
    const MAX_LENGTH = 45
    if (placa_e.value.trim() !== '' && placa_e.value.length <= MAX_LENGTH) {
        document.getElementById('error_placa_e').textContent = ''
    } else if (!(placa_e.value.trim() !== '')) {
        document.getElementById('error_placa_e').textContent = 'Llene el campo *'
    } else if (!(placa_e.value.length <= MAX_LENGTH)) {
        document.getElementById('error_placa_e').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
cargo_e.addEventListener('change', (e) => {
    const MAX_LENGTH = 350
    if (cargo_e.value.trim() !== '' && cargo_e.value.length <= MAX_LENGTH) {
        document.getElementById('error_cargo_e').textContent = ''
    } else if (!(cargo_e.value.trim() !== '')) {
        document.getElementById('error_cargo_e').textContent = 'Llene el campo *'
    } else if (!(cargo_e.value.length <= MAX_LENGTH)) {
        document.getElementById('error_cargo_e').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
sector_e.addEventListener('change', (e) => {
    const MAX_LENGTH = 250
    if (sector_e.value.trim() !== '' && sector_e.value.length <= MAX_LENGTH) {
        document.getElementById('error_sector_e').textContent = ''
    } else if (!(sector_e.value.trim() !== '')) {
        document.getElementById('error_sector_e').textContent = 'Llene el campo *'
    } else if (!(sector_e.value.length <= MAX_LENGTH)) {
        document.getElementById('error_sector_e').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
unidad_e.addEventListener('change', (e) => {
    const MAX_LENGTH = 100
    if (unidad_e.value.trim() !== '' && unidad_e.value.length <= MAX_LENGTH) {
        document.getElementById('error_unidad_e').textContent = ''
    } else if (!(unidad_e.value.trim() !== '')) {
        document.getElementById('error_unidad_e').textContent = 'Llene el campo *'
    } else if (!(unidad_e.value.length <= MAX_LENGTH)) {
        document.getElementById('error_unidad_e').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})


//-------------------------------------------------------
padeceInput.addEventListener('change', (e) => {
    const MAX_LENGTH = 200
    if (padeceInput.value.trim() !== '' && padeceInput.value.length <= MAX_LENGTH) {
        document.getElementById('error_enfermedades_padece').textContent = ''
    } else if (!(padeceInput.value.trim() !== '')) {
        document.getElementById('error_enfermedades_padece').textContent = 'Llene el campo *'
    } else if (!(padeceInput.value.length <= MAX_LENGTH)) {
        document.getElementById('error_enfermedades_padece').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
tomaMedInput.addEventListener('change', (e) => {
        const MAX_LENGTH = 200
        if (!(tomaMedInput.value.trim() !== '')) {
            document.getElementById('error_toma_medicamentos').textContent = 'Llene el campo *'
        } else if (!(tomaMedInput.value.length <= MAX_LENGTH)) {
            document.getElementById('error_toma_medicamentos').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
        } else {
            document.getElementById('error_toma_medicamentos').textContent = ''
        }
    })
    //-------------------------------------------------------
fechaConsum.addEventListener('change', (e) => {
    if (existeFecha(fechaConsum.value)) {
        document.getElementById('error_fecha_consumo').textContent = ''
    } else {
        document.getElementById('error_fecha_consumo').textContent = 'Elije una fecha correcta'
    }
})
horaConsum.addEventListener('change', (e) => {
    if (existeHora(horaConsum.value)) {
        document.getElementById('error_hora_consumo').textContent = ''
    } else {
        document.getElementById('error_hora_consumo').textContent = 'Elije una hora correcta'
    }
})
fecha_reinicio.addEventListener('click', (e) => {    
    fechaConsum.value = '';
})
hora_reinicio.addEventListener('click', (e) => {    
    horaConsum.value = '';
})
cantidadConsum. addEventListener('change', (e) => {
        const MAX_LENGTH = 200
        if (!(cantidadConsum.value.trim() !== '')) {
            document.getElementById('error_cantidad_consumo').textContent = 'Llene el campo *'
        } else if (!(cantidadConsum.value.length <= MAX_LENGTH)) {
            document.getElementById('error_cantidad_consumo').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
        } else {
            document.getElementById('error_cantidad_consumo').textContent = ''
        }
    })
    //-------------------------------------------------------
heridas_lesiones.addEventListener('change', (e) => {
    const MAX_LENGTH = 500
    if (heridas_lesiones.value.length <= MAX_LENGTH) {
        document.getElementById('error_heridas_lesiones').textContent = ''
    } else {
        document.getElementById('error_heridas_lesiones').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
    }
})
observaciones.addEventListener('change', (e) => {
        const MAX_LENGTH = 500
        if (observaciones.value.length <= MAX_LENGTH) {
            document.getElementById('error_observaciones').textContent = ''
        } else {
            document.getElementById('error_observaciones').textContent = 'Tamaño máximo: ' + MAX_LENGTH + ' caracteres'
        }
    })
    //antedecentes
let rad_Padece = document.getElementsByName('Padece_Si_No')
for (let i = 0; i < rad_Padece.length; i++) {
    rad_Padece[i].addEventListener('change', function() {
        document.getElementById('error_padece_si_no').textContent = ''
    });
}
let rad_Medic = document.getElementsByName('Medic_Si_No')
for (let i = 0; i < rad_Medic.length; i++) {
    rad_Medic[i].addEventListener('change', function() {
        document.getElementById('error_medic_si_no').textContent = ''
    });
}
// pruebas realizadas radio buttons
let rad_Prueba_1 = document.getElementsByName('Prueba_Alcoholimetro')
for (let i = 0; i < rad_Prueba_1.length; i++) {
    rad_Prueba_1[i].addEventListener('change', function() {
        document.getElementById('error_pruebas_1').textContent = ''
    });
}
let rad_Prueba_2 = document.getElementsByName('Prueba_Multitestdrog')
for (let i = 0; i < rad_Prueba_2.length; i++) {
    rad_Prueba_2[i].addEventListener('change', function() {
        document.getElementById('error_pruebas_2').textContent = ''
    });
}
let rad_Prueba_3 = document.getElementsByName('Prueba_Clinica')
for (let i = 0; i < rad_Prueba_3.length; i++) {
    rad_Prueba_3[i].addEventListener('change', function() {
        document.getElementById('error_pruebas_3').textContent = ''
    });
}
//Interrogatorio
let rad_Coopera = document.getElementsByName('Coopera_Interrogatorio')
for (let i = 0; i < rad_Coopera.length; i++) {
    rad_Coopera[i].addEventListener('change', function() {
        document.getElementById('error_coopera').textContent = ''
    });
}
let rad_Consumio = document.getElementsByName('Consumio_Si_No')
for (let i = 0; i < rad_Consumio.length; i++) {
    rad_Consumio[i].addEventListener('change', function() {
        document.getElementById('error_consumio').textContent = ''
    });
}

//sustancia consumida event check box
let SustanciaCheck = document.querySelectorAll(".sustancia_check");
let Sustancias_checks = []
    // Use Array.forEach to add an event listener to each checkbox.
SustanciaCheck.forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        Sustancias_checks =
            Array.from(SustanciaCheck) // Convert checkboxes to an array to use filter and map.
            .filter(i => i.checked) // Use Array.filter to remove unchecked checkboxes.
            .map(i => i.value) // Use Array.map to extract only the checkbox values from the array of objects.

        if (Sustancias_checks.length > 0) {
            error_sustancia.textContent = ''
        } else {
            error_sustancia.textContent = 'selecciona al menos una opción'
        }
    })
});

//lenguaje event check box
let LenguajeCheck = document.querySelectorAll(".lenguaje_check");
let Lenguajes_checks = []

LenguajeCheck.forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        Lenguajes_checks =
            Array.from(LenguajeCheck) // Convert checkboxes to an array to use filter and map.
            .filter(i => i.checked) // Use Array.filter to remove unchecked checkboxes.
            .map(i => i.value) // Use Array.map to extract only the checkbox values from the array of objects.

        if (Lenguajes_checks.length > 0) {
            error_lenguaje.textContent = ''
        } else {
            error_lenguaje.textContent = 'elige al menos una opción'
        }
    })
});
document.getElementById('id_lenguaje_1').addEventListener('change', (e) => {
    if (e.target.checked) {
        document.getElementById('id_lenguaje_2').checked = false
        document.getElementById('id_lenguaje_3').checked = false
        document.getElementById('id_lenguaje_4').checked = false
    }
})
document.getElementById('id_lenguaje_2').addEventListener('change', (e) => {
    if (e.target.checked) {
        document.getElementById('id_lenguaje_1').checked = false
    }
})
document.getElementById('id_lenguaje_3').addEventListener('change', (e) => {
    if (e.target.checked) {
        document.getElementById('id_lenguaje_1').checked = false
    }
})
document.getElementById('id_lenguaje_4').addEventListener('change', (e) => {
    if (e.target.checked) {
        document.getElementById('id_lenguaje_1').checked = false
    }
})


//nivel conciencia
let rad_EdoCons = document.getElementsByName('Estado_Conciencia')
for (let i = 0; i < rad_EdoCons.length; i++) {
    rad_EdoCons[i].addEventListener('change', function() {
        document.getElementById('error_edo_cons').textContent = ''
    });
}
let rad_Actitud = document.getElementsByName('Actitud')
for (let i = 0; i < rad_Actitud.length; i++) {
    rad_Actitud[i].addEventListener('change', function() {
        document.getElementById('error_actitud').textContent = ''
    });
}
//exploración física
let rad_Fascies = document.getElementsByName('Fascies')
for (let i = 0; i < rad_Fascies.length; i++) {
    rad_Fascies[i].addEventListener('change', function() {
        document.getElementById('error_fascies').textContent = ''
    });
}
let rad_Conjuntivas = document.getElementsByName('Conjuntivas')
for (let i = 0; i < rad_Conjuntivas.length; i++) {
    rad_Conjuntivas[i].addEventListener('change', function() {
        document.getElementById('error_conjuntivas').textContent = ''
    });
}
let rad_Pupilas = document.getElementsByName('Pupilas')
for (let i = 0; i < rad_Pupilas.length; i++) {
    rad_Pupilas[i].addEventListener('change', function() {
        document.getElementById('error_pupilas').textContent = ''
    });
}
let rad_Pupilas2 = document.getElementsByName('Pupilas2')
for (let i = 0; i < rad_Pupilas2.length; i++) {
    rad_Pupilas2[i].addEventListener('change', function() {
        document.getElementById('error_pupilas2').textContent = ''
    });
}
let rad_MucosaOral = document.getElementsByName('Mucosa_Oral')
for (let i = 0; i < rad_MucosaOral.length; i++) {
    rad_MucosaOral[i].addEventListener('change', function() {
        document.getElementById('error_mucosa_oral').textContent = ''
    });
}
//diagnostico
let rad_Diagnostico = document.getElementsByName('Diagnostico')
for (let i = 0; i < rad_Diagnostico.length; i++) {
    rad_Diagnostico[i].addEventListener('change', function() {
        document.getElementById('error_diagnostico').textContent = ''
    });
}

/*valida fecha*/
function existeFecha(fecha) {
    var fechaf = fecha.split("-")
    var d = fechaf[2]
    var m = fechaf[1]
    var y = fechaf[0]
    return m > 0 && m < 13 && y > 0 && y < 32768 && d > 0 && d <= (new Date(y, m, 0)).getDate()
}
/*valida fecha*/
function existeHora(hora) {
    var horaH = hora.split(":")
    var hrs = horaH[0]
    var mins = horaH[1]
    return hrs >= 0 && hrs <= 23 && mins >= 0 && mins <= 59
}