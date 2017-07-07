<?php

	session_start();

	if(isset($SESSION['is_login'])){
		echo "<meta http-equiv='refresh' content=\"0;url='index.php'\">";
	}

	require 'dbClass.php';

	$userTable = 'todouser';

	$username = $_POST['username'];
	$password = $_POST['password'];
	$signin   = $_POST['signin'];

	if(class_exists("DBLink")) {
		$DB = new DBLink;
		echo "<span class='sys'>Connection succeed.</span><br/>";
	}
	else
		exit("<span class='err'>DBLink class does not exist</span><br/>");

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Sign in</title>
	<link rel="stylesheet" type="text/css" href="./css/signin.css?ver=1">
</head>
<body>
<div class="container">

	<h2 class="title">"To do list" - Sign in</h2>

	<div class="note">

		<p class="txt">"To do" Application</p>
		<p class="txt">Designed &amp; developed by Paolo Chang</p>
		<p class="txt">Inspired by Seonghoon, Soohyun</p>
		
	</div>

	<form class="form" method="post" name="login" action="" >
		
		<input class="field" type="text" name="username">
		<label for="username" class="txt">Username : </label> <br/>
		
		<input class="field" type="password" name="password">
		<label for="password" class="txt">Password : </label> <br/><br/><br/>
		<input class="btn" type="submit" name="signin" value="Sign in">
		<input class="btn" type="button" onclick="location.href='index.php'" value="Back">
	</form>
</div>

<?php

	if(isset($signin) && isset($username) && isset($password)) {

		$DB->signin($userTable, $username, $password);
	}

?>

</body>
</html>