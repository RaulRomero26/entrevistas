<div class="container">
    <div class="row mt-5">
        <div class="col-auto my-auto">
            <button class="btn btn-sm back-btn mb-3 d-flex justify-content-center my-auto" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="goToBack()">
                <i class="material-icons">arrow_back</i>
            </button>
        </div>
        <div class="col-auto my-auto mr-auto">
            <h5 class="title-width my-auto">
                <span>Anexo F - Entrega - Recepción del lugar de la intervención</span>
                <span class="navegacion">/ nuevo</span>
            </h5>
        </div>

        <div class="col-auto my-auto mx-auto mx-lg-0 ml-0 ml-lg-auto mi_hide" id="id_edit_button_panel">
            <button class="btn btn-primary" id="id_edit_button">Modo Editar</button>
        </div>


    </div>
    <form onsubmit="event.preventDefault()" id="anexoFForm">
        <input type="hidden" id="Id_Puesta" name="Id_Puesta" value="<?= $data['id_puesta'] ?>">
        <input type="hidden" id="Id_Entrega_Recepcion_Lugar" name="Id_Entrega_Recepcion_Lugar" value="<?= $data['id_elem'] ?>">
        <h6 class="text-center text-divider mt-5 mb-4">Apartado F.1 Preservación del lugar de la intervención</h6>
        <div class="col-12 mt-2" id="msg_anexoFError"></div>
        <div class="row my-3">
            <div class="form-group col-lg-12">
                <label for="Destino" class="label-form">Explique brevemente las acciones realizadas para la preservación del lugar de la intervención. (delimitación, acordonamiento, clausura en lugar cerrado, etc.)</label>
                <textarea class="form-control form-control-sm text-uppercase" id="Descripcion_PL" name="Descripcion_PL" rows="3" maxlength="16000"> </textarea>
                <span class="span_error" id="Descripcion_PL_error"></span>
            </div>

            <div class="col-lg-12 d-flex align-items-center justify-content-center">
                <label for="0_1" class="label-form">¿Solicitó apoyo de alguna autoridad o servicios especializados en el lugar de la intervención?:</label>
            </div>

            <div class="form-group col-lg-12 d-flex justify-content-center align-items-center">
                <div class="custom-control custom-radio custom-control-inline ">
                    <input type="radio" id="autoridad_0" name="autoridad" class="custom-control-input" value="No" checked>
                    <label class="custom-control-label label-form" for="autoridad_0">No</label>
                </div>

                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="autoridad_1" name="autoridad" class="custom-control-input" value="Si">
                    <label class="custom-control-label label-form" for="autoridad_1">Si</label>
                </div>
            </div>

            <div id="div_Descripcion_Apoyo" class="col-12">
                <div class="form-group col-lg-12">
                    <label for="id_num_detencion" class="label-form">¿Cuál?</label>
                    <textarea class="form-control form-control-sm text-uppercase" id="Descripcion_Apoyo" name="Descripcion_Apoyo" rows="3" maxlength="250"></textarea>
                    <span class="span_error" id="Descripcion_Apoyo_error"></span>
                </div>
            </div>

            <h6 class="text-center text-divider col-12 mt-5 mb-4">Apartado F.2 Acciones realizadas después de la preservación del lugar</h6>

            <div class="col-lg-12 d-flex align-items-center justify-content-center">
                <label for="0_1" class="label-form">Después de la preservación del lugar de la intervención, ¿Ingresó alguna persona al lugar?:</label>
            </div>

            <div class="form-group col-lg-12 d-flex justify-content-center align-items-center">
                <div class="custom-control custom-radio custom-control-inline ">
                    <input type="radio" id="persona_0" name="persona" class="custom-control-input" value="No" checked>
                    <label class="custom-control-label label-form" for="persona_0">No</label>
                </div>

                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="persona_1" name="persona" class="custom-control-input" value="Si">
                    <label class="custom-control-label label-form" for="persona_1">Si</label>
                </div>
            </div>

            <div id="id_Motivo" class="col-12">
                <div class="form-group col-lg-12">
                    <label for="Destino" class="label-form">Motivo de ingreso</label>
                    <textarea class="form-control form-control-sm text-uppercase" id="Motivo_Ingreso" name="Motivo_Ingreso" rows="3" maxlength="2500"> </textarea>
                    <span class="span_error" id="Motivo_Ingreso_error"></span>
                </div>

                <div class="row">
                    <h6 class="text-center text-divider mt-2 col-12 mt-5 mb-4">Datos del personal que ingreso al lugar de intervención</h6>

                    <div class="alert alert-warning col-lg-12 text-center" role="alert" id="alertEditPersonal">Está realizando edición del personal que ingreso al lugar de la intervención.</div>

                    <div class="col-12">
                        <div class="input-group col-lg-6 offset-lg-3 my-2">
                            <input type="text" class="form-control text-uppercase form-control-sm" placeholder="Ingrese el número de control, placa ó apellidos del elemento" id="element_search_2">
                            <div class="input-group-append">
                                <button class="btn btn-ssc btn-sm" type="button" id="button_search_2">Buscar</button>
                            </div>
                        </div>
                        <div class="col-lg-6 offset-lg-3 mb-3" id="list_elements_search_2"></div>
                    </div>

                    <div class="form-group col-lg-2 ">
                        <label for="Nombre_PLI" class="label-form">Nombre(s):</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Nombre_PLI" name="Nombre_PLI" maxlength="250">
                        <span class="span_error" id="Nombre_PLI_error"></span>
                    </div>
                    <div class="form-group col-lg-2 ">
                        <label for="Ap_Paterno_PLI" class="label-form">Apellido Paterno:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Paterno_PLI" name="Ap_Paterno_PLI" maxlength="250">
                        <span class="span_error" id="Ap_Paterno_PLI_error"></span>
                    </div>
                    <div class="form-group col-lg-2 ">
                        <label for="Ap_Materno_PLI" class="label-form">Apellido Materno:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Materno_PLI" name="Ap_Materno_PLI" maxlength="250">
                        <span class="span_error" id="Ap_Materno_PLI_error"></span>
                    </div>
                    <div class="form-group col-lg-2 ">
                        <label for="Cargo" class="label-form">Grado/Cargo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Cargo" name="Cargo" maxlength="250">
                        <span class="span_error" id="Cargo_error"></span>
                    </div>
                    <div class="form-group col-lg-2 ">
                        <label for="Institucion" class="label-form">Institución:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Institucion" name="Institucion" maxlength="250">
                        <span class="span_error" id="Institucion_error"></span>
                    </div>

                    <div class="col d-flex align-items-center justify-content-center ">
                        <button type="button" id="btn-add-personal" class="btn btn-primary button-movil-plus">+</button>
                    </div>

                    <div class="table-responsive my-5">
                        <table class="table table-bordered" id="elementos_intervencion" name="elementos_intervencion">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Apellido Paterno</th>
                                    <th scope="col">Apellido Materno</th>
                                    <th scope="col">Grado/Cargo</th>
                                    <th scope="col">Institución</th>
                                    <th scope="col" class="action_0"></th>
                                    <th scope="col" class="action_1"></th>
                                </tr>
                            <tbody>
                            </tbody>
                            </thead>
                        </table>
                        <span class="span_error d-flex justify-content-center" id="tabla_error"></span>
                    </div>
                </div>


            </div>

            <h6 class="text-center text-divider mt-5 mb-4 col-12">Apartado F.3 Entrega - recepción del lugar de la intervención</h6>
            <label for="id_descripcion_detenido" class="label-form text-center col-12 mt-2">Datos de la persona que entrega el lugar de la intervención.</label>

            <div class="input-group col-lg-6 offset-lg-3 my-2">
                <input type="text" class="form-control text-uppercase form-control-sm" placeholder="Ingrese el número de control, placa ó apellidos del elemento" id="element_search">
                <div class="input-group-append">
                    <button class="btn btn-ssc btn-sm" type="button" id="button_search">Buscar</button>
                </div>
            </div>
            <div class="col-lg-6 offset-lg-3 mb-3" id="list_elements_search"></div>

            <div class="form-group col-lg-4 ">
                <label for="Nombre_PER_0" class="label-form">Nombre(s):</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Nombre_PER_0" name="Nombre_PER_0" maxlength="200">
                <span class="span_error" id="Nombre_PER_0_error"></span>
            </div>

            <div class="form-group col-lg-4 ">
                <label for="Ap_Paterno_PER_0" class="label-form">Apellido Paterno:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Paterno_PER_0" name="Ap_Paterno_PER_0" maxlength="450">
                <span class="span_error" id="Ap_Paterno_PER_0_error"></span>
            </div>


            <div class="form-group col-lg-4 ">
                <label for="Ap_Materno_PER_0" class="label-form">Apellido Materno:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Materno_PER_0" name="Ap_Materno_PER_0" maxlength="450">
                <span class="span_error" id="Ap_Materno_PER_0_error"></span>
            </div>

            <div class="form-group col-lg-6 ">
                <label for="Institucion_0" class="label-form">Adscripción:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Institucion_0" name="Institucion_0" maxlength="450">
                <span class="span_error" id="Institucion_0_error"></span>
            </div>

            <div class="form-group col-lg-6 ">
                <label for="Cargo_0" class="label-form">Cargo:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Cargo_0" name="Cargo_0" maxlength="450">
                <span class="span_error" id="Cargo_0_error"></span>
            </div>

            <div class="col-12 dropdown-divider my-4"></div>

            <label for="id_descripcion_detenido" class="label-form text-center col-lg-12">Datos de la persona que recibe el lugar de la intervención.</label>

            <div class="input-group col-lg-6 offset-lg-3 my-2">
                <input type="text" class="form-control text-uppercase form-control-sm" placeholder="Ingrese el número de control, placa ó apellidos del elemento" id="element_search_1">
                <div class="input-group-append">
                    <button class="btn btn-ssc btn-sm" type="button" id="button_search_1">Buscar</button>
                </div>
            </div>
            <div class="col-lg-6 offset-lg-3 mb-3" id="list_elements_search_1"></div>

            <div class="form-group col-lg-4 ">
                <label for="Nombre_PER_1" class="label-form">Nombre(s):</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Nombre_PER_1" name="Nombre_PER_1" maxlength="200">
                <span class="span_error" id="Nombre_PER_1_error"></span>
            </div>

            <div class="form-group col-lg-4 ">
                <label for="Ap_Paterno_PER_1" class="label-form">Apellido Paterno:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Paterno_PER_1" name="Ap_Paterno_PER_1" maxlength="450">
                <span class="span_error" id="Ap_Paterno_PER_1_error"></span>
            </div>

            <div class="form-group col-lg-4 ">
                <label for="Ap_Materno_PER_1" class="label-form">Apellido Materno:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Materno_PER_1" name="Ap_Materno_PER_1" maxlength="450">
                <span class="span_error" id="Ap_Materno_PER_1_error"></span>
            </div>

            <div class="form-group col-lg-6 ">
                <label for="Institucion_1" class="label-form">Adscripción:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Institucion_1" name="Institucion_1" maxlength="450">
                <span class="span_error" id="Institucion_1_error"></span>
            </div>

            <div class="form-group col-lg-6 ">
                <label for="Cargo_1" class="label-form">Cargo:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Cargo_1" name="Cargo_1" maxlength="450">
                <span class="span_error" id="Cargo_1_error"></span>
            </div>

            <div class="form-group col-lg-12">
                <label for="Observaciones" class="label-form">Observaciones: </label>
                <textarea class="form-control form-control-sm text-uppercase" id="Observaciones" name="Observaciones" rows="3" maxlength="4500"> </textarea>
                <span class="span_error" id="Observaciones_error"></span>
            </div>

            <h6 class="text-center text-divider mt-5 mb-4 col-12">Apartado F.4 Fecha y hora de la entrega - recepción del lugar de la intervención</h6>

            <div class="form-group col-lg-6 ">
                <label for="Fecha" class="label-form">Fecha:</label>
                <input type="date" class="form-control form-control-sm text-uppercase" id="Fecha" name="Fecha" maxlength="250">
                <span class="span_error" id="Fecha_error"></span>
            </div>

            <div class="form-group col-lg-6 ">
                <label for="Hora" class="label-form">Hora:</label>
                <input type="time" class="form-control form-control-sm text-uppercase" id="Hora" name="Hora" maxlength="250">
                <span class="span_error" id="Hora_error"></span>
            </div>

            <div class="col-12 d-flex justify-content-center col-sm-12 my-5">
                <button type="button" class="btn btn-secondary mr-4" onclick="goToBack()" id="id_cancel_button">Cancelar</button>
                <button class="btn btn-sm btn-ssc" id="btn_anexoF" data-id="insertar" onclick="sendForm(event)">Guardar</button>
            </div>
        </div>
    </form>
</div>