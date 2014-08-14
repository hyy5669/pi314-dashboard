<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <!--<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>-->
      <script src="../js/jquery.js"></script>
      <script>
         $(document).ready(function(){
           $('.carousel').carousel();
         });
      </script>
      <script type="text/javascript" src="../js/highchart.js"></script>
      <link rel="stylesheet" href="../css/bootstrap.css" media="screen" type="text/css">
      <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
      <!--<link rel="stylesheet" href="../assets/css/bootswatch.min.css">-->
      <title>Data Quality</title>
      <link rel="shortcut icon" href="../images/favicon.ico" />
   </head>
   <body>
      <div class="container">
      <div class="bs-example">
      <div class="navbar navbar-default">
         <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">     </a>
         </div>
         <div class="navbar-collapse collapse navbar-responsive-collapse">
            <ul class="nav navbar-nav">
               <li><a href="/analytics/hackathon"><img src="../images/storm8logo.png" width="30" height="30"></a></li>
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><font size="4">Overview</font><b class="caret"></b></a>
                  <ul class="dropdown-menu">
                     <li><a href="/analytics/hackathon/overview">Do you know</a></li>
                  </ul>
               </li>
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><font size="4">Department</font><b class="caret"></b></a>
                  <ul class="dropdown-menu">
                     <li><a href="/analytics/hackathon/department">Stats</a></li>
                  </ul>
               </li>
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><font size="4">Individual</font><b class="caret"></b></a>
                  <ul class="dropdown-menu">
                     <li><a href="/analytics/hackathon/individual">Stats</a></li>
                  </ul>
               </li>
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><font size="4">Leaderboard</font><b class="caret"></b></a>
                  <ul class="dropdown-menu">
                     <li><a href="/analytics/hackathon/leaderboard">Who's the winner</a></li>
                  </ul>
               </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
               <li><a href="#">Contact</a></li>
               <li><a href="#">Share</a></li>
            </ul>
         </div>
         <!-- /.nav-collapse -->
      </div>
      <!-- /.navbar -->
      <!-- Containers
         ================================================== -->
      <div class="bs-docs-section">
      <div class="row">
         <div class="col-lg-12">
         </div>
         <div class="col-lg-12">
            <div class="bs-example">
               <div class="jumbotron">
                  <h1>Data Quality</h1>
                  <div class="bs-example">
                     <div class="progress">
                        <div class="progress-bar" style="width: 100%;"></div>
                     </div>
                  </div>
                  <form action = "">
                     Tables: 
                     <select name="table1" id="table1">
                        <option value='daily'>Daily</option>
                        <option value='30mins'>30mins</option>
                        <option value='5mins'>5mins</option>
                        <option value='sec'>0.5sec</option>
                     </select>
                     Start Date: <input type="date" id="dt1" value="<?php 
					$timezone = "America/Los_Angeles";
  					date_default_timezone_set($timezone);
  					echo date('Y-m-d',time() - 7* 60 * 60 * 24); ?>">
  	
					End Date: <input type="date" id="dt2" value="<?php 
  					echo date('Y-m-d',time() - 60 * 60 * 24); ?>">
                     
                     
                     <input type="submit" id = "metric-submit1" value="Run" ><br>
                  </form>
                  <br>
                  <div id="metric-plots"></div>
                  <div id="metric-stats"></div>
                  <script src="../js/jqry.js"></script>
                  <script src="js/global.js"></script>             
                  <!--
                     <a name="analytics"></a><p><small>1. ZZZZ </small><br>                   	
                     	<img src="../images/storm8logo.png" width="30" height="30">
                     </p>
                     
                     <a name="pm"></a><p><small>2. ZZZZ </small><br>
                     		<img src="../images/storm8logo.png" width="30" height="30">
                     </p>
                     
                     <a name="gd"></a><p><small>3. ZZZZ </small><br>
                     		<img src="../images/storm8logo.png" width="30" height="30">
                     </p>
                     -->
               </div>
            </div>
         </div>
      </div>
      <div id="copyright" align="center"><img src="../images/storm8logo.png" width="15" height="15"> <small>&copy; Pi314 Inc.</small></div>
      <script src="../js/bootstrap.min.js"></script>
      <script src="../js/bootstrap-carousel.js"></script>
      <script src="../js/bootswatch.js"></script>
   </body>
</html>