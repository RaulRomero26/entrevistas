<div class="container mb-5">
    <div class="row mt-5">
        <div class="col-auto my-auto">
            <button class="btn btn-sm back-btn mb-3 d-flex justify-content-center my-auto" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="goToBack()">
                <i class="material-icons">arrow_back</i>
            </button>
        </div>
        <div class="col-auto my-auto mr-auto">
            <h5 class="title-width my-auto">
                <span>Anexo C. Inspección de vehículo</span>
                <span class="navegacion"></span>
            </h5>
        </div>

        <!-- Edit/See Button -->
        <div class="col-auto my-auto mx-auto mx-lg-0 ml-0 ml-lg-auto mi_hide" id="id_edit_button_panel">
            <button class="btn btn-primary" id="id_edit_button">Modo Editar</button>
        </div>
    </div>
    <form id="anexoCForm" onsubmit="event.preventDefault();">
        <input type="hidden" id="Id_Puesta" name="Id_Puesta" value="<?= $data['id_puesta'] ?>">
        <input type="hidden" id="Id_Inspeccion_Vehiculo" name="Id_Inspeccion_Vehiculo" value="<?= $data['id_elem'] ?>">
        <div class="row">
            <div class="col-12 mt-2" id="msg_anexoCError"></div>
            <h6 class="col-12 text-center text-divider">Apartado C.1 Fecha y hora de la inspección</h6>
            <span class="advise-span text-center col-12 mb-1">Indique la fecha y la hora en que realizó la inspección</span>

            <div class="form-group col-lg-6">
                <label for="fecha" class="label-form">Fecha:</label>
                <input type="date" class="form-control form-control-sm text-uppercase" id="fecha" name="fecha">
                <span class="span_error" id="fecha_error"></span>
            </div>

            <div class="form-group col-lg-6">
                <label for="hora" class="label-form">Hora:</label>
                <input type="time" class="form-control form-control-sm text-uppercase" id="hora" name="hora">
                <span class="span_error" id="hora_error"></span>
            </div>


            <h6 class="col-12 text-center mt-5 mb-4 text-divider">Apartado C.2 Datos generales del vehículo inspeccionado</h6>

            <div class="form-group col-lg-3">
                <label for="tipo" class="label-form">Tipo:</label>
                <select class="custom-select custom-select-sm" name="tipo" id="tipo">
                    <option selected disabled value="">SELECCIONE UNA OPCIÓN</option>
                    <option value="TERRESTRE">TERRESTRE</option>
                    <option value="ACUATICO">ACUÁTICO</option>
                    <option value="AEREO">AÉREO</option>
                </select>
            </div>

            <div class="form-group col-lg-3">
                <label for="Procedencia" class="label-form">Procedencia:</label>
                <select class="custom-select custom-select-sm" name="Procedencia" id="Procedencia">
                    <option selected disabled value="">SELECCIONE UNA OPCIÓN</option>
                    <option value="NACIONAL">NACIONAL</option>
                    <option value="EXTRANJERO">EXTRANJERO</option>

                </select>
            </div>

            <div class="form-group col-lg-3">
                <label for="Uso" class="label-form">Uso:</label>
                <select class="custom-select custom-select-sm" name="Uso" id="Uso">
                    <option selected disabled value="">SELECCIONE UNA OPCIÓN</option>
                    <option value="PARTICULAR">PARTICULAR</option>
                    <option value="TRANSPORTE PUBLICO">TRANSPORTE PÚBLICO</option>
                    <option value="CARGA">CARGA</option>

                </select>
            </div>

            <div class="form-group col-lg-3">
                <label for="Situacion" class="label-form">Situación:</label>
                <select class="custom-select custom-select-sm" name="Situacion" id="Situacion">
                    <option selected disabled value="">SELECCIONE UNA OPCIÓN</option>
                    <option value="CON REPORTE DE ROBO">CON REPORTE DE ROBO</option>
                    <option value="SIN REPORTE DE ROBO">SIN REPORTE DE ROBO</option>
                    <option value="NO ES POSIBLE SABERLO">NO ES POSIBLE SABERLO</option>
                </select>
            </div>

            <div class="form-group col-lg-3">
                <label for="Marca" class="label-form">Marca:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Marca" name="Marca" maxlength="100">
                <span class="span_error" id="Marca_error"></span>
            </div>

            <div class="form-group col-lg-3">
                <label for="Submarca" class="label-form">Submarca:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Submarca" name="Submarca" maxlength="100">
                <span class="span_error" id="Submarca_error"></span>
            </div>

            <div class="form-group col-lg-3">
                <label for="Modelo" class="label-form">Modelo:</label>
                <input type="number" class="form-control form-control-sm text-uppercase" id="Modelo" name="Modelo" maxlength="4">
                <span class="span_error" id="Modelo_error"></span>
            </div>

            <div class="form-group col-lg-3">
                <label for="Color" class="label-form">Color:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Color" name="Color" maxlength="100">
                <span class="span_error" id="Color_error"></span>
            </div>

            <div class="form-group col-lg-6">
                <label for="Placa" class="label-form">Placa:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Placa" name="Placa" maxlength="45">
                <span class="span_error" id="Placa_error"></span>
            </div>

            <div class="form-group col-lg-6">
                <label for="Num_Serie" class="label-form">Número de Serie:</label>
                <input type="text" class="form-control form-control-sm text-uppercase" id="Num_Serie" name="Num_Serie" maxlength="18">
                <span class="span_error" id="Num_Serie_error"></span>
            </div>

            <div class="form-group col-lg-12">
                <label for="Observaciones" class="label-form">Observaciones:</label>
                <textarea class="form-control text-uppercase" id="Observaciones" name="Observaciones" rows="6" maxlength="10000"></textarea>
                <span class="span_error" id="Observaciones_error"></span>
            </div>

            <div class="form-group col-lg-12">
                <label for="Destino" class="label-form">Destino que se le dio:</label>
                <textarea class="form-control text-uppercase" id="Destino" name="Destino" rows="6" maxlength="10000"></textarea>
                <span class="span_error" id="Destino_error"></span>
            </div>

            <h6 class="col-12 text-center mt-5 mb-4 text-divider">Apartado C.3 Objetos encontrados en el vehículo inspeccionado</h6>

            <div class="col-lg-12 d-flex align-items-center justify-content-center">
                <label for="0" class="label-form">¿Encontró objetos relacionados con los hechos?:</label>
            </div>

            <div class="form-group col-lg-12 d-flex justify-content-center align-items-center">
                <div class="custom-control custom-radio custom-control-inline ">
                    <input type="radio" id="Objetos_Encontrados_0" name="Objetos_Encontrados" class="custom-control-input" value="No" checked>
                    <label class="custom-control-label label-form" for="Objetos_Encontrados_0">No</label>
                </div>

                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="Objetos_Encontrados_1" name="Objetos_Encontrados" class="custom-control-input" value="Si">
                    <label class="custom-control-label label-form" for="Objetos_Encontrados_1">Si</label>
                </div>
            </div>
            <h6 class="col-12 text-center mt-5 mb-4 text-divider">Apartado C.4 Datos del primer respondiente que realizó la inspección, sólo si es diferente a quien firmó la puesta a disposición</h6>


            <div class="col-lg-12 d-flex align-items-center justify-content-center">
                <label for="0_1" class="label-form">¿El elemento correspode al primer respondiente?:</label>
            </div>


            <div class="form-group col-lg-12 d-flex justify-content-center align-items-center">
                <div class="custom-control custom-radio custom-control-inline ">
                    <input type="radio" id="pr_0" name="pr" class="custom-control-input" value="No">
                    <label class="custom-control-label label-form" for="pr_0">No</label>
                </div>

                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="pr_1" name="pr" class="custom-control-input" value="Si" checked>
                    <label class="custom-control-label label-form" for="pr_1">Si</label>
                </div>
            </div>

            <div id="div_respondientes">

                <div class="input-group col-lg-6 offset-lg-3 my-2">
                    <input type="text" class="form-control text-uppercase form-control-sm" placeholder="Ingrese el número de control, placa ó apellidos del elemento" id="element_search">
                    <div class="input-group-append">
                        <button class="btn btn-ssc btn-sm" type="button" id="button_search">Buscar</button>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-3 mb-3" id="list_elements_search"></div>


                <span class="advise-span text-center col-12 my-4">Primer elemento (obligatorio)</span>
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="Nombre_PR" class="label-form">Nombre(s):</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Nombre_PR" name="Nombre_PR" maxlength="250">
                        <span class="span_error" id="Nombre_PR_error"></span>
                    </div> 
                    <div class="form-group col-lg-4">
                        <label for="Ap_Paterno_PR" class="label-form">Apeliido Paterno:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Paterno_PR" name="Ap_Paterno_PR" maxlength="250">
                        <span class="span_error" id="Ap_Paterno_PR_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="Ap_Materno_PR" class="label-form">Apellido Materno:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Materno_PR" name="Ap_Materno_PR" maxlength="250">
                        <span class="span_error" id="Ap_Materno_PR_error"></span>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="Institucion" class="label-form">Adscripción:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Institucion" name="Institucion" maxlength="250">
                        <!-- <input type="text" class="form-control form-control-sm text-uppercase" id="" name="Institucion" maxlength="250"> -->
                        <span class="span_error" id="Institucion_error"></span>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="Cargo" class="label-form">Cargo/grado:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Cargo" name="Cargo" maxlength="250">
                        <span class="span_error" id="Cargo_error"></span>
                    </div>

                    <div class="col-12 dropdown-divider"></div>
                    <span class="advise-span text-center col-12 my-4">Segundo elemento (opcional)</span>
                    <div class="input-group col-lg-6 offset-lg-3 my-2">
                        <input type="text" class="form-control text-uppercase form-control-sm" placeholder="Ingrese el número de control, placa ó apellidos del elemento" id="element_search_1">
                        <div class="input-group-append">
                            <button class="btn btn-ssc btn-sm" type="button" id="button_search_1">Buscar</button>
                        </div>
                    </div>
                    <div class="col-lg-6 offset-lg-3 mb-3" id="list_elements_search_1"></div>

                    <div class="form-group col-lg-4">
                        <label for="Nombre_PR_1" class="label-form">Nombre(s):</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Nombre_PR_1" name="Nombre_PR_1" maxlength="250">
                        <span class="span_error" id="Nombre_PR_1_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="Ap_Paterno_PR_1" class="label-form">Apellido Paterno:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Paterno_PR_1" name="Ap_Paterno_PR_1" maxlength="250">
                        <span class="span_error" id="Ap_Paterno_PR_1_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="Ap_Materno_PR_1" class="label-form">Apellido Materno:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Materno_PR_1" name="Ap_Materno_PR_1" maxlength="250">
                        <span class="span_error" id="Ap_Materno_PR_1_error"></span>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="Institucion_1" class="label-form">Adscripción:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Institucion_1" name="Institucion_1" maxlength="250">
                        <span class="span_error" id="Institucion_1_error"></span>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="Cargo_1" class="label-form">Cargo/grado:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="Cargo_1" name="Cargo_1" maxlength="250">
                        <span class="span_error" id="Cargo_1_error"></span>
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center col-sm-12 my-5">

                <button type="button" class="btn btn-secondary mr-4" onclick="goToBack()" id="id_cancel_button">Cancelar</button>
                <button class="btn btn-sm btn-ssc" id="btn_anexoC" data-id="insertar" onclick="senForm(event)">Guardar</button>
            </div>
        </div>
    </form>
</div>