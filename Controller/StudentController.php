<?php
require 'GlobalFunctions.php';
class StudentController extends GlobalFunctions
{
    public function __construct()
    {
        parent::__construct();
    }

     /**
     * @author Johannes Scheffold
     * Erzeugt eine Tabelle mit allen relavanten Fragebögen.
     *
     * 
     * @return string $tableString der String mit der die Tabelle aufgebaut wird 
     */
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


     /**
     * @author Johannes Scheffold
     * Erzeugt eine Tabelle mit allen relavanten Fragebögen.
     *
     * @param $post 
     * 
     * @return string $tableString der String mit der die Tabelle aufgebaut wird 
     */
    public function saveAndNavigateToNext($post, $fbnr, $fnr)
    {
        // prüfen ob student angegemeldet ist
        if (!$this->studentUndFragebogenPruefen($fbnr)) {
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
        $sqlObjectFragen = $this->tblFrage->selectRecords($fbnr, $fnr); // liefert ab der aktuellen Frage
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

    /**
     * @author Johannes Scheffold
     * Navigiert zur ersten nicht beantworteten Frage eines Studenten. 
     *
     * @param $fbnr (Fragebogennummer) 
     * 
     * @return void  
     */

    public function navigateToFirstNotAnswerdQuestion($fbnr)
    {
        // prüfen ob student angegemeldet ist
        if (!$this->studentUndFragebogenPruefen($fbnr)) {
            return;
        }

        $sqlObjectBeantwortet = $this->tblBeantwortet->selectRecords($fbnr, $_SESSION["matrikelnummer"]);
        $sqlObjectFrage = $this->tblFrage->selectRecords($fbnr);
        while ($recordFrage = $sqlObjectFrage->fetch_object()) {
            $recordBeantwortet = $sqlObjectBeantwortet->fetch_object();
            // funktioniert nur wenn Beantwortet und Frage beide nach der FNr sortiert sind. 
            // Davon kann ausgeganngen werden, da FNr ein Primärschlüssel ist.
            if (!isset($recordBeantwortet)) {
                $suffix = '?Fragebogen=' . $fbnr . '&Frage=' . $recordFrage->FNr;
                $this->moveToPage('Beantworten.php', $suffix);
                return;
            }
        }
        // Befragung ist fertig
        $this->moveToPage('BeantwortenAbschliessen.php', '?Fragebogen=' . $fbnr);
    }

    /**
     * @author Johannes Scheffold
     * gibt die Anzahl der Fragen pro Fragebogen zurück
     *
     * @param $fbnr (Fragebogennummer) 
     * 
     * @return int 
     */
    public function anzahlSeitenProFB($fbnr)
    {
        $sqlResult = $this->tblFrage->selectRecords($fbnr);
        return $sqlResult->num_rows;
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
        if (!$this->studentUndFragebogenPruefen($fbnr)) {
            return;
        }
        $recordKommentare = $this->tblKommentiert->selectUniqueRecord($fbnr, $_SESSION["matrikelnummer"]);
        if (isset($recordKommentare)) {
            $this->tblKommentiert->updateRecord($fbnr, $_SESSION["matrikelnummer"], $kommentar);
        } else {
            if (isset($kommentar)) {
                $this->tblKommentiert->insertRecord($fbnr, $_SESSION["matrikelnummer"], $kommentar);
            } else {
                // Fehler: kein Kommentar
                $this->handleError('abschliessen', 'noKommentar');
            }
        }
        // Handle Info Kommentar gespeichert
        $this->handleInfo('abschliessen','?Fragebogen=' . $fbnr . '&info=gespeichert');
    }
    public function fragebogenAbschliessen($fbnr)
    {
        // prüfen ob student angegemeldet ist
        if (!$this->studentUndFragebogenPruefen($fbnr)) {
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
        if (!$this->studentUndFragebogenPruefen($fbnr)) {
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
    public function goToLastQuestion($fbnr){
        if (!$this->studentUndFragebogenPruefen($fbnr)) {
            return;
        }
        $recordFrage =$this->tblFrage->maxRecord($fbnr);
        $this->moveToPage('Beantworten.php','?Fragebogen='. $fbnr . '&Frage=' . $recordFrage->maxFnr);
    }
    public function getKommentar($fbnr){
        if (!$this->studentUndFragebogenPruefen($fbnr)){
            return;
        }
        $kommentarRecord = $this->tblKommentiert->selectUniqueRecord($fbnr,$_SESSION["matrikelnummer"]);
        if (isset($kommentarRecord)){
           return $kommentarRecord->Kommentar;
        }
        return '';
    }

    public function studentUndFragebogenPruefen($fbnr='')
    {
        // prüfen ob angemeldet
        $recordStudent = $this->tblStudent->selectUniqueRecord($_SESSION["matrikelnummer"]);
        if (!isset($recordStudent)) {
            $this->handleError('anmeldungStudent', 'notLoggedIn');
            return false;
        }

        if ($fbnr != ''){

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
        }

        return true;
    }
}
