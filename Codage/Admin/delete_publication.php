<?php
session_start();
include "../connection.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

if (isset($_GET['id'])) {
    $publicationid = intval($_GET['id']);
    $query = "DELETE FROM publication WHERE publicationid = :publicationid";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':publicationid', $publicationid);
    $stmt->execute();
}

header("Location: admin_dashboard.php");
exit;
?>
