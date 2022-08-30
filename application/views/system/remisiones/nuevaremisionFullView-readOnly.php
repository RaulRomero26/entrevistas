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
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Ver_remisiones[10]) { ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link active d-flex align-items-center" id="datos_p" data-toggle="tab" href="#datos_p0" role="tab" aria-controls="Datos_principales" aria-selected="true">
                    Datos principales
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-0" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item" role="presentation" style="display: none">
                <a class="nav-link active d-flex align-items-center" id="datos_p" data-toggle="tab" href="#datos_p0" role="tab" aria-controls="Datos_principales" aria-selected="true">
                    Datos principales
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-0" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Ver_remisiones[9]) { ?>
            <li class="nav-item repetido" id="li-peticionario" role="presentation">
                <a class="nav-link d-flex align-items-center" id="peticionario" data-toggle="tab" href="#peticionario0" role="tab" aria-controls="Peticionario" aria-selected="true">
                    Peticionario
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-1" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item repetido" id="li-peticionario" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="peticionario" data-toggle="tab" href="#peticionario0" role="tab" aria-controls="Peticionario" aria-selected="true">
                    Peticionario
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-1" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Ver_remisiones[8]) { ?>

            <li class="nav-item repetido" id="li-ubicacion-h" role="presentation">
                <a class="nav-link d-flex align-items-center" id="ubicacion_h" data-toggle="tab" href="#ubicacion_h0" role="tab" aria-controls="Ubicacion_hechos" aria-selected="false">
                    Ubicación de los hechos
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-2" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item repetido" id="li-ubicacion-h" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="ubicacion_h" data-toggle="tab" href="#ubicacion_h0" role="tab" aria-controls="Ubicacion_hechos" aria-selected="false">
                    Ubicación de los hechos
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-2" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Ver_remisiones[7]) { ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link d-flex align-items-center" id="elem_p" data-toggle="tab" href="#elem_p0" role="tab" aria-controls="contact" aria-selected="false">
                    Elementos participantes
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-3" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="elem_p" data-toggle="tab" href="#elem_p0" role="tab" aria-controls="contact" aria-selected="false">
                    Elementos participantes
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-3" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Ver_remisiones[6]) { ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link d-flex align-items-center" id="obj_recuperados" data-toggle="tab" href="#obj_recuperados0" role="tab" aria-controls="contact" aria-selected="false">
                    Objetos asegurados
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-4" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="obj_recuperados" data-toggle="tab" href="#obj_recuperados0" role="tab" aria-controls="contact" aria-selected="false">
                    Objetos asegurados
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-4" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Ver_remisiones[5]) { ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link d-flex align-items-center" id="captura_fyh" data-toggle="tab" href="#captura_fyh0" role="tab" aria-controls="contact" aria-selected="false">
                    Captura de fotos y huellas
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-5" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="captura_fyh" data-toggle="tab" href="#captura_fyh0" role="tab" aria-controls="contact" aria-selected="false">
                    Captura de fotos y huellas
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-5" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Ver_remisiones[4]) { ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link d-flex align-items-center" id="ubicacion_d" data-toggle="tab" href="#ubicacion_d0" role="tab" aria-controls="contact" aria-selected="false">
                    Ubicación de la detención
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-6" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="ubicacion_d" data-toggle="tab" href="#ubicacion_d0" role="tab" aria-controls="contact" aria-selected="false">
                    Ubicación de la detención
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-6" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Ver_remisiones[3]) { ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link d-flex align-items-center" id="sen_part" data-toggle="tab" href="#sen_part0" role="tab" aria-controls="contact" aria-selected="false">
                    Señas particulares
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-7" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="sen_part" data-toggle="tab" href="#sen_part0" role="tab" aria-controls="contact" aria-selected="false">
                    Señas particulares
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-7" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Ver_remisiones[2]) { ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link d-flex align-items-center" id="entre_det" data-toggle="tab" href="#entre_det0" role="tab" aria-controls="contact" aria-selected="false">
                    Entrevista del detenido
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-8" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="entre_det" data-toggle="tab" href="#entre_det0" role="tab" aria-controls="contact" aria-selected="false">
                    Entrevista del detenido
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-8" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Ver_remisiones[1]) { ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link d-flex align-items-center" id="datos_s" data-toggle="tab" href="#datos_s0" role="tab" aria-controls="Datos_secuendarios" aria-selected="false">
                    Media Filiación
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-9" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        else{ ?>
            <li class="nav-item" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="datos_s" data-toggle="tab" href="#datos_s0" role="tab" aria-controls="Datos_secuendarios" aria-selected="false">
                    Media Filiación
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-9" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        if ($_SESSION['userdata']->Modo_Admin == 1  || $_SESSION['userdata']->Ver_remisiones[0]) { ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link d-flex align-items-center" id="narrativas" data-toggle="tab" href="#narrativas0" role="tab" aria-controls="Inf_ad" aria-selected="false">
                    Narrativas
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-10" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }
        else{?>
            <li class="nav-item" role="presentation" style="display: none">
                <a class="nav-link d-flex align-items-center" id="narrativas" data-toggle="tab" href="#narrativas0" role="tab" aria-controls="Inf_ad" aria-selected="false">
                    Narrativas
                    <svg data-toggle="popover" data-content="Tab validado" data-placement="top" data-trigger="hover" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-1 bi bi-check2-circle check-tab" id="check-tab-10" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </a>
            </li>
            <?php
        }?>

    </ul>


    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active" id="datos_p0" role="tabpanel" aria-labelledby="datos_p">
            <?php include 'readOnly/datos_principales-readOnly.php'; ?>
        </div>

        <div class="tab-pane fade" id="datos_s0" role="tabpanel" aria-labelledby="datos_s">
            <?php include 'readOnly/datos_secundarios-readOnly.php'; ?>
        </div>

        <div class="tab-pane fade " id="peticionario0" role="tabpanel" aria-labelledby="peticionario">
            <?php include 'readOnly/peticionario-readOnly.php'; ?>
        </div>

        <div class="tab-pane fade" id="ubicacion_h0" role="tabpanel" aria-labelledby="ubicacion_h">
            <?php include 'readOnly/ubicacion_hechos-readOnly.php'; ?>
        </div>

        <div class="tab-pane fade" id="ubicacion_d0" role="tabpanel" aria-labelledby="ubicacion_d">
            <?php include 'readOnly/ubicacion_detencion-readOnly.php'; ?>
        </div>

        <div class="tab-pane fade" id="elem_p0" role="tabpanel" aria-labelledby="lem_p">
            <?php include 'readOnly/elementos_participantes-readOnly.php' ?>
        </div>

        <div class="tab-pane fade" id="captura_fyh0" role="tabpanel" aria-labelledby="captura_fyh">
            <?php include 'readOnly/captura_fyh-readOnly.php'; ?>
        </div>

        <div class="tab-pane fade" id="obj_recuperados0" role="tabpanel" aria-labelledby="obj_recuperados">
            <?php include 'readOnly/obj_recuperados-readOnly.php'; ?>
        </div>

        <div class="tab-pane fade" id="sen_part0" role="tabpanel" aria-labelledby="sen_part">
            <?php include 'readOnly/senas_particulares-readOnly.php'; ?>
        </div>

        <div class="tab-pane fade" id="entre_det0" role="tabpanel" aria-labelledby="entre_det">
            <?php include 'readOnly/entrevista-readOnly.php'; ?>
        </div>

        <div class="tab-pane fade" id="Inf_ad0" role="tabpanel" aria-labelledby="entre_det">
            <?php include 'readOnly/inf_ad-readOnly.php'; ?> 
        </div>

        <div class="tab-pane fade" id="narrativas0" role="tabpanel" aria-labelledby="narrativas">
            <?php include 'readOnly/narrativas-readOnly.php'; ?> 
        </div>
    </div>
</div>