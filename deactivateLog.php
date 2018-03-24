<?php 
session_start();

require 'connect.php';
include 'constants.php';
include 'helper.php';

if(isset($_GET['id']))	
	$timelog = $_GET['id'];

$updateSQL = "UPDATE ".TBL_TIME_LOG." SET 

".IS_ACTIVE." = '0' 

WHERE ".TIME_LOG_ID." = $timelog";

mysqli_query($con, $updateSQL);

$_SESSION['attendance_success_delete'] = "<div class='alert alert-success alert-dismissible'>
<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
<strong>Attendance Log was deleted successfully!</strong> 
</div>";
   
header('location: attendance.php');

?>