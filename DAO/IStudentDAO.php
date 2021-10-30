<?php

namespace DAO;

interface IStudentDAO
{
    function Login($email, $password);
    function GetAll();
}
