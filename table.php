<?php
session_start();
//get from menu
if (!isset($_SESSION['u_username'])) {
	header("Location: ./index.php");
}

if(isset($_GET['value'])){
	$main = $_GET['value'];
}else{
	$main = $_SESSION['tableName'];
}
include"./include/dbh.inc.php";
$tableName = $colorOne = $colorTwo = $textColor = $image = $editName ="";
$sql = "SELECT * FROM alltables WHERE tableName = '$main'";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)){
	$tableName = $row['tableName'];
	$colorOne = $row['colorOne'];
	$colorTwo = $row['colorTwo'];
	$textColor = $row['textColor'];
	$image = $row['image'];
	$editName = $row['editName'];

}

$_SESSION['tableName'] = $tableName;



?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	

</head>
<body>
<style>
body{
	background-color: #ccc;
	background-image: url(<?php echo '"'.$image.'"'; ?>);
	background-size: cover;
	background-position: center center;
	background-attachment: fixed;
}
.bg-color-one{
	background-color: <?php echo $colorOne ?>;
	border-color: <?php echo $colorOne ?>;
}
.bg-color-border{
	border-color: <?php echo $colorOne ?>;
}
</style>
<br>

<div class="button-questions bg-color-one"><div class='button-show-active'></div></div>
<div class="button-answers bg-color-one"><div class='button-show-active'></div></div>
<div class="openColors button-edit-table bg-color-one">Table<br>Settings</div>
<div class="highlight"><div id="highlighted"></div></div>
<h1 class="colorText"><?php echo $editName; ?></h1>
<div class="deselectUnit bg-color-one">Deselect All</div>
<div id="Units" class="doneEditingHeader">
<?php
	include "./include/dbh.inc.php";
	$sql = "SELECT answer FROM $tableName WHERE question = '!@#title!@#'";
	$result = mysqli_query($conn, $sql);
	$number = 1;

     while($row = mysqli_fetch_assoc($result)){
     echo '<div class="UnitsRow"><div class="UnitSelect bg-color-border" id="unit'.$number.'">
		</div><div class="UnitWords"><p>'. $row["answer"].'</p> </div></div>	';
		$number = $number + 1;
}
	
?>
</div>
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>
<div id='thetable'>
<?php
echo'
<div class="editColors bg-color-one">

<h1>Table Settings</h1>
<div id="closeColors">CLOSE  </div>
<form method="post" id="form1" action="./include/tablesettings.inc.php">
<input type="hidden" name="table" value="'.$tableName.'">
<span  style="color: white">Table Name</span> <input type="text" name="tableName" value="'.$editName.'"><br>
<span  style="color: white">Background Color</span> <input type="color" name="colorOne" value="'.$colorOne.'"><br>
<span  style="color: white">Background Image URL</span> <input type="text" name="image" value="'.$image.'"><br>
<input type="submit" name="edit" value="Save" id="save" class="bright" >
</form>
</div>
';

?>

<?php

//Load the data
include './include/dbh.inc.php';
$sqr = "SELECT * FROM $tableName ORDER BY reorder ASC";
$result = mysqli_query($conn, $sqr);
$resultCheck= mysqli_num_rows($result);
$firstitle = "no";
$tableclass = 1;

if ($resultCheck >= 1) {
      while($row = mysqli_fetch_assoc($result)){
      //echo the title
      	if ($row['question'] === "!@#title!@#") {
      		if ($firstitle === "no") {
      			echo"<div class='data-wrapper bg-color-one unit".$tableclass."'>
      		<div class='data-title bg-color-one'><div class='data'name=".$row['id'].">
      		".$row['answer']."<div class='edit'></div></div>
      		<div class='textblock textblockhead'><div class='downcard'></div><div class='downcard'></div><div class='upcard'></div><div class='deletecard'></div><div class='savecardanswerhead'></div><textarea class='titleedit' name=".$row['id'].">".$row['answer'] ."</textarea></div>
      		</div>";
      			$firstitle = "yes";
      			$tableclass = $tableclass + 1;
      		}else{
      			echo"</div><div class='data-wrapper bg-color-one unit".$tableclass."'>
      		<div class='data-title bg-color-one'><div class='data'name=".$row['id'].">
      		".$row['answer']."<div class='edit'></div></div>
      		<div class='textblock textblockhead'><div class='downcard'></div><div class='upcard'></div><div class='deletecard'></div><div class='savecardanswerhead'></div><textarea class='titleedit' name=".$row['id'].">".$row['answer'] ."</textarea></div>
      		</div>";
      		$tableclass = $tableclass + 1;
      		}
      		
      		
      	}
      //echo a header
      	else if($row['question'] === "!@#head!@#"){
      		echo"<div class='data-heading bg-color-one'><div class='data'name=".$row['id'].">
      		".$row['answer'] ."<div class='edit'></div></div>
      		<div class='textblock textblockhead'><div class='downcard'></div><div class='upcard'></div><div class='deletecard'></div><div class='savecardanswerhead'></div><textarea class='titleedit' name=".$row['id'].">".$row['answer'] ."</textarea></div>
      		</div>";
      	}
      	else{
      		$qimage = "";
      		$aimage = "";
      		if (strlen($row['answerimage']) > 4) {
      			$aimage = "<img src='./images/".$row['answerimage']."'>";
      		}
      		if (strlen($row['questionimage']) > 4) {
      			$qimage = "<img src='./images/".$row['questionimage']."'>";
      		}
      		echo "<div class='data-row'>
					<div class='data-question' name=".$row['id'].">".$qimage.$row['question'] ."<div class='edit'></div></div>
					<div class='textblock'><div class='addimagecard'>
					<form action='./include/uploadimage.php' method='post' enctype='multipart/form-data'>
						<input style='display: none;' name='id'value='".$row['id']."'>
						<input style='display: none;' name='type'value='question'>
					    <input type='file' name='file' >
					    <input type='submit' value='upload' name='submit' >
						</form></div><div class='downcard'></div><div class='upcard'></div><div class='deletecard'></div><div class='savecardquestion'></div><textarea name=".$row['id'].">".$row['question'] ."</textarea></div>
					
					<div class='data-answer' name=".$row['id'].">".$aimage.$row['answer'] ."<div class='edit'></div></div>
					<div class='textblock'><div class='addimagecard'>
						<form action='./include/uploadimage.php' method='post' enctype='multipart/form-data'>
						<input style='display: none;' name='id'value='".$row['id']."'>
						<input style='display: none;' name='type'value='answer'>
					    <input type='file' name='file' >
					    <input type='submit' value='upload' name='submit'  >
						</form></div><div class='downcard'></div><div class='upcard'></div><div class='deletecard'></div><div class='savecardanswer'></div><textarea name=".$row['id'].">".$row['answer'] ."</textarea></div>
					</div>";
      	}
 

}

}

?>
</div></div><br>
<div class="addButtons">
		<div class="addHead">+ Heading</div>
		<div class="add">+</div>
		<div class="addTitle">+Title</div>
</div>
<br><br>
<script type="text/javascript" src="js/buttons.js"></script>
<script type="text/javascript" src="js/modal.js"></script>
</body>
</html>