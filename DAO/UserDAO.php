<?php

namespace DAO;

use \Exception as Exception;
use DAO\IStudentDAO as IStudentDAO;
use Models\Student as Student;
use Models\User as User;
use DAO\Connection as Connection;

class UserDAO implements IUserDAO
{
    private $connection;
    private $tableName = "users";

    /**
     * Recibe un objeto de tipo User y lo guarda en nuestra base de datos.
     * Devuelve al usuario si se guarda correctamente o lanza una excepción en caso de error.
     */
    function Add(User $user)
    {
        try {            
            $this->EmailVerify($user->getEmail());            

            $query = "INSERT INTO " . $this->tableName . " (email, password, roleId, studentId, active, companyId) VALUES (:email, :password, :roleId, :studentId, :active, :companyId);";

            $parameters['email'] = $user->getEmail();
            $parameters['password'] = $user->getPassword();
            $parameters['roleId'] = $user->getRoleId();
            $parameters['studentId'] = $user->getStudentId();
            $parameters['active'] = $user->getActive();
            $parameters['companyId'] = $user->getCompany()->getCompanyId();        

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetAll(){
        try {
            $query = "SELECT * FROM " . $this->tableName . ";";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            $users = array();

            foreach ($resultSet as $row) {
                $user = new User();
                $user->setUserId($row["userId"]);
                $user->setEmail($row["email"]);
                $user->setPassword($row["password"]);
                $user->setRoleId($row["roleId"]);
                $user->setStudentId($row["studentId"]);
                $user->setActive($row["active"]);

                array_push($users, $user);
            }

            return $users;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetAllUsers(){
        try {
            $query = "CALL get_users_with_roles()";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            $users = array();

            foreach ($resultSet as $row) {
                $user = new User();
                $user->setUserId($row["userId"]);
                $user->setEmail($row["email"]);                                
                $user->setStudentId($row["studentId"]);
                $user->setActive($row["active"]);
                $user->setRoleId($row["roleId"]);
                $user->setRoleName($row["roleName"]);

                array_push($users, $user);
            }

            return $users;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Busca un usuario en la base de datos a partir de un email y un password recibidos por parámetro.
     * Devuelve al usuario si lo encuentra, o lanza una excepción en caso de error.
     */
   function GetUserByCredentials($email, $password) {
        try{            
            $usersList = $this->GetAll();
            
            foreach ($usersList as $user){
                $message = "Usuario y/o contraseña incorrectos.";
                if($user->getEmail() == $email && password_verify($password, $user->getPassword()) == true){
                    return $user;
                }
            }
                        
            throw New Exception($message);
            
        } catch(Exception $ex) {
            throw $ex;
        }
   }

    /**
     * Recibe un email y verifica si ya existe en nuestra base de datos.
     * Arroja un error si el correo existe.
     */
    function EmailVerify($email){
        try{
            $query = "SELECT * FROM " . $this->tableName . " WHERE email = :email;";

            $parameters['email'] = $email;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            if($resultSet) {
                throw New Exception('El correo ingresado ya existe en la base de datos de la aplicación.');
            }            
        } catch(Exception $ex){
            throw $ex;
        }
    }

    /**
     * Recibe el id de un administrador y lo elimina de la base de datos.
     */
    public function Remove($userId)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET `active` = false WHERE `userId` = :userId";

            $parameters["userId"] = $userId;

            $this->connection = Connection::GetInstance();

            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {

            throw $ex;
        }
    }
}
