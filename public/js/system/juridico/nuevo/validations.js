let FV = new FormValidator();
const fechaPuesta                = document.getElementById('fecha_puesta'),
    fechaPuesta_error            = document.getElementById('fecha_puesta_error'),
    horaPuesta                   = document.getElementById('hora_puesta'),
    horaPuesta_error             = document.getElementById('hora_puesta'),
    checksIdentificacion         = document.getElementsByName('institucion'),
    cualIdentificacionContent    = document.getElementById('cual_identificacion_content'),
    cualIdentificacion           = document.getElementById('cual_identificacion'),
    elementos                    = document.getElementsByName('elementos'),
    cuantosIdentificacionContent = document.getElementById('cuantos_identificacion_content'),
    cuantosIdentificacion        = document.getElementById('cuantos_identificacion'),
    realizoInspeccionContent     = document.getElementById('realizo_inspeccion_content'),
    realizoInspeccion            = document.getElementsByName('realizo_inspeccion'),
    priorizacionLugarContent     = document.getElementById('priorizacion_lugar_content'),
    priorizacionLugar            = document.getElementsByName('priorizacion_lugar'),
    checksEntero                 = document.getElementsByName('hecho'),
    cualEmergencia               = document.getElementById('cual_emergencia'),
    cualEmergenciaContent        = document.getElementById('cual_emergencia_content'),
    riesgoPresentado             = document.getElementsByName('riesgo_presentado'),
    narrativa                    = document.getElementById('narrativa'),
    encontroObjeto               = document.getElementsByName('encontro_objeto'),
    preservoLugar                = document.getElementsByName('preservo_lugar');

const inputs = [
    {
        id: 'num_folio_iph',
        length: 10
    },
    {
        id: 'ano_folio_iph',
        length: 4
    },
    {
        id: 'turno_folio_iph',
        length: 1
    },
    {
        id: 'nombre_identificacion',
        length: 100
    },
    {
        id: 'apellido_p_identificacion',
        length: 100
    },
    {
        id: 'apellido_m_identificacion',
        length: 100
    },
    {
        id: 'grado_identificacion',
        length: 100
    },
    {
        id: 'narrativa',
        length: 16000000
    }
];

/* ----- ----- ----- Validaciones de inputs ----- ----- ----- */
validateInputs(inputs);

fechaPuesta.addEventListener('input',()=>{
    fechaPuesta_error.textContent = (FV.validarFecha(fechaPuesta.value)) ? '' : 'Elija una fecha correcta';
});

horaPuesta.addEventListener('input',()=>{
    horaPuesta_error.textContent = (FV.validarHora(horaPuesta.value)) ? '' : 'Elija una fecha correcta';
});

checksIdentificacion.forEach(element=>{
    element.addEventListener('change', ()=>{
        if(element.value === 'Otro'){
            cualIdentificacionContent.style.display = 'block';
            const inputs = [
                {
                    id: 'cual_identificacion',
                    length: 100
                }
            ];
            validateInputs(inputs);
        }else{
            cualIdentificacionContent.style.display = 'none';
            cualIdentificacion.value = '';
        }
    })
});

elementos.forEach(element=>{
    element.addEventListener('change', ()=>{
        if(element.value === 'Si'){
            cuantosIdentificacionContent.style.display = 'block';
            const inputs = [
                {
                    id: 'cuantos_identificacion',
                    length: 100
                }
            ];
            validateInputs(inputs);
        }else{
            cuantosIdentificacionContent.style.display = 'none';
            cuantosIdentificacion.value = '';
        }
    })
});

checksEntero.forEach(element=>{
    element.addEventListener('change', ()=>{
        if(element.value === 'Llamada de emergencia 911'){
            cualEmergenciaContent.style.display = 'block';
        }else{
            cualEmergenciaContent.style.display = 'none';
            cualEmergencia.value = '';
        }
    })
});

realizoInspeccion.forEach(element=>{
    element.addEventListener('change', ()=>{
        if(element.value === 'Si'){
            realizoInspeccionContent.style.display = 'block';
        }else{
            realizoInspeccionContent.style.display = 'none';
        }
    })
});

priorizacionLugar.forEach(element=>{
    element.addEventListener('change', ()=>{
        if(element.value === 'Si'){
            priorizacionLugarContent.style.display = 'block';
            const inputs = [
                {
                    id: 'especifique_riesgo',
                    length: 50
                }
            ];
            validateInputs(inputs);
        }else{
            priorizacionLugarContent.style.display = 'none';
            especifique_riesgo.value = '';
        }
    })
});

narrativa.addEventListener('input', ()=>{
    narrativa.value = narrativa.value.replace(/[“”]/g,'"');
})