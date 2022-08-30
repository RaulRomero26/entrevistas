let selectedRowSegVehPer = null;

const onFormSegVehiculosSubmit = () =>{

    const campos = ['marcaVehiculoSegPer','modeloVehiculoSegPer','colorVehiculoSegPer','placaVehiculoSegPer'];
    let formData = readFormSegVehPer(campos);
    if(selectedRowSegVehPer === null)
        insertNewRowSegVehPer(formData);
    else
        updateRowSegVehPer(formData);

    resetFormSegVehPer(campos);
}

const insertNewRowSegVehPer = ({marcaVehiculoSegPer,modeloVehiculoSegPer,colorVehiculoSegPer,placaVehiculoSegPer}, type) =>{

    const table = document.getElementById('seguimientoVehiculosPer').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);

    newRow.insertCell(0).innerHTML = marcaVehiculoSegPer;
    newRow.insertCell(1).innerHTML = modeloVehiculoSegPer;
    newRow.insertCell(2).innerHTML = colorVehiculoSegPer;
    newRow.insertCell(3).innerHTML = placaVehiculoSegPer;
    if(type != 'view'){
        newRow.insertCell(4).innerHTML = `<button class="btn btn-primary" onclick="editSegVehPer(this)"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
        </button>`;
        newRow.insertCell(5).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteRow(this,seguimientoVehiculosPer)">`;
    }
}

const editSegVehPer = (obj)=>{

    document.getElementById('alertEditVehiculoSP').style.display = 'block';

    const campos = ['marcaVehiculoSegPer','modeloVehiculoSegPer','colorVehiculoSegPer','placaVehiculoSegPer'];

    selectedRowSegVehPer = obj.parentElement.parentElement;
    document.getElementById('marcaVehiculoSegPer').value = selectedRowSegVehPer.cells[0].innerHTML;
    document.getElementById('modeloVehiculoSegPer').value = selectedRowSegVehPer.cells[1].innerHTML;
    document.getElementById('colorVehiculoSegPer').value = selectedRowSegVehPer.cells[2].innerHTML;
    document.getElementById('placaVehiculoSegPer').value = selectedRowSegVehPer.cells[3].innerHTML;
    
}

const updateRowSegVehPer = ({marcaVehiculoSegPer,modeloVehiculoSegPer,colorVehiculoSegPer,placaVehiculoSegPer})=>{
        
    selectedRowSegVehPer.cells[0].innerHTML = marcaVehiculoSegPer.toUpperCase();
    selectedRowSegVehPer.cells[1].innerHTML = modeloVehiculoSegPer.toUpperCase();
    selectedRowSegVehPer.cells[2].innerHTML = colorVehiculoSegPer.toUpperCase();
    selectedRowSegVehPer.cells[3].innerHTML = placaVehiculoSegPer.toUpperCase();


    document.getElementById('alertEditVehiculoSP').style.display = 'none';

}

const readFormSegVehPer = (campos)=>{

    let formData = {}
    for(let i=0; i<campos.length;i++){
        formData[campos[i]] = document.getElementById(campos[i]).value;
/*
        $("#seguimientoVehiculosPer").ready(function(event) {
            var formData = this.value;
            if (formData != "") {
                    console.log(formData);

                    var myObjString = JSON.stringify(formData);

                    console.log(myObjString);
                $('<div class="chip"> ' + myObjString + ' <span class="closebtn" >&times;</span></div>').appendTo('#guardaDatos');
                $("#seguimientoVehiculosPer").val(null);

            
            //console.log(document.getElementById('contenido').childNodes[0].innerText)
    }
});
*/
    }

/*
    $("#seguimientoVehiculosPer").keyup(function(event) {
    var data = this.value;
    if (data != "") {

        if (event.keyCode === 13) {
            $('<div class="chip"> ' + data + ' <span class="closebtn" >&times;</span></div>').appendTo('#contenido');
            $("#seguimientoVehiculosPer").val(null);

            
        }

            //console.log(document.getElementById('contenido').childNodes[0].innerText)
    }
});
   */
   var myObjString = JSON.stringify(formData);

   console.log(myObjString);
   console.log(formData);
    return formData;

}

const resetFormSegVehPer = (campos)=>{
    
    for(let i=0;i<campos.length;i++){
        document.getElementById(campos[i]).value='';
    }

    selectedRowSegVehPer = null;

}

/* ----- ----- ----- Funciones reutilizables ----- ----- ----- */

const deleteRow = (obj,tableId)=>{

    if(confirm('¿Desea eliminar este elemento?')){
        const row = obj.parentElement.parentElement;
        document.getElementById(tableId.id).deleteRow(row.rowIndex);
    }

}