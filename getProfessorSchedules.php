<?php 


require 'connect.php';
include 'constants.php';
include 'helper.php';

$day = $_POST['day'];
$room_number = $_POST['room_number'];


if(isset($_POST['professor_id']))
{
	$professor_id = $_POST['professor_id'];

	$searchSQL = "SELECT ".SCHEDULE_ID.",".SCHEDULE_TIME_IN.", ".SCHEDULE_TIME_OUT." FROM ".TBL_SCHEDULE." WHERE ".PROFESSOR_ID." = '$professor_id' AND ".SCHEDULE_DAY." = '$day' AND ".IS_ACTIVE." = ".ACTIVE." AND ".ROOM_NUMBER." = '$room_number'";
	
	$resultSQL = mysqli_query($con, $searchSQL);

	$profsched = array();

	while($rowSQL = mysqli_fetch_assoc($resultSQL))
	{
		$profsched[$rowSQL[SCHEDULE_ID]] = array(

		$rowSQL[SCHEDULE_ID] => date("h:i:s a",strtotime($rowSQL[SCHEDULE_TIME_IN])).' - '. date('h:i:s a',strtotime($rowSQL[SCHEDULE_TIME_OUT])),

		);
	}

}

echo json_encode($profsched);

?>
