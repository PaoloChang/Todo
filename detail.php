<!DOCTYPE html>
<html lang="en">
<head>
	<title>Detail</title>
	<link rel="stylesheet" type="text/css" href="./css/detail.css?ver=1">
</head>
<body>

<?php

	require "dbClass.php";

	$no = $_GET['no'];

	$table = 'todolist';

	if(class_exists("DBLink")) {
		$DB = new DBLink;
		echo "<span class='sys'>Connection succeed.</span><br/>";
	}
	else
		exit("<span class='err'>DBLink class does not exist</span><br/>");

?>

<div id="container">

	<h2 id="title">"To do list" - Detail</h2>
	<br/>
	<table id="detail">

	<?php

		$DB->detail($table, $no);

	?>

	</table>
	<br/>
	<input class="btn" type="button" onclick="location.href='index.php'" value="Back">
	
</div>
</body>
</html>