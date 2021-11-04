<?php

namespace DAO;

use \Exception as Exception;
use DAO\IJobOfferDAO as IJobOfferDAO;
use Models\JobOffer as JobOffer;
use DAO\Connection as Connection;
use DAO\JobPositionDAO as JobPositionDAO;

class JobOfferDAO implements IJobOfferDAO
{
    private $connection;
    private $tableName = "job_offers";
    private $postulationsTableName = "job_postulations";

    private $jobPositionDAO;

    public function __construct()
    {
        $this->jobPositionDAO = new JobPositionDAO();
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

            $query = "INSERT INTO " . $this->tableName . " (title, createdAt, expirationDate, salary, companyId, jobPositionId, active) VALUES (:title, :createdAt, :expirationDate, :salary, :companyId, :jobPositionId, :active);";

            $parameters["title"] = $jobOffer->getTitle();
            $parameters["createdAt"] = $jobOffer->getCreatedAt();
            $parameters["expirationDate"] = $jobOffer->getExpirationDate();
            $parameters["salary"] = $jobOffer->getSalary();
            $parameters["companyId"] = $jobOffer->getCompanyId();
            $parameters["jobPositionId"] = $jobOffer->getJobPositionId();
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

            $query = "SELECT * FROM " . $this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $jobOffer = new JobOffer();
                $jobOffer->setJobOfferId($row["jobOfferId"]);
                $jobOffer->setTitle($row["title"]);
                $jobOffer->setCreatedAt($row["createdAt"]);
                $jobOffer->setExpirationDate($row["expirationDate"]);
                $jobOffer->setSalary($row["salary"]);
                $jobOffer->setCompanyId($row["companyId"]);
                $jobOffer->setJobPositionId($row["jobPositionId"]);
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

            // TODO validate if results != null

            foreach ($resultSet as $row) {
                $jobOffer = new JobOffer();
                $jobOffer->setJobOfferId($row["jobOfferId"]);
                $jobOffer->setTitle($row["title"]);
                $jobOffer->setCreatedAt($row["createdAt"]);
                $jobOffer->setExpirationDate($row["expirationDate"]);
                $jobOffer->setSalary($row["salary"]);
                $jobOffer->setCompanyId($row["companyId"]);
                $jobOffer->setJobPositionId($row["jobPositionId"]);
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
                        if ($jobOffer->getJobPositionId() == $jobPosition['jobPositionId']) {
                            $loweredJobPositionDesc = strtolower($jobPosition['description']);
                            if (strpos($loweredJobPositionDesc, $loweredReceivedDesc) !== false) {
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
    function Modify($jobOfferId, $title, $createdAt, $expirationDate, $salary)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET `title` = :title, `createdAt` = :createdAt, `expirationDate` = :expirationDate, `salary` = :salary WHERE `jobOfferId` = :jobOfferId";
            $parameters["jobOfferId"] = $jobOfferId;
            $parameters["title"] = $title;
            $parameters["createdAt"] = $createdAt;
            $parameters["expirationDate"] = $expirationDate;
            $parameters["salary"] = $salary;

            $this->connection = Connection::GetInstance();

            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Recibe la id de una propuesta laboral y la elimina de la base de datos.
     */
    function Delete($id)
    {
        try {

            $query = "UPDATE " . $this->tableName . " SET `active` = false WHERE `jobOfferId` = :id";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetPostulationsByJobOfferId($jobOfferId){
        try{

            $query = "SELECT * FROM " . $this->tableName . " INNER JOIN " . $this->postulationsTableName . " WHERE " . $this->tableName.".jobOfferId = :jobOfferId AND " . $this->postulationsTableName . ".jobOfferId = :jobOfferId AND " . $this->postulationsTableName .".Active = true ";
            $parameters["jobOfferId"] = $jobOfferId;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            return $resultSet;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
