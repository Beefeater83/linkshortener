<?php
   require 'app/util/Csrf.php';
    class User extends Controller {

        public function index(){
            $user = $this->model('UserModel');
            if(isset($_POST['exit_btn'])){
                $user->logOut();
                exit();
            }
            return $this->view('user/index', $user->getUser());
        }


        public function reg() {           
            Csrf::generate();
            if(isset($_POST['name'])){               
                if (!Csrf::verify($_POST['csrf_token'])) {
                    die('Помилка CSRF захисту');
                }
                $user = $this->model("UserModel");
                $user->setData( $_POST['email'], $_POST['name'], $_POST['pass']);
                $isValid = $user->validForm();
                if($isValid == "Вірно")
                    $user->addUser();
                else
                    $_POST['data'] = $isValid;
            }
            return $this->view('user/reg', ['csrf_token' => $_SESSION['csrf_token']]);
        }
       
        
        public function auth() {
            Csrf::generate();
          
            if(isset($_POST['name'])){
                if (!Csrf::verify($_POST['csrf_token'])) {
                    die('Помилка CSRF захисту');
                }                
                $user = $this->model('UserModel');
                $_POST['data'] = $user->auth($_POST['name'], $_POST['pass']);
            }
            return $this->view('user/auth', ['csrf_token' => $_SESSION['csrf_token']]);
        }
    }

