//registration.php
<?php
include('connect.php');

// Ensure database exists and select it. If missing, try to create it.
$dbName = 'SE_G3_A';
$selected = false;
try {
    $selected = mysqli_select_db($con, $dbName);
} catch (Throwable $e) {
    $selected = false;
}

if (!$selected) {
    $createDbSql = "CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if (!mysqli_query($con, $createDbSql)) {
        die('Unable to create database: ' . htmlspecialchars(mysqli_error($con)));
    }
    try {
        if (!mysqli_select_db($con, $dbName)) {
            die('Unable to select database after creation: ' . htmlspecialchars(mysqli_error($con)));
        }
    } catch (Throwable $e) {
        die('Unable to select database after creation: ' . htmlspecialchars($e->getMessage()));
    }
}

mysqli_set_charset($con, 'utf8mb4');

// Ensure members table exists
$createTable = "CREATE TABLE IF NOT EXISTS `members` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Role` VARCHAR(64) DEFAULT NULL,
  `Full_Name` VARCHAR(255) NOT NULL,
  `Age` INT DEFAULT NULL,
  `Sex` VARCHAR(16) DEFAULT NULL,
  `Address` TEXT,
  `Phone_No` VARCHAR(32),
  `Email` VARCHAR(255),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
if (!mysqli_query($con, $createTable)) {
    die('Unable to ensure members table exists: ' . htmlspecialchars(mysqli_error($con)));
}

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
