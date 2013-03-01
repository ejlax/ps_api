<?php
ob_start();
session_start();
include_once('header.php');
if(!isset($_GET['schools'])){
/*select schools from which to import users
 * this will loop through each school and aggregate all users (Staff and Students)
 * into 1 users.csv file and either offer it for download or for import through the
 * Canvas API SIS Import feature.
 */
//$inputFile = "/Users/eric/Documents/canvas/vscsd-students-test.csv";
$url = $_SESSION['ps_url']."/ws/v1/district/school";
//api/v1/accounts/1/sis_imports/17888.json?access_token=".$token;
//echo $url."<br>";
$ch = curl_init($url);
$request_headers = array('Authorization: Bearer ' . $_SESSION['access_token'],
		'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'
);

# Initiate cURL, adding the REQUEST_HEADERS to it for authentication
//$ch = curl_init($url);
//echo $url."<br>";
//print_r($request_headers);
//echo "<br>";
if(curl_errno($ch)){
  $curlerror = 'Curl error: ' . curl_error($ch);
	echo $curlerror;
}else{ 
	// Set headers
	curl_setopt($ch,CURLOPT_HTTPHEADER,$request_headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$response = new SimpleXMLElement(curl_exec($ch));
	curl_close($ch);		
	//print_r($response);
	/*
	 * $fp = fopen('courses.csv', 'w');
	//fwrite($fp,$json_str);
	$data = "course_id,short_name,long_name,status\n";
	fwrite($fp,$data);*/
	echo "<form method='get' action='import_users.php' id='import'><select name='schools[]' multiple='multiple' size='10'>";
	foreach($response->school as $school)
		{
		    	$school_id = (String) $school->id;
				$school_name = (String) $school->name;
			echo "<option class='option' value='".$school_id."'>".$school_name."</option>";
		}
	echo "</select><br><button type='submit' class='btn-info'>Select Schools</button>
			</form>";
  	}
}?>
			

<?php
	$fp = fopen('users.csv', 'w');
	$data = "user_id,login_id,first_name,last_name,email,status\n";
	//writing users.csv headers
	fwrite($fp,$data);
//print_r($_GET['schools']);
foreach($_GET['schools'] as $school){

	$school_id = $school[0];
	echo $school_id."<br>";
	$i++;
	//get student count
	$url = $_SESSION['ps_url']."/ws/v1/school/".$school_id."/student/count";
	echo $url."<br>";
	# Initiate cURL, adding the REQUEST_HEADERS to it for authentication
	$ch = curl_init($url);
	$request_headers = array('Authorization: Bearer ' . $_SESSION['access_token'],
			'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'
	);
	// Set headers
	curl_setopt($ch,CURLOPT_HTTPHEADER,$request_headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$response = new SimpleXMLElement(curl_exec($ch));
	curl_close($ch);		
	
	//print_r($response);
	echo "<br>";
	$i = 0;
	//store course count as $count
	$student_count = $response->count;
	echo $student_count;
	// setting remainder to determing how many pages to request from API
	$pages = $student_count / 100;
	//echo $pages;
	$num = 1;
	//creating users.csv for download
	//looping through API requests for as many pages as necessary to complete student
	while($i < $pages){
		//call all students
		$url = $_SESSION['ps_url']."/ws/v1/school/".$school_id."/student?page=".$num."&page_size=100";
		//api/v1/accounts/1/sis_imports/17888.json?access_token=".$token;
		//echo $url."<br>";
		$ch = curl_init($url);
		
		$request_headers = array('Authorization: Bearer ' . $_SESSION['access_token'],
				'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'
		);
		
		# Initiate cURL, adding the REQUEST_HEADERS to it for authentication
		$ch = curl_init($url);
		//echo $url."<br>";
		//print_r($request_headers);
		//echo "<br>";
		
		// Set headers
		curl_setopt($ch,CURLOPT_HTTPHEADER,$request_headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = new SimpleXMLElement(curl_exec($ch));
		//$info = curl_getinfo($ch);
		curl_close($ch);
		$num++;	
		//$json_str = "{'aintlist':[4,3,2,1], 'astringlist':['str1','str2']}";
		    //$json_obj = json_decode ($json_str);
		//print_r($response);
		foreach($response->student as $student){
		    	$user_id = (String) $student->id;
		    	$fname = (String) $student->name->first_name;
				$lname = (String) $student->name->last_name;
				$status = 'active';
				$email = $fname.".".$lname."@govikes.org";
				
				$str = $user_id.",".$email.",".$fname.",".$lname.",".$email.",".$status."\n";
				$data = strtolower($str);
				$f = fopen('users.csv', 'a');
				fwrite($f,$data);
				fclose($f);
		}
		$i++;
		}
	}
	foreach($_GET['schools'] as $school){

	$school_id = $school[0];
	echo $school_id."<br>";
	$i++;
	//get student count
	$url = $_SESSION['ps_url']."/ws/v1/school/".$school_id."/staff/count";
	echo $url."<br>";
	# Initiate cURL, adding the REQUEST_HEADERS to it for authentication
	$ch = curl_init($url);
	$request_headers = array('Authorization: Bearer ' . $_SESSION['access_token'],
			'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'
	);
	// Set headers
	curl_setopt($ch,CURLOPT_HTTPHEADER,$request_headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$response = new SimpleXMLElement(curl_exec($ch));
	curl_close($ch);		
	
	//print_r($response);
	echo "<br>";
	$i = 0;
	//store course count as $count
	$student_count = $response->count;
	echo $student_count;
	// setting remainder to determing how many pages to request from API
	$pages = $student_count / 100;
	//echo $pages;
	$num = 1;
	//creating users.csv for download
	//looping through API requests for as many pages as necessary to complete student
	while($i < $pages){
		//call all students
		$url = $_SESSION['ps_url']."/ws/v1/school/".$school_id."/staff?page=".$num."&page_size=100";
		//api/v1/accounts/1/sis_imports/17888.json?access_token=".$token;
		//echo $url."<br>";
		$ch = curl_init($url);
		
		$request_headers = array('Authorization: Bearer ' . $_SESSION['access_token'],
				'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'
		);
		
		# Initiate cURL, adding the REQUEST_HEADERS to it for authentication
		$ch = curl_init($url);
		//echo $url."<br>";
		//print_r($request_headers);
		//echo "<br>";
		
		// Set headers
		curl_setopt($ch,CURLOPT_HTTPHEADER,$request_headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = new SimpleXMLElement(curl_exec($ch));
		//$info = curl_getinfo($ch);
		curl_close($ch);
		$num++;	
		//$json_str = "{'aintlist':[4,3,2,1], 'astringlist':['str1','str2']}";
		    //$json_obj = json_decode ($json_str);
		//print_r($response);
		foreach($response->staff as $staff){
		    	$user_id = (String) $staff->id;
		    	$fname = (String) $staff->name->first_name;
				$lname = (String) $staff->name->last_name;
				$status = 'active';
				$email = (String) $staff->email;
				
				$str = $user_id.",".$email.",".$fname.",".$lname.",".$email.",".$status."\n";
				$data = strtolower($str);
				$f = fopen('users.csv', 'a');
				fwrite($f,$data);
				fclose($f);
		}
		$i++;
		}
	}

/*
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
			$url ="https://".$domain.".instructure.com/api/v1/accounts/1/sis_imports/".$id."?access_token=".$token;
			//echo $url."<br>";
			$ch = curl_init($url);
	//curl_setopt($ch, CURLOPT_POST, true);
	/*curl_setopt($ch, CURLOPT_POSTFIELDS,
	array(
		  'access_token' => "$token")
	);
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
			echo "Error Number= "."<a href='https://".$domain.".instructure.com/error_reports/".$error_report."'>".$error_report."</a>";
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
 * 
 * 
 */
?>