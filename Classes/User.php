<?php
abstract class User{
	protected $username;
	protected $password;
	protected $first_name;
	protected $image;
	static $invalidUser;

	function setUsername($username){
		$this->username=strtolower(trim($username));
	}
	function setPassword($password){
		$this->password=trim($password);
	}
}
?>