const msg_seguimientoPersonaError = document.getElementById('msg_seguimientoPersona'),
    error_folio_911          = document.getElementById('No_folio911_error'),
    error_folio_infra        = document.getElementById('No_folioinfra_error'),
    error_celula_seguimiento = document.getElementById('Celula_error'),
    error_nombre1            = document.getElementById('spnombre1_error'),
    error_nombre2            = document.getElementById('spnombre2_error'),
    error_nombre3            = document.getElementById('spnombre3_error'),
    error_apePaterno         = document.getElementById('spappater_error'),
    error_apeMaterno         = document.getElementById('spapmater_error'),
    error_otrosNombres       = document.getElementById('spotrosnomf_error'),
    error_alias              = document.getElementById('spalias_error'),
    error_fechaNacimiento    = document.getElementById('spfechand_error'),
    error_edad               = document.getElementById('spedad_error'),
    error_lugarOrigen        = document.getElementById('splugaro_error'),
    error_calle              = document.getElementById('spdomicilio_calle_error'),
    error_numExterior        = document.getElementById('spdomicilio_numext_error'),
    error_numInterior        = document.getElementById('spdomicilio_numint_error'),
    error_colonia            = document.getElementById('spdomicilio_colonia_error'),
    error_cp                 = document.getElementById('spdomicilio_cp_error'),
    error_observaDomicilio   = document.getElementById('spalias_error'),
    error_numeroTel          = document.getElementById('sptel_error'),
    error_ocupacion          = document.getElementById('spocupacion_error'),
    error_redSocial          = document.getElementById('spredsocial_error'),
    error_nombreFami         = document.getElementById('spnombrefamc_error'),
    error_parentezco         = document.getElementById('spparentezco_error'),
    error_probableVin        = document.getElementById('spvinculodel_error'),
    data_nuevo_sp            = document.getElementById('datos_nuevoSP');

document.getElementById('crearSPid').addEventListener('click',(e)=>{

    e.preventDefault();

    let myFormData = new FormData(data_nuevo_sp),
    band = [],
    FV = new FormValidator(),
    i = 0;

    //band[i++] = error_folio_911.innerText = FV.validate(myFormData.get('spnofolio911'),'required | numeric');
    //band[i++] = error_folio_infra.innerText = FV.validate(myFormData.get('spfolioinfra'),'required');
    band[i++] = error_celula_seguimiento.innerText = FV.validate(myFormData.get('spcelulas'),'required | numeric');
    /* 
    band[i++] = error_nombre1.innerText = FV.validate(myFormData.get('spnombre1'),'required');
    band[i++] = error_nombre2.innerText = FV.validate(myFormData.get('spnombre2'),'required');
    band[i++] = error_nombre3.innerText = FV.validate(myFormData.get('spnombre3'),'required');
    band[i++] = error_apePaterno.innerText = FV.validate(myFormData.get('spappater'),'required');
    band[i++] = error_apeMaterno.innerText = FV.validate(myFormData.get('spapmater'),'required');
    band[i++] = error_otrosNombres.innerText = FV.validate(myFormData.get('spotrosnomf'),'required');
    band[i++] = error_alias.innerText = FV.validate(myFormData.get('spalias'),'required');
    band[i++] = error_fechaNacimiento.innerText = FV.validate(myFormData.get('spfechand'),'required');
    band[i++] = error_edad.innerText = FV.validate(myFormData.get('spedad'),'required');
    band[i++] = error_lugarOrigen.innerText = FV.validate(myFormData.get('splugaro'),'required');
    band[i++] = error_calle.innerText = FV.validate(myFormData.get('spdomicilio_calle'),'required');
    band[i++] = error_numExterior.innerText = FV.validate(myFormData.get('spdomicilio_numext'),'required');
    band[i++] = error_numInterior.innerText = FV.validate(myFormData.get('spdomicilio_numint'),'required');
    band[i++] = error_colonia.innerText = FV.validate(myFormData.get('spdomicilio_colonia'),'required');
    band[i++] = error_cp.innerText = FV.validate(myFormData.get('spdomicilio_cp'),'required');
    band[i++] = error_numeroTel.innerText = FV.validate(myFormData.get('sptel'),'required');
    band[i++] = error_ocupacion.innerText = FV.validate(myFormData.get('spocupacion'),'required');
    band[i++] = error_redSocial.innerText = FV.validate(myFormData.get('spredsocial'),'required');
    band[i++] = error_nombreFami.innerText = FV.validate(myFormData.get('spnombrefamc'),'required');
    band[i++] = error_parentezco.innerText = FV.validate(myFormData.get('spparentezco'),'required');
    band[i++] = error_probableVin.innerText = FV.validate(myFormData.get('spvinculodel'),'required'); 
    */

    let success = true;

    band.forEach(element=>{
        success &= (element == '')?true:false;
    });
    
    if(success){
        
       const elements = document.getElementsByClassName('imagenSP');


        myFormData.append('seguimiento_persona', document.getElementById('datos_nuevoSP').value);
        myFormData.append('captura_imagenes', JSON.stringify(getImages()));
        myFormData.append('table_vehiculos', JSON.stringify(readTableSP()));


        for(let i=0; i<elements.length; i++){
            if(elements[i].getAttribute('type') === 'file'){
                let nameInput = elements[i].name;
                myFormData.append(nameInput, elements[i].files[0]);
            }
        }

        readTableSenas().then(res=>{
            myFormData.append('senas_table', JSON.stringify(res));
            fetch(base_url_js + 'Seguimientos/insertSeguimientoP',{
                method: 'POST',
                body: myFormData
            })
            .then(res => res.json())
            .then(data =>{
                console.log(data);


                if(data.status != 'success'){
                    //console.log("El data.status de javascript es: "+data.status)
                    
                    error_celula_seguimiento.innerHTML = data.Celula_error;

                    msg_seguimientoPersonaError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario.</div>'
                
                    window.scroll({
                        top: 0,
                        left: 100,
                        behavior: 'smooth'
                    });
                }else{

                    //document.getElementById('datos_nuevoSP').reset()
                    //console.log("El data.status de javascript es: "+data.status)
                    //console.log(data.Celula_error)
                    msg_seguimientoPersonaError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información guardada con éxito.</div>'
                    window.scroll({
                        top: 0,
                        left: 100,
                        behavior: 'smooth'
                    });
                    document.getElementById('Celula_error').style.display = 'none';
                    setInterval(()=>{
                                window.location = base_url_js+"Seguimientos"
                            },2500)
                }
            })
        });
    }
    else{
        msg_seguimientoPersonaError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario.</div>'
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });
    }

});


const readTableSP = ()=>{
    const table = document.getElementById('seguimientoVehiculosPer');
    let vehiculos = [];

    for(let i=1; i<table.rows.length;i++){
        vehiculos.push({
            ['row']:{
                marca: table.rows[i].cells[0].innerHTML,
                modelo: table.rows[i].cells[1].innerHTML,
                color: table.rows[i].cells[2].innerHTML,
                placa: table.rows[i].cells[3].innerHTML
            }
        })
    }

    return vehiculos;
}


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
    const content = document.getElementById('photos-content-seguimientos'),
        items = content.getElementsByClassName('imagenSP'),
        capturaFotos = [];
    
    for(let i=0; i<items.length; i++){
        if(items[i].getAttribute('type') === 'file'){
            capturaFotos.push(dataImage('File', items[i].getAttribute('name'), null));
        }
    }
    
    return capturaFotos;
}

const readTableSenas = async()=>{
    const table = document.getElementById('senas');
    let senas = [];
    if(table.rows.length>1){


        for(let i=1;i<table.rows.length;i++){
            const items = table.rows[i].cells[1].getElementsByTagName('li'),
                input = table.rows[i].cells[6].children[1].children[0];

            let partes = [];

            for(let j=0;j<items.length;j++){
                partes.push(items[j].innerHTML);
            }

            if(input != undefined){
                const type = input.children[2].classList[1],
                    index = input.children[2].classList[0],
                    base64 = document.getElementById('images_row_'+index);
                nameImage = 'sena_row'+index;
                if(type != 'File'){
                    isPNG = base64.src.split('.');
                    if(isPNG[1] != undefined){
                        await toDataURL(base64.src)
                            .then(myBase64=>{
                                senas.push(dataImageSenas(table.rows[i].cells[0].innerHTML,partes.toString(),table.rows[i].cells[2].innerHTML,table.rows[i].cells[3].innerHTML.length != 0 ? true:false,table.rows[i].cells[4].innerHTML,table.rows[i].cells[5].innerHTML,type,nameImage,myBase64));
                            })
                    }else{
                        senas.push(dataImageSenas(table.rows[i].cells[0].innerHTML,partes.toString(),table.rows[i].cells[2].innerHTML,table.rows[i].cells[3].innerHTML.length != 0 ? true:false,table.rows[i].cells[4].innerHTML,table.rows[i].cells[5].innerHTML,type,nameImage,base64.src));
                    }
                }else{
                    senas.push(dataImageSenas(table.rows[i].cells[0].innerHTML,partes.toString(),table.rows[i].cells[2].innerHTML,table.rows[i].cells[3].innerHTML.length != 0 ? true:false,table.rows[i].cells[4].innerHTML,table.rows[i].cells[5].innerHTML,type,nameImage,null));
                }
            }else{
                senas.push(dataImageSenas(table.rows[i].cells[0].innerHTML,partes.toString(),table.rows[i].cells[2].innerHTML,table.rows[i].cells[3].innerHTML.length != 0 ? true:false,table.rows[i].cells[4].innerHTML,table.rows[i].cells[5].innerHTML,null,null,null));
            }
        }
    }
    return senas;
}

const dataImageSenas = (perfil, partes, tipo, color, clasificacion, descripcion, typeImage, nameImage, dataImage)=>{
    return {
        ['row']: {
            perfil : perfil,
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

window.onload = function() {

    let online = window.navigator.onLine;
    if(!online){
        offlineMapsSeguimientos();
    }
};