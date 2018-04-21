<?php
session_start();

include('../database/dbconfig.php');
include('../database/mysql.php');
$vid = $_GET['vid'];
?>
<html>
    <head>
        <link href = "../resources/css/bootstrap.min.css" rel = "stylesheet">
        <link rel = "stylesheet" href = "../resources/css/jquery-ui.css">
        <script type = "text/javascript" src = "../resources/jquery/jquery-1.12.4.js"></script>
        <script type="text/javascript" src="../resources/jquery/jquery.validate.min.js"></script>
        <script type="text/javascript" src="../resources/jquery/jquery-ui.js"></script>

    </head>
    <?php
    include 'logout.php';
    ?>
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
            align-items: center;
        }

        .form-group{
            width: 150%;
        }

    </style>

    <script>
        $(document).ready(function () {

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
        <div class="container">
            <form action="book_car.php" method="post" id="book_car">
                <div class="form-group">
                    <fieldset>
                        <legend>Booking Details</legend>
                        <?php
                        $mysql = new mysql($db);
                        $car_details = $mysql->get_car_by_vid($vid);
//                        echo '<pre>';
//                        print_r($car_details);
//                        exit();
                        ?>
                        <label class="control-label" for="readOnlyInput">Car Model</label>
                        <input class="form-control" id="car_model" name="car_model" type="text" placeholder="" readonly="" value="<?php echo $car_details[0]['model']; ?>">
                        <input class="form-control" id="vid" name="vid" type="hidden" placeholder="" readonly="" value="<?php echo $vid; ?>">
                    </fieldset>
                </div>
                <div class="form-group">
                    <fieldset>
                        <label class="control-label" for="readOnlyInput">Start Date</label>
                        <input class="form-control" id="start_date" name="start_date" type="text" placeholder="" readonly="" value="<?php echo $_SESSION['start_date']; ?>">
                    </fieldset>
                </div>

                <div class="form-group">
                    <fieldset>
                        <label class="control-label" for="readOnlyInput">Return Date</label>
                        <input class="form-control" id="return_date" name="return_date" type="text" placeholder="" readonly="" value="<?php echo $_SESSION['return_date']; ?>">
                    </fieldset>
                </div>

                <?php
                if ($_SESSION['rental_type'] == 1) {
                    $total_cost = $_SESSION['no_of_weeks'] * $car_details[0]['weekly_rate'];
                    $rental_type = 'Weekly';
                } else {
                    $total_cost = $_SESSION['no_of_days'] * $car_details[0]['daily_rate'];
                    $rental_type = 'Daily';
                }
                ?>
                <div class="form-group">
                    <fieldset>
                        <label class="control-label" for="readOnlyInput">Rental Type</label>
                        <input class="form-control" id="rental_type" name="rental_type" type="text" placeholder="" readonly="" value="<?php echo $rental_type; ?>">
                    </fieldset>
                </div>

                <div class="form-group">
                    <fieldset>
                        <label class="control-label" for="readOnlyInput">Total Cost</label>
                        <input class="form-control" id="total_cost" name="total_cost" type="text" placeholder="" readonly="" value="<?php echo $total_cost; ?>">
                    </fieldset>
                </div>

                <button type="submit" class="btn btn-primary">Confirm Booking</button>
            </form>
        </div>
    </body>
</html>