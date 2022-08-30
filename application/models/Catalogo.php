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
    11 - Parentezco
    12 - Forma Detención
    13 - Tipo de violencia
    14 - Grupos (policía)
    15 - Adicciones/Narcóticos
    16 - Tipo accesorios
    18 - Zonas / Sectores
    19 - Origen del evento
    20 - Vectores
    21 - Uso del vehículo
    22 - Marca vehículo IO
*/
class Catalogo
{
	
	public $db; //variable para instanciar el objeto PDO
    public function __construct(){
        $this->db = new Base(); //se instancia el objeto con los métodos de PDO
    }

    //Obtener la info del catálogo conforme a la cadena de búsqueda y al catálogo en sí
    public function getCatalogoByCadena($cadena,$catalogo = '1'){
        //CONSULTA COINCIDENCIAS DE CADENA CONFORME AL CATALOGO SELECCIONADO

        if (!is_numeric($catalogo) || !($catalogo>=MIN_CATALOGO) || !($catalogo<=MAX_CATALOGO))
        	$catalogo = 1;
        
        //sentencia from_where para hacer la busqueda por la cadena ingresada
        $from_where_sentence = $this->generateFromWhereSentence($catalogo,$cadena);
        $numPage = 1;
        $no_of_records_per_page = NUM_MAX_REG_PAGE; //total de registros por pagination
        $offset = ($numPage-1) * $no_of_records_per_page; // desplazamiento conforme a la pagina

        $results = $this->getTotalPages($no_of_records_per_page,$from_where_sentence);  //total de páginas conforme a la busqueda
        //info de retorno para la creacion de los links conforme a la cadena ingresada
        $data['cat_rows'] = $this->getDataCurrentPage($offset,$no_of_records_per_page,$from_where_sentence);   //se obtiene la información de la página actual
        $data['numPage'] = $numPage; //numero pag actual para la pagination footer
        $data['total_pages'] = $results['total_pages']; //total pages para la pagination
        $data['total_rows'] = $results['total_rows'];   //total de registro hallados
        
        return $data;
    }
    //esta funcion retorna tanto el número total de paginas para los links como el total de registros contados conforme a la busqueda
    public function getTotalPages($no_of_records_per_page,$from_where_sentence = ""){ 
        $sql_total_pages = "SELECT COUNT(*) as Num_Pages ".$from_where_sentence; //total registros
        $this->db->query($sql_total_pages);      //prepararando query
        $total_rows = $this->db->register()->Num_Pages; //ejecutando query y recuperando el valor obtenido
        $total_pages = ceil($total_rows / $no_of_records_per_page); //calculando el total de paginations

        $data['total_rows'] = $total_rows;
        $data['total_pages'] = $total_pages;
        return $data;
    }

    public function getDataCurrentPage($offset,$no_of_records_per_page,$from_where_sentence = ""){

        $sql = "
                SELECT * "
                .$from_where_sentence." 
                LIMIT $offset,$no_of_records_per_page
                ";

        $this->db->query($sql);
        return $this->db->registers();
    }

    public function generateFromWhereSentence($catalogo,$cadena=""){
        $from_where_sentence = "";
        switch ($catalogo) {
        	case '1': $from_where_sentence.= "FROM catalogo_tatuaje WHERE Tipo_Tatuaje LIKE '%".$cadena."%' OR Descripcion LIKE '%".$cadena."%'"; break;
        	case '2': $from_where_sentence.= "FROM catalogo_institucion_seguridad WHERE Tipo_Institucion LIKE '%".$cadena."%'"; break;
        	case '3': $from_where_sentence.= "FROM catalogo_medidas_droga WHERE Tipo_Medida LIKE '%".$cadena."%'"; break;
        	case '4': $from_where_sentence.= "FROM catalogo_falta_delito WHERE Entidad LIKE '%".$cadena."%' OR Falta_Delito LIKE '%".$cadena."%' OR Descripcion LIKE '%".$cadena."%'"; break;
        	case '5': $from_where_sentence.= "FROM catalogo_tipos_armas WHERE Tipo_Arma LIKE '%".$cadena."%'"; break;
        	case '6': $from_where_sentence.= "FROM catalogo_grupo_delictivo WHERE Nombre_Grupo LIKE '%".$cadena."%' OR Modus_Operandi LIKE '%".$cadena."%' OR Modo_Fuga LIKE '%".$cadena."%' OR Descripcion LIKE '%".$cadena."%'"; break;
            case '7': $from_where_sentence.= "FROM catalogo_media_filiacion WHERE Tipo_MF LIKE '%".$cadena."%' OR Valor_MF LIKE '%".$cadena."%'"; break;
            case '8': $from_where_sentence.= "FROM catalogo_vehiculo_ocra WHERE Marca LIKE '%".$cadena."%'"; break;
            case '9': $from_where_sentence.= "FROM catalogo_motocicletas WHERE Marca LIKE '%".$cadena."%'"; break;
            case '10': $from_where_sentence.= "FROM catalogo_escolaridad WHERE Escolaridad LIKE '%".$cadena."%'"; break;
            case '11': $from_where_sentence.= "FROM catalogo_parentezco WHERE Parentezco LIKE '%".$cadena."%'"; break;
            case '12': $from_where_sentence.= "FROM catalogo_forma_detencion WHERE Forma_Detencion LIKE '%".$cadena."%' OR Descripcion LIKE '%".$cadena."%'"; break;
            case '13': $from_where_sentence.= "FROM catalogo_tipo_violencia WHERE Tipo_Violencia LIKE '%".$cadena."%'"; break;
            case '14': $from_where_sentence.= "FROM catalogo_grupos WHERE Tipo_Grupo LIKE '%".$cadena."%' OR Valor_Grupo LIKE '%".$cadena."%'"; break;
            case '15': $from_where_sentence.= "FROM catalogo_adicciones WHERE Nombre_Adiccion LIKE '%".$cadena."%'"; break;
            case '16': $from_where_sentence.= "FROM catalogo_tipo_accesorios WHERE Tipo_Accesorio LIKE '%".$cadena."%'"; break;
            case '17': $from_where_sentence.= "FROM catalogo_tipo_vestimenta WHERE Tipo_Vestimenta LIKE '%".$cadena."%'"; break;
            case '18': $from_where_sentence.= "FROM catalogo_zonas_sectores WHERE Tipo_Grupo LIKE '%".$cadena."%' OR Zona_Sector LIKE '%".$cadena."%'"; break;
            case '19': $from_where_sentence.= "FROM catalogo_origen_evento WHERE Origen LIKE '%".$cadena."%'"; break;
            case '20': $from_where_sentence.= "FROM catalogo_vectores WHERE Vector LIKE '%".$cadena."%' OR Id_Vector_Interno LIKE '%".$cadena."%'"; break;
            case '21': $from_where_sentence.= "FROM catalogo_uso_vehiculo WHERE Uso LIKE '%".$cadena."%'"; break;
            case '22': $from_where_sentence.= "FROM catalogo_marca_vehiculos_io WHERE Marca LIKE '%".$cadena."%'"; break;
            case '23': $from_where_sentence.= "FROM catalogo_grupos_inspecciones WHERE Tipo_Grupo LIKE '%".$cadena."%' OR Valor_Grupo LIKE '%".$cadena."%'"; break;
        	//se añaden los dos nuevos catalogos: tipos y submarcas de vehiculos
            case '24': $from_where_sentence.= "FROM catalogo_tipos_vehiculos WHERE Tipo LIKE '%".$cadena."%'"; break;
            case '25': $from_where_sentence.= "FROM catalogo_submarcas_vehiculos WHERE Submarca LIKE '%".$cadena."%'"; break;
        	//Se añade el catalogo para estados, municipios, calles, colonias, animales, tipo_placanip, cuervo personas y vehiculos
            case '26': $from_where_sentence.= "FROM catalogo_placaniv WHERE Categoria LIKE '%".$cadena."%'"; break;
            case '27': $from_where_sentence.= "FROM catalogo_animales_asegurados WHERE Descripcion LIKE '%".$cadena."%'"; break;
            case '28': $from_where_sentence.= "FROM catalogo_colonias WHERE Tipo LIKE '%".$cadena."%' OR Colonia LIKE '%".$cadena."%'"; break;
            case '29': $from_where_sentence.= "FROM catalogo_calle WHERE Calle LIKE '%".$cadena."%'"; break;
            case '30': $from_where_sentence.= "FROM catalogo_estados WHERE Estado LIKE '%".$cadena."%'"; break;
            case '31': $from_where_sentence.= "FROM catalogo_estados_municipios WHERE Municipio LIKE '%".$cadena."%'"; break;
            case '32': $from_where_sentence.= "FROM catalogo_lista_negra WHERE id_dato LIKE '%".$cadena."%' OR CONCAT(Nombre, ' ',Ap_Paterno, ' ', Ap_Materno) LIKE '%".$cadena."%'"; break;
            case '33': $from_where_sentence.= "FROM catalogo_lista_vehiculos WHERE id_dato LIKE '%".$cadena."%' OR placa LIKE '%".$cadena."%' OR nip LIKE '%".$cadena."%'"; break;
            case '34': $from_where_sentence.= "FROM catalogo_codigos_postales WHERE Id_cp LIKE '%".$cadena."%' OR Codigo_postal LIKE '%".$cadena."%' OR Nombre LIKE '%".$cadena."%'"; break;
        	default:
        		case '1': $from_where_sentence.= "FROM catalogo_tatuaje WHERE Tipo_Tatuaje LIKE '%".$cadena."%' OR Descripcion LIKE '%".$cadena."%'"; break;
        	break;
        }
        return $from_where_sentence;
    }
    public function getAllInfoCatalogoByCadena($from_where_sentence = ""){
    	$sqlAux = "SELECT *"
    				.$from_where_sentence."
                    ";  //query a la DB
        $this->db->query($sqlAux);          //se prepara el query mediante PDO
        return $this->db->registers();      //retorna todos los registros devueltos por la consulta
    }

    public function getModalidadDetencion($post)
    {
        $modalidad = $post['modalidad'];
        $sql = "SELECT * FROM catalogo_forma_detencion WHERE Forma_Detencion = '".$modalidad."'";
        $this->db->query($sql);
        return $this->db->registers();
    }

    public function InsertOrUpdateCatalogo($post){
        $catalogo = $post['catalogo'];
        $action   = $post['action'];
        $response = "Error";

        //switch de catalogo
        try{
            $this->db->beginTransaction(); //inicio de transaction
                switch ($catalogo) {
                    case '1':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_tatuaje (Tipo_Tatuaje,Descripcion) 
                                        VALUES ('".$post['Tipo_Tatuaje']."','".$post['Descripcion']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_tatuaje 
                                        SET Tipo_Tatuaje    = '".$post['Tipo_Tatuaje']."',
                                            Descripcion     = '".$post['Descripcion']."' 
                                        WHERE Id_Tatuaje = ".$post['Id_Tatuaje']."
                                       ";
                            break;
                        }
                    break;
                    case '2':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_institucion_seguridad (Tipo_Institucion) 
                                        VALUES ('".$post['Tipo_Institucion']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_institucion_seguridad 
                                        SET Tipo_Institucion    = '".$post['Tipo_Institucion']."' 
                                        WHERE Id_Institucion = ".$post['Id_Institucion']."
                                       ";
                            break;
                        }
                    break;
                    case '3':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_medidas_droga (Tipo_Medida) 
                                        VALUES ('".$post['Tipo_Medida']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_medidas_droga 
                                        SET Tipo_Medida    = '".$post['Tipo_Medida']."' 
                                        WHERE Id_Medida = ".$post['Id_Medida']."
                                       ";
                            break;
                        }
                    break;
                    case '4':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_falta_delito (Entidad,Falta_Delito,Status,Descripcion) 
                                        VALUES ('".$post['Entidad']."','".$post['Falta_Delito']."',".$post['Status'].",'".$post['Descripcion']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_falta_delito 
                                        SET Entidad     = '".$post['Entidad']."',
                                            Falta_Delito    = '".$post['Falta_Delito']."',
                                            Status          = ".$post['Status'].",
                                            Descripcion     = '".$post['Descripcion']."'
                                        WHERE Id_Falta_Delito = ".$post['Id_Falta_Delito']."
                                       ";
                            break;
                        }
                    break;
                    case '5':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_tipos_armas (Tipo_Arma) 
                                        VALUES ('".$post['Tipo_Arma']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_tipos_armas 
                                        SET Tipo_Arma    = '".$post['Tipo_Arma']."' 
                                        WHERE Id_Tipo_Arma = ".$post['Id_Tipo_Arma']."
                                       ";
                            break;
                        }
                    break;
                    case '6':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_grupo_delictivo (Nombre_Grupo,Modus_Operandi,Modo_Fuga,Descripcion) 
                                        VALUES ('".$post['Nombre_Grupo']."','".$post['Modus_Operandi']."','".$post['Modo_Fuga']."','".$post['Descripcion']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_grupo_delictivo 
                                        SET Nombre_Grupo     = '".$post['Nombre_Grupo']."',
                                            Modus_Operandi    = '".$post['Modus_Operandi']."',
                                            Modo_Fuga          = '".$post['Modo_Fuga']."',
                                            Descripcion     = '".$post['Descripcion']."'
                                        WHERE Id_Grupo = ".$post['Id_Grupo']."
                                       ";
                            break;
                        }
                    break;
                    case '7':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_media_filiacion (Tipo_MF,Valor_MF) 
                                        VALUES ('".$post['Tipo_MF']."','".$post['Valor_MF']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_media_filiacion 
                                        SET Tipo_MF    = '".$post['Tipo_MF']."',
                                            Valor_MF     = '".$post['Valor_MF']."' 
                                        WHERE Id_MF = ".$post['Id_MF']."
                                       ";
                            break;
                        }
                    break;
                    case '8':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_vehiculo_ocra (Marca) 
                                        VALUES ('".$post['Marca']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_vehiculo_ocra 
                                        SET Marca    = '".$post['Marca']."' 
                                        WHERE Id_Vehiculo_OCRA = ".$post['Id_Vehiculo_OCRA']."
                                       ";
                            break;
                        }
                    break;
                    case '9':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_motocicletas (Marca) 
                                        VALUES ('".$post['Marca']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_motocicletas 
                                        SET Marca    = '".$post['Marca']."' 
                                        WHERE Id_Motocicleta = ".$post['Id_Motocicleta']."
                                       ";
                            break;
                        }
                    break;
                    case '10':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_escolaridad (Escolaridad) 
                                        VALUES ('".$post['Escolaridad']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_escolaridad 
                                        SET Escolaridad    = '".$post['Escolaridad']."' 
                                        WHERE Id_Escolaridad = ".$post['Id_Escolaridad']."
                                       ";
                            break;
                        }
                    break;
                    case '11':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_parentezco (Parentezco) 
                                        VALUES ('".$post['Parentezco']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_parentezco 
                                        SET Parentezco    = '".$post['Parentezco']."' 
                                        WHERE Id_Parentezco = ".$post['Id_Parentezco']."
                                       ";
                            break;
                        }
                    break;
                    case '12':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_forma_detencion (Forma_Detencion,Descripcion) 
                                        VALUES ('".$post['Forma_Detencion']."','".$post['Forma_Detencion']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_forma_detencion 
                                        SET Forma_Detencion    = '".$post['Forma_Detencion']."',
                                            Descripcion     = '".$post['Descripcion']."' 
                                        WHERE Id_Forma_Detencion = ".$post['Id_Forma_Detencion']."
                                       ";
                            break;
                        }
                    break;
                    case '13':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_tipo_violencia (Tipo_Violencia) 
                                        VALUES ('".$post['Tipo_Violencia']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_tipo_violencia 
                                        SET Tipo_Violencia    = '".$post['Tipo_Violencia']."' 
                                        WHERE Id_Tipo_Violencia = ".$post['Id_Tipo_Violencia']."
                                       ";
                            break;
                        }
                    break;
                    case '14':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_grupos (Tipo_Grupo,Valor_Grupo) 
                                        VALUES ('".$post['Tipo_Grupo']."','".$post['Valor_Grupo']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_grupos 
                                        SET Tipo_Grupo    = '".$post['Tipo_Grupo']."',
                                            Valor_Grupo     = '".$post['Valor_Grupo']."' 
                                        WHERE Id_Grupo = ".$post['Id_Grupo']."
                                       ";
                            break;
                        }
                    break;
                    case '15':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_adicciones (Nombre_Adiccion) 
                                        VALUES ('".$post['Nombre_Adiccion']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_adicciones 
                                        SET Nombre_Adiccion    = '".$post['Nombre_Adiccion']."' 
                                        WHERE Id_Adiccion = ".$post['Id_Adiccion']."
                                       ";
                            break;
                        }
                    break;
                    case '16':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_tipo_accesorios (Tipo_Accesorio) 
                                        VALUES ('".$post['Tipo_Accesorio']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_tipo_accesorios 
                                        SET Tipo_Accesorio    = '".$post['Tipo_Accesorio']."' 
                                        WHERE Id_Tipo_Accesorio = ".$post['Id_Tipo_Accesorio']."
                                       ";
                            break;
                        }
                    break;
                    case '17':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_tipo_vestimenta (Tipo_Vestimenta) 
                                        VALUES ('".$post['Tipo_Vestimenta']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_tipo_vestimenta 
                                        SET Tipo_Vestimenta    = '".$post['Tipo_Vestimenta']."' 
                                        WHERE Id_Tipo_Vestimenta = ".$post['Id_Tipo_Vestimenta']."
                                       ";
                            break;
                        }
                    break;
                    case '18':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_zonas_sectores (Tipo_Grupo,Zona_Sector) 
                                        VALUES ('".$post['Tipo_Grupo']."','".$post['Zona_Sector']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_zonas_sectores 
                                        SET Tipo_Grupo    = '".$post['Tipo_Grupo']."',
                                            Zona_Sector     = '".$post['Zona_Sector']."' 
                                        WHERE Id_Zona_Sector = ".$post['Id_Zona_Sector']."
                                       ";
                            break;
                        }
                    break;
                    case '19':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_origen_evento (Origen) 
                                        VALUES ('".$post['Origen']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_origen_evento 
                                        SET Origen = '".$post['Origen']."'
                                        WHERE Id_Origen_Evento = ".$post['Id_Origen_Evento']."
                                       ";
                            break;
                        }
                    break;
                    case '20':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_vectores (Id_Vector_Interno,Zona,Vector,Region) 
                                        VALUES ('".$post['Id_Vector_Interno']."','".$post['Zona']."','".$post['Vector']."','".$post['Region']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_vectores 
                                        SET Id_Vector_Interno     = '".$post['Id_Vector_Interno']."',
                                            Zona    = '".$post['Zona']."',
                                            Vector          = '".$post['Vector']."',
                                            Region     = '".$post['Region']."'
                                        WHERE Id_Vector = ".$post['Id_Vector']."
                                       ";
                            break;
                        }
                    break;
                    case '21':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_uso_vehiculo (Uso) 
                                        VALUES ('".$post['Uso']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_uso_vehiculo 
                                        SET Uso = '".$post['Uso']."'
                                        WHERE Id_Uso_Vehiculo = ".$post['Id_Uso_Vehiculo']."
                                       ";
                            break;
                        }
                    break;
                    case '22':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_marca_vehiculos_io (Marca) 
                                        VALUES ('".$post['Marca']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_marca_vehiculos_io 
                                        SET Marca = '".$post['Marca']."'
                                        WHERE Id_Marca_Io = ".$post['Id_Marca_Io']."
                                       ";
                            break;
                        }
                    break;
                    case '23':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_grupos_inspecciones (Tipo_Grupo,Valor_Grupo) 
                                        VALUES ('".$post['Tipo_Grupo']."','".$post['Valor_Grupo']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_grupos_inspecciones 
                                        SET Tipo_Grupo    = '".$post['Tipo_Grupo']."',
                                            Valor_Grupo     = '".$post['Valor_Grupo']."' 
                                        WHERE Id_Grupo_Inspeccion = ".$post['Id_Grupo_Inspeccion']."
                                       ";
                            break;
                        }
                    break;
                    //se añaden los dos nuevos catalogos: tipos y submarcas de vehiculos
                    case '24':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_tipos_vehiculos (Tipo) 
                                        VALUES ('".$post['Valor_Tipo']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_tipos_vehiculos 
                                        SET Tipo    = '".$post['Valor_Tipo']."' 
                                        WHERE Id_Tipo_veh = ".$post['Id_Tipo_Vehiculo']."
                                       ";
                            break;
                        }
                    break;
                    case '25':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_submarcas_vehiculos (Submarca) 
                                        VALUES ('".$post['Valor_Submarca']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_submarcas_vehiculos 
                                        SET Submarca    = '".$post['Valor_Submarca']."' 
                                        WHERE Id_Submarca_veh = ".$post['Id_Submarca_Vehiculo']."
                                        ";
                            break;
                        }
                    break;
                    //Se añade el catalogo para estados, municipios, calles, colonias, animales, tipo_placanip, cuervo personas y vehiculos
                    case '26':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_placaniv (Categoria) 
                                        VALUES ('".$post['Valor_Categoria']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_placaniv 
                                        SET Categoria    = '".$post['Valor_Categoria']."' 
                                        WHERE Id_categoria = ".$post['Id_Categoria']."
                                        ";
                            break;
                        }
                    break;
                    case '27':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_animales_asegurados (Descripcion) 
                                        VALUES ('".$post['Descripcion']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_animales_asegurados 
                                        SET Descripcion    = '".$post['Descripcion']."' 
                                        WHERE Id_Tipo_Animal = ".$post['Id_Tipo_Animal']."
                                        ";
                            break;
                        }
                    break;
                    case '28':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_colonias (Tipo,Colonia) 
                                        VALUES ('".$post['tipo']."','".$post['colonia']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_colonias 
                                        SET Tipo            = '".$post['tipo']."',
                                            Colonia         = '".$post['colonia']."' 
                                        WHERE Id_colonia = ".$post['Id_colonia']."
                                       ";
                            break;
                        }
                    break;
                    case '29':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_calle (Calle) 
                                        VALUES ('".$post['Id_calle_desc']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_calle 
                                        SET Calle    = '".$post['Id_calle_desc']."' 
                                        WHERE Id_Calle = ".$post['Id_calle']."
                                        ";
                            break;
                        }
                    break;
                    case '30':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_estados (Estado) 
                                         VALUES ('".$post['Estado']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_estados 
                                        SET Estado    = '".$post['Estado']."' 
                                        WHERE Id_estado = ".$post['Id_estado']."
                                        ";
                            break;
                        }
                    break;
                    case '31':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_estados_municipios (Estado,Municipio) 
                                        VALUES ('".$post['Id_municipio_desc']."','".$post['Id_municipio_m']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_estados_municipios 
                                        SET Estado            = '".$post['Id_municipio_desc']."',
                                            Municipio         = '".$post['Id_municipio_m']."'
                                        WHERE Id_municipio = ".$post['Id_municipio']."
                                        ";
                            break;
                        }
                    break;
                    case '32':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_lista_negra (Nombre,Ap_Paterno,Ap_Materno,Fecha_Registro) 
                                VALUES ('".$post['Nombre']."','".$post['Ap_Paterno']."','".$post['Ap_Materno']."',CURRENT_TIMESTAMP)";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_lista_negra
                                        SET Nombre    = '".$post['Nombre']."',
                                            Ap_Paterno = '".$post['Ap_Paterno']."' ,
                                            Ap_Materno ='".$post['Ap_Materno']."'    
                                        WHERE id_dato = ".$post['id_dato']."
                                        ";
                            break;
                        }
                    break;
                    case '33':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_lista_vehiculos (placa,nip,Fecha_Registro) 
                                VALUES ('".$post['placa']."','".$post['nip']."',CURRENT_TIMESTAMP)";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_lista_vehiculos
                                        SET placa    = '".$post['placa']."',
                                            nip = '".$post['nip']."'
                                        WHERE id_dato = ".$post['id_dato']."
                                        ";
                            break;
                        }
                    break;
                    case '34':
                        switch ($action) { //switch de action 1-insertar  2-actualizar
                            case '1':
                                $sql = "INSERT INTO catalogo_codigos_postales (Codigo_postal,Nombre) 
                                        VALUES ('".$post['Codigo_postal']."','".$post['Nombre']."')";
                            break;
                            case '2':
                                $sql = "UPDATE catalogo_codigos_postales 
                                        SET Codigo_postal            = '".$post['Codigo_postal']."',
                                            Nombre         = '".$post['Nombre']."'
                                        WHERE Id_cp = ".$post['Id_cp']."
                                        ";
                            break;
                        }
                    break;
                }
            $this->db->query($sql); //se prepara query
            $this->db->execute();   //se ejecuta el query
            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries
            $response = "Success";
        }
        catch (Exception $e) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            $response = "Fatal Error: ".$e->getMessage();
        }
            

        return $response;
    }

    public function deleteCatalogoRow($post){
        $catalogo = $post['catalogo'];
        $id_reg   = $post['Id_Reg'];
        $response = "Error";

        //switch de catalogo
        try{
            $this->db->beginTransaction(); //inicio de transaction
                switch ($catalogo) {
                    case '1': $sql = "DELETE FROM catalogo_tatuaje WHERE Id_Tatuaje = ".$id_reg; break;
                    case '2': $sql = "DELETE FROM catalogo_institucion_seguridad WHERE Id_Institucion = ".$id_reg; break;
                    case '3': $sql = "DELETE FROM catalogo_medidas_droga WHERE Id_Medida = ".$id_reg; break;
                    case '4': $sql = "DELETE FROM catalogo_falta_delito WHERE Id_Falta_Delito = ".$id_reg; break;
                    case '5': $sql = "DELETE FROM catalogo_tipos_armas WHERE Id_Tipo_Arma = ".$id_reg; break;
                    case '6': $sql = "DELETE FROM catalogo_grupo_delictivo WHERE Id_Grupo = ".$id_reg; break;
                    case '7': $sql = "DELETE FROM catalogo_media_filiacion WHERE Id_MF = ".$id_reg; break;
                    case '8': $sql = "DELETE FROM catalogo_vehiculo_ocra WHERE Id_Vehiculo_OCRA = ".$id_reg; break;
                    case '9': $sql = "DELETE FROM catalogo_motocicletas WHERE Id_Motocicleta = ".$id_reg; break;
                    case '10': $sql = "DELETE FROM catalogo_escolaridad WHERE Id_Escolaridad = ".$id_reg; break;
                    case '11': $sql = "DELETE FROM catalogo_parentezco WHERE Id_Parentezco = ".$id_reg; break;
                    case '12': $sql = "DELETE FROM catalogo_forma_detencion WHERE Id_Forma_Detencion = ".$id_reg; break;
                    case '13': $sql = "DELETE FROM catalogo_tipo_violencia WHERE Id_Tipo_Violencia = ".$id_reg; break;
                    case '14': $sql = "DELETE FROM catalogo_grupos WHERE Id_Grupo = ".$id_reg; break;
                    case '15': $sql = "DELETE FROM catalogo_adicciones WHERE Id_Adiccion = ".$id_reg; break;
                    case '16': $sql = "DELETE FROM catalogo_tipo_accesorios WHERE Id_Tipo_Accesorio = ".$id_reg; break;
                    case '17': $sql = "DELETE FROM catalogo_tipo_vestimenta WHERE Id_Tipo_Vestimenta = ".$id_reg; break;
                    case '18': $sql = "DELETE FROM catalogo_zonas_sectores WHERE Id_Zona_Sector = ".$id_reg; break;
                    case '19': $sql = "DELETE FROM catalogo_origen_evento WHERE Id_Origen_Evento = ".$id_reg; break;
                    case '20': $sql = "DELETE FROM catalogo_vectores WHERE Id_Vector = ".$id_reg; break;
                    case '21': $sql = "DELETE FROM catalogo_uso_vehiculo WHERE Id_Uso_Vehiculo = ".$id_reg; break;
                    case '22': $sql = "DELETE FROM catalogo_marca_vehiculos_io WHERE Id_Marca_Io = ".$id_reg; break;
                    case '23': $sql = "DELETE FROM catalogo_grupos_inspecciones WHERE Id_Grupo_Inspeccion = ".$id_reg; break;
                    /*Se añaden los dos nuevos catalogos: tipos y sumbarcas de vehiculos*/
                    case '24': $sql = "DELETE FROM catalogo_tipos_vehiculos WHERE Id_Tipo_veh = ".$id_reg; break;
                    case '25': $sql = "DELETE FROM catalogo_submarcas_vehiculos WHERE Id_Submarca_veh = ".$id_reg; break;
                    //Se añade el catalogo para estados, municipios, calles, colonias, animales, tipo_placanip, cuervo personas y vehiculos
                    case '26': $sql = "DELETE FROM catalogo_placaniv WHERE Id_categoria = ".$id_reg; break;
                    case '27': $sql = "DELETE FROM catalogo_animales_asegurados WHERE Id_Tipo_Animal = ".$id_reg; break;
                    case '28': $sql = "DELETE FROM catalogo_colonias WHERE Id_colonia = ".$id_reg; break;
                    case '29': $sql = "DELETE FROM catalogo_calle WHERE Id_Calle = ".$id_reg; break;
                    case '30': $sql = "DELETE FROM catalogo_estados WHERE Id_estado = ".$id_reg; break;
                    case '31': $sql = "DELETE FROM catalogo_estados_municipios WHERE Id_municipio = ".$id_reg; break;
                    case '32': $sql = "DELETE FROM catalogo_lista_negra WHERE id_dato = ".$id_reg; break;
                    case '33': $sql = "DELETE FROM catalogo_lista_vehiculos WHERE id_dato = ".$id_reg; break;
                    case '34': $sql = "DELETE FROM catalogo_codigos_postales WHERE Id_cp = ".$id_reg; break;
                }
            $this->db->query($sql); //se prepara query
            $this->db->execute();   //se ejecuta el query
            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries
            $response = "Success";
        }
        catch (Exception $e) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            $response = "Fatal Error: ".$e->getMessage();
        }
            

        return $response;
    }


    public function getCatalogforDropdown($post){
        //SELECT Valor_MF FROM catalogo_media_filiacion WHERE Tipo_MF = 'COMPLEXIÓN'
        $sql = "SELECT Valor_MF FROM catalogo_media_filiacion WHERE Tipo_MF ="."'".$post."'"."ORDER BY Id_MF";
        $this->db->query($sql);
        $resultado = $this->db->registers();
        return $resultado;
    }

    public function getSimpleCatalogo($campo, $tabla){
        $sql = "SELECT DISTINCT $campo FROM $tabla";
        $this->db->query($sql);
        $resultado = $this->db->registers();
        return $resultado;

    }

    /* ----- ----- ----- Función zona o sector ----- ----- ----- */
    public function getZonaSector($tipo){
        $sql = "SELECT Zona_Sector FROM catalogo_zonas_sectores WHERE Tipo_Grupo = "."'".$tipo."'";
        $this->db->query($sql);
        $resultado = $this->db->registers();
        return $resultado;
    }

    /*---------------Función para obtener los vectores solicitados */

    public function getVector($tipo){
        $aux = (is_int($tipo) ? "WHERE Zona = " .  $tipo   : "WHERE Zona = " .  "'" . $tipo ."'" );
        $sql = "SELECT Id_vector_Interno, Region FROM catalogo_vectores " . $aux . " ORDER BY Zona ASC, Id_Vector_Interno ASC";
        $this->db->query($sql);
        return $this->db->registers();
    }

    /*Funciones para Eventos delictivos*/
    public function getCatalogoGruposPolicia(){
        $sql = "SELECT CONCAT(Tipo_Grupo,' - ',Valor_Grupo) AS Grupo 
                FROM catalogo_grupos
                ORDER BY Tipo_Grupo,Valor_Grupo;    
                ";
        $this->db->query($sql);
        return $this->db->registers();
    }
    /*fin Eventos delictivos*/

    /*Funciones inspecciones*/
    public function getGruposZonasSectores(){
        $sql = "SELECT DISTINCT Tipo_Grupo FROM catalogo_grupos_inspecciones";
        $this->db->query($sql);
        $grupos = $this->db->registers();
        return $grupos;
    }
    /*fin inspecciones*/

    /*Obteniendo los Eventos para "Eventos delictivos"*/
    public function getEventos( $termino ){
        $sql = "SELECT descripcion FROM catalogo_911 WHERE descripcion LIKE " ."'". $termino."%' OR descripcion LIKE " . "'%" .$termino . "%' OR descripcion LIKE " . "'" . $termino . "%'" ;
        $this->db->query($sql);
        return $this->db->registers();
    }

    public function getColonia( $termino ){
        $sql = "SELECT Tipo_Colonia, Colonia  FROM catalogo_colonia WHERE Colonia LIKE " ."'". $termino."%' OR Colonia LIKE " . "'%" .$termino . "%' OR Colonia LIKE " . "'" . $termino . "%'" ;
        $this->db->query( $sql );
        return $this->db->registers();
    }
    /*Funciones añadidas para catalogo de colonias, calles, estados y municipios*/
    public function getColoniaCatalogo( $termino ){
        $sql = "SELECT Tipo, Colonia  FROM catalogo_colonias WHERE Colonia LIKE " ."'". $termino."%' OR Colonia LIKE " . "'%" .$termino . "%' OR Colonia LIKE " . "'" . $termino . "%'" ;
        $this->db->query( $sql );
        return $this->db->registers();
    }
    public function getCallesCatalogo( $termino ){
        $sql = "SELECT Calle  FROM catalogo_calle WHERE Calle LIKE " ."'". $termino."%' OR Calle LIKE " . "'%" .$termino . "%' OR Calle LIKE " . "'" . $termino . "%'" ;
        $this->db->query( $sql );
        return $this->db->registers();
    }
    public function getCPCatalogo($termino ){
        $termino=str_replace([" DE "," de "," DEL "," del "]," ",$termino);
        $sql = "SELECT *  FROM catalogo_codigos_postales WHERE Nombre LIKE " ."'%". $termino."%'" ;
        $this->db->query( $sql );
        return $this->db->registers();
    }
    public function getSimpleCatalogoOrder($campo, $tabla,$order){
        $sql = "SELECT DISTINCT $campo FROM $tabla Order By $order";
        $this->db->query($sql);
        $resultado = $this->db->registers();
        return $resultado;
    }
    public function getMunicipiosEstados( $termino,$estado ){
        $sql = "SELECT Municipio  FROM catalogo_estados_municipios WHERE (Municipio LIKE " ."'". $termino."%' OR Municipio LIKE " . "'%" .$termino . "%' OR Municipio LIKE " . "'" . $termino . "%') AND Estado = "."'".$estado."'";
        $this->db->query( $sql );
        return $this->db->registers();
    }
    public function existeMunicipio( $estado,$municipio ){
        $sql = "SELECT COUNT(Municipio) AS CONTADOR from catalogo_estados_municipios where Estado=" ."'". $estado."' AND Municipio="."'".$municipio."'";
        $this->db->query( $sql );
        return $this->db->registers();
    }
    /*Funciones añadidad para colonias y calles de catalogo*/
    public function getColonias()
    {
        $sql = "SELECT Tipo, Colonia FROM catalogo_colonias";
        $this->db->query($sql);
        return $this->db->registers();
    }
    public function getCalles()
    {
        $sql = "SELECT Calle FROM catalogo_calle";
        $this->db->query($sql);
        return $this->db->registers();
    }
    /*Funciones añadidas para catalogo de cuervos*/
    public function getIncidenciasCuervosPersonas(){
        $sql = "SELECT * FROM registros_match_lista_negra";
        $this->db->query($sql);
        return $this->db->registers();
    }

    public function getIncidenciasCuervosVehiculos(){
        $sql = "SELECT * FROM registros_vehiculos_lista";
        $this->db->query($sql);
        return $this->db->registers();
    }

    public function getCatalogoPersonas(){
        $sql = "SELECT * FROM catalogo_lista_negra";
        $this->db->query($sql);
        return $this->db->registers();
    }

    public function getCatalogoPlacaNip(){
        $sql = "SELECT * FROM catalogo_lista_vehiculos";
        $this->db->query($sql);
        return $this->db->registers();
    }
    public function getSubmarcaCatalogo($termino){
        $sql = "SELECT Submarca  FROM catalogo_submarcas_vehiculos WHERE Submarca LIKE " ."'". $termino."%' OR Submarca LIKE " . "'%" .$termino . "%' OR Submarca LIKE " . "'" . $termino . "%'" ;
        $this->db->query( $sql );
        return $this->db->registers();
    }
    public function getMarcaCatalogo($termino){
        $sql = "SELECT Marca  FROM catalogo_marca_vehiculos_io WHERE Marca LIKE " ."'". $termino."%' OR Marca LIKE " . "'%" .$termino . "%' OR Marca LIKE " . "'" . $termino . "%'" ;
        $this->db->query( $sql );
        return $this->db->registers();
    }
    public function getAMarcas()
    {
        $sql = "SELECT Marca FROM catalogo_marca_vehiculos_io";
        $this->db->query($sql);
        return $this->db->registers();
    }
    public function getSMarcas()
    {
        $sql = "SELECT Submarca FROM catalogo_submarcas_vehiculos";
        $this->db->query($sql);
        return $this->db->registers();
    }
     /*---------------- Funciones Modulo de Indicios -------------*/
    /*---------------Función para obtener todos los vectores */

    public function getAllVector(){
        $sql = "SELECT Id_vector_Interno, Zona, Region FROM catalogo_vectores ORDER BY Zona ASC, Id_Vector_Interno ASC";
        $this->db->query($sql);
        return $this->db->registers();
    }

    public function getAllFormaDetencion(){
        $sql = "SELECT * FROM catalogo_forma_detencion";
        $this->db->query($sql);
        return $this->db->registers();
    }

    public function getAllArma(){
        $sql = "SELECT * FROM catalogo_tipos_armas";
        $this->db->query($sql);
        return $this->db->registers();
    }

    public function getAllMedidasDroga(){
        $sql = "SELECT * FROM catalogo_medidas_droga";
        $this->db->query($sql);
        return $this->db->registers();
    }

    public function getAllAdicciones(){
        $sql = "SELECT * FROM catalogo_adicciones";
        $this->db->query($sql);
        return $this->db->registers();
    }

    public function getAllTipoAnimal(){
        $sql = "SELECT * FROM catalogo_animales_asegurados";
        $this->db->query($sql);
        return $this->db->registers();
    }

    public function getTipoAseguramiento($id_forma){
        $sql = "SELECT * FROM catalogo_forma_detencion WHERE Id_Forma_Detencion = $id_forma";
        $this->db->query($sql);
        return $this->db->registers();
    }

}


?>