USE joboffers;
DELIMITER $$
DROP PROCEDURE IF EXISTS GetPostulationsByJobOfferId$$
CREATE PROCEDURE GetPostulationsByJobOfferId(IN $jobOfferId INT)
BEGIN
SELECT jo.jobOfferId, c.name as company_name, jp.idjob_postulations, jp.studentId, jp.comment, jp.cvarchive FROM job_offers jo INNER JOIN job_postulations jp INNER JOIN companies c WHERE jo.jobOfferId = $jobOfferId AND jp.jobOfferId = $jobOfferId AND jp.Active = true AND c.companyId = jo.companyId;
END;
$$

CALL GetPostulationsByJobOfferId(2)