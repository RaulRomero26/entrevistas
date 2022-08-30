let modo = true;

const fecha_puesta             = document.getElementById('fecha_puesta'),
    hora_puesta                = document.getElementById('hora_puesta'),
    num_expendiente_puesta     = document.getElementById('num_expendiente_puesta'),
    num_referencia_puesta      = document.getElementById('num_referencia_puesta'),
    num_folio_iph              = document.getElementById('num_folio_iph'),
    ano_folio_iph              = document.getElementById('ano_folio_iph'),
    turno_folio_iph            = document.getElementById('turno_folio_iph'),
    nombre_realiza_puesta      = document.getElementById('nombre_realiza_puesta'),
    apellido_p_realiza_puesta  = document.getElementById('apellido_p_realiza_puesta'),
    apellido_m_realiza_puesta  = document.getElementById('apellido_m_realiza_puesta'),
    adscripcion_realiza_puesta = document.getElementById('adscripcion_realiza_puesta'),
    cargo_realiza_puesta       = document.getElementById('cargo_realiza_puesta'),
    apellido_p_autoridad       = document.getElementById('apellido_p_autoridad'),
    apellido_m_autoridad       = document.getElementById('apellido_m_autoridad'),
    fiscalia_autoridad         = document.getElementById('fiscalia_autoridad'),
    adscripcion_autoridad      = document.getElementById('adscripcion_autoridad'),
    cargo_autoridad            = document.getElementById('cargo_autoridad'),
    nombre_identificacion      = document.getElementById('nombre_identificacion'),
    apellido_p_identificacion  = document.getElementById('apellido_p_identificacion'),
    apellido_m_identificacion  = document.getElementById('apellido_m_identificacion'),
    num_control_identificacion = document.getElementById('num_control_identificacion'),
    grado_identificacion       = document.getElementById('grado_identificacion'),
    unidad_identificacion      = document.getElementById('unidad_identificacion'),
    fecha_conocimiento         = document.getElementById('fecha_conocimiento'),
    hora_conocimiento          = document.getElementById('hora_conocimiento'),
    fecha_arribo               = document.getElementById('fecha_arribo'),
    hora_arribo                = document.getElementById('hora_arribo'),
    Colonia                    = document.getElementById('Colonia'),
    Calle                      = document.getElementById('Calle'),
    noExterior                 = document.getElementById('noExterior'),
    noInterior                 = document.getElementById('noInterior'),
    cordY                      = document.getElementById('cordY'),
    cordX                      = document.getElementById('cordX'),
    CP                         = document.getElementById('CP'),
    Municipio                  = document.getElementById('Municipio'),
    Entidad                    = document.getElementById('Entidad'),
    Referencias                = document.getElementById('Referencias'),
    especifique_riesgo         = document.getElementById('especifique_riesgo'),
    cual_emergencia            = document.getElementById('cual_emergencia'),
    setStateBtn                = document.getElementById('setStateBtn'),
    buttonSave                 = document.getElementById('btn_puesta'),
    fotografia_check           = document.getElementById('fotografia_check'),
    video_check                = document.getElementById('video_check'),
    audio_check                = document.getElementById('audio_check'),
    certificado_check          = document.getElementById('certificado_check')
    ;

window.onload = function() {
    disableForm(modo,buttonSave,elements);
    getData();
}

if(setStateBtn != null){
    setStateBtn.addEventListener('click',()=>{
        modo = !modo;
        (modo) ? setStateBtn.innerText = 'Editar Registro' : setStateBtn.innerText = 'Solo Lectura';
        disableForm(modo,buttonSave,elements);
    })
}

const elements = [
    {
        id: 'fecha_puesta',
        type: 'input'
    },
    {
        id: 'hora_puesta',
        type: 'input'
    },
    {
        id: 'num_expendiente_puesta',
        type: 'input'
    },
    {
        id: 'num_referencia_puesta',
        type: 'input'
    },
    {
        id: 'num_folio_iph',
        type: 'input'
    },
    {
        id: 'turno_folio_iph',
        type: 'input'
    },
    {
        id: 'adscripcion_realiza_puesta',
        type: 'input'
    },
    {
        id: 'nombre_autoridad',
        type: 'input'
    },
    {
        id: 'apellido_p_autoridad',
        type: 'input'
    },
    {
        id: 'apellido_m_autoridad',
        type: 'input'
    },
    {
        id: 'fiscalia_autoridad',
        type: 'input'
    },
    {
        id: 'adscripcion_autoridad',
        type: 'input'
    },
    {
        id: 'cargo_autoridad',
        type: 'input'
    },
    {
        id: 'grado_identificacion',
        type: 'input'
    },
    {
        id: 'unidad_identificacion',
        type: 'input'
    },
    {
        id: 'institucion',
        type: 'checkbox'
    },
    {
        id: 'cual_identificacion',
        type: 'input'
    },
    {
        id: 'elementos',
        type: 'checkbox'
    },
    {
        id: 'cuantos_identificacion',
        type: 'input'
    },
    {
        id: 'hecho',
        type: 'checkbox'
    },
    {
        id: 'cual_emergencia',
        type: 'input'
    },
    {
        id: 'fecha_conocimiento',
        type: 'input'
    },
    {
        id: 'hora_conocimiento',
        type: 'input'
    },
    {
        id: 'fecha_arribo',
        type: 'input'
    },
    {
        id: 'hora_arribo',
        type: 'input'
    },
    {
        id: 'busqueda',
        type: 'checkbox'
    },
    {
        id: 'Colonia',
        type: 'input'
    },
    {
        id: 'Calle',
        type: 'input'
    },
    {
        id: 'noExterior',
        type: 'input'
    },
    {
        id: 'noInterior',
        type: 'input'
    },
    {
        id: 'cordY',
        type: 'input'
    },
    {
        id: 'cordX',
        type: 'input'
    },
    {
        id: 'CP',
        type: 'input'
    },
    {
        id: 'Municipio',
        type: 'input'
    },
    {
        id: 'Entidad',
        type: 'input'
    },
    {
        id: 'Referencias',
        type: 'input'
    },
    {
        id: 'realizo_inspeccion',
        type: 'checkbox'
    },
    {
        id: 'encontro_objeto',
        type: 'checkbox'
    },
    {
        id: 'preservo_lugar',
        type: 'checkbox'
    },
    {
        id: 'priorizacion_lugar',
        type: 'checkbox'
    },
    {
        id: 'riesgo_presentado',
        type: 'checkbox'
    },
    {
        id: 'especifique_riesgo',
        type: 'input'
    },
    {
        id: 'narrativa',
        type: 'input'
    },
    {
        id: 'element_search',
        type: 'input'
    },
    {
        id: 'button_search',
        type: 'select'
    }
];

const deleteDocComButton = document.getElementsByClassName('icon-delete-doc-com');

deleteDocComButton.forEach(button=>{
    button.addEventListener('click',()=>{
        if(window.confirm('¿Seguro desea eliminar el documento?')){
            let myFormData = new FormData();

            myFormData.append('name', button.getAttribute('data-name'));
            myFormData.append('id_puesta', button.getAttribute('data-id'));
            myFormData.append('btn_doc', 'xd');

            fetch(base_url_js + 'Juridico/deleteDocComple', {
                method: 'POST',
                body: myFormData
            })

            .then(res => res.json())
            .then(data => {
                if(data.status){
                    button.parentNode.parentNode.parentNode.parentNode.removeChild(button.parentNode.parentNode.parentNode);
                }
            })
        }
    })
})

const getData = ()=>{
    let myFormData = new FormData();

    myFormData.append('id_puesta', document.getElementById('id_puesta').value);

    fetch(base_url_js+'Juridico/getPuesta',{
        method: 'POST',
        body: myFormData
    })
    .then(res=>res.json())
    .then(data =>{
        console.log(data);
        if(data.puesta.Fecha_Hora != null){
            fecha_puesta.value                 = data.puesta.Fecha_Hora.split(' ')[0];
            hora_puesta.value                  = data.puesta.Fecha_Hora.split(' ')[1];
        }
        num_expendiente_puesta.value       = data.puesta.Num_Expediente;
        num_referencia_puesta.value        = (data.puesta.Num_Referencia === '') ? '21PM03115' : data.puesta.Num_Referencia;

        if(data.puesta.Folio_IPH != null){
            const folioIPH = data.puesta.Folio_IPH.split('/');
    
            num_folio_iph.value = folioIPH[0];
            ano_folio_iph.value = folioIPH[1];
            turno_folio_iph.value = folioIPH[2];
        }

        nombre_realiza_puesta.value        = data.primerRespondiente.Nombre_PR;
        apellido_p_realiza_puesta.value    = data.primerRespondiente.Ap_Paterno_PR;
        apellido_m_realiza_puesta.value    = data.primerRespondiente.Ap_Materno_PR;
        adscripcion_realiza_puesta.value   = data.primerRespondiente.Adscripcion_Realiza_Puesta;
        cargo_realiza_puesta.value         = data.primerRespondiente.Cargo;

        if(data.fiscal != false){
            nombre_autoridad.value             = data.fiscal.Nombre_Fis;
            apellido_p_autoridad.value         = data.fiscal.Ap_Paterno_Fis;
            apellido_m_autoridad.value         = data.fiscal.Ap_Materno_Fis;
            fiscalia_autoridad.value           = data.fiscal.Fiscalia;
            adscripcion_autoridad.value        = data.fiscal.Adscripcion;
            cargo_autoridad.value              = data.fiscal.Cargo;
        }

        nombre_identificacion.value        = data.primerRespondiente.Nombre_PR;
        apellido_p_identificacion.value    = data.primerRespondiente.Ap_Paterno_PR;
        apellido_m_identificacion.value    = data.primerRespondiente.Ap_Materno_PR;
        num_control_identificacion.value   = data.primerRespondiente.No_Control;
        grado_identificacion.value         = data.primerRespondiente.Cargo;
        unidad_identificacion.value        = data.primerRespondiente.Unidad_Arribo;

        let institucion = false;
        checksIdentificacion.forEach(element=>{
            if(element.value === data.primerRespondiente.Institucion){
                element.checked = true;
                institucion = true;
            }
        });

        if(!institucion && data.primerRespondiente.Institucion != ''){
            checksIdentificacion[6].checked = true;
            cualIdentificacionContent.style.display = 'block';
            cualIdentificacion.value = data.primerRespondiente.Institucion;
        }

        (data.puesta.Num_Elementos != "" && data.puesta.Num_Elementos != null) ? elementos[1].checked = true : elementos[0].checked = true;
        if(elementos[1].checked) cuantosIdentificacionContent.style.display = 'block';
        cuantos_identificacion.value = data.puesta.Num_Elementos;

        checksEntero.forEach(element=>{
            if(element.value === data.hecho.Conocimiento_Hecho){
                element.checked = true;
                if(element.value === 'Llamada de emergencia 911'){
                    cualEmergenciaContent.style.display = 'block';
                    cual_emergencia.value = data.hecho.Especificacion;
                } 
            }
        });

        if(data.hecho.Fecha_Hora_Conocimiento != null){
            fecha_conocimiento.value           = data.hecho.Fecha_Hora_Conocimiento.split(' ')[0];
            hora_conocimiento.value            = data.hecho.Fecha_Hora_Conocimiento.split(' ')[1];
        }
        if(data.hecho.Fecha_Hora_Arribo != null){
            fecha_arribo.value                 = data.hecho.Fecha_Hora_Arribo.split(' ')[0];
            hora_arribo.value                  = data.hecho.Fecha_Hora_Arribo.split(' ')[1];
        }

        if(data.ubicacion != undefined){
            Colonia.value          = data.ubicacion.Colonia;              
            Calle.value            = data.ubicacion.Calle_1;            
            noExterior.value       = data.ubicacion.No_Ext;                 
            noInterior.value       = data.ubicacion.No_Int;                 
            cordY.value            = data.ubicacion.Coordenada_Y;            
            cordX.value            = data.ubicacion.Coordenada_X;            
            CP.value               = data.ubicacion.CP;
            Municipio.value        = data.ubicacion.Municipio;
            Entidad.value          = data.ubicacion.Estado;
            Referencias.value      = data.ubicacion.Referencias;
        }
        
        (data.lugarIntervencion.Inspeccion_Lugar === '1') ? realizoInspeccion[1].checked = true : realizoInspeccion[0].checked = true;
        if(realizoInspeccion[1].checked) realizoInspeccionContent.style.display = 'block';
        (data.lugarIntervencion.Objeto_Encontrado === '1') ? encontroObjeto[1].checked = true : encontroObjeto[0].checked = true;
        (data.lugarIntervencion.Preservar_Lugar === '1') ? preservoLugar[1].checked = true : preservoLugar[0].checked = true;
        
        (data.lugarIntervencion.Priorizacion_Lugar === '1') ? priorizacionLugar[1].checked = true : priorizacionLugar[0].checked = true;
        if(priorizacionLugar[1].checked) priorizacionLugarContent.style.display = 'block';
        riesgoPresentado.forEach(element=>{
            if(element.value === data.lugarIntervencion.Tipo_Riesgo){
                element.checked = true;
            } 
        })
        especifique_riesgo.value = data.lugarIntervencion.Especificacion;

        narrativa.value                    = (data.puesta.Narrativa_Hechos != null) ? data.puesta.Narrativa_Hechos.replace(/[“”]/g,'"') : '';

        if(data.docComplementaria.length > 0){
            if(data.docComplementaria[0].Fotografia != 0) fotografia_check.checked = true;
            if(data.docComplementaria[0].Video != 0)      video_check.checked = true;
            if(data.docComplementaria[0].Audio != 0)      audio_check.checked = true;
            if(data.docComplementaria[0].Certificado != 0) certificado_check.checked = true;
            if(data.docComplementaria[0].Otro != ''){
                otro_check.checked = true;
                document.getElementById('especifique_content').style.display = 'block';
                document.getElementById('otro_especificacion').value = data.docComplementaria[0].Otro;
            }
        }
    });
}