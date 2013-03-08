<?php
ob_start();
session_start();
include_once('header.php');
//include_once('host-test.php');
if(!isset($_SESSION['access_token'])){
	echo "<div class='alert-error'><h6>There is no access token configured. Redirecting you to LTI Redirect tool.</h6></div>";
	sleep(5);
	header('location: index.php');
	
}
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

//print_r($_GET['schools']);
			echo "<div class='span10'>";
			echo "<div id='instances'>
          			<!--  Where the AJAX return HTML will go -->
          			</div>";

			echo "<div id='select' class='table'>";
			echo "<legend>Select Schools</legend>";
			echo"<form id='schools_submit' method='get' action=''>";
				echo "<table id='schools' class='table-condensed table-striped table-hover'>";
				echo "<thead><tr class='info'><th>Select</th><th>School&nbsp;Id</th><th>School&nbspName</th></tr>";
				echo "<tbody>";
	foreach($response->school as $school)
		{
		    	$school_id = (String) $school->id;
				$school_name = (String) $school->name;
					
				echo "<tr><td><input type='checkbox' value='".$school_id."' name='schools[]'></td><td>".$school_id."</td><td>".$school_name."</td></tr>";
				}	
				echo "</tbody></table><br>";
				echo "<legend>Import Users</legend>";
				echo "<label class='checkbox'>
			      <input type='checkbox' name='import_students' value='y'><h6>Import Students</h6>
			    </label>";
				echo "<label class='checkbox'>
			      <input type='checkbox' name='import_staff' value='y'><h6>Import Staff</h6>
			    </label>";
				echo "<legend>Import Course and Sections</legend>";
				echo "<label class='checkbox'>
			      <input type='checkbox' name='import_courses' value='y'><h6>Import Courses</h6>
			    </label>";
			    echo "<label class='checkbox'>
			      <input type='checkbox' name='import_sections' value='y'><h6>Import Sections</h6>
			    </label>";
				echo "<label class='checkbox'>
			      <input type='checkbox' name='import_enrollments' value='y'><h6>Import Enrollments</h6>
			    </label>";
				echo "<label class='checkbox'>
			      <input type='checkbox' name='import_terms' value='y'><h6>Import Term</h6>
			    </label>";
				echo "<button id='import' class='btn btn-primary' data-loading-text='Creating...' type='submit'>Create Import Files</button></p></form></div></div>";

				//include_once('footer.php');
}
?>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
	<script src='js/tableutils.js'></script>
    <script src="js/bootstrap.js"></script>
</script>
<script>
	$('#import').click(function () {
        var btn = $(this)
        btn.button('loading')
        //setTimeout(function () {
         //   btn.button('reset')
        //}, 100)
    });
</script>
</script>
<script>$('#schools_submit').bind('submit', function() {
  $('#loading').show()
});
</script>
<script>

</script>
<script>
	$("#schools_submit").submit(function(){
		$('#import').button();
		$('#import').submit(function(){
			$(this).button('loading');
		});
		$("#import").submit(function(){
   $(this).show();
}).ajaxStop(function(){
   $(this).hide();
   	$('#import').button(); 
        var btn = $(this)
        btn.button('reset')
        //setTimeout(function () {
         //   btn.button('reset')
        //}, 100)
      $("#select").fadeOut(500);
});

    // Intercept the form submission
    var formdata = $(this).serialize(); // Serialize all form data

    // Post data to your PHP processing script
    $.get( "imports.php", formdata, function( data ) {
        // Act upon the data returned, setting it to #success <div>
        //$("#instances").html ( data ).fadeIn("slow");
        $('#instances').hide().html( data ).fadeIn(800);
    });

    return false; // Prevent the form from actually submitting
});
</script>


