<?php

class DictamenM{

    public $db; //variable para instanciar el objeto PDO
    public function __construct(){
        $this->db = new Base(); //se instancia el objeto con los métodos de PDO
    }

    //obtener la info principal sobre el detenido y el elemento participante principal
    public function getInfoRemisionForDictamen($id_dictamen){
    	$returnInfo = false; //se incia en false por si ocurre un error durante el proceso
    	$sql = "
    			SELECT * FROM dictamen_view WHERE Id_Dictamen = $id_dictamen
    			";
    	$this->db->query($sql);
    	return $this->db->register(); //obtenemos la información obtenida por la consulta 
    }

    // se inserta nuevo dictamen solo en caso de OTRO porque de los demás no es necesario ya que ya existirán los registros desde jurídico
    public function insertDictamen($post){
        try {
            $return['success'] = false;
            $return['error_message'] = '';
            //asignando checkboxes a cadena
            $Intoxicacion_Etilica = ''; $Orientacion = ''; $Sustancia_Consumida = ''; $Aliento = ''; $Lenguaje = '';
            foreach ($post['IE'] as $value) {
                $Intoxicacion_Etilica.= $value;
            }
            foreach ($post['Orient'] as $value) {
                $Orientacion.= $value;
            }
            foreach ($post['SustanciaC'] as $value) {
                $Sustancia_Consumida.= $value;
            }
            foreach ($post['Aliento_A'] as $value) {
                $Aliento.= $value;
            }
            foreach ($post['Lenguaje_Bit'] as $value) {
                $Lenguaje.= $value;
            }
            //get all fields
            $Id_Usuario     = $post['Id_Usuario'];
            //detenido
            $Nombre        = (isset($post['Nombre']))?$post['Nombre']:'';
            $Ap_Paterno    = (isset($post['Ap_Paterno']))?$post['Ap_Paterno']:'';
            $Ap_Materno    = (isset($post['Ap_Materno']))?$post['Ap_Materno']:'';
            $Ocupacion     = (isset($post['Ocupacion']))?$post['Ocupacion']:'';
            $Edad          = (isset($post['Edad']))?$post['Edad']:'';
            $Genero        = (isset($post['Genero']))?$post['Genero']:'';
            $Domicilio     = (isset($post['Domicilio']))?$post['Domicilio']:'';
            //elemento
            $Nombre_E        = (isset($post['Nombre_E']))?$post['Nombre_E']:'';
            $Ap_Paterno_E    = (isset($post['Ap_Paterno_E']))?$post['Ap_Paterno_E']:'';
            $Ap_Materno_E    = (isset($post['Ap_Materno_E']))?$post['Ap_Materno_E']:'';
            $Placa_E         = (isset($post['Placa_E']))?$post['Placa_E']:'';
            $Cargo_E         = (isset($post['Cargo_E']))?$post['Cargo_E']:'';
            $Sector_Area_E   = (isset($post['Sector_Area_E']))?$post['Sector_Area_E']:'';
            $Unidad_E        = (isset($post['Unidad_E']))?$post['Unidad_E']:'';

            $Fecha_Hora				= (isset($post['Fecha_Dictamen']))?$post['Fecha_Dictamen'].' ':'';
            $Fecha_Hora			   .= (isset($post['Hora_Dictamen']))?$post['Hora_Dictamen']:'';
            $Instancia 				= (isset($post['Instancia']))?$post['Instancia']:'';
            //$Observaciones_Genero	= (isset($post['Observaciones_Genero']))?$post['Observaciones_Genero']:'';
            $Enfermedades_Padece	= (isset($post['Enfermedades_Padece']))?$post['Enfermedades_Padece']:'';
            $Medicamentos_Toma		= (isset($post['Medicamentos_Toma']))?$post['Medicamentos_Toma']:'';
            $Prueba_Alcoholimetro	= (isset($post['Prueba_Alcoholimetro']))?$post['Prueba_Alcoholimetro']:'';
            $Prueba_Multitestdrog	= (isset($post['Prueba_Multitestdrog']))?$post['Prueba_Multitestdrog']:'';
            $Prueba_Clinica			= (isset($post['Prueba_Clinica']))?$post['Prueba_Clinica']:'';
            $Coopera_Interrogatorio	= (isset($post['Coopera_Interrogatorio']))?$post['Coopera_Interrogatorio']:'';
            //$Sustancia_Consumida	= (isset($post['Sustancia_Consumida']))?$post['Sustancia_Consumida']:'';
            $Fecha_Hora_Consumo = '';
            if(isset($post['Fecha_Consumo']) && isset($post['Hora_Consumo'])){ //ambos
                if($post['Fecha_Consumo'] != '' && $post['Hora_Consumo'] != ''){
                    $Fecha_Hora_Consumo = $post['Fecha_Consumo'].' '.$post['Hora_Consumo'];
                }
                else if($post['Fecha_Consumo'] != ''){
                    $Fecha_Hora_Consumo = $post['Fecha_Consumo'];
                }
                else if($post['Hora_Consumo'] != ''){
                    $Fecha_Hora_Consumo = $post['Hora_Consumo'];
                }
            }
            // $Fecha_Hora_Consumo		= (isset($post['Fecha_Consumo']) && $post['Fecha_Consumo'] != '')?$post['Fecha_Consumo'].' ':'';
            // $Fecha_Hora_Consumo    .= (isset($post['Hora_Consumo']) && $post['Hora_Consumo'] != '')?$post['Hora_Consumo']:'';

            $Cantidad_Consumida		= (isset($post['Cantidad_Consumida']))?$post['Cantidad_Consumida']:'';
            $Estado_Conciencia		= (isset($post['Estado_Conciencia']))?$post['Estado_Conciencia']:'';
            $Actitud				= (isset($post['Actitud']))?$post['Actitud']:'';
            //$Lenguaje				= (isset($post['Lenguaje']))?$post['Lenguaje']:'';
            $Fascies				= (isset($post['Fascies']))?$post['Fascies']:'';
            $Conjuntivas			= (isset($post['Conjuntivas']))?$post['Conjuntivas']:'';
            $Pupilas				= (isset($post['Pupilas']))?$post['Pupilas']:'';
            $Pupilas2                = (isset($post['Pupilas2']))?$post['Pupilas2']:'';
            $Mucosa_Oral			= (isset($post['Mucosa_Oral']))?$post['Mucosa_Oral']:'';
            //$Aliento				= (isset($post['Aliento']))?$post['Aliento']:'';
            $Heridas_Lesiones		= (isset($post['Heridas_Lesiones']))?$post['Heridas_Lesiones']:'';
            $Observaciones			= (isset($post['Observaciones']))?$post['Observaciones']:'';
            $Diagnostico			= (isset($post['Diagnostico']))?$post['Diagnostico']:'';

            $this->db->beginTransaction(); //inicio de transaction
               //----------------begin_transaction----------------
               $sql = "
                        INSERT INTO dictamen_medico_detenido (  Tipo_Dictamen,
                                                                Instancia,
                                                                Fecha_Hora, 
                                                                Enfermedades_Padece, 
                                                                Medicamentos_Toma, 
                                                                Prueba_Alcoholimetro, 
                                                                Prueba_Multitestdrog, 
                                                                Prueba_Clinica, 
                                                                Coopera_Interrogatorio, 
                                                                Sustancia_Consumida, 
                                                                Fecha_Hora_Consumo, 
                                                                Cantidad_Consumida, 
                                                                Intoxicacion_Etilica, 
                                                                Estado_Conciencia, 
                                                                Orientacion, 
                                                                Actitud, 
                                                                Lenguaje, 
                                                                Fascies, 
                                                                Conjuntivas, 
                                                                Pupilas,
                                                                Pupilas2, 
                                                                Mucosa_Oral, 
                                                                Aliento, 
                                                                Heridas_Lesiones, 
                                                                Observaciones, 
                                                                Diagnostico,
                                                                Nombre,
                                                                Ap_Paterno,
                                                                Ap_Materno,
                                                                Ocupacion,
                                                                Edad,
                                                                Genero,
                                                                Domicilio,
                                                                Nombre_E,
                                                                Ap_Paterno_E,
                                                                Ap_Materno_E,
                                                                Placa_E,
                                                                Cargo_E,
                                                                Sector_Area_E,
                                                                Unidad_E,
                                                                Id_Usuario,
                                                                No_detenido)
                                VALUES( b'1', 
                                        '".$Instancia."', 
                                        '".$Fecha_Hora."', 
                                        '".$this->limpiarEspaciosCadena($Enfermedades_Padece)."', 
                                        '".$this->limpiarEspaciosCadena($Medicamentos_Toma)."', 
                                        b'".$Prueba_Alcoholimetro."', 
                                        b'".$Prueba_Multitestdrog."', 
                                        b'".$Prueba_Clinica."', 
                                        b'".$Coopera_Interrogatorio."', 
                                        b'".$Sustancia_Consumida."', 
                                        '".$Fecha_Hora_Consumo."', 
                                        '".$Cantidad_Consumida."', 
                                        b'".$Intoxicacion_Etilica."', 
                                        '".$Estado_Conciencia."', 
                                        b'".$Orientacion."', 
                                        '".$Actitud."', 
                                        b'".$Lenguaje."', 
                                        '".$Fascies."', 
                                        '".$Conjuntivas."', 
                                        '".$Pupilas."', 
                                        '".$Pupilas2."', 
                                        '".$Mucosa_Oral."', 
                                        b'".$Aliento."', 
                                        '".$this->limpiarEspaciosCadena($Heridas_Lesiones)."', 
                                        '".$this->limpiarEspaciosCadena($Observaciones)."', 
                                        '".$Diagnostico."',

                                        '".$this->limpiarEspaciosCadena($Nombre)."',
                                        '".$this->limpiarEspaciosCadena($Ap_Paterno)."', 
                                        '".$this->limpiarEspaciosCadena($Ap_Materno)."', 
                                        '".$this->limpiarEspaciosCadena($Ocupacion)."', 
                                        '".$Edad."', 
                                        '".$Genero."', 
                                        '".$this->limpiarEspaciosCadena($Domicilio)."',

                                        '".$this->limpiarEspaciosCadena($Nombre_E)."',
                                        '".$this->limpiarEspaciosCadena($Ap_Paterno_E)."', 
                                        '".$this->limpiarEspaciosCadena($Ap_Materno_E)."', 
                                        '".$this->limpiarEspaciosCadena($Placa_E)."', 
                                        '".$this->limpiarEspaciosCadena($Cargo_E)."', 
                                        '".$this->limpiarEspaciosCadena($Sector_Area_E)."', 
                                        '".$this->limpiarEspaciosCadena($Unidad_E)."', 
                                        '".$Id_Usuario."',
                                        'zz'  
                                        )
                        ";
                $this->db->query($sql);
                $this->db->execute();
                $this->db->query("SELECT LAST_INSERT_ID() as Id_Dictamen"); //se recupera el id del dictamen
                $Id_Dictamen = $this->db->register()->Id_Dictamen;
                // Update no_detenido
                $sql = "UPDATE dictamen_medico_detenido SET No_Detenido = $Id_Dictamen WHERE Id_Dictamen = $Id_Dictamen";
                $this->db->query($sql);
                $this->db->execute();
                $return['success'] = true;
               //----------------fin_transaction -----------------
            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries
        }catch (Exception $err) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            $return['success'] = false;
            $return['error_message'] = $err;
        }

        return $return;
    }
    //insertar nuevo registro de dictamen o actualizar algun existente
    public function updateDictamen($post){
        try {
            $return['success'] = false;
            $return['error_message'] = '';
            //asignando checkboxes a cadena
            $Intoxicacion_Etilica = ''; $Orientacion = ''; $Sustancia_Consumida = ''; $Aliento = ''; $Lenguaje = '';
            foreach ($post['IE'] as $value) {
                $Intoxicacion_Etilica.= $value;
            }
            foreach ($post['Orient'] as $value) {
                $Orientacion.= $value;
            }
            foreach ($post['SustanciaC'] as $value) {
                $Sustancia_Consumida.= $value;
            }
            foreach ($post['Aliento_A'] as $value) {
                $Aliento.= $value;
            }
            foreach ($post['Lenguaje_Bit'] as $value) {
                $Lenguaje.= $value;
            }
            //get all fields
            $Id_Usuario     = $post['Id_Usuario'];
            $Id_Dictamen    = $post['Id_Dictamen'];
            //detenido
            $Nombre        = (isset($post['Nombre']))?$post['Nombre']:'';
            $Ap_Paterno    = (isset($post['Ap_Paterno']))?$post['Ap_Paterno']:'';
            $Ap_Materno    = (isset($post['Ap_Materno']))?$post['Ap_Materno']:'';
            $Ocupacion     = (isset($post['Ocupacion']))?$post['Ocupacion']:'';
            $Edad          = (isset($post['Edad']))?$post['Edad']:'';
            $Genero        = (isset($post['Genero']))?$post['Genero']:'';
            $Domicilio     = (isset($post['Domicilio']))?$post['Domicilio']:'';
            //elemento
            $Nombre_E        = (isset($post['Nombre_E']))?$post['Nombre_E']:'';
            $Ap_Paterno_E    = (isset($post['Ap_Paterno_E']))?$post['Ap_Paterno_E']:'';
            $Ap_Materno_E    = (isset($post['Ap_Materno_E']))?$post['Ap_Materno_E']:'';
            $Placa_E         = (isset($post['Placa_E']))?$post['Placa_E']:'';
            $Cargo_E         = (isset($post['Cargo_E']))?$post['Cargo_E']:'';
            $Sector_Area_E   = (isset($post['Sector_Area_E']))?$post['Sector_Area_E']:'';
            $Unidad_E        = (isset($post['Unidad_E']))?$post['Unidad_E']:'';

            $Fecha_Hora				= (isset($post['Fecha_Dictamen']))?$post['Fecha_Dictamen'].' ':'';
            $Fecha_Hora			   .= (isset($post['Hora_Dictamen']))?$post['Hora_Dictamen']:'';
            $Instancia 				= (isset($post['Instancia']))?$post['Instancia']:'';
            //$Observaciones_Genero	= (isset($post['Observaciones_Genero']))?$post['Observaciones_Genero']:'';
            $Enfermedades_Padece	= (isset($post['Enfermedades_Padece']))?$post['Enfermedades_Padece']:'';
            $Medicamentos_Toma		= (isset($post['Medicamentos_Toma']))?$post['Medicamentos_Toma']:'';
            $Prueba_Alcoholimetro	= (isset($post['Prueba_Alcoholimetro']))?$post['Prueba_Alcoholimetro']:'';
            $Prueba_Multitestdrog	= (isset($post['Prueba_Multitestdrog']))?$post['Prueba_Multitestdrog']:'';
            $Prueba_Clinica			= (isset($post['Prueba_Clinica']))?$post['Prueba_Clinica']:'';
            $Coopera_Interrogatorio	= (isset($post['Coopera_Interrogatorio']))?$post['Coopera_Interrogatorio']:'';
            //$Sustancia_Consumida	= (isset($post['Sustancia_Consumida']))?$post['Sustancia_Consumida']:'';
            $Fecha_Hora_Consumo = '';
            if(isset($post['Fecha_Consumo']) && isset($post['Hora_Consumo'])){ //ambos
                if($post['Fecha_Consumo'] != '' && $post['Hora_Consumo'] != ''){
                    $Fecha_Hora_Consumo = $post['Fecha_Consumo'].' '.$post['Hora_Consumo'];
                }
                else if($post['Fecha_Consumo'] != ''){
                    $Fecha_Hora_Consumo = $post['Fecha_Consumo'];
                }
                else if($post['Hora_Consumo'] != ''){
                    $Fecha_Hora_Consumo = $post['Hora_Consumo'];
                }
            }
            // $Fecha_Hora_Consumo		= (isset($post['Fecha_Consumo']) && $post['Fecha_Consumo'] != '')?$post['Fecha_Consumo'].' ':'';
            // $Fecha_Hora_Consumo    .= (isset($post['Hora_Consumo']) && $post['Hora_Consumo'] != '')?$post['Hora_Consumo']:'';

            $Cantidad_Consumida		= (isset($post['Cantidad_Consumida']))?$post['Cantidad_Consumida']:'';
            $Estado_Conciencia		= (isset($post['Estado_Conciencia']))?$post['Estado_Conciencia']:'';
            $Actitud				= (isset($post['Actitud']))?$post['Actitud']:'';
            //$Lenguaje				= (isset($post['Lenguaje']))?$post['Lenguaje']:'';
            $Fascies				= (isset($post['Fascies']))?$post['Fascies']:'';
            $Conjuntivas			= (isset($post['Conjuntivas']))?$post['Conjuntivas']:'';
            $Pupilas				= (isset($post['Pupilas']))?$post['Pupilas']:'';
            $Pupilas2                = (isset($post['Pupilas2']))?$post['Pupilas2']:'';
            $Mucosa_Oral			= (isset($post['Mucosa_Oral']))?$post['Mucosa_Oral']:'';
            //$Aliento				= (isset($post['Aliento']))?$post['Aliento']:'';
            $Heridas_Lesiones		= (isset($post['Heridas_Lesiones']))?$post['Heridas_Lesiones']:'';
            $Observaciones			= (isset($post['Observaciones']))?$post['Observaciones']:'';
            $Diagnostico			= (isset($post['Diagnostico']))?$post['Diagnostico']:'';

            //Si es nuevo registro se actualiza la fecha de Registro de lo contrario no se mueve para nada
            $condicionFechaRegistro = ($post['Nuevo'] == '1')?", Fecha_Registro_Dictamen = NOW() ":'';
            $this->db->beginTransaction(); //inicio de transaction
               //----------------begin_transaction----------------
            	$sql =	"UPDATE dictamen_medico_detenido 
                                SET Instancia              = '".$Instancia."',
                                
                                    Nombre            = '".$this->limpiarEspaciosCadena($Nombre)."',
                                    Ap_Paterno        = '".$this->limpiarEspaciosCadena($Ap_Paterno)."',
                                    Ap_Materno        = '".$this->limpiarEspaciosCadena($Ap_Materno)."',
                                    Ocupacion         = '".$this->limpiarEspaciosCadena($Ocupacion)."',
                                    Edad              = '".$Edad."',
                                    Genero            = '".$Genero."',
                                    Domicilio         = '".$this->limpiarEspaciosCadena($Domicilio)."',

                                    Nombre_E          = '".$this->limpiarEspaciosCadena($Nombre_E)."',
                                    Ap_Paterno_E      = '".$this->limpiarEspaciosCadena($Ap_Paterno_E)."',
                                    Ap_Materno_E      = '".$this->limpiarEspaciosCadena($Ap_Materno_E)."',
                                    Ocupacion         = '".$this->limpiarEspaciosCadena($Ocupacion)."',
                                    Placa_E           = '".$this->limpiarEspaciosCadena($Placa_E)."',
                                    Cargo_E           = '".$this->limpiarEspaciosCadena($Cargo_E)."',
                                    Sector_Area_E     = '".$this->limpiarEspaciosCadena($Sector_Area_E)."',
                                    Unidad_E        = '".$this->limpiarEspaciosCadena($Unidad_E)."',

                                    Fecha_Hora              = '".$Fecha_Hora."',
                                    Enfermedades_Padece     = '".$this->limpiarEspaciosCadena($Enfermedades_Padece)."',
                                    Medicamentos_Toma       = '".$this->limpiarEspaciosCadena($Medicamentos_Toma)."',
                                    Prueba_Alcoholimetro    = b'".$Prueba_Alcoholimetro."',
                                    Prueba_Multitestdrog    = b'".$Prueba_Multitestdrog."',
                                    Prueba_Clinica          = b'".$Prueba_Clinica."',
                                    Coopera_Interrogatorio  = b'".$Coopera_Interrogatorio."',
                                    Sustancia_Consumida     = b'".$Sustancia_Consumida."',
                                    Fecha_Hora_Consumo      = '".$Fecha_Hora_Consumo."',
                                    Cantidad_Consumida      = '".$Cantidad_Consumida."',
                                    Intoxicacion_Etilica    = b'".$Intoxicacion_Etilica."',
                                    Estado_Conciencia       = '".$Estado_Conciencia."',
                                    Orientacion             = b'".$Orientacion."',
                                    Actitud                 = '".$Actitud."',
                                    Lenguaje                = b'".$Lenguaje."',
                                    Fascies                 = '".$Fascies."',
                                    Conjuntivas             = '".$Conjuntivas."',
                                    Pupilas                 = '".$Pupilas."',
                                    Pupilas2                = '".$Pupilas2."',
                                    Mucosa_Oral             = '".$Mucosa_Oral."',
                                    Aliento                 = b'".$Aliento."',
                                    Heridas_Lesiones        = '".$this->limpiarEspaciosCadena($Heridas_Lesiones)."',
                                    Observaciones           = '".$this->limpiarEspaciosCadena($Observaciones)."',
                                    Diagnostico             = '".$Diagnostico."', 
                                    Id_Usuario              = '".$Id_Usuario."' 
                                    ".$condicionFechaRegistro."
                                WHERE Id_Dictamen = ".$Id_Dictamen."
                               ";
            	$this->db->query($sql);
                $this->db->execute();
                $return['success'] = true;
               //----------------fin_transaction -----------------
            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries
        }catch (Exception $err) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            $return['success'] = false;
            $return['error_message'] = $err;
        }

        return $return;
    }
    //insertar nuevo registro llamado desde Juridico
    public function crearDictamenFromJuridico($post){
        try {
            $return['success'] = false;
            $return['error_message'] = '';
            
            //num detenido Formato (IPH_123412445)
            $No_Detenido        = (isset($post['No_Detenido']))?$post['No_Detenido']:'';
            //detenido
            $Nombre        = (isset($post['Nombre']))?$post['Nombre']:'';
            $Ap_Paterno    = (isset($post['Ap_Paterno']))?$post['Ap_Paterno']:'';
            $Ap_Materno    = (isset($post['Ap_Materno']))?$post['Ap_Materno']:'';
            $Ocupacion     = (isset($post['Ocupacion']))?$post['Ocupacion']:'';
            $Edad          = (isset($post['Edad']))?$post['Edad']:'';
            $Genero        = (isset($post['Genero']))?$post['Genero']:'';
            $Domicilio     = (isset($post['Domicilio']))?$post['Domicilio']:'';
            //elemento
            $Nombre_E        = (isset($post['Nombre_E']))?$post['Nombre_E']:'';
            $Ap_Paterno_E    = (isset($post['Ap_Paterno_E']))?$post['Ap_Paterno_E']:'';
            $Ap_Materno_E    = (isset($post['Ap_Materno_E']))?$post['Ap_Materno_E']:'';
            $Placa_E         = (isset($post['Placa_E']))?$post['Placa_E']:'';
            $Cargo_E         = (isset($post['Cargo_E']))?$post['Cargo_E']:'';
            $Sector_Area_E   = (isset($post['Sector_Area_E']))?$post['Sector_Area_E']:'';
            $Unidad_E        = (isset($post['Unidad_E']))?$post['Unidad_E']:'';

            $this->db->beginTransaction(); //inicio de transaction
               //----------------begin_transaction----------------
                $sql = "
                        INSERT INTO dictamen_medico_detenido (  Tipo_Dictamen,
                                                                No_Detenido,
                                                                Nombre,
                                                                Ap_Paterno,
                                                                Ap_Materno,
                                                                Ocupacion,
                                                                Edad,
                                                                Genero,
                                                                Domicilio,
                                                                Nombre_E,
                                                                Ap_Paterno_E,
                                                                Ap_Materno_E,
                                                                Placa_E,
                                                                Cargo_E,
                                                                Sector_Area_E,
                                                                Unidad_E,
                                                                Id_Usuario)
                                VALUES( 
                                        b'0', 
                                        '".$No_Detenido."', 
                                        '".$this->limpiarEspaciosCadena($Nombre)."', 
                                        '".$this->limpiarEspaciosCadena($Ap_Paterno)."', 
                                        '".$this->limpiarEspaciosCadena($Ap_Materno)."', 
                                        '".$this->limpiarEspaciosCadena($Ocupacion)."', 
                                        '".$Edad."', 
                                        '".$Genero."', 
                                        '".$this->limpiarEspaciosCadena($Domicilio)."', 

                                        '".$this->limpiarEspaciosCadena($Nombre_E)."', 
                                        '".$this->limpiarEspaciosCadena($Ap_Paterno_E)."', 
                                        '".$this->limpiarEspaciosCadena($Ap_Materno_E)."', 
                                        '".$this->limpiarEspaciosCadena($Placa_E)."', 
                                        '".$this->limpiarEspaciosCadena($Cargo_E)."', 
                                        '".$this->limpiarEspaciosCadena($Sector_Area_E)."', 
                                        '".$this->limpiarEspaciosCadena($Unidad_E)."', 
                                        1  
                                        )
                        ";
            	$this->db->query($sql);
                $this->db->execute();
                $return['success'] = true;
               //----------------fin_transaction -----------------
            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries
        }catch (Exception $err) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            $return['success'] = false;
            $return['error_message'] = $err;
        }
        return $return;
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
        	case '1':	//todos
        		
        		$from_where_sentence.= " FROM dictamen_view 
        								 WHERE 	(	Id_Dictamen LIKE '%".$cadena."%' OR 
        								 			Nombre_Completo_Detenido LIKE '%".$cadena."%' OR 
											        Nombre_Medico LIKE '%".$cadena."%' OR 
                                                    Nombre_Completo_Elemento LIKE '%".$cadena."%' OR
                                                    Instancia LIKE '%".$cadena."%' OR
                                                    Ocupacion LIKE '%".$cadena."%' OR   
                                                     Enfermedades_Padece LIKE '%".$cadena."%' OR 
											        Medicamentos_Toma LIKE '%".$cadena."%' OR 
											        Diagnostico LIKE '%".$cadena."%' OR 
											        Estado_Conciencia LIKE '%".$cadena."%' OR 
											        Actitud LIKE '%".$cadena."%' ) 
				        					";
				
        	break;
            case '2':   //pendientes
                
                $from_where_sentence.= " FROM dictamen_view 
                                         WHERE  (   Id_Dictamen LIKE '%".$cadena."%' OR 
                                                    Nombre_Completo_Detenido LIKE '%".$cadena."%' OR 
                                                    Nombre_Medico LIKE '%".$cadena."%' OR 
                                                    Nombre_Completo_Elemento LIKE '%".$cadena."%' OR
                                                    Instancia LIKE '%".$cadena."%' OR
                                                    Ocupacion LIKE '%".$cadena."%' OR   
                                                    Enfermedades_Padece LIKE '%".$cadena."%' OR 
                                                    Medicamentos_Toma LIKE '%".$cadena."%' OR 
                                                    Diagnostico LIKE '%".$cadena."%' OR 
                                                    Estado_Conciencia LIKE '%".$cadena."%' OR 
                                                    Actitud LIKE '%".$cadena."%' ) AND 
                                                    Diagnostico <=> NULL 
                                            ";
                
            break;
            case '3':   //completados
                
                $from_where_sentence.= " FROM dictamen_view 
                                         WHERE  (   Id_Dictamen LIKE '%".$cadena."%' OR 
                                                    Nombre_Completo_Detenido LIKE '%".$cadena."%' OR 
                                                    Nombre_Medico LIKE '%".$cadena."%' OR 
                                                    Nombre_Completo_Elemento LIKE '%".$cadena."%' OR
                                                    Instancia LIKE '%".$cadena."%' OR
                                                    Ocupacion LIKE '%".$cadena."%' OR   
                                                    Enfermedades_Padece LIKE '%".$cadena."%' OR 
                                                    Medicamentos_Toma LIKE '%".$cadena."%' OR 
                                                    Diagnostico LIKE '%".$cadena."%' OR 
                                                    Estado_Conciencia LIKE '%".$cadena."%' OR 
                                                    Actitud LIKE '%".$cadena."%' ) AND 
                                                    Diagnostico <> '' 
                                            ";
                
            break;
            case '4':   //otros
                
                $from_where_sentence.= " FROM dictamen_view 
                                         WHERE (   Id_Dictamen LIKE '%".$cadena."%' OR 
                                                    Nombre_Completo_Detenido LIKE '%".$cadena."%' OR 
                                                    Enfermedades_Padece LIKE '%".$cadena."%' OR 
                                                    Medicamentos_Toma LIKE '%".$cadena."%' OR 
                                                    Diagnostico LIKE '%".$cadena."%' OR 
                                                    Estado_Conciencia LIKE '%".$cadena."%' OR 
                                                    Actitud LIKE '%".$cadena."%' ) AND 
                                                    Tipo_Dictamen = 1 
                                            ";
                
            break;

                /*
                    SELECT * FROM evento_delictivo_view WHERE Fecha >= '2020-01-01' AND Fecha <= '2020-03-30'
        		*/
        }

        //where complemento fechas (si existe)
        $from_where_sentence.= $this->getFechaCondition();
        //order by
		$from_where_sentence.= " ORDER BY Id_Dictamen DESC";   
        return $from_where_sentence;
    }

    public function getDictamenDByCadena($cadena,$filtro='1'){
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
    public function getAllInfoDictamenDByCadena($from_where_sentence = ""){
    	$sqlAux = "SELECT *"
    				.$from_where_sentence."
                    ";  //query a la DB
        $this->db->query($sqlAux);          //se prepara el query mediante PDO
        return $this->db->registers();      //retorna todos los registros devueltos por la consulta
    }

    //función auxiliar para filtrar por un rango de fechas específicado por el usuario
    public function getFechaCondition(){
        $cad_fechas = "";
        if (isset($_SESSION['userdata']->rango_inicio_dm) && 
            isset($_SESSION['userdata']->rango_fin_dm) && 
            isset($_SESSION['userdata']->rango_hora_inicio_dm) && 
            isset($_SESSION['userdata']->rango_hora_fin_dm)) { //si no ingresa una fecha se seleciona el día de hoy como máximo

            $rango_inicio = $_SESSION['userdata']->rango_inicio_dm;
            $rango_fin = $_SESSION['userdata']->rango_fin_dm;
            $rango_hora_inicio = $_SESSION['userdata']->rango_hora_inicio_dm;
            $rango_hora_fin = $_SESSION['userdata']->rango_hora_fin_dm;

            $cad_fechas = " AND 
                            Fecha_Hora >= '".$rango_inicio." ".$rango_hora_inicio.":00'  AND 
                            Fecha_Hora <= '".$rango_fin." ".$rango_hora_fin.":59' 
                            ";
        }

        return $cad_fechas;
    }

    private function limpiarEspaciosCadena($cadena = null){
        if($cadena == null) return '';
        return implode(' ',array_filter(explode(' ',$cadena)));
    }
}

?>