<?php 

require 'connect.php';
include 'constants.php';
include 'helper.php';

$professor_id =  $_POST['professor_id'];

$sql = "SELECT ".SERIAL_NUMBER." FROM ".TBL_PROFESSOR." WHERE ".PROFESSOR_ID."='$professor_id'";

$result = mysqli_query($con, $sql);

$row = mysqli_fetch_assoc($result);

echo json_encode($row);
?>