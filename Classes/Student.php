<?php
/***
This class will implement login for student
***/
require 'User.php';
//require 'Interfaces/UserInterface.php';
class Student Extends User{

	function getUsername(){
		return $this->username;
	}

	function getImage(){
	require'DBconnect.php';
	$image="select image from student where stud_username='$this->username'";
	$result=$db->query($image) or die($db->error);
	$row =$result->fetch_assoc();
	$this->image=$row['image'];
	return $this->image;
	}

	function getFirstName(){
	require'DBconnect.php';
	$query="select * from student where stud_username='$this->username'";
	$result=$db->query($query) or die($db->error);
	$row =$result->fetch_assoc();
	//check if there is space on the student first name
	$space=preg_match('/\s/',$row['stud_first_name']);
	if($space){
		$arrayName=explode(" ",$row['stud_first_name']);
		$this->first_name=$arrayName[1];
	}
	else
		$this->first_name=$row['stud_first_name'];
	return $this->first_name;
	}

	function login(){
	require'DBconnect.php';
	$query="select * from student where stud_username='$this->username' and stud_password='$this->password'";
			$result=$db->query($query) or die($db->error);
			$row =$result->fetch_assoc();
			//if username found then create session
			if($row!=0){
			   session_start();
			   $_SESSION['student']=$this->username;
			   header("location:stud_home.php");
			}//end of if

			else
				self::$invalidUser="Invalid username or password";			
	}//end of login
	function getProfile(){
		require'DBconnect.php';
		$query="select * from student where stud_username='$this->username'";
		$result=$db->query($query) or die($db->error);
		if($result->num_rows>0){
		$row =$result->fetch_assoc();
		return $row;
		}

	}//end of get profile
	//this method will update user image
	function updateImage($filename){
		require'DBconnect.php';
		$this->image="image/user_image/".$this->username."/".$filename;
		$query="update student set image='$this->image' where stud_username='$this->username'";
		$result=$db->query($query) or die($db->error);
		return $this->image;
	}
	
}//end of class
?>