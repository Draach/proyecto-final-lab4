<?php

namespace Models;

class Role
{
    private $roleId;
    private $name;


    /**
     * Get the value of roleId
     */ 
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * Set the value of roleId
     *
     * @return  self
     */ 
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;

        return $this;
    }


    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}