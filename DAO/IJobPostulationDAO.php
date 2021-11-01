<?php namespace DAO;

use Models\JobPostulation as JobPostulation;

interface IJobPostulationDAO {
    function Add(JobPostulation $jobPostulation);
    function IsPostulated($studentId);
    public function Remove($jobOfferId, $studentId);
}