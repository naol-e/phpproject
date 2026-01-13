<?php
include('connect.php');
mysqli_select_db($con, 'G3_SE_A');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login Form</title>

    <style type="text/css">
        a:link,
        a:visited {
            background-color: #f44336;
            color: white;
            padding: 14px 25px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        a:hover,
        a:active {
            background-color: red;
        }
    </style>

</head>

<body>

    <h1>Login Form</h1>
    <hr>

    <form method="post" action="">
        Username: <input type="text" name="un"><br><br>
        Password: <input type="password" name="pass"><br><br>
        <input type="submit" name="btnL" value="Login">
    </form>

</body>

</html>

<?php
if (isset($_POST['btnL'])) {

    $un = $_POST['un'];
    $pw = $_POST['pass'];

    
    $query = "SELECT User_Name, Password, NO FROM account WHERE 1";
    $execute = mysqli_query($con, $query);

    while ($rows = mysqli_fetch_array($execute)) {

        if ($un == $rows[0] && $pw == $rows[1]) {
            header("Location: registration.html");
            exit();
        }
    }

    echo "<script>alert('Username or password is incorrect');</script>";
}
?>