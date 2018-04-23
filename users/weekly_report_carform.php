<?php
session_start();

include('../database/dbconfig.php');
include('../database/mysql.php');

if (!empty($_GET)) {
    
}
?>
<html>
    <head>

        <link href="../resources/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../resources/css/jquery-ui.css">
        <link rel="stylesheet" href="../resources/css/jquery.dataTables.min.css">
        <script type="text/javascript" src="../resources/jquery/jquery-1.12.4.js"></script>
        <script type="text/javascript" src="../resources/jquery/jquery.validate.min.js"></script>
        <script type="text/javascript" src="../resources/jquery/jquery-ui.js"></script>
        <script type="text/javascript" src="../resources/jquery/jquery.dataTables.min.js"></script>
    </head>
    <style>
        .name {
            color: white;
        }
        html,
        body {
            height: 100%;
            /*        background-image: url("resources/images/car2.jpg");
                    background-repeat: no-repeat;
                    background-size: cover;*/
        }
        .container {
            height: 100%;
            display: flex;
            justify-content: center;
            /*align-items: center;*/
        }

        .form-group{
            margin-top: 20px;
            width: 150%;
        }

    </style>
    <?php
    include 'logout.php';
    ?>
    <script>

        $(document).ready(function () {
            $('#rentals_table').dataTable();
            $('#my_car_rentals').click(function () {
                window.location.href = 'owner_login_dashboard.php';
            });

            $('#start_date').datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="#">UTA Car Rental</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation" style="">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link my_car_rentals" href="#" id="my_car_rentals">My Car Rentals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link weekly_reports_car_type" href="#" id="weekly_reports_car_type">Weekly Reports - Car Type</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link weekly_reports_car" href="weekly_report_carform.php" id="weekly_reports_car">Weekly Reports - Car</a>
                    </li>

                </ul>
                <div class="row">
                    <label for="" class="col-md-8 col-form-label name">Welcome <?php echo $_SESSION['user_name'] ?></label>
                </div>
                <button class="btn btn-secondary my-2 my-sm-0" type="button" name="logout" id="logout">Logout</button>
            </div>
        </nav>
        <div class="container">
            <form action="weekly_reportscar.php" method="post" id="report">
                <?php
                $mysql = new mysql($db);
                $oid = $_SESSION['id'];
                $cars = $mysql->get_car_by_oid($oid);
                ?>
                <div class="form-group">
                    <label for="exampleSelect1">Car Type</label>
                    <select class="form-control" id="car" name="car" required="">
                        <option value="" selected="">Select a car</option>
                        <?php
                        for ($i = 0; $i < count($cars); $i++) {
                            ?>
                            <option value="<?php echo $cars[$i]['vid'] ?>"><?php echo $cars[$i]['model'] ?></option>
                            <?php
                        }
                        ?>
                        <option value="all">All</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Start Date</label>
                    <input type="text" class="form-control" id="start_date"  name="start_date" placeholder="Enter Start Date" required="">
                </div>
                <button type="submit" class="btn btn-primary " id="submit" name="submit">Submit</button>
            </form>
        </div>

    </body>
</html>
