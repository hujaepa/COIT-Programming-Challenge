<?php
/*Class Description:
This class is to check whether the session is created or not. 
It will return value status in boolean data type
*/
class CheckSession{
function __construct(){
	session_start();
}
function getSession($username){
if(!isset($username))
	return false;
else 
	return true;
}

}
?>