<?php
session_start();

include('../database/dbconfig.php');
include('../database/mysql.php');

//echo '<pre>';
//print_r($_SESSION);
//die;
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

        .dataTable {
            /*height: 100%;*/
            margin-left: 200px;
            margin-top: 20px;            
            /*            display: flex;
                        justify-content: center;
                        align-items: center;*/
        }
    </style>
    <?php
    include 'logout.php';
    ?>
    <script>

        $(document).ready(function () {
            $('#rentals_table').dataTable();
            $('#weekly_reports_car_type').click(function () {
                window.location.href = 'weekly_reportscartypeform.php';
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
                    <li class="nav-item active">
                        <a class="nav-link my_car_rentals" href="#" id="my_car_rentals">My Car Rentals</a>
                    </li>

                    <!--                    <li class="nav-item">
                                            <a class="nav-link past_rentals" href="#" id="past_rentals">Past Rentals</a>
                                        </li>-->
                    <li class="nav-item">
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

                    $rental_details = $mysql->get_rental_details_by_oid($_SESSION['id']);
//                    echo '<pre>';
//                    print_r($rental_details);
//                    exit();
                    for ($i = 0; $i < count($rental_details); $i++) {
                        if ($i % 2 == 0) {
                            $row = "table-active";
                        } else {
                            $row = "table-default";
                        }
                        $customer_details = $mysql->get_user_by_cid($rental_details[$i]['cid']);
                        $car_details = $mysql->get_car_by_vid($rental_details[$i]['vid']);
                        $car_type = $mysql->get_car_type_name($car_details[0]['car_type']);
                        ?>
                        <tr class="<?php echo $row; ?>">
                            <th><?php echo $i + 1 ?></th>
                            <td><?php echo $customer_details[0]['cname']; ?></td>
                            <td><?php echo $car_details[0]['model']; ?></td>
                            <td><?php echo $car_type[0]['ctype']; ?></td>
                            <td><?php echo $rental_details[$i]['start_date']; ?></td>
                            <td><?php echo $rental_details[$i]['return_date']; ?></td>
                            <td><?php echo $rental_details[$i]['total_cost']; ?></td>
                            <td><?php echo ($rental_details[$i]['paid'] == 2 ? "Not Paid" : "Paid"); ?></td>


                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
