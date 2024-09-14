<?php

class NavbarModel {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUserNavbar($roleId, $languageCode) {
        $isVisible = true;
        $stmt = $this->db->prepare("SELECT n.url, n.icon, t.label
                                    FROM bms_navbar_roles AS r
                                    INNER JOIN bms_navbar AS n ON r.navbar_id = n.id
                                    INNER JOIN bms_navbar_translations AS t ON n.id = t.navbar_id
                                    INNER JOIN bms_languages AS l ON l.id = t.language_id
                                    WHERE r.role_id = :roleId AND l.code = :languageCode AND n.is_visible = :isVisible ORDER BY n.display_order ASC;"
                                    );
        $stmt->bindParam(":roleId", $roleId);
        $stmt->bindParam(":languageCode", $languageCode);
        $stmt->bindParam(":isVisible", $isVisible);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }
}