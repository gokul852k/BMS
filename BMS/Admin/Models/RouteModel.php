<?php

class RouteModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getLanguage($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT bms_languages.id AS 'language_id', bms_languages.code AS 'language_code', bms_languages.name AS 'language_name' FROM `bms_company_languages` INNER JOIN bms_languages ON bms_company_languages.language_id = bms_languages.id WHERE bms_company_languages.company_id = :companyId AND bms_company_languages.is_active = :isActive ORDER BY bms_languages.id ASC");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function setRoute($companyId, $route) {
        $stmt = $this->db->prepare("INSERT INTO `bms_routes`(`company_id`, `route_name`) VALUES (:companyId, :route)");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("route", $route);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                // Get the last inserted ID
                $lastId = $this->db->lastInsertId();
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.',
                    'routeId' => $lastId
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

    public function setRouteTranslation($companyId, $routeId, $languageId, $route) {
        $stmt = $this->db->prepare("INSERT INTO `bms_route_translations`(`company_id`, `route_id`, `language_id`, `route_name`) VALUES (:companyId, :routeId, :languageId, :route)");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("routeId", $routeId);
        $stmt->bindParam("languageId", $languageId);
        $stmt->bindParam("route", $route);

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

    public function getRouteCardDetails($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT
                                    (SELECT COUNT(*) FROM bms_bus WHERE company_id=:companyId AND is_active=:isActive) AS 'total_bus',
                                    (SELECT COUNT(*) FROM bms_routes WHERE company_id=:companyId AND is_active=:isActive) AS 'total_routes',
                                    (SELECT COUNT(*) FROM bms_company_languages WHERE company_id=:companyId AND is_active=:isActive) AS 'language_support',
                                    (SELECT COUNT(*) FROM bms_bus WHERE company_id=:companyId AND bus_status=true AND is_active=:isActive) AS 'active_bus'
                                ");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getRoutes($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT id AS 'routeId', route_name AS 'routeName' FROM `bms_routes` WHERE company_id = :companyId AND is_active = :isActive");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getRoute($routeId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT bms_routes.id AS 'routeId', bms_languages.name AS 'language', bms_route_translations.id AS 'translationId', bms_route_translations.route_name AS 'routeName' FROM bms_routes INNER JOIN bms_route_translations ON bms_routes.id = bms_route_translations.route_id INNER JOIN bms_languages ON bms_route_translations.language_id = bms_languages.id WHERE bms_routes.id = :routeId AND bms_routes.is_active = :isActive ORDER BY bms_route_translations.language_id ASC");
        $stmt->bindParam("routeId", $routeId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function updateRoute($routeId, $route) {
        $stmt = $this->db->prepare("UPDATE `bms_routes` SET `route_name` = :route WHERE `id` = :routeId");
        $stmt->bindParam(":route", $route);
        $stmt->bindParam(":routeId", $routeId);

        return $stmt->execute() ? true : false;
    }

    public function updateRouteTranslation($translationId, $route) {
        $stmt = $this->db->prepare("UPDATE `bms_route_translations` SET `route_name` = :route WHERE `id` = :translationId");
        $stmt->bindParam(":route", $route);
        $stmt->bindParam(":translationId", $translationId);

        return $stmt->execute() ? true : false;
    }

    public function deleteRoute($routeId) {
        $is_active = false;
        $stmt = $this->db->prepare("UPDATE `bms_routes` SET `is_active` = :is_active WHERE `id` = :routeId");
        $stmt->bindParam(":is_active", $is_active);
        $stmt->bindParam(":routeId", $routeId);

        return $stmt->execute() ? true : false;
    }

    public function getRouteField($companyId, $languageCode) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT bms_routes.id AS 'routeId', bms_route_translations.route_name AS 'routeName' FROM bms_routes INNER JOIN bms_route_translations ON bms_routes.id = bms_route_translations.route_id INNER JOIN bms_languages ON bms_route_translations.language_id = bms_languages.id WHERE bms_languages.code = :languageCode AND bms_routes.is_active = :isActive AND bms_routes.company_id = :companyId ORDER BY bms_route_translations.language_id ASC");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("languageCode", $languageCode);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }
}