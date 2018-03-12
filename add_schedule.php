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
        margin: 0 5px;
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
                <input type="text" name="card_no" style="width: 150px;">
              </div>
              <div class="col-md-6">
                  <label>Subject Code</label>
                  <input type="text" name="subj_code">
              </div>
              <div class="col-md-6">
                  <label>Professor's Name</label>
                  <div class="dropdown styled-select slate" style="display: inline-block;">
                    <select name="day" style="width: 200px;">
                      <option>Engr. Julian Lorico</option>
                      <option>Engr. Julian Lorico</option>
                      <option>Engr. Julian Lorico</option>
                    </select>
                  </div>
              </div>
              <div class="col-md-6">
                  <label>Subject Name</label>
                  <input type="text" name="subj_name">
              </div>
              <div class="col-md-6">
                  <label>Day</label>
                  <div class="dropdown styled-select slate" style="display: inline-block;">
                      <select name="day">
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
                  <div class="dropdown styled-select slate" style="display: inline-block;">
                      <select style="width: 80px;">
                        <option>300</option>
                        <option>301</option>
                        <option>302</option>
                      </select>
                  </div>
              </div>
              <div class="col-md-6">
                  <label>Time Schedule</label>
                  <div class="dropdown styled-select slate" style="display: inline-block;">
                      <select name="form-day" style="width: 80px;">
                        <option>1:00</option>
                        <option>2:00</option>
                        <option>3:00</option>
                        <option>4:00</option>
                        <option>5:00</option>
                        <option>6:00</option>
                      </select>
                  </div>
                  <div class="dropdown styled-select slate" style="display: inline-block;">
                      <select name="form-day" style="width: 80px;">
                        <option>1:00</option>
                        <option>2:00</option>
                        <option>3:00</option>
                        <option>4:00</option>
                        <option>5:00</option>
                        <option>6:00</option>
                      </select>
                  </div>
                  <!-- Call Date Picker Here -->
              </div>
              <div class="col-md-12 buttons" style="margin-top: 40px; float: left;">
                  <button class="btn btn-primary">Save</button>
                  <button class="btn btn-warning">Cancel</button>
              </div>
          </div>
        </div>
</div>

<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

</body>
</html>