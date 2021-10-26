<?php

namespace DAO;

interface IStudentDAO
{
    function Login($email);
    function GetAll();
}
