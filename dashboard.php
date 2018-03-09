<?php 

session_start();

require 'connect.php';
include 'constants.php';
include 'helper.php';

if(isset($_SESSION[USER_LEVEL]))
{
  header('location: login.php');
}


?>

<!DOCTYPE html>
<html>
<head>
<?php include 'headSettings.php'; ?>
</head>
<body>

<?php include 'headerAndSideBar.php';?> 

<div class="dash_page">
  <div class="col-lg-10">
    <h2 style="padding: 20px 0 9px 0;">Welcome <?php echo $_SESSION[USER_FIRST_NAME]?>!</h2>
    <hr style="margin-left: -25px;">

<div class="row">
  <div class="container">

    <div class="col-lg-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-bar-chart-o fa-fw"></i> Bar Graph
          <div class="pull-right">
        </div>
      </div>
      <div class="panel-body" style="display: none;">
          <div id="morris-area-chart"></div>
      </div>
      <div class="panel-body">
          <div class="col-lg-4">
              <div class="table-responsive">
                  <table class="table table-bordered table-hover table-striped">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Date</th>
                              <th>Time</th>
                              <th>Amount</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td>3326</td>
                              <td>10/21/2013</td>
                              <td>3:29 PM</td>
                              <td>$321.33</td>
                          </tr>
                          <tr>
                              <td>3325</td>
                              <td>10/21/2013</td>
                              <td>3:20 PM</td>
                              <td>$234.34</td>
                          </tr>
                          <tr>
                              <td>3324</td>
                              <td>10/21/2013</td>
                              <td>3:03 PM</td>
                              <td>$724.17</td>
                          </tr>
                          <tr>
                              <td>3323</td>
                              <td>10/21/2013</td>
                              <td>3:00 PM</td>
                              <td>$23.71</td>
                          </tr>
                          <tr>
                              <td>3322</td>
                              <td>10/21/2013</td>
                              <td>2:49 PM</td>
                              <td>$8345.23</td>
                          </tr>
                      </tbody>
                  </table>
              </div>
          </div>
          <div class="col-lg-8">
              <div id="morris-bar-chart"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="panel panel-default">
          <div class="panel-heading">
              <i class="fa fa-bar-chart-o fa-fw"></i> Donut Chart Example
          </div>
          <div class="panel-body">
              <center>
                <div id="morris-donut-chart"></div>
                <a href="#" class="btn btn-default btn-block">View Details</a>
            </center>
          </div>
      </div>
    </div>

  </div>
</div>

</div>

</div>


    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/raphael.min.js"></script>
    <script src="js/morris.min.js"></script>
    <script src="js/morris-data.js"></script>

</body>
</html>