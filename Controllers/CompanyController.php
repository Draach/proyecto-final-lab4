<?php

namespace Controllers;

use DAO\CompanyDAO as CompanyDAO;
use DAO\JsonCompanyDAO as JsonCompanyDAO;
use Models\Company as Company;
use Utils\CustomSessionHandler as CustomSessionHandler;
use Exception as Exception;

class CompanyController
{
    private $companyDAO;
    private $sessionHandler;

    public function __construct()
    {
        $this->companyDAO = new CompanyDAO();
        $this->sessionHandler = new CustomSessionHandler();
    }

    public function ShowAddView()
    {
        if ($this->sessionHandler->isAdmin()) {
            require_once(VIEWS_PATH . "nav.php");
            require_once(VIEWS_PATH . "company-add.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    public function ShowListView()
    {

        $companiesList = $this->companyDAO->GetAll();

        if ($this->sessionHandler->isAdmin() || $this->sessionHandler->isStudent()) {
            if ($this->sessionHandler->isAdmin()) {
                require_once(VIEWS_PATH . "nav.php");
            }
            require_once(VIEWS_PATH . "company-list.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    public function Add($name, $email, $phone, $address, $cuit, $website, $founded)
    {
        $company = new Company();
        $company->setName($name);
        $company->setEmail($email);
        $company->setPhone($phone);
        $company->setAddress($address);
        $company->setCuit($cuit);
        $company->setWebsite($website);
        $company->setFounded($founded);

        try {
            $this->companyDAO->Add($company);
        } catch (Exception $ex) {
            echo "<script type='text/javascript'>alert('Ha ocurrido un error.');</script>";
        }

        $this->ShowAddView();
    }

    public function Remove()
    {
        if ($this->sessionHandler->isAdmin()) {
            require_once(VIEWS_PATH . "nav.php");
            require_once(VIEWS_PATH . "company-remove.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    public function RemoveCompany($number)
    {
        $message = "";
        
        $response = $this->companyDAO->Delete($number); 


        if ($response == 1) {
            $message = "La empresa con ID " . $number . " ha sido eliminada exitosamente.";
        } else {
            $message = "La empresa con ID " . $number . " no ha sido encontrada. Intente nuevamente.";
        }

        echo "<script type='text/javascript'>alert('$message');</script>";
        $this->ShowListView();
    }

    public function ShowDetails($companyId)
    {
        if ($this->sessionHandler->isAdmin() || $this->sessionHandler->isStudent()) {
            $company = $this->companyDAO->GetById($companyId);
            if ($this->sessionHandler->isAdmin()) {
                require_once(VIEWS_PATH . "nav.php");
            }
            require_once(VIEWS_PATH . "company-details.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    public function ShowModifyView($companyId)
    {
        if ($this->sessionHandler->isAdmin()) {
            $company = $this->companyDAO->GetById($companyId);
            require_once(VIEWS_PATH . "nav.php");
            require_once(VIEWS_PATH . "company-modify.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    public function Modify($id, $companyName, $email, $phone, $address, $cuit, $website, $founded)
    {        
        try {
            $response = $this->companyDAO->Modify($id, $companyName, $email, $phone, $address, $cuit, $website, $founded);
            echo "<script type='text/javascript'>alert('Se ha modificado exitosamente.');</script>";
            $this->ShowModifyView($id);
        } catch (Exception $ex) {
            $errMessage = $ex->getMessage();
            echo "<script type='text/javascript'>alert('$errMessage');</script>";
            $this->ShowModifyView($id);
        }        
    }

    public function GetByName($name)
    {
        if ($this->sessionHandler->isAdmin() || $this->sessionHandler->isStudent()) {
            $companiesList = $this->companyDAO->GetByName($name);
            if ($this->sessionHandler->isAdmin()) {
                require_once(VIEWS_PATH . "nav.php");
            }
            require_once(VIEWS_PATH . "company-list.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }
}
