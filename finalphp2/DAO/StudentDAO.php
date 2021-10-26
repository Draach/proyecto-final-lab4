<?php

namespace DAO;

use \Exception as Exception;
use DAO\IStudentDAO as IStudentDAO;



class StudentDAO implements IStudentDAO
{

    public function Login($email)
    {
        $found = null;
        $studentsList = $this->GetAll();

        foreach ($studentsList as $student) {
            if ($email == $student['email']) {
                $found = $student;
                break;
            }
        }

        return $found;
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
}
