<div class="container">
    <!--header of inspección-->
    <div class="row mt-5">
        <div class="col-auto mr-auto my-auto">
            <h5 class="title-width my-auto">
                <a href="<?= base_url;?>Inspecciones">Inspecciones</a> 
                <span class="navegacion">/ Nueva</span>
            </h5>
        </div>
    </div>
    <!--result alert-->
    <div class="row mt-3 mi_hide" id="result_alert">
        <div class="alert alert-danger col-12" id="id_alert">
            
        </div>
    </div>
    <!--Inspección a...-->
    <div class="row mt-4">
        <div class="col-12">
            <div class="row">
                <div class="col-auto mb-3">
                    <span class="label-form text-center">Inspección a:</span>
                </div>
                <div class="col-auto custom-checkbox">
                    <div class="form-check">
                        <input type="checkbox" class="custom-control-input check_inspeccion" id="id_check_persona" name="Check_Persona" value="1" form="id_form_insp" checked>
                        <label class="custom-control-label" for="id_check_persona">Persona</label>
                    </div>
                        
                </div>
                <div class="col-auto">
                    <span class="label-form"> y/o </span>
                </div>
                <div class="col-auto custom-checkbox">
                    <div class="form-check">
                        <input type="checkbox" class="custom-control-input check_inspeccion" id="id_check_vehiculo" name="Check_Vehiculo" value="1" form="id_form_insp">
                        <label class="custom-control-label" for="id_check_vehiculo">Vehículo</label>
                    </div>  
                </div>
            </div>
            <small id="error_inspeccion_a" class="form-text text-danger "></small>
        </div>
    </div>

    <form id="id_form_insp" class="row" method="POST" action="<?= base_url;?>Inspecciones/nuevaInspeccion" enctype="multipart/form-data" accept-charset="utf-8">
        <!--INFO GENERAL-->
        <div class="col-12 ">
            <div class="row">
                <div class="col-12 text-center mt-2 mb-2">
                    <div class="text-divider">
                        <h5 class="sub_header">Información general</h5>
                    </div>
                </div>

                <div class="form-group col-12 col-md-6 col-lg-3">
                    <label for="id_grupo" class="label-form">Grupo que solicita:</label>
                    <select class="form-control form-control-sm" id="id_grupo" name="Grupo">
                      <?= $data['grupos'];?>
                    </select>
                </div>

                <div class="form-group col-12 col-md-6 col-lg-3">
                    <label for="id_zona_sector" class="label-form">Zona / Sector:</label>
                    <select class="form-control form-control-sm" id="id_zona_sector" name="Zona_Sector">
                    </select>       
                </div>

                <div class="form-group col-12 col-md-6 col-lg-3">
                    <label for="id_quien_solicita" class="label-form">Clave o grupo solicitante:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_quien_solicita" name="Quien_Solicita" required>
                    <small id="error_quien_solicita" class="form-text text-danger "></small>
                </div>

                <div class="form-group col-12 col-md-6 col-lg-3">
                    <label for="id_clave_solicitante" class="label-form">Nombre completo del solicitante:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_clave_solicitante" name="Clave_Num_Solicitante" required>
                    <small id="error_clave_solicitante" class="form-text text-danger "></small>
                </div>
                
                <div class="form-group col-12 col-md-6 col-lg-3">
                    <label for="id_quien_solicita" class="label-form">Unidad:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_unidad" name="Unidad" required>
                    <small id="error_unidad" class="form-text text-danger "></small>
                </div>

                <div class="form-group col-12 col-md-6 col-lg-3">
                    <label for="id_fecha" class="label-form">Fecha inspección:</label>
                    <input type="date" class="form-control form-control-sm" id="id_fecha" name="Fecha_Inspeccion" value="<?php echo date('Y-m-d') ?>" required>
                    <small id="error_fecha" class="form-text text-danger "></small>
                </div>
                <div class="form-group col-12 col-md-6 col-lg-3">
                    <label for="id_hora" class="label-form">Hora inspección:</label>
                    <input type="time" class="form-control form-control-sm" id="id_hora" name="Hora_Inspeccion" value="<?php echo date('H:i')?>" required>
                    <small id="error_hora" class="form-text text-danger "></small>
                </div>
                <div class="form-group col-12 col-md-6 col-lg-3">
                    <label for="id_telefono_radio" class="label-form">Teléfono/Radio:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_telefono_radio" name="Telefono_Radio">
                    <small id="error_telefono_radio" class="form-text text-danger "></small>
                </div>

                <div class="col-12 col-md-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="row mt-3">
                                <div class="col-3 label-form">Motivo: </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Motivo_Radio" id="id_motivo_radio_1" value="INSPECCIÓN PREVENTIVA" checked>
                                        <label class="form-check-label" for="id_motivo_radio_1">INSPECCIÓN PREVENTIVA</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" name="Motivo_Radio" id="id_motivo_radio_2" value="OTRO" >
                                        <label class="form-check-label" for="id_motivo_radio_2">OTRO</label>
                                    </div>
                                </div>
                                <div class="col-9 offset-3">
                                    <small id="error_motivo" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mi_hide" id="id_motivo_otro_panel">
                            <div class="row mt-3">
                                <div class="col-auto my-auto">
                                    <span class="label-form">Especifique cuál: </span>
                                </div>
                                <div class="col -auto">
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_motivo_otro" name="Motivo_Otro" maxlength="1000">
                                    <small id="error_motivo_otro" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                </div>
                
                <div class="form-group col-12 col-md-6">
                    <label for="id_resultado" class="label-form">Resultado de la inspección:</label>
                    <textarea class="form-control text-uppercase"  id="id_resultado" name="Resultado_Inspeccion" rows="3" maxlength="1000" required></textarea>
                    <small id="error_resultado" class="form-text text-danger "></small>
                </div>
            </div>
        </div>
        <!--INSPECCIÓN PERSONA-->
        <div class="col-12 col-md-6">
            <div class="row">
            
                <div class="col-12 text-center mt-3 mb-2">
                    <div class="text-divider">
                        <h5 class="sub_header">Persona(s)</h5>
                    </div>
                </div>
                <div class="col-12 alert alert-warning mi_hide" role="alert" id="id_edit_p_mode">
                    Esta en modo de editar persona.
                </div>
                <div class="col-12 alert alert-danger mi_hide" role="alert" id="id_error_p_mode">
                    Agrega al menos una persona o desactiva la casilla de persona (si solo es vehículo)
                </div>
                <div class="form-group col-12 col-lg-6">
                    <label for="id_nombre" class="label-form">Nombre(s):</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_nombre" name="Nombre" required>
                    <small id="error_nombre" class="form-text text-danger "></small>
                </div>

                <div class="form-group col-12 col-lg-6">
                    <label for="id_ap_paterno" class="label-form">Apellido paterno:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_ap_paterno" name="Ap_Paterno" required>
                    <small id="error_ap_paterno" class="form-text text-danger "></small>
                </div>
                <div class="form-group col-12 col-lg-6">
                    <label for="id_ap_materno" class="label-form">Apellido materno:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_ap_materno" name="Ap_Materno" required>
                    <small id="error_ap_materno" class="form-text text-danger "></small>
                </div>
                <div class="form-group col-12 col-lg-6">
                    <label for="id_alias" class="label-form">Alias:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_alias" name="Alias" value="S/D" required>
                    <small id="error_alias" class="form-text text-danger "></small>
                </div>
                <div class="form-group col-12 col-lg-6">
                    <label for="id_fecha_nacimiento" class="label-form">Fecha nacimiento:</label>
                    <input type="date" class="form-control form-control-sm" id="id_fecha_nacimiento" name="Fecha_Nacimiento" value="<?php echo '' ?>" required>
                    <small id="error_fecha" class="form-text text-danger "></small>
                </div>
                <div class="col-12 col-lg-6 my-lg-auto my-3 text-center text-lg-left">
                    <button type="button" class="btn btn-ssc" data-toggle="tooltip" data-placement="top" title="Agregar persona" id="id_add_persona">
                        Agregar
                    </button>
                    <input type="hidden" value="-1" id="id_persona_edit">
                    <button type="button" class="btn mibtn-primary mi_hide" data-toggle="tooltip" data-placement="top" title="Guardar los cambios de la persona" id="id_edit_persona">
                        Guardar cambios
                    </button>
                    <button type="button" class="btn mibtn-secondary mi_hide" data-toggle="tooltip" data-placement="top" title="Cancelar operación" id="id_cancelar_edit_per">
                        Cancelar
                    </button>
                </div>
                <div class="col-12 table-responsive">
                    <table class="table table-bordered table-sm" id="id_persona_table">
                        <thead >
                            <th>Nombre completo</th>
                            <th>Alias</th>
                            <th>Fecha nacimiento</th>
                            <th class="sticky_head">Operaciones</th>
                        </thead>
                        <tbody id="id_tbody_persona">
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <!--INSPECCIÓN VEHÍCULO-->
        <div class="col-12 col-md-6">
            <div class="row">
                <div class="col-12 text-center mt-3 mb-2">
                    <div class="text-divider">
                        <h5 class="sub_header">Vehículo</h5>
                    </div>
                </div>
                <div class="form-group col-12 col-lg-4">
                    <label for="id_tipo" class="label-form">Tipo:</label>
                    <select class="form-control form-control-sm" id="id_tipo" name="Tipo"  required disabled>
                        <?php foreach ($data['tipos_vehiculos'] as $item) : ?>
                            <option value="<?php echo $item->Tipo ?>"><?php echo $item->Tipo ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group col-12 col-lg-4">
                    <label for="id_marca" class="label-form">Marca:</label>
                    <select class="form-control form-control-sm" id="id_marca" name="Marca"  required disabled>
                        <?php foreach ($data['marcas_vehiculos'] as $item) : ?>
                            <option value="<?php echo $item->Marca ?>"><?php echo $item->Marca ?></option>
                        <?php endforeach ?>
                    </select>
                    <small id="error_marca" class="form-text text-danger "></small>
                </div>
                <div class="form-group col-12 col-lg-4">
                    <label for="id_submarca" class="label-form">Submarca:</label>
                    <select class="form-control form-control-sm" id="id_submarca" name="Submarca"  required disabled>
                        <?php foreach ($data['submarcas_vehiculos'] as $item) : ?>
                            <option value="<?php echo $item->Submarca ?>"><?php echo $item->Submarca ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group col-12 col-lg-4">
                    <label for="id_modelo" class="label-form">Modelo:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_modelo" name="Modelo" required disabled>
                    <small id="error_modelo" class="form-text text-danger "></small>
                </div>
                <div class="form-group col-12 col-lg-4">
                    <label for="id_placas" class="label-form">Placas:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_placas" name="Placas_Vehiculo" required disabled>
                    <small id="error_placas" class="form-text text-danger "></small>
                </div>
                <div class="form-group col-12 col-lg-4">
                    <label for="id_niv_vehiculo" class="label-form">NIV:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_niv_vehiculo" name="NIV" disabled>
                    <small id="error_niv_vehiculo" class="form-text text-danger "></small>
                </div>
                <div class="form-group col-12 col-lg-4">
                    <label for="id_color" class="label-form">Color:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_color" name="Color" disabled>
                </div>

                <div class="form-group col-12">
                    <div class="row">
                        <div class="col-12 mb-3 text-center">
                            <span class="label-form">Colocación de las placas:</span>
                        </div>
                        <div class="col-4 text-center">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Colocacion_Placa" id="id_colocacion_1" value="Original" checked disabled>
                                <label class="form-check-label" for="id_colocacion_1">Original</label>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Colocacion_Placa" id="id_colocacion_2" value="Sobrepuesta" checked disabled>
                                <label class="form-check-label" for="id_colocacion_2">Sobrepuesta</label>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Colocacion_Placa" id="id_colocacion_3" value="Apócrifa" disabled>
                                <label class="form-check-label" for="id_colocacion_3">Apócrifa</label>
                            </div>
                        </div>
                        <small id="error_colocacion" class="form-text text-danger text-center col-12 mb-3"></small>
                    </div>
                </div>

            </div>
        </div>
        <!--UBICACIÓN INSPECCIÓN-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-3 mb-2">
                    <div class="text-divider">
                        <h5 class="sub_header">Ubicación de la inspección</h5>
                    </div>
                </div>

                <!--campos de la ubicación-->
                <div class="col-12 col-lg-6">
                    <div class="row">
                        <!--busqueda dinámica de Google maps-->
                        <div class="col-12">
                            <div class="row ">
                                <div class="col-12 mb-2">
                                    <span class="label-form">Buscar por:</span>
                                </div>
                                

                                <div class="form-group col-12">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="porDireccion_inspecciones" name="busqueda_inspecciones" class="custom-control-input" value="0">
                                        <label class="custom-control-label label-form" for="porDireccion_inspecciones">Dirección</label>
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="porCoordenadas_inspecciones" name="busqueda_inspecciones" class="custom-control-input" value="1">
                                        <label class="custom-control-label label-form" for="porCoordenadas_inspecciones">Coordenadas</label>
                                    </div>
                                </div>

                                <div class="form-group col-12 mi_hide" id="por_direccion_inspecciones">
                                    <div class="input-group input-group-sm">
                                        <input type="search" name="dir_inspecciones" id="dir_inspecciones" class="form-control" placeholder="Ingrese una dirección a buscar" />
                                    </div>
                                </div>

                                <div class="form-group col-12 mi_hide" id="por_coordenadas_inspecciones">
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="search_cy_inspecciones" id="search_cy_inspecciones" class="form-control pr-3 mr-3" placeholder="Coordenada Y" />
                                        <input type="text" name="search_cx_inspecciones" id="search_cx_inspecciones" class="form-control pl-3 mr-3" placeholder="Coordenada X" />
                                        <button type="button" class="btn btn-ssc btn-sm" id="buscar_inspecciones">Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--campos del formulario principal-->
                        <div class="col-12">
                            <div class="row">
                                <div class="form-group col-12 col-lg-6">
                                    <label for="id_colonia" class="label-form">Colonia:</label>
                                    <input type="text" autocomplete="off" class="form-control form-control-sm text-uppercase" id="id_colonia" name="Colonia" required>
                                    <small id="error_colonia" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label for="id_calle_1" class="label-form">Calle 1:</label>
                                    <input type="text" autocomplete="off" class="form-control form-control-sm text-uppercase" id="id_calle_1" name="Calle_1" required>
                                    <small id="error_calle_1" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label for="id_calle_2" class="label-form">Calle 2:</label>
                                    <input type="text" autocomplete="off" class="form-control form-control-sm text-uppercase" id="id_calle_2" name="Calle_2" required>
                                    <small id="error_calle_2" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-12 col-lg-3">
                                    <label for="id_no_ext" class="label-form">Núm. Exterior:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_no_ext" name="No_Ext" required>
                                    <small id="error_no_ext" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-12 col-lg-3">
                                    <label for="id_no_int" class="label-form">Núm. Interior:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_no_int" name="No_Int" required>
                                    <small id="error_no_int" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-12 col-lg-3">
                                    <label for="id_coord_x" class="label-form">Coordenada X:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_coord_x" name="Coordenada_X" required>
                                    <small id="error_coord_x" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-12 col-lg-3">
                                    <label for="id_coord_y" class="label-form">Coordenada Y:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_coord_y" name="Coordenada_Y" required>
                                    <small id="error_coord_y" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-12 col-lg-3">
                                    <label for="id_coord_y" class="label-form">Codigo Postal:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_cp" name="id_cp" required>
                                    <small id="error_id_cp" class="form-text text-danger "></small>
                                </div>
                                <div class="form-group col-12 col-lg-3">
                                    <button type="button" class="btn btn-ssc mt-3 mi_hide" id="buscar_coordenadas_ins">Buscar</button>
                                    <button type="button" class="btn btn-ssc mt-3 mi_hide" id="buscar_direccion_ins">Buscar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--mapa-->
                <div class="col-12 col-lg-6 mi_hide">
                    <div class="col-12 alert alert-info mi_hide">
                        De momento no se tiene acceso a la api de Google Maps, por lo que la indicación es insertar campo por campo para continuar con los registros de Inspecciones/Consultas
                    </div>
                    <div class="col-12 " id="id_map">
                    </div>
                </div>
                <div id='map_mapbox'></div>

            </div>
        </div>
        <!--CARGA DE IMÁGENES/FOTOS-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-2 mb-2">
                    <div class="text-divider">
                        <h5 class="sub_header">Carga de imágenes</h5>
                    </div>
                </div>
                <!--botones de carga de imágenes-->
                <div class="col-12">
                    <div class="row">
                        <div class="col-auto">
                            <div class="form-group">
                                <input type="file" name="fileInspecciones" accept="image/*" id="fileInspecciones" class="inputfile uploadFileInspecciones" onchange="uploadFile(event)" data-toggle="tooltip" data-placement="bottom">
                                <label for="fileInspecciones">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cloud-upload" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z" />
                                        <path fill-rule="evenodd" d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3z" />
                                    </svg>
                                </label>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-group ml-2 mi_hide">
                                <label class="btn-photo" onclick="onloadCamera('Inspecciones')" data-toggle="modal" data-target="#capturePhotoInspecciones">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-camera" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M15 12V6a1 1 0 0 0-1-1h-1.172a3 3 0 0 1-2.12-.879l-.83-.828A1 1 0 0 0 9.173 3H6.828a1 1 0 0 0-.707.293l-.828.828A3 3 0 0 1 3.172 5H2a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z" />
                                        <path fill-rule="evenodd" d="M8 11a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                        <path d="M3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
                                    </svg>
                                </label>
                            </div>
                        </div>
                    </div>
                            
                            
                    
                </div>

                <!---panel de imágenes-->
                <div class="form-group col-12">
                    <div id="photos-content-inspecciones" class="row">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--BUTTONS-->
    <div class="row">
        <!--Botones de guardar y/o continuar-->
        <div class="col-12 mt-4 mb-5">
            <div class="row d-flex justify-content-center">
                <div class="col-auto">
                    <button type="button" class="btn btn-secondary" onclick="goToBack()" id="id_cancel_button">Cancelar</button>
                    <!-- <a href="<?= base_url;?>Inspecciones" class="btn btn-secondary">cancelar</a> -->
                </div>
                <div class="col-auto">
                    <button class="btn btn-ssc" onclick="checkFormInspeccion(event)" id="guardar_crear">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cámara-->
    <div class="modal fade mi_hide" id="capturePhotoInspecciones" tabindex="-1" aria-labelledby="capturePhotoInspeccionesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Capturar fotografía</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="video-wrap">
                                <video id="videoInspecciones" playsinline autoplay></video>
                                <span id="errMsgInspecciones"></span>
                            </div>
                            <div class="text-center">
                                <button id="captureInspecciones" class="btn btn-primary">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-camera" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M15 12V6a1 1 0 0 0-1-1h-1.172a3 3 0 0 1-2.12-.879l-.83-.828A1 1 0 0 0 9.173 3H6.828a1 1 0 0 0-.707.293l-.828.828A3 3 0 0 1 3.172 5H2a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z" />
                                        <path fill-rule="evenodd" d="M8 11a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                        <path d="M3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-6" id="canvas-content">
                            <canvas id="canvasInspecciones" width="368" height="368"></canvas>
                            <div class="text-center">
                                <button id="add-photoInspecciones" onclick="uploadPhoto('Inspecciones')" class="btn btn-ssc" disabled>
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>