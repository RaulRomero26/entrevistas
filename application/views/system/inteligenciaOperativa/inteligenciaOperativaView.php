<div class="container">
    <div class="paragraph-title d-flex justify-content-between mt-5 mb-4">
        <h5>Inteligencia Operativa</h5>
    </div>

    <form id="InteligenciaOperativaForm" onsubmit="event.preventDefault()">
        <div class="row mt-5">
            <div class="col-12" id="msg_principales"></div>

            <div class="form-group col-lg-4">
                <label for="Nombre_Elemento_R" class="label-form">Nombre del elemento responsable:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Nombre_Elemento_R" name="Nombre_Elemento_R" value="<?= $_SESSION['userdata']->Nombre . " " . $_SESSION['userdata']->Ap_Paterno . " " . $_SESSION['userdata']->Ap_Materno ?>" readonly>
                <span class="span_error" id="Nombre_Elemento_R_error"></span>
            </div>

            <div class="form-group col-lg-4">
                <label for="Responsable_Turno" class="label-form">Responsable de turno:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Responsable_Turno" name="Responsable_Turno">
                <span class="span_error" id="Responsable_Turno_error"></span>
            </div>

            <div class="form-group col-lg-4">
                <label for="Origen_Evento" class="label-form">Origen del evento:</label>
                <select class="custom-select custom-select-sm" id="Origen_Evento" name="Origen_Evento">
                    <?php foreach ($data['datos_InteligenciaOp']['origenEvento'] as $item) : ?>
                        <option value="<?php echo strtoupper($item->Origen) ?>"><?php echo strtoupper($item->Origen) ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group col-lg-4">
                <label for="Fecha_Turno" class="label-form">Fecha del turno:</label>
                <input type="date" class="form-control form-control-sm" id="Fecha_Turno" name="Fecha_Turno" value="<?php echo date('Y-m-d') ?>" readonly>
                <span class="span_error" id="Fecha_Turno_error"></span>
            </div>

            <div class="form-group col-lg-4">
                <label for="Turno" class="label-form">Turno:</label>
                <select class="custom-select custom-select-sm" id="Turno" name="Turno">
                    <option value="DIURNO">DIURNO</option>
                    <option value="NOCTURNO">NOCTURNO</option>
                </select>
            </div>

            <div class="form-group col-lg-4">
                <label for="Semana" class="label-form">Semana:</label>
                <input type="text" class="form-control form-control-sm" id="Semana" name="Semana" onkeypress="return soloNumeros(event)" maxlength="2">
                <span class="span_error" id="Semana_error"></span>
            </div>

            <div class="form-group col-lg-4">
                <label for="Folio_Deri" class="label-form">Folio DERI:</label>
                <input type="text" class="form-control form-control-sm" id="Folio_Deri" name="Folio_Deri" onkeypress="return soloNumeros(event)">
                <span class="span_error" id="Folio_Deri_error"></span>
            </div>

            <div class="form-group col-lg-4">
                <label for="Fecha_Evento" class="label-form">Fecha del evento:</label>
                <input type="date" class="form-control form-control-sm" id="Fecha_Evento" name="Fecha_Evento">
                <span class="span_error" id="Fecha_Evento_error"></span>
            </div>

            <div class="form-group col-lg-4">
                <label for="Hora_Reporte" class="label-form">Hora del reporte:</label>
                <input type="time" class="form-control form-control-sm" id="Hora_Reporte" name="Hora_Reporte">
                <span class="span_error" id="Hora_Reporte_error"></span>
            </div>

            <div class="form-group col-lg-3">
                <label for="Motivo" class="label-form">Motivo:</label>

                <select class="custom-select custom-select-sm" id="Motivo" name="Motivo">
                    <?php foreach ($data['datos_InteligenciaOp']['motivo'] as $item) : ?>
                        <option value="<?php echo strtoupper($item->Descripcion) ?>"><?php echo strtoupper($item->Descripcion) ?></option>
                    <?php endforeach ?>
                </select>

            </div>

            <div class="form-group col-lg-3">
                <label for="Caracteristicas_Robo" class="label-form">Características del evento:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Caracteristicas_Robo" name="Caracteristicas_Robo">
                <span class="span_error" id="Caracteristicas_Robo_error"></span>
            </div>

            <div class="col-lg-1 d-flex align-items-center justify-content-center">
                <label for="Violencia" class="label-form">Violencia:</label>
            </div>

            <div class="form-group col-lg-2 d-flex justify-content-center align-items-center">
                <div class="custom-control custom-radio custom-control-inline ">
                    <input type="radio" id="Violencia_0" name="Violencia" class="custom-control-input" value="No" checked>
                    <label class="custom-control-label label-form" for="Violencia_0">No</label>
                </div>

                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="Violencia_1" name="Violencia" class="custom-control-input" value="Si">
                    <label class="custom-control-label label-form" for="Violencia_1">Si</label>
                </div>
            </div>

            <div class="form-group col-lg-3">
                <label for="Tipo_Violencia" class="label-form">Tipo de violencia:</label>
                <select class="custom-select custom-select-sm" id="Tipo_Violencia" name="Tipo_Violencia">
                    <?php foreach ($data['datos_InteligenciaOp']['tipoViolencia'] as $item) : ?>
                        <option value="<?php echo strtoupper($item->Tipo_Violencia) ?>"><?php echo strtoupper($item->Tipo_Violencia) ?></option>
                    <?php endforeach ?>
                </select>
            </div>


            <div class="col-lg-6 mt-5">
                <p class="form_title">Ubicación: </p>
                <div class="form-row mt-3">
                    <p class="label-form ml-2"> Buscar por: </p>
                    <div class="form-group col-lg-12">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="porDireccion" data-id="InteligenciaOperativa_1" name="busqueda" class="custom-control-input" value="0">
                            <label class="custom-control-label label-form" for="porDireccion">Dirección</label>
                        </div>

                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="porCoordenadas" data-id="InteligenciaOperativa_1" name="busqueda" class="custom-control-input" value="1">
                            <label class="custom-control-label label-form" for="porCoordenadas">Coordenadas</label>
                        </div>
                    </div>

                    <div class="form-group col-lg-12" id="por_direccion">
                        <div class="input-group input-group-sm">
                            <input type="search" id="dir" class="form-control text-uppercase" placeholder="Ingrese una dirección a buscar" />
                        </div>
                    </div>

                    <div class="form-group col-lg-12" id="por_coordenadas">
                        <div class="input-group input-group-sm">
                            <input type="text" id="search_cy" class="form-control pr-3 mr-3" placeholder="Coordenada Y" />
                            <input type="text" id="search_cx" class="form-control pl-3 mr-3" placeholder="Coordenada X" />
                            <button class="btn btn-ssc btn-sm" id="buscar">Buscar</button>
                        </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="Colonia" class="label-form">Colonia:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Colonia" name="Colonia">
                        <span class="span_error" id="Colonia_inteligencia_error"></span>

                    </div>

                    <div class="form-group col-lg-6">
                        <label for="Calle" class="label-form">Calle:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Calle" name="Calle">
                        <span class="span_error" id="Calle_inteligencia_error"></span>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="noInterior" class="label-form">Núm. de Interior:</label>
                        <input type="text" class="form-control form-control-sm" id="noInterior" name="noInterior">
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="noExterior" class="label-form">Núm. de Exterior:</label>
                        <input type="text" class="form-control form-control-sm" id="noExterior" name="noExterior">
                        <span class="span_error" id="noExterior_inteligencia_error"></span>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordY" class="label-form">Coordenada Y:</label>
                        <input type="text" class="form-control form-control-sm" id="cordY" name="cordY" readonly>
                        <span class="span_error" id="cordY_inteligencia_error"></span>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordX" class="label-form">Coordenada X:</label>
                        <input type="text" class="form-control form-control-sm" id="cordX" name="cordX" readonly>
                        <span class="span_error" id="cordX_inteligencia_error"></span>
                    </div>

                    <div class="form-group col-lg-6 mi_hide">
                        <label for="Estado" class="label-form">Estado:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Estado" name="Estado">
                        <span class="span_error" id="Estado_inteligencia_error"></span>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="Municipio" class="label-form">Municipio:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Municipio" name="Municipio">
                        <span class="span_error" id="Municipio_inteligencia_error"></span>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="CP" class="label-form">Código Postal:</label>
                        <input type="text" class="form-control form-control-sm" id="CP" name="CP" onkeypress="return soloNumeros(event) ">
                        <span class="span_error" id="CP_inteligencia_error"></span>
                    </div>
                    <span class="span_error" id="errorMap"></span>
                </div>
            </div>

            <div class="col-lg-6 mt-5">
<!--                 <div class="col-12 alert alert-info">
                    De momento no se tiene acceso a la api de Google Maps, por lo que la indicación es insertar campo por campo para continuar con los registros de Inteligencia Operativa
                </div> -->
                <div id="map1"></div>
            </div>

            <div class="form-group col-lg-6">
                <label for="Zona_Evento" class="label-form">Zona del evento:</label>
                <select class="custom-select custom-select-sm" id="Zona_Evento" name="Zona_Evento">
                    <?php foreach ($data['datos_InteligenciaOp']['zona'] as $item) : ?>
                        <option value="<?php echo strtoupper($item->Zona_Sector) ?>"><?php echo strtoupper($item->Zona_Sector) ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group col-lg-6">
                <label for="Vector" class="label-form">Vector:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Vector" name="Vector" maxlength="10">
                <!-- <select class="custom-select custom-select-sm" id="Vector" name="Vector">
                    <?php //foreach ($data['datos_InteligenciaOp']['vector'] as $item) : ?>
                        <option value="<?php //echo strtoupper($item->Vector) ?>"><?php //echo strtoupper($item->Vector) ?></option>
                    <?php //endforeach ?>
                </select> -->
            </div>

            <div class="col-12 text-center mt-5">
                <div class="text-divider">
                    <h5>Registro de cámaras implicadas en el evento</h5>
                </div>
            </div>
            <div class="alert alert-warning col-lg-12" role="alert" id="alertEditCamaras">Está realizando edición a un vehículo.</div>

            <div class="row mb-5">
                <div class="form-group col-lg-4 col-md-12">
                    <label for="Ubicacion_Camaras" class="label-form">Ubicación de la cámara respecto al evento:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Ubicacion_Camaras" name="Ubicacion_Camaras">
                    <span class="span_error" id="Ubicacion_Camaras_error"></span>
                    <div class="invalid-feedback" id="Ubicacion_Camaras-invalid">La ubicación es requerida.</div>
                </div>

                <div class="form-group col-lg-2 col-md-12">
                    <label for="Funciona_Camara" class="label-form">¿La cámara funciona?</label>
                    <select class="custom-select custom-select-sm" id="Funciona_Camara">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        <option value="Si">Si</option>
                        <option value="No">No</option>
                    </select>
                    <div class="invalid-feedback" id="Funciona_Camara-invalid">La opción es requerida.</div>
                </div>

                <div class="form-group col-lg-4 text-center">
                    <label for="Funciona_Camara" class="label-form">Tipo:</label>
                    <div class="d-flex justify-content-around">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipo_camara" id="tipo_camara1" checked>
                        <label class="form-check-label" for="tipo_camara1">
                            Cámara
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipo_camara" id="tipo_camara2">
                        <label class="form-check-label" for="tipo_camara2">
                            LPR
                        </label>
                    </div>
                    </div>
                </div>
                <div class="col-lg-1 text-center d-flex justify-content-center align-items-start mt-4 mb-4">
                    <button type="button" onclick="onFormSegCamarasSubmit()" class="btn btn-primary  btn-sm button-movil-plus">Agregar</button>
                </div>

                <div class="col-lg-12 col-md-12">
                    <table class="table table-bordered" id="camarasIO">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Ubicación de la cámara respecto al evento</th>
                                <th scope="col">¿La cámara funciona?</th>
                                <th scope="col">Tipo</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody class="text-uppercase">
                        </tbody>
                    </table>
                </div>
            </div>



            <div class="form-group col-lg-12">
                <label for="Unidad_Primer_R" class="label-form">Unidad del primer respondiente:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Unidad_Primer_R" name="Unidad_Primer_R">
                <span class="span_error" id="Unidad_Primer_R_error"></span>
            </div>

            <div class="form-group col-lg-6">
                <label for="Informacion_Primer_R" class="label-form">Información del primer respondiente:</label>
                <textarea class="form-control text-uppercase" id="Informacion_Primer_R" name="Informacion_Primer_R" rows="6" maxlength="6000"></textarea>
                <span class="span_error" id="Informacion_Primer_R_error"></span>
            </div>

            <div class="form-group col-lg-6">
                <label for="Acciones" class="label-form">Acciones:</label>
                <textarea class="form-control text-uppercase" id="Acciones" name="Acciones" rows="6" maxlength="6000"></textarea>
                <span class="span_error" id="Acciones_error"></span>
            </div>

            <div class="col-lg-3 d-flex justify-content-center mt-4">
                <span class="label-form text-center ">¿Se identificarón responsables?</span>
            </div>

            <div class="form-group col-lg-3 d-flex justify-content-center align-items-center mt-4">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="Identificacion_Responsables_0" name="Identificacion_Responsables" class="custom-control-input" value="No" checked>
                    <label class="custom-control-label label-form" for="Identificacion_Responsables_0">No</label>
                </div>

                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="Identificacion_Responsables_1" name="Identificacion_Responsables" class="custom-control-input" value="Si">
                    <label class="custom-control-label label-form" for="Identificacion_Responsables_1">Si</label>
                </div>
            </div>

            <div class="col-lg-3 d-flex justify-content-center mt-4">
                <span class="label-form text-center ">¿Detención por información de I.O?</span>
            </div>

            <div class="form-group col-lg-3 d-flex justify-content-center align-items-center mt-4">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="Detencion_Por_Info_Io_0" name="Detencion_Por_Info_Io" class="custom-control-input" value="No" checked>
                    <label class="custom-control-label label-form" for="Detencion_Por_Info_Io_0">No</label>
                </div>

                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="Detencion_Por_Info_Io_1" name="Detencion_Por_Info_Io" class="custom-control-input" value="Si">
                    <label class="custom-control-label label-form" for="Detencion_Por_Info_Io_1">Si</label>
                </div>
            </div>

            <div class="form-group col-lg-12">
                <label for="Elementos_Realizan_D" class="label-form">Elementos que realizan la detención:</label>
                <textarea class="form-control text-uppercase" id="Elementos_Realizan_D" name="Elementos_Realizan_D" rows="6" maxlength="6000"></textarea>
                <span class="span_error" id="Elementos_Realizan_D_error"></span>
            </div>

            <div class="form-group col-lg-6">
                <label for="Fecha_Detencion" class="label-form">Fecha de detención:</label>
                <input type="date" class="form-control form-control-sm" id="Fecha_Detencion" name="Fecha_Detencion">
                <span class="span_error" id="Fecha_Detencion_error"></span>
            </div>

            <div class="form-group col-lg-6">
                <label for="marca" class="label-form">Compañía:</label>
                <select class="custom-select custom-select-sm" id="Compania" name="Compania">
                    <option value="1 CIA">1 CIA</option>
                    <option value="2 CIA">2 CIA</option>
                </select>
            </div>

            <div class="col-lg-6 mt-5">
                <p class="form_title">Zona de aseguramiento: </p>
                <div class="form-row mt-3">
                    <p class="label-form ml-2"> Buscar por: </p>

                    <div class="form-group col-lg-12">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="porDireccion_1" data-id="InteligenciaOperativa_2" name="busqueda" class="custom-control-input" value="0">
                            <label class="custom-control-label label-form" for="porDireccion_1">Dirección</label>
                        </div>

                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="porCoordenadas_1" data-id="InteligenciaOperativa_2" name="busqueda" class="custom-control-input" value="1">
                            <label class="custom-control-label label-form" for="porCoordenadas_1">Coordenadas</label>
                        </div>
                    </div>

                    <div class="form-group col-lg-12" id="por_direccion_1">
                        <div class="input-group input-group-sm">
                            <input type="search" id="dir_1" class="form-control text-uppercase" placeholder="Ingrese una dirección a buscar" />
                        </div>
                    </div>

                    <div class="form-group col-lg-12" id="por_coordenadas_1">
                        <div class="input-group input-group-sm">
                            <input type="text" id="search_cy_1" class="form-control pr-3 mr-3" placeholder="Coordenada Y" />
                            <input type="text" id="search_cx_1" class="form-control pl-3 mr-3" placeholder="Coordenada X" />
                            <button class="btn btn-ssc btn-sm" id="buscar_1">Buscar</button>
                        </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="Colonia_1" class="label-form">Colonia:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Colonia_1" name="Colonia_1">
                        <span class="span_error" id="Colonia_inteligencia_1_error"></span>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="Calle_1" class="label-form">Calle:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Calle_1" name="Calle_1">
                        <span class="span_error" id="Calle_inteligencia_1_error"></span>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="noInterior_1" class="label-form">Núm. de Interior:</label>
                        <input type="text" class="form-control form-control-sm" id="noInterior_1" name="noInterior_1">
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="noExterior_1" class="label-form">Núm. de Exterior:</label>
                        <input type="text" class="form-control form-control-sm" id="noExterior_1" name="noExterior_1">
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordY_1" class="label-form">Coordenada Y:</label>
                        <input type="text" class="form-control form-control-sm" id="cordY_1" name="cordY_1" readonly>
                        <span class="span_error" id="cordY_inteligencia_1_error"></span>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordX_1" class="label-form">Coordenada X:</label>
                        <input type="text" class="form-control form-control-sm" id="cordX_1" name="cordX_1" readonly>
                        <span class="span_error" id="cordX_inteligencia_1_error"></span>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="Municipio_1" class="label-form">Municipio:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Municipio_1" name="Municipio_1">
                        <span class="span_error" id="Municipio_inteligencia_1_error"></span>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="CP_1" class="label-form">Código Postal:</label>
                        <input type="text" class="form-control form-control-sm" id="CP_1" name="CP_1" onkeypress="return soloNumeros(event) ">
                        <span class="span_error" id="CP_inteligencia_1_error"></span>
                    </div>
                    <span class="span_error" id="errorMap_1"></span>
                </div>
            </div>

            <div class="col-lg-6 mt-5">
                <!-- <div class="col-12 alert alert-info">
                    De momento no se tiene acceso a la api de Google Maps, por lo que la indicación es insertar campo por campo para continuar con los registros de Inteligencia Operativa
                </div> -->
                <div id="map2"></div>
            </div>

            <div class="form-group col-lg-12 mt-4">
                <p class="form_title">Adjuntar PDF</p>
                <div class="custom-file">
                    <input type="file" class="bs-custom-file-input" id="Path_Pdf" name="Path_Pdf" accept=".pdf" placeholder="Cargar PDF">
                    <label class="custom-file-label" for="Path_Pdf"></label>
                </div>
                <span class="span_error" id="Path_Pdf_error"></span>
            </div>

            <div id="RenderPDF" class="col-12"></div>
        </div>

        <div class="col-12 text-center mt-5">
            <div class="text-divider">
                <h5>Registro de Vehículos Involucrados/Robados</h5>
            </div>
        </div>

        <div class="alert alert-warning col-lg-12" role="alert" id="alertEditVehiculoSP">Está realizando edición a un vehículo.</div>
        <div class="row d-flex justify-content-between">
            <div class="form-group col-lg-3">
                <label for="marcaVehiculoSegPer" class="label-form">Marca:</label>
                <select class="custom-select custom-select-sm" id="marcaVehiculoSegPer">
                    <option value="" selected disabled>SELECCIONE LA MARCA</option>
                    <?php foreach ($data['datos_InteligenciaOp']['marcasVehiculos'] as $item) : ?>
                        <option value="<?php echo strtoupper($item->Marca) ?>"><?php echo strtoupper($item->Marca) ?></option>
                    <?php endforeach ?>
                </select>
                <div class="invalid-feedback" id="marcaVehiculoSegPer-invalid">La marca es requerida.</div>
            </div>
            <div class="form-group col-lg-3">
                <label for="modeloVehiculoSegPer" class="label-form">Modelo:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="modeloVehiculoSegPer">
            </div>
            <div class="form-group col-lg-3">
                <label for="colorVehiculoSegPer" class="label-form">Color:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="colorVehiculoSegPer">
            </div>
            <div class="form-group col-lg-2">
                <label for="placaVehiculoSegPer" class="label-form">Placa:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="placaVehiculoSegPer">
            </div>

            <!-- <div class="col-lg-3 d-flex justify-content-center mt-4">
                <span class="label-form text-center ">¿Identificación de placas?</span>
            </div> -->

            <div class="form-group col-lg-4">
                <!-- <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="Identificacion_Placa_0" name="identifiacionVehiculoSegPer" class="custom-control-input" value="No" checked>
                    <label class="custom-control-label label-form" for="Identificacion_Placa_0">No</label>
                </div>

                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="Identificacion_Placa_1" name="identifiacionVehiculoSegPer" class="custom-control-input" value="Si">
                    <label class="custom-control-label label-form" for="Identificacion_Placa_1">Si</label>
                </div> -->
                <label for="identifiacionVehiculoSegPer" class="label-form">¿Identificación de placas?:</label>
                <select class="custom-select custom-select-sm" id="identifiacionVehiculoSegPer">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    <option value="Si">Si</option>
                    <option value="No">No</option>
                </select>
            </div>

            <div class="form-group col-lg-4 d-flex justify-content-around align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="involucrado_robado" id="involucrado_robado1" checked>
                    <label class="form-check-label" for="involucrado_robado1">
                        Involucrado
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="involucrado_robado" id="involucrado_robado2">
                    <label class="form-check-label" for="involucrado_robado2">
                        Robado
                    </label>
                </div>
            </div>
            <div class="form-group col-lg-4">
                <label for="usoVehiculoSegPer" class="label-form">Uso del vehículo:</label>
                
                <select class="custom-select custom-select-sm" id="usoVehiculoSegPer" name="usoVehiculoSegPer">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    <?php foreach ($data['datos_InteligenciaOp']['usoVehiculo'] as $item) : ?>
                        <option value="<?php echo strtoupper($item->Uso) ?>"><?php echo strtoupper($item->Uso) ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group col-lg-12">
                <label for="caracteristicasVehiculoSegPer" class="label-form">Características del vehículo:</label>
                <textarea class="form-control text-uppercase" id="caracteristicasVehiculoSegPer" name="caracteristicasVehiculoSegPer" rows="6" maxlength="6000"></textarea>
                <span class="span_error" id="Caracteristicas_Vehiculo_error"></span>
            </div>




            <div class="col-lg-12 d-flex align-items-center justify-content-center my-4">
                <button type="button" onclick="onFormSegVehiculosSubmit()" class="btn btn-primary button-movil-plus">Agregar</button>
            </div>
        </div>

        <table class="table table-bordered" id="seguimientoVehiculosPer">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Marca</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Color</th>
                    <th scope="col">Identificación de placa</th>
                    <th scope="col">Placa</th>
                    <th scope="col">Uso del vehículo</th>
                    <th scope="col">Involucrado/Robado</th>
                    <th scope="col">Características del vehículo</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody class="text-uppercase">
            </tbody>
        </table>
    </form>
    <div class="row mt-5 mb-5">
        <div class="col-12 d-flex justify-content-end col-sm-12">
            <button class="btn btn-sm btn-ssc" id="btn_Inteligencia">Guardar</button>
        </div>
    </div>
</div>