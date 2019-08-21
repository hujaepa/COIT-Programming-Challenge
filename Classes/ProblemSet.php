
<?php
class ProblemSet{
	private $id;
    private $title;
	private $desc;
	private $hint;
	private $level;
	private $time_limit;
	private $lect_un;
	//constructor that set the information
	function __construct($title,$desc,$hint,$level,$time_limit,$lect_un){
	  $this->title=trim($title);
	  $this->desc=chop($desc);
	  $this->hint=trim($hint);
	  $this->level=trim($level);
	  $this->time_limit=trim($time_limit);
	  $this->lect_un=trim($lect_un);
	}
	//check problem title duplication
	function checkDuplicate(){
		require 'DBconnect.php';
		$query="select set_name from problem_set where set_name='$this->title'";
		$result=$db->query($query) or die($db->error);
		if($result->num_rows>0)
			return false;
		else
			return true;
	}
	//Insert problem title
	function insertProblem(){
		require 'DBconnect.php';
		$query1="select lect_id from lecturer where lect_username='$this->lect_un'";
		$result1=$db->query($query1) or die($db->error);
		//get the lect id
		if($result1->num_rows>0)
			$this->id=$result1->fetch_assoc();
		$id=$this->id['lect_id'];
		$query2="insert into problem_set(set_id,set_name,set_desc,set_level,date_time_created,hint,time_limit,lect_id) 
		values('','$this->title','$this->desc','$this->level',now(),'$this->hint',$this->time_limit,$id);";
		$result2=$db->query($query2) or die($db->error." testing");
		if($db->affected_rows>0){
		 	return true;
		}
		else 
			return false;
		}
		//delete problem title
	function deleteProblem(){
		require 'DBconnect.php';
		$query="delete * from problem_set where problem_title='$this->title'";
		$result=$db->query($query) or die($db->error);
		if($db->affected_rows>0)
			return true;
		else 
			return false;
	}
	function updateProblem(){
	  require 'DBconnect.php';
	  $query="update problem_set set set_name='$this->title',set_desc='$this->desc',
	  hint='$this->hint',
	  set_level='$this->level',
	  time_limit=$this->time_limit
	  where set_name='$this->title'";
	  $result=$db->query($query) or die($db->error);
		if($db->affected_rows>0)
			return true;
		else 
			return false; 
	}
	
}

?>