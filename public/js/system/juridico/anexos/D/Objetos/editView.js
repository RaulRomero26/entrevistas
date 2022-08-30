let modo = true

const elements = [
    { id: 'Apariencia', type: 'checkbox' },
    { id: 'Aportacion', type: 'checkbox' },
    { id: 'Inspeccion', type: 'checkbox' },
    { id: 'Ubicacion_Objeto', type: 'input' },
    { id: 'Destino', type: 'input' },
    { id: 'Descripcion_Objeto', type: 'input' },
    { id: 'Nombre_A', type: 'input' },
    { id: 'Ap_Paterno_A', type: 'input' },
    { id: 'Ap_Materno_A', type: 'input' },
    { id: 'testigos', type: 'checkbox' },
    { id: 'Nombre_TO_0', type: 'input' },
    { id: 'Ap_Paterno_TO_0', type: 'input' },
    { id: 'Ap_Materno_TO_0', type: 'input' },
    { id: 'Nombre_TO_1', type: 'input' },
    { id: 'Ap_Paterno_TO_1', type: 'input' },
    { id: 'Ap_Materno_TO_1', type: 'input' },
    { id: 'respondiente', type: 'checkbox' },
    { id: 'Nombre_PR', type: 'input' },
    { id: 'Ap_Paterno_PR', type: 'input' },
    { id: 'Ap_Materno_PR', type: 'input' },
    { id: 'Institucion', type: 'input' },
    { id: 'Cargo', type: 'input' },
    { id: 'button_search', type: 'select' }
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