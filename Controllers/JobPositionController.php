<?php

namespace Controllers;

use DAO\JobPositionDAO as JobPositionDAO;
use DAO\CareerDAO as CareerDAO;
use Utils\CustomSessionHandler as CustomSessionHandler;

class JobPositionController
{
    private $jobPositionDAO;
    private $careerDAO;
    private $sessionHandler;

    public function __construct()
    {
        $this->jobPositionDAO = new JobPositionDAO();
        $this->careerDAO = new CareerDAO();
        $this->sessionHandler = new CustomSessionHandler();
    }

    public function ShowListView()
    {
        /**
         * Recupera la lista de propuestas laborales desde la API.
         */
        $jobPositionsList = $this->jobPositionDAO->GetAll();
        $careersList = $this->careerDAO->GetAll();

        if ($this->sessionHandler->isAdmin()) {
            require_once(VIEWS_PATH . "nav.php");
            require_once(VIEWS_PATH . "job-position-list.php");
        } else {
            require_once(VIEWS_PATH . "job-position-list.php");
        }
    }
}
