<?php
session_start();
$tableName = $_SESSION['tableName'];
if (isset($_POST['edit'])) {
	$tableName = $_POST['table'];
	$nameEdit = $_POST['tableName'];
	$colorOne = $_POST['colorOne'];
	$image = $_POST['image'];

	include "./dbh.inc.php";
	$sql = "UPDATE alltables SET editName='".$nameEdit."', colorOne='".$colorOne."',  image='".$image."' WHERE tableName = '".$tableName."'";
	mysqli_query($conn, $sql);
	header("Location: ../table.php");
}