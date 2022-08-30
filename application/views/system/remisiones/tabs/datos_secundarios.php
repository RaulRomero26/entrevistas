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

        <div class="row">
            <div class="col-lg-4">
                <img class="img-fluid" src="" alt="" id="cuerpo_frente_media">
                <img class="img-fluid" src="" alt="" id="rostro_frente_media">
            </div>
            <div class="col-lg-8">
                <p class="form_title mt-5">Media filiación: </p>
                <div class="form-row">
                    <div class="form-group col-lg-2">
                        <label for="Complexion" class="label-form">Complexión:</label>
                        <select class="custom-select custom-select-sm" id="Complexion" name="Complexion">
                            <?php foreach ($data['datos_sec']['complexion'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="Estarura" class="label-form">Estatura(cm):</label>
                        <input type="number" class="form-control form-control-sm" id="Estarura" name="Estarura">
                        <span class="span_error" id="Estatura_error"></span>
                    </div>

                    <div class="form-group col-lg-2">
                        <label for="Color_p" class="label-form">Color de piel:</label>

                        <select class="custom-select custom-select-sm" id="Color_p" name="Color_p">
                            <?php foreach ($data['datos_sec']['color_piel'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="formaCara" class="label-form">Forma de cara:</label>
                        <select class="custom-select custom-select-sm" id="formaCara" name="formaCara">
                            <?php foreach ($data['datos_sec']['forma_cara'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>

                    </div>

                    <div class="form-group col-lg-2">
                        <label for="Pomulos" class="label-form">Pómulos:</label>
                        <select class="custom-select custom-select-sm" id="Pomulos" name="Pomulos">
                            <?php foreach ($data['datos_sec']['pomulos'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-2">
                        <label for="Cabello" class="label-form">Cabello:</label>
                        <select class="custom-select custom-select-sm" id="Cabello" name="Cabello">
                            <?php foreach ($data['datos_sec']['cabello'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>

                    </div>

                    <div class="form-group col-lg-3">
                        <label for="colorCabello" class="label-form">Color de cabello:</label>
                        <select class="custom-select custom-select-sm" id="colorCabello" name="colorCabello">
                            <?php foreach ($data['datos_sec']['color_cabello'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-2">
                        <label for="tamCabello" class="label-form">Tam. de cabello:</label>
                        <select class="custom-select custom-select-sm" id="tamCabello" name="tamCabello">
                            <?php foreach ($data['datos_sec']['tam_cabello'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>

                    </div>

                    <div class="form-group col-lg-3">
                        <label for="formaCabello" class="label-form">Forma de cabello:</label>
                        <select class="custom-select custom-select-sm" id="formaCabello" name="formaCabello">
                            <?php foreach ($data['datos_sec']['forma_cabello'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-2">
                        <label for="Frente" class="label-form">Frente:</label>
                        <select class="custom-select custom-select-sm" id="Frente" name="Frente">
                            <?php foreach ($data['datos_sec']['frente'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-2">
                        <label for="Cejas" class="label-form">Cejas:</label>
                        <select class="custom-select custom-select-sm" id="Cejas" name="Cejas">
                            <?php foreach ($data['datos_sec']['cejas'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="tipoCejas" class="label-form">Tipo de Cejas:</label>
                        <select class="custom-select custom-select-sm" id="tipoCejas" name="tipoCejas">
                            <?php foreach ($data['datos_sec']['tipo_cejas'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-2">
                        <label for="colorOjos" class="label-form">Color de ojos:</label>
                        <select class="custom-select custom-select-sm" id="colorOjo" name="colorOjo">
                            <?php foreach ($data['datos_sec']['color_ojos'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="tamOjos" class="label-form">Tam. de ojos:</label>
                        <select class="custom-select custom-select-sm" id="tamOjos" name="tamOjos">
                            <?php foreach ($data['datos_sec']['tam_ojos'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-2">
                        <label for="formaOjos" class="label-form">Forma de ojos:</label>
                        <select class="custom-select custom-select-sm" id="formaOjos" name="formaOjos">
                            <?php foreach ($data['datos_sec']['forma_ojos'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-2">
                        <label for="Nariz" class="label-form">Nariz:</label>
                        <select class="custom-select custom-select-sm" id="Nariz" name="Nariz">
                            <?php foreach ($data['datos_sec']['nariz'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="tamBoca" class="label-form">Tam. de boca:</label>
                        <select class="custom-select custom-select-sm" id="tamBoca" name="tamBoca">
                            <?php foreach ($data['datos_sec']['tam_boca'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-2">
                        <label for="Labios" class="label-form">Labios:</label>
                        <select class="custom-select custom-select-sm" id="Labios" name="Labios">
                            <?php foreach ($data['datos_sec']['labios'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>

                    </div>

                    <div class="form-group col-lg-3">
                        <label for="Menton" class="label-form">Mentón:</label>
                        <select class="custom-select custom-select-sm" id="Menton" name="Menton">
                            <?php foreach ($data['datos_sec']['menton'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>

                    </div>

                    <div class="form-group col-lg-2">
                        <label for="tamOrejas" class="label-form">Tam. de orejas:</label>
                        <select class="custom-select custom-select-sm" id="tamOrejas" name="tamOrejas">
                            <?php foreach ($data['datos_sec']['tam_orejas'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-2">
                        <label for="Lobulos" class="label-form">Lóbulos:</label>
                        <select class="custom-select custom-select-sm" id="Lobulos" name="Lobulos">
                            <?php foreach ($data['datos_sec']['lobulos'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="Barba" class="label-form">Barba:</label>
                        <select class="custom-select custom-select-sm" id="Barba" name="Barba">
                            <?php foreach ($data['datos_sec']['barba'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>

                    </div>

                    <div class="form-group col-lg-2">
                        <label for="tamBarba" class="label-form">Tam. de barba:</label>
                        <select class="custom-select custom-select-sm" id="tamBarba" name="tamBarba">
                            <?php foreach ($data['datos_sec']['tam_barba'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="colorBarba" class="label-form">Color de barba:</label>
                        <select class="custom-select custom-select-sm" id="colorBarba" name="colorBarba">
                            <?php foreach ($data['datos_sec']['color_barba'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-2">
                        <label for="Bigote" class="label-form">Bigote:</label>
                        <select class="custom-select custom-select-sm" id="Bigote" name="Bigote">
                            <?php foreach ($data['datos_sec']['bigote'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-2">
                        <label for="tamBigote" class="label-form">Tam. de bigote:</label>
                        <select class="custom-select custom-select-sm" id="tamBigote" name="tamBigote">
                            <?php foreach ($data['datos_sec']['tam_bigote'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="colorBigote" class="label-form">Color de bigote:</label>
                        <select class="custom-select custom-select-sm" id="colorBigote" name="colorBigote">
                            <?php foreach ($data['datos_sec']['color_bigote'] as $item) : ?>
                                <option value="<?php echo $item->Valor_MF ?>"><?php echo $item->Valor_MF ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Se comento esta seccion para que ahora los elementos del contacto conocido
            esten siempre visilbles
        <div class="form-row mt-5">
            <fieldset class="form-group col-sm-12">
                <legend class="col-form-label pl-1">¿Se poseé información de algún conocido?</legend>
                <div class="container ml-1">
                    <div class="row">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="infoConocido" id="infoConocido1" value="No" checked onclick="showHide('infoConocido')">
                            <label class="form-check-label" for="infoConocido1">
                                No
                            </label>
                        </div>
                        <div class="form-check ml-5">
                            <input class="form-check-input" type="radio" name="infoConocido" id="infoConocido2" value="Si" onclick="showHide('infoConocido')">
                            <label class="form-check-label" for="infoConocido2">
                                Si
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        -->
        
        <!---Desde aqui -->
        <div class="col-sm-12" id="infoConocido">
        <p class="form_title mt-5">Información de conocidos: </p>
        <div class="alert alert-warning" role="alert" id="alertEditContacto" style="display: none">
            Está realizando edición a un elemento.
        </div>
            <div class="form-row mt-3">

                <div class="form-group col-lg-3">
                    <label for="parentezco" class="label-form">Tipo de relación:</label>
                    <select class="custom-select custom-select-sm" id="parentezco_conocido" name="parentezco_conocido">
                        <?php foreach ($data['datos_sec']['tipo_relacion'] as $item) : ?>
                            <option value="<?php echo $item->Parentezco ?>"><?php echo $item->Parentezco ?></option>
                        <?php endforeach ?>
                    </select>
                    <!-- se cambio el tipo de campo que indica algun error en el llenado del formulario -->
                    <div class="invalid-feedback align-items-center justify-content-center" id="parentezco_conocido-invalid">
                            El tipo de relación es requerido 
                    </div>
                </div>

                <div class="form-group col-lg-3">
                    <label for="Nombres" class="label-form">Nombres:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" name="Nombre_conocido" id="Nombre_conocido">
                    <div class="invalid-feedback align-items-center justify-content-center" id="Nombre_conocido-invalid">
                            El nombre del conocido es requerido
                    </div>
                </div>

                <div class="form-group col-lg-3">
                    <label for="appPaterno" class="label-form">Apellido paterno:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" name="apaterno_conocido" id="apaterno_conocido">
                    <div class="invalid-feedback align-items-center justify-content-center" id="apaterno_conocido-invalid">
                            El Apellido paterno es requerido 
                    </div>
                  <!--  <span class="span_error" id="apaterno_conocido_error"></span>-->
                </div>

                <div class="form-group col-lg-3">
                    <label for="appMaterno" class="label-form">Apellido materno:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" name="amaterno_conocido" id="amaterno_conocido">
                    <div class="invalid-feedback align-items-center justify-content-center" id="amaterno_conocido-invalid">
                            El Apellido materno es requerido 
                    </div>
                </div>

                <div class="form-group col-lg-4">
                    <label for="telefono" class="label-form">Teléfono:</label>
                    <input type="text" class="form-control form-control-sm" name="telefono_conocido" maxlength="10" id="telefono_conocido" onkeypress="return valideKey(event);">
                    <div class="invalid-feedback align-items-center justify-content-center" id="telefono_conocido-invalid">
                            El teléfono es requerido 
                    </div>
                </div>

                <div class="form-group col-lg-4">
                    <label for="Edad" class="label-form">Edad:</label>
                    <input type="text" class="form-control form-control-sm" name="edad_conocido" maxlength="2" id="edad_conocido" onkeypress="return valideKey(event);">
                    <div class="invalid-feedback align-items-center justify-content-center" id="edad_conocido-invalid">
                        La edad es requerido 
                    </div>
                </div>

                <div class="form-group col-lg-4">
                    <label for="Sexo" class="label-form">Sexo:</label>
                    <select class="custom-select custom-select-sm" name="sexo_conocido" id="sexo_conocido">
                        <option selected value="HOMBRE">HOMBRE</option>
                        <option value="MUJER">MUJER</option>
                    </select>
                    <div class="invalid-feedback align-items-center justify-content-center" id="sexo_conocido-invalid">
                            El sexo es requerido
                    </div>
                </div>
                <button type="button" class="btn btn-primary button-movil-plus" onclick="onFormContactoSubmit()">+</button>
            </div>
        </div>
        <!-- Se añade la tabla que mostrara la informacion de los contactos conocidos -->
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
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
        </div>
        <!-- Hasta aqui -->

    </form>

    <div class="row mt-5 mb-5">
        <div class="col-12 d-flex justify-content-between col-sm-12">
            <a class="btn btn-sm btn-ssc btn-tab-getIndex" data-id="9" id="btn-tab-getIndex-9" message="msg_mediaF">Validar</a>
            <div>
                <btn class="btn btn-sm btn-ssc" onclick="ValidarFiliacion()" id="btn_mediaF">Guardar</btn>
                <span class="advise-span text-center ml-2 mt-2 span-message" id="span-message-9">* Lo sentimos, el tab ha sido validado. Su usuario no tiene los permisos necesarios para editar</span>
            </div>
        </div>
    </div>
</div>