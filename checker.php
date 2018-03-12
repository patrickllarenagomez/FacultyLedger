<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
    <title>Checker Dashboard</title>
    <link rel="icon" type="image/png" href="images/logo-pcu.png">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/dashboard-styles.css" rel="stylesheet">
    <script src="js/jquery-2.1.4.min.js"></script>
</head>
<body>
<?php include 'checkerHeaderAndSideBar.php';?>

<div class="dash_page">
  <div class="col-lg-10">
    <h2 style="padding: 20px 0 9px 0;">Welcome Checker!</h2>
    <hr style="margin-left: -25px;">
  </div>

  <div class="row">
    <div class="container">
      <div class="col-lg-10">
        <!--Table-->
          <table class="table table-bordered table-hover">
              <!--Table head-->
              <thead class="blue-grey lighten-4">
                  <tr>
                      <th>Semester</th>
                      <th>Day</th>
                      <th>Subject Code</th>
                      <th>Subject Name</th>
                      <th>Section</th>
                      <th>Time Schedule</th>
                      <th>Room No.</th>
                  </tr>
              </thead>
              <!--Table head-->
              <!--Table body-->
              <tbody>
                  <tr>
                      <td>1st</td>
                      <td>Wednesdays</td>
                      <td>COEN 3232</td>
                      <td>Software Engineering</td>
                      <td>4</td>
                      <td>9am - 2pm</td>
                      <td>314</td>
                  </tr>
              </tbody>
              <!--Table body-->
          </table>
          <!--Table-->
      </div>
    </div>

</div>

    </div>
  </div>
</div>

</body>
</html>