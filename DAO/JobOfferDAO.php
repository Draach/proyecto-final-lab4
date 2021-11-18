<?php

namespace DAO;

use \Exception as Exception;
use DAO\Connection as Connection;
use DAO\IJobOfferDAO as IJobOfferDAO;
use DAO\JobPositionDAO as JobPositionDAO;
use DAO\CompanyDAO as CompanyDAO;
use DAO\StudentDAO as StudentDAO;
use DAO\CareerDAO as CareerDAO;
use Models\JobOffer as JobOffer;
use Models\Company as Company;
use Models\JobPostulation;

class JobOfferDAO implements IJobOfferDAO
{
    private $connection;
    private $tableName = "job_offers";
    private $companyDAO;
    private $jobPositionDAO;
    private $careerDAO;
    private $studentDAO;

    public function __construct()
    {
        $this->jobPositionDAO = new JobPositionDAO();
        $this->companyDAO = new CompanyDAO();
        $this->studentDAO = new StudentDAO();
        $this->careerDAO = new CareerDAO();
    }

    /**
     * Recibe una propuesta laboral y la agrega a la base de datos.
     */
    function Add(JobOffer $jobOffer)
    {
        try {
            /*
            $response = $this->cuitVerify(null, $company->getCuit());

            if ($response == 1) {
                throw new Exception('El cuit ingresado ya existe.');
            }
            */

            $query = "INSERT INTO " . $this->tableName . " (title, createdAt, expirationDate, salary, companyId, jobPositionId, flyerName, active) VALUES (:title, :createdAt, :expirationDate, :salary, :companyId, :jobPositionId, :flyerName, :active);";

            $parameters["title"] = $jobOffer->getTitle();
            $parameters["createdAt"] = $jobOffer->getCreatedAt();
            $parameters["expirationDate"] = $jobOffer->getExpirationDate();
            $parameters["salary"] = $jobOffer->getSalary();
            $parameters["companyId"] = $jobOffer->getCompany()->getCompanyId();
            $parameters["jobPositionId"] = $jobOffer->getJobPosition()->getJobPositionId();
            $parameters["flyerName"] = $jobOffer->getFlyer()['name'];
            $parameters["active"] = $jobOffer->getActive();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {

            throw $ex;
        }
    }

    /**
     * Busca y retorna todas las propuestas laborales de la base de datos.
     */
    function GetAll()
    {
        try {
            $jobOffersList = array();

            $query = "call get_all_job_offers()";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $jobOffer = new JobOffer();
                $company = new Company();

                //Seteo de Company
                $company->setName($row["companyName"]);
                $company->setCompanyId($row["companyId"]);
                $company->setEmail($row["email"]);
                $company->setPhone($row["phone"]);
                $company->setAddress($row["address"]);
                $company->setCuit($row["cuit"]);
                $company->setWebsite($row["website"]);
                $company->setFounded($row["founded"]);
                $company->setStatus($row["status"]);


                $jobOffer->setJobOfferId($row["jobOfferId"]);
                $jobOffer->setTitle($row["title"]);
                $jobOffer->setCreatedAt($row["createdAt"]);
                $jobOffer->setExpirationDate($row["expirationDate"]);
                $jobOffer->setSalary($row["salary"]);
                $jobOffer->setCompany($company);
                $jobOffer->setJobPosition($this->jobPositionDAO->getById($row["jobPositionId"]));                
                $jobOffer->setFlyer($row['flyer']);
                $jobOffer->setActive($row["active"]);


                array_push($jobOffersList, $jobOffer);
            }
            return $jobOffersList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Recibe el id de una propuesta laboral, la busca en la base de datos y devuelve la propuesta laboral.
     */
    public function GetById($number)
    {
        try {
            $jobOffersList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE `jobOfferId` = :number";

            $parameters["number"] = $number;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            if ($resultSet == null) {
                throw new Exception("No se encontró la propuesta laboral.");
            }

            foreach ($resultSet as $row) {
                $jobOffer = new JobOffer();
                $jobOffer->setJobOfferId($row["jobOfferId"]);
                $jobOffer->setTitle($row["title"]);
                $jobOffer->setCreatedAt($row["createdAt"]);
                $jobOffer->setExpirationDate($row["expirationDate"]);
                $jobOffer->setSalary($row["salary"]);
                $jobOffer->setCompany($this->companyDAO->GetById($row["companyId"]));
                $jobOffer->setJobPosition($this->jobPositionDAO->GetById($row["jobPositionId"]));
                array_push($jobOffersList, $jobOffer);
            }
            return $jobOffersList[0];
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    function temporaryGetByJobPositionDesc($jobPositionDesc)
    {
        try {

            $jobOffersList = $this->GetAll();
            $jobPositionsList = $this->jobPositionDAO->GetAll();
            if ($jobPositionDesc != null) {
                $filteredJobOffersList = array();
                $loweredReceivedDesc = strtolower($jobPositionDesc);
                foreach ($jobOffersList as $jobOffer) {
                    foreach ($jobPositionsList as $jobPosition) {
                        if ($jobOffer->getJobPosition()->getJobPositionId() == $jobPosition['jobPositionId']) {
                            $loweredJobPositionDesc = strtolower($jobPosition['description']);
                            if (strpos($loweredJobPositionDesc, $loweredReceivedDesc) !== false) {
                                $jobOffer->getJobPosition()->setDescription($jobPosition['description']);
                                $jobOffer->getJobPosition()->setCareer($this->careerDAO->getById($jobPosition['careerId']));
                                array_push($filteredJobOffersList, $jobOffer);
                            }
                        }
                    }
                }
            } else {
                $filteredJobOffersList = $jobOffersList;
            }


            return $filteredJobOffersList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Recibe la id de una propuesta laboral existente y los datos a modificar de la misma, y la modifica en la base de datos.
     */
    function Modify(JobOffer $jobOffer)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET `title` = :title, `createdAt` = :createdAt, `expirationDate` = :expirationDate, `salary` = :salary WHERE `jobOfferId` = :jobOfferId";
            $parameters["jobOfferId"] = $jobOffer->getJobOfferId();
            $parameters["title"] = $jobOffer->getTitle();
            $parameters["createdAt"] = $jobOffer->getCreatedAt();
            $parameters["expirationDate"] = $jobOffer->getExpirationDate();
            $parameters["salary"] = $jobOffer->getSalary();

            $this->connection = Connection::GetInstance();

            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Recibe la id de una propuesta laboral y la elimina de la base de datos, en conjunto con todas sus postulaciones activas.
     */
    function Delete($id)
    {
        try {

            $query = "CALL remove_job_offer(?);";

            $parameters["?"] = $id;

            $this->connection = Connection::GetInstance();

            return $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /** Recibe la ID de una oferta laboral y retorna el email de todos los estudiantes con aplicaciones activas a esa oferta. */
    function GetPostulatedEmails($jobOfferId)
    {
        try {
            $postulatedEmails = array();
            $query = "CALL get_postulated_emails(?)";

            $parameters["?"] = $jobOfferId;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            foreach ($resultSet as $row) {
                $email = '';
                $email = $row["email"];
                array_push($postulatedEmails, $email);
            }

            return $postulatedEmails;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetPostulationsByJobOfferId($jobOfferId)
    {
        try {
            $postulationsHistory = array();
            $query = "CALL GetPostulationsByJobOfferId(?)";

            $parameters["?"] = $jobOfferId;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            if ($resultSet == null) {
                throw new Exception("No se encontró ningun postulado para esta propuesta laboral.");
            }

            foreach ($resultSet as $row) {
                $postulation = new JobPostulation();
                $postulation->setPostulationId($row["idjob_postulations"]);
                $postulation->setStudent($this->studentDAO->getById($row["studentId"]));
                $postulation->setJobOffer($this->GetById($row["jobOfferId"]));
                $postulation->setComment($row["comment"]);
                $postulation->setCVarchive($row["cvarchive"]);
                $postulation->setActive($row["active"]);

                array_push($postulationsHistory, $postulation);
            }

            return $postulationsHistory;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
