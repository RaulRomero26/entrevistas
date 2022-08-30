const  folio911 					= document.getElementById('spnofolio911'),
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
       data_nuevo_sp            	= document.getElementById('datos_nuevoSP'),
       pathFileCDI = pathFilesSeguimientos+`/Personas/${id_seguimiento_persona.value}/CDI/`;


window.onload = function() {
getSeguimientoP();
};

const getSeguimientoP = ()=>{

    const id_sp = document.getElementById('id_sp').value;

    var myFormData  =  new FormData()
    myFormData.append('no_id_sp', id_sp)

    fetch(base_url_js + 'Seguimientos/getSeguimientoPersona', {
        method: 'POST',
        body: myFormData
    })

    .then (res => res.json())

    .then( data => {

        console.log(data);

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

        domicilio_calle.value = (data.seguimiento_persona[0].Calle === undefined || data.seguimiento_persona[0].Calle === null) ? '' : data.seguimiento_persona[0].Calle.toUpperCase();
        domicilio_n_exterior.value = (data.seguimiento_persona[0].No_Exterior === undefined) ? '' : data.seguimiento_persona[0].No_Exterior;
        domicilio_n_interior.value = (data.seguimiento_persona[0].No_Interior === undefined) ? '' : data.seguimiento_persona[0].No_Interior;
        domicilio_colonia.value = (data.seguimiento_persona[0].Colonia === undefined || data.seguimiento_persona[0].Colonia === null) ? '' : data.seguimiento_persona[0].Colonia.toUpperCase();
        domicilio_codigo_postal.value = (data.seguimiento_persona[0].CP === undefined) ? '' : data.seguimiento_persona[0].CP;

        telefono.value = (data.seguimiento_persona[0].Telefono === undefined) ? '' : data.seguimiento_persona[0].Telefono;
        ocupacion.value = (data.seguimiento_persona[0].Ocupacion === undefined) ? '' : data.seguimiento_persona[0].Ocupacion.toUpperCase();
        red_social.value = (data.seguimiento_persona[0].Link_Red_Social === undefined) ? '' : data.seguimiento_persona[0].Link_Red_Social.toUpperCase();
        nombre_familiar_conocido.value = (data.seguimiento_persona[0].Nombre_Familiar === undefined) ? '' : data.seguimiento_persona[0].Nombre_Familiar.toUpperCase();
        parentezco.value = (data.seguimiento_persona[0].Parentezco === undefined) ? '' : data.seguimiento_persona[0].Parentezco.toUpperCase();
        vinculacion_b_delictiva.value = (data.seguimiento_persona[0].Vinculo_Grupo_Banda === undefined) ? '' : data.seguimiento_persona[0].Vinculo_Grupo_Banda.toUpperCase();
        modus_operandi.value = (data.seguimiento_persona[0].Modus_Operandi === undefined) ? '' : data.seguimiento_persona[0].Modus_Operandi.toUpperCase();
        numero_cdi.value = (data.seguimiento_persona[0].CDI === undefined) ? '' : data.seguimiento_persona[0].CDI.toUpperCase();
        violencia_si.value = (data.seguimiento_persona[0].Violencia === undefined) ? '' : data.seguimiento_persona[0].Violencia;
        violencia_no.value = (data.seguimiento_persona[0].Violencia === undefined) ? '' : data.seguimiento_persona[0].Violencia;
        if(violencia_si.value == '1')
        {
        	violencia_si.checked=true;
        	violencia_si.disabled = true;
        }

        else
        {
        	violencia_no.checked=true;
        	violencia_no.disabled = true;
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
                createElementSeguimientos(`${pathFilesSeguimientos}Personas/${data.images[i].Id_Seguimiento_P}/Images/${data.images[i].Path_Imagen}`, 'Photo', 'VER');
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

                insertNewRowSegVehPer(formData, 'view');
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
                insertNewRowSenas(formData,'view');
                if(data.senas[i].Path_Imagen.length != 0){
                    createElementSena(`${pathFilesSeguimientos}Personas/${id_sp}/Images/${data.senas[i].Path_Imagen}`, i+1, 'Photo', 'view');
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


const getImages = ()=>{
    const content = document.getElementById('photos-content-seguimientos');
    const items = content.getElementsByClassName('imagenSP');
    const capturaFotos = [];

    for(let i=0; i<items.length; i++){
    	console.log(items[i]);
        /*
        let descripcion = items[i].classList[1].split("_");
        console.log(descripcion+" ");
        let image = document.getElementById('image_'+descripcion[0]+'_'+descripcion[1]);

//        if(image.classList[1] != 'File'){
            dataImage = image.src;
            typeImage = 'File';
//        }

        
        else
        {
            dataImage = null;
            typeImage = 'File';
        }

        
        
        capturaFotos.push({
            ['row']: {
                tipo: descripcion[0],
                //perfil: descripcion[1],
                type: typeImage,
                name: descripcion[0]+'_'+descripcion[1],
                image: dataImage
            }
        });
    */
    }
    
    //console.log(capturaFotos);
}