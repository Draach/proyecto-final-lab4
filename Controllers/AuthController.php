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

    public function Login($email, $password){
        $result = null;        
        
        $result = $this->studentDAO->Login($email);        
        if($result) {
            return $this->ShowStudentDashboard();
        }                         
        
        $result = $this->adminDAO->Login($email, $password);        
        if($result) {
            return $this->ShowAdminDashboard();
        }

        $message = "<p class='message'>Hubo un error en tu combinación de correo y contraseña. Por favor, intenta nuevamente.</p>";
        $this->Index($message);   
    }

    public function ShowStudentDashboard(){   
        require_once(VIEWS_PATH."student-dashboard.php");
    }

    public function ShowAdminDashboard(){
        require_once(VIEWS_PATH."admin-dashboard.php");
    }

    public function Index($message) {
        require_once(VIEWS_PATH."index.php");
    }
}

?>