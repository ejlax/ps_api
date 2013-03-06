<?php
ob_start();
session_start();
$token = "d3389800-3540-4b51-889a-3ee5a1c9cdda";
/*if(!isset($_SESSION['access_token'])){
	echo "<div class='alert-error'><h6>There is no access token configured. Redirecting you to LTI Redirect tool.</h6></div>";
	sleep(5);
	header('location: index.php');
}*/
//$token = $_SESSION['acces_token'];
//$inputFile = "/Users/eric/Documents/canvas/vscsd-students-test.csv";
//get course count by school
$url ="https://ps-vscsd.gwaea.org/ws/v1/school/6/section/count?q=term.start_year==2012";
//$url = "https://ps-vscsd.gwaea.org/ws/v1/district/school";
//api/v1/accounts/1/sis_imports/17888.json?access_token=".$token;
//echo $url."<br>";
$ch = curl_init($url);
$request_headers = array('Authorization: Bearer ' . $token,
		'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'
);

# Initiate cURL, adding the REQUEST_HEADERS to it for authentication
$ch = curl_init($url);
echo $url."<br>";
//print_r($request_headers);
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
$i = 0;
//store course count as $count
foreach($response->count as $section_count) {
	echo "This school has ".$section_count." courses.";

}

$pages = $section_count / 100;

echo $pages;
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
while($i < $pages){
		
		$url ="https://ps-vscsd.gwaea.org/ws/v1/school/6/section?page=".$num;
		//$url = "https://ps-vscsd.gwaea.org/ws/v1/district/school";
		//api/v1/accounts/1/sis_imports/17888.json?access_token=".$token;
		//echo $url."<br>";
		$ch = curl_init($url);
		$request_headers = array('Authorization: Bearer ' . $token,
				'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'
		);
		
		# Initiate cURL, adding the REQUEST_HEADERS to it for authentication
		$ch = curl_init($url);
		echo $url."<br>";
		//print_r($request_headers);
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
		$num++;
		
		foreach($response->section as $section)
		{
    	$section_id = (String) $section->id;
    	$course_id = (String) $section->course_id;		
		$name = (String) $section->section_number;
		$term_id = (String) $section->term_id;
		$status = 'active';

		/*$data = $section_id.",".$course_id.",".$name.",".$status."\n";
		$f = fopen('sections.csv', 'a');
		fwrite($f,$data);
		fclose($f);*/
		
		//add case for term_id (implement in later version)
		if ($term_id == '227'){
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
		else{}

		//Creating courses.csv with term_id
		/*Creating enrollments for active term section
				
				$url ="https://ps-vscsd.gwaea.org/ws/v1/section/".$section_id."/section_enrollment";
				//$url = "https://ps-vscsd.gwaea.org/ws/v1/district/school";
				//api/v1/accounts/1/sis_imports/17888.json?access_token=".$token;
				//echo $url."<br>";
				$ch = curl_init($url);
				$request_headers = array('Authorization: Bearer ' . $token,
						'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'
				);
				
				# Initiate cURL, adding the REQUEST_HEADERS to it for authentication
				$ch = curl_init($url);
				echo $url."<br>";
				//print_r($request_headers);
				echo "<br>";
				
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
			
			
		
		
		
		$data = $section_id.",".$course_id.",".$name.",".$status."\n";
		$f = fopen('sections.csv', 'a');
		fwrite($f,$data);
		fclose($f);
		}*/
		}
		
		$i++;
		
		}