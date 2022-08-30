<?php
/*
	filtros:
	1  - View general de Eventos delictivos
	2  - Elementos participantes de cada ED
	3  - Ubicacion de los hechos ED
	4  - Observación vehiculos
	5  - Situación
	6  - Objetos robados
	7  - Objetos recuperados/asegurados
	8  - Responsables ED
	9  - Peticionarios ED
	10 - Usuarios del sistema
*/
class EventoD
{
	
	public $db; //variable para instanciar el objeto PDO
    public function __construct(){
        $this->db = new Base(); //se instancia el objeto con los métodos de PDO
    }

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
        	case '1':	//general
        		$from_where_sentence.= "FROM ed_view_filtro_1 
        									WHERE 
        								 	(Folio_N LIKE '%".$cadena."%' OR 
        								 	Zona LIKE '%".$cadena."%' OR 
				        					Cia LIKE '%".$cadena."%' OR 
				        					Vector LIKE '%".$cadena."%' OR 
				        					Full_Name_Peticionario LIKE '%".$cadena."%' OR 
				        					Telefono_Peticionario LIKE '%".$cadena."%' OR 
				        					Calle_1 LIKE '%".$cadena."%' OR 
				        					Calle_2 LIKE '%".$cadena."%' OR 
				        					Numero LIKE '%".$cadena."%' OR 
				        					Colonia_Tipo LIKE '%".$cadena."%' OR 
				        					Colonia LIKE '%".$cadena."%' OR 
				        					Motivo_Evento LIKE '%".$cadena."%' OR 
				        					Giro_Evento LIKE '%".$cadena."%' OR 
				        					Caracteristica_Evento LIKE '%".$cadena."%' OR 
				        					Observaciones LIKE '%".$cadena."%' OR 
				        					Objetos_Robados LIKE '%".$cadena."%' OR 
				        					Marca LIKE '%".$cadena."%' OR 
				        					Tipo_Vehiculo LIKE '%".$cadena."%' OR 
				        					Year LIKE '%".$cadena."%' OR 
				        					Placas LIKE '%".$cadena."%' OR 
				        					Color LIKE '%".$cadena."%' OR 
				        					Situacion LIKE '%".$cadena."%' OR 
				        					Remisiones LIKE '%".$cadena."%' OR 
				        					Tipo_Arma LIKE '%".$cadena."%' OR 
				        					Modus_Operandi LIKE '%".$cadena."%' OR 
				        					Modo_Fuga LIKE '%".$cadena."%' OR 
				        					Responsables LIKE '%".$cadena."%')
				        				";
				
        	break;
        	case '2':	//general
        		$from_where_sentence.= "FROM ed_view_filtro_2 
        									WHERE 
        								 	(Folio_N LIKE '%".$cadena."%' OR 
        								 	Zona LIKE '%".$cadena."%' OR 
				        					Cia LIKE '%".$cadena."%' OR 
				        					Vector LIKE '%".$cadena."%' OR 
				        					Full_Name_Peticionario LIKE '%".$cadena."%' OR 
				        					Telefono_Peticionario LIKE '%".$cadena."%' OR 
				        					Calle_1 LIKE '%".$cadena."%' OR 
				        					Calle_2 LIKE '%".$cadena."%' OR 
				        					Numero LIKE '%".$cadena."%' OR 
				        					Colonia_Tipo LIKE '%".$cadena."%' OR 
				        					Colonia LIKE '%".$cadena."%' OR 
				        					Motivo_Evento LIKE '%".$cadena."%' OR 
				        					Giro_Evento LIKE '%".$cadena."%' OR 
				        					Caracteristica_Evento LIKE '%".$cadena."%' OR 
				        					Observaciones LIKE '%".$cadena."%' OR 
				        					Objetos_Robados LIKE '%".$cadena."%' OR 
				        					Marca LIKE '%".$cadena."%' OR 
				        					Tipo_Vehiculo LIKE '%".$cadena."%' OR 
				        					Year LIKE '%".$cadena."%' OR 
				        					Placas LIKE '%".$cadena."%' OR 
				        					Color LIKE '%".$cadena."%' OR 
				        					Situacion LIKE '%".$cadena."%' OR 
				        					Remisiones LIKE '%".$cadena."%' OR 
				        					Tipo_Arma LIKE '%".$cadena."%' OR 
				        					Modus_Operandi LIKE '%".$cadena."%' OR 
				        					Modo_Fuga LIKE '%".$cadena."%' OR 
				        					Responsables LIKE '%".$cadena."%')
				        				";
				
        	break;
        	case '3':	//general
        		$from_where_sentence.= "FROM ed_view_filtro_3 
        									WHERE 
        								 	(Folio_N LIKE '%".$cadena."%' OR 
        								 	Zona LIKE '%".$cadena."%' OR 
				        					Cia LIKE '%".$cadena."%' OR 
				        					Vector LIKE '%".$cadena."%' OR 
				        					Full_Name_Peticionario LIKE '%".$cadena."%' OR 
				        					Telefono_Peticionario LIKE '%".$cadena."%' OR 
				        					Calle_1 LIKE '%".$cadena."%' OR 
				        					Calle_2 LIKE '%".$cadena."%' OR 
				        					Numero LIKE '%".$cadena."%' OR 
				        					Colonia_Tipo LIKE '%".$cadena."%' OR 
				        					Colonia LIKE '%".$cadena."%' OR 
				        					Motivo_Evento LIKE '%".$cadena."%' OR 
				        					Giro_Evento LIKE '%".$cadena."%' OR 
				        					Caracteristica_Evento LIKE '%".$cadena."%' OR 
				        					Observaciones LIKE '%".$cadena."%' OR 
				        					Objetos_Robados LIKE '%".$cadena."%' OR 
				        					Marca LIKE '%".$cadena."%' OR 
				        					Tipo_Vehiculo LIKE '%".$cadena."%' OR 
				        					Year LIKE '%".$cadena."%' OR 
				        					Placas LIKE '%".$cadena."%' OR 
				        					Color LIKE '%".$cadena."%' OR 
				        					Situacion LIKE '%".$cadena."%' OR 
				        					Remisiones LIKE '%".$cadena."%' OR 
				        					Tipo_Arma LIKE '%".$cadena."%' OR 
				        					Modus_Operandi LIKE '%".$cadena."%' OR 
				        					Modo_Fuga LIKE '%".$cadena."%' OR 
				        					Responsables LIKE '%".$cadena."%')
				        				";
				
        	break;
        }

        //where complemento fechas (si existe)
        $from_where_sentence.= $this->getFechaCondition();
        //order by
		$from_where_sentence.= " ORDER BY Folio_N";   
        return $from_where_sentence;
    }

    public function getEventoDByCadena($cadena,$filtro='1'){
    	//CONSULTA COINCIDENCIAS DE CADENA PARA EVENTOS DELICTIVOS
        if (!is_numeric($filtro) || !($filtro>=MIN_FILTRO_ED) || !($filtro<=MAX_FILTRO_ED))
        	$filtro = 1;
        
        //sentencia from_where para hacer la busqueda por la cadena ingresada
        $from_where_sentence = $this->generateFromWhereSentence($cadena,$filtro);
        $numPage = 1;
        $no_of_records_per_page = NUM_MAX_REG_PAGE; //total de registros por pagination
        $offset = ($numPage-1) * $no_of_records_per_page; // desplazamiento conforme a la pagina

        $results = $this->getTotalPages($no_of_records_per_page,$from_where_sentence);  //total de páginas conforme a la busqueda
        //info de retorno para la creacion de los links conforme a la cadena ingresada
        $data['rows_Eventos'] = $this->getDataCurrentPage($offset,$no_of_records_per_page,$from_where_sentence);   //se obtiene la información de la página actual
        $data['numPage'] = $numPage; //numero pag actual para la pagination footer
        $data['total_pages'] = $results['total_pages']; //total pages para la pagination
        $data['total_rows'] = $results['total_rows'];   //total de registro hallados
        
        return $data;
    }
    
    //obtener todos los registros de un cierto filtro para su exportación
    public function getAllInfoEventoDByCadena($from_where_sentence = ""){
    	$sqlAux = "SELECT *"
    				.$from_where_sentence."
                    ";  //query a la DB
        $this->db->query($sqlAux);          //se prepara el query mediante PDO
        return $this->db->registers();      //retorna todos los registros devueltos por la consulta
    }

    //función auxiliar para filtrar por un rango de fechas específicado por el usuario
    public function getFechaCondition(){
    	$cad_fechas = "";
    	if (isset($_SESSION['userdata']->rango_inicio_ed) && isset($_SESSION['userdata']->rango_fin_ed)) { //si no ingresa una fecha se seleciona el día de hoy como máximo
    		$rango_inicio = $_SESSION['userdata']->rango_inicio_ed;
    		$rango_fin = $_SESSION['userdata']->rango_fin_ed;
    		$cad_fechas = " AND 
        					Fecha >= '".$rango_inicio."'  AND 
        					Fecha <= '".$rango_fin."' 
        					";
    	}

    	return $cad_fechas; 
    }

	/* ----- ----- ----- Insertar actualizar data ----- ----- ----- */
	public function insertUpdateEvento($post)
	{
		try{
			$this->db->beginTransaction();

			$folio = $post['folio_no'];
			$user = $_SESSION['userdata']->Id_Usuario;
			$responsables = json_decode($post['responsables']);
			
			$num_responsables = count($responsables);
			$hombres = $mujeres = 0;
			
			foreach($responsables as $responsable){
				if($responsable->row->sexo == 'HOMBRE') $hombres++;
				if($responsable->row->sexo == 'MUJER') $mujeres++;
			}

			/* ----- ----- ----- Evento ----- ----- ----- */
			$evento = $this->existeRegistroTabla('ed_evento', ['Folio_N'], [$folio]);
			if(!$evento){
				$sql = "INSERT
						INTO ed_evento(
							Folio_N,
							Zona,
							Cia,
							Vector,
							Fecha,
							Hora_Reporte,
							Id_Usuario,
							Num_Responsables,
							Hombres,
							Mujeres,
							Full_Name_Peticionario,
							Telefono_Peticionario
						)VALUES(
							'" . trim($folio) . "',
							'" . trim($post['zona']) . "',
							'" . trim($post['cia']) . "',
							'" . trim($post['vector']) . "',
							'" . trim($post['fecha']) . "',
							'" . trim($post['hora_reporte']) . "',
							'" . $user . "',
							'" . $num_responsables . "',
							'" . $hombres . "',
							'" . $mujeres . "',
							'" . trim($post['peticionario']) . "',
							'" . trim($post['telefono']) . "'
						)
				";

				$this->db->query($sql);
                $this->db->execute();
			}else{
				$sql = "UPDATE ed_evento
						SET
							Zona                    = '" . trim($post['zona']) . "',
							Cia                     = '" . trim($post['cia']) . "',
							Status					= b'" . 1 . "',
							Vector                  = '" . trim($post['vector']) . "',
							Fecha                   = '" . trim($post['fecha']) . "',
							Hora_Reporte            = '" . trim($post['hora_reporte']) . "',
							Num_Responsables        = '" . $num_responsables . "',
							Hombres                 = '" . $hombres . "',
							Mujeres                 = '" . $mujeres . "',
							Full_Name_Peticionario  = '" . trim($post['peticionario']) . "',
							Telefono_Peticionario   = '" . trim($post['telefono']) . "'
						WHERE Folio_N = " . $folio;

				$this->db->query($sql);
                $this->db->execute();
			}

			$this->db->query("SELECT * FROM ed_evento WHERE Folio_N = ".$folio);
            $idEvento= $this->db->register()->Id_ED;

			/* ----- ----- ----- Ubicacion hechos ----- ----- ----- */
			$ubicacion = $this->existeRegistroTabla('ed_ubicacion_hechos', ['Id_ED'], [$idEvento]);
			if(!$ubicacion){
				$sql = "INSERT
						INTO ed_ubicacion_hechos(
							Id_ED,
							Calle_1,
							Calle_2,
							Numero,
							Colonia_Tipo,
							Colonia,
							Motivo_Evento,
							Giro_Evento,
							Caracteristica_Evento,
							Observaciones,
							Objetos_Robados
						)values(
							'" . $idEvento . "',
							'" . trim($post['dom_calle']) . "',
							'" . trim($post['calle']) . "',
							'" . trim($post['num']) . "',
							'" . trim($post['tipo_colonia']) . "',
							'" . trim($post['colonia']) . "',
							'" . trim($post['tipo_evento']) . "',
							'" . trim($post['giro_evento']) . "',
							'" . trim($post['caracteristicas_evento']) . "',
							'" . trim($post['observaciones']) . "',
							'" . trim($post['objetos_robados']) . "'
						)
				";

				$this->db->query($sql);
                $this->db->execute();
			}else{
				$sql = "UPDATE ed_ubicacion_hechos
						SET
							Calle_1                 = '" . trim($post['dom_calle']) . "',
							Calle_2                 = '" . trim($post['calle']) . "',
							Numero                  = '" . trim($post['num']) . "',
							Colonia_Tipo            = '" . trim($post['tipo_colonia']) . "',
							Colonia                 = '" . trim($post['colonia']) . "',
							Motivo_Evento           = '" . trim($post['tipo_evento']) . "',
							Giro_Evento             = '" . trim($post['giro_evento']) . "',
							Caracteristica_Evento   = '" . trim($post['caracteristicas_evento']) . "',
							Observaciones           = '" . trim($post['observaciones']) . "',
							Objetos_Robados         = '" . trim($post['objetos_robados']) . "'
						WHERE Id_ED = " . $idEvento;

				$this->db->query($sql);
				$this->db->execute();
			}

			/* ----- ----- ----- Observaciones Vehiculo ----- ----- ----- */
			if($post['tipo_evento'] == 'ROBO DE VEHÍCULO'){

				$obs_vehiculo = $this->existeRegistroTabla('ed_observacion_vehiculo', ['Id_ED'], [$idEvento]);
				if(!$obs_vehiculo){
					$sql = "INSERT
							INTO ed_observacion_vehiculo(
								Id_ED,
								Marca,
								Tipo_Vehiculo,
								Year,
								Placas,
								Color
							)VALUES(
								'" . $idEvento . "',
								'" . trim($post['marca']) . "',
								'" . trim($post['tipo']) . "',
								'" . trim($post['anio']) . "',
								'" . trim($post['placas']) . "',
								'" . trim($post['color']) . "'
							)
					";

					$this->db->query($sql);
                	$this->db->execute();
				}else{
					$sql = "UPDATE ed_observacion_vehiculo
							SET
								Marca         = '" . trim($post['marca']) . "',
								Tipo_Vehiculo = '" . trim($post['tipo']) . "',
								Year          = '" . trim($post['anio']) . "',
								Placas        = '" . trim($post['placas']) . "',
								Color         = '" . trim($post['color']) . "'
							WHERE Id_ED = " . $idEvento;
						
					$this->db->query($sql);
					$this->db->execute();
				}
			}else{
				$sql = "DELETE FROM ed_observacion_vehiculo WHERE Id_ED = ". $idEvento;

				$this->db->query($sql);
				$this->db->execute();
			}

			/* ----- ----- ----- Situcion ----- ----- ----- */
			$situacion = $this->existeRegistroTabla('ed_situacion', ['Id_ED'], [$idEvento]);

			$detenidos = ($post['detenidos'] == 'Si') ? 1 : 0;
			$violencia = ($post['violencia'] == 'Si') ? 1 : 0;
			$cuantos = ($post['cuantos'] != '') ? trim($post['cuantos']) : 0 ;
			$remisiones = (isset($post['remisiones'])) ? trim($post['remisiones']) : '' ;

			if(!$situacion){
				$sql = "INSERT
						INTO ed_situacion(
							Id_ED,
							Situacion,
							Detenidos,
							Num_Detenidos,
							Remisiones,
							Con_Violencia,
							Tipo_Arma,
							Modus_Operandi,
							Modo_Fuga
						)VALUES(
							'" . $idEvento . "',
							'" . trim($post['situacion']) . "',
							b'" . $detenidos . "',
							$cuantos,
							'" . $remisiones . "',
							b'" . $violencia. "',
							'" . trim($post['tipo_arma']) . "',
							'" . trim($post['modus_operandi']) . "',
							'" . trim($post['modo_fuga']) . "'
						)
				";

				$this->db->query($sql);
				$this->db->execute();
			}else{
				$sql = "UPDATE ed_situacion
						SET
							Situacion        = '" . trim($post['situacion']) . "',
							Detenidos        = b'" . $detenidos . "',
							Num_Detenidos    = $cuantos ,
							Remisiones       = '" . $remisiones . "',
							Con_Violencia    = b'" . $violencia . "',
							Tipo_Arma        = '" . trim($post['tipo_arma']) . "',
							Modus_Operandi   = '" . trim($post['modus_operandi']) . "',
							Modo_Fuga        = '" . trim($post['modo_fuga']) . "'
						WHERE Id_ED = " . $idEvento;
						$this->db->query($sql);
				$this->db->execute();
			}

			/* ----- ----- ----- Responsables ----- ----- ----- */

			$sql = "DELETE FROM ed_responsable WHERE Id_ED =" . $idEvento;
            $this->db->query($sql);
            $this->db->execute();

			foreach($responsables as $responsable){
				$sexo = ($responsable->row->sexo == 'HOMBRE') ? 'H' : 'M';
				$sql = "INSERT
						INTO ed_responsable(
							Id_ED,
							No_Remision,
							Full_Nombre,
							Edad,
							Genero
						)VALUES(
							'" . $idEvento . "',
							'" . trim($responsable->row->remision) . "',
							'" . trim($responsable->row->nombre) . "',
							'" . trim($responsable->row->edad) . "',
							'" . $sexo . "'
						)
				";

				$this->db->query($sql);
				$this->db->execute();
			}
			

			$this->db->commit();
            $response['status'] = true;
		}catch (Exception $e){
			$response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollback();
		}

		return $response;
	}

	/* ----- ----- ----- Funciones ----- ----- ----- */
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

	public function existFicha($ficha)
	{
		try{
			$sql = "SELECT remision.No_Ficha, remision.No_Remision, CONCAT(detenido.Nombre,' ',detenido.Ap_Paterno,' ',detenido.Ap_Materno) AS fullname, detenido.Edad, detenido.Genero 
			FROM remision
			LEFT JOIN detenido ON remision.No_Remision = detenido.No_Remision
			WHERE remision.No_Ficha = ".$ficha." AND remision.Status_Remision = 1
			ORDER BY remision.No_Remision";

			$this->db->query($sql);
			return $this->db->registers();
		}catch(Exception $e){
			return false;
		}
	}

	public function existRemision($remision)
	{
		$response['status'] = true;
		try{
			$sql = "SELECT remision.No_Remision, CONCAT(detenido.Nombre,' ',detenido.Ap_Paterno,' ',detenido.Ap_Materno) AS fullname, detenido.Edad, detenido.Genero 
			FROM remision
			LEFT JOIN detenido ON remision.No_Remision = detenido.No_Remision
			WHERE remision.No_Remision = ".$remision." AND remision.Status_Remision = 1";

			$this->db->query($sql);
			$response['data'] = $this->db->register();
		}catch(Exception $e){
			$response['status'] = false;
			$response['message_error'] = $e;
			$this->db->rollback();
		}

		return $response;
	}

	public function deleteFolio($id){
		try{
			$this->db->beginTransaction();

			$sql = "UPDATE ed_evento
						SET
						Status	= b'" . 0 . "'
						WHERE Id_Ed = " . $id;

			$this->db->query($sql);
			$this->db->execute();


			$this->db->commit();
            $response['status'] = true;
		}catch(Exception $e){
			$response['status'] = false;
            $response['error_message'] = $e;
            $this->db->rollback();
		}

		return $response;
	}
}


?>