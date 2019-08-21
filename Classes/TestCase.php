<?php
require 'FileUpload.php';
class TestCase extends FileUpload{
	private $problem_title;
	private $fileType;
	//constructor that set thee information, the parent constructor will get filename, size, type and temp location.
	public function __construct($filename,$size,$type,$temp,$problem_title,$fileType){
		parent::__construct($filename,$size,$type,$temp);
		$this->problem_title=$problem_title;
		$this->fileType=$fileType;
	}
	//validate file extension
	public function validateFileExt(){
		$ext=explode('.', $this->filename);
		if($ext[1]=="txt"||$ext[1]=="in")
			return true;
		else 
			return false;
	}
	//get the path
	public function setPath(){
		$setpath="../problem_set/".$this->problem_title."/".$this->fileType."/".$this->filename;
		return $setpath;
	}
	//check file size
	public  function checkSize(){
		if($this->size>1000000)
			return false;
		else 
			return true;
	}
	//insert test case info into database
	public function updateTcdb($input,$output){
		require 'DBconnect.php';
		$query1="select set_id from problem_set where set_name='$this->problem_title';";
		$result1=$db->query($query1) or die($db->error);
		//fetch problem set id
		if($result1->num_rows>0)
		$id=$result1->fetch_assoc();
	
		$getid=$id['set_id'];
	    if(!empty($input)){//if set input test case
	    	$query2="insert into test_case values('','$input','$output',$getid);";
	    	$result2=$db->query($query2) or die($db->error);
	    	if(isset($result2->insert_id))
	    		return true;
			else 
				return false;
	    }
	    else{//if set output test case
	    $query3="insert into test_case values('','','$output',$getid);";
	    	$result3=$db->query($query3) or die($db->error);
	    	if(isset($result3->insert_id))
	    		return true;
			else 
				return false;
		}
	}
	//upload the test case
	public function uploadTestCase(){
		$this->path=$this->setPath();
		$status_upload=parent::moveFile();
		return $status_upload;
    }
    //get filename
    public function getFilename(){
    	return $this->filename;
    }
    //update the test case info into database
    public function updateDB($path_input,$path_output,$id){
    	require 'DBconnect.php';
	    $query2="update test_case set input='$path_input', output='$path_output' where set_id='$id'";
	    $result2=$db->query($query2) or die($db->error);
	    if(isset($result2->insert_id))
	    	return true;
		else 
			return false;
    }
}