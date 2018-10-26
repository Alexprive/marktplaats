<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";

$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Nieuw wachtwoord invoeren alstublieft.";
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Wachtwoord moet tenminste 6 karakters hebben.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }

    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Wachtwoord bevestigen alstublieft.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Wachtwoord komt niet overeen.";
        }
    }

    if(empty($new_password_err) && empty($confirm_password_err)){
        $sql = "UPDATE users SET password = ? WHERE id = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            if(mysqli_stmt_execute($stmt)){
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Er ging iets mis. Probeer het later nog eens.";
            }
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <style type="text/css">
        body{ font: 14px sans-serif; background: #ffffff;}
        .wrapper{ width: 350px; padding: 20px; margin: auto; background-color: #ffffff; margin-top: 8%; border: 1px solid black; }
    </style>
</head>
<body>
<div class="header">
    <div class="headerlogo">
        <img src="img/coin-300.png" width="30" height="30" alt="">
        <h1>Marktplaats</h1>
    </div>
    <a href="placeadd.php"><button class="btn btn-primary" style="float: right; margin-top: -43px; margin-right: 30px;">Plaats advertentie</button></a>
</div>

<nav class="navbar">
    <ul class="navbar-nav">
        <li><a href="register.php">Registreren</a></li>
        <li><a href="login.php">Inloggen</a></li>
        <li><a href="reset-password.php">ww veranderen</a></li>
        <li><a href="logout.php">Uitloggen</a></li>
    </ul>

    <span class="open-slide">
      <a href="#" onclick="openSlideMenu()">
        <svg width="30" height="30">
            <path d="M0,5 30,5" stroke="#666" stroke-width="5"/>
            <path d="M0,14 30,14" stroke="#666" stroke-width="5"/>
            <path d="M0,23 30,23" stroke="#666" stroke-width="5"/>
        </svg>
      </a>
    </span>
</nav>

<div id="side-menu" class="side-nav">
    <a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>
    <a href="register.php">Registreren</a>
    <a href="login.php">Inloggen</a>
    <a href="reset-password.php">Wachtwoord veranderen</a>
    <a href="logout.php">Uitloggen</a>
</div>
<div class="wrapper">
    <h2>Reset Wachtwoord</h2>
    <p>Vul dit formulier in om uw wachtwoord te resetten.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
            <label>Nieuw wachtwoord</label>
            <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
            <span class="help-block"><?php echo $new_password_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Bevestig wachtwoord</label>
            <input type="password" name="confirm_password" class="form-control">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <a class="btn btn-link" href="welcome.php">Annuleren</a>
        </div>
    </form>
</div>

<script>
    function openSlideMenu(){
        document.getElementById('side-menu').style.width = '250px';
        document.getElementById('main').style.marginLeft = '250px';
    }

    function closeSlideMenu(){
        document.getElementById('side-menu').style.width = '0';
        document.getElementById('main').style.marginLeft = '0';
    }
</script>
</body>
</html>