<?php namespace Utils;


class CustomSessionHandler {

    public function createAdminUser($user) {
        $_SESSION['loggedUser'] = $user;
        $_SESSION['loggedUser']['role'] = "admin";
    }

    public function createStudentUser($user) {
        $_SESSION['loggedUser'] = $user;
        $_SESSION['loggedUser']['role'] = "student";
    }

    public function isAdmin() {
        $response = false;
        if(isset($_SESSION["loggedUser"])){
            if($_SESSION["loggedUser"]["role"] == "admin") {
                $response = true;
            }
        }
        return $response;
    }

    public function isStudent(){
        $response = false;
        if(isset($_SESSION["loggedUser"])){
            if($_SESSION["loggedUser"]["role"] == "student") {
                $response = true;
            }
        }
        return $response;
    }
}

?>