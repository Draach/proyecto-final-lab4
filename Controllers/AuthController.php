<?php

namespace Controllers;

use DAO\StudentDAO as StudentDAO;
use DAO\AdminDAO as AdminDAO;

class AuthController
{
    private $studentDAO;
    private $adminDAO;

    public function __construct()
    {
        $this->studentDAO = new StudentDAO();
        $this->adminDAO = new AdminDAO();
    }

    public function Login($email, $password)
    {
        $result = null;

        $result = $this->studentDAO->Login($email);

        if ($result) {

            $_SESSION['loggedUser'] = $result;
            $_SESSION['loggedUser']['role'] = "student";
            return require_once(VIEWS_PATH . "student-dashboard.php");
        }


        $result = $this->adminDAO->Login($email, $password);
        if ($result) {

            $_SESSION['loggedUser'] = $result;
            $_SESSION['loggedUser']['role'] = "admin";
            return require_once(VIEWS_PATH . "admin-dashboard.php");
        }

        $message = "<p class='message'>La combinación de usuario/contraseña es incorrecta. Por favor, intenta nuevamente.</p>";
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
