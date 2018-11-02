<?php

class User{
    private $_db;

    public function __construct(){
        $this->_db = DB::getInstance();
    }

    public function create($fields = array()){
        try {
            $this->_db->insert('users', $fields);
        } catch (Exception $e) {
            echo $e;
        }
    }

}

public function login($username = null, $password = null, $remember = false)
{

    if (!$username && !$password && !$this->exists()) {
        // log user in
        Session::put($this->_sessionName, $this->data()->id);
    } else {

        $user = $this->find($username);
        //print_r($this->_data);]

        if($user) {
            if($this->data()->password === Hash::make($password, $this->data()->salt)) {
                //echo "Ok!";
                Session::put($this->_sessionName, $this->data()->id);
                if ($remember) {
                    $hash = Hash::unique();
                    $hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));
                    if (!$hashCheck->count()) {
                        $this->_db->insert('users_session', array(
                            'user_id' => $this->data()->id,
                            'hash' => $hash
                        ));
                    } else {
                        $hash = $hashCheck->first()->hash;
                    }
                    Cookie::put($this->_cookieName, $hash, Config::get('remember/cookir_expiry'));
                }
                return true;
            }
        }

    }

    return false;
}