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
              <li class="active"><a href="https://lti-examples.heroku.com/index.html?tool=redirect"><i class="icon-hand-right icon-black"></i>Redirect LTI Tool</a></li>
              <li><a href="schedule.php"><i class="icon-calendar icon-black"></i>Schedule</a></li>
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
    	    