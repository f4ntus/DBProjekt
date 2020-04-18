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
        public function anzeigenFrageboegen() {
            return $this->sqlWrapper->selectAlleFrageboegen();
        } 
        
        public function getAnzahlFragen($post){
            $anzFragen = $post["anzahlFragen"];

            return $anzFragen;
        }

        public function createFrageFelder ($anzFragen) {
            for ($i = 1; $i <= $anzFragen; $i++) {
                echo $i . " ";
                echo "<input type='text'>";
                echo "</br></br>";
            }
        }

        public function __destruct()
        {
            $this->sqlWrapper = NULL;
        }
    }
?>