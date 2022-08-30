<?php

class Inspeccion{

    public $db; //variable para instanciar el objeto PDO
    public function __construct(){
        $this->db = new Base(); //se instancia el objeto con los métodos de PDO
    }


    public function getZonaSectorByGrupo($grupo){
        $grupo = strtoupper($grupo);
        $sql = "SELECT Valor_Grupo FROM catalogo_grupos_inspecciones WHERE Tipo_Grupo = '".$grupo."'";
        $this->db->query($sql);
        $resultado =  $this->db->registers();
        return $resultado;
    }

/*-------------------------FUNCIONES NECESARIAS PARA FILTRADO DE INFORMACIÓN------------------------------*/ 
    //obtener el total de páginas y de registros de la consulta
    public function getTotalPages($no_of_records_per_page,$from_where_sentence = ""){
        //quitamos todo aquello que este fuera de los parámetros para solo obtener el substring desde FROM
        $from_where_sentence = strstr($from_where_sentence, 'FROM');

        $sql_total_pages = "SELECT COUNT(*) as Num_Pages ".$from_where_sentence; //total registros
        $this->db->query($sql_total_pages);      //prepararando query
        $total_rows = $this->db->register()->Num_Pages; //ejecutando query y recuperando el valor obtenido
        $total_pages = ceil($total_rows / $no_of_records_per_page); //calculando el total de paginations

        $data['total_rows'] = $total_rows;
        $data['total_pages'] = $total_pages;
        return $data;
    }

    //obtener los registros de la pagina actual
    public function getDataCurrentPage($offset,$no_of_records_per_page,$from_where_sentence = ""){

        $sql = "
                SELECT * "
                .$from_where_sentence." 
                LIMIT $offset,$no_of_records_per_page
                ";

        $this->db->query($sql);
        return $this->db->registers();
    }

    //genera la consulta where dependiendo del filtro
    public function generateFromWhereSentence($cadena="",$filtro='1'){

        $from_where_sentence = "";
        switch ($filtro) {
            case '1':   //general
                
                $from_where_sentence.= " FROM inspeccion_view 
                                         WHERE (Id_Inspeccion LIKE '%".$cadena."%' OR 
                                                Quien_Solicita LIKE '%".$cadena."%' OR 
                                                Grupo LIKE '%".$cadena."%' OR 
                                                Zona_Sector LIKE '%".$cadena."%' OR 
                                                Motivo_Inspeccion LIKE '%".$cadena."%' OR 
                                                Telefono_Radio LIKE '%".$cadena."%' OR 
                                                Resultado_Inspeccion LIKE '%".$cadena."%' OR 
                                                Personas_Inspeccion LIKE '%".$cadena."%' OR 
                                                Vehiculo_Inspeccionado LIKE '%".$cadena."%' OR 
                                                Colocacion_Placa LIKE '%".$cadena."%' OR 
                                                Nombre_Usuario LIKE '%".$cadena."%' OR 
                                                Fecha_Hora_Inspeccion LIKE '%".$cadena."%') 
                                            ";
                
            break;
            case '2':   //solo personas
                
                $from_where_sentence.= " FROM inspeccion_view 
                                         WHERE (Id_Inspeccion LIKE '%".$cadena."%' OR 
                                                Quien_Solicita LIKE '%".$cadena."%' OR 
                                                Grupo LIKE '%".$cadena."%' OR 
                                                Zona_Sector LIKE '%".$cadena."%' OR 
                                                Motivo_Inspeccion LIKE '%".$cadena."%' OR 
                                                Telefono_Radio LIKE '%".$cadena."%' OR 
                                                Resultado_Inspeccion LIKE '%".$cadena."%' OR 
                                                Personas_Inspeccion LIKE '%".$cadena."%' OR
                                                Nombre_Usuario LIKE '%".$cadena."%' OR 
                                                Fecha_Hora_Inspeccion LIKE '%".$cadena."%') AND 
                                                Colocacion_Placa <=> NULL 
                                            ";
                
            break;
            case '3':   //solo vehículos
                
                $from_where_sentence.= " FROM inspeccion_view 
                                         WHERE (Id_Inspeccion LIKE '%".$cadena."%' OR 
                                                Quien_Solicita LIKE '%".$cadena."%' OR 
                                                Grupo LIKE '%".$cadena."%' OR 
                                                Zona_Sector LIKE '%".$cadena."%' OR 
                                                Motivo_Inspeccion LIKE '%".$cadena."%' OR 
                                                Telefono_Radio LIKE '%".$cadena."%' OR 
                                                Resultado_Inspeccion LIKE '%".$cadena."%' OR 
                                                Vehiculo_Inspeccionado LIKE '%".$cadena."%' OR 
                                                Colocacion_Placa LIKE '%".$cadena."%' OR 
                                                Nombre_Usuario LIKE '%".$cadena."%' OR 
                                                Fecha_Hora_Inspeccion LIKE '%".$cadena."%') AND 
                                                Alias_Inspeccionado <=> NULL 
                                            ";
                
            break;
            case '4':   //personas y vehículos
                
                $from_where_sentence.= " FROM inspeccion_view 
                                         WHERE (Id_Inspeccion LIKE '%".$cadena."%' OR 
                                                Quien_Solicita LIKE '%".$cadena."%' OR 
                                                Grupo LIKE '%".$cadena."%' OR 
                                                Zona_Sector LIKE '%".$cadena."%' OR 
                                                Motivo_Inspeccion LIKE '%".$cadena."%' OR 
                                                Telefono_Radio LIKE '%".$cadena."%' OR 
                                                Resultado_Inspeccion LIKE '%".$cadena."%' OR 
                                                Personas_Inspeccion LIKE '%".$cadena."%' OR 
                                                Vehiculo_Inspeccionado LIKE '%".$cadena."%' OR 
                                                Colocacion_Placa LIKE '%".$cadena."%' OR 
                                                Nombre_Usuario LIKE '%".$cadena."%' OR 
                                                Fecha_Hora_Inspeccion LIKE '%".$cadena."%') AND 
                                                Colocacion_Placa <> '' AND 
                                                Alias_Inspeccionado <> ''  
                                            ";
                
            break;

                /*
                    SELECT * FROM evento_delictivo_view WHERE Fecha >= '2020-01-01' AND Fecha <= '2020-03-30'
                */
        }

        //where complemento fechas (si existe)
        $from_where_sentence.= $this->getFechaCondition();
        //order by
        $from_where_sentence.= " ORDER BY Id_Inspeccion DESC";   
        return $from_where_sentence;
    }

    public function getInspeccionByCadena($cadena,$filtro='1'){
        //CONSULTA COINCIDENCIAS DE CADENA PARA EVENTOS DELICTIVOS
        if (!is_numeric($filtro) || !($filtro>=MIN_FILTRO_INSP) || !($filtro<=MAX_FILTRO_INSP))
            $filtro = 1;
        
        //sentencia from_where para hacer la busqueda por la cadena ingresada
        $from_where_sentence = $this->generateFromWhereSentence($cadena,$filtro);
        $numPage = 1;
        $no_of_records_per_page = NUM_MAX_REG_PAGE; //total de registros por pagination
        $offset = ($numPage-1) * $no_of_records_per_page; // desplazamiento conforme a la pagina

        $results = $this->getTotalPages($no_of_records_per_page,$from_where_sentence);  //total de páginas conforme a la busqueda
        //info de retorno para la creacion de los links conforme a la cadena ingresada
        $data['rows_Inspecciones'] = $this->getDataCurrentPage($offset,$no_of_records_per_page,$from_where_sentence);   //se obtiene la información de la página actual
        $data['numPage'] = $numPage; //numero pag actual para la pagination footer
        $data['total_pages'] = $results['total_pages']; //total pages para la pagination
        $data['total_rows'] = $results['total_rows'];   //total de registro hallados
        
        return $data;
    }
    
    //obtener todos los registros de un cierto filtro para su exportación
    public function getAllInfoInspeccionByCadena($from_where_sentence = ""){
        $sqlAux = "SELECT *"
                    .$from_where_sentence."
                    ";  //query a la DB
        $this->db->query($sqlAux);          //se prepara el query mediante PDO
        return $this->db->registers();      //retorna todos los registros devueltos por la consulta
    }

    //función auxiliar para filtrar por un rango de fechas específicado por el usuario
    public function getFechaCondition(){
        $cad_fechas = "";
        if (isset($_SESSION['userdata']->rango_inicio_insp) && 
            isset($_SESSION['userdata']->rango_fin_insp) && 
            isset($_SESSION['userdata']->rango_hora_inicio_insp) && 
            isset($_SESSION['userdata']->rango_hora_fin_insp)) { //si no ingresa una fecha se seleciona el día de hoy como máximo

            $rango_inicio = $_SESSION['userdata']->rango_inicio_insp;
            $rango_fin = $_SESSION['userdata']->rango_fin_insp;
            $rango_hora_inicio = $_SESSION['userdata']->rango_hora_inicio_insp;
            $rango_hora_fin = $_SESSION['userdata']->rango_hora_fin_insp;

            $cad_fechas = " AND 
                            Fecha_Hora_Inspeccion >= '".$rango_inicio." ".$rango_hora_inicio.":00'  AND 
                            Fecha_Hora_Inspeccion <= '".$rango_fin." ".$rango_hora_fin.":59' 
                            ";
        }

        return $cad_fechas; 
    }
/*-------------------------FIN FUNCIONES NECESARIAS PARA FILTRADO DE INFORMACIÓN------------------------------*/ 


    //funcone para insertar nueva inspección
    public function insertNuevaInspeccion($post){
        //valores iniciales de retorno
        $data['status'] = true;
        $data['Id_Inspeccion'] = -1;
        try{
            /*orden de inserción:
                ubicación
                inspección
                persona/vehículo
            */
            $this->db->beginTransaction();  //inicia la transaction

                $sql = "INSERT
                        INTO ubicacion(
                            Colonia,
                            Calle_1,
                            Calle_2,
                            No_Ext,
                            No_Int,
                            CP,
                            Coordenada_X,
                            Coordenada_Y
                        )
                        VALUES(
                            '".$post['Colonia']."',
                            '".$post['Calle_1']."',
                            '".$post['Calle_2']."',
                            '".$post['No_Ext']."',
                            '".$post['No_Int']."',
                            '".$post['id_cp']."',
                            '".$post['Coordenada_X']."',
                            '".$post['Coordenada_Y']."'
                        )
                ";
                $this->db->query($sql);
                $this->db->execute();
                $this->db->query("SELECT LAST_INSERT_ID() as Id_Ubicacion"); //se recupera el id de ubicacion creado recientemente
                $id_ubicacion = $this->db->register()->Id_Ubicacion;
                $id_user = $_SESSION['userdata']->Id_Usuario; //get id de session

                $fecha_hora_inspeccion = $post['Fecha_Inspeccion']." ".$post['Hora_Inspeccion'];
                $sql = "INSERT
                        INTO inspeccion(
                            Id_Usuario,
                            Id_Ubicacion,
                            Quien_Solicita,
                            Grupo,
                            Zona_Sector,
                            Clave_Num_Solicitante,
                            Unidad,
                            Telefono_Radio,
                            Motivo_Inspeccion,
                            Resultado_Inspeccion,
                            Fecha_Hora_Inspeccion
                        )
                        VALUES(
                            ".$id_user.",
                            ".$id_ubicacion.",
                            '".$post['Quien_Solicita']."',
                            '".$post['Grupo']."',
                            '".$post['Zona_Sector']."',
                            '".$post['Clave_Num_Solicitante']."',
                            '".$post['Unidad']."',
                            '".$post['Telefono_Radio']."',
                            '".$post['Motivo_Inspeccion']."',
                            '".$post['Resultado_Inspeccion']."',
                            '".$fecha_hora_inspeccion."'
                        )
                        ";
                $this->db->query($sql);
                $this->db->execute();
                $this->db->query("SELECT LAST_INSERT_ID() as Id_Inspeccion"); //se recupera el id de inspeccion creado recientemente
                $id_inspeccion = $this->db->register()->Id_Inspeccion;

                if (isset($post['Check_Persona'])) {

                    // $sql = "DELETE FROM persona_inspeccion WHERE Id_Inspeccion = ".$id_inspeccion;
                    // $this->db->query($sql);
                    // $this->db->execute();
                    $personasArray = json_decode($post['personas']);
                    foreach ($personasArray as $persona) {
                        //se inserta persona
                        $sql = "INSERT
                        INTO persona_inspeccion(
                            Id_Inspeccion,
                            Nombre,
                            Ap_Paterno,
                            Ap_Materno,
                            Alias,
                            Fecha_Nacimiento
                        )
                        VALUES(
                            ".$id_inspeccion.",
                            '".$this->limpiarEspaciosCadena($persona->Nombre)."',
                            '".$this->limpiarEspaciosCadena($persona->Ap_Paterno)."',
                            '".$this->limpiarEspaciosCadena($persona->Ap_Materno)."',
                            '".$this->limpiarEspaciosCadena($persona->Alias)."',
                            '".$persona->Fecha_Nacimiento."'
                        )
                        ";
                        $this->db->query($sql);
                        $this->db->execute();
                    }
                    
                }
                if (isset($post['Check_Vehiculo'])) {
                   //se inserta vehiculo
                    $sql = "INSERT
                            INTO vehiculo_inspeccion(
                                Id_Inspeccion,
                                Marca,
                                Modelo,
                                Placas_Vehiculo,
                                Colocacion_Placa,
                                NIV,
                                Color,
                                Tipo,
                                Submarca
                            )
                            VALUES(
                                ".$id_inspeccion.",
                                '".mb_strtoupper($post['Marca'])."',
                                '".$post['Modelo']."',
                                '".mb_strtoupper($post['Placas_Vehiculo'])."',
                                '".$post['Colocacion_Placa']."',
                                '".$post['NIV']."',
                                '".mb_strtoupper($post['Color'])."',
                                '".mb_strtoupper($post['Tipo'])."',
                                '".mb_strtoupper($post['Submarca'])."'
                            )
                            ";
                    $this->db->query($sql);
                    $this->db->execute();
                }

                $data['Id_Inspeccion'] = $id_inspeccion;
            $this->db->commit(); //se realiza los commits de cada query ejecutado correctamente
        }catch(Exception $e){
            // echo "Error, ".$e."\nParece que hubo un error en la base de datos. Recomendación: asegúrese de no insertar emojis en algun campo del formulario";
            $data['status'] = false;
            $this->db->rollBack(); //rollBack de seguridad por si ocurre un fallo
        }
        return $data;
    }

    //funcion para insertar imgs a la DB inspecciones
    public function insertImageInspeccion($id_inspeccion = null, $img_name = null){
        if ($id_inspeccion == null || $img_name == null)
            return false;
        
        $sql = "INSERT 
                INTO imagen_inspeccion (Id_Inspeccion,Path_Imagen)
                VALUES(
                     ".$id_inspeccion.",
                    '".$img_name."'
                )";
        $this->db->query($sql);
        return $this->db->execute();
    }

    //funcion para módulo de ver inspección
    public function getInspeccionInfo($id_inspeccion){
        $sql = "
                SELECT  inspeccion.*,
                        CONCAT(persona_inspeccion.Nombre,' ',persona_inspeccion.Ap_Paterno,' ',persona_inspeccion.Ap_Materno) AS Nombre_Inspeccionado,
                        vehiculo_inspeccion.Marca,
                        vehiculo_inspeccion.Modelo,
                        vehiculo_inspeccion.Placas_Vehiculo,
                        vehiculo_inspeccion.Colocacion_Placa,
                        vehiculo_inspeccion.NIV,
                        vehiculo_inspeccion.Tipo,
                        vehiculo_inspeccion.Color,
                        vehiculo_inspeccion.Submarca,
                        ubicacion.Calle_1,
                        ubicacion.Calle_2,
                        ubicacion.Colonia,
                        ubicacion.No_Ext,
                        ubicacion.No_Int,
                        ubicacion.Coordenada_X,
                        ubicacion.Coordenada_Y,
                        ubicacion.CP,
                        GROUP_CONCAT(
                                    imagen_inspeccion.Id_Imagen_I,',',
                                    imagen_inspeccion.Tipo,',',
                                    imagen_inspeccion.Path_Imagen SEPARATOR '|') AS Imagenes_Inspeccion
                FROM inspeccion
                LEFT JOIN ubicacion ON ubicacion.Id_Ubicacion = inspeccion.Id_Ubicacion
                LEFT JOIN persona_inspeccion ON persona_inspeccion.Id_Inspeccion = inspeccion.Id_Inspeccion
                LEFT JOIN vehiculo_inspeccion ON vehiculo_inspeccion.Id_Inspeccion = inspeccion.Id_Inspeccion
                LEFT JOIN imagen_inspeccion ON imagen_inspeccion.Id_Inspeccion = inspeccion.Id_Inspeccion
                WHERE inspeccion.Id_Inspeccion = $id_inspeccion
                GROUP BY inspeccion.Id_Inspeccion
                ";
        $this->db->query($sql);
        return $this->db->register();
    }

    public function getPersonasArray($id_inspeccion){
        $sql = "
                SELECT  persona_inspeccion.*,
                CONCAT(persona_inspeccion.Nombre,' ',persona_inspeccion.Ap_Paterno,' ',persona_inspeccion.Ap_Materno) AS Nombre_Inspeccionado  
                FROM persona_inspeccion
                WHERE persona_inspeccion.Id_Inspeccion = $id_inspeccion
                ORDER BY persona_inspeccion.Nombre;
                ";
        $this->db->query($sql);
        return $this->db->registers();
    }

    public function getImagesByIdInspeccion($id_inspeccion = null){
        if($id_inspeccion == null){
            return [];
        }
        $sql = "SELECT  	imagen_inspeccion.Id_Inspeccion,
                            imagen_inspeccion.Path_Imagen
                FROM imagen_inspeccion
                LEFT JOIN inspeccion ON inspeccion.Id_Inspeccion = imagen_inspeccion.Id_Inspeccion
                WHERE imagen_inspeccion.Id_Inspeccion = $id_inspeccion";
        $this->db->query($sql);
        $results = $this->db->registers();

        return ($results)?$results:[];
    }

    public function getImagesById($id_inspeccion){
        $sql = "
                SELECT Id_Imagen_I,Path_Imagen 
                FROM imagen_inspeccion 
                WHERE Id_Inspeccion = ".intval($id_inspeccion)."
                ";
        $this->db->query($sql);
        return $this->db->registers();
    }

    //actualizar la info de una inspección
    public function updateInspeccion($post){

        //valores iniciales de retorno
        $data['status'] = true;
        //$data['Id_Inspeccion'] = -1;
        try{
            $this->db->beginTransaction();  //inicia la transaction
                //update ubicación
                $sql = "UPDATE
                        ubicacion
                            SET Colonia = '".$post['Colonia']."',
                                Calle_1 = '".$post['Calle_1']."',
                                Calle_2 = '".$post['Calle_2']."',
                                No_Ext = '".$post['No_Ext']."',
                                No_Int = '".$post['No_Int']."',
                                CP = '".$post['id_cp']."',
                                Coordenada_X = '".$post['Coordenada_X']."',
                                Coordenada_Y = '".$post['Coordenada_Y']."'
                        WHERE Id_Ubicacion = ".$post['Id_Ubicacion']."
                ";
                $this->db->query($sql);
                $this->db->execute();
                
                //update inspección
                $fecha_hora_inspeccion = $post['Fecha_Inspeccion']." ".$post['Hora_Inspeccion'];
                $sql = "UPDATE
                        inspeccion
                            SET Quien_Solicita = '".$post['Quien_Solicita']."',
                                Grupo = '".$post['Grupo']."',
                                Zona_Sector = '".$post['Zona_Sector']."',
                                Clave_Num_Solicitante = '".$post['Clave_Num_Solicitante']."',
                                Unidad = '".$post['Unidad']."',
                                Telefono_Radio = '".$post['Telefono_Radio']."',
                                Motivo_Inspeccion = '".$post['Motivo_Inspeccion']."',
                                Resultado_Inspeccion = '".$post['Resultado_Inspeccion']."',
                                Fecha_Hora_Inspeccion = '".$fecha_hora_inspeccion."'
                        WHERE Id_Inspeccion = ".$post['Id_Inspeccion']."
                ";
                $this->db->query($sql);
                $this->db->execute();
                
                //se borran registros de persona y vehículo para evitar hacer más código
                $this->db->query("DELETE FROM persona_inspeccion WHERE Id_Inspeccion = ".$post['Id_Inspeccion']);
                $this->db->execute();
                $this->db->query("DELETE FROM vehiculo_inspeccion WHERE Id_Inspeccion = ".$post['Id_Inspeccion']);
                $this->db->execute();

                //checar persona y vehículo para update
                if (isset($post['Check_Persona'])) {
                    // $data['personas_check'] = true;
                    $sql = "DELETE FROM persona_inspeccion WHERE Id_Inspeccion = ".$post['Id_Inspeccion'];
                    $this->db->query($sql);
                    $this->db->execute();
                    $personasArray = json_decode($post['personas']);
                    foreach ($personasArray as $persona) {
                        //se inserta persona
                        $sql = "INSERT
                        INTO persona_inspeccion(
                            Id_Inspeccion,
                            Nombre,
                            Ap_Paterno,
                            Ap_Materno,
                            Alias,
                            Fecha_Nacimiento
                        )
                        VALUES(
                            ".$post['Id_Inspeccion'].",
                            '".$this->limpiarEspaciosCadena($persona->Nombre)."',
                            '".$this->limpiarEspaciosCadena($persona->Ap_Paterno)."',
                            '".$this->limpiarEspaciosCadena($persona->Ap_Materno)."',
                            '".$this->limpiarEspaciosCadena($persona->Alias)."',
                            '".$persona->Fecha_Nacimiento."'
                        )
                        ";
                        $this->db->query($sql);
                        $this->db->execute();
                    }
                }
                if (isset($post['Check_Vehiculo'])) {
                    //se inserta vehiculo
                    $sql = "INSERT
                            INTO vehiculo_inspeccion(
                                Id_Inspeccion,
                                Marca,
                                Modelo,
                                Placas_Vehiculo,
                                Colocacion_Placa,
                                NIV,
                                Color,
                                Tipo,
                                Submarca
                            )
                            VALUES(
                                ".$post['Id_Inspeccion'].",
                                '".$post['Marca']."',
                                '".$post['Modelo']."',
                                '".$post['Placas_Vehiculo']."',
                                '".$post['Colocacion_Placa']."',
                                '".$post['NIV']."',
                                '".$post['Color']."',
                                '".$post['Tipo']."',
                                '".$post['Submarca']."'
                            )
                            ";
                    $this->db->query($sql);
                    $this->db->execute();
                }

                //$data['Id_Inspeccion'] = $id_inspeccion;
            $this->db->commit(); //se realiza los commits de cada query ejecutado correctamente
        }catch(Exception $e){
            // echo "Error, un error ".$e;
            $data['status'] = false;
            $this->db->rollBack(); //rollBack de seguridad por si ocurre un fallo
        }
        return $data;
    }
    //borrar registro de cierta imagen
    public function deleteImageInspeccion($id_imagen = null){
        if ($id_imagen == null)
            return false;
        
        $sql = "DELETE FROM imagen_inspeccion 
                WHERE Id_Imagen_I = ".intval($id_imagen);
        $this->db->query($sql);
        return $this->db->execute();
    }


    /*--------------------GRÁFICA--------------------*/
    public function getCountZona($cadena = ''){
        $cadena = trim($cadena);
        $data['por_zonas'] = [];
        $data['total_personas'] = 0;
        $data['total_vehiculos'] = 0;

        
        $from_where_sentence = $this->generateFromWhereSentence($cadena,1); //se obtiene el from where sentence
        $sqlPerVeh = "SELECT Marca, Personas_Inspeccion $from_where_sentence"; //counsulta aux para conteo de personas y vehiculos por separado
        $indexAuxForOrderBy = intval(strlen(" ORDER BY Id_Inspeccion DESC")*-1); //se obtiene el tamaño de la cadena que no necesito para el count
        $from_where_sentence = substr($from_where_sentence, 0,intval($indexAuxForOrderBy)); //se quita ese fragmento de la cadena de order by 

        //select para conteo por zonas
        $sql = "SELECT inspeccion_view.Zona_Sector, COUNT(inspeccion_view.Zona_Sector) AS Num_Inspecciones 
                ".$from_where_sentence." 
                GROUP BY inspeccion_view.Zona_Sector 
                ORDER BY Num_Inspecciones DESC";

        $this->db->query($sql);
        $data['por_zonas'] = $this->db->registers();
        $data['por_zonas'] = ($data['por_zonas'])?$data['por_zonas']:[];

        //select para total de personas y vehículos
        $this->db->query($sqlPerVeh);
        $results = $this->db->registers();
        foreach ($results as $key => $row) {
            if($row->Marca != null){$data['total_vehiculos']++;}
            $personasArray = explode("|||",$row->Personas_Inspeccion);
            foreach($personasArray as $per){
                $data['total_personas']+= ($per)?1:0;
            }
        }
        
        return $data;
    }

    private function limpiarEspaciosCadena($cadena = null){
        if($cadena == null) return '';
        return implode(' ',array_filter(explode(' ',$cadena)));
    }
    public function getMarcas(){
        $sql = "SELECT Marca FROM catalogo_marca_vehiculos_io ORDER BY Marca ASC";
        $this->db->query($sql);
        $resultado = $this->db->registers();
        return $resultado;
    }
    public function getSubmarcas(){
        $sql = "SELECT Submarca FROM catalogo_submarcas_vehiculos ORDER BY Submarca ASC";
        $this->db->query($sql);
        $resultado = $this->db->registers();
        return $resultado;
    }
    public function getTipos(){
        $sql = "SELECT Tipo FROM catalogo_tipos_vehiculos ORDER BY Tipo ASC";
        $this->db->query($sql);
        $resultado = $this->db->registers();
        return $resultado;
    }


}

?>