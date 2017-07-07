<?php

	$no = $_GET['no'];

	require 'dbClass.php';

	if(class_exists("DBLink")) {
		$DB = new DBLink;
		echo "<span id='sys'>Connection succeed.</span><br/>";
	}
	else
		exit("<span id='err'>DBLink class does not exist</span><br/>");

	$result = $DB->delete($no);

/*	if($result)
		echo "data has been deleted.";
	else
		echo "fail to delete data.";*/

	header("Location: index.php");

?>