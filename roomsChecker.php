<?php 

session_start();

require 'connect.php';
include 'constants.php';
include 'helper.php';


if(!isset($_SESSION[USER_LEVEL]))
{
  header('location:login.php');  
}

?>


<!DOCTYPE html>
<html lang="en">
<head>

<title>Room Slot</title>

<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css"></link>
<style type="text/css">
    .square {
      height: 30px;
      width: 30px;
    }

    label {
      float: right;
      margin-top: -25px;
      margin-left: 50px;
      font-size: 18px;
      position: absolute;
    }

</style>

<?php include 'headSettings.php';?>
</head>
<body>

<?php include 'checkerHeaderAndSideBar.php';?>

<div class="dash_page">
    <h1 class="page-header">Room Slot</h1>
        <div class="container" style="width: 1000px;">
            <div class="col-md-3">
                <h3>Legend: </h3> <br>
                <div class="square" style="background-color: #66ff99;"></div>
                <label>Still Available</label>
                <br>
                <div class="square" style="background-color: #ff3333;"></div>
                <label>Not Available</label>
            </div>
        </div>
</div>

<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

</body>
</html>