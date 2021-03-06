<?php
require '../Model/TblAbschliessen.php';
require '../Model/TblBeantwortet.php';
require '../Model/TblBefrager.php';
require '../Model/TblFrage.php';
require '../Model/TblFragebogen.php';
require '../Model/TblKommentiert.php';
require '../Model/TblKurs.php';
require '../Model/TblStudent.php';
require '../Model/TblFreigeschaltet.php';
require '../Model/SqlAuswertung.php';
abstract class GlobalFunctions
{
    protected $tblAbschliessen;
    protected $tblBeantwortet;
    protected $tblBefrager;
    protected $tblFrage;
    protected $tblFragebogen;
    protected $tblKommentiert;
    protected $tblKurs;
    protected $tblStudent;
    protected $tblFreigeschaltet;
    protected $sqlAuswertung;
    public function __construct()
    {
        $this->tblAbschliessen = new TblAbschliessen();
        $this->tblBeantwortet = new TblBeantwortet();
        $this->tblBefrager = new TblBefrager();
        $this->tblFrage = new TblFrage();
        $this->tblFragebogen = new TblFragebogen();
        $this->tblKommentiert = new TblKommentiert();
        $this->tblKurs = new TblKurs();
        $this->tblStudent = new TblStudent();
        $this->tblFreigeschaltet = new TblFreigeschaltet();
        $this->sqlAuswertung = new SqlAuswertung();
    }
    /**
     * @author Johannes Scheffold
     * 
     * Hilfsfunktion, macht das Errorhandling einfacher
     * 
     * @param $moveTo Code, sagt wo der Fehler angezeigt werden soll.
     * @param $errorCode, dieser Code wird als parameter im Link mitangegeben und kann auf einzelnen Pages abgefragt werden (Error-Boxen)
     * @return void
     */

    function handleError($moveTo, $errorCode)
    {
        switch ($moveTo) {
            case 'anmeldungBefrager':
                $GETString = '?befrager=Befrager&error=' . $errorCode;
                $this->moveToPage('index.php', $GETString);
                break;

            case 'anmeldungStudent':
                $GETString = '?student=Student&error=' . $errorCode;
                $this->moveToPage('index.php', $GETString);
                break;

            case 'neuerFragebogen':
                $GETString = '?error=' . $errorCode;
                $this->moveToPage('neuerFragebogen.php', $GETString);
                break;

            case 'fragenErstellen':
                $GETString = $errorCode;
                $this->moveToPage('FragenErstellen.php', $GETString);
                break;

            case 'kurseFreischalten':
                $GETString = '?error=' . $errorCode;
                $this->moveToPage('FreischaltungKurs.php', $GETString);
                break;

            case 'fragebogenKopieren':
                $GETString = '?error=' . $errorCode;
                $this->moveToPage('FragebogenKopieren.php', $GETString);
                break;

            case 'neuerKurs':
                $GETString = '?error=' . $errorCode;
                $this->moveToPage('neuerKurs.php', $GETString);
                break;

            case 'neueMatrikelnummer':
                $GETString = '?error=' . $errorCode;
                $this->moveToPage('neuerStudent.php', $GETString);
                break;

            case 'fragebogenLoeschen':
                $GETString = '?error=' . $errorCode;
                $this->moveToPage('FragebogenLoeschen.php', $GETString);
                break;
            case 'einzelneFrageLoeschen':
                $GETString = $errorCode;
                $this->moveToPage('FragebogenBearbeiten.php', $GETString);
                break;
            case 'einzelneFrageHinzufügen':
                $GETString = $errorCode;
                $this->moveToPage('FragebogenBearbeiten.php', $GETString);
                break;
            case 'auswertung':
                $GETString = $errorCode;
                $this->moveToPage('Auswertung.php', $GETString);
                break;
            case 'abschliessen':
                $GETString = $errorCode;
                $this->moveToPage('BeantwortenAbschliessen.php', $GETString);
                break;
            case 'menueStudent':
                $GETString = '?error=' . $errorCode;
                $this->moveToPage('MenuStudent.php', $GETString);
                break;
            case 'richtigeMatrikelnummer':
                $GETString = '?error=' . $errorCode;
                $this->moveToPage('neuerStudent.php', $GETString);
                break;
            case 'andererBefrager':
                $GETString = '?error=' . $errorCode;
                $this->moveToPage('menuBefrager.php', $GETString);
                break;
        }
    }

    /**
     * @author Johannes Scheffold
     * 
     * Hilfsfunktion, macht das handling von Infos einfacher
     * 
     * @param $moveTo Code, sagt wo die Info angezeigt werden soll.
     * @param $infoCode, dieser Code wird als parameter im Link mitangegeben und kann auf einzelnen Pages abgefragt werden (Info-Boxen)
     * @return void
     */
    protected function handleInfo($moveTo, $infoCode)
    {
        switch ($moveTo) {

            case "anmeldungBefrager":
                $GETString = '?befrager=Befrager' . '&info=' . $infoCode;
                $this->moveToPage('index.php', $GETString);
                break;

            case "fragebogenErstellt":
                $GETString = '?info=' . $infoCode;
                $this->moveToPage('menuBefrager.php', $GETString);
                break;

            case "kurseFreischalten":
                $GETString = '?info=' . $infoCode;
                $this->moveToPage('FreischaltungKurs.php', $GETString);
                break;

            case "fragebogenKopieren":
                $GETString = '?info=' . $infoCode;
                $this->moveToPage('menuBefrager.php', $GETString);
                break;

            case "neuerKurs":
                $GETString = '?info=' . $infoCode;
                $this->moveToPage('menuBefrager.php', $GETString);
                break;

            case "neuerStudent":
                $GETString = '?info=' . $infoCode;
                $this->moveToPage('menuBefrager.php', $GETString);
                break;

            case "fragebogenLoeschen":
                $GETString = '?info=' . $infoCode;
                $this->moveToPage('menuBefrager.php', $GETString);
                break;
            case "einzelneFrageLoeschen":
                $GETString = $infoCode;
                $this->moveToPage('FragebogenBearbeiten.php', $GETString);
                break;
            case 'einzelneFrageHinzufügen':
                $GETString = $infoCode;
                $this->moveToPage('FragebogenBearbeiten.php', $GETString);
                break;
            case 'abschliessen':
                $GETString = $infoCode;
                $this->moveToPage('BeantwortenAbschliessen.php', $GETString);
                break;
            case "MenuStudent":
                $GETString = '?info=' . $infoCode;
                $this->moveToPage('MenuStudent.php', $GETString);
                break;
        }
    }

    /**
     * @author Johannes Scheffold
     * 
     * Hilfsfunktion, macht das navigieren zwischen den pages leichter
     * 
     * @param $pageName (zur welcher Page navigiert werden soll)
     * @param $suffix (optional) wird verwendet, wenn im Link noch Parameter angegeben werden sollen. 
     * @return void
     */
    protected function moveToPage($pageName, $suffix = '')
    {
        // Redirect auf eine andere Seite im aktuell angeforderten Verzeichnis 
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/$pageName$suffix");
    }
}
