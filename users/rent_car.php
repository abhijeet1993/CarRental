<?php

session_start();
include('../database/dbconfig.php');
include('../database/mysql.php');
include('../users/checksession.php');
//echo '<pre>';
//print_r($_POST);
//exit;
$rent_details['car_type'] = trim($_POST['car_type']);
$rent_details['rental_type'] = trim($_POST['rental_type']);
$rent_details['no_of_weeks_or_days'] = trim($_POST['weeks_or_days']);
$rent_details['start_date'] = trim($_POST['start_date']);

$_SESSION['rental_type'] = $rent_details['rental_type'];
if ($rent_details['rental_type'] == 1) {
    $_SESSION['no_of_weeks'] = $rent_details['no_of_weeks_or_days'];
    $duration = 7 * $rent_details['no_of_weeks_or_days'];
} else {
    $duration = $rent_details['no_of_weeks_or_days'];
    $_SESSION['no_of_days'] = $duration;
}

if ($rent_details['car_type'] == 7) {
    $where_condition = '';
} else {
    $car_type = $rent_details['car_type'];
    $where_condition = " and car_type = $car_type";
}
$return_date = date('Y-m-d', strtotime($rent_details['start_date'] . ' + ' . $duration . ' day'));

$_SESSION['start_date'] = $rent_details['start_date'];
$_SESSION['return_date'] = $return_date;

$mysql = new mysql($db);

$busy_cars = $mysql->get_busy_cars($rent_details, $where_condition, $return_date);
$temp_array = array();
foreach ($busy_cars as $key => $value) {
    array_push($temp_array, $value[0]);
}
//print_r($temp_array);
$busy_cars_string = implode(',', $temp_array);

if (empty($busy_cars_string) || $busy_cars_string == '') {//no cars are busy
    $not_in = '';
    if ($rent_details['car_type'] != 7) {//all car types are allowed
        $car_type = $rent_details['car_type'];
        $not_in = " where car_type = $car_type";
    }
} else {//some cars are busy
    $not_in = "where vid not in ($busy_cars_string)";
    if ($rent_details['car_type'] != 7) {//all car types are allowed
        $car_type = $rent_details['car_type'];
        $not_in .= " and car_type = $car_type";
    }
}
//echo $not_in;
//die;
$free_cars = $mysql->get_free_cars($not_in);
$_SESSION['free_cars'] = $free_cars;
$location = "display_free_cars.php";
header("Location: $location");
?>


