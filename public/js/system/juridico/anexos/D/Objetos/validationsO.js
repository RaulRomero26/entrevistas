const array = [
    /* { id: 'Ubicacion_Objeto', length: 250 }, */
    { id: 'Destino', length: 250 },
    { id: 'Descripcion_Objeto', length: 1000 },
    // { id: 'Nombre_A', length: 250 },
    // { id: 'Ap_Paterno_A', length: 250 },
    // { id: 'Ap_Materno_A', length: 250 }
]
validateInputs(array)

document.getElementsByName('Apariencia').forEach(element => {
    element.addEventListener('change', () => {
        if (element.value == 'Otro') {
            document.getElementById('div_otro').style.display = 'block'
            const array = [{ id: 'otro', length: 450 }]
            validateInputs(array)
        } else {
            document.getElementById('div_otro').style.display = 'none'
        }
    })
});

document.getElementsByName('testigos').forEach(element => {
    element.addEventListener('change', () => {
        if (element.value === 'Si') {
            document.getElementById('div_testigos').style.display = 'block'
            const array = [
                { id: 'Nombre_TO_0', length: 250 },
                { id: 'Ap_Paterno_TO_0', length: 250 },
                { id: 'Ap_Materno_TO_0', length: 250 },
                { id: 'Nombre_TO_1', length: 250 },
                { id: 'Ap_Paterno_TO_1', length: 250 },
                { id: 'Ap_Materno_TO_1', length: 250 },
            ]
            validateInputs(array)
        } else if (element.value === 'No') {
            document.getElementById('div_testigos').style.display = 'none'
        }
    })
});

document.getElementsByName('respondiente').forEach(element => {
    element.addEventListener('change', () => {
        if (element.value === 'Si') {
            document.getElementById('div_respondiente').style.display = 'none'
            const array = [
                { id: 'Nombre_PR', length: 250 },
                { id: 'Ap_Paterno_PR', length: 250 },
                { id: 'Ap_Materno_PR', length: 250 },
                { id: 'Institucion', length: 250 },
                { id: 'Cargo', length: 250 }
            ]
            validateInputs(array)
        } else if (element.value === 'No') {
            document.getElementById('div_respondiente').style.display = 'block'
        }
    })
});