<div class="container">

    <div class="row mt-5">
        <div class="col-auto my-auto">
            <button class="btn btn-sm back-btn mb-3 d-flex justify-content-center my-auto" data-toggle="tooltip" data-placement="top" title="Regresar" onclick="goToBack()">
                <i class="material-icons">arrow_back</i>
            </button>
        </div>
        <div class="col-auto my-auto mr-auto">
            <h5 class="title-width my-auto">
                <span>Anexo D. Inventario de armas y objetos</span>
                <!-- <span class="navegacion">/nuevo</span> -->
            </h5>
        </div>

        <div class="col-auto my-auto mx-auto mx-lg-0 ml-0 ml-lg-auto mi_hide" id="id_edit_button_panel">
            <button class="btn btn-primary" id="id_edit_button">Modo Editar</button>
        </div>
    </div>

    <form class="row mb-5" id="formAnexoCArmas" onsubmit="event.preventDefault()">
        <input type="hidden" id="Id_Puesta" name="Id_Puesta" value="<?= $data['id_puesta'] ?>">
        <input type="hidden" id="Id_Inventario_Arma" name="Id_Inventario_Arma" value="<?= $data['id_elem'] ?>">
        <h6 class="col-12 text-center mt-2 text-divider">Apartado D.1 Registro de armas de fuego</h6>

        <!-- Edit/See Button -->

        <div class="col-12 mt-2" id="msg_anexoDArmasError"></div>
        <span class="advise-span text-center col-12 mb-1">Seleccione si se trata de aportación o inspección, según corresponda.</span>

        <div class="form-group col-lg-12 d-flex justify-content-center align-items-center">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" class="custom-control-input" id="Aportacion" name="Aportacion">
                <label class="custom-control-label" for="Aportacion" style="font-size: 14px;">Aportación</label>
            </div>
        </div>

        <div class="col-lg-12 d-flex align-items-center justify-content-center">
            <label for="0" class="label-form">Inspección:</label>
        </div>

        <div class="form-group col-lg-12 d-flex justify-content-center align-items-center">
            <div class="custom-control custom-radio custom-control-inline ">
                <input type="radio" id="Lugar" name="Inspeccion" class="custom-control-input" value="Lugar">
                <label class="custom-control-label label-form" for="Lugar">Lugar</label>
            </div>

            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="Persona" name="Inspeccion" class="custom-control-input" value="Persona">
                <label class="custom-control-label label-form" for="Persona">Persona</label>
            </div>

            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="Vehiculo" name="Inspeccion" class="custom-control-input" value="Vehiculo">
                <label class="custom-control-label label-form" for="Vehiculo">Vehículo</label>
            </div>
        </div>

        <div class="form-group col-lg-12">
            <label for="" class="label-form">¿Dónde se encontró el arma?</label>
            <textarea class="form-control form-control-sm text-uppercase" id="Ubicacion_Arma" name="Ubicacion_Arma" maxlength="1000"> </textarea>
            <span class="span_error" id="Ubicacion_Arma_error"></span>
        </div>

        <div class="col-lg-12 d-flex align-items-center justify-content-center">
            <label for="0" class="label-form">Tipo de arma:</label>
        </div>

        <div class="form-group col-lg-12 d-flex justify-content-center align-items-center">
            <div class="custom-control custom-radio custom-control-inline ">
                <input type="radio" id="Corta" name="Tipo_Arma" class="custom-control-input" value="Corta" checked>
                <label class="custom-control-label label-form" for="Corta">Corta</label>
            </div>

            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="Larga" name="Tipo_Arma" class="custom-control-input" value="Larga">
                <label class="custom-control-label label-form" for="Larga">Larga</label>
            </div>
        </div>

        <div class="form-group col-lg-3">
            <label for="Calibre" class="label-form">Calibre:</label>
            <input type="text" class="form-control form-control-sm text-uppercase" id="Calibre" name="Calibre" maxlength="45">
            <span class="span_error" id="Calibre_error"></span>
        </div>

        <div class="form-group col-lg-3">
            <label for="Color" class="label-form">Color:</label>
            <input type="text" class="form-control form-control-sm text-uppercase" id="Color" name="Color" maxlength="45">
            <span class="span_error" id="Color_error"></span>
        </div>

        <div class="form-group col-lg-3">
            <label for="Matricula" class="label-form">Matrícula:</label>
            <input type="text" class="form-control form-control-sm text-uppercase" id="Matricula" name="Matricula" maxlength="45">
            <span class="span_error" id="Matricula_error"></span>
        </div>

        <div class="form-group col-lg-3">
            <label for="Num_Serie" class="label-form">No. Serie:</label>
            <input type="text" class="form-control form-control-sm text-uppercase" id="Num_Serie" name="Num_Serie" maxlength="45">
            <span class="span_error" id="Num_Serie_error"></span>
        </div>

        <div class="form-group col-lg-6">
            <label for="Observaciones" class="label-form">Observaciones</label>
            <textarea class="form-control form-control-sm text-uppercase" id="Observaciones" name="Observaciones" rows="4" maxlength="10000"></textarea>
            <span class="span_error" id="Observaciones_error"></span>
        </div>

        <div class="form-group col-lg-6">
            <label for="Destino" class="label-form">Destino que se le dio:</label>
            <textarea class="form-control form-control-sm text-uppercase" id="Destino" name="Destino" rows="4"> </textarea>
            <span class="span_error" id="Destino_error"></span>
        </div>




        <span class="advise-span text-center col-12 my-3">Anote el nombre y firma de la persona a la que se le aseguró el arma.</span>

        <div class="form-group col-lg-4">
            <label for="Nombre_A" class="label-form">Nombre:</label>
            <input type="text" class="form-control form-control-sm text-uppercase" id="Nombre_A" name="Nombre_A" maxlength="250">
            <span class="span_error" id="Nombre_A_error"></span>
        </div>

        <div class="form-group col-lg-4">
            <label for="Ap_Paterno_A" class="label-form">Apellido Paterno:</label>
            <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Paterno_A" name="Ap_Paterno_A" maxlength="250">
            <span class="span_error" id="Ap_Paterno_A_error"></span>
        </div>

        <div class="form-group col-lg-4">
            <label for="Ap_Materno_A" class="label-form">Apellido Materno:</label>
            <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Materno_A" name="Ap_Materno_A" maxlength="250">
            <span class="span_error" id="Ap_Materno_A_error"></span>
        </div>

        <span class="advise-span text-center col-12 my-3">En caso de que la persona a la que se le aseguró el arma no acceda a firmar, anote nombre y firma de dos testigos.</span>

        <div class="col-lg-12 d-flex align-items-center justify-content-center">
            <label for="0_1" class="label-form">¿Desea agregar testigos?:</label>
        </div>


        <div class="form-group col-lg-12 d-flex justify-content-center align-items-center">
            <div class="custom-control custom-radio custom-control-inline ">
                <input type="radio" id="testigo_0" name="testigos" class="custom-control-input" value="No" checked>
                <label class="custom-control-label label-form" for="testigo_0">No</label>
            </div>

            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="testigo_1" name="testigos" class="custom-control-input" value="Si">
                <label class="custom-control-label label-form" for="testigo_1">Si</label>
            </div>
        </div>

        <div class="col-12" id="div_testigos">
            <div class="row">
                <span class="advise-span text-center col-12 my-3">Primer testigo</span>
                <div class="form-group col-lg-4">
                    <label for="Nombre_TA_0" class="label-form">Nombre:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Nombre_TA_0" name="Nombre_TA_0" maxlength="250">
                    <span class="span_error" id="Nombre_TA_0_error"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="Ap_Paterno_TA_0" class="label-form">Apellido Paterno:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Paterno_TA_0" name="Ap_Paterno_TA_0" maxlength="250">
                    <span class="span_error" id="Ap_Paterno_TA_0_error"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="Ap_Materno_TA_0" class="label-form">Apellido Materno:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Materno_TA_0" name="Ap_Materno_TA_0" maxlength="250">
                    <span class="span_error" id="Ap_Materno_TA_0_error"></span>
                </div>

                <div class="col-12 dropdown-divider"></div>

                <span class="advise-span text-center col-12 my-3">Segundo testigo</span>
                <div class="form-group col-lg-4">
                    <label for="Nombre_TA_1" class="label-form">Nombre:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Nombre_TA_1" name="Nombre_TA_1" maxlength="250">
                    <span class="span_error" id="Nombre_TA_1_error"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="Ap_Paterno_TA_1" class="label-form">Apellido Paterno:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Paterno_TA_1" name="Ap_Paterno_TA_1" maxlength="250">
                    <span class="span_error" id="Ap_Paterno_TA_1_error"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="Ap_Materno_TA_1" class="label-form">Apellido Materno:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Materno_TA_1" name="Ap_Materno_TA_1" maxlength="250">
                    <span class="span_error" id="Ap_Materno_TA_1_error"></span>
                </div>
            </div>
        </div>


        <h6 class="col-12 text-center mt-5 mb-4 text-divider">Apartado D.2 Datos del primer respondiente que realizó la recolección y/o aseguramiento del o las armas, sólo si es diferente a quien firmó la puesta a disposición</h6>
        <div class="col-lg-12 d-flex align-items-center justify-content-center">
            <label for="0_1" class="label-form">¿El elemento correspode al primer respondiente?:</label>
        </div>
        <div class="form-group col-lg-12 d-flex justify-content-center align-items-center">
            <div class="custom-control custom-radio custom-control-inline ">
                <input type="radio" id="arma_0" name="arma" class="custom-control-input" value="No">
                <label class="custom-control-label label-form" for="arma_0">No</label>
            </div>

            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="arma_1" name="arma" class="custom-control-input" value="Si" checked>
                <label class="custom-control-label label-form" for="arma_1">Si</label>
            </div>
        </div>

        <div class="col-12" id="div_respondientes_Armas">
            
            <div class="input-group col-lg-6 offset-lg-3 my-2">
                <input type="text" class="form-control text-uppercase form-control-sm" placeholder="Ingrese el número de control, placa ó apellidos del elemento" id="element_search">
                <div class="input-group-append">
                    <button class="btn btn-ssc btn-sm" type="button" id="button_search">Buscar</button>
                </div>
            </div>
            <div class="col-lg-6 offset-lg-3 mb-3" id="list_elements_search"></div>


            <div class="row">
                <div class="form-group col-lg-4">
                    <label for="Nombre_PRA" class="label-form">Nombre:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Nombre_PRA" name="Nombre_PRA" maxlength="250">
                    <span class="span_error" id="Nombre_PRA_error"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="Ap_Paterno_PRA" class="label-form">Apellido Paterno:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Paterno_PRA" name="Ap_Paterno_PRA" maxlength="250">
                    <span class="span_error" id="Ap_Paterno_PRA_error"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="" class="label-form">Apellido Materno:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Materno_PRA" name="Ap_Materno_PRA" maxlength="250">
                    <span class="span_error" id="Ap_Materno_PRA_error"></span>
                </div>

                <div class="form-group col-lg-6">
                    <label for="InstitucionA" class="label-form">Adscripción:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="InstitucionA" name="InstitucionA" maxlength="250">
                    <span class="span_error" id="InstitucionA_error"></span>
                </div>

                <div class="form-group col-lg-6">
                    <label for="CargoA" class="label-form">Grado/Cargo:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="CargoA" name="CargoA" maxlength="250">
                    <span class="span_error" id="CargoA_error"></span>
                </div>
            </div>
        </div>

        <div class="col-12 d-flex justify-content-center col-sm-12 my-5">
            <button type="button" class="btn btn-secondary mr-4" onclick="goToBack()" id="id_cancel_button">Cancelar</button>
            <button class="btn btn-sm btn-ssc" id="btnAnexoDArmas" data-id="insertar" onclick="sendForm(event)">Guardar</button>
        </div>
    </form>

</div>