<?php
include "connect.php";

$dbName = "SE_G3_A";
mysqli_select_db($con, $dbName);

// Query
$data = "SELECT * FROM members";
$result = mysqli_query($con, $data);

if (!$result)
    die("Database access failed: " . mysqli_error($con));

$rows = mysqli_num_rows($result);

if ($rows) {

    while ($row = mysqli_fetch_array($result)) {

        echo "Full Name : " . $row["Full_Name"] . "<br>";
        echo "Age : " . $row["Age"] . "<br>";
        echo "Sex : " . $row["Sex"] . "<br>";
        echo "Address : " . $row["Address"] . "<br>";
        echo "Phone Number : " . $row["Phone_No"] . "<br>";
        echo "Email : " . $row["Email"] . "<br><br>";
    }
} else {
    echo "No data found.";
}

mysqli_close($con);
