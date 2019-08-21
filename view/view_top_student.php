<?php
require "../Classes/DBconnect.php";
$query="select * from student order by score desc limit 0,10";
$result=$db->query($query);
$i=0;
if($result->num_rows>0){
	echo "<table class=' table'><th>No</th><th>Student Name</th><th>Email</th><th>Score</th></tr>";
while($row=$result->fetch_assoc()){
echo "<tr>
<td >".++$i."</td>
<td><a href='other.php?username=".$row['stud_username']."'>".$row['stud_first_name']." ".$row['stud_last_name']."</a></td>
<td>".$row['email']."</td>
<td>".$row['score']."</td>
</tr>";

}//end of while
echo "<tr>
<td colspan='4' align='center'><a href='view_all_student.php'>View all student</a></td>
</tr>
</table>";
}
?>