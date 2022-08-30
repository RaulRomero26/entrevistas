const   folio_911                	 	= document.getElementById('svnofolio911'),
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
    	pathFileCDI = pathFilesSeguimientos+`/Vehiculos/${id_seguimiento_vehiculo.value}/CDI/`;


window.onload = function() {
getSeguimientoV();
};

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

        console.log(data);

        folio_911.value = (data.seguimiento_vehiculo[0].Folio_911 === undefined) ? '' : data.seguimiento_vehiculo[0].Folio_911;
        infra.value = (data.seguimiento_vehiculo[0].Folio_Infra === undefined) ? '' : data.seguimiento_vehiculo[0].Folio_Infra;
        celula_seguimiento.value = (data.seguimiento_vehiculo[0].Celula_Seguimiento === undefined) ? '' : data.seguimiento_vehiculo[0].Celula_Seguimiento;
        placa.value = (data.seguimiento_vehiculo[0].Placas === undefined) ? '' : data.seguimiento_vehiculo[0].Placas;
        marca.value = (data.seguimiento_vehiculo[0].Marca === undefined) ? '' : data.seguimiento_vehiculo[0].Marca;
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
        	obra_placa_si.disabled = true;
        }

        else
        {
        	obra_placa_no.checked=true;
        	obra_placa_no.disabled = true;
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
                createElementSeguimientos2(`${pathFilesSeguimientos}Vehiculos/${data.images[i].Id_Seguimiento_V}/Images/${data.images[i].Path_Imagen}`, 'Photo', 'VER');
            }
        }

    })
}

/*
const getImages = ()=>{
    const content = document.getElementById('photos-content-seguimientos');
    const items = content.getElementsByClassName('imagenSV');
    const capturaFotos = [];

    for(let i=0; i<items.length; i++){
    	console.log(items[i]);
        
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
    }
    
    //console.log(capturaFotos);
}
*/