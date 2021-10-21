<?php namespace Controllers;

    use DAO\CompanyDAO as CompanyDAO;
    use DAO\JsonCompanyDAO as JsonCompanyDAO;
    use Models\Company as Company;

class CompanyController{
    private $companyDAO;
    private $jsonCompanyDAO;

    public function __construct() {
        $this->companyDAO = new CompanyDAO();
        $this->jsonCompanyDAO = new JsonCompanyDAO();
    }

    public function ShowAddView(){
        require_once(VIEWS_PATH."company-add.php");        
    }

    public function List(){
        /**
         * Recupera la lista de empresas desde la base de datos.
         */
        $companiesList = $this->companyDAO->GetAll();

        /**
         * Recupera la lista de empresas desde el archivo JSON.
         */
        //$companiesList = $this->jsonCompanyDAO->GetAll();

        require_once(VIEWS_PATH."company-list.php");
    }

    public function Add($name, $email, $phone, $address, $cuit, $website, $founded) {
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
        $this->companyDAO->Add($company);   
        
        /**
         *  Agrega una empresa al archivo JSON.
         */
        //$this->jsonCompanyDAO->Add($company);

        $this->ShowAddView();
    }

    public function Remove() {
        require_once(VIEWS_PATH."company-remove.php");
    }

    public function RemoveCompany($number) {
        $message = "";
        /**
         * Remueve logicamente una empresa del archivo JSON (Status = false).
         */
        /*
        $response = $this->jsonCompanyDAO->Delete($number);                
        */


        /**
         * Remueve logicamente una empresa de la base de datos (Status = false).
         */
        $response = $this->companyDAO->Delete($number) ;




        if($response == 1) {
            $message = "La empresa con ID ".$number." ha sido eliminada exitosamente.";
        } else {
            $message = "La empresa con ID ".$number." no ha sido encontrada. Intente nuevamente.";
        }        

        echo "<script type='text/javascript'>alert('$message');</script>";
        $this->Remove();
    }
}

?>