<div class="container">


    <form id="datos_ubicacionH">

        <div class="row mt-5">

            <div class="col-12 my-4" id="msg_ubicacionHechos"></div>
            <div class="col-lg-4 d-flex justify-content-start align-items-center">

                <?php
                $no_remision    = (isset($_GET['no_remision'])) ? $_GET['no_remision'] : '0';
                $no_ficha       = (isset($_GET['no_ficha'])) ? $_GET['no_ficha'] : '0';
                ?>


                <input type="hidden" name="no_remision_ubicacionHechos" id="no_remision_ubicacionHechos" value=<?= $no_remision ?>>
                <input type="hidden" name="no_ficha_ubicacionHechos" id="no_ficha_ubicacionHechos" value=<?= $no_ficha ?>>


                <span class="span_rem">Núm. Remisión/Oficio: </span>
                <?php if (isset($_GET['no_remision'])) { ?>
                    <span class="span_rem_ans ml-2"><?= $_GET['no_remision'] ?></span>
                <?php } ?>

                <span class="span_rem ml-5">Núm. Ficha: </span>
                <?php if (isset($_GET['no_remision'])) { ?>
                    <span class="span_rem_ans ml-2"><?= $_GET['no_ficha'] ?></span>
                <?php } ?>
            </div>
        </div>


        

            <div class="form-row mt-2">
                <div class="col-12 text-center">
                    <p class="form_title">Ubicación: </p>
                </div>
                <div class="form-group col-lg-6 text-center mt-4">
                    <label for="Colonia" class="label-form">Colonia:</label>
                    <span class="valor-campo" id="Colonia_hechos" name="Colonia_hechos"></span>
                    <span class="span_error" id="Colonia_hechos_error"></span>
                </div>

                <div class="form-group col-lg-6 text-center mt-4">
                    <label for="Fraccionamiento" class="label-form">Fracccionamiento:</label>
                    <span class="valor-campo" id="Fraccionamiento_hechos" name="Fraccionamiento_hechos"></span>
                    <span class="span_error" id="Fraccionamiento_hechos_error"></span>
                </div>

                <div class="form-group col-lg-6 text-center mt-4">
                    <label for="Calle" class="label-form">Calle 1:</label>
                    <span class="valor-campo" id="Calle_hechos" name="Calle_hechos"></span>
                    <span class="span_error" id="Calle_hechos_error"></span>
                </div>

                <div class="form-group col-lg-6 text-center mt-4">
                    <label for="Calle" class="label-form">Calle 2:</label>
                    <span class="valor-campo" id="Calle2_hechos" name="Calle2_hechos"></span>
                    <span class="span_error" id="Calle2_hechos_error"></span>
                </div>

                <div class="form-group col-lg-3 text-center mt-4">
                    <label for="noInterior" class="label-form">Núm. de Interior:</label>
                    <span class="valor-campo" id="noInterior_hechos" name="noInterior_hechos"></span>
                </div>

                <div class="form-group col-lg-3 text-center mt-4">
                    <label for="noExterior" class="label-form">Núm. de Exterior:</label>
                    <span class="valor-campo" id="noExterior_hechos" name="noExterior_hechos"></span>
                </div>

                <div class="form-group col-lg-3 text-center mt-4">
                    <label for="cordY" class="label-form">Coordenada Y:</label>
                    <span class="valor-campo" id="cordY_hechos" name="cordY_hechos" readonly></span>
                    <span class="span_error" id="cordY_hechos_error"></span>
                </div>

                <div class="form-group col-lg-3 text-center mt-4">
                    <label for="cordX" class="label-form">Coordenada X:</label>
                    <span class="valor-campo" id="cordX_hechos" name="cordX_hechos" readonly></span>
                    <span class="span_error" id="cordX_hechos_error"></span>
                </div>

                <div class="form-group col-lg-4 text-center mt-4"> <!-- Se añade el elemento html para poder mostrar la informacion del vector lineas 86 a 90-->
                    <label for="Vector" class="label-form">Vector:</label>
                    <span class="valor-campo" id="Vector" name="Vector" readonly></span>
                    <span class="span_error" id="Vector_error"></span>
                </div>

                <div class="form-group col-lg-4 text-center mt-4">
                    <label for="CP_hechos" class="label-form">Código Postal:</label>
                    <span class="valor-campo" id="CP_hechos" name="CP_hechos"></span>
                    <span class="span_error" id="CP_hechos_error"></span>
                </div>

                <div class="form-group col-lg-4 text-center mt-4">
                    <label for="hora" class="label-form">Hora:</label>
                    <span class="valor-campo" id="hora_hechos" name="hora_hechos"></span>
                    <span class="span_error" id="hora_hechos_error"></span>
                </div>

                <div class="form-group col-lg-12 text-center mt-4">
                    <label for="participantes_hechos" class="label-form">Núm. de participantes:</label>
                    <span class="valor-campo" id="participantes_hechos" name="participantes_hechos" onkeypress="return valideKey(event);"></span>
                    <span class="span_error" id="participantes_hechos_error"></span>
                </div>


                <!--
                        <div class="form-group col-lg-6">
                            <label for="Estado" class="label-form">Estado:</label>
                            <input type="text" class="form-control form-control-sm" id="Estado_hechos" name="Estado_hechos">
                            <span class="span_error" id="Estado_hechos_error"></span>
                        </div> 

                        <div class="form-group col-lg-6">
                            <label for="Municipio" class="label-form">Municipio:</label>
                            <input type="text" class="form-control form-control-sm" id="Municipio_hechos" name="Municipio_hechos">
                            <span class="span_error" id="Municipio_hechos_error"></span>
                        </div> -->
            </div>
        




        <div class="mt-5">
            <div class="col-12 text-center">
                <p class="form_title">Datos del delito: </p>
            </div>
            
            <div class="row">
                <div class="form-group col-lg-12 text-center" id="div_delito_1">
                    <label for="delito_1" class="label-form">Detenido por:</label>
                    <span class="valor-campo" id="delito_1" name="delito_1"></span>
                </div>

                

                <!--<div class="form-group col-lg-6 text-center" id="div_ruta_1">
                    <label for="ruta" class="label-form">Ruta:</label>
                    <span class="valor-campo" id="ruta" name="ruta"></span>
                    <span class="span_error" id="ruta_error"></span>
                </div>

                <div class="form-group col-lg-6 text-center" id="div_unidad_1">
                    <label for="unidad" class="label-form">Unidad:</label>
                    <span class="valor-campo" id="unidad" name="unidad"></span>
                    <span class="span_error" id="unidad_error"></span>
                </div>

                <div class="form-group col-lg-12 text-center" id="div_negocio_1">
                    <label for="negocio" class="label-form">Nombre del comercio afectado:</label>
                    <span class="valor-campo" id="negocio" name="negocio"></span>
                    <span class="span_error" id="negocio_error"></span>
                </div>-->


            </div>

            <div class="mt-5">
                    <div class="table-responsive">
                        <table class="table" id="FaltaDelitoTabla_RO">
                            <thead class="thead-dark text-center">
                                <tr>
                                    <th scope="col">Falta / Delito</th>
                                    <th scope="col">* Nombre del comercio afectado</th>
                                    <th scope="col">* RUTA</th>
                                    <th scope="col">* Unidad</th>
                                </tr>
                                <tbody id='tbodyFaltaDelito'>
                                
                                </tbody>
                            </thead>
                        </table>
                    </div>
                </div>
        </div>

        
            <div class="row mt-5 mb-5">
                <div class="col-12 d-flex justify-content-center col-sm-12">
                    <a class="btn btn-sm btn-ssc" href="<?= base_url;?>Remisiones">Volver al inicio</a>
                </div>
            </div>
        

        <!--<div class="row mt-5 mb-5">
            <div class="col-12 d-flex justify-content-end col-sm-12">
                <btn class="btn btn-sm btn-ssc" onclick="ValidarUbicacionH()" id="btn_ubicacionH">Guardar</btn>
            </div>
        </div>-->
    </form>

</div>