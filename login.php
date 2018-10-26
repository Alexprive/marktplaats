<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

require_once "config.php";

$username = $password = "";
$username_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["username"]))){
        $username_err = "Gebruikersnaam invoeren alstublieft.";
    } else{
        $username = trim($_POST["username"]);
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Wachtwoord invoeren alstublieft.";
    } else{
        $password = trim($_POST["password"]);
    }

    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = $username;

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            header("location: index.php");
                        } else{
                            $password_err = "Het wachtwoord dat u heeft ingevoerd is niet geldig.";
                        }
                    }
                } else{
                    $username_err = "Geen account gevonden met die gebruikersnaam.";
                }
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
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <style type="text/css">
        body{ font: 14px sans-serif; background: #ffffff;}
        .wrapper{ width: 350px; padding: 20px; margin: auto; background-color: #ffffff; margin-top: 5%; border: 1px solid black; }
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
    <h2>Login</h2>
    <p>Vul uw gegevens in om in te loggen.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Gebruikersnaam</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Wachtwoord</label>
            <input type="password" name="password" class="form-control">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
        <p>Heeft u nog geen account? <a href="register.php">Inschrijven</a>.</p>
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