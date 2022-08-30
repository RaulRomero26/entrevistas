<div class="container">

    <div class="col-12 my-4" id="msg_detencion"></div>

    <div class="row mt-5">
        <!--<div class="col-lg-12 col-sm-12 d-flex justify-content-start align-items-center">
            <span class="span_rem">Núm. Remisión/Oficio: </span>
            <span class="span_rem_ans ml-2">20133</span>
        </div> -->

        <form id="datos_ubicacionD">


            <div class="col-lg-12 d-flex justify-content-start align-items-center">

                <?php
                $no_remision    = (isset($_GET['no_remision'])) ? $_GET['no_remision'] : '0';
                $no_ficha       = (isset($_GET['no_ficha'])) ? $_GET['no_ficha'] : '0';
                ?>


                <input type="hidden" name="no_remision_detencion" id="no_remision_detencion" value=<?= $no_remision ?>>
                <input type="hidden" name="no_ficha_detencion" id="no_ficha_detencion" value=<?= $no_ficha ?>>

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


    <div class="form-row mt-5">

        <div class="form-group col-lg-6 text-center mt-4">
            <label for="fecha_detencion" class="label-form">Fecha: </label>
            <span class="valor-campo" name="fecha_detencion" id="fecha_detencion"></span>
            <span class="span_error" id="fecha_detencion_error"></span>
        </div>

        <div class="form-group col-lg-6 text-center mt-4">
            <label for="hora" class="label-form">Hora:</label>
            <span class="valor-campo" id="hora_detencion" name="hora_detencion"></span>
            <span class="span_error" id="hora_detencion_error"></span>
        </div>
        <div class="form-group col-lg-6 text-center mt-4">
            <label for="Colonia_1" class="label-form">Colonia:</label>
            <span class="valor-campo" id="Colonia_detencion" name="Colonia_detencion"></span>
            <span class="span_error" id="Colonia_detencion_error"></span>
        </div>

        <div class="form-group col-lg-6 text-center mt-4">
            <label for="Fraccionamiento_1" class="label-form">Fraccionamiento:</label>
            <span class="valor-campo" id="Fraccionamiento_detencion" name="Fraccionamiento_detencion"></span>
            <span class="span_error" id="Fraccionamiento_detencion_error"></span>
        </div>

        <div class="form-group col-lg-6 text-center mt-4">
            <label for="Calle_1" class="label-form">Calle 1:</label>
            <span class="valor-campo" id="Calle_1_detencion" name="Calle_1_detencion"></span>
            <span class="span_error" id="Calle_1_detencion_error"></span>
        </div>

        <div class="form-group col-lg-6 text-center mt-4">
            <label for="Calle_2" class="label-form">Calle 2:</label>
            <span class="valor-campo" id="Calle_2_detencion" name="Calle_2_detencion"></span>
            <span class="span_error" id="Calle_2_detencion_error"></span>
        </div>

        <div class="form-group col-lg-3 text-center mt-4">
            <label for="noInterior_1" class="label-form">Núm. de Exterior:</label>
            <span class="valor-campo" id="noInterior_detencion" name="noInterior_detencion"></span>
        </div>

        <div class="form-group col-lg-3 text-center mt-4">
            <label for="noExterior2" class="label-form">Núm. de Interior</label>
            <span class="valor-campo" id="noExterior_detencion" name="noExterior_detencion"></span>
        </div>

        <div class="form-group col-lg-3 text-center mt-4">
            <label for="cordY_1" class="label-form">Coordenada Y:</label>
            <span class="valor-campo" id="cordY_detencion" readonly name="cordY_detencion"></span>
            <span class="span_error" id="cordY_detencion_error"></span>
        </div>

        <div class="form-group col-lg-3 text-center mt-4">
            <label for="cordX_1" class="label-form">Coordenada X:</label>
            <span class="valor-campo" id="cordX_detencion" readonly name="cordX_detencion"></span>
            <span class="span_error" id="cordX_detencion_error"></span>
        </div>

        <div class="form-group col-lg-12 text-center mt-4">
            <label for="CP_detencion" class="label-form">Código Postal:</label>
            <span class="valor-campo" id="CP_detencion" name="CP_detencion"></span>
            <span class="span_error" id="CP_detencion_error"></span>
        </div>


    </div>

    <div class="mt-5">
        <div class="row">
            <div class="form-group col-lg-4 text-center mt-4">
                <label for="tipoViolencia" class="label-form">Tipo de violencia:</label>
                <span class="valor-campo" id="tipoViolencia" name="tipoViolencia"></span>
            </div>

            <div class="form-group col-lg-4 text-center mt-4">
                <label for="formaDetencion" class="label-form">Modalidad de la detención:</label>
                <span class="valor-campo" id="formaDetencion" name="formaDetencion"></span>
            </div>

            <div class="form-group col-lg-4 text-center mt-4">
                <label for="formaDetencionSelect" class="label-form" id="formaDetencionLabel">Operativos</label>
                <span class="valor-campo" id="formaDetencionSelect" name="formaDetencionSelect"></span>
            </div>

            <div class="form-group col-lg-12 text-center mt-4">
                <label for="observaciondesDetencion" class="label-form">Observaciones</label>
                <span class="valor-campo" id="observaciones_detencion" name="observaciones_detencion"></span>
                <span class="span_error" id="observaciones_detencion_error"></span>
            </div>
        </div>
    </div>
<!-- Se comentan estas lineas ya que los vehiculos recuperados no deben mostrarse en la ubicacion
del detenido, sino en objetos recuperados
    <div class="mt-5">
        <p class="form_title ml-3">Vehículo: </p>

        <div class="row">
            <div class="form-group col-lg-12 text-center mt-4">
                <label for="observaciondesDetencion" class="label-form">Tipo de situación</label>
                <span class="valor-campo" id="Tipo_Situacion" name="Tipo_Situacion"></span>
                <span class="span_error" id="Tipo_Situacion_error"></span>
            </div>

            <div class="form-group col-lg-3 text-center mt-4">
                <label for="Tipo_Vehiculo" class="label-form">Tipo de vehículo:</label>
                <span class="valor-campo" id="Tipo_Vehiculo" name="Tipo_Vehiculo"></span>
                <span class="span_error" id="Tipo_Vehiculo_error"></span>
            </div>

            <div class="form-group col-lg-3 text-center mt-4">
                <label for="Placa_Vehiculo" class="label-form">Placa del vehículo:</label>
                <span class="valor-campo" id="Placa_Vehiculo" name="Placa_Vehiculo"></span>
                <span class="span_error" id="Placa_Vehiculo_error"></span>
            </div>

            <div class="form-group col-lg-3 text-center mt-4">
                <label for="Marca" class="label-form">Marca:</label>
                <span class="valor-campo" id="Marca" name="Marca"></span>
                <span class="span_error" id="Marca_error"></span>
            </div>

            <div class="form-group col-lg-3 text-center mt-4">
                <label for="Modelo" class="label-form">Modelo:</label>
                <span class="valor-campo" id="Modelo" name="Modelo"></span>
                <span class="span_error" id="Modelo_error"></span>
            </div>

            <div class="form-group col-lg-3 text-center mt-4">
                <label for="Color" class="label-form">Color:</label>
                <span class="valor-campo" id="Color" name="Color"></span>
                <span class="span_error" id="Color_error"></span>
            </div>

            <div class="form-group col-lg-3 text-center mt-4">
                <label for="Senia_Particular" class="label-form">Seña particular:</label>
                <span class="valor-campo" id="Senia_Particular" name="Senia_Particular"></span>
                <span class="span_error" id="Senia_Particular_error"></span>
            </div>

            <div class="form-group col-lg-3 text-center mt-4">
                <label for="No_Serie" class="label-form">Núm. de serie:</label>
                <span class="valor-campo" id="No_Serie" name="No_Serie"></span>
                <span class="span_error" id="No_Serie_error"></span>
            </div>

            <div class="form-group col-lg-3 text-center mt-4">
                <label for="Procedencia_Vehiculo" class="label-form">Procedencia del vehículo::</label>
                <span class="valor-campo" id="Procedencia_Vehiculo" name="Procedencia_Vehiculo"></span>
                <span class="span_error" id="Procedencia_Vehiculo_error"></span>
            </div>

            <div class="form-group col-lg-12 text-center mt-4">
                <label for="Observacion_Vehiculo" class="label-form">Observaciones:</label>
                <span class="valor-campo" id="Observacion_Vehiculo" name="Observacion_Vehiculo"></span>
                <span class="span_error" id="Observacion_Vehiculo_error"></span>
            </div>
        </div>
    </div>
    <!--<div class="row mt-5 mb-5">
        <div class="col-12 d-flex justify-content-end col-sm-12">
            <btn class="btn btn-sm btn-ssc" onclick="ValidarUbicacionD()" id="btn_ubicacionD">Guardar</btn>
        </div>
    </div> -->


    <div class="row mt-5 mb-5">
        <div class="col-12 d-flex justify-content-center col-sm-12">
            <a class="btn btn-sm btn-ssc" href="<?= base_url; ?>Remisiones">Volver al inicio</a>
        </div>
    </div>
    </form>
</div>