const  msg_seguimientoPersonaError 	= document.getElementById('msg_seguimientoPersona'),
	   error_celula_seguimiento 	= document.getElementById('Celula_error'),
	   folio911 					= document.getElementById('spnofolio911'),
	   folio_infra 					= document.getElementById('spfolioinfra'),
	   celula_seguimiento			= document.getElementById('spcelulas'),
	   nombre_1						= document.getElementById('spnombre1'),
	   nombre_2						= document.getElementById('spnombre2'),
	   nombre_3						= document.getElementById('spnombre3'),
	   apellido_paterno				= document.getElementById('spappater'),
	   apellido_materno				= document.getElementById('spapmater'),
	   otros_nombres				= document.getElementById('spotrosnomf'),
	   alias						= document.getElementById('spalias'),
	   fecha_nacimiento				= document.getElementById('spfechand'),
	   edad 						= document.getElementById('spedad'),
	   lugar_origen					= document.getElementById('splugaro'),
	   domicilio_calle				= document.getElementById('spdomicilio_calle'),
	   domicilio_n_exterior			= document.getElementById('spdomicilio_numext'),
	   domicilio_n_interior			= document.getElementById('spdomicilio_numint'),
	   domicilio_colonia			= document.getElementById('spdomicilio_colonia'),
	   domicilio_codigo_postal		= document.getElementById('spdomicilio_cp'),
	   domicilio_observacion		= document.getElementById('spdomicilio_observaciones'),
	   telefono						= document.getElementById('sptel'),
	   ocupacion 					= document.getElementById('spocupacion'),
	   red_social					= document.getElementById('spredsocial'),
	   nombre_familiar_conocido		= document.getElementById('spnombrefamc'),
	   parentezco 					= document.getElementById('spparentezco'),
	   vinculacion_b_delictiva		= document.getElementById('spvinculodel'),
	   modus_operandi				= document.getElementById('spmodusoperandi'),
	   numero_cdi					= document.getElementById('spnumcdi'),
	   violencia_si					= document.getElementById('spviolencia_si'),
	   violencia_no					= document.getElementById('spviolencia_no'),
	   tipo_violencia				= document.getElementById('sptipov'),
	   delito_vinculado				= document.getElementById('spdv'),
	   especific_delito				= document.getElementById('spespdd'),
	   principales_areas_o			= document.getElementById('sppado'),
	   principales_areas_r			= document.getElementById('sppadr'),
	   id_seguimiento_persona   	= document.getElementById('id_sp'), 
       id_domicilio                 = document.getElementById('spdomicilio_id_dom'),
       id_img                       = document.getElementById('spimagen'),
       data_edit_sp            	    = document.getElementById('datos_editarSP'),
       pathFileCDI = pathFilesSeguimientos+`/Personas/${id_seguimiento_persona.value}/CDI/`;


window.onload = function() {
    getSeguimientoP();

    let online = window.navigator.onLine;
    if(!online){
        offlineMapsSeguimientos();
    }
};
document.getElementById('editarSP').addEventListener('click',(e)=>{

    e.preventDefault();

    let myFormData = new FormData(data_edit_sp),
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


       /*
       const values = window.location.search,*/
        const elements = document.getElementsByClassName('imagenSP');


        myFormData.append('seguimiento_persona', document.getElementById('datos_editarSP').value);
        myFormData.append('no_id_sp', id_seguimiento_persona.value);
        myFormData.append('no_id_dom', id_domicilio.value);
        myFormData.append('spviolencia_si', violencia_si.checked);
        myFormData.append('spviolencia_no', violencia_no.checked);
        myFormData.append('table_vehiculos', JSON.stringify(readTableSP()));
        
        for(let i=0; i<elements.length; i++){
            if(elements[i].getAttribute('type') === 'file'){
                let nameInput = elements[i].name;
                myFormData.append(nameInput, elements[i].files[0]);
            }
        }
        getImages().then(res=>{
            myFormData.append('captura_imagenes', JSON.stringify(res));
            readTableSenas().then(res=>{
                myFormData.append('senas_table', JSON.stringify(res));
                fetch(base_url_js + 'Seguimientos/updateSeguimientoP',{
                    method: 'POST',
                    body: myFormData
                })
                .then(res => res.json())
                .then(data =>{
    
    
                    if(data.status != 'success'){
                        
                        error_celula_seguimiento.innerHTML = data.Celula_error;
    
                        msg_seguimientoPersonaError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario.</div>'
                    
                        window.scroll({
                            top: 0,
                            left: 100,
                            behavior: 'smooth'
                        });
                    }else{
    
                        console.log(data.Celula_error)
                        msg_seguimientoPersonaError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información guardada con éxito.</div>'
                        window.scroll({
                            top: 0,
                            left: 100,
                            behavior: 'smooth'
                        });
                    }
                })
            });
        })
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


const getSeguimientoP = ()=>{

    const id_sp = document.getElementById('id_sp').value;

    var myFormData  =  new FormData()
    myFormData.append('no_id_sp', id_sp)
    //myFormData.append('no_id_img', id_img)

    fetch(base_url_js + 'Seguimientos/getSeguimientoPersona', {
        method: 'POST',
        body: myFormData
    })

    .then (res => res.json())

    .then( data => {

        console.log(data);
        //console.log(data.seguimiento_persona[0].Imagen);

        folio911.value = (data.seguimiento_persona[0].Folio_911 === undefined) ? '' : data.seguimiento_persona[0].Folio_911.toUpperCase();
        folio_infra.value = (data.seguimiento_persona[0].Folio_Infra === undefined) ? '' : data.seguimiento_persona[0].Folio_Infra.toUpperCase();
        celula_seguimiento.value = (data.seguimiento_persona[0].Celula_Seguimiento === undefined) ? '' : data.seguimiento_persona[0].Celula_Seguimiento;
        nombre_1.value = (data.seguimiento_persona[0].Nombre1 === undefined) ? '' : data.seguimiento_persona[0].Nombre1.toUpperCase();
        nombre_2.value = (data.seguimiento_persona[0].Nombre2 === undefined) ? '' : data.seguimiento_persona[0].Nombre2.toUpperCase();
        nombre_3.value = (data.seguimiento_persona[0].Nombre3 === undefined) ? '' : data.seguimiento_persona[0].Nombre3.toUpperCase();
        apellido_paterno.value = (data.seguimiento_persona[0].Ap_Paterno === undefined) ? '' : data.seguimiento_persona[0].Ap_Paterno.toUpperCase();
        apellido_materno.value = (data.seguimiento_persona[0].Ap_Materno === undefined) ? '' : data.seguimiento_persona[0].Ap_Materno.toUpperCase();
        otros_nombres.value = (data.seguimiento_persona[0].Otros_Nombres_Falsos === undefined) ? '' : data.seguimiento_persona[0].Otros_Nombres_Falsos.toUpperCase();
        alias.value = (data.seguimiento_persona[0].Alias === undefined) ? '' : data.seguimiento_persona[0].Alias.toUpperCase();
        fecha_nacimiento.value = (data.seguimiento_persona[0].Fecha_Nacimiento === undefined) ? '' : data.seguimiento_persona[0].Fecha_Nacimiento;
        edad.value = (data.seguimiento_persona[0].Edad === undefined) ? '' : data.seguimiento_persona[0].Edad;
        lugar_origen.value = (data.seguimiento_persona[0].Lugar_Origen === undefined) ? '' : data.seguimiento_persona[0].Lugar_Origen.toUpperCase();
        
        domicilio_calle.value = (data.seguimiento_persona[0].Calle === undefined) ? '' : data.seguimiento_persona[0].Calle;
        domicilio_n_exterior.value = (data.seguimiento_persona[0].No_Exterior === undefined) ? '' : data.seguimiento_persona[0].No_Exterior;
        domicilio_n_interior.value = (data.seguimiento_persona[0].No_Interior === undefined) ? '' : data.seguimiento_persona[0].No_Interior;
        domicilio_colonia.value = (data.seguimiento_persona[0].Colonia === undefined) ? '' : data.seguimiento_persona[0].Colonia;
        domicilio_codigo_postal.value = (data.seguimiento_persona[0].CP === undefined) ? '' : data.seguimiento_persona[0].CP;
        id_domicilio.value = (data.seguimiento_persona[0].Id_Domicilio === undefined) ? '' : data.seguimiento_persona[0].Id_Domicilio;
    
        telefono.value = (data.seguimiento_persona[0].Telefono === undefined) ? '' : data.seguimiento_persona[0].Telefono;
        ocupacion.value = (data.seguimiento_persona[0].Ocupacion === undefined) ? '' : data.seguimiento_persona[0].Ocupacion.toUpperCase();
        red_social.value = (data.seguimiento_persona[0].Link_Red_Social === undefined) ? '' : data.seguimiento_persona[0].Link_Red_Social.toUpperCase();
        nombre_familiar_conocido.value = (data.seguimiento_persona[0].Nombre_Familiar === undefined) ? '' : data.seguimiento_persona[0].Nombre_Familiar.toUpperCase();
        parentezco.value = (data.seguimiento_persona[0].Parentezco === undefined) ? '' : data.seguimiento_persona[0].Parentezco.toUpperCase();
        vinculacion_b_delictiva.value = (data.seguimiento_persona[0].Vinculo_Grupo_Banda === undefined) ? '' : data.seguimiento_persona[0].Vinculo_Grupo_Banda.toUpperCase();
        modus_operandi.value = (data.seguimiento_persona[0].Modus_Operandi === undefined) ? '' : data.seguimiento_persona[0].Modus_Operandi.toUpperCase();
        numero_cdi.value = (data.seguimiento_persona[0].CDI === undefined) ? '' : data.seguimiento_persona[0].CDI;
        violencia_si.value = (data.seguimiento_persona[0].Violencia === undefined) ? '' : data.seguimiento_persona[0].Violencia;
        violencia_no.value = (data.seguimiento_persona[0].Violencia === undefined) ? '' : data.seguimiento_persona[0].Violencia;
        if(violencia_si.value == '1')
        {
        	violencia_si.checked=true;
        }

        else
        {
        	violencia_no.checked=true;
        }
        
        tipo_violencia.value = (data.seguimiento_persona[0].Tipo_Violencia === undefined) ? '' : data.seguimiento_persona[0].Tipo_Violencia.toUpperCase();
        delito_vinculado.value = (data.seguimiento_persona[0].Delito_Vinculado === undefined) ? '' : data.seguimiento_persona[0].Delito_Vinculado.toUpperCase();
        especific_delito.value = (data.seguimiento_persona[0].Especificacion_Delito === undefined) ? '' : data.seguimiento_persona[0].Especificacion_Delito.toUpperCase();
        principales_areas_o.value = (data.seguimiento_persona[0].Areas_Operacion === undefined) ? '' : data.seguimiento_persona[0].Areas_Operacion.toUpperCase();
        principales_areas_r.value = (data.seguimiento_persona[0].Areas_Resguardo === undefined) ? '' : data.seguimiento_persona[0].Areas_Resguardo.toUpperCase();


        if(data.seguimiento_persona[0].Path_CDI != null)
        {
            document.getElementById('viewPDFCDI').innerHTML = `
                <embed src="${pathFileCDI+data.seguimiento_persona[0].Path_CDI}" width="100%" height="400"  type="application/pdf">
            `;
        }

        if(data.images.length > 0){
            for(let i=0; i< data.images.length; i++){
                createElementSeguimientos(`${pathFilesSeguimientos}Personas/${data.images[i].Id_Seguimiento_P}/Images/${data.images[i].Path_Imagen}`, 'Photo', data.images[i].Path_Imagen);
            }
        }

        if(data.vehiculos.length > 0){
            for(let i=0; i<data.vehiculos.length; i++){
                let formData = {
                    marcaVehiculoSegPer: data.vehiculos[i].Marca,
                    modeloVehiculoSegPer: data.vehiculos[i].Modelo,
                    colorVehiculoSegPer: data.vehiculos[i].Color,
                    placaVehiculoSegPer: data.vehiculos[i].Placas
                }

                insertNewRowSegVehPer(formData);
            }
        }

        if(data.senas.length > 0){
            for(let i=0;i<data.senas.length;i++){
                const lis = createListLI(data.senas[i].Ubicacion_Corporal,data.senas[i].Perfil).toString();
                let formData={
                    selectPerfil: data.senas[i].Perfil,
                    senasparticulares: data.senas[i].Tipo_Senia_Particular,
                    clasificacion: data.senas[i].Clasificacion,
                    colorTatuaje: data.senas[i].Color === '1' ? true:false,
                    descripcion: data.senas[i].Descripcion,
                    list: lis.replace(',','')
                }
                insertNewRowSenas(formData,'sena');
                if(data.senas[i].Path_Imagen.length != 0){
                    createElementSena(`${pathFilesSeguimientos}Personas/${id_sp}/Images/${data.senas[i].Path_Imagen}`, i+1, 'Photo');
                }
            }
        }

        const table = document.getElementById('senas'),
            items = table.getElementsByTagName('li');

        for(let j=0; j<items.length;j++){
            if(!document.getElementById(items[j].id.substring(3)).classList.contains('select-piece')){
                document.getElementById(items[j].id.substring(3)).classList.add('select-piece');
            }
        }

    })
}

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

const getImages = async()=>{
    const content = document.getElementById('photos-content-seguimientos'),
        items = content.getElementsByClassName('imagenSP'),
        capturaFotos = [];
    
    for(let i=0; i<items.length; i++){
        if(items[i].getAttribute('type') === 'file'){
            capturaFotos.push(dataImage('File', items[i].getAttribute('name'), null));
        }else{
            if(items[i].classList[2] != 'undefined'){
                await toDataURL(items[i].src)
                    .then(myBase64=>{
                        capturaFotos.push(dataImage('Photo', items[i].classList[2], myBase64));
                    })
            }
        }
    }
    
    return capturaFotos;
}

const toDataURL = url => fetch(url)
    .then(res => res.blob())
    .then(blob => new Promise((resolve, reject) => {
        const reader = new FileReader()
        reader.onloadend = () => resolve(reader.result)
        reader.onerror = reject
        reader.readAsDataURL(blob)
    }))

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