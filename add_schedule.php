<?php 


session_start();

require 'connect.php';
include 'constants.php';
include 'helper.php';

if(!isset($_SESSION[USER_LEVEL]))
{
    header('location: login.php');
}

$professorArr = array();

$profSQL = "SELECT ".PROFESSOR_ID.", ".PROFESSOR_FIRST_NAME.", ".PROFESSOR_LAST_NAME." FROM ".TBL_PROFESSOR." WHERE ".IS_ACTIVE." = 1";

$result = mysqli_query($con, $profSQL);

$option_professor = '';
while($row = mysqli_fetch_assoc($result))
{
  $professorArr[$row[PROFESSOR_ID]] = $row[PROFESSOR_FIRST_NAME].' '.$row[PROFESSOR_LAST_NAME]; 
  $option_professor .= '<option value='.$row[PROFESSOR_ID].'>'.$row[PROFESSOR_LAST_NAME].', '.$row[PROFESSOR_FIRST_NAME].'</option>';
}

$roomSQL = "SELECT * FROM ".TBL_ROOM_AVAILABILITY."";

$resultSet = mysqli_query($con, $roomSQL);
$option_rooms = '';
while($rowroom = mysqli_fetch_assoc($resultSet))
{
  $option_rooms .= '<option value='.$rowroom[ROOM_NUMBER].'>'.$rowroom[ROOM_NUMBER].'</option>';
}

?>


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
                <input type="text" name="card_no" id="card_no" readOnly="true" style="width: 150px;">
              </div>
              <div class="col-md-6">
                  <label>Subject Code</label>
                  <input type="text" name="subj_code">
              </div>
              <div class="col-md-6">
                  <label>Professor's Name</label>
                  <div class="dropdown styled-select slate" style="display: inline-block;">
                    <select id="option_professor" name="day" style="width: 200px;">
                      <option value="0">-----</option>
                      <?php echo ($option_professor != '' ? $option_professor : ''); ?>
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
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
                        <option value="6">Saturday</option>
                      </select>
                  </div>
              </div>
              <div class="col-md-6">
                  <label>Room No.</label>
                  <div class="dropdown styled-select slate" style="display: inline-block;">
                      <select style="width: 80px;">
                        <?php echo ($option_rooms != '' ? $option_rooms : '');?>
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
<script type="text/javascript">
  $(document).ready(function(){
    
    var base_url = "";

    var option_professor_value = $("#option_professor").val();

    $("#option_professor").on('change', function(){

      //ajax start
      $.ajax({  
              type: "POST",
              url: 'getUserCardNumber.php',
              data: {professor_id: option_professor_value},
              dataType:"json",
              success: function(response){
                $('#card_no').val(response);
              },
              error: function(xhr, textStatus, errorThrown){
               alert('request failed');
              }
          });
        //ajax end
        


    });
    
  });
</script>

</body>
</html>