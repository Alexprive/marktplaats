<?php

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

    $titel = $category = $category_id = $description ="";
    $titel_err = $category_err = $description_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty(trim($_POST["titel"]))) {
            $titel_err = "U moet een titel invoeren.";
        } else {
            $titel = trim($_POST["titel"]);
        }

        if (empty(trim($_POST["category"]))) {
            $category_err = "U moet een categorie invoeren.";
        } else {
            $category = trim($_POST["category"]);
            $sql1 = mysqli_query($link, "SELECT category_id FROM categorys WHERE category = '$category' ");
            $row = mysqli_fetch_assoc($sql1);
            $category_id = $row["category_id"];
        }

        if (empty(trim($_POST["description"]))) {
            $category_err = "U moet een omschrijving invoeren.";
        } else {
            $description = trim($_POST["description"]);
        }

        if ($titel_err == '' and $category_err == '' and $description_err == ''){

            $sql2 = "INSERT INTO adds ( category_id, titel, description ) VALUES ('$category_id','$titel','$description')";

            if ($link->query($sql2) === TRUE) {
                echo "Advertentie succesvol toegevoegd";
                header("location: index.php");
            } else {
                echo "Fout: " . $sql2 . "<br>" . $link->error;
            }

            $link->close();
        }


    }
} else {
    header("location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Plaats advertentie</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <style type="text/css">
        body{ font: 14px sans-serif; background: #ffffff;}
        .wrapper{ width: 450px; padding: 20px; margin: auto; background-color: #ffffff; margin-top: 3%; border: 1px solid black; }
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
    <h2>Plaats advertentie</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <div class="form-group <?php echo (!empty($titel_err)) ? 'has-error' : ''; ?>">
            <label>Titel</label>
            <input type="text" name="titel" class="form-control" value="<?php echo $titel; ?>">
            <span class="help-block"><?php echo $titel_err; ?></span>
        </div>

        <div class="form-group <?php echo (!empty($category_err)) ? 'has-error' : ''; ?>">
           <label>Categorie</label>
           <select name="category" class="form-control" value="<?php echo $category; ?>">
               <option value=""></option>
               <?php
               $sql = mysqli_query($link, "SELECT category FROM categorys");
               while ($row = $sql->fetch_assoc()){
                   echo "<option value=\"{$row['category']}\">{$row['category']}</option>";
               }
               ?>
           </select>
           <span class="help-block"><?php echo $category_err; ?></span>
        </div>

        <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
            <label>Advertentie tekst</label>
            <textarea name="description" class="form-control" style="height: 130px;" value="<?php echo $description; ?>"></textarea>
            <span class="help-block"><?php echo $description_err; ?></span>
        </div>

        <div class="form-group">
           <input type="submit" class="btn btn-primary" value="Plaats advertentie">
        </div>
    </form>

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

</div>
</body>
</html>