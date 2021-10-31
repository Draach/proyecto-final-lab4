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

    /**
     * Devuelve una vista para agregar una nueva propuesta laboral
     */
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

    /**
     * Devuelve una vista con la lista de propuestas laborales con su empresa y posición asociada.
     */
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

    /**
     * Recibe los datos de una nueva propuesta laboral y la agrega a la base de datos.
     */
    public function Add($title, $createdAt, $expirationDate, $salary, $companyId, $jobPositionId)
    {
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

    /**
     * Recibe el id de una propuesta laboral y la elimina de la base de datos.
     */
    public function Delete($id)
    {
        if ($this->sessionHandler->isAdmin()) {
            $this->jobOfferDAO->delete($id);
            $this->ShowListView();
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    /**
     * Recibe el id de una propuesta laboral y la devuelve en una vista para editarla.
     */
    public function ShowModifyView($jobOfferId)
    {
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
            $response = $this->jobOfferDAO->Modify($jobOfferId, $title, $createdAt, $expirationDate, $salary);
            echo "<script type='text/javascript'>alert('Se ha modificado exitosamente.');</script>";
            $this->ShowModifyView($jobOfferId);
        } catch (Exception $ex) {
            $errMessage = $ex->getMessage();
            echo "<script type='text/javascript'>alert('Error: $errMessage');</script>";
            $this->ShowModifyView($jobOfferId);
        }
    }

    /**
     * Recibe el ID de una propuesta laboral y devuelve una vista para que un estudiante pueda postularse a la misma.
     */
    public function PostulateView($jobOfferId)
    {
        $jobOffer = $this->jobOfferDAO->GetById($jobOfferId);
        require_once(VIEWS_PATH . "job-offer-postulation.php");
    }

    /**
     * Recibe el ID de una propuesta laboral, el ID de un estudiante, un comentario del estudiante y un archivo currículum.
     * Agrega una nueva postulación a la base de datos con los respectivos datos.
     */
    public function Postulate($jobOfferId, $studentId, $comment, $cvarchive)
    {

        $companiesList = $this->companyDAO->GetAll();
        $jobOffersList = $this->jobOfferDAO->GetAll();
        $jobPositionsList = $this->jobPositionDAO->GetAll();

        if ($this->jobOfferDAO->IsPostulated($studentId) == false) {
            // Recibe un archivo y lo sube a la carpeta uploads
            $message = $this->UploadArchive($cvarchive);

            // Guardamos la postulacion a la db
            $this->jobOfferDAO->AddPostulation($jobOfferId, $studentId, $comment, $cvarchive['name']);
            $message = "Postulacion realizada con exito ";
            require_once(VIEWS_PATH . "job-offer-list.php");
        } else {
            $message = "El usuario ya se encuentra postulado";
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
