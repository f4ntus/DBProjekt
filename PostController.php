<?php
    require 'SqlWrapper.php';
    class PostController {
        private $sqlWrapper;
        public function __construct()
        {
            $this->sqlWrapper = new SqlWrapper();
        }
        public function controllAnmeldung($post){
            $benutzername = $post["benutzername"];
            $kennwort = $post["kennwort"];
            // hier kommt eine Gültigkeitsprüfung rein 

           return $this->sqlWrapper->insertIntoBefrager($benutzername,$kennwort);

        }
        public function __destruct()
        {
            $this->sqlWrapper = NULL;
        }
    }
?>