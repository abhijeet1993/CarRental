<?php
session_start();
?>
<html>
    <head>

        <link href="../resources/css/bootstrap.min.css" rel="stylesheet">
        <script type="text/javascript" src="../resources/jquery/jquery-1.4.4.min.js"></script>
        <script type="text/javascript" src="../resources/jquery/jquery.validate.min.js"></script>

    </head>
    <style>
        .name {
            color: white;
        }
    </style>
    <script>

        $(document).ready(function () {
            $("#add_car").click(function () {
                 window.location.href = "add_carform.php";
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
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link add_car" href="#" id="add_car">Add Car</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link owner_dashboard" href="#" id="owner_dashboard">Owner Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                </ul>
                    <div class="row">
                        <label for="" class="col-md-8 col-form-label name">Welcome <?php echo $_SESSION['user_name'] ?></label>
                    </div>
                    <button class="btn btn-secondary my-2 my-sm-0" type="button">Logout</button>
            </div>
        </nav>
    </body>
</html>
