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
                $GETString = '?student=Student&error=StudentNotFound';
                $this->moveToPage('index.php', $GETString);
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
                $GETString = '?befrager=Befrager&error=BefragerNotFound';
                $this->moveToPage('index.php', $GETString);
            } else {
                if (password_verify($kennwort,$befrager->Kennwort)) {
                    // weiterleitung zu main.php
                    $GETString = '?Kennwort=' . $befrager->Kennwort . '&Befrager=' . $benutzername;
                    $this->moveToPage('main.php', $GETString);
                } else { // Wenn password nicht übereinstimmt
                    // weiterleitung zu index.php - Befrageranmeldung mit Fehlercode
                    $GETString = '?befrager=Befrager&error=wrongPassword';
                    $this->moveToPage('index.php', $GETString);
                }
            }
            //return $this->sqlWrapper->insertIntoBefrager($benutzername, $kennwort);
        }
    }

    public function controllRegister($benutzername,$kennwort){
        $kennwort_hash = password_hash($kennwort,PASSWORD_DEFAULT);
        return $this->sqlWrapper->insertIntoBefrager($benutzername, $kennwort_hash);
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
