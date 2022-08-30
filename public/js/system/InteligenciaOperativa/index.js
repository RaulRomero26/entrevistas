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


document.getElementById('btn_Inteligencia').addEventListener('click', function(e) {
    this.disabled = true;
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
        // band[i++] = Caracteristicas_Vehiculo_Error.innerText = FV.validate(myFormData.get('Caracteristicas_Vehiculo'), 'required | max_length[500]')
        // band[i++] = Path_Pdf_Error.innerText = (document.getElementById('Path_Pdf').files.length === 0) ? "Campo requerido" : '';
        // clearTable('camarasIO');

    let message = '';
    for (i = 0; i < campos.length; i++) {
        if (document.getElementById(campos[i]).value != '') {
            band[i++] = message = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa el apartado "Vehículos Relacionados", hay información sin agregar a la tabla</div>'
            break;
        }
    }

    for (i = 0; i < campos_camara.length; i++) {
        if (document.getElementById(campos_camara[i]).value != '') {
            band[i++] = message = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa la tabla "Registro de cámaras implicadas en el evento", hay información sin agregar.</div>'
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



        fetch(base_url_js + 'InteligenciaOperativa/insertarNuevaIO', {
            method: 'POST',
            body: myFormData
        })

        .then(res => res.json())
            .then(data => {
                console.log(data)
                if (!data.status) {
                    this.disabled = false;
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
                        let messageError;
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

                    window.scroll({
                        top: 0,
                        left: 100,
                        behavior: 'smooth'
                    });

                    alerta(this)
                }

            })

    } else { //si no, se muestran errores en pantalla
        // msg_principalesError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>'
        this.disabled = false;
        // console.log(`${message}-------${message_camara}`);

        (message.length === 0) ? msg_principalesError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>': msg_principalesError.innerHTML = message;
        // (message_camara === '') ? msg_principalesError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>': msg_principalesError.innerHTML = message_camara;

        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });
    }


    for (let pair of myFormData.entries()) {
        // console.log(pair[0] + ', ' + pair[1]);
    }

})








$('#Path_Pdf').change(function(e) {
    let fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    const url = URL.createObjectURL(e.target.files[0])
    document.getElementById('RenderPDF').innerHTML = `
        <embed src="${url}" width="100%" height="400"  type="application/pdf">
    `;
});


const soloNumeros = (e) => {
    tecla = (document.all) ? e.keyCode : e.which;
    patron = /[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}


const alerta = (elem) => {
    let opcion = confirm("¿Desea agregar un nuevo registro?");
    if (opcion == true) {
        msg_principalesError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información ha sido almacenada correctamente.'
        setInterval(function() {
            msg_principalesError.innerHTML = ''
            data.reset();
            document.getElementById('camarasIO').childNodes[3].innerHTML = ''
            document.getElementById('seguimientoVehiculosPer').childNodes[3].innerHTML = ''
            elem.disabled = false;
            // console.log(document.getElementById('camarasIO').childNodes)

        }, 3000);
    } else {
        msg_principalesError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información almacenada correctamente. En breve será redirigido a la página de inicio</div>'
        elem.disabled = true;
        setInterval(function() { window.location = base_url_js + 'InteligenciaOperativa'; }, 5000);
    }
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

    // console.log(camaras);
    return camaras;
}