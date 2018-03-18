<?php 



function showArray($post)
{
	echo '<pre>';
	print_r($post);
	echo '</pre>';

}

function encryptPassword($password)
{
	$encryptedPassword = md5($password);
	return $encryptedPassword;
}

function getDays()
{
	$days = array(

  		0 => 'Sunday',
  		1 => 'Monday',
  		2 => 'Tuesday',
  		3 => 'Wednesday',
  		4 => 'Thursday',
  		5 => 'Friday',
  		6 => 'Saturday',

	);

	return $days;
}
?>