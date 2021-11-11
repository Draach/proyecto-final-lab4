USE joboffers;
DELIMITER $$
DROP PROCEDURE IF EXISTS get_postulations_by_student_id$$
CREATE PROCEDURE get_postulations_by_student_id(IN $studentId INT)
BEGIN
SELECT jp.idjob_postulations, jp.studentId, jp.comment, jp.cvarchive, jp.active as jp_active, jo.jobOfferId, jo.title, jo.createdAt, jo.expirationDate, jo.salary, jo.jobPositionId, jo.active as jo_active, c.companyId, c.name, c.email, c.phone, c.address, c.cuit, c.website, c.founded, c.status FROM job_postulations jp INNER JOIN job_offers jo INNER JOIN companies c WHERE jp.studentId = $studentId && jp.jobOfferId = jo.jobOfferId AND c.companyId = jo.companyId;
END;
$$

CALL get_postulations_by_student_id(2);