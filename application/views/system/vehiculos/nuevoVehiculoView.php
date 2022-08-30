<div class="container">

    <form id='datos_nuevovehiculo' onsubmit="event.preventDefault()">
        <!-- aqui agregare mi elemento de vehiculos -->
        <h5 class="text-center mt-5">Vehiculos Asegurados/Involucrados</h5>
            <span class="span_error" id="inputsVehiculos_error"></span>
            <div class="row d-flex align-items-center justify-content-center" id="Form_vehiculo" >
                    <div class="form-group col-lg-6">
                            <label for="cordX" class="label-form">Núm. de ficha de tipo:</label>
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
                    <div class="form-group col-lg-6" id="tipo_ficha_remision" style="display:none">
                        <label for="cordX" class="label-form">Número de ficha:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="ficha_Vehiculo" name="ficha_Vehiculo">
                        <span class="span_error" id="ficha_Vehiculo_error"></span>
                    </div> 

                    <div class="form-group col-lg-6" id="tipo_ficha_vehiculo" >
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
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="cordX" class="label-form">Tipo de situación:</label>
                        <select class="custom-select custom-select-sm" id="Tipo_Situacion" name="Tipo_Situacion">
                            <option value="RECUPERADO">RECUPERADO</option>
                            <option value="INVOLUCRADO">INVOLUCRADO</option>
                        </select>
                    </div> 
                    <span class="span_error" id="Tipo_Situacion_error"></span>

                    <div class="form-group col-lg-4">
                        <label for="cordX" class="label-form">Fecha de recuperación:</label>
                        <input type="date" class="form-control form-control-sm text-uppercase" id="fechar_Vehiculo" data-date="" data-date-format="DD MM YYYY" name="fechar_Vehiculo">
                        <span class="span_error" id="fechar_Vehiculo_error"></span>
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="cordX" class="label-form">Colonia:</label>
                        <input type="text" autocomplete="off" class="form-control form-control-sm text-uppercase" id="colonia_Vehiculo" name="colonia_Vehiculo">
                        <span class="span_error" id="colonia_Vehiculo_error"></span>
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="cordX" class="label-form">Zona del evento:</label>
                        <select class="custom-select custom-select-sm" id="zona_Vehiculo" name="zona_Vehiculo">
                            <?php foreach ($data['datos_prim']['zonas'] as $item) : ?>
                            <option value="<?php echo trim($item->Zona_Sector) ?>"><?php echo trim($item->Zona_Sector) ?></option>
                            <?php endforeach ?>
                        </select>
                        <span class="span_error" id="zona_Vehiculo_error"></span>
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="cordX" class="label-form">Primer respondiente:</label>
                        <select class="custom-select custom-select-sm" id="primerm_Vehiculo" name="primerm_Vehiculo">
                            <option value="" selected disabled>Seleccione la adscripción a la que pertenece</option>
                            <?php foreach ($data['datos_prim']['grupos'] as $item) : ?>
                                <option value="<?php echo trim($item->Valor_Grupo) ?>"><?php echo trim($item->Valor_Grupo) ?></option>
                            <?php endforeach ?>
                        </select>
                        <span class="span_error" id="primerr_Vehiculo_error"></span>
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="cordX" class="label-form">Tipo de vehículo:</label>
                        <select class="custom-select custom-select-sm" id="Tipo_Vehiculo" name="Tipo_Vehiculo">
                            <?php foreach ($data['datos_prim']['tipos_vehiculos'] as $item) : ?>
                            <option value="<?php echo strtoupper($item->Tipo) ?>"><?php echo strtoupper($item->Tipo) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>


                    <div class="form-group col-lg-4">
                        <label for="cordX" class="label-form">Marca:</label>
                        <input type="text" autocomplete="off" class="form-control form-control-sm text-uppercase" id="Marca" name="Marca">
                        <span class="span_error" id="marca_Vehiculo_error"></span>
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="Submarca" class="label-form">Submarca:</label>
                        <input type="text" autocomplete="off" class="form-control form-control-sm text-uppercase" id="Submarca" name="Submarca">
                        <span class="span_error" id="submarca_Vehiculo_error"></span>
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="cordX" class="label-form">Modelo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Modelo" name="Modelo">
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="cordX" class="label-form">Color:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Color" name="Color">
                        <span class="span_error" id="Color_error"></span>
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="cordX" class="label-form">CDI:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="CDI_Vehiculo" name="CDI_Vehiculo">
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="cordX" class="label-form">Nombre del Ministerio Público:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="nombre_mp" name="nombre_mp">
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="cordX" class="label-form">Apellido paterno del Ministerio Público:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="apellidop_mp" name="apellidop_mp">
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="cordX" class="label-form">Apellido materno del Ministerio Público:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="apellidom_mp" name="apellidom_mp">
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="cordX" class="label-form">Fecha de puesta a disposición:</label>
                        <input type="date" class="form-control form-control-sm text-uppercase" id="fechad_Vehiculo" name="fechad_Vehiculo">
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="OBJ_Observacion_Vehiculo" class="label-form">Observaciones del vehículo:</label>
                        <textarea class="form-control text-uppercase text-uppercase" id="Observacion_Vehiculo" name="Observacion_Vehiculo" rows="6" maxlength="450"></textarea>   
                    </div>
                    <div class="form-group col-lg-12">
                        <h5 class="text-center mt-5">Placas del vehiculo</h5>
                    </div>
                    <div class="form-group col-lg-12">
                        <div class="alert alert-warning" role="alert" id="alertEditPlaca" style="display: none">
                            Está realizando edición a un elemento.
                        </div>
                    </div>
                    <div class="form-group col-lg-2">
                        <label for="cordX" class="label-form">Tipo de placa:</label>
                        <select class="custom-select custom-select-sm" id="tipo_placa" name="tipo_placa">
                            <?php foreach ($data['datos_prim']['categoria'] as $item) : ?>
                            <option value="<?php echo strtoupper($item->Categoria) ?>"><?php echo strtoupper($item->Categoria) ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback" id="tipo_placa-invalid">
                            El tipo de placa es requerida.
                        </div>
                    </div>
                    <div class="form-group col-lg-2">
                        <label for="cordX" class="label-form">Placa del vehículo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Placa_Vehiculo" name="Placa_Vehiculo">
                        <div class="invalid-feedback" id="Placa_Vehiculo-invalid">
                            La placa es requerida.
                        </div>
                    </div>
                    <div class="form-group col-lg-5">
                        <label for="cordX" class="label-form">Procedencia de la placa:</label>
                        <select class="custom-select custom-select-sm" id="procedencia_placa" name="procedencia_placa">
                            <?php foreach ($data['datos_prim']['estados'] as $item) : ?>
                            <option value="<?php echo strtoupper($item->Estado) ?>"><?php echo strtoupper($item->Estado) ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback" id="procedencia_placa-invalid">
                            La procedencia es requerida.
                        </div>
                    </div>
                    <div class="form-group col-lg-1">
                        <button type="button" class="btn btn-primary button-movil-plus" onclick="onFormPlacaSubmit()">+</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="placas_vehiculos">
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
                        <div class="alert alert-warning" role="alert" id="alertEditNiv" style="display: none">
                            Está realizando edición a un elemento.
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <h5 class="text-center mt-5">Numero de serie del vehiculo</h5>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="cordX" class="label-form">Tipo de NIV:</label>
                        <select class="custom-select custom-select-sm" id="tipo_niv" name="tipo_niv">
                            <?php foreach ($data['datos_prim']['categoria'] as $item) : ?>
                            <option value="<?php echo strtoupper($item->Categoria) ?>"><?php echo strtoupper($item->Categoria) ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback" id="tipo_niv-invalid">
                            El tipo de niv es requerido.
                        </div>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="cordX" class="label-form">Núm. de serie:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="No_Serie" name="No_Serie">
                        <div class="invalid-feedback" id="No_Serie-invalid">
                            El numero de serie es requerido.
                        </div>
                    </div>
                    <div class="form-group col-lg-1">
                        <button type="button" class="btn btn-primary button-movil-plus" onclick="onFormNivSubmit()">+</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="niv_vehiculos">
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
                        <textarea class="form-control text-uppercase text-uppercase" id="Narrativas_Vehiculo" name="Narrativas_Vehiculo" rows="10" maxlength="30000"></textarea>
                        <button type="button" class="btn btn-primary button-movil-plus mb-4" id="btn_vehiculos_guardar">Guardar</button>   
                    </div>
        </div>
    </form>

</div>