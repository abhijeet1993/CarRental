<?php

session_start();

include('../database/dbconfig.php');
include('../database/mysql.php');
$mysql = new mysql($db);
$logout = $mysql->nullify_sessionid($_SESSION['id']);
session_destroy();
session_commit();

$location = "../index.php";
header("Location: $location");
?>

