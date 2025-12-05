<?php
$host = "localhost";
$username = "root";
$password = "";
$con = mysqli_connect($host, $username, $password);

if (!$con) {
    die("Unable to connect: " . mysqli_error($con));
}
