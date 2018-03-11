<!DOCTYPE html>
<html lang="en">
<head>
<title>Class Schedule</title>

<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css"></link>
<style type="text/css">
    th {
        font-weight: bold;
    }
    input {
        border-radius: 3px;
        border: 2px solid gray;
        padding: 5px;
        background: rgba(255,255,255,0.5);
    }
    .styled-select.slate select {
        font-size: 16px;
        width: 130px;
        border-radius: 3px;
        border: 2px solid gray;
        padding: 5px;
        background: rgba(255,255,255,0.5);
    }

</style>

<?php include 'headSettings.php';?>
</head>
<body>

<?php include 'headerAndSideBar.php';?>

<div class="dash_page">
    <h1 class="page-header">Add Schedule</h1>
        <div class="container" style="width: 1000px;">
                <table id="table-schedule" class="display" cellspacing="0" width="100%">
                   <thead>
                        <tr>
                            <th>No.</th>
                            <th>Professor</th>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Room No.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <th><input type="text" name="card_no" style="width: 90px; margin-right: 10px;"></th>
                        <th><input type="text" name="prof" style="width: 150px; margin-right: 10px;"></th>
                        <th><input type="text" name="subj_code" style="width: 150px; margin-right: 10px;"></th>
                        <th><input type="text" name="subj_name" style="width: 150px; margin-right: 10px;"></th>
                        <th>
                            <div class="dropdown styled-select slate" style="margin-right: 10px;">
                              <select>
                                <option>Monday</option>
                                <option>Tuesday</option>
                                <option>Wednesday</option>
                                <option>Thursday</option>
                                <option>Friday</option>
                                <option>Saturday</option>
                              </select>
                            </div>
                        </th>
                        <th><input name="time" style="width: 150px; margin-right: 10px;"></th>
                        <th><input type="number" name="room" min="1" max="3" style="width: 70px; margin-right: 10px;"></th>
                    </tbody>
                </table>
        </div>
</div>

<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

</body>
</html>