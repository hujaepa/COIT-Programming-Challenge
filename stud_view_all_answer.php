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
$stud_un=$student->getUsername();
if(file_exists("image/user_image/$stud_un/".$student->getImage()))
$image="image/user_image/$stud_un/".$student->getImage();
else
$image="image/user.png";
}
else
  header("location:index.php");
require "Classes/DBconnect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Welcome To COIT Programming Challenge</title>
<script src="script/jquery.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap-custom.css">
<script>
  $(document).ready(function(){
    $("#search").click(function(){
      if($("#searchval").val()===""){
        alert("Please enter the keyword to search");

        console.log("test");
        return false;
      }
      else
        $("#search_form").submit();
    });//end of search

$("#success_all").load("view/view_all_success.php");
$("#failed").load("view/view_all_failed.php");
$("#all").load("view/view_all_all.php");


  });//end of ready
</script>
<link rel="stylesheet" type="text/css" href="CSS/mycss.css">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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
            <li><a href="stud_view_easy.php">Easy Problem Set</a></li>
            <li class="divider"></li>
            <li><a href="stud_view_medium.php">Medium Problem Set</a></li>
            <li class="divider"></li>
            <li><a href="stud_view_hard.php">Hard Problem Set</a></li>
          </ul>
        </li>
      <form class="navbar-form navbar-left" role="search" id="search_form" method="get" action="stud_search.php">
        <div class="form-group ">
          <input type="text" class="form-control" id="searchval" placeholder="Enter problem title" name="value" required >&nbsp;
      </div>
      <div class="form-group">
      <img  src="image/searchblue.png" width="30px" height="30px" id="search"/>
        </div>
      </form>
      <li><img src=<?php echo $image;?> class="rounder padding1 "></li>
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
   
  </div> <!--end of lef content-->
<div class="col-md-6"> 
<div class="content-padd background_white">
<h3><i>History of submission</i></h3>
<hr>
     <ul class="nav nav-pills">
     <li class="active"><a data-toggle="tab" href="#success_all">Sucessful submission</a></li>
     <li ><a data-toggle="tab" href="#failed">Failed submission</a></li>
        <li><a data-toggle="tab" href="#all">All submission</a></li>
  </ul>

  <div class="tab-content">

    <div id="success_all" class="tab-pane fade in active">
    </div>
  <div id="failed" class="tab-pane fade">
    </div>
    <div id="all" class="tab-pane fade">
    </div>
    </div>
    <!--footer-->
<img src="image/coit.jpg" class="rounder4 " width="150px" height="150px" />
<img src="image/uniten.png" width="340px" height="230px" />
<img src="image/acm-icpc.png" width="280px" height="200px" />
<!--end of footer-->
  </div>
<hr>


</div><!--end of middle content-->
</div><!--end of md6-->
</div><!--end of row-->
</div><!--end of content-->

<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/bootstrap.js"></script>
</body>
</html>