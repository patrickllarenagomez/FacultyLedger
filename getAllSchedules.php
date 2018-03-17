<?php 


require 'connect.php';
include 'constants.php';
include 'helper.php';

$day = $_POST['day'];
$room_number = $_POST['room_number'];

$timeinsched = array(

	0 => strtotime("07:30:00"),
	1 => strtotime("08:00:00"),
	2 => strtotime("08:30:00"),
	3 => strtotime("09:00:00"),
	4 => strtotime("09:30:00"),
	5 => strtotime("10:00:00"),
	6 => strtotime("10:30:00"),
	7 => strtotime("11:00:00"),
	8 => strtotime("11:30:00"),
	9 => strtotime("12:00:00"),
	10 => strtotime("12:30:00"),
	11 => strtotime("13:00:00"),
	12 => strtotime("13:30:00"),
	13 => strtotime("14:00:00"),
	14 => strtotime("14:30:00"),
	15 => strtotime("15:00:00"),
	16 => strtotime("15:30:00"),
	17 => strtotime("16:00:00"),
	18 => strtotime("16:30:00"),
	19 => strtotime("17:00:00"),
	20 => strtotime("17:30:00"),
	21 => strtotime("18:00:00"),
	22 => strtotime("18:30:00"),
	23 => strtotime("19:00:00"),
	24 => strtotime("19:30:00"),
	25 => strtotime("20:00:00"),
	26 => strtotime("20:30:00"),
);


if(isset($_POST['professor_id']))
{
	$professor_id = $_POST['professor_id'];

	$searchSQL = "SELECT ".SCHEDULE_ID.",".SCHEDULE_TIME_IN.", ".SCHEDULE_TIME_OUT." FROM ".TBL_SCHEDULE." WHERE ".PROFESSOR_ID." = '$professor_id' AND ".SCHEDULE_DAY." = '$day' AND ".IS_ACTIVE." = ".ACTIVE."";
	
	$resultSQL = mysqli_query($con, $searchSQL);

	$profsched = array();

	while($rowSQL = mysqli_fetch_assoc($resultSQL))
	{
		$profsched[$rowSQL[SCHEDULE_ID]] = array(

		SCHEDULE_TIME_IN => strtotime($rowSQL[SCHEDULE_TIME_IN]),
		SCHEDULE_TIME_OUT => strtotime($rowSQL[SCHEDULE_TIME_OUT])

		);
	}

	foreach($profsched as $prof)
	{
		foreach($timeinsched as $key => $timein)
		{
			if($timein < $prof[SCHEDULE_TIME_OUT] && $timein >= $prof[SCHEDULE_TIME_IN])
			{
				unset($timeinsched[$key]);
			}
		}
	}
}

$sql = "SELECT ".SCHEDULE_ID.",".SCHEDULE_TIME_IN.", ".SCHEDULE_TIME_OUT." FROM ".TBL_SCHEDULE." WHERE ".SCHEDULE_DAY." = '$day' AND ".ROOM_NUMBER." = '$room_number' AND ".IS_ACTIVE."=".ACTIVE." GROUP BY ".SCHEDULE_ID." ";

$result = mysqli_query($con, $sql);

$activeScheduleArr = array();

while($row = mysqli_fetch_assoc($result))
{
	$activeScheduleArr[$row[SCHEDULE_ID]] = array(

		SCHEDULE_TIME_IN => strtotime($row[SCHEDULE_TIME_IN]),
		SCHEDULE_TIME_OUT => strtotime($row[SCHEDULE_TIME_OUT])

	);
}	

foreach($activeScheduleArr as $activeSched)
{
	foreach($timeinsched as $key => $timein)
	{
		if($timein < $activeSched[SCHEDULE_TIME_OUT] && $timein >= $activeSched[SCHEDULE_TIME_IN])
		{
			unset($timeinsched[$key]);
		}
	}
}

$inactiveScheduleArr = array();
$inactiveScheduleArr = $timeinsched;
$availSched = array();

foreach($inactiveScheduleArr as $inactive)
{
	$availSched[date("H:i:s",$inactive)] = date("h:i:s A",$inactive); 
}

echo json_encode($availSched);

?>
