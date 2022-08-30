<div class="container">
	<div class="row d-flex justify-content-center">
		<div class="col-auto pr-3 pl-3">
			<div class="paragraph-title d-flex justify-content-between mt-3 mb-3">
				<h5 class="title-width my-auto font-weight-bold">Seguimientos</h5>
				<div>
					<a class="btn btn-opacity"  href="<?php echo base_url;?>Seguimientos/nuevoSeguimientoP" data-toggle="tooltip" data-placement="left" title="Crear un nuevo seguimiento de persona">
							<span class="v-a-middle">Seguimiento Persona</span>
							<i class="material-icons md-30 v-a-middle">add</i>
							
					</a>
					<a class="btn btn-opacity"  href="<?php echo base_url;?>Seguimientos/nuevoSeguimientoV" data-toggle="tooltip" data-placement="left" title="Crear un nuevo seguimiento de vehículo">
							<span class="v-a-middle">Seguimiento Vehículo</span>
							<i class="material-icons md-30 v-a-middle">add</i>
					</a>
				</div>
			</div>

			<div class="container-fluid">
			    <ul class="nav nav-tabs d-flex" id="tab_seguimientos" role="tablist">
			        <li class="nav-item" role="presentation">
			            <a class="nav-link active" data-toggle="tab" href="#s_persona" role="tab" aria-controls="Seguimiento_personas" aria-selected="true">Personas</a>
			        </li>

			        <li class="nav-item repetido" id="tab_seguimientos" role="presentation">
			            <a class="nav-link" data-toggle="tab" href="#s_vehiculo" role="tab" aria-controls="Seguimiento_vehiculos" aria-selected="false">Vehículos</a>
			        </li>
			    </ul>


			    <div class="tab-content" id="myTabContent">
			        <div class="tab-pane fade show active" id="s_persona">
			            <?php include 'tabs/segPView.php'; ?>
			        </div>

			        <div class="tab-pane fade" id="s_vehiculo">
			            <?php include 'tabs/segVView.php'; ?>
			            <!--<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>-->
			        </div>
			    </div>
			</div>
		</div>
	</div>
</div>
