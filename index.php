<!DOCTYPE html>

<body>
    <html>
    <form method="post" action="<?php $_PHP_SELF ?>">
        <h1>Login</h1>
        </br>
        Benutzername:
        <input type="text" name="benutzername">
        </br>
        </br>
        Passwort:
        <input type="password" name="kennwort" required>
        </br>
        </br>

        <input type="submit" name="anmelden" value="Anmelden" />
        <input type="submit" name="registrieren" value="Registrieren" />
        </br>
        </br>

        <?php
        require 'PostController.php';
        $postController = new PostController();
        $postController->controllAnmeldung($_POST);
        $postController = NULL;
        /*$dbhost = "localhost";
        $dbuser = "root";
        $dbpassword = "";
        $db = "befragungstool";

        $benutzername = $_POST["benutzername"];
        $kennwort = $_POST["kennwort"];

        $db = new MySQLi($dbhost, $dbuser, $dbpassword, $db);

        $sql = "INSERT INTO tbl_befrager (Benutzername, Kennwort) VALUES ('$benutzername', '$kennwort')";

        if ($db->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }


        $db->close(); */
        ?>
    </form>

</body>

</html>