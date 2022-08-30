$(function() {
    $('[data-toggle="tooltip"]').tooltip()
})

var search = document.getElementById('id_search')
var catalogoActual = document.getElementById('catalogoActual')
var search_button = document.getElementById('search_button')

document.getElementById('id_form_catalogo').style.display = 'none'

//cararteres máximos en texarea
const MAXLENGTH = 300
var textareas = document.querySelectorAll('textarea')

textareas.forEach(function(element, index, array) {
    element.maxLength = MAXLENGTH
})

search_button.addEventListener('click', buscarUsuarioCad)

function buscarUsuarioCad(e) {
    var myform = new FormData()
    myform.append("cadena", search.value)
    myform.append("catalogoActual", catalogoActual.value)

    fetch(base_url_js + 'Catalogos/buscarPorCadena', {
            method: 'POST',
            body: myform
        })
        .then(function(response) {
            if (response.ok) {
                return response.json()
            } else {
                throw "Error en la llamada Ajax";
            }
        })
        .then(function(myJson) {
            if (!(typeof(myJson) == 'string')) {
                document.getElementById('id_tbody').innerHTML = myJson.infoTable.body
                document.getElementById('id_thead').innerHTML = myJson.infoTable.header
                document.getElementById('id_pagination').innerHTML = myJson.links
                document.getElementById('id_link_excel').href = myJson.export_links.excel
                document.getElementById('id_link_pdf').href = myJson.export_links.pdf
                document.getElementById('id_total_rows').innerHTML = myJson.total_rows
            } else {
                console.log("myJson: " + myJson)
            }

        })
        .catch(function(error) {
            console.log("Error desde Catch _  " + error)
        })

}

function checarCadena(e) {
    if (search.value == "") {
        buscarUsuarioCad()
    }
}

//function para precargar la información del registro seleccionado y visualizar formulario de edición
function editAction(catalogo, id_reg) {
    console.log("catalogo: " + catalogo + "\n Id: " + id_reg)
    document.getElementById('id_form_catalogo').style.display = 'block'
    document.getElementById('send_button').innerHTML = 'Guardar'
    /*Se comento esta asignacion ya que pone el boton con fondo blanco*/
   // document.getElementById('send_button').style.backgroundColor = 'var(--blue-darken-2)'
    window.scrollTo(0, 50);

    switch (catalogo) {
        case 1:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_tatuaje').value = id_reg
            document.getElementById('id_tipo_tatuaje').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_tipo_tatuaje').focus()
            document.getElementById('id_descripcion').value = t_row.getElementsByTagName('td')[2].innerHTML
            break
        case 2:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_institucion').value = id_reg
            document.getElementById('id_tipo_institucion').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_tipo_institucion').focus()
            break
        case 3:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_medida').value = id_reg
            document.getElementById('id_tipo_medida').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_tipo_medida').focus()
            break
        case 4:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_delito_falta').value = id_reg
            document.getElementById('id_entidad').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_entidad').focus()
            document.getElementById('select_FD').value = t_row.getElementsByTagName('td')[2].innerHTML
            document.getElementById('select_Status').value = (t_row.getElementsByTagName('td')[3].innerHTML == 'Activo') ? 1 : 0
            document.getElementById('id_descripcion').value = t_row.getElementsByTagName('td')[4].innerHTML
            break
        case 5:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_tipo_arma').value = id_reg
            document.getElementById('id_tipo_arma_nombre').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_tipo_arma_nombre').focus()
            break
        case 6:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_grupo').value = id_reg
            document.getElementById('id_nombre_g').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_nombre_g').focus()
            document.getElementById('id_modus_operandi').value = t_row.getElementsByTagName('td')[2].innerHTML
            document.getElementById('id_modo_fuga').value = t_row.getElementsByTagName('td')[3].innerHTML
            document.getElementById('id_descripcion').value = t_row.getElementsByTagName('td')[4].innerHTML
            break
        case 7:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_mf').value = id_reg
            document.getElementById('id_tipo_mf').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_tipo_mf').focus()
            document.getElementById('id_valor_mf').value = t_row.getElementsByTagName('td')[2].innerHTML
            break
        case 8:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_vehiculo_ocra').value = id_reg
            document.getElementById('id_marca').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_marca').focus()
            break
        case 9:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_motocicleta').value = id_reg
            document.getElementById('id_marca').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_marca').focus()
            break
        case 10:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_escolaridad').value = id_reg
            document.getElementById('id_escolaridad_valor').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_escolaridad_valor').focus()
            break
        case 11:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_parentezco').value = id_reg
            document.getElementById('id_parentezco_valor').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_parentezco_valor').focus()
            break
        case 12:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_forma_detencion').value = id_reg
            document.getElementById('id_forma_detencion_valor').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_forma_detencion_valor').focus()
            document.getElementById('id_descripcion').value = t_row.getElementsByTagName('td')[2].innerHTML
            break
        case 13:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_tipo_violencia').value = id_reg
            document.getElementById('id_tipo_violencia_valor').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_tipo_violencia_valor').focus()
            break
        case 14:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_grupo').value = id_reg
            document.getElementById('id_tipo_grupo').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_tipo_grupo').focus()
            document.getElementById('id_valor_grupo').value = t_row.getElementsByTagName('td')[2].innerHTML
            break
        case 15:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_adiccion').value = id_reg
            document.getElementById('id_nombre_adiccion').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_nombre_adiccion').focus()
            break
        case 16:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_tipo_accesorio').value = id_reg
            document.getElementById('id_tipo_accesorio_valor').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_tipo_accesorio_valor').focus()
            break
        case 17:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_tipo_vestimenta').value = id_reg
            document.getElementById('id_tipo_vestimenta_valor').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_tipo_vestimenta_valor').focus()
            break
        case 18:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_zona_sector').value = id_reg
            document.getElementById('id_tipo_grupo').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_tipo_grupo').focus()
            document.getElementById('id_zona_sector_valor').value = t_row.getElementsByTagName('td')[2].innerHTML
            break
        case 19:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_origen_evento').value = id_reg
            document.getElementById('id_origen').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_origen').focus()
            break
        case 20:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_vector').value = id_reg
            document.getElementById('id_vector_i').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_vector_i').focus()
            document.getElementById('id_zona').value = t_row.getElementsByTagName('td')[2].innerHTML
            document.getElementById('id_vector_numero').value = t_row.getElementsByTagName('td')[3].innerHTML
            document.getElementById('id_region').value = t_row.getElementsByTagName('td')[4].innerHTML
            break
        case 21:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_uso_vehiculo').value = id_reg
            document.getElementById('id_uso').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_uso').focus()
            break
        case 22:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_marca_vehiculo').value = id_reg
            document.getElementById('id_marca').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_marca').focus()
            break
        case 23:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_grupo').value = id_reg
            document.getElementById('id_tipo_grupo').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_tipo_grupo').focus()
            document.getElementById('id_valor_grupo').value = t_row.getElementsByTagName('td')[2].innerHTML
            break
        /*Se añaden las dos nuevas opciones para los dos nuevos
        catalogos: tipos y submarcas de vehiculos*/
        case 24:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_tipo_veh').value = id_reg
            document.getElementById('id_tipo_veh_desc').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_tipo_veh_desc').focus()
            break
        case 25:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_submarca_veh').value = id_reg
            document.getElementById('id_submarca_desc').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('id_submarca_desc').focus()
            break
        //Se añade el catalogo para estados, municipios, calles, colonias, animales, tipo_placanip, cuervo personas y vehiculos
        case 26:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('Id_categoria').value = id_reg
            document.getElementById('Id_categoria_desc').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('Id_categoria_desc').focus()
            break
        case 27:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('Id_Tipo_Animal').value = id_reg
            document.getElementById('Descripcion').value = t_row.getElementsByTagName('td')[1].innerHTML
            break
        case 28:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('Id_colonia').value = id_reg
            document.getElementById('tipo').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('colonia').value = t_row.getElementsByTagName('td')[2].innerHTML
            break
        case 29:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('Id_calle').value = id_reg
            document.getElementById('Id_calle_desc').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('Id_calle_desc').focus()
            break
        case 30:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('Id_estado').value = id_reg
            document.getElementById('Estado').value = t_row.getElementsByTagName('td')[1].innerHTML
            break
        case 31:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('Id_municipio').value = id_reg
            document.getElementById('Id_municipio_desc').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('Id_municipio_m').value = t_row.getElementsByTagName('td')[2].innerHTML
            document.getElementById('Id_municipio_desc').focus()
            break
        case 32:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_dato').value = id_reg
            document.getElementById('Nombre').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('Ap_Paterno').value = t_row.getElementsByTagName('td')[2].innerHTML
            document.getElementById('Ap_Materno').value = t_row.getElementsByTagName('td')[3].innerHTML
            break
        case 33:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('id_dato').value = id_reg
            document.getElementById('placa').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('nip').value = t_row.getElementsByTagName('td')[2].innerHTML
            break
        case 34:
            var t_row = document.getElementById('tr' + id_reg)
            document.getElementById('Id_cp').value = id_reg
            document.getElementById('Codigo_postal').value = t_row.getElementsByTagName('td')[1].innerHTML
            document.getElementById('Nombre').value = t_row.getElementsByTagName('td')[2].innerHTML
            break
    }

}

//funcion para ocultar formulario de edición o creación
function hideForm() {
    document.getElementById('id_form_catalogo').style.display = 'none'
}

//funcion para vaciar los campos correspondientes (si no lo estan) y mostrar el form de cada catálogo
function addAction(catalogo) {
    console.log("catalogo: " + catalogo)
    document.getElementById('id_form_catalogo').style.display = 'block'
    document.getElementById('send_button').innerHTML = 'Crear'
    /*Se comento esta asignacion ya que pone el boton con fondo blanco*/
   // document.getElementById('send_button').style.backgroundColor = 'var(--green-darken-2)'
    window.scrollTo(0, 50);

    switch (catalogo) {
        case 1:
            document.getElementById('id_tatuaje').value = ''
            document.getElementById('id_tipo_tatuaje').value = ''
            document.getElementById('id_descripcion').value = ''
            document.getElementById('id_tipo_tatuaje').focus()
            break
        case 2:
            document.getElementById('id_institucion').value = ''
            document.getElementById('id_tipo_institucion').value = ''
            document.getElementById('id_tipo_institucion').focus()
            break
        case 3:
            document.getElementById('id_medida').value = ''
            document.getElementById('id_tipo_medida').value = ''
            document.getElementById('id_tipo_medida').focus()
            break
        case 4:
            document.getElementById('id_delito_falta').value = ''
            document.getElementById('id_entidad').value = ''
            document.getElementById('select_FD').value = 'F'
            document.getElementById('select_Status').value = '0'
            document.getElementById('id_descripcion').value = ''
            document.getElementById('id_entidad').focus()
            break
        case 5:
            document.getElementById('id_tipo_arma').value = ''
            document.getElementById('id_tipo_arma_nombre').value = ''
            document.getElementById('id_tipo_arma_nombre').focus()
            break
        case 6:
            document.getElementById('id_grupo').value = ''
            document.getElementById('id_nombre_g').value = ''
            document.getElementById('id_modus_operandi').value = ''
            document.getElementById('id_modo_fuga').value = ''
            document.getElementById('id_descripcion').value = ''
            document.getElementById('id_nombre_g').focus()
            break
        case 7:
            document.getElementById('id_mf').value = ''
            document.getElementById('id_tipo_mf').value = ''
            document.getElementById('id_valor_mf').value = ''
            document.getElementById('id_tipo_mf').focus()
            break
        case 8:
            document.getElementById('id_vehiculo_ocra').value = ''
            document.getElementById('id_marca').value = ''
            document.getElementById('id_marca').focus()
            break
        case 9:
            document.getElementById('id_motocicleta').value = ''
            document.getElementById('id_marca').value = ''
            document.getElementById('id_marca').focus()
            break
        case 10:
            document.getElementById('id_escolaridad').value = ''
            document.getElementById('id_escolaridad_valor').value = ''
            document.getElementById('id_escolaridad_valor').focus()
            break
        case 11:
            document.getElementById('id_parentezco').value = ''
            document.getElementById('id_parentezco_valor').value = ''
            document.getElementById('id_parentezco_valor').focus()
            break
        case 12:
            document.getElementById('id_forma_detencion').value = ''
            document.getElementById('id_forma_detencion_valor').value = ''
            document.getElementById('id_descripcion').value = ''
            document.getElementById('id_forma_detencion_valor').focus()
            break
        case 13:
            document.getElementById('id_tipo_violencia').value = ''
            document.getElementById('id_tipo_violencia_valor').value = ''
            document.getElementById('id_tipo_violencia_valor').focus()
            break
        case 14:
            document.getElementById('id_grupo').value = ''
            document.getElementById('id_tipo_grupo').value = ''
            document.getElementById('id_valor_grupo').value = ''
            document.getElementById('id_tipo_grupo').focus()
            break
        case 15:
            document.getElementById('id_adiccion').value = ''
            document.getElementById('id_nombre_adiccion').value = ''
            document.getElementById('id_nombre_adiccion').focus()
            break
        case 16:
            document.getElementById('id_tipo_accesorio').value = ''
            document.getElementById('id_tipo_accesorio_valor').value = ''
            document.getElementById('id_tipo_accesorio_valor').focus()
            break
        case 17:
            document.getElementById('id_tipo_vestimenta').value = ''
            document.getElementById('id_tipo_vestimenta_valor').value = ''
            document.getElementById('id_tipo_vestimenta_valor').focus()
            break
        case 18:
            document.getElementById('id_zona_sector').value = ''
            document.getElementById('id_tipo_grupo').value = ''
            document.getElementById('id_tipo_grupo').focus()
            document.getElementById('id_zona_sector_valor').value = ''
            break
        case 19:
            document.getElementById('id_origen_evento').value = ''
            document.getElementById('id_origen').value = ''
            document.getElementById('id_origen').focus()
            break
        case 20:
            document.getElementById('id_vector').value = ''
            document.getElementById('id_vector_i').value = ''
            document.getElementById('id_zona').value = ''
            document.getElementById('id_vector_numero').value = ''
            document.getElementById('id_region').value = ''
            document.getElementById('id_vector_i').focus()
            break
        case 21:
            document.getElementById('id_uso_vehiculo').value = ''
            document.getElementById('id_uso').value = ''
            document.getElementById('id_uso').focus()
            break
        case 22:
            document.getElementById('id_marca_vehiculo').value = ''
            document.getElementById('id_marca').value = ''
            document.getElementById('id_marca').focus()
            break
        case 23:
            document.getElementById('id_grupo').value = ''
            document.getElementById('id_tipo_grupo').value = ''
            document.getElementById('id_valor_grupo').value = ''
            document.getElementById('id_tipo_grupo').focus()
            break
        /*Se añade el reset para los elementos
        de editar/crear para las dos nuevos catalogos:
        tipo y submarca de vehiculos*/
        case 24:
            document.getElementById('id_tipo_veh').value = ''
            document.getElementById('id_tipo_veh_desc').value = ''
            document.getElementById('id_tipo_veh_desc').focus()
            break
        case 25:
            document.getElementById('id_submarca_veh').value = ''
            document.getElementById('id_submarca_desc').value = ''
            document.getElementById('id_submarca_desc').focus()
            break
        //Se añade el catalogo para estados, municipios, calles, colonias, animales, tipo_placanip, cuervo personas y vehiculos
        case 26:
            document.getElementById('Id_categoria').value = ''
            document.getElementById('Id_categoria_desc').value = ''
            document.getElementById('Id_categoria_desc').focus()
            break
        case 27:
            document.getElementById('Id_Tipo_Animal').value = ''
            document.getElementById('Descripcion').value = ''
            document.getElementById('Descripcion').focus()
            break 
        case 28:
            document.getElementById('Id_colonia').value = ''
            document.getElementById('tipo').value = ''
            document.getElementById('colonia').value = ''
            document.getElementById('colonia').focus()
            break    
        case 29:
            document.getElementById('Id_calle').value = ''
            document.getElementById('Id_calle_desc').value = ''
            document.getElementById('Id_calle_desc').focus()
            break   
        case 30:
            document.getElementById('Id_estado').value = ''
            document.getElementById('Estado').value = ''
            document.getElementById('Estado').focus()
            break
        case 31:
            document.getElementById('Id_municipio').value = ''
            document.getElementById('Id_municipio_desc').value = ''
            document.getElementById('Id_municipio_m').value = ''
            document.getElementById('Id_municipio_desc').focus()
            break
        case 32:
            document.getElementById('id_dato').value = ''
            document.getElementById('Nombre').value = ''
            document.getElementById('Nombre').focus()
            document.getElementById('Ap_Paterno').value = ''
            document.getElementById('Ap_Materno').value = ''
            break
        case 33:
            document.getElementById('id_dato').value = ''
            document.getElementById('placa').value = ''
            document.getElementById('placa').focus()
            document.getElementById('nip').value = ''
            break
        case 34:
            document.getElementById('Id_cp').value = ''
            document.getElementById('Codigo_postal').value = ''
            document.getElementById('Nombre').value = ''
            document.getElementById('Codigo_postal').focus()
            break
    }
}

function deleteAction(catalogo, id_reg) {
    console.log("catalogo: " + catalogo + "\n Id: " + id_reg)
    const confirmaDelete = confirm("¿Estás seguro de borrar este registro permanéntemente?")

    if (confirmaDelete) {
        var myForm = new FormData()
            //catálogo que será afectado por medio del form
        myForm.append('catalogo', catalogo)
            //acción del fetch (insertar o actualizar)
        myForm.append('Id_Reg', id_reg)
            //catálogo que será afectado por medio del form
        myForm.append('deletePostForm', 1)

        fetch(base_url_js + 'Catalogos/deleteFormFetch', {
                method: 'POST',
                body: myForm
            })
            .then(function(response) {
                if (response.ok) {
                    return response.json()
                } else {
                    throw "Error en la llamada Ajax";
                }
            })
            .then(function(myJson) {
                console.log(myJson)
                if (myJson == 'Success') {
                    alert("El registro ha sido borrado!")
                    document.location.reload()
                } else {
                    alert(myJson)
                }
            })
            .catch(function(error) {
                console.log("Error desde Catch _  " + error)
            })
    }
}

//función para enviar el formulario, comprobar si se trata de insert or update y comprobar todo el llenado correcto del mismo
async function sendFormAction(catalogo) {
    switch (catalogo) {
        case 1:
            //form inputs charge
            var id_tatuaje = document.getElementById('id_tatuaje')
            var tipo_tatuaje = document.getElementById('id_tipo_tatuaje')
            var descripcion = document.getElementById('id_descripcion')

            if (id_tatuaje.value == '') { // se trata de insert
                //validaciones
                if (tipo_tatuaje.value.trim() != '' && descripcion.value.trim() != '' && descripcion.value.length <= MAXLENGTH) {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_tatuaje.value.trim() != '' && tipo_tatuaje.value.trim() != '' && descripcion.value.trim() != '' && descripcion.value.length <= MAXLENGTH) {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                }
            }
            break
        case 2:
            var id_institucion = document.getElementById('id_institucion')
            var tipo_institucion = document.getElementById('id_tipo_institucion')
            if (id_institucion.value == '') { // se trata de insert
                //validaciones
                if (tipo_institucion.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_institucion.value.trim() != '' && tipo_institucion.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form amix")
            }
            break
        case 3:
            var id_medida = document.getElementById('id_medida')
            var tipo_medida = document.getElementById('id_tipo_medida')
            if (id_medida.value == '') { // se trata de insert
                //validaciones
                if (tipo_medida.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_medida.value.trim() != '' && tipo_medida.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                }
            }
            break
        case 4:
            var id_delito_falta = document.getElementById('id_delito_falta')
            var entidad = document.getElementById('id_entidad')
            var select_FD = document.getElementById('select_FD')
            var select_Status = document.getElementById('select_Status')
            var descripcion = document.getElementById('id_descripcion')
            if (id_delito_falta.value == '') { // se trata de insert
                //validaciones
                if (entidad.value.trim() != '' && (select_FD.value.includes('F') || select_FD.value.includes('D')) && (select_Status.value.includes('1') || select_Status.value.includes('0')) &&
                    descripcion.value.trim() != '' && descripcion.value.length <= MAXLENGTH) {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_delito_falta.value.trim() != '' && entidad.value.trim() != '' && (select_FD.value.includes('F') || select_FD.value.includes('D')) && (select_Status.value.includes('1') || select_Status.value.includes('0')) &&
                    descripcion.value.trim() != '' && descripcion.value.length <= MAXLENGTH) {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                }
            }
            break
        case 5:
            var id_tipo_arma = document.getElementById('id_tipo_arma')
            var tipo_arma = document.getElementById('id_tipo_arma_nombre')
            if (id_tipo_arma.value == '') { // se trata de insert
                //validaciones
                if (tipo_arma.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_tipo_arma.value.trim() != '' && tipo_arma.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                }
            }
            break
        case 6:
            var id_grupo = document.getElementById('id_grupo')
            var nombre_g = document.getElementById('id_nombre_g')
            var modus_operandi = document.getElementById('id_modus_operandi')
            var modo_fuga = document.getElementById('id_modo_fuga')
            var descripcion = document.getElementById('id_descripcion')
            if (id_grupo.value == '') { // se trata de insert
                //validaciones
                if (nombre_g.value.trim() != '' && modus_operandi.value.trim() != '' && modo_fuga.value.trim() != '' &&
                    descripcion.value.trim() != '' && descripcion.value.length <= MAXLENGTH) {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_grupo.value.trim() != '' && nombre_g.value.trim() != '' && modus_operandi.value.trim() != '' && modo_fuga.value.trim() != '' &&
                    descripcion.value.trim() != '' && descripcion.value.length <= MAXLENGTH) {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                }
            }
            break
        case 7:
            //form inputs charge
            var id_mf = document.getElementById('id_mf')
            var tipo_mf = document.getElementById('id_tipo_mf')
            var valor_mf = document.getElementById('id_valor_mf')

            if (id_mf.value == '') { // se trata de insert
                //validaciones
                if (tipo_mf.value.trim() != '' && valor_mf.value.trim() != '' && valor_mf.value.length <= MAXLENGTH) {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_mf.value.trim() != '' && tipo_mf.value.trim() != '' && valor_mf.value.trim() != '' && valor_mf.value.length <= MAXLENGTH) {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                }
            }
            break
        case 8:
            var id_vehiculo_ocra = document.getElementById('id_vehiculo_ocra')
            var marca = document.getElementById('id_marca')
            if (id_vehiculo_ocra.value == '') { // se trata de insert
                //validaciones
                if (marca.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_vehiculo_ocra.value.trim() != '' && marca.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                }
            }
            break
        case 9:
            var id_motocicleta = document.getElementById('id_motocicleta')
            var marca = document.getElementById('id_marca')
            if (id_motocicleta.value == '') { // se trata de insert
                //validaciones
                if (marca.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_motocicleta.value.trim() != '' && marca.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                }
            }
            break
        case 10:
            var id_escolaridad = document.getElementById('id_escolaridad')
            var escolaridad = document.getElementById('id_escolaridad_valor')
            if (id_escolaridad.value == '') { // se trata de insert
                //validaciones
                if (escolaridad.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_escolaridad.value.trim() != '' && escolaridad.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form amix")
            }
            break
        case 11:
            var id_parentezco = document.getElementById('id_parentezco')
            var parentezco = document.getElementById('id_parentezco_valor')
            if (id_parentezco.value == '') { // se trata de insert
                //validaciones
                if (parentezco.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_parentezco.value.trim() != '' && parentezco.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form amix")
            }
            break
        case 12:
            var id_forma_detencion = document.getElementById('id_forma_detencion')
            var forma_detencion = document.getElementById('id_forma_detencion_valor')
            var descripcion = document.getElementById('id_descripcion')
            if (id_forma_detencion.value == '') { // se trata de insert
                //validaciones
                if (forma_detencion.value.trim() != '' && descripcion.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_forma_detencion.value.trim() != '' && forma_detencion.value.trim() != '' && descripcion.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form amix")
            }
            break
        case 13:
            var id_tipo_violencia = document.getElementById('id_tipo_violencia')
            var tipo_violencia = document.getElementById('id_tipo_violencia_valor')
            if (id_tipo_violencia.value == '') { // se trata de insert
                //validaciones
                if (tipo_violencia.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_tipo_violencia.value.trim() != '' && tipo_violencia.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form amix")
            }
            break
        case 14:
            //form inputs charge
            var id_grupo = document.getElementById('id_grupo')
            var tipo_grupo = document.getElementById('id_tipo_grupo')
            var valor_grupo = document.getElementById('id_valor_grupo')

            if (id_grupo.value == '') { // se trata de insert
                //validaciones
                if (tipo_grupo.value.trim() != '' && valor_grupo.value.trim() != '' && valor_grupo.value.length <= MAXLENGTH) {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_grupo.value.trim() != '' && tipo_grupo.value.trim() != '' && valor_grupo.value.trim() != '' && valor_grupo.value.length <= MAXLENGTH) {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                }
            }
            break
        case 15:
            var id_adiccion = document.getElementById('id_adiccion')
            var nombre_adiccion = document.getElementById('id_nombre_adiccion')
            if (id_adiccion.value == '') { // se trata de insert
                //validaciones
                if (nombre_adiccion.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_adiccion.value.trim() != '' && nombre_adiccion.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form amix")
            }
            break
        case 16:
            var id_tipo_accesorio = document.getElementById('id_tipo_accesorio')
            var tipo_accesorio = document.getElementById('id_tipo_accesorio_valor')
            if (id_tipo_accesorio.value == '') { // se trata de insert
                //validaciones
                if (tipo_accesorio.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_tipo_accesorio.value.trim() != '' && tipo_accesorio.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form amix")
            }
            break
        case 17:
            var id_tipo_vestimenta = document.getElementById('id_tipo_vestimenta')
            var tipo_vestimenta = document.getElementById('id_tipo_vestimenta_valor')
            if (id_tipo_vestimenta.value == '') { // se trata de insert
                //validaciones
                if (tipo_vestimenta.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_tipo_vestimenta.value.trim() != '' && tipo_vestimenta.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form amix")
            }
            break
        case 18:
            //form inputs charge
            var id_zona_sector = document.getElementById('id_zona_sector')
            var tipo_grupo = document.getElementById('id_tipo_grupo')
            var zona_sector_valor = document.getElementById('id_zona_sector_valor')

            if (id_zona_sector.value == '') { // se trata de insert
                //validaciones
                if (tipo_grupo.value.trim() != '' && zona_sector_valor.value.trim() != '' && zona_sector_valor.value.length <= MAXLENGTH) {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_zona_sector.value.trim() != '' && tipo_grupo.value.trim() != '' && zona_sector_valor.value.trim() != '' && zona_sector_valor.value.length <= MAXLENGTH) {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                }
            }
            break
        case 19:
            var id_origen_evento = document.getElementById('id_origen_evento')
            var origen = document.getElementById('id_origen')
            if (id_origen_evento.value == '') { // se trata de insert
                //validaciones
                if (origen.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_origen_evento.value.trim() != '' && origen.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form mano(a)")
            }
            break
        case 20:
            var id_vector = document.getElementById('id_vector')
            var id_vector_in = document.getElementById('id_vector_i')
            var id_zona = document.getElementById('id_zona')
            var id_vector_numero = document.getElementById('id_vector_numero')
            var id_region = document.getElementById('id_region')
            if (id_vector.value == '') { // se trata de insert
                //validaciones
                if (id_vector_in.value.trim() != '' && id_zona.value.trim() != '' && id_vector_numero.value.trim() != '' &&
                    id_region.value.trim() != '' && id_region.value.length <= MAXLENGTH) {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_vector.value.trim() != '' && id_vector_in.value.trim() != '' && id_zona.value.trim() != '' && id_vector_numero.value.trim() != '' &&
                    id_region.value.trim() != '' && id_region.value.length <= MAXLENGTH) {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                }
            }
            break
        case 21:
            var id_uso_vehiculo = document.getElementById('id_uso_vehiculo')
            var uso = document.getElementById('id_uso')
            if (id_uso_vehiculo.value == '') { // se trata de insert
                //validaciones
                if (uso.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_uso_vehiculo.value.trim() != '' && uso.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form mano(a)")
            }
            break
        case 22:
            var id_marca_vehiculo = document.getElementById('id_marca_vehiculo')
            var marca = document.getElementById('id_marca')
            if (id_marca_vehiculo.value == '') { // se trata de insert
                //validaciones
                if (marca.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_marca_vehiculo.value.trim() != '' && marca.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form mano(a)")
            }
            break
        case 23:
            //form inputs charge
            var id_grupo = document.getElementById('id_grupo')
            var tipo_grupo = document.getElementById('id_tipo_grupo')
            var valor_grupo = document.getElementById('id_valor_grupo')

            if (id_grupo.value == '') { // se trata de insert
                //validaciones
                if (tipo_grupo.value.trim() != '' && valor_grupo.value.trim() != '' && valor_grupo.value.length <= MAXLENGTH) {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_grupo.value.trim() != '' && tipo_grupo.value.trim() != '' && valor_grupo.value.trim() != '' && valor_grupo.value.length <= MAXLENGTH) {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                }
            }
            break
        /*Se añaden el envio por fetch para editar/crear elementos para los dos nuevos
        catalagoso: tipos y submarcas de vehiculos*/
        case 24:
            var id_tipo_veh = document.getElementById('id_tipo_veh')
            var id_tipo_veh_desc = document.getElementById('id_tipo_veh_desc')
            if (id_tipo_veh.value == '') { // se trata de insert
                //validaciones
                if (id_tipo_veh_desc.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_tipo_veh.value.trim() != '' && id_tipo_veh_desc.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form amix")
            }
            break
        case 25:
            var id_submarca_veh = document.getElementById('id_submarca_veh')
            var id_submarca_desc = document.getElementById('id_submarca_desc')
            if (id_submarca_veh.value == '') { // se trata de insert
                //validaciones
                if (id_submarca_desc.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (id_submarca_veh.value.trim() != '' && id_submarca_desc.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form amix")
            }
            break

        //Se añade el catalogo para estados, municipios, calles, colonias, animales, tipo_placanip, cuervo personas y vehiculos
        case 26:
            var Id_categoria = document.getElementById('Id_categoria')
            var Id_categoria_desc = document.getElementById('Id_categoria_desc')
            if (Id_categoria.value == '') { // se trata de insert
                //validaciones
                if (Id_categoria_desc.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (Id_categoria.value.trim() != '' && Id_categoria_desc.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form amix")
            }
            break
        case 27:
            var Id_Tipo_Animal = document.getElementById('Id_Tipo_Animal')
            var Descripcion = document.getElementById('Descripcion')
            if (Id_Tipo_Animal.value == '') { // se trata de insert
                //validaciones
                if (Descripcion.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (Id_Tipo_Animal.value.trim() != '' && Descripcion.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form amix")
            }
            break
        case 28:
            var Id_colonia = document.getElementById('Id_colonia')
            var tipo = document.getElementById('tipo')
            var colonia = document.getElementById('colonia')
            if (Id_colonia.value == '') { // se trata de insert
                //validaciones
                if (tipo.value.trim() != '' && colonia.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (Id_colonia.value.trim() != '' && tipo.value.trim() != '' && colonia.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form amix")
            }
            break
        case 29:
            var Id_calle = document.getElementById('Id_calle')
            var Id_calle_desc = document.getElementById('Id_calle_desc')
            if (Id_calle.value == '') { // se trata de insert
                //validaciones
                if (Id_calle_desc.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (Id_calle.value.trim() != '' && Id_calle_desc.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form amix")
            }
            break
        case 30:
            var Id_estado = document.getElementById('Id_estado')
            var Estado = document.getElementById('Estado')
            if (Id_estado.value == '') { // se trata de insert
                //validaciones
                if (Estado.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (Id_estado.value.trim() != '' && Estado.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form amix")
            }
            break
        case 31:
            var Id_municipio = document.getElementById('Id_municipio')
            var Id_municipio_desc = document.getElementById('Id_municipio_desc')
            var Id_municipio_m = document.getElementById('Id_municipio_m')
            
            if (Id_municipio.value == '') { // se trata de insert
                //validaciones
                if (Id_municipio_desc.value.trim() != '' && Id_municipio_m.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (Id_municipio.value.trim() != '' && Id_municipio_desc.value.trim() != '' && Id_municipio_m.value.trim() != '' ) {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form amix")
            }
            break
        case 32:
            var id_dato = document.getElementById('id_dato')
            var Nombre = document.getElementById('Nombre')
            var Ap_Paterno = document.getElementById('Ap_Paterno')
            var Ap_Materno = document.getElementById('Ap_Materno')

            //console.log(id_dato,Nombre,Ap_Paterno,Ap_Materno);

            if (id_dato.value == '') { // se trata de insert
                //validaciones

                if ( Nombre.value.trim() != '' && Nombre.value.length <= MAXLENGTH && Ap_Paterno.value.length <= MAXLENGTH && Ap_Materno.value.length <= MAXLENGTH) {
                    let datavalid = await validarPersona(Nombre.value.trim(),Ap_Paterno.value.trim(),Ap_Materno.value.trim())
                    if(datavalid.valor){
                        document.getElementById("errorcombinado1").innerHTML =""
                        document.getElementById("errorcombinado2").innerHTML =``

                        console.log("form valido, se envia form por fetch")
                        fetchFormCatalogo(catalogo, '1')
                    }else{
                        document.getElementById("errorcombinado1").innerHTML ="Persona ya registrada"
                        document.getElementById("errorcombinado2").innerHTML =`Registro ${datavalid.id_dato}`
                    }
                }
            } else { // se trata de update
                let datavalid = await validarPersona(Nombre.value.trim(),Ap_Paterno.value.trim(),Ap_Materno.value.trim())
                if(datavalid.valor){

                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                }
            }
            break
        case 33:
            console.log('ento a caso 33')
            var id_dato = document.getElementById('id_dato')
            var placa= document.getElementById('placa')
            var nip = document.getElementById('nip')

            //console.log(id_dato,placa,nip);
            if (id_dato.value == '') { // se trata de insert
                //validaciones
                placalimpia=placa.value.replace(/[^a-z0-9]/gi,'')
                placa.value = placalimpia;
                if ( placa.value.trim() != '' && placa.value.length <= MAXLENGTH && nip.value.length <= MAXLENGTH ) {
                    let datavalid = await validarPlacaNip(placa.value.trim(),nip.value.trim())
                    //console.log(datavalid)
                    if(datavalid.valor){
                        document.getElementById("errorcombinado1").innerHTML =""
                        document.getElementById("errorcombinado2").innerHTML =``
                        //console.log("form valido, se envia form por fetch")
                        fetchFormCatalogo(catalogo, '1')
                    }else{
                        document.getElementById("errorcombinado1").innerHTML ="Placa y NIV ya registrados"
                        document.getElementById("errorcombinado2").innerHTML =`Registro ${datavalid.id_dato}`
                    }
                }
            } else { // se trata de update
                if (id_dato.value.trim() != '' && placa.value.trim() != '' && placa.value.length <= MAXLENGTH && nip.value.trim() != '' && nip.value.length <= MAXLENGTH ) {
                    let datavalid = await validarPlacaNip(placa.value.trim(),nip.value.trim())
                    //console.log(datavalid)
                    if(datavalid.valor){

                        //console.log("form valido, se envia form por fetch")
                        fetchFormCatalogo(catalogo, '2')
                    }
                }
            }
            break
        case 34:
            var Id_cp = document.getElementById('Id_cp')
            var Codigo_postal = document.getElementById('Codigo_postal')
            var Nombre = document.getElementById('Nombre')           
            if (Id_cp.value == '') { // se trata de insert
                //validaciones
                if (Codigo_postal.value.trim() != '' && Nombre.value.trim() != '') {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '1')
                }
            } else { // se trata de update
                if (Id_cp.value.trim() != '' && Codigo_postal.value.trim() != '' && Nombre.value.trim() != '' ) {
                    console.log("form valido, se envia form por fetch")
                    fetchFormCatalogo(catalogo, '2')
                } else console.log("Error en el form amix")
            }
            break
    }
}

function fetchFormCatalogo(catalogo, action) { //action: 1 - insertar,  2 - actualizar
    var myForm = new FormData()
        //acción del fetch (insertar o actualizar)
    myForm.append('action', action)
        //catálogo que será afectado por medio del form
    myForm.append('catalogo', catalogo)
        //catálogo que será afectado por medio del form
    myForm.append('postForm', 1)

    switch (catalogo) { //apendizar todos los campos correspondientes conforme al cátolo afectado
        case 1:
            myForm.append('Id_Tatuaje', document.getElementById('id_tatuaje').value)
            myForm.append('Tipo_Tatuaje', document.getElementById('id_tipo_tatuaje').value)
            myForm.append('Descripcion', document.getElementById('id_descripcion').value)
            break
        case 2:
            myForm.append('Id_Institucion', document.getElementById('id_institucion').value)
            myForm.append('Tipo_Institucion', document.getElementById('id_tipo_institucion').value)
            break
        case 3:
            myForm.append('Id_Medida', document.getElementById('id_medida').value)
            myForm.append('Tipo_Medida', document.getElementById('id_tipo_medida').value)
            break
        case 4:
            myForm.append('Id_Falta_Delito', document.getElementById('id_delito_falta').value)
            myForm.append('Entidad', document.getElementById('id_entidad').value)
            myForm.append('Falta_Delito', document.getElementById('select_FD').value)
            myForm.append('Status', document.getElementById('select_Status').value)
            myForm.append('Descripcion', document.getElementById('id_descripcion').value)
            break
        case 5:
            myForm.append('Id_Tipo_Arma', document.getElementById('id_tipo_arma').value)
            myForm.append('Tipo_Arma', document.getElementById('id_tipo_arma_nombre').value)
            break
        case 6:
            myForm.append('Id_Grupo', document.getElementById('id_grupo').value)
            myForm.append('Nombre_Grupo', document.getElementById('id_nombre_g').value)
            myForm.append('Modus_Operandi', document.getElementById('id_modus_operandi').value)
            myForm.append('Modo_Fuga', document.getElementById('id_modo_fuga').value)
            myForm.append('Descripcion', document.getElementById('id_descripcion').value)
            break
        case 7:
            myForm.append('Id_MF', document.getElementById('id_mf').value)
            myForm.append('Tipo_MF', document.getElementById('id_tipo_mf').value)
            myForm.append('Valor_MF', document.getElementById('id_valor_mf').value)
            break
        case 8:
            myForm.append('Id_Vehiculo_OCRA', document.getElementById('id_vehiculo_ocra').value)
            myForm.append('Marca', document.getElementById('id_marca').value)
            break
        case 9:
            myForm.append('Id_Motocicleta', document.getElementById('id_motocicleta').value)
            myForm.append('Marca', document.getElementById('id_marca').value)
            break
        case 10:
            myForm.append('Id_Escolaridad', document.getElementById('id_escolaridad').value)
            myForm.append('Escolaridad', document.getElementById('id_escolaridad_valor').value)
            break
        case 11:
            myForm.append('Id_Parentezco', document.getElementById('id_parentezco').value)
            myForm.append('Parentezco', document.getElementById('id_parentezco_valor').value)
            break
        case 12:
            myForm.append('Id_Forma_Detencion', document.getElementById('id_forma_detencion').value)
            myForm.append('Forma_Detencion', document.getElementById('id_forma_detencion_valor').value)
            myForm.append('Descripcion', document.getElementById('id_descripcion').value)
            break
        case 13:
            myForm.append('Id_Tipo_Violencia', document.getElementById('id_tipo_violencia').value)
            myForm.append('Tipo_Violencia', document.getElementById('id_tipo_violencia_valor').value)
            break
        case 14:
            myForm.append('Id_Grupo', document.getElementById('id_grupo').value)
            myForm.append('Tipo_Grupo', document.getElementById('id_tipo_grupo').value)
            myForm.append('Valor_Grupo', document.getElementById('id_valor_grupo').value)
            break
        case 15:
            myForm.append('Id_Adiccion', document.getElementById('id_adiccion').value)
            myForm.append('Nombre_Adiccion', document.getElementById('id_nombre_adiccion').value)
            break
        case 16:
            myForm.append('Id_Tipo_Accesorio', document.getElementById('id_tipo_accesorio').value)
            myForm.append('Tipo_Accesorio', document.getElementById('id_tipo_accesorio_valor').value)
            break
        case 17:
            myForm.append('Id_Tipo_Vestimenta', document.getElementById('id_tipo_vestimenta').value)
            myForm.append('Tipo_Vestimenta', document.getElementById('id_tipo_vestimenta_valor').value)
            break
        case 18:
            myForm.append('Id_Zona_Sector', document.getElementById('id_zona_sector').value)
            myForm.append('Tipo_Grupo', document.getElementById('id_tipo_grupo').value)
            myForm.append('Zona_Sector', document.getElementById('id_zona_sector_valor').value)
            break
        case 19:
            myForm.append('Id_Origen_Evento', document.getElementById('id_origen_evento').value)
            myForm.append('Origen', document.getElementById('id_origen').value)
            break
        case 20:
            myForm.append('Id_Vector', document.getElementById('id_vector').value)
            myForm.append('Id_Vector_Interno', document.getElementById('id_vector_i').value)
            myForm.append('Zona', document.getElementById('id_zona').value)
            myForm.append('Vector', document.getElementById('id_vector_numero').value)
            myForm.append('Region', document.getElementById('id_region').value)
            break
        case 21:
            myForm.append('Id_Uso_Vehiculo', document.getElementById('id_uso_vehiculo').value)
            myForm.append('Uso', document.getElementById('id_uso').value)
            break
        case 22:
            myForm.append('Id_Marca_Io', document.getElementById('id_marca_vehiculo').value)
            myForm.append('Marca', document.getElementById('id_marca').value)
            break
        case 23:
            myForm.append('Id_Grupo_Inspeccion', document.getElementById('id_grupo').value)
            myForm.append('Tipo_Grupo', document.getElementById('id_tipo_grupo').value)
            myForm.append('Valor_Grupo', document.getElementById('id_valor_grupo').value)
            break
        /*Se añade la funcion para obtener los valores ingresados para editar/crear
        un nuevo elemento en los dos nuevos catalogos: tipos y submarcas de vehiculos*/
        case 24:
            myForm.append('Id_Tipo_Vehiculo', document.getElementById('id_tipo_veh').value)
            myForm.append('Valor_Tipo', document.getElementById('id_tipo_veh_desc').value)
            break
        case 25:
            myForm.append('Id_Submarca_Vehiculo', document.getElementById('id_submarca_veh').value)
            myForm.append('Valor_Submarca', document.getElementById('id_submarca_desc').value)
            break
        //Se añade el catalogo para estados, municipios, calles, colonias, animales, tipo_placanip, cuervo personas y vehiculos
        case 26:
            myForm.append('Id_Categoria', document.getElementById('Id_categoria').value)
            myForm.append('Valor_Categoria', document.getElementById('Id_categoria_desc').value)
            break
        case 27:
            myForm.append('Id_Tipo_Animal', document.getElementById('Id_Tipo_Animal').value)
            myForm.append('Descripcion', document.getElementById('Descripcion').value)
            break
        case 28:
            myForm.append('Id_colonia', document.getElementById('Id_colonia').value)
            myForm.append('tipo', document.getElementById('tipo').value)
            myForm.append('colonia', document.getElementById('colonia').value)
            break
        case 29:
            myForm.append('Id_calle', document.getElementById('Id_calle').value)
            myForm.append('Id_calle_desc', document.getElementById('Id_calle_desc').value)
            break
        case 30:
            myForm.append('Id_estado', document.getElementById('Id_estado').value)
            myForm.append('Estado', document.getElementById('Estado').value)
            break
        case 31:
            myForm.append('Id_municipio', document.getElementById('Id_municipio').value)
            myForm.append('Id_municipio_desc', document.getElementById('Id_municipio_desc').value)
            myForm.append('Id_municipio_m', document.getElementById('Id_municipio_m').value)
            break
        case 32:
            myForm.append('id_dato', document.getElementById('id_dato').value.toUpperCase())
            myForm.append('Nombre', document.getElementById('Nombre').value.toUpperCase())
            myForm.append('Ap_Paterno', document.getElementById('Ap_Paterno').value.toUpperCase())
            myForm.append('Ap_Materno', document.getElementById('Ap_Materno').value.toUpperCase())
            break
        case 33:
            myForm.append('id_dato', document.getElementById('id_dato').value.toUpperCase())
            myForm.append('placa', document.getElementById('placa').value.toUpperCase())
            myForm.append('nip', document.getElementById('nip').value.toUpperCase())
            break
        case 34:
            myForm.append('Id_cp', document.getElementById('Id_cp').value.toUpperCase())
            myForm.append('Codigo_postal', document.getElementById('Codigo_postal').value.toUpperCase())
            myForm.append('Nombre', document.getElementById('Nombre').value.toUpperCase())
            break

    }
    fetch(base_url_js + 'Catalogos/sendFormFetch', {
            method: 'POST',
            body: myForm
        })
        .then(function(response) {
            if (response.ok) {
                return response.json()
            } else {
                throw "Error en la llamada Ajax";
            }
        })
        .then(function(myJson) {
            console.log(myJson)
            if (myJson == 'Success') {
                alert("Consulta realizada correctamente")
                document.location.reload()
            } else {
                alert(myJson)
            }
        })
        .catch(function(error) {
            console.log("Error desde Catch _  " + error)
        })
}
const catalogocuervov =  async () => {
    //console.log('entro a sacar catalogo')
    try {
        const response = await fetch(base_url_js + 'Catalogos/getCatalogoPlacaNip', {
            method: 'POST',
            mode: 'cors' ,
        });
        const data = await response.json();
        //console.log('entro a sacar catalogo con data')
        return data;
    } catch (error) {
        console.log(error);
    }
}

const catalogocuervop =  async () => {
    //console.log('entro a sacar catalogo')
    try {
        const response = await fetch(base_url_js + 'Catalogos/getCatalogoPersonas', {
            method: 'POST',
            mode: 'cors' ,
        });
        const data = await response.json();
        //console.log('entro a sacar catalogo con data')
        return data;
    } catch (error) {
        console.log(error);
    }
}

const validarPlacaNip = async (placainput, nipinput) => {
    // console.log('entro a validar placa nip')
    // console.log(placainput,nipinput)
    let noEncontro = {id_dato: 0, valor: true };
    let catalogocuervovdata;
    catalogocuervovdata = await catalogocuervov()
    console.log('DESDE FUNCION VALIDACION',catalogocuervovdata);
    for(let i =0; i<catalogocuervovdata.length; i++){
        if(catalogocuervovdata[i].placa.toLowerCase() === placainput.toLowerCase() && catalogocuervovdata[i].nip.toLowerCase() === nipinput.toLowerCase()){
            noEncontro.valor = false;
            noEncontro.id_dato = catalogocuervovdata[i].id_dato;
           break;
        }
    }
    // console.log('salgo de validad placa nip')
    return noEncontro;
}
const validarPersona = async (nombreinput, appaternoinput, apmaternoinput) => {
    // console.log('entro a validar placa nip')
    // console.log(placainput,nipinput)
    let noEncontro = {id_dato: 0, valor: true };
    let catalogocuervopdata;
    catalogocuervopdata = await catalogocuervop()
    console.log('DESDE FUNCION VALIDACION',catalogocuervopdata);
    for(let i =0; i<catalogocuervopdata.length; i++){
        if(catalogocuervopdata[i].Nombre.toLowerCase() === nombreinput.toLowerCase() && catalogocuervopdata[i].Ap_Paterno.toLowerCase() === appaternoinput.toLowerCase() && catalogocuervopdata[i].Ap_Materno.toLowerCase() === apmaternoinput.toLowerCase()){
            noEncontro.valor = false;
            noEncontro.id_dato = catalogocuervopdata[i].id_dato;
           break;
        }
    }
    // console.log('salgo de validad placa nip')
    return noEncontro;
}