
<!DOCTYPE html>
<html lang="en">
<head>
<title>Class Schedule</title>


<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>

<script type="text/javascript">

    $(document).ready(function() {
        $('#table-schedule').DataTable();
    });

    function activate(id)
    {
        if(confirm("Make schedule active?"))
            location.href = "activateSchedule.php?id=" + id;
    }

    function deactivate(id)
    {
        if(confirm("Deactivate schedule?"))
            location.href = "deactivateSchedule.php?id=" + id;
    }

</script>


<style type="text/css">
    th {
        font-weight: bold;
    }
    .btn {
        margin-right: 3px;
    }
</style>



<?php include 'headSettings.php';?>
</head>
<body>

<?php include 'headerAndSideBar.php';?>


<div class="dash_page">
  <div class="col-lg-10">
    <h2 style="margin-right:">Schedule  </h2>

    <?php echo isset($_SESSION['edit_registration_success']) ? $_SESSION['edit_registration_success'] : "";

        if(isset($_SESSION['edit_registration_success']))
            unset($_SESSION['edit_registration_success']);

    ?>
    <hr style="margin-left: -25px;">

        <div class="row">
          <div class="container">
                    <div class="buttons" style="float: right; margin-bottom: 15px;">
                        <button class="btn btn-primary">Add</button>
                    </div>
                        <table id="table-schedule" class="table table-bordered table-hover">
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
                        </table>
                    </div>

            </div>
            </div>
</body>
</html>