<?php
include('connect.php');

mysqli_select_db($con, "SE_G3_A");

if (isset($_POST['btnR'])) {

    $fn    = trim($_POST['fn'] ?? '');
    $age   = trim($_POST['age'] ?? '');
    $sex   = trim($_POST['s'] ?? '');
    $addr  = trim($_POST['addr'] ?? '');
    $phone = trim($_POST['ph'] ?? '');
    $email = trim($_POST['em'] ?? '');

    // Basic server-side validation
    $errors = [];

    if ($fn === '') {
        $errors[] = 'Full name is required.';
    }

    if (!ctype_digit($age) || (int)$age < 0) {
        $errors[] = 'Age must be a non-negative integer.';
    } else {
        $age = (int)$age;
    }

    $allowedSex = ['Male', 'Female'];
    if (!in_array($sex, $allowedSex, true)) {
        $errors[] = 'Invalid sex selection.';
    }

    if ($addr === '') {
        $errors[] = 'Address is required.';
    }

    // Phone should match the client-side pattern: digits, +, -, spaces (7-15 chars)
    if (!preg_match('/^[0-9+\- ]{7,15}$/', $phone)) {
        $errors[] = 'Phone number is invalid. Use digits, "+", "-" or spaces (7-15 chars).';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address.';
    }

    if (!empty($errors)) {
        foreach ($errors as $err) {
            echo htmlspecialchars($err) . "<br>";
        }
        echo "<a href='registration.html'>Back</a>";
        exit();
    }

    // Use prepared statement to avoid SQL injection
    $stmt = mysqli_prepare($con, "INSERT INTO members (Role, Full_Name, Age, Sex, Address, Phone_No, Email) VALUES (DEFAULT, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        echo 'Database error: ' . htmlspecialchars(mysqli_error($con));
        exit();
    }

    mysqli_stmt_bind_param($stmt, 'sissss', $fn, $age, $sex, $addr, $phone, $email);
    $exec = mysqli_stmt_execute($stmt);

    if ($exec) {
        echo "Registration completed successfully!<br>";
        echo "<a href='registration.html'>Back</a>";
    } else {
        echo "Error... Registration not completed.<br>";
        echo htmlspecialchars(mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
}
