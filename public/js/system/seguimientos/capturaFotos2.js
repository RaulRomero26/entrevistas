function uploadFile2(event) 
{
    if(event.currentTarget.classList.contains('uploadFileSeguimiento2'))
    {
        if(validateImage(event.target)){
            const src = URL.createObjectURL(event.target.files[0]);
                
                document.getElementById('msg_seguimientoVehiculo').innerHTML = '';
            createElementSeguimientos2(src, 'file');
        }else{
            document.getElementById('msg_seguimientoVehiculo').innerHTML = '<div class="alert alert-warning text-center" role="alert">Verificar el archivo cargado.<br>Posibles errores: <br> - Archivo muy pesado (Máximo 8 megas). <br> -Extensión no aceptada (Extensiones aceptadas: jpeg, png, jpg).</div>';
            window.scroll({
                top: 0,
                left: 100,
                behavior: 'smooth'
            });
        }
    }
};

function deleteFile2(obj)
{
    const index = obj.parentNode.parentNode.parentNode.parentNode.rowIndex;
    const element = obj.parentNode.parentNode;
    element.remove();
}

const createElementSeguimientos2 = (src, type, name)=>{
    const contenedor = document.getElementById('photos-content-seguimientos2'),
        newElement = document.createElement('div'),
        div = document.createElement('div'),
        spanDelete = document.createElement('span'),
        iconDelete = document.createTextNode('x'),
        img = document.createElement('img'),
        file = document.getElementById('fileSeguimiento2');
    if(name != 'VER'){
        spanDelete.appendChild(iconDelete);
        spanDelete.setAttribute('onclick','deleteFile2(this)');
        spanDelete.setAttribute('class','deleteFile2');
    }
    div.appendChild(spanDelete);
    img.src = src;
    div.setAttribute('class','d-flex justify-content-end');
    img.setAttribute('class',`img-fluid imagenSV ${name}`);
    newElement.appendChild(div);
    newElement.appendChild(img);
    if(type === 'file'){
        let day = new Date();
        const inputFile = file.cloneNode(true);
        inputFile.setAttribute('class', 'new_input_data');
        inputFile.setAttribute('style', 'display:none');
        inputFile.setAttribute('name', `image_${Date.parse(day)}`);
        inputFile.setAttribute('class', 'imagenSV');
        newElement.appendChild(inputFile);    
    }
    newElement.setAttribute('class','col-sm-3 px-2');
    contenedor.appendChild(newElement);
    if(type === 'file'){
        file.value='';
    }
}

const validateImage = (image)=>{
    const size = image.files[0].size,
        allowedExtensions = /(.jpg|.jpeg|.png|.PNG)$/i;
    if(!allowedExtensions.exec(image.value)){
        return false;
    }
    return true;
}

const uploadFileCDI = (obj)=>{
    const name = obj.target.files[0].name,
        content = document.getElementById('fileCDIResult');

    content.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
            <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
            <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
            <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
        </svg>
        <p class="text-center">${name}</p>
    `;
}