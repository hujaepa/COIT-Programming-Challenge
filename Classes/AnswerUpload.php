<?php
require "FileUpload.php";
//this class is to upload student answer
class AnswerUpload extends FileUpload{
		private $problem_title;
		private $username;
		public function __construct($filename,$size,$type,$temp,$problem_title,$username){
		parent::__construct($filename,$size,$type,$temp);
		$this->username=$username;
		$this->problem_title=$problem_title;
		}

		public function validateFileExt(){
		$ext=explode('.', $this->filename);
		if($ext[1]=="c"||$ext[1]=="cpp")
			return true;
		else 
			return false;
		} 

		public function getPath(){
		$setpath="problem_set/$this->problem_title/$this->username/$this->filename";
		return $setpath;
		}

		public  function checkSize(){
		if($this->size>10000000)
			return false;
		else 
			return true;
		}

	public function uploadAnswer(){
		$this->path=$this->getPath();
		$status_upload=parent::moveFile();
		return $status_upload;
    }
    public function getFileName(){
    	return $this->filename;
    }
}
?>