const dataEntrevista = document.getElementById('data_entrevista'),
    // probableVinculacionError = document.getElementById('probableVinculacion_error'),
    motivoDelinquirError = document.getElementById('motivoDelinquir_error'),
    modusOperandiError = document.getElementById('modusOperandi_error'),
    probableVinculacion = document.getElementById('probableVinculacion'),
    motivoDelinquir = document.getElementById('motivoDelinquir'),
    modusOperandi = document.getElementById('modusOperandi'),
    no_remision_entrevista = document.getElementById('no_remision_elementosParticipantes'),
    inputsInstitucion = document.getElementById('inputsInstitucion_error'),
    inputsAdiccion = document.getElementById('inputsAdiccion_error'),
    inputsFalta = document.getElementById('inputsFaltas_error'),
    inputsAntecedente = document.getElementById('inputsAntecedentes_error'),
    msg_entrevista = document.getElementById('msg_entrevista');

document.getElementById('btn_entrevista').addEventListener('click', async(e) => {

    e.preventDefault();

    const button = document.getElementById('btn_entrevista');

    let myFormData = new FormData(dataEntrevista),
        band = [],
        FV = new FormValidator(),
        i = 0;

    //band[i++] = probableVinculacionError.innerText = FV.validate(myFormData.get('probableVinculacion'), 'required');

    let success = true;

    band.forEach(element => {
        success &= (element == '') ? true : false;
    });

    const institucion = validateInputsTables(['tipoInstitucion', 'corporacionInstitucion']);
    const adiccion = validateInputsTables(['tipoAdiccion', 'tiempoConsumo', 'frecuenciaConsumo', 'sueleRobar']);
    const falta = validateInputsTables(['descripcionFaltaAdministrativa']);
    const antecedente = validateInputsTables(['descripcionAntecedentePenal']);

    if (!institucion || !adiccion || !falta || !antecedente) {
        msg_entrevista.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario.</div>'
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });

        if (!institucion) {
            inputsInstitucion.innerHTML = 'No se a agregado el registro a la tabla';
        } else {
            inputsInstitucion.innerHTML = '';
        }
        if (!adiccion) {
            inputsAdiccion.innerHTML = 'No se a agregado el registro a la tabla';
        } else {
            inputsAdiccion.innerHTML = '';
        }
        if (!falta) {
            inputsFalta.innerHTML = 'No se a agregado el registro a la tabla';
        } else {
            inputsFalta.innerHTML = '';
        }
        if (!antecedente) {
            inputsAntecedente.innerHTML = 'No se a agregado el registro a la tabla';
        } else {
            inputsAntecedente.innerHTML = '';
        }

        return;
    } else {
        inputsInstitucion.innerHTML = '';
        inputsAdiccion.innerHTML = '';
        inputsFalta.innerHTML = '';
        inputsAntecedente.innerHTML = '';
    }

    const result = await getTabValidado(8);
    if(!result){
        success = false;
    }

    if (success) {

        button.innerHTML = `
            Guardando
            <div class="spinner-grow spinner-grow-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        `;
        button.classList.add('disabled-link');

        myFormData.append('entrevista_detenido', document.getElementById('btn_entrevista').value);
        myFormData.append('instituciones_table', JSON.stringify(readTableInstitucion()));
        myFormData.append('adicciones_table', JSON.stringify(readTableAdicciones()));
        myFormData.append('faltasAdministrativas_table', JSON.stringify(readTableFaltasAdministrativas()));
        myFormData.append('antecedentesPenales_table', JSON.stringify(readTableAntecedentes()));
        myFormData.append('remision', no_remision_entrevista.value);

        fetch(base_url + 'updateEntrevistaDetenido', {
                method: 'POST',
                body: myFormData
            })
            .then(res => res.json())
            .then(data => {
                button.innerHTML = `
                Guardar
            `;
                button.classList.remove('disabled-link');
                if (!data.status) {
                    // probableVinculacionError.innerText = data.probableVinculacionError;
                    motivoDelinquirError.innerText = (data.motivoDelinquirError === undefined) ? '' : data.motivoDelinquirError;
                    modusOperandiError.innerText = (data.modusOperandiError === undefined) ? '' : data.modusOperandiError;
                    let messageError;
                    if ('error_message' in data) {
                        if (data.error_message != 'Render Index') {
                            if (typeof(data.error_message) != 'string') {
                                messageError = `<div class="alert alert-danger text-center" role="alert">Sucedio un error en el servidor: ${data.error_message.errorInfo[2]}</div>`;
                            } else {
                                messageError = `<div class="alert alert-danger text-center" role="alert">Sucedio un error en el servidor: ${data.error_message}</div>`;
                            }
                        } else {
                            messageError = `<div class="alert alert-danger text-center alert-session-create" role="alert">
                                <p>Sucedio un error, su sesión caduco o no tiene los permisos necesarios. Por favor vuelva a iniciar sesión.</p>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalLogin">
                                    Iniciar sesión
                                </button>
                            </div>`;
                        }
                    } else {
                        messageError = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>'
                    }

                    msg_entrevista.innerHTML = messageError
                    window.scroll({
                        top: 0,
                        left: 100,
                        behavior: 'smooth'
                    });
                } else {
                    msg_entrevista.innerHTML = '<div class="alert alert-success text-center" role="alert">Información guardada con éxito.</div>'
                    window.scroll({
                        top: 0,
                        left: 100,
                        behavior: 'smooth'
                    });
                    getTabsGuardados();
                    // result.tab === '1' ? '' : document.getElementById('save-tab-8').style.display = 'block';
                }
            })
    } else {
        msg_entrevista.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario.</div>'
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });
    }
})

const readTableInstitucion = () => {
    const table = document.getElementById('institucionesSeguridad');
    let instituciones = [];

    if (document.getElementById('institucion2').checked) {
        for (let i = 1; i < table.rows.length; i++) {
            instituciones.push({
                ['row']: {
                    tipo: table.rows[i].cells[0].innerHTML,
                    corporacion: table.rows[i].cells[1].innerHTML
                }
            });
        }
    }

    return instituciones;
}

const readTableAdicciones = () => {
    const table = document.getElementById('adiccones');
    let adicciones = [];

    if (document.getElementById('adicciones2').checked) {
        for (let i = 1; i < table.rows.length; i++) {
            adicciones.push({
                ['row']: {
                    tipo: table.rows[i].cells[0].innerHTML,
                    tiempo: table.rows[i].cells[1].innerHTML,
                    frecuencia: table.rows[i].cells[2].innerHTML,
                    robar: table.rows[i].cells[3].innerHTML
                }
            });
        }
    }

    return adicciones;
}

const readTableFaltasAdministrativas = () => {
    const table = document.getElementById('faltasAdministrativas');
    let faltas = [];

    if (document.getElementById('faltas2').checked) {
        for (let i = 1; i < table.rows.length; i++) {
            faltas.push({
                ['row']: {
                    descripcion: table.rows[i].cells[0].innerHTML,
                    fecha: table.rows[i].cells[1].innerHTML
                }
            });
        }
    }

    return faltas;
}

const readTableAntecedentes = () => {
    const table = document.getElementById('antecedentePenales');
    let antecedentes = [];

    if (document.getElementById('antecedentes2').checked) {
        for (let i = 1; i < table.rows.length; i++) {
            antecedentes.push({
                ['row']: {
                    descripcion: table.rows[i].cells[0].innerHTML,
                    fecha: table.rows[i].cells[1].innerHTML
                }
            });
        }
    }

    return antecedentes;
}

const getEntrevistaDetenido = () => {
    var no_remision = document.getElementById('no_remision_entrevistaDetenido')

    var myFormData = new FormData()
    myFormData.append('no_remision', no_remision.value)

    fetch(base_url + 'getEntrevistaDetenido', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {

        probableVinculacion.value = (data.entrevista.Vinculacion_Grupo_D === undefined) ? '' : data.entrevista.Vinculacion_Grupo_D;

        const rowsTableInstituciones = data.instituciones;
        if (rowsTableInstituciones.length != 0) {
            document.getElementById('institucion').style.display = 'block';
            document.getElementById('institucion2').checked = true;
        }
        for (let i = 0; i < rowsTableInstituciones.length; i++) {
            let formData = {
                tipoInstitucion: rowsTableInstituciones[i].Tipo_Institucion,
                corporacionInstitucion: rowsTableInstituciones[i].Nombre_Institucion
            }
            insertNewRowInstitucion(formData);
        }

        const rowsTableAdicciones = data.addiciones;
        if (rowsTableAdicciones.length != 0) {
            document.getElementById('adicciones').style.display = 'block';
            document.getElementById('adicciones2').checked = true;
        }
        for (let i = 0; i < rowsTableAdicciones.length; i++) {
            let formData = {
                tipoAdiccion: rowsTableAdicciones[i].Nombre_Adiccion,
                tiempoConsumo: rowsTableAdicciones[i].Tiempo_Consumo,
                frecuenciaConsumo: rowsTableAdicciones[i].Frecuencia_Consumo,
                sueleRobar: rowsTableAdicciones[i].Que_Suele_Robar
            }
            insertNewRowAdicciones(formData);
        }

        const rowsTableFaltas = data.faltas;
        if (rowsTableFaltas.length != 0) {
            document.getElementById('faltas').style.display = 'block';
            document.getElementById('faltas2').checked = true;
        }
        for (let i = 0; i < rowsTableFaltas.length; i++) {
            const dateDB = rowsTableFaltas[i].Fecha_FD_Detenido,
                date = dateDB.split(" ")[0];
            let formData = {
                descripcionFaltaAdministrativa: rowsTableFaltas[i].Descripcion,
                dateFaltaAdministrativa: date
            }
            insertNewRowFaltas(formData);
        }

        const rowsTableAntedecentes = data.antecedentes;
        if (rowsTableAntedecentes.length != 0) {
            document.getElementById('antecedentes').style.display = 'block';
            document.getElementById('antecedentes2').checked = true;
        }
        for (let i = 0; i < rowsTableAntedecentes.length; i++) {
            const dateDB = rowsTableAntedecentes[i].Fecha_Antecedente,
                date = dateDB.split(" ")[0];
            let formData = {
                descripcionAntecedentePenal: rowsTableAntedecentes[i].Descripcion,
                dateAntecedentePenal: date
            }
            insertNewRowAntecedentes(formData);
        }

        motivoDelinquir.value = (data.entrevista.Motivo_Delinquir === undefined) ? '' : data.entrevista.Motivo_Delinquir;
        modusOperandi.value = (data.entrevista.Modus_Operandi === undefined) ? '' : data.entrevista.Modus_Operandi;
    })
}