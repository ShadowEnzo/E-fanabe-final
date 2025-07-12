<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['profil'] !== 'mpianatra') {
    header('Location: ../fidirana.php');
    exit;
}
$pdo = new PDO('mysql:host=localhost;dbname=e-fanabe;charset=utf8', 'root', '');
$classe = $_SESSION['kilasy'];
$id_mpianatra = $_SESSION['id'];

// Devoirs non rendus par l'élève
$stmt = $pdo->prepare("
    SELECT d.*, 'devoir' as type_fampiasana FROM devoirs d
    WHERE d.classe=?
      AND NOT EXISTS (
        SELECT 1 FROM devoirs_rendus dr
        WHERE dr.id_devoir = d.id AND dr.id_mpianatra = ?
      )
    ORDER BY d.date_limite DESC
");
$stmt->execute([$classe, $id_mpianatra]);
$devoirs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Leçons (rakitra) pour la classe
$stmt = $pdo->prepare("SELECT r.*, 'rakitra' as type_fampiasana FROM rakitra r WHERE r.classe=? ORDER BY r.date_pub DESC");
$stmt->execute([$classe]);
$lecons = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fusionner les deux listes
$fampiasana = array_merge($devoirs, $lecons);

// Tri par date (date_limite pour devoir, date_pub pour rakitra). NULL en dernier.
usort($fampiasana, function($a, $b) {
    $dateA = $a['type_fampiasana'] === 'devoir' ? ($a['date_limite'] ?? '') : ($a['date_pub'] ?? '');
    $dateB = $b['type_fampiasana'] === 'devoir' ? ($b['date_limite'] ?? '') : ($b['date_pub'] ?? '');
    if ($dateA === '' && $dateB === '') return 0;
    if ($dateA === '') return 1;
    if ($dateB === '') return -1;
    return strcmp($dateB, $dateA);
});
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <title>Fampiasana & Lesona miandry</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include("../loha.php"); include("../sisiny_mpianatra.php"); ?>
<main class="votoaty" id="votoaty">
<div class="container py-4">
    <h2>Ireo fampiasana & lesona miandry (Kilasy <?= htmlspecialchars($classe ?? '') ?>)</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Karazany</th>
                <th>Taranja</th>
                <th>Lohateny</th>
                <th>Daty farany fandefasana</th>
                <th>Hetsika</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($fampiasana as $f): ?>
            <tr>
                <td>
                    <?php if(($f['type_fampiasana'] ?? '') === 'devoir'): ?>
                        <span class="badge bg-warning text-dark">Fampiasana</span>
                    <?php else: ?>
                        <span class="badge bg-info text-dark">Lesona</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php
                        $matiere = $f['matiere'] ?? '';
                        if ($f['type_fampiasana'] === 'rakitra' && !$matiere) {
                            echo "<span class='text-danger'>Tsy misy taraanja</span>";
                        } else {
                            echo htmlspecialchars($matiere);
                        }
                    ?>
                </td>
                <td><?= htmlspecialchars($f['titre'] ?? '') ?></td>
                <td>
                    <?php if(($f['type_fampiasana'] ?? '') === 'devoir'): ?>
                        <?= htmlspecialchars($f['date_limite'] ?? '') ?>
                    <?php else: ?>
                        <?= htmlspecialchars($f['date_pub'] ?? '') ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if(!empty($f['fichier'])): ?>
                        <a href="<?= htmlspecialchars($f['fichier']) ?>" class="btn btn-sm btn-info" target="_blank">Alaina</a>
                    <?php endif; ?>
                    <?php if(($f['type_fampiasana'] ?? '') === 'devoir'): ?>
                        <a href="taranja_manokana.php?matiere=<?= urlencode($f['matiere'] ?? '') ?>" class="btn btn-sm btn-success ms-2">Alefa</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(!$fampiasana): ?>
            <tr><td colspan="5" class="text-muted">Tsy misy fampiasana na lesona miandry.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="alert alert-info mt-3">
        <b>NB :</b> Raha misy lesona eto <span class="text-danger">tsy misy taranja</span>,dia tsy ho hita n'aiza n'aiza izany. Manontania ny mpitantana
</div>
</main>
<?php include("../tongony.php"); ?>
</body>
<script src="../script.js"></script>
</html>