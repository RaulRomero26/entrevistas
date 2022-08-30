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
            <h4 class="display-5">Nuevo seguimiento a vehículo</h5>
        </div>
    </div>

    <div class="col-12 my-4" id="msg_seguimientoVehiculo"></div>

    <div class="form-row mt-5">
        <form id="datos_nuevoSV" class="col-12" method="post" enctype="multipart/form-data" accept-charset="utf-8" onsubmit="event.preventDefault();">
            
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="svnofolio911" class="label-form">No. folio 911: </label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svnofolio911" name="svnofolio911">
                        <span class="span_error" id="no_folio911_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="svfolioinfra" class="label-form">Folio infra: </label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svfolioinfra" name="svfolioinfra">
                        <span class="span_error" id="No_folioinfra_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="svcelula" class="label-form">Célula de seguimiento:</label>
                        <!--<input type="text" class="form-control form-control-sm" id="svcelula" name="svcelula" onkeypress="return letrasNumerosyEspacios(event)">-->
                        <select class="custom-select custom-select-sm" id="svcelulas" name="svcelulas">
                                <option selected disabled>SELECCIONE UN NÚMERO</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                        </select>
                        <span class="span_error" id="celula_error"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="svplaca" class="label-form">Placa:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svplaca" name="svplaca">
                        <span class="span_error" id="placa_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="svmarca" class="label-form">Marca:</label>
                        <select class="custom-select custom-select-sm" id="svmarca" name="svmarca">
                            <option value="" selected disabled>SELECCIONE LA MARCA</option>
                            <?php foreach ($data['senasParticulares']['vehiculos'] as $item) : ?>
                                <option value="<?php echo $item->Marca ?>"><?php echo $item->Marca ?></option>
                            <?php endforeach ?>
                        </select>
                        <span class="span_error" id="marca_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="svmodelo" class="label-form">Modelo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svmodelo" name="svmodelo">
                        <span class="span_error" id="modelo_error"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="svcolor" class="label-form">Color:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svcolor" name="svcolor">
                        <span class="span_error" id="color_error"></span>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="svcesp" class="label-form">Características específicas:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svcesp" name="svcesp">
                        <span class="span_error" id="caracteristicas_esp_error"></span>
                    </div>
                </div>

                <div class="row">
                    
                    <div class="form-group col-lg-2" id="btn_img">
                        <label class="label-form center-text">Fotografías:</label>
                        <div class="d-flex justify-content-around">
                            <div class="form-group">
                                <input type="file" name="fileSeguimiento2" accept="image/*" id="fileSeguimiento2" class="inputfile uploadFileSeguimiento2" onchange="uploadFile2(event)" data-toggle="tooltip" data-placement="bottom">
                                <label for="fileSeguimiento2">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cloud-upload" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z" />
                                        <path fill-rule="evenodd" d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3z" />
                                    </svg>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-lg-12">
                        <div id="photos-content-seguimientos2" class="row">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="svdv" class="label-form">Delito involucrado:</label>
                        <select class="custom-select custom-select-sm" id="svdv" name="svdv">
                            <option selected>SELECCIONE</option>
                            <option value="NO APLICA">NO APLICA</option>
                            <option value="ROBO A NEGOCIO">ROBO A NEGOCIO</option>
                            <option value="ROBO CASA HABITACIÓN">ROBO CASA HABITACIÓN</option>
                            <option value="ROBO TRANSEÚNTE">ROBO TRANSEÚNTE</option>
                            <option value="ALTO IMPACTO">ALTO IMPACTO</option>
                            <option value="ROBO DE VEHÍCULO">ROBO DE VEHÍCULO</option>
                            <option value="ROBO A OXXO">ROBO A OXXO</option>
                        </select>
                        <span class="span_error" id="delito_involucrado_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="svpado" class="label-form">Principales áreas de operación:</label>
                        <select class="custom-select custom-select-sm" id="svpado" name="svpado">
                            <option selected>SELECCIONE</option>
                            <option value="NO APLICA">NO APLICA</option>
                            <option value="COLONIA">COLONIA</option>
                            <option value="VECTOR">VECTOR</option>
                            <option value="POLÍGONO">POLÍGONO</option>
                        </select>
                        <span class="span_error" id="pado_error"></span>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="svnumcdi" class="label-form">Número de CDI:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svnumcdi" name="svnumcdi">
                        <span class="span_error" id="no_cdi_error"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="svobrap" class="label-form">¿Obra la Placa/NIV en la CDI?:</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="svobrap" id="svobrap" value="1">
                                <label class="form-check-label" for="svobrap">Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="svobrap" id="svobrap" value="0" checked>
                                <label class="form-check-label" for="svobrap">No</label>
                            </div>
                            <span class="span_error" id="obra_p_error"></span>
                        </div>
                    </div>  
                    <div class="form-group col-lg-4">
                        <label for="spdfcdi" class="label-form">PDF de CDI:</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" onchange="uploadFileCDI(event)" id="svpdfcdi" name="svpdfcdi" accept=".pdf" aria-describedby="pdfdecdi">
                            <label class="custom-file-label" for="spdfcdi">Buscar archivo</label>
                        </div>
                    </div>
                    <div class="form-group col-lg-4">
                            <label for="fileCDIResult" class="label-form"></label>
                            <div class="fileCDIResult col-sm-12 d-flex justify-content-left" id="fileCDIResult"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="svpadr" class="label-form">Principales áreas de resguardo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svpadr" name="svpadr">
                        <span class="span_error" id="padr_error"></span>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="svvinculodel" class="label-form">Probable vinculación, banda o grupo delictivo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="svvinculodel" name="svvinculodel">
                        <span class="span_error" id="banda_delictiva_error"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12">
                        <label for="svmodusoperandi" class="label-form">Modus operandi:</label>
                        <div class="form-group col-lg-12">
                            <textarea class="form-control text-uppercase" id="svmodusoperandi" name="svmodusoperandi" rows="12"></textarea>
                            <span class="span_error" id="modus_operandi_error"></span>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 d-flex justify-content-center col-sm-12">
                    <button type="submit" id="crearSVid" class="btn btn-sm btn-ssc" name="crearSV">Guardar</button>
                </div>
        </form>
    </div>
</div>
<br><br><br>