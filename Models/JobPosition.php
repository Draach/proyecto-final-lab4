<?php

namespace Models;

class JobPosition
{
    private $jobPositionId;
    private $career;
    private $description;

    public function getJobPositionId()
    {
        return $this->jobPositionId;
    }

    public function setJobPositionId($jobPositionId)
    {
        $this->jobPositionId = $jobPositionId;

        return $this;
    }

    public function getCareer()
    {
        return $this->career;
    }

    public function setCareer($career)
    {
        $this->career = $career;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}
