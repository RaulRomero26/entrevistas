const no_remision_fyh = document.getElementById('no_remision_capturaFyH'),
    no_ficha_fyh = document.getElementById('no_ficha_capturaFyH'),
    pathImagesFH = pathFilesRemisiones + `${no_ficha_fyh.value}/FotosHuellas/${no_remision_fyh.value}/`;

const getFotosHuellas = () => {

    var myFormData = new FormData()
    myFormData.append('no_remision', no_remision_fyh.value)

    fetch(base_url + 'getAllFotosHuellas', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {

        data.fotos.forEach(elem=>{
            document.getElementById(`${elem.Tipo}_${elem.Perfil}`).src = pathImagesFH+elem.Path_Imagen;
        })

    })
}

const toDataUrl = (url, callback) => {
    var xhr = new XMLHttpRequest();
    xhr.onload = function() {
        var reader = new FileReader();
        reader.onloadend = function() {
            callback(reader.result);
        }
        reader.readAsDataURL(xhr.response);
    };
    xhr.open('GET', url);
    xhr.responseType = 'blob';
    xhr.send();
}


const collapse_one = document.getElementById('collapse_one');
const collapse_two = document.getElementById('collapse_two');

const collapse_one_1 = document.getElementById('collapse_one_1');
const collapse_two_1 = document.getElementById('collapse_two_1');


const tabla = document.getElementById("tabla");
const tbody_coincidencias = document.getElementById('tbody_coincidencias');
const NotFound = document.getElementById("NotFound");


const tabla_iris = document.getElementById("tabla_iris");
const tbody_coincidencias_iris = document.getElementById('tbody_coincidencias_iris');
const NotFound_iris = document.getElementById("NotFound_iris");

/*collapse_two.disabled = true;
tabla.style.display = 'none'
NotFound.style.display = 'none' */

const getHuellas = async() => {
    var myFormData = new FormData()
    myFormData.append('no_remision', no_remision_fyh.value)

    const response = await fetch(base_url_js + 'Remisiones/openImgFromFTP', {
        method: 'POST',
        body: myFormData
    })
    const data = await response.json()
        //console.log(data)
    if (data.status_PathExist === true) {
        //collapse_two.disabled = false;
        //document.getElementById('CapturaHuellas').innerText = 'Volver a capturar';
        document.getElementById('finger_1').src = data.LeftIndexFinger
        document.getElementById('finger_2').src = data.LeftMiddleFinger
        document.getElementById('finger_3').src = data.LeftRingFinger
        document.getElementById('finger_4').src = data.LeftLittle
        document.getElementById('finger_5').src = data.RightIndexFinger

        document.getElementById('finger_6').src = data.RightMiddleFinger
        document.getElementById('finger_7').src = data.RightRingFinger
        document.getElementById('finger_8').src = data.RightLittle
        document.getElementById('finger_9').src = data.LeftThumb
        document.getElementById('finger_10').src = data.RightThumb
    }
}


let buscarCoincidencias = async() => {
    tabla.style.display = 'none'
    const remision = document.getElementById('no_remision_principales').value
    const ficha = document.getElementById('no_ficha_principales').value

    var myform = new FormData()
    myform.append("no_remision", remision)

    const response = await fetch(base_url_js + 'Remisiones/getHuellasAPI', {
        method: 'POST',
        body: myform
    })
    const data = await response.json()

    if (data.success) { //con resultados
        //loader.style.display = 'none'
        //button_panel.style.display = 'block'
        //button_huellas.textContent = "Reiniciar búsqueda"
        NotFound.style.display = 'none'
        tabla.style.display = 'block'
        tbody_coincidencias.innerHTML = ""
        var tbody_dinamic = ""

        data.coincidencias.forEach((elem, index, arreglo) => {
            var imgNameAux = base_url_js + 'public/files/Remisiones/' + elem.no_ficha + '/FotosHuellas/' + elem.no_remision + '/ROSTRO_FRENTE.jpeg';
            var img = new Image();
            img.src = imgNameAux
            if (img.height == 0)
                imgNameAux = base_url_js + 'public/files/Remisiones/' + elem.no_ficha + '/FotosHuellas/' + elem.no_remision + '/ROSTRO_FRENTE.png';


            tbody_dinamic += '<tr>' +
                '<td class="v-a-middle">' + elem.no_remision + '</td>' +
                '<td class="v-a-middle">' + elem.nombre_detenido + '</td>' +
                '<td class="v-a-middle">' + elem.fecha_detenido + '</td>' +
                '<td class="v-a-middle">' + elem.score_match + '</td>' +
                '<td class="v-a-middle">' +
                '<img src="' + imgNameAux + '" class="my-cfh-width"' +
                +'</td>' +
                '<tr>'
        })
        tbody_coincidencias.innerHTML = tbody_dinamic
    } else {
        NotFound.style.display = 'block'
    }
}

const getStatusIris = async() => {
    var myFormData = new FormData()
    myFormData.append('no_remision', no_remision_fyh.value)

    const response = await fetch(base_url_js + 'Remisiones/getStatusIris', {
        method: 'POST',
        body: myFormData
    })
    const data = await response.json()
        //console.log(data)
    if (data === false) {
        document.getElementById('status_res').innerText = 'No capturado'
        document.getElementById('img_1').src = base_url_js + 'public/media/icons/eye.png'
        document.getElementById('img_2').src = base_url_js + 'public/media/icons/eye.png'

    } else {
        document.getElementById('status_res').innerText = 'Capturado'
        document.getElementById('img_1').src = base_url_js + 'public/media/icons/eye_after.png'
        document.getElementById('img_2').src = base_url_js + 'public/media/icons/eye_after.png'
    }
}


let buscarCoincidenciasIris = async() => {
    tabla_iris.style.display = 'none'
    const remision = document.getElementById('no_remision_principales').value
    const ficha = document.getElementById('no_ficha_principales').value

    var myform = new FormData()
    myform.append("no_remision", remision)

    const response = await fetch(base_url_js + 'Remisiones/getIrisAPI', {
        method: 'POST',
        body: myform
    })
    const data = await response.json()

    console.log(data)

    if (data.success) { //con resultados
        NotFound_iris.style.display = 'none'
        tabla_iris.style.display = 'block'
        tbody_coincidencias_iris.innerHTML = ""
        var tbody_dinamic = ""

        data.coincidencias.forEach((elem, index, arreglo) => {
            var imgNameAux = base_url_js + 'public/files/Remisiones/' + elem.no_ficha + '/FotosHuellas/' + elem.no_remision + '/ROSTRO_FRENTE.jpeg';
            var img = new Image();
            img.src = imgNameAux
            if (img.height == 0)
                imgNameAux = base_url_js + 'public/files/Remisiones/' + elem.no_ficha + '/FotosHuellas/' + elem.no_remision + '/ROSTRO_FRENTE.png';


            tbody_dinamic += '<tr>' +
                '<td class="v-a-middle">' + elem.no_remision + '</td>' +
                '<td class="v-a-middle">' + elem.nombre_detenido + '</td>' +
                '<td class="v-a-middle">' + elem.fecha_detenido + '</td>' +
                '<td class="v-a-middle">' +
                '<img src="' + imgNameAux + '" class="my-cfh-width"' +
                +'</td>' +
                '<tr>'
        })
        tbody_coincidencias_iris.innerHTML = tbody_dinamic
    } else { //sin resultados

        NotFound_iris.style.display = 'block'
    }
}