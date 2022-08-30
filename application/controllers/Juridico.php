<?php

class Juridico extends Controller
{
    public $JuridicoM;
    public $Remision;
    public $DictamenM;
    public $FV;
    public $Catalogo;

    public function __construct()
    {
        $this->JuridicoM = $this->model('JuridicoM');
        $this->Remision = $this->model('Remision');
        $this->DictamenM = $this->model('DictamenM');
        $this->FV = new FormValidator();
        $this->Catalogo = $this->model('Catalogo');
        $this->numColumnsJUR = [8];  //se inicializa el número de columns por cada filtro
    }

    public function index()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $data = [
            'titulo'    => 'Planeación | Jurídico',
            'extra_css'  => '<link rel="stylesheet" href="' . base_url . 'public/css/system/juridico/index.css">',
            'extra_js'  => '<script src="' . base_url . 'public/js/system/juridico/index.js"></script>'
        ];

        //PROCESO DE FILTRADO DE JURÍDICO

        if (isset($_GET['filtro']) && is_numeric($_GET['filtro']) && $_GET['filtro'] >= MIN_FILTRO_JUR && $_GET['filtro'] <= MAX_FILTRO_JUR) { //numero de catálogo
            $filtro = $_GET['filtro'];
        } else {
            $filtro = 1;
        }

        //PROCESAMIENTO DE LAS COLUMNAS 
        $this->setColumnsSession($filtro);
        $data['columns_INSP'] = $_SESSION['userdata']->columns_JUR;

        //PROCESAMIENTO DE RANGO DE FOLIOS
        if (isset($_POST['rango_inicio']) && isset($_POST['rango_fin']) && isset($_POST['rango_hora_inicio']) && isset($_POST['rango_hora_fin'])) {
            $_SESSION['userdata']->rango_inicio_jur = $_POST['rango_inicio'];
            $_SESSION['userdata']->rango_fin_jur = $_POST['rango_fin'];
            $_SESSION['userdata']->rango_hora_inicio_jur = $_POST['rango_hora_inicio'];
            $_SESSION['userdata']->rango_hora_fin_jur = $_POST['rango_hora_fin'];
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

        $where_sentence = $this->JuridicoM->generateFromWhereSentence($cadena, $filtro);
        $extra_cad = ($cadena != "") ? ("&cadena=" . $cadena) : ""; //para links conforme a búsqueda

        $no_of_records_per_page = NUM_MAX_REG_PAGE; //total de registros por pagination
        $offset = ($numPage - 1) * $no_of_records_per_page; // desplazamiento conforme a la pagina

        $results_rows_pages = $this->JuridicoM->getTotalPages($no_of_records_per_page, $where_sentence);   //total de páginas de acuerdo a la info de la DB
        $total_pages = $results_rows_pages['total_pages'];

        if ($numPage > $total_pages) {
            $numPage = 1;
            $offset = ($numPage - 1) * $no_of_records_per_page;
        } //seguridad si ocurre un error por url     

        $rows_Juridico = $this->JuridicoM->getDataCurrentPage($offset, $no_of_records_per_page, $where_sentence);    //se obtiene la información de la página actual

        //guardamos la tabulacion de la información para la vista
        $data['infoTable'] = $this->generarInfoTable($rows_Juridico, $filtro);
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
        }



        $this->view('templates/header', $data);
        $this->view('system/Juridico/Index', $data);
        $this->view('templates/footer', $data);
    }

    public function Puesta($id_puesta, $accion = 'nueva')
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        } else {
            if (!$this->JuridicoM->existeRegistroTabla('iph_puesta_disposicion', ['Id_Puesta'], [$id_puesta])) {
                header("Location: " . base_url . "Juridico");
                exit();
            } else {
                if ($accion != 'nueva') {
                    if ($accion != 'ver') {
                        header("Location: " . base_url . "Juridico");
                        exit();
                    } else {
                        $data = [
                            'titulo'    => 'Planeación | Jurídico',
                            'extra_css'  => '<link rel="stylesheet" href="' . base_url . 'public/css/system/juridico/nueva.css">
                                            <link rel="stylesheet" href="' . base_url . 'public/css/libraries/dropzone.css">',
                            'extra_js'  => '<script src="https://maps.googleapis.com/maps/api/js?key=' . API_KEY . '&callback=initMap&libraries=places" async defer></script>
                                            <script src="' . base_url . 'public/js/libraries/dropzone.js"></script>
                                            <script src="' . base_url . 'public/js/maps/juridico/nueva.js"></script>
                                            <script src="' . base_url . 'public/js/system/juridico/nuevo/viewEdit.js"></script>
                                            <script src="' . base_url . 'public/js/system/juridico/generalFunctions.js"></script>
                                            <script src="' . base_url . 'public/js/system/juridico/nuevo/validations.js"></script>
                                            <script src="' . base_url . 'public/js/system/juridico/nuevo/index.js"></script>
                                            <script src="' . base_url . 'public/js/system/juridico/nuevo/docComplementaria.js"></script>
                                            <script src="' . base_url . 'public/js/system/juridico/nuevo/compararDocx.js"></script>
                                            <script src="' . base_url . 'public/js/system/juridico/nuevo/borrarRegistro.js"></script>
                                            ',
                            'data_puesta' => $this->JuridicoM->getPuesta($id_puesta),
                            'Id_Puesta'   => $id_puesta,
                            'button'      => true
                        ];
                    }
                } else {
                    $data = [
                        'titulo'    => 'Planeación | Jurídico',
                        'extra_css'  => '<link rel="stylesheet" href="' . base_url . 'public/css/system/juridico/nueva.css">
                                        <link rel="stylesheet" href="' . base_url . 'public/css/libraries/dropzone.css">',
                        'extra_js'  => '<script src="https://maps.googleapis.com/maps/api/js?key=' . API_KEY . '&callback=initMap&libraries=places" async defer></script>
                                        <script src="' . base_url . 'public/js/libraries/dropzone.js"></script>
                                        <script src="' . base_url . 'public/js/maps/juridico/nueva.js"></script>
                                        <script src="' . base_url . 'public/js/system/juridico/generalFunctions.js"></script>
                                        <script src="' . base_url . 'public/js/system/juridico/nuevo/validations.js"></script>
                                        <script src="' . base_url . 'public/js/system/juridico/nuevo/index.js"></script>
                                        <script src="' . base_url . 'public/js/system/juridico/nuevo/docComplementaria.js"></script>
                                        <script src="' . base_url . 'public/js/system/juridico/nuevo/compararDocx.js"></script>
                                        <script src="' . base_url . 'public/js/system/juridico/nuevo/borrarRegistro.js"></script>
                                        ',
                        'data_puesta' => $this->JuridicoM->getPuesta($id_puesta),
                        'Id_Puesta'   => $id_puesta,
                        'button'      => false
                    ];
                }
                $anexosRows = $this->getAnexosIndex($id_puesta);
                $data['collapse_anexoA'] = $this->generateBodyCollapseAnexo('A', $anexosRows['anexoA']);
                $data['collapse_anexoB'] = $this->generateBodyCollapseAnexo('B', $anexosRows['anexoB']);
                $data['hide_anexoB'] = ($anexosRows['anexoB'] && count($anexosRows['anexoB']) == 1)?'mi_hide':'';
                $data['collapse_anexoC'] = $this->generateBodyCollapseAnexo('C', $anexosRows['anexoC']);
                $data['collapse_anexoD1'] = $this->generateBodyCollapseAnexo('D1', $anexosRows['anexoD']['Armas']);
                $data['collapse_anexoD2'] = $this->generateBodyCollapseAnexo('D2', $anexosRows['anexoD']['Objetos']);
                $data['popover_anexoD'] = '
                    <div class=\'row\'>
                        <div class=\'col-6 my-3 d-flex justify-content-center\'>
                            <a class=\'btn btn-primary btn-sm\' href=\'' . base_url . 'Juridico/AnexoD/arma/' . $data['Id_Puesta'] . '\'>
                                Arma
                            </a>
                        </div>
                        <div class=\'col-6 my-3 d-flex justify-content-center\'>
                            <a class=\'btn btn-primary btn-sm\' href=\'' . base_url . 'Juridico/AnexoD/objeto/' . $data['Id_Puesta'] . '\'>
                                Objeto
                            </a>
                        </div>
                    </div>';
                $data['collapse_anexoE'] = $this->generateBodyCollapseAnexo('E', $anexosRows['anexoE']);
                $data['collapse_anexoF'] = $this->generateBodyCollapseAnexo('F', $anexosRows['anexoF']);
                $data['hide_anexoF'] = ($anexosRows['anexoF'] && count($anexosRows['anexoF']) == 1)?'mi_hide':'';

                $this->view('templates/header', $data);
                $this->view('system/Juridico/nuevoIPH', $data);
                $this->view('templates/footer', $data);
            }
        }
    }

/* ------------------------------FUNCIONES ANEXO A------------------------------ */
    public function AnexoA()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $data = [
            'titulo'    => 'Planeación | Anexo A',
            'extra_css' => '<link rel="stylesheet" href="' . base_url . 'public/css/system/juridico/anexos/A/nuevo.css">',
            'extra_js'  =>  '<script src="' . base_url . 'public/js/maps/juridico/anexoA.js"></script>' .
                '<script src="https://maps.googleapis.com/maps/api/js?key=' . API_KEY . '&callback=initMap&libraries=places" async defer></script>' .
                '<script src="' . base_url . 'public/js/system/juridico/anexos/A/camposForm.js"></script>' .
                '<script src="' . base_url . 'public/js/system/juridico/anexos/A/pertenenciaTable.js"></script>' .
                '<script src="' . base_url . 'public/js/system/juridico/anexos/A/validacionesForm.js"></script>' .
                '<script src="' . base_url . 'public/js/system/juridico/anexos/A/elementos.js"></script>'
        ];

        //checar si se envia id de la puesta (requerido)
        if (isset($_GET['id_puesta']) && is_numeric($_GET['id_puesta'])) { //id puesta
            $data['id_puesta'] = $_GET['id_puesta'];
            if (!$this->JuridicoM->existeRegistroTabla('iph_puesta_disposicion', ['Id_Puesta'], [$data['id_puesta']])) { //si no existe la puesta con ese id entonces se sale de ese proceso por posible manipulación desde la url
                header("Location: " . base_url . "Juridico");
                exit();
            } else { //la puesta existe, entonces se comprueba el id del detenido si es que existe
                if (isset($_GET['id_detenido']) && is_numeric($_GET['id_detenido'])) { //numero de detenido
                    $data['id_detenido'] = $_GET['id_detenido'];
                    if (!$this->JuridicoM->existeRegistroTabla('iph_detenido', ['Id_Detenido'], [$data['id_detenido']])) { //si no existe el detenido entonces se sale de ese proceso por posible manipulación desde la url
                        header("Location: " . base_url . "Juridico");
                        exit();
                    } else { //existe puesta y detenido entonces se trata de Editar/Ver se carga javascript para cargar la info previa
                        $data['extra_js'] .= '<script src="' . base_url . 'public/js/system/juridico/anexos/A/getInfo.js"></script>';
                    }
                } else {
                    $data['id_detenido'] = -1;
                } //la puesta si existe pero no hay detenido entonces es nuevo detenido Insert
            }
        } else { //la url esta mal desde el inicio por posible manipulación, no hay necesidad de feedback
            header("Location: " . base_url . "Juridico");
            exit();
        }

        $user = $_SESSION['userdata']->Id_Usuario;
        $ip = $this->obtenerIp();
        $descripcion = 'Ver AnexoA, Puesta: ' . $_GET['id_puesta'];
        $this->Remision->historial($user, $ip, 18, $descripcion);

        $this->view('templates/header', $data);
        $this->view('system/Juridico/anexos/A/anexoAView', $data);
        $this->view('templates/footer', $data);
    }

    public function insertAnexoAFetch()
    {
        try {
            //comprobar los permisos para dejar pasar al módulo
            if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
                $data['resp_case'] = 'error_session';
                $data['error_message'] = 'La sesión caducó. Vuelva a iniciar sesión.';
            } else if (isset($_POST['Id_Puesta'])) {

                //set rules
                $k = 0;
                //numero y fecha/hora detención
                $valid[$k++] = $data['error_num_detencion'] = $this->FV->validate($_POST, 'Num_Detencion', 'max_length[45]');
                $valid[$k++] = $data['error_fecha'] = $this->FV->validate($_POST, 'Fecha', 'required | date');
                $valid[$k++] = $data['error_hora'] = $this->FV->validate($_POST, 'Hora', 'required | time');

                //datos generales del detenido
                $valid[$k++] = $data['error_nombre_d'] = $this->FV->validate($_POST, 'Nombre_D', 'required | max_length[250]');
                $valid[$k++] = $data['error_ap_pat_d'] = $this->FV->validate($_POST, 'Ap_Paterno_D', 'required | max_length[250]');
                $valid[$k++] = $data['error_ap_mat_d'] = $this->FV->validate($_POST, 'Ap_Materno_D', 'required | max_length[250]');
                $valid[$k++] = $data['error_apodo'] = $this->FV->validate($_POST, 'Apodo', 'max_length[100]');
                $valid[$k++] = $data['error_nacionalidad_radio'] = $this->FV->validate($_POST, 'Nacionalidad_Radio', 'required');
                //nacionalidad
                if ($_POST['Nacionalidad_Radio'] != 'MEXICANA') {
                    $valid[$k++] = $data['error_nacionalidad_otro'] = $this->FV->validate($_POST, 'Nacionalidad_Otro', 'required | max_length[45]');
                }

                $valid[$k++] = $data['error_genero'] = $this->FV->validate($_POST, 'Genero', 'required | max_length[45]');
                $valid[$k++] = $data['error_fecha_nacimiento'] = $this->FV->validate($_POST, 'Fecha_Nacimiento', 'required | max_length[45]');
                $valid[$k++] = $data['error_edad'] = $this->FV->validate($_POST, 'Edad', 'required | max_length[2]');
                $valid[$k++] = $data['error_identificacion_select'] = $this->FV->validate($_POST, 'Identificacion', 'required | max_length[45]');
                if ($_POST['Identificacion'] == 'Otro') {
                    $valid[$k++] = $data['error_identificacion_otro'] = $this->FV->validate($_POST, 'Identificacion_Otro', 'required | max_length[45]');
                }

                $valid[$k++] = $data['error_num_identificacion'] = $this->FV->validate($_POST, 'Num_Identificacion', 'max_length[45]');

                //domicilio del detenido
                $valid[$k++] = $data['error_colonia_domDetenido'] = $this->FV->validate($_POST, 'Colonia_Dom_Detenido', 'max_length[500]');
                $valid[$k++] = $data['error_calle_1_domDetenido'] = $this->FV->validate($_POST, 'Calle_1_Dom_Detenido', 'max_length[100]');
                $valid[$k++] = $data['error_no_ext_domDetenido'] = $this->FV->validate($_POST, 'No_Ext_Dom_Detenido', 'max_length[100]');
                $valid[$k++] = $data['error_no_int_domDetenido'] = $this->FV->validate($_POST, 'No_Int_Dom_Detenido', 'max_length[100]');
                $valid[$k++] = $data['error_coord_x_domDetenido'] = $this->FV->validate($_POST, 'Coordenada_X_Dom_Detenido', 'max_length[45]');
                $valid[$k++] = $data['error_coord_y_domDetenido'] = $this->FV->validate($_POST, 'Coordenada_Y_Dom_Detenido', 'max_length[45]');
                $valid[$k++] = $data['error_estado_domDetenido'] = $this->FV->validate($_POST, 'Estado_Dom_Detenido', 'max_length[850]');
                $valid[$k++] = $data['error_municipio_domDetenido'] = $this->FV->validate($_POST, 'Municipio_Dom_Detenido', 'max_length[850]');
                $valid[$k++] = $data['error_cp_domDetenido'] = $this->FV->validate($_POST, 'CP_Dom_Detenido', 'max_length[45]');
                $valid[$k++] = $data['error_referencias_domDetenido'] = $this->FV->validate($_POST, 'Referencias_Dom', 'max_length[850]');

                // información adicional del detenido
                $valid[$k++] = $data['error_descripcion_detenido'] = $this->FV->validate($_POST, 'Descripcion_Detenido', 'required | max_length[10000]');
                $valid[$k++] = $data['error_lesiones_radio'] = $this->FV->validate($_POST, 'Lesiones', 'required');
                $valid[$k++] = $data['error_padecimiento_radio'] = $this->FV->validate($_POST, 'Padecimiento_Radio', 'required');
                if ($_POST['Padecimiento_Radio'] != 'No') {
                    $valid[$k++] = $data['error_padecimiento'] = $this->FV->validate($_POST, 'Descripcion_Padecimiento', 'required | max_length[250]');
                }
                $valid[$k++] = $data['error_grupo_v_radio'] = $this->FV->validate($_POST, 'Grupo_V_Radio', 'required');
                if ($_POST['Grupo_V_Radio'] != 'No') {
                    $valid[$k++] = $data['error_grupo_v'] = $this->FV->validate($_POST, 'Grupo_Vulnerable', 'required | max_length[250]');
                }
                $valid[$k++] = $data['error_grupo_d_radio'] = $this->FV->validate($_POST, 'Grupo_D_Radio', 'required');
                if ($_POST['Grupo_D_Radio'] != 'No') {
                    $valid[$k++] = $data['error_grupo_d'] = $this->FV->validate($_POST, 'Grupo_Delictivo', 'required | max_length[250]');
                }

                // familiar del detenido
                $valid[$k++] = $data['error_familiar_radio'] = $this->FV->validate($_POST, 'Familiar_Radio', 'required');
                if ($_POST['Familiar_Radio'] != 'No') {
                    $valid[$k++] = $data['error_nombre_f'] = $this->FV->validate($_POST, 'Nombre_F', 'required | max_length[250]');
                    $valid[$k++] = $data['error_ap_pat_f'] = $this->FV->validate($_POST, 'Ap_Paterno_F', 'max_length[250]');
                    $valid[$k++] = $data['error_ap_mat_f'] = $this->FV->validate($_POST, 'Ap_Materno_F', 'max_length[250]');
                    $valid[$k++] = $data['error_telefono_f'] = $this->FV->validate($_POST, 'Telefono_F', 'max_length[10]');
                }

                // derechos del detenido
                $valid[$k++] = $data['error_derechos_radio'] = $this->FV->validate($_POST, 'Lectura_Derechos', 'required');

                //inspección del detenido
                $valid[$k++] = $data['error_obj_encontrado_radio'] = $this->FV->validate($_POST, 'Objeto_Encontrado', 'required');
                $valid[$k++] = $data['error_pert_encontrado_radio'] = $this->FV->validate($_POST, 'Pertenencias_Encontradas', 'required');


                // lugar de la detención
                if ($_POST['Ubicacion_Det_Radio'] != 'Sí') {
                    $valid[$k++] = $data['error_colonia_ubi_detencion'] = $this->FV->validate($_POST, 'Colonia_Ubi_Det', 'max_length[450]');
                    $valid[$k++] = $data['error_calle_1_ubi_detencion'] = $this->FV->validate($_POST, 'Calle_1_Ubi_Det', 'max_length[450]');
                    $valid[$k++] = $data['error_calle_2_ubi_detencion'] = $this->FV->validate($_POST, 'Calle_1_Ubi_Det', 'max_length[450]');
                    $valid[$k++] = $data['error_no_ext_ubi_detencion'] = $this->FV->validate($_POST, 'No_Ext_Ubi_Det', 'max_length[45]');
                    $valid[$k++] = $data['error_no_int_ubi_detencion'] = $this->FV->validate($_POST, 'No_Int_Ubi_Det', 'max_length[45]');
                    $valid[$k++] = $data['error_coord_x_ubi_detencion'] = $this->FV->validate($_POST, 'Coordenada_X_Ubi_Det', 'max_length[45]');
                    $valid[$k++] = $data['error_coord_y_ubi_detencion'] = $this->FV->validate($_POST, 'Coordenada_Y_Ubi_Det', 'max_length[45]');
                    $valid[$k++] = $data['error_estado_ubi_detencion'] = $this->FV->validate($_POST, 'Estado_Ubi_Det', 'max_length[600]');
                    $valid[$k++] = $data['error_municipio_ubi_detencion'] = $this->FV->validate($_POST, 'Municipio_Ubi_Det', 'max_length[600]');
                    $valid[$k++] = $data['error_cp_ubi_detencion'] = $this->FV->validate($_POST, 'CP_Ubi_Det', 'max_length[45]');
                    $valid[$k++] = $data['error_referencias_ubi_detencion'] = $this->FV->validate($_POST,'Referencias_Ubi_Det', 'max_length[800]');
                }

                //lugar traslado detenido
                $valid[$k++] = $data['error_lugar_traslado'] = $this->FV->validate($_POST, 'Lugar_Traslado', 'required | max_length[450]');
                $valid[$k++] = $data['error_desc_traslado'] = $this->FV->validate($_POST, 'Descripcion_Traslado', 'required | max_length[450]');
                $valid[$k++] = $data['error_obs_detencion'] = $this->FV->validate($_POST, 'Observaciones_Detencion', 'max_length[10000]');

                // primer respondiente
                $valid[$k++] = $data['error_primer_respondiente_radio'] = $this->FV->validate($_POST, 'Primer_Respondiente_Radio', 'required');
                if ($_POST['Primer_Respondiente_Radio'] != 'No') {
                    $valid[$k++] = $data['error_nombre_pr'] = $this->FV->validate($_POST, 'Nombre_PR', 'required | max_length[250]');
                    $valid[$k++] = $data['error_ap_pat_pr'] = $this->FV->validate($_POST, 'Ap_Paterno_PR', 'required | max_length[250]');
                    $valid[$k++] = $data['error_ap_mat_pr'] = $this->FV->validate($_POST, 'Ap_Materno_PR', 'required | max_length[250]');
                    $valid[$k++] = $data['error_institucion_pr'] = $this->FV->validate($_POST, 'Institucion_PR', 'required | max_length[250]');
                    $valid[$k++] = $data['error_cargo_pr'] = $this->FV->validate($_POST, 'Cargo_PR', 'required | max_length[250]');
                    $valid[$k++] = $this->FV->validate($_POST, 'No_Control_PR', 'max_length[45]');
                    // segundo respondiente
                    $valid[$k++] = $data['error_nombre_sr'] = $this->FV->validate($_POST, 'Nombre_SR', 'max_length[250]');
                    $valid[$k++] = $data['error_ap_pat_sr'] = $this->FV->validate($_POST, 'Ap_Paterno_SR', 'max_length[250]');
                    $valid[$k++] = $data['error_ap_mat_sr'] = $this->FV->validate($_POST, 'Ap_Materno_SR', 'max_length[250]');
                    $valid[$k++] = $data['error_institucion_sr'] = $this->FV->validate($_POST, 'Institucion_SR', 'max_length[250]');
                    $valid[$k++] = $data['error_cargo_sr'] = $this->FV->validate($_POST, 'Cargo_SR', 'max_length[250]');
                    $valid[$k++] = $this->FV->validate($_POST, 'No_Control_SR', 'max_length[45]');
                }

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) { //se trata de actualizar el dictamen con toda la info mandada
                    $success2 = $this->JuridicoM->insertAnexoA($_POST);
                    if ($success2['success']) {
                        // //info elemento para Remision
                        // $respondiente['nombreElemento']             = $success2['primer_resp']->Nombre_PR;
                        // $respondiente['primerApellidoElemento']     = $success2['primer_resp']->Ap_Paterno_PR;
                        // $respondiente['segundoApellidoElemento']    = $success2['primer_resp']->Ap_Materno_PR;
                        // $respondiente['placaElemento']              = '';
                        // $respondiente['unidadElemento']             = $success2['primer_resp']->Unidad_Arribo;
                        // $respondiente['adscripcionElemento']        = $success2['primer_resp']->Institucion;
                        // $respondiente['cargoElemento']              = $success2['primer_resp']->Cargo;

                        // $respondiente['numControl']                 = $success2['primer_resp']->No_Control;
                        // $respondiente['fullNombreElemento']         = $success2['primer_resp']->Nombre_PR . ' ' . $success2['primer_resp']->Ap_Paterno_PR . ' ' . $success2['primer_resp']->Ap_Materno_PR;

                        // $_POST['id_iph'] = 'IPH_' . $success2['id_detenido'];
                        // $_POST['Genero'] = ($_POST['Genero'] == 'H') ? 'HOMBRE' : 'MUJER';
                        // $no_ficha = $this->JuridicoM->getFichaForRemisionByIdPuesta($_POST['Id_Puesta']);
                        // $_POST['No_Ficha'] = $no_ficha;

                        // (!$no_ficha) ? $_POST['ficha'] = 'No' : $_POST['ficha'] = 'Si';

                        // $createRemision = $this->createRemision($_POST, $respondiente);
                        // if ($createRemision['status']) {

                        //     $_POST['Domicilio'] =   $_POST['Calle_1_Dom_Detenido'].' '.
                        //                             $_POST['No_Ext_Dom_Detenido'].' '.
                        //                             $_POST['No_Int_Dom_Detenido'].' '.
                        //                             $_POST['Colonia_Dom_Detenido'].' '.
                        //                             $_POST['Estado_Dom_Detenido'].' '.
                        //                             $_POST['Municipio_Dom_Detenido'];

                            
                        //     $createDictamen = $this->createDictamen($_POST, $respondiente);

                        //     if ($createDictamen['status']) {
                        //         $data['resp_case'] = 'success';
                        //         $data['success'] = true;
                        //     } else { //falló dictamen
                        //         $data['resp_case'] = 'error_db';
                        //         $data['error_message'] = 'Falló al insertar en Dictamen Médico';
                        //     }
                        // } else { //falló remisión
                        //     $data['resp_case'] = 'error_db';
                        //     $data['error_message'] = 'Falló al insertar en Remisión';
                        // }
                        $data['resp_case'] = 'success';
                                $data['success'] = true;
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $descripcion = 'Creo AnexoA, Puesta: ' . $_POST['Id_Puesta'];
                        $this->Remision->historial($user, $ip, 16, $descripcion);
                    } else {
                        $data['resp_case'] = 'error_db';
                        $data['error_message'] = 'Parece que ocurrió un problema en la base de datos. Mensaje: ' . $success2['error_message'];
                    }
                } else { //error en el formulario
                    $data['resp_case'] = 'error_form';
                    $data['error_message'] = 'Error en el formulario, compruebe que toda la información este llenada correctamente y que ningun campo requerido haga falta.';
                }
            } else { // error en la petición
                $data['resp_case'] = 'error_post';
                $data['error_message'] = 'Error en la petición de la función (mal formada)';
            }
        } catch (Exception $err) {
            $data['resp_case'] = 'error_interno';
            $data['error_message'] = 'Error interno: ' . $err;
        }

        //se retorna la respuesta final
        echo json_encode($data);
    }
    public function updateAnexoAFetch()
    {
        try {
            //comprobar los permisos para dejar pasar al módulo
            if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[1] != '1')) {
                $data['resp_case'] = 'error_session';
                $data['error_message'] = 'La sesión caducó. Vuelva a iniciar sesión.';
            } else if (isset($_POST['Id_Puesta'])) {

                //set rules
                $k = 0;
                //numero y fecha/hora detención
                $valid[$k++] = $data['error_num_detencion'] = $this->FV->validate($_POST, 'Num_Detencion', 'max_length[45]');
                $valid[$k++] = $data['error_fecha'] = $this->FV->validate($_POST, 'Fecha', 'required | date');
                $valid[$k++] = $data['error_hora'] = $this->FV->validate($_POST, 'Hora', 'required | time');

                //datos generales del detenido
                $valid[$k++] = $data['error_nombre_d'] = $this->FV->validate($_POST, 'Nombre_D', 'required | max_length[250]');
                $valid[$k++] = $data['error_ap_pat_d'] = $this->FV->validate($_POST, 'Ap_Paterno_D', 'required | max_length[250]');
                $valid[$k++] = $data['error_ap_mat_d'] = $this->FV->validate($_POST, 'Ap_Materno_D', 'required | max_length[250]');
                $valid[$k++] = $data['error_apodo'] = $this->FV->validate($_POST, 'Apodo', 'max_length[100]');
                $valid[$k++] = $data['error_nacionalidad_radio'] = $this->FV->validate($_POST, 'Nacionalidad_Radio', 'required');
                //nacionalidad
                if ($_POST['Nacionalidad_Radio'] != 'MEXICANA') {
                    $valid[$k++] = $data['error_nacionalidad_otro'] = $this->FV->validate($_POST, 'Nacionalidad_Otro', 'required | max_length[45]');
                }

                $valid[$k++] = $data['error_genero'] = $this->FV->validate($_POST, 'Genero', 'required | max_length[45]');
                $valid[$k++] = $data['error_fecha_nacimiento'] = $this->FV->validate($_POST, 'Fecha_Nacimiento', 'required | max_length[45]');
                $valid[$k++] = $data['error_edad'] = $this->FV->validate($_POST, 'Edad', 'required | max_length[2]');
                $valid[$k++] = $data['error_identificacion_select'] = $this->FV->validate($_POST, 'Identificacion', 'required | max_length[45]');
                if ($_POST['Identificacion'] == 'Otro') {
                    $valid[$k++] = $data['error_identificacion_otro'] = $this->FV->validate($_POST, 'Identificacion_Otro', 'required | max_length[45]');
                }

                $valid[$k++] = $data['error_num_identificacion'] = $this->FV->validate($_POST, 'Num_Identificacion', 'max_length[45]');

                //domicilio del detenido
                $valid[$k++] = $data['error_colonia_domDetenido'] = $this->FV->validate($_POST, 'Colonia_Dom_Detenido', 'max_length[500]');
                $valid[$k++] = $data['error_calle_1_domDetenido'] = $this->FV->validate($_POST, 'Calle_1_Dom_Detenido', 'max_length[100]');
                $valid[$k++] = $data['error_no_ext_domDetenido'] = $this->FV->validate($_POST, 'No_Ext_Dom_Detenido', 'max_length[100]');
                $valid[$k++] = $data['error_no_int_domDetenido'] = $this->FV->validate($_POST, 'No_Int_Dom_Detenido', 'max_length[100]');
                $valid[$k++] = $data['error_coord_x_domDetenido'] = $this->FV->validate($_POST, 'Coordenada_X_Dom_Detenido', 'max_length[45]');
                $valid[$k++] = $data['error_coord_y_domDetenido'] = $this->FV->validate($_POST, 'Coordenada_Y_Dom_Detenido', 'max_length[45]');
                $valid[$k++] = $data['error_estado_domDetenido'] = $this->FV->validate($_POST, 'Estado_Dom_Detenido', 'max_length[850]');
                $valid[$k++] = $data['error_municipio_domDetenido'] = $this->FV->validate($_POST, 'Municipio_Dom_Detenido', 'max_length[850]');
                $valid[$k++] = $data['error_cp_domDetenido'] = $this->FV->validate($_POST, 'CP_Dom_Detenido', 'max_length[45]');
                $valid[$k++] = $data['error_referencias_domDetenido'] = $this->FV->validate($_POST, 'Referencias_Dom', 'max_length[850]');

                // información adicional del detenido
                $valid[$k++] = $data['error_descripcion_detenido'] = $this->FV->validate($_POST, 'Descripcion_Detenido', 'required | max_length[10000]');
                $valid[$k++] = $data['error_lesiones_radio'] = $this->FV->validate($_POST, 'Lesiones', 'required');
                $valid[$k++] = $data['error_padecimiento_radio'] = $this->FV->validate($_POST, 'Padecimiento_Radio', 'required');
                if ($_POST['Padecimiento_Radio'] != 'No') {
                    $valid[$k++] = $data['error_padecimiento'] = $this->FV->validate($_POST, 'Descripcion_Padecimiento', 'required | max_length[250]');
                }
                $valid[$k++] = $data['error_grupo_v_radio'] = $this->FV->validate($_POST, 'Grupo_V_Radio', 'required');
                if ($_POST['Grupo_V_Radio'] != 'No') {
                    $valid[$k++] = $data['error_grupo_v'] = $this->FV->validate($_POST, 'Grupo_Vulnerable', 'required | max_length[250]');
                }
                $valid[$k++] = $data['error_grupo_d_radio'] = $this->FV->validate($_POST, 'Grupo_D_Radio', 'required');
                if ($_POST['Grupo_D_Radio'] != 'No') {
                    $valid[$k++] = $data['error_grupo_d'] = $this->FV->validate($_POST, 'Grupo_Delictivo', 'required | max_length[250]');
                }

                // familiar del detenido
                $valid[$k++] = $data['error_familiar_radio'] = $this->FV->validate($_POST, 'Familiar_Radio', 'required');
                if ($_POST['Familiar_Radio'] != 'No') {
                    $valid[$k++] = $data['error_nombre_f'] = $this->FV->validate($_POST, 'Nombre_F', 'required | max_length[250]');
                    $valid[$k++] = $data['error_ap_pat_f'] = $this->FV->validate($_POST, 'Ap_Paterno_F', 'max_length[250]');
                    $valid[$k++] = $data['error_ap_mat_f'] = $this->FV->validate($_POST, 'Ap_Materno_F', 'max_length[250]');
                    $valid[$k++] = $data['error_telefono_f'] = $this->FV->validate($_POST, 'Telefono_F', 'max_length[10]');
                }

                // derechos del detenido
                $valid[$k++] = $data['error_derechos_radio'] = $this->FV->validate($_POST, 'Lectura_Derechos', 'required');

                //inspección del detenido
                $valid[$k++] = $data['error_obj_encontrado_radio'] = $this->FV->validate($_POST, 'Objeto_Encontrado', 'required');
                $valid[$k++] = $data['error_pert_encontrado_radio'] = $this->FV->validate($_POST, 'Pertenencias_Encontradas', 'required');


                // lugar de la detención
                if ($_POST['Ubicacion_Det_Radio'] != 'Sí') {
                    $valid[$k++] = $data['error_colonia_ubi_detencion'] = $this->FV->validate($_POST, 'Colonia_Ubi_Det', 'max_length[450]');
                    $valid[$k++] = $data['error_calle_1_ubi_detencion'] = $this->FV->validate($_POST, 'Calle_1_Ubi_Det', 'max_length[450]');
                    $valid[$k++] = $data['error_calle_2_ubi_detencion'] = $this->FV->validate($_POST, 'Calle_1_Ubi_Det', 'max_length[450]');
                    $valid[$k++] = $data['error_no_ext_ubi_detencion'] = $this->FV->validate($_POST, 'No_Ext_Ubi_Det', 'max_length[45]');
                    $valid[$k++] = $data['error_no_int_ubi_detencion'] = $this->FV->validate($_POST, 'No_Int_Ubi_Det', 'max_length[45]');
                    $valid[$k++] = $data['error_coord_x_ubi_detencion'] = $this->FV->validate($_POST, 'Coordenada_X_Ubi_Det', 'max_length[45]');
                    $valid[$k++] = $data['error_coord_y_ubi_detencion'] = $this->FV->validate($_POST, 'Coordenada_Y_Ubi_Det', 'max_length[45]');
                    $valid[$k++] = $data['error_estado_ubi_detencion'] = $this->FV->validate($_POST, 'Estado_Ubi_Det', 'max_length[600]');
                    $valid[$k++] = $data['error_municipio_ubi_detencion'] = $this->FV->validate($_POST, 'Municipio_Ubi_Det', 'max_length[600]');
                    $valid[$k++] = $data['error_cp_ubi_detencion'] = $this->FV->validate($_POST, 'CP_Ubi_Det', 'max_length[45]');
                    $valid[$k++] = $data['error_referencias_ubi_detencion'] = $this->FV->validate($_POST,'Referencias_Ubi_Det', 'max_length[800]');
                }

                //lugar traslado detenido
                $valid[$k++] = $data['error_lugar_traslado'] = $this->FV->validate($_POST, 'Lugar_Traslado', 'required | max_length[450]');
                $valid[$k++] = $data['error_desc_traslado'] = $this->FV->validate($_POST, 'Descripcion_Traslado', 'required | max_length[450]');
                $valid[$k++] = $data['error_obs_detencion'] = $this->FV->validate($_POST, 'Observaciones_Detencion', 'max_length[10000]');

                // primer respondiente
                $valid[$k++] = $data['error_primer_respondiente_radio'] = $this->FV->validate($_POST, 'Primer_Respondiente_Radio', 'required');
                if ($_POST['Primer_Respondiente_Radio'] != 'No') {
                    $valid[$k++] = $data['error_nombre_pr'] = $this->FV->validate($_POST, 'Nombre_PR', 'required | max_length[250]');
                    $valid[$k++] = $data['error_ap_pat_pr'] = $this->FV->validate($_POST, 'Ap_Paterno_PR', 'required | max_length[250]');
                    $valid[$k++] = $data['error_ap_mat_pr'] = $this->FV->validate($_POST, 'Ap_Materno_PR', 'required | max_length[250]');
                    $valid[$k++] = $data['error_institucion'] = $this->FV->validate($_POST, 'Institucion_PR', 'required | max_length[250]');
                    $valid[$k++] = $data['error_cargo'] = $this->FV->validate($_POST, 'Cargo_PR', 'required | max_length[250]');
                    $valid[$k++] = $this->FV->validate($_POST, 'No_Control_PR', 'max_length[45]');
                    // segundo respondiente
                    $valid[$k++] = $data['error_nombre_sr'] = $this->FV->validate($_POST, 'Nombre_SR', 'max_length[250]');
                    $valid[$k++] = $data['error_ap_pat_sr'] = $this->FV->validate($_POST, 'Ap_Paterno_SR', 'max_length[250]');
                    $valid[$k++] = $data['error_ap_mat_sr'] = $this->FV->validate($_POST, 'Ap_Materno_SR', 'max_length[250]');
                    $valid[$k++] = $data['error_institucion_sr'] = $this->FV->validate($_POST, 'Institucion_SR', 'max_length[250]');
                    $valid[$k++] = $data['error_cargo_sr'] = $this->FV->validate($_POST, 'Cargo_SR', 'max_length[250]');
                    $valid[$k++] = $this->FV->validate($_POST, 'No_Control_SR', 'max_length[45]');
                }

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) { //se trata de actualizar el dictamen con toda la info mandada
                    $success2 = $this->JuridicoM->updateAnexoA($_POST);
                    if ($success2['success']) {
                        // $domicilioAux = $_POST['Calle_1_Dom_Detenido'].' '.
                        //                 $_POST['No_Ext_Dom_Detenido'].' '.
                        //                 $_POST['No_Int_Dom_Detenido'].' '.
                        //                 $_POST['Colonia_Dom_Detenido'].' '.
                        //                 $_POST['Estado_Dom_Detenido'].' '.
                        //                 $_POST['Municipio_Dom_Detenido'];
                        // $update = $this->JuridicoM->updateNombreRemDic($_POST['Nombre_D'], $_POST['Ap_Paterno_D'], $_POST['Ap_Materno_D'], $_POST['Genero'], $_POST['Edad'], $_POST['Id_Detenido'],$domicilioAux);
                        // if($update['success']){
                        //     $data['resp_case'] = 'success';
                        //     $data['success'] = true;
                        // }else{
                        //     $data['resp_case'] = 'error_db';
                        //     $data['error_message'] = 'Parece que ocurrió un problema en la base de datos. Mensaje: ' . $update['error_message'];
                        // }
                        $data['resp_case'] = 'success';
                            $data['success'] = true;
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $descripcion = 'Editar AnexoA, Puesta: ' . $_POST['Id_Puesta'];
                        $this->Remision->historial($user, $ip, 17, $descripcion);
                    } else {
                        $data['resp_case'] = 'error_db';
                        $data['error_message'] = 'Parece que ocurrió un problema en la base de datos. Mensaje: ' . $success2['error_message'];
                    }
                } else { //error en el formulario
                    $data['resp_case'] = 'error_form';
                    $data['error_message'] = 'Error en el formulario, compruebe que toda la información este llenada correctamente y que ningun campo requerido haga falta.';
                }
            } else { // error en la petición
                $data['resp_case'] = 'error_post';
                $data['error_message'] = 'Error en la petición de la función (mal formada)';
            }
        } catch (Exception $err) {
            $data['resp_case'] = 'error_interno';
            $data['error_message'] = 'Error interno: ' . $err;
        }

        //se retorna la respuesta final
        echo json_encode($data);
    }

    public function getInfoAnexoAFetch()
    {
        try {
            if (isset($_POST['Id_Puesta']) && isset($_POST['Id_Detenido'])) {
                $info = $this->JuridicoM->getInfoAnexoA($_POST['Id_Puesta'], $_POST['Id_Detenido']);
                if ($info['success']) { //se retornan toda la info del detenido
                    $data['resp_case'] = 'success';
                    $data['apartados'] = $info['apartados'];
                } else { //error en la info del detenido
                    $data['resp_case'] = 'error_db';
                    $data['error_message'] = 'Error interno: ' . $info['error_message'];
                }
            }
        } catch (Exception $err) {
            $data['resp_case'] = 'error_interno';
            $data['error_message'] = 'Error interno: ' . $err;
        }

        //se retorna la respuesta final
        echo json_encode($data);
    }

/* ------------------------------FIN FUNCIONES ANEXO A------------------------------ */



/* ------------------------------FUNCIONES ANEXO B------------------------------ */
    public function AnexoB()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $data = [
            'titulo'    => 'Planeación | Anexo B',
            'extra_css' => '<link rel="stylesheet" href="' . base_url . 'public/css/system/juridico/anexos/B/nuevo.css">',
            'extra_js'  =>  '<script src="' . base_url . 'public/js/system/juridico/anexos/B/camposForm.js"></script>' .
                '<script src="' . base_url . 'public/js/system/juridico/anexos/B/validacionesForm.js"></script>' .
                '<script src="' . base_url . 'public/js/system/juridico/anexos/B/elementos.js"></script>'
        ];

        //checar si se envia id de la puesta (requerido)
        if (isset($_GET['id_puesta']) && is_numeric($_GET['id_puesta'])) { //id puesta
            $data['id_puesta'] = $_GET['id_puesta'];
            if (!$this->JuridicoM->existeRegistroTabla('iph_puesta_disposicion', ['Id_Puesta'], [$data['id_puesta']])) { //si no existe la puesta con ese id entonces se sale de ese proceso por posible manipulación desde la url
                header("Location: " . base_url . "Juridico");
                exit();
            } else { //la puesta existe, entonces se comprueba el id del informe de uso fuerza si es que existe
                if (isset($_GET['id_informe']) && is_numeric($_GET['id_informe'])) { //numero de detenido
                    $data['id_informe'] = $_GET['id_informe'];
                    if (!$this->JuridicoM->existeRegistroTabla('iph_informe_uso_fuerza', ['Id_Informe_Uso_Fuerza'], [$data['id_informe']])) { //si no existe el detenido entonces se sale de ese proceso por posible manipulación desde la url
                        header("Location: " . base_url . "Juridico");
                        exit();
                    } else { //existe puesta y detenido entonces se trata de Editar/Ver se carga javascript para cargar la info previa
                        $data['extra_js'] .= '<script src="' . base_url . 'public/js/system/juridico/anexos/B/getInfo.js"></script>';
                    }
                } else {
                    $data['id_informe'] = -1;
                } //la puesta si existe pero no hay detenido entonces es nuevo detenido Insert
            }
        } else { //la url esta mal desde el inicio por posible manipulación, no hay necesidad de feedback
            header("Location: " . base_url . "Juridico");
            exit();
        }

        $user = $_SESSION['userdata']->Id_Usuario;
        $ip = $this->obtenerIp();
        $descripcion = 'Ver AnexoB, Puesta: ' . $_GET['id_puesta'];
        $this->Remision->historial($user, $ip, 18, $descripcion);

        $this->view('templates/header', $data);
        $this->view('system/Juridico/anexos/B/anexoBView', $data);
        $this->view('templates/footer', $data);
    }
    public function insertUpdateAnexoBFetch()
    {
        // $data = ($_POST['Tipo_Form'])?'Update':'Insert prro';
        // echo json_encode($data);
        try {
            //comprobar los permisos para dejar pasar al módulo
            if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
                $data['resp_case'] = 'error_session';
                $data['error_message'] = 'La sesión caducó. Vuelva a iniciar sesión.';
            } else if (isset($_POST['Id_Puesta'])) {

                //set rules
                $k = 0;
                //numero y fecha/hora detención
                $valid[$k++] = $data['error_num_lesionados_autoridad']   = $this->FV->validate($_POST, 'Num_Lesionados_Autoridad', 'required | max_length[25]');
                $valid[$k++] = $data['error_num_lesionados_persona']     = $this->FV->validate($_POST, 'Num_Lesionados_Persona', 'required | max_length[25]');
                $valid[$k++] = $data['error_num_fallecidos_autoridad']   = $this->FV->validate($_POST, 'Num_Fallecidos_Autoridad', 'required | max_length[25]');
                $valid[$k++] = $data['error_num_fallecidos_persona']     = $this->FV->validate($_POST, 'Num_Fallecidos_Persona', 'required | max_length[25]');

                $valid[$k++] = $data['error_descripcion_conducta']       = $this->FV->validate($_POST, 'Descripcion_Conducta', 'required | max_length[2500]');
                $valid[$k++] = $data['error_asistencia_med_radio']       = $this->FV->validate($_POST, 'Asistencia_Med_Radio', 'required | length[1]');

                if ($_POST['Asistencia_Med_Radio'] == '1') {
                    $valid[$k++] = $data['error_asistencia_medica']      = $this->FV->validate($_POST, 'Asistencia_Medica', 'required | max_length[2500]');
                }

                // primer respondiente
                $valid[$k++] = $data['error_primer_respondiente_radio']  = $this->FV->validate($_POST, 'Primer_Respondiente_Radio', 'required | length[1]');
                if ($_POST['Primer_Respondiente_Radio'] == '1') {
                    $valid[$k++] = $data['error_nombre_pr']              = $this->FV->validate($_POST, 'Nombre_PR', 'required | max_length[250]');
                    $valid[$k++] = $data['error_ap_pat_pr']              = $this->FV->validate($_POST, 'Ap_Paterno_PR', 'required | max_length[250]');
                    $valid[$k++] = $data['error_ap_mat_pr']              = $this->FV->validate($_POST, 'Ap_Materno_PR', 'required | max_length[250]');
                    $valid[$k++] = $data['error_institucion_pr']         = $this->FV->validate($_POST, 'Institucion_PR', 'required | max_length[250]');
                    $valid[$k++] = $data['error_cargo_pr']               = $this->FV->validate($_POST, 'Cargo_PR', 'required | max_length[250]');
                    $valid[$k++] = $this->FV->validate($_POST, 'No_Control_PR', 'max_length[45]');
                    // segundo respondiente
                    $valid[$k++] = $data['error_nombre_sr']              = $this->FV->validate($_POST, 'Nombre_SR', 'max_length[250]');
                    $valid[$k++] = $data['error_ap_pat_sr']              = $this->FV->validate($_POST, 'Ap_Paterno_SR', 'max_length[250]');
                    $valid[$k++] = $data['error_ap_mat_sr']              = $this->FV->validate($_POST, 'Ap_Materno_SR', 'max_length[250]');
                    $valid[$k++] = $data['error_institucion_sr']         = $this->FV->validate($_POST, 'Institucion_SR', 'max_length[250]');
                    $valid[$k++] = $data['error_cargo_sr']               = $this->FV->validate($_POST, 'Cargo_SR', 'max_length[250]');
                    $valid[$k++] = $this->FV->validate($_POST, 'No_Control_SR', 'max_length[45]');
                }

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) { //se trata de actualizar el dictamen con toda la info mandada
                    //dependiendo se realiza un insert o un update
                    $success2 = ($_POST['Tipo_Form']) ? $this->JuridicoM->updateAnexoB($_POST) : $this->JuridicoM->insertAnexoB($_POST);
                    if ($success2['success']) {
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        if($_POST['Tipo_Form']){
                            $descripcion = 'Editar AnexoB, Puesta: ' . $_POST['Id_Puesta'];
                            $this->Remision->historial($user, $ip, 17, $descripcion);
                        }else{
                            $descripcion = 'Creo AnexoB, Puesta: ' . $_POST['Id_Puesta'];
                            $this->Remision->historial($user, $ip, 16, $descripcion);
                        }
                        $data['resp_case'] = 'success';
                        $data['success'] = true;
                    } else {
                        $data['resp_case'] = 'error_db';
                        $data['error_message'] = 'Parece que ocurrió un problema en la base de datos. Mensaje: ' . $success2['error_message'];
                    }
                } else { //error en el formulario
                    $data['resp_case'] = 'error_form';
                    $data['error_message'] = 'Error en el formulario, compruebe que toda la información este llenada correctamente y que ningun campo requerido haga falta.';
                }
            } else { // error en la petición
                $data['resp_case'] = 'error_post';
                $data['error_message'] = 'Error en la petición de la función (mal formada)';
            }
        } catch (Exception $err) {
            $data['resp_case'] = 'error_interno';
            $data['error_message'] = 'Error interno: ' . $err;
        }

        // se retorna la respuesta final
        echo json_encode($data);
    }
    public function getInfoAnexoBFetch()
    {
        try {
            if (isset($_POST['Id_Puesta']) && isset($_POST['Id_Informe'])) {
                $info = $this->JuridicoM->getInfoAnexoB($_POST['Id_Puesta'], $_POST['Id_Informe']);
                if ($info['success']) { //se retornan toda la info del detenido
                    $data['resp_case'] = 'success';
                    $data['apartados'] = $info['apartados'];
                } else { //error en la info del detenido
                    $data['resp_case'] = 'error_db';
                    $data['error_message'] = 'Error interno: ' . $info['error_message'];
                }
            }
        } catch (Exception $err) {
            $data['resp_case'] = 'error_interno';
            $data['error_message'] = 'Error interno: ' . $err;
        }

        //se retorna la respuesta final
        echo json_encode($data);
    }
/* ------------------------------FIN FUNCIONES ANEXO B------------------------------ */



/* ------------------------------INICIO FUNCIONES ANEXO C------------------------------ */    
    public function AnexoC($id_puesta = null, $id_elem =  null)
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }
        // echo "Puesta: " .$id_puesta;
        // echo "id_elem: " . $id_elem;
        $data = [
            'titulo'     => 'Planeación | Jurídico | Anexo C',
            'extra_css'  => '<link rel="stylesheet" href="' . base_url . 'public/css/system/juridico/anexos/C/style.css">',
            'extra_js'   => '<script src="' . base_url . 'public/js/system/juridico/generalFunctions.js"></script>' .
                '<script src="' . base_url . 'public/js/system/juridico/anexos/C/index.js"></script>' .
                '<script src="' . base_url . 'public/js/system/juridico/anexos/C/validations.js"></script>'
        ];

        if ($id_puesta != null && is_numeric($id_puesta)) {
            $data['id_puesta'] =  $id_puesta;
            if (!$this->JuridicoM->existeRegistroTabla('iph_puesta_disposicion', ['Id_Puesta'], [$id_puesta])) {
                header("Location: " . base_url . "Juridico");
                exit();
            } else {
                if (($id_elem != null && is_numeric($id_elem))) { //numero de detenido
                    $data['id_elem'] = $id_elem;
                    if (!$this->JuridicoM->existeRegistroTabla('iph_inspeccion_vehiculo', ['Id_Puesta', 'Id_Inspeccion_Vehiculo'], [$id_puesta, $id_elem])) { //si no existe el detenido entonces se sale de ese proceso por posible manipulación desde la url
                        header("Location: " . base_url . "Juridico");
                        exit();
                    } else { //existe puesta y detenido entonces se trata de Editar/Ver se carga javascript para cargar la info previa
                        $data['extra_js'] .=    '<script src="' . base_url . 'public/js/system/juridico/anexos/C/editView.js"></script>' .
                            '<script src="' . base_url . 'public/js/system/juridico/anexos/C/getAnexoC.js"></script>';
                    }
                } else {
                    $data['id_elem'] = -1;
                }
            }
        } else {
            header("Location: " . base_url . "Juridico");
            exit();
        }

        $user = $_SESSION['userdata']->Id_Usuario;
        $ip = $this->obtenerIp();
        $descripcion = 'Ver AnexoC, Puesta: ' . $id_puesta;
        $this->Remision->historial($user, $ip, 18, $descripcion);

        $this->view('templates/header', $data);
        $this->view('system/Juridico/anexos/C/anexoCView', $data);
        $this->view('templates/footer', $data);
    }

    public function insertarAnexoC()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['btn_anexoC'])) {

                $k = 0;
                $valid[$k++] = $data_p['fecha_error']           = $this->FV->validate($_POST, 'fecha', 'required | date');
                $valid[$k++] = $data_p['hora_error']            = $this->FV->validate($_POST, 'hora', 'required | time');
                $valid[$k++] = $data_p['Marca_error']           = $this->FV->validate($_POST, 'Marca', 'max_length[100]');
                $valid[$k++] = $data_p['Submarca_error']        = $this->FV->validate($_POST, 'Submarca', 'max_length[100]');
                $valid[$k++] = $data_p['Modelo_error']          = $this->FV->validate($_POST, 'Modelo', 'max_length[4]');
                $valid[$k++] = $data_p['Color_error']           = $this->FV->validate($_POST, 'Color', 'required | max_length[100]');
                $valid[$k++] = $data_p['Placa_error']           = $this->FV->validate($_POST, 'Placa', 'max_length[45]');
                $valid[$k++] = $data_p['Num_Serie_error']       = $this->FV->validate($_POST, 'Num_Serie', 'max_length[18]');
                $valid[$k++] = $data_p['Observaciones_error']   = $this->FV->validate($_POST, 'Observaciones', 'max_length[10000]');
                $valid[$k++] = $data_p['Destino_error']         = $this->FV->validate($_POST, 'Destino', 'required | max_length[10000]');

                if ($_POST['pr'] == 'No') {
                    $valid[$k++] = $data_p['Nombre_PR_error']       = $this->FV->validate($_POST, 'Nombre_PR', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Paterno_PR_error']   = $this->FV->validate($_POST, 'Ap_Paterno_PR', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Materno_PR_error']   = $this->FV->validate($_POST, 'Ap_Materno_PR', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Institucion_error']     = $this->FV->validate($_POST, 'Institucion', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Cargo_error']           = $this->FV->validate($_POST, 'Cargo', 'required | max_length[250]');

                    $valid[$k++] = $data_p['Nombre_PR_1_error']     = $this->FV->validate($_POST, 'Nombre_PR_1', 'max_length[250]');
                    $valid[$k++] = $data_p['Ap_Paterno_PR_1_error'] = $this->FV->validate($_POST, 'Ap_Paterno_PR_1', 'max_length[250]');
                    $valid[$k++] = $data_p['Ap_Materno_PR_1_error'] = $this->FV->validate($_POST, 'Ap_Materno_PR_1', 'max_length[250]');
                    $valid[$k++] = $data_p['Institucion_1_error']   = $this->FV->validate($_POST, 'Institucion_1', 'max_length[250]');
                    $valid[$k++] = $data_p['Cargo_1_error']         = $this->FV->validate($_POST, 'Cargo_1', 'max_length[250]');
                }

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) {
                    $data_p['Server_Validation_Status'] =  'success';
                    $success_2 = $this->JuridicoM->insertarAnexoC($_POST);
                    //$success_2['status'] =  true ;
                    if ($success_2['status']) {
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $descripcion = 'Creo AnexoC, Puesta: ' . $_POST['Id_Puesta'];
                        $this->Remision->historial($user, $ip, 16, $descripcion);
                        $data_p['Server_Status_Insertion'] = $success_2['status'];
                        // $this->Historial->insertHistorial(11,'Nuevo registro I.O.:'.$Id_Inteligencia);
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

    public function getInfoAnexoC()
    {
        try {
            if (isset($_POST['Id_Puesta']) && isset($_POST['Id_Inspeccion_Vehiculo'])) {
                $info = $this->JuridicoM->getInfoAnexoC($_POST['Id_Puesta'], $_POST['Id_Inspeccion_Vehiculo']);
                if ($info['success']) { //se retornan toda la info del detenido
                    $data['resp_case'] = 'success';
                    $data['apartados'] = $info['apartados'];
                } else { //error en la info del detenido
                    $data['resp_case'] = 'error_db';
                    $data['error_message'] = 'Error interno: ' . $info['error_message'];
                }
            }
        } catch (Exception $err) {
            $data['resp_case'] = 'error_interno';
            $data['error_message'] = 'Error interno: ' . $err;
        }
        echo json_encode($data);
    }

    public function actualizarAnexoC()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['btn_anexoC'])) {
                $k = 0;
                $valid[$k++] = $data_p['fecha_error']           = $this->FV->validate($_POST, 'fecha', 'required | date');
                $valid[$k++] = $data_p['hora_error']            = $this->FV->validate($_POST, 'hora', 'required | time');
                $valid[$k++] = $data_p['Marca_error']           = $this->FV->validate($_POST, 'Marca', 'required | max_length[100]');
                $valid[$k++] = $data_p['Submarca_error']        = $this->FV->validate($_POST, 'Submarca', 'max_length[100]');
                $valid[$k++] = $data_p['Modelo_error']          = $this->FV->validate($_POST, 'Modelo', 'max_length[4]');
                $valid[$k++] = $data_p['Color_error']           = $this->FV->validate($_POST, 'Color', 'required | max_length[100]');
                $valid[$k++] = $data_p['Placa_error']           = $this->FV->validate($_POST, 'Placa', 'max_length[45]');
                $valid[$k++] = $data_p['Num_Serie_error']       = $this->FV->validate($_POST, 'Num_Serie', 'max_length[18]');
                $valid[$k++] = $data_p['Observaciones_error']   = $this->FV->validate($_POST, 'Observaciones', 'max_length[10000]');
                $valid[$k++] = $data_p['Destino_error']         = $this->FV->validate($_POST, 'Destino', 'required | max_length[10000]');

                if ($_POST['pr'] == 'No') {
                    $valid[$k++] = $data_p['Nombre_PR_error']       = $this->FV->validate($_POST, 'Nombre_PR', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Paterno_PR_error']   = $this->FV->validate($_POST, 'Ap_Paterno_PR', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Materno_PR_error']   = $this->FV->validate($_POST, 'Ap_Materno_PR', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Institucion_error']     = $this->FV->validate($_POST, 'Institucion', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Cargo_error']           = $this->FV->validate($_POST, 'Cargo', 'required | max_length[250]');

                    $valid[$k++] = $data_p['Nombre_PR_1_error']     = $this->FV->validate($_POST, 'Nombre_PR_1', 'max_length[250]');
                    $valid[$k++] = $data_p['Ap_Paterno_PR_1_error'] = $this->FV->validate($_POST, 'Ap_Paterno_PR_1', 'max_length[250]');
                    $valid[$k++] = $data_p['Ap_Materno_PR_1_error'] = $this->FV->validate($_POST, 'Ap_Materno_PR_1', 'max_length[250]');
                    $valid[$k++] = $data_p['Institucion_1_error']   = $this->FV->validate($_POST, 'Institucion_1', 'max_length[250]');
                    $valid[$k++] = $data_p['Cargo_1_error']         = $this->FV->validate($_POST, 'Cargo_1', 'max_length[250]');
                }

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) {
                    $data_p['Server_Validation_Status'] =  'success';
                    $success_2 = $this->JuridicoM->actualizarAnexoC($_POST);
                    if ($success_2['status']) {
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $descripcion = 'Editar AnexoC, Puesta: ' . $_POST['Id_Puesta'];
                        $this->Remision->historial($user, $ip, 17, $descripcion);
                        $data_p['Server_Status_Insertion'] = $success_2['status'];
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
/* ------------------------------FIN FUNCIONES ANEXO C------------------------------ */


/* ------------------------------INICIO FUNCIONES ANEXO D------------------------------ */
    public function AnexoD($arg = null, $id_puesta = null, $id_elem = null)
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $data = [
            'titulo'     => 'Planeación | Jurídico | Anexo D',
            'extra_css'  => '<link rel="stylesheet" href="' . base_url . 'public/css/system/juridico/anexos/D/style.css">',
            'extra_js'   => '<script src="' . base_url . 'public/js/system/juridico/generalFunctions.js"></script>'
        ];
        $view = '';

        switch ($arg) {
            case 'arma':

                $data['extra_js'] .= '<script src="' . base_url . 'public/js/system/juridico/anexos/D/Armas/Armas.js"></script>' .
                    '<script src="' . base_url . 'public/js/system/juridico/anexos/D/Armas/validationsA.js"></script>';

                $view = 'anexoDViewArmas';

                if ($id_puesta !=  null && is_numeric($id_puesta)) {
                    $data['id_puesta'] =  $id_puesta;
                    if (!$this->JuridicoM->existeRegistroTabla('iph_puesta_disposicion', ['Id_Puesta'], [$id_puesta])) {
                        header("Location: " . base_url . "Juridico");
                        exit();
                    } else {
                        if (($id_elem != null && is_numeric($id_elem))) {
                            $data['id_elem'] = $id_elem;
                            if (!$this->JuridicoM->existeRegistroTabla('iph_inventario_arma', ['Id_Puesta', 'Id_Inventario_Arma'], [$id_puesta, $id_elem])) {
                                header("Location: " . base_url . "Juridico");
                                exit();
                            } else {
                                $data['extra_js'] .= '<script src="' . base_url . 'public/js/system/juridico/anexos/D/Armas/editView.js"></script>'.
                                                    '<script src="' . base_url . 'public/js/system/juridico/anexos/D/Armas/getAnexoDArmas.js"></script>';

                                $user = $_SESSION['userdata']->Id_Usuario;
                                $ip = $this->obtenerIp();
                                $descripcion = 'Ver AnexoD Arma, Puesta: ' . $id_puesta;
                                $this->Remision->historial($user, $ip, 18, $descripcion);
                            }
                        } else {
                            $data['id_elem'] = -1;
                        }
                    }
                } else {
                    header("Location: " . base_url . "Juridico");
                    exit();
                }
                break;


            case 'objeto':
                $data['extra_js'] .= '<script src="' . base_url . 'public/js/system/juridico/anexos/D/Objetos/Objetos.js"></script>' .
                    '<script src="' . base_url . 'public/js/system/juridico/anexos/D/Objetos/validationsO.js"></script>';
                $view = 'anexoDViewObjetos';

                if ($id_puesta !=  null && is_numeric($id_puesta)) {
                    $data['id_puesta'] =  $id_puesta;
                    if (!$this->JuridicoM->existeRegistroTabla('iph_puesta_disposicion', ['Id_Puesta'], [$id_puesta])) {
                        header("Location: " . base_url . "Juridico");
                        exit();
                    } else {
                        if (($id_elem != null && is_numeric($id_elem))) {
                            $data['id_elem'] = $id_elem;
                            if (!$this->JuridicoM->existeRegistroTabla('iph_inventario_objeto', ['Id_Puesta', 'Id_Inventario_Objetos'], [$id_puesta, $id_elem])) {
                                header("Location: " . base_url . "Juridico");
                                exit();
                            } else {
                                $data['extra_js'] .= '<script src="' . base_url . 'public/js/system/juridico/anexos/D/Objetos/editView.js"></script>'.
                                                    '<script src="' . base_url . 'public/js/system/juridico/anexos/D/Objetos/getAnexoDObjetos.js"></script>';

                                $user = $_SESSION['userdata']->Id_Usuario;
                                $ip = $this->obtenerIp();
                                $descripcion = 'Ver AnexoD Objeto, Puesta: ' . $id_puesta;
                                $this->Remision->historial($user, $ip, 18, $descripcion);
                            }
                        } else {
                            $data['id_elem'] = -1;
                        }
                    }
                } else {
                    header("Location: " . base_url . "Juridico");
                    exit();
                }

                break;
            default:
                header("Location: " . base_url . "Juridico");
                exit();
        }

        if ($id_puesta == null && $id_elem == null) {
            header("Location: " . base_url . "Juridico");
            exit();
        }

        $this->view('templates/header', $data);
        $this->view('system/Juridico/anexos/D/' . $view, $data);
        $this->view('templates/footer', $data);
    }

    public function getInfoAnexoDArmas()
    {
        try {
            if (isset($_POST['Id_Puesta']) && isset($_POST['Id_Inventario_Arma'])) {
                $info = $this->JuridicoM->getInfoAnexoDArmas($_POST['Id_Puesta'], $_POST['Id_Inventario_Arma']);
                if ($info['success']) { //se retornan toda la info del detenido
                    $data['resp_case'] = 'success';
                    $data['apartados'] = $info['apartados'];
                } else { //error en la info del detenido
                    $data['resp_case'] = 'error_db';
                    $data['error_message'] = 'Error interno: ' . $info['error_message'];
                }
            }
        } catch (Exception $err) {
            $data['resp_case'] = 'error_interno';
            $data['error_message'] = 'Error interno: ' . $err;
        }
        echo json_encode($data);
    }

    public function getInfoAnexoDObjetos()
    {
        try {
            if (isset($_POST['Id_Puesta']) && isset($_POST['Id_Inventario_Objetos'])) {
                $info = $this->JuridicoM->getInfoAnexoDObjetos($_POST['Id_Puesta'], $_POST['Id_Inventario_Objetos']);
                if ($info['success']) { //se retornan toda la info del detenido
                    $data['resp_case'] = 'success';
                    $data['apartados'] = $info['apartados'];
                } else { //error en la info del detenido
                    $data['resp_case'] = 'error_db';
                    $data['error_message'] = 'Error interno: ' . $info['error_message'];
                }
            }
        } catch (Exception $err) {
            $data['resp_case'] = 'error_interno';
            $data['error_message'] = 'Error interno: ' . $err;
        }
        echo json_encode($data);
    }

    public function insertarAnexoD()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['btn_anexoDArmas'])) { //Anexo D - Armas

                $k = 0;
                $valid[$k++] = $data_p['Ubicacion_Arma_Error']    = $this->FV->validate($_POST, 'Ubicacion_Arma', 'required | max_length[1000]');
                $valid[$k++] = $data_p['Calibre_Error']           = $this->FV->validate($_POST, 'Calibre', 'required | max_length[45]');
                $valid[$k++] = $data_p['Color_Error']             = $this->FV->validate($_POST, 'Color', 'required | max_length[45]');
                $valid[$k++] = $data_p['Matricula_Error']         = $this->FV->validate($_POST, 'Matricula', 'max_length[45]');
                $valid[$k++] = $data_p['Num_Serie_Error']         = $this->FV->validate($_POST, 'Num_Serie', 'max_length[45]');
                $valid[$k++] = $data_p['Observaciones_Error']     = $this->FV->validate($_POST, 'Observaciones', 'required | max_length[10000]');
                $valid[$k++] = $data_p['Destino_Error']           = $this->FV->validate($_POST, 'Destino', 'required | max_length[250]');
                $valid[$k++] = $data_p['Nombre_A_Error']          = $this->FV->validate($_POST, 'Nombre_A', 'max_length[100]');
                $valid[$k++] = $data_p['Ap_Paterno_A_Error']      = $this->FV->validate($_POST, 'Ap_Paterno_A', 'max_length[250]');
                $valid[$k++] = $data_p['Ap_Materno_A_Error']      = $this->FV->validate($_POST, 'Ap_Materno_A', 'max_length[250]');

                if ($_POST['testigos'] == 'Si') {
                    $valid[$k++] = $data_p['Nombre_TA_0_Error']       = $this->FV->validate($_POST, 'Nombre_TA_0', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Paterno_TA_0_Error']   = $this->FV->validate($_POST, 'Ap_Paterno_TA_0', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Materno_TA_0_Error']   = $this->FV->validate($_POST, 'Ap_Materno_TA_0', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Nombre_TA_1_Error']       = $this->FV->validate($_POST, 'Nombre_TA_1', 'max_length[250]');
                    $valid[$k++] = $data_p['Ap_Paterno_TA_1_Error']   = $this->FV->validate($_POST, 'Ap_Paterno_TA_1', 'max_length[250]');
                    $valid[$k++] = $data_p['Ap_Materno_TA_1_Error']   = $this->FV->validate($_POST, 'Ap_Materno_TA_1', 'max_length[250]');
                }

                if ($_POST['arma'] == 'No') {
                    $valid[$k++] = $data_p['Nombre_PRA_Error']        = $this->FV->validate($_POST, 'Nombre_PRA', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Paterno_PRA_Error']    = $this->FV->validate($_POST, 'Ap_Paterno_PRA', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Materno_PRA_Error']    = $this->FV->validate($_POST, 'Ap_Materno_PRA', 'required | max_length[250]');
                    $valid[$k++] = $data_p['InstitucionA_Error']      = $this->FV->validate($_POST, 'InstitucionA', 'required | max_length[250]');
                    $valid[$k++] = $data_p['CargoA_Error']            = $this->FV->validate($_POST, 'CargoA', 'required | max_length[250]');
                }

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) {
                    $data_p['Server_Validation_Status'] =  'false';
                    $success_2 = $this->JuridicoM->insertarAnexoDArmas($_POST);
                    // $success_2['status'] =  true;
                    if ($success_2['status']) {
                        $data_p['Server_Status_Insertion'] = $success_2['status'];
                        // $this->Historial->insertHistorial(11,'Nuevo registro I.O.:'.$Id_Inteligencia);
                        $data_p['status'] =  true;
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $descripcion = 'Creo AnexoD Arma, Puesta: ' . $_POST['Id_Puesta'];
                        $this->Remision->historial($user, $ip, 16, $descripcion);
                    } else {
                        $data_p['status'] =  false;
                        $data_p['error_message'] = $success_2['error_message'];
                    }
                } else {
                    $data_p['status'] = false;
                    $data_p['error_message'] = 'Validación formulario';
                }
                echo json_encode($data_p);
            } else if (isset($_POST['btn_anexoDObjetos'])) { //Anexo D - Objetos

                $k = 0;

                if ($_POST['Apariencia'] === 'Otro' && $_POST['otro'] != '')
                    $valid[$k++] = $data_p['otro_objeto_Error']   = $this->FV->validate($_POST, 'otro', 'required | max_length[450]');

                /* $valid[$k++] = $data_p['Ubicacion_Objeto_Error']    = $this->FV->validate($_POST, 'Ubicacion_Objeto', 'required | max_length[250]'); */
                $valid[$k++] = $data_p['Destino_Error']             = $this->FV->validate($_POST, 'Destino', 'required | max_length[250]');
                $valid[$k++] = $data_p['Descripcion_Objeto_Error']  = $this->FV->validate($_POST, 'Descripcion_Objeto', 'required | max_length[1000]');
                $valid[$k++] = $data_p['Nombre_A_Error']            = $this->FV->validate($_POST, 'Nombre_A', 'max_length[250]');
                $valid[$k++] = $data_p['Ap_Paterno_A_Error']        = $this->FV->validate($_POST, 'Ap_Paterno_A', 'max_length[250]');
                $valid[$k++] = $data_p['Ap_Materno_A_Error']        = $this->FV->validate($_POST, 'Ap_Materno_A', 'max_length[250]');

                if ($_POST['testigos'] == 'Si') {
                    $valid[$k++] = $data_p['Nombre_TO_0_Error']       = $this->FV->validate($_POST, 'Nombre_TO_0', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Paterno_TO_0_Error']   = $this->FV->validate($_POST, 'Ap_Paterno_TO_0', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Materno_TO_0_Error']   = $this->FV->validate($_POST, 'Ap_Materno_TO_0', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Nombre_TO_1_Error']       = $this->FV->validate($_POST, 'Nombre_TO_1', 'max_length[250]');
                    $valid[$k++] = $data_p['Ap_Paterno_TO_1_Error']   = $this->FV->validate($_POST, 'Ap_Paterno_TO_1', 'max_length[250]');
                    $valid[$k++] = $data_p['Ap_Materno_TO_1_Error']   = $this->FV->validate($_POST, 'Ap_Materno_TO_1', 'max_length[250]');
                }

                if ($_POST['respondiente'] == 'No') {
                    $valid[$k++] = $data_p['Nombre_PR_Error']        = $this->FV->validate($_POST, 'Nombre_PR', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Paterno_PR_Error']    = $this->FV->validate($_POST, 'Ap_Paterno_PR', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Materno_PR_Error']    = $this->FV->validate($_POST, 'Ap_Materno_PR', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Institucion_Error']      = $this->FV->validate($_POST, 'Institucion', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Cargo_Error']            = $this->FV->validate($_POST, 'Cargo', 'required | max_length[250]');
                }

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) {
                    //$data_p['Server_Validation_Status'] =  'false';
                    $success_2 = $this->JuridicoM->insertarAnexoDObjetos($_POST);
                    // $success_2['status'] =  true;
                    if ($success_2['status']) {
                        $data_p['Server_Status_Insertion'] = $success_2['status'];
                        // $this->Historial->insertHistorial(11,'Nuevo registro I.O.:'.$Id_Inteligencia);
                        $data_p['status'] =  true;
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $descripcion = 'Creo AnexoD Objeto, Puesta: ' . $_POST['Id_Puesta'];
                        $this->Remision->historial($user, $ip, 16, $descripcion);
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

    public function actualizarAnexoD()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['btn_anexoDArmas'])) { //Anexo D - Armas

                $k = 0;
                $valid[$k++] = $data_p['Ubicacion_Arma_Error']    = $this->FV->validate($_POST, 'Ubicacion_Arma', 'required | max_length[1000]');
                $valid[$k++] = $data_p['Calibre_Error']           = $this->FV->validate($_POST, 'Calibre', 'required | max_length[45]');
                $valid[$k++] = $data_p['Color_Error']             = $this->FV->validate($_POST, 'Color', 'required | max_length[45]');
                $valid[$k++] = $data_p['Matricula_Error']         = $this->FV->validate($_POST, 'Matricula', 'max_length[45]');
                $valid[$k++] = $data_p['Num_Serie_Error']         = $this->FV->validate($_POST, 'Num_Serie', 'max_length[45]');
                $valid[$k++] = $data_p['Observaciones_Error']     = $this->FV->validate($_POST, 'Observaciones', 'required | max_length[10000]');
                $valid[$k++] = $data_p['Destino_Error']           = $this->FV->validate($_POST, 'Destino', 'required | max_length[250]');
                $valid[$k++] = $data_p['Nombre_A_Error']          = $this->FV->validate($_POST, 'Nombre_A', 'max_length[100]');
                $valid[$k++] = $data_p['Ap_Paterno_A_Error']      = $this->FV->validate($_POST, 'Ap_Paterno_A', 'max_length[250]');
                $valid[$k++] = $data_p['Ap_Materno_A_Error']      = $this->FV->validate($_POST, 'Ap_Materno_A', 'max_length[250]');

                if ($_POST['testigos'] == 'Si') {
                    $valid[$k++] = $data_p['Nombre_TA_0_Error']       = $this->FV->validate($_POST, 'Nombre_TA_0', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Paterno_TA_0_Error']   = $this->FV->validate($_POST, 'Ap_Paterno_TA_0', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Materno_TA_0_Error']   = $this->FV->validate($_POST, 'Ap_Materno_TA_0', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Nombre_TA_1_Error']       = $this->FV->validate($_POST, 'Nombre_TA_1', 'max_length[250]');
                    $valid[$k++] = $data_p['Ap_Paterno_TA_1_Error']   = $this->FV->validate($_POST, 'Ap_Paterno_TA_1', 'max_length[250]');
                    $valid[$k++] = $data_p['Ap_Materno_TA_1_Error']   = $this->FV->validate($_POST, 'Ap_Materno_TA_1', 'max_length[250]');
                }

                if ($_POST['arma'] == 'No') {
                    $valid[$k++] = $data_p['Nombre_PRA_Error']        = $this->FV->validate($_POST, 'Nombre_PRA', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Paterno_PRA_Error']    = $this->FV->validate($_POST, 'Ap_Paterno_PRA', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Materno_PRA_Error']    = $this->FV->validate($_POST, 'Ap_Materno_PRA', 'required | max_length[250]');
                    $valid[$k++] = $data_p['InstitucionA_Error']      = $this->FV->validate($_POST, 'InstitucionA', 'required | max_length[250]');
                    $valid[$k++] = $data_p['CargoA_Error']            = $this->FV->validate($_POST, 'CargoA', 'required | max_length[250]');
                }

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) {
                    $data_p['Server_Validation_Status'] =  'false';
                    $success_2 = $this->JuridicoM->actualizarAnexoDArmas($_POST);
                    if ($success_2['status']) {
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $descripcion = 'Editar AnexoD Arma, Puesta: ' . $_POST['Id_Puesta'];
                        $this->Remision->historial($user, $ip, 17, $descripcion);
                        $data_p['Server_Status_Insertion'] = $success_2['status'];
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
            } else if (isset($_POST['btn_anexoDObjetos'])) { //Anexo D - Objetos

                $k = 0;

                /* $valid[$k++] = $data_p['Ubicacion_Objeto_Error']    = $this->FV->validate($_POST, 'Ubicacion_Objeto', 'required | max_length[250]'); */
                $valid[$k++] = $data_p['Destino_Error']             = $this->FV->validate($_POST, 'Destino', 'required | max_length[250]');
                $valid[$k++] = $data_p['Descripcion_Objeto_Error']  = $this->FV->validate($_POST, 'Descripcion_Objeto', 'required | max_length[1000]');
                $valid[$k++] = $data_p['Nombre_A_Error']            = $this->FV->validate($_POST, 'Nombre_A', 'max_length[250]');
                $valid[$k++] = $data_p['Ap_Paterno_A_Error']        = $this->FV->validate($_POST, 'Ap_Paterno_A', 'max_length[250]');
                $valid[$k++] = $data_p['Ap_Materno_A_Error']        = $this->FV->validate($_POST, 'Ap_Materno_A', 'max_length[250]');

                if ($_POST['testigos'] == 'Si') {
                    $valid[$k++] = $data_p['Nombre_TO_0_Error']       = $this->FV->validate($_POST, 'Nombre_TO_0', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Paterno_TO_0_Error']   = $this->FV->validate($_POST, 'Ap_Paterno_TO_0', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Materno_TO_0_Error']   = $this->FV->validate($_POST, 'Ap_Materno_TO_0', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Nombre_TO_1_Error']       = $this->FV->validate($_POST, 'Nombre_TO_1', 'max_length[250]');
                    $valid[$k++] = $data_p['Ap_Paterno_TO_1_Error']   = $this->FV->validate($_POST, 'Ap_Paterno_TO_1', 'max_length[250]');
                    $valid[$k++] = $data_p['Ap_Materno_TO_1_Error']   = $this->FV->validate($_POST, 'Ap_Materno_TO_1', 'max_length[250]');
                }

                if ($_POST['respondiente'] == 'No') {
                    $valid[$k++] = $data_p['Nombre_PR_Error']        = $this->FV->validate($_POST, 'Nombre_PR', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Paterno_PR_Error']    = $this->FV->validate($_POST, 'Ap_Paterno_PR', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Ap_Materno_PR_Error']    = $this->FV->validate($_POST, 'Ap_Materno_PR', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Institucion_Error']      = $this->FV->validate($_POST, 'Institucion', 'required | max_length[250]');
                    $valid[$k++] = $data_p['Cargo_Error']            = $this->FV->validate($_POST, 'Cargo', 'required | max_length[250]');
                }

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) {
                    //$data_p['Server_Validation_Status'] =  'false';
                    $success_2 = $this->JuridicoM->actualizarAnexoDObjetos($_POST);
                    // $success_2['status'] =  true;
                    if ($success_2['status']) {
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $descripcion = 'Editar AnexoD Objeto, Puesta: ' . $_POST['Id_Puesta'];
                        $this->Remision->historial($user, $ip, 17, $descripcion);
                        $data_p['Server_Status_Insertion'] = $success_2['status'];
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
/* ------------------------------FIN FUNCIONES ANEXO D------------------------------ */

/* ------------------------------FUNCIONES ANEXO E------------------------------ */
    public function AnexoE()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $data = [
            'titulo'    => 'Planeación | Anexo E',
            'extra_css' => '<link rel="stylesheet" href="' . base_url . 'public/css/system/juridico/anexos/E/nuevo.css">',
            'extra_js'  =>  '<script src="' . base_url . 'public/js/maps/juridico/anexoE.js"></script>' .
                '<script src="https://maps.googleapis.com/maps/api/js?key=' . API_KEY . '&callback=initMap&libraries=places" async defer></script>' .
                '<script src="' . base_url . 'public/js/system/juridico/anexos/E/camposForm.js"></script>' .
                '<script src="' . base_url . 'public/js/system/juridico/anexos/E/validacionesForm.js"></script>' .
                '<script src="' . base_url . 'public/js/system/juridico/anexos/E/elementos.js"></script>'
        ];

        //checar si se envia id de la puesta (requerido)
        if (isset($_GET['id_puesta']) && is_numeric($_GET['id_puesta'])) { //id puesta
            $data['id_puesta'] = $_GET['id_puesta'];
            if (!$this->JuridicoM->existeRegistroTabla('iph_puesta_disposicion', ['Id_Puesta'], [$data['id_puesta']])) { //si no existe la puesta con ese id entonces se sale de ese proceso por posible manipulación desde la url
                header("Location: " . base_url . "Juridico");
                exit();
            } else { //la puesta existe, entonces se comprueba el id de la entrevista si es que existe
                if (isset($_GET['id_entrevista']) && is_numeric($_GET['id_entrevista'])) { //id entrevista
                    $data['id_entrevista'] = $_GET['id_entrevista'];
                    if (!$this->JuridicoM->existeRegistroTabla('iph_entrevista', ['Id_Entrevista'], [$data['id_entrevista']])) { //si no existe el detenido entonces se sale de ese proceso por posible manipulación desde la url
                        header("Location: " . base_url . "Juridico");
                        exit();
                    } else { //existe puesta y detenido entonces se trata de Editar/Ver se carga javascript para cargar la info previa
                        $data['extra_js'] .= '<script src="' . base_url . 'public/js/system/juridico/anexos/E/getInfo.js"></script>';
                    }
                } else {
                    $data['id_entrevista'] = -1;
                } //la puesta si existe pero no hay detenido entonces es nuevo detenido Insert
            }
        } else { //la url esta mal desde el inicio por posible manipulación, no hay necesidad de feedback
            header("Location: " . base_url . "Juridico");
            exit();
        }

        $user = $_SESSION['userdata']->Id_Usuario;
        $ip = $this->obtenerIp();
        $descripcion = 'Ver AnexoE, Puesta: ' . $_GET['id_puesta'];
        $this->Remision->historial($user, $ip, 18, $descripcion);

        $this->view('templates/header', $data);
        $this->view('system/Juridico/anexos/E/anexoEView', $data);
        $this->view('templates/footer', $data);
    }
    public function insertUpdateAnexoEFetch()
    {
        // $data = ($_POST['Tipo_Form'])?'Update':'Insert prro';
        // echo json_encode($data);
        try {
            //comprobar los permisos para dejar pasar al módulo
            if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
                $data['resp_case'] = 'error_session';
                $data['error_message'] = 'La sesión caducó. Vuelva a iniciar sesión.';
            } else if (isset($_POST['Id_Puesta'])) {

                //set rules
                $k = 0;
                //reservar datos entrevistado
                $valid[$k++] = $data['error_reservar_datos'] = $this->FV->validate($_POST, 'Reservar_Datos', 'required | numeric | length[1]');

                //fecha/hora entrevista
                $valid[$k++] = $data['error_fecha']     = $this->FV->validate($_POST, 'Fecha', 'required | date');
                $valid[$k++] = $data['error_hora']      = $this->FV->validate($_POST, 'Hora', 'required | time');

                if($_POST['Reservar_Datos'] == '1'){//si desea reservar datos
                    $valid[$k++] = $data['error_nombre_ent']            = $this->FV->validate($_POST, 'Nombre_Ent', 'max_length[250]');
                    $valid[$k++] = $data['error_ap_pat_ent']            = $this->FV->validate($_POST, 'Ap_Paterno_Ent', 'max_length[250]');
                    $valid[$k++] = $data['error_ap_mat_ent']            = $this->FV->validate($_POST, 'Ap_Materno_Ent', 'max_length[250]');
                    $valid[$k++] = $data['error_fecha_nacimiento']      = $this->FV->validate($_POST, 'Fecha_Nacimiento', 'max_length[20]');
                    $valid[$k++] = $data['error_edad']                  = $this->FV->validate($_POST, 'Edad', 'max_length[3]');
                }
                else{
                    $valid[$k++] = $data['error_nombre_ent']            = $this->FV->validate($_POST, 'Nombre_Ent', 'required | max_length[250]');
                    $valid[$k++] = $data['error_ap_pat_ent']            = $this->FV->validate($_POST, 'Ap_Paterno_Ent', 'required | max_length[250]');
                    $valid[$k++] = $data['error_ap_mat_ent']            = $this->FV->validate($_POST, 'Ap_Materno_Ent', 'required | max_length[250]');
                    $valid[$k++] = $data['error_fecha_nacimiento']      = $this->FV->validate($_POST, 'Fecha_Nacimiento', 'required | max_length[20]');
                    $valid[$k++] = $data['error_edad']                  = $this->FV->validate($_POST, 'Edad', 'required | max_length[3]');
                }
                // datos generales del entrevistado
                
                $valid[$k++] = $data['error_calidad']               = $this->FV->validate($_POST, 'Calidad', 'required | max_length[250]');
                $valid[$k++] = $data['error_nacionalidad_select']   = $this->FV->validate($_POST, 'Nacionalidad', 'required | max_length[45]');
                //nacionalidad
                if ($_POST['Nacionalidad'] != 'MEXICANA')
                    $valid[$k++] = $data['error_nacionalidad_otro']     = $this->FV->validate($_POST, 'Nacionalidad_Otro', 'required | max_length[45]');

                $valid[$k++] = $data['error_genero']                = $this->FV->validate($_POST, 'Genero', 'required | length[1]');
                $valid[$k++] = $data['error_telefono']              = $this->FV->validate($_POST, 'Telefono', 'max_length[20]');
                $valid[$k++] = $data['error_correo']                = $this->FV->validate($_POST, 'Correo', 'max_length[100]');
                $valid[$k++] = $data['error_identificacion_select'] = $this->FV->validate($_POST, 'Identificacion', 'required | max_length[45]');
                if ($_POST['Identificacion'] == 'Otro')
                    $valid[$k++] = $data['error_identificacion_otro']   = $this->FV->validate($_POST, 'Identificacion_Otro', 'required | max_length[45]');
                $valid[$k++] = $data['error_num_identificacion']    = $this->FV->validate($_POST, 'Num_Identificacion', 'max_length[45]');

                //domicilio del detenido
                $valid[$k++] = $data['error_colonia_domEntrev']         = $this->FV->validate($_POST, 'Colonia_Dom_Entrev', 'max_length[500]');
                $valid[$k++] = $data['error_calle_1_domEntrev']         = $this->FV->validate($_POST, 'Calle_1_Dom_Entrev', 'max_length[100]');
                $valid[$k++] = $data['error_no_ext_domEntrev']          = $this->FV->validate($_POST, 'No_Ext_Dom_Entrev', 'max_length[100]');
                $valid[$k++] = $data['error_no_int_domEntrev']          = $this->FV->validate($_POST, 'No_Int_Dom_Entrev', 'max_length[100]');
                $valid[$k++] = $data['error_coord_x_domEntrev']         = $this->FV->validate($_POST, 'Coordenada_X_Dom_Entrev', 'max_length[45]');
                $valid[$k++] = $data['error_coord_y_domEntrev']         = $this->FV->validate($_POST, 'Coordenada_Y_Dom_Entrev', 'max_length[45]');
                $valid[$k++] = $data['error_estado_domEntrev']          = $this->FV->validate($_POST, 'Estado_Dom_Entrev', 'max_length[850]');
                $valid[$k++] = $data['error_municipio_domEntrev']       = $this->FV->validate($_POST, 'Municipio_Dom_Entrev', 'max_length[850]');
                $valid[$k++] = $data['error_cp_domEntrev']              = $this->FV->validate($_POST, 'CP_Dom_Entrev', 'max_length[45]');
                $valid[$k++] = $data['error_referencias_domEntrev']     = $this->FV->validate($_POST, 'Referencias_Dom_Entrev', 'max_length[850]');

                // relato entrevista
                $valid[$k++] = $data['error_relato_entrevista']     = $this->FV->validate($_POST, 'Relato_Entrevista', 'max_length[50000]');

                // traslado entrevistado
                $valid[$k++] = $data['error_canalizacion']  = $this->FV->validate($_POST, 'Canalizacion', 'required | length[1]');
                if ($_POST['Canalizacion'] == '1') {
                    $valid[$k++] = $data['error_lugar_canalizacion']        = $this->FV->validate($_POST, 'Lugar_Canalizacion', 'required | max_length[45]');
                    $valid[$k++] = $data['error_descripcion_canalizacion']  = $this->FV->validate($_POST, 'Descripcion_Canalizacion', 'required | max_length[500]');
                }

                // primer respondiente
                $valid[$k++] = $data['error_primer_respondiente_radio']     = $this->FV->validate($_POST, 'Primer_Respondiente_Radio', 'required | length[1]');
                if ($_POST['Primer_Respondiente_Radio'] == '1') {
                    $valid[$k++] = $data['error_nombre_pr']         = $this->FV->validate($_POST, 'Nombre_PR', 'required | max_length[250]');
                    $valid[$k++] = $data['error_ap_pat_pr']         = $this->FV->validate($_POST, 'Ap_Paterno_PR', 'required | max_length[250]');
                    $valid[$k++] = $data['error_ap_mat_pr']         = $this->FV->validate($_POST, 'Ap_Materno_PR', 'required | max_length[250]');
                    $valid[$k++] = $data['error_institucion_pr']    = $this->FV->validate($_POST, 'Institucion_PR', 'required | max_length[250]');
                    $valid[$k++] = $data['error_cargo_pr']          = $this->FV->validate($_POST, 'Cargo_PR', 'required | max_length[250]');
                }

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) { //se trata de actualizar el dictamen con toda la info mandada
                    //dependiendo se realiza un insert o un update
                    $success2 = ($_POST['Tipo_Form']) ? $this->JuridicoM->updateAnexoE($_POST) : $this->JuridicoM->insertAnexoE($_POST);
                    if ($success2['success']) {
                        $data['resp_case'] = 'success';
                        $data['success'] = true;
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        if($_POST['Tipo_Form']){
                            $descripcion = 'Editar AnexoE, Puesta: ' . $_POST['Id_Puesta'];
                            $this->Remision->historial($user, $ip, 17, $descripcion);
                        }else{
                            $descripcion = 'Creo AnexoE, Puesta: ' . $_POST['Id_Puesta'];
                            $this->Remision->historial($user, $ip, 16, $descripcion);
                        }
                    } else {
                        $data['resp_case'] = 'error_db';
                        $data['error_message'] = 'Parece que ocurrió un problema en la base de datos. Mensaje: ' . $success2['error_message'];
                    }
                } else { //error en el formulario
                    $data['resp_case'] = 'error_form';
                    $data['error_message'] = 'Error en el formulario, compruebe que toda la información este llenada correctamente y que ningun campo requerido haga falta.';
                }
            } else { // error en la petición
                $data['resp_case'] = 'error_post';
                $data['error_message'] = 'Error en la petición de la función (mal formada)';
            }
        } catch (Exception $err) {
            $data['resp_case'] = 'error_interno';
            $data['error_message'] = 'Error interno: ' . $err;
        }

        // se retorna la respuesta final
        echo json_encode($data);
    }
    public function getInfoAnexoEFetch()
    {
        try {
            if (isset($_POST['Id_Puesta']) && isset($_POST['Id_Entrevista'])) {
                $info = $this->JuridicoM->getInfoAnexoE($_POST['Id_Puesta'], $_POST['Id_Entrevista']);
                if ($info['success']) { //se retornan toda la info del detenido
                    $data['resp_case'] = 'success';
                    $data['apartados'] = $info['apartados'];
                } else { //error en la info del detenido
                    $data['resp_case'] = 'error_db';
                    $data['error_message'] = 'Error interno: ' . $info['error_message'];
                }
            }
        } catch (Exception $err) {
            $data['resp_case'] = 'error_interno';
            $data['error_message'] = 'Error interno: ' . $err;
        }

        //se retorna la respuesta final
        echo json_encode($data);
    }
/* ------------------------------FIN FUNCIONES ANEXO E------------------------------ */


/* ------------------------------INICIO FUNCIONES ANEXO F------------------------------ */
    public function AnexoF($id_puesta = null, $id_elem = null )
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $data = [
            'titulo'     => 'Planeación | Jurídico | Anexo F',
            'extra_css'  => '<link rel="stylesheet" href="' . base_url . 'public/css/system/juridico/anexos/F/style.css">',
            'extra_js'   => '<script src="' . base_url . 'public/js/system/juridico/generalFunctions.js"></script>' .
                '<script src="' . base_url . 'public/js/system/juridico/anexos/F/validations.js"></script>' .
                '<script src="' . base_url . 'public/js/system/juridico/anexos/F/index.js"></script>' .
                '<script src="' . base_url . 'public/js/system/juridico/anexos/F/table.js"></script>'
        ];


        if ($id_puesta != null && is_numeric($id_puesta)) {
            $data['id_puesta'] =  $id_puesta;
            if (!$this->JuridicoM->existeRegistroTabla('iph_puesta_disposicion', ['Id_Puesta'], [$id_puesta])) {
                header("Location: " . base_url . "Juridico");
                exit();
            } else {
                if (($id_elem != null && is_numeric($id_elem))) { //numero de detenido
                    $data['id_elem'] = $id_elem;
                    if (!$this->JuridicoM->existeRegistroTabla('iph_entrega_recepcion_lugar', ['Id_Puesta', 'Id_Entrega_Recepcion_Lugar'], [$id_puesta, $id_elem])) { //si no existe el detenido entonces se sale de ese proceso por posible manipulación desde la url
                        header("Location: " . base_url . "Juridico");
                        exit();
                    } else { //existe puesta y detenido entonces se trata de Editar/Ver se carga javascript para cargar la info previa
                        $data['extra_js'] .=    '<script src="' . base_url . 'public/js/system/juridico/anexos/F/editView.js"></script>'.
                            '<script src="' . base_url . 'public/js/system/juridico/anexos/F/getAnexoF.js"></script>';

                        // echo "Editar" ;
                    }
                } else {
                    // echo "Nuevo";
                    $data['id_elem'] = -1;
                }
            }
        } else {
            header("Location: " . base_url . "Juridico");
            exit();
        }

        $user = $_SESSION['userdata']->Id_Usuario;
        $ip = $this->obtenerIp();
        $descripcion = 'Ver AnexoF, Puesta: ' . $id_puesta;
        $this->Remision->historial($user, $ip, 18, $descripcion);

        $this->view('templates/header', $data);
        $this->view('system/Juridico/anexos/F/anexoFView', $data);
        $this->view('templates/footer', $data);
    }

    public function getInfoAnexoF()
    {
        try {
            if (isset($_POST['Id_Puesta']) && isset($_POST['Id_Entrega_Recepcion_Lugar'])) {
                $info = $this->JuridicoM->getInfoAnexoF($_POST['Id_Puesta'], $_POST['Id_Entrega_Recepcion_Lugar']);
                if ($info['success']) { //se retornan toda la info del detenido
                    $data['resp_case'] = 'success';
                    $data['apartados'] = $info['apartados'];
                } else { //error en la info del detenido
                    $data['resp_case'] = 'error_db';
                    $data['error_message'] = 'Error interno: ' . $info['error_message'];
                }
            }
        } catch (Exception $err) {
            $data['resp_case'] = 'error_interno';
            $data['error_message'] = 'Error interno: ' . $err;
        }
        echo json_encode($data);
    }

    public function insertarAnexoF()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['btn_anexoF'])) { //Anexo D - Armas

                $k = 0;
                $valid[$k++] = $data_p['Descripcion_PL_error']      = $this->FV->validate($_POST, 'Descripcion_PL', 'required | max_length[16000]');
                $valid[$k++] = $data_p['Nombre_PER_0_error']        = $this->FV->validate($_POST, 'Nombre_PER_0', 'required | max_length[200]');
                $valid[$k++] = $data_p['Ap_Paterno_PER_0_error']    = $this->FV->validate($_POST, 'Ap_Paterno_PER_0', 'required | max_length[450]');
                $valid[$k++] = $data_p['Ap_Materno_PER_0_error']    = $this->FV->validate($_POST, 'Ap_Materno_PER_0', 'required | max_length[450]');
                $valid[$k++] = $data_p['Institucion_0_error']       = $this->FV->validate($_POST, 'Institucion_0', 'required | max_length[450]');
                $valid[$k++] = $data_p['Cargo_0_error']             = $this->FV->validate($_POST, 'Cargo_0', 'required | max_length[450]');
                $valid[$k++] = $data_p['Nombre_PER_1_error']        = $this->FV->validate($_POST, 'Nombre_PER_1', 'required | max_length[200]');
                $valid[$k++] = $data_p['Ap_Paterno_PER_1_error']    = $this->FV->validate($_POST, 'Ap_Paterno_PER_1', 'required | max_length[450]');
                $valid[$k++] = $data_p['Ap_Materno_PER_1_error']    = $this->FV->validate($_POST, 'Ap_Materno_PER_1', 'required | max_length[450]');
                $valid[$k++] = $data_p['Institucion_1_error']       = $this->FV->validate($_POST, 'Institucion_1', 'required | max_length[450]');
                $valid[$k++] = $data_p['Cargo_1_error']             = $this->FV->validate($_POST, 'Cargo_1', 'required | max_length[450]');
                $valid[$k++] = $data_p['Observaciones_error']       = $this->FV->validate($_POST, 'Observaciones', 'required | max_length[4500]');
                $valid[$k++] = $data_p['Fecha_error']               = $this->FV->validate($_POST, 'Fecha', 'required | date');
                $valid[$k++] = $data_p['Hora_error']                = $this->FV->validate($_POST, 'Hora', 'required | time');

                if ($_POST['autoridad'] == 'Si')
                    $valid[$k++] = $data_p['Descripcion_Apoyo_error']   = $this->FV->validate($_POST, 'Descripcion_Apoyo', 'required | max_length[4000]');

                if ($_POST['persona'] == 'Si') {
                    $valid[$k++] = $data_p['Motivo_Ingreso_error']      = $this->FV->validate($_POST, 'Motivo_Ingreso', 'required | max_length[4000]');
                    // $valid[$k++] = $data_p['tabla_error'] = (tabla.rows.length > 1) ? '' : 'La tabla debe contener almenos 1 elemento.'
                }

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) {
                    $data_p['Server_Validation_Status'] =  'false';
                    $success_2 = $this->JuridicoM->insertarAnexoF($_POST);
                    //$success_2['status'] =  true;
                    if ($success_2['status']) {
                        $data_p['Server_Status_Insertion'] = $success_2['status'];
                        // $this->Historial->insertHistorial(11,'Nuevo registro I.O.:'.$Id_Inteligencia);
                        $data_p['status'] =  true;
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $descripcion = 'Creo AnexoF, Puesta: ' . $_POST['Id_Puesta'];
                        $this->Remision->historial($user, $ip, 16, $descripcion);
                        
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


    public function actualizarAnexoF()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['btn_anexoF'])) { //Anexo D - Armas

                $k = 0;
                $valid[$k++] = $data_p['Descripcion_PL_error']      = $this->FV->validate($_POST, 'Descripcion_PL', 'required | max_length[16000]');
                $valid[$k++] = $data_p['Nombre_PER_0_error']        = $this->FV->validate($_POST, 'Nombre_PER_0', 'required | max_length[200]');
                $valid[$k++] = $data_p['Ap_Paterno_PER_0_error']    = $this->FV->validate($_POST, 'Ap_Paterno_PER_0', 'required | max_length[450]');
                $valid[$k++] = $data_p['Ap_Materno_PER_0_error']    = $this->FV->validate($_POST, 'Ap_Materno_PER_0', 'required | max_length[450]');
                $valid[$k++] = $data_p['Institucion_0_error']       = $this->FV->validate($_POST, 'Institucion_0', 'required | max_length[450]');
                $valid[$k++] = $data_p['Cargo_0_error']             = $this->FV->validate($_POST, 'Cargo_0', 'required | max_length[450]');
                $valid[$k++] = $data_p['Nombre_PER_1_error']        = $this->FV->validate($_POST, 'Nombre_PER_1', 'required | max_length[200]');
                $valid[$k++] = $data_p['Ap_Paterno_PER_1_error']    = $this->FV->validate($_POST, 'Ap_Paterno_PER_1', 'required | max_length[450]');
                $valid[$k++] = $data_p['Ap_Materno_PER_1_error']    = $this->FV->validate($_POST, 'Ap_Materno_PER_1', 'required | max_length[450]');
                $valid[$k++] = $data_p['Institucion_1_error']       = $this->FV->validate($_POST, 'Institucion_1', 'required | max_length[450]');
                $valid[$k++] = $data_p['Cargo_1_error']             = $this->FV->validate($_POST, 'Cargo_1', 'required | max_length[450]');
                $valid[$k++] = $data_p['Observaciones_error']       = $this->FV->validate($_POST, 'Observaciones', 'required | max_length[4500]');
                $valid[$k++] = $data_p['Fecha_error']               = $this->FV->validate($_POST, 'Fecha', 'required | date');
                $valid[$k++] = $data_p['Hora_error']                = $this->FV->validate($_POST, 'Hora', 'required ');

                if ($_POST['autoridad'] == 'Si')
                    $valid[$k++] = $data_p['Descripcion_Apoyo_error']   = $this->FV->validate($_POST, 'Descripcion_Apoyo', 'required | max_length[4000]');

                if ($_POST['persona'] == 'Si') {
                    $valid[$k++] = $data_p['Motivo_Ingreso_error']      = $this->FV->validate($_POST, 'Motivo_Ingreso', 'required | max_length[4000]');
                    // $valid[$k++] = $data_p['tabla_error'] = (tabla.rows.length > 1) ? '' : 'La tabla debe contener almenos 1 elemento.'
                }

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;

                if ($success) {
                    // $data_p['Server_Validation_Status'] =  'false';
                    $success_2 = $this->JuridicoM->actualizarAnexoF($_POST);
                    // $success_2['status'] =  true;
                    if ($success_2['status']) {
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $descripcion = 'Editar AnexoF, Puesta: ' . $_POST['Id_Puesta'];
                        $this->Remision->historial($user, $ip, 17, $descripcion);
                        $data_p['Server_Status_Insertion'] = $success_2['status'];
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
/* ------------------------------FIN FUNCIONES ANEXO F------------------------------ */



//-----------------------FUNCIONES AUXILIARES PARA COMPLEMENTAR LOS PRINCIPALES MÓDULOS-----------------------
    //función para generar la paginación dinámica
    public function generarLinks($numPage, $total_pages, $extra_cad = "", $filtro = 1)
    {
        //$extra_cad sirve para determinar la paginacion conforme a si se realizó una busqueda
        //Creación de links para el pagination
        $links = "";

        //FLECHA IZQ (PREV PAGINATION)
        if ($numPage > 1) {
            $links .= '<li class="page-item">
                        <a class="page-link" href=" ' . base_url . 'Juridico/index/?numPage=1' . $extra_cad . '&filtro=' . $filtro . ' " data-toggle="tooltip" data-placement="top" title="Primera página">
                            <i class="material-icons">first_page</i>
                        </a>
                    </li>';
            $links .= '<li class="page-item">
                        <a class="page-link" href=" ' . base_url . 'Juridico/index/?numPage=' . ($numPage - 1) . $extra_cad . '&filtro=' . $filtro . ' " data-toggle="tooltip" data-placement="top" title="Página anterior">
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
                            <a class="page-link" href=" ' . base_url . 'Juridico/index/?numPage=' . ($ind) . $extra_cad . '&filtro=' . $filtro . ' ">
                                ' . ($ind) . '
                            </a>
                        </li>';
            }
        }

        //FLECHA DERECHA (NEXT PAGINATION)
        if ($numPage < $total_pages) {

            $links .= '<li class="page-item">
                        <a class="page-link" href=" ' . base_url . 'Juridico/index/?numPage=' . ($numPage + 1) . $extra_cad . '&filtro=' . $filtro . ' " data-toggle="tooltip" data-placement="top" title="Siguiente página">
                        <i class="material-icons">navigate_next</i>
                        </a>
                    </li>';
            $links .= '<li class="page-item">
                        <a class="page-link" href=" ' . base_url . 'Juridico/index/?numPage=' . ($total_pages) . $extra_cad . '&filtro=' . $filtro . ' " data-toggle="tooltip" data-placement="top" title="Última página">
                        <i class="material-icons">last_page</i>
                        </a>
                    </li>';
        }

        return $links;
    }

    //función para generar la información de la tabla de forma dinámica
    public function generarInfoTable($rows, $filtro = 1)
    {
        //se genera la tabulacion de la informacion por backend
        $infoTable['header'] = "";
        $infoTable['body'] = "";


        switch ($filtro) {
            case '1': //todos
                $infoTable['header'] .= '
                        <th class="column1">Folio</th>
                        <th class="column2">Num Referencia</th>
                        <th class="column3">Folio IPH</th>
                        <th class="column4">Fecha / Hora</th>
                        <th class="column5">Estatus</th>
                        <th class="column6">Primer respondiente</th>
                        <th class="column7">Lugar Intervención</th>
                        <th class="column8">Creada por</th>
                    ';
                foreach ($rows as $row) {
                    $infoTable['body'] .= '<tr id="tr' . $row->Id_Puesta . '">';
                    $infoTable['body'] .= '<td class="column1">' . $row->Id_Puesta . '</td>
                                            <td class="column2">' . mb_strtoupper($row->Num_Referencia) . '</td>
                                            <td class="column3">' . mb_strtoupper($row->Folio_IPH) . '</td>
                                            <td class="column4">' . mb_strtoupper($row->Fecha_Hora) . '</td>
                                            <td class="column5">' . mb_strtoupper($row->Estatus_Cadena) . '</td>
                                            <td class="column6">' . mb_strtoupper($row->Nombre_Primer_Respondiente) . '</td>
                                            <td class="column7">' . mb_strtoupper($row->Ubicacion_Intervencion) . '</td>
                                            <td class="column8">' . mb_strtoupper($row->Nombre_Usuario) . '</td>
                        ';
                    $infoTable['body'] .= '<td>
                                            <a class="myLinks mb-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="right" title="Abrir registro" href="' . base_url . 'Juridico/Puesta/' . $row->Id_Puesta . '/ver' . '">
                                                <i class="material-icons">app_registration</i>
                                            </a>
                                        </td>';

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
            $dataReturn['csv'] =  base_url . 'Juridico/exportarInfo/?tipo_export=CSV' . $extra_cad . '&filtroActual=' . $filtro;
            $dataReturn['excel'] =  base_url . 'Juridico/exportarInfo/?tipo_export=EXCEL' . $extra_cad . '&filtroActual=' . $filtro;
            $dataReturn['pdf'] =  base_url . 'Juridico/exportarInfo/?tipo_export=PDF' . $extra_cad . '&filtroActual=' . $filtro;
            //return $dataReturn;
        } else {
            $dataReturn['csv'] =  base_url . 'Juridico/exportarInfo/?tipo_export=CSV' . $extra_cad . '&filtroActual=' . $filtro;
            $dataReturn['excel'] =  base_url . 'Juridico/exportarInfo/?tipo_export=EXCEL' . $extra_cad . '&filtroActual=' . $filtro;
            $dataReturn['pdf'] =  base_url . 'Juridico/exportarInfo/?tipo_export=PDF' . $extra_cad . '&filtroActual=' . $filtro;
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

            $results = $this->JuridicoM->getJuridicoByCadena($cadena, $filtroActual);
            $extra_cad = ($cadena != "") ? ("&cadena=" . $cadena) : ""; //para links conforme a búsqueda

            // if(strlen($cadena)>0){
            //     $this->Historial->insertHistorial(10,'Consulta realizada: '.$cadena.'');
            // }

            $dataReturn['infoTable'] = $this->generarInfoTable($results['rows_Juridico'], $filtroActual);
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
        if (!isset($_REQUEST['filtroActual']) || !is_numeric($_REQUEST['filtroActual']) || !($_REQUEST['filtroActual'] >= MIN_FILTRO_JUR) || !($_REQUEST['filtroActual'] <= MAX_FILTRO_JUR))
            $filtroActual = 1;
        else
            $filtroActual = $_REQUEST['filtroActual'];

        $from_where_sentence = "";
        //se genera la sentencia from where para realizar la correspondiente consulta
        if (isset($_REQUEST['cadena']))
            $from_where_sentence = $this->JuridicoM->generateFromWhereSentence($_REQUEST['cadena'], $filtroActual);
        else
            $from_where_sentence = $this->JuridicoM->generateFromWhereSentence("", $filtroActual);



        //var_dump($_REQUEST);
        $tipo_export = $_REQUEST['tipo_export'];

        if ($tipo_export == 'EXCEL') {
            //se realiza exportacion de usuarios a EXCEL
            $rows_JUR = $this->JuridicoM->getAllInfoJuridicoByCadena($from_where_sentence);
            switch ($filtroActual) {
                case '1':
                    $filename = "Juridico_general";
                    $csv_data = "Fecha/Hora,Creada por,Folio,Num Referencia,Folio IPH,Estatus,Primer Respondiente,Lugar Intervención\n";

                    foreach ($rows_JUR as $row) {
                        $csv_data .= "\"" . mb_strtoupper($row->Fecha_Hora) . "\",\"" .
                            mb_strtoupper($row->Nombre_Usuario) . "\",\"" .
                            mb_strtoupper($row->Id_Puesta) . "\",\"" .
                            mb_strtoupper($row->Num_Referencia) . "\",\"" .
                            mb_strtoupper($row->Folio_IPH) . "\",\"" .
                            mb_strtoupper($row->Estatus_Cadena) . "\",\"" .
                            mb_strtoupper($row->Nombre_Primer_Respondiente) . "\",\"" .
                            mb_strtoupper($row->Ubicacion_Intervencion) . "\"\n";
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
            $rows_JUR = $this->JuridicoM->getAllInfoInspeccionByCadena($from_where_sentence);


            header("Content-type: application/pdf");
            header("Content-Disposition: inline; filename=usuarios.pdf");
            echo $this->generarPDF($rows_JUR, $_REQUEST['cadena'], $filtroActual);
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }

    //función para armar el archivo PDF dependiendo del filtro y/o cadena de búsqueda
    public function generarPDF($rows_INSP, $cadena = "", $filtroActual = '1')
    {
    }

    //funcion para borrar variable sesión para filtro de rangos de fechas
    public function removeRangosFechasSesion()
    {

        if (isset($_REQUEST['filtroActual'])) {
            unset($_SESSION['userdata']->rango_inicio_jur);
            unset($_SESSION['userdata']->rango_fin_jur);
            unset($_SESSION['userdata']->rango_hora_inicio_jur);
            unset($_SESSION['userdata']->rango_hora_fin_jur);

            header("Location: " . base_url . "Juridico/index/?filtro=" . $_REQUEST['filtroActual']);
            exit();
        } else {
            header("Location: " . base_url . "Inicio");
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
                $campos = ['Folio', 'Num Referencia', 'Folio IPH', 'Fecha / Hora', 'Estatus', 'Primer respondiente', 'Lugar Intervención', 'Creada por'];
                break;
        }
        //gestión de cada columna
        $ind = 1;
        foreach ($campos as $campo) {
            $checked = ($_SESSION['userdata']->columns_JUR['column' . $ind] == 'show') ? 'checked' : '';
            $dropDownColumn .= ' <div class="form-check">
                                    <input class="form-check-input checkColumns" type="checkbox" value="' . $_SESSION['userdata']->columns_JUR['column' . $ind] . '" onchange="hideShowColumn(this.id);" id="column' . $ind . '" ' . $checked . '>
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
        if (isset($_SESSION['userdata']->filtro_JUR) && $_SESSION['userdata']->filtro_JUR >= MIN_FILTRO_JUR && $_SESSION['userdata']->filtro_JUR <= MAX_FILTRO_JUR) {
            //si cambia el filtro se procde a cambiar los valores de las columnas que contiene el filtro seleccionado
            if ($_SESSION['userdata']->filtro_JUR != $filtroActual) {
                $_SESSION['userdata']->filtro_JUR = $filtroActual;
                unset($_SESSION['userdata']->columns_JUR); //se borra las columnas del anterior filtro
                //se asignan las nuevas columnas y por default se muestran todas (atributo show)
                for ($i = 0; $i < $this->numColumnsJUR[$_SESSION['userdata']->filtro_JUR - 1]; $i++)
                    $_SESSION['userdata']->columns_JUR['column' . ($i + 1)] = 'show';
            }
        } else { //si no existe el filtro entonces se inicializa con el primero por default
            $_SESSION['userdata']->filtro_JUR = $filtroActual;
            unset($_SESSION['userdata']->columns_JUR);
            for ($i = 0; $i < $this->numColumnsJUR[$_SESSION['userdata']->filtro_JUR - 1]; $i++)
                $_SESSION['userdata']->columns_JUR['column' . ($i + 1)] = 'show';
        }
        //echo "filtro: ".var_dump($_SESSION['userdata']->filtro_JUR)."<br>br>";
        //echo "columns: ".var_dump($_SESSION['userdata']->columns_JUR)."<br>br>";
    }

    //función fetch que actualiza los valores de las columnas para la session
    public function setColumnFetch()
    {
        if (isset($_POST['columName']) && isset($_POST['valueColumn'])) {
            $_SESSION['userdata']->columns_JUR[$_POST['columName']] = $_POST['valueColumn'];
            echo json_encode("ok");
        } else {
            header("Location: " . base_url . "Inicio");
            exit();
        }
    }

    //dar formato a fecha y Hora
    public function formatearFechaHora($fecha = null)
    {
        $f_h = explode(" ", $fecha);

        setlocale(LC_TIME, 'es_CO.UTF-8'); //hora local méxico

        $results['Fecha'] = strftime("%d  de %B del %G", strtotime($f_h[0]));
        $results['Hora'] = date('g:i a', strtotime($f_h[1]));

        return $results;
    }
    public function formatearOnlyFecha($fecha = null)
    {
        if ($fecha === null)
            return '';

        setlocale(LC_TIME, 'es_CO.UTF-8'); //hora local méxico

        return strftime("%d  de %B del %G", strtotime($fecha));
    }
    public function formatearOnlyFecha2($fecha = null)
    {
        if ($fecha == null)
            return '';

        //setlocale(LC_TIME, 'es_CO.UTF-8'); //hora local méxico

        return strftime(" %d / %m / %Y", strtotime($fecha));
    }
//-----------------------FIN --- FUNCIONES AUXILIARES PARA COMPLEMENTAR LOS PRINCIPALES MÓDULOS-----------------------


    public function crearPuesta()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['btn_save'])) {
                if ($_POST['huboDetenidos'] == 'false') {
                    $success = $this->JuridicoM->crearPuesta($_POST);
                    if ($success['status']) {
                        $id_puesta = $success['id_puesta'];
                        $lugarIntervencion = $this->JuridicoM->insertarLugarIntervencion($id_puesta);
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $descripcion = 'Nueva puesta indicios: ' . $id_puesta;
                        $this->Remision->historial($user, $ip, 15, $descripcion);
                        $data_p['status'] = true;
                        $data_p['id_puesta'] = $id_puesta;
                        echo json_encode($data_p);
                    }else{
                        $data_p['status'] = false;
                        $data_p['error_message'] = $success['error_message'];
                        echo json_encode($data_p);
                    }
                } else {
                    $crearPuesta = $this->JuridicoM->crearPuesta($_POST);
                    if ($crearPuesta['status']) {
                        $id_puesta = $crearPuesta['id_puesta'];
                        $lugarIntervencion = $this->JuridicoM->insertarLugarIntervencion($id_puesta);
                        if ($lugarIntervencion['status']) {
                            $detenidos = json_decode($_POST['detenidos']);
                            $arrayStatus = array();
                            foreach ($detenidos as $key => $detenido) {
                                $post['Nombre_D'] = $detenido->row->nombre;
                                $post['Ap_Paterno_D'] = $detenido->row->primerApellido;
                                $post['Ap_Materno_D'] = $detenido->row->segundoApellido;
                                $post['Edad'] = $detenido->row->edad;
                                $post['Genero'] = ($detenido->row->sexo == 'HOMBRE') ? 'H' : 'M';
                                $post['Ubicacion_Det_Radio'] = 'Sí';
                                $post['Primer_Respondiente_Radio'] = 'No';
                                $post['Familiar_Radio'] = 'No';
                                $post['Pertenencias_Encontradas'] = 'No';
                                $post['Id_Puesta'] = $id_puesta;
                                $post['Nacionalidad_Radio'] = 'MEXICANA';
                                $post['Identificacion'] = '';
                                $post['Lesiones'] = 'No';
                                $post['Padecimiento_Radio'] = 'No';
                                $post['Grupo_V_Radio'] = 'No';
                                $post['Grupo_D_Radio'] = 'No';
                                $post['Lectura_Derechos'] = 'No';
                                $post['Objeto_Encontrado'] = 'No';
                                $post['Fecha_Nacimiento'] = $detenido->row->fecha;
                                $anexoA = $this->JuridicoM->insertAnexoA($post);
                                if ($anexoA['success']) {
                                    $data_p['status'] = true;
                                    $data_p['id_puesta'] = $id_puesta;
                                }
                            }
                            $user = $_SESSION['userdata']->Id_Usuario;
                            $ip = $this->obtenerIp();
                            $descripcion = 'Nueva puesta detenidos: ' . $id_puesta;
                            $this->Remision->historial($user, $ip, 15, $descripcion);
                            echo json_encode($data_p);
                        } else {
                            echo json_encode($lugarIntervencion);
                        }
                    } else {
                        echo json_encode($crearPuesta);
                    }
                }
            } else {
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';
                echo json_encode($data_p);
            }
        }
    }

    public function createRemisiones()
    {
        if (!isset($_SESSION['userdata'])) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            $detenidos = json_decode($_POST['detenidos']);
            $post['No_Ficha'] = '';
            $id_puesta = '';
            $band = true;
            foreach($detenidos as $key=>$detenido){
                $id_detenido = $detenido->id_detenido;
                $id_puesta = $detenido->id_puesta;
                $detenidoInfo = $this->JuridicoM->existeRegistroTabla('iph_detenido', ['Id_Detenido'], [$id_detenido]);
                if($detenidoInfo){
                    $primerRespondiente = $this->JuridicoM->existeRegistroTabla('iph_primer_respondiente', ['Id_Primer_Respondiente'], [$detenidoInfo->Id_Primer_Respondiente]);
                    ($key == 0) ? $post['ficha'] = 'No' : $post['ficha'] = 'Si';
                    $post['id_iph'] = 'IPH_'.$id_detenido;
                    $post['Municipio'] = $post['Colonia'] = $post['Calle'] = $post['noExterior'] = $post['noInterior'] = $post['cordX'] = $post['cordY'] = $post['CP'] = $post['Estado'] = $post['escolaridad_principales'] = $post['FechaNacimiento_principales'] = $post['CURP_principales'] = $post['pertenencias_rem'] = $post['zona'] = $post['fecha_principales'] = $post['hora_principales'] = $post['statusR_principales'] = $post['911_principales'] = $post['tipoFicha'] = $post['Remitido'] = $post['CIA_principales'] = $post['Alias'] = '';
                    $post['Nombre_principales'] = $detenidoInfo->Nombre_D;
                    $post['appPaterno_principales'] = $detenidoInfo->Ap_Paterno_D;
                    $post['appMaterno_principales'] = $detenidoInfo->Ap_Materno_D;
                    $post['sexo_principales'] = $detenidoInfo->Genero;
                    $post['edad_principales'] = $detenidoInfo->Edad;
                    $post['procedencia_principales'] = '';
                    $post['fecha_principales'] = date('Y-m-d');
                    $post['hora_principales'] = date('H:i');
                    $remision = $this->Remision->nuevaRemision($post);
                    if ($remision['status']) {
                        $post['No_Ficha'] = $remision['no_ficha'];
                        $respondiente['sector'] = '';
                        $respondiente['nombreElemento'] = $primerRespondiente->Nombre_PR;
                        $respondiente['primerApellidoElemento'] = $primerRespondiente->Ap_Paterno_PR;
                        $respondiente['segundoApellidoElemento'] = $primerRespondiente->Ap_Materno_PR;
                        $respondiente['numControl'] = $primerRespondiente->No_Control;
                        $respondiente['sector'] = $primerRespondiente->Institucion;
                        $respondiente['cargoElemento'] = $primerRespondiente->Cargo;
                        $elemento = $this->Remision->elementoParticipante($respondiente, $remision['no_remision']);
                        if($elemento['status']){
                            $bit = $this->JuridicoM->updateBitJuridicoDetenido($id_detenido,0);
                            if($bit['status']){
                                $data_p['status'] = true;
                            }else{
                                $data_p['status'] = false;
                                $data_p['error_message'] = $bit['error_message'];
                                $band = false;
                            }   
                        }else{
                            $data_p['status'] = false;
                            $data_p['error_message'] = $elemento['message_error'];
                            $band = false;
                        }
                    }else{
                        $data_p['status'] = false;
                        $data_p['error_message'] = $remision['error_message'];
                        $band = false;
                    }
                }else{
                    $data_p['status'] = false;
                    $data_p['error_message'] = 'No se encontro registro del detenido '.$detenido->nombre;
                    $band = false;
                }
            }

            if($band){
                $detenidosPuesta = $this->JuridicoM->getAnexosA($id_puesta);
                foreach($detenidosPuesta as $detenido){
                    $this->JuridicoM->updateBitJuridicoDetenido($detenido->Id_Detenido, 0);
                }
            }
            echo json_encode($data_p);
        }
    }

    public function changeBitDetenido()
    {
        if (!isset($_SESSION['userdata'])) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            $bit = $this->JuridicoM->updateBitJuridicoDetenido($_POST['id_detenido'],$_POST['modulo']);
            if($bit['status']){
                $data_p['status'] = true;
            }else{
                $data_p['status'] = false;
                $data_p['error_message'] = $bit['error_message'];
            }
            echo json_encode($data_p);
        }
    }

    public function createDictamen()
    {   
        if (!isset($_SESSION['userdata'])) {
            $response['status'] = false;
            $response['error_message'] = 'Render Index';
            echo json_encode($response);
        } else {
            $response = [
                'status' => false,
                'error_message' => ''
            ];
            if(isset($_POST['detenidos'])){
                $detenidos = json_decode($_POST['detenidos']);
                $band = true;
                foreach($detenidos as $key => $detenido){
                    $id_detenido = $detenido->id_detenido;
                    $id_puesta = $detenido->id_puesta;
                    $detenidoInfo = $this->JuridicoM->existeRegistroTabla('iph_detenido', ['Id_Detenido'], [$id_detenido]);
                    
                    if($detenidoInfo){
                        $primerRespondiente = $this->JuridicoM->existeRegistroTabla('iph_primer_respondiente', ['Id_Primer_Respondiente'], [$detenidoInfo->Id_Primer_Respondiente]);
                        $domicilioDetenido = $this->JuridicoM->existeRegistroTabla('domicilio', ['Id_Domicilio'], [$detenidoInfo->Id_Domicilio]);
                        $post['No_Detenido'] = 'IPH_'.$id_detenido;
                        $post['Nombre']     = $detenidoInfo->Nombre_D;
                        $post['Ap_Paterno'] = $detenidoInfo->Ap_Paterno_D;
                        $post['Ap_Materno'] = $detenidoInfo->Ap_Materno_D;
                        $post['Genero']     = $detenidoInfo->Genero;
                        $post['Edad']       = $detenidoInfo->Edad;
        
                        $post['Nombre_E']       = $primerRespondiente->Nombre_PR;
                        $post['Ap_Paterno_E']   = $primerRespondiente->Ap_Paterno_PR;
                        $post['Ap_Materno_E']   = $primerRespondiente->Ap_Materno_PR;
                        $post['Placa_E']        = '';
                        $post['Unidad_E']       = '';
                        $post['Sector_Area_E']  = $primerRespondiente->Institucion;
                        $post['Cargo_E']        = $primerRespondiente->Cargo;
                        $post['Domicilio']      =   $domicilioDetenido->Calle.' '.
                                                    $domicilioDetenido->No_Exterior.' '.
                                                    $domicilioDetenido->Colonia.' '.
                                                    $domicilioDetenido->Estado.' '.
                                                    $domicilioDetenido->Municipio;

                        $dictamen = $this->DictamenM->crearDictamenFromJuridico($post);
                        if ($dictamen['success']) {
                            $response['status'] = true;
                            $this->JuridicoM->updateBitJuridicoDetenido($detenido->id_detenido, 1);
                        }
                        else{
                            $response['error_message'] = $dictamen['error_message'];
                        }
                    }
                    else{
                        $response['error_message'] = 'No existe el detenido';
                    }
                    
                }
                
            }
            else{
                $response['error_message'] = 'Petición post inválida';
            }
            echo json_encode($response);
        }
        
    }

    public function insertUpdatePuesta()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['btn_iph'])) {

                $k = 0;
                $valid[$k++] = $data_p['fecha_puesta_error']                 = $this->FV->validate($_POST, 'fecha_puesta', 'required | date');
                $valid[$k++] = $data_p['nombre_identificacion_error']        = $this->FV->validate($_POST, 'nombre_identificacion', 'required | max_length[100]');
                $valid[$k++] = $data_p['apellido_p_identificacion_error']    = $this->FV->validate($_POST, 'apellido_p_identificacion', 'required | max_length[100]');
                $valid[$k++] = $data_p['apellido_m_identificacion_error']    = $this->FV->validate($_POST, 'apellido_m_identificacion', 'required | max_length[100]');
                $valid[$k++] = $data_p['grado_identificacion_error']         = $this->FV->validate($_POST, 'grado_identificacion', 'required | max_length[100]');
                $valid[$k++] = $data_p['narrativa_error']                    = $this->FV->validate($_POST, 'narrativa', 'required | max_length[16000000]');

                if ($_POST['institucion'] == 'Otro') $valid[$k++] = $data_p['cual_identificacion_error'] = $this->FV->validate($_POST, 'cual_identificacion', 'required | max_length[100]');
                if ($_POST['elementos']   == 'Si')   $valid[$k++] = $data_p['cuantos_identificacion_error'] = $this->FV->validate($_POST, 'cuantos_identificacion', 'required | max_length[100]');
                if ($_POST['priorizacion_lugar']   == 'Si') {
                    $valid[$k++] = $data_p['riesgo_presentado_error'] = $this->FV->validate($_POST, 'riesgo_presentado', 'required');
                    $valid[$k++] = $data_p['especifique_riesgo_error'] = $this->FV->validate($_POST, 'especifique_riesgo', 'required | max_length[100]');
                }

                $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;
                if ($success) {
                    $insertUpdatePuesta = $this->JuridicoM->insertUpdatePuesta($_POST);
                    if ($insertUpdatePuesta['status']) {
                        $data_p['status'] = true;
                        $user = $_SESSION['userdata']->Id_Usuario;
                        $ip = $this->obtenerIp();
                        $descripcion = 'Editar AnexoPrincipal, Puesta: ' . $_POST['id_puesta'];
                        $this->Remision->historial($user, $ip, 17, $descripcion);
                    } else {
                        $data_p['status'] = false;
                        $data_p['error_message'] = $insertUpdatePuesta['error_message'];
                    }
                } else {
                    $data_p['status'] = false;
                }

                echo json_encode($data_p);
            } else {
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';

                echo json_encode($data_p);
            }
        }
    }

    public function concluirPuesta(){
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['btn_conclu'])) {
                $concluir = $this->JuridicoM->concluirPuesta($_POST);
                if($concluir['status']){
                    $user = $_SESSION['userdata']->Id_Usuario;
                    $ip = $this->obtenerIp();
                    $descripcion = 'Concluyo puesta: ' . $_POST['id_puesta'];
                    $this->Remision->historial($user, $ip, 20, $descripcion);
                    $data_p['status'] = true;
                }else{
                    $data_p['status'] = false;
                    $data_p['error_message'] = $concluir['error_message'];
                }
                echo json_encode($data_p);
            }else{
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';

                echo json_encode($data_p);
            }
        }
    }

    public function uploadCroquis()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['btn_croquis'])) {
                $id_puesta = $_POST['id_puesta'];

                $date = date("Ymdhis");
                $name = $_FILES['file']['type'];
                $name = explode("/", $name);
                $name = 'croquis_' . $date . "." . $name[1];
                $path_carpeta = BASE_PATH . "public/files/Juridico/" . $id_puesta . "/croquis/";

                $insertCroquis = $this->JuridicoM->uploadCroquis($id_puesta, $name);
                if ($insertCroquis['status']) {
                    $clearFolder = $this->existContentFiles($path_carpeta);
                    if ($this->uploadImageFile('file', $_FILES, $path_carpeta, $name)) {
                        $data_p['status'] = true;
                        $data_p['nameFile'] = $name;
                        echo json_encode($data_p);
                    } else {
                        $data_p['status'] = false;
                        $data_p['error_message'] = 'Ocurrio un error con la carga de la imagen al servidor';
                        echo json_encode($data_p);
                    }
                } else {
                    $data_p['status'] = false;
                    $data_p['error_message'] = $insertCroquis['error_message'];
                    echo json_encode($data_p);
                }
            } else {
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';

                echo json_encode($data_p);
            }
        }
    }

    public function uploadDocComplementaria()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['btn_doc'])) {
                $data_p['status'] =  true;
                $user = $_SESSION['userdata']->Id_Usuario;
                $ip = $this->obtenerIp();
                $docCom = $this->JuridicoM->existeRegistroTabla('iph_documentacion_complementaria', ['Id_Puesta'], [$_POST['id_puesta']]);
                if(!$docCom){
                    $descripcion = 'Creo Documentación Complementaria, Puesta: ' . $_POST['id_puesta'];
                    $this->Remision->historial($user, $ip, 16, $descripcion);

                }else{
                    $descripcion = 'Editar Documentación Complementaria, Puesta: ' . $_POST['id_puesta'];
                    $this->Remision->historial($user, $ip, 17, $descripcion);
                }
                $docCom = $this->JuridicoM->uploadDocComplementaria($_POST);
                if($docCom['status']){
                    $data_p['status'] = true;
                }else{
                    $data_p['status'] = false;
                    $data_p['error_message'] = $docCom['error_message'];
                }
                echo json_encode($data_p);
            } else {
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';

                echo json_encode($data_p);
            }
        }
    }

    public function getPuesta()
    {
        $data = $this->JuridicoM->getPuesta($_POST['id_puesta']);
        echo json_encode($data);
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

    public function deleteCroquisFile()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if (isset($_POST['btn_croquis'])) {
                $id_puesta = $_POST['id_puesta'];
                $path_carpeta = BASE_PATH . "public/files/Juridico/" . $id_puesta . "/croquis/";

                $insertCroquis = $this->JuridicoM->uploadCroquis($id_puesta, '');
                if ($insertCroquis['status']) {
                    $this->existContentFiles($path_carpeta);
                    $data_p['status'] = true;
                    echo json_encode($data_p);
                } else {
                    $data_p['status'] = false;
                    $data_p['error_message'] = $insertCroquis['error_message'];
                    echo json_encode($data_p);
                }
            } else {
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';

                echo json_encode($data_p);
            }
        }
    }

    private function uploadImageFile($name, $file, $carpeta, $fileName)
    {
        $type = $file[$name]['type'];
        $extension = explode("/", $type);

        $imageUploadPath = $carpeta . $fileName;
        $allowed_mime_type_arr = array('jpeg', 'png', 'jpg', 'PNG', 'JPG');

        if (!file_exists($carpeta))
            mkdir($carpeta, 0777, true);

        if (in_array($extension[1], $allowed_mime_type_arr)) {
            move_uploaded_file($file[$name]['tmp_name'], $carpeta . $fileName);
            $band = true;
        } else {
            $band = false;
        }

        return $band;
    }


    public function getAnexosIndex($id_puesta)
    {
        $data['anexoA'] = $this->JuridicoM->getAnexosA($id_puesta);
        $data['anexoB'] = $this->JuridicoM->getAnexosB($id_puesta);
        $data['anexoC'] = $this->JuridicoM->getAnexosC($id_puesta);
        $data['anexoD'] = $this->JuridicoM->getAnexosD($id_puesta);
        $data['anexoE'] = $this->JuridicoM->getAnexosE($id_puesta);
        $data['anexoF'] = $this->JuridicoM->getAnexosF($id_puesta);
        $data['docs']   = $this->JuridicoM->getDocumentacionC($id_puesta);

        return $data;
    }

    public function generateBodyCollapseAnexo($anexo = null, $rows = [])
    {
        $bodyCollapse = '';

        switch ($anexo) {
            case 'A':
                foreach ($rows as $ind => $row) {
                    $bodyCollapse .= '
                        <div class="d-flex justify-content-between content-items-detenidos" id="A_'.$row->Id_Detenido.'">
                            <div>
                                <p class="mb-0">Detenido: <strong>' . mb_strtoupper(substr($row->Nombre_Detenido,0,23)) . '</strong></p>
                                <p class="mb-0">Fecha/Hora: <strong>' . mb_strtoupper(substr($row->Fecha_Hora,0,23)) . '</strong></p>
                                <p class="mb-0">Edad: <strong>' . mb_strtoupper(substr($row->Edad,0,23)) . '</strong></p>
                            </div>
                            <div>
                                <a class="mb-3 d-flex justify-content-center" href="' . base_url . 'Juridico/AnexoA?id_puesta=' . $row->Id_Puesta . '&id_detenido=' . $row->Id_Detenido . '" data-toggle="tooltip" data-placement="left" title="abrir registro">
                                    <i class="material-icons">app_registration</i>
                                </a>
                                <button type="button" class="mb-3 d-flex justify-content-center btn" data-toggle="tooltip" data-placement="left" title="borrar registro" onclick="borrarRegistro(\'A\','.$row->Id_Detenido.')">
                                    <i class="material-icons">delete</i>
                                </button>
                            </div>
                        </div>
                        <div class="dropdown-divider my-3" id="div_A_'.$row->Id_Detenido.'"></div>
                    ';
                }
                break;
            case 'B':
                foreach ($rows as $ind => $row) {
                    $bodyCollapse .= '
                        <div class="d-flex justify-content-between content-items-detenidos" id="B_'.$row->Id_Informe_Uso_Fuerza.'">
                            <div>
                                <p class="mb-0">Autoridades lesionadas: <strong>' . $row->Num_Lesionados_Autoridad . '</strong></p>
                                <p class="mb-0">Personas lesionados : <strong>' . $row->Num_Lesionados_Persona . '</strong></p>
                                <p class="mb-0">Autoridades fallecidas : <strong>' . $row->Num_Fallecidos_Autoridad . '</strong></p>
                                <p class="mb-0">Personas fallecidas : <strong>' . $row->Num_Fallecidos_Persona . '</strong></p>
                                
                            </div>
                            <div>
                                <a class="mb-3 d-flex justify-content-center" href="' . base_url . 'Juridico/AnexoB?id_puesta=' . $row->Id_Puesta . '&id_informe=' . $row->Id_Informe_Uso_Fuerza . '">
                                    <i class="material-icons">app_registration</i>
                                </a>
                                <button type="button" class="mb-3 d-flex justify-content-center btn" data-toggle="tooltip" data-placement="left" title="borrar registro" onclick="borrarRegistro(\'B\','.$row->Id_Informe_Uso_Fuerza.')">
                                    <i class="material-icons">delete</i>
                                </button>
                            </div>
                        </div>
                        <div class="dropdown-divider my-3" id="div_B_'.$row->Id_Informe_Uso_Fuerza.'"></div>
                    ';
                }
                break;
            case 'C':
                foreach ($rows as $ind => $row) {
                    $bodyCollapse .= '
                        <div class="d-flex justify-content-between content-items-detenidos" id="C_'.$row->Id_Inspeccion_Vehiculo.'">
                            <div>
                                <p class="mb-0">Marca: <strong>' . mb_strtoupper(substr($row->Marca,0,23)) . '</strong></p>
                                <p class="mb-0">Placa : <strong>' . mb_strtoupper(substr($row->Placa,0,23)) . '</strong></p>
                                <p class="mb-0">Fecha/Hora : <strong>' . mb_strtoupper(substr($row->Fecha_Hora,0,23)) . '</strong></p>
                                
                            </div>
                            <div>
                                <a class="mb-3 d-flex justify-content-center" href="' . base_url . 'Juridico/AnexoC/' . $row->Id_Puesta . '/' . $row->Id_Inspeccion_Vehiculo . '">
                                    <i class="material-icons">app_registration</i>
                                </a>
                                <button type="button" class="mb-3 d-flex justify-content-center btn" data-toggle="tooltip" data-placement="left" title="borrar registro" onclick="borrarRegistro(\'C\','.$row->Id_Inspeccion_Vehiculo.')">
                                    <i class="material-icons">delete</i>
                                </button>
                            </div>
                        </div>
                        <div class="dropdown-divider my-3" id="div_C_'.$row->Id_Inspeccion_Vehiculo.'"></div>
                    ';
                }
                break;
            case 'D1': //Armas
                foreach ($rows as $ind => $row) {
                    $bodyCollapse .= '
                        <div class="d-flex justify-content-between content-items-detenidos" id="D1_'.$row->Id_Inventario_Arma.'">
                            <div>
                                <p class="mb-0">Inspección: <strong>' . mb_strtoupper(substr($row->Inspeccion,0,23)) . '</strong></p>
                                <p class="mb-0">Tipo : <strong>' . mb_strtoupper(substr($row->Tipo_Arma,0,23)) . '</strong></p>
                                <p class="mb-0">Calibre : <strong>' . mb_strtoupper(substr($row->Calibre,0,23)) . '</strong></p>
                                
                            </div>
                            <div>
                                <a class="mb-3 d-flex justify-content-center" href="' . base_url . 'Juridico/AnexoD/arma/' . $row->Id_Puesta . '/'.$row->Id_Inventario_Arma.'">
                                    <i class="material-icons">app_registration</i>
                                </a>
                                <button type="button" class="mb-3 d-flex justify-content-center btn" data-toggle="tooltip" data-placement="left" title="borrar registro" onclick="borrarRegistro(\'D1\','.$row->Id_Inventario_Arma.')">
                                    <i class="material-icons">delete</i>
                                </button>
                            </div>
                        </div>
                        <div class="dropdown-divider my-3" id="div_D1_'.$row->Id_Inventario_Arma.'"></div>
                    ';
                }
                break;
            case 'D2': //Objetos
                foreach ($rows as $ind => $row) {
                    $bodyCollapse .= '
                        <div class="d-flex justify-content-between content-items-detenidos" id="D2_'.$row->Id_Inventario_Objetos.'">
                            <div>
                                <p class="mb-0">Apariencia: <strong>' . mb_strtoupper(substr($row->Apariencia,0,23)) . '</strong></p>
                                <p class="mb-0">Inspección : <strong>' . mb_strtoupper(substr($row->Inspeccion,0,23)) . '</strong></p>
                            </div>
                            <div>
                                <a class="mb-3 d-flex justify-content-center" href="' . base_url . 'Juridico/AnexoD/objeto/' . $row->Id_Puesta . '/'.$row->Id_Inventario_Objetos.'">
                                    <i class="material-icons">app_registration</i>
                                </a>
                                <button type="button" class="mb-3 d-flex justify-content-center btn" data-toggle="tooltip" data-placement="left" title="borrar registro" onclick="borrarRegistro(\'D2\','.$row->Id_Inventario_Objetos.')">
                                    <i class="material-icons">delete</i>
                                </button>
                            </div>
                        </div>
                        <div class="dropdown-divider my-3" id="div_D2_'.$row->Id_Inventario_Objetos.'"></div>
                    ';
                }
                break;
            case 'E':
                foreach ($rows as $ind => $row) {
                    $bodyCollapse .= '
                        <div class="d-flex justify-content-between content-items-detenidos" id="E_'.$row->Id_Entrevista.'">
                            <div>
                                <p class="mb-0">Entrevistado(a): <strong>' . mb_strtoupper(substr($row->Nombre_Entrevistado,0,23)) . '</strong></p>
                                <p class="mb-0">Fecha/Hora : <strong>' . $row->Fecha_Hora . '</strong></p>
                                <p class="mb-0">Calidad : <strong>' . mb_strtoupper(substr($row->Calidad,0,23)) . '</strong></p>
                                
                            </div>
                            <div>
                                <a class="mb-3 d-flex justify-content-center" href="' . base_url . 'Juridico/AnexoE?id_puesta=' . $row->Id_Puesta . '&id_entrevista=' . $row->Id_Entrevista . '">
                                    <i class="material-icons">app_registration</i>
                                </a>
                                <button type="button" class="mb-3 d-flex justify-content-center btn" data-toggle="tooltip" data-placement="left" title="borrar registro" onclick="borrarRegistro(\'E\','.$row->Id_Entrevista.')">
                                    <i class="material-icons">delete</i>
                                </button>
                            </div>
                        </div>
                        <div class="dropdown-divider my-3" id="div_E_'.$row->Id_Entrevista.'"></div>
                    ';
                }
                break;
            case 'F':
                foreach ($rows as $ind => $row) {
                    $bodyCollapse .= '
                        <div class="d-flex justify-content-between content-items-detenidos" id="F_'.$row->Id_Entrega_Recepcion_Lugar.'">
                            <div>
                                <p class="mb-0">Motivo: <strong>' . mb_strtoupper(substr($row->Motivo_Ingreso,0,23)) . '</strong></p>
                                <p class="mb-0">Fecha/Hora recepcion: <strong>' . $row->Fecha_Hora_Recepcion . '</strong></p>
                                
                            </div>
                            <div>
                                <a class="mb-3 d-flex justify-content-center" href="' . base_url . 'Juridico/AnexoF/' . $row->Id_Puesta . '/' . $row->Id_Entrega_Recepcion_Lugar . '">
                                    <i class="material-icons">app_registration</i>
                                </a>
                                <button type="button" class="mb-3 d-flex justify-content-center btn" data-toggle="tooltip" data-placement="left" title="borrar registro" onclick="borrarRegistro(\'F\','.$row->Id_Entrega_Recepcion_Lugar.')">
                                    <i class="material-icons">delete</i>
                                </button>
                            </div>
                        </div>
                        <div class="dropdown-divider my-3" id="div_F_'.$row->Id_Entrega_Recepcion_Lugar.'"></div>
                    ';
                }
                break;
        }

        return $bodyCollapse;
    }

    public function generateIPH($id_puesta)
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            $data = [
                'data_puesta' => $this->JuridicoM->getPuesta($id_puesta),
                'AnexosA'     => $this->JuridicoM->getAnexosAforPDF($id_puesta),
                'AnexosB'     => $this->JuridicoM->getAnexosBforPDF($id_puesta),
                'AnexosC'     => $this->JuridicoM->getAnexosCforPDF($id_puesta),
                'AnexosD'     => $this->JuridicoM->getAnexosDforPDF($id_puesta),
                'AnexosE'     => $this->JuridicoM->getAnexosEforPDF($id_puesta),
                'AnexosF'     => $this->JuridicoM->getAnexosFforPDF($id_puesta)
            ];

            $this->view('system/Juridico/generarPDF', $data);
        }
    }

    public function uploadFileCompare()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if(isset($_POST['data_save'])){
                $date = date("Ymdhis");
                $target_dir = BASE_PATH."public/files/Juridico/Docs/";
                if (!file_exists($target_dir))
                    mkdir($target_dir, 0777, true);
                $file = $_FILES['file']['name'];
                $path = pathinfo($file);
                $filename = 'File_'.$date;
                $ext = $path['extension'];
                $temp_name = $_FILES['file']['tmp_name'];
                $path_filename_ext = $target_dir.$filename.".".$ext;
                move_uploaded_file($temp_name,$path_filename_ext);
                $data_p['status'] = true;
                $data_p['file_name'] = $filename.'.'.$ext;
                echo json_encode($data_p);
            }else {
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';
                echo json_encode($data_p);
            }
        }
    }

    public function removeFileCompare()
    {
        if(file_exists(BASE_PATH."public/files/Juridico/Docs/".$_POST['name_file'])){
            unlink(BASE_PATH."public/files/Juridico/Docs/".$_POST['name_file']);
        }
        echo json_encode(true);
    }

    public function compareDocx()
    {
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Juridico[3] != '1')) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            if(isset($_POST['data_save'])){
                $path = BASE_PATH."public/files/Juridico/Docs/";
                $primerDoc = $this->convertToText($path.$_POST['primer_file']);
                $segundoDoc = $this->convertToText($path.$_POST['segundo_file']);
                if($primerDoc == $segundoDoc){
                    $this->existContentFiles($path);
                    echo json_encode(true);
                }else{
                    $this->existContentFiles($path);
                    echo json_encode(false);
                }
            }else {
                $data_p['status'] = false;
                $data_p['error_message'] = 'Petición mal realizada, favor de verificar campos.';
                echo json_encode($data_p);
            }
        }
    }

    private function read_doc() {
        $fileHandle = fopen($this->filename, "r");
        $line = @fread($fileHandle, filesize($this->filename));   
        $lines = explode(chr(0x0D),$line);
        $outtext = "";
        foreach($lines as $thisline)
            {
            $pos = strpos($thisline, chr(0x00));
            if (($pos !== FALSE)||(strlen($thisline)==0))
                {
                } else {
                $outtext .= $thisline." ";
                }
            }
            $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
        return $outtext;
    }

    private function read_docx($filename){

        $striped_content = '';
        $content = '';

        $zip = zip_open($filename);

        if (!$zip || is_numeric($zip)) return false;

        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

            if (zip_entry_name($zip_entry) != "word/document.xml") continue;

            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
        }

        zip_close($zip);

        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $striped_content = strip_tags($content);

        return $striped_content;
    }

    private function convertToText($filename) {

        if(isset($filename) && !file_exists($filename)) {
            return "File Not exists";
        }

        
        $fileArray = pathinfo($filename);
        $file_ext  = $fileArray['extension'];
        if($file_ext == "doc" || $file_ext == "docx")
        {
            if($file_ext == "doc") {
                return $this->read_doc($filename);
            } elseif($file_ext == "docx") {
                return $this->read_docx($filename);
            }
        } else {
            return "Invalid File Type";
        }
    }

    private function obtenerIp()
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

    public function getDetenidosJuridico()
    {
        if (!isset($_SESSION['userdata'])) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';
            echo json_encode($data_p);
        } else {
            $detenidos = $this->JuridicoM->getDetenidosJuridico($_POST['modulo']);
            if($detenidos['status']){
                $data_p['status'] = true;
                $data_p['data'] = $detenidos;
            }else{
                $data_p['status'] = false;
                $data_p['error_message'] = $detenidos['error_message'];
            }
            echo json_encode($data_p);
        }
    }

    // Borrar anexo X por id del registro
    public function deleteAnexo(){
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || $_SESSION['userdata']->Juridico[3] != '1') {
            $data['resp_case'] = 'error_session';
            $data['error_message'] = 'La sesión caducó. Vuelva a iniciar sesión.';
        }
        else{
            
            //set rules
            $k = 0;
            //numero y fecha/hora detención
            $valid[$k++] = $data['error1'] = $this->FV->validate($_POST, 'Anexo', 'required | max_length[2]');
            $valid[$k++] = $data['error2'] = $this->FV->validate($_POST, 'Id_Registro', 'required | numeric');
            
            $success = true;
                foreach ($valid as $val)
                    $success &= ($val == '') ? true : false;
            if($success){
                $resp = $this->JuridicoM->deleteAnexoChangeStatus($_POST['Anexo'],$_POST['Id_Registro']);
                if($resp['success']){
                    $data['resp_case'] = 'success';
                }
                else{
                    $data['resp_case'] = 'error_interno';
                    $data['error_message'] = 'Error en la DB: '.$success['error_message'];
                }
            }
            else{
                $data['resp_case'] = 'error_interno';
                $data['error_message'] = 'Error en la petición';
            }
        }

        echo json_encode($data);

    }
}
