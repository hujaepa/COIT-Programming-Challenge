<?php
require '../Classes/CheckSession.php';
require_once "../Classes/Lecturer.php";
require_once "../Classes/ProblemSet.php";
require_once "../Classes/TestCase.php";

  extract($_POST);
$session=new CheckSession();
//getSession status and tore it in username variable
$sessionStat=$session->getSession($_SESSION['lecturer']);
//session username is true, then execute profile and image
if($sessionStat==true){
$lecturer=new Lecturer();
$lecturer->setUsername($_SESSION['lecturer']);
//get the lecturer username for detecting its ID
  $username=$lecturer->getUsername();
  //if hint is empty set hint to empty string
  if(empty($hint))
  $hint="";
/*
1.assign all details into problem set class
2. check duplicate for problem title
3. get the lecturer specific ID
4. insert all the data throug problem set class
5. validate file error
6.validate file size
7.validate file extension
8. if file error == 0 then save the test case
   else delete the problem information also and redirect to the homepage including error message
9.prompt user problem set is successfully created then redirect to view created problem set
*/
do{ 
$msg="";
//create object problem for problemset
$problem=new ProblemSet($problem_title,$desc,$hint,$level,$time_limit,$username);
//check title duplication
$check_duplicate=$problem->checkDuplicate();
if(!$check_duplicate){
  echo "Problem title already exist. Please enter a new problem title";
  break;
}
//check time limit info. Make sure its not less or equal to 0
if($time_limit<=0){
  echo "Please re-enter the time limit. time limit cannot be less than or equal to 0";
  break;
}
//create problem set directory
mkdir("../problem_set/$problem_title",0755);
//insert problem
$create=$problem->insertProblem();
//check insert problem set into database
if(!$create){
  echo "Unable to insert problem set";
  break;
}
//set input file empty
$path_input="";
$error_input=0;
//if there is input file
if($_FILES['input']['error']==UPLOAD_ERR_OK){
  //create input directory
  mkdir("../problem_set/$problem_title/input",0755);
  exec("rm problem_set/$problem_title/input/*");
  //send input file information
  $input=new TestCase($_FILES['input']['name'],$_FILES['input']['size'],$_FILES['input']['type'],$_FILES['input']['tmp_name'],$problem_title,"input");
  //check file extension
  $ext=$input->ValidateFileExt();
  if(!$ext){
  echo "invalid File Extension!";
  $error_input++;
  break;
  }
  //check file size
  $size=$input->checkSize();
  if(!$size){
    echo "invalid size";
    $error_input++;
    break;
  }
  //upload file
  $upload_input=$input->uploadTestCase();
  if(!$upload_input){
    echo "cannot upload input";
    $error_input++;
    break;
  }
  //get file path
  $path_input=$input->getFilename();
}
$error_output=0;
if($_FILES['output']['error']==UPLOAD_ERR_OK){
//output file
$path_output="";
mkdir("../problem_set/$problem_title/output",0755);
exec("rm problem_set/$problem_title/output/*");
//output file upload
$output=new TestCase($_FILES['output']['name'],$_FILES['output']['size'],$_FILES['output']['type'],$_FILES['output']['tmp_name'],$problem_title,"output");
$ext=$output->ValidateFileExt();
  if(!$ext){
  echo "invalid File Extension!";
    $error_output++;
  break;
  }
  $size=$output->checkSize();
  if(!$size){
    $error_output++;
    break;
  }
  //move file from temp to test case directory
  $upload_output=$output->uploadTestCase();
  if(!$upload_output){
    $error_output++;
    break;
  }
  //get output file path
  $path_output=$output->getFilename();
  //insert test case into database
  $status_tc=$output->updateTcdb($path_input,$path_output);
}
$msg="success";
}while($msg!="success");
//if fail create problem set then exit
if(isset($error_output)||isset($error_input))
if($error_output>0||$error_input>0){
  echo $error_output;
  if(file_exists("../problem_set/$problem_title"))
     exec("rm -rf ../problem_set/$problem_title");
  $problem->deleteProblem();
  echo "Failed to create problem set!";
}
//successfully creted problem set
else if($msg=="success"){
echo $problem_title." problem set has successfully created";
}
}//end of session status
?>