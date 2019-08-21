
<?php
require "../Classes/DBconnect.php";
/*********************************************
This view is for the lecturer and student to view 
all the problem set that has created. This view allow
student and lecturer to select the problem set.
*********************************************/
$url_lect='lect_view_specific.php';
$url_stud='stud_view_specific.php';
if($_POST['type_user']=="student"){
//student view
$query="select problem_set.set_name AS setname, problem_set.lect_id as lect_id ,lecturer.lect_first_name AS first_name, lecturer.lect_last_name AS last_name, problem_set.set_level AS level, 
problem_set.date_time_created AS created
FROM problem_set
INNER JOIN lecturer ON problem_set.lect_id = lecturer.lect_id where problem_set.set_level='hard' order by created desc ";
$result=$db->query($query) or die($db->error);
if($result->num_rows>0){
	 echo"  <table border=0 class='table table-bordered'><tr class='danger'>
  <td>Problem Title</td><td>Created By</td><td>Level of difficulty</td><td>Date and time created</td>
  </tr>";
while($row=$result->fetch_assoc())
echo "<tr><td><a href='$url_stud?name=".$row['setname']."'>".$row['setname']."</a></td><td> <a href='view_lect_profile.php?id=".$row['lect_id']."'>".$row['first_name']." ".$row['last_name']
."</td><td>".$row['level']."</td><td>".$row['created']."</td></tr>";
}
else
 echo "No hard problem set has created";
echo "</table>";//end of table
}
//lect view
else{
$query="select problem_set.set_name AS setname, problem_set.lect_id as lect_id ,lecturer.lect_first_name AS first_name, lecturer.lect_last_name AS last_name, problem_set.set_level AS level, 
problem_set.date_time_created AS created
FROM problem_set
INNER JOIN lecturer ON problem_set.lect_id = lecturer.lect_id where problem_set.set_level='hard' order by created desc ";
$result=$db->query($query) or die($db->error);
if($result->num_rows>0){
	 echo"  <table border=0 class='table table-bordered'><tr class='danger'>
  <td>Problem Title</td><td>Created By</td><td>Level of difficulty</td><td>Date and time created</td>
  </tr>";
while($row=$result->fetch_assoc())
echo "<tr><td><a href='$url_lect?name=".$row['setname']."'>".$row['setname']."</a></td><td> <a href='view_lect_profile.php?id=".$row['lect_id']."'>".$row['first_name']." ".$row['last_name']
."</td><td>".$row['level']."</td><td>".$row['created']."</td></tr>";
}
else
 echo "No hard problem set has created";
echo "</table>";//end of table
}
?>