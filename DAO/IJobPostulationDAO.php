<?php namespace DAO;

use Models\JobPostulation as JobPostulation;

interface IJobPostulationDAO {
    function Add(JobPostulation $jobPostulation);
    function GetAllByStudentId($studentId);
    function IsPostulated($studentId);
    function isPostulatedToSpecificOffer($studentId);
    function Remove($jobOfferId, $studentId);
}