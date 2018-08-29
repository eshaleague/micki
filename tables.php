<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Start the session
session_start();
if (!isset($_SESSION['u_username'])) {
	header("Location: ./index.php");
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Menu</title>
<link href="./css/menu.css" type="text/css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Ubuntu+Condensed" rel="stylesheet">
</head>
<body>
<div class='menu-wrapper'>
<?php
include "./include/dbh.inc.php";
$tables = "SELECT id, tableName, colorOne, colorTwo, textColor,image, editName FROM alltables ORDER BY id desc";
$resulttables = $conn->query($tables);

if ($resulttables->num_rows > 0) {
	while($row = $resulttables->fetch_assoc()) {
		$background = 'url("'.$row["image"].'")';
		echo "<a target='_blank' href='./table.php?value=".$row["tableName"]."'><div class='menu-table' style='background-size: cover; background-repeat: no-repeat; background-image:".$background .";'><div class='menu-title' style='background-color:".$row["colorOne"]."'>".$row["editName"]."</div></div></a>" ;
	} 
}
?>
</div>
<?php 
if ($_SESSION['u_username'] === "bryanling"){
	echo'<form method="post" action="./include/createtable.inc.php" >
<input type="hidden" name="formid" value="hi">
<input type="submit" value="+">
</form>';
}

?>

</body>
</html>