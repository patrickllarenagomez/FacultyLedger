<?php  

session_start();

require 'connect.php';
include 'constants.php';
include 'helper.php';

if(isset($_SESSION[USER_LEVEL]))
{
    header('location:login.php');
}

if(isset($_POST['registrationBtn']))
{
    $serial_number = $_POST['form-card-number'];
    $firstname = $_POST['form-first-name'];
    $lastname = $_POST['form-last-name'];
    $phonenumber = $_POST['form-phone-number'];

    $insertSQL = "INSERT INTO ".TBL_PROFESSOR."(".SERIAL_NUMBER.", ".PROFESSOR_FIRST_NAME.", ".PROFESSOR_LAST_NAME.", ".PROFESSOR_PHONE_NUMBER.",".IS_ACTIVE.") VALUES ('$serial_number', '$firstname', '$lastname', '$phonenumber', 1)";

    mysqli_query($con,$insertSQL);

    header('location: professors.php');
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
<title>Registration</title>
<!-- for-mobile-apps -->


<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/registration.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/font-awesome.css" rel="stylesheet"> 
<?php include 'headSettings.php';?>

<link rel="icon" type="image/png" href="images/logo-pcu.png">
</head>
<body>

<?php include 'headerAndSidebar.php';?>

<div class="dash_page">
  <div class="col-lg-10">
    <h2 style="margin-right:">Registration</h2>
    <hr style="margin-left: -25px;">

<div class="row">
  <div class="container">

    <div class="wthree-main-content">
            <div class="container">
                <div class="form-bottom">
                    <form role="form" action="registration.php" method="post" class="registration-form">
                        <div class="form-group">
                            <label class="sr-only" for="form-first-name">First Name</label>
                            <input type="text" name="form-first-name" placeholder="First Name" required maxlength="30" class="form-first-name form-control" id="form-first-name">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="form-last-name">Last Name</label>
                            <input type="text" name="form-last-name" placeholder="Last Name" required maxlength="30" class="form-last-name form-control" id="form-last-name">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="form-card-number">Card Number</label>
                            <input type="text" name="form-card-number" placeholder="Card Number" numeric required class="form-card-number form-control" id="form-card-number">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="form-phone-number">Phone Number</label>
                            <input type="text" name="form-phone-number" placeholder="Phone Number" maxlength="11" class="form-phone-number form-control" id="form-phone-number">
                        </div>
                        <button type="submit" name="registrationBtn" class="btn">SUBMIT</button>
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