<?php
session_start();

include('../database/dbconfig.php');
include('../database/mysql.php');

if (!empty($_GET)) {
    if ($_GET['message'] == "wrong") {
        $message = "Something went wrong, please try again.";
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

        .ui-datepicker-calendar {
            display: none;
        }​
    </style>
    <script>

        $(document).ready(function () {

            $('#year').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'MM yy',
                yearRange: '1990:2018',
                onClose: function (dateText, inst) {
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).datepicker('setDate', new Date(year, month, 1));
                }
            });

            $("#add_car_form").validate({
                errorClass: "my-error-class",
                validClass: "my-valid-class",
                rules: {
                    car_model: {
                        required: true
                    },
                    year: {
                        required: true
                    },
                    daily_rate: {
                        required: true,
                        number: true,
                        min: 1
                    },
                    weekly_rate: {
                        required: true,
                        number: true,
                        min: 1
                    },
                    owner: {
                        required: true
                    },

                },
                submitHandler: function (form) {
                    form.submit();
                }
            });

            $("#owner_dashboard").click(function () {
                window.location.href = "owner_dashboard.php";
            });
            $("#car_dashboard").click(function () {
                window.location.href = "car_dashboard.php";
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
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link car_dashboard" href="#" id="car_dashboard">Car Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link owner_dashboard" href="#" id="owner_dashboard">Owner Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <div class="form-group row">
                        <label for="" class="col-md-8 col-form-label name"><div style="color:white">Welcome <?php echo $_SESSION['user_name'] ?></div></label>
                    </div>
                    <button class="btn btn-secondary my-2 my-sm-0" type="button" style="float:right">Logout</button>
                </form>
            </div>
        </nav>

        <div class="container">
            <!--<form action="new_user.php" method="POST">-->
            <form action="add_car.php" method="post" id="add_car_form">
                <fieldset>
                    <legend>Add Car</legend>
                    <div class="form-group ">
                        <label for="example">Car Model</label>
                        <input type="text" class="form-control" id="car_model" name="car_model" aria-describedby="emailHelp" placeholder="Enter Car Model">
                    </div>
                    <div class="form-group ">
                        <label for="exampleInputEmail1">Year of Manufacturing</label>
                        <input type="text" class="form-control" id="year" name="year" aria-describedby="emailHelp" placeholder="Enter Year">
                    </div>

                    <div class="form-group ">
                        <label for="exampleInputEmail1">Daily Rate</label>
                        <input type="text" class="form-control" id="daily_rate" name="daily_rate" aria-describedby="emailHelp" placeholder="Enter Daily Rate">
                    </div>
                    <div class="form-group ">
                        <label for="exampleInputEmail1">Weekly Rate</label>
                        <input type="text" class="form-control" id="weekly_rate" name="weekly_rate" aria-describedby="emailHelp" placeholder="Enter Weekly Rate">
                    </div>

                    <div class="form-group">
                        <label for="owner_type">Owner</label>
                        <select class="form-control custom-select" name="owner" id="owner">
                            <option selected="" value="">Select an option</option>

                            <?php
                            $mysql = new mysql($db);

                            $owners = $mysql->get_all_owners();
                            for ($i = 0; $i < count($owners); $i++) {
                                if ($owners[$i]['owner_type'] == 1) {
                                    $owner_type = "Individual";
                                } elseif ($owners[$i]['owner_type'] == 2) {
                                    $owner_type = "Bank";
                                } else {
                                    $owner_type = "Car Rental Company";
                                }
                                ?>
                                <option value=<?php echo $owners[$i]['oid'] . '_' . $owners[$i]['owner_type']; ?>><?php echo $owners[$i]['owner_name']; ?>(<?php echo $owner_type; ?>)</option>

                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group ">
                        <label for="exampleInputEmail1">Lease Date(Only if owner is Individual or Bank)</label>
                        <input type="date" class="form-control" id="lease_date" name="lease_date" aria-describedby="emailHelp" placeholder="Enter Lease Date">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </fieldset>
            </form>
        </div>
    </body>
</html>


