<?php

namespace DAO;

use \Exception as Exception;
use DAO\IJobPostulationDAO as IJobPostulationDAO;
use Models\JobPostulation as JobPostulation;
use DAO\Connection as Connection;


class JobPostulationDAO implements IJobPostulationDAO
{
    private $connection;
    private $tableName = "job_postulations";

    /**
     * Recibe los datos de una postulación y la agrega a la base de datos.
     */
    function Add(JobPostulation $jobPostulation)
    {

        try {
            if($this->IsPostulated($jobPostulation->getStudentId()) == true) {
                throw new Exception("El alumno ya se encuentra postulado a una oferta de trabajo.");
            }

            $query = "INSERT INTO " . $this->tableName . " (jobOfferId, studentId, comment, cvarchive, active) VALUES (:jobOfferId, :studentId, :comment, :cvarchive, :active);";

            $parameters["jobOfferId"] = $jobPostulation->getJobOfferId();
            $parameters["studentId"] = $jobPostulation->getStudentId();
            $parameters["comment"] = $jobPostulation->getComment();
            $parameters["cvarchive"] = $jobPostulation->getCvarchive()['name'];
            $parameters["active"] = $jobPostulation->getActive();            


            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Recibe el ID de un usuario estudiante y verifica si ya está postulado a una propuesta laboral.
     * Devuelve false en caso de no estar postulado, true en caso contrario.
     */
    function IsPostulated($studentId)
    {
        $response = false;

        try {

            $query = "SELECT * FROM " . $this->tableName . " WHERE `studentId` = :studentId";
            $parameters["studentId"] = $studentId;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            //Si se encuentra postulacion activa cambia la respuesta a true
            if ($resultSet != null) {
                foreach ($resultSet as $row) {
                    if ($row['active'] == true) {
                        $response = true;
                    }
                }
            }


            return $response;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function isPostulatedToSpecificOffer($studentId) {
        $response = -1;

        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE `studentId` = :studentId";            
            $parameters["studentId"] = $studentId;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);
            
            if ($resultSet != null) {
                foreach ($resultSet as $row) {
                    if ($row['active'] == true) {
                        $response = $row['jobOfferId'];
                    }
                }
            }

            return $response;
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    public function Remove($jobOfferId, $studentId) {
        try {
            $query = "UPDATE " . $this->tableName . " SET active = 0 WHERE jobOfferId = :jobOfferId AND studentId = :studentId";
            $parameters["jobOfferId"] = $jobOfferId;
            $parameters["studentId"] = $studentId;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }        
    }
}