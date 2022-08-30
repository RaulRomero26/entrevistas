<div class="container">
    <!--header of anexo E-->
    <div class="row mt-5">
        <div class="col-auto my-auto">
            <button class="btn btn-sm back-btn mb-3 d-flex justify-content-center my-auto" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="goToBack()">
                <i class="material-icons">arrow_back</i>
            </button>
        </div>
        <div class="col-auto my-auto mr-auto">
            <h5 class="title-width my-auto">
                <span>Anexo E - ENTREVISTAS</span> 
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

    <form id="id_form_anexo_e" class="row" onsubmit="return mySubmitFunction(event)">
        <!-- Id de la puesta si se trata de edición -->
        <input type="hidden" id="id_puesta" name="Id_Puesta" value="<?= $data['id_puesta']?>">
        <!-- Id del detenido (si existe) -->
        <input type="hidden" id="id_entrevista" name="Id_Entrevista" value="<?= $data['id_entrevista']?>">
        
        <!-- PERSONA DESEA RESERVAR SUS DATOS -->
        <div class="col-12">
            <div class="row mt-3">
                <div class="col-auto label-form">¿Desea reservar sus datos? </div>
                    <div class="col-auto form-check">
                        <input class="form-check-input" type="radio" name="Reservar_Datos" id="id_reservar_datos_1" value="0">
                        <label class="form-check-label" for="id_reservar_datos_1">No</label>
                    </div>
                    <div class="col-auto form-check">
                        <input class="form-check-input" type="radio" name="Reservar_Datos" id="id_reservar_datos_2" value="1">
                        <label class="form-check-label" for="id_reservar_datos_2">Sí</label>
                    </div>
                <div class="col-auto">
                    <small id="error_reservar_datos" class="form-text text-danger my-auto"></small>
                </div>
            </div>
        </div>
        <!--FECHA/HORA ENTREVISTA-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-2 mb-2">
                    <div class="text-divider">
                        <h6 class="sub_header">Fecha y hora de la entrevista</h6>
                    </div>
                </div>
                <div class="form-group col-6 col-md-4 ">
                    <label for="id_fecha" class="label-form">Fecha*:</label>
                    <input type="date" class="form-control form-control-sm" id="id_fecha" name="Fecha" value="<?php echo date('Y-m-d') ?>" >
                    <small id="error_fecha" class="form-text text-danger "></small>
                </div>
                <div class="form-group col-6 col-md-4 ">
                    <label for="id_hora" class="label-form">Hora*:</label>
                    <input type="time" class="form-control form-control-sm" id="id_hora" name="Hora" value="<?php echo date('H:i')?>" >
                    <small id="error_hora" class="form-text text-danger "></small>
                </div>

            </div>
        </div>
        <!--DATOS GENERALES DE LA ENTREVISTA-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-2 mb-2">
                    <div class="text-divider">
                        <h6 class="sub_header">Datos generales</h6>
                    </div>
                </div>
                <!-- nombre entrevistado -->
                <div class="form-group col-6 col-lg-4">
                    <label for="id_nombre_ent" class="label-form">Nombre(s)*:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_nombre_ent" name="Nombre_Ent" >
                    <small id="error_nombre_ent" class="form-text text-danger "></small>
                </div>
                <!-- ap paterno entrevistado -->
                <div class="form-group col-6 col-lg-4">
                    <label for="id_ap_pat_ent" class="label-form">Apellido paterno*:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_ap_pat_ent" name="Ap_Paterno_Ent" >
                    <small id="error_ap_pat_ent" class="form-text text-danger "></small>
                </div>
                <!-- ap materno entrevistado -->
                <div class="form-group col-6 col-lg-4">
                    <label for="id_ap_mat_ent" class="label-form">Apellido materno*:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_ap_mat_ent" name="Ap_Materno_Ent" >
                    <small id="error_ap_mat_ent" class="form-text text-danger "></small>
                </div>
                <!-- indique según corresponda -->
                <div class="col-12">
                    <div class="row">
                        <!-- label indique -->
                        <div class="col-12 mt-3 mb-4">
                            <span class="label-form">Indique según corresponda:</span>
                        </div>
                        <!-- calidad -->
                        <div class="form-group col-6 col-lg-3">
                            <label for="id_calidad" class="label-form">Calidad</label>
                            <select class="form-control form-control-sm" id="id_calidad" name="Calidad" >
                                <option class="text-muted" value="" disabled selected>Elige una opción</option>
                                <option value="Víctima u ofendido">Víctima u ofendido</option>
                                <option value="Denunciante">Denunciante</option>
                                <option value="Testigo">Testigo</option>
                            </select>
                            <small id="error_calidad" class="form-text text-danger "></small>
                        </div>
                        <!-- nacionalidad -->
                        <div class="form-group col-6 col-lg-3">
                            <label for="id_nacionalidad_select" class="label-form">Nacionalidad</label>
                            <select class="form-control form-control-sm" id="id_nacionalidad_select" name="Nacionalidad" onchange="changeNacionalidad(event)">
                                <option value="MEXICANA" selected>MEXICANA</option>
                                <option value="EXTRANJERA">EXTRANJERA</option>
                            </select>
                            <small id="error_nacionalidad_select" class="form-text text-danger "></small>
                        </div>
                        <!-- Nacionalidad otro -->
                        <div class="form-group col-6 col-lg-3 mi_hide" id="id_nacionalidad_otro_panel">
                            <label for="id_nacionalidad_otro" class="label-form">¿Cuál nacionalidad?:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_nacionalidad_otro" name="Nacionalidad_Otro" maxlength="1000">
                            <small id="error_nacionalidad_otro" class="form-text text-danger"></small>
                        </div>
                        <!-- Sexo -->
                        <div class="form-group col-6 col-lg-3">
                            <label for="id_genero" class="label-form">Sexo*:</label>
                            <select class="form-control form-control-sm" id="id_genero" name="Genero" >
                                <option value="H">HOMBRE</option>
                                <option value="M">MUJER</option>
                            </select>
                            <small id="error_genero" class="form-text text-danger "></small>
                        </div>
                        <!-- fecha de nacimiento -->
                        <div class="form-group col-6 col-lg-3">
                            <label for="id_fecha_nacimiento" class="label-form">Fecha de nacimiento*:</label>
                            <input type="date" class="form-control form-control-sm" id="id_fecha_nacimiento" name="Fecha_Nacimiento" value="" >
                            <small id="error_fecha_nacimiento" class="form-text text-danger "></small>
                        </div>
                        <!-- edad -->
                        <div class="form-group col-6 col-lg-3">
                            <label for="id_edad" class="label-form">Edad*:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_edad" name="Edad" onkeypress="return soloNumeros(event)" maxlength = "3"  readonly>
                            <small id="error_edad" class="form-text text-danger "></small>
                        </div>
                        <!-- teléfono -->
                        <div class="form-group col-6 col-lg-3">
                            <label for="id_telefono" class="label-form">No. telefónico:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_telefono" name="Telefono" onkeypress="return soloNumeros(event)" maxlength = "10">
                            <small id="error_telefono" class="form-text text-danger "></small>
                        </div>
                        <!-- correo electrónico -->
                        <div class="form-group col-6 col-lg-3">
                            <label for="id_correo" class="label-form">Correo electrónico:</label>
                            <input type="text" class="form-control form-control-sm" id="id_correo" name="Correo" >
                            <small id="error_correo" class="form-text text-danger "></small>
                        </div>
                        <!-- identificación select -->
                        <div class="form-group col-12 col-md-6 col-lg-3">
                            <label for="id_identificacion_select" class="label-form">¿Se identificó con algún documento?</label>
                            <select class="form-control form-control-sm" id="id_identificacion_select" name="Identificacion" onchange="changeIdentificacion(event)" >
                                <option class="text-muted" value="" disabled selected>Elige una opción</option>
                                <option value="Credencial INE">Credencial INE</option>
                                <option value="Licencia">Licencia</option>
                                <option value="Pasaporte">Pasaporte</option>
                                <option value="No">No</option>
                                <option value="Otro">Otro</option>
                            </select>
                            <small id="error_identificacion_select" class="form-text text-danger "></small>
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-3 mi_hide" id="id_identificacion_panel">
                            <label for="id_identificacion_otro" class="label-form">¿Cuál?:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_identificacion_otro" name="Identificacion_Otro" >
                            <small id="error_identificacion_otro" class="form-text text-danger "></small>
                        </div>
                        <!-- num identificación -->
                        <div class="form-group col-12 col-md-6 col-lg-3">
                            <label for="id_num_identificacion" class="label-form">Número de identificación:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_num_identificacion" name="Num_Identificacion" >
                            <small id="error_num_identificacion" class="form-text text-danger "></small>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        <!--DOMICILIO ENTREVISTADO-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-3 mb-2">
                    <div class="text-divider">
                        <h6 class="sub_header">Domicilio del entrevistado</h6>
                    </div>
                </div>

                <!--campos de la ubicación-->
                <div class="col-12 col-lg-6">
                    <div class="row">
                        <!--busqueda dinámica de Google maps-->
                        <div class="col-12">
                            <div class="row" id="id_busqueda_por_panel_1">
                                <div class="col-12 mb-2">
                                    <span class="label-form">Buscar por:</span>
                                </div>
                                
                                <!-- radios búsqueda por -->
                                <div class="form-group col-12" >
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="por_direccion_domEntrev_radio" name="busqueda" data-id="domEntrev" class="custom-control-input" value="0">
                                        <label class="custom-control-label label-form" for="por_direccion_domEntrev_radio">Dirección</label>
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="por_coordenadas_domEntrev_radio" name="busqueda" data-id="domEntrev" class="custom-control-input" value="1">
                                        <label class="custom-control-label label-form" for="por_coordenadas_domEntrev_radio">Coordenadas</label>
                                    </div>
                                </div>
                                <!-- Inputs de cada búsqueda -->
                                <div class="form-group col-12" id="por_direccion_domEntrev">
                                    <div class="input-group input-group-sm">
                                        <input type="search" name="dir_domEntrev" id="dir_domEntrev" class="form-control" placeholder="Ingrese una dirección a buscar" />
                                    </div>
                                </div>

                                <div class="form-group col-12" id="por_coordenadas_domEntrev">
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="search_cy_domEntrev" id="search_cy_domEntrev" class="form-control pr-3 mr-3" placeholder="Coordenada Y" />
                                        <input type="text" name="search_cx_domEntrev" id="search_cx_domEntrev" class="form-control pl-3 mr-3" placeholder="Coordenada X" />
                                        <button class="btn btn-ssc btn-sm" id="buscar_domEntrev">Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--campos del formulario principal-->
                        <div class="col-12">
                            <div class="row">
                                <div class="form-group col-6 col-lg-6">
                                    <label for="id_colonia_domEntrev" class="label-form">Colonia:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_colonia_domEntrev" name="Colonia_Dom_Entrev" >
                                    <small id="error_colonia_domEntrev" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-6 col-lg-6">
                                    <label for="id_calle_1_domEntrev" class="label-form">Calle:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_calle_1_domEntrev" name="Calle_1_Dom_Entrev" >
                                    <small id="error_calle_1_domEntrev" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-6 col-lg-3">
                                    <label for="id_no_ext_domEntrev" class="label-form">Núm. Exterior:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_no_ext_domEntrev" name="No_Ext_Dom_Entrev" >
                                    <small id="error_no_ext_domEntrev" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-6 col-lg-3">
                                    <label for="id_no_int_domEntrev" class="label-form">Núm. Interior:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_no_int_domEntrev" name="No_Int_Dom_Entrev" >
                                    <small id="error_no_int_domEntrev" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-6 col-lg-3">
                                    <label for="id_coord_x_domEntrev" class="label-form">Coordenada X:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_coord_x_domEntrev" name="Coordenada_X_Dom_Entrev"  >
                                    <small id="error_coord_x_domEntrev" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-6 col-lg-3">
                                    <label for="id_coord_y_domEntrev" class="label-form">Coordenada Y:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_coord_y_domEntrev" name="Coordenada_Y_Dom_Entrev"  >
                                    <small id="error_coord_y_domEntrev" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-6 col-lg-4">
                                    <label for="id_estado_domEntrev" class="label-form">Estado:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_estado_domEntrev" name="Estado_Dom_Entrev"  >
                                    <small id="error_estado_domEntrev" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-6 col-lg-4">
                                    <label for="id_municipio_domEntrev" class="label-form">Municipio:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_municipio_domEntrev" name="Municipio_Dom_Entrev"  >
                                    <small id="error_municipio_domEntrev" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-6 col-lg-4">
                                    <label for="id_cp_domEntrev" class="label-form">C.P.:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_cp_domEntrev" name="CP_Dom_Entrev"  >
                                    <small id="error_cp_domEntrev" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-12">
                                    <label for="id_referencias_domEntrev" class="label-form">Referencias:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_referencias_domEntrev" name="Referencias_Dom_Entrev">
                                    <small id="error_referencias_domEntrev" class="form-text text-danger "></small>
                                </div>
                                <!-- <input type="hidden" class="mi_hide text-uppercase" id="id_cp_domEntrev" name="CP_Dom_Entrev" readonly> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!--mapa-->
                <div class="col-12 col-lg-6" id="id_map_1">
                </div>

            </div>
        </div>
        <!-- RELATO DE LA ENTREVISTA -->
        <div class="col 12 mt-4">
            <div class="row">
                <div class="col-12 text-center mt-2 mb-2">
                    <div class="text-divider">
                        <h6 class="sub_header">Relato de la entrevista</h6>
                    </div>
                </div>
                <div class="form-group col-12">
                    <label for="id_relato_entrevista" class="label-form">Relato de la entrevista:</label>
                    <textarea class="form-control text-uppercase"  id="id_relato_entrevista" name="Relato_Entrevista" rows="3" maxlength="50000"></textarea>
                    <small id="error_relato_entrevista" class="form-text text-danger "></small>
                </div>
            </div>
        </div>
        <!--TRASLADO DE LA PERSONA ENTREVISTADA-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-2 mb-2">
                    <div class="text-divider">
                        <h6 class="sub_header">Datos del lugar del traslado o canalización de la persona entrevistada</h6>
                    </div>
                </div>
                <!-- ¿Presenta info de un familiar? -->
                <div class="col-12">
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <span class="label-form">
                                ¿Trasladó o canalizó a la persona entrevistada?
                            </span>
                        </div>
                        <div class="col-auto ml-auto">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Canalizacion" id="id_canalizacion_1" value="0" onchange="changeTraslado(event)">
                                <label class="form-check-label" for="id_canalizacion_1">No</label>
                            </div>
                        </div>
                        <div class="col-auto mr-auto">
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="Canalizacion" id="id_canalizacion_2" value="1"  onchange="changeTraslado(event)">
                                <label class="form-check-label" for="id_canalizacion_2">Sí</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <small class="form-text text-danger " id="error_canalizacion"></small>
                        </div>
                    </div>
                </div>
                <!-- traslado panel -->
                <div class="col-12 mi_hide" id="id_traslado_panel">
                    <div class="row">
                        <!-- Lugar de traslado -->
                        <div class="col-6 col-md-4 ml-auto">
                            <label for="id_lugar_canalizacion" class="label-form">Lugar de traslado o canalización:</label>
                            <select class="form-control form-control-sm" id="id_lugar_canalizacion" name="Lugar_Canalizacion">
                                <option class="text-muted" value="" disabled selected>Elige una opción</option>
                                <option value="Fiscalía/Agencia">Fiscalía/Agencia</option>
                                <option value="Hospital">Hospital</option>
                                <option value="Otra dependencia">Otra dependencia</option>
                            </select>
                            <small id="error_lugar_canalizacion" class="form-text text-danger "></small>
                        </div>
                        <!-- Descripción del lugar de traslado -->
                        <div class="form-group col-6 col-md-4 mr-auto">
                            <label for="id_descripcion_canalizacion" class="label-form">¿Cuál?:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_descripcion_canalizacion" name="Descripcion_Canalizacion" >
                            <small id="error_descripcion_canalizacion" class="form-text text-danger "></small>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
        <!--CONSTANCIA DE LECTURA DE DERECHOS DEL ENTREVISTADO-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-2 mb-2">
                    <div class="text-divider">
                        <h6 class="sub_header">Constancia de lectura de derechos, SÓLO en caso de víctima u ofendido</h6>
                    </div>
                </div>
                <!-- Lectura de Derechos button -->
                <div class="col-12 text-center my-4">
                    <button type="button" class="btn  btn-ssc" data-toggle="modal" data-target="#derechosModal">
                        <span class="v-a-middle">Derechos</span>
                        <span class="v-a-middle material-icons">
                            menu_book
                        </span>
                    </button>
                </div>
                
                <!-- Modal Derechos Entrevistado -->
                <div class="modal fade" id="derechosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <p>Artículo 20 apartado C de la Constitución Política de los Estados Unidos Mexicanos y artículos 109 del Código Nacional de Procedimientos Penales y 7 de la Ley General de Víctimas. Indique a la víctima u ofendido que tiene derecho a:</p>
                                <p>1. Recibir asesoría jurídica; ser informado de los derechos que en su favor establece la Constitución y, cuando lo solicite, ser informado del desarrollo del procedimiento penal.</p>
                                <p>2. Recibir desde la comisión del delito, atención médica y psicológica de urgencia.</p>
                                <p>3. Comunicarse inmediatamente después de haberse cometido el delito con un familiar, incluso con su asesor jurídico.</p>
                                <p>4. Ser tratado con respeto y dignidad.</p>
                                <p>5. Contar con un asesor jurídico gratuito en cualquier etapa del procedimiento, en los términos de la legislación aplicable.</p>
                                <p>6. Acceder a la justicia de manera pronta, gratuita e imparcial respecto de sus denuncias o querellas.</p>
                                <p>7. Recibir gratuitamente la asistencia de un intérprete o traductor.</p>
                                <p>8. Que se le proporcione asistencia migratoria cuando tenga otra nacionalidad.</p>
                                <p>9. Que se resguarde su identidad y datos personales, en los términos que establece la ley.</p>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--PRIMER RESPONDIENTE-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-2 mb-2">
                    <div class="text-divider">
                        <h6 class="sub_header">Datos del primer respondiente que realizó la detención</h6>
                    </div>
                </div>
                <!-- Coincidencia del primer respondiente -->
                <div class="col-12">
                    <div class="row mt-3">
                        <div class="col-12 text-center label-form ml-auto">¿El primer respondiente es diferente a quien firmó la puesta a disposición (primer respondiente de la puesta)?  </div>
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
                                <input type="text" class="form-control text-uppercase form-control-sm" placeholder="Ingrese el número de control, placa ó apellidos del elemento" id="element_search_1">
                                <div class="input-group-append">
                                    <button class="btn btn-ssc btn-sm" type="button" id="button_search_1">Buscar</button>
                                </div>
                            </div>  
                            <div class="col-lg-6 offset-lg-3 mb-3" id="list_elements_search_1">
                            </div>
                        </div>
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
                        <!-- Institucion_PR-->
                        <div class="form-group col-6 col-md-2">
                            <label for="id_institucion" class="label-form">Adscripción:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_institucion_pr" name="Institucion_PR" >
                            <small id="error_institucion_pr" class="form-text text-danger "></small>
                        </div>
                        <!-- Cargo_PR -->
                        <div class="form-group col-6 col-md-3">
                            <label for="id_cargo" class="label-form">Cargo/grado:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_cargo_pr" name="Cargo_PR" >
                            <small id="error_cargo_pr" class="form-text text-danger "></small>
                        </div>
                        <input type="hidden" value="320672" name="No_Control_PR" id="id_no_control_pr">
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
                    <button type="button" class="btn btn-ssc" onclick="checkFormAnexoE(event)" id="guardar_crear">Guardar</button>
                </div>
            </div>
        </div>
    </div>

</div>