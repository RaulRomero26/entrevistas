<div class="container">


    <form id="datos_ubicacionH">

        <div class="row mt-5">

            <div class="col-12 my-4" id="msg_ubicacionHechos"></div>
            <div class="col-lg-4 d-flex justify-content-start align-items-center">

                <?php
                $no_remision    = (isset($_GET['no_remision'])) ? $_GET['no_remision'] : '0';
                $no_ficha       = (isset($_GET['no_ficha'])) ? $_GET['no_ficha'] : '0';
                ?>


                <input type="hidden" name="no_remision_ubicacionHechos" id="no_remision_ubicacionHechos" value=<?= $no_remision ?>>
                <input type="hidden" name="no_ficha_ubicacionHechos" id="no_ficha_ubicacionHechos" value=<?= $no_ficha ?>>


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

        <div class="row">
            <div class="col-lg-6">
                <div class="form-row mt-5">
                    <p class="label-form ml-2"> Buscar por:</p>

                    <div class="form-group col-lg-12">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="porDireccion_hechos" data-id="hechos" name="busqueda" class="custom-control-input" value="0">
                            <label class="custom-control-label label-form" for="porDireccion_hechos">Dirección</label>
                        </div>

                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="porCoordenadas_hechos" data-id="hechos" name="busqueda" class="custom-control-input" value="1">
                            <label class="custom-control-label label-form" for="porCoordenadas_hechos">Coordenadas</label>
                        </div>
                    </div>

                    <div class="form-group col-lg-12 mi_hide" id="por_direccion_hechos">
                        <div class="input-group input-group-sm">
                            <input type="search" id="dir_hechos" class="form-control text-uppercase" placeholder="Ingrese una dirección a buscar" />
                        </div>
                    </div>

                    <div class="form-group col-lg-12 mi_hide" id="por_coordenadas_hechos">
                        <div class="input-group input-group-sm">
                            <input type="text" name="search_cy_hechos" id="search_cy_hechos" class="form-control pr-3 mr-3" placeholder="Coordenada Y" />
                            <input type="text" name="search_cx_hechos" id="search_cx_hechos" class="form-control pl-3 mr-3" placeholder="Coordenada X" />
                            <button type="button" class="btn btn-ssc btn-sm" id="buscar_hechos">Buscar</button>
                        </div>
                    </div>
                </div>
                <div class="form-row-mt-5">    
                    <div class="form-row mt-2">
                        <div class="form-group col-lg-6">
                            <label for="Colonia" class="label-form">Colonia:</label>
                            <input type="text" autocomplete="off" class="form-control form-control-sm text-uppercase" id="Colonia_hechos" name="Colonia_hechos">
                            <span class="span_error" id="Colonia_hechos_error"></span>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="Fraccionamiento" class="label-form">Fraccionamiento:</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="Fraccionamiento_hechos" name="Fraccionamiento_hechos">
                            <span class="span_error" id="Fraccionamiento_hechos_error"></span>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="Calle" class="label-form">Calle 1:</label>
                            <input type="text" autocomplete="off" class="form-control form-control-sm text-uppercase" id="Calle_hechos" name="Calle_hechos">
                            <span class="span_error" id="Calle_hechos_error"></span>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="Calle" class="label-form">Calle 2:</label>
                            <input type="text" autocomplete="off" class="form-control form-control-sm text-uppercase" id="Calle2_hechos" name="Calle2_hechos">
                            <span class="span_error" id="Calle2_hechos_error"></span>
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="noInterior" class="label-form">Núm. de Interior:</label>
                            <input type="text" class="form-control form-control-sm" id="noInterior_hechos" name="noInterior_hechos">
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="noExterior" class="label-form">Núm. de Exterior:</label>
                            <input type="text" class="form-control form-control-sm" id="noExterior_hechos" name="noExterior_hechos">
                        </div>
                        
                        <div class="form-group col-lg-3">
                            <label for="cordY" class="label-form">Coordenada Y:</label>
                            <input type="text" class="form-control form-control-sm" id="cordY_hechos" name="cordY_hechos" >
                            <span class="span_error" id="cordY_hechos_error"></span>
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="cordX" class="label-form">Coordenada X:</label>
                            <input type="text" class="form-control form-control-sm" id="cordX_hechos" name="cordX_hechos" >
                            <span class="span_error" id="cordX_hechos_error"></span>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="CP_hechos" class="label-form">Código Postal:</label>
                            <input type="text" class="form-control form-control-sm" id="CP_hechos" name="CP_hechos" onkeypress="return soloNumeros(event) ">
                            <span class="span_error" id="CP_hechos_error"></span>
                        </div>
                        <div class="form-group col-12 col-lg-12">
                            <button type="button" class="btn btn-ssc mt-3 mi_hide" id="buscar_coordenadas_hechos">Buscar</button>
                            <button type="button" class="btn btn-ssc mt-3 mi_hide" id="buscar_direccion_hechos">Buscar</button>
                        </div>
                        

                        <!-- <div class="form-group col-lg-6">
                            <label for="ZonaUH" class="label-form">Zona:</label>
                            <select class="form-control form-control-sm" id="ZonaUH" name="ZonaUH">
                                <option value="" selected disabled>SELECIONE UNA OPCIÓN</option>
                                <?php foreach ($data['datos_prim']['zonas'] as $item) : ?>
                                    <option value="<?php echo $item->Zona_Sector ?>"><?php echo $item->Zona_Sector ?></option>
                                <?php endforeach ?>
                            </select>
                        </div> -->

                        <div class="form-group col-lg-6">
                            <label for="VectorUH" class="label-form">Vector:</label>
                            <select class="form-control form-control-sm" id="VectorUH" name="VectorUH">
                                <option value="" selected disabled>SELECIONE UNA OPCIÓN</option>
                            </select>
                            <span class="span_error" id="VectorUH_hechos_error"></span>
                            
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="CP_hechos" class="label-form">Código Postal:</label>
                            <input type="text" class="form-control form-control-sm" id="CP_hechos" name="CP_hechos" onkeypress="return soloNumeros(event) ">
                            <span class="span_error" id="CP_hechos_error"></span>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="hora" class="label-form">Hora de los hechos:</label>
                            <input type="time" class="form-control form-control-sm" id="hora_hechos" name="hora_hechos">
                            <span class="span_error" id="hora_hechos_error"></span>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="participantes_hechos" class="label-form">Núm. de participantes:</label>
                            <input type="text" class="form-control form-control-sm" id="participantes_hechos" name="participantes_hechos" onkeypress="return valideKey(event);" readonly>
                            <span class="span_error" id="participantes_hechos_error"></span>
                        </div>
                        <span class="span_error" id="errorMap_hechos"></span>


                        <!--
                        <div class="form-group col-lg-6">
                            <label for="Estado" class="label-form">Estado:</label>
                            <input type="text" class="form-control form-control-sm" id="Estado_hechos" name="Estado_hechos">
                            <span class="span_error" id="Estado_hechos_error"></span>
                        </div> 

                        <div class="form-group col-lg-6">
                            <label for="Municipio" class="label-form">Municipio:</label>
                            <input type="text" class="form-control form-control-sm" id="Municipio_hechos" name="Municipio_hechos">
                            <span class="span_error" id="Municipio_hechos_error"></span>
                        </div> -->
                    </div>


                </div>
            </div>

            <div class="col-lg-6" style="display: none">
                <!-- <div class="col-12 alert alert-info">
                    De momento no se tiene acceso a la api de Google Maps, por lo que la indicación es insertar campo por campo para continuar con los registros de Remisiones
                </div> -->
                <div id="map2"></div>
            </div>
            <div class="col-lg-6">
                <div id='map_mapbox'></div>
            </div>
        </div>

        <div class="mt-5">
            <p class="form_title">Datos del delito: </p>
            <div class="row">



                <div class="form-group col-lg-10 ">
                    <label for="RemitidoPor" class="label-form">Detenido por:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="RemitidoPor" name="RemitidoPor">
                    <span class="span_error" id="RemitidoPor_error"></span>
                </div>

                <div class="form-group col-lg-2 mt-auto d-flex justify-content-center">
                    <div class="row">
                        <div class="col-auto form-check">
                            <input class="form-check-input" type="radio" name="Falta_Delito_Tipo" id="Falta_Delito_Tipo1" value="F" checked readonly>
                            <label class="form-check-label" for="tipoFicha1">
                                Falta Administrativa
                            </label>
                        </div>
                        <div class="col-auto form-check">
                            <input class="form-check-input" type="radio" name="Falta_Delito_Tipo" id="Falta_Delito_Tipo2" value="D" readonly>
                            <label class="form-check-label" for="tipoFicha2">
                                Delito
                            </label>
                        </div>

                    </div>
                </div>

                <div class="col-lg-2 offset-lg-10 mt-n1 d-flex justify-content-center">
                    <span class="span_error" id="Falta_Delito_Tipo_error"></span>
                </div>


                <div class="col-12 my-4" id="msg_ubicacionHechosFalta">
                    <div class="alert alert-warning text-center" role="alert">Está editando una falta / delito</div>
                </div>



                <div class="form-group col-lg-4" id="div_delito_1">
                    <label for="objetorecuperado" class="label-form">Remitido por:</label>
                    <select class="custom-select custom-select-sm" id="delito_1" name="delito_1">
                    </select>
                    <span class="span_error" style="font-size: 11px;" id="letrero_1">
                        <!-- *Deberas seleccionar la autoridad a la que el ciudadano fue remitido para cargar
                        la lista de delitos en la pestaña "Datos principales" -->
                    </span>
                </div>

                <div class="form-group col-lg-3" id="div_ruta_1">
                    <label for="Municipio" class="label-form">Ruta:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="ruta" name="ruta">
                    <span class="span_error" id="ruta_error"></span>
                </div>

                <div class="form-group col-lg-4" id="div_unidad_1">
                    <label for="Municipio" class="label-form">Unidad:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="unidad" name="unidad">
                    <span class="span_error" id="unidad_error"></span>
                </div>

                <div class="form-group col-lg-7" id="div_negocio_1">
                    <label for="Municipio" class="label-form">Nombre del comercio afectado:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="negocio" name="negocio">
                    <span class="span_error" id="negocio_error"></span>
                </div>

                <div class="col-lg-1 d-flex align-items-center justify-content-center" id="div_btnNew">
                    <button type="button" class="btn btn-primary button-movil-plus" onclick="agregarFila()">+</button>
                </div>

                <div class="col-lg-1 d-flex align-items-center justify-content-center" id="div_btnSave" style='display: none !important ;'>
                    <button type="button" class="btn btn-primary button-movil-plus material-icons" id="btnSave">save</button>
                </div>




            </div>
        </div>

        <div class="mt-5">
            <div class="table-responsive">
                <table class="table table-bordered" id="FaltaDelitoTabla">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th scope="col">Falta / Delito</th>
                            <th scope="col">* Nombre del comercio afectado</th>
                            <th scope="col">* RUTA</th>
                            <th scope="col">* Unidad</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id='tbodyFaltaDelito'>

                    </tbody>
                </table>
            </div>
        </div>


        <div class="mt-5 text-center"><span class="span_error" id="FaltaDelitoError"></span></div>
        <div class="mt-5 text-center"> <span class="advise-span text-center">* Estos campos pueden variar de acuerdo a la falta / delito seleccionado.</span> </div>





        <?php if (!isset($data['tabs']['hechos'])) { ?>
            <div class="row mt-5 mb-5">
                <div class="col-12 d-flex justify-content-between col-sm-12">
                    <a class="btn btn-sm btn-ssc btn-tab-getIndex" id="btn-tab-getIndex-2" data-id="2" message="msg_ubicacionHechos">Validar</a>
                    <div>
                        <btn class="btn btn-sm btn-ssc" onclick="ValidarUbicacionH()" id="btn_ubicacionH">Guardar</btn>
                        <span class="advise-span text-center ml-2 mt-2 span-message" id="span-message-2">* Lo sentimos, el tab ha sido validado. Su usuario no tiene los permisos necesarios para editar</span>
                    </div>
                </div>
            </div>
        <?php } else if (isset($data['tabs']['hechos']) && $data['tabs']['peticionario'] == 1) { ?>
            <div class="col-12 mt-5 mb-5">
                <div class="alert alert-warning text-center" role="alert">
                    Un registro de Ubicación de los hechos ha sido creado previamente, puedes dirigirte a la pantalla principal de Remisiones para editar la información guardada
                </div>
            </div>

            <div class="row mt-5 mb-5" style="visibility: hidden;">
                <div class="col-12 d-flex justify-content-between col-sm-12">
                    <a class="btn btn-sm btn-ssc btn-tab-getIndex" id="btn-tab-getIndex-2" data-id="2" message="msg_ubicacionHechos">Validar</a>
                    <div>
                        <btn class="btn btn-sm btn-ssc" onclick="ValidarUbicacionH()" id="btn_ubicacionH" disabled>Guardar</btn>
                        <span class="advise-span text-center ml-2 mt-2 span-message" id="span-message-2">* Lo sentimos, el tab ha sido validado. Su usuario no tiene los permisos necesarios para editar</span>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!--<div class="row mt-5 mb-5">
            <div class="col-12 d-flex justify-content-end col-sm-12">
                <btn class="btn btn-sm btn-ssc" onclick="ValidarUbicacionH()" id="btn_ubicacionH">Guardar</btn>
            </div>
        </div>-->
    </form>

</div>