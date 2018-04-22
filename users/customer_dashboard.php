<?php
session_start();

include('../database/dbconfig.php');
include('../database/mysql.php');
include('../users/checksession.php');
if (!empty($_GET)) {
    if ($_GET['message'] == "rental_created") {
        $message = "Booking Confirmed";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
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
            $('#active_rentals_table').dataTable();
            $('#other_rentals_table').dataTable();
            $('#rent_car').click(function () {
                window.location.href = 'rent_carform.php';
            });
            $('#past_rentals').click(function () {
                window.location.href = 'past_rentals.php';
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
                        <a class="nav-link active_rentals" href="#" id="active_rentals">Active and Other Rentals</a>
                    </li>

                    <!--                    <li class="nav-item">
                                            <a class="nav-link past_rentals" href="#" id="past_rentals">Past Rentals</a>
                                        </li>-->
                    <li class="nav-item">
                        <a class="nav-link rent_car" href="#" id="rent_car">Rent Car</a>
                    </li>

                </ul>
                <div class="row">
                    <label for="" class="col-md-8 col-form-label name">Welcome <?php echo $_SESSION['user_name'] ?></label>
                </div>
                <button class="btn btn-secondary my-2 my-sm-0" type="button" name="logout" id="logout">Logout</button>
            </div>
        </nav>

        <div class="col-lg-9 dataTable">
            <h3>Active Rentals</h3>
            <table class="table table-hover" id="active_rentals_table">
                <thead>
                    <tr>
                        <th scope="col">Sr. No.</th>
                        <th scope="col">Car Model</th>
                        <th scope="col">Car Type</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">Return Date</th>
                        <th scope="col">Total Cost</th>
                        <th scope="col">Paid</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $mysql = new mysql($db);

                    $rental_details = $mysql->get_rental_details_by_cid($_SESSION['id']);
//                    echo '<pre>';
//                    print_r($rental_details);
//                    exit();
                    for ($i = 0; $i < count($rental_details); $i++) {
                        if ($i % 2 == 0) {
                            $row = "table-active";
                        } else {
                            $row = "table-default";
                        }

                        $car_details = $mysql->get_car_by_vid($rental_details[$i]['vid']);
                        $car_type = $mysql->get_car_type_name($car_details[0]['car_type']);
                        ?>
                        <tr class="<?php echo $row; ?>">
                            <th><?php echo $i + 1 ?></th>
                            <td><?php echo $car_details[0]['model']; ?></td>
                            <td><?php echo $car_type[0]['ctype']; ?></td>
                            <td><?php echo $rental_details[$i]['start_date']; ?></td>
                            <td><?php echo $rental_details[$i]['return_date']; ?></td>
                            <td><?php echo $rental_details[$i]['total_cost']; ?></td>
                            <td><?php echo ($rental_details[0]['paid'] == 2 ? "Not Paid" : "Paid"); ?></td>
                            <td><a href="return_carform.php?rid=<?php echo $rental_details[$i]['rid'] ?>">Return Car</a></td>

                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="col-lg-9 dataTable">
            <h3>Other Rentals</h3>
            <table class="table table-hover" id="other_rentals_table">
                <thead>
                    <tr>
                        <th scope="col">Sr. No.</th>
                        <th scope="col">Car Model</th>
                        <th scope="col">Car Type</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">Return Date</th>
                        <th scope="col">Total Cost</th>
                        <th scope="col">Paid</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $temp_array = array();
                    echo '<pre>';
                    foreach ($rental_details as $key => $value) {
                        array_push($temp_array, $value['rid']);
                    }
//                    print_r($temp_array);
//                    die;
                    $not_rids_string = implode(',', $temp_array);
//                    echo '<pre>';
//                    print_r($rental_details);
//                    exit();
                    $cid = $_SESSION['id'];
                    $where_condition = " where rid not in($not_rids_string) and cid = $cid";

                    $other_rental_details = $mysql->get_other_rental_details($where_condition);
                    for ($i = 0; $i < count($other_rental_details); $i++) {
                        if ($i % 2 == 0) {
                            $row = "table-active";
                        } else {
                            $row = "table-default";
                        }

                        $car_details1 = $mysql->get_car_by_vid($other_rental_details[$i]['vid']);
                        $car_type = $mysql->get_car_type_name($car_details1[0]['car_type']);
                        ?>
                        <tr class="<?php echo $row; ?>">
                            <th><?php echo $i + 1 ?></th>
                            <td><?php echo $car_details1[0]['model']; ?></td>
                            <td><?php echo $car_type[0]['ctype']; ?></td>
                            <td><?php echo $other_rental_details[$i]['start_date']; ?></td>
                            <td><?php echo $other_rental_details[$i]['return_date']; ?></td>
                            <td><?php echo $other_rental_details[$i]['total_cost']; ?></td>
                            <td><?php echo ($other_rental_details[0]['paid'] == 2 ? "Not Paid" : "Paid"); ?></td>

                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </body>
</html>
