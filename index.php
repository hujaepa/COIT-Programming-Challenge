<?php
require 'Classes/Student.php';
require'Classes/CheckSession.php';
//check if username is set then it will redirect to homepage
$session=new CheckSession();
if(isset($_SESSION['student']))
header("location:stud_home.php");
if(isset($_POST['login'])){
  $username=strtolower(trim($_POST['username']));
  
    $student=new Student();
      $student->setUsername($username);
      $student->setPassword($_POST['password']);
      $student->login();
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="bootstrap/css/bootstrap-custom.css">
<link rel="stylesheet" type="text/css" href="CSS/mycss.css">
<script src="script/jquery.min.js"></script>
<script type="text/javascript" src="validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="validation/dist/jquery.validate.min.js"></script>
<link rel="stylesheet" type="text/css" href="validation/demo/css/core.css">
<link rel="stylesheet" type="text/css" href="validation/demo/css/screen.css">
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
  <div class="panel panel-primary">
  <div class="panel-heading">
 <h3 class="panel-title"><strong><i>Student Login</i></strong></h3> 

  </div>
  <div class="panel-body">
 <form method="post" action="" id="login_form" class="form-horizontal">
  
  <!--Username-->
  <div class="form-group">
    <label class="col-sm-2 control-label" style="color:#ff9900">ID</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="username" name="username" placeholder="Enter your ID" maxlength="8" title="Enter your ID" required>
    </div>
  </div>
  <div class="col-sm-offset-2 col-sm-10">
      </div>
  <!--Password-->
  <div class="form-group">
    <label class="col-sm-2 control-label"style="color:#ff9900">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="password" title="Enter your password" name="password" placeholder="Enter your password" maxlength="20" required>
    </div>
  </div>
  <div class="col-sm-offset-2 col-sm-10">
  </div>
  <label class="col-sm-12"><h4 align="center">
  <font color="red  ">
  <?php 
  if(!empty(User::$invalidUser))
  echo User::$invalidUser;
  ;?>
  </font></h4></label>
  <!--buttons-->
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" class="btn btn-primary " id="login" name="login" value="Login"/>
      &nbsp;
      <input type="reset" class="btn btn-primary " value="Clear" />
    </div>

  </div>
  </form>
  
 <p align="center"><img src="image/coit.jpg" class="rounder2"  />&nbsp;&nbsp;<img src="image/uniten.png"  width="210px" height="150px"  />&nbsp;&nbsp;<img src="image/acm-icpc.png" width="170px" height="150px" /></p>
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