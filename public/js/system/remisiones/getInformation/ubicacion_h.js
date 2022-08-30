var ubicacionHData = document.getElementById('datos_ubicacionH')

var ubicacionH_ColoniaError = document.getElementById('Colonia_hechos_error')
var ubicacionH_CalleError = document.getElementById('Calle_hechos_error')
var ubicacionH_Calle2Error = document.getElementById('Calle2_hechos_error')
var ubicacionH_CoordYError = document.getElementById('cordY_hechos_error')
var ubicacionH_CoordXError = document.getElementById('cordX_hechos_error')
var VectorUH_hechos_Error = document.getElementById('VectorUH_hechos_error')
var ubicacionH_CPError = document.getElementById('CP_hechos_error')
var ubicacionH_HoraError = document.getElementById('hora_hechos_error')
var ubicacionH_ParticipantesError = document.getElementById('participantes_hechos_error')
var ubicacionH_RemitidoPorError = document.getElementById('RemitidoPor_error')
var ubicacionH_FaltaDelitoError = document.getElementById('FaltaDelitoError')
var Falta_Delito_Tipo_error = document.getElementById('Falta_Delito_Tipo_error')

var Colonia_hechos = document.getElementById('Colonia_hechos')
var Calle_hechos = document.getElementById('Calle_hechos')
var Calle2_hechos = document.getElementById('Calle2_hechos')
var noInterior_hechos = document.getElementById('noInterior_hechos')
var noExterior_hechos = document.getElementById('noExterior_hechos')
var cordY_hechos = document.getElementById('cordY_hechos')
var cordX_hechos = document.getElementById('cordX_hechos')
//var ZonaUH = document.getElementById('ZonaUH')
var VectorUH = document.getElementById('VectorUH')
var CP_hechos = document.getElementById('CP_hechos')
var Fraccionamiento_hechos = document.getElementById('Fraccionamiento_hechos')
var hora_hechos = document.getElementById('hora_hechos')
var participantes_hechos = document.getElementById('participantes_hechos')
var RemitidoPor_hechos = document.getElementById('RemitidoPor')
var Falta_Delito_Tipo1 = document.getElementById('Falta_Delito_Tipo1')
var Falta_Delito_Tipo2 = document.getElementById('Falta_Delito_Tipo2')

var FaltaDelitoTabla_hechos = document.getElementById('FaltaDelitoTabla').getElementsByTagName('tbody')[0];

var msg_ubicacionHechosError = document.getElementById('msg_ubicacionHechos')

async function ValidarUbicacionH() {

    const button = document.getElementById('btn_ubicacionH');

    var myFormData = new FormData(ubicacionHData)
    var band = []
    var FV = new FormValidator()
    var i = 0

    let DataFaltaDelito = [];

    band[i++] = ubicacionH_ColoniaError.innerText = await validateColonia(Colonia_hechos.value,1,"")
    band[i++] = ubicacionH_CalleError.innerText = await validateCalle(myFormData.get("Calle_hechos"),1,"")
    band[i++] = ubicacionH_Calle2Error.innerText = await validateCalle(myFormData.get("Calle2_hechos"),2,"")
    band[i++] = ubicacionH_CoordYError.innerText = FV.validate(myFormData.get('cordY_hechos'), 'required')
    band[i++] = ubicacionH_CoordXError.innerText = FV.validate(myFormData.get('cordX_hechos'), 'required')
    band[i++] = ubicacionH_CoordXError.innerText = FV.validate(myFormData.get('cordX_hechos'), 'required')
    band[i++] = VectorUH_hechos_Error.innerText = FV.validate( myFormData.get( 'VectorUH' ), 'required' )
    if (myFormData.get('CP_hechos') != '')
        band[i++] = ubicacionH_CPError.innerText = FV.validate(myFormData.get('CP_hechos'), 'numeric | length[5]')

    band[i++] = ubicacionH_HoraError.innerText = FV.validate(myFormData.get('hora_hechos'), 'required | time')
    band[i++] = ubicacionH_ParticipantesError.innerText = FV.validate(myFormData.get('participantes_hechos'), 'required | numeric')
    band[i++] = ubicacionH_RemitidoPorError.innerText = FV.validate(myFormData.get('RemitidoPor'), 'required')
    band[i++] = ubicacionH_FaltaDelitoError.innerText = (FaltaDelitoTabla_hechos.childNodes.length <= 1) ? 'Se requiere mínimo una falta / delito' : ''

    //se comprueban todas las validaciones
    var success = true
    band.forEach(element => {
        success &= (element == '') ? true : false
    })

    const result = await getTabValidado(2);
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


        //Se crea el Json con la información de la tabla "Falta  / Delito"
        for (let i = 1; i < FaltaDelitoTabla_hechos.childNodes.length; i++) {
            DataFaltaDelito.push({
                'faltaDelito': FaltaDelitoTabla_hechos.childNodes[i].cells[0].innerHTML,
                'comercio': FaltaDelitoTabla_hechos.childNodes[i].cells[1].innerHTML,
                'ruta': FaltaDelitoTabla_hechos.childNodes[i].cells[2].innerHTML,
                'unidad': FaltaDelitoTabla_hechos.childNodes[i].cells[3].innerHTML
            })
        }

        myFormData.append('boton_ubicacionHechos', document.getElementById('btn_ubicacionH').value)
        myFormData.append('Id_Ubicacion', Id_Ubicacion_H)
        myFormData.set('delito_1', JSON.stringify(DataFaltaDelito))

        fetch(base_url + 'ModificarUbiacionH', {
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

                msg_ubicacionHechosError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información modificada correctamente.</div>'

                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });

                ubicacionH_ColoniaError.innerTex = (data.ubicacionH_ColoniaError === undefined) ? '' : data.ubicacionH_ColoniaError
                ubicacionH_CalleError.innerText = (data.ubicacionH_CalleError === undefined) ? '' : data.ubicacionH_CalleError
                ubicacionH_Calle2Error.innerText = (data.ubicacionH_CalleError === undefined) ? '' : data.ubicacionH_CalleError
                ubicacionH_CoordYError.innerText = (data.ubicacionH_CoordYError === undefined) ? '' : data.ubicacionH_CoordYError
                ubicacionH_CoordXError.innerText = (data.ubicacionH_CoordXError === undefined) ? '' : data.ubicacionH_CoordXError
                ubicacionH_CPError.innerTex = (data.CP_hechos_error === undefined) ? '' : data.CP_hechos_error

                ubicacionH_HoraError.innerText = (data.ubicacionH_HoraError === undefined) ? '' : data.ubicacionH_HoraError
                ubicacionH_ParticipantesError.innerText = (data.ubicacionH_ParticipantesError === undefined) ? '' : data.ubicacionH_ParticipantesError
                Falta_Delito_Tipo_error.innerText = (data.Falta_Delito_Tipo_error === undefined) ? '' : data.Falta_Delito_Tipo_error
                ubicacionH_RemitidoPorError.innerText = (data.ubicacionH_RemitidoPorError === undefined) ? '' : data.ubicacionH_RemitidoPorError
                ubicacionH_FaltaDelitoError.innerText = (data.ubicacionH_FaltaDelitoError === undefined) ? '' : data.ubicacionH_FaltaDelitoError

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

                msg_ubicacionHechosError.innerHTML = messageError
                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });



            } else {
                ubicacionH_ColoniaError.innerTex = ''
                ubicacionH_CalleError.innerText = ''
                ubicacionH_Calle2Error.innerText = ''
                ubicacionH_CoordYError.innerText = ''
                ubicacionH_CoordXError.innerText = ''
                ubicacionH_CPError.innerTex = ''
                ubicacionH_CPError.innerText = ''
                Falta_Delito_Tipo_error.innerText = ''

                ubicacionH_HoraError.innerText = ''
                ubicacionH_ParticipantesError.innerText = ''
                ubicacionH_RemitidoPorError.innerText = ''
                ubicacionH_FaltaDelitoError.innerText = ''

                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });

                msg_ubicacionHechosError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información modificada correctamente.</div>';
                getTabsGuardados();
                // result.tab === '1' ? '' : document.getElementById('save-tab-2').style.display = 'block';

            }
        })
    } else { //si no, se muestran errores en pantalla
        msg_ubicacionHechosError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>'
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });
    }

    for (var pair of myFormData.entries()) {
         //console.log(pair[0] + ', ' + pair[1]);
    }
}

var delito_1 = document.getElementById('delito_1')
delito_1.addEventListener('input', () => {
    delitoSelectDom(delito_1.value);
})

const delitoSelectDom = (delito) =>{
    switch (delito) {
        case 'ROBO A TRANSPORTE PÚBLICO':
            document.getElementById('div_ruta_1').style.display = 'block'
            document.getElementById('div_unidad_1').style.display = 'block'
            document.getElementById('div_negocio_1').style.display = 'none'
            break;

        case 'ROBO A COMERCIO':
            document.getElementById('div_negocio_1').style.display = 'block'
            document.getElementById('div_ruta_1').style.display = 'none'
            document.getElementById('div_unidad_1').style.display = 'none'

            break;

        default:
            document.getElementById('div_negocio_1').style.display = 'none'
            document.getElementById('div_ruta_1').style.display = 'none'
            document.getElementById('div_unidad_1').style.display = 'none'
            break;
    }
}


function getUbicacionH() {
    var no_ficha = document.getElementById('no_ficha_ubicacionHechos')
    var no_remision = document.getElementById('no_remision_ubicacionHechos')


    var myFormData = new FormData()
    myFormData.append('no_ficha', no_ficha.value)
    myFormData.append('no_remision', no_remision.value)

    fetch(base_url + 'getUbicacionH', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {

        const { ubicacion_h, faltas_delitos, remisiones_ficha } = data
        //console.log(ubicacion_h);

        if (data) {
            //console.log(data)
            getVector(document.getElementById('zona').value, ubicacion_h.Vector)
            Colonia_hechos.value = ubicacion_h.Colonia
            Calle_hechos.value = ubicacion_h.Calle_1
            Calle2_hechos.value = ubicacion_h.Calle_2
            noInterior_hechos.value = ubicacion_h.No_Int
            noExterior_hechos.value = ubicacion_h.No_Ext
            cordY_hechos.value = ubicacion_h.Coordenada_Y
            cordX_hechos.value = ubicacion_h.Coordenada_X
            //ZonaUH.value = ubicacion_h.Zona

            VectorUH.value = ubicacion_h.Vector


            CP_hechos.value = ubicacion_h.CP
            Fraccionamiento_hechos.value = ubicacion_h.Fraccionamiento
            /*if(ubicacion_h.Coordenada_Y != "" && ubicacion_h.Coordenada_X != ""){
                hechos['porCoordenada'].style.display = 'block';
                hechos['searchCoordenadaY'].value = ubicacion_h.Coordenada_Y;
                hechos['searchCoordenadaX'].value = ubicacion_h.Coordenada_X;
            }*/

            hora_hechos.value = (ubicacion_h.Hora_Reporte != null) ? ubicacion_h.Hora_Reporte.substring(0, 5) : ''
            participantes_hechos.value = remisiones_ficha.length
            RemitidoPor_hechos.value = ubicacion_h.Remitido_Por

            Falta_Delito_Tipo1.checked = (ubicacion_h.Falta_Delito_Tipo == 'F') ? true : false
            Falta_Delito_Tipo2.checked = (ubicacion_h.Falta_Delito_Tipo == 'D') ? true : false

            for (let i = 0; i < faltas_delitos.length; i++) {

                let formData = {
                    delito_1: faltas_delitos[i].Descripcion.toUpperCase(),
                    ruta: (faltas_delitos[i].Ruta_Afectada != null) ? faltas_delitos[i].Ruta_Afectada.toUpperCase() : '',
                    unidad: (faltas_delitos[i].Unidad_Ruta_Afectada != null) ? faltas_delitos[i].Unidad_Ruta_Afectada.toUpperCase() : '',
                    negocio: (faltas_delitos[i].Negocio_Afectado != null) ? faltas_delitos[i].Negocio_Afectado.toUpperCase() : ''
                };

                insertNewRowFaltaDelito(formData);
            }
            Id_Ubicacion_H = ubicacion_h.Id_Ubicacion
        }
    })
}
/*Esta funcion sera para manejar la validacion de todas las colonias en donde haya mapas en remision
siguiendo esto num, indica de que pestaña vienen, en el siguiente orden:
1  ubicacion de los hechos, 2 para principales, 3 para peticionario, 4 para lugar de la detencion */
const validateColonia = async (colonia_buscar,num,domicilio_en)=> {
    coloniaValida=""
    if(colonia_buscar.length > 0){
        if(domicilio_en==="FORANEO")
            coloniaValida=""
        else{
            coloniasCatalogo = await getAllColonias();
            let inputColoniaValue = createObjectColonia (colonia_buscar);
            const result = coloniasCatalogo.find( colonia => (colonia.Tipo == inputColoniaValue.Tipo && colonia.Colonia == inputColoniaValue.Colonia) ) // SI ESTO ME REGRESA EL MISMO OBJETO QUIERE DECIR QUE SI LO ENCONTRO EN EL CATALOGO UNDEFINED SI NO
            if (result){
                coloniaValida = true
            }
            if(coloniaValida==false)
                coloniaValida="Ingrese una colonia valida"
            else
                coloniaValida=""
        }
    }
    else{
        if(num==1 || num==4)
            coloniaValida="Campo requerido"
    }
    return coloniaValida;
}

const getAllColonias = async () => {
    try {
        const response = await fetch(base_url_js + 'Catalogos/getColonias', {
            method: 'POST'
        });
        const data = await response.json();
        return data;
        
    } catch (error) {
        console.log(error);
    }
} 
const createObjectColonia = (colonia) => {
    separado = colonia.split(' ');
    objetoColonia = {
        Tipo: '',
        Colonia: ''
    }
    if(separado){
        objetoColonia.Tipo = separado[0];
        for(let i = 1; i<separado.length; i++){
            objetoColonia.Colonia += separado[i]+' ';
        }
    }
    objetoColonia.Colonia = objetoColonia.Colonia.trim();
    return objetoColonia
}
/*Esta funcion sera para manejar la validacion de todas las calles en donde haya mapas en remision
siguiendo esto, num indica de que pestaña vienen, en el siguiente orden:
1 y 2 para calles de hechos, 3 para principales, 4 para peticionario, 5 y 6 para lugar de la detencion */
const validateCalle = async (calle_buscar,num,domicilio_en)=> {
    var calleValida = "";
    if(calle_buscar.length > 0){
        if(domicilio_en==="FORANEO")
            coloniaValida=""
        else{
            callesCatalogo = await getAllCalles();
            const result = callesCatalogo.find(element => element.Calle == calle_buscar);
            if (result){
                calleValida = true
            }
            if(calleValida==false)
                calleValida="Ingrese una calle valida"
            else
                calleValida=""
        }
    }
    else{
        if(num==1 || num==5 )
            calleValida="Campo requerido"
    }
    return calleValida;
}
const getAllCalles = async () => {
    try {
        const response = await fetch(base_url_js + 'Catalogos/getAllCalles', {
            method: 'POST'
        });
        const data = await response.json();
        return data;
        
    } catch (error) {
        console.log(error);
    }
}