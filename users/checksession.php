<?php

if (empty($_SESSION)) {
    $location = "../index.php";
    header("Location: $location?message=Please_login");
}

    


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

