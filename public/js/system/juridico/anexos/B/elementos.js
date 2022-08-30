// PRIMER RESPONDIENTE (BUSCADOR)
const buttonSearch1 = document.getElementById('button_search_1'),
    elementSearch1 = document.getElementById('element_search_1'),
    inputsElements1 = [{
            key: 'nombre',
            value: 'id_nombre_pr'
        },
        {
            key: 'paterno',
            value: 'id_ap_pat_pr'
        },
        {
            key: 'materno',
            value: 'id_ap_mat_pr'
        },
        {
            key: 'cargo',
            value: 'id_cargo_pr'
        },
        {
            key: 'adscripcion',
            value: 'id_institucion_pr'
        },
        {
            key: 'control',
            value: 'id_no_control_pr'
        },
        {
            key: 'button',
            value: 'button_search_1'
        },
        {
            key: 'search',
            value: 'element_search_1'
        },
        {
            key: 'content',
            value: 'list_elements_search_1'
        }
    ];

buttonSearch1.addEventListener('click', () => {
    buttonSearch1.innerText = `Buscando`;
    buttonSearch1.setAttribute('disabled', '');
    getPrimerRespondiente(elementSearch1.value, inputsElements1);
})

elementSearch1.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        buttonSearch1.innerText = `Buscando`;
        buttonSearch1.setAttribute('disabled', '');
        getPrimerRespondiente(elementSearch1.value, inputsElements1);
    }
})

// SEGUNDO RESPONDIENTE (BUSCADOR)
const buttonSearch2 = document.getElementById('button_search_2'),
    elementSearch2 = document.getElementById('element_search_2'),
    inputsElements2 = [{
            key: 'nombre',
            value: 'id_nombre_sr'
        },
        {
            key: 'paterno',
            value: 'id_ap_pat_sr'
        },
        {
            key: 'materno',
            value: 'id_ap_mat_sr'
        },
        {
            key: 'cargo',
            value: 'id_cargo_sr'
        },
        {
            key: 'adscripcion',
            value: 'id_institucion_sr'
        },
        {
            key: 'control',
            value: 'id_no_control_sr'
        },
        {
            key: 'button',
            value: 'button_search_2'
        },
        {
            key: 'search',
            value: 'element_search_2'
        },
        {
            key: 'content',
            value: 'list_elements_search_2'
        }
    ];

buttonSearch2.addEventListener('click', () => {
    buttonSearch2.innerText = `Buscando`;
    buttonSearch2.setAttribute('disabled', '');
    getPrimerRespondiente(elementSearch2.value, inputsElements2);
})

elementSearch2.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        buttonSearch2.innerText = `Buscando`;
        buttonSearch2.setAttribute('disabled', '');
        getPrimerRespondiente(elementSearch2.value, inputsElements2);
    }
})