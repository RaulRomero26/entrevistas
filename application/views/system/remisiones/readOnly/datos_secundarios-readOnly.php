<div class="container">
    <!--<div class="row mt-5">
        <div class="col-lg-12 col-sm-12 d-flex justify-content-start align-items-center">
            <span class="span_rem">Núm. Remisión/Oficio: </span>
            <span class="span_rem_ans ml-2">20133</span>
        </div>
    </div> -->

    <form id="datos_mediaFiliacion">

    <div class="row mt-5">

            <div class="col-12 my-4" id="msg_mediaF"></div>
            <div class="col-lg-4 d-flex justify-content-start align-items-center">

            <?php
                $no_remision    = (isset($_GET['no_remision']))?$_GET['no_remision']:'0';
                $no_ficha       = (isset($_GET['no_ficha']))?$_GET['no_ficha']:'0';      
            ?>

            
                <input type="hidden" name="no_remision_mediaFiliacion" id="no_remision_mediaFiliacion" value=<?=$no_remision?>>
                <input type="hidden" name="no_ficha_mediaFiliacion" id="no_ficha_mediaFiliacion" value=<?=$no_ficha?>>

                <span class="span_rem">Núm. Remisión/Oficio: </span>
                <?php if(isset($_GET['no_remision'])){?>
                        <span class="span_rem_ans ml-2"><?= $_GET['no_remision'] ?></span>
                <?php } ?>

                <span class="span_rem ml-5">Núm. Ficha: </span>
                <?php if(isset($_GET['no_remision'])){?>
                        <span class="span_rem_ans ml-2"><?= $_GET['no_ficha'] ?></span>
                <?php } ?>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-3">
                <div class="row" id="photosMF"></div>
            </div>
            <div class="col-lg-9">
                <div class="col-12 text-center">
                    <p class="form_title mt-5 text-center">Media filiación: </p>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-lg-2 text-center mt-4">
                        <label for="Complexion" class="label-form">Complexión:</label>
                        <span class="valor-campo" id="Complexion" name="Complexion"></span>
                            
                        </select>
                    </div>

                    <div class="form-group col-lg-3 text-center mt-4">
                        <label for="Estarura" class="label-form">Estatura(cm):</label>
                        <span class="valor-campo" id="Estarura" name="Estarura"></span>
                        <span class="span_error" id="Estatura_error"></span>
                    </div>

                    <div class="form-group col-lg-2 text-center mt-4">
                        <label for="Color_p" class="label-form">Color de piel:</label>

                        <span class="valor-campo" id="Color_p" name="Color_p"></span>
                            
                        
                    </div>

                    <div class="form-group col-lg-3 text-center mt-4">
                        <label for="formaCara" class="label-form">Forma de cara:</label>
                        <span class="valor-campo" id="formaCara" name="formaCara"></span>

                    </div>

                    <div class="form-group col-lg-2 text-center mt-4">
                        <label for="Pomulos" class="label-form">Pómulos:</label>
                        <span class="valor-campo" id="Pomulos" name="Pomulos"></span>
                    </div>

                    <div class="form-group col-lg-2 text-center mt-4">
                        <label for="Cabello" class="label-form">Cabello:</label>
                        <span class="valor-campo" id="Cabello" name="Cabello"></span>

                    </div>

                    <div class="form-group col-lg-3 text-center mt-4">
                        <label for="colorCabello" class="label-form">Color de cabello:</label>
                        <span class="valor-campo" id="colorCabello" name="colorCabello"></span>
                    </div>

                    <div class="form-group col-lg-2 text-center mt-4">
                        <label for="tamCabello" class="label-form">Tam. de cabello:</label>
                        <span class="valor-campo" id="tamCabello" name="tamCabello"></span>

                    </div>

                    <div class="form-group col-lg-3 text-center mt-4">
                        <label for="formaCabello" class="label-form">Forma de cabello:</label>
                        <span class="valor-campo" id="formaCabello" name="formaCabello"></span>
                    </div>

                    <div class="form-group col-lg-2 text-center mt-4">
                        <label for="Frente" class="label-form">Frente:</label>
                        <span class="valor-campo" id="Frente" name="Frente"></span>
                    </div>

                    <div class="form-group col-lg-2 text-center mt-4">
                        <label for="Cejas" class="label-form">Cejas:</label>
                        <span class="valor-campo" id="Cejas" name="Cejas"></span>
                    </div>

                    <div class="form-group col-lg-3 text-center mt-4">
                        <label for="tipoCejas" class="label-form">Tipo de Cejas:</label>
                        <span class="valor-campo" id="tipoCejas" name="tipoCejas"></span>
                    </div>

                    <div class="form-group col-lg-2 text-center mt-4">
                        <label for="colorOjos" class="label-form">Color de ojos:</label>
                        <span class="valor-campo" id="colorOjo" name="colorOjo"></span>
                    </div>

                    <div class="form-group col-lg-3 text-center mt-4">
                        <label for="tamOjos" class="label-form">Tam. de ojos:</label>
                        <span class="valor-campo" id="tamOjos" name="tamOjos"></span>
                    </div>

                    <div class="form-group col-lg-2 text-center mt-4">
                        <label for="formaOjos" class="label-form">Forma de ojos:</label>
                        <span class="valor-campo" id="formaOjos" name="formaOjos"></span>
                    </div>

                    <div class="form-group col-lg-2 text-center mt-4">
                        <label for="Nariz" class="label-form">Nariz:</label>
                        <span class="valor-campo" id="Nariz" name="Nariz"></span>
                    </div>

                    <div class="form-group col-lg-3 text-center mt-4">
                        <label for="tamBoca" class="label-form">Tam. de boca:</label>
                        <span class="valor-campo" id="tamBoca" name="tamBoca"></span>
                    </div>

                    <div class="form-group col-lg-2 text-center mt-4">
                        <label for="Labios" class="label-form">Labios:</label>
                        <span class="valor-campo" id="Labios" name="Labios"></span>

                    </div>

                    <div class="form-group col-lg-3 text-center mt-4">
                        <label for="Menton" class="label-form">Mentón:</label>
                        <span class="valor-campo" id="Menton" name="Menton"></span>

                    </div>

                    <div class="form-group col-lg-2 text-center mt-4">
                        <label for="tamOrejas" class="label-form">Tam. de orejas:</label>
                        <span class="valor-campo" id="tamOrejas" name="tamOrejas"></span>
                    </div>

                    <div class="form-group col-lg-2 text-center mt-4">
                        <label for="Lobulos" class="label-form">Lóbulos:</label>
                        <span class="valor-campo" id="Lobulos" name="Lobulos"></span>
                    </div>

                    <div class="form-group col-lg-3 text-center mt-4">
                        <label for="Barba" class="label-form">Barba:</label>
                        <span class="valor-campo" id="Barba" name="Barba"></span>

                    </div>

                    <div class="form-group col-lg-2 text-center mt-4">
                        <label for="tamBarba" class="label-form">Tam. de barba:</label>
                        <span class="valor-campo" id="tamBarba" name="tamBarba"></span>
                    </div>

                    <div class="form-group col-lg-3 text-center mt-4">
                        <label for="colorBarba" class="label-form">Color de barba:</label>
                        <span class="valor-campo" id="colorBarba" name="colorBarba"></span>
                    </div>

                    <div class="form-group col-lg-2 text-center mt-4">
                        <label for="Bigote" class="label-form">Bigote:</label>
                        <span class="valor-campo" id="Bigote" name="Bigote"></span>
                    </div>

                    <div class="form-group col-lg-6 text-center mt-4">
                        <label for="tamBigote" class="label-form">Tam. de bigote:</label>
                        <span class="valor-campo" id="tamBigote" name="tamBigote"></span>
                    </div>

                    <div class="form-group col-lg-6 text-center mt-4">
                        <label for="colorBigote" class="label-form">Color de bigote:</label>
                        <span class="valor-campo" id="colorBigote" name="colorBigote"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Se comenta todo lo relacionado a contacto conocido, ya que ahora se manejara con una tabla  
        <div class="form-row mt-5">
            <fieldset class="form-group col-sm-12">
                <legend class="col-form-label pl-1">¿Se poseé información de algún conocido?</legend>
                <div class="container ml-1">
                    <div class="row">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="infoConocido" id="infoConocido1" value="No" disabled>
                            <label class="form-check-label" for="infoConocido1">
                                No
                            </label>
                        </div>
                        <div class="form-check ml-5">
                            <input class="form-check-input" type="radio" name="infoConocido" id="infoConocido2" value="Si" disabled>
                            <label class="form-check-label" for="infoConocido2">
                                Si
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="col-sm-12" id="infoConocido">
            <div class="form-row mt-3">

                <div class="form-group col-lg-3 text-center mt-4">
                    <label for="parentezco" class="label-form">Tipo de relación:</label>
                    <span class="valor-campo" id="parentezco_conocido" name="parentezco_conocido"></span>
                </div>

                <div class="form-group col-lg-3 text-center mt-4">
                    <label for="Nombres" class="label-form">Nombres:</label>
                    <span class="valor-campo" name="Nombre_conocido" id="Nombre_conocido"></span>
                    <span class="span_error" id="Nombre_conocido_error"></span>
                </div>

                <div class="form-group col-lg-3 text-center mt-4">
                    <label for="appPaterno" class="label-form">Apellido paterno:</label>
                    <span class="valor-campo" name="apaterno_conocido" id="apaterno_conocido"></span>
                    <span class="span_error" id="apaterno_conocido_error"></span>
                </div>

                <div class="form-group col-lg-3 text-center mt-4">
                    <label for="appMaterno" class="label-form">Apellido materno:</label>
                    <span class="valor-campo" name="amaterno_conocido" id="amaterno_conocido"></span>
                    <span class="span_error" id="amaterno_conocido_error"></span>
                </div>

                <div class="form-group col-lg-4 text-center mt-4">
                    <label for="telefono" class="label-form">Teléfono:</label>
                    <span class="valor-campo" name="telefono_conocido" id="telefono_conocido"></span>
                    <span class="span_error" id="telefono_conocido_error"></span>
                </div>

                <div class="form-group col-lg-4 text-center mt-4">
                    <label for="Edad" class="label-form">Edad:</label>
                    <span class="valor-campo" name="edad_conocido" id="edad_conocido"></span>
                    <span class="span_error" id="edad_conocido_error"></span>
                </div>

                <div class="form-group col-lg-4 text-center mt-4">
                    <label for="Sexo" class="label-form">Sexo:</label>
                    <span class="valor-campo" name="sexo_conocido" id="sexo_conocido"></span>
                </div>
            </div>
        </div>-->
        <!--Nueva tabla añadida para visualizar los contactos conocidos del detenido -->
        <div class="col-sm-12" id="infoConocido">
            <p class="form_title mt-5">Información de conocidos: </p>
            <div class="table-responsive">
                    <table class="table table-bordered" id="informacionConocidos">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Tipo de relación</th>
                                <th scope="col">Nombres</th>
                                <th scope="col">Apellido Paterno</th>
                                <th scope="col">Apellido Materno</th>
                                <th scope="col">Teléfono</th>
                                <th scope="col">Edad</th>
                                <th scope="col">Sexo</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
            </div>
        </div>

    </form>

    <div class="row mt-5 mb-5">
        <div class="col-12 d-flex justify-content-center col-sm-12">
            <a class="btn btn-sm btn-ssc" href="<?= base_url;?>Remisiones">Volver al inicio</a>
        </div>
    </div>
</div>