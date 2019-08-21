<?php
	$db=new mysqli("localhost","root","1q2w3e4r*#@","cpcdb");
	if($db->connect_errno>0)
	echo "Unable to connect to database!";
?>