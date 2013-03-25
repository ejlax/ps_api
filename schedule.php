<?php

ob_start();
var_dump($_GET);
 ?>
 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Canvas PowerSchool API Tool</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href='css/tableutils.css' rel='stylesheet'>
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
/*      #staff.table{
  width: 100%;
  margin-bottom: 20px;
  height: 300px;
  overflow: auto;
}*/
      .accordion-inner .table{
      	
  width: 100%;
  margin-bottom: 20px;
  height: 300px;
  overflow: auto;
}
.accordion-heading{
	  min-height: 20px;
  padding-right: 20px;
  padding-left: 20px;
  background-color: #fafafa;
  background-image: -moz-linear-gradient(top, #ffffff, #f2f2f2);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#f2f2f2));
  background-image: -webkit-linear-gradient(top, #ffffff, #f2f2f2);
  background-image: -o-linear-gradient(top, #ffffff, #f2f2f2);
  background-image: linear-gradient(to bottom, #ffffff, #f2f2f2);
  background-repeat: repeat-x;
  border: 1px solid #d4d4d4;
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#fff2f2f2', GradientType=0);
  *zoom: 1;
  -webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.065);
     -moz-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.065);
          box-shadow: 0 1px 4px rgba(0, 0, 0, 0.065);
}
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../aws_portal/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../aws_portal/img/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../aws_portal/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../aws_portal/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../aws_portal/ico/apple-touch-icon-57-precomposed.png">

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="index.php">Canvas PowerSchool API Tool</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class=""><a href="https://lti-examples.heroku.com/index.html?tool=redirect"><i class="icon-hand-right icon-black"></i>Redirect LTI Tool</a></li>
              <li class='active'><a href="schedule.php"><i class="icon-calendar icon-black"></i>Schedule</a></li>
            </ul>
            <ul class="nav pull-right">
            	<li class="dropdown">
            		<!--<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="icon-user"></b>Welcome<b class="caret"></b></a>
              		<ul class="dropdown-menu">
						<!--  <li><a href='#'>Settings</a></li>  
		                <li><a href='#'>Profile</a></li>  
		                <li class='divider'></li>   
		                <li><a href='logout.php'>Logout</a></li>
        			</ul>   -->
          		</li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
                        <!--  <ul class="breadcrumb hidden-desktop">
			  <li><a href="fluid.php">Home</a> <span class="divider">/</span></li>
			  <li><a href="instances.php">Instances</a> <span class="divider">/</span></li>
			  <li class="active">Search</li>
			</ul>  -->
    </div>    
    <div class='span1'></div>
    	    
<div class='row-fluid span6'>
	<div class='content'><h3>Please select the best schedule for you below. </h3><h4>Please only pick one.</h4></div>
		<div>
			<form class='form-horizontal' method='get' action='cron_create.php'>
				<legend><a id='once' href="#" data-toggle="tooltip" data-placement="right" title="" data-original-title="Thiw will schedule a daily sync.">Once a Day</a>
				<input type="hidden" name='once_a_day' value=1></input></legend>
				<select name='sched_time'>
					<option value='0'>00:00</option>
					<option value='1'>01:00</option>
					<option value='2'>02:00</option>
					<option value='3'>03:00</option>
					<option value='4'>04:00</option>
					<option value='5'>05:00</option>
					<option value='6'>06:00</option>
					<option value='7'>07:00</option>
					<option value='8'>08:00</option>
					<option value='9'>09:00</option>
					<option value='10'>10:00</option>
					<option value='11'>11:00</option>
					<option value='12'>12:00</option>
					<option value='13'>13:00</option>
					<option value='14'>14:00</option>
					<option value='15'>15:00</option>
					<option value='16'>16:00</option>
					<option value='17'>17:00</option>
					<option value='18'>18:00</option>
					<option value='19'>19:00</option>
					<option value='20'>20:00</option>
					<option value='21'>21:00</option>
					<option value='22'>22:00</option>
					<option value='23'>23:00</option>
				</select>
				<button class='btn btn-info' type='submit'>Schedule</button>
			</form>
		</div>
		<div>
			<form class='form-horizontal'method='get' action='cron_create.php'>
				<legend><a id='twice' href="#" data-toggle="tooltip" data-placement="right" title="" data-original-title="Thiw will schedule a sync twice a day.">Twice a Day</a>
				<input type="hidden" name='twice_a_day' value=1></input></legend>
				<select name='sched_time'class='multiple'>
					<option value='0'>00:00</option>
					<option value='1'>01:00</option>
					<option value='2'>02:00</option>
					<option value='3'>03:00</option>
					<option value='4'>04:00</option>
					<option value='5'>05:00</option>
					<option value='6'>06:00</option>
					<option value='7'>07:00</option>
					<option value='8'>08:00</option>
					<option value='9'>09:00</option>
					<option value='10'>10:00</option>
					<option value='11'>11:00</option>
					<option value='12'>12:00</option>
					<option value='13'>13:00</option>
					<option value='14'>14:00</option>
					<option value='15'>15:00</option>
					<option value='16'>16:00</option>
					<option value='17'>17:00</option>
					<option value='18'>18:00</option>
					<option value='19'>19:00</option>
					<option value='20'>20:00</option>
					<option value='21'>21:00</option>
					<option value='22'>22:00</option>
					<option value='23'>23:00</option>
				</select>
				<button class='btn btn-info' type='submit'>Schedule</button>
			</form>
		</div>
		<div>
			<form class='form-horizontal' method='get' action='cron_create.php'>
				<legend><a id='thrice' href="#" data-toggle="tooltip" data-placement="right" title="" data-original-title="Thiw will schedule a sync three times a day.">Three times a Day</a>
				<input type="hidden" name='twice_a_day' value=1></input></legend>
				<select name='sched_time'>
					<option value='0'>00:00</option>
					<option value='1'>01:00</option>
					<option value='2'>02:00</option>
					<option value='3'>03:00</option>
					<option value='4'>04:00</option>
					<option value='5'>05:00</option>
					<option value='6'>06:00</option>
					<option value='7'>07:00</option>
					<option value='8'>08:00</option>
					<option value='9'>09:00</option>
					<option value='10'>10:00</option>
					<option value='11'>11:00</option>
					<option value='12'>12:00</option>
					<option value='13'>13:00</option>
					<option value='14'>14:00</option>
					<option value='15'>15:00</option>
					<option value='16'>16:00</option>
					<option value='17'>17:00</option>
					<option value='18'>18:00</option>
					<option value='19'>19:00</option>
					<option value='20'>20:00</option>
					<option value='21'>21:00</option>
					<option value='22'>22:00</option>
					<option value='23'>23:00</option>
				</select>
				<button class='btn btn-info' type='submit'>Schedule</button>
			</form>
		</div
	</div>
</div>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
	<script src='js/tableutils.js'></script>
    <script src="js/bootstrap.js"></script>
<script>
	$('#once').tooltip('hover: {show}');


</script>
<script>
			$('#twice').tooltip('hover: {show}');
</script>
<script>
				$('#thrice').tooltip('hover: {show}');
</script>
<?php
include_once('footer.php');
?>



