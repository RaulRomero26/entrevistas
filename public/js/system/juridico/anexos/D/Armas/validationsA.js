const array = [
    { id: 'Ubicacion_Arma', length: 1000 },
    { id: 'Calibre', length: 45 },
    { id: 'Color', length: 45 },
    { id: 'Matricula', length: 45 },
    { id: 'Num_Serie', length: 45 },
    { id: 'Observaciones', length: 10000 },
    { id: 'Destino', length: 10000 },
    // { id: 'Nombre_A', length: 250 },
    // { id: 'Ap_Paterno_A', length: 250 },
    // { id: 'Ap_Materno_A', length: 250 }
]
validateInputs(array)

document.getElementsByName('arma').forEach(element => {
    element.addEventListener('change', () => {
        if (element.value === 'Si') {
            document.getElementById('div_respondientes_Armas').style.display = 'none'
        } else if (element.value === 'No') {
            document.getElementById('div_respondientes_Armas').style.display = 'block'
            const array = [
                { id: 'Nombre_PRA', length: 250 },
                { id: 'Ap_Paterno_PRA', length: 250 },
                { id: 'Ap_Materno_PRA', length: 250 },
                { id: 'InstitucionA', length: 250 },
                { id: 'CargoA', length: 250 }
            ]
            validateInputs(array)
        }
    })
});

document.getElementsByName('testigos').forEach(element => {
    element.addEventListener('change', () => {
        if (element.value === 'Si') {
            document.getElementById('div_testigos').style.display = 'block'
            const array = [
                { id: 'Nombre_TA_0', length: 250 },
                { id: 'Ap_Paterno_TA_0', length: 250 },
                { id: 'Ap_Materno_TA_0', length: 250 },
                { id: 'Nombre_TA_1', length: 250 },
                { id: 'Ap_Paterno_TA_1', length: 250 },
                { id: 'Ap_Materno_TA_1', length: 250 },
            ]
            validateInputs(array)
        } else if (element.value === 'No') {
            document.getElementById('div_testigos').style.display = 'none'
        }
    })
});