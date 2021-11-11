<?php

namespace Controllers;

use DAO\StudentDAO as StudentDAO;
use Utils\CustomSessionHandler as CustomSessionHandler;

class StudentController
{
    private $studentDAO;
    private $sessionHandler;

    public function __construct()
    {
        $this->studentDAO = new StudentDAO();
        $this->sessionHandler = new CustomSessionHandler();
    }
    
    /**
     * Devuelve la vista de tablero de un estudiante.
     */
    public function ShowDashboard()
    {

        if ($this->sessionHandler->isStudent()) {
            require_once(VIEWS_PATH . "student-dashboard.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    /**
     * Devuelve la vista de perfil de un estudiante.
     */
    public function AcademicStatus()
    {
        if ($this->sessionHandler->isStudent()) {
            $student = $this->studentDAO->GetAcademicStatusByStudentId($this->sessionHandler->getStudentId());
            require_once(VIEWS_PATH . "student-academic-status.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }
}
