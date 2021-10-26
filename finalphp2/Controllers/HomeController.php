<?php

namespace Controllers;

class HomeController
{
    public function Index($message = "")
    {
        require_once(VIEWS_PATH . "index.php");
    }

    public function AdminLogin()
    {
        require_once(VIEWS_PATH . "admin-login.php");
    }

    public function StudentLogin()
    {
        require_once(VIEWS_PATH . "student-login.php");
    }
}
