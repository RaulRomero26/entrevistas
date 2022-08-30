fecha.addEventListener('input', () => {
    fecha_error.textContent = ((existeFecha(fecha.value))) ? '' : 'Elija una fecha correcta'
})

hora.addEventListener('input', () => {
    hora_error.textContent = (existeHora(hora.value)) ? '' : 'Ingrese una fecha valida';
})

const array = [
    { id: 'Marca', length: 100 },
    // { id: 'Submarca', length: 100 },
    // { id: 'Modelo', length: 4 },
    { id: 'Color', length: 100 },
    // { id: 'Placa', length: 45 },
    { id: 'Num_Serie', length: 18 },
    // { id: 'Observaciones', length: 250 },
    { id: 'Destino', length: 10000 }
]
validateInputs(array)

document.getElementsByName('pr').forEach(element => {
    element.addEventListener('change', () => {
        if (element.value === 'Si') {
            document.getElementById('div_respondientes').style.display = 'none'
        } else if (element.value === 'No') {
            document.getElementById('div_respondientes').style.display = 'block'
            document.getElementById('Institucion').style.display = 'block'

            const array = [
                { id: 'Nombre_PR', length: 250 },
                { id: 'Ap_Paterno_PR', length: 250 },
                { id: 'Ap_Materno_PR', length: 250 },
                { id: 'Institucion', length: 250 },
                { id: 'Cargo', length: 250 }
            ]
            validateInputs(array)

            const array_0 = [
                { id: 'Nombre_PR_1', length: 250 },
                { id: 'Ap_Paterno_PR_1', length: 250 },
                { id: 'Ap_Materno_PR_1', length: 250 },
                { id: 'Institucion_1', length: 250 },
                { id: 'Cargo_1', length: 250 }
            ]
            validateInputs(array_0)
        }
    })
});