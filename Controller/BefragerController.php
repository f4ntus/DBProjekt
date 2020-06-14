<?php
/**
* @author Christoph Böhringer, Lukas Schick
* Diese Klasse beinhaltet die Business-Logik auf der Befragerseite.
*
*/

require 'GlobalFunctions.php';
class BefragerController extends GlobalFunctions
{

    /**
     * @author Christoph Böhringer
     * Diese Funktion ruft alle erstellten Fragebögen des angemeldeten Befragers auf und gibt diese zurück.
     *
     * @param $recentUser
     * @return string $tableString
     */
    public function createInnerTableBefrager($benutzername)
    {

        $sqlObject = $this->tblFragebogen->selectRecords($benutzername);
        $tableString = '';
        while ($row = $sqlObject->fetch_object()) {
            $tableString = $tableString . '<tr> <td>' . $row->FbNr . '</td><td>' . $row->Titel . '</td></tr>';
        }
        return $tableString;
    }

    /**
     * @author Christoph Böhringer
     * Dient zur Erstellung der einzelnen Fragefelder nach der Anzahl der eingegebenen Fragen.
     *
     * @param $anzFragen
     * @return string $frageString 
     */
    public function createFrageFelder($anzFragen)
    {

        $frageString = '';

        for ($i = 1; $i <= $anzFragen; $i++) {
            $frageString = $frageString . $i . " " . "<input type ='text' name ='fragetext" . $i . "'>" . "</br> </br>";
        }

        return $frageString;
    }

    /**
     * @author Christoph Böhringer
     * Speichert die einzelnen Fragen in der Datenbank.
     *
     * @param $fbnr
     * @param $anzFragen
     * @param $post
     * @param $titel
     * @return void 
     */
    public function createFragen($fbnr, $anzFragen, $post, $titel)
    {

        for ($fnr = 1; $fnr <= $anzFragen; $fnr++) {
            $postArrayName = 'fragetext' . $fnr;
            $fragetext = $post[$postArrayName];

            //Prüfung, ob gleiche Frage vorhanden. Eine Frage darf nur einmal im Fragebogen vorkommen.
            for ($fnr1 = 1; $fnr1 < $anzFragen; $fnr1++) {

                if ($fnr == $fnr1) {
                    $fnr1++;
                }
                $postArrayName1 = 'fragetext' . $fnr1;
                $fragetext1 = $post[$postArrayName1];
                if ($fragetext == $fragetext1) {
                    $suffixString = '?AnzahlFragen=' . $anzFragen . '&Fbnr=' . $fbnr . '&Titel=' . $titel . '&error=gleicheFrage';
                    $this->handleError('fragenErstellen', $suffixString);
                    exit;
                }
            }
            //Prüfung ob Frage leer
            if ($fragetext == '') {
                $suffixString = '?AnzahlFragen=' . $anzFragen . '&Fbnr=' . $fbnr . '&Titel=' . $titel . '&error=leereFrage';
                $this->handleError('fragenErstellen', $suffixString);
                exit;
            }

            $this->tblFrage->insertRecord($fbnr, $fnr, $fragetext);
        }
        $this->handleInfo('fragebogenErstellt', 'fb_erstellt');
    }
    /**
     * @author Christoph Böhringer
     * Speichert den Fragebogen in der Datenbank
     *
     * @param $titel
     * @param $benutzername
     * @param $anzFragen
     * @return void 
     */
    public function controllTitelFragebogen($titel, $benutzername, $anzFragen)
    {
        //Prüfung ob Titel = leer
        if ($titel == '') {
            $this->handleError('neuerFragebogen', 'leererTitel');
            exit;
        }
        $sqlObject = $this->tblFragebogen->selectUniqueRecordByTitel($titel);
        //Prüfung ob Titel bereits vorhanden
        if (is_null($sqlObject)) {
            if ($anzFragen <= 0) {
                $this->handleError('neuerFragebogen', 'keineFragen');
                exit;
            } else {
                $sqlResult = $this->tblFragebogen->insertRecord($titel, $benutzername);
                if ($sqlResult != 'error') {
                    $suffixString = '?AnzahlFragen=' . $anzFragen . '&Fbnr=' . $sqlResult . '&Titel=' . $titel;
                    $this->moveToPage('FragenErstellen.php', $suffixString);
                } else {
                    $this->handleError('neuerFragebogen', 'sqlError');
                }
            }
        } else {
            $this->handleError('neuerFragebogen', 'titleInUse');
        }
    }

    /**
     * @author Christoph Böhringer
     * Schaltet den ausgewählten Fragebogen für den jeweiligen Kurs frei.
     *
     * @param $fragebogen
     * @param $kurs
     * @return void 
     */
    public function freischaltenKurs($fragebogen, $kurs)
    {
        $fbnr = $this->tblFragebogen->selectUniqueRecordByTitel($fragebogen)->FbNr;
        $sqlObject = $this->tblFreigeschaltet->insertRecord($fbnr, $kurs);
        if ($sqlObject != 'success') {
            $this->handleError('kurseFreischalten', 'sqlError');
        } else $this->handleInfo('kurseFreischalten', 'freigeschalten');
    }

    /**
     * @author Christoph Böhringer
     * Funktion für das Auflisten von bereits freigeschalteten Kursen eines ausgewählten Fragebogens.
     *
     * @param  $fragebogen
     * @return string 
     */
    public function showBereitsFreigeschaltet($fragebogen)
    {
        $fbnr = $this->tblFragebogen->selectUniqueRecordByTitel($fragebogen)->FbNr;
        $sqlObject = $this->sqlWrapper->selectBereitsFreigeschaltet($fbnr);
        $freigeschaltetString = '';
        while ($row = $sqlObject->fetch_object()) {
            $freigeschaltetString = $freigeschaltetString . $row->Name . "</br>";
        }
        if ($freigeschaltetString == '') {
            $freigeschaltetString = 'Es wurden noch keine Kurse freigeschalten.';
        }
        return "<br> <p>Liste der bereits freigegebenen Kurse für den Fragebogen " . $fragebogen . ":</p>" . $freigeschaltetString;
    }

    /**
     * @author Christoph Böhringer
     * Erzeugt ein Dropdownmenü von bereits angelegten Fragebogen eines Befragers.
     *
     * @param $benutzername
     * @return string $dropdownString 
     */
    public function createDropdownFragebogen($benutzername)
    {

        $sqlObject = $this->tblFragebogen->selectRecords($benutzername);
        $dropdownString = '';

        while ($row = $sqlObject->fetch_object()) {
            $dropdownString = $dropdownString . "<option>" . $row->Titel . "</option>";
        }

        return $dropdownString;
    }

    /**
     * @author Christoph Böhringer
     * Erzeugt ein Dropdownmenü von angelegten Kursen.
     *
     * @return string $dropdownString 
     */
    public function createDropdownKurs()
    {
        $sqlObject = $this->tblKurs->selectRecords();
        $dropdownString = '';

        while ($row = $sqlObject->fetch_object()) {
            $dropdownString = $dropdownString . "<option>" . $row->Name . "</option>";
        }

        return $dropdownString;
    }

    /**
     * @author Christoph Böhringer
     * Dient zum Kopieren eines bereits angelegten Fragebogens.
     *
     * @param $benutzername
     * @param $alterTitel
     * @param $copyTitel
     * @return void 
     */
    public function fragebogenKopieren($benutzername, $alterTitel, $copyTitel)
    {
        $alteFbNr = $this->tblFragebogen->selectUniqueRecordByTitel($alterTitel)->FbNr;
        $checkTitle = $this->tblFragebogen->selectUniqueRecordByTitel($copyTitel);
        if (is_null($checkTitle)) {
            $neueFbNr = $this->tblFragebogen->insertRecord($copyTitel, $benutzername);
            $sqlObject1 = $this->tblFrage->selectRecords($alteFbNr);
            $fnr = 1;
            while ($frage = $sqlObject1->fetch_object()) {
                $fragetext = $frage->Fragetext;
                $sqlObject = $this->tblFrage->insertRecord($neueFbNr, $fnr, $fragetext);
                if ($sqlObject != 'success') {
                    $this->handleError('fragenKopieren', 'sqlError');
                    exit;
                }
                $fnr++;
            }
            $this->handleInfo('fragebogenKopieren', 'kopiert');
        } else {
            $this->handleError('fragebogenKopieren', 'titleInUse');
        }
    }

/** 
 * @author Lukas Schick
 * Die Methode überprüft den Namen eines eingegebenen Kurses, ob dieser schon existiert.
 * Wenn nicht, wird der Datensatz importiert.
*/
public function controllNameKurs()
    {

        $name = $_POST["kursname"];
        $sqlObject = $this->tblKurs->selectUniqueRecord($name);
        if (is_null($sqlObject)) {
            $neuerKurs = $this->tblKurs->insertRecord($name);
            $this->handleInfo('neuerKurs', 'kursErstellt');
        } else {
            $this->handleError('neuerKurs', 'nameInUse');
        }
    }

    /**
     * @author Christoph Böhringer
     * Löscht den gesamten Fragebogen inklusive Fragen.
     *
     * @param $titel
     * @return void 
     */
    public function fragebogenLoeschen($titel)
    {
        $fbnr = $this->tblFragebogen->selectUniqueRecordByTitel($titel)->FbNr;
        $sqlObject = $this->tblFragebogen->deleteRecord($fbnr);
        if ($sqlObject != 'success') {
            $this->handleError('fragebogenLoeschen', 'sqlError');
        } else {
            $this->handleInfo('fragebogenLoeschen', 'geloescht');
        }
    }

    /**
     * @author Christoph Böhringer
     * Navigiert zu ausgewähltem Fragebogen der bearbeitet werden soll und gibt die Fragebogennummer mit.
     *
     * @param $titel
     * @return void 
     */
    public function fragebogenBearbeiten($titel)
    {
        $fbnr = $this->tblFragebogen->selectUniqueRecordByTitel($titel)->FbNr;
        $suffixString = '?fbnr=' . $fbnr;
        $this->moveToPage('FragebogenBearbeiten.php', $suffixString);
    }

    /**
     * @author Christoph Böhringer
     * Zeigt vom ausgewählten Fragebogen alle Fragen an mit der Option sie zu löschen.
     *
     * @param $fbnr
     * @return string $tableString 
     */
    public function fragenAnzeigenBearbeiten($fbnr)
    {

        $sqlObject = $this->tblFrage->selectRecords($fbnr);
        $tableString = '';
        while ($row = $sqlObject->fetch_object()) {
            $tableString = $tableString . "<tr> 
            <td>" . $row->FNr . "</td>
            <td>" . $row->Fragetext . "</td>
            <td> <button type='submit' name='frage_loeschen' value='" . $row->FNr . "'>Löschen</button></td>
            </tr>";
        }
        return $tableString;
    }

    /**
     * @author Christoph Böhringer
     * Löscht die ausgewählte Frage und sortiert die Fragen neu.
     *
     * @param $fnr
     * @param $fbnr
     * @return void
     */
    public function einzelneFrageLoeschen($fnr, $fbnr)
    {
        $sqlObject = $this->tblFrage->deleteRecord($fnr, $fbnr);
        if ($sqlObject == "success") {
            $this->sortFragen($fbnr, $fnr);
        } else {
            $suffixString = '?fbnr=' . $fbnr . '&error=sqlError';
            $this->handleError('einzelneFrageLoeschen', $suffixString);
        }
    }

    /**
     * @author Christoph Böhringer
     * Funktion für das Neusortieren der Fragen, nachdem eine einzelne Frage gelöscht wurde.
     *
     * @param $fbnr
     * @param $fnr
     * @return void
     */
    public function sortFragen($fbnr, $fnr)
    {
        $sqlObject = $this->tblFrage->selectRecords($fbnr, $fnr);
        while ($row = $sqlObject->fetch_object()) {
            $fragetext = $row->Fragetext;
            $update = $this->tblFrage->updateRecord($fbnr, $fnr, $fragetext);
            if ($update !== "success") {
                $suffixString = '?fbnr=' . $fbnr . '&error=sqlError';
                $this->handleError('einzelneFrageLoeschen', $suffixString);
                exit;
            } else {
                $suffixString = '?fbnr=' . $fbnr . '&info=frage_geloescht';
                $this->handleInfo('einzelneFrageLoeschen', $suffixString);
            }
            $fnr++;
        }
    }

    /**
     * @author Christoph Böhringer
     * Funktion für das Hinzufügen einer neuen Frage am Ende des Fragebogens.
     *
     * @param $fbnr
     * @param $fragetext
     * @return void
     */
    public function einzelneFrageHinzufügen($fbnr, $fragetext)
    {
        $maxFnr = $this->tblFrage->maxRecord($fbnr)->maxFnr;
        $neueFnr = $maxFnr + 1;
        //Prüfung ob gleiche Frage
        for ($fnr1 = 1; $fnr1 <= $maxFnr; $fnr1++) {
            $fragetext1 = $this->tblFrage->selectUniqueRecord($fbnr, $fnr1)->Fragetext;
            if ($fragetext == $fragetext1) {
                $suffixString = $suffixString = '?fbnr=' . $fbnr . '&error=gleicheFrage';
                $this->handleError('einzelneFrageHinzufügen', $suffixString);
                exit;
            }
        }
        //Prüfung ob Frage leer
        if ($fragetext == '') {
            $suffixString = $suffixString = $suffixString = '?fbnr=' . $fbnr . '&error=leereFrage';
            $this->handleError('einzelneFrageHinzufügen', $suffixString);
            exit;
        }
        $sqlObject = $this->tblFrage->insertRecord($fbnr, $neueFnr, $fragetext);
        if ($sqlObject == "success") {
            $suffixString = '?fbnr=' . $fbnr . '&info=frage_hinzugefügt';
            $this->handleInfo('einzelneFrageHinzufügen', $suffixString);
        } else {
            $suffixString = '?fbnr=' . $fbnr . '&error=sqlError';
            $this->handleError('einzelneFrageHinzufügen', $suffixString);
        }
    }

   /** 
 * @author Lukas Schick
 * Die Methode überprüft eine eigegebene Matrikelnummer, ob sie numerisch ist und ob sie bereits existiert.
 * Wenn sie noch nicht existiert, wird die Matrikelnummer mit dem zugehörigen Kurs in die Datenbank importiert.
*/
public function controllMatrikelnummer()
    {

        $matrikelnummer = $_POST["matrikelnummer"];

        if (is_numeric($matrikelnummer)) {
            $sqlObject = $this->tblStudent->selectUniqueRecord($matrikelnummer);
            if (is_null($sqlObject)) {
                $name = $_POST["Kurs"];
                $neuerStudent = $this->tblStudent->insertRecord($matrikelnummer, $name);
                $this->handleInfo('neuerStudent', 'studentErstellt');
            } else {
                $this->handleError('neueMatrikelnummer', 'matrikelnummerInUse');
            }
        } else {
            $this->handleError('richtigeMatrikelnummer', 'matrikelnummerNotNumeric');
        }
    }


/** 
 * @author Lukas Schick
 * Die Methode speichert alle Fragebögen, die vom angemeldeten Nutzer freigeschalten wurden und gibt die Titel in einem String zurück
 * 
 * @param $recentUser
 * @return string $dropdownString
*/
public function createDropdownFreigeschaltet($recentUser)
    {

        $sqlObject = $this->tblFreigeschaltet->selectRecordsFreigeschaltet($recentUser);
        $dropdownString = '';
        while ($row = $sqlObject->fetch_object()) {
            $dropdownString = $dropdownString . "<option>" . $row->Titel . "</option>";
        }
        return $dropdownString;
    }

/** 
 * @author Lukas Schick
 * Die Methode speichert alle freigechalteten Kurse zu einer FragebogenNr und gibt die Namen in einem String zurück
 * 
 * @param $fbnr
 * @return string $dropdownString
*/
public function selectKurseZuFragebogen($fbnr)
    {

        $sqlObject = $this->tblFreigeschaltet->selectRecordsByFragebogenNr($fbnr);


        $dropdownString = "";
        while ($row = $sqlObject->fetch_object()) {
            $dropdownString = $dropdownString . "<option>" . $row->Name . "</option>";
        }
        return $dropdownString;
    }

/** 
 * @author Lukas Schick
 * Diese Funktion speichert die FragebogenNr zu einem gegebenen Fragebogentitel in einer Variable und schreibt die FragebogenNr in die URL
 * 
 * @param $titel
 * @return void
*/
    public function fragebogenAuswählen($titel)
    {
        $fbnr = $this->tblFragebogen->selectUniqueRecordByTitel($titel)->FbNr;
        $suffixString = '?fbnr=' . $fbnr;
        $this->moveToPage('Auswertung.php', $suffixString);
    }

/** 
 * @author Lukas Schick
 * Diese Funktion gibt die Berechnung von Durchschnitt, Maximalwert und Minimalwert in einem String zurück
 * 
 * @param $fbnr
 * @param $kurs
 * @return string $tableString
*/
public function auswertungAnzeigen($fbnr, $kurs)
    {
        $sqlObject = $this->tblAuswertung->selectRecordsAuswertung($fbnr, $kurs);
        if ($sqlObject->num_rows != 0) {
            $tableString = '';
            while ($row = $sqlObject->fetch_object()) {
                $tableString = $tableString . "<tr> 
                <td>" . $row->FNr . "</td>
                <td>" . $row->Fragetext . "</td>
                <td>" . $row->Durchschnitt . "</td>
                <td>" . $row->Maximal . "</td>
                <td>" . $row->Minimal . "</td>
                <td>" . $this->auswertungStandardabweichung($fbnr, $kurs, $row->FNr) . "</td>
                </tr>";
            }
            return $tableString;
        } else {
            $suffixString = '?fbnr=' . $fbnr . '&error=noValues';
            $this->handleError('auswertung', $suffixString);
        }
    }

/** 
 * @author Lukas Schick
 * Diese Funktion gibt alle Kommentare zu einer gegebenen FragebogenNr und einem gegebenen Kurs in einem String zurück
 * 
 * @param $fbnr
 * @param $kurs
 * @return string $tableString
*/
public function kommentareAnzeigen($fbnr, $kurs)
    {
        $sqlObject = $this->tblAuswertung->selectRecordsKommentare($fbnr, $kurs);

        $tableString = '';
        while ($row = $sqlObject->fetch_object()) {
            $tableString = $tableString . $row->Kommentar . "</br></br>";
        }
        return $tableString;
    }

/** 
 * @author Lukas Schick
 * Diese Funktion gibt die Standardabweichung mit einem Array zurück, in dem die Werte zu einer Frage enthalten sind
 * 
 * @param $fbnr
 * @param $kurs
 * @param $fnr
 * @return string $tableString
*/
public function auswertungStandardabweichung($fbnr, $kurs, $fnr)
    {
        $werte = array();
        $sqlObject = $this->tblAuswertung->selectRecordsStandardabweichung($fbnr, $kurs, $fnr);
        while ($row = $sqlObject->fetch_object()) {
            array_push($werte, $row->BewertungSW);
        }
        if (!empty($werte)) {
            return $this->standardabweichung($werte);
        } else {
            return '';
        }
    }

/** 
 * @author Lukas Schick
 * Diese Funktion berechnet die Standardabweichung mithilfe des gegebenen Arrays
 * 
 * @param $werte
 * @return float $stdabw
*/
function standardabweichung($werte)
    {
        $avg = array_sum($werte) / count($werte);

        $sum = 0;
        foreach ($werte as $wert) {
            $sum += pow($wert - $avg, 2);
        }

        $stdabw = sqrt($sum / count($werte));

        return Round($stdabw, 2);
    }
    

    /**
     * @author Christoph Böhringer
     * Prüfung ob ein Befrager angemeldet ist und ob er Zugriff auf einen bestimmten Fragebogen hat.
     *
     * @param $fbnr
     * @return void
     */
    public function pruefeBefrager($fbnr = '')
    {
        if (!isset($_SESSION['befrager'])) {
            $this->handleError('anmeldungBefrager', 'notLoggedIn');
        }
        if ($fbnr != '') {
            $benutzername = $this->tblFragebogen->selectUniqueRecordByFbNr($fbnr)->Benutzername;
            if ($benutzername != $_SESSION['befrager'])
                $this->handleError('andererBefrager', 'andererBefrager');
        };
    }
}
