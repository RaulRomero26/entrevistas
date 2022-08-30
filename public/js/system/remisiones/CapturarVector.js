const zvUubicacionH = {
    'zona': document.getElementById('zona'),
    'vector': document.getElementById('VectorUH')
}

let myFormData = new FormData()

let getVector = (zonaDato, obj) => {
    if (zonaDato != null) {
        const cadAux = zonaDato.split(' ')
        const condicion = (cadAux[1] != 'HISTÓRICO' ? cadAux[1] : 'CH')

        myFormData.append('valor', condicion)
        fetch(base_url + 'getVector', {
                method: 'POST',
                body: myFormData
            })
            .then(res => res.json())
            .then(data => {
                $('#VectorUH').empty()
                let option = document.createElement("option");
                option.setAttribute('disabled', '')
                option.setAttribute('selected', '')
                option.value = ''
                option.text = 'SELECCIONE UNA OPCIÓN'
                zvUubicacionH.vector.add(option)
                for (let i = 0; i < data.length; i++) {
                    option = document.createElement("option");
                    option.value = data[i].Id_vector_Interno
                    option.text = data[i].Id_vector_Interno + ' - ' + data[i].Region
                    zvUubicacionH.vector.add(option)

                    if (obj != undefined) { if (option.value === obj) option.setAttribute('selected', '') }
                }
            })
    }
}

zvUubicacionH.zona.addEventListener('input', () => {
    getVector(zvUubicacionH.zona.value);
})