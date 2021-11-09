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

    /**
     * Devuelve una vista para agregar una nueva empresa.
     */
    public function ShowAddView()
    {
        if ($this->sessionHandler->isAdmin()) {
            require_once(VIEWS_PATH . "nav.php");
            require_once(VIEWS_PATH . "company-add.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    /**
     * Devuelve una vista con la lista de empresas activas en la aplicación.
     */
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

    /**
     * Revise los datos de una nueva empresa y la agrega a nuestra base de datos.
     */
    public function Add($name, $email, $phone, $address, $cuit, $website, $founded)
    {
        $timeNow = date("Y-m-d");
        $company = new Company();
        $company->setName($name);
        $company->setEmail($email);
        $company->setPhone($phone);
        $company->setAddress($address);
        $company->setCuit($cuit);
        $company->setWebsite($website);
        $company->setFounded($founded);

        try {
            if($founded > $timeNow) {                
                throw new Exception('La fecha de fundación no puede ser posterior a hoy. Por favor, ingrese una fecha válida.');
            } 
            $this->companyDAO->Add($company);
        } catch (Exception $ex) {
            $errMessage = $ex->getMessage();
            echo "<script type='text/javascript'>alert('Error: $errMessage');</script>";
        }

        echo "<script type='text/javascript'>alert('Empresa agregada exitosamente.');</script>";
        $this->ShowAddView();
    }

    /**
     * Recibe el ID de una empresa y la elimina de nuestra base de datos. (Borrado lógico)
     */
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

    /**
     * Devuelve una vista con los datos de una empresa.
     */
    public function ShowDetails($companyId)
    {
        if ($this->sessionHandler->isAdmin() || $this->sessionHandler->isStudent()) {
            $company = $this->companyDAO->GetById($companyId);

            // TODO Verificar que funcione correctamente cuando le pasamos un ID inexistente.

            if ($this->sessionHandler->isAdmin()) {
                require_once(VIEWS_PATH . "nav.php");
            }
            require_once(VIEWS_PATH . "company-details.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    /**
     * Devuelve una vista para modificar una empresa.
     */
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

    /**
     * Recibe los datos de una empresa y los modifica en nuestra base de datos.
     */
    public function Modify($id, $companyName, $email, $phone, $address, $cuit, $website, $founded)
    {        
        try {
            $response = $this->companyDAO->Modify($id, $companyName, $email, $phone, $address, $cuit, $website, $founded);
            echo "<script type='text/javascript'>alert('Se ha modificado exitosamente.');</script>";
            $this->ShowModifyView($id);
        } catch (Exception $ex) {
            $errMessage = $ex->getMessage();
            echo "<script type='text/javascript'>alert('Error: $errMessage');</script>";
            $this->ShowModifyView($id);
        }        
    }

    /**
     * Devuelve una vista con la lista de empresas que coinciden con el nombre pasado por parámetro.
     */
    public function GetByName($name)
    {
        if ($this->sessionHandler->isAdmin() || $this->sessionHandler->isStudent()) {
            $companiesList = $this->companyDAO->temporaryGetByName($name);
            if ($this->sessionHandler->isAdmin()) {
                require_once(VIEWS_PATH . "nav.php");
            }
            require_once(VIEWS_PATH . "company-list.php");
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }
}
