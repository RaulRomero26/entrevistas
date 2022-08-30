<?php
/*
    Catálogos:
    1  - Tatuajes
    2  - Instituciones de seguridad
    3  - Medidas de drogas (ramos, paquetes, etc)
    4  - Delitos / Faltas admin
    5  - Armas
    6  - Grupos Delictivos
    7  - Media Filiación
    8  - Vehículos (autos)
    9  - Motocicletas
    10 - Escolaridad
    11 - Parentesco
    12 - Forma Detención
    13 - Tipo de violencia
    14 - Grupos (policía)
    15 - Adicciones/Narcóticos
    16 - Tipo accesorios
    17 - Tipo vestimenta
    18 - Zonas / sectores
    19 - Origen del evento
    20 - Vectores
    21 - Uso del vehículo
    22 - Marca vehículo IO
	23 - Grupos Inspecciones
*/
class Catalogos extends Controller
{
	public $Catalogo;

	public function __construct()
	{
		$this->Catalogo = $this->model("Catalogo");
	}

	public function index(){

		if (!isset($_SESSION['userdata']) || $_SESSION['userdata']->Modo_Admin!=1) {
            header("Location: ".base_url."Login");
            exit();
        }

        //Titulo de la pagina y archivos css y js necesarios
		$data = [
            'titulo'    => 'Planeación | Catálogos',
            'extra_css' => '<link rel="stylesheet" href="'. base_url . 'public/css/system/catalogos/index.css">',
            'extra_js'  => '<script src="'. base_url . 'public/js/system/catalogos/index.js"></script>'
        ];


        $this->view("templates/header", $data);
        $this->view("system/catalogos/catalogosView", $data);
        $this->view("templates/footer", $data);
    }

    public function crudCatalogo(){
    	if (!isset($_SESSION['userdata']) || $_SESSION['userdata']->Modo_Admin!=1) {
                header("Location: ".base_url."Login");
                exit();
            }

            //Titulo de la pagina y archivos css y js necesarios
			$data = [
                'titulo'    => 'Planeación | Catálogos',
                'extra_css' => '<link rel="stylesheet" href="'. base_url . 'public/css/system/catalogos/index.css">
                				<link rel="stylesheet" href="'. base_url . 'public/css/system/catalogos/crud.css">',
                'extra_js'  => '<script src="'. base_url . 'public/js/system/catalogos/crud.js"></script>'
            ];

            
            //PROCESO DE FILTRADO DE CATALOGO
            if (isset($_GET['catalogoActual']) && is_numeric($_GET['catalogoActual']) && $_GET['catalogoActual']>=MIN_CATALOGO && $_GET['catalogoActual']<=MAX_CATALOGO) { //numero de catálogo
		        $catalogoActual = $_GET['catalogoActual'];
		    } 
		    else {
		        $catalogoActual = 1;
		    }
            //PROCESO DE PAGINATION
			if (isset($_GET['numPage'])) { //numero de pagination
		        $numPage = $_GET['numPage'];
		        if (!(is_numeric($numPage))) //seguridad si se ingresa parámetro inválido
		        	$numPage = 1;
		    } 
		    else {
		        $numPage = 1;
		    }
		    //cadena auxiliar por si se trata de una paginacion conforme a una busqueda dada anteriormente
		    $cadena = "";
		    if (isset($_GET['cadena'])) { //numero de pagination
		        $cadena = $_GET['cadena'];
		        $data['cadena'] = $cadena;
		    }

		    $from_where_sentence = $this->Catalogo->generateFromWhereSentence($catalogoActual,$cadena);
		    $extra_cad = ($cadena != "")?("&cadena=".$cadena):""; //para links conforme a búsqueda

		    $no_of_records_per_page = NUM_MAX_REG_PAGE; //total de registros por pagination
		    $offset = ($numPage-1) * $no_of_records_per_page; // desplazamiento conforme a la pagina

		    $results_rows_pages = $this->Catalogo->getTotalPages($no_of_records_per_page,$from_where_sentence);	//total de páginas de acuerdo a la info de la DB
		    $total_pages = $results_rows_pages['total_pages'];

		    if ($numPage>$total_pages) {$numPage = 1; $offset = ($numPage-1) * $no_of_records_per_page;} //seguridad si ocurre un error por url 	
		    
		    $cat_rows = $this->Catalogo->getDataCurrentPage($offset,$no_of_records_per_page,$from_where_sentence);	//se obtiene la información de la página actual

		    //guardamos la tabulacion de la información para la vista
		    $data['infoTable'] = $this->generarInfoTable($cat_rows,$catalogoActual);
			//guardamos los links en data para la vista
			$data['links'] = $this->generarLinks($numPage,$total_pages,$extra_cad,$catalogoActual);
			//número total de registros encontrados
			$data['total_rows'] = $results_rows_pages['total_rows'];
			$data['catalogoActual'] = $catalogoActual;


            $this->view("templates/header", $data);
            $this->view("system/catalogos/catalogosCrudView", $data);
            $this->view("templates/footer", $data);
    }

    public function buscarPorCadena(){
		if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1)) {
			header("Location: ".base_url."Inicio");
			exit();
		}

		if (isset($_POST['cadena']) && isset($_POST['catalogoActual'])) {
			$cadena = trim($_POST['cadena']); 
			$catalogoActual = trim($_POST['catalogoActual']);

			$results = $this->Catalogo->getCatalogoByCadena($cadena,$catalogoActual);
			$extra_cad = ($cadena != "")?("&cadena=".$cadena):""; //para links conforme a búsqueda

			//$dataReturn = "jeje";

			$dataReturn['infoTable'] = $this->generarInfoTable($results['cat_rows'],$catalogoActual);
			$dataReturn['links'] = $this->generarLinks($results['numPage'],$results['total_pages'],$extra_cad,$catalogoActual);
			$dataReturn['export_links'] = $this->generarExportLinks($extra_cad,$catalogoActual);
			$dataReturn['total_rows'] = "Total registros: ".$results['total_rows'];

			
			echo json_encode($dataReturn);
		}
		else{
			header("Location: ".base_url."Inicio");
		}
	}

	public function generarExportLinks($extra_cad = "",$catalogoActual = 1){
		if ($extra_cad != "") {
			$dataReturn['csv'] =  base_url.'Catalogos/exportarInfo/?tipo_export=CSV'.$extra_cad.'&catalogoActual='.$catalogoActual;
			$dataReturn['excel'] =  base_url.'Catalogos/exportarInfo/?tipo_export=EXCEL'.$extra_cad.'&catalogoActual='.$catalogoActual;
			$dataReturn['pdf'] =  base_url.'Catalogos/exportarInfo/?tipo_export=PDF'.$extra_cad.'&catalogoActual='.$catalogoActual;
			//return $dataReturn;
		}
		else{
			$dataReturn['csv'] =  base_url.'Catalogos/exportarInfo/?tipo_export=CSV'.$extra_cad.'&catalogoActual='.$catalogoActual;
			$dataReturn['excel'] =  base_url.'Catalogos/exportarInfo/?tipo_export=EXCEL'.$extra_cad.'&catalogoActual='.$catalogoActual;
			$dataReturn['pdf'] =  base_url.'Catalogos/exportarInfo/?tipo_export=PDF'.$extra_cad.'&catalogoActual='.$catalogoActual;
		}
		return $dataReturn;
	}


    public function generarLinks($numPage,$total_pages,$extra_cad = "",$catalogoActual = 1){
			//$extra_cad sirve para determinar la paginacion conforme a si se realizó una busqueda
			//Creación de links para el pagination
			$links = "";

			//FLECHA IZQ (PREV PAGINATION)
			if ($numPage>1) {
				$links.= '<li class="page-item">
							<a class="page-link" href=" '.base_url.'Catalogos/crudCatalogo/?numPage=1'.$extra_cad.'&catalogoActual='.$catalogoActual.' " data-toggle="tooltip" data-placement="top" title="Primera página">
								<i class="material-icons">first_page</i>
							</a>
						</li>';
				$links.= '<li class="page-item">
							<a class="page-link" href=" '.base_url.'Catalogos/crudCatalogo/?numPage='.($numPage-1).$extra_cad.'&catalogoActual='.$catalogoActual.' " data-toggle="tooltip" data-placement="top" title="Página anterior">
								<i class="material-icons">navigate_before</i>
							</a>
						</li>';
			}

			//DESPLIEGUE DE PAGES NUMBER
			$LINKS_EXTREMOS = GLOBAL_LINKS_EXTREMOS; //numero máximo de links a la izquierda y a la derecha
			for ($ind=($numPage-$LINKS_EXTREMOS); $ind<=($numPage+$LINKS_EXTREMOS); $ind++) {
				if(($ind>=1) && ($ind <= $total_pages)){

					$activeLink = ($ind == $numPage)? 'active':'';

					$links.= '<li class="page-item '.$activeLink.' ">
								<a class="page-link" href=" '.base_url.'Catalogos/crudCatalogo/?numPage='.($ind).$extra_cad.'&catalogoActual='.$catalogoActual.' ">
									'.($ind).'
								</a>
							</li>';
				}
			}

			//FLECHA DERECHA (NEXT PAGINATION)
			if ($numPage<$total_pages) {

				$links.= '<li class="page-item">
							<a class="page-link" href=" '.base_url.'Catalogos/crudCatalogo/?numPage='.($numPage+1).$extra_cad.'&catalogoActual='.$catalogoActual.' " data-toggle="tooltip" data-placement="top" title="Siguiente página">
							<i class="material-icons">navigate_next</i>
							</a>
						</li>';
				$links.= '<li class="page-item">
							<a class="page-link" href=" '.base_url.'Catalogos/crudCatalogo/?numPage='.($total_pages).$extra_cad.'&catalogoActual='.$catalogoActual.' " data-toggle="tooltip" data-placement="top" title="Última página">
							<i class="material-icons">last_page</i>
							</a>
						</li>';
			}

			return $links;
	}

	public function generarInfoTable($catalogoRows,$catalogoActual = 1){
			//se genera la tabulacion de la informacion por backend
			$infoTable['header'] = "";
			$infoTable['body'] = "";
	  		$infoTable['formBody'] = $this->generateFormCatalogo($catalogoActual);

	  			
  			switch ($catalogoActual) {
  				case '1':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Tipo de tatuaje</th>
  							<th >Descripción</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Tatuaje.'">';
  						$infoTable['body'].= '	<td >'.$row->Id_Tatuaje.'</td>
										        <td >'.$row->Tipo_Tatuaje.'</td>
										        <td > '.$row->Descripcion.'</td>
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Tatuaje.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Tatuaje.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '2':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Tipo de institución</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Institucion.'">';
  						$infoTable['body'].= '	<td >'.$row->Id_Institucion.'</td>
										        <td >'.$row->Tipo_Institucion.'</td>
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Institucion.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Institucion.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '3':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Tipo de medida de droga</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Medida.'">';
						$infoTable['body'].= '	<td >'.$row->Id_Medida.'</td>
					        					<td >'.$row->Tipo_Medida.'</td>
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Medida.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Medida.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '4':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Entidad</th>
  							<th >Falta / Delito</th>
  							<th >Estatus</th>
  							<th >Descripción</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Falta_Delito.'">';
						$statusFaltaDelito = ($row->Status)?"Activo":"Inactivo";
	  					$infoTable['body'].= '	<td >'.$row->Id_Falta_Delito.'</td>
										        <td >'.$row->Entidad.'</td>
										        <td >'.$row->Falta_Delito.'</td>
										        <td >'.$statusFaltaDelito.'</td>
										        <td > '.$row->Descripcion.'</td>
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Falta_Delito.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Falta_Delito.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '5':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Tipo de arma</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Tipo_Arma.'">';
						$infoTable['body'].= '	<td >'.$row->Id_Tipo_Arma.'</td>
					        					<td >'.$row->Tipo_Arma.'</td>
					        ';
					   	$infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Tipo_Arma.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Tipo_Arma.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '6':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Nombre del grupo</th>
  							<th >Modus operandi</th>
  							<th >Modo de fuga</th>
  							<th >Descripción</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Grupo.'">';
  						$infoTable['body'].= '	<td >'.$row->Id_Grupo.'</td>
										        <td >'.$row->Nombre_Grupo.'</td>
										        <td >'.$row->Modus_Operandi.'</td>
										        <td >'.$row->Modo_Fuga.'</td>
										        <td > '.$row->Descripcion.'</td>
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Grupo.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Grupo.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '7':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Tipo media filiación</th>
  							<th >Valor</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_MF.'">';
  						$infoTable['body'].= '	<td >'.$row->Id_MF.'</td>
										        <td >'.$row->Tipo_MF.'</td>
										        <td > '.$row->Valor_MF.'</td>
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_MF.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_MF.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '8':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Marca Auto</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Vehiculo_OCRA.'">';
  						$infoTable['body'].= '	<td >'.$row->Id_Vehiculo_OCRA.'</td>
										        <td >'.$row->Marca.'</td>
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Vehiculo_OCRA.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Vehiculo_OCRA.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '9':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Marca Moto</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Motocicleta.'">';
  						$infoTable['body'].= '	<td >'.$row->Id_Motocicleta.'</td>
										        <td >'.$row->Marca.'</td>
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Motocicleta.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Motocicleta.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '10':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Escolaridad</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Escolaridad.'">';
  						$infoTable['body'].= '	<td >'.$row->Id_Escolaridad.'</td>
										        <td >'.$row->Escolaridad.'</td>
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Escolaridad.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Escolaridad.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '11':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Parentesco</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Parentezco.'">';
  						$infoTable['body'].= '	<td >'.$row->Id_Parentezco.'</td>
										        <td >'.$row->Parentezco.'</td>
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Parentezco.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Parentezco.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '12':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Forma de Detención</th>
							<th >Descripción</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Forma_Detencion.'">';
  						$infoTable['body'].= '	<td >'.$row->Id_Forma_Detencion.'</td>
										        <td >'.$row->Forma_Detencion.'</td>
												<td >'.$row->Descripcion.'</td>
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Forma_Detencion.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Forma_Detencion.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '13':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Tipo de Violencia</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Tipo_Violencia.'">';
  						$infoTable['body'].= '	<td >'.$row->Id_Tipo_Violencia.'</td>
										        <td >'.$row->Tipo_Violencia.'</td>
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Tipo_Violencia.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Tipo_Violencia.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '14':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Tipo de grupo</th>
  							<th >Valor</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Grupo.'">';
  						$infoTable['body'].= '	<td >'.$row->Id_Grupo.'</td>
										        <td >'.$row->Tipo_Grupo.'</td>
										        <td > '.$row->Valor_Grupo.'</td>
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Grupo.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Grupo.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '15':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Narcótico</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Adiccion.'">';
  						$infoTable['body'].= '	<td >'.$row->Id_Adiccion.'</td>
										        <td >'.$row->Nombre_Adiccion.'</td>
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Adiccion.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Adiccion.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '16':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Tipo de accesorio</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Tipo_Accesorio.'">';
  						$infoTable['body'].= '	<td >'.$row->Id_Tipo_Accesorio.'</td>
										        <td >'.$row->Tipo_Accesorio.'</td>
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Tipo_Accesorio.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Tipo_Accesorio.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '17':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Tipo de vestimenta</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Tipo_Vestimenta.'">';
  						$infoTable['body'].= '	<td >'.$row->Id_Tipo_Vestimenta.'</td>
										        <td >'.$row->Tipo_Vestimenta.'</td>
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Tipo_Vestimenta.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Tipo_Vestimenta.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '18':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Tipo de grupo</th>
  							<th >Zona / Sector</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Zona_Sector.'">';
  						$infoTable['body'].= '	<td >'.$row->Id_Zona_Sector.'</td>
										        <td >'.$row->Tipo_Grupo.'</td>
										        <td > '.$row->Zona_Sector.'</td>
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Zona_Sector.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Zona_Sector.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '19':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Origen del Evento</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Origen_Evento.'">';
  						$infoTable['body'].= '	<td >'.$row->Id_Origen_Evento.'</td>
  												<td >'.$row->Origen.'</td>	  
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Origen_Evento.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Origen_Evento.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '20':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Id vector interno</th>
  							<th >Zona</th>
  							<th >Vector</th>
  							<th >Región</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Vector.'">';
  						$infoTable['body'].= '	<td >'.$row->Id_Vector.'</td>
										        <td >'.$row->Id_Vector_Interno.'</td>
										        <td >'.$row->Zona.'</td>
										        <td >'.$row->Vector.'</td>
										        <td > '.$row->Region.'</td>
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Vector.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Vector.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '21':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Uso del vehículo</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Uso_Vehiculo.'">';
  						$infoTable['body'].= '	<td >'.$row->Id_Uso_Vehiculo.'</td>
  												<td >'.$row->Uso.'</td>	  
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Uso_Vehiculo.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Uso_Vehiculo.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
  				case '22':
  					$infoTable['header'] .= '
  							<th >Id</th>
  							<th >Marca del vehículo</th>
  						';
  					foreach ($catalogoRows as $row) {
  						$infoTable['body'].= '<tr id="tr'.$row->Id_Marca_Io.'">';
  						$infoTable['body'].= '	<td >'.$row->Id_Marca_Io.'</td>
  												<td >'.$row->Marca.'</td>	  
					        ';
					    $infoTable['body'].= '	<td >
						    						<div class="d-flex justify-content-center" id="operaciones">
						    							<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Marca_Io.')"><i class="material-icons">edit</i></button>
						    							<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Marca_Io.')"><i class="material-icons">delete</i></button>
						    						</div>
					    						</td>';
					    $infoTable['body'].= '</tr>';
	  				}
  					
  					break;
				case '23':
					$infoTable['header'] .= '
							<th >Id_Grupo</th>
							<th >Tipo_Grupo</th>
							<th >Valor_Grupo</th>
						';
					foreach ($catalogoRows as $row) {
						$infoTable['body'].= '<tr id="tr'.$row->Id_Grupo_Inspeccion.'">';
						$infoTable['body'].= '	<td >'.$row->Id_Grupo_Inspeccion.'</td>
												<td >'.$row->Tipo_Grupo.'</td>
												<td >'.$row->Valor_Grupo.'</td>	  
							';
						$infoTable['body'].= '	<td >
													<div class="d-flex justify-content-center" id="operaciones">
														<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Grupo_Inspeccion.')"><i class="material-icons">edit</i></button>
														<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Grupo_Inspeccion.')"><i class="material-icons">delete</i></button>
													</div>
												</td>';
						$infoTable['body'].= '</tr>';
					}
				
				break;
				/*Se añaden las vistas de las tablas para los dos nuevos catalogos: tipos y sumbarcas de vehiculos*/
				case '24':
					$infoTable['header'] .= '
							<th >Id_Tipo</th>
							<th >Tipo</th>
						';
					foreach ($catalogoRows as $row) {
						$infoTable['body'].= '<tr id="tr'.$row->Id_Tipo_veh.'">';
						
						$infoTable['body'].= '	<td >'.$row->Id_Tipo_veh.'</td>  
												<td >'.$row->Tipo.'</td>  
							';
						$infoTable['body'].= '	<td >
													<div class="d-flex justify-content-center" id="operaciones">
														<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Tipo_veh.')"><i class="material-icons">edit</i></button>
														<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Tipo_veh.')"><i class="material-icons">delete</i></button>
													</div>
												</td>';
						$infoTable['body'].= '</tr>';
					}
				
				break;
				case '25':
					$infoTable['header'] .= '
							<th >Id_Submarca</th>
							<th >Submarca</th>
						';
					foreach ($catalogoRows as $row) {
						$infoTable['body'].= '<tr id="tr'.$row->Id_Submarca_veh.'">';
						$infoTable['body'].= '	<td >'.$row->Id_Submarca_veh.'</td>
												<td >'.$row->Submarca.'</td>  
							';
						$infoTable['body'].= '	<td >
													<div class="d-flex justify-content-center" id="operaciones">
														<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Submarca_veh.')"><i class="material-icons">edit</i></button>
														<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Submarca_veh.')"><i class="material-icons">delete</i></button>
													</div>
												</td>';
						$infoTable['body'].= '</tr>';
					}
				
				break;
				/*Se añade el catalogo para estados, municipios, calles, colonias, animales, tipo_placanip, cuervo personas y vehiculos, codigos postales*/
				case '26':
					$infoTable['header'] .= '
							<th >Id_categoria</th>
							<th >Categoria</th>
						';
					foreach ($catalogoRows as $row) {
						$infoTable['body'].= '<tr id="tr'.$row->Id_categoria.'">';
						
						$infoTable['body'].= '	<td >'.$row->Id_categoria.'</td>  
												<td >'.$row->Categoria.'</td>  
							';
						$infoTable['body'].= '	<td >
													<div class="d-flex justify-content-center" id="operaciones">
														<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_categoria.')"><i class="material-icons">edit</i></button>
														<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_categoria.')"><i class="material-icons">delete</i></button>
													</div>
												</td>';
						$infoTable['body'].= '</tr>';
					}
				
				break;
				case '27':
					$infoTable['header'] .= '
							<th >Id_Tipo_Animal</th>
							<th >Descripcion</th>
						';
					foreach ($catalogoRows as $row) {
						$infoTable['body'].= '<tr id="tr'.$row->Id_Tipo_Animal.'">';
						
						$infoTable['body'].= '	<td >'.$row->Id_Tipo_Animal.'</td>  
												<td >'.$row->Descripcion.'</td>  
							';
						$infoTable['body'].= '	<td >
													<div class="d-flex justify-content-center" id="operaciones">
														<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Tipo_Animal.')"><i class="material-icons">edit</i></button>
														<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Tipo_Animal.')"><i class="material-icons">delete</i></button>
													</div>
												</td>';
						$infoTable['body'].= '</tr>';
					}
				
				break;
				case '28':
					$infoTable['header'] .= '
							<th >Id_colonia</th>
							<th >Tipo</th>
							<th >Colonia</th>
						';
					foreach ($catalogoRows as $row) {
						$infoTable['body'].= '<tr id="tr'.$row->Id_colonia.'">';
						
						$infoTable['body'].= '	<td >'.$row->Id_colonia.'</td>  
												<td >'.$row->Tipo.'</td>  
												<td >'.$row->Colonia.'</td>  
							';
						$infoTable['body'].= '	<td >
													<div class="d-flex justify-content-center" id="operaciones">
														<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_colonia.')"><i class="material-icons">edit</i></button>
														<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_colonia.')"><i class="material-icons">delete</i></button>
													</div>
												</td>';
						$infoTable['body'].= '</tr>';
					}
				
				break;
				case '29':
					$infoTable['header'] .= '
							<th >Id_calle</th>
							<th >Id_calle_desc</th>
						';
					foreach ($catalogoRows as $row) {
						$infoTable['body'].= '<tr id="tr'.$row->Id_Calle.'">';
						
						$infoTable['body'].= '	<td >'.$row->Id_Calle.'</td>  
												<td >'.$row->Calle.'</td>  
							';
						$infoTable['body'].= '	<td >
													<div class="d-flex justify-content-center" id="operaciones">
														<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_Calle.')"><i class="material-icons">edit</i></button>
														<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_Calle.')"><i class="material-icons">delete</i></button>
													</div>
												</td>';
						$infoTable['body'].= '</tr>';
					}
				
				break;
				case '30':
					$infoTable['header'] .= '
							<th >Id_estado</th>
							<th >Estado</th>
						';
					foreach ($catalogoRows as $row) {
						$infoTable['body'].= '<tr id="tr'.$row->Id_estado.'">';
						
						$infoTable['body'].= '	<td >'.$row->Id_estado.'</td>  
												<td >'.$row->Estado.'</td>  
							';
						$infoTable['body'].= '	<td >
													<div class="d-flex justify-content-center" id="operaciones">
														<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_estado.')"><i class="material-icons">edit</i></button>
														<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_estado.')"><i class="material-icons">delete</i></button>
													</div>
												</td>';
						$infoTable['body'].= '</tr>';
					}
				
				break;
				case '31':
					$infoTable['header'] .= '
							<th >Id_municipio</th>
							<th >Estado</th>
							<th >Municipio</th>
						';
					foreach ($catalogoRows as $row) {
						$infoTable['body'].= '<tr id="tr'.$row->Id_municipio.'">';
						
						$infoTable['body'].= '	<td >'.$row->Id_municipio.'</td>  
												<td >'.$row->Estado.'</td>  
												<td >'.$row->Municipio.'</td>  
							';
						$infoTable['body'].= '	<td >
													<div class="d-flex justify-content-center" id="operaciones">
														<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_municipio.')"><i class="material-icons">edit</i></button>
														<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_municipio.')"><i class="material-icons">delete</i></button>
													</div>
												</td>';
						$infoTable['body'].= '</tr>';
					}
				
				break;
				case '32':
					$infoTable['header'] .= '
							<th >Id Tipo</th>
							<th >Nombre</th>
							<th >Apellido Paterno</th>
							<th >Apellido Materno</th>
							<th >Fecha Registro</th>
						';
					foreach ($catalogoRows as $row) {
						$infoTable['body'].= '<tr id="tr'.$row->id_dato.'">';
						$infoTable['body'].= '	<td >'.$row->id_dato.'</td>  
												<td >'.$row->Nombre.'</td>  
												<td >'.$row->Ap_Paterno.'</td>  
												<td >'.$row->Ap_Materno.'</td> 
												<td >'.$row->Fecha_Registro.'</td> 
							';
						$infoTable['body'].= '	<td >
													<div class="d-flex justify-content-center" id="operaciones">
														<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->id_dato.')"><i class="material-icons">edit</i></button>
														<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->id_dato.')"><i class="material-icons">delete</i></button>
													</div>
												</td>';
						$infoTable['body'].= '</tr>';
					}
				
				break;
				case '33':
					$infoTable['header'] .= '
									<th>Id Dato</th>
									<th>Placa</th>
									<th>NIV</th>
									<th>Fecha Registro</th>
						';
					foreach ($catalogoRows as $row) {
						$infoTable['body'].= '<tr id="tr'.$row->id_dato.'">';						
						$infoTable['body'].= '	<td >'.$row->id_dato.'</td>  
												<td >'.$row->placa.'</td>  
												<td >'.$row->nip.'</td>  
												<td >'.$row->Fecha_Registro.'</td>  
							';
						$infoTable['body'].= '	<td >
													<div class="d-flex justify-content-center" id="operaciones">
														<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->id_dato.')"><i class="material-icons">edit</i></button>
														<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->id_dato.')"><i class="material-icons">delete</i></button>
													</div>
												</td>';
						$infoTable['body'].= '</tr>';
					}
				
				break;
				case '34':
					$infoTable['header'] .= '
							<th >Id_cp</th>
							<th >Codigo_postal</th>
							<th >Nombre</th>
						';
					foreach ($catalogoRows as $row) {
						$infoTable['body'].= '<tr id="tr'.$row->Id_cp.'">';
						
						$infoTable['body'].= '	<td >'.$row->Id_cp.'</td>  
												<td >'.$row->Codigo_postal.'</td>  
												<td >'.$row->Nombre.'</td>  
							';
						$infoTable['body'].= '	<td >
													<div class="d-flex justify-content-center" id="operaciones">
														<button data-toggle="tooltip" data-placement="top" title="Editar registro" class="btn btn-icon btn-edit mr-1 edit-icon" onclick="editAction('.$catalogoActual.','.$row->Id_cp.')"><i class="material-icons">edit</i></button>
														<button data-toggle="tooltip" data-placement="top" title="Eliminar registro" class="btn btn-icon btn-delete delete-icon" onclick="deleteAction('.$catalogoActual.','.$row->Id_cp.')"><i class="material-icons">delete</i></button>
													</div>
												</td>';
						$infoTable['body'].= '</tr>';
					}
				break;
  			}
  			$infoTable['header'].='<th >Operaciones</th>';
	  		return $infoTable;
	}

	public function exportarInfo(){
		if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1)) {
			header("Location: ".base_url."Inicio");
		}

		if (!isset($_REQUEST['tipo_export'])) {
			header("Location: ".base_url."UsersAdmin");
		}
		//se recupera el catalogo actual para poder consultar conforme al mismo
		if (!is_numeric($_REQUEST['catalogoActual']) || !($_REQUEST['catalogoActual']>=MIN_CATALOGO) || !($_REQUEST['catalogoActual']<=MAX_CATALOGO)) 
				$catalogoActual = 1;
			else
				$catalogoActual = $_REQUEST['catalogoActual'];

		$from_where_sentence = "";
		//se genera la sentencia from where para realizar la correspondiente consulta
		if (isset($_REQUEST['cadena'])) 
			$from_where_sentence = $this->Catalogo->generateFromWhereSentence($catalogoActual,$_REQUEST['cadena']);
		else
			$from_where_sentence = $this->Catalogo->generateFromWhereSentence($catalogoActual,"");

		
		
		//var_dump($_REQUEST);
		$tipo_export = $_REQUEST['tipo_export'];

		if ($tipo_export == 'EXCEL') {
			//se realiza exportacion de usuarios a EXCEL
			$cat_rows = $this->Catalogo->getAllInfoCatalogoByCadena($from_where_sentence);
			switch ($catalogoActual) {
				case '1':
					$filename = "catalogo_tatuajes";
					$csv_data="Id,Tipo de Tatuaje,Descripción\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Tatuaje).",\"".
									mb_strtoupper($row->Tipo_Tatuaje)."\",\"".
									mb_strtoupper($row->Descripcion)."\"\n";
					}
					break;
				case '2':
					$filename = "catalogo_instituciones_seguridad";
					$csv_data="Id,Tipo Institución de Seguridad\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Institucion).",\"".
									mb_strtoupper($row->Tipo_Institucion)."\"\n";
					}
					break;
				case '3':
					$filename = "catalogo_medidad_drogas";
					$csv_data="Id,Tipo Medida de Droga\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Medida).",\"".
									mb_strtoupper($row->Tipo_Medida)."\"\n";
					}
					break;
				case '4':
					$filename = "catalogo_faltas_delitos";
					$csv_data="Id,Entidad,Falta/Delito,Estatus,Descripción\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Falta_Delito).",\"".
									mb_strtoupper($row->Entidad)."\",\"".
									mb_strtoupper($row->Falta_Delito)."\",\"".
									mb_strtoupper($row->Status)."\",\"".
									mb_strtoupper($row->Descripcion)."\"\n";
					}
					break;
				case '5':
					$filename = "catalogo_tipos_armas";
					$csv_data="Id,Tipo de Arma\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Tipo_Arma).",\"".
									mb_strtoupper($row->Tipo_Arma)."\"\n";
					}
					break;
				case '6':
					$filename = "catalogo_grupos_delictivos";
					$csv_data="Id,Nombre Grupo,Modus Operandi,Modo Fuga,Descripción\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Grupo).",\"".
									mb_strtoupper($row->Nombre_Grupo)."\",\"".
									mb_strtoupper($row->Modus_Operandi)."\",\"".
									mb_strtoupper($row->Modo_Fuga)."\",\"".
									mb_strtoupper($row->Descripcion)."\"\n";
					}
					break;
				case '7':
					$filename = "catalogo_media_filiacion";
					$csv_data="Id,Tipo MF,Valor MF\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_MF).",\"".
									mb_strtoupper($row->Tipo_MF)."\",\"".
									mb_strtoupper($row->Valor_MF)."\"\n";
					}
					break;
				case '8':
					$filename = "catalogo_vehiculo_ocra";
					$csv_data="Id,Marca (auto)\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Vehiculo_OCRA).",\"".
									mb_strtoupper($row->Marca)."\"\n";
					}
					break;
				case '9':
					$filename = "catalogo_motocicletas";
					$csv_data="Id,Marca (motocicleta)\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Motocicleta).",\"".
									mb_strtoupper($row->Marca)."\"\n";
					}
					break;
				case '10':
					$filename = "catalogo_escolaridad";
					$csv_data="Id,Escolaridad\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Escolaridad).",\"".
									mb_strtoupper($row->Escolaridad)."\"\n";
					}
					break;
				case '11':
					$filename = "catalogo_parentesco";
					$csv_data="Id,Parentesco\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Parentezco).",\"".
									mb_strtoupper($row->Parentezco)."\"\n";
					}
					break;
				case '12':
					$filename = "catalogo_forma_detencion";
					$csv_data="Id,Forma de la Detención,Descripción\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Forma_Detencion).",\"".
									mb_strtoupper($row->Forma_Detencion)."\",\"".
									mb_strtoupper($row->Descripcion)."\"\n";
					}
					break;
				case '13':
					$filename = "catalogo_tipo_violencia";
					$csv_data="Id,Tipo_Violencia\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Tipo_Violencia).",\"".
									mb_strtoupper($row->Tipo_Violencia)."\"\n";
					}
					break;
				case '14':
					$filename = "catalogo_tipo_grupo_policia";
					$csv_data="Id,Tipo_Grupo,Valor\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Grupo).",\"".
									mb_strtoupper($row->Tipo_Grupo)."\",\"".
									mb_strtoupper($row->Valor_Grupo)."\"\n";
					}
					break;
				case '15':
					$filename = "catalogo_narcóticos";
					$csv_data="Id,Nombre del narcótico\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Adiccion).",\"".
									mb_strtoupper($row->Nombre_Adiccion)."\"\n";
					}
					break;
				case '16':
					$filename = "catalogo_tipo_accesorios";
					$csv_data="Id,Tipo_de_accesorio\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Tipo_Accesorio).",\"".
									mb_strtoupper($row->Tipo_Accesorio)."\"\n";
					}
					break;
				case '17':
					$filename = "catalogo_tipo_vestimenta";
					$csv_data="Id,Tipo_de_vestimenta\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Tipo_Vestimenta).",\"".
									mb_strtoupper($row->Tipo_Vestimenta)."\"\n";
					}
					break;
				case '18':
					$filename = "catalogo_zonas_sectores";
					$csv_data="Id,Tipo_Grupo,Zona/Sector\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Zona_Sector).",\"".
									mb_strtoupper($row->Tipo_Grupo)."\",\"".
									mb_strtoupper($row->Zona_Sector)."\"\n";
					}
					break;
				case '19':
					$filename = "catalogo_origen_evento";
					$csv_data="Id,Origen_Evento\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Origen_Evento).",\"".
									mb_strtoupper($row->Origen)."\"\n";
					}
					break;
				case '20':
					$filename = "catalogo_vectores";
					$csv_data="Id,Id Vector Interno,Zona,Vector,Región\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Vector).",\"".
									mb_strtoupper($row->Id_Vector_Interno)."\",\"".
									mb_strtoupper($row->Zona)."\",\"".
									mb_strtoupper($row->Vector)."\",\"".
									mb_strtoupper($row->Region)."\"\n";
					}
					break;
				case '21':
					$filename = "catalogo_vectores";
					$csv_data="Id,Uso del Vehículo\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Uso_Vehiculo).",\"".
									mb_strtoupper($row->Uso)."\"\n";
					}
					break;
				case '22':
					$filename = "catalogo_marca_vehiculos_io";
					$csv_data="Id,Marca del Vehículo\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Marca_Io).",\"".
									mb_strtoupper($row->Marca)."\"\n";
					}
					break;
				case '23':
					$filename = "catalogo_grupos_inspecciones";
					$csv_data="Id,Grupo,Zona/Sector\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Grupo_Inspeccion).",\"".
									mb_strtoupper($row->Tipo_Grupo)."\",\"".
									mb_strtoupper($row->Valor_Grupo)."\"\n";
					}
					break;
				/*Se añaden el nombre del archivo y los encabezados para los 
				dos nuevos catalogos: tipos y submarcas de vehiculos*/
				case '24':
					$filename = "catalogo_tipos_vehiculos";
					$csv_data="Id,Tipo\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Tipo_veh).",\"".
									mb_strtoupper($row->Tipo)."\"\n";
					}
					break;
				case '25':
					$filename = "catalogo_submarcas_vehiculos";
					$csv_data="Id,Submarca\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Submarca_veh).",\"".
									mb_strtoupper($row->Submarca)."\"\n";
					}
					break;
				//Se añade el catalogo para estados, municipios, calles, colonias, animales, tipo_placanip, cuervo personas y vehiculos
				case '26':
					$filename = "catalogo_placas_nivs";
					$csv_data="Id,Categoria\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_categoria).",\"".
									mb_strtoupper($row->Categoria)."\"\n";
					}
					break;
				case '27':
					$filename = "catlogo_animales";
					$csv_data="Id,Tipo\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_Tipo_Animal).",\"".
									mb_strtoupper($row->Descripcion)."\"\n";
					}
					break;
				case '28':
					$filename = "catalogo_colonias";
					$csv_data="Id,tipo,colonia\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_colonia).",\"".
									mb_strtoupper($row->Tipo)."\",\"".
									mb_strtoupper($row->Colonia)."\"\n";
					}
					break;
				case '29':
					$filename = "catalogo_calles";
					$csv_data="Id,calle\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_calle).",\"".
									mb_strtoupper($row->Calle)."\"\n";
					}
					break;
				case '30':
					$filename = "catalogo_estados";
					$csv_data="Id,estado\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_estado).",\"".
									mb_strtoupper($row->Estado)."\"\n";
					}
					break;
				case '31':
					$filename = "catalogo_municipios";
					$csv_data="Id,estado,municipio\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_municipio).",\"".
									mb_strtoupper($row->Estado)."\",\"".
									mb_strtoupper($row->Municipio)."\"\n";
					}
					break;
				case '32':
					$filename = "catalogo_cuervo_personas";
					$csv_data="Id,Nombre,Ap_Paterno Ap_Materno\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->id_dato).",\"".
									mb_strtoupper($row->Nombre)."\",\"".
									mb_strtoupper($row->Ap_Paterno)."\",\"".
									mb_strtoupper($row->Ap_Materno)."\"\n";
					}
					break;
				case '33':
					$filename = "catalogo_cuervo_vehiculos";
					$csv_data="Id,Placa,NIV\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->id_dato).",\"".
									mb_strtoupper($row->placa)."\",\"".
									mb_strtoupper($row->nip)."\"\n";
					}
					break;
				case '34':
					$filename = "catalogo_codigos_postales";
					$csv_data="Id,Codigo postal,Nombre\n";
					foreach ($cat_rows as $row) {
						$csv_data.= mb_strtoupper($row->Id_cp).",\"".
									mb_strtoupper($row->Codigo_postal)."\",\"".
									mb_strtoupper($row->Nombre)."\"\n";
					}
					break;
			}
			//se genera el archivo csv o excel
			$csv_data = utf8_decode($csv_data); //escribir información con formato utf8 por algún acento
			header("Content-Description: File Transfer");
			header("Content-Type: application/force-download");
			header("Content-Disposition: attachment; filename=".$filename.".csv");
			echo $csv_data;
			//header("Location: ".base_url."UsersAdmin");

		}
		elseif($tipo_export == 'PDF'){
			$cat_rows = $this->Catalogo->getAllInfoCatalogoByCadena($from_where_sentence);
			

			header("Content-type: application/pdf");
			header("Content-Disposition: inline; filename=usuarios.pdf");
			echo $this->generarPDF($cat_rows,$_REQUEST['cadena'],$catalogoActual);
		}
		else{
			header("Location: ".base_url."Inicio");
		}
	}

	public function generarPDF($cat_rows,$cadena = "",$catalogoActual = '1'){
		//require('../libraries/PDF library/fpdf16/fpdf.php');
		switch ($catalogoActual) {
			case '1': $filename="Tatuajes";break;
			case '2': $filename="Instituciones Seguridad";break;
			case '3': $filename="Medida de Drogas";break;
			case '4': $filename="Delitos / Faltas";break;
			case '5': $filename="Tipos de Armas";break;
			case '6': $filename="Grupos Delictivos";break;
			case '7': $filename="Media Filiación";break;
			case '8': $filename="Vehículos OCRA";break;
			case '9': $filename="Motocicletas";break;
			case '10': $filename="Escolaridad";break;
			case '11': $filename="Parentesco";break;
			case '12': $filename="Formas de Detención";break;
			case '13': $filename="Tipos de Violencia";break;
			case '14': $filename="Grupos (policía)";break;
			case '15': $filename="Adicciones (narcóticos)";break;
			case '16': $filename="Tipo de accesorios";break;
			case '17': $filename="Tipo de vestimenta";break;
			case '18': $filename="Zonas / Sectores";break;
			case '19': $filename="Origen Evento";break;
			case '20': $filename="Vectores";break;
			case '21': $filename="Uso del Vehículo";break;
			case '22': $filename="Marca del Vehículo";break;
			/*Se añade el nombre para los dos nuevos catalogos: tipos y submarcas de vehiculos*/
			case '24': $filename="Tipos de Vehículo";break;
			case '25': $filename="Submarcas del Vehículo";break;
		}

		$data['subtitulo']      = 'Catálogo: '.$filename;

		if ($cadena != "") {
			$data['msg'] = 'todos los registros con filtro: '.$cadena.'';
		}
		else{
			$data['msg'] = 'todos los registros del catálogo';
		}


		//---Aquí va la info según sea el catálogo seleccionado
		switch ($catalogoActual) {
			case '1': 
				$data['columns'] =  [
	                            'Id',
	                            'Tipo tatuaje',
	                            'Descripción'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Tatuaje',
	                            'Tipo_Tatuaje',
	                            'Descripcion'
                            ]; 
			break;
			case '2': 
				$data['columns'] =  [
	                            'Id',
	                            'Tipo Institución'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Institucion',
	                            'Tipo_Institucion'
                            ];
			break;
			case '3':
				$data['columns'] =  [
	                            'Id',
	                            'Tipo Medida'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Medida',
	                            'Tipo_Medida'
                            ];
			break;
			case '4':
				$data['columns'] =  [
	                            'Id',
	                            'Entidad',
	                            'F/D',
	                            'Status',
	                            'Descripción'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Falta_Delito',
	                            'Entidad',
	                            'Falta_Delito',
	                            'statusAux',
	                            'Descripcion'
                            ];
				
				foreach ($cat_rows as $key => $row){
					$cat_rows[$key]->statusAux = ($row->Status)?"Activo":"Inactivo";
				}
				
			break;
			case '5':
				$data['columns'] =  [
	                            'Id',
	                            'Tipo Arma'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Tipo_Arma',
	                            'Tipo_Arma'
                            ];
			break;
			case '6':
				$data['columns'] =  [
	                            'Id',
	                            'Nombre G',
	                            'Modus Operandi',
	                            'Modo Fuga',
	                            'Descripción'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Grupo',
	                            'Nombre_Grupo',
	                            'Modus_Operandi',
	                            'Modo_Fuga',
	                            'Descripcion'
                            ];
			break;
			case '7':
				$data['columns'] =  [
	                            'Id',
	                            'Tipo MF',
	                            'Valor MF'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_MF',
	                            'Tipo_MF',
	                            'Valor_MF'
                            ];
			break;
			case '8':
				$data['columns'] =  [
	                            'Id vehículo',
	                            'Marca'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Vehiculo_OCRA',
	                            'Marca'
                            ]; 
			break;
			case '9':
				$data['columns'] =  [
	                            'Id motocicleta',
	                            'Marca'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Motocicleta',
	                            'Marca'
                            ];
			break;
			case '10':
				$data['columns'] =  [
	                            'Id escolaridad',
	                            'Escolaridad'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Escolaridad',
	                            'Escolaridad'
                            ]; 
			break;
			case '11':
				$data['columns'] =  [
	                            'Id parentesco',
	                            'Parentesco'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Parentezco',
	                            'Parentezco'
                            ];
			break;
			case '12': 
				$data['columns'] =  [
	                            'Id forma',
	                            'Forma de la Detención',
								'Descripción'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Forma_Detencion',
	                            'Forma_Detencion',
								'Descripcion'
                            ];
			break;
			case '13':
				$data['columns'] =  [
	                            'Id tipo',
	                            'Tipo_Violencia'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Tipo_Violencia',
	                            'Tipo_Violencia'
                            ];
			break;
			case '14':
				$data['columns'] =  [
	                            'Id',
	                            'Tipo grupo',
	                            'Valor'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Grupo',
	                            'Tipo_Grupo',
	                            'Valor_Grupo'
                            ]; 
			break;
			case '15': 
				$data['columns'] =  [
	                            'Id',
	                            'Nombre narcótico'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Adiccion',
	                            'Nombre_Adiccion'
                            ];
			break;
			case '16': 
				$data['columns'] =  [
	                            'Id',
	                            'Tipo de accesorio'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Tipo_Accesorio',
	                            'Tipo_Accesorio'
                            ];
			break;
			case '17':
				$data['columns'] =  [
	                            'Id',
	                            'Tipo de vestimenta'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Tipo_Vestimenta',
	                            'Tipo_Vestimenta'
                            ];
			break;
			case '18':
				$data['columns'] =  [
	                            'Id',
	                            'Tipo grupo',
	                            'Zona Sector'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Zona_Sector',
	                            'Tipo_Grupo',
	                            'Zona_Sector'
                            ]; 
			break;
			case '19': 
				$data['columns'] =  [
	                            'Id',
	                            'Origen del evento'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Origen_Evento',
	                            'Origen'
                            ];
			break;
			case '20':
				$data['columns'] =  [
	                            'Id',
	                            'Id Vector Interno',
	                            'Zona',
	                            'Vector',
	                            'Región'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Vector',
	                            'Id_Vector_Interno',
	                            'Zona',
	                            'Vector',
	                            'Region'
                            ];
			break;
			case '21': 
				$data['columns'] =  [
	                            'Id',
	                            'Uso del vehículo'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Uso_Vehiculo',
	                            'Uso'
                            ];
			break;
			case '22': 
				$data['columns'] =  [
	                            'Id',
	                            'Marca del vehículo'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Marca_Io',
	                            'Marca'
                            ];
			break;
			/*Se añade esta columna faltante que estaba en Git pero no en el servidor de prueba*/
			case '23': 
				$data['columns'] =  [
	                            'Id',
	                            'Tipo Grupo',
								'Valor Grupo'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Grupo_Inspeccion',
	                            'Tipo_Grupo',
								'Valor_Grupo'
                            ];
			break;
			/*Se añaden los nombres de las columnas y los
			nombres para los campos de los dos nuevos
			catalogos: tipos y submarcas de vehiculos*/
			case '24': 
				$data['columns'] =  [
	                            'Id',
	                            'Tipo del vehículo'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Tipo_veh',
	                            'Tipo'
                            ];
			break;
			case '25': 
				$data['columns'] =  [
	                            'Id',
	                            'Submarca del vehículo'
                            ];  
       	 		$data['field_names'] = [
	                            'Id_Submarca_veh',
	                            'Submarca'
                            ];
			break;
		}

		$data['rows'] = $cat_rows;
		//se carga toda la plantilla con la información enviada por parámetro
        $plantilla = MY_PDF::getPlantilla($data);
        //se carga el css de la plantilla
        $css = file_get_contents(base_url.'public/css/template/pdf_style.css');
        // Create an instance of the class:
        $mpdf = new \Mpdf\Mpdf([]);
        // se inserta el css y html cargado
        $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($plantilla, \Mpdf\HTMLParserMode::HTML_BODY);
        // se muestra en pantalla
        $mpdf->Output();
	}

	//función para generar los campos para adición o edición de registros del catálogo
	public function generateFormCatalogo($catalogoActual = 1){
		$formBody = "";
		switch ($catalogoActual) {
			case '1':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
							    <label for="id_tatuaje">Id:</label>
							    <input type="text" class="form-control" id="id_tatuaje" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
							    <label for="id_tipo_tatuaje">Tipo:</label>
							    <input type="text" class="form-control" id="id_tipo_tatuaje" placeholder="Ingrese el tipo de tatuaje">
							</div>
							<div class="col-12 col-md-4 form-group">
							    <label for="id_descripcion">Descripción:</label>
							    <textarea class="form-control" id="id_descripcion" rows="2"></textarea>
							</div>
							';
				break;
			case '2':
				$formBody.='
							<div class="col-12 col-md-2 form-group">
							    <label for="id_institucion">Id:</label>
							    <input type="text" class="form-control" id="id_institucion" value="1" readonly>
							</div>
							<div class="col-12 col-md-6 form-group">
							    <label for="id_tipo_institucion">Tipo de Institución:</label>
							    <input type="text" class="form-control" id="id_tipo_institucion" placeholder="Ingrese el tipo de institución">
							</div>
							';
				break;
			case '3':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
							    <label for="id_medida">Id:</label>
							    <input type="text" class="form-control" id="id_medida" value="1" readonly>
							</div>
							<div class="col-12 col-md-6 form-group">
							    <label for="id_tipo_medida">Tipo de medida:</label>
							    <input type="text" class="form-control" id="id_tipo_medida" placeholder="Ingrese el tipo de medida">
							</div>
							
							';
				break;
			case '4':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
							    <label for="id_delito_falta">Id:</label>
							    <input type="text" class="form-control" id="id_delito_falta" value="1" readonly>
							</div>
							<div class="col-12 col-md-5 form-group">
							    <label for="id_entidad">Entidad:</label>
							    <input type="text" class="form-control" id="id_entidad" placeholder="Ingrese entidad">
							</div>
							<div class="col-12 col-md-3 form-group">
							    <label for="select_FD">Falta o Delito:</label>
							    <select class="form-control" id="select_FD">
							      <option value="F">FALTA</option>
							      <option value="D">DELITO</option>
							    </select>
							</div>
							<div class="col-12 col-md-3 form-group">
							    <label for="select_Status">Estatus:</label>
							    <select class="form-control" id="select_Status">
							      <option value="1">ACTIVO</option>
							      <option value="0">INACTIVO</option>
							    </select>
							</div>
							<div class="col-12 col-md-8 form-group">
							    <label for="id_descripcion">Descripción:</label>
							    <textarea class="form-control" id="id_descripcion" rows="2"></textarea>
							</div>
							';
				break;
			case '5':
				$formBody.='
							<div class="col-12 col-md-2 form-group">
							    <label for="id_tipo_arma">Id:</label>
							    <input type="text" class="form-control" id="id_tipo_arma" value="1" readonly>
							</div>
							<div class="col-12 col-md-6 form-group">
							    <label for="id_tipo_arma_nombre">Tipo de arma:</label>
							    <input type="text" class="form-control" id="id_tipo_arma_nombre" placeholder="Ingrese el tipo de arma">
							</div>
							';
				break;
			case '6':
				$formBody.='
							<div class="col-12 col-md-2 form-group">
							    <label for="id_grupo">Id:</label>
							    <input type="text" class="form-control" id="id_grupo" value="1" readonly>
							</div>
							<div class="col-12 col-md-4 form-group">
							    <label for="id_nombre_g">Nombre Grupo:</label>
							    <input type="text" class="form-control" id="id_nombre_g" placeholder="Nombre del Grupo">
							</div>
							<div class="col-12 col-md-3 form-group">
							    <label for="id_modus_operandi">Modus operandi:</label>
							    <input type="text" class="form-control" id="id_modus_operandi" placeholder="Ingrese el modus operandi">
							</div>
							<div class="col-12 col-md-3 form-group">
							    <label for="id_modo_fuga">Modo de Fuga:</label>
							    <input type="text" class="form-control" id="id_modo_fuga" placeholder="Ingrese el modo de fuga">
							</div>
							<div class="col-12 col-md-8 form-group">
							    <label for="id_descripcion">Descripción:</label>
							    <textarea class="form-control" id="id_descripcion" rows="2"></textarea>
							</div>
							';
				break;
			case '7':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
							    <label for="id_mf">Id:</label>
							    <input type="text" class="form-control" id="id_mf" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
							    <label for="id_tipo_mf">Tipo:</label>
							    <input type="text" class="form-control" id="id_tipo_mf" placeholder="Tipo (cabello, complexión, color ojos, etc...)">
							</div>
							<div class="col-12 col-md-4 form-group">
							    <label for="id_valor_mf">Valor media filiación:</label>
							    <textarea class="form-control" id="id_valor_mf" rows="2"></textarea>
							</div>
							';
				break;
			case '8':
				$formBody.='
							<div class="col-12 col-md-2 form-group">
							    <label for="id_vehiculo_ocra">Id:</label>
							    <input type="text" class="form-control" id="id_vehiculo_ocra" value="1" readonly>
							</div>
							<div class="col-12 col-md-6 form-group">
							    <label for="id_marca">Marca del vehículo (auto):</label>
							    <input type="text" class="form-control" id="id_marca" placeholder="Ingrese la marca">
							</div>
							';
				break;
			case '9':
				$formBody.='
							<div class="col-12 col-md-2 form-group">
							    <label for="id_motocicleta">Id:</label>
							    <input type="text" class="form-control" id="id_motocicleta" value="1" readonly>
							</div>
							<div class="col-12 col-md-6 form-group">
							    <label for="id_marca">Marca del vehículo (moto):</label>
							    <input type="text" class="form-control" id="id_marca" placeholder="Ingrese la marca">
							</div>
							';
				break;
			case '10':
				$formBody.='
							<div class="col-12 col-md-2 form-group">
							    <label for="id_escolaridad">Id:</label>
							    <input type="text" class="form-control" id="id_escolaridad" value="1" readonly>
							</div>
							<div class="col-12 col-md-6 form-group">
							    <label for="id_escolaridad_valor">Escolaridad:</label>
							    <input type="text" class="form-control" id="id_escolaridad_valor" placeholder="Ingrese la escolaridad">
							</div>
							';
				break;
			case '11':
				$formBody.='
							<div class="col-12 col-md-2 form-group">
							    <label for="id_parentezco">Id:</label>
							    <input type="text" class="form-control" id="id_parentezco" value="1" readonly>
							</div>
							<div class="col-12 col-md-6 form-group">
							    <label for="id_parentezco_valor">Parentesco:</label>
							    <input type="text" class="form-control" id="id_parentezco_valor" placeholder="Ingrese el parentesco">
							</div>
							';
				break;
			case '12':
				$formBody.='
							<div class="col-12 col-md-2 form-group">
							    <label for="id_forma_detencion">Id:</label>
							    <input type="text" class="form-control" id="id_forma_detencion" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
							    <label for="id_forma_detencion_valor">Forma de Detención:</label>
							    <input type="text" class="form-control" id="id_forma_detencion_valor" placeholder="Ingrese forma de detención">
							</div>
							<div class="col-12 col-md-3 form-group">
							    <label for="id_descripcion">Descripción:</label>
							    <input type="text" class="form-control" id="id_descripcion" placeholder="Ingrese la descripción">
							</div>
							';
				break;
			case '13':
				$formBody.='
							<div class="col-12 col-md-2 form-group">
							    <label for="id_tipo_violencia">Id:</label>
							    <input type="text" class="form-control" id="id_tipo_violencia" value="1" readonly>
							</div>
							<div class="col-12 col-md-6 form-group">
							    <label for="id_tipo_violencia_valor">Tipo de Violencia:</label>
							    <input type="text" class="form-control" id="id_tipo_violencia_valor" placeholder="Ingrese tipo de violencia">
							</div>
							';
				break;
			case '14':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
							    <label for="id_grupo">Id:</label>
							    <input type="text" class="form-control" id="id_grupo" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
							    <label for="id_tipo_grupo">Tipo grupo:</label>
							    <input type="text" class="form-control" id="id_tipo_grupo" placeholder="Ingrese el tipo de grupo">
							</div>
							<div class="col-12 col-md-4 form-group">
							    <label for="id_valor_grupo">Valor grupo:</label>
							    <textarea class="form-control" id="id_valor_grupo" rows="2"></textarea>
							</div>
							';
				break;
			case '15':
				$formBody.='
							<div class="col-12 col-md-2 form-group">
							    <label for="id_adiccion">Id:</label>
							    <input type="text" class="form-control" id="id_adiccion" value="1" readonly>
							</div>
							<div class="col-12 col-md-6 form-group">
							    <label for="id_nombre_adiccion">Nombre del narcótico:</label>
							    <input type="text" class="form-control" id="id_nombre_adiccion" placeholder="Ingrese el narcótico">
							</div>
							';
				break;
			case '16':
				$formBody.='
							<div class="col-12 col-md-2 form-group">
							    <label for="id_tipo_accesorio">Id:</label>
							    <input type="text" class="form-control" id="id_tipo_accesorio" value="1" readonly>
							</div>
							<div class="col-12 col-md-6 form-group">
							    <label for="id_tipo_accesorio_valor">Tipo de accesorio:</label>
							    <input type="text" class="form-control" id="id_tipo_accesorio_valor" placeholder="Ingrese el tipo de accesorio">
							</div>
							';
				break;
			case '17':
				$formBody.='
							<div class="col-12 col-md-2 form-group">
							    <label for="id_tipo_vestimenta">Id:</label>
							    <input type="text" class="form-control" id="id_tipo_vestimenta" value="1" readonly>
							</div>
							<div class="col-12 col-md-6 form-group">
							    <label for="id_tipo_vestimenta_valor">Tipo de vestimenta:</label>
							    <input type="text" class="form-control" id="id_tipo_vestimenta_valor" placeholder="Ingrese el tipo de vestimenta">
							</div>
							';
				break;
			case '18':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
							    <label for="id_zona_sector">Id:</label>
							    <input type="text" class="form-control" id="id_zona_sector" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
							    <label for="id_tipo_grupo">Tipo grupo:</label>
							    <input type="text" class="form-control" id="id_tipo_grupo" placeholder="Ingrese el tipo de grupo">
							</div>
							<div class="col-12 col-md-4 form-group">
							    <label for="id_zona_sector_valor">Zona/Sector:</label>
							    <textarea class="form-control" id="id_zona_sector_valor" rows="2"></textarea>
							</div>
							';
				break;
			case '19':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
							    <label for="id_origen_evento">Id:</label>
							    <input type="text" class="form-control" id="id_origen_evento" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
							    <label for="id_origen">Origen del evento:</label>
							    <input type="text" class="form-control" id="id_origen" placeholder="Ingrese el origen del evento">
							</div>
							';
				break;
			case '20':
				$formBody.='
							<div class="col-12 col-md-2 form-group">
							    <label for="id_grupo">Id:</label>
							    <input type="text" class="form-control" id="id_vector" value="1" readonly>
							</div>
							<div class="col-12 col-md-4 form-group">
							    <label for="id_nombre_g">Id Vector Interno:</label>
							    <input type="text" class="form-control" id="id_vector_i" placeholder="Id del Vector Interno">
							</div>
							<div class="col-12 col-md-3 form-group">
							    <label for="id_modus_operandi">Zona:</label>
							    <input type="text" class="form-control" id="id_zona" placeholder="Ingrese la zona (1 - 9 ó CH para centro histórico)">
							</div>
							<div class="col-12 col-md-3 form-group">
							    <label for="id_modo_fuga">Vector:</label>
							    <input type="text" class="form-control" id="id_vector_numero" placeholder="Ingrese el número del vector">
							</div>
							<div class="col-12 col-md-8 form-group">
							    <label for="id_descripcion">Región:</label>
							    <input type="text" class="form-control" id="id_region" placeholder="Ingrese la región (Norte, Centro, Sur, CH)">
							</div>
							';
				break;
			case '21':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
							    <label for="id_origen_evento">Id:</label>
							    <input type="text" class="form-control" id="id_uso_vehiculo" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
							    <label for="id_origen">Uso del Vehículo:</label>
							    <input type="text" class="form-control" id="id_uso" placeholder="Ingrese el uso del vehículo">
							</div>
							';
				break;
			case '22':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
							    <label for="id_origen_evento">Id:</label>
							    <input type="text" class="form-control" id="id_marca_vehiculo" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
							    <label for="id_origen">Marca del Vehículo:</label>
							    <input type="text" class="form-control" id="id_marca" placeholder="Ingrese la marca del vehículo">
							</div>
							';
				break;
			case '23':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
								<label for="id_grupo">Id:</label>
								<input type="text" class="form-control" id="id_grupo" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
								<label for="id_tipo_grupo">Tipo grupo:</label>
								<input type="text" class="form-control" id="id_tipo_grupo" placeholder="Ingrese el tipo de grupo">
							</div>
							<div class="col-12 col-md-4 form-group">
								<label for="id_valor_grupo">Valor grupo:</label>
								<textarea class="form-control" id="id_valor_grupo" rows="2"></textarea>
							</div>
							';
				break;
			/*Se añaden los elementos para agregar nuevos elementos a los dos
			nuevos catalogos: tipos y sumbarcas de vehiculos*/
			case '24':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
								<label for="id_tipo_veh">Id:</label>
								<input type="text" class="form-control" id="id_tipo_veh" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
								<label for="id_tipo_veh_desc">Tipo de vehiculo:</label>
								<input type="text" class="form-control" id="id_tipo_veh_desc" placeholder="Ingrese el tipo de vehiculo">
							</div>
							';
				break;
			case '25':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
								<label for="id_submarca_veh">Id:</label>
								<input type="text" class="form-control" id="id_submarca_veh" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
								<label for="id_submarca_desc">Submarca de vehiculo:</label>
								<input type="text" class="form-control" id="id_submarca_desc" placeholder="Ingrese la submarca de vehiculo">
							</div>
							';
				break;
			
				//Se añade el catalogo para estados, municipios, calles, colonias, animales, tipo_placanip, cuervo personas y vehiculos
			case '26':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
								<label for="Id_categoria">Id:</label>
								<input type="text" class="form-control" id="Id_categoria" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
								<label for="Id_categoria_desc">Tipo de placa/niv:</label>
								<input type="text" class="form-control" id="Id_categoria_desc" placeholder="Ingrese el tipo de placa/niv">
							</div>
							';
				break;
			case '27':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
								<label for="Id_Tipo_Animal">Id:</label>
								<input type="text" class="form-control" id="Id_Tipo_Animal" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
								<label for="Descripcion">Descripcion:</label>
								<input type="text" class="form-control" id="Descripcion" placeholder="Ingrese descripcion">
							</div>
							';
				break;
			case '28':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
								<label for="Id_colonia">Id:</label>
								<input type="text" class="form-control" id="Id_colonia" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
								<label for="tipo">Tipo de colonia:</label>
								<input type="text" class="form-control" id="tipo" placeholder="Ingrese el tipo de colonia">
							</div>
							<div class="col-12 col-md-4 form-group">
								<label for="colonia">Nombre de la colonia:</label>
								<input type="text" class="form-control" id="colonia" placeholder="Ingrese el nombre de la colonia">
							</div>
							';
				break;
			case '29':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
								<label for="Id_calle">Id:</label>
								<input type="text" class="form-control" id="Id_calle" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
								<label for="Id_calle_desc">Nombre de la calle/niv:</label>
								<input type="text" class="form-control" id="Id_calle_desc" placeholder="Ingrese el nombre de la calle">
							</div>
							';
				break;
			case '30':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
								<label for="Id_estado">Id:</label>
								<input type="text" class="form-control" id="Id_estado" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
								<label for="Estado">Nombre del estado:</label>
								<input type="text" class="form-control" id="Estado" placeholder="Ingrese el nombre del estado">
							</div>
							';
				break;
			case '31':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
								<label for="Id_municipio">Id:</label>
								<input type="text" class="form-control" id="Id_municipio" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
								<label for="Id_municipio_desc">Nombre del estado:</label>
								<input type="text" class="form-control" id="Id_municipio_desc" placeholder="Ingrese el nombre del estado">
							</div>
							<div class="col-12 col-md-3 form-group">
								<label for="Id_municipio_m">Nombre del municipio:</label>
								<input type="text" class="form-control" id="Id_municipio_m" placeholder="Ingrese el nombre del municipio">
							</div>
							';
				break;
			case '32':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
								<label for="Id_categoria">Id:</label>
								<input type="text" class="form-control" id="id_dato" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
								<label for="Categoria">Nombre:</label>
								<input type="text" class="form-control" id="Nombre" placeholder="Ingrese el nombre">
								<span class="span_error" id="errorcombinado1"></span>
							</div>
							<div class="col-12 col-md-3 form-group">
								<label for="Categoria">Apellido Paterno:</label>
								<input type="text" class="form-control" id="Ap_Paterno" placeholder="Ingrese el Apellido Paterno">
								<span class="span_error" id="errorcombinado2"></span>
							</div>
							<div class="col-12 col-md-3 form-group">
								<label for="Categoria">Apellido_Materno:</label>
								<input type="text" class="form-control" id="Ap_Materno" placeholder="Ingrese el Apellido Materno">
							</div>
							';
				break;
			case '33':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
								<label for="Id_categoria">Id:</label>
								<input type="text" class="form-control" id="id_dato" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
								<label for="Categoria">Placa:</label>
								<input type="text" class="form-control" id="placa" placeholder="Ingrese la placa">
								<span class="span_error" id="errorcombinado1"></span>
							</div>
							<div class="col-12 col-md-3 form-group">
								<label for="Categoria">NIV:</label>
								<input type="text" class="form-control" id="nip" placeholder="Ingrese el niv">
								<span class="span_error" id="errorcombinado2"></span>
							</div>
							';
				break;
			case '34':
				$formBody.='
							<div class="col-12 col-md-1 form-group">
								<label for="Id_cp">Id:</label>
								<input type="text" class="form-control" id="Id_cp" value="1" readonly>
							</div>
							<div class="col-12 col-md-3 form-group">
								<label for="Codigo_postal">Codigo postal</label>
								<input type="text" class="form-control" id="Codigo_postal" placeholder="Ingrese el codigo postal">
							</div>
							<div class="col-12 col-md-3 form-group">
								<label for="Nombre">Nombre:</label>
								<input type="text" class="form-control" id="Nombre" placeholder="Ingrese el nombre">
							</div>
							';
				break;
			
		}
		return $formBody;
	}

	//función Fetch para crear o actualizar en catálogo seleccionado
	public function sendFormFetch(){
		if (!isset($_SESSION['userdata']) || $_SESSION['userdata']->Modo_Admin!=1) {
            header("Location: ".base_url."Login");
            exit();
        }

        if (!isset($_POST['postForm'])) {
        	header("Location: ".base_url."Catalogos");
        }
        
        //variable de respuesta al insertar o actualizar
        $response = $this->Catalogo->InsertOrUpdateCatalogo($_POST); //se manda el POST y todo el desmadre se realiza en el modelo

        echo json_encode($response);
	}

	//función Fetch para crear o actualizar en catálogo seleccionado
	public function deleteFormFetch(){
		if (!isset($_SESSION['userdata']) || $_SESSION['userdata']->Modo_Admin!=1) {
            header("Location: ".base_url."Login");
            exit();
        }

        if (!isset($_POST['deletePostForm'])) {
        	header("Location: ".base_url."Catalogos");
        }
        
        //variable de respuesta al insertar o actualizar
        $response = $this->Catalogo->deleteCatalogoRow($_POST); //se manda el POST y todo el desmadre se realiza en el modelo

        echo json_encode($response);
	}
	/*Se añaden funciones para catalogo de colonias y calles*/
	public function getColonias()
    {
        $data = $this->Catalogo->getColonias();
        echo json_encode($data);
    }
    public function getAllCalles()
    {
        $data = $this->Catalogo->getCalles();
        echo json_encode($data);
    }
	/*Funciones para colonias y calles de catalogo y mapas con MAP BOX*/
    public function getColonia()
    {
        $data = $this->Catalogo->getColoniaCatalogo($_POST['termino']);
        echo json_encode($data);
    }
    public function getCalles()
    {
        $data = $this->Catalogo->getCallesCatalogo($_POST['termino']);
        echo json_encode($data);
    }
    public function getCP()
    {
        $data = $this->Catalogo->getCPCatalogo($_POST['cp']);
        echo json_encode($data);
    }
	public function getIncidenciasCuervosPersonas(){

        $response = $this->Catalogo->getIncidenciasCuervosPersonas(); 

        echo json_encode($response);
	}

	public function getIncidenciasCuervosVehiculos(){

        $response = $this->Catalogo->getIncidenciasCuervosVehiculos(); 

        echo json_encode($response);
	}

	public function getCatalogoPlacaNip(){

        $response = $this->Catalogo->getCatalogoPlacaNip(); 

        echo json_encode($response);
	}
	public function getCatalogoPersonas(){

        $response = $this->Catalogo->getCatalogoPersonas(); 

        echo json_encode($response);
	}
	
	public function getSubmarcasTermino(){
		$data = $this->Catalogo->getSubmarcaCatalogo($_POST['termino']);
        echo json_encode($data);
	}
	public function getMarcasTermino(){
		$data = $this->Catalogo->getMarcaCatalogo($_POST['termino']);
        echo json_encode($data);
	}
	public function getAMarcas()
    {
        $data = $this->Catalogo->getAMarcas();
        echo json_encode($data);
    }
	public function getSMarcas()
    {
        $data = $this->Catalogo->getSMarcas();
        echo json_encode($data);
    }

}

?>