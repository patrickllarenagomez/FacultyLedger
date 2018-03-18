<?php 

session_start();
require 'connect.php';
include 'constants.php';
include 'helper.php';

if(isset($_POST))
{
	$startDate =  $_POST["startDT"];
	$endDate = $_POST["endDT"];
}

//professor data start
$professorArr = array();

$profSQL = "SELECT ".PROFESSOR_ID." FROM ".TBL_PROFESSOR." WHERE ".IS_ACTIVE." = 1";

$result = mysqli_query($con, $profSQL);

while($row = mysqli_fetch_assoc($result))
{
	array_push($professorArr, $row[PROFESSOR_ID]);
}

$professorData = implode(",", $professorArr); 
// professor data code end

//professor schedule start

$scheduleSQL = "SELECT ".PROFESSOR_ID.", "."COUNT(*)"." as ".SCHEDULE_COUNT." FROM ".TBL_SCHEDULE." WHERE ".PROFESSOR_ID." IN (".$professorData.") AND ".IS_ACTIVE." = 1 GROUP BY ".PROFESSOR_ID."";
$schedules = mysqli_query($con, $scheduleSQL);


while($rowData = mysqli_fetch_assoc($schedules))
{
	$scheduleArray[$rowData[PROFESSOR_ID]] = $rowData[SCHEDULE_COUNT];
}

//professor schedule code end


$generateSQL = "SELECT ".PROFESSOR_ID.","."SUM(".IS_LATE.") as ".IS_LATE."".", "."COUNT(case when ".IS_VALID." = '0' then 1 else null end)"." as ".INVALIDLOG.", "."COUNT(*)"." as ".ROWS." FROM ".TBL_TIME_LOG." WHERE ".PROFESSOR_ID." IN (".$professorData.") AND ".TIME_LOG_DATE." BETWEEN '$startDate' AND '$endDate' GROUP BY ".PROFESSOR_ID."";

$generateResults = mysqli_query($con, $generateSQL);


$professorDataArr = array();
while($rows = mysqli_fetch_assoc($generateResults))
{	
	$professorDataArr[$rows[PROFESSOR_ID]] = array(

		IS_LATE => $rows[IS_LATE],
		INVALIDLOG => $rows[INVALIDLOG],
		ROWS => $rows[ROWS],
		SCHEDULE_COUNT => $scheduleArray[$rows[PROFESSOR_ID]]
	);

}

//showarray($professorDataArr);

$_SESSION['generate_PDF'] = "<div class='alert alert-success alert-dismissible'>
		  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
		  <strong>Report was generated successfully!</strong> 
		</div>";

// header("location: attendance.php");



?>

<?php 
	require_once '/vendor/autoload.php';
	include('mpdf/mpdf.php');

//for CRON only
// $monthStart = new DateTime("first day of this month");
// $monthEnd = new DateTime("last day of this month");
// $MS = $monthStart->format('M d, Y');
// $ME = $monthEnd->format('M d, Y');



$html = '<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/styles1.min.css">
	</head>
	<body>
		<div id="main">
			<div id="">
				<div id="">
					<div id="">
						<div class="" style="width:900px; margin:0 auto;">
						<span style="text-align:center;"><img  src="images/banner-pcu.png"></a></span>
					</div>
				</div>
			</div>
			<div id="main_info">
				<div id="main_body" class="align_left" style="width:1024px;">
					<div class="body_title">
						<span class="red_text"><h2>Attendance Report</h2></span>
						<hr>
					</div>

					<div id="">
						<table style="width:100%;">
							<tr>
								<td style="width:50%;">
									<span>Date:</span><br>
									<span class="strongText"><b>'.$MS ." - ".$ME.'</b></span>
								</td>
								<td style="width:50%;" class="text_right">&nbsp;</td>
							</tr>
							<tr>
								<td style="width:50%;">
									<span>Total Number of Active Professors:</span><br>
									<span class="strongTextCommission">''</span>
								</td>
								<td style="width:50%;">
									<span>Total Number of Lates:</span><br>
									<span class="strongTextCommission"></span>
								</td>
							</tr>
							<tr>
								<td style="width:50%;">
									<span>Total Number of Absences:</span><br>
									<span class="strongText"></span>
								</td>

							<tr>
								<td style="width:50%;">
									<span><b>Total No:</b></span><br>
									<span class="strongText"></span>
								</td>
							</tr>
						</table>
					</div>

					 <table class="table table-responsive" border=1 width="100%">
						<tr>
							<th style="text-align: center">No</th>
							<th style="text-align: center">Name</th>
							<th style="text-align: center">Attendance</th>
							<th style="text-align: center">On Time</th>
							<th style="text-align: center">Late</th>
							<th style="text-align: center">Invalid</th>
							<th style="text-align: center">Absences</th>
						</tr>
						<tr>
							<td style="text-align:center">Amount</td>
							<td style="text-align:center">Count</td>
							<td style="text-align:center">Amount</td>
							<td style="text-align:center">Percentage</td>
							<td style="text-align:center">Count</td>
							<td style="text-align:center">Percentage</td>
							<td style="text-align:center">Amount</td>
						</tr>
	
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>
	<!-- END -->
</html>';























	// MPDF
	$mpdf = new mPDF('UTF-8', 'A4-L', 0, '', 10, 10, 10, 10);	
	$mpdf->WriteHTML($html,2);

	$fileName = date('M d, Y',strtotime($startDate)).' - '.date('M d, Y',strtotime($endDate)).' Attendance Report.pdf';
	$path = 'PDF/'.$fileName;

	//storing it
	//$mpdf->Output($path, 'F');
	
	//viewing
	$mpdf->Output($fileName, 'I');
 header("location: attendance.php");

?>