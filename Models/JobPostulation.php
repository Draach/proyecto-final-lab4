<?php

namespace Models;

class JobPostulation
{
    private $postulationId; 
    private $jobOffer;
    private $student;
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

    public function getJobOffer()
    {
        return $this->jobOffer;
    }

    public function setJobOffer($jobOffer)
    {
        $this->jobOffer = $jobOffer;

        return $this;
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function setStudent($student)
    {
        $this->student = $student;

        return $this;
    }
} 