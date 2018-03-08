<?php 
session_start();

require 'connect.php';
include 'constants.php';
include 'helper.php';

if(isset($_SESSION[USER_LEVEL]))
{
	header('location: login.php');
}



$searchSQL = "SELECT * FROM ".TBL_PROFESSOR." ORDER BY ".PROFESSOR_ID." DESC";
$result = mysqli_query($con, $searchSQL);
$tableData = '';
$no = 1;
while($row = mysqli_fetch_assoc($result))
{
	$activeOrInactive = $row[IS_ACTIVE] == 1 ? '<a><span style="cursor:pointer" onclick="deactivate('.$row[PROFESSOR_ID].')" title="Make Inactive" class="fa fa-close"></span></a>' : '<a><span style="cursor:pointer" onclick="activate('.$row[PROFESSOR_ID].')" title="Make Active" class="fa fa-check"></span></a>';

	$tableData .= '<tr>

	<td>'.$no.'</td>
	<td>'.$row[PROFESSOR_FIRST_NAME].' '.$row[PROFESSOR_LAST_NAME].'</td>
	<td>'.$row[SERIAL_NUMBER].'</td>
	<td>'.$row[PROFESSOR_PHONE_NUMBER].'</td>
	<td>'.(($row[IS_ACTIVE] == ACTIVE) ? "Active" : "Inactive" ).'</td>
	<td><a href="editProfessorDetails.php?id='.$row[PROFESSOR_ID].'"><span style="margin-right:5px"class="fa fa-edit" title="Edit"></span></a>'.$activeOrInactive.'</td>
	
	</tr>';

	$no++;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Professors</title>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css"></link>
<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>

<script type="text/javascript">

	$(document).ready(function() {
	    $('#table-professors').DataTable();
	});

	function activate(id)
	{
		if(confirm("Activate this Professor?"))
			location.href = "activateProfessor.php?id=" + id;
	}

	function deactivate(id)
	{
		if(confirm("Deactivate this Professor?"))
			location.href = "deactivateProfessor.php?id=" + id;
	}

</script>

<?php include 'headSettings.php';?>
</head>
<body>

<?php include 'headerAndSideBar.php';?>


<div class="dash_page">
  <div class="col-lg-10">
    <h2 style="margin-right:">Professors</h2>

    <?php echo isset($_SESSION['edit_registration_success']) ? $_SESSION['edit_registration_success'] : "";

    unset($_SESSION['edit_registration_success']);

    ?>
    <hr style="margin-left: -25px;">

<div class="row">
  <div class="container">

		<table id="table-professors" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Card Number</th>
							<th>Phone Number</th>
							<th>Is Active</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php echo isset($tableData) ? $tableData : "";?>
					</tbody>
				</table>

</div>

</div>


<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

</body>
</html>

