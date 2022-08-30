<div class="container">
    <!--header of anexo B-->
    <div class="row mt-5">
        <div class="col-auto my-auto">
            <button class="btn btn-sm back-btn mb-3 d-flex justify-content-center my-auto" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="goToBack()">
                <i class="material-icons">arrow_back</i>
            </button>
        </div>
        <div class="col-auto my-auto mr-auto">
            <h5 class="title-width my-auto">
                <span>Anexo B - INFORME DEL USO DE LA FUERZA</span> 
                <span class="navegacion">/ </span>
            </h5>
        </div>
        <!-- Edit/See Button -->
        <div class="col-auto my-auto mx-auto mx-lg-0 ml-0 ml-lg-auto mi_hide" id="id_edit_button_panel">
            <button class="btn btn-primary" id="id_edit_button">Modo Editar</button>
        </div>
    </div>
    <!--result alert-->
    <div class="row mt-3">
        <div class="col-12 mi_hide" >
            <div class="alert alert-session-create" role="alert" id="id_alert_result">
                Alert result
            </div>
        </div>
    </div>

    <form id="id_form_anexo_b" class="row" onsubmit="return mySubmitFunction(event)">
        <!-- Id de la puesta si se trata de edición -->
        <input type="hidden" id="id_puesta" name="Id_Puesta" value="<?= $data['id_puesta']?>">
        <!-- Id del detenido (si existe) -->
        <input type="hidden" id="id_informe" name="Id_Informe" value="<?= $data['id_informe']?>">
        <!--NIVELES DEL USO DE LA FUERZA-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-2 mb-2">
                    <div class="text-divider">
                        <h6 class="sub_header">Niveles del uso de la fuerza</h6>
                    </div>
                </div>
                <!-- Cuántos lesionados -->
                <div class="col-12 col-lg-6">
                    <div class="row">
                        <div class="col-12 text-center">
                            <span class="label-form">Indique cuántos lesionados</span>
                        </div>
                        <!-- autoridad -->
                        <div class="form-group col-6">
                            <label for="id_num_lesionados_autoridad" class="label-form">Autoridad:</label>
                            <input type="number" min="0" value="0" class="form-control form-control-sm text-uppercase" id="id_num_lesionados_autoridad" name="Num_Lesionados_Autoridad" onkeypress="return soloNumeros(event)" maxlength = "4">
                            <small id="error_num_lesionados_autoridad" class="form-text text-danger "></small>
                        </div>
                        <!-- persona -->
                        <div class="form-group col-6">
                            <label for="id_num_lesionados_persona" class="label-form">Persona:</label>
                            <input type="number" min="0" value="0" class="form-control form-control-sm text-uppercase" id="id_num_lesionados_persona" name="Num_Lesionados_Persona" onkeypress="return soloNumeros(event)" maxlength = "4">
                            <small id="error_num_lesionados_persona" class="form-text text-danger "></small>
                        </div>
                    </div>
                    
                </div>
                <!-- Cuántos fallecidos -->
                <div class="col-12 col-lg-6">
                    <div class="row">
                        <div class="col-12 text-center">
                            <span class="label-form">Indique cuántos fallecidos</span>
                        </div>
                        <!-- autoridad -->
                        <div class="form-group col-6">
                            <label for="id_num_fallecidos_autoridad" class="label-form">Autoridad:</label>
                            <input type="number" min="0" value="0" class="form-control form-control-sm text-uppercase" id="id_num_fallecidos_autoridad" name="Num_Fallecidos_Autoridad" onkeypress="return soloNumeros(event)" maxlength = "4">
                            <small id="error_num_fallecidos_autoridad" class="form-text text-danger "></small>
                        </div>
                        <!-- persona -->
                        <div class="form-group col-6">
                            <label for="id_num_fallecidos_persona" class="label-form">Persona:</label>
                            <input type="number" min="0" value="0" class="form-control form-control-sm text-uppercase" id="id_num_fallecidos_persona" name="Num_Fallecidos_Persona" onkeypress="return soloNumeros(event)" maxlength = "4">
                            <small id="error_num_fallecidos_persona" class="form-text text-danger "></small>
                        </div>
                    </div>
                </div>

                <!-- Segun corresponda -->
                <div class="col-12 col-lg-4 my-4">
                    <div class="row">
                        <div class="col-12 col-md-auto text-center">
                            <span class="label-form">Seleccione según corresponda</span>
                        </div>
                        <!-- checks -->
                        <div class="col-12">
                            <div class="form-check custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input sustancia_check" id="id_reduccion_movimiento" value="1" name="Reduccion_Movimiento" >
                                <label class="custom-control-label" for="id_reduccion_movimiento">Reducción de movimientos</label>
                                
                            </div>
                            <div class="form-check custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input sustancia_check" id="id_armas_incapacitantes" value="1" name="Armas_Incapacitantes" >
                                <label class="custom-control-label" for="id_armas_incapacitantes">Utilización de armas incapacitantes menos letales</label>
                                
                            </div>
                            <div class="form-check custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input sustancia_check" id="id_armas_fuego" value="1" name="Armas_Fuego" >
                                <label class="custom-control-label" for="id_armas_fuego">Utilización de armas de fuego o fuerza letal</label>
                                
                            </div>
                        
                        </div>
                        
                    </div>
                        
                </div>

                <!-- Descripción conducta -->
                <div class="col-12 col-lg-8 my-auto">
                    <div class="row">
                        <div class="form-group col-12">
                            <label class="label-form"for="id_descripcion_conducta">Describa las conductas (resistencia activa y de alta peligrosidad) que motivaron el uso de la fuerza:</label>
                            <textarea class="form-control text-uppercase" id="id_descripcion_conducta" rows="3" maxlength="2500" name="Descripcion_Conducta"></textarea>
                            <small id="error_descripcion_conducta" class="form-text text-danger"></small>
                        </div>
                    </div>
                </div>

                <!-- Brindo asistencia médica-->
                <div class="col-12 mt-4">
                    <div class="row">
                        <div class="col-6 col-md-auto my-auto">
                            <span class="label-form">¿Brindó o solicitó asistencia médica?</span>
                        </div>
                        <div class="col-6 col-md-auto my-auto">
                            <div class="row mt-3 my-auto">
                                <div class="col-auto">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Asistencia_Med_Radio" id="id_asistencia_med_1" value="0"  onchange="changeAsistenciaMed(event)">
                                        <label class="form-check-label" for="id_asistencia_med_1">No</label>
                                    </div>
                                </div>
                                <div class="col-auto mr-auto">
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" name="Asistencia_Med_Radio" id="id_asistencia_med_2" value="1"  onchange="changeAsistenciaMed(event)">
                                        <label class="form-check-label" for="id_asistencia_med_2">Sí</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <small id="error_asistencia_med_radio" class="text-danger"></small>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-auto my-auto mi_hide" id="id_asistencia_med_panel">
                            <div class="row">
                                <div class="col-auto my-auto">
                                    <span class="label-form">Explique:</span>
                                </div>
                                <div class="col-auto my-auto">
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_asistencia_medica" name="Asistencia_Medica" disabled>
                                    <small id="error_asistencia_medica" class="form-text text-danger "></small>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>


            </div>
        </div>
        
        <!--PRIMER RESPONDIENTE-->
        <div class="col-12 mt-4">
            <div class="row">
                <div class="col-12 text-center mt-2 mb-2">
                    <div class="text-divider">
                        <h6 class="sub_header">Datos del primer respondiente que realizó el informe del uso de la fuerza</h6>
                    </div>
                </div>
                <!-- Coincidencia del primer respondiente -->
                <div class="col-12">
                    <div class="row mt-3">
                        <div class="col-12 text-center label-form ml-auto">¿El primer respondiente es diferente a quien firmó la puesta a disposición?  </div>
                        <div class="col-auto ml-auto">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Primer_Respondiente_Radio" id="id_primer_respondiente_radio_1" value="0" onchange="changePrimerResRadio(event)">
                                <label class="form-check-label" for="id_primer_respondiente_radio_1">No</label>
                            </div>
                        </div>
                        <div class="col-auto mr-auto">
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="Primer_Respondiente_Radio" id="id_primer_respondiente_radio_2" value="1" onchange="changePrimerResRadio(event)">
                                <label class="form-check-label" for="id_primer_respondiente_radio_2">Sí</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <small class="form-text text-danger" id="error_primer_respondiente_radio"></small>
                        </div>
                    </div>
                </div>

                <!-- Form Primer respondiente -->
                <div class="col-12 mi_hide" id="id_elemento_panel">
                    <div class="row">
                        <!-- buscador de elementos por no control -->
                        <div class="col-12" id="id_busqueda_pr_panel">
                            <div class="input-group col-lg-6 offset-lg-3 my-2">
                                <input type="text" class="form-control form-control-sm text-uppercase" placeholder="Ingrese el número de control, placa ó apellidos del elemento" id="element_search_1">
                                <div class="input-group-append">
                                    <button class="btn btn-ssc btn-sm" type="button" id="button_search_1">Buscar</button>
                                </div>
                            </div>  
                            <div class="col-lg-6 offset-lg-3 mb-3" id="list_elements_search_1">
                            </div>
                        </div>
                        <!-- Primer respondiente -->
                        <!-- Nombre_PR -->
                        <div class="form-group col-6 col-md-3">
                            <label for="id_nombre_pr" class="label-form">Nombre(s):</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_nombre_pr" name="Nombre_PR" >
                            <small id="error_nombre_pr" class="form-text text-danger "></small>
                        </div>
                        <!-- Ap_Paterno_PR -->
                        <div class="form-group col-6 col-md-2">
                            <label for="id_ap_pat_pr" class="label-form">Apellido paterno:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_ap_pat_pr" name="Ap_Paterno_PR" >
                            <small id="error_ap_pat_pr" class="form-text text-danger "></small>
                        </div>
                        <!-- Ap_Materno_PR -->
                        <div class="form-group col-6 col-md-2">
                            <label for="id_ap_mat_pr" class="label-form">Apellido materno:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_ap_mat_pr" name="Ap_Materno_PR" >
                            <small id="error_ap_mat_pr" class="form-text text-danger "></small>
                        </div>
                        <!-- Institucion -->
                        <div class="form-group col-6 col-md-2">
                            <label for="id_institucion_pr" class="label-form">Adscripción:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_institucion_pr" name="Institucion_PR" >
                            <small id="error_institucion_pr" class="form-text text-danger "></small>
                        </div>
                        <!-- Cargo -->
                        <div class="form-group col-6 col-md-3">
                            <label for="id_cargo_pr" class="label-form">Cargo/grado:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_cargo_pr" name="Cargo_PR" >
                            <small id="error_cargo_pr" class="form-text text-danger "></small>
                        </div>
                        <input type="hidden" value="320672" name="No_Control_PR" id="id_no_control_pr">

                        <!-- buscador de elementos por no control SEGUNDO RESPONDIENTE -->
                        <div class="col-12" id="id_busqueda_sr_panel">
                            <div class="input-group col-lg-6 offset-lg-3 my-2"> 
                                <input type="text" class="form-control form-control-sm text-uppercase" placeholder="Ingrese el número de control, placa ó apellidos del elemento" id="element_search_2">
                                <div class="input-group-append">
                                    <button class="btn btn-ssc btn-sm" type="button" id="button_search_2">Buscar</button>
                                </div>
                            </div>  
                            <div class="col-lg-6 offset-lg-3 mb-3" id="list_elements_search_2">
                            </div>
                        </div>
                        <!-- Nombre_SR -->
                        <div class="form-group col-6 col-md-3">
                            <label for="id_nombre_sr" class="label-form">Nombre(s):</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_nombre_sr" name="Nombre_SR" >
                            <small id="error_nombre_sr" class="form-text text-danger "></small>
                        </div>
                        <!-- Ap_Paterno_SR -->
                        <div class="form-group col-6 col-md-2">
                            <label for="id_ap_pat_sr" class="label-form">Apellido paterno:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_ap_pat_sr" name="Ap_Paterno_SR" >
                            <small id="error_ap_pat_sr" class="form-text text-danger "></small>
                        </div>
                        <!-- Ap_Materno_SR -->
                        <div class="form-group col-6 col-md-2">
                            <label for="id_ap_mat_sr" class="label-form">Apellido materno:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_ap_mat_sr" name="Ap_Materno_SR" >
                            <small id="error_ap_mat_sr" class="form-text text-danger "></small>
                        </div>
                        <!-- Institucion_SR -->
                        <div class="form-group col-6 col-md-2">
                            <label for="id_institucion_sr" class="label-form">Adscripción:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_institucion_sr" name="Institucion_SR" >
                            <small id="error_institucion_sr" class="form-text text-danger "></small>
                        </div>
                        <!-- Cargo_SR -->
                        <div class="form-group col-6 col-md-3">
                            <label for="id_cargo_sr" class="label-form">Cargo/grado:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_cargo_sr" name="Cargo_SR" >
                            <small id="error_cargo_sr" class="form-text text-danger "></small>
                        </div>
                        <input type="hidden" value="320672" name="No_Control_SR" id="id_no_control_sr">
                    </div>
                    
                </div>
                    
            </div>
        </div>
    </form>

    <!--BUTTONS-->
    <div class="row my-5" >
        <!--Botones de guardar y/o continuar-->
        <div class="col-12 mt-4 mb-5" id="id_send_buttons_panel">
            <div class="row d-flex justify-content-center" id="id_send_buttons_panel">
                <div class="col-auto">
                    <button type="button" class="btn btn-secondary" onclick="goToBack()" id="id_cancel_button">Cancelar</button>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-ssc" onclick="checkFormAnexoB(event)" id="guardar_crear">Guardar</button>
                </div>
            </div>
        </div>
    </div>

</div>