<?php 

session_start();

require 'connect.php';
include 'constants.php';
include 'helper.php';

if(!isset($_SESSION[USER_LEVEL]))
{
    header('location: login.php');
}

$getProfessorNames = "SELECT ".PROFESSOR_ID.",".PROFESSOR_FIRST_NAME.", ".PROFESSOR_LAST_NAME." FROM ".TBL_PROFESSOR."";

$result = mysqli_query($con, $getProfessorNames);

$professor_names = array();

while($row = mysqli_fetch_assoc($result))
{
    $professor_names[$row[PROFESSOR_ID]] = $row[PROFESSOR_FIRST_NAME].' '.$row[PROFESSOR_LAST_NAME];
}

$searchSQL = "SELECT * FROM ".TBL_TIME_LOG." WHERE ".IS_ACTIVE." = ".ACTIVE." ORDER BY ".TIME_LOG_ID." DESC";

$dataresult = mysqli_query($con, $searchSQL);

$tableData = '';
$no = 1;

while($rows = mysqli_fetch_assoc($dataresult))
{
    if($_SESSION[USER_LEVEL] == ADMIN)
    {
        $is_active ='<td><a><span style="cursor:pointer" onclick="deactivate('.$rows[TIME_LOG_ID].')" title="Delete" class="fa fa-close"></span></a></td>';
    }

    $tableData .= '<tr>
    <td>'.$no.'</td>
    <td>'.$professor_names[$rows[PROFESSOR_ID]].'</td>
    <td>'.$rows[TIME_LOG_DATE].'</td>
    <td>'.date('h:i:s a', strtotime($rows[TIME_LOG_IN])).'</td>
    <td>'.(($rows[TIME_LOG_OUT] != "00:00:00") ? date('h:i:s a', strtotime($rows[TIME_LOG_OUT])) : NONE).'</td>
    <td>'.'ROOM '.$rows[ROOM_NUMBER].'</td>
    <td>'.($rows[IS_LATE] == 1 ? LATE : ONTIME).'</td>
    '.$is_active.'
    </tr>';
    $no++;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Attendance Log Sheet</title>

<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css"></link>


  <script src="js/jquery-ui.js"></script>
<script type="text/javascript"> 
    function deactivate(id)
    {
            if(confirm("Delete log? This is irrevocable."))
                location.href = "deactivateLog.php?id=" + id;
    }

    $(document).ready(function(){
        var startDate;
        var endDate;



        $("#table-log").DataTable();

        $('.daterange').daterangepicker({
            locale:
            {
                format: 'YYYY-MM-DD'
            },
            startDate: "<?php echo date('Y-m-01');?>",
            endDate: "<?php echo date('Y-m-d');?>"
        }
        );

        $('#btn-generate-pdf').click(function(){

           startDate = $('.daterange').data('daterangepicker').startDate.format("YYYY-MM-01");
           endDate =  $('.daterange').data('daterangepicker').endDate.format("YYYY-MM-DD");

        });

        $("#btn-generate-pdf").click(function(){

            $("#startDT").val(startDate);
            $("#endDT").val(endDate);
            $("#thisSubmit").submit();
        });
        



    });

</script>

<script type="text/javascript" src="js/moment.min.js"></script>
<script type="text/javascript" src="js/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="css/daterangepicker.css" />

<?php include 'headSettings.php';?>

</head>
<body>

<?php include 'headerAndSidebar.php';?> 


<div class="dash_page">
    <h1 class="page-header">Attendance Log</h1>
        <?php echo isset($_SESSION['generate_PDF']) ? $_SESSION['generate_PDF'] : "";
        
        if(isset($_SESSION['generate_PDF']))
            unset($_SESSION['generate_PDF']);

        echo isset($_SESSION['add_attendance_success']) ? $_SESSION['add_attendance_success'] : "";

        if(isset($_SESSION['add_attendance_success']))
            unset($_SESSION['add_attendance_success']); 

        echo isset($_SESSION['attendance_success_delete']) ? $_SESSION['attendance_success_delete'] : "";

        if(isset($_SESSION['attendance_success_delete']))
            unset($_SESSION['attendance_success_delete']);
    ?>
        <div class="container" style="width: 900px;">

            <div id="datepicker" style="float: left; margin-bottom: 20px;">
                        Select Start and End Date <input type='text' class="form-control daterange" id='datepicker'>
            </div>
            <?php if($_SESSION[USER_LEVEL] == ADMIN){ 
                $forAdmin ='<div class="buttons" style="float: right; margin-bottom: 15px;">
                    <a href="add_timelog.php"><button class="btn btn-primary">Add</button></a>
                </div>';

                echo $forAdmin;
            }
            ?>

            <button id="btn-generate-pdf" class="btn btn-primary" style="margin: 20px 0px 0px 15px">Generate PDF</button>
            <table id="table-log" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Professor</th>
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Room No.</th>
                        <th>Status</th>
                        <?php 

                        if($_SESSION[USER_LEVEL] == ADMIN)
                            echo '<th></th>';
                        ?>
                    </tr>
                </thead>
                <tbody>
                        <?php echo isset($tableData) ? $tableData : "";?>
                </tbody>
            </table>
        </div>
</div>

<form id="thisSubmit" method="POST" action="generateReport.php">
<input type="hidden" name="startDT" id="startDT" value="">
<input type="hidden" name="endDT" id="endDT" value="">
</form>

<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

</body>
</html>