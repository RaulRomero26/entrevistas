//Campos
let Descripcion_PL = document.getElementById('Descripcion_PL')
let Descripcion_Apoyo = document.getElementById('Descripcion_Apoyo')
let Motivo_Ingreso = document.getElementById('Motivo_Ingreso')
let Nombre_PER_0 = document.getElementById('Nombre_PER_0')
let Ap_Paterno_PER_0 = document.getElementById('Ap_Paterno_PER_0')
let Ap_Materno_PER_0 = document.getElementById('Ap_Materno_PER_0')
let Institucion_0 = document.getElementById('Institucion_0')
let Cargo_0 = document.getElementById('Cargo_0')
let Nombre_PER_1 = document.getElementById('Nombre_PER_1')
let Ap_Paterno_PER_1 = document.getElementById('Ap_Paterno_PER_1')
let Ap_Materno_PER_1 = document.getElementById('Ap_Materno_PER_1')
let Institucion_1 = document.getElementById('Institucion_1')
let Cargo_1 = document.getElementById('Cargo_1')
let tabla = document.getElementById('elementos_intervencion')
let Observaciones = document.getElementById('Observaciones')
let Fecha = document.getElementById('Fecha')
let Hora = document.getElementById('Hora')

//Errores Campos
let Descripcion_PL_error = document.getElementById('Descripcion_PL_error')
let Descripcion_Apoyo_error = document.getElementById('Descripcion_Apoyo_error')
let Motivo_Ingreso_error = document.getElementById('Motivo_Ingreso_error')
let Nombre_PER_0_error = document.getElementById('Nombre_PER_0_error')
let Ap_Paterno_PER_0_error = document.getElementById('Ap_Paterno_PER_0_error')
let Ap_Materno_PER_0_error = document.getElementById('Ap_Materno_PER_0_error')
let Institucion_0_error = document.getElementById('Institucion_0_error')
let Cargo_0_error = document.getElementById('Cargo_0_error')
let Nombre_PER_1_error = document.getElementById('Nombre_PER_1_error')
let Ap_Paterno_PER_1_error = document.getElementById('Ap_Paterno_PER_1_error')
let Ap_Materno_PER_1_error = document.getElementById('Ap_Materno_PER_1_error')
let Institucion_1_error = document.getElementById('Institucion_1_error')
let Cargo_1_error = document.getElementById('Cargo_1_error')
let tabla_error = document.getElementById('tabla_error')
let Observaciones_error = document.getElementById('Observaciones_error')
let Fecha_error = document.getElementById('Fecha_error')
let Hora_error = document.getElementById('Hora_error')

let data = document.getElementById('anexoFForm')
let msg_anexoFError = document.getElementById('msg_anexoFError')
let button = document.getElementById('btn_anexoF')


const sendForm = (event) => {

    // button.addEventListener('click', (e) => {

    // e.preventDefault();
    let myFormData = new FormData(data);
    let band = []
    let FV = new FormValidator()
    let i = 0;

    band[i++] = Descripcion_PL_error.innerText = FV.validate(myFormData.get('Descripcion_PL'), 'required | max_length[16000]')
    band[i++] = Nombre_PER_0_error.innerText = FV.validate(myFormData.get('Nombre_PER_0'), 'required | max_length[200]')
    band[i++] = Ap_Paterno_PER_0_error.innerText = FV.validate(myFormData.get('Ap_Paterno_PER_0'), 'required | max_length[450]')
    band[i++] = Ap_Materno_PER_0_error.innerText = FV.validate(myFormData.get('Ap_Materno_PER_0'), 'required | max_length[450]')
    band[i++] = Institucion_0_error.innerText = FV.validate(myFormData.get('Institucion_0'), 'required | max_length[450]')
    band[i++] = Cargo_0_error.innerText = FV.validate(myFormData.get('Cargo_0'), 'required | max_length[450]')
    band[i++] = Nombre_PER_1_error.innerText = FV.validate(myFormData.get('Nombre_PER_1'), 'required | max_length[200]')
    band[i++] = Ap_Paterno_PER_1_error.innerText = FV.validate(myFormData.get('Ap_Paterno_PER_1'), 'required | max_length[450]')
    band[i++] = Ap_Materno_PER_1_error.innerText = FV.validate(myFormData.get('Ap_Materno_PER_1'), 'required | max_length[450]')
    band[i++] = Institucion_1_error.innerText = FV.validate(myFormData.get('Institucion_1'), 'required | max_length[450]')
    band[i++] = Cargo_1_error.innerText = FV.validate(myFormData.get('Cargo_1'), 'required | max_length[450]')
    band[i++] = Observaciones_error.innerText = FV.validate(myFormData.get('Observaciones'), 'required | max_length[4500]')
    band[i++] = Fecha_error.innerText = FV.validate(myFormData.get('Fecha'), 'required | date')
    band[i++] = Hora_error.innerText = FV.validate(myFormData.get('Hora'), 'required | time')

    if (myFormData.get('autoridad') === 'Si')
        band[i++] = Descripcion_Apoyo_error.innerText = FV.validate(myFormData.get('Descripcion_Apoyo'), 'required | max_length[250]')

    // console.log(tabla.rows.length)

    if (myFormData.get('persona') === 'Si') {
        band[i++] = Motivo_Ingreso_error.innerText = FV.validate(myFormData.get('Motivo_Ingreso'), 'required | max_length[2500]')
        band[i++] = tabla_error.innerText = (tabla.rows.length > 1) ? '' : 'La tabla debe contener almenos 1 elemento.'
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
        myFormData.append('btn_anexoF', button.value)
        myFormData.append('elementos_intervencion', JSON.stringify(readTablePersonal()))


        let URL_FETCH = (event.target.getAttribute('data-id') === 'insertar') ? 'insertarAnexoF' : 'actualizarAnexoF'
            // console.log(URL_FETCH)

        fetch(base_url_js + 'Juridico/' + URL_FETCH, {
            method: 'POST',
            body: myFormData
        })

        .then(res => res.json())

        .then(data => {
            button.innerHTML = `Guardar`;
            button.classList.remove('disabled-link');

            // console.log(data)
            if (!data.status) {

                Descripcion_PL_error.innerText = (data.Descripcion_PL_error === undefined) ? '' : data.Descripcion_PL_error
                Nombre_PER_0_error.innerText = (data.Nombre_PER_0_error === undefined) ? '' : data.Nombre_PER_0_error
                Ap_Paterno_PER_0_error.innerText = (data.Ap_Paterno_PER_0_error === undefined) ? '' : data.Ap_Paterno_PER_0_error
                Ap_Materno_PER_0_error.innerText = (data.Ap_Materno_PER_0_error === undefined) ? '' : data.Ap_Materno_PER_0_error
                Institucion_0_error.innerText = (data.Institucion_0_error === undefined) ? '' : data.Institucion_0_error
                Cargo_0_error.innerText = (data.Cargo_0_error === undefined) ? '' : data.Cargo_0_error
                Nombre_PER_1_error.innerText = (data.Nombre_PER_1_error === undefined) ? '' : data.Nombre_PER_1_error
                Ap_Paterno_PER_1_error.innerText = (data.Ap_Paterno_PER_1_error === undefined) ? '' : data.Ap_Paterno_PER_1_error
                Ap_Materno_PER_1_error.innerText = (data.Ap_Materno_PER_1_error === undefined) ? '' : data.Ap_Materno_PER_1_error
                Institucion_1_error.innerText = (data.Institucion_1_error === undefined) ? '' : data.Institucion_1_error
                Cargo_1_error.innerText = (data.Cargo_1_error === undefined) ? '' : data.Cargo_1_error
                Observaciones_error.innerText = (data.Observaciones_error === undefined) ? '' : data.Observaciones_error
                Fecha_error.innerText = (data.Fecha_error === undefined) ? '' : data.Fecha_error
                Hora_error.innerText = (data.Hora_error === undefined) ? '' : data.Hora_error
                Descripcion_Apoyo_error.innerText = (data.Descripcion_Apoyo_error === undefined) ? '' : data.Descripcion_Apoyo_error
                Motivo_Ingreso_error.innerText = (data.Motivo_Ingreso_error === undefined) ? '' : data.Motivo_Ingreso_error

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

                msg_anexoFError.innerHTML = messageError
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
                msg_anexoFError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información actualizada con éxito</div>';
                setInterval(() => {
                    window.location = base_url_js + "Juridico/Puesta/" + myFormData.get('Id_Puesta') + '/ver';
                }, 3500);
            }
        })
    } else { //si no, se muestran errores en pantalla
        msg_anexoFError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>'
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
        { key: 'nombre', value: 'Nombre_PER_0' },
        { key: 'paterno', value: 'Ap_Paterno_PER_0' },
        { key: 'materno', value: 'Ap_Materno_PER_0' },
        { key: 'cargo', value: 'Cargo_0' },
        { key: 'adscripcion', value: 'Institucion_0' },
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
        { key: 'nombre', value: 'Nombre_PER_1' },
        { key: 'paterno', value: 'Ap_Paterno_PER_1' },
        { key: 'materno', value: 'Ap_Materno_PER_1' },
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

/* -------------------------Tabla respondiente -------------------------*/
const buttonSearch_2 = document.getElementById('button_search_2'),
    elementSearch_2 = document.getElementById('element_search_2'),
    listElementsSearch_2 = document.getElementById('list_elements_search_2'),
    inputsElements_2 = [
        { key: 'nombre', value: 'Nombre_PLI' },
        { key: 'paterno', value: 'Ap_Paterno_PLI' },
        { key: 'materno', value: 'Ap_Materno_PLI' },
        { key: 'cargo', value: 'Cargo' },
        { key: 'adscripcion', value: 'Institucion' },
        { key: 'button', value: 'button_search_2' },
        { key: 'search', value: 'element_search_2', },
        { key: 'content', value: 'list_elements_search_2' }
    ];

buttonSearch_2.addEventListener('click', () => {
    buttonSearch_2.innerText = `Buscando`;
    buttonSearch_2.setAttribute('disabled', '');
    getPrimerRespondiente(elementSearch_2.value, inputsElements_2);
})

elementSearch_2.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        e.preventDefault()
        buttonSearch_2.innerText = `Buscando`;
        buttonSearch_2.setAttribute('disabled', '');
        getPrimerRespondiente(elementSearch_2.value, inputsElements_2);
    }
})