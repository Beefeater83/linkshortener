<?php
  require 'app/util/Csrf.php';
  class Home extends Controller {

      public function index() {
        Csrf::generate();
        $data=[];   
        $data['user_links'] = [];  
        $data['csrf_token'] = $_SESSION['csrf_token'];   
        $links = $this->model('LinksModel');        

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          if (!Csrf::verify($_POST['csrf_token'])) {
            die('Помилка CSRF захисту');
          }
          if (!empty($_POST['longurl']) && !empty($_POST['shorturl'])) {
            if($links->verifyShortLink($_POST['shorturl'])){
              $links->setData($_POST['longurl'], $_POST['shorturl']);
              $links->addLinks(); 
              $_POST['longurl'] = $_POST['shorturl'] = '';
              header('Location: /');
              exit();
            } else
             $data['error'] = "Така коротка назва вже є в базі";

          } else 
              $data['error'] = "Заповніть обидва поля";          
        }

        $currentUserId = $links->getUserId();        
        $data['user_links'] = $links->getLinks($currentUserId);

        if(isset($_COOKIE['login']))          
          $this->view('home/index', $data);
        else
          $this->view('user/reg', $data);
    }
    
    public function deleteLink(){
      if (!Csrf::verify($_POST['csrf_token'])) {
        die('Помилка CSRF захисту');
      }
      $links = $this->model('LinksModel');
      $linkId = $_POST['link_id'];
      $links->deleteLink($linkId);
      header('Location: /');
      exit();
    }
}