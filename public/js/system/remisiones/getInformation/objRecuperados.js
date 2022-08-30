const dataObjRecuperados = document.getElementById('data_objRecuperados'),
    no_remision_obj = document.getElementById('no_remision_objetosRecuperados'),
    no_ficha_obj = document.getElementById('no_ficha_objetosRecuperados'),
    inputsArmas = document.getElementById('inputsArmas_error'),
    inputsDrogas = document.getElementById('inputsDrogas_error'),
    inputsObjetos = document.getElementById('inputsObjetos_error'),
    msg_objRecuperados = document.getElementById('msg_objRecuperados'),
    /* Se comentan estos elementos debido a que al trabajar los vehiculos como una tabla
  los elementos se validan antes de ingresarse a ella, estos elementos por lo tanto estaran vacios
  al darle a -guardar- por lo que no son necesarios verificarlos.  
    check_vehiculos  = document.getElementById('Vehiculo_Si'),
    CheckVehiculos = document.getElementsByName('vehiculos'),
    DivFormVehiculos = document.getElementById('Form_vehiculo'),
    Tipo_Vehiculo_error = document.getElementById('Tipo_Vehiculo-invalid'),
    Placa_Vehiculo_error = document.getElementById('Placa_Vehiculo-invalid'),
    Marca_error = document.getElementById('Marca-invalid'),
    Modelo_error = document.getElementById('Modelo-invalid'),
    Color_error = document.getElementById('Color-invalid'),
    Senia_Particular_error = document.getElementById('Senia_Particular-invalid'),
    No_Serie_error = document.getElementById('No_Serie-invalid'),
    Procedencia_Vehiculo_error = document.getElementById('Procedencia_Vehiculo-invalid'),
    Observacion_Vehiculo_error = document.getElementById('Observacion_Vehiculo-invalid'),*/
    button = document.getElementById('btn_objRecuperados'),
    divDropzone = document.getElementById('dropzone_obj_recuperados');

/* Esta funcion se invalida, ya que ya no se pregunta si hay vehiculos involucrados*/    
/*    CheckVehiculos.forEach(element => {
    element.addEventListener('input', (e) => {
        DivFormVehiculos.setAttribute('style', (e.target.value === 'No') ? 'display: none !important' : 'display: block')
        vehiculoExist = ((e.target.value === 'No')) ? false : true;
    });
});*/

document.getElementById('btn_objRecuperados').addEventListener('click', async(e)=>{
    e.preventDefault();

    let myFormData = new FormData(dataObjRecuperados),
        success = true,
        band = [],
        FV = new FormValidator(),
        i = 0;

    const armas = validateInputsTables(['tipoArma', 'cantidadArmas', 'descripcionArmas']),
        drogas = validateInputsTables(['tipoDroga', 'cantidadDroga', 'unidadDroga', 'descripcionDroga']),
        objetos = validateInputsTables(['descripcionOtros']);
    
    if (!armas || !drogas || !objetos) {
        msg_objRecuperados.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario.</div>'
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });

        (!armas) ? inputsArmas.innerHTML = 'No se a agregado el registro a la tabla' : inputsArmas.innerHTML = '';
        (!drogas) ? inputsDrogas.innerHTML = 'No se a agregado el registro a la tabla' : inputsDrogas.innerHTML = '';
        (!objetos) ? inputsObjetos.innerHTML = 'No se a agregado el registro a la tabla' : inputsObjetos.innerHTML = '';

        return;
    } else {
        inputsArmas.innerHTML = '';
        inputsDrogas.innerHTML = '';
        inputsObjetos.innerHTML = '';
    }

    const result = await getTabValidado(4);
    if(!result){
        success = false;
    }


    /*esta funcion se invalida ya que no se necesita que esos campos esten validados para
    avanzar en la funcion Guardar.
    if(check_vehiculos.checked){
        band[i++] = Tipo_Vehiculo_error.innerText = FV.validate(myFormData.get('Tipo_Vehiculo'), 'required')
        band[i++] = Placa_Vehiculo_error.innerText = FV.validate(myFormData.get('Placa_Vehiculo'), 'required')
        band[i++] = Marca_error.innerText = FV.validate(myFormData.get('Marca'), 'required')
        band[i++] = Modelo_error.innerText = FV.validate(myFormData.get('Modelo'), 'required')
        band[i++] = Color_error.innerText = FV.validate(myFormData.get('Color'), 'required')
        band[i++] = Senia_Particular_error.innerText = FV.validate(myFormData.get('Senia_Particular'), 'required')
        band[i++] = No_Serie_error.innerText = FV.validate(myFormData.get('No_Serie'), 'required')
        band[i++] = Procedencia_Vehiculo_error.innerText = FV.validate(myFormData.get('Procedencia_Vehiculo'), 'required')
        band[i++] = Observacion_Vehiculo_error.innerText = FV.validate(myFormData.get('Observacion_Vehiculo'), 'required | max_length[450]')
    }*/

    band.forEach(element => {
        success &= (element == '') ? true : false
    })

    if (success) {
        button.innerHTML = `
            Guardando
            <div class="spinner-grow spinner-grow-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        `;

        button.classList.add('disabled-link');

        myFormData.append('objetos_recuperados', document.getElementById('btn_objRecuperados').value);
        myFormData.append('armas_table', JSON.stringify(readTableArmas()));
        myFormData.append('drogas_table', JSON.stringify(readTableDrogas()));
        myFormData.append('objetos_table', JSON.stringify(readTableObjetos()));
        /*se agregan los vehiculos de la tabla a traves de la funcion de readTableVehiculos*/
        myFormData.append('vehiculos_table', JSON.stringify(readTableVehiculos()));
        myFormData.append('remision', no_remision_obj.value);
        myFormData.append('ficha', no_ficha_obj.value);

        fetch(base_url + 'updateObjRecuperados', {
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

                msg_objRecuperados.innerHTML = messageError
                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });
            } else {
                msg_objRecuperados.innerHTML = '<div class="alert alert-success text-center" role="alert">Información guardada con éxito.</div>';
                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });
                getTabsGuardados();
            }
        });
    }

})

const readTableArmas = () => {
    const table = document.getElementById('armasRecuperadas');
    let armas = [];

    for (let i = 1; i < table.rows.length; i++) {
        armas.push({
            ['row']: {
                tipo: table.rows[i].cells[0].innerHTML,
                cantidad: table.rows[i].cells[1].innerHTML,
                descripcion: table.rows[i].cells[2].innerHTML
            }
        });
    }

    return armas;
}

const readTableDrogas = () => {
    const table = document.getElementById('drogasAseguradas');
    let drogas = [];

    for (let i = 1; i < table.rows.length; i++) {
        drogas.push({
            ['row']: {
                tipo: table.rows[i].cells[0].innerHTML,
                cantidad: table.rows[i].cells[1].innerHTML,
                unidad: table.rows[i].cells[2].innerHTML,
                descripcion: table.rows[i].cells[3].innerHTML
            }
        });
    }

    return drogas;
}

const readTableObjetos = () => {
    const table = document.getElementById('objetosAsegurados');
    let objetos = [];

    for (let i = 1; i < table.rows.length; i++) {
        objetos.push({
            ['row']: {
                descripcion: table.rows[i].cells[0].innerHTML
            }
        });
    }

    return objetos;
}
/*Se añade la funcion para leer la tabla de vehiculos, es homologa a las funciones de las demas tablas*/
const readTableVehiculos=()=> {
    const table = document.getElementById('vehiculosRecuperados');
    let vehiculos = [];
    for (let i = 1; i < table.rows.length; i++) {
        vehiculos.push({
            ['row']: {
                situacion: table.rows[i].cells[0].innerHTML,
                tipo: table.rows[i].cells[1].innerHTML,
                placa: table.rows[i].cells[2].innerHTML,
                marca: table.rows[i].cells[3].innerHTML,
                submarca: table.rows[i].cells[4].innerHTML,
                modelo: table.rows[i].cells[5].innerHTML,
                color: table.rows[i].cells[6].innerHTML,
                senia: table.rows[i].cells[7].innerHTML,
                num_serie: table.rows[i].cells[8].innerHTML,
                procedencia: table.rows[i].cells[9].innerHTML,
                observaciones: table.rows[i].cells[10].innerHTML,
            }
        });
    }
    return vehiculos;
}

const getObjetosRecuperados = () => {

    var myFormData = new FormData();

    myFormData.append('no_remision', no_remision_obj.value);
    myFormData.append('no_ficha', no_ficha_obj.value);

    fetch(base_url + 'getObjetosRecuperados', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {
        /*Se añaden los llamados a las funciones para rellenar los selectores de marcas, submarcas y tipos de vehiculos*/
        insertMarcasVehiculos(data.marcas_vehiculos)
        insertTiposVehiculos(data.tipos_vehiculos)
        insertSubmarcaVehiculos(data.submarcas_vehiculos)

        const rowsTableArmas = data.armas;
        for (let i = 0; i < rowsTableArmas.length; i++) {
            let formData = {
                tipoArma: rowsTableArmas[i].Tipo_Arma,
                cantidadArmas: rowsTableArmas[i].Cantidad,
                descripcionArmas: rowsTableArmas[i].Descripcion_Arma
            }
            insertNewRowArma(formData);
        }

        const rowsTableDrogas = data.drogas;
        for (let i = 0; i < rowsTableDrogas.length; i++) {
            let formData = {
                tipoDroga: rowsTableDrogas[i].Tipo_Droga,
                cantidadDroga: rowsTableDrogas[i].Cantidad,
                unidadDroga: rowsTableDrogas[i].Unidad,
                descripcionDroga: rowsTableDrogas[i].Descripcion_Droga
            }
            insertNewRowDroga(formData);
        }
        /*se añade la funcion para rellenar la tabla de vehiculos recuperados
        de la informacion de la base de datos, al igual que con las demas tablas*/
        const rowsTableVehiculos = data.vehiculos;
        for (let i = 0; i < rowsTableVehiculos.length; i++) {
            let formData = {
                Tipo_Situacion_0: rowsTableVehiculos[i].Tipo_Situacion == 0 ? true:false,
                Tipo_Vehiculo: rowsTableVehiculos[i].Tipo_Vehiculo,
                Placa_Vehiculo: rowsTableVehiculos[i].Placa_Vehiculo,
                Marca: rowsTableVehiculos[i].Marca,
                Submarca: rowsTableVehiculos[i].Submarca,
                Modelo: rowsTableVehiculos[i].Modelo,
                Color: rowsTableVehiculos[i].Color,
                Senia_Particular: rowsTableVehiculos[i].Senia_Particular,
                No_Serie: rowsTableVehiculos[i].No_Serie,
                Procedencia_Vehiculo: rowsTableVehiculos[i].Procedencia_Vehiculo,
                Observacion_Vehiculo: rowsTableVehiculos[i].Observacion_Vehiculo,
            }
            insertNewRowVehiculo(formData);
        }
        /*      Se comenta esta informacion ya que ahora estos campos quedaran vacios por defecto
        y la informacion se mostrara en la tabla
        if (data.vehiculos.No_Remision != undefined) {
            document.getElementById('Vehiculo_Si').checked = true;
            document.getElementById('Form_vehiculo').style.display = 'block';

            document.getElementById('Tipo_Situacion_1').checked = (data.vehiculos.Tipo_Situacion === '1') ? true : false;

            Tipo_Vehiculo.value = data.vehiculos.Tipo_Vehiculo
            Placa_Vehiculo.value = data.vehiculos.Placa_Vehiculo
            Marca.value = data.vehiculos.Marca
            Modelo.value = data.vehiculos.Modelo
            Color.value = data.vehiculos.Color
            Senia_Particular.value = data.vehiculos.Senia_Particular
            No_Serie.value = data.vehiculos.No_Serie
            Procedencia_Vehiculo.value = data.vehiculos.Procedencia_Vehiculo
            Observacion_Vehiculo.value = data.vehiculos.Observacion_Vehiculo

        }*/

        const rowsTableObjetos = data.objetos;
        for (let i = 0; i < rowsTableObjetos.length; i++) {
            let formData = {
                descripcionOtros: rowsTableObjetos[i].Descripcion_Objeto
            }
            insertNewRowOtro(formData);
        }
    })
}

Dropzone.autoDiscover = false;
document.addEventListener('DOMContentLoaded', ()=>{
    const dropzoneObjRec = new Dropzone('#dropzone_obj_recuperados', {
        url: `${base_url}updateImgObjRecuperados`,
        dictDefaultMessage: 'Carga tu archivo',
        acceptedFiles: '.png,.jpg,.jpeg,.PNG,.JPG',
        addRemoveLinks: true,
        maxFiles: 1,
        params: { 'data': 'xd', 'ficha' : no_ficha_obj.value},
        dictRemoveFile: 'Eliminar archivo',
        init: function(){
            var myFormData = new FormData();

            myFormData.append('no_remision', no_remision_obj.value);
            myFormData.append('no_ficha', no_ficha_obj.value);

            fetch(base_url + 'getObjetosRecuperados', {
                method: 'POST',
                body: myFormData
            })
            .then(res => res.json())
            .then(data => {
                if(data.image.Path_Objetos != '' && data.image.Path_Objetos != null && data.image.Path_Objetos != undefined){
                    let imgPublic = {};
                    imgPublic.size = 1234;
                    imgPublic.name = data.image.Path_Objetos;
    
                    this.options.addedfile.call(this, imgPublic);
                    this.options.thumbnail.call(this, imgPublic, `${base_url_js}public/files/Remisiones/${no_ficha_obj.value}/ObjRecuperados/${data.image.Path_Objetos}`);
    
                    imgPublic.previewElement.classList.add('dz-success');
                    imgPublic.previewElement.classList.add('dz-complete');
                    imgPublic.previewElement.classList.add('dz-complete');
                    imgPublic.previewElement.setAttribute('id', `serve_render`);
                    imgPublic.previewElement.childNodes[1].childNodes[0].classList.add('img-fluid');
                    divDropzone.setAttribute('data-id', data.image.Path_Objetos);
                    document.getElementById('btn_obj_recuperados').style.display = 'block';
                }
            })
        },
        success: function(file,resp){
            /* console.log(resp); */
            resp = JSON.parse(resp);
            if(!resp.status){
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

                msg_objRecuperados.innerHTML = messageError
                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });
            }else{
                divDropzone.setAttribute('data-id', resp.nameFile);
                if(document.getElementById('serve_render')){
                    let elem = document.getElementById(`serve_render`);
                    elem.parentNode.removeChild(elem);
                }
                document.getElementById('input_obj_recuperados').value = resp.nameFile;

                document.getElementById('dropzone_obj_recuperados').childNodes[2].childNodes[1].childNodes[0].src = `${base_url_js}public/files/Remisiones/${no_ficha_obj.value}/ObjRecuperados/${resp.nameFile}`;

                document.getElementById('btn_obj_recuperados').style.display = 'block';
                file.name = resp.nameFile;
            }
        },
        maxfilesexceeded: function(file){
            if (this.files[1] != null) {
                file.previewElement.parentNode.removeChild(file.previewElement);
                this.removeFile(this.files[0]);
                this.addFile(file);
            }
        },
        removedfile: function(file,resp){
            file.previewElement.parentNode.removeChild(file.previewElement);

            let myFormData = new FormData();

            myFormData.append('btn_croquis', 'xd');
            myFormData.append('ficha', no_ficha_obj.value);
            myFormData.append('name_file', divDropzone.getAttribute('data-id'));

            fetch(base_url + 'deleteImgObjRecuperados', {
                method: 'POST',
                body: myFormData
            })

            .then(res => res.text())
            .then(data => {
                console.log(data);
            })
        }
    })
})


document.getElementById('btn_obj_recuperados').addEventListener('click', ()=>{
        let myFormData = new FormData();

        myFormData.append('ficha', no_ficha_obj.value);
        myFormData.append('image', document.getElementById('dropzone_obj_recuperados').getAttribute('data-id'));

        fetch(base_url + 'rotateImageObj', {
            method: 'POST',
            body: myFormData
        })
        .then(res => res.json())
        .then(data => {
            //console.log(data);
            if(data.status){
                document.getElementById('dropzone_obj_recuperados').childNodes[2].childNodes[1].childNodes[0].src = `${base_url_js}public/files/Remisiones/${no_ficha_obj.value}/ObjRecuperados/${data.nameFile}`;
                document.getElementById('dropzone_obj_recuperados').setAttribute('data-id', data.nameFile);
            }
        })
})