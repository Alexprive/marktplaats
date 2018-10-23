<!DOCTYPE html>
<html>
<title>Marktplaats</title>
<link rel="stylesheet" type="text/css" href="style.css">
<body>
<div class="header">
    <h1>Marktplaats</h1>
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
            <path d="M0,5 30,5" stroke="#fff" stroke-width="5"/>
            <path d="M0,14 30,14" stroke="#fff" stroke-width="5"/>
            <path d="M0,23 30,23" stroke="#fff" stroke-width="5"/>
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


<div class="row">
    <div class="column">
        <h4>Auto's</h4>
        <div class="ad">Advertentie 1 ruimte</div>
        <div class="ad">Advertentie 2 ruimte</div>
    </div>
    <div class="column">
        <h4>Witgoed</h4>
        <div class="ad">Advertentie ruimte</div>
    </div>
    <div class="column">
        <h4>Huis en Inrichting</h4>
        <div class="ad">Advertentie ruimte</div>
    </div>
</div>
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