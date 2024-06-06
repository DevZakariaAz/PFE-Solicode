<?php
$dbn = 'mysql:host=localhost;dbname=tangorocco_v1';
$user = 'root';
$pass = '';

try {
    $conn = new PDO($dbn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'failed ' . $e->getMessage();
}
?>
