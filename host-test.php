<?php
if(!isset($_GET['ps_url']) && !isset($_SESSION['ps_url'])){
	echo "<div class='alert-error' align='center'><h2>No PowerSchool URL</h2></div>";
	exit;
	}
if(isset($_GET['ps_url'])){
		
	$url = $_GET['ps_url']."/ws/v1/district";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTIONTIMEOUT , 5000);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
	//curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
	//curl_setopt($ch, CURLOPT_USERPWD, "$ps_code:$ps_secret");
	$response = curl_exec($ch);
	$json = json_decode($response);
	//print_r($json);
	//$result = new SimpleXMLElement(curl_exec($ch));
	//unset($_SESSION['access_token']);
	if(curl_errno($ch)){
	  $curlerror = 'Curl error: ' . curl_error($ch);
		echo "<div class='alert-error'><h2>".$curlerror."</h2></div>";
		exit();
	}
}
?>