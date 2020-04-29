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
        $_SESSION["aktseite"] = 0;
    }

    $_SESSION["anzseiten"] = $studentController->anzahlSeitenProFB();


    if (isset($_POST["bnext"]) == true) {
        $_SESSION["aktseite"]++;
    }

    ?>

    <div class="SeiteFrage">
        <div class="Aktuelle Seite">
            <h4>Aktuelle Frage:
                <?php echo $_SESSION["aktseite"] + 1; ?> </h4>

            <?php
            echo "Inhalt der Frage ";
            echo $_SESSION["aktseite"] + 1 . " von " . $_SESSION["anzseiten"];
            ?>
            <br><br><br><br>
        </div>

        <div class="AktuelleFrage">
            <?php for ($i = 0; $i <= $_SESSION["anzseiten"]; ++$i) {
                if ($i == ($_SESSION["aktseite"]))
                    echo $studentController->showFragen();
            } ?>
            

            <form action="" method="POST">
                <input type="submit" <?php
                    if ($_SESSION["aktseite"] + 1 == $_SESSION["anzseiten"])
                        echo " disabled ";
                    ?> name="bnext" value="Next" />

            </form>


        </div>
    </div>


</body>

</html>


