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

        public function select() {
             $q = $this->db->query("SELECT * FROM tbl_fragebogen");
             echo "<table><tr><th>FragebogenNr</th><th>Titel</th>";
            
            while($row = $q->fetch_assoc()) { 
                echo "<tr>";
                echo "<td>" . $row['FbNr'] . "</td>";
                echo "<td>" . $row['Titel'] . "</td>";
                echo "</tr>";
            } 
            echo "</table>";
            
            }



        public function __destruct()
        {
            $this->db->close();
        }

    }
?>