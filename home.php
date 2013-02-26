<?php
ob_start();
error_reporting(E_ALL ^ E_NOTICE);
session_start();
include_once('header.php');
$file = $_GET['file'];
if($_SESSION['message'] == 1 ){
$error = 'Bad Username or Password. Please sign in again.';
	}elseif($_GET['message'] == 2){
	$error = 'Your session has timed out. Please Login again.';
	}elseif($_GET['message'] == 4){
	$error = 'That EmployeeId already has an account.';
	}elseif(!isset($_GET['message'])){
		$error = 'Something went wrong. Please sign in again.';
	}
?> <!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8'>
    <title>Canvas PowerSchool API Tool</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta name='description' content=''>
    <meta name='author' content=''>

    <!-- Le styles -->
    <link href='css/bootstrap.css' rel='stylesheet'>
    <style type='text/css'>
      body {
        padding-top: 40px;
        padding-bottom: 10px;
      }
    </style>
    <link href='css/bootstrap-responsive.css' rel='stylesheet'>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src='http://html5shim.googlecode.com/svn/trunk/html5.js'></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel='shortcut icon' href='ico/favicon.ico'>
    <link rel='apple-touch-icon-precomposed' sizes='144x144' href='ico/apple-touch-icon-144-precomposed.png'>
    <link rel='apple-touch-icon-precomposed' sizes='114x114' href='ico/apple-touch-icon-114-precomposed.png'>
    <link rel='apple-touch-icon-precomposed' sizes='72x72' href='ico/apple-touch-icon-72-precomposed.png'>
    <link rel='apple-touch-icon-precomposed' href='ico/apple-touch-icon-57-precomposed.png'>
  </head>

  <body>

    <div class='navbar navbar-fixed-top'>
      <div class='navbar-inner'>
        <div class='container-fluid'>
          <a class='btn btn-navbar' data-toggle='collapse' data-target='.nav-collapse'>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
          </a>
          <a class='brand' href='#'>Canvas PowerSchool API</a>
          <div class='nav-collapse collapse'>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
	<div class='container'>
          <!--  <div class='hero-unit' align='center'>
            <h1>Canvas PowerSchool API Tool</h1>
            <p>This tool allows you to export data from your Powerschool instance and import into your Canvas instance.</p>
            <p><a class='btn btn-primary btn-large' href='//instructure.com'>Learn more &raquo;</a></p>
          </div>  -->

      <div class='row-fluid'>
          <div class='accordion' id='accordion2'>
			  <div class='accordion-group'>
			    <div class='accordion-heading'>
			      <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion1' href='#collapseOne'>
			        Step 1. Get Your Access Token
			      </a>
			    </div>
			    <div id='collapseOne' class='accordion-body collapse in'>
			      <div class='accordion-inner'>
			        <form id='ps_token' class='form-horizontal' method='post' action='oauth.php'>
							<fieldset>
								<label class='UsernameLabel'>PowerSchool URL</label>
									<input type='text' id='ps_url' name='ps_url' class='InputBox' required>
								<label class='UsernameLabel'>Client Code</label>
									<input type='text' id='client_code' name='client_code' class='InputBox' required>
									<label class='PasswordLabel'>Client Secret</label>
									<input type='password' id='client_secret' name='client_secret' class='InputBox Password' required>
									<!--  <input type='hidden' name='file' value='<?php if(isset($file)){echo $file;}?>'>  -->
								<input type='submit' name='submit' value='Get Your Token' class='btn btn-primary'><br>
							</fieldset>
					</form>
					<div id='token'><p><h5></h5></p></div>
			      </div>
			    </div>
			  </div>
			  <div class='accordion-group'>
			    <div class='accordion-heading'>
			      <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#collapseTwo'>
			        Step 2. Input Canvas Information
			      </a>
			    </div>
			    <div id='collapseTwo' class='accordion-body collapse in'>
			      <div class='accordion-inner'>
			        <form id='canvas_token' class='form-horizontal' method='post' action='canvas.php'>
										<fieldset>
											<label class='UsernameLabel'>Canvas Domain</label>
												<input type='text' id='ps_url' name='canvas_domain' class='InputBox' required>
  											<label class='UsernameLabel'>Canvas Token</label>
												<input type='text' id='client_code' name='canvas_token' class='InputBox' required>
												<label class='PasswordLabel'>Canvas Account</label>
												<input type='password' id='client_secret' name='canvas_account' class='InputBox Password' required>
												<!--  <input type='hidden' name='file' value='<?php if(isset($file)){echo $file;}?>'>  -->
											<input type='submit' name='store' value='Store' class='btn btn-primary'><br>
										</fieldset>
										<!--  <div id='token'><p><h5><?php print_r($_SESSION);?></h5></p></div>   -->
									</form>
						<div id='response'><h5></h5></div>
			      </div>
			    </div>
			   </div>
			    <div class='accordion-group'>
			    <div class='accordion-heading'>
			      <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion3' href='#collapseThree'>
			        Step 3. Import Information
			      </a>
			    </div>
			    <div id='collapseThree' class='accordion-body collapse in'>
			      <div class='accordion-inner'>
			      	<?php
			      	$token = "d3389800-3540-4b51-889a-3ee5a1c9cdda";
//$inputFile = "/Users/eric/Documents/canvas/vscsd-students-test.csv";
$url ="https://ps-vscsd.gwaea.org/ws/v1/district/school";
//api/v1/accounts/1/sis_imports/17888.json?access_token=".$token;
//echo $url."<br>";
$ch = curl_init($url);
$request_headers = array('Authorization: Bearer ' . $token,
		'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'
);

# Initiate cURL, adding the REQUEST_HEADERS to it for authentication
$ch = curl_init($url);
//echo $url."<br>";
//print_r($request_headers);
echo "<br>";

// Set headers
	curl_setopt($ch,CURLOPT_HTTPHEADER,$request_headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$response = new SimpleXMLElement(curl_exec($ch));
		//$info = curl_getinfo($ch);
		curl_close($ch);		
//print_r($response);

/*
 * $fp = fopen('courses.csv', 'w');
//fwrite($fp,$json_str);
$data = "course_id,short_name,long_name,status\n";
fwrite($fp,$data);*/
echo "<p><h5>Select Your Schools</h5></p><form method='post' action='import.php' id='import'><select name='schools[]' multiple='multiple' size='10'>";
foreach($response->school as $school)
{
    	$school_id = (String) $school->id;
		$school_name = (String) $school->name;
	echo "<option class='option' value='".$school_id."'>".$school_name."</option>";
}
echo "</select>";
			      	?>

			    <fieldset id='select'>
					<select class='select' name='importType' id='importType'> 
						<option cless='option' value='all'>All (Users, Terms, Courses)</option>
						<option class='option' value='users_students'>Users (Students Only)</option>
						<option class='option' value='users_staff'>Users (Staff only)</option>
						<option class='option' value='users'>Users (Students and Staff)</option>
						<option class='option' value='term'>Terms</option>
						<option class='option' value='courses'>Courses</option>
					</select>
			    </fieldset>
			    <fieldset id='actions'>
			        <input type='submit' id='submit'  class='btn btn-primary' value='Import'>
			    </fieldset>
			</form>
			<div id='import_response'><h5></h5></div>
			      </div>
			    </div>
			  </div>
			</div>
		</div>	
			

		<hr>
		<?php inlude_once('footer.php');?>
      <footer>
        <!--  <p>&copy; Company 2012</p>  -->
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js'></script>
    <script src='js/bootstrap.js'></script>
     <script>
     $("#import").submit(function(){
        var formdata = $(this).serialize(); // Serialize all form data

    // Post data to your PHP processing script
    $.post( "import.php", formdata, function( data ) {
        // Act upon the data returned, setting it to #success <div>
        $("#import_response").html ( data );
    });

    return false; // Prevent the form from actually submitting
});
$("#ps_token").submit(function(){
        var formdata = $(this).serialize(); // Serialize all form data

    // Post data to your PHP processing script
    $.post( "oauth.php", formdata, function( data ) {
        // Act upon the data returned, setting it to #success <div>
        $("#token").html ( data );
    });

    return false; // Prevent the form from actually submitting
});
</script>

  </body>
</html>


