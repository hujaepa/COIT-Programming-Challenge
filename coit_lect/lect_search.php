<?php 
require '../Classes/CheckSession.php';
require '../Classes/Lecturer.php';
require '../Classes/DBconnect.php';
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
<script src="../script/jquery.min.js"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap-custom.css">

<link rel="stylesheet" type="text/css" href="../CSS/mycss.css">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Welcome to COIT programing Challenge</title>
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
            <li><a href="#">Easy Problem Set</a></li>
            <li class="divider"></li>
            <li><a href="#">Medium Problem Set</a></li>
            <li class="divider"></li>
            <li><a href="#">Hard Problem Set</a></li>
          </ul>
        </li>

        <li><a href="create_problem.php">Create Problem Set</a></li>
        <form class="navbar-form navbar-left" role="search" id="search_form" action="" method="get">
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
<?php
    if(isset($_GET['value'])){
$search=$_GET['value'];
echo "<h3>Search Result : <i>$search</i></h3>";
$query_search="select problem_set.set_name AS setname, problem_set.lect_id as lect_id ,lecturer.lect_first_name AS first_name, lecturer.lect_last_name AS last_name, problem_set.set_level AS level, 
problem_set.date_time_created AS created
FROM problem_set
INNER JOIN lecturer ON problem_set.lect_id = lecturer.lect_id  where set_name like '%$search%' order by created desc";
$result=$db->query($query_search) or die($db->error);
if($result->num_rows>0){
   echo"  <table border=0 class='table table-bordered'><tr class='danger'>
  <td>Problem Title</td><td>Created By</td><td>Level of difficulty</td><td>Date and time created</td>
  </tr>";
while($row=$result->fetch_assoc())
echo "<tr><td><a href='lect_view_specific.php?name=".$row['setname']."'>".$row['setname']."</a></td><td> <a href='view_lect_profile.php?id=".$row['lect_id']."'>".$row['first_name']." ".$row['last_name']
."</td><td>".$row['level']."</td><td>".$row['created']."</td></tr>";
echo "</table>";//end of table
}
  else
 echo "No problem set found";
}
?>
<!--footer-->
<hr>
<img src="../image/coit.jpg" class="rounder4 " width="150px" height="150px" />
<img src="../image/uniten.png" width="325px" height="230px" />
<img src="../image/acm-icpc.png" width="310px" height="200px" />
<!--end of footer--></div>
</div><!--end of content-->


</div><!--end of row-->
</div><!--end of container-->


<!-- Latest compiled and minified JavaScript -->
<script src="../bootstrap/js/bootstrap.js"></script>
</body>
</html>