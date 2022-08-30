    
    <div class="container">
        <div class="row d-flex justify-content-start mt-4">
            <div class="col-auto">
                <a href="<?= base_url?>Seguimientos" class="btn btn-opacity" data-toggle="tooltip" data-placement="left" title="Regresar a seguimientos">
                    <i class="material-icons">arrow_back</i>
                </a>
            </div>
        </div>

        <div class="container mt-4 mb-3 ">
            <div class="row">
                <div class="col-12 text-left">
                    <h4 class="display-5">Visualizar seguimiento a persona</h5>
                </div>
            </div>
        </div>

        <div class="col-12 my-4" id="msg_seguimientoPersona"></div>

        <div class="form-row mt-5">
            
        <form class="col-12" enctype="multipart/form-data" accept-charset="utf-8" onsubmit="event.preventDefault();">
            <div class="col-12 my-4" id="msg_seguimientoPersona"></div>
        	   <input type="hidden" id="id_sp" name="Id_Seguimiento_P" value="<?php echo $_GET['id_sp']?>">
        
            <div class="row">
                <div class="form-group col-lg-4">
                    <label for="spnofolio911" class="label-form">No. Folio 911: </label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="spnofolio911" name="spnofolio911" readonly>
                    <small class="form-text"></small>
                </div>

                <div class="form-group col-lg-4">
                    <label for="spfolioinfra" class="label-form">Folio infra: </label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="spfolioinfra" name="spfolioinfra" readonly>
                </div>

                <div class="form-group col-lg-4">
                    <label for="spcelulas" class="label-form">Célula del seguimiento:</label>
                    
                    <input type="text" class="form-control form-control-sm" id="spcelulas" name="spcelulas" readonly>
                        
                </div>
            </div>

                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="spnombre1" class="label-form">Nombre #1:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="spnombre1" name="spnombre1" readonly>
                        <small class="form-text"></small>            
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="spnombre2" class="label-form">Nombre #2:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="spnombre2" name="spnombre2" readonly>            
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="spnombre3" class="label-form">Nombre #3:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="spnombre3" name="spnombre3" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="spappater" class="label-form">Apellido paterno:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="spappater" name="spappater" readonly>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="spapmater" class="label-form">Apellido materno:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="spapmater" name="spapmater" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="spotrosnomf" class="label-form">Otros nombres (falsos):</label>
                        <div class="form-group col-lg-11">
                            <textarea class="form-control text-uppercase" id="spotrosnomf" name="spotrosnomf" rows="4" readonly></textarea>
                        </div>
                    </div>

            	    <div class="form-group col-lg-6">
                        <label for="spalias" class="label-form">Alias:</label>
                        <div class="form-group col-lg-11">
                            <textarea class="form-control text-uppercase" id="spalias" name="spalias" rows="4" readonly></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="spfechand" class="label-form">Fecha de nacimiento:</label>
                        <input type="date" class="form-control form-control-sm" id="spfechand" name="spfechand" readonly>
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="spedad" class="label-form">Edad: </label>
                        <input type="text" class="form-control form-control-sm" id="spedad" name="spedad" maxlength="2" readonly>
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="splugaro" class="label-form">Lugar de origen: </label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="splugaro" name="splugaro" readonly>            
                    </div>
                </div>

                <div class="row">
                        <div class="form-group col-lg-12 mt-5">
                            <label for="dom" class="label-form">Domicilio</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg">
                            <label for="spdomicilio_calle" class="label-form">Calle: </label>
                            <input type="text" class="form-control form-control-sm" id="spdomicilio_calle" name="spdomicilio_calle" readonly>            
                            <span class="span_error" id="spdomicilio_calle_error"></span>
                        </div>

                        <div class="form-group col-lg">
                            <label for="spdomicilio_numext" class="label-form">Número Exterior: </label>
                            <input type="text" class="form-control form-control-sm" id="spdomicilio_numext" name="spdomicilio_numext" readonly>            
                            <span class="span_error" id="spdomicilio_numext_error"></span>
                        </div>

                        <div class="form-group col-lg">
                            <label for="spdomicilio_numint" class="label-form">Número Interior: </label>
                            <input type="text" class="form-control form-control-sm" id="spdomicilio_numint" name="spdomicilio_numint" readonly>            
                            <span class="span_error" id="spdomicilio_numint_error"></span>
                        </div>

                        <div class="form-group col-lg">
                            <label for="spdomicilio_colonia" class="label-form">Colonia: </label>
                            <input type="text" class="form-control form-control-sm" id="spdomicilio_colonia" name="spdomicilio_colonia" readonly>            
                            <span class="span_error" id="spdomicilio_colonia_error"></span>
                        </div>

                        <div class="form-group col-lg">
                            <label for="spdomicilio_cp" class="label-form">Código Postal: </label>
                            <input type="text" class="form-control form-control-sm" id="spdomicilio_cp" name="spdomicilio_cp" readonly>            
                            <span class="span_error" id="spdomicilio_cp_error"></span>
                        </div>
                    </div>
                    <!--
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label for="spdomicilio_observaciones" class="label-form">Observaciones del Domicilio: </label>
                            <textarea class="form-control" id="spdomicilio_observaciones" name="spdomicilio_observaciones" rows="12"></textarea>         
                        </div>
                        <span class="span_error" id="spobservaciondom_error"></span>
                    </div>
                -->

                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="sptel" class="label-form">Número de Teléfono: </label>
                        <input type="text" class="form-control form-control-sm" id="sptel" name="sptel" readonly>            
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="spocupacion" class="label-form">Ocupación: </label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="spocupacion" name="spocupacion" readonly>           
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="spredsocial" class="label-form">Red social: </label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="spredsocial" name="spredsocial" readonly>            
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="spnombrefamc" class="label-form">Nombre del Familiar/Conocido: </label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="spnombrefamc" name="spnombrefamc" readonly>            
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="spparentezco" class="label-form">Parentesco: </label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="spparentezco" name="spparentezco" readonly>            
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-2" id="btn_img">
                        <label class="label-form center-text">Fotografías:</label>
                    </div>

                    <div class="form-group col-lg-12">
                        <div id="photos-content-seguimientos" class="row">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12">
                        <label for="spvinculodel" class="label-form">Probable vinculación, banda o grupo delictivo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="spvinculodel" name="spvinculodel" readonly>
                    </div>
                </div>

                <br><br>

                <div class="row">
                    <div class="form-group col-lg-12">
                        <label for="spmodusoperandi" class="label-form">Modus operandi:</label>
                        <div class="form-group col-lg-12">
                            <textarea class="form-control text-uppercase" id="spmodusoperandi" name="spmodusoperandi" rows="12" readonly></textarea>
                        </div>
                    </div>
                </div>
<!--
                <div class="form-group col-lg-6">
                    <label for="spcaract" class="label-form">Caracteristicas:</label>
                    <div class="form-group col-lg-12">
                        <textarea class="form-control" id="spcaract" name="spcaract" rows="12" onkeypress="return letrasNumerosyEspacios(event)"></textarea>
                    </div>
                </div>

-->
                <div class="row">
                    <div class="form-group col-lg-12">
                        <label for="spnumcdi" class="label-form">Número de CDI:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="spnumcdi" name="spnumcdi" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12">
                        <label class="label-form">Documento CDI:</label>
                        <div class="form-group col-sm-12" id="viewPDFCDI">
                        </div>
                    </div>
                </div> 


<!--
                <div class="form-group col-lg-12">
                    <label for="spdescdi" class="label-form">Descripción de la CDI:</label>
                    <div class="form-group col-lg-11">
                        <textarea class="form-control" id="spdescdi" name="spdescdi" rows="3" onkeypress="return letrasNumerosyEspacios(event)"></textarea>
                    </div>
                </div>
-->
                <div class="row">
                    <div class="form-group col-lg-3">
                        <label for="spviolencia" class="label-form">Violencia:</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="spviolencia" id="spviolencia_si" value="1" readonly>
                                
                                <label class="form-check-label" for="spvsi">Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="spviolencia" id="spviolencia_no" value="0" readonly>
                                <label class="form-check-label" for="spvno">No</label>
                            </div>
                        </div>
                    </div> 
                     

                    <div class="form-group col-lg-3">
                        <label for="sptipov" class="label-form">Tipo de violencia:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="sptipov" name="sptipov" readonly>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="spdv" class="label-form">Delito vinculado:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="spdv" name="spdv" readonly>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="spespdd" class="label-form">Especificación del delito:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="spespdd" name="spespdd" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="sppado" class="label-form">Principales áreas de operación:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="sppado" name="sppado" readonly>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="sppadr" class="label-form">Principales áreas de resguardo:</label>
                        <input type="text" class="form-control form-control-sm text-uppercase" id="sppadr" name="sppadr" readonly>
                    </div>
                </div>

                <div class="form-row mt-5">
                    <div class="col-12 text-center mt-5 mb-5">
                        <div class="text-divider">
                            <h5>Registro de Vehículos Relacionados</h5>
                        </div>
                    </div>

                    <table class="table" id="seguimientoVehiculosPer">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Marca</th>
                                <th scope="col">Modelo</th>
                                <th scope="col">Color</th>
                                <th scope="col">Placa</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            <tbody class="text-uppercase">
                            </tbody>
                        </thead>
                    </table>
                </div>
<!--
                <div id="guardaDatos">
                    
                </div>
-->
                <div class="form-row mt-5">
                    <div class="col-12 text-center mt-5 mb-5">
                        <div class="text-divider">
                            <h5>Registro de Características</h5>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-lg-12">
                            <div class="form-group col-lg-3">
                                <label for="selectPerfil" class="label-form">Perfil:</label>
                                <select class="custom-select custom-select-sm" id="selectPerfil" onchange="onChangePerfil()">
                                    <option selected>FRONTAL</option>
                                    <option value="POSTERIOR">POSTERIOR</option>
                                </select>
                            </div>
                        </div>
                        <div id="body" class="col-sm-3 col-12 mb-5">
                            <div id="front" class="body-front">
                                <svg id="head" class="head" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.32 27.55">
                                    <path d="M2.52,13l-1-1.22a.68.68,0,0,0-1.15.24,6.67,6.67,0,0,0,0,4.47,11.41,11.41,0,0,0,2.14,3s.57.77,1.17-1.18c0,0-.67,3.66.38,4.61s4.71,4.61,7,4.61,6-3.09,7.18-4.47.41-4.85.41-4.85.21,2.28,1.28,1.33a8.09,8.09,0,0,0,2.4-4.18c.12-1.26-.3-4.69-1.33-3.8-1.21,1-1.17,1.75-1.17,1.75.29-2.14.51-6.49-.66-8.67a8.55,8.55,0,0,0-8-4.66C7.25,0,4.57,1.66,3.36,4.23S2.32,11.25,2.52,13Z" transform="translate(0 0)"/>
                                </svg>
                                <svg id="neck" class="neck" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 45.65 20.98">
                                    <path d="M28,2.17,30,.25a15.32,15.32,0,0,1-.51,5.39c-.81,3.41-3.71,9.85-4.08,11a11.55,11.55,0,0,0-.81,3s-1.3-4.53.18-8.07S28.51,3.25,28,2.17Z"/><path d="M30.49,3.13A26.53,26.53,0,0,1,28.83,10a32.7,32.7,0,0,0-2.18,6.1s2.16,2.08,13.06-1.44c3.38-1.09,4.18-1.32,5.94-1.39a16.66,16.66,0,0,0-6.82-4.67C34.48,7,31.15,5.29,30.49,3.13Z"/><path d="M21.33,5a6.06,6.06,0,0,0,2.84,0S22.84,15.8,23,21h-.48S22.29,12,21.33,5Z"/><path d="M27.49,2.62a5.56,5.56,0,0,1-.56,2.51,50,50,0,0,0-3.07,7.34c-.35,1.59,1.49-7,1.1-7.88Z"/><path d="M17.45,1.91,15.48,0A15.63,15.63,0,0,0,16,5.39c.82,3.41,3.72,9.85,4.08,11a11.53,11.53,0,0,1,.82,3s1.29-4.53-.19-8.07S17,3,17.45,1.91Z"/><path d="M18,2.37a5.64,5.64,0,0,0,.57,2.51,49.05,49.05,0,0,1,3.07,7.34c.34,1.59-1.5-7-1.1-7.89Z"/><path d="M15.16,3.13A26.53,26.53,0,0,0,16.82,10,32.7,32.7,0,0,1,19,16.06s-2.16,2.08-13.06-1.44C2.56,13.53,1.76,13.3,0,13.23A16.66,16.66,0,0,1,6.82,8.56C11.17,7,14.5,5.29,15.16,3.13Z"/>
                                </svg>
                                <svg id="chest-right" class="chest-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21.85 19.84">
                                    <path d="M16.49,0s-6.83,0-10,2.1S.05,7,0,10.55s7.45,9.34,9.71,9.29,9.92-.37,11.28-6.67,1.1-9.65-.73-11.44A5.69,5.69,0,0,0,16.49,0Z" transform="translate(0)"/>
                                </svg>
                                <svg id="chest-left" class="chest-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21.85 19.84">
                                    <path d="M5.36,0s6.84,0,10,2.1S21.8,7,21.85,10.55s-7.45,9.34-9.71,9.29S2.23,19.47.86,13.17-.24,3.52,1.6,1.73A5.66,5.66,0,0,1,5.36,0Z" transform="translate(0 0)"/>
                                </svg>
                                <svg id="shoulder-right" class="shoulder-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.87 20.04">
                                    <path d="M13.71,1.13s-4.82.49-6,0S6.58,0,6.58,0A4.74,4.74,0,0,0,2.43,3.5C1.2,7-.12,11.05,0,14.51A9,9,0,0,0,2,20s1.09.28,3.28-.87,4.82-5,4.82-5-.45-3.37,1.47-5.52A12.38,12.38,0,0,1,15,5.81s1.41-2.12.55-3.82S13.71,1.13,13.71,1.13Z" transform="translate(0 0)"/>
                                </svg>
                                <svg id="shoulder-left" class="shoulder-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.87 20.04">
                                    <path d="M2.15,1.13s4.83.49,6,0S9.29,0,9.29,0a4.74,4.74,0,0,1,4.15,3.5c1.22,3.49,2.55,7.55,2.42,11a9,9,0,0,1-2,5.5s-1.1.28-3.28-.87-4.82-5-4.82-5,.45-3.37-1.48-5.52A12.28,12.28,0,0,0,.83,5.81S-.59,3.69.28,2,2.15,1.13,2.15,1.13Z"/>
                                </svg>
                                <svg id="arm-right" class="arm-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14.71 27.59">
                                    <path d="M14,3.83s-1.36,9.81-2.44,11.88c0,0,3.1-5.21,3.14-6.39A50.45,50.45,0,0,0,14,3.83Z"/><path d="M3.29,5.75a2,2,0,0,1-1.22-.88S-.09,9.27,0,16.65,3.85,27.59,3.85,27.59.47,17.77,1.51,12.09,3.29,5.75,3.29,5.75Z"/><path d="M11.56,0S8.25,5.09,4.44,6C2.9,6.3,1.82,14.23,1.93,16.39S4.37,27.18,4.37,27.18s5.76-5.8,6.59-10.37S13.31,6.37,13.42,4.13A6.21,6.21,0,0,0,11.56,0Z"/>
                                </svg>
                                <svg id="arm-left" class="arm-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14.71 27.59">
                                    <path d="M.71,4s1.36,9.82,2.44,11.88c0,0-3.1-5.21-3.15-6.38A52.45,52.45,0,0,1,.71,4Z" transform="translate(0 -0.21)"/><path d="M11.41,6a2,2,0,0,0,1.23-.88s2.16,4.4,2.06,11.77-3.85,11-3.85,11S14.23,18,13.2,12.3,11.41,6,11.41,6Z" transform="translate(0 -0.21)"/><path d="M3.15.21s3.31,5.09,7.12,6c1.54.35,2.62,8.28,2.51,10.44s-2.45,10.78-2.45,10.78S4.58,21.58,3.74,17,1.4,6.57,1.28,4.34A6.2,6.2,0,0,1,3.15.21Z" transform="translate(0 -0.21)"/>
                                </svg>
                                <svg id="forearm-right" class="forearm-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14.46 35.76">
                                    <path d="M4,0A19.8,19.8,0,0,0,5.2,4.91C6,6.35,9.26,11.57,9.81,13.27a23.69,23.69,0,0,1,.45,9.7c-.61,4.42-2.27,7.8-2.15,9.68A39.43,39.43,0,0,0,4.84,21.2C2.11,15.32.84,9.67,1.42,5.9A11.84,11.84,0,0,1,4,0Z"/><path d="M1,11.74a51.46,51.46,0,0,0,3,9.27C5.84,24.58,7.92,31.61,8,35.76a18.08,18.08,0,0,1-4.88-6.91C1.19,24.23.31,23.39,0,17.89S1,11.74,1,11.74Z"/><path d="M14.45,2.11S10.73,7.82,8.61,9.43L10,12.22s4.11-2.5,4.29-6S14.45,2.11,14.45,2.11Z"/><path d="M13.2,10.1s-1.92,2.56-2.84,2.76a28.06,28.06,0,0,1,.18,11.64s2.92-6.44,3-9.64A25.32,25.32,0,0,0,13.2,10.1Z"/>
                                </svg>
                                <svg id="forearm-left" class="forearm-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14.46 35.76">
                                    <path d="M10.45,0a19.34,19.34,0,0,1-1.2,4.91c-.77,1.44-4.06,6.66-4.6,8.36A23.69,23.69,0,0,0,4.2,23c.61,4.42,2.26,7.8,2.15,9.68A39.59,39.59,0,0,1,9.61,21.2c2.73-5.88,4-11.53,3.42-15.3A11.74,11.74,0,0,0,10.45,0Z"/><path d="M13.42,11.74a51,51,0,0,1-3,9.27c-1.77,3.57-3.84,10.6-3.92,14.75a18.08,18.08,0,0,0,4.88-6.91c1.93-4.62,2.81-5.46,3.08-11S13.42,11.74,13.42,11.74Z"/><path d="M0,2.11S3.73,7.82,5.85,9.43l-1.4,2.79s-4.12-2.5-4.3-6S0,2.11,0,2.11Z"/><path d="M1.26,10.1s1.92,2.56,2.84,2.76A28.06,28.06,0,0,0,3.92,24.5S1,18.06,1,14.86A25.32,25.32,0,0,1,1.26,10.1Z"/>
                                </svg>
                                <svg id="abdomen-right" class="abdomen-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18.49 46">
                                    <path d="M2.79,2.36A9.46,9.46,0,0,1,0,0,48,48,0,0,0,1.62,9.76S1.4,3.58,2.79,2.36Z"/><path d="M6.9,4.21a9.53,9.53,0,0,1-4.58,1,4,4,0,0,1,.87-2.6S5.82,4.17,6.9,4.21Z"/><path d="M3.39,5.55s-.92.25-1.26.07a17.41,17.41,0,0,0-.13,5,9.19,9.19,0,0,0,2.41,4.78s-.75-5.34-.15-6.79l1.39,0A9.29,9.29,0,0,1,3.39,5.55Z"/><path d="M3.52,27.93s-2.13,2.65-2.26,4.91a10.69,10.69,0,0,0,.61,4.09l4.34,3.2S9,39.23,9.58,34.8,3.52,27.93,3.52,27.93Z"/><path d="M6.59,4.79a14.16,14.16,0,0,1-2.74.91A13.87,13.87,0,0,0,8.2,10.24a4.34,4.34,0,0,0,.52-2.72C8.52,5.92,6.59,4.79,6.59,4.79Z"/><path d="M5.91,9l-1.56.08A6.35,6.35,0,0,0,5.45,13c1.38,2.39,2.34,2.79,2.34,2.79s.77-.54.75-3S5.91,9,5.91,9Z"/><path d="M4.6,11.88s1.22,3.47,3.16,4.34c0,0,1.14,2.41,0,3.72s-3.16-4-3.16-4S4.17,12.2,4.6,11.88Z"/><path d="M8.09,20.4s1,2.23.45,3.82S5.86,22.8,5.86,22.8s-2.05-3.32-2.1-5.17a8.26,8.26,0,0,1,.09-2.19l.56.34a24.44,24.44,0,0,0,1.24,3C6.67,20.69,8.09,20.4,8.09,20.4Z"/><path d="M8.27,25.35S9.05,29,7.85,29s-4.1-3.69-4.1-3.69V19.42S5.19,23.05,6.14,24A5.46,5.46,0,0,0,8.27,25.35Z"/><path d="M16.5,2s1.7,0,1.7,1.55a5.57,5.57,0,0,1-1.7,4.17c-1.14,1-4.57,2.88-6.23,2.75s-.44-4.74-.44-4.74S11.6,3,16.5,2Z"/><path d="M18,10.92s.77,4.46-.48,5.61-3.69,1.07-6,2.43-2.5-1.7-1.88-4,3.73-5.12,6.09-5.46S18,10.92,18,10.92Z"/><path d="M18.21,20.62s.61,3.13-1.12,3.87-4.42,1.18-6,1.85-2.4-3.77-.44-5.72,5.23-2.69,6.34-2.14A2.82,2.82,0,0,1,18.21,20.62Z"/><path d="M18.49,28.77S18,42.84,18.05,44.34s-.65,2.31-2.44,1-3.48-2.59-4.7-8.35-1.86-7.42.61-9.37S18.45,24.27,18.49,28.77Z"/>
                                </svg>
                                <svg id="abdomen-left" class="abdomen-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18.49 46">
                                    <path d="M15.7,2.36A9.46,9.46,0,0,0,18.49,0a48.45,48.45,0,0,1-1.61,9.76S17.1,3.58,15.7,2.36Z" transform="translate(0 0)"/><path d="M11.59,4.21a9.53,9.53,0,0,0,4.58,1,3.94,3.94,0,0,0-.87-2.6S12.68,4.17,11.59,4.21Z" transform="translate(0 0)"/><path d="M15.1,5.55a2.64,2.64,0,0,0,1.27.07,17.41,17.41,0,0,1,.13,5,9.24,9.24,0,0,1-2.42,4.78s.75-5.34.15-6.79l-1.39,0A9.15,9.15,0,0,0,15.1,5.55Z" transform="translate(0 0)"/><path d="M15,27.93s2.13,2.65,2.26,4.91a10.47,10.47,0,0,1-.61,4.09l-4.34,3.2s-2.81-.9-3.36-5.33S15,27.93,15,27.93Z" transform="translate(0 0)"/><path d="M11.9,4.79a14.06,14.06,0,0,0,2.75.91,14,14,0,0,1-4.36,4.54,4.41,4.41,0,0,1-.52-2.72C10,5.92,11.9,4.79,11.9,4.79Z" transform="translate(0 0)"/><path d="M12.58,9l1.56.08A6.26,6.26,0,0,1,13,13c-1.38,2.39-2.34,2.79-2.34,2.79s-.77-.54-.75-3S12.58,9,12.58,9Z" transform="translate(0 0)"/><path d="M13.89,11.88s-1.22,3.47-3.16,4.34c0,0-1.14,2.41,0,3.72s3.16-4,3.16-4S14.32,12.2,13.89,11.88Z" transform="translate(0 0)"/><path d="M10.41,20.4s-1,2.23-.46,3.82,2.68-1.42,2.68-1.42,2.06-3.32,2.1-5.17a8.26,8.26,0,0,0-.09-2.19l-.56.34a24.44,24.44,0,0,1-1.24,3C11.82,20.69,10.41,20.4,10.41,20.4Z" transform="translate(0 0)"/><path d="M10.22,25.35S9.44,29,10.64,29s4.1-3.69,4.1-3.69V19.42S13.3,23.05,12.36,24A5.53,5.53,0,0,1,10.22,25.35Z" transform="translate(0 0)"/><path d="M2,2S.3,2.07.3,3.58A5.56,5.56,0,0,0,2,7.75c1.14,1,4.57,2.88,6.23,2.75s.45-4.74.45-4.74S6.9,3,2,2Z" transform="translate(0 0)"/><path d="M.52,10.92s-.78,4.46.48,5.61S4.68,17.6,7,19s2.51-1.7,1.88-4S5.13,9.82,2.77,9.48.52,10.92.52,10.92Z" transform="translate(0 0)"/><path d="M.28,20.62s-.61,3.13,1.12,3.87,4.43,1.18,6,1.85,2.4-3.77.44-5.72-5.23-2.69-6.34-2.14A2.85,2.85,0,0,0,.28,20.62Z" transform="translate(0 0)"/><path d="M0,28.77S.53,42.84.45,44.34s.64,2.31,2.43,1S6.37,42.76,7.58,37,9.45,29.58,7,27.63,0,24.27,0,28.77Z" transform="translate(0 0)"/>
                                </svg>
                                <svg id="leg-right" class="leg-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.76 74.91">
                                    <path d="M11.08,2.07l-.7.84a5.91,5.91,0,0,1,1.83,3.48c.56,2.56,1.26,9.74,2.7,12.81s4.48,7.09,4.69,20.16c0,0,3.31-14.42,3.22-16.47s-.26-3.13-.26-3.13-2.14,1-4.83-4.91S12.64,3.43,11.08,2.07Z" transform="translate(-0.06)"/><path d="M5.72,0S7.48.78,7.44,5.19a38.82,38.82,0,0,1-1.72,9.64s-1.59,2.49-2.78,2.45a15.82,15.82,0,0,1,1.23-5.07,54.85,54.85,0,0,1,.2-6.65A45.2,45.2,0,0,1,5.72,0Z" transform="translate(-0.06)"/><path d="M2.55,18.52s-1,8.26,0,13.18S7.63,45.44,6.76,50.2a6.27,6.27,0,0,1-5,5.32S-.15,41.7.09,31.78,2.55,18.52,2.55,18.52Z" transform="translate(-0.06)"/><path d="M15.17,29.87a10.65,10.65,0,0,1-1.35,4.45C12.63,36.15,7.39,44.4,8.66,50.68s4.93,8.89,9.13,6.91c0,0,1.91-11.36.36-18.59S15.17,29.87,15.17,29.87Z" transform="translate(-0.06)"/><path d="M8.47,2.07s-1.21,4.12.95,11.62,7.45,17,8,19.49,1.79,7.4,1.73,10.87c0,0,.7-8.68-.64-13.8a60.69,60.69,0,0,0-4.65-12.12c-1.52-3-1.3-10.46-2.71-13.34S8.47,2.07,8.47,2.07Z" transform="translate(-0.06)"/><path d="M4.32,17.28s-.94.83-1.38.72c0,0-1.11,8.72,0,13.05s2.94,8.67,3.47,11.56c0,0,1.41-19.14-.37-22.57S4.32,17.28,4.32,17.28Z" transform="translate(-0.06)"/><path d="M9.62,15.76s-2.12,5.08-2.18,8-.56,18.93,1,21c0,0,1.51-6,4-9.63a12.33,12.33,0,0,0,1.93-7.81S10.12,18.93,9.62,15.76Z" transform="translate(-0.06)"/><path d="M17.56,59.43s-1.56,5.8-3.85,8.12A27.71,27.71,0,0,0,9,73.76s-1.16,2.59-3,0S7.33,56.43,7.6,51.11c0,0,2,6.34,4.75,7.55A10,10,0,0,0,17.56,59.43Z" transform="translate(-0.06)"/><path d="M6.88,52.35s-1.56,4-4.9,4.17c0,0,.87,4.35.47,4.94s-.77,6,2.24,9.48A53.81,53.81,0,0,1,5.46,62C6.21,58.49,7,54.5,6.88,52.35Z" transform="translate(-0.06)"/>
                                </svg>
                                <svg id="leg-left" class="leg-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.76 74.91">
                                    <path d="M11.74,2.07l.7.84a5.91,5.91,0,0,0-1.83,3.48C10.05,9,9.35,16.13,7.92,19.2s-4.48,7.09-4.7,20.16c0,0-3.31-14.42-3.22-16.47s.26-3.13.26-3.13,2.15,1,4.83-4.91S10.18,3.43,11.74,2.07Z" transform="translate(0 0)"/><path d="M17.1,0s-1.75.78-1.71,5.19a39,39,0,0,0,1.71,9.64s1.59,2.49,2.78,2.45a15.51,15.51,0,0,0-1.23-5.07,52.76,52.76,0,0,0-.2-6.65A45.2,45.2,0,0,0,17.1,0Z" transform="translate(0 0)"/><path d="M20.28,18.52s1,8.26,0,13.18-5.09,13.74-4.21,18.5a6.25,6.25,0,0,0,5,5.32S23,41.7,22.74,31.78,20.28,18.52,20.28,18.52Z" transform="translate(0 0)"/><path d="M7.65,29.87A10.65,10.65,0,0,0,9,34.32c1.19,1.83,6.43,10.08,5.16,16.36S9.24,59.57,5,57.59c0,0-1.91-11.36-.36-18.59S7.65,29.87,7.65,29.87Z" transform="translate(0 0)"/><path d="M14.36,2.07s1.21,4.12-1,11.62-7.45,17-8,19.49-1.79,7.4-1.72,10.87c0,0-.71-8.68.64-13.8A60.13,60.13,0,0,1,9,18.13c1.52-3,1.3-10.46,2.71-13.34S14.36,2.07,14.36,2.07Z" transform="translate(0 0)"/><path d="M18.5,17.28s.94.83,1.38.72c0,0,1.11,8.72,0,13.05S17,39.72,16.41,42.61c0,0-1.41-19.14.38-22.57S18.5,17.28,18.5,17.28Z" transform="translate(0 0)"/><path d="M13.2,15.76s2.12,5.08,2.19,8,.55,18.93-1,21c0,0-1.52-6-4-9.63a12.4,12.4,0,0,1-1.93-7.81S12.7,18.93,13.2,15.76Z" transform="translate(0 0)"/><path d="M5.26,59.43s1.56,5.8,3.85,8.12a28.21,28.21,0,0,1,4.68,6.21s1.16,2.59,3,0-1.3-17.33-1.57-22.65c0,0-2,6.34-4.75,7.55A10,10,0,0,1,5.26,59.43Z" transform="translate(0 0)"/><path d="M15.94,52.35s1.56,4,4.9,4.17c0,0-.87,4.35-.47,4.94s.77,6-2.24,9.48A53.81,53.81,0,0,0,17.36,62C16.61,58.49,15.82,54.5,15.94,52.35Z" transform="translate(0 0)"/>
                                </svg>
                                <svg id="hand-right" class="hand-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.77 35.97">
                                    <path d="M4.67,28.14s0,.79-.28,1a11.92,11.92,0,0,1,.91,4.66l.63.93s1.76-1.32.32-4.11S4.67,28.14,4.67,28.14Z" transform="translate(0 0)"/><path d="M4.65,25.34l.08,2.39S6.9,30.34,7,32c0,0,1-1.08-.39-3.51A18,18,0,0,0,4.65,25.34Z" transform="translate(0 0)"/><path d="M7.78,11.55s2.74,2.84,2.85,5.8S11.13,25,9.89,25s-2.11-2.63-2.11-2.63.22-2.69-1-3.17-2.58,5-2.58,5S4.51,28,4,28.89c0,0,2.42,5.74,0,7.08L1.34,29.1s-1-4.78-.7-23.94L0,0A83.08,83.08,0,0,0,4.06,7.76,30.41,30.41,0,0,0,7.78,11.55Z" transform="translate(0 0)"/>
                                </svg>
                                <svg id="hand-left" class="hand-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.77 35.97">
                                    <path d="M6.1,28.14s0,.79.28,1a11.92,11.92,0,0,0-.91,4.66l-.63.93s-1.76-1.32-.32-4.11S6.1,28.14,6.1,28.14Z"/><path d="M6.12,25.34,6,27.73S3.87,30.34,3.73,32c0,0-.94-1.08.4-3.51A17.73,17.73,0,0,1,6.12,25.34Z"/><path d="M3,11.55S.25,14.39.15,17.35-.36,25,.89,25,3,22.34,3,22.34s-.21-2.69,1-3.17,2.57,5,2.57,5S6.27,28,6.8,28.89c0,0-2.41,5.74,0,7.08L9.43,29.1s1-4.78.71-23.94L10.77,0A83.08,83.08,0,0,1,6.71,7.76,30.41,30.41,0,0,1,3,11.55Z"/>
                                </svg>
                                <svg id="calf-right" class="calf-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.39 38.21">
                                    <path d="M3,0S4,3.82,5.63,4.74a63.29,63.29,0,0,0,0,11.35c.56,6.35.29,19.33-2.68,20.77,0,0,.51-6.42-1.75-16.54S.05,7.21,3,0Z" transform="translate(0 0)"/><path d="M16.29,1.08s-6.68,7.37-7.24,10-.89,8.34.62,10.2,2,2.2,3,2.41c0,0-.13-.55.63-1.79s4.06-7,4.06-12.27A29,29,0,0,0,16.29,1.08Z" transform="translate(0 0)"/><path d="M8.4,19.23s1.78,4.69,4.08,5.08c0,0-.28,4.8-1.5,4.25S8.14,24.39,8.4,19.23Z" transform="translate(0 0)"/><path d="M8.11,22.6s.62,6.6,3.3,6.43c0,0-.8,3.32-1,4.84a30.84,30.84,0,0,0,0,4.34s-2.12-.94-2.32-5.14S8.11,22.6,8.11,22.6Z" transform="translate(0 0)"/><path d="M9.15,9.71S6.67,9.09,6.23,7.14a33.66,33.66,0,0,0,0,7.78c.53,3.59.13,18.4-.89,20a7.81,7.81,0,0,1-1.5,1.94l4.95.8a7.39,7.39,0,0,1-1.46-3C7.11,33.06,7.51,23,7.51,23L8,18.86S7.82,11.78,9.15,9.71Z" transform="translate(0 0)"/>
                                </svg>
                                <svg id="calf-left" class="calf-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.39 38.21">
                                    <path d="M14.44-.12s-1,3.82-2.68,4.74a63.29,63.29,0,0,1,0,11.35c-.56,6.35-.29,19.33,2.68,20.76,0,0-.51-6.42,1.75-16.53S17.35,7.09,14.44-.12Z" transform="translate(0 0.12)"/><path d="M1.1,1S7.79,8.33,8.34,11s.89,8.33-.62,10.2-2,2.2-3,2.41c0,0,.13-.55-.62-1.79S0,14.81,0,9.5A29.08,29.08,0,0,1,1.1,1Z" transform="translate(0 0.12)"/><path d="M9,19.1s-1.77,4.7-4.08,5.09c0,0,.28,4.8,1.5,4.24S9.25,24.27,9,19.1Z" transform="translate(0 0.12)"/><path d="M9.28,22.48S8.66,29.08,6,28.9c0,0,.8,3.33,1,4.84a32.67,32.67,0,0,1,0,4.35s2.11-1,2.31-5.14S9.28,22.48,9.28,22.48Z" transform="translate(0 0.12)"/><path d="M8.24,9.58S10.72,9,11.16,7a33.66,33.66,0,0,1,0,7.78c-.53,3.58-.13,18.4.89,20a7.84,7.84,0,0,0,1.5,1.94l-5,.81a7.39,7.39,0,0,0,1.46-3.06c.22-1.54-.18-11.58-.18-11.58l-.51-4.16S9.57,11.66,8.24,9.58Z" transform="translate(0 0.12)"/>
                                </svg>
                                <svg id="foot-right" class="foot-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.47 23.62">
                                    <path d="M16.72,1.27,8.7,0s-.28,2-1,2.24S7.51,5.08,7.17,5.6,1.71,14.24,1.26,16.17c0,0-1.26,1-1.26,1.76s-.11,1.31.8,1.25c0,0-.45,1.65,1.42,1.31,0,0-.51,1.31,1.54,1.14,0,0,.22,2.38,2.61.45,0,0,.57,2.56,3.5,1.08s2-2.56,2-2.56a4.84,4.84,0,0,0,2.5-3.18,13.27,13.27,0,0,0,.33-2.84s3.09-3.3,2.71-5.46S16.09,7,16.15,5.71,17.74,3.43,16.72,1.27Z" transform="translate(0 0)"/>
                                </svg>
                                <svg id="foot-left" class="foot-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.47 23.62">
                                    <path d="M.75,1.27,8.77,0s.28,2,1,2.24S10,5.08,10.3,5.6s5.46,8.64,5.92,10.57c0,0,1.25,1,1.25,1.76s.11,1.31-.8,1.25c0,0,.46,1.65-1.42,1.31,0,0,.51,1.31-1.54,1.14,0,0-.22,2.38-2.61.45,0,0-.57,2.56-3.5,1.08s-2-2.56-2-2.56a4.87,4.87,0,0,1-2.5-3.18,14.3,14.3,0,0,1-.33-2.84S-.35,11.28,0,9.12,1.38,7,1.32,5.71-.27,3.43.75,1.27Z"/>
                                </svg>
                            </div>
                            <div id="back" class="body-back">
                                <svg  class="nape" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.28 26.24">
                                    <path d="M3.85,25.59l.65-2.27a3.9,3.9,0,0,1-1.12-2.49V18.21s0,1.29-.77,1.24S.16,16.53,0,14.82s0-5.11,2.23-2.19c0,0-.55-8.21,2.24-10.4A12.22,12.22,0,0,1,11.11,0s4.12-.09,6.66,2.28,2.1,10.52,2.1,10.52,2.41-3.48,2.41,1.41c0,0-.43,4.08-2.67,5.2,0,0-.47.56-1-1.2,0,0,.47,3.05-.09,4.08s-.86.9-.86.9l.9,3S15.2,22.85,11.14,25C11.14,25,8.23,22.16,3.85,25.59Z" transform="translate(0 0)"/>
                                </svg>
                                <svg id="trapezius-right" class="trapezius-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.46 12.76">
                                    <path d="M0,.57S3.27-1.4,7.32,2c0,0,4.74,3.46,7.7,4.06s7.44,4.8,7.44,4.8-.27,2.73-9.38,1.67S.23,7.24,0,.57Z"/>
                                </svg>
                                <svg id="trapezius-left" class="trapezius-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.46 12.76">
                                    <path d="M22.46.57S19.19-1.4,15.15,2c0,0-4.75,3.46-7.71,4.06S0,10.85,0,10.85s.28,2.73,9.38,1.67S22.23,7.24,22.46.57Z" transform="translate(0 0)"/>
                                </svg>
                                <svg id="trunk-right" class="trunk-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.71 68.86">
                                    <path d="M5.47,0s2,1.69,6.82,2.21a25.23,25.23,0,0,0,7.29,0A3.22,3.22,0,0,1,16.5,4.69c-2.65.17-6.08-.26-6.64,2.08s-.26,3.78.78,6.73,1,7.73-3.78,14.33S1.21,35.74.43,34.48s.44-13,0-16.59S-1.48,2.93,5.47,0Z" transform="translate(0 0)"/><path d="M13.6,5.2a5.18,5.18,0,0,0-2.52.64A4.06,4.06,0,0,0,10,9.31c.18,1.57,1.29,4.24,1.41,5.07s.09,2.06.8,2.8c0,0,5.1-2,6.76-4.43a5.39,5.39,0,0,1-.62-4.17S16.21,5.87,13.6,5.2Z" transform="translate(0 0)"/><path d="M11.47,16.83A16.91,16.91,0,0,1,14,21.2a6.63,6.63,0,0,1-3.08-.55A10.63,10.63,0,0,0,11.47,16.83Z" transform="translate(0 0)"/><path d="M12.47,17.45a16.71,16.71,0,0,1,1.94,3.76h3s1.73-.2,2.28-1.2,1.1-5.17,1.1-5.17A7.17,7.17,0,0,1,19,13S15.26,16.83,12.47,17.45Z" transform="translate(0 0)"/><path d="M10.8,21.05a19.78,19.78,0,0,0,4.31.72,14.83,14.83,0,0,0,4.47-1L18.1,28.71s-1.59,5.79-3.48,8.72-6,12.13-6.5,15.06-3.11,0-3.11,0S1.61,41.92,1.36,35.38A71.06,71.06,0,0,0,6.2,29.73,32.41,32.41,0,0,0,10.8,21.05Z" transform="translate(0 0)"/><path d="M15.31,37.08V47.85A13.39,13.39,0,0,1,8.25,53.8S9,48.11,15.31,37.08Z" transform="translate(0 0)"/><path d="M9.27,54a16.39,16.39,0,0,0,6.4-5.49S17.8,51.93,17.76,54a11.75,11.75,0,0,1-.87,4Z" transform="translate(0 0)"/>
                                </svg>
                                <svg id="trunk-left" class="trunk-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.46 68.86">
                                    <path d="M15.36,0s-2,1.69-6.82,2.21a25.23,25.23,0,0,1-7.29,0A3.22,3.22,0,0,0,4.33,4.69C7,4.86,10.41,4.43,11,6.77s.26,3.78-.78,6.73-1,7.73,3.78,14.33,5.64,7.91,6.43,6.65-.44-13,0-16.59S22.31,2.93,15.36,0Z"/><path d="M7.23,5.2a5.18,5.18,0,0,1,2.52.64,4.06,4.06,0,0,1,1.13,3.47c-.18,1.57-1.29,4.24-1.41,5.07s-.09,2.06-.8,2.8c0,0-5.1-2-6.76-4.43a5.39,5.39,0,0,0,.62-4.17S4.62,5.87,7.23,5.2Z"/><path d="M9.36,16.83A16.91,16.91,0,0,0,6.82,21.2a6.63,6.63,0,0,0,3.08-.55A10.63,10.63,0,0,1,9.36,16.83Z"/><path d="M8.36,17.45a16.71,16.71,0,0,0-1.94,3.76h-3S1.64,21,1.1,20,0,14.84,0,14.84A7.05,7.05,0,0,0,1.82,13S5.57,16.83,8.36,17.45Z"/><path d="M10,21.05a19.78,19.78,0,0,1-4.31.72,14.83,14.83,0,0,1-4.47-1l1.48,7.91s1.59,5.79,3.48,8.72,6,12.13,6.5,15.06,3.11,0,3.11,0,3.39-10.57,3.65-17.11a71.06,71.06,0,0,1-4.84-5.65A32.41,32.41,0,0,1,10,21.05Z"/><path d="M5.52,37.08V47.85a13.39,13.39,0,0,0,7.06,5.95S11.79,48.11,5.52,37.08Z"/><path d="M11.56,54a16.39,16.39,0,0,1-6.4-5.49S3,51.93,3.07,54a11.75,11.75,0,0,0,.87,4Z"/>
                                </svg>
                                <svg id="p-shoulder-right" class="p-shoulder-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14.29 18.59">
                                    <path d="M.16,5.75S2.8-.26,7.37,0s5.27,6,5.27,6a23.29,23.29,0,0,1,1.63,7.25c.25,4.16-1.42,5.38-1.42,5.38a25.16,25.16,0,0,0-5.62-3.91C4.83,13.72-1,12.42.16,5.75Z" transform="translate(0 0)"/>
                                </svg>
                                <svg id="p-shoulder-left" class="p-shoulder-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14.29 18.59">
                                    <path d="M14.13,5.75S11.49-.26,6.92,0,1.65,6,1.65,6A23.13,23.13,0,0,0,0,13.21c-.26,4.16,1.42,5.38,1.42,5.38a25,25,0,0,1,5.61-3.91C9.46,13.72,15.34,12.42,14.13,5.75Z"/>
                                </svg>
                                <svg id="p-arm-right" class="p-arm-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14.64 25.95">
                                    <path d="M9.44,25a1.92,1.92,0,0,0,1.88.92c1.3-.17-2.05-10.61-4.3-13.32s-1.5,2.55-1.5,2.55A58.39,58.39,0,0,0,9.44,25Z"/><path d="M12.36,5.44a22.1,22.1,0,0,1,2.18,8.1c.37,4.8-.21,8.93-2.43,11.81a42.89,42.89,0,0,0-1.71-7.14c-1.08-2.92-3-6.59-4.63-7,0,0-1.59-9.53-2.86-11.24C2.91,0,7,1.1,12.36,5.44Z"/><path d="M0,10.88a56.36,56.36,0,0,0,3.76,7.39,29.65,29.65,0,0,0,4.09,4.42S5.34,16.32,5,15A9.72,9.72,0,0,1,5.4,11.3S3.85,2.78,2.46,0A71.59,71.59,0,0,0,0,10.88Z"/><path d="M4.1,19.2a9.3,9.3,0,0,0,1.75,4.22,7.07,7.07,0,0,0,3.38,2.15L7.85,23A37,37,0,0,1,4.1,19.2Z"/>
                                </svg>
                                <svg id="p-arm-left" class="p-arm-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14.64 25.95">
                                    <path d="M5.2,25a1.92,1.92,0,0,1-1.88.92C2,25.77,5.37,15.33,7.62,12.62s1.5,2.55,1.5,2.55A58.39,58.39,0,0,1,5.2,25Z" transform="translate(0 0)"/><path d="M2.28,5.44a22,22,0,0,0-2.17,8.1c-.38,4.8.2,8.93,2.42,11.81a42.89,42.89,0,0,1,1.71-7.14c1.08-2.92,3-6.59,4.63-7,0,0,1.59-9.53,2.86-11.24C11.73,0,7.66,1.1,2.28,5.44Z" transform="translate(0 0)"/><path d="M14.64,10.88a56.36,56.36,0,0,1-3.76,7.39A29.84,29.84,0,0,1,6.8,22.69S9.3,16.32,9.63,15a9.51,9.51,0,0,0-.39-3.72S10.79,2.78,12.19,0A72.76,72.76,0,0,1,14.64,10.88Z" transform="translate(0 0)"/><path d="M10.54,19.2A9.23,9.23,0,0,1,8.8,23.42a7.07,7.07,0,0,1-3.39,2.15L6.8,23A37.16,37.16,0,0,0,10.54,19.2Z" transform="translate(0 0)"/>
                                </svg>
                                <svg id="p-forearm-right" class="p-forearm-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14.46 37.99">
                                    <path d="M.08,3.79A31.26,31.26,0,0,0,.08,8a3.78,3.78,0,0,0,1.51,2.54,7.7,7.7,0,0,1,1.78,2.58A7.81,7.81,0,0,0,5.8,7.12,17.1,17.1,0,0,1,2.54,6.06,8.92,8.92,0,0,1,.08,3.79Z"/><path d="M6,7.15a7.87,7.87,0,0,1-2.45,6l1.46,2.91a7.75,7.75,0,0,0,2-4.94C7.31,7.74,6.7,7,6.7,7Z"/><path d="M1.33,10.89A28.67,28.67,0,0,0,1,14.56,24.53,24.53,0,0,0,2,20.1S5.08,28,5.57,29.52s.71,7.06.71,7.06S8.2,34,7.49,25.36A26.46,26.46,0,0,0,1.33,10.89Z"/><path d="M10,0S9.39,3.7,8,5.6c0,0,3.16,5.15,5,6.13,0,0,.55-4.9-.55-7.48A19.66,19.66,0,0,0,10,0Z"/><path d="M6.86,6.94l.92-1.08s3.21,6,5.32,6.29c0,0,1.4,1.68,1.36,5.78a101.27,101.27,0,0,1-.9,10.27A28,28,0,0,0,12,19.49C10.56,15.9,8.42,13.69,6.86,6.94Z"/><path d="M7.37,10.26s0,3.72-2,6A26.23,26.23,0,0,1,8.05,28.2s1.78,5.34,1.67,7.56,1.53,2.54,2.11,2a11.58,11.58,0,0,0,1.38-2.87S14,26.72,12,21,8.81,15,7.37,10.26Z"/>
                                </svg>
                                <svg id="p-forearm-left" class="p-forearm-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14.46 37.99">
                                    <path d="M14.39,3.79a33.09,33.09,0,0,1,0,4.16,3.86,3.86,0,0,1-1.51,2.54,7.63,7.63,0,0,0-1.79,2.58A7.82,7.82,0,0,1,8.67,7.12a17.34,17.34,0,0,0,3.26-1.06A9.08,9.08,0,0,0,14.39,3.79Z" transform="translate(0 0)"/><path d="M8.42,7.15a7.87,7.87,0,0,0,2.45,6L9.42,16.09a7.72,7.72,0,0,1-2-4.94C7.16,7.74,7.77,7,7.77,7Z" transform="translate(0 0)"/><path d="M13.13,10.89a28.67,28.67,0,0,1,.32,3.67,24.73,24.73,0,0,1-.94,5.54S9.38,28,8.89,29.52a48.86,48.86,0,0,0-.71,7.06S6.26,34,7,25.36A26.54,26.54,0,0,1,13.13,10.89Z" transform="translate(0 0)"/><path d="M4.5,0s.57,3.7,2,5.6c0,0-3.16,5.15-5,6.13,0,0-.55-4.9.55-7.48A19.66,19.66,0,0,1,4.5,0Z" transform="translate(0 0)"/><path d="M7.6,6.94,6.68,5.86s-3.2,6-5.32,6.29c0,0-1.4,1.68-1.36,5.78A101.27,101.27,0,0,0,.9,28.2a28,28,0,0,1,1.52-8.71C3.9,15.9,6.05,13.69,7.6,6.94Z" transform="translate(0 0)"/><path d="M7.09,10.26s0,3.72,2,6A26.23,26.23,0,0,0,6.41,28.2s-1.78,5.34-1.67,7.56-1.52,2.54-2.11,2a11.58,11.58,0,0,1-1.38-2.87S.48,26.72,2.49,21,5.65,15,7.09,10.26Z" transform="translate(0 0)"/>
                                </svg>
                                <svg id="gluteus-right" class="gluteus-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18.63 30.02">
                                    <path d="M2.7,7.6S7.33.41,10,0,17,2.57,17,2.57s1,3.44,1.34,5.62A34.49,34.49,0,0,1,18.5,14S13.26,9.4,8.8,7.56,2.7,7.6,2.7,7.6Z" transform="translate(0.09)"/><path d="M2.32,8.24s-2,2.5-2.32,8.19.1,6.75,1.79,8.35,4.54,2.46,6.91,3.28,6,3,7.59,1.41S13.44,20.57,13.78,17s1.25-2.8,1.3-4.59S5.51,5.05,2.32,8.24Z" transform="translate(0.09)"/>
                                </svg>
                                <svg id="gluteus-left" class="gluteus-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18.63 30.02">
                                    <path d="M15.84,7.6S11.2.41,8.52,0,1.58,2.57,1.58,2.57.62,6,.25,8.19A34.49,34.49,0,0,0,0,14s5.24-4.6,9.7-6.44S15.84,7.6,15.84,7.6Z" transform="translate(0 0)"/><path d="M16.22,8.24s2,2.5,2.32,8.19-.1,6.75-1.79,8.35-4.55,2.46-6.91,3.28-5.95,3-7.59,1.41S5.1,20.57,4.76,17s-1.26-2.8-1.31-4.59S13,5.05,16.22,8.24Z" transform="translate(0 0)"/>
                                </svg>
                                <svg id="p-hand-right" class="p-hand-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.41 31.49">
                                    <path d="M3.14,6.66A14.68,14.68,0,0,1,1,10C-.18,11.12,0,18.71,0,18.71s-.11,2.11,1.14,1.83,2-3,2-3,0-2.78.78-3.05,2.74,5.12,2.74,5.12A6.81,6.81,0,0,0,6,23.09s-2.43,1.52-2.43,3.59S4.7,28.05,4.7,28.05s3.84-2.42,4.82-5.75.89-16.85.89-16.85-.72,1.94-1.9,2.42S6.36,5.75,6.3,4.44A44.42,44.42,0,0,0,5.21,0S5,5.79,3.14,6.66Z" transform="translate(0 0)"/><path d="M9.56,22.63A11.51,11.51,0,0,1,9,25.88,50.63,50.63,0,0,1,5,30a1.42,1.42,0,0,1-.57-1.59A49.28,49.28,0,0,0,8.26,25,10.65,10.65,0,0,0,9.56,22.63Z" transform="translate(0 0)"/><path d="M5.78,29.56s0,1.51,1.11,1.93a22.73,22.73,0,0,0,1.89-4.85Z" transform="translate(0 0)"/>
                                </svg>
                                <svg id="p-hand-left" class="p-hand-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.41 31.49">
                                    <path d="M7.27,6.66A15.06,15.06,0,0,0,9.46,10c1.14,1.14.94,8.73.94,8.73s.12,2.11-1.13,1.83-2-3-2-3,0-2.78-.77-3.05-2.75,5.12-2.75,5.12a6.88,6.88,0,0,1,.67,3.45s2.42,1.52,2.42,3.59-1.13,1.37-1.13,1.37S1.87,25.63.9,22.3,0,5.45,0,5.45.73,7.39,1.9,7.87,4.05,5.75,4.11,4.44A44,44,0,0,1,5.21,0S5.44,5.79,7.27,6.66Z"/><path d="M.85,22.63a11.51,11.51,0,0,0,.52,3.25,50.63,50.63,0,0,0,4,4.16,1.42,1.42,0,0,0,.57-1.59A49.57,49.57,0,0,1,2.16,25,10.43,10.43,0,0,1,.85,22.63Z"/><path d="M4.63,29.56s0,1.51-1.1,1.93a22.45,22.45,0,0,1-1.9-4.85Z"/>
                                </svg>
                                <svg id="p-leg-right" class="p-leg-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.52 57.57">
                                    <path d="M15.9,0a4.67,4.67,0,0,1,2.94,1.94,5,5,0,0,0,.3,2c.35.65,2.47,10.24,2.94,12.71s.7,17.53,0,20.77c0,0-2.24-15.77-4.77-21.83A42,42,0,0,0,15.2,8.06C13.88,5,14.72,1.18,15.9,0Z"/><path d="M.19,10.55a13,13,0,0,0,5.22,3.7,23.36,23.36,0,0,1,1.25,7.14c.13,4.29-1.43,13.77-2.53,16.5,0,0-.65-10.2-2-14S-.49,15.09.19,10.55Z"/><path d="M10.72,16.28s3.89,1.19,5.2.82,1.26-.82,1.26-.82,1.44,5.14,1.82,7.34S20.81,36,21.69,38.23c0,0-1.38,11.85-1.25,12.85s.5,3.39-.06,4.33c0,0-6.15-13.42-8.09-22.89A69.63,69.63,0,0,1,10.72,16.28Z"/><path d="M6.45,29.38s-.57,6-2.21,9.3c0,0-.42,11,2.21,14.47,0,0-.33-8.41.75-13.53A21.31,21.31,0,0,0,6.45,29.38Z"/><path d="M5.88,14.53l4.32,1.75a79.91,79.91,0,0,0,1,13.49,63,63,0,0,0,2.72,11s.61,3.54-2.11,8.84-2.51,8-2.51,8-2.15-2.6-2.41-4a74.67,74.67,0,0,1,.3-11.42c.34-2.51,1.55-9.68-.72-13.33A34.78,34.78,0,0,0,7,21,43.5,43.5,0,0,0,5.88,14.53Z"/>
                                </svg>
                                <svg id="p-leg-left" class="p-leg-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.52 57.57">
                                    <path d="M6.62,0A4.69,4.69,0,0,0,3.68,1.94a5.08,5.08,0,0,1-.29,2C3,4.59.92,14.18.45,16.65s-.71,17.53,0,20.77c0,0,2.23-15.77,4.76-21.83A42.38,42.38,0,0,1,7.33,8.06C8.64,5,7.8,1.18,6.62,0Z" transform="translate(0 0)"/><path d="M22.33,10.55a13,13,0,0,1-5.22,3.7,23.56,23.56,0,0,0-1.24,7.14c-.13,4.29,1.42,13.77,2.53,16.5,0,0,.65-10.2,2-14S23,15.09,22.33,10.55Z" transform="translate(0 0)"/><path d="M11.8,16.28s-3.88,1.19-5.2.82-1.25-.82-1.25-.82S3.9,21.42,3.53,23.62,1.71,36,.83,38.23c0,0,1.38,11.85,1.26,12.85s-.51,3.39.06,4.33c0,0,6.14-13.42,8.09-22.89A69.9,69.9,0,0,0,11.8,16.28Z" transform="translate(0 0)"/><path d="M16.08,29.38s.56,6,2.2,9.3c0,0,.43,11-2.2,14.47,0,0,.33-8.41-.75-13.53A21.31,21.31,0,0,1,16.08,29.38Z" transform="translate(0 0)"/><path d="M16.65,14.53l-4.33,1.75a79.91,79.91,0,0,1-1,13.49,61.88,61.88,0,0,1-2.72,11S8,44.32,10.72,49.62s2.52,8,2.52,8,2.14-2.6,2.41-4a77.33,77.33,0,0,0-.3-11.42c-.34-2.51-1.56-9.68.71-13.33A35.43,35.43,0,0,1,15.53,21,42.73,42.73,0,0,1,16.65,14.53Z" transform="translate(0 0)"/>
                                </svg>
                                <svg id="p-calf-right" class="p-calf-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.98 48.09">
                                    <path d="M3.83,3.49s2.81,2.7,5.05,14.59S7.88,46,7.88,46,6.65,33.53,3.06,27.26-.43,16.54.68,13.11A33.33,33.33,0,0,1,3.06,7.42,5.43,5.43,0,0,1,3.83,3.49Z" transform="translate(0 0)"/><path d="M11.76,48.09s-.23-10.52,1.86-18.82,1.69-19,1.69-19L10.74,0S6.79,5.11,7.11,9.3a51.75,51.75,0,0,1,3.07,13.19C10.65,29,8.84,44.08,8.84,44.08S7.61,47.43,11.76,48.09Z" transform="translate(0 0)"/><path d="M15.73,11.81s0,6.14-.39,9.56S13.22,32.23,13,34.07s-1.06,7-.38,9.31a5.27,5.27,0,0,0,2.46,3.14s-2-2.46-.78-9.8S18.76,19.93,15.73,11.81Z" transform="translate(0 0)"/>
                                </svg>
                                <svg id="p-calf-left" class="p-calf-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.98 48.09">
                                    <path d="M13.15,3.49s-2.8,2.7-5.05,14.59S9.1,46,9.1,46s1.24-12.43,4.82-18.7,3.49-10.72,2.39-14.15a33.79,33.79,0,0,0-2.39-5.69A5.43,5.43,0,0,0,13.15,3.49Z"/><path d="M5.23,48.09s.22-10.52-1.87-18.82-1.69-19-1.69-19L6.25,0s3.94,5.11,3.63,9.3A52,52,0,0,0,6.8,22.49C6.33,29,8.14,44.08,8.14,44.08S9.37,47.43,5.23,48.09Z"/><path d="M1.26,11.81s0,6.14.38,9.56S3.76,32.23,4,34.07s1.06,7,.39,9.31a5.31,5.31,0,0,1-2.46,3.14s2-2.46.77-9.8S-1.78,19.93,1.26,11.81Z"/>
                                </svg>
                                <svg id="p-foot-right" class="p-foot-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.69 18.61">
                                    <path d="M2.71,17.22c.68-.12,1.44-1,2.69-1.62s5.91-1,5.79-3.87a1.48,1.48,0,0,0,1.43-1.82C12.44,8.1,10.23,9,10.23,9s-3.52-3.7-6-4.44A2.81,2.81,0,0,0,3.89,3C3.49,2.41,1,1.09.68,0L0,.43.05,4S-.6,17.85,2.71,17.22Z" transform="translate(0 0)"/>
                                </svg>
                                <svg id="p-foot-left" class="p-foot-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.69 18.61">
                                    <path d="M9.93,17.22c-.68-.12-1.44-1-2.69-1.62s-5.91-1-5.79-3.87A1.47,1.47,0,0,1,0,9.91C.2,8.1,2.41,9,2.41,9s3.53-3.7,6-4.44A2.76,2.76,0,0,1,8.75,3c.4-.63,2.87-1.95,3.21-3l.66.43,0,3.58S13.24,17.85,9.93,17.22Z" transform="translate(-0.01)"/>
                                </svg>
                                <svg id="heel-right" class="heel-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.69 18.61">
                                    <path d="M2.83,1.93a31.19,31.19,0,0,1-1.2,4.83c-.73,2-2.89,6.83-.62,9.38,2.74,3.08,8.49.52,8.49.52s-2.42.75-2.32-13.2c0-1.08-3.41-.85-3.45-3.14Z" transform="translate(0 -0.32)"/>
                                </svg>
                                <svg id="heel-left" class="heel-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.69 18.61">
                                    <path d="M6.67,1.93a31.19,31.19,0,0,0,1.2,4.83c.73,2,2.89,6.83.62,9.38C5.75,19.22,0,16.66,0,16.66s2.42.75,2.32-13.2c0-1.08,3.41-.85,3.45-3.14Z" transform="translate(0 -0.32)"/>
                                </svg>
                            </div>
                        </div>
                        <div class="col-sm-9 col-12 mt-5 content-senas">
                            <div class="table-responsive">
                                <table class="table" id="senas">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Perfil</th>
                                            <th scope="col">Parte</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Color</th>
                                            <th scope="col">Clasificación</th>
                                            <th scope="col">Descripción</th>
                                            <th scope="col">Imagen</th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </div>
        </form>
        </div>
                <div class="col-12 d-flex justify-content-center col-sm-12 mt-5">
                	<a href="<?= base_url?>Seguimientos">
   						<button class="btn btn-sm btn-ssc">Regresar a seguimientos</button>
					</a>
                </div>
    <br><br><br>
    </div>