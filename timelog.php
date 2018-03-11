<?php 

require 'connect.php';
include 'constants.php';
include 'helper.php';

//required details 
$cardnumber = $_POST['card_number'];
$currentTime= $_POST['current_time']; 
$room_number = $_POST['room_number'];
$grace_period = 900;
$required_time_for_log_out = 1800;
$date_today = date('Y-m-d');
$currentDay = date('w');

//server-side
$responseArr = array();
$checkBool = FALSE;

// *******\NUMBER CODE/***********
// ADD MORE IF NEEDED
// 
// 0 = UNREGISTERED CARD OR INACTIVE CARD - MUST ENABLE USING SYSTEMS UNDER PROFESSORS
// 1 = PROFESSOR IS ACTIVE BUT NO SCHEDULE ON PROFESSOR'S PROFILE FOR TODAY -- CHECK SCHEDULE OR ADD SCHEDULE ON THE SYSTEM 
// 2 = WITH MINUTES / TIME NEEDED BEFORE YOU CAN LOG THE NEXT TIME // AS FOR THE SYSTEM, CURRENT IS 30MINS WHICH IS "1800" IN SECONDS
// 3 = INSERTED ON TIME LOG FOR ON TIME PROFESSORS
// 4 = INSERTED LATE LOG FOR LATE PROFESSORS
// 5 = UPDATED TIME LOG OUT FOR PROFESSOR
// 6 = CONFIRMATION THAT THE PROFESSOR ALREADY LOGGED ON HIS/HER LAST SCHEDULE
// 7 = PROFESSOR HAS SCHEDULE FOR THE DAY BUT NOT YET HIS TIME TO LOG IN.
// 8 = IF PROFESSOR'S TIME LOG IN IS 10:30 AND SCHED ONLY LASTS AT 10:45, HE/SHE WILL NOT WAIT 30 MINS TO LOG OUT, HE NEEDS TO TAP AT THE LAST 5MINS BEFORE THE SCHEDULE ENDS.


$retrieveSQL = "SELECT ".PROFESSOR_ID.", ".PROFESSOR_FIRST_NAME.", ".PROFESSOR_LAST_NAME." FROM ".TBL_PROFESSOR." WHERE ".SERIAL_NUMBER." = '$cardnumber' AND ".IS_ACTIVE." = 1";

$result = mysqli_query($con, $retrieveSQL);

if(!mysqli_num_rows($result) > 0)
{
	// CODE : 0

	array_push($responseArr, array("code" => 0));
	echo json_encode(array("server_response" => $responseArr),JSON_PRETTY_PRINT);
	$checkBool = true;

}

$row = mysqli_fetch_assoc($result);

$professor_id = $row[PROFESSOR_ID];
$professor_first_name = $row[PROFESSOR_FIRST_NAME];
$professor_last_name = $row[PROFESSOR_LAST_NAME];

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

if(empty($scheduleArr) && !is_null($professor_id))
{
	// CODE : 1
	array_push($responseArr, array("code" => 1, 
		PROFESSOR_FIRST_NAME => $professor_first_name,
		PROFESSOR_LAST_NAME => $professor_last_name ));
	
	echo json_encode(array("server_response" => $responseArr),JSON_PRETTY_PRINT);
	$checkBool = true;
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

			  	//experimental code start
			  	if((strtotime($timeoutsched) - strtotime($currentTime)) <= 300)
			  	{
			  		if($dataRow[TIME_LOG_OUT] == "00:00:00")
			  		{
			  			$updateTimeLogOut = "UPDATE ".TBL_TIME_LOG." SET ".TIME_LOG_OUT." = '$currentTime', ".IS_VALID." = 1 WHERE ".TIME_LOG_IN." >= '$timeinsched'  AND ".TIME_LOG_OUT." <= '$timeoutsched' AND ".TIME_LOG_DATE." = '$date_today' AND ".PROFESSOR_ID." = '$professor_id'";
				 		$updatedTimeLogOut = mysqli_query($con, $updateTimeLogOut);

			  			//update the room availability to available
				 		$updateRoom = "UPDATE ".TBL_ROOM_AVAILABILITY." SET ".IS_AVAILABLE." = 1, ".PROFESSOR_ID." = '$professor_id' WHERE ".
				 		ROOM_NUMBER." = '$room_number'";

				 		$updatedQuery = mysqli_query($con, $updateRoom);

			  			// CODE : 8
						array_push($responseArr, array("code" => 8, 
							PROFESSOR_FIRST_NAME => $professor_first_name,
							PROFESSOR_LAST_NAME => $professor_last_name,
							IS_UPDATED => 1));
						
						echo json_encode(array("server_response" => $responseArr),JSON_PRETTY_PRINT);
			  		}
			  		else
			  		{
			  			// CODE : 6
				 		array_push($responseArr, array("code" => 6, 
								PROFESSOR_FIRST_NAME => $professor_first_name,
								PROFESSOR_LAST_NAME => $professor_last_name,
								IS_UPDATED => 0,
								));

						echo json_encode(array("server_response" => $responseArr),JSON_PRETTY_PRINT);
			  		}
			  	}
			  	// experimental code ends
			  	else
			  	{
			  		if((strtotime($timeoutsched) - strtotime($dataRow[TIME_LOG_IN])) <= 1800)
			  		{
			  			// CODE : 2
						array_push($responseArr, array("code" => 2, 
							PROFESSOR_FIRST_NAME => $professor_first_name,
							PROFESSOR_LAST_NAME => $professor_last_name,
							TIME_REQUIRED_FOR_NEXT_LOG => date('i',((strtotime($timeoutsched) - strtotime($currentTime)) - 300))));
					
						echo json_encode(array("server_response" => $responseArr),JSON_PRETTY_PRINT);
			  		}
			  		else
			  		{
			  			// CODE : 2
						array_push($responseArr, array("code" => 2, 
							PROFESSOR_FIRST_NAME => $professor_first_name,
							PROFESSOR_LAST_NAME => $professor_last_name,
							TIME_REQUIRED_FOR_NEXT_LOG => date('i',(strtotime($dataRow[TIME_LOG_IN])+$required_time_for_log_out) - strtotime($currentTime))));
					
						echo json_encode(array("server_response" => $responseArr),JSON_PRETTY_PRINT);
			  		}
			  	}
			  	$checkBool = true;
				break;
			  }
			  else
			  {
			  	//if the last data contains no log out yet
			  	if($dataRow[TIME_LOG_OUT] == "00:00:00")
				 {
				 	$updateTimeLogOut = "UPDATE ".TBL_TIME_LOG." SET ".TIME_LOG_OUT." = '$currentTime', ".IS_VALID." = 1 WHERE ".TIME_LOG_IN." >= '$timeinsched'  AND ".TIME_LOG_OUT." <= '$timeoutsched' AND ".TIME_LOG_DATE." = '$date_today' AND ".PROFESSOR_ID." = '$professor_id'";
				 	$updatedTimeLogOut = mysqli_query($con, $updateTimeLogOut);
 
				 	if(mysqli_affected_rows($con) == 1)
				 	{
				 		//update the room availability to available
				 		$updateRoom = "UPDATE ".TBL_ROOM_AVAILABILITY." SET ".IS_AVAILABLE." = 1, ".PROFESSOR_ID." = ".NO_PROFESSOR." WHERE ".
				 		ROOM_NUMBER." = '$room_number'";

				 		$updatedQuery =mysqli_query($con, $updateRoom);

				 		if($updatedQuery)
				 		{
				 			// CODE : 5
				 			array_push($responseArr, array("code" => 5, 
							PROFESSOR_FIRST_NAME => $professor_first_name,
							PROFESSOR_LAST_NAME => $professor_last_name,
							IS_UPDATED => 1,
							));
						
							echo json_encode(array("server_response" => $responseArr),JSON_PRETTY_PRINT);
				 		}
				 	}
				 }
				 else
				 {
				 	// CODE : 6
				 	array_push($responseArr, array("code" => 6, 
							PROFESSOR_FIRST_NAME => $professor_first_name,
							PROFESSOR_LAST_NAME => $professor_last_name,
							IS_UPDATED => 0,
							));

					echo json_encode(array("server_response" => $responseArr),JSON_PRETTY_PRINT);
				 }
				 $checkBool = true;
				 break;
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
	  			{
	  				// CODE : 3
					array_push($responseArr, array("code" => 3, 
						PROFESSOR_FIRST_NAME => $professor_first_name,
						PROFESSOR_LAST_NAME => $professor_last_name,
						IS_LATE => 0,
						));
					
					echo json_encode(array("server_response" => $responseArr),JSON_PRETTY_PRINT);
	  			}
	  		}
	  		else
	  		{
	  			//if late
	  			$insertNewTimeLog = "INSERT INTO ".TBL_TIME_LOG."(".PROFESSOR_ID.", ".TIME_LOG_DATE.", ".TIME_LOG_IN.", ".ROOM_NUMBER.", ".IS_LATE.") VALUES ('$professor_id', '$date_today', '$currentTime', '$room_number', 1)";
	  			
	  			$addResult = mysqli_query($con, $insertNewTimeLog);
	  			
	  			if($addResult)
	  			{
					// CODE : 4
					array_push($responseArr, array("code" => 4, 
						PROFESSOR_FIRST_NAME => $professor_first_name,
						PROFESSOR_LAST_NAME => $professor_last_name,
						IS_LATE => 1,
						));
					
					echo json_encode(array("server_response" => $responseArr),JSON_PRETTY_PRINT);
	  			}

	  		}
 		
	  		// update room availability to occupied
			$updateRoom = "UPDATE ".TBL_ROOM_AVAILABILITY." SET ".IS_AVAILABLE." = 0, ".PROFESSOR_ID." = '$professor_id' WHERE ".ROOM_NUMBER." = '$room_number'";

			mysqli_query($con, $updateRoom);
			$checkBool = true;
			break;
 		}
 	}	
}

if($checkBool == false)
{
 	// CODE : 7
	array_push($responseArr, array("code" => 7, 
		PROFESSOR_FIRST_NAME => $professor_first_name,
		PROFESSOR_LAST_NAME => $professor_last_name,
		NOT_TIME_YET => 1,
		));
	
	echo json_encode(array("server_response" => $responseArr),JSON_PRETTY_PRINT);
}


?>