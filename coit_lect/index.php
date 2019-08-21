
<?php
require '../Classes/Lecturer.php';
require'../Classes/CheckSession.php';
//check if username is set then it will redirect to homepage
$session=new CheckSession();
if(isset($_SESSION['lecturer']))
header("location:lect_home.php");
if(isset($_POST['login'])){
  $username=strtolower(trim($_POST['username']));
      $lecturer=new Lecturer();
      $lecturer->setUsername($username);
		  $lecturer->setPassword($_POST['password']);
		  $lecturer->login();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Welcome to COIT-PC</title>
<link rel="stylesheet" href="../bootstrap/css/bootstrap-custom.css">
<script src="../script/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="../CSS/mycss.css">
<script type="text/javascript" src="../validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="../validation/dist/jquery.validate.min.js"></script>
<link rel="stylesheet" type="text/css" href="../validation/demo/css/core.css">
<link rel="stylesheet" type="text/css" href="../validation/demo/css/screen.css">

<script type="text/javascript">
  $(document).ready(function(){
    $("#username").focus();
    $("#login").click(function(){
        $("#login_form").validate({
          rules:{
            username:{
              required:true
            },
            password:{
              required:true
            }
          },
          messages: {
            username:{
              required:"Please enter your ID"
            },
            password:{
              required:"Please enter your password"
            }
          } ,
               
        });
    });//end of login
  });//end of document load
</script>
</head>

<body class="jumbotron">

<div class="container">
<div class="row"><div class="page-header" align="center"><strong><h1><span style="color:#2b5bdf">COIT</span></strong> <span style="color:#2b5bdf">{</span><span style="color:#ff9900"><i>Programming Challenge</i><font color="red">;</font></span><span style="color:#2b5bdf">}</span></h1></div></div>
	<div class="row">
	<!--padding left-->
<div class="col-md-3"></div>
	<!--login form-->
	<div class="col-md-6">
	<div class="panel panel-success">
  <div class="panel-heading">
  <h4 class="panel-title" ><strong><i>Lecturer Login</i></strong></h4> 

  </div>
  <div class="panel-body">
 <form method="post" action="" class="form-horizontal" id="login_form">
  
  <!--Username-->
  <div class="form-group">
    <label class="col-sm-2 control-label" style="color:#ff9900">ID</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="username" name="username" placeholder="Enter your ID" maxlength="7" required>
    </div>
  </div>
  <div class="col-sm-offset-2 col-sm-10">
      </div>
  <!--Password-->
  <div class="form-group">
    <label class="col-sm-2 control-label"style="color:#ff9900">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" maxlength="20" required>
    </div>
  </div>
  <div class="col-sm-offset-2 col-sm-10">
  </div>
  <label class="col-sm-12"><h4 align="center">
  <font color="red  ">
  <?php 
  if(!empty(User::$invalidUser))
  echo "<p>".User::$invalidUser."</p>";?>
  </font></h4></label>
  <!--buttons-->
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" class="btn btn-primary " name="login" id="login" value="Login"/>
      &nbsp;
      <input type="reset" class="btn btn-primary " value="Clear" />
    </div>
  </div>
  </form>
 <p align="center"><img src="../image/coit.jpg" class="rounder2"  />&nbsp;&nbsp;<img src="../image/uniten.png"  width="210px" height="150px"  />&nbsp;&nbsp;<img src="../image/acm-icpc.png" width="170px" height="150px" /></p>
</div>

  </div>
	
	<!--login form end-->


	<!--padding right-->
	<div class="col-md-3"></div>
	</div>
	</div>
	</div>
	
</body>
</html>