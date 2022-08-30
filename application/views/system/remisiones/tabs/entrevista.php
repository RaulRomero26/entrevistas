<div class="container">
    <form id="data_entrevista" onsubmit="event.preventDefault()">
        <div class="row mt-5">
            <div class="col-12 my-4" id="msg_entrevista"></div>
            <?php
                $no_remision    = (isset($_GET['no_remision']))?$_GET['no_remision']:'0';
                $no_ficha       = (isset($_GET['no_ficha']))?$_GET['no_ficha']:'0';      
            ?>

            
            <input type="hidden" name="no_remision_peticionario" id="no_remision_entrevistaDetenido" value=<?=$no_remision?>>
            <input type="hidden" name="no_ficha_peticionario" id="no_ficha_entrevistaDetenido" value=<?=$no_ficha?>>

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
            <div class="form-group col-sm-12">
                <label for="probableVinculacion" class="label-form">Probable vinculación con banda o grupo delictivo:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" name="probableVinculacion" id="probableVinculacion">
                <span class="span_error" id="probableVinculacion_error"></span>
            </div>

            <fieldset class="form-group col-sm-12">
                <legend class="col-form-label pl-1">¿Ha pertenecido o pertenece a instituciones de seguridad?</legend>
                <div class="container ml-1">
                    <div class="row">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="institucion" id="institucion1" value="No" checked onclick="showHide('institucion')">
                            <label class="form-check-label" for="institucion1">
                                No
                            </label>
                        </div>
                        <div class="form-check ml-5">
                            <input class="form-check-input" type="radio" name="institucion" id="institucion2" value="Si" onclick="showHide('institucion')">
                            <label class="form-check-label" for="institucion2">
                                Si
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset>

            <div id="institucion" class="col-sm-12">
                <div class="alert alert-warning" role="alert" id="alertEditInstitucion">
                    Está realizando edición a un elemento.
                </div>
                <span class="span_error" id="inputsInstitucion_error"></span>
                <div class="form-row mt-3">
                    <div class="form-group col-lg-3">
                        <label for="tipoInstitucion" class="label-form">Tipo de institución:</label>
                        <select class="custom-select custom-select-sm" id="tipoInstitucion">
                            <option value="" selected disabled>SELECCIONE UN TIPO DE INSTITUCIÓN</option>
                            <?php foreach ($data['entrevistaDetenido']['instituciones'] as $item) : ?>
                                <option value="<?php echo $item->Tipo_Institucion ?>"><?php echo $item->Tipo_Institucion ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback" id="tipoInstitucion-invalid">
                            El tipo es requerido.
                        </div>
                    </div>
                    <div class="form-group col-sm-8">
                        <label for="corporacionInstitucion" class="label-form">Corporación:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="corporacionInstitucion">
                        <div class="invalid-feedback" id="corporacionInstitucion-invalid">
                            La corporación es requerida.
                        </div>
                    </div>
                    <div class="col-lg-1 d-flex align-items-center">
                        <button type="button" class="btn btn-primary button-movil-plus" onclick="onFormInstitucionSubmit()">+</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="institucionesSeguridad">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Tipo</th>
                                <th scope="col">Corporación</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <fieldset class="form-group col-sm-12">
                <legend class="col-form-label pl-1">Adicciones</legend>
                <div class="container ml-1">
                    <div class="row">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="adicciones" id="adicciones1" value="No" checked onclick="showHide('adicciones')">
                            <label class="form-check-label" for="adicciones1">
                                No
                            </label>
                        </div>
                        <div class="form-check ml-5">
                            <input class="form-check-input" type="radio" name="adicciones" id="adicciones2" value="Si" onclick="showHide('adicciones')">
                            <label class="form-check-label" for="adicciones2">
                                Si
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset>

            <div id="adicciones" class="col-sm-12">
                <div class="alert alert-warning" role="alert" id="alertEditAdiccion">
                    Está realizando edición a un elemento.
                </div>
                <span class="span_error" id="inputsAdiccion_error"></span>
                <div class="form-row mt-3">
                    <div class="form-group col-lg-3">
                        <label for="tipoAdiccion" class="label-form">Tipo de adicción:</label>
                        <select class="custom-select custom-select-sm" id="tipoAdiccion">
                            <option value="" selected disabled>SELECCIONE UN TIPO DE ADICCIÓN</option>
                            <?php foreach ($data['entrevistaDetenido']['adicciones'] as $item) : ?>
                                <option value="<?php echo $item->Nombre_Adiccion ?>"><?php echo $item->Nombre_Adiccion ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback" id="tipoAdiccion-invalid">
                            El tipo es requerido.
                        </div>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="tiempoConsumo" class="label-form">Tiempo de consumo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="tiempoConsumo">
                        <div class="invalid-feedback" id="tiempoConsumo-invalid">
                            El tiempo es requerido.
                        </div>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="frecuenciaConsumo" class="label-form">Frecuencia:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="frecuenciaConsumo">
                        <div class="invalid-feedback" id="frecuenciaConsumo-invalid">
                            La frecuancia es requerida.
                        </div>
                    </div>
                    <fieldset class="form-group col-sm-4">
                        <legend class="col-form-label pl-1">¿Roba para consumir o mantener la adicción?</legend>
                        <div class="container ml-1">
                            <div class="row">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mantener" id="mantener1" value="No" checked onclick="showHide('mantener')">
                                    <label class="form-check-label" for="mantener1">
                                        No
                                    </label>
                                </div>
                                <div class="form-check ml-5">
                                    <input class="form-check-input" type="radio" name="mantener" id="mantener2" value="Si" onclick="showHide('mantener')">
                                    <label class="form-check-label" for="mantener2">
                                        Si
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div id="mantener" class="form-group col-sm-11">
                        <label for="sueleRobar" class="label-form">¿Qué suele robar?</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="sueleRobar">
                        <div class="invalid-feedback" id="sueleRobar-invalid">
                            El campo es requerido.
                        </div>
                    </div>
                    <div class="col-lg-1 d-flex align-items-center">
                        <button type="button" class="btn btn-primary button-movil-plus" onclick="onFormAdiccionesSubmit()">+</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="adiccones">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Tipo</th>
                                <th scope="col">Tiempo de consumo</th>
                                <th scope="col">Frecuencia</th>
                                <th scope="col">Qué suele robar</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <fieldset class="form-group col-sm-12">
                <legend class="col-form-label pl-1">Faltas administrativas</legend>
                <div class="container ml-1">
                    <div class="row">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="faltas" id="faltas1" value="No" checked onclick="showHide('faltas')">
                            <label class="form-check-label" for="faltas1">
                                No
                            </label>
                        </div>
                        <div class="form-check ml-5">
                            <input class="form-check-input" type="radio" name="faltas" id="faltas2" value="Si" onclick="showHide('faltas')">
                            <label class="form-check-label" for="faltas2">
                                Si
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset>

            <div id="faltas" class="col-sm-12">
                <div class="alert alert-warning" role="alert" id="alertEditFaltaAdmin">
                    Está realizando edición a un elemento.
                </div>
                <span class="span_error" id="inputsFaltas_error"></span>
                <div class="form-row mt-3">
                    <div class="form-group col-sm-8">
                        <label for="descripcionFaltaAdministrativa" class="label-form">Descripción de la falta administrativa:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="descripcionFaltaAdministrativa">
                        <div class="invalid-feedback" id="descripcionFaltaAdministrativa-invalid">
                            La falta es requerida.
                        </div>
                    </div>
                    <div class="col-sm-3 d-flex justify-content-center align-items-center">
                        <span class="span_rem">Fecha: </span>
                        <input type="date" id="dateFaltaAdministrativa" class="form-control custom-input_dt fecha" value="<?php echo date('Y-m-d') ?>">
                        <div class="invalid-feedback" id="dateFaltaAdministrativa-invalid">
                            La fecha es requerida.
                        </div>
                    </div>
                    <div class="col-lg-1 d-flex align-items-center">
                        <button type="button" class="btn btn-primary button-movil-plus" onclick="onFormFaltasSubmit()">+</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="faltasAdministrativas">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Descripción</th>
                                <th scope="col">Fecha</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <fieldset class="form-group col-sm-12">
                <legend class="col-form-label pl-1">Antecedentes penales</legend>
                <div class="container ml-1">
                    <div class="row">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="antecedentes" id="antecedentes1" value="No" checked onclick="showHide('antecedentes')">
                            <label class="form-check-label" for="antecedentes1">
                                No
                            </label>
                        </div>
                        <div class="form-check ml-5">
                            <input class="form-check-input" type="radio" name="antecedentes" id="antecedentes2" value="Si" onclick="showHide('antecedentes')">
                            <label class="form-check-label" for="antecedentes2">
                                Si
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset>

            <div id="antecedentes" class="col-sm-12">
                <div class="alert alert-warning" role="alert" id="alertEditAntecedente">
                    Está realizando edición a un elemento.
                </div>
                <span class="span_error" id="inputsAntecedentes_error"></span>
                <div class="form-row mt-3">
                    <div class="form-group col-sm-8">
                        <label for="descripcionAntecedentePenal" class="label-form">Descripción de los antecedentes:</label>
                        <textarea rows="2" maxlength="6000" class="form-control form-control-sm text-uppercase" id="descripcionAntecedentePenal"></textarea>
                        <div class="invalid-feedback" id="descripcionAntecedentePenal-invalid">
                            La descripción es requerida.
                        </div>
                    </div>
                    <div class="col-sm-3 d-flex justify-content-center align-items-center">
                        <span class="span_rem">Fecha: </span>
                        <input type="date" id="dateAntecedentePenal" class="form-control custom-input_dt fecha" value="<?php echo date('Y-m-d') ?>">
                        <div class="invalid-feedback" id="dateAntecedentePenal-invalid">
                            La fecha es requerida.
                        </div>
                    </div>
                    <div class="col-lg-1 d-flex align-items-center">
                        <button type="button" class="btn btn-primary button-movil-plus" onclick="onFormAntecedentesSubmit()">+</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="antecedentePenales">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Descripción</th>
                                <th scope="col">Fecha</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-group col-sm-6">
                <label for="motivoDelinquir" class="label-form">¿Qué lo motivó a delinquir?:</label>
                <textarea class="form-control text-uppercase" name="motivoDelinquir" id="motivoDelinquir" rows="6"></textarea>
                <span class="span_error" id="motivoDelinquir_error"></span>
            </div>

            <div class="form-group col-sm-6">
                <label for="modusOperandi" class="label-form">Modus operandi:</label>
                <textarea class="form-control text-uppercase" name="modusOperandi" id="modusOperandi" rows="6"></textarea>
                <span class="span_error" id="modusOperandi_error"></span>
            </div>
        </div>

        <div class="row mt-5 mb-5">

            <div class="col-12 d-flex justify-content-between col-sm-12">
                <a class="btn btn-sm btn-ssc btn-tab-getIndex" data-id="8" id="btn-tab-getIndex-8" message="msg_entrevista">Validar</a>
                <div>
                    <a class="btn btn-sm btn-ssc" id="btn_entrevista">Guardar</a>
                    <span class="advise-span text-center ml-2 mt-2 span-message" id="span-message-8">* Lo sentimos, el tab ha sido validado. Su usuario no tiene los permisos necesarios para editar</span>
                </div>
            </div>
        </div>
    </form>

</div> 