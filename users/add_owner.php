<?php

include('../database/dbconfig.php');
include('../database/mysql.php');

$owner_details['full_name'] = trim($_POST['full_name']);
$owner_details['email'] = trim($_POST['email']);
$owner_details['owner_type'] = trim($_POST['owner_type']);
;
$mysql = new mysql($db);

$owner_check_email = $mysql->get_owner_by_email($owner_details['email']);
if (!empty($owner_check_email)) {
    $location = "add_ownerform.php?message=email";
    header("Location: $location");
    die;
} else {
    $owner_details = $mysql->add_owner($owner_details);
}

if (!empty($owner_details)) {
    $location = "add_ownerform.php";
    header("Location: $location?message=owner_created");
} else {
    $location = "add_ownerform.php";
    header("Location: $location?message=wrong");
}
?>


