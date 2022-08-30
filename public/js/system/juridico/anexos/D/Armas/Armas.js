let Ubicacion_Arma = document.getElementById('Ubicacion_Arma')
let Calibre = document.getElementById('Calibre')
let Color = document.getElementById('Color')
let Matricula = document.getElementById('Matricula')
let Num_Serie = document.getElementById('Num_Serie')
let Observaciones = document.getElementById('Observaciones')
let Destino = document.getElementById('Destino')
let Nombre_A = document.getElementById('Nombre_A')
let Ap_Paterno_A = document.getElementById('Ap_Paterno_A')
let Ap_Materno_A = document.getElementById('Ap_Materno_A')
    //--------------------Testigos-----------------------------
let Nombre_TA_0 = document.getElementById('Nombre_TA_0')
let Ap_Paterno_TA_0 = document.getElementById('Ap_Paterno_TA_0')
let Ap_Materno_TA_0 = document.getElementById('Ap_Materno_TA_0')
let Nombre_TA_1 = document.getElementById('Nombre_TA_1')
let Ap_Paterno_TA_1 = document.getElementById('Ap_Paterno_TA_1')
    //--------------------Primer respondiente-----------------------------
let Nombre_PRA = document.getElementById('Nombre_PRA')
let Ap_Paterno_PRA = document.getElementById('Ap_Paterno_PRA')
let Ap_Materno_PRA = document.getElementById('Ap_Materno_PRA')
let InstitucionA = document.getElementById('InstitucionA')
let CargoA = document.getElementById('CargoA')


let Ubicacion_Arma_Error = document.getElementById('Ubicacion_Arma_error')
let Calibre_Error = document.getElementById('Calibre_error')
let Color_Error = document.getElementById('Color_error')
let Matricula_Error = document.getElementById('Matricula_error')
let Num_Serie_Error = document.getElementById('Num_Serie_error')
let Observaciones_Error = document.getElementById('Observaciones_error')
let Destino_Error = document.getElementById('Destino_error')
let Nombre_A_Error = document.getElementById('Nombre_A_error')
let Ap_Paterno_A_Error = document.getElementById('Ap_Paterno_A_error')
let Ap_Materno_A_Error = document.getElementById('Ap_Materno_A_error')
    //--------------------Testigos-----------------------------
let Nombre_TA_0_Error = document.getElementById('Nombre_TA_0_error')
let Ap_Paterno_TA_0_Error = document.getElementById('Ap_Paterno_TA_0_error')
let Ap_Materno_TA_0_Error = document.getElementById('Ap_Materno_TA_0_error')
let Nombre_TA_1_Error = document.getElementById('Nombre_TA_1_error')
let Ap_Paterno_TA_1_Error = document.getElementById('Ap_Paterno_TA_1_error')
let Ap_Materno_TA_1_Error = document.getElementById('Ap_Materno_TA_1_error')
    //--------------------Primer respondiente-----------------------------
let Nombre_PRA_Error = document.getElementById('Nombre_PRA_error')
let Ap_Paterno_PRA_Error = document.getElementById('Ap_Paterno_PRA_error')
let Ap_Materno_PRA_Error = document.getElementById('Ap_Materno_PRA_error')
let InstitucionA_Error = document.getElementById('InstitucionA_error')
let CargoA_Error = document.getElementById('CargoA_error')


const button = document.getElementById('btnAnexoDArmas');
let data = document.getElementById('formAnexoCArmas')
const msg_anexoDArmasError = document.getElementById('msg_anexoDArmasError')


const sendForm = (event) => {
    //console.log(event.target.getAttribute('data-id'))
    // button.addEventListener('click', (e) => {
    //preventDefault()

    let myFormData = new FormData(data);
    let band = []
    let FV = new FormValidator()
    let i = 0;

    band[i++] = Ubicacion_Arma_Error.innerText = FV.validate(myFormData.get('Ubicacion_Arma'), 'required | max_length[1000]')
    band[i++] = Calibre_Error.innerText = FV.validate(myFormData.get('Calibre'), 'required | max_length[45]')
    band[i++] = Color_Error.innerText = FV.validate(myFormData.get('Color'), 'required | max_length[45]')
    band[i++] = Matricula_Error.innerText = FV.validate(myFormData.get('Matricula'), 'max_length[45]')
    band[i++] = Num_Serie_Error.innerText = FV.validate(myFormData.get('Num_Serie'), 'max_length[45]')
    band[i++] = Observaciones_Error.innerText = FV.validate(myFormData.get('Observaciones'), 'required | max_length[10000]')
    band[i++] = Destino_Error.innerText = FV.validate(myFormData.get('Destino'), 'required | max_length[250]')
    band[i++] = Nombre_A_Error.innerText = FV.validate(myFormData.get('Nombre_A'), 'max_length[100]')
    band[i++] = Ap_Paterno_A_Error.innerText = FV.validate(myFormData.get('Ap_Paterno_A'), 'max_length[250]')
    band[i++] = Ap_Materno_A_Error.innerText = FV.validate(myFormData.get('Ap_Materno_A'), 'max_length[250]')

    if (myFormData.get('testigos') === 'Si') {
        band[i++] = Nombre_TA_0_Error.innerText = FV.validate(myFormData.get('Nombre_TA_0'), 'required | max_length[250]')
        band[i++] = Ap_Paterno_TA_0_Error.innerText = FV.validate(myFormData.get('Ap_Paterno_TA_0'), 'required | max_length[250]')
        band[i++] = Ap_Materno_TA_0_Error.innerText = FV.validate(myFormData.get('Ap_Materno_TA_0'), 'required | max_length[250]')
        band[i++] = Nombre_TA_1_Error.innerText = FV.validate(myFormData.get('Nombre_TA_1'), 'max_length[250]')
        band[i++] = Ap_Paterno_TA_1_Error.innerText = FV.validate(myFormData.get('Ap_Paterno_TA_1'), 'max_length[250]')
        band[i++] = Ap_Materno_TA_1_Error.innerText = FV.validate(myFormData.get('Ap_Materno_TA_1'), 'max_length[250]')
    }

    if (myFormData.get('arma') === 'No') {
        band[i++] = Nombre_PRA_Error.innerText = FV.validate(myFormData.get('Nombre_PRA'), 'required | max_length[250]')
        band[i++] = Ap_Paterno_PRA_Error.innerText = FV.validate(myFormData.get('Ap_Paterno_PRA'), 'required | max_length[250]')
        band[i++] = Ap_Materno_PRA_Error.innerText = FV.validate(myFormData.get('Ap_Materno_PRA'), 'required | max_length[250]')
        band[i++] = InstitucionA_Error.innerText = FV.validate(myFormData.get('InstitucionA'), 'required | max_length[250]')
        band[i++] = CargoA_Error.innerText = FV.validate(myFormData.get('CargoA'), 'required | max_length[250]')
    }


    let success = true
    band.forEach(element => {
        success &= (element == '') ? true : false
    })

    if (success) { //si todo es correcto se envía form
        button.innerHTML = `
            Guardando
            <div class="spinner-grow spinner-grow-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        `;
        button.classList.add('disabled-link');
        myFormData.append('btn_anexoDArmas', button.value)

        let URL_FETCH = (event.target.getAttribute('data-id') === 'insertar') ? 'insertarAnexoD' : 'actualizarAnexoD'



        fetch(base_url_js + 'Juridico/' + URL_FETCH, {
            method: 'POST',
            body: myFormData
        })

        .then(res => res.json())

        .then(data => {
            button.innerHTML = `
                Guardar
            `;
            button.classList.remove('disabled-link');

            // console.log(data)
            if (!data.status) {

                Ubicacion_Arma_Error.innerText = (data.Ubicacion_Arma_Error === undefined) ? '' : data.Ubicacion_Arma_Error
                Calibre_Error.innerText = (data.Calibre_Error === undefined) ? '' : data.Calibre_Error
                Color_Error.innerText = (data.Color_Error === undefined) ? '' : data.Color_Error
                Matricula_Error.innerText = (data.Matricula_Error === undefined) ? '' : data.Matricula_Error
                Num_Serie_Error.innerText = (data.Num_Serie_Error === undefined) ? '' : data.Num_Serie_Error
                Observaciones_Error.innerText = (data.Observaciones_Error === undefined) ? '' : data.Observaciones_Error
                Destino_Error.innerText = (data.Destino_Error === undefined) ? '' : data.Destino_Error
                Nombre_A_Error.innerText = (data.Nombre_A_Error === undefined) ? '' : data.Nombre_A_Error
                Ap_Paterno_A_Error.innerText = (data.Ap_Paterno_A_Error === undefined) ? '' : data.Ap_Paterno_A_Error
                Ap_Materno_A_Error.innerText = (data.Ap_Materno_A_Error === undefined) ? '' : data.Ap_Materno_A_Error

                Nombre_TA_0_Error.innerText = (data.Nombre_TA_0_Error === undefined) ? '' : data.Nombre_TA_0_Error
                Ap_Paterno_TA_0_Error.innerText = (data.Ap_Paterno_TA_0_Error === undefined) ? '' : data.Ap_Paterno_TA_0_Error
                Ap_Materno_TA_0_Error.innerText = (data.Ap_Materno_TA_0_Error === undefined) ? '' : data.Ap_Materno_TA_0_Error
                Nombre_TA_1_Error.innerText = (data.Nombre_TA_1_Error === undefined) ? '' : data.Nombre_TA_1_Error
                Ap_Paterno_TA_1_Error.innerText = (data.Ap_Paterno_TA_1_Error === undefined) ? '' : data.Ap_Paterno_TA_1_Error
                Ap_Materno_TA_1_Error.innerText = (data.Ap_Materno_TA_1_Error === undefined) ? '' : data.Ap_Materno_TA_1_Error
                Nombre_PRA_Error.innerText = (data.Nombre_PRA_Error === undefined) ? '' : data.Nombre_PRA_Error
                Ap_Paterno_PRA_Error.innerText = (data.Ap_Paterno_PRA_Error === undefined) ? '' : data.Ap_Paterno_PRA_Error
                Ap_Materno_PRA_Error.innerText = (data.Ap_Materno_PRA_Error === undefined) ? '' : data.Ap_Materno_PRA_Error
                InstitucionA_Error.innerText = (data.InstitucionA_Error === undefined) ? '' : data.InstitucionA_Error
                CargoA_Error.innerText = (data.CargoA_Error === undefined) ? '' : data.CargoA_Error

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

                msg_anexoDArmasError.innerHTML = messageError
                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });


            } else {

                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });

                msg_anexoDArmasError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información actualizada con éxito</div>';

                if (myFormData.get('Id_Inventario_Arma') == -1) {
                    alerta(myFormData.get('Id_Puesta'))
                    setInterval(() => {
                        msg_anexoDArmasError.innerHTML = '';
                    }, 2000);
                } else {
                    setInterval(() => {
                        window.location = base_url_js + "Juridico/Puesta/" + myFormData.get('Id_Puesta') + '/ver';
                    }, 3500);

                }




                // result.tab === '1' ? '' : document.getElementById('save-tab-0').style.display = 'block';
            }
        })
    } else { //si no, se muestran errores en pantalla
        msg_anexoDArmasError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>'
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

const buttonSearch = document.getElementById('button_search'),
    elementSearch = document.getElementById('element_search'),
    listElementsSearch = document.getElementById('list_elements_search'),
    inputsElements = [
        { key: 'nombre', value: 'Nombre_PRA' },
        { key: 'paterno', value: 'Ap_Paterno_PRA' },
        { key: 'materno', value: 'Ap_Materno_PRA' },
        { key: 'cargo', value: 'CargoA' },
        { key: 'adscripcion', value: 'InstitucionA' },
        { key: 'button', value: 'button_search' },
        { key: 'search', value: 'element_search', },
        { key: 'content', value: 'list_elements_search' }
    ];

buttonSearch.addEventListener('click', () => {
    buttonSearch.innerText = `Buscando`;
    buttonSearch.setAttribute('disabled', '');
    getPrimerRespondiente(elementSearch.value, inputsElements);
})

elementSearch.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        e.preventDefault()
        buttonSearch.innerText = `Buscando`;
        buttonSearch.setAttribute('disabled', '');
        getPrimerRespondiente(elementSearch.value, inputsElements);
    }
})