<?php

namespace Controllers;

use DAO\CareerDAO as CareerDAO;
use DAO\CompanyDAO as CompanyDAO;
use DAO\JobOfferDAO as JobOfferDAO;
use DAO\JobPositionDAO as JobPositionDAO;
use DAO\JobPostulationDAO as JobPostulationDAO;
use DAO\StudentDAO as StudentDAO;
use Utils\CustomSessionHandler as CustomSessionHandler;
use Exception as Exception;
use Models\JobPostulation;

class JobPostulationController
{
    private $careerDAO;
    private $companyDAO;
    private $jobOfferDAO;
    private $jobPositionDAO;
    private $jobPostulationDAO;
    private $sessionHandler;
    private $studentDAO;
    private $message;

    public function __construct()
    {
        $this->careerDAO = new CareerDAO();
        $this->companyDAO = new CompanyDAO();
        $this->jobOfferDAO = new JobOfferDAO();
        $this->jobPositionDAO = new JobPositionDAO();
        $this->jobPostulationDAO = new JobPostulationDAO();
        $this->sessionHandler = new CustomSessionHandler();
        $this->studentDAO = new StudentDAO();
        $this->message = "";
    }

    /**
     * Recibe el ID de una propuesta laboral y devuelve una vista para que un estudiante pueda postularse a la misma.
     */
    public function ShowPostulationView($jobOfferId)
    {
        $jobOffer = $this->jobOfferDAO->GetById($jobOfferId);
        $companiesList = $this->companyDAO->GetAll();
        $jobPositionsList = $this->jobPositionDAO->GetAll();
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
        $careersList = $this->careerDAO->GetAll();
        $postulatedJobOfferId = $this->jobPostulationDAO->IsPostulatedToSpecificOffer($this->sessionHandler->getStudentId());

        
        $jobPostulation = new JobPostulation();
        $jobPostulation->setJobOffer($this->jobOfferDAO->GetById($jobOfferId));
        $jobPostulation->setStudent($this->studentDAO->getById($studentId));
        $jobPostulation->setComment($comment);
        $jobPostulation->setCvArchive($cvarchive);
        if ($this->studentDAO->isActive($studentId)) {
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
            $companiesList = $this->companyDAO->GetAll();
            $jobOffersList = $this->jobOfferDAO->GetAll();
            $jobPositionsList = $this->jobPositionDAO->GetAll();
            $student = $this->studentDAO->GetAcademicStatusByStudentId($this->sessionHandler->getStudentId());
            require_once(VIEWS_PATH . "student-postulations-history.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
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
        $careersList = $this->careerDAO->GetAll();
        $postulatedJobOfferId = $this->jobPostulationDAO->IsPostulatedToSpecificOffer($this->sessionHandler->getStudentId());
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
