<div id="id_container1" class="container mt-4">
	<div class="row">
		<div class="col-12 text-center">
			<h3 class="display-4">Nuevo Usuario</h3>
		</div>
	</div>

	<?php echo (isset($data['resultStatus']))?$data['resultStatus']:""; //status del post (con exito o sin exito)?>
	<!--div class="row">
		<div class="col-auto mx-auto mt-4">
			<img id="img_user" class="img-fluid" alt="Responsive image" src="<?= base_url;?>public/media/images/<?= $infoUser->Path_Imagen_User;?>">
		</div>
	</div-->

	<div class="row mt-4 mx-auto">
		<form id="id_form" class="col-12" method="post" action="<?= base_url;?>UsersAdmin/crearUser" enctype="multipart/form-data" accept-charset="utf-8">
			<div class="row">
				<div class="col-12 text-center my-3">
					<h5>Información general</h5>
				</div>
				<div class="col-12 text-center my-2">
					<p class="indicaciones_p">Llene los campos correspondientes a la información requerida</p>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-12 col-md-4">
					<label for="Nombre">Nombre</label>
				    <input type="text" class="form-control" name="Nombre" id="Nombre" placeholder="Nombre" required value="<?php echo (isset($_POST['crearUser']))?$_POST['Nombre']:"";?>">
				    <small class="form-text text-muted"></small>
				</div>
				<div class="form-group col-12 col-md-4">
					<label for="Ap_Paterno">Apellido paterno</label>
				    <input type="text" class="form-control" name="Ap_Paterno" id="Ap_Paterno" placeholder="Apellido Paterno" required value="<?php echo (isset($_POST['crearUser']))?$_POST['Ap_Paterno']:"";?>">
				    <!--small class="form-text text-muted">Puedes cambiar el nombre del usuario</small-->
				</div>
				<div class="form-group col-12 col-md-4">
					<label for="Ap_Materno">Apellido materno</label>
				    <input type="text" class="form-control" name="Ap_Materno" id="Ap_Materno" placeholder="Apellido Materno" required value="<?php echo (isset($_POST['crearUser']))?$_POST['Ap_Materno']:"";?>">
				    <!--small class="form-text text-muted">Puedes cambiar el nombre del usuario</small-->
				</div>
			</div>
			<div class="row">
				<div class="form-group col-12 col-md-4">
					<label for="Email">Email</label>
				    <input type="email" class="form-control" name="Email" id="Email" placeholder="example@gmail.com" required value="<?php echo (isset($_POST['crearUser']))?$_POST['Email']:"";?>">
				    <small class="form-text text-muted"><?= (isset($data['errorForm']['Email']))?$data['errorForm']['Email']:"";?></small>
				</div>
				<div class="form-group col-12 col-md-4">
				    <label for="Area">Área</label>
				    <select class="form-control" id="Area" name="Area">
				      <option value="Tecnologías" <?php echo (isset($_POST['crearUser']) && $_POST['Area'] == "Tecnologías")?"selected":"";?>>TECNOLOGÍAS</option>
				      <option value="Estadística" <?php echo (isset($_POST['crearUser']) && $_POST['Area'] == "Estadística")?"selected":"";?>>ESTADÍSTICA</option>
				      <option value="Administración" <?php echo (isset($_POST['crearUser']) && $_POST['Area'] == "Administración")?"selected":"";?>>ADMINISTRACIÓN</option>
				      <option value="Remisiones" <?php echo (isset($_POST['crearUser']) && $_POST['Area'] == "Remisiones")?"selected":"";?>>REMISIONES</option>
					  <option value="Incidencias" <?php echo (isset($_POST['crearUser']) && $_POST['Area'] == "Incidencias")?"selected":"";?>>INCIDENCIAS</option>
					  <option value="Inteligencia" <?php echo (isset($_POST['crearUser']) && $_POST['Area'] == "Inteligencia")?"selected":"";?>>INTELIGENCIA</option>
				      <option value="Eventos Delictivos" <?php echo (isset($_POST['crearUser']) && $_POST['Area'] == "Eventos Delictivos")?"selected":"";?>>EVENTOS DELICTIVOS</option>
					  <option value="PERITOS" <?php echo (isset($_POST['crearUser']) && $_POST['Area'] == "PERITOS")?"selected":"";?>>PERITOS</option>
				      <option value="Otros" <?php echo (isset($_POST['crearUser']) && $_POST['Area'] == "Otros")?"selected":"";?>>OTROS</option>
				    </select>
				</div>
				<div class="form-group col-12 col-md-4">
				    <label for="Estatus">Estatus</label>
				    <select class="form-control" id="Estatus" name="Estatus">
				      <option value="1" <?php echo (isset($_POST['crearUser']) && $_POST['Estatus'] == "1")?"selected":"";?>>ACTIVO</option>
				      <option value="0" <?php echo (isset($_POST['crearUser']) && $_POST['Estatus'] == "0")?"selected":"";?>>INACTIVO</option>
				    </select>
				</div>
			</div>
			<div class="row">
				<div class="col-12 text-center mt-3 mb-3">
					<h5>Información de la sesión</h5>
				</div>
				<div class="col-12 text-center my-2">
					<p class="indicaciones_p">Ingrese el usuario y contraseña para el inicio de sesión del nuevo usuario</p>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-12 col-md-4 offset-md-2">
					<label for="User_Name">Nombre de Usuario</label>
				    <input type="text" class="form-control" name="User_Name" id="User_Name" placeholder="Ejemplo: JuanDan123" required value="<?php echo (isset($_POST['crearUser']))?$_POST['User_Name']:"";?>">
				    <small class="form-text text-muted"><?= (isset($data['errorForm']['User_Name']))?$data['errorForm']['User_Name']:"";?></small>
				</div>
				<div class="form-group col-12 col-md-4">
					<label for="id_pass">Contraseña</label>
					<div id="id_pass" class="input-group">
		                <input id="id_input_pass" type="password" name="Password" class="form-control py-2 border-right-0 border" placeholder="Contraseña" required value="<?php echo (isset($_POST['crearUser']))?$_POST['Password']:"";?>" aria-describedby="button-addon2" >
		                <span class="input-group-append">
		                    <div id="id_pass_button" class="input-group-text bg-transparent"><i class="material-icons md-18 ssc view-password">visibility</i></div>
		                </span>
		            </div>
		            <!--small class="form-text text-muted">Contraseña de usueario</small-->
				</div>
				
			</div>
			<div class="row">
				<div class="col-12 text-center mt-3 mb-3">
					<h5>Permisos</h5>
				</div>
				<div class="col-12 text-center my-2">
					<p class="indicaciones_p">Marque los permisos que tendrá el nuevo usuario conforme a los módulos del sistema. Si el usuario tedrá permisos de administrador, solo marque la correspondiente casilla</p>
				</div>
			</div>
			<div class="row d-flex justify-content-center mt-2 mb-3" >
				<div class="col-auto">
					<table class="table table-responsive" id="permisos_tabla">
					  <thead class="thead-myTable">
						    <tr>
							    <th >
							    	<div class="row d-flex justify-content-center">
							    		Jurídico
							    	</div>
							    	<div class="row d-flex justify-content-center">
							    		<input class="checkPermisos" type="checkbox" value="1" id="all_juridico">
							    	</div>
							    </th>
							    <th >
							    	<div class="row d-flex justify-content-center">
							    		Dictamen M
							    	</div>
							    	<div class="row d-flex justify-content-center">
							    		<input class="checkPermisos" type="checkbox" value="1" id="all_dictamen">
							    	</div>
							    </th>
							    <th >
							    	<div class="row d-flex justify-content-center">
							    		Remisiones
							    	</div>
							    	<div class="row d-flex justify-content-center">
							    		<input class="checkPermisos" type="checkbox" value="1" id="all_remisiones">
							    	</div>
							    </th>
							    <th >
							    	<div class="row d-flex justify-content-center">
							    		Inteligencia
							    	</div>
							    	<div class="row d-flex justify-content-center">
							    		<input class="checkPermisos" type="checkbox" value="1" id="all_inteligencia">
							    	</div>
							    </th>
							    <th >
							    	<div class="row d-flex justify-content-center">
							    		Inteligencia Op
							    	</div>
							    	<div class="row d-flex justify-content-center">
							    		<input class="checkPermisos" type="checkbox" value="1" id="all_inteligencia_op">
							    	</div>
							    </th>
							    <th >
							    	<div class="row d-flex justify-content-center">
							    		IPH Final
							    	</div>
							    	<div class="row d-flex justify-content-center">
							    		<input class="checkPermisos" type="checkbox" value="1" id="all_iph_final">
							    	</div>
							    </th>
							    <th >
							    	<div class="row d-flex justify-content-center">
							    		<!--Antes Corralón-->
							    		Seguimientos
							    	</div>
							    	<div class="row d-flex justify-content-center">
							    		<input class="checkPermisos" type="checkbox" value="1" id="all_corralon">
							    	</div>
							    </th>
							    <th >
							    	<div class="row d-flex justify-content-center">
							    		Eventos D
							    	</div>
							    	<div class="row d-flex justify-content-center">
							    		<input class="checkPermisos" type="checkbox" value="1" id="all_eventos_d">
							    	</div>
							    </th>
								<!-- Columnas añadidas para el nuevo modulo de vehiculos-->
								<th >
							    	<div class="row d-flex justify-content-center">
							    		Vehiculos
							    	</div>
							    	<div class="row d-flex justify-content-center">
							    		<input class="checkPermisos" type="checkbox" value="1" id="all_vehiculos">
							    	</div>
							    </th>
								<!-- Columnas añadidas para mostrar permisos para  editar/ver narrativas-->
								<th style="display:none">
							    	<div class="row d-flex justify-content-center">
							    		Editar narrativas
							    	</div>
							    	<div class="row d-flex justify-content-center">
							    		<input class="checkPermisos" type="checkbox" value="1" id="all_editar_narra">
							    	</div>
							    </th>
								<th style="display:none">
							    	<div class="row d-flex justify-content-center">
							    		Ver narrativas
							    	</div>
							    	<div class="row d-flex justify-content-center">
							    		<input class="checkPermisos" type="checkbox" value="1" id="all_ver_narra">
							    	</div>
							    </th>
								<!---Hasta aqui en las modificaciones --->
						    </tr>
					  </thead>
					  <tbody>
						  	<tr>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="Ju_Create" name="Ju_Create" <?= (isset($_POST['crearUser']) && isset($_POST['Ju_Create']) )?"checked":"";?> >
									    <label class="form-check-label" for="Ju_Create">Crear</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="Dic_Create" name="Dic_Create" <?= (isset($_POST['crearUser']) && isset($_POST['Dic_Create']) )?"checked":"";?> >
									    <label class="form-check-label" for="Dic_Create">Crear</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="R_Create" name="R_Create" <?= (isset($_POST['crearUser']) && isset($_POST['R_Create']) )?"checked":"";?> >
									    <label class="form-check-label" for="R_Create">Crear</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="Int_Create" name="Int_Create" <?= (isset($_POST['crearUser']) && isset($_POST['Int_Create']) )?"checked":"";?> >
									    <label class="form-check-label" for="Int_Create">Crear</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="IntOp_Create" name="IntOp_Create" <?= (isset($_POST['crearUser']) && isset($_POST['IntOp_Create']) )?"checked":"";?> >
									    <label class="form-check-label" for="IntOp_Create">Crear</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="IPH_Create" name="IPH_Create" <?= (isset($_POST['crearUser']) && isset($_POST['IPH_Create']) )?"checked":"";?> >
									    <label class="form-check-label" for="IPH_Create">Crear</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="Corr_Create" name="Corr_Create" <?= (isset($_POST['crearUser']) && isset($_POST['Corr_Create']) )?"checked":"";?> >
									    <label class="form-check-label" for="Corr_Create">Crear</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="E_Create" name="E_Create" <?= (isset($_POST['crearUser']) && isset($_POST['E_Create']) )?"checked":"";?> >
									    <label class="form-check-label" for="E_Create">Crear</label>
									</div>
						  		</td>
								<!-- columna añadida para el modulo de vehiculos -->
								<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="V_Create" name="V_Create" <?= (isset($_POST['crearUser']) && isset($_POST['V_Create']) )?"checked":"";?> >
									    <label class="form-check-label" for="V_Create">Crear</label>
									</div>
						  		</td>
								  <!-- Columnas añadidas para mostrar permisos para editar/ver tabs de remisones y editar/ver narrativas-->
								  <td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="check_narrap" name="check_narrap" >
									    <label class="form-check-label" for="check_narrap">Peticionario</label>
									</div>
						  		</td>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="check_narrapv" name="check_narrapv" >
									    <label class="form-check-label" for="check_narrapv">Peticionario</label>
									</div>
						  		</td>
								<!---Hasta aqui en las modificaciones --->
						  	</tr>
						  	<tr>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="Ju_Read" name="Ju_Read" <?= (isset($_POST['crearUser']) && isset($_POST['Ju_Read']) )?"checked":"";?> >
									    <label class="form-check-label" for="Ju_Read">Consultar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="Dic_Read" name="Dic_Read" <?= (isset($_POST['crearUser']) && isset($_POST['Dic_Read']) )?"checked":"";?> >
									    <label class="form-check-label" for="Dic_Read">Consultar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="R_Read" onchange="ver_remisiones()" name="R_Read" <?= (isset($_POST['crearUser']) && isset($_POST['R_Read']) )?"checked":"";?> >
									    <label class="form-check-label" for="R_Read">Consultar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="Int_Read" name="Int_Read" <?= (isset($_POST['crearUser']) && isset($_POST['Int_Read']) )?"checked":"";?> >
									    <label class="form-check-label" for="Int_Read">Consultar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="IntOp_Read" name="IntOp_Read" <?= (isset($_POST['crearUser']) && isset($_POST['IntOp_Read']) )?"checked":"";?> >
									    <label class="form-check-label" for="IntOp_Read">Consultar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="IPH_Read" name="IPH_Read" <?= (isset($_POST['crearUser']) && isset($_POST['IPH_Read']) )?"checked":"";?> >
									    <label class="form-check-label" for="IPH_Read">Consultar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="Corr_Read" name="Corr_Read" <?= (isset($_POST['crearUser']) && isset($_POST['Corr_Read']) )?"checked":"";?> >
									    <label class="form-check-label" for="Corr_Read">Consultar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="E_Read" name="E_Read" <?= (isset($_POST['crearUser']) && isset($_POST['E_Read']) )?"checked":"";?> >
									    <label class="form-check-label" for="E_Read">Consultar</label>
									</div>
						  		</td>
								<!-- columna añadida para el modulo de vehiculos -->
								<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="V_Read" name="V_Read" <?= (isset($_POST['crearUser']) && isset($_POST['V_Read']) )?"checked":"";?> >
									    <label class="form-check-label" for="V_Read">Consultar</label>
									</div>
						  		</td>
								<!-- Columnas añadidas para mostrar permisos para editar/ver tabs de remisones y editar/ver narrativas-->
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="elem_narrae" name="elem_narrae"  >
									    <label class="form-check-label" for="elem_narrae">Elementos</label>
									</div>
						  		</td>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="elem_narrav" name="elem_narrav"  >
									    <label class="form-check-label" for="elem_narrav">Elementos</label>
									</div>
						  		</td>
								<!---Hasta aqui en las modificaciones --->
							</tr>
						  	<tr>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="Ju_Update" name="Ju_Update" <?= (isset($_POST['crearUser']) && isset($_POST['Ju_Update']) )?"checked":"";?> >
									    <label class="form-check-label" for="Ju_Update">Modificar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="Dic_Update" name="Dic_Update" <?= (isset($_POST['crearUser']) && isset($_POST['Dic_Update']) )?"checked":"";?> >
									    <label class="form-check-label" for="Dic_Update">Modificar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="R_Update" onchange="editar_remisiones()" name="R_Update" <?= (isset($_POST['crearUser']) && isset($_POST['R_Update']) )?"checked":"";?> >
									    <label class="form-check-label" for="R_Update">Modificar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="Int_Update" name="Int_Update" <?= (isset($_POST['crearUser']) && isset($_POST['Int_Update']) )?"checked":"";?> >
									    <label class="form-check-label" for="Int_Update">Modificar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="IntOp_Update" name="IntOp_Update" <?= (isset($_POST['crearUser']) && isset($_POST['IntOp_Update']) )?"checked":"";?> >
									    <label class="form-check-label" for="IntOp_Update">Modificar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="IPH_Update" name="IPH_Update" <?= (isset($_POST['crearUser']) && isset($_POST['IPH_Update']) )?"checked":"";?> >
									    <label class="form-check-label" for="IPH_Update">Modificar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="Corr_Update" name="Corr_Update" <?= (isset($_POST['crearUser']) && isset($_POST['Corr_Update']) )?"checked":"";?> >
									    <label class="form-check-label" for="Corr_Update">Modificar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="E_Update" name="E_Update" <?= (isset($_POST['crearUser']) && isset($_POST['E_Update']) )?"checked":"";?> >
									    <label class="form-check-label" for="E_Update">Modificar</label>
									</div>
						  		</td>
								<!-- columna añadida para el modulo de vehiculos -->
								<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="V_Update" name="V_Update" <?= (isset($_POST['crearUser']) && isset($_POST['V_Update']) )?"checked":"";?> >
									    <label class="form-check-label" for="V_Update">Modificar</label>
									</div>
						  		</td>
							<!-- Columnas añadidas para mostrar permisos para editar/ver tabs de remisones y editar/ver narrativas-->
							  <td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="detenido_narrae" name="detenido_narrae"  >
									    <label class="form-check-label" for="detenido_narrae">Detenido</label>
									</div>
						  		</td>
								  <td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="detenido_narrav" name="detenido_narrav"  >
									    <label class="form-check-label" for="detenido_narrav">Detenido</label>
									</div>
						  		</td>
						  	</tr>
							  <tr>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									<td style="display:none">
										<div class="form-group form-check col-12">
											<input type="checkbox" class="form-check-input checkPermisos" value="1" id="iph_narrae" name="iph_narrae"  >
											<label class="form-check-label" for="iph_narrae">IPH</label>
										</div>
									</td>
									<td style="display:none">
										<div class="form-group form-check col-12">
											<input type="checkbox" class="form-check-input checkPermisos" value="1" id="iph_narrav" name="iph_narrav"  >
											<label class="form-check-label" for="iph_narrav">IPH</label>
										</div>
									</td>
							</tr>
						  	<!--<tr>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="Ju_Delete" name="Ju_Delete" <?= (isset($_POST['crearUser']) && isset($_POST['Ju_Delete']) )?"checked":"";?> >
									    <label class="form-check-label" for="Ju_Delete">Borrar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="Dic_Delete" name="Dic_Delete" <?= (isset($_POST['crearUser']) && isset($_POST['Dic_Delete']) )?"checked":"";?> >
									    <label class="form-check-label" for="Dic_Delete">Borrar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="R_Delete" name="R_Delete" <?= (isset($_POST['crearUser']) && isset($_POST['R_Delete']) )?"checked":"";?> >
									    <label class="form-check-label" for="R_Delete">Borrar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="Int_Delete" name="Int_Delete" <?= (isset($_POST['crearUser']) && isset($_POST['Int_Delete']) )?"checked":"";?> >
									    <label class="form-check-label" for="Int_Delete">Borrar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="IntOp_Delete" name="IntOp_Delete" <?= (isset($_POST['crearUser']) && isset($_POST['IntOp_Delete']) )?"checked":"";?> >
									    <label class="form-check-label" for="IntOp_Delete">Borrar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="IPH_Delete" name="IPH_Delete" <?= (isset($_POST['crearUser']) && isset($_POST['IPH_Delete']) )?"checked":"";?> >
									    <label class="form-check-label" for="IPH_Delete">Borrar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="Corr_Delete" name="Corr_Delete" <?= (isset($_POST['crearUser']) && isset($_POST['Corr_Delete']) )?"checked":"";?> >
									    <label class="form-check-label" for="Corr_Delete">Borrar</label>
									</div>
						  		</td>
						  		<td>
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="E_Delete" name="E_Delete" <?= (isset($_POST['crearUser']) && isset($_POST['E_Delete']) )?"checked":"";?> >
									    <label class="form-check-label" for="E_Delete">Borrar</label>
									</div>
						  		</td>
						  	</tr>-->
						  	
					  </tbody>
					</table>
				</div>
			</div>
			<div class="row d-flex justify-content-center mt-2 mb-3" >
				<div class="col-auto">
					<table class="table table-responsive" id="remisiones">
						<thead class="thead-myTable">
						<tr>
							<th class="checkColumns" style="display:none">
								<div class="row d-flex justify-content-center">
									Editar Remision
								</div>
								<div class="row d-flex justify-content-center">
									<input class="checkPermisos" type="checkbox" value="1" id="all_editar_remi">
								</div>
							</th>
							<th style="display:none">
								<div class="row d-flex justify-content-center">
									Ver Remision
								</div>
								<div class="row d-flex justify-content-center">
									<input class="checkPermisos" type="checkbox" value="1" id="all_ver_remi">
								</div>
							</th>
						</tr>
						</thead>
						<tbody>
							<tr>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="check_datosp" name="check_datosp"  >
									    <label class="form-check-label" for="check_datosp">Datos principales</label>
									</div>
						  		</td>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="check_datospv" name="check_datospv"  >
									    <label class="form-check-label" for="check_datospv">Datos principales</label>
									</div>
						  		</td>
							</tr>
							<tr>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="peti_edit" name="peti_edit"  >
									    <label class="form-check-label" for="peti_edit">Peticionario</label>
									</div>
						  		</td>
								  <td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="peti_ver" name="peti_ver"  >
									    <label class="form-check-label" for="peti_ver">Peticionario</label>
									</div>
						  		</td>
							</tr>
							<tr>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="ubicacion_editar" name="ubicacion_editar"  >
									    <label class="form-check-label" for="ubicacion_editar">Ubicacion hechos</label>
									</div>
						  		 </td>
								  <td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="ubicacion_ver" name="ubicacion_ver"  >
									    <label class="form-check-label" for="ubicacion_ver">Ubicacion hechos</label>
									</div>
						  		</td>
							</tr>
							<!-- Renglones añadidos para mostrar permisos para editar/ver tabs de remisones y editar/ver narrativas-->
							<tr>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="elementos_rem" name="elementos_rem"  >
									    <label class="form-check-label" for="elementos_rem">Elementos participantes</label>
									</div>
						  		</td>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="elementos_remv" name="elementos_remv"  >
									    <label class="form-check-label" for="elementos_remv">Elementos participantes</label>
									</div>
						  		</td>
							</tr>
							<tr>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="objetos_ae" name="objetos_ae"  >
									    <label class="form-check-label" for="objetos_ae">Objetos asegurados</label>
									</div>
						  		</td>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="objetos_av" name="objetos_av"  >
									    <label class="form-check-label" for="objetos_av">Objetos asegurados</label>
									</div>
						  		</td>
							</tr>
							<tr>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="fotosyh_e" name="fotosyh_e"  >
									    <label class="form-check-label" for="fotosyh_e">Captura de fotos y huellas</label>
									</div>
						  		</td>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="fotosyh_v" name="fotosyh_v"  >
									    <label class="form-check-label" for="fotosyh_v">Captura de fotos y huellas</label>
									</div>
						  		</td>
							</tr>
							<tr>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="ubicacion_de" name="ubicacion_de" > 
									    <label class="form-check-label" for="ubicacion_de"> Ubicacion detencion</label>
									</div>
						  		</td>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="ubicacion_dv" name="ubicacion_dv"  >
									    <label class="form-check-label" for="ubicacion_dv">Ubicacion detencion</label>
									</div>
						  		</td>
							</tr>
							<tr>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="senas_e" name="senas_e"  >
									    <label class="form-check-label" for="senas_e">Señas particulares</label>
									</div>
						  		</td>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="senas_v" name="senas_v"  >
									    <label class="form-check-label" for="senas_v">Señas particulares</label>
									</div>
						  		</td>
							</tr>
							<tr>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="entrevistad_e" name="entrevistad_e"  >
									    <label class="form-check-label" for="entrevistad_e">Entrevista detenido</label>
									</div>
						  		</td>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="entrevistad_v" name="entrevistad_v"  >
									    <label class="form-check-label" for="entrevistad_v">Entrevista detenido</label>
									</div>
						  		</td>
							</tr>
							<tr>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="mediaf_e" name="mediaf_e" >
									    <label class="form-check-label" for="mediaf_e">Media filiacion</label>
									</div>
						  		</td>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" value="1" id="mediaf_v" name="mediaf_v"  >
									    <label class="form-check-label" for="mediaf_v">Media filiacion</label>
									</div>
						  		</td>
							</tr>
							<tr>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" onchange="editar_narrativas()" value="1" id="narrativas_e" name="narrativas_e"  >
									    <label class="form-check-label" for="narrativas_e">Narrativas</label>
									</div>
						  		</td>
								<td style="display:none">
						  			<div class="form-group form-check col-12">
									    <input type="checkbox" class="form-check-input checkPermisos" onchange="ver_narrativas()" value="1" id="narrativas_v" name="narrativas_v" >
									    <label class="form-check-label" for="narrativas_v">Narrativas</label>
									</div>
						  		</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row mt-2 mb-5" >
				<div class="col-12 form-group form-check text-center">
				    <input type="checkbox" class="form-check-input" value="1" id="Nivel_User" name="Nivel_User" <?= (isset($_POST['crearUser']) && isset($_POST['Nivel_User']))?"checked":"";?>>
				    <label class="form-check-label" for="Nivel_User" >Permisos de validación (Remisiones)</label>
				</div>
				<div class="col-12 form-group form-check text-center">
				    <input type="checkbox" class="form-check-input" value="1" id="Modo_Admin" onclick="disablePermisos()" name="Modo_Admin" <?= (isset($_POST['crearUser']) && isset($_POST['Modo_Admin']))?"checked":"";?>>
				    <label class="form-check-label" for="Modo_Admin" >Modo Administrador</label>
				</div>
			</div>
			<div class="row">
				<div class="col-12 text-center mt-3 mb-3">
					<h5>Imagen del usuario</h5>
				</div>
				<div class="col-12 text-center my-2">
					<p class="indicaciones_p">Suba una imagen de perfil.</p>
				</div>
			</div>
			<div class="row mt-3 mb-3">
				<div class="col-8 col-md-6 offset-2 offset-md-3 ">
					<label for="id_image">Imagen usuario</label>
					<div id="id_image" class="input-group">
						<div class="custom-file">
							<label id="label_foto_file" class="custom-file-label" for="id_foto_file" data-browse="Buscar">Subir imagen</label>
					    	<input type="file" class="custom-file-input" id="id_foto_file" name="foto_file">
					  	</div>
					</div>
					<small id="error_img1" class="form-text text-danger">Tamaño máximo 8MB, formatos: jpg/png</small>
				</div>
			</div>
			<div class="row mt-3 mb-5">
				<div class=" col-lg-4 col-sm-12 offset-lg-4 mt-sm-4 d-flex justify-content-center align-items-center">
                    <div id="preview_1" class="preview"></div>
                </div>
			</div>
			
			<div class="row mt-4 mb-5">
				<div class="col-12 col-md-3 offset-md-3 mb-4 mb-md-0">
					<div class="d-flex justify-content-center">
						<a id="backButton" href="<?= base_url;?>UsersAdmin/index/" class="btn">
							<i class="material-icons v-a-middle">arrow_back_ios</i>
        					<span class="v-a-middle">Regresar</span>

						</a>
					</div>
				</div>
				<div class="col-12 col-md-3 d-flex justify-content-center">
					<button type="submit" id="mySubmit" class="btn btm-ssc" name="crearUser">Crear usuario</button>
				</div>
			</div>
			
		</form>

	</div>
</div>
