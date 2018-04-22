<?php
session_start();

include('../database/dbconfig.php');
include('../database/mysql.php');
include('../users/checksession.php');

if (!empty($_GET)) {
    if ($_GET['message'] == "wrong") {
        $message = "Something went wrong, please try again";
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
            $('#lease_date').datepicker({
                minDate: 1,
                dateFormat: 'yy-mm-dd'
            });
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

            $("#edit_car_form").validate({
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
                    car_type: {
                        required: true
                    }

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
                    <button class="btn btn-secondary my-2 my-sm-0" type="button" name="logout" id="logout">Logout</button>
                </form>
            </div>
        </nav>

        <div class="container">
            <form action="edit_car.php" method="post" id="edit_car_form">
                <fieldset>
                    <?php
                    $vid = $_GET['vid'];
                    $mysql = new mysql($db);
                    $car_details = $mysql->get_car_by_vid($vid);
                    ?>
                    <legend>Edit Car Details</legend>
                    <div class="form-group ">
                        <label for="example">Car Model</label>
                        <input type="text" class="form-control" id="car_model" name="car_model" aria-describedby="emailHelp" placeholder="Enter Car Model" value="<?php echo $car_details[0]['model']; ?>">
                        <input type="hidden" class="form-control" id="vid" name="vid" aria-describedby="emailHelp" value="<?php echo $car_details[0]['vid']; ?>">
                    </div>
                    <div class="form-group ">
                        <label for="exampleInputEmail1">Year of Manufacturing</label>
                        <input type="text" class="form-control" id="year" name="year" aria-describedby="emailHelp" placeholder="Enter Year" value="<?php echo $car_details[0]['cyear']; ?>">
                    </div>

                    <div class="form-group ">
                        <label for="exampleInputEmail1">Daily Rate</label>
                        <input type="text" class="form-control" id="daily_rate" name="daily_rate" aria-describedby="emailHelp" placeholder="Enter Daily Rate" value="<?php echo $car_details[0]['daily_rate']; ?>">
                    </div>
                    <div class="form-group ">
                        <label for="exampleInputEmail1">Weekly Rate</label>
                        <input type="text" class="form-control" id="weekly_rate" name="weekly_rate" aria-describedby="emailHelp" placeholder="Enter Weekly Rate" value="<?php echo $car_details[0]['weekly_rate']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="car_type">Car Type</label>
                        <select class="form-control custom-select" name="car_type" id="car_type">
                            <option value="">Select an option</option>
                            <option value="1" <?php echo ($car_details[0]['car_type'] == 1 ? "selected" : ''); ?>>Compact</option>
                            <option value="2" <?php echo ($car_details[0]['car_type'] == 2 ? "selected" : ''); ?>>Large</option>
                            <option value="3" <?php echo ($car_details[0]['car_type'] == 3 ? "selected" : ''); ?>>SUV</option>
                            <option value="4" <?php echo ($car_details[0]['car_type'] == 4 ? "selected" : ''); ?>>Truck</option>
                            <option value="5" <?php echo ($car_details[0]['car_type'] == 5 ? "selected" : ''); ?>>Van</option>
                            <option value="6" <?php echo ($car_details[0]['car_type'] == 6 ? "selected" : ''); ?>>Medium</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="owner_type">Owner</label>
                        <select class="form-control custom-select" name="owner" id="owner">
                            <option selected="" value="">Select an option</option>

                            <?php
                            $owners = $mysql->get_all_owners();
                            for ($i = 0; $i < count($owners); $i++) {
                                if ($owners[$i]['owner_type'] == 1) {
                                    $owner_type = "Individual";
                                } elseif ($owners[$i]['owner_type'] == 2) {
                                    $owner_type = "Bank";
                                } else {
                                    $owner_type = "Car Rental Company";
                                }
                                if ($owners[$i]['oid'] == $car_details[0]['oid']) {
                                    $selected = 'selected';
                                } else {
                                    $selected = '';
                                }
                                ?>

                                <option value=<?php echo $owners[$i]['oid'] . '_' . $owners[$i]['owner_type']; ?> <?php echo $selected; ?>><?php echo $owners[$i]['owner_name']; ?>(<?php echo $owner_type; ?>)</option>

                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group ">
                        <label for="exampleInputEmail1">Lease Date(Only if owner is Individual or Bank)</label>
                        <input type="text" class="form-control" id="lease_date" name="lease_date" aria-describedby="emailHelp" placeholder="Enter Lease Date"value="<?php echo $car_details[0]['lease_date'] ?>">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </fieldset>
            </form>
        </div>
    </body>
</html>


