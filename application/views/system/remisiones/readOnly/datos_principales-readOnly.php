<div class="container center-all">
    <?php
        $no_remision    = (isset($_GET['no_remision'])) ? $_GET['no_remision'] : '0';
        $no_ficha       = (isset($_GET['no_ficha'])) ? $_GET['no_ficha'] : '0';
    ?>

    <input type="hidden" name="no_remision_principales" id="no_remision_principales" value=<?= $no_remision ?>>
    <input type="hidden" name="no_ficha_principales" id="no_ficha_principales" value=<?= $no_ficha ?>>
    <div class="row mt-5">

        <div class="col-12 my-4" id="msg_principales"></div>

        <div class="col-lg-3 col-sm-12 d-flex justify-content-start align-items-center">
            <span class="span_rem">Núm. Remisión/Oficio: </span>
            <span class="span_rem_ans" name="oficio_principales" id="oficio_principales"></span>
        </div>

        <div class="col-lg-3 col-sm-12 d-flex justify-content-end align-items-center">
            <span class="span_rem">Folio 911: </span>
            <span class="span_error" id="911_principalesError"></span>
            <span class="span_rem_ans" name="911_principales" id="911_principales"></span>
        </div>

        <div class="col-lg-3 col-sm-12 d-flex justify-content-end align-items-center">
            <span class="span_rem">Fecha: </span>
            <span class="span_error" id="fechaP_error"></span>
            <span class="span_rem_ans" name="fecha_principales" id="fecha_principales"></span>
        </div>

        <div class="col-lg-3 col-sm-12 d-flex justify-content-end align-items-center">
            <span class="span_rem">Hora:</span>
            <span class="span_error" id="hora_error"></span>
            <span class="span_rem_ans" name="hora_principales" id="hora_principales"></span>
        </div>
    </div>

    <div class="form-row mt-5 ">
        <!-- Se hizo invisible el tipo de ficha porque siempre sera policia -->
        <fieldset class="form-group col-lg-12 text-center" style="display:none">
            <span class="label-form">Tipo ficha:</span>
            <span class="valor-campo ml-2" style="display: inline;" id="tipo_ficha"></span>
        </fieldset>
        <div class="form-group col-lg-4 text-center" id="zonaContent">
            <label for="zona" class="label-form">Zona:</label>
            <span class="valor-campo" id="zona" name="zona"></span>
            <span class="span_error" id="zona_error"></span>
        </div>
        <!-- <div class="form-group col-lg-4 text-center" id="sectorContent">
            <label for="Sector" class="label-form">Sector:</label>
            <span class="valor-campo" id="sector" name="sector"></span>
            <p class="span_error" id="sector_error"></p>
        </div> -->
        <div class="form-group col-lg-4 text-center">
            <label for="CIA_principales" class="label-form">CIA:</label>
            <span class="valor-campo" id="CIA_principales" name="CIA_principales"></span>
            <span class="span_error" id="cia_error"></span>
        </div>
        <div class="form-group col-lg-4 text-center">
            <label for="Remitido" class="label-form">Remitido a:</label>
            <span class="valor-campo" id="Remitido" name="Remitido"></span>
            <span class="span_error" id="remitido_error"></span>
        </div>



        <div class="form-group col-lg-4 pl-6 text-center mt-3">
            <label for="Status" class="label-form">Estatus: </label>
            <span class="valor-campo" id="statusR_principales" name="statusR_principales"></span>
        </div>
        <div class="form-group col-lg-4 pl-6 text-center mt-3">
            <label for="Status" class="label-form">Estatus Ficha: </label>
            <span class="valor-campo" id="statusFICHA_principales" name="statusFICHA_principales"></span>
        </div>
        <!--<div class="form-group col-lg-6">
                <label for="Averiguacion_principales" class="label-form">Carpeta de investigación</label>
                <input type="text" class="form-control form-control-sm" id="Averiguacion_principales">
                <span class="span_error" id="carpeta_error"></span>
            </div>-->



        <div class="form-group col-lg-4 text-center text-center mt-3">
            <span class="span_rem">Núm. Ficha: </span>
            <span class="span_rem_ans ml-2" name="oficio_principales"><?php echo $_GET['no_ficha']; ?></span>
        </div>

        <div class="form-group col-lg-4 mt-3 text-center">
            <label for="Nombre_principales" class="label-form text-center">Nombres:</label>
            <span class="valor-campo text-center" id="Nombre_principales" name="Nombre_principales"></span>
            <span class="span_error" id="Nombre_principales_error"></span>
        </div>

        <div class="form-group col-lg-4 mt-3 text-center">
            <label for="appPaterno_principales" class="label-form">Apellido paterno:</label>
            <span class="valor-campo" id="appPaterno_principales" name="appPaterno_principales"></span>
            <span class="span_error" id="appPaterno_principales_error"></span>
        </div>

        <div class="form-group col-lg-4 mt-3 text-center">
            <label for="appMaterno_principales" class="label-form">Apellido materno:</label>
            <span class="valor-campo" id="appMaterno_principales" name="appMaterno_principales"></span>
            <span class="span_error" id="appMaterno_principales_error"></span>
        </div>

        <div class="form-group col-lg-2 mt-4 text-center">
            <label for="edad_principales" class="label-form">Edad:</label>
            <span class="valor-campo" id="edad_principales" name="edad_principales" maxlength="2"></span>
            <span class="span_error" id="edad_principales_error"></span>
        </div>

        <div class="form-group col-lg-2 mt-4 text-center">
            <label for="sexo_principales" class="label-form">Sexo:</label>
            <span class="valor-campo" id="sexo_principales" name="sexo_principales"></span>
            <span class="span_error" id="sexo_principales_error"></span>
        </div>

        <div class="form-group col-lg-4 mt-4 text-center">
            <label for="escolaridad_principales" class="label-form">Escolaridad:</label>
            <span class="valor-campo" id="escolaridad_principales" name="escolaridad_principales"><span>
            <span class="span_error" id="escolaridad_principales_error"></span>
        </div>

        <div class="form-group col-lg-4 mt-4 text-center">
            <label for="nacionalidad_principales" class="label-form">Nacionalidad:</label>
            <span class="valor-campo" id="nacionalidad_principales" name="nacionalidad_principales"></span>
        </div>
        
        <div class="form-group col-lg-4 mt-4 text-center">
            <label for="estadoMex_principales" class="label-form">Estado de procedencia:</label>
            <span class="valor-campo" id="estadoMex_principales" name="estadoMex_principales"></span>
        </div>

        <div class="form-group col-lg-4 mt-4 text-center">
            <label for="procedencia_principales" class="label-form">Municipio de Procedencia:</label>
            <span class="valor-campo" id="procedencia_principales" name="procedencia_principales"></span>
            <span class="span_error" id="procedencia_principales_error"></span>
        </div>

        <div class="form-group col-lg-4 mt-4 text-center">
            <label for="CURP_principales" class="label-form">CURP:</label>
            <span class="valor-campo" id="CURP_principales" name="CURP_principales"></span>
            <span class="span_error" id="CURP_principales_error"></span>
        </div>

        <div class="form-group col-lg-3 mt-4 d-flex justify-content-center align-items-end">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" class="custom-control-input" id="verificado_principales" name="verificado_principales" value="1" disabled>
                <label class="custom-control-label" for="verificado_principales" style="font-size: 14px;">Información verificada</label>
            </div>
        </div>

        <div class="form-group col-lg-2 mt-4 d-flex justify-content-center align-items-end">
            <a href="javascript:ventanaSecundaria('https://www.gob.mx/curp/')" class="url">Consulta curp</a>
        </div>

        <div class="form-group col-lg-3 d-flex justify-content-center align-items-end">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" class="custom-control-input" id="alcoholemia_principales" name="alcoholemia_principales" value="1" disabled>
                <label class="custom-control-label" for="alcoholemia_principales" style="font-size: 14px;">Presunción de intoxicación</label>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="col-12 text-center">
                <p class="form_title">Domicilio: </p>
            </div>
            
            <div class="form-row mt-3">

                <div class="form-group col-lg-6 text-center">
                    <label for="Colonia" class="label-form">Colonia:</label>
                    <span class="valor-campo" id="Colonia" name="Colonia"></span>
                    <span class="span_error" id="Colonia_principales_error"></span>

                </div>

                <div class="form-group col-lg-6 text-center">
                    <label for="Calle" class="label-form">Calle:</label>
                    <span class="valor-campo" id="Calle" name="Calle"></span>
                    <span class="span_error" id="Calle_principales_error"></span>

                </div>

                <div class="form-group col-lg-3 mt-4 text-center">
                    <label for="noInterior" class="label-form">Núm. de Interior:</label>
                    <span class="valor-campo" id="noInterior" name="noInterior"></span>
                </div>

                <div class="form-group col-lg-3 mt-4 text-center">
                    <label for="noExterior" class="label-form">Núm. de Exterior:</label>
                    <span class="valor-campo" id="noExterior" name="noExterior"></span>
                    <span class="span_error" id="noExterior_principales_error"></span>

                </div>

                <div class="form-group col-lg-3 mt-4 text-center">
                    <label for="cordY" class="label-form">Coordenada Y:</label>
                    <span class="valor-campo" id="cordY" name="cordY"></span>
                    <span class="span_error" id="cordY_principales_error"></span>
                </div>

                <div class="form-group col-lg-3 mt-4 text-center">
                    <label for="cordX" class="label-form">Coordenada X:</label>
                    <span class="valor-campo" id="cordX" name="cordX"></span>
                    <span class="span_error" id="cordX_principales_error"></span>
                </div>

                <div class="form-group col-lg-6 mi_hide">
                    <label for="Estado" class="label-form">Estado:</label>
                    <input class="form-control form-control-sm" id="Estado" name="Estado">
                    <span class="span_error" id="Estado_principales_error"></span>

                </div>

                <div class="form-group col-lg-6 mt-4 text-center">
                    <label for="Municipio" class="label-form">Municipio:</label>
                    <span type="text" class="valor-campo" id="Municipio" name="Municipio"></span>
                    <span class="span_error" id="Municipio_principales_error"></span>
                </div>

                <div class="form-group col-lg-6 mt-4 text-center">
                    <label for="CP" class="label-form">Código Postal:</label>
                    <span type="text" class="valor-campo" id="CP" name="CP"></span>
                    <span class="span_error" id="CP_principales_error"></span>
                </div>
            </div>
        </div>


    </div>


    <div class="form-row mt-5">

        <div class="form-group col-lg-12 mi_hide">
            <label for="pertenencias_rem" class="label-form">Pertenencias del remitido:</label>
            <textarea class="form-control" id="pertenencias_rem" name="pertenencias_rem" rows="6" maxlength="200"></textarea>
            <span class="span_error" id="pertenencias_rem_error"></span>
        </div>




        <div class="mt-5 col-12 text-center">
            <p class="label-form ml-2 form_title"> Datos adicionales: </p>
        </div>
    </div>


    <div class="form-row mt-3" id="ext_1">
        <div class="form-group col-lg-4 text-center">
            <label for="Fecha_n" class="label-form">Fecha de nacimiento:</label>
            <span class="valor-campo" id="FechaNacimiento_principales" name="FechaNacimiento_principales"></span>
            <span class="span_error" id="FechaNacimiento_principales_error"></span>
        </div>

        <div class="form-group col-lg-4 text-center">
            <label for="RFC" class="label-form">RFC:</label>
            <span class="valor-campo" id="RFC_principales" name="RFC_principales"></span>
            <span class="span_error" id="RFC_principales_error"></span>
        </div>

        <div class="form-group col-lg-4 text-center">
            <label for="Correo" class="label-form">Correo:</label>
            <span class="valor-campo" id="correo_principales" name="correo_principales"></span>
            <span class="span_error" id="correo_principales_error"></span>
        </div>


        <div class="form-group col-lg-4 text-center mt-4">
            <label for="Ocupacion" class="label-form">Ocupación:</label>
            <span class="valor-campo" id="Ocupacion_principales" name="Ocupacion_principales"></span>
            <span class="span_error" id="Ocupacion_principales_error"></span>
        </div>

        <div class="form-group col-lg-4 text-center mt-4">
            <label for="Facebook" class="label-form">Facebook:</label>
            <span class="valor-campo" id="Facebook_principales" name="Facebook_principales"></span>
            <span class="span_error" id="Facebook_principales_error"></span>
        </div>

        <div class="form-group col-lg-4 text-center mt-4">
            <label for="edoCivil" class="label-form">Estado Civil:</label>
            <span class="valor-campo" id="edoCivil_principales" name="edoCivil_principales"></span>
        </div>

        <div class="form-group col-lg-4 text-center mt-4">
            <label for="Telefono" class="label-form">Teléfono:</label>
            <span class="valor-campo" id="Telefono_principales" name="Telefono_principales"></span>
            <span class="span_error" id="Telefono_principales_error"></span>
        </div>

        <div class="form-group col-lg-4 text-center mt-4">
            <label for="imei_1" class="label-form">IMEI 1:</label>
            <span class="valor-campo" id="imei_1_principales" name="imei_1_principales" "></span>
                <span class=" span_error" id="imei_1_principales_error"></span>
        </div>

        <div class="form-group col-lg-4 text-center mt-4">
            <label for="imei_2" class="label-form">IMEI 2 (Opcional):</label>
            <span class="valor-campo" id="imei_2_principales" name="imei_2_principales"></span>
            <span class="span_error" id="imei_2_principales_error"></span>
        </div>
    </div>




    <div class="form-group col-lg-12 text-center mt-4 mb-5">
        <label for="Alias" class="label-form">Alias:</label>

        <span class="valor-campo" id="Alias" name="Alias"><span>
                <span class="span_error" id="pertenencias_rem_error"></span>

    </div>



    <!--<div class="col-lg-6">
                <div id="contenido"></div>
            </div> -->



    <div class="row mt-5 mb-5">
        <div class="d-flex justify-content-center col-sm-12">
            <a class="btn btn-sm btn-ssc" href="<?= base_url;?>Remisiones">Volver al inicio</a>
        </div>
    </div>


</div>