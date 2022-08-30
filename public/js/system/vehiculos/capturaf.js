const msg_capturaFotos = document.getElementById('msg_capturaFotos'),
    no_vehiculo = document.getElementById('no_vehiculo_'),
    pathImagesFH = base_url_js + `public/files/Vehiculos/${no_vehiculo.value}/Fotos/`;




console.log(pathImagesFH)
$(function() {
    $('[data-toggle="tooltip"]').tooltip()
})

/* ----- ----- ----- Dropzone ----- ----- ----- */
const dropzoneItems = ['parte_frontal', 'parte_posterior', 'costado_conductor', 'costado_copiloto'];
Dropzone.autoDiscover = false;
document.addEventListener('DOMContentLoaded', () => {
    dropzoneItems.forEach(item => {
        let tipo = item;
        new Dropzone(`#${item}`, {
            url: `${base_url_js}/Vehiculos/updateFotos`,
            dictDefaultMessage: `Cargar imagen ${tipo}`,
            acceptedFiles: '.png,.jpg,.jpeg,.PNG',
            addRemoveLinks: true,
            maxFiles: 1,
            maxThumbnailFilesize: 20,
            params: { 'captura_fyh': 'xd','id_vehiculo': no_vehiculo.value, 'tipo': tipo },
            dictRemoveFile: 'Eliminar archivo',
            init: function() {
                let myFormData = new FormData();

                myFormData.append('id_vehiculo', no_vehiculo.value);
                myFormData.append('tipo', tipo);

                fetch(base_url_js + '/Vehiculos/getFotos', {
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

                    msg_capturaFotos.innerHTML = messageError
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

                   

                    document.getElementById(`btn_${item}`).style.display = 'block';
    
                    file.name = resp.nameFile;
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
                document.getElementById(`btn_${item}`).style.display = 'none';

                myFormData.append('id_vehiculo', no_vehiculo.value);
                myFormData.append('deleteFile', file.name);
                myFormData.append('nameDir', nameDir[0]);
                myFormData.append('tipo', item);

                fetch(base_url_js + '/Vehiculos/deleteFotos', {
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

        myFormData.append('id_vehiculo', no_vehiculo.value);
        myFormData.append('tipo', item);
        myFormData.append('image', (document.getElementById(`serve_${item}`)) ? document.getElementById(`serve_${item}`).childNodes[1].childNodes[0].src : pathImagesFH);
        myFormData.append('new', (document.getElementById(`serve_${item}`)) ? true : false);

        fetch(base_url_js + '/Vehiculos/rotateImage', {
            method: 'POST',
            body: myFormData
        })
        .then(res => res.json())
        .then(data => {
            if(data.status){
                document.getElementById(item).childNodes[2].childNodes[1].childNodes[0].src = pathImagesFH+data.nameFile;
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

