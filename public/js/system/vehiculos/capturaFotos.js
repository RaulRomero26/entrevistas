//vars para Inspecciones
var id_img_inspeccion = 1;

function onloadCamera(apartado, obj) {

    const video = document.getElementById('video' + apartado),
        capture = document.getElementById('capture' + apartado),
        erroMessage = document.getElementById('errMsg' + apartado);

    const constraints = {
        audio: false,
        video: {
            width: 368,
            height: 368
        }
    };

    /* ----- ----- ----- Accediendo a la camara ----- ----- ----- */
    async function init() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia(constraints);
            handleSuccess(stream);
        } catch (e) {
            erroMessage.innerHTML = `<div class="alert alert-danger text-center" role="alert">Lo sentimos, ocurrio un error. <br> ${e}.</div>`;
        }
    }

    /* ----- ----- ----- Si es exitoso se inicia con la imagen ----- ----- ----- */
    function handleSuccess(stream) {
        window.stream = stream;
        video.srcObject = stream;
    }

    /* ----- ----- ----- Inicializamos la imagen ----- ----- ----- */
    init();

    capture.addEventListener("click", function() {

        const canvas = document.getElementById('canvas' + apartado);
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, 368, 368);

        /* ----- ----- ----- Index de la tabla de señas particulares ----- ----- ----- */
        if (obj != undefined) {
            canvas.removeAttribute('class');
            const id = obj.id;
            const index = id.charAt(id.length - 1);
            canvas.classList.add(index);
        }

        const btn = document.getElementById('add-photo' + apartado);
        btn.removeAttribute('disabled');

    });
}

const validateImage = (image) => {
    const size = image.files[0].size,
        allowedExtensions = /(.jpg|.jpeg|.png|.PNG)$/i;
    if (!allowedExtensions.exec(image.value)) {
        return false;
    }
    /* if(size > 8000000){
        return false;
    } */
    return true;
}

function uploadFile(event, type) {

    let file;
    if (type) {
        file = 'Photo';
    } else {
        file = 'File';
    }

    if (event.currentTarget.classList.contains('uploadFileFyH')) {
        if (validateImage(event.target)) {
            const src = URL.createObjectURL(event.target.files[0]),
                id = event.target.id;

            createElementFyH(src, id, file);
        } else {
            document.getElementById('msg_capturaFyH').innerHTML = '<div class="alert alert-warning text-center" role="alert">Verificar el archivo cargado.<br>Posibles errores: <br> - Archivo muy pesado (Máximo 8 megas). <br> -Extensión no aceptada (Extensiones aceptadas: jpeg, png, jpg, PNG).</div>';
            window.scroll({
                top: 0,
                left: 100,
                behavior: 'smooth'
            });
        }
    } else {
        if (event.currentTarget.classList.contains('uploadFileSenas')) {
            if (validateImage(event.target)) {
                const src = URL.createObjectURL(event.target.files[0]);
                const row = event.currentTarget;
                const index = row.parentNode.parentNode.parentNode.parentNode.rowIndex;
                createElementSena(src, index, 'File');
            } else {
                document.getElementById('msg_senasParticulares').innerHTML = '<div class="alert alert-warning text-center" role="alert">Verificar el archivo cargado.<br>Posibles errores: <br> - Archivo muy pesado (Máximo 8 megas). <br> -Extensión no aceptada (Extensiones aceptadas: jpeg, png, jpg, PNG).</div>';
                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });
            }
        } else {
            if (event.currentTarget.classList.contains('uploadFileInspecciones')) {
                //se inserta nueva imagen en arreglo de files para despues ser procesado por fetch
                imagesInspecciones.push({
                        'id': (id_img_inspeccion),
                        'file': (event.target.files[0])
                    })
                    //se crea img para div
                const src = URL.createObjectURL(event.target.files[0]);
                createElementInspecciones(src, id_img_inspeccion); //se manda la img y el id del ultimo item
                //se incrementa el id global de img inspecciones
                id_img_inspeccion++

            } else {
                if (event.currentTarget.classList.contains('uploadFileObjRecuperados')) {
                    if (validateImage(event.target)) {
                        const src = URL.createObjectURL(event.target.files[0]);
                        createElementObjRecuperados(src, true);
                    } else {
                        document.getElementById('msg_objRecuperados').innerHTML = '<div class="alert alert-warning text-center" role="alert">Verificar el archivo cargado.<br>Posibles errores: <br> - Archivo muy pesado (Máximo 8 megas). <br> -Extensión no aceptada (Extensiones aceptadas: jpeg, png, jpg, PNG).</div>';
                        window.scroll({
                            top: 0,
                            left: 100,
                            behavior: 'smooth'
                        });
                    }
                } else {
                    if (event.currentTarget.classList.contains('uploadFileSeguimiento')) {
                        if (validateImage(event.target)) {
                            const src = URL.createObjectURL(event.target.files[0]);

                            document.getElementById('msg_seguimientoPersona').innerHTML = '';
                            createElementSeguimientos(src, 'file');
                        } else {
                            document.getElementById('msg_seguimientoPersona').innerHTML = '<div class="alert alert-warning text-center" role="alert">Verificar el archivo cargado.<br>Posibles errores: <br> - Archivo muy pesado (Máximo 8 megas). <br> -Extensión no aceptada (Extensiones aceptadas: jpeg, png, jpg).</div>';
                            window.scroll({
                                top: 0,
                                left: 100,
                                behavior: 'smooth'
                            });
                        }
                    }
                }
            }
        }
    }

};

function uploadPhoto(apartado) {

    const canvas = document.getElementById('canvas' + apartado),
        src = canvas.toDataURL();

    if (apartado === 'fyh') {
        const tipo = document.getElementById('tipoFoto'),
            perfil = document.getElementById('perfilFoto');
        createElementFyH(src, tipo.value, perfil.value, 'Photo');
    } else {
        if (apartado === 'senas') {
            const index = canvas.classList.value;
            createElementSena(src, index, 'Photo');
            document.getElementById('fileSena_row' + index).value = "";
        } else {
            if (apartado === 'Inspecciones') {
                createElementInspecciones(src);
            } else {
                if (apartado === 'ObjRecuperados') {
                    createElementObjRecuperados(src, true);
                    document.getElementById('fileObjRecuperados').value = "";
                }
            }
        }
    }

    closeCamera(apartado);
}

function closeCamera(apartado) {
    /* ----- ----- ----- Detenemos la camara ----- ----- ----- */
    stream.getTracks().forEach(function(track) {
        track.stop();
    });

    $('#capturePhoto' + apartado).modal('hide');
}

function createElementFyH(src, id, type) {

    const img = document.getElementById(`img_${id}`),
        contentmaster = img.parentNode.parentNode.parentNode,
        content = contentmaster.childNodes[1],
        span = document.createElement('span'),
        iconDelete = document.createTextNode('x');


    img.src = src;
    img.setAttribute('data-id', type);

    if (type != 'Edit') {
        span.appendChild(iconDelete);
        span.setAttribute('class', 'deleteFile');
        span.setAttribute('onclick', `deleteFileFH(this)`);
        content.appendChild(span);
    }


    let descripcion = id.split('_');
    if (descripcion[1] === 'frente') {
        createElementMediaFilacion(src, descripcion[0], descripcion[1]);
    }
}

const deleteFileFH = (obj) => {

    const img = obj.parentNode.parentNode.childNodes[3].childNodes[3].childNodes[1];
    let descripcion = img.id.split('_');

    switch (descripcion[1]) {
        case 'rostro':
            switch (descripcion[2]) {
                case 'izquierdo':
                    img.src = `${base_url_js}public/media/images/siluetas/rostro_perfil_izquierdo.png`;
                    img.removeAttribute('data-id');
                    obj.parentNode.innerHTML = '';
                    break;
                case 'frente':
                    img.src = `${base_url_js}public/media/images/siluetas/rostro_perfil_frente.png`;
                    img.removeAttribute('data-id');
                    obj.parentNode.innerHTML = '';
                    break;
                case 'derecho':
                    img.src = `${base_url_js}public/media/images/siluetas/rostro_perfil_derecho.png`;
                    img.removeAttribute('data-id');
                    obj.parentNode.innerHTML = '';
                    break;
            }
            break;
        case 'cuerpo':
            switch (descripcion[2]) {
                case 'izquierdo':
                    img.src = `${base_url_js}public/media/images/siluetas/cuerpo_perfil_izquierdo.png`;
                    img.removeAttribute('data-id');
                    obj.parentNode.innerHTML = '';
                    break;
                case 'frente':
                    img.src = `${base_url_js}public/media/images/siluetas/cuerpo_perfil_frente.png`;
                    img.removeAttribute('data-id');
                    obj.parentNode.innerHTML = '';
                    break;
                case 'derecho':
                    img.src = `${base_url_js}public/media/images/siluetas/cuerpo_perfil_derecho.png`;
                    img.removeAttribute('data-id');
                    obj.parentNode.innerHTML = '';
                    break;
            }
            break;
    }

    /* const element = obj.parentNode.parentNode;
    element.remove();

    if(perfil === 'FRENTE'){

        elementMF = document.getElementById(tipo+'-MF');
        elementMF.remove();
    } */
}

const createElementMediaFilacion = (src, tipo, perfil) => {

    const tipoNode = document.createTextNode(tipo),
        newElement = document.createElement('div'),
        div = document.createElement('div'),
        content = document.getElementById('photosMF'),
        h5 = document.createElement('h5'),
        span = document.createElement('span'),
        img = document.createElement('img');

    h5.appendChild(tipoNode);
    h5.setAttribute('class', `elementFyH ${tipo}_${perfil}`);
    h5.appendChild(span);
    div.appendChild(h5);
    img.src = src;
    div.setAttribute('class', 'd-flex justify-content-between');
    img.setAttribute('class', 'img-fluid');
    newElement.appendChild(div);
    newElement.appendChild(img);
    newElement.setAttribute('class', 'col-sm-12 px-2');
    newElement.setAttribute('id', `${tipo}-MF`);
    content.appendChild(newElement);

}

function createElementSena(src, index, type, view) {
    const div = document.getElementById('imageContent_row' + index);

    if (view === undefined) {
        div.innerHTML = `
            <div>
                <div class="d-flex justify-content-end">
                    <span onclick="deleteImageSena(${index})" class="deleteFile">x</span>
                </div>
                <img class="img-fluid ${type}" id="images_row_${index}" width="100" src="${src}">
                <input type="hidden" class="${index} ${type}"/>
            </div>
        `;
    } else {
        div.innerHTML = `
            <div>
                <img class="img-fluid ${type}" id="images_row_${index}" width="100" src="${src}">
                <input type="hidden" class="${index} ${type}"/>
            </div>
        `;
    }
}

function deleteImageSena(index) {
    const div = document.getElementById('imageContent_row' + index);
    document.getElementById('fileSena_row' + index).value = '';

    div.innerHTML = '';
}

const createElementInspecciones = (src, id_item) => {
    const contenedor = document.getElementById('photos-content-inspecciones'),
        newElement = document.createElement('div'),
        div = document.createElement('div'),
        spanDelete = document.createElement('span'),
        iconDelete = document.createTextNode('x'),
        img = document.createElement('img'),
        file = document.getElementById('fileInspecciones');

    spanDelete.appendChild(iconDelete);
    spanDelete.setAttribute('onclick', 'deleteItemFromInspeccionesFiles(' + id_item + ')');
    spanDelete.setAttribute('class', 'deleteFile');
    div.appendChild(spanDelete);
    img.src = src;
    div.setAttribute('class', 'd-flex justify-content-end');
    img.setAttribute('class', 'img-fluid');
    newElement.appendChild(div);
    newElement.appendChild(img);
    newElement.setAttribute('class', 'col-sm-3 px-2');
    newElement.setAttribute('id', 'image' + id_item);
    contenedor.appendChild(newElement);
    file.value = '';
}

function deleteItemFromInspeccionesFiles(id_item) {
    document.getElementById('image' + id_item).remove()
    var ind = -1
        //se busca el index del elemento que continen el id especificado
    imagesInspecciones.forEach((element, index, array) => {
            if (element['id'] == id_item)
                ind = index
        })
        //se borra el item seleccionado de la lista de files de inspecciones
    imagesInspecciones.splice(ind, 1)
}

const createElementObjRecuperados = (src, newImg) => {
    const img = document.getElementById('image-obj-recuperados');
    if (newImg) {
        img.classList.add('new')
    }
    img.src = src;
}

const selectTipoBiometrico = () => {
    let tipo = document.getElementById('tipoBiometrico');
    document.getElementById('dedoContent').style.display = tipo.value != 'Mano' ? 'none' : 'block';
}