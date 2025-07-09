<?php
$mpampifandray = new PDO('mysql:host=localhost;dbname=e_fanabe;charset=utf8', 'root', '');
$id = $_GET['id'] ?? 0;
$stmt = $mpampifandray->prepare("DELETE FROM mpampianatra WHERE id = ?");
$stmt->execute([$id]);
header('Location: lisitra_mpampianatra.php');
exit;
?>