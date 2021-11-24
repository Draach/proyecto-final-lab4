<?php

namespace DAO;

use Models\Career as Career;
use \Exception as Exception;

class CareerDAO implements ICareerDAO
{
    /**
     * Solicita la lista de carreras a la API de la UTN y la retorna.
     */
    public function GetAll()
    {
        $careers = '';
        try {

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://utn-students-api2.herokuapp.com/api/Career');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept:*/*', 'x-api-key:4f3bceed-50ba-4461-a910-518598664c08'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $careers = curl_exec($ch);
            if (curl_errno($ch)) {
                echo curl_error($ch);
            } else {
                $decoded = json_decode($careers, true);
            }

            curl_close($ch);
            return $decoded;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetById($id){
        $careersList = $this->GetAll();
        $found = null;
        foreach ($careersList as $career) {
            if ($career['careerId'] == $id) {
                $found = new Career();
                $found->setCareerId($career['careerId']);
                $found->setDescription($career['description']);
                $found->setActive($career['active']);
                break;
            }
        }

        return $found;
    }
}
