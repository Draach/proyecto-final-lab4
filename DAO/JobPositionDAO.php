<?php

namespace DAO;

use Models\JobPosition as JobPosition;
use DAO\CareerDAO as CareerDAO;
use \Exception as Exception;

class JobPositionDAO implements IJobPositionDAO
{

    private $careerDAO;

    public function __construct()
    {
        $this->careerDAO = new CareerDAO();
    }

    /**
     * Solicita la lista de posiciones de trabajo a la API de la UTN y la devuelve.
     */
    public function GetAll()
    {
        $jobPositions = '';
        try {

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://utn-students-api2.herokuapp.com/api/JobPosition');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept:*/*', 'x-api-key:4f3bceed-50ba-4461-a910-518598664c08'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $jobPositions = curl_exec($ch);
            if (curl_errno($ch)) {
                echo curl_error($ch);
            } else {
                $decoded = json_decode($jobPositions, true);
            }

            curl_close($ch);            
            return $decoded;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetById($id)
    {
        $jobPositionsList = $this->GetAll();
        $found = null;
        foreach ($jobPositionsList as $jobPosition) {
            if ($jobPosition['jobPositionId'] == $id) {
                $found = new JobPosition();                                
                $found->setJobPositionId($jobPosition['jobPositionId']);
                $found->setCareer($this->careerDAO->getById($jobPosition['careerId']));
                $found->setDescription($jobPosition['description']);
                break;
            }
        }
        return $found;
    }
}
