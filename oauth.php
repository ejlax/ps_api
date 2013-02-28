<?php
ob_start();
session_start();
$ps_url= $_GET['ps_url'];

$ps_code = $_GET['client_id'];
$ps_secret = $_GET['client_secret'];
$auth_url = $ps_url."/oauth/access_token/";
//$auth = base64_encode($ps_code.$ps_secret);
//echo $auth_url;

//print_r($_GET);
if( isset($ps_url) && isset($ps_secret) && isset($ps_code)){
	

$ch = curl_init($auth_url);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
curl_setopt($ch, CURLOPT_USERPWD, "$ps_code:$ps_secret");
$response = curl_exec($ch);
$json = json_decode($respose);
//print_r($json);
//$result = new SimpleXMLElement(curl_exec($ch));
//unset($_SESSION['access_token']);
if(curl_errno($ch))
{
  echo 'Curl error: ' . curl_error($ch);
}
else
{    
  //print_r($result);
  $_SESSION['access_token'] = $json->access_token;
  //$_SESSION['access_token'] = $result['access_token'];
  //echo $_SESSION['access_token'];
}

curl_close($ch);


$_SESSION['ps_url'] = $ps_url;
echo $_SESSION['access_token'];
}else{
	echo "<div class='span4'><h6>Please input your client Id, client secret, and PowerSchool URL in the <a href='https://lti-examples.heroku.com/index.html?tool=redirect'>Redirect LTI tool</a>.<p>This Program will not function until you do.<p></h6></div>";
	break;
	
	
}


?>
