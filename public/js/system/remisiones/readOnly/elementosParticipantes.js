const  no_remision_elemento = document.getElementById('no_remision_elementosParticipantes'),
    //----------------Elementos del DOM
    guardia = document.getElementById('policiaDeGuardia'),
    observacionesElementosParticipantes = document.getElementById('observacionesElementos');

const getElementosParticipantes = ()=>{ 

    var myFormData  =  new FormData()
    myFormData.append('no_remision', no_remision_elemento.value)

    fetch(base_url + 'getElementosParticipantes', {
        method: 'POST',
        body: myFormData
    })

    .then (res => res.json())

    .then( data => {

        const rowsTable = data.elementos_participantes;
        for(let i=0; i<rowsTable.length;i++){
            let formData = {
                nombreElemento: rowsTable[i].Nombre,
                noControlElemento: rowsTable[i].No_Control,
                placaElemento: rowsTable[i].Placa,
                unidadElemento: rowsTable[i].No_Unidad,
                cargoElemento: rowsTable[i].Cargo,
                grupoElemento: rowsTable[i].Sector_Area,
            };
            insertNewRowElemento(formData,rowsTable[i].Tipo_Llamado,'view');
        }

        guardia.innerText = (data.guardia.Nombre === undefined) ? 'NA' : data.guardia.Nombre.toUpperCase();
        document.getElementById('seguimientoGPS').innerText = (data.guardia.Seguimiento_GPS === '1') ? 'SÍ' : 'NO';

        observacionesElementosParticipantes.innerText = (data.observaciones.Observaciones === undefined) ? 'NA' : data.observaciones.Observaciones.toUpperCase();

    })
}