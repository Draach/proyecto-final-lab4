<?php

namespace DAO;

use Models\JobOffer as JobOffer;

interface IJobOfferDAO
{
    function Add(JobOffer $jobOffer);
    function GetAll();
    function GetById($id);
    function GetByName($name);
    function Modify($jobOfferId, $title ,$createdAt ,$expirationDate ,$salary);
    function Delete($id);
    function AddPostulation($jobOfferId, $studentId, $comment, $cvarchive);
    function IsPostulated($studentId);
}
