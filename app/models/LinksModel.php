<?php
   require 'DB.php';
   require 'UserModel.php';

   class LinksModel {
        private $long_url;
        private $short_url;
        private $user_id;              

        private $_db = null;

        public function __construct(){
            $this->_db = DB::getInstance();
        }

        public function setData($long_url, $short_url) {
            $this->long_url = $long_url;
            $this->short_url = "localhost/".$short_url;
            $this->user_id = $this->getUserId();                
        }

        public function getUserId() {
            $user = new UserModel();
            $userData = $user->getUser();
            if (is_array($userData) && isset($userData['id'])) 
                return $userData['id']; 
            else 
                return null;            
        }

        public function verifyShortLink($shortLink){
            $link = "localhost/".$shortLink;
            $sql = "SELECT * FROM links WHERE short_url = ?";
            $query = $this->_db->prepare($sql);
            $query->execute([$link]);
            return count($query->fetchAll(PDO::FETCH_ASSOC)) > 0 ? false : true;
        }

        public function addLinks() {
            $sql = 'INSERT INTO links(long_url, short_url, user_id) VALUES(:long_url, :short_url, :user_id)';
            $query = $this->_db->prepare($sql);
            
            $query->execute(['long_url' => $this->long_url, 'short_url' => $this->short_url, 'user_id' => $this->user_id]);           
        }

        public function getLinks($userId){
            $sql = "SELECT * FROM links WHERE user_id = ? ORDER BY id DESC";
            $query = $this->_db->prepare($sql);
            $query->execute([$userId]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function deleteLink($linkId){
            $sql = "DELETE FROM links WHERE id = :id";  
            $query = $this->_db->prepare($sql);
            $query->execute(['id' => $linkId]);           
        }


   }