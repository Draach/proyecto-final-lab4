<?php

namespace Controllers;

use DAO\StudentDAO as StudentDAO;
use DAO\AdminDAO as AdminDAO;
use Utils\CustomSessionHandler as CustomSessionHandler;
use \Exception as Exception;

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
        try {
            try {
                $user = $this->studentDAO->Login($email, $password);
                $this->sessionHandler->createStudentUser($user);
                return require_once(VIEWS_PATH . "student-dashboard.php");
            } catch (Exception $ex) {
                $this->message = $ex->getMessage();
            }
            try {
                $user = $this->adminDAO->Login($email, $password);
                $this->sessionHandler->createAdminUser($user);
                require_once(VIEWS_PATH . "nav.php");
                return require_once(VIEWS_PATH . "admin-dashboard.php");
            } catch (Exception $ex) {
                $this->message = $ex->getMessage();
            } finally {
                $message = "<p class='message'>$this->message</p>";
                require_once(VIEWS_PATH . "index.php");
            }
        } catch (Exception $ex) {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    public function ShowRegisterView()
    {
        if ($this->sessionHandler->userIsSet() == false) {
            require_once(VIEWS_PATH . "register.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    public function Register($dni, $email, $password, $passwordConfirm)
    {

        try {
            $registeredStudent = $this->studentDAO->Register($dni, $email, $password, $passwordConfirm);
            if ($registeredStudent) {
                $this->sessionHandler->createStudentUser($registeredStudent);
                require_once(VIEWS_PATH . "student-dashboard.php");
            }
        } catch (Exception $ex) {
            $this->message = $ex->getMessage();
            $message = "<p class='message'>$this->message</p>";
            require_once(VIEWS_PATH . "register.php");
        }
    }

    public function Logout()
    {
        unset($_SESSION["loggedUser"]);
        session_destroy();
        $message = "";
        require_once(VIEWS_PATH . "index.php");
    }
}
