/**--------------------------------CAMPOS DOMICILIO DETENIDO-------------------------------- */
const domDetenido = {
    'porDireccion': document.getElementById('por_direccion_domDetenido'),
    'porCoordenada': document.getElementById('por_coordenadas_domDetenido'),
    'searchDireccion': document.getElementById('dir_domDetenido'),
    'searchCoordenadaY': document.getElementById('search_cy_domDetenido'),
    'searchCoordenadaX': document.getElementById('search_cx_domDetenido'),
    'buscar': document.getElementById('buscar_domDetenido'),
    'colonia': document.getElementById('id_colonia_domDetenido'),
    'calle': document.getElementById('id_calle_1_domDetenido'),
    'noInterior': document.getElementById('id_no_ext_domDetenido'),
    'noExterior': document.getElementById('id_no_int_domDetenido'),
    'coordenadaY': document.getElementById('id_coord_y_domDetenido'),
    'coordenadaX': document.getElementById('id_coord_x_domDetenido'),
    'estado': document.getElementById('id_estado_domDetenido'),
    'municipio': document.getElementById('id_municipio_domDetenido'),
    'cp': document.getElementById('id_cp_domDetenido')

}

domDetenido['porDireccion'].style.display = 'none';
domDetenido['porCoordenada'].style.display = 'none';
/**--------------------------------CAMPOS UBICACIÓN DETENCIÓN-------------------------------- */
const ubi_detencion = {
    'porDireccion': document.getElementById('por_direccion_ubi_detencion'),
    'porCoordenada': document.getElementById('por_coordenadas_ubi_detencion'),
    'searchDireccion': document.getElementById('dir_ubi_detencion'),
    'searchCoordenadaY': document.getElementById('search_cy_ubi_detencion'),
    'searchCoordenadaX': document.getElementById('search_cx_ubi_detencion'),
    'buscar': document.getElementById('buscar_ubi_detencion'),
    'colonia': document.getElementById('id_colonia_ubi_detencion'),
    'calle': document.getElementById('id_calle_1_ubi_detencion'),
    'calle2': document.getElementById('id_calle_2_ubi_detencion'),
    'noInterior': document.getElementById('id_no_ext_ubi_detencion'),
    'noExterior': document.getElementById('id_no_int_ubi_detencion'),
    'coordenadaY': document.getElementById('id_coord_y_ubi_detencion'),
    'coordenadaX': document.getElementById('id_coord_x_ubi_detencion'),
    'estado': document.getElementById('id_estado_ubi_detencion'),
    'municipio': document.getElementById('id_municipio_ubi_detencion'),
    'cp': document.getElementById('id_cp_ubi_detencion')
}

ubi_detencion['porDireccion'].style.display = 'none';
ubi_detencion['porCoordenada'].style.display = 'none';




/**--------------------------------OFFLINE MAPAS-------------------------------- */
const radios = document.getElementsByName('busqueda');
let markers = [],
    type = 0;

const offlineMapsAnexoA = () => {
    apartados = ['domDetenido', 'ubi_detencion'];

    apartados.forEach(apartado => {
        switch (apartado) {
            case 'domDetenido':
                apartado = domDetenido;
                break;
            case 'ubi_detencion':
                apartado = ubi_detencion;
                break;

        }
        apartado['coordenadaY'].removeAttribute('readonly');
        apartado['coordenadaX'].removeAttribute('readonly');
        apartado['municipio'] != undefined ? apartado['municipio'].removeAttribute('readonly') : '';
    });
    document.getElementById("id_map_1").innerHTML = document.getElementById("id_map_2").innerHTML = `
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
    offlineMapsAnexoA();
});

/**------------------------------------FUNCIONES GENERALES MAPS------------------------------- */
window.addEventListener('online', function(e) {
    //console.log('online');
    apartados = ['domDetenido', 'ubi_detencion'];

    apartados.forEach(apartado => {
        switch (apartado) {
            case 'domDetenido':
                apartado = domDetenido;
                break;
            case 'ubi_detencion':
                apartado = ubi_detencion;
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
        document.getElementById("id_map_1").innerHTML = document.getElementById("id_map_2").innerHTML = `
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

    const primer_map = new google.maps.Map(document.getElementById("id_map_1"), option);
    const segundo_map = new google.maps.Map(document.getElementById("id_map_2"), option);
    // const quinto_map = new google.maps.Map(document.getElementById("map4"), option);

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
            let apartado;
            let map;


            switch (data_id) {
                case 'domDetenido':
                    apartado = domDetenido;
                    map = primer_map;
                    break;
                case 'ubi_detencion':
                    apartado = ubi_detencion;
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

        if (e.address_components[i]['types'][0] == 'administrative_area_level_1' && apartado['estado'] != undefined)
            apartado['estado'].value = e.address_components[i]['long_name']

        if (e.address_components[i]['types'][0] == 'postal_code')
            apartado['cp'].value = e.address_components[i]['long_name']
    }

    apartado['coordenadaY'].value = e.geometry.location.lat();
    apartado['coordenadaX'].value = e.geometry.location.lng();


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


        if (input[nombre] != '') {
            try {
                input[nombre].value = ''
            } catch (error) {
                console.log(nombre);
                console.log(error);

            }
        }
    }
}

function clean_marks() {
    markers.forEach(function(m) { m.setMap(null); });
}
/**------------------------------------FIN FUNCIONES GENERALES MAPS------------------------------- */