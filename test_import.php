<?php
//$account = $_GET['account'];
//$domain = $_GET['domain'];
echo "This isn't working<br>";
$token = "5d38f5a9-24cf-4a87-a383-2e5f164d51cc";
//$inputFile = "/Users/eric/Documents/canvas/vscsd-students-test.csv";
$url ="http://powerschool-ag.dev.sifworks.com/ws/v1/school/3/student?page=1&page_size=100&q=A";
//api/v1/accounts/1/sis_imports/17888.json?access_token=".$token;
//echo $url."<br>";
$ch = curl_init($url);
	//curl_setopt($ch, CURLOPT_POST, true);
	/*curl_setopt($ch, CURLOPT_POSTFIELDS,
	array(
		  'access_token' => "$token")
	);*/

	//curl_setopt($ch, CURLINFO_HEADER_OUT);

		//$jsondmp = json_decode($json, true);
		//print_r($jsondmp);
		//var_dump($info);
		/*echo "<br>";
		$id = $jsondmp['id'];
		$progress = $jsondmp['progress'];
		$error_report = $jsondmp['error_report_id'];
		$status = $jsondmp['status'];
		echo "<br>";
		echo "Id= ".$id."<br>";
		echo "Progress= ".$progress.'<br>';
		echo "Status= ".$status."<br>";
		echo "Error Number= "."<a href='https://ericadams.test.instructure.com/error_reports/".$error_report."'>".$error_report."</a>";*/


$request_headers = array('Authorization: Bearer ' . $token,
		'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'
);

# Initiate cURL, adding the REQUEST_HEADERS to it for authentication
$ch = curl_init($url);
echo $url."<br>";
print_r($request_headers);
echo "<br>";

// Set headers
	curl_setopt($ch,CURLOPT_HTTPHEADER,$request_headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$response = new SimpleXMLElement(curl_exec($ch));
		//$info = curl_getinfo($ch);
		curl_close($ch);		
//$json_str = "{'aintlist':[4,3,2,1], 'astringlist':['str1','str2']}";
    //$json_obj = json_decode ($json_str);
print_r($response);

$fp = fopen('users.csv', 'w');
//fwrite($fp,$json_str);
$data = "user_id,login_id,first_name,last_name,status\n";
fwrite($fp,$data);
foreach($response->student as $student)
{
    	$user_id = (String) $student->id;
		$login_id = (String) $student->student_username;
    	$fname = (String) $student->name->first_name;
		$lname = (String) $student->name->last_name;
		$status = 'active';
		
		$data = $user_id.",".$login_id.",".$fname.",".$lname.",".$status."\n";
		
		$f = fopen('users.csv', 'a');
		fwrite($f,$data);
		fclose($f);
}
$url ="http://powerschool-ag.dev.sifworks.com/ws/v1/school/3/staff?page=1&page_size=100";
//api/v1/accounts/1/sis_imports/17888.json?access_token=".$token;
//echo $url."<br>";
$ch = curl_init($url);
$request_headers = array('Authorization: Bearer ' . $token,
		'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'
);

# Initiate cURL, adding the REQUEST_HEADERS to it for authentication
$ch = curl_init($url);
echo $url."<br>";
print_r($request_headers);
echo "<br>";

// Set headers
	curl_setopt($ch,CURLOPT_HTTPHEADER,$request_headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$response = new SimpleXMLElement(curl_exec($ch));
		//$info = curl_getinfo($ch);
		curl_close($ch);		

foreach($response->staff as $staff)
{
    	$user_id = (String) $staff->id;
		$login_id = (String) $staff->teacher_username;
    	$fname = (String) $staff->name->first_name;
		$lname = (String) $staff->name->last_name;
		$status = 'active';
		
		$data = $user_id.",".$login_id.",".$fname.",".$lname.",".$status."\n";
		
		$f = fopen('users.csv', 'a');
		fwrite($f,$data);
		fclose($f);
}



$account = 1;
$domain = "ericadams.test";
$token = "1~OVzaepeSrdCKW9IJipmK2hMTeClJAQaGkD0RjQc59BDUQT3TRaUZgtPopqTdcKn4";
//$inputFile = "/Users/eric/Documents/canvas/vscsd-students-test.csv";
$inputFile = "users.csv";
if(isset($domain)){
$url ="https://".$domain.".instructure.com/api/v1/accounts/".$account."/sis_imports.json?import_type=instructure_csv";
//echo $url."<br>";
$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
	array('attachment'=>"@$inputFile",
		  'access_token' => "$token")
	);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLINFO_HEADER_OUT);
	if ($error = curl_error($ch)){
	echo "Error in curl call<br>";
	print_r($error);
	}else{
		$output = curl_exec($ch);
		//info = curl_getinfo($ch);
		curl_close($ch);
		$json = json_decode($output, true);
		$id = $json['id'];
		$progress = $json['progress'];
		print_r($json);
		echo "<br>";
		//print_r($info);
		//echo "<br>";
		//echo "Id =".$id."<br>";
		//echo "Progress=".$progress.'<br>';
		}
	if(isset($progress)){
		while($progress != 100){
			sleep(5);
			$url ="https://ericadams.test.instructure.com/api/v1/accounts/1/sis_imports/".$id."?access_token=".$token;
			//echo $url."<br>";
			$ch = curl_init($url);
	//curl_setopt($ch, CURLOPT_POST, true);
	/*curl_setopt($ch, CURLOPT_POSTFIELDS,
	array(
		  'access_token' => "$token")
	);*/
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($ch, CURLINFO_HEADER_OUT);
		$json = curl_exec($ch);
		//$info = curl_getinfo($ch);
		curl_close($ch);		
		$jsondmp = json_decode($json, true);
		//print_r($jsondmp);
		//var_dump($info);
		//echo "<br>";
		//$id = $jsondmp['id'];
		$progress = $jsondmp['progress'];
		$endTime = $jsondmp['ended_at'];
		$error_report = $jsondmp['error_report_id'];
		$status = $jsondmp['status'];
		//echo "<br>";
		//echo "Id= ".$id."<br>";
		//echo "Progress= ".$progress.'<br>';
		//echo "Status= ".$status."<br>";
		if($error_report > 0){
			echo "Error Number= "."<a href='https://ericadams.test.instructure.com/error_reports/".$error_report."'>".$error_report."</a>";
			//sleep(5); 
			}
		}
		} 
		echo "<h3>SIS Import report ".$id." was successfully imported at ".$endTime.".</h3>";
		}
		else{
			echo "There was no domain set.";
		}
			
	
 ob_flush();
?>




?>