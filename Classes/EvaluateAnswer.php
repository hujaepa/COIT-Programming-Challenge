<?php
/*******************************
This class is to evaluate student 
answer. It has compile, runtime, 
timelimit and compare output method.
All this method will evaluate.
*******************************/
class EvaluateAnswer{
	private $filepath;
	private $out;//the out filename
	private $problem_title;
	private $username;
	private $filename;
	private $outpath;
	private $time;
	private $input;
	public function __construct($name,$path,$problem_title,$username){
		$this->filename=$name;
		$this->filepath=$path;
		$this->out=explode(".",$name);
		$this->problem_title=$problem_title;
		$this->username=$username;
	}
	public function getInput(){

require "Classes/DBconnect.php";
		$query="select test_case.input from test_case inner join problem_set on problem_set.set_id=test_case.set_id where problem_set.set_name='$this->problem_title'";
		$result=$db->query($query) or die($db->error);
		$row=$result->fetch_assoc();
		$this->input=$row['input'];
	}
	public function compile(){
		$ext=explode(".", $this->filename);
		if($ext[1]=="c")
		$outpath=str_replace(".c", ".out", $this->filename);
		else
		$outpath=str_replace(".cpp", ".out", $this->filename);
		$this->outpath=$outpath;
		if(exec("g++ -g problem_set/\"$this->problem_title\"/$this->username/$this->filename -o problem_set/\"$this->problem_title\"/$this->username/$this->outpath 2>&1"))
		    return false;
		else 
			return true;
	}
	public function runTime(){

require "Classes/DBconnect.php";
		$query="select time_limit from problem_set where set_name='$this->problem_title'";
		$result=$db->query($query) or die($db->error);
		$row=$result->fetch_assoc();
		$this->time=$row['time_limit']+1;
		//check input file empty or not
		if(empty($this->input))
		$status=exec("timeout $this->time valgrind problem_set/\"$this->problem_title\"/$this->username/./$this->outpath 2>&1");
		else
		$status=exec("timeout $this->time valgrind problem_set/\"$this->problem_title\"/$this->username/./$this->outpath < problem_set/\"$this->problem_title\"/input/$this->input 2>&1");
		$runtime=substr($status,9,39);
		if($runtime=="ERROR SUMMARY: 0 errors from 0 contexts")
			return true;
		else
			return false;

	}
	public function checkTimeLimit(){
		ini_set('memory_limit', '10000M');
		$start=time();
		//exec("timeout $this->time problem_set/\"$this->problem_title\"/$this->username/./$this->outpath");
		if(empty($this->input))
		$status=exec("timeout $this->time valgrind problem_set/\"$this->problem_title\"/$this->username/./$this->outpath 2>&1");
		else
		$status=exec("timeout $this->time valgrind problem_set/\"$this->problem_title\"/$this->username/./$this->outpath <  problem_set/\"$this->problem_title\"/input/$this->input");
		$end=time();
		$total=$end-$start;
		if($total>$this->time-1)
		return false;
		else
		return true;

	}
	public function compare(){
		/***
		1. Check input file
		   -Execute the file with input and save  at output file
		   else
		   -Execute the file and save at output file txt
		 2.use command diff
		**/

require "Classes/DBconnect.php";
		$query="select test_case.input, test_case.output, problem_set.set_name from test_case 
		inner join problem_set 
		ON test_case.set_id = problem_set.set_id
		where problem_set.set_name ='$this->problem_title'";
		$result=$db->query($query) or die($db->error."testing");
		$row=$result->fetch_assoc();
		$answer=str_replace(".cpp", ".txt", $this->filename);
		if(empty($this->input))
			exec("problem_set/\"$this->problem_title\"/$this->username/./$this->outpath > problem_set/\"$this->problem_title\"/$this->username/$answer");
		else{
			exec("problem_set/\"$this->problem_title\"/$this->username/./$this->outpath < problem_set/\"$this->problem_title\"/input/$this->input > problem_set/\"$this->problem_title\"/$this->username/$answer");
		}
		//do comparison
		$output=$row['output'];
		$status=exec("diff -B -w -Z problem_set/\"$this->problem_title\"/$this->username/$answer problem_set/\"$this->problem_title\"/output/$output 2>&1");
		if(empty($status))
			return true;
		else
			return false;

	}
	public function insertDB($status){
		/*
		1. get set id
		2. stud id
		3.insert answer status
		*/
		require "Classes/DBconnect.php";
		$query1="select set_id from problem_set where set_name='$this->problem_title'";
		$result1=$db->query($query1) or die($db->error);
		if($result1->num_rows>0){
			$row=$result1->fetch_assoc();
			$set_id=$row['set_id'];
		}
		$query2="select stud_id from student where stud_username='$this->username'";
		$result2=$db->query($query2) or die($db->error);
		if($result2->num_rows>0){
			$row=$result2->fetch_assoc();
			$stud_id=$row['stud_id'];
		}
		$query3="insert into answer(answer_id,set_id,stud_id,status,date_time_submit,answer_file) values('',$set_id,$stud_id,'$status',now(),'$this->filename')";
		$result3=$db->query($query3) or die($db->error);
		if($db->affected_rows>0)
			return true;
		 else
		 	return false;
	}
}