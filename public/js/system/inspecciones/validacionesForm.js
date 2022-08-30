var imagesInspecciones = [];
//get form element
var formInsp = document.getElementById("id_form_insp");
//get result_alert
var result_alert = document.getElementById("result_alert");
/*campos para asignar su respectivo listener*/
var quien_solicita = document.getElementById("id_quien_solicita");
var clave_solicitante = document.getElementById("id_clave_solicitante");
var fecha = document.getElementById("id_fecha");
var hora = document.getElementById("id_hora");

var motivoOtro = document.getElementById("id_motivo_otro");
var motivoRadio1 = document.getElementById('id_motivo_radio_1');
var motivoRadio2 = document.getElementById('id_motivo_radio_2');


var resultado = document.getElementById("id_resultado");

var nombre = document.getElementById("id_nombre");
var ap_P = document.getElementById("id_ap_paterno");
var ap_M = document.getElementById("id_ap_materno");
var alias = document.getElementById("id_alias");

var marca = document.getElementById("id_marca");
var modelo = document.getElementById("id_modelo");
var placas = document.getElementById("id_placas");

var colonia = document.getElementById("id_colonia");
var calle1 = document.getElementById("id_calle_1");
var calle2 = document.getElementById("id_calle_2");
var no_ext = document.getElementById("id_no_ext");
var no_int = document.getElementById("id_no_int");
/*get all error elements*/
var error_inspeccion_a = document.getElementById("error_inspeccion_a");
var error_quien_solicita = document.getElementById("error_quien_solicita");
var error_clave_solicitante = document.getElementById(
    "error_clave_solicitante"
);
var error_fecha = document.getElementById("error_fecha");
var error_hora = document.getElementById("error_hora");
var error_motivo = document.getElementById("error_motivo");
var error_motivo_otro = document.getElementById("error_motivo_otro");
var error_resultado = document.getElementById("error_resultado");

var error_nombre = document.getElementById("error_nombre");
var error_ap_paterno = document.getElementById("error_ap_paterno");
var error_ap_materno = document.getElementById("error_ap_materno");
var error_alias = document.getElementById("error_alias");

var error_marca = document.getElementById("error_marca");
var error_modelo = document.getElementById("error_modelo");
var error_placas = document.getElementById("error_placas");
var error_colocacion = document.getElementById("error_colocacion");

var error_colonia = document.getElementById("error_colonia");
var error_calle_1 = document.getElementById("error_calle_1");
var error_calle_2 = document.getElementById("error_calle_2");
var error_no_ext = document.getElementById("error_no_ext");
var error_no_int = document.getElementById("error_no_int");
var error_coord_x = document.getElementById("error_coord_x");
var error_coord_y = document.getElementById("error_coord_y");

/*Validar el formulario de disctamen*/
async function checkFormInspeccion(e) {
    // console.log("id check form: " + e.target.id);
    let buttonForm = document.getElementById(e.target.id)
    let cancelButton = document.getElementById('id_cancel_button')

    buttonForm.disabled = true
    buttonForm.textContent = 'Guardando...'
    cancelButton.classList.add('mi_hide')


    var myFormData = new FormData(formInsp);
    myFormData.append("enviar_inspeccion", "1");

    var band = []; //banderas success
    /*inician las validaciones campo por campo*/
    var FV = new FormValidator();
    var ind = 0;
    //set rules
    if (e.target.id == "guardar_editar") {
        // si es editar y el id inspeccion no esta asignado se manda a vista principal
        if (
            FV.validate(myFormData.get("Id_Inspeccion"), "required | numeric") != ""
        ) {
            window.location = base_url_js + "Inspecciones";
        }
    }

    band[ind++] = error_quien_solicita.textContent = FV.validate(myFormData.get("Quien_Solicita"), "required | max_length[200]");
    band[ind++] = error_clave_solicitante.textContent = FV.validate(myFormData.get("Clave_Num_Solicitante"), "required | max_length[45]");
    band[ind++] = error_fecha.textContent = FV.validate(myFormData.get("Fecha_Inspeccion"), "required | date");
    band[ind++] = error_hora.textContent = FV.validate(myFormData.get("Hora_Inspeccion"), "required | time");

    band[ind++] = error_motivo.textContent = FV.validate(myFormData.get("Motivo_Radio"), "required");
    if (myFormData.get('Motivo_Radio') == 'OTRO') {
        // console.log("Motivo otro");
        band[ind++] = error_motivo_otro.textContent = FV.validate(myFormData.get("Motivo_Otro"), "required | max_length[1000]");
        myFormData.append('Motivo_Inspeccion', myFormData.get("Motivo_Otro"));
    } else {
        myFormData.append('Motivo_Inspeccion', 'INSPECCIÓN PREVENTIVA');
    }



    band[ind++] = error_resultado.textContent = FV.validate(myFormData.get("Resultado_Inspeccion"), "required | max_length[1000]");
    myFormData.delete("personas"); //se vacía las personas si ya habian existido
    if (myFormData.get("Check_Persona")) {
        if (!(personasArray.length > 0)) {
            band[ind++] = "Error personas array";
            //se muestra alert danger error por si esta activo
            document.getElementById('id_error_p_mode').classList.remove('mi_hide');


        } else {
            //se guardan en el formData las personas si es que hay alguna
            myFormData.append("personas", JSON.stringify(personasArray));
        }
        // band[ind++] = error_nombre.textContent = FV.validate(myFormData.get("Nombre"), "required | max_length[100]");
        // band[ind++] = error_ap_paterno.textContent = FV.validate(myFormData.get("Ap_Paterno"), "required | max_length[100]");
        // band[ind++] = error_ap_materno.textContent = FV.validate(myFormData.get("Ap_Materno"), "required | max_length[100]");
    } else
        band[ind++] = error_inspeccion_a.textContent = FV.validate(myFormData.get("Check_Vehiculo"), "required");

    if (myFormData.get("Check_Vehiculo")) {
        band[ind++] = error_marca.textContent = FV.validate(myFormData.get("Marca"), "required | max_length[450]");
        band[ind++] = error_modelo.textContent = FV.validate(myFormData.get("Modelo"), "required | max_length[450]");
        band[ind++] = error_placas.textContent = FV.validate(myFormData.get("Placas_Vehiculo"), "required | max_length[50]");
        band[ind++] = error_colocacion.textContent = FV.validate(myFormData.get("Colocacion_Placa"), "required | max_length[45]");
    } else
        band[ind++] = error_inspeccion_a.textContent = FV.validate(myFormData.get("Check_Persona"), "required");

    band[ind++] = error_colonia.textContent = await validateColonia()
    band[ind++] = error_calle_1.textContent = await validateCalle(myFormData.get("Calle_1"),1)
    band[ind++] = error_calle_2.textContent = await validateCalle(myFormData.get("Calle_2"),2)
    band[ind++] = error_no_ext.textContent = FV.validate(myFormData.get("No_Ext"), "max_length[45]");
    band[ind++] = error_no_int.textContent = FV.validate(myFormData.get("No_Int"), "max_length[45]");
    band[ind++] = error_coord_x.textContent = FV.validate(myFormData.get("Coordenada_X"), "required | max_length[45]");
    band[ind++] = error_coord_y.textContent = FV.validate(myFormData.get("Coordenada_Y"), "required | max_length[45]");
    //se comprueban todas las validaciones
    var success = true;
    band.forEach((element) => {
        success &= element == "" ? true : false;
    });

    if (success) {
        //si todo es correcto se envía form
        var urlFetch = base_url_js + "Inspecciones";
        myFormData.delete("files[]"); //se vacía los files si ya habian existido
        imagesInspecciones.forEach((element, index, array) => {
            myFormData.append("files[]", element["file"]);
        });


        //se checa que se va a mandar respecto a la URL
        if (e.target.id == "guardar_crear") {
            urlFetch += "/insertInspeccionFetch";
        } else if (e.target.id == "guardar_editar") {
            //si es editar entonces se cargan en el form los img viejos
            urlFetch += "/editarInspeccionFetch";
            myFormData.delete("Old_Ids[]"); //se vacía los files si ya habian existido Old
            myFormData.delete("Old_Ids2[]"); //se vacía los files si ya habian existido Old
            myFormData.delete("Old_Path[]"); //se vacía los files si ya habian existido Old
            myFormData.delete("Old_Path2[]"); //se vacía los files si ya habian existido Old
            imagesOldInspecciones.forEach((element, index, array) => {
                myFormData.append("Old_Ids[]", element["id"]); //se guarda las imgs que quedan por si se borrar una
                myFormData.append("Old_Path[]", element["Path_Imagen"]);
            });
            imagesOldInspecciones2.forEach((element, index, array) => {
                myFormData.append("Old_Ids2[]", element["id"]); //se guarda la copia para comparar
                myFormData.append("Old_Path2[]", element["Path_Imagen"]);
            });
        } else {
            window.location = base_url_js + "Inicio";
        }

        fetch(urlFetch, {
                method: "POST",
                body: myFormData,
            })
            .then((response) => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw "Error en response";
                }
            })
            .then((myJson) => {
                // console.log(myJson);

                if (!(typeof myJson === "string")) {
                    buttonForm.disabled = false
                    buttonForm.textContent = 'Guardar Cambios'
                    cancelButton.classList.remove('mi_hide')
                    //se muestran los errores devueltos
                    error_quien_solicita.textContent = myJson.error_quien_solicita;
                    error_clave_solicitante.textContent = myJson.error_clave_solicitante;
                    error_fecha.textContent = myJson.error_fecha;
                    error_hora.textContent = myJson.error_hora;
                    error_motivo.textContent = myJson.error_motivo;
                    error_resultado.textContent = myJson.error_resultado;
                    error_nombre.textContent = typeof myJson.error_nombre != "undefined" ? myJson.error_nombre : "";
                    error_ap_paterno.textContent = typeof myJson.error_ap_paterno != "undefined" ? myJson.error_ap_paterno : "";
                    error_ap_materno.textContent = typeof myJson.error_ap_materno != "undefined" ? myJson.error_ap_materno : "";
                    error_inspeccion_a.textContent = typeof myJson.error_inspeccion_a != "undefined" ? myJson.error_inspeccion_a : "";
                    error_marca.textContent = typeof myJson.error_marca != "undefined" ? myJson.error_marca : "";
                    error_modelo.textContent = typeof myJson.error_modelo != "undefined" ? myJson.error_modelo : "";
                    error_placas.textContent = typeof myJson.error_placas != "undefined" ? myJson.error_placas : "";
                    error_colocacion.textContent = typeof myJson.error_colocacion != "undefined" ? myJson.error_colocacion : "";
                    error_colonia.textContent = myJson.error_colonia;
                    error_calle_1.textContent = myJson.error_calle_1;
                    error_calle_2.textContent = myJson.error_calle_2;
                    error_no_ext.textContent = myJson.error_no_ext;
                    error_no_int.textContent = myJson.error_no_int;
                    error_coord_x.textContent = myJson.error_coord_x;
                    error_coord_y.textContent = myJson.error_coord_y;
                    //se muestra mensaje de error
                    result_alert.classList.remove("mi_hide");
                    result_alert.firstChild.nextElementSibling.classList.remove(
                        "alert-success"
                    );
                    result_alert.firstChild.nextElementSibling.classList.add(
                        "alert-danger"
                    );
                    result_alert.firstChild.nextElementSibling.textContent =
                        "Error en el formulario. Compruebe que los campos esten llenados correctamente. Nota: asegúrese de no insertar emojis o algun caracter especial en los campos del formulario";
                    window.scroll({
                        top: 120,
                        behavior: "smooth",
                    });
                } else {
                    if (myJson.startsWith("Error")) {
                        buttonForm.disabled = false
                        buttonForm.textContent = 'Guardar Cambios'
                        cancelButton.classList.remove('mi_hide')
                        //error en algo
                        alert(myJson);
                        //se muestra mensaje de error
                        result_alert.classList.remove("mi_hide");
                        result_alert.firstChild.nextElementSibling.classList.remove(
                            "alert-success"
                        );
                        result_alert.firstChild.nextElementSibling.classList.add(
                            "alert-danger"
                        );
                        result_alert.firstChild.nextElementSibling.textContent =
                            "Error en el formulario. Compruebe que los campos esten llenados correctamente. Nota: asegúrese de no insertar emojis o algun caracter especial en los campos del formulario";
                        window.scroll({
                            top: 120,
                            behavior: "smooth",
                        });
                    } else {
                        //todo salio bien
                        result_alert.classList.remove("mi_hide");
                        result_alert.firstChild.nextElementSibling.classList.remove(
                            "alert-danger"
                        );
                        result_alert.firstChild.nextElementSibling.classList.add(
                            "alert-success"
                        );

                        //dependiendo del éxito se m¿pone el mansaje de insertada o actualizada
                        var msj_response = "";
                        if (e.target.id == "guardar_crear") {
                            msj_response = "Inspección insertada exitósamente!";
                        } else {
                            //si es editar entonces se cargan en el form los img viejos
                            msj_response = "Inspección actualizada exitósamente!";
                        }

                        result_alert.firstChild.nextElementSibling.textContent =
                            msj_response;
                        window.scroll({
                            top: 120,
                            behavior: "smooth",
                        });

                        formInsp.reset(); //reiniciamos el form
                        document.getElementById("photos-content-inspecciones").innerHTML = ""; //vaciamos imgs
                        imagesInspecciones = []; //vaciamos array auxiliar para $_FILES
                        personasArray = [];
                        limpiarPersonaCampos();
                        vaciarTablaPersonas();

                        //comprobacion de confirm o no confirm
                        if (e.target.id == "guardar_crear") {
                            var opcion = confirm(
                                "Inspección registrada exitósamente. ¿Desea insertar otra inspección? de otro modo regresará a la vista principal de inspecciones"
                            );
                            if (!opcion) {
                                setInterval(() => {
                                    window.location = base_url_js + "Inspecciones";
                                }, 1000);
                            } else {
                                //si desea insertar otra inspección se redirecciona a la misma vista para evitar que falle en caso de que se deje el navegador activo
                                setInterval(() => {
                                    window.location = base_url_js + "Inspecciones/nuevaInspeccion";
                                }, 500);
                            }
                        } else {
                            //si es editar entonces se redirecciona automáticamente a vista principal
                            document.getElementById("id_inspeccion").value = ""; //limpiar buffer de id inspección
                            window.location.assign(base_url_js + "Inspecciones");
                           /* setInterval(() => {
                                window.location = base_url_js + "Inspecciones";
                            }, 1000);*/
                        }
                    }
                }
            })
            .catch((err) => {
                alert("Error en el formulario. Compruebe que los campos esten llenados correctamente. Nota: asegúrese de no insertar emojis o algun caracter especial en los campos del formulario. Si el problema persiste, comuníquese con el equipo de desarrollo. El inge Juan Daniel");
                console.log("Error catch: " + err);
            });
    } else {
        buttonForm.disabled = false
        buttonForm.textContent = 'Guardar Cambios'
        cancelButton.classList.remove('mi_hide')
        //si no, se muestran errores en pantalla
        result_alert.classList.remove("mi_hide");
        result_alert.firstChild.nextElementSibling.classList.remove(
            "alert-success"
        );
        result_alert.firstChild.nextElementSibling.classList.add("alert-danger");
        result_alert.firstChild.nextElementSibling.textContent =
            "Error en el formulario. Compruebe que los campos esten llenados correctamente.";
        window.scroll({
            top: 120,
            behavior: "smooth",
        });
    }
}

/*LISTENERS para cada input*/
fecha.addEventListener("change", (e) => {
    if (existeFecha(fecha.value)) {
        document.getElementById("error_fecha").textContent = "";
    } else {
        document.getElementById("error_fecha").textContent =
            "Elije una fecha correcta";
    }
});
hora.addEventListener("change", (e) => {
    if (existeHora(hora.value)) {
        document.getElementById("error_hora").textContent = "";
    } else {
        document.getElementById("error_hora").textContent =
            "Elije una hora correcta";
    }
});
//-------------------------------------------------------
quien_solicita.addEventListener("change", (e) => {
    const MAX_LENGTH = 200;
    if (!(quien_solicita.value.trim() !== "")) {
        document.getElementById("error_quien_solicita").textContent =
            "Llene el campo *";
    } else if (!(quien_solicita.value.length <= MAX_LENGTH)) {
        document.getElementById("error_quien_solicita").textContent =
            "Tamaño máximo: " + MAX_LENGTH + " caracteres";
    } else {
        document.getElementById("error_quien_solicita").textContent = "";
    }
});
clave_solicitante.addEventListener("change", (e) => {
    const MAX_LENGTH = 200;
    if (!(clave_solicitante.value.trim() !== "")) {
        document.getElementById("error_clave_solicitante").textContent =
            "Llene el campo *";
    } else if (!(clave_solicitante.value.length <= MAX_LENGTH)) {
        document.getElementById("error_clave_solicitante").textContent =
            "Tamaño máximo: " + MAX_LENGTH + " caracteres";
    } else {
        document.getElementById("error_clave_solicitante").textContent = "";
    }
});
motivoOtro.addEventListener("change", (e) => {
    const MAX_LENGTH = 1000;
    if (!(motivoOtro.value.trim() !== "")) {
        document.getElementById("error_motivo_otro").textContent = "Llene el campo *";
    } else if (!(motivoOtro.value.length <= MAX_LENGTH)) {
        document.getElementById("error_motivo_otro").textContent =
            "Tamaño máximo: " + MAX_LENGTH + " caracteres";
    } else {
        document.getElementById("error_motivo_otro").textContent = "";
    }
});
resultado.addEventListener("change", (e) => {
    const MAX_LENGTH = 1000;
    if (!(resultado.value.trim() !== "")) {
        document.getElementById("error_resultado").textContent = "Llene el campo *";
    } else if (!(resultado.value.length <= MAX_LENGTH)) {
        document.getElementById("error_resultado").textContent =
            "Tamaño máximo: " + MAX_LENGTH + " caracteres";
    } else {
        document.getElementById("error_resultado").textContent = "";
    }
});
//-------------------------------------------------------
nombre.addEventListener("change", (e) => {
    const MAX_LENGTH = 100;
    if (!(nombre.value.trim() !== "")) {
        document.getElementById("error_nombre").textContent = "Llene el campo *";
    } else if (!(nombre.value.length <= MAX_LENGTH)) {
        document.getElementById("error_nombre").textContent =
            "Tamaño máximo: " + MAX_LENGTH + " caracteres";
    } else {
        document.getElementById("error_nombre").textContent = "";
    }
});
ap_P.addEventListener("change", (e) => {
    const MAX_LENGTH = 100;
    if (!(ap_P.value.trim() !== "")) {
        document.getElementById("error_ap_paterno").textContent =
            "Llene el campo *";
    } else if (!(ap_P.value.length <= MAX_LENGTH)) {
        document.getElementById("error_ap_paterno").textContent =
            "Tamaño máximo: " + MAX_LENGTH + " caracteres";
    } else {
        document.getElementById("error_ap_paterno").textContent = "";
    }
});
ap_M.addEventListener("change", (e) => {
    const MAX_LENGTH = 100;
    if (!(ap_M.value.trim() !== "")) {
        document.getElementById("error_ap_materno").textContent =
            "Llene el campo *";
    } else if (!(ap_M.value.length <= MAX_LENGTH)) {
        document.getElementById("error_ap_materno").textContent =
            "Tamaño máximo: " + MAX_LENGTH + " caracteres";
    } else {
        document.getElementById("error_ap_materno").textContent = "";
    }
});
//-------------------------------------------------------
marca.addEventListener("change", (e) => {
    const MAX_LENGTH = 450;
    if (!(marca.value.trim() !== "")) {
        document.getElementById("error_marca").textContent = "Llene el campo *";
    } else if (!(marca.value.length <= MAX_LENGTH)) {
        document.getElementById("error_marca").textContent =
            "Tamaño máximo: " + MAX_LENGTH + " caracteres";
    } else {
        document.getElementById("error_marca").textContent = "";
    }
});
modelo.addEventListener("change", (e) => {
    const MAX_LENGTH = 450;
    if (!(modelo.value.trim() !== "")) {
        document.getElementById("error_modelo").textContent = "Llene el campo *";
    } else if (!(modelo.value.length <= MAX_LENGTH)) {
        document.getElementById("error_modelo").textContent =
            "Tamaño máximo: " + MAX_LENGTH + " caracteres";
    } else {
        document.getElementById("error_modelo").textContent = "";
    }
});
placas.addEventListener("change", (e) => {
    const MAX_LENGTH = 50;
    if (!(placas.value.trim() !== "")) {
        document.getElementById("error_placas").textContent = "Llene el campo *";
    } else if (!(placas.value.length <= MAX_LENGTH)) {
        document.getElementById("error_placas").textContent =
            "Tamaño máximo: " + MAX_LENGTH + " caracteres";
    } else {
        document.getElementById("error_placas").textContent = "";
    }
});

//-------------------------------------------------------
calle1.addEventListener("change", (e) => {
    const MAX_LENGTH = 450;
    if (!(calle1.value.trim() !== "")) {
        document.getElementById("error_calle_1").textContent = "Llene el campo *";
    } else if (!(calle1.value.length <= MAX_LENGTH)) {
        document.getElementById("error_calle_1").textContent =
            "Tamaño máximo: " + MAX_LENGTH + " caracteres";
    } else {
        document.getElementById("error_calle_1").textContent = "";
    }
});
no_ext.addEventListener("change", (e) => {
    const MAX_LENGTH = 45;
    if (!(no_ext.value.trim() !== "")) {
        document.getElementById("error_no_ext").textContent = "Llene el campo *";
    } else if (!(no_ext.value.length <= MAX_LENGTH)) {
        document.getElementById("error_no_ext").textContent =
            "Tamaño máximo: " + MAX_LENGTH + " caracteres";
    } else {
        document.getElementById("error_no_ext").textContent = "";
    }
});
no_int.addEventListener("change", (e) => {
    const MAX_LENGTH = 45;
    if (!(no_int.value.trim() !== "")) {
        document.getElementById("error_no_int").textContent = "Llene el campo *";
    } else if (!(no_int.value.length <= MAX_LENGTH)) {
        document.getElementById("error_no_int").textContent =
            "Tamaño máximo: " + MAX_LENGTH + " caracteres";
    } else {
        document.getElementById("error_no_int").textContent = "";
    }
});
/*RADIO BUTTONS*/
//instancia
var rad_colocacion_placas = document.getElementsByName("Colocacion_Placa");
for (var i = 0; i < rad_colocacion_placas.length; i++) {
    rad_colocacion_placas[i].addEventListener("change", function() {
        document.getElementById("error_colocacion").textContent = "";
    });
}
//motivo
var rad_motivo = document.getElementsByName('Motivo_Radio')
for (var i = 0; i < rad_motivo.length; i++) {
    rad_motivo[i].addEventListener('change', function() {
        document.getElementById('error_motivo').textContent = ''
    });
}


//-----------------------LISTENERS RADIOS-----------------------
//motivo
var motivoPanel = document.getElementById('id_motivo_otro_panel')
motivoRadio1.addEventListener('change', changeMotivoOtro)
motivoRadio2.addEventListener('change', changeMotivoOtro)

function changeMotivoOtro(e) {
    if (e.target.id == 'id_motivo_radio_2') {
        motivoPanel.classList.remove("mi_hide");
        motivoOtro.disabled = false
    } else {
        motivoPanel.classList.add("mi_hide");
        motivoOtro.disabled = true
    }
}

/*valida fecha*/
function existeFecha(fecha) {
    var fechaf = fecha.split("-");
    var d = fechaf[2];
    var m = fechaf[1];
    var y = fechaf[0];
    return (
        m > 0 &&
        m < 13 &&
        y > 0 &&
        y < 32768 &&
        d > 0 &&
        d <= new Date(y, m, 0).getDate()
    );
}
/*valida fecha*/
function existeHora(hora) {
    var horaH = hora.split(":");
    var hrs = horaH[0];
    var mins = horaH[1];
    return hrs >= 0 && hrs <= 23 && mins >= 0 && mins <= 59;
}
/*Funciones añadidas para validar colonia y calles de catalogo*/
const validateColonia = async ()=> {
    if((document.getElementById('id_colonia').value).length > 0){
        var coloniaValida = false;
        coloniasCatalogo = await getAllColonias();
        let inputColoniaValue = createObjectColonia (document.getElementById('id_colonia').value);
        const result = coloniasCatalogo.find( colonia => (colonia.Tipo == inputColoniaValue.Tipo && colonia.Colonia == inputColoniaValue.Colonia) ) // SI ESTO ME REGRESA EL MISMO OBJETO QUIERE DECIR QUE SI LO ENCONTRO EN EL CATALOGO UNDEFINED SI NO
        if (result){
            coloniaValida = true
        }
        if(coloniaValida==false)
            coloniaValida="Ingrese una colonia valida"
        else
            coloniaValida=""
    }
    else{
        coloniaValida="Campo requerido"
    }
    return coloniaValida;
}
const getAllColonias = async () => {
    try {
        const response = await fetch(base_url_js + 'Catalogos/getColonias', {
            method: 'POST'
        });
        const data = await response.json();
        return data;
        
    } catch (error) {
        console.log(error);
    }
} 
const createObjectColonia = (colonia) => {
    separado = colonia.split(' ');
    objetoColonia = {
        Tipo: '',
        Colonia: ''
    }
    if(separado){
        objetoColonia.Tipo = separado[0];
        for(let i = 1; i<separado.length; i++){
            objetoColonia.Colonia += separado[i]+' ';
        }
    }
    objetoColonia.Colonia = objetoColonia.Colonia.trim();
    return objetoColonia
}
const validateCalle = async (calle_buscar,num)=> {
    valor=(num==1) ? document.getElementById('id_calle_1').value: document.getElementById('id_calle_2').value;
    if(valor.length > 0){
        var calleValida = false;
        callesCatalogo = await getAllCalles();
        const result = callesCatalogo.find(element => element.Calle == calle_buscar);
        if (result){
            calleValida = true
        }
        if(calleValida==false)
            calleValida="Ingrese una calle valida"
        else
            calleValida=""
    }
    else{
        if(num==1)
            calleValida="Campo requerido"
        else
            calleValida=""
    }
    return calleValida;
}
const getAllCalles = async () => {
    try {
        const response = await fetch(base_url_js + 'Catalogos/getAllCalles', {
            method: 'POST'
        });
        const data = await response.json();
        return data;
        
    } catch (error) {
        console.log(error);
    }
}