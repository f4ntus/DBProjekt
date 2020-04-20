<!DOCTYPE html>
<html> 
<head>
        <title>Matrikelnummer</title>
</head>
<body>


</body>

</html>


<?php
session_start();
require ('PostController.php');
$postController = new PostController();
?>
<h1><?php echo "Hallo" . " " . $_SESSION['student'];?></h1>

<p>Diese Fragebögen sind für Sie freigeschaltet:</p>
<table border='8' cellpadding='20'><tr><th>FragebogenNr</th><th>Titel</th>

<?php 
 echo $postController->createInnerTable();      
  


?> 

</table>



