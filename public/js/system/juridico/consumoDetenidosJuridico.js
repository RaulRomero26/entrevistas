
const button_detenidos       = document.getElementById('button-detenidos-juridico'),
    detenidos_content        = document.getElementById('detenidos-content'),
    detenidos_content_data   = document.getElementById('detenidos-content-data'),
    button_agregar_detenidos = document.getElementById('button-agregar-detenido'),
    check_detenidos          = document.getElementsByName('check_detenidos'),
    msgError                 = document.getElementById('feedback_detenidos');

window.onload = function() {
    getDetenidosJuridico(button_agregar_detenidos.getAttribute('data-id'));
}

button_detenidos.addEventListener('click', () => {
    if(detenidos_content.style.right === '' || detenidos_content.style.right === '-420px'){
        detenidos_content.style.right = '0px';
        detenidos_content.style.width = '400px';
        button_detenidos.innerHTML = `
            <img src="${base_url_js}public/media/icons/x.svg" alt="">
        `;
    }else{
        if(detenidos_content.style.right === '0px'){
            detenidos_content.style.right = '-420px';
            detenidos_content.style.width = '50px';
            button_detenidos.innerHTML = `
                <img src="${base_url_js}public/media/icons/detenidos.svg" alt="">
            `;
        }
    }
});

button_agregar_detenidos.addEventListener('click', ()=>{
    const modulo = button_agregar_detenidos.getAttribute('data-id');
    let detenidos = [];
    if(modulo === 'Remisiones'){
        check_detenidos.forEach(check=>{
            if(check.checked){
                const detenido = check.parentNode.childNodes[3].innerHTML;
                detenidos.push({
                    nombre : detenido,
                    id_detenido : check.id,
                    id_puesta : check.getAttribute('data-id-puesta')
                });
            }
        });
    }else{
        check_detenidos.forEach(check=>{
            if(check.checked){
                const detenido = check.parentNode.childNodes[3].innerHTML;
                    detenidos.push({
                        nombre : detenido,
                        id_detenido : check.id,
                        id_puesta : check.getAttribute('data-id-puesta')
                    }); 
                
            }
        })
    }

    if(detenidos.length === 0){
        window.alert('Por favor debe seleccionar al menos un elemento.');
        return;
    }

    let message;
    if(detenidos.length > 1){
        message = 'Se creara un registro para los detenidos ';
        detenidos.forEach(detenido=>{
            message += detenido.nombre+', ';
        });
        message += ' ¿Estas seguro?';
    }else{
        message = `Se creara un registro para el detenido ${detenidos[0].nombre}, ¿Estas seguro?`;
    }
    if(!window.confirm(message)){
        return;
    }

    let myFormData = new FormData;
    
    myFormData.append('detenidos', JSON.stringify(detenidos));

    fetch(base_url_js + `Juridico/create${modulo}`, {
        method: 'POST',
        body: myFormData
    })
    .then(res => res.json())
    .then(data => {
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
        }else{
            msgError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información almacenada correctamente.</div>';
            setTimeout(function() {
                location.reload();
            }, 1500);
        }
    })
})

const getDetenidosJuridico = (modulo) =>{
    let myFormData = new FormData;
    
    myFormData.append('modulo', modulo);

    fetch(base_url_js + 'Juridico/getDetenidosJuridico', {
        method: 'POST',
        body: myFormData
    })
    .then(res => res.json())
    .then(data => {
        const detenidos = data.data.detenidos;

        if(detenidos.length > 0 ){

            let html = '';
            
            detenidos.forEach((detenido, i) => {
                if(detenidos[i-1] === undefined){
                    html += `
                        <fieldset class="border p-3">
                            <legend>Puesta ${detenido.Id_Puesta}</legend>
                            <div class="custom-control custom-checkbox d-flex justify-content-between align-items-center my-2">
                                <div>
                                    <input type="checkbox" class="custom-control-input" name="check_detenidos" id="${detenido.Id_Detenido}" data-id-puesta="${detenido.Id_Puesta}">
                                    <label class="custom-control-label" for="${detenido.Id_Detenido}">${detenido.fullname.toUpperCase()}</label>
                                </div>
                                <button class="btn btn-danger btn-sm ml-3 d-flex justify-content-end" onclick="changeBitDetenido(this, ${detenido.Id_Detenido}, '${modulo}')">
                                    <img src="${base_url_js}public/media/icons/delete.svg" alt="">
                                </button>
                            </div>
                    `;
                    if(detenidos[i+1] === undefined || detenidos[i+1].Id_Puesta != detenido.Id_Puesta){
                        html += `
                            </fieldset>
                        `;
                    }
                }else{
                    if(detenidos[i-1].Id_Puesta === detenido.Id_Puesta){
                        html += `
                            <div class="custom-control custom-checkbox d-flex justify-content-between align-items-center my-2">
                                <div>
                                    <input type="checkbox" class="custom-control-input" name="check_detenidos" id="${detenido.Id_Detenido}" data-id-puesta="${detenido.Id_Puesta}">
                                    <label class="custom-control-label" for="${detenido.Id_Detenido}">${detenido.fullname.toUpperCase()}</label>
                                </div>
                                <button class="btn btn-danger btn-sm ml-3 d-flex justify-content-end" onclick="changeBitDetenido(this, ${detenido.Id_Detenido}, '${modulo}')">
                                    <img src="${base_url_js}public/media/icons/delete.svg" alt="">
                                </button>
                            </div>
                        `;
                        if(detenidos[i+1] === undefined || detenidos[i+1].Id_Puesta != detenido.Id_Puesta){
                            html += `
                                </fieldset>
                            `;
                        }
                    }else{
                        if(detenidos[i-1].Id_Puesta != detenido.Id_Puesta){
                            html += `
                                <fieldset class="border p-3">
                                    <legend>Puesta ${detenido.Id_Puesta}</legend>
                                    <div class="custom-control custom-checkbox d-flex justify-content-between align-items-center my-2">
                                        <div>
                                            <input type="checkbox" class="custom-control-input" name="check_detenidos" id="${detenido.Id_Detenido}" data-id-puesta="${detenido.Id_Puesta}">
                                            <label class="custom-control-label" for="${detenido.Id_Detenido}">${detenido.fullname.toUpperCase()}</label>
                                        </div>
                                        <button class="btn btn-danger btn-sm ml-3 d-flex justify-content-end" onclick="changeBitDetenido(this, ${detenido.Id_Detenido}, '${modulo}')">
                                            <img src="${base_url_js}public/media/icons/delete.svg" alt="">
                                        </button>
                                    </div>
                            `;
                            if(detenidos[i+1] === undefined || detenidos[i+1].Id_Puesta != detenido.Id_Puesta){
                                html += `
                                    </fieldset>
                                `;
                            }
                        }
                    }
                }
            });

            detenidos_content_data.innerHTML = html;
        }else{
            button_agregar_detenidos.style.display = 'none';
            msgError.innerHTML = '<div class="alert alert-info text-center" role="alert">No existen registros creados por Jurídico por el momento ó recargue la página más tarde.</div>';
        }
    });
}

detenidos_content_data.addEventListener('click', (e)=>{
    const modulo = button_agregar_detenidos.getAttribute('data-id');
    if(e.target.tagName.toLowerCase() === 'input'){
        const input = e.target;
        if(modulo === 'Remisiones'){
            check_detenidos.forEach(check=>{
                if(check.getAttribute('data-id-puesta') != input.getAttribute('data-id-puesta')){
                    check.checked = false;
                }
            });
        }else{
            check_detenidos.forEach(check=>{
                if(check != input){
                    check.checked = false;
                }
            })
        }
    }
})

const changeBitDetenido = (element, idDetenido, modulo)=>{

    if(!window.confirm(`¿Esta seguro de eliminar este elemento?`)){
        return;
    }

    let myFormData = new FormData;
    (modulo === 'Remisiones') ? modulo = 0 : modulo = 1;

    myFormData.append('id_detenido', idDetenido);
    myFormData.append('modulo', modulo);
    
    fetch(base_url_js + `Juridico/changeBitDetenido`, {
        method: 'POST',
        body: myFormData
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
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
        }else{
            element.parentNode.remove();
            msgError.innerHTML = '<div class="alert alert-success text-center" role="alert">Elemento eliminado correctamente.</div>';
            setTimeout(function() {
                location.reload();
            }, 1500);
        }
    })
}