<?php

namespace DAO;

use \Exception as Exception;
use DAO\ICompanyDAO as ICompanyDAO;
use Models\Company as Company;
use DAO\Connection as Connection;

class CompanyDAO implements ICompanyDAO
{
    private $connection;
    private $tableName = "companies";

    public function Add(Company $company)
    {
        try {

            $response = $this->cuitVerify(null, $company->getCuit());

            if ($response == 1) {
                throw new Exception('El cuit ingresado ya existe.');
            }
            
            $query = "INSERT INTO " . $this->tableName . " (name, email, phone, address, cuit, website, founded, status) VALUES (:name, :email, :phone, :address, :cuit, :website, :founded, :status);";

            $parameters["name"] = $company->getName();
            $parameters["email"] = $company->getEmail();
            $parameters["phone"] = $company->getPhone();
            $parameters["address"] = $company->getAddress();
            $parameters["cuit"] = $company->getCuit();
            $parameters["website"] = $company->getWebsite();
            $parameters["founded"] = $company->getFounded();
            $parameters["status"] = $company->getStatus();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {

            throw $ex;
        }
    }

    public function GetAll()
    {
        try {
            $companiesList = array();

            $query = "SELECT * FROM " . $this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $company = new Company();
                $company->setCompanyId($row["companyId"]);
                $company->setName($row["name"]);
                $company->setEmail($row["email"]);
                $company->setPhone($row["phone"]);
                $company->setAddress($row["address"]);
                $company->setCuit($row["cuit"]);
                $company->setWebsite($row["website"]);
                $company->setFounded($row["founded"]);
                $company->setStatus($row["status"]);

                array_push($companiesList, $company);
            }
            return $companiesList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function Delete($number)
    {
        try {

            $query = "UPDATE " . $this->tableName . " SET `status` = false WHERE `companyId` = :number";

            $parameters["number"] = $number;

            $this->connection = Connection::GetInstance();

            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    // TODO
    public function GetById($number)
    {
        try {
            $companiesList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE `companyId` = :number";

            $parameters["number"] = $number;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);
            foreach ($resultSet as $row) {
                $company = new Company();
                $company->setCompanyId($row["companyId"]);
                $company->setName($row["name"]);
                $company->setEmail($row["email"]);
                $company->setPhone($row["phone"]);
                $company->setAddress($row["address"]);
                $company->setCuit($row["cuit"]);
                $company->setWebsite($row["website"]);
                $company->setFounded($row["founded"]);
                $company->setStatus($row["status"]);

                array_push($companiesList, $company);
            }
            return $companiesList[0];
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function Modify($id, $name, $email, $phone, $address, $cuit, $website, $founded)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET `name` = :name, `email` = :email, `phone` = :phone, `address` = :address, `cuit` = :cuit, `website` = :website, `founded` = :founded WHERE `companyId` = :id";

            $response = $this->cuitVerify($id, $cuit);

            if ($response == 1) {
                throw new Exception('El cuit ingresado ya existe.');
            }

            $parameters["id"] = $id;
            $parameters["name"] = $name;
            $parameters["email"] = $email;
            $parameters["phone"] = $phone;
            $parameters["address"] = $address;
            $parameters["cuit"] = $cuit;
            $parameters["website"] = $website;
            $parameters["founded"] = $founded;


            $this->connection = Connection::GetInstance();

            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetByName($name)
    {
        try {
            $companiesList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE `name` LIKE '%:name%'";

            $parameters["name"] = $name;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $company = new Company();
                $company->setCompanyId($row["companyId"]);
                $company->setName($row["name"]);
                $company->setEmail($row["email"]);
                $company->setPhone($row["phone"]);
                $company->setAddress($row["address"]);
                $company->setCuit($row["cuit"]);
                $company->setWebsite($row["website"]);
                $company->setFounded($row["founded"]);
                $company->setStatus($row["status"]);

                array_push($companiesList, $company);
            }
            return $companiesList[0];
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function cuitVerify($id = null, $cuit)
    {
        try {
            $response = 0;
            $query = "SELECT `companies`.`companyId`, `companies`.`cuit` FROM " . $this->tableName . " WHERE `cuit` = :cuit";
            $parameters["cuit"] = $cuit;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            if ($resultSet != null) {
                if ($resultSet[0]['companyId'] != $id && $resultSet[0]['cuit'] == $cuit) {
                    $response = 1;
                }
            }

            return $response;;
        } catch (Exception $ex) {
        }
    }
}

// TODO Delete this if php 8 and replace with native str_contains in GetByName method.
function str_contains(string $haystack, string $needle): bool
{
    return '' === $needle || false !== strpos($haystack, $needle);
}
