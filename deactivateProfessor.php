<?php 
session_start();

require 'connect.php';
include 'constants.php';
include 'helper.php';

if(isset($_GET['id']))	
	$professor_id = $_GET['id'];



$updateSQL = "UPDATE ".TBL_PROFESSOR." SET 

".IS_ACTIVE." = '0' 

WHERE ".PROFESSOR_ID." = $professor_id";

mysqli_query($con, $updateSQL);

$_SESSION['edit_registration_success'] = "<div class='alert alert-success alert-dismissible'>
<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
<strong>Professor details was deactivated successfully!</strong> 
</div>";
   
header('location: professors.php');

?>