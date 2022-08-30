<div class="container">
    <h5 class="display-4 text-center my-5">Manual de usuario</h5>

    <div class="row container ">
        <div class="col-12 ">
            <div class="accordion mb-5" id="accordionExample">
                <!--Instalación biométricos-->
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-block text-left btn-colllapside" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Instalación de biometricos
                            </button>
                        </h2>
                    </div>
                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                            <ul>
                                <li>
                                    Descargar el archivo <a href="<?=base_url?>public/Java/Instaladores_Remisiones.zip">.zip</a> y extraerlo
                                    <ul>
                                        <li>Abrir la carpeta resultante (C1)</li>
                                    </ul>
                                </li>
                                <li>Instalar el archivo <b>jre-8u281-windows-x64.exe</b> ubicado en la raíz de la carpeta extraída</li>
                                <li>Abrir la carpeta en donde se instaló <i>JAVA RUNTIME ENVIRONMENT</i> (C2)</li>

                                <img src="<?= base_url ?>public/media/images/screen_1.png" alt="" width="50%" class="my-4 text-center">
                                <li>
                                    <b>Biometrico de Iris</b>
                                    <ul>
                                        <li>Abrir la carpeta "Iris", úbicada dentro de C1 </li>
                                        <li>Instalar el archivo <b>EyeLockSDK_v4.6.0.24894.2009_x64.exe</b> dentro de la carpeta "SDK"</li>
                                        <img src="<?= base_url ?>public/media/images/screen_2.png" alt="" width="50%" class="my-4 text-center">
                                        <li>Copiar todo el contenido de la carpeta "dll" en la carpeta "bin" (C3) ubicada en C2</li>
                                        <img src="<?= base_url ?>public/media/images/screen_3.png" alt="" width="80%" class="my-4 text-center">
                                        <li>Copiar el contenido de la carpeta "Archivos de reconocimiento de dispositivo" a "Descargas" y ocultarlos</li>
                                    </ul>
                                </li>

                                <li class="mt-5">
                                    <b>Biometrico de huellas</b>
                                    <ul>
                                        <li>Abrir la carpeta "Huellas", úbicada dentro de C1</li>
                                        <li>Copiar la carpeta "Data" en la raíz de C2</li>
                                        <img src="<?= base_url ?>public/media/images/screen_4.png" alt="" width="50%" class="my-4 text-center">
                                        <li>
                                            Copiar los dll a la carpeta "bin" de C2 de acuerdo a la arquitectura del Sistema operativo (SO). Si el SO es de 32 bits copiar el contenido de
                                            la carpeta "Win32_x86", de lo contrario utilizar el contenido de "Win64_x64"
                                        </li>

                                        <li class="mt-5"><b>Instalación de drivers</b>
                                            <ul>
                                                <li>En el administrador de dispositivos, ubicar el dispositivo biometrico y realizar la instación manual del driver. Este se encuentra dentro de C1 en la carpeta "Huellas/Drivers green bit"</li>
                                                <img src="<?= base_url ?>public/media/images/screen_5.png" alt="" width="50%" class="my-4 text-center">
                                                <img src="<?= base_url ?>public/media/images/screen_6.png" alt="" width="50%" class="my-4 text-center">
                                                <img src="<?= base_url ?>public/media/images/screen_7.png" alt="" width="50%" class="my-4 text-center">
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                                <li class="mt-5"><b>Configuración de Java</b>
                                    <ul>
                                        <li>Escribir en el buscador de Windows: "Configuración de Java" y ejecutarla</li>
                                        <img src="<?= base_url ?>public/media/images/screen_8.png" alt="" width="50%" class="my-4 text-center">
                                        <li>Navegar hasta el menú "Seguridad" y dar click en "Editar lista de sitios..."</li>
                                        <li>Agregar: http://172.18.0.25/ y guardar los cambios</li>
                                        <img src="<?= base_url ?>public/media/images/screen_9.png" alt="" width="50%" class="my-4 text-center">


                                    </ul>

                                </li>


                            </ul>
                        </div>
                    </div>
                </div>

                <!--Servicios Web-->
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="btn btn-block text-left collapsed btn-colllapside" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                Servicios web
                            </button>
                        </h2>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="row">
                                <!--WS Buscador de Huellas-->
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 text-center my-3">
                                            <div class="text-divider">
                                                <h5>Instalación web service en Servidor de producción</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-justify my-2">
                                            <li>
                                                Primero se debe descargar el archivo '.war' del proyecto hecho desde netbeans al servidor mediante File Zilla Client. 
                                                Se debe dirigir a la ruta /home/sscpueroot/WebService para descargar el .war. Si ya existe una versón pasada se debe sobrescribir
                                            </li>
                                        </div>
                                        <div class="col-12 my-2">
                                            <img src="<?= base_url?>public/media/images/huellas1.png" width="900">
                                        </div>
                                        <div class="col-12 my-2">
                                            <img src="<?= base_url?>public/media/images/huellas2.png" width="900">
                                        </div>
                                        <div class="col-12 text-justify my-2">
                                            <li>
                                                Una vez descargado, abrimos Putty, nos conectamos al servidor (con las credenciales correspondientes).
                                                Nos posicionamos en la siguiente ruta con el comando: cd /home/sscpueroot/GlassServers/glassfish5. 
                                                Antes de desplegar el Web Services comprobamos que el dominio de glassfish este corriendo con: bin/asadmin start-domain.
                                                Después de esto ejecutamos el siguiente comando para quitar la versión anterior: bin/asadmin undeploy "nombre proyecto sin .war"
                                            </li>
                                        </div>
                                        <div class="col-12 my-2">
                                            <img src="<?= base_url?>public/media/images/huellas3.png" width="900">
                                        </div>
                                        <div class="col-12 text-justify my-2">
                                            <li>
                                                Ahora realizamos el deploy correspondiente con: bin/asadmin deploy "ruta absoluta del .war del proyecto"
                                            </li>
                                        </div>
                                        <div class="col-12 my-2">
                                            <img src="<?= base_url?>public/media/images/huellas4.png" width="900">
                                        </div>
                                        <div class="col-12 text-justify my-2">
                                            <li>
                                                Finalmente reiniciamos el dominio del servidor glassfish con el comando: bin/asadmin restart-domain
                                            </li>
                                        </div>
                                        <div class="col-12 my-2">
                                            <img src="<?= base_url?>public/media/images/huellas5.png" width="900">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>