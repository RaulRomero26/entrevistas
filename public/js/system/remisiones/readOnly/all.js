//Obteniendo elementos por Id de datos principales
var oficio_principales = document.getElementById('oficio_principales')
var a911_principales = document.getElementById('911_principales')
var fecha_principales = document.getElementById('fecha_principales')
var hora_principales = document.getElementById('hora_principales')
var tipo_ficha = document.getElementById('tipo_ficha')
var zona = document.getElementById('zona')
var sector = document.getElementById('sector')
var CIA_principales = document.getElementById('CIA_principales')
var Remitido = document.getElementById('Remitido')
var statusR_principales = document.getElementById('statusR_principales')
var statusFICHA_principales = document.getElementById('statusFICHA_principales')
var nacionalidad_principales = document.getElementById('nacionalidad_principales')
var estadoMex_principales = document.getElementById('estadoMex_principales')
var Nombre_principales = document.getElementById('Nombre_principales')
var appPaterno_principales = document.getElementById('appPaterno_principales')
var appMaterno_principales = document.getElementById('appMaterno_principales')
var edad_principales = document.getElementById('edad_principales')
var sexo_principales = document.getElementById('sexo_principales')
var CURP_principales = document.getElementById('CURP_principales')
var verificado_principales = document.getElementById('verificado_principales')
var alcoholemia_principales = document.getElementById('alcoholemia_principales')
var Colonia = document.getElementById('Colonia')
var Calle = document.getElementById('Calle')
var noInterior = document.getElementById('noInterior')
var noExterior = document.getElementById('noExterior')
var cordY = document.getElementById('cordY')
var cordX = document.getElementById('cordX')
var Municipio = document.getElementById('Municipio')
var CP = document.getElementById('CP')
var FechaNacimiento_principales = document.getElementById('FechaNacimiento_principales')
var RFC_principales = document.getElementById('RFC_principales')
var correo_principales = document.getElementById('correo_principales')
var Ocupacion_principales = document.getElementById('Ocupacion_principales')
var Facebook_principales = document.getElementById('Facebook_principales')
var edoCivil_principales = document.getElementById('edoCivil_principales')
var Telefono_principales = document.getElementById('Telefono_principales')
var imei_1_principales = document.getElementById('imei_1_principales')
var imei_2_principales = document.getElementById('imei_2_principales')
var Alias = document.getElementById('Alias')

//Obteniendo elementos por Id de datos peticionario
var peticionario_Nombres = document.getElementById('peticionario_Nombres')
var peticionario_appPaterno = document.getElementById('peticionario_appPaterno')
var peticionario_appMaterno = document.getElementById('peticionario_appMaterno')
var peticionario_Edad = document.getElementById('peticionario_Edad')
var peticionario_Sexo = document.getElementById('peticionario_Sexo')
var peticionario_Escolaridad = document.getElementById('peticionario_Escolaridad')
var peticionario_Procedencia = document.getElementById('peticionario_Procedencia')
var nacionalidad_pet = document.getElementById('nacionalidad_pet')
var estadoMex_pet = document.getElementById('estadoMex_pet')
var peticionario_Fecha_n = document.getElementById('peticionario_Fecha_n')
var Colonia_peticionario = document.getElementById('Colonia_peticionario')
var Calle_peticionario = document.getElementById('Calle_peticionario')
var noInterior_peticionario = document.getElementById('noInterior_peticionario')
var noExterior_peticionario = document.getElementById('noExterior_peticionario')
var cordY_peticionario = document.getElementById('cordY_peticionario')
var cordX_peticionario = document.getElementById('cordX_peticionario')
var Municipio_peticionario = document.getElementById('Municipio_peticionario')
var CP_peticionario = document.getElementById('CP_peticionario')


//Obteniendo elementos por id de Ubicación de los hechos
var Colonia_hechos = document.getElementById('Colonia_hechos')
var Fraccionamiento_hechos = document.getElementById('Fraccionamiento_hechos')
var Calle_hechos = document.getElementById('Calle_hechos')
var Calle2_hechos = document.getElementById('Calle2_hechos')
var noInterior_hechos = document.getElementById('noInterior_hechos')
var noExterior_hechos = document.getElementById('noExterior_hechos')
var cordY_hechos = document.getElementById('cordY_hechos')
var cordX_hechos = document.getElementById('cordX_hechos')
var CP_hechos = document.getElementById('CP_hechos')
var hora_hechos = document.getElementById('hora_hechos')
var participantes_hechos = document.getElementById('participantes_hechos')
var delito_1 = document.getElementById('delito_1')
var ruta = document.getElementById('ruta')
var unidad = document.getElementById('unidad')
var negocio = document.getElementById('negocio')
var FaltaDelitoTabla_hechos = document.getElementById('FaltaDelitoTabla_RO').getElementsByTagName('tbody')[0];
var vector = document.getElementById('Vector') // Se obtiene el elemento vector de la plantilla de ubicación de hechos

//Obteniedo valores por id de Ubicación de la detención
var fecha_detencion = document.getElementById('fecha_detencion')
var hora_detencion = document.getElementById('hora_detencion')
var Colonia_detencion = document.getElementById('Colonia_detencion')
var Calle_1_detencion = document.getElementById('Calle_1_detencion')
var Calle_2_detencion = document.getElementById('Calle_2_detencion')
var noInterior_detencion = document.getElementById('noInterior_detencion')
var noExterior_detencion = document.getElementById('noExterior_detencion')
var cordY_detencion = document.getElementById('cordY_detencion')
var cordX_detencion = document.getElementById('cordX_detencion')
var CP_detencion = document.getElementById('CP_detencion')
var tipoViolencia = document.getElementById('tipoViolencia')
var formaDetencion = document.getElementById('formaDetencion')
var observaciones_detencion = document.getElementById('observaciones_detencion')
var Fraccionamiento_detencion = document.getElementById('Fraccionamiento_detencion')


let Tipo_Situacion = document.getElementById('Tipo_Situacion')
let Tipo_Vehiculo = document.getElementById('Tipo_Vehiculo')
let Placa_Vehiculo = document.getElementById('Placa_Vehiculo')
let Marca = document.getElementById('Marca')
let Modelo = document.getElementById('Modelo')
let Color = document.getElementById('Color')
let Senia_Particular = document.getElementById('Senia_Particular')
let No_Serie = document.getElementById('No_Serie')
let Procedencia_Vehiculo = document.getElementById('Procedencia_Vehiculo')
let Observacion_Vehiculo = document.getElementById('Observacion_Vehiculo')

//Obteniendo valores por id de Media Filiación
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






window.onload = function() {
    getPrincipales()
    getPeticionario()
    getUbicacionH()
    getUbicaciond()
    getMediaFiliacion()
    /*Se añade la nueva funcion para getContactoDetenido*/
    getContactoDetenido()
    getElementosParticipantes();
    getObjetosRecuperados();
    getFotosHuellas();
    getHuellas();
    buscarCoincidencias();

    getStatusIris();
    getSenasParticulares();
    getEntrevistaDetenido();
    getNarrativas();

    getTabsValidados();
};


function getPrincipales() {
    var no_ficha = document.getElementById('no_ficha_principales')
    var no_remision = document.getElementById('no_remision_principales')

    var myFormData = new FormData()
    myFormData.append('no_ficha', no_ficha.value)
    myFormData.append('no_remision', no_remision.value)

    fetch(base_url + 'getPrincipales', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {

        //console.log(data)

        if (data) {
            oficio_principales.textContent = data.No_Remision
            a911_principales.textContent = data.Folio_911
            /*se cambio la variable a Fecha_Hora para que se mostrara la fecha editada y no la de la creacion de la remision*/
            var auxDateTime = splitDateTime(data.Fecha_Hora);
            fecha_principales.textContent = auxDateTime[0]
            hora_principales.textContent = auxDateTime[1].substring(0, 5)
            tipo_ficha.textContent = data.Grupo
            zona.textContent = data.Zona_Sector;
            CIA_principales.textContent = (data.Cia == '' ? 'NA' : data.Cia)
            Remitido.textContent = data.Instancia
            statusFICHA_principales.textContent =(data.f_cancelada == 'cancelada' ? 'INACTIVA':'ACTIVA');
            statusR_principales.textContent =(data.Status_Remision == '1' ? 'ACTIVA':'INACTIVA');


            Nombre_principales.textContent = data.Nombre
            appPaterno_principales.textContent = data.Ap_Paterno
            appMaterno_principales.textContent = data.Ap_Materno
            edad_principales.textContent = data.Edad

            if (data.Genero == 'h')
                sexo_principales.textContent = 'Hombre'
            else
                sexo_principales.textContent = 'Mujer'

            escolaridad_principales.textContent = data.Escolaridad
            nacionalidad_principales.textContent=data.Nacionalidad
            estadoMex_principales.textContent=data.EstadoMex_Origen
            procedencia_principales.textContent = data.Lugar_Origen
            CURP_principales.textContent = data.CURP

            if (data.Alcoholemia == '1')
                alcoholemia_principales.checked = true

            if (data.Verificacion_CURP == '1')
                verificado_principales.checked = true


            Colonia.textContent = data.Colonia
            Calle.textContent = data.Calle
            if (data.No_Interior != '')
                noInterior.textContent = data.No_Interior
            else
                noInterior.textContent = "NA"

            noExterior.textContent = data.No_Exterior
            cordY.textContent = data.Coordenada_Y
            cordX.textContent = data.Coordenada_X
            Municipio.textContent = data.Nombre_Municipio
            CP.textContent = data.CP

            FechaNacimiento_principales.textContent = data.Fecha_Nacimiento
            RFC_principales.textContent = (data.RFC != '' ? data.RFC : 'NA')
            correo_principales.textContent = (data.Correo_Electronico != '' ? data.Correo_Electronico : 'NA')
            Ocupacion_principales.textContent = (data.Ocupacion != '' ? data.Ocupacion : 'NA')
            Facebook_principales.textContent = (data.Facebook != '' ? data.Facebook : 'NA')
            edoCivil_principales.textContent = (data.Estado_Civil != '' ? (data.Estado_Civil == 1 ? 'Soltero' : 'Casado') : 'NA')
            Telefono_principales.textContent = (data.Telefono != '' ? data.Telefono : 'NA')
            imei_1_principales.textContent = (data.Imei1 != '' ? data.Imei1 : 'NA')
            imei_2_principales.textContent = (data.Imei2 != '' ? data.Imei2 : 'NA')
            Alias.textContent = (data.alias_detenido != '' ? data.alias_detenido : 'NA')
        }
    })
}

function getPeticionario() {
    var no_ficha = document.getElementById('no_ficha_peticionario')


    var myFormData = new FormData()
    myFormData.append('no_ficha', no_ficha.value)

    fetch(base_url + 'getPeticionario', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {

        if (data) {

            peticionario_Nombres.textContent = data.Nombre
            peticionario_appPaterno.textContent = data.Ap_Paterno
            peticionario_appMaterno.textContent = data.Ap_Materno
            peticionario_Edad.textContent = data.Edad
            peticionario_Sexo.textContent = (data.Genero == 'h' ? 'Hombre' : 'Mujer')
            peticionario_Escolaridad.textContent = data.Escolaridad
            peticionario_Procedencia.textContent = data.Lugar_Origen
            nacionalidad_pet.textContent = data.Nacionalidad
            estadoMex_pet.textContent = data.EstadoMex_Origen
            peticionario_Fecha_n.textContent = data.Fecha_Nacimiento

            Colonia_peticionario.textContent = data.Colonia
            Calle_peticionario.textContent = data.Calle
            noInterior_peticionario.textContent = (data.No_Interior != '' ? data.No_Interior : 'NA')
            noExterior_peticionario.textContent = data.No_Exterior
            cordY_peticionario.textContent = data.Coordenada_Y
            cordX_peticionario.textContent = data.Coordenada_X
            Municipio_peticionario.textContent = data.Nombre_Municipio
            CP_peticionario.textContent = data.CP
        }
    })
}

function getUbicacionH() {
    var no_ficha = document.getElementById('no_ficha_ubicacionHechos')
    var no_remision = document.getElementById('no_remision_ubicacionHechos')


    var myFormData = new FormData()
    myFormData.append('no_ficha', no_ficha.value)
    myFormData.append('no_remision', no_remision.value)

    fetch(base_url + 'getUbicacionH', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {
        const { ubicacion_h, faltas_delitos } = data

        if (data) {
            console.log(data)
            Colonia_hechos.textContent = (ubicacion_h.Colonia != '' ? ubicacion_h.Colonia : 'NA')
            Fraccionamiento_hechos.textContent = (ubicacion_h.Fraccionamiento != '' ? ubicacion_h.Fraccionamiento : 'NA')
            Calle_hechos.textContent = (ubicacion_h.Calle_1 != '' ? ubicacion_h.Calle_1 : 'NA')
            Calle2_hechos.textContent = (ubicacion_h.Calle_2 != '' ? ubicacion_h.Calle_2 : 'NA')
            noInterior_hechos.textContent = (ubicacion_h.No_Int != null && ubicacion_h.No_Int != '' ? ubicacion_h.No_Int : 'NA') //añadida la condicional null para poder mostrar información en la plantilla
            noExterior_hechos.textContent = (ubicacion_h.No_Ext != null && ubicacion_h.No_Ext != '' ? ubicacion_h.No_Ext : 'NA') //añadida la condicional null para poder mostrar información en la plantilla 
            cordY_hechos.textContent = (ubicacion_h.Coordenada_Y != null && ubicacion_h.Coordenada_Y != '' ? ubicacion_h.Coordenada_Y : 'NA')//añadida la condicional null para poder mostrar información en la plantilla 
            cordX_hechos.textContent = (ubicacion_h.Coordenada_X != null && ubicacion_h.Coordenada_X != '' ? ubicacion_h.Coordenada_X : 'NA')//añadida la condicional null para poder mostrar información en la plantilla 
            CP_hechos.textContent = (ubicacion_h.CP != null && ubicacion_h.CP != '' ? ubicacion_h.CP : 'NA') //añadida la condicional null para poder mostrar información en la plantilla
            hora_hechos.textContent = (ubicacion_h.Hora_Reporte.substring(0, 5) != '' ? ubicacion_h.Hora_Reporte : 'NA')
            participantes_hechos.textContent = (ubicacion_h.No_Participantes != '' ? ubicacion_h.No_Participantes : 'NA')
            delito_1.textContent = (ubicacion_h.Remitido_Por != '' ? ubicacion_h.Remitido_Por : 'NA')
            vector.textContent = (ubicacion_h.Vector != '' ? ubicacion_h.Vector : 'NA')// Se añadio la condicional del vector, para poder mostrar su contenido en el caso de que exista, por el contrario mostrar NA

            //console.log(faltas_delitos.length)

            for (let i = 0; i < faltas_delitos.length; i++) {

                //console.log(faltas_delitos[i])
                let Descripcion = faltas_delitos[i].Descripcion.toUpperCase();
                let Comercio = (faltas_delitos[i].Negocio_Afectado != null) ? faltas_delitos[i].Negocio_Afectado.toUpperCase() : ' - ';
                let Unidad = (faltas_delitos[i].Unidad_Ruta_Afectada != null) ? faltas_delitos[i].Unidad_Ruta_Afectada.toUpperCase() : ' - ';
                let Ruta = (faltas_delitos[i].Ruta_Afectada != null) ? faltas_delitos[i].Ruta_Afectada.toUpperCase() : ' - ';

                FaltaDelitoTabla_hechos.insertRow().innerHTML =
                    '<td class="text-center">' + Descripcion + '</td>' +
                    '<td class="text-center">' + Comercio + '</td>' +
                    '<td class="text-center">' + Ruta + '</td>' +
                    '<td class="text-center">' + Unidad + '</td>';
            }
        }
    })
}

function getUbicaciond() {
    var no_remision = document.getElementById('no_remision_detencion')


    var myFormData = new FormData()
    myFormData.append('no_remision', no_remision.value)

    fetch(base_url + 'getUbicacionD', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {

        console.log(data)

        if (data) {

            var auxDateTime = splitDateTime(data.ubicacionD[0].Fecha_Hora_Detencion);
            fecha_detencion.textContent = auxDateTime[0]
            hora_detencion.textContent = auxDateTime[1].substring(0, 5)
            Colonia_detencion.textContent = data.ubicacionD[0].Colonia
            Calle_1_detencion.textContent = data.ubicacionD[0].Calle_1
            Calle_2_detencion.textContent = (data.ubicacionD[0].Calle_2 != '') ? data.ubicacionD[0].Calle_2 : 'NA'
            noInterior_detencion.textContent = data.ubicacionD[0].No_Int
            noExterior_detencion.textContent = (data.ubicacionD[0].No_Ext != '') ? data.ubicacionD[0].No_Ext : 'NA'
            cordY_detencion.textContent = data.ubicacionD[0].Coordenada_Y
            cordX_detencion.textContent = data.ubicacionD[0].Coordenada_X
            CP_detencion.textContent = data.ubicacionD[0].CP
            Fraccionamiento_detencion.textContent = data.ubicacionD[0].Fraccionamiento
            //Se agrego .ubicacionD[0] a los campos de tipo de violencia, forma de detencion, descripcion forma de detencion y observaciones
            tipoViolencia.textContent = data.ubicacionD[0].Tipo_Violencia
            formaDetencion.textContent = data.ubicacionD[0].Forma_Detencion
            const span = document.getElementById('formaDetencionSelect'),
                label = document.getElementById('formaDetencionLabel');
            switch (data.Forma_Detencion) {
                case 'OPERATIVO':
                    label.innerHTML = 'Operativo:';
                    span.innerHTML = data.ubicacionD[0].Descripcion_Forma_Detencion;
                    break;
                case 'DISPOSITIVO':
                    label.innerHTML = 'Dispositivo';
                    span.innerHTML = data.ubicacionD[0].Descripcion_Forma_Detencion;
                    break;
                case 'AUXILIO':
                    label.innerHTML = 'Auxilio';
                    span.innerHTML = data.ubicacionD[0].Descripcion_Forma_Detencion;
                    break;
                //se agrego el campo default ya que no funciona correctamente el switch de casos
                default:
                    label.innerHTML = '';
                    span.innerHTML = data.ubicacionD[0].Descripcion_Forma_Detencion;
                    break;
            }
            observaciones_detencion.textContent = data.ubicacionD[0].Observaciones
            /* Se comenta esta informacion ya que la informacion de los vehiculos no debe de mostrarse aqui
            Tipo_Situacion.textContent = (data.vehiculos.length > 0) ? (data.vehiculos[0].Tipo_Situacion == 0) ? 'Asegurado' : 'Involucrado' : ''
            Tipo_Vehiculo.textContent = (data.vehiculos.length > 0) ? data.vehiculos[0].Tipo_Vehiculo : 'NA'
            Placa_Vehiculo.textContent = (data.vehiculos.length > 0) ? data.vehiculos[0].Placa_Vehiculo : 'NA'
            Marca.textContent = (data.vehiculos.length > 0) ? data.vehiculos[0].Marca : 'NA'
            Modelo.textContent = (data.vehiculos.length > 0) ? data.vehiculos[0].Modelo : 'NA'
            Color.textContent = (data.vehiculos.length > 0) ? data.vehiculos[0].Color : 'NA'
            Senia_Particular.textContent = (data.vehiculos.length > 0) ? data.vehiculos[0].Senia_Particular : 'NA'
            No_Serie.textContent = (data.vehiculos.length > 0) ? data.vehiculos[0].No_Serie : 'NA'
            Procedencia_Vehiculo.textContent = (data.vehiculos.length > 0) ? data.vehiculos[0].Procedencia_Vehiculo : 'NA'
            Observacion_Vehiculo.textContent = (data.vehiculos.length > 0) ? data.vehiculos[0].Observacion_Vehiculo : 'NA'*/
        }
    })
}

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

        Complexion.textContent = data.Complexion.toUpperCase()
        Estarura.textContent = data.Estatura_cm
        Color_p.textContent = data.Color_Piel.toUpperCase()
        formaCara.textContent = data.Forma_Cara.toUpperCase()
        Pomulos.textContent = data.Pomulos.toUpperCase()
        Cabello.textContent = data.Cabello.toUpperCase()
        colorCabello.textContent = data.Color_Cabello.toUpperCase()
        tamCabello.textContent = data.Tam_Cabello.toUpperCase()
        formaCabello.textContent = data.Forma_Cabello.toUpperCase()
        Frente.textContent = data.Frente.toUpperCase()
        Cejas.textContent = data.Cejas.toUpperCase()
        tipoCejas.textContent = data.Tipo_Cejas.toUpperCase()
        colorOjo.textContent = data.Color_Ojos.toUpperCase()
        tamOjos.textContent = data.Tam_Ojos.toUpperCase()
        formaOjos.textContent = data.Forma_Ojos.toUpperCase()
        Nariz.textContent = data.Nariz.toUpperCase()
        tamBoca.textContent = data.Tam_Boca.toUpperCase()
        Labios.textContent = data.Labios.toUpperCase()
        Menton.textContent = data.Menton.toUpperCase()
        tamOrejas.textContent = data.Tam_Orejas.toUpperCase()
        Lobulos.textContent = data.Lobulos.toUpperCase()
        Barba.textContent = data.Barba.toUpperCase()
        tamBarba.textContent = data.Tam_Barba.toUpperCase()
        colorBarba.textContent = data.Color_Barba.toUpperCase()
        Bigote.textContent = data.Bigote.toUpperCase()
        tamBigote.textContent = data.Tam_Bigote.toUpperCase()
        colorBigote.textContent = data.Color_Bigote.toUpperCase()
        //--se añade esta sentencia
        document.getElementById('infoConocido').style.display = 'block'
      /* Se comento esta informacion ya que se creo una nueva funcion que se
      encargue de recibir los contactos conocidos del detenido  
        if (data.Nombre != null) {

            document.getElementById('infoConocido1').checked = false
            document.getElementById('infoConocido2').checked = true
            document.getElementById('infoConocido').style.display = 'block'

            document.getElementById('parentezco_conocido').textContent = data.Parentesco
            document.getElementById('Nombre_conocido').textContent = data.Nombre
            document.getElementById('apaterno_conocido').textContent = data.Ap_Paterno
            document.getElementById('amaterno_conocido').textContent = data.Ap_Materno
            document.getElementById('telefono_conocido').textContent = data.Telefono
            document.getElementById('edad_conocido').textContent = data.Edad
            document.getElementById('sexo_conocido').textContent = data.Genero

        } else {

            document.getElementById('infoConocido1').checked = true
            document.getElementById('infoConocido2').checked = false
            document.getElementById('infoConocido').style.display = 'none'
        }*/
    })
}
/*Funcion añadida que se encarga de recibir la informacion de los 
contactos conocidos del detenido para leerlos y pasarlos a la funcion que agregara la informacion 
a la tabla*/
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
/*Funcion añadida para añadir los contactos conocidos del detenido
a la tabla de readOnly*/
function insertNewRowContacto(formData){

    const table = document.getElementById('informacionConocidos').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);

    newRow.insertCell(0).innerHTML = formData.parentezco_conocido;
    newRow.insertCell(1).innerHTML = formData.Nombre_conocido;
    newRow.insertCell(2).innerHTML = formData.apaterno_conocido;
    newRow.insertCell(3).innerHTML = formData.amaterno_conocido;
    newRow.insertCell(4).innerHTML = formData.telefono_conocido;
    newRow.insertCell(5).innerHTML = formData.edad_conocido;
    newRow.insertCell(6).innerHTML = formData.sexo_conocido.toUpperCase() === "H" ? "HOMBRE" : "MUJER";

}

function splitDateTime(data) {
    return data.split(" ")
}
