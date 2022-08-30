<?php //echo var_dump($data['columns_ED']);?>
<div class="container mt-5 mb-3">
	<div class="row mb-4">
		<button type="button" class="col-auto btn btn-primary mx-auto" data-toggle="modal" data-target="#actualizacionModal">
			<span class="v-a-middle">Da click aquí para saber más sobre la última actualización del sistema</span>
			<span class="v-a-middle material-icons">
			touch_app
			</span>
		</button>
			<!-- Modal Nueva Actualización -->
			<div class="modal fade" id="actualizacionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-body">
							<p>ACTUALIZACIÓN </p>
							<hr>
							<p>Se agregó un nuevo botón CIRCULAR en la parte derecha de la pantalla.</p>
							<p>
								* Al dar click en este botón, se mostrarán los registros de los detenidos que haya capturado Jurídico en las últimas 24 horas 
								(en caso de que no haya registros, se mostrará un mensaje indicando lo mismo).
							</p>
							<p>
								* Si el detenido que llegue aparece en esa lista, puede dar click en la casilla izquierda del mismo para marcarlo
							</p>
							<p>
								* Una vez marcado, puede dar click en el botón rectangular de arriba que dice "Agregar"
							</p>
							<p>
								* Se mostrará una ventana para confirmar su decisión.
							</p>
							<p>
								* Una vez confirmada, se creará un registro con la información previa del detenido que haya capturado Jurídico. 
								Espere un momento, la página se recargará de nuevo para que pueda visualizar, en la lista, el nuevo registro.
							</p>
							<p>
								* Una vez recargada la página, para continuar llenando la información del formulario, dé Click en el ícono de '+' que se encuentra en la parte 
								derecha del registro correspondiente
							</p>
							<p>
								* Continue llenando la información como siempre y listo.
							</p>
							<hr>
							<p>
								NOTA IMPORTANTE:
							</p>
							<p>
								* En caso de que no aparezca el nombre del detenido, en la lista del botón cirular, puede crear la constancia dando click en el botón de siempre que dice 
								"Nueva Constancia" y llenar el formulario como de costumbre.
							</p>
							<p>
								* En caso de que vea, en la lista del botón cirular, nombres duplicados o nombres de detenidos que ya haya creado previamente su constancia, 
								puede eliminarlo dando click en el botón rojo de la derecha. Esto simplemente con el fin de descartar lo que se haya llenado incorrectamente en 
								Jurídico.
							</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						</div>
					</div>
				</div>
			</div>
	</div>
	<div class="row">
		<div class="col-auto mr-auto my-auto">
			<h5 class="title-width my-auto">Constancia de integridad física</h5>
		</div>
		<div class="col-auto my-auto">
			<a class="btn btn-opacity" href="<?= base_url;?>DictamenMedico/nuevoDictamen" >Nueva Constancia</a>
		</div>
	</div>

	<!-- DETENIDOS DESDE JURÍDICO -->
	<div class="detenidos_juridoco_content">
        <button id="button-detenidos-juridico" class="btn btn-primary btn-detenidos-juridico" data-toggle="tooltip" data-placement="right" title="Ver registros juridico">
            <img src="<?= base_url ?>public/media/icons/detenidos.svg" alt="">
        </button>
        <div class="detenidos-content" id="detenidos-content">
            <div class="col-12 my-4" id="feedback_detenidos"></div>
            <button type="button" class="btn btn-sm btn-block btn-primary my-3 button-agregar-detenido" id="button-agregar-detenido" data-id="Dictamen">Agregar</button>
            <div id="detenidos-content-data"></div>
        </div>
    </div>

	<div class="row mt-5">
		<div class="col-6 col-lg-auto mr-lg-auto my-2 my-lg-auto  d-flex justify-content-center">
			
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-filtro" data-toggle="dropdown" id="id_filtros">
				<i class="material-icons md-30 v-a-middle" >filter_alt</i>
				<span class="v-a-middle" >Filtros</span>
			</button>
			<!--Dropdown filter content-->
			<div class="dropdown-menu" aria-labelledby="id_filtros">
			    
				<a class="dropdown-item <?= ($data['filtroActual']==1)?'active':'';?>" href="<?= base_url;?>DictamenMedico/index/?filtro=1">Todos</a>
				<a class="dropdown-item <?= ($data['filtroActual']==2)?'active':'';?>" href="<?= base_url;?>DictamenMedico/index/?filtro=2">Pendientes</a>
				<a class="dropdown-item <?= ($data['filtroActual']==3)?'active':'';?>" href="<?= base_url;?>DictamenMedico/index/?filtro=3">Completados</a>
				<a class="dropdown-item <?= ($data['filtroActual']==4)?'active':'';?>" href="<?= base_url;?>DictamenMedico/index/?filtro=4">Otros</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item <?= ($data['filtroActual']==11)?'active':'';?>" href="#" class="btn btn-filtro" data-toggle="modal" data-target="#filtro_rangos">
					<span class="v-a-middle" >Por rango de fechas</span>
				</a>
			</div>
		</div>
		<div class="col-6 col-lg-auto mr-lg-auto my-2 my-lg-auto  d-flex justify-content-center">
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-filtro" data-toggle="dropdown" id="columnas_filtro">
				<i class="material-icons md-30 v-a-middle" >table_chart</i>
				<span class="v-a-middle" >Columnas</span>
			</button>
			<!--Dropdown filter content-->
			<div id="id_dropdownColumns" class="dropdown-menu" aria-labelledby="columnas_filtro">
				<?= $data['dropdownColumns'];?>
			</div>
		</div>
		<div class="col-12 col-lg-auto mr-lg-auto my-2 my-lg-auto  d-flex justify-content-center">
			<?php $cadena = (isset($data['cadena'])) ? $data['cadena'] : ""; ?>
			<div class="input-group">
				<input id="id_search" type="search" name="busqueda" value="<?= $cadena; ?>" id="busqueda" class="form-control py-2 border-right-0 border" placeholder="Buscar" required="required" aria-describedby="button-addon2" onkeyup="return checarCadena(event)" onchange="return checarCadena(event)">
				<span class="input-group-append">
					<div id="search_button" class="input-group-text bg-transparent"><i class="material-icons md-18 ssc search" id="filtro">search</i></div>
				</span>
			</div>
		</div>
		<div class="col-6 col-lg-auto mr-lg-auto my-auto  d-flex justify-content-center" id="id_total_rows">
			
			Total registros: <?= (isset($data['total_rows']))?$data['total_rows']:"350";?>
		</div>
		<div class="col-6 col-lg-auto mr-lg-auto my-2 my-lg-auto d-flex justify-content-center">
			<div class="row">
				<div id="buttonsExport" class="col-12">
					<?php 
						$cadenaExport = (isset($data['cadena'])) ? ("&cadena=" . $data['cadena']) : "";
						$filtroActual = "&filtroActual=".$data['filtroActual'];
					?>

					<a id="id_link_excel" href="<?= base_url ?>DictamenMedico/exportarInfo/?tipo_export=<?= "EXCEL".$cadenaExport.$filtroActual; ?>" class="btn" data-toggle="tooltip" data-placement="bottom" title="Exportar a Excel">
						<i class="material-icons ssc md-36">description</i>
						<!--img src="<?= base_url ?>public/media/icons/excelIcon.png" width="40px"--!-->
					</a>
					<a id="id_link_pdf" href="<?= base_url ?>DictamenMedico/exportarInfo/?tipo_export=<?= "PDF".$cadenaExport.$filtroActual; ?>" target="_blank" class="btn mi_hide" data-toggle="tooltip" data-placement="bottom" title="Exportar a PDF">
						<i class="material-icons ssc md-36">picture_as_pdf</i>
						<!--img src="<?= base_url ?>public/media/icons/pdfIcon.png" width="40px"--!-->
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="row d-flex justify-content-center mt-3">
		<div class="col-auto">
			<span>Filtro: </span>
			<div class="chip">
				<span class="v-a-middle" >
					<?php
						if (isset($_SESSION['userdata']->rango_inicio_dm)) {
							$r_inicio = $_SESSION['userdata']->rango_inicio_dm;
							$r_fin = $_SESSION['userdata']->rango_fin_dm;
							$r_hora_inicio = $_SESSION['userdata']->rango_hora_inicio_dm;
							$r_hora_fin = $_SESSION['userdata']->rango_hora_fin_dm;
							echo (isset($data['filtroNombre']))?$data['filtroNombre']." | Rangos de (".$r_inicio." ".$r_hora_inicio.") a (".$r_fin." ".$r_hora_fin.")":"Todos";
							 
						}
						else{
							echo (isset($data['filtroNombre']))?$data['filtroNombre']:"Todos";
						}
						
					?>
				</span>
			</div>
			
		</div>
		<?php
			if (isset($_SESSION['userdata']->rango_inicio_dm)) {
				?>
					<a class="btn btn-opacity" href="<?= base_url;?>DictamenMedico/removeRangosFechasSesion/?filtroActual=<?= $data['filtroActual'];?>">mostrar todo</a>
				<?php
			}
		?>
	</div>	
</div>

<!--Tabla con la información-->
	<div class="row d-flex justify-content-center mx-5">
		<div class="col-auto table-responsive ">
			<table class="table table-striped">
				<thead class="thead-myTable text-center">
					<tr id="id_thead" >
						<?php
							//se imprimen los encabezados conforme al catálogo seleccionado 
							echo (isset($data['infoTable']['header']))?$data['infoTable']['header']:"";
						?>
					</tr>
				</thead>
				<tbody id="id_tbody" class="text-justify">
					<?php
						//se imprime todos los registros tabulados de la consulta
						echo (isset($data['infoTable']['body']))?$data['infoTable']['body']:"";
					?>
				</tbody>
			</table>
		</div>
			
	</div>
	
<!--Despliegue de Links de Pagination-->
<div class="container mt-3 mb-5">
	<div class="row d-flex justify-content-center">
		<div class="col-auto">
			<nav aria-label="Page navigation example ">
				<ul id="id_pagination" class="pagination">
					<?php
						echo (isset($data['links']))?$data['links']:"";
					?>
				</ul>
			</nav>
		</div>
	</div>
</div>

<!-- Modals content-->
<div class="modal fade" id="filtro_rangos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
		    <div class="modal-header">
		        <h5 class="title-width" id="exampleModalLabel">Filtrar</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <i class="material-icons">close</i>
		        </button>
		    </div>
		    <div class="modal-body">
		        <div class="container">
		        	<form id="form_rangos" class="row filter-content mb-3" method="post" action="<?= base_url;?>DictamenMedico/index/?filtro=<?= $data['filtroActual']?>">
					<div class="col-3">
		        			<h6>Rango de folios</h6>
		        		</div>
		        		<div class="col-9">
		        			<div class="row">
		        				<div class="col-12 col-md-6">
									<div class="row">
										<div class="col-12">
											<div class="form-group input-group-sm">
												<input type="date" class="form-control" id="id_date_1" name="rango_inicio" aria-describedby="fecha_filtro_1" value="<?= date('Y-m-d')?>" required>
												<small id="fecha_filtro_1" class="form-text text-muted">Fecha inicio</small>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group input-group-sm">
												<input type="time" class="form-control" id="id_time_1" name="rango_hora_inicio" aria-describedby="hora_filtro_1" value="<?= '00:00'?>" required>
												<small id="hora_filtro_1" class="form-text text-muted">Hora inicio</small>
											</div>
										</div>
									</div>
										
		        				</div>
		        				<div class="col-12 col-md-6">
									<div class="row">
										<div class="col-12">
											<div class="form-group input-group-sm">
												<input type="date" class="form-control" id="id_date_2" name="rango_fin" aria-describedby="fecha_filtro_2" value="<?= date('Y-m-d')?>" required>
												<small id="fecha_filtro_2" class="form-text text-muted">Fecha fin</small>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group input-group-sm">
												<input type="time" class="form-control" id="id_time_2" name="rango_hora_fin" aria-describedby="hora_filtro_2" value="<?= '23:59'?>" required>
												<small id="hora_filtro_2" class="form-text text-muted">Hora fin</small>
											</div>
										</div>
									</div>
										
		        				</div>
		        			</div>       
		        		</div>
		        	</form>
		        </div>
		    </div>
		    <div class="modal-footer d-flex justify-content-center">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">cancelar</button>
		        <button type="button" class="btn btn-primary" onclick="return aplicarRangos()">Aplicar</button>
		    </div>
	    </div>
	</div>
</div>

<!--Input de filtro para Fetch busqueda por cadena-->
<input id="filtroActual" type="hidden" value="<?= $data['filtroActual']?>">

