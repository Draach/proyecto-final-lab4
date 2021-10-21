<?php namespace DAO;

    use \Exception as Exception;
    use DAO\ICompanyDAO as ICompanyDAO;
    use Models\Company as Company;
    use DAO\Connection as Connection;

    class CompanyDAO implements ICompanyDAO {
        private $connection;
        private $tableName = "companies";

        public function Add(Company $company){
            try
            {
                
                $query = "INSERT INTO ".$this->tableName." (name, email, phone, address, cuit, website, founded, status) VALUES (:name, :email, :phone, :address, :cuit, :website, :founded, :status);";
                
                $parameters["name"] = $company->getName();
                $parameters["email"] = $company->getEmail();
                $parameters["phone"] = $company->getPhone();
                $parameters["address"] = $company->getAddress();
                $parameters["cuit"] = $company->getCuit();
                $parameters["website"] = $company->getWebsite();
                $parameters["founded"] = $company->getFounded();
                $parameters["status"] = $company->getStatus();

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch(Exception $ex)
            {             
                
                throw $ex;
            }
        }

        public function GetAll(){
            try
            {
                $companiesList = array();

                $query = "SELECT * FROM ".$this->tableName;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                foreach ($resultSet as $row)
                {              
                    $company = new Company();
                    $company->setCompanyId($row["companyId"]);
                    $company->setName($row["name"]);
                    $company->setEmail($row["email"]);
                    $company->setPhone($row["phone"]);
                    $company->setAddress($row["address"]);
                    $company->setCuit($row["cuit"]);
                    $company->setWebsite($row["website"]);
                    $company->setFounded($row["founded"]);
                    $company->setStatus($row["status"]);                  

                    array_push($companiesList, $company);
                }
                return $companiesList;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }

        public function Delete($number) {
            try
            {
                
                $query = "UPDATE ".$this->tableName." SET `status` = false WHERE `companyId` = :number";
                
                $parameters["number"] = $number;             

                $this->connection = Connection::GetInstance();

                return $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch(Exception $ex)
            {             
                
                throw $ex;
            }
        }
    }

?>