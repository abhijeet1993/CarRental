<?php

include("../app_top.php");
require_once '../database/mysql.php';
//echo '<pre>';
//print_r($_POST);
//die;
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$logintype = trim($_POST['logintype']);
$mysql = new mysql($db);
if ($logintype == 3) {
    $owner_details = $mysql->validate_owner_login($email, $password);
//    echo '<pre>';
//    print_r($owner_details);
//    echo (!empty($owner_details));
//    die;
    if (!empty($owner_details)) {
        session_start();
        $session_id = session_id();
        $_SESSION['user_name'] = $owner_details[0]['owner_name'];
        $_SESSION['id'] = $owner_details[0]['oid'];
        $_SESSION['email'] = $owner_details[0]['email'];
        $_SESSION['logintype'] = 3;
        $location = "owner_login_dashboard.php";
        header("Location: $location");
        die;
    } else {
        $location = "../index.php";
        header("Location: $location?message=wrong");
        die;
    }
}

$user_details = $mysql->validate_login($email, $password, $logintype);

if (!empty($user_details)) {
    session_start();
    $session_id = session_id();
    $_SESSION['user_name'] = $user_details[0]['cname'];
    $_SESSION['id'] = $user_details[0]['cid'];
    $_SESSION['email'] = $user_details[0]['email'];
    $_SESSION['logintype'] = $user_details[0]['logintype'];

    $mysql->update_session_id($user_details[0]['cid'], $session_id);

    if ($_SESSION['logintype'] == 2) {//employee login
        $location = "employee_dashboard.php";
        header("Location: $location");
    } elseif ($_SESSION['logintype'] == 1) {//customer login
        $location = "customer_dashboard.php";
        header("Location: $location");
    } elseif ($_SESSION['logintype'] == 3) {//ownerlogin
        $location = "owner_dashboard.php";
        header("Location: $location");
    }
} else {
    $location = "../index.php";
    header("Location: $location?message=wrong");
}
?>


