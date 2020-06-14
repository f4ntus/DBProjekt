<?php
require 'GlobalFunctions.php';
class StudentController extends GlobalFunctions
{

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
     * speichert und navigiert zur nächsten Frage
     *
     * @param $post (Eingabe des Benutzers)
     * @param $fbnr (Fragebogennummer) 
     * @param $fnr (Fragenummer) 
     * 
     * @return void
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
     * Navigiert eine Frage zurück
     *
     * @param $fbnr (Fragebogennummer) 
     * @param $fnr (Fragenummer)
     * @return void
     */
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


    /**
     * @author Johannes Scheffold
     * 
     * Navigiert zu der letzten Frage eines Fragebogens
     * 
     * @param $fbnr (Fragebogennummer) 
     * @return void
     */
    public function goToLastQuestion($fbnr){
        if (!$this->studentUndFragebogenPruefen($fbnr)) {
            return;
        }
        $recordFrage =$this->tblFrage->maxRecord($fbnr);
        $this->moveToPage('Beantworten.php','?Fragebogen='. $fbnr . '&Frage=' . $recordFrage->maxFnr);
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

     /**
     * @author Johannes Scheffold
     * gibt den Fragetext der Frage zurück
     *
     * @param $fbnr (Fragebogennummer) 
     * @param $fnr (Fragenummer)
     * @return String 
     */
    public function getFragetext($fbnr, $fnr)
    {
        $frage = $this->tblFrage->selectUniqueRecord($fbnr, $fnr);
        return $frage->Fragetext;
    }
    

    /**
     * @author Johannes Scheffold
     * Kommentiert Fragebogen
     *
     * @param $fbnr (Fragebogennummer) 
     * @param $kommentar
     * @return void
     */
    public function fragebogenKommentieren($fbnr, $kommentar)
    {
        // prüfe Student
        if (!$this->studentUndFragebogenPruefen($fbnr)) {
            return;
        }
        
        // prüfen ob Kommentar ausgefüllt wurde
        if (!isset($kommentar)) {
            // Fehler: kein Kommentar
            $this->handleError('abschliessen', 'noKommentar');
            return;
        }

        $recordKommentare = $this->tblKommentiert->selectUniqueRecord($fbnr, $_SESSION["matrikelnummer"]);
        
        if (isset($recordKommentare)) {
            // wenn bereits kommentiert -> Kommentar updaten
            $this->tblKommentiert->updateRecord($fbnr, $_SESSION["matrikelnummer"], $kommentar);
        } else {
            // ansonsten neuer Datensatz
            $this->tblKommentiert->insertRecord($fbnr, $_SESSION["matrikelnummer"], $kommentar);
        }

        // Handle Info Kommentar gespeichert
        $this->handleInfo('abschliessen','?Fragebogen=' . $fbnr . '&info=gespeichert');
    }
    
    /**
     * @author Johannes Scheffold
     * schließt einen Fragebogen ab
     *
     * @param $fbnr (Fragebogennummer) 
     * @return void
     */
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

    /**
     * @author Johannes Scheffold
     * gibt die Radiobuttons für das Beatworten der Frage aus und regelt die Vorbelegung, 
     * falls eine Frage bereits beantwortet ist. 
     *
     * @param $fbnr (Fragebogennummer) 
     * @param $fnr (Fragenummer) 
     * @return void
     */
    public function showRadioButtons($fbnr, $fnr)
    {
        // prüfen ob student angegemeldet ist
        if (!$this->studentUndFragebogenPruefen($fbnr)) {
            return;
        }
        $recordBeantwortet = $this->tblBeantwortet->selectUniqueRecord($fbnr, $fnr, $_SESSION["matrikelnummer"] );
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
        } else { // wenn die Frage nicht beantwortet wurde
            echo ' <input type="radio" name="bewertung" value="1"> 1
                <input type="radio" name="bewertung" value="2"> 2
                <input type="radio" name="bewertung" value="3"> 3
                <input type="radio" name="bewertung" value="4"> 4 
                <input type="radio" name="bewertung" value="5"> 5 ';
        }
    }



    /**
     * @author Johannes Scheffold
     * 
     * holt sich den aktuellen Kommentar für die Vorbelegung des Textfelds
     * 
     * @param $fbnr (Fragebogennummer) 
     * @return void
     */
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
   
   
    /**
     * @author Johannes Scheffold
     * 
     * überprüft ob Student angemeldet ist, ob der Fragebogen dem Studenten freigegeben ist 
     * und ob der Student den Fragebogen nicht schon abgeschlossen hat.
     * 
     * @param $fbnr (Fragebogennummer) 
     * @return boolean (false für fehler)
     */
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
