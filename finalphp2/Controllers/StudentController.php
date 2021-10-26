<?php

namespace Controllers;

use DAO\StudentDAO as StudentDAO;
use Models\Student as Student;
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


    public function ShowDashboard()
    {

        if ($this->sessionHandler->isStudent()) {
            require_once(VIEWS_PATH . "student-dashboard.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    public function AcademicStatus()
    {
        if ($this->sessionHandler->isStudent()) {
            require_once(VIEWS_PATH . "student-academic-status.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }
}
