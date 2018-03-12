<?php 

session_start();

require 'connect.php';
include 'constants.php';
include 'helper.php';

if(!isset($_SESSION[USER_LEVEL]))
{
    header('location: login.php');
}

$getProfessorNames = "SELECT ".PROFESSOR_ID.",".PROFESSOR_FIRST_NAME.", ".PROFESSOR_LAST_NAME." FROM ".TBL_PROFESSOR." WHERE ".IS_ACTIVE." = 1";

$result = mysqli_query($con, $getProfessorNames);
$professor_names = array();

while($row = mysqli_fetch_assoc($result))
{
    $professor_names[$row[PROFESSOR_ID]] = $row[PROFESSOR_FIRST_NAME].' '.$row[PROFESSOR_LAST_NAME];
}

$searchSQL = "SELECT * FROM ".TBL_SCHEDULE." ORDER BY ".SCHEDULE_ID." DESC";

$dataresult = mysqli_query($con, $searchSQL);

$tableData = '';
$no = 1;

$days = array(
    
    0 => 'Sunday',
    1 => 'Monday',
    2 => 'Tuesday',
    3 => 'Wednesday',
    4 => 'Thursday',
    5 => 'Friday',
    6 => 'Saturday',
    
    );

while($rows = mysqli_fetch_assoc($dataresult))
{

    $tableData .= '<tr>
    <td>'.$no.'</td>
    <td>'.$professor_names[$rows[PROFESSOR_ID]].'</td>
    <td>'.$rows[SUBJECT_CODE].'</td>
    <td>'.$rows[SUBJECT_NAME].'</td>
    <td>'.$days[$rows[SCHEDULE_DAY]].'</td>
    <td>'.$rows[SCHEDULE_TIME_IN].' - '.$rows[SCHEDULE_TIME_OUT].'</td>
    <td>'.$rows[ROOM_NUMBER].'</td>
    </tr>';
    $no++;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Class Schedule</title>


<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css"></link>

<script type="text/javascript">

    $(document).ready(function() {
        $('#table-schedule').DataTable();
    });

    function activate(id)
    {
        if(confirm("Make schedule active?"))
            location.href = "activateSchedule.php?id=" + id;
    }

    function deactivate(id)
    {
        if(confirm("Deactivate schedule?"))
            location.href = "deactivateSchedule.php?id=" + id;
    }

</script>


<style type="text/css">
    th {
        font-weight: bold;
    }
    .btn {
        margin-right: 3px;
    }
</style>



<?php include 'headSettings.php';?>
</head>
<body>

<?php include 'headerAndSideBar.php';?>


<div class="dash_page">
    <h1 class="page-header">Schedule</h2>

    <?php echo isset($_SESSION['edit_schedule_success']) ? $_SESSION['edit_schedule_success'] : "";

        if(isset($_SESSION['edit_schedule_success']))
            unset($_SESSION['edit_schedule_success']);

    ?>

        <div class="container" style="width: 1000px;">
            <div class="col-lg-12">
                <div class="buttons" style="float: right; margin-bottom: 15px;">
                    <a href="add_schedule.php"><button class="btn btn-primary">Add</button></a>
                </div>
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
                        <?php echo isset($tableData) ? $tableData : '' ;?>
                    </tbody>
                </table>
            </div>
        </div>

<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

</body>
</html>