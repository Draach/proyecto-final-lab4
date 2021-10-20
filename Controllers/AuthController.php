<?php namespace Controllers;

    use DAO\StudentDAO as StudentDAO;
    use Models\Student as Student;

class AuthController{
    private $studentDAO;

    public function __construct() {
        $this->studentDAO = new StudentDAO();
    }

    public function Login($email){
        $studentsList = $this->studentDAO->GetAll();
        $found = false;
        $message = "";

        foreach($studentsList as $student) {
            if($email == $student['email']){
                $found = true;
                break;
            }
        }
        
        if($found) {
            $this->ShowDashboard();
        } else {
            $message = "<p class='message'>Hubo un error en tu combinación de correo y contraseña. Por favor, intenta nuevamente.</p>";
            $this->Index($message);
        }
    }

    public function ShowDashboard(){
        $optionsList = array();
        $optionsList[0]['optName'] = 'Consultar Estado Académico';
        $optionsList[0]['url'] = '#';
        $optionsList[1]['optName'] = 'Consultar Listado de Empresas';
        $optionsList[1]['url'] = '#';
        $optionsList[2]['optName'] = 'Consultar Listado de Propuestas';
        $optionsList[2]['url'] = '#';
        $optionsList[3]['optName'] = 'Consultar Historial de Aplicaciones';
        $optionsList[3]['url'] = '#';
   
        require_once(VIEWS_PATH."student-dashboard.php");
    }

    public function Index($message) {
        require_once(VIEWS_PATH."index.php");
    }
/*
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
    }*/
}

?>