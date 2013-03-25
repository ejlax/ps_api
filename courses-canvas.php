<?php
$account = 283;
$domain = "champlain.test";
$token = "1~OVzaepeSrdCKW9IJipmK2hMTeClJAQaGkD0RjQc59BDUQT3TRaUZgtPopqTdcKn4";
//$inputFile = "/Users/eric/Documents/canvas/vscsd-students-test.csv";
//$inputFile = "users.csv";
if(isset($domain)){
$data = "course_id,assignment_id,due_at,url\n";
$f = fopen('no_grade.csv', 'w');
fwrite($f,$data);
fclose($f);
$url ="https://".$domain.".instructure.com/api/v1/accounts/".$account."/sub_accounts?per_page=50&recursive=1&access_token=".$token;
//echo $url."<br>";
$ch = curl_init($url);
	//curl_setopt($ch, CURLOPT_POST, false);
	/*curl_setopt($ch, CURLOPT_GETFIELDS,
	array(
		  'access_token' => "$token")
	);*/
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($ch, CURLINFO_HEADER_OUT);
	if ($error = curl_error($ch)){
	echo "Error in curl call<br>";
	print_r($error);
	}else{
		$json = json_decode(curl_exec($ch));
		curl_close($ch);
		print_r($json);
		$count = 0;
		foreach($json as $item){
			$id = (String) $item->id;
			$url ="https://".$domain.".instructure.com/api/v1/accounts/".$id."/courses?per_page=50&access_token=".$token;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($ch, CURLINFO_HEADER_OUT);
			if ($error = curl_error($ch)){
			echo "Error in curl call<br>";
			print_r($error);
			}else{
			$output = json_decode(curl_exec($ch));
			curl_close($ch);
			foreach($output as $course){
				$course_id = (String) $course->id;
				//$course_name = (String) $course->name;
				$url ="https://".$domain.".instructure.com/api/v1/analytics/assignments/courses/".$course_id."?access_token=".$token;
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				if ($error = curl_error($ch)){
				echo "Error in curl call<br>";
				print_r($error);
				}else{
				$response = json_decode(curl_exec($ch));
				curl_close($ch);
				foreach ($response as $assignment) {
					$assignment_id = (String) $assignment->assignment_id;
					$missing = $assignment->tardiness_breakdown->missing;
					$due = (String) $assignment->due_at;
					if($missing > 0){
						$data = $course_id.",".$assignment_id.",".$due.",https://champlain.instructure.com/courses/".$course_id."/gradebook2\n";
						$f = fopen('no_grade.csv', 'a');
						fwrite($f,$data);
						fclose($f);
					}
				}


				//echo "<br>".$course_id.",".$course_name."<br>";
			}

		}
	}
		//$pages = $i / 10;
		$pg = 0;
		$num = 1;
		//echo "count of sub accounts: ".$count;
		//echo $i."<br>".$pages;

	}
}
}
/*
		$id = $json['name'];
$url ="https://".$domain.".instructure.com/api/v1/accounts/".$account."/courses?access_token=".$token."&with_enrollments=1";
//echo $url."<br>";
$ch = curl_init($url);
	//curl_setopt($ch, CURLOPT_POST, false);
	/*curl_setopt($ch, CURLOPT_GETFIELDS,
	array(
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
		//print_r ($output);
		$json = json_decode($output, true);
		$course_id = $json['id'];
		$name = $json['name'];
		print_r($json);
		echo "<br>";
		//print_r($info);
		//echo "<br>";
		//echo "Id =".$id."<br>";
		//echo "Progress=".$progress.'<br>';
		}
	}*/
?>