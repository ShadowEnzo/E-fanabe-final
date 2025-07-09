<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=e_fanabe;charset=utf8', 'root', '');

$id_mpianatra = $_SESSION['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fichier'])) {
    $id_devoir = $_POST['id_devoir'];
    $fichier = 'uploads/devoirs_rendus/'.uniqid().'_'.basename($_FILES['fichier']['name']);
    @mkdir('uploads/devoirs_rendus', 0777, true);
    move_uploaded_file($_FILES['fichier']['tmp_name'], $fichier);

    $stmt = $pdo->prepare("INSERT INTO devoirs_rendus (id_devoir, id_mpianatra, fichier, date_envoi) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$id_devoir, $id_mpianatra, $fichier]);
}
header('Location: taranja_manokana.php?matiere='.urlencode($_GET['matiere'] ?? ''));
exit;