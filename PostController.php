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
                $this->handleError('anmeldungStudent','studentNotFound');
            } else {
                // weiterleitung zu main.php
                $GETString = '?Matrikelnummer=' . $student->Matrikelnummer . '&Kurs=' . $student->KursName;
                $this->moveToPage('main.php', $GETString);
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
                    // weiterleitung zu main.php
                    $this->moveToPage('main.php');
                } else { // Wenn password nicht übereinstimmt
                    // weiterleitung zu index.php - Befrageranmeldung mit Fehlercode
                    $this->handleError('anmeldungBefrager','wrongPassword');
                }
            }
        }
    }

    public function controllRegister($benutzername, $kennwort)
    {
       if (empty($benutzername)){
            
            $this->handleError('anmeldungBefrager','noUsername');
            exit;
        }
        if (empty($kennwort)){
            $this->handleError('anmeldungBefrager','noPassword');
            exit;
        }
        $kennwort_hash = password_hash($kennwort, PASSWORD_DEFAULT);
        $response = $this->sqlWrapper->insertIntoBefrager($benutzername, $kennwort_hash);
        if ($response == 'success') {
            // weiterleitung zur Anmeldung
            $this->moveToPage('index.php','?befrager=Befrager&registriert=success');
        } else {
            $this->moveToPage('index.php','?befrager=Befrager&registriert=unsuccess');
        }
    }


    public function anzeigenFrageboegen() {
        return $this->sqlWrapper->selectAlleFrageboegen();
    } 
    
    public function getAnzahlFragen($post){
        $anzFragen = $post["anzahlFragen"];

        return $anzFragen;
    }

    public function createFrageFelder ($anzFragen) {
        for ($i = 1; $i <= $anzFragen; $i++) {
            echo $i . " ";
            echo "<input type='text'>";
            echo "</br></br>";
        }
    }
    private function handleError($moveTo, $errorCode)
    {
        if ($moveTo == 'anmeldungBefrager'){
            $GETString = '?befrager=Befrager&error=' . $errorCode;
        }

        if ($moveTo == 'anmeldungStudent'){
            $GETString = '?student=Student&error='. $errorCode;
        }
        $this->moveToPage('index.php', $GETString);
    }

    private function moveToPage($pageName, $suffix = '')
    {
        // Redirect auf eine andere Seite im aktuell angeforderten Verzeichnis 
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/$pageName$suffix");
    }

    public function __destruct()
    {
        $this->sqlWrapper = NULL;
    }
}
