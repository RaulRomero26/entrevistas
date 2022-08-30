var inspeccion = {
    'busqueda_direccion': document.getElementById('dir_inspecciones'),
    'busqueda_coordenadaX': document.getElementById('search_cx_inspecciones'),
    'busqueda_coordenadaY': document.getElementById('search_cy_inspecciones'),
    'Colonia': document.getElementById('id_colonia'),
    'Calle': document.getElementById('id_calle_1'),
    'Interior': document.getElementById('id_no_int'),
    'Exterior': document.getElementById('id_no_ext'),
    'coordenadaX': document.getElementById('id_coord_x'),
    'coordenadaY': document.getElementById('id_coord_y'),
    'Estado': '',
    'Municipio': ''
}
document.getElementById('por_direccion_inspecciones').style.display = 'none';
document.getElementById('por_coordenadas_inspecciones').style.display = 'none';

const offlineMapsInspeccion = () => {

    inspeccion['coordenadaX'].removeAttribute('readonly');
    inspeccion['coordenadaY'].removeAttribute('readonly');
    document.getElementById("id_map").innerHTML = `
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
    offlineMapsInspeccion();
});

window.addEventListener('online', function(e) {
    inspeccion['coordenadaY'].setAttribute('readonly', '');
    inspeccion['coordenadaX'].setAttribute('readonly', '');

    initMap();
});

function initMap() {
    var option = {
        zoom: 10,
        center: {
            lat: 19.0437227,
            lng: -98.1984744
        }
    }

    if (typeof google === "undefined") {
        document.getElementById("id_map").innerHTML = `
            <div class="d-flex align-items-center" style="height:100%">
                <div>
                    <span class="badge badge-pill badge-success">Volvio la conexión a internet</span>
                    <h2 class="my-4" style="color:#88072D">¡CON INTERNET!</h2>
                    <p>Para volver a visualizar los mapas se requiere de actualizar la página.</p>
                    <p class="text-danger">NOTA: recuerda guardar tus cambios antes de actualizar la página.</p>
                </div>
            </div>
        `;
    }

    map = new google.maps.Map(document.getElementById("id_map"), option);

    var markers = [];
    const geocoder = new google.maps.Geocoder(); //Se crea un geocoder para hacer una busquedea inversa

    $('input[name=busqueda_inspecciones]').click(function() {

        if (this.value == 0) {
            document.getElementById('por_direccion_inspecciones').style.display = 'block'
            document.getElementById('por_coordenadas_inspecciones').style.display = 'none'

            clear_fields(inspeccion)
            clean_marks(markers)
            findAndMark(map, markers, inspeccion, true, geocoder)

        } else {

            document.getElementById('por_direccion_inspecciones').style.display = 'none'
            document.getElementById('por_coordenadas_inspecciones').style.display = 'block'

            clear_fields(inspeccion)
            clean_marks(markers)

            document.getElementById('buscar_inspecciones').addEventListener('click', () => {
                if (inspeccion['busqueda_coordenadaX'].value != '' && inspeccion['busqueda_coordenadaY'] != '') {
                    var cx = inspeccion['busqueda_coordenadaX'].value
                    var cy = inspeccion['busqueda_coordenadaY'].value

                    geocodeLatLng(geocoder, map, 1, markers, cy, cx, inspeccion)

                } else {
                    alert("Ingresa unas coordenadas validas")
                }

            })

        }

    });
}

function clean_marks(mark) {
    mark.forEach(function(m) { m.setMap(null); });
}

function clear_fields(input) {
    for (var nombre in input) {
        if (input[nombre] != '')
            input[nombre].value = ''
    }
}


/*La función getAdress Necesita 3 parametros:
    1. El json con la información obtenida de la dirección
    2. El tipo: 
            2.1. 0 si es proviene de una busqueda por dirección
            2.2. 1 si es proviene de una busqueda por coordenadas
    3. Un arreglo asociativo con los campos a ser llenados
*/
function getAdress(e, type, inputs) {
    for (var i = 0; i < e.address_components.length; i++) {
        if (e.address_components[i]['types'] == 'street_number' && inputs['Exterior'] != '')
            inputs['Exterior'].value = e.address_components[i]['short_name']

        if (e.address_components[i]['types'] == 'route' && inputs['Calle'] != '')
            inputs['Calle'].value = e.address_components[i]['short_name']

        if ((e.address_components[i]['types'][0] == 'sublocality_level_1' || e.address_components[i]['types'][0] == 'political') && inputs['Colonia'] != '')
            inputs['Colonia'].value = e.address_components[i]['short_name']

        if (e.address_components[i]['types'][0] == 'locality' && inputs['Municipio'] != '')
            inputs['Municipio'].value = e.address_components[i]['short_name']

        if ((e.address_components[i]['types'][0] == 'administrative_area_level_1') && inputs['Estado'] != '')
            inputs['Estado'].value = e.address_components[i]['long_name']
    }

    inputs['coordenadaX'].value = e.geometry.location.lng();
    inputs['coordenadaY'].value = e.geometry.location.lat();

    switch (type) {
        case 0:
            inputs['busqueda_direccion'].value = e.formatted_address
            break;
    }
}

/*La función findAndMark buscará y marcara los lugares apartir de una dirección
    Esta función necesita 4 parametros
        1. map - Mapa en el que se mostrará la información
        2. mark - el arreglo de marcadores para el mapa
        3. input - un arreglo asociativo con los id's del formulario en uso
        4. band - valor booleano que dira si el marcado podrá moverse o no.
        5. geocode - Necesario para hacer una busqueda por coordenadas
        6. type: especifica si es una busqueda por coordenadas o no.
            6.1. Busqueda por d
*/

function findAndMark(map, mark, field, band, geocoder) {

    if (field['Colonia'] == '') {
        field['busqueda_direccion'].value = ''; //Se limpia el campo de busqueda
    }


    var input = field['busqueda_direccion']; //Se obtiene el campo en donde se mostraran los resultados de busqueda en google maps
    var searchName = new google.maps.places.SearchBox(input); //Se crea el constructor para la caja de busqueda

    map.addListener('bounds_changed', function() { // Set search to stay within bounds first
        searchName.setBounds(map.getBounds());
    })

    searchName.addListener('places_changed', function() { // When user selects prediction from list

        var places = searchName.getPlaces(); //Se obtienen los lugares

        if (places.length === 0) { //Sino hay resultados, no hace nada
            return;
        }

        clean_marks(mark)
        mark = []; //Se limpia el arreglo

        // bounds object
        var bounds = new google.maps.LatLngBounds(); //Objeto que contiene los resultados

        places.forEach(function(p) { //Sino hay resultados, no hace nada
            if (!p.geometry) {
                return;
            }

            mark.push(new google.maps.Marker({ //Se insertan marcadores en el arreglo
                map: map, //Mapa destino
                title: p.title, //Titulo del marcador
                position: p.geometry.location, //Coordenadas en donde se posicionará el marcador
                draggable: band //Se hablilita el movimiento del marcador
            }));

            if (band) {
                mark[0].addListener('dragend', function(event) { //Este listener se encarga de obtener los nuevos datos en caso de que el usuario mueva el marcador
                    field['coordenadaY'].value = this.getPosition().lat(); //escribimos las coordenadas de la posicion actual del marcador dentro de los input
                    field['coordenadaX'].value = this.getPosition().lng();

                    var lati = this.getPosition().lat();
                    var lon = this.getPosition().lng();

                    geocodeLatLng(geocoder, map, 0, mark, lati, lon, field)
                });
            }

            //Se centra el mapa en la nueva posicón ubicada
            if (p.geometry.viewport) {
                bounds.union(p.geometry.viewport);
            } else {
                bounds.extend(p.geometry.location);
            }

            getAdress(p, 0, field)
        });

        map.fitBounds(bounds);
    });
}

function geocodeLatLng(geocoder, map, type, mark, latitud, longitud, inputs) {

    //Estado 0 - la función es utilizada para actualizar una dirtección apartir de que el markador es movido
    //Estado 1 - buscará una nueva dirección unicamente por coordendas

    const lat = latitud //document.getElementById('cordY').value
    const lng = longitud //document.getElementById('cordX').value

    const latlng = {
        lat: parseFloat(lat),
        lng: parseFloat(lng)
    };

    geocoder.geocode({ location: latlng }, (results, status) => {
        if (status === "OK") {
            if (results[0]) {
                switch (type) {
                    case 0:
                        getAdress(results[0], 0, inputs)
                        break;

                    case 1:
                        clean_marks(mark)
                        mark.push(new google.maps.Marker({
                            map: map,
                            position: latlng,
                        }));

                        getAdress(results[0], 1, inputs)

                        mark[0].addListener('dragend', function(event) { //Este listener se encarga de obtener los nuevos datos en caso de que el usuario mueva el marcador
                            inputs['coordenadaX'].value = this.getPosition().lng();
                            inputs['coordenadaY'].value = this.getPosition().lat();

                            inputs['busqueda_coordenadaX'].value = this.getPosition.lng();
                            inputs['busqueda_coordenadaY'].value = this.getPosition.lat();

                            var lati1 = this.getPosition().lat();
                            var lon1 = this.getPosition().lng();

                            geocodeLatLng(geocoder, map, 0, mark, lati1, lon1, inputs)

                        });



                        break;
                }
            } else {
                document.getElementById("errorMap").innerHTML = '<span class="text-danger">Resultados no encontrados</span>'
            }
        } else {
            document.getElementById("errorMap").innerHTML = '<span class="text-danger" style="font-size: 11px">Solicitud invalida</span>'
        }
    });
}