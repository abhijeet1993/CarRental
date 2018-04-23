<?php
session_start();

include('../database/dbconfig.php');
include('../database/mysql.php');
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

        .dataTable {
            /*height: 100%;*/
            margin-left: 200px;
            margin-top: 20px;            
            /*            display: flex;
                        justify-content: center;
                        align-items: center;*/
        }

        html,
        body {
            height: 100%;
            /*        background-image: url("resources/images/car2.jpg");
                    background-repeat: no-repeat;
                    background-size: cover;*/
        }
        .container {
            /*height: 100%;*/
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
                    <li class="nav-item ">
                        <a class="nav-link my_car_rentals" href="owner_login_dashboard.php" id="my_car_rentals">My Car Rentals</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link weekly_reports_car_type" href="#" id="weekly_reports_car_type">Weekly Reports - Car Type</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link weekly_reports_car" href="weekly_report_carform.php" id="weekly_reports_car">Weekly Reports - Car</a>
                    </li>

                </ul>
                <div class="row">
                    <label for="" class="col-md-8 col-form-label name">Welcome <?php echo $_SESSION['user_name'] ?></label>
                </div>
                <button class="btn btn-secondary my-2 my-sm-0" type="button" name="logout" id="logout">Logout</button>
            </div>
        </nav>

        <div class="col-lg-9 dataTable">
            <h3>Your Rentals</h3>
            <table class="table table-hover" id="rentals_table">
                <thead>
                    <tr>
                        <th scope="col">Sr. No.</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Car Model</th>
                        <th scope="col">Car Type</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">Return Date</th>
                        <th scope="col">Total Earnings</th>
                        <th scope="col">Paid</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $mysql = new mysql($db);
                    $total_earnings = 0;
                    for ($i = 0; $i < count($_SESSION['rids']); $i++) {
                        $rental_details = $mysql->get_rental_details_by_rid($_SESSION['rids'][$i]);
                        if ($i % 2 == 0) {
                            $row = "table-active";
                        } else {
                            $row = "table-default";
                        }
                        $customer_details = $mysql->get_user_by_cid($rental_details[0]['cid']);
                        $car_details = $mysql->get_car_by_vid($rental_details[0]['vid']);
                        $car_type = $mysql->get_car_type_name($car_details[0]['car_type']);
                        $total_earnings += $rental_details[0]['total_cost'];
                        ?>
                        <tr class="<?php echo $row; ?>">
                            <th><?php echo $i + 1 ?></th>
                            <td><?php echo $customer_details[0]['cname']; ?></td>
                            <td><?php echo $car_details[0]['model']; ?></td>
                            <td><?php echo $car_type[0]['ctype']; ?></td>
                            <td><?php echo $rental_details[0]['start_date']; ?></td>
                            <td><?php echo $rental_details[0]['return_date']; ?></td>
                            <td><?php echo $rental_details[0]['total_cost']; ?></td>
                            <td><?php echo ($rental_details[0]['paid'] == 2 ? "Not Paid" : "Paid"); ?></td>


                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="form-group container">
            <label for="exampleInputPassword1">Total Earnings for week starting from <?php echo $_SESSION['start_date']; ?> are:</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="" readonly="" value="<?php echo $total_earnings; ?>">
        </div>
    </body>
</html>
