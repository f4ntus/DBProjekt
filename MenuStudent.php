<html> 
<head>
<title>MenüStudent</title>
</head>
<body>

<?php


$host = "localhost"; 
$user= "root";
$password = "";
$db = "befragungstool";
$db = new MySQLi($host, $user, $password, $db);

$q = $db->query("SELECT * FROM tbl_fragebogen");


echo "<table><tr><th>FragebogenNr</th><th>Titel</th>";

while($row = $q->fetch_assoc()) { 
    echo "<tr>";
    echo "<td>" . $row['FbNr'] . "</td>";
    echo "<td>" . $row['Titel'] . "</td>";
    echo "</tr>";

} 

echo "</table>"





?>
</body>
</html>
