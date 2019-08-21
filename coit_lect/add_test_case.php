<?php 
require '../Classes/CheckSession.php';
require '../Classes/Lecturer.php';
require '../Classes/DBconnect.php';
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

$set_id=$_GET['id'];
$title=$_GET['title'];
$query="select input,output from test_case where set_id=$set_id";
$result=$db->query($query) or die($db->error);
if($result->num_rows>0){
  $row=$result->fetch_assoc();
    $input=$row['input'];
    $output=$row['output'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Welcome To COIT Programming Challenge</title>
<script src="../script/jquery.min.js"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap-custom.css">

<link rel="stylesheet" type="text/css" href="../CSS/mycss.css">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script type="text/javascript" src="../validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="../validation/dist/jquery.validate.min.js"></script>
<script src="../validation/dist/additional-methods.min.js"></script>
<link rel="stylesheet" type="text/css" href="../validation/demo/css/core.css">
<link rel="stylesheet" type="text/css" href="../validation/demo/css/screen.css">
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
        <li class="active"><a href="lect_home.php">Home <span class="sr-only">(current)</span></a></li>
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
<script>
  $(document).ready(function(){
  $("#input").hide();
  $("#output").hide();
  $("#viewinput").click(function(){
    $("#input").toggle("fast");
  });
  $("#viewoutput").click(function(){
    $("#output").toggle("fast");
  });
  $("#edit").validate({
    rules:{
      output:{
      required:true,
      extension:"txt|in"
      },
      input:{
        required:true,
        extension:"txt|in"
      }
    },
    messages:{
      output:{
        required:"Please insert your output file"
      },
      input:{
        required:"Please insert your input file"
      }
    }
  });
});//end of ready
</script>
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
<h1> Test Case Manager</h1>
<hr>
 <h3>  Input file</h3>
<button id="viewinput" class="btn btn-success">View/Hide Input Content</button>

<div id="input">
<?php 
if(!empty($input)){
  if(file_exists("../problem_set/$title/input/$input")){
  $input_file=fopen("../problem_set/$title/input/$input", 'r');
  while(!feof($input_file))
    echo fgets($input_file)."<br>";

  fclose($input_file);
 }
 else
  echo "Cannot fetch input data! please contact the web administrator";
}
else 
echo "there is no input file for this problem set";
    ?>
</div>

<h3>  Output file</h3>
<button id="viewoutput" class="btn btn-success">View/Hide Output Content</button>
<div id="output">
<?php 
if(!empty($output)){
  if(file_exists("../problem_set/$title/output/$output")){
  $output_file=fopen("../problem_set/$title/output/$output", 'r');
  while(!feof($output_file))
   echo fgets($output_file)."<br>";
  
  fclose($output_file);
  }
 else
  echo "Cannot fetch output data! please contact the web administrator";
}
else 
echo "there is no output file for this problem set";
    ?>
</div>


<h3><u>Edit Test Case</u></h3>
<form id="edit" action="add_test_case_process.php" class="form-horizontal" method="post" enctype="multipart/form-data">
<?php 
if(!empty($input))
  echo "<h3>Input File</h3><input type='file' name='input' required>";
?>

  <h3>Output File</h3>
  <div class="form-group"> 
  <input type="file" name="output" required>
  </div>
  <input type="hidden" name='set_id' value="<?php echo $set_id;?>">
  <input type="hidden" name='title' value="<?php echo $title;?>">
  <input type="submit" name="change" value="Update Test Case" class="btn btn-primary">
</form>
<!--footer-->
<hr>
<img src="../image/coit.jpg" class="rounder4 " width="150px" height="150px" />
<img src="../image/uniten.png" width="310px" height="230px" />
<img src="../image/acm-icpc.png" width="310px" height="200px" />
<!--end of footer--></div>
</div><!--end of content-->


</div><!--end of row-->
</div><!--end of container-->
<!--end of content-->

<!-- Latest compiled and minified JavaScript -->
<script src="../bootstrap/js/bootstrap.js"></script>
</body>
</html>