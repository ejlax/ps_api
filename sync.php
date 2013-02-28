<?php
session_start();

	
	foreach($_GET['schools'] as $school){

		$school_id = $school[0];
		echo $school_id."<br>";

	}


?>