<!DOCTYPE html>
<html lang="en">
<head>
<title>Attendance Log Sheet</title>

<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- //for-mobile-apps -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/styles.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/font-awesome.css" rel="stylesheet"> 
<!--//fonts-->

<!--web-fonts-->
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
<!--//web-fonts-->

<!-- Date Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/latest/css/bootstrap.css" />
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<!--//Date Picker -->

<!-- js -->
<link rel="icon" type="image/png" href="images/logo-pcu.png">
<style type="text/css">
    th {
        font-weight: bold;
    }
</style>
</head>
<body>
<!-- //main-content -->
        <div class="wthree-main-content">
            <div class="container">
                <center>
                    <div id="datepicker" style="float: left; margin-bottom: 20px;">
                        Select Start and End Date <input type='text' class="form-control daterange" id='datepicker'>
                            <script type="text/javascript">
                                $('.daterange').daterangepicker();
                            </script>
                    </div>
                        <!--Table-->
                        <table class="table table-bordered table-hover">
                            <!--Table head-->
                            <thead style="background-color: lightblue;">
                                <tr>
                                    <th>Time-In</th>
                                    <th>Time-Out</th>
                                    <th>Date</th>
                                    <th>Faculty Name</th>
                                    <th>Card Number</th>
                                    <th>Room No.</th>
                                </tr>
                            </thead>
                            <!--Table head-->
                            <!--Table body-->
                            <tbody>
                                <tr>
                                    <td>11:00 PM</td>
                                    <td>2:00 PM</td>
                                    <td>02-28-2018</td>
                                    <td>Engr. Jun Lorico</td>
                                    <td>55555444</td>
                                    <td>RM 314</td>
                                </tr>
                            </tbody>
                            <!--Table body-->
                        </table>
                        <!--Table-->
                    </div>
                </center>
                </div>
            </div>
            </div>
        </div>
        </div>

        <!-- Script -->
        <script type="text/javascript">
        $(document).ready(function(){
         
          $('#datepicker').datepicker({
           format: "yy-mm-dd",
           startDate: '-1y -1m',
           endDate: '+2m +10d'
          });

          $('#datepicker2').datepicker({
           format: "yy-mm-dd",
           startDate: '-1m',
           endDate: '+10d'
          }); 
        });
        </script>

</body>
</html>