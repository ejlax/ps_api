<?php
ob_start();
session_start();
echo "<legend>Schedule Import Files</legend>";
	echo "<form method='get' action='schedule.php'>";
if($_GET['import_courses'] === 'y'){
		$fp = fopen($_SESSION['access_token'].'/courses.csv', 'w');
	$data = "course_id,short_name,long_name,term_id,status\n";
	$fp = fwrite($fp, $data);
	echo "<input type='hidden' name='import_courses' value='y'></input>";
}
if($_GET['import_sections'] === 'y'){
	echo "<input type='hidden' name='import_sections' value='y'></input>";
 }
if($_GET['import_enrollments'] === 'y'){
	echo "<input type='hidden' name='import_enrollments' value='y'></input>";
}
if($_GET['import_students'] === 'y'){
	echo "<input type='hidden' name='import_students' value='y'></input>";
}
if($_GET['import_staff'] === 'y'){
	echo "<input type='hidden' name='import_staff' value='y'></input>";
}

echo "<div class='accordion' id='accordion2'>";
if(file_exists($_SESSION['access_token']."/schools.txt")){
	unlink($_SESSION['access_token']."/schools.txt");
}
foreach($_GET['schools'] as $school){
	$school_id = $school[0];
	$file = $_SESSION['access_token']."/schools.txt";
	$data = $school_id."\n";
	if(file_exists($_SESSION['access_token']."/schools.txt")){
		$handle = fopen($file, 'a');
		$fp = fwrite($handle, $data);
		fclose($handle);
	}else{
		$handle = fopen($file, 'w');
		$fp = fwrite($handle, $data);
		fclose($handle);
	}	
	//echo $school_id."<br>";
	if ($_GET['import_courses'] === 'y'){
	$url =$_SESSION['ps_url']."/ws/v1/school/".$school_id."/course/count";
	$ch = curl_init($url);
	$request_headers = array('Authorization: Bearer ' . $_SESSION['access_token'],
	'Content-Type: application/x-www-form-urlencoded;charset=UTF-8');
	curl_setopt($ch,CURLOPT_HTTPHEADER,$request_headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$response = new SimpleXMLElement(curl_exec($ch));
	curl_close($ch);		
	$c = 0;
//store course count as $count
	$course_count = $response->count;
	$pages = $course_count / 100;
	$num = 1;

			echo"<div class='accordion-group'>
			    <div class='accordion-heading'>
			      <h4 class='accordion-toggle' data-toggle='collapse' data-parent='#accordion' href='#courses".$school_id."' align='center'>
			        Preview Courses
			      </h4>
			    </div>
			    <div id='courses".$school_id."' class='accordion-body collapse out'>
			      <div class='accordion-inner'>
			        		<div id='courses_preview' class='table'><table class='table table-striped table-condensed'>
			<thead><tr><td>Course&nbspID</td><td>Short&nbspName</td><td>Long&nbspName</td><td>Status</td></tr></thead>";
		$pre = 0;
	while($c < $pages){
		
		$url = $_SESSION['ps_url']."/ws/v1/school/".$school_id."/course?page=".$num;
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
		//print_r($response);
		$num++;
		foreach($response->course as $course)
			{
    		$course_id = (String) $course->id;
			$course_num = (string) $course->course_number;
			$short_name = (String) $course->course_name;
			//$long_name = (String) $course->course_name;
			$term_id = 226;
			$status = 'active';
			$data = $course_id.",".$short_name.",".$short_name."-".$course_num.".".$term_id.",".$status."\n";
			$f = fopen($_SESSION['access_token'].'/courses.csv', 'a');
			fwrite($f,$data);
			fclose($f);
				echo "<tr><td>".$course_id."</td><td>".$short_name."</td><td>".$short_name."-".$course_num."</td><td>".$status."</td></tr>";	

			}
			
			$c++;
		
	}echo "</table></div></div></div></div>";
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
	fwrite($fp,$data);
	fclose($fp);
			echo "
			  <div class='accordion-group'>
			    <div class='accordion-heading'>
			      <h4 class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#sections' align='center'>
			        Preview Sections
			      </h4>
			    </div>
			    <div id='sections' class='accordion-body collapse out'>
			      <div class='accordion-inner'>
			        		<div id='students_preview' class='table'><table class='table table-striped table-condensed'>
			<thead><tr><td>Section&nbspID</td><td>Course&nbspID</td><td>Name</td><td>Status</td></tr></thead>";
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
		$status = 'active';
		$end = 1;
		echo "<tr><td>".$section_id."</td><td>".$course_id."</td><td>".$name."</td><td>".$status."</td></tr>";
		
		 // change this to deleted to remove sections

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
		//Creating enrollments for active sections
			
		$data = $section_id.",".$course_id.",".$name.",".$status."\n";
		$f = fopen('sections.csv', 'a');
		fwrite($f,$data);
		fclose($f);
					
			}
		$s++;	
		}echo "</table></div></div></div></div>";
		
	}
		
	
	
	
	/*}else{
		//do nothing
	}*/

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
		echo"
			  <div class='accordion-group'>
			    <div class='accordion-heading'>
			      <h4 class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#students' align='center'>
			        Preview Students
			      </h4>
			    </div>
			    <div id='students' class='accordion-body collapse out'>
			      <div class='accordion-inner'>
			        		<div id='students_preview' class='table'><table class='table table-striped table-condensed'>
			<thead><tr><td>User_ID</td><td>Login_id</td><td>First&nbspName</td><td>Last&nbspName</td></tr></thead>";

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
					echo "<tr><td>".$user_id."</td><td>".$email."</td><td>".$fname."</td><td>".$lname."</td></tr>";	
			}

			$st++;
			}			echo "</table></div></div></div>
			    </div>";
		}else{
			//do nothing
		}
if($_GET['import_enrollments'] === 'y'){
	
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
		echo"
			  <div class='accordion-group'>
			    <div class='accordion-heading'>
			      <h4 class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#enrollments' align='center'>
			        Preview Enrollments
			      </h4>
			    </div>
			    <div id='enrollments' class='accordion-body collapse out'>
			      <div class='accordion-inner'>
			        		<div id='enrollments_preview' class='table'><table class='table table-striped table-condensed'>
			<thead><tr><td>User_ID</td><td>Role</td><td>Section&nbspID</td><td>Statuse</td></tr></thead>";
	while($s < $pages){

		$url =$_SESSION['ps_url']."/ws/v1/school/".$school_id."/section?page=".$num;
		//$url = "https://ps-vscsd.gwaea.org/ws/v1/district/school";
		//api/v1/accounts/1/sis_imports/17888.json?access_token=".$token;
		//echo $url."<br>";
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
		$s++; // controls while loop
		$num++; // control number of pages requested					
		foreach($response->section as $section)
		{
    	$section_id = (String) $section->id;
    	$course_id = (String) $section->course_id;		
		$name = (String) $section->section_number;
		$term_id = (String) $section->term_id;
		$status = 'active';

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
						echo "<tr><td>".$user_id."</td><td>".$role."</td><td>".$section_en_id."</td><td>".$status."</td></tr>";	
						}

					}					
				}
			}echo "</table></div></div></div></div>";
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
	$staff_count = $response->count;
	//echo $student_count;
	// setting remainder to determing how many pages to request from API
	$pages = $staff_count / 100;
	//echo $pages;
	$num = 1;
	echo "
	
	<div class='accordion-group'>
	    <div class='accordion-heading' '>
	      <h4 class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#staff' align='center'>
	        Preview Staff
	      </h4>
	    </div>
	    <div id='staff' class='accordion-body collapse out'>
	      <div class='accordion-inner'>
	        		<div id='staff' class='table'><table id='staff_preview' class='table table-striped table-hover table-condensed'>
	<thead><tr><td>User_ID</td><td>Login_id</td><td>First&nbspName</td><td>Last&nbspName</td></tr></thead><tbody>";
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
					echo "<tr><td>".$user_id."</td><td>".$email."</td><td>".$fname."</td><td>".$lname."</td></tr>";	
					
				}

			  $st++;
		}			echo "</tbody></table></div></div>
			    </div></div>
			  ";
		
		}else{
		//do nothing
	}
	
}
echo "</div>";
	

	

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
	echo "<button class='btn btn-info' type='submit'>Schedule Sync</button>
	</form>";
echo "</div>";

?>

