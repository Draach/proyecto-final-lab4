USE joboffers;
DELIMITER $$
DROP PROCEDURE IF EXISTS GetAllJobOffers$$
CREATE PROCEDURE GetAllJobOffers()
BEGIN
SELECT jo.jobOfferId, jo.title, jo.createdAt, jo.expirationDate, jo.salary, jo.jobPositionId, jo.active, jo.companyId, c.name as companyName, c.email, c.phone, c.address, c.cuit, c.website, c.founded, c.status FROM joboffers.job_offers jo INNER JOIN joboffers.companies c WHERE c.companyId = jo.companyId;
END;
$$

CALL GetAllJobOffers