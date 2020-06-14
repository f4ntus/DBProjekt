<?php
require 'GlobalFunctions.php';
class IndexController extends GlobalFunctions
{
    /**
     * @author Johannes Scheffold
     * regelt die Anmeldung von Student und Befrager
     * @param $post (Benutzereingabe)
     * @return void 
     */
    public function controllAnmeldung($post)
    {
        if (isset($post["matrikelnummer"])) {
            // Code für Studentenanmeldung
            $matrikelnummer = $post["matrikelnummer"];
            $student = $this->tblStudent->selectUniqueRecord($matrikelnummer);
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
            $befrager = $this->tblBefrager->selectUniqueRecord($benutzername);
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

    /**
     * @author Johannes Scheffold
     * regelt das Registrieren vom Befrager
     * @param $benutzername (Befrager)
     * @param $Kennwort
     * @return void
     */
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
        
        $response = $this->tblBefrager->insertRecord($benutzername, $kennwort_hash);
        //$response = $this->sqlWrapper->insertIntoBefrager($benutzername, $kennwort_hash);
        if ($response == 'success') {
            // weiterleitung zur Anmeldung
            $this->handleInfo('anmeldungBefrager','regSuccess');
        } else {
            $this->handleError('anmeldungBefrager','regUnsuccess');
        }
    }
}
