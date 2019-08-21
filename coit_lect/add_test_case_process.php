<?php
require '../Classes/TestCase.php';
  /*
  1. check file extension 
  2.check file size
  3.move file
  4. update DB
  */
  $path_input="";
  $msg="";
  $problem_title=$_POST['title'];
  $id=$_POST['set_id'];
  do{
    extract($_POST);
    //if(isset($_FILES['input']['name'])){
    if($_FILES['input']['error']==UPLOAD_ERR_OK){
      $filename=$_FILES['input']['name'];
      $type=$_FILES['input']['type'];
      $size=$_FILES['input']['size'];
      $temp=$_FILES['input']['tmp_name'];
      $error_input=0;
      exec("rm -f problem_set/$problem_title/input/*");
      $input=new TestCase($filename,$size,$type,$temp,$problem_title,"input");
      if(!$input->validateFileExt()){
        echo "<script>alert('invalid file extension');</script>";
        $error_input++;
        break;
      }
       if(!$input->checkSize()){
        echo "<script>alert('invalid file size');</script>";
        $error_input++;
        break;
      }
      $upload_input=$input->uploadTestCase();
      //get file path
      $path_input=$input->getFilename();
    }//end of input
//}
    if($_FILES['output']['error']==UPLOAD_ERR_OK){
      $filename=$_FILES['output']['name'];
      $type=$_FILES['output']['type'];
      $temp=$_FILES['output']['tmp_name'];
      $size=$_FILES['output']['size'];
      $error_output=0;
      exec("rm -f problem_set/$problem_title/output/*");
      $output=new TestCase($filename,$size,$type,$temp,$problem_title,"output");
      if(!$output->validateFileExt()){
        echo "<script>alert('invalid file extension');</script>";
        $error_input++;
        break;
      }
       if(!$output->checkSize()){
        echo "<script>alert('invalid file size!');</script>";
        $error_input++;
        break;
      }
      $upload_output=$output->uploadTestCase();
      //get file path
      $path_output=$output->getFilename();
    }//end of input
       $status_tc=$output->updateDB($path_input,$path_output,$id);
    $msg="success";
  }while($msg!='success');
  if($msg=="success")
  	echo "<script>alert('Test Case Successfully Updated');window.location.href='view_created_problem.php';</script>";
?>