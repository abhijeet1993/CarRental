<?php
session_start();
//echo '<pre>';
//print_r($_SESSION);
//exit();

include('../database/dbconfig.php');
include('../database/mysql.php');
include('../users/checksession.php');
?>

<html>
    <head>

        <link href="../resources/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../resources/css/jquery-ui.css">
        <link rel="stylesheet" href="../resources/css/jquery.dataTables.min.css">
        <script type="text/javascript" src="../resources/jquery/jquery-1.12.4.js"></script>
        <script type="text/javascript" src="../resources/jquery/jquery-ui.js"></script>
        <script type="text/javascript" src="../resources/jquery/jquery.dataTables.min.js"></script>

    </head>
    <?php
    include 'logout.php';
    ?>
    <style>
        html,
        body {
            height: 100%;
            /*        background-image: url("resources/images/car2.jpg");
                    background-repeat: no-repeat;
                    background-size: cover;*/
        }
        .dataTable {
            /*height: 100%;*/
            margin-top: 30px;
            margin-left: 200px;
            /*            display: flex;
                        justify-content: center;
                        align-items: center;*/
        }

    </style>

    <script>
        $(document).ready(function () {
            $('#rents_table').dataTable();
            $('#active_rentals').click(function () {
                window.location.href = 'customer_dashboard.php';
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
                        <a class="nav-link active_rentals" href="#" id="active_rentals">Active and Other Rentals</a>
                    </li>

<!--                    <li class="nav-item">
                        <a class="nav-link past_rentals" href="#" id="past_rentals">Past Rentals</a>
                    </li>-->
                    <li class="nav-item">
                        <a class="nav-link rent_car" href="#" id="rent_car">Rent Car</a>
                    </li>

                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <div class="form-group row">
                        <label for="" class="col-md-8 col-form-label name"><div style="color:white">Welcome <?php echo $_SESSION['user_name'] ?></div></label>
                    </div>
                    <button class="btn btn-secondary my-2 my-sm-0" type="button" name="logout" id="logout">Logout</button>
                </form>
            </div>
        </nav>
        <div class="col-lg-9 dataTable">
            <table class="table table-hover" id="rents_table">
                <thead>
                    <tr>
                        <?php
                        if ($_SESSION['rental_type'] == 1) {

                            $rental_type = 'Weekly Rate';
                        } else {
                            $rental_type = 'Daily Rate';
                        }
                        ?>
                        <th scope="col">Sr. No.</th>
                        <th scope="col">Car Model</th>
                        <th scope="col">Car Type</th>
                        <th scope="col"><?php echo $rental_type; ?></th>
                        <th scope="col">Start Date</th>
                        <th scope="col">Return Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $mysql = new mysql($db);

                    $free_cars = $_SESSION['free_cars'];
                    for ($i = 0; $i < count($free_cars); $i++) {
                        if ($i % 2 == 0) {
                            $row = "table-active";
                        } else {
                            $row = "table-default";
                        }
                        $car_type = $mysql->get_car_type_name($free_cars[$i]['car_type']);
                        if ($_SESSION['rental_type'] == 1) {
                            $rate = $free_cars[$i]['weekly_rate'];
                        } else {
                            $rate = $free_cars[$i]['daily_rate'];
                        }
                        ?>
                        <tr class="<?php echo $row; ?>" id=<?php echo $free_cars[$i]['vid']; ?>>
                            <th><?php echo $i + 1 ?></th>
                            <td><?php echo $free_cars[$i]['model']; ?></td>
                            <td><?php echo $car_type[0]['ctype']; ?></td>
                            <td><?php echo $rate; ?></td>
                            <td><?php echo $_SESSION['start_date']; ?></td>
                            <td><?php echo $_SESSION['return_date']; ?></td>
                            <td><a href="book_carform.php?vid=<?php echo $free_cars[$i]['vid'] ?>">Book Car</a></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>