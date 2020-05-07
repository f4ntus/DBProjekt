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
        $sqlObject = $this->sqlWrapper->selectFreigeschaltet($_SESSION['kurs']);
        $tableString = '';
        while ($row = $sqlObject->fetch_object()) {
            $tableString = $tableString . '<tr><td>' . $_SESSION['FbNr'] = $row->FbNr . '</td><td>' . $row->Titel . '</td><td> 
             <input type="submit" name="Fragebogen" value="' . $row->FbNr . '" />';
        }
        return $tableString;
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
            $this->moveToPage('Fragen.php', $suffix);
        }
    }

    // Liefert die Erste Frage in einem Fragebogen, welche nicht beantwortet wurde
    // Sollten alle Fragen beantwortet sein, so wird False ausgegeben.
    public function getFirstNotAnswerdQuestion($fragebogenNr, $matrikelnummer)
    {
        $sqlObjectBeantwortet = $this->sqlWrapper->SelectBeantwortet($fragebogenNr, $matrikelnummer);
        $sqlObjectFrage = $this->sqlWrapper->SelectFragen($fragebogenNr);
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
            // funktioniert nur wenn Beantwortet und Frage beider nach der FNr sortiert sind. 
            // Davon kann ausgeganngen werden, da FNr ein Primärschlüssel ist.
            if ($recordBeantwortet->FNR != $recordFrage->FNr) {
                return $recordFrage->FNr;
            }
        }
        return false;
    }

    public function anzahlSeitenProFB()
    {
        $test = $this->sqlWrapper->anzahlSeiten($_SESSION['FbNr']);
        return $test;
    }

    public function showFrage($fbnr, $fnr)
    {
        $frage = $this->sqlWrapper->SelectFragenText($fbnr, $fnr);
        if (is_null($frage)) {
            //ToDo: Handle Error -> Frage not Found
        } else {
            return $frage->Fragetext;
        }
    }

    public function FrageBewerten()
    {
        $test = $this->sqlWrapper->bewerten($_SESSION['FNr'], $_SESSION['FbNr'], $_SESSION['matrikelnummer'], $_GET['rating']);
        return $test;
    }
}
