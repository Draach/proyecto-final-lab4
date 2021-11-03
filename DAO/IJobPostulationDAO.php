<?php namespace DAO;

use Models\JobPostulation as JobPostulation;

interface IJobPostulationDAO {
    function Add(JobPostulation $jobPostulation);
    public function GetAllByStudentId($studentId);
    function IsPostulated($studentId);
    public function Remove($jobOfferId, $studentId);
}