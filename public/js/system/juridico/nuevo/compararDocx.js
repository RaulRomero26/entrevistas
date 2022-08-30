const dropzoneItems = ['dropzone_file1', 'dropzone_file2'],
    msgFilesCompara = document.getElementById('message_file'),
    btnCompareFile  = document.getElementById('btn_compareFile'),
    primerFile      = document.getElementById('dropzone_file1'),
    segundoFile     = document.getElementById('dropzone_file2');

Dropzone.autoDiscover = false;
let drop1, drop2;
document.addEventListener('DOMContentLoaded', () => {
    dropzoneItems.forEach((item,i) => {
        let doc = (i===0) ? 'primer' : 'segundo';
        item = new Dropzone(`#${item}`, {
            url: `${base_url_js}Juridico/uploadFileCompare`,
            dictDefaultMessage: `Cargar ${doc} documento`,
            acceptedFiles: '.doc,.docx',
            addRemoveLinks: true,
            maxFiles: 1,
            params: {'file' : doc , 'data_save': 'xd'},
            maxThumbnailFilesize: 20,
            dictRemoveFile: 'Eliminar archivo',
            accept: function(file, done) {
                if(this.files.length==1){
                    done();
                }
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
                    msgFilesCompara.innerHTML = `<div class="alert alert-success text-center" role="alert">Documento cargado con éxito</div>`;
                    setTimeout(function() {
                        msgFilesCompara.innerHTML = ``;
                    }, 1500);

                    file.previewElement.parentNode.setAttribute('data-name',resp.file_name);
                }
            },
            maxfilesexceeded: function(file) {
                if(this.files.length>1){
                    msgFilesCompara.innerHTML = `<div class="alert alert-danger text-center" role="alert">No se pueden agregar 2 archivos</div>`;
                    setTimeout(function() {
                        msgFilesCompara.innerHTML = ``;
                    }, 1500);
                    file.previewElement.parentNode.removeChild(file.previewElement);
                    this.removeFile(this.files[1]);
                }
            },
            removedfile: function(file, resp) {
                
                let myFormData = new FormData();
                
                myFormData.append('name_file', file.previewElement.parentNode.getAttribute('data-name'));

                fetch(base_url_js + 'Juridico/removeFileCompare', {
                    method: 'POST',
                    body: myFormData
                })
                
                .then(res => res.json())
                .then(data => {
                    if(data){
                        file.previewElement.parentNode.removeAttribute('data-name')
                        file.previewElement.parentNode.removeChild(file.previewElement);
                    }
                })
            }
        })
    })
});

btnCompareFile.addEventListener('click', ()=>{
    if(primerFile.getAttribute('data-name') != null && segundoFile.getAttribute('data-name') != null){
        let myFormData = new FormData();
                
        myFormData.append('primer_file', primerFile.getAttribute('data-name'));
        myFormData.append('segundo_file', segundoFile.getAttribute('data-name'));
        myFormData.append('data_save', 'xd');

        fetch(base_url_js + 'Juridico/compareDocx', {
            method: 'POST',
            body: myFormData
        })
        
        .then(res => res.json())
        .then(data => {
            console.log(data);
            if(data){
                msgFilesCompara.innerHTML = `<div class="alert alert-info text-center" role="alert">Los documentos coinciden</div>`;
            }else{
                msgFilesCompara.innerHTML = `<div class="alert alert-info text-center" role="alert">Los documentos NO coinciden</div>`;
            }
            setTimeout(function() {
                msgFilesCompara.innerHTML = ``;
                Dropzone.forElement('#dropzone_file1').removeFile(Dropzone.forElement('#dropzone_file1').files[0]);
                Dropzone.forElement('#dropzone_file2').removeFile(Dropzone.forElement('#dropzone_file2').files[0]);
            }, 5000);
            
            //console.log(Dropzone.forElement('#dropzone_file1').files[0]);
        })
    }else{
    }
})