<?php

namespace Models;

class Company
{
        private $companyId;
        private $name;
        private $email;
        private $phone;
        private $address;
        private $cuit;
        private $website;
        private $founded;
        private $status;

        public function __construct()
        {
                $this->status = true;
        }

        public function getCompanyId()
        {
                return $this->companyId;
        }

        public function setCompanyId($companyId)
        {
                $this->companyId = $companyId;

                return $this;
        }

        public function getName()
        {
                return $this->name;
        }

        public function setName($name)
        {
                $this->name = $name;

                return $this;
        }

        public function getEmail()
        {
                return $this->email;
        }

        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }

        public function getPhone()
        {
                return $this->phone;
        }

        public function setPhone($phone)
        {
                $this->phone = $phone;

                return $this;
        }

        public function getAddress()
        {
                return $this->address;
        }

        public function setAddress($address)
        {
                $this->address = $address;

                return $this;
        }

        public function getCuit()
        {
                return $this->cuit;
        }

        public function setCuit($cuit)
        {
                $this->cuit = $cuit;

                return $this;
        }

        public function getWebsite()
        {
                return $this->website;
        }

        public function setWebsite($website)
        {
                $this->website = $website;

                return $this;
        }

        public function getFounded()
        {
                return $this->founded;
        }

        public function setFounded($founded)
        {
                $this->founded = $founded;

                return $this;
        }

        public function getStatus()
        {
                return $this->status;
        }

        public function setStatus($status)
        {
                $this->status = $status;

                return $this;
        }
}
