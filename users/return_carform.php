<?php
session_start();
include('../database/dbconfig.php');
include('../database/mysql.php');
include('../users/checksession.php');

$rental_id = $_GET['rid'];
$mysql = new mysql($db);
$rent_details = $mysql->get_rental_details_by_rid($rental_id);
//echo '<pre>';
//print_r($rent_details);
//exit();
?>

<html>
    <head>
        <link href="../resources/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../resources/css/jquery-ui.css">
        <script type="text/javascript" src="../resources/jquery/jquery-1.12.4.js"></script>
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

        .my-error-class {
            color:#FF0000;  /* red */
        }
        .my-valid-class {
            color:#00CC00; /* green */
        }

    </style>

    <script>
        $(document).ready(function () {



            $('#active_rentals').click(function () {
                window.location.href = 'customer_dashboard.php';
            });
            $('#rent_car').click(function () {
                window.location.href = 'rent_carform.php';
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

        <div class="container">
            <form action="return_car.php" method="post" id="book_car">
                <div class="form-group">
                    <fieldset>
                        <legend>Payment Details</legend>
                        <?php
                        $car_details = $mysql->get_car_by_vid($rent_details[0]['vid']);
//                        echo '<pre>';
//                        print_r($car_details);
//                        exit();
                        ?>
                        <label class="control-label" for="readOnlyInput">Car Model</label>
                        <input class="form-control" id="car_model" name="car_model" type="text" placeholder="" readonly="" value="<?php echo $car_details[0]['model']; ?>">
                    </fieldset>
                </div>
                <div class="form-group">
                    <fieldset>
                        <label class="control-label" for="readOnlyInput">Start Date</label>
                        <input class="form-control" id="start_date" name="start_date" type="text" placeholder="" readonly="" value="<?php echo $rent_details[0]['start_date']; ?>">
                        <input class="form-control" id="rid" name="rid" type="hidden" value="<?php echo $rent_details[0]['rid']; ?>">
                    </fieldset>
                </div>

                <div class="form-group">
                    <fieldset>
                        <label class="control-label" for="readOnlyInput">Return Date</label>
                        <input class="form-control" id="return_date" name="return_date" type="text" placeholder="" readonly="" value="<?php echo $rent_details[0]['return_date']; ?>">
                    </fieldset>
                </div>

                <div class="form-group">
                    <fieldset>
                        <label class="control-label" for="readOnlyInput">Rental Type</label>
                        <input class="form-control" id="rental_type" name="rental_type" type="text" placeholder="" readonly="" value="<?php echo $rent_details[0]['rental_type']; ?>">
                    </fieldset>
                </div>

                <div class="form-group">
                    <fieldset>
                        <label class="control-label" for="readOnlyInput">Total Cost</label>
                        <input class="form-control" id="total_cost" name="total_cost" type="text" placeholder="" readonly="" value="<?php echo $rent_details[0]['total_cost']; ?>">
                    </fieldset>
                </div>

                <button type="submit" class="btn btn-primary">Pay and Return Car</button>
            </form>
        </div>
    </body>
</html>

