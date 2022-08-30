const tipoVestimenta = document.getElementById('tipoVestimenta'),
    no_remision_senas = document.getElementById('no_remision_senasParticulares'),
    no_ficha_senas = document.getElementById('no_ficha_senasParticulares'),
    pathImagesSenas = pathFilesRemisiones+`${no_ficha_senas.value}/SenasParticulares/${no_remision_senas.value}/`,
    descripcionVestimenta = document.getElementById('descripcionVestimenta');

const getSenasParticulares = ()=>{ 

    var myFormData  =  new FormData()
    myFormData.append('no_remision', no_remision_senas.value)

    fetch(base_url + 'getSenasParticulares', {
        method: 'POST',
        body: myFormData
    })

    .then (res => res.json())

    .then( data => {

        const rowsTableSenas = data.senas;
        for(let i=0;i<rowsTableSenas.length;i++){
            const lis = createListLI(rowsTableSenas[i].Ubicacion_Corporal,rowsTableSenas[i].Perfil).toString();
            let formData={
                selectPerfil: rowsTableSenas[i].Perfil,
                senasparticulares: rowsTableSenas[i].Tipo_Senia_Particular,
                clasificacion: rowsTableSenas[i].Clasificacion,
                colorTatuaje: rowsTableSenas[i].Color === '1' ? true:false,
                descripcion: rowsTableSenas[i].Descripcion,
                list: lis.replace(',','')
            }
            insertNewRowSenas(formData,'view');
            if(rowsTableSenas[i].Path_Imagen.length != 0){
                toDataUrl(pathImagesSenas+rowsTableSenas[i].Path_Imagen, function(myBase64) {
                    createElementSena(myBase64, i+1, 'Photo','view');
                });
            }
        }

        tipoVestimenta.innerText = (data.vestimenta.Tipo_Vestimenta === undefined) ? 'NA' : data.vestimenta.Tipo_Vestimenta;
        descripcionVestimenta.innerText = (data.vestimenta.Descripcion_Vestimenta=== undefined) ? 'NA' : data.vestimenta.Descripcion_Vestimenta.toUpperCase();

        const rowsTableAccesorios = data.accesorios;
        for(let i=0;i<rowsTableAccesorios.length;i++){
            let formData={
                tipoAccesorio: rowsTableAccesorios[i].Tipo_Accesorio, 
                descripcionAccesorio: rowsTableAccesorios[i].Descripcion
            }
            insertNewRowAccesorio(formData,'view');
        }

        const table = document.getElementById('senas'),
            items = table.getElementsByTagName('li');

        for(let j=0; j<items.length;j++){
            if(!document.getElementById(items[j].id.substring(3)).classList.contains('select-piece')){
                document.getElementById(items[j].id.substring(3)).classList.add('select-piece');
            }
        }

    })
}