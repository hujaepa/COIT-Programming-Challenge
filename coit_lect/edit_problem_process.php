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
$error=0;
extract($_GET);
$problem=new ProblemSet($title,$d,$h,$l,$t,$username);
if($t<=0){
  echo "Please re-enter the time limit. time limit cannot be less than or equal to 0";
  $error++;
  break;
}
if(!$problem->updateProblem()){
	echo "<script>alert('Unable to update problem set');</script>";
	$error++;
  break;
}
$msg="success";
}while($msg!="success");
$status=array('success' =>"");
if($error>0)
	echo "error";
else{

  $status['success']= "update problem set successfull";
  echo json_encode($status);
}
  //echo "<script>window.location.href='view_created_problem.php';</script>";
}//end of session status
?>