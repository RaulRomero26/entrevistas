<?php
class InteligenciaOperativaM
{
    public $db;

    public function __construct()
    {
        $this->db = new Base();
    }

    public function generateWhereSentence($cadena = "", $filtro = '1')
    {
        $where_sentence = "";
        switch ($filtro) {
            case '1':
                $where_sentence .= " FROM inteligencia_operativa_full_view
                                    WHERE(Id_Inteligencia_Io LIKE '%" . $cadena . "%' OR
                                        Nombre_Elemento_R LIKE '%" . $cadena . "%' OR
                                        Responsable_Turno LIKE '%" . $cadena . "%' OR
                                        Origen_Evento LIKE '%" . $cadena . "%' OR
                                        Fecha_Turno LIKE '%" . $cadena . "%' OR
                                        Turno LIKE '%" . $cadena . "%' OR
                                        Semana LIKE '%" . $cadena . "%' OR
                                        Folio_Deri LIKE '%" . $cadena . "%' OR
                                        Fecha_Evento LIKE '%" . $cadena . "%' OR
                                        Hora_Reporte LIKE '%" . $cadena . "%' OR
                                        Motivo LIKE '%" . $cadena . "%' OR
                                        Caracteristicas_Robo LIKE '%" . $cadena . "%' OR
                                        Violencia LIKE '%" . $cadena . "%' OR
                                        Tipo_Violencia LIKE '%" . $cadena . "%' OR
                                        Zona_Evento LIKE '%" . $cadena . "%' OR
                                        Vector LIKE '%" . $cadena . "%' OR
                                        Unidad_Primer_R LIKE '%" . $cadena . "%' OR
                                        Informacion_Primer_R LIKE '%" . $cadena . "%' OR
                                        Acciones LIKE '%" . $cadena . "%' OR
                                        Identificacion_Responsables LIKE '%" . $cadena . "%' OR
                                        Detencion_Por_Info_Io LIKE '%" . $cadena . "%' OR
                                        Elementos_Realizan_D LIKE '%" . $cadena . "%' OR
                                        Fecha_Detencion LIKE '%" . $cadena . "%' OR
                                        Compania LIKE '%" . $cadena . "%' OR
                                        vehiculos LIKE '%" . $cadena . "%' OR
                                        camaras LIKE '%" . $cadena . "%' OR
                                        domicilio LIKE '%" . $cadena . "%'
                                    )";

                break;
        }

        $where_sentence .= $this->getFechaCondition();
        return $where_sentence;
    }

    public function getFechaCondition()
    {
        $cad_fechas = "";
        if (
            isset($_SESSION['userdata']->rango_inicio_io) &&
            isset($_SESSION['userdata']->rango_fin_io) &&
            isset($_SESSION['userdata']->rango_hora_inicio_io) &&
            isset($_SESSION['userdata']->rango_hora_fin_io)
        ) { //si no ingresa una fecha se seleciona el día de hoy como máximo

            $rango_inicio = $_SESSION['userdata']->rango_inicio_io;
            $rango_fin = $_SESSION['userdata']->rango_fin_io;
            $rango_hora_inicio = $_SESSION['userdata']->rango_hora_inicio_io;
            $rango_hora_fin = $_SESSION['userdata']->rango_hora_fin_io;

            $cad_fechas = " AND 
                    Fecha_Evento >='" . $rango_inicio . "' AND Hora_Reporte >= '" . $rango_hora_inicio . "'
                    AND Fecha_Evento <='" . $rango_fin . "' AND Hora_Reporte <= '" . $rango_hora_fin . "'
                ";
        }

        return $cad_fechas;
    }

    public function getTotalPages($no_of_records_per_page, $where_sentence = "")
    {
        $where_sentence = strstr($where_sentence, 'FROM');

        $sql_total_pages = "SELECT COUNT(*) as Num_Pages " . $where_sentence;
        $this->db->query($sql_total_pages);
        $total_rows = $this->db->register()->Num_Pages;
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $data['total_rows'] = $total_rows;
        $data['total_pages'] = $total_pages;

        return $data;
    }

    public function getDataCurrentPage($offset, $no_of_records_per_page, $where_sentence = "")
    {
        $sql = "
                SELECT *" . $where_sentence . "
                LIMIT $offset , $no_of_records_per_page
            ";

        $this->db->query($sql);
        return $this->db->registers();
    }
    public function getHistorialByCadena($cadena, $filtro = 1)
    {
        if (!is_numeric($filtro) || !($filtro >= MIN_FILTRO_HIS) || !($filtro <= MAX_FILTRO_HIS)) {
            $filtro = 1;
        }

        $from_where_sentence = $this->generateWhereSentence($cadena, $filtro);
        $numPage = 1;
        $no_of_records_per_page = NUM_MAX_REG_PAGE;
        $offset = ($numPage - 1) * $no_of_records_per_page;

        $results = $this->getTotalPages($no_of_records_per_page, $from_where_sentence);

        $data['rows_Hisroriales'] = $this->getDataCurrentPage($offset, $no_of_records_per_page, $from_where_sentence);
        $data['numPage'] = $numPage;
        $data['total_pages'] = $results['total_pages'];
        $data['total_rows'] = $results['total_rows'];

        return $data;
    }

    public function getAllInfoHistorialByCadena($from_where_sentence = "")
    {
        $sqlAux = "SELECT *"
            . $from_where_sentence . "
                    ";

        $this->db->query($sqlAux);
        return $this->db->registers();
    }





    /*============================Consultas para obtener información de los catalogos=============================*/
    public function getOrigenEvento()
    {
        $sql = "SELECT Origen FROM catalogo_origen_evento";
        $this->db->query($sql);
        $data = $this->db->registers();
        return $data;
    }

    public function getFaltaDelito()
    {
        $sql = "SELECT Descripcion FROM catalogo_falta_delito";
        $this->db->query($sql);
        $data = $this->db->registers();
        return $data;
    }

    public function getTipoViolencia()
    {
        $sql = "SELECT Tipo_Violencia FROM catalogo_tipo_violencia";
        $this->db->query($sql);
        $data = $this->db->registers();
        return $data;
    }

    public function getMarcasVehiculos()
    {
        $sql = "SELECT Marca FROM catalogo_marca_vehiculos_io";

        $this->db->query($sql);
        $data = $this->db->registers();
        return $data;
    }

    public function getZone()
    {
        $sql = "SELECT Zona_Sector FROM catalogo_zonas_sectores WHERE Tipo_Grupo = " . "'POLICÍA'";
        $this->db->query($sql);
        $data = $this->db->registers();
        return $data;
    }

    public function getVector()
    {
        $sql = "SELECT Vector FROM catalogo_vectores";
        $this->db->query($sql);
        $data = $this->db->registers();
        return $data;
    }

    public function getUsoVehiculo()
    {
        $sql = "SELECT Uso FROM catalogo_uso_vehiculo";
        $this->db->query($sql);
        $data = $this->db->registers();
        return $data;
    }
    /*============================Fin de las consultas=============================*/


    public function inteligenciaExiste($id_inteligencia)
    {
        $sql = "SELECT COUNT(*) AS cuenta FROM inteligencia_io WHERE Id_Inteligencia_Io = " . $id_inteligencia;
        $this->db->query($sql);
        $count = $this->db->register()->cuenta;
        return $count;
    }
    /*============================Inserción a la BD=============================*/

    /*

    Orden de inserción
        1. Nuevo registro
        2. Domicilio 1
        3. Domicilio 2
        4. Vehiculos
    */

    public function nuevaInteligenciaOp($post, $files)
    {

        if ($files['Path_Pdf']['size'] > 0) {
            $nameFile = 'IO_' . date("Ymdhis") . '.pdf';
        } else {
            $nameFile = NULL;
        }

        $response['status'] = true;

        try {
            $this->db->beginTransaction(); //transaction para evitar errores de inserción

            $folio_deri = (isset($post['Folio_Deri'])) ? $post['Folio_Deri'] : '';


            $sql =  "INSERT 
                    INTO inteligencia_io(
                        Nombre_Elemento_R,
                        Responsable_Turno,
                        Origen_Evento,
                        Fecha_Turno,
                        Turno,
                        Semana,
                        Folio_Deri,
                        Fecha_Evento,
                        Hora_Reporte,
                        Motivo,
                        Caracteristicas_Robo,
                        Violencia,
                        Tipo_Violencia,
                        Zona_Evento,
                        Vector,
                        Unidad_Primer_R,
                        Informacion_Primer_R,
                        Acciones,
                        Identificacion_Responsables,
                        Detencion_Por_Info_Io,
                        Elementos_Realizan_D,
                        Fecha_Detencion,
                        Compania,
                        Path_Pdf
                    )
                    VALUES(
                        '" . $post['Nombre_Elemento_R'] . "',
                        '" . $post['Responsable_Turno'] . "',
                        '" . $post['Origen_Evento'] . "',
                        '" . $post['Fecha_Turno'] . "',
                        '" . $post['Turno'] . "',
                        '" . $post['Semana'] . "',
                        '" . $folio_deri . "',
                        '" . $post['Fecha_Evento'] . "',
                        '" . $post['Hora_Reporte'] . "',
                        '" . $post['Motivo'] . "',
                        '" . $post['Caracteristicas_Robo'] . "',
                        '" . $post['Violencia'] . "',
                        '" . $post['Tipo_Violencia'] . "',
                        '" . $post['Zona_Evento'] . "',
                        '" . $post['Vector'] . "',
                        '" . $post['Unidad_Primer_R'] . "',
                        '" . $post['Informacion_Primer_R'] . "',
                        '" . $post['Acciones'] . "',
                        '" . $post['Identificacion_Responsables'] . "',
                        '" . $post['Detencion_Por_Info_Io'] . "',
                        '" . $post['Elementos_Realizan_D'] . "',
                        '" . $post['Fecha_Detencion'] . "',
                        '" . $post['Compania'] . "',
                        '" . $nameFile . "'
                    )";


            $this->db->query($sql);
            $this->db->execute();

            $this->db->query("SELECT LAST_INSERT_ID() as Id_Inteligencia"); //se recupera el id de detenido creado recientemente
            $Id_Inteligencia = $this->db->register()->Id_Inteligencia;

            $sql = "INSERT 
                    INTO domicilio_io(
                        Municipio,
                        Colonia,
                        Calle,
                        No_Exterior,
                        No_Interior,
                        CP,
                        Coordenada_X,
                        Coordenada_Y,
                        Id_Inteligencia_Io,
                        Num_Domicilio
                    )
                    VALUES(
                        '" . $post['Municipio'] . "',
                        '" . $post['Colonia'] . "',
                        '" . $post['Calle'] . "',
                        '" . $post['noExterior'] . "',
                        '" . $post['noInterior'] . "',
                        '" . $post['CP'] . "',
                        '" . $post['cordX'] . "',
                        '" . $post['cordY'] . "',
                        " . $Id_Inteligencia . ",
                        b'0'
                    )";

            $this->db->query($sql);
            $this->db->execute();


            $sql = "INSERT 
                    INTO domicilio_io(
                        Municipio,
                        Colonia,
                        Calle,
                        No_Exterior,
                        No_Interior,
                        CP,
                        Coordenada_X,
                        Coordenada_Y,
                        Id_Inteligencia_Io,
                        Num_Domicilio
                    )
                    VALUES(
                        '" . $post['Municipio_1'] . "',
                        '" . $post['Colonia_1'] . "',
                        '" . $post['Calle_1'] . "',
                        '" . $post['noExterior_1'] . "',
                        '" . $post['noInterior_1'] . "',
                        '" . $post['CP_1'] . "',
                        '" . $post['cordX_1'] . "',
                        '" . $post['cordY_1'] . "',
                        " . $Id_Inteligencia . ",
                        b'1'
                    )";

            $this->db->query($sql);
            $this->db->execute();

            $vehiculos = json_decode($post['table_vehiculos']);
            foreach ($vehiculos as $vehiculo) {
                $sql = " INSERT
                        INTO vehiculo_io(
                            Id_Inteligencia_Io,
                            Marca,
                            Modelo,
                            Color,
                            Placas,
                            Uso_Vehiculo,
                            Caracteristicas_Vehiculo,
                            Identificacion_Placa,
                            Involucrado_robado
                        )
                        VALUES(
                            $Id_Inteligencia,
                            '" . $vehiculo->row->marca . "',
                            '" . $vehiculo->row->modelo . "',
                            '" . $vehiculo->row->color . "',
                            '" . $vehiculo->row->placa . "',
                            '" . $vehiculo->row->Uso . "',
                            '" . $vehiculo->row->caracteristicas . "',
                            '" . $vehiculo->row->identificacionPlaca . "',
                            '" . $vehiculo->row->Involucrado_robado . "'  
                        )
                ";
                $this->db->query($sql);
                $this->db->execute();
            }


            $camaras = json_decode($post['camaras']);

            foreach ($camaras as $camara) {
                $sql = "INSERT 
                    INTO camara_io(
                        Id_Inteligencia_Io,
                        Ubicacion,
                        Estatus_Camara,
                        Tipo_Camara
                    ) VALUES(
                        $Id_Inteligencia,
                        '" . $camara->row->ubicacion . "',
                        '" . $camara->row->estatus . "',
                        '" . $camara->row->tipo . "'

                    )";
                $this->db->query($sql);
                $this->db->execute();
            }

            $this->db->commit(); //si todo sale bien se realiza los commits

            $response['Id_Inteligencia'] =  $Id_Inteligencia;
            $response['nameFile'] =  $nameFile;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;

            $this->db->rollBack(); //si algo falla realiza el rollBack por seguridad
        }
        return $response;
    }


    public function editarInteligenciaOp($post, $files)
    {

        $response['status'] = true;
        $folio_deri = (isset($post['Folio_Deri'])) ? $post['Folio_Deri'] : '';
        $camaras = json_decode($post['camaras']);

        try {
            $this->db->beginTransaction(); //transaction para evitar errores de inserción

            $sql = "    UPDATE inteligencia_io
                            SET 
                                Nombre_Elemento_R = '" . $post['Nombre_Elemento_R'] . "',
                                Responsable_Turno = '" . $post['Responsable_Turno'] . "',
                                Origen_Evento = '" . $post['Origen_Evento'] . "',
                                Fecha_Turno = '" . $post['Fecha_Turno'] . "',
                                Turno = '" . $post['Turno'] . "',
                                Semana = '" . $post['Semana'] . "',
                                Folio_Deri = '" . $folio_deri . "',
                                Fecha_Evento = '" . $post['Fecha_Evento'] . "',
                                Hora_Reporte = '" . $post['Hora_Reporte'] . "',
                                Motivo = '" . $post['Motivo'] . "',
                                Caracteristicas_Robo = '" . $post['Caracteristicas_Robo'] . "',
                                Violencia = '" . $post['Violencia'] . "',
                                Tipo_Violencia = '" . $post['Tipo_Violencia'] . "',
                                Zona_Evento = '" . $post['Zona_Evento'] . "', 
                                Vector = '" . $post['Vector'] . "',
                                Unidad_Primer_R = '" . $post['Unidad_Primer_R'] . "',
                                Informacion_Primer_R = '" . $post['Informacion_Primer_R'] . "',
                                Acciones = '" . $post['Acciones'] . "',
                                Identificacion_Responsables = '" . $post['Identificacion_Responsables'] . "',
                                Detencion_Por_Info_Io = '" . $post['Detencion_Por_Info_Io'] . "',
                                Elementos_Realizan_D = '" . $post['Elementos_Realizan_D'] . "',
                                Fecha_Detencion = '" . $post['Fecha_Detencion'] . "',
                                Compania = '" . $post['Compania'] . "'
                            WHERE Id_Inteligencia_Io = " . $post['id_Inteligencia'];
            $this->db->query($sql);
            $this->db->execute();

            if ($files['Path_Pdf']['size'] > 0) {
                $nameFile = 'IO_' . date("Ymdhis") . '.pdf';

                $sql = "    UPDATE inteligencia_io
                            SET
                                Path_Pdf = '" . $nameFile . "'
                            WHERE Id_Inteligencia_Io = " . $post['id_Inteligencia'];
                $this->db->query($sql);
                $this->db->execute();

                $response['nameFile'] = $nameFile;
            }



            $sql = "UPDATE domicilio_io
                    SET 
                        Municipio = '" . $post['Municipio'] . "',
                        Colonia = '" . $post['Colonia'] . "',
                        Calle = '" . $post['Calle'] . "',
                        No_Exterior = '" . $post['noExterior'] . "',
                        No_Interior =  '" . $post['noInterior'] . "',
                        CP =  '" . $post['CP'] . "',
                        Coordenada_X = '" . $post['cordX'] . "',
                        Coordenada_Y = '" . $post['cordY'] . "'
                    WHERE Id_Inteligencia_Io = " . $post['id_Inteligencia'] . " AND Num_Domicilio = 0";
            $this->db->query($sql);
            $this->db->execute();

            $sql = "UPDATE domicilio_io
                    SET 
                        Municipio = '" . $post['Municipio_1'] . "',
                        Colonia = '" . $post['Colonia_1'] . "',
                        Calle = '" . $post['Calle_1'] . "',
                        No_Exterior = '" . $post['noExterior_1'] . "',
                        No_Interior =  '" . $post['noInterior_1'] . "',
                        CP =  '" . $post['CP_1'] . "',
                        Coordenada_X = '" . $post['cordX_1'] . "',
                        Coordenada_Y = '" . $post['cordY_1'] . "'
                    WHERE Id_Inteligencia_Io = " . $post['id_Inteligencia'] . " AND Num_Domicilio = 1";
            $this->db->query($sql);
            $this->db->execute();

            $this->db->query("DELETE FROM vehiculo_io WHERE Id_Inteligencia_Io = " . $post['id_Inteligencia']);
            $this->db->execute();

            $vehiculos = json_decode($post['table_vehiculos']);
            foreach ($vehiculos as $vehiculo) {
                $sql = " INSERT
                        INTO vehiculo_io(
                            Id_Inteligencia_Io,
                            Marca,
                            Modelo,
                            Color,
                            Placas,
                            Identificacion_Placa,
                            Uso_Vehiculo,
                            Caracteristicas_Vehiculo,
                            Involucrado_robado
                        )
                        VALUES(
                            " . $post['id_Inteligencia'] . ",
                            '" . $vehiculo->row->marca . "',
                            '" . $vehiculo->row->modelo . "',
                            '" . $vehiculo->row->color . "',
                            '" . $vehiculo->row->placa . "',
                            '" . $vehiculo->row->identificacionPlaca . "',
                            '" . $vehiculo->row->Uso . "',
                            '" . $vehiculo->row->caracteristicas . "',
                            '" . $vehiculo->row->Involucrado_robado . "'
                        )
                ";
                $this->db->query($sql);
                $this->db->execute();
            }

            $this->db->query("DELETE FROM camara_io WHERE Id_Inteligencia_Io = " . $post['id_Inteligencia']);
            $this->db->execute();

            $camaras = json_decode($post['camaras']);

            foreach ($camaras as $camara) {
                $sql = "INSERT 
                    INTO camara_io(
                        Id_Inteligencia_Io,
                        Ubicacion,
                        Estatus_Camara,
                        Tipo_Camara
                    ) VALUES(
                        " . $post['id_Inteligencia'] . ",
                        '" . $camara->row->ubicacion . "',
                        '" . $camara->row->estatus . "',
                        '" . $camara->row->tipo . "'
                    )";
                $this->db->query($sql);
                $this->db->execute();
            }
            $this->db->commit(); //si todo sale bien se realiza los commits

        } catch (Exception $e) {
            $response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollBack(); //si algo falla realiza el rollBack por seguridad
        }
        return $response;
    }
    /*============================Fin de las consultas=============================*/


    /*============================Función para traer toda la información por registro de inteligencia operativa=============================*/

    public function getDataInteligenciaById($type, $id_Inteligencia)
    {

        /*
            1. Tipo 0: Consultas con Where.
            2. Tipo 1: Consultas sin Where.
        */
        switch ($type) {
            case 0: //Consultas con Where
                $sql = "SELECT * FROM inteligencia_io WHERE Id_Inteligencia_Io = " . $id_Inteligencia;
                $this->db->query($sql);
                $data['inteligencia_operativa'] = $this->db->register();

                $sql = "SELECT * FROM domicilio_io WHERE Id_Inteligencia_Io = " . $id_Inteligencia;
                $this->db->query($sql);
                $data['domicilio'] = $this->db->registers();

                $sql = "SELECT * FROM vehiculo_io WHERE Id_Inteligencia_Io = " . $id_Inteligencia;
                $this->db->query($sql);
                $data['vehiculo'] = $this->db->registers();

                $sql = "SELECT * FROM camara_io WHERE Id_Inteligencia_Io = " . $id_Inteligencia;
                $this->db->query($sql);
                $data['camara'] = $this->db->registers();
                break;

            case 1: //Consultas sin Where
                $sql = "SELECT * FROM inteligencia_io";
                $this->db->query($sql);
                $data['inteligencia_operativa'] = $this->db->registers();

                $sql = "SELECT * FROM domicilio_io ";
                $this->db->query($sql);
                $data['domicilio'] = $this->db->registers();

                $sql = "SELECT * FROM vehiculo_io";
                $this->db->query($sql);
                $data['vehiculo'] = $this->db->registers();
                break;
        }
        return $data;
    }

    /*============================Fin de las consultas=============================*/
}
