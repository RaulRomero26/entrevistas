<?php
/*
    FILTROS
    1  - Todos
    2  - Solo personas
    3  - Solo vehículos
    4  - Personas y vehículos
*/
class Inspecciones extends Controller
{

    public $Catalogo;
    public $Inspeccion;
    public $Historial;
    public $FV;// mi formValidator

    public function __construct(){
        $this->Catalogo = $this->model('Catalogo');
        $this->Inspeccion = $this->model('Inspeccion');
        $this->Historial = $this->model('Historial');
        $this->numColumnsINSP = [12,10,11,12];  //se inicializa el número de columns por cada filtro
        $this->FV = new FormValidator(); //instancia de formValidator
    }

    //vista principal
    public function index(){
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Inspecciones[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $data = [
            'titulo'    => 'Planeación | Inspecciones',
            'extra_css' => '<link rel="stylesheet" href="' . base_url . 'public/css/system/inspecciones/index.css">',
            'extra_js'  => '<script src="' . base_url . 'public/js/system/inspecciones/index.js"></script>'.
                            '<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"></script>'.
                            '<script src="' . base_url . 'public/js/system/inspecciones/grafica.js"></script>'
        ];

        //PROCESO DE FILTRADO DE EVENTOS DELICTIVOS

        if (isset($_GET['filtro']) && is_numeric($_GET['filtro']) && $_GET['filtro'] >= MIN_FILTRO_INSP && $_GET['filtro'] <= MAX_FILTRO_INSP) { //numero de catálogo
            $filtro = $_GET['filtro'];
        } else {
            $filtro = 1;
        }

        //PROCESAMIENTO DE LAS COLUMNAS 
        $this->setColumnsSession($filtro);
        $data['columns_INSP'] = $_SESSION['userdata']->columns_INSP;

        //PROCESAMIENTO DE RANGO DE FOLIOS
        if (isset($_POST['rango_inicio']) && isset($_POST['rango_fin']) && isset($_POST['rango_hora_inicio']) && isset($_POST['rango_hora_fin'])) {
            $_SESSION['userdata']->rango_inicio_insp = $_POST['rango_inicio'];
            $_SESSION['userdata']->rango_fin_insp = $_POST['rango_fin'];
            $_SESSION['userdata']->rango_hora_inicio_insp = $_POST['rango_hora_inicio'];
            $_SESSION['userdata']->rango_hora_fin_insp = $_POST['rango_hora_fin'];
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

        $where_sentence = $this->Inspeccion->generateFromWhereSentence($cadena, $filtro);
        $extra_cad = ($cadena != "") ? ("&cadena=" . $cadena) : ""; //para links conforme a búsqueda

        $no_of_records_per_page = NUM_MAX_REG_PAGE; //total de registros por pagination
        $offset = ($numPage - 1) * $no_of_records_per_page; // desplazamiento conforme a la pagina

        $results_rows_pages = $this->Inspeccion->getTotalPages($no_of_records_per_page, $where_sentence);   //total de páginas de acuerdo a la info de la DB
        $total_pages = $results_rows_pages['total_pages'];

        if ($numPage > $total_pages) {
            $numPage = 1;
            $offset = ($numPage - 1) * $no_of_records_per_page;
        } //seguridad si ocurre un error por url     

        $rows_Inspecciones = $this->Inspeccion->getDataCurrentPage($offset, $no_of_records_per_page, $where_sentence);    //se obtiene la información de la página actual

        //guardamos la tabulacion de la información para la vista
        $data['infoTable'] = $this->generarInfoTable($rows_Inspecciones, $filtro);
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
                $data['filtroNombre'] = "Solo personas";
                break;
            case '3':
                $data['filtroNombre'] = "Solo vehículos";
                break;
            case '4':
                $data['filtroNombre'] = "Personas y vehículos";
                break;
        }

        
        
        $this->view('templates/header', $data);
        $this->view('system/inspecciones/inspeccionView', $data);
        $this->view('templates/footer', $data);
    }
    //formulario para nueva inspección
    public function nuevaInspeccion(){

        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Inspecciones[3] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $data = [
            'titulo'    => 'Planeación | Inspecciones nueva',
            'extra_css' => '<link rel="stylesheet" href="' . base_url . 'public/css/system/inspecciones/nuevaInspeccion.css">'.
                           '<link rel="stylesheet" href="' . base_url . 'public/css/system/remisiones/capturaFotos.css">',
            'extra_js'  => '<script src="' . base_url . 'public/js/system/inspecciones/nuevaInspeccion.js"></script>'.
                           //'<script src="' . base_url . 'public/js/maps/inspecciones/principal.js"></script>'.
                           //'<script src="https://maps.googleapis.com/maps/api/js?key=' . API_KEY . '&callback=initMap&libraries=places" async defer></script>'.
                           '<script src="' . base_url . 'public/js/system/remisiones/capturaFotos.js"></script>'.
                           '<script src="' . base_url . 'public/js/system/inspecciones/personaTable.js"></script>'.
                           '<script src="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js"></script>'.
                           '<link href="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css" rel="stylesheet" />'.
                           '<script src="' . base_url . 'public/js/maps/inspecciones/principal_mapbox.js"></script>'.
                           '<script src="' . base_url . 'public/js/system/inspecciones/callesycolonias.js"></script>'.
                           '<script src="' . base_url . 'public/js/system/inspecciones/validacionesForm.js"></script>'
        ];

        //se cargan los grupos posibles
        $data['grupos'] = '';
        $gruposAux = $this->Catalogo->getGruposZonasSectores();
        if ($gruposAux) {
            foreach ($gruposAux as $ind => $row) {
                if ($ind == 0) 
                    $data['grupos'].= '<option value="'.$row->Tipo_Grupo.'" selected>'.$row->Tipo_Grupo.'</option>';
                else
                    $data['grupos'].= '<option value="'.$row->Tipo_Grupo.'">'.$row->Tipo_Grupo.'</option>';   
            }
        }
        $data['marcas_vehiculos'] = $this->Inspeccion->getMarcas();
        $data['submarcas_vehiculos'] = $this->Inspeccion->getSubmarcas();
        $data['tipos_vehiculos'] = $this->Inspeccion->getTipos();

        $this->view('templates/header', $data);
        $this->view('system/inspecciones/nuevaInspeccionView', $data);
        $this->view('templates/footer', $data);     
    }
    //función para insertar POST por fetch junto con imágenes
    public function insertInspeccionFetch(){
        // echo json_encode($_POST['personas']);
        // $data = json_decode($_POST['personas']);
        // echo json_encode($data);
        if (isset($_POST['enviar_inspeccion'])) {
            $k = 0;
            //set rules | validando la información del formulario
            $valid[$k++] = $data['error_quien_solicita']      = $this->FV->validate($_POST,'Quien_Solicita'          ,'required | max_length[200]');
            $valid[$k++] = $data['error_clave_solicitante']   = $this->FV->validate($_POST,'Clave_Num_Solicitante'   ,'required | max_length[45]');
            $valid[$k++] = $data['error_fecha']               = $this->FV->validate($_POST,'Fecha_Inspeccion'        ,'required | date');
            $valid[$k++] = $data['error_hora']                = $this->FV->validate($_POST,'Hora_Inspeccion'         ,'required | time');
            $valid[$k++] = $data['error_motivo']              = $this->FV->validate($_POST,'Motivo_Inspeccion'       ,'required | max_length[1000]');
            $valid[$k++] = $data['error_resultado']           = $this->FV->validate($_POST,'Resultado_Inspeccion'    ,'required | max_length[1000]');

            if (isset($_POST['Check_Persona'])) {
                // $valid[$k++] = $data['error_nombre']      = $this->FV->validate($_POST,'Nombre'      ,'required | max_length[100]');
                // $valid[$k++] = $data['error_ap_paterno']  = $this->FV->validate($_POST,'Ap_Paterno'  ,'required | max_length[100]');
                // $valid[$k++] = $data['error_ap_materno']  = $this->FV->validate($_POST,'Ap_Materno'  ,'required | max_length[100]');
                //$valid[$k++] = $data['error_alias']       = $this->FV->validate($_POST,'Alias'       ,'required | max_length[100]');
            }
            else
                $valid[$k++] = $data['error_inspeccion_a']    = $this->FV->validate($_POST,'Check_Vehiculo'  ,'required');
            
            if (isset($_POST['Check_Vehiculo'])) {
                $valid[$k++] = $data['error_marca']       = $this->FV->validate($_POST,'Marca'               ,'required | max_length[450]');
                $valid[$k++] = $data['error_modelo']      = $this->FV->validate($_POST,'Modelo'              ,'required | max_length[450]');
                $valid[$k++] = $data['error_placas']      = $this->FV->validate($_POST,'Placas_Vehiculo'     ,'required | max_length[50]');
                $valid[$k++] = $data['error_colocacion']  = $this->FV->validate($_POST,'Colocacion_Placa'    ,'required | max_length[45]');
            }
            else
                $valid[$k++] = $data['error_inspeccion_a']    = $this->FV->validate($_POST,'Check_Persona'   ,'required');

            $valid[$k++] = $data['error_colonia']     = $this->FV->validate($_POST,'Colonia'         ,'required | max_length[450]');
            $valid[$k++] = $data['error_calle_1']     = $this->FV->validate($_POST,'Calle_1'         ,'required | max_length[450]');
            //$valid[$k++] = $data['error_calle_2']     = $this->FV->validate($_POST,'Calle_2'         ,'required | max_length[450]');
            // $valid[$k++] = $data['error_no_ext']      = $this->FV->validate($_POST,'No_Ext'          ,'max_length[45]');
            // $valid[$k++] = $data['error_no_int']      = $this->FV->validate($_POST,'No_Int'          ,'max_length[45]');
            $valid[$k++] = $data['error_coord_x']     = $this->FV->validate($_POST,'Coordenada_X'    ,'required | max_length[45]');
            $valid[$k++] = $data['error_coord_y']     = $this->FV->validate($_POST,'Coordenada_Y'    ,'required | max_length[45]');
            

            $success = true;
            foreach ($valid as $val) 
                $success &= ($val=='')?true:false;
            $success = true;
            if ($success) {
                //se trata de insertar la nueva inspección
                $success = $this->Inspeccion->insertNuevaInspeccion($_POST);
                if ($success['status']) {
                    //se trata de insertar las imagenes si es que existen
                    $success2 = $this->uploadImagesInsp($_FILES,$success['Id_Inspeccion']);
                    if ($success2['status']) {
                         $this->Historial->insertHistorial(7,'CON imágenes '.$success['Id_Inspeccion']);
                         echo json_encode("Todo correcto");
                    }
                    else{
                        $this->Historial->insertHistorial(7,'SIN imágenes '.$success['Id_Inspeccion']);
                        echo json_encode("Inspección insertada, error en subida de imágenes");
                    }
                }
                else{
                    echo json_encode("Error, Error al insertar en la DB");
                }
            }
            else{
                echo json_encode($data);
            }
        }
        else{
            echo json_encode("Error, No tiene acceso a este apartado");
        }
    }
    //ver resumen de una inspección insertada
    public function verInspeccion(){
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Inspecciones[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $data = [
            'titulo'    => 'Planeación | Ver Inspección',
            'extra_css' => '<link rel="stylesheet" href="' . base_url . 'public/css/system/inspecciones/verInspeccion.css">'
        ];

        //validando parámetro de get
        if (!isset($_GET['id_inspeccion']) || !is_numeric($_GET['id_inspeccion'])) {
            header("Location: " . base_url . "Inicio");
            exit();
        } 
        //cargar info de la inspección
        $id_inspeccion = $_GET['id_inspeccion'];
        $data['info_inspeccion'] = $this->Inspeccion->getInspeccionInfo($id_inspeccion);
        $data['personas_array'] = $this->Inspeccion->getPersonasArray($id_inspeccion);
        //se parsean las fechas de nacimiento
        foreach ($data['personas_array'] as $key => $persona) {
            $data['personas_array'][$key]->Fecha_Nacimiento = $this->formatearOnlyFecha2($persona->Fecha_Nacimiento);
        }

        if (!$data['info_inspeccion']) {
            header("Location: " . base_url . "Inicio");
            exit();
        }
        //dar formato a la fecha de la base de datos
        $auxFecha = $this->formatearFechaHora($data['info_inspeccion']->Fecha_Hora_Inspeccion);
        $data['info_inspeccion']->Fecha = $auxFecha['Fecha'];
        $data['info_inspeccion']->Hora = $auxFecha['Hora'];
        $auxFecha = $this->formatearFechaHora($data['info_inspeccion']->Fecha_Registro_Inspeccion);
        $data['info_inspeccion']->Fecha2 = $auxFecha['Fecha'];
        $data['info_inspeccion']->Hora2 = $auxFecha['Hora'];
        // $data['info_inspeccion']->Aux_Fecha_Nacimiento = $this->formatearOnlyFecha($data['info_inspeccion']->Fecha_Nacimiento);
        //precargado de todas las url de las imagenes de la inspección

        $data['info_inspeccion']->Urls_Images = $this->Inspeccion->getImagesByIdInspeccion($data['info_inspeccion']->Id_Inspeccion);
        // $rows = explode("|", $imagenes);
        // $k = 0;
        // foreach ($rows as $row) {
        //     if($row){
        //         $aux = explode(",", $row);
        //         $data['info_inspeccion']->Urls_Images[$k++] = $aux[2];
        //     }
            
        // }
        $this->Historial->insertHistorial(9,$data['info_inspeccion']->Id_Inspeccion);
        $this->view('templates/header', $data);
        $this->view('system/inspecciones/verInspeccionView', $data);
        $this->view('templates/footer', $data);
    }

    //editar una inspección insertada
    public function editarInspeccion(){
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Inspecciones[1] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $data = [
            'titulo'    =>  'Planeación | Editar Inspección',
            'extra_css' =>  '<link rel="stylesheet" href="' . base_url . 'public/css/system/inspecciones/editarInspeccion.css">'.
                            '<link rel="stylesheet" href="' . base_url . 'public/css/system/remisiones/capturaFotos.css">',
            'extra_js'  =>  '<script src="' . base_url . 'public/js/system/inspecciones/editarInspeccion.js"></script>'.
                            //'<script src="' . base_url . 'public/js/maps/inspecciones/principal.js"></script>'.
                            //'<script src="https://maps.googleapis.com/maps/api/js?key=' . API_KEY . '&callback=initMap&libraries=places" async defer></script>'.
                            '<script src="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js"></script>'.
                           '<link href="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css" rel="stylesheet" />'.
                           '<script src="' . base_url . 'public/js/system/inspecciones/callesycolonias.js"></script>'.
                           '<script src="' . base_url . 'public/js/maps/inspecciones/principal_mapbox.js"></script>'.
                           '<script src="' . base_url . 'public/js/system/remisiones/capturaFotos.js"></script>'.
                           '<script src="' . base_url . 'public/js/system/inspecciones/personaTable.js"></script>'.
                           '<script src="' . base_url . 'public/js/system/inspecciones/validacionesForm.js"></script>'
        ];

        //validando parámetro de get
        if (!isset($_GET['id_inspeccion']) || !is_numeric($_GET['id_inspeccion'])) {
            header("Location: " . base_url . "Inicio");
            exit();
        } 
        //cargar info de la inspección
        $id_inspeccion = $_GET['id_inspeccion'];
        $data['info_inspeccion'] = $this->Inspeccion->getInspeccionInfo($id_inspeccion);

        if (!$data['info_inspeccion']) {
            header("Location: " . base_url . "Inicio");
            exit();
        }
        //dar formato a la fecha de la base de datos
        $auxFecha = $this->formatearFechaHora($data['info_inspeccion']->Fecha_Hora_Inspeccion);
        $data['info_inspeccion']->Fecha = $auxFecha['Fecha'];
        $data['info_inspeccion']->Hora = $auxFecha['Hora'];
        //$auxFecha = $this->formatearFechaHora($data['info_inspeccion']->Fecha_Registro_Inspeccion);
        //$data['info_inspeccion']->Fecha2 = $auxFecha['Fecha'];
        //$data['info_inspeccion']->Hora2 = $auxFecha['Hora'];
        //precargado de todas las url de las imagenes de la inspección
        $imagenes = $data['info_inspeccion']->Imagenes_Inspeccion;
        $rows = ($imagenes)?explode("|", $imagenes):[]; //si tiene imgs se separa por | caso contrario se pone en vacío
        $k = 0;
        foreach ($rows as $row) {
            $aux = explode(",", $row);
            $data['info_inspeccion']->Urls_Images[$k++] = $aux[2];
        }
        //se cargan los grupos posibles
        $data['grupos'] = '';
        $gruposAux = $this->Catalogo->getGruposZonasSectores();
        if ($gruposAux) {
            foreach ($gruposAux as $ind => $row) {
                $aux_selected = ($data['info_inspeccion']->Grupo == $row->Tipo_Grupo)?'selected':'';
                if ($ind == 0) 
                    $data['grupos'].= '<option value="'.$row->Tipo_Grupo.'" '.$aux_selected.'>'.$row->Tipo_Grupo.'</option>';
                else
                    $data['grupos'].= '<option value="'.$row->Tipo_Grupo.'" '.$aux_selected.'>'.$row->Tipo_Grupo.'</option>';   
            }
        }

        $data['zonas_sectores'] = '';
        $zonasAux = $this->Inspeccion->getZonaSectorByGrupo($data['info_inspeccion']->Grupo);
        if ($zonasAux) {
            foreach ($zonasAux as $ind => $row) {
                $aux_selected = ($data['info_inspeccion']->Zona_Sector == $row->Valor_Grupo)?'selected':'';
                if ($ind == 0) 
                    $data['zonas_sectores'].= '<option value="'.$row->Valor_Grupo.'" '.$aux_selected.'>'.$row->Valor_Grupo.'</option>';
                else
                    $data['zonas_sectores'].= '<option value="'.$row->Valor_Grupo.'" '.$aux_selected.'>'.$row->Valor_Grupo.'</option>';   
            }
        }
        $data['marcas_vehiculos'] = $this->Inspeccion->getMarcas();
        $data['submarcas_vehiculos'] = $this->Inspeccion->getSubmarcas();
        $data['tipos_vehiculos'] = $this->Inspeccion->getTipos();
        $this->view('templates/header', $data);
        $this->view('system/inspecciones/editarInspeccionView', $data);
        $this->view('templates/footer', $data);
    }
    //evio de formulario por fetch de editar inspección
    public function editarInspeccionFetch(){
        
        // $data = json_decode($_POST['personas']);
        // echo json_encode($data);
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Inspecciones[1] != '1')) {
            header("Location: ".base_url."Inicio");
            exit();
        }

        if (isset($_POST['Old_Ids2'])) { //significa que la inspección tuvo img previas
            // proceso de comparación para ver si se borra alguna img anterior
            $Ids_1 = isset($_POST['Old_Ids'])?$_POST['Old_Ids']:[];
            $Ids_2 = $_POST['Old_Ids2'];
            $Paths_1 = isset($_POST['Old_Path'])?$_POST['Old_Path']:[];
            $Paths_2 = $_POST['Old_Path2'];
            $ids_delete = [];
            $paths_delete = [];
            foreach ($Ids_2 as $key => $id2) { //recorremos el array inicial
                if (!in_array($id2, $Ids_1)) { //si no esta el actual con el anterior se guarda en cada array
                    //array_push($ids_delete, $id2);
                    //array_push($paths_delete, $Paths_2[$key]);
                    $this->removeImageInps($_POST['Id_Inspeccion'],$Paths_2[$key]); //se borra img de carpeta
                    $this->Inspeccion->deleteImageInspeccion($id2); //se borra registro de la img en la DB
                }
            }
            //$data['ids_delete'] = $ids_delete;
            //$data['paths_delete'] = $paths_delete;
            //cho json_encode($data);
        }
        
        
        if (isset($_POST['enviar_inspeccion'])) {
            $k = 0;
            //set rules | validando la información del formulario
            $valid[$k++] = $this->FV->validate($_POST,'Id_Inspeccion' ,'required | numeric');
            $valid[$k++] = $data['error_quien_solicita']      = $this->FV->validate($_POST,'Quien_Solicita'          ,'required | max_length[200]');
            $valid[$k++] = $data['error_clave_solicitante']   = $this->FV->validate($_POST,'Clave_Num_Solicitante'   ,'required | max_length[45]');
            $valid[$k++] = $data['error_fecha']               = $this->FV->validate($_POST,'Fecha_Inspeccion'        ,'required | date');
            $valid[$k++] = $data['error_hora']                = $this->FV->validate($_POST,'Hora_Inspeccion'         ,'required | time');
            $valid[$k++] = $data['error_motivo']              = $this->FV->validate($_POST,'Motivo_Inspeccion'       ,'required | max_length[1000]');
            $valid[$k++] = $data['error_resultado']           = $this->FV->validate($_POST,'Resultado_Inspeccion'    ,'required | max_length[1000]');

            if (isset($_POST['Check_Persona'])) {
                // $valid[$k++] = $data['error_nombre']      = $this->FV->validate($_POST,'Nombre'      ,'required | max_length[100]');
                // $valid[$k++] = $data['error_ap_paterno']  = $this->FV->validate($_POST,'Ap_Paterno'  ,'required | max_length[100]');
                // $valid[$k++] = $data['error_ap_materno']  = $this->FV->validate($_POST,'Ap_Materno'  ,'required | max_length[100]');
                //$valid[$k++] = $data['error_alias']       = $this->FV->validate($_POST,'Alias'       ,'required | max_length[100]');
            }
            else
                $valid[$k++] = $data['error_inspeccion_a']    = $this->FV->validate($_POST,'Check_Vehiculo'  ,'required');
            
            if (isset($_POST['Check_Vehiculo'])) {
                $valid[$k++] = $data['error_marca']       = $this->FV->validate($_POST,'Marca'               ,'required | max_length[450]');
                $valid[$k++] = $data['error_modelo']      = $this->FV->validate($_POST,'Modelo'              ,'required | max_length[450]');
                $valid[$k++] = $data['error_placas']      = $this->FV->validate($_POST,'Placas_Vehiculo'     ,'required | max_length[50]');
                $valid[$k++] = $data['error_colocacion']  = $this->FV->validate($_POST,'Colocacion_Placa'    ,'required | max_length[45]');
            }
            else
                $valid[$k++] = $data['error_inspeccion_a']    = $this->FV->validate($_POST,'Check_Persona'   ,'required');

            $valid[$k++] = $data['error_colonia']     = $this->FV->validate($_POST,'Colonia'         ,'required | max_length[450]');
            $valid[$k++] = $data['error_calle_1']     = $this->FV->validate($_POST,'Calle_1'         ,'required | max_length[450]');
            //$valid[$k++] = $data['error_calle_2']     = $this->FV->validate($_POST,'Calle_2'         ,'required | max_length[450]');
            // $valid[$k++] = $data['error_no_ext']      = $this->FV->validate($_POST,'No_Ext'          ,'required | max_length[45]');
            // $valid[$k++] = $data['error_no_int']      = $this->FV->validate($_POST,'No_Int'          ,'max_length[45]');
            $valid[$k++] = $data['error_coord_x']     = $this->FV->validate($_POST,'Coordenada_X'    ,'required | max_length[45]');
            $valid[$k++] = $data['error_coord_y']     = $this->FV->validate($_POST,'Coordenada_Y'    ,'required | max_length[45]');
            

            $success = true;
            foreach ($valid as $val) 
                $success &= ($val=='')?true:false;
            
            if ($success) {
                //se trata de insertar la nueva inspección
                $success = $this->Inspeccion->updateInspeccion($_POST);
                if ($success['status']) {
                    $success['personas_check'] = true;
                    //se trata de insertar las imagenes si es que existen
                    $success2 = $this->uploadImagesInsp($_FILES,$_POST['Id_Inspeccion']);
                    if ($success2['status']) {
                        $this->Historial->insertHistorial(8,'CON imágenes '.$_POST['Id_Inspeccion']);
                         echo json_encode("Todo correcto");
                    }
                    else{
                        $this->Historial->insertHistorial(8,'SIN imágenes '.$_POST['Id_Inspeccion']);
                        echo json_encode("Inspección insertada, error en subida de imágenes");
                    }
                }
                else{
                    echo json_encode("Error, Error al insertar en la DB");
                }
            }
            else{
                echo json_encode($data);
            }
        }
        else{
            echo json_encode("Error, No tiene acceso a este apartado");
        }
    }

    //se cargan las personas de cierta inspeccion por fetch
    public function getPersonasArrayFetch(){
        if(isset($_POST['Id_Inspeccion'])){
            $personasArray = $this->Inspeccion->getPersonasArray($_POST['Id_Inspeccion']);
            echo ($personasArray)? json_encode($personasArray) : json_encode([]);
        }
        else{
            echo json_encode([]);
        }
    }

    public function getGrupos(){ //obtener todos los grupos que existen del catálogo
        if (isset($_POST['enviar_grupos'])) {
            $grupos = $this->Catalogo->getGruposZonasSectores();
            if ($grupos) {
                $data['grupos'] = '';
                foreach ($grupos as $ind => $row) {
                    if ($ind == 0) 
                        $data['grupos'].= '<option value="'.$row->Tipo_Grupo.'" selected>'.$row->Tipo_Grupo.'</option>';
                    else
                        $data['grupos'].= '<option value="'.$row->Tipo_Grupo.'">'.$row->Tipo_Grupo.'</option>';
                    
                }
                echo json_encode($data);
            }
            else{
                echo json_encode("Error | No hay registros");
            }
        }
        else{
            echo json_encode("Error | acceso denegado");
        }  
    }

    public function getZonaSector(){ //obtener todas las zonas y sectores del grupo elegido
        if (isset($_POST['grupo'])) {
            $zonas_sectores = $this->Inspeccion->getZonaSectorByGrupo($_POST['grupo']);
            if ($zonas_sectores) {
                $data['zonas_sectores'] = '';
                foreach ($zonas_sectores as $ind => $row) {
                    if ($ind == 0) 
                        $data['zonas_sectores'].= '<option value="'.$row->Valor_Grupo.'" selected>'.$row->Valor_Grupo.'</option>';
                    else
                        $data['zonas_sectores'].= '<option value="'.$row->Valor_Grupo.'">'.$row->Valor_Grupo.'</option>';
                }
                echo json_encode($data);
            }
            else{
                echo json_encode("Error | No hay registros con este grupo");
            }
        }
        else{
            echo json_encode("Error | acceso denegado");
        }
    }

    //-----------------------FUNCIONES AUXILIARES PARA COMPLEMENTAR LOS PRINCIPALES MÓDULOS-----------------------
    //función para generar la paginación dinámica
    public function generarLinks($numPage,$total_pages,$extra_cad = "",$filtro = 1){
            //$extra_cad sirve para determinar la paginacion conforme a si se realizó una busqueda
            //Creación de links para el pagination
            $links = "";

            //FLECHA IZQ (PREV PAGINATION)
            if ($numPage>1) {
                $links.= '<li class="page-item">
                            <a class="page-link" href=" '.base_url.'Inspecciones/index/?numPage=1'.$extra_cad.'&filtro='.$filtro.' " data-toggle="tooltip" data-placement="top" title="Primera página">
                                <i class="material-icons">first_page</i>
                            </a>
                        </li>';
                $links.= '<li class="page-item">
                            <a class="page-link" href=" '.base_url.'Inspecciones/index/?numPage='.($numPage-1).$extra_cad.'&filtro='.$filtro.' " data-toggle="tooltip" data-placement="top" title="Página anterior">
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
                                <a class="page-link" href=" '.base_url.'Inspecciones/index/?numPage='.($ind).$extra_cad.'&filtro='.$filtro.' ">
                                    '.($ind).'
                                </a>
                            </li>';
                }
            }

            //FLECHA DERECHA (NEXT PAGINATION)
            if ($numPage<$total_pages) {

                $links.= '<li class="page-item">
                            <a class="page-link" href=" '.base_url.'Inspecciones/index/?numPage='.($numPage+1).$extra_cad.'&filtro='.$filtro.' " data-toggle="tooltip" data-placement="top" title="Siguiente página">
                            <i class="material-icons">navigate_next</i>
                            </a>
                        </li>';
                $links.= '<li class="page-item">
                            <a class="page-link" href=" '.base_url.'Inspecciones/index/?numPage='.($total_pages).$extra_cad.'&filtro='.$filtro.' " data-toggle="tooltip" data-placement="top" title="Última página">
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
                case '1': //general
                    $infoTable['header'] .= '
                        <th class="column1">Folio</th>
                        <th class="column2">Solicitante</th>
                        <th class="column3">Grupo</th>
                        <th class="column4">Zona Sector</th>
                        <th class="column5">Motivo</th>
                        <th class="column6">Persona(s) Insp</th>
                        <th class="column7">Vehículo Insp</th>
                        <th class="column8">Colocación Placa</th>
                        <th class="column9">Resultado</th>
                        <th class="column10">Imágenes</th>
                        <th class="column11">Fecha y Hora</th>
                        <th class="column12">Creada por</th>
                    ';
                    foreach ($rows as $row) {
                        $images = $this->generarImagesInspecciones($row->Id_Inspeccion);
                        //separación de las personas de la inspección
                        $personasCad = "";
                        $personasArray = explode('|||',$row->Personas_Inspeccion);
                        foreach ($personasArray as $key => $per) {
                            
                            $personasCad .= ($per)? ($key+1).".- ".$per."<br>":'';
                        }
                        $infoTable['body'].= '<tr id="tr'.$row->Id_Inspeccion.'">';
                        $infoTable['body'].= '  <td class="column1">'.$row->Id_Inspeccion.'</td>
                                            <td class="column2">'.mb_strtoupper($row->Quien_Solicita).'</td>
                                            <td class="column3">'.mb_strtoupper($row->Grupo).'</td>
                                            <td class="column4">'.mb_strtoupper($row->Zona_Sector).'</td>
                                            <td class="column5">'.mb_strtoupper($row->Motivo_Inspeccion).'</td>
                                            <td class="column6">'.mb_strtoupper($personasCad).'</td>
                                            <td class="column7">'.mb_strtoupper($row->Vehiculo_Inspeccionado).'</td>
                                            <td class="column8">'.mb_strtoupper($row->Colocacion_Placa).'</td>
                                            <td class="column9">'.mb_strtoupper($row->Resultado_Inspeccion).'</td>
                                            <td class="column10">'.$images.'</td>
                                            <td class="column11">'.$row->Fecha_Hora_Inspeccion.'</td>
                                            <td class="column12">'.mb_strtoupper($row->Nombre_Usuario).'</td>

                        ';
                        $infoTable['body'].= '<td>
                                            <a class="myLinks mb-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="right" title="Editar registro" href="'.base_url.'Inspecciones/editarInspeccion/?id_inspeccion='.$row->Id_Inspeccion.'">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a class="myLinks mt-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="right" title="Ver registro" href="'.base_url.'Inspecciones/verInspeccion/?id_inspeccion='.$row->Id_Inspeccion.'">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                        </td>';
                        
                        $infoTable['body'].= '</tr>';
                    }
                break;
                case '2': //solo personas
                    $infoTable['header'] .= '
                        <th class="column1">Folio</th>
                        <th class="column2">Solicitante</th>
                        <th class="column3">Grupo</th>
                        <th class="column4">Zona Sector</th>
                        <th class="column5">Motivo</th>
                        <th class="column6">Persona(s) Insp</th>
                        <th class="column7">Resultado</th>
                        <th class="column8">Imágenes</th>
                        <th class="column9">Fecha y Hora</th>
                        <th class="column10">Creada por</th>
                    ';
                    foreach ($rows as $row) {
                        
                        $images = $this->generarImagesInspecciones($row->Id_Inspeccion);
                        //separación de las personas de la inspección
                        $personasCad = "";
                        $personasArray = explode('|||',$row->Personas_Inspeccion);
                        foreach ($personasArray as $per) {
                            $personasCad .= $per."<br>";
                        }
                        $infoTable['body'].= '<tr id="tr'.$row->Id_Inspeccion.'">';
                        $infoTable['body'].= '  <td class="column1">'.$row->Id_Inspeccion.'</td>
                                            <td class="column2">'.mb_strtoupper($row->Quien_Solicita).'</td>
                                            <td class="column3">'.mb_strtoupper($row->Grupo).'</td>
                                            <td class="column4">'.mb_strtoupper($row->Zona_Sector).'</td>
                                            <td class="column5">'.mb_strtoupper($row->Motivo_Inspeccion).'</td>
                                            <td class="column6">'.mb_strtoupper($personasCad).'</td>
                                            <td class="column7">'.mb_strtoupper($row->Resultado_Inspeccion).'</td>
                                            <td class="column8">'.$images.'</td>
                                            <td class="column9">'.$row->Fecha_Hora_Inspeccion.'</td>
                                            <td class="column10">'.mb_strtoupper($row->Nombre_Usuario).'</td>

                        ';
                        $infoTable['body'].= '<td>
                                            <a class="myLinks mb-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="right" title="Editar registro" href="'.base_url.'Inspecciones/editarInspeccion/?id_inspeccion='.$row->Id_Inspeccion.'">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a class="myLinks mt-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="right" title="Ver registro" href="'.base_url.'Inspecciones/verInspeccion/?id_inspeccion='.$row->Id_Inspeccion.'">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                        </td>';
                        
                        $infoTable['body'].= '</tr>';
                    }
                break;
                case '3': //solo vehículos
                    $infoTable['header'] .= '
                        <th class="column1">Folio</th>
                        <th class="column2">Solicitante</th>
                        <th class="column3">Grupo</th>
                        <th class="column4">Zona Sector</th>
                        <th class="column5">Motivo</th>
                        <th class="column6">Vehículo Insp</th>
                        <th class="column7">Colocación Placa</th>
                        <th class="column8">Resultado</th>
                        <th class="column9">Imágenes</th>
                        <th class="column10">Fecha y Hora</th>
                        <th class="column11">Creada por</th>
                    ';
                    foreach ($rows as $row) {
                        $images = $this->generarImagesInspecciones($row->Id_Inspeccion);
                        $infoTable['body'].= '<tr id="tr'.$row->Id_Inspeccion.'">';
                        $infoTable['body'].= '  <td class="column1">'.$row->Id_Inspeccion.'</td>
                                            <td class="column2">'.mb_strtoupper($row->Quien_Solicita).'</td>
                                            <td class="column3">'.mb_strtoupper($row->Grupo).'</td>
                                            <td class="column4">'.mb_strtoupper($row->Zona_Sector).'</td>
                                            <td class="column5">'.mb_strtoupper($row->Motivo_Inspeccion).'</td>
                                            <td class="column6">'.mb_strtoupper($row->Vehiculo_Inspeccionado).'</td>
                                            <td class="column7">'.mb_strtoupper($row->Colocacion_Placa).'</td>
                                            <td class="column8">'.mb_strtoupper($row->Resultado_Inspeccion).'</td>
                                            <td class="column9">'.$images.'</td>
                                            <td class="column10">'.$row->Fecha_Hora_Inspeccion.'</td>
                                            <td class="column11">'.mb_strtoupper($row->Nombre_Usuario).'</td>

                        ';
                        $infoTable['body'].= '<td>
                                            <a class="myLinks mb-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="right" title="Editar registro" href="'.base_url.'Inspecciones/editarInspeccion/?id_inspeccion='.$row->Id_Inspeccion.'">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a class="myLinks mt-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="right" title="Ver registro" href="'.base_url.'Inspecciones/verInspeccion/?id_inspeccion='.$row->Id_Inspeccion.'">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                        </td>';
                        
                        $infoTable['body'].= '</tr>';
                    }
                break;
                case '4': //personas y vehículos
                    $infoTable['header'] .= '
                        <th class="column1">Folio</th>
                        <th class="column2">Solicitante</th>
                        <th class="column3">Grupo</th>
                        <th class="column4">Zona Sector</th>
                        <th class="column5">Motivo</th>
                        <th class="column6">Persona(s) Insp</th>
                        <th class="column7">Vehículo Insp</th>
                        <th class="column8">Colocación Placa</th>
                        <th class="column9">Resultado</th>
                        <th class="column10">Imágenes</th>
                        <th class="column11">Fecha y Hora</th>
                        <th class="column12">Creada por</th>
                    ';
                    foreach ($rows as $row) {
                        $images = $this->generarImagesInspecciones($row->Id_Inspeccion);
                        //separación de las personas de la inspección
                        $personasCad = "";
                        $personasArray = explode('|||',$row->Personas_Inspeccion);
                        foreach ($personasArray as $per) {
                            $personasCad .= $per."<br>";
                        }
                        $infoTable['body'].= '<tr id="tr'.$row->Id_Inspeccion.'">';
                        $infoTable['body'].= '  <td class="column1">'.$row->Id_Inspeccion.'</td>
                                            <td class="column2">'.mb_strtoupper($row->Quien_Solicita).'</td>
                                            <td class="column3">'.mb_strtoupper($row->Grupo).'</td>
                                            <td class="column4">'.mb_strtoupper($row->Zona_Sector).'</td>
                                            <td class="column5">'.mb_strtoupper($row->Motivo_Inspeccion).'</td>
                                            <td class="column6">'.mb_strtoupper($personasCad).'</td>
                                            <td class="column7">'.mb_strtoupper($row->Vehiculo_Inspeccionado).'</td>
                                            <td class="column8">'.mb_strtoupper($row->Colocacion_Placa).'</td>
                                            <td class="column9">'.mb_strtoupper($row->Resultado_Inspeccion).'</td>
                                            <td class="column10">'.$images.'</td>
                                            <td class="column11">'.$row->Fecha_Hora_Inspeccion.'</td>
                                            <td class="column12">'.mb_strtoupper($row->Nombre_Usuario).'</td>

                        ';
                        $infoTable['body'].= '<td>
                                            <a class="myLinks mb-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="top" title="Editar registro" href="'.base_url.'Inspecciones/editarInspeccion/?id_inspeccion='.$row->Id_Inspeccion.'">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a class="myLinks mt-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="top" title="Ver registro" href="'.base_url.'Inspecciones/verInspeccion/?id_inspeccion='.$row->Id_Inspeccion.'">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                        </td>';
                        
                        $infoTable['body'].= '</tr>';
                    }
                break;
            }
            
            $infoTable['header'].='<th >Operaciones</th>';
            //$infoTable['header'].='<th >Ver</th>';

            return $infoTable;
    }

    //función para generar los links respectivos dependiendo del filtro y/o cadena de búsqueda
    public function generarExportLinks($extra_cad = "",$filtro = 1){
        if ($extra_cad != "") {
            $dataReturn['csv'] =  base_url.'Inspecciones/exportarInfo/?tipo_export=CSV'.$extra_cad.'&filtroActual='.$filtro;
            $dataReturn['excel'] =  base_url.'Inspecciones/exportarInfo/?tipo_export=EXCEL'.$extra_cad.'&filtroActual='.$filtro;
            $dataReturn['pdf'] =  base_url.'Inspecciones/exportarInfo/?tipo_export=PDF'.$extra_cad.'&filtroActual='.$filtro;
            //return $dataReturn;
        }
        else{
            $dataReturn['csv'] =  base_url.'Inspecciones/exportarInfo/?tipo_export=CSV'.$extra_cad.'&filtroActual='.$filtro;
            $dataReturn['excel'] =  base_url.'Inspecciones/exportarInfo/?tipo_export=EXCEL'.$extra_cad.'&filtroActual='.$filtro;
            $dataReturn['pdf'] =  base_url.'Inspecciones/exportarInfo/?tipo_export=PDF'.$extra_cad.'&filtroActual='.$filtro;
        }
        return $dataReturn;
    }

    //función fetch para buscar por la cadena introducida dependiendo del filtro
    public function buscarPorCadena(){
        /*Aquí van condiciones de permisos*/

        if (isset($_POST['cadena'])) {
            $cadena = trim($_POST['cadena']); 
            $filtroActual = trim($_POST['filtroActual']);

            $results = $this->Inspeccion->getInspeccionByCadena($cadena,$filtroActual);
            $extra_cad = ($cadena != "")?("&cadena=".$cadena):""; //para links conforme a búsqueda

            if(strlen($cadena)>0){
                $this->Historial->insertHistorial(10,'Consulta realizada: '.$cadena.'');
            }
            //$dataReturn = "jeje";

            $dataReturn['infoTable'] = $this->generarInfoTable($results['rows_Inspecciones'],$filtroActual);
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
        if (!isset($_REQUEST['filtroActual']) || !is_numeric($_REQUEST['filtroActual']) || !($_REQUEST['filtroActual']>=MIN_FILTRO_INSP) || !($_REQUEST['filtroActual']<=MAX_FILTRO_INSP)) 
                $filtroActual = 1;
            else
                $filtroActual = $_REQUEST['filtroActual'];

        $from_where_sentence = "";
        //se genera la sentencia from where para realizar la correspondiente consulta
        if (isset($_REQUEST['cadena'])) 
            $from_where_sentence = $this->Inspeccion->generateFromWhereSentence($_REQUEST['cadena'],$filtroActual);
        else
            $from_where_sentence = $this->Inspeccion->generateFromWhereSentence("",$filtroActual);

        
        
        //var_dump($_REQUEST);
        $tipo_export = $_REQUEST['tipo_export'];

        if ($tipo_export == 'EXCEL') {
            //se realiza exportacion de usuarios a EXCEL
            $rows_INSP = $this->Inspeccion->getAllInfoInspeccionByCadena($from_where_sentence);
            switch ($filtroActual) {
                case '1':
                    $filename = "INSP_general";
                    $csv_data="Fecha/Hora,Creada por,Folio,Solicitante,Grupo,Zona Sector,Teléfono/Radio,Motivo Inspección,Resultado Inspección,Persona(s) Inspeccionada(s),Vehículo Inspeccionado,Colocación Placa,Placa, Tipo, Marca, Submarca, Color, Modelo, Colonia, Calle 1, Calle 2, Num. Ext, Num.Int, Coor X, Coord Y \n";

                    foreach ($rows_INSP as $row) {
                        //separación de las personas de la inspección
                        $personasCad = "";
                        $personasArray = explode('|||',$row->Personas_Inspeccion);
                        foreach ($personasArray as $per) {
                            $personasCad .= $per." , ";
                        }
                        $personasCad = substr($personasCad,0,strlen($personasCad)-2);
                        $csv_data.= "\"".mb_strtoupper($row->Fecha_Hora_Inspeccion)."\",".
                                    "\"".mb_strtoupper($row->Nombre_Usuario)."\",".
                                    $row->Id_Inspeccion.",\"".
                                    mb_strtoupper($row->Quien_Solicita)."\",\"".
                                    mb_strtoupper($row->Grupo)."\",\"".
                                    mb_strtoupper($row->Zona_Sector)."\",\"".
                                    mb_strtoupper($row->Telefono_Radio)."\",\"".
                                    mb_strtoupper($row->Motivo_Inspeccion)."\",\"".
                                    mb_strtoupper($row->Resultado_Inspeccion)."\",\"".
                                    mb_strtoupper($personasCad)."\",\"".
                                    mb_strtoupper($row->Vehiculo_Inspeccionado)."\",\"".
                                    mb_strtoupper($row->Colocacion_Placa)."\",\"".
                                    mb_strtoupper($row->Placa)."\",\"".
                                    mb_strtoupper($row->Tipo)."\",\"".
                                    mb_strtoupper($row->Marca)."\",\"".
                                    mb_strtoupper($row->Submarca)."\",\"".
                                    mb_strtoupper($row->Color)."\",\"".
                                    mb_strtoupper($row->Modelo)."\",\"".
                                    mb_strtoupper($row->Colonia)."\",\"".
                                    mb_strtoupper($row->Calle_1)."\",\"".
                                    mb_strtoupper($row->Calle_2)."\",\"".
                                    mb_strtoupper($row->No_Ext)."\",\"".
                                    mb_strtoupper($row->No_Int)."\",\"".
                                    mb_strtoupper($row->Coordenada_X)."\",\"".
                                    mb_strtoupper($row->Coordenada_Y)."\"\n";
                    }
                break;
                case '2':
                    $filename = "INSP_personas";
                    $csv_data="Fecha/Hora,Creada por,Folio,Solicitante,Grupo,Zona Sector,Teléfono/Radio,Motivo Inspección,Resultado Inspección,Persona Inspeccionada, Colonia, Calle 1, Calle 2, Num. Ext, Num.Int, Coor X, Coord Y \n";

                    foreach ($rows_INSP as $row) {
                        //separación de las personas de la inspección
                        $personasCad = "";
                        $personasArray = explode('|||',$row->Personas_Inspeccion);
                        foreach ($personasArray as $per) {
                            $personasCad .= $per." , ";
                        }
                        $personasCad = substr($personasCad,0,strlen($personasCad)-2);
                        $csv_data.= "\"".mb_strtoupper($row->Fecha_Hora_Inspeccion)."\",".
                                    "\"".mb_strtoupper($row->Nombre_Usuario)."\",".
                                    $row->Id_Inspeccion.",\"".
                                    mb_strtoupper($row->Quien_Solicita)."\",\"".
                                    mb_strtoupper($row->Grupo)."\",\"".
                                    mb_strtoupper($row->Zona_Sector)."\",\"".
                                    mb_strtoupper($row->Telefono_Radio)."\",\"".
                                    mb_strtoupper($row->Motivo_Inspeccion)."\",\"".
                                    mb_strtoupper($row->Resultado_Inspeccion)."\",\"".
                                    mb_strtoupper($personasCad)."\",\"".
                                    mb_strtoupper($row->Colonia)."\",\"".
                                    mb_strtoupper($row->Calle_1)."\",\"".
                                    mb_strtoupper($row->Calle_2)."\",\"".
                                    mb_strtoupper($row->No_Ext)."\",\"".
                                    mb_strtoupper($row->No_Int)."\",\"".
                                    mb_strtoupper($row->Coordenada_X)."\",\"".
                                    mb_strtoupper($row->Coordenada_Y)."\"\n";
                    }
                break;
                case '3':
                    $filename = "INSP_vehiculos";
                    $csv_data="Fecha/Hora,Creada por,Folio,Solicitante,Grupo,Zona Sector,Teléfono/Radio,Motivo Inspección,Resultado Inspección,Vehículo Inspeccionado,Colocación Placa, Placa, Tipo, Marca, Submarca, Color, Modelo,Colonia, Calle 1, Calle 2, Num. Ext, Num.Int, Coor X, Coord Y \n";

                    foreach ($rows_INSP as $row) {
                        $csv_data.= "\"".mb_strtoupper($row->Fecha_Hora_Inspeccion)."\",".
                                    "\"".mb_strtoupper($row->Nombre_Usuario)."\",".
                                    $row->Id_Inspeccion.",\"".
                                    mb_strtoupper($row->Quien_Solicita)."\",\"".
                                    mb_strtoupper($row->Grupo)."\",\"".
                                    mb_strtoupper($row->Zona_Sector)."\",\"".
                                    mb_strtoupper($row->Telefono_Radio)."\",\"".
                                    mb_strtoupper($row->Motivo_Inspeccion)."\",\"".
                                    mb_strtoupper($row->Resultado_Inspeccion)."\",\"".
                                    mb_strtoupper($row->Vehiculo_Inspeccionado)."\",\"".
                                    mb_strtoupper($row->Colocacion_Placa)."\",\"".
                                    mb_strtoupper($row->Placa)."\",\"".
                                    mb_strtoupper($row->Tipo)."\",\"".
                                    mb_strtoupper($row->Marca)."\",\"".
                                    mb_strtoupper($row->Submarca)."\",\"".
                                    mb_strtoupper($row->Color)."\",\"".
                                    mb_strtoupper($row->Modelo)."\",\"".
                                    mb_strtoupper($row->Colonia)."\",\"".
                                    mb_strtoupper($row->Calle_1)."\",\"".
                                    mb_strtoupper($row->Calle_2)."\",\"".
                                    mb_strtoupper($row->No_Ext)."\",\"".
                                    mb_strtoupper($row->No_Int)."\",\"".
                                    mb_strtoupper($row->Coordenada_X)."\",\"".
                                    mb_strtoupper($row->Coordenada_Y)."\"\n";
                    }
                break;
                case '4':
                    $filename = "INSP_personas_vehiculos";
                    $csv_data="Fecha/Hora,Creada por,Folio,Solicitante,Grupo,Zona Sector,Teléfono/Radio,Motivo Inspección,Resultado Inspección,Persona Inspeccionada,Vehículo Inspeccionado,Colocación Placa,Placa, Tipo, Marca, Submarca, Color, Modelo, Colonia, Calle 1, Calle 2, Num. Ext, Num.Int, Coor X, Coord Y \n";

                    foreach ($rows_INSP as $row) {
                        //separación de las personas de la inspección
                        $personasCad = "";
                        $personasArray = explode('|||',$row->Personas_Inspeccion);
                        foreach ($personasArray as $per) {
                            $personasCad .= $per." , ";
                        }
                        $personasCad = substr($personasCad,0,strlen($personasCad)-2);
                        $csv_data.= "\"".mb_strtoupper($row->Fecha_Hora_Inspeccion)."\",".
                                    "\"".mb_strtoupper($row->Nombre_Usuario)."\",".
                                    $row->Id_Inspeccion.",\"".
                                    mb_strtoupper($row->Quien_Solicita)."\",\"".
                                    mb_strtoupper($row->Grupo)."\",\"".
                                    mb_strtoupper($row->Zona_Sector)."\",\"".
                                    mb_strtoupper($row->Telefono_Radio)."\",\"".
                                    mb_strtoupper($row->Motivo_Inspeccion)."\",\"".
                                    mb_strtoupper($row->Resultado_Inspeccion)."\",\"".
                                    mb_strtoupper($personasCad)."\",\"".
                                    mb_strtoupper($row->Vehiculo_Inspeccionado)."\",\"".
                                    mb_strtoupper($row->Colocacion_Placa)."\",\"".
                                    mb_strtoupper($row->Placa)."\",\"".
                                    mb_strtoupper($row->Tipo)."\",\"".
                                    mb_strtoupper($row->Marca)."\",\"".
                                    mb_strtoupper($row->Submarca)."\",\"".
                                    mb_strtoupper($row->Color)."\",\"".
                                    mb_strtoupper($row->Modelo)."\",\"".
                                    mb_strtoupper($row->Colonia)."\",\"".
                                    mb_strtoupper($row->Calle_1)."\",\"".
                                    mb_strtoupper($row->Calle_2)."\",\"".
                                    mb_strtoupper($row->No_Ext)."\",\"".
                                    mb_strtoupper($row->No_Int)."\",\"".
                                    mb_strtoupper($row->Coordenada_X)."\",\"".
                                    mb_strtoupper($row->Coordenada_Y)."\"\n";
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
            $rows_INSP = $this->Inspeccion->getAllInfoInspeccionByCadena($from_where_sentence);
            

            header("Content-type: application/pdf");
            header("Content-Disposition: inline; filename=usuarios.pdf");
            echo $this->generarPDF($rows_INSP,$_REQUEST['cadena'],$filtroActual);
        }
        else{
            header("Location: ".base_url."Inicio");
            exit();
        }
    }

    //función para armar el archivo PDF dependiendo del filtro y/o cadena de búsqueda
    public function generarPDF($rows_INSP,$cadena = "",$filtroActual = '1'){
        //require('../libraries/PDF library/fpdf16/fpdf.php');
        switch ($filtroActual) {
            case '1': $filename="vista general";break;
            case '2': $filename="personas inspeccionadas";break;
            case '3': $filename="vehículos inspeccionados";break;
            case '4': $filename ="personas y vehículos"; break;
        }

        $data['subtitulo']      = 'Inspecciones: '.$filename;

        if ($cadena != "") {
            $data['msg'] = 'todos los registros de Inspecciones con filtro: '.$cadena.'';
        }
        else{
            $data['msg'] = 'todos los registros de Inspecciones';
        }

        //---Aquí va la info según sea el filtro de ED seleccionado
        switch ($filtroActual) {
            case '1': //todos
                $data['columns'] =  [
                                'Folio',
                                'Solicitante',
                                'Grupo',
                                'Zona Sector',
                                'Teléfono/Radio',
                                'Motivo',
                                'Persona Insp',
                                'Vehículo Insp',
                                'Colocación Placa',
                                'Resultado'
                            ];  
                $data['field_names'] = [
                                'Id_Inspeccion',
                                'Quien_Solicita',
                                'Grupo',
                                'Zona_Sector',
                                'Telefono_Radio',
                                'Motivo_Inspeccion',
                                'Personas_Inspeccion',
                                'Vehiculo_Inspeccionado',
                                'Colocacion_Placa',
                                'Resultado_Inspeccion'
                            ];
                foreach ($rows_INSP as $key => $row) {
                    //separación de las personas de la inspección
                    $personasCad = "";
                    $personasArray = explode('|||',$row->Personas_Inspeccion);
                    foreach ($personasArray as $per) {
                        $personasCad .= $per." , ";
                    }
                    $personasCad = substr($personasCad,0,strlen($personasCad)-2);
                    $rows_INSP[$key]->Personas_Inspeccion = $personasCad;
                }
            break;

            case '2': //solo personas
                $data['columns'] =  [
                                'Folio',
                                'Solicitante',
                                'Grupo',
                                'Zona Sector',
                                'Teléfono/Radio',
                                'Motivo',
                                'Persona Insp',
                                'Resultado'
                            ];  
                $data['field_names'] = [
                                'Id_Inspeccion',
                                'Quien_Solicita',
                                'Grupo',
                                'Zona_Sector',
                                'Telefono_Radio',
                                'Motivo_Inspeccion',
                                'Personas_Inspeccion',
                                'Resultado_Inspeccion'
                            ];
                foreach ($rows_INSP as $key => $row) {
                    //separación de las personas de la inspección
                    $personasCad = "";
                    $personasArray = explode('|||',$row->Personas_Inspeccion);
                    foreach ($personasArray as $per) {
                        $personasCad .= $per." , ";
                    }
                    $personasCad = substr($personasCad,0,strlen($personasCad)-2);
                    $rows_INSP[$key]->Personas_Inspeccion = $personasCad;
                }
            break;
            case '3': // solo vehículos
                $data['columns'] =  [
                                'Folio',
                                'Solicitante',
                                'Grupo',
                                'Zona Sector',
                                'Teléfono/Radio',
                                'Motivo',
                                'Vehículo Insp',
                                'Colocación Placa',
                                'Resultado'
                            ];  
                $data['field_names'] = [
                                'Id_Inspeccion',
                                'Quien_Solicita',
                                'Grupo',
                                'Zona_Sector',
                                'Telefono_Radio',
                                'Motivo_Inspeccion',
                                'Vehiculo_Inspeccionado',
                                'Colocacion_Placa',
                                'Resultado_Inspeccion'
                            ];
            break;
            case '4': //personas y vehículos
                $data['columns'] =  [
                                'Folio',
                                'Solicitante',
                                'Grupo',
                                'Zona Sector',
                                'Teléfono/Radio',
                                'Motivo',
                                'Persona Insp',
                                'Vehículo Insp',
                                'Colocación Placa',
                                'Resultado'
                            ];  
                $data['field_names'] = [
                                'Id_Inspeccion',
                                'Quien_Solicita',
                                'Grupo',
                                'Zona_Sector',
                                'Telefono_Radio',
                                'Motivo_Inspeccion',
                                'Personas_Inspeccion',
                                'Vehiculo_Inspeccionado',
                                'Colocacion_Placa',
                                'Resultado_Inspeccion'
                            ];
                
                foreach ($rows_INSP as $key => $row) {
                    //separación de las personas de la inspección
                    $personasCad = "";
                    $personasArray = explode('|||',$row->Personas_Inspeccion);
                    foreach ($personasArray as $per) {
                        $personasCad .= $per." , ";
                    }
                    $personasCad = substr($personasCad,0,strlen($personasCad)-2);
                    $rows_INSP[$key]->Personas_Inspeccion = $personasCad;
                }
            break;
        }
        //---fin de la info del ED
        

        $data['rows'] = $rows_INSP;
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
            unset($_SESSION['userdata']->rango_inicio_insp);
            unset($_SESSION['userdata']->rango_fin_insp);
            unset($_SESSION['userdata']->rango_hora_inicio_insp);
            unset($_SESSION['userdata']->rango_hora_fin_insp);

            header("Location: ".base_url."Inspecciones/index/?filtro=".$_REQUEST['filtroActual']);
            exit();
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
                $campos = ['Folio','Solicitante','Grupo','Zona Sector','Motivo','Persona Insp','Vehículo Insp','Colocación Placa','Resultado','Imágenes','Fecha y Hora','Creada por'];
            break;
            case '2':
                $campos = ['Folio','Solicitante','Grupo','Zona Sector','Motivo','Persona Insp','Resultado','Imágenes','Fecha y Hora','Creada por'];
            break;
            case '3':
                $campos = ['Folio','Solicitante','Grupo','Zona Sector','Motivo','Vehículo Insp','Colocación Placa','Resultado','Imágenes','Fecha y Hora','Creada por'];
            break;
            case '4':
                $campos = ['Folio','Solicitante','Grupo','Zona Sector','Motivo','Persona Insp','Vehículo Insp','Colocación Placa','Resultado','Imágenes','Fecha y Hora','Creada por'];
            break;
        }
        //gestión de cada columna
        $ind = 1;
        foreach($campos as $campo){
            $checked = ($_SESSION['userdata']->columns_INSP['column'.$ind] == 'show')?'checked':'';
            $dropDownColumn.= ' <div class="form-check">
                                    <input class="form-check-input checkColumns" type="checkbox" value="'.$_SESSION['userdata']->columns_INSP['column'.$ind].'" onchange="hideShowColumn(this.id);" id="column'.$ind.'" '.$checked.'>
                                    <label class="form-check-label" for="column'.$ind.'">
                                        '.$campo.'
                                    </label>
                                </div>';
            $ind++;
        }
        $dropDownColumn.= '     <div class="dropdown-divider">
                                </div>
                                <div class="form-check">
                                    <input id="checkAll" class="form-check-input" type="checkbox" value="hide" onchange="hideShowAll(this.id);" id="column'.$ind.'" checked>
                                    <label class="form-check-label" for="column'.$ind.'">
                                        Todo
                                    </label>
                                </div>';
        return $dropDownColumn;
    }

    //función para checar los cambios de filtro y poder asignar los valores correspondientes de las columnas a la session
    public function setColumnsSession($filtroActual=1){
        //si el filtro existe y esta dentro de los parámetros continua
        if (isset($_SESSION['userdata']->filtro_INSP) && $_SESSION['userdata']->filtro_INSP >= MIN_FILTRO_INSP && $_SESSION['userdata']->filtro_INSP<=MAX_FILTRO_INSP ) {
            //si cambia el filtro se procde a cambiar los valores de las columnas que contiene el filtro seleccionado
            if ($_SESSION['userdata']->filtro_INSP != $filtroActual) {
                $_SESSION['userdata']->filtro_INSP = $filtroActual;
                unset($_SESSION['userdata']->columns_INSP); //se borra las columnas del anterior filtro
                //se asignan las nuevas columnas y por default se muestran todas (atributo show)
                for($i=0;$i<$this->numColumnsINSP[$_SESSION['userdata']->filtro_INSP -1];$i++) 
                    $_SESSION['userdata']->columns_INSP['column'.($i+1)] = 'show';

            }
        }
        else{ //si no existe el filtro entonces se inicializa con el primero por default
            $_SESSION['userdata']->filtro_INSP = $filtroActual;
            unset($_SESSION['userdata']->columns_INSP);
            for($i=0;$i<$this->numColumnsINSP[$_SESSION['userdata']->filtro_INSP -1];$i++)
                $_SESSION['userdata']->columns_INSP['column'.($i+1)] = 'show';

            
        }
        //echo "filtro: ".var_dump($_SESSION['userdata']->filtro_INSP)."<br>br>";
        //echo "columns: ".var_dump($_SESSION['userdata']->columns_INSP)."<br>br>";
    }

    //función fetch que actualiza los valores de las columnas para la session
    public function setColumnFetch(){
        if (isset($_POST['columName']) && isset($_POST['valueColumn'])) {
            $_SESSION['userdata']->columns_INSP[$_POST['columName']] = $_POST['valueColumn'];
            echo json_encode("ok");
        }
        else{
            header("Location: ".base_url."Inicio");
            exit();
        }
    }

    //funcion para generar el html de las imagenes de inspecciones para vista principal
    public function generarImagesInspecciones($id_inspeccion){
        $images = '';
        $imagesArray = $this->Inspeccion->getImagesByIdInspeccion($id_inspeccion);
        
        $cuerpo = '<div class=\'row\'>';
        $ruta = PATH_INSP_FILES.$id_inspeccion; //se carga la ruta donde se tomarán las imgs
        $ruta2 = BASE_INSP_FILES.$id_inspeccion;
        foreach($imagesArray as $img){
            if($img && file_exists($ruta2.'/'.$img->Path_Imagen)){ //si existe el archivo se carga imagen
                $cuerpo .= ' <div class=\'col-12 my-3 d-flex justify-content-center\'>
                                <img class=\'img_inspeccion\' src=\''.$ruta.'/'.$img->Path_Imagen.'\' >
                            </div>';
            }
        }
        $cuerpo .= '</div>';
        $images = '<button type="button" class="btn btn-opacity" data-html="true" data-title="imágenes" data-toggle="popover" data-placement="top" data-trigger="focus"  data-content="'.$cuerpo.'"><i class="material-icons v-a-middle">image</i></button>';
        return $images;
        // //$cuerpo = '';
        
        // if ($row) {
        //     $auxImg = $row; // se obtiene todo el registro
        //     $auxImg = explode("|", $auxImg);    //se separa cada imagen por |
        //     $ruta = PATH_INSP_FILES.$id_inspeccion; //se carga la ruta donde se tomarán las imgs
        //     $ruta2 = BASE_INSP_FILES.$id_inspeccion;
        //     foreach ($auxImg as $registro) {    //se reccorre cada registro para obtener el path
        //         $aux2 = explode(",", $registro);    //se separa cada imagen por ","
        //         if (file_exists($ruta2.'/'.$aux2[2])) { //si existe el archivo se carga imagen
        //             $cuerpo .= ' <div class=\'col-12 my-3 d-flex justify-content-center\'>
        //                             <img class=\'img_inspeccion\' src=\''.$ruta.'/'.$aux2[2].'\' >
        //                         </div>';
        //         }  
        //     }
        // }
        
    }
    //dar formato a fecha y Hora
    public function formatearFechaHora($fecha = null){
        $f_h = explode(" ", $fecha);

        setlocale(LC_TIME, 'es_CO.UTF-8'); //hora local méxico

        $results['Fecha'] = strftime("%d  de %B del %G", strtotime($f_h[0]));
        $results['Hora'] = date('g:i a', strtotime($f_h[1]));

        return $results;
    }
    public function formatearOnlyFecha($fecha = null){
        if($fecha === null)
            return '';

        setlocale(LC_TIME, 'es_CO.UTF-8'); //hora local méxico

        return strftime("%d  de %B del %G", strtotime($fecha));
    }
    public function formatearOnlyFecha2($fecha = null){
        if($fecha == null)
            return '';

        //setlocale(LC_TIME, 'es_CO.UTF-8'); //hora local méxico

        return strftime(" %d / %m / %Y", strtotime($fecha));
    }

    public function getImagesFetch(){
        $data = [
                    'status' => false,
                    'images' => false
                ];
        if (isset($_POST['Id_Inspeccion'])) {
            $images_insp = $this->Inspeccion->getImagesById($_POST['Id_Inspeccion']);
            if ($images_insp) {
                 $data['images'] = $images_insp;
                 $data['status'] = true;
             } 
        }

        echo json_encode($data);
    }
    /*-------------------FUNCIONES CON FILES-------------------*/
    //funcion para subir imagen de inspeccion
    public function uploadImagesInsp($files = null,$id_inspeccion = null){

        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Inspecciones[1] != '1') || $files == null || $id_inspeccion == null) {
            header("Location: ".base_url."Login");
            exit();
        }

        $data['status'] = false;
        //validación del File
        $MAX_SIZE = 80000000; //8 MB
        $allowed_mime_type_arr = array('jpeg','png','jpg','JPEG','PNG','JPG','jfif','JFIF'); //formatoss permitidos
        //Nota: En fetch no funciona get_mime_by_extension()
        
        $carpeta = BASE_PATH."public/files/inspecciones/images/".$id_inspeccion; //path de la carpeta destino
        //se crea carpeta si aun no existe
        if (!file_exists($carpeta)) 
            mkdir($carpeta, 0777, true);
        //else
        //    $this->removeOnlyFilesDir($carpeta,false);
        //subida de todos los archivos junto con actualización en DB
        if (isset($files['files']['tmp_name'])) {
            foreach($files['files']['tmp_name'] as $key => $source){

                //Validamos que el archivo exista
                if($files['files']['name'][$key]) {
                    //primeros parámetros
                    $arrayAux = explode('.', $files['files']['name'][$key]);//separamos el nombre para obtener la extención
                    $mime = end($arrayAux); //obtiene la extensión del file
                    //validación de archivo (size type ...)
                    //se checa si se cumplen todas las condiciones para un file correcto
                    if((isset($files['files']['name'][$key])) && ($files['files']['name'][$key]!="") && ($files['files']['size'][$key]<=$MAX_SIZE)){
                        if(in_array($mime, $allowed_mime_type_arr)){
                            $band = true;
                        }else{
                            $band = false;
                        }
                    }else{
                        $band = false;
                    }

                    //validación del nombre del archivo (evitar nombres repetidos)
                    $img_name = $files['files']['name'][$key];
                    $indAux=1;
                    while (file_exists($carpeta."/".$img_name)) {
                        
                        $img_name = str_replace(".$mime", "", $files['files']['name'][$key])."_"."$indAux".".$mime"; //armando el nuevo nombre de la imagen si ya se repitió
                        $indAux++;
                    }

                    //se procede a subir archivo al sistema
                    if ($band) {//se sube la foto al servidor y se guarda path en DB
                        $success = $this->Inspeccion->insertImageInspeccion($id_inspeccion,$img_name); //se almacena el path en la DB

                        if ($success) { //si se almaceno bien la path en la DB se procede a subir al servidor la imagen
                            $ruta = $carpeta."/".$img_name;
                            copy($source,$ruta); //se guarda la imagen en la carpeta
                            $data['status'] = true;
                        }
                        
                    }
                }
            }
        }
            
        
        return $data;
    }

    public function removeImageInps($id_inspeccion = null, $name_img = null){
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Inspecciones[1] != '1') || $id_inspeccion == null || $name_img == null) {
            header("Location: ".base_url."Login");
        }

        $img_path = BASE_PATH."public/files/inspecciones/images/".$id_inspeccion."/".$name_img; //path de la imagen a borrar
        if (file_exists($img_path)) 
            unlink("$img_path");
    }
    //Función para borrar todo file d ela carpeta
    public function removeOnlyFilesDir($dir,$ind) { //si ind == 1 no borra el directorio original, caso contrario, si lo borra
           $files = array_diff(scandir($dir), array('.','..'));
            foreach ($files as $file) {
              (is_dir("$dir/$file")) ? $this->removeOnlyFilesDir("$dir/$file",false) : unlink("$dir/$file");
            }

            if ($ind) return;
            else return rmdir($dir);
    }

    /**------------------FUNCIONES PARA LAS GRÁFICAS------------------- */
    public function getNumInspPorZonas(){
        $cadena = (isset($_POST['cadena']))?$_POST['cadena']:'';
        echo json_encode($this->Inspeccion->getCountZona($cadena));
    }

}