<?php

$server = "localhost";
$database = "car_rental";
$user = "root";
$pass = "";

$db = new PDO("mysql:host=$server;port=3306;dbname=$database;charset=utf8", "$user", "$pass");

