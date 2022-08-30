<?php
	//var_dump($data['info_dictamen']);
	$info_dictamen = $data['info_dictamen'];
?>
<div class="container">

	<!--header con back arrow y título-->
	<div class="row my-5">
		<div class="col-auto ">
			<a href="<?= base_url;?>DictamenMedico" class="btn arrow-back" data-toggle="tooltip" data-placement="top" title="regresar a vista principal">
				<i class="material-icons v-a-middle">arrow_back</i>
			</a>
		</div>
		<div class="col-auto my-0 my-md-auto mx-auto mx-md-0 ml-md-auto mt-2 mt-md-0">
			<div class="col-6 col-md-auto mr-md-auto my-md-auto mb-3 mb-md-0">
	            <div class="row">
	                <div class="col-auto my-auto">
	                    <h5 class="title-width my-auto">Resumen de dictamen médico / </h5>
	                </div>
	                <div class="col-auto my-auto">
	                	<span class="valor-campo">Folio <?= $info_dictamen->Id_Dictamen;?></span>
	                </div>
	            </div>
	        </div>
			
			
		</div>
	</div>

	<!--Fecha hora e instancia-->
    <div class="row mt-5">

        <div class="col-6 col-md-auto mr-md-auto my-md-auto mb-3 mb-md-0">
            <div class="row">
                <div class="col-auto my-auto">
                    <span class="campo">Fecha: </span>
                </div>
                <div class="col-auto my-auto">
                	<span class="valor-campo"><?= mb_strtoupper($info_dictamen->Fecha1)?></span>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-auto mx-md-auto my-md-auto mb-3 mb-md-0">
            <div class="row">
                <div class="col-auto my-auto">
                    <span class="campo">Hora: </span>
                </div>
                <div class="col-auto my-auto">
                	<span class="valor-campo"><?= mb_strtoupper($info_dictamen->Hora1)?> hrs.</span>
                </div>
            </div>   
        </div>

        <div class="col-12 col-md-auto my-auto ml-auto">
            <div class="form-group row my-auto ml-auto">
                <div class="form-check col-auto">
                  <span  > Remitido a: </span>
                </div>
                <div class="form-check col-auto">
                  <span  id="id_instancia_1"> <?= $info_dictamen->Instancia?></span>
                </div>
            </div>  
        </div>
    </div>

    <!--formulario completo-->
    <div class="row">

        <!--DATOS GENERALES del detenido-->
        <div class="col-12 col-md-6">
            <div class="row">
                <div class="col-12 text-center mt-5 mb-2">
                    <div class="text-divider">
                        <h5>Datos generales del examinado</h5>
                    </div>
                </div>

                <div class="col-12 table-responsive">
                	<table class="table table-sm my-border-table">
                		<tbody>
                			<tr>
                				<td>
                					<span class="campo">Nombre: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_dictamen->Nombre_Completo_Detenido)?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Ocupación: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_dictamen->Ocupacion)?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Género: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= (mb_strtoupper($info_dictamen->Genero) == 'H')?'HOMBRE':'MUJER';;?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Domicilio: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_dictamen->Domicilio)?></span>
                				</td>
                			</tr>
                            <tr>
                                <td>
                                    <span class="campo">Médico : </span>
                                </td>
                                <td>
                                    <span class="valor-campo"><?= mb_strtoupper($info_dictamen->Nombre_Medico)?></span>
                                </td>
                            </tr>
                		</tbody>
                	</table>
                    
                </div>
            </div>
        </div>
        <!--ELEMENTO PARTICIPANTE-->
        <div class="col-12 col-md-6">
            <div class="row">
                <div class="col-12 text-center mt-5 mb-2">
                    <div class="text-divider">
                        <h5>Elemento participante</h5>
                    </div>
                </div>

                <div class="col-12 table-responsive">
                	<table class="table table-sm my-border-table">
                		<tbody>
                			<tr>
                				<td>
                					<span class="campo">Nombre elemento: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_dictamen->Nombre_Completo_Elemento)?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Placa: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= $info_dictamen->Placa_E;?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Unidad: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_dictamen->Unidad_E)?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Cargo: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_dictamen->Cargo_E)?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Sector/Área: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_dictamen->Sector_Area_E)?></span>
                				</td>
                			</tr>
                		</tbody>
                	</table>
                    
                </div>
            </div>
        </div>

        <!--ANTECEDENTES-->
        <div class="col-12 col-md-6">
            <div class="row">
                <div class="col-12 text-center mt-3 mb-2">
                    <div class="text-divider">
                        <h5>Antecedentes</h5>
                    </div>
                </div>

                <div class="col-12">
                	<table class="table table-sm my-border-table">
                		<tbody>
                			<tr>
                				<td>
                					<span class="campo">Enfermedades: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper(($info_dictamen->Enfermedades_Padece != ''))?mb_strtoupper($info_dictamen->Enfermedades_Padece):'NO PADECE ENFERMEDADES';?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Medicamentos: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper(($info_dictamen->Medicamentos_Toma != ''))?mb_strtoupper($info_dictamen->Medicamentos_Toma):'NO TOMA MEDICAMENTOS';?></span>
                				</td>
                			</tr>
                		</tbody>
                	</table>
                </div>     
            </div>
        </div>

        <!--PRUEBAS REALIZADAS-->
        <div class="col-12 col-md-6">
            <div class="row">
                <div class="col-12 text-center mt-3 mb-2">
                    <div class="text-divider">
                        <h5>Pruebas realizadas</h5>
                    </div>
                </div>

                <div class="col-12">
                	<table class="table table-sm my-border-table">
                		<tbody>
                			<tr>
                				<td>
                					<span class="campo">Alcohólimetro: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= ($info_dictamen->Prueba_Alcoholimetro)?'SÍ':'NO';?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Multitestdrog: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= ($info_dictamen->Prueba_Multitestdrog)?'SÍ':'NO';?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Clínica: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= ($info_dictamen->Prueba_Clinica)?'SÍ':'NO';?></span>
                				</td>
                			</tr>
                		</tbody>
                	</table>
                </div>     
            </div>
        </div>

        <!--INTERROGATORIO-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-3 mb-2">
                    <div class="text-divider">
                        <h5>Interrogatorio</h5>
                    </div>
                </div>

                <div class="col-12 col-md-auto mx-0 mx-md-auto">
                	<table class="table table-sm my-border-table">
                		<tbody>
                			<tr>
                				<td>
                					<span class="campo">¿Cooperó con interrogatorio?: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= ($info_dictamen->Coopera_Interrogatorio)?'SÍ':'NO';?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">¿Tomó alguna sustancia?: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= ($info_dictamen->Sustancia_Consumida != '')?'SÍ':'NO';?></span>
                				</td>
                			</tr>
          
                		</tbody>
                	</table>
                </div>
                <div class="col-12 col-md-auto mx-0 mx-md-auto <?= ($info_dictamen->Sustancia_Consumida != '')?'':'mi_hide';?>">
                	<table class="table table-sm my-border-table">
                		<tbody>
                			<tr>
                                <?php
                                    $sustanciasCad = '';
                                    $auxSustancia = str_split($info_dictamen->Sustancia_Bit);
                                    foreach ($auxSustancia as $key => $value) {
                                        switch ($key) {
                                            case '0':
                                                if ($value)
                                                    $sustanciasCad .= 'Alcohol , ';
                                            break;
                                            case '1':
                                                if ($value)
                                                    $sustanciasCad .= 'Droga , ';
                                            break;
                                            case '2':
                                                if ($value)
                                                    $sustanciasCad .= 'Inhalantes , ';
                                            break;
                                        }
                                    }
                                    $sustanciasCad = substr($sustanciasCad, 0, -2);
                                ?>
                				<td>
                					<span class="campo">Sustancia consumida: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($sustanciasCad)?></span>
                				</td>
                			</tr>
							<?php
								$fecha2 = '';
								$hora2  = '';
								if(isset($info_dictamen->Fecha_Hora_Consumo) && strlen($info_dictamen->Fecha_Hora_Consumo) == 16){ //ambos
									$auxFecha2 = explode(" ", $info_dictamen->Fecha_Hora_Consumo);
									$fecha2 = $auxFecha2[0];
									$hora2  = substr($auxFecha2[1],0,5).'hrs';
								}
								else if(strlen($info_dictamen->Fecha_Hora_Consumo) == 10){//solo fecha
									$fecha2 = $info_dictamen->Fecha_Hora_Consumo;
								}
								else if(strlen($info_dictamen->Fecha_Hora_Consumo) == 5){//solo hora
									$hora2  = $info_dictamen->Fecha_Hora_Consumo;
								}

							?>
                			<tr>
                				<td>
                					<span class="campo">Fecha consumo: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= $info_dictamen->Sustancia_Consumida != ''?mb_strtoupper($fecha2):''?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Hora consumo: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= $info_dictamen->Sustancia_Consumida != ''?mb_strtoupper($hora2):'';?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Cantidad consumida: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= ($info_dictamen->Sustancia_Consumida != '')?mb_strtoupper($info_dictamen->Cantidad_Consumida):'';?></span>
                				</td>
                			</tr>
                		</tbody>
                	</table>
                </div>     
            </div>
        </div>

        <!--INTOXICACIÓN ETÍLICA-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-3 mb-2">
                    <div class="text-divider">
                        <h5>Intoxicación etílica</h5>
                    </div>
                </div>
                <?php
                	$IE = [	'Aliento alcohólico',
							'Rubor facial',
							'Euforia',
							'Estupor',
							'Actitud discutiría',
							'Exageración de la conducta',
							'Incoordinación leve',
							'Afectación del habla',
							'Habla en tono elevado',
							'Actitud agresiva',
							'Conducta irresponsable',
							'Dificultad al estar de pie',
							'Se mueve con ayuda'
						];
                ?>
                <div class="col-6 col-md-auto mx-auto">
                	<table class="table table-sm my-border-table">
                		<tbody>
                			<?php
                				$intoxicacion = str_split($info_dictamen->Intoxicacion_Etilica_Bit);
                				$intoxicacion = array_reverse($intoxicacion);
                				for($i=0 ; $i<5 ; $i++) {
                					if ($intoxicacion[$i]) {
                						?>
                							<tr>
				                				<td>
				                					<span class="valor-campo"><?= mb_strtoupper($IE[$i])?></span>
				                				</td>
				                			</tr>
                						<?php
                					}
                					else{
                						?>
                							<tr>
				                				<td>
				                					<span class="text-disabled"><?= mb_strtoupper($IE[$i])?></span>
				                				</td>
				                			</tr>
                						<?php
                					}
                				}
                			?>
                		</tbody>
                	</table>
                </div>
                <div class="col-6 col-md-auto mx-auto">
                	<table class="table table-sm my-border-table">
                		<tbody>
                			<?php
                				for($i=5 ; $i<9 ; $i++) {
                					if ($intoxicacion[$i]) {
                						?>
                							<tr>
				                				<td>
				                					<span class="valor-campo"><?= mb_strtoupper($IE[$i])?></span>
				                				</td>
				                			</tr>
                						<?php
                					}
                					else{
                						?>
                							<tr>
				                				<td>
				                					<span class="text-disabled"><?= mb_strtoupper($IE[$i])?></span>
				                				</td>
				                			</tr>
                						<?php
                					}
                				}
                			?>
                		</tbody>
                	</table>
                </div>
                <div class="col-6 col-md-auto mx-auto">
                	<table class="table table-sm my-border-table">
                		<tbody>
                			<?php
                				for($i=9 ; $i<13 ; $i++) {
                					if ($intoxicacion[$i]) {
                						?>
                							<tr>
				                				<td>
				                					<span class="valor-campo"><?= mb_strtoupper($IE[$i])?></span>
				                				</td>
				                			</tr>
                						<?php
                					}
                					else{
                						?>
                							<tr>
				                				<td>
				                					<span class="text-disabled"><?= mb_strtoupper($IE[$i])?></span>
				                				</td>
				                			</tr>
                						<?php
                					}
                				}
                			?>
                		</tbody>
                	</table>
                </div>   
            </div>
        </div>

        <!--NIVEL DE CONCIENCIA-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-3 mb-2">
                    <div class="text-divider">
                        <h5>Nivel de conciencia</h5>
                    </div>
                </div>
                <!--Estado de conciencia-->
                <div class="col-6 col-md-auto mx-auto">
                	<table class="table table-sm my-border-table">
                		<tbody>
                			<tr>
                				<td>
                					<span class="campo">Estado conciencia: </span>
                				</td>
                			</tr>
							<tr>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_dictamen->Estado_Conciencia)?></span>
                				</td>
                			</tr>
                		</tbody>
                	</table>
                </div>
                <!--Orientación-->
                <?php
                	$Orient = 	[	'Persona',
									'Tiempo',
									'Espacio'
								];
                ?>
                <div class="col-6 col-md-auto mx-auto">
                	<table class="table table-sm my-border-table">
                		<tbody>
                			<tr>
                				<td>
                					<span class="campo">Orientación:</span>
                				</td>
                			</tr>
                			<?php
                				$orient = str_split($info_dictamen->Orientacion_Bit);
                				$orient = array_reverse($orient);


                				foreach($orient as $ind => $valor) {
                					if ($orient[$ind]) {
                						?>
                							<tr>
				                				<td>
				                					<span class="valor-campo"><?= mb_strtoupper($Orient[$ind])?></span>
				                				</td>
				                			</tr>
                						<?php
                					}
                					else{
                						?>
                							<tr>
				                				<td>
				                					<span class="text-disabled"><?= mb_strtoupper($Orient[$ind])?></span>
				                				</td>
				                			</tr>
                						<?php
                					}
                				}
                			?>
                		</tbody>
                	</table>
                </div>
                <!--Actitud-->
                <div class="col-6 col-md-auto mx-auto">
                	<table class="table table-sm my-border-table">
                		<tbody>
                			<tr>
                				<td>
                					<span class="campo">Actitud: </span>
                				</td>
                			</tr>
							<tr>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_dictamen->Actitud)?></span>
                				</td>
                			</tr>
                		</tbody>
                	</table>
                </div>
                <!--Lenguaje-->
                <div class="col-6 col-md-auto mx-auto">
                	<table class="table table-sm my-border-table">
                		<tbody>
                			<tr>
                				<td>
                					<span class="campo">Lenguaje: </span>
                				</td>
                			</tr>
                            <?php
                                $lenguaje_aux = str_split($info_dictamen->Lenguaje_Bit);
                                $cad_lenguaje = '';
                                foreach($lenguaje_aux as $ind => $value) {
                                    switch ($ind) {
                                        case '0':
                                            if ($value)
                                                $cad_lenguaje .= 'Normal , ';
                                        break;
                                        case '1':
                                            if ($value)
                                                $cad_lenguaje .= 'Disartría , ';
                                        break;
                                        case '2':
                                            if ($value)
                                                $cad_lenguaje .= 'Verborreico , ';
                                        break;
                                        case '3':
                                            if ($value)
                                                $cad_lenguaje .= 'Incoherente , ';
                                        break;
                                    }
                                }
                                $cad_lenguaje = substr($cad_lenguaje, 0, -2);
                            ?>
							<tr>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($cad_lenguaje)?></span>
                				</td>
                			</tr>
                		</tbody>
                	</table>
                </div>
            </div>
        </div>

        <!--EXPLORACIÓN FÍSICA-->
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-3 mb-2">
                    <div class="text-divider">
                        <h5>Exploración física</h5>
                    </div>
                </div>
                <!--Facies-->
                <div class="col-6 col-md-auto mx-auto">
                	<table class="table table-sm my-border-table">
                		<tbody>
                			<tr>
                				<td>
                					<span class="campo">Facies: </span>
                				</td>
                			</tr>
							<tr>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_dictamen->Fascies)?></span>
                				</td>
                			</tr>
                		</tbody>
                	</table>
                </div>
                <!--Conjuntivas-->
                <div class="col-6 col-md-auto mx-auto">
                	<table class="table table-sm my-border-table">
                		<tbody>
                			<tr>
                				<td>
                					<span class="campo">Conjuntivas: </span>
                				</td>
                			</tr>
							<tr>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_dictamen->Conjuntivas)?></span>
                				</td>
                			</tr>
                		</tbody>
                	</table>
                </div>
                <!--Pupilas-->
                <div class="col-6 col-md-auto mx-auto">
                	<table class="table table-sm my-border-table">
                		<tbody>
                			<tr>
                				<td>
                					<span class="campo">Pupilas: </span>
                				</td>
                			</tr>
							<tr>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_dictamen->Pupilas)." - ".mb_strtoupper($info_dictamen->Pupilas2)?></span>
                				</td>
                			</tr>
                		</tbody>
                	</table>
                </div>
                <!--Mucosa oral-->
                <div class="col-6 col-md-auto mx-auto">
                	<table class="table table-sm my-border-table">
                		<tbody>
                			<tr>
                				<td>
                					<span class="campo">Mucosa oral: </span>
                				</td>
                			</tr>
							<tr>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_dictamen->Mucosa_Oral)?></span>
                				</td>
                			</tr>
                		</tbody>
                	</table>
                </div>
                <!--Aliento-->
                <div class="col-6 col-md-auto mx-auto">
                	<table class="table table-sm my-border-table">
                		<tbody>
                			<tr>
                				<td>
                					<span class="campo">Aliento: </span>
                				</td>
                			</tr>
							<tr>
                                <?php
                                    $alientoCad = '';
                                    $auxAliento = str_split($info_dictamen->Aliento_Bit);
                                    foreach ($auxAliento as $key => $value) {
                                        switch ($key) {
                                            case '0':
                                                if ($value)
                                                    $alientoCad .= 'Alcohol , ';
                                            break;
                                            case '1':
                                                if ($value)
                                                    $alientoCad .= 'Solventes , ';
                                            break;
                                            case '2':
                                                if ($value)
                                                    $alientoCad .= 'Cannabis , ';
                                            break;
                                        }
                                    }
                                    $alientoCad = substr($alientoCad, 0, -2);
                                ?>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($alientoCad)?></span>
                				</td>
                			</tr>
                		</tbody>
                	</table>
                </div>
            </div>
        </div>

        <!--HERIDAS / LESIONES-->
        <div class="col-12 col-md-6">
            <div class="row">
                <div class="col-12 text-center mt-3 mb-2">
                    <div class="text-divider">
                        <h5>Heridas / lesiones</h5>
                    </div>
                </div>
                <!--Heridas/lesiones-->
                <div class="col-12">
                	<table class="table table-sm my-border-table">
                		<tbody>
							<tr>
                				<td class="text-center">
                					<span class="valor-campo"><?= mb_strtoupper($info_dictamen->Heridas_Lesiones)?></span>
                				</td>
                			</tr>
                		</tbody>
                	</table>
                </div>
            </div>
        </div>

        <!--OBSERVACIONES-->
        <div class="col-12 col-md-6">
            <div class="row">
                <div class="col-12 text-center mt-3 mb-2">
                    <div class="text-divider">
                        <h5>Observaciones</h5>
                    </div>
                </div>
                <!--Heridas/lesiones-->
                <div class="col-12">
                	<table class="table table-sm my-border-table">
                		<tbody>
							<tr>
                				<td class="text-center">
                					<span class="valor-campo"><?= mb_strtoupper($info_dictamen->Observaciones)?></span>
                				</td>
                			</tr>
                		</tbody>
                	</table>
                </div>
            </div>
        </div>

        <!--DIAGNÓSTICO-->
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-12 text-center mt-3 mb-2">
                    <div class="text-divider">
                        <h5>Diagnóstico</h5>
                    </div>
                </div>
                <!--Diagnóstico-->
                <div class="col-12">
                	<table class="table table-sm my-border-table">
                		<tbody>
							<tr>
                				<td class="text-center">
                					<span class="valor-campo"><?= mb_strtoupper($info_dictamen->Diagnostico)?></span>
                				</td>
                			</tr>
                		</tbody>
                	</table>
                </div>
            </div>
        </div>

        <!--Back button-->
        <div class="col-auto mx-auto mb-3">
        	<a href="<?= base_url;?>DictamenMedico" class="btn back-btn">regresar</a>
        </div>
        <!--Footer dictamen-->
        <div class="col-12 mb-5">
        	<div class="card">
			  <div class="card-body text-center">
			    <span class="valor-campo">
			    	REGISTRADO EL <?= mb_strtoupper($info_dictamen->Fecha3)?>, <?= mb_strtoupper($info_dictamen->Hora3)?>
			    </span>
			  </div>
			</div>
        </div>
        
    </div>

</div>