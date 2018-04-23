<?php

if (empty($_SESSION)) {
    $location = "../index.php";
    header("Location: $location?message=Please_login");
}


