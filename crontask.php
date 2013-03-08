<?php
$ps_token = $_GET['access_token'];
$canvas_token = $_GET['canvas_token'];
$ps_url = $_GET['ps_url'];
$schools = $_GET['schools'];
foreach($schools as $school){
$school_id = $school[0];
$url = $ps_url."/ws/v1/school/".$school_id."/course/count";
	$ch = curl_init($url);
	$request_headers = array('Authorization: Bearer ' . $ps_token,
	'Content-Type: application/x-www-form-urlencoded;charset=UTF-8');
	curl_setopt($ch,CURLOPT_HTTPHEADER,$request_headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$response = new SimpleXMLElement(curl_exec($ch));
	curl_close($ch);		
	$c = 0;
	$course_count = $response->count;
	$pages = $course_count / 100;
	$num = 1;
	$fp = fopen('courses.csv', 'w');
	$data = "course_id,short_name,long_name,term_id,status\n";
	$fp = fwrite($fp, $data);
	while($c < $pages){
		$url = $ps_url."/ws/v1/school/".$school_id."/course?page=".$num;
		$ch = curl_init($url);
		$request_headers = array('Authorization: Bearer ' . $ps_token,
				'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'
		);
		$ch = curl_init($url);		
		curl_setopt($ch,CURLOPT_HTTPHEADER,$request_headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = new SimpleXMLElement(curl_exec($ch));
		curl_close($ch);		
		$num++;
		foreach($response->course as $course)
			{
    		$course_id = (String) $course->id;
			$short_name = (String) $course->course_number;
			$long_name = (String) $course->course_name;
			$status = 'active';
			$data = $course_id.",".$short_name.",".$long_name.",".$term_id.",".$status."
";
			$f = fopen('courses.csv', 'a');
			fwrite($f,$data);
			fclose($f);
			}
			$c++;	
	}
}