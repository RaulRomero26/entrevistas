<?php //echo var_dump($data['columns_ED']);?>
<div class="container mt-5 mb-3">
	<div class="row">
		<div class="col-auto mr-auto my-auto">
			<h5 class="title-width my-auto">Jurídico</h5>
		</div>
		<div class="col-auto ml-auto my-auto mi_hide">
			<button class="btn btn-opacity" data-toggle="modal" data-target=".bd-example-modal-lg">
				Estadística
			</button>
		</div>
		<div class="col-auto my-auto">
            <button type="button" class="btn btn-opacity" data-toggle="modal" data-target="#nuevaRegistroJuridico">
                Nueva
            </button>
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
			    
				<a class="dropdown-item <?= ($data['filtroActual']==1)?'active':'';?>" href="<?= base_url;?>Juridico/index/?filtro=1">Todos</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#" class="btn btn-filtro" data-toggle="modal" data-target="#filtro_rangos">
					<span class="v-a-middle" >Por fecha y hora</span>
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
			
			<h5>Total registros: <?= (isset($data['total_rows']))?$data['total_rows']:"---";?></h5>
		</div>
		<div class="col-6 col-lg-auto mr-lg-auto my-2 my-lg-auto d-flex justify-content-center">
			<div class="row">
				<div id="buttonsExport" class="col-12">
					<?php 
						$cadenaExport = (isset($data['cadena'])) ? ("&cadena=" . $data['cadena']) : "";
						$filtroActual = "&filtroActual=".$data['filtroActual'];
					?>

					<a id="id_link_excel" href="<?= base_url ?>Juridico/exportarInfo/?tipo_export=<?= "EXCEL".$cadenaExport.$filtroActual; ?>" class="btn" data-toggle="tooltip" data-placement="bottom" title="Exportar a Excel">
						<i class="material-icons ssc md-36">description</i>
						<!--img src="<?= base_url ?>public/media/icons/excelIcon.png" width="40px"--!-->
					</a>
					<a id="id_link_pdf" href="<?= base_url ?>Juridico/exportarInfo/?tipo_export=<?= "PDF".$cadenaExport.$filtroActual; ?>" target="_blank" class="btn mi_hide" data-toggle="tooltip" data-placement="bottom" title="Exportar a PDF">
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
						if (isset($_SESSION['userdata']->rango_inicio_jur)) {
							$r_inicio = $_SESSION['userdata']->rango_inicio_jur;
							$r_fin = $_SESSION['userdata']->rango_fin_jur;
							$r_hora_inicio = $_SESSION['userdata']->rango_hora_inicio_jur;
							$r_hora_fin = $_SESSION['userdata']->rango_hora_fin_jur;
							echo (isset($data['filtroNombre']))?$data['filtroNombre']." | Rangos de (".$r_inicio." ".$r_hora_inicio.") a (".$r_fin." ".$r_hora_fin.")":"Vista general";
							 
						}
						else{
							echo (isset($data['filtroNombre']))?$data['filtroNombre']:"Vista general";
						}
						
					?>
				</span>
			</div>
			
		</div>
		<?php
			if (isset($_SESSION['userdata']->rango_inicio_jur)) {
				?>
					<a class="btn btn-opacity" href="<?= base_url;?>Juridico/removeRangosFechasSesion/?filtroActual=<?= $data['filtroActual'];?>">mostrar todo</a>
				<?php
			}
		?>
	</div>	
</div>

<!--Tabla con la información-->
<!-- <div class="container"> -->
	<div class="row d-flex justify-content-center mx-5">
		<div class="col-auto table-responsive">
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
	
<!-- </div> -->
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

<!-- Modal de Rango de Fechas y Horas-->
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
		        	<form id="form_rangos" class="row filter-content mb-3" method="post" action="<?= base_url;?>Juridico/index/?filtro=<?= $data['filtroActual']?>">
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
		        <button type="button" class="btn btn-ssc" onclick="return aplicarRangos()">Aplicar</button>
		    </div>
	    </div>
	</div>
</div>

<!--Input de filtro para Fetch busqueda por cadena-->
<input id="filtroActual" type="hidden" value="<?= $data['filtroActual']?>">


<!-- MODAL DE GRÁFICAS -->


<!-- Modal para nueva -->
<div class="modal fade" id="nuevaRegistroJuridico" tabindex="-1" aria-labelledby="nuevaRegistroJuridicoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="title-fieldset">Paso 1: Buscar elemento</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="container">
                <form id="data_elemento" onsubmit="event.preventDefault();">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Ingrese el número de control, placa o apellidos del elemento." aria-describedby="button-addon2" name="input-search-element" id="input-search-element">
                        <div class="input-group-append" id="content-button-search">
                            <button id="btn-search-element" class="btn btn-outline-secondary" type="button">Buscar</button>
                        </div>
                    </div>
                    <span class="span_error" id="error-search-element"></span>
                </form>
				<div class="col-12" id="list-group-elementos-label">
					<label class="label-form text-center mt-2">Se encontraron varios registros con esas especificaciones. Seleccione el correcto.</label>
				</div>
				<div class="col-lg-12 text-center mt-2" id="formManualContent">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="formManual">
						<label class="form-check-label" for="formManual">
							Llenado manual
						</label>
					</div>
				</div>
				<div class="list-group" id="list-group-elementos">
				</div>
                <form id="content-elementos" onsubmit="event.preventDefault();">
                    <div class="my-4">
                        <fieldset>
                            <div class="row">
                                <h4 class="text-center col-lg-12 mb-3">Datos del elemento</h4>
                                <div class="form-group input-group-sm col-lg-3">
                                    <label for="numControl">Núm. Control</label>
                                    <input type="text" class="form-control" id="numControl" name="numControl">
                                    <small class="form-text span_error" id="error-numControl"></small>
                                </div>
                                <div class="form-group input-group-sm col-lg-3">
                                    <label for="nombreElemento">Nombre</label>
                                    <input type="text" class="form-control" id="nombreElemento" name="nombreElemento">
                                    <small class="form-text span_error" id="error-nombreElemento"></small>
                                </div>
                                <div class="form-group input-group-sm col-lg-3">
                                    <label for="primerApellidoElemento">Apellido paterno</label>
                                    <input type="text" class="form-control" id="primerApellidoElemento" name="primerApellidoElemento">
                                    <small class="form-text span_error" id="error-primerApellidoElemento"></small>
                                </div>
                                <div class="form-group input-group-sm col-lg-3">
                                    <label for="segundoApellidoElemento">Apellido materno</label>
                                    <input type="text" class="form-control" id="segundoApellidoElemento" name="segundoApellidoElemento">
                                    <small class="form-text span_error" id="error-segundoApellidoElemento"></small>
                                </div>
                                <div class="form-group input-group-sm col-lg-3">
                                    <label for="placaElemento">Placa</label>
                                    <input type="text" class="form-control text-uppercase" id="placaElemento" name="placaElemento">
                                    <small class="form-text span_error" id="error-placaElemento"></small>
                                </div>
                                <div class="form-group input-group-sm col-lg-3">
                                    <label for="unidadElemento">Unidad</label>
                                    <input type="text" class="form-control text-uppercase" id="unidadElemento" name="unidadElemento">
                                    <small class="form-text span_error" id="error-unidadElemento"></small>
                                </div>
                                <div class="form-group input-group-sm col-lg-3">
                                    <label for="cargoElemento">Cargo</label>
                                    <input type="text" class="form-control" id="cargoElemento" name="cargoElemento">
                                    <small class="form-text span_error" id="error-cargoElemento"></small>
                                </div>
                                <div class="form-group input-group-sm col-lg-3">
                                    <label for="adscripcionElemento">Adscripción</label>
                                    <input type="text" class="form-control text-uppercase" id="adscripcionElemento" name="adscripcionElemento">
                                    <small class="form-text span_error" id="error-adscripcionElemento"></small>
                                </div>
                                <div class="form-group col-lg-6 mt-3">
                                    <label for="adscripcionElemento" class="mr-3">¿Hubo detenidos?</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="huboDetenidos" id="huboDetenidos1" value="false" checked>
                                        <label class="form-check-label" for="inlineRadio1">No</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="huboDetenidos" id="huboDetenidos2" value="true">
                                        <label class="form-check-label" for="inlineRadio2">Si</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="row d-flex align-items-center">
								<h4 class="text-center col-lg-12 my-3">Detenido(s)</h4>
								<div class="alert alert-warning col-lg-12" role="alert" id="alertEditDetenidos">Está realizando edición a un vehículo.</div>
								<div class="form-group input-group-sm col-lg-3">
									<label for="nombreDetenido">Nombre(s)</label>
									<input type="text" class="form-control text-uppercase" id="nombreDetenido">
									<small class="form-text span_error" id="error-nombreDetenido"></small>
								</div>
								<div class="form-group input-group-sm col-lg-2">
									<label for="primerApellidoDetenido">Primer Apellido</label>
									<input type="text" class="form-control text-uppercase" id="primerApellidoDetenido">
									<small class="form-text span_error" id="error-primerApellidoDetenido"></small>
								</div>
								<div class="form-group input-group-sm col-lg-2">
									<label for="segundoApellidoDetenido">Segundo Apellido</label>
									<input type="text" class="form-control text-uppercase" id="segundoApellidoDetenido">
									<small class="form-text span_error" id="error-segundoApellidoDetenido"></small>
								</div>
								<div class="form-group input-group-sm col-lg-2">
									<label for="anoDetenido">Año(Nacimiento)</label>
									<input type="date" min="0" max="99" class="form-control " id="anoDetenido" aria-describedby="inputGroup-sizing-sm">
									<small class="form-text span_error" id="error-anoDetenido"></small>
								</div>
								<div class="form-group input-group-sm col-lg-1">
									<label for="edadDetenido">Edad</label>
									<input type="number" min="0" max="99" class="form-control " id="edadDetenido" aria-describedby="inputGroup-sizing-sm">
									<small class="form-text span_error" id="error-edadDetenido"></small>
								</div>
								<div class="form-group input-group-sm col-lg-2">
									<label for="sexoDetenido">Sexo</label>
									<select class="custom-select" id="sexoDetenido">
										<option value="" selected>SELECCIONE UNA OPCIÓN...</option>
										<option value="MUJER">MUJER</option>
										<option value="HOMBRE">HOMBRE</option>
									</select>
									<small class="form-text span_error" id="error-sexoDetenido"></small>
								</div>
								<button class="col-md-6 offset-md-3 btn btn-ssc" id="btn-add-detenido">
									Agregar
								</button>
								<div class="col-lg-12 text-center">
									<small class="form-text span_error" id="error-tableDetenidos"></small>
								</div>
								<table class="table mt-3 table-bordered" id="tableDetenidos">
									<thead class="thead-dark">
										<tr>
											<th scope="col">Nombre(s)</th>
											<th scope="col">Primer apellido</th>
											<th scope="col">Segundo apellido</th>
											<th scope="col">Fecha nacimiento</th>
											<th scope="col">Edad</th>
											<th scope="col">Sexo</th>
											<th scope="col"></th>
											<th scope="col"></th>
										</tr>
									</thead>
									<tbody class="text-uppercase">
									</tbody>
								</table>
                            </div>
                        </fieldset>
                    </div>
                </form>
				<div class="col-12 my-4" id="msg_puestaError"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-fieldset" id="btn-cancelar-fieldset">Cancelar</button>
            <button type="button" class="btn btn-ssc btn-fieldset" id="btn-continuar-fieldset">Guardar</button>
        </div>
        </div>
    </div>
</div>

