<?php 
	//se separa la info del dictamen
	$info_dictamen 	=	$data['info_dictamen'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title><?= $data['titulo']?></title>
	  
	<!-- Bootstrap CSS CDN -->
	<link rel="stylesheet" href="<?php echo base_url ?>public/css/bootstrap/bootstrap.css">
	<!-- ----- ----- ----- Root CSS ----- ----- ----- -->
	<link rel="stylesheet" href="<?php echo base_url ?>public/css/general/root.css">
	<!-- Our Custom CSS -->
	<link rel="stylesheet" href="<?php echo base_url ?>public/css/template/style.css">
	<!-- Scrollbar Custom CSS -->
	<link rel="stylesheet" href="<?php echo base_url ?>public/css/template/header/customScrollbar.min.css">
	<!--Material Icons-->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<meta name="theme-color" content="#6D0725" />
	<link rel='shortcut icon' type='image/ico' href='<?php echo base_url ?>public/media/icons/favicon.ico'/>
	    
	<script defer src="<?php echo base_url?>public/js/template/header/solid.js"></script>
	<script defer src="<?php echo base_url?>public/js/template/header/fontawesome.js"></script>
	<?php echo (isset($data['extra_css']))?$data['extra_css']:'';?>
</head>
<body>
	<div class="container mb-4">
		<!--header 1-->
		<div class="row mt-1">
			<div class="col-auto my-auto">
				<!-- <img src="<?= base_url?>public/media/images/logo_puebla_1.png" height="44"> -->
				<img src="<?= base_url?>public/media/images/logo21.png" height="44">
			</div>
			<div class="col-auto my-auto">
				<!-- <img src="<?= base_url?>public/media/images/logo_secretaria.png" height="44"> -->
			</div>
			<div class="col-auto my-auto">
				<!-- <img src="<?= base_url?>public/media/images/seguridad_ciudadana.png" height="44"> -->
			</div>
			<!-- 
			<div class="col-auto my-auto logo-borde">
				<img src="<?= base_url?>public/media/images/mexico_logo.png" height="44">
			</div>
			<div class="col-auto my-auto logo-borde">
				<img src="<?= base_url?>public/media/images/norma_logo.png" height="44">
			</div>
			<div class="col-auto my-auto logo-borde">
				<img src="<?= base_url?>public/media/images/corazon_25.png" height="44">
			</div>
			<div class="col-auto my-auto">
				<img src="<?= base_url?>public/media/images/quejas.png" height="44">
			</div>
			-->
			<div class="col-auto my-auto ml-auto">
				<div class="col-12 text-center">
					<span class="font-header">DIRECCIÓN JURÍDICA</span>
				</div>
				<div class="col-12 text-center">
					<span class="font-header">ÁREA MÉDICA</span>
				</div>
				
			</div>
		</div>
		<!--header 2 titulo-->
		<div class="row mt-1">
			<div class="col-6 offset-3 text-center">
				<h5 id="id_titulo">CONSTANCIA DE INTEGRIDAD FÍSICA</h5>
			</div>
			<div class="col-3">
				<div class="row">
					<div class="col-3 ">
						<span class="campo">Folio: </span>
					</div>
					<div class="col-8 mi_border_1 text-center">
						<?php 
							//se prepara el folio por si no cuenta con las cifras exactas
						$MAX_DIGITOS = 5;
						$id_dictamen_aux = $info_dictamen->Id_Dictamen;
							while(strlen($id_dictamen_aux) < $MAX_DIGITOS) {
								$id_dictamen_aux = "0".$id_dictamen_aux;
							}
						?>
						<span class="font-folio"><?= $id_dictamen_aux;?></span>
					</div>
				</div>
			</div>
		</div>

		<!--Fecha hora e instancia-->
		<div class="row mt-1">
			<!--fecha hora-->
			<div class="col-auto mr-auto">
				<div class="row">
					<div class="col-auto">
						<span class="valor-campo">Fecha: <span class="campo"><?= $info_dictamen->Fecha1?></span></span>
					</div>
					<div class="col-auto ml-5">
						<span class="valor-campo">Hora: <span class="campo"><?= $info_dictamen->Hora1?> hrs</span></span>
					</div>
				</div>
			</div>
			<div class="col-auto ml-auto mr-5">
				<div class="row">
					
					<?php
						$ind=0;
						$b[$ind++] = (mb_strtoupper($info_dictamen->Instancia) == 'JUEZ DE JUSTICIA CÍVICA')?true:false;
						$b[$ind++] = (mb_strtoupper($info_dictamen->Instancia) == 'MINISTERIO PÚBLICO')?true:false;
					?>
					<div class="col-auto mx-auto">
						<span class="valor-campo">JC ( <span class="<?= ($b[0])?'marca':'transparent-text';?>">X</span> )</span>
					</div>
					<div class="col-auto mx-auto">
						<span class="valor-campo">MP ( <span class="<?= ($b[1])?'marca':'transparent-text';?>">X</span> )</span>
					</div>
				</div>
			</div>
		</div>

		<!--DATOS GENERALES DEL EXAMINADO-->
		<div class="row mt-1">
			<div class="col-12 text-center fondo-seccion">
				<span class="titulo-seccion">Datos generales del examinado</span>
			</div>
			<div class="col-12">
				<div class="row">
					<div class="col-4">
						<span class="font_form_campo">Nombre del examinado:</span>
					</div>
					<div class="col-8 border_bottom">
						<span class="font_form_valor"><?= mb_strtoupper($info_dictamen->Nombre_Completo_Detenido)?></span>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="row">
					<div class="col-1">
						<span class="font_form_campo">Edad:</span>
					</div>
					<div class="col-1 border_bottom">
						<span class="font_form_campo"><?= $info_dictamen->Edad?></span>
					</div>
					<div class="col-2">
						<?php
							$ind=0;
							$b[$ind++] = (mb_strtoupper($info_dictamen->Genero) == 'M')?true:false;
							$b[$ind++] = (mb_strtoupper($info_dictamen->Genero) == 'H')?true:false;
						?>
						<span class="font_form_campo ">Sexo: ( <span class="<?= ($b[0])?'marca_fondo':'';?>" >M</span> ) ( <span class="<?= ($b[1])?'marca_fondo':'';?>" >H</span> )</span>
						
					</div>
					
					<div class="col-8 border_bottom">
						<span class="font_form_valor transparent-text"><?= mb_strtoupper("-")?></span>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="row">
					<div class="col-4">
						<span class="font_form_campo">Ocupación:</span>
					</div>
					
					<div class="col-8 border_bottom">
						<span class="font_form_valor"><?= mb_strtoupper($info_dictamen->Ocupacion)?></span>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="row">
					<div class="col-4">
						<span class="font_form_campo">Domicilio personal:</span>
					</div>
					
					<div class="col-8 border_bottom">
						<span class="font_form_valor"><?= mb_strtoupper($info_dictamen->Domicilio)?></span>
					</div>
				</div>
			</div>
		</div>

		<!--ANTECEDENTES Y PRUEBAS REALIZADAS-->
		<div class="row mt-1 border-form">
			<!--ANTECEDENTES-->
			<div class="col-6 ">
				<div class="row">
					<div class="col-12 fondo-seccion-2 text-center">
						<span class="titulo-seccion">Antecedentes</span>
					</div>
					<?php
						$ind=0;
						$b[$ind++] = (mb_strtoupper($info_dictamen->Enfermedades_Padece) != '')?true:false;
						$b[$ind++] = (mb_strtoupper($info_dictamen->Medicamentos_Toma) != '')?true:false;
					?>
					<div class="col-12">
						<div class="row">
							<div class="col-5 mr-auto">
								<div class="font_form_campo">Padece enfermedades:</div>
							</div>
							<div class="col-auto mx-auto">
								<div class="font_form_campo">Sí ( <span class="<?= ($b[0])?'font_form_campo':'transparent-text';?>">X</span> )</div>
							</div>
							<div class="col-auto mx-auto">
								<div class="font_form_campo">No ( <span class="<?= (!$b[0])?'font_form_campo':'transparent-text';?>">X</span> )</div>
							</div>
						</div>
						<div class="row">
							<div class="col-auto ">
								<div class="font_form_campo">¿Cuál(es)?:</div>
							</div>
							<div class="col-auto ">
								<div class="font_form_valor"><?= mb_strtoupper($info_dictamen->Enfermedades_Padece)?></div>
							</div>
						</div>
						<div class="row">
							<div class="col-5 mr-auto">
								<div class="font_form_campo">Toma medicamentos:</div>
							</div>
							<div class="col-auto mx-auto">
								<div class="font_form_campo">Sí ( <span class="<?= ($b[1])?'font_form_campo':'transparent-text';?>">X</span> )</div>
							</div>
							<div class="col-auto mx-auto">
								<div class="font_form_campo">No ( <span class="<?= (!$b[1])?'font_form_campo':'transparent-text';?>">X</span> )</div>
							</div>
						</div>
						<div class="row">
							<div class="col-auto ">
								<div class="font_form_campo">¿Cuál(es)?:</div>
							</div>
							<div class="col-auto ">
								<div class="font_form_valor"><?= mb_strtoupper($info_dictamen->Medicamentos_Toma)?></div>
							</div>
						</div>
					</div>	
				</div>
			</div>
			<!--PRUEBAS REALIZADAS-->
			<div class="col-6 ">
				<div class="row">
					<div class="col-12 fondo-seccion-3 text-center">
						<span class="titulo-seccion">Pruebas realizadas</span>
					</div>
					<?php
						$ind=0;
						$b[$ind++] = ($info_dictamen->Prueba_Alcoholimetro)?true:false;
						$b[$ind++] = ($info_dictamen->Prueba_Multitestdrog)?true:false;
						$b[$ind++] = ($info_dictamen->Prueba_Clinica)?true:false;
					?>
					<div class="col-12">
						<div class="row">
							<div class="col-5">
								<div class="font_form_campo">Alcoholímetro:</div>
							</div>
							<div class="col-auto mx-auto">
								<div class="font_form_campo">Sí ( <span class="<?= ($b[0])?'font_form_campo':'transparent-text';?>">X</span> )</div>
							</div>
							<div class="col-auto mx-auto">
								<div class="font_form_campo">No ( <span class="<?= (!$b[0])?'font_form_campo':'transparent-text';?>">X</span> )</div>
							</div>
						</div>
						<div class="row">
							<div class="col-5">
								<div class="font_form_campo">Multitestdrog:</div>
							</div>
							<div class="col-auto mx-auto">
								<div class="font_form_campo">Sí ( <span class="<?= ($b[1])?'font_form_campo':'transparent-text';?>">X</span> )</div>
							</div>
							<div class="col-auto mx-auto">
								<div class="font_form_campo">No ( <span class="<?= (!$b[1])?'font_form_campo':'transparent-text';?>">X</span> )</div>
							</div>
						</div>
						<div class="row">
							<div class="col-5">
								<div class="font_form_campo">Clínica:</div>
							</div>
							<div class="col-auto mx-auto">
								<div class="font_form_campo">Sí ( <span class="<?= ($b[2])?'font_form_campo':'transparent-text';?>">X</span> )</div>
							</div>
							<div class="col-auto mx-auto">
								<div class="font_form_campo">No ( <span class="<?= (!$b[2])?'font_form_campo':'transparent-text';?>">X</span> )</div>
							</div>
						</div>
					</div>	
				</div>
			</div>
		</div>

		<!--INTERROGATORIO-->
		<div class="row border-form">
			<div class="col-12 fondo-seccion-2 text-center">
				<span class="titulo-seccion">Interrogatorio</span>
			</div>
			<?php
				$ind=0;
				$b[$ind++] = ($info_dictamen->Coopera_Interrogatorio)?true:false;
				$b[$ind++] = ($info_dictamen->Sustancia_Bit != '000')?true:false;
				$b[$ind++] = (substr($info_dictamen->Sustancia_Bit, 0,1) == '1')?true:false;
				$b[$ind++] = (substr($info_dictamen->Sustancia_Bit, 1,1) == '1')?true:false;
				$b[$ind++] = (substr($info_dictamen->Sustancia_Bit, 2,1) == '1')?true:false;

				$horizonal = $b[1];
			?>
			<!--cooperó y consumió?-->
			<div class="col-6">
				<div class="row">
					<div class="col-7">
						<div class="font_form_campo">¿Coopera con el interrogatorio?:</div>
					</div>
					<div class="col-auto mx-auto">
						<div class="font_form_campo">Sí ( <span class="<?= ($b[0])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
					<div class="col-auto mx-auto">
						<div class="font_form_campo">No ( <span class="<?= (!$b[0])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
				</div>
				<div class="row">
					<div class="col-7">
						<div class="font_form_campo">¿Consumió alguna sustancia?:</div>
					</div>
					<div class="col-auto mx-auto">
						<div class="font_form_campo">Sí ( <span class="<?= ($b[1])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
					<div class="col-auto mx-auto">
						<div class="font_form_campo">No ( <span class="<?= (!$b[1])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
				</div>
				<div class="row">
					<div class="col-auto">
						<div class="font_form_campo">¿A qué hora inició el consumo?:</div>
					</div>
					<?php
						$fecha2 = 'No Refiere';
						$hora2  = 'No Refiere';
						if(isset($info_dictamen->Fecha_Hora_Consumo) && strlen($info_dictamen->Fecha_Hora_Consumo) == 16){ //ambos
							$auxFecha2 = explode(" ", $info_dictamen->Fecha_Hora_Consumo);
							$auxF = explode("-",$auxFecha2[0]);
							$auxF = (isset($auxF[2]))?$auxF[2]."/".$auxF[1]."/".$auxF[0]:'';
							$fecha2 = $auxF;
							$hora2  = substr($auxFecha2[1],0,5).'hrs';
						}
						else if(strlen($info_dictamen->Fecha_Hora_Consumo) == 10){//solo fecha
							$auxF = explode("-",$info_dictamen->Fecha_Hora_Consumo);
							$auxF = (isset($auxF[2]))?$auxF[2]."/".$auxF[1]."/".$auxF[0]:'';
							$fecha2 = $auxF;
							// $hora2 = 'No Refiere';
						}
						else if(strlen($info_dictamen->Fecha_Hora_Consumo) == 5){//solo hora
							// $fecha2 = ' No Refiere';
							$hora2  = $info_dictamen->Fecha_Hora_Consumo.'hrs';
						}
					?>
					<div class="col-auto">
						<div class="font_form_campo">Día:<span class="font_form_valor border_bottom" ><?= ($b[1])?$fecha2:'';?></span></div>
					</div>
					<div class="col-auto">
						<div class="font_form_campo">Hora:<span class="font_form_valor border_bottom" ><?= ($b[1])?$hora2:'';?></span></div>
					</div>
				</div>
			</div>
			<!--qué consuió-->
			<div class="col-6">
				<div class="row">
					<div class="col-12">
						<div class="font_form_campo">Indique sustancia consumida:</div>
					</div>
				</div>
				<div class="row <?= ($horizonal)?'':'linea1'?>">
					<div class="col-auto mx-auto">
						<div class="font_form_campo">Alcohol ( <span class="<?= ($b[2])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
					<div class="col-auto mx-auto">
						<div class="font_form_campo">Droga ( <span class="<?= ($b[3])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
					<div class="col-auto mx-auto">
						<div class="font_form_campo">Inhalante ( <span class="<?= ($b[4])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
				</div>
				<div class="row">
					<?php
						$cantidadConsumida = '';
						if($b[1]){
							$cantidadConsumida = ($info_dictamen->Cantidad_Consumida != '')?$info_dictamen->Cantidad_Consumida:'No refiere';
						}
					?>
					<div class="col-auto">
						<div class="font_form_campo">Cantidad consumida:</div>
					</div>
					<div class="col-auto">
						<div class="font_form_valor"><?= $cantidadConsumida;?></div>
					</div>
				</div>
			</div>
		</div>

		<!--INTOXICACIÓN ETÍLICA-->
		<div class="row border-form">
			<div class="col-12 fondo-seccion-2 text-center">
				<span class="titulo-seccion">Intoxicación etílica</span>
			</div>
			<?php
				//echo "IE: $info_dictamen->Intoxicacion_Etilica_Bit <br>";
				$ind=0;
				$b[$ind++] = (substr($info_dictamen->Intoxicacion_Etilica_Bit, 12,1) == '1')?true:false;
				$b[$ind++] = (substr($info_dictamen->Intoxicacion_Etilica_Bit, 11,1) == '1')?true:false;
				$b[$ind++] = (substr($info_dictamen->Intoxicacion_Etilica_Bit, 10,1) == '1')?true:false;
				$b[$ind++] = (substr($info_dictamen->Intoxicacion_Etilica_Bit, 9,1) == '1')?true:false;
				$b[$ind++] = (substr($info_dictamen->Intoxicacion_Etilica_Bit, 8,1) == '1')?true:false;
				$b[$ind++] = (substr($info_dictamen->Intoxicacion_Etilica_Bit, 7,1) == '1')?true:false;
				$b[$ind++] = (substr($info_dictamen->Intoxicacion_Etilica_Bit, 6,1) == '1')?true:false;
				$b[$ind++] = (substr($info_dictamen->Intoxicacion_Etilica_Bit, 5,1) == '1')?true:false;
				$b[$ind++] = (substr($info_dictamen->Intoxicacion_Etilica_Bit, 4,1) == '1')?true:false;
				$b[$ind++] = (substr($info_dictamen->Intoxicacion_Etilica_Bit, 3,1) == '1')?true:false;
				$b[$ind++] = (substr($info_dictamen->Intoxicacion_Etilica_Bit, 2,1) == '1')?true:false;
				$b[$ind++] = (substr($info_dictamen->Intoxicacion_Etilica_Bit, 1,1) == '1')?true:false;
				$b[$ind++] = (substr($info_dictamen->Intoxicacion_Etilica_Bit, 0,1) == '1')?true:false;

				$vertical1 = false || $b[0] || $b[1] || $b[2] || $b[4];
				$vertical2 = false || $b[5] || $b[6] || $b[7] || $b[8];
				$vertical3 = false || $b[9] || $b[10] || $b[11] || $b[12];
				// var_dump($b);
			?>
			<!--columna 1-->
			<div class="col-4">
				<div class="row">
					<div class="col-9">
						<div class="font_form_campo">Aliento alcohólico:</div>
						<div class="font_form_campo">Rubor facial:</div>
						<div class="font_form_campo">Euforia:</div>
						<div class="font_form_campo">Actitud discutiría:</div>
					</div>
					<div class="col-3 <?= ($vertical1)?'':'linea2'?>">
						<div class="font_form_campo">( <span class="<?= ($b[0])?'font_form_campo':'transparent-text';?>">X</span> )</div>
						<div class="font_form_campo">( <span class="<?= ($b[1])?'font_form_campo':'transparent-text';?>">X</span> )</div>
						<div class="font_form_campo">( <span class="<?= ($b[2])?'font_form_campo':'transparent-text';?>">X</span> )</div>
						<div class="font_form_campo">( <span class="<?= ($b[4])?'font_form_campo':'transparent-text';?>">X</span> )</div>	
					</div>
					
				</div>
			</div>
			<!--columna 2-->
			<div class="col-4">
				<div class="row">
					<div class="col-9">
						<div class="font_form_campo">Exageración de la conducta:</div>
						<div class="font_form_campo">Incoordinación leve:</div>
						<div class="font_form_campo">Afectación del habla:</div>
						<div class="font_form_campo">Habla en tono elevado:</div>
					</div>
					<div class="col-3 <?= ($vertical2)?'':'linea2'?>">
						<div class="font_form_campo">( <span class="<?= ($b[5])?'font_form_campo':'transparent-text';?>">X</span> )</div>
						<div class="font_form_campo">( <span class="<?= ($b[6])?'font_form_campo':'transparent-text';?>">X</span> )</div>
						<div class="font_form_campo">( <span class="<?= ($b[7])?'font_form_campo':'transparent-text';?>">X</span> )</div>
						<div class="font_form_campo">( <span class="<?= ($b[8])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
				
				</div>
			</div>
			<!--columna 3-->
			<div class="col-4">
				<div class="row">
					<div class="col-9">
						<div class="font_form_campo">Actitud agresiva:</div>
						<div class="font_form_campo">Conducta irresponsable:</div>
						<div class="font_form_campo">Dificultad al estar de pie:</div>
						<div class="font_form_campo">Se mueve con ayuda:</div>
					</div>
					<div class="col-3 <?= ($vertical3)?'':'linea2'?>">
						<div class="font_form_campo">( <span class="<?= ($b[9])?'font_form_campo':'transparent-text';?>">X</span> )</div>
						<div class="font_form_campo">( <span class="<?= ($b[10])?'font_form_campo':'transparent-text';?>">X</span> )</div>
						<div class="font_form_campo">( <span class="<?= ($b[11])?'font_form_campo':'transparent-text';?>">X</span> )</div>
						<div class="font_form_campo">( <span class="<?= ($b[12])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
				</div>
			</div>
		</div>

		<!--NIVEL DE CONCIENCIA-->
		<div class="row border-form">
			<div class="col-12 fondo-seccion-2 text-center">
				<span class="titulo-seccion">Nivel de conciencia</span>
			</div>
			<!--estado de conciencia-->
			<div class="col-3 border_round my-1">
				<div class="row">
					<div class="col-12 text-center border_bottom">
						<div class="font_form_campo">Estado de conciencia:</div>
					</div>
				</div>
				<?php
					$ind=0;
					$b[$ind++] = (mb_strtoupper($info_dictamen->Estado_Conciencia) == 'NORMAL')?true:false;
					$b[$ind++] = (mb_strtoupper($info_dictamen->Estado_Conciencia) == 'ALETARGADO')?true:false;
				?>
				<div class="row">
					<div class="col-9">
						<div class="font_form_campo">Normal:</div>
					</div>
					<div class="col-3">
						<div class="font_form_campo">( <span class="<?= ($b[0])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
					<div class="col-9">
						<div class="font_form_campo">Aletargado:</div>
					</div>
					<div class="col-3">
						<div class="font_form_campo">( <span class="<?= ($b[1])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
				</div>
			</div>
			<!--Orientación-->
			<div class="col-3 border_round my-1">
				<div class="row">
					<div class="col-12 text-center border_bottom">
						<div class="font_form_campo">Orientación:</div>
					</div>
				</div>
				<?php
					$ind=0;
					$b[$ind++] = (substr($info_dictamen->Orientacion_Bit, 0,1) == '1')?true:false;
					$b[$ind++] = (substr($info_dictamen->Orientacion_Bit, 1,1) == '1')?true:false;
					$b[$ind++] = (substr($info_dictamen->Orientacion_Bit, 2,1) == '1')?true:false;
				?>
				<div class="row">
					<div class="col-9">
						<div class="font_form_campo">Persona:</div>
					</div>
					<div class="col-3">
						<div class="font_form_campo">( <span class="<?= ($b[0])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
					<div class="col-9">
						<div class="font_form_campo">Tiempo:</div>
					</div>
					<div class="col-3">
						<div class="font_form_campo">( <span class="<?= ($b[1])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
					<div class="col-9">
						<div class="font_form_campo">Espacio:</div>
					</div>
					<div class="col-3">
						<div class="font_form_campo">( <span class="<?= ($b[2])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
				</div>
			</div>
			<!--Actitud-->
			<div class="col-3 border_round my-1">
				<div class="row">
					<div class="col-12 text-center border_bottom">
						<div class="font_form_campo">Actitud:</div>
					</div>
				</div>
				<?php
					$ind=0;
					$b[$ind++] = (mb_strtoupper($info_dictamen->Actitud) == 'AGRESIVA')?true:false;
					$b[$ind++] = (mb_strtoupper($info_dictamen->Actitud) == 'INDIFERENTE')?true:false;
					$b[$ind++] = (mb_strtoupper($info_dictamen->Actitud) == 'LIBREMENTE ESCOGIDA')?true:false;
				?>
				<div class="row">
					<div class="col-9">
						<div class="font_form_campo">Agresiva:</div>
					</div>
					<div class="col-3">
						<div class="font_form_campo">( <span class="<?= ($b[0])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
					<div class="col-9">
						<div class="font_form_campo">Indiferente:</div>
					</div>
					<div class="col-3">
						<div class="font_form_campo">( <span class="<?= ($b[1])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
					<div class="col-9">
						<div class="font_form_campo">Libremente escogida:</div>
					</div>
					<div class="col-3">
						<div class="font_form_campo">( <span class="<?= ($b[2])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
				</div>
			</div>
			<!--Lenguaje-->
			<div class="col-3 border_round my-1">
				<div class="row">
					<div class="col-12 text-center border_bottom">
						<div class="font_form_campo">Lenguaje:</div>
					</div>
				</div>
				<?php
					$ind=0;
					$b[$ind++] = (substr($info_dictamen->Lenguaje_Bit, 0,1) == '1')?true:false;
					$b[$ind++] = (substr($info_dictamen->Lenguaje_Bit, 1,1) == '1')?true:false;
					$b[$ind++] = (substr($info_dictamen->Lenguaje_Bit, 2,1) == '1')?true:false;
					$b[$ind++] = (substr($info_dictamen->Lenguaje_Bit, 3,1) == '1')?true:false;
					
				?>
				<div class="row">
					<div class="col-9">
						<div class="font_form_campo">Normal:</div>
					</div>
					<div class="col-3">
						<div class="font_form_campo">( <span class="<?= ($b[0])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
					<div class="col-9">
						<div class="font_form_campo">Disartría:</div>
					</div>
					<div class="col-3">
						<div class="font_form_campo">( <span class="<?= ($b[1])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
					<div class="col-9">
						<div class="font_form_campo">Verborreico:</div>
					</div>
					<div class="col-3">
						<div class="font_form_campo">( <span class="<?= ($b[2])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
					<div class="col-9">
						<div class="font_form_campo">Incoherente:</div>
					</div>
					<div class="col-3">
						<div class="font_form_campo">( <span class="<?= ($b[3])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
				</div>
			</div>
		</div>

		<!--EXPLORACIÓN FÍSICA-->
		<div class="row border-form">
			<div class="col-12 fondo-seccion-2 text-center mb-1">
				<span class="titulo-seccion">Exploración física</span>
			</div>
			<!--Fascies-->
			<div class="col-3 border_round">
				<div class="row">
					<div class="col-12 text-center border_bottom">
						<div class="font_form_campo">Facies:</div>
					</div>
				</div>
				<?php
					$ind=0;
					$b[$ind++] = (mb_strtoupper($info_dictamen->Fascies) == 'NORMAL')?true:false;
					$b[$ind++] = (mb_strtoupper($info_dictamen->Fascies) == 'ALCOHÓLICA')?true:false;
				?>
				<div class="row">
					<div class="col-9">
						<div class="font_form_campo">Normal:</div>
					</div>
					<div class="col-3">
						<div class="font_form_campo">( <span class="<?= ($b[0])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
					<div class="col-9">
						<div class="font_form_campo">Alcohólica:</div>
					</div>
					<div class="col-3">
						<div class="font_form_campo">( <span class="<?= ($b[1])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
				</div>
			</div>
			<!--Conjuntivas-->
			<div class="col-3 border_round">
				<div class="row">
					<div class="col-12 text-center border_bottom">
						<div class="font_form_campo">Conjuntivas:</div>
					</div>
				</div>
				<?php
					$ind=0;
					$b[$ind++] = (mb_strtoupper($info_dictamen->Conjuntivas) == 'COLORACIÓN NORMAL')?true:false;
					$b[$ind++] = (mb_strtoupper($info_dictamen->Conjuntivas) == 'HIPERÉMICAS')?true:false;
				?>
				<div class="row">
					<div class="col-9">
						<div class="font_form_campo">Coloración normal:</div>
					</div>
					<div class="col-3">
						<div class="font_form_campo">( <span class="<?= ($b[0])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
					<div class="col-9">
						<div class="font_form_campo">Hiperémicas:</div>
					</div>
					<div class="col-3">
						<div class="font_form_campo">( <span class="<?= ($b[1])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
				</div>
			</div>
			<!--Pupilas-->
			<div class="col-6 border_round">
				<div class="row">
					<div class="col-12 text-center border_bottom">
						<div class="font_form_campo">Pupilas:</div>
					</div>
				</div>
				<?php
					$ind=0;
					$b[$ind++] = (mb_strtoupper($info_dictamen->Pupilas) == 'NORMAL')?true:false;
					$b[$ind++] = (mb_strtoupper($info_dictamen->Pupilas) == 'MIÓTICAS')?true:false;
					$b[$ind++] = (mb_strtoupper($info_dictamen->Pupilas) == 'MIDRIÁTICAS')?true:false;
					$b[$ind++] = (mb_strtoupper($info_dictamen->Pupilas2) == 'NORMOREFLÉXICAS')?true:false;
					$b[$ind++] = (mb_strtoupper($info_dictamen->Pupilas2) == 'HIPERREFLÉXICAS')?true:false;
					$b[$ind++] = (mb_strtoupper($info_dictamen->Pupilas2) == 'HIPORREFLÉXICAS')?true:false;
				?>
				<div class="row">
					<div class="col-6">
						<div class="row">
							<div class="col-9">
								<div class="font_form_campo">Normal:</div>
							</div>
							<div class="col-3">
								<div class="font_form_campo">( <span class="<?= ($b[0])?'font_form_campo':'transparent-text';?>">X</span> )</div>
							</div>
							<div class="col-9">
								<div class="font_form_campo">Mióticas:</div>
							</div>
							<div class="col-3">
								<div class="font_form_campo">( <span class="<?= ($b[1])?'font_form_campo':'transparent-text';?>">X</span> )</div>
							</div>
							<div class="col-9">
								<div class="font_form_campo">Midriáticas:</div>
							</div>
							<div class="col-3">
								<div class="font_form_campo">( <span class="<?= ($b[2])?'font_form_campo':'transparent-text';?>">X</span> )</div>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="row">
							<div class="col-9">
								<div class="font_form_campo">Normorefléxicas:</div>
							</div>
							<div class="col-3">
								<div class="font_form_campo">( <span class="<?= ($b[3])?'font_form_campo':'transparent-text';?>">X</span> )</div>
							</div>
							<div class="col-9">
								<div class="font_form_campo">Hiperrefléxicas:</div>
							</div>
							<div class="col-3">
								<div class="font_form_campo">( <span class="<?= ($b[4])?'font_form_campo':'transparent-text';?>">X</span> )</div>
							</div>
							<div class="col-9">
								<div class="font_form_campo">Hiporrefléxicas:</div>
							</div>
							<div class="col-3">
								<div class="font_form_campo">( <span class="<?= ($b[5])?'font_form_campo':'transparent-text';?>">X</span> )</div>
							</div>
						</div>
					</div>	
				</div>
			</div>
			<!--Mucosa oral-->
			<div class="col-6 border_round my-1">
				<div class="row">
					<div class="col-12 text-center border_bottom">
						<div class="font_form_campo">Mucosa oral:</div>
					</div>
				</div>
				<?php
					$ind=0;
					$b[$ind++] = (mb_strtoupper($info_dictamen->Mucosa_Oral) == 'HIDRATADA')?true:false;
					$b[$ind++] = (mb_strtoupper($info_dictamen->Mucosa_Oral) == 'DESHIDRATADA')?true:false;
				?>
				<div class="row my-1">
					<div class="col-auto ml-auto">
						<div class="font_form_campo">Hidratada:</div>
					</div>
					<div class="col-auto">
						<div class="font_form_campo">( <span class="<?= ($b[0])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
					<div class="col-auto">
						<div class="font_form_campo">Deshidratada:</div>
					</div>
					<div class="col-auto mr-auto">
						<div class="font_form_campo">( <span class="<?= ($b[1])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
				</div>
			</div>
			<!--Aliento-->
			<div class="col-6 border_round my-1">
				<div class="row">
					<div class="col-12 text-center border_bottom">
						<div class="font_form_campo">Aliento:</div>
					</div>
				</div>
				<?php
					$ind=0;
					$b[$ind++] = (substr($info_dictamen->Aliento_Bit, 0,1) == '1')?true:false;
					$b[$ind++] = (substr($info_dictamen->Aliento_Bit, 1,1) == '1')?true:false;
					$b[$ind++] = (substr($info_dictamen->Aliento_Bit, 2,1) == '1')?true:false;

					$horizonal = $b[0] || $b[1] || $b[2];
				?>
				<div class="row my-1 <?= ($horizonal)?'':'linea1'?>">
					<div class="col-auto ml-auto">
						<div class="font_form_campo">Alcohol:</div>
					</div>
					<div class="col-auto">
						<div class="font_form_campo">( <span class="<?= ($b[0])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
					<div class="col-auto">
						<div class="font_form_campo">Solventes:</div>
					</div>
					<div class="col-auto">
						<div class="font_form_campo">( <span class="<?= ($b[1])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
					<div class="col-auto">
						<div class="font_form_campo">Cannabis:</div>
					</div>
					<div class="col-auto mr-auto">
						<div class="font_form_campo">( <span class="<?= ($b[2])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
				</div>
			</div>
		</div>

		<!--HERIDAS/LESIONES-->
		<div class="row border-form">
			<div class="col-12 fondo-seccion-2 text-center mb-1">
				<span class="titulo-seccion">Heridas/Lesiones</span>
			</div>
			<div class="col-12">
				<div class="font_form_valor rayado_1">
					<?= mb_strtoupper($info_dictamen->Heridas_Lesiones);?>
				</div>
				
			</div>
		</div>

		<!--OBSERVACIONES-->
		<div class="row border-form">
			<div class="col-12 fondo-seccion-2 text-center mb-1">
				<span class="titulo-seccion">Observaciones</span>
			</div>
			<div class="col-12 ">
				<div class="font_form_valor rayado_2">
					<?= mb_strtoupper($info_dictamen->Observaciones);?>
				</div>
				
			</div>
		</div>

		<!--DIAGNÓSTICO-->
		<div class="row border-form">
			<div class="col-12 fondo-seccion-2 text-center mb-1">
				<span class="titulo-seccion">Diagnóstico</span>
			</div>
			<?php
				$ind=0;
				$b[$ind++] = (mb_strtoupper($info_dictamen->Diagnostico) == 'NEGATIVO A ALCOHOL')?true:false;
				$b[$ind++] = (mb_strtoupper($info_dictamen->Diagnostico) == 'ALIENTO ETÍLICO')?true:false;
				$b[$ind++] = (mb_strtoupper($info_dictamen->Diagnostico) == 'INTOXICACIÓN ETÍLICA LEVE O 1° PERIODO')?true:false;
				$b[$ind++] = (mb_strtoupper($info_dictamen->Diagnostico) == 'INTOXICACIÓN ETÍLICA MODERADA O 2° PERIODO')?true:false;
				$b[$ind++] = (mb_strtoupper($info_dictamen->Diagnostico) == 'INTOXICACIÓN ETÍLICA GRAVE O 3° PERIODO')?true:false;
			?>
			<div class="col-6">
				<div class="row border_bottom">
					<div class="col-5">
						<div class="font_form_campo">Negativo a alcohol:</div>
					</div>
					<div class="col-auto">
						<div class="font_form_campo">( <span class="<?= ($b[0])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
				</div>
				<div class="row border_bottom">
					<div class="col-5">
						<div class="font_form_campo">Aliento etílico:</div>
					</div>
					<div class="col-auto">
						<div class="font_form_campo">( <span class="<?= ($b[1])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
				</div>
				<div class="row border_bottom">
					<div class="col-5">
						<div class="transparent-text"> -- </div>
					</div>
				</div>
			</div>
			<div class="col-6">
				<div class="row border_bottom">
					<div class="col-9">
						<div class="font_form_campo">Intoxicación etílica leve o 1° periodo:</div>
					</div>
					<div class="col-auto">
						<div class="font_form_campo">( <span class="<?= ($b[2])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
				</div>
				<div class="row border_bottom">
					<div class="col-9">
						<div class="font_form_campo">Intoxicación etílica moderada o 2° periodo:</div>
					</div>
					<div class="col-auto">
						<div class="font_form_campo">( <span class="<?= ($b[3])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
				</div>
				<div class="row border_bottom">
					<div class="col-9">
						<div class="font_form_campo">Intoxicación etílica grave o 3° periodo:</div>
					</div>
					<div class="col-auto">
						<div class="font_form_campo">( <span class="<?= ($b[4])?'font_form_campo':'transparent-text';?>">X</span> )</div>
					</div>
				</div>
			</div>
			<!--renglon extra con texto transparente para border bottom-->
			<div class="col-12 border_bottom">
				<div class="transparent-text">
					---
				</div>
			</div>
		</div>

		<!--ELEMENTO PARTICIPANTE Y FIRMAS-->
		<div class="row mt-2 pt-2">
			<!--nombre y placa-->
			<div class="col-12">
				<div class="row">
					<div class="col-3">
						<div class="font_form_campo">Nombre de elemento:</div>
					</div>
					<div class="col-6 border_bottom">
						<div class="font_form_valor"><?= mb_strtoupper($info_dictamen->Nombre_Completo_Elemento) ?></div>
					</div>
					<div class="col-1">
						<div class="font_form_campo">Placa:</div>
					</div>
					<div class="col-2 border_bottom">
						<div class="font_form_valor"><?= ($info_dictamen->Placa_E != '')?mb_strtoupper($info_dictamen->Placa_E):'S/P';?></div>
					</div>
				</div>
			</div>
			<!--cargo, zona, patrulla y autoridad-->
			<div class="col-12 my-2">
				<div class="row">
					<div class="col-1">
						<div class="font_form_campo">Cargo:</div>
					</div>
					<div class="col-2 border_bottom text-center">
						<div class="font_form_valor"><?= mb_strtoupper($info_dictamen->Cargo_E) ?></div>
					</div>
					<div class="col-1">
						<div class="font_form_campo">Zona:</div>
					</div>
					<div class="col-2 border_bottom text-center">
						<div class="font_form_valor"><?= mb_strtoupper($info_dictamen->Sector_Area_E) ?></div>
					</div>
					<div class="col-1">
						<div class="font_form_campo">Patrulla:</div>
					</div>
					<div class="col-2 border_bottom text-center">
						<div class="font_form_valor"><?= mb_strtoupper($info_dictamen->Unidad_E) ?></div>
					</div>
					<div class="col-3 text-center">
						<div class="row">
							<div class="col-10 offset-1">
								<div class="font_form_campo">Autoridad a que remite</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			<!--fecha y nombre de instancia-->
			<div class="col-12 my-2">
				<?php
					$meses = ['-','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
					$fechaAux = explode("/", $info_dictamen->Fecha1);
					$dia = $fechaAux[0];
					$mes = $meses[intval($fechaAux[1])];
					$anio = $fechaAux[2];
				?>
				<div class="row">
					<div class="col-3">
						<div class="font_form_campo">H. Puebla de Zaragoza a:</div>
					</div>
					<div class="col-1 border_bottom text-center">
						<div class="font_form_valor"><?= mb_strtoupper($dia) ?></div>
					</div>
					<div class="col-1 text-center">
						<div class="font_form_campo">de</div>
					</div>
					<div class="col-2 border_bottom text-center">
						<div class="font_form_valor"><?= mb_strtoupper($mes) ?></div>
					</div>
					<div class="col-1 text-center">
						<div class="font_form_campo">de</div>
					</div>
					<div class="col-1 border_bottom text-center">
						<div class="font_form_valor"><?= mb_strtoupper($anio) ?></div>
					</div>

					<div class="col-3 ">
						<div class="row">
							<div class="col-10 offset-1 border_bottom text-center">
								<div class="font_form_valor">
									<?= mb_strtoupper($info_dictamen->Instancia) ?>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			<!--firmas y huella digital-->
			<div class="col-12">
				<div class="row">
					<div class="col-4 mb-n5">
						<div class="row">
							<div class="col-12 ">
								<div class="font_form_valor text-center">
									<?= mb_strtoupper($info_dictamen->Nombre_Medico) ?>
								</div>
							</div>
						</div>
					</div>	
				</div>
				<div class="row">
					<div class="col-4 mt-5">
						<div class="row">
							<div class="col-10 offset-1 border_top">
								<div class="font_form_campo text-center">
									Nombre y firma del
								</div>
							</div>
							<div class="col-10 offset-1">
								<div class="font_form_campo text-center">
									médico en turno
								</div>
							</div>
						</div>
					</div>
					<div class="col-3 mt-5">
						<div class="row">
							<div class="col-10 offset-1 border_top">
								<div class="font_form_campo text-center">
									Firma del elemento
								</div>
							</div>
						</div>
					</div>
					<div class="col-3 mt-5">
						<div class="row">
							<div class="col-10 offset-1 border_top">
								<div class="font_form_campo text-center">
									Firma del examinado
								</div>
							</div>
						</div>
					</div>
					<div class="col-2">
						<div class="row">
							<div class="col-10 offset-1 border_round" id="huella_digital">
								<div class="font_form_campo text-center">
									Huella digital
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--FOOTER DEL FORMATO-->
		<div class="row mt-1">
			<div class="col-12 text-center">
				<div class="font_footer_2">
					www.pueblacapital.gob.mx
				</div>
			</div>
			<div class="col-12 text-center">
				<img src="<?= base_url?>public/media/icons/ubicacion.png" height="15">
				<span class="font_footer_1">Boulevard San felipe No.2621 Col. Rancho Colorado Pue C.P.72040</span>
				<img src="<?= base_url?>public/media/icons/telefono.png" height="15">
				<span class="font_footer_1">Tel +52 (222) 1018500</span>
				<img src="<?= base_url?>public/media/icons/twitter.png" height="15">
				<span class="font_footer_1">#PueblaAyto</span>
				<img src="<?= base_url?>public/media/icons/facebook.png" height="15">
				<span class="font_footer_1">H.AyuntamientodePuebla</span>
			</div>
			<div class="col-6 offset-6 text-center">
				<span class="font_footer_3">FORM.1287-C/SSC1821/0320</span>
			</div>
		
		</div>
		
	</div>
	<script type="text/javascript">
		document.addEventListener("DOMContentLoaded", function(event) {
			window.print()
		});
	</script>
</body>
</html>

			<?php
				/*
					$MAX_HERIDAS_ROWS = 5; //num máximo de renglones
					$MAX_CHARS = 130;	//num máximo de caracteres por renglón
					//$lorem = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
					$lorem = "Fragmento de un escrito con unidad temática, que queda diferenciado del resto de fragmentos por un punto y aparte y generalmente también por llevar letra mayúscula inicial y un espacio en blanco en el margen izquierdo de alineación del texto principal de la primera línea.";

					$splitCad = explode(" ", $lorem); //se divide la cadena en palabras
					for($i=0;$i<$MAX_HERIDAS_ROWS;$i++){ //se pintan máximo 5 renglones
						$auxCad = '';	//cadena auxiliar para pintar en pantalla
						$seguir = true;	//bandera auxiliar para comprobar el tamaño de la cadena
						$vacio = false;
						if (count($splitCad)>0) { //si aún tiene palabras por escribir
							$vacio = false;
							while ($seguir) {
								try{
									$word = array_shift($splitCad);
									//echo strlen($auxCad.$word)." - $word<br>";
									if (strlen($auxCad.$word) < $MAX_CHARS) {
										//echo "$word <br>";
										$auxCad.= $word." ";
									}
									else{
										array_unshift($splitCad, $word); //se regresa la ultima palabra que revasa el límite
										$seguir = false; //ya no se continua
									}
								}catch(Exception $err){
									echo "Error: $err <br>";
									$seguir = false; //ya no se continua
								}
							}
						}
						else{
							$vacio = true;
						}

						if (!$vacio) { //se escribe el renglon
							?>
								<div class="col-12 border_bottom">
									<div class="font_form_valor">
										<?= mb_strtoupper($auxCad);?>
									</div>
								</div>
							<?php
						}
						else{ //cadena vacía
							?>
								<div class="col-12 border_bottom">
									<div class="transparent-text">
										---
									</div>
								</div>
							<?php
						}
					}
				*/
			?>