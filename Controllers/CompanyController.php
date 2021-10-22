<?php

namespace Controllers;

use DAO\CompanyDAO as CompanyDAO;
use DAO\JsonCompanyDAO as JsonCompanyDAO;
use Models\Company as Company;
use Utils\CustomSessionHandler as CustomSessionHandler;

class CompanyController
{
    private $companyDAO;
    private $jsonCompanyDAO;
    private $sessionHandler;

    public function __construct()
    {
        $this->companyDAO = new CompanyDAO();
        $this->jsonCompanyDAO = new JsonCompanyDAO();
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

        //$companiesList = $this->companyDAO->GetAll();
        $companiesList = $this->jsonCompanyDAO->GetAll();

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

        //$this->companyDAO->Add($company);   
        $this->jsonCompanyDAO->Add($company);

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

        //$response = $this->companyDAO->Delete($number) ;
        $response = $this->jsonCompanyDAO->Delete($number);


        if ($response == 1) {
            $message = "La empresa con ID " . $number . " ha sido eliminada exitosamente.";
        } else {
            $message = "La empresa con ID " . $number . " no ha sido encontrada. Intente nuevamente.";
        }

        echo "<script type='text/javascript'>alert('$message');</script>";
        $this->Remove();
    }

    public function ShowDetails($companyId)
    {
        if ($this->sessionHandler->isAdmin() || $this->sessionHandler->isStudent()) {
            //$company = $this->companyDAO->GetById($companyId);        
            $company = $this->jsonCompanyDAO->GetById($companyId);
            if ($this->sessionHandler->isAdmin()) {
                require_once(VIEWS_PATH . "nav.php");
            }
            require_once(VIEWS_PATH . "company-details.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    public function ShowModifyView()
    {
        if ($this->sessionHandler->isAdmin()) {
            require_once(VIEWS_PATH . "nav.php");
            require_once(VIEWS_PATH . "company-modify.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    public function Modify($id, $companyName)
    {
        //$response = $this->companyDAO->ModifyName($id, $companyName);
        $response = $this->jsonCompanyDAO->ModifyName($id, $companyName);
        require_once(VIEWS_PATH . "nav.php");
        require_once(VIEWS_PATH . "company-modify.php");
    }

    public function GetByName($name)
    {
        if ($this->sessionHandler->isAdmin() || $this->sessionHandler->isStudent()) {
            //$companiesList = $this->companyDAO->GetByName($name);
            $companiesList = $this->jsonCompanyDAO->GetByName($name);
            if ($this->sessionHandler->isAdmin()) {
                require_once(VIEWS_PATH . "nav.php");
            }
            require_once(VIEWS_PATH . "company-list.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }
}
