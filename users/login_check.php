<?php

include("../app_top.php");
require_once '../database/mysql.php';
//echo '<pre>';
//print_r($_POST);
//die;
$email = $_POST['email'];
$password = $_POST['password'];
$logintype = $_POST['logintype'];
$mysql = new mysql($db);
$user_details = $mysql->validate_login($email, $password, $logintype);
//if ($user_details[0]['session_id'] != NULL || !empty($user_details[0]['session_id'])) {
//
//    $flag = $mysql->nullify_sessionid($user_details[0]['cid']);
//
//    $location = "../index.php";
//    header("Location: $location?message=session");
//}
if (!empty($user_details)) {
    session_start();
    $session_id = session_id();
    $_SESSION['user_name'] = $user_details[0]['cname'];
    $_SESSION['id'] = $user_details[0]['cid'];
    $_SESSION['email'] = $user_details[0]['email'];
    $_SESSION['logintype'] = $user_details[0]['logintype'];

    $mysql->update_session_id($user_details[0]['cid'], $session_id);

    if ($_SESSION['logintype'] == 2) {
        $location = "employee_dashboard.php";
        header("Location: $location");
    } elseif ($_SESSION['logintype'] == 1) {
        $location = "customer_dashboard.php";
        header("Location: $location");
    }
} else {
    $location = "../index.php";
    header("Location: $location?message=wrong");
}
?>


