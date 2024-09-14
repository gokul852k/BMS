<?php

class SessionModel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    public function getUser($token) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT * FROM `users` WHERE token = :token AND `is_active` = :isActive");
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getUserDetails($userId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT id, fullname, mail, mobile FROM bms_drivers WHERE user_id = :userId AND is_active = :isActive");
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    
    }

    public function getUserRoleFromAuthentication($userId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT roles.role_name FROM user_roles INNER JOIN roles ON user_roles.role_id = roles.id WHERE user_roles.user_id = :userId AND user_roles.is_active = :isActive");
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getUserRoleIdFromBMS($userRole) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT * FROM `bms_roles` WHERE role_name = :userRole AND is_active = :isActive");
        $stmt->bindParam(":userRole", $userRole);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getDriver($userId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `id` AS 'driverId' FROM `bms_drivers` WHERE `user_id` = :userId AND `is_active` = :isActive");
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

}

?>
