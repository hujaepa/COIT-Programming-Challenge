<?php
interface UserInterface{
	function login();
	function getImage();
	function getProfile();
	function updateImage($filename);
}
?>