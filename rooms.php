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

    .legend {
        height: 25px;
        width: 25px;
    }

    .legend, .rooms, .prof {
        display: inline-block;
        vertical-align: baseline;
        margin-top: 25px;
        margin-left: 10px;
    }

    .prof {
        position: relative;
    }

    .col-md-9 {
        background-color: #d6d6c2; 
        height: 350px; 
        width: 700px; 
        border-radius: 5px;
    }

    h3 {
        display: inline-block;
        vertical-align: baseline;
        margin-left: 150px;
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

<?php include 'headerAndSideBar.php';?>

<div class="dash_page">
    <h1 class="page-header">Room Slot</h1>
        <div class="container" style="width: 1000px;">
            <div class="col-md-3" style="margin-top: 100px;">
                <h2>Legend: </h2> <br>
                <div class="square" style="background-color: #66ff99;"></div>
                <label>Still Available</label>
                <br>
                <div class="square" style="background-color: #ff3333;"></div>
                <label>Not Available</label>
            </div>
            <div class="row">
                <h3 style="margin-left: 40px;">List of Rooms</h3>
                <h3>Professor</h3>
            </div>
            <div class="col-md-9">
                <div class="col-md-4">
                    <div class="legend" style="background-color: #66ff99;"></div>
                    <label class="rooms">Room 101</label><br>
                    <div class="legend" style="background-color: #ff3333;"></div>
                    <label class="rooms">Room 102</label><br>
                    <div class="legend" style="background-color: #ff3333;"></div>
                    <label class="rooms">Room 103</label><br>
                </div>
                <div class="col-md-4">
                    <label class="prof">Engr. Julian Lorico</label><br>
                    <label class="prof">Engr. Julian Lorico</label><br>
                    <label class="prof">Engr. Julian Lorico</label>
                </div>
            </div>
        </div>
</div>

<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

</body>
</html>