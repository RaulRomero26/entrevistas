var filiacionData = document.getElementById('datos_mediaFiliacion')

var filiacion_EstaturaError = document.getElementById('Estatura_error')
/*var conocido_nombreError = document.getElementById('Nombre_conocido_error')
var conocido_apaternoError = document.getElementById('apaterno_conocido_error')
var conocido_amaternoError = document.getElementById('amaterno_conocido_error')
var conocido_telefonoError = document.getElementById('telefono_conocido_error')
var conocido_edadError = document.getElementById('edad_conocido_error')*/

var Complexion = document.getElementById('Complexion')
var Estarura = document.getElementById('Estarura')
var Color_p = document.getElementById('Color_p')
var formaCara = document.getElementById('formaCara')
var Pomulos = document.getElementById('Pomulos')
var Cabello = document.getElementById('Cabello')
var colorCabello = document.getElementById('colorCabello')
var tamCabello = document.getElementById('tamCabello')
var formaCabello = document.getElementById('formaCabello')
var Frente = document.getElementById('Frente')
var Cejas = document.getElementById('Cejas')
var tipoCejas = document.getElementById('tipoCejas')
var colorOjo = document.getElementById('colorOjo')
var tamOjos = document.getElementById('tamOjos')
var formaOjos = document.getElementById('formaOjos')
var Nariz = document.getElementById('Nariz')
var tamBoca = document.getElementById('tamBoca')
var Labios = document.getElementById('Labios')
var Menton = document.getElementById('Menton')
var tamOrejas = document.getElementById('tamOrejas')
var Lobulos = document.getElementById('Lobulos')
var Barba = document.getElementById('Barba')
var tamBarba = document.getElementById('tamBarba')
var colorBarba = document.getElementById('colorBarba')
var Bigote = document.getElementById('Bigote')
var tamBigote = document.getElementById('tamBigote')
var colorBigote = document.getElementById('colorBigote')

var Id_MediaF

var msg_mediaFError = document.getElementById('msg_mediaF')
const arraySelectores = new Array(Complexion,Estarura,Color_p,formaCara,Pomulos,Cabello,colorCabello,tamCabello,formaCabello,Frente,Cejas,tipoCejas,colorOjo,tamOjos,formaOjos
    ,Nariz,tamBoca,Labios,Menton,tamOrejas,Lobulos,Barba,tamBarba,colorBarba,Bigote,tamBigote,colorBigote); 
async function ValidarFiliacion() {

    const button = document.getElementById('btn_mediaF');
    // funcion para cambiar los colores a invalido despues del primer intento de guardado
                   
    arraySelectores.forEach(element  => {
        if(element.value == 'SIN CAPTURAR'){
            element.classList.add('is-invalid')
            }
    })
    var myFormData = new FormData(filiacionData)
    var band = []
    var FV = new FormValidator()
    var i = 0

    band[i++] = filiacion_EstaturaError.innerText = FV.validate(myFormData.get('Estarura'), 'required | numeric')

    /*if (myFormData.get('infoConocido') == 'Si') {

        band[i++] = conocido_nombreError.innerText = FV.validate(myFormData.get('Nombre_conocido'), 'required')
        band[i++] = conocido_apaternoError.innerText = FV.validate(myFormData.get('apaterno_conocido'), 'required')
        band[i++] = conocido_telefonoError.innerText = FV.validate(myFormData.get('telefono_conocido'), 'required | numeric | length[10]')

        if (myFormData.get('edad_conocido') != '')
            band[i++] = conocido_edadError.innerText = FV.validate(myFormData.get('edad_conocido'), 'numeric | length[2]')
    }*/

    var success = true
    band.forEach(element => {
        success &= (element == '') ? true : false
    })

    const result = await getTabValidado(9);
    if(!result){
        success = false;
    }
     //funcion para saber que los selectores tengan algo distinto a sin capturar y se pueda guardar la informacion
     arraySelectores.forEach(element => {
        success &= (element.value != 'SIN CAPTURAR') ? true : false
    })
// funcion para cambiar los colores a invalido o quitarlo despues del primer intento de guardar un "sin capturar"
    arraySelectores.forEach (element => element.addEventListener('change', (event) => {
        if(event.target.value == 'SIN CAPTURAR'){
            element.classList.add('is-invalid');
        }else {
            
            element.classList.remove('is-invalid');
        }
    }) 
    )
    
    if (success) { //si todo es correcto se envía form

        button.innerHTML = `
            Guardando
            <div class="spinner-grow spinner-grow-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        `;
        button.classList.add('disabled-link');

        myFormData.append('boton_mediaFiliacion', document.getElementById('btn_mediaF').value)
        /*Se añaden las siguientes dos lineas */
        myFormData.append('contactos_table', JSON.stringify(readTableConocidos()));
        myFormData.append('ID_MEDIA_FILIACION',Id_MediaF);
       /* if (myFormData.get('edad_conocido') == '')
            myFormData.set('edad_conocido', 0)*/

        fetch(base_url + 'ModificarMediaF', {
            method: 'POST',
            body: myFormData
        })

        .then(res => res.json())

        .then(data => {

            button.innerHTML = `
                Guardar
            `;
            button.classList.remove('disabled-link');



            if (!data.status) {
                filiacion_EstaturaError.innerText = (data.filiacion_EstaturaError === undefined) ? '' : data.filiacion_EstaturaError

              /*  if ('conocido_nombreError' in data)
                    conocido_nombreError.innerText = (data.conocido_nombreError === undefined) ? '' : data.conocido_nombreError


                if ('conocido_apaternoError' in data)
                    conocido_apaternoError.innerText = (data.conocido_apaternoError === undefined) ? '' : data.conocido_apaternoError


                if ('conocido_amaternoError' in data)
                    conocido_amaternoError.innerText = (data.conocido_amaternoError === undefined) ? '' : data.conocido_amaternoError


                if ('conocido_telefonoError' in data)
                    conocido_telefonoError.innerText = (data.conocido_telefonoError === undefined) ? '' : data.conocido_telefonoError


                if ('conocido_edadError' in data)
                    conocido_edadError.innerText = (data.conocido_edadError === undefined) ? '' : data.conocido_edadError*/

                let messageError;
                if ('error_message' in data) {
                    if (data.error_message != 'Render Index') {
                        if (typeof(data.error_message) != 'string') {
                            messageError = `<div class="alert alert-danger text-center" role="alert">Sucedio un error en el servidor: ${data.error_message.errorInfo[2]}</div>`;
                        } else {
                            messageError = `<div class="alert alert-danger text-center" role="alert">Sucedio un error en el servidor: ${data.error_message}</div>`;
                        }
                    } else {
                        messageError = `<div class="alert alert-danger text-center alert-session-create" role="alert">
                                <p>Sucedio un error, su sesión caduco o no tiene los permisos necesarios. Por favor vuelva a iniciar sesión.</p>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalLogin">
                                    Iniciar sesión
                                </button>
                            </div>`;
                    }
                } else {
                    messageError = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>'
                }


                msg_mediaFError.innerHTML = messageError
                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });

            } else {

                window.scroll({
                    top: 0,
                    left: 100,
                    behavior: 'smooth'
                });

                msg_mediaFError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información actualizada correctamente.</div>'
                getTabsGuardados();


            }


            // msg_mediaFError.innerHTML = ;
            // result.tab === '1' ? '' : document.getElementById('save-tab-9').style.display = 'block';


        })
    } else { //si no, se muestran errores en pantalla
        msg_mediaFError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>'
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });
    }

    for (var pair of myFormData.entries()) {
        // console.log(pair[0]+ ', '+ pair[1]); 
    }
}
/*Funcion modificada para separar la media filiacion de los
contactos conocidos del detenido, ahora solo se encarga de agregar los datos
de media filiacion de la base de datos a la vista*/
function getMediaFiliacion() {
    var no_remision = document.getElementById('no_remision_mediaFiliacion')

    var myFormData = new FormData()
    myFormData.append('no_remision', no_remision.value)

    fetch(base_url + 'getMediaFiliacion', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {
        Id_MediaF = data.Id_Media_Filiacion
        Complexion.value = data.Complexion.toUpperCase()
        Estarura.value = data.Estatura_cm
        Color_p.value = data.Color_Piel.toUpperCase()
        formaCara.value = data.Forma_Cara.toUpperCase()
        Pomulos.value = data.Pomulos.toUpperCase()
        Cabello.value = data.Cabello.toUpperCase()
        colorCabello.value = data.Color_Cabello.toUpperCase()
        tamCabello.value = data.Tam_Cabello.toUpperCase()
        formaCabello.value = data.Forma_Cabello.toUpperCase()
        Frente.value = data.Frente.toUpperCase()
        Cejas.value = data.Cejas.toUpperCase()
        tipoCejas.value = data.Tipo_Cejas.toUpperCase()
        colorOjo.value = data.Color_Ojos.toUpperCase()
        tamOjos.value = data.Tam_Ojos.toUpperCase()
        formaOjos.value = data.Forma_Ojos.toUpperCase()
        Nariz.value = data.Nariz.toUpperCase()
        tamBoca.value = data.Tam_Boca.toUpperCase()
        Labios.value = data.Labios.toUpperCase()
        Menton.value = data.Menton.toUpperCase()
        tamOrejas.value = data.Tam_Orejas.toUpperCase()
        Lobulos.value = data.Lobulos.toUpperCase()
        Barba.value = data.Barba.toUpperCase()
        tamBarba.value = data.Tam_Barba.toUpperCase()
        colorBarba.value = data.Color_Barba.toUpperCase()
        Bigote.value = data.Bigote.toUpperCase()
        tamBigote.value = data.Tam_Bigote.toUpperCase()
        colorBigote.value = data.Color_Bigote.toUpperCase()
        document.getElementById('infoConocido').style.display = 'block'
        /*if (data.Nombre != null) {
            document.getElementById('infoConocido1').checked = false
            document.getElementById('infoConocido2').checked = true
            document.getElementById('infoConocido').style.display = 'block'

            document.getElementById('parentezco_conocido').value = data.Parentesco
            document.getElementById('Nombre_conocido').value = data.Nombre
            document.getElementById('apaterno_conocido').value = data.Ap_Paterno
            document.getElementById('amaterno_conocido').value = data.Ap_Materno
            document.getElementById('telefono_conocido').value = data.Telefono
            document.getElementById('edad_conocido').value = (data.Edad != 0 ? data.Edad : '')
            document.getElementById('sexo_conocido').value = data.Genero
        } else {
            document.getElementById('infoConocido1').checked = true
            document.getElementById('infoConocido2').checked = false
            document.getElementById('infoConocido').style.display = 'none'
        }*/
    })
}
/*Funcion añadida para recibir la informacion de los contactos conocidos del
detenido, separarla y mandarla a ingresar a la tabla */
function getContactoDetenido() {
    var no_remision = document.getElementById('no_remision_mediaFiliacion')

    var myFormData = new FormData()
    myFormData.append('no_remision', no_remision.value)

    fetch(base_url + 'getContactoDetenido', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {
        const rowsTableConocidos = data.conocidos;
        for (let i = 0; i < rowsTableConocidos.length; i++) {
            let formData = {
                parentezco_conocido: rowsTableConocidos[i].Parentesco,
                Nombre_conocido: rowsTableConocidos[i].Nombre,
                apaterno_conocido: rowsTableConocidos[i].Ap_Paterno,
                amaterno_conocido: rowsTableConocidos[i].Ap_Materno,
                telefono_conocido: rowsTableConocidos[i].Telefono,
                edad_conocido: rowsTableConocidos[i].Edad,
                sexo_conocido: rowsTableConocidos[i].Genero,
            }
            insertNewRowContacto(formData);
        }
    })
}
/*Funcion añadida para leer la tabla de conocidos*/
const readTableConocidos=()=> {
    const table = document.getElementById('informacionConocidos');
    let conocidos = [];
    for (let i = 1; i < table.rows.length; i++) {
        conocidos.push({
            ['row']: {
                tipo_relacion: table.rows[i].cells[0].innerHTML,
                nombres: table.rows[i].cells[1].innerHTML,
                apellido_p: table.rows[i].cells[2].innerHTML,
                apellido_m: table.rows[i].cells[3].innerHTML,
                telefono: table.rows[i].cells[4].innerHTML,
                edad: table.rows[i].cells[5].innerHTML,
                sexo: table.rows[i].cells[6].innerHTML,
            }
        });
    }
    return conocidos;
}