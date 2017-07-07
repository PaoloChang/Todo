<?php

	$no = $_GET['no'];

	require 'dbClass.php';

	if(class_exists("DBLink")) {
		$DB = new DBLink;
		echo "<span id='sys'>Connection succeed.</span><br/>";
	}
	else
		exit("<span id='err'>DBLink class does not exist</span><br/>");

	$result = $DB->change($no);

/*	if($result)
		echo "status has been changed.";
	else
		echo "fail to change status.";*/

	header("Location: index.php");

?>