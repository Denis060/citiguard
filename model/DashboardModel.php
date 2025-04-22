<?php
class DashboardModel {
    public static function getTotalReports($conn) {
        $result = $conn->query("SELECT COUNT(*) AS total FROM reports");
        return $result->fetch_assoc()['total'];
    }

    public static function getPendingReports($conn) {
        $result = $conn->query("SELECT COUNT(*) AS total FROM reports WHERE status = 'Pending'");
        return $result->fetch_assoc()['total'];
    }

    public static function getReviewedReports($conn) {
        $result = $conn->query("SELECT COUNT(*) AS total FROM reports WHERE status = 'Reviewed'");
        return $result->fetch_assoc()['total'];
    }

    public static function getDeletedReports($conn) {
        $result = $conn->query("SELECT COUNT(*) AS total FROM reports WHERE deleted = 1");
        return $result->fetch_assoc()['total'];
    }

    public static function getTopLocation($conn) {
        $result = $conn->query("SELECT location, COUNT(*) AS total FROM reports GROUP BY location ORDER BY total DESC LIMIT 1");
        $row = $result->fetch_assoc();
        return $row ? $row['location'] : 'N/A';
    }

    public static function getTopComplaintType($conn) {
        $result = $conn->query("SELECT type, COUNT(*) AS total FROM reports GROUP BY type ORDER BY total DESC LIMIT 1");
        $row = $result->fetch_assoc();
        return $row ? $row['type'] : 'N/A';
    }
}
?>
