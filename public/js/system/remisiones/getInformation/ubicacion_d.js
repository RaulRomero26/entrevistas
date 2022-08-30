var ubicacionDData = document.getElementById('datos_ubicacionD')

var ubicacionD_fechaError = document.getElementById('fecha_detencion_error')
var ubicacionD_ColoniaError = document.getElementById('Colonia_detencion_error')
var ubicacionD_CalleError = document.getElementById('Calle_1_detencion_error')
var ubicacionD_Calle2Error = document.getElementById('Calle_2_detencion_error')
var ubicacionD_CoordYError = document.getElementById('cordY_detencion_error')
var ubicacionD_CoordXError = document.getElementById('cordX_detencion_error')
var ubicacionD_CPError = document.getElementById('CP_detencion_error')
var ubicacionD_HoraError = document.getElementById('hora_detencion_error')
var ubicacionD_ObservacionesError = document.getElementById('observaciones_detencion_error')



var Colonia_detencion = document.getElementById('Colonia_detencion')
var Calle_1_detencion = document.getElementById('Calle_1_detencion')
var Calle_2_detencion = document.getElementById('Calle_2_detencion')
var noInterior_detencion = document.getElementById('noInterior_detencion')
var noExterior_detencion = document.getElementById('noExterior_detencion')
var cordY_detencion = document.getElementById('cordY_detencion')
var cordX_detencion = document.getElementById('cordX_detencion')
var zona =  document.getElementById('ZonaUD')
var CP_detencion = document.getElementById('CP_detencion')
var Fraccionamiento_detencion = document.getElementById('Fraccionamiento_detencion')

var tipoViolencia = document.getElementById('tipoViolencia')
var formaDetencion = document.getElementById('modalidadDetencion')
var observaciones_detencion = document.getElementById('observaciones_detencion')

var fecha_detencion = document.getElementById('fecha_detencion')
var hora_detencion = document.getElementById('hora_detencion')
/* Se comentan estas lineas ya que los vehiculos recuperados no deben mostrarse en la ubicacion
del detenido, sino en objetos recuperados
let Tipo_Vehiculo = document.getElementById('Tipo_Vehiculo')
let Placa_Vehiculo = document.getElementById('Placa_Vehiculo')
let Marca = document.getElementById('Marca')
let Modelo = document.getElementById('Modelo')
let Color = document.getElementById('Color')
let Senia_Particular = document.getElementById('Senia_Particular')
let No_Serie = document.getElementById('No_Serie')
let Procedencia_Vehiculo = document.getElementById('Procedencia_Vehiculo')
let Observacion_Vehiculo = document.getElementById('Observacion_Vehiculo')
*/
var domicilio_puebla_detencion = document.getElementById('domicilio_puebla_detencion')
var domicilio_foraneo_detencion = document.getElementById('domicilio_foraneo_detencion')
var Id_Ubicacion_D;

var msg_detencionError = document.getElementById('msg_detencion')







async function ValidarUbicacionD() {

    const button = document.getElementById('btn_ubicacionD');

    var myFormData = new FormData(ubicacionDData)
    var band = []
    var FV = new FormValidator()
    var i = 0
    band[i++] = ubicacionD_fechaError.innerText = FV.validate(myFormData.get('fecha_detencion'), 'required | date')
    if(document.getElementById('domicilio_puebla_detencion').checked){
        band[i++] = ubicacionD_ColoniaError.innerText = await validateColonia(Colonia_detencion.value,4,"")
        band[i++] = ubicacionD_CalleError.innerText = await validateCalle(Calle_1_detencion.value,5,myFormData.get('busqueda_puebla_detencion'))
        band[i++] = ubicacionD_Calle2Error.innerText = await validateCalle(Calle_2_detencion.value,6,myFormData.get('busqueda_puebla_detencion'))
    }
    else{
        band[i++] = ubicacionD_ColoniaError.innerText = FV.validate(myFormData.get('Colonia_detencion'), 'required')
        band[i++] = ubicacionD_CalleError.innerText = FV.validate(myFormData.get('Calle_1_detencion'), 'required')
        band[i++] = ubicacionD_Calle2Error.innerText = FV.validate(myFormData.get('Calle_2_detencion'), 'required')
    }
    band[i++] = ubicacionD_CoordYError.innerText = FV.validate(myFormData.get('cordY_detencion'), 'required')
    band[i++] = ubicacionD_CoordXError.innerText = FV.validate(myFormData.get('cordX_detencion'), 'required')




    if (myFormData.get('CP_detencion') != '')
        band[i++] = ubicacionD_CPError.innerText = FV.validate(myFormData.get('CP_detencion'), 'numeric | length[5]')

    band[i++] = ubicacionD_HoraError.innerText = FV.validate(myFormData.get('hora_detencion'), 'required | time')

    if (myFormData.get('observaciones_detencion') != '')
        band[i++] = ubicacionD_ObservacionesError.innerText = FV.validate(myFormData.get('observaciones_detencion'), 'max_length[600]')


    //se comprueban todas las validaciones
    var success = true
    band.forEach(element => {
        success &= (element == '') ? true : false
    })

    const result = await getTabValidado(6);
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

        myFormData.append('boton_ubicacionDetencion', document.getElementById('btn_ubicacionD').value)
        myFormData.append('Id_Ubicacion', Id_Ubicacion_D)



        fetch(base_url + 'ModificarUbicacionD', {
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

                ubicacionD_fechaError.innerText = (data.ubicacionD_fechaError === undefined) ? '' : data.ubicacionD_fechaError
                ubicacionD_ColoniaError.innerText = (data.ubicacionD_ColoniaError === undefined) ? '' : data.ubicacionD_ColoniaError
                ubicacionD_CalleError.innerText = (data.ubicacionD_CalleError === undefined) ? '' : data.ubicacionD_CalleError
                ubicacionD_CoordYError.innerText = (data.ubicacionD_CoordYError === undefined) ? '' : data.ubicacionD_CoordYError
                ubicacionD_CoordXError.innerText = (data.ubicacionD_CoordXError === undefined) ? '' : data.ubicacionD_CoordXError
                ubicacionD_CPError.innerText = (data.ubicacionD_CPError === undefined) ? '' : data.ubicacionD_CPError
                ubicacionD_HoraError.innerText = (data.ubicacionD_HoraError === undefined) ? '' : data.ubicacionD_HoraError
                ubicacionD_ObservacionesError.innerText = (data.ubicacionD_ObservacionesError === undefined) ? '' : data.ubicacionD_ObservacionesError
                /* Se comentan estas lineas ya que los vehiculos recuperados no deben mostrarse en la ubicacion
                del detenido, sino en objetos recuperados
                Tipo_Vehiculo_error.innerText = (data.Tipo_Vehiculo_error === undefined) ? '' : data.Tipo_Vehiculo_error
                Placa_Vehiculo_error.innerText = (data.Placa_Vehiculo_error === undefined) ? '' : data.Placa_Vehiculo_error
                Marca_error.innerText = (data.Marca_error === undefined) ? '' : data.Marca_error
                Modelo_error.innerText = (data.Modelo_error === undefined) ? '' : data.Modelo_error
                Color_error.innerText = (data.Color_error === undefined) ? '' : data.Color_error
                Senia_Particular_error.innerText = (data.Senia_Particular_error === undefined) ? '' : data.Senia_Particular_error
                No_Serie_error.innerText = (data.No_Serie_error === undefined) ? '' : data.No_Serie_error
                Procedencia_Vehiculo_error.innerText = (data.Procedencia_Vehiculo_error === undefined) ? '' : data.Procedencia_Vehiculo_error
                Observacion_Vehiculo_error.innerText = (data.Observacion_Vehiculo_error === undefined) ? '' : data.Observacion_Vehiculo_error
                */
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

                msg_detencionError.innerHTML = messageError
                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });

            } else {
                ubicacionD_fechaError.innerText = ''
                ubicacionD_ColoniaError.innerText = ''
                ubicacionD_CalleError.innerText = ''
                ubicacionD_CoordYError.innerText = ''
                ubicacionD_CoordXError.innerText = ''
                ubicacionD_CPError.innerText = ''
                ubicacionD_HoraError.innerText = ''
                ubicacionD_ObservacionesError.innerText = ''

                /* 
                Se comentan estas lineas ya que los vehiculos recuperados no deben mostrarse en la ubicacion
                del detenido, sino en objetos recuperados
                Tipo_Vehiculo_error.innerText = ''
                Placa_Vehiculo_error.innerText = ''
                Marca_error.innerText = ''
                Modelo_error.innerText = ''
                Color_error.innerText = ''
                Senia_Particular_error.innerText = ''
                No_Serie_error.innerText = ''
                Procedencia_Vehiculo_error.innerText = ''
                Observacion_Vehiculo_error.innerText = ''*/

                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });

                msg_detencionError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información almacenada correctamente.</div>';
                getTabsGuardados();
            }
        })
    } else { //si no, se muestran errores en pantalla

        msg_detencionError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>'
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });
    }

    for (var pair of myFormData.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
    }
}

function getUbicaciond() {
    var no_remision = document.getElementById('no_remision_detencion')


    var myFormData = new FormData()
    myFormData.append('no_remision', no_remision.value)

    fetch(base_url + 'getUbicacionD', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {
        //console.log(data)

        if (data) {
            console.log(data)

            
            if (data.ubicacionD.length > 0) {
                Colonia_detencion.value = data.ubicacionD[0].Colonia
                Calle_1_detencion.value = data.ubicacionD[0].Calle_1
                Calle_2_detencion.value = data.ubicacionD[0].Calle_2
                noInterior_detencion.value = data.ubicacionD[0].No_Int
                noExterior_detencion.value = data.ubicacionD[0].No_Ext
                cordY_detencion.value = data.ubicacionD[0].Coordenada_Y
                cordX_detencion.value = data.ubicacionD[0].Coordenada_X
                zona.value = data.ubicacionD[0].Zona
                CP_detencion.value = data.ubicacionD[0].CP
                Fraccionamiento_detencion.value = data.ubicacionD[0].Fraccionamiento
                Id_Ubicacion_D = data.ubicacionD[0].Id_Ubicacion
                tipoViolencia.value = data.ubicacionD[0].Tipo_Violencia
                formaDetencion.value = data.ubicacionD[0].Forma_Detencion;
                caseModalidadDetencion(data.ubicacionD[0].Forma_Detencion, data.ubicacionD[0].Descripcion_Forma_Detencion);
                observaciones_detencion.textContent = data.ubicacionD[0].Observaciones
                var auxDateTime = splitDateTime(data.ubicacionD[0].Fecha_Hora_Detencion);
                fecha_detencion.value = auxDateTime[0]
                hora_detencion.value = auxDateTime[1].substring(0, 5)
               /*  detencion['porCoordenada'].style.display = 'block';
                detencion['searchCoordenadaY'].value = data.ubicacionD[0].Coordenada_Y;
                detencion['searchCoordenadaX'].value = data.ubicacionD[0].Coordenada_X;*/
                if(data.ubicacionD[0].Detencion_en=="PUEBLA")
                    domicilio_puebla_detencion.checked=true
                else
                    domicilio_foraneo_detencion.checked=true
            }
        }
    })
}

formaDetencion.addEventListener('change', (e) => {

    const value = e.target.value;

    caseModalidadDetencion(value);

})

const caseModalidadDetencion = (value, selected) => {
    // console.log(value + " ---- " + selected);

    let myFormData = new FormData(),
        selects = '';

    myFormData.append('modalidad', value);

    const label = document.getElementById('modalidadLabelDetencion'),
        select = document.getElementById('modalidadSelectDetencion');

    fetch(base_url + 'getModalidadDetencion', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())
        .then(data => {

            switch (value) {
                case 'OPERATIVO':
                    label.innerHTML = 'Operativos';
                    for (const desc in data) {
                        selects += `<option value="${data[desc].Descripcion}">${data[desc].Descripcion}</option>`;
                    }
                    select.innerHTML = selects;
                    if (selected != undefined)
                        select.value = selected;
                    break;
                case 'DISPOSITIVO':
                    label.innerHTML = 'Dispositivos';
                    for (const desc in data) {
                        selects += `<option value="${data[desc].Descripcion}">${data[desc].Descripcion}</option>`;
                    }
                    select.innerHTML = selects;
                    if (selected != undefined)
                        select.value = selected;
                    break;
                case 'AUXILIO':
                    label.innerHTML = 'Auxilios';
                    for (const desc in data) {
                        selects += `<option value="${data[desc].Descripcion}">${data[desc].Descripcion}</option>`;
                    }
                    select.innerHTML = selects;
                    if (selected != undefined)
                        select.value = selected;
                    break;
                /*Se añade la opcion para sobre recorrido*/
                case 'SOBRE RECORRIDO':
                    label.innerHTML = ' ';
                    selects += `<option value="NA" selected>N/A</option>`;
                    select.innerHTML = selects;
                    break;
            }
        })


}

caseModalidadDetencion('OPERATIVO')