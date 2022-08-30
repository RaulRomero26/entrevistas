<div class="container">


    <div class="row my-5">
        <div class="col-auto my-auto">
            <button class="btn btn-sm back-btn mb-3 d-flex justify-content-center my-auto" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="goToBack()">
                <i class="material-icons">arrow_back</i>
            </button>
        </div>
        <div class="col-auto my-auto mr-auto">
            <h5 class="title-width my-auto">
                <span>Eventos Delictivos</span>
                <span class="navegacion">/ <?php echo (isset($data['folio'])) ? 'Editar': 'Nuevo' ?></span>
            </h5>
        </div>
        <!-- Edit/See Button -->
        <div class="col-auto my-auto mx-auto mx-lg-0 ml-0 ml-lg-auto" id="id_edit_button_panel">
            <?php if(isset($data['folio'])){ ?>
                <button class="btn btn-primary" id="id_edit_button">Modo Editar</button>
                <input type="hidden" id="modo">
            <?php } ?>
        </div>
    </div>

    <form id="form_evento_delictivo" onsubmit="event.preventDefault();">
        <div class="row">
            <div id="msg_error_evento_delictivo" class="col-lg-12 col-12"></div>
            <div class="form-group col-12 col-md-6 col-lg-2">
                <label for="folio_no" class="label-form">Folio No.:</label>
                <input type="number" class="form-control form-control-sm text-uppercase" id="folio_no" name="folio_no" value="<?php if(isset($data['folio'])) echo $data['folio'] ?>" <?php if(isset($data['folio'])) echo 'readonly' ?> maxlength="10">
                <small id="folio_no_error" class="form-text text-danger "></small>
            </div>
            <div class="form-group col-12 col-md-6 col-lg-1">
                <label for="" class="label-form">Zona:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="zona" name="zona" maxlength="250">
                <small id="zona_error" class="form-text text-danger "></small>
            </div>
            <div class="form-group col-12 col-md-6 col-lg-1">
                <label for="" class="label-form">Vector:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="vector" name="vector" maxlength="250">
                <small id="vector_error" class="form-text text-danger "></small>
            </div>
            <div class="form-group col-12 col-md-6 col-lg-2">
                <label for="" class="label-form">Cia:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="cia" name="cia" maxlength="250">
                <small id="cia_error" class="form-text text-danger "></small>
            </div>
            <div class="form-group col-12 col-md-6 col-lg-3">
                <label for="" class="label-form">Fecha:</label>
                <input type="date" class="form-control form-control-sm text-uppercase" id="fecha" name="fecha" value="<?php echo date('Y-m-d') ?>">
                <small id="fecha_error" class="form-text text-danger "></small>
            </div>
            <div class="form-group col-12 col-md-6 col-lg-3">
                <label for="" class="label-form">Hora Reporte:</label>
                <input type="time" class="form-control form-control-sm text-uppercase" id="hora_reporte" name="hora_reporte" value="<?php echo date('H:i') ?>">
                <small id="hora_reporte_error" class="form-text text-danger "></small>
            </div>

            <div class="container row col-lg-12">
                <div class="col-12 text-center my-3 mb-2">
                    <div class="text-divider">
                        <h6 class="sub_header">Ubicación de los Hechos</h6>
                    </div>
                </div>
            </div>

            <div class="form-group col-12 col-md-6 col-lg-10">
                <label for="" class="label-form">Dom. Calle:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="dom_calle" name="dom_calle" maxlength="250">
                <small id="dom_calle_error" class="form-text text-danger "></small>
            </div>
            <div class="form-group col-12 col-md-6 col-lg-2">
                <label for="" class="label-form">Num:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="num" name="num" maxlength="50">
                <small id="num_error" class="form-text text-danger "></small>
            </div>
            <div class="form-group col-12 col-md-6 col-lg-6">
                <label for="" class="label-form">y Calle:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="calle" name="calle" maxlength="250">
                <small id="calle_error" class="form-text text-danger "></small>
            </div>
            <div class="form-group col-12 col-md-6 col-lg-1">
                <label for="" class="label-form">Tipo:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="tipo_colonia" name="tipo_colonia" readonly>
                <small id="tipo_colonia_error" class="form-text text-danger "></small>
            </div>
            <div class="form-group col-12 col-md-6 col-lg-5">
                <label for="" class="label-form">Colonia:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="colonia" name="colonia" maxlength="250"  autocomplete="off" placeholder="Ingrese los terminos de búsqueda">
                <small id="colonia_error" class="form-text text-danger"></small>
            </div>
            <div class="form-group col-12 col-md-6 col-lg-4">
                <label for="" class="label-form">Tipo de Evento:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="tipo_evento" name="tipo_evento" placeholder="INGRESE LOS TERMINOS DE BUSQUEDA">
                <small id="tipo_evento_error" class="form-text text-danger "></small>
            </div>
            <div class="form-group col-12 col-md-6 col-lg-4">
                <label for="" class="label-form">Giro del Evento:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="giro_evento" name="giro_evento" maxlength="250">
                <small id="giro_evento_error" class="form-text text-danger "></small>
            </div>
            <div class="form-group col-12 col-md-6 col-lg-4">
                <label for="" class="label-form">Caracteristicas del Evento:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="caracteristicas_evento" name="caracteristicas_evento" maxlength="250">
                <small id="caracteristicas_evento_error" class="form-text text-danger "></small>
            </div>
            <div class="form-group col-6">
                <label for="" class="label-form">Objetos Robados:</label>
                <textarea class="form-control text-uppercase" id="objetos_robados" name="objetos_robados" rows="3" maxlength="16000000"></textarea>
                <small id="objetos_robados_error" class="form-text text-danger "></small>
            </div>
            <div class="form-group col-6">
                <label for="" class="label-form">Observaciones:</label>
                <textarea class="form-control text-uppercase" id="observaciones" name="observaciones" rows="3" maxlength="16000000"></textarea>
                <small id="observaciones_error" class="form-text text-danger "></small>
            </div>

            <div id="content_observaciones" class="container col-lg-12">
                <div class="row">
                    <div class="col-12 text-center my-3 mb-2">
                        <div class="text-divider">
                            <h6 class="sub_header">Observaciones</h6>
                        </div>
                    </div>

                    <div class="form-group col-12 col-md-6 col-lg-3">
                        <label for="" class="label-form">Marca:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="marca" name="marca" maxlength="250">
                        <small id="_error" class="form-text text-danger "></small>
                    </div>
                    <div class="form-group col-12 col-md-6 col-lg-3">
                        <label for="" class="label-form">Tipo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="tipo" name="tipo" maxlength="250">
                        <small id="_error" class="form-text text-danger "></small>
                    </div>
                    <div class="form-group col-12 col-md-6 col-lg-1">
                        <label for="" class="label-form">Año:</label>
                        <input type="number" class="form-control form-control-sm text-uppercase" id="anio" name="anio" maxlength="10">
                        <small id="_error" class="form-text text-danger "></small>
                    </div>
                    <div class="form-group col-12 col-md-6 col-lg-3">
                        <label for="" class="label-form">Placas:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="placas" name="placas" maxlength="250">
                        <small id="_error" class="form-text text-danger "></small>
                    </div>
                    <div class="form-group col-12 col-md-6 col-lg-2">
                        <label for="" class="label-form">Color:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="color" name="color" maxlength="250">
                        <small id="_error" class="form-text text-danger "></small>
                    </div>
                </div>
            </div>

            <div class="col-12 text-center my-3 mb-2">
                <div class="text-divider">
                    <h6 class="sub_header">Situación</h6>
                </div>
            </div>

            <div class="form-group col-lg-3">
                <label for="id_num_detencion" class="label-form">Situación</label>
                <br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="situacion" id="situacion_1" value="Consumado" checked>
                    <label class="form-check-label" for="">
                        Evento
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="situacion" id="situacion_2" value="Frustrado">
                    <label class="form-check-label" for="">
                        Remisión
                    </label>
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label for="id_num_detencion" class="label-form">Con Detenidos</label>
                <br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="detenidos" id="detenidos_1" value="No" checked>
                    <label class="form-check-label" for="">
                        No
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="detenidos" id="detenidos_2" value="Si">
                    <label class="form-check-label" for="">
                        Si
                    </label>
                </div>
            </div>
            <div id="detenidos_content" class="col-lg-7 col-12">
                <div class="row px-0">
                    <div class="form-group col-12 col-md-6 col-lg-3">
                        <label for="" class="label-form">Ficha:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="ficha" name="ficha">
                        <small id="ficha_error" class="form-text text-danger "></small>
                    </div>
                    <div class="form-group col-12 col-md-6 col-lg-3">
                        <label for="" class="label-form">Cuantos:</label>
                        <input type="number" class="form-control form-control-sm text-uppercase" id="cuantos" name="cuantos" maxlength="11">
                        <small id="cuantos_error" class="form-text text-danger "></small>
                    </div>
                    <div class="form-group col-12 col-md-6 col-lg-6">
                        <label for="" class="label-form">Remisiones:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="remisiones" name="remisiones" maxlength="250" placeholder="PRESIONE ENTER PARA BUSCAR">
                        <small id="remisiones_error" class="form-text text-danger "></small>
                    </div>
                </div>
            </div>

            <div class="form-group col-lg-3">
                <label for="id_num_detencion" class="label-form">Con Violancia</label>
                <br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="violencia" id="violencia_1" value="No" checked>
                    <label class="form-check-label" for="">
                        No
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="violencia" id="violencia_2" value="Si">
                    <label class="form-check-label" for="">
                        Si
                    </label>
                </div>
            </div>
            <div class="form-group col-12 col-md-6 col-lg-4">
                <label for="" class="label-form">Tipo de Arma:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="tipo_arma" name="tipo_arma" maxlength="250">
                <small id="_error" class="form-text text-danger "></small>
            </div>
            <div class="form-group col-6">
                <label for="" class="label-form">Modus Operandi:</label>
                <textarea class="form-control text-uppercase" id="modus_operandi" name="modus_operandi" rows="3" maxlength="16000000"></textarea>
                <small id="_error" class="form-text text-danger "></small>
            </div>
            <div class="form-group col-6">
                <label for="" class="label-form">Modo de Fuga:</label>
                <textarea class="form-control text-uppercase" id="modo_fuga" name="modo_fuga" rows="3" maxlength="16000000">CON RUMBO DESCONOCIDO</textarea>
                <small id="_error" class="form-text text-danger "></small>
            </div>

            <div class="col-12 text-center my-3 mb-2">
                <div class="text-divider">
                    <h6 class="sub_header">Responsables</h6>
                </div>
            </div>

            <div id="msg_table" class="col-lg-12"></div>

            <div class="row col-lg-12 d-flex align-items-center">
                <div class="form-group col-12 col-md-6 col-lg-3">
                    <label for="" class="label-form">No. Remisión:</label>
                    <input type="number" class="form-control form-control-sm text-uppercase" id="no_remision_table" maxlength="11">
                    <small id="no_remision_table_error" class="form-text text-danger "></small>
                </div>
                <div class="form-group col-12 col-md-6 col-lg-4">
                    <label for="" class="label-form">Nombre Completo:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="nombre_table" maxlength="550">
                    <small id="nombre_table_error" class="form-text text-danger "></small>
                </div>
                <div class="form-group col-12 col-md-6 col-lg-2">
                    <label for="" class="label-form">Edad:</label>
                    <input type="number" class="form-control form-control-sm text-uppercase" id="edad_table" maxlength="3">
                    <small id="edad_table_error" class="form-text text-danger "></small>
                </div>
                <div class="form-group col-12 col-md-6 col-lg-2">
                    <label for="sexo_table" class="label-form">Sexo:</label>
                    <select class="custom-select custom-select-sm" id="sexo_table">
                        <option value="" selected>SELECCIONE UNA OPCIÓN...</option>
                        <option value="MUJER">MUJER</option>
                        <option value="HOMBRE">HOMBRE</option>
                    </select>
                    <small id="sexo_table_error" class="form-text text-danger "></small>
                </div>
                <div class="form-group col-12 col-md-6 col-lg-1">
                    <button class="col-md-6 offset-md-3 btn btn-ssc d-flex justify-content-center" id="btn_add_element">
                        +
                    </button>
                </div>
            </div>
            <table class="table mt-3 table-bordered" id="responsables_table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">No. Remisión</th>
                        <th scope="col">Nombre Completo</th>
                        <th scope="col">Edad</th>
                        <th scope="col">Sexo</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody class="text-uppercase">
                </tbody>
            </table>
            <div class="form-group col-12 col-md-6 col-lg-8">
                <label for="" class="label-form">Agraviado/Peticionario:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="peticionario" name="peticionario">
                <small id="_error" class="form-text text-danger "></small>
            </div>
            <div class="form-group col-12 col-md-6 col-lg-4">
                <label for="" class="label-form">Teléfono:</label>
                <input type="number" class="form-control form-control-sm text-uppercase" id="telefono" name="telefono">
                <small id="_error" class="form-text text-danger "></small>
            </div>
        </div>

        <div class="row col-lg-12 d-flex justify-content-center my-5" id="id_send_buttons_panel">
            <div class="col-auto">
                <button type="button" class="btn btn-secondary" onclick="goToBack()" id="btn_cancel_data">Cancelar</button>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-ssc" id="btn_save_data_ed">Guardar</button>
            </div>
        </div>
    </form>
</div>