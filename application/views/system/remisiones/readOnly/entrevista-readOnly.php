<div class="container">
    <div class="col-12 my-4" id="msg_entrevista"></div>
    <div class="row mt-5">
        <?php
            $no_remision    = (isset($_GET['no_remision']))?$_GET['no_remision']:'0';
            $no_ficha       = (isset($_GET['no_ficha']))?$_GET['no_ficha']:'0';      
        ?>

        
        <input type="hidden" name="no_remision_peticionario" id="no_remision_entrevistaDetenido" value=<?=$no_remision?>>
        <input type="hidden" name="no_ficha_peticionario" id="no_ficha_entrevistaDetenido" value=<?=$no_ficha?>>

        <span class="span_rem">Núm. Remisión/Oficio: </span>
        <?php if(isset($_GET['no_remision'])){?>
            <span class="span_rem_ans ml-2"><?= $_GET['no_remision'] ?></span>
        <?php } ?>

        <span class="span_rem ml-5">Núm. Ficha: </span>
        <?php if(isset($_GET['no_remision'])){?>
            <span class="span_rem_ans ml-2"><?= $_GET['no_ficha'] ?></span>
        <?php } ?>
    </div>

    

    <div class="form-row mt-5">
        <div class="form-group col-sm-12">
            <label for="probableVinculacion" class="label-form">Probable vinculación, banda o grupo delictivo:</label>
            <span class="span_rem_ans" name="probableVinculacion" id="probableVinculacion"></span>
        </div>

        <div class="col-sm-12">
            <h5 class="text-center mt-5">Instituciones de seguridad</h5>
            <table class="table table-responsive" id="institucionesSeguridad">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Tipo</th>
                        <th scope="col">Corporación</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="col-sm-12">
            <h5 class="text-center mt-5">Adicciones</h5>
            <table class="table table-responsive" id="adiccones">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Tipo</th>
                        <th scope="col">Tiempo de consumo</th>
                        <th scope="col">Frecuencia</th>
                        <th scope="col">Qué suele robar</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="col-sm-12">
            <h5 class="text-center mt-5">Faltas administrativas</h5>
            <table class="table table-responsive" id="faltasAdministrativas">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Descripción</th>
                        <th scope="col">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="col-sm-12">
            <h5 class="text-center mt-5">Antecedentes penales</h5>
            <table class="table table-responsive" id="antecedentePenales">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Descripción</th>
                        <th scope="col">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="form-group col-sm-6 mt-5">
            <label for="motivoDelinquir" class="label-form">Motivo de delinquir:</label>
            <span class="span_rem_ans" name="motivoDelinquir" id="motivoDelinquir"></span>
        </div>

        <div class="form-group col-sm-6 mt-5">
            <label for="modusOperandi" class="label-form">Modus operandi:</label>
            <span class="span_rem_ans" name="modusOperandi" id="modusOperandi"></span>
        </div>
    </div>
    
    <div class="row mt-5 mb-5">
        <div class="d-flex justify-content-center col-sm-12">
            <a class="btn btn-sm btn-ssc" href="<?= base_url;?>Remisiones">Volver al inicio</a>
        </div>
    </div>

</div> 