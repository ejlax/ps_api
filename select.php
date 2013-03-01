<?php
//ob_start();
session_start();
include_once('header.php');
/*if(!isset($_GET['schools'])){
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
	//echo "<form method='get' action='import_users.php' id='import'><select name='schools[]' multiple='multiple' size='10'>";


/*<div class="span 6 center">
	<form method='get' action='' id='list'>
            <table class="table table-hover" id="schools">
              <thead>
                <tr>
                  <th>Select?</th>
                  <th>#</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Username</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><input type='checkbox' value='1' name='schools[]'></input></td>
                  <td>1</td>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                </tr>
                <tr>
                  <td><input type='checkbox' value='2' name='schools[]'></input></td>	
                  <td>2</td>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td colspan="2">Larry the Bird</td>
                  <td>@twitter</td>
                </tr>
              </tbody>
            </table>
            <br><button class='btn-info btn-large' type='submit' value='Select'>Select</button>
          </form>
          </div>   
  </div>
         */ 

print_r($_GET['schools']);
			echo "<div class='table'>";
			echo"<form name='schools_submit' method='get' action='import_users.php'>";
				echo "<table id='schools' class='table-condensed table-striped table-hover'>";
				echo "<thead><tr class='info'><th>Select</th><th>School&nbsp;Id</th><th>School&nbspName</th></tr>";
				echo "<tbody>";
	foreach($response->school as $school)
		{
		    	$school_id = (String) $school->id;
				$school_name = (String) $school->name;
					
				echo "<tr><td><input type='checkbox' value='".$school_id."' name='schools[]'></td><td>".$school_id."</td><td>".$school_name."</td></tr>";
				}	
				echo "</tbody></table><button class='btn-primary' type='submit' value='submit'>Select Schools</button></form></div>";
include_once('footer.php');
}

?>
    <script type="text/javascript">$(document).ready(function() {

    $('#schools tr').click(function() {
        var href = $(this).find("a").attr("href");
        if(href) {
            window.location = href;
        }
    });

});
</script>
