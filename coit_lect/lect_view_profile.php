<?php
require '../Classes/CheckSession.php';
require '../Classes/Lecturer.php';
require '../Classes/ImageUpload.php';
//instantiate start session
$session=new CheckSession();
//getSession status and tore it in username variable
$sessionStat=$session->getSession($_SESSION['lecturer']);
//session username is true, then execute profile and image
if($sessionStat==true){
$lecturer=new Lecturer();
$lecturer->setUsername($_SESSION['lecturer']);
$name=$lecturer->getFirstName();
//get profile info
$details=$lecturer->getProfile();
$lect_un=$_SESSION['lecturer'];
//getimage
if(file_exists("../image/user_image/$lect_un/".$lecturer->getImage()))
$image="../image/user_image/$lect_un/".$lecturer->getImage();
else
$image="../image/user.png";

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
  if(!file_exists("../image/user_image/$lect_un"))
  mkdir("../image/user_image/$lect_un",0755);
exec("rm image/user_image/$lect_un/*");
  $image=new ImageUpload($image_name,$image_size,$image_type,$image_temp,$lect_un,"lecturer");
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
echo "<script>window.location.href='lect_view_profile.php';</script>";
  }//end of file upload
}//end of session status
 else
header("location:index.php");//invalid session status

?> 
<!DOCTYPE html>
<html>
<head>

  
</script>
<script src="../script/jquery.min.js"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap-custom.css">

<link rel="stylesheet" type="text/css" href="../CSS/mycss.css">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
<body class="background_color">
<script type="text/javascript">
  $(document).ready(function(){
 $('#file').change(function() {
  $('#target').submit();//end submit
});//end of change
});//end of document
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
      <li><img src="<?php echo $image; ?>" class="rounder padding-1"></li>
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
	<div class="col-md-3"></div>
		<div class="col-md-6">
		<div class="content-padd background_white">
		
 <table align="center" style="padding:100px">
   <tr>
   <td colspan="3" align="center"><img id="profile" src="<?php echo $image; ?>" class="rounder4"/></td>
   </tr>
   <tr>
   <td colspan="3">
</span>
<form method="post" action="" enctype="multipart/form-data" id="target">
<span class="btn btn-primary btn-file">
 <input type="file" accept="image/*" name="change" id="file">Change Profile Image</span>
     <!--<input type="submit" value="submit" name="sub">--></form></td></tr>
   <tr>
     <td>First Name</td><td>:</td><td><?php echo $details['lect_first_name'];?></td>
     </tr>
     <tr>
     <td>Last Name</td><td>:</td><td><?php echo $details['lect_last_name'];?></td>
   </tr>
   <tr>
     <td>Room Number</td><td>:</td><td><?php echo $details['room'];?></td>
   </tr>
   <tr>
     <td>Email</td><td>:</td><td><?php echo $details['email'];?></td>
   </tr>
 </table>
    <hr>
    <!--footer-->
    <img src="../image/coit.jpg" class="rounder4 " width="150px" height="150px" />
    <img src="../image/uniten.png" width="330px" height="230px" />
      <img src="../image/acm-icpc.png" width="300px" height="200px" />
      <!--end of footer-->
    </div>
		</div>

<!-- Latest compiled and minified JavaScript -->
<script src="../bootstrap/js/bootstrap.js"></script>
</body>
</html>