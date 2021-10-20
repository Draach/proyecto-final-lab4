<?php namespace DAO;

    use Models\Company as Company;

    interface ICompanyDao{
        function add(Company $company);
        function GetAll();
    }

?>