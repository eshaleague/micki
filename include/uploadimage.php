<?php
session_start();
$tableName = $_SESSION['tableName'];
$target_dir = "../images/";
$filenameorigin = $_FILES["file"]["name"];
$fileTMP = $_FILES["file"]["tmp_name"];
$fileEXT = explode(".", $filenameorigin);
$fileACTEXT = strtolower(end($fileEXT));
$filename = uniqid('', true).".".$fileACTEXT;
$fileDestination = "../images/".$filename;
move_uploaded_file($fileTMP, $fileDestination);

include "./dbh.inc.php";
$id = $_POST['id'];
$type = $_POST['type']."image";
$sql = "UPDATE $tableName SET ".$type."='".$filename ."' WHERE id = ".$id;
mysqli_query($conn, $sql);
header("Location: ../table.php");




?>