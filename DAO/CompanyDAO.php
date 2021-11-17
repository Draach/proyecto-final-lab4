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

    /**
     * Recibe una compañía y la agrega a la base de datos pasando por las respectivas validaciones.
     */
    public function Add(Company $company)
    {
        try {

            $response = $this->cuitVerify(null, $company->getCuit());

            if ($response == 1) {
                throw new Exception('El cuit ingresado ya existe.');
            }
            
            $ucFirstName = ucfirst($company->getName());

            $query = "INSERT INTO " . $this->tableName . " (name, email, phone, address, cuit, website, founded, status) VALUES (:name, :email, :phone, :address, :cuit, :website, :founded, :status);";

            $parameters["name"] = $ucFirstName;
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

    /**
     * Devuelve la lista de compañías de la base de datos.
     */
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
            // Ordena el arreglo alfabéticamente antes de retornarlo.
            usort($companiesList, function ($param1, $param2) {
                return strcmp($param1->getName(), $param2->getName());
            });
            return $companiesList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Recibe una id de una compañía y la elimina de la base de datos.
     */
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

    /**
     * Recibe un id de una compañia, la busca en la base de datos y devuelve la compañia.
     */
    public function GetById($companyId)
    {
        try {
            $companiesList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE `companyId` = :companyId";

            $parameters["companyId"] = $companyId;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            if($resultSet == null) {
                throw new Exception('No se encontró la compañía.');
            }

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

    /** 
     * Recibe los datos de una compañía y la modifica en la base de datos.
     */
    public function Modify(Company $company)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET `name` = :name, `email` = :email, `phone` = :phone, `address` = :address, `cuit` = :cuit, `website` = :website, `founded` = :founded WHERE `companyId` = :id";

            $response = $this->cuitVerify($company->getCompanyId(), $company->getCuit());

            if ($response == 1) {
                throw new Exception('El cuit ingresado ya existe.');
            }

            $parameters["id"] = $company->getCompanyId();
            $parameters["name"] = $company->getName();
            $parameters["email"] = $company->getEmail();
            $parameters["phone"] = $company->getPhone();
            $parameters["address"] = $company->getAddress();
            $parameters["cuit"] = $company->getCuit();
            $parameters["website"] = $company->getWebsite();
            $parameters["founded"] = $company->getFounded();


            $this->connection = Connection::GetInstance();

            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // TODO No funciona
    function GetByName($name)
    {
        try {
            $companiesList = array();
            $loweredReceivedName = strtolower($name);
            $query = "SELECT * FROM " . $this->tableName . " WHERE name LIKE '%:paramName%'";

            $parameters["paramName"] = $loweredReceivedName;
            echo var_dump($parameters);
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

            return $companiesList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function temporaryGetByName($name)
    {
        try {
            $companiesList = $this->GetAll();
            if ($name != null) {
                $filteredCompaniesList = array();
                $loweredReceivedName = strtolower($name);
                foreach ($companiesList as $company) {
                    $loweredCompanyName = strtolower($company->getName());
                    if (strpos($loweredCompanyName, $loweredReceivedName) !== false) {
                        array_push($filteredCompaniesList, $company);
                    }
                }
            } else {
                $filteredCompaniesList = $companiesList;
            }

            return $filteredCompaniesList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Verifica si el cuit ingresado ya existe en la base de datos.
     * Devuelve 1 si existe, 0 si no existe o corresponde a la compañia que se quiere editar.
     */
    function CuitVerify($id = null, $cuit)
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
            // TODO
        }
    }

    function GetLastId(){
        try {
            $query = "SELECT MAX(`companyId`) AS `lastId` FROM " . $this->tableName;
            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            return $resultSet[0]['lastId'];
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // TODO Delete this if php 8 and replace with native str_contains in GetByName method.
    function str_contains(string $haystack, string $needle): bool
    {
        return '' === $needle || false !== strpos($haystack, $needle);
    }
}
