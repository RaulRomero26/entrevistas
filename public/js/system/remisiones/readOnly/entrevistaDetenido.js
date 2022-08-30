const probableVinculacion = document.getElementById('probableVinculacion'),
    motivoDelinquir = document.getElementById('motivoDelinquir'),
    modusOperandi = document.getElementById('modusOperandi'),
    no_remision_entrevista = document.getElementById('no_remision_elementosParticipantes');

const getEntrevistaDetenido = ()=>{ 
    var no_remision = document.getElementById('no_remision_entrevistaDetenido')

    var myFormData  =  new FormData()
    myFormData.append('no_remision', no_remision.value)

    fetch(base_url + 'getEntrevistaDetenido', {
        method: 'POST',
        body: myFormData
    })

    .then (res => res.json())

    .then( data => {
        
        probableVinculacion.innerText = (data.entrevista.Vinculacion_Grupo_D === undefined) ? 'NA' : data.entrevista.Vinculacion_Grupo_D.toUpperCase();

        const rowsTableInstituciones = data.instituciones;
        for(let i=0;i<rowsTableInstituciones.length;i++){
            let formData={
                tipoInstitucion: rowsTableInstituciones[i].Tipo_Institucion, 
                corporacionInstitucion: rowsTableInstituciones[i].Nombre_Institucion
            }
            insertNewRowInstitucion(formData,'view');
        }

        const rowsTableAdicciones = data.addiciones;
        for(let i=0;i<rowsTableAdicciones.length;i++){
            let formData={
                tipoAdiccion: rowsTableAdicciones[i].Nombre_Adiccion, 
                tiempoConsumo: rowsTableAdicciones[i].Tiempo_Consumo, 
                frecuenciaConsumo: rowsTableAdicciones[i].Frecuencia_Consumo, 
                sueleRobar: rowsTableAdicciones[i].Que_Suele_Robar
            }
            insertNewRowAdicciones(formData,'view');
        }
        
        const rowsTableFaltas = data.faltas;
        for(let i=0;i<rowsTableFaltas.length;i++){
            const dateDB = rowsTableFaltas[i].Fecha_FD_Detenido,
                date = dateDB.split(" ")[0];
            let formData={
                descripcionFaltaAdministrativa: rowsTableFaltas[i].Descripcion,  
                dateFaltaAdministrativa: date
            }
            insertNewRowFaltas(formData,'view');
        }

        const rowsTableAntedecentes = data.antecedentes;
        for(let i=0;i<rowsTableAntedecentes.length;i++){
            const dateDB = rowsTableAntedecentes[i].Fecha_Antecedente,
                date = dateDB.split(" ")[0];
            let formData={
                descripcionAntecedentePenal: rowsTableAntedecentes[i].Descripcion, 
                dateAntecedentePenal: date
            }
            insertNewRowAntecedentes(formData,'view');
        }

        motivoDelinquir.innerText = (data.entrevista.Motivo_Delinquir === undefined) ? 'NA' : data.entrevista.Motivo_Delinquir.toUpperCase();
        modusOperandi.innerText = (data.entrevista.Modus_Operandi === undefined) ? 'NA' : data.entrevista.Modus_Operandi.toUpperCase();
    })
}