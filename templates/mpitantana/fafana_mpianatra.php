<?php
$mpampifandray = new PDO('mysql:host=localhost;dbname=e-fanabe;charset=utf8', 'root', '');
$id = $_GET['id'] ?? 0;
$stmt = $mpampifandray->prepare("DELETE FROM mpianatra WHERE id = ?");
$stmt->execute([$id]);
header('Location: lisitra_mpianatra.php');
exit;
?>