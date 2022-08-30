let otro_objeto = document.getElementById('otro')
let Ubicacion_Objeto = document.getElementById('Ubicacion_Objeto')
let Destino = document.getElementById('Destino')
let Descripcion_Objeto = document.getElementById('Descripcion_Objeto')
let Nombre_A = document.getElementById('Nombre_A')
let Ap_Paterno_A = document.getElementById('Ap_Paterno_A')
let Ap_Materno_A = document.getElementById('Ap_Materno_A')
    //--------------------Testigos-----------------------------
let Nombre_TO_0 = document.getElementById('Nombre_TO_0')
let Ap_Paterno_TO_0 = document.getElementById('Ap_Paterno_TO_0')
let Ap_Materno_TO_0 = document.getElementById('Ap_Materno_TO_0')
let Nombre_TO_1 = document.getElementById('Nombre_TO_1')
let Ap_Paterno_TO_1 = document.getElementById('Ap_Paterno_TO_1')
let Ap_Materno_TO_1 = document.getElementById('Ap_Materno_TO_1')
    //--------------------Primer respondiente-----------------------------
let Nombre_PR = document.getElementById('Nombre_PR')
let Ap_Paterno_PR = document.getElementById('Ap_Paterno_PR')
let Ap_Materno_PR = document.getElementById('Ap_Materno_PR')
let Institucion = document.getElementById('Institucion')
let Cargo = document.getElementById('Cargo')


let otro_objeto_Error = document.getElementById('otro_error')
let Ubicacion_Objeto_Error = document.getElementById('Ubicacion_Objeto_error')
let Destino_Error = document.getElementById('Destino_error')
let Descripcion_Objeto_Error = document.getElementById('Descripcion_Objeto_error')
let Nombre_A_Error = document.getElementById('Nombre_A_error')
let Ap_Paterno_A_Error = document.getElementById('Ap_Paterno_A_error')
let Ap_Materno_A_Error = document.getElementById('Ap_Materno_A_error')
    //--------------------Testigos-----------------------------
let Nombre_TO_0_Error = document.getElementById('Nombre_TO_0_error')
let Ap_Paterno_TO_0_Error = document.getElementById('Ap_Paterno_TO_0_error')
let Ap_Materno_TO_0_Error = document.getElementById('Ap_Materno_TO_0_error')
let Nombre_TO_1_Error = document.getElementById('Nombre_TO_1_error')
let Ap_Paterno_TO_1_Error = document.getElementById('Ap_Paterno_TO_1_error')
let Ap_Materno_TO_1_Error = document.getElementById('Ap_Materno_TO_1_error')
    //--------------------Primer respondiente-----------------------------
let Nombre_PR_Error = document.getElementById('Nombre_PR_error')
let Ap_Paterno_PR_Error = document.getElementById('Ap_Paterno_PR_error')
let Ap_Materno_PR_Error = document.getElementById('Ap_Materno_PR_error')
let Institucion_Error = document.getElementById('Institucion_error')
let Cargo_Error = document.getElementById('Cargo_error')


const button = document.getElementById('btnAnexoDObjetos');
let data = document.getElementById('formAnexoDObjetos')
const msg_anexoDArmasError = document.getElementById('msg_anexoDObjetosError')


const sendForm = (event) => {
    // button.addEventListener('click', (e) => {

    let myFormData = new FormData(data);
    let band = []
    let FV = new FormValidator()
    let i = 0;

    /* band[i++] = Ubicacion_Objeto_Error.innerText = FV.validate(myFormData.get('Ubicacion_Objeto'), 'required | max_length[250]') */
    band[i++] = Destino_Error.innerText = FV.validate(myFormData.get('Destino'), 'required | max_length[250]')
    band[i++] = Descripcion_Objeto_Error.innerText = FV.validate(myFormData.get('Descripcion_Objeto'), 'required | max_length[1000]')
    band[i++] = Nombre_A_Error.innerText = FV.validate(myFormData.get('Nombre_A'), 'max_length[250]')
    band[i++] = Ap_Paterno_A_Error.innerText = FV.validate(myFormData.get('Ap_Paterno_A'), 'max_length[250]')
    band[i++] = Ap_Materno_A_Error.innerText = FV.validate(myFormData.get('Ap_Materno_A'), 'max_length[250]')

    if (myFormData.get('Apariencia') === 'Otro' && myFormData.get('otro') != '')
        band[i++] = otro_objeto_Error.innerText = FV.validate(myFormData.get('otro'), 'required | max_length[450]')

    if (myFormData.get('testigos') === 'Si') {
        band[i++] = Nombre_TO_0_Error.innerText = FV.validate(myFormData.get('Nombre_TO_0'), 'required | max_length[250]')
        band[i++] = Ap_Paterno_TO_0_Error.innerText = FV.validate(myFormData.get('Ap_Paterno_TO_0'), 'required | max_length[250]')
        band[i++] = Ap_Materno_TO_0_Error.innerText = FV.validate(myFormData.get('Ap_Materno_TO_0'), 'required | max_length[250]')
        band[i++] = Nombre_TO_1_Error.innerText = FV.validate(myFormData.get('Nombre_TO_1'), 'max_length[250]')
        band[i++] = Ap_Paterno_TO_1_Error.innerText = FV.validate(myFormData.get('Ap_Paterno_TO_1'), 'max_length[250]')
        band[i++] = Ap_Materno_TO_1_Error.innerText = FV.validate(myFormData.get('Ap_Materno_TO_1'), 'max_length[250]')
    }

    if (myFormData.get('respondiente') === 'No') {
        band[i++] = Nombre_PR_Error.innerText = FV.validate(myFormData.get('Nombre_PR'), 'required | max_length[250]')
        band[i++] = Ap_Paterno_PR_Error.innerText = FV.validate(myFormData.get('Ap_Paterno_PR'), 'required | max_length[250]')
        band[i++] = Ap_Materno_PR_Error.innerText = FV.validate(myFormData.get('Ap_Materno_PR'), 'required | max_length[250]')
        band[i++] = Institucion_Error.innerText = FV.validate(myFormData.get('Institucion'), 'required | max_length[250]')
        band[i++] = Cargo_Error.innerText = FV.validate(myFormData.get('Cargo'), 'required | max_length[250]')
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
        myFormData.append('btn_anexoDObjetos', button.value)

        let URL_FETCH = (event.target.getAttribute('data-id') === 'insertar') ? 'insertarAnexoD' : 'actualizarAnexoD'

        // console.log(URL_FETCH)



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

            console.log(data)
            if (!data.status) {

                Ubicacion_Objeto_Error.innerText = (data.Ubicacion_Objeto_Error === undefined) ? '' : data.Ubicacion_Objeto_Error
                Destino_Error.innerText = (data.Destino_Error === undefined) ? '' : data.Destino_Error
                Descripcion_Objeto_Error.innerText = (data.Descripcion_Objeto_Error === undefined) ? '' : data.Descripcion_Objeto_Error
                Nombre_A_Error.innerText = (data.Nombre_A_Error === undefined) ? '' : data.Nombre_A_Error
                Ap_Paterno_A_Error.innerText = (data.Ap_Paterno_A_Error === undefined) ? '' : data.Ap_Paterno_A_Error
                Ap_Materno_A_Error.innerText = (data.Ap_Materno_A_Error === undefined) ? '' : data.Ap_Materno_A_Error
                Nombre_TO_0_Error.innerText = (data.Nombre_TO_0_Error === undefined) ? '' : data.Nombre_TO_0_Error
                Ap_Paterno_TO_0_Error.innerText = (data.Ap_Paterno_TO_0_Error === undefined) ? '' : data.Ap_Paterno_TO_0_Error
                Ap_Materno_TO_0_Error.innerText = (data.Ap_Materno_TO_0_Error === undefined) ? '' : data.Ap_Materno_TO_0_Error
                Nombre_TO_1_Error.innerText = (data.Nombre_TO_1_Error === undefined) ? '' : data.Nombre_TO_1_Error
                Ap_Paterno_TO_1_Error.innerText = (data.Ap_Paterno_TO_1_Error === undefined) ? '' : data.Ap_Paterno_TO_1_Error
                Ap_Materno_TO_1_Error.innerText = (data.Ap_Materno_TO_1_Error === undefined) ? '' : data.Ap_Materno_TO_1_Error
                Nombre_PR_Error.innerText = (data.Nombre_PR_Error === undefined) ? '' : data.Nombre_PR_Error
                Ap_Paterno_PR_Error.innerText = (data.Ap_Paterno_PR_Error === undefined) ? '' : data.Ap_Paterno_PR_Error
                Ap_Materno_PR_Error.innerText = (data.Ap_Materno_PR_Error === undefined) ? '' : data.Ap_Materno_PR_Error
                Institucion_Error.innerText = (data.Institucion_Error === undefined) ? '' : data.Institucion_Error
                Cargo_Error.innerText = (data.Cargo_Error === undefined) ? '' : data.Cargo_Error

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

                msg_anexoDObjetosError.innerHTML = messageError
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

                //Id_Inventario_Objetos

                msg_anexoDObjetosError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información actualizada con éxito</div>';

                if (myFormData.get('Id_Inventario_Objetos') == -1) {
                    alerta(myFormData.get('Id_Puesta'))
                    setInterval(() => {
                        msg_anexoDObjetosError.innerHTML = '';
                    }, 2000);
                } else {
                    setInterval(() => {
                        window.location = base_url_js + "Juridico/Puesta/" + myFormData.get('Id_Puesta') + '/ver';
                    }, 3500);

                }
                // setInterval(() => {
                //     window.location = base_url_js + "Juridico/Puesta/" + myFormData.get('Id_Puesta') + '/ver';
                // }, 3500);
                // result.tab === '1' ? '' : document.getElementById('save-tab-0').style.display = 'block';
            }
        })
    } else { //si no, se muestran errores en pantalla
        msg_anexoDObjetosError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>'
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

const buttonSearch = document.getElementById('button_search'),
    elementSearch = document.getElementById('element_search'),
    listElementsSearch = document.getElementById('list_elements_search'),
    inputsElements = [
        { key: 'nombre', value: 'Nombre_PR' },
        { key: 'paterno', value: 'Ap_Paterno_PR' },
        { key: 'materno', value: 'Ap_Materno_PR' },
        { key: 'cargo', value: 'Cargo' },
        { key: 'adscripcion', value: 'Institucion' },
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