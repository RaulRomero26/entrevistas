
<?php
header('Content-Type: text/html; charset=UTF-8');
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
$archivo = '../public/media/pdf/VEHICULO-VACIO.pdf';
$pdf = new Fpdi();
$pageCount = $pdf->setSourceFile($archivo);
$pageId = $pdf->importPage(1);
$pageId2 = $pdf->importPage(2);
/*Calcular tamaño de narrativa para saber cuantas paginas van a ser */
$pag=0;
if(strlen($data['vehiculo']->NARRATIVAS)>2970){
    $pag=ceil(strlen($data['vehiculo']->NARRATIVAS)/2970);
}
else{
    $pag=1;
}
$pag+=2;
$pag_actual=1;
$numero_de_paginas=0;
/*Primera pagina, primer renglon*/
$pdf->addPage();
$pdf->useImportedPage($pageId, 1, 1,207,295);
$pdf->SetFont('helvetica','',12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetY(14);
$pdf->SetX(170);
if($data['vehiculo']->NO_FICHA_V!=0){
    $pdf->Cell(5,5,$data['vehiculo']->NO_FICHA_V);
}
else{
    $pdf->SetY(20);
    $pdf->SetX(170);
    $pdf->Cell(5,5,$data['vehiculo']->NO_FICHA_R);
}
$pdf->SetY(25);
$pdf->SetX(170);
$pdf->Cell(5,5,$data['vehiculo']->ID_VEHICULO);
$pdf->SetY(70);
$pdf->SetX(20);
$pdf->Cell(5,5,$data['vehiculo']->ESTADO);
$pdf->SetX(53);
$pdf->Cell(5,5,$data['vehiculo']->MARCA);
$pdf->SetY(65);
$pdf->SetX(90);
$pdf->Multicell(30,5,$data['vehiculo']->SUBMARCA);
$pdf->SetY(70);
$pdf->SetX(130);
$pdf->Cell(5,5,$data['vehiculo']->MODELO);
$pdf->SetY(65);
$pdf->SetX(160);
$pdf->Multicell(30,5,$data['vehiculo']->COLOR);
$pdf->SetY(70);
$x_=60;
$y_=102;
$pdf->SetFont('helvetica','',10);
for($i=0;$i<count($data['placas']);$i++){
    switch($data['placas'][$i]->DESCRIPCION){
        case "ORIGINAL":
            $pdf->SetY($y_);
            $pdf->SetX($x_);
            $pdf->Multicell(18,5,$data['placas'][$i]->PLACA);
            $pdf->SetY($y_);
            $pdf->SetX($x_+18);
            $pdf->Multicell(40,5,$data['placas'][$i]->PROCEDENCIA);
            $pdf->SetY($y_);
            $pdf->SetX($x_);
            break;
        case "SOBREPUESTA":
            $pdf->SetY($y_+18);
            $pdf->SetX($x_);
            $pdf->Multicell(18,5,$data['placas'][$i]->PLACA);
            $pdf->SetY($y_+18);
            $pdf->SetX($x_+18);
            $pdf->Multicell(40,5,$data['placas'][$i]->PROCEDENCIA);
            $pdf->SetX($x_+18);
            $pdf->SetY($y_+18);
            break;
        case "ALTERADA":
            $pdf->SetY($y_+36);
            $pdf->SetX($x_);
            $pdf->Multicell(18,5,$data['placas'][$i]->PLACA);
            $pdf->SetY($y_+36);
            $pdf->SetX($x_+18);
            $pdf->Multicell(40,5,$data['placas'][$i]->PROCEDENCIA);
            $pdf->SetX($x_+18);
            $pdf->SetY($y_+36);
            break;
        case "INDETERMINADA":
            $pdf->SetY($y_+54);
            $pdf->SetX($x_);
            $pdf->Multicell(18,5,$data['placas'][$i]->PLACA);
            $pdf->SetY($y_+54);
            $pdf->SetX($x_+18);
            $pdf->Multicell(40,5,$data['placas'][$i]->PROCEDENCIA);
            $pdf->SetX($x_+18);
            $pdf->SetY($y_+54);
            break;

    }
}
for($i=0;$i<count($data['nivs']);$i++){
    switch($data['nivs'][$i]->DESCRIPCION){
        case "ORIGINAL":
            $pdf->SetY(102);
            $pdf->SetX(130);
            $pdf->Multicell(68,5,$data['nivs'][$i]->NO_SERIE);   
            break;
        case "SOBREPUESTA":
            $pdf->SetY(119);
            $pdf->SetX(130);
            $pdf->Multicell(68,5,$data['nivs'][$i]->NO_SERIE);
            break;
        case "ALTERADA":
            $pdf->SetY(138);
            $pdf->SetX(130);
            $pdf->Multicell(68,5,$data['nivs'][$i]->NO_SERIE);    
            break;
        case "INDETERMINADA":
            $pdf->SetY(156);
            $pdf->SetX(130);
            $pdf->Multicell(68,5,$data['nivs'][$i]->NO_SERIE);
            break;
    }
}
$pdf->SetFont('helvetica','',12);
/*Nivs*/
$pdf->SetY(205);
$pdf->SetX(20);
$pdf->Cell(5,5,$data['vehiculo']->FECHA_RECUPERACION);
$pdf->SetX(60);
$pdf->Cell(5,5,$data['vehiculo']->FECHA_PUESTA_DISPOSICION);
$pdf->SetX(93);
$reemp = array("COLONIA", "COL.","Colonia","colonia","COLONIA ","Colonia ","colonia ");
$colonia = str_replace($reemp, "", $data['vehiculo']->COLONIA);
$pdf->Multicell(65,5,utf8_decode($colonia));
$pdf->SetY(205);
$pdf->SetX(165);
$pdf->Cell(5,5,$data['vehiculo']->ZONA_EVENTO);
/*Tercer renglon*/
$pdf->SetY(245);
$pdf->SetX(20);
$pdf->Multicell(50,5,utf8_decode($data['vehiculo']->PRIMER_RESPONDIENTE));
if($data['vehiculo']->NO_FICHA_R!=0 and isset($data['responsable'][0])){
    $pdf->SetY(245);
    $pdf->SetX(70);
    $colaboracion="";
    for($i=0;$i<count($data['colaboracion']);$i++){
        $colaboracion.=$data['colaboracion'][$i]->Sector_Area.", ";
    }
    $pdf->Multicell(42,5,utf8_decode($colaboracion));
    $pdf->SetY(245);
    $pdf->SetX(115);
    $pdf->Multicell(75,5,utf8_decode(mb_strtoupper($data['responsable'][0]->nombre_completo)));
}
$pdf->SetY(270);
$pdf->SetX(150);
$pdf->Cell(5,5,"Pagina ".$pag_actual. "/".$pag);



/*Segunda pagina de fotografias*/
$pdf->addPage();
$pdf->useImportedPage($pageId2, 1, 1,207,295);
$pdf->SetFont('helvetica','',12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetY(14);
$pdf->SetX(170);
if($data['vehiculo']->NO_FICHA_V!=0){
    $pdf->Cell(5,5,$data['vehiculo']->NO_FICHA_V);
}
else{
    $pdf->SetY(20);
    $pdf->SetX(170);
    $pdf->Cell(5,5,$data['vehiculo']->NO_FICHA_R);
}
$pdf->SetY(25);
$pdf->SetX(170);
$pdf->Cell(5,5,$data['vehiculo']->ID_VEHICULO);
if(isset($data['fotos'][0])){
    for($f=0;$f<count($data['fotos']);$f++){
        $imagen = explode("?", $data['fotos'][$f]->Path_Imagen);
        $pathImagesFH = base_url."public/files/Vehiculos/".$data['vehiculo']->ID_VEHICULO."/Fotos/".$imagen[0];
        if(isset($pathImagesFH) && getimagesize($pathImagesFH)){
            $type = exif_imagetype($pathImagesFH);
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
            if (strpos($imagen[0], "parte_frontal") !== false) {
                $pdf->Image($pathImagesFH,33,59,60,52,$extension);
            }
            if(strpos($imagen[0], "parte_posterior") !== false){
                $pdf->Image($pathImagesFH,117,59,60,52,$extension);
            }
            if(strpos($imagen[0], "costado_conductor") !== false){
                $pdf->Image($pathImagesFH,25,120,75,60,$extension);
            }
            if(strpos($imagen[0], "costado_copiloto") !== false){
                $pdf->Image($pathImagesFH,110,120,75,60,$extension);
            }
        }
            
    }
}
$pdf->SetY(190);
$pdf->SetX(22);
$pdf->Multicell(162,5,utf8_decode($data['vehiculo']->OBSERVACIONES));
$pdf->SetY(238);
$pdf->SetX(65);
$pdf->Cell(5,5,$data['vehiculo']->ELABORO);
$pdf->SetY(270);
$pdf->SetX(150);
$pag_actual++;
$pdf->Cell(5,5,"Pagina ".$pag_actual. "/".$pag);
$pageId3 = $pdf->importPage(3);
$j=0; $k=1;
$reemplazar=["\n",'"'];
$por=["\t",'`'];
for($i=$pag_actual;$i<$pag;$i++){ 
    $pdf->addPage();
    $pdf->useImportedPage($pageId3, 1, 1,207,295);
    $pdf->SetFont('helvetica','',12);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetY(14);
    $pdf->SetX(170);
    if($data['vehiculo']->NO_FICHA_V!=0){
        $pdf->Cell(5,5,$data['vehiculo']->NO_FICHA_V);
    }
    else{
        $pdf->SetY(20);
        $pdf->SetX(170);
        $pdf->Cell(5,5,$data['vehiculo']->NO_FICHA_R);
    }
    $pdf->SetY(25);
    $pdf->SetX(170);
    $pdf->Cell(5,5,$data['vehiculo']->ID_VEHICULO);
    $pdf->SetY(60);
    $pdf->SetX(10);
    if($j==0){
        $pdf->Multicell(190,5,utf8_decode(str_replace($reemplazar, $por, mb_substr($data['vehiculo']->NARRATIVAS,$j,2970))));
    }
    else{
        $pdf->Multicell(190,5,utf8_decode(str_replace($reemplazar, $por, mb_substr($data['vehiculo']->NARRATIVAS,$j+1,2970))));
    }
    $pag_actual++;
    $pdf->SetY(270);
    $pdf->SetX(150);
    $pdf->Cell(5,5,"Pagina ".$pag_actual. "/".$pag);
    $j+=2970; $k++;
}
$pdf->Output('I', 'generated.pdf');
?>
