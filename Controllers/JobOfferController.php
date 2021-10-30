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
    private $message;

    public function __construct()
    {
        $this->companyDAO = new CompanyDAO();
        $this->jobOfferDAO = new JobOfferDAO();
        $this->jobPositionDAO = new JobPositionDAO();
        $this->sessionHandler = new CustomSessionHandler();
        $this->message = "";
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

    public function postulateView($jobOfferId){
            $jobOffer = $this->jobOfferDAO->GetById($jobOfferId);
            require_once(VIEWS_PATH . "job-offer-postulation.php");
    }

    //Funcion que postula una Student a una jobOffer
    public function Postulate($jobOfferId, $studentId, $comment, $cvarchive){

        $companiesList = $this->companyDAO->GetAll();        
        $jobOffersList = $this->jobOfferDAO->GetAll();
        $jobPositionsList = $this->jobPositionDAO->GetAll();

        if($this->jobOfferDAO->isPostulated($studentId)==false){
            //Subimos el archivo a la carpeta
            $message =$this->uploadArchive($cvarchive);

            //Subimos la postulacion a la db
            $this->jobOfferDAO->addPostulation($jobOfferId, $studentId, $comment, $cvarchive['name']);
            $message = "Postulacion realizada con exito ";
            require_once(VIEWS_PATH . "job-offer-list.php");
        }else{
            $message = "El usuario ya se encuentra postulado";
            require_once(VIEWS_PATH . "job-offer-list.php");
        }
    }

    public function uploadArchive($cvarchive){
        try
        {
            //Obtenemos nombre del archivo, tipo, direccion temporal
            $fileName = $cvarchive["name"];
            $tempFileName = $cvarchive["tmp_name"];
            $type = $cvarchive["type"];

            $filePath = UPLOADS_PATH.basename($fileName);

            $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            //Obtenemos el peso
            $fileSize = filesize($tempFileName);

            //Si tiene datos
            if($fileSize !== false)
            {
                //Recibe el archivo, recibe la ruta a la que queremos moverlo 
                if (move_uploaded_file($tempFileName, $filePath))
                {
                    $this->message = "Archivo subido correctamente";
                }
                else
                $this->message = "Ocurrió un error al intentar subir el archivo";
            }
            else
            $this->message = "El archivo no corresponde a una imágen";               
        }    catch(Exception $ex){
                    
                    $this->message = $ex->getMessage();
                }

        finally{
            return $this->message;
        }

    }

}