<?php namespace Controllers;

    use DAO\CompanyDAO as CompanyDAO;
    use Models\Company as Company;

class CompanyController{
    private $companyDAO;

    public function __construct() {
        $this->companyDAO = new CompanyDAO();
    }

    public function ShowAddView(){
        require_once(VIEWS_PATH."company-add.php");        
    }

    public function List(){
        $companiesList = $this->companyDAO->GetAll();

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
                
        $this->companyDAO->Add($company);
        
        $this->ShowAddView();
    }
}

?>