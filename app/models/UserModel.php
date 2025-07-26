<?php
    require_once 'DB.php';

    class UserModel {        
        private $email;
        private $name;
        private $pass;              

        private $_db = null;

        public function __construct(){
            $this->_db = DB::getInstance();
        }

        public function setData($email, $name,  $pass) {
            $this->email = $email;
            $this->name = $name;            
            $this->pass = $pass;                  
        }

        public function validForm() {
            if (strlen($this->email) < 3)
                return "Email надто короткий";
            else if(strlen($this->name) < 3)
                return "Логін надто короткий";
            else if($this->checkLoginInDB($this->name))
                return "Такий логін вже існує";            
            else if(strlen($this->pass) < 3)
                return "Пароль не менше 3 символів";           
            else
                return "Вірно";
        }

        public function addUser() {
            $sql = 'INSERT INTO users(name, email, pass) VALUES(:name, :email, :pass)';
            $query = $this->_db->prepare($sql);

            $pass = password_hash($this->pass, PASSWORD_DEFAULT);
            $query->execute(['name' => $this->name, 'email' => $this->email, 'pass' => $pass]);

            $this->setAuth($this->name);
        }
       
        public function getUser(){
            if (isset($_COOKIE['login'])) {
                $name = $_COOKIE['login'];
                $sql = 'SELECT * FROM users WHERE name = :name';
                $query = $this->_db->prepare($sql);
                $query->execute(['name' => $name]);
                return $query->fetch(PDO::FETCH_ASSOC);
            } else 
                return false;             
        }
        
        public function logOut() {
            setcookie('login', $this->name, time() - 3600, "/");
            unset($_COOKIE['login']);
            header('Location: /user/auth');
        }

        public function auth($name, $pass){
            $sql = 'SELECT * FROM users WHERE name = :name';
            $query = $this->_db->prepare($sql);
            $query->execute(['name' => $name]);
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if(!isset($user['name']))
              return "Такого користувача не існує";
            else if(password_verify($pass, $user['pass'])){
              $this->setAuth($name);
            }              
            else
              return "Пароль не співпадає";
        }

        public function setAuth($name){
            setcookie('login', $name, [
                'expires' => time() + 3600,
                'path' => '/',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
            header('Location: /user');
        } 
        
        public function checkLoginInDB($login){
            $sql = 'SELECT * FROM users WHERE name = :login';
            $query = $this->_db->prepare($sql);
            $query->execute(['login' => $login]);
            $user = $query->fetch(PDO::FETCH_ASSOC);
            return $user !== false;
        }
         

    }