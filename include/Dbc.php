<?php

class Dbc{

    private $servername;
    private $username;
    private $password;
    private $dbname;

    protected function connect(){

        $this->servername = 'localhost';
        $this->username = 'root';
        $this->password = '12345678';
        $this->dbname = 'marktplaats';

        $conn =  new mysqli($this->servername, $this->username, $this->password, $this->dbname );

        if (mysqli_connect_errno()){
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        return $conn;

    }
}