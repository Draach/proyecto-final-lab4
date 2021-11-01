<?php

namespace Models;

class JobPostulation
{
    private $postulationId; 
    private $studentId; 
    private $jobOfferId; 
    private $comment;
    private $CVarchive;
    private $active;

    public function __construct() {
        $this->active = true;
    }


    public function getPostulationId()
    {
        return $this->postulationId;
    }


    public function setPostulationId($postulationId)
    {
        $this->postulationId = $postulationId;

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

    public function getJobOfferId()
    {
        return $this->jobOfferId;
    }

    public function setJobOfferId($jobOfferId)
    {
        $this->jobOfferId = $jobOfferId;

        return $this;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCVarchive()
    {
        return $this->CVarchive;
    }

    public function setCVarchive($CVarchive)
    {
        $this->CVarchive = $CVarchive;

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
} 