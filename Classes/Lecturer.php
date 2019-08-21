<?php
/***
This class will implement login,display image, display profile and update image for lecturer
***/
require 'User.php';
require '../Interfaces/UserInterface.php';
class Lecturer Extends User implements UserInterface{

	function getUsername(){

		return $this->username;
	}
	 
	//this method is to get user image from db
	function getImage(){
	require'DBconnect.php';
	 $image="select image from lecturer where lect_username='$this->username'";
	 $result=$db->query($image) or die($db->error);
	 $row =$result->fetch_assoc();
	 $this->image=$row['image'];
	 return $this->image;
	}
	//this method is to get user first name from db. return the first name to the main
	function getFirstName(){
	 require'DBconnect.php';
	 $query="select * from lecturer where lect_username='$this->username'";
	 $result=$db->query($query) or die($db->error);
	 $row =$result->fetch_assoc();
	 //check if there is space on the lecturer first name
	 $space=preg_match('/\s/',$row['lect_first_name']);
	 if($space){
		$arrayName=explode(" ",$row['lect_first_name']);
		$this->first_name=$arrayName[1];
	 }
	 else
		$this->first_name=$row['lect_first_name'];
	 return $this->first_name;
	}
	//this method is to do login process for user
	function login(){
	require'DBconnect.php';
	$query="select * from lecturer where lect_username='$this->username' and lect_password='$this->password'";
			$result=$db->query($query) or die($db->error);
			$row =$result->fetch_assoc();
			//if username found then create session
			if($row!=0){
				//close connection
			   $db->close();
			   session_start();
			   $_SESSION['lecturer']=$this->username;
			   header("location:lect_home.php");
			}//end of if

			else
			parent::$invalidUser="Invalid username or password!";			
	}
	//this method to get user profile information
	function getProfile(){
		require'DBconnect.php';
		$query="select * from lecturer where lect_username='$this->username'";
		$result=$db->query($query) or die($db->error);
		if($result->num_rows>0){
		$row =$result->fetch_assoc();
		return $row;
		}

	}
	//this method will update user image
	function updateImage($newpath){
		require'DBconnect.php';
		$this->image=$newpath;
		$query="update lecturer set image='$this->image' where lect_username='$this->username'";
		$result=$db->query($query) or die($db->error);
	}
}//end of class
?>