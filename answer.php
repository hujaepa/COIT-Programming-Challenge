<?php
require_once "Classes/AnswerUpload.php";
require_once "Classes/EvaluateAnswer.php";
require_once "Classes/Student.php";
require_once 'Classes/CheckSession.php';
require_once "Classes/DBconnect.php";
do{
/*******************************
1. check file extension
2. check file size 
3. upload answer
4. compile answer
5. check runtime error
6. execute with lect test case
7. compare output
*******************************/


$session=new checkSession();
$username=$session->getSession($_SESSION['student']);
$set_level=$_POST['set_level'];
if($_FILES['answer']['error']==0){
	$filename=$_FILES['answer']['name'];
	$size=$_FILES['answer']['size'];
	$temp=$_FILES['answer']['tmp_name'];
  $type=$_FILES['answer']['type'];
	$problem_title=$_POST['set_name'];
	$student=new Student();
  $student->setUsername($_SESSION['student']);
	$username=$student->getUsername();
  if(!file_exists("problem_set/$problem_title/$username"))
	mkdir("problem_set/$problem_title/$username", 0755);

  if(strlen($filename)>20){
  echo "<script>alert('Filename is too long! Please rename your filename.The character for the filename must be less than 20 characters');</script>"; 
  break;
  }

$error_answer=0;

  //instantiate for upload answer
	$upload_answer=new AnswerUpload($filename,$size,$type,$temp,$problem_title,$username);

  //check file extension
	if(!$upload_answer->validateFileExt()){
     echo "<script>alert('Invalid File!Please re-upload your file again.');</script>";
    $error_answer=1;
 	break;	
 }

  //check file size
  if(!$upload_answer->checkSize()){
    echo "<script>alert('File's too big. Cannot upload more than 10 MB size of file');</script>";
    $error_answer=1;
     break;
 }

 //upload answer to the problem set directory
 if(!$upload_answer->uploadAnswer()){
     echo "<script>alert('Failed to upload answer');</script>";
     $error_answer=1;
     break;
  }

  //get full directory path for answer
  $path=$upload_answer->getPath();

  //change answer file permission to 755
  chmod($path, 0755);

  //get the filename
  $name=$upload_answer->getFileName();

  //instantiate for evaluate the answer
  $answer=new EvaluateAnswer($name,$path,$problem_title,$username);
//get input file
  $input=$answer->getInput();
  //compile answer
  if(!$answer->compile()){
    echo "<script>alert('compilation error!');</script>";
    $status="compile error";
    $error_answer=1;
    break;
  }

  //runtime error
  if(!$answer->runTime()){
    echo "<script>alert('runtime error!');</script>";
    $status="runtime error";
    $error_answer=1;
    break;
  }

  //time limit error
  if(!$answer->checkTimeLimit()){
    echo "<script>alert('time limit exeeded');</script>";
    $status="time limit exceeded";
    $error_answer=1;
    break;
  }

  //compare answer
  if(!$answer->compare()){
   echo "<script>alert('wrong answer');</script>";
    $status="wrong answer";
    $error_answer=1;
    break;
  }
  else{
   echo "<script>alert('Congratulation! your answer is correct');</script>";
    $status="success";
    $error_answer=0;
    break;
  }

  $msg="end";
 }//end of upload error
}while($msg!="end");
  //insert answer into db

  if(!$answer->insertDB($status))
    echo "<script>alert('Something wrong happen! please contact the administrator, Cannot update your submmission.');</script>";
if($error_answer==0){
//update score 
$query_success="select count( answer.answer_id ) as total
from answer inner join student ON student.stud_id = answer.stud_id
INNER JOIN problem_set ON problem_set.set_id = answer.set_id
WHERE student.stud_username = '$username' AND answer.status =  'success' and problem_set.set_name='$problem_title'";
$result=$db->query($query_success) or die($db->error);
$row=$result->fetch_assoc();
  // if(!$answer->insertDB($status))
  //   echo "<script>alert('Something wrong happen! please contact the administrator, Cannot update your submmission.');</script>";
//check if score still 0
//echo $row['total']." count how many ";
if($row['total']==1){
  $query_score="select score from student where stud_username='$username'";
  $result_score=$db->query($query_score) or die($db->error);
$row_score=$result_score->fetch_assoc();
if($set_level=="easy")
  $score=10;
else if($set_level=="medium")
  $score=100;
else
  $score=1000;
$total=$row_score['score']+$score;
echo $total." score";
$query="update student set score=$total where stud_username='$username'";
$result=$db->query($query) or die($db->error."test");
}//end of update score
}//end of update
echo "<script>window.location.href='stud_view_specific.php?name=".$problem_title."';</script>";
?>