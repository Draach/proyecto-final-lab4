<?php

namespace Utils;


class CustomSessionHandler
{

    public function createUserSession($user)
    {
        $_SESSION['loggedUser'] = $user;
    }

    public function getStudentId()
    {
        if ($this->isStudent()) {
            return $_SESSION['loggedUser']->getStudentId();
        }
    }

    public function getUserRole()
    {
        return $_SESSION['loggedUser']->getRoleId();
    }


    public function isAdmin()
    {
        $response = false;
        if (isset($_SESSION["loggedUser"])) {
            if ($_SESSION["loggedUser"]->getRoleId() == 2) {
                $response = true;
            }
        }
        return $response;
    }

    public function isStudent()
    {
        $response = false;
        if (isset($_SESSION["loggedUser"])) {
            if ($_SESSION["loggedUser"]->getRoleId() == 1) {
                $response = true;
            }
        }
        return $response;
    }

    public function Logout()
    {
        unset($_SESSION["loggedUser"]);
        session_destroy();
        require_once(VIEWS_PATH . "index.php");
    }

    public function userIsSet()
    {
        $result = false;
        if (isset($_SESSION["loggedUser"])) {
            $result = true;
        }

        return $result;
    }

    public function getEmail(){
        $result = "";
        if($this->userIsSet()){
            $result = $_SESSION["loggedUser"]->getEmail();
        }
        return $result;
    }
}
