<?php

namespace Controllers;

use Utils\CustomSessionHandler as CustomSessionHandler;

class HomeController
{
    private $sessionHandler;

    public function __construct(){
        $this->sessionHandler = new CustomSessionHandler();
    }

    public function Index($message = "")
    {
        require_once(VIEWS_PATH . "index.php");
    }
}
