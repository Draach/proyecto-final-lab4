<?php namespace Models;

class JobPosition {
    private $jobPositionId;
    private $careerId;
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

    public function getCareerId()
    {
        return $this->careerId;
    }

    public function setCareerId($careerId)
    {
        $this->careerId = $careerId;

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
?>