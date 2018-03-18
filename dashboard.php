<?php 

session_start();

require 'connect.php';
include 'constants.php';
include 'helper.php';

if(!isset($_SESSION[USER_LEVEL]))
{
  header('location: login.php');
}

//set sched start
//startDate is first day of the month, endDate is current date

  $startDate = date('Y-m-1');
  $endDate = date('Y-m-d');


//set sched end

//get Professor Names

$retrieveSQL = "SELECT ".PROFESSOR_ID.",".PROFESSOR_FIRST_NAME.",".PROFESSOR_LAST_NAME." FROM ".TBL_PROFESSOR." WHERE ".IS_ACTIVE." = ".ACTIVE."";

$retrieveResult = mysqli_query($con, $retrieveSQL);
$professorNames = array();
while($rowProfessors = mysqli_fetch_assoc($retrieveResult))
{
  $professorNames[$rowProfessors[PROFESSOR_ID]] = $rowProfessors[PROFESSOR_LAST_NAME].', '.$rowProfessors[PROFESSOR_FIRST_NAME]; 
}

//get Professor Names end

//donut chart start
$profSQL = "SELECT "."COUNT(CASE WHEN ".IS_ACTIVE." = 1 then 1 ELSE NULL END) as ACTIVE".", "."COUNT(CASE WHEN ".IS_ACTIVE." = 0 then 1 ELSE NULL END) as INACTIVE"." FROM ".TBL_PROFESSOR."";

$res = mysqli_query($con, $profSQL);


$profArr[] = array();
while($row = mysqli_fetch_assoc($res))
{
  $profArr[ACTIVE] = $row["ACTIVE"];
  $profArr[INACTIVE] = $row["INACTIVE"];
}
$donutchart ='';
foreach($profArr as $key => $value)
{
  $donutchart .= '{label: '.($key == 1 ? '"Active"' : '"Inactive"' ).', value:'.$value.'},'; 
}
//donut chart end
 

//bar graph start

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
$barGraphData = '';
foreach($professorDataArr as $key => $value)
{
  $barGraphData .= '{
      y: "'.$professorNames[$key].'",
      a: '.$value[IS_LATE].',
      b: '.$value[INVALIDLOG].',
      c: '.($value[ROWS]-$value[IS_LATE]).',
      d: '.$value[ROWS].'
    },';
}
//bar graph end


?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>


<script type="text/javascript">
  $(document).ready(function(){

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [


        <?php echo isset($barGraphData) ? $barGraphData : '';?>

        ],
        xkey: 'y',
        ykeys: ['a', 'b', 'c', 'd'],
        labels: ['Late', 'Invalid', 'On Time','Total Attendance'],
        hideHover: 'auto',
        barColors: ["#ED2939", "#7a92a3", "#197319", "#0087BD"],
        resize: true
    
    });

    Morris.Donut({
  element: 'morris-donut-chart',
  data: [
    <?php echo isset($donutchart) ? $donutchart : '';?>
  ]
});

  });
</script>


<?php include 'headSettings.php'; ?>

</head>
<body>

<?php include 'headerAndSideBar.php';?> 

<div class="dash_page">
    <h2 class="page-header">Welcome <?php echo $_SESSION[USER_FIRST_NAME]?>!</h2>

<div class="row">
  <div class="container">

    <div class="col-lg-5">
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-bar-chart-o fa-fw"></i> Professors' Performance (<?php echo date('M d, Y', strtotime(date('Y-m-1')) ).' - '.date('M d, Y', strtotime(date('Y-m-d')));?>)
          <div class="pull-right">
        </div>
      </div>

      <div class="panel-body">
          <div class="col-lg-12">
              <div id="morris-bar-chart"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="panel panel-default">
          <div class="panel-heading">
              <i class="fa fa-bar-chart-o fa-fw"></i> Professors (To Date)
          </div>
          <div class="panel-body">
                <div id="morris-donut-chart"></div>
          </div>
      </div>
    </div>

  </div>
</div>

</div>

  <!-- Morris Charts JavaScript -->
    <script src="js/raphael.min.js"></script>
    <script src="js/morris.min.js"></script>

</body>
</html>