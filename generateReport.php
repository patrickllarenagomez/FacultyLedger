<?php 

session_start();
require 'connect.php';
include 'constants.php';
include 'helper.php';

if(isset($_POST))
{
	$startDate =  $_POST["startDT"];
	$endDate = $_POST["endDT"];
}


mysqli_query();

$_SESSION['generate_PDF'] = "<div class='alert alert-success alert-dismissible'>
		  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
		  <strong>Report was generated successfully!</strong> 
		</div>";

header("location: attendance.php");
?>