<?php
session_start();
$tableName = $_SESSION['tableName'];

if (isset($_POST['method'])) {
	include "../include/dbh.inc.php";
	if ($_POST['method'] === "editcard") {
		$sql = "UPDATE $tableName SET ".$_POST['type']."= '".$_POST['value']."' WHERE id ='".$_POST['id']."'";
		mysqli_query($conn, $sql);

	}
	else if ($_POST['method'] === "updatecard") {
		$type = $_POST['type'];
		$sql = "SELECT * FROM $tableName WHERE id = ".$_POST['id'];
		$result = mysqli_query($conn, $sql);
		$image = "";
     	 if ($row = mysqli_fetch_assoc($result)){
     	 	if (!empty($row[$type."image"])) {
     	 		$image = "<img src='./images/".$row[$type."image"]."'>";
     	 	}
    		Echo $image.$row[$type];
		}

	}
	else if ($_POST['method'] === "additems") {
		$type = $_POST['type'];
		if ($type === 'card') {

			$sql = "SELECT MAX(reorder) AS highest FROM $tableName ; ";
			$result = mysqli_query($conn, $sql);
			if ($row = mysqli_fetch_assoc($result)){
			     $highest =  $row['highest'];
			}
			$sqr = "INSERT INTO $tableName (question, answer, reorder) VALUES ('', '', $highest + 1);";
			mysqli_query($conn, $sqr);
	
		}else{

			$sql = "SELECT MAX(reorder) AS highest FROM $tableName ; ";
			$result = mysqli_query($conn, $sql);
			if ($row = mysqli_fetch_assoc($result)){
			     $highest =  $row['highest'];
			}
			$sqr = "INSERT INTO $tableName (question, answer, reorder) VALUES ('!@#".$type."!@#', '".$type."', $highest + 1);";
			mysqli_query($conn, $sqr);
		}
		

	}

	else if($_POST['method'] === "deletecard"){
		$id= $_POST['id'];
		
		//update numbers and cecrease by 1 where the order number is higher than deleted
		//get the value of the order that was just deleted
		$min = 0;
		$sqr = "SELECT reorder FROM $tableName WHERE id = $id";
		$result = mysqli_query($conn, $sqr);
		if ($row = mysqli_fetch_assoc($result)){
		    $min =  $row['reorder'];
		}
		//select all the rows that are larger than the min reorder
		$sqw = "SELECT id FROM $tableName WHERE reorder >  $min ";
		$result = mysqli_query($conn, $sqw);
		     while($row = mysqli_fetch_assoc($result)){
		     $current = $row['id'];
		     $sqt = "UPDATE $tableName SET reorder = reorder -1 WHERE id =$current";
			mysqli_query($conn, $sqt);


		}
		$sql = "DELETE FROM $tableName WHERE id = ".$id;
		mysqli_query($conn, $sql);

	}
	else if($_POST['method'] === "changespot"){
		$prev = $_POST['prev'];
		$upda = $_POST['upda'];

		if ($prev === $upda) {
			# code...
		}elseif($prev > $upda){
			$sqt = "UPDATE $tableName SET reorder = reorder + 1 WHERE reorder >= $upda";
			mysqli_query($conn, $sqt);
			$sqf = "UPDATE $tableName SET reorder = $upda WHERE reorder = $prev + 1";
			mysqli_query($conn, $sqf);
			$sqy = "UPDATE $tableName SET reorder = reorder - 1 WHERE reorder > $prev";
			mysqli_query($conn, $sqy);
		}
		elseif($prev < $upda){
			$sqt = "UPDATE $tableName SET reorder = reorder - 1 WHERE reorder <= $upda";
			mysqli_query($conn, $sqt);
			$sqf = "UPDATE $tableName SET reorder = $upda WHERE reorder = $prev - 1";
			mysqli_query($conn, $sqf);
			$sqy = "UPDATE $tableName SET reorder = reorder + 1 WHERE reorder < $prev";
			mysqli_query($conn, $sqy);
		}
		
	 
			
			
		
		/*
		 $sqq = "UPDATE $tableName SET reorder = $upda + 1 WHERE reorder = $prev";
			mysqli_query($conn, $sqq);*/





	}

	else if ($_POST['method'] === 'loadtable'){
		$sql = "SELECT * FROM $tableName ORDER BY reorder ASC";
		$result = mysqli_query($conn, $sql);
		$resultCheck= mysqli_num_rows($result);
		$tableclass = 1;
		$firstitle = "no";

		if ($resultCheck >= 1) {
		     while($row = mysqli_fetch_assoc($result)){
      //echo the title
      	if ($row['question'] === "!@#title!@#") {
      		if ($firstitle === "no") {
      			echo"<div class='data-wrapper bg-color-one unit".$tableclass."'><div class='row-number'>".$row['reorder']."</div>
      		<div class='data-title bg-color-one'><div class='data'name=".$row['id'].">
      		".$row['answer']."<div class='edit'></div></div>
      		<div class='textblock textblockhead'><input type='number' style='display: none;' value='".$row['reorder']."'><div class='row-number-save'></div><input type='number' class='row-number-change' min='1' value='".$row['reorder']."'><div class='deletecard'></div><div class='savecardanswerhead'></div><textarea class='titleedit' name=".$row['id'].">".$row['answer'] ."</textarea></div>
      		</div>";
      			$firstitle = "yes";
      			$tableclass = $tableclass + 1;
      		}else{
      			echo"</div><div class='data-wrapper bg-color-one unit".$tableclass."'><div class='row-number'>".$row['reorder']."</div>
      		<div class='data-title bg-color-one'><div class='data'name=".$row['id'].">
      		".$row['answer']."<div class='edit'></div></div>
      		<div class='textblock textblockhead'><input type='number' style='display: none;' value='".$row['reorder']."'><div class='row-number-save'></div><input type='number' class='row-number-change' min='1' value='".$row['reorder']."'><div class='deletecard'></div><div class='savecardanswerhead'></div><textarea class='titleedit' name=".$row['id'].">".$row['answer'] ."</textarea></div>
      		</div>";
      		$tableclass = $tableclass + 1;
      		}
      		
      		
      	}
      //echo a header
      	else if($row['question'] === "!@#head!@#"){
      		echo"<div class='data-heading bg-color-one'><div class='row-number'>".$row['reorder']."</div><div class='data'name=".$row['id'].">
      		".$row['answer'] ."<div class='edit'></div></div>
      		<div class='textblock textblockhead'><input type='number' style='display: none;' value='".$row['reorder']."'><div class='row-number-save'></div><input type='number' class='row-number-change' min='1' value='".$row['reorder']."'><div class='deletecard'></div><div class='savecardanswerhead'></div><textarea class='titleedit' name=".$row['id'].">".$row['answer'] ."</textarea></div>
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
      		echo "<div class='row-number'>".$row['reorder']."</div><div class='data-row'>
					<div class='data-question' name=".$row['id'].">".$qimage.$row['question'] ."<div class='edit'></div></div>
					<div class='textblock'><div class='addimagecard'>
					<form action='./include/uploadimage.php' method='post' enctype='multipart/form-data'>
						<input style='display: none;' name='id'value='".$row['id']."'>
						<input style='display: none;' name='type'value='question'>
					    <input type='file' name='file' >
					    <input type='submit' value='upload' name='submit' >
						</form></div><input type='number' style='display: none;' value='".$row['reorder']."'><div class='row-number-save'></div><input type='number' class='row-number-change' min='1' value='".$row['reorder']."'><div class='deletecard'></div><div class='savecardquestion'></div><textarea name=".$row['id'].">".$row['question'] ."</textarea></div>
					
					<div class='data-answer' name=".$row['id'].">".$aimage.$row['answer'] ."<div class='edit'></div></div>
					<div class='textblock'><div class='addimagecard'>
						<form action='./include/uploadimage.php' method='post' enctype='multipart/form-data'>
						<input style='display: none;' name='id'value='".$row['id']."'>
						<input style='display: none;' name='type'value='answer'>
					    <input type='file' name='file' >
					    <input type='submit' value='upload' name='submit' >
						</form></div><input type='number' style='display: none;' value='".$row['reorder']."'><div class='row-number-save'></div><input type='number' class='row-number-change' min='1' value='".$row['reorder']."'><div class='deletecard'></div><div class='savecardanswer'></div><textarea name=".$row['id'].">".$row['answer'] ."</textarea></div>
					</div>";
      	}
 

}

		}

	}
	else if ($_POST['method'] === 'loadunits'){
		$sql = "SELECT answer FROM $tableName WHERE question = '!@#title!@#'";
		$result = mysqli_query($conn, $sql);
		$number = 1;

    	 while($row = mysqli_fetch_assoc($result)){
    	 echo '<div class="UnitsRow"><div class="UnitSelect bg-color-border" id="unit'.$number.'">
		</div><div class="UnitWords"><p>'. $row["answer"].'</p> </div></div>	';
		$number = $number + 1;
		}
	}

}