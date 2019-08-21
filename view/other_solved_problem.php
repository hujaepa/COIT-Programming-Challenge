<?php
require '../Classes/CheckSession.php';
require '../Classes/Student.php';
require '../Classes/DBconnect.php';
$session=new checkSession();
$status=$session->getSession($_SESSION['student']);
if($status){
$username=$_POST['name'];
//query
$query="SELECT DISTINCT problem_set.set_name
FROM problem_set
INNER JOIN answer ON problem_set.set_id = answer.set_id
INNER JOIN student ON answer.stud_id = student.stud_id
WHERE student.stud_username =  '$username'
AND answer.status =  'success' order by answer.date_time_submit desc ";
$result=$db->query($query) or die($db->error);

if($result->num_rows>0){
	echo"<br><table border=0 class='table table-bordered' >
<tr class='danger'><td>No</td>
<td>Problem Set Title</td>
</tr>";
$i=0;
while($row=$result->fetch_assoc()){
echo "<tr>
<td>".++$i."</td>
<td><a href='stud_view_specific.php?name=".$row['set_name']."'>".$row['set_name']."</a></td>
</tr>";

 }//end of while
 echo "</table>";
}//end of fetch
//no data
else
	echo "<br/><h3><i>No problem solved<i></h3>";
}

?>