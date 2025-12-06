<?php
include('connect.php');

mysqli_select_db($con, "SE_G3_A");

if (isset($_POST['btnR'])) {

    $fn    = $_POST['fn'];
    $age   = $_POST['age'];
    $sex   = $_POST['s'];
    $addr  = $_POST['addr'];
    $phone = $_POST['ph'];
    $email = $_POST['em'];

    // SQL query
    $query = "INSERT INTO members (Role, Full_Name, Age, Sex, Address, Phone_No, Email)
              VALUES (DEFAULT, '$fn', '$age', '$sex', '$addr', '$phone', '$email')";

    $execute = mysqli_query($con, $query);

    if ($execute) {
        echo "Registration completed successfully!<br>";
        echo "<a href='registration.html'>Back</a>";
    } else {
        echo "Error... Registration not completed.<br>";
        echo mysqli_error($con);
    }
}
