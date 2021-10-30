<?php

namespace Models;

class JobPostulation
{
    private $postulationId; 
    private $studentId; 
    private $jobOfferId; 
    private $comment;
    private $CVarchive;


    public function getPostulacionId()
    {
        return $this->postulacionId;
    }


    public function setPostulacionId($postulacionId)
    {
        $this->postulacionId = $postulacionId;

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

    public function getComentario()
    {
        return $this->comentario;
    }

    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getArchivoCV()
    {
        return $this->archivoCV;
    }

    public function setArchivoCV($archivoCV)
    {
        $this->archivoCV = $archivoCV;

        return $this;
    }
} 