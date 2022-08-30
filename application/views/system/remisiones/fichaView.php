<?php
    class PDF extends FPDF
    {
        function OnePage($data, $base_url)
        {
            /* ----- ----- ----- Variables ----- ----- ----- */
            $banner             = $base_url.'public/media/images/logo22.png';
            $nombreDetenido     = strtoupper($data['principales']->Nombre.' '.$data['principales']->Ap_Paterno.' '.$data['principales']->Ap_Materno);
            $alias              = strtoupper($data['principales']->alias_detenido);
            $noRemision         = $data['principales']->No_Remision;
            $noFicha            = $data['principales']->No_Ficha;
            $folio              = $data['principales']->Folio_911;
            /*se cambio la variable a Fecha_Hora para que se mostrara la fecha editada y no la de la creacion de la remision*/
            $fechaHora          = explode(" ",$data['principales']->Fecha_Hora);
            $instancia          = $data['principales']->Instancia;
            $fotosRostroCuerpo  = $data['fotosHuellas']['fotos'];

            $imgRostroFrente    = $imgRostroDerecho = $imgRostroIzquierdo = $imgCuerpoFrente = $imgCuerpoDerecho   = $imgCuerpoIzquierdo = ''; 

            foreach($fotosRostroCuerpo as $foto){
                $nameImage = explode("?",$foto->Path_Imagen);
                $path = $base_url.'public/files/Remisiones/'.$noFicha."/FotosHuellas/".$noRemision.'/';
                $path.$nameImage[0];
                switch($foto->Tipo){
                    case 'rostro':
                        switch($foto->Perfil){
                            case 'frente':
                                $imgRostroFrente    =  $path.$nameImage[0];
                            break;
                            case 'derecho':
                                $imgRostroDerecho   =  $path.$nameImage[0];
                            break;
                            case 'izquierdo':
                                $imgRostroIzquierdo =  $path.$nameImage[0];
                            break;
                        }
                    break;
                    case 'cuerpo':
                        switch($foto->Perfil){
                            case 'frente':
                                $imgCuerpoFrente    =  $path.$nameImage[0];
                            break;
                            case 'derecho':
                                $imgCuerpoDerecho   =  $path.$nameImage[0];
                            break;
                            case 'izquierdo':
                                $imgCuerpoIzquierdo =  $path.$nameImage[0];
                            break;
                        }
                    break;
                }   
            }

            $detenidoPor        = strtoupper($data['ubicacionHechos']['ubicacion_h']->Remitido_Por);
            $faltas = $data['ubicacionHechos']['faltas_delitos'];
            $remitidoPor = '';
            foreach($faltas as $falta){
                if($falta===end($faltas)){
                    $remitidoPor = $remitidoPor.' '.$falta->Descripcion;
                }else{
                    $remitidoPor = $remitidoPor.' '.$falta->Descripcion.',';
                }
            }

            $probableVinculacion = (isset($data['entrevista']['entrevista']->Vinculacion_Grupo_D)) ? strtoupper($data['entrevista']['entrevista']->Vinculacion_Grupo_D) : '';

            //print_r($data);

            /* ----- ----- ----- Formato ----- ----- ----- */
            $this->Image($banner,12,5,50);
            $this->SetFont('Avenir','',11);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(135, 4);
            $this->Cell(33,  4, utf8_decode("FICHA DE DETENCIÓN:"), 0, 0, 'R');
            $this->SetTextColor(128, 128, 128);
            $this->Cell(20,  4, $noFicha, '', 1, 'C');
            $this->Cell(135, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(33,  4, utf8_decode("REMISIÓN:"), 0, 0, 'R');
            $this->SetTextColor(128, 128, 128);
            $this->Cell(20,  4, $noRemision, '', 1, 'C');
            $this->Cell(135, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(33,  4, utf8_decode("FOLIO:"), 0, 0, 'R');
            $this->SetTextColor(128, 128, 128);
            $this->Cell(20,  4, $folio, '', 1, 'C');
            $this->Ln(10);

            $y1 = $this->GetY();
            $this->Cell(190, 2, '', 0, 1);
            $this->Cell(5,   4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(19,  4, 'NOMBRE:');
            $this->SetTextColor(128, 128, 128);
            $this->MultiCell(161,  4, utf8_decode($nombreDetenido), 0, 1);
            $this->Cell(190, 1, '', 0, 1);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(5,   4);
            $this->Cell(13,  4, 'ALIAS:');
            $this->SetTextColor(128, 128, 128);
            $this->MultiCell(172,  4, utf8_decode($alias), 0, 1);
            $this->Cell(190, 2, '', 0, 1);
            $this->Cell(5,   4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(15,  4, 'FECHA:');
            $this->SetTextColor(128, 128, 128);
            $this->Cell(14,  4, $fechaHora[0]);
            $this->Cell(15,   4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(13,  4, 'HORA:');
            $this->SetTextColor(128, 128, 128);
            /*se cambio la variable a Fecha_Hora para que se mostrara la fecha editada y no la de la creacion de la remision, esta la ser mas corta, solo ocupa la casilla 1*/
            $this->Cell(7,  4, $fechaHora[1]);
            $this->Cell(15,   4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(62,  4, 'INSTANCIA A LA QUE SE REMITE:');
            $this->SetTextColor(128, 128, 128);
            $this->Cell(15,  4, utf8_decode($instancia), 0,1);
            $this->Cell(190, 2, '', 0, 1);
            $y2 = $this->GetY();
            $this->SetY($y1);
            $this->Cell(190, $y2-$y1, '', 1, 1);
            $this->Ln(5);
            $this->ContentPhotos(
                'FOTOGRAFÍAS DE ROSTRO',
                'Rostro',
                $imgRostroIzquierdo,
                $imgRostroFrente,
                $imgRostroDerecho
            );
            $this->Ln(5);
            $y1 = $this->GetY();
            $this->Cell(190, 2, '', 0, 1);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(31, 4, 'DETENIDO POR:');
            $this->SetTextColor(128, 128, 128);
            $this->MultiCell(144, 4, utf8_decode($detenidoPor), 0, 1);
            $this->Cell(190, 1, '', 0, 1);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(30, 4, 'REMITIDO POR:');
            $this->SetTextColor(128, 128, 128);
            $this->MultiCell(145, 4, utf8_decode($remitidoPor), 0, 1);
            $this->Cell(190, 1, '', 0, 1);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(128, 4, utf8_decode('PROBABLE VINCULACIÓN A PERSONA, BANDA O GRUPO DELICTIVO:'), 0, 1);
            $this->SetTextColor(128, 128, 128);
            $this->Cell(190, 1, '', 0, 1);
            $this->Cell(5,4);
            $this->MultiCell(180, 4, utf8_decode($probableVinculacion), 0, 1);
            $this->Cell(190, 2, '', 0, 1);
            $y2 = $this->GetY();
            $this->SetY($y1);
            $this->Cell(190, $y2-$y1, '', 1, 1);
            $this->Ln(5);
            $this->ContentPhotos(
                'FOTOGRAFÍAS DE CUERPO COMPLETO',
                'Cuerpo',
                $imgCuerpoIzquierdo,
                $imgCuerpoFrente,
                $imgCuerpoDerecho
            );
        }

        function TwoPage($data, $base_url)
        {
            $numDetenido = '';
            foreach($data['ubicacionHechos']['remisiones_ficha'] as $key=>$detenido){
                if($detenido->No_Remision == $data['principales']->No_Remision){
                    $numDetenido = ($key+1).'/'.count($data['ubicacionHechos']['remisiones_ficha']);
                }
            }
            
            $noRemision       = $data['principales']->No_Remision;
            $noFicha          = $data['principales']->No_Ficha;
            $fechaNacimiento  = $data['principales']->Fecha_Nacimiento;
            $edad             = $data['principales']->Edad;
            $lugarOrigen      = strtoupper($data['principales']->Lugar_Origen);
            //Se añadio la especificacion del campo colonia y calle
            $domicilio        = strtoupper('Colonia: '.$data['principales']->Colonia.' Calle: '.$data['principales']->Calle.' #Ext.: '.$data['principales']->No_Exterior.' #Int.: '.$data['principales']->No_Interior.' CP: '.$data['principales']->CP);
            $telefono         = $data['principales']->Telefono;
            $ocupacion        = strtoupper($data['principales']->Ocupacion);
            $escolaridad      = strtoupper($data['principales']->Escolaridad);
            $estadoCivil      = ($data['principales']->Estado_Civil == 1) ? 'SOLTERO' : 'CASADO';
            /* Se comentan esas lineas ya que ya no sera solo un contacto conocido  
            $contacto         = strtoupper($data['contacto']->Nombre.' '.$data['contacto']->Ap_Paterno.' '.$data['contacto']->Ap_Materno);
            $parentesco       = strtoupper($data['contacto']->Parentesco);
            $telefonoContacto = strtoupper($data['contacto']->Telefono);*/
            $seguridadPP      = (count($data['entrevista']['instituciones']) > 0) ? 'SI' : 'NO';
            
            $instituciones = $data['entrevista']['instituciones'];
            $listIntituciones = '';
            foreach($instituciones as $institucion){
                if($institucion === end($instituciones)){
                    $listIntituciones = $listIntituciones.$institucion->Nombre_Institucion.'-'.$institucion->Tipo_Institucion;
                }else{
                    $listIntituciones = $listIntituciones.$institucion->Nombre_Institucion.'-'.$institucion->Tipo_Institucion.', ';
                }
            } 
            //Se añadio la especificacion del campo colonia y calle
            $lugarDetencion   = (isset($data['detencion']['ubicacionD'][0])) ? strtoupper('Colonia: '.$data['detencion']['ubicacionD'][0]->Colonia.' Calle #1: '.$data['detencion']['ubicacionD'][0]->Calle_1.' Calle #2:'.$data['ubicacionHechos']['ubicacion_h']->Calle_2.' #Ext.: '.$data['detencion']['ubicacionD'][0]->No_Ext.' #Int.: '.$data['detencion']['ubicacionD'][0]->No_Int.' CP: '.$data['detencion']['ubicacionD'][0]->CP) : '';
           //Se añadio la especificacion del campo colonia y calle
            $lugarHechos   = strtoupper('Colonia: '.$data['ubicacionHechos']['ubicacion_h']->Colonia.' Calle #1:'.$data['ubicacionHechos']['ubicacion_h']->Calle_1.' Calle #2:'.$data['ubicacionHechos']['ubicacion_h']->Calle_2.' #Ext.: '.$data['ubicacionHechos']['ubicacion_h']->No_Ext.' #Int.: '.$data['ubicacionHechos']['ubicacion_h']->No_Int.' CP: '.$data['ubicacionHechos']['ubicacion_h']->CP);

            $antecedentes = $data['entrevista']['antecedentes'];
            $listAntecedentes = '';
            foreach($antecedentes as $antecedente){
                if($antecedente === end($antecedentes)){
                    $listAntecedentes = $listAntecedentes.$antecedente->Descripcion;
                }else{
                    $listAntecedentes = $listAntecedentes.$antecedente->Descripcion.', ';
                }
            }

            $senas = $data['senas']['senas'];
            $tatuajes = $cicatrices = $lunares = $perforaciones = $mutilaciones = 0;
            foreach($senas as $sena){
                switch($sena->Tipo_Senia_Particular){
                    case 'TATUAJES':
                        $tatuajes = $tatuajes+1;
                    break;
                    case 'CICATRICES':
                        $cicatrices = $cicatrices+1;
                    break;
                    case 'LUNARES, MANCHAS Y/O VERRUGAS':
                        $lunares = $lunares+1;
                    break;
                    case 'PERFORACIONES':
                        $perforaciones = $perforaciones+1;
                    break;
                    case 'MUTILACIONES/MALFORMACIONES':
                        $mutilaciones = $mutilaciones+1;
                    break;
                }
            }

            $peticionario = (isset($data['peticionario']->Nombre)) ? strtoupper($data['peticionario']->Nombre.' '.$data['peticionario']->Ap_Paterno.' '.$data['peticionario']->Ap_Materno) : '';

            $this->SetTextColor(135, 45, 44);
            $this->Cell(190, 5, utf8_decode('DATOS PERSONALES'), 0, 1, 'C');
            $this->ln(2);
            $y1 = $this->GetY();
            $this->ln(2);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(35, 4, utf8_decode('NUM. DETENIDOS:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(11, 4, utf8_decode($numDetenido));
            $this->SetTextColor(51, 51, 51);
            $this->Cell(47, 4, utf8_decode('FECHA DE NACIMIENTO:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(26, 4, utf8_decode($fechaNacimiento));
            $this->SetTextColor(51, 51, 51);
            $this->Cell(13, 4, utf8_decode('EDAD:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(25, 4, utf8_decode($edad), 0, 1);
            $this->ln(1.5);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(23, 4, utf8_decode('DOMICILIO:'));
            $this->SetTextColor(128, 128, 128);
            $this->MultiCell(157, 4, utf8_decode($domicilio), 0, 1);
            $this->ln(1.5);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(37, 4, utf8_decode('LUGAR DE ORIGEN:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(50, 4, utf8_decode($lugarOrigen));
            $this->SetTextColor(51, 51, 51);
            $this->Cell(22, 4, utf8_decode('TELÉFONO:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(26, 4, utf8_decode($telefono), 0, 1);
            $this->ln(1.5);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(29, 4, utf8_decode('ESCOLARIDAD:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(58, 4, utf8_decode($escolaridad));
            $this->SetTextColor(51, 51, 51);
            $this->Cell(28, 4, utf8_decode('ESTADO CIVIL:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(50, 4, utf8_decode($estadoCivil), 0, 1);
            $this->ln(1.5);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(26, 4, utf8_decode('OCUPACIÓN:'));
            $this->SetTextColor(128, 128, 128);
            $this->MultiCell(154, 4, utf8_decode($ocupacion));
            $this->ln(1.5);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(48, 4, utf8_decode('CANTIDAD DE TATUAJES:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(8, 4, utf8_decode($tatuajes));
            $this->SetTextColor(51, 51, 51);
            $this->Cell(16, 4, utf8_decode('ANEXO:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(15, 4, ($tatuajes > 0) ? utf8_decode('SÍ'): 'NO');
            $this->SetTextColor(51, 51, 51);
            $this->Cell(51, 4, utf8_decode('CANTIDAD DE CICATRICES:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(8, 4, utf8_decode($cicatrices));
            $this->SetTextColor(51, 51, 51);
            $this->Cell(16, 4, utf8_decode('ANEXO:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(10, 4, ($cicatrices > 0) ? utf8_decode('SÍ'): 'NO', 0, 1);
            $this->ln(1.5);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(98, 4, utf8_decode('CANTIDAD DE LUNARES, MANCHAS Y/O VERRUGAS:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(8, 4, utf8_decode($lunares));
            $this->SetTextColor(51, 51, 51);
            $this->Cell(16, 4, utf8_decode('ANEXO:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(10, 4, ($lunares > 0) ? utf8_decode('SÍ'): 'NO', 0, 1);
            $this->ln(1.5);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(61, 4, utf8_decode('CANTIDAD DE PERFORACIONES:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(8, 4, utf8_decode($perforaciones));
            $this->SetTextColor(51, 51, 51);
            $this->Cell(16, 4, utf8_decode('ANEXO:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(15, 4, ($perforaciones > 0) ? utf8_decode('SÍ'): 'NO', 0, 1);
            $this->ln(1.5);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(96, 4, utf8_decode('CANTIDAD DE MUTILACIONES/MALFORMACIONES:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(8, 4, utf8_decode($mutilaciones));
            $this->SetTextColor(51, 51, 51);
            $this->Cell(16, 4, utf8_decode('ANEXO:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(15, 4, ($mutilaciones > 0) ? utf8_decode('SÍ'): 'NO', 0, 1);
            $this->ln(1.5);
             /*$this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(49, 4, utf8_decode('CÓNYUGE O CONTACTO:'));
            $this->SetTextColor(128, 128, 128);
            $this->MultiCell(131, 4, utf8_decode($contacto));
            $this->ln(1.5);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(27, 4, utf8_decode('PARENTESCO:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(50, 4, utf8_decode($parentesco));
            $this->SetTextColor(51, 51, 51);
            $this->Cell(22, 4, utf8_decode('TELÉFONO:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(26, 4, utf8_decode($telefonoContacto), 0, 1);
            */
            /* De aqui a la linea 386 se cambio la manera en que se imprime la informacion del contacto conocido, 
            esto se hace a traves de un ciclo for que imprime la informacion de cada uno.
            */ 
            if(count($data['contacto']['conocidos'])==0){
                $this->Cell(5, 4);
                $this->SetTextColor(51, 51, 51);
                $this->Cell(49, 4, utf8_decode('CONTACTO:'));
                $this->SetTextColor(128, 128, 128);
                $this->MultiCell(131, 4, utf8_decode("SIN INFORMACIÓN"), 0, 1);
                
            }
            else{
                $icontacto=0;
                for($icontacto=0;$icontacto<count($data['contacto']['conocidos']);$icontacto++){
                    $contacto=strtoupper($data['contacto']['conocidos'][$icontacto]->Nombre.' '.$data['contacto']['conocidos'][$icontacto]->Ap_Paterno.' '.$data['contacto']['conocidos'][$icontacto]->Ap_Materno);
                    $gene=$data['contacto']['conocidos'][$icontacto]->Genero;
                    if($gene=='h'){
                        $gene='HOMBRE';
                    }
                    else{
                        $gene='MUJER';
                    }
                    $this->Cell(5, 4);
                    $this->SetTextColor(51, 51, 51);
                    $this->Cell(49, 6, utf8_decode('CONTACTO '.($icontacto+1).':'));
                    $this->SetTextColor(128, 128, 128);
                    $this->MultiCell(131, 6, utf8_decode($contacto));
                    $this->ln(1.5);
                    $this->Cell(5, 4);
                    $this->SetTextColor(51, 51, 51);
                    $this->Cell(27, 4, utf8_decode('PARENTESCO:'));
                    $this->SetTextColor(128, 128, 128);
                    $this->Cell(30, 4, utf8_decode($data['contacto']['conocidos'][$icontacto]->Parentesco));
                    $this->SetTextColor(51, 51, 51);
                    $this->Cell(15, 4, utf8_decode('EDAD:'));
                    $this->SetTextColor(128, 128, 128);
                    $this->Cell(7, 4, utf8_decode($data['contacto']['conocidos'][$icontacto]->Edad));
                    $this->SetTextColor(51, 51, 51);
                    $this->Cell(12, 4, utf8_decode('SEXO:'));
                    $this->SetTextColor(128, 128, 128);
                    $this->Cell(19, 4, utf8_decode($gene));
                    $this->SetTextColor(51, 51, 51);
                    $this->Cell(22, 4, utf8_decode('TELÉFONO:'));
                    $this->SetTextColor(128, 128, 128);
                    $this->Cell(25, 4, utf8_decode($data['contacto']['conocidos'][$icontacto]->Telefono), 0, 1);
                }
            }
            $this->ln(2);
            $y2 = $this->GetY();
            $this->SetY($y1);
            $this->Cell(190, $y2-$y1, '', 1, 1);
            $this->ln(4);
           
            $this->SetTextColor(135, 45, 44);
            $this->Cell(190, 5, utf8_decode('INFORMACIÓN DE LA DETENCIÓN'), 0, 1, 'C');
            $this->ln(2);
            $y1 = $this->GetY();
            $this->ln(2);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(98, 4, utf8_decode('PERTENECIENTE A SEGURIDAD PÚBLICA O PRIVADA:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(11, 4, utf8_decode($seguridadPP), 0, 1);
            $this->ln(1.5);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(180, 4, utf8_decode('NOMBRE DE LA CORPORACIÓN A LA QUE PERTENECE:'), 0, 1);
            $this->Cell(5, 4);
            $this->SetTextColor(128, 128, 128);
            if(strlen($listIntituciones)>0){
                $this->MultiCell(180, 4, utf8_decode($listIntituciones), 0, 1);
            }
            $this->ln(1.5);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(180, 4, utf8_decode('LUGAR DE LA DETENCIÓN:'), 0, 1);
            $this->Cell(5, 4);
            $this->SetTextColor(128, 128, 128);
            if(strlen($lugarDetencion)>0){
                $this->MultiCell(180, 4, utf8_decode($lugarDetencion), 0, 1);
            }
            $this->ln(1.5);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(180, 4, utf8_decode('LUGAR DE LOS HECHOS:'), 0, 1);
            $this->Cell(5, 4);
            $this->SetTextColor(128, 128, 128);
            if(strlen($lugarHechos)>0){
                $this->MultiCell(180, 4, utf8_decode($lugarHechos), 0, 1);
            }
            $this->ln(1.5);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(180, 4, utf8_decode('ANTECEDENTES PENALES:'), 0, 1);
            $this->Cell(5, 4);
            $this->SetTextColor(128, 128, 128);
            if(strlen($listAntecedentes)>0){
                $this->MultiCell(180, 4, utf8_decode($listAntecedentes), 0, 1);
            }
            $this->ln(1.5);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(180, 4, utf8_decode('PARTE AFECTADA:'), 0, 1);
            $this->Cell(5, 4);
            $this->SetTextColor(128, 128, 128);
            if(strlen($peticionario)>0){
                $this->MultiCell(180, 4, utf8_decode($peticionario), 0, 1);
            }
            $this->ln(2);
            $y2 = $this->GetY();
            $this->SetY($y1);
            $this->Cell(190, $y2-$y1, '', 1, 1);
        }
        /*Funcion añadida para evitar que la imagen de los objetos asegurados
        no se elimine independientemente de la cantidad de contactos conocidos
        que se agreguen
        */
        function TwoPageHalf($data){
            $noFicha          = $data['principales']->No_Ficha;
            $this->ln(4);
            $imgY = $this->GetY();
            $this->SetTextColor(135, 45, 44);
            $this->Cell(190, 5, utf8_decode('OBJETOS ASEGURADOS'), 'B', 1, 'C');
            $this->SetTextColor(128, 128, 128);
            $this->Cell(190,  5, utf8_decode('EVIDENCIA FOTOGRÁFICA:'), '', 1);

            if(isset($data['objetos']['image']->Path_Objetos)){
                $nameImage = $data['objetos']['image']->Path_Objetos;
                $image = base_url.'public/files/Remisiones/'.$noFicha."/ObjRecuperados/".$nameImage;
                if(isset($image) && getimagesize($image)){
                    $type = exif_imagetype($image);
                    $extension = '';
                    $width = $height = $x = $y = 0;
                    $widthImg = getimagesize($image)[0];
                    $heightImg = getimagesize($image)[1];
                    
                    ($widthImg > $heightImg) ? $width = 170 : $height = 116.66;

                    switch($type){
                        case 1:
                            $extension = 'gif';
                        break;
                        case 2:
                            $extension = 'jpeg';
                        break;
                        case 3:
                            $extension = 'png';
                        break;
                    }
                    $this->Image($image,20,10+$imgY, $width, $height, $extension);
                }
            }

        }
        
        function ThreePage($data)
        {
            $armasHead  = array('TIPO', 'CANTIDAD', utf8_decode('DESCRIPCIÓN'));
            $armas      = $data['objetos']['armas'];
            $drogasHead = array('TIPO', 'CANTIDAD', 'UNIDAD', utf8_decode('DESCRIPCIÓN'));
            $drogas     = $data['objetos']['drogas'];
            $objetos    = $data['objetos']['objetos'];
            /*Lineas añadidas para multiples vehiculos*/
            $vehiculosHead  = array('ESTATUS', 'DESCRIPCION');
            $vehiculos      = $data['objetos']['vehiculos'];
            $adiccionesHead = array('TIPO', utf8_decode('ROBA'), 'QUE SUELE ROBAR');
            $adicciones = $data['entrevista']['addiciones'];
            $motivoDelinquir = (isset($data['entrevista']['entrevista']->Motivo_Delinquir)) ? strtoupper($data['entrevista']['entrevista']->Motivo_Delinquir) : '';
            $participantes = $data['ubicacionHechos']['ubicacion_h']->No_Participantes;
            $detenidos = $data['ubicacionHechos']['ubicacion_h']->Total_Detenidos;
            $narrativaPeticionario = (isset($data['narrativas']['peticionario']->Narrativa_Hechos)) ? strtoupper($data['narrativas']['peticionario']->Narrativa_Hechos) : '';
            $narrativaDetenido = (isset($data['narrativas']['detenido']->Narrativa_Hechos)) ? strtoupper($data['narrativas']['detenido']->Narrativa_Hechos) : '';
            $narrativaElemento = (isset($data['narrativas']['elemento']->Narrativa_Hechos)) ? strtoupper($data['narrativas']['elemento']->Narrativa_Hechos) : '';
            $obserElement      = (isset($data['observacion']['observacion']->Observaciones)) ? strtoupper($data['observacion']['observacion']->Observaciones) : ''; //strtoupper($data['observacion']['observacion']->Observaciones);
            $elaboroFicha = strtoupper($data['remisionUser']['userCreate']->Nombre.' '.$data['remisionUser']['userCreate']->Ap_Paterno.' '.$data['remisionUser']['userCreate']->Ap_Materno.' Area: '.$data['remisionUser']['userCreate']->Area);
            $validoFicha = (isset($data['remisionUser']['userValidate']->Nombre)) ? strtoupper($data['remisionUser']['userValidate']->Nombre.' '.$data['remisionUser']['userValidate']->Ap_Paterno.' '.$data['remisionUser']['userValidate']->Ap_Materno) : '';

            if(count($armas)>0 || count($drogas)>0 ||count($objetos) || count($vehiculos) ){
                $this->SetTextColor(135, 45, 44);
                $this->Cell(190, 5, utf8_decode('OBJETOS ASEGURADOS'), 'B', 1, 'C');
                $this->Ln(3);
            }
            if(count($armas)>0){
                $this->Cell(190,  4.5, 'ARMAS RECUPERADAS:', 0, 1, 'C');
                $this->ln(1);
                foreach($armasHead as $armasH){
                    if($armasH === reset($armasHead)){
                        $this->Cell(50,5, $armasH, 'LBRT', 0, 'C');
                    }else{
                        if($armasH === end($armasHead)){
                            $this->Cell(115,5, $armasH, 'TRB', 1, 'C');
                        }else{
                            $this->Cell(25,5, $armasH, 'BRT',0, 'C');
                        }
                    }
                }
                $this->SetTextColor(128, 128, 128);
                foreach($armas as $arma){
                    $this->Cell(50, 5, utf8_decode($arma->Tipo_Arma), 0, 0, 'C');
                    $this->Cell(25, 5, utf8_decode($arma->Cantidad), 0, 0, 'C');
                    $this->MultiCell(115, 5, utf8_decode($arma->Descripcion_Arma), '','C');
                }
            }
            if(count($drogas)>0){
                $this->Ln(3);
                $this->SetTextColor(135, 45, 44);
                $this->Cell(190,  4.5, 'DROGAS RECUPERADAS:', 0, 1, 'C');
                $this->ln(1);
                foreach($drogasHead as $drogasH){
                    if($drogasH === reset($drogasHead)){
                        $this->Cell(70,5, $drogasH, 'LTRB', 0, 'C');
                    }else{
                        if($drogasH === end($drogasHead)){
                            $this->Cell(74,5, $drogasH, 'TRB', 1, 'C');
                        }else{
                            $this->Cell(23,5, $drogasH, 'TRB',0, 'C');
                        }
                    }
                }
                $this->SetTextColor(128, 128, 128);
                foreach($drogas as $droga){
                    $this->Cell(70, 5, utf8_decode($droga->Tipo_Droga), '', 0, 'C');
                    $this->Cell(23, 5, utf8_decode($droga->Cantidad), '', 0, 'C');
                    $this->Cell(25, 5, utf8_decode($droga->Unidad), '', 0, 'C');
                    $this->MultiCell(74, 5, utf8_decode($droga->Descripcion_Droga), '','C');
                }
            }
            if(count($objetos)>0){
                $this->Ln(3);
                $this->SetTextColor(135, 45, 44);
                $this->Cell(190,  4.5, 'OBJETOS RECUPERADOS:', 0, 1, 'C');
                $this->ln(1);
                $this->Cell(190,  5, utf8_decode('DESCRIPCIÓN'), 'LTRB', 1, 'C');
                $this->SetTextColor(128, 128, 128);
                foreach($objetos as $objeto){
                    $this->MultiCell(190,  4.5,utf8_decode($objeto->Descripcion_Objeto), 0, 'C');
                }
                
                
            }
            if(count($vehiculos)>0){
                // se cambia la manera en que se imprime los vehiculos asegurados, para que se recorra el arreglo
                //y se añada como una tabla con sus respectivos columnas
                    $this->Ln(3);
                    $this->SetTextColor(135, 45, 44);
                    $this->Cell(190,  4.5, 'VEHICULOS ASEGURADOS:', 0, 1, 'C');
                    foreach($vehiculosHead as $vehiculoH){
                        if($vehiculoH === reset($vehiculosHead)){
                            $this->Cell(25,5, $vehiculoH, 'LBRT', 0, 'C');
                        }else{
                            if($vehiculoH === end($vehiculosHead)){
                                $this->Cell(165,5, $vehiculoH, 'TRB', 1, 'C');
                            }else{
                                $this->Cell(20,5, $vehiculoH, 'BRT',0, 'C');
                            }
                        }
                    }
                    $this->SetTextColor(128, 128, 128);
                foreach($vehiculos as $vehiculo){
                    if($vehiculo->Tipo_Situacion==0){
                        $this->Cell(25, 5, utf8_decode("Recuperado"), 0, 0, 'C');
                    }
                    else{
                        $this->Cell(25, 5, utf8_decode("Involucrado"), 0, 0, 'C');
                    }
                    $vehiculos_cad="";
                    $vehiculos_cad.= "PLACA: ";
                    $vehiculos_cad.= $vehiculo->Placa_Vehiculo.", ";
                    $vehiculos_cad.= "MARCA: ";
                    $vehiculos_cad.= $vehiculo->Marca.", ";
                    $vehiculos_cad.= "SUBMARCA: ";
                    $vehiculos_cad.= $vehiculo->Submarca.", ";
                    $vehiculos_cad.= "TIPO: ";
                    $vehiculos_cad.= $vehiculo->Tipo_Vehiculo.", ";
                    $vehiculos_cad.= "MODELOS: ";
                    $vehiculos_cad.= $vehiculo->Modelo.", ";
                    $vehiculos_cad.= "COLOR: ";
                    $vehiculos_cad.= $vehiculo->Color.", ";
                    $vehiculos_cad.= "PROCEDENCIA: ";
                    $vehiculos_cad.= $vehiculo->Procedencia_Vehiculo.", ";
                    $vehiculos_cad.= "NO.SERIE: ";
                    $vehiculos_cad.= $vehiculo->No_Serie.", ";
                    $vehiculos_cad.= "SEÑA PARTICULAS: ";
                    $vehiculos_cad.= $vehiculo->Senia_Particular.", ";
                    $vehiculos_cad.= "OBSERVACIONES: ";
                    $vehiculos_cad.= $vehiculo->Observacion_Vehiculo.", ";
                    $this->MultiCell(165, 5, utf8_decode($vehiculos_cad), '','C');
                }
            }
            if(count($adicciones)>0){
                $this->Ln(6);
                $this->SetTextColor(135, 45, 44);
                $this->Cell(190,  4.5, 'ADICCIONES:', 0, 1, 'C');
                $this->ln(1);
                foreach($adiccionesHead as $adiccionesH){
                    if($adiccionesH === reset($adiccionesHead)){
                        $this->Cell(70,5, $adiccionesH, 'LTRB', 0, 'C');
                    }else{
                        if($adiccionesH === end($adiccionesHead)){
                            $this->Cell(90,5, $adiccionesH, 'TRB', 1, 'C');
                        }else{
                            $this->Cell(30,5, $adiccionesH, 'TRB',0, 'C');
                        }
                    }
                }
                $this->SetTextColor(128, 128, 128);
                foreach($adicciones as $adiccion){
                    $this->Cell(70, 5, $adiccion->Nombre_Adiccion, '', 0, 'C');
                    $this->Cell(30, 5, utf8_decode(($adiccion->Robo_Para_Consumo == 0) ? 'NO' : 'SÍ'), '', 0, 'C');
                    $this->Cell(90, 5, $adiccion->Que_Suele_Robar, '', 1, 'C');
                }
            }
            $y1 = $this->GetY();
            $this->Ln(2);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(180, 4, utf8_decode('MOTIVO DEL DELITO:'), 0, 1);
            $this->Cell(5, 4);
            $this->SetTextColor(128, 128, 128);
            if(strlen($motivoDelinquir)>0){
                $this->MultiCell(180, 4, utf8_decode($motivoDelinquir), 0, 'J');
            }
            $this->ln(1.5);
            $this->Cell(5,4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(69, 4, utf8_decode('NÚMERO TOTAL DE PARTICIPANTES:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(20, 4, utf8_decode($participantes));
            $this->SetTextColor(51, 51, 51);
            $this->Cell(69, 4, utf8_decode('NÚMERO TOTAL DE DETENIDOS:'));
            $this->SetTextColor(128, 128, 128);
            $this->Cell(20, 4, utf8_decode($detenidos), 0, 1);
            $this->Ln(2);
            $y2 = $this->GetY();
            $this->SetY($y1);
            $this->Cell(190, $y2-$y1, '', 1, 1);
            $this->ln(4);
           
            $this->SetTextColor(135, 45, 44);
            $this->Cell(190, 5, utf8_decode('ANEXO NARRATIVAS'), 0, 1, 'C');
            $this->ln(2);
            $this->ln(1.5);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(180, 4, utf8_decode('NARRATIVA DE HECHOS DEL AFECTADO/VÍCTIMA/PETICIONARIO:'), 0, 1);
            $this->Cell(5, 4);
            $this->SetTextColor(128, 128, 128);
            if(strlen($narrativaPeticionario)>0){
                $this->MultiCell(180, 4, utf8_decode($narrativaPeticionario), 0, 'J');
            }
            $this->ln(2);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(180, 4, utf8_decode('NARRATIVA DE HECHOS DEL DETENIDO:'), 0, 1);
            $this->Cell(5, 4);
            $this->SetTextColor(128, 128, 128);
            if(strlen($narrativaDetenido)>0){
                $this->MultiCell(180, 4, utf8_decode($narrativaDetenido), 0, 'J');
            }
            $this->ln(2);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(180, 4, utf8_decode('NARRATIVA DE HECHOS DEL ELEMENTO DE SEGURIDAD:'), 0, 1);
            $this->Cell(5, 4);
            $this->SetTextColor(128, 128, 128);
            if(strlen($narrativaElemento)>0){
                $this->MultiCell(180, 4, utf8_decode($narrativaElemento), 0, 'J');
            }
            $this->ln(2);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(180, 4, utf8_decode('OBSERVACIONES:'), 0, 1);
            $this->Cell(5, 4);
            $this->SetTextColor(128, 128, 128);
            if(strlen($obserElement)>0){
                $this->MultiCell(180, 4, utf8_decode($obserElement), 0, 'J');
            }
            $this->ln(2);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(180, 4, utf8_decode('ELABORÓ FICHA:'), 0, 1);
            $this->Cell(5, 4);
            $this->SetTextColor(128, 128, 128);
            if(strlen($elaboroFicha)>0){
                $this->MultiCell(180, 4, utf8_decode($elaboroFicha), 0, 1);
            }
            $this->ln(1.5);
            $this->Cell(5, 4);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(180, 4, utf8_decode('VERIFICÓ LA FICHA:'), 0, 1);
            $this->Cell(5, 4);
            $this->SetTextColor(128, 128, 128);
            if(strlen($validoFicha)>0){
                $this->MultiCell(180, 4, utf8_decode($validoFicha), 0, 1);
            }
            $this->Ln(2);
        }

        function FourPage($data, $base_url)
        {
            $noRemision         = $data['principales']->No_Remision;
            $noFicha            = $data['principales']->No_Ficha;
            $senas = $data['senas']['senas'];
            $tatuajesArray = $cicatricesArray = $lunaresArray = $perforacionesArray = $mutilacionesArray = array();
            foreach($senas as $sena){
                switch($sena->Tipo_Senia_Particular){
                    case 'TATUAJES':
                        array_push($tatuajesArray,$sena);
                    break;
                    case 'CICATRICES':
                        array_push($cicatricesArray,$sena);
                    break;
                    case 'LUNARES, MANCHAS Y/O VERRUGAS':
                        array_push($lunaresArray,$sena);
                    break;
                    case 'PERFORACIONES':
                        array_push($perforacionesArray,$sena);
                    break;
                    case 'MUTILACIONES/MALFORMACIONES':
                        array_push($mutilacionesArray,$sena);
                    break;
                }
            }
            $path = $base_url.'public/files/Remisiones/'.$noFicha.'/SenasParticulares/'.$noRemision.'/';
            if(count($tatuajesArray)>0){
                $this->AddPage();
                $this->SetTextColor(135, 45, 44);
                $this->Cell(190, 5, utf8_decode('ANEXO DE TATUAJES'), 'B', 1, 'C');
                $this->ln(2);
                foreach($tatuajesArray as $key=>$tatuaje){
                    $y1 = $this->GetY();
                    $this->ContentTatuajes($tatuaje, $path, $y1);
                    $y2 = $this->GetY();
                    if($y2 > 240 & $tatuaje != end($tatuajesArray)){
                        $this->AddPage();
                    }
                }
                $this->Ln(2);
            }
            if(count($cicatricesArray)>0){
                $this->AddPage();
                $this->SetFillColor(123, 28, 30);
                $this->SetTextColor(135, 45, 44);
                $this->Cell(190, 5, utf8_decode('ANEXO DE CICATRICES'), 'B', 1, 'C');
                $this->SetTextColor(112,112,112);
                $this->Ln(2);
                foreach($cicatricesArray as $key=>$cicatriz){
                    $y1 = $this->GetY();
                    $this->ContentCicatrices($cicatriz, $path, $y1);
                    $y2 = $this->GetY();
                    if($y2 > 240 & $cicatriz != end($cicatricesArray)){
                        $this->AddPage();
                    }
                }
                $this->Ln(2);
            }
            if(count($lunaresArray)>0){
                $this->AddPage();
                $this->SetFillColor(123, 28, 30);
                $this->SetTextColor(135, 45, 44);
                $this->Cell(190, 5, utf8_decode('ANEXO DE LUNARES, MANCHAS Y/O VERRUGAS'), 'B', 1, 'C');
                $this->SetTextColor(112,112,112);
                $this->Ln(2);
                foreach($lunaresArray as $key=>$lunar){
                    $y1 = $this->GetY();
                    $this->ContentLunares($lunar, $path, $y1);
                    $y2 = $this->GetY();
                    if($y2 > 240 & $lunar != end($lunaresArray)){
                        $this->AddPage();
                    }
                }
                $this->Ln(2);
            }
            if(count($perforacionesArray)>0){
                $this->AddPage();
                $this->SetFillColor(123, 28, 30);
                $this->SetTextColor(135, 45, 44);
                $this->Cell(190, 5, utf8_decode('ANEXO DE PERFORACIONES'), 'B', 1, 'C');
                $this->SetTextColor(112,112,112);
                $this->Ln(2);
                foreach($perforacionesArray as $key=>$perforacion){
                    $y1 = $this->GetY();
                    $this->ContentPerforaciones($perforacion, $path, $y1);
                    $y2 = $this->GetY();
                    if($y2 > 240 & $perforacion != end($perforacionesArray)){
                        $this->AddPage();
                    }
                }
                $this->Ln(2);
            }
            if(count($mutilacionesArray)>0){
                $this->AddPage();
                $this->SetFillColor(123, 28, 30);
                $this->SetTextColor(135, 45, 44);
                $this->Cell(190, 5, utf8_decode('ANEXO DE MUTILACIONES/MALFORMACIONES'), 'B', 1, 'C');
                $this->SetTextColor(112,112,112);
                $this->Ln(2);
                foreach($mutilacionesArray as $key=>$mutilacion){
                    $y1 = $this->GetY();
                    $this->ContentMutilaciones($mutilacion, $path, $y1);
                    $y2 = $this->GetY();
                    if($y2 > 240 & $mutilacion != end($mutilacionesArray)){
                        $this->AddPage();
                    }
                }
            }
            $this->Ln(2);
        }

        function ContentMutilaciones($mutilacion, $path, $y1)
        {
            $image = $path.$mutilacion->Path_Imagen;
            if(getimagesize($image)){
                $type = exif_imagetype($image);
                $imgInfo = getimagesize($image); 
                $extension = '';
                switch($type){
                    case 1:
                        $extension = 'gif';
                    break;
                    case 2:
                        $extension = 'jpeg';
                    break;
                    case 3:
                        $extension = 'png';
                    break;
                }
                $widthImage = ($imgInfo[0]*80)/$imgInfo[1];
                $x = (200-$widthImage)/2;
                $this->Image($image,$x,$y1, 0, 80, $extension);
            }
            $this->SetY($y1+80);
            $this->ln(6);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(5, 4);
            $this->Cell(180, 4, utf8_decode('PARTE DEL CUERPO DONDE SE ENCUENTRA LA MUTILACIÓN/MALFORMACIÓN:'), 0, 1);
            $this->SetTextColor(128, 128, 128);
            if(strlen($mutilacion->Ubicacion_Corporal)>0){
                $this->Cell(5, 4);
                $this->MultiCell(180, 4, utf8_decode($mutilacion->Ubicacion_Corporal), 0, 'J');
            }
            $this->ln(1.5);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(5, 4);
            $this->Cell(180, 4, utf8_decode('DESCRIPCIÓN:'), 0, 1);
            $this->SetTextColor(128, 128, 128);
            if(strlen($mutilacion->Descripcion)>0){
                $this->Cell(5, 4);
                $this->MultiCell(180, 4, utf8_decode($mutilacion->Descripcion), 0, 'J');
            }
            $this->ln(5);
        }

        function ContentPerforaciones($perforacion, $path, $y1)
        {
            $image = $path.$perforacion->Path_Imagen;
            if(getimagesize($image)){
                $type = exif_imagetype($image);
                $imgInfo = getimagesize($image); 
                $extension = '';
                switch($type){
                    case 1:
                        $extension = 'gif';
                    break;
                    case 2:
                        $extension = 'jpeg';
                    break;
                    case 3:
                        $extension = 'png';
                    break;
                }
                $widthImage = ($imgInfo[0]*80)/$imgInfo[1];
                $x = (200-$widthImage)/2;
                $this->Image($image,$x,$y1, 0, 80, $extension);
            }
            $this->SetY($y1+80);
            $this->ln(6);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(5, 4);
            $this->Cell(180, 4, utf8_decode('PARTE DEL CUERPO DONDE SE ENCUENTRA LA PERFORACIÓN:'), 0, 1);
            $this->SetTextColor(128, 128, 128);
            if(strlen($perforacion->Ubicacion_Corporal)>0){
                $this->Cell(5, 4);
                $this->MultiCell(180, 4, utf8_decode($perforacion->Ubicacion_Corporal), 0, 'J');
            }
            $this->ln(1.5);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(5, 4);
            $this->Cell(180, 4, utf8_decode('DESCRIPCIÓN:'), 0, 1);
            $this->SetTextColor(128, 128, 128);
            if(strlen($perforacion->Descripcion)>0){
                $this->Cell(5, 4);
                $this->MultiCell(180, 4, utf8_decode($perforacion->Descripcion), 0, 'J');
            }
            $this->ln(5);
        }

        function ContentLunares($lunar, $path, $y1)
        {
            $image = $path.$lunar->Path_Imagen;
            if(getimagesize($image)){
                $type = exif_imagetype($image);
                $imgInfo = getimagesize($image); 
                $extension = '';
                switch($type){
                    case 1:
                        $extension = 'gif';
                    break;
                    case 2:
                        $extension = 'jpeg';
                    break;
                    case 3:
                        $extension = 'png';
                    break;
                }
                $widthImage = ($imgInfo[0]*80)/$imgInfo[1];
                $x = (200-$widthImage)/2;
                $this->Image($image,$x,$y1, 0, 80, $extension);
            }
            $this->SetY($y1+80);
            $this->ln(6);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(5, 4);
            $this->Cell(180, 4, utf8_decode('PARTE DEL CUERPO DONDE SE ENCUENTRA EL LUNAR, MANCHAS Y/O VERRUGAS:'), 0, 1);
            $this->SetTextColor(128, 128, 128);
            if(strlen($lunar->Ubicacion_Corporal)>0){
                $this->Cell(5, 4);
                $this->MultiCell(180, 4, utf8_decode($lunar->Ubicacion_Corporal), 0, 'J');
            }
            $this->ln(1.5);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(5, 4);
            $this->Cell(180, 4, utf8_decode('DESCRIPCIÓN:'), 0, 1);
            $this->SetTextColor(128, 128, 128);
            if(strlen($lunar->Descripcion)>0){
                $this->Cell(5, 4);
                $this->MultiCell(180, 4, utf8_decode($lunar->Descripcion), 0, 'J');
            }
            $this->ln(5);
        }

        function ContentCicatrices($cicatriz, $path, $y1)
        {
            $image = $path.$cicatriz->Path_Imagen;
            if(getimagesize($image)){
                $type = exif_imagetype($image);
                $imgInfo = getimagesize($image); 
                $extension = '';
                switch($type){
                    case 1:
                        $extension = 'gif';
                    break;
                    case 2:
                        $extension = 'jpeg';
                    break;
                    case 3:
                        $extension = 'png';
                    break;
                }
                $widthImage = ($imgInfo[0]*80)/$imgInfo[1];
                $x = (200-$widthImage)/2;
                $this->Image($image,$x,$y1, 0, 80, $extension);
            }
            $this->SetY($y1+80);
            $this->ln(6);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(5, 4);
            $this->Cell(180, 4, 'PARTE DEL CUERPO DONDE SE ENCUENTRA LA CICATRIZ:', 0, 1);
            $this->SetTextColor(128, 128, 128);
            if(strlen($cicatriz->Ubicacion_Corporal)>0){
                $this->Cell(5, 4);
                $this->MultiCell(180, 4, utf8_decode($cicatriz->Ubicacion_Corporal), 0, 'J');
            }
            $this->ln(1.5);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(5, 4);
            $this->Cell(180, 4, utf8_decode('DESCRIPCIÓN:'), 0, 1);
            $this->SetTextColor(128, 128, 128);
            if(strlen($cicatriz->Descripcion)>0){
                $this->Cell(5, 4);
                $this->MultiCell(180, 4, utf8_decode($cicatriz->Descripcion), 0, 'J');
            }
            $this->ln(5);

        }

        function ContentTatuajes($tatuaje, $path, $y1)
        {
            $this->ln(1);
            $image = $path.$tatuaje->Path_Imagen;
            if(getimagesize($image)){
                $type = exif_imagetype($image);
                $imgInfo = getimagesize($image); 
                $extension = '';
                switch($type){
                    case 1:
                        $extension = 'gif';
                    break;
                    case 2:
                        $extension = 'jpeg';
                    break;
                    case 3:
                        $extension = 'png';
                    break;
                }
                $widthImage = ($imgInfo[0]*80)/$imgInfo[1];
                $x = (200-$widthImage)/2;
                $this->Image($image,$x,$y1, 0, 80, $extension);
            }
            $this->SetY($y1+80);
            $this->ln(6);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(5, 4);
            $this->Cell(180, 4, 'PARTE DEL CUERPO DONDE SE ENCUENTRA EL TATUAJE:', 0, 1);
            $this->SetTextColor(128, 128, 128);
            if(strlen($tatuaje->Ubicacion_Corporal)>0){
                $this->Cell(5, 4);
                $this->MultiCell(180, 4, utf8_decode($tatuaje->Ubicacion_Corporal), 0, 1);
            }
            $this->ln(1.5);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(5, 4);
            $this->Cell(35, 4, 'TIPO DE TATUAJE:');
            $this->SetTextColor(128, 128, 128);
            if(strlen($tatuaje->Clasificacion)>0){
                $this->MultiCell(145, 4, utf8_decode($tatuaje->Clasificacion), 0, 1);
            }
            $this->ln(1.5);
            $this->SetTextColor(51, 51, 51);
            $this->Cell(5, 4);
            $this->Cell(180, 4, utf8_decode('DESCRIPCIÓN:'), 0, 1);
            $this->SetTextColor(128, 128, 128);
            if(strlen($tatuaje->Descripcion)>0){
                $this->Cell(5, 4);
                $this->MultiCell(180, 4, utf8_decode($tatuaje->Descripcion), 0, 'J');
            }
            $this->ln(5);
        }
        
        function ContentPhotos($title, $apartado, $image1, $image2, $image3)
        {
            ($apartado == 'Rostro') ? $heightContent = 42.6 : $heightContent = 96;
            $this->SetTextColor(135, 45, 44);
            $this->Cell(190, 5, utf8_decode($title), 'B', 1, 'C');
            $this->Cell(190, 2, '', 0, 1);
            $this->SetTextColor(128, 128, 128);
            $this->Cell(63.3, 4, 'IZQUIERDO', 0, 0, 'C');
            $this->Cell(63.3, 4, 'FRENTE', 0, 0, 'C');
            $this->Cell(63.3, 4, 'DERECHO', 0, 1, 'C');
            $getY = $this->GetY();
            $this->Cell(190, $heightContent, '', 0, 1);
            if($image1 != '' && getimagesize($image1)){
                $type = exif_imagetype($image1);
                $extension = '';
                $width = $height = $x = $y = 0;
                $widthImg = getimagesize($image1)[0];
                $heightImg = getimagesize($image1)[1];

                ($widthImg > $heightImg) ? $width = 63.3 : $height = 96;

                switch($type){
                    case 1:
                        $extension = 'gif';
                    break;
                    case 2:
                        $extension = 'jpeg';
                    break;
                    case 3:
                        $extension = 'png';
                    break;
                }

                switch($apartado){
                    case 'Rostro':
                        $this->Image($image1,10,$getY, $width, $height, $extension);
                    break;
                    case 'Cuerpo':
                        $this->Image($image1,10,$getY, $width, $height, $extension);
                    break;
                }
                
            }
            if($image2 != '' && getimagesize($image2)){
                $type = exif_imagetype($image2);
                $extension = '';
                $width = $height = $x = $y = 0;
                $widthImg = getimagesize($image2)[0];
                $heightImg = getimagesize($image2)[1];

                ($widthImg > $heightImg) ? $width = 63.3 : $height = 96;

                switch($type){
                    case 1:
                        $extension = 'gif';
                    break;
                    case 2:
                        $extension = 'jpeg';
                    break;
                    case 3:
                        $extension = 'png';
                    break;
                }

                switch($apartado){
                    case 'Rostro':
                        $this->Image($image2,73.3,$getY, $width, $height, $extension);
                    break;
                    case 'Cuerpo':
                        $this->Image($image2,74,$getY, $width, $height, $extension);
                    break;
                }
                
            }
            if($image3 != '' && getimagesize($image3)){
                $type = exif_imagetype($image3);
                $extension = '';
                $width = $height = $x = $y = 0;
                $widthImg = getimagesize($image3)[0];
                $heightImg = getimagesize($image3)[1];

                ($widthImg > $heightImg) ? $width = 63.3 : $height = 96;

                switch($type){
                    case 1:
                        $extension = 'gif';
                    break;
                    case 2:
                        $extension = 'jpeg';
                    break;
                    case 3:
                        $extension = 'png';
                    break;
                }

                switch($apartado){
                    case 'Rostro':
                        $this->Image($image3,136.6,$getY, $width, $height, $extension);
                    break;
                    case 'Cuerpo':
                        $this->Image($image3,137,$getY, $width, $height, $extension);
                    break;
                }
                
            }
        }
        
        function Footer()
        {
            $this->SetY(-8);
            $this->SetFont('Avenir','',7);
            $this->Cell(0,10,utf8_decode('NÚMERO DE VALIDACIÓN CONTRALORÍA'),0,0,'C');
            $this->Cell(0,10,$this->PageNo().'/{nb}',0,0,'R');
        }

    }

    $pdf = new PDF();
    $pdf->AddFont('Avenir','','avenir.php');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->OnePage($data, base_url);
    $pdf->AddPage();
    $pdf->TwoPage($data, base_url);
    $pdf->AddPage();
     /*Se añade la nueva funcion que contiene solo la imagen de los objetos asegurados*/
     $pdf->TwoPageHalf($data, base_url);
    $pdf->AddPage();
    $pdf->ThreePage($data);
    if(count($data['senas']['senas']) > 0){
        $pdf->FourPage($data, base_url);
    }
    $pdf->Output();
?>
