<?php 

class BuscarPoliciaGuardia extends Controller{

    public function __construct(){
        
    }

    public function index()
    {
        //comprobar los permisos para dejar pasar al módulo
        if (!isset($_SESSION['userdata']) || ($_SESSION['userdata']->Modo_Admin != 1 && $_SESSION['userdata']->Remisiones[2] != '1')) {
            header("Location: " . base_url . "Inicio");
            exit();
        }

        $buscar_2 = strtr($_POST['ctrl_2'], " ", "%20");


        /*   Condicion para buscar policia de guardia por numero de control   */
        if (isset($_POST['getDataElement_2']) && isset($buscar_2) && is_numeric($buscar_2) && strlen($buscar_2)>=6){
            
            /*
            $ct = 0;
            $valid[$ct++] = $data_p['ctrlError']         =  $this->FV->validate($_POST, 'ctrl', '');

            $success = true;
            foreach ($valid as $val)
                $success &= ($val == '') ? true : false;
            */

            $success = true;


            $arrContextOptions=array(
                "ssl"=>array(
                    'method'=>"GET",
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ),
            );

            if($success){
                $data_p['status'] = 'success';
                $data = json_decode(file_get_contents("https://172.18.0.28/swebremisiones/?user=paco&pass=iv10998sdryt&control=".$buscar_2, true,stream_context_create($arrContextOptions)));
                $data_p['res'] = $data;
            }else{
                $data_p['status'] = 'failed';
            }

            echo json_encode($data_p);

            //print_r($data_p);
        }

        /*   Condicion para buscar policia de guardia por numero de placa   */
        else if(isset($_POST['getDataElement_2']) && isset($buscar_2) && is_numeric($buscar_2) && strlen($buscar_2)<=4)

        {

            /*
            $ct = 0;
            $valid[$ct++] = $data_p['ctrlError']         =  $this->FV->validate($_POST, 'ctrl', '');

            $success = true;
            foreach ($valid as $val)
                $success &= ($val == '') ? true : false;
            */

            $success = true;

            $arrContextOptions=array(
                "ssl"=>array(
                    'method'=>"GET",
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ),
            );

            if($success){
                $data_p['status'] = 'success';
                $data = json_decode(file_get_contents("https://172.18.0.28/swebremisiones/?user=paco&pass=iv10998sdryt&placa=".$buscar_2, true,stream_context_create($arrContextOptions)));
                $data_p['res'] = $data;
            }else{
                $data_p['status'] = 'failed';
            }

            echo json_encode($data_p);

            //print_r($data_p);
        }

        /*   Condicion para buscar policia de guardia por nombre, un solo apellido, por apellido paterno y materno o por nombre completo   */
        else if(isset($_POST['getDataElement_2']) && isset($buscar_2) && !is_numeric($buscar_2))
        {

            $success = true;


            $arrContextOptions=array(
                "ssl"=>array(
                    'method'=>"GET",
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ),
            );

            if($success){
                $data_p['status'] = 'success';
                $data = json_decode(file_get_contents("https://172.18.0.28/swebremisiones/?user=paco&pass=iv10998sdryt&nombre=".$buscar_2, true,stream_context_create($arrContextOptions)));
                $data_p['res'] = $data;
            }else{
                $data_p['status'] = 'failed';
            }

            echo json_encode($data_p);

            //print_r($data_p);
        }

        else
        {
            echo "No existe";
        }
    }

}
 ?>
