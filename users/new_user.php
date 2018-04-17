<?php

include('../database/dbconfig.php');
include('../database/mysql.php');

$user_details['cname'] = trim($_POST['full_name']);
$user_details['email'] = trim($_POST['email']);
$user_details['password'] = trim($_POST['password']);
$user_details['confirm_password'] = trim($_POST['confirm_password']);
$user_details['phone'] = trim($_POST['phone_number']);
$user_details['logintype'] = 1; //1->customer
$mysql = new mysql($db);

$user_check_email = $mysql->get_user_by_email($user_details['email']);

if (!empty($user_check_email)) {
    $location = "new_userform.php?message=email";
    header("Location: $location");
} else {
    $user_details = $mysql->add_user($user_details);
}

if (!empty($user_details)) {
    $location = "../index.php";
    header("Location: $location?message=login_created");
} else {
    $location = "../index.php";
    header("Location: $location?message=wrong");
}
?>

