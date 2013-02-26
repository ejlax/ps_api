<?php
session_start();

$fp = fopen('courses.csv', 'w');
//fwrite($fp,$json_str);
$data = "course_id,short_name,long_name,status\n";
$fp = fwrite($fp, $data);
foreach($_GET['schools'] as $school){

//$_SESSION['access_token'] = "d3389800-3540-4b51-889a-3ee5a1c9cdda";
//$inputFile = "/Users/eric/Documents/canvas/vscsd-students-test.csv";
//get course count by school
$url =$_SESSION['ps_url']."/ws/v1/school/".$school."/course/count";
//$url = "https://ps-vscsd.gwaea.org/ws/v1/district/school";
//api/v1/accounts/1/sis_imports/17888.json?access_token=".$_SESSION['access_token'];
//echo $url."<br>";
$ch = curl_init($url);
$request_headers = array('Authorization: Bearer ' . $_SESSION['access_token'],
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
$i = 0;
//store course count as $count
foreach($response->count as $course_count) {
	echo "This school has ".$course_count." courses.";

}

$pages = $course_count / 100;

echo $pages;
$num = 1;

while($i < $pages){
		
			$url =$_SESSION['ps_url']."/ws/v1/school/".$school."/course?page=".$num;
		//$url = "https://ps-vscsd.gwaea.org/ws/v1/district/school";
		//api/v1/accounts/1/sis_imports/17888.json?access_token=".$_SESSION['access_token'];
		//echo $url."<br>";
		$ch = curl_init($url);
		$request_headers = array('Authorization: Bearer ' . $_SESSION['access_token'],
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
		$num++;
		
		foreach($response->course as $course)
		{
    	$course_id = (String) $course->id;
		$short_name = (String) $course->course_number;
		$long_name = (String) $course->course_name;
		$status = 'active';
		$data = $course_id.",".$short_name.",".$long_name.",".$status."\n";
		$f = fopen('courses.csv', 'a');
		fwrite($f,$data);
		fclose($f);
		}
		
		$i++;
		
		}

}
?>