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

$profNameSQL = "SELECT ".PROFESSOR_FIRST_NAME.",".PROFESSOR_LAST_NAME.", ".PROFESSOR_ID." FROM ".TBL_PROFESSOR." WHERE ".IS_ACTIVE." = 1";
$profname = mysqli_query($con, $profNameSQL);
$profNameArr = array();
while($rowProf = mysqli_fetch_assoc($profname))
{
	$profNameArr[$rowProf[PROFESSOR_ID]] = $rowProf[PROFESSOR_LAST_NAME].', '.$rowProf[PROFESSOR_FIRST_NAME];
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

$scheduleSQL = "SELECT ".PROFESSOR_ID.", 

"."COUNT(case when ".SCHEDULE_DAY." = '0' then 1 else null end)"." as ".SCHEDULE_COUNT_SUNDAY.", 
"."COUNT(case when ".SCHEDULE_DAY." = '1' then 1 else null end)"." as ".SCHEDULE_COUNT_MONDAY.", 
"."COUNT(case when ".SCHEDULE_DAY." = '2' then 1 else null end)"." as ".SCHEDULE_COUNT_TUESDAY.", 
"."COUNT(case when ".SCHEDULE_DAY." = '3' then 1 else null end)"." as ".SCHEDULE_COUNT_WEDNESDAY.", 
"."COUNT(case when ".SCHEDULE_DAY." = '4' then 1 else null end)"." as ".SCHEDULE_COUNT_THURSDAY.", 
"."COUNT(case when ".SCHEDULE_DAY." = '5' then 1 else null end)"." as ".SCHEDULE_COUNT_FRIDAY.", 
"."COUNT(case when ".SCHEDULE_DAY." = '6' then 1 else null end)"." as ".SCHEDULE_COUNT_SATURDAY.",
"."COUNT(*) as ".SCHEDULE_COUNT." 

FROM ".TBL_SCHEDULE." WHERE ".PROFESSOR_ID." IN (".$professorData.") AND ".IS_ACTIVE." = 1 GROUP BY ".PROFESSOR_ID."";
$schedules = mysqli_query($con, $scheduleSQL);

$scheduleArray = array();
while($rowData = mysqli_fetch_assoc($schedules))
{
	$scheduleArray[$rowData[PROFESSOR_ID]] = array(

		SCHEDULE_COUNT_SUNDAY =>$rowData[SCHEDULE_COUNT_SUNDAY],
		SCHEDULE_COUNT_MONDAY =>$rowData[SCHEDULE_COUNT_MONDAY],
		SCHEDULE_COUNT_TUESDAY =>$rowData[SCHEDULE_COUNT_TUESDAY],
		SCHEDULE_COUNT_WEDNESDAY =>$rowData[SCHEDULE_COUNT_WEDNESDAY],
		SCHEDULE_COUNT_THURSDAY =>$rowData[SCHEDULE_COUNT_THURSDAY],
		SCHEDULE_COUNT_FRIDAY =>$rowData[SCHEDULE_COUNT_FRIDAY],
		SCHEDULE_COUNT_SATURDAY =>$rowData[SCHEDULE_COUNT_SATURDAY],

	);
}

//professor schedule code end


$generateSQL = "SELECT ".PROFESSOR_ID.","."SUM(".IS_LATE.") as ".IS_LATE."".", "."COUNT(case when ".IS_VALID." = '0' then 1 else null end)"." as ".INVALIDLOG.", "."COUNT(*)"." as ".ROWS." FROM ".TBL_TIME_LOG." WHERE ".PROFESSOR_ID." IN (".$professorData.") AND ".TIME_LOG_DATE." BETWEEN '$startDate' AND '$endDate' AND ".IS_ACTIVE." = ".ACTIVE." GROUP BY ".PROFESSOR_ID."";

$generateResults = mysqli_query($con, $generateSQL);

//get number of occurences
$startDT = strtotime($startDate);
$endDT = strtotime($endDate);

$scheduleOccurences = array();
$daysInAWeek = getDays();

for($y=0; $y<=6; $y++)
{
	$count = 1;
	for($i = strtotime($daysInAWeek[$y], $startDT); $i <= $endDT; $i = strtotime('+1 week', $i))
    	$scheduleOccurences[$y] = $count++;	
}	

// get number of occurences end

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

//count total no of professors start
$countProf = "SELECT "."COUNT(*)"." as count FROM ".TBL_PROFESSOR." WHERE ".IS_ACTIVE." = 1";
$getProfCountResult = mysqli_query($con, $countProf);
$rowCountProf = mysqli_fetch_assoc($getProfCountResult);
//count total no of professors end

$timelogArray = array();
$getTimeLog = "SELECT * FROM ".TBL_TIME_LOG." WHERE ".PROFESSOR_ID." IN (".$professorData.") AND ".TIME_LOG_DATE." BETWEEN '$startDate' AND '$endDate' AND ".IS_ACTIVE." = ".ACTIVE."";

$timelogs = mysqli_query($con, $getTimeLog);
$thisNo = 1;
$timeLogTable = '';
$statusValid = '';
$statusLate = '';
while($thisRow = mysqli_fetch_assoc($timelogs))
{
	$style = ($thisNo%2 == 1) ? 'style="background:#EAEAEA"': ''; 
	if($thisRow[IS_VALID] != 1)
	{
		$statusValid = 'INVALID';
	}
	else
	{
		$statusValid = 'VALID';
	}

	if($thisRow[IS_LATE] == 1)
	{
		$statusLate = 'LATE';
	}
	else
	{
		$statusLate = 'ON-TIME';
	}

	$timeLogTable .= '<tr '.$style.'>

	<td>'.$thisNo.'</td>
	<td width="20%" style="text-align:center">'.$profNameArr[$thisRow[PROFESSOR_ID]].'</td>
	<td colspan="3" style="text-align:center">'.date('D, F d, Y', strtotime($thisRow[TIME_LOG_DATE])).'</td>
	<td colspan="2" style="text-align:center">'.($thisRow[TIME_LOG_IN] != '00:00:00' ? date('H:i:s a',strtotime($thisRow[TIME_LOG_IN])) : '-').'</td>
	<td colspan="2" style="text-align:center">'.($thisRow[TIME_LOG_OUT] != '00:00:00' ? date('H:i:s a',strtotime($thisRow[TIME_LOG_OUT])) : '-').'</td>
	<td style="text-align:center">'.$statusLate.' | '.$statusValid.'</td>
	</tr>';
	$thisNo++;

}


$dataForTable ='';
$no = 1;
$totalabsences = $totalinvalid = $totallate = 0;

foreach($professorDataArr as $key => $value)
{
	$total = 0;
	$count = 0;
	$style = ($no%2 == 1) ? 'style="background:#EAEAEA"': ''; 
	$dataForTable .= '<tr '.$style.'>

	<td style="text-align:center">'.$no.'</td>
	<td style="text-align:center">'.$profNameArr[$key].'</td>';
	
	foreach($value[SCHEDULE_COUNT] as $val)
	{
		$total += $val * $scheduleOccurences[$count];
		$count++;			 
	}

	$dataForTable .=
	'<td style="text-align:center">'.$total.'</td>';
	$dataForTable .= '<td style="text-align:center">'.$value[ROWS].'</td>
	<td style="text-align:center">'.($value[ROWS]-$value[IS_LATE]).'</td>
	<td style="text-align:center">'.$value[IS_LATE].'</td>
	<td style="text-align:center">'.$value[INVALIDLOG].'</td>
	<td style="text-align:center">'.($total-$value[ROWS]).'</td>
	</tr>';

	$totalabsences += $total-$value[ROWS];
	$totalinvalid += $value[INVALIDLOG];
	$totallate += $value[IS_LATE];
	$no++;
}

$_SESSION['generate_PDF'] = "<div class='alert alert-success alert-dismissible'>
		  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
		  <strong>Report was generated successfully!</strong> 
		</div>";

?>
<?php 
	//require_once '/vendor/autoload.php';
	include('mpdf/mpdf.php');

//for CRON only
// $monthStart = new DateTime("first day of last month");
// $monthEnd = new DateTime("last day of last month");
// $MS = $monthStart->format('M d, Y');
// $ME = $monthEnd->format('M d, Y');


$html = '<html>
	<head>

		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/styles1.css">
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
									<span class="strongText"><b>'.date('F d, Y',strtotime($startDate)) ." - ".date('F d, Y',strtotime($endDate)).'</b></span>
								</td>
								<td style="width:50%;" class="text_right">&nbsp;</td>
							</tr>
							<tr>
								<td style="width:50%;">
									<span>Total Number of Active Professors:</span><br>
									<span class="strongTextCommission"><b>'.$rowCountProf['count'].'</b></span>
								</td>
								<td style="width:50%;">
									<span>Total Number of Lates:</span><br>
									<p class="strongTextCommission"><b>'.($totallate!=0 ? $totallate :'None').'</b></p>
								</td>
							</tr>
							<tr>
								<td style="width:50%;">
									<span>Total Number of Absences:</span><br>
									<span class="strongText"><b>'.($totalabsences!=0 ? $totalabsences :'None').'</b></span>
								</td>

								<td style="width:50%;">
									<span>Total Number of Invalids:</span><br>
									<span class="strongText"><b>'.($totalinvalid!=0 ? $totalinvalid :'None').'</b></span>
								</td>
						</table>
					</div>

					<div>					
					 <table class="table table-striped" style="margin-top:15px" border=1 width="100%">
						<tr>
							<th style="text-align: center">No</th>
							<th width="20%" style="text-align: center">Name</th>
							<th style="text-align: center">Possible Total Attendance</th>
							<th style="text-align: center">Total Attendance Entered</th>
							<th style="text-align: center">On Time</th>
							<th style="text-align: center">Late</th>
							<th style="text-align: center">Invalid</th>
							<th style="text-align: center">Absences</th>
						</tr>

						'.$dataForTable.'
					</table>	

					<table class="table table-striped" style="margin-top:15px" border=1 width="100%">
						<tr>
							<th style="text-align: center">No</th>
							<th width="20%" style="text-align:center">Name</th>
							<th colspan="3" style="text-align: center">Date</th>
							<th colspan="2" style="text-align: center">Time In</th>
							<th colspan="2" style="text-align: center">Time Out</th>
							<th style="text-align: center">Status</th>
						</tr>

						'.$timeLogTable.'

						<tr><td colspan=10 height="25px"></td></tr><tr></tr>
							<tr>
								<td class="" colspan="4">
									<span class="strongText">Prepared by:</span>
								</td>
								<td class="" colspan="4">
									<span class="strongText">Checked by:</span>
								</td>
								<td colspan="2">
									<span class="align_right strongText" style="padding-right:50px">Approved by:</span>
								</td>
							</tr>
							<tr>
								<td class="" colspan="4">
									<br/>
									<br/>
									<p class="strongText"><u>Site Administrator</u></p>
									<p class="smallText">'.date('F d, Y - h:i a').'</p>
								</td>
								<td colspan="4">
									<span class="align_right strongText" style="padding-right:50px">&nbsp;</span>
								</td>
								<td colspan="2">
									<span class="align_right strongText" style="padding-right:50px">&nbsp;</span>
								</td>
							</tr>


						</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
	<!-- END -->
</html>';




	ob_clean();
	// MPDF
	$mpdf = new mPDF('UTF-8', 'A4-L', 0, '', 10, 10, 10, 10);	
	$mpdf->WriteHTML($html,2);

	$fileName = date('M d, Y',strtotime($startDate)).' - '.date('M d, Y',strtotime($endDate)).' Attendance Report.pdf';
	$path = 'PDF/'.$fileName;

	//storing it
	//$mpdf->Output($path, 'F');
	
	//viewing
	$mpdf->Output($fileName, 'D');
 	header("location: attendance.php");
?>