<?php
require 'GlobalFunctions.php';
class BefragerController extends GlobalFunctions
{
    public function __construct()
    {
        parent::__construct();
    }
    /* @Author: Chris
        Hier stehen alle relevanten Funktionen für das Menü des Befragers.*/
    public function createInnerTableBefrager($recentUser)
    {

        $sqlObject = $this->sqlWrapper->selectErstellteFrageboegen($recentUser);
        $tableString = '';
        while ($row = $sqlObject->fetch_object()) {
            $tableString = $tableString . '<tr> <td>' . $row->FbNr . '</td><td>' . $row->Titel . '</td></tr>';
        }
        return $tableString;
    }

    public function createFrageFelder($anzFragen)
    {

        $frageString = '';

        for ($i = 1; $i <= $anzFragen; $i++) {
            $frageString = $frageString . $i . " " . "<input type ='text' name ='fragetext" . $i . "'>" . "</br> </br>";
        }

        return $frageString;
    }


    // noch in Bearbeitung --> @JOSC
    // Fragen müssen noch geprüft werden --> @JOSC
    public function createFragen($fbnr, $anzFragen, $post)
    {

        for ($fnr = 1; $fnr <= $anzFragen; $fnr++) {
            $postArrayName = 'fragetext' . $fnr;
            $fragetext = $post[$postArrayName];
            $sqlObject = $this->sqlWrapper->insertIntoFrage($fnr, $fbnr, $fragetext);
            if ($sqlObject != 'success') {
                $this->handleError('fragenErstellen', 'sqlError');
                exit;
            }
        }
        $infoCode = '?fbnr=' . $fbnr . '&erstellt=true';
        $this->handleInfo('fragebogenErstellt', $infoCode);
    }

    public function controllTitelFragebogen($titel, $benutzername, $anzFragen)
    {
        $sqlObject = $this->sqlWrapper->selectAlleTitel($titel);
        if (is_null($sqlObject)) {
            $sqlResult = $this->sqlWrapper->insertIntoFragebogen($titel, $benutzername);
            if ($sqlResult != 'error') {
                $suffixString = '?AnzahlFragen=' . $anzFragen . '&Fbnr=' . $sqlResult . '&Titel=' . $titel;
                $this->moveToPage('FragenErstellen.php', $suffixString);
            } else {
                $this->handleError('neuerFragebogen', 'sqlError');
            }
        } else {
            $this->handleError('neuerFragebogen', 'titleInUse');
        }
    }

    public function createKursFelder()
    {

        $arrayKurse = $this->sqlWrapper->selectKurse();
        foreach ($arrayKurse as $kurs) {
            echo "<input type='checkbox' name='" . $kurs[0] . "'><label for='" . $kurs[0] . "'>" . $kurs[0] . "</label></br>";
            echo "</br>";
        }
    }

    public function freischaltenKurs($fbnr, $post)
    {
        $arrayKurs = array_slice($post, 0, count($post) - 1);
        foreach ($arrayKurs as $key => $kurs) {
            $sqlObject = $this->sqlWrapper->insertIntoFreigeschaltet($fbnr, $key);
            if ($sqlObject != 'success') {
                $suffixString = 'sqlError&fbnr=' . $fbnr;
                $this->handleError('kurseFreischalten', $suffixString);
                exit;
            }
        }
        $this->handleInfo('kurseFreischalten', 'freigeschalten');
    }

    public function controllNameKurs(){ 
        
        $name = $_POST["kursname"];
        $sqlObject = $this->sqlWrapper->selectAlleKurse($name);
        if (is_null($sqlObject)) {
            $neuerKurs = $this->sqlWrapper->insertIntoKurs($name);
            $this->handleInfo('neuerKurs', 'erstellt');
        }
        else {
                $this->handleError('neuerKurs', 'nameInUse');
                //Message: Kurs erfolgreich erstellt
                //Prüfung, ob Titel bereits vorhanden mit Funktion controllNameKurs
            }   
        }
}
