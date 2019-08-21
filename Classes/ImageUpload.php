<?php
require "FileUpload.php";
class ImageUpload extends FileUpload
{
	private $username;
	private $userType;
	function __construct($filename,$size,$type,$temp,$username,$userType){
		 parent::__construct($filename,$size,$type,$temp);
		 $this->userType=$userType;
		 $this->username=$username;
	}
	public function validateFileExt(){
		$ext=explode('.', $this->filename);
		if($ext[1]=="jpeg"||$ext[1]=="jpg"||$ext[1]=="png"||$ext[1]=="gif")
			return true;
		else 
			return false;
		} 
	function setPath(){
		if($this->userType=="lecturer")
		$newpath="../image/user_image/$this->username/".$this->filename;
		else
		$newpath="image/user_image/$this->username/".$this->filename;
		return $newpath;
	}
	function moveImage(){
		$this->path=$this->setPath();
		$status=parent::moveFile();
		return $status;
	}
	function updateImage(){
		require 'DBconnect.php';
		if($this->userType=="lecturer")
	    $query="update ".$this->userType." set image='$this->filename' where lect_username='$this->username'";
		else
		$query="update ".$this->userType." set image='$this->filename' where stud_username='$this->username'";
	    $result=$db->query($query) or die($db->error);
	    if($db->affected_rows>0)
	    	return true;
		else 
			return false;
	}
	function getPath(){
		return $this->path;
	}
}

?>