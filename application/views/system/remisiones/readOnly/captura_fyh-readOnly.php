<div class="container">
    <div class="col-12 my-4" id="msg_capturaFyH"></div>
    <div class="row mt-5">
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



    <div class="form-row mt-5">
        
        <div class="col-lg-12 mt-3">
            <div id="photos-content" class="row">
            </div>
        </div>
    </div>

    <div id="photos-content">
            <div class="row">
                <h5 class="col-lg-12 mb-3 text-center">Fotos detenido</h5>
                <div class="col-sm-4 text-center">
                    <div class="d-flex justify-content-end mb-1"></div>
                    <div>
                        <img class="img-fluid" src="" alt="" id='rostro_izquierdo'>
                        <h5 class="elementFyH text-center">ROSTRO<span>IZQUIERDO</span></h5>
                    </div>
                </div>
                <div class="col-sm-4 text-center">
                    <div class="d-flex justify-content-end mb-1"></div>
                    <div>
                        <img class="img-fluid" src="" alt="" id="rostro_frente">
                        <h5 class="elementFyH text-center">ROSTRO<span>FRENTE</span></h5>
                    </div>
                </div>
                <div class="col-sm-4 text-center">
                    <div class="d-flex justify-content-end mb-1"></div>
                    <div>
                        <img class="img-fluid" src="" alt="" id="rostro_derecho">
                        <h5 class="elementFyH text-center">ROSTRO<span>DERECHO</span></h5>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-sm-4 text-center">
                    <div class="d-flex justify-content-end mb-1"></div>
                    <div>
                        <img class="img-fluid" src="" alt="" id="cuerpo_izquierdo">
                        <h5 class="elementFyH text-center">CUERPO<span>IZQUIERDO</span></h5>
                    </div>
                </div>
                <div class="col-sm-4 text-center">
                    <div class="d-flex justify-content-end mb-1"></div>
                    <div>
                        <img class="img-fluid" src="" alt="" id="cuerpo_frente">
                        <h5 class="elementFyH text-center">CUERPO<span>FRENTE</span></h5>
                    </div>
                </div>
                <div class="col-sm-4 text-center">
                    <div class="d-flex justify-content-end mb-1"></div>
                    <div>
                        <img class="img-fluid" src="" alt="" id="cuerpo_derecho">
                        <h5 class="elementFyH text-center">CUERPO<span>DERECHO</span></h5>
                    </div>
                </div>
            </div>
        </div>



    <!-- ******************************************************************************** -->


    <h5 class="col-lg-12 mb-3 text-center mt-5">Resultados de captura de biométricos</h5>

    <div class="col-12 text-center mt-5 mb-2">
        <div class="text-divider">
            <h5>Escaneo de Huellas Dactilares</h5>
        </div>
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

    <div class="row mt-5 mb-5">
        <div class="d-flex justify-content-center col-sm-12">
            <a class="btn btn-sm btn-ssc" href="<?= base_url; ?>Remisiones">Volver al inicio</a>
        </div>
    </div>
</div>