<?php 
	//se separa la info por apartados
	$general 	=	$data['info_remision']['General'];
	$elementos 	=	$data['info_remision']['Elementos'];
	$delitos 	=	$data['info_remision']['Delitos'];
	$armas 		=	$data['info_remision']['Armas_Asegurados'];
	$drogas 	=	$data['info_remision']['Drogas_Asegurados'];
	$objetos 	=	$data['info_remision']['Objetos_Asegurados'];
	//Se añade la variable vehiculos, para tener el arreglo de los vehiculos asegurados comentamos la variable de solo un vehiculo
	$vehiculos =	$data['info_remision']['Vehiculos_Asegurados'];
	//$vehiculo_asegurado =	$data['info_remision']['Vehiculo_Asegurado'];
	$elemento_guardia = $data['info_remision']['Elemento_Guardia'];
	/*Se añade para mostrar el numero interior del domicilio del detenido*/
	if($general->No_Int_Det!= ""){
		$dom_ext_int= mb_strtoupper($general->No_Ext_Det). " INT: ".mb_strtoupper($general->No_Int_Det);
	}
	else{
		$dom_ext_int=mb_strtoupper($general->No_Ext_Det);
	}
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
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css"> -->
	<link rel="stylesheet" href="<?php echo base_url ?>public/css/template/header/customScrollbar.min.css">
	<!--Material Icons-->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<meta name="theme-color" content="#6D0725" />
	<!-- <link rel='shortcut icon' type='image/ico' href='<?php echo base_url ?>public/media/icons/favicon.ico'/> -->
	    
	<script defer src="<?php echo base_url?>public/js/template/header/solid.js"></script>
	<script defer src="<?php echo base_url?>public/js/template/header/fontawesome.js"></script>
	<?php echo (isset($data['extra_css']))?$data['extra_css']:'';?>
</head>
<body>
	<div class="container mb-4">
		<!--header 1-->
		<div class="row mt-2">
			<div class="col-auto mr-auto">
				<img src="<?= base_url?>public/media/images/logo21.png" height="90">
			</div>

			<div class="col-auto ml-auto my-auto">
				<span class="valor-campo"><em>COORDINACIÓN GENERAL DE OPERATIVIDAD POLICIAL <br> DIRECCIÓN DE INTELIGENCIA Y POLÍTICA CRIMINAL <br> DEPARTAMENTO DE INFORMACIÓN</em></span>
			</div>
		</div>
		<!--header 2-->
		<div class="row mt-2">
			<div class="col-12 text-center">
				<span class="valor-campo">REMISIÓN</span>
			</div>
		</div>
		<!--header 3-->
		<div class="row mt-2">
			<div class="col-8 my-auto">
				
				<div class="row">
					<div class="col-12">
						<span class="campoHeader">C: </span>
						<span class="valor-campo underline"><?= $general->Instancia;?></span>
					</div>
					<div class="col-12">
						<span class="campoHeader">CDI:__________________________________ </span>
						
					</div>
				</div>
			</div>
			<div class="col-4 no_border">
				<div class="row">
					<div class="col-3 offset-3">
						<span class="campoHeader">FOLIO: </span>
					</div>
					<div class="col-6 mi_border_1 text-center">
						<span class="folio"><?= $general->No_Remision;?></span>
					</div>
				</div>
				<div class="row">
					<?php
						$fechaHoraAux = explode(" ", $general->Fecha_Hora);
						$fecha1 = explode("-", $fechaHoraAux[0]);
						$hora1 = substr($fechaHoraAux[1],0,5);
					?>
					<div class="col-3 offset-3">
						<span class="campoHeader">FECHA: </span>
					</div>
					<div class="col-2">
						<div class=" underline campoHeader"><?= $fecha1[2]?></div>
					</div>
					<div class="col-2">
						<div class=" underline campoHeader"><?= $fecha1[1]?></div>
					</div>
					<div class="col-2">
						<div class=" underline campoHeader"><?= $fecha1[0]?></div>
					</div>
					<div class="col-3"></div>
					<div class="col-3"></div>
					<div class="col-2">
						<div class="">DÍA</div>
					</div>
					<div class="col-2">
						<div class="">MES</div>
					</div>
					<div class="col-2">
						<div class="">AÑO</div>
					</div>
				</div>
			</div>
		</div>
		<!--header 4-->
		<div class="row mt-2">
			<div class="col-8 my-auto">
				<div class="row">
					<div class="col-12">
						<span class="campo">PRESENTE </span>
					</div>
					<div class="col-12">
						<span class="campo">PARA LOS EFECTOS LEGALES QUE PROCEDAN SE REMITE A SU DISPOSICIÓN</span>
					</div>
				</div>
			</div>
			<div class="col-4">
				<div class="row text-right">
					<div class="col-12">
						<!--
							<span class="campo">ZONA: </span>
							<span class="valor-campo"><?= mb_strtoupper($general->Zona_Sector)?></span>
						-->
					</div>
					<div class="col-12">
						<span class="campo">CIA: </span>
						<span class="valor-campo"><?= mb_strtoupper($general->Cia)?></span>
					</div>
				</div>
			</div>
		</div>
		<!--REMITIDO-->
		<div class="row mt-2">
			<div class="col-12 text-center">
				<h6>REMITIDO</h6>
			</div>
			<div class="col-12 mi_border_1 py-3">
				<div class="row">
					<div class="col-2">
						<span class="campo">
							<span class="font_form_campo">NOMBRE:</span>
						</span>
					</div>
					<div class="col-10 border_bottom">
						<span class="valor-campo font_form_valor"><?= mb_strtoupper($general->Nombre_Detenido)?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-2">
						<span class="font_form_campo">CALLE:</span>
					</div>
					<div class="col-3 border_bottom">
						<span class="valor-campo font_form_valor"><?= mb_strtoupper($general->Calle_Det)?></span>
					</div>
					<div class="col-1">
						<span class="font_form_campo">NÚM:</span>
					</div>
					<div class="col-2 border_bottom">
						<span class="valor-campo font_form_valor"><?= $dom_ext_int ?></span>
					</div>
					<div class="col-1">
						<span class="font_form_campo">COL:</span>
					</div>
					<div class="col-3 border_bottom">
						<span class="valor-campo font_form_valor"><?= mb_strtoupper($general->Colonia_Det)?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-1">
						<span class="font_form_campo">CIUDAD:</span>
					</div>
					<div class="col-1 border_bottom">
						<span class="valor-campo font_form_valor"><?= mb_strtoupper($general->Municipio_Det)?></span>
					</div>
					<div class="col-1">
						<span class="font_form_campo">C.P.:</span>
					</div>
					<div class="col-1 border_bottom">
						<span class="valor-campo font_form_valor"><?= mb_strtoupper($general->CP_Det)?></span>
					</div>
					<div class="col-1">
						<span class="font_form_campo">EDAD:</span>
					</div>
					<div class="col-1 border_bottom">
						<span class="valor-campo font_form_valor"><?= $general->Edad_Det?></span>
					</div>
					<div class="col-1">
						<span class="font_form_campo">SEXO:</span>
					</div>
					<div class="col-1 border_bottom">
						<span class="valor-campo font_form_valor"><?= mb_strtoupper($general->Genero_Det)?></span>
					</div>
					<div class="col-2">
						<span class="font_form_campo">ESCOLARIDAD:</span>
					</div>
					<div class="col-2 border_bottom">
						<span class="valor-campo font_form_valor"><?= mb_strtoupper($general->Escolaridad_Det)?></span>
					</div>
				</div>
			</div>
		</div>
		<!--PETICIONARIO-->
		<div class="row mt-2">
			<div class="col-12 text-center">
				<h6>PETICIONARIO</h6>
			</div>
			<div class="col-12 mi_border_1 py-3">
				<div class="row">
					<div class="col-2">
						<span class="campo">
							<span class="font_form_campo">NOMBRE:</span>
						</span>
					</div>
					<div class="col-10 border_bottom">
						<span class="valor-campo font_form_valor"><?= mb_strtoupper($general->Nombre_Peticionario)?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-2">
						<span class="font_form_campo">CALLE:</span>
					</div>
					<div class="col-3 border_bottom">
						<span class="valor-campo font_form_valor"><?= mb_strtoupper($general->Calle_Petic)?></span>
					</div>
					<div class="col-1">
						<span class="font_form_campo">NÚM:</span>
					</div>
					<div class="col-2 border_bottom">
						<span class="valor-campo font_form_valor"><?= mb_strtoupper($general->No_Ext_Petic)?></span>
					</div>
					<div class="col-1">
						<span class="font_form_campo">COL:</span>
					</div>
					<div class="col-3 border_bottom">
						<span class="valor-campo font_form_valor"><?= mb_strtoupper($general->Colonia_Petic)?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-1">
						<span class="font_form_campo">CIUDAD:</span>
					</div>
					<div class="col-1 border_bottom">
						<span class="valor-campo font_form_valor"><?= mb_strtoupper($general->Municipio_Petic)?></span>
					</div>
					<div class="col-1">
						<span class="font_form_campo">C.P.:</span>
					</div>
					<div class="col-1 border_bottom">
						<span class="valor-campo font_form_valor"><?= mb_strtoupper($general->CP_Petic)?></span>
					</div>
					<div class="col-1">
						<span class="font_form_campo">EDAD:</span>
					</div>
					<div class="col-1 border_bottom">
						<span class="valor-campo font_form_valor"><?= $general->Edad_Petic?></span>
					</div>
					<div class="col-1">
						<span class="font_form_campo">SEXO:</span>
					</div>
					<div class="col-1 border_bottom">
						<span class="valor-campo font_form_valor"><?= mb_strtoupper($general->Genero_Petic)?></span>
					</div>
					<div class="col-2">
						<span class="font_form_campo">ESCOLARIDAD:</span>
					</div>
					<div class="col-2 border_bottom">
						<span class="valor-campo font_form_valor"><?= mb_strtoupper($general->Escolaridad_Petic)?></span>
					</div>
				</div>
			</div>
		</div>
		<!--UBICACIÓN DE LOS HECHOS-->
		<div class="row mt-2">
			<div class="col-12 text-center">
				<h6>UBICACIÓN DE LOS HECHOS</h6>
			</div>
			<div class="col-12 mi_border_1 py-3">
				<div class="row">
					<div class="col-2">
						<span class="font_form_campo">CALLE 1:</span>
					</div>
					<div class="col-3 border_bottom">
						<span class="valor-campo font_form_valor"><?= mb_strtoupper($general->Calle_1_UH)?></span>
					</div>
					<div class="col-2">
						<span class="font_form_campo">CALLE 2:</span>
					</div>
					<div class="col-3 border_bottom">
						<span class="valor-campo font_form_valor"><?= mb_strtoupper($general->Calle_2_UH)?></span>
					</div>
					<div class="col-1">
						<span class="font_form_campo">NÚM:</span>
					</div>
					<div class="col-1 border_bottom">
						<span class="valor-campo font_form_valor"><?= mb_strtoupper($general->No_Ext_UH)?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-1">
						<span class="font_form_campo">COL:</span>
					</div>
					<div class="col-3 border_bottom">
						<span class="valor-campo font_form_valor"><?= mb_strtoupper($general->Colonia_UH)?></span>
					</div>
					<div class="col-2">
						<span class="font_form_campo">HORA DE LOS HECHOS</span>
					</div>
					<div class="col-2 border_bottom">
						<?php $hora_UH = substr($general->Hora_Reporte_UH,0,5);?>
						<span class="valor-campo font_form_valor"><?= $hora_UH." hrs."?></span>
					</div>
					<div class="col-3">
						<span class="font_form_campo">FALTA ADMINISTRATIVA/DELITO:</span>
					</div>
					<div class="col-1 border_bottom">
						<span class="valor-campo font_form_valor"><?= ($general->Falta_Delito_Tipo == 'F')?'FALTA':'DELITO';?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-1">
						<span class="font_form_campo">MOTIVO:</span>
					</div>
					<div class="col-11 border_bottom">
						<!--
						<span class="valor-campo font_form_valor"><?php echo ucfirst(mb_strtoupper ($general->Remitido_Por));?></span>
						<br>
					-->
						<?php 
						foreach ($delitos as $key => $delito) {
							?>
							<span class="valor-campo font_form_valor"><?php echo ucfirst(mb_strtoupper ($delito->Descripcion));?></span>
							<br>
						<?php 
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<!--OBSERVACIONES-->
		<div class="row mt-2">
			<div class="col-12 text-center">
				<h6>OBSERVACIONES</h6>
			</div>
			<div class="col-12 mi_border_1 py-3" id="id_min_height">
				<div class="row">
					<div class="col-12">
						<!--span class="valor-campo font_form_valor"><?= mb_strtoupper($general->Observaciones_UH)?></span-->
                        <span class="valor-campo font_observaciones">
                            <?= ($general->Alcoholemia)?mb_strtoupper("Con base al dictamen médico clínico-toxicológico que se adjunta a la remisión, se sugiere integrar a la persona a un programa social de rehabilitación contra adicciones que tenga a su alcance."):'';?>
                        </span>
					</div>
				</div>
			</div>
		</div>
		<!--OBJETOS QUE SE ADJUNTAN-->
		<div class="row mt-2">
			<?php
				// $armas_cad = (count($armas) > 0)?'Armas: ':'';
				// $drogas_cad = (count($drogas))?'Drogas: ':'';
				// $objetos_cad = (count($objetos) > 0)?'Objetos: ':'';
				/*Se añaden las impresiones para vehiculos, imitando la forma en que se hizo para armas, drogas y objetos, 
				solo añadiendo el nombre de cada campo para que pueda ser distingible entre cada vehiculo*/
				$armas_cad = '';
				$drogas_cad = '';
				$objetos_cad = '';
				$vehiculos_cad = '';
				foreach ($armas as $key => $value) {
					$armas_cad.= $value->Descripcion_Arma.", ";
				}
				foreach ($drogas as $key => $value) {
					$drogas_cad.= $value->Descripcion_Droga.", ";
				}
				foreach ($objetos as $key => $value) {
					$objetos_cad.= $value->Descripcion_Objeto.", ";
				}
				$i=1;
				foreach ($vehiculos as $key => $value) {
					$vehiculos_cad.= "VEHICULO ".$i.": ";
					$vehiculos_cad.= "PLACA: ";
					$vehiculos_cad.= $value->Placa_Vehiculo.", "?mb_strtoupper($value->Placa_Vehiculo).", ":"";
					$vehiculos_cad.= "MARCA: ";
					$vehiculos_cad.= $value->Marca.", "?mb_strtoupper($value->Marca).", ":"";
					$vehiculos_cad.= "SUBMARCA: ";
					$vehiculos_cad.= $value->Submarca.", "?mb_strtoupper($value->Submarca).",":"";
					$vehiculos_cad.= "TIPO: ";
					$vehiculos_cad.= $value->Tipo_Vehiculo.", "?mb_strtoupper($value->Tipo_Vehiculo).",":"";
					$vehiculos_cad.= "MODELO: ";
					$vehiculos_cad.= $value->Modelo.", "?mb_strtoupper($value->Modelo).",":"";
					$vehiculos_cad.= "COLOR: ";
					$vehiculos_cad.= $value->Color.", "?mb_strtoupper($value->Color).",":"";
					$vehiculos_cad.= "PROCEDENCIA: ";
					$vehiculos_cad.= $value->Procedencia_Vehiculo.", "?mb_strtoupper($value->Procedencia_Vehiculo).",":"";
					$vehiculos_cad.= "NO. SERIE: ";
					$vehiculos_cad.= $value->No_Serie.", "?mb_strtoupper($value->No_Serie).",":"";
					$i++;
				}
				//$objetos_cad .= ($vehiculo_asegurado != '')?mb_strtoupper($vehiculo_asegurado).", ":"";
				
				
				$armas_cad 		= substr($armas_cad,0,-2).". ";
				$drogas_cad 	= substr($drogas_cad,0,-2).". ";
				$objetos_cad 	= substr($objetos_cad,0,-2).". ";
				$vehiculos_cad 	= substr($vehiculos_cad,0,-2).". ";

				$armas_cad 		= ($armas_cad == ". ")?'':$armas_cad;
				$drogas_cad 		= ($drogas_cad == ". ")?'':$drogas_cad;
				$objetos_cad 		= ($objetos_cad == ". ")?'':$objetos_cad;
				$vehiculos_cad 		= ($vehiculos_cad == ". ")?'':$vehiculos_cad;

			?>
			<div class="col-12 text-center">
				<h6>OBJETOS QUE SE ADJUNTAN</h6>
			</div>
			<div class="col-12 mi_border_1 py-3" id="id_min_height">
				<div class="row">
					<div class="col-12">
						<span class="valor-campo font_observaciones">
						<?= $armas_cad.$drogas_cad.$objetos_cad.$vehiculos_cad;?>
						</span>
					</div>
				</div>
			</div>
		</div>
		<!--PERTENENCIAS DEL REMITIDO-->
		<div class="row mt-2">
			<div class="col-12 text-center">
				<h6>PERTENENCIAS DEL REMITIDO</h6>
			</div>
			<div class="col-12 mi_border_1 py-3" id="id_min_height">
				<div class="row">
					<div class="col-12">
						<span class="valor-campo font_observaciones"><?= (isset($general->Pertenencias_Detenido))?$general->Pertenencias_Detenido:'';?></span>
					</div>
				</div>
			</div>
		</div>
		<!--POLICÍAS PREVENTIVOS MUNICIPALES-->
		<div class="row mt-1">
			<div class="col-12 text-center">
				<h6>POLICÍAS PREVENTIVOS MUNICIPALES</h6>
			</div>
			<div class="col-12 mi_border_1 py-3">
				<?php
					$unidad = (isset($elementos[0]->No_Unidad))?$elementos[0]->No_Unidad:'---';
					foreach ($elementos as $key => $elemento) {
						?>
							<div class="row">
								<div class="col-1">
									<span class="font_form_campo">NOMBRE:</span>
								</div>
								<div class="col-3 border_bottom">
									<span class="valor-campo font_form_valor"><?= mb_strtoupper($elemento->Nombre_Elemento)?></span>
								</div>
								<div class="col-1">
									<span class="font_form_campo">CARGO:</span>
								</div>
								<div class="col-1 border_bottom">
									<span class="valor-campo font_form_valor"><?= mb_strtoupper($elemento->Cargo)?></span>
								</div>
								<div class="col-1">
									<span class="font_form_campo">GRUPO:</span>
								</div>
								<div class="col-2 border_bottom">
									<span class="valor-campo font_form_valor"><?= mb_strtoupper($elemento->Sector_Area)?></span>
								</div>
								<div class="col-2">
									<span class="font_form_campo">NÚM. DE CONTROL:</span>
								</div>
								<div class="col-1 border_bottom">
									<span class="valor-campo font_form_valor"><?= mb_strtoupper($elemento->No_Control)?></span>
								</div>
							</div>
						<?php
					}
				?>
				<div class="row">
					<div class="col-3">
						<span class="font_form_campo">NÚM. DE UNIDAD:</span>
					</div>
					<div class="col-3 border_bottom">
						<span class="valor-campo font_form_valor">
							<?php echo mb_strtoupper($unidad);?>	
						</span>
					</div>
					<div class="col-3">
						<span class="font_form_campo">HORA DE REMISIÓN:</span>
					</div>
					<div class="col-3 border_bottom">
						<span class="valor-campo font_form_campo">
							<?= $hora1." hrs."?>
						</span>
					</div>
				</div>
			</div>
		</div>
		<!--FIRMAS-->
		<div class=" row mt-3">
			<div class="col-12 mt-4 mb-2">
				<div class="row">
					<div class="col-4 offset-4 text-center">
						<span class="campo">
							<?= (isset($elemento_guardia->Nombre))?mb_strtoupper($elemento_guardia->Nombre):'';?>
						</span>
					</div>
					<div class="col-4 offset-4 text-center border_top">
						<span class="campo">
							POLICÍA DE GUARDIA EN PREVENCIÓN
						</span>
					</div>
				</div>
			</div>
			<div class="col-12 mt-4">
				<div class="row">
					<div class="col-3 text-center border_top">
						<span class="campo">
							JUZGADO DE JUSTICIA CÍVICA
						</span>
					</div>
					<div class="col-4 offset-1 text-center border_top">
						<span class="campo">
							ZONA, SECTOR O GRUPO ESPECIAL
						</span>
					</div>
					<div class="col-3 offset-1 text-center border_top">
						<span class="campo">
							MINISTERIO PÚBLICO FEDERAL
						</span>
					</div>
				</div>
			</div>
		</div>
		<!--FOOTER-->
		<div class=" row mt-2">
			<div class="col-4">
				<span class="campo font_form_campo">
					AUTORIDAD QUE RECIBE HORA _______
				</span>
			</div>
			<div class="col-4 text-center">
				<span class="campo font_form_campo">
					MINISTERIO PÚBLICO DEL FUERO COMÚN
				</span>
			</div>
			<div class="col-4 text-right">
				<span class="campo font_form_campo">
				<!--FORM.3135-B/SSC1821/0921-->
				<!--FORM.818/SSC/122124-->
				FORM.645/SSC/022224
				</span>
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