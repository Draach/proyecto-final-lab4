<?php

namespace DAO;

use \Exception as Exception;
use DAO\IAdminDAO as IAdminDAO;
use Models\Admin as Admin;
use DAO\Connection as Connection;

class AdminDAO implements IAdminDAO
{
    private $connection;
    private $tableName = "admins";

    public function Login($email, $password)
    {
        
        $loweredEmail = strtolower($email);
        $found = null;
        $adminsList = $this->GetAll();   

        foreach ($adminsList as $admin) {            
            if ($loweredEmail == $admin->getEmail() && password_verify($password, $admin->getPassword())) {
                $found['adminId'] = $admin->getAdminId();                            
                $found['firstName'] = $admin->getFirstName();
                $found['lastName'] = $admin->getLastName();
                $found['dni'] = $admin->getDni();
                $found['gender'] = $admin->getGender();
                $found['birthDate'] = $admin->getBirthDate();
                $found['email'] = $admin->getEmail();
                $found['phoneNumber'] = $admin->getPhoneNumber();
                $found['active'] = $admin->getActive();
                break;
            }
        }        
        return $found;
    }

    public function Add(Admin $admin)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (firstName, lastName, dni, gender, birthDate, email, password, phoneNumber, active) VALUES (:firstName, :lastName, :dni, :gender, :birthDate, :email, :password, :phoneNumber, :active);";

            $parameters["firstName"] = $admin->getFirstName();
            $parameters["lastName"] = $admin->getLastName();
            $parameters["dni"] = $admin->getDni();
            $parameters["gender"] = $admin->getGender();
            $parameters["birthDate"] = $admin->getBirthDate();
            $parameters["email"] = $admin->getEmail();
            $parameters["password"] = $admin->getPassword();
            $parameters["phoneNumber"] = $admin->getPhoneNumber();
            $parameters["active"] = $admin->getActive();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            
            throw $ex;
        }
    }

    public function GetAll()
    {
        try {            
            $adminsList = array();

            $query = "SELECT * FROM ".$this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);
            
            foreach ($resultSet as $row) {
                $admin = new Admin();
                $admin->setAdminId($row["adminId"]);
                $admin->setFirstName($row["firstName"]);
                $admin->setLastName($row["lastName"]);
                $admin->setDni($row["dni"]);
                $admin->setGender($row["gender"]);
                $admin->setBirthDate($row["birthDate"]);
                $admin->setEmail($row["email"]);
                $admin->setPassword($row["password"]);
                $admin->setPhoneNumber($row["phoneNumber"]);
                $admin->setActive($row["active"]);

                array_push($adminsList, $admin);
            }
            return $adminsList;
        } catch (Exception $ex) {
            
            throw $ex;
        }
    }

    public function Delete($number) {
        try
        {            
            $query = "UPDATE ".$this->tableName." SET `active` = false WHERE `adminId` = :number";
            
            $parameters["number"] = $number;             

            $this->connection = Connection::GetInstance();

            return $this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch(Exception $ex)
        {             
            
            throw $ex;
        }
    }
}
