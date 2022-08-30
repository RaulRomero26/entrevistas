let Nombre_Elemento_R = document.getElementById('Nombre_Elemento_R'),
    Responsable_Turno = document.getElementById('Responsable_Turno'),
    Origen_Evento = document.getElementById('Origen_Evento'),
    Fecha_Turno = document.getElementById('Fecha_Turno'),
    Turno = document.getElementById('Turno'),
    Semana = document.getElementById('Semana'),
    Folio_Deri = document.getElementById('Folio_Deri'),
    Fecha_Evento = document.getElementById('Fecha_Evento'),
    Hora_Reporte = document.getElementById('Hora_Reporte'),
    Motivo = document.getElementById('Motivo'),
    Caracteristicas_Robo = document.getElementById('Caracteristicas_Robo'),
    Violencia = document.getElementById('Violencia'),
    Tipo_Violencia = document.getElementById('Tipo_Violencia'),
    Colonia = document.getElementById('Colonia'),
    Calle = document.getElementById('Calle'),
    noInterior = document.getElementById('noInterior'),
    noExterior = document.getElementById('noExterior'),
    cordY = document.getElementById('cordY'),
    cordX = document.getElementById('cordX'),
    Municipio = document.getElementById('Municipio'),
    CP = document.getElementById('CP'),
    Zona_Evento = document.getElementById('Zona_Evento'),
    Vector = document.getElementById('Vector'),
    Ubicacion_Camaras = document.getElementById('Ubicacion_Camaras'),
    Estatus_Camara = document.getElementById('Estatus_Camara'),
    Unidad_Primer_R = document.getElementById('Unidad_Primer_R'),
    Informacion_Primer_R = document.getElementById('Informacion_Primer_R'),
    Acciones = document.getElementById('Acciones'),
    Identificacion_Placa = document.getElementById('Identificacion_Placa'),
    Uso_Vehiculo = document.getElementById('Uso_Vehiculo'),
    Caracteristicas_Vehiculo = document.getElementById('Caracteristicas_Vehiculo'),
    Identificacion_Responsables = document.getElementById('Identificacion_Responsables'),
    Detencion_Por_Info_Io = document.getElementById('Detencion_Por_Info_Io'),
    Elementos_Realizan_D = document.getElementById('Elementos_Realizan_D'),
    Fecha_Detencion = document.getElementById('Fecha_Detencion'),
    Compania_1 = document.getElementById('Compania_1'),
    Colonia_1 = document.getElementById('Colonia_1'),
    Calle_1 = document.getElementById('Calle_1'),
    noInterior_1 = document.getElementById('noInterior_1'),
    noExterior_1 = document.getElementById('noExterior_1'),
    cordY_1 = document.getElementById('cordY_1'),
    cordX_1 = document.getElementById('cordX_1'),
    Municipio_1 = document.getElementById('Municipio_1'),
    CP_1 = document.getElementById('CP_1')



window.onload = () => {
    let id_inteligencia = document.getElementById('id_Inteligencia');
    getData(id_inteligencia.value);
}


const getData = (arg) => {

    let myFormData = new FormData();
    myFormData.append("id_Inteligencia", arg);

    fetch(base_url_js + 'InteligenciaOperativa/getData', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {



        const { inteligencia_operativa, domicilio, vehiculo, camara } = data;
        const [domicilio_0, domicilio_1] = domicilio;

        Nombre_Elemento_R.innerText = inteligencia_operativa.Nombre_Elemento_R.toUpperCase()
        Responsable_Turno.innerText = inteligencia_operativa.Responsable_Turno.toUpperCase()
        Origen_Evento.innerText = inteligencia_operativa.Origen_Evento.toUpperCase()
        Fecha_Turno.innerText = inteligencia_operativa.Fecha_Turno.toUpperCase()
        Turno.innerText = inteligencia_operativa.Turno.toUpperCase()
        Semana.innerText = inteligencia_operativa.Semana.toUpperCase()
        Folio_Deri.innerText = (inteligencia_operativa.Folio_Deri != '') ? inteligencia_operativa.Folio_Deri.toUpperCase() : 'NA'
        Fecha_Evento.innerText = inteligencia_operativa.Fecha_Evento.toUpperCase()
        Hora_Reporte.innerText = inteligencia_operativa.Hora_Reporte.toUpperCase()
        Motivo.innerText = inteligencia_operativa.Motivo.toUpperCase()
        Caracteristicas_Robo.innerText = inteligencia_operativa.Caracteristicas_Robo.toUpperCase()
        Violencia.innerText = inteligencia_operativa.Violencia.toUpperCase()
        Tipo_Violencia.innerText = inteligencia_operativa.Tipo_Violencia.toUpperCase()

        Colonia.innerText = domicilio_0.Colonia.toUpperCase()
        Calle.innerText = domicilio_0.Calle.toUpperCase()
        noInterior.innerText = (domicilio_0.No_Interior.toUpperCase() != '') ? domicilio_0.No_Interior.toUpperCase() : 'NA'
        noExterior.innerText = (domicilio_0.No_Exterior.toUpperCase() != '') ? domicilio_0.No_Exterior.toUpperCase() : 'NA'
        cordY.innerText = domicilio_0.Coordenada_Y.toUpperCase()
        cordX.innerText = domicilio_0.Coordenada_X.toUpperCase()
        Municipio.innerText = domicilio_0.Municipio.toUpperCase()
        CP.innerText = domicilio_0.CP.toUpperCase()

        Zona_Evento.innerText = inteligencia_operativa.Zona_Evento.toUpperCase()
        Vector.innerText = inteligencia_operativa.Vector.toUpperCase()
            // Ubicacion_Camaras.innerText = inteligencia_operativa.Ubicacion_Camaras.toUpperCase()
            // Estatus_Camara.innerText = inteligencia_operativa.Estatus_Camara.toUpperCase()
        Unidad_Primer_R.innerText = inteligencia_operativa.Unidad_Primer_R.toUpperCase()
        Informacion_Primer_R.innerText = inteligencia_operativa.Informacion_Primer_R.toUpperCase()
        Acciones.innerText = inteligencia_operativa.Acciones.toUpperCase()
            // Identificacion_Placa.innerText = inteligencia_operativa.Identificacion_Placa.toUpperCase()
            // Uso_Vehiculo.innerText = inteligencia_operativa.Uso_Vehiculo.toUpperCase()
            // Caracteristicas_Vehiculo.innerText = inteligencia_operativa.Caracteristicas_Vehiculo.toUpperCase()
        Identificacion_Responsables.innerText = inteligencia_operativa.Identificacion_Responsables.toUpperCase()
        Detencion_Por_Info_Io.innerText = inteligencia_operativa.Detencion_Por_Info_Io.toUpperCase()
        Elementos_Realizan_D.innerText = inteligencia_operativa.Elementos_Realizan_D.toUpperCase()
        Fecha_Detencion.innerText = (inteligencia_operativa.Fecha_Detencion.toUpperCase() != '') ? inteligencia_operativa.Fecha_Detencion.toUpperCase() : 'NA'
        Compania.innerText = inteligencia_operativa.Compania.toUpperCase()

        Colonia_1.innerText = (domicilio_1.Colonia.toUpperCase() != '') ? domicilio_1.Colonia.toUpperCase() : 'NA'
        Calle_1.innerText = (domicilio_1.Calle.toUpperCase() != '') ? domicilio_1.Calle.toUpperCase() : 'NA'
        noInterior_1.innerText = (domicilio_1.No_Interior.toUpperCase() != '') ? domicilio_0.No_Interior.toUpperCase() : 'NA'
        noExterior_1.innerText = (domicilio_1.No_Exterior.toUpperCase() != '') ? domicilio_0.No_Exterior.toUpperCase() : 'NA'
        cordY_1.innerText = (domicilio_1.Coordenada_Y.toUpperCase() != '') ? domicilio_1.Coordenada_Y.toUpperCase() : 'NA'
        cordX_1.innerText = (domicilio_1.Coordenada_X.toUpperCase() != '') ? domicilio_1.Coordenada_X.toUpperCase() : 'NA'
        Municipio_1.innerText = (domicilio_1.Municipio.toUpperCase() != '') ? domicilio_1.Municipio.toUpperCase() : 'NA'
        CP_1.innerText = (domicilio_1.CP.toUpperCase() != '') ? domicilio_1.CP.toUpperCase() : 'NA'

        if (vehiculo.length > 0) {
            for (let i = 0; i < vehiculo.length; i++) {
                let formData = {
                    marcaVehiculoSegPer: vehiculo[i].Marca,
                    modeloVehiculoSegPer: vehiculo[i].Modelo,
                    colorVehiculoSegPer: vehiculo[i].Color,
                    identifiacionVehiculoSegPer: vehiculo[i].Identificacion_Placa,
                    placaVehiculoSegPer: vehiculo[i].Placas,
                    usoVehiculoSegPer: vehiculo[i].Uso_vehiculo,
                    caracteristicasVehiculoSegPer: vehiculo[i].Caracteristicas_Vehiculo,involucrado_robado2: vehiculo[i].Involucrado_robado
                }
                insertNewRowSegVehPer(formData, 'view');
            }
        }

        if (camara.length > 0) {
            for (let i = 0; i < camara.length; i++) {
                let formData = {
                    Ubicacion_Camaras: camara[i].Ubicacion,
                    Funciona_Camara: camara[i].Estatus_Camara,
                    tipo_camara2: camara[i].Tipo_Camara
                }
                insertNewRowCamaras(formData, 'view');
            }
        }

        if (inteligencia_operativa.Path_Pdf != '')
            document.getElementById('RenderPDF').innerHTML = `
                <embed src="${base_url_js}public/files/InteligenciaOperativa/${arg}/${inteligencia_operativa.Path_Pdf}" width="100%" height="400"  type="application/pdf"> `;

    })
}