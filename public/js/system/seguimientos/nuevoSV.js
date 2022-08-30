const msg_seguimientoVehiculoError = document.getElementById('msg_seguimientoVehiculo'),
    error_folio_911               = document.getElementById('no_folio911_error'),
    error_folio_infra             = document.getElementById('no_folioinfra_error'),
    error_celula_seguimiento      = document.getElementById('celula_error'),
    error_placa                   = document.getElementById('placa_error'),
    error_marca                   = document.getElementById('marca_error'),
    error_modelo                  = document.getElementById('modelo_error'),
    error_color                   = document.getElementById('color_error'),
    error_caracteristicas_esp     = document.getElementById('caracteristicas_esp_error'),
    error_delito_involucrado      = document.getElementById('delito_involucrado_error'),
    error_pado                    = document.getElementById('pado_error'),
    error_no_cdi                  = document.getElementById('no_cdi_error'),
    error_obra_placa              = document.getElementById('obra_p_error'),
    error_padr                    = document.getElementById('padr_error'),
    error_banda_delictiva         = document.getElementById('banda_delictiva_error'),
    error_modus_operandi          = document.getElementById('modus_operandi_error'),
    data_nuevo_sv                 = document.getElementById('datos_nuevoSV');

document.getElementById('crearSVid').addEventListener('click',(e)=>{

    e.preventDefault();

    let myFormData = new FormData(data_nuevo_sv),
    band = [],
    FV = new FormValidator(),
    i = 0;

    //band[i++] = error_folio_911.innerText = FV.validate(myFormData.get('spnofolio911'),'required | numeric');
    //band[i++] = error_folio_infra.innerText = FV.validate(myFormData.get('spfolioinfra'),'required');
    band[i++] = error_celula_seguimiento.innerText = FV.validate(myFormData.get('svcelulas'),'required | numeric');
    /* 
    band[i++] = error_placa.innerText = FV.validate(myFormData.get('svplaca'),'required');
    band[i++] = error_marca.innerText = FV.validate(myFormData.get('svmarca'),'required');
    band[i++] = error_modelo.innerText = FV.validate(myFormData.get('svmodelo'),'required');
    band[i++] = error_color.innerText = FV.validate(myFormData.get('svcolor'),'required');
    band[i++] = error_caracteristicas_esp.innerText = FV.validate(myFormData.get('svcesp'),'required');
    band[i++] = error_delito_involucrado.innerText = FV.validate(myFormData.get('svdv'),'required');
    band[i++] = error_pado.innerText = FV.validate(myFormData.get('svpado'),'required');
    band[i++] = error_no_cdi.innerText = FV.validate(myFormData.get('svnumcdi'),'required');
    band[i++] = error_obra_placa.innerText = FV.validate(myFormData.get('svobrap'),'required');
    band[i++] = error_padr.innerText = FV.validate(myFormData.get('svpadr'),'required');
    band[i++] = error_banda_delictiva.innerText = FV.validate(myFormData.get('svvinculodel'),'required');
    band[i++] = error_modus_operandi.innerText = FV.validate(myFormData.get('svmodusoperandi'),'required');
    */

    let success = true;

    band.forEach(element=>{
        success &= (element == '')?true:false;
    });
    
    if(success){

        const elements = document.getElementsByClassName('imagenSV');


        myFormData.append('seguimiento_vehiculo', document.getElementById('datos_nuevoSV').value);
        myFormData.append('captura_imagenes', JSON.stringify(getImages()));

        for(let i=0; i<elements.length; i++){
            if(elements[i].getAttribute('type') === 'file'){
                let nameInput = elements[i].name;
                myFormData.append(nameInput, elements[i].files[0]);
            }
        }

        fetch(base_url_js + 'Seguimientos/insertSeguimientoV',{
            method: 'POST',
            body: myFormData
        })
        .then(res => res.json())
        .then(data =>{
        	console.log(data);

            if(data.status != 'success'){
            	//console.log("El data.status de javascript es: "+data.status)
            	
                error_celula_seguimiento.innerHTML = data.celula_error;

                msg_seguimientoVehiculoError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario.</div>'
            
                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });
            }else{

                console.log(data.celula_error)
                msg_seguimientoVehiculoError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información guardada con éxito.</div>'
                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });
                document.getElementById('celula_error').style.display = 'none';
                setInterval(()=>{
                                window.location = base_url_js+"Seguimientos"
                            },2500)
            }
        })
    }
    else{
        msg_seguimientoVehiculoError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario.</div>'
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });
    }

});

const dataImage = (type, name, image)=>{
    return {
        ['row']:{
            tipo: type,
            name: name, 
            image: image
        }
    }
}

const getImages = ()=>{
    const content = document.getElementById('photos-content-seguimientos2'),
        items = content.getElementsByClassName('imagenSV'),
        capturaFotos = [];
    
    for(let i=0; i<items.length; i++){
        if(items[i].getAttribute('type') === 'file'){
            capturaFotos.push(dataImage('File', items[i].getAttribute('name'), null));
        }
    }
    
    return capturaFotos;
}