<div class="container">
    <div class="col-12 my-4" id="msg_elementosParticipantes"></div>
    <div class="row mt-5">
        <?php
            $no_remision    = (isset($_GET['no_remision']))?$_GET['no_remision']:'0';
            $no_ficha       = (isset($_GET['no_ficha']))?$_GET['no_ficha']:'0';      
        ?>

        <input type="hidden" name="no_remision_peticionario" id="no_remision_elementosParticipantes" value=<?=$no_remision?>>
        <input type="hidden" name="no_ficha_peticionario" id="no_ficha_elementosParticipantes" value=<?=$no_ficha?>>

        <span class="span_rem">Núm. Remisión/Oficio: </span>
        <?php if(isset($_GET['no_remision'])){?>
            <span class="span_rem_ans ml-2"><?= $_GET['no_remision'] ?></span>
        <?php } ?>

        <span class="span_rem ml-5">Núm. Ficha: </span>
        <?php if(isset($_GET['no_remision'])){?>
            <span class="span_rem_ans ml-2"><?= $_GET['no_ficha'] ?></span>
        <?php } ?>
    </div>
    <h5 class="text-center mt-5">Elementos participantes</h5>
    <div class="form-row mt-5">
        <table class="table table-responsive" id="elementosParticipantes">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Núm. Control</th>
                    <th scope="col">Primer respondiente</th>
                    <th scope="col">Placa</th>
                    <th scope="col">Unidad</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Grupo</th>
                </tr>
                <tbody>
                </tbody>
            </thead>
        </table>
    </div>

    <div class="form-row mt-5">
        <div class="form-group col-lg-12">
            <span class="label-form">¿Seguimiento por GPS?</span>
            <span class="span_rem_ans" name="seguimientoGPS" id="seguimientoGPS">Sí</span>
        </div>
    </div>

    <div class="form-row mt-5">
        <div class="form-group col-lg-12">
            <span class="label-form">Policía de guardia:</span>
            <span class="span_rem_ans" name="policiaDeGuardia" id="policiaDeGuardia"></span>
        </div>
    </div>

    <div class="form-row mt-5">
        <div class="form-group col-lg-12">
            <span class="label-form">Observaciones:</span>
            <span class="span_rem_ans" name="observacionesElementos" id="observacionesElementos"></span>
        </div>
    </div>

    <div class="row mt-5 mb-5">
        <div class="d-flex justify-content-center col-sm-12">
            <a class="btn btn-sm btn-ssc" href="<?= base_url;?>Remisiones">Volver al inicio</a>
        </div>
    </div>

</div>