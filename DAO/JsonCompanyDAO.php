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

    /**
     * Recibe una empresa y la guarda en el archivo JSON
     */
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
        $id = 1;
        if (file_exists($this->fileName)) {
            $contenido = file_get_contents($this->fileName);

            $arrayDecodificado = ($contenido) ? json_decode($contenido, true) : array();

            foreach ($arrayDecodificado as $valores) {
                if ($valores["companyId"] >= $id) {
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
        foreach ($this->companiesList as $company) {
            if ($company->getCompanyId() == $number) {
                if ($company->getStatus() == true) {
                    $company->setStatus(false);
                    $response = 1;
                    break;
                }
            }
        }
        $this->SaveData();

        return $response;
    }

    public function GetById($number)
    {
        $response = null;

        $this->retrieveData();
        foreach ($this->companiesList as $company) {
            if ($company->getCompanyId() == $number) {
                if ($company->getStatus() == true) {
                    $response = $company;
                    break;
                }
            }
        }
        return $response;
    }

    public function Modify($number, $name, $email, $phone, $address, $cuit, $website, $founded)
    {
        $response = 0;

        $this->retrieveData();

        foreach ($this->companiesList as $company) {
            if ($company->getCompanyId() == $number) {
                if ($company->getStatus() == true) {
                    $company->setName($name);
                    $company->setEmail($email);
                    $company->setPhone($phone);
                    $company->setAddress($address);
                    $company->setCuit($cuit);
                    $company->setWebsite($website);
                    $company->setFounded($founded);
                    $response = 1;
                    break;
                }
            }
        }

        $this->saveData();

        return $response;
    }

    public function GetByName($name)
    {
        $foundCompanies = array();
        $loweredReceivedName = strtolower($name);

        $this->retrieveData();
        foreach ($this->companiesList as $company) {
            $loweredCompanyName = "";
            $loweredCompanyName = strtolower($company->getName());

            if ($this->str_contains($loweredCompanyName, $loweredReceivedName) == true) {
                array_push($foundCompanies, $company);
            }
        }
        return $foundCompanies;
    }

    function CuitVerify($id = null, $cuit){
        
    }

    // TODO Delete this if php 8 and replace with native str_contains in GetByName method.
    function str_contains(string $haystack, string $needle): bool
    {
        return '' === $needle || false !== strpos($haystack, $needle);
    }
}
