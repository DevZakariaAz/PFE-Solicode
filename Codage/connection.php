<?php
$dbn = 'mysql:host=localhost;dbname=stagiaires';
$user = 'root';
$pass = '';

try {
    $DB = new PDO($dbn, $user, $pass);
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'failed ' . $e->getMessage();
}
?>