<?php
namespace DAO;

use Models\User as User;

interface IUserDao {
    function Add(User $user);  
    function GetAll();
    function GetUserByCredentials($email, $password);
    function GetAllUsers();
    function EmailVerify($email);
}