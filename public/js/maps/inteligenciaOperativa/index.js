const primerMapa = {
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
    'municipio': document.getElementById('Municipio'),
    'cp': document.getElementById('CP')
}

primerMapa['porDireccion'].style.display = 'none';
primerMapa['porCoordenada'].style.display = 'none';

const segundoMapa = {
    'porDireccion': document.getElementById('por_direccion_1'),
    'porCoordenada': document.getElementById('por_coordenadas_1'),
    'searchDireccion': document.getElementById('dir_1'),
    'searchCoordenadaY': document.getElementById('search_cy_1'),
    'searchCoordenadaX': document.getElementById('search_cx_1'),
    'buscar': document.getElementById('buscar_1'),
    'colonia': document.getElementById('Colonia_1'),
    'calle': document.getElementById('Calle_1'),
    'noInterior': document.getElementById('noInterior_1'),
    'noExterior': document.getElementById('noExterior_1'),
    'coordenadaY': document.getElementById('cordY_1'),
    'coordenadaX': document.getElementById('cordX_1'),
    'municipio': document.getElementById('Municipio_1'),
    'cp': document.getElementById('CP_1')
}

segundoMapa['porDireccion'].style.display = 'none';
segundoMapa['porCoordenada'].style.display = 'none';

const radios = document.getElementsByName('busqueda');

let markers = [],
    type = 0;

function initMap() {

    const option = {
        zoom: 10,
        center: {
            lat: 19.0437227,
            lng: -98.1984744
        }
    }

    const primer_map = new google.maps.Map(document.getElementById('map1'), option);
    const segundo_map = new google.maps.Map(document.getElementById('map2'), option);

    const geocoder = new google.maps.Geocoder();

    for (let radio in radios) {
        radios[radio].onclick = (e) => {
            let select, data_id;
            if (e.path === undefined) {
                select = e.originalTarget;
                data_id = select.getAttribute('data-id');
            } else {
                select = e.path[0];
                data_id = select.getAttribute('data-id');
            }

            let apartado, map;

            switch (data_id) {
                case 'InteligenciaOperativa_1':
                    apartado = primerMapa;
                    map = primer_map;
                    break;
                case 'InteligenciaOperativa_2':
                    apartado = segundoMapa;
                    map = segundo_map;
                    break;
            }

            if (select.value == 0) {
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

            //console.log(data_id);
        }
    }
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
            apartado['noInterior'].value = e.address_components[i]['short_name']

        if (e.address_components[i]['types'] == 'route')
            apartado['calle'].value = e.address_components[i]['short_name']

        if (e.address_components[i]['types'][0] == 'sublocality_level_1' || e.address_components[i]['types'][0] == 'political')
            apartado['colonia'].value = e.address_components[i]['short_name']

        if (e.address_components[i]['types'][0] == 'locality' && apartado['municipio'] != undefined)
            apartado['municipio'].value = e.address_components[i]['short_name']

        /* if (e.address_components[i]['types'][0] == 'administrative_area_level_1' && apartado['estado'] != undefined)
            apartado['estado'].value = e.address_components[i]['long_name'] */

        if (e.address_components[i]['types'][0] == 'postal_code')
            apartado['cp'].value = e.address_components[i]['long_name']
    }

    apartado['coordenadaX'].value = e.geometry.location.lng();
    apartado['coordenadaY'].value = e.geometry.location.lat();
    /* apartado['coordenadaX'].value = Object.values(e.geometry.viewport)[1].i;
    apartado['coordenadaY'].value = Object.values(e.geometry.viewport)[0].i; */

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