let modo = true

const elements = [
    { id: 'Descripcion_PL', type: 'input' },
    { id: 'autoridad', type: 'checkbox' },
    { id: 'Descripcion_Apoyo', type: 'input' },
    { id: 'persona', type: 'checkbox' },
    { id: 'Motivo_Ingreso', type: 'input' },
    { id: 'Nombre_PLI', type: 'input' },
    { id: 'Ap_Paterno_PLI', type: 'input' },
    { id: 'Ap_Materno_PLI', type: 'input' },
    { id: 'Cargo', type: 'input' },
    { id: 'Institucion', type: 'input' },
    { id: 'btn-add-personal', type: 'input' },
    { id: 'btn_anexoF', type: 'input' },
    { id: 'Nombre_PER_0', type: 'input' },
    { id: 'Ap_Paterno_PER_0', type: 'input' },
    { id: 'Ap_Materno_PER_0', type: 'input' },
    { id: 'Institucion_0', type: 'input' },
    { id: 'Cargo_0', type: 'input' },
    { id: 'Nombre_PER_1', type: 'input' },
    { id: 'Ap_Paterno_PER_1', type: 'input' },
    { id: 'Ap_Materno_PER_1', type: 'input' },
    { id: 'Institucion_1', type: 'input' },
    { id: 'Cargo_1', type: 'input' },
    { id: 'Observaciones', type: 'input' },
    { id: 'Fecha', type: 'input' },
    { id: 'Hora', type: 'input' },
    { id: 'btn-add-personal', type: 'input' },
    { id: 'button_search', type: 'select' },
    { id: 'button_search_1', type: 'select' },
    { id: 'button_search_2', type: 'select' }
]

window.onload = () => {
    disableForm(modo, button, elements);
    // console.log(document.getElementById('Nombre_PLI'))
    getData()
}

btn_modo = document.getElementById('id_edit_button')


btn_modo.addEventListener('click', () => {
    if (btn_modo.innerText === 'Modo Editar') {
        btn_modo.innerText = 'Modo lectura'
        disableForm(false, button, elements)
        button.setAttribute('data-id', 'actualizar')
        document.getElementById('btn-add-personal').disabled = false;
        activateButtonRow(document.getElementById('elementos_intervencion').getElementsByClassName('action_row'), false)
    } else {
        btn_modo.innerText = 'Modo Editar'
        disableForm(true, button, elements)
        button.setAttribute('data-id', 'insertar')
        document.getElementById('btn-add-personal').disabled = true;
        activateButtonRow(document.getElementById('elementos_intervencion').getElementsByClassName('action_row'), true)
    }
})





// document.getElementsByClassName('action_row').forEach(element => {
//     console.log(element)

// });