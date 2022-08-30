<?php
class ManualUsuario extends Controller
{


	public function index()
    {

        if (!isset($_SESSION['userdata'])) {
            header("Location: ".base_url."Login");
            exit();
        }

        $data = [
            'titulo'    => 'Planeación | Manual de usuario',
            'extra_css' => '<link rel="stylesheet" href="' . base_url . 'public/css/system/manual/index.css">',
        ];
        
        $this->view('templates/header', $data);
        $this->view('system/manualUsuario/manualUsuarioView', $data);
        $this->view('templates/footer', $data);
        
    }

}

?>