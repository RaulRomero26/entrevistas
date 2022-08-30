<?php
    class PDF extends FPDF
    {
        function OnePage($data, $base_url)
        {
            /* ----- ----- ----- Formato ----- ----- ----- */
            $this->Image($base_url.'public/media/images/logo.png',32,22,23);
            $puesta = $data['data_puesta']['puesta'];
            $this->SetFont('Arial','B',6.5);
            $this->SetFillColor(0, 0, 0);
            $this->Cell(190, 4, '', 0, 1);
            $this->Cell(8,   8);
            $this->Cell(52,  8, utf8_decode('SISTEMA NACIONAL DE SEGURIDAD PÚBLICA'));
            $this->Cell(36,  8);
            $this->SetFont('Arial','B',8);
            $this->Cell(92,  8, utf8_decode('NO. DE REFERENCIA'), 'LRT', 0, 'C');
            $this->Cell(5,   8, '', '', 1);
            $this->Cell(96,  4, '', 'R');
            $this->Cell(4,   4);
            $this->SetFillColor(196, 189, 151);

            /* ----- ----- ----- Valor numero de referencia ----- ----- ----- */
            $noReferencia = $puesta->Num_Referencia;
            (isset($noReferencia)) ? $noReferencia = strtoupper($noReferencia) : $noReferencia = array();

            for($i=0;$i<22;$i++){
                switch($i){
                    case 0:
                    case 1:
                        $this->Cell(4,   4, (isset($noReferencia[$i])) ? strtoupper($noReferencia[$i]) : '', 'LRB', 0, 'C', true);
                    break;
                    case 2:
                    case 3:
                        $this->Cell(4,   4, (isset($noReferencia[$i])) ? strtoupper($noReferencia[$i]) : '', 'LRB', 0, 'C');
                    break;
                    case 4:
                    case 5:
                        $this->Cell(4,   4, (isset($noReferencia[$i])) ? strtoupper($noReferencia[$i]) : '', 'LRB', 0, 'C', true);
                    break;
                    case 6:
                    case 7:
                    case 8:
                        $this->Cell(4,   4, (isset($noReferencia[$i])) ? strtoupper($noReferencia[$i]) : '', 'LRB', 0, 'C');
                    break;
                    case 9:
                    case 10:
                        $this->Cell(4,   4, (isset($noReferencia[$i])) ? strtoupper($noReferencia[$i]) : '', 'LRB', 0, 'C', true);
                    break;
                    case 11:
                    case 12:
                        $this->Cell(4,   4, (isset($noReferencia[$i])) ? strtoupper($noReferencia[$i]) : '', 'LRB', 0, 'C');
                    break;
                    case 13:
                    case 14:
                    case 15:
                    case 16:
                        $this->Cell(4,   4, (isset($noReferencia[$i])) ? strtoupper($noReferencia[$i]) : '', 'LRB', 0, 'C', true);
                    break;
                    case 17:
                    case 18:
                        $this->Cell(4,   4, (isset($noReferencia[$i])) ? strtoupper($noReferencia[$i]) : '', 'LRB', 0, 'C');
                    break;
                    case 19:
                    case 20:
                        $this->Cell(4,   4, (isset($noReferencia[$i])) ? strtoupper($noReferencia[$i]) : '', 'LRB', 0, 'C', true);
                    break;
                    default:
                        $this->Cell(4,   4, '', 'R', 1);
                    break;
                }
            }
            $this->Cell(96,  4, '', 'R');
            $this->Cell(4,   4);

            $dataRef = array(
                0 => array(
                    'text' => 'EDO',
                    'esp' => 2,
                    'fill' => true
                ),
                1 => array(
                    'text' => 'INST',
                    'esp' => 2,
                    'fill' => false
                ),
                2 => array(
                    'text' => 'GOB',
                    'esp' => 2,
                    'fill' => true
                ),
                3 => array(
                    'text' => 'MPIO',
                    'esp' => 3,
                    'fill' => false
                ),
                4 => array(
                    'text' => 'D D',
                    'esp' => 2,
                    'fill' => true
                ),
                5 => array(
                    'text' => 'M M',
                    'esp' => 2,
                    'fill' => false
                ),
                6 => array(
                    'text' => 'A  A  A  A',
                    'esp' => 4,
                    'fill' => true
                ),
                7 => array(
                    'text' => 'H  H',
                    'esp' => 2,
                    'fill' => false
                ),
                8 => array(
                    'text' => 'M  M',
                    'esp' => 2,
                    'fill' => true
                ),
            );

            foreach($dataRef as $dat){
                $this->Cell(4*$dat['esp'],   4, $dat['text'], 'T', 0, 'C', $dat['fill']);
            }
            $this->Cell(4,   4, '', 'R', 1);
            $this->Cell(96,  2);
            $this->Cell(92,  2, '', 'LRB');
            $this->Cell(5,   2, '', 0, 1);
            $this->Cell(96,  8);
            $this->Cell(92,  8, 'NO. DE FOLIO ASIGNADO POR EL SISTEMA', 'LR', 0, 'C');
            $this->Cell(5,   8, '', 0, 1);
            for($j=0;$j<count($data['AnexosA']);$j++){
                $this->Cell(96,  4, '', 'R');
                $numDetencionDetenido = str_split($data['AnexosA'][$j]->Num_Detencion);
                for($i=0;$i<23;$i++){
                    $this->Cell(4,  4, (isset($numDetencionDetenido[$i])) ? utf8_decode(strtoupper($numDetencionDetenido[$i])) : '', 'RB');
                }
                $this->Cell(5,   4, '', 0, 1);
            }
            if(count($data['AnexosA']) == 0) $this->Cell(96,   4, '', 'R');
            if(count($data['AnexosA']) == 0) $this->Cell(92,   4, '', 'RB', 1);
            $this->Ln(2);
            $this->Cell(8,   4);
            $this->Cell(52,  4, 'CNSP', 0, 0, 'C');
            $this->Cell(36,  4);
            $this->Cell(92,  4, 'FOLIO IPH: '.$puesta->Folio_IPH, 0, 0, 'C');
            $this->Cell(5,   4, '', 0, 1);
            $this->Ln(5);
            $this->Cell(3,   4);
            $this->Cell(190, 4, 'INFORME POLICIAL HOMOLOGADO (IPH2019)', 0, 1, 'C');
            $this->Ln(1);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Ln(1);
            $this->Cell(3, 4);
            $this->Cell(190, 4, 'HECHO PROBABLEMENTE DELICTIVO)',       0, 1, 'C', true);
            $this->Ln(3);
            $this->SetTextColor(0,0,0);
            $this->Cell(6, 4);
            $this->Cell(190, 4, utf8_decode('SECCIÓN 1. PUESTA A DISPOSICIÓN'), 0, 1);
            $this->Ln(1);
            $this->SetFont('Arial','B',7);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado 1.1 Fecha y hora de la puesta a disposición'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',8);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   5);
            $this->Cell(97,  5, '', 'LR');
            $this->Cell(93,  5, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(3,   4, '', 'L');
            $this->Cell(12,  4, 'Fecha:');
            if(isset($puesta->Fecha_Hora)){
                $fechaPuesta = str_split(implode(array_reverse(explode('-',(explode(' ', $puesta->Fecha_Hora))[0]))));
                $horaPuesta = str_replace(':', '', (explode(' ', $puesta->Fecha_Hora))[1]);
            }else{
                $fechaPuesta = array();
                $horaPuesta = array();
            }

            for($i=0; $i<8; $i++){
                $this->Cell(4, 4, (isset($fechaPuesta[$i])) ? $fechaPuesta[$i] : '', 'LRB', 0, 'C');
            }
            $this->Cell(2,  4);
            $this->Cell(10, 4, 'Hora:');
            $this->Cell(4,  4, (isset($horaPuesta[0])) ? $horaPuesta[0] : '', 'LRB', 0, 'C');
            $this->Cell(4,  4, (isset($horaPuesta[1])) ? $horaPuesta[1] : '', 'LRB', 0, 'C');
            $this->Cell(4,  4, ':', 0, 0, 'C');
            $this->Cell(4,  4, (isset($horaPuesta[2])) ? $horaPuesta[2] : '', 'LRB', 0, 'C');
            $this->Cell(4,  4, (isset($horaPuesta[3])) ? $horaPuesta[3] : '', 'LRB', 0, 'C');
            $this->Cell(2,  4);
            $this->Cell(16, 4, '(24 horas)', 'R');
            $this->Cell(4,  4);
            $this->Cell(25, 4, 'No. expendiente:');

            (isset($puesta->Num_Expediente)) ? $numExpediente = strtoupper($puesta->Num_Expediente) : $numExpediente = array();
            for($i=0;$i<14;$i++){
                $this->Cell(4, 4, (isset($numExpediente[$i])) ? $numExpediente[$i] : '', 'LRB', 0, 'C');
            }

            $this->Cell(8,    4, '',      'R', 1);
            $this->Cell(3,   5);
            $this->Cell(15,   4, '',      'L');
            $dataDate = array(
                0 => array(
                    'text' => 'D  D',
                    'esp' => 2
                ),
                1 => array(
                    'text' => 'M  M',
                    'esp' => 2
                ),
                2 => array(
                    'text' => 'A  A  A  A',
                    'esp' => 4
                )
            );

            foreach($dataDate as $dat){
                $this->Cell(4*$dat['esp'],   4, $dat['text'], 'T', 0, 'C');
            }
            $this->Cell(12,   4);
            $this->Cell(4,    4, 'h', 0, 0, 'C');
            $this->Cell(4,    4, 'h', 0, 0, 'C');
            $this->Cell(4,    4, '');
            $this->Cell(4,    4, 'm', 0, 0, 'C');
            $this->Cell(4,    4, 'm', 0, 0, 'C');
            $this->Cell(18,   4, '', 'R');
            $this->Cell(93,   3, '',      'R', 1);
            $this->Cell(3,    3);
            $this->Cell(97,   3, '',      'LRB');
            $this->Cell(93,   3, '',      'RB', 1);
            $this->Cell(3,    7);
            $this->Cell(190,  7, utf8_decode('Señale con una "X" el o los Anexos entregados e indique la cantidad de cada uno de ellos (sólo entregue los Anexos utilizados).'), 'LR',1);
            $this->Cell(3,    2);
            $this->Cell(190,  2, '', 'RL', 1);
            $this->Cell(3,   5);
            $this->Cell(3,    4, '',      'L');
            $this->SetFont('Arial','B',8);
            $this->Cell(13,   4, 'Anexo A.');
            $this->SetFont('Arial','',8);
            $this->Cell(40,   4, utf8_decode('Detención(es)'));

            $anexosA = count($data['AnexosA']);
            $numAnexoA = [0,0,0];
            $existA = '';
            if($anexosA > 0){
                $anexosA = strrev(strval($anexosA));
                for($i=0; $i<strlen($anexosA); $i++)
                    $numAnexoA[$i] = intval($anexosA[$i]);
                $numAnexoA = array_reverse($numAnexoA);
                $existA = 'X';
            }
            $this->Cell(4,   4, $existA, 'LRBT', 0, 'C');
            $this->Cell(4,   4);
            foreach($numAnexoA as $num){
                $this->Cell(4, 4, $num, 'LRB');
            }
            $this->Cell(3,   4);
            $this->SetFont('Arial','B',8);
            $this->Cell(13,  4, 'Anexo E.');
            $this->SetFont('Arial','',8);
            $this->Cell(74,  4, 'Entrevistas');

            $anexosE = count($data['AnexosE']);
            $numAnexoE = [0,0,0];
            $existE = '';
            if($anexosE > 0){
                $anexosE = strrev(strval($anexosE));
                for($i=0; $i<strlen($anexosE); $i++)
                    $numAnexoE[$i] = intval($anexosE[$i]);
                $numAnexoE = array_reverse($numAnexoE);
                $existE = 'X';
            }
            $this->Cell(4, 4, $existE, 'LRBT', 0, 'C');
            $this->Cell(4, 4);
            foreach($numAnexoE as $num){
                $this->Cell(4, 4, $num, 'LRB');
            }
            $this->Cell(4,   4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(3,   4, '',      'L');
            $this->SetFont('Arial','B',8);
            $this->Cell(13,  4, 'Anexo B.');
            $this->SetFont('Arial','',8);
            $this->Cell(40,  4, 'Informe del uso de la fuerza');

            $anexosB = count($data['AnexosB']);
            $numAnexoB = [0,0,0];
            $existB = '';
            if($anexosB > 0){
                $anexosB = strrev(strval($anexosB));
                for($i=0; $i<strlen($anexosB); $i++)
                    $numAnexoB[$i] = intval($anexosB[$i]);
                $numAnexoB = array_reverse($numAnexoB);
                $existB = 'X';
            }
            $this->Cell(4,   4, $existB, 'LRBT', 0, 'C');
            $this->Cell(4,   4);
            foreach($numAnexoB as $num){
                $this->Cell(4, 4, $num, 'LRB');
            }
            $this->Cell(3,   4);

            $this->SetFont('Arial','B',8);
            $this->Cell(13,  4, 'Anexo F.');
            $this->SetFont('Arial','',8);
            $this->Cell(74,  4, utf8_decode('Entrega - recepción del lugar de la intervención'));

            $anexosF = ($data['AnexosF']) ? count($data['AnexosF'])/3 : 0;
            $numAnexoF = [0,0,0];
            $existF = '';
            if($anexosF > 0){
                $anexosF = strrev(strval($anexosF));
                for($i=0; $i<strlen($anexosF); $i++)
                    $numAnexoF[$i] = intval($anexosF[$i]);
                $numAnexoF = array_reverse($numAnexoF);
                $existF = 'X';
            }
            $this->Cell(4,   4, $existF, 'LRBT', 0, 'C');
            $this->Cell(4,   4);
            foreach($numAnexoF as $num){
                $this->Cell(4, 4, $num, 'LRB');
            }
            $this->Cell(4,   4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(3,   4, '',      'L');
            $this->SetFont('Arial','B',8);
            $this->Cell(13,  4, 'Anexo C.');
            $this->SetFont('Arial','',8);
            $this->Cell(40,  4, utf8_decode('Inspección de vehículo'));

            $anexosC = count($data['AnexosC']);
            $numAnexoC = [0,0,0];
            $existC = '';
            if($anexosC > 0){
                $anexosC = strrev(strval($anexosC));
                for($i=0; $i<strlen($anexosC); $i++)
                    $numAnexoC[$i] = intval($anexosC[$i]);
                $numAnexoC = array_reverse($numAnexoC);
                $existC = 'X';
            }
            $this->Cell(4, 4, $existC, 'LRBT', 0, 'C');
            $this->Cell(4, 4);
            foreach($numAnexoC as $num){
                $this->Cell(4, 4, $num, 'LRB');
            }

            $this->Cell(3,   4);
            $this->SetFont('Arial','B',8);
            $this->Cell(13,  4, 'Anexo G.');
            $this->SetFont('Arial','',8);
            $this->Cell(74,  4, utf8_decode('Continuación de la narrativa de los hechos y/o entrevista'));
            $this->Cell(4,   4, '', 'LRTB');
            $this->Cell(4,   4);
            $this->Cell(4,   4, '0', 'LRB', 0, 'C');
            $this->Cell(4,   4, '0', 'RB', 0, 'C');
            $this->Cell(4,   4, '0', 'RB', 0, 'C');
            $this->Cell(4,   4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(3,   4, '',      'L');
            $this->SetFont('Arial','B',8);
            $this->Cell(13,  4, 'Anexo D.');
            $this->SetFont('Arial','',8);
            $this->Cell(40,  4, utf8_decode('Inventario de armas y objetos')); 

            $anexosD = (count($data['AnexosD']['armas']) > 0 || count($data['AnexosD']['objetos'])>0) ? count($data['AnexosD']['armas'])+count($data['AnexosD']['objetos']) : 0;
            $numAnexoD = [0,0,0];
            $existD = '';
            if($anexosD > 0){
                $anexosD = strrev(strval($anexosD));
                for($i=0; $i<strlen($anexosD); $i++)
                    $numAnexoD[$i] = intval($anexosD[$i]);
                $numAnexoD = array_reverse($numAnexoD);
                $existD = 'X';
            }
            $this->Cell(4, 4, $existD, 'LRBT', 0, 'C');
            $this->Cell(4, 4);
            foreach($numAnexoD as $num){
                $this->Cell(4, 4, $num, 'LRB');
            }
            $this->Cell(3,   4);
            $this->Cell(87,  4, 'No se entregan Anexos');
            $this->Cell(4,   4, ($anexosA > 0 || $anexosB > 0 || $anexosC > 0 || $anexosD > 0 || $anexosE > 0 || $anexosF > 0) ? '' : 'X', 'LRTB');
            $this->Cell(20,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LRB', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $docComplementaria = $data['data_puesta']['docComplementaria'];
            $docCom = ['','X'];
            if(isset($docComplementaria[0])){
                if($docComplementaria[0]->Fotografia != 0 || $docComplementaria[0]->Video != 0 || $docComplementaria[0]->Audio != 0 || $docComplementaria[0]->Certificado != 0 || $docComplementaria[0]->Otro != ""){
                    $docCom = ['X',''];
                }else{
                    $this->Line($this->GetX()+88,$this->GetY(),$this->GetX()+171,$this->GetY()+17); 
                }
            }else{
                $this->Line($this->GetX()+88,$this->GetY(),$this->GetX()+171,$this->GetY()+17); 
            }
            $this->Cell(36,  4, '', 'L');
            $this->Cell(5,   4, utf8_decode('Sí'));
            $this->Cell(4,   4, $docCom[0], 'LRTB');
            $this->Cell(12,  4, utf8_decode('(Señale con una "X" el'));
            $this->Cell(31,  4);
            $this->Cell(20,  4, utf8_decode('Fotografías'));
            $this->Cell(4,   4, (isset($docComplementaria[0]) && $docComplementaria[0]->Fotografia != 0) ? 'X' : ' ', 'LRTB');
            $this->Cell(26,  4);
            $this->Cell(28,  4, utf8_decode('Audio'));
            $this->Cell(4,   4, (isset($docComplementaria[0]) && $docComplementaria[0]->Audio != 0) ? 'X' : ' ', 'LRTB');
            $this->Cell(20,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(46,  3, '', 'L');
            $this->Cell(10,  3, utf8_decode('tipo de documentación)'));
            $this->Cell(134, 3, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(3,   4, '', 'L');
            $this->Cell(12,  4, utf8_decode('¿Anexa documentación'));
            $this->Cell(73,  4);
            $this->Cell(20,  4, utf8_decode('Videos'));
            $this->Cell(4,   4, (isset($docComplementaria[0]) && $docComplementaria[0]->Video != 0) ? 'X' : ' ', 'LRTB');
            $this->Cell(26,  4);
            $this->Cell(28,  4, utf8_decode('Certificados médicos'));
            $this->Cell(4,   4, (isset($docComplementaria[0]) && $docComplementaria[0]->Certificado != 0) ? 'X' : ' ', 'LRTB');
            $this->Cell(20,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(6,   3, '', 'L');
            $this->Cell(10,  3, utf8_decode('complementaria?'));
            $this->Cell(174, 3, '', 'R', 1);
            $this->Cell(3,   1);
            $this->Cell(190, 1, '', 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(35,  3, '', 'L');
            $this->Cell(5,   3, 'No');
            $this->Cell(1,   3);
            $this->Cell(4,   4, $docCom[1], 'LRTB');
            $this->Cell(43,  4);
            $this->Cell(20,  4, utf8_decode('Otra'));
            $this->Cell(4,   4, (isset($docComplementaria[0]) && $docComplementaria[0]->Otro != '') ? 'X' : '', 'LRTB');
            $this->Cell(2,   4);
            $this->Cell(28,  4, utf8_decode('(¿Cuál?)'));
            $this->Cell(48,  3, (isset($docComplementaria[0]->Otro)) ? utf8_decode(strtoupper($docComplementaria[0]->Otro)) : '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
            $this->SetFillColor(196, 189, 151);
            $this->SetFont('Arial','B',8);
            $this->Cell(3,   6);
            $this->Cell(190, 6, utf8_decode('Datos de quien realiza la puesta a disposición'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',8);
            $this->Cell(3,   3);
            $this->Cell(190, 3, "", 'LR', 1);
            $this->Cell(3,   4);
            $primerRespondiente = $data['data_puesta']['primerRespondiente'];
            $this->Cell(3,   4, "", 'L');
            $this->Cell(30,  4, 'Primer apellido:');
            $this->Cell(157, 4, (isset($primerRespondiente->Ap_Paterno_PR)) ? utf8_decode($primerRespondiente->Ap_Paterno_PR) : ' ', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(33,  0);
            $this->Cell(5,   0, '.....................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(3,   4, '', 'L');
            $this->Cell(30,  4, 'Segundo apellido:');
            $this->Cell(157, 4, (isset($primerRespondiente->Ap_Materno_PR)) ? utf8_decode($primerRespondiente->Ap_Materno_PR) : ' ', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(33,  0);
            $this->Cell(5,   0, '.....................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(3,   4, '', 'L');
            $this->Cell(30,  4, 'Nombre(s):');
            $this->Cell(157, 4, (isset($primerRespondiente->Nombre_PR)) ? utf8_decode($primerRespondiente->Nombre_PR) : ' ', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(33,  0);
            $this->Cell(5,   0, '.....................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->MultiCell(190, 4, (isset($primerRespondiente->Adscripcion_Realiza_Puesta)) ? utf8_decode('    Adscripción:                   '.strtoupper($primerRespondiente->Adscripcion_Realiza_Puesta)) : utf8_decode('Adscripción:'), 'LR', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(33,  0);
            $this->Cell(5,   0, '.....................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(3,   4, '', 'L');
            $this->Cell(30,  4, 'Cargo/grado:');
            $this->Cell(157, 4, (isset($primerRespondiente->Cargo)) ? utf8_decode(strtoupper($primerRespondiente->Cargo)) : ' ', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(33,  0);
            $this->Cell(5,   0, '.....................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(3,   4, '', 'L');
            $this->Cell(10,  4, 'Firma:');
            $this->Cell(177, 4, '', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(33,  0);
            $this->Cell(5,   0, '.....................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,    5);
            $this->Cell(190,  5, '', 'LR', 1);
            $fiscal = $data['data_puesta']['fiscal'];
            $this->SetFont('Arial','B',8);
            $this->Cell(3,   6);
            $this->Cell(190, 6, utf8_decode('Fiscal/Autoridad que recibe la puesta a disposición'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',8);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(3,   4, '', 'L');
            $this->Cell(30,  4, 'Primer apellido:');
            $this->Cell(157, 4, (isset($fiscal->Ap_Paterno_Fis)) ? utf8_decode(strtoupper($fiscal->Ap_Paterno_Fis)) : ' ', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(33,  0);
            $this->Cell(5,   0, '.....................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(3,   4, '', 'L');
            $this->Cell(30,  4, 'Segundo apellido:');
            $this->Cell(157, 4, (isset($fiscal->Ap_Materno_Fis)) ? utf8_decode(strtoupper($fiscal->Ap_Materno_Fis)) : ' ', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(33,  0);
            $this->Cell(5,   0, '.....................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(3,   4, '', 'L');
            $this->Cell(30,  4, 'Nombre(s):');
            $this->Cell(157, 4, (isset($fiscal->Nombre_Fis)) ? utf8_decode(strtoupper($fiscal->Nombre_Fis)) : ' ', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(33,  0);
            $this->Cell(5,   0, '.....................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(3,   4, '', 'L');
            $this->Cell(30,  4, utf8_decode('Fiscalía/Autoridad:'));
            $this->Cell(157, 4, (isset($fiscal->Fiscalia)) ? utf8_decode(strtoupper($fiscal->Fiscalia)) : ' ', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(33,  0);
            $this->Cell(5,   0, '.....................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(3,   4, '', 'L');
            $this->Cell(30,  4, utf8_decode('Adscripción:'));
            $this->Cell(157, 4, (isset($fiscal->Adscripcion)) ? utf8_decode(strtoupper($fiscal->Adscripcion)) : ' ', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(33,  0);
            $this->Cell(5,   0, '.....................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(3,   4, '', 'L');
            $this->Cell(30,  4, 'Cargo:');
            $this->Cell(157, 4, (isset($fiscal->Cargo)) ? utf8_decode(strtoupper($fiscal->Cargo)) : ' ', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(33,  0);
            $this->Cell(5,   0, '.....................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(3,   4, '', 'L');
            $this->Cell(10,  4, 'Firma:');
            $this->Cell(177, 4, '', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(33,  0);
            $this->Cell(5,   0, '.....................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LRB', 1);
            $this->SetFont('Arial','B',8);
            $this->Cell(3,   35);
            $this->Cell(190, 35, '', 'LR', 1, 'C');
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Sello de la institución/autoridad que recibe el formato IPH'), 'LRB', 1, 'C');
        }

        function TwoPage($data, $base_url)
        {
            $this->SetFont('Arial','B',8);
            $this->Ln(2);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('SECCIÓN 2. PRIMER RESPONDIENTE'), 0, 1);
            $this->Ln(1);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado 2.1 Datos de identificación'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',8);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $primerRespondiente = $data['data_puesta']['primerRespondiente'];
            $this->Cell(64,  4, (isset($primerRespondiente->Ap_Paterno_PR)) ? utf8_decode($primerRespondiente->Ap_Paterno_PR) : ' ', 'L', 0, 'C');
            $this->Cell(63,  4, (isset($primerRespondiente->Ap_Materno_PR)) ? utf8_decode($primerRespondiente->Ap_Materno_PR) : ' ', 0,  0, 'C');
            $this->Cell(63,  4, (isset($primerRespondiente->Nombre_PR)) ? utf8_decode($primerRespondiente->Nombre_PR) : ' ', 'R', 1, 'C');
            $this->Cell(3,   1);
            $this->Cell(190, 1, '', 'LR', 1);
            $this->Cell(3,   0);
            $this->Cell(64,  0, '.............................................................', 0, 0, 'C');
            $this->Cell(63,  0, '.............................................................', 0,  0, 'C');
            $this->Cell(63,  0, '.............................................................', 0, 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(64,  4, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(63,  4, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(63,  4, 'Nombre(s)', 'R', 1, 'C');
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Seleccione con una "X" la institución a la que pertenece, así como la entidad federativa o municipio de adscripción.'), 'LR', 1);
            $this->Cell(3,   3);
            $intituciones = ['Guardia Nacional','Policía Federal Ministerial','Policía Ministerial','Policía Mando Único','Policía Estatal','Policía Municipal'];
            $arrayInstitucion = ['','','','','','',''];

            $band = false;
            foreach($intituciones as $key=>$intitucion){
                if($intitucion == $primerRespondiente->Institucion){
                   $arrayInstitucion[$key] = 'X'; 
                   $band = true;
                 }
            }
            if(!$band) $arrayInstitucion[6] = $primerRespondiente->Institucion;

            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(75,  4, '', 'L');
            $this->Cell(4,   4, $arrayInstitucion[2], 'LRTB');
            $this->Cell(4,   4, utf8_decode('Policía Ministerial'));
            $this->Cell(107, 4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(4,   4, $arrayInstitucion[0], 'LRTB');
            $this->Cell(4,   4, utf8_decode('Guardia Nacional'));
            $this->Cell(62,  4);
            $this->Cell(4,   4, $arrayInstitucion[3], 'LRTB');
            $this->Cell(4,   4, utf8_decode('Policía Mando Único'));
            $this->Cell(107, 4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(4,   4, $arrayInstitucion[1], 'LRTB');
            $this->Cell(4,   4, utf8_decode('Policía Federal Ministerial '));
            $this->Cell(62,  4);
            $this->Cell(4,   4, $arrayInstitucion[4], 'LRTB');
            $this->Cell(4,   4, utf8_decode('Policía Estatal'));
            $this->Cell(107, 4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(75,  4, '', 'L');
            $this->Cell(4,   4, $arrayInstitucion[5], 'LRTB');
            $this->Cell(4,   4, utf8_decode('Policía Municipal'));
            $this->Cell(107, 4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(75,  4, '', 'L');
            $this->Cell(21,  4, utf8_decode('Otra autoridad:'));
            $this->Cell(94,  4, utf8_decode(strtoupper($arrayInstitucion[6])), 'R', 1);
            $this->Cell(3,   1);
            $this->Cell(190, 1, '', 'LR', 1);
            $this->Cell(96,  0);
            $this->Cell(67,  0, '.................................................................................................................', 0, 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(75,  4, utf8_decode('¿Cuál es su grado o cargo?'));
            $this->Cell(110, 4, (isset($primerRespondiente->Cargo)) ? utf8_decode($primerRespondiente->Cargo) : '', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(83,  0);
            $this->Cell(64,  0, '.................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(75,  4, utf8_decode('¿En qué unidad arribó al lugar de la intervención?'));
            $this->Cell(81,  4, ($primerRespondiente->Unidad_Arribo != '') ? $primerRespondiente->Unidad_Arribo : '');
            $this->Cell(15,  4, 'No aplica');
            $this->Cell(4,   4, ($primerRespondiente->Unidad_Arribo == '') ? 'X' : '', 'LRTB');
            $this->Cell(10,  4, '', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(83,  0);
            $this->Cell(64,  0, '.................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(10,  4, utf8_decode('¿Arribó más de un elemento al lugar de la intervención?'));
            $this->Cell(70,  4);

            $numElementos = $data['data_puesta']['puesta']->Num_Elementos;
            $arrayNumElementos = [0,0,0];
            if($numElementos > 0){
                $numElementos = strrev(strval($numElementos));
                for($i=0; $i<strlen($numElementos); $i++)
                    $arrayNumElementos[$i] = intval($numElementos[$i]);
                $arrayNumElementos = array_reverse($arrayNumElementos);
            }

            $this->Cell(5,   4, utf8_decode('Sí'));
            $this->Cell(4,   4, ($numElementos != '' || $numElementos != NULL) ? 'X' : '', 'LRTB');
            $this->Cell(4,   4);
            $this->Cell(17,  4, utf8_decode('¿Cuántos?'));
            foreach($arrayNumElementos as $num_elementos){
                $this->Cell(4,   4, $num_elementos, 'LRB');
            }
            $this->Cell(15,  4, '(001,002,...,010,...,)');
            $this->Cell(26,  4);
            $this->Cell(8,   4, 'No');
            $this->Cell(4,   4, ($numElementos != '' || $numElementos != NULL) ? '' : 'X', 'LRTB');
            $this->Cell(10,  4, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
            $this->Ln(9);
            $this->SetFont('Arial','B',8);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('SECCIÓN 3. CONOCIMIENTO DEL HECHO Y SEGUIMIENTO DE LA ACTUACIÓN DE LA AUTORIDAD'), 0, 1);
            $this->Ln(1);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado 3.1 Conocimiento del hecho por el primer respondiente'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',8);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, utf8_decode('¿Cómo se enteró del hecho?'), 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');

            $hecho = $data['data_puesta']['hecho'];
            $conocimientos = ['Denuncia','Flagrancia','Localización','Mandamiento judicial','Llamada de emergencia 911','Descubrimiento','Aportación'];
            $conocimientoH = ['','','','','','','',''];
            if($hecho){
                foreach($conocimientos as $key=>$conocimiento){
                    ($conocimiento == $hecho->Conocimiento_Hecho) ? $conocimientoH[$key] = 'X' : $conocimientoH[7] = $hecho->Especificacion;
                }
            }

            $this->Cell(35,  4, 'Denuncia');
            $this->Cell(4,   4, $conocimientoH[0], 'LRTB');
            $this->Cell(10,  4);
            $this->Cell(23,  4, 'Flagrancia');
            $this->Cell(4,   4, $conocimientoH[1], 'LRTB');
            $this->Cell(14,  4);
            $this->Cell(20,  4, utf8_decode('Localización'));
            $this->Cell(4,   4, $conocimientoH[2], 'LRTB');
            $this->Cell(27,  4);
            $this->Cell(30,  4, 'Mandamiento judicial');
            $this->Cell(4,   4, $conocimientoH[3], 'LRTB');
            $this->Cell(10,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(35,  4, 'Llamada de emergencia');
            $this->Cell(4,   4, $conocimientoH[4], 'LRTB');
            $this->Cell(10,  4);
            $this->Cell(23,  4, 'Descubrimiento');
            $this->Cell(4,   4, $conocimientoH[5], 'LRTB');
            $this->Cell(14,  4);
            $this->Cell(20,  4, utf8_decode('Aportación'));
            $this->Cell(4,   4, $conocimientoH[6], 'LRTB');
            $this->Cell(71,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(15,  4, '911 No.');
            $this->SetFont('Arial','I',8);
            (isset($hecho->Especificacion)) ? $no911 = str_split($hecho->Especificacion) : $no911 = array();
            for($i=0;$i<24;$i++){
                $this->Cell(4, 4, (isset($no911[$i])) ? $no911[$i] : '', 'LRB');
            }
            $this->Cell(4,   4);
            $this->Cell(70,  4, utf8_decode('Sólo en caso de contar con él.'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
            $this->SetFont('Arial','B',8);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado 3.2 Seguimiento de la actuación de la autoridad'), 'LRB', 1, '', true);
            $this->SetFont('Arial','',8);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Indique la fecha y hora en cada recuadro.'), 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LR', 1);
            $this->Cell(3,   6);
            $this->Cell(24,  6, '', 'L');
            $this->SetFont('Arial','B',8);
            $this->Cell(52,  6, 'Conocimiento del hecho', 'LTR', 0, 'C');
            $this->Cell(40,  6);
            $this->Cell(52,  6, 'Arribo al lugar', 'LTR', 0, 'C');
            $this->Cell(22,  6, '', 'R', 1);
            $this->Cell(3,   2);
            $this->SetFont('Arial','',8);
            $this->Cell(24,  2, '', 'L');
            $this->Cell(52,  2, '', 'LR');
            $this->Cell(40,  2);
            $this->Cell(52,  2, '', 'LR');
            $this->Cell(22,  2, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(24,  4, '', 'L');
            $this->Cell(3,   4, '', 'L');
            $this->Cell(11,  4, 'Fecha:');
            
            if(isset($hecho->Fecha_Hora_Conocimiento)){
                $fecha_conocimiento = str_split(implode(array_reverse(explode('-',(explode(' ', $hecho->Fecha_Hora_Conocimiento))[0]))));
                $hora_conocimiento = str_replace(':', '', (explode(' ', $hecho->Fecha_Hora_Conocimiento))[1]);
            }else{
                $fecha_conocimiento = array();
                $hora_conocimiento = array();
            }

            if(isset($hecho->Fecha_Hora_Arribo)){
                $fecha_arribo = str_split(implode(array_reverse(explode('-',(explode(' ', $hecho->Fecha_Hora_Arribo))[0]))));
                $hora_arribo = str_replace(':', '', (explode(' ', $hecho->Fecha_Hora_Arribo))[1]);
            }else{
                $fecha_arribo = array();
                $hora_arribo = array();
            }
            for($i=0; $i<8; $i++){
                $this->Cell(4, 4, (isset($fecha_conocimiento[$i])) ? $fecha_conocimiento[$i] : '', 'LRB', 0, 'C');
            }

            $this->Cell(6,   4, '', 'R');
            $this->Cell(40,  4);
            $this->Cell(3,   4, '', 'L');
            $this->Cell(11,  4, 'Fecha:');
            for($i=0; $i<8; $i++){
                $this->Cell(4, 4, (isset($fecha_arribo[$i])) ? $fecha_arribo[$i] : '', 'LRB', 0, 'C');
            }
            $this->Cell(6,   4, '', 'R');
            $this->Cell(22,  4, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(24,  4, '', 'L');
            $this->Cell(14,  4, '', 'L');
            $this->Cell(4,   4, 'D', 0, 0, 'C');
            $this->Cell(4,   4, 'D', 0, 0, 'C');
            $this->Cell(4,   4, 'M', 0, 0, 'C');
            $this->Cell(4,   4, 'M', 0, 0, 'C');
            $this->Cell(4,   4, 'A', 0, 0, 'C');
            $this->Cell(4,   4, 'A', 0, 0, 'C');
            $this->Cell(4,   4, 'A', 0, 0, 'C');
            $this->Cell(4,   4, 'A', 0, 0, 'C');
            $this->Cell(6,   4);
            $this->Cell(1,   4, '', 'L');
            $this->Cell(39,  4);
            $this->Cell(14,  4, '', 'L');
            $this->Cell(4,   4, 'D', 0, 0, 'C');
            $this->Cell(4,   4, 'D', 0, 0, 'C');
            $this->Cell(4,   4, 'M', 0, 0, 'C');
            $this->Cell(4,   4, 'M', 0, 0, 'C');
            $this->Cell(4,   4, 'A', 0, 0, 'C');
            $this->Cell(4,   4, 'A', 0, 0, 'C');
            $this->Cell(4,   4, 'A', 0, 0, 'C');
            $this->Cell(4,   4, 'A', 0, 0, 'C');
            $this->Cell(6,   4, '', 'R');
            $this->Cell(22,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(24,  3, '', 'L');
            $this->Cell(52,  3, '', 'LR');
            $this->Cell(40,  3);
            $this->Cell(52,  3, '', 'LR');
            $this->Cell(22,  3, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(24,  4, '', 'L');
            $this->Cell(3,   4, '', 'L');
            $this->Cell(11,  4, 'Hora:');
            $this->Cell(4,   4, (isset($hora_conocimiento[0])) ? $hora_conocimiento[0] : '', 'LRB', 0, 'C');
            $this->Cell(4,   4, (isset($hora_conocimiento[1])) ? $hora_conocimiento[1] : '', 'LRB', 0, 'C');
            $this->Cell(4,   4, ':', 0, 0, 'C');
            $this->Cell(4,   4, (isset($hora_conocimiento[2])) ? $hora_conocimiento[2] : '', 'LRB', 0, 'C');
            $this->Cell(4,   4, (isset($hora_conocimiento[3])) ? $hora_conocimiento[3] : '', 'LRB', 0, 'C');
            $this->SetFont('Arial','I',7);
            $this->Cell(12,  4, '(24 horas)');
            $this->Cell(6,   4, '', 'R');
            $this->Cell(40,  4);
            $this->Cell(3,   4, '', 'L');
            $this->SetFont('Arial','',7);
            $this->Cell(11,  4, 'Hora:');
            $this->Cell(4,   4, (isset($hora_arribo[0])) ? $hora_arribo[0] : '', 'LRB', 0, 'C');
            $this->Cell(4,   4, (isset($hora_arribo[1])) ? $hora_arribo[1] : '', 'LRB', 0, 'C');
            $this->Cell(4,   4, ':', 0, 0, 'C');
            $this->Cell(4,   4, (isset($hora_arribo[2])) ? $hora_arribo[2] : '', 'LRB', 0, 'C');
            $this->Cell(4,   4, (isset($hora_arribo[3])) ? $hora_arribo[3] : '', 'LRB', 0, 'C');
            $this->SetFont('Arial','I',7);
            $this->Cell(12,  4, '(24 horas)');
            $this->SetFont('Arial','',8);
            $this->Cell(6,   4, '', 'R');
            $this->Cell(22,  4, '', 'R', 1);
            $this->Cell(3,   5);
            $this->Cell(24,  5, '', 'L');
            $this->Cell(14,  5, '', 'LB');
            $this->Cell(4,   5, 'h', 'B', 0, 'C');
            $this->Cell(4,   5, 'h', 'B', 0, 'C');
            $this->Cell(4,   5,  '', 'B');
            $this->Cell(4,   5, 'm', 'B', 0, 'C');
            $this->Cell(4,   5, 'm', 'B', 0, 'C');
            $this->Cell(18,  5, '',  'B');
            $this->Cell(1,   5, '', 'L');
            $this->Cell(39,  5);
            $this->Cell(14,  5, '', 'LB');
            $this->Cell(4,   5, 'h', 'B', 0, 'C');
            $this->Cell(4,   5, 'h', 'B', 0, 'C');
            $this->Cell(4,   5, '',  'B');
            $this->Cell(4,   5, 'm', 'B', 0, 'C');
            $this->Cell(4,   5, 'm', 'B', 0, 'C');
            $this->Cell(18,  5, '', 'RB');
            $this->Cell(22,  5, '', 'R', 1);
            $this->Cell(3,   6);
            $this->Cell(190, 6, '', 'LRB', 1);
            $this->Ln(5);

            $this->SetFont('Arial','B',8);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('SECCIÓN 4. LUGAR DE LA INTERVENCIÓN'), 0, 1);
            $this->Ln(1);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado 4.1 Ubicación geográfica'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',8);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(45,  4, 'Calle/Tramo carretero:');

            $ubicacion = $data['data_puesta']['ubicacion'];

            $this->Cell(140, 4,(isset($ubicacion->Calle_1)) ? utf8_decode(strtoupper($ubicacion->Calle_1)) : ' ', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(53,  0);
            $this->Cell(154, 0, '..........................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(18,  4, 'No. exterior:');
            $this->Cell(40,  4, (isset($ubicacion->No_Ext)) ? strtoupper($ubicacion->No_Ext) : ' ');
            $this->Cell(19,  4, 'No. interior:');
            $this->Cell(40,  4, (isset($ubicacion->No_Int)) ? strtoupper($ubicacion->No_Int) : ' ');
            $this->Cell(20,  4, utf8_decode('Código Postal:'));
            $this->Cell(40,  4, (isset($ubicacion->CP)) ? $ubicacion->CP : '');
            $this->Cell(8,   4, '', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(23,  0);
            $this->Cell(40,  0, '..................................................');
            $this->Cell(17,  0);
            $this->Cell(40,  0, '..................................................');
            $this->Cell(24,  0);
            $this->Cell(40,  0, '.......................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(45,  4, 'Colonia/Localidad:');
            $this->Cell(140, 4, (isset($ubicacion->Colonia)) ? utf8_decode(strtoupper($ubicacion->Colonia)) : ' ', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(53,  0);
            $this->Cell(64,  0, '..........................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(45,  4, utf8_decode('Municipio/Demarcación territorial:'));
            $this->Cell(140, 4, (isset($ubicacion->Municipio)) ? utf8_decode(strtoupper($ubicacion->Municipio)) : ' ', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(53,  0);
            $this->Cell(64,  0, '..........................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(45,  4, 'Entidad federativa:');
            $this->Cell(140, 4, (isset($ubicacion->Estado)) ? utf8_decode(strtoupper($ubicacion->Estado)) : ' ', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(50,  0);
            $this->Cell(64,  0, '..........................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(45,   4, 'Referencias:');
            $this->Cell(140, 4, (isset($ubicacion->Referencias)) ? utf8_decode(strtoupper($ubicacion->Referencias)) : ' ' , 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(53,  0);
            $this->Cell(64,  0, '..........................................................................................................................................................................', 0, 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $latitud = array();
            if(isset($ubicacion->Coordenada_Y)){
                $latitud = str_split($ubicacion->Coordenada_Y);
            }
            $this->Cell(190, 4, utf8_decode('Anote las coordenadas geográficas.'), 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->SetFont('Arial','',8);
            $this->Cell(12,  4, 'Latitud:');
            for($i=0; $i<10; $i++){
                if($i==0 || $i== 3){
                    $this->Cell(4,   4, (isset($latitud[$i])) ? $latitud[$i] : '', 'LRB');
                }else{
                    if($i==2){
                        $this->Cell(4,   4, (isset($latitud[$i])) ? $latitud[$i] : '.', '', 0, 'C');
                    }else{
                        $this->Cell(4,   4, (isset($latitud[$i])) ? $latitud[$i] : '', 'RB');
                    }
                }
            }
            $this->Cell(10,  4);
            $longitud = array();
            if(isset($ubicacion->Coordenada_X)){
                $longitud = str_split($ubicacion->Coordenada_X);
            }
            $this->Cell(15,  4, 'Longitud:');
            for($i=0; $i<11; $i++){
                if($i==0 || $i== 4){
                    $this->Cell(4,   4, (isset($longitud[$i])) ? $longitud[$i] : '', 'LRB');
                }else{
                    if($i==3){
                        $this->Cell(4,   4, (isset($longitud[$i])) ? $longitud[$i] : '.', '', 0, 'C');
                    }else{
                        $this->Cell(4,   4, (isset($longitud[$i])) ? $longitud[$i] : '', 'RB');
                    }
                }
            }
            $this->Cell(64,  4, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB',1);
        }
        
        function ThreePage($data, $base_url)
        {
            $this->SetFont('Arial','B',8);
            $this->Ln(2);
            $this->SetFillColor(196, 189, 151);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Croquis del lugar'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','I',8);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Es necesario incluir elementos y referencias que permitan identificar el o los lugares de la intervención, detención y/o hallazgo, como vialidades,'), 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('árboles, cerros, ríos o edificaciones.'), 'LR', 1);
            $this->Cell(3,   200);
            $this->Cell(190, 200, utf8_decode(""), 'LRB', 1);

            $lugarIntervencion = $data['data_puesta']['lugarIntervencion'];
            if($lugarIntervencion->Path_Croquis != NULL && $lugarIntervencion->Path_Croquis != ''){
                $this->Image($base_url.'public/files/Juridico/'.$data['data_puesta']['puesta']->Id_Puesta.'/croquis/'.$lugarIntervencion->Path_Croquis,30,60,150);
            }
            $this->Image($base_url.'public/media/images/croquis.PNG',165,26,20);
            $this->SetFont('Arial','B',8);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado 4.2 Inspección del lugar'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',8);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(133, 4, utf8_decode('¿Realizó la inspección del lugar?'));
            $this->Cell(5,   4, utf8_decode('Sí'));
            $this->Cell(4,   4, ($lugarIntervencion->Inspeccion_Lugar != NULL && $lugarIntervencion->Inspeccion_Lugar != 0) ? 'X' : '', 'LTRB');
            $this->Cell(30,  4);
            $this->Cell(5,   4, 'No');
            $this->Cell(4,   4, ($lugarIntervencion->Inspeccion_Lugar != NULL && $lugarIntervencion->Inspeccion_Lugar != 0) ? '' : 'X', 'LTRB');
            $this->Cell(4,   4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(133, 4, utf8_decode('Al momento de realizar la inspección del lugar, ¿encontró algún objeto relacionado con los hechos?'));
            $this->Cell(5,   4, utf8_decode('Sí'));
            $this->Cell(4,   4, ($lugarIntervencion->Objeto_Encontrado != NULL && $lugarIntervencion->Objeto_Encontrado != 0) ? 'X' : '', 'LTRB');
            $this->SetFont('Arial','I',8);
            $this->Cell(30,  4, 'Llene el Anexo D');
            $this->SetFont('Arial','',8);
            $this->Cell(5,   4, 'No');
            $this->Cell(4,   4, ($lugarIntervencion->Objeto_Encontrado != NULL && $lugarIntervencion->Objeto_Encontrado != 0) ? '' : 'X', 'LTRB');
            $this->Cell(4,   4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(133, 4, utf8_decode('¿Preservó el lugar de la intervención?'));
            $this->Cell(5,   4, utf8_decode('Sí'));
            $this->Cell(4,   4, ($lugarIntervencion->Preservar_Lugar != NULL && $lugarIntervencion->Preservar_Lugar != 0) ? 'X' : '', 'LTRB');
            $this->Cell(30,  4);
            $this->Cell(5,   4, 'No');
            $this->Cell(4,   4, ($lugarIntervencion->Preservar_Lugar != NULL && $lugarIntervencion->Preservar_Lugar != 0) ? '' : 'X', 'LTRB');
            $this->Cell(4,   4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(133, 4, utf8_decode('¿Llevó a cabo la priorización en el lugar de la intervención?'));
            $this->Cell(5,   4, utf8_decode('Sí'));
            $this->Cell(4,   4, ($lugarIntervencion->Priorizacion_Lugar != NULL && $lugarIntervencion->Priorizacion_Lugar != 0) ? 'X' : '', 'LTRB');
            $this->Cell(30,  4);
            $this->Cell(5,   4, 'No');
            $this->Cell(4,   4, ($lugarIntervencion->Priorizacion_Lugar != NULL && $lugarIntervencion->Priorizacion_Lugar != 0) ? '' : 'X', 'LTRB');
            $this->Cell(4,   4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(10,  4, '', 'L');
            $this->Cell(10,  4, 'Tipo de riesgo presentado:');
            $this->Cell(45,  4);
            $this->Cell(13,  4, 'Sociales');
            $this->Cell(4,   4, ($lugarIntervencion->Tipo_Riesgo != NULL && $lugarIntervencion->Tipo_Riesgo != '' && $lugarIntervencion->Tipo_Riesgo == 'Sociales') ? 'X' : '', 'LTRB');
            $this->Cell(30,  4);
            $this->Cell(15,  4, 'Naturales');
            $this->Cell(4,   4, ($lugarIntervencion->Tipo_Riesgo != NULL && $lugarIntervencion->Tipo_Riesgo != '' && $lugarIntervencion->Tipo_Riesgo == 'Naturales') ? 'X' : '', 'LTRB');
            $this->Cell(59,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(30,  4, 'Especifique: ');
            $this->Cell(155, 4,  (isset($lugarIntervencion->Especificacion)) ? utf8_decode(strtoupper($lugarIntervencion->Especificacion)) : '', 'R', 1);
            $this->Cell(3,   0.5);
            $this->Cell(190, 0.5, '', 'LR', 1);
            $this->Cell(28,  0);
            $this->Cell(64,  0, '.........................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   5);
            $this->Cell(190, 5, '', 'LRB', 1);
        }

        function FourPage($data, $base_url)
        {
            $this->SetFont('Arial','B',8);
            $this->Ln(2);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('SECCIÓN 5. NARRATIVA DE LOS HECHOS'), 0, 1);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado 5.1 Descripción de los hechos y actuación de la autoridad'), 'LTRB', 1, '', true);
            $this->Cell(3,   4);
            $this->Cell(190,   4, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->SetFont('Arial','',8);
            $this->SetTextColor(0,0,0);
            $this->Cell(190, 4, utf8_decode('Relate cronológicamente las acciones realizadas durante su intervención desde el conocimiento del hecho hasta la puesta a disposición. En su caso,'), 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('explique las circunstancias de modo, tiempo y lugar que motivaron cada uno de los niveles de contacto y la detención. Tome como base las siguientes'), 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('preguntas: ¿Quién? (personas), ¿Qué? (hechos), ¿Cómo? (circunstancias), ¿Cuándo? (tiempo) y ¿Dónde? (lugar).'), 'LR', 1);
            $this->Cell(3,   5);
            $this->Cell(190, 5, '', 'LR', 1);
            $this->SetFont('Arial','',8);
            $this->Cell(3,   4);
            $this->MultiCell(190, 4, (isset($data['data_puesta']['puesta']->Narrativa_Hechos)) ? utf8_decode(strtoupper($data['data_puesta']['puesta']->Narrativa_Hechos)) : '','LR','J');
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
        }

        function AnexoA($data)
        {
            if($data['AnexosA']){
                $detenidos = $data['AnexosA'];
                $lugarIntervencion = $data['data_puesta']['lugarIntervencion'];
                foreach($detenidos as $key=>$detenido){
                    $this->AddPage('P', 'Legal');
                    $this->AnexoAPag1($detenido,$key+1);
                    $this->AddPage('P', 'Legal');
                    $this->AnexoAPag2($detenido,$key+1,$lugarIntervencion);
                    $this->AddPage('P', 'Legal');
                    $this->AnexoAPag3($detenido,$key+1);
                }
            }else{
                $this->AddPage('P', 'Legal');
                $this->AnexoAPag1();
                $this->AddPage('P', 'Legal');
                $this->AnexoAPag2();
                $this->AddPage('P', 'Legal');
                $this->AnexoAPag3();
            }
        }

        function AnexoAPag1($detenido = NULL,$num_detenido = 0)
        {   
            
            $numDetenido = [0,0,0];
            if($num_detenido>0){
                $num_detenido = strrev(strval($num_detenido));
                for($i=0; $i<strlen($num_detenido); $i++)
                $numDetenido[$i] = intval($num_detenido[$i]);
                $numDetenido = array_reverse($numDetenido);
            }
            $this->SetFont('Arial','B',8);
            $this->Ln(2);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('ANEXO A. DETENCIÓN(ES)'), 0, 1, 'C');
            $this->Ln(1);
            $this->Cell(3,   4);
            $this->SetFont('Arial','B',7);
            $this->Cell(190, 4, utf8_decode('Llene este Anexo por cada persona detenida'), 0, 1);
            $this->Ln(1);
            $this->SetFillColor(196, 189, 151);
            $this->SetFont('Arial','B',7);
            $this->Cell(3,   5);
            if($detenido == NULL) $this->Line($this->GetX(),$this->GetY(),$this->GetX()+190,$this->GetY()+232);
            $this->Cell(25,  5, utf8_decode('Persona detenida:'), 'LT', 0, '', true);
            foreach($numDetenido as $numDet){
                $this->Cell(4,   5, ($num_detenido != 0) ? $numDet : '', 'LTRB', 0, '', true);
            }
            $this->Cell(1,   5, '',  'LT',   0, '', true);
            $this->SetFont('Arial','',7);
            $this->Cell(50,  5, '(001, 002,..., 001,...,)', 'T', 0, '', true);
            $this->SetFont('Arial','B',7);
            $this->Cell(38,  5, utf8_decode('Número de detención (RND):'), 'T', 0, '', true);
            (isset($detenido->Num_Detencion)) ? $nrd = str_split(substr(str_replace('/', '', $detenido->Num_Detencion), 4)) : $nrd = array();
            for($i=0;$i<15;$i++){
                $this->Cell(4,   5, (isset($nrd[$i])) ? $nrd[$i] : '', 'LTRB', 0, '', true);
            }
            $this->Cell(4,  5, '*', 'LTR', 1, '', true);
            $this->Cell(3,   3);
            $this->Cell(128, 3, '', 'L', 0, '', true);
            $this->SetFont('Arial','', 5.5);
            $this->Cell(62,  3, '*Sexto transitorio de la Ley Nacional del Registro de Detenciones', 'R', 1, '', true);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado A.1 Fecha y hora de la detención'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Indique la fecha y la hora en que realizó la detención'), 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            if(isset($detenido->Fecha_Hora)){
                $fechaDetencion = str_split(implode(array_reverse(explode('-',(explode(' ', $detenido->Fecha_Hora))[0]))));
                $horaDetencion = str_replace(':', '', (explode(' ', $detenido->Fecha_Hora))[1]);
            }else{
                $fechaDetencion = array();
                $horaDetencion = array();
            }
            $this->Cell(10,  4, 'Fecha:');
            for($i=0;$i<8;$i++){
                $this->Cell(4,   4, (isset($fechaDetencion[$i])) ? $fechaDetencion[$i] : '', 'LRB');
            }
            $this->Cell(25,  4);
            $this->Cell(10,  4, 'Hora:');
            $this->Cell(4,   4, (isset($horaDetencion[0])) ? $horaDetencion[0] : '', 'LRB');
            $this->Cell(4,   4, (isset($horaDetencion[1])) ? $horaDetencion[1] : '', 'RB');
            $this->Cell(4,   4, ':', 0, 0, 'C');
            $this->Cell(4,   4, (isset($horaDetencion[2])) ? $horaDetencion[2] : '', 'LRB');
            $this->Cell(4,   4, (isset($horaDetencion[3])) ? $horaDetencion[3] : '', 'RB');
            $this->Cell(88,  4, '(24 horas)', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(15,  4, '', 'L');
            $this->Cell(4,   4, 'D');
            $this->Cell(4,   4, 'D');
            $this->Cell(4,   4, 'M');
            $this->Cell(4,   4, 'M');
            $this->Cell(4,   4, 'A');
            $this->Cell(4,   4, 'A');
            $this->Cell(4,   4, 'A');
            $this->Cell(4,   4, 'A');
            $this->Cell(35,  4);
            $this->Cell(4,   4, 'h');
            $this->Cell(4,   4, 'h');
            $this->Cell(4,   4);
            $this->Cell(4,   4, 'm');
            $this->Cell(92,  4, 'm', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
            $this->Cell(3,   5);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(190, 5, utf8_decode('Apartado A.2 Datos generales de la persona detenida'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(64,  4, (isset($detenido->Ap_Paterno_D)) ? utf8_decode(strtoupper($detenido->Ap_Paterno_D)) : '', 'L', 0, 'C');
            $this->Cell(63,  4, (isset($detenido->Ap_Materno_D)) ? utf8_decode(strtoupper($detenido->Ap_Materno_D)) : '', 0,  0, 'C');
            $this->Cell(63,  4, (isset($detenido->Nombre_D)) ? utf8_decode(strtoupper($detenido->Nombre_D)) : '', 'R', 1, 'C');
            $this->Cell(67,  0, '..................................................................................', 0, 0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0,  0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(64,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(63,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(63,  6, 'Nombre(s)', 'R', 1, 'C');
            $this->Cell(3,   1);
            $this->Cell(190, 1, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(155, 4, (isset($detenido->Apodo)) ? 'Apodo o alias:      '.utf8_decode(strtoupper($detenido->Apodo)) : 'Apodo o alias: ');
            $this->Cell(13,  4, 'No aplica');
            $this->Cell(4,   4, (isset($detenido->Apodo) && $detenido->Apodo == '' && $num_detenido != 0) ? 'X' : '', 'LTRB');
            $this->Cell(13,  4, '', 'R', 1);
            $this->Cell(28,  0);
            $this->Cell(64,  0, '..................................................................................................................................................................................', '', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(45,  4, 'Nacionalidad:');
            $this->Cell(16,  4, 'Mexicana');
            $this->Cell(4,   4, (isset($detenido->Nacionalidad) && $detenido->Nacionalidad == 'MEXICANA') ? 'X' : '', 'LTRB');
            $this->Cell(30,  4);
            $this->Cell(16,  4, 'Extranjera');
            $this->Cell(4,   4, (isset($detenido->Nacionalidad) && $detenido->Nacionalidad != 'MEXICANA') ? 'X' : '', 'LTRB');
            $this->Cell(6,   4);
            $this->Cell(64,  4, (isset($detenido->Nacionalidad) && $detenido->Nacionalidad != 'MEXICANA') ? utf8_decode('¿Cuál? '.$detenido->Nacionalidad) : utf8_decode('¿Cuál?'), 'R', 1);
            $this->Cell(138, 0, '');
            $this->Cell(64,  0, '..................................................................', '', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(45,  4, 'Sexo:');
            $this->Cell(16,  4, 'Mujer');
            $this->Cell(4,   4, (isset($detenido->Genero) && $detenido->Genero == 'M') ? 'X' : '', 'LTRB');
            $this->Cell(30,  4);
            $this->Cell(16,  4, 'Hombre');
            $this->Cell(4,   4, (isset($detenido->Genero) && $detenido->Genero == 'H') ? 'X' : '', 'LTRB');
            $this->Cell(6,   4);
            $this->Cell(64,  4, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            if(isset($detenido->Fecha_Nacimiento)){
                $fechaNacimiento = str_split(implode(array_reverse(explode('-', $detenido->Fecha_Nacimiento))));
            }else{
                $fechaNacimiento = array();
            }
            $this->Cell(50,  4, 'Fecha de nacimiento:');
            for($i=0;$i<8;$i++){
                $this->Cell(4,   4, (isset($fechaNacimiento[$i])) ? $fechaNacimiento[$i] : '', 'LRB');
            }
            $this->Cell(16,  4);
            $this->Cell(10,  4, 'Edad:');
            $this->Cell(4,   4, (isset($detenido->Edad) && isset(str_split($detenido->Edad)[0])) ? str_split($detenido->Edad)[0] : '', 'LRB');
            $this->Cell(4,   4, (isset($detenido->Edad) && isset(str_split($detenido->Edad)[1])) ? str_split($detenido->Edad)[1] : '', 'RB');
            $this->Cell(69,  4, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(55,  4, '', 'L');
            $this->Cell(4,   4, 'D');
            $this->Cell(4,   4, 'D');
            $this->Cell(4,   4, 'M');
            $this->Cell(4,   4, 'M');
            $this->Cell(4,   4, 'A');
            $this->Cell(4,   4, 'A');
            $this->Cell(4,   4, 'A');
            $this->Cell(4,   4, 'A');
            $this->Cell(103, 4, '', 'R',1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(55,  4, utf8_decode('¿Se identificó con algún documento?'));
            $this->Cell(20,  4, 'Credencial INE');
            $this->Cell(4,   4, (isset($detenido->Identificacion) && $detenido->Identificacion == 'Credencial INE') ? 'X' : '', 'LTRB');
            $this->Cell(8,   4);
            $this->Cell(13,  4, 'Licencia');
            $this->Cell(4,   4, (isset($detenido->Identificacion) && $detenido->Identificacion == 'Licencia') ? 'X' : '', 'LTRB');
            $this->Cell(8,   4);
            $this->Cell(15,  4, 'Pasaporte');
            $this->Cell(4,   4, (isset($detenido->Identificacion) && $detenido->Identificacion == 'Pasaporte') ? 'X' : '', 'LTRB');
            $this->Cell(8,   4);
            $this->Cell(30,  4, (isset($detenido->Identificacion) && $detenido->Identificacion != 'Credencial INE' && $detenido->Identificacion != 'Licencia' && $detenido->Identificacion != 'Pasaporte' && $detenido->Identificacion != 'No') ? 'Otro: '.utf8_decode(strtoupper($detenido->Identificacion)) : 'Otro: ');
            $this->Cell(6,   4, 'No');
            $this->Cell(4,   4, (isset($detenido->Identificacion) && $detenido->Identificacion == 'No') ? 'X' : '', 'LTRB');
            $this->Cell(6,   4, '', 'R', 1);
            $this->Cell(153, 0);
            $this->Cell(60,  0, '................................', '', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(28,  4, utf8_decode('No. de identificación:'));
            if(isset($detenido->Num_Identificacion)){
                $numIdentificacion = str_split($detenido->Num_Identificacion);
            }else{
                $numIdentificacion = array();
            }
            
            for($i=0;$i<23;$i++){
                $this->Cell(4,   4, (isset($numIdentificacion[$i])) ? strtoupper($numIdentificacion[$i]) : '', 'LRB');
            }
            $this->Cell(65,  4, '', 'R', 1);
            $this->Cell(3,   5);
            $this->Cell(190, 5, '', 'LRB', 1);
            $this->SetFillColor(196, 189, 151);
            $this->SetFont('Arial','B',7);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Domicilio de la persona detenida'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(40,  4, 'Calle/Tramo carretero:');
            $this->Cell(145, 4, (isset($detenido->Calle_Dom)) ? utf8_decode(strtoupper($detenido->Calle_Dom)) : '', 'R', 1);
            $this->Cell(43,  0);
            $this->Cell(64,  0, '...............................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(15,  4, 'No. exterior:');
            $this->Cell(43,  4, (isset($detenido->No_Ext_Dom)) ? strtoupper($detenido->No_Ext_Dom) : '');
            $this->Cell(17,  4, 'No. interior:');
            $this->Cell(42,  4, (isset($detenido->No_Int_Dom)) ? strtoupper($detenido->No_Int_Dom) : '');
            $this->Cell(18,  4, utf8_decode('Código Postal:'));
            $this->Cell(40,  4, (isset($detenido->CP_Dom)) ? strtoupper($detenido->CP_Dom) : '');
            $this->Cell(10,  4, '', 'R', 1);
            $this->Cell(23,  0);
            $this->Cell(40,  0, '............................................................');
            $this->Cell(20,  0);
            $this->Cell(40,  0, '............................................................');
            $this->Cell(20,  0);
            $this->Cell(40,  0, '.............................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(35,  4, 'Colonia/Localidad:');
            $this->Cell(150, 4, (isset($detenido->Colonia_Dom)) ? utf8_decode(strtoupper($detenido->Colonia_Dom)) : '', 'R', 1);
            $this->Cell(43,  0);
            $this->Cell(64,  0, '...............................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(35,  4, utf8_decode('Municipio/Demarcación:'));
            $this->Cell(150, 4, (isset($detenido->Municipio_Dom)) ? utf8_decode(strtoupper($detenido->Municipio_Dom)) : '', 'R', 1);
            $this->Cell(43,  0);
            $this->Cell(64,  0, '...............................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(21,  3, '', 'L');
            $this->Cell(169, 2, 'territorial:', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(35,  4, 'Entidad federativa:');
            $this->Cell(150, 4, (isset($detenido->Estado_Dom)) ? utf8_decode(strtoupper($detenido->Estado_Dom)) : '', 'R', 1);
            $this->Cell(43,  0);
            $this->Cell(64,  0, '...............................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(35,  4, 'Referencias:');
            $this->Cell(150, 4, (isset($detenido->Referencias_Dom)) ? utf8_decode(strtoupper($detenido->Referencias_Dom)) : '', 'R', 1);
            $this->Cell(43,  0);
            $this->Cell(64,  0, '...............................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
            $this->Cell(3,   1);
            $this->Cell(190, 1, '', 'LR', 1);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Describa brevemente a la persona detenida, incluyendo tipo de vestimenta y rasgos visibles (barba, tatuajes, cicatrices, lunares, bigote, etcétera).'), 'LR', 1);
            $this->Cell(3,   1);
            $this->Cell(190, 1, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->MultiCell(190, 4, (isset($detenido->Descripcion_Detenido)) ? utf8_decode(strtoupper($detenido->Descripcion_Detenido)) : '', 'LRB', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(70,  4, utf8_decode('¿La persona detenida presenta lesiones visibles?'));
            $this->Cell(5,   4, utf8_decode('Sí'));
            $this->Cell(4,   4, (isset($detenido->Lesiones) && $detenido->Lesiones == '1') ? 'X' : '', 'LTRB');
            $this->Cell(8,   4);
            $this->Cell(5,   4, utf8_decode('No'));
            $this->Cell(4,   4, (isset($detenido->Lesiones) && $detenido->Lesiones == '0') ? 'X' : '', 'LTRB');
            $this->Cell(89,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(70,  4, utf8_decode('¿Manifiesta tener algún padecimiento?'));
            $this->Cell(5,   4, utf8_decode('Sí'));
            $this->Cell(4,   4, (isset($detenido->Descripcion_Padecimiento) && $detenido->Descripcion_Padecimiento != '') ?  'X' : '', 'LTRB');
            $this->Cell(8,   4);
            $this->Cell(10,  4, utf8_decode('¿Cuál?'));
            $this->Cell(71,  4, (isset($detenido->Descripcion_Padecimiento) && $detenido->Descripcion_Padecimiento != '') ?  utf8_decode(strtoupper($detenido->Descripcion_Padecimiento)) : '');
            $this->Cell(5,   4, utf8_decode('No'));
            $this->Cell(4,   4, (isset($detenido->Descripcion_Padecimiento) && $detenido->Descripcion_Padecimiento == '') ?  'X' : '', 'LTRB');
            $this->Cell(8,   4, '', 'R', 1);
            $this->Cell(105, 0);
            $this->Cell(64,  0, '...................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(105, 4, utf8_decode('¿La persona detenida se identificó como miembro de algún grupo vulnerable?'));
            $this->Cell(5,   4, utf8_decode('Sí'));
            $this->Cell(4,   4, (isset($detenido->Grupo_Vulnerable) && $detenido->Grupo_Vulnerable != '') ?  'X' : '', 'LTRB');
            $this->Cell(2,   4);
            $this->Cell(10,  4, utf8_decode('¿Cuál?'));
            $this->Cell(42,  4, (isset($detenido->Grupo_Vulnerable) && $detenido->Grupo_Vulnerable != '') ?  utf8_decode(strtoupper($detenido->Grupo_Vulnerable)) : '');
            $this->Cell(5,   4, utf8_decode('No'));
            $this->Cell(4,   4, (isset($detenido->Grupo_Vulnerable) && $detenido->Grupo_Vulnerable == '') ?  'X' : '', 'LTRB');
            $this->Cell(8,   4, '', 'R', 1);
            $this->Cell(133, 0);
            $this->Cell(64,  0, '..........................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(105, 4, utf8_decode('¿La persona detenida se identificó como integrante de algún grupo delictivo?'));
            $this->Cell(5,   4, utf8_decode('Sí'));
            $this->Cell(4,   4, (isset($detenido->Grupo_Delictivo) && $detenido->Grupo_Delictivo != '') ?  'X' : '', 'LTRB');
            $this->Cell(2,   4);
            $this->Cell(10,  4, utf8_decode('¿Cuál?'));
            $this->Cell(42,  4, (isset($detenido->Grupo_Delictivo) && $detenido->Grupo_Delictivo != '') ?  utf8_decode(strtoupper($detenido->Grupo_Delictivo)) : '');
            $this->Cell(5,   4, utf8_decode('No'));
            $this->Cell(4,   4, (isset($detenido->Grupo_Delictivo) && $detenido->Grupo_Delictivo == '') ?  'X' : '', 'LTRB');
            $this->Cell(8,   4, '', 'R', 1);
            $this->Cell(133, 0);
            $this->Cell(64,  0, '..........................................................', 0, 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado A.3 Datos del familiar o persona de confianza señalado por la persona detenida'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(64,  4, (isset($detenido->Ap_Paterno_F)) ? utf8_decode(strtoupper($detenido->Ap_Paterno_F)) : '', 'L', 0, 'C');
            $this->Cell(63,  4, (isset($detenido->Ap_Materno_F)) ? utf8_decode(strtoupper($detenido->Ap_Materno_F)) : '', 0,  0, 'C');
            $this->Cell(63,  4, (isset($detenido->Nombre_F)) ? utf8_decode(strtoupper($detenido->Nombre_F)) : '', 'R', 1, 'C');
            $this->Cell(67,  0, '..................................................................................', 0, 0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0,  0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(64,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(63,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(63,  6, 'Nombre(s)', 'R', 1, 'C');
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            (isset($detenido->Telefono_F))? $telefonoFam = str_split($detenido->Telefono_F) : $telefonoFam = array();
            $this->Cell(23,  4, utf8_decode('No. telefónico:'));
            for($i=0;$i<10;$i++){
                $this->Cell(4,   4, (isset($telefonoFam[$i])) ? $telefonoFam[$i] : '', 'LRB');
            }
            $this->Cell(20,  4);
            $this->Cell(25,  4, utf8_decode('No proporcionado'));
            $this->Cell(4,   4, (isset($detenido->Telefono_F)) ? '' : 'X', 'LTRB');
            $this->Cell(73,  4, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
        }
        function AnexoAPag2($detenido = NULL,$num_detenido = 0, $lugarIntervencion = NULL)
        {
            $this->Ln(2);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            if($detenido == NULL) $this->Line($this->GetX(),$this->GetY(),$this->GetX()+190,$this->GetY()+280);
            $this->Cell(190, 5, utf8_decode('Apartado A.4 Constancia de lectura de derechos de la persona detenida'), 'LTRB', 1, '', true);
            $this->SetFillColor(196, 189, 151);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Artículo 20 apartado B de la Constitución Política de los Estados Unidos Mexicanos y artículo 152 del Código Nacional de'), 'LTR', 1, '', true);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Procedimientos Penales'), 'LR', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, 'Informe a la persona detenida:', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '1.');
            $this->Cell(180, 4, utf8_decode('Usted tiene derecho a conocer el motivo de su detención.'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '2.');
            $this->Cell(180, 4, utf8_decode('Usted tiene derecho a guardar silencio'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '3.');
            $this->Cell(180, 4, utf8_decode('Usted tiene derecho a declarar, y en caso de hacerlo, lo hará asistido de su defensor ante la autoridad competente.'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '4.');
            $this->Cell(180, 4, utf8_decode('Usted tiene derecho a ser asistido por un defensor, si no quiere o no puede hacerlo, le será designado un defensor público.'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '5.');
            $this->Cell(180, 4, utf8_decode('Usted tiene derecho a hacer del conocimiento a un familiar o persona que desee, los hechos de su detención y el lugar de custodia en que'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(10,  4, '', 'L');
            $this->Cell(180, 4, utf8_decode('se halle en cada momento.'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '6.');
            $this->Cell(180, 4, utf8_decode('Usted es considerado inocente desde este momento hasta que se determine lo contrario.'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '7.');
            $this->Cell(180, 4, utf8_decode('En caso de ser extranjero, Usted tiene derecho a que el consulado de su país sea notificado de su detención.'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '8.');
            $this->Cell(180, 4, utf8_decode('Usted tiene derecho a un traductor o intérprete, el cual será proporcionado por el Estado.'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '9.');
            $this->Cell(180, 4, utf8_decode('Usted tiene derecho a ser presentado ante el Ministerio Público o Juez de Control, según sea el caso, inmediatamente después de ser'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(10,  4, '', 'L');
            $this->Cell(180, 4, utf8_decode('detenido o aprehendido.'), 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->SetFont('Arial','BU',7);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(185, 4, utf8_decode('Si la persona detenida es un adolescente, infórmele también:'), 'R', 1);
            $this->Cell(3,   2);
            $this->SetFont('Arial','',7);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '10.');
            $this->Cell(180, 4, utf8_decode('Usted tiene derecho a permanecer en un lugar distinto al de los adultos.'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '11.');
            $this->Cell(180, 4, utf8_decode('Usted tiene derecho a un trato digno y de conformidad con su condición de adolescente.'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '12.');
            $this->Cell(180, 4, utf8_decode('Usted tiene derecho a que la autoridad informe sobre su detención a la procuraduría federal o local de protección de niñas, niños y'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(10,  4, '', 'L');
            $this->Cell(180, 4, utf8_decode('adolescentes. '), 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(65,  4, utf8_decode('¿Le informó sus derechos a la persona detenida?'));
            $this->Cell(5,   4, utf8_decode('Sí'));
            $this->Cell(4,   4, (isset($detenido->Lectura_Derechos) && $detenido->Lectura_Derechos == '1') ? 'X' : '', 'LTRB');
            $this->Cell(5,   4);
            $this->Cell(5,   4, utf8_decode('No'));
            $this->Cell(4,   4, (isset($detenido->Lectura_Derechos) && $detenido->Lectura_Derechos == '0') ? 'X' : '', 'LTRB');
            $this->Cell(97,  4, '', 'R', 1);
            $this->Cell(3,   7);
            $this->Cell(190, 7, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '.....................................................................................', 'LR', 1, 'C');
            $this->Cell(3,   4);
            $this->Cell(190, 4, 'Firma/Huella de le persona detenida', 'LR', 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LRB', 1);
            $this->Cell(3,   4);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(190, 5, utf8_decode('Apartado A.5 Inspección a la persona detenida'), 'LTRB', 1, '', true);
            $this->SetFillColor(196, 189, 151);
            $this->SetTextColor(0,0,0);
            $this->SetFont('Arial','',7);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'RL', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(185, 4, utf8_decode('Al momento de realizar la inspección a la persona detenida, ¿le encontró algún objeto relacionado con los hechos?'), 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'RL', 1);
            $this->Cell(3,   4);
            $this->Cell(25,  4, '', 'L');
            $this->Cell(5,   4, utf8_decode('Sí'));
            $this->Cell(4,   4, (isset($detenido->Objeto_Encontrado) && $detenido->Objeto_Encontrado == '1') ? 'X' : '', 'LTRB');
            $this->Cell(5,   4, 'Llene el Anexo D');
            $this->Cell(40,  4);
            $this->Cell(5,   4, 'No');
            $this->Cell(4,   4, (isset($detenido->Objeto_Encontrado) && $detenido->Objeto_Encontrado == '0') ? 'X' : '', 'LTRB');
            $this->Cell(102, 4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'RL', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(74,  4, utf8_decode('¿Recolectó pertenencias de la persona detenida?'));
            $this->Cell(5,   4, utf8_decode('Sí'));
            $this->Cell(4,   4, (isset($detenido->Pertenencias_Encontradas) && $detenido->Pertenencias_Encontradas == '1') ? 'X' : '', 'LTRB');
            $this->Cell(5,   4, 'Complete el siguiente cuadro');
            $this->Cell(50,  4);
            $this->Cell(5,   4, 'No');
            $this->Cell(4,   4, (isset($detenido->Pertenencias_Encontradas) && $detenido->Pertenencias_Encontradas == '0') ? 'X' : '', 'LTRB');
            $this->Cell(38,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'RL', 1);
            $this->Cell(3,   4);
            (isset($detenido->Pertenencias)) ? $pertenencias = explode('|||', $detenido->Pertenencias) : $pertenencias = array();
            if($detenido != NULL && count($pertenencias) == 0) $this->Line($this->GetX()+7,$this->GetY(),$this->GetX()+181,$this->GetY()+64);
            $this->Cell(7,   4, '', 'L');
            $header = array('Pertenencias', utf8_decode('Breve descripción'), 'Destino que se le dio');
            foreach($header as $col)
                $this->Cell(58,4, $col, 1, 0, 'C');
            $this->Cell(9,   4, '', 'R', 1);
            $this->Cell(3,   4);
            for($j=0;$j<=9;$j++){
                (isset($pertenencias[$j])) ? $pertenencia = explode('|',$pertenencias[$j]) : $pertenencia = array();
                for($i=0;$i<=3;$i++){
                    switch($i){
                        case 0:
                            $this->Cell(7,  6, '', 'L', 0, 'C');
                            $this->Cell(8,  6, $j+1, 'LRB', 0, 'C');
                        break;
                        case 1:
                            $this->Cell(50, 6, (isset($pertenencia[$i-1])) ? $pertenencia[$i-1] : '', 'RB', 0, 'C');
                        break;
                        case 2:
                            $this->Cell(58, 6, (isset($pertenencia[$i-1])) ? $pertenencia[$i-1] : '', 'RB', 0, 'C');
                        break;
                        case 3:
                            $this->Cell(58, 6, (isset($pertenencia[$i-1])) ? $pertenencia[$i-1] : '', 'RB', 0, 'C');
                            $this->Cell(9,  6, '', 'R', 1);
                            $this->Cell(3,  6);
                        break;
                    }
                }
            }
            $this->Cell(190, 6, '', 'LRB', 1);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado A.6 Datos del lugar de la detención'), 'LTRB', 1, '', true);
            $this->Cell(3,   3);
            $this->SetFillColor(196, 189, 151);
            $this->SetTextColor(0,0,0);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->SetFont('Arial','',7);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(100, 4, utf8_decode('¿El lugar de la detención es el mismo que el de la intervención?'));
            $this->Cell(5,   4, utf8_decode('Sí'));
            $this->Cell(4,   4, (isset($detenido->Id_Ubicacion_Detencion) && $detenido->Id_Ubicacion_Detencion == $lugarIntervencion->Id_Ubicacion) ? 'X' : '', 'LTRB');
            $this->Cell(20,  4);
            $this->Cell(5,   4, 'No');
            $this->Cell(4,   4, (isset($detenido->Id_Ubicacion_Detencion) && $detenido->Id_Ubicacion_Detencion != $lugarIntervencion->Id_Ubicacion) ? 'X' : '', 'LTRB');
            $this->Cell(5,   4, utf8_decode('Indique la dirección'));
            $this->Cell(42,  4, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(35,  4, 'Calle/Tramo carretero:');
            $this->Cell(150, 4, (isset($detenido->Calle_1_Ubi)) ? utf8_decode(strtoupper($detenido->Calle_1_Ubi)) : '', 'R', 1);
            $this->Cell(43,  0);
            $this->Cell(64,  0, '...............................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(15,  4, 'No. exterior:');
            $this->Cell(42,  4, (isset($detenido->No_Ext_Ubi)) ? utf8_decode(strtoupper($detenido->No_Ext_Ubi)) : '');
            $this->Cell(18,  4, 'No. interior:');
            $this->Cell(41,  4, (isset($detenido->No_Int_Ubi)) ? utf8_decode(strtoupper($detenido->No_Int_Ubi)) : '');
            $this->Cell(19,  4, utf8_decode('Código Postal:'));
            $this->Cell(40,  4, (isset($detenido->CP_Ubi)) ? utf8_decode(strtoupper($detenido->CP_Ubi)) : '');
            $this->Cell(10,  4, '', 'R', 1);
            $this->Cell(23,  0);
            $this->Cell(40,  0, '............................................................');
            $this->Cell(20,  0);
            $this->Cell(40,  0, '............................................................');
            $this->Cell(20,  0);
            $this->Cell(40,  0, '.............................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(35,  4, 'Colonia/Localidad:');
            $this->Cell(150, 4, (isset($detenido->Colonia_Ubi)) ? utf8_decode(strtoupper($detenido->Colonia_Ubi)) : '', 'R', 1);
            $this->Cell(43,  0);
            $this->Cell(64,  0, '...............................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(35,  4, utf8_decode('Municipio/Demarcación:'));
            $this->Cell(150, 4, (isset($detenido->Municipio_Ubi)) ? utf8_decode(strtoupper($detenido->Municipio_Ubi)) : '', 'R', 1);
            $this->Cell(43,  0);
            $this->Cell(64,  0, '...............................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(21,  3, '', 'L');
            $this->Cell(169, 3, 'territorial:', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(35,  4, 'Entidad federativa:');
            $this->Cell(150, 4, (isset($detenido->Estado_Ubi)) ? utf8_decode(strtoupper($detenido->Estado_Ubi)) : '', 'R', 1);
            $this->Cell(43,  0);
            $this->Cell(64,  0, '...............................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(35,  4, 'Referencias:');
            $this->Cell(150, 4, (isset($detenido->Referencias_Ubi)) ? utf8_decode(strtoupper($detenido->Referencias_Ubi)) : '', 'R', 1);
            $this->Cell(43,  0);
            $this->Cell(64,  0, '...............................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   6);
            $this->Cell(190, 6, '', 'LRB', 1);
        }
        function AnexoAPag3($detenido = NULL,$num_detenido = 0)
        {
            $this->SetFont('Arial','B',7);
            $this->Ln(2);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            if($detenido == NULL) $this->Line($this->GetX(),$this->GetY(),$this->GetX()+190,$this->GetY()+111);
            $this->Cell(190, 6, utf8_decode('Apartado A.7 Datos del lugar del traslado de la persona detenida'), 'LTRB', 1, '', true);
            $this->Cell(3,   3);
            $this->SetFillColor(196, 189, 151);
            $this->SetTextColor(0,0,0);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->SetFont('Arial','',7);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(185, 4, 'Lugar de traslado:', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(40,  4, '', 'L');
            $this->Cell(20,  4, utf8_decode('Fiscalía/Agencia'));
            $this->Cell(4,   4, (isset($detenido->Lugar_Traslado) && $detenido->Lugar_Traslado == 'Fiscalía/Agencia') ? 'X' : '', 'LTRB');
            $this->Cell(20,  4);
            $this->Cell(11,  4, 'Hospital');
            $this->Cell(4,   4, (isset($detenido->Lugar_Traslado) && $detenido->Lugar_Traslado == 'Hospital') ? 'X' : '', 'LTRB');
            $this->Cell(25,  4);
            $this->Cell(22,  4, 'Otra dependencia');
            $this->Cell(4,   4, (isset($detenido->Lugar_Traslado) && $detenido->Lugar_Traslado == 'Otra dependencia') ? 'X' : '', 'LTRB');
            $this->Cell(40,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(25,  4, '', 'L');
            $this->Cell(10,  4, utf8_decode('¿Cuál?'));
            $this->Cell(155, 4, (isset($detenido->Descripcion_Traslado)) ? utf8_decode(strtoupper($detenido->Descripcion_Traslado)) : '', 'R', 1);
            $this->Cell(38,  0);
            $this->Cell(64,  0, '.........................................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LRB', 1);
            $this->Cell(3,   5);
            $this->SetFont('Arial','B',7);
            $this->Cell(190, 5, utf8_decode('Observaciones relacionadas con la detención'), 'LTRB', 1, '', true);
            $this->Cell(3,   2);
            $this->SetFont('Arial','',7);
            $this->Cell(190, 2, '', 'RL', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Describa brevemente la ruta y el medio de traslado desde el lugar de la detención hasta la puesta a disposición, así como la razón de posibles demoras. Incluya'), 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('cualquier otra observación que considere relevante.'), 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->MultiCell(190, 4, (isset($detenido->Observaciones_Detencion)) ? utf8_decode(strtoupper($detenido->Observaciones_Detencion)) : '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
            $this->Cell(3,   5);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(190, 5, utf8_decode('Apartado A.8 Datos del primer respondiente que realizó la detención'), 'LTRB', 1, '', true);
            $this->Cell(3,   3);
            $this->SetFont('Arial','',7);
            $this->SetFillColor(196, 189, 151);
            $this->SetTextColor(0,0,0);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(64,  4, (isset($detenido->Ap_Paterno_PR)) ? utf8_decode(strtoupper($detenido->Ap_Paterno_PR)) : '', 'L', 0, 'C');
            $this->Cell(63,  4, (isset($detenido->Ap_Materno_PR)) ? utf8_decode(strtoupper($detenido->Ap_Materno_PR)) : '', 0,  0, 'C');
            $this->Cell(63,  4, (isset($detenido->Nombre_PR)) ? utf8_decode(strtoupper($detenido->Nombre_PR)) : '', 'R', 1, 'C');
            $this->Cell(67,  0, '..................................................................................', 0, 0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0,  0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(64,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(63,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(63,  6, 'Nombre(s)', 'R', 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(16,  4, utf8_decode('Adscripción:'));
            $this->Cell(48,  4, (isset($detenido->Institucion_PR)) ? utf8_decode(strtoupper($detenido->Institucion_PR)) : '');
            $this->Cell(17,  4, 'Cargo/grado:');
            $this->Cell(47,  4, (isset($detenido->Cargo_PR)) ? utf8_decode(strtoupper($detenido->Cargo_PR)) : '');
            $this->Cell(57,  4, 'Firma:', 'R', 1);
            $this->Cell(91,  0, '................................................................', 0, 0, 'C');
            $this->Cell(37,  0, '........................................................', 0,  0, 'C');
            $this->Cell(78,  0, '..................................................................', 0, 1, 'C');
            $this->Cell(3,   5);
            $this->Cell(190, 5, '', 'LRB', 1);
            $this->Cell(3,   3);
            if($detenido != NULL) if(isset($detenido->Nombre_SR) == false || $detenido->Nombre_SR == '') $this->Line($this->GetX(),$this->GetY(),$this->GetX()+190,$this->GetY()+25);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(64,  4, (isset($detenido->Ap_Paterno_SR)) ? utf8_decode(strtoupper($detenido->Ap_Paterno_SR)) : '', 'L', 0, 'C');
            $this->Cell(63,  4, (isset($detenido->Ap_Materno_SR)) ? utf8_decode(strtoupper($detenido->Ap_Materno_SR)) : '', 0,  0, 'C');
            $this->Cell(63,  4, (isset($detenido->Nombre_SR)) ? utf8_decode(strtoupper($detenido->Nombre_SR)) : '', 'R', 1, 'C');
            $this->Cell(67,  0, '..................................................................................', 0, 0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0,  0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(64,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(63,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(63,  6, 'Nombre(s)', 'R', 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(16,  4, utf8_decode('Adscripción:'));
            $this->Cell(48,  4, (isset($detenido->Institucion_SR)) ? utf8_decode(strtoupper($detenido->Institucion_SR)) : '');
            $this->Cell(17,  4, 'Cargo/grado:');
            $this->Cell(47,  4, (isset($detenido->Cargo_SR)) ? utf8_decode(strtoupper($detenido->Cargo_SR)) : '');
            $this->Cell(57,  4, 'Firma:', 'R', 1);
            $this->Cell(88,  0, '................................................................', 0, 0, 'C');
            $this->Cell(37,  0, '........................................................', 0,  0, 'C');
            $this->Cell(78,  0, '..................................................................', 0, 1, 'C');
            $this->Cell(3,   5);
            $this->Cell(190, 5, '', 'LRB', 1);
        }

        function AnexoB($data)
        {
            if($data['AnexosB']){
                $informes = $data['AnexosB'];
                foreach($informes as $key=>$informe){
                    $this->AddPage('P', 'Legal');
                    $this->AnexoBPag1($informe, $key+1);
                }
            }else{
                $this->AddPage('P', 'Legal');
                $this->AnexoBPag1();
            }
        }

        function AnexoBPag1($informe = NULL, $num_informe = 0)
        {
            $this->SetFont('Arial','B',8);
            $this->Ln(2);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('ANEXO B. INFORME DEL USO DE LA FUERZA'), 0, 1, 'C');
            $this->SetFont('Arial','B',7);
            $this->Ln(2);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Llene este Anexo sólo en caso de lesionados y/o fallecidos con motivo del uso de la fuerza.'), 0, 1);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            if($informe == NULL) $this->Line($this->GetX()+3,$this->GetY(),$this->GetX()+193,$this->GetY()+127);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado A.1 Fecha y hora de la detención'), 'LTRB', 1, '', true);
            $this->Cell(3,   2);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->Cell(95,  2, '', 'LR');
            $this->Cell(95,  2, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(15,  4, utf8_decode('Indique cuántos:'));
            $this->Cell(75,  4, '', 'R');
            $this->Cell(5,   4);
            $this->Cell(15,  4, utf8_decode('Seleccione con una "X" según corresponda:'));
            $this->Cell(75,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(95,  3, '', 'LR');
            $this->Cell(95,  3, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(34,  4, '', 'L' );
            $this->SetFont('Arial','B',7);
            $this->Cell(32,  4, utf8_decode('Autoridad'));
            $this->Cell(29,  4, utf8_decode('Personas'), 'R');
            $this->SetFont('Arial','',7);
            $this->Cell(10,  4, '', 'L');
            $this->Cell(68,  4, utf8_decode('Reducción física de movimientos'));
            $this->Cell(4,   4, (isset($informe->Reduccion_Movimiento) && $informe->Reduccion_Movimiento != '0') ? 'X' : '', 'LTRB');
            $this->Cell(13,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(95,  3, '', 'LR');
            $this->Cell(95,  3, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(10,  4, '', 'L');
            (isset($informe->Num_Lesionados_Autoridad)) ? $lesionadosAutoridad = $informe->Num_Lesionados_Autoridad : $lesionadosAutoridad = 0;
            $lesionadosAutoridadArray = [0,0,0];
            if($lesionadosAutoridad > 0){
                $lesionadosAutoridad = strrev(strval($lesionadosAutoridad));
                for($i=0; $i<strlen($lesionadosAutoridad); $i++)
                $lesionadosAutoridadArray[$i] = intval($lesionadosAutoridad[$i]);
                $lesionadosAutoridadArray = array_reverse($lesionadosAutoridadArray);
            }
            $this->Cell(20,  4, utf8_decode('Lesionados'));
            $this->Cell(4,   4, ($lesionadosAutoridad>0) ? 'X' : '', 'LTRB');
            $this->Cell(4,   4);
            foreach($lesionadosAutoridadArray as $lesionados){
                $this->Cell(4,   4, (isset($informe->Num_Lesionados_Autoridad)) ? $lesionados : '', 'LRB');
            }
            $this->Cell(12,  4);
            (isset($informe->Num_Lesionados_Persona)) ? $lesionadosPersona = $informe->Num_Lesionados_Persona : $lesionadosPersona = 0;
            $lesionadosPersonaArray = [0,0,0];
            if($lesionadosPersona > 0){
                $lesionadosPersona = strrev(strval($lesionadosPersona));
                for($i=0; $i<strlen($lesionadosPersona); $i++)
                $lesionadosPersonaArray[$i] = intval($lesionadosPersona[$i]);
                $lesionadosPersonaArray = array_reverse($lesionadosPersonaArray);
            }
            $this->Cell(4,   4, ($lesionadosPersona>0) ? 'X' : '', 'LTRB');
            $this->Cell(4,   4);
            foreach($lesionadosPersonaArray as $lesionados){
                $this->Cell(4,   4, (isset($informe->Num_Lesionados_Persona)) ? $lesionados : '', 'LRB');
            }
            $this->Cell(13,  4, '', 'R');
            $this->Cell(10,  4, '', 'L');
            $this->Cell(68,  4, utf8_decode('Utilización de armas incapacitantes menos letales'));
            $this->Cell(4,   4, (isset($informe->Armas_Incapacitantes) && $informe->Armas_Incapacitantes != '0') ? 'X' : '', 'LTRB');
            $this->Cell(13,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(95,  3, '', 'LR');
            $this->Cell(95,  3, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(10,  4, '', 'L');
            (isset($informe->Num_Fallecidos_Autoridad)) ? $fallecidosAurotidad = $informe->Num_Fallecidos_Autoridad : $fallecidosAurotidad = 0;
            $fallecidosAurotidadArray = [0,0,0];
            if($fallecidosAurotidad > 0){
                $fallecidosAurotidad = strrev(strval($fallecidosAurotidad));
                for($i=0; $i<strlen($fallecidosAurotidad); $i++)
                $fallecidosAurotidadArray[$i] = intval($fallecidosAurotidad[$i]);
                $fallecidosAurotidadArray = array_reverse($fallecidosAurotidadArray);
            }
            $this->Cell(20,  4, utf8_decode('Fallecidos'));
            $this->Cell(4,   4, ($fallecidosAurotidad>0) ? 'X' : '', 'LTRB');
            $this->Cell(4,   4);
            foreach($fallecidosAurotidadArray as $fallecido){
                $this->Cell(4,   4, (isset($informe->Num_Fallecidos_Autoridad)) ? $fallecido : '', 'LRB');
            }
            $this->Cell(12,  4);
            (isset($informe->Num_Fallecidos_Persona)) ? $fallecidosPersona = $informe->Num_Fallecidos_Persona : $fallecidosPersona = 0;
            $fallecidosPersonaArray = [0,0,0];
            if($fallecidosPersona > 0){
                $fallecidosPersona = strrev(strval($fallecidosPersona));
                for($i=0; $i<strlen($fallecidosPersona); $i++)
                $fallecidosPersonaArray[$i] = intval($fallecidosPersona[$i]);
                $fallecidosPersonaArray = array_reverse($fallecidosPersonaArray);
            }
            $this->Cell(4,   4, '', 'LTRB');
            $this->Cell(4,   4);
            foreach($fallecidosPersonaArray as $fallecido){
                $this->Cell(4,   4, (isset($informe->Num_Fallecidos_Persona)) ? $fallecido : '', 'LRB');
            }
            $this->Cell(13,  4, '', 'R');
            $this->Cell(10,  4, '', 'L');
            $this->Cell(68,  4, utf8_decode('Utilización de armas de fuego o fuerza letal'));
            $this->Cell(4,   4, (isset($informe->Armas_Fuego) && $informe->Armas_Fuego != '0') ? 'X' : '', 'LTRB');
            $this->Cell(13,  4, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(95,  4, '', 'LRB');
            $this->Cell(95,  4, '', 'RB', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Describa las conductas (resistencia activa y de alta peligrosidad) que motivaron el uso de la fuerza:'), 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->MultiCell(190, 4, (isset($informe->Descripcion_Conducta)) ? utf8_decode(strtoupper($informe->Descripcion_Conducta)) : '', 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LRB', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR',  1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(60,  4, utf8_decode('¿Brindó o solicitó asistencia médica?'));
            $this->Cell(4,   4, utf8_decode('Sí'));
            $this->Cell(4,   4);
            $this->Cell(4,   4, (isset($informe->Asistencia_Medica) && $informe->Asistencia_Medica != '') ? 'X' : '', 'LTRB');
            $this->Cell(15,  4);
            $this->Cell(4,   4, utf8_decode('No'));
            $this->Cell(4,   4);
            $this->Cell(4,   4, (isset($informe->Asistencia_Medica) && $informe->Asistencia_Medica == '') ? 'X' : '', 'LTRB');
            $this->Cell(86,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR',  1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->MultiCell(185,  4, (isset($informe->Asistencia_Medica) && $informe->Asistencia_Medica != '') ? utf8_decode(strtoupper('Explique: '.$informe->Asistencia_Medica)) : utf8_decode('Explique:'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado B.2 Datos del primer respondiente que realizó el informe del uso de la fuerza, sólo si es diferente a quien firmó la puesta'), 'LTR', 1, '', true);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('a disposición'), 'LRB', 1, '', true);
            $this->Cell(3,   3);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(64,  4, (isset($informe->Ap_Paterno_PR)) ? utf8_decode(strtoupper($informe->Ap_Paterno_PR)) : '', 'L', 0, 'C');
            $this->Cell(63,  4, (isset($informe->Ap_Materno_PR)) ? utf8_decode(strtoupper($informe->Ap_Materno_PR)) : '', 0,  0, 'C');
            $this->Cell(63,  4, (isset($informe->Nombre_PR)) ? utf8_decode(strtoupper($informe->Nombre_PR)) : '', 'R', 1, 'C');
            $this->Cell(67,  0, '..................................................................................', 0, 0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0,  0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(64,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(63,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(63,  6, 'Nombre(s)', 'R', 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(16,  4, utf8_decode('Adscripción:'));
            $this->Cell(48,  4, (isset($informe->Institucion_PR)) ? utf8_decode(strtoupper($informe->Institucion_PR)) : '');
            $this->Cell(17,  4, 'Cargo/grado:');
            $this->Cell(46,  4, (isset($informe->Cargo_PR)) ? utf8_decode(strtoupper($informe->Cargo_PR)) : '');
            $this->Cell(58,  4, 'Firma:', 'R', 1);
            $this->Cell(91,  0, '................................................................', 0, 0, 'C');
            $this->Cell(37,  0, '........................................................', 0,  0, 'C');
            $this->Cell(78,  0, '..................................................................', 0, 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LRB', 1);
            $this->Cell(3,   3);
            if($informe != NULL) if(!isset($informe->Nombre_SR) || $informe->Nombre_SR == '') $this->Line($this->GetX(),$this->GetY(),$this->GetX()+190,$this->GetY()+24);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(64,  4, (isset($informe->Ap_Paterno_SR)) ? utf8_decode(strtoupper($informe->Ap_Paterno_SR)) : '', 'L', 0, 'C');
            $this->Cell(63,  4, (isset($informe->Ap_Materno_SR)) ? utf8_decode(strtoupper($informe->Ap_Materno_SR)) : '', 0,  0, 'C');
            $this->Cell(63,  4, (isset($informe->Nombre_SR)) ? utf8_decode(strtoupper($informe->Nombre_SR)) : '', 'R', 1, 'C');
            $this->Cell(67,  0, '..................................................................................', 0, 0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0,  0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(64,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(63,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(63,  6, 'Nombre(s)', 'R', 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(16,  4, utf8_decode('Adscripción:'));
            $this->Cell(48,  4, (isset($informe->Institucion_SR)) ? utf8_decode(strtoupper($informe->Institucion_SR)) : '');
            $this->Cell(17,  4, 'Cargo/grado:');
            $this->Cell(46,  4, (isset($informe->Cargo_SR)) ? utf8_decode(strtoupper($informe->Cargo_SR)) : '');
            $this->Cell(58,  4, 'Firma:', 'R', 1);
            $this->Cell(91,  0, '................................................................', 0, 0, 'C');
            $this->Cell(37,  0, '........................................................', 0,  0, 'C');
            $this->Cell(78,  0, '..................................................................', 0, 1, 'C');
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
        }

        function AnexoC($data)
        {
            if($data['AnexosC']){
                $vehiculos = $data['AnexosC'];
                foreach($vehiculos as $key=>$vehiculo){
                    $this->AddPAge('P', 'Legal');
                    $this->AnexoCPag1($vehiculo, $key+1);
                }
            }else{
                $this->AddPAge('P', 'Legal');
                $this->AnexoCPag1();
            }
        }

        function AnexoCPag1($vehiculo = NULL, $num_vehiculo = 0)
        {
            $numVehiculo = [0,0,0];
            if($num_vehiculo>0){
                $num_vehiculo = strrev(strval($num_vehiculo));
                for($i=0; $i<strlen($num_vehiculo); $i++)
                $numVehiculo[$i] = intval($num_vehiculo[$i]);
                $numVehiculo = array_reverse($numVehiculo);
            }
            $this->SetFont('Arial','B',8);
            $this->Ln(2);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('ANEXO C. INSPECCIÓN DE VEHÍCULO'), 0, 1, 'C');
            $this->SetFont('Arial','B',7);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 0, 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Llene este Anexo por cada vehículo inspeccionado.'), 0, 1);
            $this->Cell(3,   5);
            $this->SetFillColor(196, 189, 151);
            $this->SetFont('Arial','B',7);
            if($vehiculo == NULL) $this->Line($this->GetX(),$this->GetY(),$this->GetX()+190,$this->GetY()+188);
            $this->Cell(15,  5, utf8_decode('Vehículo:'), 'LT', 0, '', true);
            foreach($numVehiculo as $numVeh){
                $this->Cell(4,   5, ($num_vehiculo != 0) ? $numVeh : '', 'LTRB', 0, '', true);
            }
            $this->Cell(1,   5, '',  'LT',   0, '', true);
            $this->SetFont('Arial','',7);
            $this->Cell(55,  5, '(001, 002,..., 010,...,)', 'T', 0, '', true);
            $this->Cell(107, 5, '', 'TR', 1, '', true);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 6, utf8_decode('Apartado C.1 Fecha y hora de la inspección'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Indique la fecha y la hora en que realizó la detención'), 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            if(isset($vehiculo->Fecha_Hora)){
                $fechaDetencion = str_split(implode(array_reverse(explode('-',(explode(' ', $vehiculo->Fecha_Hora))[0]))));
                $horaDetencion = str_replace(':', '', (explode(' ', $vehiculo->Fecha_Hora))[1]);
            }else{
                $fechaDetencion = array();
                $horaDetencion = array();
            }
            $this->Cell(10,  4, 'Fecha:');
            for($i=0;$i<8;$i++){
                $this->Cell(4,   4, (isset($fechaDetencion[$i])) ? $fechaDetencion[$i] : '', 'LRB');
            }
            $this->Cell(25,  4);
            $this->Cell(10,  4, 'Hora:');
            $this->Cell(4,   4, (isset($horaDetencion[0])) ? $horaDetencion[0] : '', 'LRB');
            $this->Cell(4,   4, (isset($horaDetencion[1])) ? $horaDetencion[1] : '', 'RB');
            $this->Cell(4,   4, ':', 0, 0, 'C');
            $this->Cell(4,   4, (isset($horaDetencion[2])) ? $horaDetencion[2] : '', 'LRB');
            $this->Cell(4,   4, (isset($horaDetencion[3])) ? $horaDetencion[3] : '', 'RB');
            $this->Cell(88,  4, '(24 horas)', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(15,  4, '', 'L');
            $this->Cell(4,   4, 'D');
            $this->Cell(4,   4, 'D');
            $this->Cell(4,   4, 'M');
            $this->Cell(4,   4, 'M');
            $this->Cell(4,   4, 'A');
            $this->Cell(4,   4, 'A');
            $this->Cell(4,   4, 'A');
            $this->Cell(4,   4, 'A');
            $this->Cell(35,  4);
            $this->Cell(4,   4, 'h');
            $this->Cell(4,   4, 'h');
            $this->Cell(4,   4);
            $this->Cell(4,   4, 'm');
            $this->Cell(92,  4, 'm', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado C.2 Datos generales del vehículo inspeccionado'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0, 0, 0);
            $this->Cell(3,   3);
            $this->Cell(115, 3, '', 'LR');
            $this->Cell(75,  3, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(110, 4, 'Tipo:');
            $this->Cell(5,   4, '', 'L');
            $this->Cell(70,  4, 'Procedencia:', 'R', 1);
            $this->Cell(3,   2);
            $this->Cell(115, 2, '', 'LR');
            $this->Cell(75,  2, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(15,  4, '', 'L');
            $this->Cell(12,  4, 'Terrestre');
            $this->Cell(4,   4, (isset($vehiculo->Tipo) && $vehiculo->Tipo == 'TERRESTRE') ? 'X' : '', 'LTRB');
            $this->Cell(18,  4);
            $this->Cell(12,  4, utf8_decode('Acuático'));
            $this->Cell(4,   4, (isset($vehiculo->Tipo) && $vehiculo->Tipo == 'ACUATICO') ? 'X' : '', 'LTRB');
            $this->Cell(18,  4);
            $this->Cell(9,   4, utf8_decode('Aéreo'));
            $this->Cell(4,   4, (isset($vehiculo->Tipo) && $vehiculo->Tipo == 'AEREO') ? 'X' : '', 'LTRB');
            $this->Cell(19,  4);
            $this->Cell(25,  4, '', 'L');
            $this->Cell(12,  4, 'Nacional');
            $this->Cell(4,   4, (isset($vehiculo->Procedencia) && $vehiculo->Procedencia == 'NACIONAL') ? 'X' : '', 'LTRB');
            $this->Cell(10,  4);
            $this->Cell(13,  4, 'Extranjero');
            $this->Cell(4,   4, (isset($vehiculo->Procedencia) && $vehiculo->Procedencia == 'EXTRANJERO') ? 'X' : '', 'LTRB');
            $this->Cell(7,   4, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(115, 4, '', 'LRB');
            $this->Cell(75,  4, '', 'RB', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(10,  4, 'Marca:');
            $this->Cell(40,  4, (isset($vehiculo->Marca)) ? utf8_decode(strtoupper($vehiculo->Marca)) : '');
            $this->Cell(14,  4, 'Submarca:');
            $this->Cell(36,  4, (isset($vehiculo->Submarca)) ? utf8_decode(strtoupper($vehiculo->Submarca)) : '');
            $this->Cell(11,  4, 'Modelo:');
            (isset($vehiculo->Modelo)) ? $modelo = str_split($vehiculo->Modelo) : $modelo = array();
            for($i=0;$i<4;$i++){
                $this->Cell(4,   4, (isset($modelo[$i])) ? $modelo[$i] : '', 'LRB');
            }
            $this->Cell(20,  4);
            $this->Cell(38,  4, (isset($vehiculo->Color)) ? utf8_decode('Color: '.strtoupper($vehiculo->Color)) : 'Color:', 'R', 1);
            $this->Cell(18,  0);
            $this->Cell(25,  0, '................................................');
            $this->Cell(29,  0);
            $this->Cell(25,  0, '................................................');
            $this->Cell(66,  0);
            $this->Cell(25,  0, '.................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(185, 4, 'Uso:', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(15,  4, '', 'L');
            $this->Cell(13,  4, 'Particular');
            $this->Cell(4,   4, (isset($vehiculo->Uso) && $vehiculo->Uso == 'PARTICULAR') ? 'X' : '', 'LTRB');
            $this->Cell(50,  4);
            $this->Cell(23,  4, utf8_decode('Transporte público'));
            $this->Cell(4,   4, (isset($vehiculo->Uso) && $vehiculo->Uso == 'TRANSPORTE PUBLICO') ? 'X' : '', 'LTRB');
            $this->Cell(40,  4);
            $this->Cell(9,   4, 'Carga');
            $this->Cell(4,   4, (isset($vehiculo->Uso) && $vehiculo->Uso == 'CARGA') ? 'X' : '', 'LTRB');
            $this->Cell(28,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(12,  4, '', 'L');
            $this->Cell(25,  4, utf8_decode('Placa/Matrícula:'));
            (isset($vehiculo->Placa)) ? $placa = str_split($vehiculo->Placa) : $placa = array();
            for($i=0;$i<8;$i++){
                $this->Cell(4,   4, (isset($placa[$i])) ? $placa[$i] : '', 'LRB');
            }
            $this->Cell(15,  4);
            $this->Cell(20,  4, utf8_decode('No. de seríe:'));
            (isset($vehiculo->Num_Serie)) ? $numSerie = str_split($vehiculo->Num_Serie) : $numSerie = array();
            for($i=0;$i<18;$i++){
                $this->Cell(4,   4, (isset($numSerie[$i])) ? $numSerie[$i] : '', 'LRB');
            }
            $this->Cell(14,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(185, 4, utf8_decode('Situación'), 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(15,  4, '', 'L');
            $this->Cell(24,  4, 'Con reporte de robo');
            $this->Cell(4,   4, (isset($vehiculo->Situacion) && $vehiculo->Situacion == 'CON REPORTE DE ROBO') ? 'X' : '', 'LTRB');
            $this->Cell(39,  4);
            $this->Cell(23,  4, 'Sin reporte de robo');
            $this->Cell(4,   4, (isset($vehiculo->Situacion) && $vehiculo->Situacion == 'SIN REPORTE DE ROBO') ? 'X' : '', 'LTRB');
            $this->Cell(35,  4);
            $this->Cell(26,  4, 'No es posible saberlo');
            $this->Cell(4,   4, (isset($vehiculo->Situacion) && $vehiculo->Situacion == 'NO ES POSIBLE SABERLO') ? 'X' : '', 'LTRB');
            $this->Cell(16,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->MultiCell(190,  4, (isset($vehiculo->Observaciones)) ? utf8_decode('Observaciones: '.strtoupper($vehiculo->Observaciones)) : utf8_decode('Observaciones:'), 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->MultiCell(190,  4, (isset($vehiculo->Destino)) ? utf8_decode('Destino que se le dio: '.strtoupper($vehiculo->Destino)) : utf8_decode('Destino que se le dio:'), 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   5);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(190, 5, utf8_decode('Apartado C.3 Objetos encontrados en el vehículo inspeccionado'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0, 0, 0);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(185, 4, utf8_decode('¿Encontró objetos relacionados con los hechos?'), 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(15,  4, '', 'L');
            $this->Cell(50,  4);
            $this->Cell(5,   4, utf8_decode('Sí'));
            $this->Cell(4,   4, (isset($vehiculo->Objetos_Encontrados) && $vehiculo->Objetos_Encontrados == '1') ? 'X' : '', 'LTRB');
            $this->Cell(5,   4, utf8_decode('Llene el Anexo D.'));
            $this->Cell(40,  4);
            $this->Cell(5,   4, 'No');
            $this->Cell(4,   4, (isset($vehiculo->Objetos_Encontrados) && $vehiculo->Objetos_Encontrados == '0') ? 'X' : '', 'LTRB');
            $this->Cell(62,  4, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LR', 1);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado C.4 Datos del primer respondiente que realizó la inspección, sólo si es diferente a quien firmó la puesta a disposición'), 'LTBR', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(64,  4, (isset($vehiculo->Ap_Paterno_PR)) ? utf8_decode(strtoupper($vehiculo->Ap_Paterno_PR)) : '', 'L', 0, 'C');
            $this->Cell(63,  4, (isset($vehiculo->Ap_Materno_PR)) ? utf8_decode(strtoupper($vehiculo->Ap_Materno_PR)) : '', 0,  0, 'C');
            $this->Cell(63,  4, (isset($vehiculo->Nombre_PR)) ? utf8_decode(strtoupper($vehiculo->Nombre_PR)) : '', 'R', 1, 'C');
            $this->Cell(67,  0, '..................................................................................', 0, 0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0,  0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(64,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(63,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(63,  6, 'Nombre(s)', 'R', 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(17,  4, utf8_decode('Adscripción:'));
            $this->Cell(47,  4, (isset($vehiculo->Institucion_PR)) ? utf8_decode(strtoupper($vehiculo->Institucion_PR)) : '');
            $this->Cell(15,  4, 'Cargo/grado:');
            $this->Cell(48,  4, (isset($vehiculo->Cargo_PR)) ? utf8_decode(strtoupper($vehiculo->Cargo_PR)) : '');
            $this->Cell(58,  4, 'Firma:', 'R', 1);
            $this->Cell(91,  0, '................................................................', 0, 0, 'C');
            $this->Cell(33,  0, '........................................................', 0,  0, 'C');
            $this->Cell(78,  0, '..............................................................................', 0, 1, 'C');
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
            $this->Cell(3,   3);
            if($vehiculo != NULL)  if(!isset($vehiculo->Nombre_SR) || $vehiculo->Nombre_SR == '') $this->Line($this->GetX(),$this->GetY(),$this->GetX()+190,$this->GetY()+24);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(64,  4, (isset($vehiculo->Ap_Paterno_SR)) ? utf8_decode(strtoupper($vehiculo->Ap_Paterno_SR)) : '', 'L', 0, 'C');
            $this->Cell(63,  4, (isset($vehiculo->Ap_Materno_SR)) ? utf8_decode(strtoupper($vehiculo->Ap_Materno_SR)) : '', 0,  0, 'C');
            $this->Cell(63,  4, (isset($vehiculo->Nombre_SR)) ? utf8_decode(strtoupper($vehiculo->Nombre_SR)) : '', 'R', 1, 'C');
            $this->Cell(67,  0, '..................................................................................', 0, 0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0,  0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(64,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(63,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(63,  6, 'Nombre(s)', 'R', 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(17,  4, utf8_decode('Adscripción:'));
            $this->Cell(47,  4, (isset($vehiculo->Institucion_SR)) ? utf8_decode(strtoupper($vehiculo->Institucion_SR)) : '');
            $this->Cell(15,  4, 'Cargo/grado:');
            $this->Cell(48,  4, (isset($vehiculo->Cargo_SR)) ? utf8_decode(strtoupper($vehiculo->Cargo_SR)) : '');
            $this->Cell(58,  4, 'Firma:', 'R', 1);
            $this->Cell(91,  0, '................................................................', 0, 0, 'C');
            $this->Cell(33,  0, '........................................................', 0,  0, 'C');
            $this->Cell(78,  0, '..............................................................................', 0, 1, 'C');
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
        }

        function AnexoD($data)
        {
            if($data['AnexosD']['armas']){
                $armas = $data['AnexosD']['armas'];
                foreach($armas as $key=>$arma){
                    if($key%2 == 0){
                        $arma1 = $arma;
                        $key1 = $key;
                        if($arma == end($armas)){
                            $this->AddPage('P', 'Legal');
                            $this->AnexoDArmas($arma1, $key1+1);
                        }
                    }else{
                        $arma2 = $arma;
                        $key2 = $key;
                        $this->AddPage('P', 'Legal');
                        $this->AnexoDArmas($arma1, $key1+1, $arma2, $key2+1);
                    }
                }
            }else{
                $this->AddPage('P', 'Legal');
                $this->AnexoDArmas();
            }

            if($data['AnexosD']['objetos']){
                $objetos = $data['AnexosD']['objetos'];
                foreach($objetos as $key=>$objeto){
                    if($key%2 == 0){
                        $objeto1 = $objeto;
                        $key1 = $key;
                        if($objeto == end($objetos)){
                            $this->AddPage('P', 'Legal');
                            $this->AnexoDObjetos($objeto1, $key1+1);
                        }
                    }else{
                        $objeto2 = $objeto;
                        $key2 = $key;
                        $this->AddPage('P', 'Legal');
                        $this->AnexoDObjetos($objeto1, $key1+1, $objeto2, $key2+1);
                    }
                }
            }else{
                $this->AddPage('P', 'Legal');
                $this->AnexoDObjetos();
            }
        }

        function AnexoDArmas($arma1 = NULL, $num_arma1 = 0, $arma2 = NULL, $num_arma2 = 0)
        {
            $this->SetFont('Arial','B',8);
            $this->Ln(2);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('ANEXO D. INVENTARIO DE ARMAS Y OBJETOS'), 0, 1, 'C');
            $this->SetFont('Arial','B',7);
            $this->Cell(6,   4);
            $this->Cell(190, 4, utf8_decode('Llene tantas veces como sea necesario este Anexo'), 0, 1);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado D.1 Registro de armas de fuego'), 'LTRB', 1, '', true);
            
            $this->ArmaFuego($arma1, $num_arma1);
            $this->ArmaFuego($arma2, $num_arma2);

            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado D.2 Datos del primer respondiente que realizó la recolección y/o aseguramiento de la o las armas, sólo si es diferente a'), 'LTR', 1, '', true);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('quien firmó la puesta a disposición'), 'LRB', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->SetFillColor(196, 189, 151);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(64,  4, (isset($arma1->Ap_Paterno_PR)) ? utf8_decode(strtoupper($arma1->Ap_Paterno_PR)) : '', 'L', 0, 'C');
            $this->Cell(63,  4, (isset($arma1->Ap_Materno_PR)) ? utf8_decode(strtoupper($arma1->Ap_Materno_PR)) : '', 0,  0, 'C');
            $this->Cell(63,  4, (isset($arma1->Nombre_PR)) ? utf8_decode(strtoupper($arma1->Nombre_PR)) : '', 'R', 1, 'C');
            $this->Cell(67,  0, '..................................................................................', 0, 0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0,  0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(64,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(63,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(63,  6, 'Nombre(s)', 'R', 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(16,  4, utf8_decode('Adscripción:'));
            $this->Cell(47,  4, (isset($arma1->Institucion)) ? utf8_decode(strtoupper($arma1->Institucion)) : '');
            $this->Cell(16,  4, 'Cargo/grado:');
            $this->Cell(45,  4, (isset($arma1->Cargo)) ? utf8_decode(strtoupper($arma1->Cargo)) : '');
            $this->Cell(61,  4, 'Firma:', 'R', 1);
            $this->Cell(91,  0, '................................................................', 0, 0, 'C');
            $this->Cell(33,  0, '........................................................', 0,  0, 'C');
            $this->Cell(78,  0, '..............................................................................', 0, 1, 'C');
            $this->Cell(3,   5);
            $this->Cell(190, 5, '', 'LRB', 1);
            $this->SetFont('Arial','B',6);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Nota: Este Anexo no sustituye la Cadena de Custodia, la cual deberá ser debidamente requisitada.'));
        }

        function ArmaFuego($arma = NULL, $num_arma = 0)
        {
            $numArma = [0,0,0];
            if($num_arma>0){
                $num_arma = strrev(strval($num_arma));
                for($i=0; $i<strlen($num_arma); $i++)
                    $numArma[$i] = intval($num_arma[$i]);
                $numArma = array_reverse($numArma);
            }
            $this->SetFont('Arial','',7);
            $this->SetFillColor(196, 189, 151);
            $this->SetFont('Arial','B',7);
            $this->SetTextColor(0,0,0);
            if($arma == NULL) $this->Line($this->GetX()+3,$this->GetY(),$this->GetX()+190,$this->GetY()+112);
            $this->Cell(3,   4);
            $this->Cell(25,  4, utf8_decode('Arma de fuego:'), 'LTB', 0, '', true);
            foreach($numArma as $numArm){
                $this->Cell(4,   4, ($num_arma != 0) ? $numArm : '', 'LTRB', 0, '', true);
            }
            $this->Cell(1,   4, '',  'LTB',   0, '', true);
            $this->SetFont('Arial','',7);
            $this->Cell(55,  4, '(001, 002,..., 010,...,)', 'TB', 0, '', true);
            $this->Cell(97,  4, '', 'TRB', 1, '', true);
            $this->Cell(3,   1);
            $this->Cell(190, 1, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Seleccione con una "X" si se trata de aportación o inspección, según corresponda.'), 'LR', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(10,  4, utf8_decode('Aportación'));
            $this->Cell(20,  4);
            $this->Cell(4,   4, (isset($arma->Aportacion) && $arma->Aportacion == '1') ? 'X' : '', 'LTRB');
            $this->Cell(151, 4, '', 'R', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(185, 4, utf8_decode('Inspección:'), 'R', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(25,  4, '', 'L');
            $this->Cell(10,  4, 'Lugar');
            $this->Cell(4,   4, (isset($arma->Inspeccion) && $arma->Inspeccion == 'Lugar') ? 'X' : '', 'LTRB');
            $this->Cell(10,  4);
            $this->Cell(13,  4, 'Persona');
            $this->Cell(4,   4, (isset($arma->Inspeccion) && $arma->Inspeccion == 'Persona') ? 'X' : '', 'LTRB');
            $this->Cell(10,  4);
            $this->Cell(13,  4, utf8_decode('Vehículo'));
            $this->Cell(4,   4, (isset($arma->Inspeccion) && $arma->Inspeccion == 'Vehiculo') ? 'X' : '', 'LTRB');
            $this->Cell(10,  4);
            $this->Cell(35,  4, utf8_decode('¿Dónde se encontró el arma?'));
            $this->MultiCell(52,  4, (isset($arma->Ubicacion_Arma)) ? utf8_decode(strtoupper($arma->Ubicacion_Arma)) : '', 'R', 1);
            $this->Cell(141, 0);
            $this->Cell(63,  0, '...................................................................', '', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LRB', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(20,  4, utf8_decode('Tipo de arma:'));
            $this->Cell(70,  4);
            $this->Cell(11,   4, 'Calibre:');
            $this->Cell(33,  4, (isset($arma->Calibre)) ? utf8_decode(strtoupper($arma->Calibre)) : '');
            $this->Cell(10,   4, 'Color:');
            $this->Cell(41,  4, (isset($arma->Color)) ? utf8_decode(strtoupper($arma->Color)) : '', 'R', 1);
            $this->Cell(109, 0);
            $this->Cell(20,  0, '.............................................');
            $this->Cell(22,  0);
            $this->Cell(40,  0, '....................................................', '', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(25,  4, '', 'L');
            $this->Cell(10,  4, 'Corta');
            $this->Cell(4,   4, (isset($arma->Tipo_Arma) && $arma->Tipo_Arma == 'Corta') ? 'X' : '', 'LTRB');
            $this->Cell(10,  4);
            $this->Cell(13,  4, 'Larga');
            $this->Cell(4,   4, (isset($arma->Tipo_Arma) && $arma->Tipo_Arma == 'Larga') ? 'X' : '', 'LTRB');
            $this->Cell(124, 4, '', 'R', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(15,  4, utf8_decode('Matrícula:'));
            (isset($arma->Matricula)) ? $matricula = str_split($arma->Matricula) : $matricula = array();
            for($i=0;$i<8;$i++){
                $this->Cell(4,   4, (isset($matricula[$i])) ? utf8_decode(strtoupper($matricula[$i])) : '', 'LRB');
            }
            $this->Cell(20,  4);
            $this->Cell(20,  4, utf8_decode('No. de seríe:'));
            (isset($arma->Num_Serie)) ? $numSerie = str_split($arma->Num_Serie) : $numSerie = array();
            for($i=0;$i<19;$i++){
                $this->Cell(4,   4, (isset($numSerie[$i])) ? utf8_decode(strtoupper($numSerie[$i])) : '', 'LRB');
            }
            $this->Cell(22,  4, '', 'R', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LRB', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->MultiCell(190, 4, (isset($arma->Observaciones)) ? utf8_decode('Observaciones (de ser el caso, señale además, características, marca, cargadores y cartuchos): '.strtoupper($arma->Observaciones)): utf8_decode('Observaciones (de ser el caso, señale además, características, marca, cargadores y cartuchos):'), 'LR', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->MultiCell(190,  4, (isset($arma->Destino)) ? utf8_decode('Destino que se le dio: '.strtoupper($arma->Destino)) : utf8_decode('Destino que se le dio:'), 'LR', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LRB', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Anote el nombre y firma de la persona a la que se le aseguró el arma:'), 'LR', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(48,  4, (isset($arma->Ap_Paterno_A)) ? utf8_decode(strtoupper($arma->Ap_Paterno_A)) : '', 'L', 0, 'C');
            $this->Cell(47,  4, (isset($arma->Ap_Materno_A)) ? utf8_decode(strtoupper($arma->Ap_Materno_A)) : '', 0,  0, 'C');
            $this->Cell(47,  4, (isset($arma->Nombre_A)) ? utf8_decode(strtoupper($arma->Nombre_A)) : '', '', 0, 'C');
            $this->Cell(48,  4, '', 'R', 1, 'C');
            $this->Cell(51,  0, '............................................................', 0, 0, 'C');
            $this->Cell(47,  0, '............................................................', 0,  0, 'C');
            $this->Cell(47,  0, '............................................................', 0,  0, 'C');
            $this->Cell(48,  0, '............................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(48,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(47,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(47,  6, 'Nombre(s)', '', 0, 'C');
            $this->Cell(48,  6, 'Firma', 'R', 1, 'C');
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LRB', 1);
            $this->Cell(3,   1);
            $this->Cell(190, 1, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('En caso de que la persona a la que se le aseguró el arma no acceda a firmar, anote nombre y firma de dos testigos:'), 'LR', 1);
            isset($arma->Testigos) ? $testigos = explode('|||',$arma->Testigos) : $testigos = array();
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(48,  4, (isset($testigos[0])) ? utf8_decode(strtoupper((explode(',', $testigos[0]))[1])) : '', 'L', 0, 'C');
            $this->Cell(47,  4, (isset($testigos[0])) ? utf8_decode(strtoupper((explode(',', $testigos[0]))[2])) : '', 0,  0, 'C');
            $this->Cell(47,  4, (isset($testigos[0])) ? utf8_decode(strtoupper((explode(',', $testigos[0]))[0])) : '', '', 0, 'C');
            $this->Cell(48,  4, '', 'R', 1, 'C');
            $this->Cell(51,  0, '............................................................', 0, 0, 'C');
            $this->Cell(47,  0, '............................................................', 0,  0, 'C');
            $this->Cell(47,  0, '............................................................', 0,  0, 'C');
            $this->Cell(48,  0, '............................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(48,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(47,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(47,  6, 'Nombre(s)', '', 0, 'C');
            $this->Cell(48,  6, 'Firma', 'R', 1, 'C');
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(48,  4, (isset($testigos[1])) ? utf8_decode(strtoupper((explode(',', $testigos[1]))[1])) : '', 'L', 0, 'C');
            $this->Cell(47,  4, (isset($testigos[1])) ? utf8_decode(strtoupper((explode(',', $testigos[1]))[2])) : '', 0,  0, 'C');
            $this->Cell(47,  4, (isset($testigos[1])) ? utf8_decode(strtoupper((explode(',', $testigos[1]))[0])) : '', '', 0, 'C');
            $this->Cell(48,  4, '', 'R', 1, 'C');
            $this->Cell(51,  0, '............................................................', 0, 0, 'C');
            $this->Cell(47,  0, '............................................................', 0,  0, 'C');
            $this->Cell(47,  0, '............................................................', 0,  0, 'C');
            $this->Cell(48,  0, '............................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(48,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(47,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(47,  6, 'Nombre(s)', '', 0, 'C');
            $this->Cell(48,  6, 'Firma', 'R', 1, 'C');
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LRB', 1);
        }

        function AnexoDObjetos($objeto1 = NULL, $num_objeto1 = 0, $objeto2 = NULL, $num_objeto2 = 0)
        {
            $this->SetFont('Arial','B',8);
            $this->Cell(3,   4);
            $this->Ln(2);
            $this->Cell(190, 4, utf8_decode('ANEXO D. INVENTARIO DE ARMAS Y OBJETOS'), 0, 1, 'C');
            $this->SetFont('Arial','B',6);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, utf8_decode('Llene tantas veces como sea necesario este Anexo'), 0, 1);
            $this->Cell(3,   3);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(190, 3, utf8_decode('Apartado D.3 Registro de objetos recolectados y/o asegurados relacionados con el hecho probablemente delictivo'), 'LTRB', 1, '', true);


            $this->Objeto($objeto1, $num_objeto1);
            $this->Objeto($objeto2, $num_objeto2);

            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   3);
            $this->Cell(190, 3, utf8_decode('Apartado D.4 Datos del primer respondiente que realizó la recolección y/o aseguramiento del o los objetos, sólo si es diferente a'), 'LTR', 1, '', true);
            $this->Cell(3,   3);
            $this->Cell(190, 3, utf8_decode('quien firmó la puesta a disposición'), 'LRB', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->SetFillColor(196, 189, 151);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(64,  4, (isset($objeto1->Ap_Paterno_PR)) ? utf8_decode(strtoupper($objeto1->Ap_Paterno_PR)) : '', 'L', 0, 'C');
            $this->Cell(63,  4, (isset($objeto1->Ap_Materno_PR)) ? utf8_decode(strtoupper($objeto1->Ap_Materno_PR)) : '', 0,  0, 'C');
            $this->Cell(63,  4, (isset($objeto1->Nombre_PR)) ? utf8_decode(strtoupper($objeto1->Nombre_PR)) : '', 'R', 1, 'C');
            $this->Cell(67,  0, '..................................................................................', 0, 0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0,  0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(64,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(63,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(63,  6, 'Nombre(s)', 'R', 1, 'C');
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(17,  4, utf8_decode('Adscripción:'));
            $this->Cell(47,  4, (isset($objeto1->Institucion)) ? utf8_decode(strtoupper($objeto1->Institucion)) : '');
            $this->Cell(15,  4, 'Cargo/grado:');
            $this->Cell(48,  4, (isset($objeto1->Cargo)) ? utf8_decode(strtoupper($objeto1->Cargo)) : '');
            $this->Cell(58,  4, 'Firma:', 'R', 1);
            $this->Cell(91,  0, '................................................................', 0, 0, 'C');
            $this->Cell(33,  0, '........................................................', 0,  0, 'C');
            $this->Cell(78,  0, '..............................................................................', 0, 1, 'C');
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LRB', 1);
            $this->Cell(3,   4);
            $this->SetFont('Arial','B',6);
            $this->Cell(190, 4, utf8_decode('Nota: Este Anexo no sustituye la Cadena de Custodia, la cual deberá ser debidamente requisitada.'));
        }

        function Objeto($objeto = NULL, $num_objeto = 0)
        {
            $numObjeto = [0,0,0];
            if($num_objeto>0){
                $num_objeto = strrev(strval($num_objeto));
                for($i=0; $i<strlen($num_objeto); $i++)
                    $numObjeto[$i] = intval($num_objeto[$i]);
                $numObjeto = array_reverse($numObjeto);
            }
            $this->SetFont('Arial','',7);
            $this->SetFillColor(196, 189, 151);
            $this->SetFont('Arial','B',7);
            $this->SetTextColor(0,0,0);
            if($objeto == NULL) $this->Line($this->GetX()+3,$this->GetY(),$this->GetX()+193,$this->GetY()+130);
            $this->Cell(3,   4);
            $this->Cell(12,  4, utf8_decode('Objeto:'), 'LTB', 0, '', true);
            foreach($numObjeto as $numObj){
                $this->Cell(4,   4, ($num_objeto != 0) ? $numObj : '', 'LTRB', 0, '', true);
            }
            $this->Cell(1,   4, '',  'LTB',   0, '', true);
            $this->SetFont('Arial','',7);
            $this->Cell(55,  4, '(001, 002,..., 010,...,)', 'TB', 0, '', true);
            $this->Cell(110, 4, '', 'TRB', 1, '', true);
            $this->Cell(3,   1);
            $this->Cell(190, 1, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('¿Qué encontró? (apariencia de):'), 'LR', 1);
            $this->Cell(3,   1);
            $this->Cell(190, 1, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(13,  4, utf8_decode('Narcótico'));
            $this->Cell(4,   4, (isset($objeto->Apariencia) && $objeto->Apariencia == 'Narcótico') ? 'X' : '', 'LTRB');
            $this->Cell(15,  4);
            $this->Cell(16,  4, 'Hidrocarburo');
            $this->Cell(4,   4, (isset($objeto->Apariencia) && $objeto->Apariencia == 'Hidrocarburo') ? 'X' : '', 'LTRB');
            $this->Cell(10,  4);
            $this->Cell(14,  4, 'Numerario');
            $this->Cell(4,   4, (isset($objeto->Apariencia) && $objeto->Apariencia == 'Numerario') ? 'X' : '', 'LTRB');
            $this->Cell(10,  4);
            $this->Cell(10,  4, 'Otro:');
            $this->Cell(85,  4, (isset($objeto->Apariencia) && $objeto->Apariencia != 'Narcótico' && $objeto->Apariencia != 'Hidrocarburo' && $objeto->Apariencia != 'Numerario') ? utf8_decode(strtoupper($objeto->Apariencia)) : '', 'R', 1);
            $this->Cell(106, 0);
            $this->Cell(63,  0, '.................................................................................................................', '', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LRB', 1);
            $this->Cell(3,   1);
            $this->Cell(190, 1, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Seleccione con una "X" si se trata de aportación o inspección, según corresponda.'), 'LR', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(10,  4, utf8_decode('Aportación'));
            $this->Cell(20,  4);
            $this->Cell(4,   4, (isset($objeto->Aportacion) && $objeto->Aportacion == '1') ? 'X' : '', 'LTRB');
            $this->Cell(151, 4, '', 'R', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(185, 4, utf8_decode('Inspección:'), 'R', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(25,  4, '', 'L');
            $this->Cell(10,  4, 'Lugar');
            $this->Cell(4,   4, (isset($objeto->Inspeccion) && $objeto->Inspeccion == 'Lugar') ? 'X' : '', 'LTRB');
            $this->Cell(10,  4);
            $this->Cell(13,  4, 'Persona');
            $this->Cell(4,   4, (isset($objeto->Inspeccion) && $objeto->Inspeccion == 'Persona') ? 'X' : '', 'LTRB');
            $this->Cell(10,  4);
            $this->Cell(13,  4, utf8_decode('Vehículo'));
            $this->Cell(4,   4, (isset($objeto->Inspeccion) && $objeto->Inspeccion == 'Vehiculo') ? 'X' : '', 'LTRB');
            $this->Cell(97,  4, '', 'R', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->MultiCell(190,  4, (isset($objeto->Ubicacion_Objeto)) ? utf8_decode('¿Dónde se encontró el objeto? '.strtoupper($objeto->Ubicacion_Objeto)) : utf8_decode('¿Dónde se encontró el objeto?'), 'LR',1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LRB', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Breve descripción del objeto:'), 'LR',1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->MultiCell(190, 4, (isset($objeto->Descripcion_Objeto)) ? utf8_decode(strtoupper($objeto->Descripcion_Objeto)) : '', 'LR', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Destino que se le dio:'), 'LR',1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->MultiCell(190, 4, (isset($objeto->Destino)) ? utf8_decode(strtoupper($objeto->Destino)) : '', 'LR', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Anote el nombre y firma de la persona a la que se le aseguró el objeto:'), 'LRT', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(48,  4, (isset($objeto->Ap_Paterno_A)) ? utf8_decode(strtoupper($objeto->Ap_Paterno_A)) : '', 'L', 0, 'C');
            $this->Cell(47,  4, (isset($objeto->Ap_Materno_A)) ? utf8_decode(strtoupper($objeto->Ap_Materno_A)) : '', 0,  0, 'C');
            $this->Cell(47,  4, (isset($objeto->Nombre_A)) ? utf8_decode(strtoupper($objeto->Nombre_A)) : '', '', 0, 'C');
            $this->Cell(48,  4, '', 'R', 1, 'C');
            $this->Cell(51,  0, '............................................................', 0, 0, 'C');
            $this->Cell(47,  0, '............................................................', 0,  0, 'C');
            $this->Cell(47,  0, '............................................................', 0,  0, 'C');
            $this->Cell(48,  0, '............................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(48,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(47,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(47,  6, 'Nombre(s)', '', 0, 'C');
            $this->Cell(48,  6, 'Firma', 'R', 1, 'C');
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LRB', 1);
            $this->Cell(3,   1);
            $this->Cell(190, 1, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('En caso de que la persona a la que se le aseguró el objeto no acceda a firmar, anote nombre y firma de dos testigos:'), 'LR', 1);
            $this->Cell(3,   2);
            isset($objeto->Testigos) ? $testigos = explode('|||',$objeto->Testigos) : $testigos = array();
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(48,  4, (isset($testigos[0])) ? utf8_decode(strtoupper((explode(',', $testigos[0]))[1])) : '', 'L', 0, 'C');
            $this->Cell(47,  4, (isset($testigos[0])) ? utf8_decode(strtoupper((explode(',', $testigos[0]))[2])) : '', 0,  0, 'C');
            $this->Cell(47,  4, (isset($testigos[0])) ? utf8_decode(strtoupper((explode(',', $testigos[0]))[0])) : '', '', 0, 'C');
            $this->Cell(48,  4, '', 'R', 1, 'C');
            $this->Cell(51,  0, '............................................................', 0, 0, 'C');
            $this->Cell(47,  0, '............................................................', 0,  0, 'C');
            $this->Cell(47,  0, '............................................................', 0,  0, 'C');
            $this->Cell(48,  0, '............................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(48,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(47,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(47,  6, 'Nombre(s)', '', 0, 'C');
            $this->Cell(48,  6, 'Firma', 'R', 1, 'C');
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(48,  4, (isset($testigos[1])) ? utf8_decode(strtoupper((explode(',', $testigos[1]))[1])) : '', 'L', 0, 'C');
            $this->Cell(47,  4, (isset($testigos[1])) ? utf8_decode(strtoupper((explode(',', $testigos[1]))[2])) : '', 0,  0, 'C');
            $this->Cell(47,  4, (isset($testigos[1])) ? utf8_decode(strtoupper((explode(',', $testigos[1]))[0])) : '', '', 0, 'C');
            $this->Cell(48,  4, '', 'R', 1, 'C');
            $this->Cell(51,  0, '............................................................', 0, 0, 'C');
            $this->Cell(47,  0, '............................................................', 0,  0, 'C');
            $this->Cell(47,  0, '............................................................', 0,  0, 'C');
            $this->Cell(48,  0, '............................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(48,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(47,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(47,  6, 'Nombre(s)', '', 0, 'C');
            $this->Cell(48,  6, 'Firma', 'R', 1, 'C');
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LRB', 1);
        }
        
        function AnexoE($data)
        {
            if($data['AnexosE']){
                $entrevistas = $data['AnexosE'];
                foreach($entrevistas as $key=>$entrevista){
                    $this->AddPage('P', 'Legal');
                    $this->AnexoEPag1($entrevista, $key+1);
                    $this->AddPage('P', 'Legal');
                    $this->AnexoEPag2($entrevista, $key+1);
                }
            }else{
                $this->AddPage('P', 'Legal');
                $this->AnexoEPag1();
                $this->AddPage('P', 'Legal');
                $this->AnexoEPag2();
            }
        }

        function AnexoEPag1($entrevista = NULL, $num_entrevista = 0)
        {
            $numEntrevista = [0,0,0];
            if($num_entrevista>0){
                $num_entrevista = strrev(strval($num_entrevista));
                for($i=0; $i<strlen($num_entrevista); $i++)
                    $numEntrevista[$i] = intval($num_entrevista[$i]);
                $numEntrevista = array_reverse($numEntrevista);
            }
            $this->SetFont('Arial','B',8);
            $this->Ln(2);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('ANEXO E. ENTREVISTAS'), 0, 1, 'C');
            $this->SetFont('Arial','B',7);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, utf8_decode('Llene este Anexo por cada persona entrevistada.'), 0, 1);
            $this->Cell(3,   5);
            $this->SetFillColor(196, 189, 151);
            $this->SetFont('Arial','B',7);
            if($entrevista == NULL) $this->Line($this->GetX(),$this->GetY(),$this->GetX()+190,$this->GetY()+203);
            $this->Cell(30,  5, utf8_decode('Persona entrevistada:'), 'LT', 0, '', true);
            foreach($numEntrevista as $numEnt){
                $this->Cell(4,   5, ($num_entrevista != 0) ? $numEnt : '', 'LTRB', 0, '', true);
            }
            $this->Cell(1,   5, '',  'LT',   0, '', true);
            $this->SetFont('Arial','',7);
            $this->Cell(60,  5, '(001, 002,..., 010,...,)', 'T', 0, '', true);
            $this->SetFont('Arial','B',7);
            $this->Cell(40,  5, utf8_decode('¿Desea reservar sus datos?'), 'T', 0, '', true);
            $this->Cell(5,  5, utf8_decode('Sí'), 'T', 0, '', true);
            $this->Cell(4,  5, (isset($entrevista->Reservar_Datos) && $entrevista->Reservar_Datos == '1') ? 'X' : '', 'TRL', 0, '', true);
            $this->Cell(10,  5, '', 'TL', 0, '', true);
            $this->Cell(5,  5, 'No', 'T', 0, '', true);
            $this->Cell(4,  5, (isset($entrevista->Reservar_Datos) && $entrevista->Reservar_Datos == '0') ? 'X' : '', 'TRL', 0, '', true);
            $this->Cell(19,  5, '', 'TRL', 1, '', true);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado E.1 Fecha y hora del lugar de la entrevista'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Indique la fecha y la hora en que realizó la detención'), 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            if(isset($entrevista->Fecha_Hora)){
                $fechaDetencion = str_split(implode(array_reverse(explode('-',(explode(' ', $entrevista->Fecha_Hora))[0]))));
                $horaDetencion = str_replace(':', '', (explode(' ', $entrevista->Fecha_Hora))[1]);
            }else{
                $fechaDetencion = array();
                $horaDetencion = array();
            }
            $this->Cell(10,  4, 'Fecha:');
            for($i=0;$i<8;$i++){
                $this->Cell(4,   4, (isset($fechaDetencion[$i])) ? $fechaDetencion[$i] : '', 'LRB');
            }
            $this->Cell(25,  4);
            $this->Cell(10,  4, 'Hora:');
            $this->Cell(4,   4, (isset($horaDetencion[0])) ? $horaDetencion[0] : '', 'LRB');
            $this->Cell(4,   4, (isset($horaDetencion[1])) ? $horaDetencion[1] : '', 'RB');
            $this->Cell(4,   4, ':', 0, 0, 'C');
            $this->Cell(4,   4, (isset($horaDetencion[2])) ? $horaDetencion[2] : '', 'LRB');
            $this->Cell(4,   4, (isset($horaDetencion[3])) ? $horaDetencion[3] : '', 'RB');
            $this->Cell(88,  4, '(24 horas)', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(15,  4, '', 'L');
            $this->Cell(4,   4, 'D');
            $this->Cell(4,   4, 'D');
            $this->Cell(4,   4, 'M');
            $this->Cell(4,   4, 'M');
            $this->Cell(4,   4, 'A');
            $this->Cell(4,   4, 'A');
            $this->Cell(4,   4, 'A');
            $this->Cell(4,   4, 'A');
            $this->Cell(35,  4);
            $this->Cell(4,   4, 'h');
            $this->Cell(4,   4, 'h');
            $this->Cell(4,   4);
            $this->Cell(4,   4, 'm');
            $this->Cell(92,  4, 'm', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LRB', 1);
            $this->Cell(3,   5);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(190, 5, utf8_decode('Apartado E.2 Datos generales'), 'LTRB', 1, '', true);
            $this->Cell(3,   3);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(64,  4, (isset($entrevista->Ap_Paterno_Ent)) ? utf8_decode(strtoupper($entrevista->Ap_Paterno_Ent)) : '', 'L', 0, 'C');
            $this->Cell(63,  4, (isset($entrevista->Ap_Materno_Ent)) ? utf8_decode(strtoupper($entrevista->Ap_Materno_Ent)) : '', 0,  0, 'C');
            $this->Cell(63,  4, (isset($entrevista->Nombre_Ent)) ? utf8_decode(strtoupper($entrevista->Nombre_Ent)) : '', 'R', 1, 'C');
            $this->Cell(67,  0, '..................................................................................', 0, 0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0,  0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(64,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(63,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(63,  6, 'Nombre(s)', 'R', 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LRB', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Indique según corresponda'), 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(25,  4, 'Calidad:');
            $this->Cell(25,  4, utf8_decode("Víctima u ofendido"));
            $this->Cell(4,   4, (isset($entrevista->Calidad) && $entrevista->Calidad == 'Víctima u ofendido') ? 'X' : '', 'LTRB');
            $this->Cell(30,  4);
            $this->Cell(18,  4, 'Denunciante');
            $this->Cell(4,   4, (isset($entrevista->Calidad) && $entrevista->Calidad == 'Denunciante') ? 'X' : '', 'LTRB');
            $this->Cell(30,  4);
            $this->Cell(11,  4, 'Testigo');
            $this->Cell(4,   4, (isset($entrevista->Calidad) && $entrevista->Calidad == 'Testigo') ? 'X' : '', 'LTRB');
            $this->Cell(34,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(35,  4, 'Nacionalidad:');
            $this->Cell(15,  4, 'Mexicana');
            $this->Cell(4,   4, (isset($entrevista->Nacionalidad) && $entrevista->Nacionalidad == 'MEXICANA') ? 'X' : '', 'LTRB');
            $this->Cell(33,  4);
            $this->Cell(15,  4, 'Extranjera');
            $this->Cell(4,   4, (isset($entrevista->Nacionalidad) && $entrevista->Nacionalidad != 'MEXICANA') ? 'X' : '', 'LTRB');
            $this->Cell(5,   4);
            $this->Cell(74,  4, (isset($entrevista->Nacionalidad) && $entrevista->Nacionalidad != 'MEXICANA') ? utf8_decode(strtoupper('¿Cuál? '.$entrevista->Nacionalidad)) : utf8_decode('¿Cuál?'), 'R', 1);
            $this->Cell(129, 0);
            $this->Cell(20,  0, '...........................................................................', '', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(10,  4, 'Sexo:');
            $this->Cell(10,  4, 'Mujer');
            $this->Cell(4,   4, (isset($entrevista->Genero) && $entrevista->Genero == 'M') ? 'X' : '', 'LTRB');
            $this->Cell(10,  4);
            $this->Cell(13,  4, 'Hombre');
            $this->Cell(4,   4, (isset($entrevista->Genero) && $entrevista->Genero == 'H') ? 'X' : '', 'LTRB');
            $this->Cell(20,  4);
            (isset($entrevista->Fecha_Nacimiento)) ? $fechaNacimiento = str_split(implode(array_reverse(explode('-',$entrevista->Fecha_Nacimiento)))) : $fechaNacimiento = array();
            $this->Cell(28,  4, 'Fecha de nacimiento:');
            for($i=0;$i<8;$i++){
                $this->Cell(4,   4, (isset($fechaNacimiento[$i])) ? $fechaNacimiento[$i] : '', 'LRB');
            }
            $this->Cell(10,  4);
            $this->Cell(10,  4, 'Edad:');
            $this->Cell(4,   4, (isset($entrevista->Edad) && isset(str_split($entrevista->Edad)[0])) ? str_split($entrevista->Edad)[0] : '', 'LRB');
            $this->Cell(4,   4, (isset($entrevista->Edad) && isset(str_split($entrevista->Edad)[1])) ? str_split($entrevista->Edad)[1] : '', 'RB');
            $this->Cell(26,  4, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(104, 4, '', 'L');
            $this->Cell(4,   4, 'D');
            $this->Cell(4,   4, 'D');
            $this->Cell(4,   4, 'M');
            $this->Cell(4,   4, 'M');
            $this->Cell(4,   4, 'A');
            $this->Cell(4,   4, 'A');
            $this->Cell(4,   4, 'A');
            $this->Cell(4,   4, 'A');
            $this->Cell(54,  4, '', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(55,  4, utf8_decode('¿Se identificó con algún documento?'));
            $this->Cell(20,  4, 'Credencial INE');
            $this->Cell(4,   4, (isset($entrevista->Identificacion) && $entrevista->Identificacion == 'Credencial INE') ? 'X' : '', 'LTRB');
            $this->Cell(10,  4);
            $this->Cell(12,  4, 'Licencia');
            $this->Cell(4,   4, (isset($entrevista->Identificacion) && $entrevista->Identificacion == 'Licencia') ? 'X' : '', 'LTRB');
            $this->Cell(10,  4);
            $this->Cell(14,  4, 'Pasaporte');
            $this->Cell(4,   4, (isset($entrevista->Identificacion) && $entrevista->Identificacion == 'Pasaporte') ? 'X' : '', 'LTRB');
            $this->Cell(8,   4);
            $this->Cell(27,  4, (isset($entrevista->Identificacion) && $entrevista->Identificacion != 'Credencial INE' && $entrevista->Identificacion != 'Licencia' && $entrevista->Identificacion != 'Pasaporte' && $entrevista->Identificacion != 'No') ? 'Otro: '.utf8_decode(strtoupper($entrevista->Identificacion)) : 'Otro:');
            $this->Cell(5,   4, 'No');
            $this->Cell(4,   4, (isset($entrevista->Identificacion) && $entrevista->Identificacion == 'No') ? 'X' : '', 'LTRB');
            $this->Cell(8,   4, '', 'R', 1);
            $this->Cell(156, 0);
            $this->Cell(40,  0, '........................', '', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(30,  4, utf8_decode('No. de identificación'));
            (isset($entrevista->Num_Identificacion)) ? $numIdentificacion = str_split($entrevista->Num_Identificacion): $numIdentificacion = array();
            for($i=0; $i<23; $i++){
                $this->Cell(4,   4, (isset($numIdentificacion[$i])) ? utf8_decode(strtoupper($numIdentificacion[$i])) : '', 'LRB');
            }
            $this->Cell(63,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            (isset($entrevista->Telefono)) ? $numTel = str_split($entrevista->Telefono) : $numTel = array();
            $this->Cell(20,  4, utf8_decode('No. telefónico'));
            for($i=0; $i<10; $i++){
                $this->Cell(4,   4, (isset($numTel[$i])) ? $numTel[$i] : '', 'LRB');
            }
            $this->Cell(20,  4);
            $this->Cell(10,  4, utf8_decode('Correo electrónico:'));
            $this->Cell(95,  4, (isset($entrevista->Correo)) ? $entrevista->Correo : '', 'R', 1);
            $this->Cell(111, 0);
            $this->Cell(40,  0, '...........................................................................................................', '', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LRB', 1);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(196, 189, 151);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Domicilio de la persona entrevistada '), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(35, 4, 'Calle/Tramo carretero:');
            $this->Cell(150, 4, (isset($entrevista->Calle_Dom)) ? utf8_decode(strtoupper($entrevista->Calle_Dom)) : '', 'R', 1);
            $this->Cell(43,  0);
            $this->Cell(64,  0, '...............................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(15,  4, 'No. exterior:');
            $this->Cell(43,  4, (isset($entrevista->No_Ext_Dom)) ? utf8_decode(strtoupper($entrevista->No_Ext_Dom)) : '');
            $this->Cell(17,  4, 'No. interior:');
            $this->Cell(42,  4, (isset($entrevista->No_Int_Dom)) ? utf8_decode(strtoupper($entrevista->No_Int_Dom)) : '');
            $this->Cell(18,  4, utf8_decode('Código Postal:'));
            $this->Cell(40,  4, (isset($entrevista->CP_Dom)) ? $entrevista->CP_Dom : '');
            $this->Cell(10,  4, '', 'R', 1);
            $this->Cell(23,  0);
            $this->Cell(40,  0, '............................................................');
            $this->Cell(20,  0);
            $this->Cell(40,  0, '............................................................');
            $this->Cell(20,  0);
            $this->Cell(40,  0, '.............................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(35,  4, 'Colonia/Localidad:');
            $this->Cell(150, 4, (isset($entrevista->Colonia_Dom)) ? utf8_decode(strtoupper($entrevista->Colonia_Dom)) : '', 'R', 1);
            $this->Cell(43,  0);
            $this->Cell(64,  0, '...............................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(35, 4, utf8_decode('Municipio/Demarcación:'));
            $this->Cell(150, 4, (isset($entrevista->Municipio_Dom)) ? utf8_decode(strtoupper($entrevista->Municipio_Dom)) : '', 'R', 1);
            $this->Cell(43,  0);
            $this->Cell(64,  0, '...............................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(21,  3, '', 'L');
            $this->Cell(169, 3, 'territorial:', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(35, 4, 'Entidad federativa:');
            $this->Cell(150, 4, (isset($entrevista->Estado_Dom)) ? utf8_decode(strtoupper($entrevista->Estado_Dom)) : '', 'R', 1);
            $this->Cell(43,  0);
            $this->Cell(64,  0, '...............................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(35, 4, 'Referencias:');
            $this->Cell(150, 4, (isset($entrevista->Referencias_Dom)) ? utf8_decode(strtoupper($entrevista->Referencias_Dom)) : '', 'R', 1);
            $this->Cell(43,  0);
            $this->Cell(64,  0, '...............................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Comunique al entrevistado la facultad de abstención que le otorga el artículo 361 del Código Nacional de Procedimientos Penales'), 'LR', 1);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LRB', 1);
            $this->Cell(3,   5);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(190, 5, utf8_decode('Apartado E.3 Relato de la entrevista'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);            
            $this->Cell(3,   4);
            // $this->MultiCell(190, 4, (isset($entrevista->Relato_Entrevista)) ? utf8_decode(strtoupper($entrevista->Relato_Entrevista)) : '', 'LR', 1);
            $this->MultiCell(190, 4, (isset($entrevista->Relato_Entrevista)) ? utf8_decode(strtoupper($entrevista->Relato_Entrevista)) : '','LR','J');

            $this->Cell(3,   15);
            $this->Cell(190, 15, '', 'LR', 1);            
            $this->Cell(8,   0, '', 'L');
            $this->Cell(185, 0, '.................................................................................................................................', 'R', 1, 'C');
            $this->Cell(3,   1);
            $this->Cell(190, 1, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(185, 4, 'Firma/Huella de la persona entrevistada', 'R', 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->SetFont('Arial','',6);
            $this->Cell(55, 4, utf8_decode('De ser el caso continúe la narración de la entrevista en el'), 'L');
            $this->SetFont('Arial','B',6);
            $this->Cell(135, 4, utf8_decode('Anexo G.'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
        }
        function AnexoEPag2($entrevista = NULL, $num_entrevista = 0)
        {
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            if($entrevista == NULL) $this->Line($this->GetX(),$this->GetY(),$this->GetX()+190,$this->GetY()+139);
            $this->Cell(190, 5, utf8_decode('Apartado E.4 Datos del lugar del traslado o canalización de la persona entrevistada'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(65,  4, utf8_decode('¿Trasladó o canalizó a la persona entrevistada?'));
            $this->Cell(5,   4, utf8_decode('Sí'));
            $this->Cell(4,   4, (isset($entrevista->Canalizacion) && $entrevista->Canalizacion == '1') ? 'X' : '', 'LTRB');
            $this->Cell(15,  4);
            $this->Cell(5,   4, utf8_decode('No'));
            $this->Cell(4,   4, (isset($entrevista->Canalizacion) && $entrevista->Canalizacion == '0') ? 'X' : '', 'LTRB');
            $this->Cell(87,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(49,  4, utf8_decode('Lugar de traslado o canalización:'));
            $this->Cell(21,  4, utf8_decode('Fiscalía/Agencia'));
            $this->Cell(4,   4, (isset($entrevista->Lugar_Canalizacion) && $entrevista->Lugar_Canalizacion == 'Fiscalía/Agencia') ? 'X' : '', 'LTRB');
            $this->Cell(9,  4);
            $this->Cell(11,  4, utf8_decode('Hospital'));
            $this->Cell(4,   4, (isset($entrevista->Lugar_Canalizacion) && $entrevista->Lugar_Canalizacion == 'Hospital') ? 'X' : '', 'LTRB');
            $this->Cell(15,  4);
            $this->Cell(22,  4, utf8_decode('Otra dependencia'));
            $this->Cell(4,   4, (isset($entrevista->Lugar_Canalizacion) && $entrevista->Lugar_Canalizacion == 'Otra dependencia') ? 'X' : '', 'LTRB');
            $this->Cell(46,  4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(185, 4, (isset($entrevista->Descripcion_Canalizacion))  ? utf8_decode('¿Cuál? '.strtoupper($entrevista->Descripcion_Canalizacion)) : utf8_decode('¿Cuál?'), 'R', 1);
            $this->Cell(18,  0);
            $this->Cell(64,  0, '.......................................................................................................................................................................................................................................................', 0, 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LRB', 1);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado E.5 Constancia de lectura de derechos, SÓLO en caso de víctima u ofendido'), 'LTRB', 1, '', true);
            $this->SetTextColor(0,0,0);
            $this->SetFillColor(196, 189, 151);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LTR', 1, '', true);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Artículo 20 apartado C de la Constitución Política de los Estados Unidos Mexicanos y artículos 109 del Código Nacional de Procedimientos Penales y '), 'LR', 1, '', true);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('7 de la Ley General de Víctimas.'), 'LR', 1, '', true);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LRB', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Indique a la víctima u ofendido que tiene derecho a:'), 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '1.');
            $this->Cell(180, 4, utf8_decode('Recibir asesoría jurídica; ser informado de los derechos que en su favor establece la Constitución y, cuando lo solicite, ser'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(10,  4, '', 'L');
            $this->Cell(180, 4, utf8_decode('informado del desarrollo del procedimiento penal. '), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '2.');
            $this->Cell(180, 4, utf8_decode('Recibir desde la comisión del delito, atención médica y psicológica de urgencia.'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '3.');
            $this->Cell(180, 4, utf8_decode('Comunicarse inmediatamente después de haberse cometido el delito con un familiar, incluso con su asesor jurídico.'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '4.');
            $this->Cell(180, 4, utf8_decode('Ser tratado con respeto y dignidad.'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '5.');
            $this->Cell(180, 4, utf8_decode('Contar con un asesor jurídico gratuito en cualquier etapa del procedimiento, en los términos de la legislación aplicable.'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '6.');
            $this->Cell(180, 4, utf8_decode('Acceder a la justicia de manera pronta, gratuita e imparcial respecto de sus denuncias o querellas.'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '7.');
            $this->Cell(180, 4, utf8_decode('Recibir gratuitamente la asistencia de un intérprete o traductor.'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '8.');
            $this->Cell(180, 4, utf8_decode('Que se le proporcione asistencia migratoria cuando tenga otra nacionalidad.'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(5,   4, '9.');
            $this->Cell(180, 4, utf8_decode(' Que se resguarde su identidad y datos personales, en los términos que establece la ley.'), 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(185, 4, '', 'R', 1, 'C');
            $this->Cell(8,   0, '', 'L');
            $this->Cell(185, 0, '.................................................................................................................................', 'R', 1, 'C');
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(185, 4, 'Firma/Huella de la persona entrevistada', 'R', 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LRB', 1);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado E.6 Datos del primer respondiente que realizó la entrevista, sólo si es diferente a quien firmó la puesta a disposición'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(64,  4, (isset($entrevista->Ap_Paterno_PR)) ? utf8_decode(strtoupper($entrevista->Ap_Paterno_PR)) : '', 'L', 0, 'C');
            $this->Cell(63,  4, (isset($entrevista->Ap_Materno_PR)) ? utf8_decode(strtoupper($entrevista->Ap_Materno_PR)) : '', 0,  0, 'C');
            $this->Cell(63,  4, (isset($entrevista->Nombre_PR)) ? utf8_decode(strtoupper($entrevista->Nombre_PR)) : '', 'R', 1, 'C');
            $this->Cell(67,  0, '..................................................................................', 0, 0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0,  0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(64,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(63,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(63,  6, 'Nombre(s)', 'R', 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(17,  4, utf8_decode('Adscripción:'));
            $this->Cell(47,  4, (isset($entrevista->Institucion_PR)) ? utf8_decode(strtoupper($entrevista->Institucion_PR)) : '');
            $this->Cell(15,  4, 'Cargo/grado:');
            $this->Cell(48,  4, (isset($entrevista->Cargo_PR)) ? utf8_decode(strtoupper($entrevista->Cargo_PR)) : '');
            $this->Cell(58,  4, 'Firma:', 'R', 1);
            $this->Cell(91,  0, '................................................................', 0, 0, 'C');
            $this->Cell(33,  0, '........................................................', 0,  0, 'C');
            $this->Cell(78,  0, '..............................................................................', 0, 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LRB', 1);
        }

        function AnexoF($data)
        {
            if($data['AnexosF']){
                $lugar = $data['AnexosF']['lugar'];
                $entrega = $data['AnexosF']['persona_Entrega'];
                $recibe = $data['AnexosF']['persona_Recibe'];
                $this->AddPage('P', 'Legal');
                $this->AnexoFPag1($lugar, $entrega, $recibe);
            }else{
                $this->AddPage('P', 'Legal');
                $this->AnexoFPag1();
            }
        }

        function AnexoFPag1($lugar = NULL, $entrega = NULL, $recibe = NULL)
        {
            $this->SetFont('Arial','B',8);
            $this->Ln(2);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('ANEXO F. ENTREGA - RECEPCIÓN DEL LUGAR DE LA INTERVENCIÓN'), 0, 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 0, 1);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            if($lugar == NULL) $this->Line($this->GetX(),$this->GetY(),$this->GetX()+190,$this->GetY()+215);
            $this->Cell(190, 5, utf8_decode('Apartado F.1 Preservación del lugar de la intervención'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   2);
            $this->Cell(190, 2, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Explique brevemente las acciones realizadas para la preservación del lugar de la intervención. (delimitacíon, acordonamiento, clausura en lugar cerrado, etc.)'), 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->MultiCell(190, 4, (isset($lugar->Descripcion_PL)) ? utf8_decode(strtoupper($lugar->Descripcion_PL)) : '', 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LRB', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(147, 4, utf8_decode('¿Solicitó apoyo de alguna autoridad o servicios especializados en el lugar de la intervención?'));
            $this->Cell(5,   4, utf8_decode('Sí'));
            $this->Cell(4,   4, (isset($lugar->Descripcion_Apoyo) && $lugar->Descripcion_Apoyo != '') ? 'X' : '', 'LTRB');
            $this->Cell(15,  4);
            $this->Cell(5,   4, utf8_decode('No'));
            $this->Cell(4,   4, (isset($lugar->Descripcion_Apoyo) && $lugar->Descripcion_Apoyo == '') ? 'X' : '', 'LTRB');
            $this->Cell(5,   4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->MultiCell(190, 4, (isset($lugar->Descripcion_Apoyo) && $lugar->Descripcion_Apoyo != '') ? utf8_decode('¿Cuál? '.strtoupper($lugar->Descripcion_Apoyo)) : utf8_decode('¿Cuál?'), 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LRB', 1);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado F.2 Acciones realizadas despúes de la preservación'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(147, 4, utf8_decode('Después de la preservación del lugar de la intervención, ¿Ingresó alguna persona al lugar?'));
            $this->Cell(5,   4, utf8_decode('Sí'));
            $this->Cell(4,   4, (isset($lugar->Motivo_Ingreso) && $lugar->Motivo_Ingreso != '') ? 'X' : '', 'LTRB');
            $this->Cell(15,  4);
            $this->Cell(5,   4, utf8_decode('No'));
            $this->Cell(4,   4, (isset($lugar->Motivo_Ingreso) && $lugar->Motivo_Ingreso == '') ? 'X' : '', 'LTRB');
            $this->Cell(5,   4, '', 'R', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->MultiCell(190, 4, (isset($lugar->Motivo_Ingreso) && $lugar->Motivo_Ingreso != '') ? utf8_decode('Motivo del ingreso: '.strtoupper($lugar->Motivo_Ingreso)) : utf8_decode('Motivo del ingreso:'), 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LRB', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            isset($lugar->personalIntervencion) ? $personal = explode('|||',$lugar->personalIntervencion) : $personal = array();
            $this->Cell(190, 4, utf8_decode('Datos del personal que ingresó al lugar de la intervención.'), 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(64,  4, (isset($personal[0])) ? utf8_decode(strtoupper((explode(',', $personal[0]))[1])) : '', 'L', 0, 'C');
            $this->Cell(63,  4, (isset($personal[0])) ? utf8_decode(strtoupper((explode(',', $personal[0]))[2])) : '', 0,  0, 'C');
            $this->Cell(63,  4, (isset($personal[0])) ? utf8_decode(strtoupper((explode(',', $personal[0]))[0])) : '', 'R', 1, 'C');
            $this->Cell(67,  0, '..................................................................................', 0, 0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0,  0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(64,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(63,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(63,  6, 'Nombre(s)', 'R', 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(15,  4, 'Cargo/grado:');
            $this->Cell(75,  4, (isset($personal[0])) ? utf8_decode(strtoupper((explode(',', $personal[0]))[3])) : '');
            $this->Cell(15,  4, utf8_decode('Institución:'));
            $this->Cell(80,  4, (isset($personal[0])) ? utf8_decode(strtoupper((explode(',', $personal[0]))[4])) : '', 'R', 1);
            $this->Cell(112,  0, '..................................................................................................', 0, 0, 'C');
            $this->Cell(80,  0, '..............................................................................................................', 0, 1, 'C');
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(64,  4, (isset($personal[1])) ? utf8_decode(strtoupper((explode(',', $personal[1]))[1])) : '', 'L', 0, 'C');
            $this->Cell(63,  4, (isset($personal[1])) ? utf8_decode(strtoupper((explode(',', $personal[1]))[2])) : '', 0,  0, 'C');
            $this->Cell(63,  4, (isset($personal[1])) ? utf8_decode(strtoupper((explode(',', $personal[1]))[0])) : '', 'R', 1, 'C');
            $this->Cell(67,  0, '..................................................................................', 0, 0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0,  0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(64,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(63,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(63,  6, 'Nombre(s)', 'R', 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(15,  4, 'Cargo/grado:');
            $this->Cell(75,  4, (isset($personal[1])) ? utf8_decode(strtoupper((explode(',', $personal[1]))[3])) : '');
            $this->Cell(15,  4, utf8_decode('Institución:'));
            $this->Cell(80,  4, (isset($personal[1])) ? utf8_decode(strtoupper((explode(',', $personal[1]))[4])) : '', 'R', 1);
            $this->Cell(112,  0, '..................................................................................................', 0, 0, 'C');
            $this->Cell(80,  0, '..............................................................................................................', 0, 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LRB', 1);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado F.3 Entrega - recepción del lugar de la intervención'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Datos de la persona que entrega el lugar de la intervención.'), 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(64,  4, (isset($entrega->Ap_Paterno_PER)) ? utf8_decode(strtoupper($entrega->Ap_Paterno_PER)) : '', 'L', 0, 'C');
            $this->Cell(63,  4, (isset($entrega->Ap_Materno_PER)) ? utf8_decode(strtoupper($entrega->Ap_Materno_PER)) : '', 0,  0, 'C');
            $this->Cell(63,  4, (isset($entrega->Nombre_PER)) ? utf8_decode(strtoupper($entrega->Nombre_PER)) : '', 'R', 1, 'C');
            $this->Cell(67,  0, '..................................................................................', 0, 0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0,  0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(64,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(63,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(63,  6, 'Nombre(s)', 'R', 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(17,  4, utf8_decode('Adscripción:'));
            $this->Cell(47,  4, (isset($entrega->Institucion)) ? utf8_decode(strtoupper($entrega->Institucion)) : '');
            $this->Cell(16,  4, 'Cargo/grado:');
            $this->Cell(47,  4, (isset($entrega->Cargo)) ? utf8_decode(strtoupper($entrega->Cargo)) : '');
            $this->Cell(58,  4, 'Firma:', 'R', 1);
            $this->Cell(91,  0, '................................................................', 0, 0, 'C');
            $this->Cell(33,  0, '........................................................', 0,  0, 'C');
            $this->Cell(78,  0, '..............................................................................', 0, 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LRB', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, utf8_decode('Datos de la persona que recibe el lugar de la intervención.'), 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(64,  4, (isset($recibe->Ap_Paterno_PER)) ? utf8_decode(strtoupper($recibe->Ap_Paterno_PER)) : '', 'L', 0, 'C');
            $this->Cell(63,  4, (isset($recibe->Ap_Materno_PER)) ? utf8_decode(strtoupper($recibe->Ap_Materno_PER)) : '', 0,  0, 'C');
            $this->Cell(63,  4, (isset($recibe->Nombre_PER)) ? utf8_decode(strtoupper($recibe->Nombre_PER)) : '', 'R', 1, 'C');
            $this->Cell(67,  0, '..................................................................................', 0, 0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0,  0, 'C');
            $this->Cell(63,  0, '..................................................................................', 0, 1, 'C');
            $this->Cell(3,   6);
            $this->Cell(64,  6, 'Primer apellido', 'L', 0, 'C');
            $this->Cell(63,  6, 'Segundo apellido', 0,  0, 'C');
            $this->Cell(63,  6, 'Nombre(s)', 'R', 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(5,   4, '', 'L');
            $this->Cell(17,  4, utf8_decode('Adscripción:'));
            $this->Cell(47,  4, (isset($recibe->Institucion)) ? utf8_decode(strtoupper($recibe->Institucion)) : '');
            $this->Cell(16,  4, 'Cargo/grado:');
            $this->Cell(47,  4, (isset($recibe->Cargo)) ? utf8_decode(strtoupper($recibe->Cargo)) : '');
            $this->Cell(58,  4, 'Firma:', 'R', 1);
            $this->Cell(91,  0, '................................................................', 0, 0, 'C');
            $this->Cell(33,  0, '........................................................', 0,  0, 'C');
            $this->Cell(78,  0, '..............................................................................', 0, 1, 'C');
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LRB', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->MultiCell(190, 4, utf8_decode('Observaciones:'), 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LRB', 1);
            $this->SetFont('Arial','B',7);
            $this->SetFillColor(148, 138, 84);
            $this->SetTextColor(255,255,255);
            $this->Cell(3,   5);
            $this->Cell(190, 5, utf8_decode('Apartado F.4 Fecha y hora de la entrega - recepción del lugar de la intervención'), 'LTRB', 1, '', true);
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->Cell(3,   3);
            $this->Cell(190, 3, '', 'LR', 1);
            $this->Cell(3,   4);
            $this->Cell(40,   4, '', 'L');
            if(isset($lugar->Fecha_Hora_Recepcion)){
                $fechaRecepcion = str_split(implode(array_reverse(explode('-',(explode(' ', $lugar->Fecha_Hora_Recepcion))[0]))));
                $horaRecepcion = str_replace(':', '', (explode(' ', $lugar->Fecha_Hora_Recepcion))[1]);
            }else{
                $fechaRecepcion = array();
                $horaRecepcion = array();
            }
            $this->Cell(10,  4, 'Fecha:');
            for($i=0;$i<8;$i++){
                $this->Cell(4,   4, (isset($fechaRecepcion[$i])) ? $fechaRecepcion[$i] : '', 'LRB');
            }
            $this->Cell(25,  4);
            $this->Cell(10,  4, 'Hora:');
            $this->Cell(4,   4, (isset($horaRecepcion[0])) ? $horaRecepcion[0] : '', 'LRB');
            $this->Cell(4,   4, (isset($horaRecepcion[1])) ? $horaRecepcion[1] : '', 'RB');
            $this->Cell(4,   4, ':', 0, 0, 'C');
            $this->Cell(4,   4, (isset($horaRecepcion[2])) ? $horaRecepcion[2] : '', 'LRB');
            $this->Cell(4,   4, (isset($horaRecepcion[3])) ? $horaRecepcion[3] : '', 'RB');
            $this->Cell(53,  4, '(24 horas)', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(50,  4, '', 'L');
            $this->Cell(4,   4, 'D');
            $this->Cell(4,   4, 'D');
            $this->Cell(4,   4, 'M');
            $this->Cell(4,   4, 'M');
            $this->Cell(4,   4, 'A');
            $this->Cell(4,   4, 'A');
            $this->Cell(4,   4, 'A');
            $this->Cell(4,   4, 'A');
            $this->Cell(35,  4);
            $this->Cell(4,   4, 'h');
            $this->Cell(4,   4, 'h');
            $this->Cell(4,   4);
            $this->Cell(4,   4, 'm');
            $this->Cell(57,  4, 'm', 'R', 1);
            $this->Cell(3,   4);
            $this->Cell(190, 4, '', 'LRB', 1);
        }

        function Footer()
        {
            // Posición: a 1,5 cm del final
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',7);
            // Número de página
            $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'R');
        }

    }

    $pdf = new PDF();
    $pdf->AddFont('Avenir','','avenir.php');
    $pdf->AliasNbPages();
    $pdf->AddPage('P', 'Legal');
    $pdf->OnePage($data, base_url);
    $pdf->AddPage('P', 'Legal');
    $pdf->TwoPage($data, base_url);
    $pdf->AddPage('P', 'Legal');
    $pdf->ThreePage($data, base_url);
    $pdf->AddPage('P', 'Legal');
    $pdf->FourPage($data, base_url);
    $pdf->AnexoA($data);
    $pdf->AnexoB($data);
    $pdf->AnexoC($data);
    $pdf->AnexoD($data);
    $pdf->AnexoE($data);
    $pdf->AnexoF($data);
    $pdf->Output();
?>