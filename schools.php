<?php
session_start();
//include_once('verify.php');
//require_once 'AWSSDKforPHP/sdk.class.php';
//$ec2 = new AmazonEC2();
include_once('header.php');
$token = $_SESSION['access_token'];
//$token = '5d38f5a9-24cf-4a87-a383-2e5f164d51cc';
//$ps_url = 'https://ps-vscsd.gwaea.org';
$ps_url = $_POST['ps_url'];
$_POST['ps_url'] = $_SESSION['ps_url'];
?>
          <!--  <div class="hero-unit">
            <h1>AWS Instance List</h1>
            <p>Live list of all instances in AWS</p>
            <p><a class="btn btn-primary btn-large" href="//aws.amazon.com/what-is-aws/">Learn more &raquo;</a></p>
          </div>  -->
        <div class="row-fluid">
		<div class="span10 content">
        <!-- Main hero unit for a primary marketing message or call to action -->
        <!-- Tabs -->
          <h2>PowerSchool API Integration</h2>
          <!--  <? echo $token." and ".$ps_url;?>  -->
          <div class="span10">
          <div class="tabbable tabs-left">
          	<ul class="span3 nav nav-tabs">
            <li><a href="#tab1" data-toggle="tab">Select Schools</a></li>
            <li><a href="#tab2" data-toggle="tab">Import Staff and Students</a></li>
            <li><a href="#tab3" data-toggle="tab">Import Courses and Sections</a></li>
			<li><a href="#tab4" data-toggle="tab">Import Enrollments</a></li>            
          </ul>	
          <div id="nav nav-tab" class="span7 tab-content">
            <div style="overflow: visible;" class="tab-pane" id="tab1">
				  <div class="control-group">
				    <label class="control-label" for="imageId"><h5>Select Schools</h5></label>
				    <div class="controls"><?
						//$inputFile = "/Users/eric/Documents/canvas/vscsd-students-test.csv";
						$url = $ps_url."/ws/v1/district/school";
						//api/v1/accounts/1/sis_imports/17888.json?access_token=".$token;
						//echo $url."<br>";
						$ch = curl_init($url);
						$request_headers = array('Authorization: Bearer ' . $token,
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
						}
						else{ 
						// Set headers
							curl_setopt($ch,CURLOPT_HTTPHEADER,$request_headers);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							$response = new SimpleXMLElement(curl_exec($ch));
							//$response = curl_exec($ch);
								//$info = curl_getinfo($ch);
								curl_close($ch);		
						print_r($response);
						
						/*
						 * $fp = fopen('courses.csv', 'w');
						//fwrite($fp,$json_str);
						$data = "course_id,short_name,long_name,status\n";
						fwrite($fp,$data);*/
						echo "<form method='get' action='sync.php' id='import'><select name='schools[]' multiple='multiple' size='10'>";
						foreach($response->school as $school)
						{
						    	$school_id = (String) $school->id;
								$school_name = (String) $school->name;
							echo "<option class='option' value='".$school_id."'>".$school_name."</option>";
						}
						echo "</select>";
									      	}?>
						<br><button type='submit' class="btn-info">Select Schools</button>
						</form>	
				    </div>
				  </div>
				  
         	</div><!--/nav-tab-->
        	</div><!--/tabbable-->
        </div><!--/span-->
       </div>
      </div><!--/row-->

      <?php
include_once('footer.php');
?>
<?php
$_POST['access_token'] = $_SESSION['access_token'];
?>

  </body>
</html>