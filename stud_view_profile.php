<?php
require 'Classes/CheckSession.php';
require 'Classes/Student.php';
require 'Classes/ImageUpload.php';
require 'Classes/DBconnect.php';
//instantiate start session
$session=new CheckSession();
//getSession status and tore it in username variable
$sessionStat=$session->getSession($_SESSION['student']);
//session username is true, then execute profile and image
if($sessionStat==true){
$student=new Student();
$student->setUsername($_SESSION['student']);
$name=$student->getFirstName();
//get profile info
$details=$student->getProfile();
$stud_un=$details['stud_username'];
//get image
if(file_exists("image/user_image/$stud_un/".$student->getImage()))
$image="image/user_image/$stud_un/".$student->getImage();
else
$image="image/user.png";
//get total solved
$query="SELECT COUNT( DISTINCT problem_set.set_name ) as total
FROM problem_set
INNER JOIN answer ON problem_set.set_id = answer.set_id
INNER JOIN student ON answer.stud_id = student.stud_id
WHERE student.stud_username =  '$stud_un'
AND answer.status =  'success'";
$result=$db->query($query) or die($db->error);
$totalSolved=$result->fetch_assoc();

//upload image
if(isset($_FILES["change"]['size'])){
  $msg="";
do{
  $image_name=$_FILES['change']['name'];
  $image_size=$_FILES['change']['size'];
  $image_type=$_FILES['change']['type'];
  $image_temp=$_FILES['change']['tmp_name'];
if(strlen($image_name)>20){
  echo "<script> alert('Image file name too long! Please rename your image file, it must be less than 20 character');</script>";
  break;
}
  if(!file_exists("image/user_image/$stud_un"))
  mkdir("image/user_image/$stud_un",0755);
exec("rm image/user_image/$stud_un/*");
  $image=new ImageUpload($image_name,$image_size,$image_type,$image_temp,$stud_un,"student");
  //check image extension
  if(!$image->validateFileExt()){
    echo "<script>alert('Invalid image type!');</script>";
    break;
  }
    //check image upload status
    if(!$image->moveImage()){
      echo "<script>alert('Failed upload image!');</script>";
      break;
    }
     
    //update image path
    if(!$image->updateImage()){
    echo "<script>alert('Failed to update image!');</script>";
    break;
    }
  
  $msg="end";
}while($msg!="end");
echo "<script>window.location.href='stud_view_profile.php';</script>";
  }//end of change size
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
    
 $("#solved").load("view/solved_problem.php");
 $('#file').change(function() {
  $('#target').submit();
  });//end of change
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
    
 <table align="center" style="padding:100px">
   <tr>
   <td colspan="3" align="center"><img src="<?php echo $image;?>" class="rounder4" /></td>
   </tr>

 <tr>
   <td>&nbsp;&nbsp;</td>
   </tr>

   <tr>
   <td colspan="3">
<form method="post" action="" enctype="multipart/form-data" id="target">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span class="btn btn-primary btn-file">
 <input type="file" accept="image/*" name="change" id="file">Change Profile Image</span>
     <!--<input type="submit" value="submit" name="sub">--></form></td>
     </tr>

   <tr>
   <td>&nbsp;&nbsp;</td>
   </tr>

     <tr>
     <td><strong>First Name</strong></td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?php echo $details['stud_first_name'];?></td>
     </tr>

    <tr>
   <td>&nbsp;&nbsp;</td>
   </tr>

     <tr>
     <td><strong>Last Name</strong></td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?php echo $details['stud_last_name'];?></td>
   </tr>

    <tr>
   <td>&nbsp;&nbsp;</td>
   </tr>

   <tr>
     <td><strong>Email</strong></td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?php echo $details['email'];?></td>
   </tr>

   <tr>
   <td>&nbsp;&nbsp;</td>
   </tr>

   <tr>
     <td><strong>Score</strong></td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?php echo $details['score'];?></td>
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