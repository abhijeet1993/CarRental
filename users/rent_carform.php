<?php
session_start();
include('../users/checksession.php');
if (!empty($_GET)) {
    if ($_GET['message'] == "wrong") {
        $message = "Something went wrong, please try again!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
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
            $('#start_date').datepicker({
                minDate: 0,
                dateFormat: 'yy-mm-dd'
            });
            $("#rent_car_form").validate({
                errorClass: "my-error-class",
                validClass: "my-valid-class",
                rules: {
                    car_type: {
                        required: true
                    },
                    rental_type: {
                        required: true
                    },
                    weeks_or_days: {
                        required: true,
                        digits: true,
                        min: 1
                    },
                    start_date: {
                        required: true,
                    }

                },
                submitHandler: function (form) {
                    form.submit();
                }
            });

            $('#active_rentals').click(function () {
                window.location.href = 'customer_dashboard.php';
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
                    <li class="nav-item">
                        <a class="nav-link active_rentals" href="#" id="active_rentals">Active and Other Rentals</a>
                    </li>

<!--                    <li class="nav-item">
                        <a class="nav-link past_rentals" href="#" id="past_rentals">Past Rentals</a>
                    </li>-->
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
            <!--<form action="new_user.php" method="POST">-->
            <form action="rent_car.php" method="post" id="rent_car_form">
                <fieldset>
                    <legend>Rent Car</legend>
                    <div class="form-group">
                        <label for="car_type">Select Car Type</label>
                        <select class="form-control custom-select" name="car_type" id="car_type">
                            <option selected="" value="">Select an option</option>
                            <option value="1">Compact</option>
                            <option value="2">Large</option>
                            <option value="3">SUV</option>
                            <option value="4">Truck</option>
                            <option value="5">Van</option>
                            <option value="6">Medium</option>
                            <option value="7">All</option>
                        </select>
                    </div>
                    <fieldset class="form-group">
                        <label for="">Rental Type</label>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="rental_type" id="weekly" value="1" checked="">
                                Weekly
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="rental_type" id="daily" value="2">
                                Daily
                            </label>
                        </div>
                    </fieldset>
                </fieldset>
                <div class="form-group ">
                    <label for="exampleInputEmail1">Number of Weeks Or Days</label>
                    <input type="text" class="form-control" id="weeks_or_days" name="weeks_or_days" aria-describedby="emailHelp" placeholder="Enter number of days or weeks">
                </div>
                <div class="form-group ">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" class="form-control" id="start_date" name="start_date" aria-describedby="emailHelp" placeholder="Enter Start Date">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                </fieldset>
            </form>
        </div>
    </body>
</html>