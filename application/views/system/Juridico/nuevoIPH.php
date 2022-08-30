<div class="sideContent">
    <div class="subSideContent">
        <div class="accordion" id="accordionAnexos">
            <div class="card">
                <div class="card-header d-flex justify-content-between" id="headingOne">
                    <button class="btn btn-block text-left collapsed text-primary" type="button" data-toggle="collapse" data-target="#anexoA" aria-expanded="false" aria-controls="anexoA">
                        <!-- Anexo A  -->
                        DETENCIÓN(ES)
                    </button>
                    <div class="d-flex align-items-center">
                        <?php if($data['button'] && $data['data_puesta']['puesta']->Estatus  != '1'){ ?>
                            <a class="btn btn-ssc btn-sm condicion_concluido" href="<?= base_url?>Juridico/AnexoA?id_puesta=<?= $data['Id_Puesta']?>">Agregar</a>
                        <?php } ?>
                    </div>
                </div>

                <div id="anexoA" class="collapse" aria-labelledby="headingOne" data-parent="#accordionAnexos">
                    <div class="card-body">
                        <?= $data['collapse_anexoA'];?>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between" id="headingTwo">
                    <button class="btn btn-block text-left collapsed text-primary" type="button" data-toggle="collapse" data-target="#anexoB" aria-expanded="false" aria-controls="anexoB">
                        <!-- Anexo B  -->
                        INF USO FUERZA
                    </button>
                    <div class="d-flex align-items-center ">
                        <?php if($data['button'] && $data['data_puesta']['puesta']->Estatus  != '1'){ ?>
                            <a class="btn btn-ssc btn-sm condicion_concluido <?= $data['hide_anexoB']?>" href="<?= base_url?>Juridico/AnexoB?id_puesta=<?= $data['Id_Puesta']?>">Agregar</a>
                        <?php } ?>
                    </div>
                </div>
                <div id="anexoB" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionAnexos">
                    <div class="card-body">
                        <?= $data['collapse_anexoB'];?>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between" id="headingThree">
                    <button class="btn btn-block text-left collapsed text-primary" type="button" data-toggle="collapse" data-target="#anexoC" aria-expanded="false" aria-controls="anexoC">
                        <!-- Anexo C  -->
                        INSPECCIÓN VEHÍCULO
                    </button>
                    <div class="d-flex align-items-center">
                        <?php if($data['button'] && $data['data_puesta']['puesta']->Estatus  != '1'){ ?>
                            <a class="btn btn-ssc btn-sm condicion_concluido" href="<?= base_url?>Juridico/AnexoC/<?= $data['Id_Puesta']?>">Agregar</a>
                        <?php } ?>
                    </div>
                </div>
                <div id="anexoC" class="collapse" aria-labelledby="headingThree" data-parent="#accordionAnexos">
                    <div class="card-body">
                        <?= $data['collapse_anexoC'];?>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between" id="headingThree">
                    
                    <button class="btn btn-block text-left collapsed text-primary" type="button" data-toggle="collapse" data-target="#anexoD" aria-expanded="false" aria-controls="anexoD">
                        <!-- Anexo D  -->
                        ARMAS Y OBJETOS
                    </button>
                    <div class="d-flex align-items-center">
                        <?php if($data['button'] && $data['data_puesta']['puesta']->Estatus  != '1'){ ?>
                            <button type="button" class="btn btn-ssc btn-sm condicion_concluido" data-html="true"  data-toggle="popover"  title="Agregar nueva(o)" data-content="<?= $data['popover_anexoD']?>">
                                Agregar
                            </button>
                        <?php } ?>
                    </div>

                </div>
                <div id="anexoD" class="collapse" aria-labelledby="headingThree" data-parent="#accordionAnexos">
                    <div class="card-body">
                        <p class="text-center text-primary mb-0"><strong>Armas</strong></p>
                        <div class="dropdown-divider mb-4"></div>
                        <?= $data['collapse_anexoD1'];?>

                        <p class="text-center text-primary mb-0"><strong>Objetos</strong></p>
                        <div class="dropdown-divider mb-4"></div>
                        <?= $data['collapse_anexoD2'];?>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between" id="headingOne">
                    <button class="btn btn-block text-left collapsed text-primary" type="button" data-toggle="collapse" data-target="#anexoE" aria-expanded="false" aria-controls="anexoE">
                        <!-- Anexo E  -->
                        ENTREVISTA(S)
                    </button>
                    <div class="d-flex align-items-center">
                        <?php if($data['button'] && $data['data_puesta']['puesta']->Estatus  != '1'){ ?>
                            <a class="btn btn-ssc btn-sm condicion_concluido" href="<?= base_url?>Juridico/AnexoE?id_puesta=<?= $data['Id_Puesta']?>">Agregar</a>
                        <?php } ?>
                    </div>
                </div>

                <div id="anexoE" class="collapse" aria-labelledby="headingOne" data-parent="#accordionAnexos">
                    <div class="card-body">
                        <?= $data['collapse_anexoE'];?>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between" id="headingOne">
                    <button class="btn btn-block text-left collapsed text-primary" type="button" data-toggle="collapse" data-target="#anexoF" aria-expanded="false" aria-controls="anexoF">
                        <!-- Anexo F  -->
                        ENTREGA RECEP.
                    </button>
                    <div class="d-flex align-items-center">
                        <?php if($data['button'] && $data['data_puesta']['puesta']->Estatus  != '1'){ ?>
                            <a class="btn btn-ssc btn-sm condicion_concluido <?= $data['hide_anexoF']?>" href="<?= base_url?>Juridico/AnexoF/<?= $data['Id_Puesta']?>">Agregar</a>
                        <?php } ?>                            
                    </div>
                </div>

                <div id="anexoF" class="collapse" aria-labelledby="headingOne" data-parent="#accordionAnexos">
                    <div class="card-body">
                        <?= $data['collapse_anexoF'];?>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between" id="headingOne">
                    <button class="btn btn-block text-left collapsed text-primary" type="button" data-toggle="collapse" data-target="#documentacionComplementaria" aria-expanded="false" aria-controls="documentacionComplementaria">
                        Documentación complementaría
                    </button>
                    <div class="d-flex align-items-center">
                        <?php if($data['button'] && $data['data_puesta']['puesta']->Estatus  != '1'){ ?>
                            <button type="button" class="btn btn-ssc btn-sm condicion_concluido" data-toggle="modal" data-target="#dropzoneDocCom">
                                Agregar
                            </button>
                        <?php } ?>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <a class="btn btn-ssc btn-sm btn-block" target="_blank" href="<?php echo base_url.'Juridico/generateIPH/'.$data['Id_Puesta'] ?>">Generar PDF</a>
                    </div>
                </div>
                <!-- <div class="card">
                    <div class="card-header" id="headingOne">
                        <a class="btn btn-ssc btn-sm btn-block" target="_blank" href="https://pdf2docx.com/es/">Generar Word</a>
                    </div>
                </div> -->
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <button type="button" class="btn btn-block btn-ssc btn-sm condicion_concluido" data-toggle="modal" data-target="#dropzoneFiles">
                            Comparar archivos (Word)
                        </button>
                    </div>
                </div>
            </div>
            <?php if($data['button'] && $data['data_puesta']['puesta']->Estatus  != '1'){ ?>
                <div class="card condicion_concluido">
                    <div class="card-header" id="headingOne">
                        <button class="btn btn-ssc btn-sm btn-block" id="btn_concluir">Concluir</button>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="mainContent">
    <div class="col-lg-10 offset-lg-1">
        <div class="d-flex bd-highlight mt-5">
            <div class="flex-shrink-1 bd-highlight">
                <a href="<?php echo base_url ?>Juridico" class="btn btn-sm back-btn mb-3 d-flex justify-content-start">
                    <i class="material-icons">arrow_back</i>
                </a>
            </div>
            <div class="w-100 bd-highlight">
                <p class="form_title mb-0 text-center col-12">INFORME POLICIAL HOMOLOGADO (IPH)</p>
                <p class="form_title text-center col-12">Hecho Probablemente Delictivo</p>
            </div>
            <div class="flex-shrink-1 bd-highlight">
                <?php if($data['button'] && $data['data_puesta']['puesta']->Estatus  != '1'){ ?>
                    <button class="btn btn-ssc condicion_concluido" id="setStateBtn">Editar Registro</button>
                <?php }?>
            </div>
        </div>
        <form id="iph" onsubmit="event.preventDefault();">
            <input type="hidden" id="id_puesta" name="id_puesta" value="<?php echo $data['Id_Puesta']; ?>">
            <div id="message_error_iph">
                <?php if($data['button'] && $data['data_puesta']['puesta']->Estatus  == '1'){ ?>
                    <div class="alert alert-info text-center" role="alert">
                        La puesta ha sido concluida, las funciones de editar han sido deshabilitadas.
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-12 mt-5">
                <p class="form_title text-center mb-3">Sección 1. puesta a disposición</p>
            </div>
            <div class="mt-2">
                <h6 class="text-center text-divider">Fecha y hora de la puesta a disposición</h6>
                <div class="row my-3">
                    <div class="form-group col-lg-4">
                        <label for="fecha_puesta" class="label-form">Fecha:</label>
                        <input type="date" class="form-control form-control-sm" id="fecha_puesta" name="fecha_puesta" value="<?php echo date('Y-m-d') ?>">
                        <span class="span_error" id="fecha_puesta_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="hora_puesta" class="label-form">Hora:</label>
                        <input type="time" class="form-control form-control-sm" id="hora_puesta" name="hora_puesta" value="">
                        <span class="span_error" id="hora_puesta_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="num_expendiente_puesta" class="label-form">Número de expediente:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="num_expendiente_puesta" name="num_expendiente_puesta">
                        <span class="span_error" id="num_expendiente_puesta_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="num_referencia_puesta" class="label-form">Número de Referencia:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="num_referencia_puesta" name="num_referencia_puesta" value="21PM03115">
                        <span class="span_error" id="num_referencia_puesta_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="folio_iph" class="label-form">Folio IPH:</label>
                        <div class="d-flex align-item-center">
                            <input type="number" class="form-control form-control-sm text-uppercase" id="num_folio_iph" name="num_folio_iph" placeholder="Núm">
                            <span class="span_error" id="num_folio_iph_error"></span>
                            <h4 class="mb-0"> / </h4>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="ano_folio_iph" name="ano_folio_iph" value="<?php echo date('Y') ?>" 
                            readonly>
                            <span class="span_error" id="ano_folio_iph_error"></span>
                            <h4 class="mb-0"> / </h4>
                            <input type="number" class="form-control form-control-sm text-uppercase" id="turno_folio_iph" name="turno_folio_iph" placeholder="Turno">
                            <span class="span_error" id="turno_folio_iph_error"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <h6 class="text-center text-divider">Datos de quien realiza la puesta a disposición</h6>
                <div class="row my-3">
                    <div class="form-group col-lg-4">
                        <label for="nombre_realiza_puesta" class="label-form">Nombre(s):</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="nombre_realiza_puesta" name="nombre_realiza_puesta" value="<?php echo $data['data_puesta']['primerRespondiente']->Nombre_PR?>" readonly>
                        <span class="span_error" id="nombre_realiza_puesta_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="apellido_p_realiza_puesta" class="label-form">Apellido Paterno:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="apellido_p_realiza_puesta" name="apellido_p_realiza_puesta" value="<?php echo $data['data_puesta']['primerRespondiente']->Ap_Paterno_PR?>" readonly>
                        <span class="span_error" id="apellido_p_realiza_puesta_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="apellido_m_realiza_puesta" class="label-form">Apellido Materno:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="apellido_m_realiza_puesta" name="apellido_m_realiza_puesta" value="<?php echo $data['data_puesta']['primerRespondiente']->Ap_Materno_PR?>" readonly>
                        <span class="span_error" id="apellido_m_realiza_puesta_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="adscripcion_realiza_puesta" class="label-form">Adscripción:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="adscripcion_realiza_puesta" name="adscripcion_realiza_puesta" value="<?php echo $data['data_puesta']['primerRespondiente']->Adscripcion_Realiza_Puesta?>">
                        <span class="span_error" id="adscripcion_realiza_puesta_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="cargo_realiza_puesta" class="label-form">Cargo/Grado:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="cargo_realiza_puesta" name="cargo_realiza_puesta" value="<?php echo $data['data_puesta']['primerRespondiente']->Cargo?>" readonly>
                        <span class="span_error" id="cargo_realiza_puesta_error"></span>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <h6 class="text-center text-divider">Fiscal/Autoridad que recibe la puesta a disposición</h6>
                <div class="row my-3">
                    <div class="form-group col-lg-4">
                        <label for="nombre_autoridad" class="label-form">Nombre(s):</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="nombre_autoridad" name="nombre_autoridad">
                        <span class="span_error" id="nombre_autoridad_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="apellido_p_autoridad" class="label-form">Apellido Paterno:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="apellido_p_autoridad" name="apellido_p_autoridad">
                        <span class="span_error" id="apellido_p_autoridad_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="apellido_m_autoridad" class="label-form">Apellido Materno:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="apellido_m_autoridad" name="apellido_m_autoridad">
                        <span class="span_error" id="apellido_m_autoridad_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="fiscalia_autoridad" class="label-form">Fiscalía/Autoridad:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="fiscalia_autoridad" name="fiscalia_autoridad">
                        <span class="span_error" id="fiscalia_autoridad_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="adscripcion_autoridad" class="label-form">Adscripción:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="adscripcion_autoridad" name="adscripcion_autoridad">
                        <span class="span_error" id="adscripcion_autoridad_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="cargo_autoridad" class="label-form">Cargo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="cargo_autoridad" name="cargo_autoridad">
                        <span class="span_error" id="cargo_autoridad_error"></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mt-5">
                <p class="form_title text-center mb-3">Sección 2. primer respondiente</p>
            </div>
            <div class="mt-2">
                <h6 class="text-center text-divider">Datos de identificación</h6>
                <div class="row my-3">
                    <div class="input-group col-lg-6 offset-lg-3 my-2">
                        <input type="text" class="form-control text-uppercase" placeholder="Ingrese el número de control, placa ó apellidos del elemento" id="element_search">
                        <div class="input-group-append">
                            <button class="btn btn-ssc" type="button" id="button_search">Buscar</button>
                        </div>
                    </div>  
                    <div class="col-lg-6 offset-lg-3 mb-3" id="list_elements_search">
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="nombre_identificacion" class="label-form">Nombre(s):</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="nombre_identificacion" name="nombre_identificacion" value="<?php echo $data['data_puesta']['primerRespondiente']->Nombre_PR?>" readonly>
                        <span class="span_error" id="nombre_identificacion_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="apellido_p_identificacion" class="label-form">Apellido Paterno:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="apellido_p_identificacion" name="apellido_p_identificacion" value="<?php echo $data['data_puesta']['primerRespondiente']->Ap_Paterno_PR?>" readonly>
                        <span class="span_error" id="apellido_p_identificacion_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="apellido_m_identificacion" class="label-form">Apellido Materno:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="apellido_m_identificacion" name="apellido_m_identificacion" value="<?php echo $data['data_puesta']['primerRespondiente']->Ap_Materno_PR?>" readonly>
                        <span class="span_error" id="apellido_m_identificacion_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="grado_identificacion" class="label-form">Grado ó Cargo</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="grado_identificacion" name="grado_identificacion" value="<?php echo $data['data_puesta']['primerRespondiente']->Cargo?>">
                        <span class="span_error" id="grado_identificacion_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="unidad_identificacion" class="label-form">¿En qué unidad arribó al lugar de la intervención?</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="unidad_identificacion" name="unidad_identificacion" value="<?php echo $data['data_puesta']['primerRespondiente']->Unidad_Arribo?>">
                        <span class="span_error" id="unidad_identificacion_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="hidden" class="form-control form-control-sm text-uppercase" id="num_control_identificacion" name="num_control_identificacion" value="<?php echo $data['data_puesta']['primerRespondiente']->No_Control?>" readonly>
                    </div>
                    <div class="col-lg-12">
                        <label for="id_descripcion_detenido" class="label-form">Seleccione la institución a la que pertenece, así como la entidad federativa o municipio de adscripción.</label>
                        <div class="col-lg-12 my-2">
                            <div class="d-flex justify-content-between">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="institucion" id="institucion1" value="Guardia Nacional">
                                    <label class="form-check-label" for="institucion1">
                                        Guardia Nacional
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="institucion" id="institucion2" value="Policía Federal Ministerial">
                                    <label class="form-check-label" for="institucion2">
                                        Policía Federal Ministerial
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="institucion" id="institucion3" value="Policía Ministerial">
                                    <label class="form-check-label" for="institucion3">
                                        Policía Ministerial
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="institucion" id="institucion4" value="Policía Mando Único">
                                    <label class="form-check-label" for="institucion4">
                                        Policía Mando Único
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="institucion" id="institucion5" value="Policía Estatal">
                                    <label class="form-check-label" for="institucion5">
                                        Policía Estatal
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="institucion" id="institucion6" value="Policía Municipal">
                                    <label class="form-check-label" for="institucion6">
                                        Policía Municipal
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="institucion" id="institucion7" value="Otro">
                                    <label class="form-check-label" for="institucion7">
                                        Otro
                                    </label>
                                </div>
                                <div class="form-group col-lg-4" id="cual_identificacion_content">
                                    <label for="cual_identificacion" class="label-form">¿Cuál?</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="cual_identificacion" name="cual_identificacion">
                                    <span class="span_error" id="cual_identificacion_error"></span>
                                </div>
                            </div>
                        </div>
                        <span class="span_error" id="institucion_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="id_num_detencion" class="label-form">¿Arribó más de un elemento al lugar de la intervención?</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="elementos" id="elementos1" value="No" checked>
                            <label class="form-check-label" for="elementos1">
                                No
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="elementos" id="elementos2" value="Si">
                            <label class="form-check-label" for="elementos2">
                                Si
                            </label>
                            <div class="form-group col-lg-12" id="cuantos_identificacion_content">
                                <label for="cuantos_identificacion" class="label-form">¿Cuántos?</label>
                                <input type="number" class="form-control form-control-sm text-uppercase" id="cuantos_identificacion" name="cuantos_identificacion">
                                <span class="span_error" id="cuantos_identificacion_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mt-5">
                <p class="form_title text-center mb-3">Sección 3. conocimiento del hecho y seguimiento de la actuación de la autoridad</p>
            </div>
            <div class="mt-2">
                <h6 class="text-center text-divider">Conocimiento del hecho por el primer respondiente</h6>
                <div class="row my-3">
                    <div class="col-lg-12">
                        <label for="id_descripcion_detenido" class="label-form">¿Cómo se enteró del hecho?</label>
                        <div class="col-lg-12 my-2">
                            <div class="d-flex justify-content-between">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hecho" id="hecho1" value="Denuncia">
                                    <label class="form-check-label" for="hecho1">
                                        Denuncia
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hecho" id="hecho2" value="Flagrancia">
                                    <label class="form-check-label" for="hecho2">
                                        Flagrancia
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hecho" id="hecho3" value="Localización">
                                    <label class="form-check-label" for="hecho3">
                                        Localización
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hecho" id="hecho4" value="Mandamiento judicial">
                                    <label class="form-check-label" for="hecho4">
                                        Mandamiento judicial
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hecho" id="hecho5" value="Descubrimiento">
                                    <label class="form-check-label" for="hecho5">
                                        Descubrimiento
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hecho" id="hecho6" value="Aportación">
                                    <label class="form-check-label" for="hecho6">
                                        Aportación
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="hecho" id="hecho7" value="Llamada de emergencia 911">
                                    <label class="form-check-label" for="hecho7">
                                        Llamada de emergencia 911
                                    </label>
                                </div>
                                <div class="form-group col-lg-4" id="cual_emergencia_content">
                                    <label for="cual_emergencia" class="label-form">¿Cuál?</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="cual_emergencia" name="cual_emergencia" placeholder="Sólo en caso de contar con él">
                                    <span class="span_error" id="cual_emergencia_error"></span>
                                </div>
                            </div>
                        </div>
                        <span class="span_error" id="hecho_error"></span>
                    </div>
                </div>
                <h6 class="text-center text-divider">Seguimiento de la actuación de la autoridad</h6>
                <div class="row my-3">
                    <div class="col-12 text-center label-form ml-auto">Conocimiento del hecho:</div>
                    <div class="form-group col-lg-6">
                        <label for="fecha_conocimiento" class="label-form">Fecha:</label>
                        <input type="date" class="form-control form-control-sm" id="fecha_conocimiento" name="fecha_conocimiento" value="<?php echo date('Y-m-d') ?>">
                        <span class="span_error" id="fecha_conocimiento_error"></span>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="hora_conocimiento" class="label-form">Hora:</label>
                        <input type="time" class="form-control form-control-sm" id="hora_conocimiento" name="hora_conocimiento" value="<?php echo date('H:i')?>">
                        <span class="span_error" id="hora_conocimiento_error"></span>
                    </div>
                    <div class="col-12 text-center label-form ml-auto">Arribo al lugar:</div>
                    <div class="form-group col-lg-6">
                        <label for="fecha_arribo" class="label-form">Fecha:</label>
                        <input type="date" class="form-control form-control-sm" id="fecha_arribo" name="fecha_arribo" value="<?php echo date('Y-m-d') ?>">
                        <span class="span_error" id="fecha_arribo_error"></span>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="hora_arribo" class="label-form">Hora:</label>
                        <input type="time" class="form-control form-control-sm" id="hora_arribo" name="hora_arribo" value="<?php echo date('H:i')?>">
                        <span class="span_error" id="hora_arribo_error"></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mt-5">
                <p class="form_title text-center mb-3">Sección 4. lugar de la intervención</p>
            </div>
            <div class="mt-2">
                <h6 class="text-center text-divider">Ubicación geográfica</h6>
                <div class="row my-3">
                    <div class="col-lg-6 mt-5">
                        <p class="form_title">Ubicación: </p>
                        <div class="form-row mt-3">
                            <p class="label-form ml-2"> Buscar por: </p>
                            <div class="form-group col-lg-12">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="porDireccion" data-id="InteligenciaOperativa_1" name="busqueda" class="custom-control-input" value="0">
                                    <label class="custom-control-label label-form" for="porDireccion">Dirección</label>
                                </div>

                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="porCoordenadas" data-id="InteligenciaOperativa_1" name="busqueda" class="custom-control-input" value="1">
                                    <label class="custom-control-label label-form" for="porCoordenadas">Coordenadas</label>
                                </div>
                            </div>

                            <div class="form-group col-lg-12" id="por_direccion">
                                <div class="input-group input-group-sm">
                                    <input type="search" id="dir" class="form-control text-uppercase" placeholder="Ingrese una dirección a buscar" />
                                </div>
                            </div>

                            <div class="form-group col-lg-12" id="por_coordenadas">
                                <div class="input-group input-group-sm">
                                    <input type="text" id="search_cy" class="form-control pr-3 mr-3" placeholder="Coordenada Y" />
                                    <input type="text" id="search_cx" class="form-control pl-3 mr-3" placeholder="Coordenada X" />
                                    <button class="btn btn-ssc btn-sm" id="buscar">Buscar</button>
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="Colonia" class="label-form">Colonia:</label>
                                <input type="text" class="form-control form-control-sm text-uppercase" id="Colonia" name="Colonia">
                                <span class="span_error" id="Colonia_inteligencia_error"></span>

                            </div>

                            <div class="form-group col-lg-6">
                                <label for="Calle" class="label-form">Calle:</label>
                                <input type="text" class="form-control form-control-sm text-uppercase" id="Calle" name="Calle">
                                <span class="span_error" id="Calle_inteligencia_error"></span>
                            </div>

                            <div class="form-group col-lg-3">
                                <label for="noExterior" class="label-form">Núm. de Exterior:</label>
                                <input type="text" class="form-control form-control-sm" id="noExterior" name="noExterior">
                                <span class="span_error" id="noExterior_inteligencia_error"></span>
                            </div>

                            <div class="form-group col-lg-3">
                                <label for="noInterior" class="label-form">Núm. de Interior:</label>
                                <input type="text" class="form-control form-control-sm" id="noInterior" name="noInterior">
                            </div>

                            <div class="form-group col-lg-3">
                                <label for="cordY" class="label-form">Coordenada Y:</label>
                                <input type="text" class="form-control form-control-sm" id="cordY" name="cordY">
                                <span class="span_error" id="cordY_inteligencia_error"></span>
                            </div>

                            <div class="form-group col-lg-3">
                                <label for="cordX" class="label-form">Coordenada X:</label>
                                <input type="text" class="form-control form-control-sm" id="cordX" name="cordX">
                                <span class="span_error" id="cordX_inteligencia_error"></span>
                            </div>

                            <div class="form-group col-lg-4">
                                <label for="CP" class="label-form">Código Postal:</label>
                                <input type="text" class="form-control form-control-sm" id="CP" name="CP">
                                <span class="span_error" id="CP_inteligencia_error"></span>
                            </div>
                            
                            <div class="form-group col-lg-4">
                                <label for="Municipio" class="label-form">Municipio:</label>
                                <input type="text" class="form-control form-control-sm" id="Municipio" name="Municipio">
                                <span class="span_error" id="Municipio_error"></span>
                            </div>

                            <div class="form-group col-lg-4">
                                <label for="Entidad" class="label-form">Entidad Federativa:</label>
                                <input type="text" class="form-control form-control-sm" id="Entidad" name="Entidad">
                                <span class="span_error" id="Entidad_error"></span>
                            </div>

                            <div class="form-group col-lg-12">
                                <label for="Referencias" class="label-form">Referencias:</label>
                                <textarea type="text" class="form-control form-control-sm" id="Referencias" name="Referencias"></textarea>
                                <span class="span_error" id="Referencias_error"></span>
                            </div>
                            <span class="span_error" id="errorMap"></span>
                        </div>
                    </div>

                    <div class="col-lg-6 mt-5">
                        <div id="map1"></div>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <h6 class="text-center text-divider">Croquis del lugar</h6>
                <div class="row my-3">
                    <label class="label-form">Es necesario incluir elementos y referencias que permitan identificar el o los lugares de la intervención, detención y/o hallazgo, como vialidades, árboles, cerros, ríos o edificaciones</label>
                    <div class="col-lg-12">
                        <div class="dropzone d-flex justify-content-center" id="dropzoneCroquis" data-id="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <h6 class="text-center text-divider">Inspección del lugar</h6>
                <div class="row my-3">
                    <div class="form-group col-lg-3">
                        <label for="id_fecha" class="label-form text-center">¿Realizó la inspección del lugar?</label>
                        <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="realizo_inspeccion" id="realizo_inspeccion1" value="No" checked>
                            <label class="form-check-label" for="realizo_inspeccion">
                                No
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="realizo_inspeccion" id="realizo_inspeccion2" value="Si">
                            <label class="form-check-label" for="institucion6">
                                Si
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div id="realizo_inspeccion_content">
                            <div class="row">
                                <div class="form-group col-lg-8">
                                    <label for="id_hora" class="label-form">Al momento de realizar la inspección del lugar, ¿encontró algún objeto relacionado con los hechos?</label>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="encontro_objeto" id="encontro_objeto1" value="No" checked>
                                        <label class="form-check-label" for="encontro_objeto1">
                                            No
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="encontro_objeto" id="encontro_objeto2" value="Si">
                                        <label class="form-check-label" for="encontro_objeto2">
                                            Si
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="id_fecha" class="label-form">¿Preservó el lugar de la intervención?</label>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="preservo_lugar" id="preservo_lugar1" value="No" checked>
                                        <label class="form-check-label" for="preservo_lugar1">
                                            No
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="preservo_lugar" id="preservo_lugar2" value="Si">
                                        <label class="form-check-label" for="preservo_lugar2">
                                            Si
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="id_fecha" class="label-form">¿Llevó a cabo la priorización en el lugar de la intervención?</label>
                        <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="priorizacion_lugar" id="priorizacion_lugar1" value="No" checked>
                            <label class="form-check-label" for="priorizacion_lugar1">
                                No
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="priorizacion_lugar" id="priorizacion_lugar2" value="Si">
                            <label class="form-check-label" for="priorizacion_lugar2">
                                Si
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-8" id="priorizacion_lugar_content">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="id_hora" class="label-form">Tipo de riesgo presentado:</label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="riesgo_presentado" id="riesgo_presentado1" value="Sociales">
                                    <label class="form-check-label" for="riesgo_presentado1">
                                        Sociales
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="riesgo_presentado" id="riesgo_presentado2" value="Naturales">
                                    <label class="form-check-label" for="riesgo_presentado2">
                                        Naturales
                                    </label>
                                </div>
                                <span class="span_error" id="riesgo_presentado_error"></span>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="id_fecha" class="label-form">Especifique:</label>
                                <input type="text" class="form-control form-control-sm text-uppercase" id="especifique_riesgo" name="especifique_riesgo">
                                <span class="span_error" id="especifique_riesgo_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mt-5">
                <p class="form_title text-center mb-3">Sección 5. narrativa de los hechos</p>
            </div>
            <div class="mt-2">
                <h6 class="text-center text-divider">Descripción de los hechos y actuación de la autoridad</h6>
                <div class="row my-3">
                    <label for="id_descripcion_detenido" class="label-form">Relate cronológicamente las acciones realizadas durante su intervención desde el conocimiento del hecho hasta la puesta a disposición. En su caso, explique las circunstancias de modo, tiempo y lugar que motivaron cada uno de los niveles de contacto y la detención. Tome como base las siguientes preguntas: ¿Quién? (personas), ¿Qué? (hechos), ¿Cómo? (circunstancias), ¿Cuándo? (tiempo) y ¿Dónde? (lugar).</label>
                    <textarea class="form-control text-uppercase"  id="narrativa" name="narrativa" rows="25" maxlength="16000000"></textarea>
                    <span class="span_error" id="narrativa_error"></span>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-center col-sm-12 my-5">
                <button class="btn btn-sm btn-ssc" id="btn_puesta">Guardar</button>
            </div>
        </form>
        <!-- Modal -->
        <div class="modal fade" id="dropzoneDocCom" tabindex="-1" aria-labelledby="dropzoneDocComLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-white" id="dropzoneDocComLabel">Documentación complementaria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div id="message_docComp">
                            </div>
                            <p class="text-center mb-3">Seleccione la documentación que se adjunta</p>
                            <form class="row d-flex align-items-center" id="doc_com_form" onsubmit="event.preventDefault();">
                                <div class="col-lg-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Fotografia" name="Fotografia" id="fotografia_check">
                                        <label class="form-check-label" for="fotografia_check">
                                            Fotografía
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Video" name="Video" id="video_check">
                                        <label class="form-check-label" for="video_check">
                                            Video
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Audio" name="Audio" id="audio_check">
                                        <label class="form-check-label" for="audio_check">
                                            Audio
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Certificado" name="Certificado" id="certificado_check">
                                        <label class="form-check-label" for="certificado_check">
                                            Certificados médicos
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Otro" id="otro_check">
                                        <label class="form-check-label" for="otro_check">
                                            Otro
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-lg-3" id="especifique_content">
                                    <label for="otro_especificacion" class="label-form">Especifique:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase" id="otro_especificacion" name="otro_especificacion">
                                    <span class="span_error" id="otro_especificacion_error"></span>
                                </div>

                                <button class="btn btn-primary col-lg-6 offset-lg-3 my-4" id="doc_com_form_button">
                                    Guardar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="dropzoneFiles" tabindex="-1" aria-labelledby="dropzoneFilesLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-white" id="dropzoneFilesLabel">Comparar archivos (Word)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div id="message_file">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="dropzone d-flex justify-content-center" id="dropzone_file1">
                                    </div>  
                                </div>
                                <div class="col-lg-6">
                                    <div class="dropzone d-flex justify-content-center" id="dropzone_file2">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 offset-lg-3 mt-4">
                                <button class="btn btn-ssc btn-sm btn-block" id="btn_compareFile">Comparar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>