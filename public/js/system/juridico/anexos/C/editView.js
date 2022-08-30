let modo = true

const elements = [
    { id: 'fecha', type: 'input' },
    { id: 'hora', type: 'input' },
    { id: 'tipo', type: 'select' },
    { id: 'Procedencia', type: 'select' },
    { id: 'Uso', type: 'select' },
    { id: 'Situacion', type: 'select' },
    { id: 'Marca', type: 'input' },
    { id: 'Submarca', type: 'input' },
    { id: 'Modelo', type: 'input' },
    { id: 'Color', type: 'input' },
    { id: 'Placa', type: 'input' },
    { id: 'Num_Serie', type: 'input' },
    { id: 'Observaciones', type: 'input' },
    { id: 'Destino', type: 'input' },
    { id: 'Nombre_PR', type: 'input' },
    { id: 'Ap_Paterno_PR', type: 'input' },
    { id: 'Ap_Materno_PR', type: 'input' },
    { id: 'Institucion', type: 'input' },
    { id: 'Cargo', type: 'input' },
    { id: 'Nombre_PR_1', type: 'input' },
    { id: 'Ap_Paterno_PR_1', type: 'input' },
    { id: 'Ap_Materno_PR_1', type: 'input' },
    { id: 'Institucion_1', type: 'input' },
    { id: 'Cargo_1', type: 'input' },
    { id: 'Objetos_Encontrados', type: 'checkbox' },
    { id: 'pr', type: 'checkbox' },
    { id: 'btn_anexoC', type: 'input' },
    { id: 'button_search', type: 'select' },
    { id: 'button_search_1', type: 'select' }
]

window.onload = () => {
    disableForm(modo, button, elements);
    getData()
}

btn_modo = document.getElementById('id_edit_button')


btn_modo.addEventListener('click', () => {
    if (btn_modo.innerText === 'Modo Editar') {
        btn_modo.innerText = 'Modo lectura'
        disableForm(false, button, elements)
        button.setAttribute('data-id', 'actualizar')
    } else {
        btn_modo.innerText = 'Modo Editar'
        disableForm(true, button, elements)
        button.setAttribute('data-id', 'insertar')
    }
})