<?php
require 'SqlWrapper.php';
class PostController
{
    private $sqlWrapper;
    public function __construct()
    {
        $this->sqlWrapper = new SqlWrapper();
    }

    public function controllAnmeldung($post)
    {
        if (isset($post["matrikelnummer"])) {
            // Code für Studentenanmeldung
            $matrikelnummer = $post["matrikelnummer"];
            $student = $this->sqlWrapper->selectFromStudent($matrikelnummer);
            if (is_null($student)) {
                // weiterleitung zu index.php - Studentenanmeldung mit Fehlercode
                $this->handleError('anmeldungStudent', 'studentNotFound');
            } else {
                // weiterleitung zu main.php
                $_SESSION['matrikelnummer'] = $student->Matrikelnummer;
                $_SESSION['kurs'] = $student->Name;
                $this->moveToPage('MenuStudent.php');
            }
        } else {
            // Code für Befrageranmeldung
            $benutzername = $post["benutzername"];
            $kennwort = $post["password"];
            $befrager = $this->sqlWrapper->selectFromBefrager($benutzername);
            // Wenn Benutzername nicht gefunden wird
            if (is_null($befrager)) {
                // weiterleitung zu index.php - Befrageranmeldung mit Fehlercode
                $this->handleError('anmeldungBefrager', 'befragerNotFound');
            } else {
                if (password_verify($kennwort, $befrager->Kennwort)) {
                    // Anmeldung Erfolgreich:
                    $_SESSION['befrager'] = $befrager->Benutzername;
                    // weiterleitung zu menuBefrager.php
                    $this->moveToPage('menuBefrager.php');
                } else { // Wenn password nicht übereinstimmt
                    // weiterleitung zu index.php - Befrageranmeldung mit Fehlercode
                    $this->handleError('anmeldungBefrager', 'wrongPassword');
                }
            }
        }
    }


    public function controllRegister($benutzername, $kennwort)
    {
        if (empty($benutzername)) {

            $this->handleError('anmeldungBefrager', 'noUsername');
            exit;
        }
        if (empty($kennwort)) {
            $this->handleError('anmeldungBefrager', 'noPassword');
            exit;
        }
        $kennwort_hash = password_hash($kennwort, PASSWORD_DEFAULT);
        $response = $this->sqlWrapper->insertIntoBefrager($benutzername, $kennwort_hash);
        if ($response == 'success') {
            // weiterleitung zur Anmeldung
            $this->moveToPage('index.php', '?befrager=Befrager&registriert=success');
        } else {
            $this->moveToPage('index.php', '?befrager=Befrager&registriert=unsuccess');
        }
    }
    
    private function handleError($moveTo, $errorCode)
    {
        switch ($moveTo){
            case 'anmeldungBefrager' : {
                $GETString = '?befrager=Befrager&error=' . $errorCode;
                $this->moveToPage('index.php', $GETString);
                break;
            }
            case 'anmeldungStudent' : {
                $GETString = '?student=Student&error=' . $errorCode;
                $this->moveToPage('index.php', $GETString);
            }
            case 'neuerFragebogen' : {
                $GETString = '?error=' . $errorCode;
                $this->moveToPage('neuerFragebogen.php', $GETString);
            }
        }
   }

    private function moveToPage($pageName, $suffix = '')
    {
        // Redirect auf eine andere Seite im aktuell angeforderten Verzeichnis 
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/$pageName$suffix");
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
    public function createFragebogen($titel, $benutzername) {      
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
