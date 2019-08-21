<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<script type="text/javascript">
function delete_id(id)
{
     if(confirm('Sure Want to delete this problem set ?'))
     {
        window.location.href='delete.php?delete_id='+id;
     }
}
</script>
<?php
/*********************************************
This view is for the lecturer that has created
the problem set. In this view lecturer can 
have function edit, delete and update test cases.
*********************************************/
 require '../Classes/CheckSession.php';
require '../Classes/Lecturer.php';
require '../Classes/DBconnect.php';
$session=new checkSession();
$username=$session->getSession($_SESSION['lecturer']);
if($username){
$lecturer=new Lecturer();
$lecturer->setUsername($_SESSION['lecturer']);
$username=$lecturer->getUsername();
}
$url='../coit_lect/lect_view_specific.php';
$query="select problem_set.set_id as set_id,problem_set.set_name AS setname, problem_set.lect_id as lect_id ,lecturer.lect_first_name AS first_name, lecturer.lect_last_name AS last_name, problem_set.set_level AS level, 
problem_set.date_time_created AS created
FROM problem_set
INNER JOIN lecturer ON problem_set.lect_id = lecturer.lect_id where lect_username='$username' order by created desc ";
$result=$db->query($query) or die($db->error);


if($result->num_rows>0){
echo"  <table border=0 class='table table-bordered'><tr class='danger'>
<td>Problem Title</td><td>Level of difficulty</td><td>Date and time created</td><td colspan='3' align='center'>Task</td>
</tr>";
while($row=$result->fetch_assoc()){
  echo "<tr>";

$date=date_create($row['created']);
echo "
<td><a href='$url?name=".$row['setname']."'>".$row['setname']."</a></td>
<td>".$row['level']."</td>
<td>".date_format($date,"d-m-Y H:i:s")."</td>
<td align='center'> 
<a class='btn btn-success' href='edit_problem.php?setname=".$row['setname']."
'>Edit Problem</a></td>
<td align='center'><a class='btn btn-danger' href='javascript:delete_id(".$row['set_id'].")' >Delete Problem</a></td>
<td align='center'><a class='btn btn-primary' href='add_test_case.php?id=".$row['set_id']."&title=".$row['setname']."'>Test Case</a></td>
</tr>";
}
}
else
 echo "No problem set has created";
echo "</table>";//end of table
?>
</body>
</html>

