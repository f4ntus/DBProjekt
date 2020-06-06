<?php
require 'GlobalFunctions.php';
class StudentController extends GlobalFunctions
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createInnerTable()
    {
        $recordFreigeschaltet = $this->tblFreigeschaltet->selectRecords($_SESSION['kurs']);
        $tableString = '';
        while ($row = $recordFreigeschaltet->fetch_object()) {
            $recordAbgeschlossen = $this->tblAbschliessen->selectUniqueRecord($_SESSION['matrikelnummer'], $row->FbNr);
            // nur Fragebogen anzeigen, welche nicht Abgeschlossen sind
            if (!isset($recordAbgeschlossen)) {
                $tableString = $tableString . '<tr><td>' . $_SESSION['FbNr'] = $row->FbNr . '</td><td>' . $row->Titel . '</td><td> 
                 <button type="submit" name="Fragebogen" value="' . $row->FbNr . '">Beantworten</button>';
            }
        }
        return $tableString;
    }

    public function saveAndNavigateToNext($post, $fbnr, $fnr)
    {
        // prüfen ob student angegemeldet ist
        if (!$this->StudentUndFragebogenPruefen($fbnr)) {
            return;
        }

        // prüfen ob Frage schon beantwortet wurde 
        $recordBeantwortet = $this->tblBeantwortet->selectUniqueRecord($fbnr, $fnr, $_SESSION['matrikelnummer']);
        if (isset($recordBeantwortet)) {
            //Updaten wenn sie schonmal beantwortet wurde
            $this->tblBeantwortet->updateRecord($fbnr, $fnr, $_SESSION['matrikelnummer'], $post['bewertung']);
        } else {
            // Neuer Datensatz, wenn sie noch nicht beantwortet wurde
            $this->tblBeantwortet->insertRecord($fbnr, $fnr, $_SESSION['matrikelnummer'], $post['bewertung']);
        }
        var_dump($fnr);
        $sqlObjectFragen = $this->tblFrage->selectRecords($fbnr, 'FNr>' . $fnr); // liefert ab der aktuellen Frage
        $newFnr = $sqlObjectFragen->fetch_object()->FNr; // die nächste Fragennummer
        if (is_null($newFnr)) {
            // Befragung ist fertig
            $this->moveToPage('BeantwortenAbschliessen.php', '?Fragebogen=' . $fbnr);
        } else {
            // es gibt noch unbeantwortete Fragen
            $suffix = '?Fragebogen=' . $fbnr . '&Frage=' . $newFnr;
            $this->moveToPage('Beantworten.php', $suffix);
        }
    }


    public function navigateToFirstNotAnswerdQuestion($fbnr)
    {
        // prüfen ob student angegemeldet ist
        if (!$this->StudentUndFragebogenPruefen($fbnr)) {
            return;
        }

        $Fnr = $this->getFirstNotAnswerdQuestion($fbnr, $_SESSION["matrikelnummer"]);
        if ($Fnr == false) {
            echo '<p> Ups es ist etwas schiefgelaufen</p>';
            //ToDo: Besseres Errorhandling;
        } else {
            $suffix = '?Fragebogen=' . $fbnr . '&Frage=' . $Fnr;
            $this->moveToPage('Beantworten.php', $suffix);
        }
    }

    // Liefert die Erste Frage in einem Fragebogen, welche nicht beantwortet wurde
    // Sollten alle Fragen beantwortet sein, so wird False ausgegeben.
    private function getFirstNotAnswerdQuestion($fbnr, $matrikelnummer)
    {
        $sqlObjectBeantwortet = $this->tblBeantwortet->selectRecords($fbnr, $matrikelnummer);
        $sqlObjectFrage = $this->tblFrage->selectRecords($fbnr);
        if (is_null($sqlObjectFrage)) {
            //ToDo: Handle Error
            echo 'Frage ist leer';
            return false;
        }
        if (is_null($sqlObjectBeantwortet)) {
            // das heißt es wurde keine Frage beantwortet -> erste Fragennummer zurückgeben
            return $sqlObjectFrage->fetch_object()->FNr;
        }
        while ($recordFrage = $sqlObjectFrage->fetch_object()) {
            $recordBeantwortet = $sqlObjectBeantwortet->fetch_object();
            var_dump($recordBeantwortet);
            var_dump($recordFrage);
            // funktioniert nur wenn Beantwortet und Frage beider nach der FNr sortiert sind. 
            // Davon kann ausgeganngen werden, da FNr ein Primärschlüssel ist.
            if ($recordBeantwortet->FNr != $recordFrage->FNr) {
                return $recordFrage->FNr;
            }
        }
        // Befragung ist fertig
        $this->moveToPage('BeantwortenAbschliessen.php', '?Fragebogen=' . $fbnr);
    }

    public function anzahlSeitenProFB($fbnr)
    {
        $test = $this->sqlWrapper->anzahlSeiten($fbnr);
        return $test;
    }

    public function showFrage($fbnr, $fnr)
    {
        $frage = $this->tblFrage->selectUniqueRecord($fbnr, $fnr);
        if (is_null($frage)) {
            //ToDo: Handle Error -> Frage not Found
        } else {
            return $frage->Fragetext;
        }
    }
    public function goBack($fbnr, $fnr)
    {
        $recordsFrage = $this->tblFrage->selectRecords($fbnr);
        $recordFrage = $recordsFrage->fetch_object(); // erste Frage
        if ($fnr <= $recordFrage->FNr) {
            // wenn erste Frage -> zurück zum Hauptmenü
            $this->moveToPage('MenuStudent.php');
        } else {
            // ansonsten zur letzten Frage
            $fnr = $fnr - 1;
            $suffix = '?Fragebogen=' . $fbnr . '&Frage=' . $fnr;
            $this->moveToPage('Beantworten.php', $suffix);
        }
    }
    public function fragebogenKommentieren($fbnr, $kommentar)
    {
        // to Do: check student
        if (!$this->StudentUndFragebogenPruefen($fbnr)) {
            return;
        }
        $recordKommentare = $this->tblKommentiert->selectUniqueRecord($fbnr, $_SESSION["matrikelnummer"]);
        if (isset($recordKommentare)) {
            $this->tblKommentiert->updateRecord($fbnr, $_SESSION["matrikelnummer"], $kommentar);
        } else {
            if (isset($kommentar)) {
                echo $this->tblKommentiert->insertRecord($fbnr, $_SESSION["matrikelnummer"], $kommentar);
            } else {
                // Fehler: kein Kommentar
                $this->handleError('abschliessen', 'noKommentar');
            }
        }
        // Handle Info Kommentar gespeichert
        //$this->handleInfo('abschliessen','?Fragebogen=' . $fbnr . '&info=gespeichert');
    }
    public function fragebogenAbschliessen($fbnr)
    {
        // prüfen ob student angegemeldet ist
        if (!$this->StudentUndFragebogenPruefen($fbnr)) {
            return;
        }
        // neuer Datensatz eintragen
        echo  $this->tblAbschliessen->insertRecord($_SESSION["matrikelnummer"], $fbnr);

        // zurück zum Hauptmenue
        $this->handleInfo('MenuStudent', 'abgeschlossen');
    }
    public function showRadioButtons($fbnr, $fnr, $matrikelnummer)
    {
        // prüfen ob student angegemeldet ist
        if (!$this->StudentUndFragebogenPruefen($fbnr)) {
            return;
        }
        $recordBeantwortet = $this->tblBeantwortet->selectUniqueRecord($fbnr, $fnr, $matrikelnummer);
        if (isset($recordBeantwortet)) {

            switch ($recordBeantwortet->Bewertung) {
                case 1:
                    echo ' <input type="radio" name="bewertung" value="1" checked> 1
                    <input type="radio" name="bewertung" value="2"> 2
                    <input type="radio" name="bewertung" value="3"> 3
                    <input type="radio" name="bewertung" value="4"> 4 
                    <input type="radio" name="bewertung" value="5"> 5 ';
                    break;
                case 2:
                    echo ' <input type="radio" name="bewertung" value="1"> 1
                    <input type="radio" name="bewertung" value="2" checked> 2
                    <input type="radio" name="bewertung" value="3"> 3
                    <input type="radio" name="bewertung" value="4"> 4 
                    <input type="radio" name="bewertung" value="5"> 5 ';
                    break;
                case 3:
                    echo ' <input type="radio" name="bewertung" value="1"> 1
                    <input type="radio" name="bewertung" value="2"> 2
                    <input type="radio" name="bewertung" value="3" checked> 3
                    <input type="radio" name="bewertung" value="4"> 4 
                    <input type="radio" name="bewertung" value="5"> 5 ';
                    break;
                case 4:
                    echo ' <input type="radio" name="bewertung" value="1"> 1
                    <input type="radio" name="bewertung" value="2"> 2
                    <input type="radio" name="bewertung" value="3"> 3
                    <input type="radio" name="bewertung" value="4" checked> 4 
                    <input type="radio" name="bewertung" value="5"> 5 ';
                    break;
                case 5:
                    echo ' <input type="radio" name="bewertung" value="1"> 1
                    <input type="radio" name="bewertung" value="2"> 2
                    <input type="radio" name="bewertung" value="3"> 3
                    <input type="radio" name="bewertung" value="4"> 4 
                    <input type="radio" name="bewertung" value="5" checked> 5 ';
                    break;
            }
        } else {
            echo ' <input type="radio" name="bewertung" value="1"> 1
                <input type="radio" name="bewertung" value="2"> 2
                <input type="radio" name="bewertung" value="3"> 3
                <input type="radio" name="bewertung" value="4"> 4 
                <input type="radio" name="bewertung" value="5"> 5 ';
        }
    }

    private function StudentUndFragebogenPruefen($fbnr)
    {
        // prüfen ob angemeldet
        $recordStudent = $this->tblStudent->selectUniqueRecord($_SESSION["matrikelnummer"]);
        if (!isset($recordStudent)) {
            $this->handleError('anmeldungStudent', 'notLoggedIn');
            return false;
        }

        // prüfen ob freigeschaltet
        $recordFreigeschaltet = $this->tblFreigeschaltet->selectUniqueRecord($recordStudent->Name, $fbnr);
        if (!isset($recordFreigeschaltet)) {
            $this->handleError('menueStudent', 'notFreigegeben');
            return false;
        }

        // prüfen ob nicht abgeschlossen
        $recordAbgeschlossen = $this->tblAbschliessen->selectUniqueRecord($_SESSION["matrikelnummer"], $fbnr);
        if (isset($recordAbgeschlossen)) {
            $this->handleError('menueStudent', 'abgeschlossen');
            return false;
        }

        return true;
    }
}
