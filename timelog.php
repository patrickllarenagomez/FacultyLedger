<?php 

require 'connect.php';
include 'constants.php';
include 'helper.php';


$cardnumber = $_GET['card_number'];
//$currentTime= $_GET['current_time']; 
$currentDay = date('w');
//$room_number = $_GET['room_number'];

$retrieveSQL = "SELECT ".PROFESSOR_ID." FROM ".TBL_PROFESSOR." WHERE ".SERIAL_NUMBER." = '$cardnumber' AND ".IS_ACTIVE." = 1";

$result = mysqli_query($con, $retrieveSQL);


$row = mysqli_fetch_assoc($result);

$professor_id = $row[PROFESSOR_ID];

$getProfessorSchedule = "SELECT ".SCHEDULE_ID.", ".SCHEDULE_TIME_IN.", FROM ".TBL_SCHEDULE." WHERE ".PROFESSOR_ID." = '$professor_id' AND ".IS_ACTIVE." AND ".SCHEDULE_DAY." = '$currentDay'";

$schedule = mysqli_query($con, $getProfessorSchedule);

$scheduleArr = array();

while($scheduleRow = mysqli_fetch_assoc($schedule))
{
	$scheduleArr[] = array(

		SCHEDULE_DAY => $scheduleRow[SCHEDULE_DAY],
		SCHEDULE_TIME_IN => $scheduleRow[SCHEDULE_TIME_IN]

	);
}

foreach($scheduleArr as $sched)
{
	//if($currentTime >=)

	//check muna kung mag mamatch ang currentTime sa SCHEDULE_TIME_IN
	// pwedeng 15mins yung grace period
	//gawing timestamp yung currentTime and yung SCHEDULE_TIME_IN + GRACE PERIOD
	// if magffall siya dun, mag query ka ulet at tignan lahat ng logs niya near the time on the same day and if meron nang in
	// syempre out na yung lalagyan momdcm
}


showArray($scheduleArr);

?>