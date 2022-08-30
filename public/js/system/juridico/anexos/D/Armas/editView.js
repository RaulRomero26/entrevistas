let modo = true

const elements = [
    { id: 'Aportacion', type: 'checkbox' },
    { id: 'Inspeccion', type: 'checkbox' },
    { id: 'Ubicacion_Arma', type: 'input' },
    { id: 'Tipo_Arma', type: 'checkbox' },
    { id: 'Calibre', type: 'input' },
    { id: 'Color', type: 'input' },
    { id: 'Matricula', type: 'input' },
    { id: 'Num_Serie', type: 'input' },
    { id: 'Observaciones', type: 'input' },
    { id: 'Destino', type: 'input' },
    { id: 'Nombre_A', type: 'input' },
    { id: 'Ap_Paterno_A', type: 'input' },
    { id: 'Ap_Materno_A', type: 'input' },
    { id: 'testigos', type: 'checkbox' },
    { id: 'Nombre_TA_0', type: 'input' },
    { id: 'Ap_Paterno_TA_0', type: 'input' },
    { id: 'Ap_Materno_TA_0', type: 'input' },
    { id: 'Nombre_TA_1', type: 'input' },
    { id: 'Ap_Paterno_TA_1', type: 'input' },
    { id: 'Ap_Materno_TA_1', type: 'input' },
    { id: 'arma', type: 'checkbox' },
    { id: 'Nombre_PRA', type: 'input' },
    { id: 'Ap_Paterno_PRA', type: 'input' },
    { id: 'Ap_Materno_PRA', type: 'input' },
    { id: 'InstitucionA', type: 'input' },
    { id: 'CargoA', type: 'input' },
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