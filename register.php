<!DOCTYPE html>
<html>
<head>
	<title>register</title>
	<link rel="stylesheet" type="text/css" href="./css/register.css?ver=1">
</head>
<body>

<?php

	session_start();

	require "dbClass.php";

	$userTable = 'todouser';

	$username = $_POST['username'];
	$password = $_POST['password'];
	$checking = $_POST['checking'];
	$email    = $_POST['email'];
	$register = $_POST['register'];

	if(class_exists("DBLink")) {
		$DB = new DBLink;
		echo "<span class='sys'>Connection succeed.</span><br/>";
	}
	else
		exit("<span class='err'>DBLink class does not exist</span><br/>");

?>


<div class="container">

	<h2 class="title">"To do list" - Register</h2>

	<div class="note">

		<p class="txt">"To do" Application</p>
		<p class="txt">Designed &amp; developed by Paolo Chang</p>
		<p class="txt">Inspired by Seonghoon, Soohyun</p>

	</div>

	<form class="form" method="POST" name="register">
		<input class="field" type="text" name="username">
		<label class="txt" for="username">Username : </label> <br/>
		<input class="field" type="password" name="password"> 
		<label class="txt" for="password">Password : </label> <br/>
		<input class="field" type="password" name="checking"> 
		<label class="txt" for="password">Password : </label> <br/>
		<input class="field" type="email" name="email"> 
		<label class="txt" for="email">e-mail : </label> <br/><br/>	
		<input class="btn" type="submit" name="register" value="Register">
		<input class="btn" type="button" onclick="location.href='index.php'" value="Back" >
	</form>
</div>

<?php

	if(isset($register) && isset($username) && isset($password) && isset($checking) && isset($email)) {

		$result = $DB->check($password, $checking);

		if($result == true)
			$DB->register($userTable, $username, $password, $email);
		else
			echo "<span class='err'>Fail</span><br/>";
	}
?>

</body>
</html>