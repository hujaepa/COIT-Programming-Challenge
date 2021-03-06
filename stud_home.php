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
//get image
if(file_exists("image/user_image/$stud_un/".$student->getImage()))
$image="image/user_image/$stud_un/".$student->getImage();
else
$image="image/user.png";
}
else
header("location:index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="script/jquery.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap-custom.css">
<script type="text/javascript">
 $(document).ready(function(){
  $("#topstud").load("view/view_top_student.php");
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
<link rel="stylesheet" type="text/css" href="CSS/mycss.css">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Welcome to COIT programing Challenge</title>
</head>
<body class="background_color">
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
        <div class="form-group">
          <input type="text" class="form-control" id="searchval" placeholder="Enter problem title" name="value">&nbsp;<button>
          <img src="image/searchblue.png" width="30px" height="30px" id="search"></button>
        </div>
      </form>
      <li><img src=<?php echo $image;?> class="rounder padding1 "></li>
       <li><div class="pad-menu"><?php echo "Welcome $name";?></span></div></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user"></span><span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="stud_view_profile.php">View profile</a></li>
            <li class="divider"></li>
            <li><a href="stud_view_all_answer.php">View all submission</a></li>
            <li class="divider"></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
       
      </ul>
      </div>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<!--content-->
<div class="container-fluid">
<div class="row">
	<div class="col-md-3">
   <div class="panel panel-primary">
  <div class="panel-heading"><h4 class="panel-title">Top students</h4></div>
   <div id="topstud"></div>
  </div> 
  </div>
		<div class="col-md-6">
		<div class="content-padd background_white"><h1>Welcome to COIT Programming Challenge</h1> <hr>
    <h3><i><strong>What is this website for?</strong></i></h3>
    <p><strong>COIT Programming Challenge</strong> is a website where COIT students can practice <a href="http://icpc.baylor.edu/" target="blank">ACM-ICPC</a> style of programming competition. 
    It has 3 levels of problem sets which are easy, medium and hard. All the problem set is created and updated by COIT lecturers.</p>
    <h3><i><strong>What programming language does this website support?</strong></i></h3>
    <p>C++ program only. Other than that the system won't accept your answer.</p>
    <h3><i><strong>How to submit my answer?</strong></i></h3>
    <p>Simply by choosing one of the problem set and upload your C or C++ program.</p>
    <h3><i><strong>How it will evaluate?</strong></i></h3>
    <p>It will automatically evaluate your code based on the lecturer standard input and standard output. It will give back the result depends on the efficiency 
     of your code and the time limit that has been set by the lecturers.</p>
    <h3><i><strong>Does this website provide compiler, IDE or editor for code writing and compiling</strong></i></h3>
    <p>No. Code editor, IDE and compiler will not be included.</p>
    
    <hr>


<!--footer-->
<img src="image/coit.jpg" class="rounder4 " width="150px" height="150px" />
<img src="image/uniten.png" width="340px" height="230px" />
<img src="image/acm-icpc.png" width="280px" height="200px" />
<!--end of footer-->
</div><!--end of content-->
</div><!--end of middle column-->

</div><!--end of row-->
</div><!--end of content-->
<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/bootstrap.js"></script>
</body>
</html>