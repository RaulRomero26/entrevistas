<div class="container">

    <form id="datos_peticionario" autocomplete="off">

        <div class="row mt-5">

            <div class="col-12 my-4" id="msg_peticionario"></div>
            <div class="col-lg-4 d-flex justify-content-start align-items-center">

                <?php
                $no_remision    = (isset($_GET['no_remision'])) ? $_GET['no_remision'] : '0';
                $no_ficha       = (isset($_GET['no_ficha'])) ? $_GET['no_ficha'] : '0';
                ?>

                <input type="hidden" name="no_remision_peticionario" id="no_remision_peticionario" value=<?= $no_remision ?>>
                <input type="hidden" name="no_ficha_peticionario" id="no_ficha_peticionario" value=<?= $no_ficha ?>>

                <span class="span_rem">Núm. Remisión/Oficio: </span>
                <?php if (isset($_GET['no_remision'])) { ?>
                    <span class="span_rem_ans ml-2"><?= $_GET['no_remision'] ?></span>
                <?php } ?>

                <span class="span_rem ml-5">Núm. Ficha: </span>
                <?php if (isset($_GET['no_remision'])) { ?>
                    <span class="span_rem_ans ml-2"><?= $_GET['no_ficha'] ?></span>
                <?php } ?>
            </div>
        </div>

        <div class="form-row mt-5">

            <div class="form-group col-lg-4">
                <label for="Nombres" class="label-form">Nombres:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" name="peticionario_Nombres" id="peticionario_Nombres">
                <span class="span_error" id="peticionario_Nombres_error"></span>
            </div>

            <div class="form-group col-lg-4">
                <label for="appPaterno" class="label-form">Apellido paterno:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" name="peticionario_appPaterno" id="peticionario_appPaterno">
                <span class="span_error" id="peticionario_appPaterno_error"></span>
            </div>

            <div class="form-group col-lg-4">
                <label for="appMaterno" class="label-form">Apellido materno:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" name="peticionario_appMaterno" id="peticionario_appMaterno">
                <span class="span_error" id="peticionario_appMaterno_error"></span>
            </div>

            <div class="form-group col-lg-2">
                <label for="Edad" class="label-form">Edad:</label>
                <input type="number" class="form-control form-control-sm" name="peticionario_Edad" id="peticionario_Edad">
                <span class="span_error" id="peticionario_Edad_error"></span>
            </div>

            <div class="form-group col-lg-2">
                <label for="Sexo" class="label-form">Sexo:</label>
                <select class="custom-select custom-select-sm" name="peticionario_Sexo" id="peticionario_Sexo">
                    <option value="" selected disabled>SELECCIONA UNA OPCIÓN</option>
                    <option value="h">HOMBRE</option>
                    <option value="m">MUJER</option>
                </select>
            </div>

            <div class="form-group col-lg-4">
                <label for="Escolaridad" class="label-form">Escolaridad:</label>
                <select class="custom-select custom-select-sm" name="peticionario_Escolaridad" id="peticionario_Escolaridad">
                    <option value="" selected disabled>SELECCIONA UNA OPCIÓN</option>
                    <?php foreach ($data['datos_prim']['escolaridad'] as $item) : ?>
                        <option value="<?php echo $item->Escolaridad ?>"><?php echo $item->Escolaridad ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group col-lg-3">
                <label for="Fecha_n" class="label-form">Fecha de nacimiento:</label>
                <input type="date" class="form-control form-control-sm" name="peticionario_Fecha_n" id="peticionario_Fecha_n">
                <span class="span_error" id="peticionario_Fecha_n_error"></span>
            </div>
            <div class="form-group col-lg-4">
                <p class="label-form ml-2"> Nacionalidad: </p>
                <div class="form-group col-lg-12">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="nacionalidad_mexicana_pet" name="nacionalidad_pet" class="custom-control-input" value="MEXICANA" checked>
                        <label class="custom-control-label label-form" for="nacionalidad_mexicana_pet">Mexicana</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="nacionalidad_extranjera_pet" name="nacionalidad_pet" class="custom-control-input" value="EXTRANJERA">
                        <label class="custom-control-label label-form" for="nacionalidad_extranjera_pet">Extranjera</label>
                    </div>
                </div>
            </div>
            <div class="form-group col-lg-4" id="estado_nacimiento_pet">
                <label for="procedencia_estado_pet" class="label-form">Estado de nacimiento:</label>
                <select class="custom-select custom-select-sm" id="procedencia_estado_pet" name="procedencia_estado_pet">
                    <?php foreach ($data['datos_prim']['estados'] as $item) : ?>
                        <option value="<?php echo $item->Estado ?>"><?php echo $item->Estado ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group col-lg-4" id="procedencia_peticionario_div">
                <label for="Procedencia" class="label-form" id="label_procedencia_pet">Procedencia:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" name="peticionario_Procedencia" id="peticionario_Procedencia">
                <span class="span_error" id="peticionario_Procedencia_error"></span>
            </div>

        </div>
        <div id="mapDivPeticionario">
            <div class="row mt-5">
                <div class="col-lg-6">
                    <p class="form_title">Domicilio: </p>
                    <div class="form-row mt-5">
                        <p class="label-form ml-2"> Domicilio en: </p>
                        <div class="form-group col-lg-12">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="domicilio_puebla_peticionario" data-id="peticionario" name="busqueda_puebla_peticionario" class="custom-control-input" value="PUEBLA" checked>
                                <label class="custom-control-label label-form" for="domicilio_puebla_peticionario">Puebla</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="domicilio_foraneo_peticionario" data-id="peticionario" name="busqueda_puebla_peticionario" class="custom-control-input" value="FORANEO">
                                <label class="custom-control-label label-form" for="domicilio_foraneo_peticionario">Foraneo</label>
                            </div>
                        </div>
                        <p class="label-form ml-2"> Buscar por: </p>
                        <div class="form-group col-lg-12">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="porDireccion_peticionario" data-id="peticionario" name="busqueda" class="custom-control-input" value="0">
                                <label class="custom-control-label label-form" for="porDireccion_peticionario">Dirección</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="porCoordenadas_peticionario" data-id="peticionario" name="busqueda" class="custom-control-input" value="1">
                                <label class="custom-control-label label-form" for="porCoordenadas_peticionario">Coordenadas</label>
                            </div>
                        </div>
                        <div class="form-group col-lg-12 mi_hide" id="por_direccion_peticionario">
                            <div class="input-group input-group-sm">
                                <input type="search" id="dir_peticionario" class="form-control text-uppercase" placeholder="Ingrese la dirección del peticionario" />
                            </div>
                        </div>
                        <div class="form-group col-lg-12 mi_hide" id="por_coordenadas_peticionario">
                            <div class="input-group input-group-sm">
                                <input type="text" id="search_cy_peticionario" class="form-control pr-3 mr-3" placeholder="Coordenada Y" />
                                <input type="text" id="search_cx_peticionario" class="form-control pl-3 mr-3" placeholder="Coordenada X" />
                                <button type="button" class="btn btn-ssc btn-sm" id="buscar_peticionario">Buscar</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-5">    
                        <div class="form-group col-lg-6">
                            <label for="Colonia" class="label-form">Colonia:</label>
                            <input type="text" autocomplete="off" class="form-control form-control-sm text-uppercase" id="Colonia_peticionario" name="Colonia_peticionario">
                            <span class="span_error" id="Colonia_peticionario_error"></span>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="Calle" class="label-form">Calle:</label>
                            <input type="text" autocomplete="off" class="form-control form-control-sm text-uppercase" id="Calle_peticionario" name="Calle_peticionario">
                            <span class="span_error" id="Calle_peticionario_error"></span>
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="noInterior" class="label-form">Núm. de Interior:</label>
                            <input type="text" class="form-control form-control-sm" id="noInterior_peticionario" name="noInterior_peticionario">
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="noExterior" class="label-form">Núm. de Exterior:</label>
                            <input type="text" class="form-control form-control-sm" id="noExterior_peticionario" name="noExterior_peticionario">
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="cordY" class="label-form">Coordenada Y:</label>
                            <input type="text" class="form-control form-control-sm" id="cordY_peticionario" name="cordY_peticionario" >
                            <span class="span_error" id="cordY_peticionario_error"></span>
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="cordX" class="label-form">Coordenada X:</label>
                            <input type="text" class="form-control form-control-sm" id="cordX_peticionario" name="cordX_peticionario" >
                            <span class="span_error" id="cordX_peticionario_error"></span>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="Estado" class="label-form">Estado:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="Estado_peticionario" name="Estado_peticionario" >
                            <span class="span_error" id="Estado_peticionario_error"></span>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="Municipio" class="label-form">Municipio:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="Municipio_peticionario" name="Municipio_peticionario" >
                            <span class="span_error" id="Municipio_peticionario_error"></span>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="CP_peticionario" class="label-form">Código Postal:</label>
                            <input type="text" class="form-control form-control-sm" id="CP_peticionario" name="CP_peticionario">
                            <span class="span_error" id="CP_peticionario_error"></span>
                        </div>
                        <span class="span_error" id="errorMap_peticionario"></span>
                        <div class="form-group col-12 col-lg-12">
                            <button type="button" class="btn btn-ssc mt-3 mi_hide" id="buscar_coordenadas_peticionario">Buscar</button>
                            <button type="button" class="btn btn-ssc mt-3 mi_hide" id="buscar_direccion_peticionario">Buscar</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" style="display: none">
                    <!-- <div class="col-12 alert alert-info">
                        De momento no se tiene acceso a la api de Google Maps, por lo que la indicación es insertar campo por campo para continuar con los registros de Remisiones
                    </div> -->
                    <div id="map1"></div>
                </div>
                <div class="col-lg-6">
                    <div id='map_mapbox2'></div>
                </div>
            </div>
        </div>

        <?php if (!isset($data['tabs']['peticionario'])) { ?>
            <div class="row mt-5 mb-5">
                <div class="col-12 d-flex justify-content-between col-sm-12">
                    <a class="btn btn-sm btn-ssc btn-tab-getIndex" id="btn-tab-getIndex-1" data-id="1" message="msg_peticionario">Validar</a>
                    <div>
                        <a class="btn btn-sm btn-ssc" id='btn_peticionario' value="1">Guardar</a>
                        <span class="advise-span text-center ml-2 mt-2 span-message" id="span-message-1">* Lo sentimos, el tab ha sido validado. No se poseen los permisos necesarios para editar</span>
                    </div>
                </div>
            </div>
        <?php } else if (isset($data['tabs']['peticionario']) && $data['tabs']['peticionario'] == 1) { ?>
            <div class="col-12 mt-5 mb-5">
                <div class="alert alert-warning text-center" role="alert">
                    Un registro de peticionario ha sido creado previamente, puedes dirigirte a la pantalla principal de Remisiones para editar la información guardada
                </div>
            </div>

            <div class="row mt-5 mb-5" style="visibility: hidden;">
                <div class="col-12 d-flex justify-content-between col-sm-12">
                    <a class="btn btn-sm btn-ssc btn-tab-getIndex" id="btn-tab-getIndex-1" data-id="1" message="msg_peticionario">Validar</a>
                    <div>
                        <a class="btn btn-sm btn-ssc" id='btn_peticionario' value="1">Guardar</a>
                        <span class="advise-span text-center ml-2 mt-2 span-message" id="span-message-1">* Lo sentimos, el tab ha sido validado. Su usuario no tiene los permisos necesarios para editar</span>
                    </div>
                </div>
            </div>
        <?php } ?>
    </form>
</div>