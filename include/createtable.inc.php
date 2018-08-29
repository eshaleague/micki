<?php 
session_start();
/*connect to server*/
$tableNames = "allTables";
include "../include/dbh.inc.php";
$tableName = $colorOne = $colorTwo = $textColor = $image = "";
if($conn->connect_error){
die($conn->connect_error); 
}

$_SESSION["formid"] = '';
$tables = "SELECT tableName, colorOne, colorTwo, textColor,image, editName FROM ".$tableNames;
$resulttables = $conn->query($tables);
//generate key
$key = md5(microtime().rand());
$last_id = $key ;
$sql = "INSERT INTO alltables (tableName, colorOne, colorTwo, textColor, image, editName)
VALUES ('".$last_id ."','#1F3A93','#3A539B','#ffffff','http://benoitfelten.com/wp-content/uploads/2013/01/06012013-IMG_1023.jpg','untitled')";

if ($conn->query($sql) === TRUE) {
$sqw = "CREATE TABLE `".$last_id."` (
id INT(11) not null PRIMARY KEY AUTO_INCREMENT,
question VARCHAR(252),
answer VARCHAR(252),
date TIMESTAMP,
questionimage VARCHAR(252),
answerimage VARCHAR(252),
reorder INT(11)
)";

if ($conn->query($sqw) === TRUE) {
$sqr = "INSERT INTO ".$last_id ."(question, answer, reorder) VALUES ('!@#title!@#','This is a TITLE', 1);";
$sqr .= "INSERT INTO ".$last_id ."(question, answer, reorder) VALUES ('!@#header!@#','This is a HEADING', 2);";
$sqr .= "INSERT INTO ".$last_id ."(question, answer, reorder) VALUES ('data','data', 3)";
if ($conn->multi_query($sqr) === TRUE) {
} 
else {
echo "Error creating table: " . $conn->error;
}
}


} 
else {
echo "Error: " . $sql . "<br>" . $conn->error;
}
header("Location: ../tables.php");

?>