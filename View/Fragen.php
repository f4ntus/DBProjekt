<!DOCTYPE html>
<?php
session_start();
require '../Controller/StudentController.php';
$studentController = new StudentController();
$anzFragen = $studentController->anzahlSeitenProFB();
?>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Fragen</title>
</head>

<body>
    <div class="SeiteFrage">
        <div class="Aktuelle Seite">
            <h4>Aktuelle Frage:
                <?php echo $_GET["Frage"]; ?> </h4>

            <?php
            echo "Inhalt der Frage ";
            echo $_GET["Frage"] . " von " . $anzFragen;
            ?>
            <br><br><br><br>
        </div>

        <div class="AktuelleFrage">
            <h2><?php echo $studentController->showFrage($_GET["Fragebogen"],$_GET["Frage"]); ?></h2> 
           </br></br>    
           
           <form action="" method="POST">
                    
                <input type="radio" name="bewertung" value="1"> 1
                <input type="radio" name="bewertung" value="2"> 2
                <input type="radio" name="bewertung" value="3"> 3
                <input type="radio" name="bewertung" value="4"> 4 
                <input type="radio" name="bewertung" value="5"> 5 
                <input type="submit" name="bsubmit" value="Next">
                
            </form>
            <form action="" method="POST">
                <name="bnext" value="Next" />
            </form>
            
            <?php 
            /* ich hab keine Ahnung was das soll 
            require_once 'Auswertung.php';
                    if(isset($_GET['rating'])) {
                        $result = $studentController->FrageBewerten();
                        echo $result;
                    }*/
            ?>
        </div>
    </div>


</body>

</html>


