<div class="container">
    <div class="col-12 my-4" id="msg_narrativas"></div>
    <div class="row mt-5">
        <?php
            $no_remision    = (isset($_GET['no_remision']))?$_GET['no_remision']:'0';
            $no_ficha       = (isset($_GET['no_ficha']))?$_GET['no_ficha']:'0';      
        ?>

        
        <input type="hidden" name="no_remision_peticionario" id="no_remision_narrativas" value=<?=$no_remision?>>
        <input type="hidden" name="no_ficha_peticionario" id="no_ficha_narrativas" value=<?=$no_ficha?>>

        <span class="span_rem">Núm. Remisión/Oficio: </span>
        <?php if(isset($_GET['no_remision'])){?>
            <span class="span_rem_ans ml-2"><?= $_GET['no_remision'] ?></span>
        <?php } ?>

        <span class="span_rem ml-5">Núm. Ficha: </span>
        <?php if(isset($_GET['no_remision'])){?>
            <span class="span_rem_ans ml-2"><?= $_GET['no_ficha'] ?></span>
        <?php } ?>
    </div>
    <?php
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->ver_Narrativas[3]) { ?>
        <div class="row mt-2 mt-5">
            <div class="form-group col-sm-12">
                <p class="form_title">Peticionario </p>
                <label class="label-form">Narrativa de los hechos:</label>
                <span class="span_rem_ans" name="narrativaPeticionario" id="narrativaPeticionario"></span>
            </div>
        </div>
        <?php
        }
        else{ ?>
            <div class="row mt-2 mt-5" style="display: none">
                <div class="form-group col-sm-12">
                    <p class="form_title">Peticionario </p>
                    <label class="label-form">Narrativa de los hechos:</label>
                    <span class="span_rem_ans" name="narrativaPeticionario" id="narrativaPeticionario"></span>
                </div>
            </div>
        <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->ver_Narrativas[2]) { ?>
            <div class="row mt-2">
                <div class="form-group col-sm-12">
                    <p class="form_title">Elementos </p>
                    <label class="label-form">Narrativa de los hechos:</label>
                    <span class="span_rem_ans" name="narrativaElementos" id="narrativaElementos"></span>
                </div>
            </div>
            <?php
        }
        else{ ?>
            <div class="row mt-2" style="display: none">
                <div class="form-group col-sm-12">
                    <p class="form_title">Elementos </p>
                    <label class="label-form">Narrativa de los hechos:</label>
                    <span class="span_rem_ans" name="narrativaElementos" id="narrativaElementos"></span>
                </div>
            </div>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->ver_Narrativas[1]) { ?>
            <div class="row mt-2">
                <div class="form-group col-sm-12">
                    <p class="form_title">Detenido </p>
                    <label class="label-form">Narrativa de los hechos:</label>
                    <span class="span_rem_ans" name="narrativaDetenido" id="narrativaDetenido"></span>
                </div>
            </div>
            <?php
        }
        else{ ?>
             <div class="row mt-2">
                <div class="form-group col-sm-12" style="display: none">
                    <p class="form_title">Detenido </p>
                    <label class="label-form">Narrativa de los hechos:</label>
                    <span class="span_rem_ans" name="narrativaDetenido" id="narrativaDetenido"></span>
                </div>
            </div>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->ver_Narrativas[0]) { ?>
            <div class="row mt-2">
                <p class="form_title col-sm-12">IPH </p>
                <div class="form-group col-sm-12">
                    <label class="label-form">Extracto del IPH:</label>
                    <span class="span_rem_ans" name="extractoIPH" id="extractoIPH"></span>
                </div>
            </div>
            <?php
        } 
        else{ ?>
            <div class="row mt-2" style="display: none">
                <p class="form_title col-sm-12">IPH </p>
                <div class="form-group col-sm-12">
                    <label class="label-form">Extracto del IPH:</label>
                    <span class="span_rem_ans" name="extractoIPH" id="extractoIPH"></span>
                </div>
            </div>
            <?php
        } 
        ?>
    <div class="row mt-2">
        <p class="form_title col-sm-12">CDI/FOLIO JC </p>
        <div class="form-group col-sm-12">
            <label class="label-form">CDI/FOLIO JC:</label>
            <span class="span_rem_ans" name="cdiFolioJC" id="cdiFolioJC"></span>
        </div>
    </div>
    <div class="row mt-2">
        <div class="form-group col-sm-12" id="viewPDFIPH">
        </div>
    </div>
    <!-- <div class="row mt-2">
        <div class="form-group col-sm-12">
            <p class="form_title">Observaciones de narrativas: </p>
            <textarea name="observacionesNarrativas" id="observacionesNarrativas" class="form-control" rows="6"></textarea>
            <span class="span_error" id="observacionesNarrativas_error"></span>
        </div>
    </div> -->
    
    <div class="row mt-5 mb-5">
        <div class="d-flex justify-content-center col-sm-12">
            <a class="btn btn-sm btn-ssc" href="<?= base_url;?>Remisiones">Volver al inicio</a>
        </div>
    </div>
</div>