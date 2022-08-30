var map;


var btn_cord = document.getElementById('buscar_ev')


/*Esta sección se puede pasar a otro js*/
document.getElementById('por_direccion').style.display = 'none';
document.getElementById('por_coordenadas').style.display = 'none';

var type = 0;

const offlineMapsPrincipal = () => {

    document.getElementById("cordY").removeAttribute('readonly');
    document.getElementById("cordX").removeAttribute('readonly');
    document.getElementById('Municipio').removeAttribute('readonly');

    document.getElementById("map").innerHTML = `
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

window.addEventListener('online', function(e) {

    document.getElementById("cordY").setAttribute('readonly', '');
    document.getElementById("cordX").setAttribute('readonly', '');
    document.getElementById('Municipio').setAttribute('readonly', '');

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
        document.getElementById("map").innerHTML = `
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

    map = new google.maps.Map(document.getElementById("map"), option);

    var markers = [];

    const geocoder = new google.maps.Geocoder(); //Se crea un geocoder para hacer una busquedea inversa
    type = 0




    $('input[name=busqueda]').click(function() {
        if (this.value == 0) { //Busqueda por dirección
            document.getElementById('por_direccion').style.display = 'block';
            document.getElementById('por_coordenadas').style.display = 'none';
            type = 0;
            clear_fields(1);
            clean_marks(markers)

            document.getElementById('dir').value = ''; //Se limpia el campo de busqueda
            var input = document.getElementById('dir'); //Se obtiene el campo en donde se mostraran los resultados de busqueda en google maps
            var searchName = new google.maps.places.SearchBox(input); //Se crea el constructor para la caja de busqueda

            map.addListener('bounds_changed', function() { // Set search to stay within bounds first
                searchName.setBounds(map.getBounds());
            })

            searchName.addListener('places_changed', function() { // When user selects prediction from list

                // Var to get places
                var places = searchName.getPlaces(); //Se obtienen los lugares

                if (places.length === 0) { //Sino hay resultados, no hace nada
                    return;
                }

                clean_marks(markers)
                markers = []; //Se limpia el arreglo

                // bounds object
                var bounds = new google.maps.LatLngBounds(); //Objeto que contiene los resultados

                places.forEach(function(p) { //Sino hay resultados, no hace nada
                    if (!p.geometry) {
                        return;
                    }

                    markers.push(new google.maps.Marker({ //Se insertan marcadores en el arreglo
                        map: map, //Mapa destino
                        title: p.title, //Titulo del marcador
                        position: p.geometry.location, //Coordenadas en donde se posicionará el marcador
                        draggable: true //Se hablilita el movimiento del marcador
                    }));




                    markers[0].addListener('dragend', function(event) { //Este listener se encarga de obtener los nuevos datos en caso de que el usuario mueva el marcador
                        document.getElementById("cordY").value = this.getPosition().lat(); //escribimos las coordenadas de la posicion actual del marcador dentro de los input
                        document.getElementById("cordX").value = this.getPosition().lng();


                        var lati = this.getPosition().lat();
                        var lon = this.getPosition().lng();

                        geocodeLatLng(geocoder, map, type, markers, lati, lon)
                    });

                    //Se centra el mapa en la nueva posicón ubicada
                    if (p.geometry.viewport) {
                        bounds.union(p.geometry.viewport);
                    } else {
                        bounds.extend(p.geometry.location);
                    }

                    getAdress(p, type)
                });
                map.fitBounds(bounds);
            });

        } else { //Busqueda por coordenadas
            document.getElementById('por_coordenadas').style.display = 'block';
            document.getElementById('por_direccion').style.display = 'none';
            clear_fields(0);
            type = 1
            clean_marks(markers)

            btn_cord.addEventListener('click', () => {
                if (document.getElementById('search_cy').value != '' && document.getElementById('search_cx').value != '') {
                    geocodeLatLng(geocoder, map, type, markers, document.getElementById('search_cy').value, document.getElementById('search_cx').value)
                } else {
                    alert("Por favor ingresa unas coordenadas validas")
                }
            })
        }
    });
}



function getAdress(e, type) {

    for (var i = 0; i < e.address_components.length; i++) {
        if (e.address_components[i]['types'] == 'street_number')
            document.getElementById('noExterior').value = e.address_components[i]['short_name']

        if (e.address_components[i]['types'] == 'route')
            document.getElementById('Calle').value = e.address_components[i]['short_name']

        if (e.address_components[i]['types'][0] == 'sublocality_level_1' || e.address_components[i]['types'][0] == 'political')
            document.getElementById('Colonia').value = e.address_components[i]['short_name']

        if (e.address_components[i]['types'][0] == 'locality')
            document.getElementById('Municipio').value = e.address_components[i]['short_name']

        if (e.address_components[i]['types'][0] == 'administrative_area_level_1')
            document.getElementById('Estado').value = e.address_components[i]['long_name']

        if (e.address_components[i]['types'][0] == 'postal_code')
            document.getElementById('CP').value = e.address_components[i]['long_name']
    }

    document.getElementById("cordY").value = e.geometry.location.lat();
    document.getElementById("cordX").value = e.geometry.location.lng();
    /* document.getElementById('cordX').value = Object.values(e.geometry.viewport)[0].i;
    document.getElementById('cordY').value = Object.values(e.geometry.viewport)[1].i; */

    if (type == 0)
        document.getElementById('dir').value = e.formatted_address
}

function geocodeLatLng(geocoder, map, type, mark, latitud, longitud) {


    //Estado 0 - la función es utilizada para actualizar una dirtección apartir de que el markador es movido
    //Estado 1 - buscará una nueva dirección unicamente por coordendas


    const lat = latitud //document.getElementById('cordY').value
    const lng = longitud //document.getElementById('cordX').value

    // console.log(lat)
    // console.log(lng)

    const latlng = {
        lat: parseFloat(lat),
        lng: parseFloat(lng)
    };

    console.log(latlng)

    geocoder.geocode({ location: latlng }, (results, status) => {
        if (status === "OK") {
            if (results[0]) {
                switch (type) {
                    case 0:
                        getAdress(results[0], 0)
                        break;

                    case 1:
                        clean_marks(mark)
                        mark.push(new google.maps.Marker({
                            map: map,
                            position: latlng,
                        }));

                        getAdress(results[0], type)

                        mark[0].addListener('dragend', function(event) { //Este listener se encarga de obtener los nuevos datos en caso de que el usuario mueva el marcador
                            document.getElementById("cordY").value = this.getPosition().lat(); //escribimos las coordenadas de la posicion actual del marcador dentro de los input
                            document.getElementById("cordX").value = this.getPosition().lng();

                            document.getElementById("search_cy").value = this.getPosition().lat();
                            document.getElementById("search_cx").value = this.getPosition().lng();

                            var lati1 = this.getPosition().lat();
                            var lon1 = this.getPosition().lng();

                            geocodeLatLng(geocoder, map, 1, mark, lati1, lon1)

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


document.getElementById('dir').addEventListener('input', () => {
    document.getElementById('Colonia').value = ''
    document.getElementById('noInterior').value = ''
    document.getElementById('Calle').value = ''
    document.getElementById('Municipio').value = ''
    document.getElementById('Estado').value = ''
    document.getElementById('cordY').value = ''
    document.getElementById('cordX').value = ''
    document.getElementById('CP').value = ''
})


function clear_fields(type) {

    if (type == 0)
        document.getElementById('dir').value = ''

    if (type == 1) {
        document.getElementById('search_cx').value = ''
        document.getElementById('search_cy').value = ''
    }

    document.getElementById('Colonia').value = ''
    document.getElementById('noInterior').value = ''
    document.getElementById('Calle').value = ''
    document.getElementById('Municipio').value = ''
    document.getElementById('Estado').value = ''
    document.getElementById('cordY').value = ''
    document.getElementById('cordX').value = ''
}

function clean_marks(mark) {
    mark.forEach(function(m) { m.setMap(null); });
}