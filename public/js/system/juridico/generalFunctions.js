const validateInputs = (inputs) => {
    inputs.forEach(input => {
        const element = document.getElementById(input.id);
        const error = document.getElementById(`${input.id}_error`);
        element.addEventListener('input', () => {
            if (element.value.trim() !== '' && element.value.length <= input.length)
                error.textContent = ''
            else if (!(element.value.trim() !== ''))
                error.textContent = 'Campo requerido'
            else if ((element.value.length > input.length))
                error.textContent = 'Tamaño máximo: ' + input.length + ' caracteres'
        });
    });
};

const disableForm = (band, button, elements) => {
    elements.forEach(element => {
        if (element.type === 'input') {
            (band) ? document.getElementById(element.id).setAttribute('readonly', ''): document.getElementById(element.id).removeAttribute('readonly');
        }
        if (element.type === 'checkbox') {
            const checks = document.getElementsByName(element.id);
            checks.forEach(check => {
                check.disabled = band;
            })
        }
        if (element.type === 'select') {
            document.getElementById(element.id).disabled = band
        }
    });

    (band) ? button.style.display = 'none': button.style.display = 'block';
}

/*--------------------------FUNCIONES AUXILIARES----------------------------*/
/*valida fecha*/
const existeFecha = (fecha) => {
        let fechaf = fecha.split("-")
        let d = fechaf[2]
        let m = fechaf[1]
        let y = fechaf[0]
        return m > 0 && m < 13 && y > 0 && y < 32768 && d > 0 && d <= (new Date(y, m, 0)).getDate()
    }
    /*valida fecha*/
const existeHora = (hora) => {
    let horaH = hora.split(":")
    let hrs = horaH[0]
    let mins = horaH[1]
    return hrs >= 0 && hrs <= 23 && mins >= 0 && mins <= 59
}


document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[type=text]').forEach(node => node.addEventListener('keypress', e => {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    }))

    document.querySelectorAll('input[type=number]').forEach(node => node.addEventListener('keypress', e => {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    }))

    document.querySelectorAll('input[type=date]').forEach(node => node.addEventListener('keypress', e => {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    }))

    document.querySelectorAll('input[type=time]').forEach(node => node.addEventListener('keypress', e => {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    }))
});

const alerta = (id_puesta /*div_elemento*/ ) => {
    var opcion = confirm("El registro se agregó correctamente. ¿Desea agregar uno nuevo?");
    if (opcion == true) {
        console.log('Dijo que sí')
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });

    } else {
        window.location = base_url_js + "Juridico/Puesta/" + id_puesta + '/ver';
    }
}