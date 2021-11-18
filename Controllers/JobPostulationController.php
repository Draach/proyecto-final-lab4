<?php

namespace Controllers;

use DAO\JobOfferDAO as JobOfferDAO;
use DAO\JobPositionDAO as JobPositionDAO;
use DAO\JobPostulationDAO as JobPostulationDAO;
use DAO\StudentDAO as StudentDAO;
use Utils\CustomSessionHandler as CustomSessionHandler;
use Utils\fileUpload as fileUpload;
use Exception as Exception;
use Models\JobPostulation;

class JobPostulationController
{
    private $jobOfferDAO;
    private $jobPositionDAO;
    private $jobPostulationDAO;
    private $sessionHandler;
    private $studentDAO;
    private $fileUploader;
    private $message;

    public function __construct()
    {
        $this->jobOfferDAO = new JobOfferDAO();
        $this->jobPositionDAO = new JobPositionDAO();
        $this->jobPostulationDAO = new JobPostulationDAO();
        $this->sessionHandler = new CustomSessionHandler();
        $this->studentDAO = new StudentDAO();
        $this->fileUploader = new fileUpload();
        $this->message = "";
    }

    /**
     * Recibe el ID de una propuesta laboral y devuelve una vista para que un estudiante pueda postularse a la misma.
     */
    public function ShowPostulationView($jobOfferId)
    {
        $jobOffer = $this->jobOfferDAO->GetById($jobOfferId);
        $jobPositionsList = $this->jobPositionDAO->GetAll();
        require_once(VIEWS_PATH . "job-offer-postulation.php");
    }

    /**
     * Recibe el ID de una propuesta laboral, el ID de un estudiante, un comentario del estudiante y un archivo currículum.
     * Agrega una nueva postulación a la base de datos con los respectivos datos.
     */
    public function Add($jobOfferId, $studentId, $comment, $cvarchive)
    {
        $jobOffersList = $this->jobOfferDAO->GetAll();

        $postulatedJobOfferId = $this->jobPostulationDAO->IsPostulatedToSpecificOffer($this->sessionHandler->getStudentId());


        $jobPostulation = new JobPostulation();
        $jobPostulation->setJobOffer($this->jobOfferDAO->GetById($jobOfferId));
        $jobPostulation->setStudent($this->studentDAO->getById($studentId));
        $jobPostulation->setComment($comment);
        $jobPostulation->setCvArchive($cvarchive);
        $jobPostulation->setActive(true);
        if ($this->studentDAO->isActive($studentId)) {
            try {
                // Recibe un archivo y lo sube a la carpeta uploads
                $message = $this->fileUploader->UploadArchive($cvarchive);

                // Guardamos la postulacion a la db
                $this->jobPostulationDAO->Add($jobPostulation);
                $message = "Postulacion realizada con exito.";
                require_once(VIEWS_PATH . "job-offer-list.php");
            } catch (Exception $ex) {
                $message = $ex->getMessage();
                require_once(VIEWS_PATH . "job-offer-list.php");
            }
        } else {
            $message = "El usuario ha sido dado de baja.";
            $this->sessionHandler->logout();
        }
    }

    /**
     * Muestra el historial de postulaciónes de un estudiante.
     */
    public function ShowPostulationsHistory($studentId)
    {
        if ($this->sessionHandler->isStudent()) {
            $jobPostulationsList = $this->jobPostulationDAO->GetAllByStudentId($studentId);

            require_once(VIEWS_PATH . "student-postulations-history.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    /**
     * Recibe el ID de una propuesta laboral y el ID de un estudiante para eliminar la postulación activa
     */
    public function Remove($jobOfferId, $studentId, $email = null)
    {
        $jobOffersList = $this->jobOfferDAO->GetAll();
        $postulatedJobOfferId = $this->jobPostulationDAO->IsPostulatedToSpecificOffer($this->sessionHandler->getStudentId());
        try {
            $this->jobPostulationDAO->Remove($jobOfferId, $studentId);
            // Si quien elimino la postulación es el admin, se envía un correo notificando al estudiante.
            if($this->sessionHandler->isAdmin()){                                
                /** PARA VERIFICAR QUE FUNCIONE, AGREGAR UN EMAIL EXISTENTE */
                // $email = 'existentEmail@example.com';
                require_once(UTILS_PATH . "MailHandler.php");
            }
            $message = "Postulacion eliminada con exito.";
            require_once(VIEWS_PATH . "job-offer-list.php");            
        } catch (Exception $ex) {
            $message = "No se ha encontrado una postulación activa.";
            require_once(VIEWS_PATH . "job-offer-list.php");
        }
    }

}
