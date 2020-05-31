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
        $sqlObject = $this->tblFreigeschaltet->selectRecords($_SESSION['kurs']);
        $tableString = '';
        while ($row = $sqlObject->fetch_object()) {
            $tableString = $tableString . '<tr><td>' . $_SESSION['FbNr'] = $row->FbNr . '</td><td>' . $row->Titel . '</td><td> 
             <button type="submit" name="Fragebogen" value="' . $row->FbNr . '">Beantworten</button>';
        }
        return $tableString;
    }
    
    public function saveAndNavigateToNext($post,$fbnr,$fnr)
    {
        // ToDo: Muss geprüft werden ob der Student angemeldet ist
        // prüfen ob Frage schon beantwortet wurde 
        $recordBeantwortet = $this->tblBeantwortet->selectUniqueRecord($fbnr,$fnr,$_SESSION['matrikelnummer']);
        $this->tblBeantwortet->insertRecord($fbnr, $fnr, $_SESSION['matrikelnummer'], $post['bewertung']);
        var_dump($fnr);
        $sqlObjectFragen = $this->tblFrage->selectRecords($fbnr,'FNr>'. $fnr); // liefert ab der aktuellen Frage
        $newFnr = $sqlObjectFragen->fetch_object()->FNr; // die nächste Fragennummer
        if (is_null($newFnr)){
            // Befragung ist fertig
            $this->moveToPage('BeantwortenAbschliessen.php', '?Fragebogen='. $fbnr);
        } else {
            // es gibt noch unbeantwortete Fragen
            $suffix = '?Fragebogen='. $fbnr . '&Frage='. $newFnr;
            $this->moveToPage('Beantworten.php', $suffix); 
        }
        
    }

    
    public function navigateToFirstNotAnswerdQuestion($fbnr)
    {
        // ToDo: Muss geprüft werden ob Student angemeldet ist.
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
        if(is_null($sqlObjectBeantwortet)){
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
        $this->moveToPage('BeantwortenAbschliessen.php', '?Fragebogen='. $fbnr);
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

}
