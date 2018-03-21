<?php 

session_start();

require 'connect.php';
include 'constants.php';
include 'helper.php';

if(!isset($_SESSION[USER_LEVEL]))
{
  header('location: login.php');
}

$getProfessorNames = "SELECT ".PROFESSOR_ID.",".PROFESSOR_FIRST_NAME.", 
".PROFESSOR_LAST_NAME." FROM ".TBL_PROFESSOR." WHERE ".IS_ACTIVE." = 1";

$result = mysqli_query($con, $getProfessorNames);
$professor_names = array();

while($row = mysqli_fetch_assoc($result))
{
    $professor_names[$row[PROFESSOR_ID]] = $row[PROFESSOR_FIRST_NAME].' '.$row[PROFESSOR_LAST_NAME];
}

$retrieveSQL = "SELECT * FROM ".TBL_ROOM_AVAILABILITY."";

$roomavail = mysqli_query($con, $retrieveSQL);
$dataList = '';
while($row = mysqli_fetch_assoc($roomavail))
{
    //#66ff99 green
    //#ff3333 red
    $dataList .= '<tr>
        <td><div class="legend" style="background-color:'.($row[IS_AVAILABLE] == 1 ? "#66ff99" :  "#ff3333").'"></div></td>
        <td>Room '.(isset($row[ROOM_NUMBER]) ? $row[ROOM_NUMBER] : '').'</td>
        <td>'.($row[PROFESSOR_ID] != 0 ? $professor_names[$row[PROFESSOR_ID]] : '-' ).'</td>
    </tr>';
    
}

'<tr>
        <td><div class="legend" style="background-color:'.($row[IS_AVAILABLE] == 1 ? "#66ff99" :  "#ff3333").'"></div></td>
        <td>Room '.(isset($row[ROOM_NUMBER]) ? $row[ROOM_NUMBER] : '').'</td>
        <td>'.($row[PROFESSOR_ID] != 0 ? $professor_names[$row[PROFESSOR_ID]] : '-' ).'</td>
    </tr>';
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

    .legend {
        height: 25px;
        width: 25px;
    }

    .legend, .rooms {
        display: inline-block;
        vertical-align: baseline;
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

    th 
    {
        font-size:18px;
    }

</style>

<?php include 'headSettings.php';?>
</head>
<body>

<?php include 'headerAndSidebar.php';?> 

<div class="dash_page">
    <h1 class="page-header">Room Slot</h1>
        <div class="container" style="width: 1000px;">
            <div class="col-md-3" style="margin-top: 50px;">
                <h2>Legend: </h2> <br>
                <div class="square" style="background-color: #66ff99;"></div>
                <label>Available</label>
                <br>
                <div class="square" style="background-color: #ff3333;"></div>
                <label>Not Available</label>
            </div>
            <div class="col-md-9">
                <table class="table table-responsive">
                    <tr>
                        <th>Status</th>
                        <th>Room</th>
                        <th>Professor</th>
                    </tr>
                    <?php echo $dataList;?>
                </table>
            </div>
        </div>
</div>

<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

</body>
</html>