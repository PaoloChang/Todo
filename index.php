<!DOCTYPE html>
<html>
<head>
	<title>To do</title>
	<link rel="stylesheet" type="text/css" href="./css/index.css?ver=1"/>
</head>
<body>


<?php

	session_start();

	// if(!isset($_SESSION['username']))
	// 	echo "<button id='signin' type='button' onclick='location.href=\"signin.php\"'>Sign in</button>";
	// else
	// 	echo "<button id='signin' type='button' onclick='location.href=\"signout.php\"'>Sign out</button>";

	$todoTable = 'todolist';
	$userTable = 'todouser';
	$task = $_POST['task'];

	require 'dbClass.php';

	if(class_exists("DBLink")) {
		$DB = new DBLink;
		echo "<span class='sys'>Connection succeed.</span><br/>";
	}
	else
		exit("<span class='err'>DBLink class does not exist</span><br/>");

	$table = $DB->select($todoTable);

	// echo $table;

	if($table == 1)
		echo "<span class='sys'>Table selected.</span><br/>";
	else
		$DB->create($todoTable);

?>



<div id="container">

	<span id="welcome">Welcome... 
		<?php
			if(isset($_SESSION['is_login']))
				echo $_SESSION['username'];
			else
				echo "Guest";
		?>	
	</span>
		
	<?php 
	
		if(isset($_SESSION['is_login']))
			echo "<a class='tool' href='signout.php'>Sign out</a>";
		else {
			echo "<a class='tool' href='signin.php'>Sign in</a>";
			echo "&nbsp;";
			echo "<a class='tool' href='register.php'>Register</a>";
		}

	?>

	<h2 id="title">"To do list"</h2>
	<form method="POST" name="todo">
		<input type="text" id="input" name="task">
		<input type="submit" id="add" name="add" value="add">
	</form>
	<?php

		if(isset($_POST['add'])){

			$result = $DB->add($todoTable, $task, $_SESSION['username']);

			if($result)
				echo "<span class='sys'>Task is added.</span><br/>";
			else
				echo "<span class='err'>Error occurs while task added.</span><br/>";
		}

	?>
	<br/>
	<table id="list">

		<?php  

			$DB->display($todoTable, $_SESSION['username']);

		?>
	</table>

</div>

</body>
</html>