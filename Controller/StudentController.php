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
            <form method="POST" action="">
            <input type="submit" name="anzeigenFragen" value="Anzeigen" />
            </form>';

            
        }
        return $tableString;
    }

    public function test() {
        $test = $this->sqlWrapper->limit($_SESSION['FbNr']);
        return $test;
    }

}