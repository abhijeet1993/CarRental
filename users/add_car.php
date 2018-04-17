<?php

include('../database/dbconfig.php');
include('../database/mysql.php');

$car_details['car_model'] = trim($_POST['car_model']);
$car_details['year'] = trim($_POST['year']);
$car_details['daily_rate'] = trim($_POST['daily_rate']);
$car_details['weekly_rate'] = trim($_POST['weekly_rate']);
$car_details['owner'] = trim($_POST['owner']);

$owner_details = explode('_', $car_details['owner']);
$car_details['owner_id'] = $owner_details[0];
$owner_type = $owner_details[1];
if ($owner_type == 1 || $owner_type == 2) {
    if ($_POST['lease_date'] == '' || empty($_POST['lease_date'])) {
        $car_details['lease_date'] = '2038-04-27';
    } else {
        $car_details['lease_date'] = trim($_POST['lease_date']);
    }
} else {
    $car_details['lease_date'] = null;
    
}

$mysql = new mysql($db);


$new_car_details = $mysql->add_car($car_details);


if (!empty($new_car_details)) {
    $location = "car_dashboard.php";
    header("Location: $location?message=car_created");
} else {
    $location = "add_carform.php";
    header("Location: $location?message=wrong");
}
?>


