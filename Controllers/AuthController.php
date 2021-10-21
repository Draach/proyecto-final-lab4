<?php namespace Controllers;

    use DAO\StudentDAO as StudentDAO;
    use DAO\AdminDAO as AdminDAO;

class AuthController{
    private $studentDAO;
    private $adminDAO;

    public function __construct() {
        $this->studentDAO = new StudentDAO();
        $this->adminDAO = new AdminDAO();
    }

    public function StudentLogin($email){
        $result = null;        
        
        $result = $this->studentDAO->Login($email);      
        
        if($result) {         
            session_start();
            $_SESSION['loggedUser'] = $result;
            $_SESSION['loggedUser']['role'] = "student";
            require_once(VIEWS_PATH."student-dashboard.php");
        }  else {
            $message = "<p class='message'>Usuario no encontrado. Por favor, intenta nuevamente.</p>";
            require_once(VIEWS_PATH."student-login.php");
        }        
    
    }

    public function AdminLogin($email, $password){
        $result = null;
        $result = $this->adminDAO->Login($email, $password);                
        if($result) {
            session_start();
            $_SESSION['loggedUser'] = $result;
            $_SESSION['loggedUser']['role'] = "admin";
            require_once(VIEWS_PATH."admin-dashboard.php");
        } else {
            $message = "<p class='message'>Hubo un error en tu combinación de correo y contraseña. Por favor, intenta nuevamente.</p>";
            require_once(VIEWS_PATH."admin-login.php");
        }   
    }

    public function Logout() {
        session_destroy();
        require_once(VIEWS_PATH."index.php");
    }
}

?>