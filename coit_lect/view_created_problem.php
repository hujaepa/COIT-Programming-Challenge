<?php 
require '../Classes/CheckSession.php';
require '../Classes/Lecturer.php';
$session=new checkSession();
$username=$session->getSession($_SESSION['lecturer']);
if($username){
$lecturer=new Lecturer();
$lecturer->setUsername($_SESSION['lecturer']);
$image=$lecturer->getImage();
$name=$lecturer->getFirstName();
$lect_un=$lecturer->getUsername();
}
else
  header("location:index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="../script/jquery.min.js"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap-custom.css">

<link rel="stylesheet" type="text/css" href="../CSS/mycss.css">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Welcome to COIT programing Challenge</title>
<script>
$(document).ready(function(){
function loadData(){
$.ajax({
url:"../view/view_created_process.php",
 type: "Post",
 success: function(data){
 $("#viewproblem").html(data);
 }
 });//end ajax
}//end of load data
setInterval(function(){loadData()},1000);
//searching
$("#search_button").click(
function(){
var search=$("#search").val();
$.ajax({
url:"../view/view_created_process.php",
type: "Post",
data:{search:"search"},
success: function(data){
$("#viewproblem").html(data);
}//end of success
});//end ajax
  //clearInterval(repeat);
});//end of search

});//end of ready
</script>  
</head>
<body class="background_color">
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
        <li class="active"><a href="lect_home.php">Home</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> View Problems <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="lect_view_problem.php?">View All Problems</a></li>
            <li class="divider"></li>
            <li><a href="#">Easy Problem Set</a></li>
            <li class="divider"></li>
            <li><a href="#">Medium Problem Set</a></li>
            <li class="divider"></li>
            <li><a href="#">Hard Problem Set</a></li>
          </ul>
        </li>

        <li><a href="create_problem.php">Create Problem Set</a></li>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Enter Problem Title">&nbsp;<a href=""><img src="../image/searchblue.png" width="30px" height="30px"></a>
        </div>
      </form>
      <li><img src=<?php echo "../image/user_image/$lect_un/$image"?> class="rounder padding-1"><?php  //echo "<img src='../image/$image' class='rounder padding_1' />";?></li>
       <li><div class="pad-menu"><?php echo "Welcome $name";?></span></div></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user"></span><span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="lect_view_profile.php">View profile</a></li>
            <li class="divider"></li>
            <li><a href="#">View saved problem set</a></li>
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
   
  </div>
  <!--end of left bar-->
  <!--middle content-->
<div class="col-md-6">
<div class="content-padd background_white">
<h3> View all created problem set</h3>
<hr>
<form class="form-horizontal">
<div class="form-group col-sm-4">
<input  class="form-control" type="text" name="search" id="search" placeholder="Enter problem title" required/>
</div>

<div class="form-groupcol-sm-4">
&nbsp;&nbsp;&nbsp;<input class="btn btn-primary" type="submit" id="search_button" value="filter by title">
</div>
</form >
<div id="viewproblem"></div>
<!--footer-->
<img src="../image/coit.jpg" class="rounder4 " width="150px" height="150px" />
<img src="../image/uniten.png" width="340px" height="230px" />
<img src="../image/acm-icpc.png" width="280px" height="200px" />
<!--end of footer-->
</div>
</div><!--end of content-->


</div><!--end of row-->
</div><!--end of container-->


<!-- Latest compiled and minified JavaScript -->
<script src="../bootstrap/js/bootstrap.js"></script>
</body>
</html>