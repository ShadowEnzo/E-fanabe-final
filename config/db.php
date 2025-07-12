<?php
$host = "localhost";
$dbname = "e-fanabe";
$user = "root";
$pass = "";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("Erreur connexion : " . $e->getMessage());
}
?>