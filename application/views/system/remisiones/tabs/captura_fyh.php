<div class="container">
    <div class="row mt-5">
        <div class="col-12 my-4" id="msg_capturaFyH"></div>
        <?php
        $no_remision    = (isset($_GET['no_remision'])) ? $_GET['no_remision'] : '0';
        $no_ficha       = (isset($_GET['no_ficha'])) ? $_GET['no_ficha'] : '0';
        ?>


        <input type="hidden" name="no_remision_peticionario" id="no_remision_capturaFyH" value=<?= $no_remision ?>>
        <input type="hidden" name="no_ficha_peticionario" id="no_ficha_capturaFyH" value=<?= $no_ficha ?>>

        <span class="span_rem">Núm. Remisión/Oficio: </span>
        <?php if (isset($_GET['no_remision'])) { ?>
            <span class="span_rem_ans ml-2"><?= $_GET['no_remision'] ?></span>
        <?php } ?>

        <span class="span_rem ml-5">Núm. Ficha: </span>
        <?php if (isset($_GET['no_remision'])) { ?>
            <span class="span_rem_ans ml-2"><?= $_GET['no_ficha'] ?></span>
        <?php } ?>
    </div>
    <div id="photos-content">
        <div class="container mt-3">
            <h5>Captura de fotos</h5>
            <div class="row">
                <div class="col-lg-4">
                    <div id="rostro_izquierdo" class="dropzone d-flex justify-content-center">
                    </div>
                    <span id="message_rostro_izquierdo" class="text-center"></span>
                    <input type="hidden" name="input_rostro_izquierdo" id="input_rostro_izquierdo" value="">
                    <div class="mt-2 d-flex justify-content-center">
                        <button class="btn btn-primary" id="btn_rostro_izquierdo">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                            </svg>
                            Rotar
                        </button>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div id="rostro_frente" class="dropzone d-flex justify-content-center">
                    </div>
                    <span id="message_rostro_frente" class="text-center"></span>
                    <input type="hidden" name="input_rostro_frente" id="input_rostro_frente" value="">
                    <div class="mt-2 d-flex justify-content-center">
                        <button class="btn btn-primary" id="btn_rostro_frente">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                            </svg>
                            Rotar
                        </button>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div id="rostro_derecho" class="dropzone d-flex justify-content-center">
                    </div>
                    <span id="message_rostro_derecho" class="text-center"></span>
                    <input type="hidden" name="input_rostro_derecho" id="input_rostro_derecho" value="">
                    <div class="mt-2 d-flex justify-content-center">
                        <button class="btn btn-primary" id="btn_rostro_derecho">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                            </svg>
                            Rotar
                        </button>
                    </div>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-lg-4">
                    <div id="cuerpo_izquierdo" class="dropzone d-flex justify-content-center">
                    </div>
                    <span id="message_cuerpo_izquierdo" class="text-center"></span>
                    <input type="hidden" name="input_cuerpo_izquierdo" id="input_cuerpo_izquierdo" value="">
                    <div class="mt-2 d-flex justify-content-center">
                        <button class="btn btn-primary" id="btn_cuerpo_izquierdo">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                            </svg>
                            Rotar
                        </button>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div id="cuerpo_frente" class="dropzone d-flex justify-content-center">
                    </div>
                    <span id="message_cuerpo_frente" class="text-center"></span>
                    <input type="hidden" name="input_cuerpo_frente" id="input_cuerpo_frente" value="">
                    <div class="mt-2 d-flex justify-content-center">
                        <button class="btn btn-primary" id="btn_cuerpo_frente">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                            </svg>
                            Rotar
                        </button>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div id="cuerpo_derecho" class="dropzone d-flex justify-content-center">
                    </div>
                    <span id="message_cuerpo_derecho" class="text-center"></span>
                    <input type="hidden" name="input_cuerpo_derecho" id="input_cuerpo_derecho" value="">
                    <div class="mt-2 d-flex justify-content-center">
                        <button class="btn btn-primary" id="btn_cuerpo_derecho">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                            </svg>
                            Rotar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 mb-5">
        <div class="d-flex justify-content-between col-sm-12" id="id_p">
            <a class="btn btn-sm btn-ssc btn-tab-getIndex" id="btn-tab-getIndex-5" data-id="5" message="msg_principales">Validar</a>
            <div>
                <span class="advise-span text-center ml-2 mt-2 span-message" id="span-message-5">* Lo sentimos, el tab ha sido validado. Su usuario no tiene los permisos necesarios para editar</span>
            </div>
        </div>
    </div>


    <h5 class="col-lg-12 mb-3">Capturar biométricos</h5>

    <div class="col-12 text-center mt-5 mb-2">
        <div class="text-divider">
            <h5>Escaneo de Huellas Dactilares</h5>
        </div>
    </div>


    <div class="col-lg-4 offset-lg-4 d-flex justify-content-between align-items-center">
        <a class="btn btn-sm btn-ssc btn-block" id="CapturaHuellas" href="<?= base_url . 'Remisiones/ejecutarHuellas/?no_remision=' . $no_remision ?>">Iniciar captura de huellas</a>
        <img src="<?php echo base_url; ?>public/media/icons/refresh.svg" width="32px" height="24px" class="ml-lg-5 zoom" data-toggle="tooltip" data-placement="top" title="Refrescar" id="RefreshImg">
    </div>




    <div class="col-12 mt-5 accordion" id="accordion">
        <div class="card">
            <div class="card-header mybg-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-colllapside" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" id="collapse_one">
                        Mostrar / Ocultar huellas capturadas
                    </button>
                </h5>
            </div>

            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <div class="row" id="MuestraHuellas">
                        <div class="col-sm-3 d-flex justify-content-center mt-3 mt-md-0">
                            <div class="card shadow-sm finger-card d-flex justify-content-center align-items-center">
                                <img src="<?php echo base_url; ?>public/media/icons/noFinger.svg" class="d-block my-width p-1" id="finger_1">
                                <div class="text-muted btn-block text-center">Izquierda - Índice</div>
                            </div>

                        </div>

                        <div class="col-sm-3 d-flex justify-content-center mt-3 mt-md-0">
                            <div class="card shadow-sm finger-card d-flex justify-content-center align-items-center">
                                <img src="<?php echo base_url; ?>public//media/icons/noFinger.svg" class="d-block my-width p-1" id="finger_2">
                                <div class="text-muted btn-block text-center">Izquierda - Medio</div>
                            </div>
                        </div>

                        <div class="col-sm-3 d-flex justify-content-center mt-3 mt-md-0">
                            <div class="card shadow-sm finger-card d-flex justify-content-center align-items-center">
                                <img src="<?php echo base_url; ?>public//media/icons/noFinger.svg" class="d-block my-width p-1" id="finger_3">
                                <div class="text-muted btn-block text-center">Izquierda - Anular</div>
                            </div>

                        </div>

                        <div class="col-sm-3 d-flex justify-content-center mt-3 mt-md-0">
                            <div class="card shadow-sm finger-card d-flex justify-content-center align-items-center">
                                <img src="<?php echo base_url; ?>public//media/icons/noFinger.svg" class="d-block my-width p-1" id="finger_4">
                                <div class="text-muted btn-block text-center">Izquierda - Meñique</div>
                            </div>
                        </div>


                        <!--sdfsdfsdf-->

                        <div class="col-sm-3 d-flex justify-content-center mt-3">
                            <div class="card shadow-sm finger-card d-flex justify-content-center align-items-center">
                                <img src="<?php echo base_url; ?>public//media/icons/noFinger.svg" class="d-block my-width p-1" id="finger_5">

                                <div class="text-muted btn-block text-center">Derecha - Índice</div>
                            </div>
                        </div>

                        <div class="col-sm-3 d-flex justify-content-center mt-3">
                            <div class="card shadow-sm finger-card d-flex justify-content-center align-items-center">
                                <img src="<?php echo base_url; ?>public//media/icons/noFinger.svg" class="d-block my-width p-1" id="finger_6">
                                <div class="text-muted btn-block text-center">Derecha - Medio</div>
                            </div>

                        </div>

                        <div class="col-sm-3 d-flex justify-content-center mt-3">
                            <div class="card shadow-sm finger-card d-flex justify-content-center align-items-center">
                                <img src="<?php echo base_url; ?>public//media/icons/noFinger.svg" class="d-block my-width p-1" id="finger_7">
                                <div class="text-muted btn-block text-center">Derecha - Anular</div>
                            </div>

                        </div>

                        <div class="col-sm-3 d-flex justify-content-center mt-3">
                            <div class="card shadow-sm finger-card d-flex justify-content-center align-items-center">
                                <img src="<?php echo base_url; ?>public//media/icons/noFinger.svg" class="d-block my-width p-1" id="finger_8">
                                <div class="text-muted btn-block text-center">Derecha - Meñique</div>
                            </div>
                        </div>

                        <!---fsddsfsdfd-->
                        <div class="col-sm-3 offset-sm-3 d-flex justify-content-center mt-3">
                            <div class="card shadow-sm finger-card d-flex justify-content-center align-items-center">
                                <img src="<?php echo base_url; ?>public//media/icons/noFinger.svg" class="d-block my-width p-1" id="finger_9">
                                <div class="text-muted btn-block text-center">Izquierda - pulgar</div>
                            </div>

                        </div>

                        <div class="col-sm-3 d-flex justify-content-center mt-3">
                            <div class="card shadow-sm finger-card d-flex justify-content-center align-items-center">
                                <img src="<?php echo base_url; ?>public//media/icons/noFinger.svg" class="d-block my-width p-1" id="finger_10">
                                <div class="text-muted btn-block text-center">Derecha - pulgar</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header mybg-header" id="headingTwo">
                <h5 class="mb-0">
                    <button class="btn btn-colllapside" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" id="collapse_two">
                        Coincidencias
                    </button>
                </h5>
            </div>

            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                    <div id="button_panel">
                        <div class="text-center"> <span class="advise-span text-center">Presiona el botón para buscar.</span> </div>
                        <div class="col-lg-4 offset-lg-4 d-flex justify-content-center align-items-center my-3">
                            <a class="btn btn-sm btn-ssc" id="btn_huellas">Buscar coincidencias</a>
                        </div>
                    </div>


                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" style="color: #A94C67;" role="status" id="loader">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>

                    <div class="mt-3" id="tabla">
                        <div class="table-responsive">
                            <table class="table" id="LastRemision">
                                <thead class="thead-dark text-center">
                                    <tr>
                                        <th scope="col">Núm. Remisión</th>
                                        <th scope="col">Detenido</th>
                                        <th scope="col">Fecha detención</th>
                                        <th scope="col">Score coincidencia</th>
                                        <th scope="col">Foto</th>
                                    </tr>
                                <tbody id='tbody_coincidencias' class="text-center">

                                </tbody>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <div class="row" id="NotFound">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <img src="<?= base_url ?>public/media/icons/error.svg" width="64px">
                        </div>

                        <div class="col-12 d-flex align-items-center justify-content-center mt-4">
                            <p class="my-p">Ningún resultado encontrado</p>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="col-12 text-center mt-5 mb-2">
        <div class="text-divider">
            <h5>Escaneo de Iris</h5>
        </div>
    </div>

    <div class="col-lg-4 offset-lg-4 d-flex justify-content-between align-items-center">
        <a class="btn btn-sm btn-ssc btn-block" id="CapturaIris" href="<?= base_url . 'Remisiones/ejecutarIris/?no_remision=' . $no_remision ?>">Iniciar captura de Iris</a>
        <img src="<?php echo base_url; ?>public/media/icons/refresh.svg" width="32px" height="24px" class="ml-lg-5 zoom" data-toggle="tooltip" data-placement="top" title="Refrescar" id="RefreshImgIris">
    </div>

    <div class="col-12 mt-5 accordion" id="accordion_1">
        <div class="card">
            <div class="card-header mybg-header" id="headingOne_1">
                <h5 class="mb-0">
                    <button class="btn btn-colllapside" data-toggle="collapse" data-target="#collapseOne_1" aria-expanded="true" aria-controls="collapseOne" id="collapse_one_1">
                        Estatus de captura
                    </button>
                </h5>
            </div>

            <div id="collapseOne_1" class="collapse" aria-labelledby="headingOne_1" data-parent="#accordion_1">
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <img src="<?= base_url ?>public/media/icons/eye.png" height="80px" class="mr-2" id="img_1">
                        <img src="<?= base_url ?>public/media/icons/eye.png" height="80px" class="ml-2" id="img_2">
                    </div>

                    <div class="mt-2 text-center">
                        <span class="status_cap" id="status_cap">Status de captura: </span>
                        <span class="status_res" id="status_res">No capturado</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header mybg-header" id="headingTwo_1">
                <h5 class="mb-0">
                    <button class="btn btn-colllapside" data-toggle="collapse" data-target="#collapseTwo_1" aria-expanded="true" aria-controls="collapseTwo" id="collapse_two_1">
                        Coincidencias
                    </button>
                </h5>
            </div>

            <div id="collapseTwo_1" class="collapse" aria-labelledby="headingTwo_1" data-parent="#accordion_1">
                <div class="card-body">
                    <div id="button_panel_iris">
                        <div class="text-center"> <span class="advise-span text-center">Presiona el botón para buscar.</span> </div>
                        <div class="col-lg-4 offset-lg-4 d-flex justify-content-center align-items-center my-3">
                            <a class="btn btn-sm btn-ssc" id="btn_iris">Buscar coincidencias</a>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" style="color: #A94C67;" role="status" id="loader_iris">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>

                    <div class="mt-3" id="tabla_iris">
                        <div class="table-responsive">
                            <table class="table" id="LastRemision_iris">
                                <thead class="thead-dark text-center">
                                    <tr>
                                        <th scope="col">Núm. Remisión</th>
                                        <th scope="col">Detenido</th>
                                        <th scope="col">Fecha detención</th>
                                        <th scope="col">Foto</th>
                                    </tr>
                                <tbody id='tbody_coincidencias_iris' class="text-center">

                                </tbody>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <div class="row" id="NotFound_iris">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <img src="<?= base_url ?>public/media/icons/error.svg" width="64px">
                        </div>

                        <div class="col-12 d-flex align-items-center justify-content-center mt-4">
                            <p class="my-p">Ningún resultado encontrado</p>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 mb-5"></div>




</div>