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
<nav class="navbar navbar-default navbar-static-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <img src="images/logo-pcu.png" name="logo" height="50" width="50" style="float: left; margin: 5px 0px;">
      <a class="navbar-brand" href="#">&nbsp Faculty Attendance Ledger</a>
    </div>
  </div>
</nav>
<div class="navbar-default sidebar">
    <div class="sidebar-nav navbar-collapse" id="sidebar">
    <ul class="nav in">
        <br>
        <li class="divider"></li>
        <li><a href="#"><span class="fa fa-user"></span> &nbspProfile</a></li>
        <li class="divider"></li>
        <li class="dropdown"><a href="#"><i class="fa fa-wpforms"></i>&nbsp Attendance Log Sheet</a></li>
        <li class="divider"></li>
        <li class="dropdown"><a href="#"><i class="fa fa-sitemap"></i>&nbsp Room Slots</a></li>
    </ul>
    </div>
</div>

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