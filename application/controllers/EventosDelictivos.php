<?php
/*
	filtros:
	1  - View general de Eventos delictivos
	2  - Elementos participantes de cada ED
	3  - Ubicacion de los hechos ED
	4  - Observación vehiculos
	5  - Situación
	6  - Objetos robados
	7  - Objetos recuperados/asegurados
	8  - Responsables ED
	9  - Peticionarios ED
	10 - Usuarios del sistema

	FormValidator usage
	$_POST['inputText'] = "  ";
    $this->formValidator->validate($_POST,'inputText','required | numeric | max_length[5] | min_length[2] | date')
*/
class EventosDelictivos extends Controller
{
	public $EventoD;	//model
	public $Catalogo;   //model
	public $numColumnsED; //número de columnas por cada filtro
	public $FV;// mi formValidator
	public function __construct(){
		$this->EventoD = $this->model("EventoD");
		$this->Catalogo = $this->model("Catalogo");
		$this->numColumnsED = [34,34,34];	//se inicializa el número de columns por cada filtro
		$this->FV = new FormValidator(); //instancia de formValidator
	}

	public function index(){
		//comprobar los permisos para dejar pasar al módulo
		if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Evento_D[2] != '1')) {
            header("Location: ".base_url."Inicio");
            exit();
        }

        
        //Titulo de la pagina y archivos css y js necesarios
		$data = [
            'titulo'    => 'Planeación | Eventos D',
            'extra_css' => '<link rel="stylesheet" href="'. base_url . 'public/css/system/eventosD/index.css">',
            'extra_js'  => '<script src="'. base_url . 'public/js/system/eventosD/index.js"></script>'
        ];

        //PROCESO DE FILTRADO DE EVENTOS DELICTIVOS

        if (isset($_GET['filtro']) && is_numeric($_GET['filtro']) && $_GET['filtro']>=MIN_FILTRO_ED && $_GET['filtro']<=MAX_FILTRO_ED) { //numero de catálogo
	        $filtro = $_GET['filtro'];
	    } 
	    else {
	        $filtro = 1;
	    }

	    //PROCESAMIENTO DE LAS COLUMNAS 
	    $this->setColumnsSession($filtro);
	    $data['columns_ED'] = $_SESSION['userdata']->columns_ED;

	    //PROCESAMIENTO DE RANGO DE FOLIOS
	    if (isset($_POST['rango_inicio']) && isset($_POST['rango_fin'])) {
	    	$_SESSION['userdata']->rango_inicio_ed = $_POST['rango_inicio'];
	    	$_SESSION['userdata']->rango_fin_ed = $_POST['rango_fin'];
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

	    $where_sentence = $this->EventoD->generateFromWhereSentence($cadena,$filtro);
		$where_sentence = $where_sentence.' DESC';
	    $extra_cad = ($cadena != "")?("&cadena=".$cadena):""; //para links conforme a búsqueda

	    $no_of_records_per_page = NUM_MAX_REG_PAGE; //total de registros por pagination
	    $offset = ($numPage-1) * $no_of_records_per_page; // desplazamiento conforme a la pagina

	    $results_rows_pages = $this->EventoD->getTotalPages($no_of_records_per_page,$where_sentence);	//total de páginas de acuerdo a la info de la DB
	    $total_pages = $results_rows_pages['total_pages'];

	    if ($numPage>$total_pages) {$numPage = 1; $offset = ($numPage-1) * $no_of_records_per_page;} //seguridad si ocurre un error por url 	
	    
	    $rows_Eventos = $this->EventoD->getDataCurrentPage($offset,$no_of_records_per_page,$where_sentence);	//se obtiene la información de la página actual

	    //guardamos la tabulacion de la información para la vista
	    $data['infoTable'] = $this->generarInfoTable($rows_Eventos,$filtro);
		//guardamos los links en data para la vista
		$data['links'] = $this->generarLinks($numPage,$total_pages,$extra_cad,$filtro);
		//número total de registros encontrados
		$data['total_rows'] = $results_rows_pages['total_rows'];
		//filtro actual para Fetch javascript
		$data['filtroActual'] = $filtro;
		$data['dropdownColumns'] = $this->generateDropdownColumns($filtro);

		switch ($filtro) {
			case '1': $data['filtroNombre'] = "Vista general"; break;
		}

		$this->view("templates/header",$data);
		$this->view("system/eventosD/eventoDView",$data);
		$this->view("templates/footer",$data);
	}

	//creación de nuevo evento delictivo
	public function nuevoEventoD(){
		
		if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Evento_D[3] != '1')) {
            header("Location: ".base_url."Inicio");
            exit();
        }
        
        $data = [
			'titulo' 	=> 'Planeación | Nuevo Evento D',
			'extra_css' => '<link rel="stylesheet" href="'. base_url . 'public/css/general/root.css">
							<link rel="stylesheet" href="'. base_url . 'public/css/system/eventosD/nuevoED.css">',
        	'extra_js'  => '<script src="'. base_url . 'public/js/system/eventosD/nuevo/Peticiones.js"></script>
							<script src="'. base_url . 'public/js/system/eventosD/nuevo/responsablesTable.js"></script>
							<script src="'. base_url . 'public/js/system/eventosD/nuevo/sendGetData.js"></script>
							<script src="'. base_url . 'public/js/system/eventosD/nuevo/eventsDom.js"></script>
							<script src="'. base_url . 'public/js/system/juridico/generalFunctions.js"></script>'
			// 'eventos'	=> $this->getEventos(),
		];
			
		$this->view('templates/header',$data);
		$this->view('system/eventosD/eventoDelictivoForm',$data);
		$this->view('templates/footer',$data);

	}

	public function editarRegistro($folio = null)
	{
		if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Evento_D[3] != '1')) {
            header("Location: ".base_url."Inicio");
            exit();
        }
        
        $data = [
			'titulo' 	=> 'Planeación | Nuevo Evento D',
			'extra_css' => '<link rel="stylesheet" href="'. base_url . 'public/css/general/root.css">
							<link rel="stylesheet" href="'. base_url . 'public/css/system/eventosD/nuevoED.css">',
        	'extra_js'  => '<script src="'. base_url . 'public/js/system/eventosD/nuevo/Peticiones.js"></script>
							<script src="'. base_url . 'public/js/system/eventosD/nuevo/responsablesTable.js"></script>
							<script src="'. base_url . 'public/js/system/eventosD/nuevo/sendGetData.js"></script>
							<script src="'. base_url . 'public/js/system/eventosD/nuevo/eventsDom.js"></script>
							<script src="'. base_url . 'public/js/system/juridico/generalFunctions.js"></script>',
			// 'eventos'	=> $this->getEventos(),
			'folio'    => $folio
		];
			
		$this->view('templates/header',$data);
		$this->view('system/eventosD/eventoDelictivoForm',$data);
		$this->view('templates/footer',$data);
	}

	//función para generar la paginación dinámica
	public function generarLinks($numPage,$total_pages,$extra_cad = "",$filtro = 1){
			//$extra_cad sirve para determinar la paginacion conforme a si se realizó una busqueda
			//Creación de links para el pagination
			$links = "";

			//FLECHA IZQ (PREV PAGINATION)
			if ($numPage>1) {
				$links.= '<li class="page-item">
							<a class="page-link" href=" '.base_url.'EventosDelictivos/index/?numPage=1'.$extra_cad.'&filtro='.$filtro.' " data-toggle="tooltip" data-placement="top" title="Primera página">
								<i class="material-icons">first_page</i>
							</a>
						</li>';
				$links.= '<li class="page-item">
							<a class="page-link" href=" '.base_url.'EventosDelictivos/index/?numPage='.($numPage-1).$extra_cad.'&filtro='.$filtro.' " data-toggle="tooltip" data-placement="top" title="Página anterior">
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
								<a class="page-link" href=" '.base_url.'EventosDelictivos/index/?numPage='.($ind).$extra_cad.'&filtro='.$filtro.' ">
									'.($ind).'
								</a>
							</li>';
				}
			}

			//FLECHA DERECHA (NEXT PAGINATION)
			if ($numPage<$total_pages) {

				$links.= '<li class="page-item">
							<a class="page-link" href=" '.base_url.'EventosDelictivos/index/?numPage='.($numPage+1).$extra_cad.'&filtro='.$filtro.' " data-toggle="tooltip" data-placement="top" title="Siguiente página">
							<i class="material-icons">navigate_next</i>
							</a>
						</li>';
				$links.= '<li class="page-item">
							<a class="page-link" href=" '.base_url.'EventosDelictivos/index/?numPage='.($total_pages).$extra_cad.'&filtro='.$filtro.' " data-toggle="tooltip" data-placement="top" title="Última página">
							<i class="material-icons">last_page</i>
							</a>
						</li>';
			}

			return $links;
	}

	//función para generar la información de la tabla de forma dinámica
	public function generarInfoTable($rows,$filtro = 1){
			//se genera la tabulacion de la informacion por backend
			$infoTable['header'] = "";
			$infoTable['body'] = "";
	
	  			
			switch ($filtro) {
				//$campos = ['Folio','Zona','Vector','Colonia','Tipo de Evento','Violencia','Hora Reporte'];
				case '1':
				case '2':
				case '3': //general
					$infoTable['header'] .= '
						<th class="column1">Folio</th>
						<th class="column2">Zona</th>
						<th class="column3">Vector</th>
						<th class="column4">Cia</th>
						<th class="column5">Fecha</th>
						<th class="column6">Hora Reporte</th>
						<th class="column7">Dom. Calle</th>
						<th class="column8">Num.</th>
						<th class="column9">y Calle</th>
						<th class="column10">Tipo Colonia</th>
						<th class="column11">Colonia</th>
						<th class="column12">Tipo Evento</th>
						<th class="column13">Giro Evento</th>
						<th class="column14">Caracteristicas Evento</th>
						<th class="column15">Objetos Robados</th>
						<th class="column16">Observaciones</th>
						<th class="column17">Marca</th>
						<th class="column18">Tipo</th>
						<th class="column19">Año</th>
						<th class="column20">Placas</th>
						<th class="column21">Color</th>
						<th class="column22">Situación</th>
						<th class="column23">Con Detenidos</th>
						<th class="column24">Cuantos</th>
						<th class="column25">Hombres</th>
						<th class="column26">Mujeres</th>
						<th class="column27">Remisiones</th>
						<th class="column28">Con Violencia</th>
						<th class="column29">Tipo Arma</th>
						<th class="column30">Modus Operandi</th>
						<th class="column31">Modo Fuga</th>
						<th class="column32">Responsables</th>
						<th class="column33">Peticionario</th>
						<th class="column34">Teléfono</th>
					';
					foreach ($rows as $row) {
						$violencia = ($row->Con_Violencia === '1') ? 'SI' : 'NO';
						$detenidos = ($row->Detenidos === '1') ? 'SI' : 'NO';
						if($row->Responsables == ',,,'){
							$responsables = '';
						}else{
							$responsables= '';
							$responsablesAux = explode('|||', $row->Responsables);
							foreach($responsablesAux as $key=>$responsable){
								$responsable = explode(',',$responsable);
								$sexo = ($responsable[3] == 'M') ? 'MUJER' : 'HOMBRE';
								$indice = $key+1;
								$responsables .= $indice.'. Remisión: '.$responsable[0].', Nombre: '.$responsable[1].', Edad: '.$responsable[2].', Sexo: '.$sexo.'</br>';
							}
						}
						$infoTable['body'].= '<tr id="tr'.$row->Folio_N.'">';
						$infoTable['body'].= '	<td class="column1">'.$row->Folio_N.'</td>
									        <td class="column2">'.strtoupper($row->Zona).'</td>
									        <td class="column3">'.strtoupper($row->Vector).'</td>
									        <td class="column4">'.strtoupper($row->Cia).'</td>
									        <td class="column5">'.$row->Fecha.'</td>
									        <td class="column6">'.$row->Hora_Reporte.'</td>
									        <td class="column7">'.strtoupper($row->Calle_1).'</td>
									        <td class="column8">'.strtoupper($row->Numero).'</td>
									        <td class="column9">'.strtoupper($row->Calle_2).'</td>
									        <td class="column10">'.strtoupper($row->Colonia_Tipo).'</td>
									        <td class="column11">'.strtoupper($row->Colonia).'</td>
									        <td class="column12">'.strtoupper($row->Motivo_Evento).'</td>
									        <td class="column13">'.strtoupper($row->Giro_Evento).'</td>
									        <td class="column14">'.strtoupper($row->Caracteristica_Evento).'</td>
									        <td class="column15">'.strtoupper($row->Objetos_Robados).'</td>
									        <td class="column16">'.strtoupper($row->Observaciones).'</td>
									        <td class="column17">'.strtoupper($row->Marca).'</td>
									        <td class="column18">'.strtoupper($row->Tipo_Vehiculo).'</td>
									        <td class="column19">'.$row->Year.'</td>
									        <td class="column20">'.strtoupper($row->Placas).'</td>
									        <td class="column21">'.strtoupper($row->Color).'</td>
									        <td class="column22">'.strtoupper($row->Situacion).'</td>
									        <td class="column23">'.$detenidos.'</td>
									        <td class="column24">'.$row->Num_Detenidos.'</td>
									        <td class="column25">'.$row->Hombres.'</td>
									        <td class="column26">'.$row->Mujeres.'</td>
									        <td class="column27">'.$row->Remisiones.'</td>
									        <td class="column28">'.$violencia.'</td>
									        <td class="column29">'.strtoupper($row->Tipo_Arma).'</td>
									        <td class="column30">'.strtoupper($row->Modus_Operandi).'</td>
									        <td class="column31">'.strtoupper($row->Modo_Fuga).'</td>
									        <td class="column32">'.$responsables.'</td>
									        <td class="column33">'.strtoupper($row->Full_Name_Peticionario).'</td>
									        <td class="column34">'.$row->Telefono_Peticionario.'</td>
				        ';
				        $infoTable['body'].= '<td class="d-flex justify-content-center">
												<a class="myLinks mb-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="right" title="Abrir registro" href="' . base_url . 'EventosDelictivos/editarRegistro/'.$row->Folio_N.'">
													<i class="material-icons">app_registration</i>
												</a>
												<a class="myLinks mb-3 ml-3 d-flex justify-content-center btn_delete_folio" data-toggle="tooltip" data-placement="right" title="Eliminar Registro" data-id="'.$row->Id_ED.'">
													<i class="material-icons">delete</i>
												</a>
									        </td>
											';
				    	$infoTable['body'].= '</tr>';
					}
				break;
			}
  			
  			$infoTable['header'].='<th >Operaciones</th>';

	  		return $infoTable;
	}

	//función para generar los links respectivos dependiendo del filtro y/o cadena de búsqueda
	public function generarExportLinks($extra_cad = "",$filtro = 1){
		if ($extra_cad != "") {
			$dataReturn['csv'] =  base_url.'EventosDelictivos/exportarInfo/?tipo_export=CSV'.$extra_cad.'&filtroActual='.$filtro;
			$dataReturn['excel'] =  base_url.'EventosDelictivos/exportarInfo/?tipo_export=EXCEL'.$extra_cad.'&filtroActual='.$filtro;
			$dataReturn['pdf'] =  base_url.'EventosDelictivos/exportarInfo/?tipo_export=PDF'.$extra_cad.'&filtroActual='.$filtro;
			//return $dataReturn;
		}
		else{
			$dataReturn['csv'] =  base_url.'EventosDelictivos/exportarInfo/?tipo_export=CSV'.$extra_cad.'&filtroActual='.$filtro;
			$dataReturn['excel'] =  base_url.'EventosDelictivos/exportarInfo/?tipo_export=EXCEL'.$extra_cad.'&filtroActual='.$filtro;
			$dataReturn['pdf'] =  base_url.'EventosDelictivos/exportarInfo/?tipo_export=PDF'.$extra_cad.'&filtroActual='.$filtro;
		}
		return $dataReturn;
	}

	//función fetch para buscar por la cadena introducida dependiendo del filtro
	public function buscarPorCadena(){
		/*Aquí van condiciones de permisos*/

		if (isset($_POST['cadena'])) {
			$cadena = trim($_POST['cadena']); 
			$filtroActual = trim($_POST['filtroActual']);

			$results = $this->EventoD->getEventoDByCadena($cadena,$filtroActual);
			$extra_cad = ($cadena != "")?("&cadena=".$cadena):""; //para links conforme a búsqueda

			//$dataReturn = "jeje";

			$dataReturn['infoTable'] = $this->generarInfoTable($results['rows_Eventos'],$filtroActual);
			$dataReturn['links'] = $this->generarLinks($results['numPage'],$results['total_pages'],$extra_cad,$filtroActual);
			$dataReturn['export_links'] = $this->generarExportLinks($extra_cad,$filtroActual);
			$dataReturn['total_rows'] = "Total registros: ".$results['total_rows'];
			$dataReturn['dropdownColumns'] = $this->generateDropdownColumns($filtroActual);

			
			echo json_encode($dataReturn);
		}
		else{
			header("Location: ".base_url."Inicio");
			exit();
		}
	}

	//función para exportar la inforación dependiendo del filtro 
	public function exportarInfo(){
		/*checar permisos*/

		if (!isset($_REQUEST['tipo_export'])) {
			header("Location: ".base_url."Inicio");
			exit();
		}
		//se recupera el catalogo actual para poder consultar conforme al mismo
		if (!isset($_REQUEST['filtroActual']) || !is_numeric($_REQUEST['filtroActual']) || !($_REQUEST['filtroActual']>=MIN_FILTRO_ED) || !($_REQUEST['filtroActual']<=MAX_FILTRO_ED)) 
				$filtroActual = 1;
			else
				$filtroActual = $_REQUEST['filtroActual'];

		$from_where_sentence = "";
		//se genera la sentencia from where para realizar la correspondiente consulta
		if (isset($_REQUEST['cadena'])) 
			$from_where_sentence = $this->EventoD->generateFromWhereSentence($_REQUEST['cadena'],$filtroActual);
		else
			$from_where_sentence = $this->EventoD->generateFromWhereSentence("",$filtroActual);
		//var_dump($_REQUEST);
		$tipo_export = $_REQUEST['tipo_export'];

		if ($tipo_export == 'EXCEL') {
			//se realiza exportacion de usuarios a EXCEL
			$rows_ED = $this->EventoD->getAllInfoEventoDByCadena($from_where_sentence);
			switch ($filtroActual) {
				case '1':
				case '2':
				case '3':
					$filename = "ED_general";
					$csv_data="Folio,Zona,Vector,Cia,Fecha,Hora Reporte,Dom. Calle,Num.,y Calle,Tipo Colonia,Colonia,Tipo Evento,Giro Evento, Caracteristicas Evento,Objetos Robados,Observaciones,Marca,Tipo,Año,Placas,Color,Situación,Con Detenidos,Cuantos,Hombres,Mujeres,Remisiones,Con Violencia,Tipo Arma,Modus Operandi,Modo Fuga,Responsables,Peticionario,Teléfono\n";

					foreach ($rows_ED as $row) {
						$violencia = ($row->Con_Violencia === '1') ? 'SI' : 'NO';
						$detenidos = ($row->Detenidos === '1') ? 'SI' : 'NO';
						if($row->Responsables == ',,,'){
							$responsables = '';
						}else{
							$responsables= '';
							$responsablesAux = explode('|||', $row->Responsables);
							foreach($responsablesAux as $key=>$responsable){
								$responsable = explode(',',$responsable);
								$sexo = ($responsable[3] == 'M') ? 'MUJER' : 'HOMBRE';
								$indice = $key+1;
								$responsables .= $indice.'. Remisión: '.$responsable[0].', Nombre: '.$responsable[1].', Edad: '.$responsable[2].', Sexo: '.$sexo.'</br>';
							}
						}
						$csv_data.= $row->Folio_N.",\"".
									strtoupper($row->Zona)."\",\"".
									strtoupper($row->Vector)."\",\"".
									strtoupper($row->Cia)."\",\"".
									$row->Fecha."\",\"".
									$row->Hora_Reporte."\",\"".
									strtoupper($row->Calle_1)."\",\"".
									strtoupper($row->Numero)."\",\"".
									strtoupper($row->Calle_2)."\",\"".
									strtoupper($row->Colonia_Tipo)."\",\"".
									strtoupper($row->Colonia)."\",\"".
									strtoupper($row->Motivo_Evento)."\",\"".
									strtoupper($row->Giro_Evento)."\",\"".
									strtoupper($row->Caracteristica_Evento)."\",\"".
									strtoupper($row->Objetos_Robados)."\",\"".
									strtoupper($row->Observaciones)."\",\"".
									strtoupper($row->Marca)."\",\"".
									strtoupper($row->Tipo_Vehiculo)."\",\"".
									$row->Year."\",\"".
									strtoupper($row->Placas)."\",\"".
									strtoupper($row->Color)."\",\"".
									strtoupper($row->Situacion)."\",\"".
									$detenidos."\",\"".
									$row->Num_Detenidos."\",\"".
									$row->Hombres."\",\"".
									$row->Mujeres."\",\"".
									$row->Remisiones."\",\"".
									$violencia."\",\"".
									strtoupper($row->Tipo_Arma)."\",\"".
									strtoupper($row->Modus_Operandi)."\",\"".
									strtoupper($row->Modo_Fuga)."\",\"".
									$responsables."\",\"".
									strtoupper($row->Full_Name_Peticionario)."\",\"".
									strtoupper($row->Telefono_Peticionario)."\"\n";
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
			$rows_ED = $this->EventoD->getAllInfoEventoDByCadena($from_where_sentence);
			

			header("Content-type: application/pdf");
			header("Content-Disposition: inline; filename=usuarios.pdf");
			echo $this->generarPDF($rows_ED,$_REQUEST['cadena'],$filtroActual);
		}
		else{
			header("Location: ".base_url."Inicio");
			exit();
		}
	}

	//función para armar el archivo PDF dependiendo del filtro y/o cadena de búsqueda
	public function generarPDF($rows_ED,$cadena = "",$filtroActual = '1'){
		//require('../libraries/PDF library/fpdf16/fpdf.php');
		switch ($filtroActual) {
			case '1': $filename="Vista general";break;
		}

		$data['subtitulo']      = 'Eventos Delictivos: '.$filename;

		if ($cadena != "") {
			$data['msg'] = 'todos los registros de Eventos Delictivos con filtro: '.$cadena.'';
		}
		else{
			$data['msg'] = 'todos los registros de Eventos Delictivos';
		}

		//---Aquí va la info según sea el filtro de ED seleccionado
		switch ($filtroActual) {
			case '1':
				$data['columns'] =  [
	                            'Folio',
	                            'Sector',
	                            'Cia',
	                            'Fecha',
	                            'Hora robo',
	                            'Tipo robo',
	                            '#Element',
	                            '#Obj rob',
	                            '#Obj rec',
	                            '#Resp'
                            ];  
       	 		$data['field_names'] = [
	                            'Folio_N',
	                            'Sector',
	                            'Cia',
	                            'Fecha',
	                            'Hora_Robo',
	                            'Tipo_Robo',
	                            'Num_Elementos_P',
	                            'Num_Obj_Rob',
	                            'Num_Obj_Recup',
	                            'Num_Responsables'
                            ];
			break;
			
		}
		//---fin de la info del ED
		
		$data['rows'] = $rows_ED;
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

	//funcion para borrar variable sesión para filtro de rangos de fechas
	public function removeRangosFechasSesion(){

		if (isset($_REQUEST['filtroActual'])) {
			unset($_SESSION['userdata']->rango_inicio_ed);
			unset($_SESSION['userdata']->rango_fin_ed);

			header("Location: ".base_url."EventosDelictivos/index/?filtro=".$_REQUEST['filtroActual']);
		}
		else{
			header("Location: ".base_url."Inicio");
			exit();
		}
		
	}

	//función que filtra las columnas deseadas por el usuario
	public function generateDropdownColumns($filtro=1){
		//parte de permisos

		$dropDownColumn = '';
		//generación de dropdown dependiendo del filtro
		switch ($filtro) {
			case '1':
			case '2':
			case '3':
				//$campos = ['Folio','Zona','Vector','Colonia','Tipo de Evento','Violencia','Hora Reporte'];
				$campos = ['Folio','Zona','Vector','Cia','Fecha','Hora Reporte','Dom. Calle','Num.','y Calle','Tipo Colonia','Colonia','Tipo Evento','Giro Evento', 'Caracteristicas Evento','Objetos Robados','Observaciones','Marca','Tipo','Año','Placas','Color','Situación','Con Detenidos','Cuantos','Hombres','Mujeres','Remisiones','Con Violencia','Tipo Arma','Modus Operandi','Modo Fuga','Responsables','Peticionario','Teléfono'];
			break;
		}
		//gestión de cada columna
		$ind = 1;
		foreach($campos as $campo){
			$checked = ($_SESSION['userdata']->columns_ED['column'.$ind] == 'show')?'checked':'';
			$dropDownColumn.= '	<div class="form-check">
							        <input class="form-check-input checkColumns" type="checkbox" value="'.$_SESSION['userdata']->columns_ED['column'.$ind].'" onchange="hideShowColumn(this.id);" id="column'.$ind.'" '.$checked.'>
							        <label class="form-check-label" for="column'.$ind.'">
							            '.$campo.'
							        </label>
							    </div>';
			$ind++;
		}
		$dropDownColumn.= '		<div class="dropdown-divider">
							    </div>
								<div class="form-check">
							        <input id="checkAll" class="form-check-input" type="checkbox" value="show" onchange="hideShowAll(this.id);" id="column'.$ind.'">
							        <label class="form-check-label" for="column'.$ind.'">
							            Todo
							        </label>
							    </div>';
		return $dropDownColumn;
	}

	//función para checar los cambios de filtro y poder asignar los valores correspondientes de las columnas a la session
	public function setColumnsSession($filtroActual=1){
		//si el filtro existe y esta dentro de los parámetros continua
		if (isset($_SESSION['userdata']->filtro_ED) && $_SESSION['userdata']->filtro_ED >= MIN_FILTRO_ED && $_SESSION['userdata']->filtro_ED<=MAX_FILTRO_ED ) {
			//si cambia el filtro se procde a cambiar los valores de las columnas que contiene el filtro seleccionado
			if ($_SESSION['userdata']->filtro_ED != $filtroActual) {
				$_SESSION['userdata']->filtro_ED = $filtroActual;
				unset($_SESSION['userdata']->columns_ED); //se borra las columnas del anterior filtro
				//se asignan las nuevas columnas y por default se muestran todas (atributo show)
				for($i=0;$i<$this->numColumnsED[$_SESSION['userdata']->filtro_ED -1];$i++)
					$_SESSION['userdata']->columns_ED['column'.($i+1)] = ($i+1 == 1 || $i+1 == 2 || $i+1 == 3 || $i+1 == 11 || $i+1 == 12 || $i+1 == 28 || $i+1 == 6) ? 'show' : 'hide';

			}
		}
		else{ //si no existe el filtro entonces se inicializa con el primero por default
			$_SESSION['userdata']->filtro_ED = $filtroActual;
			unset($_SESSION['userdata']->columns_ED);
			for($i=0;$i<$this->numColumnsED[$_SESSION['userdata']->filtro_ED -1];$i++)
				$_SESSION['userdata']->columns_ED['column'.($i+1)] = ($i+1 == 1 || $i+1 == 2 || $i+1 == 3 || $i+1 == 11 || $i+1 == 12 || $i+1 == 28 || $i+1 == 6) ? 'show' : 'hide';

			
		}
		//echo "filtro: ".var_dump($_SESSION['userdata']->filtro_ED)."<br>br>";
		//echo "columns: ".var_dump($_SESSION['userdata']->columns_ED)."<br>br>";
	}

	//función fetch que actualiza los valores de las columnas para la session
	public function setColumnFetch(){
		if (isset($_POST['columName']) && isset($_POST['valueColumn'])) {
			$_SESSION['userdata']->columns_ED[$_POST['columName']] = $_POST['valueColumn'];
			echo json_encode("ok");
		}
		else{
			header("Location: ".base_url."Inicio");
			exit();
		}
	}

	public function getEventos(){
		$data =  $this->Catalogo->getEventos($_POST['termino']);
        echo json_encode ($data);
	}

	public function getColonia()
    {
        $data = $this->Catalogo->getColonia($_POST['termino']);
        echo json_encode($data);
    }


	/* ----- ----- ----- Insertar Actualizar Evento ----- ----- ----- */
	public function insertUpdateEvento()
	{
		/* echo json_encode($_POST);
		return; */
		if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Evento_D[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
        }else{
			if (isset($_POST['btn_evento'])) {

				$k = 0;
                $valid[$k++] = $data_p['folio_no_error']    = $this->FV->validate($_POST, 'folio_no', 'required');
                $valid[$k++] = $data_p['fecha_error']    = $this->FV->validate($_POST, 'fecha', 'required | date');
                $valid[$k++] = $data_p['hora_reporte_error']    = $this->FV->validate($_POST, 'hora_reporte', 'required | time');

				$success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

				if($success){
					$sql = $this->EventoD->insertUpdateEvento($_POST);
					if($sql['status']){
						$data_p['status'] = true;
						$data_p['response'] = $sql;
					}else{
						$data_p['status'] = false;
						$data_p['error_message'] = $sql['error_message'];
					}
				}else{
					$data_p['status'] = false;
                    $data_p['error_message'] = 'Validación formulario';
				}
			}else{
				$data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizado, por favor verifica tu información';
			}
		}
		echo json_encode($data_p);
	}

	public function getDataEvento()
	{
		echo json_encode($this->EventoD->existeRegistroTabla('ed_view_filtro_1', ['Folio_N'], [$_POST['folio']]));
	}

	public function existFolio()
	{
		$data = $this->EventoD->existeRegistroTabla('ed_evento', ['Folio_N'], [$_POST['id_evento']]);
		if($data){
			if($data->Status == '0'){
				$response = false;
			}else{
				$response = true;
			}
		}else{
			$response = false;
		}
		echo json_encode($response);
	}

	public function existFicha()
	{
		echo json_encode($this->EventoD->existFicha($_POST['ficha']));
	}

	public function deleteFolio()
	{
		if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Evento_D[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
        }else{
			if (isset($_POST['id'])) {
				$delete = $this->EventoD->deleteFolio($_POST['id']);
				if($delete['status']){
					$data_p['status'] = true;
				}else{
					$data_p['status'] = false;
					$data_p['error_message'] = $delete['error_message'];
				}
			}else{
				$data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizado, por favor verifica tu información';
			}
			echo json_encode($data_p);
		}
	}

	public function existRemisiones()
	{
		$remisiones = explode(',',$_POST['remisiones']);
		$response = array();
		foreach($remisiones as $remision){
			$remision = trim($remision);
			$data = $this->EventoD->existRemision($remision);
			if($data['status']){
				array_push($response, array(
						'status'   => $data['status'],
						'remision' => $remision,
						'data'     => $data['data']
					)
				);
			}else{
				array_push($response, array(
					'status'        => $data['status'],
					'remision'      => $remision,
					'message_error' => $data['message_error']
				));
			}
		}

		echo json_encode($response);
		//echo json_encode($this->EventoD->existRemision($_POST['remisiones']));
	}
}

?>