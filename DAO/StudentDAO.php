<?php

namespace DAO;

use \Exception as Exception;
use DAO\IStudentDAO as IStudentDAO;
use Models\Student as Student;
use Models\User as User;
use DAO\Connection as Connection;

class StudentDAO implements IStudentDAO
{
    private $connection;
    private $tableName = "students";


    public function GetAcademicStatusByStudentId($studentId)
    {
        try {
            $studentsList = $this->GetAll();

            foreach ($studentsList as $student) {
                if ($student['studentId'] == $studentId) {
                    $found = new Student();
                    $found->setStudentId($student['studentId']);
                    $found->setCareerId($student['careerId']);
                    $found->setFirstName($student['firstName']);
                    $found->setLastName($student['lastName']);
                    $found->setDni($student['dni']);
                    $found->setFileNumber($student['fileNumber']);
                    $found->setGender($student['gender']);
                    $found->setBirthDate($student['birthDate']);
                    $found->setEmail($student['email']);
                    $found->setPhoneNumber($student['phoneNumber']);
                    $found->setActive($student['active']);
                    return $found;
                }
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Solicita la lista de estudiantes a la API de la UTN y devuelve una lista de estudiantes.
     */
    public function GetAll()
    {
        $studentsList = '';
        try {

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://utn-students-api.herokuapp.com/api/Student');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
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


    /**
     * Recibe el ID de un estudiante y verifica si este está activo en la api de la utn.
     */
    function isActive($id)
    {
        $response = false;
        $studentsList = $this->GetAll();
        foreach ($studentsList as $student) {
            if ($id == $student['studentId']) {
                if ($student['active'] == true) {
                    $response = true;
                }
            }
        }
        return $response;
    }

    /**
     * Recibe un dni y un email de un estudiante y verifica si este existe en la API de la UTN.
     * Devuelve a el estudiante si este existe y está activo.
     * Arroja un error si el estudiante no existe o está inactivo.
     */
    public function studentVerify($dni, $email)
    {
        try {
            $studentsList = $this->GetAll();
            $message = "";
            $message = "El usuario no ha sido encontrado en la base de datos de la UTN MDP.";
            foreach ($studentsList as $student) {
                if ($dni == $student['dni'] && $email == $student['email']) {
                    $message = "El usuario no se encuentra activo en la base de datos de la UTN MDP.";
                    if ($student['active'] == true) {
                        $found = new Student();
                        $found->setStudentId($student['studentId']);
                        $found->setCareerId($student['careerId']);
                        $found->setFirstName($student['firstName']);
                        $found->setLastName($student['lastName']);
                        $found->setDni($student['dni']);
                        $found->setFileNumber($student['fileNumber']);
                        $found->setGender($student['gender']);
                        $found->setBirthDate($student['birthDate']);
                        $found->setEmail($student['email']);
                        $found->setPhoneNumber($student['phoneNumber']);
                        $found->setActive($student['active']);
                        return $found;
                    }
                }
            }

            throw new Exception($message);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function studentVerifyForLogin($email)
    {
        try {
            $studentsList = $this->GetAll();
            $message = "";
            $message = "El usuario no ha sido encontrado en la base de datos de la UTN MDP.";
            foreach ($studentsList as $student) {
                if ($email == $student['email']) {
                    $message = "El usuario no se encuentra activo en la base de datos de la UTN MDP.";
                    if ($student['active'] == true) {
                        $found = new Student();
                        $found->setStudentId($student['studentId']);
                        $found->setCareerId($student['careerId']);
                        $found->setFirstName($student['firstName']);
                        $found->setLastName($student['lastName']);
                        $found->setDni($student['dni']);
                        $found->setFileNumber($student['fileNumber']);
                        $found->setGender($student['gender']);
                        $found->setBirthDate($student['birthDate']);
                        $found->setEmail($student['email']);
                        $found->setPhoneNumber($student['phoneNumber']);
                        $found->setActive($student['active']);
                        return $found;
                    }
                }
            }

            throw new Exception($message);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
