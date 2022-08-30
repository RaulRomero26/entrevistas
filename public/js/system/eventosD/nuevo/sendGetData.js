const data                 = document.getElementById('form_evento_delictivo'),
    button_save            = document.getElementById('btn_save_data_ed'),
    button_cancel          = document.getElementById('btn_cancel_data'),
    folio_no_error         = document.getElementById('folio_no_error'),
    fecha_error            = document.getElementById('fecha_error'),
    hora_reporte_error     = document.getElementById('hora_reporte_error'),
    observaciones_error    = document.getElementById('observaciones_error'),
    msgError               = document.getElementById('msg_error_evento_delictivo'),
    folio                  = document.getElementById('folio_no'),
    zona                   = document.getElementById('zona'),
    vector                 = document.getElementById('vector'),
    cia                    = document.getElementById('cia'),
    fecha                  = document.getElementById('fecha'),
    hora_reporte           = document.getElementById('hora_reporte'),
    dom_calle              = document.getElementById('dom_calle'),
    num                    = document.getElementById('num'),
    calle                  = document.getElementById('calle'),
    tipo_colonia           = document.getElementById('tipo_colonia'),
    colonia                = document.getElementById('colonia'),
    tipo_evento            = document.getElementById('tipo_evento'),
    giro_evento            = document.getElementById('giro_evento'),
    caracteristicas_evento = document.getElementById('caracteristicas_evento'),
    objetos_robados        = document.getElementById('objetos_robados'),
    observaciones          = document.getElementById('observaciones'),
    situacion_1            = document.getElementById('situacion_1'),
    situacion_2            = document.getElementById('situacion_2'),
    detenidos_1            = document.getElementById('detenidos_1'),
    detenidos_2            = document.getElementById('detenidos_2'),
    violencia_1            = document.getElementById('violencia_1'),
    violencia_2            = document.getElementById('violencia_2'),
    tipo_arma              = document.getElementById('tipo_arma'),
    modus_operandi         = document.getElementById('modus_operandi'),
    modo_fuga              = document.getElementById('modo_fuga'),
    peticionario           = document.getElementById('peticionario'),
    telefono               = document.getElementById('telefono');

button_save.addEventListener('click', async(e)=>{
    e.preventDefault();
    let myFormData = new FormData(data),
        band = [],
        FV = new FormValidator(),
        i = 0;

    if(document.getElementById('modo') === null){
        let result = await existFolio(folio.value);
        if(result){
            msgError.innerHTML = '<div class="alert alert-warning text-center" role="alert">Lo sentimos, el folio ya existe</div>'
            window.scroll({
                top: 0,
                left: 100,
                behavior: 'smooth'
            });

            return;
        }
    };

    band[i++] = folio_no_error.innerText = FV.validate(myFormData.get('folio_no'), 'required');
    band[i++] = fecha_error.innerText = FV.validate(myFormData.get('fecha'), 'required | date');
    band[i++] = hora_reporte_error.innerText = FV.validate(myFormData.get('hora_reporte'), 'required | time');

    let success = true
    band.forEach(element => {
        success &= (element == '') ? true : false
    });


    if(success){

        button_save.setAttribute('disabled', '');
        button_cancel.setAttribute('disabled', '');

        myFormData.append('btn_evento', button_save.value);
        myFormData.append('responsables', JSON.stringify(readTableResponsables()));

        fetch(base_url_js+'EventosDelictivos/insertUpdateEvento',{
            method: 'POST',
            body: myFormData
        })
        .then(res=>res.json())
        .then(data =>{
            //console.log(data);
            button_save.removeAttribute('disabled');
            button_cancel.removeAttribute('disabled');
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

                setInterval(function() { window.location = base_url_js+'EventosDelictivos'; }, 1500);
            }
        });

    }else{
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });

        msgError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>';
    }

    for (var pair of myFormData.entries()) {
        //console.log(pair[0] + ', ' + pair[1]);
    }
});

const readTableResponsables = ()=>{
    const table = document.getElementById('responsables_table');

    let responsables = [];

    for(let i = 1; i<table.rows.length; i++){
        responsables.push({
            ['row']:{
                remision: table.rows[i].cells[0].innerHTML,
                nombre: table.rows[i].cells[1].innerHTML,
                edad: table.rows[i].cells[2].innerHTML,
                sexo: table.rows[i].cells[3].innerHTML
            }
        });
    }

    return responsables;
}

let modo =  true ;
const buttonSave =  document.getElementById('btn_save_data_ed')
const elements = [
    { id: 'zona', type: 'input'},
    { id: 'vector', type: 'input'},
    { id: 'cia', type: 'input'},
    { id: 'fecha', type: 'input'},
    { id: 'hora_reporte', type: 'input'},
    { id: 'dom_calle', type: 'input'},
    { id: 'num', type: 'input'},
    { id: 'calle', type: 'input'},
    { id: 'colonia', type: 'input'},
    { id: 'tipo_evento', type: 'select'},
    { id: 'giro_evento', type: 'input'},
    { id: 'caracteristicas_evento', type: 'input'},
    { id: 'objetos_robados', type: 'input'},
    { id: 'observaciones', type: 'input'},
    { id: 'situacion', type: 'checkbox'},
    { id: 'detenidos', type: 'checkbox'},
    { id: 'violencia', type: 'checkbox'},
    { id: 'tipo_arma', type: 'input'},
    { id: 'modus_operandi', type: 'input'},
    { id: 'modo_fuga', type: 'input'},
    { id: 'no_remision_table', type: 'input'},
    { id: 'nombre_table', type: 'input'},
    { id: 'edad_table', type: 'input'},
    { id: 'sexo_table', type: 'select'},
    { id: 'btn_add_element', type: 'select'},
    { id: 'peticionario', type: 'input'},
    { id: 'telefono', type: 'input'},
    { id: 'marca', type: 'input'},
    { id: 'tipo', type: 'input'},
    { id: 'anio', type: 'input'},
    { id: 'placas', type: 'input'},
    { id: 'color', type: 'input'},
    { id: 'ficha', type: 'input'},
    { id: 'cuantos', type: 'input'},
    { id: 'remisiones', type: 'input'},

]

window.onload = function() {
    if(document.getElementById('modo') != null){
        disableForm(modo,buttonSave,elements);
        getData();
    }
}

let activateButtonRow = (arg, value) => {
    for (let i = 0; i < arg.length; i++) {
        arg[i].disabled = value
    }
}

if(document.getElementById('modo') != null){
    btn_modo = document.getElementById('id_edit_button')
    btn_modo.addEventListener('click', () => {
        if (btn_modo.innerText === 'Modo Editar') {
            btn_modo.innerText = 'Modo lectura'
            disableForm(false, buttonSave, elements)
            activateButtonRow(document.getElementById('responsables_table').getElementsByClassName('action_row'), false)
        } else {
            btn_modo.innerText = 'Modo Editar'
            disableForm(true, buttonSave, elements)
            activateButtonRow(document.getElementById('responsables_table').getElementsByClassName('action_row'), true)
        }
    })
}

const getData = ()=>{
    if(folio.value != '' && folio.hasAttribute('readonly')){
        let myFormData = new FormData();

        myFormData.append('folio', folio.value);

        fetch(base_url_js+'EventosDelictivos/getDataEvento',{
            method: 'POST',
            body: myFormData
        })
        .then(res=>res.json())
        .then(data =>{
            //console.log(data);
            if(!data){
                window.location = base_url_js+'EventosDelictivos';
            }else{
                zona.value                   = data.Zona;
                vector.value                 = data.Vector;
                cia.value                    = data.Cia;
                fecha.value                  = data.Fecha;
                hora_reporte.value           = data.Hora_Reporte;
                dom_calle.value              = data.Calle_1;
                num.value                    = data.Numero;
                calle.value                  = data.Calle_2;
                tipo_colonia.value           = data.Colonia_Tipo;
                colonia.value                = data.Colonia;
                tipo_evento.value            = data.Motivo_Evento;
                if(data.Motivo_Evento === 'ROBO DE VEHÍCULO'){
                    document.getElementById('content_observaciones').style.display = 'block';
                    marca.value  = data.Marca;
                    tipo.value   = data.Tipo_Vehiculo;
                    year.value   = data.Year;
                    placas.value = data.Placas;
                    color.value  = data.Color;
                }
                (data.Situacion === 'Consumado') ? situacion_1.checked = true : situacion_2.checked = true;
                if(data.Detenidos === '1'){
                    detenidos_2.checked = true;
                    document.getElementById('detenidos_content').style.display = 'block';
                    cuantos.value    = data.Num_Detenidos;
                    remisiones.value = data.Remisiones;
                }else{
                    detenidos_1.checked = true;
                }
                (data.Con_Violencia === '1') ? violencia_1.checked = true : violencia_2.checked = true;
                giro_evento.value            = data.Giro_Evento;
                caracteristicas_evento.value = data.Caracteristica_Evento;
                objetos_robados.value        = data.Objetos_Robados;
                observaciones.value          = data.Observaciones;
                tipo_arma.value              = data.Tipo_Arma;
                modus_operandi.value         = data.Modus_Operandi;
                modo_fuga.value              = data.Modo_Fuga;
                if(data.Responsables != ',,,'){
                    let responsables = data.Responsables.split('|||');
                    responsables.forEach(responsable=>{
                        let responsableArray = responsable.split(',');
                        let formData = {
                            no_remision_table : responsableArray[0],
                            nombre_table : responsableArray[1],
                            edad_table : responsableArray[2],
                            sexo_table : (responsableArray[3] === 'H') ? 'HOMBRE' : 'MUJER'
                        }
            
                        insertNewRowResponsable(formData);
                    })

                    const button_row = document.getElementById('responsables_table').getElementsByClassName('action_row')
                    activateButtonRow(button_row, true)
                }
                peticionario.value           = data.Full_Name_Peticionario;
                telefono.value               = data.Telefono_Peticionario;
            }

        });
    }
}
