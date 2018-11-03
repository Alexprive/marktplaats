<?php

// Core Initialization
require_once 'core/init.php';

echo "<div class='maincontainer'>";

// Header
include 'header.php';

if (!$username = Input::get('user')) {
    Redirect::to('index.php');
} else {
    $user = new User($username);
    if (!$user->exists()) {
        Redirect::to(404);
    } else {
        //echo "User exists!";
        $data = $user->data();
    }
    ?>
<div class="wrapper">
    <h3><?php echo escape($data->name); ?></h3>
    <p>Gebruikersnaam: <?php echo escape($data->username); ?></p>
</div>

    <?php
}


echo "</div> <!-- //maincontainer -->";
include 'includes/footer.php';
