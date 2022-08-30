<?php

class BuscarPolicia extends Controller{

    public function __construct(){
        
    }

    public function index()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata'])) {
            $data_p['status'] = false;
            $data_p['error_message'] = 'Render Index';

            echo json_encode($data_p);
        }else{

            $buscar = "";
            
            if(isset($_POST['ctrl'])){
                $buscar = strtr($_POST['ctrl'], " ", "%20");
            }else if(isset($_POST['input-search-element'])){
                $buscar = strtr($_POST['input-search-element'], " ", "%20");
            }


            /*   Condicion para buscar un elemeto de policia por numero de control   */
            if (isset($buscar) && is_numeric($buscar) && strlen($buscar)>=6){

                $arrContextOptions=array(
                    "ssl"=>array(
                        'method'=>"GET",
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ),
                );

                $data = json_decode(file_get_contents("https://172.18.0.28/swebremisiones/?user=paco&pass=iv10998sdryt&control=".$buscar, true,stream_context_create($arrContextOptions)));
                if($data == null){
                    $data_p['status'] = false;
                    $data_p['error_message'] = 'No se encontraron registros';
                }else{
                    $data_p['status'] = true;
                    $data_p['res'] = $data;
                }
                $data_p['apartado'] = 'control';
                
                echo json_encode($data_p);

            }
            
            /*   Condicion para buscar un elemeto de policia por numero de placa   */
            else if(isset($buscar) && is_numeric($buscar) && strlen($buscar)<=4)
            {
                
                $arrContextOptions=array(
                    "ssl"=>array(
                        'method'=>"GET",
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ),
                );
                
                $data = json_decode(file_get_contents("https://172.18.0.28/swebremisiones/?user=paco&pass=iv10998sdryt&placa=".$buscar, true,stream_context_create($arrContextOptions)));
                if($data == null){
                    $data_p['status'] = false;
                    $data_p['error_message'] = 'No se encontraron registros';
                }else{
                    $data_p['status'] = true;
                    $data_p['res'] = $data;
                }
                $data_p['apartado'] = 'placa';
                
                echo json_encode($data_p);
                
            }

            /*   Condicion para buscar un elemeto de policia por nombre, un solo apellido, por apellido paterno y materno o por nombre completo   */
            else if(isset($buscar) && !is_numeric($buscar))
            {
                
                $arrContextOptions=array(
                    "ssl"=>array(
                        'method'=>"GET",
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ),
                );
                
                $data = json_decode(file_get_contents("https://172.18.0.28/swebremisiones/?user=paco&pass=iv10998sdryt&nombre=".$buscar, true,stream_context_create($arrContextOptions)));
                if($data == null){
                    $data_p['status'] = false;
                    $data_p['error_message'] = 'No se encontraron registros';
                }else{
                    $data_p['status'] = true;
                    $data_p['res'] = $data;
                }
                $data_p['apartado'] = 'nombre';
                
                echo json_encode($data_p);
                
            }else{
                $data_p['status'] = false;
                $data_p['error_message'] = 'Sucedio un error';
            }
        }
    }
}
?>