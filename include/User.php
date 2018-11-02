<?php

class User extends Dbc
{
    private $id = "";
    private $username = "";
    private $password = "";
    private $new_password = "";
    private $confirm_password = "";
    public $username_err = "";
    public $password_err = "";
    public $new_password_err = "";
    public $confirm_password_err = "";

    public function __construct($id, $username, $password, $new_password, $confirm_password, $username_err, $password_err, $new_password_err, $confirm_password_err){

        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->new_password = $new_password;
        $this->confirm_password = $confirm_password;
        $this->username_err = $username_err;
        $this->password_err = $password_err;
        $this->new_password_err = $new_password_err;
        $this->confirm_password_err = $confirm_password_err;
    }

    public function checkRegistrationForm($username, $password, $confirm_password){

        if(empty(trim($username))){
            $this->username_err = "Gebruikersnaam invoeren alstublieft.";
        } else{
            $sql = "SELECT id FROM users WHERE username = ?";

            if($stmt = $this->db->prepare($sql)){

                $this->username = trim($username);

                $stmt->bind_param("s", $this->username);

                if($stmt->execute()){

                    $stmt->store_result();

                    if($stmt->num_rows == 1){
                        $this->username_err = "Deze gebruikersnaam is al in gebruik.";
                    } else{
                        $this->username = trim($username);
                    }
                } else{
                    echo "Oeps! Er ging iets mis, probeer het later nog eens!";
                }
            }

            $stmt->close();
        }

        if(empty(trim($password))){
            $this->password_err = "Wachtwoord invoeren alstublieft.";
        } elseif(strlen(trim($password)) < 6){
            $this->password_err = "Wachtwoord moet tenminste 6 karakters hebben.";
        } else{
            $this->password = trim($password);
        }

        if(empty(trim($confirm_password))){
            $this->confirm_password_err = "Wachtwoord bevestigen alstublieft.";
        } else{
            $this->confirm_password = trim($confirm_password);
            if(empty($password_err) && ($password != $confirm_password)){
                $this->confirm_password_err = "Wachtwoorden komen niet overeen.";
            }
        }


    }

    public function checkLoginForm($username, $password){

        if(empty(trim($username))){
            $this->username_err = "Gebruikersnaam invoeren alstublieft.";
        } else{
            $this->username = trim($username);
        }

        if(empty(trim($password))){
            $this->username_err = "Wachtwoord invoeren alstublieft.";
        } else{
            $this->password = trim($password);
        }

    }

    public function registerUser($username, $password){

        if(empty($this->username_err) && empty($this->password_err) && empty($this->confirm_password_err)){

            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

            if($stmt = $this->db->prepare($sql)){

                $this->username = $username;
                $this->password = password_hash($password, PASSWORD_DEFAULT);

                $stmt->bind_param("sss", $this->username, $this->password);

                if($stmt->execute()){
                    header("location: login.php");
                } else{
                    echo "Er ging iets mis. Probeer het later nog eens.";
                }
            }

            $stmt->close();
        }
    }

    public function loginUser($username, $password){

        if(empty($this->username_err) && empty($this->password_err)){

            $sql = "SELECT id, username, password FROM users WHERE username = ?";

            if($stmt = $this->db->prepare($sql)) {

                $this->username = trim($username);

                $stmt->bind_param("s", $this->username);

                if($stmt->execute()){
                    $stmt->store_result();

                    if($stmt->num_rows == 1){
                        $stmt->bind_result($stmt, $id, $username, $hashed_password);
                        if($stmt->fetch($stmt)){
                            if(password_verify($password, $hashed_password)){
                                session_start();

                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;

                                header("location: index.php");
                            } else{
                                $this->password_err = "Het wachtwoord dat u heeft ingevoerd is niet geldig.";
                            }
                        }
                    } else{
                        $this->username_err = "Geen account gevonden met die gebruikersnaam.";
                    }
                } else{
                    echo "Oeps! Er ging iets mis, probeer het later nog eens!";
                }
            }

            $stmt->close();
        }

    }

    public function resetPassword($id, $new_password, $confirm_password){

        if(empty(trim($new_password))){
            $this->new_password_err = "Nieuw wachtwoord invoeren alstublieft.";
        } elseif(strlen(trim($new_password)) < 6){
            $this->new_password_err = "Wachtwoord moet tenminste 6 karakters hebben.";
        } else{
            $this->new_password = trim($new_password);
        }

        if(empty(trim($confirm_password))){
            $this->confirm_password_err = "Wachtwoord bevestigen alstublieft.";
        } else{
            $this->confirm_password = trim($confirm_password);
            if(empty($this->new_password_err) && ($this->new_password != $this->confirm_password)){
                $this->confirm_password_err = "Wachtwoord komt niet overeen.";
            }
        }

        if(empty($this->new_password_err) && empty($this->confirm_password_err)){
            $sql = "UPDATE users SET password = ? WHERE id = ?";

            if($stmt = $this->db->prepare($sql)){

                $this->new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $this->id = $id;

                $stmt->bind_param("si", $this->new_password, $this->id);

                if($stmt->execute()){
                    session_destroy();
                    header("location: login.php");
                    exit();
                } else{
                    echo "Oops! Er ging iets mis. Probeer het later nog eens.";
                }
            }

            $stmt->close();
        }

    }


    public function showUser(){

        if($_SESSION["loggedin"] = true){

          $this->username =  $_SESSION["username"];

          return $this->username;
        }
    }

    public function logoutUser(){

        session_start();

        $_SESSION = array();

        session_destroy();

        header("location: index.php");
        exit;
    }

}