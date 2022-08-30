<?php
     class WebService extends Controller{
        public $Usuario;    //variable para instanciar el modelo de Usuario
        public $FV;
        public function __construct(){
            $this->Usuario = $this->model('Usuario');   //se instancia model Usuario y ya puede ser ocupado en el controlador
            $this->FV = new FormValidator();
        }

        //busca respuesta de usuario y password
        public function searchUserPassword(){
            $response = ['success' => false];

            $k = 0;
            //set rules | validando la información del formulario
            $valid[$k++] = $this->FV->validate($_POST,'User_Name'    ,'required|min_length[2]');
            $valid[$k++] = $this->FV->validate($_POST,'Password'     ,'required|min_length[2]');

            $formValid = true;
            foreach ($valid as $val)
                $formValid &= ($val=='')?true:false;
            
            if($formValid) { //trata de hacer login
                $success = $this->Usuario->loginUser($_POST);

                if ($success) {
                    $response['success'] = true;
                }
            }
            echo json_encode($response);
        }

        // inicia sesión con las credenciales
        public function loginFetch(){
            $response = ['success' => false];
            if (isset($_SESSION['userdata'])) { //se cierra la sesión que este activa
                unset($_SESSION['userdata']);
            }

            $k = 0;
            //set rules | validando la información del formulario
            $valid[$k++] = $this->FV->validate($_POST,'User_Name'    ,'required|min_length[2]');
            $valid[$k++] = $this->FV->validate($_POST,'Password'     ,'required|min_length[2]');

          
            $formValid = true;
            foreach ($valid as $val)
                $formValid &= ($val=='')?true:false;
            
            if($formValid) { //trata de hacer login
                $success = $this->Usuario->loginUser($_POST);

                if ($success) {
                    $_SESSION['userdata'] = $success;
                    $response['success'] = true;
                }
            }
            echo json_encode($response);
        }
     }