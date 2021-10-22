<?php namespace DAO;

    use Models\Company as Company;

    interface ICompanyDAO{
        function add(Company $company);
        function GetAll();
        function GetById($number);
        function ModifyName($number, $name);
        function Delete($number);
    }
?>