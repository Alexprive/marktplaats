<?php

include'include/Dbc.php';
include'include/getCategorie.php';
include'include/showCategorie.php';
include'include/getAdd.php';
include'include/showAdd.php';

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Reporting E_NOTICE can be good too (to report uninitialized
// variables or catch variable name misspellings ...)
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);

// Report all PHP errors (see changelog)
error_reporting(E_ALL);

// Report all PHP errors
error_reporting(-1);

// Same as error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {

    require_once "config.php";

    /*$category_id = "";*/

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Marktplaats</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script>
        function showAdds(str) {
            if (str == "") {
                document.getElementById("addTable").innerHTML = "";
                return;
            } else {
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("addTable").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET","showadds.php?q="+str,true);
                xmlhttp.send();
            }
        }
    </script>
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

    <div id="main">
        <div class="col-md-3">
            <h3 style="color:white; background-color: black; padding: 5px; text-align: center;">Categoriën</h3>
            <?php
                $categorie = new showCategorie();
                $categorie->showAllCategories();
            ?>
        </div>
        <div class="col-md-9">
            <h3 style="color:white; background-color: black; padding: 5px; text-align: center;">Advertenties</h3>
            <?php
              $add = new showAdd();
              $add->showAlladds();
            ?>

        </div>
    </div>
</section>

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