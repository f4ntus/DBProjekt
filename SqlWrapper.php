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


        /*public function student($Matrikelnummer) {
                $abfrage = "SELECT tbl_student.Name FROM tbl_student, tbl_kurs where tbl_student.Matrikelnummer = '$Matrikelnummer'";
                $check = $this->db->query($abfrage);
                $row = $check->fetch_assoc();
                    if($row) {
                        header('location: MenuStudent.php');
                    }
                    else {
                        echo "Matrikelnummer nicht gefunden"; 
                    }
        }

        */
      

      
    
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
            



            public function selectFreigeschaltet($kurs) {
                $sql = "SELECT tbl_fragebogen.FbNr, tbl_fragebogen.Titel FROM tbl_fragebogen, tbl_freigeschaltet 
                where tbl_fragebogen.FbNr = tbl_freigeschaltet.FbNr and tbl_freigeschaltet.Name = '$kurs'";
                return $this->db->query($sql);
                                                                       
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

               public function student($Matrikelnummer) {
                $abfrage = "SELECT tbl_student.Name FROM tbl_student, tbl_kurs where tbl_student.Matrikelnummer = '$Matrikelnummer'";
                $check = $this->db->query($abfrage);
                $row = $check->fetch_assoc();
                    if($row) {
                        if($row['Name'] == 'WWI118'){
                            echo $this->select118();
                        }
                        if($row['Name'] == 'WWI218'){
                            echo $this->select218();
                        }
                        if($row['Name'] == 'WWI318'){
                            echo $this->select318();
                        }
                    }       
                    else {
                        echo "Matrikelnummer nicht gefunden"; 
                    }
                }   
            
               


        public function selectFromBefrager($benutzername){
            $sql = "SELECT * FROM tbl_befrager WHERE Benutzername = '$benutzername'";
            $result = $this->db->query($sql);
            return $result->fetch_object(); // es kann davon ausgegangen werden, dass nur ein Datensatz zurück kommt
            // da matrikelnummer der Primärschlüssel ist.
        }

        public function selectFromStudent($matrikelnummer){
            $sql = "SELECT * FROM tbl_student WHERE Matrikelnummer = '$matrikelnummer'";
            $result = $this->db->query($sql);
            return $result->fetch_object(); // es kann davon ausgegangen werden, dass nur ein Datensatz zurück kommt
            // da matrikelnummer der Primärschlüssel ist.
        }

        public function selectFreigeschaltet($kurs) {
            $sql = "SELECT tbl_fragebogen.FbNr, tbl_fragebogen.Titel FROM tbl_fragebogen, tbl_freigeschaltet 
            where tbl_fragebogen.FbNr = tbl_freigeschaltet.FbNr and tbl_freigeschaltet.Name = '$kurs'";
            return $this->db->query($sql);
                                                                   
        }

        
        public function __destruct()
        {
            $this->db->close();
        }

    }
?>