<?php


class Evaluation extends Dbc
{
    public $username_err = "";
    public $password_err = "";
    public $new_password_err = "";
    public $confirm_password_err = "";

    public function __construct($username_err, $password_err, $new_password_err, $confirm_password_err){

        $this->username_err = $username_err;
        $this->password_err = $password_err;
        $this->new_password_err = $new_password_err;
        $this->confirm_password_err = $confirm_password_err;

    }


}

?>