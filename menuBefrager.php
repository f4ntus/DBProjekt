<!DOCTYPE html>
<html>
                <h1>Hallo Gregory Peck!</h1>
        <form>
                <input action ="neuerFragebogen.php" type="button" name="fb_neu" value=" + Neuen Fragebogen erstellen" />
        </form>

        <p>Übersicht Ihrer bereits erstellen Fragebögen:</p>
</html>








<?php
require 'SqlWrapper.php';
$sqlWrapper = new SqlWrapper();
$db_erg = $sqlWrapper->selectAlleFrageboegen();
  echo $db_erg;
?>