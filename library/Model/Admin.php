<?php

class Model_Admin {

    public $login;
    public $pass;

    public function __construct($login, $pass) {
        $this->login = $login;
        $this->pass = $pass;
    }

}

?>
