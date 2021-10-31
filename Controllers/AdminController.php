<?php

namespace Controllers;

use DAO\AdminDAO as AdminDAO;
use Models\Admin as Admin;
use Utils\CustomSessionHandler as CustomSessionHandler;
use Exception as Exception;

class AdminController
{
    private $adminDAO;
    private $sessionHandler;

    public function __construct()
    {
        $this->adminDAO = new AdminDAO();
        $this->sessionHandler = new CustomSessionHandler();
    }

    /**
     * Recibe los datos de un usuario y administrador y lo crea.
     */
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

        try {
            $this->adminDAO->Add($admin);
        } catch (Exception $ex) {
            $errMessage = $ex->getMessage();
            echo "<script type='text/javascript'>alert('Error: $errMessage');</script>";
        } finally {
            $this->ShowAddView();
        }

        
    }

    /**
     * Devuelve una lista de administradores.
     */
    // TODO - Implementar
    public function List()
    {
        /**
         * Recupera la lista de admins desde la base de datos.
         */
        $adminsList = $this->adminDAO->GetAll();

        if ($this->sessionHandler->isAdmin()) {
            require_once(VIEWS_PATH . "nav.php");
            require_once(VIEWS_PATH . "admin-list.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    /**
     * Devuelve una vista para crear un nuevo usuario administrador si se está logeado como administrador
     * o una vista para logearse si no se está logeado.
     */
    public function ShowAddView()
    {
        if ($this->sessionHandler->isAdmin()) {
            require_once(VIEWS_PATH . "nav.php");
            require_once(VIEWS_PATH . "admin-add.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }


    /**
     * Devuelve la vista del tablero de administrador si se está logeado como administrador.
     */
    public function ShowDashboard()
    {
        if ($this->sessionHandler->isAdmin()) {
            require_once(VIEWS_PATH . "nav.php");
            require_once(VIEWS_PATH . "admin-dashboard.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    /**
     * Devuelve la vista para remover un administrador si se está logeado como administrador.
     */
    public function Remove()
    {
        if ($this->sessionHandler->isAdmin()) {
            require_once(VIEWS_PATH . "nav.php");
            require_once(VIEWS_PATH . "admin-remove.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    /**
     * @param recibe un id de usuario administrador y lo elimina.
     */
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
            require_once(VIEWS_PATH . "index.php");
        }
    }
}
