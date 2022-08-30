<div class="container">
    <div class="col-12 my-4" id="msg_objRecuperados"></div>
    <div class="row mt-5">
        <?php
        $no_remision    = (isset($_GET['no_remision'])) ? $_GET['no_remision'] : '0';
        $no_ficha       = (isset($_GET['no_ficha'])) ? $_GET['no_ficha'] : '0';
        ?>


        <input type="hidden" name="no_remision_peticionario" id="no_remision_objetosRecuperados" value=<?= $no_remision ?>>
        <input type="hidden" name="no_ficha_peticionario" id="no_ficha_objetosRecuperados" value=<?= $no_ficha ?>>

        <span class="span_rem">Núm. Remisión/Oficio: </span>
        <?php if (isset($_GET['no_remision'])) { ?>
            <span class="span_rem_ans ml-2"><?= $_GET['no_remision'] ?></span>
        <?php } ?>

        <span class="span_rem ml-5">Núm. Ficha: </span>
        <?php if (isset($_GET['no_remision'])) { ?>
            <span class="span_rem_ans ml-2"><?= $_GET['no_ficha'] ?></span>
        <?php } ?>
    </div>
    <div class="mt-5">
        <h5 class="text-center mt-5">Armas recuperadas</h5>
        <div class="table-responsive">
            <table class="table mt-3" id="armasRecuperadas">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Tipo</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Descripción</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <h5 class="text-center mt-5">Drogas recuperadas</h5>
        <div class="table-responsive">
            <table class="table mt-3" id="drogasAseguradas">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Tipo</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Unidad</th>
                        <th scope="col">Descripción</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <h5 class="text-center mt-5">Objetos recuperados</h5>
        <div class="table-responsive">
            <table class="table mt-3" id="objetosAsegurados">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Descripción</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Se añade la tabla de vehiculos recuperados para readOnly -->
    <h5 class="text-center mt-5">Vehiculos recuperados</h5>
        <div class="table-responsive">
            <table class="table mt-3" id="vehiculosRecuperados">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Situación</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Placa</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Submarca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Color</th>
                        <th scope="col">Seña</th>
                        <th scope="col">Num.Serie</th>
                        <th scope="col">Procedencia</th>
                        <th scope="col">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
 <!--   </div> -->

    <div class="row mt-5" id="obj-recuperados-image">
        <div class="form-group col-lg-3">
            <img class="img-fluid" src="" id="image-obj-recuperados" alt="">
        </div>
    </div>



    <!-- Se comenta esta parte ya que los vehiculos se manejan ahroa en la nueva tabla <div class="container">
        <div class="container">
        <div class="mt-5">
            <div class="table-responsive">
                <table class="table" id="VehiculosTabla">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th scope="col">Tipo de situación</th>
                            <th scope="col">Tipo de vehículo</th>
                            <th scope="col">Placa</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Año</th>
                            <th scope="col">Color</th>
                            <th scope="col">Seña particular</th>
                            <th scope="col">Núm. de serie</th>
                            <th scope="col">Forma de aseguramiento</th>
                            <th scope="col">Fecha de aseguramiento</th>
                            <th scope="col">Hora de aseguramiento</th>
                            <th scope="col">Hora de arribo a la central</th>
                            <th scope="col">Colonia</th>
                            <th scope="col">Calle 1</th>
                            <th scope="col">Calle 2</th>
                            <th scope="col">Núm. de interior</th>
                            <th scope="col">Núm. de exterior</th>
                            <th scope="col">Coordenada Y</th>
                            <th scope="col">Coordenada X</th>
                            <th scope="col">C.P.</th>
                            <th scope="col">Observaciones</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    <tbody id='tbodyVehiculos'>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div> -->

    <div class="row mt-5 mb-5">
        <div class="d-flex justify-content-center col-sm-12">
            <a class="btn btn-sm btn-ssc" href="<?= base_url; ?>Remisiones">Volver al inicio</a>
        </div>
    </div>
</div>