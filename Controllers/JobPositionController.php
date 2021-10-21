<?php namespace Controllers;

    use DAO\JobPositionDAO as JobPositionDAO;
    use DAO\CareerDAO as CareerDAO;

class JobPositionController{
    private $jobPositionDAO;
    private $careerDAO;

    public function __construct() {
        $this->jobPositionDAO = new JobPositionDAO();
        $this->careerDAO = new CareerDAO();
    }

    public function ShowListView(){
        /**
         * Recupera la lista de propuestas laborales desde la API.
         */
        $jobPositionsList = $this->jobPositionDAO->GetAll();
        $careersList = $this->careerDAO->GetAll();        
        require_once(VIEWS_PATH."job-position-list.php");
    }

}

?>