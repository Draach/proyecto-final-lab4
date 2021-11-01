<?php

namespace Controllers;

use DAO\JobOfferDAO as JobOfferDAO;
use DAO\JobPositionDAO as JobPositionDAO;
use DAO\JobPostulationDAO as JobPostulationDAO;
use DAO\CompanyDAO as CompanyDAO;
use Utils\CustomSessionHandler as CustomSessionHandler;
use Exception as Exception;
use Models\JobPostulation;

class JobPostulationController
{
    private $companyDAO;
    private $jobOfferDAO;
    private $jobPositionDAO;
    private $jobPostulationDAO;
    private $sessionHandler;
    private $message;

    public function __construct()
    {
        $this->companyDAO = new CompanyDAO();
        $this->jobOfferDAO = new JobOfferDAO();
        $this->jobPositionDAO = new JobPositionDAO();
        $this->jobPostulationDAO = new JobPostulationDAO();
        $this->sessionHandler = new CustomSessionHandler();
        $this->message = "";
    }

    /**
     * Recibe el ID de una propuesta laboral y devuelve una vista para que un estudiante pueda postularse a la misma.
     */
    public function ShowPostulationView($jobOfferId)
    {
        $jobOffer = $this->jobOfferDAO->GetById($jobOfferId);
        require_once(VIEWS_PATH . "job-offer-postulation.php");
    }

    /**
     * Recibe el ID de una propuesta laboral, el ID de un estudiante, un comentario del estudiante y un archivo currículum.
     * Agrega una nueva postulación a la base de datos con los respectivos datos.
     */
    public function Add($jobOfferId, $studentId, $comment, $cvarchive)
    {
        $companiesList = $this->companyDAO->GetAll();
        $jobOffersList = $this->jobOfferDAO->GetAll();
        $jobPositionsList = $this->jobPositionDAO->GetAll();
        $isPostulated = $this->jobPostulationDAO->IsPostulatedToSpecificOffer($this->sessionHandler->getLoggedStudentId());  

        $jobPostulation = new JobPostulation();
        $jobPostulation->setJobOfferId($jobOfferId);
        $jobPostulation->setStudentId($studentId);
        $jobPostulation->setComment($comment);
        $jobPostulation->setCvArchive($cvarchive);        
        try {
            // Recibe un archivo y lo sube a la carpeta uploads
            $message = $this->UploadArchive($cvarchive);

            // Guardamos la postulacion a la db
            $this->jobPostulationDAO->Add($jobPostulation);
            $message = "Postulacion realizada con exito ";
            require_once(VIEWS_PATH . "job-offer-list.php");
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            require_once(VIEWS_PATH . "job-offer-list.php");
        }
    }

    /**
     * Recibe el ID de una propuesta laboral y el ID de un estudiante para eliminar la postulación activa
     */
    public function Remove($jobOfferId, $studentId)
    {
        $companiesList = $this->companyDAO->GetAll();
        $jobOffersList = $this->jobOfferDAO->GetAll();
        $jobPositionsList = $this->jobPositionDAO->GetAll();
        $isPostulated = $this->jobPostulationDAO->IsPostulatedToSpecificOffer($this->sessionHandler->getLoggedStudentId());  
        try {        
            $this->jobPostulationDAO->Remove($jobOfferId, $studentId);
            $message = "Postulacion eliminada con exito";
            require_once(VIEWS_PATH . "job-offer-list.php");
        } catch (Exception $ex) {
            $message = "No se ha encontrado una postulación activa.";
            require_once(VIEWS_PATH . "job-offer-list.php");
        }
    }

    //? ######## MÉTODOS PARA GESTIONAR LA POSTULACIÓN ########
    /**
     * Recibe un archivo y lo guarda en la carpeta uploads del proyecto.
     */
    public function UploadArchive($cvarchive)
    {
        try {
            // Obtenemos nombre del archivo, tipo, direccion temporal
            $fileName = $cvarchive["name"];
            $type = $cvarchive["type"];
            $tempFileName = $cvarchive["tmp_name"];

            $filePath = UPLOADS_PATH . basename($fileName);

            $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            // Obtenemos el peso del archivo
            $fileSize = filesize($tempFileName);

            // Si tiene datos
            if ($fileSize !== false) {
                // Recibe el archivo, recibe la ruta a la que queremos moverlo 
                if (move_uploaded_file($tempFileName, $filePath)) {
                    $this->message = "Archivo subido correctamente";
                } else {
                    $this->message = "Ocurrió un error al intentar subir el archivo";
                }
            } else {
                $this->message = "El archivo no corresponde a una imágen";
            }
        } catch (Exception $ex) {
            $this->message = $ex->getMessage();
        } finally {
            return $this->message;
        }
    }
}
