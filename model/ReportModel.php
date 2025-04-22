<?php

class ReportModel {

    // 🔄 Get all soft-deleted reports with optional filters
    public static function getDeletedReports($conn) {
        $conditions = ["r.deleted = 1"];
        $params = [];
        $types = "";

        if (!empty($_GET['id'])) {
            $conditions[] = "r.id LIKE ?";
            $params[] = "%" . $_GET['id'] . "%";
            $types .= "s";
        }

        if (!empty($_GET['type'])) {
            $conditions[] = "r.type LIKE ?";
            $params[] = "%" . $_GET['type'] . "%";
            $types .= "s";
        }

        if (!empty($_GET['location'])) {
            $conditions[] = "r.location LIKE ?";
            $params[] = "%" . $_GET['location'] . "%";
            $types .= "s";
        }

        if (!empty($_GET['from_date'])) {
            $conditions[] = "r.date >= ?";
            $params[] = $_GET['from_date'];
            $types .= "s";
        }

        if (!empty($_GET['to_date'])) {
            $conditions[] = "r.date <= ?";
            $params[] = $_GET['to_date'];
            $types .= "s";
        }

        $sql = "
            SELECT r.*, rg.name AS region_name, d.name AS district_name, c.name AS chiefdom_name
            FROM reports r
            LEFT JOIN regions rg ON r.region = rg.id
            LEFT JOIN districts d ON r.district = d.id
            LEFT JOIN chiefdoms c ON r.chiefdom = c.id
            WHERE " . implode(" AND ", $conditions) . "
            ORDER BY r.date DESC
        ";

        $stmt = $conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $reports = [];
        while ($row = $result->fetch_assoc()) {
            $reports[] = $row;
        }

        return $reports;
    }

    // ✅ Get a single report by its internal ID
    public static function getReportById($conn, $id) {
        $sql = "
            SELECT r.*, rg.name AS region_name, d.name AS district_name, c.name AS chiefdom_name
            FROM reports r
            LEFT JOIN regions rg ON r.region = rg.id
            LEFT JOIN districts d ON r.district = d.id
            LEFT JOIN chiefdoms c ON r.chiefdom = c.id
            WHERE r.id = ?
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // 🔄 Get all active (non-deleted) reports with filters and optional pagination
    public static function getAllReports($conn, $limit = null, $offset = null) {
        $conditions = ["r.deleted = 0"];
        $params = [];
        $types = "";

        if (!empty($_GET['id'])) {
            $conditions[] = "r.id LIKE ?";
            $params[] = "%" . $_GET['id'] . "%";
            $types .= "s";
        }

        if (!empty($_GET['type'])) {
            $conditions[] = "r.type LIKE ?";
            $params[] = "%" . $_GET['type'] . "%";
            $types .= "s";
        }

        if (!empty($_GET['region'])) {
            $conditions[] = "r.region = ?";
            $params[] = $_GET['region'];
            $types .= "i";
        }

        if (!empty($_GET['district'])) {
            $conditions[] = "r.district = ?";
            $params[] = $_GET['district'];
            $types .= "i";
        }

        if (!empty($_GET['chiefdom'])) {
            $conditions[] = "r.chiefdom = ?";
            $params[] = $_GET['chiefdom'];
            $types .= "i";
        }

        if (!empty($_GET['from_date'])) {
            $conditions[] = "r.date >= ?";
            $params[] = $_GET['from_date'];
            $types .= "s";
        }

        if (!empty($_GET['to_date'])) {
            $conditions[] = "r.date <= ?";
            $params[] = $_GET['to_date'];
            $types .= "s";
        }

        $sql = "
            SELECT r.*, rg.name AS region_name, d.name AS district_name, c.name AS chiefdom_name
            FROM reports r
            LEFT JOIN regions rg ON r.region = rg.id
            LEFT JOIN districts d ON r.district = d.id
            LEFT JOIN chiefdoms c ON r.chiefdom = c.id
            WHERE " . implode(" AND ", $conditions) . "
            ORDER BY r.date DESC
        ";

        if ($limit !== null && $offset !== null) {
            $sql .= " LIMIT ? OFFSET ?";
            $types .= "ii";
            $params[] = $limit;
            $params[] = $offset;
        }

        $stmt = $conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $reports = [];
        while ($row = $result->fetch_assoc()) {
            $reports[] = $row;
        }

        return $reports;
    }

    // 📊 Get total number of matching reports (for pagination)
    public static function getTotalCount($conn) {
        $sql = "SELECT COUNT(*) as total FROM reports WHERE deleted = 0";
        $result = $conn->query($sql);
        return $result->fetch_assoc()['total'];
    }
}
?>