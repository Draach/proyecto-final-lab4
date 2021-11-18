<?php

namespace Controllers;

use DAO\StudentDAO as StudentDAO;
use DAO\UserDAO as UserDAO;
use DAO\RoleDAO as RoleDAO;
use DAO\CompanyDAO as CompanyDAO;
use Utils\CustomSessionHandler as CustomSessionHandler;
use Models\User as User;

use \Exception as Exception;

class AuthController
{
    private $studentDAO;
    private $userDAO;
    private $sessionHandler;
    private $roleDAO;
    private $companyDAO;
    private $studentRole = 1;
    private $adminRole = 2;
    private $companyRole = 3;

    public function __construct()
    {
        $this->userDAO = new UserDAO();
        $this->studentDAO = new StudentDAO();
        $this->roleDAO = new RoleDAO();
        $this->companyDAO = new CompanyDAO();
        $this->sessionHandler = new CustomSessionHandler();
        $this->message = '';
    }

    /**
     * Recibe un correo electrónico y una contraseña para posteriormente autentificar al usuario.
     */
    public function Login($email, $password)
    {

        $to = "juliomissart.mdq@gmail.com";
        $subject = "Asunto del email";
        $message = "Este es mi primer envío de email con PHP";
        mail($to, $subject, $message);
        try {
            $user = $this->userDAO->GetUserByCredentials($email, $password);
            if ($user->getRoleId() == $this->studentRole && $user->getActive() == 1) {
                $this->studentDAO->studentVerifyForLogin($email);
                $this->sessionHandler->createUserSession($user);
                return require_once(VIEWS_PATH . 'student-dashboard.php');
            } else if ($user->getRoleId() == $this->adminRole && $user->getActive() == 1) {
                $this->sessionHandler->createUserSession($user);
                require_once(VIEWS_PATH . 'nav.php');
                return require_once(VIEWS_PATH . 'admin-dashboard.php');
            } else if ($user->getRoleId() == $this->companyRole && $user->getActive() == 1) {
                // TODO DASHBOARD COMPANY       
                require_once(VIEWS_PATH . 'student-dashboard.php');
            } else {
                $message = "El usuario no se encuentra activo.";
                return require_once(VIEWS_PATH . 'index.php');
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            require_once(VIEWS_PATH . "index.php");
        }
    }

    /**
     * Devuelve una vista con el formulario de registro.
     */
    public function ShowRegisterView()
    {
        if ($this->sessionHandler->userIsSet() == false) {
            $rolesList = $this->roleDAO->GetAll();
            require_once(VIEWS_PATH . "register.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    /**
     * Recibe los datos del formulario de registro, valida que el usuario exista en la API de la UTN
     * y si la validación es exitosa, procede a completar el registro en nuestra base de datos.
     */
    public function Register($dni, $email, $password, $passwordConfirm, $roleId)
    {
        $rolesList = $this->roleDAO->GetAll();
        try {
            if ($roleId == 1) {
                // Lo verificamos en la API
                $student = $this->studentDAO->studentVerify($dni, $email);

                // Si la verificacion de la password es correcta, procedemos a registrar al usuario en nuestra base de datos.
                if ($password == $passwordConfirm) {
                    $encryptedPassword = password_hash($password, PASSWORD_BCRYPT);
                    $user = new User();
                    $user->setEmail($email);
                    $user->setPassword($encryptedPassword);
                    $user->setRoleId($roleId);
                    $user->setStudentId($student->getStudentId());
                    $user->setActive(1);
                    $this->userDAO->Add($user);

                    // Creamos la sesión y lo mandamos al dashboard.
                    // TODO Agregar confirmación "Registrado con éxito."
                    $this->sessionHandler->createUserSession($user);
                    require_once(VIEWS_PATH . "student-dashboard.php");
                } else {
                    $message = "Las contraseñas no coinciden.";
                    require_once(VIEWS_PATH . "register.php");
                }
            } else if ($roleId == 3) {
                // TODO REGISTER COMPANY
                if ($this->companyDAO->cuitVerify(null, $dni) != 0) {
                    throw new Exception('El cuit ingresado ya existe.');
                }

                $encryptedPassword = password_hash($password, PASSWORD_BCRYPT);
                $user = new User();
                $user->setEmail($email);
                $user->setPassword($encryptedPassword);
                $user->setRoleId($roleId);
                $user->setActive(1);

                $this->sessionHandler->createUnregisteredUser($user);

                require_once(VIEWS_PATH . "company-add.php");
            }
        } catch (Exception $ex) { // Si ocurre algún error interno, lo reenviamos al registro indicando el error.
            $message = $ex->getMessage();
            require_once(VIEWS_PATH . "register.php");
        }
    }

    /**
     * Destruye la sesión actual y deslogea al usuario.
     */
    public function Logout()
    {
        $this->sessionHandler->Logout();
        $message = "";
        require_once(VIEWS_PATH . "index.php");
    }
}
