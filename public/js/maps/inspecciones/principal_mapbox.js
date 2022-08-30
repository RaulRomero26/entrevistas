var error_codigop = document.getElementById("error_id_cp");
var error_calle_1 = document.getElementById("error_calle_1");
document.getElementById('porDireccion_inspecciones').addEventListener('change',seleccionar_busqueda);
document.getElementById('porCoordenadas_inspecciones').addEventListener('change',seleccionar_busqueda);
var inspeccion = {
    'porDireccion': document.getElementById('por_direccion_ins'),
    'porCoordenada': document.getElementById('por_coordenadas_ins'),
    'busqueda_direccion': document.getElementById('dir_inspecciones'),
    'busqueda_coordenadaX': document.getElementById('search_cx_inspecciones'),
    'busqueda_coordenadaY': document.getElementById('search_cy_inspecciones'),
    'Colonia': document.getElementById('id_colonia'),
    'Calle': document.getElementById('id_calle_1'),
    'Interior': document.getElementById('id_no_int'),
    'Exterior': document.getElementById('id_no_ext'),
    'coordenadaX': document.getElementById('id_coord_x'),
    'coordenadaY': document.getElementById('id_coord_y'),
    'codigo_postal': document.getElementById('id_cp'),
    'Estado': '',
    'Municipio': ''
}
button_buscar_direccion=document.getElementById('buscar_direccion_ins');
const offlineMapsPrincipalI = () => {

    document.getElementById("map_mapbox").innerHTML = `
        <div class="d-flex align-items-center" style="height:100%">
            <div>
                <span class="badge badge-pill badge-warning">Sin conexión a internet</span>
                <h2 class="my-4" style="color:#88072D">¡OH NO! ERROR 404</h2>
                <p>Lo sentimos, al parecer no tienes conexión a internet ó la señal es muy débil.</p>
            </div>
        </div>
    `;
}
mapboxgl.accessToken = API_MAPBOX;
const getColoniasCalles = async(e) => {
    console.log("getColoniasCalles")
    console.log(e.target.id)
    coord_x = inspeccion['coordenadaX'].value;
    coord_y =  inspeccion['coordenadaY'].value;
    error_coord_x = document.getElementById("error_coord_x");
    error_coord_y = document.getElementById("error_coord_y");
    (document.getElementById("error_id_cp")).textContent="";
    (document.getElementById("error_calle_1")).textContent="";
    var FV = new FormValidator();
    if(coord_x=="" || coord_y==""){
        error_coord_x.textContent = FV.validate(coord_x, "required | max_length[50]");
        error_coord_y.textContent = FV.validate(coord_y, "required |max_length[50]");
    }
    else{
        error_coord_x.textContent="";
        error_coord_y.textContent="";
        map.flyTo({
        center: [
            coord_x,
            coord_y
        ],
        zoom: 18,
        essential: true
        });
        marker.setLngLat([coord_x,coord_y])
        var lngLat = {
            lng : coord_x,
            lat : coord_y,
        }
        direccion = await getDireccion(lngLat)
        console.log(direccion)
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
        inspeccion['Municipio'].value=(mun_.split(","))[0]
        inspeccion['Estado'].value=(esta_.split(","))[0]
        if(esta_=="")
            inspeccion['Estado'].value=(codi_.split(","))[0]
        inspeccion['codigo_postal'].value=(codi_.split(","))[((codi_.split(","))).length-2]
        inspeccion['Exterior'].value=nume_

    }
}
var map = new mapboxgl.Map({
    container: 'map_mapbox',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [-98.20868494860592, 19.040296987811555], // starting position
    zoom: 11 // starting zoom

});
map.addControl(new mapboxgl.NavigationControl());
map.addControl(new mapboxgl.FullscreenControl());
const marker = new mapboxgl.Marker({
    color: "#FF0000",
    draggable: true
    }).setLngLat([-98.20868494860592, 19.040296987811555])
    .addTo(map);

// Store the marker's longitude and latitude coordinates in a variable
const lngLat = marker.getLngLat();
async function onDragEnd () {
    const lngLat = marker.getLngLat();
    inspeccion['coordenadaX'].value=lngLat.lng
    inspeccion['coordenadaY'].value=lngLat.lat
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
    inspeccion['Municipio'].value=(mun_.split(","))[0]
    inspeccion['Estado'].value=(esta_.split(","))[0]
    if(esta_=="")
        inspeccion['Estado'].value=(codi_.split(","))[0]
    inspeccion['codigo_postal'].value=((codi_.split(","))[((codi_.split(","))).length-2]).trim()
    inspeccion['noExterior'].value=nume_
    console.log(inspeccion['Estado'].value)
    console.log(inspeccion['Municipio'].value)
    if(inspeccion['Estado'].value=="Mexico City")
        inspeccion['Estado'].value="CIUDAD DE MEXICO"
    if(inspeccion['Municipio'].value=="Mexico City")
        inspeccion['Municipio'].value="CIUDAD DE MEXICO"
    /*inspeccion['Municipio'].value=direccion.features[2].place_name
    inspeccion['Estado'].value=direccion.features[3].place_name*/
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

const getLngLat = async () => {
    console.log("Para obtener coordendas dando calle y cp")
    calle = document.getElementById('id_calle_1').value;
    numero = document.getElementById('id_no_ext').value;
    codigopostal = document.getElementById('id_cp').value;
    var FV = new FormValidator();
    if(calle=="" || codigopostal==""){
        error_calle_1.textContent = FV.validate(document.getElementById('id_calle_1').value, "required | max_length[50]");
        error_codigop.textContent = FV.validate(document.getElementById('id_cp').value, "required |max_length[50]");
    }
    else{
        error_calle_1.textContent=""
        error_codigop.textContent=""
        cadena = '';
        calle = calle.split(' ');
        
        for(call of calle){
            cadena+=`${call},`
        }
        cadena+=`${numero},`
        cadena+=`${codigopostal}`
        console.log(cadena)
        try {
            const response = await fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${cadena}.json?access_token=${mapboxgl.accessToken}&limit=1`, {
                method: 'GET',
                mode: 'cors', // <---
                cache: 'default'          
            });
            const data = await response.json();
            console.log(data)
            console.log(data.features[0].geometry.coordinates)
            inspeccion['coordenadaX'].value=data.features[0].geometry.coordinates[0]
            inspeccion['coordenadaY'].value=data.features[0].geometry.coordinates[1]
            map.flyTo({
                center: [
                data.features[0].geometry.coordinates[0],
                data.features[0].geometry.coordinates[1]
                ],
                zoom: 18,
                essential: true
                });
                marker.setLngLat([data.features[0].geometry.coordinates[0],data.features[0].geometry.coordinates[1]])
            return data;
        } catch (error) {
            console.log(error);
        }
    }
}
marker.on('dragend', onDragEnd);
(document.getElementById('buscar_coordenadas_ins')).addEventListener('click',getLngLat)
button_buscar_direccion.addEventListener('click',getColoniasCalles);
function seleccionar_busqueda(e){
    console.log("seleccionar_busqueda")
    console.log(e.target.id)
    if(document.getElementById('porDireccion_inspecciones').checked){
        console.log("busca por direccion")
        document.getElementById('buscar_coordenadas_ins').style.display = "block";
        document.getElementById('buscar_direccion_ins').style.display = "none";
    }
    else{   
        document.getElementById('buscar_coordenadas_ins').style.display = "none";
        document.getElementById('buscar_direccion_ins').style.display = "block";
    }
}