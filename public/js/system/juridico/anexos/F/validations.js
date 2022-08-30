const array = [
    { id: 'Descripcion_PL', length: 16000 },
    { id: 'Nombre_PER_0', length: 200 },
    { id: 'Ap_Paterno_PER_0', length: 450 },
    { id: 'Ap_Materno_PER_0', length: 450 },
    { id: 'Institucion_0', length: 450 },
    { id: 'Cargo_0', length: 450 },
    { id: 'Nombre_PER_1', length: 200 },
    { id: 'Ap_Paterno_PER_1', length: 450 },
    { id: 'Ap_Materno_PER_1', length: 450 },
    { id: 'Institucion_1', length: 450 },
    { id: 'Cargo_1', length: 450 },
    { id: 'Observaciones', length: 4500 }
]
validateInputs(array)

document.getElementById('Fecha').addEventListener('input', () => {
    document.getElementById('Fecha_error').textContent = ((existeFecha(document.getElementById('Fecha').value))) ? '' : 'Elija una fecha correcta'
})

document.getElementById('Hora').addEventListener('input', () => {
    document.getElementById('Hora_error').textContent = (existeHora(document.getElementById('Hora').value)) ? '' : 'Ingrese una fecha valida';
})

document.getElementsByName('autoridad').forEach(element => {
    element.addEventListener('change', () => {
        if (element.value === 'Si') {
            document.getElementById('div_Descripcion_Apoyo').style.display = 'block'
            const array = [
                { id: 'Descripcion_Apoyo', length: 250 }
            ]
            validateInputs(array)
        } else if (element.value === 'No') {
            document.getElementById('div_Descripcion_Apoyo').style.display = 'none'
        }
    })
});


document.getElementsByName('persona').forEach(element => {
    element.addEventListener('change', () => {
        if (element.value === 'Si') {
            document.getElementById('id_Motivo').style.display = 'block'
            const array = [
                { id: 'Motivo_Ingreso', length: 2500 },
            ]
            validateInputs(array)
        } else if (element.value === 'No') {
            document.getElementById('id_Motivo').style.display = 'none'
        }
    })
});