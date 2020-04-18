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


        public function student($Matrikelnummer) {
                $abfrage = "SELECT tbl_kurs.Name FROM tbl_student, tbl_kurs where tbl_student.Matrikelnummer = '$Matrikelnummer'";
                $ergebnis = $this->db->query($abfrage);
                echo $ergebnis;
                
                    
                
            }  


        /*public function select() {
             $q = $this->db->query("SELECT * FROM tbl_fragebogen");
             echo "<table border='8' cellpadding='20'><tr><th>FragebogenNr</th><th>Titel</th>";
            
            while($row = $q->fetch_assoc()) { 
                echo "<tr>";    
                echo "<td>" . $row['FbNr'] . "</td>";
                echo "<td>" . $row['Titel'] . "</td>";
                echo "</tr>";
            } 
            echo "</table>";
            
            }
        */
            
            public function select118() {
                $q = $this->db->query("SELECT tbl_fragebogen.FbNr, tbl_fragebogen.Titel FROM tbl_fragebogen, tbl_freigeschaltet 
                                        where tbl_fragebogen.FbNr = tbl_freigeschaltet.FbNr and tbl_freigeschaltet.Name = 'WWI118'");
                                                         
                echo "<table border='8' cellpadding='20'><tr><th>FragebogenNr</th><th>Titel</th>";
               
               while($row = $q->fetch_assoc()) { 
                   echo "<tr>";
                   echo "<td>" . $row['FbNr'] . "</td>";
                   echo "<td>" . $row['Titel'] . "</td>";
                   echo "</tr>";
               } 
               echo "</table>";
               
               }

               public function select218() {
                $q = $this->db->query("SELECT tbl_fragebogen.FbNr, tbl_fragebogen.Titel FROM tbl_fragebogen, tbl_freigeschaltet 
                                        where tbl_fragebogen.FbNr = tbl_freigeschaltet.FbNr and tbl_freigeschaltet.Name = 'WWI218'");
                                                         
                echo "<table border='8' cellpadding='20'><tr><th>FragebogenNr</th><th>Titel</th>";
               
               while($row = $q->fetch_assoc()) { 
                   echo "<tr>";
                   echo "<td>" . $row['FbNr'] . "</td>";
                   echo "<td>" . $row['Titel'] . "</td>";
                   echo "</tr>";
               } 
               echo "</table>";
               
               }

               public function select318() {
                $q = $this->db->query("SELECT tbl_fragebogen.FbNr, tbl_fragebogen.Titel FROM tbl_fragebogen, tbl_freigeschaltet 
                                        where tbl_fragebogen.FbNr = tbl_freigeschaltet.FbNr and tbl_freigeschaltet.Name = 'WWI318'");
                                                         
                echo "<table border='8' cellpadding='20'><tr><th>FragebogenNr</th><th>Titel</th>";
               
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