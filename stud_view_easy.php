<?php 
require 'Classes/CheckSession.php';
require 'Classes/Student.php';
$session=new checkSession();
$username=$session->getSession($_SESSION['student']);
if($username){
$student=new Student();
$student->setUsername($_SESSION['student']);
$image=$student->getImage();
$name=$student->getFirstName();
}
else
header("location:index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="script/jquery.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap-custom.css">

<link rel="stylesheet" type="text/css" href="CSS/mycss.css">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Welcome to COIT programing Challenge</title>
<script type="text/javascript">
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
</script>
<script>
$(document).ready(function(){
function loadData(){
$.ajax({
url:"view/view_easy_process.php",
 type: "Post",
 data:{type_user:'student'},
 success: function(data){
 $("#viewproblem").html(data);
 }
 });//end ajax
}//end of load data
setInterval(function(){loadData()},1000);


});//end of ready
</script>  
</head>
<body class="background_color">
<!--navbar-->
<nav class="navbar navbar-default navbar-fixed-top navbar-center-student" role="navigation">
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
     <li></li>
        <li class="active"><a href="stud_home.php">Home <span class="sr-only">(current)</span></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> View Problems <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="stud_view_problem.php">View All Problems</a></li>
            <li class="divider"></li>
            <li><a href="#">Easy Problem Set</a></li>
            <li class="divider"></li>
            <li><a href="#">Medium Problem Set</a></li>
            <li class="divider"></li>
            <li><a href="#">Hard Problem Set</a></li>
          </ul>
        </li>
      <form class="navbar-form navbar-left" role="search" id="search_form" method="get" action="stud_search.php">
        <div class="form-group">
          <input type="text" class="form-control" id="searchval" placeholder="Enter problem title" name="value">&nbsp;<button>
          <img src="image/searchblue.png" width="30px" height="30px" id="search"></button>
        </div>
      </form>
      <li><img src=<?php echo "image/".$image;?> class="rounder padding1 "></li>
       <li><div class="pad-menu"><?php echo "Welcome $name";?></span></div></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user"></span><span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="stud_view_profile.php">View profile</a></li>
            <li class="divider"></li>
            <li><a href="#">View all submission</a></li>
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
<h3> View easy problem set</h3>
<hr>

<div id="viewproblem"></div>
<!--footer-->
<img src="image/coit.jpg" class="rounder4 " width="150px" height="150px" />
<img src="image/uniten.png" width="340px" height="230px" />
<img src="image/acm-icpc.png" width="280px" height="200px" />
<!--end of footer-->
</div>
</div><!--end of content-->


</div><!--end of row-->
</div><!--end of container-->


<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/bootstrap.js"></script>
</body>
</html>