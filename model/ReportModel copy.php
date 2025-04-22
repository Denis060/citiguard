<?php

class ReportModel {
    public static function getDeletedReports($conn) {
        $conditions = ["deleted = 1"];
        $params = [];
        $types = "";

        if (!empty($_GET['id'])) {
            $conditions[] = "id LIKE ?";
            $params[] = "%" . $_GET['id'] . "%";
            $types .= "s";
        }

        if (!empty($_GET['type'])) {
            $conditions[] = "type LIKE ?";
            $params[] = "%" . $_GET['type'] . "%";
            $types .= "s";
        }

        if (!empty($_GET['location'])) {
            $conditions[] = "location LIKE ?";
            $params[] = "%" . $_GET['location'] . "%";
            $types .= "s";
        }

        if (!empty($_GET['from_date'])) {
            $conditions[] = "date >= ?";
            $params[] = $_GET['from_date'];
            $types .= "s";
        }

        if (!empty($_GET['to_date'])) {
            $conditions[] = "date <= ?";
            $params[] = $_GET['to_date'];
            $types .= "s";
        }

        $sql = "SELECT * FROM reports WHERE " . implode(" AND ", $conditions) . " ORDER BY date DESC";
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

    // ✅ Add this new method
    public static function getReportById($conn, $id) {
        $sql = "SELECT * FROM reports WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id); // Use "s" if ID is a string
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }


    public static function getAllReports($conn,  $limit = null, $offset = null) {
        $conditions = ["deleted = 0"];
        $params = [];
        $types = "";

        if (!empty($_GET['id'])) {
            $conditions[] = "id LIKE ?";
            $params[] = "%" . $_GET['id'] . "%";
            $types .= "s";
        }

        if (!empty($_GET['type'])) {
            $conditions[] = "type LIKE ?";
            $params[] = "%" . $_GET['type'] . "%";
            $types .= "s";
        }

        if (!empty($_GET['location'])) {
            $conditions[] = "location LIKE ?";
            $params[] = "%" . $_GET['location'] . "%";
            $types .= "s";
        }

        if (!empty($_GET['from_date'])) {
            $conditions[] = "date >= ?";
            $params[] = $_GET['from_date'];
            $types .= "s";
        }

        if (!empty($_GET['to_date'])) {
            $conditions[] = "date <= ?";
            $params[] = $_GET['to_date'];
            $types .= "s";
        }

        $sql = "SELECT * FROM reports WHERE " . implode(" AND ", $conditions) . " ORDER BY date DESC";
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
}
?>
