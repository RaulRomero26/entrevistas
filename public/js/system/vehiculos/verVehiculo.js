const pathFile = base_url_js + `public/files/Vehiculos/${document.getElementById('no_vehiculo_ver').value}/PDF/`;
window.onload = function() {
    var no_vehiculo_editar = document.getElementById('no_vehiculo_ver')

    var myFormData = new FormData()
    myFormData.append('no_vehiculo_editar', no_vehiculo_editar.value)
    console.log(no_vehiculo_editar.value)
    fetch(base_url_js + '/Vehiculos/getVehiculoEditar', {
        method: 'POST',
        body: myFormData
    })
    .then(res => res.json())

    .then(data => {
        if(data.vehiculo.NO_FICHA_R!=0){
            document.getElementById('Tipo_FichaV').textContent = "Remisión"
            document.getElementById('Num_fichaV').textContent = data.vehiculo.NO_FICHA_R
        }
        else{
            document.getElementById('Tipo_FichaV').textContent = "Vehiculo"
            document.getElementById('Num_fichaV').textContent = data.vehiculo.NO_FICHA_V
        }
        document.getElementById('id_vehiculoV').textContent = data.vehiculo.ID_VEHICULO
        document.getElementById('fechar_VehiculoV').textContent = data.vehiculo.FECHA_RECUPERACION
        document.getElementById('fechad_VehiculoV').textContent = data.vehiculo.FECHA_PUESTA_DISPOSICION
        document.getElementById('Tipo_SituacionV').textContent = data.vehiculo.ESTADO
        document.getElementById('colonia_VehiculoV').textContent = (data.vehiculo.COLONIA).replace(","," ")
        document.getElementById('zona_VehiculoV').textContent = data.vehiculo.ZONA_EVENTO
        document.getElementById('primerm_VehiculoV').textContent = data.vehiculo.PRIMER_RESPONDIENTE
        document.getElementById('MarcaV').textContent = data.vehiculo.MARCA
        document.getElementById('SubmarcaV').textContent = data.vehiculo.SUBMARCA
        document.getElementById('ModeloV').textContent = data.vehiculo.MODELO
        document.getElementById('ColorV').textContent = data.vehiculo.COLOR
        document.getElementById('CDI_VehiculoV').textContent = data.vehiculo.CDI
        document.getElementById('remision_VehiculoV').textContent = data.vehiculo.NO_REMISION
        document.getElementById('Tipo_VehiculoV').textContent = data.vehiculo.TIPO
        document.getElementById('Observacion_VehiculoV').value = data.vehiculo.OBSERVACIONES
        document.getElementById('Narrativa_VehiculoV').value = data.vehiculo.NARRATIVAS
        if(data.vehiculo.NOMBRE_MP!="" & data.vehiculo.NOMBRE_MP!=" " ){
            NOMBRE_MP=data.vehiculo.NOMBRE_MP.split(" ");
            document.getElementById('apellidom_mpV').textContent = NOMBRE_MP[NOMBRE_MP.length-1]
            document.getElementById('apellidop_mpV').textContent = NOMBRE_MP[NOMBRE_MP.length-2]
            document.getElementById('nombre_mpV').textContent=""
            for (let i = 0; i <= NOMBRE_MP.length-3; i++) {
                document.getElementById('nombre_mpV').textContent += NOMBRE_MP[i]+" "
            }
        }
        const rowsTablePlacas = data.placas;
        for (let i = 0; i < rowsTablePlacas.length; i++) {
            let formData = {
                tipo_placaV: rowsTablePlacas[i].DESCRIPCION,
                Placa_VehiculoV: rowsTablePlacas[i].PLACA,
                procedencia_placaV: rowsTablePlacas[i].PROCEDENCIA
            }
            insertNewRowPlaca(formData);
        }
        const rowsTableNivs = data.nivs;
        for (let i = 0; i < rowsTableNivs.length; i++) {
            let formData = {
                tipo_nivV: rowsTableNivs[i].DESCRIPCION,
                No_SerieV: rowsTableNivs[i].NO_SERIE,
            }
            insertNewRowNiv(formData);
        }
        getFotos()
        if (data.vehiculo.Path_file != null) {
            document.getElementById('viewPDFIPH').innerHTML = `
                <embed src="${pathFile + data.vehiculo.Path_file}" width="100%" height="400"  type="application/pdf">
            `;
            document.getElementById('pdf_puesta').style.display="block";
        }
        
        
    })
};
const insertNewRowNiv = ({ tipo_nivV, No_SerieV }, type) => {
    const table = document.getElementById('niv_vehiculosV').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);
    newRow.insertCell(0).innerHTML = tipo_nivV;
    newRow.insertCell(1).innerHTML = No_SerieV;
}
const insertNewRowPlaca = ({ tipo_placaV, Placa_VehiculoV, procedencia_placaV }, type) => {
    const table = document.getElementById('placas_vehiculosV').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);
    newRow.insertCell(0).innerHTML = tipo_placaV;
    newRow.insertCell(1).innerHTML = Placa_VehiculoV;
    newRow.insertCell(2).innerHTML = procedencia_placaV.toUpperCase();
}


const no_vehiculo_ver = document.getElementById('no_vehiculo_ver'),
    pathImagesFH = base_url_js + `public/files/Vehiculos/${no_vehiculo_ver.value}/Fotos/`;

const getFotos = () => {

    var myFormData = new FormData()
    myFormData.append('no_vehiculo_ver', no_vehiculo_ver.value)

    fetch(base_url_js + '/Vehiculos/getAllFotos', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {

        data.fotos.forEach(elem=>{
            console.log(pathImagesFH+elem.Path_Imagen)
            document.getElementById(`${elem.Tipo}`).src = pathImagesFH+elem.Path_Imagen;
        })

    })
}