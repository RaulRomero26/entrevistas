<?php
    /**
     Filtros
     1 - Vista general con remisiones
     2 - Pendientes
     3 - Completados jurídico
     4 - Otros
    */
class DictamenMedico extends Controller{
    public $DictamenM;    //model
    public $numColumnsDM; //número de columnas por cada filtro
    public $FV;// mi formValidator

    public function __construct(){
        $this->DictamenM = $this->model('DictamenM');   //se instancia model Historial y ya puede ser ocupado en el controlador
        $this->numColumnsDM = [9,9,9,9];  //se inicializa el número de columns por cada filtro
        $this->FV = new FormValidator(); //instancia de formValidator
    }
    //vista general de todos los dictámenes hechos y no hechos
    public function index(){

        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Dictamen_M[2] != '1')) {
            header("Location: ".base_url."Inicio");
            exit();
        }

        //Titulo de la pagina y archivos css y js necesarios
        $data = [
            'titulo'    => 'Planeación | Dictamen médico',
            'extra_css' => '<link rel="stylesheet" href="'. base_url . 'public/css/system/dictamenM/index.css">',
            'extra_js'  => '<script src="'. base_url . 'public/js/system/dictamenM/index.js"></script>
                            <script src="' . base_url . 'public/js/system/juridico/consumoDetenidosJuridico.js"></script>'
        ];

        //PROCESO DE FILTRADO DE EVENTOS DELICTIVOS

        if (isset($_GET['filtro']) && is_numeric($_GET['filtro']) && $_GET['filtro']>=MIN_FILTRO_DM && $_GET['filtro']<=MAX_FILTRO_DM) { //numero de catálogo
            $filtro = $_GET['filtro'];
        } 
        else {
            $filtro = 1;
        }

        //PROCESAMIENTO DE LAS COLUMNAS 
        $this->setColumnsSession($filtro);
        $data['columns_DM'] = $_SESSION['userdata']->columns_DM;

        //PROCESAMIENTO DE RANGO DE FOLIOS
        if (isset($_POST['rango_inicio']) && isset($_POST['rango_fin']) && isset($_POST['rango_hora_inicio']) && isset($_POST['rango_hora_fin'])) {
            $_SESSION['userdata']->rango_inicio_dm = $_POST['rango_inicio'];
            $_SESSION['userdata']->rango_fin_dm = $_POST['rango_fin'];
            $_SESSION['userdata']->rango_hora_inicio_dm = $_POST['rango_hora_inicio'];
            $_SESSION['userdata']->rango_hora_fin_dm = $_POST['rango_hora_fin'];
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

        $where_sentence = $this->DictamenM->generateFromWhereSentence($cadena,$filtro);
        $extra_cad = ($cadena != "")?("&cadena=".$cadena):""; //para links conforme a búsqueda

        $no_of_records_per_page = NUM_MAX_REG_PAGE; //total de registros por pagination
        $offset = ($numPage-1) * $no_of_records_per_page; // desplazamiento conforme a la pagina

        $results_rows_pages = $this->DictamenM->getTotalPages($no_of_records_per_page,$where_sentence);   //total de páginas de acuerdo a la info de la DB
        $total_pages = $results_rows_pages['total_pages'];

        if ($numPage>$total_pages) {$numPage = 1; $offset = ($numPage-1) * $no_of_records_per_page;} //seguridad si ocurre un error por url     
        
        $rows_Eventos = $this->DictamenM->getDataCurrentPage($offset,$no_of_records_per_page,$where_sentence);    //se obtiene la información de la página actual

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
            case '1': $data['filtroNombre'] = "Todos"; break;
            case '2': $data['filtroNombre'] = "Pendientes"; break;
            case '3': $data['filtroNombre'] = "Completados"; break;
            case '4': $data['filtroNombre'] = "Otros"; break;
        }

        $this->view("templates/header",$data);
        $this->view("system/dictamenM/dictamenMView",$data);
        $this->view("templates/footer",$data);
    }

    //formulario de primer dictamen médico
    public function nuevoDictamen(){
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Dictamen_M[3] != '1')) {
            header("Location: ".base_url."Inicio");
            exit();
        }
        //Titulo de la pagina y archivos css y js necesarios
        $data = [
            'titulo'    => 'Planeación | Dic Med nuevo',
            'extra_css' => '<link rel="stylesheet" href="'. base_url . 'public/css/system/dictamenM/nuevo.css">',
            'extra_js'  => '<script src="'. base_url . 'public/js/system/dictamenM/nuevo.js"></script>
                            <script src="'. base_url . 'public/js/system/dictamenM/validacionesForm.js"></script>
                            <script src="'. base_url . 'public/js/system/dictamenM/elementos.js"></script>'
        ];

        //validación get del parámetro pasado por GET
        $band1 = $this->FV->validate($_GET,'id_dictamen','required | numeric');
        if ($band1 != '') {
            $_GET['id_dictamen'] = -1;
        }
        //si la validación es correcta se trata de recuperar la info de la remisión
        $data['info_remision'] = $this->DictamenM->getInfoRemisionForDictamen($_GET['id_dictamen']);

        $this->view("templates/header",$data);
        $this->view("system/dictamenM/nuevoDictamenMView",$data);
        $this->view("templates/footer",$data); 
    }
    //vista principal para mostrar formulario del detenido en cuestión
    public function editarDictamen(){
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Dictamen_M[1] != '1')) {
            header("Location: ".base_url."Inicio");
            exit();
        }
        //Titulo de la pagina y archivos css y js necesarios
        $data = [
            'titulo'    => 'Planeación | Dic Med editar',
            'extra_css' => '<link rel="stylesheet" href="'. base_url . 'public/css/system/dictamenM/nuevo.css">',
            'extra_js'  => '<script src="'. base_url . 'public/js/system/dictamenM/nuevo.js"></script>
                            <script src="'. base_url . 'public/js/system/dictamenM/validacionesForm.js"></script>
                            <script src="'. base_url . 'public/js/system/dictamenM/elementos.js"></script>'
        ];

        //validación get del parámetro pasado por GET
        $band1 = $this->FV->validate($_GET,'id_dictamen','required | numeric');
        if ($band1 != '') {
            header("Location: ".base_url."Inicio");
            exit();
        }
        //si la validación es correcta se trata de recuperar la info de la remisión
        $data['info_remision'] = $this->DictamenM->getInfoRemisionForDictamen($_GET['id_dictamen']);
        if(!$data['info_remision']){
            header("Location: ".base_url."Inicio");
            exit();
        }
        $this->view("templates/header",$data);
        $this->view("system/dictamenM/editarDictamenMView",$data);
        $this->view("templates/footer",$data);  
    }
    // para el caso donde no interviene Jurídico
    public function insertOtroFetch(){ 
        try{
            //comprobar los permisos para dejar pasar al módulo
            if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Dictamen_M[3] != '1')) {
                $data['resp_case'] = 'error_session';
                $data['error_message'] = 'La sesión caducó. Vuelva a iniciar sesión.';
            }
            else if(isset($_POST['Diagnostico'])){
                //se asignan los checks que se hayan seleccionado (No obligatorios)
                $_POST['IE']     = $this->generateCheckBoxPost($_POST,1);    //intoxicación etílica
                $_POST['Orient'] = $this->generateCheckBoxPost($_POST,2);    //Orientación
                $_POST['SustanciaC'] = $this->generateCheckBoxPost($_POST,3);//sustancia consumida
                $_POST['Aliento_A'] = $this->generateCheckBoxPost($_POST,4);//aliento
                $_POST['Lenguaje_Bit'] = $this->generateCheckBoxPost($_POST,5);//lenguaje
                $k = 0;

                //validando la información del formulario
                //detenido
                $valid[$k++] = $data['error_nombre']    = $this->FV->validate($_POST,'Nombre', 'required | max_length[100]');
                $valid[$k++] = $data['error_ap_pat']    = $this->FV->validate($_POST,'Ap_Paterno', 'required | max_length[100]');
                $valid[$k++] = $data['error_ap_mat']    = $this->FV->validate($_POST,'Ap_Materno', 'required | max_length[100]');
                $valid[$k++] = $data['error_edad']      = $this->FV->validate($_POST,'Edad', 'required | numeric');
                $valid[$k++] = $data['error_ocupacion'] = $this->FV->validate($_POST,'Ocupacion', 'required | max_length[250]');
                $valid[$k++] = $data['error_domicilio'] = $this->FV->validate($_POST,'Domicilio', 'required | max_length[650]');
                $valid[$k++] = $data['error_genero']    = $this->FV->validate($_POST,'Genero', 'required | length[1]');
                    //elemento
                $valid[$k++] = $data['error_nombre_e']      = $this->FV->validate($_POST,'Nombre_E', 'required | max_length[450]');
                $valid[$k++] = $data['error_ap_paterno_e']  = $this->FV->validate($_POST,'Ap_Paterno_E', 'required | max_length[450]');
                $valid[$k++] = $data['error_ap_materno_e']  = $this->FV->validate($_POST,'Ap_Materno_E', 'required | max_length[450]');
                $valid[$k++] = $data['error_placa_e']       = $this->FV->validate($_POST,'Placa_E', 'max_length[45]');
                $valid[$k++] = $data['error_cargo_e']       = $this->FV->validate($_POST,'Cargo_E', 'required | max_length[350]');
                $valid[$k++] = $data['error_sector_e']      = $this->FV->validate($_POST,'Sector_Area_E', 'required | max_length[250]');
                $valid[$k++] = $data['error_unidad_e']      = $this->FV->validate($_POST,'Unidad_E', 'required | max_length[100]');
                    //dictamen form
                $valid[$k++] = $data['error_fecha_dictamen']    = $this->FV->validate($_POST,'Fecha_Dictamen', 'required | date');
                $valid[$k++] = $data['error_hora_dictamen']     = $this->FV->validate($_POST,'Hora_Dictamen', 'required | time');
                $valid[$k++] = $data['error_instancia']         = $this->FV->validate($_POST,'Instancia', 'required');

                $valid[$k++] = $data['error_padece_si_no']  = $this->FV->validate($_POST,'Padece_Si_No', 'required');
                $valid[$k++] = $data['error_medic_si_no']   = $this->FV->validate($_POST,'Medic_Si_No', 'required');

                if ($_POST['Padece_Si_No'] == '1')
                    $valid[$k++] = $data['error_enfermedades_padece'] = $this->FV->validate($_POST,'Enfermedades_Padece', 'required');

                if ($_POST['Medic_Si_No'] == '1')
                    $valid[$k++] = $data['error_toma_medicamentos'] = $this->FV->validate($_POST,'Medicamentos_Toma', 'required');

                $valid[$k++] = $data['error_pruebas_1']     = $this->FV->validate($_POST,'Prueba_Alcoholimetro', 'required');
                $valid[$k++] = $data['error_pruebas_2']     = $this->FV->validate($_POST,'Prueba_Multitestdrog', 'required');
                $valid[$k++] = $data['error_pruebas_3']     = $this->FV->validate($_POST,'Prueba_Clinica', 'required');

                $valid[$k++] = $data['error_coopera']       = $this->FV->validate($_POST,'Coopera_Interrogatorio', 'required');
                $valid[$k++] = $data['error_consumio']      = $this->FV->validate($_POST,'Consumio_Si_No', 'required');

                if ($_POST['Consumio_Si_No'] == '1') {
                    $valid[$k++] = $data['error_sustancia']         = $this->FV->validate($_POST,'Sustancia_Consumida', 'required');
                    $valid[$k++] = $data['error_fecha_consumo']     = $this->FV->validate($_POST,'Fecha_Consumo', 'max_length[10]');
                    $valid[$k++] = $data['error_hora_consumo']      = $this->FV->validate($_POST,'Hora_Consumo', 'max_length[5]');
                    $valid[$k++] = $data['error_cantidad_consumo']  = $this->FV->validate($_POST,'Cantidad_Consumida', 'max_length[500]');
                }

                $valid[$k++] = $data['error_edo_cons']          = $this->FV->validate($_POST,'Estado_Conciencia', 'required');
                $valid[$k++] = $data['error_actitud']           = $this->FV->validate($_POST,'Actitud', 'required');
                $valid[$k++] = $data['error_lenguaje']          = $this->FV->validate($_POST,'Lenguaje', 'required');
                $valid[$k++] = $data['error_fascies']           = $this->FV->validate($_POST,'Fascies', 'required');
                $valid[$k++] = $data['error_conjuntivas']       = $this->FV->validate($_POST,'Conjuntivas', 'required');
                $valid[$k++] = $data['error_pupilas']           = $this->FV->validate($_POST,'Pupilas', 'required');
                $valid[$k++] = $data['error_pupilas2']          = $this->FV->validate($_POST,'Pupilas2', 'required');
                $valid[$k++] = $data['error_mucosa_oral']       = $this->FV->validate($_POST,'Mucosa_Oral', 'required');
                $valid[$k++] = $data['error_heridas_lesiones']  = $this->FV->validate($_POST,'Heridas_Lesiones', 'max_length[500]');
                $valid[$k++] = $data['error_observaciones']     = $this->FV->validate($_POST,'Observaciones', 'max_length[500]');
                $valid[$k++] = $data['error_diagnostico']       = $this->FV->validate($_POST,'Diagnostico', 'required');

                $success = true;
                foreach ($valid as $val) 
                    $success &= ($val=='')?true:false;
                
                if ($success) { //se trata de actualizar el dictamen con toda la info mandada
                    $success2 = $this->DictamenM->insertDictamen($_POST);
                    if ($success2['success']) {
                        $data['resp_case'] = 'success';
                        $data['success'] = true;
                    }
                    else{
                        $data['resp_case'] = 'error_db';
                        $data['error_message'] = 'Parece que ocurrió un problema en la base de datos. Mensaje: '.$success2['error_message'];
                    }
                }
                else{ //error en el formulario
                    $data['resp_case'] = 'error_form';
                    $data['error_message'] = 'Error en el formulario, compruebe que toda la información este llenada correctamente y que ningun campo requerido haga falta.';
                }
            }
            else{// error en la petición
                $data['resp_case'] = 'error_post';
                $data['error_message'] = 'Error en la petición de la función (mal formada)';
            }
        }catch(Exception $err){
            $data['resp_case'] = 'error_interno';
            $data['error_message'] = 'Error interno: '.$err;
        }
        
        //se retorna la respuesta final
        echo json_encode($data);
    }
    // se actualiza el dictamen 2 casos: se actualiza como nuevo (caso desde jurídico se crea el folio) o se actualiza uno previamente llenado (comparten la misma función)
    public function actualizaFetch(){
        try{
            //comprobar los permisos para dejar pasar al módulo
            if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin!=1 && $_SESSION['userdata']->Dictamen_M[3] != '1')) {
                $data['resp_case'] = 'error_session';
                $data['error_message'] = 'La sesión caducó. Vuelva a iniciar sesión.';
            }
            else if(isset($_POST['Diagnostico'])){
                //se asignan los checks que se hayan seleccionado (No obligatorios)
                $_POST['IE']     = $this->generateCheckBoxPost($_POST,1);    //intoxicación etílica
                $_POST['Orient'] = $this->generateCheckBoxPost($_POST,2);    //Orientación
                $_POST['SustanciaC'] = $this->generateCheckBoxPost($_POST,3);//sustancia consumida
                $_POST['Aliento_A'] = $this->generateCheckBoxPost($_POST,4);//aliento
                $_POST['Lenguaje_Bit'] = $this->generateCheckBoxPost($_POST,5);//lenguaje
                $k = 0;

                //validando la información del formulario
                //detenido
                // $valid[$k++] = $data['error_id_usuario']    = $this->FV->validate($_POST,'Id_Usuario', 'required | numeric');
                // $valid[$k++] = $data['error_id_dictamen']   = $this->FV->validate($_POST,'Id_Dictamen', 'required | numeric');
                $valid[$k++] = $data['error_nombre']    = $this->FV->validate($_POST,'Nombre', 'required | max_length[100]');
                $valid[$k++] = $data['error_ap_pat']    = $this->FV->validate($_POST,'Ap_Paterno', 'required | max_length[100]');
                $valid[$k++] = $data['error_ap_mat']    = $this->FV->validate($_POST,'Ap_Materno', 'required | max_length[100]');
                $valid[$k++] = $data['error_edad']      = $this->FV->validate($_POST,'Edad', 'required | numeric');
                $valid[$k++] = $data['error_ocupacion'] = $this->FV->validate($_POST,'Ocupacion', 'required | max_length[250]');
                $valid[$k++] = $data['error_domicilio'] = $this->FV->validate($_POST,'Domicilio', 'required | max_length[650]');
                $valid[$k++] = $data['error_genero']    = $this->FV->validate($_POST,'Genero', 'required | length[1]');
                    //elemento
                $valid[$k++] = $data['error_nombre_e']      = $this->FV->validate($_POST,'Nombre_E', 'required | max_length[450]');
                $valid[$k++] = $data['error_ap_paterno_e']  = $this->FV->validate($_POST,'Ap_Paterno_E', 'required | max_length[450]');
                $valid[$k++] = $data['error_ap_materno_e']  = $this->FV->validate($_POST,'Ap_Materno_E', 'required | max_length[450]');
                $valid[$k++] = $data['error_placa_e']       = $this->FV->validate($_POST,'Placa_E', 'max_length[45]');
                $valid[$k++] = $data['error_cargo_e']       = $this->FV->validate($_POST,'Cargo_E', 'required | max_length[350]');
                $valid[$k++] = $data['error_sector_e']      = $this->FV->validate($_POST,'Sector_Area_E', 'required | max_length[250]');
                $valid[$k++] = $data['error_unidad_e']      = $this->FV->validate($_POST,'Unidad_E', 'required | max_length[100]');
                    //dictamen form
                $valid[$k++] = $data['error_fecha_dictamen']    = $this->FV->validate($_POST,'Fecha_Dictamen', 'required | date');
                $valid[$k++] = $data['error_hora_dictamen']     = $this->FV->validate($_POST,'Hora_Dictamen', 'required | time');
                $valid[$k++] = $data['error_instancia']         = $this->FV->validate($_POST,'Instancia', 'required');

                $valid[$k++] = $data['error_padece_si_no']  = $this->FV->validate($_POST,'Padece_Si_No', 'required');
                $valid[$k++] = $data['error_medic_si_no']   = $this->FV->validate($_POST,'Medic_Si_No', 'required');

                if ($_POST['Padece_Si_No'] == '1')
                    $valid[$k++] = $data['error_enfermedades_padece'] = $this->FV->validate($_POST,'Enfermedades_Padece', 'required');

                if ($_POST['Medic_Si_No'] == '1')
                    $valid[$k++] = $data['error_toma_medicamentos'] = $this->FV->validate($_POST,'Medicamentos_Toma', 'required');

                $valid[$k++] = $data['error_pruebas_1']     = $this->FV->validate($_POST,'Prueba_Alcoholimetro', 'required');
                $valid[$k++] = $data['error_pruebas_2']     = $this->FV->validate($_POST,'Prueba_Multitestdrog', 'required');
                $valid[$k++] = $data['error_pruebas_3']     = $this->FV->validate($_POST,'Prueba_Clinica', 'required');

                $valid[$k++] = $data['error_coopera']       = $this->FV->validate($_POST,'Coopera_Interrogatorio', 'required');
                $valid[$k++] = $data['error_consumio']      = $this->FV->validate($_POST,'Consumio_Si_No', 'required');

                if ($_POST['Consumio_Si_No'] == '1') {
                    $valid[$k++] = $data['error_sustancia']         = $this->FV->validate($_POST,'Sustancia_Consumida', 'required');
                    $valid[$k++] = $data['error_fecha_consumo']     = $this->FV->validate($_POST,'Fecha_Consumo', 'max_length[10]');
                    $valid[$k++] = $data['error_hora_consumo']      = $this->FV->validate($_POST,'Hora_Consumo', 'max_length[5]');
                    $valid[$k++] = $data['error_cantidad_consumo']  = $this->FV->validate($_POST,'Cantidad_Consumida', 'max_length[500]');
                }

                $valid[$k++] = $data['error_edo_cons']          = $this->FV->validate($_POST,'Estado_Conciencia', 'required');
                $valid[$k++] = $data['error_actitud']           = $this->FV->validate($_POST,'Actitud', 'required');
                $valid[$k++] = $data['error_lenguaje']          = $this->FV->validate($_POST,'Lenguaje', 'required');
                $valid[$k++] = $data['error_fascies']           = $this->FV->validate($_POST,'Fascies', 'required');
                $valid[$k++] = $data['error_conjuntivas']       = $this->FV->validate($_POST,'Conjuntivas', 'required');
                $valid[$k++] = $data['error_pupilas']           = $this->FV->validate($_POST,'Pupilas', 'required');
                $valid[$k++] = $data['error_pupilas2']          = $this->FV->validate($_POST,'Pupilas2', 'required');
                $valid[$k++] = $data['error_mucosa_oral']       = $this->FV->validate($_POST,'Mucosa_Oral', 'required');
                $valid[$k++] = $data['error_heridas_lesiones']  = $this->FV->validate($_POST,'Heridas_Lesiones', 'max_length[500]');
                $valid[$k++] = $data['error_observaciones']     = $this->FV->validate($_POST,'Observaciones', 'max_length[500]');
                $valid[$k++] = $data['error_diagnostico']       = $this->FV->validate($_POST,'Diagnostico', 'required');

                $success = true;
                foreach ($valid as $val) 
                    $success &= ($val=='')?true:false;
                
                if ($success) { //se trata de actualizar el dictamen con toda la info mandada
                    $success2 = $this->DictamenM->updateDictamen($_POST);
                    if ($success2['success']) {
                        $data['resp_case'] = 'success';
                        $data['success'] = true;
                    }
                    else{
                        $data['resp_case'] = 'error_db';
                        $data['error_message'] = 'Parece que ocurrió un problema en la base de datos. Mensaje: '.$success2['error_message'];
                    }
                }
                else{ //error en el formulario
                    $data['resp_case'] = 'error_form';
                    $data['error_message'] = 'Error en el formulario, compruebe que toda la información este llenada correctamente y que ningun campo requerido haga falta.';
                }
            }
            else{// error en la petición
                $data['resp_case'] = 'error_post';
                $data['error_message'] = 'Error en la petición de la función (mal formada)';
            }
        }catch(Exception $err){
            $data['resp_case'] = 'error_interno';
            $data['error_message'] = 'Error interno: '.$err;
        }
        
        //se retorna la respuesta final
        echo json_encode($data);
    }
    //Ver un dictamen elegido
    public function verDictamen(){
        //seguridad de permsios
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != '1'  && $_SESSION['userdata']->Dictamen_M[2] != '1')) {
            header("Location: ".base_url."Inicio");
            exit();
        }

        //Titulo de la pagina y archivos css y js necesarios
        $data = [
            'titulo'    => 'Planeación | Ver dictamen',
            'extra_css' => '<link rel="stylesheet" href="'. base_url . 'public/css/system/dictamenM/verDictamen.css">',
            'extra_js'  => '<script src="'. base_url . 'public/js/system/dictamenM/verDictamen.js"></script>'
        ];

        //validación get del parámetro pasado por GET
        $band1 = $this->FV->validate($_GET,'id_dictamen','required | numeric');
        if ($band1 != '') {
            header("Location: ".base_url."Inicio");
            exit();
        }
        //si la validación es correcta se trata de recuperar la info de la remisión
        $band2 = $data['info_dictamen'] = $this->DictamenM->getInfoRemisionForDictamen($_GET['id_dictamen']);

        if (!$band2) {
            header("Location: ".base_url."UsersAdmin");
            exit();
        }
        //formatear fecha y Hora
        // $auxFechaHora1 = $this->formatearFechaHora($data['info_dictamen']->Fecha_Hora);
        // $auxFechaHora2 = $this->formatearFechaHora($data['info_dictamen']->Fecha_Hora_Consumo);
        // $auxFechaHora3 = $this->formatearFechaHora($data['info_dictamen']->Fecha_Registro_Dictamen);
        // $data['info_dictamen']->Fecha1  = $auxFechaHora1['Fecha'];  //fecha header
        // $data['info_dictamen']->Hora1   = $auxFechaHora1['Hora'];   //hora header
        // $data['info_dictamen']->Fecha2  = $auxFechaHora2['Fecha'];  //fecha consumo
        // $data['info_dictamen']->Hora2   = $auxFechaHora2['Hora'];   //hora consumo
        // $data['info_dictamen']->Fecha3  = $auxFechaHora3['Fecha'];  //fecha registro
        // $data['info_dictamen']->Hora3   = $auxFechaHora3['Hora'];   //hora registro
        $auxFechaHora1 = explode(" ",$data['info_dictamen']->Fecha_Hora);
        $auxFecha1 = explode("-",$auxFechaHora1[0]);
        $auxFecha1 = $auxFecha1[2]."/".$auxFecha1[1]."/".$auxFecha1[0];
        // $auxFechaHora2 = explode(" ",$data['info_dictamen']->Fecha_Hora_Consumo);
        // $auxFecha2 = explode("-",$auxFechaHora2[0]);
        // $auxFecha2 = $auxFecha2[2]."/".$auxFecha2[1]."/".$auxFecha2[0];
        $auxFechaHora3 = $this->formatearFechaHora($data['info_dictamen']->Fecha_Registro_Dictamen);
        $data['info_dictamen']->Fecha1  = $auxFecha1;  //fecha header
        $data['info_dictamen']->Hora1   = $auxFechaHora1[1];   //hora header
        // $data['info_dictamen']->Fecha2  = $auxFecha2;  //fecha consumo
        // $data['info_dictamen']->Hora2   = $auxFechaHora2[1];   //hora consumo
        $data['info_dictamen']->Fecha3  = $auxFechaHora3['Fecha'];  //fecha registro
        $data['info_dictamen']->Hora3   = $auxFechaHora3['Hora'];   //hora registro


        $this->view("templates/header",$data);
        $this->view("system/dictamenM/verDictamenMView",$data);
        $this->view("templates/footer",$data);
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
                            <a class="page-link" href=" '.base_url.'DictamenMedico/index/?numPage=1'.$extra_cad.'&filtro='.$filtro.' " data-toggle="tooltip" data-placement="top" title="Primera página">
                                <i class="material-icons">first_page</i>
                            </a>
                        </li>';
                $links.= '<li class="page-item">
                            <a class="page-link" href=" '.base_url.'DictamenMedico/index/?numPage='.($numPage-1).$extra_cad.'&filtro='.$filtro.' " data-toggle="tooltip" data-placement="top" title="Página anterior">
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
                                <a class="page-link" href=" '.base_url.'DictamenMedico/index/?numPage='.($ind).$extra_cad.'&filtro='.$filtro.' ">
                                    '.($ind).'
                                </a>
                            </li>';
                }
            }

            //FLECHA DERECHA (NEXT PAGINATION)
            if ($numPage<$total_pages) {

                $links.= '<li class="page-item">
                            <a class="page-link" href=" '.base_url.'DictamenMedico/index/?numPage='.($numPage+1).$extra_cad.'&filtro='.$filtro.' " data-toggle="tooltip" data-placement="top" title="Siguiente página">
                            <i class="material-icons">navigate_next</i>
                            </a>
                        </li>';
                $links.= '<li class="page-item">
                            <a class="page-link" href=" '.base_url.'DictamenMedico/index/?numPage='.($total_pages).$extra_cad.'&filtro='.$filtro.' " data-toggle="tooltip" data-placement="top" title="Última página">
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
                        <th class="column2">Creado por</th>
                        <th class="column3">Nombre Detenido</th>
                        <th class="column4">Fecha y Hora</th>
                        <th class="column5">Enfermedades que Padece</th>
                        <th class="column6">Medicamentos que Toma</th>
                        <th class="column7">Actitud</th>
                        <th class="column8">Lenguaje</th>
                        <th class="column9">Diagnóstico</th>
                    ';
                    foreach ($rows as $row) {
                        //nombre usuario
                        $auxNombreMedico = ($row->Id_Usuario == 1)?'':$row->Nombre_Medico;
                        $auxLenguaje = "";
                        $auxArrayLenguaje = str_split($row->Lenguaje_Bit);
                        if(count($auxArrayLenguaje) == 4){
                            $auxLenguaje.= ($auxArrayLenguaje[0])?"Normal":"";
                            $auxLenguaje.= ($auxArrayLenguaje[1])?"Disartría":"";
                            $auxLenguaje.= ($auxArrayLenguaje[2])?" Verborreico":"";
                            $auxLenguaje.= ($auxArrayLenguaje[3])?" Incoherente":"";  
                        }
                        
                        
                        $infoTable['body'].= '<tr id="tr'.$row->Id_Dictamen.'">';
                        $infoTable['body'].= '  <td class="column1">'.$row->Id_Dictamen.'</td>
                                            <td class="column2">'.mb_strtoupper($auxNombreMedico).'</td>
                                            <td class="column3">'.mb_strtoupper($row->Nombre_Completo_Detenido).'</td>
                                            <td class="column4">'.$row->Fecha_Hora.'</td>
                                            <td class="column5">'.mb_strtoupper($row->Enfermedades_Padece).'</td>
                                            <td class="column6">'.mb_strtoupper($row->Medicamentos_Toma).'</td>
                                            <td class="column7">'.mb_strtoupper($row->Actitud).'</td>
                                            <td class="column8">'.mb_strtoupper($auxLenguaje).'</td>
                                            <td class="column9">'.mb_strtoupper($row->Diagnostico).'</td>

                        ';
                        //se comprueba si el registro ya tiene un dictamen previamente llenado o si no existe genera un link para nuevo
                        if ($row->Diagnostico != '') {
                            $infoTable['body'].= '<td>
                                                <a class="myLinks mb-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="right" title="Editar registro" href="'.base_url.'DictamenMedico/editarDictamen/?id_dictamen='.$row->Id_Dictamen.'">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                <a class="myLinks mt-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="right" title="Ver registro" href="'.base_url.'DictamenMedico/verDictamen/?id_dictamen='.$row->Id_Dictamen.'">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="myLinks mt-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="right" title="Generar formato dictamen" href="' . base_url . 'DictamenMedico/generarFormatoDictamen/?id_dictamen='.$row->Id_Dictamen.'" target="_blank">
                                                    <i class="material-icons">list_alt</i>
                                                </a>
                                            </td>';
                        }
                        else{
                            $infoTable['body'].= '<td>
                                                <a class="myLinks col-auto d-flex justify-content-center" data-toggle="tooltip" data-placement="top" title="Crear dictamen" href="'.base_url.'DictamenMedico/nuevoDictamen/?id_dictamen='.$row->Id_Dictamen.'">
                                                    <i class="material-icons">note_add</i>
                                                </a>
                                            </td>';
                        }
                        
                        $infoTable['body'].= '</tr>';
                    }
                break;
                case '2': //pendientes
                    $infoTable['header'] .= '
                        <th class="column1">Folio</th>
                        <th class="column2">Creadp por</th>
                        <th class="column3">Nombre Detenido</th>
                        <th class="column4">Fecha y Hora</th>
                        <th class="column5">Enfermedades que Padece</th>
                        <th class="column6">Medicamentos que Toma</th>
                        <th class="column7">Actitud</th>
                        <th class="column8">Lenguaje</th>
                        <th class="column9">Diagnóstico</th>
                    ';
                    foreach ($rows as $row) {
                        $auxNombreMedico = ($row->Id_Usuario == 1)?'':$row->Nombre_Medico;

                        $infoTable['body'].= '<tr id="tr'.$row->Id_Dictamen.'">';
                        $infoTable['body'].= '  <td class="column1">'.$row->Id_Dictamen.'</td>
                                            <td class="column2">'.mb_strtoupper($auxNombreMedico).'</td>
                                            <td class="column3">'.mb_strtoupper($row->Nombre_Completo_Detenido).'</td>
                                            <td class="column4">'.$row->Fecha_Hora.'</td>
                                            <td class="column5">'.mb_strtoupper($row->Enfermedades_Padece).'</td>
                                            <td class="column6">'.mb_strtoupper($row->Medicamentos_Toma).'</td>
                                            <td class="column7">'.mb_strtoupper($row->Actitud).'</td>
                                            <td class="column8">'.mb_strtoupper($row->Lenguaje_Bit).'</td>
                                            <td class="column9">'.mb_strtoupper($row->Diagnostico).'</td>

                        ';
                        
                        $infoTable['body'].= '<td>
                                            <a class="myLinks col-auto d-flex justify-content-center" data-toggle="tooltip" data-placement="top" title="Crear dictamen" href="'.base_url.'DictamenMedico/nuevoDictamen/?id_dictamen='.$row->Id_Dictamen.'">
                                                <i class="material-icons">note_add</i>
                                            </a>
                                        </td>';
                        
                        $infoTable['body'].= '</tr>';
                    }
                break;
                case '3': //completados
                    $infoTable['header'] .= '
                        <th class="column1">Folio</th>
                        <th class="column2">Creado por</th>
                        <th class="column3">Nombre Detenido</th>
                        <th class="column4">Fecha y Hora</th>
                        <th class="column5">Enfermedades que Padece</th>
                        <th class="column6">Medicamentos que Toma</th>
                        <th class="column7">Actitud</th>
                        <th class="column8">Lenguaje</th>
                        <th class="column9">Diagnóstico</th>
                    ';
                    foreach ($rows as $row) {
                        $auxNombreMedico = ($row->Id_Usuario == 1)?'':$row->Nombre_Medico;
                        $auxLenguaje = "";
                        $auxArrayLenguaje = str_split($row->Lenguaje_Bit);
                        if(count($auxArrayLenguaje) == 4){
                            $auxLenguaje.= ($auxArrayLenguaje[0])?"Normal":"";
                            $auxLenguaje.= ($auxArrayLenguaje[1])?"Disartría":"";
                            $auxLenguaje.= ($auxArrayLenguaje[2])?" Verborreico":"";
                            $auxLenguaje.= ($auxArrayLenguaje[3])?" Incoherente":"";  
                        }
                        $infoTable['body'].= '<tr id="tr'.$row->Id_Dictamen.'">';
                        $infoTable['body'].= '  <td class="column1">'.$row->Id_Dictamen.'</td>
                                            <td class="column2">'.mb_strtoupper($auxNombreMedico).'</td>
                                            <td class="column3">'.mb_strtoupper($row->Nombre_Completo_Detenido).'</td>
                                            <td class="column4">'.$row->Fecha_Hora.'</td>
                                            <td class="column5">'.mb_strtoupper($row->Enfermedades_Padece).'</td>
                                            <td class="column6">'.mb_strtoupper($row->Medicamentos_Toma).'</td>
                                            <td class="column7">'.mb_strtoupper($row->Actitud).'</td>
                                            <td class="column8">'.mb_strtoupper($auxLenguaje).'</td>
                                            <td class="column9">'.mb_strtoupper($row->Diagnostico).'</td>

                        ';
                        
                        $infoTable['body'].= '<td>
                                                <a class="myLinks mb-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="right" title="Editar registro" href="'.base_url.'DictamenMedico/editarDictamen/?id_dictamen='.$row->Id_Dictamen.'">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                <a class="myLinks mt-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="right" title="Ver registro" href="'.base_url.'DictamenMedico/verDictamen/?id_dictamen='.$row->Id_Dictamen.'">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="myLinks mt-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="right" title="Generar formato dictamen" href="' . base_url . 'DictamenMedico/generarFormatoDictamen/?id_dictamen='.$row->Id_Dictamen.'" target="_blank">
                                                    <i class="material-icons">list_alt</i>
                                                </a>
                                            </td>';
                        
                        $infoTable['body'].= '</tr>';
                    }
                break;
                case '4': //otros
                    $infoTable['header'] .= '
                        <th class="column1">Folio</th>
                        <th class="column2">Creado por</th>
                        <th class="column3">Nombre Detenido</th>
                        <th class="column4">Fecha y Hora</th>
                        <th class="column5">Enfermedades que Padece</th>
                        <th class="column6">Medicamentos que Toma</th>
                        <th class="column7">Actitud</th>
                        <th class="column8">Lenguaje</th>
                        <th class="column9">Diagnóstico</th>
                    ';
                    foreach ($rows as $row) {
                        $auxNombreMedico = ($row->Id_Usuario == 1)?'':$row->Nombre_Medico;
                        $auxLenguaje = "";
                        $auxArrayLenguaje = str_split($row->Lenguaje_Bit);
                        if(count($auxArrayLenguaje) == 4){
                            $auxLenguaje.= ($auxArrayLenguaje[0])?"Normal":"";
                            $auxLenguaje.= ($auxArrayLenguaje[1])?"Disartría":"";
                            $auxLenguaje.= ($auxArrayLenguaje[2])?" Verborreico":"";
                            $auxLenguaje.= ($auxArrayLenguaje[3])?" Incoherente":"";  
                        }
                        $infoTable['body'].= '<tr id="tr'.$row->Id_Dictamen.'">';
                        $infoTable['body'].= '  <td class="column1">'.$row->Id_Dictamen.'</td>
                                            <td class="column2">'.mb_strtoupper($auxNombreMedico).'</td>
                                            <td class="column3">'.mb_strtoupper($row->Nombre_Completo_Detenido).'</td>
                                            <td class="column4">'.$row->Fecha_Hora.'</td>
                                            <td class="column5">'.mb_strtoupper($row->Enfermedades_Padece).'</td>
                                            <td class="column6">'.mb_strtoupper($row->Medicamentos_Toma).'</td>
                                            <td class="column7">'.mb_strtoupper($row->Actitud).'</td>
                                            <td class="column8">'.mb_strtoupper($auxLenguaje).'</td>
                                            <td class="column9">'.mb_strtoupper($row->Diagnostico).'</td>

                        ';
                        $infoTable['body'].= '<td>
                                                <a class="myLinks mb-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="right" title="Editar registro" href="'.base_url.'DictamenMedico/editarDictamen/?id_dictamen='.$row->Id_Dictamen.'">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                <a class="myLinks mt-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="right" title="Ver registro" href="'.base_url.'DictamenMedico/verDictamen/?id_dictamen='.$row->Id_Dictamen.'">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a class="myLinks mt-3 d-flex justify-content-center" data-toggle="tooltip" data-placement="right" title="Generar formato dictamen" href="' . base_url . 'DictamenMedico/generarFormatoDictamen/?id_dictamen='.$row->Id_Dictamen.'" target="_blank">
                                                    <i class="material-icons">list_alt</i>
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
            $dataReturn['csv'] =  base_url.'DictamenMedico/exportarInfo/?tipo_export=CSV'.$extra_cad.'&filtroActual='.$filtro;
            $dataReturn['excel'] =  base_url.'DictamenMedico/exportarInfo/?tipo_export=EXCEL'.$extra_cad.'&filtroActual='.$filtro;
            $dataReturn['pdf'] =  base_url.'DictamenMedico/exportarInfo/?tipo_export=PDF'.$extra_cad.'&filtroActual='.$filtro;
            //return $dataReturn;
        }
        else{
            $dataReturn['csv'] =  base_url.'DictamenMedico/exportarInfo/?tipo_export=CSV'.$extra_cad.'&filtroActual='.$filtro;
            $dataReturn['excel'] =  base_url.'DictamenMedico/exportarInfo/?tipo_export=EXCEL'.$extra_cad.'&filtroActual='.$filtro;
            $dataReturn['pdf'] =  base_url.'DictamenMedico/exportarInfo/?tipo_export=PDF'.$extra_cad.'&filtroActual='.$filtro;
        }
        return $dataReturn;
    }

    //función fetch para buscar por la cadena introducida dependiendo del filtro
    public function buscarPorCadena(){
        /*Aquí van condiciones de permisos*/

        if (isset($_POST['cadena'])) {
            $cadena = trim($_POST['cadena']); 
            $filtroActual = trim($_POST['filtroActual']);

            $results = $this->DictamenM->getDictamenDByCadena($cadena,$filtroActual);
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
        if (!isset($_REQUEST['filtroActual']) || !is_numeric($_REQUEST['filtroActual']) || !($_REQUEST['filtroActual']>=MIN_FILTRO_DM) || !($_REQUEST['filtroActual']<=MAX_FILTRO_DM)) 
                $filtroActual = 1;
            else
                $filtroActual = $_REQUEST['filtroActual'];

        $from_where_sentence = "";
        //se genera la sentencia from where para realizar la correspondiente consulta
        if (isset($_REQUEST['cadena'])) 
            $from_where_sentence = $this->DictamenM->generateFromWhereSentence($_REQUEST['cadena'],$filtroActual);
        else
            $from_where_sentence = $this->DictamenM->generateFromWhereSentence("",$filtroActual);

        
        
        //var_dump($_REQUEST);
        $tipo_export = $_REQUEST['tipo_export'];

        if ($tipo_export == 'EXCEL') {
            //se realiza exportacion de usuarios a EXCEL
            $rows_ED = $this->DictamenM->getAllInfoDictamenDByCadena($from_where_sentence);
            switch ($filtroActual) {
                case '1':
                case '2':
                case '3':
                case '4':
                    $filename = "DM_general";
                    $csv_data="Folio,Fecha y Hora,Creada por,Nombre Detenido,Instancia,Enfermedades que Padece,Medicamentos que Toma,Prueba Alcoholímetro,Prueba Multitestdrog,Prueba Clínica,Coopera con el Interrogatorio,Estado de Conciencia,Orientacion,Actitud,Lenguaje,Facies,Conjuntivas,Pupilas,Pupilas (complemento),Mucosa oral,Aliento,Diagnóstico\n";

                    foreach ($rows_ED as $row) {
                        $auxNombreMedico = ($row->Id_Usuario == 1)?'':$row->Nombre_Medico;
                        $auxPrueba1 = ($row->Prueba_Alcoholimetro == 1)?'Sí':'No';
                        $auxPrueba2 = ($row->Prueba_Multitestdrog == 1)?'Sí':'No';
                        $auxPrueba3 = ($row->Prueba_Clinica == 1)?'Sí':'No';
                        $auxCoopera = ($row->Coopera_Interrogatorio)?'Sí':'No';

                        $auxLenguaje = "";
                        $auxArrayLenguaje = str_split($row->Lenguaje_Bit);
                        if(count($auxArrayLenguaje) == 4){
                            $auxLenguaje.= ($auxArrayLenguaje[0])?"Normal":"";
                            $auxLenguaje.= ($auxArrayLenguaje[1])?"Disartría":"";
                            $auxLenguaje.= ($auxArrayLenguaje[2])?" Verborreico":"";
                            $auxLenguaje.= ($auxArrayLenguaje[3])?" Incoherente":"";  
                        }

                        $auxOrientacion = "";
                        $auxArrayOrient = str_split($row->Orientacion_Bit);
                        if(count($auxArrayOrient) == 3){
                            $auxOrientacion.= ($auxArrayOrient[0])?"Persona":"";
                            $auxOrientacion.= ($auxArrayOrient[1])?" Tiempo":"";
                            $auxOrientacion.= ($auxArrayOrient[2])?" Espacio":"";  
                        }

                        $auxAliento = "";
                        $auxArrayAliento = str_split($row->Orientacion_Bit);
                        if(count($auxArrayAliento) == 3){
                            $auxAliento.= ($auxArrayAliento[0])?"Alcohol":"";
                            $auxAliento.= ($auxArrayAliento[1])?" Solventes":"";
                            $auxAliento.= ($auxArrayAliento[2])?" Cannabis":"";  
                        }



                        $csv_data.= mb_strtoupper($row->Id_Dictamen).",\"".
                                    mb_strtoupper($row->Fecha_Hora)."\",\"".
                                    mb_strtoupper($auxNombreMedico)."\",\"".
                                    mb_strtoupper($row->Nombre_Completo_Detenido)."\",\"".
                                    mb_strtoupper($row->Instancia)."\",\"".
                                    mb_strtoupper($row->Enfermedades_Padece)."\",\"".
                                    mb_strtoupper($row->Medicamentos_Toma)."\",\"".
                                    mb_strtoupper($auxPrueba1)."\",\"".
                                    mb_strtoupper($auxPrueba2)."\",\"".
                                    mb_strtoupper($auxPrueba3)."\",\"".
                                    mb_strtoupper($auxCoopera)."\",\"".
                                    mb_strtoupper($row->Estado_Conciencia)."\",\"".
                                    mb_strtoupper($auxOrientacion)."\",\"".
                                    mb_strtoupper($row->Actitud)."\",\"".
                                    mb_strtoupper($auxLenguaje)."\",\"".
                                    mb_strtoupper($row->Fascies)."\",\"".
                                    mb_strtoupper($row->Conjuntivas)."\",\"".
                                    mb_strtoupper($row->Pupilas)."\",\"".
                                    mb_strtoupper($row->Pupilas2)."\",\"".
                                    mb_strtoupper($row->Mucosa_Oral)."\",\"".
                                    mb_strtoupper($auxAliento)."\",\"".
                                    mb_strtoupper($row->Diagnostico)."\"\n";
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
            $rows_ED = $this->DictamenM->getAllInfoDictamenDByCadena($from_where_sentence);
            

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
    public function generarPDF($rows_DM,$cadena = "",$filtroActual = '1'){
        //require('../libraries/PDF library/fpdf16/fpdf.php');
        switch ($filtroActual) {
            case '1': $filename="vista general";break;
            case '2': $filename="registros pendientes";break;
            case '3': $filename="registros completados";break;
            case '4': $filename="otros registros";break;
        }

        $data['subtitulo']      = 'Dictamen médico: '.$filename;

        if ($cadena != "") {
            $data['msg'] = 'todos los registros de Dictamen médico con filtro: '.$cadena.'';
        }
        else{
            $data['msg'] = 'todos los registros de Dictamen médico';
        }

        //---Aquí va la info según sea el filtro de ED seleccionado
        switch ($filtroActual) {
            case '1':
            case '2':
            case '3':
                $data['columns'] =  [
                                'Folio',
                                'Núm. Remisión',
                                'Detenido',
                                'Fecha y Hora',
                                'Instancia',
                                'Enfermedades que Padece',
                                'Medicamentos que Toma',
                                'Coopera con el Interrogatorio',
                                'Estado de Conciencia',
                                'Actitud',
                                'Lenguaje',
                                'Diagnóstico'
                            ];  
                $data['field_names'] = [
                                'Id_Dictamen',
                                'No_Remision1',
                                'Nombre_Detenido',
                                'Fecha_Hora',
                                'Instancia_Remision',
                                'Enfermedades_Padece',
                                'Medicamentos_Toma',
                                'Coopera_Interrogatorio',
                                'Estado_Conciencia',
                                'Actitud',
                                'Lenguaje',
                                'Diagnostico'
                            ];
            break;
            case '4':
                $data['columns'] =  [
                                'Folio',
                                'Detenido',
                                'Fecha y Hora',
                                'Instancia',
                                'Enfermedades que Padece',
                                'Medicamentos que Toma',
                                'Coopera',
                                'Estado de Conciencia',
                                'Actitud',
                                'Lenguaje',
                                'Diagnóstico'
                            ];  
                $data['field_names'] = [
                                'Id_Dictamen',
                                'Nombre_Completo_Otro',
                                'Fecha_Hora',
                                'Instancia',
                                'Enfermedades_Padece',
                                'Medicamentos_Toma',
                                'Coopera_Interrogatorio',
                                'Estado_Conciencia',
                                'Actitud',
                                'Lenguaje',
                                'Diagnostico'
                            ];
            break;
            
        }
        //---fin de la info del ED
        

        $data['rows'] = $rows_DM;
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
            unset($_SESSION['userdata']->rango_inicio_dm);
            unset($_SESSION['userdata']->rango_fin_dm);
            unset($_SESSION['userdata']->rango_hora_inicio_dm);
            unset($_SESSION['userdata']->rango_hora_fin_dm);

            header("Location: ".base_url."DictamenMedico/index/?filtro=".$_REQUEST['filtroActual']);
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
                $campos = ['Folio','Creado por','Nombre Detenido','Fecha y Hora','Enfermedades que Padece','Medicamentos que Toma','Actitud','Lenguaje','Diagnóstico'];
            break;
            case '2':
                $campos = ['Folio','Creado por','Nombre Detenido','Fecha y Hora','Enfermedades que Padece','Medicamentos que Toma','Actitud','Lenguaje','Diagnóstico'];
            break;
            case '3':
                $campos = ['Folio','Creado por','Nombre Detenido','Fecha y Hora','Enfermedades que Padece','Medicamentos que Toma','Actitud','Lenguaje','Diagnóstico'];
            break;
            case '4':
                $campos = ['Folio','Creado por','Nombre Detenido','Fecha y Hora','Enfermedades que Padece','Medicamentos que Toma','Actitud','Lenguaje','Diagnóstico'];
            break;
        }
        //gestión de cada columna
        $ind = 1;
        foreach($campos as $campo){
            $checked = ($_SESSION['userdata']->columns_DM['column'.$ind] == 'show')?'checked':'';
            $dropDownColumn.= ' <div class="form-check">
                                    <input class="form-check-input checkColumns" type="checkbox" value="'.$_SESSION['userdata']->columns_DM['column'.$ind].'" onchange="hideShowColumn(this.id);" id="column'.$ind.'" '.$checked.'>
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
        if (isset($_SESSION['userdata']->filtro_DM) && $_SESSION['userdata']->filtro_DM >= MIN_FILTRO_DM && $_SESSION['userdata']->filtro_DM<=MAX_FILTRO_DM ) {
            //si cambia el filtro se procde a cambiar los valores de las columnas que contiene el filtro seleccionado
            if ($_SESSION['userdata']->filtro_DM != $filtroActual) {
                $_SESSION['userdata']->filtro_DM = $filtroActual;
                unset($_SESSION['userdata']->columns_DM); //se borra las columnas del anterior filtro
                //se asignan las nuevas columnas y por default se muestran todas (atributo show)
                for($i=0;$i<$this->numColumnsDM[$_SESSION['userdata']->filtro_DM -1];$i++) 
                    $_SESSION['userdata']->columns_DM['column'.($i+1)] = 'show';

            }
        }
        else{ //si no existe el filtro entonces se inicializa con el primero por default
            $_SESSION['userdata']->filtro_DM = $filtroActual;
            unset($_SESSION['userdata']->columns_DM);
            for($i=0;$i<$this->numColumnsDM[$_SESSION['userdata']->filtro_DM -1];$i++)
                $_SESSION['userdata']->columns_DM['column'.($i+1)] = 'show';

            
        }
        //echo "filtro: ".var_dump($_SESSION['userdata']->filtro_DM)."<br>br>";
        //echo "columns: ".var_dump($_SESSION['userdata']->columns_DM)."<br>br>";
    }

    //función fetch que actualiza los valores de las columnas para la session
    public function setColumnFetch(){
        if (isset($_POST['columName']) && isset($_POST['valueColumn'])) {
            $_SESSION['userdata']->columns_DM[$_POST['columName']] = $_POST['valueColumn'];
            echo json_encode("ok");
        }
        else{
            header("Location: ".base_url."Inicio");
            exit();
        }
    }

    //generar el post correspondiente a cada checkbox
    public function generateCheckBoxPost($post,$ind=1){ //$ind = 1-Intoxicaqción etílica |  2-Orientación  |  3-Sustancia consumida
        switch ($ind) {
            case '1':
                $Intoxicacion_E = array_fill(0, 13, '0');
                if (isset($post['Intoxicacion_Etilica'])) {
                       foreach ($post['Intoxicacion_Etilica'] as $indice) {
                           $Intoxicacion_E[$indice] = '1';
                       }
                }
                return $Intoxicacion_E;
            break;
            case '2':
                $Orientacion = array_fill(0, 3, '0');
                if (isset($post['Orientacion'])) {
                       foreach ($post['Orientacion'] as $indice) {
                           $Orientacion[$indice] = '1';
                       }
                }
                return $Orientacion;
            break;
            case '3':
                $SustanciaC = array_fill(0, 3, '0');
                if (isset($post['Sustancia_Consumida'])) {
                       foreach ($post['Sustancia_Consumida'] as $indice => $value) {
                            switch($value)  {
                                case 'Alcohol':
                                   $SustanciaC[2] = '1';
                                break;
                                case 'Droga':
                                   $SustanciaC[1] = '1';
                                break;
                                case 'Inhalantes':
                                   $SustanciaC[0] = '1';
                                break;
                            }
                       }
                }
                return $SustanciaC;
            break;
            case '4':
                $Aliento_A = array_fill(0, 3, '0');
                if (isset($post['Aliento'])) {
                       foreach ($post['Aliento'] as $indice => $value) {
                            switch($value)  {
                                case 'Alcohol':
                                   $Aliento_A[2] = '1';
                                break;
                                case 'Solventes':
                                   $Aliento_A[1] = '1';
                                break;
                                case 'Cannabis':
                                   $Aliento_A[0] = '1';
                                break;
                            }
                       }
                }
                return $Aliento_A;
            break;
            case '5':
                $Lenguaje = array_fill(0, 4, '0');
                if (isset($post['Lenguaje'])) {
                       foreach ($post['Lenguaje'] as $indice => $value) {
                            switch($value)  {
                                case 'Normal':
                                   $Lenguaje[3] = '1';
                                break;
                                case 'Disartría':
                                   $Lenguaje[2] = '1';
                                break;
                                case 'Verborreico':
                                   $Lenguaje[1] = '1';
                                break;
                                case 'Incoherente':
                                   $Lenguaje[0] = '1';
                                break;
                            }
                       }
                }
                return $Lenguaje;
            break;
        }
    }

    //dar formato a fecha y Hora
    public function formatearFechaHora($fecha = null){
        $f_h = explode(" ", $fecha);

        setlocale(LC_TIME, 'es_CO.UTF-8'); //hora local méxico

        $results['Fecha'] = strftime("%d  de %B del %G", strtotime($f_h[0]));
        $results['Hora'] = date('g:i a', strtotime($f_h[1]));

        return $results;
    }

    //generar formato de dictamen
    public function generarFormatoDictamen(){
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Dictamen_M[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }
        //validando url
        if (!isset($_GET['id_dictamen']) || !is_numeric($_GET['id_dictamen'])) { //numero de catálogo
            header("Location: " . base_url . "Inicio");
            exit();
        }
        //comprobando que exista el registro con el id_dictamen de la url
        $dictamen_info = $this->DictamenM->getInfoRemisionForDictamen($_GET['id_dictamen']);
        if (!$dictamen_info) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $data = [
                    'titulo'    => 'Formato dictamen',
                    'extra_css' => '<link rel="stylesheet" href="' . base_url . 'public/css/system/dictamenM/formato1.css">',
                ];
        $data['info_dictamen'] = $dictamen_info;
        //formatear fecha y Hora
        $auxFechaHora1 = explode(" ",$data['info_dictamen']->Fecha_Hora);
        $auxFecha1 = explode("-",$auxFechaHora1[0]);
        $auxFecha1 = $auxFecha1[2]."/".$auxFecha1[1]."/".$auxFecha1[0];
        // $auxFechaHora2 = explode(" ",$data['info_dictamen']->Fecha_Hora_Consumo);
        // $auxFecha2 = explode("-",$auxFechaHora2[0]);
        // $auxFecha2 = (isset($auxFecha2[2]))?$auxFecha2[2]."/".$auxFecha2[1]."/".$auxFecha2[0]:'';
        $data['info_dictamen']->Fecha1  = $auxFecha1;  //fecha header
        $data['info_dictamen']->Hora1   = $auxFechaHora1[1];   //hora header
        // $data['info_dictamen']->Fecha2  = $auxFecha2;  //fecha consumo
        // $data['info_dictamen']->Hora2   = (isset($auxFechaHora2[1]))?$auxFechaHora2[1]:'';   //hora consumo

        //se manda todo a la vista de formato
        $this->view("system/dictamenM/formatoDictamenView",$data);
    }
}
?>