<?php $info_inspeccion = $data['info_inspeccion']; $personas_array = $data['personas_array'];?>
<!--script type="text/javascript">
	var info = '<?php echo json_encode($info_inspeccion);?>';
	alert(info);
</script-->
<div class="container mt-3">
	<!--header con back arrow y título-->
	<div class="row mt-4">
		<div class="col-auto ">
			<a href="<?= base_url;?>Inspecciones" class="btn arrow-back" data-toggle="tooltip" data-placement="top" title="regresar a vista principal">
				<i class="material-icons v-a-middle">arrow_back</i>
			</a>
		</div>
		<div class="col-auto my-0 my-md-auto mx-auto mx-md-0 ml-md-auto mt-2 mt-md-0">
			<div class="col-6 col-md-auto mr-md-auto my-md-auto mb-3 mb-md-0">
	            <div class="row">
	                <div class="col-auto my-auto">
	                    <h5 class="title-width my-auto">Resumen de inspección / </h5>
	                </div>
	                <div class="col-auto my-auto">
	                	<span class="valor-campo">Folio inspección: <?= $info_inspeccion->Id_Inspeccion;?></span>
	                </div>
	            </div>
	        </div>
		</div>
	</div>
	<!--Panel de toda la información-->
	<div class="row mt-4">
		<!--INFO GENERAL-->
		<div class="col-12 col-md-6 mt-3">
			<div class="row">
				<div class="col-12 text-center">
                    <div class="text-divider">
                        <h5>Información general</h5>
                    </div>
                </div>
				<div class="col-12 table-responsive">
					<table class="table table-sm table-bordered">
						<tbody>
							<tr>
                				<td>
                					<span class="campo">Grupo que solicita: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_inspeccion->Grupo);?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Zona / Sector: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_inspeccion->Zona_Sector);?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Solicitante: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_inspeccion->Quien_Solicita);?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Nombre completo solicitante: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_inspeccion->Clave_Num_Solicitante);?></span>
                				</td>
                			</tr>
							<tr>
                				<td>
                					<span class="campo">Unidad: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_inspeccion->Unidad);?></span>
                				</td>
                			</tr>
							<tr>
                				<td>
                					<span class="campo">Teléfono/Radio: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_inspeccion->Telefono_Radio);?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Fecha inspección: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_inspeccion->Fecha);?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Hora inspección: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= $info_inspeccion->Hora;?></span>
                				</td>
                			</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!--UBICACIÓN-->
		<div class="col-12 col-md-6 mt-3">
			<div class="row">
				<div class="col-12 text-center">
                    <div class="text-divider">
                        <h5>Ubicación</h5>
                    </div>
                </div>
				<div class="col-12 table-responsive">
					<table class="table table-sm table-bordered">
						<tbody>
							<tr>
                				<td>
                					<span class="campo">Calles: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_inspeccion->Calle_1." y ".$info_inspeccion->Calle_2);?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Núm. exterior: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_inspeccion->No_Ext);?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Núm. interior: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_inspeccion->No_Int);?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Colonia: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= mb_strtoupper($info_inspeccion->Colonia);?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Coordenada X: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= $info_inspeccion->Coordenada_X;?></span>
                				</td>
                			</tr>
                			<tr>
                				<td>
                					<span class="campo">Coordenada Y: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= $info_inspeccion->Coordenada_Y;?></span>
                				</td>
                			</tr>
							<tr>
                				<td>
                					<span class="campo">Codigo postal: </span>
                				</td>
                				<td>
                					<span class="valor-campo"><?= $info_inspeccion->CP;?></span>
                				</td>
                			</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!--PERSONA-->
		<div class="col-12 col-md-6 mt-3">
			<div class="row">
				<div class="col-12 text-center">
                    <div class="text-divider">
                        <h5>Persona(s) inspeccionada(s)</h5>
                    </div>
                </div>
				<div class="col-12 table-responsive">
					<?php
						if (isset($info_inspeccion->Nombre_Inspeccionado)) {
							?>
								<table class="table table-sm table-bordered">
									<thead>
										<th>#</th>
										<th>Nombre completo</th>
										<th>Alias</th>
										<th>Fecha de nacimiento</th>
									</thead>
									<tbody>
										<?php 
											foreach ($personas_array as $key => $persona) {
												?>
													<tr>
														<td><?= ($key+1)?></td>
														<td><?= mb_strtoupper($persona->Nombre_Inspeccionado)?></td>
														<td><?= mb_strtoupper($persona->Alias)?></td>
														<td><?= ($persona->Fecha_Nacimiento)?$persona->Fecha_Nacimiento:'--';?></td>
													</tr>
												<?php
											}
										?>
									</tbody>
								</table>
							<?php
						}
						else{
							?>
								<div class="row mt-4">
									<div class="col-12 text-center">
										<span class="campo text-center">Sin información de persona</span>	
									</div>
									
								</div>
							<?php
						}
					?>
								
				</div>
			</div>
		</div>
		<!--VEHICULO-->
		<div class="col-12 col-md-6 mt-3">
			<div class="row">
				<div class="col-12 text-center">
                    <div class="text-divider">
                        <h5>Vehículo inspeccionado</h5>
                    </div>
                </div>
				<div class="col-12 table-responsive">
					<?php
						if (isset($info_inspeccion->Marca)) {
							?>
								<table class="table table-sm my-border-table">
									<tbody>
									<tr>
			                				<td>
			                					<span class="campo">Tipo: </span>
			                				</td>
			                				<td>
			                					<span class="valor-campo"><?= mb_strtoupper($info_inspeccion->Tipo);?></span>
			                				</td>
			                			</tr>
										<tr>
			                				<td>
			                					<span class="campo">Marca: </span>
			                				</td>
			                				<td>
			                					<span class="valor-campo"><?= mb_strtoupper($info_inspeccion->Marca);?></span>
			                				</td>
			                			</tr>
										<tr>
			                				<td>
			                					<span class="campo">Submarca: </span>
			                				</td>
			                				<td>
			                					<span class="valor-campo"><?= mb_strtoupper($info_inspeccion->Submarca);?></span>
			                				</td>
			                			</tr>
			                			<tr>
			                				<td>
			                					<span class="campo">Modelo: </span>
			                				</td>
			                				<td>
			                					<span class="valor-campo"><?= mb_strtoupper($info_inspeccion->Modelo);?></span>
			                				</td>
			                			</tr>
										<tr>
			                				<td>
			                					<span class="campo">Color: </span>
			                				</td>
			                				<td>
			                					<span class="valor-campo"><?= mb_strtoupper($info_inspeccion->Color);?></span>
			                				</td>
			                			</tr>
			                			<tr>
			                				<td>
			                					<span class="campo">Placas: </span>
			                				</td>
			                				<td>
			                					<span class="valor-campo"><?= mb_strtoupper($info_inspeccion->Placas_Vehiculo);?></span>
			                				</td>
			                			</tr>
										<tr>
			                				<td>
			                					<span class="campo">NIV: </span>
			                				</td>
			                				<td>
			                					<span class="valor-campo"><?= mb_strtoupper($info_inspeccion->NIV);?></span>
			                				</td>
			                			</tr>
			                			<tr>
			                				<td>
			                					<span class="campo">Colocación placas: </span>
			                				</td>
			                				<td>
			                					<span class="valor-campo"><?= mb_strtoupper($info_inspeccion->Colocacion_Placa);?></span>
			                				</td>
			                			</tr>
										
									</tbody>
								</table>
							<?php
						}
						else{
							?>
								<div class="row mt-4">
									<div class="col-12 text-center">
										<span class="campo text-center">Sin información de vehículo</span>	
									</div>
									
								</div>
							<?php
						}
					?>
								
				</div>
			</div>
		</div>
		<!--IMÁGENES-->
		<div class="col-12 mt-2">
			<div class="row">
				<div class="col-12 text-center">
					<div class="text-divider">
						<h5>Imágenes</h5>
					</div>
				</div>

				<div class="col-12">
					<div class="row">
						<?php
							if (isset($info_inspeccion->Imagenes_Inspeccion)) {
									$ruta = PATH_INSP_FILES.$info_inspeccion->Id_Inspeccion;
									$ruta2 = BASE_INSP_FILES.$info_inspeccion->Id_Inspeccion;

									foreach ($info_inspeccion->Urls_Images as $url_image) {
										if (file_exists($ruta2.'/'.$url_image->Path_Imagen)) { //si existe el archivo se carga imagen
							               	?>
							               		<div class="col-auto">
							               			<div class="preview">
							               				<img src="<?= $ruta.'/'.$url_image->Path_Imagen?>">
							               			</div>
							               		</div>
											<?php 
							            }
									}
							}
							else{
								?>
									<div class="row mt-4">
										<div class="col-12 text-center">
											<span class="campo text-center">Sin imágenes</span>	
										</div>
									</div>
								<?php
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<!--RETURN BUTTON-->
		<div class="col-auto mx-auto mt-5">
			<a href="<?= base_url;?>Inspecciones" class="btn btn-secondary">
				regresar
			</a>
		</div>
		<!--FECHA CREACIÓN-->
		<div class="col-12 mt-4 mb-5">
        	<div class="card">
			  <div class="card-body text-center">
			    <span class="valor-campo">
			    	Registrado el <?= $info_inspeccion->Fecha2;?>, <?= $info_inspeccion->Hora2;?>
			    </span>
			  </div>
			</div>
        </div>
	</div>
</div>