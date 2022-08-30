var data = document.getElementById('datos_principales')

var fechaError = document.getElementById('fechaP_error')
var horaError = document.getElementById('hora_error')
var nombreError = document.getElementById('Nombre_principales_error')
var apellidoPError = document.getElementById('appPaterno_principales_error')
var apellidoMError = document.getElementById('appMaterno_principales_error')
var edadError = document.getElementById('edad_principales_error')
var procedenciaError = document.getElementById('procedencia_principales_error')
var curpError = document.getElementById('CURP_principales_error')
var coloniaError = document.getElementById('Colonia_principales_error')
var calleError = document.getElementById('Calle_principales_error')
var cordYError = document.getElementById('cordY_principales_error')
var cordXError = document.getElementById('cordX_principales_error')
var cpError = document.getElementById('CP_principales_error')
var estadoError = document.getElementById('Estado_principales_error')
var municipioError = document.getElementById('Municipio_principales_error')
var pertenenciasError = document.getElementById('pertenencias_rem_error')
var fecha_nacimientoError = document.getElementById('FechaNacimiento_principales_error')
var rfcError = document.getElementById('RFC_principales_error')
var correoError = document.getElementById('correo_principales_error')
var telefonoError = document.getElementById('Telefono_principales_error')
var imei1Error = document.getElementById('imei_1_principales_error')
var imei2Error = document.getElementById('imei_2_principales_error')
var Folio911Error = document.getElementById('911_principalesError')

var msg_principalesError = document.getElementById('msg_principales')

document.getElementById('imei_1_principales').disabled = true
document.getElementById('imei_2_principales').disabled = true

document.getElementById('Telefono_principales').addEventListener('input', () => {

    switch (document.getElementById('Telefono_principales').value.length) {

        case 10:
            document.getElementById('imei_1_principales').disabled = false
            document.getElementById('imei_2_principales').disabled = false
            break;

        default:
            document.getElementById('imei_1_principales').disabled = true
            document.getElementById('imei_2_principales').disabled = true
            break;
    }
})

function valideKey(evt) {
    // code is the decimal ASCII representation of the pressed key.
    var code = (evt.which) ? evt.which : evt.keyCode;

    if (code == 8) { // backspace.
        return true;
    } else if (code >= 48 && code <= 57) { // is a number.
        return true;
    } else { // other keys.
        return false;
    }
}


document.getElementById('btn_principal').addEventListener('click', async function(e) {
    e.preventDefault()

    var myFormData = new FormData(data)
    var band = []

    var FV = new FormValidator()
    var i = 0

    if (myFormData.get('911_principales') != '')
        band[i++] = Folio911Error.innerText = FV.validate(myFormData.get('911_principales'), 'numeric')

    band[i++] = fechaError.innerText = FV.validate(myFormData.get('fecha_principales'), 'required | date')
    band[i++] = horaError.innerText = FV.validate(myFormData.get('hora_principales'), 'required | time')
    band[i++] = nombreError.innerText = FV.validate(myFormData.get('Nombre_principales'), 'required')
    band[i++] = apellidoPError.innerText = FV.validate(myFormData.get('appPaterno_principales'), 'required')

    if (myFormData.get('edad_principales') != '')
        band[i++] = edadError.innerText = FV.validate(myFormData.get('edad_principales'), 'numeric | length[2]')

    band[i++] = procedenciaError.innerText = await validarMunicipio()

    if (myFormData.get('CURP_principales') != '')
        band[i++] = curpError.innerText = FV.validate(myFormData.get('CURP_principales'), 'length[18]')

    const municipio = myFormData.get('Municipio') == '' ? 'PUEBLA' : myFormData.get('Municipio');

    myFormData.set('Municipio', municipio)

    if (myFormData.get('CP') != '')
        band[i++] = cpError.innerText = FV.validate(myFormData.get('CP'), 'numeric | length[5]')

    if (myFormData.get('pertenencias_rem') != '') {
        band[i++] = pertenenciasError.innerText = FV.validate(myFormData.get('pertenencias_rem'), 'max_length[600]')
    }

    if (myFormData.get('FechaNacimiento_principales') != '')
        band[i++] = fecha_nacimientoError.innerText = FV.validate(myFormData.get('FechaNacimiento_principales'), 'date')

    if (myFormData.get('RFC_principales') != '')
        band[i++] = rfcError.innerText = FV.validate(myFormData.get('RFC_principales'), 'length[10]')

    if (myFormData.get('correo_principales') != '')
        band[i++] = correoError.innerText = FV.validate(myFormData.get('correo_principales'), 'mail')

    if (myFormData.get('Telefono_principales').length == 10) {

        if (myFormData.get('imei_1_principales') != '')
            band[i++] = imei1Error.innerText = FV.validate(myFormData.get('imei_1_principales'), 'min_length[14] | max_length[16] | numeric')

        if (myFormData.get('imei_2_principales') != '')
            band[i++] = imei2Error.innerText = FV.validate(myFormData.get('imei_2_principales'), 'min_length[14] | max_length[16] | numeric')
    }

    //se comprueban todas las validaciones
    var success = true
    band.forEach(element => {
        success &= (element == '') ? true : false
    })

    if (success) { //si todo es correcto se envía form
        myFormData.append('boton_principales', document.getElementById('btn_principal').value)

        fetch(base_url + 'insertarNuevaRemision', {
            method: 'POST',
            body: myFormData
        })

        .then(res => res.json())

        .then(data => {

            // console.log(data)
            if (!data.status) {
                Folio911Error.innerText = (data.Folio911Error === undefined) ? '' : data.Folio911Error;
                fechaError.innerText = (data.fechaError === undefined) ? '' : data.fechaError;
                horaError.innerText = (data.horaError === undefined) ? '' : data.horaError;
                nombreError.innerText = (data.nombreError === undefined) ? '' : data.nombreError;
                apellidoPError.innerText = (data.apellidoPError === undefined) ? '' : data.apellidoPError;
                apellidoMError.innerText = (data.apellidoMError === undefined) ? '' : data.apellidoMError;
                edadError.innerText = (data.edadError === undefined) ? '' : data.edadError;
                procedenciaError.innerText = (data.procedenciaError === undefined) ? '' : data.procedenciaError;
                curpError.innerText = (data.curpError === undefined) ? '' : data.curpError;
                coloniaError.innerText = (data.coloniaError === undefined) ? '' : data.coloniaError;
                calleError.innerText = (data.calleError === undefined) ? '' : data.calleError;
                cordYError.innerText = (data.cordYError === undefined) ? '' : data.cordYError;
                cordXError.innerText = (data.cordXError === undefined) ? '' : data.cordXError;
                estadoError.innerText = (data.estadoError === undefined) ? '' : data.estadoError;
                municipioError.innerText = (data.municipioError === undefined) ? '' : data.municipioError;
                pertenenciasError.innerText = (data.pertenenciasError === undefined) ? '' : data.pertenenciasError;
                fecha_nacimientoError.innerText = (data.fecha_nacimientoError === undefined) ? '' : data.fecha_nacimientoError;

                if ('rfcError' in data)
                    rfcError.innerText = (data.rfcError === undefined) ? '' : data.rfcError;

                if ('correoError' in data)
                    correoError.innerText = (data.correoError === undefined) ? '' : data.correoError;

                if ('imei1Error' in data)
                    imei1Error.innerText = (data.imei1Error === undefined) ? '' : data.imei1Error;

                if ('imei2Error' in data)
                    imei2Error.innerText = (data.imei2Error === undefined) ? '' : data.imei2Error;

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

                msg_principalesError.innerHTML = messageError
                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });

            } else {
                Folio911Error.innerText = ''
                fechaError.innerText = ''
                horaError.innerText = ''
                nombreError.innerText = ''
                apellidoPError.innerText = ''
                apellidoMError.innerText = ''
                edadError.innerText = ''
                procedenciaError.innerText = ''
                curpError.innerText = ''

                coloniaError.innerText = ''
                calleError.innerText = ''
                cordYError.innerText = ''
                cordXError.innerText = ''
                estadoError.innerText = ''
                municipioError.innerText = ''
                pertenenciasError.innerText = ''

                fecha_nacimientoError.innerText = ''

                rfcError.innerText = ''
                correoError.innerText = ''
                imei1Error.innerText = ''
                imei2Error.innerText = ''

                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });

                document.getElementById('datos_principales').reset()
                alerta(data.no_remision, data.no_ficha)
            }
        })
    } else { //si no, se muestran errores en pantalla
        msg_principalesError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>'
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });
    }

    for (var pair of myFormData.entries()) {
        // console.log(pair[0] + ', ' + pair[1]);
    }
})

function alerta(no_remision, no_ficha) {
    var opcion = confirm("¿Desea continuar con la remisión actual?");
    if (opcion == true) {
        msg_principalesError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información almacenada correctamente. En breve será redirigido a la versión completa de la remisión</div>'
        setInterval(function() { window.location = base_url + 'editarRemision/?no_remision=' + no_remision + '&no_ficha=' + no_ficha; }, 3000);
    } else {
        msg_principalesError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información almacenada correctamente. En breve será redirigido a la página prinicipal de remisiones</div>'
        setInterval(function() { window.location = base_url; }, 5000);
    }
}
/*Funcion añadida para saber si la combinacion de estado-municipio ingresada existe como valida*/
const validarMunicipio = async ()=> {
    if((document.getElementById('procedencia_principales').value).length > 0){
        console.log("Municipio")
        municipioValido = ""
        //Para validadr municipio necesitamos que sea mexicano y que se haya seleccionado un estado
        if(document.getElementById('nacionalidad_mexicana_nueva').checked){
            if(document.getElementById('procedencia_estado_principales_nueva').value!="SD"){
                myFormData_muni=new FormData()
                myFormData_muni.append('municipio', document.getElementById('procedencia_principales').value)
                myFormData_muni.append('estado', document.getElementById('procedencia_estado_principales_nueva').value)
                try {
                    const response = await fetch(base_url_js + 'Remisiones/existeMunicipio', {
                        method: 'POST',
                        body: myFormData_muni
                    });
                    const data = await response.json();
                    console.log(data)
                    console.log(data[0].CONTADOR)
                    if(data[0].CONTADOR>0)  
                    municipioValido=""
                    else
                    municipioValido="Ingrese un municipio acorde al estado"
                } catch (error) {
                    console.log(error);
                }
            }
            else
                municipioValido=""
        }
        else{
            municipioValido=""
        }
    }
    else{
        municipioValido="Campo requerido"
    }
    return municipioValido;
}