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
        // Fragen müssen noch geprüft werden --> @JOSC
        public function createFragen ($fbnr, $anzFragen, $post) {
            echo('ich war hier')     ;
            // wie spreche ich die Variable $i aus dem Inputfeld an
            for ($fnr = 1; $fnr <= $anzFragen; $fnr++){
                $postArrayName = 'fragetext' . $fnr;
                $fragetext = $post[$postArrayName];
                $sqlObject = $this->sqlWrapper->insertIntoFrage($fnr, $fbnr, $fragetext );
                if ($sqlObject != 'success'){
                    var_dump($sqlObject);
                    exit;         
                }
            } 
            $suffixString = '?fbnr='. $fbnr .'&erstellt=true';
            $this->moveToPage('FreischaltungKurs.php',$suffixString);
        }

        public function controllTitelFragebogen($titel, $benutzername, $anzFragen) {
            $sqlObject = $this->sqlWrapper->selectAlleTitel($titel);
            if (is_null($sqlObject)) {
                $sqlResult = $this->sqlWrapper->insertIntoFragebogen($titel, $benutzername);
                if ( $sqlResult != 'error'){
                    $suffixString = '?AnzahlFragen=' . $anzFragen . '&Fbnr=' . $sqlResult . '&Titel=' . $titel; 
                    $this->moveToPage('FragenErstellen.php',$suffixString);
                } else {
                    $this->handleError('neuerFragebogen','sqlError');
                }
            } else {
                $this->handleError('neuerFragebogen','titleInUse');
        }
        }
}
