<?php

class ConductorModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getMailID($mail) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `username` FROM `users` WHERE username = :username AND is_active = :isActive");
        $stmt->bindParam(":username", $mail);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getConductor($conductorId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT * FROM `bms_conductors` WHERE `id` = :conductorId AND `is_active` = :isActive");
        $stmt->bindParam(":conductorId", $conductorId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getDriversCardDetails($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT
                                    (SELECT COUNT(*) FROM bms_drivers WHERE company_id=:companyId AND is_active=:isActive) AS 'total_drivers',
                                    (SELECT COUNT(*) FROM bms_drivers WHERE company_id=:companyId AND is_active=:isActive) AS 'active_drivers',
                                    (SELECT COUNT(*) FROM bms_drivers WHERE licence_expiry<CURRENT_DATE() AND company_id=:companyId AND is_active=:isActive) AS 'expired_licenses',
                                    (SELECT COUNT(*) FROM bms_drivers WHERE licence_expiry<DATE_ADD(CURDATE(), INTERVAL 3 MONTH) AND licence_expiry>CURRENT_DATE() AND company_id=:companyId AND is_active=:isActive) AS 'upcoming_expirations'
                                    ");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }
    public function getConductors($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT id, fullname, mail, mobile, district, state FROM bms_conductors WHERE company_id=:companyId AND is_active = :isActive");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function setConductorInUsers($username, $password, $companyId) {
        $stmt = $this->db->prepare("INSERT INTO `users`(`username`, `password`, `company_id`) VALUES (:username, :password, :companyId)");
        $stmt->bindParam("username", $username);
        $stmt->bindParam("password", $password);
        $stmt->bindParam("companyId", $companyId);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                // Get the last inserted ID
                $lastId = $this->db->lastInsertId();
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.',
                    'userId' => $lastId
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Insert failed.',
                    'error' => 'No reason'
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'Insert failed.',
                'error' => $stmt->errorInfo()
            ];
        }
    }

    public function setConductorInUserRole($userId, $roleId, $systemId) {
        $stmt = $this->db->prepare("INSERT INTO `user_roles`(`user_id`, `role_id`, `system_id`) VALUES (:userId, :roleId, :systemId)");
        $stmt->bindParam("userId", $userId);
        $stmt->bindParam("roleId", $roleId);
        $stmt->bindParam("systemId", $systemId);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Insert failed.',
                    'error' => 'No reason'
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'Insert failed.',
                'error' => $stmt->errorInfo()
            ];
        }
    }

    public function setConductor($userId, $companyId, $name, $mobile, $mail, $address, $state, $district, $pincode, $language, $conductorImage_path, $aadharNo, $aadharCard_path, $panNo, $panCard_path) {
        $stmt = $this->db->prepare("INSERT INTO `bms_conductors` (`user_id`, `company_id`, `fullname`, `mail`, `mobile`, `address`, `state`, `district`, `pincode`, `language`, `conductor_image_path`, `aadhar_no`, `aadhar_path`, `pan_no`, `pan_path`) VALUES (:userId, :companyId, :name, :mail, :mobile, :address, :state, :district, :pincode, :language, :conductorImage_path, :aadharNo, :aadharCard_path, :panNo, :panCard_path)");
        
        $stmt->bindParam("userId", $userId);
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("name", $name);
        $stmt->bindParam("mail", $mail);
        $stmt->bindParam("mobile", $mobile);
        $stmt->bindParam("address", $address);
        $stmt->bindParam("state", $state);
        $stmt->bindParam("district", $district);
        $stmt->bindParam("pincode", $pincode);
        $stmt->bindParam("language", $language);
        $stmt->bindParam("conductorImage_path", $conductorImage_path);
        $stmt->bindParam("aadharNo", $aadharNo);
        $stmt->bindParam("aadharCard_path", $aadharCard_path);
        $stmt->bindParam("panNo", $panNo);
        $stmt->bindParam("panCard_path", $panCard_path);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Insert failed.',
                    'error' => 'No reason'
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'Insert failed.',
                'error' => $stmt->errorInfo()
            ];
        }
    }

    function deleteUser($userId) {
        $stmt = $this->db->prepare("DELETE FROM `users` WHERE `id`=:userId");
        $stmt->bindParam("userId", $userId);
        return $stmt->execute();
    }

    function updateConductor($update_fields, $update_values) {
        $sql = "UPDATE bms_conductors SET ". implode(", ", $update_fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        if ($stmt->execute($update_values)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteConductor($conductorId) {
        $stmt = $this->db->prepare("DELETE FROM `bms_conductors` WHERE `id`=:conductorId");
        $stmt->bindParam("conductorId", $conductorId);
        return $stmt->execute();
    }

    public function getConductorField($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `id`, `fullname` FROM `bms_conductors` WHERE `company_id` = :companyId AND `is_active` = :isActive");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function updatePassword($userId, $hashPassword) {
        $stmt = $this->db->prepare("UPDATE `users` SET `password` = :hashPassword WHERE `id` = :userId");
        $stmt->bindParam(":hashPassword", $hashPassword);
        $stmt->bindParam(":userId", $userId);

        return $stmt->execute() ? true : false;
    }
}

