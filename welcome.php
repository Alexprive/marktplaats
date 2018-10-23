<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; background: #dce6e3;}
    </style>
</head>
<body>
<div class="page-header">
    <h1>Hallo, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. U bent al ingelogd!</h1>
</div>
<p>
    <a href="index.php" class="btn btn-primary">Terug naar de homepage</a>
    <a href="reset-password.php" class="btn btn-warning">Reset uw wachtwoord</a>
    <a href="logout.php" class="btn btn-danger">Uitloggen</a>
</p>
</body>
</html>