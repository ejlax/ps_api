<?php
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
            <li><a href="#tab2" data-toggle="tab">Import Staff and Students</a></li>
            <li><a href="#tab3" data-toggle="tab">Import Courses and Sections</a></li>
			<li><a href="#tab4" data-toggle="tab">Import Enrollments</a></li>            
          </ul>	
          <div id="nav nav-tab" class="span7 tab-content">
            <div style="overflow: visible;" class="tab-pane" id="tab1">
              	<form class="form-condensed" method="post" action="oauth.php" id='create'>
				  <div class="control-group">
				    <label class="control-label" for="imageId"><h5>Platform</h5></label>
				    <div class="controls">
						<input type="hidden" id="client_id" value='<?echo $client_id;?>'></input>
						<input type="hidden" id="client_secret" value='<?echo $client_secret;?>'></input>
						<input type="hidden" id="ps_url" value='<?echo $ps_url;?>'></input>
				    </div>
				  </div>
				  <div class="control-group">
				  <button type="submit" class="btn">Get Token</button><img id='loading' style='display: none;' src='img/ajax-loader.gif'>
				</form>
           	</div>
           	<div style="overflow: visible;" class="tab-pane" id="tab2">
				<form class="form-condensed" method="post" action="create_tag.php">
				 <div class="control-group">
				    <label class="control-label" for="keyPair"><h5>Resource ID</h5></label>
				    <div class="controls">
				      <select name="resource_id">
				      </select>
				    </div>
				  </div>
				  <div class="control-group">
				    <label class="control-label" for="securityGroup"><h5>Key Name Value Pair</h5></label>
				    <div class="controls">
				    	<label class='control-label' for='keyName'>Key Name</label>
				      <input type='text' name='keyName'>
				    	<label class='control-label' for='keyName'>Key Value</label>				      
				      <input type='text' name='keyValue'>
				    </div>
				  </div>
				  <button type="submit" class="btn">Add Tag</button>
				</form>
           	</div>
           	<div style="overflow: visible;" class="tab-pane" id="tab3">
				<form class="form-condensed" method="post" action="create_vol.php">
				 <div class="control-group">
				    <label class="control-label" for="keyPair"><h5>Instance ID</h5></label>
				    <p>This is the instance to which you will add the volume.</p>
				    <div class="controls">
				      <select name="resource_id">
				      </select>
				    </div>
				  </div>
				  <div class="control-group">
				    <label class="control-label" for="securityGroup"><h5>Volume Info</h5></label>
				    <div class="controls">
				    <label class='control-label' for='keyName'><h5>Volume Size (in GB)</h5></label>
				      <input type='text' name='size'>	
				    	<label class='control-label' for='keyName'><h5>Tag Name</h5></label>
				    	<p>Tag name of 'name' will give the instance a reference name</p>
				      <input type='text' name='key'>
				    	<label class='control-label' for='keyName'>Tag Value</label>
				    	<p>The value of the tag you want to create</p>			      
				      <input type='text' name='value'>
				    </div>
				  </div>
				  <button type="submit" class="btn">Add Tag</button>
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

      
      <script>$('#create').bind('submit', function() {
  $('#loading').show()
});
</script>
<script>
	$("#create").submit(function(){
		$("#loading").submit(function(){
    $(this).show();
}).ajaxStop(function(){
   $(this).hide();
});
</script>
