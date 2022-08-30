<?php

class Vehiculo
{

    public $db; //variable para instanciar el objeto PDO
    public function __construct()
    {
        $this->db = new Base(); //se instancia el objeto con los métodos de PDO
    }
/*-----------------------FUNCIONES DE INSERTS-----------------------*/
    public function insertNuevoVehiculo($post)
    {
        $response['status'] = true;
        try {
            $this->db->beginTransaction();
            if($post['opciones_ficha']=="vehiculo"){
                if($post['ficha_vehiculo']=="existe"){
                    $num_ficha_vehiculo=$post['existe'];
                    $num_ficha_remision=0;
                }
                else{
                    $sql = "SELECT NO_FICHA_V FROM vehiculos ORDER BY NO_FICHA_V DESC";
                    $this->db->query($sql);
                    $num_ficha_vehiculo = $this->db->register()->NO_FICHA_V;
                    $num_ficha_vehiculo +=1;
                    $num_ficha_remision=0;
                }
            }
            else{
                $num_ficha_remision=$post['ficha_vehiculo'];
                $num_ficha_vehiculo=0;
            }
            $sql = " INSERT
                        INTO vehiculos(
                            ESTADO,
                            FECHA_RECUPERACION,
                            COLONIA,
                            ZONA_EVENTO,
                            PRIMER_RESPONDIENTE,
                            MARCA,
                            SUBMARCA,
                            TIPO,
                            MODELO,
                            COLOR,
                            CDI,
                            NO_FICHA_R,
                            NO_FICHA_V,
                            NOMBRE_MP,
                            OBSERVACIONES,
                            NARRATIVAS,
                            FECHA_PUESTA_DISPOSICION,
                            ELABORO
                        )
                        VALUES (
                            '" . trim($post['Tipo_Situacion']) . "',
                            '" . trim($post['fechar_Vehiculo']) . "',
                            '" . trim(strtoupper($post['colonia_Vehiculo'])) . "',
                            '" . trim(strtoupper($post['zona_Vehiculo'])) . "',
                            '" . trim(strtoupper($post['primerm_Vehiculo'])) . "',
                            '" . trim(strtoupper($post['Marca'])) . "',
                            '" . trim(strtoupper($post['Submarca'])) . "',
                            '" . trim(strtoupper($post['Tipo_Vehiculo'])) . "',
                            '" . trim(strtoupper($post['Modelo'])) . "',
                            '" . trim(strtoupper($post['Color'])) . "',
                            '" . trim(strtoupper($post['CDI_Vehiculo'])) . "',
                            '" . trim($num_ficha_remision) . "',
                            '" . trim($num_ficha_vehiculo) . "',
                            '" . trim(strtoupper($post['nombre_mp'])) ." ".trim(strtoupper($post['apellidop_mp'])) ." ".trim(strtoupper($post['apellidom_mp'])) . "',
                            '" . trim(strtoupper($post['Observacion_Vehiculo'])) . "',
                            '" . trim(strtoupper($post['Narrativas_Vehiculo'])) . "',
                            '" . trim($post['fechad_Vehiculo']) . "',
                            '" . trim($_SESSION['userdata']->Nombre ." ".$_SESSION['userdata']->Ap_Paterno." ".$_SESSION['userdata']->Ap_Materno) . "'
                        )
                ";
            $this->db->query($sql);
            $this->db->execute();

            $this->db->query("SELECT LAST_INSERT_ID() as No_Vehiculo"); //se recupera el id de fichas creado recientemente
            $no_Vehiculo = $this->db->register()->No_Vehiculo;
            $placas = json_decode($post['placas_table']);
            foreach ($placas as $placa) {
                $sql = " INSERT
                        INTO placas_vehiculos(
                            NO_VEHICULO,
                            DESCRIPCION,
                            PLACA,
                            PROCEDENCIA
                        )
                        VALUES(
                            trim($no_Vehiculo),
                            '" . trim(strtoupper($placa->row->tipo)) . "',
                            '" . trim(strtoupper($placa->row->placa)) . "',
                            '" . trim(strtoupper($placa->row->procedencia)) . "'
                        )
                ";
                $this->db->query($sql);
                $this->db->execute();
            }
            $nivs = json_decode($post['niv_table']);
            foreach ($nivs as $niv) {
                $sql = " INSERT
                        INTO no_serie_vehiculos(
                            NO_VEHICULO,
                            DESCRIPCION,
                            NO_SERIE
                        )
                        VALUES(
                            trim($no_Vehiculo),
                            '" . trim(strtoupper($niv->row->tipo)) . "',
                            '" . trim(strtoupper($niv->row->niv)) . "'
                        )
                ";
                $this->db->query($sql);
                $this->db->execute();
            }
            $this->db->commit();
            $response['status'] = true;
        }catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = 'Error al insertar en la base de datos';
            $this->db->rollBack();
        }
        return $response;
            
    }
    public function obtenerFicha($post)
    {
        try {
            $this->db->beginTransaction();
            $sql = "SELECT COUNT(*) as existe FROM ficha WHERE No_Ficha= '" . $post['buscar'] . "'";
            $this->db->query($sql);
            $existe = $this->db->register()->existe;
            if($existe==0)
                $response['status'] = false;
            else
                $response['status'] = true;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = 'Error al insertar en la base de datos';
            $this->db->rollBack();
        }

        return $response;
    }
/*--------------------------FIN DE INSERTS--------------------------*/

    /* * * * * * * * * * * * * * *   Funciones para insertar accine del historial de Remisiones   * * * * * * * * * * * * * * */

    //Funcionn que inserta los movimientos de los usuarios en la tabla historial
    public function historial($user, $ip, $movimiento, $descripcion)
    {
        $band = true;
        try {

            $this->db->beginTransaction();

            $sql = " INSERT
                    INTO historial(
                        Id_Usuario,
                        Ip_Acceso,
                        Movimiento,
                        Descripcion
                    )
                    VALUES(
                        trim($user),
                        '" . trim($ip) . "',
                        trim($movimiento),
                        '" . trim($descripcion) . "'
                    )
            ";
            $this->db->query($sql);
            $this->db->execute();

            $this->db->commit();
        } catch (Exception $e) {
            echo "Sucedio un error " . $e;
            $band = false;
            $this->db->rollBack();
        }

        return $band;
    }

    /*------------------------------UPDATE -----------------------*/
    public function updateVehiculo($post,$file)
    {
        $response['status'] = true;
        try {
            $this->db->beginTransaction();
            $no_Vehiculo=$post['no_vehiculo_'];
            $bandera=0;
            if($post['modo_admin']==1){
                if($post['cambio']!="no"){
                    $bandera=1;
                    $ficha_remision=0; $ficha_vehiculo=0;
                    switch($post['cambio']){
                        case "vehiculo_vehiculo_nuevo":
                            $sql = "SELECT NO_FICHA_V FROM vehiculos ORDER BY NO_FICHA_V DESC";
                            $this->db->query($sql);
                            $ficha_vehiculo = $this->db->register()->NO_FICHA_V;
                            $ficha_vehiculo +=1;
                            $ficha_remision=0;
                            break;
                        case "vehiculo_vehiculo_existe":
                            $ficha_vehiculo=$post['ficha_vehiculo_nueva'];
                            $ficha_remision=0;
                            break;
                        case "vehiculo_remision":
                            $ficha_remision=$post['ficha_vehiculo_nueva'];
                            $ficha_vehiculo=0;
                            break;
                        case "remision_vehiculo_nuevo":
                            $sql = "SELECT NO_FICHA_V FROM vehiculos ORDER BY NO_FICHA_V DESC";
                            $this->db->query($sql);
                            $ficha_vehiculo = $this->db->register()->NO_FICHA_V;
                            $ficha_vehiculo +=1;
                            $ficha_remision=0;
                            break;
                        case "remision_vehiculo_existe":
                            $ficha_vehiculo=$post['ficha_vehiculo_nueva'];
                            $ficha_remision=0;
                            break;
                        case "remision_remision":
                            $ficha_remision=$post['ficha_vehiculo_nueva'];
                            $ficha_vehiculo=0;
                            break;
                    }
                    $sql = " UPDATE vehiculos 
                            SET ESTADO='" . trim($post['Tipo_SituacionE']) . "',
                            FECHA_RECUPERACION='" . trim($post['fechar_VehiculoE']) . "',
                            COLONIA='" . trim(strtoupper($post['colonia_VehiculoE'])) . "',
                            ZONA_EVENTO='" . trim(strtoupper($post['zona_VehiculoE'])) . "',
                            PRIMER_RESPONDIENTE='" . trim(strtoupper($post['primerm_VehiculoE'])) . "',
                            MARCA='" . trim($post['MarcaE']) . "',
                            SUBMARCA='" . trim($post['SubmarcaE']) . "',
                            TIPO='" . trim($post['Tipo_VehiculoE']) . "',
                            MODELO='" . trim($post['ModeloE']) . "',
                            COLOR='" . trim(strtoupper($post['ColorE'])) . "',
                            CDI='" . trim(strtoupper($post['CDI_VehiculoE'])) . "',
                            NO_FICHA_R='" . $ficha_remision . "',
                            NO_FICHA_V='" . $ficha_vehiculo . "',
                            NO_REMISION='" . trim($post['remision_VehiculoE']) . "',
                            NOMBRE_MP='" . trim(strtoupper($post['nombre_mpE']))." ".trim(strtoupper($post['apellidop_mpE'])) ." ".trim(strtoupper($post['apellidom_mpE'])) . "',
                            OBSERVACIONES='" . trim(strtoupper($post['Observacion_VehiculoE'])) . "',
                            NARRATIVAS='" . trim(strtoupper($post['Narrativas_VehiculoE'])) . "',
                            FECHA_PUESTA_DISPOSICION='" . trim($post['fechad_VehiculoE']) . "',
                            ACTIVA=b'" . trim($post['inactiva']) . "'
                            WHERE ID_VEHICULO = '" . $post['no_vehiculo_'] . "'";

                            $this->db->query($sql);
                            $this->db->execute();
                }
            }
            if($bandera==0){
                $sql = " UPDATE vehiculos 
                SET ESTADO='" . trim($post['Tipo_SituacionE']) . "',
                FECHA_RECUPERACION='" . trim($post['fechar_VehiculoE']) . "',
                COLONIA='" . trim(strtoupper($post['colonia_VehiculoE'])) . "',
                ZONA_EVENTO='" . trim(strtoupper($post['zona_VehiculoE'])) . "',
                PRIMER_RESPONDIENTE='" . trim(strtoupper($post['primerm_VehiculoE'])) . "',
                MARCA='" . trim($post['MarcaE']) . "',
                SUBMARCA='" . trim($post['SubmarcaE']) . "',
                TIPO='" . trim($post['Tipo_VehiculoE']) . "',
                MODELO='" . trim($post['ModeloE']) . "',
                COLOR='" . trim(strtoupper($post['ColorE'])) . "',
                CDI='" . trim(strtoupper($post['CDI_VehiculoE'])) . "',
                NO_REMISION='" . trim($post['remision_VehiculoE']) . "',
                NOMBRE_MP='" . trim(strtoupper($post['nombre_mpE']))." ".trim(strtoupper($post['apellidop_mpE'])) ." ".trim(strtoupper($post['apellidom_mpE'])) . "',
                OBSERVACIONES='" . trim(strtoupper($post['Observacion_VehiculoE'])) . "',
                NARRATIVAS='" . trim(strtoupper($post['Narrativas_VehiculoE'])) . "',
                FECHA_PUESTA_DISPOSICION='" . trim($post['fechad_VehiculoE']) . "',
                ACTIVA=b'" . trim($post['inactiva']) . "'
                WHERE ID_VEHICULO = '" . $post['no_vehiculo_'] . "'";

                $this->db->query($sql);
                $this->db->execute();
            }
                $sql = "DELETE FROM placas_vehiculos WHERE NO_VEHICULO =" . $post['no_vehiculo_'];
                $this->db->query($sql);
                $this->db->execute();

                $placas = json_decode($post['placas_table']);
                foreach ($placas as $placa) {
                    $sql = " INSERT
                            INTO placas_vehiculos(
                                NO_VEHICULO,
                                DESCRIPCION,
                                PLACA,
                                PROCEDENCIA
                            )
                            VALUES(
                                trim($no_Vehiculo),
                                '" . trim(strtoupper($placa->row->tipo)) . "',
                                '" . trim(strtoupper($placa->row->placa)) . "',
                                '" . trim(strtoupper($placa->row->procedencia)) . "'
                            )
                    ";
                    $this->db->query($sql);
                    $this->db->execute();
                }
                $sql = "DELETE FROM no_serie_vehiculos WHERE NO_VEHICULO =" . $post['no_vehiculo_'];
                $this->db->query($sql);
                $this->db->execute();
                $nivs = json_decode($post['niv_table']);
                foreach ($nivs as $niv) {
                    $sql = " INSERT
                            INTO no_serie_vehiculos(
                                NO_VEHICULO,
                                DESCRIPCION,
                                NO_SERIE
                            )
                            VALUES(
                                trim($no_Vehiculo),
                                '" . trim(strtoupper($niv->row->tipo)) . "',
                                '" . trim(strtoupper($niv->row->niv)) . "'
                            )
                    ";
                    $this->db->query($sql);
                    $this->db->execute();
                }
                if ($file)
                    $nameFile = "" . $post['no_vehiculo_'] . ".pdf";
                if ($file) {
                    $sql = " UPDATE vehiculos
                        SET Path_file = '" . trim($nameFile) . "' WHERE ID_VEHICULO = '" . $post['no_vehiculo_'] . "'";
                    $this->db->query($sql);
                    $this->db->execute();
                }

                $this->db->commit();
                $response['status'] = true;
        }catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = 'Error al insertar en la base de datos';
            $this->db->rollBack();
        }
        return $response;
            
    }



    /*------------------FUNCIONES PARA FILTRADO Y BÚSQUEDA------------------*/
    //obtener el total de páginas y de registros de la consulta
    public function getTotalPages($no_of_records_per_page, $from_where_sentence = "")
    {
        //quitamos todo aquello que este fuera de los parámetros para solo obtener el substring desde FROM
        $from_where_sentence = strstr($from_where_sentence, 'FROM');

        $sql_total_pages = "SELECT COUNT(*) as Num_Pages " . $from_where_sentence; //total registros
        $this->db->query($sql_total_pages);      //prepararando query
        $total_rows = $this->db->register()->Num_Pages; //ejecutando query y recuperando el valor obtenido
        $total_pages = ceil($total_rows / $no_of_records_per_page); //calculando el total de paginations

        $data['total_rows'] = $total_rows;
        $data['total_pages'] = $total_pages;
        return $data;
    }

    //obtener los registros de la pagina actual
    public function getDataCurrentPage($offset, $no_of_records_per_page, $from_where_sentence = "")
    {

        $pos = strpos($from_where_sentence, "SELECT");
        if ($pos !== false) {
            $sql = "";
            $sql.=$from_where_sentence;
          /*SIN PAGINACION 
            $sql = "";
            $sql.=$from_where_sentence;*/
          /*  $sql = "";
            $sql.=$from_where_sentence. " 
            LIMIT". $offset.",".$no_of_records_per_page.
            ";";*/
           // $sql=" \" ". $from_where_sentence . " \"; ";
           // $sql=htmlspecialchars_decode($sql);
        }
        else{
            $sql = "
                SELECT * "
            . $from_where_sentence . " 
                LIMIT $offset,$no_of_records_per_page
                ";
        }
        $this->db->query($sql);
        return $this->db->registers();
    }

    //genera la consulta where dependiendo del filtro
    public function generateFromWhereSentence($cadena = "", $filtro = '1')
    {
        $from_where_sentence = "";
        $pos = strpos($cadena, "SELECT");
        if ($pos !== false && $filtro==1) {
            $from_where_sentence =$cadena;
        }
        else{
            switch ($filtro) {
                case '1':   //general
                        $from_where_sentence .= "
                                            FROM vehiculos
                                            WHERE  (    FECHA_RECUPERACION LIKE '%" . $cadena . "%' OR 
                                                        ESTADO LIKE '%" . $cadena . "%' OR
                                                        ID_VEHICULO LIKE '%" . $cadena . "%' OR
                                                        NO_FICHA_R LIKE '%" . $cadena . "%' OR
                                                        NO_FICHA_V LIKE '%" . $cadena . "%' OR
                                                        COLONIA LIKE '%" . $cadena . "%' OR 
                                                        ZONA_EVENTO LIKE '%" . $cadena . "%' OR 
                                                        PRIMER_RESPONDIENTE LIKE '%" . $cadena . "%' OR 
                                                        MARCA LIKE '%" . $cadena . "%' OR 
                                                        SUBMARCA LIKE '%" . $cadena . "%' OR 
                                                        TIPO LIKE '%" . $cadena . "%' OR 
                                                        MODELO LIKE '%" . $cadena . "%' OR 
                                                        COLOR LIKE '%" . $cadena . "%')
                                                ";
                    break;
                    case '2':   //generalSELECT FROM vehiculos JOIN placas_vehiculos WHERE vehiculos.ID_VEHICULO=placas_vehiculos.NO_VEHICULO

                        $from_where_sentence .= "
                                            FROM vehiculos JOIN placas_vehiculos WHERE vehiculos.ID_VEHICULO=placas_vehiculos.NO_VEHICULO and 
                                              (         ESTADO LIKE '%" . $cadena . "%' OR
                                                        ID_VEHICULO LIKE '%" . $cadena . "%' OR
                                                        NO_FICHA_R LIKE '%" . $cadena . "%' OR
                                                        NO_FICHA_V LIKE '%" . $cadena . "%' OR
                                                        placas_vehiculos.PLACA LIKE '%" . $cadena . "%' OR
                                                        placas_vehiculos.PROCEDENCIA LIKE '%" . $cadena . "%' OR
                                                        placas_vehiculos.DESCRIPCION LIKE '%" . $cadena . "%' OR
                                                        MARCA LIKE '%" . $cadena . "%' OR 
                                                        SUBMARCA LIKE '%" . $cadena . "%' OR 
                                                        TIPO LIKE '%" . $cadena . "%' OR 
                                                        MODELO LIKE '%" . $cadena . "%' OR 
                                                        COLOR LIKE '%" . $cadena . "%' OR 
                                                        PLACA LIKE '%" . $cadena . "%')
                                                ";
                    break;
                    case '3':   //general
                        $from_where_sentence .= "
                                            FROM vehiculos JOIN no_serie_vehiculos WHERE vehiculos.ID_VEHICULO=no_serie_vehiculos.NO_VEHICULO and 
                                              (         ESTADO LIKE '%" . $cadena . "%' OR
                                                        ID_VEHICULO LIKE '%" . $cadena . "%' OR
                                                        NO_FICHA_R LIKE '%" . $cadena . "%' OR
                                                        NO_FICHA_V LIKE '%" . $cadena . "%' OR
                                                        no_serie_vehiculos.DESCRIPCION LIKE '%" . $cadena . "%' OR
                                                        no_serie_vehiculos.NO_SERIE LIKE '%" . $cadena . "%' OR
                                                        MARCA LIKE '%" . $cadena . "%' OR 
                                                        SUBMARCA LIKE '%" . $cadena . "%' OR 
                                                        TIPO LIKE '%" . $cadena . "%' OR 
                                                        MODELO LIKE '%" . $cadena . "%' OR 
                                                        COLOR LIKE '%" . $cadena . "%')
                                                ";
                    break;
            }
            $from_where_sentence .= $this->getFechaCondition();
        }
        return $from_where_sentence;
    }

    public function getRemisionDByCadena($cadena, $filtro = '1')
    {
        //CONSULTA COINCIDENCIAS DE CADENA PARA EVENTOS DELICTIVOS
        if (!is_numeric($filtro) || !($filtro >= MIN_FILTRO_VE) || !($filtro <= MAX_FILTRO_VE))
            $filtro = 1;

        //sentencia from_where para hacer la busqueda por la cadena ingresada
        $from_where_sentence = $this->generateFromWhereSentence($cadena, $filtro);
        $numPage = 1;
        $no_of_records_per_page = NUM_MAX_REG_PAGE; //total de registros por pagination
        $offset = ($numPage - 1) * $no_of_records_per_page; // desplazamiento conforme a la pagina

        $results = $this->getTotalPages($no_of_records_per_page, $from_where_sentence);  //total de páginas conforme a la busqueda
        //info de retorno para la creacion de los links conforme a la cadena ingresada
        $data['rows_Vehs'] = $this->getDataCurrentPage($offset, $no_of_records_per_page, $from_where_sentence);   //se obtiene la información de la página actual
        $data['numPage'] = $numPage; //numero pag actual para la pagination footer
        $data['total_pages'] = $results['total_pages']; //total pages para la pagination
        $data['total_rows'] = $results['total_rows'];   //total de registro hallados

        return $data;
    }

    //obtener todos los registros de un cierto filtro para su exportación
    public function getAllInfoRemisionDByCadena($from_where_sentence = "")
    {
        $pos = strpos($from_where_sentence, "SELECT");
        if ($pos !== false) {
            $sqlAux=$from_where_sentence;
        }
        else{
            $sqlAux = "SELECT *"
            . $from_where_sentence . "
                    ";  //query a la DB
        }
        $this->db->query($sqlAux); 
        return $this->db->registers();      //retorna todos los registros devueltos por la consulta
    }
    public function getAllPlacas($no_v)
    {
        
        $sql = "SELECT * from placas_vehiculos WHERE NO_VEHICULO=".$no_v."";
        $this->db->query($sql); 
        return $this->db->registers();      //retorna todos los registros devueltos por la consulta
    }
    public function getAllNIV($no_v)
    {
        
        $sql = "SELECT * from no_serie_vehiculos WHERE NO_VEHICULO=".$no_v."";
        $this->db->query($sql); 
        return $this->db->registers();      //retorna todos los registros devueltos por la consulta
    }
    //complementaria de getAll para vista general para exportación EXCEL

    //función auxiliar para filtrar por un rango de fechas específicado por el usuario
    public function getFechaCondition()
    {
        $cad_fechas = "";
        if (isset($_SESSION['userdata']->rango_inicio_veh) && isset($_SESSION['userdata']->rango_fin_veh)) { //si no ingresa una fecha se seleciona el día de hoy como máximo
            $rango_inicio = $_SESSION['userdata']->rango_inicio_veh;
            $rango_fin = $_SESSION['userdata']->rango_fin_veh;
            $cad_fechas = " AND 
                            FECHA_PUESTA_DISPOSICION >= '" . $rango_inicio . "'  AND 
                            FECHA_PUESTA_DISPOSICION <= '" . $rango_fin . "' 
                            ";
        }
        return $cad_fechas;
    }
    public function getVehiculos($no_vehiculo_editar){
        try {
            $this->db->beginTransaction();
            $sql = "SELECT 	* FROM vehiculos
                    WHERE vehiculos.ID_VEHICULO = " . $no_vehiculo_editar;

            $this->db->query($sql);
            $data['vehiculo'] = $this->db->register();

            $sql = "SELECT * FROM placas_vehiculos WHERE NO_VEHICULO =" . $no_vehiculo_editar;
            $this->db->query($sql);
            $data['placas'] = $this->db->registers();

            $sql = "SELECT * FROM no_serie_vehiculos WHERE NO_VEHICULO =" . $no_vehiculo_editar;
            $this->db->query($sql);
            $data['nivs'] = $this->db->registers();

            $sql = "SELECT * FROM imagen_vehiculos WHERE No_vehiculo =" . $no_vehiculo_editar;
            $this->db->query($sql);
            $data['fotos'] = $this->db->registers();
            $this->db->commit();

        } catch (Exception $e) {
            echo $e;
            $this->db->rollBack();
        }
        return $data;

    }
    public function getVehiculoFicha($no_vehiculo_editar,$ficha)
    {
        try {
            $this->db->beginTransaction();
            $sql = "SELECT 	* FROM vehiculos
                    WHERE vehiculos.ID_VEHICULO = " . $no_vehiculo_editar;

            $this->db->query($sql);
            $data['vehiculo'] = $this->db->register();

            $sql = "SELECT * FROM placas_vehiculos WHERE NO_VEHICULO =" . $no_vehiculo_editar;
            $this->db->query($sql);
            $data['placas'] = $this->db->registers();

            $sql = "SELECT * FROM no_serie_vehiculos WHERE NO_VEHICULO =" . $no_vehiculo_editar;
            $this->db->query($sql);
            $data['nivs'] = $this->db->registers();

            $sql = "select CONCAT_WS( '', detenido.Nombre, ' ',detenido.Ap_Paterno,' ', detenido.Ap_Materno) AS 
            nombre_completo from remision join detenido on remision.No_Remision=detenido.No_Remision join 
            vehiculo_remision on remision.No_Remision=vehiculo_remision.No_Remision where No_ficha=" . $ficha;
            $this->db->query($sql);
            $data['responsable'] = $this->db->registers();

            $sql = "select DISTINCT elemento_participante_remision.Sector_Area from remision join 
            elemento_participante_remision on remision.No_Remision=elemento_participante_remision.No_Remision 
            where elemento_participante_remision.En_Colaboracion=1 and No_ficha=" . $ficha;
            $this->db->query($sql);
            $data['colaboracion'] = $this->db->registers();

            $sql = "SELECT * FROM imagen_vehiculos WHERE No_vehiculo =" . $no_vehiculo_editar;
            $this->db->query($sql);
            $data['fotos'] = $this->db->registers();

            $this->db->commit();

        } catch (Exception $e) {
            echo $e;
            $this->db->rollBack();
        }
        return $data;
    }

    public function getVehiculosFicha($no_vehiculo_editar,$ficha)
    {
        try {
            $this->db->beginTransaction();
            $sql = "SELECT 	* FROM vehiculos
                    WHERE vehiculos.ID_VEHICULO = " . $no_vehiculo_editar;

            $this->db->query($sql);
            $data['vehiculo'] = $this->db->register();

            $sql = "SELECT * FROM placas_vehiculos WHERE NO_VEHICULO =" . $no_vehiculo_editar;
            $this->db->query($sql);
            $data['placas'] = $this->db->registers();

            $sql = "SELECT * FROM no_serie_vehiculos WHERE NO_VEHICULO =" . $no_vehiculo_editar;
            $this->db->query($sql);
            $data['nivs'] = $this->db->registers();

            $sql = "select CONCAT_WS( '', detenido.Nombre, ' ',detenido.Ap_Paterno,' ', detenido.Ap_Materno) AS 
            nombre_completo from remision join detenido on remision.No_Remision=detenido.No_Remision join 
            vehiculo_remision on remision.No_Remision=vehiculo_remision.No_Remision where No_ficha=" . $ficha;
            $this->db->query($sql);
            $data['responsable'] = $this->db->registers();

            $sql = "select DISTINCT elemento_participante_remision.Sector_Area from remision join 
            elemento_participante_remision on remision.No_Remision=elemento_participante_remision.No_Remision 
            where elemento_participante_remision.En_Colaboracion=1 and No_ficha=" . $ficha;
            $this->db->query($sql);
            $data['colaboracion'] = $this->db->registers();

            $sql = "SELECT * FROM imagen_vehiculos WHERE No_vehiculo =" . $no_vehiculo_editar;
            $this->db->query($sql);
            $data['fotos'] = $this->db->registers();
            $this->db->commit();

        } catch (Exception $e) {
            echo $e;
            $this->db->rollBack();
        }
        return $data;
    }
    public function getTodosApartados($rows)
    {
        foreach ($rows as $key => $row) {
            $data['Vehiculo'][$key] = '';
            $data['placas'][$key] = '';
            $sql = "
                    SELECT placas_vehiculos.PLACA,CONCAT_WS('DESCRIPCION: ',placas_vehiculos.DESCRIPCION,'PROCEDENCIA ',placas_vehiculos.PROCEDENCIA) AS PLACAS_VEHICULOS
                    FROM placas_vehiculos
                    WHERE placas_vehiculos.NO_VEHICULO = $row->ID_VEHICULO
                    ";
            $this->db->query($sql);
            $aux1 = $this->db->registers();

            foreach ($aux1 as $vehiculo) {
                $data['placas'][$key] .= $vehiculo->PLACA. " ".$vehiculo->PLACAS_VEHICULOS . ", ";
            }

        }
    }
    public function getUltimasFichas(){
        try {
            $this->db->beginTransaction();
            $sql = "SELECT NO_FICHA_V FROM vehiculos ORDER BY NO_FICHA_V DESC LIMIT 10";
            $this->db->query($sql);
            $resultado = $this->db->registers();
            $this->db->commit();

        } catch (Exception $e) {
            echo $e;
            $this->db->rollBack();
        }
        return $resultado;
    }
    public function getFotos($post)
    {
        try {
            $this->db->beginTransaction();
            $sql = "SELECT * FROM imagen_vehiculos WHERE No_vehiculo = " . $post['id_vehiculo'] . " AND Tipo = '" . $post['tipo']  . "'";
            $this->db->query($sql);
            if ($this->db->register()) {
                $response['data'] = $this->db->register();
                $response['status'] = true;
            } else {
                $response['error_message'] = 'No se encontraron registros';
                $response['status'] = false;
            }
            /* $response['data'] = $this->db->register(); */

            $this->db->commit();
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollBack();
        }

        return $response;
    }
    public function updateFotos($post, $id_vehiculo, $name)
    {
        $response['status'] = true;
        $date = date("Ymdhis");
        $tipo = $post['tipo'];
        $name = $name . "?v=" . $date;
        $response['nameFile'] = $name;
        try {
            $this->db->beginTransaction();

            $sql = "SELECT * FROM imagen_vehiculos WHERE No_vehiculo = " . $id_vehiculo . " AND Tipo = '" . $tipo . "'";
            $this->db->query($sql);
            if ($this->db->register()) {
                $sql = "UPDATE imagen_vehiculos SET Path_Imagen = '" . trim($name) . "' WHERE No_vehiculo = " . $id_vehiculo . " AND Tipo = '" . $tipo . "'";
                $this->db->query($sql);
                $response['status'] = true;
                $this->db->execute();
            } else {
                $sql = "INSERT INTO imagen_vehiculos(
                    No_vehiculo,
                    Tipo,
                    Path_Imagen
                )
                VALUES(
                    trim($id_vehiculo),
                    '" . trim($tipo) . "',
                    '" . trim($name) . "'
                )";
                $this->db->query($sql);
                $this->db->execute();

                $response['status'] = true;
            }

            $this->db->commit();
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollBack();
        }

        return $response;
    }
    public function deleteFotos($id_vehiculo, $tipo)
    {
        try {
            $this->db->beginTransaction();

            $sql = "SELECT * FROM imagen_vehiculos WHERE No_vehiculo = " . $id_vehiculo . " AND Tipo = '" . $tipo . "'";
            $this->db->query($sql);
            if ($this->db->register()) {
                $id = $this->db->register()->Id_imagenvh;
                $sql = "DELETE FROM imagen_vehiculos WHERE Id_imagenvh = " . $id;
                $this->db->query($sql);
                $this->db->execute();

                $response['status'] = true;
            } else {
                $response['status'] = false;
                $response['error_message'] = 'No se encontro registro con estas caracteristicas';
            }

            $this->db->commit();
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollBack();
        }

        return $response;
    }
    public function updateNameFile($tipo, $name, $id_vehiculo)
    {
        try {
            $this->db->beginTransaction();
            $sql = "UPDATE imagen_vehiculos SET Path_Imagen = '" . trim($name) . "' WHERE No_vehiculo = " . $id_vehiculo . " AND Tipo = '" . $tipo . "'";
            $this->db->query($sql);
            $response['status'] = true;
            $this->db->execute();

            $this->db->commit();
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollBack();
        }

        return $response;
    }
    public function getAllFotos($no_vehiculo_ver)
    {
        try {
            $this->db->beginTransaction();

            $sql = "SELECT * FROM imagen_vehiculos WHERE No_vehiculo =" . $no_vehiculo_ver;
            $this->db->query($sql);

            $response['status'] = true;
            $response['fotos'] = $this->db->registers();

            $this->db->commit();
        } catch (Exception $e) {
            $response['status'] = true;
            $response['error_message'] = $e;
            $this->db->rollBack();
        }

        return $response;
    }
    public function sacar_primer($post)
    {
        try {
            $this->db->beginTransaction();
            $sql = "select DISTINCT elemento_participante_remision.Sector_Area from remision join elemento_participante_remision on remision.No_Remision=elemento_participante_remision.No_Remision where elemento_participante_remision.Tipo_Llamado=1 and No_ficha=" . $post['ficha_buscar'];
            $this->db->query($sql);
            if(isset($this->db->register()->Sector_Area))
                $sector = $this->db->register()->Sector_Area;
            else 
                $sector="null";
            $response['sector']=$sector;
            $response['status'] = true;
        } catch (Exception $e) {
            $response['sector']="null";
            $response['status'] = false;
            $response['error_message'] = 'Error al insertar en la base de datos';
            $this->db->rollBack();
        }
        return $response;
    }

}
