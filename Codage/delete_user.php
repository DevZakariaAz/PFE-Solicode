<?php
session_start();
include "connection.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

if (isset($_GET['id'])) {
    $userid = intval($_GET['id']);
    $query = "DELETE FROM user WHERE userid = :userid";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userid', $userid);
    $stmt->execute();
}

header("Location: admin_dashboard.php");
exit;
?>
