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
const offlineMapsPrincipal = () => {

    document.getElementById("map_nuevar").innerHTML = `
        <div class="d-flex align-items-center" style="height:100%">
            <div>
                <span class="badge badge-pill badge-warning">Sin conexión a internet</span>
                <h2 class="my-4" style="color:#88072D">¡OH NO! ERROR 404</h2>
                <p>Lo sentimos, al parecer no tienes conexión a internet ó la señal es muy débil.</p>
            </div>
        </div>
    `;
}
window.addEventListener('offline', function(e) {
    offlineMapsPrincipal();
});

const getColoniasCalles = async(e) => {
    coord_x = principales_mapbox['coordenadaX'].value;
    coord_y =  principales_mapbox['coordenadaY'].value;
    error_coord_x = document.getElementById("cordY_principales_error");
    error_coord_y = document.getElementById("cordX_principales_error");
    (document.getElementById("CP_principales_error")).textContent="";
    (document.getElementById("Calle_principales_error")).textContent="";
    var FV = new FormValidator();
    if(coord_x=="" || coord_y==""){
        error_coord_x.textContent = FV.validate(coord_x, "required | max_length[50]");
        error_coord_y.textContent = FV.validate(coord_y, "required |max_length[50]");
    }
    else{
        error_coord_x.textContent="";
        error_coord_y.textContent="";
        map_principales.flyTo({
        center: [
            coord_x,
            coord_y
        ],
        zoom: 18,
        essential: true
        });
        marker_principales.setLngLat([coord_x,coord_y])
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
    }
}
const getLngLat = async (e) => {
    calle = principales_mapbox['calle'].value;
    numero =  principales_mapbox['noExterior'].value;
    codigopostal =  principales_mapbox['cp'].value;
    error_codigop = document.getElementById("CP_principales_error");
    error_calle_1 = document.getElementById("Calle_principales_error");
    (document.getElementById("cordY_principales_error")).textContent="";
    (document.getElementById("cordX_principales_error")).textContent="";
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
            return data;
        } catch (error) {
            console.log(error);
        }
    }
}
mapboxgl.accessToken = API_MAPBOX;
button_principales = document.getElementById('buscar_coordenadas_principales')
button_principales.addEventListener('click',getLngLat)
button_principales_direccion=document.getElementById('buscar_direccion_principales')
button_principales_direccion.addEventListener('click',getColoniasCalles)
var map_principales = new mapboxgl.Map({
    container: 'map_nuevar',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [-98.20868494860592, 19.040296987811555], // starting position
    zoom: 11 // starting zoom
});
map_principales.addControl(new mapboxgl.NavigationControl());
map_principales.addControl(new mapboxgl.FullscreenControl());
//Azul para principales
const marker_principales = new mapboxgl.Marker({
color: "#0000FF",
draggable: true
}).setLngLat([-98.20868494860592, 19.040296987811555])
.addTo(map_principales);
const lngLat = marker_principales.getLngLat();
async function onDragEnd (e) {
    mun_="";esta_="";codi_="";calle_="";nume_="";coloni_="";esta_2="";
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
marker_principales.on('dragend', onDragEnd);
botones_radio=document.getElementsByName('busqueda')
for(i in botones_radio){
    botones_radio[i].addEventListener('change',seleccionar_busqueda);
}
function seleccionar_busqueda(e){
    if(document.getElementById('porDireccion').checked){
        document.getElementById('buscar_coordenadas_principales').style.display = "block";
        document.getElementById('buscar_direccion_principales').style.display = "none";
    }
    else{   
        document.getElementById('buscar_coordenadas_principales').style.display = "none";
        document.getElementById('buscar_direccion_principales').style.display = "block";
    }
}