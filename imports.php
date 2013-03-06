<?php
ob_start();
session_start();
include_once('header.php');
//include_once('host-test.php');
 
	// Set headers		
	//print_r($response);
	/*
	 * $fp = fopen('courses.csv', 'w');
	//fwrite($fp,$json_str);
	$data = "course_id,short_name,long_name,status\n";
	fwrite($fp,$data);*/
	/*echo "<form method='get' action='import_users.php' id='import'><select name='schools[]' multiple='multiple' size='10'>";
	foreach($response->school as $school)
		{
		    	$school_id = (String) $school->id;
				$school_name = (String) $school->name;
			echo "<option class='option' value='".$school_id."'>".$school_name."</option>";
		}
	echo "</select><br><button type='submit' class='btn btn-info'>Select Schools</button>
			</form>";
  	}
}*/

foreach($_GET['schools'] as $school){
	$school_id = $school[0];
	//echo $school_id."<br>";
	if ($_GET['import_courses'] === 'y'){
	$url =$_SESSION['ps_url']."/ws/v1/school/".$school_id."/course/count";
	$ch = curl_init($url);
	$request_headers = array('Authorization: Bearer ' . $_SESSION['access_token'],
	'Content-Type: application/x-www-form-urlencoded;charset=UTF-8');

//echo $url."<br>";
//print_r($request_headers);
//echo "<br>";

// Set headers
	curl_setopt($ch,CURLOPT_HTTPHEADER,$request_headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$response = new SimpleXMLElement(curl_exec($ch));
		//$info = curl_getinfo($ch);
	curl_close($ch);		
//$json_str = "{'aintlist':[4,3,2,1], 'astringlist':['str1','str2']}";
    //$json_obj = json_decode ($json_str);
//print_r($response);
	$c = 0;
//store course count as $count
	foreach($response->count as $course_count) {
		echo "This school has ".$course_count." courses.";

		}

	$pages = $course_count / 100;

//echo $pages;
	$num = 1;

	$fp = fopen('courses.csv', 'w');
//fwrite($fp,$json_str);
	$data = "course_id,short_name,long_name,term_id,status\n";
	$fp = fwrite($fp, $data);
	while($c < $pages){
		
		$url = $_SESSION['ps_url']."/ws/v1/school/6/course?page=".$num;
		//$url = "https://ps-vscsd.gwaea.org/ws/v1/district/school";
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
		//$json_str = "{'aintlist':[4,3,2,1], 'astringlist':['str1','str2']}";
		    //$json_obj = json_decode ($json_str);
		//print_r($response);
		$num++;
		
		foreach($response->course as $course)
			{
    		$course_id = (String) $course->id;
			$short_name = (String) $course->course_number;
			$long_name = (String) $course->course_name;
			$term_id = 226;
			$status = 'active';
			$data = $course_id.",".$short_name.",".$long_name.",".$term_id.",".$status."\n";
			$f = fopen('courses.csv', 'a');
			fwrite($f,$data);
			fclose($f);
			}
		
		$c++;
		
	}
}else{
	//do nothing
}

			
if ($_GET['import_sections'] === 'y'){
	$url = $_SESSION['ps_url']."/ws/v1/school/".$school_id."/section/count?q=term.start_year==2012";
//$url = "https://ps-vscsd.gwaea.org/ws/v1/district/school";
//api/v1/accounts/1/sis_imports/17888.json?access_token=".$token;
//echo $url."<br>";
	$ch = curl_init($url);
	$request_headers = array('Authorization: Bearer ' . $_SESSION['access_token'],
		'Content-Type: application/x-www-form-urlencoded;charset=UTF-8');

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
//$json_str = "{'aintlist':[4,3,2,1], 'astringlist':['str1','str2']}";
    //$json_obj = json_decode ($json_str);
//print_r($response);
	$s = 0;
//store course count as $count
	foreach($response->count as $section_count) {
		//echo "This school has ".$section_count." courses.";
	}

	$pages = $section_count / 100;

//echo $pages;
	$num = 1;
//create section file
	$fp = fopen('sections.csv', 'w');
//fwrite($fp,$json_str);
	$data = "section_id,course_id,name,status\n";
	$fp = fwrite($fp, $data);
	fwrite($fp,$data);
	fclose($fp);
	$fp = fopen('enrollments.csv', 'w');
//fwrite($fp,$json_str);
	$data = "user_id,role,section_id,status\n";
	$fp = fwrite($fp, $data);
	fwrite($fp,$data);
	fclose($fp);
	while($s < $pages){
		
		$url =$_SESSION['ps_url']."/ws/v1/school/".$school_id."/section?page=".$num;
		//$url = "https://ps-vscsd.gwaea.org/ws/v1/district/school";
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
		//$json_str = "{'aintlist':[4,3,2,1], 'astringlist':['str1','str2']}";
		    //$json_obj = json_decode ($json_str);
		//print_r($response);
		$num++;
		
		foreach($response->section as $section)
		{
    	$section_id = (String) $section->id;
    	$course_id = (String) $section->course_id;		
		$name = (String) $section->section_number;
		$term_id = (String) $section->term_id;
		$status = 'active'; // change this to deleted to remove sections

		/*$data = $section_id.",".$course_id.",".$name.",".$status."\n";
		$f = fopen('sections.csv', 'a');
		fwrite($f,$data);
		fclose($f);*/
		
		//add case for term_id (implement in later version)
		/*if ($term_id == '227'){
			$data = $section_id.",".$course_id.",".$name.",".$status."\n";
		$f = fopen('sections.csv', 'a');
		fwrite($f,$data);
		fclose($f);
		}
		elseif ($term_id == '226'){			
		$data = $section_id.",".$course_id.",".$name.",".$status."\n";
		$f = fopen('sections.csv', 'a');
		fwrite($f,$data);
		fclose($f);
		}
		else{}*/

		//Creating courses.csv with term_id
		/*Creating enrollments for active sections*/
			if($_GET['import_enrollments'] === 'y'){
				$url =$_SESSION['ps_url']."/ws/v1/section/".$section_id."/section_enrollment";
				//$url = "https://ps-vscsd.gwaea.org/ws/v1/district/school";
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
				//$json_str = "{'aintlist':[4,3,2,1], 'astringlist':['str1','str2']}";
				    //$json_obj = json_decode ($json_str);
				//print_r($response);
	
				foreach($response->section_enrollment as $enrollment){
					$state = (String) $enrollment->dropped;
					$section_en_id = (String) $enrollment->section_id;
					$user_id = (String) $enrollment->student_id;
					$role = "student";
					$status = "active";
					
					if ($state == 'false'){
						//do nothing
					}else{
						$data = $user_id.",".$role.",".$section_en_id.",".$status."\n";
						$f = fopen('enrollments.csv', 'a');
						fwrite($f,$data);
						fclose($f);
					}
			
				}
				}
		
		
		
		$data = $section_id.",".$course_id.",".$name.",".$status."\n";
		$f = fopen('sections.csv', 'a');
		fwrite($f,$data);
		fclose($f);
		}
		$s++;
	}
		
	
	
	
	}else{
		//do nothing
	}

if ($_GET['import_students'] === 'y'){
		$fp = fopen('users.csv', 'w');
		$data = "user_id,login_id,first_name,last_name,email,status\n";
		//writing users.csv headers
		fwrite($fp,$data);
	//print_r($_GET['schools']);	
		//get student count
		$url = $_SESSION['ps_url']."/ws/v1/school/".$school_id."/student/count";
		//echo $url."<br>";
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
		//echo "<br>";
		$st = 0;
		//store course count as $count
		$student_count = $response->count;
		//echo $student_count;
		// setting remainder to determing how many pages to request from API
		$pages = $student_count / 100;
		//echo $pages;
		$num = 1;
		//creating users.csv for download
		//looping through API requests for as many pages as necessary to complete student
		while($st < $pages){
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
			$st++;
			}
		}else{
			//do nothing
		}
if($_GET['import_staff'] === 'y'){
	//get student count
	$url = $_SESSION['ps_url']."/ws/v1/school/".$school_id."/staff/count";
	//echo $url."<br>";
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
	//echo "<br>";
	$st = 0;
	//store course count as $count
	$student_count = $response->count;
	//echo $student_count;
	// setting remainder to determing how many pages to request from API
	$pages = $student_count / 100;
	//echo $pages;
	$num = 1;
	//creating users.csv for download
	//looping through API requests for as many pages as necessary to complete student
	while($st < $pages){
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
		$st++;
		}
	}else{
		//do nothing
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

echo "<div class='span6'>";
echo "<legend>Download Import Files</legend>";
if($_GET['import_courses'] === 'y'){
	
	echo "<a class='btn btn-primary' href='courses.csv'><i class='icon-download-alt icon-white'></i> Courses.csv</a>";
}
if($_GET['import_sections'] === 'y'){
	echo "<a class='btn btn-primary' href='sections.csv'><i class='icon-download-alt icon-white'></i> Sections.csv</a>";
}
if($_GET['import_enrollments'] === 'y'){
	echo "<a class='btn btn-primary' href='enrollments.csv'><i class='icon-download-alt icon-white'></i> Enrollments.csv</a>";
} 
if($_GET['import_students'] === 'y' && $_GET['import_staff'] === 'y'){
	echo "<a class='btn btn-primary' href='users.csv'><i class='icon-download-alt icon-white'></i> Staff and Students</a>";
	}elseif($_GET['import_students'] === 'y'){
	echo "<a class='btn btn-primary' href='users.csv'><i class='icon-download-alt icon-white'></i> Students</a>";
	}elseif($_GET['import_staff'] === 'y'){
	echo "<a class='btn btn-primary' href='users.csv'><i class='icon-download-alt icon-white'></i> Staff</a>";
	}
echo "</div>";

?>
