<div class="container">


    <div class="row mt-5">
        <div class="col-12 my-4" id="msg_detencion"></div>
        <!--<div class="col-lg-12 col-sm-12 d-flex justify-content-start align-items-center">
            <span class="span_rem">Núm. Remisión/Oficio: </span>
            <span class="span_rem_ans ml-2">20133</span>
        </div> -->

        <form id="datos_ubicacionD">


            <div class="col-lg-12 d-flex justify-content-start align-items-center">

                <?php
                $no_remision    = (isset($_GET['no_remision'])) ? $_GET['no_remision'] : '0';
                $no_ficha       = (isset($_GET['no_ficha'])) ? $_GET['no_ficha'] : '0';
                ?>


                <input type="hidden" name="no_remision_detencion" id="no_remision_detencion" value=<?= $no_remision ?>>
                <input type="hidden" name="no_ficha_detencion" id="no_ficha_detencion" value=<?= $no_ficha ?>>

                <span class="span_rem">Núm. Remisión/Oficio: </span>
                <?php if (isset($_GET['no_remision'])) { ?>
                    <span class="span_rem_ans ml-2"><?= $_GET['no_remision'] ?></span>
                <?php } ?>

                <span class="span_rem ml-5">Núm. Ficha: </span>
                <?php if (isset($_GET['no_remision'])) { ?>
                    <span class="span_rem_ans ml-2"><?= $_GET['no_ficha'] ?></span>
                <?php } ?>
            </div>

            <div class="col-lg-12 col-sm-12 d-flex align-items-center mt-5">
                <span class="form_title">Fecha: </span>
                <input type="date" class="form-control custom-input_dt fecha" value="<?php echo date('Y-m-d') ?>" name="fecha_detencion" id="fecha_detencion">
                <span class="span_error" id="fecha_detencion_error"></span>
            </div>

    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="form-row mt-5">
                <p class="label-form ml-2"> Detencion en: </p>
                <div class="form-group col-lg-12">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="domicilio_puebla_detencion" data-id="detencion" name="busqueda_puebla_detencion" class="custom-control-input" value="PUEBLA" checked>
                        <label class="custom-control-label label-form" for="domicilio_puebla_detencion">Puebla</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="domicilio_foraneo_detencion" data-id="detencion" name="busqueda_puebla_detencion" class="custom-control-input" value="FORANEO">
                        <label class="custom-control-label label-form" for="domicilio_foraneo_detencion">Foraneo</label>
                    </div>
                </div>
                <p class="label-form ml-2"> Buscar por: </p>

                <div class="form-group col-lg-12">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="porDireccion_detencion" data-id="detencion" name="busqueda" class="custom-control-input" value="0">
                        <label class="custom-control-label label-form" for="porDireccion_detencion">Dirección</label>
                    </div>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="porCoordenadas_detencion" data-id="detencion" name="busqueda" class="custom-control-input" value="1">
                        <label class="custom-control-label label-form" for="porCoordenadas_detencion">Coordenadas</label>
                    </div>
                </div>

                <div class="form-group col-lg-12 mi_hide" id="por_direccion_detencion">
                    <div class="input-group input-group-sm">
                        <input type="search" name="dir_detencion" id="dir_detencion" class="form-control text-uppercase" placeholder="Ingrese una dirección a buscar" />
                    </div>
                </div>

                <div class="form-group col-lg-12 mi_hide" id="por_coordenadas_detencion">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search_cy_detencion" id="search_cy_detencion" class="form-control pr-3 mr-3" placeholder="Coordenada Y" />
                        <input type="text" name="search_cx_detencion" id="search_cx_detencion" class="form-control pl-3 mr-3" placeholder="Coordenada X" />
                        <button type="button" class="btn btn-ssc btn-sm" id="buscar_detencion">Buscar</button>
                    </div>
                </div>
            </div>
            <div class="form-row mt-5">
                <div class="form-group col-lg-6">
                    <label for="Colonia_1" class="label-form">Colonia:</label>
                    <input type="text" autocomplete="off" class="form-control form-control-sm text-uppercase" id="Colonia_detencion" name="Colonia_detencion">
                    <span class="span_error" id="Colonia_detencion_error"></span>
                </div>

                <div class="form-group col-lg-6">
                    <label for="Fraccionamiento" class="label-form">Fraccionamiento:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Fraccionamiento_detencion" name="Fraccionamiento_detencion">
                    <span class="span_error" id="Fraccionamiento_detencion_error"></span>
                </div>

                <div class="form-group col-lg-6">
                    <label for="Calle_1" class="label-form">Calle 1:</label>
                    <input type="text" autocomplete="off" class="form-control form-control-sm text-uppercase" id="Calle_1_detencion" name="Calle_1_detencion">
                    <span class="span_error" id="Calle_1_detencion_error"></span>
                </div>

                <div class="form-group col-lg-6">
                    <label for="Calle_2" class="label-form">Calle 2:</label>
                    <input type="text" autocomplete="off" class="form-control form-control-sm text-uppercase" id="Calle_2_detencion" name="Calle_2_detencion">
                    <span class="span_error" id="Calle_2_detencion_error"></span>
                </div>

                <div class="form-group col-lg-3">
                    <label for="noInterior_1" class="label-form">Núm. de Interior:</label>
                    <input type="text" class="form-control form-control-sm" id="noInterior_detencion" name="noInterior_detencion">
                </div>

                <div class="form-group col-lg-3">
                    <label for="noExterior2" class="label-form">Núm. de Exterior</label>
                    <input type="text" class="form-control form-control-sm" id="noExterior_detencion" name="noExterior_detencion">
                </div>

                <div class="form-group col-lg-3">
                    <label for="cordY_1" class="label-form">Coordenada Y:</label>
                    <input type="text" class="form-control form-control-sm" id="cordY_detencion" name="cordY_detencion">
                    <span class="span_error" id="cordY_detencion_error"></span>
                </div>

                <div class="form-group col-lg-3">
                    <label for="cordX_1" class="label-form">Coordenada X:</label>
                    <input type="text" class="form-control form-control-sm" id="cordX_detencion" name="cordX_detencion" >
                    <span class="span_error" id="cordX_detencion_error"></span>
                </div>
                <div class="form-group col-lg-6">
                    <label for="Estado" class="label-form">Estado:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Estado_detencion" name="Estado_detencion" >
                    <span class="span_error" id="Estado_detencion_error"></span>
                </div>

                <div class="form-group col-lg-6">
                    <label for="Municipio" class="label-form">Municipio:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Municipio_detencion" name="Municipio_detencion" >
                    <span class="span_error" id="Municipio_detencion_error"></span>
                </div>

                <div class="form-group col-lg-6">
                    <label for="CP_detencion" class="label-form">Código Postal:</label>
                    <input type="text" class="form-control form-control-sm" id="CP_detencion" name="CP_detencion" onkeypress="return soloNumeros(event)">
                    <span class="span_error" id="CP_detencion_error"></span>
                </div>
                <div class="form-group col-12 col-lg-6">
                    <button type="button" class="btn btn-ssc mt-3 mi_hide" id="buscar_coordenadas_detencion">Buscar</button>
                    <button type="button" class="btn btn-ssc mt-3 mi_hide" id="buscar_direccion_detencion">Buscar</button>
                </div>
                <div class="form-group col-lg-6">
                    <label for="ZonaUH" class="label-form">Zona:</label>
                    <select class="form-control form-control-sm" id="ZonaUD" name="ZonaUD">
                        <option value="" selected disabled>SELECIONE UNA OPCIÓN</option>
                        <?php foreach ($data['datos_prim']['zonas'] as $item) : ?>
                            <option value="<?php echo $item->Zona_Sector ?>"><?php echo $item->Zona_Sector ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label for="hora" class="label-form">Hora:</label>
                    <input type="time" class="form-control form-control-sm" id="hora_detencion" name="hora_detencion">
                    <span class="span_error" id="hora_detencion_error"></span>
                </div>
                <span class="span_error" id="errorMap_detencion"></span>
            </div>
        </div>

        <div class="col-lg-6" style="display: none">
            <!-- <div class="col-12 alert alert-info">
                De momento no se tiene acceso a la api de Google Maps, por lo que la indicación es insertar campo por campo para continuar con los registros de Remisiones
            </div> -->
            <div id="map3" class=""></div>
        </div>
        <div class="col-lg-6">
            <div id='map_mapbox4'></div>
        </div>
    </div>

    <div class="mt-5">
        <div class="row">
            <div class="form-group col-lg-4">
                <label for="tipoViolencia" class="label-form">Tipo de violencia:</label>
                <select class="custom-select custom-select-sm" id="tipoViolencia" name="tipoViolencia">
                    <?php foreach ($data['ubi_detencion']['tipo_violencia'] as $item) : ?>
                        <option value="<?php echo $item->Tipo_Violencia ?>"><?php echo $item->Tipo_Violencia ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group col-lg-4">
                <label for="modalidadDetencion" class="label-form">Modalidad de la detención:</label>
                <select class="custom-select custom-select-sm" id="modalidadDetencion" name="modalidadDetencion">
                    <?php foreach ($data['ubi_detencion']['forma_detencion'] as $item) : ?>
                        <option value="<?php echo $item->Forma_Detencion ?>"><?php echo $item->Forma_Detencion ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group col-lg-4" id="modalidadDetencionContent">
                <label for="modalidadSelectDetencion" id="modalidadLabelDetencion" class="label-form">Modalidad de la detención:</label>
                <select class="custom-select custom-select-sm" id="modalidadSelectDetencion" name="modalidadSelectDetencion">
                </select>
            </div>

            <div class="form-group col-lg-12 mt-3">
                <label for="observaciondesDetencion" class="label-form">Observaciones:</label>
                <textarea class="form-control text-uppercase" id="observaciones_detencion" name="observaciones_detencion" rows="6" maxlength="600"></textarea>
                <span class="span_error" id="observaciones_detencion_error"></span>
            </div>
        </div>
    </div>



    <!--<div class="row mt-5 mb-5">
        <div class="col-12 d-flex justify-content-end col-sm-12">
            <btn class="btn btn-sm btn-ssc" onclick="ValidarUbicacionD()" id="btn_ubicacionD">Guardar</btn>
        </div>
    </div> -->

    <?php if (!isset($data['tabs']['ubicacionD'])) { ?>
        <div class="row mt-5 mb-5">
            <div class="col-12 d-flex justify-content-between col-sm-12">
                <a class="btn btn-sm btn-ssc btn-tab-getIndex" id="btn-tab-getIndex-6" data-id="6" message="msg_detencion">Validar</a>
                <div>
                    <a class="btn btn-sm btn-ssc" onclick="ValidarUbicacionD()" id="btn_ubicacionD" value="1">Guardar</a>
                    <span class="advise-span text-center ml-2 mt-2 span-message" id="span-message-6">* Lo sentimos, el tab ha sido validado. Su usuario no tiene los permisos necesarios para editar</span>
                </div>
            </div>
        </div>
    <?php } else if (isset($data['tabs']['ubicacionD']) && $data['tabs']['ubicacionD'] == 0) { ?>
        <div class="col-12 mt-5 mb-5">
            <div class="alert alert-warning text-center" role="alert">
                Un registro de Ubicación de los hechos ha sido creado previamente, puedes dirigirte a la pantalla principal de Remisiones para editar la información guardada
            </div>
        </div>

        <div class="row mt-5 mb-5" style="visibility: hidden;">
            <div class="col-12 d-flex justify-content-between col-sm-12">
                <a class="btn btn-sm btn-ssc btn-tab-getIndex" data-id="6" id="btn-tab-getIndex-6" mesage="msg_detencion">Validar</a>
                <div>
                    <a class="btn btn-sm btn-ssc" onclick="ValidarUbicacionD()" id="btn_ubicacionD" value="1">Guardar</a>
                    <span class="advise-span text-center ml-2 mt-2 span-message" id="span-message-6">* Lo sentimos, el tab ha sido validado. Su usuario no tiene los permisos necesarios para editar</span>
                </div>
            </div>
        </div>
    <?php } ?>

    </form>
</div>