<?php

require_once 'core/init.php';

echo "<div class='maincontainer'>";

include 'header.php';

if (Input::exists()) {

    if(Token::check(Input::get('token'))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array('required' => true),
            'password' => array('required' => true)
        ));
        if($validation->passed()) {

            $user = new User();
            $remember = (Input::get('remember') === 'on') ? true : false;
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            if ($login) {
                Redirect::to('index.php');
            } else {
                echo "<p class='label label-danger'>Sorry, login is niet succesvol!</p><br><br>";
            }

        } else {
            foreach($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }

    }
}
?>
<div class="wrapper">
    <form class="" action="" method="post">

        <div class="field form-group">
            <label for="username">Gebruikersnaam</label>
            <input type="text" class="form-control" name="username" id="username" autocomplete="off">
        </div>

        <div class="field form-group">
            <label for="password">Wachtwoord</label>
            <input type="password" class="form-control" name="password" id="password" autocomplete="off">
        </div>

        <div class="field form-group">
            <label for="remember">
                <input class="" type="checkbox" name="remember" id="remember"> Onthoud mij
            </label>
        </div>

        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <input type="Submit" class="btn btn-primary" value="Login">
    </form>
</div>

<?php
include 'includes/footer.php';
?>