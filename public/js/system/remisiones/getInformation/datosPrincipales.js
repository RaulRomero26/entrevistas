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
var estadoError = document.getElementById('Estado_principales_error')
var municipioError = document.getElementById('Municipio_principales_error')
var cpError = document.getElementById('CP_principales_error')
var pertenenciasError = document.getElementById('pertenencias_rem_error')
var fecha_nacimientoError = document.getElementById('FechaNacimiento_principales_error')
var rfcError = document.getElementById('RFC_principales_error')
var correoError = document.getElementById('correo_principales_error')
var telefonoError = document.getElementById('Telefono_principales_error')
var imei1Error = document.getElementById('imei_1_principales_error')
var imei2Error = document.getElementById('imei_2_principales_error')
var Folio911Error = document.getElementById('911_principalesError')


//Elemento html para asignar información recuperada de la BD

var Folio911_principales = document.getElementById('911_principales')
var fecha_pricipales = document.getElementById('fecha_principales')
var hora_pricipales = document.getElementById('hora_principales')
var tipoFicha1_pricipales = document.getElementById('tipoFicha1')
var tipoFicha2_pricipales = document.getElementById('tipoFicha2')
var CIA_principales = document.getElementById('CIA_principales')
var Remitido_principales = document.getElementById('Remitido')
var status_principales = document.getElementById('statusR_principales')


var nombe_principales = document.getElementById('Nombre_principales')
var aPaterno_principales = document.getElementById('appPaterno_principales')
var aMaterno_principales = document.getElementById('appMaterno_principales')
var edad_principales = document.getElementById('edad_principales')
var sexo_principales_select = document.getElementById('sexo_principales_select')
var sexo_principales = document.getElementById('sexo_principales')
var escolaridad_principales = document.getElementById('escolaridad_principales')
var procedencia_principales = document.getElementById('procedencia_principales')
var curp_principales = document.getElementById('CURP_principales')
var nacionalidad_mexicana = document.getElementById('nacionalidad_mexicana')
var nacionalidad_extranjera = document.getElementById('nacionalidad_extranjera')
var domicilio_puebla = document.getElementById('domicilio_puebla')
var domicilio_foraneo = document.getElementById('domicilio_foraneo')
var procedencia_estado_principales = document.getElementById('procedencia_estado_principales')

var curpV_principales = document.getElementById('verificado_principales')
var alcoholemia_principales = document.getElementById('alcoholemia_principales')

var Colonia_principales = document.getElementById('Colonia')
var Calle_principales = document.getElementById('Calle')
var noInterior_principales = document.getElementById('noInterior')
var noExterior_principales = document.getElementById('noExterior')
var cordY_principales = document.getElementById('cordY')
var cordX_principales = document.getElementById('cordX')
var Estado_principales = document.getElementById('Estado')
var Municipio_principales = document.getElementById('Municipio')
var CP_principales = document.getElementById('CP')

var pertenencias_rem = document.getElementById('pertenencias_rem')




var FechaNacimiento_principales = document.getElementById('FechaNacimiento_principales')
var RFC_principales = document.getElementById('RFC_principales')
var correo_principales = document.getElementById('correo_principales')
var Ocupacion_principales = document.getElementById('Ocupacion_principales')
var Facebook_principales = document.getElementById('Facebook_principales')
var edoCivil_principales = document.getElementById('edoCivil_principales')
var Telefono_principales = document.getElementById('Telefono_principales')
var imei_1_principales = document.getElementById('imei_1_principales')
var imei_2_principales = document.getElementById('imei_2_principales')
var Alias = document.getElementById('Alias')
var cancelar_ficha = document.getElementById('cancelar_ficha')
var cancelar_remision = document.getElementById('cancelar_remision')
document.getElementById('cancelar_ficha').addEventListener("change",cambiar_status_remision)
function cambiar_status_remision(){
    if(document.getElementById('cancelar_ficha').checked){
        document.getElementById('cancelar_remision').disabled=true
        document.getElementById('cancelar_remision').checked=true
    }
    else
        document.getElementById('cancelar_remision').disabled=false
}

var Id_Domicilio_Principales;


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

function soloNumeros(e) {
    tecla = (document.all) ? e.keyCode : e.which;

    // Patron de entrada, en este caso solo acepta numeros
    patron = /[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}



window.onload = function() {
    getPrincipales()
    getPeticionario()
    getUbicacionH()
    getUbicaciond()
    getMediaFiliacion()
    //Funcion nueva que se manda a llamar para rellenar la tabla
    //de contactos conocidos del detenido
    getContactoDetenido()

    getElementosParticipantes();
    getObjetosRecuperados();
    getSenasParticulares();
    getEntrevistaDetenido();
    getNarrativas();

    getHuellas();
    getStatusIris();

    // getTabsValidados();
    getTabsGuardados();

    let online = window.navigator.onLine;
    if (!online) {
        offlineMapsPrincipal_MAPBOX();
    }
};

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
    e.preventDefault();
    const button = document.getElementById('btn_principal');

    var myFormData = new FormData(data)
    var band = []
    if(document.getElementById('cancelar_remision').checked)    
        myFormData.append('remision_cancelada', "0")
    else
        myFormData.append('remision_cancelada', "1")

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

    band[i++] = coloniaError.innerText = await validateColonia(Colonia_principales.value,2,myFormData.get('busqueda_puebla'))
    band[i++] = calleError.innerText = await validateCalle(myFormData.get("Calle"),3,myFormData.get('busqueda_puebla'))



    //se comprueban todas las validaciones
    var success = true
    band.forEach(element => {
        success &= (element == '') ? true : false
    })

    const result = await getTabValidado(0);
    if(!result){
        success = false;
    }

    if (success) { //si todo es correcto se envía form
        button.innerHTML = `
            Guardando
            <div class="spinner-grow spinner-grow-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        `;
        button.classList.add('disabled-link');
        myFormData.append('boton_principales', document.getElementById('btn_principal').value)
        myFormData.append('Id_Domicilio', Id_Domicilio_Principales)

        fetch(base_url + 'ModificarRemision', {
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

                if ('Folio911Error' in data)
                    Folio911Error.innerText = (data.Folio911Error === undefined) ? '' : data.Folio911Error

                fechaError.innerText = (data.fechaError === undefined) ? '' : data.fechaError
                horaError.innerText = (data.horaError === undefined) ? '' : data.horaError
                nombreError.innerText = (data.nombreError === undefined) ? '' : data.nombreError
                apellidoPError.innerText = (data.apellidoPError === undefined) ? '' : data.apellidoPError
                edadError.innerText = (data.edadError === undefined) ? '' : data.edadError
                procedenciaError.innerText = (data.procedenciaError === undefined) ? '' : data.procedenciaError

                if ('curpError' in data)
                    curpError.innerText = data.curpError

                coloniaError.innerText = (data.coloniaError === undefined) ? '' : data.coloniaError
                calleError.innerText = (data.calleError === undefined) ? '' : data.calleError
                cordYError.innerText = (data.cordYError === undefined) ? '' : data.cordYError
                cordXError.innerText = (data.cordXError === undefined) ? '' : data.cordXError
                municipioError.innerText = (data.municipioError === undefined) ? '' : data.municipioError
                cpError.innerText = (data.cpError === undefined) ? '' : data.cpError

                if ('pertenenciasError' in data)
                    pertenenciasError.innerText = (data.pertenenciasError === undefined) ? '' : data.pertenenciasError

                if ('fecha_nacimientoError' in data)
                    fecha_nacimientoError.innerText = (data.fecha_nacimientoError === undefined) ? '' : data.fecha_nacimientoError

                if ('rfcError' in data)
                    rfcError.innerText = (data.rfcError === undefined) ? '' : data.rfcError

                if ('correoError' in data)
                    correoError.innerText = (data.correoError === undefined) ? '' : data.correoError

                if ('imei1Error' in data)
                    imei1Error.innerText = (data.imei1Error === undefined) ? '' : data.imei1Error

                if ('imei2Error' in data)
                    imei2Error.innerText = (data.imei2Error === undefined) ? '' : data.imei2Error


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
                edadError.innerText = ''
                procedenciaError.innerText = ''

                coloniaError.innerText = ''
                calleError.innerText = ''
                cordYError.innerText = ''
                cordXError.innerText = ''
                estadoError.innerText = ''
                municipioError.innerText = ''
                cpError.innerText = ''
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

                msg_principalesError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información actualizada con éxito</div>';
                getTabsGuardados();
                // result.tab === '1' ? '' : document.getElementById('save-tab-0').style.display = 'block';
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

        //console.log(pair[0]+ ', '+ pair[1]); 
    }
})



function getPrincipales() {
    var no_ficha = document.getElementById('no_ficha_principales')
    var no_remision = document.getElementById('no_remision_principales')

    var myFormData = new FormData()
    myFormData.append('no_ficha', no_ficha.value)
    myFormData.append('no_remision', no_remision.value)

    fetch(base_url + 'getPrincipales', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {
        //console.log(data)

        Folio911_principales.value = data.Folio_911

        //Descomponer fecha y hora, se cambio la variable a Fecha_Hora para que se mostrara la fecha editada y no la de la creacion de la remision
        var auxDateTime = splitDateTime(data.Fecha_Hora);
        fecha_pricipales.value = auxDateTime[0]
        hora_pricipales.value = auxDateTime[1]
        hora_pricipales.value = hora_pricipales.value.substring(0, 5)
        /*Se saco la condicional para asignar a zona la zona de la base de datos,ya que al crearse por primera vez no asigna correctamente, debido a que solo
        maneja los casos para cuando Grupo es policia o transito, esto de grupo debe de revisarse para cambiarse
        Ademas se copia el caso de policia para transito y se agrega la opcion de default, para que en  caso que no se ninguna
        aun muestre zonas y no sectores*/
        document.getElementById('zona').value = data.Zona_Sector
        switch (data.Grupo) {
            case 'POLICÍA':
                tipoFicha1_pricipales.checked = true;
                tipoFicha2_pricipales.checked = false;
                document.getElementById('zona').value = data.Zona_Sector
                document.getElementById('zonaContent').style.display = 'block'
                document.getElementById('sectorContent').style.display = 'none'
                break;

            case 'TRÁNSITO':
                tipoFicha1_pricipales.checked = true;
                tipoFicha2_pricipales.checked = false;
                document.getElementById('zona').value = data.Zona_Sector
                document.getElementById('zonaContent').style.display = 'block'
                document.getElementById('sectorContent').style.display = 'none'
                break;
            default:
                tipoFicha1_pricipales.checked = true;
                tipoFicha2_pricipales.checked = false;
                document.getElementById('zona').value = data.Zona_Sector
                document.getElementById('zonaContent').style.display = 'block'
                document.getElementById('sectorContent').style.display = 'none'
                break;
        }

        CIA_principales.value = (data.Cia === '') ? 'PRIMERO' : data.Cia;

        Remitido_principales.value = (data.Instancia === '') ? 'M.P. FUERO COMÚN' : data.Instancia;
        getDataRemitidoA(Remitido_principales.value);

        status_principales.value = (data.Status_Remision === '') ? 1 : data.Status_Remision;
        nombe_principales.value = data.Nombre
        aPaterno_principales.value = data.Ap_Paterno
        aMaterno_principales.value = data.Ap_Materno
        edad_principales.value = data.Edad
        sexo_principales.value = data.Genero.toLowerCase();
        // sexo_principales.value = data.Genero;
        escolaridad_principales.value = (data.Escolaridad === '') ? 'PRIMARIA CONCLUIDA' : data.Escolaridad;
        procedencia_principales.value = data.Lugar_Origen
        curp_principales.value = data.CURP;
        if(data.Nacionalidad=="MEXICANA"){
            nacionalidad_mexicana.checked=true
            procedencia_estado_principales.value=data.EstadoMex_Origen
            document.getElementById('estado_nacimiento').style.display = 'block'
        }   
        else{
            nacionalidad_extranjera.checked=true
            procedencia_estado_principales.value="SD"
            document.getElementById('estado_nacimiento').style.display = 'none'
        }

        if (data.f_cancelada == 'cancelada'){
            cancelar_ficha.checked = true
            document.getElementById('cancelar_remision').disabled=true
            cancelar_remision.checked = true
            document.getElementById('estado_ficha_original').value="cancelada";
        }
        else{
            document.getElementById('estado_ficha_original').value="";
            if (data.Status_Remision == '0')
                cancelar_remision.checked = true
        }
        if(data.Domicilio_en=="PUEBLA")
        domicilio_puebla.checked=true
        else
            domicilio_foraneo.checked=true
        if (data.Alcoholemia == '1')
        alcoholemia_principales.checked = true
        
        if (data.Verificacion_CURP == '1')
        curpV_principales.checked = true
        
        if (data.Alcoholemia == '1')
        alcoholemia_principales.checked = true
        
        if (data.Verificacion_CURP == '1')
        curpV_principales.checked = true
        
        Colonia_principales.value = data.Colonia
        Calle_principales.value = data.Calle
        noInterior_principales.value = data.No_Interior
        noExterior_principales.value = data.No_Exterior
        cordY_principales.value = data.Coordenada_Y
        cordX_principales.value = data.Coordenada_X
        Municipio_principales.value = data.Municipio
        CP_principales.value = data.CP
        Estado_principales.value = data.Estado
        /*if(data.Coordenada_Y != "" && data.Coordenada_X != ""){
            principales['porCoordenada'].style.display = 'block';
            principales['searchCoordenadaY'].value = data.Coordenada_Y;
            principales['searchCoordenadaX'].value = data.Coordenada_X;
        }*/

        pertenencias_rem.value = data.Pertenencias_Detenido



        document.getElementById('delito_1').innerHTML = data.faltas_Delitos

        if (data.Fecha_Nacimiento != "0000-00-00")
            FechaNacimiento_principales.value = data.Fecha_Nacimiento

        RFC_principales.value = data.RFC
        correo_principales.value = data.Correo_Electronico
        Ocupacion_principales.value = data.Ocupacion
        Facebook_principales.value = data.Facebook
        edoCivil_principales.value = (data.Estado_Civil === '') ? 1 : data.Estado_Civil;
        Telefono_principales.value = data.Telefono

        if (data.Telefono != '') {
            document.getElementById('imei_1_principales').disabled = false
            document.getElementById('imei_2_principales').disabled = false
            imei_1_principales.value = data.Imei1
            imei_2_principales.value = data.Imei2
        }

        Alias.value = data.alias_detenido

        Id_Domicilio_Principales = data.Id_Domicilio
    })
}

function splitDateTime(data) {
    return data.split(" ")
}
/*Funcion añadida para saber si la combinacion de estado-municipio ingresada existe como valida*/
const validarMunicipio = async ()=> {
    if((document.getElementById('procedencia_principales').value).length > 0){
        municipioValido = ""
        //Para validadr municipio necesitamos que sea mexicano y que se haya seleccionado un estado
        if(document.getElementById('nacionalidad_mexicana').checked){
            if(document.getElementById('procedencia_estado_principales').value!="SD"){
                myFormData_muni=new FormData()
                myFormData_muni.append('municipio', document.getElementById('procedencia_principales').value)
                myFormData_muni.append('estado', document.getElementById('procedencia_estado_principales').value)
                try {
                    const response = await fetch(base_url_js + 'Remisiones/existeMunicipio', {
                        method: 'POST',
                        body: myFormData_muni
                    });
                    const data = await response.json();
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

// Colonia_principales.addEventListener('input', () => {
//     Colonia_principales.value = ''
//     cordY_principales.value = ''
//     cordX_principales.value = ''
//     noInterior_principales.value = ''
//     noExterior_principales.value = ''
//     Municipio_principales.value = ''
//     CP_principales.value = ''
//     Calle_principales.value = ''
// })


// Calle_principales.addEventListener('input', () => {
//     cordY_principales.value = ''
//     cordX_principales.value = ''
//     Colonia_principales.value = ''
//     noInterior_principales.value = ''
//     noExterior_principales.value = ''
//     Municipio_principales.value = ''
//     CP_principales.value = ''
//     Calle_principales.value = ''
// })
