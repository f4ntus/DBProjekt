<?php
class SqlWrapper
{
    const DBHOST = "localhost";
    const DBUSER = "root";
    const DBPASSWORD = "";
    const DATABASE = "befragungstool";
    private $db;

    public function __construct()
    {
        $this->db = new MySQLi(self::DBHOST, self::DBUSER, self::DBPASSWORD, self::DATABASE);
    }

    public function insertIntoBefrager($benutzername, $kennwort)
    {
        $sql = "INSERT INTO tbl_befrager (Benutzername, Kennwort) VALUES ('$benutzername', '$kennwort')";

        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
    }

    public function selectFreigeschaltet($kurs)
    {
        $sql = "SELECT tbl_fragebogen.FbNr, tbl_fragebogen.Titel FROM tbl_fragebogen, tbl_freigeschaltet 
                where tbl_fragebogen.FbNr = tbl_freigeschaltet.FbNr and tbl_freigeschaltet.Name = '$kurs'";
        return $this->db->query($sql);
    }


    public function selectFromBefrager($benutzername)
    {
        $sql = "SELECT * FROM tbl_befrager WHERE Benutzername = '$benutzername'";
        $result = $this->db->query($sql);
        return $result->fetch_object(); // es kann davon ausgegangen werden, dass nur ein Datensatz zurück kommt
        // da matrikelnummer der Primärschlüssel ist.
    }

    public function selectFromStudent($matrikelnummer)
    {
        $sql = "SELECT * FROM tbl_student WHERE Matrikelnummer = '$matrikelnummer'";
        $result = $this->db->query($sql);
        return $result->fetch_object(); // es kann davon ausgegangen werden, dass nur ein Datensatz zurück kommt
        // da matrikelnummer der Primärschlüssel ist.
    }



    /* @Author: Chris
        Hier stehen alle relevanten Funktionen für die Datenbankabfragen durch den Befrager, im Hauptmenü.*/
    public function selectErstellteFrageboegen($recentUser)
    {
        $sql = "SELECT * FROM tbl_fragebogen WHERE Benutzername = '$recentUser'";
        return $this->db->query($sql);
    }

    public  function insertIntoFragebogen($titel, $benutzername)
    {
        $sql = "INSERT INTO tbl_fragebogen (Titel, Benutzername) VALUES ('$titel', '$benutzername')";

        if ($this->db->query($sql)) {
            return $this->db->insert_id;
        } else {
            return 'error';
        }
    }

    public function insertIntoFrage($fnr, $fbnr, $fragetext)
    {
        $sql = "INSERT INTO tbl_frage (FNr, FbNr, Fragetext) VALUES ('$fnr', '$fbnr', '$fragetext')";
        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
    }

    public function selectFbNrFragebogen($titel)
    {
        $sql = "SELECT FbNr FROM tbl_fragebogen WHERE Titel ='$titel'";
        $result = $this->db->query($sql);
        return $result->fetch_object();
    }

    public function selectAlleTitel($titel)
    {
        $sql = "SELECT Titel FROM tbl_fragebogen WHERE Titel = '$titel'";

        $result = $this->db->query($sql);
        return $result->fetch_object();
    }

    public function selectKurse()
    {
        $sql = "SELECT * FROM tbl_kurs";

        return $result = $this->db->query($sql);
        
    }
    public function selectBereitsFreigeschaltet($fbnr){
        $sql = "SELECT Name FROM tbl_freigeschaltet WHERE FbNr = '$fbnr'";
        return $this->db->query($sql);

    }

    public function insertIntoFreigeschaltet($fbnr, $kurs)
    {
        $sql = "INSERT INTO tbl_freigeschaltet (FbNr, Name) VALUES ('$fbnr', '$kurs')";
        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
    }

    public function selectFragetextFromFragen($fbnr)
    {
        $sql = "SELECT Fragetext FROM tbl_frage WHERE FbNr = '$fbnr'";

        return $this->db->query($sql);
    }
    
    public function insertIntoKurs($name)
    {
        $sql = "INSERT INTO tbl_kurs (Name) VALUES ('$name')";
        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
    }

    public function selectAlleKurse($name)
    {
        $sql = "SELECT Name FROM tbl_kurs WHERE Name = '$name'";

        $result = $this->db->query($sql);
        return $result->fetch_object();
    }

    public function deleteFreigeschaltet($fbnr){
        $sql = "DELETE FROM tbl_freigeschaltet WHERE FbNr = '$fbnr'";
        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
    }

    public function deleteAbschliessen($fbnr) {
        $sql = "DELETE FROM tbl_abschliessen WHERE FbNr = '$fbnr'";
        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
    }

    public function deleteKommentiert($fbnr) {
        $sql = "DELETE FROM tbl_kommentiert WHERE FbNr = '$fbnr'";
        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
    }

    public function deleteBeantwortet($fbnr){
        $sql = "DELETE FROM tbl_beantwortet WHERE FbNr = '$fbnr'";
        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
    }

    public function deleteFrage($fbnr) {
        $sql = "DELETE FROM tbl_frage WHERE FbNr = '$fbnr'";
        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
    }

    public function deleteFragebogen($fbnr){
        $sql = "DELETE FROM tbl_fragebogen WHERE FbNr = '$fbnr'";
        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
    }



    public function __destruct()
    {
        $this->db->close();
    }
}
