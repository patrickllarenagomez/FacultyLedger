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

//professor data start
$professorArr = array();

$profSQL = "SELECT ".PROFESSOR_ID." FROM ".TBL_PROFESSOR." WHERE ".IS_ACTIVE." = 1";

$result = mysqli_query($con, $profSQL);

while($row = mysqli_fetch_assoc($result))
{
	array_push($professorArr, $row[PROFESSOR_ID]);
}

$professorData = implode(",", $professorArr); 
// professor data code end

//professor schedule start

$scheduleSQL = "SELECT ".PROFESSOR_ID.", "."COUNT(*)"." as ".SCHEDULE_COUNT." FROM ".TBL_SCHEDULE." WHERE ".PROFESSOR_ID." IN (".$professorData.") AND ".IS_ACTIVE." = 1 GROUP BY ".PROFESSOR_ID."";
$schedules = mysqli_query($con, $scheduleSQL);


while($rowData = mysqli_fetch_assoc($schedules))
{
	$scheduleArray[$rowData[PROFESSOR_ID]] = $rowData[SCHEDULE_COUNT];
}

//professor schedule code end


$generateSQL = "SELECT ".PROFESSOR_ID.","."SUM(".IS_LATE.") as ".IS_LATE."".", "."COUNT(case when ".IS_VALID." = '0' then 1 else null end)"." as ".INVALIDLOG.", "."COUNT(*)"." as ".ROWS." FROM ".TBL_TIME_LOG." WHERE ".PROFESSOR_ID." IN (".$professorData.") AND ".TIME_LOG_DATE." BETWEEN '$startDate' AND '$endDate' GROUP BY ".PROFESSOR_ID."";

$generateResults = mysqli_query($con, $generateSQL);


$professorDataArr = array();
while($rows = mysqli_fetch_assoc($generateResults))
{	
	$professorDataArr[$rows[PROFESSOR_ID]] = array(

		IS_LATE => $rows[IS_LATE],
		INVALIDLOG => $rows[INVALIDLOG],
		ROWS => $rows[ROWS],
		SCHEDULE_COUNT => $scheduleArray[$rows[PROFESSOR_ID]]
	);

}

showarray($professorDataArr);

$_SESSION['generate_PDF'] = "<div class='alert alert-success alert-dismissible'>
		  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
		  <strong>Report was generated successfully!</strong> 
		</div>";



//header("location: attendance.php");
?>