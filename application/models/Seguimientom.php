<?php

class Seguimientom{

    public $db; //variable para instanciar el objeto PDO
    public function __construct(){
        $this->db = new Base(); //se instancia el objeto con los métodos de PDO
    }

    public function getSegByIdSP($id_sp){
        if ($id_sp != null) {
            $sql = " SELECT *
                        FROM seguimiento_persona
                        LEFT JOIN domicilio ON domicilio.Id_Domicilio = seguimiento_persona.Id_Domicilio
                        LEFT JOIN imagen_seguimiento_persona ON imagen_seguimiento_persona.Id_Seguimiento_P = seguimiento_persona.Id_Seguimiento_P
                        WHERE seguimiento_persona.Id_Seguimiento_P = $id_sp
                        ";
            $this->db->query($sql);
            return $this->db->register();
        }
        else return false;
    }

    public function getSegByIdSV($id_sv){
        if ($id_sv != null) {
                    $sql = " SELECT * FROM seguimiento_vehiculo
                        LEFT JOIN imagen_seguimiento_vehiculo ON imagen_seguimiento_vehiculo.Id_Seguimiento_V = seguimiento_vehiculo.Id_Seguimiento_V
                        WHERE  seguimiento_vehiculo.Id_Seguimiento_V = $id_sv
                        ";
            $this->db->query($sql);
            return $this->db->register();
        }
        else return false;
    }

    public function getImgSegById($id_sp = null){
        if ($id_sp != null) {
            $sql = "
                    SELECT  *
                    FROM seguimiento_persona
                    LEFT JOIN imagen_seguimiento_persona ON imagen_seguimiento_persona.Id_Seguimiento_P = seguimiento_persona.Id_Seguimiento_P
                    WHERE seguimiento_persona.Id_Seguimiento_P = $id_sp
                    ";
            $this->db->query($sql);
            return $this->db->register();
        }
        else return false;
    }

    public function getAllSPByCadena($where_sentence = ""){   //funcion creada para obtener los registros de los usuarios
        $sqlAux = "SELECT *
                    FROM seguimiento_persona".$where_sentence."
                    ";  //query a la DB
        $this->db->query($sqlAux);          //se prepara el query mediante PDO
        return $this->db->registers();      //retorna todos los registros devueltos por la consulta
    }

    public function getAllSVByCadena($where_sentence2 = ""){   //funcion creada para obtener los registros de los usuarios
        $sqlAux = "SELECT *
                    FROM seguimiento_vehiculo".$where_sentence2."
                    ";  //query a la DB
        $this->db->query($sqlAux);          //se prepara el query mediante PDO
        return $this->db->registers();      //retorna todos los registros devueltos por la consulta
    }

    //esta funcion retorna tanto el número total de paginas para los links como el total de registros contados conforme a la busqueda
    public function getTotalPagesSP($no_of_records_per_page,$where_sentence = ""){ 
        $sql_total_pages = "SELECT COUNT(*) as Num_Pages FROM seguimiento_persona ".$where_sentence; //total registros
        $this->db->query($sql_total_pages);      //prepararando query
        $total_rows = $this->db->register()->Num_Pages; //ejecutando query y recuperando el valor obtenido
        $total_pages = ceil($total_rows / $no_of_records_per_page); //calculando el total de paginations

        $data['total_rows'] = $total_rows;
        $data['total_pages'] = $total_pages;
        return $data;
    }

    public function getTotalPagesSV($no_of_records_per_page2,$where_sentence2 = ""){ 
        $sql_total_pages = "SELECT COUNT(*) as Num_Pages FROM seguimiento_vehiculo".$where_sentence2; //total registros
        $this->db->query($sql_total_pages);      //prepararando query
        $total_rows2 = $this->db->register()->Num_Pages; //ejecutando query y recuperando el valor obtenido
        $total_pages2 = ceil($total_rows2 / $no_of_records_per_page2); //calculando el total de paginations

        $data['total_rows2'] = $total_rows2;
        $data['total_pages2'] = $total_pages2;
        return $data;
    }

    public function getDataCurrentPageSP($offset,$no_of_records_per_page,$where_sentence = ""){

            $sql = "
                    SELECT * 
                    FROM seguimiento_persona ".$where_sentence." 
                    LIMIT $offset,$no_of_records_per_page
                    ";

            $this->db->query($sql);
            return $this->db->registers();
        }

    public function getDataCurrentPageSV($offset2,$no_of_records_per_page2,$where_sentence2 = ""){

            $sql = "
                    SELECT * 
                    FROM seguimiento_vehiculo ".$where_sentence2." 
                    LIMIT $offset2,$no_of_records_per_page2
                    ";

            $this->db->query($sql);
            return $this->db->registers();
    }

    public function getSPByCadena($cadena,$filtro='1'){

        //CONSULTA COINCIDENCIAS DE CADENA PARA EVENTOS DELICTIVOS
        if (!is_numeric($filtro) || !($filtro>=MIN_FILTRO_ED) || !($filtro<=MAX_FILTRO_ED))
            $filtro = 1;
        //CONSULTA A LA VIEW DE LA DB
        //sentencia where para hacer la busqueda por la cadena ingresada
        $where_sentence = $this->generateWhereSentenceSP($cadena,$filtro);
        $numPage = 1;
        $no_of_records_per_page = NUM_MAX_REG_PAGE; //total de registros por pagination
        $offset = ($numPage-1) * $no_of_records_per_page; // desplazamiento conforme a la pagina

        $results = $this->getTotalPagesSP($no_of_records_per_page,$where_sentence);  //total de páginas conforme a la busqueda
        //info de retorno para la creacion de los links conforme a la cadena ingresada
        $data['seguimient'] = $this->getDataCurrentPageSP($offset,$no_of_records_per_page,$where_sentence);   //se obtiene la información de la página actual
        $data['numPage'] = $numPage; //numero pag actual para la pagination footer
        $data['total_pages'] = $results['total_pages']; //total pages para la pagination
        $data['total_rows'] = $results['total_rows'];   //total de registro hallados
        
        return $data;
    }

    public function getSVByCadena($cadena2,$filtro2='1'){

        //CONSULTA COINCIDENCIAS DE CADENA PARA EVENTOS DELICTIVOS
        if (!is_numeric($filtro2) || !($filtro2>=MIN_FILTRO_ED) || !($filtro2<=MAX_FILTRO_ED))
            $filtro2 = 1;
        //CONSULTA A LA VIEW DE LA DB
        //sentencia where para hacer la busqueda por la cadena ingresada
        $where_sentence2 = $this->generateWhereSentenceSV($cadena2,$filtro2);
        $numPage2 = 1;
        $no_of_records_per_page2 = NUM_MAX_REG_PAGE; //total de registros por pagination
        $offset2 = ($numPage2-1) * $no_of_records_per_page2; // desplazamiento conforme a la pagina

        $results2 = $this->getTotalPagesSV($no_of_records_per_page2,$where_sentence2);  //total de páginas conforme a la busqueda
        //info de retorno para la creacion de los links conforme a la cadena ingresada
        $data['seguimient2'] = $this->getDataCurrentPageSV($offset2,$no_of_records_per_page2,$where_sentence2);   //se obtiene la información de la página actual
        $data['numPage2'] = $numPage2; //numero pag actual para la pagination footer
        $data['total_pages2'] = $results2['total_pages2']; //total pages para la pagination
        $data['total_rows2'] = $results2['total_rows2'];   //total de registro hallados
        
        return $data;
    }

    public function insertNewSP($post){
        $band=true;
        $id_seguimiento_p;
        $id_domicilio_sp;
        
        try {  
            $this->db->beginTransaction(); //inicio de transaction

                    $sql = "
                                INSERT INTO seguimiento_persona (Folio_911,Folio_Infra,Celula_Seguimiento,Nombre1,Nombre2,Nombre3,Ap_Paterno,Ap_Materno,Otros_Nombres_Falsos,Alias,Fecha_Nacimiento,Edad,Lugar_Origen,Telefono,Ocupacion,Link_Red_Social,Nombre_Familiar,Parentezco,Vinculo_Grupo_Banda,Modus_Operandi,CDI,Violencia,Tipo_Violencia,Delito_Vinculado,Especificacion_Delito,Areas_Operacion,Areas_Resguardo)
                    VALUES  ('".$post['spnofolio911']."', 
                                        '".$post['spfolioinfra']."',
                                        '".$post['spcelulas']."',
                                        '".$post['spnombre1']."',
                                        '".$post['spnombre2']."',
                                        '".$post['spnombre3']."',
                                        '".$post['spappater']."',
                                        '".$post['spapmater']."',
                                        '".$post['spotrosnomf']."',
                                        '".$post['spalias']."',
                                        '".$post['spfechand']."',
                                        '".$post['spedad']."',
                                        '".$post['splugaro']."',
                                        '".$post['sptel']."',
                                        '".$post['spocupacion']."',
                                        '".$post['spredsocial']."',
                                        '".$post['spnombrefamc']."',
                                        '".$post['spparentezco']."',
                                        '".$post['spvinculodel']."',
                                        '".$post['spmodusoperandi']."',
                                        '".$post['spnumcdi']."',
                                        b'".$post['spviolencia']."',
                                        '".$post['sptipov']."',
                                        '".$post['spdv']."',
                                        '".$post['spespdd']."',
                                        '".$post['sppado']."',
                                        '".$post['sppadr']."'
                                         )
                                ";
                    $this->db->query($sql);
                    $this->db->execute();
                    $this->db->query("SELECT LAST_INSERT_ID() AS Id_Seguimiento_P");
                    $id_seguimiento_p = $this->db->register()->Id_Seguimiento_P;

                    if($id_seguimiento_p != null && ($post['spdomicilio_colonia'] != null || $post['spdomicilio_calle']!=null || $post['spdomicilio_numext']!=null || $post['spdomicilio_numint']!=null || $post['spdomicilio_cp']!=null)) 
                    {
                        $sql = "
                                INSERT INTO domicilio(Id_Municipio,Colonia,Calle,No_Exterior,No_Interior,CP)
                    VALUES  ('1714', 
                                        '".$post['spdomicilio_colonia']."',
                                        '".$post['spdomicilio_calle']."',
                                        '".$post['spdomicilio_numext']."',
                                        '".$post['spdomicilio_numint']."',
                                        '".$post['spdomicilio_cp']."'
                                         )
                                ";
                    $this->db->query($sql);
                    $this->db->execute();
                    $this->db->query("SELECT LAST_INSERT_ID() AS Id_Domicilio");
                    $id_domicilio_sp = $this->db->register()->Id_Domicilio;

                    if($id_domicilio_sp != null) 
                    {
                        $sql = " UPDATE seguimiento_persona
                                SET Id_Domicilio = '".$id_domicilio_sp."'
                                WHERE Id_Seguimiento_P = $id_seguimiento_p
                                ";
                        $this->db->query($sql);
                        $this->db->execute();
                    }


                    }
                    
                    if($id_seguimiento_p && ($_FILES['sppdfcdi']['name'] != null))
                    {
                        $nameFile = $id_seguimiento_p.".pdf";
                        $sql = " UPDATE seguimiento_persona
                                SET Path_CDI = '".$nameFile."'
                                WHERE Id_Seguimiento_P = $id_seguimiento_p
                                ";
                        $this->db->query($sql);
                        $this->db->execute();
                    }
                    
                
            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries
          
        }catch (Exception $e) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            echo "Fallo en DB: " . $e->getMessage();
            $band=false;
        }
        

        return $id_seguimiento_p;
    }

    public function getSeguimientoP($id_seguimiento_persona)
    {
        $band = true;

        try {
                $this->db->beginTransaction();

                $sql = " SELECT *
                        FROM seguimiento_persona
                        LEFT JOIN domicilio ON domicilio.Id_Domicilio = seguimiento_persona.Id_Domicilio
                        WHERE seguimiento_persona.Id_Seguimiento_P = $id_seguimiento_persona
                        ";

                $this->db->query($sql);
                $data['seguimiento_persona'] = $this->db->registers();
                $this->db->execute();

                $sql = "SELECT * FROM imagen_seguimiento_persona WHERE Id_Seguimiento_P = ". $id_seguimiento_persona;
                $this->db->query($sql);
                $data['images'] = $this->db->registers();
                $this->db->execute();

                $sql = "SELECT * FROM vehiculo_rel_seg WHERE Id_Seguimiento_P = ". $id_seguimiento_persona;
                $this->db->query($sql);
                $data['vehiculos'] = $this->db->registers();
                $this->db->execute();

                $sql = "SELECT * FROM senia_seg_per WHERE Id_Seguimiento_P = ". $id_seguimiento_persona;
                $this->db->query($sql);
                $data['senas'] = $this->db->registers();
                $this->db->execute();

                $this->db->commit();
        } catch (Exception $e) {
            echo "Sucedio un error " . $e;
            $band = false;
            $this->db->rollBack();
        }

        return $data;
    }

    public function updateSeguimientoP($post,$id_seguimiento_persona,$sp_violencia,$id_domicilio){

        $band = true;
        $date = date("Ymdhis");
        try {
                $this->db->beginTransaction();
                $sql = " UPDATE seguimiento_persona 
                                        SET Folio_911 = '".$post['spnofolio911']."',
                                            Folio_Infra = '".$post['spfolioinfra']."',
                                            Celula_Seguimiento = '".$post['spcelulas']."',
                                            Nombre1 = '".$post['spnombre1']."',
                                            Nombre2 = '".$post['spnombre2']."',
                                            Nombre3 = '".$post['spnombre3']."',
                                            Ap_Paterno = '".$post['spappater']."',
                                            Ap_Materno = '".$post['spapmater']."',
                                            Otros_Nombres_Falsos = '".$post['spotrosnomf']."',
                                            Alias =  '".$post['spalias']."',
                                            Fecha_Nacimiento = '".$post['spfechand']."',
                                            Edad = '".$post['spedad']."',
                                            Lugar_Origen = '".$post['splugaro']."',
                                            Telefono = '".$post['sptel']."',
                                            Ocupacion = '".$post['spocupacion']."',
                                            Link_Red_Social = '".$post['spredsocial']."',
                                            Nombre_Familiar = '".$post['spnombrefamc']."',
                                            Parentezco = '".$post['spparentezco']."',
                                            Vinculo_Grupo_Banda = '".$post['spvinculodel']."',
                                            Modus_Operandi = '".$post['spmodusoperandi']."',
                                            CDI = '".$post['spnumcdi']."',
                                            CDI = '".$post['spnumcdi']."',
                                            Violencia = b'".$sp_violencia."',
                                            Tipo_Violencia = '".$post['sptipov']."',
                                            Delito_Vinculado = '".$post['spdv']."',
                                            Especificacion_Delito = '".$post['spespdd']."',
                                            Areas_Operacion = '".$post['sppado']."',
                                            Areas_Resguardo = '".$post['sppadr']."'
                                        WHERE Id_Seguimiento_P = ".$id_seguimiento_persona."
                                        ";
                $this->db->query($sql);
                $this->db->execute();

                if($id_domicilio!='') 
                {
                    if($post['spdomicilio_calle']!=null || $post['spdomicilio_colonia']!=null || $post['spdomicilio_numint']!=null || $post['spdomicilio_numext']!=null ||$post['spdomicilio_cp']!=null)
                    {
                        $sql = " UPDATE domicilio
                                SET Colonia = '".$post['spdomicilio_colonia']."',
                                    Calle = '".$post['spdomicilio_calle']."',
                                    No_Exterior = '".$post['spdomicilio_numext']."',
                                    No_Interior = '".$post['spdomicilio_numint']."',
                                    CP = '".$post['spdomicilio_cp']."'
                                WHERE Id_Domicilio = $id_domicilio
                                ";
                        $this->db->query($sql);
                        $this->db->execute();                    
                    }
                }

                else
                {
                    if($post['spdomicilio_calle']!=null || $post['spdomicilio_colonia']!=null || $post['spdomicilio_numint']!=null || $post['spdomicilio_numext']!=null ||$post['spdomicilio_cp']!=null)
                    {
                        $sql = " INSERT INTO domicilio(Id_Municipio,Colonia,Calle,No_Exterior,No_Interior,CP)
                                VALUES('1714', 
                                    '".$post['spdomicilio_colonia']."',
                                    '".$post['spdomicilio_calle']."',
                                    '".$post['spdomicilio_numext']."',
                                    '".$post['spdomicilio_numint']."',
                                    '".$post['spdomicilio_cp']."')
                                ";
                        $this->db->query($sql);
                        $this->db->execute();
                        $this->db->query("SELECT LAST_INSERT_ID() AS Id_Domicilio");
                        $id_domicilio_sp = $this->db->register()->Id_Domicilio;

                        if($id_domicilio_sp != null) 
                        {
                            $sql = "UPDATE seguimiento_persona
                                    SET Id_Domicilio = '".$id_domicilio_sp."'
                                    WHERE Id_Seguimiento_P = $id_seguimiento_persona
                                    ";
                            $this->db->query($sql);
                            $this->db->execute();
                        }                    
                    }
                }

                    
                if($id_seguimiento_persona && ($_FILES['sppdfcdi']['name'] != null))
                {
                    $nameFile = $id_seguimiento_persona.".pdf";
                    $sql = " UPDATE seguimiento_persona
                            SET Path_CDI = '".$nameFile."'
                            WHERE Id_Seguimiento_P = $id_seguimiento_persona
                            ";
                    $this->db->query($sql);
                    $this->db->execute();
                }

                $sql = "DELETE FROM imagen_seguimiento_persona WHERE Id_Seguimiento_P = " . $id_seguimiento_persona;
                $this->db->query($sql);
                $this->db->execute();

                $images = json_decode($post['captura_imagenes']);
                foreach ($images as $image) {
                    $name = '';
                    if ($image->row->tipo == 'File') {
                        $type = $_FILES[$image->row->name]['type'];
                        $extension = explode("/",$type);
                        $name = $image->row->name.'.'.$extension[1];
                    } else {
                        $name = $image->row->name;
                    }

                    $sql = " INSERT
                            INTO imagen_seguimiento_persona(
                                Id_Seguimiento_P,
                                Path_Imagen
                            )
                            VALUES(
                                $id_seguimiento_persona,
                                '" . $name . "'
                            )
                    ";
                    $this->db->query($sql);
                    $this->db->execute();
                }

                $sql = "DELETE FROM vehiculo_rel_seg WHERE Id_Seguimiento_P = " . $id_seguimiento_persona;
                $this->db->query($sql);
                $this->db->execute();

                $vehiculos = json_decode($post['table_vehiculos']);
                foreach ($vehiculos as $vehiculo) {
                    $sql = " INSERT
                            INTO vehiculo_rel_seg(
                                Id_Seguimiento_P,
                                Marca,
                                Modelo,
                                Color,
                                Placas
                            )
                            VALUES(
                                $id_seguimiento_persona,
                                '" . $vehiculo->row->marca . "',
                                '" . $vehiculo->row->modelo . "',
                                '" . $vehiculo->row->color . "',
                                '" . $vehiculo->row->placa . "'
                            )
                    ";
                    $this->db->query($sql);
                    $this->db->execute();
                }

                $sql = "DELETE FROM senia_seg_per WHERE Id_Seguimiento_P = " . $id_seguimiento_persona;
                $this->db->query($sql);
                $this->db->execute();

                $senas = json_decode($post['senas_table']);
                foreach ($senas as $sena) {

                    $name = '';
                    if($sena->row->typeImage == 'null'){
                        $name = '';
                    }else{
                        if ($sena->row->typeImage == 'File') {
                            $type = $_FILES[$sena->row->nameImage]['type'];
                            $extension = explode("/", $type);
                            $name = $sena->row->nameImage . "." . $extension[1] . "?v=" . $date;
                        }
                        if ($sena->row->typeImage == 'Photo'){
                            $image_parts = explode(";base64,", $sena->row->image);
                            $image_type_aux = explode("image/", $image_parts[0]);
                            $image_type = $image_type_aux[1];
                            $name = $sena->row->nameImage.'.'.$image_type;
                        }
                    }

                    $sql = " INSERT
                            INTO senia_seg_per(
                                Id_Seguimiento_P,
                                Tipo_Senia_Particular,
                                Perfil,
                                Ubicacion_Corporal,
                                Color,
                                Clasificacion,
                                Descripcion,
                                Path_Imagen
                            )
                            VALUES(
                                $id_seguimiento_persona,
                                '" . $sena->row->tipo . "',
                                '" . $sena->row->perfil . "',
                                '" . $sena->row->partes . "',
                                b'" . $sena->row->color . "',
                                '" . $sena->row->clasificacion . "',
                                '" . $sena->row->descripcion . "',
                                '" . $name . "'
                            )
                    ";
                    $this->db->query($sql);
                    $this->db->execute();
                }

                $this->db->commit();
        } catch (Exception $e) {
            echo "Sucedio un error " . $e;
            $band = false;
            $this->db->rollBack();
        }
        return $band;
    }

    public function insertFotosSP($id_seguimiento_p,$name)
    {
        $band = true;
        try {

            if ($name != '') {
                $this->db->beginTransaction();
                $sql = " INSERT INTO imagen_seguimiento_persona(Id_Seguimiento_P,Path_Imagen)
                        VALUES('".$id_seguimiento_p."','".$name. "')
                        ";
                $this->db->query($sql);
                $this->db->execute();
                $this->db->commit();
            }
                    
        } catch (Exception $e) {
            echo "Sucedio un error " . $e;
            $band = false;
            $this->db->rollBack();
        }

        return $band;
    }

    public function insertVehiculosSP($id_seguimiento_p,$marca,$modelo,$color,$placa)
    {
        $band = true;
        try {
            $this->db->beginTransaction();

                $sql = " INSERT INTO vehiculo_rel_seg(Id_Seguimiento_P,Marca,Modelo,Color,Placas)
                        VALUES('".$id_seguimiento_p."','".$marca."','".$modelo."','".$color."','".$placa."')
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

    public function insertSeniasSP($id_seguimiento_p,$perfil,$partes,$tipo,$color,$clasificacion,$descripcion,$nameImage)
    {
        $band = true;
        try {
            $this->db->beginTransaction();

                $sql = " INSERT INTO senia_seg_per(Id_Seguimiento_P,Tipo_Senia_Particular,Perfil,Ubicacion_Corporal,Color,Clasificacion,Descripcion,Path_Imagen)
                        VALUES('".$id_seguimiento_p."','".$tipo."','".$perfil."','".$partes."','".$color."','".$clasificacion."','".$descripcion."','".$nameImage."')
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

    public function insertNewSV($post)
    {
        $band=true;
        $id_seguimiento_v;
        
        try {  
            $this->db->beginTransaction(); //inicio de transaction

                    $sql= "
                            INSERT INTO seguimiento_vehiculo(Folio_911,Folio_Infra,Celula_Seguimiento,Marca,Modelo,Color,Placas,Caracteristicas,Delito_Involucrado,CDI,Obra_Placa,Modus_Operandi,Areas_Operacion,Areas_Resguardo,Vinculacion_Banda_Persona)
                                VALUES  ('".$post['svnofolio911']."', 
                                        '".$post['svfolioinfra']."',
                                        '".$post['svcelulas']."',
                                        '".$post['svmarca']."',
                                        '".$post['svmodelo']."',
                                        '".$post['svcolor']."',
                                        '".$post['svplaca']."',
                                        '".$post['svcesp']."',
                                        '".$post['svdv']."',
                                        '".$post['svnumcdi']."',
                                        b'".$post['svobrap']."',
                                        '".$post['svmodusoperandi']."',
                                        '".$post['svpado']."',
                                        '".$post['svpadr']."',
                                        '".$post['svvinculodel']."')
                                        ";
                    $this->db->query($sql);
                    $this->db->execute();
                    $this->db->query("SELECT LAST_INSERT_ID() AS Id_Seguimiento_V");
                    $id_seguimiento_v = $this->db->register()->Id_Seguimiento_V;
                    
                    if($id_seguimiento_v && ($_FILES['svpdfcdi']['name'] != null))
                    {
                        $nameFile = $id_seguimiento_v.".pdf";
                        $sql = " UPDATE seguimiento_vehiculo
                                SET Path_CDI = '".$nameFile."'
                                WHERE Id_Seguimiento_V = $id_seguimiento_v
                                ";
                        $this->db->query($sql);
                        $this->db->execute();
                    }
                    
            $this->db->commit();  //si todo sale bien, la transaction realiza commit de los queries
          
        }catch (Exception $e) {
            $this->db->rollBack();    //si algo falla realiza el rollBack por seguridad
            echo "Fallo en DB: " . $e->getMessage();
            $band=false;
        }

        return $id_seguimiento_v;
    }

    public function insertFotosSV($id_seguimiento_v,$name)
    {
        $band = true;
        try {
            $this->db->beginTransaction();

            $sql = "SELECT * FROM imagen_seguimiento_vehiculo WHERE Id_Seguimiento_V = ".$id_seguimiento_v;
            $this->db->query($sql);
            
            if($this->db->registers()){
                $sql = "DELETE FROM imagen_seguimiento_vehiculo WHERE Id_Seguimiento_V = ".$id_seguimiento_v;
                $this->db->query($sql);
                $this->db->execute();
            }

            $sql = " INSERT INTO imagen_seguimiento_vehiculo(Id_Seguimiento_V,Path_Imagen)
                    VALUES('".$id_seguimiento_v."','".$name. "')
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

    public function getSeguimientoV($id_seguimiento_vehiculo)
    {
        $band = true;

        try {
                $this->db->beginTransaction();
                $sql = " SELECT * FROM seguimiento_vehiculo
                        LEFT JOIN imagen_seguimiento_vehiculo ON imagen_seguimiento_vehiculo.Id_Seguimiento_V = seguimiento_vehiculo.Id_Seguimiento_V
                        WHERE  seguimiento_vehiculo.Id_Seguimiento_V = $id_seguimiento_vehiculo
                        ";
                $this->db->query($sql);
                $data['seguimiento_vehiculo'] = $this->db->registers();
                $this->db->execute();
                
                $sql = "SELECT * FROM imagen_seguimiento_vehiculo WHERE Id_Seguimiento_V = ".$id_seguimiento_vehiculo;
                $this->db->query($sql);
                $data['images'] = $this->db->registers();
                $this->db->execute();
                
                $this->db->commit();
        } catch (Exception $e) {
            echo "Sucedio un error " . $e;
            $band = false;
            $this->db->rollBack();
        }

        return $data;
        
    }

    public function updateSeguimientoV($post,$id_seguimiento_vehiculo,$sv_obrap)
    {
        $band = true;
        try {
            $this->db->beginTransaction();
            $sql = " UPDATE seguimiento_vehiculo 
                                    SET Folio_911 = '".$post['svnofolio911']."',
                                        Folio_Infra = '".$post['svfolioinfra']."',
                                        Celula_Seguimiento = '".$post['svcelulas']."',
                                        Placas = '".$post['svplaca']."',
                                        Marca = '".$post['svmarca']."',
                                        Modelo = '".$post['svmodelo']."',
                                        Color = '".$post['svcolor']."',
                                        Caracteristicas = '".$post['svcesp']."',
                                        Delito_Involucrado = '".$post['svdv']."',
                                        Areas_Operacion =  '".$post['svpado']."',
                                        CDI = '".$post['svnumcdi']."',
                                        Obra_Placa = b'".$sv_obrap."',
                                        Areas_Resguardo = '".$post['svpadr']."',
                                        Vinculacion_Banda_Persona = '".$post['svvinculodel']."',
                                        Modus_Operandi = '".$post['svmodusoperandi']."'
                                    WHERE Id_Seguimiento_V = ".$id_seguimiento_vehiculo."
                                    ";
            $this->db->query($sql);
            $this->db->execute();
                
            if($id_seguimiento_vehiculo && ($_FILES['svpdfcdi']['name'] != null))
            {
                $nameFile = $id_seguimiento_vehiculo.".pdf";
                $sql = " UPDATE seguimiento_vehiculo
                        SET Path_CDI = '".$nameFile."'
                        WHERE Id_Seguimiento_V = $id_seguimiento_vehiculo
                        ";
                $this->db->query($sql);
                $this->db->execute();
            }

            $sql = "DELETE FROM imagen_seguimiento_vehiculo WHERE Id_Seguimiento_V = " . $id_seguimiento_vehiculo;
            $this->db->query($sql);
            $this->db->execute();

            $images = json_decode($post['captura_imagenes']);
            foreach ($images as $image) {
                $name = '';
                if ($image->row->tipo == 'File') {
                    $type = $_FILES[$image->row->name]['type'];
                    $extension = explode("/",$type);
                    $name = $image->row->name.'.'.$extension[1];
                } else {
                    $name = $image->row->name;
                }

                $sql = " INSERT
                        INTO imagen_seguimiento_vehiculo(
                            Id_Seguimiento_V,
                            Path_Imagen
                        )
                        VALUES(
                            $id_seguimiento_vehiculo,
                            '" . $name . "'
                        )
                ";
                $this->db->query($sql);
                $this->db->execute();
            }

            $this->db->commit();
        } catch (Exception $e) {
            echo "Sucedio un error " . $e;
            $band = false;
            $this->db->rollBack();
        }
        return $band;
    }

    public function generateWhereSentenceSP($cadena,$filtro='1'){
        $where_sentence = "";

        switch ($filtro) {
            case '1':   //general
            $where_sentence = "
                                LEFT JOIN domicilio ON domicilio.Id_Domicilio = seguimiento_persona.Id_Domicilio
                        WHERE   (seguimiento_persona.Folio_911 LIKE '%".$cadena."%' OR
                                seguimiento_persona.Folio_Infra LIKE '%".$cadena."%' OR
                                seguimiento_persona.Celula_Seguimiento LIKE '%".$cadena."%'  OR
                                seguimiento_persona.Nombre1 LIKE '%".$cadena."%' OR
                                seguimiento_persona.Nombre2 LIKE '%".$cadena."%' OR
                                seguimiento_persona.Nombre3 LIKE '%".$cadena."%' OR
                                seguimiento_persona.Ap_Paterno LIKE '%".$cadena."%' OR
                                seguimiento_persona.Ap_Materno LIKE '%".$cadena."%' OR
                                seguimiento_persona.Edad LIKE '%".$cadena."%'  OR
                                seguimiento_persona.Lugar_Origen LIKE '%".$cadena."%' OR
                                seguimiento_persona.Vinculo_Grupo_Banda LIKE '%".$cadena."%' OR
                                seguimiento_persona.Modus_Operandi LIKE '%".$cadena."%' OR
                                seguimiento_persona.Tipo_Violencia LIKE '%".$cadena."%' OR
                                seguimiento_persona.Areas_Operacion LIKE '%".$cadena."%' OR
                                seguimiento_persona.Alias LIKE '%".$cadena."%' OR
                                domicilio.Calle LIKE '%".$cadena."%' OR
                                domicilio.Colonia LIKE '%".$cadena."%' OR
                                domicilio.CP LIKE '%".$cadena."%' OR
                                domicilio.No_Interior LIKE '%".$cadena."%' OR
                                domicilio.No_Exterior LIKE '%".$cadena."%'
                                )
                        ";
        break;

        }
        //where complemento fechas (si existe)
        $where_sentence.= $this->getFechaConditionSP();
        //order by
        $where_sentence.= " ORDER BY Id_Seguimiento_P DESC";  
        
        return $where_sentence;
    }

    public function generateWhereSentenceSV($cadena2,$filtro2='1'){
        $where_sentence2 = "";

        switch ($filtro2) {
            case '1':   //general
            $where_sentence2 = "
                        WHERE   (Folio_911 LIKE '%".$cadena2."%' OR
                                Folio_Infra LIKE '%".$cadena2."%' OR
                                Celula_Seguimiento LIKE '%".$cadena2."%'  OR
                                Marca LIKE '%".$cadena2."%' OR
                                Modelo LIKE '%".$cadena2."%' OR
                                Color LIKE '%".$cadena2."%' OR
                                Placas LIKE '%".$cadena2."%' OR
                                CDI LIKE '%".$cadena2."%' OR
                                Areas_Operacion LIKE '%".$cadena2."%' OR
                                Areas_Resguardo LIKE '%".$cadena2."%' OR
                                Vinculacion_Banda_Persona LIKE '%".$cadena2."%')  
                        ";
        break;

        }
        //where complemento fechas (si existe)
        $where_sentence2.= $this->getFechaConditionSV();
        //order by
        $where_sentence2.= " ORDER BY Id_Seguimiento_V DESC";  
        
        return $where_sentence2;
    }

    //Funcionn que inserta los movimientos de los usuarios en la tabla historial
    public function historial($user,$ip,$movimiento,$descripcion)
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
                        $user,
                        '".$ip."',
                        '".$movimiento."',
                        '".$descripcion."'
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

    //función auxiliar para filtrar por un rango de fechas específicado por el usuario
    public function getFechaConditionSP(){
        $cad_fechas = "";
        if (isset($_SESSION['userdata']->rango_inicio_sp) && isset($_SESSION['userdata']->rango_fin_sp)) { //si no ingresa una fecha se seleciona el día de hoy como máximo
            $rango_inicio = $_SESSION['userdata']->rango_inicio_sp;
            $rango_fin = $_SESSION['userdata']->rango_fin_sp;
            $cad_fechas = " AND 
                            Fecha_Registro_SP >= '".$rango_inicio." 00:00:00'  AND
                            Fecha_Registro_SP <= '".$rango_fin." 23:59:59' 
                            ";
        }

        return $cad_fechas; 
    }


    //función auxiliar para filtrar por un rango de fechas específicado por el usuario
    public function getFechaConditionSV(){
        $cad_fechas = "";
        if (isset($_SESSION['userdata']->rango_inicio_sv) && isset($_SESSION['userdata']->rango_fin_sv)) { //si no ingresa una fecha se seleciona el día de hoy como máximo
            $rango_inicio = $_SESSION['userdata']->rango_inicio_sv;
            $rango_fin = $_SESSION['userdata']->rango_fin_sv;
            $cad_fechas = " AND 
                            Fecha_Registro_SV >= '".$rango_inicio." 00:00:00'  AND
                            Fecha_Registro_SV <= '".$rango_fin." 23:59:59' 
                            ";
        }

        return $cad_fechas; 
    }
}

?>