DELIMITER $$
DROP PROCEDURE IF EXISTS get_users_with_roles$$
CREATE PROCEDURE get_users_with_roles()
BEGIN
SELECT u.userId, u.email, u.roleId, u.studentId, u.active, r.name as roleName FROM joboffers.users u LEFT JOIN `role` r ON u.roleId = r.roleId;
END;
$$

CALL get_users_with_roles()