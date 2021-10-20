<?php namespace Models;

    class Student extends User {
        private $studentId;
        private $careerId;
        private $fileNumber;
        private $gender;
        private $birthDate;
        private $email;
        private $phoneNumber;
        private $active;

        public function getStudentId()
        {
                return $this->studentId;
        }

   
        public function setStudentId($studentId)
        {
                $this->studentId = $studentId;

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

        public function getFileNumber()
        {
                return $this->fileNumber;
        }


        public function setFileNumber($fileNumber)
        {
                $this->fileNumber = $fileNumber;

                return $this;
        }

  
        public function getGender()
        {
                return $this->gender;
        }


        public function setGender($gender)
        {
                $this->gender = $gender;

                return $this;
        }


        public function getBirthDate()
        {
                return $this->birthDate;
        }


        public function setBirthDate($birthDate)
        {
                $this->birthDate = $birthDate;

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

   
        public function getPhoneNumber()
        {
                return $this->phoneNumber;
        }


        public function setPhoneNumber($phoneNumber)
        {
                $this->phoneNumber = $phoneNumber;

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
?>