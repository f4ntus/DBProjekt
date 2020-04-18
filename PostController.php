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
            $matrikelnummer = $post["matrikelnummer"];
            $student = $this->sqlWrapper->selectFromStudent($matrikelnummer);
            if (is_null($student)) {
                echo '<p class="error"> Die Matrikelnummer ist nicht im System vorhanden, 
                bitte überprüfen Sie Ihre Eingabe oder wenden sich and den Administrator </p>';
            } else {
                // weiterleitung zu main.php
                $GETString = '?Matrikelnummer=' . $student->Matrikelnummer . '&Kurs=' . $student->KursName;
                $this->moveToPage('main.php', $GETString);
            }
        } else {
            $benutzername = $post["benutzername"];
            $kennwort = $post["kennwort"];
            return $this->sqlWrapper->insertIntoBefrager($benutzername, $kennwort);
        }
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
