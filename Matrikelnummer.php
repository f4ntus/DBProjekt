<!DOCTYPE html>
<html> 
<head>
        <title>Matrikelnummer</title>
</head>
<body>

<form method="POST" action="">    
        
Matrikelnummer:
        <input type="text" name="matrikelnummer">
        <input type="submit" name="absenden" value="absenden">
</form>
</br>

</body>

</html>


<?php



/*if(isset($_POST['absenden'])){
$Matrikelnummer = $_POST["matrikelnummer"]; 
$sqlWrapper->student($Matrikelnummer);
}
*/
?>


<table border='8' cellpadding='20'><tr><th>FragebogenNr</th><th>Titel</th>
  <?php 
  require ('PostController.php');
  $postController = new PostController();
  
  echo $postController->createInnerTable();
  ?>             
</table>



