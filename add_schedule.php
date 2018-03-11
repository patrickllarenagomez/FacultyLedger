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
    .col-md-6 {
        margin: 10px 0px;
    }
    label, input {
    display: inline-block;
    vertical-align: baseline;
    width: 170px;
    }

    label {
        color: #2D2D2D;
        font-size: 15px;
    }

    .form-group, input {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
    }

    .btn {
        margin: 0 3px;
    }

</style>

<?php include 'headSettings.php';?>
</head>
<body>

<?php include 'headerAndSideBar.php';?>

<div class="dash_page">
    <h1 class="page-header">Add Schedule</h1>
        <div class="container" style="width: 1000px;">
          <div class="col-md-12 form-group">
              <div class="col-md-6">
                <label>Card No.</label>
                <input type="text" name="card_no" style="width: 100px;">
              </div>
              <div class="col-md-6">
                  <label>Professor's Name</label>
                  <input type="text" name="prof">
              </div>
              <div class="col-md-6">
                  <label>Subject Code</label>
                  <input type="text" name="subj_code">
              </div>
              <div class="col-md-6">
                  <label>Subject Name</label>
                  <input type="text" name="subj_name">
              </div>
              <div class="col-md-6">
                  <label>Day</label>
                  <div class="dropdown styled-select slate" style="display: inline-block;">
                      <select>
                        <option>Monday</option>
                        <option>Tuesday</option>
                        <option>Wednesday</option>
                        <option>Thursday</option>
                        <option>Friday</option>
                        <option>Saturday</option>
                      </select>
                  </div>
              </div>
              <div class="col-md-6">
                  <label>Room No.</label>
                  <input type="number" name="prof" min="1" max="3" style="width: 70px">
              </div>
              <div class="col-md-6">
                  <label>Time Schedule</label>
                  <input name="start_time" style="width: 70px;">
                  <input name="end_time" style="width: 70px;">
                  <!-- Call Date Picker Here -->
              </div>
              <div class="col-md-6 buttons">
                  <button class="btn btn-primary">Save</button>
                  <button class="btn btn-warning">Cancel</button>
              </div>
          </div>
                <!-- <table id="table-schedule" class="display" cellspacing="0" width="100%">
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
                </table> -->
        </div>
</div>

<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

</body>
</html>