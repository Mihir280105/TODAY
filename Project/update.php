<?php
	include "imp.php";
	include "config.php";
	$id = $_REQUEST['id'];
	$unm = $_REQUEST['unm'];
	$pwd =$_REQUEST['pwd'];
	$cpwd =$_REQUEST['cpwd'];
	$no=$_REQUEST['no'];
	$age=$_REQUEST['age'];
	$rd1 =$_REQUEST['rd1'];
	
	$update = "UPDATE `loginsystem` SET `unm`='$unm',`pwd`='$pwd',`cpwd`='$cpwd',`no`='$no',`age`='$age',`rd1`='$rd1' WHERE `id`='$id'";
	$result = mysqli_query($con,$update);
	header("location:profile.php");
	
?>