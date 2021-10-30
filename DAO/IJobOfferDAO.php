<?php

namespace DAO;

use Models\JobOffer as JobOffer;

interface IJobOfferDAO
{
    function add(JobOffer $jobOffer);
    function GetAll();
    function GetById($id);
    function GetByName($name);
    function Modify($jobOfferId, $title ,$createdAt ,$expirationDate ,$salary);
    function Delete($id);
}
