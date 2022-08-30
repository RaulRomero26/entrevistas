const dataSenasParticulares = document.getElementById('data_senasParticulares'),
    tipoVestimentaError = document.getElementById('tipoVestimenta_error'),
    descripcionVestiementaError = document.getElementById('descripcionVestimenta_error'),
    inputsSenas = document.getElementById('inputsSenas_error'),
    inputsAccesorios = document.getElementById('inputsAccesorio_error'),
    msg_senasParticulares = document.getElementById('msg_senasParticulares'),
    tipoVestimenta = document.getElementById('tipoVestimenta'),
    no_remision_senas = document.getElementById('no_remision_senasParticulares'),
    no_ficha_senas = document.getElementById('no_ficha_senasParticulares'),
    pathImagesSenas = pathFilesRemisiones + `${no_ficha_senas.value}/SenasParticulares/${no_remision_senas.value}/`,
    descripcionVestimenta = document.getElementById('descripcionVestimenta');

document.getElementById('btn_senasParticulares').addEventListener('click', async(e) => {

    e.preventDefault();

    const button = document.getElementById('btn_senasParticulares');

    let myFormData = new FormData(dataSenasParticulares),
        band = [],
        FV = new FormValidator(),
        i = 0;

    band[i++] = tipoVestimentaError.innerText = FV.validate(myFormData.get('tipoVestimenta'), 'required');
    band[i++] = descripcionVestiementaError.innerText = FV.validate(myFormData.get('descripcionVestimenta'), 'required');

    let success = true;

    band.forEach(element => {
        success &= (element == '') ? true : false;
    });

    const senas = validateInputTableSena();
    const accesorios = validateInputsTables(['tipoAccesorio', 'descripcionAccesorio']);

    if (!senas || !accesorios) {
        msg_senasParticulares.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario.</div>'
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });
        if (!senas) {
            inputsSenas.innerHTML = 'No se a agregado el registro a la tabla';
        } else {
            inputsSenas.innerHTML = '';
        }
        if (!accesorios) {
            inputsAccesorios.innerHTML = 'No se a agregado el registro a la tabla';
        } else {
            inputsAccesorios.innerHTML = '';
        }

        return;
    } else {
        inputsSenas.innerHTML = '';
        inputsAccesorios.innerHTML = '';
    }

    const result = await getTabValidado(7);
    if(!result){
        success = false;
    }

    if (success) {

        const elements = document.getElementsByClassName('uploadFileSenas');

        myFormData.append('senas_particulares', document.getElementById('btn_senasParticulares').value);
        myFormData.append('accesorios_table', JSON.stringify(readTableAccesorios()));
        myFormData.append('ficha', no_ficha_senas.value);
        myFormData.append('remision', no_remision_senas.value);

        for (let i = 0; i < elements.length; i++) {
            if (elements[i].files.length != 0) {
                let nameInput = elements[i].name;
                myFormData.append(nameInput, elements[i].files[0]);
            }
        }

        readTableSenas().then(res => {
            //console.log(res);

            validateImages(res).then(resp => {
                if (resp) {
                    button.innerHTML = `
                        Guardando
                        <div class="spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    `;
                    button.classList.add('disabled-link');
                    myFormData.append('senas_table', JSON.stringify(res));
                    fetch(base_url + 'updateSenasParticulares', {
                            method: 'POST',
                            body: myFormData
                        })
                        .then(res => res.json())
                        .then(data => {
                            button.innerHTML = `
                            Guardar
                        `;
                            button.classList.remove('disabled-link');
                            if (!data.status) {
                                tipoVestimentaError.innerText = (data.tipoVestimentaError === undefined) ? '' : data.tipoVestimentaError;
                                descripcionVestiementaError.innerText = (data.descripcionVestiementaError === undefined) ? '' : data.descripcionVestiementaError;


                                msg_senasParticulares.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario.</div>'
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

                                msg_senasParticulares.innerHTML = messageError
                                window.scroll({
                                    top: 0,
                                    left: 100,
                                    behavior: 'smooth'
                                });
                            } else {
                                msg_senasParticulares.innerHTML = '<div class="alert alert-success text-center" role="alert">Información guardada con éxito.</div>'
                                window.scroll({
                                    top: 0,
                                    left: 100,
                                    behavior: 'smooth'
                                });
                                getTabsGuardados();
                                // result.tab === '1' ? '' : document.getElementById('save-tab-7').style.display = 'block';
                            }
                        })
                } else {
                    msg_senasParticulares.innerHTML = '<div class="alert alert-warning text-center" role="alert">Todas las señas particulares requieren una imagen.</div>'
                    window.scroll({
                        top: 0,
                        left: 100,
                        behavior: 'smooth'
                    });
                }
            })

        });
    } else {
        msg_senasParticulares.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario.</div>'
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });
    }

});

const validateInputTableSena = () => {
    let isValid = true;

    const items = document.getElementById('list');
    const campos = ['senasparticulares', 'clasificacion', 'descripcion'];

    if (items.innerHTML.length != 0) {
        isValid = false;
    }

    for (i = 0; i < campos.length; i++) {
        if (document.getElementById(campos[i]).value != "") {
            isValid = false;
        }
    }
    return isValid;
}

const dataImageSenas = (perfil, partes, tipo, color, clasificacion, descripcion, typeImage, nameImage, dataImage) => {
    return {
        ['row']: {
            perfil: perfil,
            partes: partes,
            tipo: tipo,
            color: color,
            clasificacion: clasificacion,
            descripcion: descripcion,
            typeImage: typeImage,
            nameImage: nameImage,
            image: dataImage
        }
    }
}

const validateImages = async(res) => {
    let band = true;

    await res.forEach(element => {
        if (element.row.typeImage === null) {
            band = false;
        }
    });

    return band;
}

const readTableSenas = async() => {
    const table = document.getElementById('senas');
    let senas = [];
    if (table.rows.length > 1) {


        for (let i = 1; i < table.rows.length; i++) {
            const items = table.rows[i].cells[1].getElementsByTagName('li'),
                input = table.rows[i].cells[6].children[1].children[0];

            let partes = [];

            for (let j = 0; j < items.length; j++) {
                partes.push(items[j].innerHTML);
            }

            if (input != undefined) {
                const type = input.children[2].classList[1],
                    base64 = document.getElementById('images_row_' + i);
                nameImage = 'sena_row' + i;
                if (type != 'File') {
                    isPNG = base64.src.split('.');
                    if (isPNG[1] != undefined) {
                        await toDataURL(base64.src)
                            .then(myBase64 => {
                                senas.push(dataImageSenas(table.rows[i].cells[0].innerHTML, partes.toString(), table.rows[i].cells[2].innerHTML, table.rows[i].cells[3].innerHTML.length != 0 ? true : false, table.rows[i].cells[4].innerHTML, table.rows[i].cells[5].innerHTML, type, nameImage, myBase64));
                            })
                    } else {
                        senas.push(dataImageSenas(table.rows[i].cells[0].innerHTML, partes.toString(), table.rows[i].cells[2].innerHTML, table.rows[i].cells[3].innerHTML.length != 0 ? true : false, table.rows[i].cells[4].innerHTML, table.rows[i].cells[5].innerHTML, type, nameImage, base64.src));
                    }
                } else {
                    senas.push(dataImageSenas(table.rows[i].cells[0].innerHTML, partes.toString(), table.rows[i].cells[2].innerHTML, table.rows[i].cells[3].innerHTML.length != 0 ? true : false, table.rows[i].cells[4].innerHTML, table.rows[i].cells[5].innerHTML, type, nameImage, null));
                }
            } else {
                senas.push(dataImageSenas(table.rows[i].cells[0].innerHTML, partes.toString(), table.rows[i].cells[2].innerHTML, table.rows[i].cells[3].innerHTML.length != 0 ? true : false, table.rows[i].cells[4].innerHTML, table.rows[i].cells[5].innerHTML, null, null, null));
            }
        }
    }
    return senas;
}

const readTableAccesorios = () => {
    const table = document.getElementById('accesorios');
    let accesorios = [];

    for (let i = 1; i < table.rows.length; i++) {
        accesorios.push({
            ['row']: {
                accesorio: table.rows[i].cells[0].innerHTML,
                descripcion: table.rows[i].cells[1].innerHTML
            }
        });
    }

    return accesorios;
}

const getSenasParticulares = () => {
    var no_remision = document.getElementById('no_remision_senasParticulares')

    var myFormData = new FormData()
    myFormData.append('no_remision', no_remision.value)

    fetch(base_url + 'getSenasParticulares', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {

        const rowsTableSenas = data.senas;
        for (let i = 0; i < rowsTableSenas.length; i++) {
            const lis = createListLI(rowsTableSenas[i].Ubicacion_Corporal, rowsTableSenas[i].Perfil).toString();
            let formData = {
                selectPerfil: rowsTableSenas[i].Perfil,
                senasparticulares: rowsTableSenas[i].Tipo_Senia_Particular,
                clasificacion: rowsTableSenas[i].Clasificacion,
                colorTatuaje: rowsTableSenas[i].Color === '1' ? true : false,
                descripcion: rowsTableSenas[i].Descripcion,
                list: lis.replace(',', '')
            }
            insertNewRowSenas(formData, 'sena');
            if (rowsTableSenas[i].Path_Imagen.length != 0) {
                createElementSena(pathImagesSenas + rowsTableSenas[i].Path_Imagen, i + 1, 'Photo');
            }
        }

        tipoVestimenta.value = (data.vestimenta.Tipo_Vestimenta === undefined) ? '' : data.vestimenta.Tipo_Vestimenta;
        descripcionVestimenta.value = (data.vestimenta.Descripcion_Vestimenta === undefined) ? '' : data.vestimenta.Descripcion_Vestimenta;

        const rowsTableAccesorios = data.accesorios;
        for (let i = 0; i < rowsTableAccesorios.length; i++) {
            let formData = {
                tipoAccesorio: rowsTableAccesorios[i].Tipo_Accesorio,
                descripcionAccesorio: rowsTableAccesorios[i].Descripcion
            }
            insertNewRowAccesorio(formData);
        }

        const table = document.getElementById('senas'),
            items = table.getElementsByTagName('li');

        for (let j = 0; j < items.length; j++) {
            if (!document.getElementById(items[j].id.substring(3)).classList.contains('select-piece')) {
                document.getElementById(items[j].id.substring(3)).classList.add('select-piece');
            }
        }

    })
}