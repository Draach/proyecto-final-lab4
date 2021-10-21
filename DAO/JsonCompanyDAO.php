<?php

namespace DAO;

use Models\Company as Company;

class JsonCompanyDAO implements ICompanyDAO
{
    private $companiesList = array();
    private $fileName;

    public function __construct()
    {
        $this->fileName = dirname(__DIR__) . "/Data/Companies.json";
    }

    public function Add(Company $company)
    {
        $this->RetrieveData();
        $company->setCompanyId($this->GetLastID());
        array_push($this->companiesList, $company);
        $this->SaveData();
    }

    private function SaveData()
    {
        $arrayToEncode = array();

        foreach ($this->companiesList as $company) {
            $valuesArray["companyId"] = $company->getCompanyId();
            $valuesArray["name"] = $company->getName();
            $valuesArray["email"] = $company->getEmail();
            $valuesArray["phone"] = $company->getPhone();
            $valuesArray["address"] = $company->getAddress();
            $valuesArray["cuit"] = $company->getCuit();
            $valuesArray["website"] = $company->getWebsite();
            $valuesArray["founded"] = $company->getFounded();
            $valuesArray["status"] = $company->getStatus();
            array_push($arrayToEncode, $valuesArray);
        }
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents($this->fileName, $jsonContent);
    }

    private function GetLastID()
    {
        $id = 0;
        if (file_exists($this->fileName)) {
            $contenido = file_get_contents($this->fileName);

            $arrayDecodificado = ($contenido) ? json_decode($contenido, true) : array();

            foreach ($arrayDecodificado as $valores) {
                if ($valores["companyId"] >= $id) {
                    echo "llego al if";
                    $id = $valores["companyId"] + 1;
                }
            }
        }
        return $id;
    }

    public function GetAll()
    {
        $this->retrieveData();

        return $this->companiesList;
    }

    private function retrieveData()
    {
        $this->companiesList = array();

        if (file_exists($this->fileName)) {
            $contenido = file_get_contents($this->fileName);

            $arrayDecodificado = ($contenido) ? json_decode($contenido, true) : array();

            foreach ($arrayDecodificado as $valores) {
                $company = new Company();

                $company->setCompanyId($valores["companyId"]);
                $company->setName($valores["name"]);
                $company->setEmail($valores["email"]);
                $company->setPhone($valores["phone"]);
                $company->setAddress($valores["address"]);
                $company->setCuit($valores["cuit"]);
                $company->setWebsite($valores["website"]);
                $company->setFounded($valores["founded"]);
                $company->setStatus($valores["status"]);

                array_push($this->companiesList, $company);
            }
        }
    }

    public function Delete($number)
    {
        $response = 0;

        $this->retrieveData();
        foreach ($this->companiesList as $value) {
            if ($value->getCompanyId() == $number) {
                if ($value->getStatus() == true) {
                    $value->setStatus(false);
                    $response = 1;
                    break;
                }
            }
        }
        $this->SaveData();

        return $response;
    }
}
