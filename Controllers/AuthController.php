<?php

namespace Controllers;

use DAO\StudentDAO as StudentDAO;
use DAO\AdminDAO as AdminDAO;
use Utils\CustomSessionHandler as CustomSessionHandler;

class AuthController
{
    private $message;
    private $studentDAO;
    private $adminDAO;
    private $sessionHandler;

    public function __construct()
    {
        $this->studentDAO = new StudentDAO();
        $this->adminDAO = new AdminDAO();
        $this->sessionHandler = new CustomSessionHandler();
        $this->message = '';
    }

    public function Login($email, $password)
    {
        $user = null;

        $user = $this->studentDAO->Login($email);

        if ($user) {
            $this->message = "<p class='message'>Este usuario se encuentra desactivado.</p>";
            if ($user['active'] == true) {
                $this->sessionHandler->createStudentUser($user);
                return require_once(VIEWS_PATH . "student-dashboard.php");
            }
        }


        $user = $this->adminDAO->Login($email, $password);
        if ($user) {
            $this->message = "<p class='message'>Este usuario se encuentra desactivado.</p>";
            if ($user['active'] == true) {
                $this->sessionHandler->createAdminUser($user);
                require_once(VIEWS_PATH . "nav.php");
                return require_once(VIEWS_PATH . "admin-dashboard.php");
            }
        }
        if ($this->message == '') {
            $this->message = "<p class='message'>Usuario o contraseña incorrectos. Por favor, intenta nuevamente.</p>";
        }
        $message = $this->message;
        require_once(VIEWS_PATH . "index.php");
    }

    public function Logout()
    {
        unset($_SESSION["loggedUser"]);
        session_destroy();
        $message = "";
        require_once(VIEWS_PATH . "index.php");
    }
}
