var peticionarioData = document.getElementById('datos_peticionario')
var peticionario_nombreError = document.getElementById('peticionario_Nombres_error')
var peticionario_apaternoError = document.getElementById('peticionario_appPaterno_error')
var peticionario_amaternoError = document.getElementById('peticionario_appMaterno_error')
var peticionario_edadError = document.getElementById('peticionario_Edad_error')
var peticionario_procedenciaError = document.getElementById('peticionario_Procedencia_error')
var peticionario_fechanError = document.getElementById('peticionario_Fecha_n_error')
var peticionario_coloniaError = document.getElementById('Colonia_peticionario_error')
var peticionario_calleError = document.getElementById('Calle_peticionario_error')
var peticionario_cordYError = document.getElementById('cordY_peticionario_error')
var peticionario_cordXError = document.getElementById('cordX_peticionario_error')
var peticionario_CPError = document.getElementById('CP_peticionario_error')
var peticionario_estadoError = document.getElementById('Estado_peticionario_error')
var peticionario_municipioError = document.getElementById('Municipio_peticionario_error')


var msg_peticionarioError = document.getElementById('msg_peticionario')

var nombre_peticionario = document.getElementById('peticionario_Nombres')
var aPaterno_peticionario = document.getElementById('peticionario_appPaterno')
var aMaterno_peticionario = document.getElementById('peticionario_appMaterno')
var edad_peticionario = document.getElementById('peticionario_Edad')
var sexo_peticionario = document.getElementById('peticionario_Sexo')
var escolaridad_peticionario = document.getElementById('peticionario_Escolaridad')
var procedencia_peticionario = document.getElementById('peticionario_Procedencia')
var fechaN_peticionario = document.getElementById('peticionario_Fecha_n')

var Colonia_peticionario = document.getElementById('Colonia_peticionario')
var Calle_peticionario = document.getElementById('Calle_peticionario')
var noInterior_peticionario = document.getElementById('noInterior_peticionario')
var noExterior_peticionario = document.getElementById('noExterior_peticionario')
var cordY_peticionario = document.getElementById('cordY_peticionario')
var cordX_peticionario = document.getElementById('cordX_peticionario')
var Municipio_peticionario = document.getElementById('Municipio_peticionario')
var CP_peticionario = document.getElementById('CP_peticionario')
var nacionalidad_mexicana_pet = document.getElementById('nacionalidad_mexicana_pet')
var nacionalidad_extranjera_pet = document.getElementById('nacionalidad_extranjera_pet')
var procedencia_estado_principales_pet = document.getElementById('procedencia_estado_pet')
var domicilio_puebla_pet = document.getElementById('domicilio_puebla_peticionario')
var domicilio_foraneo_pet = document.getElementById('domicilio_foraneo_peticionario')
// console.log(document.getElementById('btn_peticionario'))

var Id_Domicilio_Peticionario;

document.getElementById('btn_peticionario').addEventListener('click', async function(e) {
    e.preventDefault();

    const button = document.getElementById('btn_peticionario');

    var myFormData = new FormData(peticionarioData)
    var band = []
    var FV = new FormValidator()
    var i = 0

    // band[i++] = peticionario_nombreError.innerText = FV.validate(myFormData.get('peticionario_Nombres'), 'required')
    // band[i++] = peticionario_apaternoError.innerText = FV.validate(myFormData.get('peticionario_appPaterno'), 'required')

    if (myFormData.get('peticionario_Edad') != '')
        band[i++] = peticionario_edadError.innerText = FV.validate(myFormData.get('peticionario_Edad'), 'numeric | length[2]')

    // band[i++] = peticionario_procedenciaError.innerText = FV.validate(myFormData.get('peticionario_Procedencia'), 'required')

    if (myFormData.get('peticionario_Fecha_n') != '')
        band[i++] = peticionario_fechanError.innerText = FV.validate(myFormData.get('peticionario_Fecha_n'), 'date')

    const municipio = myFormData.get('Municipio_peticionario') == '' ? 'PUEBLA' : myFormData.get('Municipio_peticionario');
    myFormData.set('Municipio_peticionario', municipio)

    if(nacionalidad_mexicana_pet.checked)
        band[i++] = peticionario_procedenciaError.innerText = await validarMunicipioPE()

    if (myFormData.get('CP_peticionario') != '')
        band[i++] = peticionario_CPError.innerText = FV.validate(myFormData.get('CP_peticionario'), 'numeric | length[5]')

        band[i++] = peticionario_coloniaError.innerText = await validateColonia(Colonia_peticionario.value,3,myFormData.get('busqueda_puebla_peticionario'))
        band[i++] = peticionario_calleError.innerText = await validateCalle(myFormData.get("Calle_peticionario"),4,myFormData.get('busqueda_puebla_peticionario'))
    //se comprueban todas las validaciones
    var success = true
    band.forEach(element => {
        success &= (element == '') ? true : false
    })

    const result = await getTabValidado(1);
    if (!result) {
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


        myFormData.append('boton_peticionario', document.getElementById('btn_peticionario').value)
        myFormData.append('Id_Domicilio', Id_Domicilio_Peticionario)


        fetch(base_url + 'ModificarPeticionario', {
            method: 'POST',
            body: myFormData
        })

        .then(res => res.json())

        .then(data => {

            // console.log(data)
            button.innerHTML = `
                Guardar
            `;
            button.classList.remove('disabled-link');
            if (!data.status) {
                console.log(data)
                peticionario_nombreError.innerText = (data.peticionario_nombreError === undefined) ? '' : data.peticionario_nombreError
                peticionario_apaternoError.innerText = (data.peticionario_apaternoError === undefined) ? '' : data.peticionario_apaternoError
                peticionario_amaternoError.innerTex = (data.peticionario_amaternoError === undefined) ? '' : data.peticionario_amaternoError
                peticionario_edadError.innerText = (data.peticionario_edadError === undefined) ? '' : data.peticionario_edadError
                peticionario_procedenciaError.innerText = (data.peticionario_procedenciaError === undefined) ? '' : data.peticionario_procedenciaError
                peticionario_fechanError.innerText = (data.peticionario_fechanError === undefined) ? '' : data.peticionario_fechanError
                peticionario_coloniaError.innerText = (data.peticionario_coloniaError === undefined) ? '' : data.peticionario_coloniaError
                peticionario_calleError.innerText = (data.peticionario_calleError === undefined) ? '' : data.peticionario_calleError
                peticionario_cordYError.innerText = (data.peticionario_cordYError === undefined) ? '' : data.peticionario_cordYError
                peticionario_cordXError.innerText = (data.peticionario_cordXError === undefined) ? '' : data.peticionario_cordXError
                peticionario_municipioError.innerText = (data.peticionario_municipioError === undefined) ? '' : data.peticionario_municipioError
                peticionario_CPError.innerText = (data.peticionario_CPError === undefined) ? '' : data.peticionario_CPError

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

                msg_peticionarioError.innerHTML = messageError
                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });


            } else {
                peticionario_nombreError.innerTex = ''
                peticionario_apaternoError.innerText = ''
                peticionario_amaternoError.innerTex = ''
                peticionario_edadError.innerText = ''
                peticionario_procedenciaError.innerText = ''
                peticionario_fechanError.innerText = ''
                peticionario_coloniaError.innerText = ''
                peticionario_calleError.innerText = ''
                peticionario_cordYError.innerText = ''
                peticionario_cordXError.innerText = ''
                peticionario_municipioError.innerText = ''
                peticionario_CPError.innerText = ''

                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });

                msg_peticionarioError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información actualizada correctamente.</div>';
                getTabsGuardados();
                // result.tab === '1' ? '' : document.getElementById('save-tab-1').style.display = 'block';
            }
        })
    } else { //si no, se muestran errores en pantalla
        msg_peticionarioError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>'
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


document.getElementById('peticionario_Nombres').addEventListener('input', () => {
    (document.getElementById('peticionario_Nombres').value.length === 0) ? peticionarioData.reset(): ''
    if (document.getElementById('peticionario_Nombres').value.length > 0)
        document.getElementById('mapDivPeticionario').classList.remove('disabled')
    else
        document.getElementById('mapDivPeticionario').classList.add('disabled')
})


function getPeticionario() {
    var no_ficha = document.getElementById('no_ficha_peticionario')


    var myFormData = new FormData()
    myFormData.append('no_ficha', no_ficha.value)

    fetch(base_url + 'getPeticionario', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {
        if (data) {
            nombre_peticionario.value = data.Nombre
            aPaterno_peticionario.value = data.Ap_Paterno
            aMaterno_peticionario.value = data.Ap_Materno
            edad_peticionario.value = data.Edad
            sexo_peticionario.value = data.Genero
            escolaridad_peticionario.value = data.Escolaridad
            procedencia_peticionario.value = data.Lugar_Origen
            fechaN_peticionario.value = data.Fecha_Nacimiento
            if(data.Nombre != '')
                document.getElementById('mapDivPeticionario').classList.remove('disabled')
            Colonia_peticionario.value = data.Colonia
            Calle_peticionario.value = data.Calle
            noInterior_peticionario.value = data.No_Interior
            noExterior_peticionario.value = data.No_Exterior
            cordY_peticionario.value = data.Coordenada_Y
            cordX_peticionario.value = data.Coordenada_X
            Municipio_peticionario.value = data.Municipio
            CP_peticionario.value = data.CP
            /*peticionario['porCoordenada'].style.display = 'block';
            peticionario['searchCoordenadaY'].value = data.Coordenada_Y;
            peticionario['searchCoordenadaX'].value = data.Coordenada_X;*/

            Id_Domicilio_Peticionario = data.Id_Domicilio
            if(data.Nacionalidad=="MEXICANA"){
                nacionalidad_mexicana_pet.checked=true
                procedencia_estado_principales_pet.value=data.EstadoMex_Origen
                document.getElementById('estado_nacimiento_pet').style.display = 'block'
            }   
            else{
                nacionalidad_extranjera_pet.checked=true
                procedencia_estado_principales_pet.value="SD"
                document.getElementById('estado_nacimiento_pet').style.display = 'none'
            }
            if(data.Domicilio_en=="PUEBLA")
                domicilio_puebla_pet.checked=true
            else
                domicilio_foraneo_pet.checked=true
        }
    })
}
/*Funcion añadida para saber si la combinacion de estado-municipio ingresada existe como valida*/
const validarMunicipioPE = async ()=> {
    if((document.getElementById('peticionario_Procedencia').value).length > 0){
        municipioValido = ""
        //Para validadr municipio necesitamos que sea mexicano y que se haya seleccionado un estado
        if(document.getElementById('nacionalidad_mexicana_pet').checked){
            if(document.getElementById('procedencia_estado_pet').value!="SD"){
                myFormData_muni=new FormData()
                myFormData_muni.append('municipio', document.getElementById('peticionario_Procedencia').value)
                myFormData_muni.append('estado', document.getElementById('procedencia_estado_pet').value)
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