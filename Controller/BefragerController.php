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
        $this->handleInfo('fragebogenErstellt', 'fb_erstellt');
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

    public function freischaltenKurs($fragebogen, $kurs)
    {
        $fbnr = $this->sqlWrapper->selectFbNrFragebogen($fragebogen)->FbNr;
        $sqlObject = $this->sqlWrapper->insertIntoFreigeschaltet($fbnr, $kurs);
        if ($sqlObject != 'success') {
            $this->handleError('kurseFreischalten', 'sqlError');
        } else $this->handleInfo('kurseFreischalten', 'freigeschalten');
    }

    public function showBereitsFreigeschaltet($fragebogen)
    {
        $fbnr = $this->sqlWrapper->selectFbNrFragebogen($fragebogen)->FbNr;
        $sqlObject = $this->sqlWrapper->selectBereitsFreigeschaltet($fbnr);
        $freigeschaltetString = '';
        while ($row = $sqlObject->fetch_object()) {
            $freigeschaltetString = $freigeschaltetString . $row->Name . "</br>";
        }
        if ($freigeschaltetString == '') {
            $freigeschaltetString = 'Es wurden noch keine Kurse freigeschalten.';
        }
        return "<br> <p>Liste der bereits freigegebenen Kurse für den Fragebogen " . $fragebogen . ":</p>" . $freigeschaltetString;
    }


    public function createDropdownFragebogen($recentUser)
    {

        $sqlObject = $this->sqlWrapper->selectErstellteFrageboegen($recentUser);
        $dropdownString = '';

        while ($row = $sqlObject->fetch_object()) {
            $dropdownString = $dropdownString . "<option>" . $row->Titel . "</option>";
        }

        return $dropdownString;
    }

    public function createDropdownKurs()
    {
        $sqlObject = $this->sqlWrapper->selectKurse();
        $dropdownString = '';

        while ($row = $sqlObject->fetch_object()) {
            $dropdownString = $dropdownString . "<option>" . $row->Name . "</option>";
        }

        return $dropdownString;
    }

    public function fragebogenKopieren($recentUser, $oldTitle, $copyTitle)
    {
        $oldFbNr = $this->sqlWrapper->selectFbNrFragebogen($oldTitle)->FbNr;
        $checkTitle = $this->sqlWrapper->selectAlleTitel($copyTitle);
        if (is_null($checkTitle)) {
            $newFbNr = $this->sqlWrapper->insertIntoFragebogen($copyTitle, $recentUser);
            $sqlObject1 = $this->sqlWrapper->selectFragetextFromFragen($oldFbNr);
            $fnr = 1;
            while ($frage = $sqlObject1->fetch_object()) {
                $fragetext = $frage->Fragetext;
                $sqlObject = $this->sqlWrapper->insertIntoFrage($fnr, $newFbNr, $fragetext);
                if ($sqlObject != 'success') {
                    $this->handleError('fragenKopieren', 'sqlError');
                    exit;
                }
                $fnr++;
            }
            $this->handleInfo('fragebogenKopieren', 'kopiert');
        } else {
            $this->handleError('fragebogenKopieren', 'titleInUse');
        }
    }
    public function controllNameKurs()
    {

        $name = $_POST["kursname"];
        $sqlObject = $this->sqlWrapper->selectAlleKurse($name);
        if (is_null($sqlObject)) {
            $neuerKurs = $this->sqlWrapper->insertIntoKurs($name);
            $this->handleInfo('neuerKurs', 'kursErstellt');
        } else {
            $this->handleError('neuerKurs', 'nameInUse');
        }
    }

    public function fragebogenLoeschen($title)
    {
        $fbnr = $this->sqlWrapper->selectFbNrFragebogen($title)->FbNr;
        $sqlObject = $this->sqlWrapper->deleteFreigeschaltet($fbnr);
        $sqlObject = $this->sqlWrapper->deleteKommentiert($fbnr);
        $sqlObject = $this->sqlWrapper->deleteAbschliessen($fbnr);
        $sqlObject = $this->sqlWrapper->deleteBeantwortet($fbnr);
        $sqlObject =  $this->sqlWrapper->deleteFrage($fbnr);
        $sqlObject = $this->sqlWrapper->deleteFragebogen($fbnr);
        if ($sqlObject != 'success') {
            $this->handleError('fragebogenLoeschen', 'sqlError');
        } else {
            $this->handleInfo('fragebogenLoeschen', 'geloescht');
        }
    }
        

    public function controllMatrikelnummer(){ 
        
        $matrikelnummer = $_POST["matrikelnummer"];
        $sqlObject = $this->sqlWrapper->selectMatrikelnummern($matrikelnummer);
        if (is_null($sqlObject)) {
            $name = $_POST["Kurs"];
            $neuerStudent = $this->sqlWrapper->insertIntoStudent($matrikelnummer, $name);
            $this->handleInfo('neuerStudent', 'studentErstellt');
        }
        else {
                $this->handleError('neueMatrikelnummer', 'matrikelnummerInUse');   
            }   
        }
}
