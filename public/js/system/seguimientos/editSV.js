const   msg_seguimientoVehiculoError 	= document.getElementById('msg_seguimientoVehiculo'),
		error_celula_seguimiento 	    = document.getElementById('celula_error'),
		folio_911                	 	= document.getElementById('svnofolio911'),
    	infra              				= document.getElementById('svfolioinfra'),
    	celula_seguimiento       		= document.getElementById('svcelulas'),
    	placa                    		= document.getElementById('svplaca'),
    	marca                    		= document.getElementById('svmarca'),
    	modelo                   		= document.getElementById('svmodelo'),
    	color                    		= document.getElementById('svcolor'),
    	caracteristicas_esp      		= document.getElementById('svcesp'),
    	delito_involucrado       		= document.getElementById('svdv'),
    	pado                     		= document.getElementById('svpado'),
    	no_cdi                   		= document.getElementById('svnumcdi'),
    	obra_placa_si             		= document.getElementById('svobrap_si'),
    	obra_placa_no             		= document.getElementById('svobrap_no'),
    	padr                     		= document.getElementById('svpadr'),
    	banda_delictiva          		= document.getElementById('svvinculodel'),
    	modus_operandi           		= document.getElementById('svmodusoperandi'),
    	id_seguimiento_vehiculo  	 	= document.getElementById('id_sv'),
    	data_edit_sv            	    = document.getElementById('datos_editarSV'), 
    	pathFileCDI = pathFilesSeguimientos+`/Vehiculos/${id_seguimiento_vehiculo.value}/CDI/`;


window.onload = function() {
getSeguimientoV();
};
document.getElementById('editarSV').addEventListener('click',(e)=>{

	e.preventDefault();

    let myFormData = new FormData(data_edit_sv),
    band = [],
    FV = new FormValidator(),
    i = 0;

    //band[i++] = error_folio_911.innerText = FV.validate(myFormData.get('svnofolio911'),'required | numeric');
    //band[i++] = error_folio_infra.innerText = FV.validate(myFormData.get('svfolioinfra'),'required');
    band[i++] = error_celula_seguimiento.innerText = FV.validate(myFormData.get('svcelulas'),'required | numeric');

    let success = true;

    band.forEach(element=>{
        success &= (element == '')?true:false;
    });
    
    if(success){

    	//getImages();


        const elements = document.getElementsByClassName('imagenSV');

        myFormData.append('seguimiento_vehiculo', document.getElementById('datos_editarSV').value);
        myFormData.append('no_id_sv', id_seguimiento_vehiculo.value);
        myFormData.append('svobrap_si', obra_placa_si.checked);
        myFormData.append('svobrap_no', obra_placa_no.checked);
        
        for(let i=0; i<elements.length; i++){
            if(elements[i].getAttribute('type') === 'file'){
                let nameInput = elements[i].name;
                myFormData.append(nameInput, elements[i].files[0]);
            }
        }
        
        getImages().then(res =>{
            myFormData.append('captura_imagenes', JSON.stringify(res));
            fetch(base_url_js + 'Seguimientos/updateSeguimientoV',{
                method: 'POST',
                body: myFormData
            })
            .then(res => res.json())
            .then(data =>{
                if(data.status != 'success'){
                    
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
                }
            })
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

const getSeguimientoV = ()=>{

    const id_sv = document.getElementById('id_sv').value;

    var myFormData  =  new FormData()
    myFormData.append('no_id_sv', id_sv)

    fetch(base_url_js + 'Seguimientos/getSeguimientoVehiculo', {
        method: 'POST',
        body: myFormData
    })

    .then (res => res.json())

    .then( data => {

        folio_911.value = (data.seguimiento_vehiculo[0].Folio_911 === undefined) ? '' : data.seguimiento_vehiculo[0].Folio_911;
        infra.value = (data.seguimiento_vehiculo[0].Folio_Infra === undefined) ? '' : data.seguimiento_vehiculo[0].Folio_Infra;
        celula_seguimiento.value = (data.seguimiento_vehiculo[0].Celula_Seguimiento === undefined) ? '' : data.seguimiento_vehiculo[0].Celula_Seguimiento;
        placa.value = (data.seguimiento_vehiculo[0].Placas === undefined) ? '' : data.seguimiento_vehiculo[0].Placas;
        marca.value = (data.seguimiento_vehiculo[0].Marca === undefined) ? '' : data.seguimiento_vehiculo[0].Marca;
        console.log(data.seguimiento_vehiculo[0].Marca);
        modelo.value = (data.seguimiento_vehiculo[0].Modelo === undefined) ? '' : data.seguimiento_vehiculo[0].Modelo;
        color.value = (data.seguimiento_vehiculo[0].Color === undefined) ? '' : data.seguimiento_vehiculo[0].Color;
        caracteristicas_esp.value = (data.seguimiento_vehiculo[0].Caracteristicas === undefined) ? '' : data.seguimiento_vehiculo[0].Caracteristicas;
        delito_involucrado.value = (data.seguimiento_vehiculo[0].Delito_Involucrado === undefined) ? '' : data.seguimiento_vehiculo[0].Delito_Involucrado;
        pado.value = (data.seguimiento_vehiculo[0].Areas_Operacion === undefined) ? '' : data.seguimiento_vehiculo[0].Areas_Operacion;
        no_cdi.value = (data.seguimiento_vehiculo[0].CDI === undefined) ? '' : data.seguimiento_vehiculo[0].CDI;
        obra_placa_si.value = (data.seguimiento_vehiculo[0].Obra_Placa === undefined) ? '' : data.seguimiento_vehiculo[0].Obra_Placa;
        obra_placa_no.value = (data.seguimiento_vehiculo[0].Obra_Placa === undefined) ? '' : data.seguimiento_vehiculo[0].Obra_Placa;
        if(obra_placa_si.value == '1')
        {
        	obra_placa_si.checked=true;
        }

        else
        {
        	obra_placa_no.checked=true;
        }
        /*
        domicilio_calle.value = (data.domicilio_s_persona[0].Calle === undefined) ? '' : data.domicilio_s_persona[0].Calle;
        domicilio_n_exterior = (data.domicilio_s_persona[0].No_Exterior === undefined) ? '' : data.domicilio_s_persona[0].No_Exterior;
        domicilio_n_interior = (data.domicilio_s_persona[0].No_Interior === undefined) ? '' : data.domicilio_s_persona[0].No_Interior;
        domicilio_colonia = (data.domicilio_s_persona[0].Colonia === undefined) ? '' : data.domicilio_s_persona[0].Colonia;
        domicilio_codigo_postal = (data.domicilio_s_persona[0].CP === undefined) ? '' : data.domicilio_s_persona[0].CP;
        */
        padr.value = (data.seguimiento_vehiculo[0].Areas_Resguardo === undefined) ? '' : data.seguimiento_vehiculo[0].Areas_Resguardo;
        banda_delictiva.value = (data.seguimiento_vehiculo[0].Vinculacion_Banda_Persona === undefined) ? '' : data.seguimiento_vehiculo[0].Vinculacion_Banda_Persona;
        modus_operandi.value = (data.seguimiento_vehiculo[0].Modus_Operandi === undefined) ? '' : data.seguimiento_vehiculo[0].Modus_Operandi;

        if(data.seguimiento_vehiculo[0].Path_CDI != null)
        {
            document.getElementById('viewPDFCDI').innerHTML = `
                <embed src="${pathFileCDI+data.seguimiento_vehiculo[0].Path_CDI}" width="100%" height="400"  type="application/pdf">
            `;
        }

        
        if(data.images.length > 0){
            for(let i=0; i< data.images.length; i++){
                createElementSeguimientos2(`${pathFilesSeguimientos}Vehiculos/${data.images[i].Id_Seguimiento_V}/Images/${data.images[i].Path_Imagen}`, 'Photo', data.images[i].Path_Imagen);
            }
        }

    })
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
    const content = document.getElementById('photos-content-seguimientos2'),
        items = content.getElementsByClassName('imagenSV'),
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