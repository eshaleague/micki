<?php

session_start();

if (isset($_POST['login']) ) {
	include 'dbh.inc.php';
	
	$uid = mysqli_real_escape_string($conn, $_POST['username']);
	$pwd = mysqli_real_escape_string($conn, $_POST['password']);

	if (empty($uid) || empty($pwd)){
		header("Location: ../index.php?login=error");
		exit();
	}else{

		$sql = "SELECT * FROM users WHERE username = '$uid'";
		$result = mysqli_query($conn, $sql);
		$resultCheck= mysqli_num_rows($result);
		if ($resultCheck < 1) {
			header("Location: ../index.php?login=error");
			exit();
		}else{
			if ($row = mysqli_fetch_assoc($result)) {
				//de-has the password
				$hashedPwdCheck = password_verify($pwd, $row['password']);
				if ($hashedPwdCheck  == false) {
					header("Location: ../index.php?login=error");
					exit();
				}else if ($hashedPwdCheck  == true){
					//login the admin
					$_SESSION['uid'] = $row['id'];
					$_SESSION['u_username'] = $row['username'];
					header("Location: ../tables.php?login=success");
				}
			}
		}

	}
}else{
		header("Location: ../index.php?login=error");
		exit();
	};