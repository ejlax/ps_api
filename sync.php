<?php
session_start();
$i = 0;
foreach($_GET['schools'] as $school){

	$school_id.$i = $school[0];
	echo $school_id.$i."<br>";
	$i++;

}


?>