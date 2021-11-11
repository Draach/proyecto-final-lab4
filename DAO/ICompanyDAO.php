<?php

namespace DAO;

use Models\Company as Company;

interface ICompanyDAO
{
    function Add(Company $company);
    function CuitVerify($id = null, $cuit);
    function GetAll();
    function GetById($number);
    function GetByName($name);
    function Modify(Company $company);
    function Delete($number);
}
