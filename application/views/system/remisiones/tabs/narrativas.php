<div class="container">
    <form id="data_narrativas" onsubmit="event.preventDefault();">
        <div class="row mt-5">
            <div class="col-12 my-4" id="msg_narrativas"></div>
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
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->editar_Narrativas[3]) { ?>
            <div class="row mt-2">
                <div class="form-group col-sm-12">
                    <p class="form_title">Peticionario: </p>
                    <label class="label-form">Narrativa de los hechos</label>
                    <textarea name="narrativaPeticionario" id="narrativaPeticionario" class="form-control text-uppercase" rows="6"></textarea>
                    <span class="span_error" id="narrativaPeticionario_error"></span>
                </div>
            </div>
            <?php
        }
        else{ ?>
            <div class="row mt-2" style="display: none">
                <div class="form-group col-sm-12">
                    <p class="form_title">Peticionario: </p>
                    <label class="label-form">Narrativa de los hechos</label>
                    <textarea name="narrativaPeticionario" id="narrativaPeticionario" class="form-control text-uppercase" rows="6"></textarea>
                    <span class="span_error" id="narrativaPeticionario_error"></span>
                </div>
            </div>
        <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->editar_Narrativas[2]) { ?>
            <div class="row mt-2">
                <div class="form-group col-sm-12">
                    <p class="form_title">Elementos: </p>
                    <label class="label-form">Narrativa de los hechos</label>
                    <textarea name="narrativaElementos" id="narrativaElementos" class="form-control text-uppercase" rows="6"></textarea>
                    <span class="span_error" id="narrativaElementos_error"></span>
                </div>
            </div>
            <?php
        }
        else{ ?>
            <div class="row mt-2" style="display: none">
                <div class="form-group col-sm-12">
                    <p class="form_title">Elementos: </p>
                    <label class="label-form">Narrativa de los hechos</label>
                    <textarea name="narrativaElementos" id="narrativaElementos" class="form-control text-uppercase" rows="6"></textarea>
                    <span class="span_error" id="narrativaElementos_error"></span>
                </div>
            </div>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->editar_Narrativas[1]) { ?>
            <div class="row mt-2">
                <div class="form-group col-sm-12">
                    <p class="form_title">Detenido: </p>
                    <label class="label-form">Narrativa de los hechos</label>
                    <textarea name="narrativaDetenido" id="narrativaDetenido" class="form-control text-uppercase" rows="6"></textarea>
                    <span class="span_error" id="narrativaDetenido_error"></span>
                </div>
            </div>
            <?php
        }
        else{ ?>
            <div class="row mt-2" style="display: none">
                <div class="form-group col-sm-12">
                    <p class="form_title">Detenido: </p>
                    <label class="label-form">Narrativa de los hechos</label>
                    <textarea name="narrativaDetenido" id="narrativaDetenido" class="form-control text-uppercase" rows="6"></textarea>
                    <span class="span_error" id="narrativaDetenido_error"></span>
                </div>
            </div>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->editar_Narrativas[0]) { ?>
            <div class="row mt-2">
                <p class="form_title col-sm-12">IPH: </p>
                <div class="form-group col-sm-12">
                    <label class="label-form">Extracto del IPH</label>
                    <textarea name="extractoIPH" id="extractoIPH" class="form-control text-uppercase" rows="6"></textarea>
                    <span class="span_error" id="extractoIPH_error"></span>
                </div>
            </div>
            <?php
        }
        else{ ?>
            <div class="row mt-2" style="display: none">
                <p class="form_title col-sm-12">IPH: </p>
                <div class="form-group col-sm-12">
                    <label class="label-form">Extracto del IPH</label>
                    <textarea name="extractoIPH" id="extractoIPH" class="form-control text-uppercase" rows="6"></textarea>
                    <span class="span_error" id="extractoIPH_error"></span>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="row mt-2">
            <p class="form_title col-sm-12">CDI/FOLIO JC: </p>
            <div class="form-group col-sm-12">
                <input type="text" name="cdiFolioJC" class="form-control form-control-sm text-uppercase" id="cdiFolioJC">
                <span class="span_error" id="cdiFolioJC_error"></span>
            </div>
        </div>
        <div class="row mt-2">
            <div class="input-group col-sm-12 mt-4 mb-5">
                <div class="custom-file">
                    <input type="file" name="fileIPHNarrativas" onchange="uploadFileIPH(event)"class="bs-custom-file-input" id="fileIPHNarrativas" accept=".pdf">
                    <label class="custom-file-label" for="fileIPHNarrativas">Buscar archivo</label>
                </div>
            </div>
            <div class="fileIPHResult col-sm-12 d-flex justify-content-center" id="fileIPHResult">
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
            <div class="d-flex justify-content-between col-sm-12" id="id_p">
                <a class="btn btn-sm btn-ssc btn-tab-getIndex" data-id="10" id="btn-tab-getIndex-10" message="msg_narrativas">Validar</a>
                <div>   
                    <a class="btn btn-sm btn-ssc" id="btn_narrativas">Guardar</a>
                    <span class="advise-span text-center ml-2 mt-2 span-message" id="span-message-10">* Lo sentimos, el tab ha sido validado. Su usuario no tiene los permisos necesarios para editar</span>
                </div>
            </div>
        </div>
    </form>
</div>