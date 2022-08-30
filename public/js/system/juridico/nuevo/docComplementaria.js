const otro_check      = document.getElementById('otro_check'),
    button            = document.getElementById('doc_com_form_button'),
    data_doc_com      = document.getElementById('doc_com_form'),
    otro_especificacion_error = document.getElementById('otro_especificacion_error'),
    message_doc_com   = document.getElementById('message_docComp');

otro_check.addEventListener('change', ()=>{
    if(otro_check.checked){
        document.getElementById('especifique_content').style.display = 'block';
    }else{
        document.getElementById('especifique_content').style.display = 'none';
        document.getElementById('otro_especificacion').value = '';
    }
});

button.addEventListener('click', (e)=>{
    e.preventDefault();

    let myFormData = new FormData(data_doc_com);
    let band = []

    let FV = new FormValidator()
    let i = 0;

    if(otro_check.checked){
        band[i++] = otro_especificacion_error.innerText = FV.validate(myFormData.get('otro_especificacion'), 'required');
    }

    let success = true
    band.forEach(element => {
        success &= (element == '') ? true : false
    });

    if(success){

        myFormData.append('btn_doc', 'xd');
        myFormData.append('id_puesta', id_puesta);

        fetch(base_url_js + 'Juridico/uploadDocComplementaria', {
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

                message_doc_com.innerHTML = messageError
                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });
            }else{
                message_doc_com.innerHTML = '<div class="alert alert-success text-center" role="alert">Información almacenada correctamente.</div>'
                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });
                setInterval(function() { message_doc_com.innerHTML = '' }, 1000);
            }
        })
    }else{
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });

        message_doc_com.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario aaaa</div>';
    }
})