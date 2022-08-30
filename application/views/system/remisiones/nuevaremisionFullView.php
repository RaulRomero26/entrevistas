<div class="container">

    <?php if(!isset($data['titulo_1'])){ ?>
        <div class="paragraph-title d-flex justify-content-between mt-5 mb-4">
            <h5> <a href="<?= base_url; ?>Remisiones">Remisiones </a> <span>/ Nueva</span></h5>
        </div>
    <?php }else{ ?>
        <div class="paragraph-title d-flex justify-content-between mt-5 mb-4">
            <h5> <a href="<?= base_url; ?>Remisiones">Remisiones </a> <span>/ <?=$data['titulo_1']?></span></h5>
        </div>
    <?php } ?>

</div>






<div class="container-fluid" >
    <ul class="nav nav-tabs d-flex justify-content-center" id="tab_remisiones" role="tablist">
        <?php
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Editar_remisiones[10]) { ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link active d-flex align-items-center" id="datos_p" data-toggle="tab" href="#datos_p0" role="tab" aria-controls="Datos_principales" aria-selected="true">
                    Datos principales
                    <div id="check-tab-0">
                    </div>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item" role="presentation" style="display: none">
                <a class="nav-link active d-flex align-items-center" id="datos_p" data-toggle="tab" href="#datos_p0" role="tab" aria-controls="Datos_principales" aria-selected="true">
                    Datos principales
                    <div id="check-tab-0">
                    </div>
                </a>
            </li>
        <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Editar_remisiones[9]) { ?>
        
            <li class="nav-item repetido" id="li-peticionario" role="presentation">
                <a class="nav-link d-flex align-items-center" id="peticionario" data-toggle="tab" href="#peticionario0" role="tab" aria-controls="Peticionario" aria-selected="true">
                    Peticionario
                    <div id="check-tab-1">
                    </div>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item repetido" id="li-peticionario" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="peticionario" data-toggle="tab" href="#peticionario0" role="tab" aria-controls="Peticionario" aria-selected="true">
                    Peticionario
                    <div id="check-tab-1">
                    </div>
                </a>
            </li>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Editar_remisiones[8]) { ?>
            <li class="nav-item repetido" id="li-ubicacion-h" role="presentation">
                <a class="nav-link d-flex align-items-center" id="ubicacion_h" data-toggle="tab" href="#ubicacion_h0" role="tab" aria-controls="Ubicacion_hechos" aria-selected="false">
                    Ubicación de los hechos
                    <div id="check-tab-2">
                    </div>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item repetido" id="li-ubicacion-h" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="ubicacion_h" data-toggle="tab" href="#ubicacion_h0" role="tab" aria-controls="Ubicacion_hechos" aria-selected="false">
                    Ubicación de los hechos
                    <div id="check-tab-2">
                    </div>
                </a>
            </li>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Editar_remisiones[7]) { ?>

            <li class="nav-item" role="presentation">
                <a class="nav-link d-flex align-items-center" id="elem_p" data-toggle="tab" href="#elem_p0" role="tab" aria-controls="contact" aria-selected="false">
                    Elementos participantes
                    <div id="check-tab-3">
                    </div>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="elem_p" data-toggle="tab" href="#elem_p0" role="tab" aria-controls="contact" aria-selected="false">
                    Elementos participantes
                    <div id="check-tab-3">
                    </div>
                </a>
            </li>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Editar_remisiones[6]) { ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link d-flex align-items-center" id="obj_recuperados" data-toggle="tab" href="#obj_recuperados0" role="tab" aria-controls="contact" aria-selected="false">
                    Objetos asegurados
                    <div id="check-tab-4">
                    </div>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="obj_recuperados" data-toggle="tab" href="#obj_recuperados0" role="tab" aria-controls="contact" aria-selected="false">
                    Objetos asegurados
                    <div id="check-tab-4">
                    </div>
                </a>
            </li>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Editar_remisiones[5]) { ?>

            <li class="nav-item" role="presentation">
                <a class="nav-link d-flex align-items-center" id="captura_fyh" data-toggle="tab" href="#captura_fyh0" role="tab" aria-controls="contact" aria-selected="false">
                    Captura de fotos y huellas
                    <div id="check-tab-5">
                    </div>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="captura_fyh" data-toggle="tab" href="#captura_fyh0" role="tab" aria-controls="contact" aria-selected="false">
                    Captura de fotos y huellas
                    <div id="check-tab-5">
                    </div>
                </a>
            </li>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Editar_remisiones[4]) { ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link d-flex align-items-center" id="ubicacion_d" data-toggle="tab" href="#ubicacion_d0" role="tab" aria-controls="contact" aria-selected="false">
                    Ubicación de la detención
                    <div id="check-tab-6">
                    </div>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="ubicacion_d" data-toggle="tab" href="#ubicacion_d0" role="tab" aria-controls="contact" aria-selected="false">
                    Ubicación de la detención
                    <div id="check-tab-6">
                    </div>
                </a>
            </li>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Editar_remisiones[3]) { ?>

            <li class="nav-item" role="presentation">
                <a class="nav-link d-flex align-items-center" id="sen_part" data-toggle="tab" href="#sen_part0" role="tab" aria-controls="contact" aria-selected="false">
                    Señas particulares
                    <div id="check-tab-7">
                    </div>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="sen_part" data-toggle="tab" href="#sen_part0" role="tab" aria-controls="contact" aria-selected="false">
                    Señas particulares
                    <div id="check-tab-7">
                    </div>
                </a>
            </li>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Editar_remisiones[2]) { ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link d-flex align-items-center" id="entre_det" data-toggle="tab" href="#entre_det0" role="tab" aria-controls="contact" aria-selected="false">
                    Entrevista del detenido
                    <div id="check-tab-8">
                    </div>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="entre_det" data-toggle="tab" href="#entre_det0" role="tab" aria-controls="contact" aria-selected="false">
                    Entrevista del detenido
                    <div id="check-tab-8">
                    </div>
                </a>
            </li>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Editar_remisiones[1]) { ?>

            <li class="nav-item" role="presentation">
                <a class="nav-link d-flex align-items-center" id="datos_s" data-toggle="tab" href="#datos_s0" role="tab" aria-controls="Datos_secuendarios" aria-selected="false">
                    Media Filiación
                    <div id="check-tab-9">
                    </div>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="datos_s" data-toggle="tab" href="#datos_s0" role="tab" aria-controls="Datos_secuendarios" aria-selected="false">
                    Media Filiación
                    <div id="check-tab-9">
                    </div>
                </a>
            </li>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Editar_remisiones[0]) { ?>

            <li class="nav-item" role="presentation">
                <a class="nav-link d-flex align-items-center" id="narrativas" data-toggle="tab" href="#narrativas0" role="tab" aria-controls="Inf_ad" aria-selected="false">
                    Narrativas
                    <div id="check-tab-10">
                    </div>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="narrativas" data-toggle="tab" href="#narrativas0" role="tab" aria-controls="Inf_ad" aria-selected="false">
                    Narrativas
                    <div id="check-tab-10">
                    </div>
                </a>
            </li>
            <?php
        }?>

    </ul>


    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active" id="datos_p0" role="tabpanel" aria-labelledby="datos_p">
            <?php include 'tabs/datos_principales.php'; ?>
        </div>

        <div class="tab-pane fade" id="datos_s0" role="tabpanel" aria-labelledby="datos_s">
            <?php include 'tabs/datos_secundarios.php'; ?>
        </div>

        <div class="tab-pane fade " id="peticionario0" role="tabpanel" aria-labelledby="peticionario">
            <?php include 'tabs/peticionario.php'; ?>
        </div>

        <div class="tab-pane fade" id="ubicacion_h0" role="tabpanel" aria-labelledby="ubicacion_h">
            <?php include 'tabs/ubicacion_hechos.php'; ?>
        </div>

        <div class="tab-pane fade" id="ubicacion_d0" role="tabpanel" aria-labelledby="ubicacion_d">
            <?php include 'tabs/ubicacion_detencion.php'; ?>
        </div>

        <div class="tab-pane fade" id="elem_p0" role="tabpanel" aria-labelledby="lem_p">
            <?php include 'tabs/elementos_participantes.php' ?>
        </div>

        <div class="tab-pane fade" id="captura_fyh0" role="tabpanel" aria-labelledby="captura_fyh">
            <?php include 'tabs/captura_fyh.php'; ?>
        </div>

        <div class="tab-pane fade" id="obj_recuperados0" role="tabpanel" aria-labelledby="obj_recuperados">
            <?php include 'tabs/obj_recuperados.php'; ?>
        </div>

        <div class="tab-pane fade" id="sen_part0" role="tabpanel" aria-labelledby="sen_part">
            <?php include 'tabs/senas_particulares.php'; ?>
        </div>

        <div class="tab-pane fade" id="entre_det0" role="tabpanel" aria-labelledby="entre_det">
            <?php include 'tabs/entrevista.php'; ?>
        </div>

        <!-- <div class="tab-pane fade" id="Inf_ad0" role="tabpanel" aria-labelledby="entre_det">
            
        </div> -->

        <div class="tab-pane fade" id="narrativas0" role="tabpanel" aria-labelledby="narrativas">
            <?php include 'tabs/narrativas.php'; ?> 
        </div>
    </div>
</div>