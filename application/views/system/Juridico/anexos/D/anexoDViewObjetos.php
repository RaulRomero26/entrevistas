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
    <form class="mb-5 row" id="formAnexoDObjetos" onsubmit="event.preventDefault()">
        <input type="hidden" id="Id_Puesta" name="Id_Puesta" value="<?= $data['id_puesta'] ?>">
        <input type="hidden" id="Id_Inventario_Objetos" name="Id_Inventario_Objetos" value="<?= $data['id_elem'] ?>">

        <h6 class="col-12 text-center mt-5 mb-4 text-divider">Apartado D.3 Registro de objetos recolectados y/o asegurados relacionados con el hecho probablemente delictivo</h6>
        <div class="col-12 mt-2" id="msg_anexoDObjetosError"></div>
        <div class="col-lg-12 d-flex align-items-center justify-content-center">
            <label class="label-form">¿Qué encontró? (apariencia de)</label>
        </div>

        <div class="form-group col-lg-12 d-flex justify-content-center align-items-center mb-4">
            <div class="custom-control custom-radio custom-control-inline ">
                <input type="radio" id="Narcotico" name="Apariencia" class="custom-control-input" value="Narcótico" checked>
                <label class="custom-control-label label-form" for="Narcotico">Narcótico</label>
            </div>

            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="Hidrocarburo" name="Apariencia" class="custom-control-input" value="Hidrocarburo">
                <label class="custom-control-label label-form" for="Hidrocarburo">Hidrocarburo</label>
            </div>

            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="Numerario" name="Apariencia" class="custom-control-input" value="Numerario">
                <label class="custom-control-label label-form" for="Numerario">Numerario</label>
            </div>

            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="Otro" name="Apariencia" class="custom-control-input" value="Otro">
                <label class="custom-control-label label-form" for="Otro">Otro</label>
            </div>
        </div>

        <div id="div_otro" class="col-12">
            <div class="row">
                <div class="form-group col-lg-4 offset-lg-4">
                    <label for="Ap_Paterno_A" class="label-form">¿De qué?</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="otro" name="otro" maxlength="450">
                    <span class="span_error" id="otro_error"></span>
                </div>
            </div>
        </div>

        <span class="advise-span text-center col-12 mb-1">Seleccione si se trata de aportación o inspección, según corresponda.</span>
        <div class="form-group col-lg-12 d-flex justify-content-center align-items-center mb-4">
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

        <div class="form-group col-lg-6">
            <label for="Ubicacion_Objeto" class="label-form">¿Dónde se encontró el objeto?</label>
            <textarea class="form-control form-control-sm text-uppercase" id="Ubicacion_Objeto" name="Ubicacion_Objeto" rows="3" maxlength="250"> </textarea>
            <span class="span_error" id="Ubicacion_Objeto_error"></span>
        </div>

        <div class="form-group col-lg-6">
            <label for="Destino" class="label-form">Destino que se le dio</label>
            <textarea class="form-control form-control-sm text-uppercase" id="Destino" name="Destino" rows="3" maxlength="250"> </textarea>
            <span class="span_error" id="Destino_error"></span>
        </div>

        <div class="form-group col-lg-12">
            <label for="Descripcion_Objeto" class="label-form">Breve descripción del objeto</label>
            <textarea class="form-control form-control-sm text-uppercase" id="Descripcion_Objeto" name="Descripcion_Objeto" rows="3" maxlength="1001"> </textarea>
            <span class="span_error" id="Descripcion_Objeto_error"></span>
        </div>

        <span class="advise-span text-center col-12 my-3">Anote el nombre y firma de la persona a la que se le aseguró el objeto.</span>

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

        <span class="advise-span text-center col-12 my-3">En caso de que la persona a la que se le aseguró el objeto no acceda a firmar, anote nombre y firma de dos testigos.</span>

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
                    <label for="Nombre_TO_0" class="label-form">Nombre:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Nombre_TO_0" name="Nombre_TO_0" maxlength="250">
                    <span class="span_error" id="Nombre_TO_0_error"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="Ap_Paterno_TO_0" class="label-form">Apellido Paterno:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Paterno_TO_0" name="Ap_Paterno_TO_0" maxlength="250">
                    <span class="span_error" id="Ap_Paterno_TO_0_error"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="Ap_Materno_TO_0" class="label-form">Apellido Materno:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Materno_TO_0" name="Ap_Materno_TO_0" maxlength="250">
                    <span class="span_error" id="Ap_Materno_TO_0_error"></span>
                </div>

                <div class="col-12 dropdown-divider"></div>

                <span class="advise-span text-center col-12 my-3">Segundo testigo</span>
                <div class="form-group col-lg-4">
                    <label for="Nombre_TO_1" class="label-form">Nombre:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Nombre_TO_1" name="Nombre_TO_1" maxlength="250">
                    <span class="span_error" id="Nombre_TO_1_error"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="Ap_Paterno_TO_1" class="label-form">Apellido Paterno:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Paterno_TO_1" name="Ap_Paterno_TO_1" maxlength="250">
                    <span class="span_error" id="Ap_Paterno_TO_1_error"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="Ap_Materno_TO_1" class="label-form">Apellido Materno:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Ap_Materno_TO_1" name="Ap_Materno_TO_1" maxlength="250">
                    <span class="span_error" id="Ap_Materno_TO_1_error"></span>
                </div>

            </div>

        </div>

        <h6 class="col-12 text-center mt-5 mb-4 text-divider">Apartado D.4 Datos del primer respondiente que realizó la recolección y/o aseguramiento del o los objetos, sólo si es diferente a quien firmó la puesta a disposición</h6>

        <div class="col-lg-12 d-flex align-items-center justify-content-center">
            <label for="0_1" class="label-form">¿El elemento correspode al primer respondiente?:</label>
        </div>
        <div class="form-group col-lg-12 d-flex justify-content-center align-items-center">
            <div class="custom-control custom-radio custom-control-inline ">
                <input type="radio" id="respondiente_0" name="respondiente" class="custom-control-input" value="No">
                <label class="custom-control-label label-form" for="respondiente_0">No</label>
            </div>

            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="respondiente_1" name="respondiente" class="custom-control-input" value="Si" checked>
                <label class="custom-control-label label-form" for="respondiente_1">Si</label>
            </div>
        </div>

        <div class="col-12" id="div_respondiente">
            <div class="input-group col-lg-6 offset-lg-3 my-2">
                <input type="text" class="form-control text-uppercase form-control-sm" placeholder="Ingrese el número de control, placa ó apellidos del elemento" id="element_search">
                <div class="input-group-append">
                    <button class="btn btn-primary btn-sm btn-ssc" type="button" id="button_search">Buscar</button>
                </div>
            </div>
            <div class="col-lg-6 offset-lg-3 mb-3" id="list_elements_search"></div>
            <div class="row">
                <div class="form-group col-lg-4">
                    <label for="Nombre_PR" class="label-form">Nombre:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Nombre_PR" name="Nombre_PR" maxlength="250">
                    <span class="span_error" id="Nombre_PR_error"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="Ap_Paterno_PR" class="label-form">Apellido Paterno:</label>
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
                    <span class="span_error" id="Institucion_error"></span>
                </div>

                <div class="form-group col-lg-6">
                    <label for="Cargo" class="label-form">Grado/Cargo:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="Cargo" name="Cargo" maxlength="250">
                    <span class="span_error" id="Cargo_error"></span>
                </div>
            </div>
        </div>

        <div class="col-12 d-flex justify-content-center col-sm-12 my-5">
            <button type="button" class="btn btn-secondary mr-4" onclick="goToBack()" id="id_cancel_button">Cancelar</button>
            <button class="btn btn-sm btn-ssc" id="btnAnexoDObjetos" data-id="insertar" onclick="sendForm(event)">Guardar</button>
        </div>
    </form>
</div>