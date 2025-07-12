<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['profil'] !== 'mpianatra') {
    header('Location: ../fidirana.php');
    exit;
}
$mpampifandray = new PDO('mysql:host=localhost;dbname=e-fanabe;charset=utf8', 'root', '');
$kilasy = $_SESSION['kilasy'];

$stmt = $mpampifandray->prepare("SELECT * FROM fandaharana WHERE kilasy = ? ORDER BY daty, ora_manomboka");
$stmt->execute([$kilasy]);
$fandaharana = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <title>Fandaharam-potoana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php
include("../loha.php");  // inclut le contenu du fichier header.php ici
?>
<?php
include("../sisiny_mpianatra.php");  // inclut le contenu du fichier header.php ici
?>
<main class="votoaty" id="votoaty">
<div class="container py-4">
    <h2><i class="fas fa-calendar-alt me-2"></i> Fandaharam-potoana (Kilasy <?= htmlspecialchars($kilasy) ?>)</h2>
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Daty</th>
                            <th>Ora</th>
                            <th>Lohateny</th>
                            <th>Mpampianatra</th>
                            <th>Efitrano</th>
                            <th>Karazana</th>
                            <th>Fanamarihana</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($fandaharana as $f): ?>
                        <tr>
                            <td><?= htmlspecialchars($f['daty']) ?></td>
                            <td><?= htmlspecialchars($f['ora_manomboka']) ?> - <?= htmlspecialchars($f['ora_mifarana']) ?></td>
                            <td><?= htmlspecialchars($f['lohateny']) ?></td>
                            <td>
                            <?php
                                // Affichage dynamique des noms des mpampianatra concernés
                                if (!empty($f['mpampianatra_ids'])) {
                                    $ids = explode(',', $f['mpampianatra_ids']);
                                    $placeholders = implode(',', array_fill(0, count($ids), '?'));
                                    $stmt2 = $mpampifandray->prepare("SELECT anarana, fanampiny FROM mpampianatra WHERE id IN ($placeholders)");
                                    $stmt2->execute($ids);
                                    $noms = [];
                                    while ($mp = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                        $noms[] = $mp['anarana'].' '.$mp['fanampiny'];
                                    }
                                    echo htmlspecialchars(implode(', ', $noms));
                                }
                            ?>
                            </td>
                            <td><?= htmlspecialchars($f['efitrano']) ?></td>
                            <td><?= htmlspecialchars($f['karazana']) ?></td>
                            <td><?= htmlspecialchars($f['fanamarihana']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($fandaharana)): ?>
                        <tr><td colspan="7" class="text-center">Tsy misy fandaharana amin'izao fotoana izao.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</main>
<?php
include("../tongony.php");  
?>
</body>
<script src="../script.js"></script>

</html>