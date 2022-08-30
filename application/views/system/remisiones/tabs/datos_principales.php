<div class="container">
    <form id='datos_principales'>

        <?php
        $no_remision    = (isset($_GET['no_remision'])) ? $_GET['no_remision'] : '0';
        $no_ficha       = (isset($_GET['no_ficha'])) ? $_GET['no_ficha'] : '0';
        ?>


        <input type="hidden" name="no_remision_principales" id="no_remision_principales" value=<?= $no_remision ?>>
        <input type="hidden" name="no_ficha_principales" id="no_ficha_principales" value=<?= $no_ficha ?>>
        <div class="row mt-5">

            <div class="col-12 my-4" id="msg_principales"></div>
            <div class="col-lg-3 col-sm-12 center-movil-flex d-flex justify-content-start align-items-center">
                <span class="span_rem">Núm. Remisión/Oficio: </span>
                <?php
                if (isset($_GET['no_remision']))
                    echo '<span class="span_rem_ans ml-2s" name="oficio_principales"> ' . $_GET['no_remision'] . '</span>';
                else
                    echo '<span class="span_rem_ans" name="oficio_principales"> - </span>';
                ?>
            </div>

            <div class="col-lg-3 col-sm-12 center-movil-flex d-flex justify-content-end align-items-center">
                <span class="span_rem">Folio 911: </span>
                <input type="text" name="911_principales" id="911_principales" class="form-control custom-input_dt fecha" placeholder="Ingresa folio 911" onkeypress="return valideKey(event);">
                <span class="span_error" id="911_principalesError"></span>
            </div>

            <div class="col-lg-3 col-sm-12 center-movil-flex d-flex justify-content-end align-items-center">
                <span class="span_rem">Fecha: </span>
                <input type="date" name="fecha_principales" id="fecha_principales" class="form-control custom-input_dt fecha" value="<?php  ?>">
                <span class="span_error" id="fechaP_error"></span>
            </div>

            <div class="col-lg-3 col-sm-12 center-movil-flex d-flex justify-content-end align-items-center">
                <span class="span_rem">Hora:</span>
                <input type="time" name="hora_principales" id="hora_principales" class="form-control custom-input_dt hora" value="<?php  ?>">
                <span class="span_error" id="hora_error"></span>
            </div>
        </div>

        <div class="form-row mt-5">
            <fieldset class="form-group col-lg-12 mi_hide">
                <legend class="col-form-label pl-1">Tipo ficha:</legend>
                <div class="container ml-1">
                    <div class="row">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipoFicha" id="tipoFicha1" value="POLICÍA" checked onclick="zonaSector('zonaContent','sectorContent')">
                            <label class="form-check-label" for="tipoFicha1">
                                Policía
                            </label>
                        </div>
                        <div class="form-check ml-3">
                            <input class="form-check-input" type="radio" name="tipoFicha" id="tipoFicha2" value="TRÁNSITO" onclick="zonaSector('sectorContent','zonaContent')">
                            <label class="form-check-label" for="tipoFicha2">
                                Tránsito
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="form-group col-lg-4" id="zonaContent">
                <label for="zona" class="label-form">Zona:</label>
                <select class="custom-select custom-select-sm" id="zona" name="zona">
                    <?php foreach ($data['datos_prim']['zonas'] as $item) : ?>
                        <option value="<?php echo $item->Zona_Sector ?>"><?php echo $item->Zona_Sector ?></option>
                    <?php endforeach ?>
                </select>
                <span class="span_error" id="zona_error"></span>
            </div>
            <div class="form-group col-lg-4" id="sectorContent">
                <label for="Sector" class="label-form">Sector:</label>
                <select class="custom-select custom-select-sm" id="sector" name="sector">
                    <?php foreach ($data['datos_prim']['sectores'] as $item) : ?>
                        <option value="<?php echo $item->Zona_Sector ?>"><?php echo $item->Zona_Sector ?></option>
                    <?php endforeach ?>
                </select>
                <span class="span_error" id="sector_error"></span>
            </div>
            <div class="form-group col-lg-4">
                <label for="CIA_principales" class="label-form">CIA:</label>
                <select class="custom-select custom-select-sm" id="CIA_principales" name="CIA_principales">
                    <option value="PRIMERO">PRIMERA</option>
                    <option value="SEGUNDO">SEGUNDA</option>
                </select>
                <span class="span_error" id="cia_error"></span>
            </div>
            <div class="form-group col-lg-4">
                <label for="Remitido" class="label-form">Remitido a:</label>
                <select class="custom-select custom-select-sm" id="Remitido" name="Remitido">
                    <option selected disabled>Seleccione</option>
                    <option value="M.P. FUERO COMÚN">M.P. FUERO COMÚN</option>
                    <option value="M.P. FEDERAL">M.P. FEDERAL</option>
                    <option value="MIGRACION">MIGRACIÓN</option>
                    <option value="JUEZ DE JUSTICIA CÍVICA">JUEZ DE JUSTICIA CÍVICA</option>
                    <option value="ADOLESCENTES I.">ADOLESCENTES I.</option>
                </select>

                <span class="span_error" id="remitido_error"></span>
            </div>



            <input type="hidden" value="1" id="statusR_principales" name="statusR_principales">
            <!-- <div class="form-group col-lg-2 pl-6 mi_hide">
                <label for="Status" class="label-form">Estatus: </label>
                <select class="custom-select custom-select-sm" id="statusR_principales" name="statusR_principales">
                    <option value="1">ACTIVA</option>
                </select>
            </div> -->

            <!--<div class="form-group col-lg-6">
                <label for="Averiguacion_principales" class="label-form">Carpeta de investigación</label>
                <input type="text" class="form-control form-control-sm" id="Averiguacion_principales">
                <span class="span_error" id="carpeta_error"></span>
            </div>-->

            <?php if (!isset($_GET['no_ficha'])) { ?>

                <fieldset class="form-group col-lg-6">
                    <legend class="col-form-label pl-1">Núm. de ficha</legend>
                    <div class="container ml-1">
                        <div class="row">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ficha" id="ficha1" value="No" checked onclick="showHide('ficha')">
                                <label class="form-check-label" for="fichaNueva">
                                    Nueva
                                </label>
                            </div>
                            <div class="form-check ml-5">
                                <input class="form-check-input" type="radio" name="ficha" id="ficha2" value="Si" onclick="showHide('ficha')">
                                <label class="form-check-label" for="fichaExistente">
                                    Existente
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="form-group col-lg-3">
                    <div id="ficha">
                        <div class="form-row">
                            <div class="form-group col-lg-12">
                                <label for="id_ficha" class="label-form">Fichas:</label>
                                <select class="custom-select custom-select-sm" id="id_ficha" name="No_Ficha">
                                    <?= $data['fichas_select']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } else { ?>

                <div class="form-group col-lg-9 align-items-center">
                    <span class="span_rem">Núm. Ficha: </span>
                    <span class="span_rem_ans ml-2" name="oficio_principales"><?php echo $_GET['no_ficha']; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="cancelar_ficha" name="cancelar_ficha" value="cancelada">
                        <label class="custom-control-label" for="cancelar_ficha" style="font-size: 15px;">Cancelar Ficha</label>
                    </div>
                    <input type="text" class="custom-control-input" id="estado_ficha_original" name="estado_ficha_original" style="display: none">
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="cancelar_remision" name="cancelar_remision" value="cancelada">
                        <label class="custom-control-label" for="cancelar_remision" style="font-size: 15px;">Cancelar Remision</label>
                    </div>
                </div>

            <?php } ?>

            <div class="form-group col-lg-4">
                <label for="Nombre_principales" class="label-form">Nombres:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Nombre_principales" name="Nombre_principales" >
                <span class="span_error" id="Nombre_principales_error"></span>
            </div>

            <div class="form-group col-lg-4">
                <label for="appPaterno_principales" class="label-form">Apellido paterno:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="appPaterno_principales" name="appPaterno_principales" >
                <span class="span_error" id="appPaterno_principales_error"></span>
            </div>

            <div class="form-group col-lg-4">
                <label for="appMaterno_principales" class="label-form">Apellido materno:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="appMaterno_principales" name="appMaterno_principales" >
                <span class="span_error" id="appMaterno_principales_error"></span>
            </div>

            <div class="form-group col-lg-2">
                <label for="edad_principales" class="label-form">Edad:</label>
                <input type="number" class="form-control form-control-sm" id="edad_principales" name="edad_principales" maxlength="2" >
                <span class="span_error" id="edad_principales_error"></span>
            </div>

            <div class="form-group col-lg-2">
                <label for="sexo_principales" class="label-form">Sexo:</label>
                <input type="hidden" class="form-control form-control-sm" id="sexo_principales_1" name="sexo_principales_1" >
                <select class="custom-select custom-select-sm" id="sexo_principales" name="sexo_principales" >
                    <option value="h">HOMBRE</option>
                    <option value="m">MUJER</option>
                </select>
                <span class="span_error" id="sexo_principales_error"></span>
            </div>

            <div class="form-group col-lg-4">
                <label for="escolaridad_principales" class="label-form">Escolaridad:</label>
                <select class="custom-select custom-select-sm" id="escolaridad_principales" name="escolaridad_principales">
                    <?php foreach ($data['datos_prim']['escolaridad'] as $item) : ?>
                        <option value="<?php echo $item->Escolaridad ?>"><?php echo $item->Escolaridad ?></option>
                    <?php endforeach ?>
                </select>
                <span class="span_error" id="escolaridad_principales_error"></span>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-lg-4">
                <label for="CURP_principales" class="label-form">CURP:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="CURP_principales" name="CURP_principales" maxlength="18">
                <span class="span_error" id="CURP_principales_error"></span>
            </div>

            <div class="form-group col-lg-4 d-flex justify-content-center align-items-end">
                <a href="javascript:ventanaSecundaria('https://www.gob.mx/curp/')" class="url">Consulta CURP</a>
            </div>

            <div class="form-group col-lg-4 d-flex justify-content-center align-items-end">
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="verificado_principales" name="verificado_principales" value="1">
                    <label class="custom-control-label" for="verificado_principales" style="font-size: 14px;">CURP validada</label>
                </div>
            </div>          
            <div class="form-group col-lg-4">
                <p class="label-form ml-2"> Nacionalidad: </p>
                <div class="form-group col-lg-12">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="nacionalidad_mexicana" data-id="principales" name="nacionalidad" class="custom-control-input" value="MEXICANA">
                        <label class="custom-control-label label-form" for="nacionalidad_mexicana">Mexicana</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="nacionalidad_extranjera" data-id="principales" name="nacionalidad" class="custom-control-input" value="EXTRANJERA">
                        <label class="custom-control-label label-form" for="nacionalidad_extranjera">Extranjera</label>
                    </div>
                </div>
            </div>
            <div class="form-group col-lg-4" id="estado_nacimiento">
                <label for="procedencia_estado_principales" class="label-form">Estado de nacimiento:</label>
                <select class="custom-select custom-select-sm" id="procedencia_estado_principales" name="procedencia_estado_principales">
                    <?php foreach ($data['datos_prim']['estados'] as $item) : ?>
                        <option value="<?php echo $item->Estado ?>"><?php echo $item->Estado ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group col-lg-4" id="procedencia_principales_div">
                <label for="procedencia_principales" class="label-form" id="label_procedencia">Procedencia:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="procedencia_principales" name="procedencia_principales">
                <span class="span_error" id="procedencia_principales_error"></span>
            </div>

            <div class="form-group col-lg-3 d-flex justify-content-center align-items-end">
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="alcoholemia_principales" name="alcoholemia_principales" value="1">
                    <label class="custom-control-label" for="alcoholemia_principales" style="font-size: 14px;">Presunción de intoxicación</label>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-6">
                <p class="form_title">Domicilio: </p>
                <div class="form-row mt-3">
                    <p class="label-form ml-2"> Domicilio en: </p>
                    <div class="form-group col-lg-12">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="domicilio_puebla" data-id="principales" name="busqueda_puebla" class="custom-control-input" value="PUEBLA" checked>
                            <label class="custom-control-label label-form" for="domicilio_puebla">Puebla</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="domicilio_foraneo" data-id="principales" name="busqueda_puebla" class="custom-control-input" value="FORANEO">
                            <label class="custom-control-label label-form" for="domicilio_foraneo">Foraneo</label>
                        </div>
                    </div>
                    <p class="label-form ml-2"> Buscar por: </p>

                    <div class="form-group col-lg-12">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="porDireccion" data-id="principales" name="busqueda" class="custom-control-input" value="0">
                            <label class="custom-control-label label-form" for="porDireccion">Dirección</label>
                        </div>

                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="porCoordenadas" data-id="principales" name="busqueda" class="custom-control-input" value="1">
                            <label class="custom-control-label label-form" for="porCoordenadas">Coordenadas</label>
                        </div>
                    </div>

                    <div class="form-group col-lg-12 mi_hide" id="por_direccion">
                        <div class="input-group input-group-sm">
                            <input type="search" id="dir" class="form-control text-uppercase" placeholder="Ingrese una dirección a buscar" />
                        </div>
                    </div>

                    <div class="form-group col-lg-12 mi_hide" id="por_coordenadas">
                        <div class="input-group input-group-sm">
                            <input type="text" id="search_cy" class="form-control pr-3 mr-3" placeholder="Coordenada Y" />
                            <input type="text" id="search_cx" class="form-control pl-3 mr-3" placeholder="Coordenada X" />
                            <button type="button" class="btn btn-ssc btn-sm" id="buscar">Buscar</button>
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="Colonia" class="label-form">Colonia:</label>
                        <input type="text" autocomplete="off" class="form-control form-control-sm text-uppercase" id="Colonia" name="Colonia">
                        <span class="span_error" id="Colonia_principales_error"></span>

                    </div>

                    <div class="form-group col-lg-6">
                        <label for="Calle" class="label-form">Calle:</label>
                        <input type="text" autocomplete="off" class="form-control form-control-sm text-uppercase" id="Calle" name="Calle">
                        <span class="span_error" id="Calle_principales_error"></span>

                    </div>

                    <div class="form-group col-lg-3">
                        <label for="noExterior" class="label-form">Núm. de Exterior:</label>
                        <input type="text" class="form-control form-control-sm" id="noExterior" name="noExterior">
                        <span class="span_error" id="noExterior_principales_error"></span>
                    </div>
                    
                    <div class="form-group col-lg-3">
                        <label for="noInterior" class="label-form">Núm. de Interior:</label>
                        <input type="text" class="form-control form-control-sm" id="noInterior" name="noInterior">
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordY" class="label-form">Coordenada Y:</label>
                        <input type="text" class="form-control form-control-sm" id="cordY" name="cordY" >
                        <span class="span_error" id="cordY_principales_error"></span>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordX" class="label-form">Coordenada X:</label>
                        <input type="text" class="form-control form-control-sm" id="cordX" name="cordX" >
                        <span class="span_error" id="cordX_principales_error"></span>
                    </div>


                    <div class="form-group col-lg-6">
                        <label for="Estado" class="label-form">Estado:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Estado" name="Estado" >
                        <span class="span_error" id="Estado_principales_error"></span>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="Municipio" class="label-form">Municipio:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Municipio" name="Municipio" >
                        <span class="span_error" id="Municipio_principales_error"></span>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="CP" class="label-form">Código Postal:</label>
                        <input type="text" class="form-control form-control-sm" id="CP" name="CP" onkeypress="return soloNumeros(event) ">
                        <span class="span_error" id="CP_principales_error"></span>
                    </div>
                    <span class="span_error" id="errorMap"></span>
                    <div class="form-group col-lg-6">
                        <button type="button" class="btn btn-ssc mt-3 mi_hide" id="buscar_coordenadas_principales">Buscar</button>
                        <button type="button" class="btn btn-ssc mt-3 mi_hide" id="buscar_direccion_principales">Buscar</button>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" style="display: none">
                <!-- <div class="col-12 alert alert-info">
                    De momento no se tiene acceso a la api de Google Maps, por lo que la indicación es insertar campo por campo para continuar con los registros de Remisiones
                </div> -->
                <div id="map"></div>
            </div>
            <div class="col-lg-6">
                <div id='map_mapbox3'></div>
            </div>
        </div>


        <div class="form-row mt-5">

            <div class="form-group col-lg-12">
                <label for="pertenencias_rem" class="label-form">Pertenencias del remitido:</label>
                <textarea class="form-control text-uppercase" id="pertenencias_rem" name="pertenencias_rem" rows="6" maxlength="8000"></textarea>
                <span class="span_error" id="pertenencias_rem_error"></span>
            </div>




            <div class="form-row mt-5">

                <p class="label-form ml-2 "> Datos adicionales: </p>

                <!--<div class="form-group col-lg-12">

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="dp_mostrar" name="dp_ocultar_mostrar" class="custom-control-input" value="1" checked>
                        <label class="custom-control-label label-form" for="dp_mostrar">Mostrar</label>
                    </div>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="dp_ocultar" name="dp_ocultar_mostrar" class="custom-control-input" value="0">
                        <label class="custom-control-label label-form" for="dp_ocultar">Ocultar</label>
                    </div>
                </div>-->

            </div>
        </div>


        <div class="form-row mt-3" id="ext_1">
            <div class="form-group col-lg-4">
                <label for="Fecha_n" class="label-form">Fecha de nacimiento:</label>
                <input type="date" class="form-control form-control-sm" id="FechaNacimiento_principales" name="FechaNacimiento_principales">
                <span class="span_error" id="FechaNacimiento_principales_error"></span>
            </div>

            <div class="form-group col-lg-4">
                <label for="RFC" class="label-form">RFC:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="RFC_principales" name="RFC_principales" maxlength="10">
                <span class="span_error" id="RFC_principales_error"></span>
            </div>

            <div class="form-group col-lg-4">
                <label for="Correo" class="label-form">Correo:</label>
                <input type="mail" class="form-control form-control-sm" id="correo_principales" name="correo_principales">
                <span class="span_error" id="correo_principales_error"></span>
            </div>


            <div class="form-group col-lg-4">
                <label for="Ocupacion" class="label-form">Ocupación:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Ocupacion_principales" name="Ocupacion_principales">
                <span class="span_error" id="Ocupacion_principales_error"></span>
            </div>

            <div class="form-group col-lg-4">
                <label for="Facebook" class="label-form">Redes sociales:</label>
                <input type="text" class="form-control form-control-sm" id="Facebook_principales" name="Facebook_principales">
                <span class="span_error" id="Facebook_principales_error"></span>
            </div>

            <div class="form-group col-lg-4">
                <label for="edoCivil" class="label-form">Estado Civil:</label>
                <select class="custom-select custom-select-sm" id="edoCivil_principales" name="edoCivil_principales">
                    <option selected value="1">SOLTERO</option>
                    <option value="2">CASADO</option>
                </select>
            </div>

            <div class="form-group col-lg-4">
                <label for="Telefono" class="label-form">Teléfono:</label>
                <input type="text" class="form-control form-control-sm" id="Telefono_principales" name="Telefono_principales" onkeypress="return valideKey(event);" maxlength="10">
                <span class="span_error" id="Telefono_principales_error"></span>
            </div>

            <div class="form-group col-lg-4">
                <label for="imei_1" class="label-form">IMEI 1:</label>
                <input type="text" class="form-control form-control-sm" id="imei_1_principales" name="imei_1_principales" onkeypress="return valideKey(event);" minlength="14" maxlength="16">
                <span class="span_error" id="imei_1_principales_error"></span>
            </div>

            <div class="form-group col-lg-4">
                <label for="imei_2" class="label-form">IMEI 2 (Opcional):</label>
                <input type="text" class="form-control form-control-sm" id="imei_2_principales" name="imei_2_principales" onkeypress="return valideKey(event);" minlength="14" maxlength="16">
                <span class="span_error" id="imei_2_principales_error"></span>
            </div>
        </div>

        <div class="form-row mt-3" id='ext_2'>
            <div class="col-lg-12">
                <div class="form-row">
                    <div class="form-group col-lg-12">
                        <label for="Alias" class="label-form">Alias:</label>
                        <div class="d-flex justify-content-center align-items-center">
                            <input type="text" class="form-control form-control-sm text-uppercase" id="Alias" placeholder="separe cada alias con una coma ','" name="Alias">
                            <span class="span_error" id="pertenencias_rem_error"></span>
                            <!--<i class="material-icons md-24 ssc ml-2 icon-pointer" id="addAlias">add</i> -->
                        </div>
                    </div>
                </div>
            </div>

            <!--<div class="col-lg-6">
                <div id="contenido"></div>
            </div> -->

        </div>

        <div class="row mt-5 mb-5">
            <div class="d-flex justify-content-between col-sm-12" id="id_p">
                <a class="btn btn-sm btn-ssc btn-tab-getIndex" id="btn-tab-getIndex-0" data-id="0" message="msg_principales">Validar</a>
                <div>
                    <a class="btn btn-sm btn-ssc" id="btn_principal" value='1'>Guardar</a>
                    <span class="advise-span text-center ml-2 mt-2 span-message" id="span-message-0">* Lo sentimos, el tab ha sido validado. Su usuario no tiene los permisos necesarios para editar</span>
                </div>
            </div>
        </div>
    </form>

</div>