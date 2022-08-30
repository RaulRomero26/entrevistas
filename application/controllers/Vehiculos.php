<?php
/*
    Filtros (vehiculos):
    1  - General
    2. - Placas
    3. - NIVS
    
*/

/*Filtro SQL*/

use Mpdf\Tag\Img;

class Vehiculos extends Controller
{

    public $Catalogo;
    public $Vehiculo;
    public $numColumnsVeh; //número de columnas por cada filtro
    public $FV;

    public function __construct()
    {
        $this->Catalogo = $this->model('Catalogo');
        $this->Vehiculo = $this->model('Vehiculo');
        $this->numColumnsVeh = [12,13,12];  //se inicializa el número de columns por cada filtro
        $this->FV = new FormValidator();
    }

    public function index()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Vehiculos[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $data = [
            'titulo'    => 'Sistema de vehiculos | Vehiculo',
            'extra_css' => '<link rel="stylesheet" href="' . base_url . 'public/css/system/vehiculos/index.css">',
            'extra_js'  => '<script src="' . base_url . 'public/js/system/vehiculos/index.js"></script>'
        ];
        if (isset($_GET['filtro']) && is_numeric($_GET['filtro']) && $_GET['filtro'] >= MIN_FILTRO_VE && $_GET['filtro'] <= MAX_FILTRO_VE) { //numero de filtro
                $filtro = $_GET['filtro'];
        } else {
            $filtro = 1;
        }

        //PROCESAMIENTO DE LAS COLUMNAS 
        $this->setColumnsSession($filtro);
        $data['columns_VEH'] = $_SESSION['userdata']->columns_VEH;

        //PROCESAMIENTO DE RANGO DE FOLIOS
        if (isset($_POST['rango_inicio']) && isset($_POST['rango_fin'])) {
            $_SESSION['userdata']->rango_inicio_veh = $_POST['rango_inicio'];
            $_SESSION['userdata']->rango_fin_veh = $_POST['rango_fin'];
        }

        //PROCESO DE PAGINATION
        if (isset($_GET['numPage'])) { //numero de pagination
            $numPage = $_GET['numPage'];
            if (!(is_numeric($numPage))) //seguridad si se ingresa parámetro inválido
                $numPage = 1;
        } else {
            $numPage = 1;
        }
        //cadena auxiliar por si se trata de una paginacion conforme a una busqueda dada anteriormente
        $cadena = "";
        if (isset($_GET['cadena'])) { //numero de pagination
            $cadena = $_GET['cadena'];
            $data['cadena'] = $cadena;
        }

        $where_sentence = $this->Vehiculo->generateFromWhereSentence($cadena, $filtro);
        $extra_cad = ($cadena != "") ? ("&cadena=" . $cadena) : ""; //para links conforme a búsqueda

        $no_of_records_per_page = NUM_MAX_REG_PAGE; //total de registros por pagination
        $offset = ($numPage - 1) * $no_of_records_per_page; // desplazamiento conforme a la pagina

        $results_rows_pages = $this->Vehiculo->getTotalPages($no_of_records_per_page, $where_sentence);   //total de páginas de acuerdo a la info de la DB
        $total_pages = $results_rows_pages['total_pages'];

        if ($numPage > $total_pages) {
            $numPage = 1;
            $offset = ($numPage - 1) * $no_of_records_per_page;
        } //seguridad si ocurre un error por url     

        $rows_Vehiculos = $this->Vehiculo->getDataCurrentPage($offset, $no_of_records_per_page, $where_sentence);    //se obtiene la información de la página actual

        //guardamos la tabulacion de la información para la vista
        $data['infoTable'] = $this->generarInfoTable($rows_Vehiculos, $filtro);
        //guardamos los links en data para la vista
        $data['links'] = $this->generarLinks($numPage, $total_pages, $extra_cad, $filtro);
        //número total de registros encontrados
        $data['total_rows'] = $results_rows_pages['total_rows'];
        //filtro actual para Fetch javascript
        $data['filtroActual'] = $filtro;
        $data['dropdownColumns'] = $this->generateDropdownColumns($filtro);

        switch ($filtro) {
            case '1':
                $data['filtroNombre'] = "Todos";
                break;
            case '2':
                $data['filtroNombre'] = "Placas";
                break;
            case '3':
                $data['filtroNombre'] = "Numeros de series";
                break;
        }

        $this->view('templates/header', $data);
        $this->view('system/vehiculos/vehiculosView', $data);
        $this->view('templates/footer', $data);
    }

    public function nueva()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Vehiculos[3] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $datos_prim = [
            'tipos_vehiculos' => $this->getTipoVehiculos(),
            'zonas' => $this->getZona(),
            'grupos' => $this->getGrupos(),
            'estados' => $this->getEstados(),
            'categoria' => $this->getCategoria(),
            'ultimas_fichas' => $this->getFichas(),
        ];
        $data = [
            'titulo'     => 'Sistema de Vehiculos | Nuevo Vehiculo',
            'extra_css'  => '
                        <link rel="stylesheet" href="' . base_url . 'public/css/system/vehiculos/fullview.css">',
            'extra_js'   => '<script src="' . base_url . 'public/js/system/vehiculos/nuevo.js"></script>',
                'datos_prim' => $datos_prim
        ];

        $this->view('templates/header', $data);
        $this->view('system/vehiculos/nuevoVehiculoView', $data);
        $this->view('templates/footer', $data);
    }
    public function setColumnsSession($filtroActual = 1)
    {
        //si el filtro existe y esta dentro de los parámetros continua
        if (isset($_SESSION['userdata']->filtro_VEH) && $_SESSION['userdata']->filtro_VEH >= MIN_FILTRO_VE && $_SESSION['userdata']->filtro_VEH <= MAX_FILTRO_VE) {
            //si cambia el filtro se procde a cambiar los valores de las columnas que contiene el filtro seleccionado
            if ($_SESSION['userdata']->filtro_VEH != $filtroActual) {
                $_SESSION['userdata']->filtro_VEH = $filtroActual;
                unset($_SESSION['userdata']->columns_VEH); //se borra las columnas del anterior filtro
                //se asignan las nuevas columnas y por default se muestran todas (atributo show)
                for ($i = 0; $i < $this->numColumnsVeh[$_SESSION['userdata']->filtro_VEH - 1]; $i++)
                    $_SESSION['userdata']->columns_VEH['column' . ($i + 1)] = 'show';
            }
        } else { //si no existe el filtro entonces se inicializa con el primero por default
            $_SESSION['userdata']->filtro_VEH = $filtroActual;
            unset($_SESSION['userdata']->columns_VEH);
            for ($i = 0; $i < $this->numColumnsVeh[$_SESSION['userdata']->filtro_VEH - 1]; $i++)
                $_SESSION['userdata']->columns_VEH['column' . ($i + 1)] = 'show';
        }
        //echo "filtro: ".var_dump($_SESSION['userdata']->filtro_VEH)."<br>br>";
        //echo "columns: ".var_dump($_SESSION['userdata']->columns_VEH)."<br>br>";
    }
    public function setColumnFetch()
    {
        if (isset($_POST['columName']) && isset($_POST['valueColumn'])) {
            $_SESSION['userdata']->columns_VEH[$_POST['columName']] = $_POST['valueColumn'];
            echo json_encode("ok");
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }
    public function generarInfoTable($rows, $filtro = 1)
    {
        $permisos_Editar = ($_SESSION['userdata']->Vehiculos[1] == '1') ? 'd-flex justify-content-center' : 'mi_hide';
        $permisos_Ver = ($_SESSION['userdata']->Vehiculos[2] == '1') ? 'd-flex justify-content-center' : 'mi_hide';
        $permisos_FormatoFicha = ($_SESSION['userdata']->Vehiculos[2] == '1') ? 'd-flex justify-content-center' : 'mi_hide';
        //se genera la tabulacion de la informacion por backend
        $infoTable['header'] = "";
        $infoTable['body'] = "";
        switch ($filtro) {
            case '1': //general
                $infoTable['header'] .= '
                        <th class="column1">Ficha</th>
                        <th class="column2">Fecha Recuperacion</th>
                        <th class="column3">Fecha Puesta a Disposición</th>
                        <th class="column4">Estado</th>
                        <th class="column5">Colonia</th>
                        <th class="column6">Zona Evento</th>
                        <th class="column7">Primer Respondiente</th>
                        <th class="column8">Marca</th>
                        <th class="column9">Submarca</th>
                        <th class="column10">Tipo</th>
                        <th class="column11">Modelo</th>
                        <th class="column12">Color</th>
                    ';
                foreach ($rows as $row) {
                    if($row->NO_FICHA_R==0)
                        $ficha=$row->NO_FICHA_V;
                    else
                        $ficha=$row->NO_FICHA_R;
                    $infoTable['body'] .= '<tr id="tr' . $row->ID_VEHICULO . '">';
                    $infoTable['body'] .= '  <td class="column1">' . $ficha . '</td>
                                            <td class="column2">' . $row->FECHA_RECUPERACION . '</td>
                                            <td class="column3">' . $row->FECHA_PUESTA_DISPOSICION . '</td>
                                            <td class="column4">' . $row->ESTADO . '</td>
                                            <td class="column5">' . $row->COLONIA . '</td>
                                            <td class="column6">' . $row->ZONA_EVENTO . '</td>
                                            <td class="column7">' . mb_strtoupper($row->PRIMER_RESPONDIENTE) . '</td>
                                            <td class="column8">' . mb_strtoupper($row->MARCA) . '</td>
                                            <td class="column9">' . mb_strtoupper($row->SUBMARCA) . '</td>
                                            <td class="column10">' . mb_strtoupper($row->TIPO) . '</td>
                                            <td class="column11">' . mb_strtoupper($row->MODELO) . '</td>
                                            <td class="column12">' . mb_strtoupper($row->COLOR) . '</td>

                        ';
                        $infoTable['body'] .= '<td class="d-flex">
                        <a class="myLinks mb-3 ' . $permisos_Editar . '" data-toggle="tooltip" data-placement="right" title="Editar registro" href="' . base_url . 'Vehiculos/editarVehiculo/?id_vehiculo=' . $row->ID_VEHICULO . '">
                            <i class="material-icons">edit</i>
                        </a>';
                        $infoTable['body'] .= '
                                                <a class="myLinks mt-3 ' . $permisos_Ver . '" data-toggle="tooltip" data-placement="right" title="Ver registro" href="' . base_url . 'Vehiculos/verVehiculo/?id_vehiculo=' . $row->ID_VEHICULO . '">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="myLinks mt-3 ' . $permisos_FormatoFicha . '" data-toggle="tooltip" data-placement="right" title="Generar formato vehiculo" href="' . base_url . 'Vehiculos/generarFormato/?no_vehiculo=' . $row->ID_VEHICULO . '" target="_blank">
                                                    <i class="material-icons">list_alt</i>
                                                </a>
                                                
                                            </td>';
                    $infoTable['body'] .= '</tr>';
                }
                $infoTable['header'] .= '<th >Operaciones</th>';
                break;
                case '2': //general
                    $infoTable['header'] .= '
                            <th class="column1">Ficha</th>
                            <th class="column2">ID Vehiculo</th>
                            <th class="column3">Fecha Recuperacion</th>
                            <th class="column4">Fecha Puesta a Disposición</th>
                            <th class="column5">Tipo</th>
                            <th class="column6">Placa</th>
                            <th class="column7">Procedencia</th>
                            <th class="column8">Marca</th>
                            <th class="column9">Submarca</th>
                            <th class="column10">Tipo</th>
                            <th class="column11">Modelo</th>
                            <th class="column12">Color</th>
                        ';
                    foreach ($rows as $row) {
                        $infoTable['body'] .= '<tr id="tr' . $row->ID_VEHICULO . '">';
                        if(trim($row->NO_FICHA_R)==0){
                            $ficha=$row->NO_FICHA_V;
                        }
                        else{
                            $ficha=$row->NO_FICHA_R;
                        }
                        $infoTable['body'] .= '  <td class="column1">' . $ficha . '</td>
                                                <td class="column2">' . $row->ID_VEHICULO . '</td>
                                                <td class="column3">' . $row->FECHA_RECUPERACION . '</td>
                                                <td class="column4">' . $row->FECHA_PUESTA_DISPOSICION . '</td>
                                                <td class="column5">' . $row->DESCRIPCION . '</td>
                                                <td class="column6">' . $row->PLACA . '</td>
                                                <td class="column7">' . $row->PROCEDENCIA . '</td>
                                                <td class="column8">' . mb_strtoupper($row->MARCA) . '</td>
                                                <td class="column9">' . mb_strtoupper($row->SUBMARCA) . '</td>
                                                <td class="column10">' . mb_strtoupper($row->TIPO) . '</td>
                                                <td class="column11">' . mb_strtoupper($row->MODELO) . '</td>
                                                <td class="column12">' . mb_strtoupper($row->COLOR) . '</td>
    
                            ';
                            $infoTable['body'] .= '<td class="d-flex">
                            <a class="myLinks mb-3 ' . $permisos_Editar . '" data-toggle="tooltip" data-placement="right" title="Editar registro" href="' . base_url . 'Vehiculos/editarVehiculo/?id_vehiculo=' . $row->ID_VEHICULO . '">
                                <i class="material-icons">edit</i>
                            </a>';
                            $infoTable['body'] .= '
                                                    <a class="myLinks mt-3 ' . $permisos_Ver . '" data-toggle="tooltip" data-placement="right" title="Ver registro" href="' . base_url . 'Vehiculos/verVehiculo/?id_vehiculo=' . $row->ID_VEHICULO . '">
                                                        <i class="material-icons">visibility</i>
                                                    </a>
                                                    <a class="myLinks mt-3 ' . $permisos_FormatoFicha . '" data-toggle="tooltip" data-placement="right" title="Generar formato vehiculo" href="' . base_url . 'Vehiculos/generarFormato/?no_vehiculo=' . $row->ID_VEHICULO . '" target="_blank">
                                                        <i class="material-icons">list_alt</i>
                                                    </a>
                                                    
                                                </td>';
                        $infoTable['body'] .= '</tr>';
                    }
                    $infoTable['header'] .= '<th >Operaciones</th>';
                    break;
                case '3': //general
                    $infoTable['header'] .= '
                            <th class="column1">Ficha</th>
                            <th class="column2">ID Vehiculos</th>
                            <th class="column3">Fecha Recuperacion</th>
                            <th class="column4">Fecha Puesta a Disposición</th>
                            <th class="column5">Tipo</th>
                            <th class="column6">Niv</th>
                            <th class="column7">Marca</th>
                            <th class="column8">Submarca</th>
                            <th class="column9">Tipo</th>
                            <th class="column10">Modelo</th>
                            <th class="column11">Color</th>
                        ';
                    foreach ($rows as $row) {
                        $infoTable['body'] .= '<tr id="tr' . $row->ID_VEHICULO . '">';
                        if(trim($row->NO_FICHA_R)==0){
                            $ficha=$row->NO_FICHA_V;
                        }
                        else{
                            $ficha=$row->NO_FICHA_R;
                        }
                        $infoTable['body'] .= '  <td class="column1">' . $ficha . '</td>
                                                <td class="column2">' . $row->ID_VEHICULO . '</td>
                                                <td class="column3">' . $row->FECHA_RECUPERACION . '</td>
                                                <td class="column4">' . $row->FECHA_PUESTA_DISPOSICION . '</td>
                                                <td class="column5">' . $row->DESCRIPCION . '</td>
                                                <td class="column6">' . $row->NO_SERIE . '</td>
                                                <td class="column7">' . mb_strtoupper($row->MARCA) . '</td>
                                                <td class="column8">' . mb_strtoupper($row->SUBMARCA) . '</td>
                                                <td class="column9">' . mb_strtoupper($row->TIPO) . '</td>
                                                <td class="column10">' . mb_strtoupper($row->MODELO) . '</td>
                                                <td class="column11">' . mb_strtoupper($row->COLOR) . '</td>
    
                            ';
                            $infoTable['body'] .= '<td class="d-flex">
                            <a class="myLinks mb-3 ' . $permisos_Editar . '" data-toggle="tooltip" data-placement="right" title="Editar registro" href="' . base_url . 'Vehiculos/editarVehiculo/?id_vehiculo=' . $row->ID_VEHICULO . '">
                                <i class="material-icons">edit</i>
                            </a>';
                            $infoTable['body'] .= '
                                                    <a class="myLinks mt-3 ' . $permisos_Ver . '" data-toggle="tooltip" data-placement="right" title="Ver registro" href="' . base_url . 'Vehiculos/verVehiculo/?id_vehiculo=' . $row->ID_VEHICULO . '">
                                                        <i class="material-icons">visibility</i>
                                                    </a>
                                                    <a class="myLinks mt-3 ' . $permisos_FormatoFicha . '" data-toggle="tooltip" data-placement="right" title="Generar formato vehiculo" href="' . base_url . 'Vehiculos/generarFormato/?no_vehiculo=' . $row->ID_VEHICULO . '" target="_blank">
                                                        <i class="material-icons">list_alt</i>
                                                    </a>
                                                    
                                                </td>';
                        $infoTable['body'] .= '</tr>';
                    }
                    $infoTable['header'] .= '<th >Operaciones</th>';
                    break;
        }

        return $infoTable;
    }
    public function generarLinks($numPage, $total_pages, $extra_cad = "", $filtro = 1)
    {
        //$extra_cad sirve para determinar la paginacion conforme a si se realizó una busqueda
        //Creación de links para el pagination
        $links = "";

        //FLECHA IZQ (PREV PAGINATION)
        if ($numPage > 1) {
            $links .= '<li class="page-item">
                            <a class="page-link" href=" ' . base_url . 'vehiculos/index/?numPage=1' . $extra_cad . '&filtro=' . $filtro . ' " data-toggle="tooltip" data-placement="top" title="Primera página">
                                <i class="material-icons">first_page</i>
                            </a>
                        </li>';
            $links .= '<li class="page-item">
                            <a class="page-link" href=" ' . base_url . 'vehiculos/index/?numPage=' . ($numPage - 1) . $extra_cad . '&filtro=' . $filtro . ' " data-toggle="tooltip" data-placement="top" title="Página anterior">
                                <i class="material-icons">navigate_before</i>
                            </a>
                        </li>';
        }

        //DESPLIEGUE DE PAGES NUMBER
        $LINKS_EXTREMOS = GLOBAL_LINKS_EXTREMOS; //numero máximo de links a la izquierda y a la derecha
        for ($ind = ($numPage - $LINKS_EXTREMOS); $ind <= ($numPage + $LINKS_EXTREMOS); $ind++) {
            if (($ind >= 1) && ($ind <= $total_pages)) {

                $activeLink = ($ind == $numPage) ? 'active' : '';

                $links .= '<li class="page-item ' . $activeLink . ' ">
                                <a class="page-link" href=" ' . base_url . 'vehiculos/index/?numPage=' . ($ind) . $extra_cad . '&filtro=' . $filtro . ' ">
                                    ' . ($ind) . '
                                </a>
                            </li>';
            }
        }

        //FLECHA DERECHA (NEXT PAGINATION)
        if ($numPage < $total_pages) {

            $links .= '<li class="page-item">
                            <a class="page-link" href=" ' . base_url . 'vehiculos/index/?numPage=' . ($numPage + 1) . $extra_cad . '&filtro=' . $filtro . ' " data-toggle="tooltip" data-placement="top" title="Siguiente página">
                            <i class="material-icons">navigate_next</i>
                            </a>
                        </li>';
            $links .= '<li class="page-item">
                            <a class="page-link" href=" ' . base_url . 'vehiculos/index/?numPage=' . ($total_pages) . $extra_cad . '&filtro=' . $filtro . ' " data-toggle="tooltip" data-placement="top" title="Última página">
                            <i class="material-icons">last_page</i>
                            </a>
                        </li>';
        }

        return $links;
    }
    public function generateDropdownColumns($filtro = 1)
    {
        //parte de permisos

        $dropDownColumn = '';
        //generación de dropdown dependiendo del filtro
        switch ($filtro) {
            case '1':
                $campos = ['FICHA','FECHA RECUPERACION','FECHA DISPOSICION', 'ESTADO','COLONIA', 'ZONA EVENTO', 'PRIMER RESPONDIENTE', 'MARCA', 'SUBMARCA', 'TIPO', 'MODELO', ' COLOR'];
                break;
            case '2':
                $campos = ['FICHA','ID VEHICULO','FECHA RECUPERACION','FECHA DISPOSICION','TIPO','PLACA','PROCEDENCIA','MARCA', 'SUBMARCA', 'TIPO', 'MODELO', 'COLOR'];
                break;
            case '3':
                $campos = ['FICHA','ID VEHICULO','FECHA RECUPERACION','FECHA DISPOSICION','TIPO','NIV','MARCA', 'SUBMARCA', 'TIPO', 'MODELO', ' COLOR'];
                break;
        }
        //gestión de cada columna
        $ind = 1;
        foreach ($campos as $campo) {
            $checked = ($_SESSION['userdata']->columns_VEH['column' . $ind] == 'show') ? 'checked' : '';
            $dropDownColumn .= ' <div class="form-check">
                                    <input class="form-check-input checkColumns" type="checkbox" value="' . $_SESSION['userdata']->columns_VEH['column' . $ind] . '" onchange="hideShowColumn(this.id);" id="column' . $ind . '" ' . $checked . '>
                                    <label class="form-check-label" for="column' . $ind . '">
                                        ' . $campo . '
                                    </label>
                                </div>';
            $ind++;
        }
        $dropDownColumn .= '     <div class="dropdown-divider">
                                </div>
                                <div class="form-check">
                                    <input id="checkAll" class="form-check-input" type="checkbox" value="hide" onchange="hideShowAll(this.id);" id="column' . $ind . '" checked>
                                    <label class="form-check-label" for="column' . $ind . '">
                                        Todo
                                    </label>
                                </div>';
        return $dropDownColumn;
    }
    public function buscarPorCadena()
    {
        /*Aquí van condiciones de permisos*/
        if (isset($_POST['cadena'])) {
            $cadena = trim($_POST['cadena']);
            $filtroActual = trim($_POST['filtroActual']);

            $results = $this->Vehiculo->getRemisionDByCadena($cadena, $filtroActual);
            if (strlen($cadena) > 0) {
                $user = $_SESSION['userdata']->Id_Usuario;
                $ip = $this->obtenerIp();
                $descripcion = 'Consulta realizada: ' . $cadena . '';
                $this->Vehiculo->historial($user, $ip, 6, $descripcion);
            }
            $extra_cad = ($cadena != "") ? ("&cadena=" . $cadena) : ""; //para links conforme a búsqueda
            $dataReturn['infoTable'] = $this->generarInfoTable($results['rows_Vehs'], $filtroActual);
            $dataReturn['links'] = $this->generarLinks($results['numPage'], $results['total_pages'], $extra_cad, $filtroActual);
            $dataReturn['export_links'] = $this->generarExportLinks($extra_cad, $filtroActual);
            $dataReturn['total_rows'] = "Total registros: " . $results['total_rows'];
            $dataReturn['dropdownColumns'] = $this->generateDropdownColumns($filtroActual);


            echo json_encode($dataReturn);
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }
    //función para generar los links respectivos dependiendo del filtro y/o cadena de búsqueda
    public function generarExportLinks($extra_cad = "", $filtro = 1)
    {
        if ($extra_cad != "") {
            $dataReturn['excel'] =  base_url . 'Vehiculos/exportarInfo/?tipo_export=EXCEL' . $extra_cad . '&filtroActual=' . $filtro;
            $dataReturn['pdf'] =  base_url . 'Vehiculos/exportarPDFVarios/?tipo_export=PDF' . $extra_cad . '&filtroActual=' . $filtro;
            //return $dataReturn;
        } else {
            $dataReturn['excel'] =  base_url . 'Vehiculos/exportarInfo/?tipo_export=EXCEL' . $extra_cad . '&filtroActual=' . $filtro;
            $dataReturn['pdf'] =  base_url . 'Vehiculos/exportarPDFVarios/?tipo_export=PDF' . $extra_cad . '&filtroActual=' . $filtro;
        }
        return $dataReturn;
    }
    public function obtenerIp()
    {
        $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $hosts = gethostbynamel($hostname);
        if (is_array($hosts)) {
            foreach ($hosts as $ip) {
                return $ip;
            }
        } else {
            return $ip = '0.0.0.0';
        }
    }
    public function removeRangosFechasSesion()
    {

        if (isset($_REQUEST['filtroActual'])) {
            unset($_SESSION['userdata']->rango_inicio_veh);
            unset($_SESSION['userdata']->rango_fin_veh);

            header("Location: " . base_url . "Vehiculos/index/?filtro=" . $_REQUEST['filtroActual']);
            exit();
        } else {
            header("Location: " . base_url . "Cuenta");
            exit();
        }
    }

    public function getTipoVehiculos()
    {
        $data = $this->Catalogo->getSimpleCatalogo("Tipo", "catalogo_tipos_vehiculos");
        return $data;
    }

    public function getMarcasVehiculos()
    {
        $data = $this->Catalogo->getSimpleCatalogo("Marca", "catalogo_marca_vehiculos_io");
        return $data;
    }

    public function getSubmarcasVehiculos()
    {
        $data = $this->Catalogo->getSimpleCatalogo("Submarca", "catalogo_submarcas_vehiculos");
        return $data;
    }
    public function getEstados()
    {
        //$data = $this->Catalogo->getSimpleCatalogo("Estado", "catalogo_estados");
        $data = $this->Catalogo->getSimpleCatalogoOrder("Estado", "catalogo_estados","Estado");
        return $data;
    }
    public function getCategoria()
    {
        $data = $this->Catalogo->getSimpleCatalogo("Categoria", "catalogo_placaniv");
        return $data;
    }

    public function getFichas()
    {
        $data = $this->Vehiculo->getUltimasFichas();
        return $data;
    }
    public function agregarVehiculoSeccion()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Vehiculos[1] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {

            if (isset($_POST['datos_nuevovehiculo'])) {
                $k = 0;
                
                $valid[$k++] = $data_p['Tipo_Situacion_error']              =   $this->FV->validate($_POST, 'Tipo_Situacion', 'required');
                $valid[$k++] = $data_p['fechar_Vehiculo_error']             =   $this->FV->validate($_POST, 'fechar_Vehiculo', 'required | date');
                $valid[$k++] = $data_p['colonia_Vehiculo_error']            =   $this->FV->validate($_POST, 'colonia_Vehiculo', 'required');
                $valid[$k++] = $data_p['zona_Vehiculo_error']               =   $this->FV->validate($_POST, 'zona_Vehiculo', 'required');
                $valid[$k++] = $data_p['primerr_Vehiculo_error']            =   $this->FV->validate($_POST, 'primerm_Vehiculo', 'required');
                $valid[$k++] = $data_p['Color_error']                       =   $this->FV->validate($_POST, 'Color', 'required');
                

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) {
                    $success_2 = $this->Vehiculo->insertNuevoVehiculo($_POST);
                    if ($success_2['status']) {
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $descripcion = 'Añadio nuevo vehiculo';
                        $this->Vehiculo->historial($user, $ip, 3, $descripcion);
                        $data_p['status'] =  true;
                    } else {
                        $data_p['status'] =  false;
                        $data_p['error_message'] = $success_2['error_message'];
                    }
                } else {
                    $data_p['status'] =  false;
                }
                echo json_encode($data_p);
            } else {
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';
                echo json_encode($data_p);
            }
        }
    }
    public function obtenerFicha()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Vehiculos[1] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['buscar'])) {
                    $success = $this->Vehiculo->obtenerFicha($_POST);
                    if ($success['status']) {
                        $data_p['status'] =  true;
                        $data_p['REALIZO']="SI";
                    } else {
                        $data_p['status'] =  false;
                        $data_p['REALIZO']="SI PERO FALSO";
                    }
                echo json_encode($data_p);
            } else {
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';
                $data_p['REALIZO']="NO";
                echo json_encode($data_p);
            }
        }
    }
    public function editarVehiculo(){
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Vehiculos[1] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }
        $datos_prim = [
            'tipos_vehiculos' => $this->getTipoVehiculos(),
            'zonas' => $this->getZona(),
            'grupos' => $this->getGrupos(),
            'estados' => $this->getEstados(),
            'categoria' => $this->getCategoria(),
            'ultimas_fichas' => $this->getFichas(),
        ];
        $data = [
            'titulo'     => 'Sistema de Vehiculos | Editar Vehiculo',
            'extra_css'  => '<link rel="stylesheet" href="' . base_url . 'public/css/system/vehiculos/capturaFotos.css">
                            <link rel="stylesheet" href="' . base_url . 'public/css/libraries/dropzone.css">
                            <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
                            <link rel="stylesheet" href="' . base_url . 'public/css/system/vehiculos/fullview.css">',
            'extra_js'   => '<script src="' . base_url . 'public/js/system/vehiculos/editar.js"></script>'.
                            '<script src="' . base_url . 'public/js/libraries/dropzone.js"></script>'.
                            '<script src="' . base_url . 'public/js/system/vehiculos/capturaf.js"></script>' . 
                            '<script src="' . base_url . 'public/js/system/vehiculos/capturaFotos.js"></script>',
                'datos_prim' => $datos_prim
        ];

        $this->view('templates/header', $data);
        $this->view('system/vehiculos/editarVehiculoView', $data);
        $this->view('templates/footer', $data);
    }

    public function verVehiculo(){
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Vehiculos[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }
        $data = [
            'titulo'     => 'Sistema de Vehiculos | Ver Vehiculo',
            'extra_css'  => '
                        <link rel="stylesheet" href="' . base_url . 'public/css/system/vehiculos/fullview.css">',
            'extra_js'   => '<script src="' . base_url . 'public/js/system/vehiculos/verVehiculo.js"></script>'
        ];

        $this->view('templates/header', $data);
        $this->view('system/vehiculos/verVehiculoView', $data);
        $this->view('templates/footer', $data);
    } 
    public function getVehiculoEditar()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Vehiculos[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }
      //  echo $_POST['no_vehiculo_editar'];
        if (isset($_POST['no_vehiculo_editar'])) {
            $no_vehiculo_editar = $_POST['no_vehiculo_editar'];
            $data = $this->Vehiculo->getVehiculos($no_vehiculo_editar);
            echo json_encode($data);
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }
    public function updateVehiculo()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Vehiculos[1] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {

            if (isset($_POST['datos_editarvehiculo'])) {
                $k = 0;
                
                $valid[$k++] = $data_p['fechar_VehiculoE_error']             =   $this->FV->validate($_POST, 'fechar_VehiculoE', 'required | date');
                $valid[$k++] = $data_p['colonia_VehiculoE_error']            =   $this->FV->validate($_POST, 'colonia_VehiculoE', 'required');
                $valid[$k++] = $data_p['zona_VehiculoE_error']               =   $this->FV->validate($_POST, 'zona_VehiculoE', 'required');
                $valid[$k++] = $data_p['primerr_VehiculoE_error']            =   $this->FV->validate($_POST, 'primerm_VehiculoE', 'required');
                $valid[$k++] = $data_p['ColorE_error']                       =   $this->FV->validate($_POST, 'ColorE', 'required');
                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;
                    
                $path_carpeta = BASE_PATH . "public/files/Vehiculos/" . $_POST['no_vehiculo_'] . "/PDF/";
                $path_file = BASE_PATH . "public/files/Vehiculos/" . $_POST['no_vehiculo_'] . "/PDF/" . $_POST['no_vehiculo_'] . ".pdf";
                $name = 'file_vehiculos';

                if (isset($_FILES['file_vehiculos']))
                    $file = true;
                else
                    $file = false;

                if ($success) {
                    $success_2 = $this->Vehiculo->updateVehiculo($_POST,$file);
                    if ($success_2['status']) {
                        if (isset($_FILES['file_vehiculos'])) {
                            $result = $this->uploadFileVehiculos($name, $_FILES, $_POST['no_vehiculo_'], $path_carpeta, $path_file);
                            $data_p['file'] = $result;
                        }
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $descripcion = 'Edito vehiculo '.$_POST['no_vehiculo_']; //-----------luego cambiar 
                        $this->Vehiculo->historial($user, $ip, 3, $descripcion);
                        $data_p['status'] =  true;
                    } else {
                        $data_p['status'] =  false;
                        $data_p['error_message'] = $success_2['error_message'];
                    }
                } else {
                    $data_p['status'] =  false;
                }
                echo json_encode($data_p);
            } else {
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';
                echo json_encode($data_p);
            }
        }
    }
    public function exportarInfo()
    {
        if (!isset($_REQUEST['tipo_export'])) {
            header("Location: " . base_url . "Inicio");
            exit();
        }
        if (!isset($_REQUEST['filtroActual']) || !is_numeric($_REQUEST['filtroActual']) || !($_REQUEST['filtroActual'] >= MIN_FILTRO_VE) || !($_REQUEST['filtroActual'] <= MAX_FILTRO_VE))
            $filtroActual = 1;
        else
            $filtroActual = $_REQUEST['filtroActual'];
        $from_where_sentence = "";
        if (isset($_REQUEST['cadena']))
            $from_where_sentence = $this->Vehiculo->generateFromWhereSentence($_REQUEST['cadena'], $filtroActual);
        else
            $from_where_sentence = $this->Vehiculo->generateFromWhereSentence("", $filtroActual);
        $rows_Veh = $this->Vehiculo->getAllInfoRemisionDByCadena($from_where_sentence);
        switch ($filtroActual) {
            case '1':
                $filename = "Vehiculos";
                $encabezados_placas_niv=$this->getCategoria();
             //   print_r($encabezados_placas_niv);
                $csv_data = "Fecha de recuperacion, Fecha puesta disposicion,Numero de Ficha,Estado,Colonia,Zona evento, Primer respondiente,Marca,Submarca,Tipo,Modelo,Color, CDI, Observaciones,Núm. Remision, Nombre del MP, ";
                foreach ($encabezados_placas_niv as $item):
                    $csv_data .= "Placa ".$item->Categoria.", Procedencia de placa ".$item->Categoria.", NIV ".$item->Categoria.", ";
                endforeach;
                //añadir al final obervaciones
                $csv_data .="Narrativas, Estatus\n";
                $rows_Veh = $this->Vehiculo->getAllInfoRemisionDByCadena($from_where_sentence);
             //   echo $csv_data;
                foreach ($rows_Veh as $key => $row) {
                    $placas=$this->Vehiculo->getAllPlacas($row->ID_VEHICULO);
                    $nivs=$this->Vehiculo->getAllNIV($row->ID_VEHICULO);
                    $ficha=0;
                    if($row->NO_FICHA_R==0){
                        $ficha=$row->NO_FICHA_V;
                    }
                    else{
                        $ficha=$row->NO_FICHA_R;
                    }
                    $csv_data .= "\" ".$row->FECHA_RECUPERACION . "\",\"" .
                        mb_strtoupper($row->FECHA_PUESTA_DISPOSICION) . "\",\"" .
                        mb_strtoupper($ficha) . "\",\"" .
                        mb_strtoupper($row->ESTADO) . "\",\"" .
                        mb_strtoupper($row->COLONIA) . "\",\"" .
                        mb_strtoupper($row->ZONA_EVENTO) . "\",\"" .
                        mb_strtoupper($row->PRIMER_RESPONDIENTE) . "\",\"" .
                        mb_strtoupper($row->MARCA) . "\",\"" .
                        mb_strtoupper($row->SUBMARCA) . "\",\"" .
                        mb_strtoupper($row->TIPO) . "\",\"" .
                        mb_strtoupper($row->MODELO) . "\",\"" .
                        mb_strtoupper($row->COLOR) . "\",\"" .
                        mb_strtoupper($row->CDI) . "\",\"" .
                        mb_strtoupper($row->OBSERVACIONES) . "\",\"" .
                        mb_strtoupper($row->NO_REMISION) . "\",\"" .
                        mb_strtoupper($row->NOMBRE_MP) . "\",";
                        foreach ($encabezados_placas_niv as $item):
                            $bandera=0; $bandera1=0;
                            foreach ($placas as $item2):
                                if($item2->DESCRIPCION==$item->Categoria){
                                    $csv_data .= "\" ".$item2->PLACA. "\",\"";
                                    $csv_data .= " ".$item2->PROCEDENCIA. "\",\"";
                                    $bandera=1;
                                }
                            endforeach;
                            foreach ($nivs as $item3):
                                if($item3->DESCRIPCION==$item->Categoria){
                                    $csv_data .= $item3->NO_SERIE. "\",";
                                    $bandera1=1;
                                }
                            endforeach;
                            if($bandera==0){
                                $csv_data .= "\"\" ".",";
                                $csv_data .= "\"\" "." ,";
                            }
                            if($bandera1==0){
                                if($bandera==1){
                                    $csv_data .= " \" "." ,";
                                }
                                else{
                                    $csv_data .= "\"\" "." ,";
                                }
                            }
                        endforeach;
                    $csv_data .= "\" ".str_replace('"', '`',$row->NARRATIVAS). "\",";
                    if($row->ACTIVA==1)
                        $csv_data .= "ACTIVO".",\n";
                    else 
                        $csv_data .= "CANCELADO ".",\n";
                }
                break;
            case '2':
                $filename = "Placas de vehiculos";
                $csv_data = "Fecha de recuperacion, Fecha puesta disposicion,Numero de vehiculo, Numero de Ficha,Estado,Colonia,Zona evento, Primer respondiente,Marca,Submarca,Tipo,Modelo,Color, CDI, Observaciones, Núm. Remision, Nombre del MP, Descripcion de placa, Placa, Procedencia, Estatus\n";
                $rows_Veh = $this->Vehiculo->getAllInfoRemisionDByCadena($from_where_sentence);
                foreach ($rows_Veh as $key => $row) {
                    $ficha=0;
                    if($row->NO_FICHA_R==0)
                        $ficha=$row->NO_FICHA_V;
                    else
                        $ficha=$row->NO_FICHA_R;
                    if($row->ACTIVA==1)
                        $activo = "ACTIVO";
                    else 
                        $activo = "CANCELADO";
                    $csv_data .= $row->FECHA_RECUPERACION . ",\"" .
                        mb_strtoupper($row->FECHA_PUESTA_DISPOSICION) . "\",\"" .
                        mb_strtoupper($row->NO_VEHICULO) . "\",\"" .
                        mb_strtoupper($ficha) . "\",\"" .
                        mb_strtoupper($row->ESTADO) . "\",\"" .
                        mb_strtoupper($row->COLONIA) . "\",\"" .
                        mb_strtoupper($row->ZONA_EVENTO) . "\",\"" .
                        mb_strtoupper($row->PRIMER_RESPONDIENTE) . "\",\"" .
                        mb_strtoupper($row->MARCA) . "\",\"" .
                        mb_strtoupper($row->SUBMARCA) . "\",\"" .
                        mb_strtoupper($row->TIPO) . "\",\"" .
                        mb_strtoupper($row->MODELO) . "\",\"" .
                        mb_strtoupper($row->COLOR) . "\",\"" .
                        mb_strtoupper($row->CDI) . "\",\"" .
                        mb_strtoupper($row->OBSERVACIONES) . "\",\"" .
                        mb_strtoupper($row->NO_REMISION) . "\",\"" .
                        mb_strtoupper($row->NOMBRE_MP) . "\",\"" .
                        mb_strtoupper($row->PLACA) . "\",\"" .
                        mb_strtoupper($row->DESCRIPCION) . "\",\"" .
                        mb_strtoupper($row->PROCEDENCIA) . "\",\"" .
                        mb_strtoupper($activo) . "\",\n";
                }
                    break;
                case '3':
                    $filename = "NIV de vehiculos";
                    $csv_data = "Fecha de recuperacion, Fecha puesta disposicion,Numero de vehiculo,Numero de Ficha,Estado,Colonia,Zona evento, Primer respondiente,Marca,Submarca,Tipo,Modelo,Color, CDI, Observaciones, Núm. Remision, Nombre del MP, Descripcion de NIV, NIV, Estatus \n";
                    $rows_Veh = $this->Vehiculo->getAllInfoRemisionDByCadena($from_where_sentence);
                    foreach ($rows_Veh as $key => $row) {
                        $ficha=0;
                        if($row->NO_FICHA_R==0)
                        $ficha=$row->NO_FICHA_V;
                        else
                            $ficha=$row->NO_FICHA_R;
                        if($row->ACTIVA==1)
                            $activo = "ACTIVO";
                        else 
                            $activo = "CANCELADO";
                        $csv_data .= $row->FECHA_RECUPERACION . ",\"" .
                            mb_strtoupper($row->FECHA_PUESTA_DISPOSICION) . "\",\"" .
                            mb_strtoupper($row->NO_VEHICULO) . "\",\"" .
                            mb_strtoupper($ficha) . "\",\"" .
                            mb_strtoupper($row->ESTADO) . "\",\"" .
                            mb_strtoupper($row->COLONIA) . "\",\"" .
                            mb_strtoupper($row->ZONA_EVENTO) . "\",\"" .
                            mb_strtoupper($row->PRIMER_RESPONDIENTE) . "\",\"" .
                            mb_strtoupper($row->MARCA) . "\",\"" .
                            mb_strtoupper($row->SUBMARCA) . "\",\"" .
                            mb_strtoupper($row->TIPO) . "\",\"" .
                            mb_strtoupper($row->MODELO) . "\",\"" .
                            mb_strtoupper($row->COLOR) . "\",\"" .
                            mb_strtoupper($row->CDI) . "\",\"" .
                            mb_strtoupper($row->OBSERVACIONES) . "\",\"" .
                            mb_strtoupper($row->NO_REMISION) . "\",\"" .
                            mb_strtoupper($row->NOMBRE_MP) . "\",\"" .
                            mb_strtoupper($row->DESCRIPCION) . "\",\"" .
                            mb_strtoupper($row->NO_SERIE) . "\",\"" .
                            mb_strtoupper($activo) . "\",\n";
                        
                    }
                        break;
        }
        //se genera el archivo csv o excel
        $csv_data = utf8_decode($csv_data); //escribir información con formato utf8 por algún acento
        header("Content-Description: File Transfer");
        header("Content-Type: application/force-download");
        header("Content-Disposition: attachment; filename=" . $filename . ".csv");
        echo $csv_data;
    }
    public function exportarPDFVarios()
    {
        if (!isset($_REQUEST['tipo_export'])) {
            header("Location: " . base_url . "Inicio");
            exit();
        }
        if (!isset($_REQUEST['filtroActual']) || !is_numeric($_REQUEST['filtroActual']) || !($_REQUEST['filtroActual'] >= MIN_FILTRO_VE) || !($_REQUEST['filtroActual'] <= MAX_FILTRO_VE))
            $filtroActual = 1;
        else
            $filtroActual = $_REQUEST['filtroActual'];
        $from_where_sentence = "";
        if (isset($_REQUEST['cadena']))
            $from_where_sentence = $this->Vehiculo->generateFromWhereSentence($_REQUEST['cadena'], $filtroActual);
        else
            $from_where_sentence = $this->Vehiculo->generateFromWhereSentence("", $filtroActual);
        $rows_Veh = $this->Vehiculo->getAllInfoRemisionDByCadena($from_where_sentence);
               $ids_= array(); $j_cantidad=0;
                for($i=0;$i<count($rows_Veh);$i++){
                    if(!(in_array($rows_Veh[$i]->ID_VEHICULO, $ids_))){  
                        if($rows_Veh[$i]->NO_FICHA_R==0)
                            $data[$j_cantidad] = $this->Vehiculo->getVehiculos($rows_Veh[$i]->ID_VEHICULO);
                        else
                            $data[$j_cantidad] = $this->Vehiculo->getVehiculoFicha($rows_Veh[$i]->ID_VEHICULO,$rows_Veh[$i]->NO_FICHA_R);  
                        array_push($ids_, $rows_Veh[$i]->ID_VEHICULO);
                        $j_cantidad++;
                    }
                    
                }
        $this->view('system/vehiculos/fichasView', $data);
    }
    public function generarFormato(){
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Vehiculos[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }
        if (isset($_GET['no_vehiculo'])) {
            $no_vehiculo = $_GET['no_vehiculo'];
            $data = $this->Vehiculo->getVehiculos($no_vehiculo);
            if($data['vehiculo']->NO_FICHA_R!=0){
                $data = $this->Vehiculo->getVehiculoFicha($no_vehiculo,$data['vehiculo']->NO_FICHA_R);
            }
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $this->view('system/vehiculos/fichaView', $data);

    }
    public function getFotos()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Vehiculos[2] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['id_vehiculo'])) {
                $data = $this->Vehiculo->getFotos($_POST);
                if ($data['status']) {
                    $data_p['status'] = true;
                    $data_p['foto'] = $data['data'];
                    echo json_encode($data_p);
                } else {
                    $data_p['status'] = false;
                    $data_p['error_message'] = $data['error_message'];
                    echo json_encode($data_p);
                }
            } else {
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';
                echo json_encode($data_p);
            }
        }
    }
    public function updateFotos()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Vehiculos[1] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';

            echo json_encode($data_p);
        } else {
            if (isset($_POST['captura_fyh'])) {
                $id_vehiculo = $_POST['id_vehiculo'];
                $path_carpeta = BASE_PATH . "public/files/Vehiculos/" . $id_vehiculo . "/Fotos/";
                $name = $_FILES['file']['type'];
                $name = explode("/", $name);
                $name = $_POST['tipo'] . "." . $name[1];

                $success = $this->Vehiculo->updateFotos($_POST, $id_vehiculo, $name);
                if($success['status']){
                    $result = $this->uploadImageFileVehiculos('file', $_FILES, $id_vehiculo, $path_carpeta, $name);
                    if($result){
                        $data_p['status'] =  true;
                        $data_p['nameFile'] = $success['nameFile'];
                    } else {
                        $data_p['status'] =  false;
                        $data_p['error_message'] = 'Hubo un error con la imagen. Imagenes aceptadas .jpeg, .png, .jpg,.PNG, .JPG, .JPEG';
                    }
                    $user = $_SESSION['userdata']->Id_Usuario;
                    $ip = $this->obtenerIp();
                    $descripcion = 'Vehiculo: ' . $id_vehiculo . ' Captura de fotos';
                    $this->Vehiculo->historial($user, $ip, 3, $descripcion);
                } else {
                    $data_p['status'] =  false;
                    $data_p['error_message'] = $success['error_message'];
                }

                echo json_encode($data_p);
            } else {
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';

                echo json_encode($data_p);
            }
        }
    }
    public function uploadImageFileVehiculos($name, $file, $id_vehiculo, $carpeta, $fileName)
    {
        $type = $file[$name]['type'];
        $extension = explode("/", $type);

        $imageUploadPath = $carpeta . $fileName;
        $allowed_mime_type_arr = array('jpeg', 'png', 'jpg', 'PNG');

        if (!file_exists($carpeta))
            mkdir($carpeta, 0777, true);

        if (in_array($extension[1], $allowed_mime_type_arr)) {
            $img_temp = $file[$name]['tmp_name'];
            $compressedImg = $this->compressImage($img_temp, $imageUploadPath, 75);
            $band = true;
        } else {
            $band = false;
        }

        return $band;
    }
    public function compressImage($source, $destination, $quality)
    {
        $imgInfo = getimagesize($source);
        $mime = $imgInfo['mime'];

        switch ($mime) {
            case 'image/jpeg':
                $image = @imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = @imagecreatefrompng($source);
                break;
            default:
                $image = @imagecreatefromjpeg($source);
        }

        imagejpeg($image, $destination, $quality);

        return $imgInfo;
    }
    public function rotateImage()
    {
        if ($_POST['new'] == 'true') {
            $imagenUrl = $_POST['image'];
            $imgInfo = getimagesize($_POST['image']);
        } else {
            $image = $this->Vehiculo->getFotos($_POST);
            if ($image['status']) {
                $pathFile = base_url . 'public/files/Vehiculos/' . $_POST['id_vehiculo'] . '/Fotos/' . $image['data']->Path_Imagen;
                $imgInfo = getimagesize($pathFile);
                $imagenUrl = $pathFile;
            }
        }

        $path = BASE_PATH . 'public/files/Vehiculos/' . $_POST['id_vehiculo'] . '/Fotos/';
        $mime = $imgInfo['mime'];

        $date = date("Ymdhis");
        $type = explode("/", $mime);
        $tipo = $_POST['tipo'];
        $name = $_POST['tipo'] . "." . $type[1] . "?v=" . $date;

        switch ($mime) {
            case 'image/jpeg':
                $image = @imagecreatefromjpeg($imagenUrl);
                break;
            case 'image/png':
                $image = @imagecreatefrompng($imagenUrl);
                break;
            default:
                $image = @imagecreatefromjpeg($imagenUrl);
        }

        $image = imagerotate($image, 90, 0);

        imagejpeg($image, $path . $_POST['tipo'] . ".jpeg");

        $success = $this->Vehiculo->updateNameFile($tipo, $name, $_POST['id_vehiculo']);
        if ($success['status']) {
            $data_p['status'] = true;
            $data_p['nameFile'] = $name;
        } else {
            $data_p['status'] = false;
            $data_p['error_message'] = $success['error_message'];
        }
        echo json_encode($data_p);
    }
    public function deleteFotos()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Vehiculos[1] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['deleteFile'])) {
                $id_vehiculo = $_POST['id_vehiculo'];
                $path_carpeta = BASE_PATH . "public/files/Vehiculo/" . $id_vehiculo . "/Fotos/";
                $nameDir = $_POST['nameDir'];

                $success = $this->Vehiculo->deleteFotos($id_vehiculo, $_POST['tipo']);
                if ($success['status']) {
                    unlink($path_carpeta . $nameDir);
                    $data_p['status'] = true;
                } else {
                    $data_p['status'] =  false;
                    $data_p['error_message'] = $success['error_message'];
                }
                echo json_encode($data_p);
            } else {
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';

                echo json_encode($data_p);
            }
        }
    }
    public function getAllFotos()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Vehiculos[2] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['no_vehiculo_ver'])) {
                $no_vehiculo_ver = $_POST['no_vehiculo_ver'];
                $success = $this->Vehiculo->getAllFotos($no_vehiculo_ver);
                if ($success['status']) {
                    $data_p['status'] = true;
                    $data_p['fotos'] = $success['fotos'];
                } else {
                    $data_p['status'] = false;
                    $data_p['error_message'] = $success['error_message'];
                }
                echo json_encode($data_p);
            } else {
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';
                echo json_encode($data_p);
            }
        }
    }
    public function uploadFileVehiculos($name, $file, $vehiculo, $carpeta, $ruta)
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
    public function getZona()
    {
        $data = $this->Catalogo->getZonaSector("POLICIA");
        return $data;
    }
    public function getGrupos()
    {
        $data = $this->Catalogo->getSimpleCatalogo("Valor_Grupo", "catalogo_grupos");
        return $data;
    }
    public function sacarPrimerR()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Vehiculos[1] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['ficha_buscar'])) {
                    $success = $this->Vehiculo->sacar_primer($_POST);
                    $data_p['sector']=$success['sector'];
                    $data_p['status'] =  true;  
                echo json_encode($data_p);
            } else {
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';
                $data_p['REALIZO']="NO";
                echo json_encode($data_p);
            }
        }
    }
}
