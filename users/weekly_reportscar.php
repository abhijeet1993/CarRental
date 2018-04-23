<?php

session_start();

include('../database/dbconfig.php');
include('../database/mysql.php');
include('../users/checksession.php');

$owner_details['car'] = trim($_POST['car']);
$owner_details['oid'] = trim($_SESSION['id']);
$owner_details['start_date'] = trim($_POST['start_date']);

$mysql = new mysql($db);

$rentals = $mysql->get_rentals_weekly_reports_car($owner_details);
//echo '<pre>';
//print_r($rentals);
//die;
$temp_array = array();
foreach ($rentals as $key => $value) {

    array_push($temp_array, $value['rid']);
}
$_SESSION['rids'] = $temp_array;
$_SESSION['start_date'] = $owner_details['start_date'];

$location = "display_weeklyrentals_car.php";
header("Location: $location");
?>


