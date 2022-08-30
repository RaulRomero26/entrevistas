<?php
class JuridicoM
{
    public $db;

    public function __construct()
    {
        $this->db = new Base();
    }

/*-------------------------FUNCIONES NECESARIAS PARA FILTRADO DE INFORMACIÓN------------------------------*/
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

        $sql = "
                SELECT * "
            . $from_where_sentence . " 
                LIMIT $offset,$no_of_records_per_page
                ";

        $this->db->query($sql);
        return $this->db->registers();
    }

    //genera la consulta where dependiendo del filtro
    public function generateFromWhereSentence($cadena = "", $filtro = '1')
    {

        $from_where_sentence = "";
        switch ($filtro) {
            case '1':   //general

                $from_where_sentence .= " FROM iph_view_filtro_1 
                                         WHERE (Id_Puesta LIKE '%" . $cadena . "%' OR 
                                                Num_Referencia LIKE '%" . $cadena . "%' OR 
                                                Folio_IPH LIKE '%" . $cadena . "%' OR 
                                                Fecha_Hora LIKE '%" . $cadena . "%' OR 
                                                Num_Expediente LIKE '%" . $cadena . "%' OR 
                                                Estatus_Cadena LIKE '%" . $cadena . "%' OR 
                                                Nombre_Usuario LIKE '%" . $cadena . "%' OR 
                                                Nombre_Primer_Respondiente LIKE '%" . $cadena . "%' OR 
                                                Ubicacion_Intervencion LIKE '%" . $cadena . "%' ) 
                                            ";

                break;
        }

        //where complemento fechas (si existe)
        $from_where_sentence .= $this->getFechaCondition();
        //order by
        $from_where_sentence .= " ORDER BY Id_Puesta DESC";
        return $from_where_sentence;
    }

    public function getJuridicoByCadena($cadena, $filtro = '1')
    {
        //CONSULTA COINCIDENCIAS DE CADENA PARA EVENTOS DELICTIVOS
        if (!is_numeric($filtro) || !($filtro >= MIN_FILTRO_JUR) || !($filtro <= MAX_FILTRO_JUR))
            $filtro = 1;

        //sentencia from_where para hacer la busqueda por la cadena ingresada
        $from_where_sentence = $this->generateFromWhereSentence($cadena, $filtro);
        $numPage = 1;
        $no_of_records_per_page = NUM_MAX_REG_PAGE; //total de registros por pagination
        $offset = ($numPage - 1) * $no_of_records_per_page; // desplazamiento conforme a la pagina

        $results = $this->getTotalPages($no_of_records_per_page, $from_where_sentence);  //total de páginas conforme a la busqueda
        //info de retorno para la creacion de los links conforme a la cadena ingresada
        $data['rows_Juridico'] = $this->getDataCurrentPage($offset, $no_of_records_per_page, $from_where_sentence);   //se obtiene la información de la página actual
        $data['numPage'] = $numPage; //numero pag actual para la pagination footer
        $data['total_pages'] = $results['total_pages']; //total pages para la pagination
        $data['total_rows'] = $results['total_rows'];   //total de registro hallados

        return $data;
    }

    //obtener todos los registros de un cierto filtro para su exportación
    public function getAllInfoJuridicoByCadena($from_where_sentence = "")
    {
        $sqlAux = "SELECT *"
            . $from_where_sentence . "
                    ";  //query a la DB
        $this->db->query($sqlAux);          //se prepara el query mediante PDO
        return $this->db->registers();      //retorna todos los registros devueltos por la consulta
    }

    //función auxiliar para filtrar por un rango de fechas específicado por el usuario
    public function getFechaCondition()
    {
        $cad_fechas = "";
        if (
            isset($_SESSION['userdata']->rango_inicio_jur) &&
            isset($_SESSION['userdata']->rango_fin_jur) &&
            isset($_SESSION['userdata']->rango_hora_inicio_jur) &&
            isset($_SESSION['userdata']->rango_hora_fin_jur)
        ) { //si no ingresa una fecha se seleciona el día de hoy como máximo

            $rango_inicio = $_SESSION['userdata']->rango_inicio_jur;
            $rango_fin = $_SESSION['userdata']->rango_fin_jur;
            $rango_hora_inicio = $_SESSION['userdata']->rango_hora_inicio_jur;
            $rango_hora_fin = $_SESSION['userdata']->rango_hora_fin_jur;

            $cad_fechas = " AND 
                            Fecha_Hora >= '" . $rango_inicio . " " . $rango_hora_inicio . ":00'  AND 
                            Fecha_Hora <= '" . $rango_fin . " " . $rango_hora_fin . ":59' 
                            ";
        }

        return $cad_fechas;
    }
/*-------------------------FIN FUNCIONES NECESARIAS PARA FILTRADO DE INFORMACIÓN------------------------------*/


    public function getNumberofTable($idPuesta, $tabla)
    {
        try {
            $sql = "SELECT COUNT(*) AS Numero FROM $tabla WHERE Id_Puesta = " . $idPuesta;
            $this->db->query($sql);
            return (int)($this->db->register()->Numero) + 1;
        } catch (Exception $e) {
            return -1;
        }
    }

    public function crearPuesta($post)
    {
        try {

            $this->db->beginTransaction();
            /* ----- ----- ----- Insertar primer respondiente ----- ----- ----- */
            $sql = "INSERT
                INTO iph_primer_respondiente(
                    Nombre_PR,
                    Ap_Paterno_PR,
                    Ap_Materno_PR,
                    Institucion,
                    Cargo,
                    Unidad_Arribo,
                    No_Control
                ) VALUES(
                    '" . trim($post['nombreElemento']) . "',
                    '" . trim($post['primerApellidoElemento']) . "',
                    '" . trim($post['segundoApellidoElemento']) . "',
                    '" . trim($post['adscripcionElemento']) . "',
                    '" . trim($post['cargoElemento']) . "',
                    '" . trim($post['unidadElemento']) . "',
                    '" . trim($post['numControl']) . "'
                )
            ";
            $this->db->query($sql);
            $this->db->execute();

            /* ----- ----- ----- Recuperar ID primer respondiente ----- ----- ----- */
            $this->db->query("SELECT LAST_INSERT_ID() as Id_Primer_Respondiente");
            $Id_Primer_Respondiente = $this->db->register()->Id_Primer_Respondiente;

            /* ----- ----- ----- Id usuario ----- ----- ----- */
            $user = $_SESSION['userdata']->Id_Usuario;

            $sql = "INSERT
                INTO iph_puesta_disposicion(
                    Id_Realiza_Puesta,
                    Id_Usuario,
                    Id_Primer_Respondiente
                ) VALUES(
                    " . trim($Id_Primer_Respondiente) . ",
                    " . trim($user) . ",
                    " . trim($Id_Primer_Respondiente) . "
                )
            ";
            $this->db->query($sql);
            $this->db->execute();

            /* ----- ----- ----- Recuperar ID puesta ----- ----- ----- */
            $this->db->query("SELECT LAST_INSERT_ID() as Id_Puesta");
            $Id_Puesta = $this->db->register()->Id_Puesta;


            $this->db->commit();
            $response['status'] = true;
            $response['id_puesta'] = $Id_Puesta;
            $response['id_pr'] = $Id_Primer_Respondiente;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollback();
        }

        return $response;
    }

    public function insertarLugarIntervencion($puesta)
    {
        try {
            $this->db->beginTransaction();

            /* ----- ----- ----- Insertar ubicacion vacia ----- ----- ----- */
            $sql = "INSERT INTO ubicacion VALUES()";
            $this->db->query($sql);
            $this->db->execute();

            /* ----- ----- ----- Recuperar ID domicilio ----- ----- ----- */
            $this->db->query("SELECT LAST_INSERT_ID() as Id_Ubicacion");
            $Id_Ubicacion = $this->db->register()->Id_Ubicacion;

            $sql = "INSERT
                INTO iph_lugar_intervencion(
                    Id_Puesta,
                    Id_Ubicacion
                ) VALUES(
                    " . trim($puesta) . ",
                    " . trim($Id_Ubicacion) . "
                )
            ";
            $this->db->query($sql);
            $this->db->execute();

            $this->db->commit();
            $response['status'] = true;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollback();
        }

        return $response;
    }

    public function insertUpdatePuesta($post)
    {
        try {
            $id_puesta = $post['id_puesta'];
            $puesta = $this->existeRegistroTabla('iph_puesta_disposicion', ['Id_Puesta'], [$id_puesta]);
            $folioIPH = $post['num_folio_iph'] . '/' . $post['ano_folio_iph'] . '/' . $post['turno_folio_iph'];

            $this->db->beginTransaction();


            $sql = "UPDATE iph_puesta_disposicion
                    SET
                        Fecha_Hora       = '" . trim($post['fecha_puesta']) . ' ' . trim($post['hora_puesta']) . "',
                        Num_Expediente   = '" . trim($post['num_expendiente_puesta']) . "',
                        Num_Referencia   = '" . trim($post['num_referencia_puesta']) . "',
                        Folio_IPH   = '" . trim($folioIPH) . "',
                        Num_Elementos    = '" . trim($post['cuantos_identificacion']) . "',
                        Narrativa_Hechos = '" . trim($post['narrativa']) . "'
                    WHERE Id_Puesta = " . $id_puesta;

            $this->db->query($sql);
            $this->db->execute();

            $fiscal = $this->existeRegistroTabla('iph_fiscal', ['Id_Puesta'], [$id_puesta]);
            if (!$fiscal) {
                $sql = "INSERT
                        INTO iph_fiscal(
                            Nombre_Fis,
                            Ap_Paterno_Fis,
                            Ap_Materno_Fis,
                            Fiscalia,
                            Adscripcion,
                            Cargo,
                            Id_Puesta
                        ) VALUES(
                            '" . trim($post['nombre_autoridad']) . "',
                            '" . trim($post['apellido_p_autoridad']) . "',
                            '" . trim($post['apellido_m_autoridad']) . "',
                            '" . trim($post['fiscalia_autoridad']) . "',
                            '" . trim($post['adscripcion_autoridad']) . "',
                            '" . trim($post['cargo_autoridad']) . "',
                            "  . trim($id_puesta) . "
                        )
                ";
                $this->db->query($sql);
                $this->db->execute();
            } else {
                $sql = "UPDATE iph_fiscal
                        SET
                            Nombre_Fis      = '" . trim($post['nombre_autoridad']) . "',
                            Ap_Paterno_Fis  = '" . trim($post['apellido_p_autoridad']) . "',
                            Ap_Materno_Fis  = '" . trim($post['apellido_m_autoridad']) . "',
                            Fiscalia        = '" . trim($post['fiscalia_autoridad']) . "',
                            Adscripcion     = '" . trim($post['adscripcion_autoridad']) . "',
                            Cargo           = '" . trim($post['cargo_autoridad']) . "'
                        WHERE Id_Fiscal = " . $fiscal->Id_Fiscal;

                $this->db->query($sql);
                $this->db->execute();
            }

            $primerRespondiente = $this->existeRegistroTabla('iph_primer_respondiente', ['Id_Primer_Respondiente'], [$puesta->Id_Primer_Respondiente]);
            ($post['institucion'] == 'Otro') ? $institucion = $post['cual_identificacion'] : $institucion = $post['institucion'];

            $sql = "UPDATE iph_primer_respondiente
                    SET
                        Nombre_PR      = '" . trim($post['nombre_identificacion']) . "',
                        Ap_Paterno_PR  = '" . trim($post['apellido_p_identificacion']) . "',
                        Ap_Materno_PR  = '" . trim($post['apellido_m_identificacion']) . "',
                        Institucion    = '" . trim($institucion) . "',
                        Adscripcion_Realiza_Puesta = '" . trim($post['adscripcion_realiza_puesta']) . "',
                        Cargo          = '" . trim($post['grado_identificacion']) . "',
                        Unidad_Arribo  = '" . trim($post['unidad_identificacion']) . "',
                        No_Control     = '" . trim($post['num_control_identificacion']) . "'
                    WHERE Id_Primer_Respondiente = " . $primerRespondiente->Id_Primer_Respondiente;

            $this->db->query($sql);
            $this->db->execute();

            $conocimientoHecho = $this->existeRegistroTabla('iph_hecho_seguimiento_actuacion', ['Id_Puesta'], [$id_puesta]);

            if (!$conocimientoHecho) {
                $sql = "INSERT
                        INTO iph_hecho_seguimiento_actuacion(
                            Id_Puesta,
                            Conocimiento_Hecho,
                            Especificacion,
                            Fecha_Hora_Conocimiento,
                            Fecha_Hora_Arribo
                        ) VALUES(
                            " . trim($id_puesta) . ",
                            '" . trim($post['hecho']) . "',
                            '" . trim($post['cual_emergencia']) . "',
                            '" . trim($post['fecha_conocimiento']) . ' ' . trim($post['hora_conocimiento']) . "',
                            '" . trim($post['fecha_arribo']) . ' ' . trim($post['hora_arribo']) . "'
                        )";

                $this->db->query($sql);
                $this->db->execute();
            } else {
                $sql = "UPDATE iph_hecho_seguimiento_actuacion
                        SET
                            Conocimiento_Hecho       = '" . trim($post['hecho']) . "',
                            Especificacion           = '" . trim($post['cual_emergencia']) . "',
                            Fecha_Hora_Conocimiento  = '" . trim($post['fecha_conocimiento']) . ' ' . trim($post['hora_conocimiento']) . "',
                            Fecha_Hora_Arribo        = '" . trim($post['fecha_arribo']) . ' ' . trim($post['hora_arribo']) . "'
                        WHERE Id_Puesta = " . $id_puesta;

                $this->db->query($sql);
                $this->db->execute();
            }

            $lugarIntervencion = $this->existeRegistroTabla('iph_lugar_intervencion', ['Id_Puesta'], [$id_puesta]);

            $sql = "UPDATE ubicacion
                    SET 
                        Calle_1       = '" . trim($post['Calle']) . "',
                        No_Ext        = '" . trim($post['noExterior']) . "',
                        No_Int        = '" . trim($post['noInterior']) . "',
                        Colonia       = '" . trim($post['Colonia']) . "',
                        Coordenada_X  = '" . trim($post['cordX']) . "',
                        Coordenada_Y  = '" . trim($post['cordY']) . "',
                        CP            = '" . trim($post['CP']) . "',
                        Municipio     = '" . trim($post['Municipio']) . "',
                        Estado       = '"  . trim($post['Entidad']) . "',
                        Referencias   = '" . trim($post['Referencias']) . "'
                    WHERE Id_Ubicacion = " . $lugarIntervencion->Id_Ubicacion;

            $this->db->query($sql);
            $this->db->execute();

            ($post['priorizacion_lugar'] == 'No') ? $tipoRiesgo = '' : $tipoRiesgo = $post['riesgo_presentado'];
            ($post['realizo_inspeccion'] == 'Si') ? $inspeccionLugar = 1 : $inspeccionLugar = 0;
            ($post['encontro_objeto'] == 'Si')    ? $objetoEncontrado = 1 : $objetoEncontrado = 0;
            ($post['preservo_lugar'] == 'Si')     ? $preservoLugar = 1 : $preservoLugar = 0;
            ($post['priorizacion_lugar'] == 'Si') ? $priorizacionLugar = 1 : $priorizacionLugar = 0;

            $sql = "UPDATE iph_lugar_intervencion
                    SET 
                        Inspeccion_Lugar   = b'" . trim($inspeccionLugar) . "',
                        Objeto_Encontrado  = b'" . trim($objetoEncontrado) . "',
                        Preservar_Lugar    = b'" . trim($preservoLugar) . "',
                        Priorizacion_Lugar = b'" . trim($priorizacionLugar) . "',
                        Tipo_Riesgo        = '" . trim($tipoRiesgo) . "',
                        Especificacion     = '" . trim($post['especifique_riesgo']) . "'
                    WHERE Id_Puesta = " . $id_puesta;

            $this->db->query($sql);
            $this->db->execute();

            $this->db->commit();
            $response['status'] = true;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollback();
        }

        return $response;
    }

    public function concluirPuesta($post)
    {
        try {
            $this->db->beginTransaction();

            $sql = "UPDATE iph_puesta_disposicion
                    SET 
                        Estatus = b'" . 1 . "'
                    WHERE Id_Puesta = " . $post['id_puesta'];
            $this->db->query($sql);
            $this->db->execute();

            $this->db->commit();
            $response['status'] = true;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollback();
        }

        return $response;
    }

    public function getPuesta($id_puesta)
    {
        $response['puesta'] = $this->existeRegistroTabla('iph_puesta_disposicion', ['Id_Puesta'], [$id_puesta]);
        $response['primerRespondiente'] = $this->existeRegistroTabla('iph_primer_respondiente', ['Id_Primer_Respondiente'], [$response['puesta']->Id_Primer_Respondiente]);
        $response['fiscal'] = $this->existeRegistroTabla('iph_fiscal', ['Id_Puesta'], [$id_puesta]);
        $response['hecho']  = $this->existeRegistroTabla('iph_hecho_seguimiento_actuacion', ['Id_Puesta'], [$id_puesta]);
        $response['lugarIntervencion'] = $this->existeRegistroTabla('iph_lugar_intervencion', ['Id_Puesta'], [$id_puesta]);
        if ($response['lugarIntervencion']) {
            $response['ubicacion'] = $this->existeRegistroTabla('ubicacion', ['Id_Ubicacion'], [$response['lugarIntervencion']->Id_Ubicacion]);
        }
        $response['docComplementaria'] = $this->getDocumentacionC($id_puesta);

        return $response;
    }

    public function uploadCroquis($id_puesta, $name)
    {
        try {
            $this->db->beginTransaction();
            $sql = "UPDATE iph_lugar_intervencion
                    SET
                        Path_Croquis = '" . trim($name) . "'
                    WHERE Id_Puesta = " . $id_puesta;

            $this->db->query($sql);
            $this->db->execute();

            $this->db->commit();
            $response['status'] = true;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollback();
        }

        return $response;
    }

    public function uploadDocComplementaria($post)
    {
        try {
            $this->db->beginTransaction();

            (isset($post['Fotografia'])) ? $fotografia = 1 : $fotografia = 0;
            (isset($post['Video'])) ? $video = 1 : $video = 0;
            (isset($post['Audio'])) ? $audio = 1 : $audio = 0;
            (isset($post['Certificado'])) ? $certificado = 1 : $certificado = 0;

            $docCom = $this->existeRegistroTabla('iph_documentacion_complementaria', ['Id_Puesta'], [$post['id_puesta']]);
            if(!$docCom){
                $sql = "INSERT 
                        INTO iph_documentacion_complementaria(
                            Fotografia,
                            Video,
                            Audio,
                            Certificado,
                            Otro,
                            Id_Puesta
                        ) VALUES(
                            b'" . $fotografia . "',
                            b'" . $video . "',
                            b'" . $audio . "',
                            b'" . $certificado . "',
                            '" . $post['otro_especificacion'] . "',
                            ". $post['id_puesta'] ."
                        )
                ";
            }else{
                $sql = "UPDATE iph_documentacion_complementaria
                        SET
                            Fotografia = b'" . $fotografia . "',
                            Video = b'" . $video . "',
                            Audio = b'" . $audio . "',
                            Certificado = b'" . $certificado . "',
                            Otro = '" . $post['otro_especificacion'] . "'
                            WHERE Id_Puesta = ".$post['id_puesta'];
            }

            $this->db->query($sql);
            $this->db->execute();

            $this->db->commit();
            $response['status'] = true;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollback();
        }

        return $response;
    }

    public function insertarAnexoC($post)
    {

        $response['status'] =  true;
        try {
            $this->db->beginTransaction();
            $this->db->query("SELECT Id_Primer_Respondiente AS id_puesta FROM iph_puesta_disposicion WHERE Id_Puesta = " . $post['Id_Puesta']);
            $id_respondiente_1 =  $this->db->register()->id_puesta;
            $id_respondiente_2 =  1;

            if (($post['pr']) == 'No') {
                $sql = "INSERT 
                        INTO iph_primer_respondiente(
                            Nombre_PR,
                            Ap_Paterno_PR,
                            Ap_Materno_PR,
                            Institucion,
                            Cargo
                        )
                        VALUES(
                            '" . $post['Nombre_PR'] . "',
                            '" . $post['Ap_Paterno_PR'] . "',
                            '" . $post['Ap_Materno_PR'] . "',
                            '" . $post['Institucion'] . "',
                            '" . $post['Cargo'] . "'
                        )";

                $this->db->query($sql);
                $this->db->execute();

                $this->db->query("SELECT LAST_INSERT_ID() as Id_Primer_Respondiente");
                $id_respondiente_1 = $this->db->register()->Id_Primer_Respondiente;

                if ($post['Nombre_PR_1'] != '' && $post['Ap_Paterno_PR_1'] && $post['Ap_Materno_PR_1']) {

                    $sql = "INSERT 
                        INTO iph_primer_respondiente(
                            Nombre_PR,
                            Ap_Paterno_PR,
                            Ap_Materno_PR,
                            Institucion,
                            Cargo
                        )
                        VALUES(
                            '" . $post['Nombre_PR_1'] . "',
                            '" . $post['Ap_Paterno_PR_1'] . "',
                            '" . $post['Ap_Materno_PR_1'] . "',
                            '" . $post['Institucion_1'] . "',
                            '" . $post['Cargo_1'] . "'
                        )";

                    $this->db->query($sql);
                    $this->db->execute();

                    $this->db->query("SELECT LAST_INSERT_ID() as Id_Segundo_Respondiente");
                    $id_respondiente_2 = $this->db->register()->Id_Segundo_Respondiente;
                }
            }

            $numVehiculo =  $this->getNumberofTable(0, 'iph_inspeccion_vehiculo');
            $IdPuesta = $post['Id_Puesta'];
            $tipo           = (isset($post['tipo']))                    ? $post['tipo'] : '';
            $procedencia    = (isset($post['Procedencia']))             ? $post['Procedencia'] : '';
            $uso            = (isset($post['Uso']))                     ? $post['Uso'] : '';
            $situacion      = (isset($post['Situacion']))               ? $post['Situacion'] : '';
            $objetos        = ($post['Objetos_Encontrados'] === 'Si')    ? '1' : '0';
            $primerResp     = $id_respondiente_1;
            $segundoResp    = $id_respondiente_2;

            $sql = "INSERT 
                INTO iph_inspeccion_vehiculo(
                    Id_Puesta,
                    Num_Vehiculo,
                    Fecha_Hora,
                    Tipo,
                    Procedencia,
                    Marca,
                    Submarca,
                    Modelo,
                    Color,
                    Uso,
                    Placa,
                    Num_Serie,
                    Situacion,
                    Observaciones,
                    Destino,
                    Objetos_Encontrados,
                    Id_Primer_Respondiente,
                    Id_Segundo_Respondiente
                    )
                    VALUES(
                        " . $IdPuesta . ",
                        " . $numVehiculo . ",
                        '" . $post['fecha'] . " " . $post['hora'] . "',
                        '" .  $tipo . "',
                        '" .  $procedencia . "',
                        '" . $post['Marca'] . "',
                        '" . $post['Submarca'] . "',
                        '" . $post['Modelo'] . "',
                        '" . $post['Color'] . "',
                        '" .  $uso . "',
                        '" . $post['Placa'] . "',
                        '" . $post['Num_Serie'] . "',
                        '" . $situacion . "',
                        '" . $post['Observaciones'] . "',
                        '" . $post['Destino'] . "',
                        b'" . $objetos . "',
                        '" . $primerResp . "',
                        '" . $segundoResp . "'
                    )";
            $this->db->query($sql);
            $this->db->execute();

            $this->db->commit();
            $response['status'] = true;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollBack(); //si algo falla realiza el rollBack por seguridad
        }
        return $response;
    }


    public function actualizarAnexoC($post)
    {


        $response['status'] =  true;
        try {
            $this->db->beginTransaction();
            $this->db->query("SELECT Id_Primer_Respondiente AS id_pr_puesta FROM iph_puesta_disposicion WHERE Id_Puesta = " . $post['Id_Puesta']);
            $id_respondiente_1_puesta =  $this->db->register()->id_pr_puesta;

            $this->db->query("SELECT Id_Primer_Respondiente AS id_pr_vehiculo FROM iph_inspeccion_vehiculo WHERE Id_Inspeccion_Vehiculo = " . $post['Id_Inspeccion_Vehiculo']);
            $id_respondiente_1_vehiculo =  $this->db->register()->id_pr_vehiculo;

            $this->db->query("SELECT Id_Segundo_Respondiente AS id_sg_vehiculo FROM iph_inspeccion_vehiculo WHERE Id_Inspeccion_Vehiculo = " . $post['Id_Inspeccion_Vehiculo']);
            $id_respondiente_2_vehiculo =  $this->db->register()->id_sg_vehiculo;




            // echo $id_respondiente_1_puesta . " " .$id_respondiente_1_vehiculo ;
            // echo $id_respondiente_1_puesta. "--" .$id_respondiente_1_vehiculo;
            $id_respondiente_1 = 1;
            $id_respondiente_2 =  1;

            if (($post['pr']) == 'No') {
                if ($id_respondiente_1_puesta == $id_respondiente_1_vehiculo) {
                    // echo "Entre al if" ;
                    $sql = "INSERT 
                    INTO iph_primer_respondiente(
                        Nombre_PR,
                        Ap_Paterno_PR,
                        Ap_Materno_PR,
                        Institucion,
                        Cargo
                    )
                    VALUES(
                        '" . $post['Nombre_PR'] . "',
                        '" . $post['Ap_Paterno_PR'] . "',
                        '" . $post['Ap_Materno_PR'] . "',
                        '" . $post['Institucion'] . "',
                        '" . $post['Cargo'] . "'
                    )";

                    $this->db->query($sql);
                    $this->db->execute();

                    $this->db->query("SELECT LAST_INSERT_ID() as Id_Primer_Respondiente");
                    $id_respondiente_1 = $this->db->register()->Id_Primer_Respondiente;

                    $sql = "UPDATE iph_inspeccion_vehiculo 
                            SET Id_Primer_Respondiente      = '" . $id_respondiente_1 . "'
                            WHERE Id_Inspeccion_Vehiculo = " . $post['Id_Inspeccion_Vehiculo'];

                    $this->db->query($sql);
                    $this->db->execute();

                    if ($post['Nombre_PR_1'] != '' && $post['Ap_Paterno_PR_1'] && $post['Ap_Materno_PR_1']) {
                        // echo "Entre al otro if" ;

                        $sql = "INSERT 
                                INTO iph_primer_respondiente(
                                    Nombre_PR,
                                    Ap_Paterno_PR,
                                    Ap_Materno_PR,
                                    Institucion,
                                    Cargo
                                )
                                VALUES(
                                    '" . $post['Nombre_PR_1'] . "',
                                    '" . $post['Ap_Paterno_PR_1'] . "',
                                    '" . $post['Ap_Materno_PR_1'] . "',
                                    '" . $post['Institucion_1'] . "',
                                    '" . $post['Cargo_1'] . "'
                                )";

                        $this->db->query($sql);
                        $this->db->execute();

                        $this->db->query("SELECT LAST_INSERT_ID() as Id_Segundo_Respondiente");
                        $id_respondiente_2 = $this->db->register()->Id_Segundo_Respondiente;

                        $sql = "UPDATE iph_inspeccion_vehiculo 
                            SET Id_Segundo_Respondiente      = '" . $id_respondiente_2 . "'
                            WHERE Id_Inspeccion_Vehiculo = " . $post['Id_Inspeccion_Vehiculo'];
                        $this->db->query($sql);
                        $this->db->execute();
                    }
                } else if ($id_respondiente_1_puesta != $id_respondiente_1_vehiculo) {

                    $sql = "UPDATE iph_primer_respondiente
                                SET Nombre_PR       = '" . $post['Nombre_PR'] . "',
                                    Ap_Paterno_PR   = '" . $post['Ap_Paterno_PR'] . "',
                                    Ap_Materno_PR   = '" . $post['Ap_Materno_PR'] . "',
                                    Institucion     = '" . $post['Institucion'] . "',  
                                    Cargo           = '" . $post['Cargo'] . "' WHERE Id_Primer_Respondiente = " . $id_respondiente_1_vehiculo;
                    $this->db->query($sql);
                    $this->db->execute();

                    if ($post['Nombre_PR_1'] != '' && $post['Ap_Paterno_PR_1'] && $post['Ap_Materno_PR_1']) {
                        $sql = "UPDATE iph_primer_respondiente
                                SET Nombre_PR       = '" . $post['Nombre_PR_1'] . "',
                                    Ap_Paterno_PR   = '" . $post['Ap_Paterno_PR_1'] . "',
                                    Ap_Materno_PR   = '" . $post['Ap_Materno_PR_1'] . "',
                                    Institucion     = '" . $post['Institucion_1'] . "',  
                                    Cargo           = '" . $post['Cargo_1'] . "' WHERE Id_Primer_Respondiente = " . $id_respondiente_2_vehiculo;
                        $this->db->query($sql);
                        $this->db->execute();
                    }
                }
            } else {
                // echo "Caí en el else" ;
                if ($id_respondiente_1_puesta != $id_respondiente_1_vehiculo) {
                    $sql = "UPDATE iph_inspeccion_vehiculo 
                            SET Id_Primer_Respondiente      = '" . $id_respondiente_1_puesta . "'
                            WHERE Id_Inspeccion_Vehiculo = " . $post['Id_Inspeccion_Vehiculo'];
                    $this->db->query($sql);
                    $this->db->execute();

                    $sql = "DELETE FROM iph_primer_respondiente WHERE Id_Primer_Respondiente =" . $id_respondiente_1_vehiculo;
                    $this->db->query($sql);
                    $this->db->execute();

                    $this->db->query("SELECT Id_Segundo_Respondiente AS id_srp FROM iph_inspeccion_vehiculo WHERE Id_Inspeccion_Vehiculo = " . $post['Id_Inspeccion_Vehiculo']);
                    $id_srp =  $this->db->register()->id_srp;
                    if ($id_srp != 1) {

                        $sql = "UPDATE iph_inspeccion_vehiculo 
                            SET Id_Segundo_Respondiente = 1
                            WHERE Id_Inspeccion_Vehiculo = " . $post['Id_Inspeccion_Vehiculo'];
                        $this->db->query($sql);
                        $this->db->execute();

                        $sql = "DELETE FROM iph_primer_respondiente WHERE Id_Primer_Respondiente =" . $id_srp;
                        $this->db->query($sql);
                        $this->db->execute();
                    }
                }
            }

            $tipo           = (isset($post['tipo']))                    ? $post['tipo'] : '';
            $procedencia    = (isset($post['Procedencia']))             ? $post['Procedencia'] : '';
            $uso            = (isset($post['Uso']))                     ? $post['Uso'] : '';
            $situacion      = (isset($post['Situacion']))               ? $post['Situacion'] : '';
            $objetos        = ($post['Objetos_Encontrados'] === 'Si')    ? '1' : '0';

            $sql = "UPDATE iph_inspeccion_vehiculo 
                    SET Fecha_Hora          = '" . $post['fecha'] . " " . $post['hora'] . "',
                        Tipo                = '" .  $tipo . "',
                        Procedencia         = '" .  $procedencia . "',
                        Marca               = '" . $post['Marca'] . "',
                        Submarca            = '" . $post['Submarca'] . "',
                        Modelo              = '" . $post['Modelo'] . "',
                        Color               = '" . $post['Color'] . "',
                        Uso                 = '" .  $uso . "',
                        Placa               = '" . $post['Placa'] . "',
                        Num_Serie           = '" . $post['Num_Serie'] . "',
                        Situacion           = '" . $situacion . "',
                        Observaciones       = '" . $post['Observaciones'] . "',
                        Destino             = '" . $post['Destino'] . "',
                        Objetos_Encontrados = b'" . $objetos . "'
                    WHERE Id_Inspeccion_Vehiculo = " . $post['Id_Inspeccion_Vehiculo'];
            $this->db->query($sql);
            $this->db->execute();

            $this->db->commit();
            $response['status'] = true;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollBack(); //si algo falla realiza el rollBack por seguridad
        }

        return $response;
    }

    public function getInfoAnexoC($id_puesta, $id_elem)
    {
        try {
            $this->db->beginTransaction(); //inicio de transaction

            $return['success'] = false;
            $return['error_message'] = '';

            $sql =  "SELECT Estatus AS estado FROM iph_puesta_disposicion WHERE Id_Puesta = " . $id_puesta;
            $this->db->query($sql);
            $data['estatus'] = $this->db->register()->estado;


            $sql =  "SELECT * FROM iph_inspeccion_vehiculo WHERE Id_Puesta =  $id_puesta AND Id_Inspeccion_Vehiculo = $id_elem ";
            $this->db->query($sql);
            $data['general'] = $this->db->register();

            $sql =  "SELECT * FROM iph_primer_respondiente WHERE Id_Primer_Respondiente = " . $data['general']->Id_Primer_Respondiente;
            $this->db->query($sql);
            $data['primer_respondiente'] = $this->db->register();

            if ($data['general']->Id_Segundo_Respondiente != 1) {
                $sql =  "SELECT * FROM iph_primer_respondiente WHERE Id_Primer_Respondiente = " . $data['general']->Id_Segundo_Respondiente;
                $this->db->query($sql);
                $data['segundo_respondiente'] = $this->db->register();
            } else {
                $data['segundo_respondiente'] =  null;
            }

            $return['success'] = true;
            $return['apartados'] = $data;

            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries

        } catch (Exception $err) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            $return['success'] = false;
            $return['error_message'] = $err;
        }

        return $return;
    }


    public function insertarAnexoDArmas($post)
    {

        $response['status'] =  true;
        try {
            $this->db->beginTransaction();
            $IdPuesta = $post['Id_Puesta'];

            $this->db->query("SELECT Id_Primer_Respondiente AS id_pr FROM iph_puesta_disposicion WHERE Id_Puesta = " . $IdPuesta);
            $Id_Primer_Respondiente_Puesta = $this->db->register()->id_pr; //Id del primer respondiente de la puesta
            $aportacion =  (isset($post['Aportacion'])) ? 1 : 0;

            if (($post['arma']) == 'No') {
                $sql = "INSERT 
                        INTO iph_primer_respondiente(
                            Nombre_PR,
                            Ap_Paterno_PR,
                            Ap_Materno_PR,
                            Institucion,
                            Cargo
                        )
                        VALUES(
                            '" . $post['Nombre_PRA'] . "',
                            '" . $post['Ap_Paterno_PRA'] . "',
                            '" . $post['Ap_Materno_PRA'] . "',
                            '" . $post['InstitucionA'] . "',
                            '" . $post['CargoA'] . "'
                        )";

                $this->db->query($sql);
                $this->db->execute();
            }

            $this->db->query("SELECT LAST_INSERT_ID() as Id_Primer_Respondiente");
            $Id_Primer_Respondiente = (($post['arma']) == 'No') ? $this->db->register()->Id_Primer_Respondiente :  $Id_Primer_Respondiente_Puesta;
            $inspeccion = (isset($post['Inspeccion'])) ? $post['Inspeccion'] : '';

            $sql = "INSERT  
                INTO iph_inventario_arma(
                    Aportacion,
                    Inspeccion,
                    Ubicacion_Arma,
                    Tipo_Arma,
                    Calibre,
                    Color,
                    Matricula,
                    Num_Serie,
                    Observaciones,
                    Destino,
                    Nombre_A,
                    Ap_Paterno_A,
                    Ap_Materno_A,
                    Id_Puesta,
                    Id_Primer_Respondiente
                    )
                    VALUES(
                        b'" . $aportacion . "',
                        '" . $inspeccion . "',
                        '" .  $post['Ubicacion_Arma'] . "',
                        '" .  $post['Tipo_Arma'] . "',
                        '" .  $post['Calibre'] . "',
                        '" .  $post['Color'] . "',
                        '" .  $post['Matricula'] . "',
                        '" .  $post['Num_Serie'] . "',
                        '" .  $post['Observaciones'] . "',
                        '" .  $post['Destino'] . "',
                        '" .  $post['Nombre_A'] . "',
                        '" .  $post['Ap_Paterno_A'] . "',
                        '" .  $post['Ap_Materno_A'] . "',
                        " . $IdPuesta . ",
                        " . $Id_Primer_Respondiente . " 
                    )";
            $this->db->query($sql);
            $this->db->execute();

            if ($post['testigos'] == 'Si') {
                $this->db->query("SELECT LAST_INSERT_ID() as Id_Inventario");
                $Id_Inventario = $this->db->register()->Id_Inventario;
                for ($i = 0; $i < 2; $i++) {
                    $sql = "INSERT 
                        INTO iph_testigo_arma(
                            Nombre_TA,
                            Ap_Paterno_TA,
                            Ap_Materno_TA,
                            Id_Inventario
                        )
                        VALUES(
                            '" . $post["Nombre_TA_$i"] . "',
                            '" . $post["Ap_Paterno_TA_$i"] . "',
                            '" . $post["Ap_Materno_TA_$i"] . "',
                            "  . $Id_Inventario . "
                        )";

                    $this->db->query($sql);
                    $this->db->execute();
                }
            }
            $this->db->commit();
            $response['status'] = true;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollBack(); //si algo falla realiza el rollBack por seguridad
        }

        return $response;
    }


    public function actualizarAnexoDArmas($post)
    {

        $response['status'] =  true;
        try {
            $this->db->beginTransaction();
            $IdPuesta = $post['Id_Puesta'];

            $this->db->query("SELECT Id_Primer_Respondiente AS id_pr FROM iph_puesta_disposicion WHERE Id_Puesta = " . $IdPuesta);
            $Id_Primer_Respondiente_Puesta = $this->db->register()->id_pr; //Id del primer respondiente de la puesta

            $this->db->query("SELECT Id_Primer_Respondiente AS id_pr FROM iph_inventario_arma WHERE Id_Inventario_Arma = " . $post['Id_Inventario_Arma']);
            $Id_Primer_Respondiente_Arma = $this->db->register()->id_pr; //Id del primer respondiente de la puesta

            // echo "Puesta: " . $Id_Primer_Respondiente_Puesta . "Tabla arma: " .  $Id_Primer_Respondiente_Arma;

            $aportacion =  (isset($post['Aportacion'])) ? 1 : 0;

            switch (($post['arma'])) {
                case 'No':
                    if ($Id_Primer_Respondiente_Puesta == $Id_Primer_Respondiente_Arma) {
                        $sql = "INSERT 
                                INTO iph_primer_respondiente(
                                    Nombre_PR,
                                    Ap_Paterno_PR,
                                    Ap_Materno_PR,
                                    Institucion,
                                    Cargo
                                )
                                VALUES(
                                    '" . $post['Nombre_PRA'] . "',
                                    '" . $post['Ap_Paterno_PRA'] . "',
                                    '" . $post['Ap_Materno_PRA'] . "',
                                    '" . $post['InstitucionA'] . "',
                                    '" . $post['CargoA'] . "'
                                )";
                        $this->db->query($sql);
                        $this->db->execute();

                        $this->db->query("SELECT LAST_INSERT_ID() as Id_Primer_Respondiente");
                        $id_respondiente = $this->db->register()->Id_Primer_Respondiente;

                        $sql = "UPDATE iph_inventario_arma 
                            SET Id_Primer_Respondiente      = '" . $id_respondiente . "'
                            WHERE Id_Inventario_Arma = " . $post['Id_Inventario_Arma'];

                        $this->db->query($sql);
                        $this->db->execute();
                    } else if ($Id_Primer_Respondiente_Puesta != $Id_Primer_Respondiente_Arma) {
                        $sql = "UPDATE iph_primer_respondiente
                                SET Nombre_PR       = '" . $post['Nombre_PRA'] . "',
                                    Ap_Paterno_PR   = '" . $post['Ap_Paterno_PRA'] . "',
                                    Ap_Materno_PR   = '" . $post['Ap_Materno_PRA'] . "',
                                    Institucion     = '" . $post['InstitucionA'] . "',  
                                    Cargo           = '" . $post['CargoA'] . "' WHERE Id_Primer_Respondiente = " . $Id_Primer_Respondiente_Arma;
                        $this->db->query($sql);
                        $this->db->execute();
                    }
                    break;

                case 'Si':
                    if ($Id_Primer_Respondiente_Puesta != $Id_Primer_Respondiente_Arma) {
                        $sql = "UPDATE iph_inventario_arma 
                            SET Id_Primer_Respondiente      = '" . $Id_Primer_Respondiente_Puesta . "'
                            WHERE Id_Inventario_Arma = " . $post['Id_Inventario_Arma'];
                        $this->db->query($sql);
                        $this->db->execute();

                        $sql = "DELETE FROM iph_primer_respondiente WHERE Id_Primer_Respondiente =" . $Id_Primer_Respondiente_Arma;
                        $this->db->query($sql);
                        $this->db->execute();
                    }

                    break;
            }

            $inspeccion = (isset($post['Inspeccion'])) ? $post['Inspeccion'] : '';
            $sql =  "UPDATE iph_inventario_arma
                    SET Aportacion      =   b'" . $aportacion . "',
                        Inspeccion      =   '" . $inspeccion . "',
                        Ubicacion_Arma  =   '" .  $post['Ubicacion_Arma'] . "', 
                        Tipo_Arma       =   '" .  $post['Tipo_Arma'] . "', 
                        Calibre         =   '" .  $post['Calibre'] . "',
                        Color           =   '" .  $post['Color'] . "',
                        Matricula       =   '" .  $post['Matricula'] . "',
                        Num_Serie       =   '" .  $post['Num_Serie'] . "',
                        Observaciones   =   '" .  $post['Observaciones'] . "',
                        Destino         =   '" .  $post['Destino'] . "', 
                        Nombre_A        =   '" .  $post['Nombre_A'] . "', 
                        Ap_Paterno_A    =   '" .  $post['Ap_Paterno_A'] . "', 
                        Ap_Materno_A    =   '" .  $post['Ap_Materno_A'] . "' 
                        WHERE  Id_Inventario_Arma = " . $post['Id_Inventario_Arma'];
            $this->db->query($sql);
            $this->db->execute();

            $this->db->query("SELECT COUNT(*) AS count_testigos FROM iph_testigo_arma WHERE Id_Inventario = " . $post['Id_Inventario_Arma']);
            $count_testigos =  $this->db->register()->count_testigos;
            // echo "TESTIGOS: " . $count_testigos;

            if ($post['testigos'] == 'No') {
                if ($count_testigos == 2) {
                    $this->db->query("DELETE FROM iph_testigo_arma WHERE Id_Inventario =" . $post['Id_Inventario_Arma']);
                    $this->db->execute();
                }
            } else {
                if ($count_testigos == 2) {

                    $this->db->query("SELECT Id_Testigo_Inventario  FROM iph_testigo_arma WHERE Id_Inventario = " . $post['Id_Inventario_Arma']);
                    $id_testigo =  $this->db->registers();
                    // var_dump($id_testigo);


                    for ($i = 0; $i < 2; $i++) {
                        $sql = "UPDATE iph_testigo_arma
                                    SET Nombre_TA   = '" . $post["Nombre_TA_$i"] . "',
                                    Ap_Paterno_TA   = '" . $post["Ap_Paterno_TA_$i"] . "',
                                    Ap_Materno_TA   = '" . $post["Ap_Materno_TA_$i"] . "',
                                    Id_Inventario   = "  . $post['Id_Inventario_Arma'] . "
                                    WHERE Id_Inventario = "  . $post['Id_Inventario_Arma'] . " AND Id_Testigo_Inventario = " . $id_testigo[$i]->Id_Testigo_Inventario;
                        $this->db->query($sql);
                        $this->db->execute();
                    }
                } else {
                    for ($i = 0; $i < 2; $i++) {
                        $sql = "INSERT 
                                INTO iph_testigo_arma(
                                    Nombre_TA,
                                    Ap_Paterno_TA,
                                    Ap_Materno_TA,
                                    Id_Inventario
                                )
                                VALUES(
                                    '" . $post["Nombre_TA_$i"] . "',
                                    '" . $post["Ap_Paterno_TA_$i"] . "',
                                    '" . $post["Ap_Materno_TA_$i"] . "',
                                    "  . $post['Id_Inventario_Arma'] . "
                                )";
                        $this->db->query($sql);
                        $this->db->execute();
                    }
                }
            }
            $this->db->commit();
            $response['status'] = true;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollBack(); //si algo falla realiza el rollBack por seguridad
        }

        return $response;
    }

    public function actualizarAnexoDObjetos($post)
    {

        $response['status'] =  true;
        try {
            $this->db->beginTransaction();
            $IdPuesta = $post['Id_Puesta'];

            $this->db->query("SELECT Id_Primer_Respondiente AS id_pr FROM iph_puesta_disposicion WHERE Id_Puesta = " . $IdPuesta);
            $Id_Primer_Respondiente_Puesta = $this->db->register()->id_pr; //Id del primer respondiente de la puesta

            $this->db->query("SELECT Id_Primer_Respondiente AS id_pr FROM iph_inventario_objeto WHERE Id_Inventario_Objetos = " . $post['Id_Inventario_Objetos']);
            $Id_Primer_Respondiente_Objeto = $this->db->register()->id_pr; //Id del primer respondiente de la puesta

            // echo "Puesta: " . $Id_Primer_Respondiente_Puesta . "Tabla arma: " .  $Id_Primer_Respondiente_Objeto;

            $aportacion =  (isset($post['Aportacion'])) ? 1 : 0;

            switch (($post['respondiente'])) {
                case 'No':
                    if ($Id_Primer_Respondiente_Puesta == $Id_Primer_Respondiente_Objeto) {
                        $sql = "INSERT 
                                INTO iph_primer_respondiente(
                                    Nombre_PR,
                                    Ap_Paterno_PR,
                                    Ap_Materno_PR,
                                    Institucion,
                                    Cargo
                                )
                                VALUES(
                                    '" . $post['Nombre_PR'] . "',
                                    '" . $post['Ap_Paterno_PR'] . "',
                                    '" . $post['Ap_Materno_PR'] . "',
                                    '" . $post['Institucion'] . "',
                                    '" . $post['Cargo'] . "'
                                )";
                        $this->db->query($sql);
                        $this->db->execute();

                        $this->db->query("SELECT LAST_INSERT_ID() as Id_Primer_Respondiente");
                        $id_respondiente = $this->db->register()->Id_Primer_Respondiente;

                        $sql = "UPDATE iph_inventario_objeto 
                            SET Id_Primer_Respondiente      = '" . $id_respondiente . "'
                            WHERE Id_Inventario_Objetos = " . $post['Id_Inventario_Objetos'];

                        $this->db->query($sql);
                        $this->db->execute();
                    } else if ($Id_Primer_Respondiente_Puesta != $Id_Primer_Respondiente_Objeto) {
                        $sql = "UPDATE iph_primer_respondiente
                                SET Nombre_PR       = '" . $post['Nombre_PR'] . "',
                                    Ap_Paterno_PR   = '" . $post['Ap_Paterno_PR'] . "',
                                    Ap_Materno_PR   = '" . $post['Ap_Materno_PR'] . "',
                                    Institucion     = '" . $post['Institucion'] . "',  
                                    Cargo           = '" . $post['Cargo'] . "' WHERE Id_Primer_Respondiente = " . $Id_Primer_Respondiente_Objeto;
                        $this->db->query($sql);
                        $this->db->execute();
                    }
                    break;

                case 'Si':
                    if ($Id_Primer_Respondiente_Puesta != $Id_Primer_Respondiente_Objeto) {
                        $sql = "UPDATE iph_inventario_objeto 
                            SET Id_Primer_Respondiente      = '" . $Id_Primer_Respondiente_Puesta . "'
                            WHERE Id_Inventario_Objetos = " . $post['Id_Inventario_Objetos'];
                        $this->db->query($sql);
                        $this->db->execute();

                        $sql = "DELETE FROM iph_primer_respondiente WHERE Id_Primer_Respondiente =" . $Id_Primer_Respondiente_Objeto;
                        $this->db->query($sql);
                        $this->db->execute();
                    }

                    break;
            }

            $apariencia =  ($post['Apariencia'] == 'Otro' && $post['otro'] != '') ? $post['otro'] : $post['Apariencia'];
            $inspeccion = (isset($post['Inspeccion'])) ? $post['Inspeccion'] : '';

            $sql = "UPDATE iph_inventario_objeto
                    SET Apariencia                  = '" .  $apariencia . "',
                        Aportacion                  = b'" . $aportacion . "',
                        Inspeccion                  = '" .  $inspeccion . "',
                        Ubicacion_Objeto            = '" .  $post['Ubicacion_Objeto'] . "',
                        Descripcion_Objeto          = '" .  $post['Descripcion_Objeto'] . "',
                        Destino                     = '" .  $post['Destino'] . "',
                        Nombre_A                    = '" .  $post['Nombre_A'] . "',
                        Ap_Paterno_A                = '" .  $post['Ap_Paterno_A'] . "',
                        Ap_Materno_A                = '" .  $post['Ap_Materno_A'] . "'
                        WHERE Id_Inventario_Objetos = " . $post['Id_Inventario_Objetos'];

            $this->db->query($sql);
            $this->db->execute();

            $this->db->query("SELECT COUNT(*) AS count_testigos FROM iph_testigo_objeto WHERE Id_Inventario = " . $post['Id_Inventario_Objetos']);
            $count_testigos =  $this->db->register()->count_testigos;
            // echo "TESTIGOS: " . $count_testigos;

            if ($post['testigos'] == 'No') {
                if ($count_testigos == 2) {
                    $this->db->query("DELETE FROM iph_testigo_objeto WHERE Id_Inventario =" . $post['Id_Inventario_Objetos']);
                    $this->db->execute();
                }
            } else {
                if ($count_testigos == 2) {

                    $this->db->query("SELECT Id_Testigo_Inventario  FROM iph_testigo_objeto WHERE Id_Inventario = " . $post['Id_Inventario_Objetos']);
                    $id_testigo =  $this->db->registers();
                    // var_dump($id_testigo);


                    for ($i = 0; $i < 2; $i++) {
                        $sql = "UPDATE iph_testigo_objeto
                                    SET Nombre_TO   = '" . $post["Nombre_TO_$i"] . "',
                                    Ap_Paterno_TO   = '" . $post["Ap_Paterno_TO_$i"] . "',
                                    Ap_Materno_TO   = '" . $post["Ap_Materno_TO_$i"] . "',
                                    Id_Inventario   = "  . $post['Id_Inventario_Objetos'] . "
                                    WHERE Id_Inventario = "  . $post['Id_Inventario_Objetos'] . " AND Id_Testigo_Inventario = " . $id_testigo[$i]->Id_Testigo_Inventario;
                        $this->db->query($sql);
                        $this->db->execute();
                    }
                } else {
                    for ($i = 0; $i < 2; $i++) {
                        $sql = "INSERT 
                                INTO iph_testigo_objeto(
                                    Nombre_TO,
                                    Ap_Paterno_TO,
                                    Ap_Materno_TO,
                                    Id_Inventario
                                )
                                VALUES(
                                    '" . $post["Nombre_TO_$i"] . "',
                                    '" . $post["Ap_Paterno_TO_$i"] . "',
                                    '" . $post["Ap_Materno_TO_$i"] . "',
                                    "  . $post['Id_Inventario_Objetos'] . "
                                )";
                        $this->db->query($sql);
                        $this->db->execute();
                    }
                }
            }
            $this->db->commit();
            $response['status'] = true;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollBack(); //si algo falla realiza el rollBack por seguridad
        }

        return $response;
    }

    public function getInfoAnexoDArmas($id_puesta, $id_elem)
    {
        try {
            $this->db->beginTransaction(); //inicio de transaction

            $return['success'] = false;
            $return['error_message'] = '';

            $sql =  "SELECT Estatus AS estado FROM iph_puesta_disposicion WHERE Id_Puesta = " . $id_puesta;
            $this->db->query($sql);
            $data['estatus'] = $this->db->register()->estado;

            $sql =  "SELECT * FROM iph_inventario_arma WHERE Id_Puesta =  $id_puesta AND Id_Inventario_Arma = $id_elem ";
            $this->db->query($sql);
            $data['general'] = $this->db->register();

            $this->db->query("SELECT Id_Primer_Respondiente AS id_pr FROM iph_puesta_disposicion WHERE Id_Puesta = " . $id_puesta);
            $id_pr_puesta = $this->db->register()->id_pr;

            if ($id_pr_puesta != $data['general']->Id_Primer_Respondiente) {
                $sql =  "SELECT * FROM iph_primer_respondiente WHERE Id_Primer_Respondiente = " . $data['general']->Id_Primer_Respondiente;
                $this->db->query($sql);
                $data['primer_respondiente'] = $this->db->register();
            } else {
                $data['primer_respondiente'] = null;
            }

            $this->db->query("SELECT COUNT(*) AS contador FROM iph_testigo_arma WHERE Id_Inventario = " . $data['general']->Id_Inventario_Arma);
            $testigo_count =   $this->db->register()->contador;

            if ($testigo_count > 0) {
                $sql = "SELECT * FROM iph_testigo_arma WHERE Id_Inventario = " . $data['general']->Id_Inventario_Arma;
                $this->db->query($sql);
                $data['testigos'] =  $this->db->registers();
            } else {
                $data['testigos'] = null;
            }

            $return['success'] = true;
            $return['apartados'] = $data;

            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries

        } catch (Exception $err) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            $return['success'] = false;
            $return['error_message'] = $err;
        }
        return $return;
    }

    public function getInfoAnexoDObjetos($id_puesta, $id_elem)
    {
        try {
            $this->db->beginTransaction(); //inicio de transaction

            $return['success'] = false;
            $return['error_message'] = '';

            $sql =  "SELECT Estatus AS estado FROM iph_puesta_disposicion WHERE Id_Puesta = " . $id_puesta;
            $this->db->query($sql);
            $data['estatus'] = $this->db->register()->estado;

            $sql =  "SELECT * FROM iph_inventario_objeto WHERE Id_Puesta =  $id_puesta AND Id_Inventario_Objetos = $id_elem ";
            $this->db->query($sql);
            $data['general'] = $this->db->register();

            $this->db->query("SELECT Id_Primer_Respondiente AS id_pr FROM iph_puesta_disposicion WHERE Id_Puesta = " . $id_puesta);
            $id_pr_puesta = $this->db->register()->id_pr;

            if ($id_pr_puesta != $data['general']->Id_Primer_Respondiente) {
                $sql =  "SELECT * FROM iph_primer_respondiente WHERE Id_Primer_Respondiente = " . $data['general']->Id_Primer_Respondiente;
                $this->db->query($sql);
                $data['primer_respondiente'] = $this->db->register();
            } else {
                $data['primer_respondiente'] = null;
            }

            $this->db->query("SELECT COUNT(*) AS contador FROM iph_testigo_objeto WHERE Id_Inventario = " . $data['general']->Id_Inventario_Objetos);
            $testigo_count =   $this->db->register()->contador;

            if ($testigo_count > 0) {
                $sql = "SELECT * FROM iph_testigo_objeto WHERE Id_Inventario = " . $data['general']->Id_Inventario_Objetos;
                $this->db->query($sql);
                $data['testigos'] =  $this->db->registers();
            } else {
                $data['testigos'] = null;
            }

            $return['success'] = true;
            $return['apartados'] = $data;

            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries

        } catch (Exception $err) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            $return['success'] = false;
            $return['error_message'] = $err;
        }
        return $return;
    }

    public function insertarAnexoDObjetos($post)
    {
        $response['status'] =  true;
        try {
            $this->db->beginTransaction();
            $IdPuesta = $post['Id_Puesta'];

            $this->db->query("SELECT Id_Primer_Respondiente AS id_pr FROM iph_puesta_disposicion WHERE Id_Puesta = " . $IdPuesta);
            $Id_Primer_Respondiente_Puesta = $this->db->register()->id_pr; //Id del primer respondiente de la puesta

            $aportacion =  (isset($post['Aportacion'])) ? 1 : 0;

            if (($post['respondiente']) == 'No') {
                $sql = "INSERT 
                        INTO iph_primer_respondiente(
                            Nombre_PR,
                            Ap_Paterno_PR,
                            Ap_Materno_PR,
                            Institucion,
                            Cargo
                        )
                        VALUES(
                            '" . $post['Nombre_PR'] . "',
                            '" . $post['Ap_Paterno_PR'] . "',
                            '" . $post['Ap_Materno_PR'] . "',
                            '" . $post['Institucion'] . "',
                            '" . $post['Cargo'] . "'
                        )";

                $this->db->query($sql);
                $this->db->execute();
            }


            $this->db->query("SELECT LAST_INSERT_ID() as Id_Primer_Respondiente");
            $Id_Primer_Respondiente = (($post['respondiente']) == 'No') ? $this->db->register()->Id_Primer_Respondiente : $Id_Primer_Respondiente_Puesta;

            $apariencia =  ($post['Apariencia'] == 'Otro' && $post['otro'] != '') ? $post['otro'] : $post['Apariencia'];
            $inspeccion = (isset($post['Inspeccion'] )) ? $post['Inspeccion'] : '';

            $sql = "INSERT 
                INTO iph_inventario_objeto(
                    Apariencia,
                    Aportacion,
                    Inspeccion,
                    Ubicacion_Objeto,
                    Descripcion_Objeto,
                    Destino,
                    Nombre_A,
                    Ap_Paterno_A,
                    Ap_Materno_A,
                    Id_Puesta,
                    Id_Primer_Respondiente
                    )
                    VALUES(
                        '" .  $apariencia . "',
                        b'" . $aportacion . "',
                        '" .  $inspeccion . "',
                        '" .  $post['Ubicacion_Objeto'] . "',
                        '" .  $post['Descripcion_Objeto'] . "',
                        '" .  $post['Destino'] . "',
                        '" .  $post['Nombre_A'] . "',
                        '" .  $post['Ap_Paterno_A'] . "',
                        '" .  $post['Ap_Materno_A'] . "',
                        " . $IdPuesta . ",
                        " . $Id_Primer_Respondiente . " 
                    )";
            $this->db->query($sql);
            $this->db->execute();

            if ($post['testigos'] == 'Si') {
                $this->db->query("SELECT LAST_INSERT_ID() as Id_Inventario");
                $Id_Inventario = $this->db->register()->Id_Inventario;
                for ($i = 0; $i < 2; $i++) {
                    $sql = "INSERT 
                        INTO iph_testigo_objeto(
                            Nombre_TO,
                            Ap_Paterno_TO,
                            Ap_Materno_TO,
                            Id_Inventario
                        )
                        VALUES(
                            '" . $post["Nombre_TO_$i"] . "',
                            '" . $post["Ap_Paterno_TO_$i"] . "',
                            '" . $post["Ap_Materno_TO_$i"] . "',
                            "  . $Id_Inventario . "
                        )";

                    $this->db->query($sql);
                    $this->db->execute();
                }
            }
            $this->db->commit();
            $response['status'] = true;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollBack(); //si algo falla realiza el rollBack por seguridad
        }

        return $response;
    }


    public function insertarAnexoF($post)
    {
        $response['status'] =  true;
        try {
            $this->db->beginTransaction();
            $IdPuesta = $post['Id_Puesta'];
            $Descripcion_Apoyo = ($post['autoridad'] == 'Si') ?  trim($post['Descripcion_Apoyo']) : '';
            $Motivo_Ingreso =  ($post['persona'] == 'Si') ? trim($post['Motivo_Ingreso']) : '';

            $sql = "INSERT 
                    INTO iph_entrega_recepcion_lugar(
                        Descripcion_PL,
                        Descripcion_Apoyo,
                        Motivo_Ingreso,
                        Fecha_Hora_Recepcion,
                        Id_Puesta,
                        Observaciones_Entrega_Recibe
                    )VALUES(
                        '" . trim($post['Descripcion_PL']) . "',
                        '" . $Descripcion_Apoyo . "',
                        '" . $Motivo_Ingreso . "',
                        '" . $post['Fecha'] . " " . $post['Hora'] . "',
                        " . $IdPuesta . ",
                        '" . $post['Observaciones'] . "'
                    )";

            $this->db->query($sql);
            $this->db->execute();

            $this->db->query("SELECT LAST_INSERT_ID() as Id_Entrega_Lugar");
            $Id_Entrega_Lugar = $this->db->register()->Id_Entrega_Lugar;

            if ($post['persona'] == 'Si') {
                $elementos_intervencion =  json_decode($post['elementos_intervencion']);
                foreach ($elementos_intervencion as $elem) {
                    $sql = "INSERT 
                        INTO iph_persona_lugar_intervencion(
                            Id_Entrega_Lugar,
                            Nombre_PLI,
                            Ap_Paterno_PLI,
                            Ap_Materno_PLI,
                            Cargo,
                            Institucion
                        )VALUES(
                            " . $Id_Entrega_Lugar . ",
                            '" .  trim($elem->row->Nombre_PLI) . "',
                            '" .  trim($elem->row->Ap_Paterno_PLI) . "',
                            '" .  trim($elem->row->Ap_Materno_PLI) . "',
                            '" .  trim($elem->row->Cargo) . "',
                            '" .  trim($elem->row->Institucion) . "'
                        )";

                    $this->db->query($sql);
                    $this->db->execute();
                }
            }

            $sql = "INSERT 
                    INTO iph_persona_entrega_recibe(
                        Id_Entrega_Lugar,
                        Entrega_Recibe,
                        Nombre_PER,
                        Ap_Paterno_PER,
                        Ap_Materno_PER,
                        Cargo,
                        Institucion
                    )VALUES(
                        " . $Id_Entrega_Lugar . ",
                        b'" . 0 . "',
                        '" . trim($post['Nombre_PER_0']) . "',
                        '" . trim($post['Ap_Paterno_PER_0']) . "',
                        '" . trim($post['Ap_Materno_PER_0']) . "',
                        '" . trim($post['Cargo_0']) . "',
                        '" . trim($post['Institucion_0']) . "'
                    )";

            $this->db->query($sql);
            $this->db->execute();

            $sql = "INSERT 
                    INTO iph_persona_entrega_recibe(
                        Id_Entrega_Lugar,
                        Entrega_Recibe,
                        Nombre_PER,
                        Ap_Paterno_PER,
                        Ap_Materno_PER,
                        Cargo,
                        Institucion
                    )VALUES(
                        " . $Id_Entrega_Lugar . ",
                        b'" . 1 . "',
                        '" . trim($post['Nombre_PER_1']) . "',
                        '" . trim($post['Ap_Paterno_PER_1']) . "',
                        '" . trim($post['Ap_Materno_PER_1']) . "',
                        '" . trim($post['Cargo_1']) . "',
                        '" . trim($post['Institucion_1']) . "'
                    )";

            $this->db->query($sql);
            $this->db->execute();

            $this->db->commit();
            $response['status'] = true;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollBack(); //si algo falla realiza el rollBack por seguridad
        }

        return $response;
    }

    public function actualizarAnexoF($post)
    {
        $response['status'] =  true;
        try {
            $this->db->beginTransaction();
            // $IdPuesta = $post['Id_Puesta'];
            $Descripcion_Apoyo = ($post['autoridad'] == 'Si') ?  trim($post['Descripcion_Apoyo']) : '';
            $Motivo_Ingreso =  ($post['persona'] == 'Si') ? trim($post['Motivo_Ingreso']) : '';
            $Id_Entrega_Lugar = $post['Id_Entrega_Recepcion_Lugar'];

            $sql =  "UPDATE iph_entrega_recepcion_lugar
                    SET Descripcion_PL                  =  '" . trim($post['Descripcion_PL']) . "',
                        Descripcion_Apoyo               =  '" . $Descripcion_Apoyo . "',
                        Motivo_Ingreso                  =  '" . $Motivo_Ingreso . "',
                        Fecha_Hora_Recepcion            =  '" . $post['Fecha'] . " " . $post['Hora'] . "',
                        Observaciones_Entrega_Recibe    =  '" . $post['Observaciones'] . "' 
                        WHERE Id_Entrega_Recepcion_Lugar = " . $Id_Entrega_Lugar;
            $this->db->query($sql);
            $this->db->execute();

            $this->db->query("SELECT COUNT(*) AS count_personal_intervencion FROM iph_persona_lugar_intervencion WHERE Id_Entrega_Lugar = " . $Id_Entrega_Lugar);
            $count_personal_intervencion =  $this->db->register()->count_personal_intervencion;

            switch ($post['persona']) {
                case 'Si':
                    if ($count_personal_intervencion > 0) {
                        $sql = "DELETE FROM iph_persona_lugar_intervencion WHERE Id_Entrega_Lugar =" . $Id_Entrega_Lugar;
                        $this->db->query($sql);
                        $this->db->execute();

                        $elementos_intervencion =  json_decode($post['elementos_intervencion']);
                        foreach ($elementos_intervencion as $elem) {
                            $sql = "INSERT 
                        INTO iph_persona_lugar_intervencion(
                            Id_Entrega_Lugar,
                            Nombre_PLI,
                            Ap_Paterno_PLI,
                            Ap_Materno_PLI,
                            Cargo,
                            Institucion
                        )VALUES(
                            " . $Id_Entrega_Lugar . ",
                            '" .  trim($elem->row->Nombre_PLI) . "',
                            '" .  trim($elem->row->Ap_Paterno_PLI) . "',
                            '" .  trim($elem->row->Ap_Materno_PLI) . "',
                            '" .  trim($elem->row->Cargo) . "',
                            '" .  trim($elem->row->Institucion) . "'
                        )";

                            $this->db->query($sql);
                            $this->db->execute();
                        }
                    } else if ($count_personal_intervencion == 0) {

                        $elementos_intervencion =  json_decode($post['elementos_intervencion']);
                        foreach ($elementos_intervencion as $elem) {
                            $sql = "INSERT 
                                    INTO iph_persona_lugar_intervencion(
                                        Id_Entrega_Lugar,
                                        Nombre_PLI,
                                        Ap_Paterno_PLI,
                                        Ap_Materno_PLI,
                                        Cargo,
                                        Institucion
                                    )VALUES(
                                        " . $Id_Entrega_Lugar . ",
                                        '" .  trim($elem->row->Nombre_PLI) . "',
                                        '" .  trim($elem->row->Ap_Paterno_PLI) . "',
                                        '" .  trim($elem->row->Ap_Materno_PLI) . "',
                                        '" .  trim($elem->row->Cargo) . "',
                                        '" .  trim($elem->row->Institucion) . "'
                                    )";

                            $this->db->query($sql);
                            $this->db->execute();
                        }
                    }

                    break;

                case 'No':
                    if ($count_personal_intervencion > 0) {
                        $sql = "DELETE FROM iph_persona_lugar_intervencion WHERE Id_Entrega_Lugar =" . $Id_Entrega_Lugar;
                        $this->db->query($sql);
                        $this->db->execute();
                    }
                    break;
            }

            $sql =  "UPDATE iph_persona_entrega_recibe
                    SET Entrega_Recibe  = b'" . 0 . "',
                        Nombre_PER      = '" . trim($post['Nombre_PER_0']) . "',
                        Ap_Paterno_PER  = '" . trim($post['Ap_Paterno_PER_0']) . "',
                        Ap_Materno_PER  = '" . trim($post['Ap_Materno_PER_0']) . "',
                        Cargo           = '" . trim($post['Cargo_0']) . "',
                        Institucion     = '" . trim($post['Institucion_0']) . "'
                        WHERE Id_Entrega_Lugar = " . $Id_Entrega_Lugar . " AND Entrega_Recibe = " . 0;

            $this->db->query($sql);
            $this->db->execute();

            $sql =  "UPDATE iph_persona_entrega_recibe
                    SET Entrega_Recibe  = b'" . 1 . "',
                        Nombre_PER      = '" . trim($post['Nombre_PER_1']) . "',
                        Ap_Paterno_PER  = '" . trim($post['Ap_Paterno_PER_1']) . "',
                        Ap_Materno_PER  = '" . trim($post['Ap_Materno_PER_1']) . "',
                        Cargo           = '" . trim($post['Cargo_1']) . "',
                        Institucion     = '" . trim($post['Institucion_1']) . "'
                        WHERE Id_Entrega_Lugar = " . $Id_Entrega_Lugar . " AND Entrega_Recibe = " . 1;

            $this->db->query($sql);
            $this->db->execute();

            $this->db->commit();
            $response['status'] = true;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollBack(); //si algo falla realiza el rollBack por seguridad
        }

        return $response;
    }

    public function getInfoAnexoF($id_puesta, $id_elem)
    {
        try {
            $this->db->beginTransaction(); //inicio de transaction

            $return['success'] = false;
            $return['error_message'] = '';

            $sql =  "SELECT Estatus AS estado FROM iph_puesta_disposicion WHERE Id_Puesta = " . $id_puesta;
            $this->db->query($sql);
            $data['estatus'] = $this->db->register()->estado;

            $sql =  "SELECT * FROM iph_entrega_recepcion_lugar WHERE Id_Puesta = " . $id_puesta . " AND Id_Entrega_Recepcion_Lugar = " . $id_elem;
            $this->db->query($sql);
            $data['general'] = $this->db->register();

            if ($data['general']->Motivo_Ingreso != '') {
                $sql = "SELECT * FROM iph_persona_lugar_intervencion WHERE Id_Entrega_Lugar = " . $id_elem;
                $this->db->query($sql);
                $data['personal_intervencion'] = $this->db->registers();
            } else {
                $data['personal_intervencion'] =  null;
            }

            $sql = "SELECT * FROM iph_persona_entrega_recibe WHERE Id_Entrega_Lugar = " . $id_elem;
            $this->db->query($sql);
            $data['persona_entrega'] =   ($this->db->registers()[0]->Entrega_Recibe == '0') ? $this->db->registers()[0] : $this->db->registers()[1];
            $data['persona_recibe'] =   ($this->db->registers()[0]->Entrega_Recibe == '1') ? $this->db->registers()[0] : $this->db->registers()[1];













            // $sql =  "SELECT * FROM iph_inventario_arma WHERE Id_Puesta =  $id_puesta AND Id_Inventario_Arma = $id_elem ";
            // $this->db->query($sql);
            // $data['general'] = $this->db->register();

            // $this->db->query("SELECT Id_Primer_Respondiente AS id_pr FROM iph_puesta_disposicion WHERE Id_Puesta = " . $id_puesta);
            // $id_pr_puesta = $this->db->register()->id_pr;

            // if ($id_pr_puesta != $data['general']->Id_Primer_Respondiente) {
            //     $sql =  "SELECT * FROM iph_primer_respondiente WHERE Id_Primer_Respondiente = " . $data['general']->Id_Primer_Respondiente;
            //     $this->db->query($sql);
            //     $data['primer_respondiente'] = $this->db->register();
            // } else {
            //     $data['primer_respondiente'] = null;
            // }

            // $this->db->query("SELECT COUNT(*) AS contador FROM iph_testigo_arma WHERE Id_Inventario = " . $data['general']->Id_Inventario_Arma);
            // $testigo_count =   $this->db->register()->contador;

            // if ($testigo_count > 0) {
            //     $sql = "SELECT * FROM iph_testigo_arma WHERE Id_Inventario = " . $data['general']->Id_Inventario_Arma;
            //     $this->db->query($sql);
            //     $data['testigos'] =  $this->db->registers();
            // } else {
            //     $data['testigos'] = null;
            // }

            $return['success'] = true;
            $return['apartados'] = $data;

            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries

        } catch (Exception $err) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            $return['success'] = false;
            $return['error_message'] = $err;
        }
        return $return;
    }





/*-------------------------FUNCIONES HELPERS------------------------------*/
    public function existeRegistroTabla($tabla = null, $campos = [], $valores = [], $op = 'AND')
    { //comprueba la existencia de un registro en el campo de cierta tabla
        if ($tabla == null || $campos == [] || $valores == [] || (count($campos) != count($valores))) {
            return false;
        }
        try {
            //preparar sentencia Where
            $where_sentence = '';
            $count = count($campos) - 1;
            foreach ($campos as $ind => $campo) {
                if ($count == $ind) {
                    $where_sentence .= $campo . " = " . $valores[$ind] . " ";
                } else {
                    $where_sentence .= $campo . " = '" . $valores[$ind] . "' $op ";
                }
            }
            $sql = "SELECT * FROM " . $tabla . " WHERE " . $where_sentence;
            $this->db->query($sql);
            return $this->db->register();
        } catch (Exception $err) {
            return false;
        }
    }
    private function mi_trim($cadena = null)
    {
        if ($cadena == null) return '';
        return implode(' ', array_filter(explode(' ', $cadena)));
    }
/*-------------------------FIN FUNCIONES HELPERS------------------------------*/

/*-------------------------FUNCIONES ANEXO A------------------------------*/
    public function getAnexosA($id_puesta)
    {
        try {
            //get all anexos A
            $sql = "
            SELECT 	    iph_detenido.Id_Detenido, iph_detenido.Id_Puesta,
                        CONCAT_WS('',iph_detenido.Nombre_D,' ',iph_detenido.Ap_Paterno_D,' ',iph_detenido.Ap_Materno_D) AS Nombre_Detenido, 
                        iph_detenido.Fecha_Hora, 
                        iph_detenido.Edad 
            FROM iph_detenido 
            WHERE iph_detenido.Id_Puesta = $id_puesta AND Status = 1";

            $this->db->query($sql);
            return $this->db->registers();
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function insertAnexoA($post = null)
    {
        /** Orden de inserciones:
         * domicilio
         * ubicación de detención/intervención
         * primer y segundo respondiente
         * detenido
         * familiar
         * pertenencias
         */
        try {
            $this->db->beginTransaction(); //inicio de transaction

            $return['success'] = false;
            $return['error_message'] = '';

            //DOMICILIO DEL DETENIDO
            $Colonia_Dom_Detenido       = (isset($post['Colonia_Dom_Detenido'])) ? $post['Colonia_Dom_Detenido'] : '';
            $Calle_1_Dom_Detenido       = (isset($post['Calle_1_Dom_Detenido'])) ? $post['Calle_1_Dom_Detenido'] : '';
            $No_Ext_Dom_Detenido        = (isset($post['No_Ext_Dom_Detenido'])) ? $post['No_Ext_Dom_Detenido'] : '';
            $No_Int_Dom_Detenido        = (isset($post['No_Int_Dom_Detenido'])) ? $post['No_Int_Dom_Detenido'] : '';
            $Coordenada_X_Dom_Detenido  = (isset($post['Coordenada_X_Dom_Detenido'])) ? $post['Coordenada_X_Dom_Detenido'] : '';
            $Coordenada_Y_Dom_Detenido  = (isset($post['Coordenada_Y_Dom_Detenido'])) ? $post['Coordenada_Y_Dom_Detenido'] : '';
            $Estado_Dom_Detenido        = (isset($post['Estado_Dom_Detenido'])) ? $post['Estado_Dom_Detenido'] : '';
            $Municipio_Dom_Detenido     = (isset($post['Municipio_Dom_Detenido'])) ? $post['Municipio_Dom_Detenido'] : '';
            $CP_Dom_Detenido            = (isset($post['CP_Dom_Detenido'])) ? $post['CP_Dom_Detenido'] : '';
            $Referencias_Dom            = (isset($post['Referencias_Dom'])) ? $post['Referencias_Dom'] : '';

            $sql = "INSERT    INTO domicilio( 
                                                Colonia, 
                                                Calle, 
                                                No_Exterior, 
                                                No_Interior, 
                                                Coordenada_X, 
                                                Coordenada_Y, 
                                                Estado, 
                                                Municipio, 
                                                CP, 
                                                Referencias 
                                            ) 
                                VALUES(
                                    '" . $Colonia_Dom_Detenido . "', 
                                    '" . $Calle_1_Dom_Detenido . "', 
                                    '" . $No_Ext_Dom_Detenido . "', 
                                    '" . $No_Int_Dom_Detenido . "', 
                                    '" . $Coordenada_X_Dom_Detenido . "', 
                                    '" . $Coordenada_Y_Dom_Detenido . "', 
                                    '" . $Estado_Dom_Detenido . "', 
                                    '" . $Municipio_Dom_Detenido . "', 
                                    '" . $CP_Dom_Detenido . "', 
                                    '" . $Referencias_Dom . "' 
                                )";

            $this->db->query($sql);
            $this->db->execute();
            $this->db->query("SELECT LAST_INSERT_ID() as Id_Domicilio"); //se recupera el id del domicilio
            $Id_Domicilio = $this->db->register()->Id_Domicilio;

            //UBICACIÓN DEL LUGAR DE LA DETENCIÓN
            $Id_Ubicacion = -1;
            if ($post['Ubicacion_Det_Radio'] != 'Sí') { //se inserta nueva ubicación de la intervención
                $Colonia_Ubi_Det        = (isset($post['Colonia_Ubi_Det'])) ? $post['Colonia_Ubi_Det'] : '';
                $Calle_1_Ubi_Det        = (isset($post['Calle_1_Ubi_Det'])) ? $post['Calle_1_Ubi_Det'] : '';
                $Calle_2_Ubi_Det        = (isset($post['Calle_2_Ubi_Det'])) ? $post['Calle_2_Ubi_Det'] : '';
                $No_Ext_Ubi_Det         = (isset($post['No_Ext_Ubi_Det'])) ? $post['No_Ext_Ubi_Det'] : '';
                $No_Int_Ubi_Det         = (isset($post['No_Int_Ubi_Det'])) ? $post['No_Int_Ubi_Det'] : '';
                $Coordenada_X_Ubi_Det   = (isset($post['Coordenada_X_Ubi_Det'])) ? $post['Coordenada_X_Ubi_Det'] : '';
                $Coordenada_Y_Ubi_Det   = (isset($post['Coordenada_Y_Ubi_Det'])) ? $post['Coordenada_Y_Ubi_Det'] : '';
                $Estado_Ubi_Det         = (isset($post['Estado_Ubi_Det'])) ? $post['Estado_Ubi_Det'] : '';
                $Municipio_Ubi_Det      = (isset($post['Municipio_Ubi_Det'])) ? $post['Municipio_Ubi_Det'] : '';
                $CP_Ubi_Det             = (isset($post['CP_Ubi_Det'])) ? $post['CP_Ubi_Det'] : '';
                $Referencias_Ubi_Det    = (isset($post['Referencias_Ubi_Det'])) ? $post['Referencias_Ubi_Det'] : '';

                $sql = "INSERT    INTO ubicacion( 
                                                    Colonia, 
                                                    Calle_1, 
                                                    Calle_2, 
                                                    No_Ext, 
                                                    No_Int, 
                                                    Coordenada_X, 
                                                    Coordenada_Y, 
                                                    Estado, 
                                                    Municipio, 
                                                    CP,
                                                    Referencias
                                                ) 
                                    VALUES(
                                        '" . $Colonia_Ubi_Det . "', 
                                        '" . $Calle_1_Ubi_Det . "', 
                                        '" . $Calle_2_Ubi_Det . "', 
                                        '" . $No_Ext_Ubi_Det . "', 
                                        '" . $No_Int_Ubi_Det . "', 
                                        '" . $Coordenada_X_Ubi_Det . "', 
                                        '" . $Coordenada_Y_Ubi_Det . "', 
                                        '" . $Estado_Ubi_Det . "', 
                                        '" . $Municipio_Ubi_Det . "', 
                                        '" . $CP_Ubi_Det . "', 
                                        '" . $Referencias_Ubi_Det . "' 
                                    )";
                $this->db->query($sql);
                $this->db->execute();
                $this->db->query("SELECT LAST_INSERT_ID() as Id_Ubicacion"); //se recupera el id del domicilio
                $Id_Ubicacion = $this->db->register()->Id_Ubicacion;
            } else { //solo se recupera el id de la ubicación de la tabla de lugar de intervención
                $sql = "SELECT Id_Ubicacion FROM iph_lugar_intervencion WHERE Id_Puesta = " . $post['Id_Puesta'];
                $this->db->query($sql);
                $Id_Ubicacion = $this->db->register()->Id_Ubicacion;
            }

            //ELEMENTOS PARTICIPANTES
            $Id_Primer_Respondiente = -1;
            $Id_Segundo_Respondiente = -1;
            if ($post['Primer_Respondiente_Radio'] != 'No') { //se inserta nuevo elemento 
                $Nombre_PR      = (isset($post['Nombre_PR'])) ? $post['Nombre_PR'] : '';
                $Ap_Paterno_PR  = (isset($post['Ap_Paterno_PR'])) ? $post['Ap_Paterno_PR'] : '';
                $Ap_Materno_PR  = (isset($post['Ap_Materno_PR'])) ? $post['Ap_Materno_PR'] : '';
                $Institucion_PR = (isset($post['Institucion_PR'])) ? $post['Institucion_PR'] : '';
                $Cargo_PR       = (isset($post['Cargo_PR'])) ? $post['Cargo_PR'] : '';
                $No_Control_PR  = (isset($post['No_Control_PR'])) ? $post['No_Control_PR'] : '';


                $sql = "INSERT    INTO iph_primer_respondiente( 
                                                    Nombre_PR, 
                                                    Ap_Paterno_PR, 
                                                    Ap_Materno_PR, 
                                                    Institucion, 
                                                    Cargo, 
                                                    No_Control
                                                ) 
                                    VALUES(
                                        '" . $Nombre_PR . "', 
                                        '" . $Ap_Paterno_PR . "', 
                                        '" . $Ap_Materno_PR . "', 
                                        '" . $Institucion_PR . "', 
                                        '" . $Cargo_PR . "', 
                                        '" . $No_Control_PR . "' 
                                    )";
                $this->db->query($sql);
                $this->db->execute();
                $this->db->query("SELECT LAST_INSERT_ID() as Id_Primer_Respondiente"); //se recupera el id del domicilio
                $Id_Primer_Respondiente = $this->db->register()->Id_Primer_Respondiente;

                // SEGUNDO RESPONDIENTE
                $Nombre_SR      = (isset($post['Nombre_SR'])) ? $post['Nombre_SR'] : '';
                $Ap_Paterno_SR  = (isset($post['Ap_Paterno_SR'])) ? $post['Ap_Paterno_SR'] : '';
                $Ap_Materno_SR  = (isset($post['Ap_Materno_SR'])) ? $post['Ap_Materno_SR'] : '';
                $Institucion_SR = (isset($post['Institucion_SR'])) ? $post['Institucion_SR'] : '';
                $Cargo_SR       = (isset($post['Cargo_SR'])) ? $post['Cargo_SR'] : '';
                $No_Control_SR  = (isset($post['No_Control_SR'])) ? $post['No_Control_SR'] : '';


                $sql = "INSERT    INTO iph_primer_respondiente( 
                                                    Nombre_PR, 
                                                    Ap_Paterno_PR, 
                                                    Ap_Materno_PR, 
                                                    Institucion, 
                                                    Cargo, 
                                                    No_Control
                                                ) 
                                    VALUES(
                                        '" . $Nombre_SR . "', 
                                        '" . $Ap_Paterno_SR . "', 
                                        '" . $Ap_Materno_SR . "', 
                                        '" . $Institucion_SR . "', 
                                        '" . $Cargo_SR . "', 
                                        '" . $No_Control_SR . "' 
                                    )";
                $this->db->query($sql);
                $this->db->execute();
                $this->db->query("SELECT LAST_INSERT_ID() as Id_Segundo_Respondiente"); //se recupera el id del domicilio
                $Id_Segundo_Respondiente = $this->db->register()->Id_Segundo_Respondiente;
            } else { //se recupera el id del primer respondiente de la puesta
                $sql = "SELECT Id_Primer_Respondiente FROM iph_puesta_disposicion WHERE Id_Puesta = " . $post['Id_Puesta'];
                $this->db->query($sql);
                $Id_Primer_Respondiente = $this->db->register()->Id_Primer_Respondiente;
                $Id_Segundo_Respondiente = 1; //primer respondiente null
            }
            //DETENIDO INFO GENERAL
            $Num_Detencion      = (isset($post['Num_Detencion'])) ?  $post['Num_Detencion'] : '';
            $Fecha              = (isset($post['Fecha'])) ?          $post['Fecha'] : '';
            $Hora               = (isset($post['Hora'])) ?           $post['Hora'] : '';
            $Nombre_D           = (isset($post['Nombre_D'])) ?       $post['Nombre_D'] : '';
            $Ap_Paterno_D       = (isset($post['Ap_Paterno_D'])) ?   $post['Ap_Paterno_D'] : '';
            $Ap_Materno_D       = (isset($post['Ap_Materno_D'])) ?   $post['Ap_Materno_D'] : '';
            $Apodo              = (isset($post['Apodo'])) ?          $post['Apodo'] : '';
            $Nacionalidad       = ($post['Nacionalidad_Radio'] != 'MEXICANA') ? $post['Nacionalidad_Otro'] : 'MEXICANA';
            $Genero             = (isset($post['Genero'])) ?          $post['Genero'] : '';
            $Fecha_Nacimiento   = (isset($post['Fecha_Nacimiento'])) ? $post['Fecha_Nacimiento'] : '';
            $Edad               = (isset($post['Edad'])) ? $post['Edad'] : '';
            $Identificacion     = ($post['Identificacion'] == 'Otro') ? $post['Identificacion_Otro'] : $post['Identificacion'];
            $Num_Identificacion = (isset($post['Num_Identificacion'])) ? $post['Num_Identificacion'] : '';

            $Descripcion_Detenido  = (isset($post['Descripcion_Detenido'])) ? $post['Descripcion_Detenido'] : '';
            $Lesiones           = ($post['Lesiones'] == 'No') ? '0' : '1';
            $Descripcion_Padecimiento   = ($post['Padecimiento_Radio'] != 'No') ? $post['Descripcion_Padecimiento'] : '';
            $Grupo_Vulnerable   = ($post['Grupo_V_Radio'] != 'No') ? $post['Grupo_Vulnerable'] : '';
            $Grupo_Delictivo    = ($post['Grupo_D_Radio'] != 'No') ? $post['Grupo_Delictivo'] : '';
            $Lectura_Derechos   = ($post['Lectura_Derechos'] == 'No') ? '0' : '1';
            $Objeto_Encontrado          = ($post['Objeto_Encontrado'] == 'No') ? '0' : '1';
            $Pertenencias_Encontradas   = ($post['Pertenencias_Encontradas'] == 'No') ? '0' : '1';

            $Lugar_Traslado             = (isset($post['Lugar_Traslado'])) ? $post['Lugar_Traslado'] : '';
            $Descripcion_Traslado       = (isset($post['Descripcion_Traslado'])) ? $post['Descripcion_Traslado'] : '';
            $Observaciones_Detencion    = (isset($post['Observaciones_Detencion'])) ? $post['Observaciones_Detencion'] : '';

            $sql = "INSERT    INTO iph_detenido( 
                                                Num_Detencion, 
                                                Fecha_Hora, 
                                                Nombre_D, 
                                                Ap_Paterno_D, 
                                                Ap_Materno_D, 
                                                Apodo, 
                                                Nacionalidad, 
                                                Genero, 
                                                Fecha_Nacimiento, 
                                                Edad, 
                                                Identificacion, 
                                                Num_Identificacion, 
                                                Descripcion_Detenido, 
                                                Lesiones, 
                                                Descripcion_Padecimiento, 
                                                Grupo_Vulnerable, 
                                                Grupo_Delictivo, 
                                                Lectura_Derechos, 
                                                Objeto_Encontrado, 
                                                Pertenencias_Encontradas, 
                                                Lugar_Traslado, 
                                                Descripcion_Traslado, 
                                                Observaciones_Detencion,
                                                
                                                Id_Domicilio,
                                                Id_Ubicacion_Detencion,
                                                Id_Primer_Respondiente,
                                                Id_Segundo_Respondiente,
                                                Id_Puesta
                                                
                                            ) 
                                VALUES(
                                    '" . $Num_Detencion . "', 
                                    '" . $Fecha . " " . $Hora . "', 
                                    '" . $Nombre_D . "', 
                                    '" . $Ap_Paterno_D . "', 
                                    '" . $Ap_Materno_D . "', 
                                    '" . $Apodo . "', 
                                    '" . $Nacionalidad . "', 
                                    '" . $Genero . "', 
                                    '" . $Fecha_Nacimiento . "', 
                                    '" . $Edad . "', 
                                    '" . $Identificacion . "', 
                                    '" . $Num_Identificacion . "', 
                                    '" . $Descripcion_Detenido . "', 
                                    b'" . $Lesiones . "', 
                                    '" . $Descripcion_Padecimiento . "', 
                                    '" . $Grupo_Vulnerable . "', 
                                    '" . $Grupo_Delictivo . "', 
                                    b'" . $Lectura_Derechos . "', 
                                    b'" . $Objeto_Encontrado . "', 
                                    b'" . $Pertenencias_Encontradas . "', 
                                    '" . $Lugar_Traslado . "', 
                                    '" . $Descripcion_Traslado . "', 
                                    '" . $Observaciones_Detencion . "',
                                    
                                    '" . $Id_Domicilio . "', 
                                    '" . $Id_Ubicacion . "', 
                                    '" . $Id_Primer_Respondiente . "', 
                                    '" . $Id_Segundo_Respondiente . "', 
                                    '" . $post['Id_Puesta'] . "'
                                )";

            $this->db->query($sql);
            $this->db->execute();
            $this->db->query("SELECT LAST_INSERT_ID() as Id_Detenido"); //se recupera el id del domicilio
            $Id_Detenido = $this->db->register()->Id_Detenido;
            $return['id_detenido'] = $Id_Detenido;

            //intermedio se retorna la info del primer respondiente para remisión
            $sql = "SELECT * FROM iph_primer_respondiente WHERE Id_Primer_Respondiente = $Id_Primer_Respondiente";
            $this->db->query($sql);
            $return['primer_resp'] = $this->db->register();

            //FAMILIAR DETENIDO
            if ($post['Familiar_Radio'] != 'No') {
                $Nombre_F      = (isset($post['Nombre_F'])) ? $post['Nombre_F'] : '';
                $Ap_Paterno_F  = (isset($post['Ap_Paterno_F'])) ? $post['Ap_Paterno_F'] : '';
                $Ap_Materno_F  = (isset($post['Ap_Materno_F'])) ? $post['Ap_Materno_F'] : '';
                $Telefono_F = (isset($post['Telefono_F'])) ? $post['Telefono_F'] : '';

                $sql = "INSERT    INTO iph_familiar_detenido( 
                                                    Id_Detenido_IPH,
                                                    Nombre_F, 
                                                    Ap_Paterno_F, 
                                                    Ap_Materno_F, 
                                                    Telefono_F
                                                ) 
                                    VALUES(
                                        " . $Id_Detenido . ",
                                        '" . $Nombre_F . "', 
                                        '" . $Ap_Paterno_F . "', 
                                        '" . $Ap_Materno_F . "', 
                                        '" . $Telefono_F . "'
                                    )";
                $this->db->query($sql);
                $this->db->execute();
            }

            //PERTENENCIAS DEL DETENIDO
            if ($post['Pertenencias_Encontradas'] != 'No') {

                $pertenenciasArray = json_decode($post['Pertenencias_Detenido']);
                foreach ($pertenenciasArray as $pertenencia) {
                    //se inserta persona
                    $sql = "INSERT
                                INTO iph_pertenencia_detenido(
                                    Id_Detenido_IPH,
                                    Pertenencia,
                                    Descripcion,
                                    Destino
                                )
                                VALUES(
                                    " . $Id_Detenido . ",
                                    '" . $this->mi_trim($pertenencia->Pertenencia) . "',
                                    '" . $this->mi_trim($pertenencia->Descripcion) . "',
                                    '" . $this->mi_trim($pertenencia->Destino) . "'
                                )
                        ";
                    $this->db->query($sql);
                    $this->db->execute();
                }
            }
            $return['success'] = true;
            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries

        } catch (Exception $err) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            $return['success'] = false;
            $return['error_message'] = $err;
        }

        return $return;
    }
    public function updateAnexoA($post = null)
    {
        /** Orden de updates:
         * domicilio
         * ubicación de detención/intervención
         * primer y segundo respondiente
         * detenido
         * familiar
         * pertenencias
         */
        try {
            $this->db->beginTransaction(); //inicio de transaction

            $return['success'] = false;
            $return['error_message'] = '';
            //Se recuperan todos los Id's auxiliares para los updates
            $sql = "SELECT Id_Domicilio,Id_Ubicacion_Detencion,Id_Primer_Respondiente,Id_Segundo_Respondiente FROM iph_detenido WHERE Id_Detenido = " . $post['Id_Detenido'];
            $this->db->query($sql);
            $infoAux = $this->db->register();
            $Id_Domicilio_Aux = $infoAux->Id_Domicilio;
            $Id_Ubi_Det_Aux = $infoAux->Id_Ubicacion_Detencion;
            $Id_PR_Aux = $infoAux->Id_Primer_Respondiente;
            $Id_SR_Aux = $infoAux->Id_Segundo_Respondiente;

            //DOMICILIO DEL DETENIDO
            $Colonia_Dom_Detenido       = (isset($post['Colonia_Dom_Detenido'])) ? $post['Colonia_Dom_Detenido'] : '';
            $Calle_1_Dom_Detenido       = (isset($post['Calle_1_Dom_Detenido'])) ? $post['Calle_1_Dom_Detenido'] : '';
            $No_Ext_Dom_Detenido        = (isset($post['No_Ext_Dom_Detenido'])) ? $post['No_Ext_Dom_Detenido'] : '';
            $No_Int_Dom_Detenido        = (isset($post['No_Int_Dom_Detenido'])) ? $post['No_Int_Dom_Detenido'] : '';
            $Coordenada_X_Dom_Detenido  = (isset($post['Coordenada_X_Dom_Detenido'])) ? $post['Coordenada_X_Dom_Detenido'] : '';
            $Coordenada_Y_Dom_Detenido  = (isset($post['Coordenada_Y_Dom_Detenido'])) ? $post['Coordenada_Y_Dom_Detenido'] : '';
            $Estado_Dom_Detenido        = (isset($post['Estado_Dom_Detenido'])) ? $post['Estado_Dom_Detenido'] : '';
            $Municipio_Dom_Detenido     = (isset($post['Municipio_Dom_Detenido'])) ? $post['Municipio_Dom_Detenido'] : '';
            $CP_Dom_Detenido            = (isset($post['CP_Dom_Detenido'])) ? $post['CP_Dom_Detenido'] : '';
            $Referencias_Dom            = (isset($post['Referencias_Dom'])) ? $post['Referencias_Dom'] : '';

            $sql = "UPDATE  domicilio   
                    SET  
                        Colonia         = '" . $Colonia_Dom_Detenido . "', 
                        Calle           = '" . $Calle_1_Dom_Detenido . "', 
                        No_Exterior     = '" . $No_Ext_Dom_Detenido . "', 
                        No_Interior     = '" . $No_Int_Dom_Detenido . "', 
                        Coordenada_X    = '" . $Coordenada_X_Dom_Detenido . "', 
                        Coordenada_Y    = '" . $Coordenada_Y_Dom_Detenido . "', 
                        Estado          = '" . $Estado_Dom_Detenido . "', 
                        Municipio       = '" . $Municipio_Dom_Detenido . "', 
                        CP              = '" . $CP_Dom_Detenido . "', 
                        Referencias     = '" . $Referencias_Dom . "' 
                    WHERE Id_Domicilio = " . $Id_Domicilio_Aux;

            $this->db->query($sql);
            $this->db->execute();


            //UBICACIÓN DEL LUGAR DE LA DETENCIÓN
            //se recupera primero el id de la ubicación del lugar de la intervención
            $sql = "SELECT Id_Ubicacion FROM iph_lugar_intervencion WHERE Id_Puesta = " . $post['Id_Puesta'];
            $this->db->query($sql);
            $Id_Ubicacion_LI = $this->db->register()->Id_Ubicacion;
            $Id_UbicacionFinal = -1;
            if ($post['Ubicacion_Det_Radio'] != 'Sí') { //se trata de otra dirección
                //campos del fomr
                $Colonia_Ubi_Det        = (isset($post['Colonia_Ubi_Det'])) ? $post['Colonia_Ubi_Det'] : '';
                $Calle_1_Ubi_Det        = (isset($post['Calle_1_Ubi_Det'])) ? $post['Calle_1_Ubi_Det'] : '';
                $Calle_2_Ubi_Det        = (isset($post['Calle_2_Ubi_Det'])) ? $post['Calle_2_Ubi_Det'] : '';
                $No_Ext_Ubi_Det         = (isset($post['No_Ext_Ubi_Det'])) ? $post['No_Ext_Ubi_Det'] : '';
                $No_Int_Ubi_Det         = (isset($post['No_Int_Ubi_Det'])) ? $post['No_Int_Ubi_Det'] : '';
                $Coordenada_X_Ubi_Det   = (isset($post['Coordenada_X_Ubi_Det'])) ? $post['Coordenada_X_Ubi_Det'] : '';
                $Coordenada_Y_Ubi_Det   = (isset($post['Coordenada_Y_Ubi_Det'])) ? $post['Coordenada_Y_Ubi_Det'] : '';
                $Estado_Ubi_Det         = (isset($post['Estado_Ubi_Det'])) ? $post['Estado_Ubi_Det'] : '';
                $Municipio_Ubi_Det      = (isset($post['Municipio_Ubi_Det'])) ? $post['Municipio_Ubi_Det'] : '';
                $CP_Ubi_Det             = (isset($post['CP_Ubi_Det'])) ? $post['CP_Ubi_Det'] : '';
                $Referencias_Ubi_Det    = (isset($post['Referencias_Ubi_Det'])) ? $post['Referencias_Ubi_Det'] : '';
                //se comprueba si anteriormente ya existia para actualizar o crear
                if ($Id_Ubicacion_LI == $Id_Ubi_Det_Aux) { //se crea porque quiere decir que anteriormente tenía el id del lugar de intervención
                    $sql = "INSERT    INTO ubicacion( 
                                            Colonia, 
                                            Calle_1, 
                                            Calle_2, 
                                            No_Ext, 
                                            No_Int, 
                                            Coordenada_X, 
                                            Coordenada_Y, 
                                            Estado, 
                                            Municipio, 
                                            CP,
                                            Referencias
                                        ) 
                            VALUES(
                                '" . $Colonia_Ubi_Det . "', 
                                '" . $Calle_1_Ubi_Det . "', 
                                '" . $Calle_2_Ubi_Det . "', 
                                '" . $No_Ext_Ubi_Det . "', 
                                '" . $No_Int_Ubi_Det . "', 
                                '" . $Coordenada_X_Ubi_Det . "', 
                                '" . $Coordenada_Y_Ubi_Det . "', 
                                '" . $Estado_Ubi_Det . "', 
                                '" . $Municipio_Ubi_Det . "', 
                                '" . $CP_Ubi_Det . "', 
                                '" . $Referencias_Ubi_Det . "'
                            )";
                    $this->db->query($sql);
                    $this->db->execute();
                    $this->db->query("SELECT LAST_INSERT_ID() as Id_Ubicacion"); //se recupera el id del domicilio
                    $Id_UbicacionFinal = $this->db->register()->Id_Ubicacion;
                } else { //se actualiza porque ya existe
                    $sql = "UPDATE  ubicacion   
                            SET  
                                Colonia         = '" . $Colonia_Ubi_Det . "', 
                                Calle_1         = '" . $Calle_1_Ubi_Det . "', 
                                Calle_2         = '" . $Calle_2_Ubi_Det . "', 
                                No_Ext          = '" . $No_Ext_Ubi_Det . "', 
                                No_Int          = '" . $No_Int_Ubi_Det . "', 
                                Coordenada_X    = '" . $Coordenada_X_Ubi_Det . "', 
                                Coordenada_Y    = '" . $Coordenada_Y_Ubi_Det . "', 
                                Estado          = '" . $Estado_Ubi_Det . "', 
                                Municipio       = '" . $Municipio_Ubi_Det . "', 
                                CP              = '" . $CP_Ubi_Det . "', 
                                Referencias     = '" . $Referencias_Ubi_Det . "' 
                                
                            WHERE Id_Ubicacion = " . $Id_Ubi_Det_Aux;
                    $this->db->query($sql);
                    $this->db->execute();
                    $Id_UbicacionFinal = $Id_Ubi_Det_Aux;
                }
            } else { //misma que la de intervención
                // si son diferentes quiere decir que apenas se lo asignaron como el mismo
                if ($Id_Ubicacion_LI != $Id_Ubi_Det_Aux) { //se borra primero el existente y luego se asigna el del lugar inter actual
                    //como auxiliar se asigna primero la del lugar inter
                    $sql = "UPDATE iph_detenido SET Id_Ubicacion_Detencion = $Id_Ubicacion_LI WHERE Id_Detenido = " . $post['Id_Detenido'];
                    $this->db->query($sql);
                    $this->db->execute();
                    $sql = "DELETE FROM ubicacion WHERE Id_Ubicacion = $Id_Ubi_Det_Aux";
                    $this->db->query($sql);
                    $this->db->execute();
                }
                $Id_UbicacionFinal = $Id_Ubicacion_LI;
            }

            //ELEMENTOS PARTICIPANTES
            //se recupera el pr de la puesta
            $sql = "SELECT Id_Primer_Respondiente FROM iph_puesta_disposicion WHERE Id_Puesta = " . $post['Id_Puesta'];
            $this->db->query($sql);
            $Id_PR_Puesta = $this->db->register()->Id_Primer_Respondiente;
            $Id_PR_Final = -1;
            $Id_SR_Final = -1;
            if ($post['Primer_Respondiente_Radio'] != 'No') { //se inserta nuevo elemento 
                $Nombre_PR      = (isset($post['Nombre_PR'])) ? $post['Nombre_PR'] : '';
                $Ap_Paterno_PR  = (isset($post['Ap_Paterno_PR'])) ? $post['Ap_Paterno_PR'] : '';
                $Ap_Materno_PR  = (isset($post['Ap_Materno_PR'])) ? $post['Ap_Materno_PR'] : '';
                $Institucion_PR = (isset($post['Institucion_PR'])) ? $post['Institucion_PR'] : '';
                $Cargo_PR       = (isset($post['Cargo_PR'])) ? $post['Cargo_PR'] : '';
                $No_Control_PR  = (isset($post['No_Control_PR'])) ? $post['No_Control_PR'] : '';
                // SEGUNDO RESPONDIENTE
                $Nombre_SR      = (isset($post['Nombre_SR'])) ? $post['Nombre_SR'] : '';
                $Ap_Paterno_SR  = (isset($post['Ap_Paterno_SR'])) ? $post['Ap_Paterno_SR'] : '';
                $Ap_Materno_SR  = (isset($post['Ap_Materno_SR'])) ? $post['Ap_Materno_SR'] : '';
                $Institucion_SR = (isset($post['Institucion_SR'])) ? $post['Institucion_SR'] : '';
                $Cargo_SR       = (isset($post['Cargo_SR'])) ? $post['Cargo_SR'] : '';
                $No_Control_SR  = (isset($post['No_Control_SR'])) ? $post['No_Control_SR'] : '';
                //se comprueba si anteriormente ya existia para actualizar o crear
                if ($Id_PR_Puesta == $Id_PR_Aux) { //se crea porque quiere decir que anteriormente tenía el id del pr de la puesta
                    $sql = "INSERT    INTO iph_primer_respondiente( 
                                            Nombre_PR, 
                                            Ap_Paterno_PR, 
                                            Ap_Materno_PR, 
                                            Institucion, 
                                            Cargo, 
                                            No_Control
                                        ) 
                            VALUES(
                                '" . $Nombre_PR . "', 
                                '" . $Ap_Paterno_PR . "', 
                                '" . $Ap_Materno_PR . "', 
                                '" . $Institucion_PR . "', 
                                '" . $Cargo_PR . "', 
                                '" . $No_Control_PR . "' 
                            )";
                    $this->db->query($sql);
                    $this->db->execute();
                    $this->db->query("SELECT LAST_INSERT_ID() as Id_Primer_Respondiente"); //se recupera el id del domicilio
                    $Id_PR_Final = $this->db->register()->Id_Primer_Respondiente;
                    // SEGUNDO RESPONDIENTE
                    $sql = "INSERT    INTO iph_primer_respondiente( 
                                                        Nombre_PR, 
                                                        Ap_Paterno_PR, 
                                                        Ap_Materno_PR, 
                                                        Institucion, 
                                                        Cargo, 
                                                        No_Control
                                                    ) 
                                        VALUES(
                                            '" . $Nombre_SR . "', 
                                            '" . $Ap_Paterno_SR . "', 
                                            '" . $Ap_Materno_SR . "', 
                                            '" . $Institucion_SR . "', 
                                            '" . $Cargo_SR . "', 
                                            '" . $No_Control_SR . "' 
                                        )";
                    $this->db->query($sql);
                    $this->db->execute();
                    $this->db->query("SELECT LAST_INSERT_ID() as Id_Segundo_Respondiente"); //se recupera el id del domicilio
                    $Id_SR_Final = $this->db->register()->Id_Segundo_Respondiente;
                } else { //se actualiza porque ya existe el id del pr
                    $sql = "UPDATE  iph_primer_respondiente   
                            SET  
                                Nombre_PR       = '" . $Nombre_PR . "', 
                                Ap_Paterno_PR   = '" . $Ap_Paterno_PR . "',  
                                Ap_Materno_PR   = '" . $Ap_Materno_PR . "',  
                                Institucion     = '" . $Institucion_PR . "', 
                                Cargo           = '" . $Cargo_PR . "', 
                                No_Control      = '" . $No_Control_PR . "'                                 
                            WHERE Id_Primer_Respondiente = " . $Id_PR_Aux;
                    $this->db->query($sql);
                    $this->db->execute();
                    $Id_PR_Final = $Id_PR_Aux;
                    //SEGUNDO RESPONDIENTE
                    $sql = "UPDATE  iph_primer_respondiente   
                            SET  
                                Nombre_PR       = '" . $Nombre_SR . "', 
                                Ap_Paterno_PR   = '" . $Ap_Paterno_SR . "',  
                                Ap_Materno_PR   = '" . $Ap_Materno_SR . "',  
                                Institucion     = '" . $Institucion_SR . "', 
                                Cargo           = '" . $Cargo_SR . "', 
                                No_Control      = '" . $No_Control_SR . "'                                 
                            WHERE Id_Primer_Respondiente = " . $Id_SR_Aux;
                    $this->db->query($sql);
                    $this->db->execute();
                    $Id_SR_Final = $Id_SR_Aux;
                }
            } else { //se trata del mismo de la puesta
                // si son diferentes quiere decir que apenas se lo asignaron como el mismo
                if ($Id_PR_Puesta != $Id_PR_Aux) { //se borra primero el existente y luego se asigna el pr de la puesta
                    //como auxiliar se cambia al de la puesta
                    $sql = "UPDATE iph_detenido SET Id_Primer_Respondiente = $Id_PR_Puesta WHERE Id_Detenido = " . $post['Id_Detenido'];
                    $this->db->query($sql);
                    $this->db->execute();
                    //auxiliar Segudno respondiente
                    $sql = "UPDATE iph_detenido SET Id_Segundo_Respondiente = 1 WHERE Id_Detenido = " . $post['Id_Detenido'];
                    $this->db->query($sql);
                    $this->db->execute();
                    //ahora se borra para evitar conflicto en constraint
                    $sql = "DELETE FROM iph_primer_respondiente WHERE Id_Primer_Respondiente = $Id_PR_Aux";
                    $this->db->query($sql);
                    $this->db->execute();
                    //ahora se borra segundo respondiente para evitar trash
                    $sql = "DELETE FROM iph_primer_respondiente WHERE Id_Primer_Respondiente = $Id_SR_Aux";
                    $this->db->query($sql);
                    $this->db->execute();
                }
                $Id_PR_Final = $Id_PR_Puesta;
                $Id_SR_Final = 1;
            }
            //DETENIDO INFO GENERAL
            $Num_Detencion      = (isset($post['Num_Detencion'])) ?  $post['Num_Detencion'] : '';
            $Fecha              = (isset($post['Fecha'])) ?          $post['Fecha'] : '';
            $Hora               = (isset($post['Hora'])) ?           $post['Hora'] : '';
            $Nombre_D           = (isset($post['Nombre_D'])) ?       $post['Nombre_D'] : '';
            $Ap_Paterno_D       = (isset($post['Ap_Paterno_D'])) ?   $post['Ap_Paterno_D'] : '';
            $Ap_Materno_D       = (isset($post['Ap_Materno_D'])) ?   $post['Ap_Materno_D'] : '';
            $Apodo              = (isset($post['Apodo'])) ?          $post['Apodo'] : '';
            $Nacionalidad       = ($post['Nacionalidad_Radio'] != 'MEXICANA') ? $post['Nacionalidad_Otro'] : 'MEXICANA';
            $Genero             = (isset($post['Genero'])) ?          $post['Genero'] : '';
            $Fecha_Nacimiento   = (isset($post['Fecha_Nacimiento'])) ? $post['Fecha_Nacimiento'] : '';
            $Edad               = (isset($post['Edad'])) ? $post['Edad'] : '';
            $Identificacion     = ($post['Identificacion'] == 'Otro') ? $post['Identificacion_Otro'] : $post['Identificacion'];
            $Num_Identificacion = (isset($post['Num_Identificacion'])) ? $post['Num_Identificacion'] : '';

            $Descripcion_Detenido  = (isset($post['Descripcion_Detenido'])) ? $post['Descripcion_Detenido'] : '';
            $Lesiones           = ($post['Lesiones'] == 'No') ? '0' : '1';
            $Descripcion_Padecimiento   = ($post['Padecimiento_Radio'] != 'No') ? $post['Descripcion_Padecimiento'] : '';
            $Grupo_Vulnerable   = ($post['Grupo_V_Radio'] != 'No') ? $post['Grupo_Vulnerable'] : '';
            $Grupo_Delictivo    = ($post['Grupo_D_Radio'] != 'No') ? $post['Grupo_Delictivo'] : '';
            $Lectura_Derechos   = ($post['Lectura_Derechos'] == 'No') ? '0' : '1';
            $Objeto_Encontrado          = ($post['Objeto_Encontrado'] == 'No') ? '0' : '1';
            $Pertenencias_Encontradas   = ($post['Pertenencias_Encontradas'] == 'No') ? '0' : '1';

            $Lugar_Traslado             = (isset($post['Lugar_Traslado'])) ? $post['Lugar_Traslado'] : '';
            $Descripcion_Traslado       = (isset($post['Descripcion_Traslado'])) ? $post['Descripcion_Traslado'] : '';
            $Observaciones_Detencion    = (isset($post['Observaciones_Detencion'])) ? $post['Observaciones_Detencion'] : '';

            $sql = "UPDATE  iph_detenido 
                    SET
                        Num_Detencion               = '" . $Num_Detencion . "', 
                        Fecha_Hora                  = '" . $Fecha . " " . $Hora . "', 
                        Nombre_D                    = '" . $Nombre_D . "', 
                        Ap_Paterno_D                = '" . $Ap_Paterno_D . "', 
                        Ap_Materno_D                = '" . $Ap_Materno_D . "', 
                        Apodo                       = '" . $Apodo . "', 
                        Nacionalidad                = '" . $Nacionalidad . "', 
                        Genero                      = '" . $Genero . "', 
                        Fecha_Nacimiento            = '" . $Fecha_Nacimiento . "', 
                        Edad                        = '" . $Edad . "', 
                        Identificacion              = '" . $Identificacion . "', 
                        Num_Identificacion          = '" . $Num_Identificacion . "', 
                        Descripcion_Detenido        = '" . $Descripcion_Detenido . "', 
                        Lesiones                    = b'" . $Lesiones . "', 
                        Descripcion_Padecimiento    = '" . $Descripcion_Padecimiento . "', 
                        Grupo_Vulnerable            = '" . $Grupo_Vulnerable . "', 
                        Grupo_Delictivo             = '" . $Grupo_Delictivo . "', 
                        Lectura_Derechos            = b'" . $Lectura_Derechos . "', 
                        Objeto_Encontrado           = b'" . $Objeto_Encontrado . "', 
                        Pertenencias_Encontradas    = b'" . $Pertenencias_Encontradas . "', 
                        Lugar_Traslado              = '" . $Lugar_Traslado . "', 
                        Descripcion_Traslado        = '" . $Descripcion_Traslado . "', 
                        Observaciones_Detencion     = '" . $Observaciones_Detencion . "',
                                                     
                        Id_Domicilio                = '" . $Id_Domicilio_Aux . "', 
                        Id_Ubicacion_Detencion      = '" . $Id_UbicacionFinal . "', 
                        Id_Primer_Respondiente      = '" . $Id_PR_Final . "', 
                        Id_Segundo_Respondiente     = '" . $Id_SR_Final . "' 
                    WHERE Id_Detenido = " . $post['Id_Detenido'];

            $this->db->query($sql);
            $this->db->execute();

            //FAMILIAR DETENIDO
            //se trata de borrar cualquier existente
            $sql = "DELETE FROM iph_familiar_detenido WHERE Id_Detenido_IPH = " . $post['Id_Detenido'];
            $this->db->query($sql);
            $this->db->execute();
            if ($post['Familiar_Radio'] != 'No') {
                $Nombre_F      = (isset($post['Nombre_F'])) ? $post['Nombre_F'] : '';
                $Ap_Paterno_F  = (isset($post['Ap_Paterno_F'])) ? $post['Ap_Paterno_F'] : '';
                $Ap_Materno_F  = (isset($post['Ap_Materno_F'])) ? $post['Ap_Materno_F'] : '';
                $Telefono_F = (isset($post['Telefono_F'])) ? $post['Telefono_F'] : '';

                //inserta uno nuevo
                $sql = "INSERT    INTO iph_familiar_detenido( 
                                                    Id_Detenido_IPH,
                                                    Nombre_F, 
                                                    Ap_Paterno_F, 
                                                    Ap_Materno_F, 
                                                    Telefono_F
                                                ) 
                                    VALUES(
                                        " . $post['Id_Detenido'] . ",
                                        '" . $Nombre_F . "', 
                                        '" . $Ap_Paterno_F . "', 
                                        '" . $Ap_Materno_F . "', 
                                        '" . $Telefono_F . "'
                                    )";
                $this->db->query($sql);
                $this->db->execute();
            }

            //PERTENENCIAS DEL DETENIDO
            //se trata de borrar cualquier existente
            $sql = "DELETE FROM iph_pertenencia_detenido WHERE Id_Detenido_IPH = " . $post['Id_Detenido'];
            $this->db->query($sql);
            $this->db->execute();
            if ($post['Pertenencias_Encontradas'] != 'No') {

                $pertenenciasArray = json_decode($post['Pertenencias_Detenido']);
                foreach ($pertenenciasArray as $pertenencia) {
                    //se inserta persona
                    $sql = "INSERT
                                INTO iph_pertenencia_detenido(
                                    Id_Detenido_IPH,
                                    Pertenencia,
                                    Descripcion,
                                    Destino
                                )
                                VALUES(
                                    " . $post['Id_Detenido'] . ",
                                    '" . $this->mi_trim($pertenencia->Pertenencia) . "',
                                    '" . $this->mi_trim($pertenencia->Descripcion) . "',
                                    '" . $this->mi_trim($pertenencia->Destino) . "'
                                )
                        ";
                    $this->db->query($sql);
                    $this->db->execute();
                }
            }

            $return['success'] = true;
            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries

        } catch (Exception $err) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            $return['success'] = false;
            $return['error_message'] = $err;
        }

        return $return;
    }
    public function getInfoAnexoA($id_puesta, $id_detenido)
    {
        try {
            $this->db->beginTransaction(); //inicio de transaction

            $return['success'] = false;
            $return['error_message'] = '';

            //get detenido info
            $sql = "SELECT * FROM iph_detenido WHERE Id_Detenido = $id_detenido";
            $this->db->query($sql);
            $data['Detenido'] = $this->db->register();
            //get familiar
            $sql = "SELECT * FROM iph_familiar_detenido WHERE Id_Detenido_IPH = $id_detenido";
            $this->db->query($sql);
            $data['Familiar'] = $this->db->register();
            //get primer respondiente
            $sql = "SELECT * FROM iph_primer_respondiente WHERE Id_Primer_Respondiente = " . $data['Detenido']->Id_Primer_Respondiente;
            $this->db->query($sql);
            $data['Primer_Resp'] = $this->db->register();
            //get segundo respondiente
            $sql = "SELECT * FROM iph_primer_respondiente WHERE Id_Primer_Respondiente = " . $data['Detenido']->Id_Segundo_Respondiente;
            $this->db->query($sql);
            $data['Segundo_Resp'] = $this->db->register();
            //get pertenencias
            $sql = "SELECT * FROM iph_pertenencia_detenido WHERE Id_Detenido_IPH = " . $id_detenido;
            $this->db->query($sql);
            $data['Pertenencias'] = $this->db->registers();
            //get domicilio
            $sql = "SELECT * FROM domicilio WHERE Id_Domicilio = " . $data['Detenido']->Id_Domicilio;
            $this->db->query($sql);
            $data['Domicilio'] = $this->db->register();
            //get ubicación de la detención
            $sql = "SELECT * FROM ubicacion WHERE Id_Ubicacion = " . $data['Detenido']->Id_Ubicacion_Detencion;
            $this->db->query($sql);
            $data['Ubi_Detencion'] = $this->db->register();
            //get puesta
            $sql = "
                    SELECT iph_puesta_disposicion.Estatus, iph_puesta_disposicion.Id_Primer_Respondiente,iph_lugar_intervencion.Id_Ubicacion AS Id_Ubicacion
                    FROM iph_detenido 
                    LEFT JOIN iph_puesta_disposicion ON iph_puesta_disposicion.Id_Puesta = iph_detenido.Id_Puesta
                    LEFT JOIN iph_lugar_intervencion ON iph_lugar_intervencion.Id_Puesta = iph_puesta_disposicion.Id_Puesta
                    WHERE iph_detenido.Id_Puesta = " . $id_puesta . " AND iph_detenido.Id_Detenido = " . $id_detenido;
            $this->db->query($sql);
            $data['Puesta'] = $this->db->register();
            if (!$data['Puesta']) throw new Exception('Error en la URL el Id de la Puesta y el Detenido no tienen relación');

            $return['success'] = true;
            $return['apartados'] = $data;

            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries

        } catch (Exception $err) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            $return['success'] = false;
            $return['error_message'] = $err;
        }

        return $return;
    }
    public function getFichaForRemisionByIdPuesta($id_puesta)
    {
        $sql = "SELECT COUNT(*) AS Num_Detenidos FROM iph_detenido WHERE Id_Puesta = $id_puesta";
        $this->db->query($sql);
        $num = $this->db->register()->Num_Detenidos;

        if ($num > 1) { //se recupera el número de ficha si hay mas de 1
            $sql = "SELECT iph_detenido.Id_Detenido FROM iph_detenido WHERE Id_Puesta = $id_puesta LIMIT 1 ";
            $this->db->query($sql);
            $detenido = $this->db->register();

            $sql = "SELECT remision.No_Ficha 
                    FROM remision 
                    LEFT JOIN detenido ON detenido.No_Remision = remision.No_Remision 
                    WHERE detenido.Id_IPH = 'IPH_" . $detenido->Id_Detenido . "'";
            $this->db->query($sql);
            $no_ficha = $this->db->register()->No_Ficha;
        } else {
            $no_ficha = false;
        }
        return $no_ficha;
    }
    public function getAnexosAforPDF($id_puesta)
    {
        try {
            //get all anexos A
            $sql = "
                SELECT 	det.*, 
                        puesta.Id_Primer_Respondiente AS Id_PR_Puesta, 
                        fam.Nombre_F, 
                        fam.Ap_Paterno_F, 
                        fam.Ap_Materno_F, 
                        fam.Telefono_F, 
                        GROUP_CONCAT(  
                                    CONCAT('',pert.Pertenencia,'|',pert.Descripcion,'|',pert.Destino) 
                                    SEPARATOR '|||' 
                        ) AS Pertenencias, 
                        pr.Nombre_PR, 
                        pr.Ap_Paterno_PR, 
                        pr.Ap_Materno_PR, 
                        pr.Institucion AS Institucion_PR, 
                        pr.Cargo AS Cargo_PR, 
                        sr.Nombre_PR        AS Nombre_SR, 
                        sr.Ap_Paterno_PR    AS Ap_Paterno_SR, 
                        sr.Ap_Materno_PR    AS Ap_Materno_SR, 
                        sr.Institucion      AS Institucion_SR, 
                        sr.Cargo            AS Cargo_SR, 
                        dom_det.Colonia 		AS Colonia_Dom, 
                        dom_det.Calle 			AS Calle_Dom, 
                        dom_det.No_Exterior 	AS No_Ext_Dom, 
                        dom_det.No_Interior 	AS No_Int_Dom, 
                        dom_det.CP 				AS CP_Dom, 
                        dom_det.Municipio 		AS Municipio_Dom, 
                        dom_det.Estado 			AS Estado_Dom, 
                        dom_det.Referencias 	AS Referencias_Dom, 
                        ubi_det.Colonia 		AS Colonia_Ubi, 
                        ubi_det.Calle_1 	    AS Calle_1_Ubi, 
                        ubi_det.No_Ext 	        AS No_Ext_Ubi, 
                        ubi_det.No_Int 	        AS No_Int_Ubi, 
                        ubi_det.CP 				AS CP_Ubi, 
                        ubi_det.Municipio 		AS Municipio_Ubi, 
                        ubi_det.Estado 			AS Estado_Ubi, 
                        ubi_det.Referencias 	AS Referencias_Ubi 
                FROM iph_detenido AS det 
                LEFT JOIN iph_puesta_disposicion puesta ON puesta.Id_Puesta = det.Id_Puesta 
                LEFT JOIN iph_familiar_detenido fam ON fam.Id_Detenido_IPH = det.Id_Detenido 
                LEFT JOIN iph_pertenencia_detenido pert ON pert.Id_Detenido_IPH = det.Id_Detenido 
                LEFT JOIN iph_primer_respondiente pr ON pr.Id_Primer_Respondiente = det.Id_Primer_Respondiente 
                LEFT JOIN iph_primer_respondiente sr ON sr.Id_Primer_Respondiente = det.Id_Segundo_Respondiente 
                LEFT JOIN domicilio dom_det ON dom_det.Id_Domicilio = det.Id_Domicilio 
                LEFT JOIN ubicacion ubi_det ON ubi_det.Id_Ubicacion = det.Id_Ubicacion_Detencion 
                WHERE det.Id_Puesta = $id_puesta AND det.Status = 1 
                GROUP BY det.Id_Detenido
                ORDER BY det.Id_Detenido
            ";

            $this->db->query($sql);
            return $this->db->registers();
        } catch (\Throwable $th) {
            return false;
        }
    }
/*-------------------------FIN FUNCIONES ANEXO A------------------------------*/

/*-------------------------FUNCIONES ANEXO B------------------------------*/
    public function getAnexosB($id_puesta)
    {
        try {
            //get all anexos B
            $sql = "
            SELECT 	iph_informe_uso_fuerza.Id_Informe_Uso_Fuerza,
                    iph_informe_uso_fuerza.Id_Puesta,
                    iph_informe_uso_fuerza.Num_Lesionados_Autoridad,
                    iph_informe_uso_fuerza.Num_Lesionados_Persona,
                    iph_informe_uso_fuerza.Num_Fallecidos_Autoridad,
                    iph_informe_uso_fuerza.Num_Fallecidos_Persona
            FROM iph_informe_uso_fuerza
            WHERE iph_informe_uso_fuerza.Id_Puesta = $id_puesta  AND Status = 1";

            $this->db->query($sql);
            return $this->db->registers();
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function insertAnexoB($post = null)
    {
        /** Orden de inserciones:
         * primer y segundo respondiente
         * iph_informe_uso_fuerza
         */
        try {
            $this->db->beginTransaction(); //inicio de transaction

            $return['success'] = false;
            $return['error_message'] = '';

            //ELEMENTOS PARTICIPANTES
            $Id_Primer_Respondiente = -1;
            $Id_Segundo_Respondiente = -1;
            if ($post['Primer_Respondiente_Radio'] == '1') { //se inserta nuevo elemento 
                $Nombre_PR      = (isset($post['Nombre_PR'])) ? $post['Nombre_PR'] : '';
                $Ap_Paterno_PR  = (isset($post['Ap_Paterno_PR'])) ? $post['Ap_Paterno_PR'] : '';
                $Ap_Materno_PR  = (isset($post['Ap_Materno_PR'])) ? $post['Ap_Materno_PR'] : '';
                $Institucion_PR = (isset($post['Institucion_PR'])) ? $post['Institucion_PR'] : '';
                $Cargo_PR       = (isset($post['Cargo_PR'])) ? $post['Cargo_PR'] : '';
                $No_Control_PR  = (isset($post['No_Control_PR'])) ? $post['No_Control_PR'] : '';


                $sql = "INSERT    INTO iph_primer_respondiente( 
                                                    Nombre_PR, 
                                                    Ap_Paterno_PR, 
                                                    Ap_Materno_PR, 
                                                    Institucion, 
                                                    Cargo, 
                                                    No_Control
                                                ) 
                                    VALUES(
                                        '" . $Nombre_PR . "', 
                                        '" . $Ap_Paterno_PR . "', 
                                        '" . $Ap_Materno_PR . "', 
                                        '" . $Institucion_PR . "', 
                                        '" . $Cargo_PR . "', 
                                        '" . $No_Control_PR . "' 
                                    )";
                $this->db->query($sql);
                $this->db->execute();
                $this->db->query("SELECT LAST_INSERT_ID() as Id_Primer_Respondiente"); //se recupera el id del domicilio
                $Id_Primer_Respondiente = $this->db->register()->Id_Primer_Respondiente;

                // SEGUNDO RESPONDIENTE
                $Nombre_SR      = (isset($post['Nombre_SR'])) ? $post['Nombre_SR'] : '';
                $Ap_Paterno_SR  = (isset($post['Ap_Paterno_SR'])) ? $post['Ap_Paterno_SR'] : '';
                $Ap_Materno_SR  = (isset($post['Ap_Materno_SR'])) ? $post['Ap_Materno_SR'] : '';
                $Institucion_SR = (isset($post['Institucion_SR'])) ? $post['Institucion_SR'] : '';
                $Cargo_SR       = (isset($post['Cargo_SR'])) ? $post['Cargo_SR'] : '';
                $No_Control_SR  = (isset($post['No_Control_SR'])) ? $post['No_Control_SR'] : '';


                $sql = "INSERT    INTO iph_primer_respondiente( 
                                                    Nombre_PR, 
                                                    Ap_Paterno_PR, 
                                                    Ap_Materno_PR, 
                                                    Institucion, 
                                                    Cargo, 
                                                    No_Control
                                                ) 
                                    VALUES(
                                        '" . $Nombre_SR . "', 
                                        '" . $Ap_Paterno_SR . "', 
                                        '" . $Ap_Materno_SR . "', 
                                        '" . $Institucion_SR . "', 
                                        '" . $Cargo_SR . "', 
                                        '" . $No_Control_SR . "' 
                                    )";
                $this->db->query($sql);
                $this->db->execute();
                $this->db->query("SELECT LAST_INSERT_ID() as Id_Segundo_Respondiente"); //se recupera el id del domicilio
                $Id_Segundo_Respondiente = $this->db->register()->Id_Segundo_Respondiente;
            } else { //se recupera el id del primer respondiente de la puesta
                $sql = "SELECT Id_Primer_Respondiente FROM iph_puesta_disposicion WHERE Id_Puesta = " . $post['Id_Puesta'];
                $this->db->query($sql);
                $Id_Primer_Respondiente = $this->db->register()->Id_Primer_Respondiente;
                $Id_Segundo_Respondiente = 1; //primer respondiente null
            }
            //IPH INFORME USO DE LA FUERZA

            $Num_Lesionados_Autoridad   = (isset($post['Num_Lesionados_Autoridad'])) ? (int)$post['Num_Lesionados_Autoridad'] : '';
            $Num_Lesionados_Persona     = (isset($post['Num_Lesionados_Persona'])) ? (int)$post['Num_Lesionados_Persona'] : '';
            $Num_Fallecidos_Autoridad   = (isset($post['Num_Fallecidos_Autoridad'])) ? (int)$post['Num_Fallecidos_Autoridad'] : '';
            $Num_Fallecidos_Persona     = (isset($post['Num_Fallecidos_Persona'])) ? (int)$post['Num_Fallecidos_Persona'] : '';

            $Reduccion_Movimiento       = (isset($post['Reduccion_Movimiento'])) ? '1' : '';
            $Armas_Incapacitantes       = (isset($post['Armas_Incapacitantes'])) ? '1' : '';
            $Armas_Fuego                = (isset($post['Armas_Fuego'])) ? '1' : '';

            $Asistencia_Medica       = ($post['Asistencia_Med_Radio'] == '1') ? $post['Asistencia_Medica'] : '';
            $Descripcion_Conducta     = (isset($post['Descripcion_Conducta'])) ? $post['Descripcion_Conducta'] : '';

            $sql = "INSERT    INTO iph_informe_uso_fuerza( 
                                                Num_Lesionados_Autoridad, 
                                                Num_Lesionados_Persona, 
                                                Num_Fallecidos_Autoridad, 
                                                Num_Fallecidos_Persona, 
                                                Reduccion_Movimiento, 
                                                Armas_Incapacitantes, 
                                                Armas_Fuego, 
                                                Descripcion_Conducta, 
                                                Asistencia_Medica, 

                                                Id_Puesta, 
                                                Id_Primer_Respondiente, 
                                                Id_Segundo_Respondiente
                                                
                                            ) 
                                VALUES(
                                    '" . $Num_Lesionados_Autoridad . "', 
                                    '" . $Num_Lesionados_Persona . "', 
                                    '" . $Num_Fallecidos_Autoridad . "', 
                                    '" . $Num_Fallecidos_Persona . "', 
                                    b'" . $Reduccion_Movimiento . "', 
                                    b'" . $Armas_Incapacitantes . "', 
                                    b'" . $Armas_Fuego . "', 
                                    '" . $Descripcion_Conducta . "', 
                                    '" . $Asistencia_Medica . "', 

                                    '" . $post['Id_Puesta'] . "', 
                                    '" . $Id_Primer_Respondiente . "', 
                                    '" . $Id_Segundo_Respondiente . "'
                                )";

            $this->db->query($sql);
            $this->db->execute();

            $return['success'] = true;
            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries

        } catch (Exception $err) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            $return['success'] = false;
            $return['error_message'] = $err;
        }

        return $return;
    }
    public function updateAnexoB($post = null)
    {
        /** Orden de inserciones:
         * primer y segundo respondiente
         * iph_informe_uso_fuerza
         */
        try {
            $this->db->beginTransaction(); //inicio de transaction

            $return['success'] = false;
            $return['error_message'] = '';

            //Se recuperan todos los Id's auxiliares para los updates
            $sql = "SELECT Id_Primer_Respondiente,Id_Segundo_Respondiente 
                    FROM iph_informe_uso_fuerza 
                    WHERE Id_Puesta = " . $post['Id_Puesta'] . " AND Id_Informe_Uso_Fuerza = " . $post['Id_Informe'];
            $this->db->query($sql);
            $infoAux = $this->db->register();
            $Id_PR_Aux = $infoAux->Id_Primer_Respondiente;
            $Id_SR_Aux = $infoAux->Id_Segundo_Respondiente;

            //ELEMENTOS PARTICIPANTES
            //se recupera el pr de la puesta
            $sql = "SELECT Id_Primer_Respondiente FROM iph_puesta_disposicion WHERE Id_Puesta = " . $post['Id_Puesta'];
            $this->db->query($sql);
            $Id_PR_Puesta = $this->db->register()->Id_Primer_Respondiente;
            $Id_PR_Final = -1;
            $Id_SR_Final = -1;
            if ($post['Primer_Respondiente_Radio'] == '1') { //se inserta nuevo elemento 
                $Nombre_PR      = (isset($post['Nombre_PR'])) ? $post['Nombre_PR'] : '';
                $Ap_Paterno_PR  = (isset($post['Ap_Paterno_PR'])) ? $post['Ap_Paterno_PR'] : '';
                $Ap_Materno_PR  = (isset($post['Ap_Materno_PR'])) ? $post['Ap_Materno_PR'] : '';
                $Institucion_PR = (isset($post['Institucion_PR'])) ? $post['Institucion_PR'] : '';
                $Cargo_PR       = (isset($post['Cargo_PR'])) ? $post['Cargo_PR'] : '';
                $No_Control_PR  = (isset($post['No_Control_PR'])) ? $post['No_Control_PR'] : '';
                // SEGUNDO RESPONDIENTE
                $Nombre_SR      = (isset($post['Nombre_SR'])) ? $post['Nombre_SR'] : '';
                $Ap_Paterno_SR  = (isset($post['Ap_Paterno_SR'])) ? $post['Ap_Paterno_SR'] : '';
                $Ap_Materno_SR  = (isset($post['Ap_Materno_SR'])) ? $post['Ap_Materno_SR'] : '';
                $Institucion_SR = (isset($post['Institucion_SR'])) ? $post['Institucion_SR'] : '';
                $Cargo_SR       = (isset($post['Cargo_SR'])) ? $post['Cargo_SR'] : '';
                $No_Control_SR  = (isset($post['No_Control_SR'])) ? $post['No_Control_SR'] : '';
                //se comprueba si anteriormente ya existia para actualizar o crear
                if ($Id_PR_Puesta == $Id_PR_Aux) { //se crea porque quiere decir que anteriormente tenía el id del pr de la puesta
                    $sql = "INSERT    INTO iph_primer_respondiente( 
                                            Nombre_PR, 
                                            Ap_Paterno_PR, 
                                            Ap_Materno_PR, 
                                            Institucion, 
                                            Cargo, 
                                            No_Control
                                        ) 
                            VALUES(
                                '" . $Nombre_PR . "', 
                                '" . $Ap_Paterno_PR . "', 
                                '" . $Ap_Materno_PR . "', 
                                '" . $Institucion_PR . "', 
                                '" . $Cargo_PR . "', 
                                '" . $No_Control_PR . "' 
                            )";
                    $this->db->query($sql);
                    $this->db->execute();
                    $this->db->query("SELECT LAST_INSERT_ID() as Id_Primer_Respondiente"); //se recupera el id del domicilio
                    $Id_PR_Final = $this->db->register()->Id_Primer_Respondiente;
                    // SEGUNDO RESPONDIENTE
                    $sql = "INSERT    INTO iph_primer_respondiente( 
                                            Nombre_PR, 
                                            Ap_Paterno_PR, 
                                            Ap_Materno_PR, 
                                            Institucion, 
                                            Cargo, 
                                            No_Control
                                        ) 
                            VALUES(
                                '" . $Nombre_SR . "', 
                                '" . $Ap_Paterno_SR . "', 
                                '" . $Ap_Materno_SR . "', 
                                '" . $Institucion_SR . "', 
                                '" . $Cargo_SR . "', 
                                '" . $No_Control_SR . "' 
                            )";
                    $this->db->query($sql);
                    $this->db->execute();
                    $this->db->query("SELECT LAST_INSERT_ID() as Id_Segundo_Respondiente"); //se recupera el id del domicilio
                    $Id_SR_Final = $this->db->register()->Id_Segundo_Respondiente;
                } else { //se actualiza porque ya existe el id del pr
                    $sql = "UPDATE  iph_primer_respondiente   
                            SET  
                                Nombre_PR       = '" . $Nombre_PR . "', 
                                Ap_Paterno_PR   = '" . $Ap_Paterno_PR . "',  
                                Ap_Materno_PR   = '" . $Ap_Materno_PR . "',  
                                Institucion     = '" . $Institucion_PR . "', 
                                Cargo           = '" . $Cargo_PR . "', 
                                No_Control      = '" . $No_Control_PR . "'                                 
                            WHERE Id_Primer_Respondiente = " . $Id_PR_Aux;
                    $this->db->query($sql);
                    $this->db->execute();
                    $Id_PR_Final = $Id_PR_Aux;
                    //SEGUNDO RESPONDIENTE
                    $sql = "UPDATE  iph_primer_respondiente   
                            SET  
                                Nombre_PR       = '" . $Nombre_SR . "', 
                                Ap_Paterno_PR   = '" . $Ap_Paterno_SR . "',  
                                Ap_Materno_PR   = '" . $Ap_Materno_SR . "',  
                                Institucion     = '" . $Institucion_SR . "', 
                                Cargo           = '" . $Cargo_SR . "', 
                                No_Control      = '" . $No_Control_SR . "'                                 
                            WHERE Id_Primer_Respondiente = " . $Id_SR_Aux;
                    $this->db->query($sql);
                    $this->db->execute();
                    $Id_SR_Final = $Id_SR_Aux;
                }
            } else { //se trata del mismo de la puesta
                // si son diferentes quiere decir que apenas se lo asignaron como el mismo
                if ($Id_PR_Puesta != $Id_PR_Aux) { //se borra primero el existente y luego se asigna el pr de la puesta
                    //como auxiliar se cambia al de la puesta
                    $sql = "UPDATE iph_informe_uso_fuerza SET Id_Primer_Respondiente = $Id_PR_Puesta WHERE Id_Informe_Uso_Fuerza = " . $post['Id_Informe'];
                    $this->db->query($sql);
                    $this->db->execute();
                    //auxiliar Segudno respondiente
                    $sql = "UPDATE iph_informe_uso_fuerza SET Id_Segundo_Respondiente = 1 WHERE Id_Informe_Uso_Fuerza = " . $post['Id_Informe'];
                    $this->db->query($sql);
                    $this->db->execute();
                    //ahora se borra para evitar conflicto en constraint
                    $sql = "DELETE FROM iph_primer_respondiente WHERE Id_Primer_Respondiente = $Id_PR_Aux";
                    $this->db->query($sql);
                    $this->db->execute();
                    //ahora se borra segundo respondiente para evitar trash
                    $sql = "DELETE FROM iph_primer_respondiente WHERE Id_Primer_Respondiente = $Id_SR_Aux";
                    $this->db->query($sql);
                    $this->db->execute();
                }
                $Id_PR_Final = $Id_PR_Puesta;
                $Id_SR_Final = 1;
            }

            //IPH INFORME USO DE LA FUERZA
            $Num_Lesionados_Autoridad   = (isset($post['Num_Lesionados_Autoridad'])) ? (int)$post['Num_Lesionados_Autoridad'] : '';
            $Num_Lesionados_Persona     = (isset($post['Num_Lesionados_Persona'])) ? (int)$post['Num_Lesionados_Persona'] : '';
            $Num_Fallecidos_Autoridad   = (isset($post['Num_Fallecidos_Autoridad'])) ? (int)$post['Num_Fallecidos_Autoridad'] : '';
            $Num_Fallecidos_Persona     = (isset($post['Num_Fallecidos_Persona'])) ? (int)$post['Num_Fallecidos_Persona'] : '';

            $Reduccion_Movimiento       = (isset($post['Reduccion_Movimiento'])) ? '1' : '';
            $Armas_Incapacitantes       = (isset($post['Armas_Incapacitantes'])) ? '1' : '';
            $Armas_Fuego                = (isset($post['Armas_Fuego'])) ? '1' : '';

            $Asistencia_Medica       = ($post['Asistencia_Med_Radio'] == '1') ? $post['Asistencia_Medica'] : '';
            $Descripcion_Conducta     = (isset($post['Descripcion_Conducta'])) ? $post['Descripcion_Conducta'] : '';

            $sql = "UPDATE iph_informe_uso_fuerza SET 
                            Num_Lesionados_Autoridad    = '" . $Num_Lesionados_Autoridad . "', 
                            Num_Lesionados_Persona      = '" . $Num_Lesionados_Persona . "', 
                            Num_Fallecidos_Autoridad    = '" . $Num_Fallecidos_Autoridad . "', 
                            Num_Fallecidos_Persona      = '" . $Num_Fallecidos_Persona . "', 
                            Reduccion_Movimiento        = b'" . $Reduccion_Movimiento . "', 
                            Armas_Incapacitantes        = b'" . $Armas_Incapacitantes . "', 
                            Armas_Fuego                 = b'" . $Armas_Fuego . "', 
                            Descripcion_Conducta        = '" . $Descripcion_Conducta . "', 
                            Asistencia_Medica           = '" . $Asistencia_Medica . "', 

                            Id_Primer_Respondiente      = '" . $Id_PR_Final . "', 
                            Id_Segundo_Respondiente     = '" . $Id_SR_Final . "'
                            
                            WHERE Id_Informe_Uso_Fuerza = " . $post['Id_Informe'];

            $this->db->query($sql);
            $this->db->execute();

            $return['success'] = true;
            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries

        } catch (Exception $err) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            $return['success'] = false;
            $return['error_message'] = $err;
        }

        return $return;
    }
    public function getInfoAnexoB($id_puesta, $id_informe)
    {
        try {
            $this->db->beginTransaction(); //inicio de transaction

            $return['success'] = false;
            $return['error_message'] = '';

            //iph informe uso fuerza
            $sql = "SELECT * FROM iph_informe_uso_fuerza WHERE Id_Puesta = $id_puesta AND Id_Informe_Uso_Fuerza = $id_informe";
            $this->db->query($sql);
            $data['Informe'] = $this->db->register();
            if (!$data['Informe']) throw new Exception('Error en la URL el Id de la Puesta y/o el Id del Informe');
            //primer respondiente
            $sql = "SELECT * FROM iph_primer_respondiente WHERE Id_Primer_Respondiente = " . $data['Informe']->Id_Primer_Respondiente;
            $this->db->query($sql);
            $data['Primer_Resp'] = $this->db->register();
            //get segundo respondiente
            $sql = "SELECT * FROM iph_primer_respondiente WHERE Id_Primer_Respondiente = " . $data['Informe']->Id_Segundo_Respondiente;
            $this->db->query($sql);
            $data['Segundo_Resp'] = $this->db->register();
            //get puesta
            $sql = "SELECT iph_puesta_disposicion.Estatus,iph_puesta_disposicion.Id_Primer_Respondiente FROM iph_puesta_disposicion WHERE iph_puesta_disposicion.Id_Puesta = " . $id_puesta;
            $this->db->query($sql);
            $data['Puesta'] = $this->db->register();

            $return['success'] = true;
            $return['apartados'] = $data;

            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries

        } catch (Exception $err) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            $return['success'] = false;
            $return['error_message'] = $err;
        }

        return $return;
    }
    public function getAnexosBforPDF($id_puesta)
    {
        try {
            //get all anexos B
            $sql = "
            SELECT 	informe.*, 
		            pr.Nombre_PR,
                    pr.Ap_Paterno_PR,
                    pr.Ap_Materno_PR,
                    pr.Institucion AS Institucion_PR,
                    pr.Cargo AS Cargo_PR,
                    sr.Nombre_PR        AS Nombre_SR,
                    sr.Ap_Paterno_PR    AS Ap_Paterno_SR,
                    sr.Ap_Materno_PR    AS Ap_Materno_SR,
                    sr.Institucion      AS Institucion_SR,
                    sr.Cargo            AS Cargo_SR
            FROM iph_informe_uso_fuerza AS informe
            LEFT JOIN iph_puesta_disposicion puesta ON puesta.Id_Puesta = informe.Id_Puesta
            LEFT JOIN iph_primer_respondiente pr ON pr.Id_Primer_Respondiente = informe.Id_Primer_Respondiente
            LEFT JOIN iph_primer_respondiente sr ON sr.Id_Primer_Respondiente = informe.Id_Segundo_Respondiente
            WHERE informe.Id_Puesta = $id_puesta AND informe.Status = 1 
            ORDER BY informe.Id_Informe_Uso_Fuerza
            ";

            $this->db->query($sql);
            return $this->db->registers();
        } catch (\Throwable $th) {
            return false;
        }
    }
/*-------------------------FIN FUNCIONES ANEXO B------------------------------*/

    public function getAnexosC($Id_Puesta)
    {
        $sql =  "SELECT Id_Puesta,Id_Inspeccion_Vehiculo,Marca,Placa, Fecha_Hora FROM iph_inspeccion_vehiculo WHERE Id_Puesta = " . $Id_Puesta." AND Status = 1";
        $this->db->query($sql);
        return $this->db->registers();
    }

    public function getAnexosD($Id_Puesta)
    {   // Armas
        $sql =  " SELECT Id_Inventario_Arma,Id_Puesta,Inspeccion,Tipo_Arma,Calibre FROM iph_inventario_arma WHERE Id_Puesta = $Id_Puesta  AND Status = 1";
        $this->db->query($sql);
        $aux = $this->db->registers();
        $resp['Armas'] = ($aux) ? $aux : [];
        // Objetos
        $sql =  " SELECT Id_Inventario_Objetos,Id_Puesta,Apariencia,Inspeccion FROM iph_inventario_objeto WHERE Id_Puesta = $Id_Puesta  AND Status = 1";
        $this->db->query($sql);
        $aux = $this->db->registers();
        $resp['Objetos'] = ($aux) ? $aux : [];
        return $resp;
    }

    public function getAnexosDforPDF($id_puesta)
    {
        try {
            //get all anexos B
            $sql = "SELECT 	arma.*,
                            pr.Nombre_PR,
                            pr.Ap_Paterno_PR,
                            pr.Ap_Materno_PR, 
                            pr.Institucion,
                            pr.Cargo,
                            GROUP_CONCAT( CONCAT(T0.Nombre_TA , ',', T0.Ap_Paterno_TA, ',', T0.Ap_Materno_TA) SEPARATOR '|||' ) AS Testigos	
                    FROM iph_inventario_arma AS arma
                    LEFT JOIN iph_testigo_arma T0 ON T0.Id_Inventario = arma.Id_Inventario_Arma
                    LEFT JOIN iph_primer_respondiente pr ON pr.Id_Primer_Respondiente =  arma.Id_Primer_Respondiente
                    WHERE arma.Id_Puesta = " . $id_puesta . " AND arma.Status = 1 GROUP BY arma.Id_Inventario_Arma";
            $this->db->query($sql);
            $aux['armas'] = $this->db->registers();

            $sql = "SELECT 	objeto.*,
                            pr.Nombre_PR,
                            pr.Ap_Paterno_PR,
                            pr.Ap_Materno_PR, 
                            pr.Institucion,
                            pr.Cargo,
			                GROUP_CONCAT( CONCAT(T0.Nombre_TO , ',', T0.Ap_Paterno_TO, ',', T0.Ap_Materno_TO) SEPARATOR '|||' ) AS Testigos	
                    FROM iph_inventario_objeto AS objeto
                    LEFT JOIN iph_testigo_objeto T0 ON T0.Id_Inventario = objeto.Id_Inventario_Objetos
                    LEFT JOIN iph_primer_respondiente pr ON pr.Id_Primer_Respondiente =  objeto.Id_Primer_Respondiente
                    WHERE objeto.Id_Puesta = " . $id_puesta ." AND objeto.Status = 1 GROUP BY objeto.Id_Inventario_Objetos";
            $this->db->query($sql);
            $aux['objetos'] = $this->db->registers();

            return $aux ;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getAnexosCforPDF($id_puesta)
    {
        try {
            //get all anexos B
            $sql = "
            SELECT 	vehiculo.Id_Inspeccion_Vehiculo,
                    vehiculo.Id_Puesta,
                    vehiculo.Fecha_Hora,
                    vehiculo.Tipo,
                    vehiculo.Procedencia,
                    vehiculo.Marca,
                    vehiculo.Submarca,
                    vehiculo.Modelo,
                    vehiculo.Color,
                    vehiculo.Uso,
                    vehiculo.Placa,
                    vehiculo.Num_Serie,
                    vehiculo.Situacion,
                    vehiculo.Observaciones,
                    vehiculo.Destino,
                    vehiculo.Objetos_Encontrados,
                    pr.Nombre_PR AS Nombre_PR,
                    pr.Ap_Paterno_PR AS Ap_Paterno_PR,
                    pr.Ap_Materno_PR AS Ap_Materno_PR, 
                    pr.Institucion AS Institucion_PR,
                    pr.Cargo AS Cargo_PR,
                    sg.Nombre_PR AS Nombre_SR,
                    sg.Ap_Paterno_PR AS Ap_Paterno_SR,
                    sg.Ap_Materno_PR AS Ap_Materno_SR, 
                    sg.Institucion AS Institucion_SR,
                    sg.Cargo AS Cargo_SR	
                FROM iph_inspeccion_vehiculo AS vehiculo
                INNER JOIN iph_primer_respondiente pr ON pr.Id_Primer_Respondiente = vehiculo.Id_Primer_Respondiente
                INNER JOIN iph_primer_respondiente sg ON sg.Id_Primer_Respondiente =  vehiculo.Id_Segundo_Respondiente  
                WHERE vehiculo.Id_Puesta = " . $id_puesta . " AND vehiculo.Status = 1  ORDER BY vehiculo.Id_Inspeccion_Vehiculo ASC";

            $this->db->query($sql);
            return $this->db->registers();
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getAnexosFforPDF($id_puesta)
    {
        try {
            //get all anexos B
            $sql = "SELECT 	entregaLugar.*,
                            GROUP_CONCAT(CONCAT(TI.Nombre_PLI, ',' , TI.Ap_Paterno_PLI, ',' , TI.Ap_Materno_PLI, ',' , TI.Cargo, ',' , TI.Institucion) SEPARATOR '|||') AS personalIntervencion
                    FROM planeacion.iph_entrega_recepcion_lugar entregaLugar 
                    LEFT JOIN iph_persona_lugar_intervencion TI ON TI.Id_Entrega_Lugar =  entregaLugar.Id_Entrega_Recepcion_Lugar
                    WHERE entregaLugar.Id_Puesta = " . $id_puesta . " AND entregaLugar.Status = 1 ";
            $this->db->query($sql);
            $aux['lugar'] = $this->db->register();

            

            $sql = "SELECT 	entrega.Nombre_PER, 
                            entrega.Ap_Paterno_PER,
                            entrega.Ap_Materno_PER,
                            entrega.Cargo,
                            entrega.Institucion
                FROM iph_persona_entrega_recibe entrega 
                WHERE entrega.Id_Entrega_Lugar = ".  $aux['lugar']->Id_Entrega_Recepcion_Lugar ." AND entrega.Entrega_Recibe = 0 " ;
            $this->db->query($sql);
            $aux['persona_Entrega'] =  $this->db->register();

            $sql = "SELECT 	recibe.Nombre_PER, 
                            recibe.Ap_Paterno_PER,
                            recibe.Ap_Materno_PER,
                            recibe.Cargo,
                            recibe.Institucion
                FROM iph_persona_entrega_recibe recibe 
                WHERE recibe.Id_Entrega_Lugar = ".  $aux['lugar']->Id_Entrega_Recepcion_Lugar ." AND recibe.Entrega_Recibe = 1 " ;
            $this->db->query($sql);
            $aux['persona_Recibe'] =  $this->db->register();
            

            return $aux ;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getAnexosF($Id_Puesta)
    {
        $sql =  "SELECT Id_Entrega_Recepcion_Lugar,Id_Puesta,Motivo_Ingreso,Fecha_Hora_Recepcion FROM iph_entrega_recepcion_lugar WHERE Id_Puesta = " . $Id_Puesta." AND Status = 1";
        $this->db->query($sql);
        return $this->db->registers();
    }

/*-------------------------FUNCIONES ANEXO E------------------------------*/

    public function getAnexosE($id_puesta)
    {
        try {
            //get all anexos E
            $sql = "
            SELECT 	iph_entrevista.Id_Entrevista,
                    iph_entrevista.Id_Puesta,
			        CONCAT_WS('',iph_entrevista.Nombre_Ent,' ',iph_entrevista.Ap_Paterno_Ent,' ',iph_entrevista.Ap_Materno_Ent) AS Nombre_Entrevistado, 
			        iph_entrevista.Fecha_Hora,
			        iph_entrevista.Calidad
            FROM iph_entrevista
            WHERE iph_entrevista.Id_Puesta = $id_puesta  AND Status = 1";

            $this->db->query($sql);
            return $this->db->registers();
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function insertAnexoE($post = null)
    {
        /** Orden de inserciones:
         * domicilio
         * primer respondiente
         * iph_entrevista
         */
        try {
            $this->db->beginTransaction(); //inicio de transaction

            $return['success'] = false;
            $return['error_message'] = '';

            //DOMICILIO DEL DETENIDO
            $Colonia_Dom_Entrev       = (isset($post['Colonia_Dom_Entrev'])) ? $post['Colonia_Dom_Entrev'] : '';
            $Calle_1_Dom_Entrev       = (isset($post['Calle_1_Dom_Entrev'])) ? $post['Calle_1_Dom_Entrev'] : '';
            $No_Ext_Dom_Entrev        = (isset($post['No_Ext_Dom_Entrev'])) ? $post['No_Ext_Dom_Entrev'] : '';
            $No_Int_Dom_Entrev        = (isset($post['No_Int_Dom_Entrev'])) ? $post['No_Int_Dom_Entrev'] : '';
            $Coordenada_X_Dom_Entrev  = (isset($post['Coordenada_X_Dom_Entrev'])) ? $post['Coordenada_X_Dom_Entrev'] : '';
            $Coordenada_Y_Dom_Entrev  = (isset($post['Coordenada_Y_Dom_Entrev'])) ? $post['Coordenada_Y_Dom_Entrev'] : '';
            $Estado_Dom_Entrev        = (isset($post['Estado_Dom_Entrev'])) ? $post['Estado_Dom_Entrev'] : '';
            $Municipio_Dom_Entrev     = (isset($post['Municipio_Dom_Entrev'])) ? $post['Municipio_Dom_Entrev'] : '';
            $CP_Dom_Entrev            = (isset($post['CP_Dom_Entrev'])) ? $post['CP_Dom_Entrev'] : '';
            $Referencias_Dom_Entrev   = (isset($post['Referencias_Dom_Entrev'])) ? $post['Referencias_Dom_Entrev'] : '';

            $sql = "INSERT    INTO domicilio( 
                                                Colonia, 
                                                Calle, 
                                                No_Exterior, 
                                                No_Interior, 
                                                Coordenada_X, 
                                                Coordenada_Y, 
                                                Estado, 
                                                Municipio, 
                                                CP, 
                                                Referencias 
                                            ) 
                                VALUES(
                                    '" . $Colonia_Dom_Entrev . "', 
                                    '" . $Calle_1_Dom_Entrev . "', 
                                    '" . $No_Ext_Dom_Entrev . "', 
                                    '" . $No_Int_Dom_Entrev . "', 
                                    '" . $Coordenada_X_Dom_Entrev . "', 
                                    '" . $Coordenada_Y_Dom_Entrev . "', 
                                    '" . $Estado_Dom_Entrev . "', 
                                    '" . $Municipio_Dom_Entrev . "', 
                                    '" . $CP_Dom_Entrev . "', 
                                    '" . $Referencias_Dom_Entrev . "' 
                                )";

            $this->db->query($sql);
            $this->db->execute();
            $this->db->query("SELECT LAST_INSERT_ID() as Id_Domicilio"); //se recupera el id del domicilio
            $Id_Domicilio = $this->db->register()->Id_Domicilio;

            //ELEMENTOS PARTICIPANTES
            $Id_Primer_Respondiente = -1;
            if ($post['Primer_Respondiente_Radio'] == '1') { //se inserta nuevo elemento 
                $Nombre_PR      = (isset($post['Nombre_PR'])) ? $post['Nombre_PR'] : '';
                $Ap_Paterno_PR  = (isset($post['Ap_Paterno_PR'])) ? $post['Ap_Paterno_PR'] : '';
                $Ap_Materno_PR  = (isset($post['Ap_Materno_PR'])) ? $post['Ap_Materno_PR'] : '';
                $Institucion_PR = (isset($post['Institucion_PR'])) ? $post['Institucion_PR'] : '';
                $Cargo_PR       = (isset($post['Cargo_PR'])) ? $post['Cargo_PR'] : '';
                $No_Control_PR  = (isset($post['No_Control_PR'])) ? $post['No_Control_PR'] : '';


                $sql = "INSERT    INTO iph_primer_respondiente( 
                                                    Nombre_PR, 
                                                    Ap_Paterno_PR, 
                                                    Ap_Materno_PR, 
                                                    Institucion, 
                                                    Cargo, 
                                                    No_Control
                                                ) 
                                    VALUES(
                                        '" . $Nombre_PR . "', 
                                        '" . $Ap_Paterno_PR . "', 
                                        '" . $Ap_Materno_PR . "', 
                                        '" . $Institucion_PR . "', 
                                        '" . $Cargo_PR . "', 
                                        '" . $No_Control_PR . "' 
                                    )";
                $this->db->query($sql);
                $this->db->execute();
                $this->db->query("SELECT LAST_INSERT_ID() as Id_Primer_Respondiente"); //se recupera el id del domicilio
                $Id_Primer_Respondiente = $this->db->register()->Id_Primer_Respondiente;
            } else { //se recupera el id del primer respondiente de la puesta
                $sql = "SELECT Id_Primer_Respondiente FROM iph_puesta_disposicion WHERE Id_Puesta = " . $post['Id_Puesta'];
                $this->db->query($sql);
                $Id_Primer_Respondiente = $this->db->register()->Id_Primer_Respondiente;
            }

            //IPH ENTREVISTA
            $Reservar_Datos             = ($post['Reservar_Datos'] == '1') ? '1' : '0';
            $Fecha                      = (isset($post['Fecha'])) ? $post['Fecha'] : '';
            $Hora                       = (isset($post['Hora'])) ? $post['Hora'] : '';

            $Nombre_Ent                 = (isset($post['Nombre_Ent'])) ? $post['Nombre_Ent'] : '';
            $Ap_Paterno_Ent             = (isset($post['Ap_Paterno_Ent'])) ? $post['Ap_Paterno_Ent'] : '';
            $Ap_Materno_Ent             = (isset($post['Ap_Materno_Ent'])) ? $post['Ap_Materno_Ent'] : '';
            $Calidad                    = (isset($post['Calidad'])) ? $post['Calidad'] : '';

            $Nacionalidad               = ($post['Nacionalidad'] != 'MEXICANA') ? $post['Nacionalidad_Otro'] : 'MEXICANA';
            $Genero                     = (isset($post['Genero'])) ?          $post['Genero'] : '';
            $Fecha_Nacimiento           = (isset($post['Fecha_Nacimiento'])) ? $post['Fecha_Nacimiento'] : '';
            $Edad                       = (isset($post['Edad'])) ? $post['Edad'] : '';
            $Telefono                   = (isset($post['Telefono'])) ? $post['Telefono'] : '';
            $Correo                     = (isset($post['Correo'])) ? $post['Correo'] : '';
            $Identificacion             = ($post['Identificacion'] == 'Otro') ? $post['Identificacion_Otro'] : $post['Identificacion'];
            $Num_Identificacion         = (isset($post['Num_Identificacion'])) ? $post['Num_Identificacion'] : '';

            $Relato_Entrevista          = (isset($post['Relato_Entrevista'])) ? $post['Relato_Entrevista'] : '';

            $Canalizacion               = ($post['Canalizacion'] == '1') ? '1' : '0';
            $Lugar_Canalizacion         = (isset($post['Lugar_Canalizacion'])) ? $post['Lugar_Canalizacion'] : '';
            $Descripcion_Canalizacion   = (isset($post['Descripcion_Canalizacion'])) ? $post['Descripcion_Canalizacion'] : '';


            $sql = "INSERT  INTO iph_entrevista( 
                                            Reservar_Datos,
                                            Fecha_Hora,
                                            Nombre_Ent,
                                            Ap_Paterno_Ent,
                                            Ap_Materno_Ent,
                                            Calidad,
                                            Nacionalidad,
                                            Genero,
                                            Fecha_Nacimiento,
                                            Edad,
                                            Telefono,
                                            Correo,
                                            Identificacion,
                                            Num_Identificacion,
                                            Relato_Entrevista,
                                            Canalizacion,
                                            Lugar_Canalizacion,
                                            Descripcion_Canalizacion,

                                            Id_Puesta, 
                                            Id_Domicilio,
                                            Id_Primer_Respondiente 
                                            ) 
                            VALUES(
                                b'" . $Reservar_Datos . "', 
                                '" . $Fecha . " " . $Hora . "', 
                                '" . $Nombre_Ent . "', 
                                '" . $Ap_Paterno_Ent . "', 
                                '" . $Ap_Materno_Ent . "', 
                                '" . $Calidad . "', 
                                '" . $Nacionalidad . "', 
                                '" . $Genero . "', 
                                '" . $Fecha_Nacimiento . "', 
                                '" . $Edad . "', 
                                '" . $Telefono . "', 
                                '" . $Correo . "', 
                                '" . $Identificacion . "', 
                                '" . $Num_Identificacion . "', 
                                '" . $Relato_Entrevista . "', 
                                b'" . $Canalizacion . "', 
                                '" . $Lugar_Canalizacion . "', 
                                '" . $Descripcion_Canalizacion . "', 

                                '" . $post['Id_Puesta'] . "', 
                                '" . $Id_Domicilio . "', 
                                '" . $Id_Primer_Respondiente . "'
                            )";

            $this->db->query($sql);
            $this->db->execute();

            $return['success'] = true;
            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries

        } catch (Exception $err) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            $return['success'] = false;
            $return['error_message'] = $err;
        }

        return $return;
    }
    public function updateAnexoE($post = null)
    {
        /** Orden de inserciones:
         * primer y segundo respondiente
         * iph_entrevista
         */
        try {
            $this->db->beginTransaction(); //inicio de transaction

            $return['success'] = false;
            $return['error_message'] = '';

            //Se recuperan todos los Id's auxiliares para los updates
            $sql = "SELECT Id_Domicilio, Id_Primer_Respondiente 
                    FROM iph_entrevista 
                    WHERE Id_Puesta = " . $post['Id_Puesta'] . " AND Id_Entrevista = " . $post['Id_Entrevista'];
            $this->db->query($sql);
            $infoAux = $this->db->register();
            $Id_Domicilio_Aux = $infoAux->Id_Domicilio;
            $Id_PR_Aux = $infoAux->Id_Primer_Respondiente;

            //DOMICILIO DEL DETENIDO
            $Colonia_Dom_Entrev       = (isset($post['Colonia_Dom_Entrev'])) ? $post['Colonia_Dom_Entrev'] : '';
            $Calle_1_Dom_Entrev       = (isset($post['Calle_1_Dom_Entrev'])) ? $post['Calle_1_Dom_Entrev'] : '';
            $No_Ext_Dom_Entrev        = (isset($post['No_Ext_Dom_Entrev'])) ? $post['No_Ext_Dom_Entrev'] : '';
            $No_Int_Dom_Entrev        = (isset($post['No_Int_Dom_Entrev'])) ? $post['No_Int_Dom_Entrev'] : '';
            $Coordenada_X_Dom_Entrev  = (isset($post['Coordenada_X_Dom_Entrev'])) ? $post['Coordenada_X_Dom_Entrev'] : '';
            $Coordenada_Y_Dom_Entrev  = (isset($post['Coordenada_Y_Dom_Entrev'])) ? $post['Coordenada_Y_Dom_Entrev'] : '';
            $Estado_Dom_Entrev        = (isset($post['Estado_Dom_Entrev'])) ? $post['Estado_Dom_Entrev'] : '';
            $Municipio_Dom_Entrev     = (isset($post['Municipio_Dom_Entrev'])) ? $post['Municipio_Dom_Entrev'] : '';
            $CP_Dom_Entrev            = (isset($post['CP_Dom_Entrev'])) ? $post['CP_Dom_Entrev'] : '';
            $Referencias_Dom_Entrev   = (isset($post['Referencias_Dom_Entrev'])) ? $post['Referencias_Dom_Entrev'] : '';

            $sql = "UPDATE  domicilio   
                    SET  
                        Colonia         = '" . $Colonia_Dom_Entrev . "', 
                        Calle           = '" . $Calle_1_Dom_Entrev . "', 
                        No_Exterior     = '" . $No_Ext_Dom_Entrev . "', 
                        No_Interior     = '" . $No_Int_Dom_Entrev . "', 
                        Coordenada_X    = '" . $Coordenada_X_Dom_Entrev . "', 
                        Coordenada_Y    = '" . $Coordenada_Y_Dom_Entrev . "', 
                        Estado          = '" . $Estado_Dom_Entrev . "', 
                        Municipio       = '" . $Municipio_Dom_Entrev . "', 
                        CP              = '" . $CP_Dom_Entrev . "', 
                        Referencias     = '" . $Referencias_Dom_Entrev . "' 
                    WHERE Id_Domicilio = " . $Id_Domicilio_Aux;

            $this->db->query($sql);
            $this->db->execute();

            //ELEMENTOS PARTICIPANTES
            //se recupera el pr de la puesta
            $sql = "SELECT Id_Primer_Respondiente FROM iph_puesta_disposicion WHERE Id_Puesta = " . $post['Id_Puesta'];
            $this->db->query($sql);
            $Id_PR_Puesta = $this->db->register()->Id_Primer_Respondiente;
            $Id_PR_Final = -1;
            if ($post['Primer_Respondiente_Radio'] == '1') { //se inserta nuevo elemento 
                $Nombre_PR      = (isset($post['Nombre_PR'])) ? $post['Nombre_PR'] : '';
                $Ap_Paterno_PR  = (isset($post['Ap_Paterno_PR'])) ? $post['Ap_Paterno_PR'] : '';
                $Ap_Materno_PR  = (isset($post['Ap_Materno_PR'])) ? $post['Ap_Materno_PR'] : '';
                $Institucion_PR = (isset($post['Institucion_PR'])) ? $post['Institucion_PR'] : '';
                $Cargo_PR       = (isset($post['Cargo_PR'])) ? $post['Cargo_PR'] : '';
                $No_Control_PR  = (isset($post['No_Control_PR'])) ? $post['No_Control_PR'] : '';
                //se comprueba si anteriormente ya existia para actualizar o crear
                if ($Id_PR_Puesta == $Id_PR_Aux) { //se crea porque quiere decir que anteriormente tenía el id del pr de la puesta
                    $sql = "INSERT    INTO iph_primer_respondiente( 
                                            Nombre_PR, 
                                            Ap_Paterno_PR, 
                                            Ap_Materno_PR, 
                                            Institucion, 
                                            Cargo, 
                                            No_Control
                                        ) 
                            VALUES(
                                '" . $Nombre_PR . "', 
                                '" . $Ap_Paterno_PR . "', 
                                '" . $Ap_Materno_PR . "', 
                                '" . $Institucion_PR . "', 
                                '" . $Cargo_PR . "', 
                                '" . $No_Control_PR . "' 
                            )";
                    $this->db->query($sql);
                    $this->db->execute();
                    $this->db->query("SELECT LAST_INSERT_ID() as Id_Primer_Respondiente"); //se recupera el id del domicilio
                    $Id_PR_Final = $this->db->register()->Id_Primer_Respondiente;
                } else { //se actualiza porque ya existe el id del pr
                    $sql = "UPDATE  iph_primer_respondiente   
                            SET  
                                Nombre_PR       = '" . $Nombre_PR . "', 
                                Ap_Paterno_PR   = '" . $Ap_Paterno_PR . "',  
                                Ap_Materno_PR   = '" . $Ap_Materno_PR . "',  
                                Institucion     = '" . $Institucion_PR . "', 
                                Cargo           = '" . $Cargo_PR . "', 
                                No_Control      = '" . $No_Control_PR . "'                                 
                            WHERE Id_Primer_Respondiente = " . $Id_PR_Aux;
                    $this->db->query($sql);
                    $this->db->execute();
                    $Id_PR_Final = $Id_PR_Aux;
                }
            } else { //se trata del mismo de la puesta
                // si son diferentes quiere decir que apenas se lo asignaron como el mismo
                if ($Id_PR_Puesta != $Id_PR_Aux) { //se borra primero el existente y luego se asigna el pr de la puesta
                    //como auxiliar se cambia al de la puesta
                    $sql = "UPDATE iph_entrevista SET Id_Primer_Respondiente = $Id_PR_Puesta WHERE Id_Entrevista = " . $post['Id_Entrevista'];
                    $this->db->query($sql);
                    $this->db->execute();
                    //ahora se borra para evitar conflicto en constraint
                    $sql = "DELETE FROM iph_primer_respondiente WHERE Id_Primer_Respondiente = $Id_PR_Aux";
                    $this->db->query($sql);
                    $this->db->execute();
                }
                $Id_PR_Final = $Id_PR_Puesta;
            }

            //IPH ENTREVISTA
            $Reservar_Datos             = ($post['Reservar_Datos'] == '1') ? '1' : '0';
            $Fecha                      = (isset($post['Fecha'])) ? $post['Fecha'] : '';
            $Hora                       = (isset($post['Hora'])) ? $post['Hora'] : '';

            $Nombre_Ent                 = (isset($post['Nombre_Ent'])) ? $post['Nombre_Ent'] : '';
            $Ap_Paterno_Ent             = (isset($post['Ap_Paterno_Ent'])) ? $post['Ap_Paterno_Ent'] : '';
            $Ap_Materno_Ent             = (isset($post['Ap_Materno_Ent'])) ? $post['Ap_Materno_Ent'] : '';
            $Calidad                    = (isset($post['Calidad'])) ? $post['Calidad'] : '';

            $Nacionalidad               = ($post['Nacionalidad'] != 'MEXICANA') ? $post['Nacionalidad_Otro'] : 'MEXICANA';
            $Genero                     = (isset($post['Genero'])) ?          $post['Genero'] : '';
            $Fecha_Nacimiento           = (isset($post['Fecha_Nacimiento'])) ? $post['Fecha_Nacimiento'] : '';
            $Edad                       = (isset($post['Edad'])) ? $post['Edad'] : '';
            $Telefono                   = (isset($post['Telefono'])) ? $post['Telefono'] : '';
            $Correo                     = (isset($post['Correo'])) ? $post['Correo'] : '';
            $Identificacion             = ($post['Identificacion'] == 'Otro') ? $post['Identificacion_Otro'] : $post['Identificacion'];
            $Num_Identificacion         = (isset($post['Num_Identificacion'])) ? $post['Num_Identificacion'] : '';

            $Relato_Entrevista          = (isset($post['Relato_Entrevista'])) ? $post['Relato_Entrevista'] : '';

            $Canalizacion               = ($post['Canalizacion'] == '1') ? '1' : '0';
            $Lugar_Canalizacion         = (isset($post['Lugar_Canalizacion'])) ? $post['Lugar_Canalizacion'] : '';
            $Descripcion_Canalizacion   = (isset($post['Descripcion_Canalizacion'])) ? $post['Descripcion_Canalizacion'] : '';

            $sql = "UPDATE iph_entrevista SET
                                    Reservar_Datos              = b'" . $Reservar_Datos . "', 
                                    Fecha_Hora                  = '" . $Fecha . " " . $Hora . "', 
                                    Nombre_Ent                  = '" . $Nombre_Ent . "', 
                                    Ap_Paterno_Ent              = '" . $Ap_Paterno_Ent . "', 
                                    Ap_Materno_Ent              = '" . $Ap_Materno_Ent . "', 
                                    Calidad                     = '" . $Calidad . "', 
                                    Nacionalidad                = '" . $Nacionalidad . "', 
                                    Genero                      = '" . $Genero . "', 
                                    Fecha_Nacimiento            = '" . $Fecha_Nacimiento . "', 
                                    Edad                        = '" . $Edad . "', 
                                    Telefono                    = '" . $Telefono . "', 
                                    Correo                      = '" . $Correo . "', 
                                    Identificacion              = '" . $Identificacion . "', 
                                    Num_Identificacion          = '" . $Num_Identificacion . "', 
                                    Relato_Entrevista           = '" . $Relato_Entrevista . "', 
                                    Canalizacion                = b'" . $Canalizacion . "', 
                                    Lugar_Canalizacion          = '" . $Lugar_Canalizacion . "', 
                                    Descripcion_Canalizacion    = '" . $Descripcion_Canalizacion . "',
                                    Id_Domicilio                = '" . $Id_Domicilio_Aux . "', 
                                    Id_Primer_Respondiente      = '" . $Id_PR_Final . "'
                    WHERE   Id_Entrevista = " . $post['Id_Entrevista'];


            $this->db->query($sql);
            $this->db->execute();

            $return['success'] = true;
            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries

        } catch (Exception $err) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            $return['success'] = false;
            $return['error_message'] = $err;
        }

        return $return;
    }
    public function getInfoAnexoE($id_puesta, $id_entrevista)
    {
        try {
            $this->db->beginTransaction(); //inicio de transaction

            $return['success'] = false;
            $return['error_message'] = '';

            //iph entrevista
            $sql = "SELECT * FROM iph_entrevista WHERE Id_Puesta = $id_puesta AND Id_Entrevista = $id_entrevista";
            $this->db->query($sql);
            $data['Entrevista'] = $this->db->register();
            if (!$data['Entrevista']) throw new Exception('Error en la URL el Id de la Puesta y/o el Id de la Entrevista');
            //primer respondiente
            $sql = "SELECT * FROM iph_primer_respondiente WHERE Id_Primer_Respondiente = " . $data['Entrevista']->Id_Primer_Respondiente;
            $this->db->query($sql);
            $data['Primer_Resp'] = $this->db->register();
            //get domicilio
            $sql = "SELECT * FROM domicilio WHERE Id_Domicilio = " . $data['Entrevista']->Id_Domicilio;
            $this->db->query($sql);
            $data['Domicilio'] = $this->db->register();
            //get puesta
            $sql = "SELECT iph_puesta_disposicion.Estatus,iph_puesta_disposicion.Id_Primer_Respondiente FROM iph_puesta_disposicion WHERE iph_puesta_disposicion.Id_Puesta = " . $id_puesta;
            $this->db->query($sql);
            $data['Puesta'] = $this->db->register();

            $return['success'] = true;
            $return['apartados'] = $data;

            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries

        } catch (Exception $err) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            $return['success'] = false;
            $return['error_message'] = $err;
        }

        return $return;
    }
    public function getAnexosEforPDF($id_puesta)
    {
        try {
            //get all anexos E
            $sql = "
            SELECT 	entrevista.*, 
                    puesta.Id_Primer_Respondiente AS Id_PR_Puesta, 
                    pr.Nombre_PR, 
                    pr.Ap_Paterno_PR, 
                    pr.Ap_Materno_PR, 
                    pr.Institucion AS Institucion_PR, 
                    pr.Cargo AS Cargo_PR, 
                    dom_entrev.Colonia 		AS Colonia_Dom, 
                    dom_entrev.Calle 		AS Calle_Dom, 
                    dom_entrev.No_Exterior 	AS No_Ext_Dom, 
                    dom_entrev.No_Interior 	AS No_Int_Dom, 
                    dom_entrev.CP 			AS CP_Dom, 
                    dom_entrev.Municipio 	AS Municipio_Dom, 
                    dom_entrev.Estado 		AS Estado_Dom, 
                    dom_entrev.Referencias 	AS Referencias_Dom 
            FROM iph_entrevista entrevista 
            LEFT JOIN iph_puesta_disposicion puesta ON puesta.Id_Puesta = entrevista.Id_Puesta 
            LEFT JOIN iph_primer_respondiente pr ON pr.Id_Primer_Respondiente = entrevista.Id_Primer_Respondiente 
            LEFT JOIN domicilio dom_entrev ON dom_entrev.Id_Domicilio = entrevista.Id_Domicilio 
            WHERE entrevista.Id_Puesta = $id_puesta  AND entrevista.Status = 1
            ORDER BY entrevista.Id_Entrevista
            ";

            $this->db->query($sql);
            return $this->db->registers();
        } catch (\Throwable $th) {
            return false;
        }
    }
/*-------------------------FIN FUNCIONES ANEXO E------------------------------*/


    public function getDocumentacionC($Id_Puesta)
    {
        $sql =  "SELECT * FROM iph_documentacion_complementaria WHERE Id_Puesta = " . $Id_Puesta;
        $this->db->query($sql);
        return $this->db->registers();
    }

    public function updateNombreRemDic($nombre, $paterno, $materno, $genero, $edad, $detenido, $domicilio = '')
    {
        try{
            $this->db->beginTransaction();
            $iph = 'IPH_'.$detenido;
            $sql = "UPDATE detenido
                    SET 
                        Nombre = '". $nombre ."',
                        Ap_Paterno = '". $paterno ."',
                        Ap_Materno = '". $materno ."',
                        Genero = '". $genero ."',
                        Edad = '". $edad ."'
                    WHERE Id_IPH = '". $iph ."'";
            
            
            $this->db->query($sql);
            $this->db->execute();

            $sql = "UPDATE dictamen_medico_detenido
                    SET 
                        Nombre = '". $nombre ."',
                        Ap_Paterno = '". $paterno ."',
                        Ap_Materno = '". $materno ."',
                        Genero = '". $genero ."',
                        Edad = '". $edad ."',
                        Domicilio = '" . $domicilio . "'
                    WHERE No_Detenido = '". $iph ."'";
            
            $this->db->query($sql);
            $this->db->execute();
            
            $this->db->commit();
            $response['success'] = true;
        }catch(Exception $e){
            $this->db->rollBack();
            $response['success'] = false;
            $response['error_message'] = $e;
        }

        return $response;
    }

    public function getDetenidosJuridico($modulo)
    {
        try{
            $this->db->beginTransaction();

            ($modulo == 'Remisiones') ? $bit = 1 : $bit = 2; 

            $sql = "SELECT detenido.Id_Detenido, CONCAT(detenido.Nombre_D,' ',detenido.Ap_Paterno_D,' ',detenido.Ap_Materno_D) AS fullname, detenido.Id_Puesta FROM iph_detenido AS detenido
            LEFT JOIN iph_puesta_disposicion AS puesta ON puesta.Id_Puesta = detenido.Id_Puesta
            WHERE (detenido.Status_Detenido_RD = 0 OR detenido.Status_Detenido_RD =".$bit.") AND detenido.Status = 1 AND UNIX_TIMESTAMP(puesta.Fecha_Hora_Registro) >= (UNIX_TIMESTAMP()-24*3600) ORDER BY puesta.Id_Puesta DESC";

            $this->db->query($sql);
            $detenidos = $this->db->registers();

            $this->db->commit();
            $response['status'] = true;
            $response['detenidos'] = $detenidos;
        }catch(Exception $e){
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollBack();
        }

        return $response;
    }

    public function updateBitJuridicoDetenido($id_detenido, $modulo)
    {
        try {

            $this->db->beginTransaction();

            $sql = "SELECT reverse(EXPORT_SET(Status_Detenido_RD,'1','0','',2)) AS Reverse FROM iph_detenido WHERE Id_Detenido =" . $id_detenido;
            $this->db->query($sql);
            if ($this->db->register()) {
                $bit = $this->db->register()->Reverse;
                $bit[$modulo] = 1;
                $sql = " UPDATE iph_detenido
                    SET Status_Detenido_RD = b'" . $bit . "'
                    WHERE Id_Detenido = $id_detenido
                ";
                $this->db->query($sql);
                $this->db->execute();

                $response['status'] = true;
            } else {
                $response['status'] = false;
            }

            $this->db->commit();
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollBack();
        }

        return $response;
    }

    // Detele registo de anexo X por su id registro correspondiente
    public function deleteAnexoChangeStatus($anexo,$id_registro){
        try {

            $resp['success'] = false;
            $sql = 'UPDATE ';
            switch($anexo){
                case 'A': $sql.= 'iph_detenido                  SET Status = 0 WHERE Id_Detenido                    = '.$id_registro; break;
                case 'B': $sql.= 'iph_informe_uso_fuerza        SET Status = 0 WHERE Id_Informe_Uso_Fuerza          = '.$id_registro; break;
                case 'C': $sql.= 'iph_inspeccion_vehiculo       SET Status = 0 WHERE Id_Inspeccion_Vehiculo         = '.$id_registro; break;
                case 'D1': $sql.= 'iph_inventario_arma          SET Status = 0 WHERE Id_Inventario_Arma             = '.$id_registro; break;
                case 'D2': $sql.= 'iph_inventario_objeto        SET Status = 0 WHERE Id_Inventario_Objetos          = '.$id_registro; break;                    
                case 'E': $sql.= 'iph_entrevista                SET Status = 0 WHERE Id_Entrevista                  = '.$id_registro; break;
                case 'F': $sql.= 'iph_entrega_recepcion_lugar   SET Status = 0 WHERE Id_Entrega_Recepcion_Lugar     = '.$id_registro; break;
            }
            $this->db->beginTransaction(); //inicio de transaction
                $this->db->query($sql);
                $this->db->execute();
                $resp['success'] = true;
            $this->db->commit(); //inicio de transaction
        } catch (\Throwable $th) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            $resp['success'] = false;
            $resp['error_message'] = $err;
        }
        
        return $resp;
    }
}
