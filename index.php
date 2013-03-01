<?php
session_start();
ob_start();
include_once('header.php');
if(isset($_SESSION['access_token']) && isset($_SESSION['ps_url'])){
	session_unset();
}
$ps_url= $_GET['ps_url'];
$_SESSION['ps_url'] = $ps_url; 
$ps_code = $_GET['client_id'];
$ps_secret = $_GET['client_secret'];
$auth_url = $ps_url."/oauth/access_token/";
//$auth = base64_encode($ps_code.$ps_secret);
//echo $auth_url;

//print_r($_GET);
if( isset($ps_url) && isset($ps_secret) && isset($ps_code)){
		
	
	$ch = curl_init($auth_url);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
	curl_setopt($ch, CURLOPT_USERPWD, "$ps_code:$ps_secret");
	$response = curl_exec($ch);
	$json = json_decode($response);
	//print_r($json);
	//$result = new SimpleXMLElement(curl_exec($ch));
	//unset($_SESSION['access_token']);
	if(curl_errno($ch)){
	  $curlerror = 'Curl error: ' . curl_error($ch);
	}
	else{    
	  //print_r($result);
	  $_SESSION['access_token'] = $json->access_token;
	  $_SESSION['ps_url'] = $ps_url;
	  //$_SESSION['access_token'] = $result['access_token'];
	  //echo $_SESSION['access_token'];
	  }
	
	
	
	
	//$_SESSION['ps_url'] = $ps_url;
	//echo $_SESSION['access_token'];
	}else{
		echo "<div class='span4'><h6>Please input your client Id, client secret, and PowerSchool URL in the <a href='https://lti-examples.heroku.com/index.html?tool=redirect'>Redirect LTI tool</a>.<p>This Program will not function until you do.<p></h6></div>";
		break;
		}
header("location:select.php");
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
          <div class="span10">
         <!--   <div class="tabbable tabs-left">
          	<ul class="span3 nav nav-tabs">
            <li><a href="#tab1" data-toggle="tab">Generate Token</a></li>
            <li class='disabled'><a href="#tab2" data-toggle="tab">Select Schools</a></li>
            <li class='disabled'><a href="#tab3" data-toggle="tab">Import Staff and Students</a></li>
            <li class='disabled'><a href="#tab4" data-toggle="tab">Import Courses and Sections</a></li>
			<li class='disabled'><a href="#tab5" data-toggle="tab">Import Enrollments</a></li>          
          </ul>	
          <div id="nav nav-tab" class="span7 tab-content">
            <div style="overflow: visible;" class="tab-pane" id="tab1">
              	<form class="form-condensed" method="post" action="oauth.php" id='get_token'>
				  <div class="control-group">
				    <label class="control-label" for="imageId"></label>
				    <div class="controls">
						<input type="hidden" name="client_id" value='<?php echo $client_id;?>'></input>
						<input type="hidden" name="client_secret" value='<?php echo $client_secret;?>'></input>
						<input type="hidden" name="ps_url" value='<?php echo $ps_url;?>'></input>
				    </div>
				  </div>
				  <div class="control-group">
				  <button type="submit" class="btn">Get Token</button><img id='loading' style='display: none;' src='img/ajax-loader.gif'>
					</div>				
				</form>  -->
				<h5 class='hidden' id="token"><?php echo $_SESSION['access_token'];?></h5>
				<form method='post' action='select.php'>
					<input type='hidden' name='access_token' value="<?php echo $_SESSION['access_token'];?>"></input>
					<input type='hidden' name='ps_url' value="<?php echo $_SESSION['ps_url'];?>"></input>
					<button type="submit" class="btn">Select Schools</button>
				</form>
				
           	</div>
           	    
         	</div><!--/nav-tab-->
        	</div><!--/tabbable-->
        	
        </div><!--/span-->
       </div>
      </div><!--/row-->

      <?php
include_once('footer.php');
?>
      
<!--  <script>$('#get_token').bind('submit', function() {
  $('#loading').show()
});
</script>
<script>
	$("#get_token").submit(function(){
		$("#loading").submit(function(){
    $(this).show();
}).ajaxStop(function(){
   $(this).hide();
});
</script>  -->
<script> 
$("#get_token").submit(function(){
        var formdata = $(this).serialize(); // Serialize all form data

    // Post data to your PHP processing script
    $.post( "oauth.php", formdata, function( data ) {
        // Act upon the data returned, setting it to #success <div>
        $("#token").html ( data );
    });

    return false; // Prevent the form from actually submitting
});
</script>

<?php

$_POST['access_token'] = $_SESSION['access_token'];
?>

  </body>
</html>

