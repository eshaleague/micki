<?php
$order = 1;
include "../include/dbh.inc.php";
$sqw = "SELECT id FROM `fa720df9245dc9b0ea7343edb0a171d9`";
		$result = mysqli_query($conn, $sqw);
		     while($row = mysqli_fetch_assoc($result)){
		     $current = $row['id'];
		     $sqt = "UPDATE fa720df9245dc9b0ea7343edb0a171d9 SET reorder = $order WHERE id =$current";
			mysqli_query($conn, $sqt);
			$order = $order + 1;


		}