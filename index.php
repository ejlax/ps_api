<?php
session_start();
//include_once('verify.php');
//require_once 'AWSSDKforPHP/sdk.class.php';
//$ec2 = new AmazonEC2();
include_once('header.php');
$client_id = $_GET['client_id'];
$client_secret = $_GET['client_secret'];
$ps_url = $_GET['ps_url'];
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
          <div class="tabbable tabs-left">
          	<ul class="span3 nav nav-tabs">
            <li><a href="#tab1" data-toggle="tab">Generate Token</a></li>
            <li><a href="#tab2" data-toggle="tab">Select Schools</a></li>
            <li><a href="#tab3" data-toggle="tab">Import Staff and Students</a></li>
            <li><a href="#tab4" data-toggle="tab">Import Courses and Sections</a></li>
			<li><a href="#tab5" data-toggle="tab">Import Enrollments</a></li>            
          </ul>	
          <div id="nav nav-tab" class="span7 tab-content">
            <div style="overflow: visible;" class="tab-pane" id="tab1">
              	<form class="form-condensed" method="post" action="oauth.php" id='get_token'>
				  <div class="control-group">
				    <label class="control-label" for="imageId"><h5>Get Token</h5></label>
				    <div class="controls">
						<input type="hidden" name="client_id" value='<?php echo $client_id;?>'></input>
						<input type="hidden" name="client_secret" value='<?php echo $client_secret;?>'></input>
						<input type="hidden" name="ps_url" value='<?php echo $ps_url;?>'></input>
				    </div>
				  </div>
				  <div class="control-group">
				  <button type="submit" class="btn">Get Token</button><img id='loading' style='display: none;' src='img/ajax-loader.gif'>
					</div>				
				</form>
				<h5 id="token"></h5>
				<form method='post' action='imports.php'>
					<input type='hidden' name='access_token' value="<? echo $_SESSION['access_token'];?>"></input>
					<input type='hidden' name='ps_url' value="<?php echo $ps_url;?>"></input>
					<button type="submit" class="btn">Save Token</button>
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
