<?php 



$username = 'root';
$password = '';
$db = 'faculty_ledger';
$con = mysqli_connect('localhost', $username, $password, $db);

if(!mysqli_connect()){
	echo 'Error. Connecting to the database failed.';
}

date_default_timezone_set('Asia/Manila');


?>