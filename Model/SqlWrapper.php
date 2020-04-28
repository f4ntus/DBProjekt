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

        public function selectFreigeschaltet($kurs) {
                $sql = "SELECT tbl_fragebogen.FbNr, tbl_fragebogen.Titel FROM tbl_fragebogen, tbl_freigeschaltet 
                where tbl_fragebogen.FbNr = tbl_freigeschaltet.FbNr and tbl_freigeschaltet.Name = '$kurs'";
                return $this->db->query($sql);
                                                                       
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

        

        /* @Author: Chris
        Hier stehen alle relevanten Funktionen für die Datenbankabfragen durch den Befrager, im Hauptmenü.*/
        public function selectErstellteFrageboegen($recentUser) {
            $sql = "SELECT * FROM tbl_fragebogen WHERE Benutzername = '$recentUser'";
              return $this->db->query($sql);
            }

        public function insertIntoFragebogen($titel, $benutzername){
            $sql = "INSERT INTO tbl_fragebogen (Titel, Benutzername) VALUES ('$titel', '$benutzername')";

            if ($this->db->query($sql)) {
                return 'success';
            } else {
                return $this->db->error;
                
            }
        }

        public function insertIntoFrage($fnr, $fbnr, $fragetext){
            $sql = "INSERT INTO tbl_frage (FNr, FbNr, Fragetext) VALUES ('$fnr', $fbnr', '$fragetext')";

            if ($this->db->query($sql)) {
                return 'success';
            } else {
                return $this->db->error;
                
            }
        }

        public function selectFbNrFragebogen($titel){
            $sql = "SELECT FbNr FROM tbl_fragebogen WHERE FbNr ='$titel'";
            $result = $this->db->query($sql);
            return $result->fetch_object();
        }

        public function selectAlleTitel($titel) {
            $sql = "SELECT Titel FROM tbl_fragebogen WHERE Titel = '$titel'";
            
            $result = $this->db->query($sql);
            return $result->fetch_object();
        }


        public function limit($fbnr) {

            //Anzahl Fragen zu FragebogenNr
            $sql = "SELECT * FROM tbl_frage where FbNr = '$fbnr'";
            $result = $this->db->query($sql);
            $anzahl = $result->num_rows;
    
            $ergebnisse_pro_Seite = 1;
           
    
            //Aktuelle Seite
           if (empty($_GET['seite_nr'])) {
            $seite= 1;
            } else {
                $seite = $_GET['seite_nr'];
            if ($seite > $anzahl) {
                $seite = 1;
            }
            }
            $limit = ($seite* $ergebnisse_pro_Seite)-$ergebnisse_pro_Seite;
            
            $result = $this->db->query("SELECT * FROM tbl_frage where FbNr = '$fbnr' LIMIT ".$limit.', '.$ergebnisse_pro_Seite);
            $string = '';
            while ($row = $result->fetch_object()) {
                
            echo $string = $string . "<table border='8' cellpadding='20'>'<tr><td>" . $row->Fragetext . '</td><td>' . $row->FbNr . '</td></tr></table>';    
            }
           
            for ($i=1; $i<=$anzahl; ++$i) {
                if ($seite == $i) {
                    echo '<a href="Fragen.php?seite_nr='.$i.'" style="font-weight: bold;">'.$i.'</a>';
                } else {
                    echo '<a href="Fragen.php?seite_nr='.$i.'">'.$i.'</a>';
                }
            }
    
            
        }
        public function __destruct()
        {
            $this->db->close();
        }

    }
?>