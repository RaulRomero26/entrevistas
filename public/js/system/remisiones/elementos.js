let selectedRowElementos = null;

const onFormElementosSubmit = () => {

    const campos = ['nombreElemento', 'noControlElemento', 'placaElemento', 'unidadElemento', 'cargoElemento', 'grupoElemento'];

    if (validateFormElementos(campos)) {
        let formData = readFormElemento(campos);
        if (selectedRowElementos === null)
            insertNewRowElemento(formData);
        else
            updateRowElemento(formData);

        resetFormElemento(campos);
    }

}

const insertNewRowElemento = ({ nombreElemento, noControlElemento, placaElemento, unidadElemento, cargoElemento, grupoElemento }, index, type) => {

    const table = document.getElementById('elementosParticipantes').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);

    newRow.insertCell(0).innerHTML = nombreElemento.toUpperCase();
    newRow.insertCell(1).innerHTML = noControlElemento;
    if (index === undefined) {
        if (newRow.rowIndex === 1) {
            newRow.insertCell(2).innerHTML = `
            <div class="form-check ml-5">
                <input class="form-check-input" type="radio" name="primerRespondienteCheck" value="${noControlElemento}" id="check-${noControlElemento}" checked>
                <label class="form-check-label" for="check-${noControlElemento}">
                </label>
            </div>
        `;
        } else {
            newRow.insertCell(2).innerHTML = `
            <div class="form-check ml-5">
                <input class="form-check-input" type="radio" name="primerRespondienteCheck" value="${noControlElemento}" id="check-${noControlElemento}">
                <label class="form-check-label" for="check-${noControlElemento}">
                </label>
            </div>
        `;
        }
    } else {
        if (index === '1') {
            newRow.insertCell(2).innerHTML = `
            <div class="form-check ml-5">
                <input class="form-check-input" type="radio" name="primerRespondienteCheck" value="${noControlElemento}" id="check-${noControlElemento}" checked>
                <label class="form-check-label" for="check-${noControlElemento}">
                </label>
            </div>
        `;
        } else {
            if (type != undefined) {
                newRow.insertCell(2).innerHTML = '';
            } else {
                newRow.insertCell(2).innerHTML = `
                    <div class="form-check ml-5">
                        <input class="form-check-input" type="radio" name="primerRespondienteCheck" value="${noControlElemento}" id="check-${noControlElemento}">
                        <label class="form-check-label" for="check-${noControlElemento}">
                        </label>
                    </div>
                `;
            }
        }
    }
    newRow.insertCell(3).innerHTML = placaElemento;
    newRow.insertCell(4).innerHTML = unidadElemento.toUpperCase();
    newRow.insertCell(5).innerHTML = cargoElemento.toUpperCase();
    newRow.insertCell(6).innerHTML = `
        <p class="mb-0">${grupoElemento}</p>
    `;
    if (type === undefined) {
        newRow.insertCell(7).innerHTML = `<button type="button" class="btn btn-primary" onclick="editElemento(this)"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
        </button>`;
        newRow.insertCell(8).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteRow(this,elementosParticipantes)">`;
    }

    let band = true;

    for (let i = 0; i < table.rows.length; i++) {
        if (i > 0 && table.rows[i].cells[6].childNodes[1].innerHTML != table.rows[i - 1].cells[6].childNodes[1].innerHTML) {
            band = false;
        }
    }

    if (!band) {
        for (let i = 0; i < table.rows.length; i++) {
            table.rows[i].cells[6].innerHTML = `
                <p class="mb-0">${table.rows[i].cells[6].childNodes[1].innerHTML}</p>
                <small class="form-text text-muted">En colaboración</small>
            `;
        }
    }

    // console.log(type);
}

const editElemento = (obj) => {

    document.getElementById('alertEditElemento').style.display = 'block';
    selectedRowElementos = obj.parentElement.parentElement;

    document.getElementById('nombreElemento').value = selectedRowElementos.cells[0].innerHTML;
    document.getElementById('noControlElemento').value = selectedRowElementos.cells[1].innerHTML;
    document.getElementById('placaElemento').value = selectedRowElementos.cells[3].innerHTML;
    document.getElementById('unidadElemento').value = selectedRowElementos.cells[4].innerHTML;
    document.getElementById('cargoElemento').value = selectedRowElementos.cells[5].innerHTML;
    document.getElementById('grupoElemento').value = selectedRowElementos.cells[6].childNodes[1].innerHTML;

}

const updateRowElemento = ({ noControlElemento, nombreElemento, placaElemento, unidadElemento, cargoElemento, grupoElemento }) => {

    const table = document.getElementById('elementosParticipantes').getElementsByTagName('tbody')[0];

    selectedRowElementos.cells[0].innerHTML = nombreElemento.toUpperCase();
    selectedRowElementos.cells[1].innerHTML = noControlElemento;
    selectedRowElementos.cells[3].innerHTML = placaElemento;
    selectedRowElementos.cells[4].innerHTML = unidadElemento;
    selectedRowElementos.cells[5].innerHTML = cargoElemento.toUpperCase();
    selectedRowElementos.cells[6].innerHTML = `
        <p class="mb-0">${grupoElemento}</p>
    `;

    let band = true;

    for (let i = 0; i < table.rows.length; i++) {
        if (i > 0 && table.rows[i].cells[6].childNodes[1].innerHTML != table.rows[i - 1].cells[6].childNodes[1].innerHTML) {
            band = false;
        }
    }

    if (!band) {
        for (let i = 0; i < table.rows.length; i++) {
            table.rows[i].cells[6].innerHTML = `
                <p class="mb-0">${table.rows[i].cells[6].childNodes[1].innerHTML}</p>
                <small class="form-text text-muted">En colaboración</small>
            `;
        }
    } else {
        for (let i = 0; i < table.rows.length; i++) {
            table.rows[i].cells[6].innerHTML = `
                <p class="mb-0">${table.rows[i].cells[6].childNodes[1].innerHTML}</p>
            `
        }
    }

    document.getElementById('alertEditElemento').style.display = 'none';

}

const readFormElemento = (campos) => {

    let formData = {}
    for (let i = 0; i < campos.length; i++) {
        formData[campos[i]] = document.getElementById(campos[i]).value;
    }

    return formData;

}

const resetFormElemento = (campos) => {

    for (let i = 0; i < campos.length; i++) {
        document.getElementById(campos[i]).value = '';
    }

    selectedRowElementos = null;

}

const validateFormElementos = (campos) => {

    let isValid = true;

    for (i = 0; i < campos.length; i++) {
        if (i != 2) {
            if (document.getElementById(campos[i]).value === "") {
                isValid = false;
                document.getElementById(campos[i] + '-invalid').style.display = 'block';
            } else {
                document.getElementById(campos[i] + '-invalid').style.display = 'none';
            }
        }
    }

    return isValid;

}