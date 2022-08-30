<div class="container">


    <form id="datos_peticionario" autocomplete="off">

        <div class="row mt-5">

            <div class="col-12 my-4" id="msg_peticionario"></div>
            <div class="col-lg-4 d-flex justify-content-start align-items-center">

                <?php
                $no_remision    = (isset($_GET['no_remision'])) ? $_GET['no_remision'] : '0';
                $no_ficha       = (isset($_GET['no_ficha'])) ? $_GET['no_ficha'] : '0';
                ?>


                <input type="hidden" name="no_remision_peticionario" id="no_remision_peticionario" value=<?= $no_remision ?>>
                <input type="hidden" name="no_ficha_peticionario" id="no_ficha_peticionario" value=<?= $no_ficha ?>>

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

            <div class="form-group col-lg-4 text-center mt-4">
                <label for="Nombres" class="label-form">Nombres:</label>
                <span class="valor-campo" name="peticionario_Nombres" id="peticionario_Nombres"></span <span class="span_error" id="peticionario_Nombres_error"></span>
            </div>

            <div class="form-group col-lg-4 text-center mt-4">
                <label for="appPaterno" class="label-form">Apellido paterno:</label>
                <span class="valor-campo" name="peticionario_appPaterno" id="peticionario_appPaterno"></span>
                <span class="span_error" id="peticionario_appPaterno_error"></span>
            </div>

            <div class="form-group col-lg-4 text-center mt-4">
                <label for="appMaterno" class="label-form">Apellido materno:</label>
                <span class="valor-campo" name="peticionario_appMaterno" id="peticionario_appMaterno"></span>
                <span class="span_error" id="peticionario_appMaterno_error"></span>
            </div>

            <div class="form-group col-lg-4 text-center mt-4">
                <label for="Edad" class="label-form">Edad:</label>
                <span class="valor-campo" name="peticionario_Edad" id="peticionario_Edad"></span>
                <span class="span_error" id="peticionario_Edad_error"></span>
            </div>

            <div class="form-group col-lg-4 text-center mt-4">
                <label for="Sexo" class="label-form">Sexo:</label>
                <span class="valor-campo" name="peticionario_Sexo" id="peticionario_Sexo"></span>
            </div>

            <div class="form-group col-lg-4 text-center4 mt-4">
                <label for="Escolaridad" class="label-form">Escolaridad:</label>
                <span class="valor-campo" name="peticionario_Escolaridad" id="peticionario_Escolaridad"></span>
            </div>

            <div class="form-group col-lg-4 mt-4 text-center">
                <label for="nacionalidad_pet" class="label-form">Nacionalidad:</label>
                <span class="valor-campo" id="nacionalidad_pet" name="nacionalidad_pet"></span>
            </div>

            <div class="form-group col-lg-4 mt-4 text-center">
                <label for="estadoMex_pet" class="label-form">Estado de procedencia:</label>
                <span class="valor-campo" id="estadoMex_pet" name="estadoMex_pet"></span>
            </div>

            <div class="form-group col-lg-6 text-center mt-4">
                <label for="Procedencia" class="label-form">Municipio de Procedencia:</label>
                <span class="valor-campo" name="peticionario_Procedencia" id="peticionario_Procedencia"></span>
                <span class="span_error" id="peticionario_Procedencia_error"></span>
            </div>

            <div class="form-group col-lg-6 text-center mt-4">
                <label for="Fecha_n" class="label-form">Fecha de nacimiento:</label>
                <span class="valor-campo" name="peticionario_Fecha_n" id="peticionario_Fecha_n"></span>
                <span class="span_error" id="peticionario_Fecha_n_error"></span>
            </div>

        </div>

        <div class="form-row mt-5">
            <div class="col-12 text-center">
                <p class="form_title">Domicilio: </p>
            </div>
            <div class="form-group col-lg-6 text-center">
                <label for="Colonia" class="label-form">Colonia:</label>
                <span class="valor-campo" id="Colonia_peticionario" name="Colonia_peticionario"></span>
                <span class="span_error" id="Colonia_peticionario_error"></span>
            </div>

            <div class="form-group col-lg-6 text-center">
                <label for="Calle" class="label-form">Calle:</label>
                <span class="valor-campo" id="Calle_peticionario" name="Calle_peticionario"></span>
                <span class="span_error" id="Calle_peticionario_error"></span>
            </div>

            <div class="form-group col-lg-3 text-center">
                <label for="noInterior" class="label-form">Núm. de Interior:</label>
                <span class="valor-campo" id="noInterior_peticionario" name="noInterior_peticionario"></span>
            </div>

            <div class="form-group col-lg-3 text-center">
                <label for="noExterior" class="label-form">Núm. de Exterior:</label>
                <span class="valor-campo" id="noExterior_peticionario" name="noExterior_peticionario"></span>
            </div>

            <div class="form-group col-lg-3 text-center">
                <label for="cordY" class="label-form">Coordenada Y:</label>
                <span class="valor-campo" id="cordY_peticionario" name="cordY_peticionario" readonly></span>
                <span class="span_error" id="cordY_peticionario_error"></span>
            </div>

            <div class="form-group col-lg-3 text-center">
                <label for="cordX" class="label-form">Coordenada X:</label>
                <span class="valor-campo" id="cordX_peticionario" name="cordX_peticionario" readonly></span>
                <span class="span_error" id="cordX_peticionario_error"></span>
            </div>

            <div class="form-group col-lg-6 mi_hide">
                <label for="Estado" class="label-form">Estado:</label>
                <span class="valor-campo" id="Estado_peticionario" name="Estado_peticionario"></span>
                <span class="span_error" id="Estado_peticionario_error"></span>
            </div>

            <div class="form-group col-lg-6 text-center">
                <label for="Municipio" class="label-form">Municipio:</label>
                <span class="valor-campo" id="Municipio_peticionario" name="Municipio_peticionario"></span>
                <span class="span_error" id="Municipio_peticionario_error"></span>
            </div>

            <div class="form-group col-lg-6 text-center">
                <label for="CP_peticionario" class="label-form">Código Postal:</label>
                <span class="valor-campo" id="CP_peticionario" name="CP_peticionario"></span>
                <span class="span_error" id="CP_peticionario_error"></span>
            </div>
        </div>


        
            <div class="row mt-5 mb-5">
                <div class="col-12 d-flex justify-content-center col-sm-12">
                    <a class="btn btn-sm btn-ssc" href="<?= base_url;?>Remisiones">Volver al inicio</a>
                </div>
            </div>
        


    </form>
</div>