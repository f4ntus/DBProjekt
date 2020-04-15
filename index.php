<!DOCTYPE html>
<body> <html>
<form method="post" action="http://vorlesungen.kirchbergnet.de/inhalte/DB-PR/output_posted_vars.php">
  <h1>Login</h1>
    </br>
    Benutzername: 
        <input type="text" name="benutername">
            </br>
            </br>
    Passwort: 
        <input type="password" name="passwort" required>   
            </br>
            </br>
  
  <input type="submit" name="anmelden" value="Anmelden"/>
  <input type="submit" name="registrieren" value="Registrieren"/>
            </br>
            </br>

    <?php
            $servername = "localhost";
            $username = "root";
            $password = "";

            // Create connection
            $conn = new mysqli($servername, $username, $password);

            // Check connection
         if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
            }
        echo "Connected successfully";
    ?>
</form>

</body> </html>

