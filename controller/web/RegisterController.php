<?php

require_once('../../Model/DBconnect.php');
class RegisterController
{
    private $userDB;

    public function __construct()
    {
        $this->userDB = new UserDB();
    }

    public function index()
    {
    
    }

}