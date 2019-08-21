<?php
require "../Classes/DBconnect.php";
$set_id=$_GET['delete_id'];
$query_get_filename="select set_name from problem_set where set_id=$set_id";
$result=$db->query($query_get_filename) or die($db->error);
$rows=$result->fetch_assoc();
$set_name=$rows['set_name'];
$query_delete="delete from problem_set where set_id=$set_id";
$db->query($query_delete) or die($db->error); 
echo $db->affected_rows;
if($db->affected_rows>0){
	exec("rm -rf ../problem_set/\"$set_name\"");
	if(!file_exists("../problem_set/\"$set_name\"")){
		echo "<script> 
		alert('successfully delete problem set ".$set_name."');
		</script>";

	}
	else
		echo "sumthing Wrong!";
}
echo "<script>window.location.href='view_created_problem.php';</script>"
?>