<?php 

session_start();
require 'connect.php';
include 'constants.php';
include 'helper.php';

if(isset($_SESSION[USER_LEVEL]))
{
    if($_SESSION[USER_LEVEL] == 1)
        header('location:dashboard.php');
    else if($_SESSION[USER_LEVEL] == 2)
        header('location:checkerAttendance.php');
    else
        header('location:admin.php');
        
}


//search if user exists
if(isset($_POST['submitLogin']))
{
    $user = $_POST['username'];
    $pass = encryptPassword($_POST['password']);

    $searchSQL = "SELECT ".USER_ID.", ".USERNAME.", ".USER_FIRST_NAME.", ".USER_LAST_NAME.", ".USER_LEVEL."  
    FROM ".TBL_USER." 
    WHERE ".IS_ACTIVE." = 1 AND ".USERNAME." = '$user' AND ".PASSWORD." = '$pass'";

    $result = mysqli_query($con, $searchSQL);

    $rows = mysqli_num_rows($result);
    $loginError ="";
    if($rows > 0)
    {
        if($dataRow = mysqli_fetch_assoc($result))
        {
            $_SESSION[USER_ID] = $dataRow[USER_ID];
            $_SESSION[USERNAME] = $dataRow[USERNAME];
            $_SESSION[USER_FIRST_NAME] = $dataRow[USER_FIRST_NAME];
            $_SESSION[USER_LAST_NAME] = $dataRow[USER_LAST_NAME];
            $_SESSION[USER_LEVEL] = $dataRow[USER_LEVEL];
            if($dataRow[USER_LEVEL] == SECRETARY)
            {
                header('location: dashboard.php');
            }
            else if($dataRow[USER_LEVEL] == CHECKER)
            {
                header('location: checkerAttendance.php');
            }
            else
            {
                header('location: admin.php');
            }
        }
    }
    else
    {
        $loginError = "Login failed. Wrong User credentials.";
    }
}


?>



<!DOCTYPE html>
<html>
<head>  
  <link rel="icon" type="image/png" href="images/logo-pcu.png">
<style>

button.btn {
    height: 40px;
    padding: 0 20px;
    background: #1ca0de;
    font-family: 'Open Sans', sans-serif;
    font-size: 16px;
    color: #fff;
}

.form-box {
    margin-top: 7%;
}

.form-top {
    padding: 10px 25px 15px 25px;
    background: rgba(0, 0, 0, 0.5);
}

.form-top-left {
    padding-top: 30px;
}

.form-top-left h3, p { 
    margin-top: 0; 
    color: #fff; 
    font-family: 'Open Sans', sans-serif;
}

.form-bottom {
    padding: 25px 25px 30px 25px;
    background: rgba(0, 0, 0, 0.3);
}

.form-bottom form button.btn {
    width: 20%;
    margin-left: 40%;
}

input[type="text"], 
input[type="password"], 
textarea, 
textarea.form-control {
    height: 45px;
    padding: 0 20px;
    margin-left: 25px;
    vertical-align: middle;
    background: #fff;
    border: 3px solid #fff;
    font-family: 'Open Sans', sans-serif;
    font-size: 16px;
    color: #888;
    width: 90%;
}
.glyphicon.glyphicon-lock{
    font-size: 60px;
    right: 40px;
    top: 40px;
    position: absolute;
    color: white;
}
</style>
    <title>Login Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="top-content">
  <div class="inner-bg">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 form-box">
                <div class="form-top">
                    <div class="form-top-left">
                        <h3>Sign-in Now</h3>
                        <p>Enter your username and password to log on:</p>
                        <span class="glyphicon glyphicon-lock"></span>
                    </div>
                </div>
                <div class="form-bottom">
                    <form role="form" action="" method="post" class="login-form">
                        <div class="form-group">
                            <label class="sr-only" for="form-username">Username</label>
                            <input type="text" name="username" placeholder="Username..." class="form-username form-control" id="form-username" required>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="form-password">Password</label>
                            <input type="password" name="password" placeholder="Password..." class="form-password form-control" id="form-password" required>
                        </div>
                            <p style="color:red;text-align:center"><?php echo isset($loginError) ? $loginError : "";?></p>
                            <button type="submit" name="submitLogin" class="btn">SIGN-IN</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
</body>
</html>