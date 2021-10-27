<?php

namespace DAO;

use Models\Admin as Admin;

interface IAdminDAO
{
    function Add(Admin $admin);
    function dniVerify($id, $dni);
    function Login($email, $password);
    function GetAll();
    function Delete($number);
}
