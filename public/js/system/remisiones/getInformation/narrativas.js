const dataNarrativas = document.getElementById('data_narrativas'),
    narrativaPeticionarioError = document.getElementById('narrativaPeticionario_error'),
    narrativaElementosError = document.getElementById('narrativaElementos_error'),
    narrativaDetenidoError = document.getElementById('narrativaDetenido_error'),
    extractoIPHError = document.getElementById('extractoIPH_error'),
    observacionesNarrativasError = document.getElementById('observacionesNarrativas_error'),
    cdiFolioJCError = document.getElementById('cdiFolioJC_error'),
    narrativaPeticionario = document.getElementById('narrativaPeticionario'),
    narrativaElementos = document.getElementById('narrativaElementos'),
    narrativaDetenido = document.getElementById('narrativaDetenido'),
    extractoIPH = document.getElementById('extractoIPH'),
    no_remision_narrativas = document.getElementById('no_remision_narrativas'),
    no_ficha_narrativas = document.getElementById('no_ficha_narrativas'),
    cdiFolioJC = document.getElementById('cdiFolioJC'),
    pathFileIPH = pathFilesRemisiones + `${no_ficha_narrativas.value}/IPH/${no_remision_narrativas.value}/`,
    msg_narrativas = document.getElementById('msg_narrativas');

document.getElementById('narrativaPeticionario').disabled = true;

document.getElementById('peticionario_Nombres').addEventListener('input', () => {
    if (document.getElementById('peticionario_Nombres').value.length > 0)
        document.getElementById('narrativaPeticionario').disabled = false;
    else
        document.getElementById('narrativaPeticionario').disabled = true;
})


document.getElementById('btn_narrativas').addEventListener('click', async(e) => {

    e.preventDefault();

    const button = document.getElementById('btn_narrativas');

    let myFormData = new FormData(dataNarrativas),
        band = [],
        FV = new FormValidator(),
        i = 0;

    //band[i++] = narrativaPeticionarioError.innerText = FV.validate(myFormData.get('narrativaPeticionario'), 'required');
    band[i++] = narrativaElementosError.innerText = FV.validate(myFormData.get('narrativaElementos'), 'required');
    band[i++] = narrativaDetenidoError.innerText = FV.validate(myFormData.get('narrativaDetenido'), 'required');
    band[i++] = extractoIPHError.innerText = FV.validate(myFormData.get('extractoIPH'), 'required');
    //band[i++] = cdiFolioJCError.innerText = FV.validate(myFormData.get('cdiFolioJC'), 'required');

    let success = true;

    band.forEach(element => {
        success &= (element == '') ? true : false;
    });

    const result = await getTabValidado(10);
    if(!result){
        success = false;
    }

    if (success) {
        button.innerHTML = `
            Guardando
            <div class="spinner-grow spinner-grow-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        `;
        button.classList.add('disabled-link');

        const file = document.getElementById('fileIPHNarrativas');

        myFormData.append('narrativas', document.getElementById('btn_narrativas').value);
        myFormData.append('remision', no_remision_narrativas.value);
        myFormData.append('ficha', no_ficha_narrativas.value);

        if (file.files[0] != undefined) {
            myFormData.append('file_iph', file.files[0]);
        }


        fetch(base_url + 'insertarNarrativas', {
                method: 'POST',
                body: myFormData
            })
            .then(res => res.json())
            .then(data => {
                console.log(data)
                button.innerHTML = `
                Guardar
            `;
                button.classList.remove('disabled-link');

                if (!data.status) {
                    console.log(data);
                    narrativaPeticionarioError.innerText = (data.narrativaPeticionarioError === undefined) ? '' : data.narrativaPeticionarioError;
                    narrativaElementosError.innerText = (data.narrativaElementosError === undefined) ? '' : data.narrativaElementosError;
                    narrativaDetenidoError.innerText = (data.narrativaDetenidoError === undefined) ? '' : data.narrativaDetenidoError;
                    extractoIPHError.innerText = (data.extractoIPHError === undefined) ? '' : data.extractoIPHError;

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

                    msg_narrativas.innerHTML = messageError
                    window.scroll({
                        top: 0,
                        left: 100,
                        behavior: 'smooth'
                    });
                } else {
                    let peticionario = true,
                        elemento = true;
                    if (data.status_insertion.Peticionario || data.status_insertion.Peticionario === undefined) {
                        narrativaPeticionarioError.innerText = '';
                    } else {
                        narrativaPeticionarioError.innerText = 'Por favor registrar peticionario para poder asignar narrativa';
                        peticionario = false;
                    }
                    if (data.status_insertion.Elemento || data.status_insertion.Elemento === undefined) {
                        narrativaElementosError.innerText = '';
                    } else {
                        narrativaElementosError.innerText = 'Por favor registrar primer respondiente para poder asignar narrativa';
                        elemento = false;
                    }

                    if (peticionario && elemento) {
                        msg_narrativas.innerHTML = '<div class="alert alert-success text-center" role="alert">Información guardada con éxito.</div>'
                        window.scroll({
                            top: 0,
                            left: 100,
                            behavior: 'smooth'
                        });
                        getTabsGuardados();
                        //result.tab === '1' ? '' : document.getElementById('save-tab-10').style.display= 'block';
                    } else {
                        msg_narrativas.innerHTML = '<div class="alert alert-warning text-center" role="alert">No toda la información fue guardada con éxito.<br>Por favor, revisa nuevamente el formulario.</div>'
                        window.scroll({
                            top: 0,
                            left: 100,
                            behavior: 'smooth'
                        });
                    }
                }
            })
    } else {
        msg_narrativas.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario.</div>'
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });
    }
})

const getNarrativas = () => {
    var myFormData = new FormData()
    myFormData.append('no_remision', no_remision_narrativas.value);
    myFormData.append('no_ficha', no_ficha_narrativas.value);

    fetch(base_url + 'getNarrativas', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {

        // console.log(data)

        narrativaPeticionario.value = (data.peticionario.Narrativa_Hechos === undefined) ? '' : data.peticionario.Narrativa_Hechos;
        //if (data.peticionario.Narrativa_Hechos != undefined)
        document.getElementById('narrativaPeticionario').disabled = (data.peticionario.Narrativa_Hechos != undefined || data.peticionario.Narrativa_Hechos != '') ? false : true;
        narrativaElementos.value = (data.elemento.Narrativa_Hechos === undefined) ? '' : data.elemento.Narrativa_Hechos;
        narrativaDetenido.value = (data.detenido.Narrativa_Hechos === undefined) ? '' : data.detenido.Narrativa_Hechos;
        extractoIPH.value = (data.iph.Extracto_IPH === undefined) ? '' : data.iph.Extracto_IPH;
        cdiFolioJC.value = (data.iph.CDI === undefined) ? '' : data.iph.CDI;

        if (data.iph.Path_IPH != null) {
            document.getElementById('viewPDFIPH').innerHTML = `
                <embed src="${pathFileIPH + data.iph.Path_IPH}" width="100%" height="400"  type="application/pdf">
            `;
        }

    })
}