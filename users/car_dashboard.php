<?php
session_start();

include('../database/dbconfig.php');
include('../database/mysql.php');
include('../users/checksession.php');
if (!empty($_GET)) {
    if ($_GET['message'] == "car_created") {
        $message = "Car Inserted";
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
            margin: auto;
            /*            display: flex;
                        justify-content: center;
                        align-items: center;*/
        }

        .add_car_div{
            margin-top: 10px;
            margin-right: 20px;
        }
    </style>

    <script>
        $(document).ready(function () {
            $("#owner_dashboard").click(function () {
                window.location.href = "owner_dashboard.php";
            });
            $("#add_car").click(function () {
                window.location.href = "add_carform.php";
            });
            $('#car_table').dataTable();
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
                    <li class="nav-item active">
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
                    <button class="btn btn-secondary my-2 my-sm-0" type="button"  name="logout" id="logout">Logout</button>
                </form>
            </div>
        </nav>
        <div class="add_car_div">
            <button type="button" class="btn btn-primary btn-lg add_car" style="float: right" id="add_car">Add Car</button>
        </div>
        <div class="col-lg-9 dataTable">
            <table class="table table-hover" id="car_table">
                <thead>
                    <tr>
                        <th scope="col">Sr. No.</th>
                        <th scope="col">Car Model</th>
                        <th scope="col">Car Type</th>
                        <th scope="col">Daily Rate</th>
                        <th scope="col">Weekly Rate</th>
                        <th scope="col">Owner</th>
                        <th scope="col">Manufacturing Year</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $mysql = new mysql($db);

                    $car_details = $mysql->get_all_cars();
//                    echo '<pre>';
//                    print_r($owner_details);
//                    die;
                    for ($i = 0; $i < count($car_details); $i++) {
                        if ($i % 2 == 0) {
                            $row = "table-active";
                        } else {
                            $row = "table-default";
                        }
                        $owner_name = $mysql->get_owner_name_by_oid($car_details[$i]['oid']);
                        $car_type = $mysql->get_car_type_name($car_details[$i]['car_type']);
                        ?>
                        <tr class="<?php echo $row; ?>" id=<?php echo $car_details[$i]['vid']; ?>>
                            <th><?php echo $i + 1 ?></th>
                            <td><?php echo $car_details[$i]['model']; ?></td>
                            <td><?php echo $car_type[0]['ctype']; ?></td>
                            <td><?php echo $car_details[$i]['daily_rate']; ?></td>
                            <td><?php echo $car_details[$i]['weekly_rate']; ?></td>
                            <td><?php echo $owner_name[0]['owner_name']; ?></td>
                            <td><?php echo $car_details[$i]['cyear']; ?></td>

                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </body>
</html>
