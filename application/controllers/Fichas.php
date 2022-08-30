<?php
class Fichas extends Controller
{

    public function __construct(){
    }

    public function index()
    {

        if (!isset($_SESSION['userdata'])) {
            header("Location: ".base_url."Inicio");
        }

        $data = [
            'titulo'    => 'Sistema de remisiones | Fichas',
        ];


        $this->view('templates/header', $data);
        $this->view('system/fichas/fichasView', $data);
        $this->view('templates/footer', $data);
    }
}