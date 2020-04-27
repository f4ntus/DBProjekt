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
        

        // noch in Bearbeitung --> @JOSC
        public function createFragen ($fbnr, $anzFragen, $post) {
                    
            // wie spreche ich die Variable $i aus dem Inputfeld an
            for ($fnr = 1; $fnr <= $anzFragen; $fnr++){
                $fragetext
                $sqlObject = $this->sqlWrapper->insertIntoFrage($fnr, $fbnr, $fragetext );
            } 
            if ($sqlObject == "success"){
                return "<p>Fragen erfolgreich gespeichert</p>";
            } else return $sqlObject;
        }
    
        // noch in Bearbeitung --> @JOSC
        public function getFbNr($titel) {
            $sqlObject = $this->sqlWrapper->selectFbNrFragebogen($titel);
            return $sqlObject;
        }

        public function controllTitelFragebogen($titel, $benutzername) {
            $sqlObject = $this->sqlWrapper->selectAlleTitel($titel);
            if (is_null($sqlObject)) {
                $this->createFragebogen($titel, $benutzername);
            } else {
                $this->handleError('neuerFragebogen','titleInUse');
                /*$this->moveToPage('neuerFragebogen.php');
                return "<p> Dieser Titel wurde schon vergeben.";*/
        }
        }
    
        public function createFragebogen($titel, $benutzername){
                $sqlObject = $this->sqlWrapper->insertIntoFragebogen($titel, $benutzername);
    
                if($sqlObject =="success"){
                    return "<p>Fragebogen wurde erstellt.</p>";
                } else return $sqlObject;
        }
}
