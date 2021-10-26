<?php

namespace Controllers;

use DAO\CareerDAO as CareerDAO;

class CareerController
{
    private $careerDAO;

    public function __construct()
    {
        $this->careerDAO = new CareerDAO();
    }

    public function ShowListView()
    {
        /**
         * Recupera la lista de propuestas laborales desde la API.
         */
        $careersList = $this->careerDAO->GetAll();
        require_once(VIEWS_PATH . "career-list.php");
    }
}
