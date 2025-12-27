<?php
include "connect.php";

$dbName = "SE_G3_A";
if (!mysqli_select_db($con, $dbName)) {
    die('Could not select database: ' . htmlspecialchars(mysqli_error($con)));
}

mysqli_set_charset($con, 'utf8mb4');

// Query
$data = "SELECT * FROM members";
$result = mysqli_query($con, $data);

if (!$result) {
    die("Database access failed: " . htmlspecialchars(mysqli_error($con)));
}

echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Members</title>';
echo '<meta name="viewport" content="width=device-width,initial-scale=1">';
echo '<style>html,body{height:100%;margin:0;font-family:Arial,Helvetica,sans-serif;background:linear-gradient(135deg,#f5f7ff 0%,#eef2ff 100%);color:#111} .wrap{max-width:900px;margin:24px auto;padding:20px} .card{background:#fff;border-radius:12px;padding:18px;box-shadow:0 10px 30px rgba(20,20,50,0.06);border:1px solid rgba(16,24,40,0.04)} h1{margin-top:0;font-size:20px;color:#0f172a} .row{padding:12px 0;border-bottom:1px solid #f1f5f9} .row:last-child{border-bottom:0} .label{font-weight:600;color:#334155} .value{margin-top:6px;color:#0b1220}</style>';
echo '</head><body><div class="wrap"><div class="card"><h1>Members</h1>';

$rows = mysqli_num_rows($result);

if ($rows) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="row">';
        echo '<div class="label">Full Name</div>';
        echo '<div class="value">' . htmlspecialchars($row['Full_Name'] ?? '') . '</div>';
        echo '<div class="label">Age</div>';
        echo '<div class="value">' . htmlspecialchars($row['Age'] ?? '') . '</div>';
        echo '<div class="label">Sex</div>';
        echo '<div class="value">' . htmlspecialchars($row['Sex'] ?? '') . '</div>';
        echo '<div class="label">Address</div>';
        echo '<div class="value">' . nl2br(htmlspecialchars($row['Address'] ?? '')) . '</div>';
        echo '<div class="label">Phone Number</div>';
        echo '<div class="value">' . htmlspecialchars($row['Phone_No'] ?? '') . '</div>';
        echo '<div class="label">Email</div>';
        echo '<div class="value">' . htmlspecialchars($row['Email'] ?? '') . '</div>';
        echo '</div>';
    }
} else {
    echo '<div class="row">No data found.</div>';
}

echo '</div></div></body></html>';

mysqli_close($con);
