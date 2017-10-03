<?php
	//session_start();
	$username = "";
	$email = "";
	$password_1 = "";
	$errors = array();
	$db = mysqli_connect('localhost','root','kone5566', 'literatures');

	if (isset($_POST['register'])) {
		$username   = mysqli_real_escape_string($db, $_POST['username']);
		$email      = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

		if (empty($username)){
			array_push($errors, "Username is required");
		}
		if (empty($email)){
			array_push($errors, "Email is required");
		}
		if (empty($password_1)){
			array_push($errors, "Password is required");
		}
		if ($password_1 != $password_2){
			array_push($errors, "The two passwords do not match");
		}
		//--------------------------------------------------------------------//
		//27~36 check the username.
		$sql = "SELECT COUNT(*) FROM users WHERE username LIKE ('$username')";
		$compareresult = mysqli_query($db,$sql);
		while($row = mysqli_fetch_array($compareresult)){
   			
    		$counter = $row['COUNT(*)'];
		}
		if ( $counter != 0 && $username != "" ){
			array_push($errors, "The username is exist");
		}
		//-------------------------------------------------------------------//

	

		if (count($errors) == 0 && $username != "" ) {
			$gusql = "SELECT uuid();";
  			$result = mysqli_query($db,$gusql);
  			while ($row = $result->fetch_assoc()) {
        		$guid =  $row['uuid()'];
        		$guid = strtoupper($guid);
    		}

			$password = md5($password_1);
			$sql = "INSERT INTO users (guid, username, email, password) VALUES('$guid', '$username', '$email', '$password')";

			mysqli_query($db,$sql);
			//session_start();
			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are logged in";
			header('location: index.php');

		}
	}
	if(isset($_POST['login'])){
		$username   = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($username)){
			array_push($errors, "Username is required");
		}
		if (empty($password)){
			array_push($errors, "Password is required");
		}
		if (count($errors) == 0){
			$password = md5($password);
			$query = "SELECT * FROM users WHERE username = '$username' AND password='$password'";
			$result = mysqli_query($db, $query);
			if ( mysqli_num_rows($result) == 1 ){
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are logged in";

				$row = mysqli_fetch_array($result);
				$access = $row['access'];
				$_SESSION['access'] = $access;
				

				header('location: index.php');
			}
		}
		else{
			array_push($errors, "The username/password combination");
		}
	}

	if (isset($_GET['logout'])){
		session_destroy();
		unset($_SESSION['username']);
		header('location: login.php');
	}

?>