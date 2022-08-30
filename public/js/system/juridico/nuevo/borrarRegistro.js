

const borrarRegistro = async(anexo,id_registro) =>{
    if(['A','B','C','D1','D2','E','F'].includes(anexo) && parseInt(id_registro) > 0){
        if(confirm('¿Desea eliminar permanentemente este registro?')){
            // const data = {
            //     'Anexo'       : anexo,
            //     'Id_Registro' : id_registro
            // }
            const myForm = new FormData();
            myForm.append('Anexo',anexo);
            myForm.append('Id_Registro',id_registro);
            const request = await fetch(base_url_js+'Juridico/deleteAnexo',{
                method: 'POST',
                body: myForm
            });

            const response = await request.json();

            switch (response.resp_case) {
                case 'error_interno': //error de petición
                case 'error_post': //error de petición
                case 'error_db': //error de base de datos
                    break;
                case 'error_session': //error de sesión
                    const alert = document.querySelector('#message_error_iph');
                        alert.innerHTML = ` <div class="alert alert-danger text-center" role="alert">
                                                <p>Sucedio un error, su sesión caduco o no tiene los permisos necesarios. Por favor vuelva a iniciar sesión.</p>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalLogin">
                                                    Iniciar sesión
                                                </button>
                                            </div>`;
                    break;
                case 'success': // borrarlo del DOM
                    const itemToRemove = document.querySelector('#'+anexo+'_'+id_registro);
                    itemToRemove.parentNode.removeChild(itemToRemove);
                    const divider = document.querySelector('#div_'+anexo+'_'+id_registro);
                    divider.parentNode.removeChild(divider);
                    // quitar el alert de inicio de sesión en caso de que haya uno
                    const alert2 = document.querySelector('#message_error_iph');
                        alert2.innerHTML = ``;
                    break;
            }
            console.log(response);

        } 
    }
}