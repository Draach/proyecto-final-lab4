<?php

namespace DAO;

use \Exception as Exception;
use DAO\Connection as Connection;
use Models\Role as Role;

class RoleDAO implements IRoleDAO
{
    private $connection;
    private $tableName = "role";

    /**
     * Devuelve la lista de compañías de la base de datos.
     */
    public function GetAll()
    {
        try {
            $rolesList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE role.name != 'administrador'";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $role = new Role();
                $role->setRoleId($row["roleId"]);
                $role->setName($row["name"]);

                array_push($rolesList, $role);
            }


            return $rolesList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetById($id)
    {
        try {
            $rolesList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE `roleId` = :id";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            if($resultSet == null) {
                throw new Exception('No se encontró la compañía.');
            }

            foreach ($resultSet as $row) {
                $role = new Role();
                $role->setRoleId($row["roleId"]);
                $role->setName($row["name"]);

                array_push($rolesList, $role);
            }
            return $rolesList[0];
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
