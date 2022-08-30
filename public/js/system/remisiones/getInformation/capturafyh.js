const dataCapturaFyH = document.getElementById('data_capturaFyH'),
    msg_capturaFyF = document.getElementById('msg_capturaFyH'),
    no_remision_fyh = document.getElementById('no_remision_capturaFyH'),
    no_ficha_fyh = document.getElementById('no_ficha_capturaFyH'),
    pathImagesFH = pathFilesRemisiones + `${no_ficha_fyh.value}/FotosHuellas/${no_remision_fyh.value}/`;


const collapse_one = document.getElementById('collapse_one');
const collapse_two = document.getElementById('collapse_two');

const collapse_one_1 = document.getElementById('collapse_one_1');
const collapse_two_1 = document.getElementById('collapse_two_1');

const button_panel = document.getElementById("button_panel");
const button_huellas = document.getElementById("btn_huellas");
const loader = document.getElementById("loader");
const tabla = document.getElementById("tabla");
const tbody_coincidencias = document.getElementById('tbody_coincidencias');
const NotFound = document.getElementById("NotFound");

const button_panel_iris = document.getElementById("button_panel_iris");
const button_iris = document.getElementById("btn_iris");
const loader_iris = document.getElementById("loader_iris");
const tabla_iris = document.getElementById("tabla_iris");
const tbody_coincidencias_iris = document.getElementById('tbody_coincidencias_iris');
const NotFound_iris = document.getElementById("NotFound_iris");

collapse_two.disabled = true;

button_panel.style.display = 'none'
loader.style.display = 'none'
tabla.style.display = 'none'
NotFound.style.display = 'none'



$(function() {
    $('[data-toggle="tooltip"]').tooltip()
})

/* ----- ----- ----- Dropzone ----- ----- ----- */
const dropzoneItems = ['rostro_izquierdo', 'rostro_frente', 'rostro_derecho', 'cuerpo_izquierdo', 'cuerpo_frente', 'cuerpo_derecho'];
Dropzone.autoDiscover = false;
document.addEventListener('DOMContentLoaded', () => {
    dropzoneItems.forEach(item => {
        let tipo = item.split('_');
        new Dropzone(`#${item}`, {
            url: `${base_url}updateFotosHuellas`,
            dictDefaultMessage: `Cargar imagen ${tipo[0]} ${tipo[1]}`,
            acceptedFiles: '.png,.jpg,.jpeg,.PNG',
            addRemoveLinks: true,
            maxFiles: 1,
            maxThumbnailFilesize: 20,
            params: { 'captura_fyh': 'xd', 'ficha': no_ficha_fyh.value, 'remision': no_remision_fyh.value, 'perfil': item },
            dictRemoveFile: 'Eliminar archivo',
            init: function() {
                let myFormData = new FormData();

                myFormData.append('remision', no_remision_fyh.value);
                myFormData.append('perfil', item);

                fetch(base_url + 'getFotosHuellas', {
                    method: 'POST',
                    body: myFormData
                })

                .then(res => res.json())
                .then(data => {
                    //console.log(data);
                    if(data.status){
                        if(data.foto != false){
                            let imgPublic = {};
                            imgPublic.size = 1234;
                            imgPublic.name = data.foto.Path_Imagen;

                            this.options.addedfile.call(this, imgPublic);
                            this.options.thumbnail.call(this, imgPublic, `${pathImagesFH}${data.foto.Path_Imagen}`);

                            imgPublic.previewElement.classList.add('dz-success');
                            imgPublic.previewElement.classList.add('dz-complete');
                            imgPublic.previewElement.setAttribute('id', `serve_${item}`);
                            document.getElementById(`input_${item}`).value = data.foto.Path_Imagen;
                            document.getElementById(`btn_${item}`).style.display = 'block';

                            if(item === 'rostro_frente' || item === 'cuerpo_frente'){
                                document.getElementById(`${item}_media`).src = pathImagesFH+data.foto.Path_Imagen;
                            }
                        }
                    }
                })
            },
            success: function(file, resp) {
                //console.log(resp);
                resp = JSON.parse(resp);
                if (!resp.status) {
                    if ('error_message' in resp) {
                        if (resp.error_message != 'Render Index') {
                            if (typeof(resp.error_message) != 'string') {
                                messageError = `<div class="alert alert-danger text-center" role="alert">Sucedio un error en el servidor: ${resp.error_message.errorInfo[2]}</div>`;
                            } else {
                                messageError = `<div class="alert alert-danger text-center" role="alert">Sucedio un error en el servidor: ${resp.error_message}</div>`;
                            }
                        } else {
                            messageError = `<div class="alert alert-danger text-center alert-session-create" role="alert">
                                    <p>Sucedio un error, su sesión caduco o no tiene los permisos necesarios. Por favor vuelva a iniciar sesión.</p>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalLogin">
                                        Iniciar sesión
                                    </button>
                                </div>`;
                        }
                    } else {
                        messageError = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>'
                    }

                    msg_capturaFyF.innerHTML = messageError
                    window.scroll({
                        top: 0,
                        left: 100,
                        behavior: 'smooth'
                    });
                } else {
                    if (document.getElementById(`serve_${item}`)) {
                        let elem = document.getElementById(`serve_${item}`);

                        elem.parentNode.removeChild(elem);
                    }
                    document.getElementById(`message_${item}`).innerText = '';
                    document.getElementById(`input_${item}`).value = resp.nameFile;
                    document.getElementById(item).childNodes[2].childNodes[1].childNodes[0].src = pathImagesFH+resp.nameFile;

                    if(item === 'rostro_frente' || item === 'cuerpo_frente'){
                        document.getElementById(`${item}_media`).src = pathImagesFH+resp.nameFile;
                    }

                    document.getElementById(`btn_${item}`).style.display = 'block';
    
                    file.name = resp.nameFile;
                    getTabsGuardados();
                }
            },
            maxfilesexceeded: function(file) {
                //console.log(file);
                if (this.files[1] != null) {
                    file.previewElement.parentNode.removeChild(file.previewElement);
                    this.removeFile(this.files[0]);
                    this.addFile(file);
                }
            },
            removedfile: function(file, resp) {
                file.previewElement.parentNode.removeChild(file.previewElement);

                let myFormData = new FormData();
                let nameDir = document.getElementById(`input_${item}`).value.split('?');

                if(item === 'rostro_frente' || item === 'cuerpo_frente'){
                    document.getElementById(`${item}_media`).src = '';
                }

                document.getElementById(`btn_${item}`).style.display = 'none';

                myFormData.append('remision', no_remision_fyh.value);
                myFormData.append('deleteFile', file.name);
                myFormData.append('ficha', no_ficha_fyh.value);
                myFormData.append('nameDir', nameDir[0]);
                myFormData.append('perfil', item);

                fetch(base_url + 'deleteFotosHuellas', {
                    method: 'POST',
                    body: myFormData
                })

                .then(res => res.text())
                    .then(data => {
                        //console.log(data);
                    })
            }
        })
    })
})

dropzoneItems.forEach(item=>{
    document.getElementById(`btn_${item}`).addEventListener('click', ()=>{

        let myFormData = new FormData();

        myFormData.append('remision', no_remision_fyh.value);
        myFormData.append('ficha', no_ficha_fyh.value);
        myFormData.append('perfil', item);
        myFormData.append('image', (document.getElementById(`serve_${item}`)) ? document.getElementById(`serve_${item}`).childNodes[1].childNodes[0].src : pathImagesFH);
        myFormData.append('new', (document.getElementById(`serve_${item}`)) ? true : false);

        fetch(base_url + 'rotateImage', {
            method: 'POST',
            body: myFormData
        })
        .then(res => res.json())
        .then(data => {
            if(data.status){
                document.getElementById(item).childNodes[2].childNodes[1].childNodes[0].src = pathImagesFH+data.nameFile;
                if(item === 'rostro_frente' || item === 'cuerpo_frente'){
                    document.getElementById(`${item}_media`).src = pathImagesFH+data.nameFile;
                }
            }
        })
    });
})

const toDataURL = url => fetch(url)
    .then(res => res.blob())
    .then(blob => new Promise((resolve, reject) => {
        const reader = new FileReader()
        reader.onloadend = () => resolve(reader.result)
        reader.onerror = reject
        reader.readAsDataURL(blob)
    }))


const getHuellas = async() => {
    var myFormData = new FormData()
    myFormData.append('no_remision', no_remision_fyh.value)

    const response = await fetch(base_url_js + 'Remisiones/openImgFromFTP', {
        method: 'POST',
        body: myFormData
    })
    const data = await response.json()
        //console.log(data)
    if (data.status_PathExist === true) {
        collapse_two.disabled = false;
        document.getElementById('CapturaHuellas').innerText = 'Volver a capturar';
        document.getElementById('finger_1').src = data.LeftIndexFinger
        document.getElementById('finger_2').src = data.LeftMiddleFinger
        document.getElementById('finger_3').src = data.LeftRingFinger
        document.getElementById('finger_4').src = data.LeftLittle
        document.getElementById('finger_5').src = data.RightIndexFinger

        document.getElementById('finger_6').src = data.RightMiddleFinger
        document.getElementById('finger_7').src = data.RightRingFinger
        document.getElementById('finger_8').src = data.RightLittle
        document.getElementById('finger_9').src = data.LeftThumb
        document.getElementById('finger_10').src = data.RightThumb
    } else {
        collapse_two.disabled = true;
        document.getElementById('CapturaHuellas').innerText = 'Iniciar captura de huellas';
    }
}

document.getElementById('RefreshImg').addEventListener('click', () => {
    getHuellas();
})

let buscarCoincidencias = async() => {
    loader.style.display = 'block'
    button_panel.style.display = 'none'
    tabla.style.display = 'none'
    const remision = document.getElementById('no_remision_principales').value
    const ficha = document.getElementById('no_ficha_principales').value

    var myform = new FormData()
    myform.append("no_remision", remision)

    const response = await fetch(base_url_js + 'Remisiones/getHuellasAPI', {
        method: 'POST',
        body: myform
    })
    const data = await response.json()

    if (data.success) { //con resultados
        loader.style.display = 'none'
        button_panel.style.display = 'block'
        button_huellas.textContent = "Reiniciar búsqueda"
        NotFound.style.display = 'none'
        tabla.style.display = 'block'
        tbody_coincidencias.innerHTML = ""
        var tbody_dinamic = ""

        data.coincidencias.forEach((elem, index, arreglo) => {
            var imgNameAux = base_url_js + 'public/files/Remisiones/' + elem.no_ficha + '/FotosHuellas/' + elem.no_remision + '/ROSTRO_FRENTE.jpeg';
            var img = new Image();
            img.src = imgNameAux
            if (img.height == 0)
                imgNameAux = base_url_js + 'public/files/Remisiones/' + elem.no_ficha + '/FotosHuellas/' + elem.no_remision + '/ROSTRO_FRENTE.png';


            tbody_dinamic += '<tr>' +
                '<td class="v-a-middle">' + elem.no_remision + '</td>' +
                '<td class="v-a-middle">' + elem.nombre_detenido + '</td>' +
                '<td class="v-a-middle">' + elem.fecha_detenido + '</td>' +
                '<td class="v-a-middle">' + elem.score_match + '</td>' +
                '<td class="v-a-middle">' +
                '<img src="' + imgNameAux + '" class="my-cfh-width"' +
                +'</td>' +
                '<tr>'
        })
        tbody_coincidencias.innerHTML = tbody_dinamic
    } else { //sin resultados
        loader.style.display = 'none'
        button_panel.style.display = 'block'
        button_huellas.textContent = "Reiniciar búsqueda"
        NotFound.style.display = 'block'
    }
}


const getStatusIris = async() => {
    var myFormData = new FormData()
    myFormData.append('no_remision', no_remision_fyh.value)

    const response = await fetch(base_url_js + 'Remisiones/getStatusIris', {
        method: 'POST',
        body: myFormData
    })
    const data = await response.json()
        //console.log(data)
    if (data === false) {
        document.getElementById('status_res').innerText = 'No capturado'
        document.getElementById('CapturaIris').innerText = 'Iniciar captura de Iris'
        document.getElementById('img_1').src = base_url_js + 'public/media/icons/eye.png'
        document.getElementById('img_2').src = base_url_js + 'public/media/icons/eye.png'

    } else {
        document.getElementById('status_res').innerText = 'Capturado'
        document.getElementById('img_1').src = base_url_js + 'public/media/icons/eye_after.png'
        document.getElementById('img_2').src = base_url_js + 'public/media/icons/eye_after.png'
        document.getElementById('CapturaIris').innerText = 'Volver a capturar'

    }
}


document.getElementById('RefreshImgIris').addEventListener('click', () => {
    getStatusIris();
})

collapse_two.addEventListener("click", buscarCoincidencias)
button_huellas.addEventListener("click", buscarCoincidencias)




let buscarCoincidenciasIris = async() => {
    loader_iris.style.display = 'block'
    button_panel_iris.style.display = 'none'
    tabla_iris.style.display = 'none'
    const remision = document.getElementById('no_remision_principales').value
    const ficha = document.getElementById('no_ficha_principales').value

    var myform = new FormData()
    myform.append("no_remision", remision)

    const response = await fetch(base_url_js + 'Remisiones/getIrisAPI', {
        method: 'POST',
        body: myform
    })
    const data = await response.json()

    //console.log(data)

    if (data.success) { //con resultados
        loader_iris.style.display = 'none'
        button_panel_iris.style.display = 'block'
        button_iris.textContent = "Reiniciar búsqueda"
        NotFound_iris.style.display = 'none'
        tabla_iris.style.display = 'block'
        tbody_coincidencias_iris.innerHTML = ""
        var tbody_dinamic = ""

        data.coincidencias.forEach((elem, index, arreglo) => {
            var imgNameAux = base_url_js + 'public/files/Remisiones/' + elem.no_ficha + '/FotosHuellas/' + elem.no_remision + '/ROSTRO_FRENTE.jpeg';
            var img = new Image();
            img.src = imgNameAux
            if (img.height == 0)
                imgNameAux = base_url_js + 'public/files/Remisiones/' + elem.no_ficha + '/FotosHuellas/' + elem.no_remision + '/ROSTRO_FRENTE.png';


            tbody_dinamic += '<tr>' +
                '<td class="v-a-middle">' + elem.no_remision + '</td>' +
                '<td class="v-a-middle">' + elem.nombre_detenido + '</td>' +
                '<td class="v-a-middle">' + elem.fecha_detenido + '</td>' +
                '<td class="v-a-middle">' +
                '<img src="' + imgNameAux + '" class="my-cfh-width"' +
                +'</td>' +
                '<tr>'
        })
        tbody_coincidencias_iris.innerHTML = tbody_dinamic
    } else { //sin resultados
        loader_iris.style.display = 'none'
        button_panel_iris.style.display = 'block'
        button_iris.textContent = "Reiniciar búsqueda"
        NotFound_iris.style.display = 'block'
    }
}

collapse_two_1.addEventListener("click", buscarCoincidenciasIris)
button_iris.addEventListener("click", buscarCoincidenciasIris)