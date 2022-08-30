<div class="container">
    <form id="data_elementos" onsubmit="event.preventDefault();">
        <div class="row mt-5">
            <div class="col-12 my-4" id="msg_elementosParticipantes"></div>
            <?php
                $no_remision    = (isset($_GET['no_remision']))?$_GET['no_remision']:'0';
                $no_ficha       = (isset($_GET['no_ficha']))?$_GET['no_ficha']:'0';      
            ?>

            
            <input type="hidden" name="no_remision_peticionario" id="no_remision_elementosParticipantes" value=<?=$no_remision?>>
            <input type="hidden" name="no_ficha_peticionario" id="no_ficha_elementosParticipantes" value=<?=$no_ficha?>>

            <span class="span_rem">Núm. Remisión/Oficio: </span>
            <?php if(isset($_GET['no_remision'])){?>
                <span class="span_rem_ans ml-2"><?= $_GET['no_remision'] ?></span>
            <?php } ?>

            <span class="span_rem ml-5">Núm. Ficha: </span>
            <?php if(isset($_GET['no_remision'])){?>
                <span class="span_rem_ans ml-2"><?= $_GET['no_ficha'] ?></span>
            <?php } ?>
        </div>

        <div class="form-row mt-5">
            <div class="input-group col-lg-6 offset-lg-3 my-2">
                <input type="text" class="form-control text-uppercase" placeholder="Ingrese el número de control, placa ó apellidos del elemento" id="element_search">
                <div class="input-group-append">
                    <button class="btn btn-ssc" type="button" id="button_search">Buscar</button>
                </div>
            </div>
            <div class="col-lg-6 offset-lg-3 mb-3" id="list_elements_search">
            </div>
        </div>
        
        <div class="form-row mt-5">
            <div class="alert alert-warning col-lg-12" role="alert" id="alertEditElemento">
                Está realizando edición a un elemento.
            </div>
            <span class="span_error" id="inputsElementos_error"></span>
            <div class="form-row">
                <div class="form-group col-lg-2">
                    <label for="nombreElemento" class="label-form">Nombre:</label>
                    <input type="hidden" id="nombreElementoAux">
                    <input type="hidden" id="apellidoPElementoAux">
                    <input type="hidden" id="apellidoMElementoAux">
                    <input type="text" class="form-control form-control-sm text-uppercase" id="nombreElemento">
                    <div class="invalid-feedback" id="nombreElemento-invalid">
                        El nombre es requerido.
                    </div>
                </div>
                <div class="form-group col-lg-2">
                    <label for="noControlElemento" class="label-form">Núm. Control:</label>
                    <input type="text" class="form-control form-control-sm" id="noControlElemento">
                    <div class="invalid-feedback" id="noControlElemento-invalid">
                        El número de control es requerido.
                    </div>
                </div>
                <div class="form-group col-lg-2">
                    <label for="placaElemento" class="label-form">Placa:</label>
                    <input type="text" class="form-control form-control-sm" id="placaElemento">
                    <div class="invalid-feedback" id="placaElemento-invalid">
                        La placa es requerida.
                    </div>
                </div>
                <div class="form-group col-lg-1">
                    <label for="unidadElemento" class="label-form">Unidad:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="unidadElemento">
                    <div class="invalid-feedback" id="unidadElemento-invalid">
                        La unidad es requerida.
                    </div>
                </div>
                <div class="form-group col-lg-2">
                    <label for="cargoElemento" class="label-form">Cargo:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="cargoElemento">
                    <div class="invalid-feedback" id="cargoElemento-invalid">
                        El cargo es requerido.
                    </div>
                </div>
                <div class="form-group col-lg-2">
                    <label for="grupoElemento" class="label-form">Adscripción:</label>
                    <select class="custom-select custom-select-sm" id="grupoElemento">
                        <option value="" selected disabled>Seleccione la adscripción a la que pertenece</option>
                        <?php foreach ($data['elementos']['grupos'] as $item) : ?>
                            <option value="<?php echo $item->Valor_Grupo ?>"><?php echo $item->Valor_Grupo ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback" id="grupoElemento-invalid">
                        El grupo es requerido.
                    </div>
                </div>
                <div class="col-lg-1 d-flex align-items-center">
                    <button type="button" onclick="onFormElementosSubmit()" class="btn btn-primary button-movil-plus">+</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="elementosParticipantes">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Núm. Control</th>
                            <th scope="col">Encargado de puesta</th>
                            <th scope="col">Placa</th>
                            <th scope="col">Unidad</th>
                            <th scope="col">Cargo</th>
                            <th scope="col">Adscripción</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                        <tbody>
                        </tbody>
                    </thead>
                </table>
            </div>
            <span class="span_error" id="primerElementos_error"></span>
            <!-- <p>¿Seguimiento por GPS?</p>
            <div class="container d-flex">
                <div class="form-check mr-3">
                    <input class="form-check-input" type="radio" name="seguimientoGPS" id="flexRadioDefault1" checked>
                    <label class="form-check-label" for="flexRadioDefault1">
                        No
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="seguimientoGPS" id="seguimientoGPS">
                    <label class="form-check-label" for="seguimientoGPS">
                        Si
                    </label>
                </div>
            </div> -->
        </div>

        <div class="form-row mt-5">
            <div class="input-group col-lg-6 offset-lg-3 my-2">
                <input type="text" class="form-control text-uppercase" placeholder="Ingrese el número de control, placa ó apellidos del elemento" id="element_search_2">
                <div class="input-group-append">
                    <button class="btn btn-ssc" type="button" id="button_search_2">Buscar</button>
                </div>
            </div>
            <div class="col-lg-6 offset-lg-3 mb-3" id="list_elements_search_2">
            </div>
        </div>

        <div class="form-row mt-5">
            <label for="policiaDeGuardia" class="label-form">Policía de guardia:</label>
            <input type="text" class="form-control form-control-sm text-uppercase" id="policiaDeGuardia" name="policiaDeGuardia">
            <span class="span_error" id="policiaDeGuardia_error"></span>
        </div>

        <div class="form-row mt-5">
            <div class="form-group col-lg-12">
                <label for="observacionesElementos" class="label-form">Observaciones:</label>
                <textarea class="form-control text-uppercase" id="observacionesElementos" name="observacionesElementos" rows="6"></textarea>
                <span class="span_error" id="observacionesElementos_error"></span>
            </div>
        </div>

        <div class="row mt-5 mb-5">
            <div class="col-12 d-flex justify-content-between col-sm-12">
                <a class="btn btn-sm btn-ssc btn-tab-getIndex" id="btn-tab-getIndex-3" data-id="3" message="msg_elementosParticipantes">Validar</a>
                <div>
                    <a class="btn btn-sm btn-ssc" id="btn_elementos">Guardar</a>
                    <span class="advise-span text-center ml-2 mt-2 span-message" id="span-message-3">* Lo sentimos, el tab ha sido validado. Su usuario no tiene los permisos necesarios para editar</span>
                </div>
            </div>
        </div>
    </form>

</div>