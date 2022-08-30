// PRIMER RESPONDIENTE (BUSCADOR)
const buttonSearch1 = document.getElementById('button_search_1'),
    elementSearch1 = document.getElementById('element_search_1'),
    inputsElements1 = [{
            key: 'nombre',
            value: 'id_nombre_e'
        },
        {
            key: 'paterno',
            value: 'id_ap_paterno_e'
        },
        {
            key: 'materno',
            value: 'id_ap_materno_e'
        },
        {
            key: 'cargo',
            value: 'id_cargo_e'
        },
        {
            key: 'adscripcion',
            value: 'id_sector_e'
        },
        {
            key: 'control',
            value: 'id_no_control'
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