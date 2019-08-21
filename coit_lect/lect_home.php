<?php 
require '../Classes/CheckSession.php';
require '../Classes/Lecturer.php';
$session=new checkSession();
$username=$session->getSession($_SESSION['lecturer']);
if($username){
$lecturer=new Lecturer();
$lecturer->setUsername($_SESSION['lecturer']);
$name=$lecturer->getFirstName();
$lect_un=$lecturer->getUsername();
if(file_exists("../image/user_image/$lect_un/".$lecturer->getImage()))
$image="../image/user_image/$lect_un/".$lecturer->getImage();
else
$image="../image/user.png";
}
else
  header("location:index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Welcome To COIT Programming Challenge</title>
<script src="../script/jquery.min.js"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap-custom.css">

<link rel="stylesheet" type="text/css" href="../CSS/mycss.css">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
<body class="background_color">
<script type="text/javascript">
 $(document).ready(function(){
    $("#search").click(function(){
      if($("#searchval").val()===""){
        alert("Please enter the keyword to search");
        return false;
      }
      else
        $("#search_form").submit();
    });
  });
  
</script>
<!--navbar-->
<nav class="navbar navbar-inverse navbar-fixed-top navbar-center-lecturer" role="navigation">
  <div class="container-fluid">
   <div class="navbar-header">
  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>
  
</div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li ><a href="lect_home.php">Home</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> View Problems <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="lect_view_problem.php?">View All Problems</a></li>
            <li class="divider"></li>
            <li><a href="lect_view_easy.php">Easy Problem Set</a></li>
            <li class="divider"></li>
            <li><a href="lect_view_medium.php">Medium Problem Set</a></li>
            <li class="divider"></li>
            <li><a href="lect_view_hard.php">Hard Problem Set</a></li>
          </ul>
        </li>

        <li><a href="create_problem.php">Create Problem Set</a></li>
      <form class="navbar-form navbar-left" role="search" id="search_form" action="lect_search.php" method="get">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Enter Problem Title" id="searchval" name="value">&nbsp;
          <button><img src="../image/searchblue.png" width="30px" id="search" height="30px"></button>
        </div>
      </form>
      <li><img src=<?php echo "$image"?> class="rounder padding-1"></li>
       <li><div class="pad-menu"><?php echo "Welcome $name";?></span></div></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user"></span><span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="lect_view_profile.php">View profile</a></li>
            
            <li class="divider"></li>
            <li><a href=<?php echo "view_created_problem.php";?>>View created problem set</a></li>
            <li class="divider"></li>
             <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
       
           
            
      </ul>
      </div>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<!--end of navbar-->
<!--content-->
<div class="container-fluid">
<div class="row">
  <div class="col-md-3">
    <div class="panel panel-success">
  <div class="panel-heading"><h4 class="panel-title">Top 10 students</h4></div>
    <table class="table">
    <tr><th>Rank</th><th>Student Name</th></tr>
    
 
  </table>
  </div>
  </div>
    <div class="col-md-6">
    <div class="content-padd background_white"><h1>Welcome to COIT Programming Challenge</h1> <hr>
    <h3><i><strong>What is this site for?</strong></i></h3>
    <p><strong>COIT Programming Challenge</strong> is a site where COIT students can practice <a href="http://icpc.baylor.edu/" target="blank">ACM-ICPC</a> style of programming environment. 
    It has 3 levels of problem sets which are easy, medium and hard. All the problem set is created and updated by COIT lecturers.</p>
    <h3><i><strong>What lecturer can do with this website?</strong></i></h3>
    <p>Lecturer can :</p>
    <ol class='big'>
    <li>Create new problem set</li>
    <li>Edit existing problem set</li>
    <li>Delete existing problem set</li>
    <li>Search existing problem set</li>
    <li>View student's answer</li>
    </ol>
<hr>
<!--footer-->
    <img src="../image/coit.jpg" class="rounder4 " width="150px" height="150px" />
    <img src="../image/uniten.png" width="330px" height="230px" />
      <img src="../image/acm-icpc.png" width="300px" height="200px" />
      <!--end of footer-->


</div><!--end of white-->
    
    
  



<!-- Latest compiled and minified JavaScript -->
<script src="../bootstrap/js/bootstrap.js"></script>
</body>
</html>