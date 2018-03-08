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

?>