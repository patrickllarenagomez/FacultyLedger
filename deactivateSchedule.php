<?php 
session_start();

require 'connect.php';
include 'constants.php';
include 'helper.php';

if(isset($_GET['id']))	
	$schedule_id = $_GET['id'];

$updateSQL = "UPDATE ".TBL_SCHEDULE." SET 

".IS_ACTIVE." = '0' 

WHERE ".SCHEDULE_ID." = $schedule_id";

mysqli_query($con, $updateSQL);

$_SESSION['attendance_success_delete'] = "<div class='alert alert-success alert-dismissible'>
<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
<strong>Schedule was deactivated successfully!</strong> 
</div>";
   
header('location: schedule.php');

?>