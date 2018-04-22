<?php

session_start();
include('../database/dbconfig.php');
include('../database/mysql.php');
include('../users/checksession.php');

//echo '<pre>';
//print_r($_SESSION);
//exit;

$mysql = new mysql($db);

$car_details = $mysql->get_car_by_vid($_POST['vid']);
$rental_details['vid'] = $_POST['vid'];
$rental_details['start_date'] = $_POST['start_date'];
$rental_details['return_date'] = $_POST['return_date'];
$rental_details['rental_type'] = $_POST['rental_type'];
$rental_details['cid'] = $_SESSION['id'];
$rental_details['total_cost'] = $_POST['total_cost'];
$rental_details['oid'] = $car_details[0]['oid'];
$rental_details['car_type'] = $car_details[0]['car_type'];

$rental_details = $mysql->insert_new_rental($rental_details);
if (!empty($rental_details)) {
    $location = "customer_dashboard.php";
    header("Location: $location?message=rental_created");
} else {
    $location = "rent_carform.php";
    header("Location: $location?message=wrong");
}
?>
