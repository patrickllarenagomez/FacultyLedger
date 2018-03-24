<?php 


session_start();

require 'connect.php';
include 'constants.php';
include 'helper.php';

if(!isset($_SESSION[USER_LEVEL]))
{
    header('location: login.php');
}

$days = getDays();

//get 
$sched_id = $_GET['id'];

$retrieveSQL = "SELECT * FROM ".TBL_SCHEDULE." WHERE ".SCHEDULE_ID." = '$sched_id'";

$retrieveResult = mysqli_query($con,$retrieveSQL);

$resultArray = mysqli_fetch_assoc($retrieveResult);
// end get

//professor data
$professorArr = array();

$profSQL = "SELECT ".PROFESSOR_ID.", ".PROFESSOR_FIRST_NAME.", ".PROFESSOR_LAST_NAME." FROM ".TBL_PROFESSOR." WHERE ".IS_ACTIVE." = 1";

$result = mysqli_query($con, $profSQL);

$option_professor = '';
while($row = mysqli_fetch_assoc($result))
{
  $professorArr[$row[PROFESSOR_ID]] = $row[PROFESSOR_FIRST_NAME].' '.$row[PROFESSOR_LAST_NAME]; 
  $option_professor .= '<option '.(isset($resultArray[PROFESSOR_ID]) && $resultArray[PROFESSOR_ID] == $row[PROFESSOR_ID] ? 'selected="selected"' : '').' value='.$row[PROFESSOR_ID].'>'.$row[PROFESSOR_LAST_NAME].', '.$row[PROFESSOR_FIRST_NAME].'</option>';
}
//professor data end 

//get room data
$roomSQL = "SELECT * FROM ".TBL_ROOM_AVAILABILITY."";

$resultSet = mysqli_query($con, $roomSQL);
$option_rooms = '';
while($rowroom = mysqli_fetch_assoc($resultSet))
{
  $option_rooms .= '<option '.(isset($resultArray[ROOM_NUMBER]) && $resultArray[ROOM_NUMBER] == $rowroom[ROOM_NUMBER] ? 'selected="selected"' :'' ).' value='.$rowroom[ROOM_NUMBER].'>'.$rowroom[ROOM_NUMBER].'</option>';
}

//get room data end

$dayArr =  '<option '.(isset($resultArray[SCHEDULE_DAY]) && $resultArray[SCHEDULE_DAY] == '1' ? 'selected="selected"': '').'value="1">Monday</option>
           <option '.(isset($resultArray[SCHEDULE_DAY]) && $resultArray[SCHEDULE_DAY] == '2' ? 'selected="selected"': '').'value="2">Tuesday</option>
           <option '.(isset($resultArray[SCHEDULE_DAY]) && $resultArray[SCHEDULE_DAY] == '3' ? 'selected="selected"': '').'value="3">Wednesday</option>
           <option '.(isset($resultArray[SCHEDULE_DAY]) && $resultArray[SCHEDULE_DAY] == '4' ? 'selected="selected"': '').'value="4">Thursday</option>
           <option '.(isset($resultArray[SCHEDULE_DAY]) && $resultArray[SCHEDULE_DAY] == '5' ? 'selected="selected"': '').'value="5">Friday</option>
           <option '.(isset($resultArray[SCHEDULE_DAY]) && $resultArray[SCHEDULE_DAY] == '6' ? 'selected="selected"': '').'value="6">Saturday</option>
            <option '.(isset($resultArray[SCHEDULE_DAY]) && $resultArray[SCHEDULE_DAY] == '0' ? 'selected="selected"': '').'value="0">Sunday</option>';

if(isset($_POST['schedSubmitBtn']))
{
  $checker = true;

  $professor_id = $_POST['form-professor'];
  $schedule_day = $_POST['form-schedule-day'];
  $timein = $_POST['form-time-in'];
  $timeout = $_POST['form-time-out'];
  $subject_code = $_POST['form-subject-code'];
  $subject_name = $_POST['form-subject-name'];
  $room_number = $_POST['form-room-number'];

$searchSQL = "SELECT ".SCHEDULE_TIME_IN.", ".SCHEDULE_TIME_OUT.", ".ROOM_NUMBER.", ".SCHEDULE_DAY." FROM ".TBL_SCHEDULE." WHERE ".PROFESSOR_ID." = '$professor_id' AND ".IS_ACTIVE." = ".ACTIVE." AND ".SCHEDULE_DAY." = '$schedule_day'";

  $resultSQL = mysqli_query($con,$searchSQL);

  while($currentSched = mysqli_fetch_assoc($resultSQL))
  {
    if(strtotime($timein) <= strtotime($currentSched[SCHEDULE_TIME_IN]) && strtotime($timeout) >= strtotime($currentSched[SCHEDULE_TIME_OUT]))
    {
    $_SESSION["add_schedule_error"] = "<div class='alert alert-danger alert-dismissible'>
    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
    <strong>Error:</strong> Conflict on Professor <strong>".$professorArr[$professor_id]."'s</strong> current schedule. Day is:<strong>".$days[$currentSched[SCHEDULE_DAY]]."</strong>. Conflict time is: <strong>".date("h:i:s a", strtotime($currentSched[SCHEDULE_TIME_IN]))." - ".date("h:i:s a", strtotime($currentSched[SCHEDULE_TIME_OUT]))." </strong>. Room Number is <strong>".$currentSched[ROOM_NUMBER]."</strong>.
    </div>";
    $checker = false;
      break;
    }
  }

  if(strtotime($timein) == strtotime($timeout))
  {
    $_SESSION['add_schedule_error'] = "<div class='alert alert-danger alert-dismissible'>
    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
    <strong>Error: Time In and Time Out cannot be the same.</strong> 
    </div>";
    $checker = false;
  }

  if($professor_id == 0)
  {
    $_SESSION['add_schedule_error'] = "<div class='alert alert-danger alert-dismissible'>
    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
    <strong>Error: Professor cannot be null.</strong> 
    </div>";
    $checker = false;
  }

  if(strtotime($timein) > strtotime($timeout))
  {
    $_SESSION['add_schedule_error'] = "<div class='alert alert-danger alert-dismissible'>
    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
    <strong>Error: Time In should be earlier than Time Out!</strong> 
    </div>";
    $checker = false;
  }
  if($checker == true)
  {

      $_SESSION['edit_schedule_success'] = "<div class='alert alert-success alert-dismissible'>
      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
      <strong>Schedule was updated successfully!</strong> 
      </div>";

      $updateSQL = "UPDATE ".TBL_SCHEDULE." SET
      ".PROFESSOR_ID." = '$professor_id', ".SUBJECT_CODE." = '$subject_code', ".SUBJECT_NAME." = '$subject_name', ".ROOM_NUMBER." = '$room_number', ".SCHEDULE_DAY." = '$schedule_day', ".SCHEDULE_TIME_IN." = '$timein', ".SCHEDULE_TIME_OUT." = '$timeout' WHERE ".SCHEDULE_ID." = '$sched_id'";
      mysqli_query($con, $updateSQL);

      header("location: schedule.php");
  }
}
if(isset($_POST['cancelBtn']))
{
  header("location: schedule.php");
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

<?php include 'headerAndSidebar.php';?>

<div class="dash_page">
    <h1 class="page-header">Edit Schedule</h1>
    <?php 

      echo isset($_SESSION['add_schedule_error']) ? $_SESSION['add_schedule_error'] : '';

      if(isset($_SESSION['add_schedule_error']))
        unset($_SESSION['add_schedule_error']);  


    ?>
        <div class="container" style="width: 1000px;">
          <form action="" method="POST">
          <div class="col-md-12 form-group">
              <div class="col-md-6">
                <label>Card No.</label>
                <input type="text" name="card_no" id="card_no" readOnly="true" style="width: 150px;">
              </div>
              <div class="col-md-6">
                  <label>Subject Code</label>
                  <input type="text" name="form-subject-code" value="<?php echo isset($resultArray[SUBJECT_CODE]) ? $resultArray[SUBJECT_CODE] : '' ?>">
              </div>
              <div class="col-md-6">
                  <label>Professor's Name</label>
                  <div class="dropdown styled-select slate" style="display: inline-block;">
                    <select id="option_professor" name="form-professor" style="width: 200px;">
                      <option value="0">-----</option>
                      <?php echo ($option_professor != '' ? $option_professor : ''); ?>
                    </select>
                  </div>
              </div>
              <div class="col-md-6">
                  <label>Subject Name</label>
                  <input type="text" name="form-subject-name" value="<?php echo isset($resultArray[SUBJECT_NAME]) ? $resultArray[SUBJECT_NAME] : '' ?>">
              </div>
              <div class="col-md-6">
                  <label>Day</label>
                  <div class="dropdown styled-select slate" style="display: inline-block;">
                      <select id="option_day" name="form-schedule-day">
                          <?php echo $dayArr;?>
                      </select>
                  </div>
              </div>
              <div class="col-md-6">
                  <label>Room No.</label>
                  <div class="dropdown styled-select slate" style="display: inline-block;">
                      <select style="width: 80px;" name="form-room-number" id="option_room_number">
                        <?php echo ($option_rooms != '' ? $option_rooms : '');?>
                      </select>
                  </div>
              </div>
              <div class="col-md-6">
                  <label>Time Schedule</label>
                  <div class="dropdown styled-select slate" style="display: inline-block;">
                      <select name="form-time-in" id="option_schedule_in" style="width: 130px;">
                        
                      </select>
                  </div>
                  <div class="dropdown styled-select slate" style="display: inline-block;">
                      <select name="form-time-out" id="option_schedule_out" style="width: 130px;">

                      </select>
                  </div>
              </div>
              <div class="col-md-12 buttons" style="margin-top: 40px; float: left;">
                  <button name="schedSubmitBtn" class="btn btn-primary">Update</button>
                  <button name="cancelBtn" class="btn btn-warning">Cancel</button>
              </div>
          </form>

          </div>
        </div>
</div>

<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    
    //if editing

    var editTimeIn = "<?php echo $resultArray[SCHEDULE_TIME_IN];?>";
    var editTimeOut = "<?php echo $resultArray[SCHEDULE_TIME_OUT];?>";
    var editTimeInText = "<?php echo date('h:i:s A',strtotime($resultArray[SCHEDULE_TIME_IN]));?>"    
    var editTimeOutText = "<?php echo date('h:i:s A',strtotime($resultArray[SCHEDULE_TIME_OUT]));?>"


    


    //if editing end


    var base_url = "";
    var option_professor_value;
    var option_day_value;
    var option_room_number_value;
    
    option_professor_value = $("#option_professor").val();
    $.ajax({
              type: "POST",
              url: 'getUserCardNumber.php',
              data: {professor_id: option_professor_value},
              dataType:"json",
              success: function(response)
              {
                $('#card_no').val(response["serial_number"]);
              }
          });

    option_room_number_value = $("#option_room_number").val();
    option_day_value = $("#option_day").val();
    $.ajax({

        type: "POST",
        url: 'getAllSchedules.php',
        data : {day : option_day_value, room_number : option_room_number_value},
        dataType: "json",
        success: function(response)
        {
          populateTimeSchedules(response);
        }
      });


    $("#option_professor").on('change', function(){
      option_professor_value = $("#option_professor").val();
      option_room_number_value = $("#option_room_number").val();
      option_day_value = $("#option_day").val();
      //ajax start
      $.ajax({
              type: "POST",
              url: 'getUserCardNumber.php',
              data: {professor_id: option_professor_value},
              dataType:"json",
              success: function(response)
              {
                $('#card_no').val(response["serial_number"]);
              }
          });

      $.ajax({

        type: "POST",
        url: 'getAllSchedules.php',
        data : {day : option_day_value, 
                room_number : option_room_number_value,
                professor_id : option_professor_value},
        dataType: "json",
        success: function(response)
        {
            populateTimeSchedules(response);
        }
      });


        //ajax end
    });

    $("#option_day").on('change', function(){

      option_room_number_value = $("#option_room_number").val();
      option_day_value = $("#option_day").val();
      option_professor_value = $("#option_professor").val();
      $.ajax({

        type: "POST",
        url: 'getAllSchedules.php',
        data : {day : option_day_value, 
                room_number : option_room_number_value,
                professor_id : option_professor_value},
        dataType: "json",
        success: function(response)
        {
            populateTimeSchedules(response);
        }
      });
    });


    $("#option_room_number").on('change', function(){

      option_room_number_value = $("#option_room_number").val();
      option_day_value = $("#option_day").val();
      option_professor_value = $("#option_professor").val();
      $.ajax({

        type: "POST",
        url: 'getAllSchedules.php',
        data : {day : option_day_value, 
                room_number : option_room_number_value,
                professor_id : option_professor_value},
        dataType: "json",
        success: function(response)
        {
          populateTimeSchedules(response);
        }
      });

    });
    
    function populateTimeSchedules(response)
    {
            var isFirst = true;
            var schedtimeout = '';
            var schedtimein = '';

            $.each(response, function(index,value){   
                schedtimein+= '<option value="'+index+'">'+value+'</option>';
            }); 
           $('#option_schedule_in').html(schedtimein);  


            $.each(response, function(index,value){   
                if(!isFirst)
                  schedtimeout+= '<option value="'+index+'">'+value+'</option>';
                isFirst = false; 
            }); 
           $('#option_schedule_out').html(schedtimeout);

           //for editing
          if(editTimeIn && editTimeOut)
          {
            $("#option_schedule_in").append($('<option>', {
              value: editTimeIn,
              text: editTimeInText,
              selected: true
            }));
      
            $("#option_schedule_out").append($('<option>', {
              value: editTimeOut,
              text: editTimeOutText,
              selected: true
            }));
          }
          //for editing ends
    }

    


  });//document ready end
</script>
</body>
</html>