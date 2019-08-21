<?php
/*********************************************/
 require '../Classes/CheckSession.php';
require '../Classes/Student.php';
require '../Classes/DBconnect.php';
$session=new CheckSession();
$username=$session->getSession($_SESSION['student']);
if($username){
$student=new Student();
$student->setUsername($_SESSION['student']);
$username=$student->getUsername();
$query="select student.*,answer.*,problem_set.* from answer inner 
join student on student.stud_id=answer.stud_id inner 
join problem_set on problem_set.set_id=answer.set_id
where student.stud_username='$username' order by answer.date_time_submit desc";
$result=$db->query($query) or die($db->error);
//fetch data
if($result->num_rows>0){
	echo"<br><table border=0 class='table table-bordered'>
<tr class='danger'>
<td><strong>Problem Title</strong></td>
<td><strong>Date and time submitted</strong></td><td colspan='2'><strong>Status</strong></td><td><strong>View answer</strong></td>
</tr>";
while($row=$result->fetch_assoc()){
$date=date_create($row['date_time_submit']);
if($row['status']=="success")
$symbol="right.png";
else
$symbol="wrong.png";
echo "<tr>
<td>".$row['set_name']."</td>
<td>".date_format($date,"d-m-Y H:i:s")."</td><td>".$row['status']."</td><td><img src='image/$symbol' width=20 height=20/></td></td>
<td><a class='btn btn-primary' href='view_answer.php?answer='".$row['answer_id']."'>view source code</a></td>
</tr>";

 }//end of while
 echo "</table>";
}//end of fetch
//no data
else
	echo "<br/><h3><i>No successful submission has been made<i></h3>";
}

?>