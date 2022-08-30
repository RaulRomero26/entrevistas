let selectedRowSegCarPer = null;

const onFormSegCarPerSubmit = () =>{

    const campos = ['tatuajesSegPer','cicatricesSegPer','mutilacionesSegPer','lunaresSegPer'];
    let formData = readFormSegCarPer(campos);
    if(selectedRowSegCarPer === null)
        insertNewRowSegCarPer(formData);
    else
        updateRowSegCarPer(formData);

    resetFormSegCarPer(campos);
}

const insertNewRowSegCarPer = ({tatuajesSegPer,cicatricesSegPer,mutilacionesSegPer,lunaresSegPer}) =>{

    const table = document.getElementById('seguimientoCarPer').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);

    newRow.insertCell(0).innerHTML = tatuajesSegPer;
    newRow.insertCell(1).innerHTML = cicatricesSegPer;
    newRow.insertCell(2).innerHTML = mutilacionesSegPer;
    newRow.insertCell(3).innerHTML = lunaresSegPer;
    newRow.insertCell(4).innerHTML = `<button class="btn btn-primary" onclick="editSegCarPer(this)"> 
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
        </svg>
    </button>`;
    newRow.insertCell(5).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteRow(this,seguimientoCarPer)">`;
}

const editSegCarPer = (obj)=>{

    const campos = ['tatuajesSegPer','cicatricesSegPer','mutilacionesSegPer','lunaresSegPer'];

    selectedRowSegCarPer = obj.parentElement.parentElement;
    document.getElementById('tatuajesSegPer').value = selectedRowSegCarPer.cells[0].innerHTML;
    document.getElementById('cicatricesSegPer').value = selectedRowSegCarPer.cells[1].innerHTML;
    document.getElementById('mutilacionesSegPer').value = selectedRowSegCarPer.cells[2].innerHTML;
    document.getElementById('lunaresSegPer').value = selectedRowSegCarPer.cells[3].innerHTML;
    
}

const updateRowSegCarPer = ({tatuajesSegPer,cicatricesSegPer,mutilacionesSegPer,lunaresSegPer})=>{
        
    selectedRowSegCarPer.cells[0].innerHTML = tatuajesSegPer;
    selectedRowSegCarPer.cells[1].innerHTML = cicatricesSegPer;
    selectedRowSegCarPer.cells[2].innerHTML = mutilacionesSegPer;
    selectedRowSegCarPer.cells[3].innerHTML = lunaresSegPer;
}

const readFormSegCarPer = (campos)=>{

    let formData = {}
    for(let i=0; i<campos.length;i++){
        formData[campos[i]] = document.getElementById(campos[i]).value;
    }
    
    return formData;
}

const resetFormSegCarPer = (campos)=>{
    
    for(let i=0;i<campos.length;i++){
        document.getElementById(campos[i]).value='';
    }

    selectedRowSegCarPer = null;
}