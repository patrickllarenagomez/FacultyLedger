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

$searchSQL = "SELECT * FROM ".TBL_TIME_LOG." ORDER BY ".TIME_LOG_ID." DESC";

$dataresult = mysqli_query($con, $searchSQL);

$tableData = '';
$no = 1;

while($rows = mysqli_fetch_assoc($dataresult))
{
    $tableData .= '<tr>
    <td>'.$no.'</td>
    <td>'.$professor_names[$rows[PROFESSOR_ID]].'</td>
    <td>'.$rows[TIME_LOG_DATE].'</td>
    <td>'.date('h:i:s a', strtotime($rows[TIME_LOG_IN])).'</td>
    <td>'.(($rows[TIME_LOG_OUT] != "00:00:00") ? date('h:i:s a', strtotime($rows[TIME_LOG_OUT])) : NONE).'</td>
    <td>'.'ROOM '.$rows[ROOM_NUMBER].'</td>
    <td>'.($rows[IS_LATE] == 1 ? LATE : ONTIME).'</td>
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
    $(document).ready(function(){
        var startDate;
        var endDate;

        $("#table-log").DataTable();

        $('.daterange').daterangepicker();

        $('#btn-generate-pdf').click(function(){

           startDate = $('.daterange').data('daterangepicker').startDate.format("YYYY-MM-DD");
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

<?php include 'headerAndSideBar.php';?>


<div class="dash_page">
    <h1 class="page-header">Attendance Log</h1>
        <?php echo isset($_SESSION['generate_PDF']) ? $_SESSION['generate_PDF'] : "";
        
        if(isset($_SESSION['generate_PDF']))
            unset($_SESSION['generate_PDF']);
    ?>
        <div class="container" style="width: 900px;">

            <div id="datepicker" style="float: left; margin-bottom: 20px;">
                        Select Start and End Date <input type='text' class="form-control daterange" id='datepicker'>
            </div>
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