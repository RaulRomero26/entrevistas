<div class="container">
    <form id="data_objRecuperados" onsubmit="event.preventDefault();">
        <div class="row mt-5">
            <div class="col-12 my-4" id="msg_objRecuperados"></div>
            <?php
            $no_remision    = (isset($_GET['no_remision'])) ? $_GET['no_remision'] : '0';
            $no_ficha       = (isset($_GET['no_ficha'])) ? $_GET['no_ficha'] : '0';
            ?>


            <input type="hidden" name="no_remision_peticionario" id="no_remision_objetosRecuperados" value=<?= $no_remision ?>>
            <input type="hidden" name="no_ficha_peticionario" id="no_ficha_objetosRecuperados" value=<?= $no_ficha ?>>

            <span class="span_rem">Núm. Remisión/Oficio: </span>
            <?php if (isset($_GET['no_remision'])) { ?>
                <span class="span_rem_ans ml-2"><?= $_GET['no_remision'] ?></span>
            <?php } ?>

            <span class="span_rem ml-5">Núm. Ficha: </span>
            <?php if (isset($_GET['no_remision'])) { ?>
                <span class="span_rem_ans ml-2"><?= $_GET['no_ficha'] ?></span>
            <?php } ?>
            <!--
            <span class="span_rem ml-5">Vehiculos: </span>
            <?php if (isset($_GET['no_remision'])) { ?>
                <span class="span_rem_ans ml-2"><?= print_r($data) ?></span>
            <?php } ?>
        -->
        </div>
        <div class="mt-5">
            <p class="form_title">Objetos asegurados: </p>
            <h5 class="text-center mt-5">Armas aseguradas</h5>
            <div class="alert alert-warning" role="alert" id="alertEditArma">
                Está realizando edición a un elemento.
            </div>
            <span class="span_error" id="inputsArmas_error"></span>
            <div class="form-row mt-3">
                <div class="form-group col-lg-4">
                    <label for="tipoArma" class="label-form">Tipo:</label>
                    <select class="custom-select custom-select-sm" id="tipoArma">
                        <option value="" selected disabled>SELECCIONE UN TIPO DE ARMA</option>
                        <?php foreach ($data['objRecuperados']['armas'] as $item) : ?>
                            <option value="<?php echo $item->Tipo_Arma ?>"><?php echo $item->Tipo_Arma ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback" id="tipoArma-invalid">
                        El tipo es requerido.
                    </div>
                </div>
                <div class="form-group col-lg-2">
                    <label for="cantidadArmas" class="label-form">Cantidad:</label>
                    <input type="number" min="1" class="form-control form-control-sm" id="cantidadArmas">
                    <div class="invalid-feedback" id="cantidadArmas-invalid">
                        La cantidad es requerida.
                    </div>
                </div>
                <div class="form-group col-lg-5">
                    <label for="descripcionArmas" class="label-form">Descripción:</label>
                    <textarea  class="form-control form-control-sm text-uppercase" id="descripcionArmas" rows="2" maxlength="5000"></textarea>
                    <div class="invalid-feedback" id="descripcionArmas-invalid">
                        La descripción es requerida.
                    </div>
                </div>
                <div class="col-lg-1 d-flex align-items-center">
                    <button type="button" class="btn btn-primary button-movil-plus" onclick="onFormArmaSubmit()">+</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="armasRecuperadas">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Tipo</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Descripción</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <h5 class="text-center mt-5">Drogas aseguradas</h5>
            <div class="alert alert-warning" role="alert" id="alertEditDroga">
                Está realizando edición a un elemento.
            </div>
            <span class="span_error" id="inputsDrogas_error"></span>
            <div class="form-row mt-3">
                <div class="form-group col-lg-3">
                    <label for="tipoDroga" class="label-form">Tipo:</label>
                    <select class="custom-select custom-select-sm" id="tipoDroga">
                        <option value="" selected disabled>SELECCIONE EL TIPO DE DROGA</option>
                        <?php foreach ($data['objRecuperados']['adicciones'] as $item) : ?>
                            <option value="<?php echo $item->Nombre_Adiccion ?>"><?php echo $item->Nombre_Adiccion ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback" id="tipoDroga-invalid">
                        El tipo es requerido.
                    </div>
                </div>
                <div class="form-group col-lg-1">
                    <label for="cantidadDroga" class="label-form">Cantidad:</label>
                    <input type="number" min="1" class="form-control form-control-sm" id="cantidadDroga">
                    <div class="invalid-feedback" id="cantidadDroga-invalid">
                        La cantidad es requerida.
                    </div>
                </div>
                <div class="form-group col-lg-3">
                    <label for="unidadDroga" class="label-form">Unidad:</label>
                    <select class="custom-select custom-select-sm" id="unidadDroga">
                        <option value="" selected disabled>SELECCIONE LA UNIDAD</option>
                        <?php foreach ($data['objRecuperados']['unidades'] as $item) : ?>
                            <option value="<?php echo $item->Tipo_Medida ?>"><?php echo $item->Tipo_Medida ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback" id="unidadDroga-invalid">
                        La unidad es requerida.
                    </div>
                </div>
                <div class="form-group col-lg-4">
                    <label for="descripcionDroga" class="label-form">Descripción:</label>
                    <textarea  class="form-control form-control-sm text-uppercase" id="descripcionDroga" rows="2" maxlength="6000"></textarea>
                    <div class="invalid-feedback" id="descripcionDroga-invalid">
                        La descripción es requerida.
                    </div>
                </div>
                <div class="col-lg-1 d-flex align-items-center">
                    <button type="button" class="btn btn-primary button-movil-plus" onclick="onFormDrogaSubmit()">+</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="drogasAseguradas">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Tipo</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Unidad</th>
                            <th scope="col">Descripción</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <h5 class="text-center mt-5">Objetos asegurados</h5>
            <div class="alert alert-warning" role="alert" id="alertEditObjeto">
                Está realizando edición a un elemento.
            </div>
            <span class="span_error" id="inputsObjetos_error"></span>
            <div class="form-row mt-3">
                <div class="form-group col-lg-11">
                    <label for="descripcionOtros" class="label-form">Descripción:</label>
                    <textarea  class="form-control form-control-sm text-uppercase" id="descripcionOtros" rows="2" maxlength="6000"></textarea>
                    <div class="invalid-feedback" id="descripcionOtros-invalid">
                        La descripción es requerida.
                    </div>
                </div>
                <div class="col-lg-1 d-flex align-items-center">
                    <button type="button" class="btn btn-primary button-movil-plus" onclick="onFormOtroSubmit()">+</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="objetosAsegurados">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Descripción</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- aqui agregare mi elemento de vehiculos -->
            <h5 class="text-center mt-5">Vehiculos asegurados</h5>
            <div class="alert alert-warning" role="alert" id="alertEditVehiculo" style="display: none">
                Está realizando edición a un elemento.
            </div>
            <span class="span_error" id="inputsVehiculos_error"></span>
            <div class="row d-flex align-items-center justify-content-center" id="Form_vehiculo" >
                    <label for="cordX" class="label-form">Tipo de situación:</label>
                    <div class="form-group col-lg-12 d-flex align-items-center justify-content-center text-center">
                        <div class="form-check form-check-inline d-flex align-items-center justify-content-center">
                            <input class="form-check-input" type="radio" name="Tipo_Situacion" id="Tipo_Situacion_0" value="Asegurado">
                            <label class="form-check-label " for="exampleRadios1">Recuperado</label>
                        </div>

                        <div class="form-check form-check-inline d-flex align-items-center justify-content-center">
                            <input class="form-check-input" type="radio" name="Tipo_Situacion" id="Tipo_Situacion_1" value="Involucrado">
                            <label class="form-check-label" for="exampleRadios2">Involucrado</label>
                        </div>
                        <div class="invalid-feedback align-items-center justify-content-center" id="Tipo_Situacion-invalid">
                            El tipo de situación es requerida.
                        </div>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordX" class="label-form">Tipo de vehículo:</label>
                      <!--  <input type="text" class="form-control form-control-sm text-uppercase" id="Tipo_Vehiculo" name="Tipo_Vehiculo">-->
                        <select class="custom-select custom-select-sm" id="Tipo_Vehiculo" name="Tipo_Vehiculo">
                        </select>
                        <div class="invalid-feedback" id="Tipo_Vehiculo-invalid">
                            El tipo de vehiculo es requerido.
                        </div>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordX" class="label-form">Placa del vehículo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Placa_Vehiculo" name="Placa_Vehiculo">
                        <div class="invalid-feedback" id="Placa_Vehiculo-invalid">
                            La placa es requerida.
                        </div>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordX" class="label-form">Marca:</label>
                      <!--  <input type="text" class="form-control form-control-sm text-uppercase" id="Marca" name="Marca"> -->
                        <select class="custom-select custom-select-sm" id="Marca" name="Marca">
                        <!--    <option value="Asia Motors">Asia Motors</option>
                            <option value="CHEVROLET">Chevrolet</option>
                            <option value="Citroen">Citroen</option>-->
                        </select>
                        <div class="invalid-feedback" id="Marca-invalid">
                            La marca es requerida.
                        </div>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordX" class="label-form">Submarca:</label>
                      <!--  <input type="text" class="form-control form-control-sm text-uppercase" id="Marca" name="Marca"> -->
                        <select class="custom-select custom-select-sm" id="Submarca" name="Submarca">
                        <!--    <option value="Asia Motors">Asia Motors</option>
                            <option value="CHEVROLET">Chevrolet</option>
                            <option value="Citroen">Citroen</option>-->
                        </select>
                        <div class="invalid-feedback" id="Submarca-invalid">
                            La Submarca es requerida.
                        </div>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordX" class="label-form">Modelo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Modelo" name="Modelo">
                        <div class="invalid-feedback" id="Modelo-invalid">
                            El modelo es requerido.
                        </div>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordX" class="label-form">Color:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Color" name="Color">
                        <div class="invalid-feedback" id="Color-invalid">
                            El color es requerido.
                        </div>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordX" class="label-form">Seña particular:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Senia_Particular" name="Senia_Particular">
                        <div class="invalid-feedback" id="Senia_Particular-invalid">
                            La seña particular es requerida.
                        </div>
                    </div>
                    

                    <div class="form-group col-lg-3">
                        <label for="cordX" class="label-form">Núm. de serie:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="No_Serie" name="No_Serie">
                        <div class="invalid-feedback" id="No_Serie-invalid">
                            El número de serie es requerido.
                        </div>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordX" class="label-form">Procedencia del vehículo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Procedencia_Vehiculo" name="Procedencia_Vehiculo">
                        <div class="invalid-feedback" id="Procedencia_Vehiculo-invalid">
                            La procedencia del vehiculo es requerida.
                        </div>
                    </div>

                    <div class="form-group col-lg-12">
                        <label for="OBJ_Observacion_Vehiculo" class="label-form">Observaciones del vehículo:</label>
                        <textarea class="form-control text-uppercase text-uppercase" id="Observacion_Vehiculo" name="Observacion_Vehiculo" rows="6" maxlength="450"></textarea>
                        <div class="invalid-feedback" id="Observacion_Vehiculo-invalid">
                            La observacion del vehiculo es requerida.
                        </div>
                        <button type="button" class="btn btn-primary button-movil-plus" onclick="onFormVehiculoSubmit()">+</button>
                    </div>
                    
                </div>
            <!-- se añade la tabla para vehiculos recuperados, se sigue el mismo procedimiento que ya se utilizo para armas, objetos y drogas, 
            asi de igual manera la tabla siempre estara visible aunque no tenga elementos-->
            <div class="table-responsive">
                <table class="table table-bordered" id="vehiculosRecuperados">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Situación</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Placa</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Submarca</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Color</th>
                            <th scope="col">Seña</th>
                            <th scope="col">Num.Serie</th>
                            <th scope="col">Procedencia</th>
                            <th scope="col">Observaciones</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- Se comenta toda esta seccion debido a que se añaden mas de un vehiculo
            como esta pregunta controlaba la visualizacion de los campos, deben de quitarse para que siempre esten visibles.
            los demas campos se mantienen solo modificando los campos span, ya que debido a las validaciones, se necesitan 
            los mensajes de errror con el mismo nombre mas -invalid, ademas de ser un div de la clase invalid-feedback,

            <div class="mt-5">
                <p class="form_title ml-3">Vehículo: </p>

                <div class="row">
                    <div class="col-12 mt-4">
                        <span>¿Existen un vehículo recuperado / involucrado?</span>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="vehiculos" id="Vehiculo_No" value="No" checked>
                            <label class="form-check-label" for="exampleRadios1">
                                No
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="vehiculos" id="Vehiculo_Si" value="Si">
                            <label class="form-check-label" for="exampleRadios2">
                                Si
                            </label>
                        </div>
                    </div>
                </div>

                
                <div class="row d-flex align-items-center justify-content-center" id="Form_vehiculo" style="display: none !important">

                    <label for="cordX" class="label-form">Tipo de situación:</label>
                    <div class="form-group col-lg-12 d-flex align-items-center justify-content-center text-center">
                        <div class="form-check form-check-inline d-flex align-items-center justify-content-center">
                            <input class="form-check-input" type="radio" name="Tipo_Situacion" id="Tipo_Situacion_0" value="Asegurado" checked>
                            <label class="form-check-label " for="exampleRadios1">Recuperado</label>
                        </div>

                        <div class="form-check form-check-inline d-flex align-items-center justify-content-center">
                            <input class="form-check-input" type="radio" name="Tipo_Situacion" id="Tipo_Situacion_1" value="Involucrado">
                            <label class="form-check-label" for="exampleRadios2">Involucrado</label>
                        </div>
                        <span class="span_error" id="Tipo_Situacion-invalid"></span>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordX" class="label-form">Tipo de vehículo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Tipo_Vehiculo" name="Tipo_Vehiculo">
                        <span class="span_error" id="Tipo_Vehiculo-invalid"></span>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordX" class="label-form">Placa del vehículo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Placa_Vehiculo" name="Placa_Vehiculo">
                        <span class="span_error" id="Placa_Vehiculo-invalid"></span>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordX" class="label-form">Marca:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Marca" name="Marca">
                        <span class="span_error" id="Marca-invalid"></span>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordX" class="label-form">Modelo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Modelo" name="Modelo">
                        <span class="span_error" id="Modelo-invalid"></span>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordX" class="label-form">Color:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Color" name="Color">
                        <span class="span_error" id="Color-invalid"></span>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordX" class="label-form">Seña particular:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Senia_Particular" name="Senia_Particular">
                        <span class="span_error" id="Senia_Particular-invalid"></span>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordX" class="label-form">Núm. de serie:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="No_Serie" name="No_Serie">
                        <span class="span_error" id="No_Serie-invalid"></span>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="cordX" class="label-form">Procedencia del vehículo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Procedencia_Vehiculo" name="Procedencia_Vehiculo">
                        <span class="span_error" id="Procedencia_Vehiculo-invalid"></span>
                    </div>

                    <div class="form-group col-lg-12">
                        <label for="OBJ_Observacion_Vehiculo" class="label-form">Observaciones del vehículo:</label>
                        <textarea class="form-control text-uppercase text-uppercase" id="Observacion_Vehiculo" name="Observacion_Vehiculo" rows="6" maxlength="450"></textarea>
                        <span class="span_error" id="Observacion_Vehiculo-invalid"></span>
                    </div>
                </div>
                
            </div>
             ---------------------------------------------------------- -->

        </div>

        <div class="row mt-5">
            <div class="form-group col-lg-4">
                <label class="label-form center-text">Imagen general de todos los indicios:</label>
                <div id="dropzone_obj_recuperados" class="dropzone d-flex justify-content-center">
                </div>
                <span id="message_obj_recuperados" class="text-center"></span>
                <input type="hidden" name="input_obj_recuperados" id="input_obj_recuperados" value="">
                <div class="mt-2 d-flex justify-content-center">
                    <button class="btn btn-primary" id="btn_obj_recuperados">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                            <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                        </svg>
                        Rotar
                    </button>
                </div>
            </div>
        </div>



        <div class="row mt-5 mb-5">
            <div class="col-12 d-flex justify-content-between col-sm-12">
                <a class="btn btn-sm btn-ssc btn-tab-getIndex" data-id="4" id="btn-tab-getIndex-4" message="msg_objRecuperados">Validar</a>
                <div>
                    <a class="btn btn-sm btn-ssc" id="btn_objRecuperados">Guardar</a>
                    <span class="advise-span text-center ml-2 mt-2 span-message" id="span-message-4">* Lo sentimos, el tab ha sido validado. Su usuario no tiene los permisos necesarios para editar</span>
                </div>
            </div>
        </div>
    </form>
</div>