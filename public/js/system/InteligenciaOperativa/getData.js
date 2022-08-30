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
    Tipo_Violencia = document.getElementsByName('Tipo_Violencia'),
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
    Unidad_Primer_R = document.getElementById('Unidad_Primer_R'),
    Informacion_Primer_R = document.getElementById('Informacion_Primer_R'),
    Acciones = document.getElementById('Acciones'),
    Uso_Vehiculo = document.getElementById('Uso_Vehiculo'),
    Caracteristicas_Vehiculo = document.getElementById('Caracteristicas_Vehiculo'),
    Elementos_Realizan_D = document.getElementById('Elementos_Realizan_D'),
    Fecha_Detencion = document.getElementById('Fecha_Detencion'),
    Compania = document.getElementById('Compania'),
    Colonia_1 = document.getElementById('Colonia_1'),
    Calle_1 = document.getElementById('Calle_1'),
    noInterior_1 = document.getElementById('noInterior_1'),
    noExterior_1 = document.getElementById('noExterior_1'),
    cordY_1 = document.getElementById('cordY_1'),
    cordX_1 = document.getElementById('cordX_1'),
    Municipio_1 = document.getElementById('Municipio_1'),
    CP_1 = document.getElementById('CP_1'),
    Path_Pdf = document.getElementById('Path_Pdf')


const data = document.getElementById('InteligenciaOperativaForm');

let Nombre_Elemento_R_Error = document.getElementById('Nombre_Elemento_R_error'),
    Responsable_Turno_Error = document.getElementById('Responsable_Turno_error'),
    Fecha_Turno_Error = document.getElementById('Fecha_Turno_error'),
    Semana_Error = document.getElementById('Semana_error'),
    Folio_Deri_Error = document.getElementById('Folio_Deri_error'),
    Fecha_Evento_Error = document.getElementById('Fecha_Evento_error'),
    Hora_Reporte_Error = document.getElementById('Hora_Reporte_error'),
    Caracteristicas_Robo_Error = document.getElementById('Caracteristicas_Robo_error'),
    Colonia_Error = document.getElementById('Colonia_inteligencia_error'),
    Calle_Error = document.getElementById('Calle_inteligencia_error'),
    cordY_Error = document.getElementById('cordY_inteligencia_error'),
    cordX_Error = document.getElementById('cordX_inteligencia_error'),
    Municipio_Error = document.getElementById('Municipio_inteligencia_error'),
    CP_Error = document.getElementById('CP_inteligencia_error'),
    Ubicacion_Camaras_Error = document.getElementById('Ubicacion_Camaras_error'),
    Unidad_Primer_R_Error = document.getElementById('Unidad_Primer_R_error'),
    Informacion_Primer_R_Error = document.getElementById('Informacion_Primer_R_error'),
    Acciones_Error = document.getElementById('Acciones_error'),
    Caracteristicas_Vehiculo_Error = document.getElementById('Caracteristicas_Vehiculo_error'),
    Elementos_Realizan_D_Error = document.getElementById('Elementos_Realizan_D_error'),
    Fecha_Detencion_Error = document.getElementById('Fecha_Detencion_error'),
    Colonia_inteligencia_1_Error = document.getElementById('Colonia_inteligencia_1_error'),
    Calle_inteligencia_1_Error = document.getElementById('Calle_inteligencia_1_error'),
    cordY_inteligencia_1_Error = document.getElementById('cordY_inteligencia_1_error'),
    cordX_inteligencia_1_Error = document.getElementById('cordX_inteligencia_1_error'),
    Municipio_inteligencia_1_Error = document.getElementById('Municipio_inteligencia_1_error'),
    CP_inteligencia_1_Error = document.getElementById('CP_inteligencia_1_error'),
    Path_Pdf_Error = document.getElementById('Path_Pdf_error'),
    msg_principalesError = document.getElementById('msg_principales')

document.getElementById('Folio_Deri').disabled = true

document.getElementById('Origen_Evento').addEventListener('input', () => {
    document.getElementById('Folio_Deri').disabled = (document.getElementById('Origen_Evento').value === '911') ? false : true;
})


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

        Nombre_Elemento_R.value = inteligencia_operativa.Nombre_Elemento_R
        Responsable_Turno.value = inteligencia_operativa.Responsable_Turno
        Origen_Evento.value = inteligencia_operativa.Origen_Evento

        document.getElementById('Folio_Deri').disabled = (inteligencia_operativa.Origen_Evento != '911') ? true : false;


        Fecha_Turno.value = inteligencia_operativa.Fecha_Turno
        Turno.value = inteligencia_operativa.Turno
        Semana.value = inteligencia_operativa.Semana
        Folio_Deri.value = inteligencia_operativa.Folio_Deri
        Fecha_Evento.value = inteligencia_operativa.Fecha_Evento
        Hora_Reporte.value = inteligencia_operativa.Hora_Reporte
        Motivo.value = inteligencia_operativa.Motivo
        Caracteristicas_Robo.value = inteligencia_operativa.Caracteristicas_Robo

        const violencia = (inteligencia_operativa.Violencia === 'No') ? 'Violencia_0' : 'Violencia_1'
        document.getElementById(violencia).checked = true;

        Tipo_Violencia.value = inteligencia_operativa.Tipo_Violencia
        Colonia.value = domicilio_0.Colonia
        Calle.value = domicilio_0.Calle
            /*===========================================*/
        noInterior.value = domicilio_0.No_Interior
        noExterior.value = domicilio_0.No_Exterior
            /*===========================================*/
        cordY.value = domicilio_0.Coordenada_Y
        cordX.value = domicilio_0.Coordenada_X
        Municipio.value = domicilio_0.Municipio
        CP.value = domicilio_0.CP

        Zona_Evento.value = inteligencia_operativa.Zona_Evento
        Vector.value = inteligencia_operativa.Vector
            // Ubicacion_Camaras.value = inteligencia_operativa.Ubicacion_Camaras

        // const estatusCamara = (inteligencia_operativa.Estatus_Camara === 'No') ? 'Estatus_Camara_0' : 'Estatus_Camara_1'
        // document.getElementById(estatusCamara).checked = true;

        Unidad_Primer_R.value = inteligencia_operativa.Unidad_Primer_R
        Informacion_Primer_R.innerText = inteligencia_operativa.Informacion_Primer_R
        Acciones.innerText = inteligencia_operativa.Acciones

        // const identificacionPlacas = (inteligencia_operativa.Identificacion_Placa === 'NO') ? 'Identificacion_Placa_0' : 'Identificacion_Placa_1';
        // document.getElementById(identificacionPlacas).checked = true;

        // Uso_Vehiculo.value = inteligencia_operativa.Uso_Vehiculo
        // Caracteristicas_Vehiculo.innerText = inteligencia_operativa.Caracteristicas_Vehiculo

        const Identificacion_Responsables = (inteligencia_operativa.Identificacion_Responsables === 'No') ? 'Identificacion_Responsables_0' : 'Identificacion_Responsables_1'
        document.getElementById(Identificacion_Responsables).checked = true;


        const Detencion_Por_Info_Io = (inteligencia_operativa.Detencion_Por_Info_Io === 'No') ? 'Detencion_Por_Info_Io_0' : 'Detencion_Por_Info_Io_1'
        document.getElementById(Detencion_Por_Info_Io).checked = true;

        Elementos_Realizan_D.value = inteligencia_operativa.Elementos_Realizan_D
        Fecha_Detencion.value = inteligencia_operativa.Fecha_Detencion
        Compania.value = inteligencia_operativa.Compania

        Colonia_1.value = domicilio_1.Colonia
        Calle_1.value = domicilio_1.Calle
        noInterior_1.value = domicilio_1.No_Interior
        noExterior_1.value = domicilio_1.No_Exterior
        cordY_1.value = domicilio_1.Coordenada_Y
        cordX_1.value = domicilio_1.Coordenada_X
        Municipio_1.value = domicilio_1.Municipio
        CP_1.value = domicilio_1.CP

        if (inteligencia_operativa.Path_Pdf != '')
            document.getElementById('RenderPDF').innerHTML = `
                <embed src="${base_url_js}public/files/InteligenciaOperativa/${arg}/${inteligencia_operativa.Path_Pdf}" width="100%" height="400"  type="application/pdf"> `;
        console.log(vehiculo);

        if (vehiculo.length > 0) {
            for (let i = 0; i < vehiculo.length; i++) {
                let formData = {
                    marcaVehiculoSegPer: vehiculo[i].Marca,
                    modeloVehiculoSegPer: vehiculo[i].Modelo,
                    colorVehiculoSegPer: vehiculo[i].Color,
                    identifiacionVehiculoSegPer: vehiculo[i].Identificacion_Placa,
                    placaVehiculoSegPer: vehiculo[i].Placas,
                    usoVehiculoSegPer: vehiculo[i].Uso_vehiculo,
                    caracteristicasVehiculoSegPer: vehiculo[i].Caracteristicas_Vehiculo,
                    involucrado_robado2: vehiculo[i].Involucrado_robado

                }
                insertNewRowSegVehPer(formData);
            }
        }

        if (camara.length > 0) {
            for (let i = 0; i < camara.length; i++) {
                let formData = {
                    Ubicacion_Camaras: camara[i].Ubicacion,
                    Funciona_Camara: camara[i].Estatus_Camara,
                    tipo_camara2: camara[i].Tipo_Camara
                }
                insertNewRowCamaras(formData);
            }
        }
    })
}




const readTableSP = () => {
    const table = document.getElementById('seguimientoVehiculosPer');
    let vehiculos = [];

    for (let i = 1; i < table.rows.length; i++) {
        vehiculos.push({
            ['row']: {
                marca: table.rows[i].cells[0].innerHTML,
                modelo: table.rows[i].cells[1].innerHTML,
                color: table.rows[i].cells[2].innerHTML,
                identificacionPlaca: table.rows[i].cells[3].innerHTML,
                placa: table.rows[i].cells[4].innerHTML,
                Uso: table.rows[i].cells[5].innerHTML,
                Involucrado_robado: table.rows[i].cells[6].innerHTML,
                caracteristicas: table.rows[i].cells[7].innerHTML
            }
        })
    }

    return vehiculos;
}


const readTableCamaras = () => {
    const table = document.getElementById('camarasIO');
    let camaras = [];

    for (let i = 1; i < table.rows.length; i++) {
        camaras.push({
            ['row']: {
                ubicacion: table.rows[i].cells[0].innerHTML,
                estatus: table.rows[i].cells[1].innerHTML,
                tipo: table.rows[i].cells[2].innerHTML
            }
        })
    }

    return camaras;
}

document.getElementById('btn_Inteligencia').addEventListener('click', (e) => {
    document.getElementById('btn_Inteligencia').disabled = false;
    e.preventDefault();

    let myFormData = new FormData(data);
    const campos = ['marcaVehiculoSegPer', 'modeloVehiculoSegPer', 'colorVehiculoSegPer', 'identifiacionVehiculoSegPer', 'placaVehiculoSegPer', 'usoVehiculoSegPer', 'caracteristicasVehiculoSegPer'];
    const campos_camara = ['Ubicacion_Camaras', 'Funciona_Camara'];

    let band = []

    let FV = new FormValidator()
    let i = 0;

    band[i++] = Nombre_Elemento_R_Error.innerText = FV.validate(myFormData.get('Nombre_Elemento_R'), 'required');
    band[i++] = Responsable_Turno_Error.innerText = FV.validate(myFormData.get('Responsable_Turno'), 'required');
    band[i++] = Fecha_Turno_Error.innerText = FV.validate(myFormData.get('Fecha_Turno'), 'required | date');
    band[i++] = Semana_Error.innerText = FV.validate(myFormData.get('Semana'), 'required | numeric');

    if (document.getElementById('Origen_Evento').value === '911')
        band[i++] = Folio_Deri_Error.innerText = FV.validate(myFormData.get('Folio_Deri'), 'required | numeric');

    band[i++] = Fecha_Evento_Error.innerText = FV.validate(myFormData.get('Fecha_Evento'), 'required | date');
    band[i++] = Hora_Reporte_Error.innerText = FV.validate(myFormData.get('Hora_Reporte'), 'required | time');
    band[i++] = Caracteristicas_Robo_Error.innerText = FV.validate(myFormData.get('Caracteristicas_Robo'), 'required');
    band[i++] = Colonia_Error.innerText = FV.validate(myFormData.get('Colonia'), 'required ');
    band[i++] = Calle_Error.innerText = FV.validate(myFormData.get('Calle'), 'required');
    band[i++] = cordY_Error.innerText = FV.validate(myFormData.get('cordY'), 'required | numeric');
    band[i++] = cordX_Error.innerText = FV.validate(myFormData.get('cordX'), 'required | numeric');
    band[i++] = Municipio_Error.innerText = FV.validate(myFormData.get('Municipio'), 'required');
    // band[i++] = Ubicacion_Camaras_Error.innerText = FV.validate(myFormData.get('Ubicacion_Camaras'), 'required')
    band[i++] = Unidad_Primer_R_Error.innerText = FV.validate(myFormData.get('Unidad_Primer_R'), 'required')
    band[i++] = Informacion_Primer_R_Error.innerText = FV.validate(myFormData.get('Informacion_Primer_R'), 'required | max_length[6000]')
    band[i++] = Acciones_Error.innerText = FV.validate(myFormData.get('Acciones'), 'required | max_length[6000]')


    let message = '';
    for (i = 0; i < campos.length; i++) {
        if (document.getElementById(campos[i]).value != '') {
            band[i++] = message = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa el apartado "Vehículos Relacionados", hay información sin agregar a la tabla</div>'
            break;
        }
    }

    let message_camara = '';
    for (i = 0; i < campos_camara.length; i++) {
        if (document.getElementById(campos_camara[i]).value != '') {
            band[i++] = message_camara = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa la tabla "Registro de cámaras implicadas en el evento", hay información sin agregar.</div>'
            break;
        }
    }




    //se comprueban todas las validaciones
    let success = true
    band.forEach(element => {
        success &= (element == '') ? true : false
    })

    if (success) {

        myFormData.append('boton_Inteligencia', document.getElementById('btn_Inteligencia').value)
        myFormData.append('table_vehiculos', JSON.stringify(readTableSP()));
        myFormData.append('camaras', JSON.stringify(readTableCamaras()));


        fetch(base_url_js + 'InteligenciaOperativa/UpdateIO', {
            method: 'POST',
            body: myFormData
        })

        .then(res => res.json())

        .then(data => {
            console.log(data);
            if (!data.status) {
                Nombre_Elemento_R_Error.innerHTML = (data.Nombre_Elemento_R_Error === undefined) ? '' : data.Nombre_Elemento_R_Error;
                Responsable_Turno_Error.innerHTML = (data.Responsable_Turno_Error === undefined) ? '' : data.Responsable_Turno_Error;
                Fecha_Turno_Error.innerHTML = (data.Fecha_Turno_Error === undefined) ? '' : data.Fecha_Turno_Error;
                Semana_Error.innerHTML = (data.Semana_Error === undefined) ? '' : data.Semana_Error;
                Fecha_Evento_Error.innerHTML = (data.Fecha_Evento_Error === undefined) ? '' : data.Fecha_Evento_Error;
                Hora_Reporte_Error.innerHTML = (data.Hora_Reporte_Error === undefined) ? '' : data.Hora_Reporte_Error;
                Caracteristicas_Robo_Error.innerHTML = (data.Caracteristicas_Robo_Error === undefined) ? '' : data.Caracteristicas_Robo_Error;
                Colonia_Error.innerHTML = (data.Colonia_Error === undefined) ? '' : data.Colonia_Error;
                Calle_Error.innerHTML = (data.Calle_Error === undefined) ? '' : data.Calle_Error;
                cordY_Error.innerHTML = (data.cordY_Error === undefined) ? '' : data.cordY_Error;
                cordX_Error.innerHTML = (data.cordX_Error === undefined) ? '' : data.cordX_Error;
                Municipio_Error.innerHTML = (data.Municipio_Error === undefined) ? '' : data.Municipio_Error;
                Unidad_Primer_R_Error.innerHTML = (data.Unidad_Primer_R_Error === undefined) ? '' : data.Unidad_Primer_R_Error;
                Informacion_Primer_R_Error.innerHTML = (data.Informacion_Primer_R_Error === undefined) ? '' : data.Informacion_Primer_R_Error;
                Acciones_Error.innerHTML = (data.Acciones_Error === undefined) ? '' : data.Acciones_Error;
                if ('error_message' in data) {
                    if (data.error_message != 'Render Index') {
                        messageError = `<div class="alert alert-danger text-center" role="alert">Sucedio un error en el servidor: ${data.error_message.errorInfo[2]}</div>`;
                    } else {
                        messageError = `<div class="alert alert-danger text-center alert-session-create" role="alert">
                                    <p>Sucedio un error, su sesión caduco o no tiene los permisos necesarios. Por favor vuelva a iniciar sesión.</p>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalLogin">
                                        Iniciar sesión
                                    </button>
                                </div>`;
                    }
                    msg_principalesError.innerHTML = messageError
                    window.scroll({
                        top: 0,
                        left: 100,
                        behavior: 'smooth'
                    });
                }

            } else {
                document.getElementById('btn_Inteligencia').disabled = true;
                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });

                msg_principalesError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información ha sido almacenada correctamente. Usted será redirigido a la página principal'
                setInterval(function() {
                    msg_principalesError.innerHTML = ''
                    window.location = base_url_js + 'InteligenciaOperativa';
                }, 3000);
            }
        })

        .catch((e) => {
            console.log('Error' + e)
        })

    } else { //si no, se muestran errores en pantalla
        (message === '') ? msg_principalesError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>': msg_principalesError.innerHTML = message;
        (message_camara === '') ? msg_principalesError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>': msg_principalesError.innerHTML = message_camara;
        document.getElementById('btn_Inteligencia').disabled = false;
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });
    }

    /* for (let pair of myFormData.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
    } */

})

Path_Pdf.addEventListener('change', (e) => {
    const url = URL.createObjectURL(e.target.files[0])
    document.getElementById('RenderPDF').innerHTML = `
        <embed src="${url}" width="100%" height="400"  type="application/pdf">
    `;
})