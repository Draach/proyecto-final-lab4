<?php

namespace Controllers;

use Utils\CustomSessionHandler as CustomSessionHandler;
use DAO\RoleDAO as RoleDAO;

class RoleController
{
    private $sessionHandler;
    private $roleDAO;

    public function __construct(){
        $this->sessionHandler = new CustomSessionHandler();
        $this->roleDAO = new RoleDAO();
    }

    public function Index($message = "")
    {
        require_once(VIEWS_PATH . "index.php");
    }
    
}
