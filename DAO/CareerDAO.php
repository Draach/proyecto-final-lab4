<?php

namespace DAO;

use Models\Career as Career;
use \Exception as Exception;

class CareerDAO implements ICareerDAO
{
    public function GetAll()
    {
        $careers = '';
        try {

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://utn-students-api.herokuapp.com/api/Career');
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
}
?>