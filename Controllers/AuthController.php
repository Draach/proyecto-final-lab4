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

    /**
     * Recibe un correo electrónico y una contraseña para posteriormente autentificar al usuario.
     */
    public function Login($email, $password)
    {
        $user = null;
        try {

            // Intenta validar el usuario contra la api de estudiantes y nuestra base de datos.
            // Si se valida exitosamente, crea una sesión de tipo estudiante y devuelve una vista al tablero de estudiante.
            try {
                // Si no se encuentra al usuario, arroja una excepción.
                $user = $this->studentDAO->Login($email, $password);
                $this->sessionHandler->createStudentUser($user);
                return require_once(VIEWS_PATH . "student-dashboard.php");
            } catch (Exception $ex) {
                $this->message = $ex->getMessage();
            }

            // Intenta validar el usuario contra nuestra tabla de administradores en la base de datos.
            // Si se valida exitosamente, crea una sesión de tipo administrador y devuelve una vista al tablero de administrador.
            try {
                // Busca al usuario administrador en la base de datos, si no lo encuentra devuelve una excepción.
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

    /**
     * Devuelve una vista con el formulario de registro.
     */
    public function ShowRegisterView()
    {
        if ($this->sessionHandler->userIsSet() == false) {
            require_once(VIEWS_PATH . "register.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    /**
     * Recibe los datos del formulario de registro, valida que el usuario exista en la API de la UTN
     * y si la validación es exitosa, procede a completar el registro en nuestra base de datos.
     */
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

    /**
     * Destruye la sesión actual y deslogea al usuario.
     */
    public function Logout()
    {
        unset($_SESSION["loggedUser"]);
        session_destroy();
        $message = "";
        require_once(VIEWS_PATH . "index.php");
    }
}
