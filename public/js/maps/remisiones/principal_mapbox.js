/*Archivo hecho para manejar los 4 mapas de remisiones, con mapbox, se hizo 
de manera independiente a google maps para que no chocara con los ids*/
const hechos_mapbox = {
    'porDireccion': document.getElementById('por_direccion_hechos'),
    'porCoordenada': document.getElementById('por_coordenadas_hechos'),
    'searchDireccion': document.getElementById('dir_hechos'),
    'searchCoordenadaY': document.getElementById('search_cy_hechos'),
    'searchCoordenadaX': document.getElementById('search_cx_hechos'),
    'buscar': document.getElementById('buscar_hechos'),
    'Colonia': document.getElementById('Colonia_hechos'),
    'Calle': document.getElementById('Calle_hechos'),
    'Interior': document.getElementById('noInterior_hechos'),
    'Exterior': document.getElementById('noExterior_hechos'),
    'coordenadaX': document.getElementById('cordX_hechos'),
    'coordenadaY': document.getElementById('cordY_hechos'),
    'codigo_postal': document.getElementById('CP_hechos'),
    'Estado': '',
    'Municipio': ''
}
const principales_mapbox = {
    'porDireccion': document.getElementById('por_direccion'),
    'porCoordenada': document.getElementById('por_coordenadas'),
    'searchDireccion': document.getElementById('dir'),
    'searchCoordenadaY': document.getElementById('search_cy'),
    'searchCoordenadaX': document.getElementById('search_cx'),
    'buscar': document.getElementById('buscar'),
    'colonia': document.getElementById('Colonia'),
    'calle': document.getElementById('Calle'),
    'noInterior': document.getElementById('noInterior'),
    'noExterior': document.getElementById('noExterior'),
    'coordenadaY': document.getElementById('cordY'),
    'coordenadaX': document.getElementById('cordX'),
    'cp': document.getElementById('CP'),
    'errorMap': document.getElementById('errorMap'),
    'Estado': document.getElementById('Estado'),
    'Municipio': document.getElementById('Municipio')
}
const peticionario_mapbox = {
    'porDireccion': document.getElementById('por_direccion_peticionario'),
    'porCoordenada': document.getElementById('por_coordenadas_peticionario'),
    'searchDireccion': document.getElementById('dir_peticionario'),
    'searchCoordenadaY': document.getElementById('search_cy_peticionario'),
    'searchCoordenadaX': document.getElementById('search_cx_peticionario'),
    'buscar': document.getElementById('buscar_peticionario'),
    'colonia': document.getElementById('Colonia_peticionario'),
    'calle': document.getElementById('Calle_peticionario'),
    'noInterior': document.getElementById('noInterior_peticionario'),
    'noExterior': document.getElementById('noExterior_peticionario'),
    'coordenadaY': document.getElementById('cordY_peticionario'),
    'coordenadaX': document.getElementById('cordX_peticionario'),
    'cp': document.getElementById('CP_peticionario'),
    'errorMap': document.getElementById('errorMap_peticionario'),
    'Estado': document.getElementById('Estado_peticionario'),
    'Municipio': document.getElementById('Municipio_peticionario')
}
const detencion_mapbox = {
    'porDireccion': document.getElementById('por_direccion_detencion'),
    'porCoordenada': document.getElementById('por_coordenadas_detencion'),
    'searchDireccion': document.getElementById('dir_detencion'),
    'searchCoordenadaY': document.getElementById('search_cy_detencion'),
    'searchCoordenadaX': document.getElementById('search_cx_detencion'),
    'buscar': document.getElementById('buscar_detencion'),
    'colonia': document.getElementById('Colonia_detencion'),
    'calle': document.getElementById('Calle_1_detencion'),
    'calle2': document.getElementById('Calle_2_detencion'),
    'noInterior': document.getElementById('noInterior_detencion'),
    'noExterior': document.getElementById('noExterior_detencion'),
    'coordenadaY': document.getElementById('cordY_detencion'),
    'coordenadaX': document.getElementById('cordX_detencion'),
    'cp': document.getElementById('CP_detencion'),
    'errorMap': document.getElementById('errorMap_detencion'),
    'Estado': document.getElementById('Estado_detencion'),
    'Municipio': document.getElementById('Municipio_detencion')
}
const offlineMapsPrincipal_MAPBOX = () => {

    document.getElementById("map_mapbox").innerHTML=document.getElementById("map_mapbox2").innerHTML=document.getElementById("map_mapbox3").innerHTML=document.getElementById("map_mapbox4").innerHTML = `
        <div class="d-flex align-items-center" style="height:100%">
            <div>
                <span class="badge badge-pill badge-warning">Sin conexión a internet</span>
                <h2 class="my-4" style="color:#88072D">¡OH NO! ERROR 404</h2>
                <p>Lo sentimos, al parecer no tienes conexión a internet ó la señal es muy débil.</p>
            </div>
        </div>
    `;
}
const getColoniasCalles = async(e) => {
    switch(e.target.id){
        case "buscar_direccion_hechos":
            coord_x = hechos_mapbox['coordenadaX'].value;
            coord_y =  hechos_mapbox['coordenadaY'].value;
            error_coord_x = document.getElementById("cordX_hechos_error");
            error_coord_y = document.getElementById("cordY_hechos_error");
            (document.getElementById("CP_hechos_error")).textContent="";
            (document.getElementById("Calle_hechos_error")).textContent="";
            break;
        case "buscar_direccion_peticionario":
            coord_x = peticionario_mapbox['coordenadaX'].value;
            coord_y =  peticionario_mapbox['coordenadaY'].value;
            error_coord_x = document.getElementById("cordX_peticionario_error");
            error_coord_y = document.getElementById("cordY_peticionario_error");
            (document.getElementById("CP_peticionario_error")).textContent="";
            (document.getElementById("Calle_peticionario_error")).textContent="";
            break;
        case "buscar_direccion_principales":
            coord_x = principales_mapbox['coordenadaX'].value;
            coord_y =  principales_mapbox['coordenadaY'].value;
            error_coord_x = document.getElementById("cordY_principales_error");
            error_coord_y = document.getElementById("cordX_principales_error");
            (document.getElementById("CP_principales_error")).textContent="";
            (document.getElementById("Calle_principales_error")).textContent="";
            break;
        case "buscar_direccion_detencion":
            coord_x = detencion_mapbox['coordenadaX'].value;
            coord_y =  detencion_mapbox['coordenadaY'].value;
            error_coord_x = document.getElementById("cordX_detencion_error");
            error_coord_y = document.getElementById("cordY_detencion_error");
            (document.getElementById("CP_detencion_error")).textContent="";
            (document.getElementById("Calle_1_detencion_error")).textContent="";
            break;
    }
    
    var FV = new FormValidator();
    if(coord_x=="" || coord_y==""){
        error_coord_x.textContent = FV.validate(coord_x, "required | max_length[50]");
        error_coord_y.textContent = FV.validate(coord_y, "required |max_length[50]");
    }
    else{
        error_coord_x.textContent="";
        error_coord_y.textContent="";
        switch(e.target.id){
            case "buscar_direccion_hechos":
                map_hechos.flyTo({
                    center: [
                    coord_x,
                    coord_y
                    ],
                    zoom: 18,
                    essential: true
                    });
                    marker.setLngLat([coord_x,coord_y])
                break;
            case "buscar_direccion_peticionario":
                map_peticionario.flyTo({
                    center: [
                        coord_x,
                        coord_y
                    ],
                    zoom: 18,
                    essential: true
                    });
                    marker_peticionario.setLngLat([coord_x,coord_y])
                break;
            case "buscar_direccion_principales":
                map_principales.flyTo({
                    center: [
                        coord_x,
                        coord_y
                    ],
                    zoom: 18,
                    essential: true
                    });
                    marker_principales.setLngLat([coord_x,coord_y])
                break;
            case "buscar_direccion_detencion":
                map_detencion.flyTo({
                    center: [
                        coord_x,
                        coord_y
                    ],
                    zoom: 18,
                    essential: true
                    });
                    marker_detencion.setLngLat([coord_x,coord_y])
                break;
        }
        var lngLat = {
            lng : coord_x,
            lat : coord_y,
        }
        direccion = await getDireccion(lngLat)
        mun_="";esta_="";codi_="";calle_="";nume_="";coloni_="";esta_2="";
        for(i=0;i<(direccion.features).length;i++){
            if((direccion.features[i].id).includes("place"))
                mun_=direccion.features[i].place_name
            if((direccion.features[i].id).includes("region"))
                esta_=direccion.features[i].place_name
            if((direccion.features[i].id).includes("postcode"))
                codi_=direccion.features[i].place_name
            if((direccion.features[i].id).includes("address")){
                calle_=direccion.features[i].text
                nume_=direccion.features[i].address
            }
            if((direccion.features[i].id).includes("locality"))
                coloni_=direccion.features[i].text
            
        }
        switch(e.target.id){
            case "buscar_direccion_hechos":
                hechos_mapbox['Municipio'].value=(mun_.split(","))[0]
                hechos_mapbox['Estado'].value=(esta_.split(","))[0]
                hechos_mapbox['codigo_postal'].value=(codi_.split(","))[((codi_.split(","))).length-2]
            //    hechos_mapbox['Calle'].value=(calle_.split(","))[0]
                hechos_mapbox['Exterior'].value=nume_
                if(esta_=="")
                    peticionario_mapbox['Estado'].value=(codi_.split(","))[0]
                break;
            case "buscar_direccion_peticionario":
                peticionario_mapbox['Municipio'].value=(mun_.split(","))[0]
                peticionario_mapbox['Estado'].value=(esta_.split(","))[0]
                peticionario_mapbox['cp'].value=(codi_.split(","))[((codi_.split(","))).length-2]
                if(esta_=="")
                    peticionario_mapbox['Estado'].value=(codi_.split(","))[0]
                if(!((document.getElementById('domicilio_puebla_peticionario')).checked)){
                    peticionario_mapbox['calle'].value=(calle_.split(","))[0]
                    peticionario_mapbox['colonia'].value=coloni_
                }                   
                peticionario_mapbox['noExterior'].value=nume_
                if(peticionario_mapbox['Estado'].value=="Mexico City")
                    peticionario_mapbox['Estado'].value="CIUDAD DE MEXICO"
                if(peticionario_mapbox['Municipio'].value=="Mexico City")
                    peticionario_mapbox['Municipio'].value="CIUDAD DE MEXICO"
                break;
            case "buscar_direccion_principales":
                principales_mapbox['Municipio'].value=(mun_.split(","))[0]
                principales_mapbox['Estado'].value=(esta_.split(","))[0]
                if(esta_=="")
                    principales_mapbox['Estado'].value=(codi_.split(","))[0]
                principales_mapbox['cp'].value=(codi_.split(","))[((codi_.split(","))).length-2]
                if(!((document.getElementById('domicilio_puebla')).checked)){
                    principales_mapbox['calle'].value=(calle_.split(","))[0]
                    principales_mapbox['colonia'].value=coloni_
                }
                principales_mapbox['noExterior'].value=nume_
                if(principales_mapbox['Estado'].value=="Mexico City")
                    principales_mapbox['Estado'].value="CIUDAD DE MEXICO"
                if(principales_mapbox['Municipio'].value=="Mexico City")
                    principales_mapbox['Municipio'].value="CIUDAD DE MEXICO"
                break;
            case "buscar_direccion_detencion":
                detencion_mapbox['Municipio'].value=(mun_.split(","))[0]
                detencion_mapbox['Estado'].value=(esta_.split(","))[0]
                detencion_mapbox['cp'].value=(codi_.split(","))[((codi_.split(","))).length-2]
                if(esta_=="")
                    detencion_mapbox['Estado'].value=(codi_.split(","))[0]
                if(!((document.getElementById('domicilio_puebla_detencion')).checked)){
                    detencion_mapbox['calle'].value=(calle_.split(","))[0]
                    detencion_mapbox['colonia'].value=coloni_
                }
                detencion_mapbox['noExterior'].value=nume_
                if(detencion_mapbox['Estado'].value=="Mexico City")
                    detencion_mapbox['Estado'].value="CIUDAD DE MEXICO"
                if(detencion_mapbox['Municipio'].value=="Mexico City")
                    detencion_mapbox['Municipio'].value="CIUDAD DE MEXICO"
                break;
        }
    }
}
const getLngLat = async (e) => {
    switch(e.target.id){
        case "buscar_coordenadas_hechos":
            calle = hechos_mapbox['Calle'].value;
            numero =  hechos_mapbox['Exterior'].value;
            codigopostal =  hechos_mapbox['codigo_postal'].value;
            error_codigop = document.getElementById("CP_hechos_error");
            error_calle_1 = document.getElementById("Calle_hechos_error");
            (document.getElementById("cordX_hechos_error")).textContent="";
            (document.getElementById("cordY_hechos_error")).textContent="";
            break;
        case "buscar_coordenadas_peticionario":
            calle = peticionario_mapbox['calle'].value;
            numero =  peticionario_mapbox['noExterior'].value;
            codigopostal =  peticionario_mapbox['cp'].value;
            error_codigop = document.getElementById("CP_peticionario_error");
            error_calle_1 = document.getElementById("Calle_peticionario_error");
            (document.getElementById("cordX_peticionario_error")).textContent="";
            (document.getElementById("cordY_peticionario_error")).textContent="";
            break;
        case "buscar_coordenadas_principales":
            calle = principales_mapbox['calle'].value;
            numero =  principales_mapbox['noExterior'].value;
            codigopostal =  principales_mapbox['cp'].value;
            error_codigop = document.getElementById("CP_principales_error");
            error_calle_1 = document.getElementById("Calle_principales_error");
            (document.getElementById("cordY_principales_error")).textContent="";
            (document.getElementById("cordX_principales_error")).textContent="";
            break;
        case "buscar_coordenadas_detencion":
            calle = detencion_mapbox['calle'].value;
            numero =  detencion_mapbox['noExterior'].value;
            codigopostal =  detencion_mapbox['cp'].value;
            error_codigop = document.getElementById("CP_detencion_error");
            error_calle_1 = document.getElementById("Calle_1_detencion_error");
            (document.getElementById("cordX_detencion_error")).textContent="";
            (document.getElementById("cordY_detencion_error")).textContent="";
            break;

    }
    
    var FV = new FormValidator();
    if(calle=="" || codigopostal==""){
        error_calle_1.textContent = FV.validate(calle, "required | max_length[50]");
        error_codigop.textContent = FV.validate(codigopostal, "required |max_length[50]");
    }
    else{
        error_calle_1.textContent="";
        error_codigop.textContent="";
        cadena = '';
        calle = calle.split(' ');
        
        for(call of calle){
            cadena+=`${call},`
        }
        cadena+=`${numero},`
        cadena+=`${codigopostal}`
        try {
            const response = await fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${cadena}.json?access_token=${mapboxgl.accessToken}&limit=1`, {
                method: 'GET',
                mode: 'cors', // <---
                cache: 'default'          
            });
            const data = await response.json();
            switch(e.target.id){
                case "buscar_coordenadas_hechos":
                    hechos_mapbox['coordenadaX'].value=data.features[0].geometry.coordinates[0]
                    hechos_mapbox['coordenadaY'].value=data.features[0].geometry.coordinates[1]
                    map_hechos.flyTo({
                        center: [
                        data.features[0].geometry.coordinates[0],
                        data.features[0].geometry.coordinates[1]
                        ],
                        zoom: 18,
                        essential: true
                        });
                        marker.setLngLat([data.features[0].geometry.coordinates[0],data.features[0].geometry.coordinates[1]])
                    break;
                case "buscar_coordenadas_peticionario":
                    peticionario_mapbox['coordenadaX'].value=data.features[0].geometry.coordinates[0]
                    peticionario_mapbox['coordenadaY'].value=data.features[0].geometry.coordinates[1]
                    map_peticionario.flyTo({
                        center: [
                        data.features[0].geometry.coordinates[0],
                        data.features[0].geometry.coordinates[1]
                        ],
                        zoom: 18,
                        essential: true
                        });
                        marker_peticionario.setLngLat([data.features[0].geometry.coordinates[0],data.features[0].geometry.coordinates[1]])
                    break;
                case "buscar_coordenadas_principales":
                    principales_mapbox['coordenadaX'].value=data.features[0].geometry.coordinates[0]
                    principales_mapbox['coordenadaY'].value=data.features[0].geometry.coordinates[1]
                    map_principales.flyTo({
                        center: [
                        data.features[0].geometry.coordinates[0],
                        data.features[0].geometry.coordinates[1]
                        ],
                        zoom: 18,
                        essential: true
                        });
                        marker_principales.setLngLat([data.features[0].geometry.coordinates[0],data.features[0].geometry.coordinates[1]])
                    break;
                case "buscar_coordenadas_detencion":
                    detencion_mapbox['coordenadaX'].value=data.features[0].geometry.coordinates[0]
                    detencion_mapbox['coordenadaY'].value=data.features[0].geometry.coordinates[1]
                    map_detencion.flyTo({
                        center: [
                        data.features[0].geometry.coordinates[0],
                        data.features[0].geometry.coordinates[1]
                        ],
                        zoom: 18,
                        essential: true
                        });
                        marker_detencion.setLngLat([data.features[0].geometry.coordinates[0],data.features[0].geometry.coordinates[1]])
                    break;
            }
            return data;
        } catch (error) {
            console.log(error);
        }
    }
}
mapboxgl.accessToken = API_MAPBOX;
button_hechos = document.getElementById('buscar_coordenadas_hechos')
button_hechos.addEventListener('click',getLngLat)
button_principales = document.getElementById('buscar_coordenadas_principales')
button_principales.addEventListener('click',getLngLat)
button_peticionario = document.getElementById('buscar_coordenadas_peticionario')
button_peticionario.addEventListener('click',getLngLat)
button_detencion = document.getElementById('buscar_coordenadas_detencion')
button_detencion.addEventListener('click',getLngLat)
button_principales_direccion=document.getElementById('buscar_direccion_principales')
button_principales_direccion.addEventListener('click',getColoniasCalles)
button_hechos_direccion=document.getElementById('buscar_direccion_hechos')
button_hechos_direccion.addEventListener('click',getColoniasCalles)
button_peticionario_direccion=document.getElementById('buscar_direccion_peticionario')
button_peticionario_direccion.addEventListener('click',getColoniasCalles)
button_detencion_direccion=document.getElementById('buscar_direccion_detencion')
button_detencion_direccion.addEventListener('click',getColoniasCalles)

var map_hechos = new mapboxgl.Map({
    container: 'map_mapbox',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [-98.20868494860592, 19.040296987811555], // starting position
    zoom: 11 // starting zoom
});
var map_peticionario = new mapboxgl.Map({
    container: 'map_mapbox2',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [-98.20868494860592, 19.040296987811555], // starting position
    zoom: 11 // starting zoom
});
var map_principales = new mapboxgl.Map({
    container: 'map_mapbox3',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [-98.20868494860592, 19.040296987811555], // starting position
    zoom: 11 // starting zoom
});
var map_detencion = new mapboxgl.Map({
    container: 'map_mapbox4',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [-98.20868494860592, 19.040296987811555], // starting position
    zoom: 11 // starting zoom
});
map_hechos.addControl(new mapboxgl.FullscreenControl());
map_peticionario.addControl(new mapboxgl.FullscreenControl());
map_principales.addControl(new mapboxgl.FullscreenControl());
map_detencion.addControl(new mapboxgl.FullscreenControl());
map_hechos.addControl(new mapboxgl.NavigationControl());
map_peticionario.addControl(new mapboxgl.NavigationControl());
map_principales.addControl(new mapboxgl.NavigationControl());
map_detencion.addControl(new mapboxgl.NavigationControl());
//Rojo para hechos
const marker = new mapboxgl.Marker({
    color: "#FF0000",
    draggable: true
    }).setLngLat([-98.20868494860592, 19.040296987811555])
    .addTo(map_hechos);
//Azul para principales
const marker_principales = new mapboxgl.Marker({
    color: "#0000FF",
    draggable: true
    }).setLngLat([-98.20868494860592, 19.040296987811555])
    .addTo(map_principales);
//verde para peticionario
const marker_peticionario = new mapboxgl.Marker({
    color: "#008F39",
    draggable: true
    }).setLngLat([-98.20868494860592, 19.040296987811555])
    .addTo(map_peticionario);
//morado para detencion
const marker_detencion = new mapboxgl.Marker({
    color: "#800080",
    draggable: true
    }).setLngLat([-98.20868494860592, 19.040296987811555])
    .addTo(map_detencion);

// Store the marker's longitude and latitude coordinates in a variable
const lngLat = marker.getLngLat();
async function onDragEnd (e) {
    mun_="";esta_="";codi_="";calle_="";nume_="";coloni_="";esta_2="";
    switch(e.target._color){
        case "#FF0000":
            var lngLat = marker.getLngLat();
            hechos_mapbox['coordenadaX'].value=lngLat.lng
            hechos_mapbox['coordenadaY'].value=lngLat.lat
            direccion = await getDireccion(lngLat)
            for(i=0;i<(direccion.features).length;i++){
                if((direccion.features[i].id).includes("place"))
                mun_=direccion.features[i].place_name
                if((direccion.features[i].id).includes("region"))
                    esta_=direccion.features[i].place_name
                if((direccion.features[i].id).includes("postcode"))
                    codi_=direccion.features[i].place_name
                if((direccion.features[i].id).includes("address")){
                    calle_=direccion.features[i].text
                    nume_=direccion.features[i].address
                }
                if((direccion.features[i].id).includes("locality"))
                    coloni_=direccion.features[i].text
            }
            hechos_mapbox['Municipio'].value=(mun_.split(","))[0]
            hechos_mapbox['Estado'].value=(esta_.split(","))[0]
            hechos_mapbox['codigo_postal'].value=((codi_.split(","))[((codi_.split(","))).length-2]).trim()
            hechos_mapbox['Exterior'].value=nume_
            if(esta_=="")
                    peticionario_mapbox['Estado'].value=(codi_.split(","))[0]
            break;
        case "#0000FF":
            var lngLat = marker_principales.getLngLat();
            principales_mapbox['coordenadaX'].value=lngLat.lng
            principales_mapbox['coordenadaY'].value=lngLat.lat
            direccion = await getDireccion(lngLat)
            for(i=0;i<(direccion.features).length;i++){
                if((direccion.features[i].id).includes("place"))
                mun_=direccion.features[i].place_name
                if((direccion.features[i].id).includes("region"))
                    esta_=direccion.features[i].place_name
                if((direccion.features[i].id).includes("postcode"))
                    codi_=direccion.features[i].place_name
                if((direccion.features[i].id).includes("address")){
                    calle_=direccion.features[i].text
                    nume_=direccion.features[i].address
                }
                if((direccion.features[i].id).includes("locality"))
                    coloni_=direccion.features[i].text
            }
            principales_mapbox['Municipio'].value=(mun_.split(","))[0]
            principales_mapbox['Estado'].value=(esta_.split(","))[0]
            if(esta_=="")
                principales_mapbox['Estado'].value=(codi_.split(","))[0]
            principales_mapbox['cp'].value=((codi_.split(","))[((codi_.split(","))).length-2]).trim()
            if(!((document.getElementById('domicilio_puebla')).checked)){
                principales_mapbox['calle'].value=(calle_.split(","))[0]
                principales_mapbox['colonia'].value=coloni_
            }
            principales_mapbox['noExterior'].value=nume_
            if(principales_mapbox['Estado'].value=="Mexico City")
                principales_mapbox['Estado'].value="CIUDAD DE MEXICO"
            if(principales_mapbox['Municipio'].value=="Mexico City")
                principales_mapbox['Municipio'].value="CIUDAD DE MEXICO"
            break;
        case "#008F39":
            var lngLat = marker_peticionario.getLngLat();
            peticionario_mapbox['coordenadaX'].value=lngLat.lng
            peticionario_mapbox['coordenadaY'].value=lngLat.lat
            direccion = await getDireccion(lngLat)
            for(i=0;i<(direccion.features).length;i++){
                if((direccion.features[i].id).includes("place"))
                mun_=direccion.features[i].place_name
                if((direccion.features[i].id).includes("region"))
                    esta_=direccion.features[i].place_name
                if((direccion.features[i].id).includes("postcode"))
                    codi_=direccion.features[i].place_name
                if((direccion.features[i].id).includes("address")){
                    calle_=direccion.features[i].text
                    nume_=direccion.features[i].address
                }
                if((direccion.features[i].id).includes("locality"))
                    coloni_=direccion.features[i].text
            }
            peticionario_mapbox['Municipio'].value=(mun_.split(","))[0]
            peticionario_mapbox['Estado'].value=(esta_.split(","))[0]
            peticionario_mapbox['cp'].value=((codi_.split(","))[((codi_.split(","))).length-2]).trim()
            if(esta_=="")
                peticionario_mapbox['Estado'].value=(codi_.split(","))[0]
            if(!((document.getElementById('domicilio_puebla_peticionario')).checked)){
                peticionario_mapbox['calle'].value=(calle_.split(","))[0]
                peticionario_mapbox['colonia'].value=coloni_
            }                   
            peticionario_mapbox['noExterior'].value=nume_
            if(peticionario_mapbox['Estado'].value=="Mexico City")
                peticionario_mapbox['Estado'].value="CIUDAD DE MEXICO"
            if(peticionario_mapbox['Municipio'].value=="Mexico City")
                peticionario_mapbox['Municipio'].value="CIUDAD DE MEXICO"
            break;
        case "#800080":
            var lngLat = marker_detencion.getLngLat();
            detencion_mapbox['coordenadaX'].value=lngLat.lng
            detencion_mapbox['coordenadaY'].value=lngLat.lat
            direccion = await getDireccion(lngLat)
            for(i=0;i<(direccion.features).length;i++){
                if((direccion.features[i].id).includes("place"))
                mun_=direccion.features[i].place_name
                if((direccion.features[i].id).includes("region"))
                    esta_=direccion.features[i].place_name
                if((direccion.features[i].id).includes("postcode"))
                    codi_=direccion.features[i].place_name
                if((direccion.features[i].id).includes("address")){
                    calle_=direccion.features[i].text
                    nume_=direccion.features[i].address
                }
                if((direccion.features[i].id).includes("locality"))
                    coloni_=direccion.features[i].text
            }
            detencion_mapbox['Municipio'].value=(mun_.split(","))[0]
            detencion_mapbox['Estado'].value=(esta_.split(","))[0]
            detencion_mapbox['cp'].value=((codi_.split(","))[((codi_.split(","))).length-2]).trim()
            if(esta_=="")
                detencion_mapbox['Estado'].value=(codi_.split(","))[0]
            if(!((document.getElementById('domicilio_puebla_detencion')).checked)){
                detencion_mapbox['calle'].value=(calle_.split(","))[0]
                detencion_mapbox['colonia'].value=coloni_
            }
            detencion_mapbox['noExterior'].value=nume_
            if(detencion_mapbox['Estado'].value=="Mexico City")
                detencion_mapbox['Estado'].value="CIUDAD DE MEXICO"
            if(detencion_mapbox['Municipio'].value=="Mexico City")
                detencion_mapbox['Municipio'].value="CIUDAD DE MEXICO"
            
            break;
    }
}
    
const getDireccion = async (lngLat) => {
    try {
        const response = await fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${lngLat.lng}, ${lngLat.lat}.json?access_token=${mapboxgl.accessToken}`, {
            method: 'GET',
            mode: 'cors', // <---
            cache: 'default'          
        });
        const data = await response.json();
        return data;
    } catch (error) {
        console.log(error);
    }
}


marker.on('dragend', onDragEnd);
marker_principales.on('dragend', onDragEnd);
marker_peticionario.on('dragend', onDragEnd);
marker_detencion.on('dragend', onDragEnd);


botones_radio=document.getElementsByName('busqueda')
for(i in botones_radio){
    botones_radio[i].addEventListener('change',seleccionar_busqueda);
}

function seleccionar_busqueda(e){
    if((e.target.id).includes("hechos")){
        document.getElementById("Colonia_hechos")
        if(document.getElementById('porDireccion_hechos').checked){
            document.getElementById('buscar_coordenadas_hechos').style.display = "block";
            document.getElementById('buscar_direccion_hechos').style.display = "none";
        }
        else{   
            document.getElementById('buscar_coordenadas_hechos').style.display = "none";
            document.getElementById('buscar_direccion_hechos').style.display = "block";
        }
    }
    else{
        if((e.target.id).includes("peticionario")){
            if(document.getElementById('porDireccion_peticionario').checked){
                document.getElementById('buscar_coordenadas_peticionario').style.display = "block";
                document.getElementById('buscar_direccion_peticionario').style.display = "none";
            }
            else{   
                document.getElementById('buscar_coordenadas_peticionario').style.display = "none";
                document.getElementById('buscar_direccion_peticionario').style.display = "block";
            }
        }
        else{
            if((e.target.id).includes("detencion")){
                if(document.getElementById('porDireccion_detencion').checked){
                    document.getElementById('buscar_coordenadas_detencion').style.display = "block";
                    document.getElementById('buscar_direccion_detencion').style.display = "none";
                }
                else{   
                    document.getElementById('buscar_coordenadas_detencion').style.display = "none";
                    document.getElementById('buscar_direccion_detencion').style.display = "block";
                }
            }
            else{
                if(document.getElementById('porDireccion').checked){
                    document.getElementById('buscar_coordenadas_principales').style.display = "block";
                    document.getElementById('buscar_direccion_principales').style.display = "none";
                }
                else{   
                    document.getElementById('buscar_coordenadas_principales').style.display = "none";
                    document.getElementById('buscar_direccion_principales').style.display = "block";
                }
            }
        }
    }
}