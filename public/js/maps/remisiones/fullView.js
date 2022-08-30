const principales = {
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
    'estado': document.getElementById('Estado'),
    'municipio': document.getElementById('Municipio'),
    'cp': document.getElementById('CP'),
    'errorMap': document.getElementById('errorMap')
}

principales['porDireccion'].style.display = 'none';
principales['porCoordenada'].style.display = 'none';

const peticionario = {
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
    'estado': document.getElementById('Estado_peticionario'),
    'municipio': document.getElementById('Municipio_peticionario'),
    'cp': document.getElementById('CP_peticionario'),
    'errorMap': document.getElementById('errorMap_peticionario')
}

peticionario['porDireccion'].style.display = 'none';
peticionario['porCoordenada'].style.display = 'none';

const hechos = {
    'porDireccion': document.getElementById('por_direccion_hechos'),
    'porCoordenada': document.getElementById('por_coordenadas_hechos'),
    'searchDireccion': document.getElementById('dir_hechos'),
    'searchCoordenadaY': document.getElementById('search_cy_hechos'),
    'searchCoordenadaX': document.getElementById('search_cx_hechos'),
    'buscar': document.getElementById('buscar_hechos'),
    'colonia': document.getElementById('Colonia_hechos'),
    'calle': document.getElementById('Calle_hechos'),
    'calle2': document.getElementById('Calle2_hechos'),
    'noInterior': document.getElementById('noInterior_hechos'),
    'noExterior': document.getElementById('noExterior_hechos'),
    'coordenadaY': document.getElementById('cordY_hechos'),
    'coordenadaX': document.getElementById('cordX_hechos'),
    'cp': document.getElementById('CP_hechos'),
    'errorMap': document.getElementById('errorMap_hechos')
}

hechos['porDireccion'].style.display = 'none';
hechos['porCoordenada'].style.display = 'none';

const detencion = {
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
    'errorMap': document.getElementById('errorMap_detencion')
}


detencion['porDireccion'].style.display = 'none';
detencion['porCoordenada'].style.display = 'none';

const radios = document.getElementsByName('busqueda');

let markers = [],
    type = 0;

const offlineMapsFullView = () => {
    apartados = ['principales', 'peticionario', 'hechos', 'detencion' /*, 'objetos'*/ ];

    apartados.forEach(apartado => {
        switch (apartado) {
            case 'principales':
                apartado = principales;
                break;
            case 'peticionario':
                apartado = peticionario;
                break;
            case 'hechos':
                apartado = hechos;
                break;
            case 'detencion':
                apartado = detencion;
                break;
        }
        apartado['coordenadaY'].removeAttribute('readonly');
        apartado['coordenadaX'].removeAttribute('readonly');
        apartado['municipio'] != undefined ? apartado['municipio'].removeAttribute('readonly') : '';
    });
    document.getElementById("map").innerHTML = document.getElementById("map1").innerHTML = document.getElementById("map2").innerHTML = document.getElementById("map3").innerHTML = `
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
    offlineMapsFullView();
});

window.addEventListener('online', function(e) {
    apartados = ['principales', 'peticionario', 'hechos', 'detencion', 'objetos'];

    apartados.forEach(apartado => {
        switch (apartado) {
            case 'principales':
                apartado = principales;
                break;
            case 'peticionario':
                apartado = peticionario;
                break;
            case 'hechos':
                apartado = hechos;
                break;
            case 'detencion':
                apartado = detencion;
                break;
        }
        apartado['coordenadaY'].setAttribute('readonly', '');
        apartado['coordenadaX'].setAttribute('readonly', '');
        apartado['municipio'] != undefined ? apartado['municipio'].setAttribute('readonly', '') : '';
    });

    initMap();
});


function initMap() {

    const option = {
        zoom: 10,
        center: {
            lat: 19.0437227,
            lng: -98.1984744
        }
    }

    if (typeof google === "undefined") {
        document.getElementById("map").innerHTML = document.getElementById("map1").innerHTML = document.getElementById("map2").innerHTML = document.getElementById("map3").innerHTML = `
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

    const primer_map = new google.maps.Map(document.getElementById("map"), option);
    const segundo_map = new google.maps.Map(document.getElementById("map1"), option);
    const tercer_map = new google.maps.Map(document.getElementById("map2"), option);
    const cuarto_map = new google.maps.Map(document.getElementById("map3"), option);

    const geocoder = new google.maps.Geocoder();

    radios.forEach(radio=>{
        radio.addEventListener('click', ()=>{
            let data_id, apartado, map;
            data_id = radio.getAttribute('data-id');
            switch (data_id) {
                case 'principales':
                    apartado = principales;
                    map = primer_map
                break;
                case 'peticionario':
                    apartado = peticionario;
                    map = segundo_map;
                break;
                case 'hechos':
                    apartado = hechos;
                    map = tercer_map
                break;
                case 'detencion':
                    apartado = detencion;
                    map = cuarto_map;
                break;
            }
            if (radio.value == 0) {
                apartado['porDireccion'].style.display = 'block';
                apartado['porCoordenada'].style.display = 'none';

                clear_fields(apartado);
                clean_marks();
                markers = [];

                placesMap(map, apartado, geocoder)

            } else {

                apartado['porDireccion'].style.display = 'none';
                apartado['porCoordenada'].style.display = 'block';

                clear_fields(apartado);
                clean_marks();
                markers = [];
                type = 1;

                apartado['buscar'].addEventListener('click', (e) => {
                    e.preventDefault();
                    if (apartado['searchCoordenadaY'].value != '' && apartado['searchCoordenadaX'].value != '') {
                        geocodeLatLng(geocoder, map, apartado['searchCoordenadaY'].value, apartado['searchCoordenadaX'].value, apartado)
                    } else {
                        alert("Por favor ingresa unas coordenadas validas")
                    }
                })

            }
        })
    })

    principales['buscar'].addEventListener('click', (e) => {
        type = 1;
        geocodeLatLng(geocoder, primer_map, principales['searchCoordenadaY'].value, principales['searchCoordenadaX'].value, principales)
    })
    peticionario['buscar'].addEventListener('click', (e) => {
        type = 1;
        geocodeLatLng(geocoder, segundo_map, peticionario['searchCoordenadaY'].value, peticionario['searchCoordenadaX'].value, peticionario)
    })
    hechos['buscar'].addEventListener('click', (e) => {
        type = 1;
        geocodeLatLng(geocoder, tercer_map, hechos['searchCoordenadaY'].value, hechos['searchCoordenadaX'].value, hechos)
    })
    detencion['buscar'].addEventListener('click', (e) => {
        type = 1;
        geocodeLatLng(geocoder, cuarto_map, detencion['searchCoordenadaY'].value, detencion['searchCoordenadaX'].value, detencion)
    })
}

function placesMap(map, apartado, geocoder) {

    const direccion = apartado['searchDireccion'],
        searchValue = new google.maps.places.SearchBox(direccion);

    map.addListener('bounds_changed', function() {
        searchValue.setBounds(map.getBounds());
    });

    searchValue.addListener('places_changed', function() {
        const places = searchValue.getPlaces();

        if (places.length === 0) {
            return;
        }

        const bounds = new google.maps.LatLngBounds();

        places.forEach(function(p) {
            if (!p.geometry) {
                return;
            }

            clean_marks();
            markers = [];

            markers.push(new google.maps.Marker({
                map: map,
                position: p.geometry.location,
                draggable: true
            }));

            for (let i = 0; i < markers.length; i++) {
                markers[i].addListener('dragend', function(event) {

                    apartado['coordenadaY'].value = this.getPosition().lat();
                    apartado['coordenadaX'].value = this.getPosition().lng();

                    const lati = this.getPosition().lat();
                    const lon = this.getPosition().lng();

                    geocodeLatLng(geocoder, map, lati, lon, apartado);

                });
            }


            if (p.geometry.viewport) {
                bounds.union(p.geometry.viewport);
            } else {
                bounds.extend(p.geometry.location);
            }

            getAdress(p, apartado);

        });
        map.fitBounds(bounds);
    });
}

function getAdress(e, apartado) {
    for (let i = 0; i < e.address_components.length; i++) {
        if (e.address_components[i]['types'] == 'street_number')
            apartado['noExterior'].value = e.address_components[i]['short_name']

        if (e.address_components[i]['types'] == 'route')
            apartado['calle'].value = e.address_components[i]['short_name']

        if (e.address_components[i]['types'][0] == 'sublocality_level_1' || e.address_components[i]['types'][0] == 'political')
            apartado['colonia'].value = e.address_components[i]['short_name']

        if (e.address_components[i]['types'][0] == 'locality' && apartado['municipio'] != undefined)
            apartado['municipio'].value = e.address_components[i]['short_name']

        if (e.address_components[i]['types'][0] == 'administrative_area_level_1' && apartado['estado'] != undefined)
            apartado['estado'].value = e.address_components[i]['long_name']

        if (e.address_components[i]['types'][0] == 'postal_code')
            apartado['cp'].value = e.address_components[i]['long_name']
    }

    apartado['coordenadaX'].value = e.geometry.location.lng();
    //Object.values(e.geometry.viewport)[1].i;
    apartado['coordenadaY'].value = e.geometry.location.lat();
    //Object.values(e.geometry.viewport)[0].i;

    if (type == 0)
        apartado['searchDireccion'].value = e.formatted_address
}

function geocodeLatLng(geocoder, map, latitud, longitud, apartado) {

    const lat = latitud;
    const lng = longitud;

    const latlng = {
        lat: parseFloat(lat),
        lng: parseFloat(lng)
    };

    geocoder.geocode({ location: latlng }, (results, status) => {
        if (status === "OK") {
            if (results[0]) {
                switch (type) {
                    case 0:
                        getAdress(results[0], apartado)
                        break;
                    case 1:
                        clean_marks();
                        markers = [];

                        markers.push(new google.maps.Marker({
                            map: map,
                            position: latlng,
                            draggable: true
                        }));

                        for (let i = 0; i < markers.length; i++) {
                            markers[i].addListener('dragend', function(event) {
                                apartado['coordenadaY'].value = this.getPosition().lat();
                                apartado['coordenadaX'].value = this.getPosition().lng();

                                apartado['searchCoordenadaY'].value = this.getPosition().lat();
                                apartado['searchCoordenadaX'].value = this.getPosition().lng();

                                var lati1 = this.getPosition().lat();
                                var lon1 = this.getPosition().lng();

                                geocodeLatLng(geocoder, map, lati1, lon1, apartado)

                            });
                        }

                        const bounds = new google.maps.LatLngBounds();

                        if (results[0].geometry.viewport) {
                            bounds.union(results[0].geometry.viewport);
                        } else {
                            bounds.extend(results[0].geometry.location);
                        }

                        getAdress(results[0], apartado);
                        map.fitBounds(bounds);
                        break;
                }
            } else {
                apartado['errorMap'].innerHTML = '<span class="text-danger">Resultados no encontrados</span>'
            }
        } else {
            apartado['errorMap'].innerHTML = '<span class="text-danger" style="font-size: 11px">Solicitud invalida</span>'
        }
    });
}

function clear_fields(input) {
    for (var nombre in input) {
        if (input[nombre] != '')
            input[nombre].value = ''
    }
}

function clean_marks() {
    markers.forEach(function(m) { m.setMap(null); });
}