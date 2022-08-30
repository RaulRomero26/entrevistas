<?php
class InteligenciaOperativa extends Controller
{
    public $InteligenciaOperativaM;
    public $FV;
    public $Historial;
    public $datos_InteligenciaOp;

    public function __construct()
    {
        $this->InteligenciaOperativaM = $this->model('InteligenciaOperativaM');
        $this->numColumnsIO = [31];
        $this->FV = new FormValidator();
        $this->Historial = $this->model('Historial');

        $this->datos_InteligenciaOp = [
            'origenEvento'      => $this->getOrigenEvento(),
            'motivo'            => $this->getFaltaDelito(),
            'tipoViolencia'     => $this->getTipoViolencia(),
            'zona'              => $this->getZone(),
            'vector'            => $this->getVector(),
            'marcasVehiculos'   => $this->getMarcasVehiculos(),
            'usoVehiculo'       => $this->getUsoVehiculo()
        ];
    }

    public function index()
    {

        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Inteligencia_Op[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $data = [
            'titulo'    => 'Planeación | Inteligencia Operativa',
            'extra_css'  => '<link rel="stylesheet" href="' . base_url . 'public/css/admin/index.css">',
            'extra_js'  => '<script src="' . base_url . 'public/js/system/InteligenciaOperativa/buscar_Cadena.js"></script>'
        ];

        if (isset($_GET['filtro']) && is_numeric($_GET['filtro']) && $_GET['filtro'] >= MIN_FILTRO_IO && $_GET['filtro'] <= MAX_FILTRO_IO) {
            $filtro = $_GET['filtro'];
        } else {
            $filtro = 1;
        }

        $this->setColumnsSession($filtro);
        if (isset($_POST['rango_inicio']) && isset($_POST['rango_fin'])) {
            $_SESSION['userdata']->rango_inicio_io = $_POST['rango_inicio'];
            $_SESSION['userdata']->rango_fin_io = $_POST['rango_fin'];
            $_SESSION['userdata']->rango_hora_inicio_io = $_POST['rango_hora_inicio'];
            $_SESSION['userdata']->rango_hora_fin_io = $_POST['rango_hora_fin'];
        }

        if (isset($_GET['numPage'])) {
            $numPage = $_GET['numPage'];
            if (!(is_numeric($numPage))) {
                $numPage = 1;
            }
        } else {
            $numPage = 1;
        }

        $cadena = "";
        if (isset($_GET['cadena'])) {
            $cadena = $_GET['cadena'];
            $data['cadena'] = $cadena;
        }

        $where_sentence = $this->InteligenciaOperativaM->generateWhereSentence($cadena, $filtro);
        $extra_cad = ($cadena != "") ? ("&cadena=" . $cadena) : "";

        $no_of_records_per_page = NUM_MAX_REG_PAGE;
        $offset = ($numPage - 1) * $no_of_records_per_page;

        $results_rows_pages = $this->InteligenciaOperativaM->getTotalPages($no_of_records_per_page, $where_sentence);
        $total_pages = $results_rows_pages['total_pages'];

        if ($numPage > $total_pages) {
            $numPage = 1;
            $offset = ($numPage - 1) * $no_of_records_per_page;
        }

        $rows_io = $this->InteligenciaOperativaM->getDataCurrentPage($offset, $no_of_records_per_page, $where_sentence);
        /* var_dump($rows_io); */

        $data['infoTable'] = $this->generateInfoTable($rows_io, $filtro);
        //var_dump($data['infoTable']);
        $data['links'] = $this->generateLinks($numPage, $total_pages, $extra_cad, $filtro);
        $data['total_rows'] = $results_rows_pages['total_rows'];
        $data['filtroActual'] = $filtro;
        $data['dropdownColumns'] = $this->generateDropdownColumns($filtro);

        switch($filtro){
            case '1':
                $data['filtroNombre'] = "Todos";
            break;
        }

        $this->view('templates/header', $data);
        $this->view('system/inteligenciaOperativa/indexIO', $data);
        $this->view('templates/footer', $data);
    }

    public function nuevaIO()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Inteligencia_Op[3] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $data = [
            'titulo'    => 'Planeación | Inteligencia Operativa',
            'extra_css' => '<link rel="stylesheet" href="' . base_url . 'public/css/system/inteligenciaOperativa/index.css">',
            'extra_js'  => '<script src="https://maps.googleapis.com/maps/api/js?key=' . API_KEY . '&callback=initMap&libraries=places" async defer></script>' .
                '<script src="' . base_url . 'public/js/maps/inteligenciaOperativa/index.js"></script>' .
                '<script src="' . base_url . 'public/js/system/InteligenciaOperativa/vehiculos.js"></script>' .
                '<script src="' . base_url . 'public/js/system/InteligenciaOperativa/camaras.js"></script>' .
                '<script src="' . base_url . 'public/js/system/InteligenciaOperativa/index.js"></script>',
            'datos_InteligenciaOp'    => $this->datos_InteligenciaOp
        ];
        $this->view('templates/header', $data);
        $this->view('system/inteligenciaOperativa/inteligenciaOperativaView', $data);
        $this->view('templates/footer', $data);
    }

    public function verIO()
    {

        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Inteligencia_Op[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        if (is_numeric($_GET['id_Inteligencia'])) {
            if ($this->InteligenciaOperativaM->inteligenciaExiste($_GET['id_Inteligencia']) == 0) {
                header("Location: " . base_url . "Inicio");
                exit();
            }
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $data = [
            'titulo'    => 'Planeación | Inteligencia Operativa',
            'extra_css' => '<link rel="stylesheet" href="' . base_url . 'public/css/system/inteligenciaOperativa/index.css">',
            'extra_js'  => '<script src="' . base_url . 'public/js/system/InteligenciaOperativa/vehiculos.js"></script>' .
                            '<script src="' . base_url . 'public/js/system/InteligenciaOperativa/camaras.js"></script>' .
                            '<script src="' . base_url . 'public/js/system/InteligenciaOperativa/getDataVer.js"></script>' 
            
        ];

        $this->Historial->insertHistorial(13,'Ver registro I.O.:'.$_GET['id_Inteligencia']);
        $this->view('templates/header', $data);
        $this->view('system/inteligenciaOperativa/inteligenciaOperativaVer', $data);
        $this->view('templates/footer', $data);
    }

    public function editarIO()
    {

        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Inteligencia_Op[3] != '1') || (!isset($_GET['id_Inteligencia']))) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        if (is_numeric($_GET['id_Inteligencia'])) {
            if ($this->InteligenciaOperativaM->inteligenciaExiste($_GET['id_Inteligencia']) == 0) {
                header("Location: " . base_url . "Inicio");
                exit();
            }
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $data = [
            'titulo'    => 'Planeación | Inteligencia Operativa',
            'extra_css' => '<link rel="stylesheet" href="' . base_url . 'public/css/system/inteligenciaOperativa/index.css">',
            'extra_js'  => '<script src="https://maps.googleapis.com/maps/api/js?key=' . API_KEY . '&callback=initMap&libraries=places" async defer></script>' .
                '<script src="' . base_url . 'public/js/maps/inteligenciaOperativa/index.js"></script>' .
                '<script src="' . base_url . 'public/js/system/InteligenciaOperativa/vehiculos.js"></script>' .
                '<script src="' . base_url . 'public/js/system/InteligenciaOperativa/camaras.js"></script>' .
                '<script src="' . base_url . 'public/js/system/InteligenciaOperativa/getData.js"></script>',
            'datos_InteligenciaOp'    => $this->datos_InteligenciaOp
        ];
        
        $this->view('templates/header', $data);
        $this->view('system/inteligenciaOperativa/inteligenciaOperativaEditar', $data);
        $this->view('templates/footer', $data);
    }

    public function getData(){
        $data = $this->InteligenciaOperativaM->getDataInteligenciaById(0, $_POST['id_Inteligencia']);
        echo json_encode($data);
    }

    public function buscarPorCadena()
    {
        if(isset($_POST['cadena'])){
            $cadena = trim($_POST['cadena']);
            $filtroActual = trim($_POST['filtroActual']);

            $results = $this->InteligenciaOperativaM->getHistorialByCadena($cadena,$filtroActual);
            $extra_cad = ($cadena != "")?("&cadena=".$cadena):"";

            $dataReturn['infoTable'] = $this->generateInfoTable($results['rows_Hisroriales'],$filtroActual);
            $dataReturn['links'] = $this->generateLinks($results['numPage'],$results['total_pages'],$extra_cad,$filtroActual);

            $dataReturn['export_links'] = $this->generateExportLinks($extra_cad,$filtroActual);
            $dataReturn['total_rows'] = "Total registros: ".$results['total_rows'];
            $dataReturn['dropdownColumns'] = $this->generateDropdownColumns($filtroActual);

            $this->Historial->insertHistorial(14,'Consulta realizada: '.$cadena);

            echo json_encode($dataReturn);
        }
    }

    public function setColumnFetch(){
        if(isset($_POST['columnName']) && isset($_POST['valueColumn'])){
            $_SESSION['userdata']->columns_HIS[$_POST['columnName']] = $_POST['valueColumn'];
            echo json_encode('ok');
        }
    }

    public function generateExportLinks($extra_cad = "",$filtro = 1)
    {
        if($extra_cad != ""){
            $dataReturn['csv']   =  base_url.'InteligenciaOperativa/exportarInfo/?tipo_export=CSV'.$extra_cad.'&filtroActual='.$filtro;
            $dataReturn['excel'] =  base_url.'InteligenciaOperativa/exportarInfo/?tipo_export=EXCEL'.$extra_cad.'&filtroActual='.$filtro;
            $dataReturn['pdf']   =  base_url.'InteligenciaOperativa/exportarInfo/?tipo_export=PDF'.$extra_cad.'&filtroActual='.$filtro;
        }else{
            $dataReturn['csv']   =  base_url.'InteligenciaOperativa/exportarInfo/?tipo_export=CSV'.$extra_cad.'&filtroActual='.$filtro;
            $dataReturn['excel'] =  base_url.'InteligenciaOperativa/exportarInfo/?tipo_export=EXCEL'.$extra_cad.'&filtroActual='.$filtro;
            $dataReturn['pdf']   =  base_url.'InteligenciaOperativa/exportarInfo/?tipo_export=PDF'.$extra_cad.'&filtroActual='.$filtro;
        }

        return $dataReturn;
    }

    public function exportarInfo()
    {
        if(!isset($_REQUEST['tipo_export'])){
            header("Location: ".base_url."Inicio");
            exit();
        }

        if(!isset($_REQUEST['filtroActual']) || !is_numeric($_REQUEST['filtroActual']) || !($_REQUEST['filtroActual']>=MIN_FILTRO_IO) || !($_REQUEST['filtroActual']<=MAX_FILTRO_IO)){
            $filtroActual = 1;
        }else{
            $filtroActual = $_REQUEST['filtroActual'];
        }

        $from_where_sentence = "";

        if(isset($_REQUEST['cadena'])){
            $from_where_sentence = $this->InteligenciaOperativaM->generateWhereSentence($_REQUEST['cadena'],$filtroActual);
        }else{
            $from_where_sentence = $this->InteligenciaOperativaM->generateWhereSentence("",$filtroActual);
        }

        $tipo_export = $_REQUEST['tipo_export'];

        if($tipo_export == 'EXCEL'){
            $rows_IO = $this->InteligenciaOperativaM->getAllInfoHistorialByCadena($from_where_sentence);
            $filename = 'IO_general';

            /* var_dump($rows_IO); */
            $csv_data = "ID,Nombre del elemento responsable, Responsable de turno, Origen del evento, Fecha del turno, Turno, Semana, Folio DERI, Fecha del evento, Hora del reporte, Motivo, Características del robo, Violencia, Tipo de violencia, Zona del evento, Vector, Unidad del primer respondiente, Información del primer respondiente, Acciones, ¿Se identificarón responsables?, ¿Detención por información de I.O?, Elementos que realizan la detención, Fecha de detención, Compañía, Vehículos, Domicilios, Camaras\n";
            foreach ($rows_IO as $row) {

                $vehiculos = "";
                $domicilios = "";
                $camaras = "";
                $vehiculos_array = explode('|', $row->vehiculos);
                $domicilios_array = explode('|', $row->domicilio);
                $camaras_array = explode('|', $row->camaras);

                foreach($vehiculos_array as $key=>$vehiculo){
                    if(strlen(trim($vehiculo)) > 0){
                        $vehiculos .= ($vehiculo) ? ($key+1).".- ".trim($vehiculo) : "";
                    }
                }

                foreach($domicilios_array as $key=>$domicilio){
                    if(strlen(trim($domicilio)) > 0){
                        $domicilios .= ($domicilio) ? ($key+1).".- ".trim($domicilio) : "";
                    }
                }

                foreach($camaras_array as $key=>$camara){
                    if(strlen(trim($camara)) > 0){
                        $camaras .= ($camara) ? ($key+1).".- ".trim($camara)."<br>" : "";
                    }
                }

                
                $csv_data.= $row->Id_Inteligencia_Io.",\"".
                            $row->Nombre_Elemento_R.",\",\"".
                            $row->Responsable_Turno."\",\"".
                            $row->Origen_Evento."\",\"".
                            $row->Fecha_Turno."\",\"".
                            $row->Turno."\",\"".
                            $row->Semana."\",\"".
                            $row->Folio_Deri."\",\"".
                            $row->Fecha_Evento."\",\"".
                            $row->Hora_Reporte."\",\"".
                            $row->Motivo."\",\"".
                            $row->Caracteristicas_Robo."\",\"".
                            $row->Violencia."\",\"".
                            $row->Tipo_Violencia."\",\"".
                            $row->Zona_Evento."\",\"".
                            $row->Vector."\",\"".
                            $row->Unidad_Primer_R."\",\"".
                            $row->Informacion_Primer_R."\",\"".
                            $row->Acciones."\",\"".
                            $row->Identificacion_Responsables."\",\"".
                            $row->Detencion_Por_Info_Io."\",\"".
                            $row->Elementos_Realizan_D."\",\"".
                            $row->Fecha_Detencion."\",\"".
                            $row->Compania."\",\"".
                            $vehiculos."\",\"".
                            $domicilios."\",\"".
                            $camaras."\"\n";
            }
            
            $csv_data = utf8_decode($csv_data);

            header("Content-Description: File Transfer");
            header("Content-Type: application/force-download");
            header("Content-Disposition: attachment; filename=".$filename."_IO.csv");
            echo $csv_data;
        }elseif($tipo_export == 'PDF'){
            $data = [
                'titulo'    => 'Historial',
            ];

            $rows_HIS = $this->Historial->getAllInfoHistorialByCadena($from_where_sentence);
            $data['infoTable'] = $this->generateInfoTable($rows_HIS,$filtroActual);

            $this->view('system/historial/His_general_view',$data);
        }else{
            header("Location: ".base_url."Historiales");
            exit();
        }
    }

    public function setColumnsSession($filtroActual = 1)
    {
        if (isset($_SESSION['userdata']->filtro_IO) && $_SESSION['userdata']->filtro_IO >= MIN_FILTRO_IO && $_SESSION['userdata']->filtro_IO <= MAX_FILTRO_IO) {
            if ($_SESSION['userdata']->filtro_IO != $filtroActual) {
                $_SESSION['userdata']->filtro_IO = $filtroActual;
                unset($_SESSION['userdata']->columns_IO);
                for ($i = 0; $i < $this->numColumnsIO[$_SESSION['userdata']->filtro_IO - 1]; $i++) {
                    $_SESSION['userdata']->columns_IO['column' . ($i + 1)] = 'show';
                }
            }
        } else {
            $_SESSION['userdata']->filtro_IO = $filtroActual;
            unset($_SESSION['userdata']->columns_IO);
            for ($i = 0; $i < $this->numColumnsIO[$_SESSION['userdata']->filtro_IO - 1]; $i++) {
                $_SESSION['userdata']->columns_IO['column' . ($i + 1)] = 'show';
            }
        }
    }

    public function generateInfoTable($rows, $filtro = 1)
    {
        $infoTable['header'] = "";
        $infoTable['body'] = "";
        $infoTable['header'] .= '<th >Operaciones</th>';
        $infoTable['header'] .= '
            <th class="column1">ID</th>
            <th class="column2">Nombre del elemento responsable</th>
            <th class="column3">Responsable de turno</th>
            <th class="column4">Origen del evento</th>
            <th class="column5">Fecha del turno</th>
            <th class="column6">Turno</th>
            <th class="column7">Semana</th>
            <th class="column8">Folio DERI</th>
            <th class="column9">Fecha del evento</th>
            <th class="column10">Hora del reporte</th>
            <th class="column11">Motivo</th>
            <th class="column12">Características del robo</th>
            <th class="column13">Violencia</th>
            <th class="column14">Tipo de violencia</th>
            <th class="column15">Zona del evento</th>
            <th class="column16">Vector</th>
            <th class="column17">Unidad del primer respondiente</th>
            <th class="column18">Información del primer respondiente</th>
            <th class="column19">Acciones</th>
            <th class="column20">¿Se identificarón responsables?</th>
            <th class="column21">¿Detención por información de I.O?</th>
            <th class="column22">Elementos que realizan la detención</th>
            <th class="column23">Fecha de detención</th>
            <th class="column24">Compañía</th>
            <th class="column25">Vehículos</th>
            <th class="column26">Domicilio</th>
            <th class="column27">Cámaras</th>
        ';
        foreach ($rows as $row) {
            $vehiculos = "";
            $domicilios = "";
            $camaras = "";
            $vehiculos_array = explode('|', $row->vehiculos);
            $domicilios_array = explode('|', $row->domicilio);
            $camaras_array = explode('|', $row->camaras);
            
            foreach($vehiculos_array as $key=>$vehiculo){
                if(strlen(trim($vehiculo)) > 0){
                    $vehiculos .= ($vehiculo) ? ($key+1).".- ".trim($vehiculo)."<br>" : "";
                }
            }
            
            foreach($domicilios_array as $key=>$domicilio){
                if(strlen(trim($domicilio)) > 0){
                    $domicilios .= ($domicilio) ? ($key+1).".- ".trim($domicilio)."<br>" : "";
                }
            }
            
            foreach($camaras_array as $key=>$camara){
                if(strlen(trim($camara)) > 0){
                    $camaras .= ($camara) ? ($key+1).".- ".trim($camara)."<br>" : "";
                }
            }

            $infoTable['body'].='<tr>';

            $infoTable['body'].= '<td>
                    <a class="myLinks mb-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="right" title="Editar registro" href="'.base_url.'InteligenciaOperativa/editarIO/?id_Inteligencia='.$row->Id_Inteligencia_Io.'">
                        <i class="material-icons">edit</i>
                    </a>
                    <a class="myLinks mt-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="right" title="Ver registro" href="'.base_url.'InteligenciaOperativa/verIO/?id_Inteligencia='.$row->Id_Inteligencia_Io.'">
                        <i class="material-icons">visibility</i>
                    </a>
                </td>';
            
            $primer_respondiente = "";
            (strlen($row->Informacion_Primer_R) > 100) ? $primer_respondiente = substr($row->Informacion_Primer_R, 0, 100).'...' : $row->Informacion_Primer_R;
            
            $acciones = "";
            (strlen($row->Acciones) > 100) ? $acciones = substr($row->Acciones, 0, 100).'...' : $row->Acciones;
            
            $elementos = "";
            (strlen($row->Elementos_Realizan_D) > 100) ? $elementos = substr($row->Elementos_Realizan_D, 0, 100).'...' : $row->Elementos_Realizan_D;
            
            $infoTable['body'].='
                <td class="column2">'.$row->Id_Inteligencia_Io.'</td>
                <td class="column3">'.strtoupper($row->Nombre_Elemento_R).'</td>
                <td class="column4">'.strtoupper($row->Responsable_Turno).'</td>
                <td class="column4">'.strtoupper($row->Origen_Evento).'</td>
                <td class="column5">'.strtoupper($row->Fecha_Turno).'</td>
                <td class="column6">'.strtoupper($row->Turno).'</td>
                <td class="column7">'.strtoupper($row->Semana).'</td>
                <td class="column8">'.strtoupper($row->Folio_Deri).'</td>
                <td class="column9">'.strtoupper($row->Fecha_Evento).'</td>
                <td class="column10">'.strtoupper($row->Hora_Reporte).'</td>
                <td class="column11">'.strtoupper($row->Motivo).'</td>
                <td class="column12">'.strtoupper($row->Caracteristicas_Robo).'</td>
                <td class="column13">'.strtoupper($row->Violencia).'</td>
                <td class="column14">'.strtoupper($row->Tipo_Violencia).'</td>
                <td class="column15">'.strtoupper($row->Zona_Evento).'</td>
                <td class="column16">'.strtoupper($row->Vector).'</td>
                <td class="column17">'.strtoupper($row->Unidad_Primer_R).'</td>
                <td class="column18">'.strtoupper($primer_respondiente).'</td>
                <td class="column19">'.strtoupper($acciones).'</td>
                <td class="column20">'.strtoupper($row->Identificacion_Responsables).'</td>
                <td class="column21">'.strtoupper($row->Detencion_Por_Info_Io).'</td>
                <td class="column22">'.strtoupper($elementos).'</td>
                <td class="column23">'.strtoupper($row->Fecha_Detencion).'</td>
                <td class="column24">'.strtoupper($row->Compania).'</td>
                <td class="column25">'.strtoupper($vehiculos).'</td>
                <td class="column26">'.strtoupper($domicilios).'</td>
                <td class="column27">'.strtoupper($camaras).'</td>
            ';
            
			$infoTable['body'].='</tr>';
        }
        

        return $infoTable;
    }

    public function generateLinks($numPage, $total_pages, $extra_cad = "", $filtro = 1)
    {
        $links = "";

        if ($numPage > 1) {
            $links .= '<li>
                        <a class="page-link" href="' . base_url . 'InteligenciaOperativa/?numPage=1' . $extra_cad . '&filtro=' . $filtro . '" data-toggle="tooltip" data-placement="top" title="Primera página">
                            <i class="material-icons">first_page</i>
                        </a>
                    </li>';
            $links .= '<li class="page-item">
                        <a class="page-link" href=" ' . base_url . 'InteligenciaOperativa/?numPage=' . ($numPage - 1) . $extra_cad . '&filtro=' . $filtro . ' " data-toggle="tooltip" data-placement="top" title="Página anterior">
                            <i class="material-icons">navigate_before</i>
                        </a>
                    </li>';
        }

        $LINKS_EXTREMOS = GLOBAL_LINKS_EXTREMOS;
        for ($ind = ($numPage - $LINKS_EXTREMOS); $ind <= ($numPage + $LINKS_EXTREMOS); $ind++) {
            if (($ind >= 1) && ($ind <= $total_pages)) {
                $activeLink = ($ind == $numPage) ? 'active' : '';

                $links .= '<li class="page-item ' . $activeLink . ' ">
                            <a class="page-link" href=" ' . base_url . 'InteligenciaOperativa/?numPage=' . ($ind) . $extra_cad . '&filtro=' . $filtro . ' ">
                                ' . ($ind) . '
                            </a>
                        </li>';
            }
        }

        if ($numPage < $total_pages) {
            $links .= '<li class="page-item">
                        <a class="page-link" href=" ' . base_url . 'InteligenciaOperativa/?numPage=' . ($numPage + 1) . $extra_cad . '&filtro=' . $filtro . ' " data-toggle="tooltip" data-placement="top" title="Siguiente página">
                            <i class="material-icons">navigate_next</i>
                        </a>
                    </li>';
            $links .= '<li class="page-item">
                        <a class="page-link" href=" ' . base_url . 'InteligenciaOperativa/?numPage=' . ($total_pages) . $extra_cad . '&filtro=' . $filtro . ' " data-toggle="tooltip" data-placement="top" title="Última página">
                            <i class="material-icons">last_page</i>
                        </a>
                    </li>';
        }

        return $links;
    }

    public function removeRangosFechasSesion()
    {
        if(isset($_REQUEST['filtroActual'])){
            unset($_SESSION['userdata']->rango_inicio_io);
            unset($_SESSION['userdata']->rango_fin_io);

            header("Location: ".base_url."InteligenciaOperativa/?filtro=".$_REQUEST['filtroActual']);
            exit();
        }
    }

    public function generateDropdownColumns($filtro = 1)
    {
        $dropdownColumn = "";

        $campos = ['ID','Nombre del elemento responsable', 'Responsable de turno', 'Origen del evento', 'Fecha del turno', 'Turno', 'Semana', 'Folio DERI', 'Fecha del evento', 'Hora del reporte', 'Motivo', 'Características del robo', 'Violencia', 'Tipo de violencia', 'Zona del evento', 'Vector', 'Unidad del primer respondiente', 'Información del primer respondiente', 'Acciones', '¿Se identificarón responsables?', '¿Detención por información de I.O?', 'Elementos que realizan la detención', 'Fecha de detención', 'Compañía', 'Vehículos', 'Domicilio', 'Cámaras'];

        $ind = 1;
        foreach ($campos as $campo) {
            $checked = ($_SESSION['userdata']->columns_IO['column' . $ind] == 'show') ? 'checked' : '';
            $dropdownColumn .=   '<div class="form-check">
                                    <input class="form-check-input checkColumns" type="checkbox" value="' . $_SESSION['userdata']->columns_IO['column' . $ind] . '" onchange="hideShowColumn(this.id);" id="column' . $ind . '" ' . $checked . '>
                                    <label class="form-check-label" for="column' . $ind . '">
                                        ' . $campo . '
                                    </label>
                                </div>';
            $ind++;
        }

        $dropdownColumn .=     '<div class="dropdown-divider">
                            </div>
                            <div class="form-check">
                                <input id="checkAll" class="form-check-input" type="checkbox" value="hide" onchange="hideShowAll(this.id);" id="column' . $ind . '" checked>
                                <label class="form-check-label" for="column' . $ind . '">
                                    Todo
                                </label>
                            </div>';

        return $dropdownColumn;
    }


    public function getOrigenEvento()
    {
        $data = $this->InteligenciaOperativaM->getOrigenEvento();
        return $data;
    }

    public function getTipoViolencia()
    {
        $data = $this->InteligenciaOperativaM->getTipoViolencia();
        return $data;
    }

    public function getZona()
    {
        $data = $this->InteligenciaOperativaM->getZona();
        return $data;
    }


    public function getFaltaDelito()
    {
        $data = $this->InteligenciaOperativaM->getFaltaDelito();
        return $data;
    }

    public function getZone()
    {
        $data = $this->InteligenciaOperativaM->getZone();
        return $data;
    }

    public function getVector()
    {
        $data = $this->InteligenciaOperativaM->getVector();
        return $data;
    }

    public function getMarcasVehiculos()
    {
        $data = $this->InteligenciaOperativaM->getMarcasVehiculos();
        return $data;
    }

    public function getUsoVehiculo()
    {
        $data = $this->InteligenciaOperativaM->getUsoVehiculo();
        return $data;
    }


    public function insertarNuevaIO()
    {

        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Inteligencia_Op[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';

            echo json_encode($data_p);
        }else{
            if (isset($_POST['boton_Inteligencia'])) {
    
                $k = 0;
                // $valid[$k++] = $data_p['apellidoPError']        =   $this->FV->validate($_POST, 'appPaterno_principales', 'required');
    
    
                $valid[$k++] = $data_p['Nombre_Elemento_R_Error.innerText'] = $this->FV->validate($_POST, 'Nombre_Elemento_R', 'required');
                $valid[$k++] = $data_p['Responsable_Turno_Error.innerText'] = $this->FV->validate($_POST, 'Responsable_Turno', 'required');
                $valid[$k++] = $data_p['Fecha_Turno_Error.innerText']       = $this->FV->validate($_POST, 'Fecha_Turno', 'required | date');
                $valid[$k++] = $data_p['Semana_Error.innerText']            = $this->FV->validate($_POST, 'Semana', 'required | numeric');
    
                if ($_POST['Origen_Evento'] === '911')
                    $valid[$k++] = $data_p['Folio_Deri_Error']              = $this->FV->validate($_POST, 'Folio_Deri', 'required | numeric');
    
                $valid[$k++] = $data_p['Fecha_Evento_Error']                = $this->FV->validate($_POST, 'Fecha_Evento', 'required | date');
                $valid[$k++] = $data_p['Hora_Reporte_Error']                = $this->FV->validate($_POST, 'Hora_Reporte', 'required | time');
                $valid[$k++] = $data_p['Caracteristicas_Robo_Error']        = $this->FV->validate($_POST, 'Caracteristicas_Robo', 'required');
                $valid[$k++] = $data_p['Colonia_Error']                     = $this->FV->validate($_POST, 'Colonia', 'required ');
                $valid[$k++] = $data_p['Calle_Error']                       = $this->FV->validate($_POST, 'Calle', 'required');
                $valid[$k++] = $data_p['cordY_Error']                       = $this->FV->validate($_POST, 'cordY', 'required | numeric');
                $valid[$k++] = $data_p['cordX_Error']                       = $this->FV->validate($_POST, 'cordX', 'required | numeric');
                $valid[$k++] = $data_p['Municipio_Error']                   = $this->FV->validate($_POST, 'Municipio', 'required');
                // $valid[$k++] = $data_p['Ubicacion_Camaras_Error']           = $this->FV->validate($_POST, 'Ubicacion_Camaras', 'required');
                $valid[$k++] = $data_p['Unidad_Primer_R_Error']             = $this->FV->validate($_POST, 'Unidad_Primer_R', 'required');
                $valid[$k++] = $data_p['Informacion_Primer_R_Error']        = $this->FV->validate($_POST, 'Informacion_Primer_R', 'required | max_length[6000]');
                $valid[$k++] = $data_p['Acciones_Error']                    = $this->FV->validate($_POST, 'Acciones', 'required | max_length[6000]');
                // $valid[$k++] = $data_p['Caracteristicas_Vehiculo_Error']    = $this->FV->validate($_POST, 'Caracteristicas_Vehiculo', 'required | max_length[500]');
                // $valid[$k++] = $data_p['Path_Pdf_Error'] = ($_FILES['Path_Pdf']['size'] > 0) ? '' : 'Campo requerido';
    
                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;
    
                if ($success) {
                    $data_p['Server_Validation_Status'] =  'success';
                    $success_2 = $this->InteligenciaOperativaM->nuevaInteligenciaOp($_POST,$_FILES);
                    if ($success_2['status']) {
                        
                        $data_p['Server_Status_Insertion'] = $success_2['status'];
                        
                        $Id_Inteligencia =  $success_2['Id_Inteligencia'];
                        if($_FILES['Path_Pdf']['size'] > 0){
                            $path_carpeta = BASE_PATH."public/files/InteligenciaOperativa/".$Id_Inteligencia;
                            $path_file = BASE_PATH."public/files/InteligenciaOperativa/".$Id_Inteligencia."/".$success_2['nameFile'];
                            $data_p['file'] = $this->uploadFileIO('Path_Pdf', $_FILES, $path_carpeta, $path_file);
                        }
    
                        $this->Historial->insertHistorial(11,'Nuevo registro I.O.:'.$Id_Inteligencia);
                        $data_p['status'] =  true;
    
                    } else {
                        $data_p['status'] =  false;
                        $data_p['error_message'] = $success_2['error_message'];
                    }
                } else {
                    $data_p['status'] = false;
                    $data_p['error_message'] = 'Validación formulario';
                }
                
    
                echo json_encode($data_p);
            }
        }

    }

    public function UpdateIO(){

        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Inteligencia_Op[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';

            echo json_encode($data_p);
        }else{

            if (isset($_POST['boton_Inteligencia'])) {

                $k = 0;
                // $valid[$k++] = $data_p['apellidoPError']        =   $this->FV->validate($_POST, 'appPaterno_principales', 'required');


                $valid[$k++] = $data_p['Nombre_Elemento_R_Error.innerText'] = $this->FV->validate($_POST, 'Nombre_Elemento_R', 'required');
                $valid[$k++] = $data_p['Responsable_Turno_Error.innerText'] = $this->FV->validate($_POST, 'Responsable_Turno', 'required');
                $valid[$k++] = $data_p['Fecha_Turno_Error.innerText']       = $this->FV->validate($_POST, 'Fecha_Turno', 'required | date');
                $valid[$k++] = $data_p['Semana_Error.innerText']            = $this->FV->validate($_POST, 'Semana', 'required | numeric');

                if ($_POST['Origen_Evento'] === '911')
                    $valid[$k++] = $data_p['Folio_Deri_Error']              = $this->FV->validate($_POST, 'Folio_Deri', 'required | numeric');

                $valid[$k++] = $data_p['Fecha_Evento_Error']                = $this->FV->validate($_POST, 'Fecha_Evento', 'required | date');
                $valid[$k++] = $data_p['Hora_Reporte_Error']                = $this->FV->validate($_POST, 'Hora_Reporte', 'required | time');
                $valid[$k++] = $data_p['Caracteristicas_Robo_Error']        = $this->FV->validate($_POST, 'Caracteristicas_Robo', 'required');
                $valid[$k++] = $data_p['Colonia_Error']                     = $this->FV->validate($_POST, 'Colonia', 'required ');
                $valid[$k++] = $data_p['Calle_Error']                       = $this->FV->validate($_POST, 'Calle', 'required');
                $valid[$k++] = $data_p['cordY_Error']                       = $this->FV->validate($_POST, 'cordY', 'required | numeric');
                $valid[$k++] = $data_p['cordX_Error']                       = $this->FV->validate($_POST, 'cordX', 'required | numeric');
                $valid[$k++] = $data_p['Municipio_Error']                   = $this->FV->validate($_POST, 'Municipio', 'required');
                // $valid[$k++] = $data_p['Ubicacion_Camaras_Error']           = $this->FV->validate($_POST, 'Ubicacion_Camaras', 'required');
                $valid[$k++] = $data_p['Unidad_Primer_R_Error']             = $this->FV->validate($_POST, 'Unidad_Primer_R', 'required');
                $valid[$k++] = $data_p['Informacion_Primer_R_Error']        = $this->FV->validate($_POST, 'Informacion_Primer_R', 'required | max_length[6000]');
                $valid[$k++] = $data_p['Acciones_Error']                    = $this->FV->validate($_POST, 'Acciones', 'required | max_length[6000]');
                // $valid[$k++] = $data_p['Caracteristicas_Vehiculo_Error']    = $this->FV->validate($_POST, 'Caracteristicas_Vehiculo', 'required | max_length[500]');
                // $valid[$k++] = $data_p['Path_Pdf_Error'] = ($_FILES['Path_Pdf']['size'] > 0) ? '' : 'Campo requerido';

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) {
                    $data_p['Server_Validation_Status'] =  'success';
                    $success_2 = $this->InteligenciaOperativaM->editarInteligenciaOp($_POST,$_FILES);
                    if ($success_2['status']) {
                        $data_p['Server_Status_Update'] = $success_2['status'];
                        if($_FILES['Path_Pdf']['size'] > 0){
                            $path_carpeta = BASE_PATH."public/files/InteligenciaOperativa/".$_POST['id_Inteligencia'];
                            $path_file = BASE_PATH."public/files/InteligenciaOperativa/".$_POST['id_Inteligencia']."/".$success_2['nameFile'];
                            foreach(glob($path_carpeta . "/*") as $archivos_carpeta){             
                                if (is_dir($archivos_carpeta)){
                                    rmDir_rf($archivos_carpeta);
                                } else {
                                    unlink($archivos_carpeta);
                                }
                            }
                            $data_p['file'] = $this->uploadFileIO('Path_Pdf', $_FILES, $path_carpeta, $path_file);
                        }
                        $this->Historial->insertHistorial(12,'Editar registro I.O.:'.$_POST['id_Inteligencia']);
                        $data_p['status'] =  true;
                    } else {
                        $data_p['status'] =  false;
                        $data_p['error_message'] = $success_2['error_message'];
                    }
                } else {
                    $data_p['status'] = false;
                    $data_p['error_message'] = 'Validación formulario';
                }
                

                echo json_encode($data_p);
            }
        }

    }

    public function uploadFileIO($name, $file, $carpeta, $ruta)
    {
        $allowed_mime_type_arr = array('pdf');
        $arrayAux = explode('.', $file[$name]['name']);
        $mime = end($arrayAux);

        if ((isset($file[$name]['name'])) && ($file[$name]['name'] != "")) {
            if (in_array($mime, $allowed_mime_type_arr)) {
                $band = true;
            } else {
                $band = false;
            }
        } else {
            $band = false;
        }

        /* ----- ----- ----- Existe la carpeta ----- ----- ----- */
        if (!file_exists($carpeta))
            mkdir($carpeta, 0777, true);

        if ($band) {
            move_uploaded_file($file[$name]['tmp_name'], $ruta);
        }

        return $band;
    }
}
