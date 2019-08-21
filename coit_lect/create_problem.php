<?php 
require '../Classes/CheckSession.php';
require '../Classes/Lecturer.php';
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
<script type="text/javascript" src="../tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="../validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="../validation/dist/jquery.validate.min.js"></script>
<script src="../validation/dist/additional-methods.min.js"></script>
<link rel="stylesheet" type="text/css" href="../validation/demo/css/screen.css">

<script type="text/javascript">
tinymce.init({
    selector: "textarea.editme",
    plugins: [
        "advlist autolink lists charmap preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime table contextmenu paste colorpicker textcolor link image",
        
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor | link image",
    resize: false,
    force_p_newlines : false,
force_br_newlines : true,
convert_newlines_to_brs : false,
remove_linebreaks : true,  
forced_root_block : false,
paste_remove_styles : false,
paste_strip_class_attributes : "none",  
paste_auto_cleanup_on_paste : false,  
paste_text_use_dialog : true,                  
paste_force_cleanup_paste : false,        
paste_remove_spans : true,               
    file_browser_callback: function(field, url, type, win) {
        tinyMCE.activeEditor.windowManager.open({
            file: '../kcfinder/browse.php?opener=tinymce4&field=' + field + '&type=' + type,
            title: 'KCFinder',
            width: 700,
            height: 500,
            inline: true,
            close_previous: false
        }, {
            window: win,
            input: field
        }
        );
        return false;
    }
    
});
</script>
<script type="text/javascript">
$(document).ready(function(){
$("#create").click(function(){

  $("#create_form").validate({
    rules:{
      problem_title:{
        required:true
      },
      time_limit:{
        required:true,
        number:true
      },
      level:{
        required:true
      },
      input:{
      extension:"txt|in"
      },
      output:{
        required:true,
        extension:"txt|in"
      }
    },//end of rules
    messages:{
      problem_title:{
        required:"Please enter the problem title"
      },
      time_limit:{
        required:"Please enter the time limit",
        number:"Only numeric data are acceptable"
      },
      level:{
        required:"Please choose the level"
      },
      output:{
        required:"Please insert the output file"
      }
    },//end of messages
    submitHandler: function(form) {
  if(tinyMCE.get('content').getContent()==="")
  alert("Please write something on the description editor");
  else
    $.ajax({
      url:"create_problem_process.php",
       type:"post",
      data: new FormData(form),
      processData: false,
    contentType: false,
      success: function(data,status){
                alert(data);
            }//end of success
    });//end of ajax
  return false;
  },//end of handler
  });//end of validate
  });//end of click

});//end of ready
  
</script>
<title>Welcome To COIT-PC</title>
<link rel="stylesheet" type="text/css" href="../CSS/mycss.css">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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
<div class="container">
<div class="row">
  <div class="col-md-1"></div>
    <div class="col-md-10">
    <div class="content-padd background_white">
    <h1><i>Create Problem Set</i></h1>
          <hr/>
        
    <form method="post" action="" id="create_form" enctype="multipart/form-data">

        <div class="form-group col-md-12">
        <h3>Problem title<font color="red">*</font></h3>
        <input type="text" name="problem_title" class="form-control" placeholder="Enter title here" maxlength="30" required/>
        </div>

        <div class="form-group col-md-12">
        <h3>Problem description<font color="red">*</font></h3>
        <textarea class="editme" name="desc" rows="20" id="content" ></textarea>
        </div>

         <div class="form-group col-md-12">
        <h3>Add hint (<font color="red"><i>optional</i></font>)</h3>
        <textarea  class="form-control" name="hint" cols="20" rows="10" style="resize:none" placeholder="eg.Looping,AI"></textarea>
        </div>

<div class="col-md-12">
  <div class="form-group col-md-7 ">
      <h3>Level of difficulty <font color="red">*</font>(<font color="red"><i>eg: easy, medium, hard</i></font>)</h3>
        <select class="form-control" name="level" required>
        <option value="">Please Choose the level of the difficulty</option>
          <option value="easy">Easy</option>
          <option value="medium">Medium</option>
          <option value="hard">Hard</option>
        </select>
        </div>

        <div class="form-group col-md-5 ">
        <h3>Time Limit(in seconds)<font color="red">*</font></h3>
          <input class="form-control" type="text" name="time_limit" required>
        </div>
</div>


  <div class="form-group col-md-12">
        <h3>Input & Output</h3>
        <span class="col-sm-6"><h4><i><strong>Input</strong></i></h4> <input type="file" name="input"></span>
       <span class="col-sm-6"><h4><i><strong>Output</strong></i><font color="red">*</font></h4><input type="file" name="output" required id="output" ></span>
        </div>       

        <div class="form-group col-md-12">
        <div class="col-md-3"></div>
         <div class="col-md-8">
         <br>
         <br>
         <p>
        <input type="submit" name="saved" class="btn btn-primary" id="save" value="Save">
        <input type="submit" name="create" class="btn btn-primary" value="Create" id="create"/>
        <input type="reset" class="btn btn-primary " value="Clear" />  
        </p>
        </div>  
        </div>    
      </form>
      <hr/>
      <!--footer-->
    <img src="../image/coit.jpg" class="rounder4 " width="150px" height="150px" />
    <img src="../image/uniten.png" width="350px" height="230px" />
      <img src="../image/acm-icpc.png" width="300px" height="200px" />
      <!--end of footer-->
      </div><!--end of content-->
</div><!--end of column-->

</div>
    
    

</div><!--end of container-->

<!-- Latest compiled and minified JavaScript -->
<script src="../bootstrap/js/bootstrap.js"></script>
</body>
</html>