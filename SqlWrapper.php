<?php
    class SqlWrapper{
        const DBHOST = "localhost";
        const DBUSER = "root";
        const DBPASSWORD = "";
        const DATABASE = "befragungstool";
        private $db;
        
        public function __construct()
        {
            $this->db = new MySQLi(self::DBHOST, self::DBUSER, self::DBPASSWORD, self::DATABASE);
        }

        public function insertIntoBefrager($benutzername,$kennwort){
            $sql = "INSERT INTO tbl_befrager (Benutzername, Kennwort) VALUES ('$benutzername', '$kennwort')";

            if ($this->db->query($sql)) {
                return 'success';
            } else {
                return $this->db->error;
                
            }
        }

        public function selectAlleFrageboegen()
            $sql = "SELECT * FROM tbl_fragebogen";

            if ($this->db->query($sql)) {
                return 'success';
            } else {
                return 'Sie haben noch keinen Fragebogene erstellt.';
                
            }
        }

        public function __destruct()
        {
            $this->db->close();
        }

    }
?>