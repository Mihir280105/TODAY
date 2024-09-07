<?php
	include "imp.php";
	require "config.php";
	session_start();
	$id = $_SESSION['id'];
	$delete="DELETE FROM `loginsystem` WHERE `id`='$id'";
	
	$res=mysqli_query($con,$delete);
	//echo $delete;
	session_destroy();
	header("location:login.php");
?>