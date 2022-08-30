<?php
    /**
     * 
     */
    class Seguimientos extends Controller
    {
        public $Seguimiento;
        public $numColumnsSP;
        public $numColumnsSV;
        public $FV;
        public $Catalogo;

        public function __construct()
        {
            $this->Catalogo = $this->model('Catalogo');
            $this->Seguimiento = $this->model('Seguimientom');   //se instancia model Seguimiento y ya puede ser ocupado en el controlador
            $this->numColumnsSP = [31];
            $this->numColumnsSV = [20];
            $this->FV = new FormValidator();
        }


        public function index(){
            //Se toman permisos de Corralon para Seguimientos
            if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Seguimientos[2] != '1')) {
                header("Location: ".base_url."Login");
            }

            //Titulo de la pagina y archivos css y js necesarios
            $data = [
                'titulo'    => 'Planeación | Seguimientos',
                'extra_css' => '<link rel="stylesheet" href="'. base_url . 'public/css/system/seguimientos/index.css">',
                'extra_js' =>   '<script src="' . base_url . 'public/js/system/seguimientos/index.js"></script>' .
                                '<script src="' . base_url . 'public/js/system/seguimientos/index2.js"></script>'
                    ];

            //PROCESO DE FILTRADO DE SEGUIMIENTOS A PERSONAS

            if (isset($_GET['filtro']) && is_numeric($_GET['filtro']) && $_GET['filtro']>=MIN_FILTRO_SP && $_GET['filtro']<=MAX_FILTRO_SP) { //numero de catálogo
                $filtro = $_GET['filtro'];
            } 
            else {
                $filtro = 1;
            }

            //PROCESO DE FILTRADO DE SEGUIMIENTOS A VEHÍCULOS

            if (isset($_GET['filtro2']) && is_numeric($_GET['filtro2']) && $_GET['filtro2']>=MIN_FILTRO_SV && $_GET['filtro2']<=MAX_FILTRO_SV) { //numero de catálogo
                $filtro2 = $_GET['filtro2'];
            } 
            else {
                $filtro2 = 1;
            }


            //PROCESAMIENTO DE LAS COLUMNAS 
            $this->setColumnsSessionSP($filtro);
            $data['columns_SP'] = $_SESSION['userdata']->columns_SP;

            //PROCESAMIENTO DE LAS COLUMNAS 
            $this->setColumnsSessionSV($filtro2);
            $data['columns_SV'] = $_SESSION['userdata']->columns_SV;


            //PROCESAMIENTO DE RANGO DE FOLIOS
            if (isset($_POST['rango_inicio_sp']) && isset($_POST['rango_fin_sp'])) {
                $_SESSION['userdata']->rango_inicio_sp = $_POST['rango_inicio_sp'];
                $_SESSION['userdata']->rango_fin_sp = $_POST['rango_fin_sp'];
            }

            //PROCESAMIENTO DE RANGO DE FOLIOS
            if (isset($_POST['rango_inicio_sv']) && isset($_POST['rango_fin_sv'])) {
                $_SESSION['userdata']->rango_inicio_sv = $_POST['rango_inicio_sv'];
                $_SESSION['userdata']->rango_fin_sv = $_POST['rango_fin_sv'];
            }

            //PROCESO DE PAGINACIÓN SEGUIMIENTOS A PERSONAS
            if (isset($_GET['numPage'])) { //numero de pagination
                $numPage = $_GET['numPage'];
                if (!(is_numeric($numPage))) //seguridad si se ingresa parámetro inválido
                    $numPage = 1;
            } 
            else {
                $numPage = 1;
            }

            //PROCESO DE PAGINACIÓN SEGUIMIENTO A VEHÍCULOS
            if (isset($_GET['numPage2'])) { //numero de pagination
                $numPage2 = $_GET['numPage2'];
                if (!(is_numeric($numPage2))) //seguridad si se ingresa parámetro inválido
                    $numPage2 = 1;
            } 
            else {
                $numPage2 = 1;
            }


            //cadena auxiliar por si se trata de una paginacion conforme a una busqueda dada anteriormente
            $cadena = "";
            if (isset($_GET['cadena'])) { //numero de pagination
                $cadena = $_GET['cadena'];
                $data['cadena'] = $cadena;
                //echo var_dump($cadena);
                //echo "Num caracteres: ".strlen($cadena);
            }

            //cadena auxiliar por si se trata de una paginacion conforme a una busqueda dada anteriormente
            $cadena2 = "";
            if (isset($_GET['cadena2'])) { //numero de pagination
                $cadena2 = $_GET['cadena2'];
                $data['cadena2'] = $cadena2;
                echo var_dump($cadena2);
                echo print_r($cadena2);
                //echo "Num caracteres: ".strlen($cadena);
            }  
            $where_sentence = $this->Seguimiento->generateWhereSentenceSP($cadena, $filtro);
            $where_sentence2 = $this->Seguimiento->generateWhereSentenceSV($cadena2, $filtro2);
            
            $extra_cad = ($cadena != "")?("&cadena=".$cadena):""; //para links conforme a búsqueda

            $extra_cad2 = ($cadena2 != "")?("&cadena2=".$cadena2):""; //para links conforme a búsqueda

            $no_of_records_per_page = NUM_MAX_REG_PAGE; //total de registros por pagination
            $no_of_records_per_page2 = NUM_MAX_REG_PAGE; //total de registros por pagination
            $offset = ($numPage-1) * $no_of_records_per_page; // desplazamiento conforme a la pagina
            $offset2 = ($numPage2-1) * $no_of_records_per_page2; // desplazamiento conforme a la pagina

            $results_rows_pages = $this->Seguimiento->getTotalPagesSP($no_of_records_per_page,$where_sentence);   //total de páginas de acuerdo a la info de la DB
            $results_rows_pages2 = $this->Seguimiento->getTotalPagesSV($no_of_records_per_page2,$where_sentence2);   //total de páginas de acuerdo a la info de la DB
            $total_pages = $results_rows_pages['total_pages'];

            $total_pages2 = $results_rows_pages2['total_pages2'];

            if ($numPage>$total_pages) {$numPage = 1; $offset = ($numPage-1) * $no_of_records_per_page;} //seguridad si ocurre un error por url

            if ($numPage2>$total_pages2) {$numPage2 = 1; $offset2 = ($numPage2-1) * $no_of_records_per_page2;} //seguridad si ocurre un error por url          
            
            $seguimientos = $this->Seguimiento->getDataCurrentPageSP($offset,$no_of_records_per_page,$where_sentence);   //se obtiene la información de la página actual

            $seguimientos2 = $this->Seguimiento->getDataCurrentPageSV($offset2,$no_of_records_per_page2,$where_sentence2);   //se obtiene la información de la página actual

            //guardamos la tabulacion de la información para la vista
            $data['infoTable'] = $this->generarInfoTableSP($seguimientos, $filtro);
            //guardamos la tabulacion de la información para la vista
            $data['infoTable2'] = $this->generarInfoTableSV($seguimientos2, $filtro2);
            //guardamos los links en data para la vista
            $data['links'] = $this->generarLinksSP($numPage,$total_pages,$extra_cad);
            //guardamos los links en data para la vista
            $data['links2'] = $this->generarLinksSV($numPage2,$total_pages2,$extra_cad2);
            //número total de registros encontrados
            $data['total_rows'] = $results_rows_pages['total_rows'];

            $data['total_rows2'] = $results_rows_pages2['total_rows2'];

            //$data['export_links'] = $this->generarExportLinksSP($extra_cad);
            //var_dump($seguimientos[0]);
            //echo "<br><br>";
            //var_dump($seguimientos[1]);
            $data['filtroActual'] = $filtro;
            $data['filtroActual2'] = $filtro2;
            $data['dropdownColumns'] = $this->generateDropdownColumnsSP($filtro);
            $data['dropdownColumns2'] = $this->generateDropdownColumnsSV($filtro2);

            switch ($filtro) {
            case '1': $data['filtroNombre'] = "Vista general"; break;
            }

            switch ($filtro2) {
            case '1': $data['filtroNombre2'] = "Vista general"; break;
            }


            $this->view("templates/header",$data);
            $this->view("system/seguimientos/seguimView",$data);
            $this->view("templates/footer",$data);
        }

    public function nuevoSeguimientoP(){
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Seguimientos[3] != '1')) {
            header("Location: ".base_url."Login");
        }

        $senasParticulares = [
            'tatuajes'  => $this->getTatuajes(),
            'vehiculos' => $this->getMarcasVehiculos()
        ];

        //Titulo de la pagina y archivos css y js necesarios del apartado Seguimiento de Personas
        $data = [
                'titulo'    => 'Planeación | Seguimientos',
                'extra_css' => '<link rel="stylesheet" href="' . base_url . 'public/css/system/seguimientos/capturaFotos.css">
                                <link rel="stylesheet" href="' . base_url . 'public/css/system/remisiones/senas.css">',
                'extra_js'  => '<script src="' . base_url . 'public/js/system/seguimientos/validaciones/script.js"></script>
                                <script src="' . base_url . 'public/js/system/remisiones/senas.js"></script>
                                <script src="' . base_url . 'public/js/system/remisiones/capturaFotos.js"></script>
                                <script src="' . base_url . 'public/js/system/seguimientos/capturaFotos1.js"></script>
                                <script src="' . base_url . 'public/js/system/seguimientos/regvehiculos1.js"></script>
                                <script src="' . base_url . 'public/js/system/seguimientos/nuevoSP.js"></script>
                                <script src="' . base_url . 'public/js/system/seguimientos/regCaract.js"></script>
                                <script src="' . base_url . 'public/js/maps/seguimientos/principal.js"></script>
                                <script src="https://maps.googleapis.com/maps/api/js?key=' . API_KEY . '&callback=initMap&libraries=places" async defer></script>',
                'senasParticulares'     =>  $senasParticulares
            ];

            $this->view("templates/header",$data);
            $this->view("system/seguimientos/crearSPView",$data);
            $this->view("templates/footer",$data);
    }

    public function insertSeguimientoP()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Seguimientos[3] != '1')) {
            header("Location: ".base_url."Login");
        }

        if(!empty($_POST['spcelulas']) && is_numeric($_POST['spcelulas']))
        {
            
            $k = 0;
            /*
            if($_POST['spcelulas'] != '')
            $valid[$k++] = $data_p['No_folio911_error']         = $this->FV->validate($_POST,   'spnofolio911', 'required | min_length[2] | max_length[3] | numeric');

            if($_POST['spfolioinfra'] != '')
            $valid[$k++] = $data_p['No_folioinfra_error']         = $this->FV->validate($_POST,   'spfolioinfra', 'required | min_length[5] | max_length[6]');
            */

            if($_POST['spcelulas'] != '')
            $valid[$k++] = $data_p['Celula_error']         = $this->FV->validate($_POST,   'spcelulas', 'required | numeric | length[1]');


            if(isset($_FILES['sppdfcdi']))
                $file = true;
            else
                $file = false;
                
            $success = true;
            foreach ($valid as $val)
                $success &= ($val == '') ? true : false;


            $images = json_decode($_POST['captura_imagenes']);
            $vehiculos = json_decode($_POST['table_vehiculos']);
            $senias = json_decode($_POST['senas_table']);

            if($success) 
            {
                $data_p['status'] =  'success';
                $date = date("Ymdhis");

                $id_seguimiento_p = $this->Seguimiento->insertNewSP($_POST);
                $path_carpetaImg = BASE_PATH."public/files/Seguimientos/Personas/".$id_seguimiento_p."/Images/";

                if($id_seguimiento_p && isset($_FILES['sppdfcdi']))
                {
                    $path_carpeta = BASE_PATH."public/files/Seguimientos/Personas/".$id_seguimiento_p."/CDI/";
                    $path_file = BASE_PATH."public/files/Seguimientos/Personas/".$id_seguimiento_p."/CDI/".$id_seguimiento_p.".pdf";
                    $name = $_FILES['sppdfcdi'];
                    $result = $this->uploadpdfCDISeguimientoP($name,$_FILES,$path_carpeta,$path_file);
                    $data_p['file'] = $result;
                }

                if ($id_seguimiento_p) 
                {
                    $descripcion = "Con el Id: ".$id_seguimiento_p;
                    $user = $_SESSION['userdata']->Id_Usuario;
                    $ip = $this->obtenerIp();
                    $this->Seguimiento->historial($user,$ip,5,$descripcion);                    
                }
                
                foreach($images as $image){
                    if($image->row->tipo == 'File'){
                        $type = $_FILES[$image->row->name]['type'];
                        $extension = explode("/",$type);
                        $result = $this->uploadImageFileSeguimientos($image->row->name,$_FILES,$path_carpetaImg,$image->row->name.'.'.$extension[1]);
                        $name = $image->row->name.'.'.$extension[1];
                        $this->Seguimiento->insertFotosSP($id_seguimiento_p,$name);
                    }
                }

                foreach($vehiculos as $vehiculo){
                        $marca  = $vehiculo->row->marca;
                        $modelo = $vehiculo->row->modelo;
                        $color  = $vehiculo->row->color;
                        $placa  = $vehiculo->row->placa;
                        $this->Seguimiento->insertVehiculosSP($id_seguimiento_p,$marca,$modelo,$color,$placa);
                }

                foreach($senias as $senia)
                {
                    $tipo           = $senia->row->tipo;
                    $perfil         = $senia->row->perfil;
                    $partes         = $senia->row->partes;
                    $color          = $senia->row->color;
                    $clasificacion  = $senia->row->clasificacion;
                    $descripcion    = $senia->row->descripcion;
                    $nameImage = '';

                    if($senia->row->typeImage == 'null')
                    {
                        $nameImage = '';
                    }

                    else
                    {
                        if ($senia->row->typeImage == 'File') 
                        {
                            $type = $_FILES[$senia->row->nameImage]['type'];
                            $extension = explode("/", $type);
                            $nameImage = $senia->row->nameImage . "." . $extension[1] . "?v=" . $date;
                        }

                        else 
                        {
                            $nameImage = $senia->row->nameImage;
                        }
                    }
                    $this->Seguimiento->insertSeniasSP($id_seguimiento_p,$perfil,$partes,$tipo,$color,$clasificacion,$descripcion,$nameImage);
                    if($senia->row->typeImage != 'null'){
                        if ($senia->row->typeImage == 'File') 
                        {
                            $type = $_FILES[$senia->row->nameImage]['type'];
                            $extension = explode("/",$type);
                            $result = $this->uploadImageFileSeguimientos($senia->row->nameImage,$_FILES,$path_carpetaImg,$senia->row->nameImage.'.'.$extension[1]);                          
                        }
                        if ($senia->row->typeImage == 'Photo') 
                        {
                        }
                    }
                }
            }           
            echo json_encode($data_p);
        }

        else
        {
            $data_p['status'] =  'failed';
            echo json_encode($data_p);
        }
}

    public function updateSeguimientoP()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Seguimientos[1] != '1')) {
            header("Location: ".base_url."Login");
        }

        if(isset($_POST['no_id_sp']) && is_numeric($_POST['no_id_sp']))
        {
            
            $k = 0;
            /*
            if($_POST['spcelulas'] != '')
            $valid[$k++] = $data_p['No_folio911_error']         = $this->FV->validate($_POST,   'spnofolio911', 'required | min_length[2] | max_length[3] | numeric');

            if($_POST['spfolioinfra'] != '')
            $valid[$k++] = $data_p['No_folioinfra_error']         = $this->FV->validate($_POST,   'spfolioinfra', 'required | min_length[5] | max_length[6]');
            */

            if($_POST['spcelulas'] != '')
            $valid[$k++] = $data_p['Celula_error']         = $this->FV->validate($_POST,   'spcelulas', 'required | numeric | length[1]');
                
            $success = true;
            foreach ($valid as $val)
                $success &= ($val == '') ? true : false;

            $images = json_decode($_POST['captura_imagenes']);
            $id_seguimiento_persona = $_POST['no_id_sp'];
            $id_domicilio = $_POST['no_id_dom'];
            $senas = json_decode($_POST['senas_table']);
            
            $path_carpetaImg = BASE_PATH."public/files/Seguimientos/Personas/".$id_seguimiento_persona."/Images/";

            if($success) 
            {
                $data_p['status'] =  'success';

                $sp_violencia_si = $_POST['spviolencia_si'];
                $descripcion = "Con el Id: ".$id_seguimiento_persona;

                if($sp_violencia_si == 'true'){
                    $sp_vio = '1';
                }else{
                    $sp_vio = '0';
                }

                $result = $this->Seguimiento->updateSeguimientoP($_POST,$id_seguimiento_persona,$sp_vio,$id_domicilio);

                if($result){
                    if(isset($_FILES['sppdfcdi']))
                    {
                        $path_carpeta = BASE_PATH."public/files/Seguimientos/Personas/".$id_seguimiento_persona."/CDI/";
                        $path_file = BASE_PATH."public/files/Seguimientos/Personas/".$id_seguimiento_persona."/CDI/".$id_seguimiento_persona.".pdf";
                        $name = $_FILES['sppdfcdi'];
                        $result = $this->uploadpdfCDISeguimientoP($name,$_FILES,$path_carpeta,$path_file);
                        $data_p['file'] = $result;
                    }
                    
                    $user = $_SESSION['userdata']->Id_Usuario;
                    $ip = $this->obtenerIp();
                    $this->Seguimiento->historial($user,$ip,6,$descripcion);
    
                    foreach(glob($path_carpetaImg . "/*") as $archivos_carpeta){             
                        if (is_dir($archivos_carpeta)){
                            rmDir_rf($archivos_carpeta);
                        } else {
                            unlink($archivos_carpeta);
                        }
                    } 
    
                    foreach($images as $image){
                        if($image->row->tipo == 'File'){
                            $type = $_FILES[$image->row->name]['type'];
                            $extension = explode("/",$type);
                            $this->uploadImageFileSeguimientos($image->row->name,$_FILES,$path_carpetaImg,$image->row->name.'.'.$extension[1]);
                        }
                        if($image->row->tipo == 'Photo'){
                            $this->uploadImagePhotoSeguimientos($image->row->image,$path_carpetaImg,$path_carpetaImg.$image->row->name);
                        }
                    } 

                    foreach($senas as $sena){
                        if($sena->row->typeImage == 'File'){
                            $type = $_FILES[$sena->row->nameImage]['type'];
                            $extension = explode("/",$type);
                            $result = $this->uploadImageFileSeguimientos($sena->row->nameImage,$_FILES,$path_carpetaImg,$sena->row->nameImage.".".$extension[1]);
                        }
                        if($sena->row->typeImage == 'Photo'){
                            $image_parts = explode(";base64,", $sena->row->image);
                            $image_type_aux = explode("image/", $image_parts[0]);
                            $image_type = $image_type_aux[1];
                            $result = $this->uploadImagePhotoSeguimientos($sena->row->image,$path_carpetaImg,$path_carpetaImg.$sena->row->nameImage.'.'.$image_type);
                        }
                    }
                }

            }

            else
            {
                $data_p['status'] =  'failed';
            }
            
            echo json_encode($data_p);
        }

        else
        {
            $data_p['status'] =  'failed';
            echo json_encode($data_p);
        }
    }

    public function editarSegP(){
        //echo("TIENE DETALLE EN CAMPO AREA CORREGIR HOY");
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Seguimientos[1] != '1')) {
            header("Location: ".base_url."Login");
        }

        $senasParticulares = [
            'tatuajes' => $this->getTatuajes(),
            'vehiculos' => $this->getMarcasVehiculos()
        ];

        //Titulo de la pagina y archivos css y js necesarios
        $data = [
                'titulo'    => 'Planeación | Seguimientos',
                'extra_css' => '<link rel="stylesheet" href="' . base_url . 'public/css/system/seguimientos/capturaFotos.css">
                                <link rel="stylesheet" href="' . base_url . 'public/css/system/remisiones/senas.css">',
                'extra_js'  => '<script src="' . base_url . 'public/js/system/seguimientos/validaciones/script.js"></script>
                                <script src="' . base_url . 'public/js/system/remisiones/senas.js"></script>
                                <script src="' . base_url . 'public/js/system/remisiones/capturaFotos.js"></script>
                                <script src="' . base_url . 'public/js/system/seguimientos/capturaFotos1.js"></script>
                                <script src="' . base_url . 'public/js/system/seguimientos/regvehiculos1.js"></script>
                                <script src="' . base_url . 'public/js/system/seguimientos/editSP.js"></script>
                                <script src="' . base_url . 'public/js/system/seguimientos/regCaract.js"></script>
                                <script src="' . base_url . 'public/js/maps/seguimientos/principal.js"></script>
                                <script src="https://maps.googleapis.com/maps/api/js?key=' . API_KEY . '&callback=initMap&libraries=places" async defer></script>',
                'senasParticulares'     =>  $senasParticulares
            ];

                //$data['infoSegSP'] = $infoSegSP;
                $this->view("templates/header",$data);
                $this->view("system/seguimientos/editSPView",$data);
                $this->view("templates/footer",$data);

    }

    public function getSeguimientoPersona()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Seguimientos[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        if(isset($_POST['no_id_sp'])){
            $id_seguimiento_persona = $_POST['no_id_sp'];
            $data = $this->Seguimiento->getSeguimientoP($id_seguimiento_persona);
            echo json_encode($data);
        }else{
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }

    public function verSP(){
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Seguimientos[2] != '1')) {
            header("Location: ".base_url."Login");
        }

        //Titulo de la pagina y archivos css y js necesarios
        $data = [
            'titulo'    => 'Planeación | Ver Seguimiento',
            'extra_css' => '<link rel="stylesheet" href="'. base_url . 'public/css/system/seguimientos/capturaFotos.css">
                            <link rel="stylesheet" href="' . base_url . 'public/css/system/remisiones/senas.css">',
            'extra_js'  => '<script src="' . base_url . 'public/js/system/seguimientos/verSP.js"></script>
                            <script src="' . base_url . 'public/js/system/remisiones/senas.js"></script>
                            <script src="' . base_url . 'public/js/system/remisiones/capturaFotos.js"></script>
                            <script src="' . base_url . 'public/js/system/seguimientos/regvehiculos1.js"></script>
                            <script src="' . base_url . 'public/js/system/seguimientos/capturaFotos1.js"></script>
                            '
        ];

        if (isset($_GET['id_sp'])) { //GET para mostrar la información actual del user
            $id_sp = $_GET['id_sp'];
            if (!(is_numeric($id_sp))) //seguridad si se ingresa parámetro inválido
                header("Location: ".base_url."Seguimientos");
            $infoSegSP = $this->Seguimiento->getSegByIdSP($id_sp);
            if (!$infoSegSP) {
                header("Location: ".base_url."Inicio");
                exit();
            }
            else{
                
                //$infoSegSP->Fecha_Format = $this->formatearFecha($infoSegSP->Fecha_Registro_Usuario);
                $data['infoSegSP'] = $infoSegSP;
                $this->view("templates/header",$data);
                $this->view("system/seguimientos/verSegPView",$data);
                $this->view("templates/footer",$data);
            }
        } 
        else{   //ni post ni get
            header("Location: ".base_url."Seguimientos");
        }
    }

    public function nuevoSeguimientoV(){
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Seguimientos[3] != '1')) {
            header("Location: ".base_url."Login");
        }

        $senasParticulares = [
            'vehiculos' => $this->getMarcasVehiculos()
        ];

        //Titulo de la pagina y archivos css y js necesarios del apartado Seguimiento de Personas
        $data = [
                'titulo'    => 'Planeación | Seguimientos',
                'extra_css' => '<link rel="stylesheet" href="' . base_url . 'public/css/system/seguimientos/capturaFotos.css">',
                'extra_js'  => '<script src="' . base_url . 'public/js/system/seguimientos/validaciones/script.js"></script>
                                <script src="' . base_url . 'public/js/system/seguimientos/capturaFotos2.js"></script>
                                <script src="' . base_url . 'public/js/system/seguimientos/nuevoSV.js"></script>',
                'senasParticulares'     =>  $senasParticulares
            ];

            $this->view("templates/header",$data);
            $this->view("system/seguimientos/crearSVView",$data);
            $this->view("templates/footer",$data);
    }

    public function insertSeguimientoV()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Seguimientos[3] != '1')) {
            header("Location: ".base_url."Login");
        }

        if(!empty($_POST['svcelulas']) && is_numeric($_POST['svcelulas']))
        {
            
            $k = 0;

            if($_POST['svcelulas'] != '')
            $valid[$k++] = $data_p['celula_error']         = $this->FV->validate($_POST,   'svcelulas', 'required | numeric | length[1]');


            if(isset($_FILES['svpdfcdi']))
                $file = true;
            else
                $file = false;
                
            $success = true;
            foreach ($valid as $val)
                $success &= ($val == '') ? true : false;


            $images = json_decode($_POST['captura_imagenes']);

            if($success) 
            {
                $data_p['status'] =  'success';

                $id_seguimiento_v = $this->Seguimiento->insertNewSV($_POST);
                $path_carpetaImg = BASE_PATH."public/files/Seguimientos/Vehiculos/".$id_seguimiento_v."/Images/";

                if($id_seguimiento_v && isset($_FILES['svpdfcdi']))
                {
                    $path_carpeta = BASE_PATH."public/files/Seguimientos/Vehiculos/".$id_seguimiento_v."/CDI/";
                    $path_file = BASE_PATH."public/files/Seguimientos/Vehiculos/".$id_seguimiento_v."/CDI/".$id_seguimiento_v.".pdf";
                    $name = $_FILES['svpdfcdi'];
                    $result = $this->uploadpdfCDISeguimientoV($name,$_FILES,$path_carpeta,$path_file);
                    $data_p['file'] = $result;
                }

                if ($id_seguimiento_v) 
                {
                    $descripcion = "Con el Id: ".$id_seguimiento_v;
                    $user = $_SESSION['userdata']->Id_Usuario;
                    $ip = $this->obtenerIp();
                    $this->Seguimiento->historial($user,$ip,7,$descripcion);                    
                }

                foreach($images as $image){
                    if($image->row->tipo == 'File'){
                        $type = $_FILES[$image->row->name]['type'];
                        $extension = explode("/",$type);
                        $result = $this->uploadImageFileSeguimientos($image->row->name,$_FILES,$path_carpetaImg,$image->row->name.'.'.$extension[1]);
                        $name = $image->row->name.'.'.$extension[1];
                        $this->Seguimiento->insertFotosSV($id_seguimiento_v,$name);
                    }
                }
            }

            else
            {
                $data_p['status'] =  'failed';
            }
            
            echo json_encode($data_p);
        }

        else
        {
            $data_p['status'] =  'failed';
            echo json_encode($data_p);
        }
    }

    public function updateSeguimientoV()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Seguimientos[1] != '1')) {
            header("Location: ".base_url."Login");
        }

        if(isset($_POST['no_id_sv']) && is_numeric($_POST['no_id_sv']))
        {
            
            $k = 0;

            if($_POST['svcelulas'] != '')
            $valid[$k++] = $data_p['celula_error']         = $this->FV->validate($_POST,   'svcelulas', 'required | numeric | length[1]');
                
            $success = true;
            foreach ($valid as $val)
                $success &= ($val == '') ? true : false;

            $images = json_decode($_POST['captura_imagenes']);
            $id_seguimiento_vehiculo = $_POST['no_id_sv']; 
            $path_carpetaImg = BASE_PATH."public/files/Seguimientos/Vehiculos/".$id_seguimiento_vehiculo."/Images/";

            if($success) 
            {
                $data_p['status'] =  'success';

                $sv_obrap_si = $_POST['svobrap_si'];
                $descripcion = "Con el Id: ".$id_seguimiento_vehiculo;

                if($sv_obrap_si == 'true'){
                    $sv_obra = '1';
                }else{
                    $sv_obra = '0';
                }

                $result = $this->Seguimiento->updateSeguimientoV($_POST,$id_seguimiento_vehiculo,$sv_obra);

                if($result){

                    if(isset($_FILES['svpdfcdi']))
                    {
                        $path_carpeta = BASE_PATH."public/files/Seguimientos/Vehiculos/".$id_seguimiento_vehiculo."/CDI/";
                        $path_file = BASE_PATH."public/files/Seguimientos/Vehiculos/".$id_seguimiento_vehiculo."/CDI/".$id_seguimiento_vehiculo.".pdf";
                        $name = $_FILES['svpdfcdi'];
                        $resultCDI = $this->uploadpdfCDISeguimientoV($name,$_FILES,$path_carpeta,$path_file);
                        $data_p['file'] = $resultCDI;
                    }
                    
                    $user = $_SESSION['userdata']->Id_Usuario;
                    $ip = $this->obtenerIp();
                    $this->Seguimiento->historial($user,$ip,8,$descripcion);
                    
                    foreach(glob($path_carpetaImg . "/*") as $archivos_carpeta){             
                        if (is_dir($archivos_carpeta)){
                            rmDir_rf($archivos_carpeta);
                        } else {
                            unlink($archivos_carpeta);
                        }
                    } 
    
                    foreach($images as $image){
                        if($image->row->tipo == 'File'){
                            $type = $_FILES[$image->row->name]['type'];
                            $extension = explode("/",$type);
                            $this->uploadImageFileSeguimientos($image->row->name,$_FILES,$path_carpetaImg,$image->row->name.'.'.$extension[1]);
                        }
                        if($image->row->tipo == 'Photo'){
                            $this->uploadImagePhotoSeguimientos($image->row->image,$path_carpetaImg,$path_carpetaImg.$image->row->name);
                        }
                    } 
                }
                

                
            }else{
                $data_p['status'] =  'failed';
            }
            
            echo json_encode($data_p);
        }

        else
        {
            $data_p['status'] =  'failed';
            echo json_encode($data_p);
        }
    }

    public function editarSegV(){
        //echo("TIENE DETALLE EN CAMPO AREA CORREGIR HOY");
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Seguimientos[1] != '1')) {
            header("Location: ".base_url."Login");
        }

        $senasParticulares = [
            'vehiculos' => $this->getMarcasVehiculos()
        ];

        //Titulo de la pagina y archivos css y js necesarios
        $data = [
                'titulo'    => 'Planeación | Seguimientos',
                'extra_css' => '<link rel="stylesheet" href="' . base_url . 'public/css/system/seguimientos/capturaFotos.css">',
                'extra_js'  => '<script src="' . base_url . 'public/js/system/seguimientos/validaciones/script.js"></script>
                                <script src="' . base_url . 'public/js/system/seguimientos/capturaFotos2.js"></script>
                                <script src="' . base_url . 'public/js/system/seguimientos/editSV.js"></script>',
                'senasParticulares'     =>  $senasParticulares
            ];

                $this->view("templates/header",$data);
                $this->view("system/seguimientos/editSVView",$data);
                $this->view("templates/footer",$data);
    }

    public function getSeguimientoVehiculo()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Seguimientos[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        if(isset($_POST['no_id_sv'])){
            $id_seguimiento_vehiculo = $_POST['no_id_sv'];
            $data = $this->Seguimiento->getSeguimientoV($id_seguimiento_vehiculo);
            echo json_encode($data);
        }else{
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }

    public function verSV(){
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Seguimientos[2] != '1')) {
            header("Location: ".base_url."Login");
        }

        //Titulo de la pagina y archivos css y js necesarios
        $data = [
            'titulo'    => 'Planeación | Ver Seguimiento',
            'extra_css' => '<link rel="stylesheet" href="'. base_url . 'public/css/system/seguimientos/capturaFotos.css">',
            'extra_js'  => '<script src="' . base_url . 'public/js/system/seguimientos/capturaFotos2.js"></script>
                            <script src="' . base_url . 'public/js/system/seguimientos/verSV.js"></script>'
        ];

        if (isset($_GET['id_sv'])) { //GET para mostrar la información actual del user
            $id_sv = $_GET['id_sv'];
            if (!(is_numeric($id_sv))) //seguridad si se ingresa parámetro inválido
                header("Location: ".base_url."Seguimientos");
            $infoSegSV = $this->Seguimiento->getSegByIdSV($id_sv);
            if (!$infoSegSV) {
                header("Location: ".base_url."Inicio");
                exit();
            }
            else{
                
                //$infoSegSV->Fecha_Format = $this->formatearFecha($infoSegSV->Fecha_Registro_Usuario);
                $this->view("templates/header",$data);
                $this->view("system/seguimientos/verSegVView",$data);
                $this->view("templates/footer",$data);
            }
        } 
        else{   //ni post ni get
            header("Location: ".base_url."Seguimientos");
        }
    }

    public function exportarInfoSP(){
        /*
        if (!isset($_REQUEST['filtroActual']) || !isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Seguimientos[2] != '1')) {
            header("Location: ".base_url."Inicio");
            exit();
        }
        */

        if(!isset($_REQUEST['filtroActual']) || !is_numeric($_REQUEST['filtroActual']) || !($_REQUEST['filtroActual']>=MIN_FILTRO_SP) || !($_REQUEST['filtroActual']<=MAX_FILTRO_SP)){
                $filtroActual = 1;
            }else{
                $filtroActual = $_REQUEST['filtroActual'];
            }

        $where_sentence = "";

        if(isset($_REQUEST['cadena'])){
                $where_sentence = $this->Seguimiento->generateWhereSentenceSP($_REQUEST['cadena'],$filtroActual);
            }else{
                $where_sentence = $this->Seguimiento->generateWhereSentenceSP("",$filtroActual);
            }
        
        //var_dump($_REQUEST);
        $tipo_export = $_REQUEST['tipo_export'];

        if ($tipo_export == 'EXCEL') {
            //se realiza exportacion de usuarios a EXCEL
            $seguimient = $this->Seguimiento->getAllSPByCadena($where_sentence);
            $csv_data="Id,Folio 911,Folio Infra,Célula seguimiento,Nombre Completo,Otros nombres falsos,Alias,Fecha de nacimiento,Edad,Lugar de origen,Teléfono,Domicilio,Ocupación,Link red social,Nombre de familiar,Parentesco,Vínculo con grupo o banda delictiva,Modus operandi,CDI,Violencia,Tipo de violencia,Delito vinculado,Especificación del delito,Áreas de Operación,Áreas de resguardo,\n";
            foreach ($seguimient as $seg) {
                
                if($seg->Violencia=='1')
                {
                    $seg->Violencia='SI';
                }
                else
                {
                    $seg->Violencia='NO';
                }

                $domicilio="";
                if(($seg->Colonia)!=null) 
                {
                    $domicilio='COLONIA: '.mb_strtoupper($seg->Colonia).' CALLE: '.mb_strtoupper($seg->Calle).' INTERIOR: '.mb_strtoupper($seg->No_Interior).' CP: '.mb_strtoupper($seg->CP);

                    if($seg->No_Exterior!=null) 
                    {
                        $domicilio='COLONIA: '.mb_strtoupper($seg->Colonia).' CALLE: '.mb_strtoupper($seg->Calle).' EXTERIOR: '.mb_strtoupper($seg->No_Exterior).' INTERIOR: '.mb_strtoupper($seg->No_Interior).' CP: '.mb_strtoupper($seg->CP);                        
                    }
                }

                $csv_data.= $seg->Id_Seguimiento_P. ",\"" .
                            mb_strtoupper($seg->Folio_911). "\",\"" .
                            mb_strtoupper($seg->Folio_Infra). "\",\"" .
                            $seg->Celula_Seguimiento. "\",\"" .
                            mb_strtoupper($seg->Nombre1)." ".mb_strtoupper($seg->Nombre2)." ".mb_strtoupper($seg->Nombre3)." ".mb_strtoupper($seg->Ap_Paterno)." ".mb_strtoupper($seg->Ap_Materno) . "\",\"" .
                            //$seg->Nombre_Completo.",".
                            //$seg->Nombre1.",".
                            //$seg->Nombre2.",".
                            //$seg->Nombre3.",".
                            //$seg->Ap_Paterno.",".
                            //$seg->Ap_Materno.",".
                            mb_strtoupper($seg->Otros_Nombres_Falsos) . "\",\"" .
                            mb_strtoupper($seg->Alias) . "\",\"" .
                            $seg->Fecha_Nacimiento . "\",\"" .
                            $seg->Edad . "\",\"" .
                            mb_strtoupper($seg->Lugar_Origen) . "\",\"" .
                            $seg->Telefono . "\",\"" .
                            $domicilio . "\",\"" .
                            mb_strtoupper($seg->Ocupacion) . "\",\"" .
                            mb_strtoupper($seg->Link_Red_Social) . "\",\"" .
                            mb_strtoupper($seg->Nombre_Familiar) . "\",\"" .
                            mb_strtoupper($seg->Parentezco) . "\",\"" .
                            mb_strtoupper($seg->Vinculo_Grupo_Banda) . "\",\"" .
                            mb_strtoupper($seg->Modus_Operandi) . "\",\"" .
                            mb_strtoupper($seg->CDI) . "\",\"" .
                            mb_strtoupper($seg->Violencia) . "\",\"" .
                            mb_strtoupper($seg->Tipo_Violencia) . "\",\"" .
                            mb_strtoupper($seg->Delito_Vinculado) . "\",\"" .
                            mb_strtoupper($seg->Especificacion_Delito) . "\",\"" .
                            mb_strtoupper($seg->Areas_Operacion) . "\",\"" .
                            mb_strtoupper($seg->Areas_Resguardo) . "\"\n";

            }
            $csv_data = utf8_decode($csv_data); //escribir información con formato utf8 por algún acento
            header("Content-Description: File Transfer");
            header("Content-Type: application/force-download");
            header("Content-Disposition: attachment; filename=seguimiento_persona.csv");
            echo $csv_data;
            //header("Location: ".base_url."UsersAdmin");

        }
        elseif($tipo_export == 'PDF'){
            $seguimient = $this->Seguimiento->getAllSPByCadena($where_sentence);
            

            header("Content-type: application/pdf");
            header("Content-Disposition: inline; filename=seguimiento_persona.pdf");
            //echo $this->generarPDFSP($seguimient,$_REQUEST['cadena']);
            echo $this->generarPDFSP($seguimient,$_REQUEST['cadena']);
        }
        else{
            header("Location: ".base_url."Inicio");
            exit();
        }
    }

    public function exportarInfoSV(){

        if(!isset($_REQUEST['filtroActual2']) || !is_numeric($_REQUEST['filtroActual2']) || !($_REQUEST['filtroActual2']>=MIN_FILTRO_SV) || !($_REQUEST['filtroActual2']<=MAX_FILTRO_SV)){
                $filtroActual = 1;
            }else{
                $filtroActual = $_REQUEST['filtroActual2'];
            }

        if (!isset($_REQUEST['tipo_export2'])) {
            header("Location: ".base_url."Seguimientos");
        }

        $where_sentence2 = "";

        if(isset($_REQUEST['cadena2'])){
                $where_sentence2 = $this->Seguimiento->generateWhereSentenceSV($_REQUEST['cadena2'],$filtroActual);
            }else{
                $where_sentence2 = $this->Seguimiento->generateWhereSentenceSV("",$filtroActual);
            }
        
        $tipo_export2 = $_REQUEST['tipo_export2'];

        if ($tipo_export2 == 'EXCEL') {
            //se realiza exportacion de usuarios a EXCEL
            $seguimient = $this->Seguimiento->getAllSVByCadena($where_sentence2);
            $csv_data="Id,Folio 911,Folio Infra,Célula seguimiento,Marca,Modelo,Placas,Color,Características,Delito involucrado,CDI,Obra placa en CDI,Modus operandi,Áreas de operación,Áreas de resguardo,Vínculo con grupo o banda delictiva,Fecha de registro\n";
            foreach ($seguimient as $seg) {

                //cadenas permisos para exportación

                if($seg->Obra_Placa=='1') 
                {
                    $seg->Obra_Placa='SI';
                }

                else
                {
                    $seg->Obra_Placa='NO';
                }
   

                $csv_data.= $seg->Id_Seguimiento_V . ",\"" .
                            mb_strtoupper($seg->Folio_911). "\",\"" .
                            mb_strtoupper($seg->Folio_Infra). "\",\"" .
                            $seg->Celula_Seguimiento. "\",\"" .
                            mb_strtoupper($seg->Marca). "\",\"" .
                            mb_strtoupper($seg->Modelo). "\",\"" .
                            mb_strtoupper($seg->Placas). "\",\"" .
                            mb_strtoupper($seg->Color). "\",\"" .
                            mb_strtoupper($seg->Caracteristicas). "\",\"" .
                            mb_strtoupper($seg->Delito_Involucrado). "\",\"" .
                            mb_strtoupper($seg->CDI). "\",\"" .
                            mb_strtoupper($seg->Obra_Placa). "\",\"" .
                            mb_strtoupper($seg->Modus_Operandi). "\",\"" .
                            mb_strtoupper($seg->Areas_Operacion). "\",\"" .                            
                            mb_strtoupper($seg->Areas_Resguardo). "\",\"" .
                            mb_strtoupper($seg->Vinculacion_Banda_Persona). "\",\"" .
                            $seg->Fecha_Registro_SV. "\"\n";

            }
            $csv_data = utf8_decode($csv_data); //escribir información con formato utf8 por algún acento
            header("Content-Description: File Transfer");
            header("Content-Type: application/force-download");
            header("Content-Disposition: attachment; filename=seguimiento_vehiculo.csv");
            echo $csv_data;
            //header("Location: ".base_url."UsersAdmin");

        }
        elseif($tipo_export2 == 'PDF'){
            $seguimient = $this->Seguimiento->getAllSVByCadena($where_sentence2);
            

            header("Content-type: application/pdf");
            header("Content-Disposition: inline; filename=seguimiento_vehiculo.pdf");
            echo $this->generarPDFSV($seguimient,$_REQUEST['cadena2']);
        }
        else{
            header("Location: ".base_url."Inicio");
            exit();
        }
    }

    //función para armar el archivo PDF dependiendo del filtro y/o cadena de búsqueda
    public function generarPDFSP($seguimient,$cadena = ""){
        
        $filename="Vista general";

        $data['subtitulo']      = 'Seguimientos a Personas: '.$filename;

        if ($cadena != "") {
            $data['msg'] = 'todos los registros de Seguimientos a Personas con filtro: '.$cadena.'';
        }
        else{
            $data['msg'] = 'todos los registros de Seguimientos a Personas';
        }

        //---Aquí va la info según sea el filtro de SP seleccionado
                $data['columns'] =  [
                                'Id',
                                'Folio 911',
                                'Folio Infra',
                                'Célula',
                                'Apellido paterno',
                                'Apellido materno',
                                'Nombre #1',
                                'Nombre #2',
                                'Nombre #3'
                            ];  
                $data['field_names'] = [
                                'Id_Seguimiento_P',
                                'Folio_911',
                                'Folio_Infra',
                                'Celula_Seguimiento',
                                'Ap_Paterno',
                                'Ap_Materno',
                                'Nombre1',
                                'Nombre2',
                                'Nombre3'
                            ];
          
        //---fin de la info del SP
        
        $data['rows'] = $seguimient;
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

    public function generarPDFSV($seguimient,$cadena2 = ""){

        $filename="Vista general";

        $data['subtitulo']      = 'Seguimientos a Vehículos: '.$filename;

        if ($cadena != "") {
            $data['msg'] = 'todos los registros de Seguimientos a Vehículos con filtro: '.$cadena.'';
        }
        else{
            $data['msg'] = 'todos los registros de Seguimientos a Vehículos';
        }

        //---Aquí va la info según sea el filtro de SP seleccionado
                $data['columns'] =  [
                                'Id',
                                'Folio 911',
                                'Folio Infra',
                                'Célula',
                                'Marca',
                                'Modelo',
                                'Placas',
                                'Color',
                                'Características'
                            ];  
                $data['field_names'] = [
                                'Id_Seguimiento_V',
                                'Folio_911',
                                'Folio_Infra',
                                'Celula_Seguimiento',
                                'Marca',
                                'Modelo',
                                'Placas',
                                'Color',
                                'Caracteristicas'
                            ];
          
        //---fin de la info del SP
        
        $data['rows'] = $seguimient;
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
    public function removeRangosFechasSesionSP(){

        if (isset($_REQUEST['filtroActual'])) {
            unset($_SESSION['userdata']->rango_inicio_sp);
            unset($_SESSION['userdata']->rango_fin_sp);

            header("Location: ".base_url."Seguimientos/index/?filtro=".$_REQUEST['filtroActual']);
            exit();
        }
        else{
            header("Location: ".base_url."Inicio");
            exit();
        }
    }

    //funcion para borrar variable sesión para filtro de rangos de fechas
    public function removeRangosFechasSesionSV(){

        if (isset($_REQUEST['filtroActual2'])) {
            unset($_SESSION['userdata']->rango_inicio_sv);
            unset($_SESSION['userdata']->rango_fin_sv);

            header("Location: ".base_url."Seguimientos/index/?filtro2=".$_REQUEST['filtroActual2']);
            exit();
        }
        else{
            header("Location: ".base_url."Inicio");
            exit();
        }
    }

    //función que filtra las columnas de seguimientos de personas deseadas por el usuario
    public function generateDropdownColumnsSP($filtro=1){
        //parte de permisos

        $dropDownColumn = '';
        //generación de dropdown dependiendo del filtro
        switch ($filtro) {
            case '1':
                $campos = ['Id Seguimiento','Folio 911','Folio infra','Célula de seguimiento','Nombre(s)','Apellido Paterno','Apellido Materno','Nombres falsos','Alias','Fecha de nacimiento','Edad','Lugar de origen','Teléfono','Domicilio','Ocupación','Red social','Nombre familiar','Parentesco','Vínculo grupo delictivo','Modus operandi','CDI','Violencia','Tipo de violencia','Delito vinculado','Especificación del delito','Áreas de Operación','Áreas de resguardo','Fecha de registro','Editar','Ver'];
            break;
        }
        //gestión de cada columna
        $ind = 1;
        foreach($campos as $campo){
            $checked = ($_SESSION['userdata']->columns_SP['column'.$ind] == 'show')?'checked':'';
            $dropDownColumn.= ' <div class="form-check">
                                    <input class="form-check-input checkColumns" type="checkbox" value="'.$_SESSION['userdata']->columns_SP['column'.$ind].'" onchange="hideShowColumn(this.id);" id="column'.$ind.'" '.$checked.'>
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

    //función que filtra las columnas de seguimientos de vehiculos deseadas por el usuario
    public function generateDropdownColumnsSV($filtro2=1){
        //parte de permisos

        $dropDownColumn2 = '';
        //generación de dropdown dependiendo del filtro
        switch ($filtro2) {
            case '1':
                $campos2 = ['Id Seguimiento','Folio 911','Folio infra','Célula de seguimiento','Marca','Modelo','Placas','Color','Características','Delito involucrado','CDI','Obra Placa','Modus operandi','Áreas de operación','Áreas de resguardo','Vinculación con persona o grupo delictivo','Fecha de registro','Editar','Ver'];
            break;
        }
        //gestión de cada columna
        $ind2 = 1;
        foreach($campos2 as $campo2){
            $checked = ($_SESSION['userdata']->columns_SV['c2olumn'.$ind2] == 'show')?'checked':'';
            $dropDownColumn2.= ' <div class="form-check">
                                    <input class="form-check-input checkColumns2" type="checkbox" value="'.$_SESSION['userdata']->columns_SV['c2olumn'.$ind2].'" onchange="hideShowColumn2(this.id);" id="c2olumn'.$ind2.'" '.$checked.'>
                                    <label class="form-check-label" for="c2olumn'.$ind2.'">
                                        '.$campo2.'
                                    </label>
                                </div>';
            $ind2++;
        }
        $dropDownColumn2.= '     <div class="dropdown-divider">
                                </div>
                                <div class="form-check">
                                    <input id="checkAll2" class="form-check-input" type="checkbox" value="hide" onchange="hideShowAll2(this.id);" id="c2olumn'.$ind2.'" checked>
                                    <label class="form-check-label" for="c2olumn'.$ind2.'">
                                        Todo
                                    </label>
                                </div>';
        return $dropDownColumn2;
    }

    //función para checar los cambios de filtro y poder asignar los valores correspondientes de las columnas a la session
    public function setColumnsSessionSP($filtroActual=1){
        //si el filtro existe y esta dentro de los parámetros continua
        if (isset($_SESSION['userdata']->filtro_SP) && $_SESSION['userdata']->filtro_SP >= MIN_FILTRO_SP && $_SESSION['userdata']->filtro_SP<=MAX_FILTRO_SP ) {
            //si cambia el filtro se procde a cambiar los valores de las columnas que contiene el filtro seleccionado
            if ($_SESSION['userdata']->filtro_SP != $filtroActual) {
                $_SESSION['userdata']->filtro_SP = $filtroActual;
                unset($_SESSION['userdata']->columns_SP); //se borra las columnas del anterior filtro
                //se asignan las nuevas columnas y por default se muestran todas (atributo show)
                for($i=0;$i<$this->numColumnsSP[$_SESSION['userdata']->filtro_SP -1];$i++) 
                    $_SESSION['userdata']->columns_SP['column'.($i+1)] = 'show';

            }
        }
        else{ //si no existe el filtro entonces se inicializa con el primero por default
            $_SESSION['userdata']->filtro_SP = $filtroActual;
            unset($_SESSION['userdata']->columns_SP);
            for($i=0;$i<$this->numColumnsSP[$_SESSION['userdata']->filtro_SP -1];$i++)
                $_SESSION['userdata']->columns_SP['column'.($i+1)] = 'show';

            
        }
        //echo "filtro: ".var_dump($_SESSION['userdata']->filtro_SP)."<br>br>";
        //echo "columns: ".var_dump($_SESSION['userdata']->columns_SP)."<br>br>";
    }

    //función para checar los cambios de filtro y poder asignar los valores correspondientes de las columnas a la session
    public function setColumnsSessionSV($filtroActual2=1){
        //si el filtro existe y esta dentro de los parámetros continua
        if (isset($_SESSION['userdata']->filtro_SV) && $_SESSION['userdata']->filtro_SV >= MIN_FILTRO_SV && $_SESSION['userdata']->filtro_SV<=MAX_FILTRO_SV ) {
            //si cambia el filtro se procde a cambiar los valores de las columnas que contiene el filtro seleccionado
            if ($_SESSION['userdata']->filtro_SV != $filtroActual2) {
                $_SESSION['userdata']->filtro_SV = $filtroActual2;
                unset($_SESSION['userdata']->columns_SV); //se borra las columnas del anterior filtro
                //se asignan las nuevas columnas y por default se muestran todas (atributo show)
                for($i=0;$i<$this->numColumnsSV[$_SESSION['userdata']->filtro_SV -1];$i++) 
                    $_SESSION['userdata']->columns_SV['c2olumn'.($i+1)] = 'show';

            }
        }
        else{ //si no existe el filtro entonces se inicializa con el primero por default
            $_SESSION['userdata']->filtro_SV = $filtroActual2;
            unset($_SESSION['userdata']->columns_SV);
            for($i=0;$i<$this->numColumnsSV[$_SESSION['userdata']->filtro_SV -1];$i++)
                $_SESSION['userdata']->columns_SV['c2olumn'.($i+1)] = 'show';

            
        }
        //echo "filtro: ".var_dump($_SESSION['userdata']->filtro_SV)."<br>br>";
        //echo "columns: ".var_dump($_SESSION['userdata']->columns_SV)."<br>br>";
    }

    //función fetch que actualiza los valores de las columnas para la session
    public function setColumnFetchSP(){
        if (isset($_POST['columName']) && isset($_POST['valueColumn'])) {
            $_SESSION['userdata']->columns_SP[$_POST['columName']] = $_POST['valueColumn'];
            echo json_encode("ok");
        }
        else{
            header("Location: ".base_url."Inicio");
            exit();
        }
    }

    //función fetch que actualiza los valores de las columnas para la session
    public function setColumnFetchSV(){
        if (isset($_POST['columName2']) && isset($_POST['valueColumn2'])) {
            $_SESSION['userdata']->columns_SV[$_POST['columName2']] = $_POST['valueColumn2'];
            echo json_encode("ok");
        }
        else{
            header("Location: ".base_url."Inicio");
            exit();
        }
    }


    public function generarExportLinksSP($extra_cad = "",$filtro = 1){
        if ($extra_cad != "") {
            $dataReturn['csv'] =  base_url.'Seguimientos/exportarInfoSP/?tipo_export=CSV'.$extra_cad.'&filtroActual='.$filtro;
            $dataReturn['excel'] =  base_url.'Seguimientos/exportarInfoSP/?tipo_export=EXCEL'.$extra_cad.'&filtroActual='.$filtro;
            $dataReturn['pdf'] =  base_url.'Seguimientos/exportarInfoSP/?tipo_export=PDF'.$extra_cad.'&filtroActual='.$filtro;
            //return $dataReturn;
        }
        else{
            $dataReturn['csv'] =  base_url.'Seguimientos/exportarInfoSP/?tipo_export=CSV'.'&filtroActual='.$filtro;
            $dataReturn['excel'] =  base_url.'Seguimientos/exportarInfoSP/?tipo_export=EXCEL'.'&filtroActual='.$filtro;
            $dataReturn['pdf'] =  base_url.'Seguimientos/exportarInfoSP/?tipo_export=PDF'.'&filtroActual='.$filtro;
        }
        return $dataReturn;
    }

    public function generarExportLinksSV($extra_cad2 = "",$filtro2 = 1){
        if ($extra_cad2 != "") {
            $dataReturn['csv'] =  base_url.'Seguimientos/exportarInfoSV/?tipo_export2=CSV'.$extra_cad2.'&filtroActual2='.$filtro2;
            $dataReturn['excel'] =  base_url.'Seguimientos/exportarInfoSV/?tipo_export2=EXCEL'.$extra_cad2.'&filtroActual2='.$filtro2;
            $dataReturn['pdf'] =  base_url.'Seguimientos/exportarInfoSV/?tipo_export2=PDF'.$extra_cad2.'&filtroActual2='.$filtro2;
            //return $dataReturn;
        }
        else{
            $dataReturn['csv'] =  base_url.'Seguimientos/exportarInfoSV/?tipo_export2=CSV'.'&filtroActual2='.$filtro2;
            $dataReturn['excel'] =  base_url.'Seguimientos/exportarInfoSV/?tipo_export2=EXCEL'.'&filtroActual2='.$filtro2;
            $dataReturn['pdf'] =  base_url.'Seguimientos/exportarInfoSV/?tipo_export2=PDF'.'&filtroActual2='.$filtro2;
        }
        return $dataReturn;
    }

    public function generarLinksSP($numPage,$total_pages,$extra_cad = "", $filtro = 1){
        //$extra_cad sirve para determinar la paginacion conforme a si se realizó una busqueda
        //Creación de links para el pagination
        $links = "";

        //FLECHA IZQ (PREV PAGINATION)
        if ($numPage>1) {
            $links.= '<li class="page-item">
                        <a class="page-link" href=" '.base_url.'Seguimientos/index/?numPage=1'.$extra_cad.'&filtro='.$filtro.' " data-toggle="tooltip" data-placement="top" title="Primera página">
                            <i class="material-icons">first_page</i>
                        </a>
                    </li>';
            $links.= '<li class="page-item">
                        <a class="page-link" href=" '.base_url.'Seguimientos/index/?numPage='.($numPage-1).$extra_cad.'&filtro='.$filtro.' " data-toggle="tooltip" data-placement="top" title="Página anterior">
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
                            <a class="page-link" href=" '.base_url.'Seguimientos/index/?numPage='.($ind).$extra_cad.'&filtro='.$filtro.' ">
                                '.($ind).'
                            </a>
                        </li>';
            }
        }

        //FLECHA DERECHA (NEXT PAGINATION)
        if ($numPage<$total_pages) {

            $links.= '<li class="page-item">
                        <a class="page-link" href=" '.base_url.'Seguimientos/index/?numPage='.($numPage+1).$extra_cad.'&filtro='.$filtro.' " data-toggle="tooltip" data-placement="top" title="Siguiente página">
                        <i class="material-icons">navigate_next</i>
                        </a>
                    </li>';
            $links.= '<li class="page-item">
                        <a class="page-link" href=" '.base_url.'Seguimientos/index/?numPage='.($total_pages).$extra_cad.'&filtro='.$filtro.' " data-toggle="tooltip" data-placement="top" title="Última página">
                        <i class="material-icons">last_page</i>
                        </a>
                    </li>';
        }

        return $links;
    }

    public function generarLinksSV($numPage2,$total_pages2,$extra_cad2 = "", $filtro2 = 1){
        //$extra_cad sirve para determinar la paginacion conforme a si se realizó una busqueda
        //Creación de links para el pagination
        $links = "";

        //FLECHA IZQ (PREV PAGINATION)
        if ($numPage2>1) {
            $links.= '<li class="page-item">
                        <a class="page-link" href=" '.base_url.'Seguimientos/index/?numPage2=1'.$extra_cad2.'&filtro2='.$filtro2.' " data-toggle="tooltip" data-placement="top" title="Primera página">
                            <i class="material-icons">first_page</i>
                        </a>
                    </li>';
            $links.= '<li class="page-item">
                        <a class="page-link" href=" '.base_url.'Seguimientos/index/?numPage2='.($numPage2-1).$extra_cad2.'&filtro2='.$filtro2.' " data-toggle="tooltip" data-placement="top" title="Página anterior">
                            <i class="material-icons">navigate_before</i>
                        </a>
                    </li>';
        }

        //DESPLIEGUE DE PAGES NUMBER
        $LINKS_EXTREMOS = GLOBAL_LINKS_EXTREMOS; //numero máximo de links a la izquierda y a la derecha
        for ($ind=($numPage2-$LINKS_EXTREMOS); $ind<=($numPage2+$LINKS_EXTREMOS); $ind++) {
            if(($ind>=1) && ($ind <= $total_pages2)){

                $activeLink = ($ind == $numPage2)? 'active':'';

                $links.= '<li class="page-item '.$activeLink.' ">
                            <a class="page-link" href=" '.base_url.'Seguimientos/index/?numPage2='.($ind).$extra_cad2.'&filtro2='.$filtro2.' ">
                                '.($ind).'
                            </a>
                        </li>';
            }
        }

        //FLECHA DERECHA (NEXT PAGINATION)
        if ($numPage2<$total_pages2) {

            $links.= '<li class="page-item">
                        <a class="page-link" href=" '.base_url.'Seguimientos/index/?numPage2='.($numPage2+1).$extra_cad2.'&filtro2='.$filtro2.' " data-toggle="tooltip" data-placement="top" title="Siguiente página">
                        <i class="material-icons">navigate_next</i>
                        </a>
                    </li>';
            $links.= '<li class="page-item">
                        <a class="page-link" href=" '.base_url.'Seguimientos/index/?numPage2='.($total_pages2).$extra_cad2.'&filtro2='.$filtro2.' " data-toggle="tooltip" data-placement="top" title="Última página">
                        <i class="material-icons">last_page</i>
                        </a>
                    </li>';
        }

        return $links;
    }

    public function generarInfoTableSP($seguimientos,$filtro = 1){
            //se genera la tabulacion de la informacion por backend
            $infoTable['header'] = "";
            $infoTable['body'] = "";

             switch ($filtro) {
                case '1': //general
                $infoTable['header'] = '
                                        <th class="column1">#</th>
                                        <th class="column2">Folio 911</th>
                                        <th class="column3">Folio Infra</th>
                                        <th class="column4">Célula Seguimiento</th>
                                        <th class="column5">Nombre (s)</th>
                                        <th class="column6">Apellido paterno</th>
                                        <th class="column7">Apellido materno</th>
                                        <th class="column8">Nombres falsos</th>
                                        <th class="column9">Alias</th>
                                        <th class="column10">Fecha de nacimiento</th>
                                        <th class="column11">Edad</th>
                                        <th class="column12">Lugar de origen</th>
                                        <th class="column13">Teléfono</th>
                                        <th class="column14">Domicilio</th>
                                        <th class="column15">Ocupación</th>
                                        <th class="column16">Red social</th>
                                        <th class="column17">Nombre del familiar</th>
                                        <th class="column18">Parentesco</th>
                                        <th class="column19">Vínculo grupo delictivo</th>
                                        <th class="column20">Modus operandi</th>
                                        <th class="column21">CDI</th>
                                        <th class="column22">Violencia</th>
                                        <th class="column23">Tipo de violencia</th>
                                        <th class="column24">Delito vinculado</th>
                                        <th class="column25">Especificación del delito</th>
                                        <th class="column26">Áreas de operación</th>
                                        <th class="column27">Áreas de resguardo</th>
                                        <th class="column28">Fecha de registro</th>
                                        <th class="column29">Editar</th>
                                        <th class="column30">Ver</th>
                                        ';
            foreach ($seguimientos as $segpv) {

                $domicilio="";
                if(($segpv->Colonia)!=null) 
                {
                    $domicilio='COLONIA: '.mb_strtoupper($segpv->Colonia).', CALLE: '.mb_strtoupper($segpv->Calle).', INTERIOR: '.mb_strtoupper($segpv->No_Interior).', CP: '.mb_strtoupper($segpv->CP);

                    if($segpv->No_Exterior!=null) 
                    {
                        $domicilio='COLONIA: '.mb_strtoupper($segpv->Colonia).', CALLE: '.mb_strtoupper($segpv->Calle).', EXTERIOR: '.mb_strtoupper($segpv->No_Exterior).', INTERIOR: '.mb_strtoupper($segpv->No_Interior).', CP: '.mb_strtoupper($segpv->CP);                        
                    }
                }

                $infoTable['body'].= '<tr>';
                $infoTable['body'].= '<td class="column1">'.$segpv->Id_Seguimiento_P.'</td>';
                $infoTable['body'].= '<td class="column2">'.mb_strtoupper($segpv->Folio_911).'</td>';
                $infoTable['body'].= '<td class="column3">'.mb_strtoupper($segpv->Folio_Infra).'</td>';
                $infoTable['body'].= '<td class="column4">'.$segpv->Celula_Seguimiento.'</td>';
                $infoTable['body'].= '<td class="column5">'.mb_strtoupper($segpv->Nombre1).' '.mb_strtoupper($segpv->Nombre2).' '.mb_strtoupper($segpv->Nombre3).'</td>';
                $infoTable['body'].= '<td class="column6">'.mb_strtoupper($segpv->Ap_Paterno).'</td>';
                $infoTable['body'].= '<td class="column7">'.mb_strtoupper($segpv->Ap_Materno).'</td>';
                $infoTable['body'].= '<td class="column8">'.mb_strtoupper($segpv->Otros_Nombres_Falsos).'</td>';
                $infoTable['body'].= '<td class="column9">'.mb_strtoupper($segpv->Alias).'</td>';
                $infoTable['body'].= '<td class="column10">'.$segpv->Fecha_Nacimiento.'</td>';
                $infoTable['body'].= '<td class="column11">'.$segpv->Edad.'</td>';
                $infoTable['body'].= '<td class="column12">'.mb_strtoupper($segpv->Lugar_Origen).'</td>';
                $infoTable['body'].= '<td class="column13">'.$segpv->Telefono.'</td>';
                $infoTable['body'].= '<td class="column14">'.$domicilio.'</td>';
                $infoTable['body'].= '<td class="column15">'.mb_strtoupper($segpv->Ocupacion).'</td>';
                $infoTable['body'].= '<td class="column16">'.mb_strtoupper($segpv->Link_Red_Social).'</td>';
                $infoTable['body'].= '<td class="column17">'.mb_strtoupper($segpv->Nombre_Familiar).'</td>';
                $infoTable['body'].= '<td class="column18">'.mb_strtoupper($segpv->Parentezco).'</td>';
                $infoTable['body'].= '<td class="column19">'.mb_strtoupper($segpv->Vinculo_Grupo_Banda).'</td>';
                $infoTable['body'].= '<td class="column20">'.mb_strtoupper($segpv->Modus_Operandi).'</td>';
                $infoTable['body'].= '<td class="column21">'.mb_strtoupper($segpv->CDI).'</td>';
                $infoTable['body'].= '<td class="column22">'.$segpv->Violencia=$segpv->Violencia=='1'?'SI':'NO'.'</td>';
                $infoTable['body'].= '<td class="column23">'.mb_strtoupper($segpv->Tipo_Violencia).'</td>';  
                $infoTable['body'].= '<td class="column24">'.mb_strtoupper($segpv->Delito_Vinculado).'</td>';
                $infoTable['body'].= '<td class="column25">'.mb_strtoupper($segpv->Especificacion_Delito).'</td>'; 
                $infoTable['body'].= '<td class="column26">'.mb_strtoupper($segpv->Areas_Operacion).'</td>';
                $infoTable['body'].= '<td class="column27">'.mb_strtoupper($segpv->Areas_Resguardo).'</td>';
                $infoTable['body'].= '<td class="column28">'.$segpv->Fecha_Registro_SP.'</td>';               

                $infoTable['body'].= '  <td class="column29">
                                    <a class="myLinks" href="'.base_url.'Seguimientos/editarSegP/?id_sp='.$segpv->Id_Seguimiento_P.'">
                                        <i class="material-icons">edit</i>
                                    </a>
                                </td>
                                <td class="column30">
                                    <a class="myLinks" href="'.base_url.'Seguimientos/verSP/?id_sp='.$segpv->Id_Seguimiento_P.'">
                                        <i class="material-icons">visibility</i>
                                    </a>
                                </td>';
                $infoTable['body'].= '</tr>';
              }
              break;
                
            }
            return $infoTable;
    }

    public function generarInfoTableSV($seguimientos2,$filtro2 = 1){
            //se genera la tabulacion de la informacion por backend
            $infoTable2['header'] = "";
            $infoTable2['body'] = "";

             switch ($filtro2) {
                case '1': //general
              
                $infoTable2['header'] = '
                                        <th class="c2olumn1">#</th>
                                        <th class="c2olumn2">Folio 911</th>
                                        <th class="c2olumn3">Folio Infra</th>
                                        <th class="c2olumn4">Célula de Seguimiento</th>
                                        <th class="c2olumn5">Marca</th>
                                        <th class="c2olumn6">Modelo</th>
                                        <th class="c2olumn7">Placas</th>
                                        <th class="c2olumn8">Color</th>
                                        <th class="c2olumn9">Características</th>
                                        <th class="c2olumn10">Delito involucrado</th>
                                        <th class="c2olumn11">CDI</th>
                                        <th class="c2olumn12">Obra placa en CDI</th>
                                        <th class="c2olumn13">Modus Operandi</th>
                                        <th class="c2olumn14">Áreas de Operacion</th>
                                        <th class="c2olumn15">Áreas de resguardo</th>
                                        <th class="c2olumn16">Vinculación con persona o banda delictiva</th>
                                        <th class="c2olumn17">Fecha de registro</th>
                                        <th class="c2olumn18">Editar</th>
                                        <th class="c2olumn19">Ver</th>
                                        ';
            foreach ($seguimientos2 as $segpv) {

                $infoTable2['body'].= '<tr>';
                $infoTable2['body'].= '  <td class="c2olumn1">'.mb_strtoupper($segpv->Id_Seguimiento_V).'</td>';
                $infoTable2['body'].= '<td class="c2olumn2">'.mb_strtoupper($segpv->Folio_911).'</td>';
                $infoTable2['body'].= '<td class="c2olumn3">'.mb_strtoupper($segpv->Folio_Infra).'</td>';
                $infoTable2['body'].= '<td class="c2olumn4">'.$segpv->Celula_Seguimiento.'</td>';
                $infoTable2['body'].= '<td class="c2olumn5">'.mb_strtoupper($segpv->Marca).'</td>';
                $infoTable2['body'].= '<td class="c2olumn6">'.mb_strtoupper($segpv->Modelo).'</td>';
                $infoTable2['body'].= '<td class="c2olumn7">'.mb_strtoupper($segpv->Placas).'</td>';
                $infoTable2['body'].= '<td class="c2olumn8">'.mb_strtoupper($segpv->Color).'</td>';
                $infoTable2['body'].= '<td class="c2olumn9">'.mb_strtoupper($segpv->Caracteristicas).'</td>';
                $infoTable2['body'].= '<td class="c2olumn10">'.mb_strtoupper($segpv->Delito_Involucrado).'</td>';
                $infoTable2['body'].= '<td class="c2olumn11">'.mb_strtoupper($segpv->CDI).'</td>';
                //$obra_placa_cdi = "";
                //if(($segpv->Obra_Placa)==1){$obra_placa_cdi = "SI";}else{$obra_placa_cdi = "NO";}
                $infoTable2['body'].= '<td class="c2olumn12">'.$segpv->Obra_Placa=$segpv->Obra_Placa=='1' ? 'SI' : 'NO'.'</td>';
                $infoTable2['body'].= '<td class="c2olumn13">'.mb_strtoupper($segpv->Modus_Operandi).'</td>';
                $infoTable2['body'].= '<td class="c2olumn14">'.mb_strtoupper($segpv->Areas_Operacion).'</td>';
                $infoTable2['body'].= '<td class="c2olumn15">'.mb_strtoupper($segpv->Areas_Resguardo).'</td>';
                $infoTable2['body'].= '<td class="c2olumn16">'.mb_strtoupper($segpv->Vinculacion_Banda_Persona).'</td>';
                $infoTable2['body'].= '<td class="c2olumn17">'.$segpv->Fecha_Registro_SV.'</td>';
                $infoTable2['body'].= '  <td class="c2olumn18">
                                    <a class="myLinks" href="'.base_url.'Seguimientos/editarSegV/?id_sv='.$segpv->Id_Seguimiento_V.'">
                                        <i class="material-icons">edit</i>
                                    </a>
                                </td>
                                <td class="c2olumn19">
                                    <a class="myLinks" href="'.base_url.'Seguimientos/verSV/?id_sv='.$segpv->Id_Seguimiento_V.'">
                                        <i class="material-icons">visibility</i>
                                    </a>
                                </td>';
                $infoTable2['body'].= '</tr>';
              }
              break;
                
            }
            return $infoTable2;
    }

    public function buscarSPPorCadena(){
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Seguimientos[3] != '1')) {
            header("Location: ".base_url."Inicio");
            exit();
        }

        if (isset($_POST['cadena'])) {
            $cadena = trim($_POST['cadena']);
            $filtroActual = trim($_POST['filtroActual']);

            $results = $this->Seguimiento->getSPByCadena($cadena,$filtroActual);
            $extra_cad = ($cadena != "")?("&cadena=".$cadena):""; //para links conforme a búsqueda

            //$dataReturn = "jeje";

            $dataReturn['infoTable'] = $this->generarInfoTableSP($results['seguimient'],$filtroActual);
            $dataReturn['links'] = $this->generarLinksSP($results['numPage'],$results['total_pages'],$extra_cad,$filtroActual);
            $dataReturn['export_links'] = $this->generarExportLinksSP($extra_cad,$filtroActual);
            $dataReturn['total_rows'] = "Total registros: ".$results['total_rows'];
            $dataReturn['dropdownColumns'] = $this->generateDropdownColumnsSP($filtroActual);
            echo json_encode($dataReturn);
        }
        else{
            header("Location: ".base_url."Inicio");
            exit();
        }
    }

    public function buscarSVPorCadena(){
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Seguimientos[3] != '1')) {
            header("Location: ".base_url."Inicio");
            exit();
        }

        if (isset($_POST['cadena2'])) {
            $cadena2 = trim($_POST['cadena2']);
            $filtroActual2 = trim($_POST['filtroActual2']);

            $results2 = $this->Seguimiento->getSVByCadena($cadena2,$filtroActual2);
            $extra_cad2 = ($cadena2 != "")?("&cadena2=".$cadena2):""; //para links conforme a búsqueda

            //$dataReturn = "jeje";

            $dataReturn['infoTable2'] = $this->generarInfoTableSV($results2['seguimient2'],$filtroActual2);
            $dataReturn['links2'] = $this->generarLinksSV($results2['numPage2'],$results2['total_pages2'],$extra_cad2,$filtroActual2);
            $dataReturn['export_links2'] = $this->generarExportLinksSV($extra_cad2,$filtroActual2);
            $dataReturn['total_rows2'] = "Total registros: ".$results2['total_rows2'];
            $dataReturn['dropdownColumns2'] = $this->generateDropdownColumnsSV($filtroActual2);
            echo json_encode($dataReturn);
        }
        else{
            header("Location: ".base_url."Inicio");
            exit();
        }
    }

    public function uploadpdfCDISeguimientoP($name,$file,$path_carpeta,$path_file)
    {
        $allowed_mime_type_arr = array('pdf');
        $arrayAux = explode('.', $file['sppdfcdi']['name']);
        $mime = end($arrayAux);
        
        if((isset($file['sppdfcdi']['name'])) && ($file['sppdfcdi']['name']!="")){
            if(in_array($mime, $allowed_mime_type_arr)){
                $band = true;
            }else{
                $band = false;
            }
        }else{
            $band = false;
        }

        /* ----- ----- ----- Existe la carpeta ----- ----- ----- */
        if(!file_exists($path_carpeta))
            mkdir($path_carpeta, 0777, true);
            
        if($band){
            move_uploaded_file($file['sppdfcdi']['tmp_name'],$path_file);
        }

        return $band;
    }

    public function uploadpdfCDISeguimientoV($name,$file,$path_carpeta,$path_file)
    {
        $allowed_mime_type_arr = array('pdf');
        $arrayAux = explode('.', $file['svpdfcdi']['name']);
        $mime = end($arrayAux);
        
        if((isset($file['svpdfcdi']['name'])) && ($file['svpdfcdi']['name']!="")){
            if(in_array($mime, $allowed_mime_type_arr)){
                $band = true;
            }else{
                $band = false;
            }
        }else{
            $band = false;
        }

        /* ----- ----- ----- Existe la carpeta ----- ----- ----- */
        if(!file_exists($path_carpeta))
            mkdir($path_carpeta, 0777, true);
            
        if($band){
            move_uploaded_file($file['svpdfcdi']['tmp_name'],$path_file);
        }

        return $band;
    }

    public function obtenerIp()
    {
        $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $hosts = gethostbynamel($hostname);
        if (is_array($hosts)) {
            foreach ($hosts as $ip) {
                return $ip;
            }
        }else{
            return $ip = '0.0.0.0';
        }
    }

    //Función para borrar carpetas de grupos
    public function removeOnlyFilesDir($dir,$ind) { //si ind == 1 no borra el directorio original, caso contrario, si lo borra
           $files = array_diff(scandir($dir), array('.','..'));
            foreach ($files as $file) {
              (is_dir("$dir/$file")) ? $this->removeOnlyFilesDir("$dir/$file",false) : unlink("$dir/$file");
            }

            if ($ind) return;
            else return rmdir($dir);
    }

    public function formatearFecha($fecha = null){
            //$fecha = "2020-01-20 15:30:00";
            //$date = new DateTime($fecha);
            //se asigna hora local en México
            setlocale(LC_TIME, 'es_CO.UTF-8');
            $results = strftime("%A, %d  de %B del %G", strtotime($fecha))." a las ".date('g:i a', strtotime($fecha));;

            return $results;
        }

        public function uploadImageFileSeguimientos($name,$file,$carpeta,$fileName)
        {
            $type = $file[$name]['type'];
            $extension = explode("/",$type);

            $imageUploadPath = $carpeta.$fileName;
            $allowed_mime_type_arr = array('jpeg','png','jpg','PNG');

            if(!file_exists($carpeta))
                mkdir($carpeta, 0777, true);

            if(in_array($extension[1], $allowed_mime_type_arr)){
                $img_temp = $file[$name]['tmp_name'];
                $compressedImg = $this->compressImage($img_temp, $imageUploadPath, 75);
                $band = true;
            }else{
                $band = false;
            }

            return $band;
        }

        public function compressImage($source, $destination, $quality)
        {
            $imgInfo = getimagesize($source);
            $mime = $imgInfo['mime'];

            switch($mime){
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

        public function uploadImagePhotoSeguimientos($img,$carpeta,$ruta)
        {   
            /* ----- ----- ----- Existe la carpeta ----- ----- ----- */
            if(!file_exists($carpeta))
                mkdir($carpeta, 0777, true);
                
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            file_put_contents($ruta, $image_base64);

            return $image_base64;
        }

        public function getTatuajes()
        {
            $data = $this->Catalogo->getSimpleCatalogo("Tipo_Tatuaje", "catalogo_tatuaje");
            return $data;
        }

        public function getMarcasVehiculos()
        {
            $data = $this->Catalogo->getSimpleCatalogo("Marca", 'catalogo_vehiculo_ocra');
            return $data;
        }
    }



?>