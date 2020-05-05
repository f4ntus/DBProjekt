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

    public function insertIntoFragebogen($titel, $benutzername)
    {
        $sql = "INSERT INTO tbl_fragebogen (Titel, Benutzername) VALUES ('$titel', '$benutzername')";

        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
    }

    public function insertIntoFrage($fnr, $fbnr, $fragetext)
    {
        $sql = "INSERT INTO tbl_frage (FNr, FbNr, Fragetext) VALUES ('$fnr', $fbnr', '$fragetext')";

        if ($this->db->query($sql)) {
            return 'success';
        } else {
            return $this->db->error;
        }
    }

    public function selectFbNrFragebogen($titel)
    {
        $sql = "SELECT FbNr FROM tbl_fragebogen WHERE FbNr ='$titel'";
        $result = $this->db->query($sql);
        return $result->fetch_object();
    }

    public function selectAlleTitel($titel)
    {
        $sql = "SELECT Titel FROM tbl_fragebogen WHERE Titel = '$titel'";

        $result = $this->db->query($sql);
        return $result->fetch_object();
    }


    public function anzahlSeiten($fbnr)
    {
        // ToDo: sauberer SQL-Befehl, so werden alle Datensätze von der Datenbank geholt und dann gezählt. Mit Count lässt sich 
        // von vornerein die Anzahl holen -> performanter 
        $sql = "SELECT * FROM tbl_frage where FbNr = '$fbnr'";
        $result = $this->db->query($sql);
        return $result->num_rows;
    }


    public function FragenEinzeln($fbnr)
    {
        // Muss geprüft werden ob obsolet
        $result = $this->db->query("SELECT * FROM tbl_frage where FbNr = '$fbnr' LIMIT " . $_SESSION["aktfrage"] . ',1');
        $string = '';
        while ($row = $result->fetch_object()) {
            echo $string = $string . '<tr><td>' . $_SESSION['FNr'] = $row->FNr . '</td><td>' . $row->Fragetext . '</td></tr>';
        }
    }

    public function GetFragenText($fbnr,$fnr){
        $result =  $this->db->query("SELECT Fragetext FROM tbl_frage where FbNr = '$fbnr' and fnr ='$fnr'");
        return $result->fetch_object();
    }

    public function bewerten($fnr, $fbnr, $matrikelnummer, $bewertung)
    {
        if (!is_numeric($bewertung)) return false;
        $bewertung = (int) $bewertung;
        if ($bewertung < 1 || $bewertung > 5) return false;
        $sql = "INSERT INTO tbl_beantwortet (FNr, FbNr, Matrikelnummer, Bewertung) VALUES ('$fnr', '$fbnr', '$matrikelnummer', '$bewertung')";

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
