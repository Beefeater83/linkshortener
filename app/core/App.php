<?php
    class App {
        protected $controller = 'Home';
        protected $method = 'index';
        protected $params = [];

        public function __construct() {
           $url = $this->parseUrl();

           if($url && file_exists('app/controllers/' . ucfirst($url[0]) . '.php')) {
               $this->controller = ucfirst($url[0]);
               unset($url[0]); 
           }

           require_once 'app/controllers/' . $this->controller . '.php';
            $this->controller = new $this->controller; 
            if(isset($url[1])) { 
                if (method_exists($this->controller, $url[1])) { 
                    $this->method = $url[1];
                    unset($url[1]); 
                }
            }
            $this->params = $url ? array_values($url) : []; 
            call_user_func_array([$this->controller, $this->method], $this->params);
        }

        public function parseUrl() {
            if(isset($_GET['url'])) {
                return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_STRING));
            }
        }
    }