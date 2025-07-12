<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['profil'] !== 'mpianatra') {
    header('Location: ../fidirana.php');
    exit;
}
$pdo = new PDO('mysql:host=localhost;dbname=e-fanabe;charset=utf8', 'root', '');
$id_mpianatra = $_SESSION['id'];

$stmt = $pdo->prepare("SELECT * FROM notes WHERE id_mpianatra=? ORDER BY matiere, date_note DESC");
$stmt->execute([$id_mpianatra]);
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <title>Ireo naoty rehetra</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include("../loha.php"); ?>
    <?php include("../sisiny_mpianatra.php"); ?>
<main class="votoaty" id="votoaty">
<div class="container py-4">
    <h2>Ireo naoty rehetra</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Taranja</th><th>Naoty</th><th>Daty</th><th>Karazany</th><th>Fanamarihana</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($notes as $n): ?>
            <tr>
                <td><?= htmlspecialchars($n['matiere']) ?></td>
                <td><?= htmlspecialchars($n['note']) ?></td>
                <td><?= htmlspecialchars($n['date_note']) ?></td>
                <td><?= htmlspecialchars($n['type_note']) ?></td>
                <td><?= htmlspecialchars($n['appreciation']) ?></td>
            </tr>
            <?php endforeach; ?>
            <?php if(!$notes): ?>
            <tr><td colspan="5" class="text-muted">Tsy misy naoty.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</main>
<?php include("../tongony.php"); ?>
</body>
<script src="../script.js"></script>
</html>