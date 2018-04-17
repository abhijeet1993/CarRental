<?php
session_start();

include('../database/dbconfig.php');
include('../database/mysql.php');
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

        .add_owner_div{
            margin-top: 10px;
            margin-right: 20px;
        }
    </style>

    <script>
        $(document).ready(function () {
            $("#add_owner").click(function () {
                window.location.href = "add_ownerform.php";
            });
            $("#car_dashboard").click(function () {
                window.location.href = "car_dashboard.php";
            });
            $('#owner_table').dataTable();
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
                    <li class="nav-item active">
                        <a class="nav-link owner_dashboard" href="#" id="owner_dashboard">Owner Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <div class="form-group row">
                        <label for="" class="col-md-8 col-form-label name">Welcome <?php echo $_SESSION['user_name'] ?></label>
                    </div>
                    <button class="btn btn-secondary my-2 my-sm-0" type="button" style="float:right">Logout</button>
                </form>
            </div>
        </nav>
        <div class="add_owner_div">
            <button type="button" class="btn btn-primary btn-lg add_owner" style="float: right" id="add_owner">Add Owner</button>
        </div>
        <div class="col-lg-9 dataTable">
            <table class="table table-hover" id="car_table">
                <thead>
                    <tr>
                        <th scope="col">Sr. No.</th>
                        <th scope="col">Owner Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Owner Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $mysql = new mysql($db);

                    $owner_details = $mysql->get_all_owners();
//                    echo '<pre>';
//                    print_r($owner_details);
//                    die;
                    for ($i = 0; $i < count($owner_details); $i++) {
                        if ($i % 2 == 0) {
                            $row = "table-active";
                        } else {
                            $row = "table-default";
                        }

                        if ($owner_details[$i]['owner_type'] == 1) {
                            $owner_type = "Individual";
                        } elseif ($owner_details[$i]['owner_type'] == 2) {
                            $owner_type = "Bank";
                        } else {
                            $owner_type = "Car Rental Company";
                        }
                        ?>
                        <tr class="<?php echo $row; ?>" id=<?php echo $owner_details[$i]['oid']; ?>>
                            <th><?php echo $i + 1 ?></th>
                            <td><?php echo $owner_details[$i]['owner_name']; ?></td>
                            <td><?php echo $owner_details[$i]['email']; ?></td>
                            <td><?php echo $owner_type; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </body>
</html>
