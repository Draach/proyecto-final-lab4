<?php namespace Controllers;

    use DAO\StudentDAO as StudentDAO;
    use Models\Student as Student;

class StudentController{
    private $studentDAO;

    public function __construct() {
        $this->studentDAO = new StudentDAO();
    }
    

    public function ShowDashboard(){   
        require_once(VIEWS_PATH."student-dashboard.php");
    }

    public function AcademicStatus() {
        require_once(VIEWS_PATH."student-academic-status.php");
    }
}

?>