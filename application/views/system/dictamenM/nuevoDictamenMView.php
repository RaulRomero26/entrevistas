<?php

    $infoRem = (isset($data['info_remision']))?$data['info_remision']:false; //se separa la información de la remisión en una variable aparte
?>
<div class="container mt-5 mb-3">
    <!--header of dictamen-->
    <div class="row">
        <div class="col-auto mr-auto my-auto">
            <h5 class="title-width my-auto">
                <a href="<?= base_url;?>DictamenMedico">Constancia de Integridad Física</a> 
                <span class="navegacion">/ Nuevo</span>
            </h5>
        </div>
        <div class="col-auto my-auto">
            <span class="title-width"> Folio: </span>
            <span><?= ($infoRem)?$infoRem->Id_Dictamen:'nuevo'?></span>
            <input form="id_form_dictamen" type="hidden" name="Id_Dictamen" id="id_dictamen" value="<?= ($infoRem)?$infoRem->Id_Dictamen:''?>" readonly>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12 mi_hide" id="id_error_panel">
            <div class="alert alert-danger" role="alert"id="id_error_alert" >
            </div>
        </div>
        <div class="col-12 mi_hide" id="id_success_panel">
            <div class="alert alert-success" role="alert" id="id_success_alert">
            </div>
        </div>
    </div>
    <!-- Input Folio de Dictamen
    <div class="row mt-1">
        <div class="col-6 col-md-3">
            <label for="id_dictamen_aux" class="label-form">Folio (editar en caso de ser necesario):</label>
            <input type="text" class="form-control form-control-sm text-uppercase" id="id_dictamen_aux" name="Id_Dictamen_Aux" value="<?= ($infoRem)?$infoRem->Id_Dictamen:''?>" >
            <small id="error_id_dictamen_aux" class="form-text text-danger "></small>
        </div>
            
    </div> -->
    <!--Fecha hora e instancia-->
    <div class="row mt-2">
        <div class="col-6 col-md-auto mr-md-auto my-md-auto d-flex align-items-center mb-3 mb-md-0">
            <div class="row">
                <div class="col-auto my-auto">
                    <span class="label1">Fecha: </span>
                </div>
                <div class="col-auto">
                    <input form="id_form_dictamen" type="date" class="form-control custom-input_dt" value="<?php echo date('Y-m-d') ?>" id="id_fecha_dictamen" name="Fecha_Dictamen">
                    <small id="error_fecha_dictamen" class="form-text text-danger "></small>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-auto mx-md-auto my-md-auto d-flex align-items-center mb-3 mb-md-0">
            <div class="row">
                <div class="col-auto my-auto">
                    <span class="label1">Hora:</span>
                </div>
                <div class="col-auto">
                    <input form="id_form_dictamen" type="time" class="form-control custom-input_dt" value="<?php echo date('H:i') ?>" id="id_hora_dictamen" name="Hora_Dictamen">
                    <small id="error_hora_dictamen" class="form-text text-danger "></small>
                </div>
            </div>   
        </div>

        <div class="col-12 col-md-auto my-auto">
            <div class="form-group row my-auto ml-auto">
                <div class="form-check col-auto">
                  <span  > Remitido a: </span>
                </div>
                <div class="form-check col-auto">
                    <select form="id_form_dictamen" class="form-control form-control-sm" id="id_instancia" name="Instancia" onchange="return changeInstancia(event)">
                        <option <?= (isset($infoRem->Instancia) && $infoRem->Instancia == "MINISTERIO PÚBLICO")?'selected':'';?> value="MINISTERIO PÚBLICO">MINISTERIO PÚBLICO</option>
                        <option <?= (isset($infoRem->Instancia) && $infoRem->Instancia == "JUEZ DE JUSTICIA CÍVICA")?'selected':'';?> value="JUEZ DE JUSTICIA CÍVICA">JUEZ DE JUSTICIA CÍVICA</option>
                        <option <?= (isset($infoRem->Instancia) && $infoRem->Instancia == "ASUNTOS INTERNOS")?'selected':'';?> value="ASUNTOS INTERNOS">ASUNTOS INTERNOS</option>
                    </select>
                    <small id="error_instancia" class="form-text text-danger "></small>
                </div>
            </div>   
        </div>
    </div>

    <!--formulario completo-->
    <form id="id_form_dictamen" class="row" method="post" action="">

        <!--DATOS GENERALES del detenido-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-5 mb-2">
                    <div class="text-divider">
                        <h5>Datos generales del examinado</h5>
                    </div>
                </div>

                <div class="form-group col-12 col-md-3 col-lg-3">
                    <label for="id_nombre" class="label-form">Nombre(s):</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_nombre" name="Nombre" value="<?= ($infoRem)?$infoRem->Nombre:''?>"  required>
                    <small id="error_nombre" class="form-text text-danger "></small>
                </div>
                <div class="form-group col-12 col-md-2 col-lg-2">
                    <label for="id_ap_paterno" class="label-form">Apellido paterno:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_ap_paterno" name="Ap_Paterno" value="<?= ($infoRem)?$infoRem->Ap_Paterno:''?>"  required>
                    <small id="error_ap_pat" class="form-text text-danger "></small>
                </div>
                <div class="form-group col-12 col-md-2 col-lg-2">
                    <label for="id_ap_materno" class="label-form">Apellido materno:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_ap_materno" name="Ap_Materno" value="<?= ($infoRem)?$infoRem->Ap_Materno:''?>"  required>
                    <small id="error_ap_mat" class="form-text text-danger "></small>
                </div>

                <div class="form-group col-4 col-md-2 col-lg-1">
                    <label for="id_edad" class="label-form">Edad:</label>
                    <input class="form-control form-control-sm text-uppercase" type="text" id="id_edad" name="Edad" onkeypress="return soloNumeros(event)" maxlength = "2" value="<?= ($infoRem)?$infoRem->Edad:''?>"  required>
                    <small id="error_edad" class="form-text text-danger "></small>
                </div>

                <div class="form-group col-8 col-md-3 col-lg-4">
                    <label for="id_ocupacion" class="label-form">Ocupación:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_ocupacion" name="Ocupacion" value="<?= (isset($infoRem->Ocupacion))?$infoRem->Ocupacion:'';?>"  required>            
                    <small id="error_ocupacion" class="form-text text-danger "></small>
                </div>

                <div class="form-group col-12 col-md-8">
                    <label for="id_domicilio" class="label-form">Domicilio personal:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_domicilio" name="Domicilio" value="<?= ($infoRem)?$infoRem->Domicilio:''?>"  required >
                    <small id="error_domicilio" class="form-text text-danger "></small>
                </div>

                <!-- <div class="form-group col-6 col-md-4">
                    <label for="id_genero" class="label-form">Sexo:</label>
                    <input type="text" class="form-control form-control-sm text-uppercase" id="id_genero" name="Genero" value="<?= (mb_strtoupper($infoRem->Genero) == 'H')?'HOMBRE':'MUJER';?>"  required>
                </div> -->
                <div class="form-group col-6 col-md-4">
                    <label for="id_genero" class="label-form">Sexo:</label>
                    <select class="form-control form-control-sm" id="id_genero" name="Genero" required>
                        <option <?= (isset($infoRem->Genero) && (mb_strtoupper($infoRem->Genero) == "H"))?'selected':'';?> value="H">HOMBRE</option>
                        <option <?= (isset($infoRem->Genero) && (mb_strtoupper($infoRem->Genero) == "M"))?'selected':'';?> value="M">MUJER</option>
                    </select>
                    <small id="error_genero" class="form-text text-danger "></small>
                </div>
                
            </div>
        </div>
                
        <!--ANTECEDENTES del detenido-->
        <div class="col-12 col-lg-6">
            <div class="row">
                <div class="col-12 text-center mt-3 mb-2">
                    <div class="text-divider">
                        <h5>Antecedentes</h5>
                    </div>
                </div>
                <!--Padece enfermedades?-->
                <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                            <span>¿Padece enfermedades?</span>
                        </div>
                        <div class="col-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Padece_Si_No" id="id_enf_pad_1" value="1" onchange="return changePadeceEnfermedades(event)" >
                                <label class="form-check-label" for="id_enf_pad_1">Si</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Padece_Si_No" id="id_enf_pad_2" value="0" onchange="return changePadeceEnfermedades(event)" >
                                <label class="form-check-label" for="id_enf_pad_2">No</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <small id="error_padece_si_no" class="form-text text-danger"></small>
                        </div>
                        
                    </div>
                    <div class="row mt-2 mi_hide" id="id_enfermedades_padece_panel">
                        <div class="col-auto my-auto">
                            <span class="label-form">¿Cuál(es)? </span>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_enfermedades_padece" name="Enfermedades_Padece" value="" disabled>
                            <small id="error_enfermedades_padece" class="form-text text-danger "></small>
                        </div>
                    </div>
                </div>
                <!--Toma medicamentos?-->
                <div class="col-12">
                    <div class="row mt-3">
                        <div class="col-6">
                            <span>¿Toma medicamentos?</span>
                        </div>
                        <div class="col-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Medic_Si_No" id="id_medic_1" value="1" onchange="return changeTomaMedic(event)">
                                <label class="form-check-label" for="id_medic_1">Si</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Medic_Si_No" id="id_medic_2" value="0" onchange="return changeTomaMedic(event)" >
                                <label class="form-check-label" for="id_medic_2">No</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <small id="error_medic_si_no" class="form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="row mt-2 mi_hide" id="id_toma_medicamentos_panel">
                        <div class="col-auto my-auto">
                            <span class="label-form">¿Cuál(es)? </span>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control form-control-sm text-uppercase" id="id_toma_medicamentos" name="Medicamentos_Toma" value="" disabled>
                            <small id="error_toma_medicamentos" class="form-text text-danger "></small>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!--PRUEBAS REALIZADAS-->
		<div class="col-12 col-lg-6">
            <div class="row">
                <div class="col-12 text-center mt-3 mb-2">
                    <div class="text-divider">
                        <h5>Pruebas realizadas</h5>
                    </div>
                </div>

                <div class="col-12">
                    <!--Alcoholímetro-->
                    <div class="row">
                        <div class="col-6">
                            <span>Alcoholímetro: </span>
                        </div>
                        <div class="col-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Prueba_Alcoholimetro" id="id_prueba_alcohol_si" value="1">
                                <label class="form-check-label" for="id_prueba_alcohol_si">Si</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Prueba_Alcoholimetro" id="id_prueba_alcohol_no" value="0">
                                <label class="form-check-label" for="id_prueba_alcohol_no">No</label>
                            </div>
                        </div>
                        <small id="error_pruebas_1" class="form-text text-danger text-center col-12 mb-3"></small>
                    </div>
                    <!--Multitestdrog-->
                    <div class="row">
                        <div class="col-6">
                            <span>Multitestdrog: </span>
                        </div>
                        <div class="col-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Prueba_Multitestdrog" id="id_prueba_multi_si" value="1">
                                <label class="form-check-label" for="id_prueba_multi_si">Si</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Prueba_Multitestdrog" id="id_prueba_multi_no" value="0">
                                <label class="form-check-label" for="id_prueba_multi_no">No</label>
                            </div>
                        </div>
                        <small id="error_pruebas_2" class="form-text text-danger text-center col-12 mb-3"></small>
                    </div>
                    <!--Clínica-->
                    <div class="row">
                        <div class="col-6">
                            <span>Clínica: </span>
                        </div>
                        <div class="col-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Prueba_Clinica" id="id_prueba_clinica_si" value="1" >
                                <label class="form-check-label" for="id_prueba_clinica_si">Si</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Prueba_Clinica" id="id_prueba_clinica_no" value="0" >
                                <label class="form-check-label" for="id_prueba_clinica_no">No</label>
                            </div>
                        </div>
                        <small id="error_pruebas_3" class="form-text text-danger text-center col-12 mb-3"></small>
                    </div>
                </div>
            </div>
        </div>

        <!--INTERROGATORIO-->
        <div class="col-12 mt-3">
            <div class="row">
                <div class="col-12 text-center mt-3 mb-2">
                    <div class="text-divider">
                        <h5>Interrogatorio</h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <!--coopera interrogatorio?-->
                <div class="col-10 col-md-auto mx-auto d-flex justify-content-center">
                    <div class="row">
                        <div class="col-8">
                            <span class="label-form">¿Coopera con el interrogatorio?</span>
                        </div>
                        <div class="col-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Coopera_Interrogatorio" id="id_coopera_1" value="1" >
                                <label class="form-check-label" for="id_coopera_1">Si</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Coopera_Interrogatorio" id="id_coopera_2" value="0" >
                                <label class="form-check-label" for="id_coopera_2">No</label>
                            </div>
                        </div>
                        <small id="error_coopera" class="form-text text-danger text-center mt-3 col "></small>
                    </div>
                </div>
                <!--consumió sustancia?-->
                <div class="col-10 col-md-auto mx-auto d-flex justify-content-center">
                    <div class="row">
                        <div class="col-8">
                            <span class="label-form">¿Consumió alguna sustancia?</span>
                        </div>
                        <div class="col-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Consumio_Si_No" id="id_consumio_1" value="1" onchange="changeConsumio(event)" >
                                <label class="form-check-label" for="id_consumio_1">Si</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Consumio_Si_No" id="id_consumio_2" value="0" onchange="changeConsumio(event)" >
                                <label class="form-check-label" for="id_consumio_2">No</label>
                            </div>
                        </div>
                        <small id="error_consumio" class="form-text text-danger text-center mt-3 col "></small>
                    </div>
                </div>
                <!--Panel consumió sustancia-->
                <div class="col-12 mt-3">
                    <div class="row mi_hide" id="id_consumio_panel">
                        <div class="col-12 col-md-auto mx-auto mt-3">
                            <div class="row">
                                <div class="col-12 col-md-auto text-center">
                                    <span class="label-form">Indique la sustancia consumida</span>
                                </div>

                                <div class="form-check col-auto mx-auto custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input sustancia_check" id="id_sustancia_1" value="Alcohol" name="Sustancia_Consumida[]" >
                                    <label class="custom-control-label" for="id_sustancia_1">Alcohol</label>
                                    
                                </div>
                                <div class="form-check col-auto mx-auto custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input sustancia_check" id="id_sustancia_2" value="Droga" name="Sustancia_Consumida[]" >
                                    <label class="custom-control-label" for="id_sustancia_2">Droga</label>
                                    
                                </div>
                                <div class="form-check col-auto mx-auto custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input sustancia_check" id="id_sustancia_3" value="Inhalantes" name="Sustancia_Consumida[]" >
                                    <label class="custom-control-label" for="id_sustancia_3">Inhalantes</label>
                                    
                                </div>

                            </div>
                            <small id="error_sustancia" class="form-text text-danger text-center mt-3 col "></small>
                        </div>
                        <div class="col-12 mt-4">
                            <div class="row">

                                <div class="col-12 col-md-auto mx-auto form-group">
                                    <div class="row">
                                        
                                        <div class="col-auto ml-auto my-auto">
                                            <span class="label-form">Fecha consumo </span>
                                        </div>
                                        <div class="col-auto mr-auto">
                                            <input type="date" class="form-control form-control-sm" value="" id="id_fecha_consumo" name="Fecha_Consumo">
                                        </div>
                                    </div>
                                    <small id="error_fecha_consumo" class="form-text text-danger text-center mt-3 col "></small>
                                    <!-- reinicio button -->
                                    <button type="button" class="btn btn-sm btn-reinicio" id="id_fecha_reinicio">
                                        Reiniciar fecha
                                    </button>      
                                </div>
                                <div class="col-12 col-md-auto mx-auto form-group">
                                    <div class="row">
                                        <div class="col-auto ml-auto my-auto">
                                            <span class="label-form">Hora inicio consumo </span>
                                        </div>
                                        <div class="col-auto mr-auto">
                                            <input type="time" class="form-control form-control-sm" value="" id="id_hora_consumo" name="Hora_Consumo">
                                        </div>
                                    </div>
                                    <small id="error_hora_consumo" class="form-text text-danger text-center mt-3 col "></small>
                                    <!-- reinicio button -->
                                    <button type="button" class="btn btn-sm btn-reinicio" id="id_hora_reinicio">
                                        Reiniciar hora
                                    </button>   
                                </div>
                                
                                <div class="col-8 col-md-auto mx-auto form-group">
                                    <div class="row">
                                        <div class="col-auto mx-auto my-auto">
                                            <span class="label-form">Cantidad consumida </span>
                                        </div>
                                        <div class="col-auto mx-auto my-auto">
                                            <input type="text" name="Cantidad_Consumida" id="id_cantidad_consumida" class="form-control form-control-sm text-uppercase" placeholder="Cantidad consumida" value="">
                                        </div>
                                    </div>
                                    <small id="error_cantidad_consumo" class="form-text text-danger text-center mt-3 col "></small>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>   
        </div>
			
        <!--INTOXICACIÓN ETÍLICA-->
        <div class="col-12 mt-4">
            <div class="row">
                <div class="col-12 text-center mt-3 mb-2">
                    <div class="text-divider">
                        <h5>Intoxicación Etílica</h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-md-auto mx-auto mt-4 mt-md-0 ">
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input intoxicacion_check" id="alientoa" name="Intoxicacion_Etilica[]" value="0" >
                                <label class="custom-control-label" for="alientoa">Aliento alcohólico</label>
                            </div>
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input intoxicacion_check" id="rfacial" name="Intoxicacion_Etilica[]" value="1" >
                                <label class="custom-control-label" for="rfacial">Rubor facial</label>
                            </div>
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input intoxicacion_check" id="euforia" name="Intoxicacion_Etilica[]" value="2" >
                                <label class="custom-control-label" for="euforia">Euforia</label>
                            </div>
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input intoxicacion_check" id="estupor" name="Intoxicacion_Etilica[]" value="3" >
                                <label class="custom-control-label" for="estupor">Estupor</label>
                            </div>
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input intoxicacion_check" id="adisc" name="Intoxicacion_Etilica[]" value="4" >
                                <label class="custom-control-label" for="adisc">Actitud discutiría</label>
                            </div>
                        </div>
                            
                    </div>
                    
                </div>
                <div class="col-6 col-md-auto mx-auto mt-4 mt-md-0 ">
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input intoxicacion_check" id="exagerac" name="Intoxicacion_Etilica[]" value="5" >
                                <label class="custom-control-label" for="exagerac">Exageración de la conducta</label>
                            </div>
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input intoxicacion_check" id="incoorl" name="Intoxicacion_Etilica[]" value="6" >
                                <label class="custom-control-label" for="incoorl">Incoordinación leve</label>
                            </div>
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input intoxicacion_check" id="afecth" name="Intoxicacion_Etilica[]" value="7" >
                                <label class="custom-control-label" for="afecth">Afectación del habla</label>
                            </div>
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input intoxicacion_check" id="hablate" name="Intoxicacion_Etilica[]" value="8" >
                                <label class="custom-control-label" for="hablate">Habla en tono elevado</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-auto mx-auto mt-4 mt-md-0 ">
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input intoxicacion_check" id="actitudag" name="Intoxicacion_Etilica[]" value="9" >
                                <label class="custom-control-label" for="actitudag">Actitud agresiva</label>
                            </div>
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input intoxicacion_check" id="conductai" name="Intoxicacion_Etilica[]" value="10" >
                                <label class="custom-control-label" for="conductai">Conducta irresponsable</label>
                            </div>
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input intoxicacion_check" id="difedp" name="Intoxicacion_Etilica[]" value="11" >
                                <label class="custom-control-label" for="difedp">Dificultad al estar de pie</label>
                            </div>
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input intoxicacion_check" id="semueveca" name="Intoxicacion_Etilica[]" value="12" >
                                <label class="custom-control-label" for="semueveca">Se mueve con ayuda</label>
                            </div>
                        </div>
                            
                    </div>
                </div>

            </div>
        </div>

        <!--NIVEL DE CONCIENCIA-->
        <div class="col-12 mt-4">
            <div class="row">
                <div class="col-12 mi_align">
                    <div class="text-divider">
                        <h5>Nivel de conciencia</h5>
                    </div>
                </div>
            </div>

            <div class="row">
                <!--ESTADO DE CONCIENCIA-->
                <div class="col-6 col-md-auto mx-auto mt-4 mt-md-0">
                    <div class="row">
                        <div class="col-12 mi_align">
                            <h6>Estado de conciencia</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Estado_Conciencia" id="id_edo_cons_1" value="Normal" >
                                <label class="form-check-label" for="id_edo_cons_1">Normal</label>
                            </div>
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Estado_Conciencia" id="id_edo_cons_2" value="Aletargado" >
                                <label class="form-check-label" for="id_edo_cons_2">Aletargado</label>
                                <small id="error_edo_cons" class="form-text text-danger"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <!--ORIENTACIÓN-->
                <div class="col-6 col-md-auto mx-auto mt-4 mt-md-0">
                    <div class="row">
                        <div class="col-12 mi_align">
                            <h6>Orientación</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input" id="id_orient_1" value="2" name="Orientacion[]" >
                                <label class="custom-control-label" for="id_orient_1">Persona</label>
                            </div>
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input" id="id_orient_2" value="1" name="Orientacion[]" >
                                <label class="custom-control-label" for="id_orient_2">Tiempo</label>
                            </div>
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input" id="id_orient_3" value="0" name="Orientacion[]" >
                                <label class="custom-control-label" for="id_orient_3">Espacio</label>
                            </div>
                        </div> 
                    </div>
                </div>
                <!--ACTITUD-->
                <div class="col-6 col-md-auto mx-auto mt-4 mt-md-0">
                    <div class="row">
                        <div class="col-12 mi_align">
                            <h6>Actitud</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Actitud" id="id_actitud_1" value="Agresiva"              >
                                <label class="form-check-label" for="id_actitud_1">Agresiva</label>
                            </div>
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Actitud" id="id_actitud_2" value="Indiferente"           >
                                <label class="form-check-label" for="id_actitud_2">Indiferente</label>
                            </div>
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Actitud" id="id_actitud_3" value="Libremente escogida"   >
                                <label class="form-check-label" for="id_actitud_3">Libremente escogida</label>
                                <small id="error_actitud" class="form-text text-danger"></small>
                            </div>
                        </div> 
                    </div>
                </div>
                <!--LENGUAJE-->
                <div class="col-6 col-md-auto mx-auto mt-4 mt-md-0">
                    <div class="row">
                        <div class="col-12 mi_align">
                            <h6>Lenguaje</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input lenguaje_check" id="id_lenguaje_1" value="Normal" name="Lenguaje[]" >
                                <label class="custom-control-label" for="id_lenguaje_1">Normal</label>
                            </div>
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input lenguaje_check" id="id_lenguaje_2" value="Disartría" name="Lenguaje[]" >
                                <label class="custom-control-label" for="id_lenguaje_2">Disartría</label>
                            </div>
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input lenguaje_check" id="id_lenguaje_3" value="Verborreico" name="Lenguaje[]" >
                                <label class="custom-control-label" for="id_lenguaje_3">Verborreico</label>
                            </div>
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input lenguaje_check" id="id_lenguaje_4" value="Incoherente" name="Lenguaje[]" >
                                <label class="custom-control-label" for="id_lenguaje_4">Incoherente</label>
                                <small id="error_lenguaje" class="form-text text-danger"></small>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

        <!--EXPLORACIÓN FÍSICA-->
        <div class="col-12 mt-4">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="text-divider">
                        <h5>Exploración física</h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <!--FACIES-->
                <div class="col-6 col-md-auto mx-auto mt-4 mt-md-0">
                    <div class="row">
                        <div class="col-12 mi_align">
                            <h6>Facies</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Fascies" id="id_fascies_1" value="Normal" >
                                <label class="form-check-label" for="id_fascies_1">Normal</label>
                            </div>
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Fascies" id="id_fascies_2" value="Alcohólica" >
                                <label class="form-check-label" for="id_fascies_2">Alcohólica</label>
                                <small id="error_fascies" class="form-text text-danger"></small>
                            </div>
                        </div> 
                    </div>
                </div>
                <!--CONJUNTIVAS-->
                <div class="col-6 col-md-auto mx-auto mt-4 mt-md-0">
                    <div class="row">
                        <div class="col-12 mi_align">
                            <h6>Conjuntivas</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Conjuntivas" id="id_conjuntivas_1" value="Coloración normal" >
                                <label class="form-check-label" for="id_conjuntivas_1">Coloración normal</label>
                            </div>
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Conjuntivas" id="id_conjuntivas_2" value="Hiperémicas" >
                                <label class="form-check-label" for="id_conjuntivas_2">Hiperémicas</label>
                                <small id="error_conjuntivas" class="form-text text-danger"></small>
                            </div>
                        </div> 
                    </div>
                </div>
                <!--PUPILAS-->
                <div class="col-6 col-md-auto mx-auto mt-4 mt-md-0">
                    <div class="row">
                        <div class="col-12 mi_align text-center">
                            <h6>Pupilas</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Pupilas" id="id_pupilas_1" value="Normal"   >
                                <label class="form-check-label" for="id_pupilas_1">Normal</label>
                            </div>
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Pupilas" id="id_pupilas_2" value="Mióticas"          >
                                <label class="form-check-label" for="id_pupilas_2">Mióticas</label>
                            </div>
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Pupilas" id="id_pupilas_3" value="Midriáticas"       >
                                <label class="form-check-label" for="id_pupilas_3">Midriáticas</label>
                                <small id="error_pupilas" class="form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Pupilas2" id="id_pupilas_4" value="Normorefléxicas"   >
                                <label class="form-check-label" for="id_pupilas_4">Normorefléxicas</label>
                            </div>
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Pupilas2" id="id_pupilas_5" value="Hiperrefléxicas"   >
                                <label class="form-check-label" for="id_pupilas_5">Hiperrefléxicas</label>
                            </div>
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Pupilas2" id="id_pupilas_6" value="Hiporrefléxicas"   >
                                <label class="form-check-label" for="id_pupilas_6">Hiporrefléxicas</label>
                                <small id="error_pupilas2" class="form-text text-danger"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <!--MUCOSA ORAL-->
                <div class="col-6 col-md-auto mx-auto mt-4 mt-md-0">
                    <div class="row">
                        <div class="col-12 mi_align">
                            <h6>Mucosa oral</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Mucosa_Oral" id="id_mucosa_1" value="Hidratada"      >
                                <label class="form-check-label" for="id_mucosa_1">Hidratada</label>
                            </div>
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Mucosa_Oral" id="id_mucosa_2" value="Deshidratada"   >
                                <label class="form-check-label" for="id_mucosa_2">Deshidratada</label>
                                <small id="error_mucosa_oral" class="form-text text-danger"></small>
                            </div>
                        </div> 
                    </div>
                </div>
                <!--ALIENTO-->
                <div class="col-6 col-md-auto mx-auto mt-4 mt-md-0">
                    <div class="row">
                        <div class="col-12 mi_align">
                            <h6>Aliento</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input" id="id_aliento_1" value="Alcohol" name="Aliento[]" >
                                <label class="custom-control-label" for="id_aliento_1">Alcohol</label>
                            </div>
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input" id="id_aliento_2" value="Solventes" name="Aliento[]" >
                                <label class="custom-control-label" for="id_aliento_2">Solventes</label>
                            </div>
                            <div class="custom-control custom-checkbox mi_align">
                                <input type="checkbox" class="custom-control-input" id="id_aliento_3" value="Cannabis" name="Aliento[]" >
                                <label class="custom-control-label" for="id_aliento_3">Cannabis</label>
                            </div>
                            
                        </div> 
                    </div>
                </div>
            </div>
        </div>

        <!--HERIDAS/LESIONES-->
        <div class="col-12 col-lg-6 mt-4">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="text-divider">
                        <h5>Heridas / Lesiones</h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-12">
                    <label for="id_heridas_lesiones">heridas - lesiones:</label>
                    <textarea class="form-control text-uppercase" id="id_heridas_lesiones" rows="3" maxlength="500" name="Heridas_Lesiones"></textarea>
                    <small id="error_heridas_lesiones" class="form-text text-danger"></small>
                </div>
            </div>
        </div>

        <!--OBSERVACIONES-->
        <div class="col-12 col-lg-6 mt-4">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="text-divider">
                        <h5>Observaciones</h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-12">
                    <label for="id_observaciones">observaciones:</label>
                    <textarea class="form-control text-uppercase" id="id_observaciones" rows="3" maxlength="500" name="Observaciones"></textarea>
                    <small id="error_observaciones" class="form-text text-danger"></small>
                </div>
            </div>
        </div>

        <!--DIAGNÓSTICO-->
        <div class="col-12 mt-4">
            <div class="row">
                <div class="col-12 text-divider">
                    <h5>Diagnóstico</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-auto mx-auto">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Diagnostico" id="id_diagnostico_1" value="Negativo a alcohol" >
                                <label class="form-check-label" for="id_diagnostico_1">Negativo a alcohol</label>
                            </div>
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Diagnostico" id="id_diagnostico_2" value="Aliento etílico" >
                                <label class="form-check-label" for="id_diagnostico_2">Aliento etílico</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto mx-auto " id="id_diagnostico_panel">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Diagnostico" id="id_diagnostico_3" value="Intoxicación etílica leve o 1° periodo" >
                                <label class="form-check-label" for="id_diagnostico_3">Intoxicación etílica leve o 1° periodo</label>
                            </div>
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Diagnostico" id="id_diagnostico_4" value="Intoxicación etílica moderada o 2° periodo" >
                                <label class="form-check-label" for="id_diagnostico_4">Intoxicación etílica moderada o 2° periodo</label>
                            </div>
                            <div class="form-check mi_align">
                                <input class="form-check-input" type="radio" name="Diagnostico" id="id_diagnostico_5" value="Intoxicación etílica grave o 3° periodo" >
                                <label class="form-check-label" for="id_diagnostico_5">Intoxicación etílica grave o 3° periodo</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <small id="error_diagnostico" class="form-text text-danger"></small>
                </div>
                
            </div>
        </div>

        <!--ELEMENTO PARTICIPANTE (primer respondiente)-->
        <div class="col-12 mt-4">
            <div class="row">
                <div class="col-12 text-divider">
                    <h5>Elemento participante</h5>
                </div>
            </div>
            <div class="row">
                <!-- buscador de elementos por no control -->
                <div class="col-12" id="id_busqueda_pr_panel">
                    <div class="input-group col-lg-6 offset-lg-3 my-2">
                        <input type="text" class="form-control text-uppercase" placeholder="Ingrese el número de control, placa ó apellidos del elemento" id="element_search_1">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="button_search_1">Buscar</button>
                        </div>
                    </div>  
                    <div class="col-lg-6 offset-lg-3 mb-3" id="list_elements_search_1">
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <label for="id_nombre_e" class="label-form">Nombre del elemento:</label>
                    <input id="id_nombre_e" type="text" name="Nombre_E" class="form-control form-control-sm text-uppercase" value="<?= ($infoRem)?$infoRem->Nombre_E:''?>" required >
                    <small id="error_nombre_e" class="form-text text-danger "></small>
                </div>
                <div class="col-6 col-lg-3">
                    <label for="id_ap_paterno_e" class="label-form">Apellido paterno:</label>
                    <input id="id_ap_paterno_e" type="text" name="Ap_Paterno_E" class="form-control form-control-sm text-uppercase" value="<?= ($infoRem)?$infoRem->Ap_Paterno_E:''?>" required >
                    <small id="error_ap_paterno_e" class="form-text text-danger "></small>
                </div>
                <div class="col-6 col-lg-3">
                    <label for="id_ap_materno_e" class="label-form">Apellido materno:</label>
                    <input id="id_ap_materno_e" type="text" name="Ap_Materno_E" class="form-control form-control-sm text-uppercase" value="<?= ($infoRem)?$infoRem->Ap_Materno_E:''?>" required >
                    <small id="error_ap_materno_e" class="form-text text-danger "></small>
                </div>
                <div class="col-6 col-lg-3 form-group">
                    <label for="id_placa_e" class="label-form">Placa:</label>
                    <input id="id_placa_e" type="text" name="Placa_E" class="form-control form-control-sm text-uppercase" value="<?= ($infoRem)?$infoRem->Placa_E:''?>" >
                    <small id="error_placa_e" class="form-text text-danger "></small>
                </div>
                <div class="col-6 col-lg-3 form-group">
                    <label for="id_cargo_e" class="label-form">Cargo:</label>
                    <input id="id_cargo_e" type="text" name="Cargo_E" class="form-control form-control-sm text-uppercase" value="<?= ($infoRem)?$infoRem->Cargo_E:''?>" required >
                    <small id="error_cargo_e" class="form-text text-danger "></small>
                </div>
                <div class="col-6 col-lg-3 form-group">
                    <label for="id_sector_e" class="label-form">Sector/Área:</label>
                    <input id="id_sector_e" type="text" name="Sector_Area_E" class="form-control form-control-sm text-uppercase" value="<?= ($infoRem)?$infoRem->Sector_Area_E:''?>" required >
                    <small id="error_sector_e" class="form-text text-danger "></small>
                </div>
                <div class="col-6 col-lg-3 form-group">
                    <label for="id_unidad_e" class="label-form">Patrulla:</label>
                    <input id="id_unidad_e" type="text" name="Unidad_E" class="form-control form-control-sm text-uppercase" value="<?= ($infoRem)?$infoRem->Unidad_E:''?>" required >
                    <small id="error_unidad_e" class="form-text text-danger "></small>
                </div>
                <div class="col-6 col-lg-3 form-group mi_hide">
                    <label for="id_instancia_e" class="label-form">Autoridad a que remite:</label>
                    <input id="id_instancia_e" type="text" name="Instancia_E" class="form-control form-control-sm text-uppercase" value="Juez Calificador" readonly>
                </div>
                <input type="hidden" value="" id="id_no_control">
            </div>
        </div>

        <!-- FECHA Y FOOTER -->
        <div class="col-12">
            <div class="row my-5">
                <div class="col-auto my-auto mr-auto">
                    <h6 class="my-auto">Heróica Puebla de Zaragoza a: </h6>
                </div>
                <div class="col-2 col-lg-1 my-auto mx-auto">
                    <input type="text" class="form-control form-control-sm text-uppercase" readonly id="id_dia_footer" value="10">
                </div>
                <div class="col-auto my-auto mx-auto">
                    <h6 class="my-auto"> de </h6>
                </div>
                <div class="col-3 col-md-3 col-lg-2 my-auto mx-auto">
                    <input type="text" class="form-control form-control-sm text-uppercase" readonly id="id_mes_footer" value="Noviembre">
                </div>
                <div class="col-auto my-auto mx-0 mx-md-auto">
                    <h6 class="my-auto"> de </h6>
                </div>
                <div class="col-2 col-md-3 col-lg-2 my-auto">
                    <input type="text" class="form-control form-control-sm text-uppercase" readonly id="id_anio_footer" value="2020">
                </div>
                <div class="col-12 mt-4">
                    <label for="id_doctor" class="label-form">Médico en turno:</label>
                    <input id="id_doctor" type="text" class="form-control form-control-sm text-uppercase" value="<?= $_SESSION['userdata']->Nombre.' '.$_SESSION['userdata']->Ap_Paterno.' '.$_SESSION['userdata']->Ap_Materno?>" readonly>
                    <input id="id_usuario" name="Id_Usuario" type="hidden" class="mi_hide" value="<?= $_SESSION['userdata']->Id_Usuario?>">
                </div>
            </div>
        </div>
        <div class="col-12">
            <!--buttons to back or send form-->
            <div class="row my-5">
                <div class="col-12 d-flex justify-content-center mx-auto">
                    <a href="<?= base_url;?>DictamenMedico" class="btn btn-secondary mr-3" id="id_cancel_button">cancelar</a>
                    <button id="<?= ($infoRem)?'id_dictamen_nuevo':'id_dictamen_otro'?>" type="button" class="btn btn-ssc ml-3" onclick="checkFormDictamen(event)">Crear</button>
                </div>
            </div>
        </div>
    </form>

    

    
</div>