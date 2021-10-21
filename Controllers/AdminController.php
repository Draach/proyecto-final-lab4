<?php namespace Controllers;

    use DAO\AdminDAO as AdminDAO;
    use Models\Admin as Admin;

class AdminController{
    private $adminDAO;

    public function __construct() {
        $this->adminDAO = new AdminDAO();
    }
    
    public function Add($firstName, $lastName, $dni, $gender, $birthDate, $email, $password, $phoneNumber) {
        $admin = new Admin();                  

        $encryptedPassword = password_hash($password, PASSWORD_BCRYPT);
        $admin->setFirstName(strtolower($firstName));
        $admin->setLastName(strtolower($lastName));
        $admin->setDni($dni);
        $admin->setGender($gender);
        $admin->setBirthDate($birthDate);
        $admin->setEmail(strtolower($email));
        $admin->setPassword($encryptedPassword);
        $admin->setPhoneNumber($phoneNumber); 
        $admin->setActive(true);
        
        /**
         * Agrega un admin a la base de datos.
         */
        $this->adminDAO->Add($admin);   
        
        /**
         *  Agrega un admin al archivo JSON.
         */
        //$this->jsonAdminDAO->Add($admin);

        $this->ShowAddView();
    }

    public function List(){
        /**
         * Recupera la lista de admins desde la base de datos.
         */
        $adminsList = $this->adminDAO->GetAll();

        /**
         * Recupera la lista de admins desde el archivo JSON.
         */
        //$companiesList = $this->jsonAdminDAO->GetAll();

        require_once(VIEWS_PATH."admin-list.php");
    }

    public function ShowAddView(){
        require_once(VIEWS_PATH."admin-add.php");        
    }

    public function ShowDashboard(){   
        require_once(VIEWS_PATH."admin-dashboard.php");
    }

    public function Remove() {
        require_once(VIEWS_PATH."company-remove.php");
    }

    public function RemoveCompany($number) {
        $message = "";
        /**
         * Remueve logicamente un admin del archivo JSON (Status = false).
         */
        /*
        $response = $this->jsonAdminDAO->Delete($number);                
        */


        /**
         * Remueve logicamente un admin de la base de datos (Status = false).
         */
        $response = $this->adminDAO->Delete($number) ;




        if($response == 1) {
            $message = "El admin con ID ".$number." ha sido eliminada exitosamente.";
        } else {
            $message = "El admin con ID ".$number." no ha sido encontrada. Intente nuevamente.";
        }        

        echo "<script type='text/javascript'>alert('$message');</script>";
        $this->Remove();
    }
}

?>