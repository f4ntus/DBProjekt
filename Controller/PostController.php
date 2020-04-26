<?php
require 'SqlWrapper.php';
class PostController extends GlobalFunctions
{
    private $sqlWrapper;
    public function __construct()
    {
        $this->sqlWrapper = new SqlWrapper();
    }

    


   
    

    public function createInnerTable()
    {

        $sqlObject = $this->sqlWrapper->selectFreigeschaltet($_SESSION['kurs']);
        $tableString = '';
        while ($row = $sqlObject->fetch_object()) {
            $tableString = $tableString . '<tr> <td>' . $row->FbNr . '</td><td>' . $row->Titel . '</td></tr>';
        }
        return $tableString;
    }

    /* @Author: Chris
        Hier stehen alle relevanten Funktionen für das Menü des Befragers.*/
    public function createInnerTableBefrager($recentUser) {
        
        $sqlObject = $this->sqlWrapper->selectErstellteFrageboegen($recentUser);
        $tableString = '';
        while($row = $sqlObject->fetch_object()) {
            $tableString = $tableString . '<tr> <td>' . $row->FbNr . '</td><td>' . $row->Titel . '</td></tr>';
           
        }

        return $tableString;
    }

    public function createFrageFelder ($anzFragen) {
        
            $frageString = '';

            for ($i = 1; $i <= $anzFragen; $i++) {
            $frageString = $frageString . $i . " " . "<input type ='text' name ='fragetext" . $i . "'>" . "</br> </br>"; 
            }

            return $frageString;
    }

    // noch in Bearbeitung
    public function createFragen ($fbnr, $i, $fragetext) {
                
        // wie spreche ich die Variable $i aus dem Inputfeld an
        for ($fnr = 1; $fnr <= $i; $fnr++){
            $sqlObject = $this->sqlWrapper->insertIntoFrage($fnr, $fbnr, $fragetext );
        } 
        if ($sqlObject == "success"){
            return "<p>Fragen erfolgreich gespeichert</p>";
        } else return $sqlObject;
    }

    // noch in Bearbeitung
    public function getFbNr($titel) {
        $sqlObject = $this->sqlWrapper->selectFbNrFragebogen($titel);
        return $sqlObject;
    }

    public function createFragebogen($titel, $benutzername){
            $sqlObject = $this->sqlWrapper->insertIntoFragebogen($titel, $benutzername);

            if($sqlObject =="success"){
                return "<p>Fragebogen wurde erstellt.</p>";
            } else return $sqlObject;
    }
    public function __destruct()
    {
        $this->sqlWrapper = NULL;
    }
}
