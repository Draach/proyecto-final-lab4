<?php

namespace Controllers;

use DAO\CareerDAO as CareerDAO;
use DAO\CompanyDAO as CompanyDAO;
use DAO\JobOfferDAO as JobOfferDAO;
use DAO\JobPositionDAO as JobPositionDAO;
use DAO\JobPostulationDAO as JobPostulationDAO;
use DAO\StudentDAO as StudentDAO;
use Models\JobOffer as JobOffer;
use Utils\CustomSessionHandler as CustomSessionHandler;
use Utils\fileUpload as fileUpload;
use Exception as Exception;


class JobOfferController
{
    private $careerDAO;
    private $studentDAO;
    private $companyDAO;
    private $jobOfferDAO;
    private $jobPositionDAO;
    private $jobPostulationDAO;
    private $sessionHandler;
    private $fileUploader;

    public function __construct()
    {
        $this->careerDAO = new CareerDAO();
        $this->companyDAO = new CompanyDAO();
        $this->jobOfferDAO = new JobOfferDAO();
        $this->jobPositionDAO = new JobPositionDAO();
        $this->jobPostulationDAO = new JobPostulationDAO();
        $this->studentDAO = new StudentDAO();
        $this->sessionHandler = new CustomSessionHandler();
        $this->fileUploader = new fileUpload();
    }

    /**
     * Devuelve una vista para agregar una nueva propuesta laboral
     */
    public function ShowAddView()
    {
        $jobPositionsList = $this->jobPositionDAO->GetAll();
        foreach ($jobPositionsList as $key => $row) {
            $description[$key] = $row['description'];
        }
        array_multisort($description, SORT_ASC, $jobPositionsList);
        $companiesList = $this->companyDAO->GetAll();
        $careersList = $this->careerDAO->GetAll();
        if ($this->sessionHandler->isAdmin()) {
            require_once(VIEWS_PATH . "nav.php");
            require_once(VIEWS_PATH . "job-offer-add.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    /**
     * Devuelve una vista con la lista de propuestas laborales con su empresa y posición asociada.
     */
    public function ShowListView($message = null)
    {
        $jobOffersList = $this->jobOfferDAO->GetAll();
        $postulatedJobOfferId = $this->jobPostulationDAO->IsPostulatedToSpecificOffer($this->sessionHandler->getStudentId());

        if ($this->sessionHandler->isAdmin() || $this->sessionHandler->isStudent()) {
            if ($this->sessionHandler->isAdmin()) {
                require_once(VIEWS_PATH . "nav.php");
            }
            require_once(VIEWS_PATH . "job-offer-list.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    /**
     * Recibe los datos de una nueva propuesta laboral y la agrega ala base de datos.
     */
    public function Add($jobPositionId, $companyId, $title, $salary, $createdAt, $expirationDate, $flyer)
    {
        $timeNow = date("Y-m-d");

        $jobOffer = new JobOffer();

        $jobOffer->setTitle($title);
        $jobOffer->setCreatedAt($createdAt);
        $jobOffer->setExpirationDate($expirationDate);
        $jobOffer->setSalary($salary);
        $jobOffer->setCompany($this->companyDAO->GetById($companyId));
        $jobOffer->setJobPosition($this->jobPositionDAO->GetById($jobPositionId));
        $jobOffer->setFlyer($flyer);
        
        try {
            if ($expirationDate <= $timeNow) {
                throw new Exception('La fecha de expiración no puede ser anterior o igual a la fecha de hoy. Ingrese una fecha válida.');
            }

            $message = $this->fileUploader->UploadArchive($flyer);

            echo "<script type='text/javascript'>alert('Propuesta agregada exitosamente.');</script>";
            $this->jobOfferDAO->Add($jobOffer);
        } catch (Exception $ex) {
            $errMessage = $ex->getMessage();
            echo "<script type='text/javascript'>alert('Error: $errMessage');</script>";
        }

        $this->ShowAddView();
    }

    /**
     * Recibe el id de una propuesta laboral y la elimina de la base de datos.
     */
    public function Delete($id)
    {
        if ($this->sessionHandler->isAdmin()) {
            $this->jobOfferDAO->delete($id);      
            $emailsArray = $this->jobOfferDAO->GetPostulatedEmails($id);
            /** PARA VERIFICAR QUE FUNCIONE, AGREGAR UN EMAIL EXISTENTE */
            //array_push($emailsArray, "jmissart@gmail.com");
            require_once(UTILS_PATH . "MailHandler.php");
            $message = "La propuesta ha sido eliminada exitosamente.";
            $this->ShowListView($message);
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    /**
     * Recibe el id de una propuesta laboral y la devuelve en una vista para editarla.
     */
    public function ShowModifyView($jobOfferId)
    {
        $companiesList = $this->companyDAO->GetAll();
        $jobPositionsList = $this->jobPositionDAO->GetAll();

        if ($this->sessionHandler->isAdmin()) {
            $jobOffer = $this->jobOfferDAO->GetById($jobOfferId);
            require_once(VIEWS_PATH . "nav.php");
            require_once(VIEWS_PATH . "job-offer-modify.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    /**
     * Recibe los datos de una propuesta laboral y la modifica en la base de datos.
     */
    public function Modify($jobOfferId, $title, $createdAt, $expirationDate, $salary)
    {
        try {
            $jobOffer = new JobOffer();
            $jobOffer->setJobOfferId($jobOfferId);
            $jobOffer->setTitle($title);
            $jobOffer->setCreatedAt($createdAt);
            $jobOffer->setExpirationDate($expirationDate);
            $jobOffer->setSalary($salary);

            $response = $this->jobOfferDAO->Modify($jobOffer);

            echo "<script type='text/javascript'>alert('Se ha modificado exitosamente.');</script>";
            $this->ShowModifyView($jobOfferId);
        } catch (Exception $ex) {
            $errMessage = $ex->getMessage();
            echo "<script type='text/javascript'>alert('Error: $errMessage');</script>";
            $this->ShowModifyView($jobOfferId);
        }
    }

    public function GetByJobPositionDesc($jobPositionDesc)
    {
        if ($this->sessionHandler->isAdmin() || $this->sessionHandler->isStudent()) {
            $jobOffersList = $this->jobOfferDAO->temporaryGetByJobPositionDesc($jobPositionDesc);
            $jobPositionsList = $this->jobPositionDAO->GetAll();
            $companiesList = $this->companyDAO->GetAll();
            $careersList = $this->careerDAO->GetAll();
            $postulatedJobOfferId = $this->jobPostulationDAO->IsPostulatedToSpecificOffer($this->sessionHandler->getStudentId());

            if ($this->sessionHandler->isAdmin()) {
                require_once(VIEWS_PATH . "nav.php");
            }
            require_once(VIEWS_PATH . "job-offer-list.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    public function ShowJobOfferPostulations($jobOfferId)
    {
        if ($this->sessionHandler->isAdmin()) {
            try {
                $postulationsHistory = $this->jobOfferDAO->GetPostulationsByJobOfferId($jobOfferId);
                
            } catch (Exception $ex) {
                $postulationsHistory = null;                
            } finally {
                require_once(VIEWS_PATH . "nav.php");
                require_once(VIEWS_PATH . "job-offer-postulation-list.php");
            }
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }    

    public function GeneratePDF($jobOfferId) {
        $postulationsHistory = $this->jobOfferDAO->GetPostulationsByJobOfferId($jobOfferId);
        require_once(VIEWS_PATH . "fpdf-complete.php");
    }
}
