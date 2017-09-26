<?php

include_once 'dbconfig.php';


$name=$_POST['name'];
$email=$_POST['email'];
$mobile=$_POST['mobile'];
$message=$_POST['message'];

$sql="INSERT INTO `contactus` (`name`,`email`,`mobile`,`message`) VALUES ('$name','$email','$mobile','$message')";
$con=$link->query($sql);
if($con)
	echo "Send";
else
	echo "Faild";
?>