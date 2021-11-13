<?php

namespace DAO;

use Models\Student as Student;

interface IStudentDAO
{    
    function GetAcademicStatusByStudentId($studentId);
    function GetAll();
    function getById($id);
    function isActive($id);
    function studentVerify($dni, $email);
    function studentVerifyForLogin($email);
}
