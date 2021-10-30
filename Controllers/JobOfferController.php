<?php

namespace Controllers;

use DAO\JobOfferDAO as JobOfferDAO;
use DAO\JobPositionDAO as JobPositionDAO;
use DAO\CompanyDAO as CompanyDAO;
use Models\JobOffer as JobOffer;
use Utils\CustomSessionHandler as CustomSessionHandler;
use Exception as Exception;

class JobOfferController
{
    private $companyDAO;
    private $jobOfferDAO;
    private $jobPositionDAO;    
    private $sessionHandler;

    public function __construct()
    {
        $this->companyDAO = new CompanyDAO();
        $this->jobOfferDAO = new JobOfferDAO();
        $this->jobPositionDAO = new JobPositionDAO();
        $this->sessionHandler = new CustomSessionHandler();
    }


    
    public function ShowAddView()
    {
        $jobPositionsList = $this->jobPositionDAO->GetAll();
        $companiesList = $this->companyDAO->GetAll();
        if ($this->sessionHandler->isAdmin()) {
            require_once(VIEWS_PATH . "nav.php");
            require_once(VIEWS_PATH . "job-offer-add.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    public function ShowListView()
    {

        $companiesList = $this->companyDAO->GetAll();        
        $jobOffersList = $this->jobOfferDAO->GetAll();
        $jobPositionsList = $this->jobPositionDAO->GetAll();

        if ($this->sessionHandler->isAdmin() || $this->sessionHandler->isStudent()) {
            if ($this->sessionHandler->isAdmin()) {
                require_once(VIEWS_PATH . "nav.php");
            }
            require_once(VIEWS_PATH . "job-offer-list.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    public function Add($title, $createdAt, $expirationDate, $salary, $companyId, $jobPositionId)
    {
        echo $title, $createdAt, $expirationDate, $salary, $companyId, $jobPositionId;
        $jobOffer = new JobOffer();
        $jobOffer->setTitle($title);
        $jobOffer->setCreatedAt($createdAt);
        $jobOffer->setExpirationDate($expirationDate);
        $jobOffer->setSalary($salary);
        $jobOffer->setCompanyId($companyId);
        $jobOffer->setJobPositionId($jobPositionId);   

        try {
            $this->jobOfferDAO->Add($jobOffer);
        } catch (Exception $ex) {
            $errMessage = $ex->getMessage();
            echo "<script type='text/javascript'>alert('Error: $errMessage');</script>";
        }

        $this->ShowAddView();
    }

    public function Delete($id) {
        if($this->sessionHandler->isAdmin()){
            $this->jobOfferDAO->delete($id);
            $this->ShowListView();    
        } else{
            require_once(VIEWS_PATH . "index.php");
        }
    }

    public function showModifyView($jobOfferId){
        if ($this->sessionHandler->isAdmin()) {
            $jobOffer = $this->jobOfferDAO->GetById($jobOfferId);
            require_once(VIEWS_PATH . "nav.php");
            require_once(VIEWS_PATH . "job-offer-modify.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    public function Modify($jobOfferId, $title ,$createdAt ,$expirationDate ,$salary)
    {        
        try {
            $response = $this->jobOfferDAO->Modify($jobOfferId, $title, $createdAt, $expirationDate, $salary);
            echo "<script type='text/javascript'>alert('Se ha modificado exitosamente.');</script>";
            $this->ShowModifyView($jobOfferId);
        } catch (Exception $ex) {
            $errMessage = $ex->getMessage();
            echo "<script type='text/javascript'>alert('Error: $errMessage');</script>";
            $this->ShowModifyView($jobOfferId);
        }        
    }
}