<?php
require_once 'core/init.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Marktplaats</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/myScript.js"></script>
    <style>
        .wrapper{ width: 350px; padding: 20px; margin: auto; background-color: #ffffff; margin-top: 5%; border: 1px solid black; }
    </style>
</head>
<body>
<div class="wrap">

    <div class="head-container">
        <div class="box1">
            <img src="img/coin-300.png" width="30" height="30">
            <h1>Marktplaats</h1>
        </div>
        <div class="box2">
            <ul>
                <li><a href="#">Plaats advertentie</a></li>
            </ul>
        </div>
    </div>

    <div class="menu">
        <nav class="navibar">
            <!-- <ul class="navibar-nav">
                 <li><a href="index.php">Home</a></li>
                 <li><a href="#">Login</a></li>
                 <li><a href="#">Change password</a></li>
                 <li><a href="#">Logout</a></li>
                 <li><a href="#">registeren</a></li>
             </ul>-->

            <div id="navbar" class="collapse navbar-collapse">
                <!--<ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>-->


                <?php $user = new User(); if ($user->isLoggedIn()) { ?>
                <ul class="">
                    <li class=""><a href="index.php" class="" >Home <span class=""></span></a>

                        <ul class="">
                            <li><a href="profile.php?user=<?php echo escape($user->data()->username); ?>">Profiel <?php echo escape($user->data()->name); ?></a></li>
                            <li><a href="update.php">Wijzig</a></li>
                            <li><a href="changepassword.php">Wachtwoord wijzigen</a></li>
                            <li><a href="logout.php">Uitloggen</a></li>

                        </ul>

                    </li>
                </ul>
            <?php }
            else { ?>
                <ul class="">
                    <li><a href="login.php">Inloggen</a></li>
                    <li><a href="register.php">Registreren</a></li>
                </ul>
            <?php } ?>

            <span class="open-slide">
              <a href="#" onclick="openSlideMenu()">
                <svg width="30" height="30">
                  <path d="M0,5 30,5" stroke="#000" stroke-width="5"/>
                  <path d="M0,14 30,14" stroke="#000" stroke-width="5"/>
                  <path d="M0,23 30,23" stroke="#000" stroke-width="5"/>
                </svg>
              </a>
            </span>
        </nav>

        <div id="side-menu" class="side-nav">
            <div>
                <a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>
            </div>

            <div class="options">
                <a href="#" style="margin-top: 120px">Home</a>
                <a href="#">Login</a>
                <a href="#">Wachtwoord wijzigen</a>
                <a href="#">Logout</a>
                <a href="#">Registreren</a>
            </div>
        </div>
    </div>
</div>