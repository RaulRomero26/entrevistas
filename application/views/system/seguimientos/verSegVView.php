<div class="container">
    <div class="row d-flex justify-content-start mt-4">
        <div class="col-auto">
            <a href="<?= base_url?>Seguimientos" class="btn btn-opacity" data-toggle="tooltip" data-placement="left" title="Regresar a seguimientos">
                <i class="material-icons">arrow_back</i>
            </a>
        </div>
    </div>

    <div class="container mt-4 mb-3 ">
        <div class="col-12 text-left">
            <h4 class="display-5">Visualizar seguimiento a vehículo</h5>
        </div>
    </div>

    <div class="col-12 my-4" id="msg_seguimientoVehiculo"></div>
    <input type="hidden" id="id_sv" value="<?php echo $_GET['id_sv']?>">

    <div class="form-row mt-5">
        <form class="col-12" method="post" enctype="multipart/form-data" accept-charset="utf-8" onsubmit="event.preventDefault();">
            
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="svnofolio911" class="label-form">No. folio 911: </label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svnofolio911" name="svnofolio911" readonly>
                        <span class="span_error" id="no_folio911_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="svfolioinfra" class="label-form">Folio infra: </label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svfolioinfra" name="svfolioinfra" readonly>
                        <span class="span_error" id="No_folioinfra_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="svcelula" class="label-form">Célula de seguimiento:</label>
                        <input type="text" class="form-control form-control-sm" id="svcelulas" name="spcelulas" readonly>
                        <span class="span_error" id="celula_error"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="svplaca" class="label-form">Placa:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svplaca" name="svplaca" readonly>
                        <span class="span_error" id="placa_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="svmarca" class="label-form">Marca:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svmarca" name="svmarca" readonly>
                        <span class="span_error" id="marca_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="svmodelo" class="label-form">Modelo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svmodelo" name="svmodelo" readonly>
                        <span class="span_error" id="modelo_error"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="svcolor" class="label-form">Color:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svcolor" name="svcolor" readonly>
                        <span class="span_error" id="color_error"></span>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="svcesp" class="label-form">Características específicas:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svcesp" name="svcesp" readonly>
                        <span class="span_error" id="caracteristicas_esp_error"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-2" id="btn_img">
                        <label class="label-form center-text">Fotografías:</label>
                    </div>
                    <div class="form-group col-lg-12">
                        <div id="photos-content-seguimientos2" class="row">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="svdv" class="label-form">Delito involucrado:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svdv" name="svdv" readonly>
                        <span class="span_error" id="delito_involucrado_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="svpado" class="label-form">Principales áreas de operación:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svpado" name="svpado" readonly>
                        <span class="span_error" id="pado_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="svobrap" class="label-form">¿Obra la Placa/NIV en la CDI?:</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="svobrap" id="svobrap_si" value="1">
                                <label class="form-check-label" for="svobrap">Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="svobrap" id="svobrap_no" value="0" checked>
                                <label class="form-check-label" for="svobrap">No</label>
                            </div>
                            <span class="span_error" id="obra_p_error"></span>
                        </div>
                    </div>  
                </div>

                <div class="row">
                    <div class="form-group col-lg-12">
                        <label for="svnumcdi" class="label-form">Número de CDI:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svnumcdi" name="svnumcdi" readonly>
                        <span class="span_error" id="no_cdi_error"></span>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-lg-12">
                        <label class="label-form">Documento CDI:</label>
                        <div class="form-group col-sm-12" id="viewPDFCDI">
                        </div>
                    </div>
                </div> 

                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="svpadr" class="label-form">Principales áreas de resguardo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svpadr" name="svpadr" readonly>
                        <span class="span_error" id="padr_error"></span>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="svvinculodel" class="label-form">Probable vinculación, banda o grupo delictivo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svvinculodel" name="svvinculodel" readonly>
                        <span class="span_error" id="banda_delictiva_error"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12">
                        <label for="svmodusoperandi" class="label-form">Modus operandi:</label>
                        <div class="form-group col-lg-12">
                            <textarea class="form-control text-uppercase" id="svmodusoperandi" name="svmodusoperandi" rows="12" readonly></textarea>
                            <span class="span_error" id="modus_operandi_error"></span>
                        </div>
                    </div>
                </div>
        </form>
                <div class="col-12 d-flex justify-content-center col-sm-12 mt-5">
                	<a href="<?= base_url?>Seguimientos">
   						<button class="btn btn-sm btn-ssc">Regresar a seguimientos</button>
					</a>
                </div>
    </div>
</div>
<br><br><br>