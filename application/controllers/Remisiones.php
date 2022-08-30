<?php
/*
    Filtros (remisiones):
    1  - General
    2  - Peticionarios
    3  - Ubicación de los hechos
    4  - Elementos participantes
    5  - Ubicación de la detención
    6  - Objetos asegurados
    7  - Armas aseguradas
    8  - Drogas aseguradas
    9  - Accesorios detenido
    10 - Contacto detenido
    11 - Adicción detenido
    12 - Tatuajes
    .
    .
    15 - Vehículos asegurados
*/

use Mpdf\Tag\Img;

class Remisiones extends Controller
{

    public $Catalogo;
    public $Remision;
    public $numColumnsRem; //número de columnas por cada filtro
    public $FV;

    public function __construct()
    {
        $this->Catalogo = $this->model('Catalogo');
        $this->Remision = $this->model('Remision');
        $this->numColumnsRem = [10, 7, 6, 9, 6, 6, 8, 7, 6, 8, 8, 11, 8, 8, 9];  //se inicializa el número de columns por cada filtro
        $this->FV = new FormValidator();
    }

    public function index()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $data = [
            'titulo'    => 'Sistema de remisiones | Remisiones',
            'extra_css' => '<link rel="stylesheet" href="' . base_url . 'public/css/system/remisiones/index.css">',
            'extra_js'  => '<script src="' . base_url . 'public/js/system/remisiones/index.js"></script>
                            <script src="' . base_url . 'public/js/system/juridico/consumoDetenidosJuridico.js"></script>'
        ];

        //PROCESO DE FILTRADO DE EVENTOS DELICTIVOS
        if (isset($_GET['filtro']) && is_numeric($_GET['filtro']) && $_GET['filtro'] >= MIN_FILTRO_REM && $_GET['filtro'] <= MAX_FILTRO_REM) { //numero de filtro
            if ($_GET['filtro'] >= 13 && $_GET['filtro'] <= 14) { //si son filtros de validación
                if ($_SESSION['userdata']->Modo_Admin == '1' || $_SESSION['userdata']->Nivel_User == '1') { //si cuenta con los permisos necesarios
                    $filtro = $_GET['filtro'];
                } else { //si no cuenta con los permisos lo dirige a la vista general
                    $filtro = 1;
                }
            } else {
                $filtro = $_GET['filtro'];
            }
        } else {
            $filtro = 1;
        }

        //PROCESAMIENTO DE LAS COLUMNAS 
        $this->setColumnsSession($filtro);
        $data['columns_REM'] = $_SESSION['userdata']->columns_REM;

        //PROCESAMIENTO DE RANGO DE FOLIOS
        if (isset($_POST['rango_inicio']) && isset($_POST['rango_fin'])) {
            $_SESSION['userdata']->rango_inicio_rem = $_POST['rango_inicio'];
            $_SESSION['userdata']->rango_fin_rem = $_POST['rango_fin'];
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

        $where_sentence = $this->Remision->generateFromWhereSentence($cadena, $filtro);
        $extra_cad = ($cadena != "") ? ("&cadena=" . $cadena) : ""; //para links conforme a búsqueda

        $no_of_records_per_page = NUM_MAX_REG_PAGE; //total de registros por pagination
        $offset = ($numPage - 1) * $no_of_records_per_page; // desplazamiento conforme a la pagina

        $results_rows_pages = $this->Remision->getTotalPages($no_of_records_per_page, $where_sentence);   //total de páginas de acuerdo a la info de la DB
        $total_pages = $results_rows_pages['total_pages'];

        if ($numPage > $total_pages) {
            $numPage = 1;
            $offset = ($numPage - 1) * $no_of_records_per_page;
        } //seguridad si ocurre un error por url     

        $rows_Remisiones = $this->Remision->getDataCurrentPage($offset, $no_of_records_per_page, $where_sentence);    //se obtiene la información de la página actual

        //guardamos la tabulacion de la información para la vista
        $data['infoTable'] = $this->generarInfoTable($rows_Remisiones, $filtro);
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
                $data['filtroNombre'] = "Peticionarios";
                break;
            case '3':
                $data['filtroNombre'] = "Ubicación de los Hechos";
                break;
            case '4':
                $data['filtroNombre'] = "Elementos Participantes";
                break;
            case '5':
                $data['filtroNombre'] = "Ubicación de la Detención";
                break;
            case '6':
                $data['filtroNombre'] = "Objetos Asegurados";
                break;
            case '7':
                $data['filtroNombre'] = "Armas Aseguradas";
                break;
            case '8':
                $data['filtroNombre'] = "Droga Aseg";
                break;
            case '9':
                $data['filtroNombre'] = "Accesorios";
                break;
            case '10':
                $data['filtroNombre'] = "Contacto det";
                break;
            case '11':
                $data['filtroNombre'] = "Adicción det";
                break;
            case '12':
                $data['filtroNombre'] = "Señas Particulares";
                break;
            case '13':
                $data['filtroNombre'] = "Registros por validar";
                break;
            case '14':
                $data['filtroNombre'] = "Registros validados";
                break;
            case '15':
                $data['filtroNombre'] = "Vehículos Asegurados";
                break;
        }

        $this->view('templates/header', $data);
        $this->view('system/remisiones/remisionView', $data);
        $this->view('templates/footer', $data);
    }

    public function nueva()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[3] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $datos_prim = [
            'escolaridad' => $this->getEscolaridad(),
            'zonas' => $this->getZona(),
            'sectores' => $this->getSector(),
            'estados' => $this->getEstadosMexico(),
        ];

        $data = [
            'titulo'     => 'Sistema de remisiones | Nueva Remisión',
            'extra_css'  => '
                        <link rel="stylesheet" href="' . base_url . 'public/css/system/remisiones/fullview.css">',
            'extra_js'   => '<script src="' . base_url . 'public/js/system/remisiones/nueva.js"></script>
                        <script src="' . base_url . 'public/js/system/remisiones/entrevista.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/validaciones/datosPrincipales.js"></script>' .
                '<script src="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js"></script>'.
                '<link href="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css" rel="stylesheet" />'.
                '<script src="' . base_url . 'public/js/maps/remisiones/nueva_mapbox.js"></script>'.
                '<script src="' . base_url . 'public/js/system/remisiones/lugarOrigenNueva.js"></script>'.
                '<script src="' . base_url . 'public/js/system/remisiones/callesycolonias_nueva.js"></script>',
                //'<script src="' . base_url . 'public/js/maps/remisiones/principal.js"></script>' .
                //'<script src="https://maps.googleapis.com/maps/api/js?key=' . API_KEY . '&callback=initMap&libraries=places" async defer></script>',
            'datos_prim' => $datos_prim
        ];

        $lastFichas = $this->Remision->getLastFichas();
        $data['fichas_select'] = '';
        foreach ($lastFichas as $row) {
            $data['fichas_select'] .= '<option value="' . $row->No_Ficha . '">' . $row->No_Ficha . '</option>';
        }

        $this->view('templates/header', $data);
        $this->view('system/remisiones/nuevaremisionView', $data);
        $this->view('templates/footer', $data);
    }

    public function insertarNuevaRemision()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';

            echo json_encode($data_p);
        } else {
            if (isset($_POST['boton_principales'])) {

                $k = 0;
                if ($_POST['911_principales'] != '')
                    $valid[$k++] = $data_p['Folio911Error']         = $this->FV->validate($_POST,   '911_principales', 'required | numeric');
                $valid[$k++] = $data_p['fechaError']            =   $this->FV->validate($_POST, 'fecha_principales', 'required | date');
                $valid[$k++] = $data_p['horaError']             =   $this->FV->validate($_POST, 'hora_principales', 'required | time');
                $valid[$k++] = $data_p['nombreError']           =   $this->FV->validate($_POST, 'Nombre_principales', 'required');
                $valid[$k++] = $data_p['apellidoPError']        =   $this->FV->validate($_POST, 'appPaterno_principales', 'required');

                if ($_POST['edad_principales'] != '')
                    $valid[$k++] = $data_p['edadError']             =   $this->FV->validate($_POST, 'edad_principales', 'numeric | length[2]');

                $valid[$k++] = $data_p['procedenciaError']      =   $this->FV->validate($_POST, 'procedencia_principales', 'required');

                if ($_POST['CURP_principales'] != '')
                    $valid[$k++] = $data_p['curpError']             =   $this->FV->validate($_POST, 'CURP_principales', 'required | length[18]');

                $municipio = ($_POST['Municipio'] == '') ? 'PUEBLA' : $_POST['Municipio'];
                $_POST['Municipio'] = $municipio;


                if ($_POST['pertenencias_rem'] != '') {
                    $valid[$k++] = $data_p['pertenenciasError']     =   $this->FV->validate($_POST, 'pertenencias_rem', 'max_length[600]');
                }

                if ($_POST['FechaNacimiento_principales'] != '')
                    $valid[$k++] = $data_p['fecha_nacimientoError'] =   $this->FV->validate($_POST, 'FechaNacimiento_principales', 'date');

                if ($_POST['RFC_principales'] != '') {
                    $valid[$k++] = $data_p['rfcError']          =   $this->FV->validate($_POST, 'RFC_principales', 'length[10]');
                }

                if (strlen($_POST['Telefono_principales']) == 10) {
                    if ($_POST['imei_1_principales'] != '')
                        $valid[$k++] = $data_p['imei1Error']    =   $this->FV->validate($_POST, 'imei_1_principales', 'min_length[14] | max_length[16] | numeric');

                    if ($_POST['imei_2_principales'] != '')
                        $valid[$k++] = $data_p['imei2Error']    =   $this->FV->validate($_POST, 'imei_2_principales', 'min_length[14] | max_length[16] | numeric');
                }

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) {
                    $success_2 = $this->Remision->nuevaRemision($_POST);
                    if ($success_2['status']) {
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $this->Remision->historial($user, $ip, 2, $success_2['no_remision']);
                        $data_p['status'] =  true;
                        $data_p['no_remision'] = $success_2['no_remision'];
                        $data_p['no_ficha'] = $success_2['no_ficha'];
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

    public function insertarNarrativas()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[1] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';

            echo json_encode($data_p);
        } else {

            if (isset($_POST['narrativas'])) {

                $n = 0;

                $remision = $_POST['remision'];
                $ficha = $_POST['ficha'];
    
                //$valid[$n++] = $data_p['narrativaPeticionarioError'] = $this->FV->validate($_POST, 'narrativaPeticionario', 'required');
                $valid[$n++] = $data_p['narrativaElementosError'] = $this->FV->validate($_POST, 'narrativaElementos', 'required');
                $valid[$n++] = $data_p['narrativaDetenidoError'] = $this->FV->validate($_POST, 'narrativaDetenido', 'required');
                $valid[$n++] = $data_p['extractoIPHError'] = $this->FV->validate($_POST, 'extractoIPH', 'required');
                // $valid[$n++] = $data_p['cdiFolioJCError'] = $this->FV->validate($_POST, 'cdiFolioJC', 'required');
                // $valid[$n++] = $data_p['observacionesNarrativasError'] = $this->FV->validate($_POST, 'observacionesNarrativas', 'required');

                $path_carpeta = BASE_PATH . "public/files/Remisiones/" . $ficha . "/IPH/" . $remision;
                $path_file = BASE_PATH . "public/files/Remisiones/" . $ficha . "/IPH/" . $remision . "/IPH_" . $remision . ".pdf";

                $name = 'file_iph';

                if (isset($_FILES['file_iph']))
                    $file = true;
                else
                    $file = false;

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) {
                    $success_2 = $this->Remision->narrativas($_POST, $ficha, $remision, $file);
                    if ($success_2['status']) {
                        if (isset($_FILES['file_iph'])) {
                            $result = $this->uploadIphFileRemisiones($name, $_FILES, $ficha, $path_carpeta, $path_file);
                            $data_p['file'] = $result;
                        }
                        $this->Remision->updateGuardarTab($remision, 10);
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $descripcion = 'Remisión: ' . $remision . ' Tab: 10';
                        $this->Remision->historial($user, $ip, 3, $descripcion);
                        $data_p['status'] =  true;
                        $data_p['status_insertion'] =  $success_2;
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


    public function uploadImagePhotoRemisiones($img, $ficha, $carpeta, $ruta)
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[3] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }
        /* ----- ----- ----- Existe la carpeta ----- ----- ----- */
        if (!file_exists($carpeta))
            mkdir($carpeta, 0777, true);

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        file_put_contents($ruta, $image_base64);

        return true;
    }

    public function uploadImageFileRemisiones($name, $file, $ficha, $carpeta, $fileName)
    {
        /*$allowed_mime_type_arr = array('jpeg','png','jpg','PNG','JPEG','JPG');
        $arrayAux = explode('.', $file[$name]['name']);
        $mime = end($arrayAux);
        
        if((isset($file[$name]['name'])) && ($file[$name]['name']!="")){
	        if(in_array($mime, $allowed_mime_type_arr)){
	            $band = true;
	        }else{
	            $band = false;
	        }
	    }else{
	        $band = false;
        }

        if(!file_exists($carpeta))
            mkdir($carpeta, 0777, true);
            
        if($band){
            move_uploaded_file($file[$name]['tmp_name'],$carpeta.$fileName);
        }

        return $band;*/
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
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            default:
                $image = imagecreatefromjpeg($source);
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
            $image = $this->Remision->getFotosHuellas($_POST);
            if ($image['status']) {
                $pathFile = base_url . 'public/files/Remisiones/' . $_POST['ficha'] . '/FotosHuellas/' . $_POST['remision'] . '/' . $image['data']->Path_Imagen;
                $imgInfo = getimagesize($pathFile);
                $imagenUrl = $pathFile;
            }
        }

        $path = BASE_PATH . 'public/files/Remisiones/' . $_POST['ficha'] . '/FotosHuellas/' . $_POST['remision'] . '/';
        $mime = $imgInfo['mime'];

        $date = date("Ymdhis");
        $perfil = explode('_', $_POST['perfil']);
        $type = explode("/", $mime);
        $name = $_POST['perfil'] . "." . $type[1] . "?v=" . $date;

        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($imagenUrl);
                break;
            case 'image/png':
                $image = imagecreatefrompng($imagenUrl);
                break;
            default:
                $image = imagecreatefromjpeg($imagenUrl);
        }

        $image = imagerotate($image, 90, 0);

        imagejpeg($image, $path . $_POST['perfil'] . ".jpeg");

        $success = $this->Remision->updateNameFile($perfil[0], $perfil[1], $name, $_POST['remision']);
        if ($success['status']) {
            $data_p['status'] = true;
            $data_p['nameFile'] = $name;
        } else {
            $data_p['status'] = false;
            $data_p['error_message'] = $success['error_message'];
        }


        echo json_encode($data_p);
    }

    public function rotateImageObj()
    {
        $imageName = $type = explode("?", $_POST['image']);
        $pathFile = BASE_PATH . 'public/files/Remisiones/' . $_POST['ficha'] . '/ObjRecuperados/'.$imageName[0];
        $imgInfo = getimagesize($pathFile);
        $imagenUrl = $pathFile;

        $path = BASE_PATH . 'public/files/Remisiones/' . $_POST['ficha'] . '/ObjRecuperados/';
        $mime = $imgInfo['mime'];

        $date = date("Ymdhis");
        $type = explode("/", $mime);
        $name = $_POST['ficha'].'_obj' . "." . $type[1] . "?v=" . $date;

        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($imagenUrl);
                break;
            case 'image/png':
                $image = imagecreatefrompng($imagenUrl);
                break;
            default:
                $image = imagecreatefromjpeg($imagenUrl);
        }

        $image = imagerotate($image, 90, 0);

        imagejpeg($image, $path . $_POST['ficha'].'_obj'. '.' . $type[1]);

        $success = $this->Remision->updateImgObjRecuperados($_POST['ficha'], $name);
        if ($success['status']) {
            $data_p['status'] = true;
            $data_p['nameFile'] = $name;
        } else {
            $data_p['status'] = false;
            $data_p['error_message'] = $success['error_message'];
        }

        echo json_encode($data_p);
    }

    public function uploadIphFileRemisiones($name, $file, $ficha, $carpeta, $ruta)
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

    public function getCatalogos($catalogo)
    {
        $data = $this->Catalogo->getCatalogforDropdown($catalogo);
        return $data;
    }

    public function getTipoViolenacia()
    {
        $data = $this->Catalogo->getSimpleCatalogo("Tipo_Violencia", "catalogo_tipo_violencia");
        return $data;
    }

    public function getEscolaridad()
    {
        $data = $this->Catalogo->getSimpleCatalogo("Escolaridad", "catalogo_escolaridad");
        return $data;
    }

    public function getZona()
    {
        $data = $this->Catalogo->getZonaSector("POLICIA");
        return $data;
    }

    public function getVector()
    {
        $data =  $this->Catalogo->getVector($_POST['valor']);
        echo json_encode($data);
    }

    public function getSector()
    {
        $data = $this->Catalogo->getZonaSector("TRANSITO");
        return $data;
    }

    public function getFormaDetencion()
    {
        $data = $this->Catalogo->getSimpleCatalogo("Forma_Detencion", "catalogo_forma_detencion");
        return $data;
    }

    public function getTipoRelacion()
    {
        $data = $this->Catalogo->getSimpleCatalogo("Parentezco", "catalogo_parentezco");
        return $data;
    }

    public function getModalidadDetencion()
    {
        $data = $this->Catalogo->getModalidadDetencion($_POST);
        echo json_encode($data);
    }

    public function getDelito()
    {
        $info = $_POST['instancia'];
        $data = "";

        switch ($info) {
            case 'M.P. FUERO COMÚN':
                $data = $this->Remision->getDetitosByCadena("MINISTERIO PÚBLICO");
                echo json_encode($data);
                break;

            case 'M.P. FEDERAL':
                $data = $this->Remision->getDetitosByCadena("MINISTERIO PÚBLICO FEDERAL");
                echo json_encode($data);
                break;

            case 'ADOLESCENTES I.':
                $data = $this->Remision->getDetitosByCadena("MINISTERIO PÚBLICO PARA ADOLESCENTES");
                echo json_encode($data);
                break;

            case 'MIGRACION':
                $data = $this->Remision->getDetitosByCadena("INSTITUTO MEXICANO DE MIGRACIÓN (IMM)");
                echo json_encode($data);
                break;

            case 'JUEZ DE JUSTICIA CÍVICA':
                $data = $this->Remision->getDetitosByCadena("JUEZ CALIFICADOR");
                echo json_encode($data);
                break;
            default:
                echo json_encode(array());
        }
    }

    /* ----- ----- ----- Elementos participantes ----- ----- ----- */
    public function getGrupos()
    {
        $data = $this->Catalogo->getSimpleCatalogo("Valor_Grupo", "catalogo_grupos");
        return $data;
    }
    /* ----- ----- ----- Señas particulares ----- ----- ----- */
    public function getTatuajes()
    {
        $data = $this->Catalogo->getSimpleCatalogo("Tipo_Tatuaje", "catalogo_tatuaje");
        return $data;
    }

    public function getTipoVestimenta()
    {
        $data = $this->Catalogo->getSimpleCatalogo("Tipo_Vestimenta", "catalogo_tipo_vestimenta");
        return $data;
    }

    public function getTipoAccesorio()
    {
        $data = $this->Catalogo->getSimpleCatalogo("Tipo_Accesorio", "catalogo_tipo_accesorios");
        return $data;
    }

    /* ----- ----- ----- Obj recuperados y entrevista ----- ----- ----- */
    public function getTipoAdiccion()
    {
        $data = $this->Catalogo->getSimpleCatalogo("Nombre_Adiccion", "catalogo_adicciones");
        return $data;
    }

    public function getTipoArmas()
    {
        $data = $this->Catalogo->getSimpleCatalogo("Tipo_Arma", "catalogo_tipos_armas");
        return $data;
    }

    public function getUnidadDroga()
    {
        $data = $this->Catalogo->getSimpleCatalogo("Tipo_Medida", "catalogo_medidas_droga");
        return $data;
    }

    /* ----- ----- ----- Entrevista del detenido ----- ----- ----- */

    public function getTipoInstitucion()
    {
        $data = $this->Catalogo->getSimpleCatalogo("Tipo_Institucion", "catalogo_institucion_seguridad");
        return $data;
    }


    //-----------------Funcion para editar remision-----------------------------------
    public function editarRemision()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[1] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $datos_prim = [
            'escolaridad' => $this->getEscolaridad(),
            'zonas' => $this->getZona(),
            'sectores' => $this->getSector(),
            'estados' => $this->getEstadosMexico(),
        ];

        $ubi_detencion = [
            'tipo_violencia' => $this->getTipoViolenacia(),
            'forma_detencion' => $this->getFormaDetencion()
        ];

        $datos_sec = [
            'tipo_relacion' => $this->getTipoRelacion(),
            'complexion' => $this->getCatalogos("COMPLEXIÓN"),
            'color_piel' => $this->getCatalogos("COLOR PIEL"),
            'forma_cara' => $this->getCatalogos("FORMA CARA"),
            'pomulos' => $this->getCatalogos("PÓMULOS"),
            'cabello' => $this->getCatalogos("CABELLO"),
            'color_cabello' => $this->getCatalogos("COLOR CABELLO"),
            'tam_cabello' => $this->getCatalogos("TAM CABELLO"),
            'forma_cabello' => $this->getCatalogos("FORMA CABELLO"),
            'frente' => $this->getCatalogos("FRENTE"),
            'cejas' => $this->getCatalogos("CEJAS"),
            'tipo_cejas' => $this->getCatalogos("TIPO CEJAS"),
            'color_ojos' => $this->getCatalogos("COLOR OJOS"),
            'tam_ojos' => $this->getCatalogos("TAM OJOS"),
            'forma_ojos' => $this->getCatalogos("FORMA OJOS"),
            'nariz' => $this->getCatalogos("NARIZ"),
            'tam_boca' => $this->getCatalogos("TAM BOCA"),
            'labios' => $this->getCatalogos("LABIOS"),
            'menton' =>  $this->getCatalogos("MENTÓN"),
            'tam_orejas' => $this->getCatalogos("TAM OREJAS"),
            'lobulos' => $this->getCatalogos("LÓBULOS"),
            'barba' => $this->getCatalogos("BARBA"),
            'tam_barba' => $this->getCatalogos("TAM BARBA"),
            'color_barba' => $this->getCatalogos("COLOR BARBA"),
            'bigote' => $this->getCatalogos("BIGOTE"),
            'tam_bigote' => $this->getCatalogos("TAM BIGOTE"),
            'color_bigote' => $this->getCatalogos("COLOR BARBA"),
        ];

        $elementosParticipantes = [
            'grupos' => $this->getGrupos()
        ];

        $objRecuperados = [
            'adicciones' => $this->getTipoAdiccion(),
            'armas' => $this->getTipoArmas(),
            'unidades' => $this->getUnidadDroga()
        ];

        $senasParticulares = [
            'tatuajes' => $this->getTatuajes(),
            'vestimenta' => $this->getTipoVestimenta(),
            'accesorios' => $this->getTipoAccesorio()
        ];

        $entrevistaDetenido = [
            'adicciones' => $this->getTipoAdiccion(),
            'instituciones' => $this->getTipoInstitucion()
        ];



        //se añadio el extra_js contactosDetenido para manejar por separado las funcionalidades de la tabla
        $data = [
            'titulo'                => 'Sistema de remisiones | Editar Remisión',
            'titulo_1'              => 'Editar',
            'extra_css'             => '<link rel="stylesheet" href="' . base_url . 'public/css/system/remisiones/fullview.css">
                                        <link rel="stylesheet" href="' . base_url . 'public/css/system/remisiones/senas.css">
                                        <link rel="stylesheet" href="' . base_url . 'public/css/system/remisiones/capturaFotos.css">
                                        <link rel="stylesheet" href="' . base_url . 'public/css/libraries/dropzone.css">
                                        

                                        <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">',

            'extra_js'              => '<script src="' . base_url . 'public/js/system/remisiones/senas.js"></script>
                                        <script src="' . base_url . 'public/js/remisiones/nueva/principal.js"></script>
                                        <script src="' . base_url . 'public/js/system/remisiones/nueva.js"></script>
                                        <script src="' . base_url . 'public/js/system/remisiones/capturaFotos.js"></script>
                                        <script src="' . base_url . 'public/js/system/remisiones/elementos.js"></script>
                                        <script src="' . base_url . 'public/js/system/remisiones/objetosRecuperados.js"></script>
                                        <script src="' . base_url . 'public/js/system/remisiones/contactosDetenido.js"></script>
                                        <script src="' . base_url . 'public/js/system/remisiones/entrevista.js"></script>' .
                //'<script src="' . base_url . 'public/js/maps/remisiones/fullView.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/cargarFalta_UD.js"></script>' .
                //'<script src="https://maps.googleapis.com/maps/api/js?key=' . API_KEY . '&callback=initMap&libraries=places" async defer></script>' .
                '<script src="' . base_url . 'public/js/libraries/dropzone.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/getInformation/datosPrincipales.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/getInformation/validarRemision.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/getInformation/peticionario.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/getInformation/ubicacion_h.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/getInformation/ubicacion_d.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/getInformation/medifiliacion.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/getInformation/elementosParticipantes.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/getInformation/objRecuperados.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/getInformation/capturafyh.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/getInformation/senasParticulares.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/getInformation/entrevistaDetenido.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/getInformation/narrativas.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/CapturaFaltaDelito.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/CapturarVector.js"></script>'.
                '<script src="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js"></script>'.
                '<link href="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css" rel="stylesheet" />'.
                '<script src="' . base_url . 'public/js/maps/remisiones/principal_mapbox.js"></script>'.
                '<script src="' . base_url . 'public/js/system/remisiones/lugarOrigen.js"></script>'.
                '<script src="' . base_url . 'public/js/system/remisiones/callesycolonias.js"></script>',



            'ubi_detencion'         =>  $ubi_detencion,
            'datos_sec'             =>  $datos_sec,
            'datos_prim'            =>  $datos_prim,
            'senasParticulares'     =>  $senasParticulares,
            'objRecuperados'        =>  $objRecuperados,
            'elementos'             =>  $elementosParticipantes,
            'entrevistaDetenido'    =>  $entrevistaDetenido,
        ];

        $lastFichas = $this->Remision->getLastFichas();
        $data['fichas_select'] = '';
        foreach ($lastFichas as $row) {
            $data['fichas_select'] .= '<option value="' . $row->No_Ficha . '">' . $row->No_Ficha . '</option>';
        }

        $this->view('templates/header', $data);
        $this->view('system/remisiones/nuevaremisionFullView', $data);
        $this->view('templates/footer', $data);
    }

    public function verRemision()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $user = $_SESSION['userdata']->Id_Usuario;
        $ip = $this->obtenerIp();
        $descripcion = 'Remisión: ' . $_GET['no_remision'];
        $this->Remision->historial($user, $ip, 5, $descripcion);

        $data = [
            'titulo'                => 'Sistema de remisiones | Ver Remisión',
            'titulo_1'              => 'Ver',
            'extra_css'             => '<link rel="stylesheet" href="' . base_url . 'public/css/remisiones/style.css">
                                        <link rel="stylesheet" href="' . base_url . 'public/css/system/remisiones/fullview.css">
                                        <link rel="stylesheet" href="' . base_url . 'public/css/system/remisiones/senas.css">
                                        <link rel="stylesheet" href="' . base_url . 'public/css/system/remisiones/capturaFotos.css">',
            'extra_js'              => '<script src="' . base_url . 'public/js/system/remisiones/senas.js"></script>
                                        <script src="' . base_url . 'public/js/remisiones/nueva/principal.js"></script>
                                        <script src="' . base_url . 'public/js/system/remisiones/nueva.js"></script>
                                        <script src="' . base_url . 'public/js/system/remisiones/capturaFotos.js"></script>
                                        <script src="' . base_url . 'public/js/system/remisiones/elementos.js"></script>
                                        <script src="' . base_url . 'public/js/system/remisiones/objetosRecuperados.js"></script>
                                        <script src="' . base_url . 'public/js/system/remisiones/entrevista.js"></script>' .
                //'<script src="' . base_url . 'public/js/maps/remisiones/fullView.js"></script>' .
                //'<script src="' . base_url . 'public/js/system/remisiones/cargarFalta_UD.js"></script>' .
                //'<script src="https://maps.googleapis.com/maps/api/js?key=' . API_KEY . '&callback=initMap&libraries=places" async defer></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/readOnly/all.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/readOnly/elementosParticipantes.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/readOnly/objRecuperados.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/readOnly/capturafyh.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/readOnly/senasParticulares.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/readOnly/entrevistaDetenido.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/readOnly/narrativas.js"></script>' .
                '<script src="' . base_url . 'public/js/system/remisiones/readOnly/validarRemision.js"></script>'

        ];
        $this->view('templates/header', $data);
        $this->view('system/remisiones/nuevaremisionFullView-readOnly', $data);
        $this->view('templates/footer', $data);
    }

    public function generarFicha()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        if (isset($_GET['no_remision']) && isset($_GET['no_ficha'])) {
            $no_remision = $_GET['no_remision'];
            $no_ficha    = $_GET['no_ficha'];
            /* Se cambio getMediaFiliacion por getContactoDetenido en la asignacion
            a contacto*/
            $data = [
                'principales'      => $this->Remision->getPrincipales($no_remision),
                'fotosHuellas'     => $this->Remision->getAllFotosHuellas($no_remision),
                'ubicacionHechos'  => $this->Remision->getUbicacionH($no_ficha, $no_remision),
                'entrevista'       => $this->Remision->getEntrevistaDetenido($no_remision),
                'contacto'         => $this->Remision->getContactoDetenido($no_remision),
                'peticionario'     => $this->Remision->getPeticionario($no_ficha),
                'objetos'          => $this->Remision->getObjetosRecuperados($no_remision, $no_ficha),
                'narrativas'       => $this->Remision->getNarrativas($no_remision, $no_ficha),
                'observacion'      => $this->Remision->getObservacion($no_remision),
                'senas'            => $this->Remision->getSenasParticulares($no_remision),
                'detencion'        => $this->Remision->getUbicacionD($no_remision),
                'remisionUser'     => $this->Remision->getUserRemision($no_remision)
            ];
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $this->view('system/remisiones/fichaView', $data);
    }


    /*-----------------------FUNCIONES PARA FILTRADO Y BÚSQUEDA-----------------------*/

    //función para generar la paginación dinámica
    public function generarLinks($numPage, $total_pages, $extra_cad = "", $filtro = 1)
    {
        //$extra_cad sirve para determinar la paginacion conforme a si se realizó una busqueda
        //Creación de links para el pagination
        $links = "";

        //FLECHA IZQ (PREV PAGINATION)
        if ($numPage > 1) {
            $links .= '<li class="page-item">
                            <a class="page-link" href=" ' . base_url . 'Remisiones/index/?numPage=1' . $extra_cad . '&filtro=' . $filtro . ' " data-toggle="tooltip" data-placement="top" title="Primera página">
                                <i class="material-icons">first_page</i>
                            </a>
                        </li>';
            $links .= '<li class="page-item">
                            <a class="page-link" href=" ' . base_url . 'Remisiones/index/?numPage=' . ($numPage - 1) . $extra_cad . '&filtro=' . $filtro . ' " data-toggle="tooltip" data-placement="top" title="Página anterior">
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
                                <a class="page-link" href=" ' . base_url . 'Remisiones/index/?numPage=' . ($ind) . $extra_cad . '&filtro=' . $filtro . ' ">
                                    ' . ($ind) . '
                                </a>
                            </li>';
            }
        }

        //FLECHA DERECHA (NEXT PAGINATION)
        if ($numPage < $total_pages) {

            $links .= '<li class="page-item">
                            <a class="page-link" href=" ' . base_url . 'Remisiones/index/?numPage=' . ($numPage + 1) . $extra_cad . '&filtro=' . $filtro . ' " data-toggle="tooltip" data-placement="top" title="Siguiente página">
                            <i class="material-icons">navigate_next</i>
                            </a>
                        </li>';
            $links .= '<li class="page-item">
                            <a class="page-link" href=" ' . base_url . 'Remisiones/index/?numPage=' . ($total_pages) . $extra_cad . '&filtro=' . $filtro . ' " data-toggle="tooltip" data-placement="top" title="Última página">
                            <i class="material-icons">last_page</i>
                            </a>
                        </li>';
        }

        return $links;
    }

    //función para generar la información de la tabla de forma dinámica
    public function generarInfoTable($rows, $filtro = 1)
    {
        $permisos_Editar = ($_SESSION['userdata']->Remisiones[1] == '1') ? 'd-flex justify-content-center' : 'mi_hide';
        $permisos_Ver = ($_SESSION['userdata']->Remisiones[2] == '1') ? 'd-flex justify-content-center' : 'mi_hide';
        /*Se modifico esta condicion para restringir la generacion de la ficha a usuarios que no tengan
        permiso para ver/editar narrativas y tabs de narrativa*/ 
    /*    if($_SESSION['userdata']->Remisiones[2] == '1' & $_SESSION['userdata']->editar_Narrativas[3] == '1' & $_SESSION['userdata']->editar_Narrativas[2] == '1' &
        $_SESSION['userdata']->editar_Narrativas[1] == '1'& $_SESSION['userdata']->editar_Narrativas[0] == '1' & $_SESSION['userdata']->ver_Narrativas[3] == '1'& 
        $_SESSION['userdata']->ver_Narrativas[2] == '1' & $_SESSION['userdata']->ver_Narrativas[1] == '1' & $_SESSION['userdata']->ver_Narrativas[0] == '1'& 
        $_SESSION['userdata']->Editar_remisiones[0] == '1' & $_SESSION['userdata']->Ver_remisiones[0] == '1'){*/
        if(($_SESSION['userdata']->Remisiones[2] == '1' && (($_SESSION['userdata']->Editar_remisiones[10] == '1' && $_SESSION['userdata']->Editar_remisiones[9] == '1' &&
         $_SESSION['userdata']->Editar_remisiones[8] == '1' && $_SESSION['userdata']->Editar_remisiones[7] == '1' && 
         $_SESSION['userdata']->Editar_remisiones[6] == '1' && $_SESSION['userdata']->Editar_remisiones[5] == '1' && 
         $_SESSION['userdata']->Editar_remisiones[4] == '1' && $_SESSION['userdata']->Editar_remisiones[2] == '1' && 
         $_SESSION['userdata']->Editar_remisiones[2] == '1' && $_SESSION['userdata']->Editar_remisiones[1] == '1' && 
         $_SESSION['userdata']->Editar_remisiones[0] == '1') || ($_SESSION['userdata']->Ver_remisiones[10] == '1' && $_SESSION['userdata']->Ver_remisiones[9] == '1' &&
         $_SESSION['userdata']->Ver_remisiones[8] == '1' && $_SESSION['userdata']->Ver_remisiones[7] == '1' && 
         $_SESSION['userdata']->Ver_remisiones[6] == '1' && $_SESSION['userdata']->Ver_remisiones[5] == '1' && 
         $_SESSION['userdata']->Ver_remisiones[4] == '1' && $_SESSION['userdata']->Ver_remisiones[2] == '1' && 
         $_SESSION['userdata']->Ver_remisiones[2] == '1' && $_SESSION['userdata']->Ver_remisiones[1] == '1' && 
         $_SESSION['userdata']->Ver_remisiones[0] == '1')))|| $_SESSION['userdata']->Modo_Admin==1){ 
            $permisos_FormatoFicha ='d-flex justify-content-center';
        }
        else{
            $permisos_FormatoFicha ='mi_hide';
        }
        $permisos_FormatoFicha2 = ($_SESSION['userdata']->Remisiones[2] == '1') ? 'd-flex justify-content-center' : 'mi_hide';
        //se genera la tabulacion de la informacion por backend
        $infoTable['header'] = "";
        $infoTable['body'] = "";


        switch ($filtro) {
            case '1': //general
                $infoTable['header'] .= '
                        <th class="column1">Ficha</th>
                        <th class="column2">Núm. Remisión</th>
                        <th class="column3">Fecha y Hora</th>
                        <th class="column4">Detenido</th>
                        <th class="column5">Ubicación Hechos</th>
                        <th class="column6">Zona</th>
                        <th class="column7">Vector</th>
                        <th class="column8">Registró</th>
                        <th class="column9">Remitido a</th>
                        <th class="column10">Folio 911</th>
                    ';
                foreach ($rows as $row) {
                    $infoTable['body'] .= '<tr id="tr' . $row->No_Remision . '">';
                    $infoTable['body'] .= '  <td class="column1">' . $row->Ficha . '</td>
                                            <td class="column2">' . $row->No_Remision . '</td>
                                            <td class="column3">' . $row->Fecha_Hora . '</td>
                                            <td class="column4">' . mb_strtoupper($row->Nombre_Detenido) . '</td>
                                            <td class="column5">' . mb_strtoupper($row->Ubicacion_Hechos) . '</td>
                                            <td class="column6">' . mb_strtoupper($row->Zona) . '</td>
                                            <td class="column7">' . mb_strtoupper($row->Vector) . '</td>
                                            <td class="column8">' . mb_strtoupper($row->Nombre_Usuario) . '</td>
                                            <td class="column9">' . mb_strtoupper($row->Instancia) . '</td>
                                            <td class="column10">' . mb_strtoupper($row->Folio_911) . '</td>

                        ';
                    //se comprueba si el registro ya tiene un dictamen previamente llenado o si no existe genera un link para nuevo
                    if ($row->Fecha_Hora != '') {
                        if ($row->Validacion_Tab_Bit != '11111111111' || $_SESSION['userdata']->Modo_Admin == '1' || $_SESSION['userdata']->Nivel_User == '1') { //validacion de tabs validados completaente y/o permisos de validacion o modo admin
                            $infoTable['body'] .= '<td class="d-flex">
                                                    <a class="myLinks mb-3' . ' ' . $permisos_Editar . '" data-toggle="tooltip" data-placement="right" title="Editar registro" href="' . base_url . 'Remisiones/editarRemision/?no_remision=' . $row->No_Remision . '&no_ficha=' . $row->Ficha . '">
                                                        <i class="material-icons">edit</i>
                                                    </a>';
                        } else {
                            $infoTable['body'] .= '<td class="d-flex">';
                        }
                        $infoTable['body'] .= '
                                                <a class="myLinks mt-3' . ' ' . $permisos_Ver . '" data-toggle="tooltip" data-placement="right" title="Ver registro" href="' . base_url . 'Remisiones/verRemision/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha2 . '" data-toggle="tooltip" data-placement="right" title="Generar formato remisión" href="' . base_url . 'Remisiones/generarIPH1/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">list_alt</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha . '" data-toggle="tooltip" data-placement="right" title="Generar ficha" href="' . base_url . 'Remisiones/generarFicha/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">file_present</i>
                                                </a>
                                            </td>';
                    }


                    $infoTable['body'] .= '</tr>';
                }
                break;
            case '2': //peticionarios
                $infoTable['header'] .= '
                        <th class="column1">Ficha</th>
                        <th class="column2">Núm. Remisión</th>
                        <th class="column3">Fecha y Hora</th>
                        <th class="column4">Peticionario</th>
                        <th class="column5">Domicilio Peticionario</th>
                        <th class="column6">Instancia Detenido</th>
                        <th class="column7">Folio 911</th>
                    ';
                foreach ($rows as $row) {
                    $infoTable['body'] .= '<tr id="tr' . $row->No_Remision . '">';
                    $infoTable['body'] .= '  <td class="column1">' . $row->Ficha . '</td>
                                            <td class="column2">' . $row->No_Remision . '</td>
                                            <td class="column3">' . $row->Fecha_Hora . '</td>
                                            <td class="column4">' . mb_strtoupper($row->Nombre_Peticionario) . '</td>
                                            <td class="column5">' . mb_strtoupper($row->Domicilio_Peticionario) . '</td>
                                            <td class="column6">' . mb_strtoupper($row->Instancia) . '</td>
                                            <td class="column7">' . mb_strtoupper($row->Folio_911) . '</td>

                        ';
                    //se comprueba si el registro ya tiene un dictamen previamente llenado o si no existe genera un link para nuevo
                    if ($row->Fecha_Hora != '') {
                        if ($row->Validacion_Tab_Bit != '11111111111' || $_SESSION['userdata']->Modo_Admin == '1' || $_SESSION['userdata']->Nivel_User == '1') { //validacion de tabs validados completaente y/o permisos de validacion o modo admin
                            $infoTable['body'] .= '<td class="d-flex">
                                                    <a class="myLinks mb-3' . ' ' . $permisos_Editar . '" data-toggle="tooltip" data-placement="right" title="Editar registro" href="' . base_url . 'Remisiones/editarRemision/?no_remision=' . $row->No_Remision . '&no_ficha=' . $row->Ficha . '">
                                                        <i class="material-icons">edit</i>
                                                    </a>';
                        } else {
                            $infoTable['body'] .= '<td class="d-flex">';
                        }
                        $infoTable['body'] .= '
                                                <a class="myLinks mt-3' . ' ' . $permisos_Ver . '" data-toggle="tooltip" data-placement="right" title="Ver registro" href="' . base_url . 'Remisiones/verRemision/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha2 . '" data-toggle="tooltip" data-placement="right" title="Generar formato remisión" href="' . base_url . 'Remisiones/generarIPH1/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">list_alt</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha . '" data-toggle="tooltip" data-placement="right" title="Generar ficha" href="' . base_url . 'Remisiones/generarFicha/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">file_present</i>
                                                </a>
                                            </td>';
                    }


                    $infoTable['body'] .= '</tr>';
                }
                break;
            case '3': //ubicación de los hechos
                $infoTable['header'] .= '
                        <th class="column1">Ficha</th>
                        <th class="column2">Núm. Remisión</th>
                        <th class="column3">Fecha y Hora</th>
                        <th class="column4">Ubicación Hechos</th>
                        <th class="column5">Instancia Detenido</th>
                        <th class="column6">Folio 911</th>
                    ';
                foreach ($rows as $row) {
                    $infoTable['body'] .= '<tr id="tr' . $row->No_Remision . '">';
                    $infoTable['body'] .= '  <td class="column1">' . $row->Ficha . '</td>
                                            <td class="column2">' . $row->No_Remision . '</td>
                                            <td class="column3">' . $row->Fecha_Hora . '</td>
                                            <td class="column4">' . mb_strtoupper($row->Ubicacion_Hechos) . '</td>
                                            <td class="column5">' . mb_strtoupper($row->Instancia) . '</td>
                                            <td class="column6">' . mb_strtoupper($row->Folio_911) . '</td>

                        ';
                    //se comprueba si el registro ya tiene un dictamen previamente llenado o si no existe genera un link para nuevo
                    if ($row->Fecha_Hora != '') {
                        if ($row->Validacion_Tab_Bit != '11111111111' || $_SESSION['userdata']->Modo_Admin == '1' || $_SESSION['userdata']->Nivel_User == '1') { //validacion de tabs validados completaente y/o permisos de validacion o modo admin
                            $infoTable['body'] .= '<td class="d-flex">
                                                    <a class="myLinks mb-3' . ' ' . $permisos_Editar . '" data-toggle="tooltip" data-placement="right" title="Editar registro" href="' . base_url . 'Remisiones/editarRemision/?no_remision=' . $row->No_Remision . '&no_ficha=' . $row->Ficha . '">
                                                        <i class="material-icons">edit</i>
                                                    </a>';
                        } else {
                            $infoTable['body'] .= '<td class="d-flex">';
                        }
                        $infoTable['body'] .= '
                                                <a class="myLinks mt-3' . ' ' . $permisos_Ver . '" data-toggle="tooltip" data-placement="right" title="Ver registro" href="' . base_url . 'Remisiones/verRemision/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha2 . '" data-toggle="tooltip" data-placement="right" title="Generar formato remisión" href="' . base_url . 'Remisiones/generarIPH1/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">list_alt</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha . '" data-toggle="tooltip" data-placement="right" title="Generar ficha" href="' . base_url . 'Remisiones/generarFicha/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">file_present</i>
                                                </a>
                                            </td>';
                    }


                    $infoTable['body'] .= '</tr>';
                }
                break;
            case '4': //elementos participantes
                $infoTable['header'] .= '
                        <th class="column1">Ficha</th>
                        <th class="column2">Núm. Remisión</th>
                        <th class="column3">Fecha y Hora</th>
                        <th class="column4">Detenido</th>
                        <th class="column5">Elemento</th>
                        <th class="column6">Cargo</th>
                        <th class="column7">Placa</th>
                        <th class="column8">Unidad</th>
                        <th class="column9">Llamado</th>
                    ';
                foreach ($rows as $row) {
                    $auxllamado = ($row->Tipo_Llamado == '0') ? "En apoyo" : "Primer respondiente";
                    $infoTable['body'] .= '<tr id="tr' . $row->No_Remision . '">';
                    $infoTable['body'] .= '  <td class="column1">' . $row->Ficha . '</td>
                                            <td class="column2">' . $row->No_Remision . '</td>
                                            <td class="column3">' . $row->Fecha_Hora . '</td>
                                            <td class="column4">' . mb_strtoupper($row->Nombre_Detenido) . '</td>
                                            <td class="column5">' . mb_strtoupper($row->Nombre_Elemento) . '</td>
                                            <td class="column6">' . mb_strtoupper($row->Cargo) . '</td>
                                            <td class="column7">' . mb_strtoupper($row->Placa) . '</td>
                                            <td class="column8">' . mb_strtoupper($row->No_Unidad) . '</td>
                                            <td class="column9">' . $auxllamado . '</td>

                        ';
                    //se comprueba si el registro ya tiene un dictamen previamente llenado o si no existe genera un link para nuevo
                    if ($row->Fecha_Hora != '') {
                        if ($row->Validacion_Tab_Bit != '11111111111' || $_SESSION['userdata']->Modo_Admin == '1' || $_SESSION['userdata']->Nivel_User == '1') { //validacion de tabs validados completaente y/o permisos de validacion o modo admin
                            $infoTable['body'] .= '<td class="d-flex">
                                                    <a class="myLinks mb-3' . ' ' . $permisos_Editar . '" data-toggle="tooltip" data-placement="right" title="Editar registro" href="' . base_url . 'Remisiones/editarRemision/?no_remision=' . $row->No_Remision . '&no_ficha=' . $row->Ficha . '">
                                                        <i class="material-icons">edit</i>
                                                    </a>';
                        } else {
                            $infoTable['body'] .= '<td class="d-flex">';
                        }
                        $infoTable['body'] .= '
                                                <a class="myLinks mt-3' . ' ' . $permisos_Ver . '" data-toggle="tooltip" data-placement="right" title="Ver registro" href="' . base_url . 'Remisiones/verRemision/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha2 . '" data-toggle="tooltip" data-placement="right" title="Generar formato remisión" href="' . base_url . 'Remisiones/generarIPH1/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">list_alt</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha . '" data-toggle="tooltip" data-placement="right" title="Generar ficha" href="' . base_url . 'Remisiones/generarFicha/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">file_present</i>
                                                </a>
                                            </td>';
                    }


                    $infoTable['body'] .= '</tr>';
                }
                break;
            case '5': //ubicación Detención
                $infoTable['header'] .= '
                        <th class="column1">Ficha</th>
                        <th class="column2">Núm. Remisión</th>
                        <th class="column3">Fecha y Hora</th>
                        <th class="column4">Detenido</th>
                        <th class="column5">Domicilio Detenido</th>
                        <th class="column6">Ubicación Detención</th>
                    ';
                foreach ($rows as $row) {
                    $infoTable['body'] .= '<tr id="tr' . $row->No_Remision . '">';
                    $infoTable['body'] .= '  <td class="column1">' . $row->Ficha . '</td>
                                            <td class="column2">' . $row->No_Remision . '</td>
                                            <td class="column3">' . $row->Fecha_Hora . '</td>
                                            <td class="column4">' . mb_strtoupper($row->Nombre_Detenido) . '</td>
                                            <td class="column5">' . mb_strtoupper($row->Domicilio_Detenido) . '</td>
                                            <td class="column6">' . mb_strtoupper($row->Ubicacion_Detencion) . '</td>

                        ';
                    //se comprueba si el registro ya tiene un dictamen previamente llenado o si no existe genera un link para nuevo
                    if ($row->Fecha_Hora != '') {
                        if ($row->Validacion_Tab_Bit != '11111111111' || $_SESSION['userdata']->Modo_Admin == '1' || $_SESSION['userdata']->Nivel_User == '1') { //validacion de tabs validados completaente y/o permisos de validacion o modo admin
                            $infoTable['body'] .= '<td class="d-flex">
                                                    <a class="myLinks mb-3' . ' ' . $permisos_Editar . '" data-toggle="tooltip" data-placement="right" title="Editar registro" href="' . base_url . 'Remisiones/editarRemision/?no_remision=' . $row->No_Remision . '&no_ficha=' . $row->Ficha . '">
                                                        <i class="material-icons">edit</i>
                                                    </a>';
                        } else {
                            $infoTable['body'] .= '<td class="d-flex">';
                        }
                        $infoTable['body'] .= '
                                                <a class="myLinks mt-3' . ' ' . $permisos_Ver . '" data-toggle="tooltip" data-placement="right" title="Ver registro" href="' . base_url . 'Remisiones/verRemision/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha2 . '" data-toggle="tooltip" data-placement="right" title="Generar formato remisión" href="' . base_url . 'Remisiones/generarIPH1/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">list_alt</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha . '" data-toggle="tooltip" data-placement="right" title="Generar ficha" href="' . base_url . 'Remisiones/generarFicha/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">file_present</i>
                                                </a>
                                            </td>';
                    }


                    $infoTable['body'] .= '</tr>';
                }
                break;
            case '6': //Objetos asegurados
                $infoTable['header'] .= '
                        <th class="column1">Ficha</th>
                        <th class="column2">Núm. Remisión</th>
                        <th class="column3">Fecha y Hora</th>
                        <th class="column4">Detenido</th>
                        <th class="column5">Objeto</th>
                        <th class="column6">Cantidad</th>
                        
                    ';
                foreach ($rows as $row) {
                    $infoTable['body'] .= '<tr id="tr' . $row->No_Remision . '">';
                    $infoTable['body'] .= '  <td class="column1">' . $row->Ficha . '</td>
                                            <td class="column2">' . $row->No_Remision . '</td>
                                            <td class="column3">' . $row->Fecha_Hora . '</td>
                                            <td class="column4">' . mb_strtoupper($row->Nombre_Detenido) . '</td>
                                            <td class="column5" >' . mb_strtoupper($row->Descripcion_Objeto) . '</td>
                                            <td class="column6">' . mb_strtoupper($row->Cantidad) . '</td>
                                            

                        ';
                    //se comprueba si el registro ya tiene un dictamen previamente llenado o si no existe genera un link para nuevo
                    if ($row->Fecha_Hora != '') {
                        if ($row->Validacion_Tab_Bit != '11111111111' || $_SESSION['userdata']->Modo_Admin == '1' || $_SESSION['userdata']->Nivel_User == '1') { //validacion de tabs validados completaente y/o permisos de validacion o modo admin
                            $infoTable['body'] .= '<td class="d-flex">
                                                    <a class="myLinks mb-3' . ' ' . $permisos_Editar . '" data-toggle="tooltip" data-placement="right" title="Editar registro" href="' . base_url . 'Remisiones/editarRemision/?no_remision=' . $row->No_Remision . '&no_ficha=' . $row->Ficha . '">
                                                        <i class="material-icons">edit</i>
                                                    </a>';
                        } else {
                            $infoTable['body'] .= '<td class="d-flex">';
                        }
                        $infoTable['body'] .= '
                                                <a class="myLinks mt-3' . ' ' . $permisos_Ver . '" data-toggle="tooltip" data-placement="right" title="Ver registro" href="' . base_url . 'Remisiones/verRemision/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha2 . '" data-toggle="tooltip" data-placement="right" title="Generar formato remisión" href="' . base_url . 'Remisiones/generarIPH1/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">list_alt</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha . '" data-toggle="tooltip" data-placement="right" title="Generar ficha" href="' . base_url . 'Remisiones/generarFicha/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">file_present</i>
                                                </a>
                                            </td>';
                    }


                    $infoTable['body'] .= '</tr>';
                }
                break;
            case '7': //Armas aseguradas
                $infoTable['header'] .= '
                        <th class="column1">Ficha</th>
                        <th class="column2">Núm. Remisión</th>
                        <th class="column3">Fecha y Hora</th>
                        <th class="column4">Detenido</th>
                        <th class="column5">Tipo Arma</th>
                        <th class="column6">Caracteristica</th>
                        <th class="column7">Descripción</th>
                        <th class="column8">Cantidad</th>
                        
                    ';
                foreach ($rows as $row) {
                    $infoTable['body'] .= '<tr id="tr' . $row->No_Remision . '">';
                    $infoTable['body'] .= '  <td class="column1">' . $row->Ficha . '</td>
                                            <td class="column2">' . $row->No_Remision . '</td>
                                            <td class="column3">' . $row->Fecha_Hora . '</td>
                                            <td class="column4">' . mb_strtoupper($row->Nombre_Detenido) . '</td>
                                            <td class="column5">' . mb_strtoupper($row->Tipo_Arma) . '</td>
                                            <td class="column6">' . mb_strtoupper($row->Caracteristica) . '</td>
                                            <td class="column7">' . mb_strtoupper($row->Descripcion_Arma) . '</td>
                                            <td class="column8">' . $row->Cantidad . '</td>
                                            

                        ';
                    //se comprueba si el registro ya tiene un dictamen previamente llenado o si no existe genera un link para nuevo
                    if ($row->Fecha_Hora != '') {
                        if ($row->Validacion_Tab_Bit != '11111111111' || $_SESSION['userdata']->Modo_Admin == '1' || $_SESSION['userdata']->Nivel_User == '1') { //validacion de tabs validados completaente y/o permisos de validacion o modo admin
                            $infoTable['body'] .= '<td class="d-flex">
                                                    <a class="myLinks mb-3' . ' ' . $permisos_Editar . '" data-toggle="tooltip" data-placement="right" title="Editar registro" href="' . base_url . 'Remisiones/editarRemision/?no_remision=' . $row->No_Remision . '&no_ficha=' . $row->Ficha . '">
                                                        <i class="material-icons">edit</i>
                                                    </a>';
                        } else {
                            $infoTable['body'] .= '<td class="d-flex">';
                        }
                        $infoTable['body'] .= '
                                                <a class="myLinks mt-3' . $permisos_Ver . '" data-toggle="tooltip" data-placement="right" title="Ver registro" href="' . base_url . 'Remisiones/verRemision/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha2 . '" data-toggle="tooltip" data-placement="right" title="Generar formato remisión" href="' . base_url . 'Remisiones/generarIPH1/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">list_alt</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha . '" data-toggle="tooltip" data-placement="right" title="Generar ficha" href="' . base_url . 'Remisiones/generarFicha/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">file_present</i>
                                                </a>
                                            </td>';
                    }


                    $infoTable['body'] .= '</tr>';
                }
                break;
            case '8': //Drogas aseguradas
                $infoTable['header'] .= '
                        <th class="column1">Ficha</th>
                        <th class="column2">Núm. Remisión</th>
                        <th class="column3">Fecha y Hora</th>
                        <th class="column4">Detenido</th>
                        <th class="column5">Tipo droga</th>
                        <th class="column6">Cantidad</th>
                        <th class="column7">Descripción</th>
                        
                    ';
                foreach ($rows as $row) {
                    $infoTable['body'] .= '<tr id="tr' . $row->No_Remision . '">';
                    $infoTable['body'] .= '  <td class="column1">' . $row->Ficha . '</td>
                                            <td class="column2">' . $row->No_Remision . '</td>
                                            <td class="column3">' . $row->Fecha_Hora . '</td>
                                            <td class="column4">' . mb_strtoupper($row->Nombre_Detenido) . '</td>
                                            <td class="column5">' . mb_strtoupper($row->Tipo_Droga) . '</td>
                                            <td class="column6">' . mb_strtoupper($row->Cantidad) . ' ' . mb_strtoupper($row->Unidad) . '</td>
                                            <td class="column7">' . mb_strtoupper($row->Descripcion_Droga) . '</td>
                                            

                        ';
                    //se comprueba si el registro ya tiene un dictamen previamente llenado o si no existe genera un link para nuevo
                    if ($row->Fecha_Hora != '') {
                        if ($row->Validacion_Tab_Bit != '11111111111' || $_SESSION['userdata']->Modo_Admin == '1' || $_SESSION['userdata']->Nivel_User == '1') { //validacion de tabs validados completaente y/o permisos de validacion o modo admin
                            $infoTable['body'] .= '<td class="d-flex">
                                                    <a class="myLinks mt-3' . ' ' . $permisos_Editar . '" data-toggle="tooltip" data-placement="right" title="Editar registro" href="' . base_url . 'Remisiones/editarRemision/?no_remision=' . $row->No_Remision . '&no_ficha=' . $row->Ficha . '">
                                                        <i class="material-icons">edit</i>
                                                    </a>';
                        } else {
                            $infoTable['body'] .= '<td class="d-flex">';
                        }
                        $infoTable['body'] .= '
                                                <a class="myLinks mt-3' . ' ' . $permisos_Ver . '" data-toggle="tooltip" data-placement="right" title="Ver registro" href="' . base_url . 'Remisiones/verRemision/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha2 . '" data-toggle="tooltip" data-placement="right" title="Generar formato remisión" href="' . base_url . 'Remisiones/generarIPH1/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">list_alt</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha . '" data-toggle="tooltip" data-placement="right" title="Generar ficha" href="' . base_url . 'Remisiones/generarFicha/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">file_present</i>
                                                </a>
                                            </td>';
                    }


                    $infoTable['body'] .= '</tr>';
                }
                break;
            case '9': //Accesorios detenido
                $infoTable['header'] .= '
                        <th class="column1">Ficha</th>
                        <th class="column2">Núm. Remisión</th>
                        <th class="column3">Fecha y Hora</th>
                        <th class="column4">Detenido</th>
                        <th class="column5">Tipo accesorio</th>
                        <th class="column6">Descripción</th>
                    ';
                foreach ($rows as $row) {
                    $infoTable['body'] .= '<tr id="tr' . $row->No_Remision . '">';
                    $infoTable['body'] .= '  <td class="column1">' . $row->Ficha . '</td>
                                            <td class="column2">' . $row->No_Remision . '</td>
                                            <td class="column3">' . $row->Fecha_Hora . '</td>
                                            <td class="column4">' . mb_strtoupper($row->Nombre_Detenido) . '</td>
                                            <td class="column5">' . mb_strtoupper($row->Tipo_Accesorio) . '</td>
                                            <td class="column6">' . mb_strtoupper($row->Descripcion) . '</td>

                        ';
                    //se comprueba si el registro ya tiene un dictamen previamente llenado o si no existe genera un link para nuevo
                    if ($row->Fecha_Hora != '') {
                        if ($row->Validacion_Tab_Bit != '11111111111' || $_SESSION['userdata']->Modo_Admin == '1' || $_SESSION['userdata']->Nivel_User == '1') { //validacion de tabs validados completaente y/o permisos de validacion o modo admin
                            $infoTable['body'] .= '<td class="d-flex">
                                                    <a class="myLinks mb-3' . ' ' . $permisos_Editar . '" data-toggle="tooltip" data-placement="right" title="Editar registro" href="' . base_url . 'Remisiones/editarRemision/?no_remision=' . $row->No_Remision . '&no_ficha=' . $row->Ficha . '">
                                                        <i class="material-icons">edit</i>
                                                    </a>';
                        } else {
                            $infoTable['body'] .= '<td class="d-flex">';
                        }
                        $infoTable['body'] .= '
                                                <a class="myLinks mt-3' . ' ' . $permisos_Ver . '" data-toggle="tooltip" data-placement="right" title="Ver registro" href="' . base_url . 'Remisiones/verRemision/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha2 . '" data-toggle="tooltip" data-placement="right" title="Generar formato remisión" href="' . base_url . 'Remisiones/generarIPH1/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">list_alt</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha . '" data-toggle="tooltip" data-placement="right" title="Generar ficha" href="' . base_url . 'Remisiones/generarFicha/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">file_present</i>
                                                </a>
                                            </td>';
                    }


                    $infoTable['body'] .= '</tr>';
                }
                break;
            case '10': //Contacto detenido
                $infoTable['header'] .= '
                        <th class="column1">Ficha</th>
                        <th class="column2">Núm. Remisión</th>
                        <th class="column3">Fecha y Hora</th>
                        <th class="column4">Detenido</th>
                        <th class="column5">Contacto</th>
                        <th class="column6">Parentesco</th>
                        <th class="column7">Teléfono</th>
                        <th class="column8">Edad</th>
                    ';
                foreach ($rows as $row) {
                    $infoTable['body'] .= '<tr id="tr' . $row->No_Remision . '">';
                    $infoTable['body'] .= '  <td class="column1">' . $row->Ficha . '</td>
                                            <td class="column2">' . $row->No_Remision . '</td>
                                            <td class="column3">' . $row->Fecha_Hora . '</td>
                                            <td class="column4">' . mb_strtoupper($row->Nombre_Detenido) . '</td>
                                            <td class="column5">' . mb_strtoupper($row->Nombre_Contacto) . '</td>
                                            <td class="column6">' . mb_strtoupper($row->Parentesco) . '</td>
                                            <td class="column7">' . $row->Telefono_Contacto . '</td>
                                            <td class="column8">' . $row->Edad_Contacto . '</td>

                        ';
                    //se comprueba si el registro ya tiene un dictamen previamente llenado o si no existe genera un link para nuevo
                    if ($row->Fecha_Hora != '') {
                        if ($row->Validacion_Tab_Bit != '11111111111' || $_SESSION['userdata']->Modo_Admin == '1' || $_SESSION['userdata']->Nivel_User == '1') { //validacion de tabs validados completaente y/o permisos de validacion o modo admin
                            $infoTable['body'] .= '<td class="d-flex">
                                                    <a class="myLinks mb-3' . $permisos_Editar . '" data-toggle="tooltip" data-placement="right" title="Editar registro" href="' . base_url . 'Remisiones/editarRemision/?no_remision=' . $row->No_Remision . '&no_ficha=' . $row->Ficha . '">
                                                        <i class="material-icons">edit</i>
                                                    </a>';
                        } else {
                            $infoTable['body'] .= '<td class="d-flex">';
                        }
                        $infoTable['body'] .= '
                                                <a class="myLinks mt-3' . ' ' . $permisos_Ver . '" data-toggle="tooltip" data-placement="right" title="Ver registro" href="' . base_url . 'Remisiones/verRemision/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha2 . '" data-toggle="tooltip" data-placement="right" title="Generar formato remisión" href="' . base_url . 'Remisiones/generarIPH1/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">list_alt</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha . '" data-toggle="tooltip" data-placement="right" title="Generar ficha" href="' . base_url . 'Remisiones/generarFicha/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">file_present</i>
                                                </a>
                                            </td>';
                    }


                    $infoTable['body'] .= '</tr>';
                }
                break;
            case '11': //Adicción detenido
                $infoTable['header'] .= '
                        <th class="column1">Ficha</th>
                        <th class="column2">Núm. Remisión</th>
                        <th class="column3">Fecha y Hora</th>
                        <th class="column4">Detenido</th>
                        <th class="column5">Adicción</th>
                        <th class="column6">¿Roba para consumir?</th>
                        <th class="column7">Frecuencia</th>
                        <th class="column8">Tiempo</th>
                    ';
                foreach ($rows as $row) {
                    $infoTable['body'] .= '<tr id="tr' . $row->No_Remision . '">';
                    $infoTable['body'] .= '  <td class="column1">' . $row->Ficha . '</td>
                                            <td class="column2">' . $row->No_Remision1 . '</td>
                                            <td class="column3">' . $row->Fecha_Hora . '</td>
                                            <td class="column4">' . mb_strtoupper($row->Nombre_Detenido) . '</td>
                                            <td class="column5">' . mb_strtoupper($row->Nombre_Adiccion) . '</td>
                                            <td class="column6">' . $row->Robo_Para_Consumo . '</td>
                                            <td class="column7">' . mb_strtoupper($row->Frecuencia_Consumo) . '</td>
                                            <td class="column8">' . mb_strtoupper($row->Tiempo_Consumo) . '</td>

                        ';
                    //se comprueba si el registro ya tiene un dictamen previamente llenado o si no existe genera un link para nuevo
                    if ($row->Fecha_Hora != '') {
                        if ($row->Validacion_Tab_Bit != '11111111111' || $_SESSION['userdata']->Modo_Admin == '1' || $_SESSION['userdata']->Nivel_User == '1') { //validacion de tabs validados completaente y/o permisos de validacion o modo admin
                            $infoTable['body'] .= '<td class="d-flex">
                                                    <a class="myLinks mb-3' . ' ' . $permisos_Editar . '" data-toggle="tooltip" data-placement="right" title="Editar registro" href="' . base_url . 'Remisiones/editarRemision/?no_remision=' . $row->No_Remision . '&no_ficha=' . $row->Ficha . '">
                                                        <i class="material-icons">edit</i>
                                                    </a>';
                        } else {
                            $infoTable['body'] .= '<td class="d-flex">';
                        }
                        $infoTable['body'] .= '
                                                <a class="myLinks mt-3' . ' ' . $permisos_Ver . '" data-toggle="tooltip" data-placement="right" title="Ver registro" href="' . base_url . 'Remisiones/verRemision/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha2 . '" data-toggle="tooltip" data-placement="right" title="Generar formato remisión" href="' . base_url . 'Remisiones/generarIPH1/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">list_alt</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha . '" data-toggle="tooltip" data-placement="right" title="Generar ficha" href="' . base_url . 'Remisiones/generarFicha/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">file_present</i>
                                                </a>
                                            </td>';
                    }


                    $infoTable['body'] .= '</tr>';
                }
                break;
            case '12': //Tatuajes
                $infoTable['header'] .= '
                        <th class="column1">Ficha</th>
                        <th class="column2">Núm. Remisión</th>
                        <th class="column3">Tipo</th>
                        <th class="column4">Fecha y Hora</th>
                        <th class="column5">Detenido</th>
                        <th class="column6">Perfil</th>
                        <th class="column7">Ubicación Corporal</th>
                        <th class="column8">Color</th>
                        <th class="column9">Clasificación</th>
                        <th class="column10">Descripción</th>
                        <th class="column11">Imagen</th>
                    ';
                foreach ($rows as $row) {
                    $colorAux = ($row->Color) ? 'Sí' : 'No';
                    $ruta = PATH_REM_FILES . $row->No_Ficha . "/SenasParticulares/" . $row->No_Remision; //se carga la ruta donde se tomarán las imgs
                    $ruta2 = BASE_REM_FILES . $row->No_Ficha . "/SenasParticulares/" . $row->No_Remision;
                    $img_tatuaje = '';
                    if (file_exists($ruta2 . '/' . $row->Path_Imagen)) { //si existe el archivo se carga imagen
                        if ($row->Path_Imagen != '') {
                            $img_tatuaje .= ' 
                                            <img src="' . $ruta . '/' . $row->Path_Imagen . '" width="100">
                                        ';
                        }
                    }
                    $infoTable['body'] .= '<tr id="tr' . $row->No_Remision . '">';
                    $infoTable['body'] .= '  <td class="column1">' . $row->No_Ficha . '</td>
                                            <td class="column2">' . $row->No_Remision . '</td>
                                            <td class="column3">' . $row->Tipo_Senia_Particular . '</td>
                                            <td class="column4">' . $row->Fecha_Hora . '</td>
                                            <td class="column5">' . mb_strtoupper($row->Nombre_Detenido) . '</td>
                                            <td class="column6">' . mb_strtoupper($row->Perfil) . '</td>
                                            <td class="column7">' . mb_strtoupper($row->Ubicacion_Corporal) . '</td>
                                            <td class="column8">' . mb_strtoupper($colorAux) . '</td>
                                            <td class="column9">' . mb_strtoupper($row->Clasificacion) . '</td>
                                            <td class="column10">' . mb_strtoupper($row->Descripcion) . '</td>
                                            <td class="column11">' . $img_tatuaje . '</td>

                        ';
                    //se comprueba si el registro ya tiene un dictamen previamente llenado o si no existe genera un link para nuevo
                    if ($row->Fecha_Hora != '') {
                        if ($row->Validacion_Tab_Bit != '11111111111' || $_SESSION['userdata']->Modo_Admin == '1' || $_SESSION['userdata']->Nivel_User == '1') { //validacion de tabs validados completaente y/o permisos de validacion o modo admin
                            $infoTable['body'] .= '<td class="d-flex">
                                                    <a class="myLinks mt-3' . ' ' . $permisos_Editar . '" data-toggle="tooltip" data-placement="right" title="Editar registro" href="' . base_url . 'Remisiones/editarRemision/?no_remision=' . $row->No_Remision . '&no_ficha=' . $row->No_Ficha . '">
                                                        <i class="material-icons">edit</i>
                                                    </a>';
                        } else {
                            $infoTable['body'] .= '<td class="d-flex">';
                        }
                        $infoTable['body'] .= '
                                                <a class="myLinks mt-3' . ' ' . $permisos_Ver . '" data-toggle="tooltip" data-placement="right" title="Ver registro" href="' . base_url . 'Remisiones/verRemision/?no_ficha=' . $row->No_Ficha . '&no_remision=' . $row->No_Remision . '">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha2 . '" data-toggle="tooltip" data-placement="right" title="Generar formato remisión" href="' . base_url . 'Remisiones/generarIPH1/?no_ficha=' . $row->No_Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">list_alt</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha . '" data-toggle="tooltip" data-placement="right" title="Generar ficha" href="' . base_url . 'Remisiones/generarFicha/?no_ficha=' . $row->No_Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">file_present</i>
                                                </a>
                                            </td>';
                    }


                    $infoTable['body'] .= '</tr>';
                }
                break;
            case '13': //registros por validar (o terminar de validar)
                $infoTable['header'] .= '
                        <th class="column1">Ficha</th>
                        <th class="column2">Núm. Remisión</th>
                        <th class="column3">Fecha y Hora</th>
                        <th class="column4">Detenido</th>
                        <th class="column5">Domicilio Detenido</th>
                        <th class="column6">Registró</th>
                        <th class="column7">Remitido a</th>
                        <th class="column8">Folio 911</th>
                    ';
                foreach ($rows as $row) {
                    $infoTable['body'] .= '<tr id="tr' . $row->No_Remision . '">';
                    $infoTable['body'] .= '  <td class="column1">' . $row->Ficha . '</td>
                                            <td class="column2">' . $row->No_Remision . '</td>
                                            <td class="column3">' . $row->Fecha_Hora . '</td>
                                            <td class="column4">' . mb_strtoupper($row->Nombre_Detenido) . '</td>
                                            <td class="column5">' . mb_strtoupper($row->Domicilio_Detenido) . '</td>
                                            <td class="column6">' . mb_strtoupper($row->Nombre_Usuario) . '</td>
                                            <td class="column7">' . mb_strtoupper($row->Instancia) . '</td>
                                            <td class="column8">' . mb_strtoupper($row->Folio_911) . '</td>

                        ';
                    //se comprueba si el registro ya tiene un dictamen previamente llenado o si no existe genera un link para nuevo
                    if ($row->Fecha_Hora != '') {
                        if ($row->Validacion_Tab_Bit != '11111111111' || $_SESSION['userdata']->Modo_Admin == '1' || $_SESSION['userdata']->Nivel_User == '1') { //validacion de tabs validados completaente y/o permisos de validacion o modo admin
                            $infoTable['body'] .= '<td class="d-flex">
                                                    <a class="myLinks mb-3' . ' ' . $permisos_Editar . '" data-toggle="tooltip" data-placement="right" title="Editar registro" href="' . base_url . 'Remisiones/editarRemision/?no_remision=' . $row->No_Remision . '&no_ficha=' . $row->Ficha . '">
                                                        <i class="material-icons">edit</i>
                                                    </a>';
                        } else {
                            $infoTable['body'] .= '<td class="d-flex">';
                        }
                        $infoTable['body'] .= '
                                                <a class="myLinks mt-3' . ' ' . $permisos_Ver . '" data-toggle="tooltip" data-placement="right" title="Ver registro" href="' . base_url . 'Remisiones/verRemision/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha2 . '" data-toggle="tooltip" data-placement="right" title="Generar formato remisión" href="' . base_url . 'Remisiones/generarIPH1/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">list_alt</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha . '" data-toggle="tooltip" data-placement="right" title="Generar ficha" href="' . base_url . 'Remisiones/generarFicha/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">file_present</i>
                                                </a>
                                            </td>';
                    }


                    $infoTable['body'] .= '</tr>';
                }
                break;
            case '14': //registros por validados completamente
                $infoTable['header'] .= '
                        <th class="column1">Ficha</th>
                        <th class="column2">Núm. Remisión</th>
                        <th class="column3">Fecha y Hora</th>
                        <th class="column4">Detenido</th>
                        <th class="column5">Domicilio Detenido</th>
                        <th class="column6">Registró</th>
                        <th class="column7">Remitido a</th>
                        <th class="column8">Folio 911</th>
                    ';
                foreach ($rows as $row) {
                    $infoTable['body'] .= '<tr id="tr' . $row->No_Remision . '">';
                    $infoTable['body'] .= '  <td class="column1">' . $row->Ficha . '</td>
                                            <td class="column2">' . $row->No_Remision . '</td>
                                            <td class="column3">' . $row->Fecha_Hora . '</td>
                                            <td class="column4">' . mb_strtoupper($row->Nombre_Detenido) . '</td>
                                            <td class="column5">' . mb_strtoupper($row->Domicilio_Detenido) . '</td>
                                            <td class="column6">' . mb_strtoupper($row->Nombre_Usuario) . '</td>
                                            <td class="column7">' . mb_strtoupper($row->Instancia) . '</td>
                                            <td class="column8">' . mb_strtoupper($row->Folio_911) . '</td>

                        ';
                    //se comprueba si el registro ya tiene un dictamen previamente llenado o si no existe genera un link para nuevo
                    if ($row->Fecha_Hora != '') {
                        if ($row->Validacion_Tab_Bit != '11111111111' || $_SESSION['userdata']->Modo_Admin == '1' || $_SESSION['userdata']->Nivel_User == '1') { //validacion de tabs validados completaente y/o permisos de validacion o modo admin
                            $infoTable['body'] .= '<td class="d-flex">
                                                    <a class="myLinks mb-3' . ' ' . $permisos_Editar . '" data-toggle="tooltip" data-placement="right" title="Editar registro" href="' . base_url . 'Remisiones/editarRemision/?no_remision=' . $row->No_Remision . '&no_ficha=' . $row->Ficha . '">
                                                        <i class="material-icons">edit</i>
                                                    </a>';
                        } else {
                            $infoTable['body'] .= '<td class="d-flex">';
                        }
                        $infoTable['body'] .= '
                                                <a class="myLinks mt-3' . ' ' . $permisos_Ver . '" data-toggle="tooltip" data-placement="right" title="Ver registro" href="' . base_url . 'Remisiones/verRemision/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha2 . '" data-toggle="tooltip" data-placement="right" title="Generar formato remisión" href="' . base_url . 'Remisiones/generarIPH1/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">list_alt</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha . '" data-toggle="tooltip" data-placement="right" title="Generar ficha" href="' . base_url . 'Remisiones/generarFicha/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">file_present</i>
                                                </a>
                                            </td>';
                    }

                    $infoTable['body'] .= '</tr>';
                }
                break;
            case '15': //Vehículos asegurados
                $infoTable['header'] .= '
                        <th class="column1">Ficha</th>
                        <th class="column2">Núm. Remisión</th>
                        <th class="column3">Fecha y Hora</th>
                        <th class="column4">Situación</th>
                        <th class="column5">Tipo Vehículo</th>
                        <th class="column6">Marca</th>
                        <th class="column7">Modelo</th>
                        <th class="column8">Núm. Serie</th>
                        <th class="column9">Placa</th> 
                    ';
                foreach ($rows as $row) {
                    $auxTipo = ($row->Tipo_Situacion) ? 'Involucrado' : 'Recuperado';
                    $infoTable['body'] .= '<tr id="tr' . $row->No_Remision . '">';
                    $infoTable['body'] .= '  <td class="column1">' . $row->Ficha . '</td>
                                            <td class="column2">' . $row->No_Remision . '</td>
                                            <td class="column3">' . $row->Fecha_Hora . '</td>
                                            <td class="column4">' . mb_strtoupper($auxTipo) . '</td>
                                            <td class="column5">' . mb_strtoupper($row->Tipo_Vehiculo) . '</td>
                                            <td class="column6">' . mb_strtoupper($row->Marca) . '</td>
                                            <td class="column7">' . mb_strtoupper($row->Modelo) . '</td>
                                            <td class="column8">' . mb_strtoupper($row->No_Serie) . '</td>
                                            <td class="column9">' . mb_strtoupper($row->Placa_Vehiculo) . '</td> 

                                            

                        ';
                    //se comprueba si el registro ya tiene un dictamen previamente llenado o si no existe genera un link para nuevo
                    if ($row->Fecha_Hora != '') {
                        if ($row->Validacion_Tab_Bit != '11111111111' || $_SESSION['userdata']->Modo_Admin == '1' || $_SESSION['userdata']->Nivel_User == '1') { //validacion de tabs validados completaente y/o permisos de validacion o modo admin
                            $infoTable['body'] .= '<td class="d-flex">
                                                    <a class="myLinks mb-3' . ' ' . $permisos_Editar . '" data-toggle="tooltip" data-placement="right" title="Editar registro" href="' . base_url . 'Remisiones/editarRemision/?no_remision=' . $row->No_Remision . '&no_ficha=' . $row->Ficha . '">
                                                        <i class="material-icons">edit</i>
                                                    </a>';
                        } else {
                            $infoTable['body'] .= '<td class="d-flex">';
                        }
                        $infoTable['body'] .= '
                                                <a class="myLinks mt-3' . ' ' . $permisos_Ver . '" data-toggle="tooltip" data-placement="right" title="Ver registro" href="' . base_url . 'Remisiones/verRemision/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="myLinks mt-3' . ' ' . $permisos_FormatoFicha . '" data-toggle="tooltip" data-placement="right" title="Generar ficha" href="' . base_url . 'Remisiones/generarFicha/?no_ficha=' . $row->Ficha . '&no_remision=' . $row->No_Remision . '" target="_blank">
                                                    <i class="material-icons">file_present</i>
                                                </a>
                                            </td>';
                    }


                    $infoTable['body'] .= '</tr>';
                }
                break;
        }



        $infoTable['header'] .= '<th >Operaciones</th>';
        //$infoTable['header'].='<th >Ver</th>';

        return $infoTable;
    }

    //función para generar los links respectivos dependiendo del filtro y/o cadena de búsqueda
    public function generarExportLinks($extra_cad = "", $filtro = 1)
    {
        if ($extra_cad != "") {
            $dataReturn['csv'] =  base_url . 'Remisiones/exportarInfo/?tipo_export=CSV' . $extra_cad . '&filtroActual=' . $filtro;
            $dataReturn['excel'] =  base_url . 'Remisiones/exportarInfo/?tipo_export=EXCEL' . $extra_cad . '&filtroActual=' . $filtro;
            $dataReturn['pdf'] =  base_url . 'Remisiones/exportarInfo/?tipo_export=PDF' . $extra_cad . '&filtroActual=' . $filtro;
            //return $dataReturn;
        } else {
            $dataReturn['csv'] =  base_url . 'Remisiones/exportarInfo/?tipo_export=CSV' . $extra_cad . '&filtroActual=' . $filtro;
            $dataReturn['excel'] =  base_url . 'Remisiones/exportarInfo/?tipo_export=EXCEL' . $extra_cad . '&filtroActual=' . $filtro;
            $dataReturn['pdf'] =  base_url . 'Remisiones/exportarInfo/?tipo_export=PDF' . $extra_cad . '&filtroActual=' . $filtro;
        }
        return $dataReturn;
    }

    //función fetch para buscar por la cadena introducida dependiendo del filtro
    public function buscarPorCadena()
    {
        /*Aquí van condiciones de permisos*/

        if (isset($_POST['cadena'])) {
            $cadena = trim($_POST['cadena']);
            $filtroActual = trim($_POST['filtroActual']);

            $results = $this->Remision->getRemisionDByCadena($cadena, $filtroActual);
            if (strlen($cadena) > 0) {
                $user = $_SESSION['userdata']->Id_Usuario;
                $ip = $this->obtenerIp();
                $descripcion = 'Consulta realizada: ' . $cadena . '';
                $this->Remision->historial($user, $ip, 6, $descripcion);
            }
            $extra_cad = ($cadena != "") ? ("&cadena=" . $cadena) : ""; //para links conforme a búsqueda

            //$dataReturn = "jeje";

            $dataReturn['infoTable'] = $this->generarInfoTable($results['rows_Rems'], $filtroActual);
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

    //función para exportar la inforación dependiendo del filtro 
    public function exportarInfo()
    {
        /*checar permisos*/

        if (!isset($_REQUEST['tipo_export'])) {
            header("Location: " . base_url . "Inicio");
            exit();
        }
        //se recupera el catalogo actual para poder consultar conforme al mismo
        if (!isset($_REQUEST['filtroActual']) || !is_numeric($_REQUEST['filtroActual']) || !($_REQUEST['filtroActual'] >= MIN_FILTRO_REM) || !($_REQUEST['filtroActual'] <= MAX_FILTRO_REM))
            $filtroActual = 1;
        else
            $filtroActual = $_REQUEST['filtroActual'];

        $from_where_sentence = "";
        //se genera la sentencia from where para realizar la correspondiente consulta
        if (isset($_REQUEST['cadena']))
            $from_where_sentence = $this->Remision->generateFromWhereSentence($_REQUEST['cadena'], $filtroActual);
        else
            $from_where_sentence = $this->Remision->generateFromWhereSentence("", $filtroActual);



        //var_dump($_REQUEST);
        $tipo_export = $_REQUEST['tipo_export'];

        if ($tipo_export == 'EXCEL') {
            //se realiza exportacion de usuarios a EXCEL
            $rows_Rem = $this->Remision->getAllInfoRemisionDByCadena($from_where_sentence);
            switch ($filtroActual) {
                case '1':
                    $filename = "Rem_general";
                    //datos indispensables
                    $csv_data = "Ficha,Núm. Remisión,Fecha Rem,Hora Rem,Zona/Sector,Vector,Cia,Remitido a,Nombre Detenido,Ap Paterno Detenido,Ap Materno Detenido,Alias,Domicilio detenido en,Colonia Detenido,Calle Detenido,No Ext Detenido,No Int Detenido,Municipio Detenido,CP Detenido,Estado Detenido,Coord Y Detenido,Coord X Detenido,Nacionalidad detenido, Estado de Origen detenido,Municipio Origen Detenido,Edad Detenido,Sexo Detenido,Escolaridad Detenido,Pertenencias Detenido,";
                    if($_SESSION['userdata']->ver_Narrativas[1]== '1' || $_SESSION['userdata']->editar_Narrativas[1]== '1' || $_SESSION['userdata']->Modo_Admin == '1'){
                        //------narrativas-detenido
                        $csv_data .="Narrativa del detenido,";
                        //--------entrevista del detenido
                        $csv_data .="Vinculación a banda o grupo delictivo,Antecedentes Penales,";
                    }
                    if($_SESSION['userdata']->Editar_remisiones[1]== '1' || $_SESSION['userdata']->Ver_remisiones[1]== '1' || $_SESSION['userdata']->Modo_Admin == '1'){
                        //------media filiacion
                        $csv_data .="Complexión,Estatura,Color de piel,Forma de la cara,Pómulos,Cabello,Color de cabello,Tam de cabello,Forma de cabello,Frente,Cejas,Tipo de cejas,Color de ojos,Tam de ojos,Forma de ojos,Nariz,Tamaño de boca,Labios,Mentón,Tam de orejas,Lóbulos,Barba,Tam de barba,Color de barba,Bigote,Tam de bigote,Color de bigote,";
                    }
                    //peticionaro
                    $csv_data .="Nombre Petic,Ap_ Paterno Petic,Ap Materno Petic,Domicilio petic en,Colonia Petic,Calle Petic,No Ext Petic,No Int Petic,Municipio Petic,CP Petic,Estado Petic,Coord Y Petic,Coord X Petic,Nacionalidad Petic, Estado origen Petic, Municipio Origen Petic,Edad Petic,Sexo Petic,Escolaridad Petic,";
                    //Ubicacion de los hechos
                    $csv_data .="Colonia Hechos,Fraccionamiento Hechos,Calle 1 Hechos,Calle 2 Hechos,No Ext Hechos,No Int Hechos,CP Hechos,Coord Y Hechos,Coord X Hechos,Hora Hechos,F_D,Motivo Detenido,";
                    //elementos participantes
                    $csv_data .="Remitido Por,Patrulla_No,Apoyo Patrulla,Grupo, Elementos Participantes,";
                    //ubicacion de la detencion
                    $csv_data .="Fecha/Hora Detencion,";
                    if($_SESSION['userdata']->ver_Narrativas[0]== '1' || $_SESSION['userdata']->editar_Narrativas[0]== '1' || $_SESSION['userdata']->Modo_Admin == '1'){
                        //--------narrativas-IPH
                        $csv_data .="CDI,";
                    }
                    //objetos asegurados
                    $csv_data .="Objetos Asegurados Det,Armas Aseguradas Det,Drogas Aseguradas Det, Vehiculo Remisión,";  
                    //datos principales
                    $csv_data .="Tel. Detenido,";
                    //media miliacion
                    $csv_data .="Tel. Familiar,";
                    //datos principales
                    $csv_data .="Estatus,Estatus Ficha\n";
                    //se recuperan los objetos y narrativas de elementos dependiendo de los resultados
                    $Apartados_Remision = $this->Remision->getTodosApartados($rows_Rem);
                    foreach ($rows_Rem as $key => $row) {

                    //$cancelada = $Apartados_Remision['Ficha'][$key]->fcancelada;
                        error_reporting(E_ERROR | E_PARSE); //evita mostrar errores de php, aparecen errores del arreglo de narrativa de detenido (algunos no tienen narrativa) 

                        /* ----- ----- ----- Se ajusta la patrulla en apoyo para mostrarla siempre cuando exista una diferente ----- ----- ----- */
                        $apoyoPatrulla = '';
                        if(count($Apartados_Remision['Elementos_Participantes'][$key])>1){
                            foreach($Apartados_Remision['Elementos_Participantes'][$key] as $elemento){
                                if(strtoupper($Apartados_Remision['Elementos_Participantes'][$key][0]->No_Unidad) != strtoupper($elemento->No_Unidad)){
                                    $apoyoPatrulla = strtoupper($elemento->No_Unidad);
                                }
                            }
                        }
                        // var_dump($Apartados_Remision['Peticionario'][$key]);
                        $auxFechaHoraRemision = explode(" ", $row->Fecha_Hora);
                        $auxGeneroDet = (mb_strtoupper($Apartados_Remision['Detenido'][$key]->Genero) == 'H') ? 'Masculino' : 'Femenino';
                        $auxGeneroPet = (mb_strtoupper($Apartados_Remision['Peticionario'][$key]->Genero) == 'H') ? 'Masculino' : 'Femenino';
                        $auxFD = (mb_strtoupper($Apartados_Remision['Remision'][$key]->Falta_Delito_Tipo) == 'F') ? 'Falta' : 'Delito';

                        //datos principales
                        $csv_data .= $row->Ficha . "," .
                            $row->No_Remision . ",\"" .
                            $auxFechaHoraRemision[0] . "\",\"" .
                            substr($auxFechaHoraRemision[1], 0, 5) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Remision'][$key]->Zona_Sector) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Ubicacion_Hechos'][$key]->Vector) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Remision'][$key]->Cia) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Remision'][$key]->Instancia) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->Nombre) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->Ap_Paterno) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->Ap_Materno) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Alias'][$key]->Alias) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->Domicilio_en) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->Colonia) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->Calle) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->No_Exterior) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->No_Interior) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->Municipio) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->CP) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->Estado) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->Coordenada_Y) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->Coordenada_X) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->Nacionalidad) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->EstadoMex_Origen) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->Lugar_Origen) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->Edad) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->Genero) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->Escolaridad) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->Pertenencias_Detenido) . "\",\"";
                            if($_SESSION['userdata']->ver_Narrativas[1]== '1' || $_SESSION['userdata']->editar_Narrativas[1]== '1' || $_SESSION['userdata']->Modo_Admin == '1'){
                                //narrativas-detenido
                                $csv_data .= mb_strtoupper(($Apartados_Remision['Narrativadet'][$key]->Narrativa_Hechos)=='' ? 'SIN NARRATIVA' : mb_strtoupper(str_replace('"', '`',$Apartados_Remision['Narrativadet'][$key]->Narrativa_Hechos))) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Narrativadet'][$key]->Vinculacion_Grupo_D) . "\",\"".
                                mb_strtoupper($Apartados_Remision['Antecedente'][$key]) . "\",\"";
                                //entrevista del detenido
                            }           
                            if($_SESSION['userdata']->Editar_remisiones[1]== '1' || $_SESSION['userdata']->Ver_remisiones[1]== '1' || $_SESSION['userdata']->Modo_Admin == '1'){
                                //media filiacion
                                $csv_data .=mb_strtoupper($Apartados_Remision['Detenido'][$key]->Complexion) . "\",\"".
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Estatura_cm) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Color_Piel) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Forma_Cara) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Pomulos) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Cabello) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Color_Cabello) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Tam_Cabello) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Forma_Cabello) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Frente) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Cejas) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Tipo_Cejas) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Color_Ojos) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Tam_Ojos) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Forma_Ojos) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Nariz) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Tam_Boca) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Labios) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Menton) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Tam_Orejas) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Lobulos) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Barba) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Tam_Barba) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Color_Barba) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Bigote) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Tam_Bigote) . "\",\"" .
                                mb_strtoupper($Apartados_Remision['Detenido'][$key]->Color_Bigote) . "\",\"" ;
                            }
                            $csv_data .=mb_strtoupper($Apartados_Remision['Peticionario'][$key]->Nombre) . "\",\"" .
                            //peticionario
                            mb_strtoupper($Apartados_Remision['Peticionario'][$key]->Ap_Paterno) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Peticionario'][$key]->Ap_Materno) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Peticionario'][$key]->Domicilio_en) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Peticionario'][$key]->Colonia) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Peticionario'][$key]->Calle) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Peticionario'][$key]->No_Exterior) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Peticionario'][$key]->No_Interior) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Peticionario'][$key]->Municipio) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Peticionario'][$key]->CP) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Peticionario'][$key]->Estado) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Peticionario'][$key]->Coordenada_Y) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Peticionario'][$key]->Coordenada_X) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Peticionario'][$key]->Nacionalidad) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Peticionario'][$key]->EstadoMex_Origen) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Peticionario'][$key]->Lugar_Origen) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Peticionario'][$key]->Edad) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Peticionario'][$key]->Genero) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Peticionario'][$key]->Escolaridad) . "\",\"" .
                            //ubicacion de los hechos
                            mb_strtoupper($Apartados_Remision['Ubicacion_Hechos'][$key]->Colonia) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Ubicacion_Hechos'][$key]->Fraccionamiento) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Ubicacion_Hechos'][$key]->Calle_1) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Ubicacion_Hechos'][$key]->Calle_2) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Ubicacion_Hechos'][$key]->No_Ext) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Ubicacion_Hechos'][$key]->No_Int) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Ubicacion_Hechos'][$key]->CP) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Ubicacion_Hechos'][$key]->Coordenada_Y) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Ubicacion_Hechos'][$key]->Coordenada_X) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Ubicacion_Hechos'][$key]->Hora_Reporte) . "\",\"" .
                            mb_strtoupper($auxFD) . "\",\"" .
                            //elementos participantes
                            mb_strtoupper($Apartados_Remision['Remision'][$key]->Remitido_Por) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Faltas_Delitos_Detenido'][$key]) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Elementos_Participantes'][$key][0]->No_Unidad) . "\",\"" .
                            mb_strtoupper($apoyoPatrulla) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Elementos_Participantes'][$key][0]->Sector_Area) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Elementos_Participantes_Nombres'][$key]) . "\",\"".
                            //ubicacion detencion
                            mb_strtoupper($Apartados_Remision['Ubicacion_Detencion'][$key]->Fecha_Hora_Detencion) . "\",\"" ;
                            if($_SESSION['userdata']->ver_Narrativas[0]== '1' || $_SESSION['userdata']->editar_Narrativas[0]== '1' || $_SESSION['userdata']->Modo_Admin == '1'){
                                //narrativas-IPH
                                $csv_data .=mb_strtoupper($Apartados_Remision['Detenido'][$key]->CDI) . "\",\"" ;
                            }
                            //objetos asegurados
                            $csv_data .=mb_strtoupper(str_replace('"', '`',$Apartados_Remision['Objetos_Asegurados'][$key])) . "\",\"" .
                            mb_strtoupper(str_replace('"', '`',$Apartados_Remision['Armas_Aseguradas'][$key])) . "\",\"" .
                            mb_strtoupper(str_replace('"', '`',$Apartados_Remision['Drogas_Aseguradas'][$key])) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Vehiculos_Remision'][$key]) . "\",\"". 
                            //datos-principales
                            mb_strtoupper($Apartados_Remision['Detenido'][$key]->Telefono) . "\",\"" .
                            //media filiacion
                            mb_strtoupper($Apartados_Remision['Contacto_Detenido'][$key]->Telefono_fam) . "\",\"" .
                            //datos principales
                            mb_strtoupper(($Apartados_Remision['Remision'][$key]->Status_Remision)=='0' ? 'CANCELADO' : 'ACTIVO') . "\",\"" .
                            mb_strtoupper(($Apartados_Remision['Ficha'][$key]->fcancelada)=='cancelada' ? 'CANCELADO' : 'ACTIVO') . "\"\n";
                    }
                    break;
                case '2':
                    $filename = "Rem_peticionarios";
                    $csv_data = "Ficha,Núm. Remisión,Fecha y Hora,Peticionario,Domicilio Peticionario,Detenido remitido a,Folio 911\n";

                    foreach ($rows_Rem as $row) {
                        $csv_data .= $row->Ficha . ",\"" .
                            $row->No_Remision . "\",\"" .
                            $row->Fecha_Hora . "\",\"" .
                            mb_strtoupper($row->Nombre_Peticionario) . "\",\"" .
                            mb_strtoupper($row->Domicilio_Peticionario) . "\",\"" .
                            mb_strtoupper($row->Instancia) . "\",\"" .
                            mb_strtoupper($row->Folio_911) . "\"\n";
                    }
                    break;
                case '3':
                    $filename = "Rem_ubicacion_hechos";
                    $csv_data = "Ficha,Núm. Remisión,Fecha y Hora,Detenido,Domicilio Detenido,Ubicacion Hechos,Remitido a\n";

                    foreach ($rows_Rem as $row) {
                        $csv_data .= $row->Ficha . ",\"" .
                            $row->No_Remision . "\",\"" .
                            $row->Fecha_Hora . "\",\"" .
                            mb_strtoupper($row->Nombre_Detenido) . "\",\"" .
                            mb_strtoupper($row->Domicilio_Detenido) . "\",\"" .
                            mb_strtoupper($row->Ubicacion_Hechos) . "\",\"" .
                            mb_strtoupper($row->Instancia) . "\"\n";
                    }
                    break;
                case '4':
                    $filename = "Rem_elementos_participantes";
                    $csv_data = "Ficha,Núm. Remisión,Fecha y Hora,Detenido,Elemento,Cargo,Placa,Unidad,Tipo Llamado\n";

                    foreach ($rows_Rem as $row) {
                        $auxllamado = ($row->Tipo_Llamado == '0') ? "En apoyo" : "Primer respondiente";
                        $csv_data .= $row->Ficha . ",\"" .
                            $row->No_Remision . "\",\"" .
                            $row->Fecha_Hora . "\",\"" .
                            mb_strtoupper($row->Nombre_Detenido) . "\",\"" .
                            mb_strtoupper($row->Nombre_Elemento) . "\",\"" .
                            mb_strtoupper($row->Cargo) . "\",\"" .
                            mb_strtoupper($row->Placa) . "\",\"" .
                            mb_strtoupper($row->No_Unidad) . "\",\"" .
                            mb_strtoupper($auxllamado) . "\"\n";
                    }
                    break;
                case '5':
                    $filename = "Rem_ubicacion_detencion";
                    $csv_data = "Ficha,Núm. Remisión,Fecha y Hora,Detenido,Domicilio Detenido,Ubicación Detención,Remitido a,Folio 911\n";

                    foreach ($rows_Rem as $row) {
                        $csv_data .= $row->Ficha . ",\"" .
                            $row->No_Remision . "\",\"" .
                            $row->Fecha_Hora . "\",\"" .
                            mb_strtoupper($row->Nombre_Detenido) . "\",\"" .
                            mb_strtoupper($row->Domicilio_Detenido) . "\",\"" .
                            mb_strtoupper($row->Ubicacion_Detencion) . "\",\"" .
                            mb_strtoupper($row->Instancia) . "\",\"" .
                            mb_strtoupper($row->Folio_911) . "\"\n";
                    }
                    break;
                case '6':
                    $filename = "Rem_obj_asegurados";
                    $csv_data = "Ficha,Núm. Remisión,Fecha y Hora,Detenido,Objeto,Cantidad,Remitido a\n";

                    foreach ($rows_Rem as $row) {
                        $csv_data .= $row->Ficha . ",\"" .
                            $row->No_Remision . "\",\"" .
                            $row->Fecha_Hora . "\",\"" .
                            mb_strtoupper($row->Nombre_Detenido) . "\",\"" .
                            mb_strtoupper($row->Descripcion_Objeto) . "\",\"" .
                            mb_strtoupper($row->Cantidad) . "\",\"" .
                            mb_strtoupper($row->Instancia) . "\"\n";
                    }
                    break;
                case '7':
                    $filename = "Rem_armas_aseguradas";
                    $csv_data = "Ficha,Núm. Remisión,Fecha y Hora,Detenido,Tipo Arma,Caracteristica,Descripción,Cantidad\n";

                    foreach ($rows_Rem as $row) {
                        $csv_data .= $row->Ficha . ",\"" .
                            $row->No_Remision . "\",\"" .
                            $row->Fecha_Hora . "\",\"" .
                            mb_strtoupper($row->Nombre_Detenido) . "\",\"" .
                            mb_strtoupper($row->Tipo_Arma) . "\",\"" .
                            mb_strtoupper($row->Caracteristica) . "\",\"" .
                            mb_strtoupper($row->Descripcion_Arma) . "\",\"" .
                            mb_strtoupper($row->Cantidad) . "\"\n";
                    }
                    break;
                case '8':
                    $filename = "Rem_drogas_aseguradas";
                    $csv_data = "Ficha,Núm. Remisión,Fecha y Hora,Detenido,Tipo Droga,Cantidad,Descripción\n";

                    foreach ($rows_Rem as $row) {
                        $auxCantidad = $row->Cantidad . " " . $row->Unidad;
                        $csv_data .= $row->Ficha . ",\"" .
                            $row->No_Remision . "\",\"" .
                            $row->Fecha_Hora . "\",\"" .
                            mb_strtoupper($row->Nombre_Detenido) . "\",\"" .
                            mb_strtoupper($row->Tipo_Droga) . "\",\"" .
                            mb_strtoupper($auxCantidad) . "\",\"" .
                            mb_strtoupper($row->Descripcion_Droga) . "\"\n";
                    }
                    break;
                case '9':
                    $filename = "Rem_accesorios_detenido";
                    $csv_data = "Ficha,Núm. Remisión,Fecha y Hora,Detenido,Tipo Accesorio,Descripción\n";

                    foreach ($rows_Rem as $row) {
                        $csv_data .= $row->Ficha . ",\"" .
                            $row->No_Remision . "\",\"" .
                            $row->Fecha_Hora . "\",\"" .
                            mb_strtoupper($row->Nombre_Detenido) . "\",\"" .
                            mb_strtoupper($row->Tipo_Accesorio) . "\",\"" .
                            mb_strtoupper($row->Descripcion) . "\"\n";
                    }
                    break;
                case '10':
                    $filename = "Rem_contacto_detenido";
                    $csv_data = "Ficha,Núm. Remisión,Fecha y Hora,Detenido,Contacto,Parentesco,Teléfono,Edad\n";

                    foreach ($rows_Rem as $row) {
                        $csv_data .= $row->Ficha . ",\"" .
                            $row->No_Remision . "\",\"" .
                            $row->Fecha_Hora . "\",\"" .
                            mb_strtoupper($row->Nombre_Detenido) . "\",\"" .
                            mb_strtoupper($row->Nombre_Contacto) . "\",\"" .
                            mb_strtoupper($row->Parentesco) . "\",\"" .
                            mb_strtoupper($row->Telefono_Contacto) . "\",\"" .
                            mb_strtoupper($row->Edad_Contacto) . "\"\n";
                    }
                    break;
                case '11':
                    $filename = "Rem_adiccion_detenido";
                    $csv_data = "Ficha,Núm. Remisión,Fecha y Hora,Detenido,Adicción,Robo Para Consumo,Frecuencia Consumo,Tiempo Consumo\n";

                    foreach ($rows_Rem as $row) {
                        $auxRoboConsumo = ($row->Robo_Para_Consumo) ? 'Sí' : 'No';
                        $csv_data .= $row->Ficha . ",\"" .
                            $row->No_Remision . "\",\"" .
                            $row->Fecha_Hora . "\",\"" .
                            mb_strtoupper($row->Nombre_Detenido) . "\",\"" .
                            mb_strtoupper($row->Nombre_Adiccion) . "\",\"" .
                            mb_strtoupper($auxRoboConsumo) . "\",\"" .
                            mb_strtoupper($row->Frecuencia_Consumo) . "\",\"" .
                            mb_strtoupper($row->Tiempo_Consumo) . "\"\n";
                    }
                    break;
                case '12':
                    $filename = "Rem_senas";
                    $csv_data = "Ficha,Núm. Remisión,Tipo,Fecha y Hora,Detenido,Perfil,Ubicación Corporal,Color,Clasificación,Descripción\n";

                    foreach ($rows_Rem as $row) {
                        $colorAux = ($row->Color) ? 'Sí' : 'No';
                        $csv_data .= $row->No_Ficha . ",\"" .
                            $row->No_Remision . "\",\"" .
                            mb_strtoupper($row->Tipo_Senia_Particular) . "\",\"" .
                            $row->Fecha_Hora . "\",\"" .
                            mb_strtoupper($row->Nombre_Detenido) . "\",\"" .
                            mb_strtoupper($row->Perfil) . "\",\"" .
                            mb_strtoupper($row->Ubicacion_Corporal) . "\",\"" .
                            mb_strtoupper($colorAux) . "\",\"" .
                            mb_strtoupper($row->Clasificacion) . "\",\"" .
                            mb_strtoupper($row->Descripcion) . "\"\n";
                    }
                    break;
                case '13':
                    $filename = "Rem_por_validar";
                    $csv_data = "Ficha,Núm. Remisión,Fecha y Hora,Detenido,Domicilio Detenido,Usuario Registró,Instancia,Objetos Asegurados,Armas_Aseguradas,Drogas Aseguradas,Narrativa Detenido,Narrativa Peticionario,Narrativa Elementos\n";
                    //se recuperan los objetos y narrativas de elementos dependiendo de los resultados
                    $Apartados_Remision = $this->Remision->getTodosApartados($rows_Rem);
                    foreach ($rows_Rem as $key => $row) {

                        $csv_data .= $row->Ficha . ",\"" .
                            $row->No_Remision . "\",\"" .
                            $row->Fecha_Hora . "\",\"" .
                            mb_strtoupper($row->Nombre_Detenido) . "\",\"" .
                            mb_strtoupper($row->Domicilio_Detenido) . "\",\"" .
                            mb_strtoupper($row->Nombre_Usuario) . "\",\"" .
                            mb_strtoupper($row->Instancia) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Objetos_Asegurados'][$key]) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Armas_Aseguradas'][$key]) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Drogas_Aseguradas'][$key]) . "\",\"" .
                            mb_strtoupper($row->Narrativa_Detenido) . "\",\"" .
                            mb_strtoupper($row->Narrativa_Peticionario) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Narrativas_Elementos'][$key]) . "\"\n";
                    }
                    break;
                case '14':
                    $filename = "Rem_por_validar";
                    $csv_data = "Ficha,Núm. Remisión,Fecha y Hora,Detenido,Domicilio Detenido,Usuario Registró,Instancia,Objetos Asegurados,Armas Aseguradas,Drogas Aseguradas,Narrativa Detenido,Narrativa Peticionario,Narrativa Elementos\n";
                    //se recuperan los objetos y narrativas de elementos dependiendo de los resultados
                    $Apartados_Remision = $this->Remision->getTodosApartados($rows_Rem);
                    foreach ($rows_Rem as $key => $row) {

                        $csv_data .= $row->Ficha . ",\"" .
                            $row->No_Remision . "\",\"" .
                            $row->Fecha_Hora . "\",\"" .
                            mb_strtoupper($row->Nombre_Detenido) . "\",\"" .
                            mb_strtoupper($row->Domicilio_Detenido) . "\",\"" .
                            mb_strtoupper($row->Nombre_Usuario) . "\",\"" .
                            mb_strtoupper($row->Instancia) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Objetos_Asegurados'][$key]) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Armas_Aseguradas'][$key]) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Drogas_Aseguradas'][$key]) . "\",\"" .
                            mb_strtoupper($row->Narrativa_Detenido) . "\",\"" .
                            mb_strtoupper($row->Narrativa_Peticionario) . "\",\"" .
                            mb_strtoupper($Apartados_Remision['Narrativas_Elementos'][$key]) . "\"\n";
                    }
                    break;
                case '15':
                    $filename = "Rem Vehiculos Asg";
                    $csv_data = "Núm. Remisión,Fecha,Hora,Forma Aseguramiento,Grupo Zona,Marca,Tipo,Modelo,Placas,Núm. Serie,Color , Procedencia, Observaciones\n";
                    //se recuperan los objetos y narrativas de elementos dependiendo de los resultados
                    foreach ($rows_Rem as $key => $row) {
                        $fechaAux = explode(" ", $row->Fecha_Hora, 2);
                        $fechaAux[1] = substr($fechaAux[1], 0, 5);
                        $csv_data .= $row->No_Remision . ",\"" .
                            $fechaAux[0] . "\",\"" .
                            $fechaAux[1] . "\",\"" .
                            mb_strtoupper($row->Forma_Detencion) . "\",\"" .
                            mb_strtoupper($row->Zona_Sector) . "\",\"" .
                            mb_strtoupper($row->Marca) . "\",\"" .
                            mb_strtoupper($row->Tipo_Vehiculo) . "\",\"" .
                            mb_strtoupper($row->Modelo) . "\",\"" .
                            mb_strtoupper($row->Placa_Vehiculo) . "\",\"" .
                            mb_strtoupper($row->No_Serie) . "\",\"" .
                            mb_strtoupper($row->Color) . "\",\"" .
                            mb_strtoupper($row->Procedencia_Vehiculo) . "\",\"" .
                            mb_strtoupper($row->Observacion_Vehiculo) . "\",\n";
                    }
                    break;
            }
            //se genera el archivo csv o excel
            $csv_data = utf8_decode($csv_data); //escribir información con formato utf8 por algún acento
            header("Content-Description: File Transfer");
            header("Content-Type: application/force-download");
            header("Content-Disposition: attachment; filename=" . $filename . ".csv");
            echo $csv_data;
            //header("Location: ".base_url."UsersAdmin");

        } elseif ($tipo_export == 'PDF') {
            $rows_Rem = $this->Remision->getAllInfoRemisionDByCadena($from_where_sentence);


            header("Content-type: application/pdf");
            header("Content-Disposition: inline; filename=usuarios.pdf");
            echo $this->generarPDF($rows_Rem, $_REQUEST['cadena'], $filtroActual);
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }

    //función para armar el archivo PDF dependiendo del filtro y/o cadena de búsqueda
    public function generarPDF($rows_REM, $cadena = "", $filtroActual = '1')
    {
        //require('../libraries/PDF library/fpdf16/fpdf.php');
        switch ($filtroActual) {
            case '1':
                $filename = "Vista general";
                break;
            case '2':
                $filename = "Peticionarios";
                break;
            case '3':
                $filename = "Ubicación de los hechos";
                break;
            case '4':
                $filename = "Elementos participantes";
                break;
            case '5':
                $filename = "Ubicación de la detención";
                break;
            case '6':
                $filename = "Objetos asegurados";
                break;
            case '7':
                $filename = "Armas aseguradas";
                break;
            case '8':
                $filename = "Drogas aseguradss";
                break;
            case '9':
                $filename = "Accesorios detenido";
                break;
            case '10':
                $filename = "Contacto detenido";
                break;
            case '11':
                $filename = "Adicción detenido";
                break;
            case '12':
                $filename = "Señas Particulares";
                break;
            case '13':
                $filename = "Registros por validar";
                break;
            case '14':
                $filename = "Registros validados";
                break;
            case '15':
                $filename = "Vehículos asegurados";
                break;
        }

        $data['subtitulo']      = 'Remisiones: ' . $filename;

        if ($cadena != "") {
            $data['msg'] = 'todos los registros de Remisiones con filtro: ' . $cadena . '';
        } else {
            $data['msg'] = 'todos los registros de Remisiones';
        }

        //---Aquí va la info según sea el filtro de ED seleccionado
        switch ($filtroActual) {
            case '1': //vista general
                $data['columns'] =  [
                    'Ficha',
                    'Núm. Remisión',
                    'Fecha y Hora',
                    'Detenido',
                    'Domicilio Detenido',
                    'Remitido a',
                    'Folio 911'
                ];
                $data['field_names'] = [
                    'Ficha',
                    'No_Remision',
                    'Fecha_Hora',
                    'Nombre_Detenido',
                    'Domicilio_Detenido',
                    'Instancia',
                    'Folio_911'
                ];
                break;
            case '2': //peticionarios
                $data['columns'] =  [
                    'Ficha',
                    'Núm. Remisión',
                    'Fecha y Hora',
                    'Peticionario',
                    'Domicilio Peticionario',
                    'Detenido remitido a',
                    'Folio 911'
                ];
                $data['field_names'] = [
                    'Ficha',
                    'No_Remision',
                    'Fecha_Hora',
                    'Nombre_Peticionario',
                    'Domicilio_Peticionario',
                    'Instancia',
                    'Folio_911'
                ];
                break;
            case '3': //ubicación de los hechos
                $data['columns'] =  [
                    'Ficha',
                    'Núm. Remisión',
                    'Fecha y Hora',
                    'Ubicación Hechos',
                    'Detenido',
                    'Remitido a',
                    'Folio 911'
                ];
                $data['field_names'] = [
                    'Ficha',
                    'No_Remision',
                    'Fecha_Hora',
                    'Ubicacion_Hechos',
                    'Nombre_Detenido',
                    'Instancia',
                    'Folio_911'
                ];
                break;
            case '4': //elementos participantes 
                $data['columns'] =  [
                    'Ficha',
                    'Núm. Remisión',
                    'Fecha y Hora',
                    'Detenido',
                    'Elemento',
                    'Cargo',
                    'Placa',
                    'Unidad',
                    'Llamado'
                ];
                $data['field_names'] = [
                    'Ficha',
                    'No_Remision',
                    'Fecha_Hora',
                    'Nombre_Detenido',
                    'Nombre_Elemento',
                    'Cargo',
                    'Placa',
                    'No_Unidad',
                    'Tipo_Llamado'
                ];
                foreach ($rows_REM as $key => $row) {
                    $auxllamado = ($row->Tipo_Llamado == '0') ? "En apoyo" : "Primer respondiente";
                    $rows_REM[$key]->Tipo_Llamado = $auxllamado;
                }
                break;
            case '5': //ubicación de la detención 
                $data['columns'] =  [
                    'Ficha',
                    'Núm. Remisión',
                    'Fecha y Hora',
                    'Detenido',
                    'Domicilio Detenido',
                    'Ubicación Detención',
                    'Remitido a'
                ];
                $data['field_names'] = [
                    'Ficha',
                    'No_Remision',
                    'Fecha_Hora',
                    'Nombre_Detenido',
                    'Domicilio_Detenido',
                    'Ubicacion_Detencion',
                    'Instancia'
                ];
                break;
            case '6': //objetos aseurados
                $data['columns'] =  [
                    'Ficha',
                    'Núm. Remisión',
                    'Fecha y Hora',
                    'Detenido',
                    'Objeto',
                    'Cantidad',
                    'Remitido a'
                ];
                $data['field_names'] = [
                    'Ficha',
                    'No_Remision',
                    'Fecha_Hora',
                    'Nombre_Detenido',
                    'Descripcion_Objeto',
                    'Cantidad',
                    'Instancia'
                ];
                break;
            case '7': //armas aseguradas
                $data['columns'] =  [
                    'Ficha',
                    'Núm. Remisión',
                    'Fecha y Hora',
                    'Detenido',
                    'Tipo Arma',
                    'Característica',
                    'Descripción',
                    'Cantidad'
                ];
                $data['field_names'] = [
                    'Ficha',
                    'No_Remision',
                    'Fecha_Hora',
                    'Nombre_Detenido',
                    'Tipo_Arma',
                    'Caracteristica',
                    'Descripcion_Arma',
                    'Cantidad'
                ];
                break;
            case '8': //drogas aseguradas
                $data['columns'] =  [
                    'Ficha',
                    'Núm. Remisión',
                    'Fecha y Hora',
                    'Detenido',
                    'Tipo droga',
                    'Cantidad',
                    'Descripción'
                ];
                $data['field_names'] = [
                    'Ficha',
                    'No_Remision',
                    'Fecha_Hora',
                    'Nombre_Detenido',
                    'Tipo_Droga',
                    'Cantidad',
                    'Descripcion_Droga'
                ];
                foreach ($rows_REM as $key => $row) {
                    $auxCantidad = $row->Cantidad . " " . $row->Unidad;
                    $rows_REM[$key]->Cantidad = $auxCantidad;
                }
                break;
            case '9': //accesorios detenido
                $data['columns'] =  [
                    'Ficha',
                    'Núm. Remisión',
                    'Fecha y Hora',
                    'Detenido',
                    'Tipo accesorio',
                    'Descripción',
                    'Remitido a'
                ];
                $data['field_names'] = [
                    'Ficha',
                    'No_Remision',
                    'Fecha_Hora',
                    'Nombre_Detenido',
                    'Tipo_Accesorio',
                    'Descripcion',
                    'Instancia'
                ];
                break;
            case '10': //contacto detenido
                $data['columns'] =  [
                    'Ficha',
                    'Núm. Remisión',
                    'Fecha y Hora',
                    'Detenido',
                    'Contacto',
                    'Parentesco',
                    'Teléfono'
                ];
                $data['field_names'] = [
                    'Ficha',
                    'No_Remision',
                    'Fecha_Hora',
                    'Nombre_Detenido',
                    'Nombre_Contacto',
                    'Parentesco',
                    'Telefono_Contacto'
                ];
                break;
            case '11': //adicción detenido
                $data['columns'] =  [
                    'Ficha',
                    'Núm. Remisión',
                    'Fecha y Hora',
                    'Detenido',
                    'Adicción',
                    'Roba para consumo?',
                    'Frecuencia',
                    'Tiempo consumo'
                ];
                $data['field_names'] = [
                    'Ficha',
                    'No_Remision',
                    'Fecha_Hora',
                    'Nombre_Detenido',
                    'Nombre_Adiccion',
                    'Robo_Para_Consumo',
                    'Frecuencia_Consumo',
                    'Tiempo_Consumo'
                ];
                foreach ($rows_REM as $key => $row) {
                    $auxRoboConsumo = ($row->Robo_Para_Consumo) ? 'Sí' : 'No';
                    $rows_REM[$key]->Robo_Para_Consumo = $auxRoboConsumo;
                }
                break;
            case '12': //tatuajes
                $data['columns'] =  [
                    'Ficha',
                    'Núm. Remisión',
                    'Tipo',
                    'Fecha y Hora',
                    'Detenido',
                    'Perfil',
                    'Ubicación Corporal',
                    'Color',
                    'Clasificación',
                    'Descripción'
                ];
                $data['field_names'] = [
                    'No_Ficha',
                    'No_Remision',
                    'Fecha_Hora',
                    'Nombre_Detenido',
                    'Perfil',
                    'Ubicacion_Corporal',
                    'Color',
                    'Clasificacion',
                    'Descripcion'
                ];
                foreach ($rows_REM as $key => $row) {
                    $auxColor = ($row->Color) ? 'Sí' : 'No';
                    $rows_REM[$key]->Color = $auxColor;
                }
                break;
            case '13': //registros por validar (o terminar de validar)
                $data['columns'] =  [
                    'Ficha',
                    'Núm. Remisión',
                    'Fecha y Hora',
                    'Detenido',
                    'Domicilio Detenido',
                    'Remitido a',
                    'Folio 911'
                ];
                $data['field_names'] = [
                    'Ficha',
                    'No_Remision',
                    'Fecha_Hora',
                    'Nombre_Detenido',
                    'Domicilio_Detenido',
                    'Instancia',
                    'Folio_911'
                ];
                break;
            case '14': //registros validados completamente
                $data['columns'] =  [
                    'Ficha',
                    'Núm. Remisión',
                    'Fecha y Hora',
                    'Detenido',
                    'Domicilio Detenido',
                    'Remitido a',
                    'Folio 911'
                ];
                $data['field_names'] = [
                    'Ficha',
                    'No_Remision',
                    'Fecha_Hora',
                    'Nombre_Detenido',
                    'Domicilio_Detenido',
                    'Instancia',
                    'Folio_911'
                ];
                break;
            case '15': //vehiculos asegurados
                $data['columns'] =  [
                    'Núm. Remisión',
                    'Fecha',
                    'Forma Aseguramiento',
                    'Grupo Zona',
                    'Marca',
                    'Tipo',
                    'Modelo',
                    'Placas',
                    'Núm. Serie',
                    'Color',
                    'Observaciones'
                ];
                $data['field_names'] = [
                    'No_Remision',
                    'Fecha_Hora',
                    'Forma_Detencion',
                    'Zona_Sector',
                    'Marca',
                    'Tipo_Vehiculo',
                    'Modelo',
                    'Placa_Vehiculo',
                    'No_Serie',
                    'Color',
                    'Observacion_Vehiculo'
                ];

                break;
        }
        //---fin de la info del ED

        $data['rows'] = $rows_REM;
        //se carga toda la plantilla con la información enviada por parámetro
        $plantilla = MY_PDF::getPlantilla($data);
        //se carga el css de la plantilla
        $css = file_get_contents(base_url . 'public/css/template/pdf_style.css');
        // Create an instance of the class:
        $mpdf = new \Mpdf\Mpdf([]);
        // se inserta el css y html cargado
        $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($plantilla, \Mpdf\HTMLParserMode::HTML_BODY);
        // se muestra en pantalla
        $mpdf->Output();


        //return $pdf->Output('','S'); //se retorna el pdf en forma de string para mostrar en el navegador
    }

    //funcion para borrar variable sesión para filtro de rangos de fechas
    public function removeRangosFechasSesion()
    {

        if (isset($_REQUEST['filtroActual'])) {
            unset($_SESSION['userdata']->rango_inicio_rem);
            unset($_SESSION['userdata']->rango_fin_rem);

            header("Location: " . base_url . "Remisiones/index/?filtro=" . $_REQUEST['filtroActual']);
            exit();
        } else {
            header("Location: " . base_url . "Cuenta");
            exit();
        }
    }

    //función que filtra las columnas deseadas por el usuario
    public function generateDropdownColumns($filtro = 1)
    {
        //parte de permisos

        $dropDownColumn = '';
        //generación de dropdown dependiendo del filtro
        switch ($filtro) {
            case '1':
                $campos = ['Ficha', 'Núm. Remisión', 'Fecha y Hora', 'Detenido', 'Ubicación Hechos', 'Zona', 'Vector', 'Registró', 'Remitido a', 'Folio 911'];
                break;
            case '2':
                $campos = ['Ficha', 'Núm. Remisión', 'Fecha y Hora', 'Peticionario', 'Domicilio Peticionario', 'Instancia', 'Folio 911'];
                break;
            case '3':
                $campos = ['Ficha', 'Núm. Remisión', 'Fecha y Hora', 'Ubicación Hechos', 'Instancia', 'Folio 911'];
                break;
            case '4':
                $campos = ['Ficha', 'Núm. Remisión', 'Fecha y Hora', 'Detenido', 'Elemento', 'Cargo', 'Placa', 'Unidad', 'Llamado'];
                break;
            case '5':
                $campos = ['Ficha', 'Núm. Remisión', 'Fecha y Hora', 'Detenido', 'Domicilio Detenido', 'Ubicación Detención'];
                break;
            case '6':
                $campos = ['Ficha', 'Núm. Remisión', 'Fecha y Hora', 'Detenido', 'Objeto', 'Cantidad'];
                break;
            case '7':
                $campos = ['Ficha', 'Núm. Remisión', 'Fecha y Hora', 'Detenido', 'Tipo Arma', 'Caracteristica', 'Descripción', 'Cantidad'];
                break;
            case '8':
                $campos = ['Ficha', 'Núm. Remisión', 'Fecha y Hora', 'Detenido', 'Tipo droga', 'Cantidad', 'Descripción'];
                break;
            case '9':
                $campos = ['Ficha', 'Núm. Remisión', 'Fecha y Hora', 'Detenido', 'Tipo accesorio', 'Descripción'];
                break;
            case '10':
                $campos = ['Ficha', 'Núm. Remisión', 'Fecha y Hora', 'Detenido', 'Contacto', 'Parentesco', 'Teléfono', 'Edad'];
                break;
            case '11':
                $campos = ['Ficha', 'Núm. Remisión', 'Fecha y Hora', 'Detenido', 'Adicción', '¿Roba para consumir?', 'Frecuencia', 'Tiempo'];
                break;
            case '12':
                $campos = ['Ficha', 'Núm. Remisión', 'Tipo', 'Fecha y Hora', 'Detenido', 'Perfil', 'Ubicación Corporal', 'Color', 'Clasificación', 'Descripción', 'Imagen'];
                break;
            case '13':
                $campos = ['Ficha', 'Núm. Remisión', 'Fecha y Hora', 'Detenido', 'Domicilio Detenido', 'Registró', 'Remitido a', 'Folio 911'];
                break;
            case '14':
                $campos = ['Ficha', 'Núm. Remisión', 'Fecha y Hora', 'Detenido', 'Domicilio Detenido', 'Registró', 'Remitido a', 'Folio 911'];
                break;
            case '15':
                $campos = ['Ficha', 'Núm. Remisión', 'Fecha y Hora', 'Situación', 'Tipo Vehículo', 'Marca', 'Modelo', 'Núm. Serie', 'Placa'];
                break;
        }
        //gestión de cada columna
        $ind = 1;
        foreach ($campos as $campo) {
            $checked = ($_SESSION['userdata']->columns_REM['column' . $ind] == 'show') ? 'checked' : '';
            $dropDownColumn .= ' <div class="form-check">
                                    <input class="form-check-input checkColumns" type="checkbox" value="' . $_SESSION['userdata']->columns_REM['column' . $ind] . '" onchange="hideShowColumn(this.id);" id="column' . $ind . '" ' . $checked . '>
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

    //función para checar los cambios de filtro y poder asignar los valores correspondientes de las columnas a la session
    public function setColumnsSession($filtroActual = 1)
    {
        //si el filtro existe y esta dentro de los parámetros continua
        if (isset($_SESSION['userdata']->filtro_REM) && $_SESSION['userdata']->filtro_REM >= MIN_FILTRO_REM && $_SESSION['userdata']->filtro_REM <= MAX_FILTRO_REM) {
            //si cambia el filtro se procde a cambiar los valores de las columnas que contiene el filtro seleccionado
            if ($_SESSION['userdata']->filtro_REM != $filtroActual) {
                $_SESSION['userdata']->filtro_REM = $filtroActual;
                unset($_SESSION['userdata']->columns_REM); //se borra las columnas del anterior filtro
                //se asignan las nuevas columnas y por default se muestran todas (atributo show)
                for ($i = 0; $i < $this->numColumnsRem[$_SESSION['userdata']->filtro_REM - 1]; $i++)
                    $_SESSION['userdata']->columns_REM['column' . ($i + 1)] = 'show';
            }
        } else { //si no existe el filtro entonces se inicializa con el primero por default
            $_SESSION['userdata']->filtro_REM = $filtroActual;
            unset($_SESSION['userdata']->columns_REM);
            for ($i = 0; $i < $this->numColumnsRem[$_SESSION['userdata']->filtro_REM - 1]; $i++)
                $_SESSION['userdata']->columns_REM['column' . ($i + 1)] = 'show';
        }
        //echo "filtro: ".var_dump($_SESSION['userdata']->filtro_REM)."<br>br>";
        //echo "columns: ".var_dump($_SESSION['userdata']->columns_REM)."<br>br>";
    }

    //función fetch que actualiza los valores de las columnas para la session
    public function setColumnFetch()
    {
        if (isset($_POST['columName']) && isset($_POST['valueColumn'])) {
            $_SESSION['userdata']->columns_REM[$_POST['columName']] = $_POST['valueColumn'];
            echo json_encode("ok");
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }

    public function generarIPH1()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }
        //validando url
        if (!isset($_GET['no_remision']) || !is_numeric($_GET['no_remision']) || !isset($_GET['no_ficha']) || !is_numeric($_GET['no_ficha'])) { //numero de catálogo
            header("Location: " . base_url . "Inicio");
            exit();
        }
        //comprobando que exista el registro con el no_remision de la url
        $remision = $this->Remision->getIPH1($_GET['no_ficha'], $_GET['no_remision']);
        if (!$remision) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $data = [
            'titulo'    => 'Primer formato',
            'extra_css' => '<link rel="stylesheet" href="' . base_url . 'public/css/system/remisiones/iph_css.css">',
        ];

        //obteniendo la info de la reisión
        $data['info_remision'] = $remision;
        //se manda todo a la vista de IPH
        $this->view("system/remisiones/IPH1_View", $data);
    }


    /*-----------FUNCIONES PARA OBTENER LA INFO DE CADA TAB-----------*/
    public function getPrincipales()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }
        //echo $_POST['no_remision'];
        if (isset($_POST['no_remision'])) {
            $no_remision = $_POST['no_remision'];
            $data = $this->Remision->getPrincipales($no_remision);
            $data_aux = $this->Remision->getDetitosByCadena($this->Remision->getEntidad($data->Instancia));
            $data->faltas_Delitos = '';
            foreach ($data_aux as $row) {
                $data->faltas_Delitos .= '<option value="' . $row->Descripcion . '">' . $row->Descripcion . '</option>';
            }
            echo json_encode($data);
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }


    public function getPeticionario()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        if (isset($_POST['no_ficha'])) {
            $no_ficha = $_POST['no_ficha'];
            $data = $this->Remision->getPeticionario($no_ficha);
            echo json_encode($data);
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }

    public function getUbicacionH()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        if (isset($_POST['no_ficha']) && isset($_POST['no_remision'])) {
            $no_ficha = $_POST['no_ficha'];
            $no_remision = $_POST['no_remision'];
            $auxData = $this->Remision->getUbicacionH($no_ficha, $no_remision);
            $data['ubicacion_h'] = $auxData['ubicacion_h'];
            $data['faltas_delitos'] = $auxData['faltas_delitos'];
            $data['remisiones_ficha'] = $auxData['remisiones_ficha'];
            echo json_encode($data);
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }

    public function getUbicacionD()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        if (isset($_POST['no_remision'])) {
            $no_remision = $_POST['no_remision'];
            $data = $this->Remision->getUbicacionD($no_remision);
            echo json_encode($data);
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }

    public function getMediaFiliacion()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        if (isset($_POST['no_remision'])) {
            $no_remision = $_POST['no_remision'];
            $data = $this->Remision->getMediaFiliacion($no_remision);
            echo json_encode($data);
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }
    //Funcion agregada para mantener por separado la media filiacion y los contactos conocidos del detenido
    public function getContactoDetenido()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        if (isset($_POST['no_remision'])) {
            $no_remision = $_POST['no_remision'];
            $data = $this->Remision->getContactoDetenido($no_remision);
            echo json_encode($data);
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }

    public function getElementosParticipantes()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        if (isset($_POST['no_remision'])) {
            $no_remision = $_POST['no_remision'];
            $data = $this->Remision->getElementosParticipantes($no_remision);
            echo json_encode($data);
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }

    public function getObjetosRecuperados()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        if (isset($_POST['no_remision']) && isset($_POST['no_ficha'])) {
            $no_remision = $_POST['no_remision'];
            $no_ficha = $_POST['no_ficha'];
            $data = $this->Remision->getObjetosRecuperados($no_remision, $no_ficha);
            clearstatcache();
            echo json_encode($data);
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }

    public function getFotosHuellas()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[2] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['remision'])) {
                $data = $this->Remision->getFotosHuellas($_POST);
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

    public function getAllFotosHuellas()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[2] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['no_remision'])) {
                $no_remision = $_POST['no_remision'];
                $success = $this->Remision->getAllFotosHuellas($no_remision);
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

    public function getSenasParticulares()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        if (isset($_POST['no_remision'])) {
            $no_remision = $_POST['no_remision'];
            $data = $this->Remision->getSenasParticulares($no_remision);
            clearstatcache();
            echo json_encode($data);
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }

    public function getEntrevistaDetenido()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        if (isset($_POST['no_remision'])) {
            $no_remision = $_POST['no_remision'];
            $data = $this->Remision->getEntrevistaDetenido($no_remision);
            echo json_encode($data);
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }

    public function getNarrativas()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        if (isset($_POST['no_remision'])) {
            $no_remision = $_POST['no_remision'];
            $no_ficha = $_POST['no_ficha'];
            $data = $this->Remision->getNarrativas($no_remision, $no_ficha);
            echo json_encode($data);
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }

    //--------------------------------------Funciones para modificar remisiones------------------------------------------

    public function ModificarRemision()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[1] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {

            if (isset($_POST['boton_principales'])) {
                $k = 0;
                if ($_POST['911_principales'] != '')
                    $valid[$k++] = $data_p['Folio911Error']     = $this->FV->validate($_POST,   '911_principales', 'required | numeric');
                $valid[$k++] = $data_p['fechaError']            =   $this->FV->validate($_POST, 'fecha_principales', 'required | date');
                $valid[$k++] = $data_p['horaError']             =   $this->FV->validate($_POST, 'hora_principales', 'required | time');
                $valid[$k++] = $data_p['nombreError']           =   $this->FV->validate($_POST, 'Nombre_principales', 'required');
                $valid[$k++] = $data_p['apellidoPError']        =   $this->FV->validate($_POST, 'appPaterno_principales', 'required');

                if ($_POST['edad_principales'] != '')
                    $valid[$k++] = $data_p['edadError']             =   $this->FV->validate($_POST, 'edad_principales', 'numeric | length[2]');

                $valid[$k++] = $data_p['procedenciaError']      =   $this->FV->validate($_POST, 'procedencia_principales', 'required');

                if ($_POST['CURP_principales'] != '')
                    $valid[$k++] = $data_p['curpError']             =   $this->FV->validate($_POST, 'CURP_principales', 'required | length[18]');

                $municipio = ($_POST['Municipio'] == '') ? 'PUEBLA' : $_POST['Municipio'];
                $_POST['Municipio'] = $municipio;

                if ($_POST['CP'] != '')
                    $valid[$k++] = $data_p['cpError']               =   $this->FV->validate($_POST, 'CP', 'numeric | length[5]');

                if ($_POST['pertenencias_rem'] != '')
                    $valid[$k++] = $data_p['pertenenciasError']     =   $this->FV->validate($_POST, 'pertenencias_rem', 'max_length[600]');

                if ($_POST['FechaNacimiento_principales'] != '')
                    $valid[$k++] = $data_p['fecha_nacimientoError'] =   $this->FV->validate($_POST, 'FechaNacimiento_principales', 'date');

                if ($_POST['RFC_principales'] != '')
                    $valid[$k++] = $data_p['rfcError']          =   $this->FV->validate($_POST, 'RFC_principales', 'length[10]');


                if (strlen($_POST['Telefono_principales']) == 10) {
                    if ($_POST['imei_1_principales'] != '')
                        $valid[$k++] = $data_p['imei1Error']    =   $this->FV->validate($_POST, 'imei_1_principales', 'min_length[14] | max_length[16] | numeric');

                    if ($_POST['imei_2_principales'] != '')
                        $valid[$k++] = $data_p['imei2Error']    =   $this->FV->validate($_POST, 'imei_2_principales', 'min_length[14] | max_length[16] | numeric');
                }

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) {
                    $success_2 = $this->Remision->updatePrincipales($_POST);
                    if ($success_2['status']) {
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $this->Remision->updateGuardarTab($_POST['no_remision_principales'], 0);
                        $descripcion = 'Remisión: ' . $_POST['no_remision_principales'] . ' Tab: Datos principales';
                        $this->Remision->historial($user, $ip, 3, $descripcion);
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

    public function ModificarPeticionario()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[1] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['boton_peticionario'])) {

                $k = 0;
                $valid[$k++] = $data_p['peticionario_nombreError']         =  $this->FV->validate($_POST, 'peticionario_Nombres', 'max_length[50]');
                // $valid[$k++] = $data_p['peticionario_apaternoError']       =  $this->FV->validate($_POST, 'peticionario_appPaterno', 'required');
                if ($_POST['peticionario_Edad'] != '')
                    $valid[$k++] = $data_p['peticionario_edadError']           =  $this->FV->validate($_POST, 'peticionario_Edad', 'required | numeric | length[2]');

                // $valid[$k++] = $data_p['peticionario_procedenciaError']    =  $this->FV->validate($_POST, 'peticionario_Procedencia', 'required');

                if ($_POST['peticionario_Fecha_n'] != '')
                    $valid[$k++] = $data_p['peticionario_fechanError']         =  $this->FV->validate($_POST, 'peticionario_Fecha_n', 'date');

                $municipio = ($_POST['Municipio_peticionario'] == '') ? 'PUEBLA' : $_POST['Municipio_peticionario'];
                $_POST['Municipio_peticionario'] = $municipio;

                if ($_POST['CP_peticionario'] != '')
                    $valid[$k++] = $data_p['CP_peticionario_error']        =   $this->FV->validate($_POST, 'CP_peticionario', 'numeric | length[5]');

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) {

                    $success_2 = $this->Remision->updatePeticionario($_POST);

                    if ($success_2['status']) {
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $this->Remision->updateGuardarTab($_POST['no_remision_peticionario'], 1);

                        $descripcion = 'Remisión: ' . $_POST['no_remision_peticionario'] . ' Tab: Peticionario';
                        $this->Remision->historial($user, $ip, 3, $descripcion);
                        $data_p['status'] =  true;
                    } else {
                        $data_p['status'] =  false;
                        $data_p['error_message'] = $success_2['error_message'];
                    }
                    //$data_p['remitido'] = $success_2['remitido'];
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

    public function ModificarUbiacionH()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[1] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';

            echo json_encode($data_p);
        } else {
            if (isset($_POST['boton_ubicacionHechos'])) {

                $k = 0;

                $valid[$k++] = $data_p['ubicacionH_ColoniaError']       = $this->FV->validate($_POST, 'Colonia_hechos', 'required');
                $valid[$k++] = $data_p['ubicacionH_CalleError']         = $this->FV->validate($_POST, 'Calle_hechos', 'required');
                //$valid[$k++] = $data_p['ubicacionH_Calle2Error']        = $this->FV->validate($_POST, 'Calle2_hechos', 'required');
                $valid[$k++] = $data_p['ubicacionH_CoordYError']        = $this->FV->validate($_POST, 'cordY_hechos', 'required');
                $valid[$k++] = $data_p['ubicacionH_CoordXError']        = $this->FV->validate($_POST, 'cordX_hechos', 'required');
                if ($_POST['CP_hechos'] != '')
                    $valid[$k++] = $data_p['ubicacionH_CPError']        = $this->FV->validate($_POST, 'CP_hechos', 'numeric | length[5]');

                $valid[$k++] = $data_p['ubicacionH_HoraError']          = $this->FV->validate($_POST, 'hora_hechos', 'required | time');
                $valid[$k++] = $data_p['ubicacionH_ParticipantesError'] = $this->FV->validate($_POST, 'participantes_hechos', 'required | numeric');
                $valid[$k++] = $data_p['ubicacionH_RemitidoPorError']   = $this->FV->validate($_POST, 'RemitidoPor', 'required');
                $valid[$k++] = $data_p['ubicacionH_FaltaDelitoError'] = ((count(json_decode($_POST['delito_1']))) == 0) ? 'Se requiere mínimo una falta / delito' : '';
                $valid[$k++] = $data_p['Falta_Delito_Tipo_error'] = $this->FV->validate($_POST, 'Falta_Delito_Tipo', 'required | length[1]');


                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;
                if ($success) {
                    // $data_p['status_server_validation'] =  'success';
                    $success_2 = $this->Remision->updateUbicacionH($_POST);
                    // $data_p['status_insertion'] = $success_2['status'];
                    if ($success_2['status']) {
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $this->Remision->updateGuardarTab($_POST['no_remision_ubicacionHechos'], 2);
                        $descripcion = 'Remisión: ' . $_POST['no_remision_ubicacionHechos'] . ' Tab: Ubicación de los hechos';
                        $this->Remision->historial($user, $ip, 3, $descripcion);
                        $data_p['status'] =  true;
                    } else {
                        $data_p['status'] =  false;
                        $data_p['error_message'] = $success_2['error_message'];
                    }
                } else {
                    $data_p['status'] =  false;
                }
                echo json_encode($data_p);
                // echo json_encode( count($data_FaltaDelito) );
            } else {
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';

                echo json_encode($data_p);
            }
        }
    }

    public function ModificarUbicacionD()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[1] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';

            echo json_encode($data_p);
        } else {

            if (isset($_POST['boton_ubicacionDetencion'])) {

                $k = 0;

                $valid[$k++] = $data_p['ubicacionD_fechaError']         = $this->FV->validate($_POST, 'fecha_detencion', 'required | date');
                $valid[$k++] = $data_p['ubicacionD_ColoniaError']       = $this->FV->validate($_POST, 'Colonia_detencion', 'required');
                $valid[$k++] = $data_p['ubicacionD_CalleError']         = $this->FV->validate($_POST, 'Calle_1_detencion', 'required');
                //$valid[$k++] = $data_p['ubicacionD_Calle2Error']        = $this->FV->validate($_POST, 'Calle_2_detencion' , 'required');
                $valid[$k++] = $data_p['ubicacionD_CoordYError']        = $this->FV->validate($_POST, 'cordY_detencion', 'required');
                $valid[$k++] = $data_p['ubicacionD_CoordXError']        = $this->FV->validate($_POST, 'cordX_detencion', 'required');

                if ($_POST['CP_detencion'] != '')
                    $valid[$k++] = $data_p['ubicacionD_CPError']        = $this->FV->validate($_POST, 'CP_detencion', 'numeric | length[5]');

                $valid[$k++] = $data_p['ubicacionD_HoraError']          = $this->FV->validate($_POST, 'hora_detencion', 'required | time');

                if ($_POST['observaciones_detencion'])
                    $valid[$k++] = $data_p['ubicacionD_ObservacionesError'] = $this->FV->validate($_POST, 'observaciones_detencion', 'max_length[600]');

                /* Se comenta esta funcion ya que la validacion de los campos para vehiculos se hacen ahroa al cargar uno nuevo
                if ($_POST['vehiculos'] == 'Si') {

                    $valid[$k++] = $data_p['Tipo_Vehiculo_error']           = $this->FV->validate($_POST, 'Tipo_Vehiculo', 'required');
                    $valid[$k++] = $data_p['Placa_Vehiculo_error']          = $this->FV->validate($_POST, 'Placa_Vehiculo', 'required');
                    $valid[$k++] = $data_p['Marca_error']                   = $this->FV->validate($_POST, 'Marca', 'required');
                    $valid[$k++] = $data_p['Modelo_error']                  = $this->FV->validate($_POST, 'Modelo', 'required');
                    $valid[$k++] = $data_p['Color_error']                   = $this->FV->validate($_POST, 'Color', 'required');
                    $valid[$k++] = $data_p['Senia_Particular_error']        = $this->FV->validate($_POST, 'Senia_Particular', 'required');
                    $valid[$k++] = $data_p['No_Serie_error']                = $this->FV->validate($_POST, 'No_Serie', 'required');
                    $valid[$k++] = $data_p['Procedencia_Vehiculo_error']    = $this->FV->validate($_POST, 'Procedencia_Vehiculo', 'required');
                    $valid[$k++] = $data_p['Observacion_Vehiculo_error']    = $this->FV->validate($_POST, 'Observacion_Vehiculo', 'required | max_length[450]');
                } */



                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) {
                    $success_2 = $this->Remision->updateUbicacionD($_POST);
                    if ($success_2['status']) {
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $this->Remision->updateGuardarTab($_POST['no_remision_detencion'], 6);
                        $descripcion = 'Remisión: ' . $_POST['no_remision_detencion'] . ' Tab: Ubicación de la detención';
                        $this->Remision->historial($user, $ip, 3, $descripcion);
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

    public function ModificarMediaF()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[1] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';

            echo json_encode($data_p);
        } else {
            if (isset($_POST['boton_mediaFiliacion'])) {

                $k = 0;

                $valid[$k++] = $data_p['filiacion_EstaturaError']       = $this->FV->validate($_POST, 'Estarura', 'required | numeric');

                /*if ($_POST['infoConocido'] == 'Si') {
                    $valid[$k++] = $data_p['conocido_nombreError']      = $this->FV->validate($_POST, 'Nombre_conocido', 'required');
                    $valid[$k++] = $data_p['conocido_apaternoError']    = $this->FV->validate($_POST, 'apaterno_conocido', 'required');
                    //$valid[$k++] = $data_p['conocido_amaternoError']    = $this->FV->validate($_POST, 'amaterno_conocido', 'required');
                    $valid[$k++] = $data_p['conocido_telefonoError']    = $this->FV->validate($_POST, 'telefono_conocido', 'required | numeric | length[10]');

                    if ($_POST['edad_conocido'] != 0)
                        $valid[$k++] = $data_p['conocido_edadError']       = $this->FV->validate($_POST, 'edad_conocido', 'numeric | length[2]');
                }*/

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) {
                    $success_2 = $this->Remision->updateMediaF($_POST);
                    /*Se añade updateContactoConocidos*/
                    $success_3 = $this->Remision->updateContactosConocidos($_POST);
                    if ($success_2['status']) {
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $this->Remision->updateGuardarTab($_POST['no_remision_mediaFiliacion'], 9);
                        $descripcion = 'Remisión: ' . $_POST['no_remision_mediaFiliacion'] . ' Tab: Media filación';
                        $this->Remision->historial($user, $ip, 3, $descripcion);
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

    public function updateElementosParticipantes()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[1] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';

            echo json_encode($data_p);
        } else {
            if (isset($_POST['elementos_participantes'])) {

                $ep = 0;

                $remision = $_POST['remision'];

                // $valid[$ep++] = $data_p['observacionesError'] = $this->FV->validate($_POST, 'observacionesElementos', 'required | max_length[600]');
                $valid[$ep++] = $data_p['policiaGuardiaError'] = $this->FV->validate($_POST, 'policiaDeGuardia', 'required');

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) {

                    $success_2 = $this->Remision->updateElementosParticipantes($_POST, $remision);

                    if ($success_2['status']) {
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $this->Remision->updateGuardarTab($remision, 3);
                        $descripcion = 'Remisión: ' . $remision . ' Tab: Elementos participantes';
                        $this->Remision->historial($user, $ip, 3, $descripcion);
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

    public function updateObjRecuperados()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[1] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';

            echo json_encode($data_p);
        } else {
            if (isset($_POST['objetos_recuperados'])) {
                $remision = $_POST['remision'];
                $ficha = $_POST['ficha'];
                $k = 0;
                /* Se comenta esta funcion ya que la validacion de los campos para vehiculos se hacen ahroa al cargar uno nuevo
                if ($_POST['vehiculos'] == 'Si') {

                    $valid[$k++] = $data_p['Tipo_Vehiculo_error']           = $this->FV->validate($_POST, 'Tipo_Vehiculo', 'required');
                    $valid[$k++] = $data_p['Placa_Vehiculo_error']          = $this->FV->validate($_POST, 'Placa_Vehiculo', 'required');
                    $valid[$k++] = $data_p['Marca_error']                   = $this->FV->validate($_POST, 'Marca', 'required');
                    $valid[$k++] = $data_p['Modelo_error']                  = $this->FV->validate($_POST, 'Modelo', 'required');
                    $valid[$k++] = $data_p['Color_error']                   = $this->FV->validate($_POST, 'Color', 'required');
                    $valid[$k++] = $data_p['Senia_Particular_error']        = $this->FV->validate($_POST, 'Senia_Particular', 'required');
                    $valid[$k++] = $data_p['No_Serie_error']                = $this->FV->validate($_POST, 'No_Serie', 'required');
                    $valid[$k++] = $data_p['Procedencia_Vehiculo_error']    = $this->FV->validate($_POST, 'Procedencia_Vehiculo', 'required');
                    $valid[$k++] = $data_p['Observacion_Vehiculo_error']    = $this->FV->validate($_POST, 'Observacion_Vehiculo', 'required | max_length[450]');
                }*/

                $success_2 = $this->Remision->updateObjRecuperados($_POST, $remision, $ficha);
                if ($success_2['status']) {
                    $this->Remision->updateGuardarTab($remision, 4);
                    $user = $_SESSION['userdata']->Id_Usuario;
                    $ip = $this->obtenerIp();
                    $descripcion = 'Remisión: ' . $remision . ' Tab: Objetos asegurados';
                    $this->Remision->historial($user, $ip, 3, $descripcion);
                    $data_p['status'] =  true;
                } else {
                    $data_p['status'] =  false;
                    $data_p['error_message'] = $success_2['error_message'];
                }

                echo json_encode($data_p);
            } else {
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';

                echo json_encode($data_p);
            }
        }
    }

    public function updateImgObjRecuperados()
    {
        if (isset($_POST['data'])) {

            $ficha = $_POST['ficha'];
            $date = date("Ymdhis");
            $type = $_FILES['file']['type'];
            $extension = explode("/", $type);

            $path_carpeta = BASE_PATH . "public/files/Remisiones/" . $ficha . "/ObjRecuperados/";
            $name_image = $ficha . '_obj.' . $extension[1];

            $success = $this->Remision->updateImgObjRecuperados($ficha, $name_image . '?v=' . $date);
            if ($success['status']) {
                $this->uploadImageFileRemisiones('file', $_FILES, $ficha, $path_carpeta, $name_image);
                $data_p['status'] = true;
                $data_p['nameFile'] = $name_image . '?v=' . $date;
            } else {
                $data_p['status'] =  false;
                $data_p['error_message'] = $success['error_message'];
            }

            echo json_encode($data_p);
        }
    }

    public function deleteImgObjRecuperados()
    {
        if (isset($_POST['btn_croquis'])) {
            $ficha = $_POST['ficha'];
            $path_carpeta = BASE_PATH . "public/files/Remisiones/" . $ficha . "/ObjRecuperados/";

            $success = $this->Remision->updateImgObjRecuperados($ficha,'');
            if ($success['status']) {
                $this->existContentFiles($path_carpeta);
                $data_p['status'] = true;
                echo json_encode($data_p);
            } else {
                $data_p['status'] = false;
                $data_p['error_message'] = $success['error_message'];
                echo json_encode($data_p);
            }
        } else {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';

            echo json_encode($data_p);
        }
    }

    private function existContentFiles($carpeta)
    {
        foreach (glob($carpeta . "*") as $archivos_carpeta) {
            if (is_dir($archivos_carpeta)) {
                rmDir_rf($archivos_carpeta);
            } else {
                unlink($archivos_carpeta);
            }
        }
        return true;
    }

    public function updateFotosHuellas()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[1] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';

            echo json_encode($data_p);
        } else {
            if (isset($_POST['captura_fyh'])) {

                $ficha = $_POST['ficha'];
                $remision = $_POST['remision'];
                $path_carpeta = BASE_PATH . "public/files/Remisiones/" . $ficha . "/FotosHuellas/" . $remision . "/";
                $name = $_FILES['file']['type'];
                $name = explode("/", $name);
                $name = $_POST['perfil'] . "." . $name[1];

                $success = $this->Remision->updateFotosyhuellas($_POST, $remision, $name);
                if($success['status']){
                    $result = $this->uploadImageFileRemisiones('file', $_FILES, $ficha, $path_carpeta, $name);
                    if($result){
                        $data_p['status'] =  true;
                        $data_p['nameFile'] = $success['nameFile'];
                    } else {
                        $data_p['status'] =  false;
                        $data_p['error_message'] = 'Hubo un error con la imagen. Imagenes aceptadas .jpeg, .png, .jpg,.PNG, .JPG, .JPEG';
                    }
                    $this->Remision->updateGuardarTab($remision, 5);
                    $user = $_SESSION['userdata']->Id_Usuario;
                    $ip = $this->obtenerIp();
                    $descripcion = 'Remisión: ' . $remision . ' Tab: Captura de fotos y huellas';
                    $this->Remision->historial($user, $ip, 3, $descripcion);
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

    public function deleteFotosHuellas()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[1] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';

            echo json_encode($data_p);
        } else {
            if (isset($_POST['deleteFile'])) {
                $remision = $_POST['remision'];
                $ficha = $_POST['ficha'];
                $path_carpeta = BASE_PATH . "public/files/Remisiones/" . $ficha . "/FotosHuellas/" . $remision . "/";
                $nameDir = $_POST['nameDir'];

                $success = $this->Remision->deleteFotosHuellas($remision, $_POST['perfil']);
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



    public function updateSenasParticulares()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[1] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';

            echo json_encode($data_p);
        } else {
            if (isset($_POST['senas_particulares'])) {

                $sp = 0;

                $ficha = $_POST['ficha'];
                $remision = $_POST['remision'];

                $path_carpeta = BASE_PATH . "public/files/Remisiones/" . $ficha . "/SenasParticulares/" . $remision . "/";

                $senas = json_decode($_POST['senas_table']);

                $valid[$sp++] = $data_p['tipoVestimentaError'] = $this->FV->validate($_POST, 'tipoVestimenta', 'required');
                $valid[$sp++] = $data_p['descripcionVestiementaError'] = $this->FV->validate($_POST, 'descripcionVestimenta', 'required');

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) {
                    $success_2 = $this->Remision->updateSenasParticulares($_POST, $remision);
                    if ($success_2['status']) {
                        foreach (glob($path_carpeta . "/*") as $archivos_carpeta) {
                            if (is_dir($archivos_carpeta)) {
                                rmDir_rf($archivos_carpeta);
                            } else {
                                unlink($archivos_carpeta);
                            }
                        }
                        foreach ($senas as $sena) {
                            if ($sena->row->typeImage == 'File') {
                                $type = $_FILES[$sena->row->nameImage]['type'];
                                $extension = explode("/", $type);
                                $result = $this->uploadImageFileRemisiones($sena->row->nameImage, $_FILES, $ficha, $path_carpeta, $sena->row->nameImage . "." . $extension[1]);
                            }
                            if ($sena->row->typeImage == 'Photo') {
                                $result = $this->uploadImagePhotoRemisiones($sena->row->image, $ficha, $path_carpeta, $path_carpeta . $sena->row->nameImage . ".png");
                            }
                        }

                        $this->Remision->updateGuardarTab($remision, 7);
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $descripcion = 'Remisión: ' . $remision . ' Tab: Señas particulares';
                        $this->Remision->historial($user, $ip, 3, $descripcion);
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

    public function updateEntrevistaDetenido()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[1] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';

            echo json_encode($data_p);
        } else {
            if (isset($_POST['entrevista_detenido'])) {

                $ed = 0;

                $remision = $_POST['remision'];

                $adicciones = $_POST['adicciones_table'];
                $faltasAdministrativas = $_POST['faltasAdministrativas_table'];
                $antecedentesPenales = $_POST['antecedentesPenales_table'];

                // $valid[$ed++] = $data_p['probableVinculacionError'] = $this->FV->validate($_POST, 'probableVinculacion', 'required');
                // $valid[$ed++] = $data_p['motivoDelinquirError'] = $this->FV->validate($_POST, 'motivoDelinquir', 'required');
                // $valid[$ed++] = $data_p['modusOperandiError'] = $this->FV->validate($_POST, 'modusOperandi', 'required');

                $success = true;
                /*  foreach ($valid as $val)
                    $success &= ($val == '') ? true : false; */


                if ($success) {
                    $success_2 = $this->Remision->updateEntrevistaDetenido($_POST, $remision);
                    $data_p['status_insertion'] = $success_2;
                    if ($success_2['status']) {
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $this->Remision->updateGuardarTab($remision, 8);
                        $descripcion = 'Remisión: ' . $remision . ' Tab: Entrevista del detenido';
                        $this->Remision->historial($user, $ip, 3, $descripcion);
                        $data_p['status'] =  true;
                    } else {
                        $data_p['status'] =  false;
                        $data_p['error_message'] = $success_2['error_message'];
                    }
                } else {
                    $data_p['status'] =  'failed';
                }

                echo json_encode($data_p);
            } else {
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';

                echo json_encode($data_p);
            }
        }
    }

    public function updateValidarTab()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[1] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        if (isset($_POST['num_tab'])) {

            if ($_SESSION['userdata']->Modo_Admin == 1) {
                $data_p['validacionRol'] = 'Admin';
            } else {
                if ($_SESSION['userdata']->Nivel_User == 1) {
                    $data_p['validacionRol'] = 'Validacion';
                } else {
                    $data_p['validacionRol'] = 'User';
                }
            }

            $remision = $_POST['remision'];
            $tab = $_POST['num_tab'];
            $user = $_SESSION['userdata']->Id_Usuario;
            $ip = $this->obtenerIp();
            $success = $this->Remision->updateValidarTab($remision, $tab, $user, $ip);
            if ($success) {
                $user = $_SESSION['userdata']->Id_Usuario;
                $ip = $this->obtenerIp();
                switch ($tab) {
                    case '0':
                        $tab = 'Datos principales';
                        break;
                    case '1':
                        $tab = 'Peticionario';
                        break;
                    case '2':
                        $tab = 'Ubicación de los hechos';
                        break;
                    case '3':
                        $tab = 'Elementos participantes';
                        break;
                    case '4':
                        $tab = 'Objetos recuperados';
                        break;
                    case '5':
                        $tab = 'Captura de fotos y huellas';
                        break;
                    case '6':
                        $tab = 'Ubicación de la detención';
                        break;
                    case '7':
                        $tab = 'Señas particulares';
                        break;
                    case '8':
                        $tab = 'Entrevista del detenido';
                        break;
                    case '9':
                        $tab = 'Media filicación';
                        break;
                    case '10':
                        $tab = 'Narrativas';
                        break;
                }
                $descripcion = 'Remisión: ' . $remision . ' Tab: ' . $tab . '';
                $this->Remision->historial($user, $ip, 4, $descripcion);
            }

            $data_p['status'] = $success;

            echo json_encode($data_p);
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }

    public function getTabsValidados()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[1] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';

            echo json_encode($data_p);
        } else {
            if (isset($_POST['remision'])) {

                $remision = $_POST['remision'];
                if ($_SESSION['userdata']->Modo_Admin == 1) {
                    $data_p['validacionRol'] = 'Admin';
                } else {
                    if ($_SESSION['userdata']->Nivel_User == 1) {
                        $data_p['validacionRol'] = 'Validacion';
                    } else {
                        $data_p['validacionRol'] = 'User';
                    }
                }

                $success = $this->Remision->getTabsValidados($remision);
                $data_p['data'] = $success;

                echo json_encode($data_p);
            } else {
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';

                echo json_encode($data_p);
            }
        }
    }

    public function getTabsGuardados()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[1] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        if (isset($_POST['remision'])) {

            $remision = $_POST['remision'];
            if ($_SESSION['userdata']->Modo_Admin == 1) {
                $data_p['validacionRol'] = 'Admin';
            } else {
                if ($_SESSION['userdata']->Nivel_User == 1) {
                    $data_p['validacionRol'] = 'Validacion';
                } else {
                    $data_p['validacionRol'] = 'User';
                }
            }

            $success = $this->Remision->getTabsGuardados($remision);
            $data_p['data'] = $success;
            $success2 = $this->Remision->getTabsValidados($remision);
            $data_p['tabs'] = $success2;

            echo json_encode($data_p);
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
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

    /*--------------------------BIOMÉTRICOS HUELLAS E IRIS--------------------------*/
    public function ejecutarHuellas()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[3] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }
        if (isset($_GET['no_remision'])) {
            $no_remision = $_GET['no_remision'];
            $existe_remision = $this->Remision->getRemision($no_remision);

            if ($existe_remision) {
                $fileName = "tempHuellas.jnlp";
                $pathHuellas = BASE_PATH . "public/Java/Huellas/tempHuellas.jnlp";


                // Escribe el contenido al fichero
                $cadena = '<?xml version="1.0" encoding="utf-8"?>
                            <jnlp spec="1.0+" codebase="http://172.18.0.25/planeacion/public/Java/Huellas" href="tempHuellas.jnlp">
                            <information>
                                <title>Huellas</title>
                                <vendor>Ardogs</vendor>
                                <description>Programa lanzador para el escaner del lector de huellas digitales </description>
                            </information>
                            <resources>
                                <j2se version="5.0+"/>
                                <jar href="EnrollmentSample.jar" main="true"/>
                            </resources>
                            <application-desc main-class="com.neurotec.samples.EnrollmentSample">
                                <argument>' . $no_remision . '</argument>
                            </application-desc>
                            <security><all-permissions/></security>
                            </jnlp>';
                file_put_contents($pathHuellas, $cadena);
                // Define headers
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=$fileName");
                header("Content-Type: application/zip");
                header("Content-Transfer-Encoding: binary");
                // Read the file
                readfile($pathHuellas);
                //unlink($pathHuellas);
                exit();
            }
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }


    /*-----------------------Captura de Iris--------------------------*/

    public function ejecutarIris()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[3] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }
        if (isset($_GET['no_remision'])) {
            $no_remision = $_GET['no_remision'];
            $existe_remision = $this->Remision->getRemision($no_remision);

            if ($existe_remision) {
                $fileName = "tempIris.jnlp";
                $pathIris = BASE_PATH . "public/Java/Iris/tempIris.jnlp";

                // Escribe el contenido al fichero
                $cadena = '<?xml version="1.0" encoding="utf-8"?>
                            <jnlp spec="1.0+" codebase="http://172.18.0.25/sarai/public/Java/Iris" href="tempIris.jnlp">
                            <information>
                                <title>Huellas</title>
                                <vendor>Ardogs</vendor>
                                <description>Programa lanzador para el escaner del lector de Iris</description>
                            </information>
                            <resources>
                                <j2se version="5.0+"/>
                                <jar href="Captura_Iris.jar" main="true"/>
                            </resources>
                            <application-desc main-class="VistaPrincipal">
                                <argument>' . $no_remision . '</argument>
                            </application-desc>
                            <security><all-permissions/></security>
                            </jnlp>';
                file_put_contents($pathIris, $cadena);
                // Define headers
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=$fileName");
                header("Content-Type: application/zip");
                header("Content-Transfer-Encoding: binary");
                // Read the file
                readfile($pathIris);
                //unlink($pathHuellas);
                exit;
            }
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }

    /*---------------------------------------------------------------*/

    public function openImgFromFTP()
    {

        $no_remision = $_POST['no_remision'];
        $fingers = [
            '',
            'LeftLittle',
            'LeftRingFinger',
            'LeftMiddleFinger',
            'LeftIndexFinger',
            'LeftThumb',
            'RightLittle',
            'RightRingFinger',
            'RightMiddleFinger',
            'RightIndexFinger',
            'RightThumb',
            'PlainLeftFourFingers',
            'PlainRightFourFingers',
            'PlainThumbs'
        ];
        $server = '172.18.0.25';
        $port   =  21;
        $user   = 'sscpueroot';
        $pwd    = 'A25pL*1me.';

        $ftp_connection = ftp_connect($server);
        $ret = ftp_login($ftp_connection, $user, $pwd);


        //comprueba si existe la carpeta del detenido
        if (in_array("remisiones/" . $no_remision, ftp_nlist($ftp_connection, 'remisiones'))) {
            //creando tempDir
            $tempDir = $this->tempdir();
            for ($i = 1; $i < sizeof($fingers); $i++) {
                $filePathFTP = "remisiones/" . $no_remision . "/images/" . $fingers[$i] . ".png";
                //$path_photo = "ftp://sscpueroot:A25pL*1me.@172.18.0.25/remisiones/".$no_remision. "/images/" . $fingers[$i] . ".png";
                $sizeFileFTP = ftp_size($ftp_connection, $filePathFTP);
                if ($sizeFileFTP != -1) { //comprueba que el archivo exista o no a traves del size file
                    //temp file
                    $pathTempFile = $tempDir . "/" . $fingers[$i] . ".png";

                    //$pathTempFile = tempnam("", "hue"); //se crea temp file

                    $handle = fopen($pathTempFile, 'w'); //se abre como escritura
                    ftp_fget($ftp_connection, $handle, $filePathFTP, FTP_BINARY, 0); //se escribe del ftp server al temp
                    fclose($handle);

                    $archivo = fopen($pathTempFile, "r");
                    if ($archivo) {
                        $texto = "";
                        while ($linea = fgets($archivo, 1024)) {
                            $texto .= $linea;
                        }
                        $data[$fingers[$i]] = 'data:image/png;base64,' . base64_encode($texto);
                    }

                    fclose($archivo);
                    //unlink($pathTempFile);
                } else {
                    $data[$fingers[$i]] = base_url . "/public/media/icons/noFinger.svg";
                    //echo "No existe" ;
                }
            }
            //borrar temp Dir
            $this->removeOnlyFilesDir($tempDir, 0);
            $data["status_PathExist"] =  true;
            $data["fsdf"] = "La carpeta si existe";
        } else {
            $data["status_PathExist"] =  false;
            $data["no_remision"] =  $no_remision;
        }

        //cerrando sesión FTP

        ftp_close($ftp_connection);
        echo json_encode($data);
    }

    public function getHuellasAPI()
    {
        echo file_get_contents('http://172.18.0.25:8080/BuscadorHuellasWS/webresources/BuscadorHuellas/?no_remision=' . $_POST['no_remision']);
    }

    public function getIrisAPI()
    {
        echo file_get_contents('http://192.168.100.208:8080/CoincidenciaIrisWS/webresources/generic?no_remision=' . $_POST['no_remision']);
    }

    public function tempdir()
    {
        $tempfile = tempnam(sys_get_temp_dir(), 'hue');
        // tempnam creates file on disk
        if (file_exists($tempfile)) {
            unlink($tempfile);
        }
        //$tempfile = substr($tempfile,0,strrpos($tempfile, '.', 0));
        mkdir($tempfile);
        if (is_dir($tempfile)) {
            return $tempfile;
        }
    }

    //Función para borrar carpetas de grupos
    public function removeOnlyFilesDir($dir, $ind)
    { //si ind == 1 no borra el directorio original, caso contrario, si lo borra
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->removeOnlyFilesDir("$dir/$file", false) : unlink("$dir/$file");
        }

        if ($ind) return;
        else return rmdir($dir);
    }


    public function getStatusIris()
    {

        $no_remision = $_POST['no_remision'];

        $CountRow = $this->Remision->getStatusIris($no_remision);

        echo ($CountRow == 0) ? json_encode(false) : json_encode(true);
    }
    /*Funciones añadidas para estados y municipios de origen de detenido y peticionario*/
    public function getEstadosMexico()
    {
        $data = $this->Catalogo->getSimpleCatalogoOrder("Estado", "catalogo_estados","Estado");
        return $data;
    }
    public function getMunicipios()
    {
        $data = $this->Catalogo->getMunicipiosEstados($_POST['termino'],$_POST['estado']);
        echo json_encode($data);
    }
    public function existeMunicipio()
    {
        $data = $this->Catalogo->existeMunicipio($_POST['estado'],$_POST['municipio']);
        echo json_encode($data);
    }
}
