<?php
session_start();
if (!empty($_GET)) {
    if ($_GET['message'] == "email") {
        $message = "Email already exists, try another email.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } elseif ($_GET['message'] == 'owner_created') {
        $message = "Owner Inserted.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } elseif ($_GET['message'] == "wrong") {
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

            $("#lease_date").datepicker({
                minDate: 1
            });

            $("#add_owner_form").validate({
                errorClass: "my-error-class",
                validClass: "my-valid-class",
                rules: {
                    full_name: {
                        required: true
                    },
                    email: {
                        email: true,
                        required: true
                    },
                    owner_type: {
                        required: true
                    }
                },
                messages: {
                    full_name: {
                        required: "Please enter Owner's Full Name"
                    },
                    email: {
                        required: "Please enter a valid email address",
                        email: "Please enter valid email"
                    },
                    owner_type: {
                        required: "Please select appropriate Owner Type"
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
            $("#car_dashboard").click(function () {
                window.location.href = "car_dashboard.php";
            });

            $("#owner_dashboard").click(function () {
                window.location.href = "owner_dashboard.php";
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
                        <label for="" class="col-md-8 col-form-label name" >Welcome <?php echo $_SESSION['user_name'] ?></label>
                    </div>
                    <button class="btn btn-secondary my-2 my-sm-0" type="button" name="logout" id="logout">Logout</button>
                </form>
            </div>
        </nav>

        <div class="container">
            <!--<form action="new_user.php" method="POST">-->
            <form action="add_owner.php" method="post" id="add_owner_form">
                <fieldset>
                    <legend>Add Owner</legend>
                    <div class="form-group ">
                        <label for="example">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" aria-describedby="emailHelp" placeholder="Enter Full Name">
                    </div>
                    <div class="form-group ">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>

                    <div class="form-group">
                        <label for="owner_type">Owner Type</label>
                        <select class="form-control custom-select" name="owner_type" id="owner_type">
                            <option selected="" value="1">Individual</option>
                            <option value="2">Bank</option>
                            <option value="3">Car Rental Company</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </fieldset>
            </form>
        </div>
    </body>
</html>
