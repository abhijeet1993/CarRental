<?php

session_start();
include('../database/dbconfig.php');
include('../database/mysql.php');
include('../users/checksession.php');
//echo '<pre>';
//print_r($_POST);

$rid = $_POST['rid'];

$mysql = new mysql($db);

$details = $mysql->update_rents_paid_by_rid($rid);

$location = "customer_dashboard.php";
header("Location: $location?message=payment");
?>
