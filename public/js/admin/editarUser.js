//ocultar mensaje de error
document.getElementById('error_img1').style.display = "none"

//procesamiento de la imagen a subir
var img_1 = document.getElementById("id_foto_file")

var p_1 = document.getElementById('preview_1')

/*JS de password y desactivar permisos*/
var passButton  =   document.getElementById('id_pass_button')
var inputPass   =   document.getElementById('id_input_pass') 
var mySubmit    =   document.getElementById('mySubmit')
var myForm      =   document.getElementById('id_form')

function viewPassword(){
    if (inputPass.type == 'text') {
        inputPass.type = 'password'
    }
    else{
        inputPass.type = 'text'
    }
    
}

passButton.addEventListener('click',viewPassword)



function disablePermisos(){
    var permisos = document.getElementsByClassName('checkPermisos');
        permisos = Array.prototype.slice.call( permisos, 0 );
    
    if (document.getElementById('Modo_Admin').checked) 
        permisos.forEach(element => {element.disabled = true});
    
    else
        permisos.forEach(element => {element.disabled = false});    
}

disablePermisos()

/*JS de validación de imágenes para subir al sistema*/
img_1.onchange = function(e) {
    let formatosImg = 'image/png image/jpeg image/jpg'

    //console.log(img_1.files[0])
    //console.log(img_1.files[0].type)
    let reader = new FileReader();
    if (typeof img_1.files[0] !== 'undefined') {
        if (img_1.files[0].size <= 8000000) { //size max 8MB
            if(formatosImg.includes(img_1.files[0].type+"")){
                document.getElementById('error_img1').style.display = "none"
                reader.onload = function() {
                    let image = document.createElement('img');

                    document.getElementById('label_foto_file').textContent = e.target.files[0].name

                    image.src = reader.result;
                    p_1.style.display = "block"
                    p_1.innerHTML = '';
                    p_1.append(image);
                    //alert('Tamaño: ' + img_1.files[0].size)
                };

                reader.readAsDataURL(e.target.files[0]);
            }
            else{
                delete img_1.files[0];
                p_1.style.display = "none"
                document.getElementById('error_img1').style.display = "block"
                img_1.value = ""
                document.getElementById('label_foto_file').textContent = "Subir imagen"
            }

        }
    } 
    else {
        delete img_1.files[0];
        p_1.style.display = "none"
        document.getElementById('error_img1').style.display = "block"
        img_1.value = ""
        document.getElementById('label_foto_file').textContent = "Subir imagen"
    }

}

/*JS para activar todos o ninguno de los permisos marcados*/

var all_juridico = document.getElementById('all_juridico')
var all_dictamen = document.getElementById('all_dictamen')
var all_remisiones = document.getElementById('all_remisiones')
var all_inteligencia = document.getElementById('all_inteligencia')
var all_inteligencia_op = document.getElementById('all_inteligencia_op')
var all_iph_final = document.getElementById('all_iph_final')
var all_corralon = document.getElementById('all_corralon')
var all_eventos_d = document.getElementById('all_eventos_d')
//se agregan las variables para editar/ver remisiones editar/ver narrativas
var all_editar_remi=document.getElementById('all_editar_remi')
var all_ver_remi=document.getElementById('all_ver_remi')
var all_editar_narra=document.getElementById('all_editar_narra')
var all_ver_narra=document.getElementById('all_ver_narra')
var all_vehiculos=document.getElementById('all_vehiculos')

all_juridico.addEventListener('change',change_all)
all_dictamen.addEventListener('change',change_all)
all_remisiones.addEventListener('change',change_all)
all_inteligencia.addEventListener('change',change_all)
all_inteligencia_op.addEventListener('change',change_all)
all_iph_final.addEventListener('change',change_all)
all_corralon.addEventListener('change',change_all)
all_eventos_d.addEventListener('change',change_all)
//se agregan las variables para editar/ver remisiones editar/ver narrativas
all_editar_remi.addEventListener('change',change_all)
all_ver_remi.addEventListener('change',change_all)
all_editar_narra.addEventListener('change',change_all)
all_ver_narra.addEventListener('change',change_all)
all_vehiculos.addEventListener('change',change_all)


function change_all(e){
    switch(e.target.id){
        case 'all_juridico':
            if (all_juridico.value === '1') {
                document.getElementById('Ju_Create').checked = true
                document.getElementById('Ju_Read').checked = true
                document.getElementById('Ju_Update').checked = true
                //se comenta porque delete se elimino del diseño final document.getElementById('Ju_Delete').checked = true
                all_juridico.value = '0'
            }
            else{
                document.getElementById('Ju_Create').checked = false
                document.getElementById('Ju_Read').checked = false
                document.getElementById('Ju_Update').checked = false
                //document.getElementById('Ju_Delete').checked = false
                all_juridico.value = '1'
            }
        break
        case 'all_dictamen':
            if (all_dictamen.value === '1') {
                document.getElementById('Dic_Create').checked = true
                document.getElementById('Dic_Read').checked = true
                document.getElementById('Dic_Update').checked = true
               // document.getElementById('Dic_Delete').checked = true
                all_dictamen.value = '0'
            }
            else{
                document.getElementById('Dic_Create').checked = false
                document.getElementById('Dic_Read').checked = false
                document.getElementById('Dic_Update').checked = false
             //   document.getElementById('Dic_Delete').checked = false
                all_dictamen.value = '1'
            }
        break
        case 'all_remisiones':
            if (all_remisiones.value === '1') {
                document.getElementById('R_Create').checked = true
                document.getElementById('R_Read').checked = true
                document.getElementById('R_Update').checked = true
               // document.getElementById('R_Delete').checked = true
                all_remisiones.value = '0'
            }
            else{
                document.getElementById('R_Create').checked = false
                document.getElementById('R_Read').checked = false
                document.getElementById('R_Update').checked = false
            //    document.getElementById('R_Delete').checked = false
                all_remisiones.value = '1'
            }
        break
        case 'all_inteligencia':
            if (all_inteligencia.value === '1') {
                document.getElementById('Int_Create').checked = true
                document.getElementById('Int_Read').checked = true
                document.getElementById('Int_Update').checked = true
             //   document.getElementById('Int_Delete').checked = true
                all_inteligencia.value = '0'
            }
            else{
                document.getElementById('Int_Create').checked = false
                document.getElementById('Int_Read').checked = false
                document.getElementById('Int_Update').checked = false
              //  document.getElementById('Int_Delete').checked = false
                all_inteligencia.value = '1'
            }
        break
        case 'all_inteligencia_op':
            if (all_inteligencia_op.value === '1') {
                document.getElementById('IntOp_Create').checked = true
                document.getElementById('IntOp_Read').checked = true
                document.getElementById('IntOp_Update').checked = true
               // document.getElementById('IntOp_Delete').checked = true
                all_inteligencia_op.value = '0'
            }
            else{
                document.getElementById('IntOp_Create').checked = false
                document.getElementById('IntOp_Read').checked = false
                document.getElementById('IntOp_Update').checked = false
            //    document.getElementById('IntOp_Delete').checked = false
                all_inteligencia_op.value = '1'
            }
        break
        case 'all_iph_final':
            if (all_iph_final.value === '1') {
                document.getElementById('IPH_Create').checked = true
                document.getElementById('IPH_Read').checked = true
                document.getElementById('IPH_Update').checked = true
             //   document.getElementById('IPH_Delete').checked = true
                all_iph_final.value = '0'
            }
            else{
                document.getElementById('IPH_Create').checked = false
                document.getElementById('IPH_Read').checked = false
                document.getElementById('IPH_Update').checked = false
            //    document.getElementById('IPH_Delete').checked = false
                all_iph_final.value = '1'
            }
        break
        case 'all_corralon':
            if (all_corralon.value === '1') {
                document.getElementById('Corr_Create').checked = true
                document.getElementById('Corr_Read').checked = true
                document.getElementById('Corr_Update').checked = true
            //    document.getElementById('Corr_Delete').checked = true
                all_corralon.value = '0'
            }
            else{
                document.getElementById('Corr_Create').checked = false
                document.getElementById('Corr_Read').checked = false
                document.getElementById('Corr_Update').checked = false
            //    document.getElementById('Corr_Delete').checked = false
                all_corralon.value = '1'
            }
        break
        case 'all_eventos_d':
            if (all_eventos_d.value === '1') {
                document.getElementById('E_Create').checked = true
                document.getElementById('E_Read').checked = true
                document.getElementById('E_Update').checked = true
            //    document.getElementById('E_Delete').checked = true
                all_eventos_d.value = '0'
            }
            else{
                document.getElementById('E_Create').checked = false
                document.getElementById('E_Read').checked = false
                document.getElementById('E_Update').checked = false
            //    document.getElementById('E_Delete').checked = false
                all_eventos_d.value = '1'
            }
        break
        //se agregan las variables para editar/ver remisiones editar/ver narrativas
        case 'all_editar_remi':
            if (all_editar_remi.value === '1') {
                document.getElementById('check_datosp').checked = true
                document.getElementById('peti_edit').checked = true
                document.getElementById('ubicacion_editar').checked = true
                document.getElementById('elementos_rem').checked = true
                document.getElementById('objetos_ae').checked = true
                document.getElementById('fotosyh_e').checked = true
                document.getElementById('ubicacion_de').checked = true
                document.getElementById('senas_e').checked = true
                document.getElementById('entrevistad_e').checked = true
                document.getElementById('mediaf_e').checked = true
                document.getElementById('narrativas_e').checked = true
                all_editar_remi.value = '0'
            }
            else{
                document.getElementById('check_datosp').checked = false
                document.getElementById('peti_edit').checked = false
                document.getElementById('ubicacion_editar').checked = false
                document.getElementById('elementos_rem').checked = false
                document.getElementById('objetos_ae').checked = false
                document.getElementById('fotosyh_e').checked = false
                document.getElementById('ubicacion_de').checked = false
                document.getElementById('senas_e').checked = false
                document.getElementById('entrevistad_e').checked = false
                document.getElementById('mediaf_e').checked = false
                document.getElementById('narrativas_e').checked = false
                all_editar_remi.value = '1'
            }
        break
        case 'all_ver_remi':
            if (all_ver_remi.value === '1') {
                document.getElementById('check_datospv').checked = true
                document.getElementById('peti_ver').checked = true
                document.getElementById('ubicacion_ver').checked = true
                document.getElementById('elementos_remv').checked = true
                document.getElementById('objetos_av').checked = true
                document.getElementById('fotosyh_v').checked = true
                document.getElementById('ubicacion_dv').checked = true
                document.getElementById('senas_v').checked = true
                document.getElementById('entrevistad_v').checked = true
                document.getElementById('mediaf_v').checked = true
                document.getElementById('narrativas_v').checked = true
                all_ver_remi.value = '0'
            }
            else{
                document.getElementById('check_datospv').checked = false
                document.getElementById('peti_ver').checked = false
                document.getElementById('ubicacion_ver').checked = false
                document.getElementById('elementos_remv').checked = false
                document.getElementById('objetos_av').checked = false
                document.getElementById('fotosyh_v').checked = false
                document.getElementById('ubicacion_dv').checked = false
                document.getElementById('senas_v').checked = false
                document.getElementById('entrevistad_v').checked = false
                document.getElementById('mediaf_v').checked = false
                document.getElementById('narrativas_v').checked = false
                all_ver_remi.value = '1'
            }
        break
        case 'all_editar_narra':
            if (all_editar_narra.value === '1') {
                document.getElementById('check_narrap').checked = true
                document.getElementById('elem_narrae').checked = true
                document.getElementById('detenido_narrae').checked = true
                document.getElementById('iph_narrae').checked = true
                all_editar_narra.value = '0'
            }
            else{
                document.getElementById('check_narrap').checked = false
                document.getElementById('elem_narrae').checked = false
                document.getElementById('detenido_narrae').checked = false
                document.getElementById('iph_narrae').checked = false
                all_editar_narra.value = '1'
            }
        break
        case 'all_ver_narra':
            if (all_ver_narra.value === '1') {
                document.getElementById('check_narrapv').checked = true
                document.getElementById('elem_narrav').checked = true
                document.getElementById('detenido_narrav').checked = true
                document.getElementById('iph_narrav').checked = true
                all_ver_narra.value = '0'
            }
            else{
                document.getElementById('check_narrapv').checked = false
                document.getElementById('elem_narrav').checked = false
                document.getElementById('detenido_narrav').checked = false
                document.getElementById('iph_narrav').checked = false
                all_ver_narra.value = '1'
            }
        break
        case 'all_vehiculos':
            if (all_vehiculos.value === '1') {
                document.getElementById('V_Create').checked = true
                document.getElementById('V_Read').checked = true
                document.getElementById('V_Update').checked = true
                all_vehiculos.value = '0'
            }
            else{
                document.getElementById('V_Create').checked = false
                document.getElementById('V_Read').checked = false
                document.getElementById('V_Update').checked = false
                all_vehiculos.value = '1'
            }
        break
        //----------------
    }
}
/*Se agrega para controlar la vista de remisiones y narrativas, consultar y modificar  */
function editar_remisiones(){ 
    fila=document.getElementById('remisiones_editar').getElementsByTagName('tr');
    if(document.getElementById('R_Update').checked){//si esta checked es hacerlo visible
        fila[0].getElementsByTagName('th')[0].style.display=''
        for(i=1;i<fila.length;i++){
            fila[i].getElementsByTagName('td')[0].style.display='';   
        }
    }
    else{
        fila[0].getElementsByTagName('th')[0].style.display='none'
        for(i=1;i<fila.length;i++){
            fila[i].getElementsByTagName('td')[0].style.display='none'     
        }
        document.getElementById('check_datosp').checked=false;
        document.getElementById('peti_edit').checked=false;
        document.getElementById('ubicacion_editar').checked=false;
        document.getElementById('elementos_rem').checked=false;
        document.getElementById('objetos_ae').checked=false;
        document.getElementById('fotosyh_e').checked=false;
        document.getElementById('ubicacion_de').checked=false;
        document.getElementById('senas_e').checked=false;
        document.getElementById('entrevistad_e').checked=false;
        document.getElementById('mediaf_e').checked=false;
        document.getElementById('narrativas_e').checked=false;
        editar_narrativas();
    }   
}
function ver_remisiones(){ 
    fila=document.getElementById('remisiones_editar').getElementsByTagName('tr');
    if(document.getElementById('R_Read').checked){//si esta checked es hacerlo visible
        fila[0].getElementsByTagName('th')[1].style.display=''
        for(i=1;i<fila.length;i++){
            fila[i].getElementsByTagName('td')[1].style.display='';   
        }
    }
    else{
        fila[0].getElementsByTagName('th')[1].style.display='none'
        for(i=1;i<fila.length;i++){
            fila[i].getElementsByTagName('td')[1].style.display='none'     
        }
        document.getElementById('check_datospv').checked=false;
        document.getElementById('peti_ver').checked=false;
        document.getElementById('ubicacion_ver').checked=false;
        document.getElementById('elementos_remv').checked=false;
        document.getElementById('objetos_av').checked=false;
        document.getElementById('fotosyh_v').checked=false;
        document.getElementById('ubicacion_dv').checked=false;
        document.getElementById('senas_v').checked=false;
        document.getElementById('entrevistad_v').checked=false;
        document.getElementById('narrativas_e').checked=false;
        document.getElementById('mediaf_v').checked=false;
        document.getElementById('narrativas_v').checked=false;
        ver_narrativas();
    }    
}
function editar_narrativas(){ 
    fila=document.getElementById('permisos_tabla_editar').getElementsByTagName('tr');
    if(document.getElementById('narrativas_e').checked){//si esta checked es hacerlo visible
        fila[0].getElementsByTagName('th')[9].style.display=''
        for(i=1;i<fila.length;i++){
            fila[i].getElementsByTagName('td')[9].style.display='';   
        }
    }
    else{
        fila[0].getElementsByTagName('th')[9].style.display='none'
        for(i=1;i<fila.length;i++){
            fila[i].getElementsByTagName('td')[9].style.display='none'     
        }
        document.getElementById('check_narrap').checked=false;
        document.getElementById('elem_narrae').checked=false;
        document.getElementById('detenido_narrae').checked=false;
        document.getElementById('iph_narrae').checked=false;
    }   
}
function ver_narrativas(){ 
    fila=document.getElementById('permisos_tabla_editar').getElementsByTagName('tr');
    if(document.getElementById('narrativas_v').checked){//si esta checked es hacerlo visible
        fila[0].getElementsByTagName('th')[10].style.display=''
        for(i=1;i<fila.length;i++){
            fila[i].getElementsByTagName('td')[10].style.display='';   
        }
    }
    else{
        fila[0].getElementsByTagName('th')[10].style.display='none'
        for(i=1;i<fila.length;i++){
            fila[i].getElementsByTagName('td')[10].style.display='none'     
        }
        document.getElementById('check_narrapv').checked=false;
        document.getElementById('elem_narrav').checked=false;
        document.getElementById('detenido_narrav').checked=false;
        document.getElementById('iph_narrav').checked=false;
    }   
}
window.onload = function() {
    editar_remisiones()
    ver_remisiones()
    editar_narrativas()
    ver_narrativas()
};