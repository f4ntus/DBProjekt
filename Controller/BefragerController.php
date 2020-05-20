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

        $sqlObject = $this->tblFragebogen->selectRecords($recentUser);
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
    public function createFragen($fbnr, $anzFragen, $post, $titel)
    {

        for ($fnr = 1; $fnr <= $anzFragen; $fnr++) {
            $postArrayName = 'fragetext' . $fnr;
            $fragetext = $post[$postArrayName];

            for ($fnr1 = 1; $fnr1 <= $anzFragen; $fnr1++) {

                if ($fnr == $fnr1) {
                    $fnr1++;
                }
                $postArrayName1 = 'fragetext' . $fnr1;
                $fragetext1 = $post[$postArrayName1];
                if ($fragetext == $fragetext1) {
                    $suffixString = '?AnzahlFragen=' . $anzFragen . '&Fbnr=' . $fbnr . '&Titel=' . $titel . '&error=gleicheFrage';
                    $this->handleError('fragenErstellen', $suffixString);
                    exit;
                }
            }
            if ($fragetext == '') {
                $suffixString = '?AnzahlFragen=' . $anzFragen . '&Fbnr=' . $fbnr . '&Titel=' . $titel . '&error=leereFrage';
                $this->handleError('fragenErstellen', $suffixString);
                exit;
            }

            $sqlObject = $this->tblFrage->insertRecord($fbnr, $fnr, $fragetext);
            if ($sqlObject != 'success') {
                echo $sqlObject; //$this->handleError('fragenErstellen', '?error=sqlError');
                exit;
            }
        }

        $this->handleInfo('fragebogenErstellt', 'fb_erstellt');
    }

    public function controllTitelFragebogen($titel, $benutzername, $anzFragen)
    {
        $sqlObject = $this->tblFragebogen->selectUniqueRecordByTitel($titel);
        if (is_null($sqlObject)) {
            $sqlResult = $this->tblFragebogen->insertRecord($titel, $benutzername);
            if ($anzFragen <= 0) {
                $this->handleError('neuerFragebogen', 'keineFragen');
            } else {
                if ($sqlResult != 'error') {
                    $suffixString = '?AnzahlFragen=' . $anzFragen . '&Fbnr=' . $sqlResult . '&Titel=' . $titel;
                    $this->moveToPage('FragenErstellen.php', $suffixString);
                } else {
                    $this->handleError('neuerFragebogen', 'sqlError');
                }
            }
        } else {
            $this->handleError('neuerFragebogen', 'titleInUse');
        }
    }

    public function createKursFelder()
    {

        $kurse = $this->tblKurs->selectRecords();
        while ($kurs = $kurse->fetch_object()) {
            echo "<input type='checkbox' name='" . $kurs->Name . "'><label for='" . $kurs->Name . "'>" . $kurs->Name . "</label></br>";
            echo "</br>";
        }
    }

    public function freischaltenKurs($fragebogen, $kurs)
    {
        $fbnr = $this->tblFragebogen->selectUniqueRecordByTitel($fragebogen)->FbNr;
        $sqlObject = $this->tblFreigeschaltet->insertRecord($fbnr, $kurs);
        if ($sqlObject != 'success') {
            $this->handleError('kurseFreischalten', 'sqlError');
        } else $this->handleInfo('kurseFreischalten', 'freigeschalten');
    }

    public function showBereitsFreigeschaltet($fragebogen)
    {
        $fbnr = $this->tblFragebogen->selectUniqueRecordByTitel($fragebogen)->FbNr;
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

        $sqlObject = $this->tblFragebogen->selectRecords($recentUser);
        $dropdownString = '';

        while ($row = $sqlObject->fetch_object()) {
            $dropdownString = $dropdownString . "<option>" . $row->Titel . "</option>";
        }

        return $dropdownString;
    }

    public function createDropdownKurs()
    {
        $sqlObject = $this->tblKurs->selectRecords();
        $dropdownString = '';

        while ($row = $sqlObject->fetch_object()) {
            $dropdownString = $dropdownString . "<option>" . $row->Name . "</option>";
        }

        return $dropdownString;
    }

    public function fragebogenKopieren($recentUser, $oldTitle, $copyTitle)
    {
        $oldFbNr = $this->tblFragebogen->selectUniqueRecordByTitel($oldTitle)->FbNr;
        $checkTitle = $this->tblFragebogen->selectUniqueRecordByTitel($copyTitle);
        if (is_null($checkTitle)) {
            $newFbNr = $this->tblFragebogen->insertRecord($copyTitle, $recentUser);
            $sqlObject1 = $this->tblFrage->selectRecords($oldFbNr);
            $fnr = 1;
            while ($frage = $sqlObject1->fetch_object()) {
                $fragetext = $frage->Fragetext;
                $sqlObject = $this->tblFrage->insertRecord($newFbNr, $fnr, $fragetext);
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
        $sqlObject = $this->tblKurs->selectUniqueRecord($name);
        if (is_null($sqlObject)) {
            $neuerKurs = $this->tblKurs->insertRecord($name);
            // ToDo: mit $neuerKurs wird nichts gemacht, Fehlerbehandlung ?
            $this->handleInfo('neuerKurs', 'kursErstellt');
        } else {
            $this->handleError('neuerKurs', 'nameInUse');
        }
    }

    public function fragebogenLoeschen($title)
    {
        $fbnr = $this->tblFragebogen->selectUniqueRecordByTitel($title)->FbNr;
        $sqlObject = $this->tblFragebogen->deleteRecord($fbnr);
        if ($sqlObject != 'success') {
            $this->handleError('fragebogenLoeschen', 'sqlError');
        } else {
            $this->handleInfo('fragebogenLoeschen', 'geloescht');
        }
    }


    public function controllMatrikelnummer()
    {

        $matrikelnummer = $_POST["matrikelnummer"];
        $sqlObject = $this->tblStudent->selectUniqueRecord($matrikelnummer);
        if (is_null($sqlObject)) {
            $name = $_POST["Kurs"];
            $neuerStudent = $this->tblStudent->insertRecord($matrikelnummer, $name);
            $this->handleInfo('neuerStudent', 'studentErstellt');
        } else {
            $this->handleError('neueMatrikelnummer', 'matrikelnummerInUse');
        }
    }
}
