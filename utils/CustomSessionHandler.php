<?php

namespace Utils;


class CustomSessionHandler
{

    public function userIsSet()
    {
        $result = false;
        if (isset($_SESSION["loggedUser"])) {
            $result = true;
        }

        return $result;
    }

    public function createAdminUser($user)
    {
        $user->setRole('admin');
        $_SESSION['loggedUser'] = $user;
    }

    public function createStudentUser($user)
    {
        $user->setRole('student');
        $_SESSION['loggedUser'] = $user;
    }

    public function getLoggedStudentId()
    {
        if ($this->isStudent()) {
            return $_SESSION['loggedUser']->getStudentId();
        }
    }

    public function isAdmin()
    {
        $response = false;
        if (isset($_SESSION["loggedUser"])) {
            if ($_SESSION["loggedUser"]->getRole() == "admin") {
                $response = true;
            }
        }
        return $response;
    }

    public function isStudent()
    {
        $response = false;
        if (isset($_SESSION["loggedUser"])) {
            if ($_SESSION["loggedUser"]->getRole() == "student") {
                $response = true;
            }
        }
        return $response;
    }

    public function logout(){
        unset($_SESSION["loggedUser"]);
        session_destroy();        
        require_once(VIEWS_PATH . "index.php");
    }

    public function getLoggedUserName() {
        $response = false;
        if ($this->userisSet()) {
           $response = ucfirst($_SESSION["loggedUser"]->getFirstName()) . " " . ucfirst($_SESSION["loggedUser"]->getLastName());
        }
        return $response;
    }
}
