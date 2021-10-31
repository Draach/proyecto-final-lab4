<?php

namespace DAO;

use Models\Student as Student;

interface IStudentDAO
{
    function Login($email, $password);
    function GetAll();
    function Register($dni, $email, $password, $passwordConfirm);
    function Add(Student $student);
    function registeredEmailVerify($email);
}
