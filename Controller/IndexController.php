<?php
require 'GlobalFunctions.php';
class IndexController extends GlobalFunctions
{
    public function __construct()
    {
        parent::__construct();
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
}
