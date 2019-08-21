<?php
require 'Classes/CheckSession.php';
require 'Classes/Student.php';
require 'Classes/ImageUpload.php';
require 'Classes/DBconnect.php';
$username=$_GET['username'];
//instantiate start session
$session=new CheckSession();
//getSession status and tore it in username variable
$sessionStat=$session->getSession($_SESSION['student']);
//session username is true, then execute profile and image
if($sessionStat==true){
$student=new Student();
$student->setUsername($_SESSION['student']);
$stud_un=$student->getUsername();
$name=$student->getFirstName();
//get profile info
$details=$student->getProfile();
//get image
if(file_exists("image/user_image/$stud_un/".$student->getImage()))
$image="image/user_image/$stud_un/".$student->getImage();
else
$image="image/user.png";


//get the profile
$query_profile="select * from student where stud_username='$username'";
$result=$db->query($query_profile) or die($db->error);
$row=$result->fetch_assoc();

//get total solved
$query="SELECT COUNT( DISTINCT problem_set.set_name ) as total
FROM problem_set
INNER JOIN answer ON problem_set.set_id = answer.set_id
INNER JOIN student ON answer.stud_id = student.stud_id
WHERE student.stud_username =  '$username'
AND answer.status =  'success'";
$result=$db->query($query) or die($db->error);
$totalSolved=$result->fetch_assoc();

}//end of session status
else
header("location:index.php");

?> 
<!DOCTYPE html>
<html>
<head>
<script src="script/jquery.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap-custom.css">

<link rel="stylesheet" type="text/css" href="CSS/mycss.css">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
<body class="background_color">
<script type="text/javascript">
  $(document).ready(function(){
    var n=$("#un").val();
    console.log(n);
 $("#solved").load("view/other_solved_problem.php",{name:n});
});//end of ready
</script>
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
      <li><img src="<?php echo $image;?>" class="rounder padding1 "></li>
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

<!--content-->
<div class="container-fluid">
<div class="row">
  <div class="col-md-3"></div>
    <div class="col-md-6">
    <div class="content-padd background_white">
    <input type="hidden" id="un" value="<?php echo $username;?>">
 <table align="center" style="padding:100px">
   <tr>
   <?php 
   $newimage=$row['image'];
if(file_exists("image/user_image/$username/$newimage"))
$user_image="image/user_image/$username/$newimage";
else
$user_image="image/user.png";
   ?>
   <td colspan="3" align="center"><img src="<?php echo $user_image; ?>" class="rounder4" /></td>
   </tr>

 <tr>
   <td>&nbsp;&nbsp;</td>
   </tr>

  
   <tr>
   <td>&nbsp;&nbsp;</td>
   </tr>

     <tr>
     <td><strong>First Name</strong></td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?php echo $row['stud_first_name'];?></td>
     </tr>

    <tr>
   <td>&nbsp;&nbsp;</td>
   </tr>

     <tr>
     <td><strong>Last Name</strong></td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?php echo $row['stud_last_name'];?></td>
   </tr>

    <tr>
   <td>&nbsp;&nbsp;</td>
   </tr>

   <tr>
     <td><strong>Email</strong></td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?php echo $row['email'];?></td>
   </tr>

   <tr>
   <td>&nbsp;&nbsp;</td>
   </tr>

   <tr>
     <td><strong>Score</strong></td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?php echo $row['score'];?></td>
   </tr>

<tr>
   <td>&nbsp;&nbsp;</td>
   </tr>

   <tr>
     <td><strong>Total Problem Solved</strong></td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?php echo $totalSolved['total'];?></td>
   </tr>

 </table>
    <hr/>
    
<h3><i>Solved problem set</i></h3>
    <div id="solved" >
    </div>
    <hr/>
    <!--footer-->
<img src="image/coit.jpg" class="rounder4" />
<img src="image/uniten.png" width="340px" height="230px" />
<img src="image/acm-icpc.png" width="280px" height="200px" />
<!--end of footer-->
  </div>

  
    </div>
    </div>

<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/bootstrap.js"></script>
</body>
</html>