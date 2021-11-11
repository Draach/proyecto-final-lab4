<?php

namespace Models;
use Models\Company as Company;

class JobOffer
{
    private $jobOfferId;
    private $title;
    private $createdAt;
    private $expirationDate;
    private $salary;
    private $company;
    private $jobPosition;
    private $applications;
    private $active;

    public function __construct()
    {
        $this->applications = array();
        $this->active = true;
    }

    public function getJobOfferId()
    {
        return $this->jobOfferId;
    }

    public function setJobOfferId($jobOfferId)
    {
        $this->jobOfferId = $jobOfferId;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    public function getSalary()
    {
        return $this->salary;
    }

    public function setSalary($salary)
    {
        $this->salary = $salary;

        return $this;
    }

    public function getStudentId()
    {
        return $this->studentId;
    }

    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;

        return $this;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    public function getApplications()
    {
        return $this->applications;
    }

    public function setApplications($applications)
    {
        $this->applications = $applications;

        return $this;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    public function getJobPosition()
    {
        return $this->jobPosition;
    }

    public function setJobPosition($jobPosition)
    {
        $this->jobPosition = $jobPosition;

        return $this;
    }
}
