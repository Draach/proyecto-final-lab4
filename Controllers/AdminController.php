<?php

namespace Controllers;

use DAO\UserDAO as UserDAO;
use Models\User as User;
use Utils\CustomSessionHandler as CustomSessionHandler;
use Exception as Exception;

class AdminController
{
    private $userDAO;
    private $sessionHandler;
    private $adminRole = 2;

    public function __construct()
    {
        $this->userDAO = new UserDAO();
        $this->sessionHandler = new CustomSessionHandler();
    }

    /**
     * Recibe los datos de un usuario y administrador y lo crea.
     */
    public function Add($email, $password)
    {
        $user = new User();

        $encryptedPassword = password_hash($password, PASSWORD_BCRYPT);
        $user->setEmail($email);
        $user->setPassword($encryptedPassword);
        $user->setRoleId($this->adminRole);        

        try {
            $this->userDAO->Add($user);
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
    public function ShowListView()
    {
        /**
         * Recupera la lista de admins desde la base de datos.
         */
        $usersList = $this->userDAO->GetAllUsers();

        if ($this->sessionHandler->isAdmin()) {
            require_once(VIEWS_PATH . "nav.php");
            require_once(VIEWS_PATH . "user-list.php");
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
    public function RemoveAdmin($userId)
    {
        $message = "";

        /**
         * Remueve logicamente un admin de la base de datos (Status = false).
         */
        $response = $this->userDAO->Remove($userId);

        if ($response == 1) {
            $message = "El usuario con ID " . $userId . " ha sido eliminada exitosamente.";
        } else {
            $message = "El usuario con ID " . $userId . " no ha sido encontrado. Intente nuevamente.";
        }

        echo "<script type='text/javascript'>alert('$message');</script>";
        if ($this->sessionHandler->isAdmin()) {
            $this->Remove();
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }
}
