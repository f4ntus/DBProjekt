<!DOCTYPE html>
<?php
session_start();
require '../Controller/StudentController.php';
$studentController = new StudentController();
?>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Fragen</title>
</head>

<body>
    <?php if ((isset($_POST["bnext"]) == false)) {
        $_SESSION["aktfrage"] = 0;
    }

    $_SESSION["anzfragen"] = $studentController->anzahlSeitenProFB();

    

    if(isset($_POST["bnext"]) == true)
        $_SESSION["aktfrage"]++;
    
?>
    <div class="SeiteFrage">
        <div class="Aktuelle Seite">
            <h4>Aktuelle Frage:
                <?php echo $_SESSION["aktfrage"] + 1; ?> </h4>

            <?php
            echo "Inhalt der Frage ";
            echo $_SESSION["aktfrage"] + 1 . " von " . $_SESSION["anzfragen"];
            ?>
            <br><br><br><br>
        </div>

        <div class="AktuelleFrage">
            <?php for ($i = 0; $i <= $_SESSION["anzfragen"]; ++$i) {
                if ($i == ($_SESSION["aktfrage"]))
                    echo $studentController->showFragen();
                    
                    
                      
            } ?>
           </br></br>    
           
           
            
            <form action="" method="POST">
                <input type="submit" <?php
                    if ($_SESSION["aktfrage"] + 1 == $_SESSION["anzfragen"])
                        echo " disabled ";
                    ?> name="bnext" value="Next" />
            </form>

            <?php require_once 'Auswertung.php';
                    if(isset($_GET['rating'])) {
                        $result = $studentController->FrageBewerten();
                        echo $result;
                    }
            ?>
            
        
            
            
            
           
            
        
        
        </div>
    </div>


</body>

</html>


