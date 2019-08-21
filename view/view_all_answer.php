<?php
/*********************************************/
require '../Classes/CheckSession.php';
require '../Classes/Student.php';
require '../Classes/DBconnect.php';
$session=new checkSession();
$username=$session->getSession($_SESSION['student']);
if($username){
$student=new Student();
$student->setUsername($_SESSION['student']);
$username=$student->getUsername();
$title=$_POST['title'];
$query="select student.*,answer.* from answer inner 
join student on student.stud_id=answer.stud_id inner 
join problem_set on problem_set.set_id=answer.set_id
where student.stud_username='$username' and problem_set.set_name='$title' order by answer.date_time_submit desc";
$result=$db->query($query) or die($db->error);
//fetch data
if($result->num_rows>0){
	echo"<br><table border=0 class='table table-bordered'>
<tr class='danger'>
<td>Date and time submitted</td><td colspan='2'>status</td><td>View answer</td>
</tr>";
while($row=$result->fetch_assoc()){
$date=date_create($row['date_time_submit']);
if($row['status']=="success")
$symbol="right.png";
else
$symbol="wrong.png";
echo "<tr>
<td>".date_format($date,"d-m-Y H:i:s")."</td><td>".$row['status']."</td><td><img src='image/$symbol' width=20 height=20/></td>
<td><a class='btn btn-primary' href='view_answer.php?answer='".$row['answer_id']."'>view source code</a></td>
</tr>";

 }//end of while
 echo "</table>";
}//end of fetch
//no data
else
	echo "<br/><h3><i>You haven't submit anything.<i></h3>";
}

?>