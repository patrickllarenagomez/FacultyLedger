<?php 
session_start();

require 'connect.php';
include 'constants.php';
include 'helper.php';

if(!isset($_SESSION[USER_LEVEL]))
{
	header('location: login.php');
}

if(isset($_GET['id'])){
	$professor_id = $_GET['id'];
}

$searchSQL = "SELECT * FROM ".TBL_PROFESSOR." WHERE ".PROFESSOR_ID." = '$professor_id'";
$result = mysqli_query($con, $searchSQL);

$row = mysqli_fetch_assoc($result);

$firstname = $row[PROFESSOR_FIRST_NAME];
$lastname = $row[PROFESSOR_LAST_NAME];
$phonenumber = $row[PROFESSOR_PHONE_NUMBER];
$cardnumber = $row[SERIAL_NUMBER];

?>

<?php 

	if(isset($_POST['editRegistrationBtn']))
	{
		$cardnumber = $_POST['form-card-number'];
    	$firstname = $_POST['form-first-name'];
    	$lastname = $_POST['form-last-name'];
    	$phonenumber = $_POST['form-phone-number'];


    	$updateSQL = "UPDATE ".TBL_PROFESSOR." SET 

    	".SERIAL_NUMBER." = '$cardnumber',
    	".PROFESSOR_FIRST_NAME." = '$firstname',
    	".PROFESSOR_LAST_NAME." = '$lastname',
    	".PROFESSOR_PHONE_NUMBER." = '$phonenumber' 

    	WHERE ".PROFESSOR_ID." = $professor_id";

    	mysqli_query($con, $updateSQL);

    	$_SESSION['edit_registration_success'] = "<div class='alert alert-success alert-dismissible'>
		  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
		  <strong>Professor details was edited successfully!</strong> 
		</div>";
    	header('location: professors.php');
	}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Professor</title>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css"></link>
<link rel="icon" type="image/png" href="images/logo-pcu.png">

<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/registration.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/font-awesome.css" rel="stylesheet"> 
<?php include 'headSettings.php';?>
</head>
<body>

<?php include 'headerAndSideBar.php';?>


<div class="dash_page">
  <div class="col-lg-10">
    <h2 style="margin-right:">Edit Professor</h2>
    <hr style="margin-left: -25px;">

<div class="row">
  <div class="container">

    <div class="wthree-main-content">
            <div class="container">
                <div class="form-bottom">
                    <form role="form" action="" method="post" class="registration-form">
                        <div class="form-group">
                            <label class="sr-only" for="form-first-name">First Name</label>
                            <input type="text" name="form-first-name" placeholder="First Name" required maxlength="30" class="form-first-name form-control" id="form-first-name" value="<?php echo isset($firstname) ? $firstname : ""?>">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="form-last-name">Last Name</label>
                            <input type="text" name="form-last-name" placeholder="Last Name" required maxlength="30" class="form-last-name form-control" id="form-last-name" value="<?php echo isset($lastname) ? $lastname : ""?>">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="form-card-number">Card Number</label>
                            <input type="text" name="form-card-number" placeholder="Card Number" numeric required class="form-card-number form-control" id="form-card-number" value="<?php echo isset($cardnumber) ? $cardnumber : ""?>">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="form-phone-number">Phone Number</label>
                            <input type="text" name="form-phone-number" placeholder="Phone Number" maxlength="11" class="form-phone-number form-control" id="form-phone-number" value="<?php echo isset($phonenumber) ? $phonenumber : ""?>">
                        </div>
                        <button type="submit" name="editRegistrationBtn" class="btn">SUBMIT</button>
                        <button type="reset" class="btn">RESET</button>
                    </form>
                  </div>
                </div>
            </div>

  </div>
</div>

</div>

</div>


</body>
</html>



?>