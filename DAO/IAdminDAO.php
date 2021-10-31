<?php

namespace DAO;

use Models\Admin as Admin;

interface IAdminDAO
{
    function Login($email, $password);
    function GetAll();
    function Add(Admin $admin);
    function DniVerify($id, $dni);
    function Delete($number);
}
