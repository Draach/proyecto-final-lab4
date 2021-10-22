<?php

namespace Controllers;

use DAO\AdminDAO as AdminDAO;
use Models\Admin as Admin;
use Utils\CustomSessionHandler as CustomSessionHandler;

class AdminController
{
    private $adminDAO;
    private $sessionHandler;

    public function __construct()
    {
        $this->adminDAO = new AdminDAO();
        $this->sessionHandler = new CustomSessionHandler();
    }

    public function Add($firstName, $lastName, $dni, $gender, $birthDate, $email, $password, $phoneNumber)
    {
        $admin = new Admin();

        $encryptedPassword = password_hash($password, PASSWORD_BCRYPT);
        $admin->setFirstName(strtolower($firstName));
        $admin->setLastName(strtolower($lastName));
        $admin->setDni($dni);
        $admin->setGender($gender);
        $admin->setBirthDate($birthDate);
        $admin->setEmail(strtolower($email));
        $admin->setPassword($encryptedPassword);
        $admin->setPhoneNumber($phoneNumber);
        $admin->setActive(true);

        /**
         * Agrega un admin a la base de datos.
         */
        $this->adminDAO->Add($admin);
;
        if ($this->sessionHandler->isAdmin()) {
            require_once(VIEWS_PATH."nav.php");
            $this->ShowAddView();
        } else {
            require_once(VIEWS_PATH."index.php");
        }
    }

    public function List()
    {
        /**
         * Recupera la lista de admins desde la base de datos.
         */
        $adminsList = $this->adminDAO->GetAll();

        if ($this->sessionHandler->isAdmin()) {
            require_once(VIEWS_PATH."nav.php");
            require_once(VIEWS_PATH . "admin-list.php");
        } else {
            require_once(VIEWS_PATH."index.php");
        }
    }

    public function ShowAddView()
    {
        if ($this->sessionHandler->isAdmin()) {
            require_once(VIEWS_PATH."nav.php");
            require_once(VIEWS_PATH . "admin-add.php");
        } else {
            require_once(VIEWS_PATH."index.php");
        }
        
    }

    public function ShowDashboard()
    {
        if($this->sessionHandler->isAdmin()){
            require_once(VIEWS_PATH."nav.php");
        require_once(VIEWS_PATH . "admin-dashboard.php");
    } else {
        require_once(VIEWS_PATH."index.php");
    }
    }

    public function Remove()
    {
        if ($this->sessionHandler->isAdmin()) {
            require_once(VIEWS_PATH."nav.php");
            require_once(VIEWS_PATH . "admin-remove.php");
        } else {
            require_once(VIEWS_PATH."index.php");
        }
    }

    public function RemoveAdmin($number)
    {
        $message = "";

        /**
         * Remueve logicamente un admin de la base de datos (Status = false).
         */
        $response = $this->adminDAO->Delete($number);




        if ($response == 1) {
            $message = "El admin con ID " . $number . " ha sido eliminada exitosamente.";
        } else {
            $message = "El admin con ID " . $number . " no ha sido encontrada. Intente nuevamente.";
        }

        echo "<script type='text/javascript'>alert('$message');</script>";
        if ($this->sessionHandler->isAdmin()) {
            $this->Remove();
        } else {
            require_once(VIEWS_PATH."index.php");
        }        
    }
}
