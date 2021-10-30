<?php

namespace DAO;

use \Exception as Exception;
use DAO\IStudentDAO as IStudentDAO;
use Models\Student;
use DAO\Connection as Connection;

class StudentDAO implements IStudentDAO
{
    private $connection;
    private $tableName = "students";

    public function Login($email, $password)
    {
        try {
        $found = null;        
        $apiResult = null;
        $loweredEmail = strtolower($email);

        // Verificamos si el correo existe en la API de la UTN MDP.
        $studentsList = $this->GetAll();
        foreach ($studentsList as $student) {
            if ($email == $student['email'] && $student['active'] == true) {
                $apiResult = $student;
                break;
            }
        }        

        if ($apiResult == null) {
            throw new Exception("Usuario y/o contraseña incorrectos.");
        }

        // Verificamos que el usuario esté registrado en la base de datos de nuestra app.
        $dbStudentsList = $this->registeredEmailVerify($loweredEmail);
        if($dbStudentsList == null){
            throw new Exception("Usuario y/o contraseña incorrectos."); 
        }

        // Si el usuario está registrado en la base de datos de nuestra app, verificamos que las credenciales sean correctas
        // y guardamos todos sus datos en caso de éxito.        
        foreach ($dbStudentsList as $student) {
            if ($loweredEmail == $student['email'] && password_verify($password, $student['password'])) {
                $found = new Student();
                $found->setStudentId($student['studentId']);
                $found->setFirstName($student['firstName']);
                $found->setCareerId($student['careerId']);
                $found->setLastName($student['lastName']);
                $found->setDni($apiResult['dni']);
                $found->setFileNumber($apiResult['fileNumber']);
                $found->setGender($apiResult['gender']);
                $found->setBirthDate($apiResult['birthDate']);
                $found->setEmail(strtolower($email));
                $found->setPhoneNumber($student['phoneNumber']);
                $found->setActive($apiResult['active']);
                break;
            }
        }
        if($found == null) {
            throw new Exception("Usuario y/o contraseña incorrectos.");
        } else if ($found->getActive() == false) {
            throw new Exception("El usuario no está activo.");
        }

        return $found;
    } catch (Exception $ex){
        throw $ex;
    }
    }

    public function GetAll()
    {
        $studentsList = '';
        try {

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://utn-students-api.herokuapp.com/api/Student');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept:*/*', 'x-api-key:4f3bceed-50ba-4461-a910-518598664c08'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $studentsList = curl_exec($ch);
            if (curl_errno($ch)) {
                echo curl_error($ch);
            } else {
                $decoded = json_decode($studentsList, true);
            }

            curl_close($ch);
            return $decoded;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function Register($dni, $email, $password, $passwordConfirm)
    {
        try {
            $found = null;

            $response = $this->registeredEmailVerify($email);

            if ($response) {
                throw new Exception('El correo ' . $email . ' ya se encuentra registrado en la aplicación.');
            }

            if ($password == $passwordConfirm) {
                $studentsList = $this->GetAll();
                foreach ($studentsList as $student) {
                    $message = 'El usuario no se encuentra en la plataforma de la Universidad.';
                    if ($dni == $student['dni'] && $email == $student['email']) {
                        $message = "El usuario no posee un estado activo en la plataforma de la Universidad.";
                        if ($student['active'] == true) {
                            $encryptedPassword = password_hash($password, PASSWORD_BCRYPT);
                            $found = new Student();
                            $found->setStudentId($student['studentId']);
                            $found->setFirstName($student['firstName']);
                            $found->setCareerId($student['careerId']);
                            $found->setLastName($student['lastName']);
                            $found->setDni($student['dni']);
                            $found->setFileNumber($student['fileNumber']);
                            $found->setGender($student['gender']);
                            $found->setBirthDate($student['birthDate']);
                            $found->setEmail(strtolower($email));
                            $found->setPassword($encryptedPassword);
                            $found->setPhoneNumber($student['phoneNumber']);
                            $found->setActive($student['active']);
                        }
                        break;
                    }
                }

                if ($found) {
                    $this->Add($found);
                } else {
                    throw new Exception($message);
                }

                return $found;
            } else {
                throw new Exception('Falló la confirmación de la contraseña.');
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    private function Add(Student $student)
    {

        try {

            $query = "INSERT INTO " . $this->tableName . " (studentId, firstName, lastName, email, password, phoneNumber, careerId) VALUES (:studentId, :firstName, :lastName, :email, :password, :phoneNumber, :careerId);";

            $parameters['studentId'] = $student->getStudentId();
            $parameters['firstName'] = $student->getFirstName();
            $parameters['lastName'] = $student->getLastName();
            $parameters['email'] = $student->getEmail();
            $parameters['password'] = $student->getPassword();
            $parameters['phoneNumber'] = $student->getPhoneNumber();
            $parameters['careerId'] = $student->getCareerId();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function registeredEmailVerify($email)
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE `email` = :email";
            $parameters["email"] = $email;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            return $resultSet;;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
