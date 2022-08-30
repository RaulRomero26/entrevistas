<div class="container">
        <div class="paragraph-title d-flex justify-content-between mt-5 mb-4">
        <h5> 
            <a href="<?= base_url;?>Vehiculos">Vehiculos</a>
            <span> /Editar </span>
        </h5>
        </div>
</div>
<div class="container">
    <form id='datos_editarvehiculo' onsubmit="event.preventDefault()">
        <?php
        $no_vehiculo    = (isset($_GET['id_vehiculo'])) ? $_GET['id_vehiculo'] : '0';
        ?>
        <input type="hidden" name="no_vehiculo_" id="no_vehiculo_" value=<?= $no_vehiculo ?>>
        <input type="hidden" name="es_admin" id="es_admin" value=<?= $_SESSION['userdata']->Modo_Admin ?>>
        <span class="span_error" id="inputsVehiculosE_error"></span>
        <div class="row d-flex align-items-center justify-content-center" id="Form_vehiculoE">
            <?php
            if ($_SESSION['userdata']->Modo_Admin == 1) { ?>
            <div class="form-group col-lg-12 custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" class="custom-control-input" id="cambiar_ficha" name="cambiar_ficha" value="inactivar">
                <label class="custom-control-label" for="cambiar_ficha" style="font-size: 15px;">Cambiar ficha</label>
            </div>
            <?php } 
            else{ ?>
            <div class="form-group col-lg-12 custom-control custom-checkbox custom-control-inline mi_hide">
                <input type="checkbox" class="custom-control-input" id="cambiar_ficha" name="cambiar_ficha" value="inactivar">
                <label class="custom-control-label" for="cambiar_ficha" style="font-size: 15px;">Cambiar ficha</label>
            </div>
            <?php } ?>
            <div class="form-group col-lg-6"  id="tipo_fichaEditar">
                <label for="cordX" class="label-form">Ficha de tipo:</label>
                <div class="container ml-1">
                    <div class="row">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo" id="tipo1" value="vehiculo" checked onclick="showHide2()">
                            <label class="form-check-label" for="tipoR">
                                Vehiculo
                            </label>
                        </div>
                        <div class="form-check ml-5">
                            <input class="form-check-input" type="radio" name="tipo" id="tipo2" value="remision" onclick="showHide2()">
                            <label class="form-check-label" for="tipoV">
                                Remisión
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-lg-6" id="tipo_ficha_vehiculo_cambiar" style="display:none" >
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="cordX" class="label-form">Núm. de ficha de vehiculo:</label>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <input class="form-check-input" type="radio" name="ficha" id="ficha1" value="no" checked onclick="showHide()">
                                <label class="form-check-label" for="fichaNueva">
                                    Nueva
                                </label>
                            </div>
                            <div class="form-group col-lg-6">
                                <input class="form-check-input" type="radio" name="ficha" id="ficha2" value="si" onclick="showHide()">
                                <label class="form-check-label" for="fichaExistente">
                                    Existente
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-6" id="ficha" style="display:none">
                        <label for="cordX" class="label-form">Fichas:</label>
                        <select class="custom-select custom-select-sm" id="id_ficha" name="No_Ficha">
                        <?php foreach ($data['datos_prim']['ultimas_fichas'] as $item) : ?>
                            <option value="<?php echo strtoupper($item->NO_FICHA_V) ?>"><?php echo strtoupper($item->NO_FICHA_V) ?></option>
                        <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div><!--DIV DE tipo_ficha_vehiculo_cambiar-->
            <div class="form-group col-lg-6" id="tipo_ficha_remision" style="display:none">
                <label for="cordX" class="label-form">Número de ficha:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="ficha_Vehiculo" name="ficha_Vehiculo">
                <span class="span_error" id="ficha_Vehiculo_error"></span>
            </div>
            <div class="form-group col-lg-6" id="tipo_ficha_vehiculo" style="display:none">
                <label for="cordX" class="label-form">Número de ficha de vehiculo:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="ficha_Vehiculo_v" name="ficha_Vehiculo_v">
                <span class="span_error" id="ficha_Vehiculo_v_error"></span>
            </div> 
            <div class="form-group col-lg-12">
                <label for="cordX" class="label-form">Tipo de situación:</label>
                <select class="custom-select custom-select-sm" id="Tipo_SituacionE" name="Tipo_SituacionE">
                    <option value="RECUPERADO">RECUPERADO</option>
                    <option value="INVOLUCRADO">INVOLUCRADO</option>
                </select>
                <span class="span_error" id="Tipo_SituacionE_error"></span>
            </div>
            <?php
                if ($_SESSION['userdata']->Modo_Admin == 1) { ?>
                <div class="form-group col-lg-12 custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="cancelar_vehiculo" name="cancelar_vehiculo" value="inactivar">
                    <label class="custom-control-label" for="cancelar_vehiculo" style="font-size: 15px;">Vehiculo Inactivo</label>
                </div>
                <?php } 
                else{ ?>
                <div class="form-group col-lg-12 custom-control custom-checkbox custom-control-inline mi_hide">
                    <input type="checkbox" class="custom-control-input" id="cancelar_vehiculo" name="cancelar_vehiculo" value="inactivar">
                    <label class="custom-control-label" for="cancelar_vehiculo" style="font-size: 15px;">Vehiculo Inactivo</label>
                </div>
            <?php } ?>
            <div class="form-group col-lg-4">
                <label for="cordX" class="label-form">Fecha de recuperación:</label>
                <input type="date" class="form-control form-control-sm text-uppercase" id="fechar_VehiculoE" name="fechar_VehiculoE">
                <span class="span_error" id="fechar_VehiculoE_error"></span>
            </div>
            <div class="form-group col-lg-4">
                <label for="cordX" class="label-form">Colonia:</label>
                <input type="text" autocomplete="off" class="form-control form-control-sm text-uppercase" id="colonia_VehiculoE" name="colonia_VehiculoE">
                <span class="span_error" id="colonia_VehiculoE_error"></span>
            </div>
            <div class="form-group col-lg-4">
                <label for="cordX" class="label-form">Zona del evento:</label>
                <select class="custom-select custom-select-sm" id="zona_VehiculoE" name="zona_VehiculoE">
                    <?php foreach ($data['datos_prim']['zonas'] as $item) : ?>
                    <option value="<?php echo $item->Zona_Sector ?>"><?php echo $item->Zona_Sector ?></option>
                    <?php endforeach ?>
                </select>
                <span class="span_error" id="zona_VehiculoE_error"></span>
            </div>
            <div class="form-group col-lg-4">
                <label for="cordX" class="label-form">Primer respondiente:</label>
                <select class="custom-select custom-select-sm" id="primerm_VehiculoE" name="primerm_VehiculoE">
                    <option value="" selected disabled>Seleccione la adscripción a la que pertenece</option>
                    <?php foreach ($data['datos_prim']['grupos'] as $item) : ?>
                        <option value="<?php echo trim($item->Valor_Grupo) ?>"><?php echo trim($item->Valor_Grupo) ?></option>
                    <?php endforeach ?>
                </select>
                <span class="span_error" id="primerr_VehiculoE_error"></span>
            </div>
            <div class="form-group col-lg-4">
                <label for="cordX" class="label-form">Tipo de vehículo:</label>
                <select class="custom-select custom-select-sm" id="Tipo_VehiculoE" name="Tipo_VehiculoE">
                    <?php foreach ($data['datos_prim']['tipos_vehiculos'] as $item) : ?>
                    <option value="<?php echo $item->Tipo ?>"><?php echo $item->Tipo ?></option>
                    <?php endforeach ?>
                </select>
                <span class="span_error" id="Tipo_VehiculoE_error"></span>
            </div>
            <div class="form-group col-lg-4">
                <label for="cordX" class="label-form">Marca:</label>
                <input type="text" autocomplete="off" class="form-control form-control-sm text-uppercase" id="MarcaE" name="MarcaE">
                <span class="span_error" id="Marca_VehiculoE_error"></span>
            </div>
            <div class="form-group col-lg-4">
                <label for="cordX" class="label-form">Submarca:</label>
                <input type="text" autocomplete="off" class="form-control form-control-sm text-uppercase" id="SubmarcaE" name="SubmarcaE">
                <span class="span_error" id="Submarca_VehiculoE_error"></span>
            </div>
            <div class="form-group col-lg-4">
                <label for="cordX" class="label-form">Modelo:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="ModeloE" name="ModeloE">
            </div>
            <div class="form-group col-lg-4">
                <label for="cordX" class="label-form">Color:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="ColorE" name="ColorE">
                <span class="span_error" id="ColorE_error"></span>
            </div>
            <div class="form-group col-lg-4">
                <label for="cordX" class="label-form">CDI:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="CDI_VehiculoE" name="CDI_VehiculoE">
            </div>
            <div class="form-group col-lg-4">
                <label for="cordX" class="label-form">Número de remisión:</label>
                <input type="text" disabled class="form-control form-control-sm text-uppercase" id="remision_VehiculoE" name="remision_VehiculoE">
            </div> 
            <div class="form-group col-lg-4">
                <label for="cordX" class="label-form">Nombre del Ministerio Público:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="nombre_mpE" name="nombre_mpE">
            </div>
            <div class="form-group col-lg-4">
                <label for="cordX" class="label-form">Apellido paterno del Ministerio Público:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="apellidop_mpE" name="apellidop_mpE">
            </div>
            <div class="form-group col-lg-4">
                <label for="cordX" class="label-form">Apellido materno del Ministerio Público:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="apellidom_mpE" name="apellidom_mpE">
            </div>
            <div class="form-group col-lg-4">
                <label for="cordX" class="label-form">Fecha de puesta a disposición:</label>
                <input type="date" class="form-control form-control-sm text-uppercase" id="fechad_VehiculoE" name="fechad_VehiculoE">
            </div>
            <div class="form-group col-lg-12">
                <label for="OBJ_Observacion_Vehiculo" class="label-form">Observaciones del vehículo:</label>
                <textarea class="form-control text-uppercase text-uppercase" id="Observacion_VehiculoE" name="Observacion_VehiculoE" rows="6" maxlength="450"></textarea>
            </div>
            <div class="form-group col-lg-12">
                <h5 class="text-center mt-5">Placas del vehiculo</h5>
            </div>
            <div class="form-group col-lg-12">
                <div class="alert alert-warning" role="alert" id="alertEditPlacaE" style="display: none">
                    Está realizando edición a un elemento.
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label for="cordX" class="label-form">Tipo de placa:</label>
                <select class="custom-select custom-select-sm" id="tipo_placaE" name="tipo_placaE">
                    <?php foreach ($data['datos_prim']['categoria'] as $item) : ?>
                    <option value="<?php echo strtoupper($item->Categoria) ?>"><?php echo strtoupper($item->Categoria) ?></option>
                    <?php endforeach ?>
                </select>
                <div class="invalid-feedback" id="tipo_placaE-invalid">
                    El tipo de placa es requerida.
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label for="cordX" class="label-form">Placa del vehículo:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Placa_VehiculoE" name="Placa_VehiculoE">
                <div class="invalid-feedback" id="Placa_VehiculoE-invalid">
                    La placa es requerida.
                </div>
            </div>
            <div class="form-group col-lg-5">
                <label for="cordX" class="label-form">Procedencia de la placa:</label>
                <select class="custom-select custom-select-sm" id="procedencia_placaE" name="procedencia_placaE">
                    <?php foreach ($data['datos_prim']['estados'] as $item) : ?>
                    <option value="<?php echo strtoupper($item->Estado) ?>"><?php echo strtoupper($item->Estado) ?></option>
                    <?php endforeach ?>
                </select>
                <div class="invalid-feedback" id="procedencia_placaE-invalid">
                    La procedencia es requerida.
                </div>
            </div>
            <div class="form-group col-lg-1">
                <button type="button" class="btn btn-primary button-movil-plus" onclick="onFormPlacaSubmitE()">+</button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="placas_vehiculosE">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Tipo de placa</th>
                            <th scope="col">Placa</th>
                            <th scope="col">Procedencia</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="form-group col-lg-12">
                <div class="alert alert-warning" role="alert" id="alertEditNivE" style="display: none">
                    Está realizando edición a un elemento.
                </div>
            </div>
            <div class="form-group col-lg-12">
                <h5 class="text-center mt-5">Numero de serie del vehiculo</h5>
            </div>
            <div class="form-group col-lg-4">
                <label for="cordX" class="label-form">Tipo de NIV:</label>
                <select class="custom-select custom-select-sm" id="tipo_nivE" name="tipo_nivE">
                    <?php foreach ($data['datos_prim']['categoria'] as $item) : ?>
                    <option value="<?php echo strtoupper($item->Categoria) ?>"><?php echo strtoupper($item->Categoria) ?></option>
                    <?php endforeach ?>
                </select>
                <div class="invalid-feedback" id="tipo_nivE-invalid">
                    El tipo de niv es requerido.
                </div>
            </div>
            <div class="form-group col-lg-4">
                <label for="cordX" class="label-form">Núm. de serie:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="No_SerieE" name="No_SerieE">
                <div class="invalid-feedback" id="No_SerieE-invalid">
                    El numero de serie es requerido.
                </div>
            </div>
            <div class="form-group col-lg-1">
                <button type="button" class="btn btn-primary button-movil-plus" onclick="onFormNivSubmitE()">+</button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="niv_vehiculosE">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Tipo de NIV</th>
                            <th scope="col">No. Serie</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="form-group col-lg-12">
                <label for="OBJ_Observacion_Vehiculo" class="label-form">Narrativas del vehículo:</label>
                <textarea class="form-control text-uppercase text-uppercase" id="Narrativas_VehiculoE" name="Narrativas_VehiculoE" rows="10" maxlength="30000"></textarea>
            </div>

            <div class="form-group col-lg-12">
                <label  class="label-form">PDF  de puesta a disposición:</label>
                <div class="input-group col-sm-12 mt-4 mb-5">
                    <div class="custom-file">
                        <input type="file" name="fileVehiculos" onchange="uploadFileIPH(event)"class="bs-custom-file-input" id="fileVehiculos" accept=".pdf">
                        <label class="custom-file-label" for="fileVehiculos">Buscar archivo</label>
                    </div>
                </div>
                <div class="fileIPHResult col-md-12 d-flex justify-content-center" id="fileIPHResult"></div>
                <div class="form-group col-md-12" id="viewPDFIPH">
                </div>
            </div>
            <div class="form-group col-lg-10">
                <div class="col-12 my-4" id="msg_capturaFotos"></div>
                <div id="photos-content">
                    <div class="container mt-3">
                        <h5>Captura de fotos</h5>
                        <div class="row">
                            <div class="col-lg-6">
                                <div id="parte_frontal" class="dropzone d-flex justify-content-center">
                                </div>
                                <span id="message_parte_frontal" class="text-center"></span>
                                <input type="hidden" name="input_parte_frontal" id="input_parte_frontal" value="">
                                <div class="mt-2 d-flex justify-content-center">
                                    <button class="btn btn-primary" id="btn_parte_frontal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                            <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                                        </svg>
                                        Rotar
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div id="parte_posterior" class="dropzone d-flex justify-content-center">
                                </div>
                                <span id="message_parte_posterior" class="text-center"></span>
                                <input type="hidden" name="input_parte_posterior" id="input_parte_posterior" value="">
                                <div class="mt-2 d-flex justify-content-center">
                                    <button class="btn btn-primary" id="btn_parte_posterior">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                            <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                                        </svg>
                                        Rotar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-lg-6">
                                <div id="costado_conductor" class="dropzone d-flex justify-content-center">
                                </div>
                                <span id="message_costado_conductor" class="text-center"></span>
                                <input type="hidden" name="input_costado_conductor" id="input_costado_conductor" value="">
                                <div class="mt-2 d-flex justify-content-center">
                                    <button class="btn btn-primary" id="btn_costado_conductor">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                            <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                                        </svg>
                                        Rotar
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div id="costado_copiloto" class="dropzone d-flex justify-content-center">
                                </div>
                                <span id="message_costado_copiloto" class="text-center"></span>
                                <input type="hidden" name="input_costado_copiloto" id="input_costado_copiloto" value="">
                                <div class="mt-2 d-flex justify-content-center">
                                    <button class="btn btn-primary" id="btn_costado_copiloto">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                            <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                                        </svg>
                                        Rotar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div><!--DIV DE container mt-3--> 
                </div><!--DIV DE photos-content--> 
            </div> 
            <div class="form-group col-lg-10">
                <button type="button" class="btn btn-primary button-movil-plus mb-4" id="btn_vehiculos_editar">Guardar</button>
            </div>
        </div><!--DIV DE Form_vehiculoE-->  
    </form>
</div>
