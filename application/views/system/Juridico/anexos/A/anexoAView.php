<div class="container">
    <!--header of anexo A-->
    <div class="row mt-5">
        <div class="col-auto my-auto">
            <button class="btn btn-sm back-btn mb-3 d-flex justify-content-center my-auto" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="goToBack()">
                <i class="material-icons">arrow_back</i>
            </button>
        </div>
        <div class="col-auto my-auto mr-auto">
            <h5 class="title-width my-auto">
                <span>Anexo A - DETENCIÓN(ES)</span> 
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

    <form id="id_form_anexo_a" class="row" onsubmit="return mySubmitFunction(event)">
        <!-- Id de la puesta si se trata de edición -->
        <input type="hidden" id="id_puesta" name="Id_Puesta" value="<?= $data['id_puesta']?>">
        <!-- Id del detenido (si existe) -->
        <input type="hidden" id="id_detenido" name="Id_Detenido" value="<?= $data['id_detenido']?>">
        <!--NUM DETENCIÓN y FECHA/HORA-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-2 mb-2">
                    <div class="text-divider">
                        <h6 class="sub_header">Número y fecha/hora de la detención</h6>
                    </div>
                </div>
                <div class="col-12 text-right">
                    <a href="javascript:ventanaSecundaria('https://www.gob.mx/curp/')" class="url">Consulta CURP</a>
                </div>
                <div class="form-group col-12 col-md-4">
                        <label for="id_num_detencion" class="label-form">Número de detención*:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="id_num_detencion" name="Num_Detencion" >
                        <small id="error_num_detencion" class="form-text text-danger "></small>
                </div>

                <div class="form-group col-12 col-md-4">
                    <label for="id_fecha" class="label-form">Fecha*:</label>
                    <input type="date" class="form-control form-control-sm" id="id_fecha" name="Fecha" value="<?php echo date('Y-m-d') ?>" >
                    <small id="error_fecha" class="form-text text-danger "></small>
                </div>
                <div class="form-group col-12 col-md-4">
                    <label for="id_hora" class="label-form">Hora*:</label>
                    <input type="time" class="form-control form-control-sm" id="id_hora" name="Hora" value="<?php echo date('H:i')?>" >
                    <small id="error_hora" class="form-text text-danger "></small>
                </div>

            </div>
        </div>
        <!--DATOS GENERALES DETENIDO-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-2 mb-2">
                    <div class="text-divider">
                        <h6 class="sub_header">Datos generales de la persona detenida</h6>
                    </div>
                </div>
                <!-- nombre detenido -->
                <div class="form-group col-12 col-md-6 col-lg-3">
                    <label for="id_nombre_d" class="label-form">Nombre(s)*:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_nombre_d" name="Nombre_D" >
                    <small id="error_nombre_d" class="form-text text-danger "></small>
                </div>
                <!-- ap paterno detenido -->
                <div class="form-group col-12 col-md-6 col-lg-3">
                    <label for="id_ap_pat_d" class="label-form">Apellido paterno*:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_ap_pat_d" name="Ap_Paterno_D" >
                    <small id="error_ap_pat_d" class="form-text text-danger "></small>
                </div>
                <!-- ap materno detenido -->
                <div class="form-group col-12 col-md-6 col-lg-3">
                    <label for="id_ap_mat_d" class="label-form">Apellido materno*:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_ap_mat_d" name="Ap_Materno_D" >
                    <small id="error_ap_mat_d" class="form-text text-danger "></small>
                </div>
                <!-- apodo detenido -->
                <div class="form-group col-12 col-md-6 col-lg-3">
                    <label for="id_apodo" class="label-form">Apodo/alias:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_apodo" name="Apodo" >
                    <small id="error_apodo" class="form-text text-danger "></small>
                </div>
                <!-- nacionalidad -->
                <div class="col-12 col-md-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="row mt-3">
                                <div class="col-4 label-form">Nacionalidad: </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Nacionalidad_Radio" id="id_nacionalidad_1" onchange="return changeNacionalidad(event)" value="MEXICANA" checked>
                                        <label class="form-check-label" for="id_nacionalidad_1">MEXICANA</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" name="Nacionalidad_Radio" id="id_nacionalidad_2" onchange="return changeNacionalidad(event)" value="EXTRANJERA" >
                                        <label class="form-check-label" for="id_nacionalidad_2">EXTRANJERA</label>
                                    </div>
                                </div>
                                <div class="col-8 offset-4">
                                    <small id="error_nacionalidad_radio" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mi_hide" id="id_nacionalidad_otro_panel">
                            <div class="row mt-3">
                                <div class="col-auto my-auto">
                                    <span class="label-form">¿cuál?: </span>
                                </div>
                                <div class="col-auto">
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_nacionalidad_otro" name="Nacionalidad_Otro" maxlength="1000">
                                    <small id="error_nacionalidad_otro" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                </div>
                <!-- Sexo -->
                <div class="form-group col-12 col-md-6 col-lg-2">
                    <label for="id_genero" class="label-form">Sexo*:</label>
                    <select class="form-control form-control-sm" id="id_genero" name="Genero" >
                        <option value="H">HOMBRE</option>
                        <option value="M">MUJER</option>
                    </select>
                    <small id="error_genero" class="form-text text-danger "></small>
                </div>
                <!-- fecha de nacimiento -->
                <div class="form-group col-12 col-md-6 col-lg-3">
                    <label for="id_fecha_nacimiento" class="label-form">Fecha de nacimiento*:</label>
                    <input type="date" class="form-control form-control-sm" id="id_fecha_nacimiento" name="Fecha_Nacimiento" value="" >
                    <small id="error_fecha_nacimiento" class="form-text text-danger "></small>
                </div>
                <!-- edad -->
                <div class="form-group col-12 col-md-6 col-lg-1">
                    <label for="id_edad" class="label-form">Edad*:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_edad" name="Edad" onkeypress="return soloNumeros(event)" maxlength = "2"  readonly>
                    <small id="error_edad" class="form-text text-danger "></small>
                </div>
                <!-- identificación select -->
                <div class="form-group col-12 col-md-6 col-lg-4">
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
                <div class="form-group col-12 col-md-6 col-lg-4 mi_hide" id="id_identificacion_panel">
                    <label for="id_identificacion_otro" class="label-form">¿Cuál?:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_identificacion_otro" name="Identificacion_Otro" >
                    <small id="error_identificacion_otro" class="form-text text-danger "></small>
                </div>
                <!-- num identificación -->
                <div class="form-group col-12 col-md-6 col-lg-4">
                    <label for="id_num_identificacion" class="label-form">Número de identificación:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_num_identificacion" name="Num_Identificacion" >
                    <small id="error_num_identificacion" class="form-text text-danger "></small>
                </div>
                
            </div>
        </div>
        <!--DOMICILIO DETENIDO-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-3 mb-2">
                    <div class="text-divider">
                        <h6 class="sub_header">Domicilio del detenido</h6>
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
                                        <input type="radio" id="por_direccion_domDetenido_radio" name="busqueda" data-id="domDetenido" class="custom-control-input" value="0">
                                        <label class="custom-control-label label-form" for="por_direccion_domDetenido_radio">Dirección</label>
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="por_coordenadas_domDetenido_radio" name="busqueda" data-id="domDetenido" class="custom-control-input" value="1">
                                        <label class="custom-control-label label-form" for="por_coordenadas_domDetenido_radio">Coordenadas</label>
                                    </div>
                                </div>
                                <!-- Inputs de cada búsqueda -->
                                <div class="form-group col-12" id="por_direccion_domDetenido">
                                    <div class="input-group input-group-sm">
                                        <input type="search" name="dir_domDetenido" id="dir_domDetenido" class="form-control" placeholder="Ingrese una dirección a buscar" />
                                    </div>
                                </div>

                                <div class="form-group col-12" id="por_coordenadas_domDetenido">
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="search_cy_domDetenido" id="search_cy_domDetenido" class="form-control pr-3 mr-3" placeholder="Coordenada Y" />
                                        <input type="text" name="search_cx_domDetenido" id="search_cx_domDetenido" class="form-control pl-3 mr-3" placeholder="Coordenada X" />
                                        <button class="btn btn-ssc btn-sm" id="buscar_domDetenido">Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--campos del formulario principal-->
                        <div class="col-12">
                            <div class="row">
                                <div class="form-group col-12 col-lg-6">
                                    <label for="id_colonia_domDetenido" class="label-form">Colonia:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_colonia_domDetenido" name="Colonia_Dom_Detenido" >
                                    <small id="error_colonia_domDetenido" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label for="id_calle_1_domDetenido" class="label-form">Calle:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_calle_1_domDetenido" name="Calle_1_Dom_Detenido" >
                                    <small id="error_calle_1_domDetenido" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-12 col-lg-3">
                                    <label for="id_no_ext_domDetenido" class="label-form">Núm. Exterior:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_no_ext_domDetenido" name="No_Ext_Dom_Detenido" >
                                    <small id="error_no_ext_domDetenido" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-12 col-lg-3">
                                    <label for="id_no_int_domDetenido" class="label-form">Núm. Interior:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_no_int_domDetenido" name="No_Int_Dom_Detenido" >
                                    <small id="error_no_int_domDetenido" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-12 col-lg-3">
                                    <label for="id_coord_x_domDetenido" class="label-form">Coordenada X:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_coord_x_domDetenido" name="Coordenada_X_Dom_Detenido" >
                                    <small id="error_coord_x_domDetenido" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-12 col-lg-3">
                                    <label for="id_coord_y_domDetenido" class="label-form">Coordenada Y:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_coord_y_domDetenido" name="Coordenada_Y_Dom_Detenido" >
                                    <small id="error_coord_y_domDetenido" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-12 col-lg-4">
                                    <label for="id_estado_domDetenido" class="label-form">Estado:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_estado_domDetenido" name="Estado_Dom_Detenido" >
                                    <small id="error_estado_domDetenido" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-12 col-lg-4">
                                    <label for="id_municipio_domDetenido" class="label-form">Municipio:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_municipio_domDetenido" name="Municipio_Dom_Detenido" >
                                    <small id="error_municipio_domDetenido" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-12 col-lg-4">
                                    <label for="id_cp_domDetenido" class="label-form">C.P.:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_cp_domDetenido" name="CP_Dom_Detenido" >
                                    <small id="error_cp_domDetenido" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-12">
                                    <label for="id_referencias_domDetenido" class="label-form">Referencias:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_referencias_domDetenido" name="Referencias_Dom">
                                    <small id="error_referencias_domDetenido" class="form-text text-danger "></small>
                                </div>
                                <!-- <input type="hidden" class="mi_hide text-uppercase" id="id_cp_domDetenido" name="CP_Dom_Detenido" readonly> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!--mapa-->
                <div class="col-12 col-lg-6" id="id_map_1">
                </div>

            </div>
        </div>
        <!--INFO ADICIONAL-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-2 mb-2">
                    <div class="text-divider">
                        <h6 class="sub_header">Información adicional del detenido</h6>
                    </div>
                </div>
                <div class="form-group col-12">
                    <label for="id_descripcion_detenido" class="label-form">Describa brevemente a la persona detenida, incluyendo tipo de vestimenta y rasgos visibles (barba, tatuajes, cicatrices, lunares, bigote, etcétera).*:</label>
                    <textarea class="form-control text-uppercase"  id="id_descripcion_detenido" name="Descripcion_Detenido" rows="3" maxlength="10000"></textarea>
                    <small id="error_descripcion_detenido" class="form-text text-danger "></small>
                </div>
                <!-- lesiones -->
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-6 ">
                            <span>¿La persona detenida presenta lesiones visibles?</span>
                        </div>
                        <!-- Lesiones -->
                        <div class="col-3 col-md-auto">
                            <div class="row mt-3 my-auto">
                                <div class="col-auto">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Lesiones" id="id_lesiones_1" value="No" >
                                        <label class="form-check-label" for="id_lesiones_1">No</label>
                                    </div>
                                </div>
                                <div class="col-auto mr-auto">
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" name="Lesiones" id="id_lesiones_2" value="Sí" >
                                        <label class="form-check-label" for="id_lesiones_2">Sí</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <small id="error_lesiones_radio" class="text-danger"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- manifiesta padecimiento -->
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-6 ">
                            <span>¿Manifiesta tener algún padecimiento?</span>
                        </div>
                        <div class="col-3 col-md-auto my-auto">
                            <div class="row mt-3 my-auto">
                                <div class="col-auto">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Padecimiento_Radio" id="id_padecimiento_1" value="No"  onchange="changePadecimientos(event)">
                                        <label class="form-check-label" for="id_padecimiento_1">No</label>
                                    </div>
                                </div>
                                <div class="col-auto mr-auto">
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" name="Padecimiento_Radio" id="id_padecimiento_2" value="Sí"  onchange="changePadecimientos(event)">
                                        <label class="form-check-label" for="id_padecimiento_2">Sí</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <small id="error_padecimiento_radio" class="text-danger"></small>
                                </div>
                            </div>
                        </div>

                        <div class="col-9 col-md-auto mi_hide" id="id_padecimiento_panel">
                            <div class="row">
                                <div class="col-auto my-auto">
                                    <span class="label-form">¿Cuál?:</span>
                                </div>
                                <div class="col-auto my-auto">
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_padecimiento" name="Descripcion_Padecimiento" >
                                    <small id="error_padecimiento" class="form-text text-danger "></small>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
                <!-- grupo vulnerable -->
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-6 ">
                            <span>¿La persona detenida se identificó como miembro de algún grupo vulnerable?</span>
                        </div>
                        <div class="col-3 col-md-auto my-auto">
                            <div class="row mt-3 my-auto">
                                <div class="col-auto">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Grupo_V_Radio" id="id_grupo_v_1" value="No"  onchange="changeGrupoV(event)">
                                        <label class="form-check-label" for="id_grupo_v_1">No</label>
                                    </div>
                                </div>
                                <div class="col-auto mr-auto">
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" name="Grupo_V_Radio" id="id_grupo_v_2" value="Sí"  onchange="changeGrupoV(event)">
                                        <label class="form-check-label" for="id_grupo_v_2">Sí</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <small id="error_grupo_v_radio" class="text-danger"></small>
                                </div>
                            </div>
                        </div>

                        <div class="col-9 col-md-auto mi_hide my-auto" id="id_grupo_v_panel">
                            <div class="row">
                                <div class="col-auto my-auto">
                                    <span class="label-form">¿Cuál?:</span>
                                </div>
                                <div class="col-auto">
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_grupo_v" name="Grupo_Vulnerable" >
                                    <small id="error_grupo_v" class="form-text text-danger "></small>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!-- grupo delictivo -->
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-6 ">
                            <span>¿La persona detenida se identificó como integrante de algún grupo delictivo?</span>
                        </div>
                        <div class="col-3 col-md-auto my-auto">
                            <div class="row mt-3 my-auto">
                                <div class="col-auto">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Grupo_D_Radio" id="id_grupo_d_1" value="No"  onchange="changeGrupoD(event)">
                                        <label class="form-check-label" for="id_grupo_d_1">No</label>
                                    </div>
                                </div>
                                <div class="col-auto mr-auto">
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" name="Grupo_D_Radio" id="id_grupo_d_2" value="Sí"  onchange="changeGrupoD(event)">
                                        <label class="form-check-label" for="id_grupo_d_2">Sí</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <small id="error_grupo_d_radio" class="text-danger"></small>
                                </div>
                            </div>
                        </div>

                        <div class="col-9 col-md-auto mi_hide my-auto" id="id_grupo_d_panel">
                            <div class="row">
                                <div class="col-auto my-auto">
                                    <span class="label-form">¿Cuál?:</span>
                                </div>
                                <div class="col-auto">
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_grupo_d" name="Grupo_Delictivo" >
                                    <small id="error_grupo_d" class="form-text text-danger "></small>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--FAMILIAR O CONTACTO DEL DETENIDO-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-2 mb-2">
                    <div class="text-divider">
                        <h6 class="sub_header">Datos del familiar o persona de confianza señalado por la persona detenida</h6>
                    </div>
                </div>
                <!-- ¿Presenta info de un familiar? -->
                <div class="col-12">
                    <div class="row mt-3">
                        <div class="col-auto ml-auto">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Familiar_Radio" id="id_familiar_radio_1" value="No" checked onchange="changeFamiliarRadio(event)">
                                <label class="form-check-label" for="id_familiar_radio_1">No proporcionado</label>
                            </div>
                        </div>
                        <div class="col-auto mr-auto">
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="Familiar_Radio" id="id_familiar_radio_2" value="Sí"  onchange="changeFamiliarRadio(event)">
                                <label class="form-check-label" for="id_familiar_radio_2">Proporcionado</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <small class="form-text text-danger " id="error_familiar_radio"></small>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3 mi_hide" id="id_familiar_panel">
                    <div class="row">
                        <!-- nombre familiar -->
                        <div class="form-group col-12 col-md-6 col-lg-3">
                            <label for="id_nombre_f" class="label-form">Nombre(s):</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_nombre_f" name="Nombre_F" >
                            <small id="error_nombre_f" class="form-text text-danger "></small>
                        </div>
                        <!-- ap paterno familiar -->
                        <div class="form-group col-12 col-md-6 col-lg-3">
                            <label for="id_ap_pat_f" class="label-form">Apellido paterno:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_ap_pat_f" name="Ap_Paterno_F" >
                            <small id="error_ap_pat_f" class="form-text text-danger "></small>
                        </div>
                        <!-- ap materno familiar -->
                        <div class="form-group col-12 col-md-6 col-lg-3">
                            <label for="id_ap_mat_f" class="label-form">Apellido materno:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_ap_mat_f" name="Ap_Materno_F" >
                            <small id="error_ap_mat_f" class="form-text text-danger "></small>
                        </div>
                        <!-- telefono familiar -->
                        <div class="form-group col-12 col-md-6 col-lg-3">
                            <label for="id_telefono_f" class="label-form">Teléfono:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_telefono_f" name="Telefono_F" onkeypress="return soloNumeros(event)" maxlength = "10">
                            <small id="error_telefono_f" class="form-text text-danger "></small>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <!--CONSTANCIA DE LECTURA DE DERECHOS DEL DETENIDO-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-2 mb-2">
                    <div class="text-divider">
                        <h6 class="sub_header">Constancia de lectura de derechos de la persona detenida</h6>
                    </div>
                </div>
                <!-- Lectura de Derechos button -->
                <div class="col-12 text-center">
                    <button type="button" class="btn derechos-btn" data-toggle="modal" data-target="#derechosModal">
                        <span class="v-a-middle">Derechos del detenido</span>
                        <span class="v-a-middle material-icons">
                            menu_book
                        </span>
                    </button>
                </div>
                <!-- Lectura de Derechos Radio Button -->
                <div class="col-12">
                    <div class="row mt-3">
                        <div class="col-auto label-form ml-auto">¿Le informó sus derechos a la persona detenida? </div>
                        <div class="col-auto">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Lectura_Derechos" id="id_lectura_derechos_1" value="No">
                                <label class="form-check-label" for="id_lectura_derechos_1">No</label>
                            </div>
                        </div>
                        <div class="col-auto mr-auto">
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="Lectura_Derechos" id="id_lectura_derechos_2" value="Sí" checked>
                                <label class="form-check-label" for="id_lectura_derechos_2">Sí</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <small id="error_derechos_radio" class="form-text text-danger"></small>
                        </div>
                    </div>
                </div>
                
                <!-- Modal Derechos Detenido -->
                <div class="modal fade" id="derechosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <p>Artículo 20 apartado B de la Constitución Política de los Estados Unidos Mexicanos y artículo 152 del Código Nacional de Procedimientos Penales</p>
                                <p>Informe a la persona detenida: </p>
                                <p>1. Usted tiene derecho a conocer el motivo de su detención. </p>
                                <p>2. Usted tiene derecho a guardar silencio. </p>
                                <p>3. Usted tiene derecho a declarar, y en caso de hacerlo, lo hará asistido de su defensor ante la autoridad competente. </p>
                                <p>4. Usted tiene derecho a ser asistido por un defensor, si no quiere o no puede hacerlo, le será designado un defensor público. </p>
                                <p>5. Usted tiene derecho a hacer del conocimiento a un familiar o persona que desee, los hechos de su detención y el lugar de custodia en que se halle en cada momento. </p>
                                <p>6. Usted es considerado inocente desde este momento hasta que se determine lo contrario. </p>
                                <p>7. En caso de ser extranjero, Usted tiene derecho a que el consulado de su país sea notificado de su detención. </p>
                                <p>8. Usted tiene derecho a un traductor o intérprete, el cual será proporcionado por el Estado. </p>
                                <p>9. Usted tiene derecho a ser presentado ante el Ministerio Público o Juez de Control, según sea el caso, inmediatamente después de ser detenido o aprehendido. </p>
                                <p>Si la persona detenida es un adolescente, infórmele también: </p>
                                <p>10. Usted tiene derecho a permanecer en un lugar distinto al de los adultos. </p>
                                <p>11. Usted tiene derecho a un trato digno y de conformidad con su condición de adolescente. </p>
                                <p>12. Usted tiene derecho a que la autoridad informe sobre su detención a la procuraduría federal o local de protección de niñas, niños y adolescentes. </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--INSPECCIÓN A LA PERSONA DETENIDA-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-2 mb-2">
                    <div class="text-divider">
                        <h6 class="sub_header">Inspección a la persona detenida</h6>
                    </div>
                </div>
                <!-- objeto relacionado con los hechos -->
                <div class="col-12 my-auto mx-auto">
                    <div class="row mt-3">
                        <div class="col-auto label-form">Al momento de realizar la inspección a la persona detenida, ¿le encontró algún objeto relacionado con los hechos? </div>
                        <div class="col-auto">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Objeto_Encontrado" id="id_obj_encontrado_1" value="No" checked>
                                <label class="form-check-label" for="id_obj_encontrado_1">No</label>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="Objeto_Encontrado" id="id_obj_encontrado_2" value="Sí" >
                                <label class="form-check-label" for="id_obj_encontrado_2">Sí</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <small id="error_obj_encontrado_radio" class="text-danger"></small>
                        </div>
                    </div>
                </div>
                <!-- ¿se le adjuntan pertenencias? -->
                <div class="col-12 my-auto mx-auto">
                    <div class="row mt-3">
                        <div class="col-auto label-form">¿Recolectó pertenencias de la persona detenida? </div>
                        <div class="col-auto">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Pertenencias_Encontradas" id="id_pert_econtradas_1" value="No" checked onchange="changePertenenciasRadio(event)">
                                <label class="form-check-label" for="id_pert_econtradas_1">No</label>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="Pertenencias_Encontradas" id="id_pert_econtradas_2" value="Sí"  onchange="changePertenenciasRadio(event)">
                                <label class="form-check-label" for="id_pert_econtradas_2">Sí</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <small id="error_pert_encontrado_radio" class="text-danger"></small>
                        </div>
                    </div>
                </div>

                <!-- Panel de Pertenencias -->
                <div class="col-12 mt-4 mi_hide" id="id_pertenencias_panel">
                    <div class="row">
                        <!-- campos de pertenencias -->
                        <div class="col-12">
                            <div class="row">
                                <!-- Alerts pertenencias -->
                                <div class="col-12 alert alert-warning mi_hide" role="alert" id="id_edit_p_mode">
                                    Esta en modo de editar pertenencia. Da click en "Guardar cambios" para que se vea reflejado en la tabla de pertenencias o en su defecto da click en "Cancelar"
                                </div>
                                <div class="col-12 alert alert-danger mi_hide" role="alert" id="id_error_p_mode">
                                    Agrega al menos una pertenencia o selecciona "No" en la pregunta anterior
                                </div>
                                <!-- pertenencia -->
                                <div class="form-group col-12 col-lg-3 ">
                                    <label for="id_pertenencia" class="label-form">Pertenencia:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_pertenencia" name="Pertenencia">
                                    <small id="error_pertenencia" class="form-text text-danger "></small>
                                </div>
                                <!-- descripción pertenencia -->
                                <div class="form-group col-12 col-lg-3 ">
                                    <label for="id_descripcion" class="label-form">Breve descripción:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_descripcion" name="Descripcion">
                                    <small id="error_descripcion" class="form-text text-danger "></small>
                                </div>
                                <!-- destino que se le dio -->
                                <div class="form-group col-12 col-lg-3 ">
                                    <label for="id_destino" class="label-form">Destino que se le dio:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_destino" name="Destino">
                                    <small id="error_destino" class="form-text text-danger "></small>
                                </div>

                                <div class="col-12 col-lg-3 text-center my-auto">
                                    <button type="button" class="btn btn-sm add-btn" id="id_btn_add_pert">
                                        Agregar a la tabla
                                    </button>
                                    <button type="button" class="btn btn-sm add-btn mi_hide" id="id_btn_edit_pert">
                                        Guardar cambios
                                    </button>
                                    <button type="button" class="btn btn-sm btn-secondary mi_hide" id="id_btn_cancel_pert">
                                        Cancelar
                                    </button>
                                    <input type="hidden" value="-1" id="id_pertenencia_edit">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2 mt-lg-1 table-responsive-sm">
                            <h6 class="text-center">Tabla de pertenencias que se adjuntan. Aquí se iran enlistando todas las pertenencias que se agreguen llenando los campos de arriba</h6>
                            <table class="table table-sm" id="id_persona_table">
                                <thead >
                                    <th>Pertenencia</th>
                                    <th>Descripción</th>
                                    <th>Destino</th>
                                    <th class="sticky_head">Operaciones</th>
                                </thead>
                                <tbody id="id_tbody_pertenencias">
                                </tbody>
                            </table>
                        </div>
                    </div>
                        
                </div>
                
                
            </div>
        </div>
        <!--UBICACIÓN DETENCIÓN-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-3 mb-2">
                    <div class="text-divider">
                        <h6 class="sub_header">Datos del lugar de la detención</h6>
                    </div>
                </div>
                <!-- ¿ubicación igual que la intervención? -->
                <div class="col-12">
                    <div class="row mt-3" >
                        <div class="col-auto label-form ml-auto">¿El lugar de la detención es el mismo que el de la intervención?</div>
                        <div class="col-auto ">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Ubicacion_Det_Radio" id="id_ubicacion_det_radio_1" value="No" onchange="changeUbicacionDetRadio(event)">
                                <label class="form-check-label" for="id_ubicacion_det_radio_1">No</label>
                            </div>
                        </div>
                        <div class="col-auto mr-auto">
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="Ubicacion_Det_Radio" id="id_ubicacion_det_radio_2" value="Sí"  onchange="changeUbicacionDetRadio(event)">
                                <label class="form-check-label" for="id_ubicacion_det_radio_2">Sí</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <small class="form-text text-danger" id="error_ubicacion_det_radio"></small>
                        </div>
                    </div>
                </div>
                <!-- form ubicación detención -->
                <div class="col-12 mt-3 mi_hide" id="id_ubicacion_det_panel">
                    <div class="row">
                        <!--campos de la ubicación-->
                        <div class="col-12 col-lg-6" >
                            <div class="row">
                                <!--busqueda dinámica de Google maps-->
                                <div class="col-12">
                                    <div class="row" id="id_busqueda_por_panel_2">
                                        <div class="col-12 mb-2">
                                            <span class="label-form">Buscar por:</span>
                                        </div>
                                        
                                        <!-- radios búsqueda por -->
                                        <div class="form-group col-12">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="por_direccion_ubi_detencion_radio" name="busqueda" data-id="ubi_detencion" class="custom-control-input" value="0">
                                                <label class="custom-control-label label-form" for="por_direccion_ubi_detencion_radio">Dirección</label>
                                            </div>

                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="por_coordenadas_ubi_detencion_radio" name="busqueda" data-id="ubi_detencion" class="custom-control-input" value="1">
                                                <label class="custom-control-label label-form" for="por_coordenadas_ubi_detencion_radio">Coordenadas</label>
                                            </div>
                                        </div>
                                        <!-- Inputs de cada búsqueda -->
                                        <div class="form-group col-12" id="por_direccion_ubi_detencion">
                                            <div class="input-group input-group-sm">
                                                <input type="search" name="dir_ubi_detencion" id="dir_ubi_detencion" class="form-control" placeholder="Ingrese una dirección a buscar" />
                                            </div>
                                        </div>

                                        <div class="form-group col-12" id="por_coordenadas_ubi_detencion">
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="search_cy_ubi_detencion" id="search_cy_ubi_detencion" class="form-control pr-3 mr-3" placeholder="Coordenada Y" />
                                                <input type="text" name="search_cx_ubi_detencion" id="search_cx_ubi_detencion" class="form-control pl-3 mr-3" placeholder="Coordenada X" />
                                                <button class="btn btn-ssc btn-sm" id="buscar_ubi_detencion">Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--campos del formulario principal-->
                                <div class="col-12">
                                    <div class="row">
                                        <div class="form-group col-12 col-lg-6">
                                            <label for="id_colonia_ubi_detencion" class="label-form">Colonia:</label>
                                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_colonia_ubi_detencion" name="Colonia_Ubi_Det" >
                                            <small id="error_colonia_ubi_detencion" class="form-text text-danger "></small>
                                        </div>
                                        <div class="form-group col-12 col-lg-6">
                                            <label for="id_calle_1_ubi_detencion" class="label-form">Calle 1:</label>
                                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_calle_1_ubi_detencion" name="Calle_1_Ubi_Det" >
                                            <small id="error_calle_1_ubi_detencion" class="form-text text-danger "></small>
                                        </div>
                                        <div class="form-group col-12 col-lg-6">
                                            <label for="id_calle_2_ubi_detencion" class="label-form">Calle 2:</label>
                                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_calle_2_ubi_detencion" name="Calle_2_Ubi_Det" >
                                            <small id="error_calle_2_ubi_detencion" class="form-text text-danger "></small>
                                        </div>
                                        <div class="form-group col-12 col-lg-3">
                                            <label for="id_no_ext_ubi_detencion" class="label-form">Núm. Exterior:</label>
                                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_no_ext_ubi_detencion" name="No_Ext_Ubi_Det" >
                                            <small id="error_no_ext_ubi_detencion" class="form-text text-danger "></small>
                                        </div>
                                        <div class="form-group col-12 col-lg-3">
                                            <label for="id_no_int_ubi_detencion" class="label-form">Núm. Interior:</label>
                                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_no_int_ubi_detencion" name="No_Int_Ubi_Det" >
                                            <small id="error_no_int_ubi_detencion" class="form-text text-danger "></small>
                                        </div>
                                        <div class="form-group col-12 col-lg-3">
                                            <label for="id_coord_x_ubi_detencion" class="label-form">Coordenada X:</label>
                                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_coord_x_ubi_detencion" name="Coordenada_X_Ubi_Det"  readonly>
                                            <small id="error_coord_x_ubi_detencion" class="form-text text-danger "></small>
                                        </div>
                                        <div class="form-group col-12 col-lg-3">
                                            <label for="id_coord_y_ubi_detencion" class="label-form">Coordenada Y:</label>
                                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_coord_y_ubi_detencion" name="Coordenada_Y_Ubi_Det"  readonly>
                                            <small id="error_coord_y_ubi_detencion" class="form-text text-danger "></small>
                                        </div>
                                        <div class="form-group col-12 col-lg-6">
                                            <label for="id_estado_ubi_detencion" class="label-form">Estado:</label>
                                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_estado_ubi_detencion" name="Estado_Ubi_Det"  readonly>
                                            <small id="error_estado_ubi_detencion" class="form-text text-danger "></small>
                                        </div>
                                        <div class="form-group col-12 col-lg-6">
                                            <label for="id_municipio_ubi_detencion" class="label-form">Municipio:</label>
                                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_municipio_ubi_detencion" name="Municipio_Ubi_Det"  readonly>
                                            <small id="error_municipio_ubi_detencion" class="form-text text-danger "></small>
                                        </div>
                                        <div class="form-group col-12 col-lg-6">
                                            <label for="id_cp_ubi_detencion" class="label-form">C.P.:</label>
                                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_cp_ubi_detencion" name="CP_Ubi_Det"  readonly>
                                            <small id="error_cp_ubi_detencion" class="form-text text-danger "></small>
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="id_referencias_ubi_detencion" class="label-form">Referencias:</label>
                                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_referencias_ubi_detencion" name="Referencias_Ubi_Det">
                                            <small id="error_referencias_ubi_detencion" class="form-text text-danger "></small>
                                        </div>
                                        <!-- <input type="hidden" class="mi_hide text-uppercase" id="id_cp_ubi_detencion" name="CP_Ubi_Det" readonly> -->

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--mapa-->
                        <div class="col-12 col-lg-6" id="id_map_2">
                        </div>
                    </div>
                </div>
                

            </div>
        </div>
        <!--TRASLADO DE LA PERSONA DETENIDA-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-2 mb-2">
                    <div class="text-divider">
                        <h6 class="sub_header">Datos del lugar del traslado de la persona detenida</h6>
                    </div>
                </div>
                <!-- Lugar de traslado -->
                <div class="col-6 col-md-4">
                    <label for="id_lugar_traslado" class="label-form">Lugar de traslado:</label>
                    <select class="form-control form-control-sm" id="id_lugar_traslado" name="Lugar_Traslado">
                        <option class="text-muted" value="" disabled selected>Elige una opción</option>
                        <option value="Fiscalía/Agencia">Fiscalía/Agencia</option>
                        <option value="Hospital">Hospital</option>
                        <option value="Otra dependencia">Otra dependencia</option>
                    </select>
                    <small id="error_lugar_traslado" class="form-text text-danger "></small>
                </div>
                <!-- Descripción del lugar de traslado -->
                <div class="form-group col-6 col-md-4">
                    <label for="id_desc_traslado" class="label-form">¿Cuál?:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_desc_traslado" name="Descripcion_Traslado" >
                    <small id="error_desc_traslado" class="form-text text-danger "></small>
                </div>
                <div class="form-group col-12">
                    <label for="id_obs_detencion" class="label-form">Describa brevemente la ruta y el medio de traslado desde el lugar de la detención hasta la puesta a disposición, así como la razón de posibles demoras. Incluya cualquier otra observación que considere relevante:</label>
                    <textarea class="form-control text-uppercase"  id="id_obs_detencion" name="Observaciones_Detencion" rows="3" maxlength="10000"></textarea>
                    <small id="error_obs_detencion" class="form-text text-danger "></small>
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
                                <input class="form-check-input" type="radio" name="Primer_Respondiente_Radio" id="id_primer_respondiente_radio_1" value="No" onchange="changePrimerResRadio(event)">
                                <label class="form-check-label" for="id_primer_respondiente_radio_1">No</label>
                            </div>
                        </div>
                        <div class="col-auto mr-auto">
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="Primer_Respondiente_Radio" id="id_primer_respondiente_radio_2" value="Sí" onchange="changePrimerResRadio(event)">
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
                                <input type="text" class="form-control text-uppercase" placeholder="Ingrese el número de control, placa ó apellidos del elemento" id="element_search_1">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="button_search_1">Buscar</button>
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
                        <!-- Institucion -->
                        <div class="form-group col-6 col-md-2">
                            <label for="id_institucion" class="label-form">Adscripción:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_institucion_pr" name="Institucion_PR" >
                            <small id="error_institucion_pr" class="form-text text-danger "></small>
                        </div>
                        <!-- Cargo -->
                        <div class="form-group col-6 col-md-3">
                            <label for="id_cargo" class="label-form">Cargo/grado:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_cargo_pr" name="Cargo_PR" >
                            <small id="error_cargo_pr" class="form-text text-danger "></small>
                        </div>
                        <input type="hidden" value="320672" name="No_Control_PR" id="id_no_control_pr">

                        <!-- SEGUNDO RESPONDIENTE buscador de elementos por no control  -->
                        <div class="col-12" id="id_busqueda_sr_panel">
                            <div class="input-group col-lg-6 offset-lg-3 my-2">
                                <input type="text" class="form-control text-uppercase" placeholder="Ingrese el número de control, placa ó apellidos del elemento" id="element_search_2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="button_search_2">Buscar</button>
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
                        <!-- Institucion -->
                        <div class="form-group col-6 col-md-2">
                            <label for="id_institucion" class="label-form">Adscripción:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_institucion_sr" name="Institucion_SR" >
                            <small id="error_institucion_sr" class="form-text text-danger "></small>
                        </div>
                        <!-- Cargo -->
                        <div class="form-group col-6 col-md-3">
                            <label for="id_cargo" class="label-form">Cargo/grado:</label>
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
                    <button type="button" class="btn btn-ssc" onclick="checkFormAnexoA(event)" id="guardar_crear">Guardar</button>
                </div>
            </div>
        </div>
    </div>

</div>