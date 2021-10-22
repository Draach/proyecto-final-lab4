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

        /**
         * Recupera la lista de empresas desde la base de datos.
         */
        //$companiesList = $this->companyDAO->GetAll();

        /**
         * Recupera la lista de empresas desde el archivo JSON.
         */
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

        /**
         * Agrega una empresa a la base de datos.
         */
        //$this->companyDAO->Add($company);   

        /**
         *  Agrega una empresa al archivo JSON.
         */
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

        /**
         * Remueve logicamente una empresa de la base de datos (Status = false).
         */
        //$response = $this->companyDAO->Delete($number) ;

        /**
         * Remueve logicamente una empresa del archivo JSON (Status = false).
         */
        $response = $this->jsonCompanyDAO->Delete($number);


        if ($response == 1) {
            $message = "La empresa con ID " . $number . " ha sido eliminada exitosamente.";
        } else {
            $message = "La empresa con ID " . $number . " no ha sido encontrada. Intente nuevamente.";
        }

        echo "<script type='text/javascript'>alert('$message');</script>";
        $this->Remove();
    }

    public function ShowDetails($companyId) {

        /**
         * Recupera la lista de empresas desde la base de datos.
         */
        //$companiesList = $this->companyDAO->GetById();

        /**
         * Recupera la lista de empresas desde el archivo JSON.
         */
        $company = $this->jsonCompanyDAO->GetById($companyId);
        if ($this->sessionHandler->isAdmin() || $this->sessionHandler->isStudent()) {
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

    public function Modify($id, $companyName) {
        $response = $this->jsonCompanyDAO->ModifyName($id, $companyName);
        require_once(VIEWS_PATH."nav.php");
        require_once(VIEWS_PATH."company-modify.php");
    }
}
