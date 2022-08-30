<div class="container">
        <div class="paragraph-title d-flex justify-content-between mt-5 mb-4">
        <h5> 
            <a href="<?= base_url;?>Vehiculos">Vehiculos</a>
            <span> /Ver </span>
        </h5>
        </div>
</div>
<div class="container">
    <form id='datos_vervehiculo' onsubmit="event.preventDefault()">
        <?php
        $no_vehiculo    = (isset($_GET['id_vehiculo'])) ? $_GET['id_vehiculo'] : '0';
        ?>
        <input type="hidden" name="no_vehiculo_ver" id="no_vehiculo_ver" value=<?= $no_vehiculo ?>>
        <span class="span_error" id="inputsVehiculosE_error"></span>
        <div class="row d-flex align-items-center justify-content-center" id="Form_vehiculoV" >
                <div class="form-group col-lg-4">
                    <label for="cordX" class="label-form">Tipo de ficha:</label>
                    <span class="valor-campo" id="Tipo_FichaV" name="Tipo_SituacionV"></span>
                </div>
                <div class="form-group col-lg-4">
                    <label for="cordX" class="label-form">Número de ficha:</label>
                    <span class="valor-campo" id="Num_fichaV" name="Tipo_SituacionV"></span>
                </div>
                <div class="form-group col-lg-4">
                    <label for="cordX" class="label-form">ID Vehiculo:</label>
                    <span class="valor-campo" id="id_vehiculoV" name="Tipo_SituacionV"></span>
                </div>
                <div class="form-group col-lg-4">
                    <label for="cordX" class="label-form">Tipo de situación:</label>
                    <span class="valor-campo" id="Tipo_SituacionV" name="Tipo_SituacionV"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="cordX" class="label-form">Fecha de recuperación:</label>
                    <span class="valor-campo" id="fechar_VehiculoV" name="fechar_VehiculoV"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="cordX" class="label-form">Colonia:</label>
                    <span class="valor-campo" id="colonia_VehiculoV" name="colonia_VehiculoV"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="cordX" class="label-form">Zona del evento:</label>
                    <span class="valor-campo" id="zona_VehiculoV" name="zona_VehiculoV"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="cordX" class="label-form">Primer respondiente:</label>
                    <span class="valor-campo" id="primerm_VehiculoV" name="primerm_VehiculoV"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="cordX" class="label-form">Tipo de vehículo:</label>
                    <span class="valor-campo" id="Tipo_VehiculoV" name="Tipo_VehiculoV"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="cordX" class="label-form">Marca:</label>
                    <span class="valor-campo" id="MarcaV" name="MarcaV"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="cordX" class="label-form">Submarca:</label>
                    <span class="valor-campo" id="SubmarcaV" name="SubmarcaV"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="cordX" class="label-form">Modelo:</label>
                    <span class="valor-campo" id="ModeloV" name="ModeloV"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="cordX" class="label-form">Color:</label>
                    <span class="valor-campo" id="ColorV" name="ColorV"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="cordX" class="label-form">CDI:</label>
                    <span class="valor-campo" id="CDI_VehiculoV" name="CDI_VehiculoV"></span>
                </div>
                
                <div class="form-group col-lg-4">
                    <label for="cordX" class="label-form">Número de remisión:</label>
                    <span class="valor-campo" id="remision_VehiculoV" name="remision_VehiculoV"></span>
                </div> 

                <div class="form-group col-lg-4">
                    <label for="cordX" class="label-form">Nombre del Ministerio Público:</label>
                    <span class="valor-campo" id="nombre_mpV" name="nombre_mpV"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="cordX" class="label-form">Apellido paterno del Ministerio Público:</label>
                    <span class="valor-campo" id="apellidop_mpV" name="apellidop_mpV"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="cordX" class="label-form">Apellido materno del Ministerio Público:</label>
                    <span class="valor-campo" id="apellidom_mpV" name="apellidom_mpV"></span>
                </div>

                <div class="form-group col-lg-4">
                    <label for="cordX" class="label-form">Fecha de puesta a disposición:</label>
                    <span class="valor-campo" id="fechad_VehiculoV" name="fechad_VehiculoV"></span>
                </div>
                <div class="form-group col-lg-12">
                    <label for="OBJ_Observacion_Vehiculo" class="label-form">Observaciones del vehículo:</label>
                    <textarea class="form-control text-uppercase text-uppercase" id="Observacion_VehiculoV" name="Observacion_VehiculoV" rows="6" maxlength="450" disabled></textarea>
                    
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="placas_vehiculosV">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Tipo de placa</th>
                                <th scope="col">Placa</th>
                                <th scope="col">Procedencia</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="niv_vehiculosV">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Tipo de NIV</th>
                                <th scope="col">No. Serie</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="form-group col-lg-12">
                    <label for="OBJ_Observacion_Vehiculo" class="label-form">Narrativas del vehículo:</label>
                    <textarea class="form-control text-uppercase text-uppercase" id="Narrativa_VehiculoV" name="Narrativa_VehiculoV" rows="10" maxlength="30000" disabled></textarea>
                    
                </div>
                <label  class="label-form" id="pdf_puesta" style="display:none">PDF  de puesta a disposición:</label>
                <div class="form-group col-md-12" id="viewPDFIPH">
                </div>
                <div id="photos-content">
                    <div class="row">
                        <h5 class="col-lg-12 mb-3 text-center">Fotos del vehiculo</h5>
                        <div class="col-sm-6 text-center">
                            <div class="d-flex justify-content-end mb-1"></div>
                            <div>
                                <img class="img-fluid" src="" alt="" id='parte_frontal'>
                                <h5 class="elementFyH text-center">PARTE <span>FRONTAL</span></h5>
                            </div>
                        </div>
                        <div class="col-sm-6 text-center">
                            <div class="d-flex justify-content-end mb-1"></div>
                            <div>
                                <img class="img-fluid" src="" alt="" id="parte_posterior">
                                <h5 class="elementFyH text-center">PARTE <span>POSTERIOR</span></h5>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-sm-6 text-center">
                            <div class="d-flex justify-content-end mb-1"></div>
                            <div>
                                <img class="img-fluid" src="" alt="" id="costado_conductor">
                                <h5 class="elementFyH text-center">COSTADO <span>CONDUCTOR</span></h5>
                            </div>
                        </div>
                        <div class="col-sm-6 text-center">
                            <div class="d-flex justify-content-end mb-1"></div>
                            <div>
                                <img class="img-fluid" src="" alt="" id="costado_copiloto">
                                <h5 class="elementFyH text-center">COSTADO <span>COPILOTO</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
                    
        </div>
        <button type="button" onclick="window.location.href='<?php echo base_url."/Vehiculos" ?>'" class="btn btn-primary button-movil-plus mb-4" id="btn_vehiculos_ver">Regresar</button>
    </form>

</div>