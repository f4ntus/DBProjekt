<?php
class GlobalFunctions {
    protected function handleError($moveTo, $errorCode)
    {
        if ($moveTo == 'anmeldungBefrager') {
            $GETString = '?befrager=Befrager&error=' . $errorCode;
        }

        if ($moveTo == 'anmeldungStudent') {
            $GETString = '?student=Student&error=' . $errorCode;
        }
        
        $this->moveToPage('index.php', $GETString);
    }
    protected function moveToPage($pageName, $suffix = '')
    {
        // Redirect auf eine andere Seite im aktuell angeforderten Verzeichnis 
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/$pageName$suffix");
    }
} 
?>