<?php
class Detenidos extends Controller
{

    public function __construct(){
    }

    public function index()
    {

        if (!isset($_SESSION['userdata'])) {
            header("Location: ".base_url."Inicio");
            exit();
        }

        $data = [
            'titulo'    => 'Sistema de remisiones | Detenidos',
        ];


        $this->view('templates/header', $data);
        $this->view('system/remisiones/detenidos/indexView', $data);
        $this->view('templates/footer', $data);
    }
}