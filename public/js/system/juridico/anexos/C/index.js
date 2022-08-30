//inputs del formulario
const fecha = document.getElementById('fecha')
const hora = document.getElementById('hora')

const tipo = document.getElementById('tipo')
const Procedencia = document.getElementById('Procedencia')
const Uso = document.getElementById('Uso')
const Situacion = document.getElementById('Situacion')

const Marca = document.getElementById('Marca')
const Submarca = document.getElementById('Submarca')
const Modelo = document.getElementById('Modelo')
const Color = document.getElementById('Color')
const Placa = document.getElementById('Placa')
const Num_Serie = document.getElementById('Num_Serie')
const Observaciones = document.getElementById('Observaciones')
const Destino = document.getElementById('Destino')
const Nombre_PR = document.getElementById('Nombre_PR')
const Ap_Paterno_PR = document.getElementById('Ap_Paterno_PR')
const Ap_Materno_PR = document.getElementById('Ap_Materno_PR')
const Institucion = document.getElementById('Institucion')
const Cargo = document.getElementById('Cargo')
const Nombre_PR_1 = document.getElementById('Nombre_PR_1')
const Ap_Paterno_PR_1 = document.getElementById('Ap_Paterno_PR_1')
const Ap_Materno_PR_1 = document.getElementById('Ap_Materno_PR_1')
const Institucion_1 = document.getElementById('Institucion_1')
const Cargo_1 = document.getElementById('Cargo_1')

const data = document.getElementById('anexoCForm')

//labels para mostrar de error
const fecha_error = document.getElementById('fecha_error')
const hora_error = document.getElementById('hora_error')
const Marca_error = document.getElementById('Marca_error')
const Submarca_error = document.getElementById('Submarca_error')
const Modelo_error = document.getElementById('Modelo_error')
const Color_error = document.getElementById('Color_error')
const Placa_error = document.getElementById('Placa_error')
const Num_Serie_error = document.getElementById('Num_Serie_error')
const Observaciones_error = document.getElementById('Observaciones_error')
const Destino_error = document.getElementById('Destino_error')

const Nombre_PR_error = document.getElementById('Nombre_PR_error')
const Ap_Paterno_PR_error = document.getElementById('Ap_Paterno_PR_error')
const Ap_Materno_PR_error = document.getElementById('Ap_Materno_PR_error')
const Institucion_error = document.getElementById('Institucion_error')
const Cargo_error = document.getElementById('Cargo_error')
const Nombre_PR_1_error = document.getElementById('Nombre_PR_1_error')
const Ap_Paterno_PR_1_error = document.getElementById('Ap_Paterno_PR_1_error')
const Ap_Materno_PR_1_error = document.getElementById('Ap_Materno_PR_1_error')
const Institucion_1_error = document.getElementById('Institucion_1_error')
const Cargo_1_error = document.getElementById('Cargo_1_error')
const button = document.getElementById('btn_anexoC')


const msg_anexoCError = document.getElementById('msg_anexoCError')

const senForm = (event) => {


    // console.log(event.target.getAttribute('data-id'))

    const button = document.getElementById('btn_anexoC');
    let myFormData = new FormData(data);
    let band = []

    let FV = new FormValidator()
    let i = 0;


    band[i++] = fecha_error.innerText = FV.validate(myFormData.get('fecha'), 'required | date');
    band[i++] = hora_error.innerText = FV.validate(myFormData.get('hora'), 'required | time');
    band[i++] = Marca_error.innerText = FV.validate(myFormData.get('Marca'), 'max_length[100]');
    band[i++] = Submarca_error.innerText = FV.validate(myFormData.get('Submarca'), 'max_length[100]');
    band[i++] = Modelo_error.innerText = FV.validate(myFormData.get('Modelo'), 'max_length[4]');
    band[i++] = Color_error.innerText = FV.validate(myFormData.get('Color'), 'required | max_length[100]');
    band[i++] = Placa_error.innerText = FV.validate(myFormData.get('Placa'), 'max_length[45]');
    band[i++] = Num_Serie_error.innerText = FV.validate(myFormData.get('Num_Serie'), 'max_length[18]');
    band[i++] = Observaciones_error.innerText = FV.validate(myFormData.get('Observaciones'), 'max_length[10000]');
    band[i++] = Destino_error.innerText = FV.validate(myFormData.get('Destino'), 'required | max_length[10000]');

    if (myFormData.get('pr') === 'No') {
        band[i++] = Nombre_PR_error.innerText = FV.validate(myFormData.get('Nombre_PR'), 'required | max_length[250]')
        band[i++] = Ap_Paterno_PR_error.innerText = FV.validate(myFormData.get('Ap_Paterno_PR'), 'required | max_length[250]')
        band[i++] = Ap_Materno_PR_error.innerText = FV.validate(myFormData.get('Ap_Materno_PR'), 'required | max_length[250]')
        band[i++] = Institucion_error.innerText = FV.validate(myFormData.get('Institucion'), 'required | max_length[250]')
        band[i++] = Cargo_error.innerText = FV.validate(myFormData.get('Cargo'), 'required | max_length[250]')

        band[i++] = Nombre_PR_1_error.innerText = FV.validate(myFormData.get('Nombre_PR_1'), 'max_length[250]')
        band[i++] = Ap_Paterno_PR_1_error.innerText = FV.validate(myFormData.get('Ap_Paterno_PR_1'), 'max_length[250]')
        band[i++] = Ap_Materno_PR_1_error.innerText = FV.validate(myFormData.get('Ap_Materno_PR_1'), 'max_length[250]')
        band[i++] = Institucion_1_error.innerText = FV.validate(myFormData.get('Institucion_1'), 'max_length[250]')
        band[i++] = Cargo_1_error.innerText = FV.validate(myFormData.get('Cargo_1'), 'max_length[250]')
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
        myFormData.append('btn_anexoC', button.value)

        let URL_FETCH = (event.target.getAttribute('data-id') === 'insertar') ? 'insertarAnexoC' : 'actualizarAnexoC'

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

                fecha_error.innerText = (data.fecha_error === undefined) ? '' : data.fecha_error
                hora_error.innerText = (data.hora_error === undefined) ? '' : data.hora_error
                Marca_error.innerText = (data.Marca_error === undefined) ? '' : data.Marca_error
                Submarca_error.innerText = (data.Submarca_error === undefined) ? '' : data.Submarca_error
                Modelo_error.innerText = (data.Modelo_error === undefined) ? '' : data.Modelo_error
                Color_error.innerText = (data.Color_error === undefined) ? '' : data.Color_error
                Placa_error.innerText = (data.Placa_error === undefined) ? '' : data.Placa_error
                Num_Serie_error.innerText = (data.Num_Serie_error === undefined) ? '' : data.Num_Seri_errore
                Observaciones_error.innerText = (data.Observaciones_error === undefined) ? '' : data.Observaciones_error
                Destino_error.innerText = (data.Destino_error === undefined) ? '' : data.Destino_error

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
                msg_anexoCError.innerHTML = messageError
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

                msg_anexoCError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información actualizada con éxito</div>';
                setInterval(() => {
                    window.location = base_url_js + "Juridico/Puesta/" + myFormData.get('Id_Puesta') + '/ver';
                }, 3500);
                // result.tab === '1' ? '' : document.getElementById('save-tab-0').style.display = 'block';
            }
        })
    } else { //si no, se muestran errores en pantalla
        msg_anexoCError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>'
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });
    }


    for (var pair of myFormData.entries()) {
        // console.log(pair[0] + ', ' + pair[1]);
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



/* -------------------------Segundo respondiente -------------------------*/
const buttonSearch_1 = document.getElementById('button_search_1'),
    elementSearch_1 = document.getElementById('element_search_1'),
    listElementsSearch_1 = document.getElementById('list_elements_search_1'),
    inputsElements_1 = [
        { key: 'nombre', value: 'Nombre_PR_1' },
        { key: 'paterno', value: 'Ap_Paterno_PR_1' },
        { key: 'materno', value: 'Ap_Materno_PR_1' },
        { key: 'cargo', value: 'Cargo_1' },
        { key: 'adscripcion', value: 'Institucion_1' },
        { key: 'button', value: 'button_search_1' },
        { key: 'search', value: 'element_search_1', },
        { key: 'content', value: 'list_elements_search_1' }
    ];

buttonSearch_1.addEventListener('click', () => {
    buttonSearch_1.innerText = `Buscando`;
    buttonSearch_1.setAttribute('disabled', '');
    getPrimerRespondiente(elementSearch_1.value, inputsElements_1);
})

elementSearch_1.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        e.preventDefault()
        buttonSearch_1.innerText = `Buscando`;
        buttonSearch_1.setAttribute('disabled', '');
        getPrimerRespondiente(elementSearch_1.value, inputsElements_1);
    }
})