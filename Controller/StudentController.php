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
            <form method="POST" action="Fragen.php">    
            <input type="submit" name="anzeigenFragen" value="Anzeigen" />
            </form>';
            
        }
        return $tableString;
    }

    public function anzahlSeitenProFB() {
        $test = $this->sqlWrapper->anzahlSeiten($_SESSION['FbNr']);
        return $test;
    }

    public function showFragen() {
        $test = $this->sqlWrapper->FragenEinzeln($_SESSION['FbNr']);
        return $test;
    }

    public function FrageBewerten() {
        $test = $this->sqlWrapper->bewerten($_SESSION['FNr'], $_SESSION['FbNr'], $_SESSION['matrikelnummer'], $_GET['rating']);
        return $test;
    }

}