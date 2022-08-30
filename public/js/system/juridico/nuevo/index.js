$(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
  
const data = document.getElementById('iph'),
    msgError = document.getElementById('message_error_iph'),
    id_puesta = document.getElementById('id_puesta').value,
    divDropzone = document.getElementById('dropzoneCroquis'),
    concluir = document.getElementById('btn_concluir');

document.getElementById('btn_puesta').addEventListener('click',(e)=>{
    e.preventDefault();

    const button = document.getElementById('btn_puesta');
    let myFormData = new FormData(data);
    let band = []

    let FV = new FormValidator()
    let i = 0;

    inputs.forEach(element =>{
        band[i++] = document.getElementById(`${element.id}_error`).innerText = FV.validate(myFormData.get(element.id), 'required');
    });

    band[i++] = fechaPuesta_error.innerText = FV.validate(myFormData.get('fecha_puesta'), 'required | date');

    let bandIdentificacion = false;

    checksIdentificacion.forEach(element=>{
        if(element.checked){
            bandIdentificacion = true;
        }
        if(element.checked && element.value === 'Otro'){
            band[i++] = document.getElementById('cual_identificacion_error').innerText = FV.validate(myFormData.get('cual_identificacion'), 'required | max_length[100]');
        }
    });

    if(!bandIdentificacion) band[i++] = document.getElementById('institucion_error').innerText = FV.validate(myFormData.get('institucion'), 'required');

    let bandEntero = false;
    checksEntero.forEach(element =>{
        if(element.checked){
            bandEntero = true;
        }
    })

    if(!bandEntero) band[i++] = document.getElementById('hecho_error').innerText = FV.validate(myFormData.get('hecho'), 'required');

    elementos.forEach(element=>{
        if(element.checked && element.value === 'Si'){
            band[i++] = document.getElementById('cuantos_identificacion_error').innerText = FV.validate(myFormData.get('cuantos_identificacion'), 'required | max_length[100]');
        }
    });

    priorizacionLugar.forEach(element=>{
        if(element.checked && element.value === 'Si'){
            band[i++] = document.getElementById('especifique_riesgo_error').innerText = FV.validate(myFormData.get('especifique_riesgo'), 'required | max_length[100]');
            if(riesgoPresentado[0].checked === false && riesgoPresentado[1].checked === false){
                band[i++] = document.getElementById('riesgo_presentado_error').innerText = FV.validate(myFormData.get('riesgo_presentado'), 'required');
            }
        }
    });

    let success = true
    band.forEach(element => {
        success &= (element == '') ? true : false
    });

    
    if(success){

        button.innerHTML = `
            Guardando
            <div class="spinner-grow spinner-grow-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        `;
        button.classList.add('disabled-link');

        myFormData.append('btn_iph', button.value);

        fetch(base_url_js+'Juridico/insertUpdatePuesta',{
            method: 'POST',
            body: myFormData
        })
        .then(res=>res.json())
        .then(data =>{
            console.log(data);
            button.innerHTML = `
                Guardar
            `;
            button.classList.remove('disabled-link');
            
            if(!data.status){
                let messageError;
                if ('error_message' in data) {
                    if (data.error_message != 'Render Index') {
                        if (typeof(data.error_message) != 'string') {
                            messageError = `<div class="alert alert-danger text-center" role="alert">Sucedio un error en el servidor: ${data.error_message.errorInfo[2]}</div>`;
                        } else {
                            messageError = `<div class="alert alert-danger text-center" role="alert">Sucedio un error en el servidor: ${data.error_message}</div>`;
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

                msgError.innerHTML = messageError
                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });
            }else{
                msgError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información almacenada correctamente.</div>'
                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });
                setInterval(function() { window.location = base_url_js+'Juridico/Puesta/'+id_puesta+'/ver'; }, 1000);
            }
        })
    }else{
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });

        msgError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>';
    }
});

if(concluir != null){
    concluir.addEventListener('click',()=>{
        if(window.confirm(`Esta seguro de concluir la puesta con registro ${id_puesta}, al realizar esta acción ya no se podrán realizar modificaciones.`)){
            let myFormData = new FormData;
        
            myFormData.append('id_puesta', id_puesta);
            myFormData.append('btn_conclu', 'xd');
        
            fetch(base_url_js+'Juridico/concluirPuesta',{
                method: 'POST',
                body: myFormData
            })
            .then(res=>res.json())
            .then(data =>{
                if(!data.status){
                    let messageError;
                    if ('error_message' in data) {
                        if (data.error_message != 'Render Index') {
                            if (typeof(data.error_message) != 'string') {
                                messageError = `<div class="alert alert-danger text-center" role="alert">Sucedio un error en el servidor: ${data.error_message.errorInfo[2]}</div>`;
                            } else {
                                messageError = `<div class="alert alert-danger text-center" role="alert">Sucedio un error en el servidor: ${data.error_message}</div>`;
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
    
                    msgError.innerHTML = messageError
                    window.scroll({
                        top: 0,
                        left: 100,
                        behavior: 'smooth'
                    });
                }else{
                    const elements = document.getElementsByClassName('condicion_concluido');
                    elements.forEach(element =>{
                        element.style.display = 'none';
                    });
            
                    msgError.innerHTML = `
                        <div class="alert alert-info text-center" role="alert">
                            La puesta ha sido concluida, las funciones de editar han sido deshabilitadas.
                        </div>
                    `;
                }
            });
        }
    })
}

Dropzone.autoDiscover = false;
document.addEventListener('DOMContentLoaded', ()=>{
    const dropzoneCroquis = new Dropzone('#dropzoneCroquis', {
        url: `${base_url_js}/Juridico/uploadCroquis`,
        dictDefaultMessage: `Da click ó arrastra la imagen`,
        acceptedFiles: '.png,.jpg,.jpeg,.PNG,.JPG',
        addRemoveLinks: true,
        maxFiles: 1,
        maxThumbnailFilesize: 20,
        params: { 'id_puesta': id_puesta, 'btn_croquis' : 'xd', 'file_name' : divDropzone.getAttribute('data-id')},
        dictRemoveFile: 'Eliminar archivo',
        init: function() {
            let myFormData = new FormData();

            myFormData.append('id_puesta', document.getElementById('id_puesta').value);

            fetch(base_url_js+'Juridico/getPuesta',{
                method: 'POST',
                body: myFormData
            })
            .then(res=>res.json())
            .then(data =>{
                if(data.lugarIntervencion.Path_Croquis != '' && data.lugarIntervencion.Path_Croquis != null && data.lugarIntervencion.Path_Croquis != undefined){
                    let imgPublic = {};
                    imgPublic.size = 1234;
                    imgPublic.name = data.lugarIntervencion.Path_Croquis;
    
                    this.options.addedfile.call(this, imgPublic);
                    this.options.thumbnail.call(this, imgPublic, `${base_url_js}public/files/Juridico/${id_puesta}/croquis/${data.lugarIntervencion.Path_Croquis}`);
    
                    imgPublic.previewElement.classList.add('dz-success');
                    imgPublic.previewElement.classList.add('dz-complete');
                    imgPublic.previewElement.classList.add('dz-complete');
                    imgPublic.previewElement.setAttribute('id', `serve_render`);
                    imgPublic.previewElement.childNodes[1].childNodes[0].classList.add('img-fluid');
                    divDropzone.setAttribute('data-id', data.lugarIntervencion.Path_Croquis);
                }
            });
        },
        accept: function(file, done){
            
            if(typeof(modo) != 'undefined' && modo){
                alert('Lo sentimos, no puede editar la imagen. Por favor cambiar a modo edición');
                file.previewElement.parentNode.removeChild(file.previewElement)
            }else{
                done();
            }
        },
        success: function(file, resp) {
            console.log(resp);
            resp = JSON.parse(resp);
            divDropzone.setAttribute('data-id', resp.nameFile);
            if(document.getElementById('serve_render')){
                let elem = document.getElementById(`serve_render`);
                elem.parentNode.removeChild(elem);
            }
            file.name = resp.nameFile;
        },
        maxfilesexceeded: function(file) {
            if (this.files[1] != null) {
                file.previewElement.parentNode.removeChild(file.previewElement);
                this.removeFile(this.files[0]);
                this.addFile(file);
            }
        },
        removedfile: function(file, resp) {
            if(typeof(modo) != 'undefined' && modo){
                alert('Lo sentimos, no puede eliminar la imagen. Por favor cambiar a modo edición');
            }else{
                file.previewElement.parentNode.removeChild(file.previewElement);

                let myFormData = new FormData();

                myFormData.append('btn_croquis', 'xd');
                myFormData.append('id_puesta', id_puesta);
                myFormData.append('name_file', divDropzone.getAttribute('data-id'));

                fetch(base_url_js + 'Juridico/deleteCroquisFile', {
                    method: 'POST',
                    body: myFormData
                })

                .then(res => res.text())
                .then(data => {
                    console.log(data);
                })
            }
        }
    })
});

const buttonSearch = document.getElementById('button_search'),
    elementSearch = document.getElementById('element_search'),
    listElementsSearch = document.getElementById('list_elements_search'),
    inputsElements = [
        {
            key: 'nombre',
            value: 'nombre_identificacion'
        },
        {
            key: 'paterno',
            value: 'apellido_p_identificacion'
        },
        {
            key: 'materno',
            value: 'apellido_m_identificacion'
        },
        {
            key: 'cargo',
            value: 'grado_identificacion'
        },
        {
            key: 'unidad',
            value: 'unidad_identificacion'
        },
        {
            key: 'control',
            value: 'num_control_identificacion'
        },
        {
            key: 'button',
            value: 'button_search'
        },
        {
            key: 'search',
            value: 'element_search'
        },
        {
            key: 'content',
            value: 'list_elements_search'
        }
    ];

buttonSearch.addEventListener('click', ()=>{
    buttonSearch.innerText = `Buscando`;
    buttonSearch.setAttribute('disabled', '');
    getPrimerRespondiente(elementSearch.value, inputsElements);
})

elementSearch.addEventListener('keypress', (e)=>{
    if(e.key === 'Enter'){
        buttonSearch.innerText = `Buscando`;
        buttonSearch.setAttribute('disabled', '');
        getPrimerRespondiente(elementSearch.value, inputsElements);
    }
})