<?php 

require 'connect.php';
include 'constants.php';
include 'helper.php';


$cardnumber = $_GET['card_number'];
$currentTime= $_GET['current_time']; 
$currentDay = date('w');
$room_number = $_GET['room_number'];
$grace_period = 900;
$required_time_for_log_out = 1800;
$date_today = date('Y-m-d');

$retrieveSQL = "SELECT ".PROFESSOR_ID." FROM ".TBL_PROFESSOR." WHERE ".SERIAL_NUMBER." = '$cardnumber' AND ".IS_ACTIVE." = 1";

$result = mysqli_query($con, $retrieveSQL);


$row = mysqli_fetch_assoc($result);

$professor_id = $row[PROFESSOR_ID];

$getProfessorSchedule = "SELECT ".SCHEDULE_ID.", ".SCHEDULE_TIME_IN.", ".SCHEDULE_TIME_OUT." FROM ".TBL_SCHEDULE." WHERE ".PROFESSOR_ID." = '$professor_id' AND ".IS_ACTIVE." = 1 AND ".SCHEDULE_DAY." = '$currentDay' AND ".ROOM_NUMBER." = '$room_number'";

$schedule = mysqli_query($con, $getProfessorSchedule);

$scheduleArr = array();

while($scheduleRow = mysqli_fetch_assoc($schedule))
{
	$scheduleArr[] = array(

		SCHEDULE_TIME_IN => $scheduleRow[SCHEDULE_TIME_IN],
		SCHEDULE_TIME_OUT => $scheduleRow[SCHEDULE_TIME_OUT]

	);
}

foreach($scheduleArr as $sched)
 {

 	$timeinsched = $sched[SCHEDULE_TIME_IN];
 	$timeoutsched = $sched[SCHEDULE_TIME_OUT];

 	//check if the current time fits the professor's schedule
 	if(strtotime($currentTime) >= strtotime($sched[SCHEDULE_TIME_IN]) && strtotime($currentTime) <= strtotime($sched[SCHEDULE_TIME_OUT]))
 	{
 		//check the database or last time log under the currentTime 
 		$checkSQL = "SELECT * FROM ".TBL_TIME_LOG." WHERE ".TIME_LOG_IN." >= '$timeinsched'  AND ".TIME_LOG_OUT." <= '$timeoutsched' AND ".TIME_LOG_DATE." = '$date_today' LIMIT 1";

 		$result = mysqli_query($con, $checkSQL);

 		if(mysqli_num_rows($result) > 0)
 		{
			 $dataRow = mysqli_fetch_assoc($result);

			 //if below 30mins, log out won't be recognized
			  if((strtotime($dataRow[TIME_LOG_IN])+$required_time_for_log_out) >= strtotime($currentTime))
			  {
			  	echo 'Minute/s to go:'.''.date('i',(strtotime($dataRow[TIME_LOG_IN])+$required_time_for_log_out)-strtotime($currentTime));
			  }
			  else
			  {
			  	if($dataRow[TIME_LOG_OUT] == "00:00:00")
				 {
				 	$updateTimeLogOut = "UPDATE ".TBL_TIME_LOG." SET ".TIME_LOG_OUT." = '$currentTime', ".IS_VALID." = 1 WHERE ".TIME_LOG_IN." >= '$timeinsched'  AND ".TIME_LOG_OUT." <= '$timeoutsched' AND ".TIME_LOG_DATE." = '$date_today' AND ".PROFESSOR_ID." = '$professor_id'";
				 	$updatedTimeLogOut = mysqli_query($con, $updateTimeLogOut);

				 	if(mysqli_affected_rows($con) == 1)
				 	{
				 		echo 'UPDATED TIME LOG OUT';


				 		$updateRoom = "UPDATE ".TBL_ROOM_AVAILABILITY." SET ".IS_AVAILABLE." = 1, ".PROFESSOR_ID." = '$professor_id' WHERE ".ROOM_NUMBER." = '$room_number'";

				 		mysqli_query($con, $updateRoom);
				 	}
				 }
				 else
				 {
				 	echo 'ALREADY HAVE A TIME LOG FOR THE SCHEDULE';
				 }
			  }
 		}
 		else
 		{
 			if(strtotime($currentTime) <= (strtotime($sched[SCHEDULE_TIME_IN]) + $grace_period))
	  		{
	  			// on time with grace period of 15mins
	  			$insertNewTimeLog = "INSERT INTO ".TBL_TIME_LOG."(".PROFESSOR_ID.", ".TIME_LOG_DATE.", ".TIME_LOG_IN.", ".ROOM_NUMBER.", ".IS_LATE.") VALUES ('$professor_id', '$date_today', '$currentTime', '$room_number', 0)";

	  			$addResult = mysqli_query($con, $insertNewTimeLog);
	  			
	  			if($addResult)
	  				echo 'SUCCESSFULLY ADDED WITHOUT LATE';
	  		}
	  		else
	  		{
	  			//if late
	  			$insertNewTimeLog = "INSERT INTO ".TBL_TIME_LOG."(".PROFESSOR_ID.", ".TIME_LOG_DATE.", ".TIME_LOG_IN.", ".ROOM_NUMBER.", ".IS_LATE.") VALUES ('$professor_id', '$date_today', '$currentTime', '$room_number', 1)";
	  			$addResult = mysqli_query($con, $insertNewTimeLog);
	  				echo 'SUCCESSFULLY ADDED WITH LATE';

	  		}
 		

			$updateRoom = "UPDATE ".TBL_ROOM_AVAILABILITY." SET ".IS_AVAILABLE." = 0, ".PROFESSOR_ID." = '$professor_id' WHERE ".ROOM_NUMBER." = '$room_number'";

			mysqli_query($con, $updateRoom);

 		}
 	}
	  	

	//check muna kung mag mamatch ang currentTime sa SCHEDULE_TIME_IN
	// pwedeng 15mins yung grace period
	//gawing timestamp yung currentTime and yung SCHEDULE_TIME_IN + GRACE PERIOD
	// if magffall siya dun, mag query ka ulet at tignan lahat ng logs niya near the time on the same day and if meron nang in
	// syempre out na yung lalagyan momdcm
}



?>